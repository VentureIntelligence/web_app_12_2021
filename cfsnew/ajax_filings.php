<?php 
include "header.php";
include "sessauth.php";
require_once MAIN_PATH.APP_NAME."/aws.php"; // load logins
require_once('aws.phar');

require_once('aws.phar');
use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => $GLOBALS['key'],
    'secret' => $GLOBALS['secret']
));

$bucket = $GLOBALS['bucket'];

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Prefix' => $GLOBALS['root'].$_POST['cname']
));

$c1=$c2=0;
$items = $object1 = array();

//$valCount = count(iterator_to_array($iterator));
try{
    
    $valCount = iterator_count($iterator);
}catch(Exception $e){}

if($valCount > 0)
{
    //Echo '<OL>';
    foreach ($iterator as $object) {
        $fileName =  $object['Key'];
    // Get a pre-signed URL for an Amazon S3 object
    $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
    // > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]

    $pieces = explode("/", $fileName);
    $pieces = $pieces[ sizeof($pieces) - 1 ];

    //foreach ($pieces as $it)
    //  echo $it ."<br>";
        
    $fileNameExt = $pieces;
    $ex_ext = explode(".", $fileNameExt);
        $ext = $ex_ext[count($ex_ext)-1];
        $find_year1 = $ex_ext[count($ex_ext)-2];
       // $find_year = substr($find_year1, -4);
        $find_first_letter = substr($find_year1, 0, 6);
        $object['filename'] = $fileNameExt; 
        $find_first_letter = strtolower(trim($find_first_letter));
        if($find_first_letter == 'annual' || $find_first_letter == 'anual'){
            $string = "/\d{4,4}/";

            $paragraph1 = $fileNameExt;

            if (preg_match_all($string, $paragraph1, $matches1)) {
              //echo count($matches[0])  // Total size

                $find_year = $matches1[0][ count($matches1[0]) -1 ];    // get match from Right
            }
            $object['f_year'] = $find_year; 
        }else{
            $object['f_year'] = '';             
        }
        
        
    // ----------------------------------------------
    // detect date pattern from filename

    $string = "/\d{6,8}/";

    $paragraph = $fileNameExt;

    if (preg_match_all($string, $paragraph, $matches)) {
      //echo count($matches[0])  // Total size

    $dateFileName = $matches[0][ count($matches[0]) -1 ];   // get match from Right
    //echo $dateFileName .'<br>';

    $d = substr($dateFileName, 0, 2);
    $m = substr($dateFileName, 2, 2);
        if(strlen($dateFileName) == 6){
            $y = substr($dateFileName, 4, 2);
        }else{
            $y = substr($dateFileName, 4, 4);            
        }
        
        if(strlen($y) == 4 ){
            $y = $y;
        }else if( intval($y) <30){
            $y = (2000+ intval($y));
        }
    else{
            $y = (1900+ intval($y));
        }
        $file_date = $y.'-'.$m.'-'.$d;
        }
        if($y !='' && $m !='' && $d !=''){
            $object['form_date'] = $file_date;
        }else{
            $object['form_date'] = '';            
        }
        $object1[] = $object;
    }   // foreach
    sort($object1);
    foreach ($object1 as $key1 => $row) {
        $f_year[$key1]  = $row['f_year'];
        $form_date[$key1] = $row['form_date'];
        $filename[$key1] = $row['filename'];
    }

array_multisort($f_year, SORT_DESC,$form_date, SORT_DESC, $filename, SORT_ASC,  $object1);
//echo "<pre>";print_r($object1);echo "</pre>";

foreach($object1 as $object){
    //echo $object['Key'] . "<br>";
    $fileName =  $object['Key'];
    
            // Get a pre-signed URL for an Amazon S3 object
    $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
    // > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]
           
    $pieces = explode("/", $fileName);
    $pieces = $pieces[ sizeof($pieces) - 1 ];

    $fileNameExt = $pieces;
    //$ext = ".pdf";
        
    $ex_ext = explode(".", $fileName);
        $ext = $ex_ext[count($ex_ext)-1];

    // ----------------------------------
    // test if the word ends with '.pdf'
    if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
        //echo "<BR>EXT";
        continue;
        }
    // ----------------------------------

    $c1 = $c1 + 1;

    // ----------------------------------------------
    // detect date pattern from filename

    /*$string = "/\d{6,8}/";

    $paragraph = $fileNameExt;

    if (preg_match_all($string, $paragraph, $matches)) {
      //echo count($matches[0])  // Total size

    $dateFileName = $matches[0][ count($matches[0]) -1 ];   // get match from Right
    //echo $dateFileName .'<br>';

    $d = substr($dateFileName, 0, 2);
    $m = substr($dateFileName, 2, 2);
        if(strlen($dateFileName) == 6){
    $y = substr($dateFileName, 4, 2);
        }else{
            $y = substr($dateFileName, 4, 4);            
        }

        if(strlen($y) == 4 ){
            $y = $y;
        }else if( intval($y) <30){
            $y = (2000+ intval($y));
        }
    else{
            $y = (1900+ intval($y));
        }
        $file_date = $d.'-'.$m.'-'.$y;
        if($y !='' && $m !='' && $d !=''){
            $uploaddate = $file_date;
        }else{
            $uploaddate = '';            
        }
    //print_r( date_parse_from_format("jnY", $d. $m. $y) );
    $dateFileName= date_parse_from_format("jnY", $d. $m. $y);

    //print_r($dateFileName);

    // if date out of range

    if ($_POST && isset($_POST["Month1"]))
        if($dateFileName < $dateFrom || $dateFileName > $dateTo)
            {
            //echo "<BR>SKIPPED" . $dateFrom ."  " .$dateFrom;
            continue;
            }

    } // end of match*/
        if($object['form_date'] !=''){
            $uploaddate = date('d-m-Y',strtotime($object['form_date']));
        }else{
            $uploaddate = '';
        }
    // ----------------------------------------------

    $c2 = $c2 + 1;

    $str = "<li> <a href='". $signedUrl ."' target='_blank' >".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'] ."</li><BR>";
    //echo $str;

    $str = "<a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'];
    //array_push($items, $str);

    array_push($items, array('name'=>$str,'uploaddate'=>($uploaddate)) );

    }   // foreach

}
$pe_data = '';
$pe_data.= '<h2>FILINGS <a class="postlink" href="viewfiling.php?c='.$_POST['cname'].'&cid='.$_POST['cid'].'"> View all</a></h2>';
$pe_data.= '<table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links"><thead><tr><th>File Name </th> <th>Date</th></tr></thead>';

for ($i=0; $i < 5; $i++) { 
    # code...
   
    $pe_data.='<tr><td style="alt">'.$items[$i][name].'</td>';
    if($items[$i][uploaddate] != ''){
        $pe_data.='<td>'.$items[$i][uploaddate].'</td> ';
    } else {
        $pe_data.='<td> -- </td> ';
    }
    $pe_data.='</tr>';
}
    


$pe_data.= '</tbody></table>';

$result = $c2. " of ". $c1;
echo json_encode(array( 'html' => $pe_data ) );

?>