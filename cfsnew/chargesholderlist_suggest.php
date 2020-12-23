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
    

    use Aws\S3\S3Client;
    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));
    $bucket = $GLOBALS['bucket'];
    $faq1="FAQAssets/";
    $iterator = $client->getIterator('ListObjects', array(
        'Bucket' => $bucket,
        'Prefix' => $faq1
    ));
    $c1=0;$c2=0;
    $items = $object1 = array();
    $foldername = '';
    $items1 = array();
    $filesarr = array();
    try {
        $valCount = iterator_count($iterator);
    } catch(Exception $e){}
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
        
        if(isset($_REQUEST['answer']['City']) && $_REQUEST['answer']['City']!='' || $_GET['cityid']!=''){
            if($_GET['cityid']!=''){
                //$cityid=$_GET['cityid'];
                $cityid=str_replace("_"," ",$_GET['cityid']);
                $cityid1=str_replace("^","&",$cityid);
                $cityval=$cityid1;
                $cityid=str_replace(",","','",$cityid1);
                $cityiocid=$_GET['cityid'];
            }else{
                //$cityid=implode(",",$_REQUEST['answer']['City']);
                $cityid=implode("','",$_REQUEST['answer']['City']);
                $cityval=$cityiocid=implode(",",$_REQUEST['answer']['City']);
            }
            
            // $citysql="select city_name from city where city_id IN(".$cityid.")";
            
            // if($query=mysql_query($citysql)){
            //     while($myrow=mysql_fetch_array($query))
            //     {
            //        $nameval .="'".$myrow['city_name']."',";
            //     }
                
            // }
           
            //$name=trim($nameval,",");
            
            if($chargewhere != ''){
                $chargewhere .="    and a1.`city` IN(' ".$cityid."')";
            }else{
                $chargewhere .="    a1.`city` IN( '".$cityid."')";
            }
            if($_GET['cityid']!=''){
                // $cityids=explode(",",$_GET['cityid']);
                // $cityarray=$cityids;
                $cityids=str_replace("_"," ",$_GET['cityid']);
                $cityids=str_replace("^","&",$cityids);
                $cityval=$cityids;
                $cityids=explode(",",$cityids);
                $cityarray=$cityids;
            }else{
                $cityarray=$_REQUEST['answer']['City'];
            }
            $cityiocid=str_replace(" ","_",$cityiocid);
            $cityiocid=str_replace("&","^",$cityiocid); 
                $template->assign("cities" , $cityarray);
                $template->assign("cityval" ,$cityval);
                $template->assign("cityid" ,$cityiocid);
               
        }
        //print_r($_REQUEST['answer']['State']);

        if(isset($_REQUEST['answer']['State']) && $_REQUEST['answer']['State']!=''|| $_GET['stateid']!=''){
            if($_GET['stateid']!=''){
               // $stateid=$_GET['stateid'];
                $stateid=str_replace("_"," ",$_GET['stateid']);
                $stateid1=str_replace("^","&",$stateid);
                $stateval=$stateid1;
                $stateid=str_replace(",","','",$stateid1);
                $stateiocid=$_GET['stateid'];
            }else{
                $stateid=implode("','",$_REQUEST['answer']['State']);
                $stateval=$stateiocid=implode(",",$_REQUEST['answer']['State']);
            }
            // $citysql="select State from index_of_charges where state_id IN(".$stateid.")";
            
            // if($query=mysql_query($citysql)){
            //     while($myrow=mysql_fetch_array($query))
            //     {
            //        $statenameval .="'".$myrow['state_name']."',";
            //     }
                
            // }
           
            $statename=trim($statenameval,",");
            
            if($chargewhere != ''){
                $chargewhere .="    and a1.`State` IN( '".$stateid."')";
            }else{
                $chargewhere .="    a1.`State` IN( '".$stateid."')";
            }
                
            if($_GET['stateid']!=''){
                $stateids=str_replace("_"," ",$_GET['stateid']);
                $stateids=str_replace("^","&",$stateids);
                $stateval=$stateids;
                $stateids=explode(",",$stateids);
                $statearray=$stateids;
            }else{
                $statearray=$_REQUEST['answer']['State'];
            }
            $stateiocid=str_replace(" ","_",$stateiocid);
            $stateiocid=str_replace("&","^",$stateiocid);
            //$stateiocid="'".$stateiocid."'";
                $template->assign("states" , $statearray);
                $template->assign("stateval" ,$stateval);
                $template->assign("stateid" ,$stateiocid);
               
        }

    if($valCount > 0){
        foreach($iterator as $object){
        $fileName =  $object['Key'];
        if($object['Size'] == 0){
            $foldername = explode("/", $object['Key']);
        } 
        $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
        $pieces = explode("/", $fileName);
        $pieces = $pieces[ sizeof($pieces) - 1 ];
        $fileNameExt = $pieces;
        $ex_ext = explode(".", $fileName);
        $ext = $ex_ext[count($ex_ext)-1];
        if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
            continue;
        }

        $c1 = $c1 + 1;
        $c2 = $c2 + 1;
        /*$items1[$foldername[sizeof($foldername) - 2]][$pieces] = $signedUrl;*/    
        $items1[$pieces] = $signedUrl;
        array_push($items, array('name'=>$str) );
        }   // foreach
        $result = $c2. " of ". $c1;
    }
    if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { error_log('CFS authadmin userid Empty in Home -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
    if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { error_log('CFS authadmin GroupList Empty in Home -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
    // $SearchResults=$faq->select();

    // $field = $_GET['id'];
    // $chargeholder_name = 'Select count(*) as chargeholders_count from index_of_charges where ID = '.$field;
    // $fetch_chargesholder = mysql_query($chargeholder_name);
    // $chargesholdername = mysql_fetch_array($fetch_chargesholder);
    
    // $chargeholders_count = $chargesholdername[0];
   // $filtered_chargesholdername = $_REQUEST['name'];
   
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
   
    // $filtered_chargesholdername = $filtered_chargesholdername;
    $companyURL = $_GET['name'];
   // $filtered_chargeholder_name = str_replace(' ', '_', $filtered_chargesholdername);
   //$filtered_chargesholdername = str_replace('_', ' ', $filtered_chargesholdername);
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

            $paginationdiv.='<li class="arrow unavailable"><a class="postlink" href="chargesholderlist_suggest.php?page='.$prevpage.'" >&laquo;</a></li>';    
        }     
             
        for($i=0;$i<count($pages);$i++){ 
            
            if($pages[$i] > 0 && $pages[$i] <= $totalpages){
                 $paginationdiv.='<li  class="'.(($pages[$i]==$page)?"current":" ").'"><a class="postlink" href="chargesholderlist_suggest.php?page='.$pages[$i].'">'.$pages[$i].'</a></li>';
            }
            if(isset($pages[$i+1])){
                if($pages[$i+1]-$pages[$i]>1){
                    $paginationdiv.='<li  ><a  >&hellip;</a></li>';   
                }
            }
        }
                 
        if($page<$totalpages){

            $paginationdiv.='<li class="arrow"><a  class="postlink"  href="chargesholderlist_suggest.php?page='.$nextpage.'">&raquo;</a></li>';
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
    if($_REQUEST['chargetodate']!='') {            
        $chargetodate=$_REQUEST['chargetodate'];    
     }
     else{
          $chargetodate = date('Y-m-d');
     }
    $chargefromamount = $_REQUEST['chargefromamount'];
    $chargetoamount = $_REQUEST['chargetoamount'];
 
 }


    //print_r($SearchResults);
    $template->assign("holderhidden" , $_REQUEST['holderhidden']);
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
    $template->display('chargesholderlist_suggest.tpl');
?>
<?php
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
?>
<script>
$('select.multi').multiselect();
$("#City").multiselect({noneSelectedText: 'Select City', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
$("#State").multiselect({noneSelectedText: 'Select State', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
</script>