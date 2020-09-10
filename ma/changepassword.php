<?php
           require_once("maconfig.php");
           $WhichMember = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
            if($WhichMember=="P")
            {
                    $dealpagedirectTo="index.php";
                    $headerurl="tvheader_search.php";
            }
            elseif($WhichMember=="M")
            {
                    $dealpagedirectTo="maindex.php";
                    $headerurl="maheader_search.php";
            }
            elseif($WhichMember=="R")
            {
                    $dealpagedirectTo="reindex.php";
                    $headerurl="reheader_search.php";
            }
            require_once("../dbconnectvi.php");
            $Db = new dbInvestments();
            include ('machecklogin.php');
            
    ?>

    <?php 
    $topNav = 'Deals';
    include_once($headerurl);
    ?>




    <div id="container">
    <table cellpadding="0" cellspacing="0" width="100%">
    <tr>


    <td class="right-box"  >
        
        <div style="width: 600px;margin:100px;"> <!--action="updatepwd.php"-->
            <script type="text/javascript">
function checkFields()
 {
  	if((document.getElementById("txtnewpwd").value == "") || (document.getElementById("txtconfirmnewpwd").value == ""))
    {
		alert("Please enter both New Password and Cofirm password");
		return false;
   } else if((document.getElementById("txtnewpwd").value !=  document.getElementById("txtconfirmnewpwd").value))
 	{
 		alert("Password Not match");
 		return false;
 	}
        
        return  true;
        
}
        </script>
        </form>
        <form name="changepwd" id="changepwd" onsubmit="return checkFields();" method="post" action="updatepwd.php">
           <table cellpadding="5">     
               <tr><td colspan="2"><h3>Change Password</h3></td></tr>
           <tr><td>Email</td><td><input type="hidden" name="txtlogintype" value=<?php echo $WhichMember; ?> ><?php echo $emailid; ?></td></tr>
           <tr><td>New Password</td><td><input type="password" name="txtnewpwd" size="39" id="txtnewpwd" /></td></tr>
           
           <tr><td>Confirm New Password</td><td> <input type="password" name="txtconfirmnewpwd" id="txtconfirmnewpwd" size="39" /></td></tr>
           <tr><td></td><td><input type="submit"  value="Update Password" name="updpwd" ></td></tr>
        
       </table>
           
        </form>
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
    
    </body>
    
    </html>
    <?php mysql_close(); ?>
