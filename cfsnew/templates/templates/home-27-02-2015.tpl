{include file="header.tpl"}

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
{*<th> Filings	</th>*}</tr></thead>
<tbody>  
  
  {section name=List loop=$SearchResults}  
    
      <tr><td class="name-list" style="text-transform: uppercase"> <span class="has-tip" data-tooltip="" title="{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} Listed{elseif $SearchResults[List].ListingStatus eq '2'} Privately held(Ltd){elseif $SearchResults[List].ListingStatus eq '3'} Partnership {elseif $SearchResults[List].ListingStatus eq '4'} Proprietorship{/if}">{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} L{elseif $SearchResults[List].ListingStatus eq '2'} PVT{elseif $SearchResults[List].ListingStatus eq '3'} PART {elseif $SearchResults[List].ListingStatus eq '4'} PROP{/if}</span>
              {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>	

        {else}
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>

        {/if}
              </td>
    <td>{if $SearchResults[List].TotalIncome eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].TotalIncome}{else}{math equation="x / y" x=$SearchResults[List].TotalIncome y=10000000 format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].EBITDA eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].EBITDA}{else}{math equation="x / y" x=$SearchResults[List].EBITDA y=10000000 format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].PAT eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].PAT}{else}{math equation="x / y" x=$SearchResults[List].PAT y=10000000 format="%.2f"}{/if}</td>
    {if $SearchResults[List].FY gt 0}
    <td>
        {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >FY{$SearchResults[List].FY} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	

        {else}
        
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >FY{$SearchResults[List].FY} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	
        {/if}
       
    </td> 
     {else}
         <td><a> </a></td>
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
</div>
<input type="hidden" name="sortby" id="sortby" value="{$sortby}"/>
<input type="hidden" name="sortorder" id="sortorder" value="{$sortorder}"/>
<input type="hidden" name="pageno" id="pageno" value="{$pageno}"/>
<input type="hidden" name="searchv" id="searchv" value="{$searchv}"/>
</form>

{if $searchexport}
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel" value="{$searchexport}"/>
            <div class="btn-cnt p10" style="float:right;"><input name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
</div>

{elseif $searchexport2}
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel1" value="{$searchexport2}"/>
            <div class="btn-cnt p10" style="float:right;"><input name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>


{elseif $searchexport3}
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel2" value="{$searchexport3}"/>
            <div class="btn-cnt p10" style="float:right;"><input name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
</div>

{/if}
</div>
  
{else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if}

<!-- End of container-right -->

</div>
<!-- End of Container -->


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
          url: "ajaxhome.php",
          data: $("#Frm_HmeSearch").serializeArray(),
          success: function( data ) {
              $('.companies-list').html(data);
             // alert(data);
          }
        });
                 //$("#Frm_HmeSearch").submit();
              });
        });
        
        
         $('#exportcompare').click(function(){ 
                initExport();
                return false;
            });
            
            function initExport(){
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec =  {/literal}{$totalrecord}{literal};

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                                    if (currentRec < remLimit){
                                $("#exportform").submit();
                            }else{
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                        },
                        error:function(){
                            alert("There was some problem exporting...");
                        }

                    });
                }
        
        
    </script>
    <style>
        .name-list{
            text-transform: uppercase !important;
            }
            .filter-selected{
                overflow: visible !important;
                }
                .list-tab{
                    clear:both !important;
                    }
                    form.custom .custom.dropdown ul li { width: 100%;}
    </style>
{/literal}

