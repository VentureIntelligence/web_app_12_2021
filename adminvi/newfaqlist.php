<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 //session_save_path("/tmp");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
// && session_is_registered("SessLoggedIpAdd"))

							//echo "<br>full string- " .$i;
                    $repQuestion=trim($_POST['repQuestion']);   
                    $repAnswer=trim($_POST['repAnswer']); 
                    $repAssert=trim($_POST['repAssert']);
                    $repDBtype=$_POST['repDBtype'];
                    $createdDate = date( 'Y-m-d H:i:s' );

                    $repAssertTypevalue = pathinfo($repAssert, PATHINFO_EXTENSION);
                    $videotype=array("webm","mkv","flv","vob","ogv","ogg","drc","gif","gifv","mng","avi","wmv","mov","yuv","rm","rmvb","asf","amv","mp4","m4p","m4v","mpg","mpeg","mp2","mpe","mpv","m2v","3gp","svi","flv");
                    $textformat=array("pdf");

                    if(in_array($repAssertTypevalue, $videotype, TRUE))
                    {
                         $repAssertType="video";
                    }elseif(in_array($repAssertTypevalue, $textformat, TRUE))
                    {
                         $repAssertType="pdf";
                    } 
                    
                    $rmspace=str_replace('%20',' ', $repAssert);
                    $basename=basename($rmspace);
                   
                    $insertsql= "INSERT INTO faq (question,answer,assert,assert_type,DBtype,createdDate,updatedDate,status,assertname)
                                        VALUES ('".addslashes($repQuestion)."','".addslashes($repAnswer)."','".addslashes($repAssert)."','$repAssertType','$repDBtype','$createdDate','$createdDate',0,'$basename')";
                    //echo "<br>@@@@ :".$insertsql;
                
                    $rsinsert = mysql_query($insertsql) or die(mysql_error());
                    
                    $rowid=  mysql_fetch_array($idsql);
                    
                    /*$filename=trim($titleofreport).'_'.$rowid['id'].'.html';
                    $target_file='./nanofolder/'.$filename;
                   
                    $handle = fopen($target_file, "w");
                    fwrite($handle, $nanocode); // write it
                    fclose($handle);*/
                    
                    /*$insertfile="update nanotool set nanobi_EC='".$filename."' where id=".$rowid['id']."";
                    $rsinsert = mysql_query( $insertfile) or die(mysql_error());*/
                
                    header( 'Location: ' . BASE_URL . 'adminvi/viewfaqlist.php' );                    
                    
           } // if resgistered loop ends
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;            
 

?>