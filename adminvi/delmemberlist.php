<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    require("checkaccess.php");
    checkaccess( 'subscribers' );
    session_save_path("/tmp");
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

<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="members"  method="post" action="" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
    <?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; /*height:542px;*/ margin-top:4px;" class="main_content_container">
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


				<div style="width: 542px; /*height: 240px;*/ overflow: scroll;" class="content_container">
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
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>