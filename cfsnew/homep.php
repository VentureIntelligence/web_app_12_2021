<?php 

session_start();
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."city.php";
$city = new city();



/* --------------------- End of home.Php code */

/* Default search */
if(count($_REQUEST)==0)
{ 
    
    $_REQUEST['ListingStatus1']=2;
    $_REQUEST['answer']['Permissions']="0";
    $_REQUEST['answer']['Permissions2']="1";
    $_REQUEST['ResultType']="0";
    
}

if($_REQUEST['page']!='' && is_numeric($_REQUEST['page']))
    $page=$_REQUEST['page'];
else {
     $page=1;
}
if($_REQUEST['limit']!='' && is_numeric($_REQUEST['limit']))
    $page=$_REQUEST['limit'];
else{
    $limit=100;
}


$template->assign("city" , $city->getCity());
$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
$template->assign("grouplimit",$toturcount1);
$template->assign("searchupperlimit",$toturcount1[0][SubLimit]);
$template->assign("searchlowerlimit",$toturcount1[0][SubCount]);
//pr($toturcount1[0][SubLimit]);
//pr($toturcount1[0][SubCount]);

$template->assign("fdownload",$authAdmin->user->elements['ExDownloadCount']);

if($_REQUEST['resetfield']=="SearchFieds" ){
     $_REQUEST['answer']['SearchFieds'][$_REQUEST['resetfieldindex']]="";
     $_REQUEST['Grtr_'.$_REQUEST['resetfieldindex']]="";
     $_REQUEST['Less_'.$_REQUEST['resetfieldindex']]="";
}
else if($_REQUEST['resetfield']=="GrowthSearchFieds")
{
     $_REQUEST['answer']['GrowthSearchFieds'][$_REQUEST['resetfieldindex']]="";
     $_REQUEST['GrothPerc_'.$_REQUEST['resetfieldindex']]="";
     $_REQUEST['NumYears_'.$_REQUEST['resetfieldindex']]="";
}
else {
    unset($_REQUEST[$_REQUEST['resetfield']]);
    unset($_REQUEST['answer'][$_REQUEST['resetfield']]);
}

//tracking code

$Insert_CProfile['user_id']   = $authAdmin->user->elements['user_id'];
$visitdate=$users->selectByVisitCompany($Insert_CProfile['user_id']);
//pr($visitdate);
$Insert_CProfile2['SearchVisit'] = $visitdate[SearchVisit]+1;

$Insert_CProfile1['SearchVisit'] = $Insert_CProfile2['SearchVisit'];
$Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];
//pr($Insert_CProfile);

//pr($authAdmin->user->elements['permission']);
$users->update($Insert_CProfile1);

$Insert_CGroup['Group_Id'] = $authAdmin->user->elements['GroupList'];
$Insert_CGroup['SubCount'] = $Insert_CProfile1['SearchVisit'];
$grouplist->update($Insert_CGroup);

if($_REQUEST['Crores']!=""){
	$crores=$_REQUEST['Crores'];
}else{
	$crores=1;
}

//$matches1 = implode(',', unserialize($authAdmin->user->elements['company']));
//pr($authAdmin->user->elements['company']);
//if(count($matches1) > 0){
	//$pos = strpos($matches1,'N;');
	//if($pos === false){
		//$where .=  " b.Company_Id IN (".$matches1.")";
		//pr($where);
	//}
//}


//pr(unserialize($authAdmin->user->elements['Industry']));
//$matches = implode(',', unserialize($authAdmin->user->elements['Industry']));
//pr($matches);
//pr(count($matches));
//if(count($matches) > 0){
	//if($where != ''){
		//$where .=  " and b.Industry IN (".$matches.")";
	//}else{
		// $where .=  " b.Industry IN (".$matches.")";
	//}
	//pr($where);
//}
$listingstatus=array();
if($_REQUEST['ListingStatus'] != ""){
	$listingstatus[]=$_REQUEST['ListingStatus'];
}
if($_REQUEST['ListingStatus1'] != ""){
	$listingstatus[]=$_REQUEST['ListingStatus1'];
}
if($_REQUEST['ListingStatus2'] != ""){
	$listingstatus[]=$_REQUEST['ListingStatus2'];
}
if($_REQUEST['ListingStatus3'] != ""){
	$listingstatus[]=$_REQUEST['ListingStatus3'];
}
if(count($listingstatus)>0)
{
    $listingin=  implode(',', $listingstatus);
   if($where == ""){
		$where .=  "  b.ListingStatus  IN (".$listingin.")";
	}else{
		$where .=  " and  b.ListingStatus  IN (".$listingin.")";	
	} 
}
//if($_REQUEST['ListingStatus'] != "" && $_REQUEST['ListingStatus1'] == ""){
//	if($where == ""){
//		$where .=  "  b.ListingStatus  = ".$_REQUEST['ListingStatus'];
//	}else{
//		$where .=  " and  b.ListingStatus  = ".$_REQUEST['ListingStatus'];	
//	}	
//}
//
//if($_REQUEST['ListingStatus1'] != "" && $_REQUEST['ListingStatus'] == ""){
//	if($where == ""){
//		$where .=  "  b.ListingStatus  = ".$_REQUEST['ListingStatus1'];
//	}else{
//		$where .=  " and  b.ListingStatus  = ".$_REQUEST['ListingStatus1'];	
//	}	
//}

//pr($_REQUEST['answer']['Permissions']);
//pr($_REQUEST['answer']['Permissions2']);
$permissions=array();
if($_REQUEST['answer']['Permissions'] != "" && isset($_REQUEST['answer']['Permissions'])){
	$permissions[]=$_REQUEST['answer']['Permissions'];
}
if($_REQUEST['answer']['Permissions2'] != ""  && isset($_REQUEST['answer']['Permissions2'])){
	$permissions[]=$_REQUEST['answer']['Permissions2'];
}
/*if($_REQUEST['answer']['Permissions'] == 0 && $_REQUEST['answer']['Permissions2'] == ''){
	if($where != ''){
		$where .=  " and b.Permissions1  = '".$_REQUEST['answer']['Permissions']."'";
	}else{
		$where .=  " b.Permissions1  = '".$_REQUEST['answer']['Permissions']."'";
	}
	//pr($where);
}elseif($_REQUEST['answer']['Permissions2'] == 1 && $_REQUEST['answer']['Permissions'] == ''){
	if($where != ''){
		$where .=  " and b.Permissions1  = '".$_REQUEST['answer']['Permissions2']."'";
	}else{
		$where .=  " b.Permissions1  = '".$_REQUEST['answer']['Permissions2']."'";
	}
//	pr($where);
}else{
	if($where != ''){
		//$where .=  " and b.Permissions1 = 0";
	}else{
		//$where .=  " b.Permissions1 = 0";
	}
//	pr($where);
}

 */		

if(count($permissions)>0)
{
    $permissionsin=  implode(',', $permissions);
        if($where != ''){
		$where .=  " and b.Permissions1 IN (".$permissionsin.")";
	}else{
		$where .=  " b.Permissions1 IN (".$permissionsin.")";
	}
}

if($_REQUEST['CountingStatus'] == 0 && $_REQUEST['CountingStatus'] != ""){
	if($where != ''){
		$where .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}else{
		$where .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}
	//pr($where);
}elseif($_REQUEST['CountingStatus'] == 1){
	if($where != ''){
		$where .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}else{
		$where .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}
}elseif($_REQUEST['CountingStatus'] == 2){
	if($where != ''){
		$where .=  " and b.UserStatus = 0";
	}else{
		$where .=  " b.UserStatus = 0";
	}
}else{
	if($where != ''){
		//$where .=  " and b.UserStatus = 0";
	}else{
		//$where .=  " b.UserStatus = 0";
	}
//	pr($where);
}		


if($_REQUEST['answer']['Industry'] != ""){
	if($where != ''){
		$where .=  " and  a.IndustryId_FK  = ".$_REQUEST['answer']['Industry'];
	}else{
		$where .=  "a.IndustryId_FK  = ".$_REQUEST['answer']['Industry'];
	}
}	

if($_REQUEST['answer']['Sector'] != ""){
	if($where!=''){
		$where .=  " and  b.Sector  = ".$_REQUEST['answer']['Sector'];
	}else{
		$where .=  " b.Sector  = ".$_REQUEST['answer']['Sector'];
	}
}	

if($_REQUEST['answer']['SubSector'] != ""){
	$where .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
}	

//if($_REQUEST['ResultType'] != ""){
//   if($where != ''){
//		//$where .=  " and a.ResultType = ".$_REQUEST['ResultType'];
//	}else{
//		//$where .=  "a.ResultType =".$_REQUEST['ResultType'];
//	}
//}

$balancesheet = 0;

for($i=0;$i<count($_REQUEST['answer']['SearchFieds']);$i++){
	//pr($i);
	if($_REQUEST['answer']['SearchFieds'][$i] != ""){
		if($_REQUEST['answer']['SearchFieds'][$i]<5){
		}else{
			$balancesheet++;
		}
              
	}
        
}
if($_REQUEST['ResultType'] != "" && $balancesheet==0){
   if($where != ''){
		$where .=  " and a.ResultType = ".$_REQUEST['ResultType'];
	}else{
		$where .=  "a.ResultType =".$_REQUEST['ResultType'];
	}
           $filters['ResultType']=$_REQUEST['ResultType'];  
}else{
  if($where != ''){
		$where .=  " and c.ResultType = ".$_REQUEST['ResultType'];
	}else{
		$where .=  "c.ResultType =".$_REQUEST['ResultType'];
	}
            $filters['ResultType']=$_REQUEST['ResultType'];  
}

//pr(count($_REQUEST['answer']['SearchFieds'])-1);
$end=count($_REQUEST['answer']['SearchFieds'])-1;
/*Financial Search Starts*/
for($i=0;$i<count($_REQUEST['answer']['SearchFieds']);$i++){
	//pr($i);
	if($_REQUEST['answer']['SearchFieds'][$i] != ""){
		$Gtrt = 'Grtr_'.$i;
		$value=$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['SearchFieds'][$i]];
		if($_REQUEST['Commonandor'] == "" || $_REQUEST['Commonandor'] == "and"){
			if($_REQUEST[$Gtrt] != ""){
				$where .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
			}
			$Less = 'Less_'.$i;
			if($_REQUEST[$Less] != ""){
				$where .= " and a.".$value."<".($_REQUEST[$Less]*$crores);
			}
		}elseif($_REQUEST['Commonandor'] == "or" ){
			$Gtrt = 'Grtr_'.$i;
			if($Gtrt=='Grtr_0' && !empty($_REQUEST['Grtr_0'])){
				if($i == 0){
					$where .= " and ( a.".$value.">".($_REQUEST[$Gtrt]*$crores);
				}else{
					$where .= " and  a.".$value.">".($_REQUEST[$Gtrt]*$crores);
				}
			}elseif($_REQUEST[$Gtrt] != ""){
				$where .= " or a.".$value.">".($_REQUEST[$Gtrt]*$crores);
			}
			
			$Less = 'Less_'.$i;
			if($Less=='Less_0' && !empty($_REQUEST['Less_0'])){
				$where .= " or  a.".$value."<".($_REQUEST[$Less]*$crores);
			}elseif($_REQUEST[$Less] != ""){
				$where .= " or a.".$value."<".($_REQUEST[$Less]*$crores);
			}
			$end--;
			if($end == 0){
				$where .= " )";
				//pr($end);
			}

		}
	   if($i != count($_REQUEST['answer']['SearchFieds'])-2){
			//$where .= "&nbsp;".$_REQUEST['Commonandor'];
		}
		
		if($_REQUEST['Commonandor'] != ""){
			//$where .= $_REQUEST['Commonandor'] ." a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['SearchFieds'][$i]]." != ".'0';
			
		}else{
			//$where .= " and a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['SearchFieds'][$i]]." != ".'0';
		}
	}//Main If Ends
	//pr($where);
}//For Ends
/*Financial Search Ends*/

/*
if($_REQUEST['answer']['BusinessDesc'] != ""){
	$where .=  " and MATCH (b.BusinessDesc) AGAINST ('".$_REQUEST['answer']['BusinessDesc']."')  ";
}	

if($_REQUEST['Grtr_0'] != ""){
	$where .= " and  a.OptnlIncome >= ".$_REQUEST['Grtr_0'];
}	

if($_REQUEST['Less_0'] != ""){
	$where .= " and a.OptnlIncome <= ".$_REQUEST['Grtr_0'];
}	

if($_REQUEST['Grtr_1'] != ""){
	$where .=  " ".$_REQUEST['Commonandor'] ." a.EBITDA >= ".$_REQUEST['Grtr_1'];
}	

if($_REQUEST['Less_1'] != ""){
	$where .= " and a.EBITDA <= ".$_REQUEST['Less_1'];
	//$where .=  " and  OptnlIncome BETWEEN ".$_REQUEST['OptnlIncomeLess'] ." and " . $_REQUEST['OptnlIncomeGrtr'];
}	

if($_REQUEST['Grtr_2'] != ""){
	$where .= " ".$_REQUEST['Commonandor'] ." a.EBDT >= ".$_REQUEST['Grtr_2'];
}	

if($_REQUEST['Less_2'] != ""){
	$where .= " and a.EBDT <= ".$_REQUEST['Less_2'];
}	

if($_REQUEST['Grtr_3'] != ""){
	$where .= " ".$_REQUEST['Commonandor'] ." EBT >= ".$_REQUEST['Grtr_3'];
}	

if($_REQUEST['Less_3'] != ""){
	$where .= " and  a.EBT >= ".$_REQUEST['Less_3'];
}	

if($_REQUEST['Grtr_4'] != ""){
	$where .= " ".$_REQUEST['Commonandor'] ." a.PAT >= ".$_REQUEST['Grtr_4'];
}	

if($_REQUEST['Less_4'] != ""){
	$where .= " and a.PAT >= ".$_REQUEST['Less_4'];
}	
*/

/*Advanced Searches Starts*/
	if($_REQUEST['answer']['Region'] != ""){
		if($where!=''){
			$where .=  " and b.RegionId_FK = "."'".$_REQUEST['answer']['Region']."'";
		}else{
			$where .=  " b.RegionId_FK = "."'".$_REQUEST['answer']['Region']."'";
		}
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName, b.SCompanyName,b.ListingStatus","TotalIncome","b.Permissions1");
		$group = " b.SCompanyName ";
		//echo "1"; pr($where);
		$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,$page,$limit);
		$total=count($SearchResults);
		$template->assign("totalrecord",$total);
	}
	if($_REQUEST['answer']['State'] != NULL){
		if($where!=''){
			$where .=  " and  b.State  = ".$_REQUEST['answer']['State'];
		}else{
			$where .=  " b.State  = ".$_REQUEST['answer']['State'];
		}
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName");
		$group = " b.SCompanyName ";
                //echo "2";
		$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,$page,$limit);
		$total=count($SearchResults);
		$template->assign("totalrecord",$total);
	}	

	if($_REQUEST['answer']['City'] != NULL){
	    if($where!=''){
			$where .=  " and  b.City  = ".$_REQUEST['answer']['City'];
		}else{
			$where .=  " b.City  = ".$_REQUEST['answer']['City'];
		}
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName");
		$group = " b.SCompanyName ";
                //echo "3";
		$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,$page,$limit);
		$total=count($SearchResults);
		$template->assign("totalrecord",$total);
	}
	if(($_REQUEST['answer']['YearGrtr'] != "")&& ($_REQUEST['answer']['YearLess'] != "")){
		if($where!=''){
			$where .= " and (b.IncorpYear >= ".$_REQUEST['answer']['YearGrtr']." and b.IncorpYear <= ".$_REQUEST['answer']['YearLess'].")";
		}else{
			$where .= "(b.IncorpYear >= ".$_REQUEST['answer']['YearGrtr']." and b.IncorpYear <= ".$_REQUEST['answer']['YearLess'].")";
		}
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName");
		$group = " b.SCompanyName ";
		//pr($where);
               // echo "4";
		$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,$page,$limit);
		$total=count($SearchResults);
		$template->assign("totalrecord",$total);
	}	


/*Advanced Searches Ends*/

if($_REQUEST['YOYCAGR'] != ("gAnyOf" || 'gacross' || "CAGR")){

	$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName");
	if($where!=''){
		$where .= " and a.CId_FK = b.Company_Id"; // Original Where
	}else{
		$where .= " a.CId_FK = b.Company_Id"; // Original Where
	}
	if($_REQUEST['arcossall']=='across'){
		//$group .= "  b.Company_Id HAVING count(b.Company_Id) > b.FYCount";
		$group = " a.CId_FK HAVING count(a.CId_FK) = FYValue";
	}else{
		$group = " b.SCompanyName";
	}
	//$order12 = " ORDER BY b.SCompanyName ASC";
	$order = " a.FY DESC";
	//pr($fields);
	//pr($where);
	//pr($order);
	//pr($group);
        //echo "5";
	$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit);
	$total=count($SearchResults);
	//pr($SearchResults);
        $n_arr = array();$k=0; $countids= array();
         if ($_SESSION['resultCompanyId']) 
              unset($_SESSION['resultCompanyId']);
        for($i=0;$i<count($SearchResults);$i++)
        {
            $n_arr[] = $SearchResults[$i];
        }
        for($s=0;$s<count($n_arr);$s++,$k++)
        {
            $countids[$k]=$n_arr[$s]['Company_Id'];
        }
        $_SESSION['resultCompanyId'] = $countids;
       // print_r($countids);
        /* foreach ($SearchResults as $res)
         {
            $n_arr[$k++]=$res['Company_Id'];
         }*/
        
	$template->assign("SearchResults",$SearchResults);
	$template->assign("totalrecord",$total);
	/*Financial Search Ends*/
}

/*Growth Search YOY Starts*/
$end1=count($_REQUEST['answer']['GrowthSearchFieds'])-1;
if($_REQUEST['YOYCAGR'] == "gAnyOf" || $_REQUEST['YOYCAGR'] == "gacross"){
for($j=0;$j<count($_REQUEST['answer']['GrowthSearchFieds']);$j++){
	if($_REQUEST['answer']['GrowthSearchFieds'][$j] != ""){
		$GrothPerc = 'GrothPerc_'.$j;
		$value=$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$j]];
		if($_REQUEST['growthandor'] == "" || $_REQUEST['growthandor'] == "and"){
			if($_REQUEST[$GrothPerc] != ""){
				$where .= " and a.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			//pr($_REQUEST[$NumYears]);
			if($_REQUEST[$NumYears] != ""){
				//for($k=1;$k<=count($_REQUEST[$NumYears]);$k++){
					$where .= " and a.GrowthYear <=".$_REQUEST[$NumYears];
				//}
			}
		}elseif($_REQUEST['growthandor'] == "or" ){
			$GrothPerc = 'GrothPerc_'.$j;
			if($GrothPerc=='GrothPerc_0' && !empty($_REQUEST['GrothPerc_0'])){
				if($j == 0){
					$where .= " and ( a.".$value.">".($_REQUEST[$GrothPerc]);
				}else{
					$where .= " and  a.".$value.">".($_REQUEST[$GrothPerc]);
				}
			}elseif($_REQUEST[$GrothPerc] != ""){
				$where .= " or a.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			if($NumYears=='NumYears_0' && !empty($_REQUEST['NumYears_0'])){
				$where .= " or a.GrowthYear <=".($_REQUEST[$NumYears]);
			}elseif($_REQUEST[$NumYears] != ""){
				$where .= " or a.GrowthYear <=".($_REQUEST[$NumYears]);
			}
			$end1--;
			if($end1 == 0){
				$where .= " )";
				//pr($end);
			}

		}
	   if($j != count($_REQUEST['answer']['GrowthSearchFieds'])-2){
			//$where .= "&nbsp;".$_REQUEST['growthandor'];
		}
		
		if($_REQUEST['growthandor'] != ""){
			//$where .= $_REQUEST['growthandor'] ." a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$j]]." != ".'0';
			
		}else{
			//$where .= " and a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$j]]." != ".'0';
		}
	}//Main If Ends
	//pr($where);
}//For Ends
$where .= " and a.CId_FK = b.Company_Id"; // Original Where
if($_REQUEST['YOYCAGR']=='gacross'){
	//$where .= " and  b.FYCount >= ".$_REQUEST['NumYears_0']; // Original Where
	$group = " a.CId_FK HAVING count(a.CId_FK) = GFY";
}else{
	$group = " b.SCompanyName";
}
$fields = array("a.GrowthPerc_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome","b.GFYCount AS GFY","b.Permissions1","b.FYCount","b.SCompanyName");
//pr($fields);
//pr($where);
//pr($_REQUEST[$GrothPerc]);
//pr($order);
$order = " a.FY DESC";
//echo "6";
$growthResults = $growthpercentage->SearchHome($fields,$where,$order,$group,$page,$limit);
//pr($growthResults);
$total=count($growthResults);
$template->assign("totalrecord",$total);
$template->assign("SearchResults",$growthResults);

}//YOY IF Ends

/*Growth Search CAGR Ends*/
$end2=count($_REQUEST['answer']['GrowthSearchFieds'])-1;
if($_REQUEST['YOYCAGR'] == "CAGR"){
for($j=0;$j<count($_REQUEST['answer']['GrowthSearchFieds']);$j++){
	if($_REQUEST['answer']['GrowthSearchFieds'][$j] != ""){
		$GrothPerc = 'GrothPerc_'.$j;
		$value=$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$j]];
		if($_REQUEST['growthandor'] == "" || $_REQUEST['growthandor'] == "and"){
			if($_REQUEST[$GrothPerc] != ""){
				$where .= " and a.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			if($_REQUEST[$NumYears] != ""){
				$where .= " and a.CAGRYear=".($_REQUEST[$NumYears]);
			}
		}elseif($_REQUEST['growthandor'] == "or" ){
			$GrothPerc = 'GrothPerc_'.$j;
			if($GrothPerc=='GrothPerc_0' && !empty($_REQUEST['GrothPerc_0'])){
				if($j == 0){
					$where .= " and ( a.".$value.">".($_REQUEST[$GrothPerc]);
				}else{
					$where .= " and  a.".$value.">".($_REQUEST[$GrothPerc]);
				}
			}elseif($_REQUEST[$GrothPerc] != ""){
				$where .= " or a.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			if($NumYears=='NumYears_0' && !empty($_REQUEST['NumYears_0'])){
				$where .= " or a.CAGRYear <=".($_REQUEST[$NumYears]);
			}elseif($_REQUEST[$NumYears] != ""){
				$where .= " or a.CAGRYear <=".($_REQUEST[$NumYears]);
			}
			$end2--;
			if($end2 == 0){
				$where .= " )";
				//pr($end);
			}

		}
	   if($j != count($_REQUEST['answer']['GrowthSearchFieds'])-2){
			//$where .= "&nbsp;".$_REQUEST['growthandor'];
		}
		
		if($_REQUEST['growthandor'] != ""){
			//$where .= $_REQUEST['growthandor'] ." a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$j]]." != ".'0';
			
		}else{
			//$where .= " and a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$j]]." != ".'0';
		}
	}//Main If Ends
	//pr($where);
}//For Ends

$where .= " and  a.CId_FK = b.Company_Id"; // Original Where
$group = " b.SCompanyName ";
$fields = array("a.CAGR_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome","b.Permissions1","b.FYCount"," b.SCompanyName");
//pr($fields);
//pr($where);
//pr($order);
$order = " a.FY DESC";
echo "7";
$cagrResults = $cagr->SearchHome($fields,$where,$order,$group,$page,$limit);
//pr($SearchResults);
$total=count($cagrResults);
$template->assign("totalrecord",$total);
$template->assign("SearchResults",$cagrResults);

}//CAGR IF Ends
/*Growth Search CAGR Ends*/

/*Growth Search CAGR Starts*/
//if($_REQUEST['YOYCAGR'] == "CAGR"){
//	for($cagr=0;$cagr<count($_REQUEST['answer']['GrowthSearchFieds']);$cagr++){
//		if($_REQUEST['answer']['GrowthSearchFieds'][$cagr] != ""){//Main IF
//			$GrothPerc = 'GrothPerc_'.$cagr;
//			
//			
//			if($GrothPerc == "GrothPerc_0"){
//					$where .= " and (a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$cagr]]." >= ".$_REQUEST[$GrothPerc] ;
//			}else{
//				 $where .=  "&nbsp;".substr($_REQUEST['growthandor'], 1)." (a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$cagr]]." >= ".$_REQUEST[$GrothPerc] ;
//			}
//			
//			
//			$NumYears = 'NumYears_'.$cagr;
//			if($_REQUEST[$NumYears] != ""){
//				//$where .= " and  d.CAGRYear <= ".$_REQUEST[$NumYears].")";	
//					for($in=1;$in <= $_REQUEST[$NumYears];$in++){
//						$where .= " and  a.CAGRYear = ".$in;
//						if($in == $_REQUEST[$NumYears]){
//							$where .= " and a.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$cagr]]." != ".'0)' ;
//						}//If Ends
//					}//For Ends	
//				
//			}else{
//				$where .= ')';
//			}
//			
///*			if($_REQUEST['growthandor'] != ""){
//				$where .=  "&nbsp;".substr($_REQUEST['growthandor'], 1)." d.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$cagr]]." != ".'0';
//			}else{	
//				$where .= " and d.".$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['GrowthSearchFieds'][$cagr]]." != ".'0';
//			}
//*/		}//Main If Ends
//	}//For Ends
//$where .= " and  a.CId_FK = b.Company_Id"; // Original Where
//$group = " d.CId_FK ";
//$fields = array("a.CAGR_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome");
////pr($where);
////pr($fields);
////pr($where);
////pr($order);
//$cagrResults = $cagr->SearchHome($fields,$where,$order,$group);
////pr($SearchResults);
//$template->assign("SearchResults",$cagrResults);
//
//}//CAGR IF Ends
/*Growth Search CAGR Ends*/

/*Year Starts*/
	$BYearArry[""] = "Please Select a Year";
	for($i=1980; $i<=2020; $i++){
		$BYearArry[$i] .= $i;	
	}
	//pr($BYearArry);
	
	//$template->assign('selectedYear', $Selectedyear);
	$template->assign('BYearArry', $BYearArry);
/*Year Ends*/	
//pr($_REQUEST);




include "leftpanel.php";

//leftpanel display
//$companylimit = count($authAdmin->user->elements['company']);
//$companylimit1 = $companylimit - 1;
//pr($companylimit1);

//if($companylimit1 != 0){
	//$template->assign("companylimit",$companylimit1);
//}else{
    //$value='Unlimited';
	//$template->assign("companylimit",$value);
//}

if(isset($_POST['exportenable'])){
	//pr($SearchResults);
	//$exportarray = unserialize($_GET['exportid']); 
	//$exportarray = implode(',',$_POST['exportid']);
	//pr($exportarray);
	//pr($_POST['exportid']);
	$contents = $plstandard->exportFinacial($_POST['exportid']);
	//pr($contents);
	//$filename ="balancesheet.xls";
	//$contents = "testdata1 \t testdata2 \t testdata3 \t \n";
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=balancesheet.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$flag = false; 
	foreach($contents as $row) { 
	 if(!$flag) { 
	 // display field/column names as first row 
		 echo implode("\t", array_keys($row)) . "\r\n"; 
		 $flag = true; 
	 } 
	 array_walk($row, 'cleanData');
	 echo implode("\t", array_values($row)) . "\r\n"; 
	} 
	exit;
	
	/*
	$fp = fopen('balancesheet.csv', 'w');


	foreach ($contents as $fields) {
		fputcsv($fp, $fields);
	}

	fclose($fp);

	header("location:download.php?filename=balancesheet.csv");
	*/
}


$currentpage = curPageName();
$template->assign("currentpage",$currentpage);

$template->display('home.tpl');

include("footer.php");

//foll set of code added to home.php

$submitemail = isset($_REQUEST['mailid']) ? $_REQUEST['mailid'] : '';
$file="cfsbeta.txt";
$RegDate=date("M-d-Y");
$schema_insert="";
$sep = "\t"; //tabbed character
$cr = "\n"; //new line
$schema_insert .=$cr;
$schema_insert .=$RegDate.$sep; //Reg Date
$schema_insert .=$submitemail.$sep; //email
$schema_insert = str_replace($sep."$", "", $schema_insert);
$schema_insert .= ""."\n";

if (file_exists($file))
{
   $fp = fopen($file,"a+"); // $fp is now the file pointer to file
   if($fp)
   {
          fwrite($fp,$schema_insert);       //    Write information to the file
	  fclose($fp);  //    Close the file
          // echo "File saved successfully";
   }
   else
   {      echo "Error saving file!"; }
   }
   print "\n";
//set of code ends




?>