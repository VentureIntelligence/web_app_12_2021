<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$InvestorId = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
//on submission
	$InvestId=$_POST['txtinvId'];
	if($InvestId>0)
	{
		$mgmtString=$_POST['txtmgmtExecutiveName'];
		//$mgmtStringArray=10;
		//count($mgmtString);
		//echo "<br>---Array-" .$mgmtStringArray;
			for ($j=0;$j<=9;$j++)
			{
				if(trim($mgmtString[$j])!="")
				{
					$spltString=explode(",",$mgmtString[$j]);
					$exeName=$spltString[0];
					$exeDesig=$spltString[1];
					$exeCompany=$spltSTring[2];
					$mgmtexecId=rand();
					if(inst_Executives($mgmtexecId,trim($exeName),trim($exeDesig),trim($exeCompany)))
					{
						echo "<br>Investor Profile Mgmt Executive Added - " .$exeName;
						if(inst_investors_managment($InvestId,$mgmtexecId))
						{
						}
					}
				}

			}
	}



?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title></title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="addinvmgmt" method="post" action="addinvestorMgmt.php">
<td><input type="hidden" name="txtinvId" size="50" value="<?php echo $InvestorId; ?>"> </td>


<?php
	//echo "<br>--" .$InvestorId;
	$cnt=10;
	if($InvestorId>0)
	{
?>
<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Add Management Executive(s)</font> </b></center></p>
Please add in this format : <b>Name,Designation </b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($i=0;$i<=$cnt-1;$i++)
		{
?>
		<tr><td> <input type="text" name="txtmgmtExecutiveName[]"  size="50" > </td></tr>
<?php
		}
?>
	<tr> <Td align=center> <input type="submit" value="Update" name="updateInvMgmt" > </td></tr></table>
</table>
<?php
	}
?>
</form>
</body></html>



<?php

function inst_Executives($executiveId,$executivename,$designation,$company)
{
	$dbexec = new dbInvestments();
	$insExecSql = "insert into executives(ExecutiveId,ExecutiveName,Designation,Company) values ($executiveId,'$executivename','$designation','$company')";
	//echo "<br>Insert executive-  ". $insExecSql;
		if ($rsinsExecutive = mysql_query($insExecSql))
		{
			return true;
		}
		mysql_free_result($rsinsExecutive);
//	$dbexec.close();
}

function inst_investors_managment($investorId,$executiveId)
{
	$dbexecmgmt = new dbInvestments();
	$insExecmgmtSql = "insert into peinvestors_management values ($investorId,$executiveId)";
		echo "<br>Ins Mgmt-  ". $insExecmgmtSql;
		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
			return true;
		}
	mysql_free_result($rsinsmgmt);
//	$dbexecmgmt.close();
}

?>