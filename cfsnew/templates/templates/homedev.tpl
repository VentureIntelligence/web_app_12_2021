{include file="headerdev.tpl"}

{include file="leftpanel.tpl"}

<div class="container-right">
{if $searchupperlimit gte $searchlowerlimit}   
{include file="filters.tpl"}

<div class="list-tab">
<ul>
<li><a  href="home.php" class="active postlink"><i></i> LIST VIEW</a></li>
<li><a class="postlink" href="{if count($SearchResults[List]) gt 0}details.php?vcid={$SearchResults[0].Company_Id}{else}#{/if}"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul><div class="page-no" style="position: initial;"><span>(in Rs. Cr) &nbsp;&nbsp;</span></div>
</div>

<div class="companies-list">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
        <th  class="sorthead {if $sortby eq "sortcompany"} {$sortorder} {/if}" id="sortcompany">Company Name</th>
<th class="sorthead {if $sortby eq "sortrevenue"} {$sortorder} {/if}" id="sortrevenue"> Revenue <br/> </th>
<th class="sorthead {if $sortby eq "sortebita"} {$sortorder} {/if}" id="sortebita"> EBITDA <br/> </th>
<th class="sorthead {if $sortby eq "sortpat"} {$sortorder} {/if}" id="sortpat"> PAT <br/> </th>
<th class="sorthead {if $sortby eq "sortdetailed"} {$sortorder} {/if}" id="sortdetailed"> Detailed</th>
<th> Filings	</th></tr></thead>
<tbody>  
  
  {section name=List loop=$SearchResults}  
    
      <tr><td class="name-list"> <span class="has-tip" data-tooltip="" title="{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} Listed{elseif $SearchResults[List].ListingStatus eq '2'} Privately held(Ltd){elseif $SearchResults[List].ListingStatus eq '3'} Partnership {elseif $SearchResults[List].ListingStatus eq '4'} Proprietorship{/if}">{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} L{elseif $SearchResults[List].ListingStatus eq '2'} PVT{elseif $SearchResults[List].ListingStatus eq '3'} PART {elseif $SearchResults[List].ListingStatus eq '4'} PROP{/if}</span>
              {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>	

        {else}
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>

        {/if}
              </td>
    <td>{if $SearchResults[List].TotalIncome eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].TotalIncome}{else}{math equation="x / y" x=$SearchResults[List].TotalIncome y=10000000 format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].EBDT eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].EBDT}{else}{math equation="x / y" x=$SearchResults[List].EBDT y=10000000 format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].PAT eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].PAT}{else}{math equation="x / y" x=$SearchResults[List].PAT y=10000000 format="%.2f"}{/if}</td>
    <td>
        {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >FY{$SearchResults[List].FY} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	

        {else}
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >FY{$SearchResults[List].FY} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	

        {/if}
        
    </td> 
     <td>
        {if $SearchResults[List].filing eq "true"}
            <a class="postlink" href="viewfiling.php?c={$SearchResults[List].FCompanyName|escape:"url"}">View</a>
        {else}
            -
        {/if}
    </td> 
  </tr>
  {/section}
   
  </tbody>
  </table>

{include file="pagination.tpl"}
</div>
  
{else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if}
</div>
<!-- End of container-right -->

</div>
<!-- End of Container -->
<input type="hidden" name="sortby" id="sortby" value="{$sortby}"/>
<input type="hidden" name="sortorder" id="sortorder" value="{$sortorder}"/>
<input type="hidden" name="pageno" id="pageno" value="{$pageno}"/>
</form>

</body>
</html>
{literal}
    <script type="text/javascript">
        $(document).ready(function() {
              $(".sorthead").live('click',function(){
                 // $(this).html($(this).text()+'<img src="images/ajax-loader.gif" style="float:right;height:20px;"/>');
                 $(this).addClass('loadingth');
                sortby=$(this).attr('id');
                if($(this).hasClass("asc"))
                        sortorder="desc";
                    else
                        sortorder="asc";
                 $("#sortby").val(sortby);
                 $("#sortorder").val(sortorder);
                   $.ajax({
            type: "POST",
          url: "ajaxhomedev.php",
          data: $("#Frm_HmeSearch").serializeArray(),
          success: function( data ) {
              $('.companies-list').html(data);
             // alert(data);
          }
        });
                 //$("#Frm_HmeSearch").submit();
              });
        });
    </script>
{/literal}