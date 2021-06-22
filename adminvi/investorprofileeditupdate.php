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
    


        $AngelApi_invID = $_POST['angelco_compID'];
        
        if($AngelApi_invID=='' || $AngelApi_invID==0){
            $angelco_invID='';
        }else if($AngelApi_invID>0){
            $angelco_invID=$AngelApi_invID;
        }
        
    	 $companyIdtoUpdate = $_POST['txtInvestorId'];
    	 $companyNameToUpdate =  $_POST['txtname'];
    	 $keyContactToUpdate=$_POST['txtKeyContact'];
    	$companyNameToUpdate=str_replace('"','',$companyNameToUpdate);
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
    	 $countryidToUpdate=$_POST['country'];

    	 $emailToUpdate=$_POST['txtemail'];
    	 $emailToUpdate=str_replace('"','',$emailToUpdate);
    	 $websiteToupdate=$_POST['txtwebsite'];
    	 $websiteToupdate=str_replace('"','',$websiteToupdate);
    	 $descriptionToUpdate=$_POST['txtdescription'];
    	 $descriptionToUpdate=str_replace('"','',$descriptionToUpdate);
    	  $yearfoundedToUpdate=$_POST['txtyearfounded'];
    	 $yearfoundedToUpdate=str_replace('"','',$yearfoundedToUpdate);
    	 $noemployeesToUpdate=$_POST['txtnoemployees'];
    	 $noemployeesToUpdate=str_replace('"','',$noemployeesToUpdate);
    	 $firmTypeToUpdate=$_POST['txtfirmtype'];
    	 $firmTypeToUpdate=str_replace('"','',$firmTypeToUpdate);
         
         $firmTypeIdToUpdate=$_POST['firmtype'];
         $foucs_capsourceIdtoUpdate=$_POST['focuscapitalsource'];
        
         $otherLocationToUpdate=$_POST['txtotherlocation'];
    	 $otherLocationToUpdate=str_replace('"','',$otherLocationToUpdate);

    	 $assets_mgmtToUpdate=$_POST['txtassets_mgmt'];
	   	 $assets_mgmtToUpdate=str_replace('"','',$assets_mgmtToUpdate);
        if(isset($_POST['txthidedrypowder'])){       
            $dry_hide=$_POST['txthidedrypowder'];
        }else{
            $dry_hide=0;
        }


    	 $alreadyinvestedToUpdate=$_POST['txtalreadyinvested'];
    	 	   	 $alreadyinvestedToUpdate=str_replace('"','',$alreadyinvestedToUpdate);

    	 $lpsToUpdate=$_POST['txtlps'];
    	 	   	 $lpsToUpdate=str_replace('"','',$lpsToUpdate);

    	 $nofundsToUpdate=$_POST['txtnofunds'];
    	 	   	 $nofundsToUpdate=str_replace('"','',$nofundsToUpdate);
    	 $activefundsToUpdate=$_POST['txtactivefunds'];
    	 	   	 $activefundsToUpdate=str_replace('"','',$activefundsToUpdate);
    	 $mininvestmentToUpdate=$_POST['txtmininvestment'];
	   	 	   	 $mininvestmentToUpdate=str_replace('"','',$mininvestmentToUpdate);
    	 $commentToUpdate=$_POST['txtcomment'];
    	 	   	 $commentToUpdate=str_replace('"','',$commentToUpdate);
    	 $addinforToUpdate=$_POST['txtaddinfor'];
    	 $addinforToUpdate=str_replace('"','',$addinforToUpdate);

	   	 $mgmtExecutiveId=$_POST['txtmgmtExecutiveId'];
    	 $mgmtExecutiveIdArray= count($mgmtExecutiveId);
    	 $mgmtExecutiveName=$_POST['txtmgmtExecutiveName'];

    	 //echo "<br>----" .$mgmtExecutiveName;

    	 $UpdatecompanySql="Update peinvestors set Investor='$companyNameToUpdate',Address1='$address1ToUpdate',Address2='$address2ToUpdate',
    	 City='$adCityToUpdate',Zip='$zipToUpdate',Telephone='$telToUpdate',Fax='$faxToUpdate',
    	 Email='$emailToUpdate',website='$websiteToupdate',linkedIn='$liToUpdate',
    	 Description='$descriptionToUpdate',yearfounded='$yearfoundedToUpdate',NoEmployees='$noemployeesToUpdate',
    	 FirmType='$firmTypeToUpdate',OtherLocation='$otherLocationToUpdate',Assets_mgmt='$assets_mgmtToUpdate',
    	 AlreadyInvested='$alreadyinvestedToUpdate',LimitedPartners='$lpsToUpdate',NoFunds='$nofundsToUpdate',
    	 NoActiveFunds='$activefundsToUpdate',MinInvestment='$mininvestmentToUpdate',
    	 AdditionalInfor='$addinforToUpdate',Comment='$commentToUpdate',countryid='$countryidToUpdate',FirmTypeId=$firmTypeIdToUpdate,
    	 focuscapsourceid=$foucs_capsourceIdtoUpdate ,KeyContact='$keyContactToUpdate', angelco_invID='$angelco_invID',dry_hide='$dry_hide'
    	 where InvestorId=$companyIdtoUpdate";

		//	echo "<br>company update Query-- " .$UpdatecompanySql;
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
						$DeleteMgmtSql="Delete from peinvestors_management where ExecutiveId=$exeId and InvestorId=$companyIdtoUpdate";
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