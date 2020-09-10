<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$companyStringId = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	//echo "<br>---". $companyId;
	$splitCompanyId=explode("-", $companyStringId);
	$pe_reflag=$splitCompanyId[0];
	$companyId=$splitCompanyId[1];
	echo "<br>Insert ".$pe_reflag . " For Id ".$companyId;
//on submission
	$PEId=$_POST['txtPEId'];
	$pereflg=$_POST['txtpereflag'];
	echo "<br>pe OR re-" .$pereflg;


	if($PEId>0)
	{
		$advCompanyString=$_POST['txtAdvCompany'];
		$advInvestorString=$_POST['txtAdvInvestor'];
		$advAcquirerString=$_POST['txtAdvAcquirer'];
		$advisorTypeComp=$_POST['AdvisortypeCompany'];
		$advisorTypeInv=$_POST['AdvisortypeInvestor'];
		$advisorTypeAcq=$_POST['AdvisortypeAcquirer'];


			for ($j=0;$j<=4;$j++)
			{
			//		echo "<br>String-" .$advCompanyString[$j];
				if(trim($advCompanyString[$j])!="")
				{

					//echo "<br>&&******".$j."--" .$advCompanyString[$j];
					$advCompanyToInsert=$advCompanyString[$j];
					$advtypeComp=$advisorTypeComp[$j];
					$ciaIdToInsert=insert_get_CIAs(trim($advCompanyToInsert),$pereflg,$advtypeComp);
					if($ciaIdToInsert==0)
						$ciaIdToInsert=insert_get_CIAs(trim($advCompanyToInsert),$pereflg,$advtypeComp);
					if(inst_advisor_companies($PEId,$ciaIdToInsert,$pereflg))
					{
					}

				}

				if(trim($advInvestorString[$j])!="")
				{
					$advInvestorToInsert=$advInvestorString[$j];
					$advtypeInv= $advisorTypeInv[$j];
				//	echo "<br>----" .$advInvestorToInsert;
					$ciaIdToInsertInv=insert_get_CIAs(trim($advInvestorToInsert),$pereflg,$advtypeInv);
					if($ciaIdToInsert==0)
						$ciaIdToInsertInv=insert_get_CIAs(trim($advInvestorToInsert),$pereflg,$advtypeInv);

					if(inst_advisor_investors($PEId,$ciaIdToInsertInv,$pereflg))
					{
					}

				}

				if(trim($advAcquirerString[$j])!="")
				{
					$advAcquirerToInsert=$advAcquirerString[$j];
					$advtypeAcq=$advisorTypeAcq[$j];
				//	echo "<br>----" .$advAcquirerToInsert;
					$ciaIdToInsertAcq=insert_get_CIAs(trim($advAcquirerToInsert),$pereflg,$advtypeAcq);
					if($ciaIdToInsertAcq==0)
						$ciaIdToInsertAcq=insert_get_CIAs(trim($advAcquirerToInsert),$pereflg,$advtypeAcq);

					if(inst_advisor_acquirer($PEId,$ciaIdToInsertAcq,$pereflg))
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
<form name="addinvmgmt" method="post" action="addAdvisorCompanyInvestor.php">
<td><input type="text" name="txtPEId" size="50" value="<?php echo $companyId; ?>"> </td>
<td><input type="text" name="txtpereflag" size="50" value="<?php echo $pe_reflag; ?>"> </td>



<?php
	//echo "<br>--" .$InvestorId;
	$cnt=5;
	if($companyId>0)
	{
?>

Please add in this format : <b>Advisor Company Name (Advisor Seller) </b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($k=0;$k<=$cnt-1;$k++)
		{
?>
		<tr><td> <input type="text" name="txtAdvCompany[]"  size="50" > </td>
                <td width=5% align=left> <SELECT NAME="AdvisortypeCompany["]>
                <OPTION VALUE="L" SELECTED>Legal</OPTION>
                <OPTION VALUE="T">Transaction</OPTION> </SELECT>
                 </td>
                </tr>
<?php
		}

?>

</table>

Please add in this format : <b>Advisor Investor Name </b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($i=0;$i<=$cnt-1;$i++)
		{
?>
		<tr><td> <input type="text" name="txtAdvInvestor[]"  size="50" > </td>
                <td width=5% align=left> <SELECT NAME="AdvisortypeInvestor[]">
                <OPTION VALUE="L" SELECTED>Legal</OPTION>
                <OPTION VALUE="T">Transaction</OPTION> </SELECT> </td></tr>

                <?php
		}
?>
</table>

Please add in this format : <b>Advisor Acquirer Name (Advisor Buyer)</b>
<table width=60% align=center border=1 cellpadding=1 cellspacing=0>
<?php
		for ($m=0;$m<=$cnt-1;$m++)
		{
?>
		<tr><td> <input type="text" name="txtAdvAcquirer[]"  size="50" > </td>
		<td width=5% align=left> <SELECT NAME="AdvisortypeAcquirer[]">
                <OPTION VALUE="L" SELECTED>Legal</OPTION>
                <OPTION VALUE="T">Transaction</OPTION> </SELECT> </td></tr>
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
function insert_get_CIAs($cianame,$pereflagAfterSubmit,$adtype)
{
	//echo "<br>****" .$cianame;
	$dblink = new dbInvestments();
	$cianame=trim($cianame);
	if($pereflagAfterSubmit=="PE")
	{	$getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame'";
		$insAcquirerSql="insert into advisor_cias(cianame,AdvisorType) values('$cianame','$adtype')";
	}
	elseif($pereflagAfterSubmit=="RE")
	{	$getInvestorIdSql = "select CIAId from REadvisor_cias where cianame like '$cianame'";
		$insAcquirerSql="insert into REadvisor_cias(cianame,AdvisorType) values('$cianame','$adtype')";
	}

	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//echo "<br>Investor count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				//$insAcquirerSql="insert into advisor_cias(cianame) values('$cianame')";
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
				return $ciaInvestorId;
			}
		}
	}
	$dblink.close();
}


function inst_advisor_acquirer($PEId,$ciaId,$pereflagAfterSubmit)
{
	echo "<Br>Inside Function-- ".$pereflagAfterSubmit;

	$dbexecmgmt = new dbInvestments();
	if($pereflagAfterSubmit=="PE")
		$insExecmgmtSql = "insert into peinvestments_advisoracquirer values ($PEId,$ciaId)";
	elseif($pereflagAfterSubmit=="RE")
		$insExecmgmtSql = "insert into REinvestments_advisoracquirer values ($PEId,$ciaId)";

	echo "<br>Ins Advisor Investors-  ". $insExecmgmtSql;
		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
			return true;
		}
	mysql_free_result($rsinsmgmt);
//	$dbexecmgmt.close();
}

function inst_advisor_investors($PEId,$ciaId,$pereflagAfterSubmit)
{
	echo "<Br>Inside Function-- ".$pereflagAfterSubmit;

	$dbexecmgmt = new dbInvestments();
	if($pereflagAfterSubmit=="PE")
		$insExecmgmtSql = "insert into peinvestments_advisorinvestors values ($PEId,$ciaId)";
	elseif($pereflagAfterSubmit=="RE")
		$insExecmgmtSql = "insert into REinvestments_advisorinvestors values ($PEId,$ciaId)";

	echo "<br>Ins Advisor Investors-  ". $insExecmgmtSql;
		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
			return true;
		}
	mysql_free_result($rsinsmgmt);
//	$dbexecmgmt.close();
}
function inst_advisor_companies($PEId,$ciaId,$pereflagAfterSubmit)
{
	echo "<Br>Inside Function-- ".$pereflagAfterSubmit;
	$dbexecbrd=new dbInvestments();
	if($pereflagAfterSubmit=="PE")
		$insExecbrdSql = "insert into peinvestments_advisorcompanies values ($PEId,$ciaId)";
	elseif($pereflagAfterSubmit=="RE")
		$insExecbrdSql = "insert into REinvestments_advisorcompanies values ($PEId,$ciaId)";

		if ($rsinsbrd= mysql_query($insExecbrdSql))
		{
				echo "<br>Ins Advisor companies  -  ". $insExecbrdSql;

			return true;
		}
	mysql_free_result($rsinsbrd);
//	$dbexecbrd.close();
}

?>