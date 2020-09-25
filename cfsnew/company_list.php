<?php 
    error_reporting(0);
    include "header.php";
	require_once MODULES_DIR."plstandard.php"; 
    $plstandard = new plstandard();
    $companyname = $_POST['companyname'];
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
                    $checkoption.= '<a style="color: #352c2c !important;" href="companylist_suggest.php?id='.$id .'"><div id="result_cc"><label class="ch_holder"> '.$name .'</label></div></a>';
                    $labelid++;
                }
                echo $checkoption;
        }else{
                //$html.="[]";
        }
    }
    mysql_close(); 
?>
