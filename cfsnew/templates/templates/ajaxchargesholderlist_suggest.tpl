

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
            <a href="companylist_suggest.php?id={$SearchResults[List].cin}&ioc_fstatus=1&name={$ChargesholderName}&ioc_c={$companyURL}{if $ioc_fstatus eq 1}{if $ioc_faddress neq ''}&chargeaddress={$ioc_faddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{elseif $companyURL neq ''}&ioc_c={$companyURL}{/if}" style="color:#414141;text-decoration: none;"><b>{$SearchResults[List].company_name}</b></a></td>
      </tr>
    {/section}
  </tbody>
</table>

{include file="pagination.tpl"}


