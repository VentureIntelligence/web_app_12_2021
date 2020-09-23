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

    $field = $_GET['id'];
    $company_name = 'Select SCompanyName as scompany_name, FCompanyName as fcompany_name,Company_Id as id from cprofile where CIN = "'.$field.'"';
    // DATE_FORMAT( LoggedIn, '%Y-%m-%d')
    // echo $company_name;
    //  exit();
    $fetch_company = mysql_query($company_name);
    $fetch_companyname = mysql_fetch_array($fetch_company);
    $filtered_scompanyname = $fetch_companyname[0];
    $filtered_fcompanyname = $fetch_companyname[1];
    $filtered_companyid = $fetch_companyname[2];
    // if($filtered_companyid !="")
    // {
    //     $fieldid=" a1.CIN = a2.CIN and a2.CIN ='".$field."'";
    // }else{
    //     $fieldid="  a1.CIN ='".$field."'";
    // }
    $SearchResults = $plstandard->getchargesholderList($field);
    $SearchCompanyname = $plstandard->getchargesholderListcompany($field);
    $SearchCompany = $SearchCompanyname['companyName'];
    // print_r($SearchResults);

//IOC
 $ioc_companyName = $_GET['ioc_c'];
 if($ioc_companyName == ''){
    $ioc_status = 0;
 }else{
    $ioc_status = 1;
 }

 $ioc_filter_status = $_GET['ioc_fstatus'];
 if($ioc_filter_status != ''){
    $ioc_fstatus = 1;
    $ioc_fchargeaddress = $_REQUEST['chargeaddress']; 
    $ioc_fchargefromdate = $_GET['chargefromdate']; 
    $ioc_fchargetodate = $_GET['chargetodate']; 
    $ioc_fchargefromamount = $_GET['chargefromamount']; 
    $ioc_fchargetoamount = $_GET['chargetoamount']; 
 }else{
    $ioc_fstatus = 0;
 }
 
//  $filtered_chargesholdername = $_REQUEST['name'];
//  $filtered_chargesholdername = str_replace('_', ' ', $filtered_chargesholdername);
if($_REQUEST['holderhidden'] !=""){
    $filtered_chargesholdername = $_REQUEST['holderhidden'];
    $filtered_chargesholdername = "'".$filtered_chargesholdername."'";
    $filtered_chargesholdername = str_replace(", ", "', '", $filtered_chargesholdername);
   }elseif($_REQUEST['holderhiddenval'] !=""){
    $filtered_chargesholdername = $_REQUEST['holderhiddenval'];
   }else{
    $filtered_chargesholdername = $_REQUEST['name'];
   }

    
    //print_r($SearchResults);
    $template->assign("searchexport",$SearchExport);
    $template->assign('SearchResults',$SearchResults);
    $template->assign('Searchcompany',$SearchCompany);
    $template->assign('SCompanyName',$filtered_scompanyname);
    $template->assign('FCompanyName',$filtered_fcompanyname);
    $template->assign('ChargesholderName',$filtered_chargesholdername);
    $template->assign('Companyid',$filtered_companyid);
    $template->assign('CompanyID',$field);
    $template->assign("cfsitem",$items1);
    $template->assign("totalrecord",$total);
    $template->assign("ioc_companyName",$ioc_companyName);
    $template->assign("ioc_status",$ioc_status);
    $template->assign("ioc_fstatus",$ioc_fstatus);
    $template->assign("ioc_fchargeaddress",$ioc_fchargeaddress);
    $template->assign("ioc_fchargefromdate",$ioc_fchargefromdate);
    $template->assign("ioc_fchargetodate",$ioc_fchargetodate);
    $template->assign("ioc_fchargefromamount",$ioc_fchargefromamount);
    $template->assign("ioc_fchargetoamount",$ioc_fchargetoamount);
    $template->assign('pageTitle',"CFS :: Company Search Or Charges Holder");
    $template->assign('pageDescription',"CFS - Company Search Or Charges Holder");
    $template->assign('pageKeyWords',"CFS - Company Search Or Charges Holder");
    $template->assign('userEmail',$_SESSION['UserEmail']);
    $template->display('companylist_suggest.tpl');
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