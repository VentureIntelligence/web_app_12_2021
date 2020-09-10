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
<form name="recompanyprofileeditupdate" >

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Edit Investor Profile</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php


    	 $acquirerIdtoUpdate = $_POST['txtAcquirerId'];
    	 $companyNameToUpdate =  $_POST['txtname'];
    		$companyNameToUpdate=str_replace('"','',$companyNameToUpdate);
    	$industryidtoUpdate=$_POST['industry'];
    	$sectortoUpdate=$_POST['txtsector'];
		$stockCodetoUpdate=$_POST['txtstockcode'];
   	   	 $address1ToUpdate=$_POST['txtaddress1'];
    	 $address1ToUpdate=str_replace('"','',$address1ToUpdate);
    	 $address2ToUpdate=$_POST['txtaddress2'];
    	 $address2ToUpdate=str_replace('"','',$address2ToUpdate);
    	 $adCityToUpdate=$_POST['txtadcity'];
    	 $adCityToUpdate=str_replace('"','',$adCityToUpdate);
    	 $zipToUpdate=$_POST['txtzip'];
    	 $zipToUpdate=str_replace('"','',$zipToUpdate);

		 $countryIdtoUpdate=$_POST['country'];

    	 $telToUpdate=$_POST['txttelephone'];
    	 $telToUpdate=str_replace('"','',$telToUpdate);
    	 $urlToUpdate=$_POST['txtwebsite'];
    	 $urlToUpdate=str_replace('"','',$urlToUpdate);
    	 $faxToUpdate=$_POST['txtfax'];
    	 $faxToUpdate=str_replace('"','',$faxToUpdate);
    	 $emailToUpdate=$_POST['txtemail'];
    	 $emailToUpdate=str_replace('"','',$emailToUpdate);
    	 $websiteToupdate=$_POST['txtwebsite'];
    	 $websiteToupdate=str_replace('"','',$websiteToupdate);
         $liToUpdate=$_POST['txtlinkedin'];
         $liToUpdate=str_replace('"','',$liToUpdate);
    	 $descriptionToUpdate=$_POST['txtdescription'];
    	 $descriptionToUpdate=str_replace('"','',$descriptionToUpdate);

		 $otherLocationToUpdate=$_POST['txtotherlocation'];
    	 $otherLocationToUpdate=str_replace('"','',$otherLocationToUpdate);

    	 $addinforToUpdate=$_POST['txtaddinfor'];
    	 $addinforToUpdate=str_replace('"','',$addinforToUpdate);

	   	 $mgmtExecutiveId=$_POST['txtmgmtExecutiveId'];
    	 $mgmtExecutiveIdArray= count($mgmtExecutiveId);
    	 $mgmtExecutiveName=$_POST['txtmgmtExecutiveName'];
    	// echo "<br>----" .$mgmtExecutiveName;

    	 $UpdatecompanySql="Update acquirers set Acquirer='$companyNameToUpdate',IndustryId=$industryidtoUpdate,Sector='$sectortoUpdate',Address='$address1ToUpdate',Address1='$address2ToUpdate',
    	 StockCode='$stockCodetoUpdate',CityId='$adCityToUpdate',Zip='$zipToUpdate',countryid='$countryIdtoUpdate',Telephone='$telToUpdate',Fax='$faxToUpdate',
    	 Email='$emailToUpdate',Website='$websiteToupdate',linkedIn='$liToUpdate', OtherLocations='$otherLocationToUpdate',
    	  	 AdditionalInfor='$addinforToUpdate' where AcquirerId=$acquirerIdtoUpdate";
;
				echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{

				//managment
				for ($i=0;$i<=$mgmtExecutiveIdArray-1;$i++)
				{
					if(trim($mgmtExecutiveName[$i])!="")
					{
						$splitmgmt=explode(",",$mgmtExecutiveName[$i]);
						$exeId=$mgmtExecutiveId[$i];
						$exeName=trim($splitmgmt[0]);
						$exeDesig=trim($splitmgmt[1]);
						$exeCompany=trim($splitmgmt[2]);
						$updateExeSql="Update executives set ExecutiveName='$exeName',Designation='$exeDesig',Company='$exeCompany' where ExecutiveId=$exeId";
						if($rsupdateMgmt=mysql_query($updateExeSql))
						{
							echo "<br>Update--".$updateExeSql;
						}

					}
					else
					{
						$exeId=$mgmtExecutiveId[$i];
						$DeleteExeSql="Delete from executives where ExecutiveId=$exeId";
						$DeleteMgmtSql="Delete from acquirer_management where ExecutiveId=$exeId and AcquirerId=$acquirerIdtoUpdate";
						if($rsdeleteMgmt=mysql_query($DeleteMgmtSql))
						{
							if($rsdeleteExe =mysql_query($DeleteExeSql))
								echo "<br>Delete Acquirer Mgmt & Executive--" .$DeleteMgmtSql;
						}
					}
				}
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