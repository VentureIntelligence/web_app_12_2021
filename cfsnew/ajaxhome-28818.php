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

require_once MAIN_PATH.APP_NAME."/aws.php";	// load logins

require_once('aws.phar');

use Aws\S3\S3Client;
$client = S3Client::factory(array(
    'key'    => $GLOBALS['key'],
    'secret' => $GLOBALS['secret']
));

/* --------------------- End of home.Php code */

if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in ajaxhome page -'.$_SESSION['username']); }


//if(isset($_POST['filterData']) && ($_POST['filterData'] == 'yes')){
    $where = "";
    $chargewhere = "";
    $whereHomeCountNew = "";
    $fliterFlag = false;
    $acrossallFlag = false;

    if($_POST['oldFinacialDataFlag'] !='display'){
    $current_year = date('y');
    for($i=$current_year;$i>= $current_year-2;$i--){
        $where .= " a.FY = '$i' or ";    
        $chargewhere .= " a.FY = '$i' or ";
        $whereHomeCountNew .= " a.FY = '$i' or ";       
    }
    $where = '('.trim($where,'or ').')';
    $chargewhere = '('.trim($chargewhere,'or ').')';
    $whereHomeCountNew = '('.trim($chargewhere,'or ').')';
    }
//}

if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { error_log('CFS authadmin userid Empty in Home -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { error_log('CFS authadmin GroupList Empty in Home -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }

//if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id']=='') { 
//    echo "<script language='javascript'>document.location.href='login.php'</script>";
//    exit();       
//}
//else if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList']=='') { 
//    echo "<script language='javascript'>document.location.href='login.php'</script>";
//    exit();       
//}


$getgroupid = $users->select($_SESSION["user_id"]);
$getgroup = $grouplist->select($getgroupid['GroupList']); 

if($getgroup['Industry']!=''){
    
    $where10 = "  Industry_Id IN ($getgroup[Industry]) "; // use to leftpanel.php
    
    $where12 = "  IndustryId_FK IN ($getgroup[Industry]) "; // use to leftpanel.php
    
    if($where != ''){
		$where .=  "    and  a.IndustryId_FK  IN ($getgroup[Industry]) ";
        $whereHomeCountNew .=  "    and  a.IndustryId_FK  IN ($getgroup[Industry]) ";
	}else{
		$where .=  "    a.IndustryId_FK  IN ($getgroup[Industry]) ";
        $whereHomeCountNew .=  "    a.IndustryId_FK  IN ($getgroup[Industry]) ";
	}
        
}

if($getgroup['Permissions']!=2)
{
    if($where != ''){
		$where .=  "    and  b.Permissions1  =".$getgroup['Permissions'] ;
	}else{
		$where .=  "    b.Permissions1  =".$getgroup['Permissions'] ;
	}

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  "    and  b.Permissions1  =".$getgroup['Permissions'] ;
    }else{
        $whereHomeCountNew .=  "    b.Permissions1  =".$getgroup['Permissions'] ;
    }
}



//

// start index of charge filter
$chargewhere="";
if(isset($_REQUEST['chargefromdate']) && $_REQUEST['chargefromdate']!='' ){
    
    $filterFlag = true;
    if($_REQUEST['chargetodate']!='') {            
        $chargetodate=$_REQUEST['chargetodate'];    
     }
     else{
          $chargetodate = date('Y-m-d');
     }
     
     
     if($chargewhere != ''){
                    $chargewhere .="    and  (`Date of Charge` BETWEEN "."'".$_REQUEST['chargefromdate']."' AND "."'".$chargetodate."' ) ";
            }else{
                    $chargewhere .="    (`Date of Charge` BETWEEN "."'".$_REQUEST['chargefromdate']."' AND "."'".$chargetodate."' ) ";
            }
    
  
        $template->assign("chargefromdate" , $_REQUEST['chargefromdate']);
        $template->assign("chargetodate" , $chargetodate);
      
    
}
if(isset($_REQUEST['chargefromamount']) && $_REQUEST['chargefromamount']!=''  ){
    $filterFlag = true;
    $chargefromamount = $_REQUEST['chargefromamount']*10000000;
    
    if($_REQUEST['chargetoamount']!='' && ($_REQUEST['chargefromamount'] <= $_REQUEST['chargetoamount'])){
        
        $chargetoamount = $_REQUEST['chargetoamount']*10000000;

        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }else{
                    $chargewhere .="    ROUND(REPLACE(`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }
           $template->assign("chargetoamount" , $chargetoamount/10000000);
    }
    else{
        
        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }else{
                    $chargewhere .="    ROUND(REPLACE(`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }
    }
    
    
       
        $template->assign("chargefromamount" , $_REQUEST['chargefromamount']);
        
       
}

if(isset($_REQUEST['chargeholdertest']) && $_REQUEST['chargeholdertest']!='' ){
    $filterFlag = true;
    $chargeholderarr = explode(',', $_REQUEST['chargeholdertest']);

    foreach($chargeholderarr as $ch){
        
        $chargeholder.= "'".$ch."',";
        
    }

    $chargeholder = substr($chargeholder, 0,-1);
   
    if($chargewhere != ''){
		$chargewhere .=" and `Charge Holder` IN (".$chargeholder.")";
	}else{
		$chargewhere .=" `Charge Holder` IN (".$chargeholder.")";
	}
        $template->assign("chargeholdertest" , $_REQUEST['chargeholdertest']);
       
}

/*if(isset($_REQUEST['chargeholder']) && $_REQUEST['chargeholder']!='' ){
    $chargeholder = preg_replace('/\s+/', ' ', $_REQUEST['chargeholder']);
    
    if($chargewhere != ''){
		$chargewhere .=" and `Charge Holder` = '$chargeholder'";
	}else{
		$chargewhere .=" `Charge Holder` = '$chargeholder' ";
	}
        
        $template->assign("chargeholder" , $chargeholder);
       
}*/
if(isset($_REQUEST['chargeaddress']) && $_REQUEST['chargeaddress']!=''){
    
    if($chargewhere != ''){
		$chargewhere .="    and `Address` LIKE  "."'%".$_REQUEST['chargeaddress']."%'";
	}else{
		$chargewhere .="    `Address` LIKE "."'%".$_REQUEST['chargeaddress']."%'";
	}
        
        $template->assign("chargeaddress" , $_REQUEST['chargeaddress']);
       
}


if($chargewhere!=''){
    $template->assign("chargewhere" ,$chargewhere);
}

 // end index of charge filter




//Industry Id from details page 
if ($_GET['industryId']){
    $_REQUEST['answer']['Industry'] = $_GET['industryId'];
}


/* Default search */
if($_REQUEST['pageno']!='' && is_numeric($_REQUEST['pageno'])) {
$page=$_REQUEST['pageno']; 
unset($_REQUEST['pageno']);
}
else {
     $page=1;
}
if($_REQUEST['limit']!='' || $_REQUEST['limit']=="all"){
    $limit=$_REQUEST['limit'];
unset($_REQUEST['limit']);}
else{
    $limit=25;
}

if(count($_POST)==0)
{
    $_REQUEST['ListingStatus']=1;
    $_REQUEST['ListingStatus1']=2;
    $_REQUEST['ListingStatus2']=3;
    $_REQUEST['ListingStatus3']=4;
    $_REQUEST['answer']['Permissions']="0";
    $_REQUEST['answer']['Permissions2']="1";
    $_REQUEST['CountingStatus']=$authAdmin->user->elements['CountingStatus'];
    $_REQUEST['sortby']="sortcompanyandfy";
    $_REQUEST['sortorder']="asc";
}

if (!$_REQUEST['ResultType'])
    $_REQUEST['ResultType']="0";

$order2="";$orderc='';
if($_REQUEST['sortby']=="sortcompanyandfy")
{
    $order2.="FIELD(a.FY,'17') DESC,FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc";
}
elseif ($_REQUEST['sortby']=="sortcompany")
{
    $order2.="b.SCompanyName  ".$_REQUEST['sortorder'];
}
elseif ($_REQUEST['sortby']=="sortrevenue") {
    $order2.="TotalIncome ".$_REQUEST['sortorder'];
}
elseif ($_REQUEST['sortby']=="sortebita") {
    $order2.="a.EBITDA ".$_REQUEST['sortorder'];
}
elseif ($_REQUEST['sortby']=="sortpat") {
    $order2.="a.PAT ".$_REQUEST['sortorder'];
}
elseif ($_REQUEST['sortby']=="sortdetailed") {
   $order2.="a.FY ".$_REQUEST['sortorder'];
}
elseif ($_REQUEST['sortby']=="sortnew") {
   $order2.="b.Added_Date ".$_REQUEST['sortorder'];
}
else{
    $order2.="FIELD(a.FY,'17') DESC,FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc";
}
$template->assign("sortby" , $_REQUEST['sortby']);
$template->assign("sortorder" , $_REQUEST['sortorder']);



$template->assign("city" , $city->getCity());
$template->assign("curPage" , $page);
$template->assign("limit" , $limit);
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


//pr($authAdmin->user->elements['permission']);
$users->update($Insert_CProfile1);


$sum_visit=$users->sum_searchBygroup($authAdmin->user->elements['GroupList']);

$Insert_CGroup['Group_Id'] = $authAdmin->user->elements['GroupList'];
$Insert_CGroup['SubCount'] = $sum_visit[SearchVisit_sum];


$grouplist->update($Insert_CGroup);

if($_REQUEST['Crores']!=""){
	$crores=$_REQUEST['Crores'];
}else{
	$crores=1;
}

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

    if($whereHomeCountNew == ""){
        $whereHomeCountNew .=  "  b.ListingStatus  IN (".$listingin.")";
    }else{
        $whereHomeCountNew .=  " and  b.ListingStatus  IN (".$listingin.")";    
    }
}

$permissions=array();
if($_REQUEST['answer']['Permissions'] != "" && isset($_REQUEST['answer']['Permissions'])){
	$permissions[]=$_REQUEST['answer']['Permissions'];
}
if($_REQUEST['answer']['Permissions2'] != ""  && isset($_REQUEST['answer']['Permissions2'])){
	$permissions[]=$_REQUEST['answer']['Permissions2'];
}

if(count($permissions)>0)
{
    $permissionsin=  implode(',', $permissions);
        if($where != ''){
		$where .=  " and b.Permissions1 IN (".$permissionsin.")";
	}else{
		$where .=  " b.Permissions1 IN (".$permissionsin.")";
	}

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and b.Permissions1 IN (".$permissionsin.")";
    }else{
        $whereHomeCountNew .=  " b.Permissions1 IN (".$permissionsin.")";
    }

}

if($_REQUEST['CountingStatus'] == 0 && $_REQUEST['CountingStatus'] != ""){
	if($where != ''){
		$where .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}else{
		$where .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
    }else{
        $whereHomeCountNew .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
    }
	//pr($where);
}elseif($_REQUEST['CountingStatus'] == 1){
	if($where != ''){
		$where .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}else{
		$where .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
	}

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
    }else{
        $whereHomeCountNew .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
    }
}elseif($_REQUEST['CountingStatus'] == 2){
	if($where != ''){
		$where .=  " and b.UserStatus = 0";
	}else{
		$where .=  " b.UserStatus = 0";
	}

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and b.UserStatus = 0";
    }else{
        $whereHomeCountNew .=  " b.UserStatus = 0";
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

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and  a.IndustryId_FK  = ".$_REQUEST['answer']['Industry'];
    }else{
        $whereHomeCountNew .=  "a.IndustryId_FK  = ".$_REQUEST['answer']['Industry'];
    }
}	

if($_REQUEST['answer']['Sector'] != ""){
	if($where!=''){
		$where .=  " and  b.Sector  = ".$_REQUEST['answer']['Sector'];
	}else{
		$where .=  " b.Sector  = ".$_REQUEST['answer']['Sector'];
	}

    if($whereHomeCountNew!=''){
        $whereHomeCountNew .=  " and  b.Sector  = ".$_REQUEST['answer']['Sector'];
    }else{
        $whereHomeCountNew .=  " b.Sector  = ".$_REQUEST['answer']['Sector'];
    }
}	

if($_REQUEST['answer']['SubSector'] != ""){
	$where .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
    $whereHomeCountNew .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
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

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and a.ResultType = ".$_REQUEST['ResultType'];
    }else{
        $whereHomeCountNew .=  "a.ResultType =".$_REQUEST['ResultType'];
    }
           $filters['ResultType']=$_REQUEST['ResultType'];  
}else{
  if($where != ''){
		$where .=  " and c.ResultType = ".$_REQUEST['ResultType'];
	}else{
		$where .=  "c.ResultType =".$_REQUEST['ResultType'];
	}

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  " and c.ResultType = ".$_REQUEST['ResultType'];
    }else{
        $whereHomeCountNew .=  "c.ResultType =".$_REQUEST['ResultType'];
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
			if($_REQUEST[$Gtrt] != "" && $_REQUEST[$Gtrt] < 100){
                            
				$where .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                $whereHomeCountNew .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
			}
                        else if($_REQUEST[$Gtrt] != "" && $_REQUEST[$Gtrt] >= 100)
                        {
                            
                            $where .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                            $whereHomeCountNew .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                        }
			$Less = 'Less_'.$i;
			if($_REQUEST[$Less] != ""){
				$where .= " and a.".$value."<".($_REQUEST[$Less]*$crores);
                $whereHomeCountNew .= " and a.".$value."<".($_REQUEST[$Less]*$crores);
			}
		}elseif($_REQUEST['Commonandor'] == "or" ){
			$Gtrt = 'Grtr_'.$i;
			if($Gtrt=='Grtr_0' && !empty($_REQUEST['Grtr_0'])){
				if($i == 0){
					//$where .= " and ( a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                        if($_REQUEST[$Gtrt] < 100){
                            
                                            $where .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                            $whereHomeCountNew .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                        }
                                        else if($_REQUEST[$Gtrt] >= 100)
                                        {

                                            $where .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                                            $whereHomeCountNew .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                                        }
				}else{
					//$where .= " and  a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                        if($_REQUEST[$Gtrt] < 100){
                            
                                            $where .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                            $whereHomeCountNew .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
				}
                                        else if($_REQUEST[$Gtrt] >= 100)
                                        {

                                            $where .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                                            $whereHomeCountNew .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                                        }
				}
			}elseif($_REQUEST[$Gtrt] != ""){
				//$where .= " or a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                if($_REQUEST[$Gtrt] < 100){
                            
                                    $where .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                    $whereHomeCountNew .= " and a.".$value.">".($_REQUEST[$Gtrt]*$crores);
			}
                                else if($_REQUEST[$Gtrt] >= 100)
                                {
			
                                    $where .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                                    $whereHomeCountNew .= " and (a.".$value.">".($_REQUEST[$Gtrt]*$crores)." )";
                                }
			}
			
			$Less = 'Less_'.$i;
			if($Less=='Less_0' && !empty($_REQUEST['Less_0'])){
				//$where .= " or  a.".$value."<".($_REQUEST[$Less]*$crores);
                                 $where .= " and  a.".$value."<".($_REQUEST[$Less]*$crores);
                                 $whereHomeCountNew .= " and  a.".$value."<".($_REQUEST[$Less]*$crores);
			}elseif($_REQUEST[$Less] != ""){
				//$where .= " or a.".$value."<".($_REQUEST[$Less]*$crores);
                                $where .= " and a.".$value."<".($_REQUEST[$Less]*$crores);
                                $whereHomeCountNew .= " and a.".$value."<".($_REQUEST[$Less]*$crores);
			}
			$end--;
			if($end == 0){
				//$where .= " )";
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

/*Advanced Searches Starts*/
        /* if($_GET['searchv']!=''){
		if($where!=''){
			$where .= "and b.SCompanyName like '".$_GET['searchv']."%'";
		}else{
			$where .= "b.SCompanyName like '".$_GET['searchv']."%'";
}	


		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName");
		$group = " b.SCompanyName ";
		//pr($where);
               // echo "4";
                $allSearchResults = $plstandard->SearchHome($fields,$where,$order,$group);
                $total=count($allSearchResults);
		$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
		$template->assign("totalrecord",$total);
	}*/

        if($_GET['searchv']!=''){
            if($where!=''){
                    $where .= " and b.SCompanyName like '%".$_GET['searchv']."%'";
            }else{
                    $where .= " b.SCompanyName like '%".$_GET['searchv']."%'";
            }

            if($whereHomeCountNew!=''){
                    $whereHomeCountNew .= " and b.SCompanyName like '%".$_GET['searchv']."%'";
            }else{
                    $whereHomeCountNew .= " b.SCompanyName like '%".$_GET['searchv']."%'";
            }

            $template->assign("searchv",$_GET['searchv']);
         }  else {
             $template->assign("searchv","");
}	
	if(count($_REQUEST['answer']['Region']) > 0){
        $fliterFlag = true;
            $regions_where = '';
            foreach($_REQUEST['answer']['Region'] as $regions){
                $regions_where .=  "  b.RegionId_FK = "."'".$regions."' or ";
            }
            if(trim($regions_where) != ''){
                $regions_where = " ( ".trim($regions_where,'or ').' ) ';
            }
          if($where!=''){
                    $where .=  " and $regions_where";
          }else{
                    $where .=  $regions_where;
          }

            if($whereHomeCountNew!=''){
                $whereHomeCountNew .=  " and $regions_where";
            }else{
                    $whereHomeCountNew .=  $regions_where;
            }
		if($where!=''){
			$where .=  " and a.CId_FK = b.Company_Id ";
		}else{
			$where .=  " a.CId_FK = b.Company_Id ";
		}
                
                 if($where!=''){
			$where .=  " and  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}else{
			$where .=  "  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}

        $maxFYQuery = "INNER JOIN (
                            SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                        ) as aa
                        ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";
                
                
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName, b.SCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.Industry"," b.Sector");
		$group = " b.SCompanyName ";
		//echo "1"; pr($where);
                /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order2,$group);
		$SearchResults = $plstandard->SearchHome($fields,$where,$order2,$group,"name",$page,$limit,$client='');
                
		$total=count($allSearchResults);*/
		
                
               
		//$template->assign("totalrecord",$total);
	}
	if(count($_REQUEST['answer']['State']) > 0){
            $fliterFlag = true;
                $state_where = $statevalue = '';
                foreach($_REQUEST['answer']['State'] as $states){
                    $state_where .=  "  b.State = "."'".$states."' or ";
                    $statesql= "select state_name from state where state_id=$states";
                    if ($staters = mysql_query($statesql))
                    {
                        While($myrow=mysql_fetch_array($staters, MYSQL_BOTH))
                        {
                            $statevalue .= $myrow["state_name"].', ';
                        }
                    }
                }
                if($statevalue != ''){
                    $statevalue = trim($statevalue,', ');
                }
                if(trim($state_where) != ''){
                    $state_where = " ( ".trim($state_where,'or ').' ) ';
                }
                if($where!=''){
			$where .=  " and  $state_where ";
		}else{
			$where .=  " $state_where ";
		}

        if($whereHomeCountNew!=''){
            $whereHomeCountNew .=  " and  $state_where ";
        }else{
            $whereHomeCountNew .=  " $state_where ";
        }
              
		if($where!=''){
			$where .=  " and a.CId_FK = b.Company_Id ";
		}else{
			$where .=  " a.CId_FK = b.Company_Id ";
		}
                
                
                 
                 if($where!=''){
			$where .=  " and  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}else{
			$where .=  "  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}
                
        $maxFYQuery = "INNER JOIN (
                                    SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                                ) as aa
                                ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";
                
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
		$group = " b.SCompanyName ";
                //echo "2";
                /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order2,$group);
                
                     $total=count($allSearchResults);
		$SearchResults = $plstandard->SearchHome($fields,$where,$order2,$group,"name",$page,$limit,$client='');*/
		//print_r($SearchResults);
		
		//$template->assign("totalrecord",$total);
	}	

	if($_REQUEST['answer']['City'] != NULL){
        $fliterFlag = true;
                $city_where = $cityvalue = '';
                foreach($_REQUEST['answer']['City'] as $cities){
                    $city_where .=  "  b.City = "."'".$cities."' or ";
                    $citysql= "select city_name from city where city_id=$cities";
                    if ($cityrs = mysql_query($citysql))
                    {
                        While($myrow=mysql_fetch_array($cityrs, MYSQL_BOTH))
                        {
                            $cityvalue .= $myrow["city_name"].', ';
                        }
                    }
                }
                if($cityvalue != ''){
                    $cityvalue = trim($cityvalue,', ');
                }
                if(trim($city_where) != ''){
                    $city_where = " ( ".trim($city_where,'or ').' ) ';
                }
	    if($where!=''){
			$where .=  " and  $city_where ";
		}else{
			$where .=  " $city_where ";
		}

        if($whereHomeCountNew!=''){
                    $whereHomeCountNew .=  " and  $city_where ";
                }else{
                    $whereHomeCountNew .=  " $city_where ";
                }
                
                 if($where!=''){
			$where .=  " and a.CId_FK = b.Company_Id ";
		}else{
			$where .=  " a.CId_FK = b.Company_Id ";
		}
                
                 
                if($where!=''){
			$where .=  " and  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}else{
			$where .=  "  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}
                
        $maxFYQuery = "INNER JOIN (
                                    SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                                ) as aa
                                ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";        
                
		$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
		$group = " b.SCompanyName ";
                //echo "3";
                 /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order2,$group);
                     $total=count($allSearchResults);
		$SearchResults = $plstandard->SearchHome($fields,$where,$order2,$group,"name",$page,$limit,$client='');
		$template->assign("totalrecord",$total);*/
                }
               
        
        if(($_REQUEST['answer']['YearGrtr'] != "") || ($_REQUEST['answer']['YearLess'] != "")){
            
            $yr_g = $_REQUEST['answer']['YearGrtr'];
            $yr_l = $_REQUEST['answer']['YearLess'];
            $yr_filter='';
            
            if( (($yr_g==$yr_l) || ($yr_g <= $yr_l)) && ( $yr_g!='' && $yr_l!='')  ){
                $yr_filter = "(b.IncorpYear >= ".$yr_g." and b.IncorpYear <= ".$yr_l.")";                
	}
            else if( $yr_g!='' && $yr_g>0 && $yr_l==''){
                 $yr_filter = "(b.IncorpYear >= ".$yr_g.")";  
            }
            else if( $yr_l!='' && $yr_l>0 && $yr_g==''){
                 $yr_filter = "(b.IncorpYear <= ".$yr_l.")";  
            }
            else {
                $_REQUEST['answer']['YearGrtr']='';
                $_REQUEST['answer']['YearLess']='';
            }
            
            
            if($yr_filter!=''){
		if($where!=''){
			$where .= " and $yr_filter";
		}else{
			$where .= $yr_filter;
		}

        if($whereHomeCountNew!=''){
                    $whereHomeCountNew .= " and $yr_filter";
                }else{
                    $whereHomeCountNew .= $yr_filter;
                }

            }
	}	

if( $fliterFlag && $chargewhere == '' ) {
    $total = $plstandard->SearchHomecount($whereHomeCountNew,$group,$maxFYQuery);
    $template->assign("totalrecord",$total);
    $SearchResults = $plstandard->SearchHomeOpt($fields,$whereHomeCountNew,$order2,$group,"name",$page,$limit,$client='',$maxFYQuery);
}

/*Advanced Searches Ends*/

if($_REQUEST['YOYCAGR'] != ("gAnyOf" || 'gacross' || "CAGR")){

	$fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
	$fields1 = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
	if($where!=''){
		$where .= " and a.CId_FK = b.Company_Id"; // Original Where
	}else{
		$where .= " a.CId_FK = b.Company_Id"; // Original Where
	}
        
         
         if($where!=''){
			$where .=  " and  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}else{
			$where .=  "  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}
                
           $maxFYQuery = "INNER JOIN (
                        SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                    ) as aa
                    ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";     
                
	if($_REQUEST['arcossall']=='across'){
		//$group .= "  b.Company_Id HAVING count(b.Company_Id) > b.FYCount";
		$group = " a.CId_FK HAVING count(a.CId_FK) = FYValue";
	}else{
		$group = " b.SCompanyName";
	}
        
        if($chargewhere!=''){
            $total = $plstandard->SearchHome_WithCharges_cnt($chargewhere,$fields,$whereHomeCountNew,$order2,$group,$maxFYQuery);
            $SearchExport = $plstandard->SearchHome_WithChargesExport($chargewhere,$fields,$where,$order2,$group);
            $SearchResults = $plstandard->SearchHome_WithChargesOpt($chargewhere,$fields,$whereHomeCountNew,$order2,$group,"name",$page,$limit,$client='',$maxFYQuery);
            /*$allSearchResults = $plstandard->SearchHome_WithCharges_cnt($chargewhere,$fields4,$where,$order2,$group);
            $total=$allSearchResults[0]['count'];
            $SearchExport = $plstandard->SearchHome_WithChargesExport($chargewhere,$fields,$where,$order2,$group);
            $SearchResults = $plstandard->SearchHome_WithCharges($chargewhere,$fields,$where,$order2,$group,"name",$page,$limit,$client='');*/
        }
        else{
            if( !$fliterFlag ) {
                $total = $plstandard->SearchHomecount($whereHomeCountNew,$group,$maxFYQuery,$acrossallFlag);
                $SearchResults = $plstandard->SearchHomeOpt($fields,$whereHomeCountNew,$order2,$group,"name",$page,$limit,$client='',$maxFYQuery);
            }
            $SearchExport = $plstandard->SearchHomeExportNew($fields1,$whereHomeCountNew,$order2,$group,'','','','',$maxFYQuery);
            /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order2,$group);
            $total=count($allSearchResults);
            $SearchExport = $plstandard->SearchHomeExport($fields1,$where,$order2,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order2,$group,"name",$page,$limit,$client='');*/
        }
	
	
       // print_r($countids);
        /* foreach ($SearchResults as $res)
         {
            $n_arr[$k++]=$res['Company_Id'];
         }*/
        $template->assign("searchexport",$SearchExport);
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
				$where1 .= " and c.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			//pr($_REQUEST[$NumYears]);
			if($_REQUEST[$NumYears] != ""){
				//for($k=1;$k<=count($_REQUEST[$NumYears]);$k++){
					$where .= " and c.GrowthYear <=".$_REQUEST[$NumYears];
				//}
			}
		}elseif($_REQUEST['growthandor'] == "or" ){
			$GrothPerc = 'GrothPerc_'.$j;
			if($GrothPerc=='GrothPerc_0' && !empty($_REQUEST['GrothPerc_0'])){
				if($j == 0){
					$where .= " and ( c.".$value.">".($_REQUEST[$GrothPerc]);
				}else{
					$where .= " and  c.".$value.">".($_REQUEST[$GrothPerc]);
				}
			}elseif($_REQUEST[$GrothPerc] != ""){
				$where .= " or c.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			if($NumYears=='NumYears_0' && !empty($_REQUEST['NumYears_0'])){
				$where .= " or c.GrowthYear <=".($_REQUEST[$NumYears]);
			}elseif($_REQUEST[$NumYears] != ""){
				$where .= " or c.GrowthYear <=".($_REQUEST[$NumYears]);
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
$where .= " and c.CId_FK = b.Company_Id AND a.CId_FK = c.CId_FK"; // Original Where
if($_REQUEST['YOYCAGR']=='gacross'){
	//$where .= " and  b.FYCount >= ".$_REQUEST['NumYears_0']; // Original Where
	//$group = " t1.CId_FK HAVING count(t1.CId_FK) = GFY";
        $group = " t1.SCompanyName";
}else{
	$group = " t1.SCompanyName";
}

                
   
//pr($fields);
//pr($where);
//pr($_REQUEST[$GrothPerc]);
//pr($order);
// $order = " a.FY DESC,b.SCompanyName ASC";
                
            $fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.GFYCount AS GFY","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
           $fields2 = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
                
           // $fields2= array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.GFYCount AS GFY","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
            if(isset($_REQUEST['sortby'])){
                
               
                if ($_REQUEST['sortby']=="sortcompany")
                {
                    $orderc.="t1.SCompanyName  ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortrevenue") {
                    $orderc.="TotalIncome ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortebita") {
                    $orderc.="t1.EBITDA ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortpat") {
                    $orderc.="t1.PAT ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortdetailed") {
                   $orderc.="t1.FY ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortnew") {
                   $orderc.="t1.Added_Date ".$_REQUEST['sortorder'];
            } 
            } 
            else {
                
                $orderc="FIELD(t1.FY,'17') DESC,FIELD(t1.FY,'16') DESC,FIELD(t1.FY,'15') DESC, t1.FY DESC, t1.SCompanyName asc"; 
            }
           
                
            if($chargewhere!=''){
                
                $allgrowthResults = $growthpercentage->SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields,$where,$orderc,$group);
                $total=$allgrowthResults[0]['count'];
                $SearchExport2 = $growthpercentage->SearchHomeExport1_WithCharges($chargewhere,$fields2,$where,$orderc,$group);
                $growthResults = $growthpercentage->SearchHomeGrowth_WithCharges($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');        
            }
            else{
                $total = $growthpercentage->SearchHomeGrowth_cnt($fields2,$where,$orderc,$group);
                $SearchExport2 = $growthpercentage->SearchHomeExport1($fields2,$where,$orderc,$group);
                $growthResults = $growthpercentage->SearchHomeGrowth($fields2,$where,$orderc,$group,"name",$page,$limit,$client='');
                /*$allgrowthResults = $growthpercentage->SearchHomeGrowth($fields2,$where,$orderc,$group);
                $total=count($allgrowthResults);
                $SearchExport2 = $growthpercentage->SearchHomeExport1($fields2,$where,$orderc,$group);
                $growthResults = $growthpercentage->SearchHomeGrowth($fields2,$where,$orderc,$group,"name",$page,$limit,$client='');*/
            }
        

$template->assign("searchexport2",$SearchExport2);
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
				$where .= " and c.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			if($_REQUEST[$NumYears] != ""){
				$where .= " and c.CAGRYear=".($_REQUEST[$NumYears]);
			}
		}elseif($_REQUEST['growthandor'] == "or" ){
			$GrothPerc = 'GrothPerc_'.$j;
			if($GrothPerc=='GrothPerc_0' && !empty($_REQUEST['GrothPerc_0'])){
				if($j == 0){
					$where .= " and ( c.".$value.">".($_REQUEST[$GrothPerc]);
				}else{
					$where .= " and  c.".$value.">".($_REQUEST[$GrothPerc]);
				}
			}elseif($_REQUEST[$GrothPerc] != ""){
				$where .= " or c.".$value.">".($_REQUEST[$GrothPerc]);
			}
			$NumYears = 'NumYears_'.$j;
			if($NumYears=='NumYears_0' && !empty($_REQUEST['NumYears_0'])){
				$where .= " or c.CAGRYear <=".($_REQUEST[$NumYears]);
			}elseif($_REQUEST[$NumYears] != ""){
				$where .= " or c.CAGRYear <=".($_REQUEST[$NumYears]);
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


            $where .= " and  c.CId_FK = b.Company_Id AND a.CId_FK = c.CId_FK"; // Original Where
            $group = " t1.SCompanyName ";
            $fields = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
            $fields2 = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");

            if(isset($_REQUEST['sortby'])){
                
               
                if ($_REQUEST['sortby']=="sortcompany")
                {
                    $orderc.="t1.SCompanyName  ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortrevenue") {
                    $orderc.="TotalIncome ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortebita") {
                    $orderc.="t1.EBITDA ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortpat") {
                    $orderc.="t1.PAT ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortdetailed") {
                   $orderc.="t1.FY ".$_REQUEST['sortorder'];
                }
                elseif ($_REQUEST['sortby']=="sortnew") {
                   $orderc.="t1.Added_Date ".$_REQUEST['sortorder'];
            } 
            } 
            else {
                
                $orderc="FIELD(t1.FY,'17') DESC,FIELD(t1.FY,'16') DESC,FIELD(t1.FY,'15') DESC, t1.FY DESC, t1.SCompanyName asc"; 
            }	
//pr($fields);
//pr($where);
//pr($order);
//$order = " a.FY DESC,b.SCompanyName ASC";
 if($chargewhere!=''){
    
     $allcagrResults = $cagr->SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');
     $total=$allcagrResults[0]['count'];
           
     $cagrResults = $cagr->SearchHomeGrowth_WithCharges($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');
     
     $SearchExport3 = $cagr->SearchHomeExport1_WithCharges($chargewhere,$fields2,$where,$orderc,$group); 
     
     
 }
 else {
    $total = $cagr->SearchHomeGrowth_cnt($fields,$where,$orderc,$group);
    $SearchExport3 = $cagr->SearchHomeExport1($fields2,$where,$orderc,$group);
    $cagrResults = $cagr->SearchHomeGrowthOpt($fields,$where,$orderc,$group,"name",$page,$limit,$client='');
/*$allcagrResult = $cagr->SearchHomeGrowth($fields,$where,$orderc,$group);
$total=count($allcagrResult);
$SearchExport3 = $cagr->SearchHomeExport1($fields2,$where,$orderc,$group);
$cagrResults = $cagr->SearchHomeGrowth($fields,$where,$orderc,$group,"name",$page,$limit,$client='');*/  
//pr($SearchResults);
//$total=count($cagrResults);

 }
 
$template->assign("searchexport3",$SearchExport3);
$template->assign("totalrecord",$total);
$template->assign("SearchResults",$cagrResults);
}//CAGR IF Ends
/*Growth Search CAGR Ends*/



         $n_arr = array();$k=0; $countids= array();
         if ($_SESSION['resultCompanyId']) 
              unset($_SESSION['resultCompanyId']);
        for($i=0;$i<count($allSearchResults);$i++)
        {
            $n_arr[] = $allSearchResults[$i];
        }
        for($s=0;$s<count($n_arr);$s++,$k++)
        {
            $countids[$k]=$n_arr[$s]['Company_Id'];
        }
        $_SESSION['resultCompanyId'] = $countids;
         if ($_SESSION['totalResults']) 
              unset($_SESSION['totalResults']);
           $_SESSION['totalResults'] = $total;


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

   if($total>0 &&  $limit!="all"){
   $paginationdiv= '<ul class="pagination">';
        
                    $totalpages=  ceil($total/$limit);
                    $firstpage=1;
                    $lastpage=$totalpages;
                    $prevpage=(( $page-1)>0)?($page-1):1;
                    $nextpage=(($page+1)<$totalpages)?($page+1):$totalpages;
        
                 
     
                    $pages=array();
                    $pages[]=1;
                    $pages[]=$page-2;
                    $pages[]=$page-1;
                    $pages[]=$page;
                    $pages[]=$page+1;
                    $pages[]=$page+2;
                    $pages[]=$totalpages-3;
                    $pages[]=$totalpages-2;
                    $pages[]=$totalpages-1;
                    $pages[]=$totalpages;
                    if($totalpages>3)
                    {
                        $pages[]=2;
                        $pages[]=3;
                        $pages[]=4;
                    }   
                    $pages =  array_unique($pages);
                    sort($pages);
                 if($page<2){
                    $paginationdiv.='<li class="arrow unavailable"><a href="">&laquo;</a></li>';
                 } else {  
                 $paginationdiv.='<li class="arrow unavailable"><a class="postlink" href="home.php?page='.$prevpage.'" >&laquo;</a></li>';
                  }
                  
                
                 
                 
                  
                  for($i=0;$i<count($pages);$i++){ 
                     if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                      $paginationdiv.='<li  class="'.(($pages[$i]==$page)?"current":" ").'"><a class="postlink" href="home.php?page='.$pages[$i].'">'.$pages[$i].'</a></li>';
                     }
                 if(isset($pages[$i+1])){
                        if($pages[$i+1]-$pages[$i]>1){
                          $paginationdiv.='<li  ><a  >&hellip;</a></li>';   
                        }
                    }
                  }
                     
                     if($page<$totalpages){
                    
                 $paginationdiv.='<li class="arrow"><a  class="postlink"  href="home.php?page='.$nextpage.'">&raquo;</a></li>';
                     } else {  
                   $paginationdiv.='<li class="arrow"><a >&raquo;</a></li>';
                     }
              $paginationdiv.='</ul>';   
        
        $template->assign("paginationdiv",$paginationdiv);
      
}
 else {
       $template->assign("paginationdiv","");
}



if($chargewhere!='')
    { $template->display('ajaxhomewithcharge.tpl'); }
else
    { $template->display('ajaxhome.tpl');  }

mysql_close();

?>