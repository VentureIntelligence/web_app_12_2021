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
//Changes - xbrl2
require_once MODULES_DIR."cashflow.php";
$cashflow = new cashflow();
//pr($_REQUEST);
if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in ajaxCurrency page -'.$_SESSION['username']); }

/*Currency Convert Function*/
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
// $yearcurrency=array();
// $fyvalue=array('20','19','18','17','16','15','14','13','12','11','10','09','08','07','06');
// $currvatype=array('75.3675337409','69.2813479208','65.1365861653','64.8589085866','66.17526015','62.335530796','60.0593486709','54.2849998474','50.8699989319','44.4','44.9747584839','50.861443474','50.861443474','40.022','43.5898132023','44.535');
// $yearcurrency=array_combine($fyvalue,$currvatype);
// $yearcurrency=array();
// $currvatype=array('75.3675337409','69.2813479208','65.1365861653','64.8589085866','66.17526015','62.335530796','60.0593486709','54.2849998474','50.8699989319','44.4','44.9747584839','50.861443474','40.022','43.5898132023','44.535','71.2921527817','69.6049200418','63.8499066326','67.9669','66.2013798142','63.1889610935','61.859004615','54.8509728363','53.0600413817','44.7000007629','46.41','48.5800658634','39.37','44.25');
// //$currvatype=array('71.751','74.3407','65.0375','67.9212','63.6120','60.9994','58.0169','52.8298','54.2244','48.88');
// //$fyvalue=array('19','18','17','16','15','14','13','12','11','10');
// $fyvalue=array('20','19','18','17','16','15','14','13','12','11','10','09','08','07','06','20 311219','19 311218','18 311217','17 311216','16 311215','15 311214','14 311213','13 311212','12 311211','11 311210','10 311209','09 311208','08 311207','07 311206');
// $yearcurrency=array_combine($fyvalue,$currvatype);
include('conversionarray.php');
//print_r($_SESSION['curvalue']);
/*Currency Convert Function*/
function currency_convert($amount,$from_currency,$to_currency)
{
    //print_r($_SESSION['typevalue']);
    $comp_key=$from_currency."-".$to_currency;
        $curr_value=$_SESSION['typevalue'][$comp_key];
        $convertnumber=$amount* $curr_value;
        return $convertnumber;
}
/*function currency_convert($amount,$from_currency,$to_currency)
{
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
    $convertnumber = preg_replace("/[^0-9,.]/", "", $removeString);
    return $convertnumber;
}*/

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
<!--Cashflow for xbrl2 start-->
<?php 


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

?>
<!--Cashflow for xbrl2 end-->
<!--<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid=<?php echo $_GET['vcid']; ?>">See Projection</a></div>-->

 <div class="tab_menu_parent" id="profit_loss_parent" style="display:none;"></div>
   <div class="tab_menu_parent" id="balancesheet_parent" style="display:none;"></div>
   <div class="tab_menu_parent" id="cashflow_parent" style="display:none;"></div>
   <div class="tab_menu_parent" id="ratio_parent" style="display:none;"></div>  

<div class="tab_menu" id="profit-loss" style="display:block;">
<div class="cfs_menu">
    <ul>
        <li class="current subMenu" data-row="profit-loss" href="javascript:;" onclick="javascript:plresult(<?php echo $_GET['vcid'];?>);">PROFIT &amp; LOSS</li>
        <li data-row="balancesheet" href="javascript:;" class="subMenu" onclick="javascript:balancesheetresult(<?php echo $_GET['vcid'];?>);">BALANCE SHEET</li>
        <!--Cashflow list added - xbrl2-->
        <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> onclick="javascript:cfresult(<?php echo $_GET['vcid'];?>);">CASH FLOW</li>

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

<div class="finance-filter">
<div class="left-cnt"> 
    <label class="cagrvalue"> <input type="radio" name="yoy" id="yoy" value="V"  <?php if($_GET['yoy']=='V'){ echo "checked";} ?> onChange="javascript:valueconversion('V',<?php echo $_GET['vcid']; ?>);" checked="checked" /> Value</label>
    <label class="cagrlabel">   <input type="radio" name="yoy" id="cagr" value="G"  <?php if($_GET['yoy']=='G'){ echo "checked";} ?> onChange="javascript:valueconversion('G',<?php echo $_GET['vcid']; ?>);" /> Growth</label> 
    <select onchange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
    
        <option value="INR" <?php if($_GET['queryString']=='INR'){ echo "selected";} ?>>INR</option>
        <option value="USD" <?php if($_GET['queryString']=='USD'){ echo "selected";} ?>>USD</option>
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
<?php
    if( $companyDetails[0]['listingstatus'] == 1 ) {
        //$style = 'display: none;';
        $style = '';
    } else {
        $style = '';
    }
?>
<?php if(BASE_URL == "//dev.vionweb.com/" || BASE_URL == "//localhost/vi_webapp/" ){?>
<div class="growth_fulldetails" style="<?php echo $style; ?>">
    <?php
    $growth_precentage = array();
    $ResultType1="SELECT MAX( ResultType ) AS ResultType FROM cagr WHERE CId_FK =".$_GET['vcid']." AND FY !=  ''";
    $query=mysql_query($ResultType1);
    $resultType=mysql_fetch_array($query);
    /*$growth_years=mysql_query("SELECT g.EBITDA as g_ebitda,g.TotalIncome as g_totalIncome,g.PAT as g_pat, p.TotalIncome as p_totalIncome, p.EBITDA as p_ebitda, p.PAT as p_pat, p.FY FROM `cagr` as g, plstandard as p WHERE g.CId_FK = p.CId_FK and g.FY=p.FY and g.CId_FK='".$_GET['vcid']."' and p.ResultType='0' GROUP BY g.CAGRYear order by g.CAGRYear,p.FY asc");*/
     $growth_years=mysql_query("SELECT g.EBITDA as g_ebitda,g.TotalIncome as g_totalIncome,g.PAT as g_pat, p.TotalIncome as p_totalIncome, p.EBITDA as p_ebitda, p.PAT as p_pat, g.FY as FY FROM `cagr` as g, plstandard as p WHERE g.CId_FK = p.CId_FK and g.FY=p.FY and g.ResultType= p.ResultType and g.CId_FK='".$_GET['vcid']."' and g.ResultType='".$resultType[ResultType]."' GROUP BY g.CAGRYear order by g.CAGRYear,p.FY asc");
    while($growth_year = mysql_fetch_array($growth_years)){
        $growth_precentage[] = $growth_year;
    }
    $j=0;
    $latest_p_totalIncome = $growth_precentage[0]['p_totalIncome'];
    $latest_p_ebitda = $growth_precentage[0]['p_ebitda'];
    $latest_p_pat = $growth_precentage[0]['p_pat'];
    for($l=1;$l<=3;$l++){
        $growth_year = $l+$j;
        
        if($growth_precentage[$growth_year]['FY'] !='' || $growth_precentage[$growth_year-1]['FY'] !=''){
            if($growth_precentage[$growth_year]['FY'] =='' && $growth_precentage[$growth_year-1]['FY'] != ''){
                $cal_year = $growth_precentage[$growth_year-1]['FY']-1;
                
                $last_years=mysql_query("SELECT TotalIncome as p_totalIncome, EBITDA as p_ebitda, PAT as p_pat FROM plstandard WHERE FY='$cal_year' and ResultType='".$resulttype[0][ResultType]."' and CId_FK='".$_GET['vcid']."' limit 0,1");
                $last_year = mysql_fetch_array($last_years);
                $p_totalIncome = $last_year['p_totalIncome'];
                $p_pat = $last_year['p_pat'];
                $p_ebitda = $last_year['p_ebitda'];                
            }else{
                $p_totalIncome = $growth_precentage[$growth_year]['p_totalIncome'];
                $p_pat = $growth_precentage[$growth_year]['p_pat'];
                $p_ebitda = $growth_precentage[$growth_year]['p_ebitda'];
            }
            $g_ebitda_arrow = ($p_ebitda <= $latest_p_ebitda)?"up":"down";  
            $g_totalIncome_arrow = ($p_totalIncome <= $latest_p_totalIncome)?"up":"down"; 
            $g_pat_arrow = ($p_pat <= $latest_p_pat)?"up":"down"; 
             ?>
                         <div class="<?php if($l==0){ echo "firstyear_growth"; }else if($l==1){ echo "thirdyear_growth"; }else echo "fifthyear_growth"; ?>">
                             <h3 class="growth_heading"><?php echo $growth_year; ?> Year Growth</h3>
                             <div class="growth_content">
                                <div class="total_income">
                                    <h4 class="income_heading">Total Income</h4>
                                </div>
                                <div class="ebitda">
                                    <h4 class="ebitda_heading">EBITDA</h4> 
                                </div>
                                <div class="pat">
                                    <h4 class="pat_heading">PAT</h4>
                                </div>
                             </div>
                             <div class="growth_details">
                                 <div class="income_details">
                                     <span class="<?php echo $g_totalIncome_arrow; ?>_amount">
                                         <?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($latest_p_totalIncome==0){
                                                   echo '&nbsp';                                        
                                                 }else{
                                                     //$vale = currency_convert($latest_p_totalIncome,'INR',$_GET['queryString']);
                                                     $vale = $latest_p_totalIncome/$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }
                                                 }
                                             }else{ ?>
                                              <?php echo $_GET['queryString'].'&nbsp'; echo round(($latest_p_totalIncome/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";                               
                                             } ?>
                                     </span>
                                     <span class="<?php echo $g_totalIncome_arrow; ?>_bg">&nbsp;</span>
                                     <span class="<?php echo $g_totalIncome_arrow; ?>_content">
                                          <p><?php echo $growth_precentage[$growth_year-1]['g_totalIncome']; ?>%</p>
                                     </span>
                                     <span class="<?php echo $g_totalIncome_arrow; ?>_amount">
                                         <?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($p_totalIncome==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                    // $vale = currency_convert($p_totalIncome,'INR',$_GET['queryString']);
                                                     $vale = $p_totalIncome/$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }
                                                 }
                                             }else{ ?>
                                              <?php echo $_GET['queryString'].'&nbsp'; echo round(($p_totalIncome/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";                               
                                             } ?>
                                     </span>
                                 </div>
                                  <div class="ebitda_details">
                                      <span class="<?php echo $g_ebitda_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($latest_p_ebitda==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                     //$vale = currency_convert($latest_p_ebitda,'INR',$_GET['queryString']); 
                                                     $vale = $latest_p_ebitda/$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                        
                                                 }
                                             }else{ ?>
                                             <?php echo $_GET['queryString'].'&nbsp';  echo round(($latest_p_ebitda/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";                                     
                                             } ?></span>
                                     <span class="<?php echo $g_ebitda_arrow; ?>_bg">&nbsp;</span>
                                     <span class="<?php echo $g_ebitda_arrow; ?>_content">
                                          <p><?php echo $growth_precentage[$growth_year-1]['g_ebitda']; ?>%</p>
                                     </span>
                                     <span class="<?php echo $g_ebitda_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($p_ebitda==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                     //$vale = currency_convert($p_ebitda,'INR',$_GET['queryString']); 
                                                     $vale = $p_ebitda/$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                        
                                                 }
                                             }else{ ?>
                                             <?php echo $_GET['queryString'].'&nbsp';  echo round(($p_ebitda/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";                                     
                                             } ?></span>
                                 </div>
                                  <div class="pat_details">
                                      <span class="<?php echo $g_pat_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($latest_p_pat==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                     //$vale = currency_convert($latest_p_pat,'INR',$_GET['queryString']);
                                                     $vale = $latest_p_pat/$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     } else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                       
                                                 }
                                             }else{ ?>
                                             <?php echo $_GET['queryString'].'&nbsp'; echo round(($latest_p_pat/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";                                     
                                             } ?></span>
                                     <span class="<?php echo $g_pat_arrow; ?>_bg">&nbsp;</span>
                                     <span class="<?php echo $g_pat_arrow; ?>_content">
                                          <p><?php echo $growth_precentage[$growth_year-1]['g_pat']; ?>%</p>
                                     </span>
                                     <span class="<?php echo $g_pat_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($p_pat==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                     //$vale = currency_convert($p_pat,'INR',$_GET['queryString']);
                                                     $vale = $p_pat/$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     } else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                       
                                                 }
                                             }else{ ?>
                                             <?php echo $_GET['queryString'].'&nbsp'; echo round(($p_pat/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";                                     
                                             } ?></span>
                                 </div>
                             </div>

                         </div>
        <?php  } $j++; }      ?>
   <div class="">
   </div>
</div> 
<?php } if(count($FinanceAnnual) > 0){ 

    if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls')){
            $PLSTANDARD_MEDIA_PATH=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';
        }
        if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls')){
            $PLSTANDARD_MEDIA_PATH_CON=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls';
            
        }
       
        ?>
        <?php if($PLSTANDARD_MEDIA_PATH || $PLSTANDARD_MEDIA_PATH_CON){?>
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 70px !important;"> 
                 <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="openpl_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />

              <div id="pl_ex" data-slide="close" style=" position: absolute;  width: 100%; display: none; {if $file_pl_cnt > 0 && $file_bs_cnt > 0} left: 0 {else} left: 0 {/if}">
              <?php if ($PLSTANDARD_MEDIA_PATH){?>
             <!--  <input  name="" type="button" value="Standalone" onClick="window.open('downloadtrack.php?vcid={$Company_Id}','_blank')" style="  width: 180px;border-top: 0;" /> -->
              <input  name="plexportcompare" type="button" value="Standalone" id="plexportcompare" style="  width: 180px;border-top: 0;" />
              <?php  } if ( $PLSTANDARD_MEDIA_PATH_CON){?>
             <!--  <input  name="" type="button" value="Consolidated" onClick="window.open('downloadtrack.php?vcid={$Company_Id}&type=consolidated','_blank')" style="  width: 180px;border-top: 0;" /> -->
              <input  name="plconexportcompare" type="button" value="Consolidated" id="plconexportcompare" style="  width: 180px;border-top: 0;" />
             
              <?php  }?>
                 </div>
                  </span>
              <?php } else{?>
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;"> 
                    <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="plDataUpdateReq()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />
                </span>
              <?php } if($PLDETAILED_MEDIA_PATH){?>
                            <input  name="" type="button"  value="Detailed P&L EXPORT" onClick="window.open('<?php echo MEDIA_PATH?>pldetailed/PLDetailed_{$VCID}.xls?time={$smarty.now}','_blank')" />
                <?php }?>
                <div class="finance-filter-custom" <?php if($_SERVER['SERVER_NAME']=="www.ventureintelligence.com" || $_SERVER['SERVER_NAME']=="www.vionweb.com" ){ echo 'style="padding-top: 70px;"';} ?>>
                <select class="currencyselection" onchange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
                
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
<div style="clear:both;margin-top:18px">
     <?php $rowtype=mysql_query("select ResultType from plstandard where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
    ?>
   <div class="resulttype-value" style="font-size: 16px;/*margin-bottom: 10px;margin-top: -45px;*/">
    <?php if($resulttypecount==2) {?>
  <ul class="primary">
        <li class="current subMenu consolidated" data-row="profit-loss" onclick ="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
  
        <li class="subMenu standalone" data-row="profit-loss" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
   </ul>
   <?php } else if($resulttypecount==1){
       
    ?><ul class="secondary"><?php
        if($resultTypetext=="Standalone"){
        ?>
       
            <li class="current subMenu standalone" data-row="profit-loss" onclick="javascript:resulttypestandalone(<?php echo $_GET['vcid'];?>);">Standalone</li>
  
   <?php } else if($resultTypetext=="Consolidated"){?>
        
             <li class="current subMenu consolidated" data-row="profit-loss" onclick="javascript:resulttypeconsolidate(<?php echo $_GET['vcid'];?>);">Consolidated</li>
             
        <?php } } ?>
        </ul>
        <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
    </div>
   <!--  <h4 style="font-size: 18px;margin-bottom: 10px;position: absolute;margin-top: -40px;"><?php echo $runTypetext; ?> / <?php echo $resultTypetext; ?></h4> -->
    <div class="detail-table-div" style="float: left;">
        <table  width="100%" border="0" cellspacing="0" cellpadding="0">
            <tHead> 
                <tr>
                    <th>OPERATIONS</th>
                </tr>
            </thead>
            <tbody>  
              <tr>
                <td>Opertnl Income</td>
              </tr>
              <tr>
                <td>Other Income</td>
              </tr>
              <tr>
                <td><b>Total Income</b></td>
              </tr>
              <!-- Fields added - xbrl2 start-->
              <tr>
                <td>Cost of materials consumed</td>
              </tr>
              
              <tr>
                <td>Purchases of stock-in-trade</td>
              </tr>
              
              <tr>
                <td>Changes in Inventories</td>
              </tr>
              <!-- Fields added - xbrl2 end-->
              <tr>
                <td>Employee benefit expense</td>
              </tr>
              <!-- Fields added - xbrl2 start-->
              <tr>
                <td>CSR expenditure</td>
              </tr>
              <tr>
                <td>Other expenses</td>
              </tr>
              <!-- Fields added - xbrl2 end-->
              <tr>
                <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
              </tr>
              <tr>
                <td>Operating Profit</td>
              </tr>
              <tr>
                <td><b>EBITDA</b></td>
              </tr>
              <tr>
                <td>Interest</td>
               </tr>
              <tr>
                <td>EBDT</td>
              </tr>
              <tr>
                <td>Depreciation</td>
              </tr>
              <tr>
            <td>EBT before Exceptional Items </td>
              </tr>
              <tr><td>
                  Prior period/Exceptional /Extra Ordinary Items</td>
              </tr>
              <tr>
                <td>EBT</td>
              </tr>
              <!-- Fields added - xbrl2 start-->
               <tr>
                <td>Current tax</td>
              </tr>
              <tr>
                <td>Deferred tax</td>
              </tr>
              <!-- Fields added - xbrl2 end-->
              <tr>
                <td>Tax</td>
              </tr>
              <tr>
                <td><b>PAT</b></td>
              </tr>
              <!-- Fields added - xbrl2 start-->
               <?php if($resulttype[0][ResultType] == 1){ ?>
                <tr>
                    <td>Profit (loss) of minority interest</td>
                </tr>
                <tr>
                    <td>Total profit (loss) for period</td>
                </tr>
              <?php } ?>
              <!-- Fields added - xbrl2 end-->
              <tr>
                <td><b>EPS</b></td>
              </tr>
              <tr>
                <td>EPS Basic (in <?php echo $_GET['queryString']?>)</td>
              </tr>
              <tr>
                <td>EPS Diluted (in <?php echo $_GET['queryString']?>)</td>
               </tr>
              <tr>
                    <td>&nbsp;</td>
              </tr>
              
                  <?php
                    $EmpRelatedExp = '';
                    for($i=0;$i<count($FinanceAnnual);$i++){
                        if($_GET['queryString']!='INR'){
                            if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                            $EmpRelatedExp .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                        }
                    }
                 else {
                        if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                            $EmpRelatedExp .= '<td>'. $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);round($tot,2).'</td>';
                        }

                 }

                    }
                    if($EmpRelatedExp!='')
                    {
                    //Changes - xbrl2
                   if($runType['run_type'] != 1){ ?>
                  <!-- <tr>
                        <td>Employee Related Expenses</td>
                   
                  </tr> -->
               <?php 
                    } 
                    }

               $frnExgEarnin = '';
                    for($i=0;$i<count($FinanceAnnual);$i++){
                        if($_GET['queryString']!='INR'){
                if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                $frnExgEarnin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue;round($tot,2).'</td>';
                        }
                    }
                 else {
                    if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                        $frnExgEarnin .= '<td>'. $tot= ($FinanceAnnual[$i][EarninginForeignExchange]/$convalue); round($tot,2).'</td>';
                        }

                 }

                    }

           
            $frnExgOutgoin = '';
                    for($i=0;$i<count($FinanceAnnual);$i++){
                    if($_GET['queryString']!='INR'){
                        if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                         $frnExgOutgoin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                        }
                    }
                 else {
                    if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                        $frnExgOutgoin .= '<td>'. $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue); round($tot,2).'</td>';
                        }

                 }

                    }
                if($frnExgEarnin!='' || $frnExgOutgoin!=''){?>
                    
                    <tr>
                        <td><b>Foreign Exchange Earning and Outgo</b></td>
                    </tr>
              <?php  }
            if($frnExgEarnin!='')
                    {
                  ?>
              <tr>
                <td>Earning in Foreign Exchange</td>
              </tr>
              <?php
                }
            if($frnExgOutgoin!='')
            {
          ?>
              <tr>
                <td>Outgo in Foreign Exchange</td>
              </tr>
        <?php
            }
            ?>
            </tbody>
            </table>
    </div>
    <div class="tab-res" style="overflow-x: auto; margin:10px 0 !important;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
<?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        $str     = $FinanceAnnual[$i][FY];
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
  <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
   $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
    //print_r($yearcurrency);
    //echo "year:".$yearcurrency["13 311212"];
                if($_GET['queryString']!='INR'){?>
                    <td><?php 
                   if($yearcurrency[$year] ==''){
                    if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OptnlIncome]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
            }
            ?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
      $position= strpos($FinanceAnnual[$i][FY]," ");
      if($position!=''){
        $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
      }else{
        $year=$FinanceAnnual[$i][FY];
      }
    if($_GET['queryString']!='INR'){?>
        <td><?php 
        if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OtherIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
      }else{
        if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OtherIncome]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
      }
        ?>
        </td>
          <?php
    }
    else
    {
        ?> 
         <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OtherIncome]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OtherIncome]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
            <?php
    }
}
?>
  </tr>
  <tr>
 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
   $position= strpos($FinanceAnnual[$i][FY]," ");
   if($position!=''){
     $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
   }else{
     $year=$FinanceAnnual[$i][FY];
   }
   if($_GET['queryString']!='INR'){?>
    <td><b><?php 
          if($yearcurrency[$year] ==''){
          if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][TotalIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
        }else{
          if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][TotalIncome]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
        }?></b></td><?php
       }else
       {
           ?> 
            <?php if($_GET['rconv'] =='r'){ ?>
                           <td><b><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{$tot=($FinanceAnnual[$i][TotalIncome]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                       <?php } else { ?>
                           <td><b><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{$tot=($FinanceAnnual[$i][TotalIncome]/$convalue);echo round($tot,2); } ?></b></td>
                       <?php } ?>
               <?php
       }
    
}
?>
  </tr>
<!-- Value changes - xbrl2 start -->
 <tr>
              <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                $position= strpos($FinanceAnnual[$i][FY]," ");
                if($position!=''){
                  $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                }else{
                  $year=$FinanceAnnual[$i][FY];
                }
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][CostOfMaterialsConsumed],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][CostOfMaterialsConsumed]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){echo '-';}else{$tot=($FinanceAnnual[$i][CostOfMaterialsConsumed]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){echo '-';}else{$tot=($FinanceAnnual[$i][CostOfMaterialsConsumed]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }
                
            }
            ?>
              </tr>
              
              
              
              
            <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
               $position= strpos($FinanceAnnual[$i][FY]," ");
               if($position!=''){
                 $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
               }else{
                 $year=$FinanceAnnual[$i][FY];
               }
               if($_GET['queryString']!='INR'){?>
                <td><?php 
                      if($yearcurrency[$year] ==''){
                      if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][PurchasesOfStockInTrade],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][PurchasesOfStockInTrade]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><?php if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){echo '-';}else{$tot=($FinanceAnnual[$i][PurchasesOfStockInTrade]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                   <?php } else { ?>
                                       <td><?php if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){echo '-';}else{$tot=($FinanceAnnual[$i][PurchasesOfStockInTrade]/$convalue);echo round($tot,2); } ?></td>
                                   <?php } ?>
                           <?php
                   }
                
            }
            ?>
              </tr>
              
              
             <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
               $position= strpos($FinanceAnnual[$i][FY]," ");
               if($position!=''){
                 $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
               }else{
                 $year=$FinanceAnnual[$i][FY];
               }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual[$i][ChangesInInventories]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][ChangesInInventories],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual[$i][ChangesInInventories]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][ChangesInInventories]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><?php if($FinanceAnnual[$i][ChangesInInventories]==0){echo '-';}else{$tot=($FinanceAnnual[$i][ChangesInInventories]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                  <?php } else { ?>
                      <td><?php if($FinanceAnnual[$i][ChangesInInventories]==0){echo '-';}else{$tot=($FinanceAnnual[$i][ChangesInInventories]/$convalue);echo round($tot,2); } ?></td>
                  <?php } ?>
                  <?php
              }
                
            }
            ?>
              </tr>
             
              
            <tr data-for="Employee benifit expenses">
 
             <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
                if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EmployeeRelatedExpenses]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                  <?php } else { ?>
                      <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo round($tot,2); } ?></td>
                  <?php } ?>
                  <?php
              }
                
            }
            ?>
              </tr>
              
               <tr data-for="csr exp">
 
            <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
               if($_GET['queryString']!='INR'){?>
                <td><?php
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual[$i][CSRExpenditure]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][CSRExpenditure],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual[$i][CSRExpenditure]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][CSRExpenditure]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }
               ?></td>
               <?php
            }
            else
            { 
                ?> 
                <?php if($_GET['rconv'] =='r'){ ?>
                    <td><?php if($FinanceAnnual[$i][CSRExpenditure]==0){echo '-';}else{$tot=($FinanceAnnual[$i][CSRExpenditure]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                <?php } else { ?>
                    <td><?php if($FinanceAnnual[$i][CSRExpenditure]==0){echo '-';}else{$tot=($FinanceAnnual[$i][CSRExpenditure]/$convalue);echo round($tot,2); } ?></td>
                <?php } ?>
                <?php
            }
            }
            ?>
            </tr>
            <tr data-for="other exp">
 
            <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
               if($_GET['queryString']!='INR'){?>
                <td><?php
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual[$i][OtherExpenses]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OtherExpenses],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual[$i][OtherExpenses]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OtherExpenses]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }
               ?></td>
               <?php
            }
            else
            { 
                ?> 
                <?php if($_GET['rconv'] =='r'){ ?>
                    <td><?php if($FinanceAnnual[$i][OtherExpenses]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OtherExpenses]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                <?php } else { ?>
                    <td><?php if($FinanceAnnual[$i][OtherExpenses]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OtherExpenses]/$convalue);echo round($tot,2); } ?></td>
                <?php } ?>
                <?php
            }
            }
            ?>
            </tr>
      <!-- Value changes - xbrl2 end -->      

  <tr>
 <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
    if($_GET['queryString']!='INR'){?>
      <td><?php
     if($yearcurrency[$year] ==''){
      if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlAdminandOthrExp],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
     }else{
      if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OptnlAdminandOthrExp]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
     }
     ?></td>
     <?php
  }
  else
  { 
      ?> 
      <?php if($_GET['rconv'] =='r'){ ?>
          <td><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
      <?php } else { ?>
          <td><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);echo round($tot,2); } ?></td>
      <?php } ?>
      <?php
  }
   
}
?>
  </tr>
  <tr>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
        if($_GET['queryString']!='INR'){?>
          <td><?php
         if($yearcurrency[$year] ==''){
          if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlProfit],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }else{
          if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OptnlProfit]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }
         ?></td>
         <?php
      }
      else
      { 
          ?> 
          <?php if($_GET['rconv'] =='r'){ ?>
              <td><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OptnlProfit]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
          <?php } else { ?>
              <td><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OptnlProfit]/$convalue);echo round($tot,2); } ?></td>
          <?php } ?>
          <?php
      }
    
}
?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
       if($_GET['queryString']!='INR'){?>
        <td><b><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBITDA],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBITDA]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></b></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><b><?php if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBITDA]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
        <?php } else { ?>
            <td><b><?php if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBITDA]/$convalue);echo round($tot,2); } ?></b></td>
        <?php } ?>
        <?php
    }
   
}
?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
       if($_GET['queryString']!='INR'){?>
        <td><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][Interest]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Interest],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][Interest]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Interest]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><?php if($FinanceAnnual[$i][Interest]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Interest]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
        <?php } else { ?>
            <td><?php if($FinanceAnnual[$i][Interest]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Interest]/$convalue);echo round($tot,2); } ?></td>
        <?php } ?>
        <?php
    }
   
}
?>
  </tr>
  <tr>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
        if($_GET['queryString']!='INR'){?>
          <td><?php
         if($yearcurrency[$year] ==''){
          if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBDT],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }else{
          if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBDT]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }
         ?></td>
         <?php
      }
      else
      { 
          ?> 
          <?php if($_GET['rconv'] =='r'){ ?>
              <td><?php if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBDT]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
          <?php } else { ?>
              <td><?php if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBDT]/$convalue);echo round($tot,2); } ?></td>
          <?php } ?>
          <?php
      }
    
}
?>
  </tr>
  <tr>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
        if($_GET['queryString']!='INR'){?>
          <td><?php
         if($yearcurrency[$year] ==''){
          if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Depreciation],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }else{
          if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Depreciation]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }
         ?></td>
         <?php
      }
      else
      { 
          ?> 
          <?php if($_GET['rconv'] =='r'){ ?>
              <td><?php if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Depreciation]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
          <?php } else { ?>
              <td><?php if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Depreciation]/$convalue);echo round($tot,2); } ?></td>
          <?php } ?>
          <?php
      }
   
}
?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
       if($_GET['queryString']!='INR'){?>
        <td><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][EBT_before_Priod_period]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBT_before_Priod_period],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][EBT_before_Priod_period]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBT_before_Priod_period]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><?php if($FinanceAnnual[$i][EBT_before_Priod_period]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBT_before_Priod_period]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
        <?php } else { ?>
            <td><?php if($FinanceAnnual[$i][EBT_before_Priod_period]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBT_before_Priod_period]/$convalue);echo round($tot,2); } ?></td>
        <?php } ?>
        <?php
    }
               
            }
            ?>
              </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
       if($_GET['queryString']!='INR'){?>
        <td><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][Priod_period]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Priod_period],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][Priod_period]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Priod_period]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><?php if($FinanceAnnual[$i][Priod_period]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Priod_period]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
        <?php } else { ?>
            <td><?php if($FinanceAnnual[$i][Priod_period]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Priod_period]/$convalue);echo round($tot,2); } ?></td>
        <?php } ?>
        <?php
    }
   
            }
            ?>
              </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
      $position= strpos($FinanceAnnual[$i][FY]," ");
      if($position!=''){
        $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
      }else{
        $year=$FinanceAnnual[$i][FY];
      }
       if($_GET['queryString']!='INR'){?>
        <td><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][EBT]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBT],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][EBT]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBT]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><?php if($FinanceAnnual[$i][EBT]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBT]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
        <?php } else { ?>
            <td><?php if($FinanceAnnual[$i][EBT]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EBT]/$convalue);echo round($tot,2); } ?></td>
        <?php } ?>
        <?php
    }
   
}
?>
  </tr>
  <!-- Value changes - xbrl2 start -->
   <tr data-for="Current tax">
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                  $position= strpos($FinanceAnnual[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                  }else{
                    $year=$FinanceAnnual[$i][FY];
                  }
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$year] ==''){
                    if($FinanceAnnual[$i][CurrentTax]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][CurrentTax],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][CurrentTax]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][CurrentTax]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual[$i][CurrentTax]==0){echo '-';}else{$tot=($FinanceAnnual[$i][CurrentTax]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual[$i][CurrentTax]==0){echo '-';}else{$tot=($FinanceAnnual[$i][CurrentTax]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                }
                ?>
              </tr>
              
              
              <tr data-for="Deferred tax">
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                  $position= strpos($FinanceAnnual[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                  }else{
                    $year=$FinanceAnnual[$i][FY];
                  }
                   if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$year] ==''){
                    if($FinanceAnnual[$i][DeferredTax]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][DeferredTax],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][DeferredTax]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][DeferredTax]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual[$i][DeferredTax]==0){echo '-';}else{$tot=($FinanceAnnual[$i][DeferredTax]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual[$i][DeferredTax]==0){echo '-';}else{$tot=($FinanceAnnual[$i][DeferredTax]/$convalue);echo round($tot,2); } ?></td>
                    <?php } ?>
                    <?php
                }
                
                }
                ?>  
              </tr>
              <!-- Value changes - xbrl2 end -->
  <tr>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
       $position= strpos($FinanceAnnual[$i][FY]," ");
       if($position!=''){
         $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
       }else{
         $year=$FinanceAnnual[$i][FY];
       }
        if($_GET['queryString']!='INR'){?>
          <td><?php
         if($yearcurrency[$year] ==''){
          if($FinanceAnnual[$i][Tax]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Tax],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }else{
          if($FinanceAnnual[$i][Tax]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Tax]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
         }
         ?></td>
         <?php
      }
      else
      { 
          ?> 
          <?php if($_GET['rconv'] =='r'){ ?>
              <td><?php if($FinanceAnnual[$i][Tax]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Tax]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
          <?php } else { ?>
              <td><?php if($FinanceAnnual[$i][Tax]==0){echo '-';}else{$tot=($FinanceAnnual[$i][Tax]/$convalue);echo round($tot,2); } ?></td>
          <?php } ?>
          <?php
      }
    
}
?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){
      $position= strpos($FinanceAnnual[$i][FY]," ");
      if($position!=''){
        $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
      }else{
        $year=$FinanceAnnual[$i][FY];
      } 
       if($_GET['queryString']!='INR'){?>
        <td><b><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][PAT]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][PAT],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][PAT]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][PAT]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></b></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><b><?php if($FinanceAnnual[$i][PAT]==0){echo '-';}else{$tot=($FinanceAnnual[$i][PAT]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
        <?php } else { ?>
            <td><b><?php if($FinanceAnnual[$i][PAT]==0){echo '-';}else{$tot=($FinanceAnnual[$i][PAT]/$convalue);echo round($tot,2); } ?></b></td>
        <?php } ?>
        <?php
    }
   
}
?>
  </tr>
  <!-- Value changes - xbrl2 start -->
   <?php if($resulttype[0][ResultType] == 1){ ?>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                   $position= strpos($FinanceAnnual[$i][FY]," ");
                   if($position!=''){
                     $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                   }else{
                     $year=$FinanceAnnual[$i][FY];
                   }
                    if($_GET['queryString']!='INR'){?>
                      <td><?php
                     if($yearcurrency[$year] ==''){
                      if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][profit_loss_of_minority_interest],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }else{
                      if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][profit_loss_of_minority_interest]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }
                     ?></td>
                     <?php
                  }
                  else
                  { 
                      ?> 
                      <?php if($_GET['rconv'] =='r'){ ?>
                          <td><?php if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){echo '-';}else{$tot=($FinanceAnnual[$i][profit_loss_of_minority_interest]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                      <?php } else { ?>
                          <td><?php if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){echo '-';}else{$tot=($FinanceAnnual[$i][profit_loss_of_minority_interest]/$convalue);echo round($tot,2); } ?></td>
                      <?php } ?>
                      <?php
                  }
               
            }
            ?>
              </tr>

              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                   $position= strpos($FinanceAnnual[$i][FY]," ");
                   if($position!=''){
                     $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                   }else{
                     $year=$FinanceAnnual[$i][FY];
                   }
                    if($_GET['queryString']!='INR'){?>
                      <td><?php
                     if($yearcurrency[$year] ==''){
                      if($FinanceAnnual[$i][total_profit_loss_for_period]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][total_profit_loss_for_period],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }else{
                      if($FinanceAnnual[$i][total_profit_loss_for_period]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][total_profit_loss_for_period]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }
                     ?></td>
                     <?php
                  }
                  else
                  { 
                      ?> 
                      <?php if($_GET['rconv'] =='r'){ ?>
                          <td><?php if($FinanceAnnual[$i][total_profit_loss_for_period]==0){echo '-';}else{$tot=($FinanceAnnual[$i][total_profit_loss_for_period]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                      <?php } else { ?>
                          <td><?php if($FinanceAnnual[$i][total_profit_loss_for_period]==0){echo '-';}else{$tot=($FinanceAnnual[$i][total_profit_loss_for_period]/$convalue);echo round($tot,2); } ?></td>
                      <?php } ?>
                      <?php
                  }
                
            }
            ?>
              </tr>
          <?php } ?>
          <!-- Value changes - xbrl2 end --> 
  <tr>
      <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
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
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
      if($position!=''){
        $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
      }else{
        $year=$FinanceAnnual[$i][FY];
      }
       if($_GET['queryString']!='INR'){?>
         <td><?php
        if($yearcurrency[$year] ==''){
         if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][BINR],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
        }else{
         if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][BINR]/$yearcurrency[$year];$tot=$vale/$convalue;echo number_format($tot, 2, '.', ','); if($vale==''){echo '-';}} 
        }
        ?></td>
        <?php
     }
    else
    {
        ?>    
        <?php if($_GET['rconv'] =='r'){ ?>
             <td><?php if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $tot= ($FinanceAnnual[$i][BINR]);echo number_format($tot, 2, '.', ','); } ?></td>
        <?php } else { ?>  
         <td><?php if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $tot= ($FinanceAnnual[$i][BINR]);echo number_format($tot, 2, '.', ','); } ?></td>
         <?php } ?>
 <?php
    }
   
}
?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
      $position= strpos($FinanceAnnual[$i][FY]," ");
      if($position!=''){
        $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
      }else{
        $year=$FinanceAnnual[$i][FY];
      }
       if($_GET['queryString']!='INR'){?>
        <td><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][DINR],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][DINR]/$yearcurrency[$year];$tot=$vale/$convalue;echo number_format($tot, 2, '.', ','); if($vale==''){echo '-';}} 
       }
       ?></td>
       <?php
    }
    else
                {
                    ?>   
                    <?php if($_GET['rconv'] =='r'){ ?>
                     <td><?php if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $tot= ($FinanceAnnual[$i][DINR]);echo number_format($tot, 2, '.', ','); } ?></td>
                    <?php } else { ?>  
                     <td><?php if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $tot= ($FinanceAnnual[$i][DINR]);echo number_format($tot, 2, '.', ','); } ?></td>
                     <?php } ?>
             <?php
                }
    
}
?>
  </tr>
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
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
   <?php
    $EmpRelatedExp = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
     
        if($_GET['queryString']!='INR'){
            if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                        $EmpRelatedExp .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                    }
                }
 else {
        if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                        $EmpRelatedExp .= '<td>'. $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);round($tot,2).'</td>';
        }
     
 }
 
    }
    if($EmpRelatedExp!='')
    {
  //Changes - xbrl2
  if($runType['run_type'] != 1){ ?>
  <!-- <tr>
     <?php
     //echo $EmpRelatedExp;
    for($i=0;$i<count($FinanceAnnual);$i++){ 
      $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
      if($_GET['queryString']!='INR'){?>
        <td><?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }else{
        if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EmployeeRelatedExpenses]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
       }
       ?></td>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ ?>
            <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
        <?php } else { ?>
            <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{$tot=($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo round($tot,2); } ?></td>
        <?php } ?>
        <?php
    }
   
}
?>
  </tr> -->
    <?php }
    }
?>
  <tr>
  <?php 
    $frnExgEarnCont = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
      $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
      if($_GET['queryString']!='INR'){?>
       <?php
       if($yearcurrency[$year] ==''){
        if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
          $frnExgEarnCont .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
      }
    }else{
      if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
        $frnExgEarnCont .= '<td>'. $vale = $FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$yearcurrency[$year]; $tot=$vale/$convalue; round($tot,2).'</td>';
    }    
    
    }
       ?>
       <?php
    }
    else
    { 
        ?> 
        <?php if($_GET['rconv'] =='r'){ if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
            $frnExgEarnCont .= '<td>'. $tot= ($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue); round($tot,2).'</td>';
        }
         } else { if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
          $frnExgEarnCont .= '<td>'. $tot= ($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue); round($tot,2).'</td>';
      }
      } ?>
        <?php
    }
        

    }?>
  </tr>
      <?php //echo $frnExgEarnCont;
    if($frnExgEarnCont!='')
    {
  ?>
  
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
       
    if($_GET['queryString']!='INR'){?>
        <td><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
   <?php
    }
    else
    {
        ?>   
         <td><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue;echo round($tot,2); } ?></td>
 <?php
    }
}
?>
  </tr>
   <?php
    }?>
  <tr>
  <?php
    $frnExgEarnin = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
      $position= strpos($FinanceAnnual[$i][FY]," ");
      if($position!=''){
        $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
      }else{
        $year=$FinanceAnnual[$i][FY];
      }
 
        if($_GET['queryString']!='INR'){?>
          <?php
         if($yearcurrency[$year] ==''){
          if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
            $frnExgEarnin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue;round($tot,2).'</td>';
}
     
        }else{
          if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
            $frnExgEarnin .= '<td>'. $vale = $FinanceAnnual[$i][EarninginForeignExchange]/$yearcurrency[$year]; $tot=$vale/$convalue;round($tot,2).'</td>';
}
          
    }
  
        
         ?>
         <?php
      }
      else
      { 
          ?> 
          <?php if($_GET['rconv'] =='r'){ 
              if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
                $frnExgEarnin .= '<td>'. $tot= ($FinanceAnnual[$i][EarninginForeignExchange]/$convalue); round($tot,2).'</td>';
}
           } else { 
            if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
              $frnExgEarnin .= '<td>'. $tot= ($FinanceAnnual[$i][EarninginForeignExchange]/$convalue); round($tot,2).'</td>';
}
          } ?>
          <?php
      }
    }
        

           
                
              $frnExgOutgoin = '';
              
                for($i=0;$i<count($FinanceAnnual);$i++){
                  $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
                  if($_GET['queryString']!='INR'){?>
                    <?php
                   if($yearcurrency[$year] ==''){
                    if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                      $frnExgOutgoin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                 }
               
                  }else{
                    if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                      $frnExgOutgoin .= '<td>'. $vale = $FinanceAnnual[$i][OutgoinForeignExchange]/$yearcurrency[$year]; $tot=$vale/$convalue; round($tot,2).'</td>';
                 }
                   
              }
                  
                   ?>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ 
                       if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                        $frnExgOutgoin .= '<td>'. $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue); round($tot,2).'</td>';
                    }
                     } else { 
                      if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
                        $frnExgOutgoin .= '<td>'. $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue); round($tot,2).'</td>';
                    }
                    } ?>
                    <?php
                }
              

            }
            
            if($frnExgEarnin!='' || $frnExgOutgoin!='')
    { 
  ?>
  
  
  <tr>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
    if($_GET['queryString']!='INR'){?>
        <td>&nbsp;<?php /*if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} */?></td>
   <?php
    }
    else
    {
        ?>      
         <td>&nbsp;<?php/* if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][EarninginForeignExchange]/$convalue;echo round($tot,2); } */?></td>
 <?php
    }
}
?>
  </tr>
  
   <?php
  }
                
            if($frnExgEarnin!='')
            {
  ?>
  <tr>
 
                <?php 
                //echo $frnExgOutgoin;
                for($i=0;$i<count($FinanceAnnual);$i++){ 
                  $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
                  if($_GET['queryString']!='INR'){
                    if($yearcurrency[$year] ==''){
                    ?>
                      <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
                 <?php
               $frnExgOutgoin .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
          }else{?>
            <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EarninginForeignExchange]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
       <?php
     $frnExgOutgoin .= '<td>'. $vale = $FinanceAnnual[$i][OutgoinForeignExchange]/$yearcurrency[$year]; $tot=$vale/$convalue; round($tot,2).'</td>';


          }
        }
                  else
                  {
                      ?>      
                       <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $tot=($FinanceAnnual[$i][EarninginForeignExchange]/$convalue); echo round($tot,2); } ?></td>
               <?php
      }
          }
            ?>
  </tr>
      <?php 
            }
    if($frnExgOutgoin !='')
    { 
  ?>
              <tr>
 
                <?php 
                //echo  $frnExgOutgoin ;
                for($i=0;$i<count($FinanceAnnual);$i++){ 
                  $position= strpos($FinanceAnnual[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                  }else{
                    $year=$FinanceAnnual[$i][FY];
                  }
                  if($_GET['queryString']!='INR'){?>
                    <td><?php
                   if($yearcurrency[$year] ==''){
                    if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OutgoinForeignExchange]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php if($_GET['rconv'] =='r'){ ?>
                        <td><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                    <?php } else { ?>
                        <td><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{$tot=($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);echo round($tot,2); } ?></td>
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

</div><br>
<div style="font-size: 16px;">
   <!--<a  href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to check for latest financial year availability</a><br><br>-->
   <a class="updateFinancialDetail" href="javascript:void(0)" >Click here to check for latest financial year availability</a><br><br>
  </div>
<?php }


$fields1 = array("*");
$where1 = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='0' and a.ResultType='0'";
//Changes - xbrl2
//$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='".$resulttype[0][ResultType]."' and a.ResultType='".$resulttype[0][ResultType]."'";
$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='".$resulttypebalsheet[0][ResultType]."' and a.ResultType='".$resulttypebalsheet[0][ResultType]."'";
$where_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='0'";
//Changes - xbrl2
//$wherebs_new_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttype[0][ResultType]."'";
$wherebs_new_withoutPL = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttypebalsheet[0][ResultType]."'";
$order1 = "a.FY DESC";
$group1 = "a.FY";
// Changes - xbrl2 - cashflow
$fieldscf = array("a.cashflow_id","a.CId_FK","a.IndustryId_FK","a.CashflowApplicable","a.NetPLBefore","a.CashflowFromOperation",
"a.NetcashUsedInvestment","a.NetcashFromFinance","a.NetIncDecCash","a.EquivalentBeginYear","a.EquivalentEndYear","a.FY","a.ResultType");
$wherecf= "a.CId_FK = ".$_GET['vcid']." and a.ResultType='".$resulttypecashflow[0][ResultType]."'";
$ordercash = "a.FY DESC";
$groupcash = "a.FY";
$FinanceAnnual_cashflow = $cashflow->getFullList(1,100,$fieldscf,$wherecf,$ordercash,"name",$groupcash); 
$FinanceAnnual1 = $balancesheet->getFullList(1,100,$fields1,$where1,$order1,"name",$group1);
if(count($FinanceAnnual1)==0){
   $FinanceAnnual1 = $balancesheet->getFullList_withoutPL(1,100,$fields1,$where_withoutPL,$order1,"name"); 
}
$FinanceAnnual1_new = $balancesheet_new->getFullList(1,100,$fields1,$wherebs_new,$order1,"name",$group1); 
if(count($FinanceAnnual1_new)==0){
    $FinanceAnnual1_new = $balancesheet_new->getFullList_withoutPL(1,100,$fields1,$wherebs_new_withoutPL,$order1,"name"); 
} 


$whereradio = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='".$resulttype[0][ResultType]."' and b.ResultType=".$resulttype[0][ResultType]."";
$group1 = "a.FY";
//Old Balancesheet Ratio calculation
$RatioCalculation = $plstandard->radioFinacial($whereradio,$group1);
if(count($RatioCalculation)==0){
   $RatioCalculation1 = $plstandard->radioFinacial($whereradio,$group1);
}

//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($whereradio,$group1);
if(count($NewRatioCalculation)==0){
   $NewRatioCalculation1 = $plstandard->NewRatioFinacial($whereradio,$group1);
}
/*echo '<pre>';
print_r($FinanceAnnual1);
echo '</pre>';*/
?>

</div>
<?php  if(count($FinanceAnnual1) > 0 && count($FinanceAnnual1_new) > 0){ ?>
<div style="margin:1% 0;" class=" tab_menu" id="templateShow">
    <label for="new_temp"> <input type="radio" name="balsheet" value="2" id="new_temp" class="template" onChange="javascript:balsheet_ch();" checked="checked"> New Template</label>
    <label for="old_temp"> <input type="radio" name="balsheet" value="1" id="old_temp" class="template" onChange="javascript:balsheet_ch();"  > Old Template</label>
</div>
<?php } ?>
<div id="balancesheet" class="tab_menu">
   <!--  <h4 style="font-size: 18px;margin-bottom: 10px;position: absolute;margin-top: 20px;"><?php echo $runTypetext; ?> / <?php echo $resultTypetext; ?></h4> -->
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
        
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 70px !important;"> 
                  <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="openbalancesheet_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />

                  <div id="balancesheet_ex" style="position: absolute; width: 100%; display: none;  right: 0; text-align: right;">
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
                  <div class="finance-filter-custom" style="padding-top: 70px;">
                <select class="currencyselection" onchange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
                
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
               <!-- Changes - xbrl2 start-->
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
              <!-- Changes - xbrl2 end-->
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
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ShareCapital],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][ShareCapital]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ReservesSurplus],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][ReservesSurplus]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                <td><b><?php
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][TotalFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][TotalFunds]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }
               ?></b></td>
               <?php
            }
            else
            { 
                ?> 
                <?php if($_GET['rconv'] =='r'){ ?>
                    <td><b><?php if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][TotalFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                <?php } else { ?>
                    <td><b><?php if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][TotalFunds]/$convalue);echo round($tot,2); } ?></b></td>
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
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ShareApplication],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][ShareApplication]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
             <!--  Changes - xbrl2  start -->
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
                     if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1_new[$i][minority_interest]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][minority_interest],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                     }else{
                      if($FinanceAnnual1_new[$i][minority_interest]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][minority_interest]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                <!--  Changes - xbrl2  end -->
            
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
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_borrowings],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][L_term_borrowings]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][deferred_tax_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][deferred_tax_liabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_long_term_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_long_term_liabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_provisions],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][L_term_provisions]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  <td><b><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_non_current_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_non_current_liabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></b></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_non_current_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                  <?php } else { ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_non_current_liabilities]/$convalue);echo round($tot,2); } ?></b></td>
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_borrowings],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][S_term_borrowings]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Trade_payables],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Trade_payables]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_current_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_current_liabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_provisions],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][S_term_provisions]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  <td><b><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_current_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_current_liabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></b></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_current_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                  <?php } else { ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_current_liabilities]/$convalue);echo round($tot,2); } ?></b></td>
                  <?php } ?>
                  <?php
              }
              
              
             
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                  <td><b><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_equity_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_equity_liabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></b></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_equity_liabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                  <?php } else { ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_equity_liabilities]/$convalue);echo round($tot,2); } ?></b></td>
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Tangible_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Tangible_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Intangible_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Intangible_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_fixed_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_fixed_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][N_current_investments],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][N_current_investments]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Deferred_tax_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Deferred_tax_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_loans_advances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][L_term_loans_advances]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_non_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_non_current_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  <td><b><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_non_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_non_current_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></b></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><?php if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_non_current_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                  <?php } else { ?>
                      <td><?php if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][T_non_current_assets]/$convalue);echo round($tot,2); } ?></td>
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Current_investments]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Current_investments],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Current_investments]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Current_investments]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Inventories]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Inventories],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Inventories]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Inventories]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                 if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Trade_receivables],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Trade_receivables]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Cash_bank_balances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Cash_bank_balances]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_loans_advances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][S_term_loans_advances]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][O_current_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                   if($yearcurrency[$year] ==''){
                    if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_current_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][T_current_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  <td><b><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Total_assets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{ $vale = $FinanceAnnual1_new[$i][Total_assets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }
                 ?></b></td>
                 <?php
              }
              else
              { 
                  ?> 
                  <?php if($_GET['rconv'] =='r'){ ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Total_assets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                  <?php } else { ?>
                      <td><b><?php if($FinanceAnnual1_new[$i][Total_assets]==0){echo '-';}else{$tot=($FinanceAnnual1_new[$i][Total_assets]/$convalue);echo round($tot,2); } ?></b></td>
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
</div>
    <?php
    // }
 
         
     
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
     
<div id="old_balsheet" class="tab_menu" style="<?php if(count($FinanceAnnual1_new) > 0){ ?> display: none; <?php } ?> ">
    <?php $rowtype=mysql_query("select ResultType from balancesheet where CId_FK =". $_GET['vcid']." Group by ResultType"); 
    $resulttypecount=mysql_num_rows($rowtype);
     if ($resulttypecount == 1 || $resulttypecount == 2) {?>
            
                    <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 70px !important;"> 
                      <input  name="" type="button" id="check1" data-check2="close" value="BALANCE SHEET EXPORT" onClick="openbalancesheet_exold(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />
    
                      <div id="balancesheet_exold" style="position: absolute; width: 100%; display: none;  right: 0; text-align: right;padding-right: 18px;">
                      <?php if($resulttypecount == 1 || $resulttypecount == 2){?>
                   <!-- <input  name="" type="button" value="Standalone" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
                   <input  name="bsoldexportcompare"  type="button" value="Standalone"  id="bsoldexportcompare" style="  width: 180px;border-top: 0;" />
                   <?php } if ($resulttypecount == 2){?>
                   <!-- <input  name="" type="button" value="Consolidated" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}_1.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
                   <input  name="bsoldconexportcompare" type="button" value="Consolidated"  id="bsoldconexportcompare" style="  width: 180px;border-top: 0;" />
                   <?php }?>
                      </div>
                      </span> 
                      <?php }else{?>
                        <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 70px !important;"> 
                        <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="bsDataUpdateReq()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />
                    </span>
                      <?php }

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
        <h4 style="font-size: 16px;margin-top: 20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
    </div> <?php  } ?>
    <div class="finance-filter-custom" style="padding-top: 70px;">
                <select class="currencyselection" onchange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
                
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
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  } 
               if($_GET['queryString']!='INR'){?>
                <td><?php 
                      if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1[$i][ShareCapital]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][ShareCapital],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual1[$i][ShareCapital]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][ShareCapital]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }?></td><?php
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ShareCapital]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                   <?php } else { ?>
                                       <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ShareCapital]/$convalue);echo round($tot,2); } ?></td>
                                   <?php } ?>
                           <?php
                   }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1);$i++){
               $position= strpos($FinanceAnnual1[$i][FY]," ");
               if($position!=''){
                 $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
               }else{
                 $year=$FinanceAnnual1[$i][FY];
               }
               if($_GET['queryString']!='INR'){?>
                <td><b><?php 
                      if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1[$i][ShareApplication]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][ShareApplication],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual1[$i][ShareApplication]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][ShareApplication]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }?></b></td><?php
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><b><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ShareApplication]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                   <?php } else { ?>
                                       <td><b><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ShareApplication]/$convalue);echo round($tot,2); } ?></b></td>
                                   <?php } ?>
                           <?php
                   } 
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1);$i++){
               $position= strpos($FinanceAnnual1[$i][FY]," ");
               if($position!=''){
                 $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
               }else{
                 $year=$FinanceAnnual1[$i][FY];
               } 
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][ReservesSurplus],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][ReservesSurplus]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ReservesSurplus]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ReservesSurplus]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                   $position= strpos($FinanceAnnual1[$i][FY]," ");
                   if($position!=''){
                     $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                   }else{
                     $year=$FinanceAnnual1[$i][FY];
                   } 
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][TotalFunds]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][TotalFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][TotalFunds]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][TotalFunds]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][TotalFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][TotalFunds]/$convalue);echo round($tot,2); } ?></b></td>
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
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  } 
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][SecuredLoans]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][SecuredLoans],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][SecuredLoans]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][SecuredLoans]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][SecuredLoans]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][SecuredLoans]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  } 
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][UnSecuredLoans],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][UnSecuredLoans]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][UnSecuredLoans]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][UnSecuredLoans]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                   $position= strpos($FinanceAnnual1[$i][FY]," ");
                   if($position!=''){
                     $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                   }else{
                     $year=$FinanceAnnual1[$i][FY];
                   } 
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][LoanFunds]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][LoanFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][LoanFunds]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][LoanFunds]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][LoanFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][LoanFunds]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     }
            
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                   $position= strpos($FinanceAnnual1[$i][FY]," ");
                   if($position!=''){
                     $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                   }else{
                     $year=$FinanceAnnual1[$i][FY];
                   } 
               if($_GET['queryString']!='INR'){?>
                <td><b><?php 
                      if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherLiabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][OtherLiabilities]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }?></b></td><?php
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][OtherLiabilities]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                   <?php } else { ?>
                                       <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][OtherLiabilities]/$convalue);echo round($tot,2); } ?></b></td>
                                   <?php } ?>
                           <?php
                   }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  } 
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][DeferredTax]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][DeferredTax],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][DeferredTax]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][DeferredTax]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][DeferredTax]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][DeferredTax]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     }
              
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                   $position= strpos($FinanceAnnual1[$i][FY]," ");
                   if($position!=''){
                     $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                   }else{
                     $year=$FinanceAnnual1[$i][FY];
                   }
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][SourcesOfFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][SourcesOfFunds]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][SourcesOfFunds]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][SourcesOfFunds]/$convalue);echo round($tot,2); } ?></b></td>
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
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][GrossBlock]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][GrossBlock],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][GrossBlock]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][GrossBlock]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][GrossBlock]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][GrossBlock]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][LessAccumulated]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][LessAccumulated],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][LessAccumulated]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][LessAccumulated]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][LessAccumulated]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][LessAccumulated]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][NetBlock]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][NetBlock],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][NetBlock]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][NetBlock]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][NetBlock]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][NetBlock]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][CapitalWork]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][CapitalWork],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][CapitalWork]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][CapitalWork]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CapitalWork]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CapitalWork]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][FixedAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][FixedAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][FixedAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][FixedAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][FixedAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][FixedAssets]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                   if($_GET['queryString']!='INR'){?>
                    <td><b><?php 
                          if($yearcurrency[$year] ==''){
                          if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][IntangibleAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                        }else{
                          if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][IntangibleAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                        }?></b></td><?php
                       }else
                       {
                           ?> 
                            <?php if($_GET['rconv'] =='r'){ ?>
                                           <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][IntangibleAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                       <?php } else { ?>
                                           <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][IntangibleAssets]/$convalue);echo round($tot,2); } ?></b></td>
                                       <?php } ?>
                               <?php
                       } 
                
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherNonCurrent],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][OtherNonCurrent]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][OtherNonCurrent]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][OtherNonCurrent]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][Investments]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][Investments],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][Investments]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][Investments]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Investments]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Investments]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     } 
             
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
               if($_GET['queryString']!='INR'){?>
                <td><b><?php 
                    if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][DeferredTaxAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][DeferredTaxAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }?></b></td><?php
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][DeferredTaxAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                   <?php } else { ?>
                                       <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][DeferredTaxAssets]/$convalue);echo round($tot,2); } ?></b></td>
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
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                  if($_GET['queryString']!='INR'){?>
                    <td><?php 
                        if($yearcurrency[$year] ==''){
                          if($FinanceAnnual1[$i][SundryDebtors]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][SundryDebtors],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                        }else{
                          if($FinanceAnnual1[$i][SundryDebtors]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][SundryDebtors]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                        }?></td><?php
                       }else
                       {
                           ?> 
                            <?php if($_GET['rconv'] =='r'){ ?>
                                           <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][SundryDebtors]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                       <?php } else { ?>
                                           <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][SundryDebtors]/$convalue);echo round($tot,2); } ?></td>
                                       <?php } ?>
                               <?php
                       }  
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php 
                      if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][CashBankBalances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][CashBankBalances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][CashBankBalances]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][CashBankBalances]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CashBankBalances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CashBankBalances]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }  
            
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php 
                      if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][Inventories]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][Inventories],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][Inventories]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][Inventories]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Inventories]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Inventories]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }  
            
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php 
                      if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][LoansAdvances]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][LoansAdvances],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][LoansAdvances]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][LoansAdvances]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][LoansAdvances]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][LoansAdvances]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     }  
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php 
                      if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherCurrentAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][OtherCurrentAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][OtherCurrentAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                     <?php } else { ?>
                                         <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][OtherCurrentAssets]/$convalue);echo round($tot,2); } ?></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][CurrentAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][CurrentAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][CurrentAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][CurrentAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CurrentAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CurrentAssets]/$convalue);echo round($tot,2); } ?></b></td>
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
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
               if($_GET['queryString']!='INR'){?>
                <td><?php 
                    if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1[$i][Provisions]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][Provisions],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual1[$i][Provisions]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][Provisions]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }?></td><?php
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Provisions]/$convalue);echo numberFormat(round($tot,2)); } ?></td>
                                   <?php } else { ?>
                                       <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Provisions]/$convalue);echo round($tot,2); } ?></td>
                                   <?php } ?>
                           <?php
                   } 
            
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][CurrentLiabilitiesProvision],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][CurrentLiabilitiesProvision]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CurrentLiabilitiesProvision]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][CurrentLiabilitiesProvision]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     }  
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][NetCurrentAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][NetCurrentAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][NetCurrentAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][NetCurrentAssets]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  } 
               if($_GET['queryString']!='INR'){?>
                <td><b><?php 
                      if($yearcurrency[$year] ==''){
                      if($FinanceAnnual1[$i][ProfitLoss]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][ProfitLoss],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }else{
                      if($FinanceAnnual1[$i][ProfitLoss]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][ProfitLoss]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                    }?></b></td><?php
                   }else
                   {
                       ?> 
                        <?php if($_GET['rconv'] =='r'){ ?>
                                       <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ProfitLoss]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                   <?php } else { ?>
                                       <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][ProfitLoss]/$convalue);echo round($tot,2); } ?></b></td>
                                   <?php } ?>
                           <?php
                   } 
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><b><?php 
                        if($yearcurrency[$year] ==''){
                        if($FinanceAnnual1[$i][Miscellaneous]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][Miscellaneous],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }else{
                        if($FinanceAnnual1[$i][Miscellaneous]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][Miscellaneous]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                      }?></b></td><?php
                     }else
                     {
                         ?> 
                          <?php if($_GET['rconv'] =='r'){ ?>
                                         <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Miscellaneous]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                     <?php } else { ?>
                                         <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][Miscellaneous]/$convalue);echo round($tot,2); } ?></b></td>
                                     <?php } ?>
                             <?php
                     } 
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                  $position= strpos($FinanceAnnual1[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual1[$i][FY]);
                  }else{
                    $year=$FinanceAnnual1[$i][FY];
                  }
                    $totalAsserts = $FinanceAnnual1[$i][FixedAssets] + $FinanceAnnual1[$i][IntangibleAssets] + $FinanceAnnual1[$i][OtherNonCurrent] + $FinanceAnnual1[$i][Investments] + $FinanceAnnual1[$i][DeferredTaxAssets] + $FinanceAnnual1[$i][NetCurrentAssets] + $FinanceAnnual1[$i][ProfitLoss] + $FinanceAnnual1[$i][Miscellaneous]; 
                    $FinanceAnnual1[$i][TotalAssets] = ($FinanceAnnual1[$i][TotalAssets]==0)? $totalAsserts : $FinanceAnnual1[$i][TotalAssets];                
                                      
                    if($_GET['queryString']!='INR'){?>
                      <td><b><?php 
                            if($yearcurrency[$year] ==''){
                            if($FinanceAnnual1[$i][TotalAssets]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual1[$i][TotalAssets],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                          }else{
                            if($FinanceAnnual1[$i][TotalAssets]==0){echo '-';}else{ $vale = $FinanceAnnual1[$i][TotalAssets]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                          }?></b></td><?php
                         }else
                         {
                             ?> 
                              <?php if($_GET['rconv'] =='r'){ ?>
                                             <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][TotalAssets]/$convalue);echo numberFormat(round($tot,2)); } ?></b></td>
                                         <?php } else { ?>
                                             <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '-';}else{$tot=($FinanceAnnual1[$i][TotalAssets]/$convalue);echo round($tot,2); } ?></b></td>
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

//$where = "a.CId_FK = ".$_GET['vcid'];
//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($whereradio,$group1);
//Old Balancesheet Ratio calculation
$RatioCalculation = $plstandard->radioFinacial($whereradio,$group1);
   ?> 
</div>
<div style="clear:both;"></div>
<div id="ratio" class="tab_menu" style="margin-top: 10px;">
 
 <div id="new_ratio" style="<?php if(count($NewRatioCalculation) >0) { ?> display:block;clear:both; <?php } else{ ?> display:none; <?php }?>">
    <?php $rowtype=mysql_query("select ResultType from balancesheet_new where CId_FK =". $_GET['vcid']." Group by ResultType"); 
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
        <div class="detail-table" style="    margin-top: 0px !important;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">     
                <tHead> <tr>
                <th>Ratios</th>
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
                    <td>Current Ratio</td>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['T_current_assets'];  
                                    $a=$NewRatioCalculation[$i]['T_current_liabilities'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td>Quick Ratio</td>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['T_current_assets'];  
                                    $y = $NewRatioCalculation[$i]['Inventories'];
                                    $a=$NewRatioCalculation[$i]['T_current_liabilities'];
                                    $equation=($x-$y)/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td>RoE</td>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['PAT'];  
                                    $a=$NewRatioCalculation[$i]['TotalFunds'];
                                    $equation=$x/$a; if($equation !='') { printf("%.2f",$equation); }else { ?>&nbsp;<?php } ?></td>
                     <?php } ?>
                  </tr>  
                  <tr>
                    <td>RoA</td>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['PAT'];  
                                    $a=$NewRatioCalculation[$i]['Total_assets'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>  
                   <tr>
                    <td>EBITDA Margin</td>
                     <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                        <td><?php $x=$NewRatioCalculation[$i]['EBITDA'];  
                                    $y = $NewRatioCalculation[$i]['TotalIncome'];
                                    $a=100;
                                    $equation=($x/$y)*$a; printf("%.2f",$equation);echo '%'; ?></td>
                    <?php } ?>
                  </tr>  
                  <tr>
                    <td>PAT Margin</td>
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
                            <td>Contribution margin</td>
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
<div id="old_ratio" style="<?php if(count($NewRatioCalculation) == 0) { ?> display:block; clear:both;<?php } else{ ?> display:none; <?php }?>">
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
        <h4 style="font-size: 16px;margin-top:20px;"> <span style="margin-left: 8px;font-size:12px;"><?php echo $runTypetext; ?></span></h4>
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
                  <tr>
                    <td>Current Ratio</td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['CurrentAssets'];  
                                    $a=$RatioCalculation[$i]['CurrentLiabilitiesProvision'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td>Quick Ratio</td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['CurrentAssets'];  
                                    $y = $RatioCalculation[$i]['Inventories'];
                                    $a=$RatioCalculation[$i]['CurrentLiabilitiesProvision'];
                                    $equation=($x-$y)/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>
                  <tr>
                    <td>RoE</td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['PAT'];  
                                    $a=$RatioCalculation[$i]['TotalFunds'];
                                    $equation=$x/$a; if($equation !='') { printf("%.2f",$equation); }else { ?>&nbsp;<?php } ?></td>
                     <?php } ?>
                  </tr>  
                  <tr>
                    <td>RoA</td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['PAT'];  
                                    $a=$RatioCalculation[$i]['TotalAssets'];
                                    $equation=$x/$a; printf("%.2f",$equation); ?></td>
                    <?php } ?>
                  </tr>  
                   <tr>
                    <td>EBITDA Margin</td>
                     <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                        <td><?php $x=$RatioCalculation[$i]['EBITDA'];  
                                    $y = $RatioCalculation[$i]['TotalIncome'];
                                    $a=100;
                                    $equation=($x/$y)*$a; printf("%.2f",$equation);echo '%'; ?></td>
                    <?php } ?>
                  </tr>  
                  <tr>
                    <td>PAT Margin</td>
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
                        <tr>
                            <td>Contribution margin</td>
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
        
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 70px !important;"> 
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
                  $position= strpos($FinanceAnnual_cashflow[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual_cashflow[$i][FY]);
                  }else{
                    $year=$FinanceAnnual_cashflow[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual_cashflow[$i][NetPLBefore]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetPLBefore],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual_cashflow[$i][NetPLBefore]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetPLBefore]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  $position= strpos($FinanceAnnual_cashflow[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual_cashflow[$i][FY]);
                  }else{
                    $year=$FinanceAnnual_cashflow[$i][FY];
                  }
               if($_GET['queryString']!='INR'){?>
                <td><?php
               if($yearcurrency[$year] ==''){
                if($FinanceAnnual_cashflow[$i][CashflowFromOperation]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][CashflowFromOperation],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual_cashflow[$i][CashflowFromOperation]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][CashflowFromOperation]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  $position= strpos($FinanceAnnual_cashflow[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual_cashflow[$i][FY]);
                  }else{
                    $year=$FinanceAnnual_cashflow[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetcashUsedInvestment],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual_cashflow[$i][NetcashUsedInvestment]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetcashUsedInvestment]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  $position= strpos($FinanceAnnual_cashflow[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual_cashflow[$i][FY]);
                  }else{
                    $year=$FinanceAnnual_cashflow[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual_cashflow[$i][NetcashFromFinance]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetcashFromFinance],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual_cashflow[$i][NetcashFromFinance]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetcashFromFinance]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  $position= strpos($FinanceAnnual_cashflow[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual_cashflow[$i][FY]);
                  }else{
                    $year=$FinanceAnnual_cashflow[$i][FY];
                  }
                 if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual_cashflow[$i][NetIncDecCash]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][NetIncDecCash],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual_cashflow[$i][NetIncDecCash]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][NetIncDecCash]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                  $position= strpos($FinanceAnnual_cashflow[$i][FY]," ");
                  if($position!=''){
                    $year=str_replace(" ","_",$FinanceAnnual_cashflow[$i][FY]);
                  }else{
                    $year=$FinanceAnnual_cashflow[$i][FY];
                  }
                if($_GET['queryString']!='INR'){?>
                  <td><?php
                 if($yearcurrency[$year] ==''){
                  if($FinanceAnnual_cashflow[$i][EquivalentEndYear]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual_cashflow[$i][EquivalentEndYear],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                 }else{
                  if($FinanceAnnual_cashflow[$i][EquivalentEndYear]==0){echo '-';}else{ $vale = $FinanceAnnual_cashflow[$i][EquivalentEndYear]/$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
<div class="lb" id="plexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrack.php?vcid=<?php echo $_GET['vcid'];?>&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-plexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div id="maskscreen"></div>
<div class="lb" id="plconexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrack.php?vcid=<?php echo $_GET['vcid'];?>&type=consolidated&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-plconexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div id="maskscreen"></div>
<div class="lb" id="bsexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackBS.php?vcid=<?php echo $_GET['vcid'];?>&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-bsexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div id="maskscreen"></div>
<div class="lb" id="bsconexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackBS.php?vcid=<?php echo $_GET['vcid'];?>&type=consolidated&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-bsconexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
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
<div id="maskscreen"></div>
<div class="lb" id="bsoldexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackBS.php?vcid=<?php echo $_GET['vcid'];?>&template=old&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-bsoldexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div id="maskscreen"></div>
<div class="lb" id="bsoldconexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackBS.php?vcid=<?php echo $_GET['vcid'];?>&template=old&type=consolidated&queryString=<?php echo $_GET['queryString'];?>&rconv=<?php echo $_GET['rconv'];?>','_blank')" class="agree-bsoldconexport">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>

<script type="text/javascript" >
// $(document).ready(function(){
//   if($('.cfs_menu').length > 1){
//       $('.cfs_menu').eq(1).remove();
//   }
//   if($('.finance-filter-custom').length > 1){
//       $('.finance-filter-custom').eq(1).remove();
//   }
// });
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
        //cf export
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
        $('input[name=bsoldexportcompare]#bsoldexportcompare').click(function(){
              jQuery('#balancesheet_parent #maskscreen').fadeIn(1000);
              $( '#bsoldexport-popup' ).show();
              return false; 
            });
        $( '.agree-bsoldexport').on( 'click', function() {    
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
            $( '#bsoldexport-popup' ).hide();
            return false;
        });
        $( '#bsoldexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#bsoldexport-popup' ).hide();
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
        });
$('input[name=bsoldconexportcompare]#bsoldconexportcompare').click(function(){
              jQuery('#balancesheet_parent #maskscreen').fadeIn(1000);
              $( '#bsoldconexport-popup' ).show();
              return false; 
            });
        $( '.agree-bsoldconexport').on( 'click', function() {    
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
            $( '#bsoldconexport-popup' ).hide();
            return false;
        });
        $( '#bsoldconexport-popup' ).on( 'click', '.close-lookup', function() {
            $( '#bsoldconexport-popup' ).hide();
            jQuery('#balancesheet_parent #maskscreen').fadeOut(1000);
        });

$(document).ready(function(){
 if($('#activeSubmenu').val() == 'profit-loss') {
        $( '.cagrlabel' ).show();
    } else {
        $( '.cagrlabel' ).hide();
    }
});

$(".cfs_menu").on('click', '.subMenu', function() {

    var row = $(this).attr('data-row');
    if(row == 'profit-loss') {
        $( '.cagrlabel' ).show();
    } else {
        $( '.cagrlabel' ).hide();
    }
    $(".cfs_menu ul li").removeClass('current');
    $(this).addClass('current');
    $('#activeSubmenu').val(row);
    tabMenu(row);

});

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