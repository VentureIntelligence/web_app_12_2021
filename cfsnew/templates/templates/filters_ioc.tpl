
</form>
{if $pageName1  eq 'home.php' or  $pageName1  eq 'home1.php' or  $pageName1  eq 'homedev.php' or $pageName1  eq 'chargesholderlist_suggest.php' or $pageName1  eq 'indexofcharges.php' }
<div class="companies-fount-new">
<!--<h1>{if $smarty.session.totalResults}<span>{$smarty.session.totalResults}</span>{else}0{/if} Companies found</h1>-->
   
    <h1 style="margin-left:15px;"><span>{if $totalrecord_1}{$totalrecord_1}{else}{$totalrecord}{/if} </span>Companies found
    <div style="float:right;">
  {if $pageName1  neq 'indexofcharges.php'}
<div class="page-no" style="position:relative">
    <div class="btn-cnt" style="float:right; padding: 0px 10px !important;">
         <form name="Frm_Compare" id="exportform" action="ioc_companylist_export.php" method="post" enctype="multipart/form-data">
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel" value="{$searchexport}"/>
            <input type="hidden" name="ioc" value='{$ChargesholderName}'>
            <input type="hidden" name="chargeaddress" value="{$ioc_faddress}">
            <input type="hidden" name="chargefromdate" value="{$ioc_fchargefromdate}">
            <input type="hidden" name="chargetoamount" value="{$ioc_fchargetoamount}">
            <input type="hidden" name="chargefromamount" value="{$ioc_fchargefromamount}">
            <input type="hidden" name="chargetodate" value="{$ioc_fchargetodate}">
            <input type="hidden" id="ChargesholderName" name="ChargesholderName" value='{$ChargesholderName}'>
            <div class="btn-cnt p10" style="float:right;padding: 5px!important;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
        </div>
    </div>
    {/if}
    </div>
    </h1>

</div>

{/if}