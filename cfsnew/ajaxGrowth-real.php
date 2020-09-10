<?php

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
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();

global $FinanceAnnual;

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

if($_GET['queryString1']=='G'){
	$fields = array("GrowthPerc_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange");
	$where .= "CId_FK = ".$_GET['vcid'];
	$order="FY DESC";
	$FinanceAnnual = $growthpercentage->getFullList(1,100,$fields,$where,$order,"name");
}else{
	$fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange");
	$where .= "CId_FK = ".$_GET['vcid'];
	$order="FY DESC";
	$FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");
}
$cprofile->select($_GET['vcid']);
if($_GET['queryString1']=='V'){
    
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
}

?>

<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid=<?php echo $_GET['vcid']; ?>">See Projection</a></div>

<div class="finance-filter">
<div class="left-cnt"> 
    <label> <input type="radio" name="yoy" id="yoy" value="V"  <?php if($_GET['queryString1']=='V'){ echo "checked";} ?> onChange="javascript:valueconversion('V',<?php echo $_GET['vcid']; ?>);" checked="checked" /> Value</label>
    <label>   <input type="radio" name="yoy" id="cagr" value="G"  <?php if($_GET['queryString1']=='G'){ echo "checked";} ?> onChange="javascript:valueconversion('G',<?php echo $_GET['vcid']; ?>);" /> Growth</label> 
    <?php 
    if($_GET['queryString1']=='V'){
        ?>
   
    <select onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur">
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
    <?php } 
    }
    else
    {
        ?>
     <select onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>);" name="ccur" id="ccur" disabled>
        <option value="INR" <?php if($_GET['queryString']=='INR'){ echo "selected";} ?>>Indian Rupee INR</option>
    </select>  
</div>
<?php if($_GET['queryString']=='INR'){ ?>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);" disabled>
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
    </select> </div>
<?php }else{ ?>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);" disabled>
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
         </select> </div>
    <?php }
   
        
    }
?>
</div>
<?php if($_GET['queryString1']=='G')
{
?>

<div class="detail-table">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
<th>OPERATIONS</th>
<?php for($i=0;$i<count($FinanceAnnual);$i++){ 
?>
<th>FY <?php echo $FinanceAnnual[$i][FY];?></th>
<?php
    
}
?>
</tr></thead>
<tbody>  
  <tr>
    <td>Opertnl Income</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
      ?> 
        <td><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][OptnlIncome]; } ?></td>
        <?php
}
?>
  </tr>
  <tr>
    <td>Other Income</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?> 
        <td><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][OtherIncome]; } ?></td>
            <?php
}
?>
  </tr>
  <tr>
    <td>Total Income</td>
 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
    ?>  
        <td><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][TotalIncome]; } ?></td>
           <?php
}
?>
  </tr>
  <tr>
    <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>
        <td><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][OptnlAdminandOthrExp]; } ?></td>
                 <?php
}
?>
  </tr>
  <tr>
    <td>Operating Profit</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>
        <td><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][OptnlProfit]; } ?></td>
                  <?php
    }
?>
  </tr>
  <tr>
    <td>EBITDA</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
    
        ?> 
        <td><?php if($FinanceAnnual[$i][EBITDA]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EBITDA]; } ?></td>
                     <?php
    }
?>
  </tr>
  <tr>
    <td>Interest</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?> 
        <td><?php if($FinanceAnnual[$i][Interest]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][Interest]; } ?></td>
                  <?php
    }
?>
  </tr>
  <tr>
    <td>EBDT</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>    
        <td><?php if($FinanceAnnual[$i][EBDT]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EBDT]; } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>Depreciation</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>    
          <td><?php if($FinanceAnnual[$i][Depreciation]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][Depreciation]; } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>EBT</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>      
         <td><?php if($FinanceAnnual[$i][EBT]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EBT]; } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>Tax</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
        <td><?php if($FinanceAnnual[$i][Tax]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][Tax]; } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>PAT</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
         <td><?php if($FinanceAnnual[$i][PAT]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][PAT]; } ?></td>
 <?php
}
?>
  </tr>
  <tr>
      <td><b>EPS</b></td>
      <?php for($i=0;$i<count($FinanceAnnual);$i++){ ?>
        <td>&nbsp;</td>
    <?php
}
?>
  </tr>
  <tr>
    <td>Basic INR</td>
      <?php for($i=0;$i<count($FinanceAnnual);$i++){ ?>
             
         <td><?php if($FinanceAnnual[$i][BINR]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][BINR]; } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>Diluted INR</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
         <td><?php if($FinanceAnnual[$i][DINR]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][DINR]; } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
       <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?> 
    <td>&nbsp;</td>
    <?php
    }
?>
  </tr>
   <?php
    $EmpRelatedExp = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
       
            if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
            $EmpRelatedExp .= '<td>'.$FinanceAnnual[$i][EmployeeRelatedExpenses].'</td>';
        }
    }
    if($EmpRelatedExp!='')
    {
  ?>
  <tr>
    <td>Employee Related Expenses</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>      
        <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EmployeeRelatedExpenses]; } ?></td>
 <?php
    }
?>
  </tr>
  <?php
    }
   
    $frnExgEarnCont = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
            if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
            $frnExgEarnCont .= '<td>'.$FinanceAnnual[$i][ForeignExchangeEarningandOutgo].'</td>';
        }
    }
    if($frnExgEarnCont!='')
    {
  ?>
  <tr>
    <td>Foreign Exchange EarningandOutgo</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
         <td><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][ForeignExchangeEarningandOutgo]; } ?></td>
 <?php
    }
?>
  </tr>
  <?php
    }
    $frnExgEarnin = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
            if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
            $frnExgEarnin .= '<td>'.$FinanceAnnual[$i][OutgoinForeignExchange].'</td>';
        }
    }
    if($frnExgEarnin!='')
    {
  ?>
  <tr>
    <td>Earningin Foreign Exchange</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>      
         <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EarninginForeignExchange]; } ?></td>
 <?php
    }
?>
  </tr>
   <?php
  }
  $frnExgOutgoin = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
            if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
             $frnExgOutgoin .= '<td>'.$FinanceAnnual[$i][OutgoinForeignExchange].'</td>';
        }
    }
    if($frnExgOutgoin !='')
    {
  ?>
  <tr>
    <td>Outgoin Foreign Exchange</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
        <td><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][OutgoinForeignExchange]; } ?></td>
 <?php
    }
?>
  </tr>
  <?php
  }
  ?>
</tbody>
</table> 
 </div>
<?php
}
else
{
?>
   <div class="detail-table">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
<th>OPERATIONS</th>
<?php for($i=0;$i<count($FinanceAnnual);$i++){ 
?>
<th>FY <?php echo $FinanceAnnual[$i][FY];?></th>
<?php
    
}
?>
</tr></thead>
<tbody>  
  <tr>
    <td>Opertnl Income</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
      ?> 
        <td><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '&nbsp';}else{ $tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);echo round($tot,2); } ?></td>
        <?php
}
?>
  </tr>
  <tr>
    <td>Other Income</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?> 
        <td><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][OtherIncome]/$convalue);echo round($tot,2); } ?></td>
            <?php
}
?>
  </tr>
  <tr>
    <td>Total Income</td>
 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
    ?>  
        <td><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '&nbsp';}else{$tot=($FinanceAnnual[$i][TotalIncome]/$convalue);echo round($tot,2); } ?></td>
           <?php
}
?>
  </tr>
  <tr>
    <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
 <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>
        <td><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '&nbsp';}else{$tot= ($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);echo round($tot,2); } ?></td>
                 <?php
}
?>
  </tr>
  <tr>
    <td>Operating Profit</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>
        <td><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '&nbsp';}else{$tot=($FinanceAnnual[$i][OptnlProfit]/$convalue);echo round($tot,2); } ?></td>
                  <?php
    }
?>
  </tr>
  <tr>
    <td>EBITDA</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
    
        ?> 
        <td><?php if($FinanceAnnual[$i][EBITDA]==0){echo '&nbsp';}else{$tot= ($FinanceAnnual[$i][EBITDA]/$convalue);echo round($tot,2); } ?></td>
                     <?php
    }
?>
  </tr>
  <tr>
    <td>Interest</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?> 
        <td><?php if($FinanceAnnual[$i][Interest]==0){echo '&nbsp';}else{$tot= ( $FinanceAnnual[$i][Interest]/$convalue);echo round($tot,2); } ?></td>
                  <?php
    }
?>
  </tr>
  <tr>
    <td>EBDT</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>    
        <td><?php if($FinanceAnnual[$i][EBDT]==0){echo '&nbsp';}else{$tot= ( $FinanceAnnual[$i][EBDT]/$convalue);echo round($tot,2); } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>Depreciation</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>    
          <td><?php if($FinanceAnnual[$i][Depreciation]==0){echo '&nbsp';}else{$tot= ( $FinanceAnnual[$i][Depreciation]/$convalue);echo round($tot,2); } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>EBT</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>      
         <td><?php if($FinanceAnnual[$i][EBT]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][EBT]/$convalue);echo round($tot,2); } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>Tax</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
        <td><?php if($FinanceAnnual[$i][Tax]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][Tax]/$convalue);echo round($tot,2);} ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>PAT</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
         <td><?php if($FinanceAnnual[$i][PAT]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][PAT]/$convalue);echo round($tot,2); } ?></td>
 <?php
}
?>
  </tr>
  <tr>
      <td><b>EPS</b></td>
      <?php for($i=0;$i<count($FinanceAnnual);$i++){ ?>
        <td>&nbsp;</td>
    <?php
}
?>
  </tr>
  <tr>
    <td>Basic INR</td>
      <?php for($i=0;$i<count($FinanceAnnual);$i++){ ?>
             
         <td><?php if($FinanceAnnual[$i][BINR]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][BINR]/$convalue);echo round($tot,2); } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
    <td>Diluted INR</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
         <td><?php if($FinanceAnnual[$i][DINR]==0){echo '&nbsp';}else{ $tot= ($FinanceAnnual[$i][DINR]/$convalue);echo round($tot,2); } ?></td>
 <?php
    }
?>
  </tr>
  <tr>
       <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?> 
    <td>&nbsp;</td>
    <?php
    }
?>
  </tr>
   <?php
    $EmpRelatedExp = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
       
            if($FinanceAnnual[$i][EmployeeRelatedExpenses]!=0){
            $EmpRelatedExp .= '<td>'.$FinanceAnnual[$i][EmployeeRelatedExpenses].'</td>';
        }
    }
    if($EmpRelatedExp!='')
    {
  ?>
  <tr>
    <td>Employee Related Expenses</td>
     <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>      
        <td><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EmployeeRelatedExpenses]; } ?></td>
 <?php
    }
?>
  </tr>
  <?php
    }
   
    $frnExgEarnCont = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
            if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]!=0){
            $frnExgEarnCont .= '<td>'.$FinanceAnnual[$i][ForeignExchangeEarningandOutgo].'</td>';
        }
    }
    if($frnExgEarnCont!='')
    {
  ?>
  <tr>
    <td>Foreign Exchange EarningandOutgo</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
         <td><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][ForeignExchangeEarningandOutgo]; } ?></td>
 <?php
    }
?>
  </tr>
  <?php
    }
    $frnExgEarnin = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
            if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
            $frnExgEarnin .= '<td>'.$FinanceAnnual[$i][OutgoinForeignExchange].'</td>';
        }
    }
    if($frnExgEarnin!='')
    {
  ?>
  <tr>
    <td>Earningin Foreign Exchange</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>      
         <td><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][EarninginForeignExchange]; } ?></td>
 <?php
    }
?>
  </tr>
   <?php
  }
  $frnExgOutgoin = '';
    for($i=0;$i<count($FinanceAnnual);$i++){
            if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
             $frnExgOutgoin .= '<td>'.$FinanceAnnual[$i][OutgoinForeignExchange].'</td>';
        }
    }
    if($frnExgOutgoin !='')
    {
  ?>
  <tr>
    <td>Outgoin Foreign Exchange</td>
    <?php for($i=0;$i<count($FinanceAnnual);$i++){ 
        ?>   
        <td><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '&nbsp';}else{ echo $FinanceAnnual[$i][OutgoinForeignExchange]; } ?></td>
 <?php
    }
?>
  </tr>
  <?php
  }
  ?>
</tbody>
</table> 
 </div>
 <?php
}
?>