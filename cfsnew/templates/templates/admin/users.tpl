{include file='admin/header.tpl'}
<link href="{$BASE_URL}cfs/css/demo_page.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="{$BASE_URL}cfs/css/demo_table.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
{literal}
<style>
.suggestionsBox {
max-height: 500px;
overflow-y: scroll;
z-index: 10;
min-width: 256px;
margin-left: 10px !important;
}
.suggestionList ul
{
    padding: 0 !important; 
    }
.suggestionList ul li{
color: #fff;    
}
</style>
{/literal}
<body>
{if $groupid>0 and $groupid!=""}
<form  method="post" name="sortlist" id="sortlist" >
    <input type="hidden" name="page" value="{$Page}" />
{else}
    <form  method="post" name="sortlist" id="sortlist" action="users.php">        
{/if}    
  <input type="hidden" name="sortby" value="{$sortby}" />
  <input type="hidden" name="order" value="{$order}" />
  
</form>
    
    
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />
</form>
<form  method="post" name="addformspringform1" id="addformspringform1">
  <input type="hidden" name="op1" />
  <input type="hidden" name="extra1" />
  <input type="hidden" name="status1" />
  <input type="hidden" name="edstatus1" />
</form>
<div class="container">

      <div class="content">
      
		
        <div class="page-header">
            <h1 style="width:60%"> Registered User(s) </h1>
          <div id="suggest" style="float: right;margin-top: -3%;">   
         <input type="text" value="{if $UserList[0].G_Name!="" and $groupid>0}{$UserList[0].G_Name}{/if}" name="groupname" id="groupname" onkeyup="suggestgroupname(this.value);" onblur="fillgroupname();" class=""  autocomplete=off placeholder="Group Name"  style="height: 24px;margin-left: 10px;float: right;margin-top: -4%;"/>
          <div class="suggestionsBox" id="groupnamesuggestions" style="display: none;margin-top: 10%;">
				  <div class="suggestionList" id="groupnamesuggestionsList"> &nbsp; </div>
          </div>
          </div>
          <a href="" id="groupfilterbyid"></a>
          <form action="users.php" method="get" id="" name="">
                <input type="hidden" name="groupid" value="{$groupid}" id="Groupid">    
            <!--<select  id="answer[Group]"  name="groupid" class="" forError="Group" onchange="this.form.submit()" style="float: right;margin-top: -4%;"/>
            <option value="">Select Group</option>
                          {html_options options=$grouplist selected=$groupid}	
            </select>-->
            
            </form>
            
        </div>
 <div class="row">
     
            <a href="adduser.php{if $groupid}?groupid={$groupid} {/if}" style="float: right;margin:2% 0;font-weight: bold;font-size: 15px;padding-top: 8px;">Add User</a> 
            
          <div id="suggest">
              <form action="users.php" method="get">
                  <input type="text" size="25" value="{if $usernamesuggest}{$usernamesuggest}{/if}" name="usernamesuggest" id="usernamesuggest" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off placeholder="User Name"  style="height:24px;margin-left: 10px;" required/>&nbsp;&nbsp;
                                <input type="submit" value="Search">
                                {if $usernamesuggest} <input type="button" value="Show all" onclick="window.location.href='users.php';"> {/if}
				<div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
             </form>                   
	    </div>
            
          <div  style="clear:both">
           
    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete?');">      
	<table border="1" cellspacing="0" cellpadding="0" id="example">
        <thead>
          <tr valign="top">
              <th width="8%"> <input type="checkbox" name="sltalluser" value="1" id="sltalluser" style="float:left; margin-top: 1px"> <span style="float: right;">All</span></th>
            <th width="10%">ID</th>
            <th width="30%"><a onclick="sortload{$usernameclicksort};"> <span style="float:left;color:#000">User Name</span> <img src="images/sort.gif"></a></th>
		    <th width="20%">First Name</th>
                    <th width="20%"> <a onclick="sortload{$groupnameclicksort};"> <span style="float:left;color:#000">Group Name</span> <img src="images/sort.gif"></a></th>
            <th width="20%">Added Date </th>
			<th>Edit</th>
			<th>Delete</th>
			<th>Permission</th> 
          </tr>
        </thead>
        <tbody>
          {section name=i loop=$UserList}
		  <tr>
            <td><input type="checkbox" name="dlt_userid[]" value="{$UserList[i].user_id}" class="sltusers"></td>
            <td>   {$UserList[i].user_id}</td>
            <td>{$UserList[i].username}</td>
		    <td>{$UserList[i].firstname}</td>
                    <td>{$UserList[i].G_Name}</td>
            <td>{$UserList[i].Added_Date}</td>
            <td width="3%" align="center"><a href="edituser.php?uid={$UserList[i].user_id}"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>
            <td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg1('delete','{$UserList[i].user_id}');" alt="delete" title="delete"/></td>
			<td width="3%">
		{if $UserList[i].usr_flag neq "0"}
			<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus1('changestatus','{$UserList[i].user_id}','Disable');"  style="cursor:pointer;"/>
		{else}
			<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus1('changestatus','{$UserList[i].user_id}','Enable');"  style="cursor:pointer;"/>
		{/if}	
			</td>
          </tr>
		  		  
		  {/section}
          
                  
                  
                  <tr><td colspan="9"><input type="Submit" value="Delete" id="deleteuserbtn" style="display:none" ></td></tr>        
          <tr>
              
  <td  colspan="9" style="color:#000000; padding-left:390px;padding-top:15px;" align="right">
		{if $pages_New.first=="0" and $pages_New.next=="0"}
<tr><td colspan="9">&nbsp;</td></tr>
		{else}

		{if $pages_New.first}<a href="{$pages_New.link}{$pages_New.first}" style="color:#000000;" >first</a>{else}first&nbsp;{/if} |

		{if $pages_New.first}<a href="{$pages_New.link}{$pages_New.previous}" style="color:#000000;">&lt; previous</a>{else} &lt;   
		previous{/if} |

		{if $pages_New.next}<a href="{$pages_New.link}{$pages_New.next}" style="color:#000000;">next &gt;</a>{else} next &gt;&nbsp;	{/if} |

		{if $pages_New.last}<a href="{$pages_New.link}{$pages_New.last}" style="color:#000000;">last</a>{else}&nbsp;last{/if}

		{/if}
</td></tr>
        
        </tbody>
      </table>
    </form>
          </div>          
        </div>
     </div>
</div> 
      <footer>
          <p style="text-align: center;">&copy; Company 2011</p>
      </footer>
    </div>
</body>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
{literal}
<script  type="text/javascript" language="javascript1.2">

jQuery.noConflict();

function suggest(inputString){
		                 
		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
                        jQuery('#cid').val('');
		} else if(inputString.length > 2) {
		jQuery('#usernamesuggest').addClass('load');
			jQuery.post("ajaxcheckusername.php", {usernamesuggest: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions').fadeIn();
					jQuery('#suggestionsList').html(data);
					jQuery('#usernamesuggest').removeClass('load');
				}
			});
		}
}
function fill(thisValue) {
        jQuery('#usernamesuggest').val(thisValue);
        setTimeout(jQuery('#suggestions').fadeOut(), 300);
       
        //jQuery('#suggestions').hide;
}

function suggestgroupname(inputString){
		                 
		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
                        jQuery('#cid').val('');
		} else if(inputString.length > 2) {
		jQuery('#groupname').addClass('load');
			jQuery.post("ajaxcheckgroupname.php", {groupnamesuggest: ""+inputString+"", redirect:'redirect'}, function(data){
				if(data.length >0) {
					jQuery('#groupnamesuggestions').fadeIn();
					jQuery('#groupnamesuggestionsList').html(data);
					jQuery('#groupname').removeClass('load');
				}
			});
		}
}
function fillgroupname(thisValue) {
        jQuery('#groupname').val(thisValue);
        setTimeout(jQuery('#groupnamesuggestions').fadeOut(), 300);
       
        //jQuery('#suggestions').hide;
}

function filterredirect(thisid) {
		jQuery('#Groupid').val(thisid);
		setTimeout(jQuery('#groupnamesuggestions').fadeOut(), 300);
                if(thisid > 0){
                    window.location.href='users.php?groupid='+thisid;
                 
                }
                   
	}






function deleteReg(op,extra)
{	if (confirm("Are you sure you want to delete? ")) {
		
	document.addformspringform.op.value=op;
	document.addformspringform.extra.value=extra;
	document.addformspringform.submit();

    } else {
       document.addformspringform.op.value=op;
    }
}

function ChangeStatus(op,status,msg)
{	if (confirm("Are you sure you want to "+msg)) {
		
	document.addformspringform.op.value=op;
	document.addformspringform.status.value=status;
	document.addformspringform.edstatus.value=msg;
	document.addformspringform.submit();

    } else {
       document.addformspringform.op.value=op;
    }
}
function deleteReg1(op1,extra1)
{	if (confirm("Are you sure you want to delete? ")) {
		
	document.addformspringform1.op1.value=op1;
	document.addformspringform1.extra1.value=extra1;
	document.addformspringform1.submit();

    } else {
       document.addformspringform1.op1.value=op;
    }
}

function ChangeStatus1(op1,status1,msg1)
{	if (confirm("Are you sure you want to "+msg1)) {
		
	document.addformspringform1.op1.value=op1;
	document.addformspringform1.status1.value=status1;
	document.addformspringform1.edstatus1.value=msg1;
	document.addformspringform1.submit();

    } else {
       document.addformspringform1.op1.value=op1;
    }
}

function sortload(name,order){
        document.sortlist.sortby.value=name;
	document.sortlist.order.value=order;
	document.sortlist.submit();
}  
    
</script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="{/literal}{$smarty.const.BASE_URL}{literal}cfs/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{/literal}{$smarty.const.BASE_URL}{literal}cfs/js/jquery.dataTables.min.js"></script>

<script type='text/javascript' src='//code.jquery.com/jquery-1.9.1.js'></script>

<script type="text/javascript" language="javascript1.2">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		jQuery('#example').dataTable({
					"sPaginationType": "full_numbers"
				});
                                
                                
                              
		
	});


$(document).ready(function() {
  $('#sltalluser').click(function(event) {  //on click 
               
                 if(this.checked) { // check select status
                     $("#deleteuserbtn").show();
                     $('.sltusers').each(function() { //loop through each checkbox
                         this.checked = true;  //select all checkboxes with class "checkbox1"               
                     });
                 }else{
                     $("#deleteuserbtn").hide();
                     $('.sltusers').each(function() { //loop through each checkbox
                         this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                     });         
                 }
             });
             
             
             
  $('.sltusers').click(function(event) {  //on click 
                      
                      var sltuserscout=0;
                      $('.sltusers').each(function() { //loop through each checkbox
                          if(this.checked) { 
                              sltuserscout++;
                          }              
                     });
                     
                     
                     if(sltuserscout>0) {$("#deleteuserbtn").show(); }
                     else {$("#deleteuserbtn").hide(); }
                     
                 
             });
             
             
});
    
  

</script>
{/literal}
