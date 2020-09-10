<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$companyId = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
  //	echo "<br>---". $companyId;
//on submission
	$compId=$_POST['txtinvId'];
	if($compId>0)
	{
		$boardString=$_POST['txtboardExecutiveName'];
		$mgmtString=$_POST['txtmgmtExecutiveName'];

			for ($j=0;$j<=4;$j++)
			{
				if(trim($boardString[$j])!="")
				{
					//echo "<br>&&******".$j."--" .$boardString[$j];
					$boardStringsplit=explode(",",$boardString[$j]);
					$bexeName=$boardStringsplit[0];
					$bexeDesig=$boardStringsplit[1];
					$bexeCompany=$boardStringsplit[2];
					$boardexecId=rand();
					if(inst_Executives($boardexecId,trim($bexeName),trim($bexeDesig),trim($bexeCompany)))
					{
						echo "<br>Board Executive Added - " .$bexeName;
						if(inst_companies_board($compId,$boardexecId))
						{
						}
					}
				}

				if(trim($mgmtString[$j])!="")
				{
					$MgmtspltString=explode(",",$mgmtString[$j]);
					$exeName=$MgmtspltString[0];
					$exeDesig=$MgmtspltString[1];
					$exeCompany=$MgmtspltString[2];
					$mgmtexecId=rand();
					if(inst_Executives($mgmtexecId,trim($exeName),trim($exeDesig),trim($exeCompany)))
					{
						echo "<br>Management Executive Added - " .$exeName;
						if(inst_companies_managment($compId,$mgmtexecId))
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
<form name="addinvmgmt" method="post" action="addcompBoardMgmt.php">
<td><input type="hidden" name="txtinvId" size="50" value="<?php echo $companyId; ?>"> </td>


<?php
	//echo "<br>--" .$InvestorId;
	$cnt=5;
	if($companyId>0)
	{
?>

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Add Board Executive(s)</font> </b></center></p>
Please add in this format : <b>Name, Designation, Company </b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($k=0;$k<=$cnt-1;$k++)
		{
?>
		<tr><td> <input type="text" name="txtboardExecutiveName[]"  size="50" > </td></tr>
<?php
		}

?>

</table>

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

</table>
	<P align=center> <input type="submit" value="Update" name="updatecompMgmt" ></p>
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
	echo "<br>Insert executive-  ". $insExecSql;
		if ($rsinsExecutive = mysql_query($insExecSql))
		{
			return true;
		}
		mysql_free_result($rsinsExecutive);
//	$dbexec.close();
}

function inst_companies_managment($investorId,$executiveId)
{
	$dbexecmgmt = new dbInvestments();
	$insExecmgmtSql = "insert into pecompanies_management values ($investorId,$executiveId)";
		echo "<br>Ins Mgmt-  ". $insExecmgmtSql;
		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
			return true;
		}
	mysql_free_result($rsinsmgmt);
//	$dbexecmgmt.close();
}
function inst_companies_board($investorId,$executiveId)
{
	$dbexecbrd=new dbInvestments();
	$insExecbrdSql = "insert into pecompanies_board values ($investorId,$executiveId)";
		echo "<br>Ins into Company Board-  ". $insExecbrdSql;
		if ($rsinsbrd= mysql_query($insExecbrdSql))
		{
			return true;
		}
	mysql_free_result($rsinsbrd);
//	$dbexecbrd.close();
}

?>