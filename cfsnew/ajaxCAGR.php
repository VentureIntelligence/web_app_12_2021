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
	require_once MODULES_DIR."cagr.php";
	$cagr = new cagr();

	global $FinanceAnnual;
        
        if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in ajaxCAGR page -'.$_SESSION['username']); }
        

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
	/*
	$fields1 = array("CAGR_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR");
	$where1 .= "CId_FK = ".$_GET['vcid'];
	$order1 = "FY DESC";
	$FinanceAnnualCAGR = $cagr->getFullList(1,100,$fields1,$where1,$order1,"name");
	*/
	$cprofile->select($_GET['vcid']);
	$calculation = array();
	$FinanceAnnualCAGR = array();
	$FinanceAnnual1 = array();
	$noofyear = $_GET['noofyear'];
	$CAGR = $_GET['CAGR'];
	$projnext = $_GET['projnext'];
//pr($FinanceAnnual);
	for($l=0;$l<count($FinanceAnnual);$l++){
		$FinanceAnnualCAGR[$l]['OptnlIncome']            = (pow(($FinanceAnnual[0]['OptnlIncome']/$FinanceAnnual[$l+1]['OptnlIncome']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['OtherIncome']            = (pow(($FinanceAnnual[0]['OtherIncome']/$FinanceAnnual[$l+1]['OtherIncome']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['TotalIncome']            = (pow(($FinanceAnnual[0]['TotalIncome']/$FinanceAnnual[$l+1]['TotalIncome']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['OptnlAdminandOthrExp']   = (pow(($FinanceAnnual[0]['OptnlAdminandOthrExp']/$FinanceAnnual[$l+1]['OptnlAdminandOthrExp']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['OptnlProfit']            = (pow(($FinanceAnnual[0]['OptnlProfit']/$FinanceAnnual[$l+1]['OptnlProfit']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['EBITDA']                 = (pow(($FinanceAnnual[0]['EBITDA']/$FinanceAnnual[$l+1]['EBITDA']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['Interest']               = (pow(($FinanceAnnual[0]['Interest']/$FinanceAnnual[$l+1]['Interest']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['EBDT']                   = (pow(($FinanceAnnual[0]['EBDT']/$FinanceAnnual[$l+1]['EBDT']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['Depreciation']           = (pow(($FinanceAnnual[0]['Depreciation']/$FinanceAnnual[$l+1]['Depreciation']),(1/($l+1)))-1) * 1000;
		$FinanceAnnualCAGR[$l]['EBT']                    = (pow(($FinanceAnnual[0]['EBT']/$FinanceAnnual[$l+1]['EBT']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['Tax']                    = (pow(($FinanceAnnual[0]['Tax']/$FinanceAnnual[$l+1]['Tax']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['PAT']            	 = (pow(($FinanceAnnual[0]['PAT']/$FinanceAnnual[$l+1]['PAT']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['BINR']                   = (pow(($FinanceAnnual[0]['BINR']/$FinanceAnnual[$l+1]['BINR']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['DINR']                   = (pow(($FinanceAnnual[0]['DINR']/$FinanceAnnual[$l+1]['DINR']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['EmployeeRelatedExpenses']      = (pow(($FinanceAnnual[0]['EmployeeRelatedExpenses']/$FinanceAnnual[$l+1]['EmployeeRelatedExpenses']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['ForeignExchangeEarningandOutgo']  = (pow(($FinanceAnnual[0]['ForeignExchangeEarningandOutgo']/$FinanceAnnual[$l+1]['ForeignExchangeEarningandOutgo']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['EarninginForeignExchange']        = (pow(($FinanceAnnual[0]['EarninginForeignExchange']/$FinanceAnnual[$l+1]['EarninginForeignExchange']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['OutgoinForeignExchange']          = (pow(($FinanceAnnual[0]['OutgoinForeignExchange']/$FinanceAnnual[$l+1]['OutgoinForeignExchange']),(1/($l+1)))-1) * 100;
		$FinanceAnnualCAGR[$l]['FY']                     = $FinanceAnnual[$l]['FY'];
		$FinanceAnnualCAGR[$l]['CId_FK']                 = $FinanceAnnual[$l]['CId_FK'];
		$FinanceAnnualCAGR[$l]['ResultType']             = $FinanceAnnual[$l]['ResultType'];
		$FinanceAnnualCAGR[$l]['IndustryId_FK'] 		 = $FinanceAnnual[$l]['IndustryId_FK'];
		$FinanceAnnualCAGR[$l]['GrowthYear'] 		 = $l+1;
	}
		//pr($FinanceAnnualCAGR);
	//	echo $noofyear;
	for($j=0;$j<count($FinanceAnnualCAGR);$j++){
		if($FinanceAnnualCAGR[$j]['GrowthYear']  == $noofyear){
			//echo $FinanceAnnualCAGR[$j][FY];
			$FinanceAnnual1[0][OptnlIncome] += $FinanceAnnualCAGR[$j][OptnlIncome];
			$FinanceAnnual1[0][OtherIncome] += $FinanceAnnualCAGR[$j][OtherIncome];
			$FinanceAnnual1[0][TotalIncome] += $FinanceAnnualCAGR[$j][TotalIncome];
			$FinanceAnnual1[0][OptnlAdminandOthrExp] += $FinanceAnnualCAGR[$j][OptnlAdminandOthrExp];
			$FinanceAnnual1[0][OptnlProfit] += $FinanceAnnualCAGR[$j][OptnlProfit];
			$FinanceAnnual1[0][EBITDA] += $FinanceAnnualCAGR[$j][EBITDA];
			$FinanceAnnual1[0][Interest] += $FinanceAnnualCAGR[$j][Interest];
			$FinanceAnnual1[0][EBDT] += $FinanceAnnualCAGR[$j][EBDT];
			$FinanceAnnual1[0][Depreciation] += $FinanceAnnualCAGR[$j][Depreciation];
			$FinanceAnnual1[0][EBT] += $FinanceAnnualCAGR[$j][EBT];
			$FinanceAnnual1[0][Tax] += $FinanceAnnualCAGR[$j][Tax];
			$FinanceAnnual1[0][PAT] += $FinanceAnnualCAGR[$j][PAT];
			$FinanceAnnual1[0][BINR] += $FinanceAnnualCAGR[$j][BINR];
			$FinanceAnnual1[0][DINR] += $FinanceAnnualCAGR[$j][DINR];
			$FinanceAnnual1[0][EmployeeRelatedExpenses] += $FinanceAnnualCAGR[$j][EmployeeRelatedExpenses];
			$FinanceAnnual1[0][ForeignExchangeEarningandOutgo] += $FinanceAnnualCAGR[$j][ForeignExchangeEarningandOutgo];
			$FinanceAnnual1[0][EarninginForeignExchange] += $FinanceAnnualCAGR[$j][EarninginForeignExchange];
			$FinanceAnnual1[0][OutgoinForeignExchange] += $FinanceAnnualCAGR[$j][OutgoinForeignExchange];
		}elseif($noofyear == 0){
			$FinanceAnnual1[0][OptnlIncome] = 1;
			$FinanceAnnual1[0][OtherIncome] = 1;
			$FinanceAnnual1[0][TotalIncome] = 1;
			$FinanceAnnual1[0][OptnlAdminandOthrExp] = 1;
			$FinanceAnnual1[0][OptnlProfit] = 1;
			$FinanceAnnual1[0][EBITDA] = 1;
			$FinanceAnnual1[0][Interest] = 1;
			$FinanceAnnual1[0][EBDT] = 1;
			$FinanceAnnual1[0][Depreciation] = 1;
			$FinanceAnnual1[0][EBT] = 1;
			$FinanceAnnual1[0][Tax] = 1;
			$FinanceAnnual1[0][PAT] = 1;
			$FinanceAnnual1[0][BINR] = 1;
			$FinanceAnnual1[0][DINR] = 1;
			$FinanceAnnual1[0][EmployeeRelatedExpenses] = 1;
			$FinanceAnnual1[0][ForeignExchangeEarningandOutgo] = 1;
			$FinanceAnnual1[0][EarninginForeignExchange] = 1;
			$FinanceAnnual1[0][OutgoinForeignExchange] = 1;
		}
	}
	//pr($FinanceAnnual1);	
	if($_GET['CAGR']!=''){
		$CAGR = $_GET['CAGR'];
	}else{
		$CAGR = 1;
	}
	//echo 'CAGR='.$CAGR;
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

<div class="title-table"><h3>PROJECTION</h3> <a href="details.php?vcid=<?php echo $_GET['vcid']; ?>">Back to details</a></div>
<div id="stMsg"></div>
<div class="project-filter">  
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
        <label>Currency</label>  <select onChange="javascript:currencyconvert(this.value,<?php echo $_GET['vcid']; ?>)" name="ccur" id="ccur" >
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
        <option value="r" <?php if($_GET['rconv']=='r'){ echo "selected";} ?>>Actual Value</option>
        <option  value="m" <?php if($_GET['rconv']=='m'){ echo "selected";} ?>>Millions</option>
        <option value="c" <?php if($_GET['rconv']=='c'){ echo "selected";} ?>>Crores</option>
    </select> 
    <?php }else{ ?>
     <select name="currencytype" id="currencytype"  onchange="javascript:millconversion(this.value,<?php echo $_GET['vcid']; ?>);">
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
                    <li class="fonts">Foreign Exchange Earning and Outgo</li>
                    <li class="fonts">Earning in Foreign Exchange</li>
                    <li class="fonts">Outgo in Foreign Exchange</li>
                    </ul>   
		<?php 
		for($i=0;$i<$projnext;$i++){ 
		    if($i==0){
			   	$calculation[$i][OptnlIncome] = $FinanceAnnual[0][OptnlIncome]*(1+($FinanceAnnual1[0][OptnlIncome]*$CAGR)/100);
				$calculation[$i][OtherIncome] = $FinanceAnnual[0][OtherIncome]*(1+($FinanceAnnual1[0][OtherIncome]*$CAGR)/100);
				$calculation[$i][TotalIncome] = $FinanceAnnual[0][TotalIncome]*(1+($FinanceAnnual1[0][TotalIncome]*$CAGR)/100);
				$calculation[$i][OptnlAdminandOthrExp] = $FinanceAnnual[0][OptnlAdminandOthrExp]*(1+($FinanceAnnual1[0][OptnlAdminandOthrExp]*$CAGR)/100);
				$calculation[$i][OptnlProfit] = $FinanceAnnual[0][OptnlProfit]*(1+($FinanceAnnual1[0][OptnlProfit]*$CAGR)/100);
				$calculation[$i][EBITDA] = $FinanceAnnual[0][EBITDA]*(1+($FinanceAnnual1[0][EBITDA]*$CAGR)/100);
				$calculation[$i][Interest] = $FinanceAnnual[0][Interest]*(1+($FinanceAnnual1[0][Interest]*$CAGR)/100);
				$calculation[$i][EBDT] = $FinanceAnnual[0][EBDT]*(1+($FinanceAnnual1[0][EBDT]*$CAGR)/100);
				$calculation[$i][Depreciation] = $FinanceAnnual[0][Depreciation]*(1+($FinanceAnnual1[0][Depreciation]*$CAGR)/100);
				$calculation[$i][EBT] = $FinanceAnnual[0][EBT]*(1+($FinanceAnnual1[0][EBT]*$CAGR)/100);
				$calculation[$i][Tax] = $FinanceAnnual[0][Tax]*(1+($FinanceAnnual1[0][Tax]*$CAGR)/100);
				$calculation[$i][PAT] = $FinanceAnnual[0][PAT]*(1+($FinanceAnnual1[0][PAT]*$CAGR)/100);
				$calculation[$i][BINR] = $FinanceAnnual[0][BINR]*(1+($FinanceAnnual1[0][BINR]*$CAGR)/100);
				$calculation[$i][DINR] = $FinanceAnnual[0][DINR]*(1+($FinanceAnnual1[0][DINR]*$CAGR)/100);
				$calculation[$i][EmployeeRelatedExpenses] = $FinanceAnnual[0][EmployeeRelatedExpenses]*(1+($FinanceAnnual1[0][EmployeeRelatedExpenses]*$CAGR)/100);
				$calculation[$i][ForeignExchangeEarningandOutgo] = $FinanceAnnual[0][ForeignExchangeEarningandOutgo]*(1+($FinanceAnnual1[0][ForeignExchangeEarningandOutgo]*$CAGR)/100);
				$calculation[$i][EarninginForeignExchange] = $FinanceAnnual[0][EarninginForeignExchange]*(1+($FinanceAnnual1[0][EarninginForeignExchange]*$CAGR)/100);
				$calculation[$i][OutgoinForeignExchange] = $FinanceAnnual[0][OutgoinForeignExchange]*(1+($FinanceAnnual1[0][OutgoinForeignExchange]*$CAGR)/100); 
			}else{
				$calculation[$i][OptnlIncome] = $calculation[$i-1][OptnlIncome]*(1+($FinanceAnnual1[0][OptnlIncome]*$CAGR)/100);
				$calculation[$i][OtherIncome] = $calculation[$i-1][OtherIncome]*(1+($FinanceAnnual1[0][OtherIncome]*$CAGR)/100);
				$calculation[$i][TotalIncome] = $calculation[$i-1][TotalIncome]*(1+($FinanceAnnual1[0][TotalIncome]*$CAGR)/100);
				$calculation[$i][OptnlAdminandOthrExp] = $calculation[$i-1][OptnlAdminandOthrExp]*(1+($FinanceAnnual1[0][OptnlAdminandOthrExp]*$CAGR)/100);
				$calculation[$i][OptnlProfit] = $calculation[$i-1][OptnlProfit]*(1+($FinanceAnnual1[0][OptnlProfit]*$CAGR)/100);
				$calculation[$i][EBITDA] = $calculation[$i-1][EBITDA]*(1+($FinanceAnnual1[0][EBITDA]*$CAGR)/100);
				$calculation[$i][Interest] = $calculation[$i-1][Interest]*(1+($FinanceAnnual1[0][Interest]*$CAGR)/100);
				$calculation[$i][EBDT] = $calculation[$i-1][EBDT]*(1+($FinanceAnnual1[0][EBDT]*$CAGR)/100);
				$calculation[$i][Depreciation] = $calculation[$i-1][Depreciation]*(1+($FinanceAnnual1[0][Depreciation]*$CAGR)/100);
				$calculation[$i][EBT] = $calculation[$i-1][EBT]*(1+($FinanceAnnual1[0][EBT]*$CAGR)/100);
				$calculation[$i][Tax] = $calculation[$i-1][Tax]*(1+($FinanceAnnual1[0][Tax]*$CAGR)/100);
				$calculation[$i][PAT] = $calculation[$i-1][PAT]*(1+($FinanceAnnual1[0][PAT]*$CAGR)/100);
				$calculation[$i][BINR] = $calculation[$i-1][BINR]*(1+($FinanceAnnual1[0][BINR]*$CAGR)/100);
				$calculation[$i][DINR] = $calculation[$i-1][DINR]*(1+($FinanceAnnual1[0][DINR]*$CAGR)/100);
				$calculation[$i][EmployeeRelatedExpenses] = $calculation[$i-1][EmployeeRelatedExpenses]*(1+($FinanceAnnual1[0][EmployeeRelatedExpenses]*$CAGR)/100);
				$calculation[$i][ForeignExchangeEarningandOutgo] = $calculation[$i-1][ForeignExchangeEarningandOutgo]*(1+($FinanceAnnual1[0][ForeignExchangeEarningandOutgo]*$CAGR)/100);
				$calculation[$i][EarninginForeignExchange] = $calculation[$i-1][EarninginForeignExchange]*(1+($FinanceAnnual1[0][EarninginForeignExchange]*$CAGR)/100);
				$calculation[$i][OutgoinForeignExchange] = $calculation[$i-1][OutgoinForeignExchange]*(1+($FinanceAnnual1[0][OutgoinForeignExchange]*$CAGR)/100); 

			}
		}
                ?>
                        <div class="compare-scroll" style="">
 
                        <div style=""> 
                        <?php
		//for($i=0;$i<count($FinanceAnnual);$i++){
                for($i=count($FinanceAnnual)-1;$i>=0;$i--){
		?>
                        
                        <ul>
                        <li><h4>FY <?php echo $FinanceAnnual[$i][FY];?> </h4></li>  
                        <li><?php if($FinanceAnnual[$i][OptnlIncome]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][OptnlIncome]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][OtherIncome]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][OtherIncome]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][TotalIncome]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][TotalIncome]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][OptnlProfit]==0){echo '-';}else{$tot= $FinanceAnnual[$i][OptnlProfit]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][EBITDA]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][EBITDA]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][Interest]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][Interest]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][EBDT]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][EBDT]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][Depreciation]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][Depreciation]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][EBT]==0){echo '-';}else{ $tot=$FinanceAnnual[$i][EBT]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][Tax]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][Tax]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][PAT]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][PAT]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php echo '-'; ?></li>
                        <li><?php if($FinanceAnnual[$i][BINR]==0){echo '-';}else{$tot= $FinanceAnnual[$i][BINR]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][DINR]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][DINR]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php echo '-'; ?></li>
                         <li><?php echo '-'; ?></li>
                      <li><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][ForeignExchangeEarningandOutgo]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][ForeignExchangeEarningandOutgo]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][EarninginForeignExchange]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][EarninginForeignExchange]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($FinanceAnnual[$i][OutgoinForeignExchange]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][OutgoinForeignExchange]/$convalue;echo round($tot,2);} ?></li>
                        </ul>  
		<?php
		}
		for($i=0;$i<$projnext;$i++){
		?>  
                             <ul class="compare-list">
                        <li><h4>FY <?php echo $FinanceAnnual[0][FY]+1+$i;?> </h4></li>  
                        <li><?php if($calculation[$i][OptnlIncome]==0){echo '-';}else{ $tot= $calculation[$i][OptnlIncome]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][OtherIncome]==0){echo '-';}else{ $tot= $calculation[$i][OtherIncome]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][TotalIncome]==0){echo '-';}else{ $tot= $calculation[$i][TotalIncome]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][OptnlAdminandOthrExp]==0){echo '-';}else{$tot= $calculation[$i][OptnlAdminandOthrExp]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][OptnlProfit]==0){echo '-';}else{ $tot= $calculation[$i][OptnlProfit]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][EBITDA]==0){echo '-';}else{ $tot= $calculation[$i][EBITDA]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][Interest]==0){echo '-';}else{ $tot= $calculation[$i][Interest]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][EBDT]==0){echo '-';}else{$tot= $calculation[$i][EBDT]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][Depreciation]==0){echo '-';}else{ $tot= $calculation[$i][Depreciation]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][EBT]==0){echo '-';}else{$tot= $calculation[$i][EBT]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][Tax]==0){echo '-';}else{ $tot=$calculation[$i][Tax]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][PAT]==0){echo '-';}else{ $tot= $calculation[$i][PAT]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php echo '-'; ?></li>
                        <li><?php if($calculation[$i][BINR]==0){echo '-';}else{ $tot= $calculation[$i][BINR]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][DINR]==0){echo '-';}else{ $tot= $calculation[$i][DINR]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php echo '-'; ?></li>
                         <li><?php echo '-'; ?></li>
                      <li><?php if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){echo '-';}else{ $tot= $FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][ForeignExchangeEarningandOutgo]==0){echo '-';}else{ $tot= $calculation[$i][ForeignExchangeEarningandOutgo]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][EarninginForeignExchange]==0){echo '-';}else{ $tot= $calculation[$i][EarninginForeignExchange]/$convalue;echo round($tot,2);} ?></li>
                        <li><?php if($calculation[$i][OutgoinForeignExchange]==0){echo '-';}else{ $tot= $calculation[$i][OutgoinForeignExchange]/$convalue;echo round($tot,2);} ?></li>
                        </ul> 
                        
		<?php } ?>
	</div>	
	</div>
        
      </div>	
	</div>

			<?php
				/*Mean Calculations Starts*/
					for($i=0;$i<count($PL_STATNDARDFIELDS);$i++){
							$Test = 0;
							for($k=0;$k<$CompareCount;$k++){
								//pr($CompareResults[$k][$PL_STATNDARDFIELDS[$i]]);
									if($k == 0)
										$Test .= $CompareResults[$k][$PL_STATNDARDFIELDS[$i]]; 
									else
										$Test = $Test + $CompareResults[$k][$PL_STATNDARDFIELDS[$i]]; 	
					
							}
							// pr($Test);
							//echo $CompareMean[$i] =  $Test / $CompareCount;
					}
			
                                        
                                        
                                        /*Mean Calculations Ends*/
                                        
                                        mysql_close();
			?>
