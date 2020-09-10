<?php include_once("../globalconfig.php"); ?>
<?php
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
<form name="companyprofileeditupdate" >

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Edit Company Profile</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    require("../dbconnectvi.php");
	$Db = new dbInvestments();


    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	 $companyNameToUpdate =  $_POST['txtname'];
    	$companyNameToUpdate=str_replace('"','',$companyNameToUpdate);
         $cinnotoUpdate=$_POST['txtcinno'];

    	 $industryIdtoUpdate=$_POST['industry'];
    	 $sectorToUpdate=$_POST['txtsector'];
    	 $sectorToUpdate=str_replace('"','',$sectorToUpdate);

    	 $stockToUpdate=$_POST['txtstockcode'];
    	 $stocktoUpdate=str_replace('"','',$stockToUpdate);
    	// echo "<Br>--------".$stockToUpdate;
    	 $yearfoundedToUpdate=$_POST['txtyearfounded'];
    	 $yearfoundedToUpdate=str_replace('"','',$yearfoundedToUpdate);
    	 $address1ToUpdate=$_POST['txtaddress1'];
    	 $address1ToUpdate=str_replace('"','',$address1ToUpdate);
    	 $address2ToUpdate=$_POST['txtaddress2'];
    	 $address2ToUpdate=str_replace('"','',$address2ToUpdate);
    	 $adCityToUpdate=$_POST['txtadcity'];
    	 $adCityToUpdate=str_replace('"','',$adCityToUpdate);
    	 $regionIdToUpdate=$_POST['txtregion'];

    	 $zipToUpdate=$_POST['txtzip'];
    	 $zipToUpdate=str_replace('"','',$zipToUpdate);
    	 $countryToUpdate=$_POST['txtcountry'];
    	 $countryToUpdate=str_replace('"','',$countryToUpdate);
    	 $otherLocationToUpdate=$_POST['txtotherlocation'];
    	 $otherLocationToUpdate=str_replace('"','',$otherLocationToUpdate);
    	 $telToUpdate=$_POST['txttelephone'];
    	 $telToUpdate=str_replace('"','',$telToUpdate);
    	 $urlToUpdate=$_POST['txtwebsite'];
    	 $urlToUpdate=str_replace('"','',$urlToUpdate);
         $liToUpdate=$_POST['txtlinkedin'];
         $liToUpdate=str_replace('"','',$liToUpdate);
    	 $faxToUpdate=$_POST['txtfax'];
    	 $faxToUpdate=str_replace('"','',$faxToUpdate);
    	 $emailToUpdate=$_POST['txtemail'];
    	 $emailToUpdate=str_replace('"','',$emailToUpdate);
    	 $addinforToUpdate=$_POST['txtaddinfor'];
    	 $addinforToUpdate=str_replace('"','',$addinforToUpdate);


		 $brdExecutiveId=$_POST['txtbrdExecutiveId'];
		 $brdExecutiveIdArray= count($brdExecutiveId);
     	 $brdExecutiveName=$_POST['txtbrdExecutiveName'];

    	 $mgmtExecutiveId=$_POST['txtmgmtExecutiveId'];
    	 $mgmtExecutiveIdArray= count($mgmtExecutiveId);
    	 //echo "<br>%%%%%%%%%%%".$mgmtExecutiveIdArray;
    	 $mgmtExecutiveName=$_POST['txtmgmtExecutiveName'];

    	// $arraylength=$_POST['txtmgmtExecutiveId'];
		// 			$arraylengthcount=count($arraylength);
		// 			echo "<br>**********--Count--".$arraylengthcount;


    	 $UpdatecompanySql="update REcompanies set companyname='$companyNameToUpdate',CIN='$cinnotoUpdate',industry=$industryIdtoUpdate,sector_business='$sectorToUpdate',
    	 city='$adCityToUpdate',website='$urlToUpdate',linkedIn='$liToUpdate',stockcode='$stockToUpdate',yearfounded='$yearfoundedToUpdate',
    	 Address1='$address1ToUpdate',Address2='$address2ToUpdate',AdCity='$adCityToUpdate',Zip='$zipToUpdate',
    	 OtherLocation='$otherLocationToUpdate',Country='$countryToUpdate',Telephone='$telToUpdate',Fax='$faxToUpdate',
    	 Email='$emailToUpdate',AdditionalInfor='$addinforToUpdate',RegionId=$regionIdToUpdate where PECompanyId=$companyIdtoUpdate";
				echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{
				//board

				for ($j=0;$j<=$brdExecutiveIdArray-1;$j++)
				{
					echo "<br>---".$brdExecutiveIdArray[$j];
					if(trim($brdExecutiveName[$j])!="")
					{
						$splitbrd=explode(",",$brdExecutiveName[$j]);
						$bexeId=$brdExecutiveId[$j];
						$bexeName=trim($splitbrd[0]);
						$bexeDesig=trim($splitbrd[1]);
						$bexeCompany=trim($splitbrd[2]);
						$updateExeSql="Update executives set ExecutiveName='$bexeName',Designation='$bexeDesig',Company='$bexeCompany' where ExecutiveId=$bexeId";

						if($updateboardrs=mysql_query($updateExeSql))
						{
							echo "<br>Board.".$updateExeSql;
							//echo "<br>Board Executive Changed--".$bexeName;
						}


					}
					else
					{
						$bexeId=$brdExecutiveId[$j];
						$DeleteExeSql="Delete from executives where ExecutiveId=$bexeId";
						$DeleteMgmtSql="Delete from REcompanies_board where ExecutiveId=$bexeId and PECompanyId=$companyIdtoUpdate";
						if($rsdeleteMgmt=mysql_query($DeleteMgmtSql))
						{
							if($rsdeleteExe =mysql_query($DeleteExeSql))
								echo "<br>Delete Board & Executive--" .$DeleteMgmtSql;
						}
					}
				}

				//managment
				for ($i=0;$i<=$mgmtExecutiveIdArray-1;$i++)
				{
					if(trim($mgmtExecutiveName[$i])!="")
					{
						$splitmgmt=explode(",",$mgmtExecutiveName[$i]);
						$exeId=trim($mgmtExecutiveId[$i]);
						$exeName=trim($splitmgmt[0]);
						$exeDesig=trim($splitmgmt[1]);
						$exeCompany=trim($splitmgmt[2]);
						$updatemgmtSql="Update executives set ExecutiveName='$exeName',Designation='$exeDesig',Company='$exeCompany' where ExecutiveId=$exeId";

						if($updatemgmtrs=mysql_query($updatemgmtSql))
						{
							echo "<br>*.".$updatemgmtSql;
							//echo "<br>Managment Executive Changed".$exeName;
						}
						//echo "<br>--".$updateExeSql;
					}
					else
					{
						$exeId=$mgmtExecutiveId[$i];
						$DeleteExeSql="Delete from executives where ExecutiveId=$exeId";
						$DeleteMgmtSql="Delete from pecompanies_management where ExecutiveId=$exeId and PECompanyId=$companyIdtoUpdate";
						if($rsdeleteMgmt=mysql_query($DeleteMgmtSql))
						{
							if($rsdeleteExe =mysql_query($DeleteExeSql))
								echo "<br>Delete Mgmt & Executive--" .$DeleteMgmtSql;
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