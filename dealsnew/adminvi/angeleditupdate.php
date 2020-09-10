<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") )
	{
	//&& session_is_registered("SessLoggedIpAdd")
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
<form name="peupdatedata" method=post action="peupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Investement deal list</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    require("../dbconnectvi.php");
	$Db = new dbInvestments();

	$multipleangelrounds=0;
	$followonVCfunding=0;
	$exited=0;
         $PEIdtoUpdate = $_POST['txtPEId'];
   
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$companyIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	
    	 if(($_POST['chkmultipleangelround']))
    	 {
	    $multipleangelrounds=1;
	}
	 else
	    { $multipleangelrounds=0;}
	
	if($_POST['chkfollowonvcfund'])
    	{
	    $followonVCfunding=1;
	}
	else
	{ $followonVCfunding=0;}
	if($_POST['chkexited'])
    	{
	    $exited=1;
	}
	else
	{ $exited=0;}
	    
    	 $investorsidtoUpdate=$_POST['txtinvestorid'];
    	 $investoridarray= count($investorsidtoUpdate);
		//	echo "<br>Inv array count- " .$investoridarray;
    	 $investorstoUpdate=$_POST['txtinvestors'];
    //	 	echo "<br>Investors to Update--" .$investorstoUpdate;
    	
    	 $mthtoUpdate=$_POST['month1'];
    	 $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";
    	 $urltoUpdate=$_POST['txtwebsite'];
    	 $citytoUpdate=$_POST['txtcity'];
    	 $RegionIdtoUpdate=$_POST['txtregion'];
    	 $countryidtoUpdate=$_POST['txtcountry'];

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];
	 $validationtoUpdate=$_POST['txtvalidation'];
	 $linktoUpdate=$_POST['txtlink'];
	 $flagDeletion=0;

    	 $UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,
    	 sector_business='$sectortoUpdate',website='$urltoUpdate',city='$citytoUpdate',
    	 RegionId=$RegionIdtoUpdate,countryid='$countryidtoUpdate' where PECompanyId=$companyIdtoUpdate";

	//echo "<br>company update Query-- " .$UpdatecompanySql;
	if($updaters=mysql_query($UpdatecompanySql))
	{
	    $UpdateInvestmentSql="update angelinvdeals set DealDate='$fulldate',
	    MultipleRound=$multipleangelrounds,FollowonVCFund=$followonVCfunding,Exited=$exited,
	    Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
	    Validation='$validationtoUpdate', Link='$linktoUpdate',Deleted=$flagDeletion
	    where AngelDealId=$PEIdtoUpdate";
       	//echo "<br>Angel Deal Update Query--**-- " .$UpdateInvestmentSql;
	    if($updatersinvestment=mysql_query($UpdateInvestmentSql))
	    {
		echo "<br>DEAL UPDATED";
		$idarray = array();
		If(trim($investorstoUpdate!=""))
		{
		    $newinvestor=explode(",",$investorstoUpdate);
		    //echo " <br>1---";
		    foreach($newinvestor as $inv)
		    {
			if(trim($inv)!="")
			{
			    $invIdtoInsert=return_insert_get_Investor($inv);
			    if($invIdtoInsert==0)
				$invIdtoInsert=return_insert_get_Investor($inv);
			    if(in_array($invIdtoInsert,$investorsidtoUpdate)==false)
			    {
				$updatePEInvestorsSql="insert into angel_investors values($PEIdtoUpdate,$invIdtoInsert)";
				if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
				{
				    echo "<br>Inserted Investor -" .$updatePEInvestorsSql;
				}
			    }
			    $idarray[]=$invIdtoInsert;
			}
		    }
		}
		if ($investoridarray>0)
		{
		    for ($i=0;$i<=$investoridarray-1;$i++)
		    {
			$delId=$investorsidtoUpdate[$i];
			if(in_array($delId,$idarray)==false)
			{
			    $updatePEInv_InvestorSql="delete from angel_investors where PEId=$PEIdtoUpdate and InvestorId=$delId";
			    if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
			    {
				echo "<br>Delete Investor Query-" .$updatePEInv_InvestorSql;
			    }
			}
		    }
		}
	    ?>
	    <tr><td>
	     <font style="font-family: Verdana; font-size: 8pt"> Deal has been updated</font>

	    </td></tr>
<?php
	    }
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
<?php
//function to insert investors
function return_insert_get_Investor($investor)
{
	$investor=trim($investor);
	$investor=ltrim($investor);
	$investor=rtrim($investor);
	$dblink = new dbInvestments();
	$getInvestorIdSql = "select InvestorId from peinvestors where Investor='$investor'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
	    $investor_cnt=mysql_num_rows($rsgetInvestorId);
	    //echo "<br>Investor count-- " .$investor_cnt;
	    if ($investor_cnt==0)
	    {
		//echo "<br>----insert Investor ";
		$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
		if($rsInsAcquirer = mysql_query($insAcquirerSql))
		{
			$InvestorId=0;
			return $InvestorId;
		}
	    }
	    elseif($investor_cnt>=1)
	    {
		While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
		{
		    $InvestorId = $myrow[0];
		    //echo "<br>Insert return investor id--" .$invId;
		    return $InvestorId;
		}
	    }
	}
	$dblink.close();
}
?>