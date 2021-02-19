<?php include_once("../globalconfig.php"); ?>
<?php

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
	if(!isset($_SESSION['UserNames']))
	{
			header('Location:../pelogin.php');
	}
	else
	{
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
	    <tr><td><A href="../pelogin.php" target="_blank">Click here </a>to login again </td></tr>
	    </table>
	<?php
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	$mailurl= curPageURL();

		$username=$_SESSION['UserNames'];
		$emailid=$_SESSION['UserEmail'];
//echo "<br>--" .$emailid;

		//while giving hyperlink in the companyname the companyId id prefixed with
			 //1- for Investment deals for the companydetails.php.
			// 2- for RealEstate in redealinfo.php
	//  company profile (which is a not a realestate company) is displayed


	//similarly prefixing 1- for investordetails.php link for PE and 2-for RE
?>
<html><head>
<title>PE Investment Deal Info</title>
<style type="text/css">
.highlight_word{
        background-color: pink;
}
</style>
<script type="text/javascript">
if (window.focus) {window.focus()}
</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body oncontextmenu="return false;" >

 <form name=companyDisplay method="post" action="exportdealinfo.php">
 <table border=0 align=center cellpadding=0 cellspacing=0 width=95%

 				<tr>
 				<td align=right>
 				<a href="../index.htm"><img border="0" src="home.JPG" width="20" height="20"></a></td>
 				</tr>
 			</table>
<?php
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);

	/*$Investorname="others";
	$invResult=substr_count($Investorname,$searchString);
	$invResult1=substr_count($Investorname,$searchString1);
	$invResult2=substr_count($Investorname,$searchString2);

		$companyName="Undisclosed-Aug-07-1   ";
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
		$compResult1=substr_count($companyName,$searchString1);
		if(($compResult==0) && ($compResult1==0))
			echo"<br>>Hyper link";
		else
			echo"<br>No Hyper link"; */
//echo "<br>****";
if ((session_is_registered("UserNames")) )
{
//	echo "<br>^^^";
//if(($username!="") && ($emailid!=""))
		$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
		$strvalue = explode("/", $value);
		$SelCompRef=$strvalue[0];
		$flagvalue=$strvalue[1];
		$searchstring=$strvalue[2];
		if($flagvalue==0)
		                 $pageTitle="PE Investment";
                elseif($flagvalue==1)
                       $pageTitle="VC Investment";
                elseif($flagvalue==3)
                       $pageTitle="Social Venture Investment";
                elseif($flagvalue==4)
                       $pageTitle="CleanTech Investment";
                elseif($flagvalue==5)
                       $pageTitle="Infrastructure Investment";

		$exportToExcel=0;
			$TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
			where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
				}
			}
                    //echo "<bR>-----" .$exportToExcel;

	//$SelCompRef=$value;
  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
	     amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city,
	     pec.region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
	    pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,uploadfilename,source,
            Valuation,FinLink,pec.RegionId, pe.AggHide, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,SPV
	     FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
	    investortype as its,stage as s
	     WHERE pec.industry = i.industryid
	     AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
	     and pe.PEId=$SelCompRef and s.StageId=pe.StageId
	     and its.InvestorType=pe.InvestorType ";
	//echo "<br>********".$sql;

	$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisorinvestors as advinv,
	advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";



  	if ($companyrs = mysql_query($sql))
		{
	?>
		<input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >


	<table border=1 align=center cellpadding=0 cellspacing=0 width=95%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
		<?php
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
                    $regionid=$myrow["RegionId"];
                   // echo "<Br>***".$regionid;
                    if($regionid>0)
                    { $regionname=return_insert_get_RegionIdName($regionid); }
                    else
                    { $regionname=$myrow["region"]; }
		    if($myrow["SPV"]==1)
		    {
                     $openDebtBracket="[";
		     $closeDebtBracket="]";

		     }
		      else
		      {
		       $openDebtBracket="";
		       $closeDebtBracket="";

		       }
                    if($myrow["AggHide"]==1)
		    {
		        $openBracket="(";
		        $closeBracket=")";
                    }
                    else
                    {
		        $openBracket="";
		        $closeBracket="";
                    }

                	if($myrow["hideamount"]==1)
			{
				$hideamount="--";
			}
			else
			{
				$hideamount=$myrow["amount"];
			}

			if($myrow["hidestake"]==1)
			{
				$hidestake="--";
			}
			else
                        {
				$hidestake=$myrow["stakepercentage"];
				if($myrow["stakepercentage"]>0)
					$hidestake=$myrow["stakepercentage"];
				else
					$hidestake="&nbsp;";
                        }
		$valuation=$myrow["Valuation"];
		if($valuation!="")
		{
		    $valuationdata = explode("\n", $valuation);
		}

		if($myrow["Company_Valuation"]<=0)
                    $dec_company_valuation=0.00;
                else
                    $dec_company_valuation=$myrow["Company_Valuation"];
                if($myrow["Revenue_Multiple"]<=0)
                    $dec_revenue_multiple=0.00;
                else
                    $dec_revenue_multiple=$myrow["Revenue_Multiple"];

               	if($myrow["EBITDA_Multiple"]<=0)
                    $dec_ebitda_multiple=0.00;
                else
                    $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
               	if($myrow["PAT_Multiple"]<=0)
                    $dec_pat_multiple=0.00;
                else
                    $dec_pat_multiple=$myrow["PAT_Multiple"];

                    if($myrow["listing_status"]=="L")
                        $listing_stauts_display="Listed";
                    elseif($myrow["listing_status"]=="U")
                        $listing_stauts_display="Unlisted";
		//echo "<bR>---".$valuationdata;


	      	$moreinfor=$myrow["MoreInfor"];
	      //$moreinfor=nl2br($moreinfor);
               //echo "<bR>".$moreinfor;
	      	$string = $moreinfor;
			/*** an array of words to highlight ***/
			$words = array($searchstring);
			//$words="warrants convertible";
			/*** highlight the words ***/
			$moreinfor =  highlightWords($string, $words);

			$col6=$myrow["Link"];
			$linkstring=str_replace('"','',$col6);
			$linkstring=explode(";",$linkstring);

			$uploadname=$myrow["uploadfilename"];
			$currentdir=getcwd();
			$target = $currentdir . "../uploadmamafiles/" . $uploadname;

			$file = "../uploadmamafiles/" . $uploadname;


	     ?>



	       		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b><?php echo $pageTitle;?></b></td></tr>
				<tr><td width=20%><b>&nbsp;Company</b></td>
		<?php
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				$finlink=$myrow["FinLink"];
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width=40% ><b>&nbsp;<?php echo $openDebtBracket;?><?php echo $openBracket;?><A href='companydetails.php?value=<?php echo $myrow["PECompanyId"];?>' >
				<?php echo rtrim($myrow["companyname"]);?></a><?php echo $closeBracket;?><?php echo $closeDebtBracket;?>
				</b></td>
		<?php
				}
				else
				{
					$webdisplay="";
		?>
				<td width=40% ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>

				</tr>
                                <tr><td width=20%><b>&nbsp;Company Type </b></td><td width=30% >&nbsp;<?php echo $listing_stauts_display;?></td></tr>
				<tr><td width=20%><b>&nbsp;Industry </b></td><td width=30% >&nbsp;<?php echo $myrow["industry"];?></td></tr>
				<tr><td width=20%><b>&nbsp;Sector </b></td><td width=30%>&nbsp;<?php echo $myrow["sector_business"];?></td></tr>
				<tr><td width=20%><b>&nbsp;Amount (US$M)</b></td><td  width=30%>&nbsp;<?php echo $hideamount;?>&nbsp;</td></tr>
				<tr><td width=20%><b>&nbsp;Round </b></td><td width=30%>&nbsp;<?php echo $myrow["round"];?></td></tr>
				<tr><td width=20%><b>&nbsp;Stage </b></td><td width=30%>&nbsp;<?php echo $myrow["Stage"];?></td></tr>

				<tr><td width=20%><b>&nbsp;Investors </b></td><td>
				<!--
				<td width=30% >&nbsp;<?php echo $myrow["investors"];?></td>-->


				<table border=0 cellpadding=0 cellspacing=0 width=80%
				style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
				<?php
					if ($getcompanyrs = mysql_query($investorSql))
					{
						$AddOtherAtLast="";
						$AddUnknowUndisclosedAtLast="";
					While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
	      			{
	      				//$AddOtherAtLast="";
	      				$Investorname=trim($myInvrow["Investor"]);
	      				$Investorname=strtolower($Investorname);

	      				$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
	      		?>
					<tr><td width="100" style="font-family: Verdana; font-size: 8pt" >
					<a href='investordetails.php?value=<?php echo $myInvrow["InvestorId"];?>' ><?php echo $myInvrow["Investor"]; ?></a>
					</td></tr>
				<?php
						}
						elseif(($invResult==1) || ($invResult1==1))
							$AddUnknowUndisclosedAtLast=$myInvrow["Investor"];
						elseif($invResult2==1)
						{
							$AddOtherAtLast=$myInvrow["Investor"];
						}

					}
					}
				?>
					<tr><td width="100" style="font-family: Verdana; font-size: 8pt" >
					<?php echo $AddUnknowUndisclosedAtLast; ?></td></tr>

					<tr><td width="100" style="font-family: Verdana; font-size: 8pt" >
					<?php echo $AddOtherAtLast; ?></td></tr>
				</table></td></tr>
				<tr><td width=20%><b>&nbsp;Investor Type </b></td><td width=30% >&nbsp;<?php echo $myrow["InvestorTypeName"] ;?></td></tr>

				<tr><td width=20%><b>&nbsp;Stake (%) </b></td><td width=30% >&nbsp;<?php echo $hidestake ;?></td></tr>
				<tr><td width=20% ><b>&nbsp;Date </b></td><td width=30%>&nbsp;<?php echo  $myrow["dt"];?></td></tr>
				<tr><td width=20%><b>&nbsp;City</b></td><td width=30%>&nbsp;<?php echo  $myrow["city"];?></td></tr>
				<tr><td width=20%><b>&nbsp;Region</b></td><td width=30% >&nbsp;<?php echo $regionname;?></td></tr>
				<tr><td width=20% ><b>&nbsp;Website</b></td><td width=30%>&nbsp;<a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></td></tr>
                                <?php
                                 if($rscomp= mysql_query($advcompanysql))
				{
				     $comp_cnt = mysql_num_rows($rscomp);
				}
				if($comp_cnt>0)
				{
                                 ?>
				<tr><td width=20%><b>&nbsp;Advisor Company</b></td>
				<td>
				<table border=0 cellpadding=0 cellspacing=0 width=80%
				style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
				<?php


					if ($getcompanyrs = mysql_query($advcompanysql))
					{
					While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
					{
				?>
					<tr><td width="100" style="font-family: Verdana; font-size: 8pt" >
					<!--					<a href='advisordetails.php?value=<?php echo $myadcomprow["CIAId"];?>' target="_blank"><?php echo $myadcomprow["cianame"]; ?></a>
					-->

						<A href='advisor.php?value=<?php echo $myadcomprow["CIAId"];?>/1/<?php echo $flagvalue?>' >
						<?php echo $myadcomprow["cianame"]; ?></a> (<?php echo $myadcomprow["AdvisorType"];?>)
					</td></tr>
				<?php
					}
					}
				?>
		 	     </table>	</td></tr>
                              <?php 
                              }

                                 if($rsinvcomp= mysql_query($advinvestorssql))
				{
				     $compinv_cnt = mysql_num_rows($rsinvcomp);
				}
				if($compinv_cnt>0)
				{
                               ?>
				<tr><td width=20%><b>&nbsp;Advisor Investors</b></td>
				<td>
				<table border=0 cellpadding=0 cellspacing=0 width=95%
				style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
				<?php
					if ($getinvestorrs = mysql_query($advinvestorssql))
					{
					While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
					{
				?>
					<tr><td width="100" style="font-family: Verdana; font-size: 8pt" >
					<A href='advisor.php?value=<?php echo $myadinvrow["CIAId"];?>/1/<?php echo $flagvalue?>' >
					<?php echo $myadinvrow["cianame"]; ?> </a> (<?php echo $myadinvrow["AdvisorType"];?>)
					</td></tr>
				<?php
					}
					}
				?>
				</table></td></tr>
                                <?php
                                }
                                ?>

            <tr><td width=20%><b>&nbsp;More Details</b></td><td width=30% >&nbsp;<?php print nl2br($moreinfor); ?>  </td></tr>
           	<tr><td width=20% ><b>&nbsp;Link</b></td>
				<td>
				<table border=0 cellpadding=0 cellspacing=0 width=95%
				style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
				<?php
					 foreach ($linkstring as $linkstr)
					{
						if(trim($linkstr)!=="")
						{
					?>
						<tr><td width=30%>&nbsp;<a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a></td></tr>
				<?php
						}
					}
				?>

			</table></td></tr>

                        <?php
                        if($dec_company_valuation >0)
                        {
                        ?>
                        <tr><td width=20%><b>&nbsp;Company Valuation - Equity - Post Money (INR Cr) </b></td>
                        <td width=30% >&nbsp;<?php echo $dec_company_valuation ;?></td></tr>
                         <?php
                        }
                        
                        if($dec_revenue_multiple >0)
                        {
                        ?>
                        <tr><td width=20%><b>&nbsp;Revenue Multiple (based on Equity Value / Market Cap)</b></td>
                        <td width=30% >&nbsp;<?php echo $dec_revenue_multiple ;?></td></tr>
                         <?php
                        }

                        if($dec_ebitda_multiple >0)
                        {
                        ?>
                        <tr><td width=20%><b>&nbsp;EBITDA Multiple (based on Equity Value)</b></td>
                        <td width=30% >&nbsp;<?php echo $dec_ebitda_multiple ;?></td></tr>
                         <?php
                        }

                        if($dec_pat_multiple >0)
                        {
                        ?>
                        <tr><td width=20%><b>&nbsp;PAT Multiple (based on Equity Value)</b></td>
                        <td width=30% >&nbsp;<?php echo $dec_pat_multiple ;?></td></tr>
                         <?php
                        }
                        if(trim($myrow["Valuation"])!="")
			{
			?>
			<tr><td width=20%><b>&nbsp;Valuation (More Info)</b></td>
			<td><table border=0 cellpadding=0 cellspacing=0 width=95%
			style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">

			<?php
			    foreach($valuationdata as $valdata)
			    {
				if($valdata!="")
				{
			?>
			   <tr><td><?php print nl2br($valdata);?></td></tr>
			<?php
				}
			    }
			?>
			</table></td></tr>
			<?php
			}

			if($finlink!="")
			{
			?>
			    <tr><td width=20%><b>&nbsp;Link for Financials</b></td>
			   <td width=30%>&nbsp;<a target="_blank" href=<?php echo $finlink; ?> ><?php echo $finlink; ?></a></td>

			<?php
			}
                        //echo "<BR>-----" .$exportToExcel;

                        //echo "<BR>^^^^".$showFinancial;
			if($myrow["uploadfilename"]!="")
			{
				?>
					<tr><td width=20% ><b>&nbsp;Financials</b></td>

                                        <?php
                                         if($exportToExcel==1)
                                         {
                                         ?>
					            <td><a href=<?php echo $file;?> target="_blank" > Click here </a>
                                                    <Br />

                                                    <img src="/images/newbuttonfinancials.gif" alt="CFS"  align="middle" width="40" height="40" />
                                                    <a href="<?php echo GLOBAL_BASE_URL; ?>cfs/index.php"target="_blank">Click Here to compare with other companies in CFS database</a>
                                                     </td>

                                                     </tr>
                                         <?php
                                         }
                                         else
                                         {
                                         ?>
                                                     <td>&nbsp;Paid Subscribers can view a link to the co. financials here </td> </tr>
                                         <?php
                                          }
                                         ?>
					<!--<tr><td width=20% valign=top><b>&nbsp;Source</b></td>
					<td width=30% >&nbsp;<?php echo  $myrow["source"];?></td></tr>  -->
				<?php
			}

            }//while loop ends

?>

              <tr rowspan=4><td colspan=2 > <br /><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.</td></tr>


		</table>
			<table border=0 align=center cellpadding=0 cellspacing=0 width=95%
				<tr><td colspan=2>&nbsp;</td></tr>
				<tr>
				<Td><input type="button" value=" < " name="backbutton" onClick='javascript:history.back(-1)'></td>

				<td align=middle>
				<?php
					if(($exportToExcel==1))
					{
					?>
							<span style="float:center" class="one">
									<input type="submit"  value="Click Here To Export" name="showdeal">
							</span>

					<?php
					}
					?>
				</td>

				<td align=right><input type="button" value=" > " name="forwardbutton" onClick='javascript:history.back(1)'></td>

				</tr>
 			</table>
 <?php
 	}//if loop ends
 } //session registered loop ends

	}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


 function highlightWords($text, $words)
 {

         /*** loop of the array of words ***/
         foreach ($words as $worde)
         {

                 /*** quote the text for regex ***/
                 $word = preg_quote($worde);
                 /*** highlight the words ***/
                 $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
         }
         /*** return the text ***/
         return $text;
 }

 	function return_insert_get_RegionIdName($regionidd)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionidd";

                if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionIdname = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionIdname;
				}
			}
		}
		$dbregionlink.close();
	}

	
?>


     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>

 </body>
 </html>