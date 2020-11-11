<style>
.finance-filter-custom{
    width: 140px;
    display: flex;
}
.btn-cnt input {
    margin-right: 25px;
}
.incurrency{
    margin: 0px 5px;
}
.currencyconversion{
    width:65px;
}
.currencyselection{
    width:52px;
}
</style><?php
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."balancesheet.php";
$balancesheet = new balancesheet();
require_once MODULES_DIR."balancesheet_new.php";
$balancesheet_new = new balancesheet_new();
//Changes done for xbrl2 start
require_once MODULES_DIR."cashflow.php";
$cashflow = new cashflow();
//Changes done for xbrl2 end
//pr($_REQUEST);

if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in ajaxmillicurrency page -'.$_SESSION['username']); }


if($_GET['queryString']!='INR')
{
if(!$_SESSION['typevalue'])
{
$currtype=array('GBP','EUR','USD','JPY','CNY','AUD','CHF','CAD','THB','INR','IDR','HKD');
$_SESSION['typevalue']=array();
for($c=0;$c < count($currtype);$c++)
{
    $from_currency='INR';
    $to_currency=$currtype[$c];
    $arr_key=$from_currency."-".$currtype[$c];
    $amount=1;
    $from = strtolower($from_currency);
    $to = strtolower($to_currency);
    //$from = 'inr';
    //$to = 'usd';
    $ch = curl_init("http://demo.matrixau.net/currency_convert/convert.php?from=" .$from. "&to=" .$to. "&amount=" .$amount);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $var= curl_exec($ch);
    curl_close($ch); 
    $pos = stripos($var,'=');
    $removeString = substr($var,$pos+1);
    $cn = preg_replace("/[^0-9,.]/", "", $removeString);
        $_SESSION['typevalue'][$arr_key]=$cn;
}
}
}
$yearcurrency=array();
$currvatype=array('71','72','70','69');
$fyvalue=array('19','18','17','16');
$yearcurrency=array_combine($fyvalue,$currvatype);

//print_r($_SESSION['curvalue']);
/*Currency Convert Function*/
function currency_convert($amount,$from_currency,$to_currency)
{
    //print_r($_SESSION['typevalue']);
    $comp_key=$from_currency."-".$to_currency;
        if($_GET['queryString']!='INR')
        {
            $curr_value=$_SESSION['typevalue'][$comp_key];
        }
        else
        {
            $curr_value=1;
        }
        $convertnumber=$amount* $curr_value;
        return $convertnumber;
}

function numberFormat($num) {
    // $amount = $num;
    // setlocale(LC_MONETARY, 'en_IN');
    // $amount = money_format('%!i', $amount);
    // $amount=explode('.',$amount); //Comment this if you want amount value to be 1,00,000.00
    // return $amount[0]; 
    return number_format($num);
}

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
$template->assign("grouplimit",$toturcount1);
//pr($toturcount1);


$Insert_CProfile['user_id']   = $authAdmin->user->elements['user_id'];
$visitdate=$users->selectByVisitCompany($Insert_CProfile['user_id']);
$Insert_CProfile2['visitcompany']  .= $visitdate['visitcompany'];
$Insert_CProfile2['visitcompany']  .= ",";
$Insert_CProfile2['visitcompany']  .= $_GET['vcid'];

$Insert_CProfile1['visitcompany'] = implode(',',array_unique(explode(',',$Insert_CProfile2['visitcompany'])));
//pr($Insert_CProfile1['visitcompany']);
//substr_count($Insert_CProfile1['visitcompany'], ',')+1;
$Insert_CProfile1['Visit'] = substr_count($Insert_CProfile1['visitcompany'], ',')+1;
$Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];
//pr($Insert_CProfile);
//pr($authAdmin->user->elements['user_id']);
$users->update($Insert_CProfile1);

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("GroupList","Visit");
$where2 = "GroupList=".$usergroup1;
$toturcount1 = $users->getFullList('','',$fields2,$where2);
$total = 0;
foreach($toturcount1 as $array)
{
   $total += $array['Visit'];
}
$Insert_CGroup['Group_Id'] = $usergroup1;
$Insert_CGroup['Used'] = $total;
$grouplist->update($Insert_CGroup);
//pr($total);
$detailsWhere = 'Company_Id='.$_GET['vcid'];
$companyDetails = $cprofile->getcomdetails( $detailsWhere );
//Changes done for xbrl2 start
$CINDetails = $cprofile->getcomCIN( $detailsWhere );
$whererunType .= "cin = '".$CINDetails['CIN']."'";
$runType = $cprofile->getrunType( $whererunType );

if($runType['run_type'] == 1){
    $runTypetext = "XBRL";
} else {
    $runTypetext = "";
}
$fieldsresulttype = "max(ResultType) As ResultType";
$whereresulttype .= "CId_FK = ".$_GET['vcid']." and FY !=''";
$resulttype = $plstandard->getFieldValue($fieldsresulttype,$whereresulttype,"name");
$resulttypebalsheet = $balancesheet_new->getFieldValue($fieldsresulttype,$whereresulttype,"name");
$resulttypecashflow = $cashflow->getFieldValue($fieldsresulttype,$whereresulttype,"name");
if($resulttype[0][ResultType] == 0){
    $resultTypetext = "Standalone";
} else {
    $resultTypetext = "Consolidated";
}
if($resulttypebalsheet[0][ResultType] == 0){
    $resultTypetextbalsheet = "Standalone";
} else {
    $resultTypetextbalsheet = "Consolidated";
}
if($resulttypecashflow[0][ResultType] == 0){
    $resultTypetextcashflow = "Standalone";
} else {
    $resultTypetextcashflow = "Consolidated";
}
//Changes done for xbrl2 end
//Latest new fields added for xbrl2 
$fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange","EBT_before_Priod_period","Priod_period","CostOfMaterialsConsumed","PurchasesOfStockInTrade","ChangesInInventories","CSRExpenditure","OtherExpenses","CurrentTax","DeferredTax","total_profit_loss_for_period","profit_loss_of_minority_interest");
//Resulttype change from 0 to variable
$where .= "CId_FK = ".$_GET['vcid']." and FY !='' and ResultType='".$resulttype[0][ResultType]."'";
$order="FY DESC";
$FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");
$cprofile->select($_GET['vcid']);
if($_GET['queryString']=='INR'){
if($_GET['rconv']=='m'){
    $convalue = "1000000";
}elseif($_GET['rconv']=='c'){
    $convalue = "10000000";
}elseif($_GET['rconv']=='l'){
    $convalue = "100000";
}else{
    $convalue = "1";
}
}
else
{
    if($_GET['rconv']=='m'){
    $convalue = "1000000";
}else{
    $convalue = "1";
}
    
}
?>
<?php
$fields1 = array("*");
$where1 = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='0' and a.ResultType='0'";
//Changes done for xbrl2 
/*$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='".$resulttype[0][ResultType]."' and a.ResultType='".$resulttype[0][ResultType]."'";*/
$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='".$resulttypebalsheet[0][ResultType]."' and a.ResultType='".$resulttypebalsheet[0][ResultType]."'";
$where_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='0'";
//Changes done for xbrl2
/*$wherebs_new_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttype[0][ResultType]."'";
*/
$wherebs_new_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttypebalsheet[0][ResultType]."'";
$order1 = "a.FY DESC";
$group1 = "a.FY";
//Changes done for xbrl2 start
$fieldscf = array("a.cashflow_id","a.CId_FK","a.IndustryId_FK","a.CashflowApplicable","a.NetPLBefore","a.CashflowFromOperation",
"a.NetcashUsedInvestment","a.NetcashFromFinance","a.NetIncDecCash","a.EquivalentBeginYear","a.EquivalentEndYear","a.FY","a.ResultType");
$wherecf= "a.CId_FK = ".$_GET['vcid']." and a.ResultType='".$resulttypecashflow[0][ResultType]."'";
$ordercash = "a.FY DESC";
$groupcash = "a.FY";
$FinanceAnnual_cashflow = $cashflow->getFullList(1,100,$fieldscf,$wherecf,$ordercash,"name",$groupcash); 
if(count($FinanceAnnual_cashflow) == 0){ 
    $displaystyle = 'style="cursor: not-allowed;color: #888888;"';
} else {
    $displaystyle = '';
}
//Changes done for xbrl2 end
$FinanceAnnual1 = $balancesheet->getFullList(1,100,$fields1,$where1,$order1,"name",$group1);
if(count($FinanceAnnual1)==0){
   $FinanceAnnual1 = $balancesheet->getFullList_withoutPL(1,100,$fields1,$where_withoutPL,$order1,"name"); 
}


$FinanceAnnual1_new = $balancesheet_new->getFullList(1,100,$fields1,$wherebs_new,$order1,"name",$group1); 
if(count($FinanceAnnual1_new)==0){
    $FinanceAnnual1_new = $balancesheet_new->getFullList_withoutPL(1,100,$fields1,$wherebs_new_withoutPL,$order1,"name"); 
} 


//$whereradio = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='0' and b.ResultType=0";
$whereradio = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttype[0][ResultType]."' and b.ResultType=".$resulttype[0][ResultType]."";
/*old template */
$whereradio1 = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='0' and b.ResultType='0'";
//Old Balancesheet Ratio calculation
/*$RatioCalculation = $plstandard->radioFinacial($whereradio,$group1);
*/$RatioCalculation = $plstandard->radioFinacial($whereradio1,$group1);
if(count($RatioCalculation)==0){
   /*$RatioCalculation1 = $plstandard->radioFinacial($whereradio,$group1);*/
   $RatioCalculation1 = $plstandard->radioFinacial($whereradio1,$group1);
}

//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($whereradio,$group1);
if(count($NewRatioCalculation)==0){
   $NewRatioCalculation1 = $plstandard->NewRatioFinacial($whereradio,$group1);
}
?>
<?php 
   // echo count($FinanceAnnual);echo count($FinanceAnnual1);echo count($FinanceAnnual1_new);
    if((count($FinanceAnnual) > 0) || (count($FinanceAnnual1) > 0) || (count($FinanceAnnual1_new)  > 0)||(count($FinanceAnnual_cashflow) > 0)){
    ?>


<!--<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid=<?php echo $_GET['vcid']; ?>">See Projection</a></div>-->
<div class="cfs_menu">
    <ul>
        <li class="subMenu" data-row="profit-loss" href="javascript:;" onclick="javascript:plresult(<?php echo $_GET['vcid'];?>);">PROFIT &amp; LOSS</li>
        <li data-row="balancesheet" href="javascript:;" class="current subMenu" onclick="javascript:balancesheetresult(<?php echo $_GET['vcid'];?>);">BALANCE SHEET</li>
        <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; echo 'onclick=javascript:cfresult('.$_GET['vcid'].')'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> id="cashMenu" >CASH FLOW</li>
        <!-- <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> onclick="javascript:cfresult(<?php echo $_GET['vcid'];?>);">CASH FLOW</li> -->
        <li data-row="ratio" href="javascript:;" class="subMenu" onclick="javascript:ratioresult(<?php echo $_GET['vcid'];?>);">RATIOS</li>
        <li data-row="companyProfile" href="javascript:;" class="subMenu" id="companyProfileMenu">CO. PROFILE</li>
        <li data-row="filings" href="javascript:;" class="subMenu" id="filingsMenu">FILINGS</li>
        <!-- <li data-row="rating-info" href="javascript:;" class="subMenu">RATINGS</li> -->
        <li data-row="funding-ajax" href="javascript:;" class="subMenu" id="funding">FUNDING</li>
        <li data-row="master-data-all" href="javascript:;" class="subMenu">MASTER DATA</li>
       <!--  <li id="mcadirector" data-row="signatories_result" href="javascript:;" class="subMenu">BOARD OF DIRECTORS</li>
        <li data-row="chargesRegistered" href="javascript:;" class="subMenu">INDEX OF CHARGES</li> -->
        
    </ul>
</div>
<div style="clear:both;"></div>
<div class="finance-filter">
<div class="left-cnt"> 
    <label class="cagrvalue"> <input type="radio" name="yoy" id="yoy" value="V"  <?php if($_GET['yoy']=='V'){ echo "checked";} ?> onChange="javascript:valueconversion('V',<?php echo $_GET['vcid']; ?>);" checked="checked" /> Value</label>
    <label class="cagrlabel">   <input type="radio" name="yoy" id="cagr" value="G"  <?php if($_GET['yoy']=='G'){ echo "checked";} ?> onChange="javascript:valueconversion('G',<?php echo $_GET['vcid']; ?>);" /> Growth</label> 
    <select onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
        <option>-- select currency --</option>
        <option value="GBP" <?php if($_GET['queryString']=='GBP'){ echo "selected";} ?>>British Pound GBP</option>
        <option value="EUR" <?php if($_GET['queryString']=='EUR'){ echo "selected";} ?>>Euro EUR</option>
        <option value="USD" <?php if($_GET['queryString']=='USD'){ echo "selected";} ?>>US Dollar USD</option>
        <option value="JPY" <?php if($_GET['queryString']=='JPY'){ echo "selected";} ?>>Japanese Yen JPY</option>
        <option value="CNY" <?php if($_GET['queryString']=='CNY'){ echo "selected";} ?>>Chinese Yuan CNY</option>
        <option value="AUD" <?php if($_GET['queryString']=='AUD'){ echo "selected";} ?>>Australian Dollar AUD</option>
        <option value="CHF" <?php if($_GET['queryString']=='CHF'){ echo "selected";} ?>>Swiss Franc CHF</option>
        <option value="CAD" <?php if($_GET['queryString']=='CAD'){ echo "selected";} ?>>Canadian Dollar CAD</option>
        <option value="THB" <?php if($_GET['queryString']=='THB'){ echo "selected";} ?>>Thai Baht THB</option>
        <option value="INR" <?php if($_GET['queryString']=='INR'){ echo "selected";} ?>>Indian Rupee INR</option>
        <option value="IDR" <?php if($_GET['queryString']=='IDR'){ echo "selected";} ?>>Indonesian Rupiah IDR</option>
        <option value="HKD" <?php if($_GET['queryString']=='HKD'){ echo "selected";} ?>>Hong Kong Dollar HKD</option>
    </select>  
</div>
<?php if($_GET['queryString']=='INR'){ ?>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
        <option  value="l" <?php if($_GET['rconv']=='l'){ echo "selected";} ?>>Lakhs</option>
    </select> </div>
<?php }else{ ?>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
         </select> </div>
    <?php } ?>
</div>

    <!-- <?php }
    
       
        ?> -->
       
<?php  if(count($FinanceAnnual1) > 0 && count($FinanceAnnual1_new) > 0){ ?>
<div style="margin:1% 0;" class=" tab_menu" id="templateShow">
    <label for="new_temp"> <input type="radio" name="balsheet" value="2" id="new_temp" class="template" onChange="javascript:balsheet_ch();" checked="checked"  > New Template</label>
    <label for="old_temp"> <input type="radio" name="balsheet" value="1" id="old_temp" class="template" onChange="javascript:balsheet_ch();" > Old Template</label>
</div>
<?php } ?>

<div id="balancesheet" class=" tab_menu">
<!-- <h4 style="font-size: 18px;margin-bottom: 10px;position: absolute;margin-top: 20px;"><?php echo $runTypetext; ?> / <?php echo $resultTypetext; ?></h4> -->
<?php      

 if(count($FinanceAnnual1_new) > 0){
     $Fbcount=0;
     for($i=0;$i<count($FinanceAnnual1_new);$i++){
         if($FinanceAnnual1_new[$i][FY] !=05 && $FinanceAnnual1_new[$i][FY]!=06)
         {
             $Fbcount++;
         }
     }
    /* if($Fbcount > 0)
     {*/
    ?>
     <?php  if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls')){
            $BSHEET_MEDIA_PATH_NEW=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls';
            
               
        }
        if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls')){
            $BSHEET_MEDIA_PATH_NEW1=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls';
                
        }
        
        if ($BSHEET_MEDIA_PATH_NEW || $BSHEET_MEDIA_PATH_NEW1) {?>
        
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 0px !important;"> 
                  <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="openbalancesheet_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />

                  <div id="balancesheet_ex" style="position: absolute; width: 100%; display: none;  right: 0; text-align: right;padding-right: 18px;">
                  <?php if($BSHEET_MEDIA_PATH_NEW){?>
               <!-- <input  name="" type="button" value="Standalone" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
               <input  name="bsexportcompare"  type="button" value="Standalone"  id="bsexportcompare" style="  width: 180px;border-top: 0;" />
               <?php } if ($BSHEET_MEDIA_PATH_NEW1){?>
               <!-- <input  name="" type="button" value="Consolidated" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}_1.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
               <input  name="bsconexportcompare" type="button" value="Consolidated"  id="bsconexportcompare" style="  width: 180px;border-top: 0;" />
               <?php }?>
                  </div>
                  </span> 
                  <?php }else{?>
                    <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 0px !important;"> 
                    <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="bsDataUpdateReq()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />
                </span>
                  <?php }?>

                   <div class="finance-filter-custom" style="padding-top: 0px;">
                   <select class="currencyselection" onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
        <option>-- select currency --</option>
       
        <option value="USD" <?php if($_GET['queryString']=='USD'){ echo "selected";} ?>>USD</option>
        <option value="INR" <?php if($_GET['queryString']=='INR'){ echo "selected";} ?>>INR</option>
        
    </select>  <span class="incurrency" > in </span>
<?php if($_GET['queryString']=='INR'){ ?>
    <select class="currencyconversion" name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
        <option  value="l" <?php if($_GET['rconv']=='l'){ echo "selected";} ?>>Lakhs</option>
    </select>
<?php }else{ ?>
    <select class="currencyconversion" name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
         </select> 
    <?php } ?>
</div>

<div id="new_balsheet" style="clear:both;">
    <?php $rowtype=mysql_query("select ResultType from balancesheet_new where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
     ?>
   <div class="resulttype-value" style="font-size: 16px;/*margin-bottom: 10px;margin-top: -45px;*/">
    <?php if($resulttypecount==2) {?>
  <ul class="primary">
        <li class="current subMenu consolidated" data-row="balancesheet" onclick ="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
         <li class="subMenu standalone" data-row="balancesheet" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
   </ul>
   <?php } else if($resulttypecount==1){
     
    ?><ul class="secondary"><?php
        if($resulttypearray[ResultType]==0){
        ?>
       
            <li class="current subMenu" data-row="balancesheet" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
  
   <?php } else if($resulttypearray[ResultType]==1){?>
         
             <li class="current subMenu" data-row="balancesheet" onclick="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
             
        <?php } } ?>
        </ul>
        <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
    </div>
    <div class="detail-table-div" style="float: left;">
        <table  width="110%" border="0" cellspacing="0" cellpadding="0">
            <tHead> 
                <tr>
                    <th>Particulars</th>
                </tr>
                
            </thead>
            <tbody>
               <tr>
                 <td><b>SOURCES OF FUNDS</b></td>
              </tr>
              <tr>
                <td>Share capital</td>
              </tr>
              <tr>
                <td>Reserves and surplus</td>
              </tr>
              <tr>
                  <td><b>Total shareholders' funds</b></td>
              </tr>
              <tr>
                <td>Share application pending allotment</td>
              </tr>
             <!-- Changes - xbrl2 -->
               <?php $showminority_interest = false;$count = 0;
                for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                    if($FinanceAnnual1_new[$i][minority_interest] != 0 && $FinanceAnnual1_new[$i][minority_interest] != ''){
                        $count++;
                        if($count > 1){
                            $showminority_interest = true;
                        }
                    } 
                } ?>
              <?php if($resulttype[0][ResultType] == 1 && $showminority_interest == 1) { ?>
                <tr>
                    <td>Minority Interest</td>
                </tr>
              <?php } ?>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>Non-current liabilities [Abstract]</b></td>
              </tr>
              <tr>
                <td>Long-term borrowings</td>
              </tr>
              <tr>
                <td>Deferred tax liabilities (net)</td>
              </tr>
              <tr>
                <td>Other long-term liabilities</td>
               </tr>
              <tr>
                <td>Long-term provisions</td>
              </tr>
              <tr>
                  <td><b>Total non-current liabilities</b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>Current liabilities [Abstract]</b></td>
              </tr>
              <tr>
                <td>Short-term borrowings</td>
              </tr>
              <tr>
                <td>Trade payables</td>
              </tr>
               <tr>
                <td>Other current liabilities</td>
              </tr>
              <tr>
                <td>Short-term provisions</td>
              </tr>
              <tr>
                <td><b>Total current liabilities</b></td>
              </tr>
              <tr>
                <td><b>Total equity and liabilities</b></td>
               </tr>
               <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>Assets [Abstract]</b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
               <tr>
                <td><b>Non-current assets [Abstract]</b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>Fixed assets [Abstract]</b></td>
              </tr>
              <tr>
                <td>Tangible assets</td>
               </tr>
              <tr>
                <td>Intangible assets</td>
              </tr>
              <tr>
                <td>Total fixed assets</td>
              </tr>
               <tr>
                <td>Non-current investments</td>
              </tr>
              <tr>
                <td>Deferred tax assets (net)</td>
              </tr>
              <tr>
                <td>Long-term loans and advances</td>
               </tr>
              <tr>
                <td>Other non-current assets</td>
              </tr>
               <tr>
                <td><b>Total non-current assets</b></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>Current assets [Abstract]</b></td>
              </tr>
              <tr>
                <td>Current investments</td>
               </tr>
              <tr>
                <td>Inventories</td>
              </tr>
              <tr>
                <td>Trade receivables</td>
              </tr>
              <tr>
                <td>Cash and bank balances</td>
              </tr>
              <tr>
                <td>Short-term loans and advances</td>
               </tr>
              <tr>
                <td>Other current assets</td>
              </tr>
              <tr>
                <td><b>Total current assets</b></td>
              </tr>
              <tr>
                <td><b>Total assets</b></td>
              </tr>
           
                 
            </tbody>
            </table>
    </div>
    <div class="tab-res" style="overflow-x: auto; margin:0px 0 !important;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tHead> <tr>
            
            <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                $str     = $FinanceAnnual1_new[$i][FY];
                $order   = array("(", ")");
                $replace = ' '; 
                $FY = str_replace($order, $replace, $str);
                if($_GET['queryString']!='INR'){?>
            <th>FY <?php echo $FY;?></th>
            <?php
                }
                else
                {
                    ?>
            <th>FY <?php echo $FY;?></th>
            <?php
                }
            }
            ?>
            </tr>
            <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
            
            </thead>
            <tbody>  
             
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ShareCapital],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][ShareCapital]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][ShareCapital]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][ShareCapital]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                  if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ReservesSurplus],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][ReservesSurplus]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><?php if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][ReservesSurplus]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                  <?php } else { ?>
                      <td><?php if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][ReservesSurplus]/$convalue);echo round($tot,2); } ?></td>
                  <?php } ?>
                  <?php
              }
                
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                  if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][TotalFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][TotalFunds]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><?php if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][TotalFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                  <?php } else { ?>
                      <td><?php if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][TotalFunds]/$convalue);echo round($tot,2); } ?></td>
                  <?php } ?>
                  <?php
              }
                
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                    if($_GET['queryString']!='INR'){?>
                      <td><?php
                     if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                      if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ShareApplication],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }else{
                      if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][ShareApplication]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }
                     ?></td>
                     <?php
                  }
                  else
                  { 
                      ?> 
                      <?php if($_GET['rconv'] =='r'){ ?>
                          <td><?php if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][ShareApplication]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                      <?php } else { ?>
                          <td><?php if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][ShareApplication]/$convalue);echo round($tot,2); } ?></td>
                      <?php } ?>
                      <?php
                  }
                
            }
            ?>
              </tr>
              <!-- Changes - xbrl2 -->
              <?php $showminority_interest = false;$count = 0;
                for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                    if($FinanceAnnual1_new[$i][minority_interest] != 0 && $FinanceAnnual1_new[$i][minority_interest] != ''){
                        $count++;
                        if($count > 1){
                            $showminority_interest = true;
                        }
                    } 
                } ?>
                <?php if($resulttype[0][ResultType] == 1 && $showminority_interest == 1) { ?>
                <tr>
                
                    <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                       if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual1_new[$i][minority_interest]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][minority_interest],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual1_new[$i][minority_interest]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][minority_interest]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual1_new[$i][minority_interest]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][minority_interest]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual1_new[$i][minority_interest]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][minority_interest]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
                    
                    }
                    ?>
                    </tr>
                <?php } ?>
              <!-- Changes - xbrl2 -->
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_borrowings],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][L_term_borrowings]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][L_term_borrowings]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][L_term_borrowings]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][deferred_tax_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][deferred_tax_liabilities]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][deferred_tax_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][deferred_tax_liabilities]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_long_term_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_long_term_liabilities]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_long_term_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_long_term_liabilities]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                    if($_GET['queryString']!='INR'){?>
                      <td><?php
                     if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                      if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_provisions],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }else{
                      if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][L_term_provisions]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }
                     ?></td>
                     <?php
                  }
                  else
                  { 
                      ?> 
                      <?php if($_GET['rconv'] =='r'){ ?>
                          <td><?php if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][L_term_provisions]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                      <?php } else { ?>
                          <td><?php if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][L_term_provisions]/$convalue);echo round($tot,2); } ?></td>
                      <?php } ?>
                      <?php
                  }
                  
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_non_current_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_non_current_liabilities]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_non_current_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_non_current_liabilities]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
              
               
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              
             
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_borrowings],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][S_term_borrowings]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][S_term_borrowings]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][S_term_borrowings]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
              
               
               
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Trade_payables],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Trade_payables]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Trade_payables]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Trade_payables]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_current_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_current_liabilities]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_current_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_current_liabilities]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_provisions],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][S_term_provisions]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][S_term_provisions]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][S_term_provisions]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_current_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_current_liabilities]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_current_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_current_liabilities]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                
               
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_equity_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_equity_liabilities]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_equity_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_equity_liabilities]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                
               
               
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
               <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Tangible_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Tangible_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Tangible_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Tangible_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
               
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Intangible_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Intangible_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Intangible_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Intangible_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_fixed_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_fixed_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_fixed_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_fixed_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
               }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][N_current_investments],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][N_current_investments]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][N_current_investments]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][N_current_investments]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
               
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Deferred_tax_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Deferred_tax_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Deferred_tax_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Deferred_tax_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
              }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_loans_advances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][L_term_loans_advances]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][L_term_loans_advances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][L_term_loans_advances]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
               
            }
            ?>
              </tr>
             
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_non_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_non_current_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_non_current_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_non_current_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
              }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_non_current_asT_non_current_assetssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_non_current_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_non_current_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_non_current_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
               
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Current_investments]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Current_investments],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Current_investments]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Current_investments]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Current_investments]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Current_investments]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Current_investments]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Current_investments]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
               
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                    if($_GET['queryString']!='INR'){?>
                      <td><?php
                     if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                      if($FinanceAnnual1_new[$i][Inventories]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Inventories],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }else{
                      if($FinanceAnnual1_new[$i][Inventories]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Inventories]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }
                     ?></td>
                     <?php
                  }
                  else
                  { 
                      ?> 
                      <?php if($_GET['rconv'] =='r'){ ?>
                          <td><?php if($FinanceAnnual1_new[$i][Inventories]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Inventories]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                      <?php } else { ?>
                          <td><?php if($FinanceAnnual1_new[$i][Inventories]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Inventories]/$convalue);echo round($tot,2); } ?></td>
                      <?php } ?>
                      <?php
                  }
                 
               
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Trade_receivables],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Trade_receivables]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Trade_receivables]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Trade_receivables]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
             <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Cash_bank_balances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Cash_bank_balances]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Cash_bank_balances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Cash_bank_balances]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
               
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_loans_advances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][S_term_loans_advances]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][S_term_loans_advances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][S_term_loans_advances]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_current_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_current_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][O_current_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_current_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_current_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_current_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
             
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                    if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Total_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Total_assets]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Total_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Total_assets]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
            
               
                
            }
            ?>
              </tr>
              
              
            </tbody>
            </table> 

    </div>

</div>
    <?php
    // }
 
     }     
     
    ?>


    <?php
 if(count($FinanceAnnual1) > 0){
     $Fbcount=0;
     for($i=0;$i<count($FinanceAnnual1);$i++){
         if($FinanceAnnual1[$i][FY] !=05 && $FinanceAnnual1[$i][FY]!=06)
         {
             $Fbcount++;
         }
     }
    /* if($Fbcount > 0)
     {*/
    ?>
    <!-- <span class="btn-cnt" style="position: relative;float:right;height: 62px;">  -->
                  
                </span>
<div id="old_balsheet" style="clear:both;<?php if(count($FinanceAnnual1_new) > 0){ ?> display: none; <?php } ?>">
     <?php $rowtype=mysql_query("select ResultType from balancesheet where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
      while($resulttypearray=mysql_fetch_array($rowtype))
      {
    ?>
   <div class="resulttype-value" style="font-size: 16px;/*margin-bottom: 10px;margin-top: -45px;*/">
    <?php if($resulttypecount==2) {?>
   <ul class="primary">
        <li class="current subMenu consolidated" data-row="balancesheet" onclick ="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
        <li class="subMenu standalone" data-row="balancesheet" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
   </ul>
   <?php } else if($resulttypecount==1){
      
    ?><ul class="secondary"><?php
     if($resulttypearray[ResultType]==0){
        ?>
        <li class="current subMenu" data-row="balancesheet" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>

   <?php } else if($resulttypearray[ResultType]==1){?>
        
        <li class="current subMenu" data-row="balancesheet" onclick="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
            
        <?php } } ?>
        </ul>
        <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:8px;"><?php echo $runTypetext; ?></span></h4>
    </div> <?php  } ?>
    <div class="detail-table-div" style="float:left;">
        <table  width="110%" border="0" cellspacing="0" cellpadding="0">
            <tHead> 
                <tr>
                    <th>Particulars</th>
                </tr>
                
            </thead>
            <tbody>
               <tr>
                 <td><b>SOURCES OF FUNDS</b></td>
              </tr>
              <tr>
                <td><b>Shareholders' funds</b></td>
              </tr>
              <tr>
                <td>Paid-up share capital</td>
              </tr>
              <tr>
                <td>Share application</td>
              </tr>
              <tr>
                <td>Reserves & Surplus</td>
              </tr>
              <tr>
                <td><b>Shareholders' funds(total)</b></td>
              </tr>
              <tr>
                <td><b>Loan funds</b></td>
              </tr>
              <tr>
                <td>Secured loans</td>
               </tr>
              <tr>
                <td>Unsecured loans</td>
              </tr>
              <tr>
                <td><b>Loan funds(total)</b></td>
              </tr>
              <tr>
                <td><b>Other Liabilities</b></td>
              </tr>
              <tr>
                <td><b>Deferred Tax Liability</b></td>
              </tr>
              <tr>
                <td><b>TOTAL SOURCES OF FUNDS</b></td>
              </tr>
               <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><b>APPLICATION OF FUNDS</b></td>
              </tr>
              <tr>
                <td><b>Fixed assets</b></td>
              </tr>
              <tr>
                <td>Gross Block</td>
               </tr>
              <tr>
                <td>Less : Depreciation Reserve</td>
              </tr>
               <tr>
                <td>Net Block</td>
              </tr>
              <tr>
                <td>Add : Capital Work in Progress</td>
              </tr>
              <tr>
                <td><b>Fixed Assets(total)</b></td>
               </tr>
              <tr>
                <td><b>Intangible Assets(total)</b></td>
              </tr>
              <tr>
                <td><b>Other Non-Current Assets</b></td>
              </tr>
               <tr>
                <td><b>Investments</b></td>
              </tr>
              <tr>
                <td><b>Deferred Tax Assets</b></td>
              </tr>
              <tr>
                <td><b>Current Assets, Loans & Advances</b></td>
               </tr>
              <tr>
                <td>Sundry Debtors</td>
              </tr>
               <tr>
                <td>Cash & Bank Balances</td>
              </tr>
              <tr>
                <td>Inventories</td>
              </tr>
              <tr>
                <td>Loans & Advances</td>
               </tr>
              <tr>
                <td>Other Current Assets</td>
              </tr>
              <tr>
                <td><b>Current Assets,Loans&Advances(total)</b></td>
              </tr>
              <tr>
                <td><b>Current Liabilities & Provisions</b></td>
              </tr>
              <tr>
                <td>Current Liabilities</td>
               </tr>
              <tr>
                <td>Provisions</td>
              </tr>
              <tr>
                <td><b>Current Liabilities & Provisions(total)</b></td>
              </tr>
              <tr>
                <td><b>Net Current Assets</b></td>
              </tr>
              <tr>
                <td><b>Profit & Loss Account</b></td>
               </tr>
              <tr>
                <td><b>Miscellaneous Expenditure</b></td>
              </tr>
              <tr>
                <td><b>TOTAL APPLICATION OF FUNDS<b></td>
              </tr>
                 
            </tbody>
            </table>
    </div>
     <div class="tab-res" style="overflow-x: auto; margin:0px 0 !important;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tHead> <tr>
            
            <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
 
                $str     = $FinanceAnnual1[$i][FY];
                $order   = array("(", ")");
                $replace = ' '; 
                $FY = str_replace($order, $replace, $str);
                if($_GET['queryString']!='INR'){?>
            <th>FY <?php echo $FY;?></th>
            <?php
                }
                else
                {
                    ?>
            <th>FY <?php echo $FY;?></th>
            <?php
                }
            }
            ?>
            </tr></thead>
            <tbody>  
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][ShareCapital],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '0';}else{ $tot=($FinanceAnnual1[$i][ShareCapital]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                    <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '0';}else{ $tot=($FinanceAnnual1[$i][ShareCapital]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                        <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][ShareApplication],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                      <?php
                }
                else
                {
                    ?>  
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][ShareApplication]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                    <td><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][ShareApplication]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                       <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][ReservesSurplus],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
                       <?php
                }
                else
                {
                    ?>
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][ReservesSurplus]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                    <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][ReservesSurplus]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][TotalFunds]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][TotalFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></b></td>
                      <?php
                }
                else
                {
                    ?>
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][TotalFunds]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][TotalFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                    <td><b><?php if($FinanceAnnual1[$i][TotalFunds]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][TotalFunds]/$convalue);echo round($tot,2); } ?></b></td>
                    <?php } ?>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][SecuredLoans],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][SecuredLoans]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                    <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][SecuredLoans]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                                 <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][UnSecuredLoans],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][UnSecuredLoans]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                    <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][UnSecuredLoans]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][LoanFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></b></td>
                  <?php
                }
                else
                {
                    ?>    
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][LoanFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                    <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][LoanFunds]/$convalue);echo round($tot,2); } ?></b></td>
                    <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherLiabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></b></td>
               <?php
                }
                else
                {
                    ?>    
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherLiabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                      <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherLiabilities]/$convalue);echo round($tot,2); } ?></b></td>
                      <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][DeferredTax],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
              <?php
                }
                else
                {
                    ?>     
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '0';}else{ $tot=($FinanceAnnual1[$i][DeferredTax]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?> 
                     <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '0';}else{ $tot=($FinanceAnnual1[$i][DeferredTax]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][SourcesOfFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></b></td>
                <?php
                }
                else
                {
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][SourcesOfFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>   
                    <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][SourcesOfFunds]/$convalue);echo round($tot,2); } ?></b></td>
                    <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                   <?php
                }
                else
                {
                    ?> 
                    <td>&nbsp;</td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][GrossBlock],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][GrossBlock]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][GrossBlock]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][LessAccumulated],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][LessAccumulated]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][LessAccumulated]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][NetBlock],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][NetBlock]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][NetBlock]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CapitalWork],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CapitalWork]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CapitalWork]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][FixedAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][FixedAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][FixedAssets]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][IntangibleAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][IntangibleAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][IntangibleAssets]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherNonCurrent],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherNonCurrent]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherNonCurrent]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Investments],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Investments]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Investments]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][DeferredTaxAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][DeferredTaxAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][DeferredTaxAssets]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                <?php
                }
                else
                {
                    ?>     
                     <td>&nbsp;</td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][SundryDebtors],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][SundryDebtors]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][SundryDebtors]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CashBankBalances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CashBankBalances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CashBankBalances]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Inventories],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Inventories]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Inventories]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][LoansAdvances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][LoansAdvances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][LoansAdvances]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherCurrentAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherCurrentAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherCurrentAssets]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CurrentAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CurrentAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CurrentAssets]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td>&nbsp;</td>
                <?php
                }
                else
                {
                    ?>     
                     <td>&nbsp;</td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Provisions],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Provisions]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                     <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Provisions]/$convalue);echo round($tot,2); } ?></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CurrentLiabilitiesProvision],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CurrentLiabilitiesProvision]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CurrentLiabilitiesProvision]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][NetCurrentAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][NetCurrentAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][NetCurrentAssets]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][ProfitLoss],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][ProfitLoss]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][ProfitLoss]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Miscellaneous],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Miscellaneous]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Miscellaneous]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                    $totalAsserts = $FinanceAnnual1[$i][FixedAssets] + $FinanceAnnual1[$i][IntangibleAssets] + $FinanceAnnual1[$i][OtherNonCurrent] + $FinanceAnnual1[$i][Investments] + $FinanceAnnual1[$i][DeferredTaxAssets] + $FinanceAnnual1[$i][NetCurrentAssets] + $FinanceAnnual1[$i][ProfitLoss] + $FinanceAnnual1[$i][Miscellaneous]; 
                    $FinanceAnnual1[$i][TotalAssets] = ($FinanceAnnual1[$i][TotalAssets]==0)? $totalAsserts : $FinanceAnnual1[$i][TotalAssets];                
                                      
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][TotalAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                       <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][TotalAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                    <?php } else { ?>
                     <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][TotalAssets]/$convalue);echo round($tot,2); } ?></b></td>
                     <?php } ?>
             <?php
                }
            }
            ?>
              </tr>
            </tbody>
            </table> 

    </div>

</div>    
    <?php
    // }
 
     }
     
    ?>
</div>
<!--cashflow start-->


 
<!--cashflow end-->


<div id="maskscreen"></div>
<div class="lb" id="bsexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackBS.php?vcid=<?php echo $_GET['vcid'];?>','_blank')" class="agree-bsexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div id="maskscreen"></div>
<div class="lb" id="bsconexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackBS.php?vcid=<?php echo $_GET['vcid'];?>&type=consolidated','_blank')" class="agree-bsconexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>

<script type="text/javascript" >
$(document).ready(function(){
  if($('.cfs_menu').length > 1){
      $('.cfs_menu').eq(1).remove();
  }
  if($('.finance-filter-custom').length > 1){
      $('.finance-filter-custom').eq(1).remove();
  }
});
$('input[name=bsexportcompare]#bsexportcompare').click(function(){
              jQuery('#balancesheet_parent #maskscreen').fadeIn(1000);
              $( '#bsexport-popup' ).show();
              return false; 
            });
        $( '.agree-bsexport').on( 'click', function() {    
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
            $( '#bsexport-popup' ).hide();
            return false;
        });
        $( '#bsexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#bsexport-popup' ).hide();
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
        });
$('input[name=bsconexportcompare]#bsconexportcompare').click(function(){
              jQuery('#balancesheet_parent #maskscreen').fadeIn(1000);
              $( '#bsconexport-popup' ).show();
              return false; 
            });
        $( '.agree-bsconexport').on( 'click', function() {    
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
            $( '#bsconexport-popup' ).hide();
            return false;
        });
        $( '#bsconexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#bsconexport-popup' ).hide();
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
        });
        
$(document).ready(function(){
$( '.cagrlabel' ).hide();


});


// function resulttypestandalone(vcid1){
  
//     $('#pgLoading').show();
//     var ccur1 = $('#currencytype').val();
//     var inputString= $('#ccur').val();
//     $.get("ajaxstandalone.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
//             $('#result').html(data);
//                         $('#pgLoading').hide();
//             $('.displaycmp').hide();
//                         $('#stMsg').hide();
//                        $(".cfs_menu ul li").removeClass('current');
//                        var row = $('#activeSubmenu').val();
//                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
//                         tabMenu(row);
//                         resetfoundation();
           
//         });
// }
// var clickflagprofitloss = 0;
// function plresult(vcid1){
//   if(clickflagprofitloss == 0){
//     $('#pgLoading').show();
//     var ccur1 = $('#currencytype').val();
//     var inputString= $('#ccur').val();
//     $.get("ajaxmilliCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
//          clickflagprofitloss=1;
//             $('#result').html(data);
           
//                         $('#pgLoading').hide();
//             $('.displaycmp').hide();
//                         $('#stMsg').hide();
//                        $(".cfs_menu ul li").removeClass('current');
//                        var row = $('#activeSubmenu').val();
//                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
//                         tabMenu(row);
//                         resetfoundation();
           
//         });
//     }
// }
// var clickflagbalancesheet = 0;
// function balancesheetresult(vcid1){
//   if(clickflagbalancesheet == 0){
//     $('#pgLoading').show();
//     var ccur1 = $('#currencytype').val();
//     var inputString= $('#ccur').val();
//     $.get("ajax_balancesheet.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
//          clickflagbalancesheet=1;
//             $('#result').html(data);
           
//                         $('#pgLoading').hide();
//             $('.displaycmp').hide();
//                         $('#stMsg').hide();
//                        $(".cfs_menu ul li").removeClass('current');
//                        var row = $('#activeSubmenu').val();
//                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
//                         tabMenu(row);
//                         resetfoundation();
           
//         });
//     }
// }
// var clickflagcashflow = 0;
// function cfresult(vcid1){
//    if(clickflagcashflow == 0){
//     $('#pgLoading').show();
//     var ccur1 = $('#currencytype').val();
//     var inputString= $('#ccur').val();
//     $.get("ajax_cashflow.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
//          clickflagcashflow=1;
//             $('#result').html(data);
           
//                         $('#pgLoading').hide();
//             $('.displaycmp').hide();
//                         $('#stMsg').hide();
//                        $(".cfs_menu ul li").removeClass('current');
//                        var row = $('#activeSubmenu').val();
//                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
//                         tabMenu(row);
//                         resetfoundation();
           
//         });
//     }
// }
// var clickflagratio = 0;
// function ratioresult(vcid1){
//    if(clickflagratio == 0){
//     $('#pgLoading').show();
//     var ccur1 = $('#currencytype').val();
//     var inputString= $('#ccur').val();
//     $.get("ajax_ratio.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
//          clickflagratio=1;
//             $('#result').html(data);
           
//                         $('#pgLoading').hide();
//             $('.displaycmp').hide();
//                         $('#stMsg').hide();
//                        $(".cfs_menu ul li").removeClass('current');
//                        var row = $('#activeSubmenu').val();
//                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
//                         tabMenu(row);
//                         resetfoundation();
           
//         });
//     }
// }
    </script>
<?php mysql_close(); ?>