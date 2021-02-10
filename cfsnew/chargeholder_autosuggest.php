<?php 

error_reporting(0);

include "header.php";
include "sessauth.php";	
		
            
                        require_once MODULES_DIR."plstandard.php"; 
                        $plstandard = new plstandard();

                        $chargeholder = $_POST['chargeholder'];
                        $where=" `Charge Holder`  LIKE '$chargeholder%'";

                        $Companies = $plstandard->getchargeholderSuggest($where,$order);
                        $jsonarray=array();
                        $checkoption='';
                        if(array_keys($Companies)){
                            $labelid=0;
                                $checkoption.= '<label  > <input style="width:auto !important;" type="checkbox" id="selectall"> SELECT ALL</label><br>';
                                foreach($Companies as $id => $name) {
                                        
                                        $jsonarray[]=array('chargeholder'=>addslashes($name),'cin'=>$id);
                                         $checkoption.= '<label  > <input style="width:auto !important;" type="checkbox" name="charge_holder[]" value="'.$name.'"  class="ch_holder" > '.$name .'</label><br>';
                                
                                        $labelid++;
                                }
                                echo $checkoption;
                        }else{
                                //$html.="[]";
                        }
                        //echo json_encode($jsonarray);
    mysql_close(); 
?>
