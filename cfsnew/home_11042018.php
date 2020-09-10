<?php
    if(!isset($_SESSION)){
        session_save_path("/tmp");
        session_start();
    }
    
    include "header.php";
    include "sessauth.php";
    require_once MODULES_DIR."industries.php";
    $industries = new industries();
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
    require_once MODULES_DIR."plstandard.php";
    $plstandard = new plstandard();
    $surveyDB='CFS';
    include("../survey/survey.php");
    require_once MAIN_PATH.APP_NAME."/aws.php";	// load logins

    require_once('aws.phar');

    use Aws\S3\S3Client;
    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));
/* --------------------- End of home.Php code */
if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in home page -'.$_SESSION['username']); }

//if(isset($_POST['refine']) || (isset($_POST['filterData']) && ($_POST['filterData'] == 'yes')) || (isset($_POST['headerSearch']))){
    $where = "";
    $whereCountNew = "";
    $chargewhere = "";
    $acrossallFlag = false;
    if($_POST['oldFinacialDataFlag'] !='display'){
    $current_year = date('y');
    for($i=$current_year;$i>= $current_year-2;$i--){
        $where .= " a.FY = '$i' or ";    
        $chargewhere .= " a.FY = '$i' or ";
        $whereCountNew .= " a.FY = '$i' or ";       
    }
    $where = '('.trim($where,'or ').')';
    $chargewhere = '('.trim($chargewhere,'or ').')';
    $whereCountNew = '('.trim($whereCountNew,'or ').')';
    }
    $template->assign("filterData",'yes');
//}
  /*  if(isset($_POST['refine']) || (isset($_POST['filterData']) && ($_POST['filterData'] == 'yes')) || (isset($_POST['headerSearch'])) || (($_POST['filterData_top'] == 'yes'))){
        $where_top = $where;
        $chargewhere_top = $chargewhere; 
    }else{
        $where_top = "";
        $chargewhere_top = "";  
        $replace_where = $where;
        $replace_chargewhere = $chargewhere;
    }*/
    $where_top = $where;
        $chargewhere_top = $chargewhere; 
        $replace_where = $where;
        $replace_chargewhere = $chargewhere;

        $search_export_value = $_POST['search_export_value'];
        if($search_export_value == ''){
            $search_export_value = ($_GET['searchv']!='')?$_GET['searchv']:'';
        }
      if($search_export_value !=''){
        $ex_search_export_value = explode(',',$search_export_value);
        if(count($ex_search_export_value) > 0){
            $input_where = '';
            for($h=0;$h<count($ex_search_export_value);$h++){
                $txt = trim($ex_search_export_value[$h]);
                if($txt !=''){
                    $input_where .= " b.FCompanyName LIKE "."'%".$txt."%' or b.SCompanyName LIKE "."'%".$txt."%' or ";
                }
            }
            if($input_where !=''){
                $input_where = trim($input_where,' or ');
                if($where !=''){
                    $where .= " and ( $input_where ) ";
                }else{
                    $where = " ( $input_where ) ";                    
                }

                if($whereCountNew !=''){
                    $whereCountNew .= " and ( $input_where ) ";
                }else{
                    $whereCountNew = " ( $input_where ) ";                    
                }
            }
        }
        $template->assign("searchv",$search_export_value);
        $template->assign("searchSubmit",'1');
    }else{
        $template->assign("searchv","");    
        $template->assign("searchSubmit",'');    
    }
   
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
		$where .=  "    and  b.Industry  IN ($getgroup[Industry]) ";
	}else{
		$where .=  "    b.Industry  IN ($getgroup[Industry]) ";
	}

    if($whereCountNew != ''){
        $whereCountNew .=  "    and  b.Industry  IN ($getgroup[Industry]) ";
    }else{
        $whereCountNew .=  "    b.Industry  IN ($getgroup[Industry]) ";
    }
        
}

if($getgroup['Permissions']!=2 && $getgroup['Permissions'] !='')
{
    if($where != ''){
		$where .=  "    and  b.Permissions1  =".$getgroup['Permissions'] ;
	}else{
		$where .=  "    b.Permissions1  =".$getgroup['Permissions'] ;
	}

    if($whereCountNew != ''){
        $whereCountNew .=  "    and  b.Permissions1  =".$getgroup['Permissions'] ;
    }else{
        $whereCountNew .=  "    b.Permissions1  =".$getgroup['Permissions'] ;
    }
}
// start index of charge filter
$chargewhere="";
if(isset($_REQUEST['chargefromdate']) && $_REQUEST['chargefromdate']!='' ){


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
        if($_REQUEST['page']!='' && is_numeric($_REQUEST['page'])) {
        $page=$_REQUEST['page']; 
        unset($_REQUEST['page']);
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

        $order="";
        if($_REQUEST['sortby']=="sortcompanyandfy")
        {
            $order.="FIELD(a.FY,'17') DESC,FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc";
        }
        elseif ($_REQUEST['sortby']=="sortcompany")
        {
            $order.="b.SCompanyName  ".$_REQUEST['sortorder'];
        }
        elseif ($_REQUEST['sortby']=="sortrevenue") {
            $order.="TotalIncome ".$_REQUEST['sortorder'];
        }
        elseif ($_REQUEST['sortby']=="sortebita") {
            $order.="a.EBITDA ".$_REQUEST['sortorder'];
        }
        elseif ($_REQUEST['sortby']=="sortpat") {
            $order.="a.PAT ".$_REQUEST['sortorder'];
        }
        elseif ($_REQUEST['sortby']=="sortdetailed") {
            $order.="a.FY ".$_REQUEST['sortorder'];
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

            if($whereCountNew == ""){
                $whereCountNew .=  "  b.ListingStatus  IN (".$listingin.")";
            }else{
                $whereCountNew .=  " and  b.ListingStatus  IN (".$listingin.")";    
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

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.Permissions1 IN (".$permissionsin.")";
                }else{
                    $whereCountNew .=  " b.Permissions1 IN (".$permissionsin.")";
                } 
        }

        if($_REQUEST['CountingStatus'] == 0 && $_REQUEST['CountingStatus'] != ""){
                if($where != ''){
                    $where .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }else{
                    $where .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }else{
                    $whereCountNew .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
                } 
                //pr($where);
        }elseif($_REQUEST['CountingStatus'] == 1){
                if($where != ''){
                    $where .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }else{
                    $where .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }else{
                    $whereCountNew .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }
        }elseif($_REQUEST['CountingStatus'] == 2){
                if($where != ''){
                    $where .=  " and b.UserStatus = 0";
                }else{
                    $where .=  " b.UserStatus = 0";
                }

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.UserStatus = 0";
                }else{
                    $whereCountNew .=  " b.UserStatus = 0";
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
                    $where .=  " and  b.Industry  = ".$_REQUEST['answer']['Industry'];
                }else{
                    $where .=  "b.Industry  = ".$_REQUEST['answer']['Industry'];
                }

                if($whereCountNew != ''){
                    $whereCountNew .=  " and  b.Industry  = ".$_REQUEST['answer']['Industry'];
                }else{
                    $whereCountNew .=  "b.Industry  = ".$_REQUEST['answer']['Industry'];
                }
        }	

        if($_REQUEST['answer']['Sector'] != ""){
                if($where!=''){
                    $where .=  " and  b.Sector  = ".$_REQUEST['answer']['Sector'];
                }else{
                    $where .=  " b.Sector  = ".$_REQUEST['answer']['Sector'];
                }

                if($whereCountNew!=''){
                    $whereCountNew .=  " and  b.Sector  = ".$_REQUEST['answer']['Sector'];
                }else{
                    $whereCountNew .=  " b.Sector  = ".$_REQUEST['answer']['Sector'];
                }
        }

        if($_REQUEST['answer']['SubSector'] != ""){
                $where .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
                $whereCountNew .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
        }	

        if($where!=''){
                $where .=  " and  b.Industry  != '' and  b.State  != ''";
        }else{
                $where .=  "  b.Industry  != '' and  b.State  != ''";
        }

        if($whereCountNew!=''){
                $whereCountNew .=  " and  b.Industry  != '' and  b.State  != ''";
        }else{
                $whereCountNew .=  "  b.Industry  != '' and  b.State  != ''";
        } 

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

            if($whereCountNew != ''){
                $whereCountNew .=  " and a.ResultType = ".$_REQUEST['ResultType'];
            }else{
                $whereCountNew .=  "a.ResultType =".$_REQUEST['ResultType'];
            }
                   $filters['ResultType']=$_REQUEST['ResultType'];  
        }else{
            if($where != ''){
                $where .=  " and c.ResultType = ".$_REQUEST['ResultType'];
            }else{
                $where .=  "c.ResultType =".$_REQUEST['ResultType'];
            }

            if($whereCountNew != ''){
                $whereCountNew .=  " and c.ResultType = ".$_REQUEST['ResultType'];
            }else{
                $whereCountNew .=  "c.ResultType =".$_REQUEST['ResultType'];
            }
                    $filters['ResultType']=$_REQUEST['ResultType'];  
        }

        /*Financial Search Starts*/

        $end=count($_REQUEST['answer']['SearchFieds'])-1;
        
        for($i=0;$i<count($_REQUEST['answer']['SearchFieds']);$i++){
                //pr($i);
                if($_REQUEST['answer']['SearchFieds'][$i] != ""){
                        $Gtrt = 'Grtr_'.$i;
                        $value=$PL_STNDSEARCHFIELDS[$_REQUEST['answer']['SearchFieds'][$i]];
                        if($_REQUEST['Commonandor'] == "" || $_REQUEST['Commonandor'] == "and"){
                                if($_REQUEST[$Gtrt] != "" && $_REQUEST[$Gtrt] < 100){

                                    $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                    $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                }
                                else if($_REQUEST[$Gtrt] != "" && $_REQUEST[$Gtrt] >= 100)
                                {

                                    $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                    $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                }
                                $Less = 'Less_'.$i;
                                if($_REQUEST[$Less] != ""){
                                        $where .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                        $whereCountNew .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                }
                        }elseif($_REQUEST['Commonandor'] == "or" ){
                                $Gtrt = 'Grtr_'.$i;
                                if($Gtrt=='Grtr_0' && !empty($_REQUEST['Grtr_0'])){
                                        if($i == 0){
                                                //$where .= " and ( a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                                if($_REQUEST[$Gtrt] < 100){

                                                    $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                    $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                }
                                                else if($_REQUEST[$Gtrt] >= 100)
                                                {

                                                    $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                    $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                }
                                        }else{
                                                //$where .= " and  a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                                if($_REQUEST[$Gtrt] < 100){

                                                    $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                    $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                }
                                                else if($_REQUEST[$Gtrt] >= 100)
                                                {

                                                    $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                    $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                }
                                        }
                                }elseif($_REQUEST[$Gtrt] != ""){
                                        //$where .= " or a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                        if($_REQUEST[$Gtrt] < 100){

                                            $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                            $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                        }
                                        else if($_REQUEST[$Gtrt] >= 100)
                                        {

                                            $where .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                            $whereCountNew .= " and (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                        }
                                }

                                $Less = 'Less_'.$i;
                                if($Less=='Less_0' && !empty($_REQUEST['Less_0'])){
                                        //$where .= " or  a.".$value."<".($_REQUEST[$Less]*$crores);
                                         $where .= " and  (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                         $whereCountNew .= " and  (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                }elseif($_REQUEST[$Less] != ""){
                                        //$where .= " or a.".$value."<".($_REQUEST[$Less]*$crores);
                                        $where .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                        $whereCountNew .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
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
        
	if(count($_REQUEST['answer']['Region']) > 0  && $_REQUEST['answer']['Region'] != NULL){
            
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


            if($whereCountNew!=''){
                $whereCountNew .=  " and $regions_where";
            }else{
                $whereCountNew .=  $regions_where;
            }
            $maxFYQuery = "INNER JOIN (
                                SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";

            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName, b.SCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.Sector");
            $group = " b.SCompanyName ";
            $tot_fields = array("a.PLStandard_Id");
            
            //echo "step1"; pr($where);
           /* $allSearchResults = $plstandard->SearchHome($tot_fields,$where,$order,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $total=count($allSearchResults);*/

            $total = $plstandard->SearchHomecount($where,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);		
	}
        
	if(count($_REQUEST['answer']['State']) > 0 && $_REQUEST['answer']['State'] != NULL){
		
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


            if($whereCountNew!=''){
                $whereCountNew .=  " and  $state_where ";
            }else{
                $whereCountNew .=  " $state_where ";
            }

            $maxFYQuery = "INNER JOIN (
                                SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";
                
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Sector");
            $group = " b.SCompanyName ";
            
            //echo "2";
            //echo "<div class='' style='display:none'>case 3</div>";
            /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order,$group);
            $total=count($allSearchResults);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');*/
            //print_r($SearchResults);
            
            $total = $plstandard->SearchHomecount($where,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);
        }	

	if($_REQUEST['answer']['City'] != NULL){
            
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


            if($whereCountNew!=''){
                $whereCountNew .=  " and  $city_where ";
            }else{
                $whereCountNew .=  " $city_where ";
            }

            $maxFYQuery = "INNER JOIN (
                                SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY";
   
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Sector");
            $group = " b.SCompanyName ";
            //echo "3";
            //echo "<div class='' style='display:none'>case 4</div>";
            /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order,$group);
            $total=count($allSearchResults);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);*/
            
            $total = $plstandard->SearchHomecount($where,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);
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

                if($whereCountNew!=''){
                    $whereCountNew .= " and $yr_filter";
                }else{
                    $whereCountNew .= $yr_filter;
                }
            }
            
            
            
            /*
		if($where!=''){
			$where .= " and (b.IncorpYear >= ".$_REQUEST['answer']['YearGrtr']." and b.IncorpYear <= ".$_REQUEST['answer']['YearLess'].")";
		}else{
			$where .= "(b.IncorpYear >= ".$_REQUEST['answer']['YearGrtr']." and b.IncorpYear <= ".$_REQUEST['answer']['YearLess'].")";
		}
                
                if($where!=''){
			$where .=  " and  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}else{
			$where .=  "  a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) ";
		}
                
                
                
		$fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
		$group = " b.SCompanyName ";
		//pr($where);
               // echo "4";
                $allSearchResults = $plstandard->SearchHome($fields,$where,$order,$group);
                $total=count($allSearchResults);
		$SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
		$template->assign("totalrecord",$total);
             
             */
	}
       
        /*Advanced Searches Ends*/

        if($_REQUEST['YOYCAGR'] != ("gAnyOf" || 'gacross' || "CAGR")){

            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector");
            $fields1 = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector");
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
                    $acrossallFlag = true;
                    //$group .= "  b.Company_Id HAVING count(b.Company_Id) > b.FYCount";
                    $group = " a.CId_FK HAVING count(a.CId_FK) = FYValue";
            }else{
                    $group = " b.SCompanyName";
            }
            //$order12 = " ORDER BY b.SCompanyName ASC";
            //$order = " a.FY DESC,b.SCompanyName ASC";
            $order1 = "b.SCompanyName ASC,a.FY DESC";
            $order2="FIELD(a.FY,'17') DESC,FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc";
                   
            $whereTop = trim($where);
            $whereCountNew = trim($whereCountNew);
            $replace_where = trim($replace_where);
            $len = strlen($replace_where);
            $whereTop = substr($whereTop, $len);
            $whereCountNew = substr($whereCountNew, $len);
           // $whereTop = ltrim($whereTop,$replace_where);
            $whereTop = trim($whereTop);
            $whereCountNew = trim($whereCountNew);
            //$whereTop = trim($whereTop,'and');
            $whereTop = substr($whereTop,3);
            $whereTop = ' '.$whereTop.' ';
            $whereCountNew = substr($whereCountNew,3);
            $whereCountNew = ' '.$whereCountNew.' ';

            if($chargewhere!=''){


                $chargewhereTop = trim($chargewhere);
                $replace_where = trim($replace_where);
                //$chargewhereTop = ltrim($chargewhereTop,$replace_where);
                $chargewhereTop = trim($chargewhereTop);
                $chargewhereTop = trim($chargewhereTop,'and');
                $chargewhereTop = ' '.$chargewhereTop.' ';

                $total_top = $plstandard->SearchHome_WithCharges_totcnt($chargewhereTop,$fields,$whereTop,$order2,$group);
                $total = $plstandard->SearchHome_WithCharges_cnt($chargewhere,$fields,$where,$order2,$group);

                $SearchExport = $plstandard->SearchHome_WithChargesExport($chargewhere,$fields,$where,$order2,$group);
                $SearchResults = $plstandard->SearchHome_WithCharges($chargewhere,$fields,$where,$order2,$group,"name",$page,$limit,$client='');


            }
            else{
                if( !$acrossallFlag ) {
                    $total_top = $plstandard->allSearchHomecount($whereCountNew,$group,$maxFYQuery);
                }
                $total = $plstandard->SearchHomecount($where,$group,$acrossallFlag);
                $SearchExport = $plstandard->SearchHomeExport($fields1,$where,$order2,$group);
                $SearchResults = $plstandard->SearchHome($fields,$where,$order2,$group,"name",$page,$limit,$client='');
                //$allSearchResults_top = $plstandard->SearchHome($fields,$whereTop,$order2,$group);
                //$total_top=count($allSearchResults_top);

                //$allSearchResults = $plstandard->SearchHome($fields,$where,$order2,$group);
                //$total=count($allSearchResults);
               //$SearchExport = $plstandard->SearchHomeExport($fields,$where,$order,$group);
            }

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
				
                            $where .= " and c.GrowthYear <=".$_REQUEST[$NumYears];
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
	
            }//For Ends
            $where .= " and c.CId_FK = b.Company_Id AND a.CId_FK = c.CId_FK"; // Original Where
            if($_REQUEST['YOYCAGR']=='gacross'){
                    //$where .= " and  b.FYCount >= ".$_REQUEST['NumYears_0']; // Original Where
                    //$group = " t1.CId_FK HAVING count(t1.CId_FK) = GFY";
                    $group = " t1.SCompanyName";
            }else{
                    $group = " t1.SCompanyName";
            }
        
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.GFYCount AS GFY","b.Permissions1"," b.SCompanyName"," b.Sector");
            $fields2 = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector");
           // $fields2= array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.GFYCount AS GFY","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
            $orderc="FIELD(t1.FY,'17') DESC,FIELD(t1.FY,'16') DESC,FIELD(t1.FY,'15') DESC, t1.FY DESC, t1.SCompanyName asc"; 
                
            if($chargewhere!=''){

                $total = $growthpercentage->SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields,$where,$orderc,$group);
                $SearchExport2 = $growthpercentage->SearchHomeExport1_WithCharges($chargewhere,$fields2,$where,$orderc,$group);
                $growthResults = $growthpercentage->SearchHomeGrowth_WithCharges($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');        
            }
            else{
           
                $total = $growthpercentage->SearchHomeGrowth_cnt($fields2,$where,$orderc,$group);
                $SearchExport2 = $growthpercentage->SearchHomeExport1($fields2,$where,$orderc,$group);
                $growthResults = $growthpercentage->SearchHomeGrowth($fields2,$where,$orderc,$group,"name",$page,$limit,$client='');
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
	
            }//For Ends

            $where .= " and  c.CId_FK = b.Company_Id AND a.CId_FK = c.CId_FK"; // Original Where
            $group = " t1.SCompanyName ";
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector");
            $fields2 = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector");

            $orderc="FIELD(t1.FY,'17') DESC,FIELD(t1.FY,'16') DESC,FIELD(t1.FY,'15') DESC, t1.FY DESC, t1.SCompanyName asc";	

            $whereTop = trim($where);
            $replace_where = trim($replace_where);
            $whereTop = ltrim($whereTop,$replace_where);
            $whereTop = trim($whereTop);
            $whereTop = trim($whereTop,'and');
            $whereTop = ' '.$whereTop.' ';
            if($chargewhere!=''){

                $total = $cagr->SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');
                $cagrResults = $cagr->SearchHomeGrowth_WithCharges($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');
                $SearchExport3 = $cagr->SearchHomeExport1_WithCharges($chargewhere,$fields2,$where,$orderc,$group); 
            }
            else {
                
               $total = $cagr->SearchHomeGrowth_cnt($fields,$where,$orderc,$group);
               $SearchExport3 = $cagr->SearchHomeExport1($fields2,$where,$orderc,$group);
               $cagrResults = $cagr->SearchHomeGrowth($fields,$where,$orderc,$group,"name",$page,$limit,$client='');  
            }
 
            $template->assign("searchexport3",$SearchExport3);
            $template->assign("totalrecord",$total);
            $template->assign("SearchResults",$cagrResults);
        }//CAGR IF Ends
        
        /*Growth Search CAGR Ends*/
        
        if(!empty($total_top)){
          $_SESSION['totalResults'] = $total_top;              
        }else{
          $_SESSION['totalResults'] = $total;              
        }

        if (!isset($_SESSION['totalResults']) || ($_SESSION['totalResults'] == '')){
          $_SESSION['totalResults'] = $total;
        }
        $template->assign("totalrecord_1",$_SESSION['totalResults']);

        /*Year Starts*/
        
	$BYearArry[""] = "Please Select a Year";
	for($i=1980; $i<=2020; $i++){
            
            $BYearArry[$i] .= $i;	
	}
	$template->assign('BYearArry', $BYearArry);
        /*Year Ends*/	

        //Pagination
        
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
        
            if($search_export_value!=''){
                $pagination_search ='searchv='.$search_export_value.'&';  
            }else{
                $pagination_search='';
            }
        
            if($page<2){
                
               $paginationdiv.='<li class="arrow unavailable"><a href="">&laquo;</a></li>';
            } else {  

                $paginationdiv.='<li class="arrow unavailable"><a class="postlink" href="home.php?'.$pagination_search.'page='.$prevpage.'" >&laquo;</a></li>';    
            }     
                 
            for($i=0;$i<count($pages);$i++){ 
                
                if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                     $paginationdiv.='<li  class="'.(($pages[$i]==$page)?"current":" ").'"><a class="postlink" href="home.php?'.$pagination_search.'page='.$pages[$i].'">'.$pages[$i].'</a></li>';
                }
                if(isset($pages[$i+1])){
                    if($pages[$i+1]-$pages[$i]>1){
                        $paginationdiv.='<li  ><a  >&hellip;</a></li>';   
                    }
                }
            }
                     
            if($page<$totalpages){

                $paginationdiv.='<li class="arrow"><a  class="postlink"  href="home.php?'.$pagination_search.'page='.$nextpage.'">&raquo;</a></li>';
            } else {  
                $paginationdiv.='<li class="arrow"><a >&raquo;</a></li>';
            }
        
            $paginationdiv.='</ul>';   
        
            $template->assign("paginationdiv",$paginationdiv);
        }
        else {
            $template->assign("paginationdiv","");
        }
        
       // LEFT  PANEL
        include "leftpanel.php";

        if(isset($_POST['exportenable'])){

            $contents = $plstandard->exportFinacial($_POST['exportid']);

            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=balancesheet.xls");
            header("Pragma: no-cache");
            header("Expires: 0");
            $flag = false; 
            foreach($contents as $row) { 
                if(!$flag) { 
                    // display field/column names as first row 
                    implode("\t", array_keys($row)) . "\r\n"; 
                    $flag = true; 
                } 
                array_walk($row, 'cleanData');
                implode("\t", array_values($row)) . "\r\n"; 
            } 
            exit;
        }

        $template->assign('pageTitle',"CFS :: Company Search");
        $template->assign('pageDescription',"CFS - Company Search");
        $template->assign('pageKeyWords',"CFS - Company Search");

        $template->display('home.tpl');
        
        // Footer
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
            {      
                echo "Error saving file!"; 
            }
        }
        print "\n";
    //set of code ends

