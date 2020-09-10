{include file='admin/header.tpl'}
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
{literal}
    
<script  type="text/javascript" language="javascript1.2">

jQuery.noConflict();

function suggest(inputString){
		
                var searchby = jQuery('#searchby').val();
                     
                     if(searchby==0) { var searchbystring = 'FCompanyName';}
                     else if(searchby==1) { var searchbystring = 'CIN';}
        
		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
                        jQuery('#cid').val('');
		} else if(inputString.length > 2) {
		jQuery('#searchname').addClass('load');
			jQuery.post("autosuggest_cname_cin.php", {queryString: ""+inputString+"", searchby:""+searchbystring+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions').fadeIn();
					jQuery('#suggestionsList').html(data);
					jQuery('#searchname').removeClass('load');
				}
			});
		}
}
function fill(thisValue) {
      if(thisValue){
        jQuery('#searchname').val(thisValue);    
        }
        
        setTimeout(jQuery('#suggestions').fadeOut(), 300);
       
        //jQuery('#suggestions').hide;
}
function clearsearch(){
    jQuery('#searchname').val('');  
    setTimeout(jQuery('#suggestions').fadeOut(), 300);
}
</script>
<script  type="text/javascript" language="javascript1.2">
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

</script>
<style>
    
.suggestionsBox {
max-height: 500px;
overflow-y: scroll;
z-index: 10;
min-width: 305px;
margin-left: 0px !important;
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
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />
</form>
<div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Company Profile </h1><a href="addcprofile.php" style="float: right;margin-top: -34px;">Add Company Profile</a>
        </div>
          <div id="suggest" style="width:500px;float:left; position: relative;">
            <form action="pmanagement.php" method="get" id="search">
                <input type="text" placeholder="Search By " name="searchname" id="searchname" value="{if $searchname}{$searchname}{/if}" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off style="height: 24px; padding-right: 90px;"   required>
                <select style="width: 85px; top:3px;left:217px; position:absolute" id="searchby" name="searchby" onchange="clearsearch();">
                    <option value="0" {if $searchby eq '0' } selected {/if}>Company</option>
                    <option value="1" {if $searchby eq '1'} selected {/if}>CIN</option>
                </select>
                <input type="submit" value="Search">
                {if $searchname} <input type="button" value="Show all" onclick="window.location.href='pmanagement.php';"> {/if}
                <div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
                
             </form>                   
	    </div>
          
                <div id="alphaPagination" style="float:right;margin-top: 1%;">
                        {section name=i loop=$alphaletter}
                                {if $setalphaletter==$alphaletter[i]}
                                    <a href="pmanagement.php?pag={$alphaletter[i]}"> <span style="text-decoration: underline;font-weight: bold;">{$alphaletter[i]}</span></a>	
                                {else}
                                <a href="pmanagement.php?pag={$alphaletter[i]}"> {$alphaletter[i]}</a>	
                                {/if}
                        {/section}
                </div><br><br>
         
          <div class="row" style="clear:both; margin-top: 1%">
          <div style="margin-left: 2%;">
           
			<table class="condensed-table">
        <thead>
          <tr>
            <th width="10%">ID</th>
            <th width="33%">Company Name</th>
            <th width="33%">CIN</th>
            <th width="31%">Added Date </th>
            <th colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
          {section name=i loop=$CProfileList}
		  <tr>
            <th>{$CProfileList[i].Company_Id}</th>
            <td>{$CProfileList[i].FCompanyName}</td>
            <td>{$CProfileList[i].CIN}</td>
            <td>{$CProfileList[i].Added_Date}</td>
            <td width="3%" align="center"><a href="editcprofile.php?cpid={$CProfileList[i].Company_Id}"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>
            {if $Usr_Type neq 2}<td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','{$CProfileList[i].Company_Id}');" alt="delete" title="delete"/></td>
        		<td width="3%">
        		{if $CProfileList[i].Profile_Flag eq "1"}
        			<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','{$CProfileList[i].Company_Id}','Disable');"  style="cursor:pointer;"/>
        		{else}
        			<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','{$CProfileList[i].Company_Id}','Enable');"  style="cursor:pointer;"/>
        		{/if}	
        		</td>{/if}
          </tr>
		  {sectionelse}
			<tr>
				<td colspan="">&nbsp;</td>
				<td colspan="3" align="center">No Data Found !</td>
				<td colspan="">&nbsp;</td>
			</tr>		  		  
		  {/section}
  <tr>
  <td  colspan="8" style="color:#000000; padding-left:390px;padding-top:15px;" align="right">
		{if $pages_New.first=="0" and $pages_New.next=="0"}
<tr><td colspan="8">&nbsp;</td></tr>
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
     {if $Usr_Type neq 2}
        <a href='companyexport.php' style="float: right;"><input type="button" value="Export"></a>
        <a href='companynaicsexport.php' style="float: right; margin-right: 10px;"><input type="button" value="Export with NAICS"></a>
     {/if}
          </div>          
        </div>
      </div>

      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
</body>