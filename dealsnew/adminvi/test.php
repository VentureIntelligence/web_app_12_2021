<?php
	require("../dbconnectvi.php");

$compId=insert_company("xxx",3,"sector","web.com");
echo "<br>1 --------" .$compId;

function returnDate($mth,$yr)
{
	//this function returns the date

	$fulldate= $yr ."-" .$mth ."-01";
	if (checkdate (01,$mth, $yr))
	{
		return $fulldate;
	}
}
echo "<Br>2 --";

function returnAcquirerId($acquirername)
{
	$acquirername=trim($acquirername);
	$dbaclinkss = new dbInvestments();
	$getAcquirerSql="select AcquirerId from acquirers where Acquirer='$acquirername'";
	//echo "<br>---" .$getAcquirerSql;
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
		$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
		if($acquirer_cnt==0)
		{
			//insert acquirer
			$insAcquirerSql="insert into acquirers(Acquirer) values('$acquirername')";
			//echo "<br>Insert Acquirer--" .$insAcquirerSql;
			if($rsInsAcquirer = mysql_query($insAcquirerSql))
			{
				$acquirerId=0;
				return acquirerId;
			}
		}

		elseif($acquirer_cnt==1)
		{
			While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
			{
				$acquirerId = $myrow["AcquirerId"];
				//echo "<br>!!Insert return investor id--" .$acquirerId;
				return $acquirerId;
			}
		}
	}
	$dbaclinkss.close();
}
echo "<Br>3 --";

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from REcompanies where companyname= '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into REcompanies(companyname,industry,sector_business,website)
					values('$companyname',$industryId,'$sector','$web')";
				//	echo "<br>Ins company sql=" .$insPECompanySql;
					//if($rsInsPECompany = mysql_query($insPECompanySql))
					//{
						$companyId=0;
						return $companyId;
					//}
			}
			elseif($pecomp_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
				{
					$companyId = $myrow[0];
				//	echo "<br>Insert return industry id--" .$companyId;
					return $companyId;
				}
			}
		}
		$dbpecomp.close();
	}


echo "<Br>4 --";


/* inserts and return the investor id */
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from REinvestors where Investor= '$investor'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//insert acquirer
					$insAcquirerSql="insert into REinvestors(Investor) values('$investor')";
					if($rsInsAcquirer = mysql_query($insAcquirerSql))
					{
						$InvestorId=0;
						return $InvestorId;
					}
			}
			elseif($investor_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$InvestorId = $myrow[0];
				//	echo "<br>Insert return investor id--" .$InvestorId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}

echo "<Br>5 --";

	// the following function inserts investor and the peid in the peinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId)
	{
		$DbInvestInv = new dbInvestments();
		$getDealInvSql="Select MandAId,InvestorId from REmanda_investors where MandAId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into REmanda_investors values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbInvestInv.close();
}
echo "<Br>6 --";


/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
	//	echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into advisor_cias(cianame) values('$cianame')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$AdInvestorId=0;
					return $InvestorId;
				}
		}
		elseif($investor_cnt==1)
		{
			While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$AdInvestorId = $myrow[0];
			//	echo "<br>Insert return investor id--" .$invId;
				return $AdInvestorId;
			}
		}
	}
	$dbcialink.close();
}

?>