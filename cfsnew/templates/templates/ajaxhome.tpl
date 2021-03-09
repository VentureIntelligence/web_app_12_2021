{if $searchupperlimit gte $searchlowerlimit}   

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
        <th  class="sorthead {if $sortby eq "sortcompany"} {$sortorder} {/if}" id="sortcompany">Company Name</th>
<th class="sorthead {if $sortby eq "sortrevenue"} {$sortorder} {/if}" id="sortrevenue"> Revenue <br/> </th>
<th class="sorthead {if $sortby eq "sortebita"} {$sortorder} {/if}" id="sortebita"> EBITDA <br/> </th>
<th class="sorthead {if $sortby eq "sortpat"} {$sortorder} {/if}" id="sortpat"> PAT <br/> </th>
<th class="sorthead {if $sortby eq "sortdetailed"} {$sortorder} {/if}" id="sortdetailed"> Detailed</th>

{if $chargewhere neq ''}

 <th style='background:none'> Date of Charge</th> 
 <th style='background:none'> Charge Amount</th> 
 <th style='background:none'> Charge Holder</th> 
{/if}


{*<th> Filings	</th>*}</tr></thead>
<tbody>  
  
  {section name=List loop=$SearchResults}  
  
    {assign var=foo value=$SearchResults[List].FY|replace:' ':'_'}
      <tr><td class="name-list" style="text-transform: uppercase"> <span class="has-tip" data-tooltip="" title="{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} Listed{elseif $SearchResults[List].ListingStatus eq '2'} Privately held(Ltd){elseif $SearchResults[List].ListingStatus eq '3'} Partnership {elseif $SearchResults[List].ListingStatus eq '4'} Proprietorship{/if}">{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} L{elseif $SearchResults[List].ListingStatus eq '2'} PVT{elseif $SearchResults[List].ListingStatus eq '3'} PART {elseif $SearchResults[List].ListingStatus eq '4'} PROP{/if}</span>
              {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>	

        {else}
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>

        {/if}
              </td>
    <td>{if $SearchResults[List].TotalIncome eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].TotalIncome}{elseif $currency eq "INR"}{math equation="x / y" x=$SearchResults[List].TotalIncome y=10000000 format="%.2f"}{elseif $currency eq "USD"}{math equation="(x / z)/y" x=$SearchResults[List].TotalIncome y=1000000 z=$yearcurrency.$foo format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].EBITDA eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].EBITDA}{elseif $currency eq "INR"}{math equation="x / y" x=$SearchResults[List].EBITDA y=10000000 format="%.2f"}{elseif $currency eq "USD"}{math equation="(x / z)/y" x=$SearchResults[List].EBITDA y=1000000 z=$yearcurrency.$foo format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].PAT eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].PAT}{elseif $currency eq "INR"}{math equation="x / y" x=$SearchResults[List].PAT y=10000000 format="%.2f"}{elseif $currency eq "USD"}{math equation="(x / z)/y" x=$SearchResults[List].PAT y=1000000 z=$yearcurrency.$foo format="%.2f"}{/if}</td>
    {if $SearchResults[List].FY gt 0}
    <td>
        {assign var="FY" value=" "|explode:$SearchResults[List].FY}
        {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >FY{$FY[0]} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	

        {else}
        
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >FY{$FY[0]} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	
        {/if}

    </td> 
     {else}
         <td><a> </a></td>
        {/if}
        
    {if $chargewhere neq ''}
  
    <td> {$SearchResults[List].dateofcharge} </td> 
    <td> {math equation="x / y" x=$SearchResults[List].chargeamt|replace:',':''  y=10000000 format="%.2f"} </td> 
    <td> {$SearchResults[List].chargeholder} </td> 
   {/if}
     
     
    {*<td>
        {if $SearchResults[List].filing eq "true"}
            <a class="postlink" href="viewfiling.php?c={$SearchResults[List].FCompanyName|escape:"url"}">View</a>
        {else}
            -
        {/if}
    </td>*}
  </tr>
  {/section}
   
  </tbody>
  </table>

{include file="pagination.tpl"}
  
{else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if}

