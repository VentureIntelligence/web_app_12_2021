<?php 
    error_reporting(0);
    include "header.php";
	require_once MODULES_DIR."plstandard.php"; 
    $plstandard = new plstandard();
    $companyname = $_REQUEST['companyname'];
    if($companyname != ''){
        $where=" `companyName`  LIKE '$companyname%'";
        $Companies = $plstandard->getcompanySuggest($where,$order);
        $jsonarray=array();
        $checkoption='';
        if(array_keys($Companies)){
            $labelid=0;
                // $checkoption.= '<label  > <input style="width:auto !important;" type="checkbox" id="selectall"> SELECT ALL</label><br>';
                foreach($Companies as $id => $name) {
                    $jsonarray[]=array('companyname'=>addslashes($name),'Company_Id'=>$id);
                    //$checkoption.= '<div id="result_cc"><label class="ch_holder"> '.$name .'</label></div>';
                    $labelid++;
                }
                
        }else{
                //$html.="[]";
        }
    }
    echo json_encode($jsonarray);
    mysql_close(); 
?>
