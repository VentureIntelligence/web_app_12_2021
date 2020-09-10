<?php
 require("../dbconnectvi.php");
			 $Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800))
	{
	    // last request was more than 3 minates ago
	    session_destroy();   // destroy session data in storage
	    session_unset();     // unset $_SESSION variable for the runtime
	    echo "<br>Your session has expired...";
	
	?>
	   <table border=o align=center cellpadding=0 cellspacing=0 width=95%
	    style="font-family: Arial; font-size: 10pt; 
	     border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
	    <tr><td><A href="../pelogin.php" >Click here </a>to login again </td></tr>
	    </table> 
	<?php
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
	 if ((session_is_registered("UserNames")))
	{
			$sesID=session_id();
			$username=$_SESSION['UserNames'];
			$emailid=$_SESSION['UserEmail'];


		$vcflagValue=$_POST['txtdirvalue'];

			

			$totalCount=0;
			$keyword= $_POST['keywordsearch'];
			$region=$_POST['region'];
			$industry=$_POST['industry'];
				$stageval=$_POST['stage'];
				if($_POST['stage'])
				{
					$boolStage=true;
					//foreach($stageval as $stage)
					//	echo "<br>----" .$stage;
				}
				else
				{
					$stage="--";
					$boolStage=false;
				}
			$investorType=$_POST['invType'];
			$firmType=$_POST['firmtype'];
			$focuscapsource=$_POST['focuscapitalsource'];
			$startRangeValue=$_POST['invrangestart'];
				$endRangeValue=$_POST['invrangeend'];
				$endRangeValueDisplay =$endRangeValue;
				//echo "<bR>---" .$startRangeValue;
				//echo "<bR>***".$endRangeValue;

			$whereind="";
			//$whereregion="";
			$whereinvType="";
			$wherestage="";
			$wheredates="";
			$whererange="";
			$wherefirmtype="";
                        $wherefocuscapsource="";
			$month1=$_POST['month1'];
			$year1 = $_POST['year1'];
			$month2=$_POST['month2'];
			$year2 = $_POST['year2'];

	$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
$splityear1=(substr($year1,2));
$splityear2=(substr($year2,2));

if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
	$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
	$wheredates1= "";
}

	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);

			if($vcflagValue==0)
			{
				$addVCFlagqry="";
				$checkForStage = ' && ('.'$stage'.' =="--")';
				//$checkForStage = " && (" .'$stage'."=='--') ";
				$checkForStageValue = " || (" .'$stage'.">0) ";
				$searchTitle = "List of PE Investors ";

			}
			elseif($vcflagValue==1)
			{
				$addVCFlagqry="";
				$addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
				$checkForStage = '&& ('.'$stage'.'=="--") ';
				//$checkForStage = " && (" .'$stage'."=='--') ";
				$checkForStageValue =  " || (" .'$stage'.">0) ";
				$searchTitle = "List of VC Investors ";
				//	echo "<br>Check for stage** - " .$checkForStage;
			}


			if($industry >0)
			{
				$industrysql= "select industry from industry where IndustryId=$industry";
				if ($industryrs = mysql_query($industrysql))
				{
					While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
					{
						$industryvalue=$myrow["industry"];
					}
				}
			}

			if($boolStage==true)
		        {
			foreach($stageval as $stageid)
			{
				$stagesql= "select Stage from stage where StageId=$stageid";
			//	echo "<br>**".$stagesql;
				if ($stagers = mysql_query($stagesql))
				{
					While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
					{
						$stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
					}
				}
			}
			$stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
		        }
		        else
			{$stagevaluetext="";}
			
                        if($investorType !="--")
				{
					$invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
							if ($invrs = mysql_query($invTypeSql))
							{
								While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
								{
									$invtypevalue=$myrow["InvestorTypeName"];
								}
							}
			}


		if (($keyword == "") && ($companysearch=="") && ($industry =="--")  && 	($investorType == "--") &&  ($startRangeValue == "--") && ($endRangeValue == "--") && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--") .$checkForStageValue)
		{
		 //original query
		 //$getInvestorSql="select inv.InvestorId,inv.Investor from peinvestors as inv order by Investor";
		$yourquery=0;
		$getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
		 				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
		 				WHERE pe.PECompanyId = pec.PEcompanyId
		 				AND s.StageId = pe.StageId
		 				AND pec.industry !=15
		 				AND peinv.PEId = pe.PEId
		 				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 order by inv.Investor ";
		 //   echo "<br>all records" .$getInvestorSql;
		}
		elseif($keyword!="")
		{
			//$getInvestorSql="select inv.InvestorId,inv.Investor from peinvestors as inv where Investor like '$keyword%' order by Investor";
			$yourquery=1;
			$datevalueDisplay1="";
			$getInvestorSql="select distinct peinv.InvestorId,inv.Investor
							from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
							where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
							pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
							pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
		//	//echo "<br> Investor search- ".$getInvestorSql;
		}

					elseif (($industry > 0) || ($investorType != "--") || ($firmType > 0) || ($focuscapsource > 0) || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
						{
							$yourquery=1;
							$dt1 = $year1."-".$month1."-01";
							//echo "<BR>DATE1---" .$dt1;
							$dt2 = $year2."-".$month2."-01";
							/*
							$getInvestorSql = "select distinct peinv.InvestorId,inv.Investor,peinv.PEId,pe.PEId,pe.PECompanyId,pec.companyname,pec.PECompanyId,
							pec.industry,pe.StageId
							from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
							where ";

							*/
							$getInvestorSql = "select distinct peinv.InvestorId,inv.Investor
							from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
							where ";

						//	echo "<br> individual where clauses have to be merged ";
							if ($industry > 0)
								$whereind = " pec.industry=" .$industry ;
							//if ($region!= "--")
							//	$whereregion = " pe.region ='".$region."'";
							if ($investorType!= "--")
								$whereInvType = " pe.InvestorType = '".$investorType."'";
							if($firmType >0)
                                                                $wherefirmtype= " peinv.FirmTypeId= ".$firmType;
                                                        if($focuscapsource>0)
                                                                $wherefocuscapsource=" peinv.focuscapsourceid =" .$focuscapsource;
							if ($boolStage==true)
						{
							$stagevalue="";
							$stageidvalue="";
							foreach($stageval as $stage)
							{
								//echo "<br>****----" .$stage;
								$stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
								$stageidvalue=$stageidvalue.",".$stage;
							}

							$wherestage = $stagevalue ;
							$qryDealTypeTitle="Stage  - ";
							$strlength=strlen($wherestage);
							$strlength=$strlength-3;
						//echo "<Br>----------------" .$wherestage;
						$wherestage= substr ($wherestage , 0,$strlength);
						$wherestage ="(".$wherestage.")";
						//echo "<br>---" .$stringto;

						}
							if (($startRangeValue!= "--") && ($endRangeValue != ""))
						{
							$startRangeValue=$startRangeValue;
							$endRangeValue=$endRangeValue-0.01;
							$qryRangeTitle="Deal Range (M$) - ";
							if($startRangeValue < $endRangeValue)
							{
								$whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
							}
							elseif($startRangeValue = $endRangeValue)
							{
								$whererange = " pe.amount >= ".$startRangeValue ."";
							}
						}
							if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
								$wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
							if ($whereind != "")
								{
									$getInvestorSql=$getInvestorSql . $whereind ." and ";

									$bool=true;
								}
								else
								{
									$bool=false;
								}
							/*if (($whereregion != "") )
								{
								$getInvestorSql=$getInvestorSql . $whereregion . " and " ;
								$bool=true;
								}*/
							if (($wherestage != ""))
								{
									$getInvestorSql=$getInvestorSql . $wherestage . " and " ;
									$bool=true;
								}
							if (($whereInvType != "") )
								{
									$getInvestorSql=$getInvestorSql .$whereInvType . " and ";
									$bool=true;
								}
							if($wherefirmtype!="")
                                                                 {
                                                                   $getInvestorSql=$getInvestorSql .$wherefirmtype . " and ";
									$bool=true;
                                                                 }
                                                        if($wherefocuscapsource!="")
                                                                 {
                                                                   $getInvestorSql=$getInvestorSql .$wherefocuscapsource . " and ";
									$bool=true;
                                                                 }
							if (($whererange != "") )
								{
									$getInvestorSql=$getInvestorSql .$whererange . " and ";
									$bool=true;
								}
							if(($wheredates !== "") )
							{
								$getInvestorSql = $getInvestorSql . $wheredates ." and ";
								$bool=true;
							}
							$getInvestorSql = $getInvestorSql . " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
							pe.StageId=s.StageId and pec.industry!=15 and
							pe.Deleted=0 " .$addVCFlagqry. "order by inv.Investor ";
							//echo "<br><br>WHERE CLAUSE SQL---" .$getInvestorSql;
						}
						else
						{
							echo "<br> INVALID DATES GIVEN ";
							$fetchRecords=false;
						}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - Private Equity, Venture Capital and M&A deals in India</title>

<script type="text/javascript">

</script>

<style type="text/css">


</style>
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body oncontextmenu="return false;" >

<form name="pegetdata"  method="post" action="exportinvestorprofile.php" >
<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="../index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeview">
    	<div id="vertMenu">
		        	<div>Welcome  &nbsp;&nbsp;<?php echo $UserNames; ?> <br/ ><br /></div>

								<div><a href="changepassword.php">Change your Password </a> <br /><br /></div>
								<div><a href="dealhome.php">Database Home</a> <br /><br /></div>

					<div><a href="../logoff.php">Logout </a> <br /><br /></div>
      	</div>

    </div>
   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
 <!--  <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>-->
	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:445px; margin-top:0px;">
	    <div id="maintextpro">
        <div id="headingtextpro">

	<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
		<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
		<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >


			<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >

		<input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
		<input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
		<input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
		<input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
                <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
		<input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
		<input type="hidden" name="hidepeipomandapage" value="4" >
		<input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >


		<?php

				$exportToExcel=0;
				$TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
				where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
				if($trialrs=mysql_query($TrialSql))
				{
					while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
					{
						$exportToExcel=$trialrow["TrialLogin"];
					}
				}
			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
				 	      /* Select queries return a resultset */
						 if ($rsinvestor = mysql_query($getInvestorSql))
						 {
						    $investor_cnt = mysql_num_rows($rsinvestor);
						 }
				           if($investor_cnt > 0)
				           {
				           	//	$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Investor(s) found for this search ";
				           }

		           ?>
		           	<div id="headingtextproboldfontcolor">
				   			    <?php
				   					echo $queryDisplayTitle;
    				   				if($industry >0 )
				   					echo "> " .$industryvalue;
				   				if($stagevaluetext!="")
				 	                              echo "&nbsp;&nbsp;&nbsp;> ".$stagevaluetext;
				   				if($investorType !="--")
				   					echo "&nbsp;&nbsp;&nbsp;> ".$invtypevalue;
				   				if (($startRangeValue!= "--") && ($endRangeValue != ""))
	           		                                        echo "&nbsp;&nbsp;&nbsp;>(USM) " .$startRangeValue ."-" .$endRangeValueDisplay;
				   	           	if($datevalueDisplay1!="")
				   	           		echo "&nbsp;&nbsp;&nbsp;> ".$datevalueDisplay1. "-" .$datevalueDisplay2;
				   	           	if($keyword!="")
				   	           		echo "&nbsp;&nbsp;&nbsp;> ".$keyword;
				   				?>
			 <br /><br /></div>

						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  </div>
					<?php
					if($investor_cnt>0)
					{
					?>
							<div style="width: 500px; height:295px; overflow: scroll;">
							<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
						<?php
						   While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
							{
								$Investorname=trim($myrow["Investor"]);
								$Investorname=strtolower($Investorname);

								$invResult=substr_count($Investorname,$searchString);
								$invResult1=substr_count($Investorname,$searchString1);
								$invResult2=substr_count($Investorname,$searchString2);

								if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
								{

							 ?>
							 		<tr><Td>
							 		<A href="investordetails.php?value=<?php echo $myrow["InvestorId"];?> "
								   target="popup" onclick="MyWindow=window.open('investordetails.php?value=<?php echo $myrow["InvestorId"];?>', 'popup', 'scrollbars=1,width=800,height=400');MyWindow.focus(top);return false">
								  <?php echo $myrow["Investor"];?></a> </td>

									 </tr>
								<?php
									$totalCount=$totalCount+1;
								}
								else
								{
							?>
									<!--<tr><td ><?php echo $myrow["Investor"]; ?></td></tr>-->

							<?

								}

							}

						?>
					 </table>
					</div>
		<?php
					}
		?>

		<div id="headingtextproboldbcolor">&nbsp; No. of Investors  - <?php echo $totalCount; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		</div>
		<?php
		if(($exportToExcel==1) && ($totalCount >=1))
		{
		?>
				<span style="float:left" class="one">
						To Export the above into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showprofile">
				</span>
		<?php
		}
		?>

	        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
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
}

function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}
?>