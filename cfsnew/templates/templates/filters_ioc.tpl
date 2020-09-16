
</form>
{if $pageName1  eq 'home.php' or  $pageName1  eq 'home1.php' or  $pageName1  eq 'homedev.php' or $pageName1  eq 'chargesholderlist_suggest.php' }
<div class="companies-fount-new">
<!--<h1>{if $smarty.session.totalResults}<span>{$smarty.session.totalResults}</span>{else}0{/if} Companies found</h1>-->
   
    <h1>{if $totalrecord_1}<span>{$totalrecord_1}</span>{else}{$totalrecord}{/if} Companies found {if $ChargesholderName}for {$ChargesholderName}{/if}
    <div style="float:right;">
  
<div class="page-no" style="position:relative">
    <div class="btn-cnt" style="float:right; padding: 0px 10px !important;">
         <form name="Frm_Compare" id="exportform" action="ioc_companylist_export.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel" value="{$searchexport}"/>
            <input type="hidden" id="ChargesholderName" name="ChargesholderName" value="{$ChargesholderName}"/>
            <div class="btn-cnt p10" style="float:right;padding: 5px!important;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
        </div>
    </div>
</div>
    </h1>

</div>
<div class="filter-selected">

</div>
{/if}