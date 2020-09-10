<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Update Investment data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="incubatorprofileupdate" >

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Update Incubator Profile</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    


    	 $companyIdtoUpdate = $_POST['txtincubatorId'];
    	 $companyNameToUpdate =  $_POST['txtname'];
         $companyNameToUpdate=str_replace('"','',$companyNameToUpdate);
          $incfirmtypeid=$_POST['incfirmtype'];
   	   	 $address1ToUpdate=$_POST['txtaddress1'];
    	 $address1ToUpdate=str_replace('"','',$address1ToUpdate);
    	 $address2ToUpdate=$_POST['txtaddress2'];
    	 $address2ToUpdate=str_replace('"','',$address2ToUpdate);
    	 $adCityToUpdate=$_POST['txtadcity'];
    	 $adCityToUpdate=str_replace('"','',$adCityToUpdate);
    	 $zipToUpdate=$_POST['txtzip'];
    	 $zipToUpdate=str_replace('"','',$zipToUpdate);

    	 $telToUpdate=$_POST['txttelephone'];
    	 $telToUpdate=str_replace('"','',$telToUpdate);
    	 $urlToUpdate=$_POST['txtwebsite'];
    	 $urlToUpdate=str_replace('"','',$urlToUpdate);
       $liToUpdate=$_POST['txtlinkedin'];
       $liToUpdate=str_replace('"','',$liToUpdate);
    	 $faxToUpdate=$_POST['txtfax'];
    	 $faxToUpdate=str_replace('"','',$faxToUpdate);

    	 $emailToUpdate=$_POST['txtEmail'];
    	 $emailToUpdate=str_replace('"','',$emailToUpdate);
    	 $websiteToupdate=$_POST['txtwebsite'];
    	 $websiteToupdate=str_replace('"','',$websiteToupdate);

       $mgmttoUpdate=$_POST['txtmgmt'];
          $mgmttoUpdate=str_replace('"','',$mgmttoUpdate);
           $fundsAvailabletoUpdate=$_POST['txtfundsavailable'];
          $fundsAvailabletoUpdate=str_replace('"','',$fundsAvailabletoUpdate);

    	 $addinforToUpdate=$_POST['txtaddinfor'];
    	 $addinforToUpdate=str_replace('"','',$addinforToUpdate);

    	$updatePECompanySql="Update incubators set Incubator='$companyNameToUpdate',Address1='$address1ToUpdate',Address2='$address2ToUpdate',
         City='$adCityToUpdate',Zip='$zipToUpdate',Telephone='$telToUpdate',Fax='$faxToUpdate',Email='$emailToUpdate',website='$urlToUpdate',linkedIn='$liToUpdate',
          FundsAvailable='$fundsAvailabletoUpdate', AdditionalInfor='$addinforToUpdate',Management='$mgmttoUpdate' , IncFirmTypeId=$incfirmtypeid
           where IncubatorId=$companyIdtoUpdate";

			//	echo "<br>company update Query-- " .$updatePECompanySql;
			if($updaters=mysql_query($updatePECompanySql))
			{
       		?>
				<tr><td>
				 <font style="font-family: Verdana; font-size: 8pt"><?php echo $companyNameToUpdate; ?> -- Profile updated</font>
				</td></tr>
		<?php
			}
		?>

</table>



<?php

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
</form>
</body></html>
