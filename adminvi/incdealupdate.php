<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
	
	//if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	//{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Update Incubator data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="incdealupdate" method=post action="">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Incubator Deal update</font> </b></center></p>


<?php
	$incDealIdtoUpdate=$_POST['txtIncDealId'];
	// echo "<br>******".$incDealIdtoUpdate;
 // $industryIdtoUpdate =$_POST['txtindustryId'];
 $user=$_SESSION['UserNames'];

 	   $companyIdtoUpdate = $_POST['txtcompanyid'];
          	 $companyNametoUpdate =$_POST['txtname'];
          	 $industryidtoUpdate=$_POST['industryid'];
          	 $sectortoUpdate=$_POST['txtsector'];
           	$incubatorIdhidden=$_POST['txtincubatorId'];
           	$incubator=$_POST['txtincubator'];
           	$incubatorId=return_insert_get_incubator($incubator);
           	If($incubatorIdhidden==$incubatorId)
                    $incubatorIdtoUpdate=$incubatorIdhidden;
               else
            	$incubatorIdtoUpdate=$incubatorId;
                	if($_POST['chkfollowonvcfund'])
    	         {
	         $followonfunding=1;
	         }
	         else
	         { $followonfunding=0;}
	$yearfounded=$_POST['txtyearfounded'];
	if($yearfounded=="")
	  $yearfounded=0;
	 $mthtoUpdate=$_POST['month1'];
    	 $YrtoUpdate=$_POST['year1'];
    	     if(($mthtoUpdate=="--") && ($YrtoUpdate=="--"))
    	      $fulldate="0000-00-00";
    	     else
              $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";

    	 $status=$_POST['status'];

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];

		   if($_POST['chkindividual'])
		 {
			$indiFlag=1;
			}
		else
		{ $indiFlag=0;}
		
		  if($_POST['chkDefunct'])
		 {
			$defunctFlag=1;
			}
		else
		{ $defunctFlag=0;}
                $UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate', yearfounded='$yearfounded',sector_business='$sectortoUpdate',
                industry =$industryidtoUpdate,modefied_by='$user'
    	       where PECompanyId=$companyIdtoUpdate";

                   if($updaterscompany=mysql_query($UpdatecompanySql))
                   {
				 echo "<br>Company Info Updated  " ;
                     	}

     		$UpdateIncSql="update incubatordeals set IncubateeId=$companyIdtoUpdate ,IncubatorId=$incubatorIdtoUpdate,
				YearFounded=$yearfounded,Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
             StatusId=$status,Deleted=0,Individual= $indiFlag,FollowonFund=$followonfunding,Defunct=$defunctFlag,date_month_year='$fulldate'
              where IncDealId=$incDealIdtoUpdate";

               //echo "<BR>--" .$UpdateIncSql;
				if($updatersinvestment=mysql_query($UpdateIncSql))
				{
						echo "<br><br>Deal Updated ";

				}



?>
</form>
</body></html>
<?php

//function to insert investors
	function return_insert_get_incubator($incubatorname)
	{
		$incubator=trim($incubatorname);
		$incubator=ltrim($incubatorname);
		$incubator=rtrim($incubatorname);
		$dblink = new dbInvestments();
		$getInvestorIdSql = "select IncubatorId from incubators where Incubator like '$incubator'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
 			if ($investor_cnt==0)
			{
					//echo "<br>----insert Investor ";
					$insAcquirerSql="insert into incubators(Incubator) values('$incubatorname')";
					if($rsInsAcquirer = mysql_query($insAcquirerSql))
					{
						$IncubatorId=0;
						return $IncubatorId;
					}
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$IncubatorId = $myrow[0];
					//echo "<br>Insert return investor id--" .$InvestorId;
					return $IncubatorId;
				}
			}
		}
		$dblink.close();
	}

?>