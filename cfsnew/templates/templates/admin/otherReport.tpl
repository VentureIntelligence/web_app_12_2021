{include file='admin/header.tpl'}
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
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


</script>
<style>
    
    .condensed-table td,.condensed-table th{
        padding: 14px 2px;
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
          <h1>Other Report List </h1><a href="add_otherReport.php" style="float: right;margin-top: -34px;">Add Report</a>
        </div>
          
              
         
          <div class="row" style="clear:both; margin-top: 1%">
          <div style="margin-left: 2%;">
           
			<table class="condensed-table" >
        <thead>
          <tr>
            <th width="4%">ID</th>
            <th>Report Title</th>
            <th>Report Period </th>
            <th>Date </th>
            <th>Embed Code </th>
            <th>Definition</th>
            <th colspan="15%">Actions</th>
          </tr>
        </thead>
        <tbody>
          {section name=i loop=$reportList}
		  <tr>
            <td >{$reportList[i].id}</td>
            <td>{$reportList[i].reportTitle}</td>
            <td>{$reportList[i].reportPeriod}</td>
            <td>{$reportList[i].date}</td>
            <td>{$reportList[i].embedCode}</td>
            <td>{$reportList[i].definition}</td>
            <td width="3%" align="center">
                <a href="edit_otherReport.php?rid={$reportList[i].id}"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>
            <td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','{$reportList[i].id}');" alt="delete" title="delete"/></td>
			
          </tr>
		  {sectionelse}
			<tr>
				<td colspan="">&nbsp;</td>
				<td colspan="3" align="center">No Data Found !</td>
				<td colspan="">&nbsp;</td>
			</tr>		  		  
		  {/section}
	  
        </tbody>
      </table>
          </div>          
        </div>
      </div>

      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
</body>