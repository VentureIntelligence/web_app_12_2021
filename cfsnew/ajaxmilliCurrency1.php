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

$fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange");
$where .= "CId_FK = ".$_GET['vcid']." and FY !='' and ResultType='0'";
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
    
    if(count($FinanceAnnual) > 0){
     $Fycount=0;
     for($i=0;$i<count($FinanceAnnual);$i++){
         if($FinanceAnnual[$i][FY] !='' && $FinanceAnnual[$i][FY]>0)
         {
             $Fycount++;
         }
     }
     if($Fycount > 0)
     {
    ?>


<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid=<?php echo $_GET['vcid']; ?>">See Projection</a></div>

<div class="finance-filter">
<div class="left-cnt"> 
    <label> <input type="radio" name="yoy" id="yoy" value="V"  <?php if($_GET['yoy']=='V'){ echo "checked";} ?> onChange="javascript:valueconversion('V',<?php echo $_GET['vcid']; ?>);" checked="checked" /> Value</label>
    <label>   <input type="radio" name="yoy" id="cagr" value="G"  <?php if($_GET['yoy']=='G'){ echo "checked";} ?> onChange="javascript:valueconversion('G',<?php echo $_GET['vcid']; ?>);" /> Growth</label> 
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
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
    </select> </div>
<?php }else{ ?>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
         </select> </div>
    <?php } ?>
</div>
<div class="growth_fulldetails">
    <?php
    $growth_precentage = array();
    $growth_years=mysql_query("SELECT g.EBITDA as g_ebitda,g.TotalIncome as g_totalIncome,g.PAT as g_pat, p.TotalIncome as p_totalIncome, p.EBITDA as p_ebitda, p.PAT as p_pat, p.FY FROM `cagr` as g, plstandard as p WHERE g.CId_FK = p.CId_FK and g.FY=p.FY and g.CId_FK='".$_GET['vcid']."' GROUP BY g.CAGRYear order by g.CAGRYear,p.FY asc");
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
                $last_years=mysql_query("SELECT TotalIncome as p_totalIncome, EBITDA as p_ebitda, PAT as p_pat FROM plstandard WHERE FY='$cal_year' and CId_FK='".$_GET['vcid']."' limit 0,1");
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
                                                     $vale = currency_convert($latest_p_totalIncome,'INR',$_GET['queryString']);
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
                                                     $vale = currency_convert($p_totalIncome,'INR',$_GET['queryString']);
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
                                                     $vale = currency_convert($latest_p_ebitda,'INR',$_GET['queryString']); 
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
                                                     $vale = currency_convert($p_ebitda,'INR',$_GET['queryString']); 
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
                                                     $vale = currency_convert($latest_p_pat,'INR',$_GET['queryString']);
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
                                                     $vale = currency_convert($p_pat,'INR',$_GET['queryString']);
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
<div>
    
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
                <td>Total Income</td>
              </tr>
              <tr>
                <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
              </tr>
              <tr>
                <td>Operating Profit</td>
              </tr>
              <tr>
                <td>EBITDA</td>
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
                <td>EBT</td>
              </tr>
              <tr>
                <td>Tax</td>
              </tr>
              <tr>
                <td>PAT</td>
              </tr>
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
              <tr>
                    <td>Employee Related Expenses</td>
               
              </tr>
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
                        <td><b>Foreign Exchange EarningandOutgo</b></td>
                    </tr>
              <?php  }
            if($frnExgEarnin!='')
            {
            ?>
              <tr>
                <td>Earningin Foreign Exchange</td>
              </tr>
            <?php
            }
            if($frnExgOutgoin!='')
            {
          ?>
              <tr>
                <td>Outgoin Foreign Exchange</td>
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
                if($_GET['queryString']!='INR'){?>
            <th>FY <?php echo $FinanceAnnual[$i][FY];?></th>
            <?php
                }
                else
                {
                    ?>
            <th>FY <?php echo $FinanceAnnual[$i][FY];?></th>
            <?php
                }
            }
            ?>
            </tr></thead>
            <tbody>  
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                   <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '&nbsp';}else{$tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);echo round($tot,2); } ?></td>
                    <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][OtherIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '&nbsp';}else{ $tot=($FinanceAnnual[$i][OtherIncome]/$convalue);echo round($tot,2); } ?></td>
                        <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][TotalIncome],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?>  
                    <td><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '&nbsp';}else{$tot= ($FinanceAnnual[$i][TotalIncome]/$convalue);echo round($tot,2); } ?></td>
                       <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][OptnlAdminandOthrExp],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                       <?php
                }
                else
                {
                    ?>
                    <td><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);echo round($tot,2); } ?></td>
                             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][OptnlProfit],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?>
                    <td><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][OptnlProfit]/$convalue);echo round($tot,2); } ?></td>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][EBITDA]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][EBITDA],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual[$i][EBITDA]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][EBITDA]/$convalue);echo round($tot,2); } ?></td>
                                 <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][Interest]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][Interest],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual[$i][Interest]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][Interest]/$convalue);echo round($tot,2); } ?></td>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][EBDT]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][EBDT],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                  <?php
                }
                else
                {
                    ?>    
                    <td><?php if($FinanceAnnual[$i][EBDT]==0){echo '&nbsp';}else{$tot= ($FinanceAnnual[$i][EBDT]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][Depreciation]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][Depreciation],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
               <?php
                }
                else
                {
                    ?>    
                      <td><?php if($FinanceAnnual[$i][Depreciation]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][Depreciation]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][EBT]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][EBT],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
              <?php
                }
                else
                {
                    ?>      
                     <td><?php if($FinanceAnnual[$i][EBT]==0){echo '&nbsp';}else{ $tot=($FinanceAnnual[$i][EBT]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][Tax]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][Tax],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                <?php
                }
                else
                {
                    ?>   
                    <td><?php if($FinanceAnnual[$i][Tax]==0){echo '&nbsp';}else{$tot= ($FinanceAnnual[$i][Tax]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][PAT]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][PAT],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual[$i][PAT]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][PAT]/$convalue);echo round($tot,2); } ?></td>
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
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][BINR]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][BINR],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
             <?php
                }
                else
                {
                    ?>     
                     <td><?php if($FinanceAnnual[$i][BINR]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][BINR]);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][DINR]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][DINR],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
               <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual[$i][DINR]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][DINR]);echo round($tot,2); } ?></td>
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
              ?>
              <tr>
 
                 <?php 
                 //echo $EmpRelatedExp;
                 for($i=0;$i<count($FinanceAnnual);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '&nbsp';}else{$vale = currency_convert($FinanceAnnual[$i][EmployeeRelatedExpenses],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
               <?php
                }
                else
                {
                    ?>      
                    <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
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
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][EarninginForeignExchange],'INR',$_GET['queryString']);$tot=$vale/$convalue;round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
               <?php
                }
                else
                {
                    ?>      
                     <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '&nbsp';}else{ $tot=($FinanceAnnual[$i][EarninginForeignExchange]/$convalue);round($tot,2); } ?></td>
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
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual[$i][OutgoinForeignExchange],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
             <?php
                }
                else
                {
                    ?>   
                    <td><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);echo round($tot,2); } ?></td>
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
   <a  href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to check for latest financial year availability</a><br><br>
  </div>
<?php }
     
            } 
   ?>


<?php
$fields1 = array("*");
$where1 = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='0' and a.ResultType='0'";
$order1 = "a.FY DESC";
$group1 = "a.FY";

$FinanceAnnual1 = $balancesheet->getFullList(1,100,$fields1,$where1,$order1,"name",$group1);
if(count($FinanceAnnual1)==0){
   $FinanceAnnual1 = $balancesheet->getFullList_withoutPL(1,100,$fields1,$where1,$order1,"name"); 
}


$FinanceAnnual1_new = $balancesheet_new->getFullList(1,100,$fields1,$where1,$order1,"name",$group1); 
if(count($FinanceAnnual1_new)==0){
   $FinanceAnnual1_new = $balancesheet_new->getFullList_withoutPL(1,100,$fields1,$where1,$order1,"name"); 
} 
echo "<pre>";
print_r($FinanceAnnual1);
echo "</pre>";
echo "<pre>";
print_r($FinanceAnnual1_new);
echo "</pre>";
$where1 = "a.CID_FK = ".$_GET['vcid']." and a.ResultType='0'";
//Old Balancesheet Ratio calculation
$RatioCalculation = $plstandard->radioFinacial($where1,$group1);
if(count($RatioCalculation)==0){
   $RatioCalculation1 = $plstandard->radioFinacial($where1,$group1);
}

//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($where1,$group1);
if(count($NewRatioCalculation)==0){
   $NewRatioCalculation1 = $plstandard->NewRatioFinacial($where1,$group1);
}
/*echo '<pre>';
print_r($FinanceAnnual1);
echo '</pre>';*/
?>


<?php  if(count($FinanceAnnual1) > 0 && count($FinanceAnnual1_new) > 0){ ?>
<div style="margin:1% 0;">
    <label for="new_temp"> <input type="radio" name="balsheet" value="2" id="new_temp" class="template" onChange="javascript:balsheet_ch();" checked="checked"  > New Template</label>
    <label for="old_temp"> <input type="radio" name="balsheet" value="1" id="old_temp" class="template" onChange="javascript:balsheet_ch();" > Old Template</label>
</div>
<?php } ?>




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
<div id="new_balsheet" >

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
                if($_GET['queryString']!='INR'){?>
            <th>FY <?php echo $FinanceAnnual1_new[$i][FY];?></th>
            <?php
                }
                else
                {
                    ?>
            <th>FY <?php echo $FinanceAnnual1_new[$i][FY];?></th>
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
                    <td><?php if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1_new[$i][ShareCapital],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual1_new[$i][ShareCapital]==0){echo '0';}else{ $tot=($FinanceAnnual1_new[$i][ShareCapital]/$convalue);echo round($tot,2); } ?></td>
                        <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1_new[$i][ReservesSurplus],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?>  
                    <td><?php if($FinanceAnnual1_new[$i][ReservesSurplus]==0){echo '0';}else{$tot= ($FinanceAnnual1_new[$i][ReservesSurplus]/$convalue);echo round($tot,2); } ?></td>
                       <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1_new[$i][TotalFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></b></td>
                       <?php
                }
                else
                {
                    ?>
                    <td><b><?php if($FinanceAnnual1_new[$i][TotalFunds]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][TotalFunds]/$convalue);echo round($tot,2); } ?></b></td>
                             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][ShareApplication],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?>
                    <td><?php if($FinanceAnnual1_new[$i][ShareApplication]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][ShareApplication]/$convalue);echo round($tot,2); } ?></td>
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
                    <td><?php if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_borrowings],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual1_new[$i][L_term_borrowings]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][L_term_borrowings]/$convalue);echo round($tot,2); } ?></td>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][deferred_tax_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual1_new[$i][deferred_tax_liabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][deferred_tax_liabilities]/$convalue);echo round($tot,2); } ?></td>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_long_term_liabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                  <?php
                }
                else
                {
                    ?>    
                    <td><?php if($FinanceAnnual1_new[$i][O_long_term_liabilities]==0){echo '0';}else{$tot= ($FinanceAnnual1_new[$i][O_long_term_liabilities]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_provisions],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
               <?php
                }
                else
                {
                    ?>    
                      <td><?php if($FinanceAnnual1_new[$i][L_term_provisions]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][L_term_provisions]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1_new[$i][T_non_current_liabilities],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
              <?php
                }
                else
                {
                    ?>      
                     <td><b><?php if($FinanceAnnual1_new[$i][T_non_current_liabilities]==0){echo '0';}else{ $tot=($FinanceAnnual1_new[$i][T_non_current_liabilities]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><?php if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_borrowings],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][S_term_borrowings]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][S_term_borrowings]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Trade_payables],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Trade_payables]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Trade_payables]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_current_liabilities],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][O_current_liabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][O_current_liabilities]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_provisions],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][S_term_provisions]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][S_term_provisions]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_current_liabilities],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1_new[$i][T_current_liabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][T_current_liabilities]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_equity_liabilities],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1_new[$i][T_equity_liabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][T_equity_liabilities]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><?php if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Tangible_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Tangible_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Tangible_assets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Intangible_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Intangible_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Intangible_assets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_fixed_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][T_fixed_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][T_fixed_assets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][N_current_investments],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][N_current_investments]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][N_current_investments]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Deferred_tax_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Deferred_tax_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Deferred_tax_assets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][L_term_loans_advances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][L_term_loans_advances]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][L_term_loans_advances]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
             
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_non_current_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][O_non_current_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][O_non_current_assets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_non_current_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1_new[$i][T_non_current_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][T_non_current_assets]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><?php if($FinanceAnnual1_new[$i][Current_investments]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Current_investments],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Current_investments]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Current_investments]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][Inventories]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Inventories],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Inventories]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Inventories]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Trade_receivables],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Trade_receivables]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Trade_receivables]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
             <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Cash_bank_balances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][Cash_bank_balances]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Cash_bank_balances]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][S_term_loans_advances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][S_term_loans_advances]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][S_term_loans_advances]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][O_current_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1_new[$i][O_current_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][O_current_assets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][T_current_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1_new[$i][T_current_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][T_current_assets]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1_new[$i][Total_assets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1_new[$i][Total_assets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1_new[$i][Total_assets]==0){echo '0';}else{ $tot= ($FinanceAnnual1_new[$i][Total_assets]/$convalue);echo round($tot,2); } ?></b></td>
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
<div id="old_balsheet" style="<?php if(count($FinanceAnnual1_new) > 0){ ?> display: none; <?php } ?>">
    
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
                if($_GET['queryString']!='INR'){?>
            <th>FY <?php echo $FinanceAnnual1[$i][FY];?></th>
            <?php
                }
                else
                {
                    ?>
            <th>FY <?php echo $FinanceAnnual1[$i][FY];?></th>
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
                    <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][ShareCapital],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual1[$i][ShareCapital]==0){echo '0';}else{ $tot=($FinanceAnnual1[$i][ShareCapital]/$convalue);echo round($tot,2); } ?></td>
                        <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][ShareApplication],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?>  
                    <td><?php if($FinanceAnnual1[$i][ShareApplication]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][ShareApplication]/$convalue);echo round($tot,2); } ?></td>
                       <?php
                }
            }
            ?>
              </tr>
              <tr>
 
             <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][ReservesSurplus],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                       <?php
                }
                else
                {
                    ?>
                    <td><?php if($FinanceAnnual1[$i][ReservesSurplus]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][ReservesSurplus]/$convalue);echo round($tot,2); } ?></td>
                             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][TotalFunds]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][TotalFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></b></td>
                      <?php
                }
                else
                {
                    ?>
                    <td><b><?php if($FinanceAnnual1[$i][TotalFunds]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][TotalFunds]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][SecuredLoans],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual1[$i][SecuredLoans]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][SecuredLoans]/$convalue);echo round($tot,2); } ?></td>
                                 <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][UnSecuredLoans],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></td>
                      <?php
                }
                else
                {
                    ?> 
                    <td><?php if($FinanceAnnual1[$i][UnSecuredLoans]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][UnSecuredLoans]/$convalue);echo round($tot,2); } ?></td>
                              <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][LoanFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></b></td>
                  <?php
                }
                else
                {
                    ?>    
                    <td><b><?php if($FinanceAnnual1[$i][LoanFunds]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][LoanFunds]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherLiabilities],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></b></td>
               <?php
                }
                else
                {
                    ?>    
                      <td><b><?php if($FinanceAnnual1[$i][OtherLiabilities]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherLiabilities]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '0';}else{$vale = currency_convert($FinanceAnnual1[$i][DeferredTax],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
              <?php
                }
                else
                {
                    ?>      
                     <td><b><?php if($FinanceAnnual1[$i][DeferredTax]==0){echo '0';}else{ $tot=($FinanceAnnual1[$i][DeferredTax]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                 <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][SourcesOfFunds],'INR',$_GET['queryString']);$tot=$vale/$convalue;echo round($tot,2);  if($vale==''){echo '&nbsp';}} ?></b></td>
                <?php
                }
                else
                {
                    ?>   
                    <td><b><?php if($FinanceAnnual1[$i][SourcesOfFunds]==0){echo '0';}else{$tot= ($FinanceAnnual1[$i][SourcesOfFunds]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][GrossBlock],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][GrossBlock]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][GrossBlock]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][LessAccumulated],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][LessAccumulated]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][LessAccumulated]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][NetBlock],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][NetBlock]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][NetBlock]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CapitalWork],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][CapitalWork]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CapitalWork]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '&nbsp';}else{ $vale = currency_convert($FinanceAnnual1[$i][FixedAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][FixedAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][FixedAssets]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][IntangibleAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][IntangibleAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][IntangibleAssets]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherNonCurrent],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][OtherNonCurrent]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherNonCurrent]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Investments],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][Investments]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Investments]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][DeferredTaxAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][DeferredTaxAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][DeferredTaxAssets]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][SundryDebtors],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][SundryDebtors]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][SundryDebtors]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CashBankBalances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][CashBankBalances]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CashBankBalances]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Inventories],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][Inventories]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Inventories]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][LoansAdvances],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][LoansAdvances]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][LoansAdvances]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][OtherCurrentAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][OtherCurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][OtherCurrentAssets]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CurrentAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][CurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CurrentAssets]/$convalue);echo round($tot,2); } ?></b></td>
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
 
                <?php for($i=0;$i<count($FinanceAnnual1_new);$i++){  ?>
                  <td>&nbsp;</td>
                <?php }
                ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Provisions],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><?php if($FinanceAnnual1[$i][Provisions]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Provisions]/$convalue);echo round($tot,2); } ?></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][CurrentLiabilitiesProvision],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][CurrentLiabilitiesProvision]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][CurrentLiabilitiesProvision]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][NetCurrentAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][NetCurrentAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][NetCurrentAssets]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
              <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][ProfitLoss],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][ProfitLoss]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][ProfitLoss]/$convalue);echo round($tot,2); } ?></b></td>
             <?php
                }
            }
            ?>
              </tr>
               <tr>
 
                <?php for($i=0;$i<count($FinanceAnnual1);$i++){ 
                if($_GET['queryString']!='INR'){?>
                    <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][Miscellaneous],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][Miscellaneous]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][Miscellaneous]/$convalue);echo round($tot,2); } ?></b></td>
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
                    <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '0';}else{ $vale = currency_convert($FinanceAnnual1[$i][TotalAssets],'INR',$_GET['queryString']); $tot=$vale/$convalue;echo round($tot,2); if($vale==''){echo '&nbsp';}} ?></b></td>
                 <?php
                }
                else
                {
                    ?>   
                     <td><b><?php if($FinanceAnnual1[$i][TotalAssets]==0){echo '0';}else{ $tot= ($FinanceAnnual1[$i][TotalAssets]/$convalue);echo round($tot,2); } ?></b></td>
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

//New Balancesheet Ratio calculation
$NewRatioCalculation = $plstandard->NewRatioFinacial($where1,$group1);
//Old Balancesheet Ratio calculation
$RatioCalculation = $plstandard->radioFinacial($where1,$group1);
   ?> 
<div style="clear:both;"></div>
<div id="new_ratio" style="<?php if(count($NewRatioCalculation) >0) { ?> display:block; <?php } else{ ?> display:none; <?php }?>">
    <div class="finance-cnt">
        <?php if($NewRatioCalculation !=''){ ?>
        <div class="detail-table">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">     
                <tHead> <tr>
                <th>Ratios</th>
                <?php for($i=0;$i<count($NewRatioCalculation);$i++){ ?>
                <th>FY <?php echo $NewRatioCalculation[$i]['FY']; ?> </th>
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

                </tbody>
              </table>
        </div>
        <?php } ?>
    </div>
</div>

        <?php if(count($RatioCalculation) > 0){ ?>
<div id="old_ratio" style="<?php if(count($NewRatioCalculation) == 0) { ?> display:block; <?php } else{ ?> display:none; <?php }?>">
    <div class="finance-cnt">
        <div class="detail-table">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">     
                <tHead> <tr>
                <th>Ratios</th>
                <?php for($i=0;$i<count($RatioCalculation);$i++){ ?>
                <th>FY <?php echo $RatioCalculation[$i]['FY']; ?> </th>
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

                </tbody>
              </table>
        </div>
    </div>
</div>
        <?php } 
        
        
        mysql_close(); ?>
