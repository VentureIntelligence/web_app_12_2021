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
    //$query= "select value from configuration where purpose='initial_count'";
    $query = "SELECT DISTINCT CIN FROM `index_of_charges` ";
    //$query = "SELECT a1.companyName  FROM index_of_charges as a1 group by chargeid ";
                        $count=mysql_query($query);
                        $total_top=mysql_num_rows($count);
                        // $total_top=$total_top1[0];
    if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { error_log('CFS authadmin userid Empty in Home -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
    if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { error_log('CFS authadmin GroupList Empty in Home -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
    $SearchResults=$faq->select();
    $template->assign("searchexport",$SearchExport);
    $template->assign("SearchResults",$SearchResults);
    $template->assign("cfsitem",$items1);
    $template->assign("totalrecord",$total_top);
    $template->assign('pageTitle',"CFS :: Company Search Or Charges Holder");
    $template->assign('pageDescription',"CFS - Company Search Or Charges Holder");
    $template->assign('pageKeyWords',"CFS - Company Search Or Charges Holder");
    $template->assign('userEmail',$_SESSION['UserEmail']);
    $template->display('companyOrChargeholder.tpl');
    // $template->display('index_of_charges.tpl');
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
</script>
<style>
/* .ui-dropdownchecklist{
    display:none;
} */
 button.ui-multiselect.ui-widget.ui-state-default.ui-corner-all{
      margin-bottom:auto;
      width:245px !important;
    }
    .ui-multiselect span.ui-icon {
    float: right;
}
.ui-state-default .ui-icon {
    background-image: url(/images/ui-icons_888888_256x240.png);
}
.ui-multiselect, .ui-multiselect-menu {
    color: #111 !important;
    font-size: 14px !important;
    font-family: calibri !important;
    padding: 2px 0 2px 4px;
    text-align: left;
    background: #fff !important;
    border: 1px solid #A2753A !important;
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -khtml-border-radius: 0 !important;
    border-radius: 0 !important;
        height: 28px;
}
.ui-multiselect-menu {
    display: none;
    padding: 3px;
    position: absolute;
    z-index: 10000;
    text-align: left;
    height:auto;
    width: 245px !important;
}
.ui-multiselect, .ui-multiselect-menu {
    color: #111 !important;
    font-size: 14px !important;
    font-family: calibri !important;
    padding: 2px 0 2px 4px;
    text-align: left;
    background: #fff !important;
    border: 1px solid #A2753A !important;
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -khtml-border-radius: 0 !important;
    border-radius: 0 !important;
}
/* Multi select dropdown styles */

.ui-multiselect,
.ui-multiselect-menu {
    color: #111 !important;
    font-size: 14px !important;
    font-family: calibri !important;
    padding: 2px 0 2px 4px;
    text-align: left;
    background: #fff !important;
    border: 1px solid #A2753A !important;
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -khtml-border-radius: 0 !important;
    border-radius: 0 !important;
}


.ui-multiselect span.ui-icon {
    float: right
}

.ui-multiselect-single .ui-multiselect-checkboxes input {
    position: absolute !important;
    top: auto !important;
    left: -9999px;
}

.ui-multiselect-single .ui-multiselect-checkboxes label {
    padding: 5px !important
}

.ui-multiselect-single .ui-multiselect-checkboxes {
    clear: both !important;
}

.ui-multiselect-checkboxes {
    clear: both !important;
}

.ui-multiselect-header {
    margin-bottom: 3px;
    padding: 3px 0 3px 4px
}

.ui-multiselect-header ul {
    font-size: 0.9em;
}

.ui-multiselect-header ul li {
    float: left;
    padding: 0 10px 0 0
}

.ui-multiselect-header a {
    text-decoration: none
}

.ui-multiselect-header a:hover {
    text-decoration: underline
}

.ui-multiselect-header span.ui-icon {
    float: left
}

.ui-multiselect-header li.ui-multiselect-close {
    float: right;
    text-align: right;
    padding-right: 0
}

.ui-multiselect-menu {
    display: none;
    padding: 3px;
    position: absolute;
    z-index: 10000;
    text-align: left
}

.ui-multiselect-checkboxes {
    position: relative
        /* fixes bug in IE6/7 */
    ;
    overflow-y: scroll
}

.ui-multiselect-checkboxes label {
    cursor: default;
    display: block;
    border: 1px solid transparent;
    padding: 3px 1px
}

.ui-multiselect-checkboxes label input {
    position: relative;
    top: 1px
}

.ui-multiselect-checkboxes li {
    clear: both;
    font-size: 0.9em;
    padding-right: 3px
}

.ui-multiselect-checkboxes li label:hover {
    background: #fff !important;
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -khtml-border-radius: 0 !important;
    border-radius: 0 !important;
}

.ui-multiselect-checkboxes li.ui-multiselect-optgroup-label {
    text-align: center;
    font-weight: bold;
    border-bottom: 1px solid
}

.ui-multiselect-checkboxes li.ui-multiselect-optgroup-label a {
    display: block;
    padding: 3px;
    margin: 1px 0;
    text-decoration: none
}

/* remove label borders in IE6 because IE6 does not support transparency */
* html .ui-multiselect-checkboxes label {
    border: none
}




.ui-autocomplete {
    -moz-border-radius: 0 !important;
    -webkit-border-radius: 0 !important;
    -khtml-border-radius: 0 !important;
    border-radius: 0 !important;
    border: 1px solid #A2753A !important;
    max-width: 232px !important;
    overflow: auto !important;
    max-height: 200px !important;
}

</style>