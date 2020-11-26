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
$Insert_CProfile1['Visit'] = substr_count($Insert_CProfile1['visitcompany'], ',');
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

?>
<?php 
   // echo count($FinanceAnnual);echo count($FinanceAnnual1);echo count($FinanceAnnual1_new);
    if((count($FinanceAnnual) > 0) || (count($FinanceAnnual1) > 0) || (count($FinanceAnnual1_new)  > 0)||(count($FinanceAnnual_cashflow) > 0)){
    ?>


<!--<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid=<?php echo $_GET['vcid']; ?>">See Projection</a></div>-->
<div class="cfs_menu">
    <ul>
        <li class="current subMenu" data-row="profit-loss" href="javascript:;" onclick="javascript:plresult(<?php echo $_GET['vcid'];?>);">PROFIT &amp; LOSS</li>
        <li data-row="balancesheet" href="javascript:;" class="subMenu"  onclick="javascript:balancesheetresult(<?php echo $_GET['vcid'];?>);">BALANCE SHEET</li>
        <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; echo 'onclick=javascript:cfresult('.$_GET['vcid'].')'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> id="cashMenu" >CASH FLOW</li>
        <!-- <li data-row="cashflow" href="javascript:;" <?php if(count($FinanceAnnual_cashflow) != 0){ echo 'class="subMenu"'; }?> <?php if(count($FinanceAnnual_cashflow) == 0){ echo $displaystyle; }?> id="cashMenu" onclick="javascript:cfresult(<?php echo $_GET['vcid'];?>);">CASH FLOW</li> -->
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
<div class="tab_menu" id="profit-loss" style="display:block;">
<?php
    if( $companyDetails[0]['listingstatus'] == 1 ) {
        //$style = 'display: none;';
        $style = '';
    } else {
        $style = '';
    }
?>
<?php if(BASE_URL == "//dev.vionweb.com/" || BASE_URL == "//localhost/vi_webapp/"){?>
<div class="growth_fulldetails" style="<?php echo $style; ?>">
    <?php
    $growth_precentage = array();
     $ResultType1="SELECT MAX( ResultType ) AS ResultType FROM cagr WHERE CId_FK =".$_GET['vcid']." AND FY !=  ''";
    $query=mysql_query($ResultType1);
    $resultType=mysql_fetch_array($query);
    /*$growth_years=mysql_query("SELECT g.EBITDA as g_ebitda,g.TotalIncome as g_totalIncome,g.PAT as g_pat, p.TotalIncome as p_totalIncome, p.EBITDA as p_ebitda, p.PAT as p_pat, p.FY FROM `cagr` as g, plstandard as p WHERE g.CId_FK = p.CId_FK and g.FY=p.FY and g.CId_FK='".$_GET['vcid']."' and p.ResultType='0' GROUP BY g.CAGRYear order by g.CAGRYear,p.FY asc");*/
    $growth_years=mysql_query("SELECT g.EBITDA as g_ebitda,g.TotalIncome as g_totalIncome,g.PAT as g_pat, p.TotalIncome as p_totalIncome, p.EBITDA as p_ebitda, p.PAT as p_pat, g.FY as FY FROM `cagr` as g, plstandard as p WHERE g.CId_FK = p.CId_FK and g.FY=p.FY and g.ResultType= p.ResultType and g.CId_FK='".$_GET['vcid']."' and g.ResultType='".$resultType[ResultType]."' GROUP BY g.CAGRYear order by g.CAGRYear,p.FY asc");
   /* $a ="SELECT g.EBITDA as g_ebitda,g.TotalIncome as g_totalIncome,g.PAT as g_pat, p.TotalIncome as p_totalIncome, p.EBITDA as p_ebitda, p.PAT as p_pat, p.FY FROM `cagr` as g, plstandard as p WHERE g.CId_FK = p.CId_FK and g.FY=p.FY and g.CId_FK='".$_GET['vcid']."' and p.ResultType='".$resultType['ResultType']."' GROUP BY g.CAGRYear order by g.CAGRYear,p.FY asc";
    echo $a;*/
   /* echo $resultType['ResultType'];*/
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
                $last_years=mysql_query("SELECT TotalIncome as p_totalIncome, EBITDA as p_ebitda, PAT as p_pat FROM plstandard WHERE FY='$cal_year' and ResultType='".$resultType[ResultType]."' and CId_FK='".$_GET['vcid']."' limit 0,1");
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
                                                     $vale = $latest_p_totalIncome*$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }
                                                 }
                                             }else{ ?>
                                                <?php if($_GET['rconv'] =='r'){ ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo numberFormat(round(($latest_p_ebitda/$convalue),2)); ?>
                                             	<?php } else { ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo round(($latest_p_ebitda/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M"; ?>
                                             	<?php } ?>
                                           <?php } ?>
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
                                                     //$vale = currency_convert($p_totalIncome,'INR',$_GET['queryString']);
                                                     $vale = $p_totalIncome*$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }
                                                 }
                                             }else{ ?>
                                              <?php if($_GET['rconv'] =='r'){ ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo numberFormat(round(($p_totalIncome/$convalue),2)); ?>
                                             	<?php } else { ?>
                                                    <?php echo $_GET['queryString'].'&nbsp'; echo round(($p_totalIncome/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";?>
                                             	<?php } ?>
                                           <?php } ?>
                                     </span>
                                 </div>
                                  <div class="ebitda_details">
                                      <span class="<?php echo $g_ebitda_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($latest_p_ebitda==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                     //$vale = currency_convert($latest_p_ebitda,'INR',$_GET['queryString']); 
                                                     $vale = $latest_p_ebitda*$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                        
                                                 }
                                             }else{ ?>
                                             <?php if($_GET['rconv'] =='r'){ ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo numberFormat(round(($latest_p_ebitda/$convalue),2)); ?>
                                             	<?php } else { ?>
                                                    <?php echo $_GET['queryString'].'&nbsp'; echo round(($latest_p_ebitda/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";?>
                                             	<?php } ?>
                                           <?php } ?>
                                             </span>
                                     <span class="<?php echo $g_ebitda_arrow; ?>_bg">&nbsp;</span>
                                     <span class="<?php echo $g_ebitda_arrow; ?>_content">
                                          <p><?php echo $growth_precentage[$growth_year-1]['g_ebitda']; ?>%</p>
                                     </span>
                                     <span class="<?php echo $g_ebitda_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($p_ebitda==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                    // $vale = currency_convert($p_ebitda,'INR',$_GET['queryString']); 
                                                    $vale = $p_ebitda*$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     }else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                        
                                                 }
                                             }else{ ?>
                                             <?php if($_GET['rconv'] =='r'){ ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo numberFormat(round(($p_ebitda/$convalue),2)); ?>
                                             	<?php } else { ?>
                                                    <?php echo $_GET['queryString'].'&nbsp'; echo round(($p_ebitda/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";?>
                                             	<?php } ?>
                                           <?php } ?></span>
                                 </div>
                                  <div class="pat_details">
                                      <span class="<?php echo $g_pat_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($latest_p_pat==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                    // $vale = currency_convert($latest_p_pat,'INR',$_GET['queryString']);
                                                    $vale = $latest_p_pat*$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     } else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                       
                                                 }
                                             }else{ ?>
                                             <?php if($_GET['rconv'] =='r'){ ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo numberFormat(round(($latest_p_pat/$convalue),2)); ?>
                                             	<?php } else { ?>
                                                    <?php echo $_GET['queryString'].'&nbsp'; echo round(($latest_p_pat/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";?>
                                             	<?php } ?>
                                           <?php } ?></span>
                                     <span class="<?php echo $g_pat_arrow; ?>_bg">&nbsp;</span>
                                     <span class="<?php echo $g_pat_arrow; ?>_content">
                                          <p><?php echo $growth_precentage[$growth_year-1]['g_pat']; ?>%</p>
                                     </span>
                                     <span class="<?php echo $g_pat_arrow; ?>_amount"><?php 
                                             if($_GET['queryString']!='INR'){ 
                                                 if($p_pat==0){
                                                     echo '&nbsp';                                        
                                                 }else{
                                                    // $vale = currency_convert($p_pat,'INR',$_GET['queryString']);
                                                    $vale = $p_pat*$yearcurrency[$growth_precentage[$growth_year]['FY']];
                                                     if($vale==''){
                                                         echo '&nbsp';                                            
                                                     } else{ 
                                                         echo $_GET['queryString'].'&nbsp'; $tot=$vale/$convalue;echo round($tot,2);  if($_GET['rconv']=='m') echo " M";
                                                     }                                       
                                                 }
                                             }else{ ?>
                                             <?php if($_GET['rconv'] =='r'){ ?>
                                             		<?php echo $_GET['queryString'].'&nbsp';  echo numberFormat(round(($p_pat/$convalue),2)); ?>
                                             	<?php } else { ?>
                                                    <?php echo $_GET['queryString'].'&nbsp'; echo round(($p_pat/$convalue),2); if($_GET['rconv']=='c') echo " CR";  if($_GET['rconv']=='m') echo " M";?>
                                             	<?php } ?>
                                           <?php } ?></span>
                                 </div>
                             </div>

                         </div>
        <?php  } $j++; }      ?>
   <div class="">
   </div>
</div> 
    <?php } }
    if(count($FinanceAnnual) > 0){
     $Fycount=0;
     for($i=0;$i<count($FinanceAnnual);$i++){
         if($FinanceAnnual[$i][FY] !='' && $FinanceAnnual[$i][FY]>0)
         {
             $Fycount++;
         }
     }
     if($Fycount > 0)
     {if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls')){
            $PLSTANDARD_MEDIA_PATH=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';
        }
        if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls')){
            $PLSTANDARD_MEDIA_PATH_CON=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls';
            
        }
       
        ?>
        <?php if($PLSTANDARD_MEDIA_PATH || $PLSTANDARD_MEDIA_PATH_CON){?>
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 0px !important;"> 
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
                <span class="btn-cnt" style="  /*position: relative;float:right;*/position: absolute;float: right;right: 0;padding-right: 18px;padding-top: 0px !important;"> 
                    <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="plDataUpdateReq()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />
                </span>
              <?php } if($PLDETAILED_MEDIA_PATH){?>
                            <input  name="" type="button"  value="Detailed P&L EXPORT" onClick="window.open('<?php echo MEDIA_PATH?>pldetailed/PLDetailed_{$VCID}.xls?time={$smarty.now}','_blank')" />
                <?php }?>


                 <div class="finance-filter-custom" style="padding-top: 0px;display:inline-flex">
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
    <select class="currencyconversion"  name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
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
   <!--  <h4 style="font-size: 18px;margin-bottom: 10px;position: absolute;margin-top: -40px;"><?php echo $runTypetext; ?> / <?php echo $resultTypetext; ?></h4>  -->
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
            
              <tr>
                <td>Employee benefit expense</td>
              </tr>
              
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
               <?php if($resulttype[0][ResultType] == 1){ ?>
                <tr>
                    <td>Profit (loss) of minority interest</td>
                </tr>
                <tr>
                    <td>Total profit (loss) for period</td>
                </tr>
              <?php } ?>
              <tr>
                <td><b>EPS</b></td>
              </tr>
              <tr>
                <td>EPS Basic (in INR)</td>
              </tr>
              <tr>
                <td>EPS Diluted (in INR)</td>
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
                  ?>
                  <!--  Changes - xbrl2  start -->
             <?php if($runType['run_type'] != 1){ ?>
              <!-- <tr>
                    <td>Employee Related Expenses</td>
               
              </tr> -->
               <?php } ?>
               <!--  Changes - xbrl2  end -->
              <?php
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
                    if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OptnlIncome]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }
                   ?></td>
                   <?php
                }
                else
                { 
                    ?> 
                    <?php  if($_GET['rconv'] =='r'){ ?>
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
                    if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OtherIncome]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
                  }
                    ?>
                    </td>
                      <?php
                }
                else
                {
                    ?> 
                     <?php   if($_GET['rconv'] =='r'){ ?>
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
                          if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][TotalIncome]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
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
              <!--  Changes - xbrl2  start -->
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
                          if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][CostOfMaterialsConsumed]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
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
                          if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][PurchasesOfStockInTrade]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][ChangesInInventories]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][ChangesInInventories]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EmployeeRelatedExpenses]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
            if($FinanceAnnual[$i][CSRExpenditure]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][CSRExpenditure],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
           }else{
            if($FinanceAnnual[$i][CSRExpenditure]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][CSRExpenditure]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                if($FinanceAnnual[$i][OtherExpenses]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OtherExpenses],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual[$i][OtherExpenses]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OtherExpenses]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
            <!--  Changes - xbrl2  end -->
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
                if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlAdminandOthrExp],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OptnlAdminandOthrExp]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlProfit],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OptnlProfit]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBITDA],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBITDA]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][Interest]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Interest],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][Interest]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Interest]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBDT],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBDT]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Depreciation],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Depreciation]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][EBT_before_Priod_period]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBT_before_Priod_period],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
                   }else{
                    if($FinanceAnnual[$i][EBT_before_Priod_period]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBT_before_Priod_period]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                if($FinanceAnnual[$i][Priod_period]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Priod_period],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
               }else{
                if($FinanceAnnual[$i][Priod_period]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Priod_period]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                if($FinanceAnnual[$i][EBT]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EBT]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
              <!--  Changes - xbrl2  start -->
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
                    if($FinanceAnnual[$i][CurrentTax]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][CurrentTax]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][DeferredTax]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][DeferredTax]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
            <!--  Changes - xbrl2  end -->
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
                    if($FinanceAnnual[$i][Tax]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][Tax]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                if($FinanceAnnual[$i][PAT]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][PAT]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
              <!--  Changes - xbrl2  start -->
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
                if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][profit_loss_of_minority_interest]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][total_profit_loss_for_period]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][total_profit_loss_for_period]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
          <!--  Changes - xbrl2  end -->
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
                     if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][BINR]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][DINR]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
                    $position= strpos($FinanceAnnual[$i][FY]," ");
    if($position!=''){
      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
    }else{
      $year=$FinanceAnnual[$i][FY];
    }
                    if($_GET['queryString']!='INR'){?>
                        <td><?php
                       if($yearcurrency[$year] ==''){
                        if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                          $EmpRelatedExp .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']); $tot=$vale/$convalue; round($tot,2).'</td>';
                      }
                   }else{
                    if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                      $EmpRelatedExp .= '<td>'. $vale = $FinanceAnnual[$i][EmployeeRelatedExpenses]*$yearcurrency[$year]; $tot=$vale/$convalue; round($tot,2).'</td>';
                  }
                }
                       
                       ?></td>
                       <?php
                    }
                    else
                    { 
                        ?> 
                        <?php if($_GET['rconv'] =='r'){ 
                          if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                                        $EmpRelatedExp .= '<td>'. $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);round($tot,2).'</td>';
                        }
                             } else { 
                           if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
                                        $EmpRelatedExp .= '<td>'. $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);round($tot,2).'</td>';
                        } } ?>
                        <?php
                    }

                }
                if($EmpRelatedExp!='')
                {
              ?>
               <?php if($runType['run_type'] != 1){ ?>
              <!-- <tr>
 
                 <?php 
                 //echo $EmpRelatedExp;
                 for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></td>
               <?php
                }
                else
                {
                    ?>      
                    <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr> -->
               <?php } ?>
              <?php
                }

           /*     $frnExgEarnCont = '';
                for($i=0;$i<count($FinanceAnnual);$i++){
                    if($_GET['queryString']!='INR'){
                        if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
                        $frnExgEarnCont .= '<td>'. $vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_GET['queryString']); $tot=$vale/$convalue;round($tot,2).'</td>';
                    }
                }
             else {
                    if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
                        $frnExgEarnCont .= '<td>'. $tot= ($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue);round($tot,2).'</td>';
                    }

             }

                }
                if($frnExgEarnCont!='')
                {
              ?>

              <tr>
 
                <?php 

                //echo $frnExgEarnCont;
               for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_GET['queryString']); $tot=$vale/$convalue;round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
               <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue);round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <?php
                }*/
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
                      $frnExgEarnin .= '<td>'. $vale = $FinanceAnnual[$i][EarninginForeignExchange]*$yearcurrency[$year]; $tot=$vale/$convalue;round($tot,2).'</td>';
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
                          $frnExgOutgoin .= '<td>'. $vale = $FinanceAnnual[$i][OutgoinForeignExchange]*$yearcurrency[$year]; $tot=$vale/$convalue; round($tot,2).'</td>';
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
            }
                
            if($frnExgEarnin!='')
            {
              ?>
              <tr>
 
                <?php 
                //echo $frnExgEarnin;
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
        <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][EarninginForeignExchange]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></td>
   <?php
 $frnExgOutgoin .= '<td>'. $vale = $FinanceAnnual[$i][OutgoinForeignExchange]*$yearcurrency[$year]; $tot=$vale/$convalue; round($tot,2).'</td>';


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
                        if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{ $vale = $FinanceAnnual[$i][OutgoinForeignExchange]*$yearcurrency[$year];$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} 
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
     
            } 
   ?>

</div>


<?php             

//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($whereradio,$group1);
//Old Balancesheet Ratio calculation
/*$RatioCalculation = $plstandard->radioFinacial($whereradio,$group1);*/
$RatioCalculation = $plstandard->radioFinacial($whereradio1,$group1);
   ?> 
<div style="clear:both;"></div>

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

$(document).ready(function(){
 if($('#activeSubmenu').val() == 'profit-loss') {
        $( '.cagrlabel' ).show();
    } else {
        $( '.cagrlabel' ).hide();
    }
});


    </script>
<?php mysql_close(); ?>
