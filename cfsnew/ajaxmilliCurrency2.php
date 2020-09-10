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
//pr($_REQUEST);


/*Currency Convert Function*/
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
        else {
                $curr_value=1;
        }
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

$fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange");
$where .= "CId_FK = ".$_GET['vcid']." and FY !='' ";
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

 <div class="title-table"><h3>PROJECTION</h3> <a class="postlink" href="details.php?vcid=<?php echo $_GET['vcid']; ?>">Back to details</a></div>
<div id="stMsg"></div>
<div class="project-filter projectionDetails">  
    <input type="hidden" name="projvcid" id="projvcid" value="<?php echo $_GET['vcid']; ?>"/>
<div class="left-cnt" ><label>Take CAGR of past</label><select name="noofyear" id="noofyear">
        <option value="0" <?php if($_GET['noofyear']==0){ echo "selected";} ?>>None</option>
        <option value="1" <?php if($_GET['noofyear']==1){ echo "selected";} ?>>1</option>
        <option value="2" <?php if($_GET['noofyear']==2){ echo "selected";} ?>>2</option>
        <option value="3" <?php if($_GET['noofyear']==3){ echo "selected";} ?>>3</option>
        <option value="4" <?php if($_GET['noofyear']==4){ echo "selected";} ?>>4</option>
        <option value="5" <?php if($_GET['noofyear']==5){ echo "selected";} ?>>5</option></select>
    <label>CAGR % </label>  <input  type="text" name="CAGR" id="CAGR" value="<?php if($_GET['CAGR']!=""){ echo $_GET['CAGR'];} ?>" placeholder="Enter Percentage" /> </select> 
    <label>Project for</label><select name="projnext" id="projnext">
        <option value="1" <?php if($_GET['projnext']==1){ echo "selected";} ?>>1</option>
        <option value="2" <?php if($_GET['projnext']==2){ echo "selected";} ?>>2</option>
        <option value="3" <?php if($_GET['projnext']==3){ echo "selected";} ?>>3</option>
        <option value="4" <?php if($_GET['projnext']==4){ echo "selected";} ?>>4</option>
        <option value="5" <?php if($_GET['projnext']==5){ echo "selected";} ?>>5</option>
        <option value="6" <?php if($_GET['projnext']==6){ echo "selected";} ?>>6</option>
        <option value="7" <?php if($_GET['projnext']==7){ echo "selected";} ?>>7</option>
        <option value="8" <?php if($_GET['projnext']==8){ echo "selected";} ?>>8</option>
        <option value="9" <?php if($_GET['projnext']==9){ echo "selected";} ?>>9</option>
        <option value="10" <?php if($_GET['projnext']==10){ echo "selected";} ?>>10</option></select> 
    <input type="button" name="projection" id="projection" onclick="javascript:projectdisplay()" value="Project Now" /> 
    </div>
    
    <div class="right-cnt">
        <label>Currency</label>  <select onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>)" name="ccur" id="ccur">
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
        <?php if($_GET['queryString']=='INR'){ ?>
        <label>Show in</label>   <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
    </select> 
    <?php }else{ ?>
     <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <!--<option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>><?php echo $_GET['queryString']; ?></option>-->
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
         </select>
    <?php } ?>
    
    </div>

</div>
	<div class="projection-cnt">

                    <div class="compare-companies">
                        
                    <ul  class="operations-list">
                    <li><h4>OPERATIONS</h4></li>
                    <li class="fontb">Operational Income</li>
                    <li class="fontb">Other Income</li>
                    <li class="fontb">Total Income</li>
                    <li><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></li>
                    <li>Operating Profit</li>
                    <li class="fontb">EBITDA</li>
                    <li>Interest</li>
                    <li class="fontb">EBDT</li>
                    <li>Depreciation</li>
                    <li class="fontb">EBT</li>
                    <li>Tax</li>
                    <li class="fontb">PAT</li>
                    <li class="fontb"><b>EPS</b></li>
                    <li>Basic INR</li>
                    <li>Diluted INR</li>
                    <li>&nbsp;</li>
                     <li>&nbsp;</li>
                    <li class="fonts">Employee Related Expenses</li>
                    <li class="fontb" style="font-size: 15px !important;">Foreign Exchange Earning and Outgo</li>
                    <li class="fonts">Earning in Foreign Exchange</li>
                    <li class="fonts">Outgo in Foreign Exchange</li>
                    </ul>   
		
                        <div class="compare-scroll" style="">
 
                        <div style=""> 
                        <?php
		//for($i=0;$i<count($FinanceAnnual);$i++){
                for($i=count($FinanceAnnual)-1;$i>=0;$i--){
                    if($_GET['queryString']!='INR'){?>
                        <ul>
                        <li><h4>FY <?php echo $FinanceAnnual[$i][FY];?> </h4></li>  
                        <li><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][OptnlIncome],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][OtherIncome],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][TotalIncome],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlAdminandOthrExp],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][OptnlProfit],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][EBITDA],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][Interest]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][Interest],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][EBDT],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Depreciation],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][EBT]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][EBT],'INR',$_GET['queryString']);  $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][Tax]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][Tax],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][PAT]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][PAT],'INR',$_GET['queryString']);  $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php echo '-'; ?></li>
                        <li><?php if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][BINR],'INR',$_GET['queryString']);  $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][DINR],'INR',$_GET['queryString']);  $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php echo '-'; ?></li>
                         <li><?php echo '-'; ?></li>
                      <li><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']);  $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][ForeignExchangeEarningandOutgo],'INR',$_GET['queryString']);  $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{$vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        <li><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{ $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '-';}} ?></li>
                        </ul>  
		<?php
		}
		else{
		?>
                            
                            
                             <ul>
                        <li><h4>FY <?php echo $FinanceAnnual[$i][FY];?></h4></li>  
                        <li><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{ $tot= ($FinanceAnnual[$i][OptnlIncome]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][OtherIncome]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{$tot=  ($FinanceAnnual[$i][TotalIncome]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{$tot=  ($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][OptnlProfit]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][EBITDA]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][Interest]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][Interest]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][EBDT]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][Depreciation]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][EBT]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][EBT]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][Tax]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][Tax]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][PAT]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][PAT]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php echo '-'; ?></li>
                        <li><?php if($FinanceAnnual[$i][BINR]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][BINR]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][DINR]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php echo '-'; ?></li>
                         <li><?php echo '-'; ?></li>
                       <li><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '&nbsp';}else{ $tot=  ($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][EarninginForeignExchange]/$convalue);echo round($tot,2); } ?></li>
                        <li><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{ $tot=  ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);echo round($tot,2); } ?></li>
                        </ul> 
                        
		<?php } 
                }?>
	</div>	
	</div>
        
      </div>	
	</div>
<?php mysql_close(); ?>