<?php

    if(!isset($_SESSION)){
        session_save_path("/tmp");
        session_start();
    }
    include "header.php";
    include "sessauth.php";
    require_once MODULES_DIR."faq.php";
    $faq = new faq();
    $surveyDB='CFS';
    include("../survey/survey.php");
    require_once MAIN_PATH.APP_NAME."/aws.php"; // load logins
    require_once('aws.phar');
    require_once MODULES_DIR."plstandard.php";
    $plstandard = new plstandard();

    
    
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
        $chargewhere="";
if(isset($_REQUEST['chargefromdate']) && $_REQUEST['chargefromdate']!='' ){


    if($_REQUEST['chargetodate']!='') {            
        $chargetodate=$_REQUEST['chargetodate'];    
     }
     else{
          $chargetodate = date('Y-m-d');
     }


     if($chargewhere != ''){
                    $chargewhere .="    and  (a1.`Date of Charge` BETWEEN "."'".$_REQUEST['chargefromdate']."' AND "."'".$chargetodate."' ) ";
            }else{
                    $chargewhere .="   (a1.`Date of Charge` BETWEEN "."'".$_REQUEST['chargefromdate']."' AND "."'".$chargetodate."' ) ";
            }

  
        $template->assign("chargefromdate" , $_REQUEST['chargefromdate']);
        $template->assign("chargetodate" , $chargetodate);
      
    
}

if(isset($_REQUEST['chargefromamount']) && $_REQUEST['chargefromamount']!=''  ){
    
    $chargefromamount = $_REQUEST['chargefromamount']*10000000;
    
    if($_REQUEST['chargetoamount']!='' && ($_REQUEST['chargefromamount'] <= $_REQUEST['chargetoamount'])){
        
        $chargetoamount = $_REQUEST['chargetoamount']*10000000;

        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(a1.`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }else{
                    $chargewhere .="    ROUND(REPLACE(a1.`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }
           $template->assign("chargetoamount" , $chargetoamount/10000000);
    }
    else{
        
        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(a1.`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }else{
                    $chargewhere .="   ROUND(REPLACE(a1.`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
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
   
    // if($chargewhere != ''){
	// 	$chargewhere .=" and `Charge Holder` IN (".$chargeholder.")";
	// }else{
	// 	$chargewhere .=" `Charge Holder` IN (".$chargeholder.")";
	// }
        $template->assign("chargeholdertest" , $_REQUEST['chargeholdertest']);
       
}

        if(isset($_REQUEST['chargeaddress']) && $_REQUEST['chargeaddress']!=''){
    
            if($chargewhere != ''){
                $chargewhere .="    and a1.`Address` LIKE  "."'%".$_REQUEST['chargeaddress']."%'";
            }else{
                $chargewhere .="    a1.`Address` LIKE "."'%".$_REQUEST['chargeaddress']."%'";
            }
                
                $template->assign("chargeaddress" , $_REQUEST['chargeaddress']);
               
        }
             

        if($_REQUEST['holderhidden'] !=""){
            $filtered_chargesholdername = $_REQUEST['holderhidden'];
            $filtered_chargesholdername = '"'.$filtered_chargesholdername.'"';
            $filtered_chargesholdername = str_replace(',','","', $filtered_chargesholdername);
            $filtered_chargesholdername = str_replace("'","", $filtered_chargesholdername);
           }elseif($_REQUEST['holderhiddenval'] !=""){
            $filtered_chargesholdername = $_REQUEST['holderhiddenval'];
           }else{
            $filtered_chargesholdername = $_REQUEST['name'];
           }
    $companyURL = $_GET['name'];
   // $filtered_chargeholder_name = str_replace(' ', '_', $filtered_chargesholdername);
  // $filtered_chargesholdername = str_replace('_', ' ', $filtered_chargesholdername);
   if($filtered_chargesholdername !=''){
    // $filtered_chargesholdername = str_replace('_', ' ', $filtered_chargesholdername);
     // if($chargewhere != ''){
     //     $chargewhere .="    and a1.`Charge Holder` LIKE  "."'%".$filtered_chargesholdername."%'";
     // }else{
     //     $chargewhere .="    a1.`Charge Holder` LIKE "."'%".$filtered_chargesholdername."%'";
     // }
     if($chargewhere != ''){
         $chargewhere .='    and a1.`Charge Holder` IN  ('.$filtered_chargesholdername.')';
     }else{
         $chargewhere .='    a1.`Charge Holder` IN ('.$filtered_chargesholdername.')';
     }
        
        // $template->assign("chargeaddress" , $_REQUEST['chargeaddress']);
        
 }
 
    if($_REQUEST['sortorder']=='')
    {
       $sortorder="asc";
    }else{
        $sortorder = $_REQUEST['sortorder'];
    }
    if ($_REQUEST['sortby']=="sortcompany")
    {
        $order =" order by a1.companyName  ".$sortorder;
    }
    $SearchResults = $plstandard->getcompanyList($chargewhere,$limit,$page,$order);
    $SearchResults_cnt = $plstandard->getcompanyList_cnt($chargewhere,$limit,$page);
    $total =  count($SearchResults_cnt);
    //print_r($SearchResults);
   
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

            $paginationdiv.='<li class="arrow unavailable"><a class="postlink" href="chargesholderlist_suggest.php?name='.$filtered_chargesholdername.'&'.$pagination_search.'page='.$prevpage.'" >&laquo;</a></li>';    
        }     
             
        for($i=0;$i<count($pages);$i++){ 
            
            if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                 $paginationdiv.='<li  class="'.(($pages[$i]==$page)?"current":" ").'"><a class="postlink" href="chargesholderlist_suggest.php?name='.$filtered_chargesholdername.'&'.$pagination_search.'page='.$pages[$i].'">'.$pages[$i].'</a></li>';
            }
            if(isset($pages[$i+1])){
                if($pages[$i+1]-$pages[$i]>1){
                    $paginationdiv.='<li  ><a  >&hellip;</a></li>';   
                }
            }
        }
                 
        if($page<$totalpages){

            $paginationdiv.='<li class="arrow"><a  class="postlink"  href="chargesholderlist_suggest.php?name='.$filtered_chargesholdername.'&'.$pagination_search.'page='.$nextpage.'">&raquo;</a></li>';
        } else {  
            $paginationdiv.='<li class="arrow"><a >&raquo;</a></li>';
        }
    
        $paginationdiv.='</ul>';   
    
        $template->assign("paginationdiv",$paginationdiv);
    }
    else {
        $template->assign("paginationdiv","");
    }
    
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
    // print_r($SearchResults);

   
    // IOC Filter 
$ioc_filter_status = $_GET['ioc_filter'];
 if($ioc_filter_status == '0'){
    $ioc_fstatus = 0;
 }else{
    
    $ioc_fstatus = '1';
    $ioc_faddress = $_REQUEST['chargeaddress'];
    $chargefromdate = $_REQUEST['chargefromdate'];
    $chargetodate = $_REQUEST['chargetodate'];
    $chargefromamount = $_REQUEST['chargefromamount'];
    $chargetoamount = $_REQUEST['chargetoamount'];
 
 }


    
    $template->assign("sortby" , $_REQUEST['sortby']);
    $template->assign("sortorder" , $_REQUEST['sortorder']);
    $template->assign("curPage" , $page);
    $template->assign("limit" , $limit);
    $template->assign("searchexport",$SearchExport);
    $template->assign('SearchResults',$SearchResults);
    $template->assign('ChargesholderName',$filtered_chargesholdername);
    $template->assign('companyURL',$companyURL);
    $template->assign("ioc_fstatus",$ioc_fstatus);
    $template->assign("ioc_faddress",$ioc_faddress);
    $template->assign("ioc_fchargefromdate",$chargefromdate);
    $template->assign("ioc_fchargetodate",$chargetodate);
    $template->assign("ioc_fchargefromamount",$chargefromamount);
    $template->assign("ioc_fchargetoamount",$chargetoamount);
    $template->assign("cfsitem",$items1);
    $template->assign("totalrecord",$total);
    $template->assign('pageTitle',"CFS :: Company Search Or Charges Holder");
    $template->assign('pageDescription',"CFS - Company Search Or Charges Holder");
    $template->assign('pageKeyWords',"CFS - Company Search Or Charges Holder");
    $template->assign('userEmail',$_SESSION['UserEmail']);
    $template->display('ajaxchargesholderlist_suggest.tpl');
?>
