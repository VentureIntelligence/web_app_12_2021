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
    include_once('conversionarray.php');
    use Aws\S3\S3Client;
    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE)
                    $user_os =  'Windows';
                elseif((strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE) && strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==FALSE)
                    $user_os = 'Android';
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== FALSE) //For Supporting IE 11
                    $user_os =  'Linux';
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE)
                    $user_os = 'IOS';
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE)
                    $user_os = 'IOS';
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== FALSE)
                    $user_os = 'iOS';

              if($user_os=='IOS'){      

                  if(strpos($_SERVER['HTTP_USER_AGENT'], 'FxiOS') !== FALSE)
                      $user_browser = 'Firefox';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== FALSE)
                      $user_browser = 'Chrome';
                  else
                      $user_browser = "Safari";
              }else{

                  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
                      $user_browser =  'IE';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
                      $user_browser =  'IE';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) //For Supporting IE EDGE
                      $user_browser =  'IE';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
                      $user_browser = 'Firefox';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
                      $user_browser = 'Chrome';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
                      $user_browser = "Opera_Mini";
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
                      $user_browser = "Opera";
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
                      $user_browser = "Safari";
              }
/* --------------------- End of home.Php code */


    
if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in home page -'.$_SESSION['username']); }

//if(isset($_POST['refine']) || (isset($_POST['filterData']) && ($_POST['filterData'] == 'yes')) || (isset($_POST['headerSearch']))){
    $where = "";
    $whereCountNew = "";
    $whereHomeCountNew = "";
    $chargewhere = "";
    $previousSortby = '';
    $previousSortOrder = '';
    $filterFlag = false;
    // T975 RATIO Flag for query
    $acrossallRFlag = false;
    $acrossallFlag = false;
    $search_export_value = $_POST['search_export_value'];
    $countflagvalue=$_POST['countflag'];
    $tagsearch = $_POST['tagsearch_auto'];
     $tagandor = $_REQUEST['tagandor'];
     $tagradio = $_REQUEST['tagradio'];
    if($countflagvalue!=''){
        $countflag=$countflagvalue;
    }else{
        $countflag=0;
    }
    if($search_export_value == ''){
        $search_export_value = ($_GET['searchv']!='')?$_GET['searchv']:'';
    }

    if($search_export_value != '' || $countflagvalue == 1){
        $addFYCondition = " and a.FY = aa.MFY ";
    } else {
        $addFYCondition = " and a.FY = aa.MFY";
    }

    $template->assign("tagsearch",$tagsearch);    
    $template->assign("tagandor",$tagandor);  
    $template->assign("tagandor",$tagradio);  

   /* if($_POST['oldFinacialDataFlag'] !='display' && $search_export_value == ''){
        $current_year = date('y');
        for($i=$current_year;$i>= $current_year-2;$i--){
            $where .= " a.FY = '$i' or a.FY LIKE '%$i %' or ";    
            $chargewhere .= " a.FY = '$i' or a.FY LIKE '%$i %' or ";
            $whereCountNew .= " a.FY = '$i' or a.FY LIKE '%$i %' or ";
            $whereHomeCountNew .= " a.FY = '$i' or a.FY LIKE '%$i %' or ";       
        }
        $where = '('.trim($where,'or ').')';
        $chargewhere = '('.trim($chargewhere,'or ').')';
        $whereCountNew = '('.trim($whereCountNew,'or ').')';
        $whereHomeCountNew = '('.trim($where,'or ').')';
    }*/
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

        // $search_export_value = $_POST['search_export_value'];
        // if($search_export_value == ''){
        //     $search_export_value = ($_GET['searchv']!='')?$_GET['searchv']:'';
        // }
      if($search_export_value !=''){
        $ex_search_export_value = explode(',',$search_export_value);
        if(count($ex_search_export_value) > 0){
            $input_where = '';
            for($h=0;$h<count($ex_search_export_value);$h++){
                $txt = trim($ex_search_export_value[$h]);
                if($txt !=''){
                    //$input_where .= " b.FCompanyName LIKE "."'%".$txt."%' or b.SCompanyName LIKE "."'%".$txt."%' or ";
                    $input_where .= " (b.FCompanyName REGEXP "."'^".$txt."' or (b.FCompanyName REGEXP "."'[[:space:]]+".$txt."' and b.FCompanyName REGEXP "."'".$txt."+[[:space:]]')) or 
                                      (b.SCompanyName REGEXP "."'^".$txt."' or (b.SCompanyName REGEXP "."'[[:space:]]+".$txt."' and b.SCompanyName REGEXP "."'".$txt."+[[:space:]]')) or ";
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

                if( $whereHomeCountNew != '' ) {
                    $whereHomeCountNew .= " and ( $input_where ) ";
                } else {
                    $whereHomeCountNew = " ( $input_where ) ";
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

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  "    and  b.Industry  IN ($getgroup[Industry]) ";
    }else{
        $whereHomeCountNew .=  "    b.Industry  IN ($getgroup[Industry]) ";
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

    if($whereHomeCountNew != ''){
        $whereHomeCountNew .=  "    and  b.Permissions1  =".$getgroup['Permissions'] ;
    }else{
        $whereHomeCountNew .=  "    b.Permissions1  =".$getgroup['Permissions'] ;
    }
}
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
        if($_REQUEST['currency']!='' || $_REQUEST['currency']=="INR"){
            $currency=$_REQUEST['currency'];
        unset($_REQUEST['currency']);}
        else{
            $currency="INR";
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
            $_REQUEST['ResultType']="both";
        }

        // if (!$_REQUEST['ResultType'])
        //     $_REQUEST['ResultType']="0";

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
        $template->assign("countflag" , $countflag);
        $template->assign("limit" , $limit);
        $template->assign("currency" , $currency);
        $usergroup1 = $authAdmin->user->elements['GroupList'];
        $fields2 = array("*");
        $where2 = "Group_Id =".$usergroup1;
        $toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
        $template->assign("grouplimit",$toturcount1);
        $template->assign("searchupperlimit",$toturcount1[0][VisitLimit]);
        $template->assign("searchlowerlimit",$toturcount1[0][Used]);
        $template->assign("searchlimit",$toturcount1[0][SubLimit]);
        $template->assign("searchDone",$toturcount1[0][SubCount]);
        //pr($toturcount1[0][SubLimit]);
        //pr($toturcount1[0][SubCount]);

        $template->assign("fdownload",$authAdmin->user->elements['ExDownloadCount']);

        if($_REQUEST['resetfield']=="Sector" ){
            $pos = array_search($_REQUEST['resetfieldindex'], $_REQUEST['answer']['Sector']);
            $_REQUEST['answer']['Sector'][$pos]="";
        }else if($_REQUEST['resetfield']=="Industry" ){
            $pos = array_search($_REQUEST['resetfieldindex'], $_REQUEST['answer']['Industry']);
            $_REQUEST['answer']['Industry'][$pos]="";
            $_REQUEST['answer']['Industry']=array_filter($_REQUEST['answer']['Industry']);
            $where="IndustryId_FK IN( ".$_REQUEST['resetfieldindex'].")";
            $order = "SectorName asc";
            $fields="Sector_Id";
            $Companiesval = $sectors->getSectorslist($where,$order);
            if($_REQUEST['answer']['Sector']!='')
            {
                $result = array_values(array_intersect($_REQUEST['answer']['Sector'], $Companiesval));
                //print_r($Companiesval);
                foreach($result as $r){
                    $pos = array_search($r, $_REQUEST['answer']['Sector']);
                    //echo $pos." ";
                   
                    $_REQUEST['answer']['Sector'][$pos]="";
                }
               
            }
            //$_REQUEST['answer']['Sector']=array_values($_REQUEST['answer']['Sector']);
        }else if($_REQUEST['resetfield']=="SearchFieds" ){
             $_REQUEST['answer']['SearchFieds'][$_REQUEST['resetfieldindex']]="";
             $_REQUEST['Grtr_'.$_REQUEST['resetfieldindex']]="";
             $_REQUEST['Less_'.$_REQUEST['resetfieldindex']]="";
        }
        else if($_REQUEST['resetfield']=="RatioSearchFieds")
        {
            // T975 RATIO BASED FILTER
             $_REQUEST['answer']['RatioSearchFieds'][$_REQUEST['resetfieldindex']]="";
             $_REQUEST['RGrtr_'.$_REQUEST['resetfieldindex']]="";
             $_REQUEST['RLess_'.$_REQUEST['resetfieldindex']]="";
             
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
        $Insert_CProfile2['SearchVisit'] = $visitdate[SearchVisit];

        $Insert_CProfile1['SearchVisit'] = $Insert_CProfile2['SearchVisit'];
        $Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];


        //pr($authAdmin->user->elements['permission']);
        $users->update($Insert_CProfile1);


        //$sum_visit=$users->sum_searchBygroup($authAdmin->user->elements['GroupList']);

        $Insert_CGroup['Group_Id'] = $authAdmin->user->elements['GroupList'];
        //$Insert_CGroup['SubCount'] = $sum_visit[SearchVisit_sum];

        $getFullUsers = $users->sum_userBygroup($authAdmin->user->elements['GroupList']);
        $getFullUsersName = str_replace(",","','",$getFullUsers[users]);
        $getFullUsersName = "'".$getFullUsersName."'";

        $search_visit=$users->sum_searchByUsers($getFullUsersName);
        $Insert_CGroup['SubCount'] = $search_visit[SearchVisit_count];

        $grouplist->update($Insert_CGroup);

        if($_REQUEST['Crores']!=""){
                $crores=$_REQUEST['Crores'];
        }else if($_REQUEST['Million']!=''){
            $crores=$_REQUEST['Million'];
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
                $where .=  " b.ListingStatus  IN (".$listingin.")";
            }else{
                $where .=  "  and   b.ListingStatus  IN (".$listingin.")";	
            }

            if($whereCountNew == ""){
                $whereCountNew .=  " b.ListingStatus  IN (".$listingin.")";
            }else{
                $whereCountNew .=  "  and  b.ListingStatus  IN (".$listingin.")";    
            }

            if($whereHomeCountNew == ""){
                $whereHomeCountNew .=  "   b.ListingStatus  IN (".$listingin.")";
            }else{
                $whereHomeCountNew .=  "  and b.ListingStatus  IN (".$listingin.")";    
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

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }else{
                    $whereCountNew .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
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

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.UserStatus  = ".$_REQUEST['CountingStatus'];
                }else{
                    $whereCountNew .=  " b.UserStatus  = ".$_REQUEST['CountingStatus'];
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

                if($whereCountNew != ''){
                    $whereCountNew .=  " and b.UserStatus = 0";
                }else{
                    $whereCountNew .=  " b.UserStatus = 0";
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
      
      if(count(array_filter($_REQUEST['answer']['Industry']))>0){
        if($_REQUEST['answer']['Industry'] != ""){
            $industry1=$_REQUEST['answer']['Industry'];
            $industry1=array_filter($industry1);
            $industry=  implode(',', $industry1);
            
                if($where != ''){
                    $where .=  " and  b.Industry IN( ".$industry.")";
                }else{
                    $where .=  "b.Industry IN( ".$industry.")";
                }

                if($whereCountNew != ''){
                    $whereCountNew .=  " and  b.Industry IN( ".$industry.")";
                }else{
                    $whereCountNew .=  "b.Industry IN( ".$industry.")";
                }

                if($whereHomeCountNew != ''){
                    $whereHomeCountNew .=  " and  b.Industry IN( ".$industry.")";
                }else{
                    $whereHomeCountNew .=  "b.Industry IN( ".$industry.")";
                }
        }	
    }
        if(isset($_REQUEST['auditorname']) && $_REQUEST['auditorname']!='' ){

            $auditornamearr = explode(',', $_REQUEST['auditorname']);

            foreach($auditornamearr as $ch){
                if($ch != ""){
                    $auditorname.= "'".$ch."',";
                }
            }

            $auditorname = substr($auditorname, 0,-1);
   
            if($where != ''){
                $where .=  " and  b.auditor_name  IN (".$auditorname.")";
            }else{
                $where .=  "b.auditor_name  IN (".$auditorname.")";
            }

            if($whereCountNew != ''){
                $whereCountNew .=  " and  b.auditor_name  IN (".$auditorname.")";
            }else{
                $whereCountNew .=  "b.auditor_name  IN (".$auditorname.")";
            }

            if($whereHomeCountNew != ''){
                $whereHomeCountNew .=  " and  b.auditor_name  IN (".$auditorname.")";
            }else{
                $whereHomeCountNew .=  "b.auditor_name  IN (".$auditorname.")";
            }
            $fliters['auditorname']=$_REQUEST['auditorname']; 
            $template->assign("auditorname" , $_REQUEST['auditorname']);
        }

        if($_REQUEST['answer']['Sector'] != ""){
            
            $sector1=$_REQUEST['answer']['Sector'];
            
            $sector1=array_filter($sector1);
            $sector=  implode(',', $sector1);
            
            if(count($sector1)>0){
                if($where!=''){
                    $where .=  " and  b.Sector  IN (".$sector.")";
                }else{
                    $where .=  " b.Sector  IN (".$sector.")";
                }

                if($whereCountNew!=''){
                    $whereCountNew .=  " and  b.Sector  IN (".$sector.")";
                }else{
                    $whereCountNew .=  " b.Sector  IN (".$sector.")";
                }

                if($whereHomeCountNew!=''){
                    $whereHomeCountNew .=  " and  b.Sector  IN (".$sector.")";
                }else{
                    $whereHomeCountNew .=  " b.Sector  IN (".$sector.")";
                }
            }
        }

        if($_REQUEST['answer']['SubSector'] != ""){
                $where .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
                $whereCountNew .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
                $whereHomeCountNew .=  " and MATCH (b.SubSector) AGAINST ('".$_REQUEST['answer']['SubSector']."')  ";
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

        if($whereHomeCountNew!=''){
            $whereHomeCountNew .=  " and  b.Industry  != '' and  b.State  != ''";
        }else{
            $whereHomeCountNew .=  "  b.Industry  != '' and  b.State  != ''";
        } 

        $balancesheet = 0;

        for($i=0;$i<count($_REQUEST['answer']['SearchFieds']);$i++){
                //pr($i);
                if($_REQUEST['answer']['SearchFieds'][$i] != ""){
                        if($_REQUEST['answer']['SearchFieds'][$i] < 5){
                        }else{
                                $balancesheet++;
                        }

                }

        }
        if($_REQUEST['ResultType'] != "" && $balancesheet==0){
            //if($_REQUEST['YOYCAGR'] == "gAnyOf" || $_REQUEST['YOYCAGR'] == "gacross" || $_REQUEST['YOYCAGR'] == "CAGR" || $search_export_value != ''){
            if($search_export_value != ''){
                if($_REQUEST['ResultType'] != "both"){
                    $havingClause = "HAVING MaxResultType = ".$_REQUEST['ResultType'];
                } else {
                    $havingClause = "";
                }
            } else {
                if($_REQUEST['ResultType'] != "both"){
                    $havingClause = "HAVING MaxResultType = ".$_REQUEST['ResultType'];
                } else {
                    $havingClause = "";
                }
            }
            
            $filters['ResultType']=$_REQUEST['ResultType'];  

        }else{
            if($search_export_value == ''){
                if($where != ''){
                    $where .=  " and bsn.ResultType = '".$_REQUEST['ResultType']."'";
                }else{
                    $where .=  "bsn.ResultType ='".$_REQUEST['ResultType']."'";
                }

                if($whereCountNew != ''){
                    $whereCountNew .=  " and bsn.ResultType = '".$_REQUEST['ResultType']."'";
                }else{
                    $whereCountNew .=  "bsn.ResultType ='".$_REQUEST['ResultType']."'";
                }

                if($whereHomeCountNew != ''){
                    $whereHomeCountNew .=  " and bsn.ResultType = '".$_REQUEST['ResultType']."'";
                }else{
                    $whereHomeCountNew .=  "bsn.ResultType ='".$_REQUEST['ResultType']."'";
                }
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

                                    if($value == "Total Debt"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        
                                    }elseif($value == "Networth"){
                                        
                                        $where .= " and (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereCountNew .= " and (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereHomeCountNew .= " and (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        
                                    }elseif($value == "Capital Employed"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                    }else{
                                        
                                        $where .= " and (a.".$value." >= ".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >= ".($_REQUEST[$Gtrt]*$crores)."))" ;
                                        $whereCountNew .= " and (a.".$value." >= ".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >= ".($_REQUEST[$Gtrt]*$crores)."))" ;
                                        $whereHomeCountNew .= " and (a.".$value." >= ".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >= ".($_REQUEST[$Gtrt]*$crores)."))" ;
                                
                                }
                                }
                                else if($_REQUEST[$Gtrt] != "" && $_REQUEST[$Gtrt] >= 100)
                                {
                                    if($value == "Total Debt"){

                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        
                                    }elseif($value == "Networth"){
                                        
                                        $where .= " and (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereCountNew .= " and (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereHomeCountNew .= " and (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        
                                    }elseif($value == "Capital Employed"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                    }else{
                                        
                                        $where .= " and (a.".$value." >= ".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >= ".($_REQUEST[$Gtrt]*$crores)." ))";
                                        $whereCountNew .= " and (a.".$value." >= ".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >= ".($_REQUEST[$Gtrt]*$crores)." ))";
                                        $whereHomeCountNew .= " and (a.".$value." >= ".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >= ".($_REQUEST[$Gtrt]*$crores)." ))";
                                
                                }
                                }
                                $Less = 'Less_'.$i;
                                if($_REQUEST[$Less] != ""){
                                    
                                        if($value == "Total Debt"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        
                                    }elseif($value == "Networth"){
                                        
                                        $where .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        
                                    }elseif($value == "Capital Employed"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                    }else{
                                        $where .= " and (a.".$value." < ".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                        $whereCountNew .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                        $whereHomeCountNew .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                }
                                }
                        }elseif($_REQUEST['Commonandor'] == "or" ){
                            
                                $Gtrt = 'Grtr_'.$i;
                                if($Gtrt=='Grtr_0' && !empty($_REQUEST['Grtr_0'])){
                                        if($i == 0){
                                                //$where .= " and ( a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                                if($_REQUEST[$Gtrt] < 100){

                                                    if($value == "Total Debt"){
                                        
                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Networth"){

                                                        $where .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Capital Employed"){

                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                    }else{

                                                        $where .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                        $whereCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                        $whereHomeCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                
                                                }
                                                }
                                                else if($_REQUEST[$Gtrt] >= 100)
                                                {

                                                    if($value == "Total Debt"){
                                        
                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Networth"){

                                                        $where .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Capital Employed"){

                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                    }else{
                                                        
                                                        $where .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                        $whereCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                        $whereHomeCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                
                                                }
                                                }
                                        }else{
                                                //$where .= " and  a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                                if($_REQUEST[$Gtrt] < 100){

                                                    if($value == "Total Debt"){
                                        
                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Networth"){

                                                        $where .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Capital Employed"){

                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                    }else{
                                                        $where .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                        $whereCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                        $whereHomeCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                }
                                                }
                                                else if($_REQUEST[$Gtrt] >= 100)
                                                {
                                                    if($value == "Total Debt"){

                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Networth"){

                                                        $where .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and ((bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                                    }elseif($value == "Capital Employed"){

                                                        $where .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                        $whereHomeCountNew .= " and (((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                    }else{
                                                        $where .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                        $whereCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                        $whereHomeCountNew .= " and ((a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                }
                                        }
                                        }
                                }elseif($_REQUEST[$Gtrt] != ""){
                                        //$where .= " or a.".$value.">".($_REQUEST[$Gtrt]*$crores);
                                        if($_REQUEST[$Gtrt] < 100){

                                            if($value == "Total Debt"){
                                        
                                                $where .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereHomeCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                            }elseif($value == "Networth"){

                                                $where .= " or (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereCountNew .= " or (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereHomeCountNew .= " or (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                            }elseif($value == "Capital Employed"){

                                                $where .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereHomeCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                            }else{
                                                $where .= " or (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                $whereCountNew .= " or (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
                                                $whereHomeCountNew .= " or (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)."))" ;
               
                                        }
                                        }
                                        else if($_REQUEST[$Gtrt] >= 100)
                                        {

                                            if($value == "Total Debt"){
                                        
                                                $where .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereHomeCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                            }elseif($value == "Networth"){

                                                $where .= " or (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereCountNew .= " or (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereHomeCountNew .= " or (bsn.TotalFunds >= "  .($_REQUEST[$Gtrt]*$crores).")" ;

                                            }elseif($value == "Capital Employed"){

                                                $where .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                                $whereHomeCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) >= "  .($_REQUEST[$Gtrt]*$crores).")" ;
                                            }else{
                                                $where .= " or (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                $whereCountNew .= " or (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                                $whereHomeCountNew .= " or (a.".$value.">=".($_REQUEST[$Gtrt]*$crores)." or (a.".$value." is null and a.OptnlIncome >=".($_REQUEST[$Gtrt]*$crores)." ))";
                                        }
                                }
                                }

                                $Less = 'Less_'.$i;
                                if($Less=='Less_0' && !empty($_REQUEST['Less_0'])){
                                    
                                    if($value == "Total Debt"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).") " ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        
                                    }elseif($value == "Networth"){
                                        
                                        $where .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        
                                    }elseif($value == "Capital Employed"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                    }else{
                                        //$where .= " or  a.".$value."<".($_REQUEST[$Less]*$crores);
                                         $where .= " and  (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                         $whereCountNew .= " and  (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                         $whereHomeCountNew .= " and  (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                               
                                    }
                                    
                                }elseif($_REQUEST[$Less] != ""){
                                    
                                     if($value == "Total Debt"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        
                                    }elseif($value == "Networth"){
                                        
                                        $where .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and (bsn.TotalFunds < "  .($_REQUEST[$Less]*$crores).")" ;
                                        
                                    }elseif($value == "Capital Employed"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings + bsn.TotalFunds) < "  .($_REQUEST[$Less]*$crores).")" ;
                                    }else{
                                        //$where .= " or a.".$value."<".($_REQUEST[$Less]*$crores);
                                        $where .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                        $whereCountNew .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                        $whereHomeCountNew .= " and (a.".$value."<".($_REQUEST[$Less]*$crores)." or (a.".$value." is null and a.OptnlIncome <".($_REQUEST[$Less]*$crores)."))" ;
                                }
                                
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
        if($_REQUEST['Commonandor'] == "or" ){
            $where .= " )" ;
            $whereCountNew .= " )" ;
            $whereHomeCountNew .= " )" ;
        }
        /*Financial Search Ends*/
        // T975 RADIO BASED QUERY
        include "ratiobasedfilter.php";
        // T975 QUERY FILTER
         /*Tag Search*/
        if($tagsearch !=''){

                if ($_POST['tagsearch'] != '') {
                    if ($_POST['tagsearch_auto'] == '') {
                        $tagsearch = $_POST['tagsearch'];
                    } else {
                        if ($_POST['tagsearch'] != $_POST['tagsearch_auto']) {
                            $tagsearch = $_POST['tagsearch'] . "," . $_POST['tagsearch_auto'];
                        } else {
                            $tagsearch = $_POST['tagsearch'];
                        }
                    }
            
                } else {
                    $tagsearch = $_POST['tagsearch_auto'];
                }
            
                $tagsearcharray = explode(',', $tagsearch);
                $response = array();
                $tag_filter = "";
                $i = 0;
            
                foreach ($tagsearcharray as $tagsearchnames) {
                    $response[$i]['name'] = $tagsearchnames;
                    $response[$i]['id'] = $tagsearchnames;
                    $i++;
                }
            
                if ($response != '') {
                    $tag_response = json_encode($response);
                } else {
                    $tag_response = 'null';
                }
                
                $template->assign("tag_response",$tag_response);

                //echo $tagsearch;
                $filterFlag = true;
                $tags_where = '';
                $tagResult = $plstandard->fetchCIN($tagsearch, $tagandor);
                
                $tags_where .=  "  b.CIN IN($tagResult)";
                /*foreach($_REQUEST['answer']['Region'] as $regions){
                    $regions_where .=  "  b.RegionId_FK = "."'".$regions."' or ";
                }*/
                
                if($where!=''){
                    $where .=  " and $tags_where";
                }else{
                    $where .=  $tags_where;
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
                    $whereCountNew .=  " and $tags_where";
                }else{
                    $whereCountNew .=  $tags_where;
                }

                if($whereHomeCountNew!=''){
                    $whereHomeCountNew .=  " and $tags_where";
                }else{
                    $whereHomeCountNew .=  $tags_where;
                }

                $maxFYQuery = "INNER JOIN (
                                    SELECT CId_FK, max(FY) as MFY,max(ResultType) as MResultType FROM plstandard GROUP BY CId_FK
                                ) as aa
                                ON a.CId_FK = aa.CId_FK and a.ResultType = aa.MResultType $addFYCondition";

                /*$fields = array(" a.CId_FK, a.EBITDA,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName, b.SCompanyName,b.ListingStatus","TotalIncome",  "max(a.ResultType) as MaxResultType" );*/
                $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName, b.SCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.Sector", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt", "bsn.TotalFunds as Networth","(bsn.L_term_borrowings+bsn.S_term_borrowings+bsn.TotalFunds) as Capital_Employed", "max(a.ResultType) as MaxResultType,bsn.Total_assets" );
                if($ratio !=''){
                array_push($fields,$ratio);
                }
                $order ="a.FY desc";
                $group = " b.Company_Id $havingClause";
                $tot_fields = array("a.PLStandard_Id");
                
                //echo "step1"; pr($where);
               /* $allSearchResults = $plstandard->SearchHome($tot_fields,$where,$order,$group);
                $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
                $total=count($allSearchResults);*/

                /*$total = $plstandard->SearchHomecount($where,$group);
                $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
                $template->assign("totalrecord",$total);*/      
        }

        /*Advanced Searches Starts*/
        
	if(count($_REQUEST['answer']['Region']) > 0  && $_REQUEST['answer']['Region'] != NULL){
            $filterFlag = true;
            $regions_where = '';
            foreach($_REQUEST['answer']['Region'] as $regions){
                $regionSql= "select state_id from state where Region='" . $regions . "'";
                $regres = mysql_query( $regionSql ) or die( mysql_error() );
                $regNumRows = mysql_num_rows( $regres );
                if( $regNumRows > 0 ) {
                    while( $regResult = mysql_fetch_array( $regres ) ) {
                        $stateIDArray[] = $regResult[ 'state_id' ];
                    }
                }
            }
            $stateIDString = implode(",", array_unique( $stateIDArray ) );
            $regions_where .=  "  b.State IN($stateIDString) or ";
            /*foreach($_REQUEST['answer']['Region'] as $regions){
                $regions_where .=  "  b.RegionId_FK = "."'".$regions."' or ";
            }*/
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

            if($whereHomeCountNew!=''){
                $whereHomeCountNew .=  " and $regions_where";
            }else{
                $whereHomeCountNew .=  $regions_where;
            }

            $maxFYQuery = "INNER JOIN (
                                SELECT CId_FK, max(FY) as MFY,max(ResultType) as MResultType FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK and a.ResultType = aa.MResultType $addFYCondition";

            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName, b.SCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.Sector", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt", "bsn.TotalFunds as Networth","(bsn.L_term_borrowings+bsn.S_term_borrowings+bsn.TotalFunds) as Capital_Employed", "max(a.ResultType) as MaxResultType,bsn.Total_assets" );
            if($ratio !=''){
                array_push($fields,$ratio);
            }
            $order ="a.FY desc";
            $group = " b.Company_Id $havingClause";
            $tot_fields = array("a.PLStandard_Id");
            
            //echo "step1"; pr($where);
           /* $allSearchResults = $plstandard->SearchHome($tot_fields,$where,$order,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $total=count($allSearchResults);*/

            /*$total = $plstandard->SearchHomecount($where,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);*/		
	}
        
	if(count($_REQUEST['answer']['State']) > 0 && $_REQUEST['answer']['State'] != NULL){
            $filterFlag = true;
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

            if($whereHomeCountNew!=''){
                $whereHomeCountNew .=  " and  $state_where ";
            }else{
                $whereHomeCountNew .=  " $state_where ";
            }

            $maxFYQuery = "INNER JOIN (
                                SELECT CId_FK, max(FY) as MFY,max(ResultType) as MResultType FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK and a.ResultType = aa.MResultType $addFYCondition";
                
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Sector", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt", "bsn.TotalFunds as Networth","(bsn.L_term_borrowings+bsn.S_term_borrowings+bsn.TotalFunds) as Capital_Employed", "max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields,$ratio);
                }
            $order ="a.FY desc";
            $group = " b.Company_Id $havingClause";
            
            //echo "2";
            //echo "<div class='' style='display:none'>case 3</div>";
            /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order,$group);
            $total=count($allSearchResults);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');*/
            //print_r($SearchResults);
            
            /*$total = $plstandard->SearchHomecount($where,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);*/
        }	

	if($_REQUEST['answer']['City'] != NULL){
            $filterFlag = true;
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

            if($whereHomeCountNew!=''){
                $whereHomeCountNew .=  " and  $city_where ";
            }else{
                $whereHomeCountNew .=  " $city_where ";
            }

            if($whereCountNew!=''){
                $whereCountNew .=  " and  $city_where ";
            }else{
                $whereCountNew .=  " $city_where ";
            }

            $maxFYQuery = "INNER JOIN (
                                SELECT CId_FK, max(FY) as MFY,max(ResultType) as MResultType FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK and a.ResultType = aa.MResultType $addFYCondition";
   
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, b.Company_Id, b.FCompanyName,b.ListingStatus","TotalIncome","b.Permissions1"," b.SCompanyName"," b.Sector", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt", "bsn.TotalFunds as Networth","(bsn.L_term_borrowings+bsn.S_term_borrowings+bsn.TotalFunds) as Capital_Employed", "max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields,$ratio);
                }
            $order ="a.FY desc";
            $group = " b.Company_Id $havingClause";
            //echo "3";
            //echo "<div class='' style='display:none'>case 4</div>";
            /*$allSearchResults = $plstandard->SearchHome($fields,$where,$order,$group);
            $total=count($allSearchResults);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
            $template->assign("totalrecord",$total);*/
            
            /*$total = $plstandard->SearchHomecount($where,$group);
            $SearchResults = $plstandard->SearchHome($fields,$where,$order,$group,"name",$page,$limit,$client='');
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

                if($whereCountNew!=''){
                    $whereCountNew .= " and $yr_filter";
                }else{
                    $whereCountNew .= $yr_filter;
                }

                if($whereHomeCountNew!=''){
                    $whereHomeCountNew .= " and $yr_filter";
                }else{
                    $whereHomeCountNew .= $yr_filter;
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

    if( $filterFlag && $chargewhere == '' ) {
        $total = $plstandard->SearchHomecount($whereHomeCountNew,$group,$maxFYQuery,$acrossFlag,$ratio,$maxFYQueryratio);
        $template->assign("totalrecord",$total);
        $SearchResults = $plstandard->SearchHomeOpt($fields,$whereHomeCountNew,$order,$group,"name",$page,$limit,$client='',$maxFYQuery,$ratio,$maxFYQueryratio);
    }
       
        /*Advanced Searches Ends*/

        if($_REQUEST['YOYCAGR'] != ("gAnyOf" || 'gacross' || "CAGR")){

            /*$fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, max(a.ResultType), b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector", "b.CIN", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt", "bsn.TotalFunds as Networth","(bsn.L_term_borrowings+bsn.S_term_borrowings+bsn.TotalFunds) as Capital_Employed", "max(a.ResultType) as MaxResultType");*/
            $fields = array(" a.CId_FK, a.OptnlIncome,a.EBITDA,a.PAT ,max(a.FY) as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName", "b.CIN", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt",  "max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields,$ratio);
                }
            $fields1 = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, max(a.ResultType), b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector", "b.CIN", "(bsn.L_term_borrowings+bsn.S_term_borrowings) as Total_Debt", "bsn.TotalFunds as Networth","(bsn.L_term_borrowings+bsn.S_term_borrowings+bsn.TotalFunds) as Capital_Employed", "max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields1,$ratio);
                }
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
                                SELECT CId_FK, max(FY) as MFY,max(ResultType) as MResultType FROM plstandard GROUP BY CId_FK
                            ) as aa
                            ON a.CId_FK = aa.CId_FK and a.ResultType = aa.MResultType $addFYCondition";

            if($_REQUEST['arcossall']=='across'){
                    $acrossallFlag = true;
                    //$group .= "  b.Company_Id HAVING count(b.Company_Id) > b.FYCount";
                    if($havingClause != ''){
                        $group = " a.CId_FK $havingClause and count(a.CId_FK) = FYValue ";
                    }else {
                        $group = " a.CId_FK HAVING count(a.CId_FK) = FYValue ";
                    }
            }else{
                    $group = " b.Company_Id $havingClause";
            }

            // T975 Ratio based - filter for across ratio
            if($_REQUEST['arcossallr']=='across'){
                    $acrossallRFlag = true;
                    if($havingClause != ''){
                        $group = " a.CId_FK $havingClause and count(a.CId_FK) = FYValue ";
                    }else {
                        $group = " a.CId_FK HAVING count(a.CId_FK) = FYValue ";
                    }
            }else{
                    $group = " b.Company_Id $havingClause";
            }
            // End

            //$order12 = " ORDER BY b.SCompanyName ASC";
            //$order = " a.FY DESC,b.SCompanyName ASC";
            $order1 = "b.SCompanyName ASC,a.FY DESC";
            //$order2 = "FIELD(a.FY,'17') DESC, FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc";
            $order2 = "LEFT(max(a.FY),2) DESC, trim(b.SCompanyName) REGEXP '^[a-z]' DESC, trim(b.SCompanyName) ASC";

            if( $_REQUEST[ 'sortby' ] == "sortcompany" ) {
                //$order2 = "b.SCompanyName  ".$_REQUEST[ 'sortorder' ];
                $order2 = "trim(b.SCompanyName) REGEXP '^[a-z]' DESC, trim(b.SCompanyName) ".$_REQUEST[ 'sortorder' ];
            } else if( $_REQUEST[ 'sortby' ] == "sortrevenue" ) {
                $order2 = "TotalIncome ".$_REQUEST[ 'sortorder' ];
            } else if( $_REQUEST[ 'sortby' ] == "sortebita" ) {
                $order2 = "a.EBITDA ".$_REQUEST[ 'sortorder' ];
            } else if( $_REQUEST[ 'sortby' ] == "sortpat" ) {
                $order2 = "a.PAT ".$_REQUEST[ 'sortorder' ];
            } else if( $_REQUEST[ 'sortby' ] == "sortdetailed" ) {
                //$order2 = "a.FY ".$_REQUEST[ 'sortorder' ];
                $order2 = "LEFT(max(a.FY),2) ".$_REQUEST[ 'sortorder' ].", trim(b.SCompanyName) REGEXP '^[a-z]' DESC, trim(b.SCompanyName) ASC";
            }
                   
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
                if( !$filterFlag ) {
                    $total_top = $plstandard->SearchHome_WithCharges_totcnt($chargewhereTop,$fields,$whereTop,$order2,$group,$maxFYQuery,$ratio,$maxFYQueryratio);
                }
                $total = $plstandard->SearchHome_WithCharges_cnt($chargewhere,$fields,$where,$order2,$group,$maxFYQuery,$ratio,$maxFYQueryratio);
                $SearchExport = $plstandard->SearchHome_WithChargesExport($chargewhere,$fields,$where,$order2,$group);
                $SearchResults = $plstandard->SearchHome_WithChargesOpt($chargewhere,$fields,$whereHomeCountNew,$order2,$group,"name",$page,$limit,$client='',$maxFYQuery,$ratio,$maxFYQueryratio);
                /*$total_top = $plstandard->SearchHome_WithCharges_totcnt($chargewhereTop,$fields,$whereTop,$order2,$group);
                $total = $plstandard->SearchHome_WithCharges_cnt($chargewhere,$fields,$where,$order2,$group);

                $SearchExport = $plstandard->SearchHome_WithChargesExport($chargewhere,$fields,$where,$order2,$group);
                $SearchResults = $plstandard->SearchHome_WithCharges($chargewhere,$fields,$where,$order2,$group,"name",$page,$limit,$client='');*/


            }
            else{
                
                

                if( !$filterFlag ) {
                    // T975 RATIO BASED
                    if( !$acrossallFlag || !$acrossallRFlag ) {

                         if(($countflag==''||$countflag==0)&& $search_export_value=='' && ($getgroup['Industry'] == '' || count(explode(',', $getgroup['Industry'])) == 25) && $industry=='' ){
                        $query= "select value from configuration where purpose='initial_count'";
                        $count=mysql_query($query);
                        $total_top1=mysql_fetch_row($count);
                        $total_top=$total_top1[0];
                        }else{
                            $total_top = $plstandard->allSearchHomecount($whereCountNew,$group,$maxFYQuery,$ratio,$maxFYQueryratio);
                        }
                       // $total_top = $plstandard->allSearchHomecount($whereCountNew,$group,$maxFYQuery);
                    }
                    if(($countflag==''||$countflag==0)&& $search_export_value=='' && ($getgroup['Industry'] == '' || count(explode(',', $getgroup['Industry'])) == 25) && $industry==''){
                        $query= "select value from configuration where purpose='initial_count'";
                        $count=mysql_query($query);
                        $total=mysql_fetch_row($count);
                        $total=$total[0];
                        }else{
                            // T975 Ratio based
                            if(!$acrossallRFlag){
                                $total = $plstandard->SearchHomecount($whereHomeCountNew,$group,$maxFYQuery,$acrossallFlag,$ratio,$maxFYQueryratio);
                            }else{
                                $total = $plstandard->SearchHomecount($whereHomeCountNew,$group,$maxFYQuery,$acrossallRFlag,$ratio,$maxFYQueryratio);
                            }
                        }

                    $SearchResults = $plstandard->SearchHomeOpt($fields,$whereHomeCountNew,$order2,$group,"name",$page,$limit,$client='',$maxFYQuery,$ratio,$maxFYQueryratio);
                }
                $SearchExport = $plstandard->SearchHomeExportNew($fields1,$whereHomeCountNew,$order2,$group,'','','','',$maxFYQuery,$ratio,$maxFYQueryratio);
                
                if($total > 0 && $search_export_value!=''){
                    //echo "dddddddddddddddddddd 3";
                    if($_SERVER["HTTP_REFERER"]!=''){
                        
                        $search_link = $_SERVER["HTTP_REFERER"];
                    }else{

                        $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    }
                    $searchdate=date('Y-m-d');
                    $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['firstname']." ".$_SESSION['lastname']."','".$search_export_value."',1,0,1,'".$search_date."','".$search_link."')";       
                    $searchoperation = $plstandard->search_operation($search_query);
                }else{
                    if($search_export_value!=''){
                        
                        if($_SERVER["HTTP_REFERER"]!=''){
                        
                            $search_link = $_SERVER["HTTP_REFERER"];
                        }else{

                            $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                        }
                        date_default_timezone_set('Asia/Calcutta');
                        $search_date=date('Y-m-d H:i:s');
                        $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['firstname']." ".$_SESSION['lastname']."','".$search_export_value."',0,0,1,'".$search_date."','".$search_link."')";       
                        $searchoperation = $plstandard->search_operation($search_query);
                    }
                }
                /*$total = $plstandard->SearchHomecount($where,$group,$acrossallFlag);
                $SearchExport = $plstandard->SearchHomeExport($fields1,$where,$order2,$group);
                $SearchResults = $plstandard->SearchHome($fields,$where,$order2,$group,"name",$page,$limit,$client='');*/
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
                            $whereHomeCountNew .= " and c.GrowthYear <=".$_REQUEST[$NumYears];
			}
                    }elseif($_REQUEST['growthandor'] == "or" ){
                        
                        $GrothPerc = 'GrothPerc_'.$j;
                        if($GrothPerc=='GrothPerc_0' && !empty($_REQUEST['GrothPerc_0'])){
                            if($j == 0){
                                $where .= " and ( c.".$value.">".($_REQUEST[$GrothPerc]);
                                $whereHomeCountNew .= " and ( c.".$value.">".($_REQUEST[$GrothPerc]);
                            }else{
                                $where .= " and  c.".$value.">".($_REQUEST[$GrothPerc]);
                                $whereHomeCountNew .= " and  c.".$value.">".($_REQUEST[$GrothPerc]);
                            }
                        }elseif($_REQUEST[$GrothPerc] != ""){
                            $where .= " or c.".$value.">".($_REQUEST[$GrothPerc]);
                            $whereHomeCountNew .= " or c.".$value.">".($_REQUEST[$GrothPerc]);
                        }
			$NumYears = 'NumYears_'.$j;
			if($NumYears=='NumYears_0' && !empty($_REQUEST['NumYears_0'])){
                            $where .= " or c.GrowthYear <=".($_REQUEST[$NumYears]);
                            $whereHomeCountNew .= " or c.GrowthYear <=".($_REQUEST[$NumYears]);
                        }elseif($_REQUEST[$NumYears] != ""){
                            $where .= " or c.GrowthYear <=".($_REQUEST[$NumYears]);
                            $whereHomeCountNew .= " or c.GrowthYear <=".($_REQUEST[$NumYears]);
			}
			$end1--;
			if($end1 == 0){
                            
                            $where .= " )";
                            $whereHomeCountNew .= " )";
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
            $whereHomeCountNew .= " and c.CId_FK = b.Company_Id AND a.CId_FK = c.CId_FK";
            if($_REQUEST['YOYCAGR']=='gacross'){
                    //$where .= " and  b.FYCount >= ".$_REQUEST['NumYears_0']; // Original Where
                    //$group = " t1.CId_FK HAVING count(t1.CId_FK) = GFY";
                    $group = " t1.Company_Id $havingClause";
            }else{
                    $group = " t1.Company_Id $havingClause";
            }
        
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, max(a.ResultType),b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.GFYCount AS GFY","b.Permissions1"," b.SCompanyName"," b.Sector, max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields,$ratio);
                }
            $fields2 = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, max(a.ResultType), b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector, max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields2,$ratio);
                }
           // $fields2= array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType,b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.GFYCount AS GFY","b.Permissions1"," b.SCompanyName"," b.Industry"," b.Sector");
            $orderc="FIELD(t1.FY,'17') DESC,FIELD(t1.FY,'16') DESC,FIELD(t1.FY,'15') DESC, t1.FY DESC, t1.SCompanyName asc"; 
                
            if($chargewhere!=''){
               // echo "dddddddddddddddddddd 4";
                $allgrowthResults = $growthpercentage->SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields,$where,$orderc,$group);
                $total=$allgrowthResults[0]['count'];
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
                            $whereHomeCountNew .= " and c.".$value.">".($_REQUEST[$GrothPerc]);
			}
                        
			$NumYears = 'NumYears_'.$j;
			if($_REQUEST[$NumYears] != ""){
                            $where .= " and c.CAGRYear=".($_REQUEST[$NumYears]);
                            $whereHomeCountNew .= " and c.CAGRYear=".($_REQUEST[$NumYears]);
			}
                    }elseif($_REQUEST['growthandor'] == "or" ){
                        
			$GrothPerc = 'GrothPerc_'.$j;
			if($GrothPerc=='GrothPerc_0' && !empty($_REQUEST['GrothPerc_0'])){
                            if($j == 0){
                                $where .= " and ( c.".$value.">".($_REQUEST[$GrothPerc]);
                                $whereHomeCountNew .= " and ( c.".$value.">".($_REQUEST[$GrothPerc]);
                            }else{
                                $where .= " and  c.".$value.">".($_REQUEST[$GrothPerc]);
                                $whereHomeCountNew .= " and  c.".$value.">".($_REQUEST[$GrothPerc]);
                            }
			}elseif($_REQUEST[$GrothPerc] != ""){
                            $where .= " or c.".$value.">".($_REQUEST[$GrothPerc]);
                            $whereHomeCountNew .= " or c.".$value.">".($_REQUEST[$GrothPerc]);
			}
                        
			$NumYears = 'NumYears_'.$j;
			if($NumYears=='NumYears_0' && !empty($_REQUEST['NumYears_0'])){
                            $where .= " or c.CAGRYear <=".($_REQUEST[$NumYears]);
                            $whereHomeCountNew .= " or c.CAGRYear <=".($_REQUEST[$NumYears]);
			}elseif($_REQUEST[$NumYears] != ""){
                            $where .= " or c.CAGRYear <=".($_REQUEST[$NumYears]);
                            $whereHomeCountNew .= " or c.CAGRYear <=".($_REQUEST[$NumYears]);
			}
			$end2--;
			if($end2 == 0){
                            $where .= " )";
                            $whereHomeCountNew .= " )";
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
            $whereHomeCountNew .= " and  c.CId_FK = b.Company_Id AND a.CId_FK = c.CId_FK"; // Original Where
            $group = " t1.Company_Id $havingClause";
            $fields = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, max(a.ResultType),b.CIN, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector, max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields,$ratio);
                }
            $fields2 = array("a.PLStandard_Id, a.CId_FK, b.Industry,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,max(a.FY) as FY, max(a.ResultType),b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome as TotalIncome","b.FYCount AS FYValue","b.Permissions1"," b.SCompanyName"," b.Sector, max(a.ResultType) as MaxResultType,bsn.Total_assets");
            if($ratio !=''){
                array_push($fields2,$ratio);
                }
            $orderc="FIELD(t1.FY,'17') DESC,FIELD(t1.FY,'16') DESC,FIELD(t1.FY,'15') DESC, t1.FY DESC, t1.SCompanyName asc";	

            $whereTop = trim($where);
            $replace_where = trim($replace_where);
            $whereTop = ltrim($whereTop,$replace_where);
            $whereTop = trim($whereTop);
            $whereTop = trim($whereTop,'and');
            $whereTop = ' '.$whereTop.' ';
            if($chargewhere!=''){
                $allcagrResults = $cagr->SearchHomeGrowth_WithCharges_cnt($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');
                $total=$allcagrResults[0]['count'];
                $cagrResults = $cagr->SearchHomeGrowth_WithCharges($chargewhere,$fields,$where,$orderc,$group,"name",$page,$limit,$client='');
                $SearchExport3 = $cagr->SearchHomeExport1_WithCharges($chargewhere,$fields2,$where,$orderc,$group); 
            }
            else {
               /*$total = $cagr->SearchHomeGrowth_cnt($fields,$where,$orderc,$group);
               $SearchExport3 = $cagr->SearchHomeExport1($fields2,$where,$orderc,$group);
               $cagrResults = $cagr->SearchHomeGrowth($fields,$where,$orderc,$group,"name",$page,$limit,$client='');*/
                $total = $cagr->SearchHomeGrowth_cnt($fields,$whereHomeCountNew,$orderc,$group);
                $SearchExport3 = $cagr->SearchHomeExport1($fields2,$where,$orderc,$group);
                $cagrResults = $cagr->SearchHomeGrowthOpt($fields,$whereHomeCountNew,$orderc,$group,"name",$page,$limit,$client='');  
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
        $template->assign('userEmail',$_SESSION['UserEmail']);
        $template->assign('user_browser',$user_browser);
        $template->assign('yearcurrency',$yearcurrency);
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

