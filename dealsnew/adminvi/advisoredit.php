<?php include_once("../../globalconfig.php"); ?>
<?php

 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
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
	require("../dbconnectvi.php");
	$Db = new dbInvestments();

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

         ?>
                       	<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Advisor Edit Deal</b></td></tr>
				<tr>


                                  <!-- Advisor Id -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtadvisorId" size="10" value="<?php echo $advisorId; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td width=10%>Advisor
                                 </td>
				<td><input type="text" name="txtadvisor" size="50" value="<?php echo $advisorname; ?>"> </td>
				</tr>

                               <!-- <tr><td >Sector</td>
				<td>
				<input type="text" name="txtsector" size="50" value="<?php echo $advisorsector; ?>"> </td>
				</tr>  -->

                                           <tr><td >Website</td>
                                     	    <td >
                        	    <input name="txtwebsite" type="text" size=20 value="<?php echo $website; ?>"  >
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
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
