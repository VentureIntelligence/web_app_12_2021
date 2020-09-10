<?php include_once("../globalconfig.php"); ?>
<?php
/*
filename - madealsearch.php
formname-peinvestment
invoked from - peauthenticate.php,deals/dealhome.php
invoked to - peview.php

*/
require("../dbconnectvi.php");
$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
         $sesID=session_id();
	$username=$_SESSION['MAUserNames'];
	$emailid=$_SESSION['MAUserEmail'];

		$currentyear = date("Y");
                $companyId=632270771;
                $compId=0;

			$pagetitle = "Mergers & Acquistions";
			$getTotalQuery= "select count(ma.MAMAId) as totaldeals, sum(ma.Amount) as totalamount from mama as ma,
			pecompanies as pec where pec.PECompanYid=ma.PECompanyId and pec.Industry !=15 and ma.Deleted=0";

		//echo "<br>Stage SQL--" .$getTotalQuery;
		 if ((session_is_registered("MAUserNames")) )
		 {


                        $ipadd=$_SESSION['MAIP'];
                        //echo "<R>--**-" .$_SESSION['MAIP'];
                        if($ipadd=="MIP")
                          $logvar="MIP";
                        else
                          $logvar="M";
                        //echo "<BR>***".$logvar;

			if ($totalrs = mysql_query($getTotalQuery))
			{
			 While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
			   {
					$totDeals = $myrow["totaldeals"];
					$totDealsAmount = $myrow["totalamount"];
				}

				$totDealsAmount=round($totDealsAmount, 0);
			}
                        	$TrialSql="select dm.DCompId as compid,dc.DCompId from dealcompanies as dc,malogin_members as dm
			where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	     	//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$compId=$trialrow["compid"];

				}
			}
			//echo "<Br>-- ".$compId;
		       if($compId==$companyId)
                       { $hideIndustry = " and display_in_page=1 "; }
                       else
                       { $hideIndustry=""; }


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence - Private Equity, Venture Capital and M&A deals in India</title>
<SCRIPT LANGUAGE="JavaScript">

function checkForAggregates()
{
	//alert("---");
	document.madealsearch.hiddenbutton.value='Aggregate';
	document.madealsearch.submit();
}

function abcde(list)
{
	//alert(list);
//	alert("---");
//	alert(list.options[list.selectedIndex].value);
	if(list.options[list.selectedIndex].value==1)
 	{
		document.madealsearch.acquirerCountry.selectedIndex=1;
		document.madealsearch.acquirerCountry.disabled=true;
		document.madealsearch.targetCountry.disabled=false;
  		document.madealsearch.targetCountry.selectedIndex="--";
	}
	else if(list.options[list.selectedIndex].value==2)
	{
		document.madealsearch.targetCountry.selectedIndex=1;
		document.madealsearch.targetCountry.disabled=true;
		document.madealsearch.acquirerCountry.disabled=false;
  		document.madealsearch.acquirerCountry.selectedIndex="--";
	}
	 else if(list.options[list.selectedIndex].value==3)
	 {
		document.madealsearch.targetCountry.selectedIndex=1;
		document.madealsearch.targetCountry.disabled=true;
		document.madealsearch.acquirerCountry.selectedIndex=1;
		document.madealsearch.acquirerCountry.disabled=true;
  	}
  	else
  	{
		document.madealsearch.targetCountry.disabled=false;
		document.madealsearch.targetCountry.selectedIndex="--";
		document.madealsearch.acquirerCountry.disabled=false;
		document.madealsearch.acquirerCountry.selectedIndex="--";
	}
}

</SCRIPT>

<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="madealsearch"  method="post" action="meracqview.php" >

<div id="containerproductpeinput">
<input type="hidden" name="txtvcFlagValue" value="<?php echo $VCFlagValue; ?>")

<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="../index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeinput">

    	<div id="vertMenu">
			<div>Welcome  &nbsp;&nbsp;<?php echo $MAUserNames; ?> <br/ ><br /></div>

			<div><a href="changepassword.php?value=M">Change your Password </a> <br /><br /></div>
			<div><a href="madealsearch.php">Database Home</a> <br /><br /></div>

			<div><a href="../logoff.php?value=<?php echo $logvar;?>">Logout </a> <br /><br /></div>
	   	</div>


    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:600px; margin-top:0px;">
	    <div id="maintextpro">
        <div id="headingtextpro">

		<div id="headingtextproboldfontcolor"> <?php echo $pagetitle; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<A href="def_M&A.htm"  target="popup" onclick="MyWindow=window.open('def_M&A.htm', 'popup', 'scrollbars=1,width=530,height=250,status=no');MyWindow.focus(top);return false">
				Definitions </a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <a href="../ma-dbase-tutorial.pdf"  target="_blank"> Tutorial </a>

		<br />  <br /> </div>
		<input type="hidden" name="hiddenbutton" value ="">
			<table border=0 cellpadding=1 cellspacing=1 width=100% style="font-family: Arial; font-size: 8pt" >
			<tr><th align=left >Industry </th><td>

							<SELECT name="industry" style="font-family: Arial; color: #004646;font-size: 8pt">
					  		<OPTION id=0 value="--" selected> ALL </option>
							<?php
								 $industrysql="select industryid,industry from industry where industryid !=15 " . $hideIndustry ." order by industry";
									if ($industryrs = mysql_query($industrysql))
									{
									 $ind_cnt = mysql_num_rows($industryrs);
									}
									if($ind_cnt>0)
									{
										 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
										}
									 	mysql_free_result($industryrs);
									}
					    		?></select>
					</td></tr>
			<tr><th align=left> Deal Type </th>
			<td valign=top><SELECT NAME="dealType" onchange="abcde(this)" style="font-family: Arial; color: #004646;font-size: 8pt">
						 <OPTION id=5 value="--" selected> ALL </option>
						 <?php
							/* populating the madealtypes from the madealtypes table */
							$invtypesql = "select MADealTypeId,MADealType from madealtypes order by MADealTypeId ";
								if ($invtypers = mysql_query($invtypesql))
								{
							   $invtype_cnt = mysql_num_rows($invtypers);
								}
							  if($invtype_cnt >0)
							{
							 While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
							{
								$id = $myrow["MADealTypeId"];
								$name = $myrow["MADealType"];
								 echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
							}
						 mysql_free_result($invtypers);
						}
					?>
						 </SELECT> &nbsp;&nbsp;

						 <img id="the_image"
									border="0" src="tool.jpg" width="20" height="20"
								target="popup" onclick="ToolWindow=window.open('toolmadealtype.php', 'popup', 'width=500,height=150,status=no');ToolWindow.focus(top);return false">
						</td>
						  </tr>
						  
                   <tr><th align=left> Target Company Type </th>
			<td colspan=3>

                                                 <SELECT NAME="targetcompanytype" style="font-family: Arial; color: #004646;font-size: 8pt">
						<OPTION value="--" selected> Choose </option>
                                                  <OPTION value="L"> Listed </option>
                                                   <OPTION  value="U"> Unlisted </option>
						 </SELECT> &nbsp;&nbsp;

						</td>
						  </tr>
                     <tr><th align=left> Acquirer Company Type </th>
			<td colspan=3>

                                                 <SELECT NAME="acquirercompanytype" style="font-family: Arial; color: #004646;font-size: 8pt">
						<OPTION value="--" selected> Choose </option>
                                                  <OPTION value="L"> Listed </option>
                                                   <OPTION  value="U"> Unlisted </option>
						 </SELECT> &nbsp;&nbsp;

						</td>
						  </tr>


	<tr><th align=left> Deal Range </th>
	<td colspan=3>
			<SELECT name="invrangestart" style="font-family: Arial; color: #004646;font-size: 8pt"><OPTION id=4 value="--" selected>ALL  </option>
			<?php
				$intialValue=1;
				//$counter=5;
						 echo "<OPTION id=".$intialValue. " value=".$intialValue.">".$intialValue."</OPTION> \n";
						for ( $counter = 5; $counter <= 100; $counter += 5)
						 echo "<OPTION id=".$counter. " value=".$counter.">".$counter."</OPTION> \n";
						 for ( $counter = 150; $counter <= 1000; $counter += 50)
						 echo "<OPTION id=".$counter. " value=".$counter.">".$counter."</OPTION> \n";
						for ( $counter = 2000; $counter <= 10000; $counter += 1000)
						 echo "<OPTION id=".$counter. " value=".$counter.">".$counter."</OPTION> \n";

				?> </select> &nbsp;(US$M)&nbsp;&nbsp;
			To 
			&nbsp;<SELECT name="invrangeend" style="font-family: Arial; color: #004646;font-size: 8pt"><OPTION id=5 value="--" selected>ALL  </option>

				<?php

					$counterTo=5;

						for ( $counterTo = 5; $counterTo <= 100; $counterTo += 5)
						 echo "<OPTION id=".$counterTo. " value=".$counterTo.">".$counterTo."</OPTION> \n";
						for ( $counterTo = 150; $counterTo <= 1000; $counterTo += 50)
						 echo "<OPTION id=".$counterTo. " value=".$counterTo.">".$counterTo."</OPTION> \n";
						for ( $counterTo = 2000; $counterTo <= 10000; $counterTo += 1000)
						 echo "<OPTION id=".$counterTo. " value=".$counterTo.">".$counterTo."</OPTION> \n";
						for ( $counterTo = 20000; $counterTo <= 50000; $counterTo += 10000)
						 echo "<OPTION id=".$counterTo. " value=".$counterTo.">".$counterTo."</OPTION> \n";
			?></select>&nbsp;(US$M)
						</td></tr>
			<tr><Td colspan=4> (Applicable only for deals with Announced Values) </td></tr>
<tr>	<th align=left>Country &nbsp;&nbsp; Target</th>
	<th align=left>

	<SELECT name="targetCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
					<OPTION id=0 value="--" selected> ALL </option>
					<?php
						 $countrysql="select countryid,country from country where countryid !=11 ";
							if ($countryrs = mysql_query($countrysql))
							{
							 $ind_cnt = mysql_num_rows($countryrs);
							}
							if($ind_cnt>0)
							{
								 While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
								{
									$id = $myrow[0];
									$name = $myrow[1];
									echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
								}
								mysql_free_result($countryrs);
							}
					?></select> </th>
	<th align=left> Acquirer </th>
	<td>
	<SELECT name="acquirerCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
						<OPTION id=0 value="--" selected> ALL </option>
						<?php
							 $countrysql="select countryid,country from country where countryid !=11 ";
								if ($countryrs = mysql_query($countrysql))
								{
								 $ind_cnt = mysql_num_rows($countryrs);
								}
								if($ind_cnt>0)
								{
									 While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
									{
										$id = $myrow[0];
										$name = $myrow[1];
										echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
									}
									mysql_free_result($countryrs);
								}
					?></select> </td>


		<tr><th align=left>  Period </th>
		<th align=left>From&nbsp;&nbsp;<SELECT NAME=month1  style="font-family: Arial; color: #004646;font-size: 8pt">
							 			 <OPTION id=1 value="--" selected> Month </option>
							 			 <OPTION VALUE=1 selected >Jan</OPTION>
							 			 <OPTION VALUE=2>Feb</OPTION>
							 			 <OPTION VALUE=3>Mar</OPTION>
							 			 <OPTION VALUE=4>Apr</OPTION>
							 			 <OPTION VALUE=5>May</OPTION>
							 			 <OPTION VALUE=6>Jun</OPTION>
							 			 <OPTION VALUE=7>Jul</OPTION>
							 			 <OPTION VALUE=8>Aug</OPTION>
							 			 <OPTION VALUE=9>Sep</OPTION>
							 			 <OPTION VALUE=10>Oct</OPTION>
							 			 <OPTION VALUE=11>Nov</OPTION>
							 			<OPTION VALUE=12>Dec</OPTION>
							 			</SELECT>
							 				<SELECT NAME=year1  style="font-family: Arial; color: #004646;font-size: 8pt">
							 				<OPTION id=2 value="--" selected> Year </option>
							 				<?php

							 					$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from mama order by DealDate asc";
							 					if($yearSql=mysql_query($yearsql))
							 					{

							 						While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
							 						{
														$id = $myrow["Year"];
														$name = $myrow["Year"];
														if ($id==$currentyear)
														{
															echo "<OPTION id=". $id. " value=". $id." selected>".$name."</OPTION>\n";
														}
														else
														{
															echo "<OPTION id=". $id. " value=". $id." >".$name."</OPTION>\n";
														}
													}
												}
							 				?> </SELECT> </th>
							 				<td align=center> <b>To </b> </td>
							 			<td>
							 			<SELECT NAME=month2 style="font-family: Arial; color: #004646;font-size: 8pt">
							 			 <OPTION id=3 value="--" selected> Month </option>
							 			 <OPTION VALUE=1>Jan</OPTION>
							 			 <OPTION VALUE=2>Feb</OPTION>
							 			 <OPTION VALUE=3>Mar</OPTION>
							 			 <OPTION VALUE=4>Apr</OPTION>
							 			 <OPTION VALUE=5>May</OPTION>
							 			 <OPTION VALUE=6>Jun</OPTION>
							 			 <OPTION VALUE=7>Jul</OPTION>
							 			 <OPTION VALUE=8>Aug</OPTION>
							 			 <OPTION VALUE=9>Sep</OPTION>
							 			 <OPTION VALUE=10>Oct</OPTION>
							 			 <OPTION VALUE=11>Nov</OPTION>
							 			 <OPTION VALUE=12 selected>Dec</OPTION>
							 			</SELECT>
							 			<SELECT name=year2 style="font-family: Arial; color: #004646;font-size: 8pt">
							 			<OPTION id=4 value="--" selected> Year </option>

							 			<?php
							 			$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from mama order by DealDate asc";
										if($yearSql=mysql_query($yearsql))
										{
											While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
											{
												$id = $myrow["Year"];
												$name = $myrow["Year"];
												if ($id==$currentyear)
												{
													echo "<OPTION id=". $id. " value=". $id." selected>".$name."</OPTION>\n";
												}
												else
												{
													echo "<OPTION id=". $id. " value=". $id." >".$name."</OPTION>\n";
												}
											}
												}
							 			?> </SELECT> </td></tr>

	</tr>
					</table>




		<!--<span style="float:left" class="one">
		<input type="button"  value="Show Aggregate Data" name="showaggregate"  onClick="checkForAggregates();">
		</span>-->
		<br />
		<span style="float:right" class="one">
		<input type="submit"  value="Show Deals " name="showdeals">
		</span> <br /> <br />

		<div id="headingtextproboldfontcolor">Show deals by  <br />  <br /> </div>

                <div id="headingtextprobold">Target Company / Sector &nbsp;
								<img src="../images/arrow.gif" />
				<input type=text name="companysearch" size=39>  <br /> <br /></div>

		<div id="headingtextprobold">Acquirer &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/arrow.gif" />
				<input type=text name="keywordsearch" size=39>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <A href="showallacquirers.php?value=4-1"
				   target="popup" onclick="MyWindow=window.open('showallacquirers.php?value=4-1', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
			   Show All </a>
				 <br /><br /></div>
                 
		<!--	<div id="headingtextprobold">Legal Advisor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/arrow.gif" />
				<input type=text name="advisorsearch_legal" size=39>
                                &nbsp;&nbsp;&nbsp;&nbsp;
				<A href="showalladvisors.php?value=L4-1 "
				   target="popup" onclick="MyWindow=window.open('showalladvisors.php?value=L4-1', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
			   Show All </a>
                             <br /> <br /></div>

                             <div id="headingtextprobold">Transaction Advisor &nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/arrow.gif" />
				<input type=text name="advisorsearch_trans" size=39>
                                &nbsp;&nbsp;&nbsp;&nbsp;
					<A href="showalladvisors.php?value=T4-1 "
				   target="popup" onclick="MyWindow=window.open('showalladvisors.php?value=T4-1', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
			   Show All </a>  
                             <br /> <br /></div>      -->
                           



		<span style="float:right" class="one">
		<input type="submit"  value="Search" name="search">
		</span> <br /> <Br />
	<!--			  <div id="headingtextproboldbcolor">Total Deals - <?php echo $totDeals; ?> worth US $M&nbsp;&nbsp;<?php echo $totDealsAmount; ?>  <br /></div>
	-->


		</div>
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
else
	header( 'Location: '. GLOBAL_BASE_URL .'malogin.php' ) ;
mysql_close();
?>