<?php 
    error_reporting(0);
    include "header.php";
	require_once MODULES_DIR."plstandard.php"; 
    $plstandard = new plstandard();
    $chargeholder = $_POST['chargeholder'];
    if($chargeholder != ''){
        $where=" `Charge Holder`  LIKE '$chargeholder%'";
        $Companies = $plstandard->getchargeholderSuggest($where,$order);
        
        $jsonarray=array();
        $checkoption='';
        if(array_keys($Companies)){
            $labelid=0;
                // $checkoption.= '<label  > <input style="width:auto !important;" type="checkbox" id="selectall"> SELECT ALL</label><br>';
                foreach($Companies as $id => $name) {
                    $jsonarray[]=array('chargeholder'=>addslashes($name),'id'=>$id);
                    $filter_cn = str_replace(' ', '_', $name);
                    $filter_cn = str_replace('__', '_', $filter_cn);
                    $checkoption.= '<a style="color: #352c2c !important;" href="chargesholderlist_suggest.php?name='.$filter_cn .'"><div id="result_cc"><label class="ch_holder" style="cursor:pointer;"> '.$name.'</label></div></a>';
                    $labelid++;
                }
                echo $checkoption;
        }else{
                //$html.="[]";
        }
    }
    mysql_close(); 
?>
