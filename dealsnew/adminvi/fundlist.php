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

<script type="text/javascript">

function findFunds()
{
	document.admin.action="fundlist.php";
	document.admin.submit();
}

function updateDeletion()
{
var chk;
var e=document.getElementsByName("DelFundId[]");
    if(e.length>0)
    {
        var del=confirm("Are you sure you want to delete this record?");
        if (del==true){
            for(var i=0;i<e.length;i++){
                chk=e[i].checked;
                //alert(chk);
                if(chk==true){
                        e[i].checked=true;
                        document.admin.action="deletefund.php";
                        document.admin.submit();
                        break;
                }
            }
            if (chk==false){
                    alert("Pls select one or more to delete");
                    return false;
            }
        } else{
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
		<div id="headingtextpro">
				Search Fund &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../images/arrow.gif" />
					<input type=text name="srcfundName" size="39"> &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="button"  value="Find" name="search"  onClick="findFunds();">
				<br />

			<table border=0 align=center cellspacing=0 cellpadding=3 width=100%>
					<tr style="font-family: Verdana; font-size: 8pt">
					<td><a href="fundlist.php?value=All" > All </a> </td>
					<td> <a href="fundlist.php?value=A">A </a></td>
					<td><a href="fundlist.php?value=B">B </a></td>
					<td><a href="fundlist.php?value=C">C </a></td>
                                        <td> <a href="fundlist.php?value=D">D </a></td>
                                        <td> <a href="fundlist.php?value=E">E</a></td>
                                        <td> <a href="fundlist.php?value=F">F </a></td>
                                        <td> <a href="fundlist.php?value=G"> G</a></td>
                                        <td> <a href="fundlist.php?value=H">H </a></td>
                                        <td> <a href="fundlist.php?value=I">I</a></td>
                                        <td> <a href="fundlist.php?value=J">J</a></td>
                                        <td> <a href="fundlist.php?value=K"> K</a></td>
                                        <td> <a href="fundlist.php?value=L">L</a> </td>
                                        <td> <a href="fundlist.php?value=M"> M</a></td>
                                        <td> <a href="fundlist.php?value=N">N </a></td>
                                        <td> <a href="fundlist.php?value=O">O</a></td>
                                        <td> <a href="fundlist.php?value=P">P</a></td>
                                        <td>  <a href="fundlist.php?value=Q">Q</a></td>
                                        <td> <a href="fundlist.php?value=R">R </a></td>
                                        <td> <a href="fundlist.php?value=S">S</a></td>
                                        <td> <a href="fundlist.php?value=T">T </a></td>
                                        <td> <a href="fundlist.php?value=U">U</a></td>
                                        <td> <a href="fundlist.php?value=V">V</a></td>
                                        <td> <a href="fundlist.php?value=W"> W</a></td>
                                        <td> <a href="fundlist.php?value=X">X </a></td>
                                        <td> <a href="fundlist.php?value=Y">Y </a></td>
					<td> <a href="fundlist.php?value=Z">Z </a></td>
                                        
					</tr>
                        </table>

                        <div style="width: 542px; height: 300px; overflow: scroll;">
                                <table border="1" cellpadding="2" cellspacing="0" id="fundtab">

                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <th BGCOLOR="#FF6699" >Del</th>
                                            <th align=center >Fund Name</th>
                                            <th align=center >Fund Manager</th>
                                            <th align=center >Investor</th>
                                            <th colspan="2" width="200px">Type <br>(Stage | Industry)</th>
                                            <th>Size (US$M)</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th align=center colspan=2>Edit</th>
                                        </tr>
                                        
                                        <?php
                                            $value = $_REQUEST['value'];
                                            $srcfundName = $_REQUEST['srcfundName'];
                                            $cond = ""; 
                                            $condQuery = "";
                                            $whereFlag = 0;
                                            
                                            if ($value != "" && $value != "All"){
                                                   if ($cond == "WHERE" || $cond == "AND"){
                                                       $cond = "AND";
                                                   }else{
                                                       $cond = "WHERE";
                                                   }                 
                                                   $condQuery = " ".$cond." fundRaisingDetails.fundName LIKE '".$value."%'";
                                            }
                                            
                                            if ($srcfundName!=""){
                                                if ($cond == "WHERE" || $cond == "AND"){
                                                       $cond = "AND";
                                                   }else{
                                                       $cond = "WHERE";
                                                   }                 
                                                   $condQuery = " ".$cond." fundRaisingDetails.fundName LIKE '%".$srcfundName."%'";                                                
                                            }
                                            
                                            
                                            $sql = "SELECT fundRaisingDetails.id,fundNames.fundName,fundRaisingDetails.fundManager,peinvestors.Investor,ftst.fundTypeName as stage,ftind.fundTypeName as industry,fundRaisingDetails.size,fundRaisingDetails.fundDate,fundRaisingDetails.fundDate,fundRaisingStatus.fundStatus";
                                            $sql .= " FROM `fundRaisingDetails` LEFT JOIN peinvestors ON fundRaisingDetails.investorId = peinvestors.InvestorId ";
                                            $sql .= " LEFT JOIN fundNames ON fundRaisingDetails.fundName = fundNames.fundId ";
                                            $sql .= " LEFT JOIN fundType ftst ON fundRaisingDetails.fundTypeStage = ftst.id";
                                            $sql .= " LEFT JOIN fundType ftind ON fundRaisingDetails.fundTypeIndustry = ftind.id";
                                            $sql .= " JOIN fundRaisingStatus ON fundRaisingDetails.fundStatus = fundRaisingStatus.id".$condQuery;
                                           
                                            $res = mysql_query($sql) or die(mysql_error());
                                            $rowCnt = mysql_num_rows($res);
                                            if ($rowCnt > 0){
                                                while($row=mysql_fetch_array($res)){
                                                    $fundId= $row['id'];
                                        ?>
                                                <tr>
                                                    <td><input name="DelFundId[]" type="checkbox" value=" <?php echo $fundId; ?>" ></td>
                                                    <td><?php echo $row['fundName'];?></td>
                                                    <td><?php echo $row['fundManager'];?></td>
                                                    <td><?php echo $row['Investor'];?></td>
                                                    <td width="100px"><?php echo $row['stage'];?></td>
                                                    <td width="100px"><?php echo $row['industry'];?></td>
                                                    <td><?php echo $row['size'];?></td>
                                                    <td><?php echo $row['fundDate'];?></td>
                                                    <td><?php echo $row['fundStatus'];?></td>
                                                    <td><a href="editfund.php?id=<?php echo $fundId; ?>">Edit</a></td>
                                                </tr>
                                        <?php } 
                                                
                                             } else {?>
                                                <tr><td colspan="9" align="center">No Records Found</td></tr>      
                                        <?php } ?>
                                </table>
                         </div><br>
                        <span style="float:left" class="one"><input type="button"  value="Delete" name="updateDelete"  onClick="updateDeletion();"></span>
                        <a style="float:right;"  id="fundlist" >Show Manager </a>


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
<SCRIPT type="text/javascript" src="js/jquery.min.js"></SCRIPT>
<script type="text/javascript">

$(document).ready(function() {
            $('#fundtab th:nth-child(3)').hide();
            $('#fundtab td:nth-child(3)').hide();
            $("#fundlist").html("Show Manager");
            $("#fundlist").click(function(){
                $('#fundtab th:nth-child(3)').toggle();
                $('#fundtab td:nth-child(3)').toggle();
                if($(this).html()=="Show Manager")
                     $("#fundlist").html("Hide Manager");
                 else
                     $("#fundlist").html("Show Manager");
            });
});
  
</script>