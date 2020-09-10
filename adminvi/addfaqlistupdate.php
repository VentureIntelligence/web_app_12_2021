<?php
    require("../dbconnectvi.php");
     $Db = new dbInvestments();
 //session_save_path("/tmp");
        session_start();
        if (session_is_registered("SessLoggedAdminPwd"))
        {
            
// && session_is_registered("SessLoggedIpAdd"))

                            //echo "<br>full string- " .$i;
                   
                    $listid=$_POST['listid']; 
                    $repQuestion=trim($_POST['repQuestion']);   
                    $repAnswer=trim($_POST['repAnswer']); 
                    $repAssert=trim($_POST['repAssert']);
                    $repDBtype=$_POST['repDBtype'];
                    $modifiedDate = date( 'Y-m-d H:i:s' );
                   
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
                  
                    $updatesql="update faq set question='".addslashes($repQuestion)."', answer='".addslashes($repAnswer)."', assert='".addslashes($repAssert)."', assert_type='$repAssertType', DBtype='$repDBtype', updatedDate='$modifiedDate',assertname='$basename' where id='$listid'";
                    $rsinsert = mysql_query( $updatesql) or die(mysql_error());
                    
                    
                
                    header( 'Location: ' . BASE_URL . 'adminvi/viewfaqlist.php' );                    
                    
           } // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;            
 

?>