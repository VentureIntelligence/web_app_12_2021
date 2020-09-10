<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$companyId = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
  //	echo "<br>---". $companyId;
//on submission
	$MAMAId=$_POST['txtMAMAId'];
	//echo "<br>***" .$MAMAId;
	if($MAMAId>0)
	{
		$advisorCompanyString=$_POST['txtAdvCompany'];
		$AdvCompanyidarray= count($advisorCompanyString);
	//	echo "<br>Array coutn--" .$AdvCompanyidarray;
		$advAcquirerString=$_POST['txtAdvAcquirer'];
		$advisorTypeComp=$_POST['REAdvisortypeCompany'];
		$advisorTypeAcq=$_POST['REAdvisortypeAcquirer'];

		//echo "<br>********". $advAcquirerString;
			for ($j=0;$j<=9;$j++)
			{
				if(trim($advisorCompanyString[$j])!="")
				{
					$advCompanyToInsert=$advisorCompanyString[$j];
					$adtypeCompany=$advisorTypeComp[$j];
					$TargetAdvisorIdtoInsert=insert_get_CIAs(trim($advCompanyToInsert),$adtypeCompany);
					if($TargetAdvisorIdtoInsert==0)
					{
						$TargetAdvisorIdtoInsert=insert_get_CIAs(trim($advCompanyToInsert),$adtypeCompany);
					}
						if(inst_advisor_companies($MAMAId,$TargetAdvisorIdtoInsert))
						{
						}

				}

				if(trim($advAcquirerString[$j])!="")
				{
					$advAcquirerToInsert=$advAcquirerString[$j];
					$adttypeAcquirer=$advisorTypeAcq[$j];
					$AcquirorAdvisorIdtoInsert=insert_get_CIAs(trim($advAcquirerToInsert),$adttypeAcquirer);
					if($AcquirorAdvisorIdtoInsert==0)
					{
						$AcquirorAdvisorIdtoInsert=insert_get_CIAs(trim($advAcquirerToInsert),$adttypeAcquirer);
					}
						if(inst_advisor_investors($MAMAId,$AcquirorAdvisorIdtoInsert))
						{
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
<form name="addinvmgmt" method="post" action="addREAdvisors_meracq.php">
<td><input type="hidden" name="txtMAMAId" size="50" value="<?php echo $companyId; ?>"> </td>


<?php
	//echo "<br>--" .$InvestorId;
	$cnt=10;
	if($companyId>0)
	{
?>

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Add RE Advisors - Target & Acquirer</font> </b></center></p>
Please add in this format : <b>Advisor - Target </b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($k=0;$k<=$cnt-1;$k++)
		{
?>
		<tr><td> <input type="text" name="txtAdvCompany[]"  size="40" > </td>
                <td width=5% align=left> <SELECT NAME="REAdvisortypeCompany[]">
                <OPTION VALUE="L" SELECTED>Legal</OPTION>
                <OPTION VALUE="T">Transaction </OPTION> </SELECT>
                 </td>
                 </tr>
<?php
		}

?>

</table>

Please add in this format : <b>Advisor Acquirer </b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($i=0;$i<=$cnt-1;$i++)
		{
?>
		<tr><td> <input type="text" name="txtAdvAcquirer[]"  size="50" > </td>
                <td width=5% align=left> <SELECT NAME="REAdvisortypeAcquirer[]">
                <OPTION VALUE="L" SELECTED>Legal</OPTION>
                <OPTION VALUE="T">Transaction</OPTION> </SELECT> </td>
                </tr>

<?php
		}
?>

</table>
	<P align=center> <input type="submit" value="Update" name="updateadvisoracquirer" ></p>
<?php
	}
?>
</form>
</body></html>



<?php

function insert_get_CIAs($cianame,$adtype)
{
	echo "<br>****" .$cianame;
	$dblink = new dbInvestments();
	$cianame=trim($cianame);
	$getInvestorIdSql = "select CIAId from REadvisor_cias where cianame like '$cianame'";
	echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//echo "<br>Investor count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into REadvisor_cias(cianame,AdvisorType) values('$cianame','$adtype')";
				//	echo "<br>Insert------" .$insAcquirerSql;
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$ciaInvestorId=0;
					return $ciaInvestorId;
				}
		}
		elseif($investor_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$ciaInvestorId = $myrow[0];
				//echo "<br>Insert return investor id--" .$ciaInvestorId;
				return $ciaInvestorId;
			}
		}
	}
	$dblink.close();
}

function inst_advisor_investors($mamaid,$ciaId)
{
	$dbexecmgmt = new dbInvestments();
	$insExecmgmtSql = "insert into REmama_advisoracquirer values ($mamaid,$ciaId)";
		echo "<br>Insert Advisor Acquirer-  ". $insExecmgmtSql;
		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
			return true;
		}
	mysql_free_result($rsinsmgmt);
//	$dbexecmgmt.close();
}
function inst_advisor_companies($MAMAId,$ciaId)
{
	$dbexecbrd=new dbInvestments();
	$insExecbrdSql = "insert into REmama_advisorcompanies values ($MAMAId,$ciaId)";
		echo "<br>Insert Advisor Target-  ". $insExecbrdSql;
		if ($rsinsbrd= mysql_query($insExecbrdSql))
		{
			return true;
		}
	mysql_free_result($rsinsbrd);
//	$dbexecbrd.close();
}

?>