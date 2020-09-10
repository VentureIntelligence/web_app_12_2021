<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
  require("checkaccess.php");
  checkaccess( 'edit' );
 session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{

?>
<html><head>
<title>Advisor Info</title>
</head>

<body>
 <form name=advisoredit method=post action="advisorupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=30%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $currentyear = date("Y");
	$advisorId=$value;
   	$getDatasql = " select * from advisor_cias where CIAId=$advisorId";
        if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
	     	While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
                   $advisorname =$mycomprow["cianame"];
                   $advisorsector=$mycomprow["sector_business"];
                   $website=$mycomprow["website"];
                   $advisorType=$mycomprow["AdvisorType"];
                   $address=$mycomprow["address"];
                   $city=$mycomprow["city"];
                   $country=$mycomprow["country"];
                   $phoneno=$mycomprow["phoneno"];
                   $contactperson=$mycomprow["contactperson"];
                   $designation=$mycomprow["designation"];
                   $email=$mycomprow["email"];
                   $linkedin=$mycomprow["linkedin"];

         ?>
                       	<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Advisor Edit Deal</b></td></tr>
				<tr>


                                  <!-- Advisor Id -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtadvisorId" size="10" value="<?php echo $advisorId; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td style="width:30%">Advisor
                                 </td>
				<td style="width:70%"><input type="text" name="txtadvisor" size="50" value="<?php echo $advisorname; ?>"> </td>
				</tr>

                               <!-- <tr><td >Sector</td>
				<td>
				<input type="text" name="txtsector" size="50" value="<?php echo $advisorsector; ?>"> </td>
				</tr>  -->

                                           <tr><td width="30%">Address</td>
                                     	    <td width="70%">
                        	    <input name="txtaddress" type="text" size=20 value="<?php echo $address; ?>"  >
                        	    </td>  </tr>
                                           
                                           <tr><td >City</td>
                                     	    <td >
                        	    <input name="txtcity" type="text" size=20 value="<?php echo $city; ?>"  >
                        	    </td>  </tr>
                                           
                                           <tr><td >Country</td>
                                     	    <td >
                        	    <input name="txtcountry" type="text" size=20 value="<?php echo $country; ?>"  >
                        	    </td>  </tr>
                                           
                                           <tr><td >Phone No.</td>
                                     	    <td >
                        	    <input name="txtphoneno" type="text" size=20 value="<?php echo $phoneno; ?>"  >
                        	    </td>  </tr>
                                           
                                           <tr><td >Website</td>
                                     	    <td >
                        	    <input name="txtwebsite" type="text" size=20 value="<?php echo $website; ?>"  >
                        	    </td>  </tr>

                                           <tr><td >Contact Person</td>
                                     	    <td >
                        	    <input name="txtcontactperson" type="text" size=20 value="<?php echo $contactperson; ?>"  >
                        	    </td>  </tr>

                                           <tr><td >Designation</td>
                                     	    <td >
                        	    <input name="txtdesignation" type="text" size=20 value="<?php echo $designation; ?>"  >
                        	    </td>  </tr>
                                           
                                           <tr><td >Email ID</td>
                                     	    <td >
                        	    <input name="txtemail" type="text" size=20 value="<?php echo $email; ?>"  >
                        	    </td>  </tr>
                                           
                                           <tr><td >Co Linkedin Profile</td>
                                     	    <td >
                        	    <input name="txtlinkedin" type="text" size=20 value="<?php echo $linkedin; ?>"  >
                        	    </td>  </tr>
                                           

				<tr>
				<td>&nbsp;Type </td><td>
				<input name="txtadvsiortype" type="text" value="<?php echo $advisorType; ?>" ></td>
			</tr>


		    	<?php
		} //end of while

	mysql_free_result($companyrs);
	}

 ?>

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update Advsior Info" name="updateDeal" > </td></tr></table>


     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>
