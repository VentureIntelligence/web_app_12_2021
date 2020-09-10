<?php include_once("../../globalconfig.php"); ?>
<?php
/*
filename - ipoinput.php
formname-ipo
invoked from - peauthenticate.php,deals/dealhome.php
invoked to - ipoview.php

*/
 require("../dbconnectvi.php");
 $Db = new dbInvestments();
	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	$username=$_SESSION['UserNames'];
			$emailid=$_SESSION['UserEmail'];
                        $companyId=632270771;
                        $compId=0;

	$currentyear = date("Y");
	$VCFlagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	if($VCFlagValue==0)
	{
		$addVCFlagqry = "";
		$pagetitle="PE-backed IPOs-> Search";
		$companyFlag=3;
	}
	elseif($VCFlagValue==1)
	{
		$addVCFlagqry = " and VCFlag=1";
		$pagetitle="VC-backed IPOs-> Search";
		$companyFlag=4;
	}

		 if ((session_is_registered("UserNames")) )
		 {
			$sesID=session_id();
			//echo "<br>peinput session id--" .$sesID;
     
			$getTotalQuery = "select count(IPOId) as totaldeals,sum(IPOSize)as totalamount 	from ipos where Deleted=0" .$addVCFlagqry ;
			if ($totalrs = mysql_query($getTotalQuery))
			{
			 While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
			   {
					$totDeals = $myrow["totaldeals"];
					$totDealsAmount = $myrow["totalamount"];
				}
			}

		$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
					where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
				//	echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$compId=$trialrow["compid"];
				}
			}
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
	document.ipo.hiddenbutton.value='Aggregate';
	document.ipo.submit();
}
  //' Allow user to enter only numbers  , - (minus) and .(dot) eg. -1.2
 function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode
             alert(charCode);
             if (((charCode > 47) && (charCode < 58 ) ) || (charCode == 8) ||(charCode==45) || (charCode==46))
              {     return true;}
             else {  return false; }
          }
function isless()
//' do not submit if to < than from
           {

             var num1 = document.ipo.txtmultipleReturnFrom.value;
             var num2 = document.ipo.txtmultipleReturnTo.value;

             var x  = parseInt( num1  ,  10  )
             var y  = parseInt( num2  ,  10  )
             if(x > y)
                { 
                  alert("Please enter valid range");
                  return false;
                }

           }

function checkFields()
 {
 	var selection = false;
 	var keyselection=false;
 //alert(document.ipo.industry.selectedIndex);
  if ((document.ipo.keywordsearch.value  != '') || (document.ipo.companysearch.value != ''))
    	  keyselection=true;
if (!keyselection)
{
  if (document.ipo.industry[document.ipo.industry.selectedIndex].value > 0)
   {
   	//alert ("comapny selected index > 0");
  	selection=true;
   }

 }
 	if((keyselection == true ) || (selection==true))
 		  {
 		  //	alert ("insie true");
 		   return true;
 		  // alert (selection);
 		  }
 	else
 		{
 		  alert("Search using keyword or choose inputs");
 		        return false;
		}
}
</SCRIPT>

<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body oncontextmenu="return false;" >
<form name="ipo" onSubmit="isless();"  method="post" action="ipoviewReturn.php" >
<div id="containerproductipoinput">

<input type="hidden" name="txtvcFlagValue" value="<?php echo $VCFlagValue; ?>");
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="../index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproipoinput">

    	<div id="vertMenu">
			<div>Welcome  &nbsp;&nbsp;<?php echo $UserNames; ?> <br/ ><br /></div>

			<div><a href="changepassword.php?value=P"">Change your Password </a> <br /><br /></div>
			<div><a href="dealhome.php">Database Home</a> <br /><br /></div>

			<div><a href="../logoff.php">Logout </a> <br /><br /></div>
	   	</div>


    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
  <!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
    <SCRIPT>
     call()
     </script>-->

  	<div style="width:565px; float:left; padding-left:2px;">

  	  <div style="background-color:#FFF; width:565px; height:446px; margin-top:0px;">
  	    <div id="maintextpro">
        <div id="headingtextpro">
     	<div id="headingtextproboldfontcolor"> <?php echo $pagetitle; ?>  <br />  <br /> </div>

		<input type="hidden" name="hiddenbutton" value ="">

		<div id="headingtextprobold">Industry&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/arrow.gif" />
		<SELECT name="industry" style="font-family: Arial; color: #004646;font-size: 8pt">
  		<OPTION id=0 value="--" selected> ALL  </option>
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
    		?></select>  <br />
  		</div>


                  	<div id="headingtextprobold">Investor Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<img src="../images/arrow.gif" />
								<SELECT NAME="invType" style="font-family: Arial; color: #004646;font-size: 8pt">
						 <OPTION id=5 value="--" selected> ALL </option>
						 <?php
							/* populating the investortype from the investortype table */
							$invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
								if ($invtypers = mysql_query($invtypesql))
								{
							   $invtype_cnt = mysql_num_rows($invtypers);
								}
							  if($invtype_cnt >0)
							{
							 While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
							{
								$id = $myrow["InvestorType"];
								$name = $myrow["InvestorTypeName"];
								 echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
							}
						 mysql_free_result($invtypers);
						}
					?>
						 </SELECT>
						 &nbsp;&nbsp;
						 <img id="the_image"
						border="0" src="tool.jpg" width="20" height="20"
						target="popup" onclick="ToolWindow=window.open('toolinvestortype.php', 'popup', 'width=500,height=150,status=no');ToolWindow.focus(top);return false">
                                 <br />
				 </div>



                       	<div id="headingtextprobold">Investor Sale in IPO?<sup> * </sup>&nbsp;
								<img src="../images/arrow.gif" />
								<SELECT NAME="invSale" style="font-family: Arial; color: #004646;font-size: 8pt">
						 <OPTION  value="--" selected> Select </option>
						 <OPTION  value="1"> Yes </option>
						 <OPTION  value="0"> No </option>
                                        	 </SELECT>
                           	 </div>
                           <div id="headingtextprosmallfont">* (Select Yes to include only IPOs in which the PE investors sold shares)</div>  <br />

                           <div id="headingtextprobold">Exit Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<img src="../images/arrow.gif" />
								<SELECT NAME="exitstatus" style="font-family: Arial; color: #004646;font-size: 8pt">
						 <OPTION  value="--" selected> Both </option>
						 <OPTION  value="0"> Partial </option>
						 <OPTION  value="1"> Complete </option>
                                        	 </SELECT> <br /><br />
                           	 </div>
                           <div id="headingtextprobold">Return Multiple &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="../images/arrow.gif" />
			   From <input type"text" name="txtmultipleReturnFrom" onkeypress="return isNumberKey(event)" value="" size=2 > &nbsp; To
                                <input type"text" name="txtmultipleReturnTo" value="" size=2 onkeypress="return isNumberKey(event)"> <br />
                           </div><br />


	<div id="headingtextprobold">Period&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/arrow.gif" />
				<SELECT NAME=month1 style="font-family: Arial; color: #004646;font-size: 8pt" >
			 <!--<OPTION id=1 value="--" selected> Month </option> -->
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
				<SELECT NAME=year1 style="font-family: Arial; color: #004646;font-size: 8pt">
			<!--	<OPTION id=2 value="--" selected> Year </option> -->
				<?php

				/*$i=2004;
						While($i<= $currentyear )
						{
						$id = $i;
						$name = $i;
						if ($id==$currentyear)
						{
							echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
						}
						else
						{
							echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
						}
						$i++;
						}*/
					$yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from ipos order by IPODate asc";
							if($yearSql=mysql_query($yearsql))
							{
								While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
								{
									$id = $myrow["Year"];
									$name = $myrow["Year"];
									echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
								}

							}
				 ?> </SELECT>
			<SELECT NAME=month2 style="font-family: Arial; color: #004646;font-size: 8pt">
			<!-- <OPTION id=3 value="--" selected> Month </option> -->
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
			<!--<OPTION id=4 value="--" selected> Year </option> -->

			<?php
				$yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from ipos order by IPODate asc";
							if($yearSql=mysql_query($yearsql))
							{
								While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
								{
									$id = $myrow["Year"];
									$name = $myrow["Year"];
									echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
								}

							}
				?> </SELECT>
			</div> <br />
	<!--	<span style="float:left" class="one">
				<input type="button"  value="Show Aggregate Data" name="showaggregate"  onClick="checkForAggregates();">
				</span> -->

				<span style="float:right" class="one">
				<input type="submit"  value="Show Deals " name="showdeals">
				</span> <br /> <br />

     	<div id="headingtextproboldfontcolor">Search by  <br /> <br /></div>

			<div id="headingtextprobold">Investor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../images/arrow.gif" />
					<input type=text name="investorsearch" size=39>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<A href="showallinvestors.php?value=2-<?php echo $VCFlagValue;?> "
			   target="popup" onclick="MyWindow=window.open('showallinvestors.php?value=2-<?php echo $VCFlagValue;?>', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
			   Show All
				</A>

					<br /><br /> </div>
			<div id="headingtextprobold">Company &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<img src="../images/arrow.gif" />
					<input type=text name="companysearch" size=39>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

					<A href="showallcompanies.php?value=<?php echo $companyFlag;?> "
			   target="popup" onclick="MyWindow=window.open('showallcompanies.php?value=<?php echo $companyFlag;?>', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
			   Show All </a> <br /><br /></div>

			<!--<div id="headingtextprobold">Advisor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../images/arrow.gif" />
					<input type=text name="advisorsearch" size=39>  <br /> <br /></div> -->

			<div id="headingtextprobold">Search More Info &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
																		<img src="../images/arrow.gif" />
										<input type=text name="searchallfield" size=39> &nbsp;&nbsp;&nbsp;&nbsp;

					 </div>


			<span style="float:right" class="one">
			<input type="submit"  value="Search" name="search">
			</span> <br /><br />


		 	<?php
		 		if($exportToExcel==1)
		 		{
		 		?>
		 			<div id="headingtextproboldbcolor">Total Deals - <?php echo $totDeals; ?> worth &nbsp;&nbsp;<?php echo $totDealsAmount; ?>  &nbsp;&nbsp; (US $M)<br /></div>
		 		<?php
		 		}
		 		else
		 		{
		 		?>
		 		<!--	<div id="headingtextproboldcolornormalfont">&nbsp;Paid Subscribers will be displayed aggregate data for the search result both No. of Deals and Value here. <br /></div>-->

		 		<?php
		 		}
			?>


		</div>
		        </div> <!-- end of maintext pro-->
			  </div>
			  </div>
			</div>
		  </div>
		  <!-- Ending Work Area -->

		</div>
		   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../../js/bottom1.js"></SCRIPT>
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
	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
?>