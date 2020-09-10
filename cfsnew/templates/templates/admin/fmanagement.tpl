{include file='admin/header.tpl'}
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

</script>
{/literal}
<body>
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />

<div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Company Financials</h1><a href="addcfinancials.php">Add Company Financials</a>
          <div style="margin-left:20px;float: right;"> Show Records Per Page:
              <select id="rowperpage" name="rowperpage" onchange="document.forms['addformspringform'].submit();" style="width: 60px;height: 22px;">
                    <option value="10" {if $rowperpage=="10"}SELECTED{/if}>10</option>
                    <option value="20" {if $rowperpage=="20"}SELECTED{/if}>20</option>
                    <option value="30" {if $rowperpage=="30"}SELECTED{/if}>30</option>
                    <option value="40" {if $rowperpage=="40"}SELECTED{/if}>40</option>
                    <option value="50" {if $rowperpage=="50"}SELECTED{/if}>50</option>
            </select>
          </div>
        </div>
             <div id="alphaPagination">
                        {section name=i loop=$alphaletter}
                                <a href="fmanagement.php?pag={$alphaletter[i]}">{$alphaletter[i]}</a>	
                        {/section}
             </div><br>
        <div class="row">
          <div class="span10">
           
			<table class="condensed-table">
        <thead>
          <tr>
            <th width="10%">ID</th>
            <th width="60%">Company Name</th>
			<th width="12%">F.Year</th>
            <th width="31%">Added Date </th>
           <!-- <th colspan="2">Actions</th>-->
          </tr>
        </thead>
        <tbody>
          {section name=i loop=$FinancialList}
		  <tr>
            <th>{$FinancialList[i].PLStandard_Id}</th>
            <td>{$FinancialList[i].SCompanyName}</td>
			<td>{$FinancialList[i].FY}</td>
            <td>{$FinancialList[i].Added_Date}</td>
           <!-- <td width="3%" align="center"><a href="edituser.php?uid={$FinancialList[i].user_id}"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>-->
            <!--<td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','{$FinancialList[i].PLStandard_Id}');" alt="delete" title="delete" style="cursor:pointer;"/></td>-->
			<td width="3%">
		{if $FinancialList[i].usr_flag eq "1"}
			<!--<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','{$FinancialList[i].user_id}','Disable');"  style="cursor:pointer;"/>-->
		{else}
			<!--<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','{$FinancialList[i].user_id}','Enable');"  style="cursor:pointer;"/>-->
		{/if}	
			</td>
          </tr>
		  {sectionelse}
			<tr>
				<td colspan="">&nbsp;</td>
				<td colspan="3" align="center">No Data Found !</td>
				<td colspan="">&nbsp;</td>
			</tr>		  		  
		  {/section}
  <tr>
  <td  colspan="8" style="color:#000000; padding-left:380px;padding-top:15px;" align="right">
		{if $pages_New.first=="0" and $pages_New.next=="0"}

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

      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
  </form>
</body>