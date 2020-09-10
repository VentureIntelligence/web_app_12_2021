<?php include_once("../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/tmp");
     	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
	//$file ="importfiles/peinvestmentsexport.txt";
	    $currentdir=getcwd();
	    $target = $currentdir . "/importfiles/" . basename($_FILES['txtangelfilepath']['name']);
	    $file = "importfiles/" . basename($_FILES['txtangelfilepath']['name']);
	    echo"<br>************".$file;
	    if (!(file_exists($file)))
	    {
		if(move_uploaded_file($_FILES['txtangelfilepath']['tmp_name'], $target))
		{
		    //echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
		    echo "<br>File is getting uploaded . Please wait..";
		    $file = "importfiles/" . basename($_FILES['txtangelfilepath']['name']);
		    //echo "<br>----------------" .$file;
		}
		else
		{
		    echo "<br>Sorry, there was a problem uploading the file.";
		}
	    }
	    $importTotal=0;
	    if (file_exists($file))
	    {
		if ($file !="")
		{
		    echo "<Br>File is being read. It will take time to import all data. Please wait....";
		    $fp = fopen($file, "r") or die("Couldn't open file");
		    //$data = fread($fp, filesize($fp));
		    while(!feof($fp))
		    {	$data .= fgets($fp, 1024);
		    }
		    fclose($fp);
		    $values = explode("\n", $data);
		    foreach ($values as $i)
		    {
			//echo "<br>full string- " .$i;
			if($i != "")
			{
			    //echo "<br>full string- " .$i;
			    $fstring = explode("\t", $i);
			    $portfoliocompany = trim($fstring[0]);
			    //echo "<br>company. ".$portfoliocompany;
			    $industryname = trim($fstring[1]);
			    $sector=$fstring[2];
			    $col6=$fstring[3]; //Investors
			    /*$col6 is investors
			    read the investor column in loop and insert invidual investors into peinvestors table
			    taking the InvestorId and insert in the manda_investors table
			    */
			    $investorString=str_replace('"','',$col6);
			    $investorString=explode(",",$investorString);
			    $IPODate=$fstring[4];
			    $MultipleAngelRound=$fstring[5];
			    if(($MultipleAngelRound<=0) || ($MultipleAngelRound==""))
				$MultipleAngelRound=0;
			    $FollowOnVCFund=$fstring[6];
			    if(($FollowOnVCFund<=0) || ($FollowOnVCFund==""))
				$FollowOnVCFund=0;
			    $Exited=$fstring[7];
			     if(($Exited<=0) || ($Exited==""))
				$Exited=0;
			    $website=$fstring[8];
			    $city=trim($fstring[9]);
			    $region=trim($fstring[10]);
			    $regionId=returnRegionId($region);
			    $comment=trim($fstring[11]);
			    $comment=str_replace('"','',$comment);
			    $moreinfor=trim($fstring[12]);
			    $moreinfor=str_replace('"','',$moreinfor);
			    $validation=trim($fstring[13]);	//valiation text
			    $links=$fstring[14];
			    $flagdeletion=0;
			    $fullDateAfter=$IPODate;
			   // echo "<br>**" .$fulldate ."--".$fullDateAfter;
			    if (trim($portfoliocompany) !="")
			    {
				$indid=insert_industry(trim($industryname));
				//echo "<br>First Industryid-".$indid;
				if($indid==0)
				{
				    $indid= insert_industry(trim($industryname));
				    //echo "<br>AFter insert Industryid-".$indid;
				}
				//echo "<br>Industryid-".$indid;
				$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$regionId);
				if($companyId==0)
				{
				    $companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$regionId);
				}
				
				if ($companyId >0)
				{
				    $pegetInvestmentsql = "select c.PECompanyId,ma.InvesteeId,Date from pecompanies as c,
				    angelinveals as ma where ma.InvesteeId = c.PECompanyId and
				    ma.Date = '$fullDateAfter' and c.PECompanyId = $companyId ";
				    //echo "<br>checking pe record***" .$pegetInvestmentsql;
				    //echo "<br>Company id--" .$companyId;
				    if ($rsInvestment = mysql_query($pegetInvestmentsql))
				    {
				    $investment_cnt = mysql_num_rows($rsInvestment);
				    // echo "<br>Count**********-- " .$investment_cnt ;
				    }
				    if($investment_cnt==0)
				    {
					$PEId= rand();
					//echo "<br>random MandAId--" .$PEId;
					// (AngelDealId,InvesteeId,DealDate,MultipleAngelRound,FollowOnVCFund,Exit,Comment,MoreInfor,Validation,Link,Deleted)
					
					$insertcompanysql="";
					$insertcompanysql= "INSERT INTO angelinvdeals
					VALUES ($PEId,$companyId,'$fullDateAfter',$MultipleAngelRound,$FollowOnVCFund,$Exited,'$comment','$moreinfor', '$validation','$links',$flagdeletion)";
					//echo "<br>@@@@ :".$insertcompanysql;
					if ($rsinsert = mysql_query($insertcompanysql))
					{
					    foreach ($investorString as $inv)
					    {
						if(trim($inv)!=="")
						{
						    $investorIdtoInsert=return_insert_get_Investor(trim($inv));
						    if($investorIdtoInsert==0)
						    {
							$investorIdtoInsert= return_insert_get_Investor(trim($inv));
						    }
							$insDeal_investors= insert_Investment_Investors($PEId,$investorIdtoInsert);
						}
					    }
					    $importTotal=$importTotal+1;
					    $datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
					    ?>
					    <Br>
					    <tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Imported</td> </tr>
					<?php
					}
					else
					{
					?>
					<tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Import failed</td> </tr>
					<?php
					}
				    }
				    elseif($investment_cnt>= 1)
				    {
				    ?>
				    <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->M&A Deal already exists</td> </tr>
				    <?php
				    }
				}//if companyid >0 loop ends
			    } //if $portfoliocompany !=null loop ends
			} //if $i loop ends
		    } //for each loop ends
		} // if $file loop ends
	    }// file exists loop ends
	    else
	    {
	    ?>
	    <table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
	    <tr> <Td><b> File dont exists to read </b> </td></tR>
	    </table>
	    <?
	    }
	} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

//End of peinvestments insert
?>

<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
<tr> <Td><b> Import count - <?php echo $importTotal; ?> </b> </td></tR>
</table>
<?php

function returnRegionId($region)
	{
		$region=trim($region);
		$dbslinkss = new dbInvestments();
		$getDealIdSql="select RegionId from region where Region like '$region'";
	//	echo "<Br>DealSql--" .$getDealIdSql;
		if($rsgetRegionId=mysql_query($getDealIdSql))
		{
			$dealtype_cnt=mysql_num_rows($rsgetRegionId);
			if($dealtype_cnt==0)
			{
				//insert deal ..mostly it wont get inserted as new..standard 9 region already exists
				$insAcquirerSql="insert into region(Region) values('$region')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$regionId=0;
					return regionId;
				}
			}
			elseif($dealtype_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetRegionId, MYSQL_BOTH))
				{
					$regionId = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionId;
				}
			}
		}
		$dbslinkss.close();
	}

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$city,$regionId)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname= '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
		    $pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
		   // echo "<BR>---Count---" .$pecomp_cnt;
		    if ($pecomp_cnt==0)
		    {
			//insert pecompanies
			$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,RegionId)
			values('$companyname',$industryId,'$sector','$web','$city',$regionId)";
		//	echo "<br>Ins company sql=" .$insPECompanySql;
			if($rsInsPECompany = mysql_query($insPECompanySql))
			{
				$companyId=0;
				return $companyId;
			}
		    }
		    elseif($pecomp_cnt==1)
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

/* function to insert the industry and return the industry id if exists */
	function insert_industry($industryname)
	{
		$dbindustrylink = new dbInvestments();
		$getIndustrySql = "select IndustryId from industry where industry like '$industryname%'";
		//echo "<br>select--" .$getIndustrySql;
		if ($rsgetIndustryId = mysql_query($getIndustrySql))
		{
			$ind_cnt=mysql_num_rows($rsgetIndustryId);
			//echo "<br>Investor count-- " .$ind_cnt;
			if ($ind_cnt==0)
			{
					//insert industry
					$insIndustrySql="insert into industry(industry) values('$industryname')";
					if($rsInsIndustry = mysql_query($insIndustrySql))
					{
						$IndustryId=0;
						return $IndustryId ;
					}
			}
			elseif($ind_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetIndustryId, MYSQL_BOTH))
				{
					$IndustryId = $myrow[0];
				//	echo "<br>Insert return industry id--" .$IndustryId;
					return $IndustryId;
				}
			}
		}
		$dbindustrylink.closeDB();
	}


//* inserts and return the investor id */
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor= '$investor'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
		    $investor_cnt=mysql_num_rows($rsgetInvestorId);
		    //echo "<br>Investor count-- " .$investor_cnt;
		    if ($investor_cnt==0)
		    {
			//insert acquirer
			$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
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


	// the following function inserts investor and the peid in the peinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId)
	{
		$DbInvestInv = new dbInvestments();
		//$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
		$getDealInvSql="Select AngelDealId,InvestorId from angel_investors where AngelDealId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
		    $deal_invcnt=mysql_num_rows($rsgetdealinvestor);
		    if($deal_invcnt==0)
		    {
			$insDealInvSql="insert into angel_investors values($dealId,$investorId)";
			if($rsinsdealinvestor = mysql_query($insDealInvSql))
			{
				return true;
			}
		    }
		}
		$DbInvestInv.close();
}

?>