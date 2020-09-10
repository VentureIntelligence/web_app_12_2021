{include file="header.tpl"}

{literal}
<style type="text/css">
    form.custom .custom.dropdown
    {
        width:80px !important;
        }
        
    </style>
{/literal}


<div class="container-right">
	<div class="companies-list">

            
            <div class="result-title" style="margin-top:1%;border-bottom: 1px solid #ccc;">
             <h3>
               <span class="result-no"> Listed Reports({$ReportsCount})</span>
            </h3>                   
               
            </div>
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2%;">
<thead> 
<tr>
<th style=" background:none;">Title </th>
<th style=" background:none;"> Period <br/> </th>
<th style=" background:none;"> Date <br/> </th>
</tr>
</thead>
<tbody>  
  
  {section name=List loop=$reportList}  
    
      <tr>
          <td class="name-list">
              <a class="postlink_new" href="other_report_details.php?rid={$reportList[List].id}">{$reportList[List].reportTitle} </a>
          </td>
          <td class="name-list">
                <a class="postlink_new"  href="other_report_details.php?rid={$reportList[List].id}">{$reportList[List].reportPeriod} </a>
          </td>
          <td class="name-list">
                <a class="postlink_new"  href="other_report_details.php?rid={$reportList[List].id}">{$reportList[List].date} </a>
          </td>
  </tr>
  {/section}
   
  </tbody>
  </table>

{include file="pagination.tpl"}
</div>

</form>


</div>




</div>


</div>
  

</div>
<!-- End of Container -->


</body>
</html>

{literal}
               
                
 <script type="text/javascript">
 $("a.postlink_new").live('click',function(){
      
        hrefval= $(this).attr("href");
        $("#Frm_reportSearch").attr("action", hrefval);
        $("#Frm_reportSearch").submit();
        return false;

    });
 </script>

{/literal}

