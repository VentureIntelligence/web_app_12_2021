<?php include_once("../../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
	//$companyIdforMem = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$companyIdforMem=$_POST['compId'];
	$companyIdAgainforMem=$_POST['CompIdwhilesubmit'];

	$comp =$_POST['txtaddcompany'];
	$trial=$_POST['txtTrialLogin'];
	if($_POST['txtTrialLogin'])
		{
			$trial=1;
		}
		else
		{
			$trial=0;
		}
	if($_POST['txtMALogin'])
			{
				$MAlogin=1;
			}
			else
			{
				$MAlogin=0;
		}
	if($_POST['txtRELogin'])
	{
		$RElogin=1;
	}
	else
	{
		$RElogin=0;
	}

	if($_POST['txtStudent'])
				{
					$student=1;
				}
				else
				{
					$student=0;
		}
	for ($i=0;$i<=9;$i++)
	{
		$MailArray[i]="";
	}
	$MailArray=$_POST['Mails'];
	$MailArrayLength= count($MailArray);
	//echo "<br>--" .$MailArrayLength;
	$namArray=$_POST['Nams'];
	$PwArray=$_POST['Pwd'];
	if(($companyIdforMem >0) )
	{
		$compName="";
		$expDate="";
		$insMemberSql="";
		$MailtoInsert="";
		$NametoInsert="";
		$PwdtoInsert="";

		echo "<br>Adding for  companyid~~~" .$companyIdforMem;
		$getcompNameSql = "select DCompanyName,ExpiryDate,REInv from dealcompanies where DCompId=$companyIdforMem";
		if ($rsGetComp=mysql_query($getcompNameSql))
		{
			While($myrow=mysql_fetch_array($rsGetComp, MYSQL_BOTH))
			{
				$compName=$myrow["DCompanyName"];
				$expDate=$myrow["ExpiryDate"];
				$relogindbvalue=$myrow["REInv"];
				if($relogindbvalue==1)
					{
						$RElogin=1;
						$Reloginflagvalue="checked";
					}
				else
					{
						$RElogin=0;
						$Reloginflagvalue="";
					}

			}
		}
	}
	if($companyIdAgainforMem >0)
	{
		echo "<br>Array length---" .$MailArrayLength;
			if($MailArrayLength>0)
			{
				//echo "<br>--";
				for ($i=0;$i<=$MailArrayLength-1;$i++)
				{
					$MailtoInsert = trim($MailArray[$i]);
					$NametoInsert= trim($namArray[$i]);
					$PwdtoInsert= trim($PwArray[$i]);
					$deleted=0;
					if((trim($MailtoInsert) !="") && (trim($NametoInsert)!="") && (trim($PwdtoInsert)!=""))
					{
						if($MAlogin==1)
						{
							$insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
							($companyIdAgainforMem,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
							echo "<br>Ins MA Lgoin For new-" .$insMemberSql;
						}
						elseif($RElogin==1)
						{
							$insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
							($companyIdAgainforMem,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
							echo "<br>Ins RE Lgoin For new-" .$insMemberSql;
						}
						else
						{
						$insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
							($companyIdAgainforMem,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
						echo "<br>Ins Memb For existing-" .$insMemberSql;
						}
						if ($rsMemberinsert = mysql_query($insMemberSql))
						{
						}
					} //if loop for empty row ends
				} //for i loop ends
				} // if array count loop ends
	}
	elseif((trim($comp)!="") && ($companyIdAgainforMem <=0))
	{
		$compName="";
		$expDate="";

		$dts =$_POST['date'];
		$ExpiryDate= strtotime($dts);
		$ExpiryDate = date("Y-m-d", $ExpiryDate);
		$DCompId=0;
		$DCompId=rand();
			$insSql= "insert into dealcompanies(DCompId,DCompanyName,Deleted,ExpiryDate,TrialLogin,Student,REInv) values
							($DCompId,'$comp',0,'$ExpiryDate',$trial,$student,$RElogin)";
			//echo "<Br> Insert company-" .$insSql;
			if ($rsinsert = mysql_query($insSql))
			{
				if($MailArrayLength>0)
				{
					for ($i=0;$i<=$MailArrayLength-1;$i++)
					{
						$MailtoInsert = trim($MailArray[$i]);
						$NametoInsert= trim($namArray[$i]);
						$PwdtoInsert= trim($PwArray[$i]);
						$deleted=0;
						if((trim($MailtoInsert) !="") && (trim($NametoInsert)!="") && (trim($PwdtoInsert)!=""))
						{
							if($MAlogin==1)
							{
								$insMemberSql= "insert into malogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
								($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
								echo "<br>Ins MA Lgoin For new-" .$insMemberSql;
							}
							elseif($RElogin==1)
							{
								$insMemberSql= "insert into RElogin_members(DCompId,EmailId,Passwrd,Name,Deleted) values
								($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
								echo "<br>Ins RE Login For new-" .$insMemberSql;
							}
							else
							{
								$insMemberSql= "insert into dealmembers(DCompId,EmailId,Passwrd,Name,Deleted) values
								($DCompId,'$MailtoInsert','$PwdtoInsert','$NametoInsert',$deleted)";
							}
//
							if ($rsMemberinsert = mysql_query($insMemberSql))
							{
							//	echo "<br>---deal members inserted--";
							}
						} //if loop for empty row ends
					} //for i loop ends
				} // if array count loop ends
			} // record set loop ends
	} //elseif loop ends
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<!-- calendar stylesheet -->
  <link rel="stylesheet" type="text/css" media="all" href="calendar-win2k-cold-1.css" title="win2k-cold-1" />

	<style type="text/css">@import url(calendar-win2k-1.css);</style>

  <!-- main calendar program -->
  <script type="text/javascript" src="calendar.js"></script>

  <!-- language for the calendar -->
  <script type="text/javascript" src="lang/calendar-en.js"></script>

  <!-- the following script defines the Calendar.setup helper function, which makes
       adding a calendar a matter of 1 or 2 lines of code. -->
  <script type="text/javascript" src="calendar-setup.js"></script>

<SCRIPT LANGUAGE="JavaScript">
function ExporttoExel()
{
	//alert(document.companydelete.txtTrialLogin.checked);
	//alert(document.companydelete.txtStudent.checked);
	if(document.companydelete.txtStudent.checked==true)
	{
		document.companydelete.txtStudent.checked=false;
	}
}

function Student()
{
	if(document.companydelete.txtTrialLogin.checked==true)
	{
		document.companydelete.txtTrialLogin.checked=false;
	}
}

</SCRIPT>

<link href="../vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="companydelete"  method="post" action="addcompany.php" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">

    		<div id="vertMenu">
				        	<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
				      	</div>
				      	<div id="linksnone"><a href="dealsinput.php">Investment Deals</a><br />
				          <span id="visitlink">
				          <a href="companyinput.php"> Profiles</a><br />
				          </span>
						</div>

			<div id="vertMenu">
										<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
									</div>
									<div id="linksnone"><a href="pegetdatainput.php">Deals / Profile</a><br />
													<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a><br />

		</div>
				<div id="vertMenu">
							<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
						</div>
						<div id="linksnone">
							<a href="admin.php">Subscriber List</a><br />
							<a href="addcompany.php">Add Subscriber / Members</a><br />
							<a href="delcompanylist.php">List of Deleted Companies</a><br />
							<a href="delmemberlist.php">List of Deleted Emails</a><br />
							<a href="deallog.php">Log</a><br />
		</div>
                   <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Admin Report</span></div>
                </div>
                <div id="linksnone">
                        <a href="viewlist.php">View Report</a><br />
                        <a href="addlist.php">Add Report</a><br />
                        <!--a href="delcompanylist.php">List of Deleted Companies</a><br />
                        <a href="delmemberlist.php">List of Deleted Emails</a><br />
                        <a href="deallog.php">Log</a><br /-->
		</div>
                <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Fund Raising</span></div>
                </div>
                <div id="linksnone">
                    <a href="fundlist.php">View Funds</a><br />
                    <a href="addfund.php">Add Fund</a><br />
		</div>
				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
				</div>
				<div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:616px; margin-top:4px;">

	    <div id="maintextpro">
	    <div id="headingtextpro">

	   		<input type="hidden" name="CompIdforMembers" value="<?php echo $companyIdforMem; ?>" >
	   		<input type="hidden" name="CompIdwhilesubmit" value="<?php echo $companyIdforMem; ?>" >
			<input type=checkbox name="txtMALogin"> Merger & Acquistion Login
			&nbsp;&nbsp;
			<input type=checkbox name="txtRELogin" <?php echo $Reloginflagvalue; ?> > RE Login
			&nbsp;&nbsp;
			<input type=checkbox name="txtTrialLogin"  onclick="ExporttoExel()">
			 Export To Excel &nbsp;&nbsp;

			<input type=checkbox name="txtStudent"  onclick="Student()">
			Student

			<br />
			<br />
			Company&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/arrow.gif" />
			<input type=text name="txtaddcompany" size=39 value="<?php echo $compName; ?>"> <br /> <br />

			Expiry Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/arrow.gif" />
			<input type="text" name="date" value="<?php echo $expDate; ?>" size="20">(yyyy-mm-dd) <br />




			<!--id="f_date_c" readonly="1" value="" size="20" />
				<img src="img.gif" id="f_trigger_c" style="cursor: pointer; border: 1px solid red;" title="Date selector"
	             onmouseover="this.style.background='red';" onmouseout="this.style.background=''" />
				-->
			
                                
								
	        Add Members :  <Br />
	        <div id="headingtextprosmallfont">(Note: All fields are manadatory. Please provide Email, Name, Pasword resp. )</div>

	        <div style="width: 542px; height: 240px; overflow: scroll;">
			<table border="1" align=left cellpadding="2" cellspacing="0" width="70%"  >
			<tr style="font-family: Verdana; font-size: 8pt">
						<th> Email</th>
						<th >Name</th>
						<th>Password</th>
			</tr>
		<?php
			for ($counter = 0; $counter <= 9; $counter += 1)
			{
		?>
	        <tr><td><input type=text name="Mails[]"  value=""> </td>
	        	<td><input type=text name="Nams[]" value=""></td>
	        	<td><input type=text name="Pwd[]" value=""></td>
			</tr>

		<?php
			}
		?>
			</table>

			<span style="float:right" class="one">
			<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
			<input type="submit"  value="Add" name="compadd" >
			</span></div>

		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../../js/bottom1.js"></SCRIPT>
   </form>


<script type="text/javascript">
      Calendar.setup({
          inputField     :    "f_date_c",     // id of the input field
          ifFormat       :    "%B %e, %Y",      // format of the input field
          button         :    "f_trigger_c",  // trigger for the calendar (button ID)
          align          :    "Tl",           // alignment (defaults to "Bl")
          singleClick    :    true
      });
</script>

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
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>