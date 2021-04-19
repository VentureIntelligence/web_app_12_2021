<?php 

    error_reporting(0);

    include "header.php";
	include "sessauth.php";
    require_once MODULES_DIR."/cprofile.php";
    $cprofile = new cprofile();

     require_once MODULES_DIR."/grouplist.php";
    $grouplist = new grouplist();

//		print $key;
  
   // $searchStrings = explode( ' ', $_POST['queryString'] );
    /*$where = "(FCompanyName LIKE "."'%".$_POST['queryString']."%' or SCompanyName LIKE "."'%".$_POST['queryString']."%')";
    $where .= " and  (Industry  != '' and  State  != '') ";*/

    $where = "CIN LIKE "."'".$_POST['queryString']."%' OR Old_CIN LIKE '%".$_POST['queryString']."%'";
    $slt='CIN, Old_CIN';

    $Companies_brand = $cprofile->getCompaniesAutoSuggest_name_cinno($slt,$where,$order);
    //print_r($Companies_brand);exit();

    if(array_keys($Companies_brand)){
        foreach($Companies_brand as $key => $comp_brand) {
            foreach($comp_brand as $key1 => $value) {
            //print_r($value);
            $jsonarray[]=array('countryname'=>$value,'countryid'=>$key1, 'category'=>'');
            }
        }
    }else{
        //$html.="[]";
       // $jsonarray = "No Result Found for you Search !..";
    }

    echo json_encode($jsonarray);
?>
