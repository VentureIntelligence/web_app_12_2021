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
</style>
<?php
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
include_once('conversionarray.php');

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
$resulttypecashflow = $cashflow->getFieldValue($fieldsresulttype,$whereresulttype,"name");
if($resulttype[0][ResultType] == 0){
    $resultTypetext = "Standalone";
} else {
    $resultTypetext = "Consolidated";
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
$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='".$resulttype[0][ResultType]."' and a.ResultType='".$resulttype[0][ResultType]."'";
$where_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='0'";
//Changes done for xbrl2
$wherebs_new_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttype[0][ResultType]."'";
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
        <li class="current subMenu" data-row="profit-loss" href="javascript:;" onclick="javascript:plresult(<?php echo $_GET['vcid'];?>);">PROFIT &amp; LOSS</li>
        <li data-row="balancesheet" href="javascript:;" class="subMenu" onclick="javascript:balancesheetresult(<?php echo $_GET['vcid'];?>);">BALANCE SHEET</li>
        <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; echo 'onclick=javascript:cfresult('.$_GET['vcid'].')'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> id="cashMenu" >CASH FLOW</li>
        <!-- <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> onclick="javascript:cfresult(<?php echo $_GET['vcid'];?>);">CASH FLOW</li> -->
        <li data-row="ratio" href="javascript:;" class="subMenu" onclick="javascript:ratioresult(<?php echo $_GET['vcid'];?>);">RATIOS</li>
       <li data-row="companyProfile" href="javascript:;" class="subMenu" id="companyProfileMenu">CO. PROFILE</li>
        <li data-row="filings" href="javascript:;" class="subMenu" id="filingsMenu">FILINGS</li>
        <!-- <li data-row="rating-info" href="javascript:;" class="subMenu">RATINGS</li> -->
        <li data-row="funding-ajax" href="javascript:;" class="subMenu" id="funding">FUNDING</li>
        <li data-row="ma-ajax" href="javascript:;" class="subMenu" id="mamenu">M&A</li>
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

<!--cashflow start-->
<div class="tab_menu" id="cashflow" style="display:none;margin-top: 10px;">
 <?php
    if( $companyDetails[0]['listingstatus'] == 1 ) {
        //$style = 'display: none;';
        $style = '';
    } else {
        $style = '';
    }
?> 

<?php 
    if(count($FinanceAnnual_cashflow) > 0){
     $Fycount=0;
     for($i=0;$i<count($FinanceAnnual_cashflow);$i++){
         if($FinanceAnnual_cashflow[$i][FY] !='' && $FinanceAnnual_cashflow[$i][FY]>0)
         {
             $Fycount++;
         }
     }
     if($Fycount > 0)
     {
         if(file_exists(FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls')){
            $CASHFLOW_MEDIA_PATH=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls';
           // echo "cF:".$CASHFLOW_MEDIA_PATH;exit();
            
               
        }
        if(file_exists(FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls')){
            $CASHFLOW_MEDIA_PATH_NEW1=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls';
            // echo "cF1:".$CASHFLOW_MEDIA_PATH_NEW1;exit();
                
        }
        
        if ($CASHFLOW_MEDIA_PATH || $CASHFLOW_MEDIA_PATH_NEW1) {?>
        
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 0px !important;"> 
                  <input  name="" type="button" id="check1" data-check2="close" value="CASHFLOW EXPORT" onClick="cashflow_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />

                  <div id="cashflow_ex" style="position: absolute; width: 100%; display: none;  right: 0; text-align: right;padding-right: 18px;">
                  <?php if($CASHFLOW_MEDIA_PATH){?>
               <!-- <input  name="" type="button" value="Standalone" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
               <input  name="cfexportcompare"  type="button" value="Standalone"  id="cfexportcompare" style="  width: 180px;border-top: 0;" />
               <?php } if ($CASHFLOW_MEDIA_PATH_NEW1){?>
               <!-- <input  name="" type="button" value="Consolidated" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}_1.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
               <input  name="cfconexportcompare" type="button" value="Consolidated"  id="cfconexportcompare" style="  width: 180px;border-top: 0;" />
               <?php }?>
                  </div>
                  </span> 
                  <?php }





       
         ?>

          <div class="finance-filter-custom" style="padding-top: 0px;">
          <select class="currencyselection" onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
         
        <option value="INR" <?php if($_GET['queryString']=='INR'){ echo "selected";} ?>>INR</option>
        <option value="USD" <?php if($_GET['queryString']=='USD'){ echo "selected";} ?>>USD</option>
        
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

<div style="clear:both;">
    <!-- <h4 style="font-size: 18px;margin-bottom: 10px;position: absolute;margin-top: -42px;"><?php echo $runTypetext; ?> / <?php echo $resultTypetextcashflow; ?></h4> -->
    <?php $rowtype=mysql_query("select ResultType from cash_flow where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
    ?>
   <div class="resulttype-value" style="font-size: 16px;/*margin-bottom: 10px;margin-top: -45px;*/">
    <?php 
   
    if($resulttypecount==2) {?>
   <ul class="primary">
        <li class="current subMenu consolidated" data-row="cashflow" onclick ="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
        <li class="subMenu standalone" data-row="cashflow" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
   </ul>
   <?php } else if($resulttypecount==1){
      ?><ul class="secondary"><?php
        if($resultTypetextcashflow=="Standalone"){
        ?>
        <li class="current subMenu" data-row="cashflow" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
  
   <?php } else if($resultTypetextcashflow=="Consolidated"){?>
        
        <li class="current subMenu" data-row="cashflow" onclick="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
        <?php } } ?>
        </ul>
        <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
    </div>
    <div class="detail-table-div" style="float: left;">
        <table  width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead> 
                <tr>
                    <th>Particulars</th>
                </tr>
            </thead>
            <tbody>  
              <tr>
                <td><b>Statement of cash flows</b></td>
              </tr>
              <tr>
                <td><b>Net Profit/Loss Before Extraordinary Items And Tax</b></td>
              </tr>
              <tr>
                <td>Net CashFlow From Operating Activities</td>
              </tr>
              <tr>
                <td>Net Cash Used In Investing Activities</td>
              </tr>
              <tr>
                <td>Net Cash Used From Financing Activities</td>
              </tr>
              <tr>
                <td><b>Net Inc/Dec In Cash And Cash Equivalents</b></td>
               </tr>
              <tr>
                <td>Cash And Cash Equivalents End Of Year</td>
              </tr>
             
            </tbody>
            </table>
    </div>

    <div class="tab-res" style="overflow-x: auto; margin:10px 0 !important;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <thead> <tr>
            
            <?php for($i=0;$i<count( $FinanceAnnual_cashflow);$i++){ 
                $str     =  $FinanceAnnual_cashflow[$i][FY];
                $order   = array("(", ")");
                $replace = ' '; 
                $FY = str_replace($order, $replace, $str);
                if($_GET['queryString']!='INR'){ ?>
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
 
                 <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
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
 
                <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
                    if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual_cashflow[$i][NetPLBefore]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetPLBefore],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual_cashflow[$i][NetPLBefore]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetPLBefore]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetPLBefore]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetPLBefore]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetPLBefore]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetPLBefore]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
                
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
                     if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual_cashflow[$i][CashflowFromOperation]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][CashflowFromOperation],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual_cashflow[$i][CashflowFromOperation]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][CashflowFromOperation]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][CashflowFromOperation]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][CashflowFromOperation]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][CashflowFromOperation]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][CashflowFromOperation]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
                    if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetcashUsedInvestment],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetcashUsedInvestment]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
               
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
                    if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual_cashflow[$i][NetcashFromFinance]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetcashFromFinance],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual_cashflow[$i][NetcashFromFinance]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetcashFromFinance]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetcashFromFinance]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetcashFromFinance]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetcashFromFinance]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetcashFromFinance]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
               
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
                     if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual_cashflow[$i][NetIncDecCash]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetIncDecCash],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual_cashflow[$i][NetIncDecCash]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetIncDecCash]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetIncDecCash]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetIncDecCash]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][NetIncDecCash]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][NetIncDecCash]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual_cashflow);$i++){ 
                     if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$FinanceAnnual1_new[$i][FY]] ==''){
                        if($FinanceAnnual_cashflow[$i][EquivalentEndYear]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][EquivalentEndYear],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }else{
                        if($FinanceAnnual_cashflow[$i][EquivalentEndYear]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][EquivalentEndYear]*$yearcurrency[$FinanceAnnual1_new[$i][FY]];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                       }
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][EquivalentEndYear]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][EquivalentEndYear]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                        <?php } else { ?>
                            <td><?php if($FinanceAnnual_cashflow[$i][EquivalentEndYear]==0){echo '-';}else{$tot=($FinanceAnnual_cashflow[$i][EquivalentEndYear]/$convalue);echo round($tot,2); } ?></td>
                        <?php } ?>
                        <?php
                    }
               
            }
            ?>
              </tr>
             
             <?php
            }
            ?>
            </tbody>
            </table> 

    </div>
    <?php }
 ?>    
 </div>
</div>

 
<!--cashflow end-->

<div id="maskscreen"></div>
<div class="lb" id="cfexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <!-- <b><a href="javascript:;" onClick="window.open('<?php //echo MEDIA_PATH;?>cashflow_xbrl2/CASHFLOW_<?php //echo $_GET['vcid'];?>.xls','_blank')" class="agree-cfexport">I Agree</a></b><b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
      <b><a href="javascript:;" onClick="window.open('downloadtrackCF.php?vcid=<?php echo $_GET['vcid'];?>&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-cfexport">I Agree</a></b>
  </div>
</div>
<div id="maskscreen"></div>
<div class="lb" id="cfconexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <!-- <b><a href="javascript:;" onClick="window.open('<?php //echo MEDIA_PATH;?>cashflow_xbrl2/CASHFLOW_<?php //echo $_GET['vcid'];?>_1.xls','_blank')" class="agree-cfconexport">I Agree</a></b><b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
      <b><a href="javascript:;" onClick="window.open('downloadtrackCF.php?vcid=<?php echo $_GET['vcid'];?>&type=consolidated&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-cfconexport">I Agree</a></b>
  </div>
</div>
<script type="text/javascript" >
// $(document).ready(function(){
//   if($('.cfs_menu').length > 1){
//       $('.cfs_menu:last').eq(1).remove();
//   }
//   if($('.finance-filter-custom').length > 1){
//       $('.finance-filter-custom').eq(1).remove();
//   }
// });
        $('input[name=cfexportcompare]#cfexportcompare').on("click",function(){
              jQuery('#cashflow_parent #maskscreen').fadeIn(1000);
              $( '#cfexport-popup' ).show();
              return false; 
            });
        $( '.agree-cfexport').on( 'click', function() {    
            jQuery('#cashflow_parent #maskscreen').fadeOut(1000);
            $( '#cfexport-popup' ).hide();
            return false;
        });
        $( '#cfexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#cfexport-popup' ).hide();
            jQuery('#cashflow_parent #maskscreen').fadeOut(1000);
        });
$('input[name=cfconexportcompare]#cfconexportcompare').click(function(){
              jQuery('#cashflow_parent #maskscreen').fadeIn(1000);
              $( '#cfconexport-popup' ).show();
              return false; 
            });
        $( '.agree-cfconexport').on( 'click', function() {    
            jQuery('#cashflow_parent #maskscreen').fadeOut(1000);
            $( '#cfconexport-popup' ).hide();
            return false;
        });
        $( '#cfconexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#cfconexport-popup' ).hide();
            jQuery('#cashflow_parent #maskscreen').fadeOut(1000);
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
/*var clickflagprofitloss = 0;
function plresult(vcid1){
  if(clickflagprofitloss == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajaxmilliCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagprofitloss=1;
            $('#result').html(data);
           
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $(".cfs_menu ul li").removeClass('current');
                       var row = $('#activeSubmenu').val();
                       $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    }
}
var clickflagbalancesheet = 0;
function balancesheetresult(vcid1){
  if(clickflagbalancesheet == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajax_balancesheet.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagbalancesheet=1;
            $('#result').html(data);
           
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $(".cfs_menu ul li").removeClass('current');
                       var row = $('#activeSubmenu').val();
                       $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    }
}
var clickflagcashflow = 0;
function cfresult(vcid1){
   if(clickflagcashflow == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajax_cashflow.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagcashflow=1;
            $('#result').html(data);
           
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $(".cfs_menu ul li").removeClass('current');
                       var row = $('#activeSubmenu').val();
                       $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    }
}
var clickflagratio = 0;
function ratioresult(vcid1){
   if(clickflagratio == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajax_ratio.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagratio=1;
            $('#result').html(data);
           
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $(".cfs_menu ul li").removeClass('current');
                       var row = $('#activeSubmenu').val();
                       $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    }
}*/
    </script>
<?php mysql_close(); ?>