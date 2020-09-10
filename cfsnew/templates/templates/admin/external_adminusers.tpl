{include file='admin/header.tpl'}
<link href="{$smarty.const.BASE_URL}cfs/css/demo_page.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="{$smarty.const.BASE_URL}cfs/css/demo_table.css" rel="stylesheet" type="text/css" media="screen"/>
{literal}
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
</script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="{/literal}{$smarty.const.BASE_URL}{literal}cfs/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{/literal}{$smarty.const.BASE_URL}{literal}cfs/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript1.2">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		jQuery('#example').dataTable({
					"sPaginationType": "full_numbers"
				});
		
	})
</script>
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/*.slider-bg {
	height:472px;
	position:absolute;
	width:980px;
	left: 155px;
	top: -39px;
	z-index:1000;
}*/
ul#primary-nav {
	float:left;
	height:75px;
	left:225px;
	position:absolute;
	top:57px;
	width: 746px;
}

ul#primary-nav {
margin:0; padding:0;
}

ul#primary-nav li {display:block; float:left; margin-right:22px;} 

ul#primary-nav li.home:hover{background: url(images/homehover.png) left top; width:77px; height:50px;}
ul#primary-nav li.aboutus:hover{background: url(images/abouthover.png) left top; width:114px; height:50px;}
ul#primary-nav li.services:hover{background: url(images/serviceshover.png) left top; width:114px; height:50px;}
ul#primary-nav li.contactus:hover{background: url(images/contactushover.png) left top; width:134px; height:50px;}

ul#primary-nav li.home a
{
background:url(images/home.png) no-repeat;
line-height:64px;
padding:19px 38px;
}

ul#primary-nav li.aboutus a
{
background:url(images/aboutus.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.services a
{
background:url(images/services.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.contactus a
{
background:url(images/contactus.png) no-repeat;
line-height:64px;
padding:19px 67px;
}

ul#primary-nav li a{
height:19px;
width:auto;
}
.contentbg
{
height:auto;
position:relative;
}
.content
{
width:930px;
height:auto;
margin:0 auto;
padding-top:42px;

}
.wrapper {
padding:0px 0px 20px;
width:300px;
float:left;
}
.breadtext
{
font:13px Verdana, Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
text-indent:15px;
}
.breadcrumb
{
width:100%;
/*background-color:#000000;*/
/*padding:15px 0;*/
}
.title {
color:#FFFFFF;
font:lighter 25px impact;
text-transform:uppercase;
text-align:left;
}
.imagebg
{
background-color:#FFFFFF;
width:278px;
height:auto;
margin:25px auto;
border:1px solid #cecece;
padding:6px;
}
.conttext
{
font:12px/1.8 Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
width:290px;

}
h1{
display:inline;
}
.ListText{
	font:18px Arial, Helvetica, sans-serif;
	bor

}
#slidecontent {

    position: relative;
}
ol#controls {
    height: 28px;
    left: 360px;
    margin: 1em 0;
    padding: 0;
    position: absolute;
    top: 121px;
    z-index: 1000;
}
.adminbox {
    border: 1px solid #589711;
	background-color:#FFFFFF;
    border-radius: 10px 10px 10px 10px;
	-webkit-border-radius: 10px 10px 10px 10px;
    box-shadow: 2px 2px 2px #B0AEA6;
    padding: 10px;
	
    margin: 20px auto;
    height: auto;
    padding: 20px;
    width: 500px;
}
.adtitle
{
font:bold 24px "Courier New", Courier, monospace;
margin:15px 0;
color:#000;

}
select, input
{
padding:5px;
width:250px;
}
label{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
float:left;
width:150px;
color:#333333;
text-align:left;
}
input[type=radio]{
width:20px;
}
.dob{
	width:60px;
	padding:0px;
}
.condensed-table td{
    line-height: 35px !important;
}

.suggestionsBox {
max-height: 500px;
overflow-y: scroll;
z-index: 10;
min-width: 256px;
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
{literal}
    <script  type="text/javascript" language="javascript1.2">

jQuery.noConflict();

function suggest(inputString){
             
		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
                        jQuery('#cid').val('');
		} else if(inputString.length > 2) {
		jQuery('#searchname').addClass('load');
			jQuery.post("ajaxcheckgroupname.php", {groupnamesuggest: ""+inputString+""}, function(data){
				if(data.length >0) {
                                        
					jQuery('#suggestions').fadeIn();
					jQuery('#suggestionsList').html(data);
					jQuery('#searchname').removeClass('load');
				}
			});
		}
}
function fillgroupname(thisValue) {
        if(thisValue){
        jQuery('#searchname').val(thisValue);        
    }
    setTimeout(jQuery('#suggestions').fadeOut(), 300);
        //jQuery('#suggestions').hide;
}
</script>
{/literal}
<body>
<form  method="post" name="sortlist" id="sortlist" action="external_adminusers.php">    
  <input type="hidden" name="sortby" value="{$sortby}" />
  <input type="hidden" name="order" value="{$order}" />
  <input type="hidden" name="page" value="{$Page}" />
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
          <h1>External API User(s) - CFS </h1>
        </div>
          <div class="row"  style="margin-left:100px;">
            <div id="suggest">
            <form action="external_adminusers.php" method="get" id="groupsearch">
                <input type="text" placeholder="Group Name" name="name" id="searchname" value="{if $searchname}{$searchname}{/if}" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off   required>
                <input type="submit" value="Search">
                {if $searchname} <input type="button" value="Show all" onclick="window.location.href='external_adminusers.php';"> {/if}
                <div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
             </form>                   
	    </div>
        </div>
      
        <div class="row">
            
            <a href="external_add_adminuser.php" style="float: right;margin:2% 0;font-weight: bold;font-size: 15px;">Add User</a> 
            
          <div>
           
		<table border="1" cellspacing="0" cellpadding="0" id="example1">
        <thead>
          <tr>
            <th width="8%">ID</th>
            <th width="26%"><a onclick="sortload{$groupnameclicksort};">User Name</a></th>
		    <th width="26%">First Name</th>
			 <th width="30%">Added Date </th>
            <th width="10%">Action</th>
			{* <th>Permission</th> *}
          </tr>
        </thead>
        <tbody>
          {section name=i loop=$AdminUserList}
		  <tr>
            <td>{$AdminUserList[i].Ident}</td>
            <td>{$AdminUserList[i].UserName}</td>
		    <td>{$AdminUserList[i].Firstname}</td>
            <td>{$AdminUserList[i].Added_Date}</td>
            <td width="10%" align="center"><a href="external_editadminuser.php?auid={$AdminUserList[i].Ident}"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a>
           <!-- <td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','{$AdminUserList[i].Ident}');" alt="delete" title="delete"/></td>-->
           <img src="images/delete.svg" width="16" height="16" alt="Click to Disable" title="Click to Delete"  onClick="deleteReg('delete','{$AdminUserList[i].Ident}');"  style="cursor:pointer; margin-left:10px;"/></td>
			{* <td width="3%" align="center">
  		{if $AdminUserList[i].usr_flag neq "0"}
  			<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','{$AdminUserList[i].Ident}','Disable');"  style="cursor:pointer;"/>
  		{else}
  			<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','{$AdminUserList[i].Ident}','Enable');"  style="cursor:pointer;"/>
  		{/if}
      </td>

      <td width="3%" align="center">
  		<?php if ($this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['usr_flag'] != '0'): ?>
  			<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','<?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['Ident']; ?>
','Disable');"  style="cursor:pointer;"/>
  		<?php else: ?>
  			<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','<?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['Ident']; ?>
','Enable');"  style="cursor:pointer;"/>
  		<?php endif; ?>
      </td>  *}
          </tr>
		  {/section}
                  
                  
                  
                  
                  
                  
                   <tr>
  <td  colspan="8" style="color:#000000; padding-left:390px;padding-top:15px;" align="right">
		{if $pages_New.first=="0" and $pages_New.next=="0"}
<tr><td colspan="7">&nbsp;</td></tr>
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
          </div>          
        </div>
		
       
     </div>
	       </div> 
      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
</body>