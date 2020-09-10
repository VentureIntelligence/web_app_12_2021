<?php include_once("../globalconfig.php"); ?>
<?php
/*
filename - pedir.php
formname-pedir
invoked from - dealhome.php
//action="pedirview.php"
*/
 session_save_path("/tmp");
session_start();
$dirFlagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
$currentyear = date("Y");
require("../dbconnectvi.php");
	$Db = new dbInvestments();

		if($dirFlagValue==0)
		{
			/*$getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount, count( pec.PECompanyid )
			FROM peinvestments AS pe, pecompanies AS pec
			WHERE pe.Deleted =0
			AND pec.PECompanyId = pe.PECompanyId
			AND pec.industry !=15";
		*/
			$pagetitle="PE Directory -> Search";
			$stagesql = "select StageId,Stage from stage ";
		}
		elseif($dirFlagValue==1)
		{
		   /*$getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
			FROM peinvestments AS pe, stage AS s ,pecompanies as pec
			WHERE s.VCview =1 and  pe.amount<=20 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId";
		*/
			$pagetitle="VC Directory -> Search";
			$stagesql = "select StageId,Stage from stage where VCview=1 ";
			//echo "<Br>---" .$getTotalQuery;
		}
		/*elseif($VCFlagValue==2)
		{
			$getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
			FROM peinvestments AS pe, pecompanies AS pec
			WHERE pec.Industry =15
			AND pe.PEcompanyID = pec.PECompanyId ";
			$pagetitle="PE Investments - Real Estate -> Search";
			$stagesql="";
		}*/


if ((session_is_registered("UserNames")) )
		{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence - Private Equity, Venture Capital and M&A deals in India</title>
<SCRIPT LANGUAGE="JavaScript">
 function checkRange()
{
  if((document.pedir.invrangestart.value!="") && (document.pedir.invrangeend.value!=""))
  {
	if((document.pedir.invrangestart.value >=0) && (document.pedir.invrangeend.value >0))
	{
          if((parseFloat(document.pedir.invrangestart.value)) > (parseFloat(document.pedir.invrangeend.value)))
	   {
            //alert(parseFloat(document.pedir.invrangestart.value));
            //alert(parseFloat(document.pedir.invrangeend.value));
            alert("Please check the Range provided");
            }
	  else
          {
             document.pedir.action="pedirview1.php";
	     document.pedir.submit();
          }
        }
        else
         {alert("Please check the Range provided"); }
}
 else
 {
             document.pedir.action="pedirview.php";
	     document.pedir.submit();
          }

}
function onSubmit()
{
   document.pedir.action="pedirview.php";
	     document.pedir.submit();
}

</SCRIPT>

<link href="../css/style_root.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="pedir"  method="post" >
<div id="containerproductpedir">
<input type="hidden" name="txtdirvalue" value="<?php echo $dirFlagValue; ?>");

<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="../index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropedir">
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
 <!--  <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>-->

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:495px; margin-top:0px;">

	    <div id="maintextpro">

        <div id="headingtextpro">
     	<div id="headingtextproboldfontcolor"> <?php echo $pagetitle; ?> <br />  <br /> </div>
		<input type="hidden" name="hiddenbutton" value ="">

		<div id="headingtextprobold">Industry&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/arrow.gif" />
		<SELECT name="industry" style="font-family: Arial; color: #004646;font-size: 8pt">
  		<OPTION id=0 value="--" selected> Choose Industry  </option>
		<?php
			 $industrysql="select industryid,industry from industry where industryid !=15 order by industry";
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
    		?></select> <br /><br />
		</div>

		<?php

					if($VCFlagValue <2)
					{


				?>
					 <table border=0>
                                          <tr><th clospan=3 valign=top> Stage &nbsp;&nbsp;&nbsp;
                                           <img id="the_image"
					border="0" src="tool.jpg" width="20" height="20"
					<?php
					if($VCFlagValue==0)
                                        {
                                        ?>
						target="popup" onclick="ToolWindow1=window.open( 'toolstage.php', 'popup', 'scrollbars=1,width=600,height=450,status=no');ToolWindow1.focus(top);return false">
					<?php
                                        }
                                        elseif($VCFlagValue==1)
                                        {
                                        ?>
                                                target="popup" onclick="ToolWindow1=window.open( 'toolvcstage.php', 'popup', 'scrollbars=1,width=600,height=300,status=no');ToolWindow1.focus(top);return false">
                                         <?php
                                        }
                                        ?>

                                          </th>

					<?php

						if ($stagers = mysql_query($stagesql))
						{
						  $stage_cnt = mysql_num_rows($stagers);
						}
						if($stage_cnt > 0)
						 {
                                                    $i=1;
                                                 ?>
                                                 <td><table border=0>
                                                 <?php
							 While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
							{
                                                           $firstaddtag="<tr>";
                                                           $firstclosetag="</tr>";
								if($i>4)
								{
                                                                  $i=1;
                                                                  $addtag="<tr>";
                                                                  $closetag="</tr>";

                                                                  }
                                                                  else
                                                                  {

                                                                  $addtag="";
                                                                  $closetag="";
                                                                  $firstaddtag="";
                                                                  $firstclosetag="";
                                                                  }
                                                                $id = $myrow[0];
								$name = $myrow[1];
                                                                if($i<=4)
								{
                                                                     if($i==1)
                                                                     echo $addtag;
                                                               ?>

                                                                   <td>&nbsp;&nbsp;<input type=checkbox name=stage[] value=<?php echo $id;?> checked ><?php echo $name;?> </td>
								<?php
                                                                    $i=$i+1;
                                                                    if($i==4)
                                                                      echo $closetag;
							        }


                                                          }
				                         mysql_free_result($stagers);
						 ?>
						 </table></td>

						 </tr></table>
						 <?php
						}
                                           }
		   ?>


  		<div id="headingtextprobold">Investor Type &nbsp;
						<img src="../images/arrow.gif" />
						<SELECT NAME="invType" style="font-family: Arial; color: #004646;font-size: 8pt">
				 <OPTION id=5 value="--" selected> Choose Investor Type </option>
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
				 </SELECT><br /><br />
				 </div>


                     <div id="headingtextprobold">Firm Type &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<img src="../images/arrow.gif" />
						<SELECT NAME="firmtype" style="font-family: Arial; color: #004646;font-size: 8pt">
				 <OPTION value==0 selected> Choose Firm Type </option>
				 <?php
					/* populating the firmtype from the firmtypes table */
					$firmtypesql = "select FirmTypeId,FirmType from firmtypes ";
					if ($firmtypers = mysql_query($firmtypesql))
					{
					  $firmtype_cnt = mysql_num_rows($firmtypers);
					}
					if($firmtype_cnt > 0)
					{
					While($myftrow=mysql_fetch_array($firmtypers, MYSQL_BOTH))
						{
							$id = $myftrow[0];
							$name = $myftrow[1];
						        echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
						}
						mysql_free_result($firmtypers);
					}
				 mysql_free_result($firmtypers);
				?>
			       </select> <br />   <br />
				 </div>

                                 <div id="headingtextprobold">Focus & <br />Capital Source
						<img src="../images/arrow.gif" />
						<SELECT NAME="focuscapitalsource" style="font-family: Arial; color: #004646;font-size: 8pt">
				 <OPTION value==0 selected> Choose Capital Source </option>
				 <?php
					/* populating the focus capital source from the table */
					$foucscapitalsql = "select focuscapsourceid,focuscapsource from focus_capitalsource ";
					if ($foucscapitalrs = mysql_query($foucscapitalsql))
					{
					  $focus_cap_cnt = mysql_num_rows($foucscapitalrs);
					}
					if($focus_cap_cnt > 0)
					{
						While($myfoccaprow=mysql_fetch_array($foucscapitalrs, MYSQL_BOTH))
						{
							$id = $myfoccaprow[0];
							$name = $myfoccaprow[1];
						        echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
						}
						mysql_free_result($foucscapitalrs);
					}
                                				?>
			       </select> <br />   <br />
				 </div>

				    <div id="headingtextprobold">Deal Range<br />	(US $M)
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="../images/arrow.gif" />

			  <input align="right" type="text" value="" name="invrangestart" size="5" > To
			  <input align="right" type="text" value="" name="invrangeend" size="5" ">

			</div> <br />

		<div id="headingtextprobold">Bet Dates&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<img src="../images/arrow.gif" />
				<SELECT NAME=month1  style="font-family: Arial; color: #004646;font-size: 8pt">
			 <OPTION id=1 value="--" selected> Month </option>
			 <OPTION VALUE=1 selected>Jan </OPTION>
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

				$i=1998;
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
				}
				?> </SELECT>
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
			$endYear=1998;
			While($endYear<= $currentyear )
			{
				$ids=$endYear;
				if($ids==$currentyear)
				{
					echo "<OPTION id=". $endYear. "value=". $endYear." selected>".$endYear."</OPTION>\n";
				}
				else
				{
					echo "<OPTION id=". $endYear. "value=". $endYear." >".$endYear."</OPTION>\n";
				}

			$endYear++;
			}
			?> </SELECT>
			</div> <br />

			<span style="float:right" class="one">
							<input type="button"  value="Search" name="search" onClick="checkRange();">
							</span> <br /> <Br />



     	<div id="headingtextproboldfontcolor">Search by   <br /> </div>

				<div id="headingtextprobold">Investor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<img src="../images/arrow.gif" />
						<input type=text name="keywordsearch" size=39> &nbsp;&nbsp;&nbsp;&nbsp;
						<A href="showallinvestors.php?value=1-<?php echo $dirFlagValue;?> "
					   target="popup" onclick="MyWindow=window.open('showallinvestors.php?value=1-<?php echo $dirFlagValue;?>', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
					   Show All
				</A>
					<br /> </div>


				<span style="float:right" class="one">
				<input type="button"  value="Search" name="search" onClick="onSubmit();" >
				</span> <br /> <Br />


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

} // if resgistered loop ends
else
header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;

?>