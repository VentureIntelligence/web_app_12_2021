{if $pageName1  eq 'home.php' or  $pageName1  eq 'home1.php' or  $pageName1  eq 'homedev.php'}
<div class="companies-fount-new">
<!--<h1>{if $smarty.session.totalResults}<span>{$smarty.session.totalResults}</span>{else}0{/if} Companies found</h1>-->
   
    <h1>{if $totalrecord_1}<span>{$totalrecord_1}</span>{else}{$totalrecord}{/if} Companies found</h1>

{if $pageName1  eq 'details.php'}
    <div class="compare-new" style="margin-right:25px;">
        <p class="findcom">
            <label>Dont find a Company ?</label>
            <!--<a href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to request for financials</a>-->
            <a href="javascript:void(0)" class="updateFinancialHome">Click here to request for financials</a>
        </p>
        <p class="findcom">
            <a href="javascript:void(0)"  class="oldFinacialData" >Click Here to search for additional
companies (with older financials)</a>
        </p>
    </div>
    {else}
       <div class="compare-new" style="margin-top:-35px;margin-right:25px;">
        <p class="findcom"><label>Dont find a Company ?</label>
            <!--<a href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to request for financials</a>-->
            <a href="javascript:void(0)" class="updateFinancialHome">Click here to request for financials</a>
        </p>
        <p class="findcom">
            <a href="javascript:void(0)"  class="oldFinacialData" >Click Here to search for additional
companies (with older financials)</a>
        </p>
    </div> 
{/if}
</div>
<div class="filter-selected">
{if count($REQUEST) gt 0 and count($fliters)}     
    <ul>
    {section name=List loop=$fliters}
      <li> <span>{$fliters[List].value}</span> <a  onclick="resetinput('{$fliters[List].field}','{$fliters[List].key}');"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li> 
    {/section}
<!--<li> <span>Unlisted</span> <a href="javascript:;"><img src="images/close-selected.gif" width="14" height="14" alt="" /></a></li>-->

<li class="result-select-close"><a href="home.php">
                                             <img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
</ul>
 
{/if}
<div style="float:right;">
  {if $searchexport}
            <div class="btn-cnt" style="float:right; padding: 8px 0 !important;"><input name="exportcompare" class="home_export" id="exportcompare" type="button" value="EXPORT" /></div>
{elseif $searchexport2}
          
            <div class="btn-cnt" style="float:right;  padding: 8px 0 !important;"><input name="exportcompare" class="home_export" id="exportcompare" type="button" value="EXPORT" /></div>

{elseif $searchexport3} 
       
            <div class="btn-cnt" style="float:right;  padding: 8px 0 !important;"><input name="exportcompare" calss="home_export" id="exportcompare" type="button" value="EXPORT" /></div>

{/if}
     {if $pageName1  eq 'home.php' or  $pageName1  eq 'home1.php' or  $pageName1  eq 'homedev.php'}
  <div class="page-no" style="position:relative"><span>Show </span>
    <select name="limit" onchange="this.form.submit();">
    <option value="all" {if $limit eq "all"}selected{/if}>All</option>
    <option value="10" {if $limit eq 10}selected{/if}>10</option>
    <option value="25" {if $limit eq 25}selected{/if}>25</option>
    <option value="50" {if $limit eq 50}selected{/if}>50</option>
</select>
</div>
{/if}
<div class="page-no" style="position:relative"><span>Sort By </span><div class="btn-cnt" style="float:right; padding: 8px 10px !important;"><input name="exportcompare" class="sorthead asc home_export" id="sortnew" type="button" value="Latest Added" /></div></div>
</div>

</div><br>
{/if}