
<form method="post" id="Frm_HmeSearch1" action="companylist_suggest.php">
                      <input type="hidden" name="holderhiddenval" class="holderhiddenval" value='{$ChargesholderName}'>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <thead> 
    <tr>
      <th  class="sorthead {if $sortby eq "sortcompany"} {$sortorder} {/if}" id="sortcompany">Company Name</th>
    </tr>
  </thead>
  <tbody>  
 
    {section name=List loop=$SearchResults}  
      <tr>
        <td>
            <a class="postlinkval" href="companylist_suggest.php?id={$SearchResults[List].cin}&ioc_fstatus=1&ioc_c={$companyURL}{if $ioc_fstatus eq 1}{if $ioc_faddress neq ''}&chargeaddress={$ioc_faddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{elseif $companyURL neq ''}&ioc_c={$companyURL}{/if}" style="color:#414141;text-decoration: none;"><b>{$SearchResults[List].company_name}</b></a></td>
      </tr>
    {/section}
  </tbody>
</table>
{literal}

 

    <script type="text/javascript">
    $("a.postlinkval").live('click',function(){
        hrefval= $(this).attr("href");
        $("#Frm_HmeSearch1").attr("action", hrefval);
        $("#Frm_HmeSearch1").submit();
        return false;
     });
     </script>
{/literal}
{include file="pagination.tpl"}



