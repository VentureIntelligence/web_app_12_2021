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
<?php             

//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($whereradio,$group1);
//Old Balancesheet Ratio calculation
/*$RatioCalculation = $plstandard->radioFinacial($whereradio,$group1);*/
$RatioCalculation = $plstandard->radioFinacial($whereradio1,$group1);
   ?> 
<div style="clear:both;"></div>
<div id="ratio" class=" tab_menu" style="margin-top: 10px;">
   <!--  <h4 style="font-size: 18px;margin-bottom: 7px;margin-top: 30px;"><?php echo $runTypetext; ?> / <?php echo $resultTypetext; ?></h4>  -->
<div id="new_ratio" style="<?php if(count($NewRatioCalculation) >0) { ?> display:block;clear:both; <?php } else{ ?> display:none; <?php }?>">
     <?php $rowtype=mysql_query("select ResultType from plstandard where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
   ?>
   <div class="resulttype-value" style="font-size: 16px;/*margin-bottom: 10px;margin-top: -45px;*/">
    <?php if($resulttypecount==2) {?>
  <ul class="primary">
        <li class="current subMenu consolidated" data-row="ratio" onclick ="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
         <li class="subMenu standalone" data-row="ratio" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
   </ul>
   <?php } else if($resulttypecount==1){
       
    ?><ul class="secondary"><?php
        if($resultTypetext=="Standalone"){
        ?>
       
            <li class="current subMenu" data-row="ratio" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
  
   <?php } else if($resultTypetext=="Consolidated"){?>
        
             <li class="current subMenu" data-row="ratio" onclick="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
            
        <?php } } ?>
        </ul>
        <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
    </div>
    <div class="finance-cnt" style="clear:both;">
         <?php if($NewRatioCalculation !=''){ ?>

        <div class="detail-table" style="    margin-top: 0px !important;float: left;overflow: visible;">
            <table  width="110%" border="0" cellspacing="0" cellpadding="0">     
                <tHead> <tr>
                <th>Ratios</th>
                </tr></thead>
                <tbody>  
                  <tr class="tooltipratio">
                    <td>Current Ratio
                        <span class="" style="top: -6px;width: 260px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>Total current assets / Total current liabilities </strong>
                        </span>
                    </td>
                     
                  </tr>
                  <tr class="tooltipratio">
                    <td>Quick Ratio
                        <span class="" style="top: -6px;width: 340px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>(Total current assets - Inventories) / Total current liabilities</strong>
                        </span>
                    </td>
                  </tr>
                  <tr class="tooltipratio">
                    <td>Debt Equity Ratio
                        <span class="" style="top: -6px;width: 435px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>(Long-term borrowings + Short-term borrowings)/Total shareholders' funds</strong>
                        </span>
                    </td>
                  </tr> 
                  <tr class="tooltipratio">
                    <td>RoE
                        <span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>PAT / Total shareholders' funds</strong>
                        </span>
                    </td>
                  </tr>  
                  <tr class="tooltipratio">
                    <td>RoA
                        <span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>PAT / Total assets</strong>
                        </span>
                    </td>
                  </tr>  
                  <tr class="tooltipratio">
                    <td>Asset Turnover Ratio
                        <span class="" style="top: -6px;width: 415px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>(Total Income/((Total Assets of prev year + Total Assets of current year)/2)</strong>
                        </span>
                    </td>
                  </tr> 
                   <tr class="tooltipratio">
                    <td>EBITDA Margin
                        <span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>EBITDA / Total Income</strong>
                        </span>
                    </td>
                  </tr>  
                  <tr class="tooltipratio">
                    <td>PAT Margin
                        <span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>PAT / Total Income</strong>
                        </span>
                    </td>
                  </tr> 
                  <?php $isContributionmargin = false;
                    for($i=0;$i<count($NewRatioCalculation);$i++){ 
                        $costofmaterial=$NewRatioCalculation[$i]['CostOfMaterialsConsumed'];  
                        $purchasesofstock=$NewRatioCalculation[$i]['PurchasesOfStockInTrade'];  
                        $changesininventories=$NewRatioCalculation[$i]['ChangesInInventories'];  
                        if(($costofmaterial == '' || $costofmaterial == 0) && ($purchasesofstock == '' || $purchasesofstock == 0) && ($changesininventories == '' || $changesininventories == 0)){
                            //$isContributionmargin = false;
                        } else {
                            $isContributionmargin = true;
                        }
                    } ?>
                    <?php if($isContributionmargin){ ?>
                        <tr class="tooltipratio">
                            <td>Contribution margin
                                <span class="" style="top: -7px;width: 605px;">
                                <div class="callout showtextlarge4" ></div>
                                    <strong>(Total Income - Cost of materials consumed - Purchases of stock in trade - Changes in inventories)/Total Income</strong>
                                </span>
                            </td>
                        </tr>
                    <?php }?> 

                </tbody>
              </table>
        </div>
        <div class="tab-res" style="overflow-x: auto; margin:0px 0 !important;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">     
                <tHead> <tr>
                
                <?php for($i=0;$i<count($NewRatioCalculation);$i++){ 
                $str     = $NewRatioCalculation[$i][FY];
                $order   = array("(", ")");
                $replace = ' '; 
                $FY = str_replace($order, $replace, $str); ?>
                <th>FY <?php echo $FY; ?> </th>
                <?php } ?>
                </tr></thead>
                <tbody>  
                  <tr>
                    
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['T_current_assets'];  
                                    $a=$NewRatioCalculation[$i]['T_current_liabilities'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['T_current_assets'];  
                                    $y = $NewRatioCalculation[$i]['Inventories'];
                                    $a=$NewRatioCalculation[$i]['T_current_liabilities'];
                                    $equation=($x-$y)/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['L_term_borrowings'] + $NewRatioCalculation[$i]['S_term_borrowings'];  
                                    $a=$NewRatioCalculation[$i]['TotalFunds'];
                                    $equation=$x/$a; if($equation !='') { printf("%.2f",$equation); }else { ?>&nbsp;<?php } ?></td>
                     <?php } ?>
                  </tr>
                  <tr>
                    
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['PAT'];  
                                    $a=$NewRatioCalculation[$i]['TotalFunds'];
                                    $equation=$x/$a; if($equation !='') { printf("%.2f",$equation); }else { ?>&nbsp;<?php } ?></td>
                     <?php } ?>
                  </tr>  
                  <tr>
                    
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['PAT'];  
                                    $a=$NewRatioCalculation[$i]['Total_assets'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr> 
                  <tr>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php 
                                    $totalIncome = $NewRatioCalculation[$i]['TotalIncome'];  
                                    $totalAssetsCurrent = $NewRatioCalculation[$i]['Total_assets'];
                                    $totalAssetsPrevious = $NewRatioCalculation[$i+1]['Total_assets'];
                                    $resultAssets = ($totalAssetsPrevious+$totalAssetsCurrent)/2;
                                    $equation=($totalIncome/$resultAssets); printf("%.2f",$equation);?></td>
                    <?php } ?>
                  </tr>  
                   <tr>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['EBITDA'];  
                                    $y = $NewRatioCalculation[$i]['TotalIncome'];
                                    $a=100;
                                    $equation=($x/$y)*$a; printf("%.2f",$equation);echo '%'; ?></td>
                    <?php } ?>
                  </tr>  
                  <tr>
                    
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['PAT'];  
                                    $y = $NewRatioCalculation[$i]['TotalIncome'];
                                    $a=100;
                                    $equation=($x/$y)*$a; printf("%.2f",$equation);echo '%'; ?></td>
                    <?php } ?>
                  </tr> 
                  <?php $isContributionmargin = false;
                    for($i=0;$i<count($NewRatioCalculation);$i++){ 
                        $costofmaterial=$NewRatioCalculation[$i]['CostOfMaterialsConsumed'];  
                        $purchasesofstock=$NewRatioCalculation[$i]['PurchasesOfStockInTrade'];  
                        $changesininventories=$NewRatioCalculation[$i]['ChangesInInventories'];  
                        if(($costofmaterial == '' || $costofmaterial == 0) && ($purchasesofstock == '' || $purchasesofstock == 0) && ($changesininventories == '' || $changesininventories == 0)){
                            //$isContributionmargin = false;
                        } else {
                            $isContributionmargin = true;
                        }
                    } ?>
                    <?php if($isContributionmargin){ ?>
                        <tr>
                            
                            <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                            <td><?php 
                                    $costofmaterial=$NewRatioCalculation[$i]['CostOfMaterialsConsumed'];  
                                    $purchasesofstock=$NewRatioCalculation[$i]['PurchasesOfStockInTrade'];  
                                    $changesininventories=$NewRatioCalculation[$i]['ChangesInInventories'];  
                                    $y = $NewRatioCalculation[$i]['TotalIncome'];
                                    $x = $y - $costofmaterial - $purchasesofstock - $changesininventories;
                                    $a=100;
                                    $equation=($x/$y)*$a;
                                    if($equation != 100){
                                        printf("%.2f",$equation);echo '%'; 
                                    } else {
                                        echo '-'; 
                                    }
                                ?>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php }?> 

                </tbody>
              </table>
        </div>
        <?php } ?>
    </div>
</div>

        <?php if(count($RatioCalculation) > 0){ ?>
<div id="old_ratio" style="<?php if(count($NewRatioCalculation) == 0) { ?> display:block;clear:both; <?php } else{ ?> display:none; clear:both; <?php }?>">
     <?php $rowtype=mysql_query("select ResultType from balancesheet where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
    while($resulttypearray=mysql_fetch_array($rowtype)){
    ?>
   <div class="resulttype-value" style="font-size: 16px;/*margin-bottom: 10px;margin-top: -45px;*/">
    <?php if($resulttypecount==2) {?>
  <ul class="primary">
        <li class="current subMenu consolidated" data-row="ratio" onclick ="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
 
        <li class="subMenu standalone" data-row="ratio" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
   </ul>
   <?php } else if($resulttypecount==1){
       
    ?><ul class="secondary"><?php
        if($resulttypearray[ResultType]==0){
        ?>
       
            <li class="current subMenu" data-row="ratio" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
 
   <?php } else if($resulttypearray[ResultType]==1){?>
        
             <li class="current subMenu" data-row="ratio" onclick="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
            
        <?php } } ?>
        </ul>
       <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
    </div><?php  } ?>
    <div class="finance-cnt" style="clear:both;">
        <div class="detail-table" style="    margin-top: 0px !important;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">     
                <tHead> <tr>
                <th>Ratios</th>
                <?php for($i=0;$i<count($RatioCalculation);$i++){ 
                $str     = $RatioCalculation[$i][FY];
                $order   = array("(", ")");
                $replace = ' '; 
                $FY = str_replace($order, $replace, $str); ?>
                <th>FY <?php echo $FY; ?> </th>
                <?php } ?>
                </tr></thead>
                <tbody>  
                  <tr class="tooltipratio">
                    <td>Current Ratio<span class="" style="top: -6px;width: 260px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>Total current assets / Total current liabilities </strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['CurrentAssets'];  
                                    $a=$RatioCalculation[$i]['CurrentLiabilitiesProvision'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr class="tooltipratio">
                    <td>Quick Ratio<span class="" style="top: -6px;width: 340px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>(Total current assets - Inventories) / Total current liabilities</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['CurrentAssets'];  
                                    $y = $RatioCalculation[$i]['Inventories'];
                                    $a=$RatioCalculation[$i]['CurrentLiabilitiesProvision'];
                                    $equation=($x-$y)/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr class="tooltipratio">
                    <td>Debt Equity Ratio<span class="" style="top: -6px;width: 435px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>(Long-term borrowings + Short-term borrowings)/Total shareholders' funds</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['L_term_borrowings'] + $NewRatioCalculation[$i]['S_term_borrowings'];  
                                    $a=$NewRatioCalculation[$i]['TotalFunds'];
                                    $equation=$x/$a; if($equation !='') { printf("%.2f",$equation); }else { ?>&nbsp;<?php } ?></td>
                     <?php } ?>
                  </tr>
                  <tr class="tooltipratio">
                    <td>RoE<span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>PAT / Total shareholders' funds</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['PAT'];  
                                    $a=$RatioCalculation[$i]['TotalFunds'];
                                    $equation=$x/$a; if($equation !='') { printf("%.2f",$equation); }else { ?>&nbsp;<?php } ?></td>
                     <?php } ?>
                  </tr>  
                  <tr class="tooltipratio">
                    <td>RoA<span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>PAT / Total assets</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['PAT'];  
                                    $a=$RatioCalculation[$i]['TotalAssets'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>  
                  <tr class="tooltipratio">
                    <td>Asset Turnover Ratio<span class="" style="top: -6px;width: 415px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>(Total Income/((Total Assets of prev year + Total Assets of current year)/2)</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php 
                                    $totalIncome = $RatioCalculation[$i]['TotalIncome'];  
                                    $totalAssetsCurrent = $RatioCalculation[$i]['TotalAssets'];
                                    $totalAssetsPrevious = $RatioCalculation[$i+1]['TotalAssets'];
                                    $resultAssets = ($totalAssetsPrevious+$totalAssetsCurrent)/2; 
                                    $equation=($totalIncome/$resultAssets); printf("%.2f",$equation);?></td>
                    <?php } ?>
                  </tr>
                   <tr class="tooltipratio">
                    <td>EBITDA Margin<span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>EBITDA / Total Income</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['EBITDA'];  
                                    $y = $RatioCalculation[$i]['TotalIncome'];
                                    $a=100;
                                    $equation=($x/$y)*$a; printf("%.2f",$equation);echo '%'; ?></td>
                    <?php } ?>
                  </tr>  
                  <tr class="tooltipratio">
                    <td>PAT Margin<span class="" style="top: -6px;">
                        <div class="callout showtextlarge4" ></div>
                            <strong>PAT / Total Income</strong>
                        </span></td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['PAT'];  
                                    $y = $RatioCalculation[$i]['TotalIncome'];
                                    $a=100;
                                    $equation=($x/$y)*$a; printf("%.2f",$equation);echo '%'; ?></td>
                    <?php } ?>
                  </tr> 
                  <?php $isContributionmargin = false;
                    for($i=0;$i<count($RatioCalculation);$i++){ 
                        $costofmaterial=$RatioCalculation[$i]['CostOfMaterialsConsumed'];  
                        $purchasesofstock=$RatioCalculation[$i]['PurchasesOfStockInTrade'];  
                        $changesininventories=$RatioCalculation[$i]['ChangesInInventories'];  
                        if(($costofmaterial == '' || $costofmaterial == 0) && ($purchasesofstock == '' || $purchasesofstock == 0) && ($changesininventories == '' || $changesininventories == 0)){
                            //$isContributionmargin = false;
                        } else {
                            $isContributionmargin = true;
                        }
                    } ?>
                    <?php if($isContributionmargin){ ?>
                        <tr class="tooltipratio">
                            <td>Contribution margin
                                <span class="" style="top: -7px;width: 605px;">
                                <div class="callout showtextlarge4" ></div>
                                    <strong>(Total Income - Cost of materials consumed - Purchases of stock in trade - Changes in inventories)/Total Income</strong>
                                </span>
                            </td>
                            <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                            <td><?php 
                                    $costofmaterial=$RatioCalculation[$i]['CostOfMaterialsConsumed'];  
                                    $purchasesofstock=$RatioCalculation[$i]['PurchasesOfStockInTrade'];  
                                    $changesininventories=$RatioCalculation[$i]['ChangesInInventories'];  
                                    $y = $RatioCalculation[$i]['TotalIncome'];
                                    $x = $y - $costofmaterial - $purchasesofstock - $changesininventories;
                                    $a=100;
                                    $equation=($x/$y)*$a;
                                    if($equation != 100){
                                        printf("%.2f",$equation);echo '%'; 
                                    } else {
                                        echo '-'; 
                                    }
                                ?>
                            </td>
                            <?php } ?>
                        </tr>
                    <?php }?>

                </tbody>
              </table>
        </div>
    </div>
</div>
        <?php } ?>
</div>

<script type="text/javascript" >
    $('input[name=plexportcompare]#plexportcompare').click(function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#plexport-popup' ).show();
              return false; 
            });
        $( '.agree-plexport').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#plexport-popup' ).hide();
            return false;
        });
        $( '#plexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#plexport-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
        });
$('input[name=plconexportcompare]#plconexportcompare').click(function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#plconexport-popup' ).show();
              return false; 
            });
        $( '.agree-plconexport').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#plconexport-popup' ).hide();
            return false;
        });
        $( '#plconexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#plconexport-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
        });
$('input[name=bsexportcompare]#bsexportcompare').click(function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#bsexport-popup' ).show();
              return false; 
            });
        $( '.agree-bsexport').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#bsexport-popup' ).hide();
            return false;
        });
        $( '#bsexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#bsexport-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
        });
$('input[name=bsconexportcompare]#bsconexportcompare').click(function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#bsconexport-popup' ).show();
              return false; 
            });
        $( '.agree-bsconexport').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#bsconexport-popup' ).hide();
            return false;
        });
        $( '#bsconexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#bsconexport-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
        });
        $('input[name=cfexportcompare]#cfexportcompare').on("click",function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#cfexport-popup' ).show();
              return false; 
            });
        $( '.agree-cfexport').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#cfexport-popup' ).hide();
            return false;
        });
        $( '#cfexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#cfexport-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
        });
$('input[name=cfconexportcompare]#cfconexportcompare').click(function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#cfconexport-popup' ).show();
              return false; 
            });
        $( '.agree-cfconexport').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#cfconexport-popup' ).hide();
            return false;
        });
        $( '#cfconexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#cfconexport-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
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