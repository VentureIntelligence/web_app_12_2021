<?php include_once("../globalconfig.php"); ?>
<?php
            require_once("../dbconnectvi.php");
            $Db = new dbInvestments();
            require_once("reconfig.php");
            $newpassword=$_POST['txtnewpwd'];
            $logintype=$_POST['txtlogintype'];
            if($logintype=="P")
            {
                    $dealpagedirectTo="index.php";
                    $headerurl="tvheader_search.php";
            }
            elseif($logintype=="M")
            {
                    $dealpagedirectTo="maindex.php";
                    $headerurl="maheader_search.php";
            }
            elseif($logintype=="R")
            {
                    $dealpagedirectTo="reindex.php";
                    $headerurl="reheader_search.php";
            }
            
            include ('checklogin.php');
            
    ?>

   <?php 
    $topNav = 'Deals';
    include_once($headerurl);
    ?>




    <div id="container">
    <table cellpadding="0" cellspacing="0" width="100%">
    <tr>
    


    <td class="right-box"  >
        
        <div style="width: 600px;margin:100px;">
            
            <?php
if( (session_is_registered("UserNames")) || (session_is_registered("REUserNames")) )
		 {
				// if($logintype=="P")
		 	// 		 $UpdatePwdSql="Update dealmembers set Passwrd='$newpassword' where EmailId='$emailid'";
				// elseif($logintype=="M")
				// 	 $UpdatePwdSql="Update malogin_members set Passwrd='$newpassword' where EmailId='$emailid'";
    //                             elseif($logintype=="R")
                                    //echo "Update RElogin_members set Passwrd='$newpassword' where EmailId='$emailid'";
                $newpasswordMD5 = md5($newpassword);
					 $UpdatePwdSql="Update RElogin_members set Passwrd='$newpasswordMD5' where EmailId='$emailid'";
				//echo "<Br>Get- ".$UpdatePwdSql;
				if($updatepwdrs=mysql_query($UpdatePwdSql))
				{

                      // update cfs 
              $getCountCfs = mysql_query("select * from users where username='$emailid'");
              $getCountCfs = mysql_num_rows($getCountCfs);
             // echo "getCountCfs = ".$getCountCfs;
              if($getCountCfs >=1) {
                $updatepwdrsCfs = mysql_query("Update users set user_password='$newpasswordMD5' where username='$emailid'"); 
                if($updatepwdrsCfs) { $noError = true; } else { $noError = false;   }
              }

              // update PE
              
              $getCountPe = mysql_query("select * from dealmembers where EmailId='$emailid'");
              $getCountPe = mysql_num_rows($getCountPe);
            //  echo "getCountPe = ".$getCountPe;
              if($getCountPe >=1) {
                $updatepwdrsPe = mysql_query("Update dealmembers set Passwrd='$newpasswordMD5' where EmailId='$emailid'"); 
                if($updatepwdrsPe) { $noError = true; } else { $noError = false;   }
              }
               // update MA
              $getCountMa = mysql_query("select * from malogin_members where EmailId='$emailid'");
              $getCountMa = mysql_num_rows($getCountMa);
            //  echo "getCountMa = ".$getCountMa;
              if($getCountMa >=1) {
                $updatepwdrsMa=mysql_query("Update malogin_members set Passwrd='$newpasswordMD5' where EmailId='$emailid'"); 
                if($updatepwdrsMa) { $noError = true; } else { $noError = false;   }
              }

?>
       
           <table cellpadding="5">     
               <tr><td colspan="2"><h3>Change Password</h3></td></tr>
           <tr><td>Your password has been changed across all the databases.</td></tr>
           <tr><td>It will become effective the next time you login.</td></tr>
        
       </table>
           
        </form>
                 <?php } else {

		$Db->closeDB();
	//	$allowAuthenticate=1;
	//	header( 'Location: https://www.ventureintelligence.com/deals/changepassword.php' ) ;
	}
} ?>
        </div>
        
    </td></tr>       
        </tbody>
    </table>

    </div>			
    <div class="holder"></div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>

    <div class=""></div>

    </div>
    </form>
    </body>
    <SCRIPT LANGUAGE="JavaScript">
function checkFields()
 {
  	if((document.pelogin.emailid.value == "") || (document.pelogin.emailpassword.value == ""))
    {
		alert("Please enter both Email Id and Password");
		return false
 	}
 	if(document.pelogin.chkTerm.checked==false)
 	{
 		alert("Please agree to Terms & Conditions");
 		return false
 	}
}
</SCRIPT>
    </html>
