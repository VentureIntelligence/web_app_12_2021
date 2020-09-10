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
function findCompanies()
{
	document.admin.action="viewlist.php";
	document.admin.submit();
}

function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("DelCompId[]");
        if(e.length>0)
        {
            var del=confirm("Are you sure you want to delete this record?");
        if (del==true){
            for(var i=0;i<e.length;i++)
            {
                    chk=e[i].checked;
            //	alert(chk);
                    if(chk==true)
                    {
                            e[i].checked=true;
                            document.admin.action="delete.php";
                            document.admin.submit();
                            break;
                    }
            }
            if (chk==false)
		{
			alert("Pls select one or more to delete");
			return false;
		}
        } else {
            alert("Record Not Deleted")
        }
        } 
        
	
		
}
</SCRIPT>

<link href="../vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="admin"  method="post" action="" >
<div id="containerproductproducts">

<!-- Starting Left Panel -->
  <div id="leftpanel">

    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>

  <div id="vertbgproproducts">

    	<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
  </div>
		<div id="linksnone">
			<a href="dealsinput.php">Investment Deals</a> | <a href="companyinput.php">Profiles</a> |
			<a href="importtime_cfs.php"> CFs </a>
                 
          	</div>

                  <div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Export</span></div>
		</div>
		<div id="linksnone">
			<a href="exportPECompaniesProfile.php">PECompanies </a> | <a href="exportREcompaniesprofile.php">RECompanies </a>
                </div>
		<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
		</div>
		<div id="linksnone">
			<a href="pegetdatainput.php">Deals / Profile</a><br />
			<a href="peadd.php">Add PE Inv </a> |  <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a> |
         		<A href="peadd_RE.php"> RE Inv</a> | <A href="reipoadd.php"> RE-IPO</a> | <A href="remandaadd.php"> RE-M&A</a><br /> | <a href="remamaadd.php">RE-MA </a> |
			<a href="incadd.php">Inc Add </a> | <A href="angeladd.php">Angel Inv</a> |
			<a href="ui_insert_comp_cfs.php"> CFs </a>
       		</div>

		<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
		</div>
		<div id="linksnone">
			<a href="admin.php">Subscriber List</a><br />
			<a href="addcompany.php">Add Subscriber / Members</a><br />
			<a href="delcompanylist.php">List of Deleted Companies</a><br />
			<!--<a href="delmemberlist.php">List of Deleted Emails</a><br />-->
			<a href="deallog.php">Log</a><br />
		</div>
                <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Admin Report</span></div>
                </div>
                <div id="linksnone">
                        <a href="viewlist.php">View Report</a><br />
                        <a href="addlist.php">Add Report</a><br />
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
                <div id="linksnone"><a href="../adminlogoff.php">Logout</a><br /></div>
    </div> <!-- end of vertbgproducts div-->
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:616px; margin-top:5px;">
	    <div id="maintextpro">
		<?php


			//echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];
			$keyword="";
			$keyword=$_POST['companysearch'];
			$complikesearch = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
			if($complikesearch=="All")
			{
				$nanoSql="select * from nanotool order by date asc";
				if ($reportrs = mysql_query($nanoSql))
				 {
					$report_cnt = mysql_num_rows($reportrs);
				 }
			}
			elseif(($complikesearch!="All") && ($complikesearch<>""))
			{
				$nanoSql="select * from nanotool where titleofReport like '$complikesearch%' order by date asc";
				if ($reportrs = mysql_query($nanoSql))
				 {
					$report_cnt = mysql_num_rows($reportrs);
				 }
			}
			elseif(trim($keyword)!="")
			{
				$nanoSql="select * from nanotool where titleofReport like '%$keyword%' order by date asc";
				if ($reportrs = mysql_query($nanoSql))
				 {
					$report_cnt = mysql_num_rows($reportrs);
				 }
			}
			else
			{
				$nanoSql="select * from nanotool order by date asc";
				if ($reportrs = mysql_query($nanoSql))
				 {
					$report_cnt = mysql_num_rows($reportrs);
				 }
			}
		?>
        <div id="headingtextpro">
				Search by Title &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../images/arrow.gif" />
					<input type=text name="companysearch" size=39> &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button"  value="Find" name="search"  onClick="findCompanies();">
				<br />

			<table border=0 align=center cellspacing=0 cellpadding=3 width=80%>
					<tr style="font-family: Verdana; font-size: 8pt">
					<td><a href="viewlist.php?value=All" > All </a> </td>
					<td> <a href="viewlist.php?value=A">A </a></td>
					<td><a href="viewlist.php?value=B">B </a></td>
					<td><a href="viewlist.php?value=C">C </a></td>
					<td> <a href="viewlist.php?value=D">D </a></td>
					<td> <a href="viewlist.php?value=E">E</a></td>
					<td> <a href="viewlist.php?value=F">F </a></td>
					<td> <a href="viewlist.php?value=G"> G</a></td>
					<td> <a href="viewlist.php?value=H">H </a></td>
					<td> <a href="viewlist.php?value=I">I</a></td>
					<td> <a href="viewlist.php?value=J">J</a></td>
					<td> <a href="viewlist.php?value=K"> K</a></td>
					<td> <a href="viewlist.php?value=L">L</a> </td>
					<td> <a href="viewlist.php?value=M"> M</a></td>
					<td> <a href="viewlist.php?value=N">N </a></td>
					<td> <a href="viewlist.php?value=O">O</a></td>
					<td> <a href="viewlist.php?value=P">P</a></td>
					<td>  <a href="viewlist.php?value=Q">Q</a></td>
					<td> <a href="viewlist.php?value=R">R </a></td>
					<td>  <a href="viewlist.php?value=S">S</a></td>
					<td> <a href="viewlist.php?value=T">T </a></td>
					<td> <a href="viewlist.php?value=U">U</a></td>
					<td> <a href="viewlist.php?value=V">V</a></td>
					<td > <a href="viewlist.php?value=W"> W</a></td>
					<td> <a href="viewlist.php?value=X">X </a></td>
					<td>  <a href="viewlist.php?value=Y">Y </a></td>
					<td>  <a href="viewlist.php?value=Z">Z </a></td>
					</tr>
		</table>

			<div style="width: 542px; height: 300px; overflow: scroll;">
								<table border="1" cellpadding="2" cellspacing="0" width="50%"  >

									<tr style="font-family: Verdana; font-size: 8pt">
                                                                            <th colspan=2 BGCOLOR="#FF6699" >Del</th>
                                                                            <th align=center colspan=2>Type</th>
                                                                            <th align=center colspan=2>Title</th>
                                                                            <th align=center colspan=2>Period</th>
                                                                            <th>PE</th>
                                                                            <th>VC</th>
                                                                            <th>Early Stage</th>
                                                                            <th>M&A</th>
                                                                            <th>RE</th>
                                                                            <th>Infra </th>
                                                                            <th>Social</th>
                                                                            <th>Cleantech</th>
                                                                            <th align=center colspan=2>Date</th>
                                                                            
                                                                            <th align=center colspan=3>Definition</th>
                                                                            <th align=center colspan=2>Edit</th>

										<!--<th> </th> -->
									</tr>

									<?php
										if ($report_cnt>0)
										{
											While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
											{
												$PE="";
												$VC="";
												$Earlystage="";
												$MA="";
												$RE="";
												$Infra="";
												$Social="";
												$Cleantech=""; 
                                                                                                
												if($myrow["ar_PE"]==1)
                                                                                                {
                                                                                                    $PE="checked disabled";
                                                                                                }
                                                                                                else {
                                                                                                    $PE="disabled";
                                                                                                }
													
												if($myrow["ar_VC"]==1)
                                                                                                {
													$VC="checked disabled";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $VC="disabled";
                                                                                                }
												if($myrow["ar_Earlystage"]==1)
                                                                                                {
													$Earlystage="checked disabled";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $Earlystage="disabled";
                                                                                                }
												if($myrow["ar_MA"]==1)
                                                                                                {
													$MA="checked disabled";
                                                                                                }
                                                                                                else {
                                                                                                        $MA="disabled";
                                                                                                }
												if($myrow["ar_RE"]==1)
                                                                                                {
													$RE="checked disabled";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $RE="disabled";
                                                                                                }
												if($myrow["ar_Infra"]==1)
                                                                                                {
													$Infra="checked disabled";
                                                                                                }
                                                                                                else {
                                                                                                    $Infra="disabled";
                                                                                                }
												if($myrow["ar_Social"]==1)
                                                                                                {
													$Social="checked disabled";
                                                                                                }
                                                                                                else
                                                                                                {
                                                                                                    $Social="disabled";
                                                                                                }
												if($myrow["ar_Cleantech"]==1)
                                                                                                {
													$Cleantech="checked disabled";
                                                                                                }
                                                                                                else{
                                                                                                    $Cleantech="disabled";
                                                                                                }
									 ?>
									 			<tr style="font-family: Verdana; font-size: 8pt">

									 			<td align=center colspan=2 BGCOLOR="#FF6699"><input name="DelCompId[]" type="checkbox" value=" <?php echo $myrow["id"]; ?>" ></td>
									
									 			<input type=hidden name="DCompId[]"  value="<?php echo $myrow["id"]; ?>" ></td>
									 			<td align=center colspan=2 > <?php echo $myrow["typeofReport"]; ?></td>
                                                                                                <td align=center colspan=2> <?php echo $myrow["titleofReport"]; ?></td>
                                                                                                <td align=center colspan=2> <?php echo str_replace('_', ' ', $myrow["periodofReport"]); ?></td>
												<td align=center><input name="PEInv[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PE; ?>></td>
												<td align=center><input name="VCInv[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VC; ?> ></td>
												<td align=center><input name="PEIpo[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $Earlystage; ?> ></td>
												<td align=center><input name="VCIpo[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $MA; ?> ></td>
												<td align=center><input name="PEMa[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $RE; ?> ></td>
												<td align=center><input name="VCMa[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $Infra; ?> ></td>
												<td align=center><input name="PEDir[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $Social; ?> ></td>
												<td align=center><input name="CODir[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $Cleantech; ?> ></td>
												<td align=center colspan=2><?php echo $myrow["date"]; ?></td>
                                                                                                
                                                                                                <td align=center colspan=3><?php echo $myrow["definitions"]; ?></td>
                                                                                                <td align=center colspan=2> <a href="editlist.php?id=<?php echo $myrow["id"]; ?>">Edit</a></td>

												</tr>
									<?php
											}
										}
                                                                                else
                                                                                {
                                                                                    echo "No data Found";
                                                                                }
									?>
									</table>
							 </div><br>
								<span style="float:left" class="one">
												<input type="button"  value="Delete" name="updateDelete"  onClick="updateDeletion();">
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