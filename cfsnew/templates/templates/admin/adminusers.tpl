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
{/literal}
<body>
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
          <h1>Admin User(s) </h1>
        </div>
        <div class="row">
            
            <a href="add_adminuser.php" style="float: right;margin:2% 0;font-weight: bold;font-size: 15px;">Add Admin User</a> 
            
          <div>
           
		<table border="1" cellspacing="0" cellpadding="0" id="example1">
        <thead>
          <tr>
            <th width="8%">ID</th>
            <th width="26%">User Name</th>
		    <th width="26%">First Name</th>
			 <th width="30%">Added Date </th>
            <th width="10%">Action</th>
			<th>Permission</th>
          </tr>
        </thead>
        <tbody>
          {section name=i loop=$AdminUserList}
		  <tr>
            <td>{$AdminUserList[i].Ident}</td>
            <td>{$AdminUserList[i].UserName}</td>
		    <td>{$AdminUserList[i].Firstname}</td>
            <td>{$AdminUserList[i].Added_Date}</td>
            <td width="10%" align="center"><a href="editadminuser.php?auid={$AdminUserList[i].Ident}"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a>
           <!-- <td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','{$AdminUserList[i].Ident}');" alt="delete" title="delete"/></td>-->
           <img src="images/delete.svg" width="16" height="16" alt="Click to Disable" title="Click to Delete"  onClick="deleteReg('delete','{$AdminUserList[i].Ident}');"  style="cursor:pointer; margin-left:10px;"/></td>
			<td width="3%" align="center">
  		{if $AdminUserList[i].usr_flag neq "0"}
  			<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','{$AdminUserList[i].Ident}','Disable');"  style="cursor:pointer;"/>
  		{else}
  			<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','{$AdminUserList[i].Ident}','Enable');"  style="cursor:pointer;"/>
  		{/if}
      </td>
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