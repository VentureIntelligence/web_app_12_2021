<?php include_once("../../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function findEmails()
{
	document.members.action="delmemberlist.php";
	document.members.submit();
}

function activateEmails()
{
	var chk;
	var e=document.getElementsByName("ActEmail[]");
	for(var i=0;i<e.length;i++)
	{
		chk=e[i].checked;
	//	alert(chk);
		if(chk==true)
		{
			e[i].checked=true;
			document.members.action="activatemembers.php";
			document.members.submit();
			break;
		}
	}
		if (chk==false)
		{
			alert("Pls select one or more to make active");
			return false;
		}
}
</SCRIPT>

<link href="../vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="members"  method="post" action="" >
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
				  <a href="companyinput.php">Company Profile</a><br />
				  </span>
				  <a href="investorinput.php">Investor Profile</a><br />
				</div>
					<div id="vertMenu">
						<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
					</div>
					<div id="linksnone"><a href="pegetdatainput.php">Investments</a><br />
					<a href="pegetdatainput.php">Company / Investor Profile</a><br />

				</div>

				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Companies</span></div>
				</div>
				<div id="linksnone"><a href="admin.php">Company List</a><br />
				  <span id="visitlink">
				  <a href="addcompany.php">Add Company / Members</a><br />
				  </span>
				  <a href="delcompanylist.php">List of Deleted Companies</a><br />
		          <a href="delmemberlist.php">List of Deleted Emails</a><br />
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
		<?php
			$keyword="";
			$keyword=$_POST['emailsearch'];
			if(trim($keyword)!="")
			{
				$getMembersSql ="Select Name,EmailId,Passwrd from dealmembers where Deleted=1 and EmailId like '$keyword%' ";
				if ($companyrs = mysql_query($getMembersSql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }
			}
			else
			{
				$getMembersSql ="Select Name,EmailId from dealmembers where Deleted=1 ";
				if ($companyrs = mysql_query($getMembersSql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }
			}
		?>
        <div id="headingtextpro">
       		 Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<img src="../images/arrow.gif" />
								<input type=text name="emailsearch" size=39><br />
				<span style="float:right" class="one">
				<input type="button"  value="Search" name="search"  onClick="findEmails();">
				</span>
			<Br /><br />
			Following are the list of deleted Emails. To activate, please select and press 'Activate' button. <br /><br />


				<div style="width: 542px; height: 240px; overflow: scroll;">
					<table border="1" cellpadding="2" cellspacing="0" width="60%"  >
					<tr style="font-family: Verdana; font-size: 8pt">
					<th BGCOLOR="#FF6699" >Activate</th>
						<th>Email</th>
						<th >Name</th>

					</tr>

					<?php
						if ($company_cnt>0)
						{
							While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
					 ?>
					 			<tr style="font-family: Verdana; font-size: 8pt">
					 			<td align=center  BGCOLOR="#FF6699"><input name="ActEmail[]" type="checkbox" value=" <?php echo $myrow["EmailId"]; ?>" >
					 			<td>  <?php echo $myrow["EmailId"]; ?>
					 			<td>  <?php echo $myrow["Name"]; ?>
								</td>
								</tr>
					<?php
							}
						}
					?>
					</table>
				</div>

				<span style="float:right" class="one">
				<input type="button"  value="Activate" name="makeActivateMember"  onClick="activateEmails();">
				</span>

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