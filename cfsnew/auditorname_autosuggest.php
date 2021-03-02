<?php 

error_reporting(0);

include "header.php";
include "sessauth.php";	
		
            
                        require_once MODULES_DIR."plstandard.php"; 
                        $plstandard = new plstandard();

                        $auditorname = $_POST['auditorname'];
                        $where=" `auditor_name`  LIKE '$auditorname%'";

                        $Companies = $plstandard->getauditornameSuggest($where,$order);
                        $jsonarray=array();
                        $checkoption='';
                        
                        if(array_keys($Companies)){
                            $labelid=0;
                                $checkoption.= '<label  > <input style="width:auto !important;" type="checkbox" id="selectallauditor"> SELECT ALL</label><br>';
                                foreach($Companies as $id => $name) {
                                        
                                        $jsonarray[]=array('auditorname'=>addslashes($name),'id'=>$id);
                                         $checkoption.= '<label  > <input style="width:auto !important;" type="checkbox" name="auditor_holder[]" value="'.$name.'"  class="ad_holder" > '.$name .'</label><br>';
                                
                                        $labelid++;
                                }
                                echo $checkoption;
                        }else{
                                //$html.="[]";
                        }
                        //echo json_encode($jsonarray);
    mysql_close(); 
?>
