<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 //session_save_path("/tmp");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
// && session_is_registered("SessLoggedIpAdd"))

							//echo "<br>full string- " .$i;
                    $action=$_POST['actionlist'];   
                    $listid=$_POST['listid']; 
                    $typeofreport=$_POST['repType'];
                    $titleofreport=$_POST['repTitle'];
                    $periodofreport=$_POST['repPeriod'];
                    $ar_PE=$_POST['txtPE'];
                    if($ar_PE=="")
                    {
                        $ar_PE=0;
                    }
                    else
                    {
                        $ar_PE;
                    }
                    $ar_VC=$_POST['txtVC'];
                     if($ar_VC=="")
                    {
                        $ar_VC=0;
                    }
                    else
                    {
                        $ar_VC;
                    }
                    $ar_Early=$_POST['txtES'];
                     if($ar_Early=="")
                    {
                        $ar_Early=0;
                    }
                    else
                    {
                        $ar_Early;
                    }
                    $ar_MA=$_POST['txtMA'];
                     if($ar_MA=="")
                    {
                        $ar_MA=0;
                    }
                    else
                    {
                        $ar_MA;
                    }
                    $ar_RE=$_POST['txtRE'];
                     if($ar_RE=="")
                    {
                        $ar_RE=0;
                    }
                    else
                    {
                        $ar_RE;
                    }
                    $ar_Infra=$_POST['txtInfra'];
                     if($ar_Infra=="")
                    {
                        $ar_Infra=0;
                    }
                    else
                    {
                        $ar_Infra;
                    }
                    $ar_social=$_POST['txtSocial'];
                     if($ar_social=="")
                    {
                        $ar_social=0;
                    }
                    else
                    {
                        $ar_social;
                    }
                    $ar_cleantech=$_POST['txtClean'];
                     if($ar_cleantech=="")
                    {
                        $ar_cleantech=0;
                    }
                    else
                    {
                       $ar_cleantech;
                    }
                    $zscore_id=$_POST['zscore_id'];
                    $dateofreport=$_POST['date'];
                    $nanocode=  stripslashes($_POST['txtcode']);
                    $def=$_POST['txtdef'];
                    
                if($action=='add')
                {
                    $insertsql= "INSERT INTO nanotool (typeofReport,titleofReport,periodofReport,ar_PE,ar_VC,ar_Earlystage,ar_MA,ar_RE,ar_Infra,ar_Social,ar_Cleantech,date,definitions)
                                        VALUES ('$typeofreport','$titleofreport','$periodofreport',$ar_PE,$ar_VC,$ar_Early,$ar_MA,$ar_RE,$ar_Infra,$ar_social,$ar_cleantech,'$dateofreport','$def')";
                    //echo "<br>@@@@ :".$insertsql;
                
                    $rsinsert = mysql_query($insertsql) or die(mysql_error());
                    
                    // echo "select id from nanotool where titleofReport='".$titleofreport."' and periodofReport='".$periodofreport."' and date='".$dateofreport."'";
                    $idsql=mysql_query("select id from nanotool where titleofReport='".$titleofreport."' and periodofReport='".$periodofreport."' and date='".$dateofreport."'");
                    $rowid=  mysql_fetch_array($idsql);
                    
                    $filename=trim($titleofreport).'_'.$rowid['id'].'.html';
                    $target_file='./nanofolder/'.$filename;
                   
                    $handle = fopen($target_file, "w");
                    fwrite($handle, $nanocode); // write it
                    fclose($handle);
                    
                    $insertfile="update nanotool set nanobi_EC='".$filename."' where id=".$rowid['id']."";
                    $rsinsert = mysql_query( $insertfile) or die(mysql_error());
                }
                else
                {
                   
                   $nanoSql="select `nanobi_EC` from nanotool WHERE `id`='".$listid."'";
                   $result = mysql_query($nanoSql) or die(mysql_error());
                   $row=mysql_fetch_array($result);
                  // echo $row['nanobi_EC'];
                    
                   $filename=$row['nanobi_EC'];
                   $target_file='./nanofolder/'.$filename;
                     if(file_exists($target_file))
                    {
                        unlink($target_file);
                       
                    }
                    
                    $handle = fopen($target_file, "w");
                    fwrite($handle, $nanocode); // write it
                    fclose($handle);
                    $updatesql="update nanotool set zscore_id='$zscore_id', typeofReport='$typeofreport', titleofReport='$titleofreport', periodofReport='$periodofreport', ar_PE=$ar_PE, ar_VC=$ar_VC, ar_Earlystage=$ar_Early, 
                                ar_MA=$ar_MA, ar_RE=$ar_RE,ar_Infra=$ar_Infra,ar_Social=$ar_social,ar_Cleantech=$ar_cleantech,date='$dateofreport',nanobi_EC='".$filename."',definitions='$def' where id='$listid'";
                    $rsinsert = mysql_query( $updatesql) or die(mysql_error());
                    
                    
                }
                    header( 'Location: ' . BASE_URL . 'adminvi/viewlist.php' );                    
                    
           } // if resgistered loop ends
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;            
 

?>