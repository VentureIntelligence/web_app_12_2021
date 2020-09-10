<?php 

error_reporting(0);

include "header.php";
	
		
                if(isset($_POST['chargeholder_str']) && $_POST['chargeholder_str']!=''){
                        require_once MODULES_DIR."plstandard.php"; 
                        $plstandard = new plstandard();

                         $where=" `Charge Holder`  LIKE "."'".$_POST['chargeholder_str']."%'";

                        $Companies = $plstandard->getchargeholderSuggest($where,$order);
                        $jsonarray=array();
                        if(array_keys($Companies)){
                                foreach($Companies as $id => $name) {
                                        $jsonarray[]=array('chargeholder'=>addslashes($name),'cin'=>$id);
                                }
                        }else{
                                //$html.="[]";
                        }
                        echo json_encode($jsonarray);
                }
                
                
                
                
              
                
                if(isset($_POST['chargeaddress_str']) && $_POST['chargeaddress_str']!=''){
                        require_once MODULES_DIR."city.php"; 
                        $city = new city();

                         $where=" city_name  LIKE "."'".$_POST['chargeaddress_str']."%'";

                        $Companies = $city->getcityfilterSuggest($where,$order);
                        $jsonarray=array();
                        if(array_keys($Companies)){
                                foreach($Companies as $id => $name) {
                                        $jsonarray[]=array('cityname'=>addslashes($name),'cityid'=>$id);
                                }
                        }else{
                                //$html.="[]";
                        }
                        echo json_encode($jsonarray);
                }
                
               
                
                
mysql_close(); 
?>
