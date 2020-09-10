<?php include_once("../../globalconfig.php"); ?>
<?php
 require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{

	$currentdir=getcwd();
	$target = $currentdir . "/importfiles/" . basename($_FILES['txtinvfilepath']['name']);

	$file = "importfiles/" . basename($_FILES['txtinvfilepath']['name']);
	if (!(file_exists($file)))
	{
		if(move_uploaded_file($_FILES['txtinvfilepath']['tmp_name'], $target))
		{
			//echo "<Br>The file ". basename( $_FILES['txtinvfilepath']['name']). " has been uploaded";
			echo "<br>File is getting uploaded . Please wait..";
			$file = "importfiles/" . basename($_FILES['txtinvfilepath']['name']);
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
		echo "<br>File is being read. ";
		if ($file !="")
		{
			echo "<Br>File is being read. It will take time to import all data. Please wait....";
			$fp = fopen($file, "r") or die("Couldn't open file");
			while(!feof($fp))
			{		$data .= fgets($fp, 1024);
			}
			fclose($fp);
			$values = explode("\n", $data);
				foreach ($values as $i)
				{
					//echo "<br>****full string- " .$i;
					//$i="";
					if($i != "")
					{
					//echo "<br>full string- " .$i;
					$fstring = explode("\t", $i);
					$portfoliocompany = $fstring[0];
					$keycontact=$fstring[1];
					//echo "<br><br>*****company. ".$portfoliocompany;
					$address1 =$fstring[2];
					$address1=str_replace('"','',$address1);
					$address2=$fstring[3];
					$address2=str_replace('"','',$address2);
					$adcity=trim($fstring[4]);
					$adcity=str_replace('"','',$adcity);
					$zip=$fstring[5];
					$telephone=trim($fstring[6]);
					$telephone=str_replace('"','',$telephone);
					$fax=trim($fstring[7]);
					$fax=str_replace('"','',$fax);
					$email=trim($fstring[8]);
					$email=str_replace('"','',$email);
					$website=trim($fstring[9]);
					$Description="";
					//$Description=str_replace('"','',$Description);
					$yearfounded="";
					$no_employees="";       //no of employees dont have to be read trim($fstring[11]);
					$mgmtString="";
					$firmType="";
					$otherlocation="";
					$assets_mgmt="";
					$already_invested="";
					$preferred_stage="";
					$limited_partners="";
					$no_funds="";
					$no_activefunds="";
					$minimum_invested="";   
					$addinfor=trim($fstring[10]); 				//additional information in the excel
					$addinfor=str_replace('"','',$addinfor);
					$comment=""; 				//comment in the excel
					$countryid="--";

					if(trim($portfoliocompany)!="")
					{
						$investorId=inst_investor($portfoliocompany,$address1,$address2,$adcity,$zip,$telephone,$fax,$email,$website,$Description,$yearfounded,$no_employees,$firmType,$otherlocation,$assets_mgmt,$already_invested,$preferred_stage,$limited_partners,$no_funds,$no_activefunds,$minimum_invested,$addinfor,$comment,$keycontact);
						echo $investorId;
						if($investorId>0)
						{
					?>
						<Br><tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany ; ?>&nbsp; --> Imported & Update done</td> </tr>
					<?php
						}
						elseif($investorId==0)
						{
						//	$companyId=inst_investor($portfoliocompany,$address1,$address2,$adcity,$zip,$telephone,$fax,$email,$website,$Description,$yearfounded,$no_employees,$firmType,$otherlocation,$assets_mgmt,$already_invested,$preferred_stage,$limited_partners,$no_funds,$no_activefunds,$minimum_invested,$addinfor,$comment,$keycontact);
					?>
						<br><tr bgcolor="#00CC66"><td width=20% style="font-family: Verdana; font-size: 8pt"> <b><?php echo $portfoliocompany ; ?>&nbsp; --> Imported </b></td> </tr>
					<?php
						}
						
							$importTotal=$importTotal+1;
						//	echo "<br>".$importTotal. " " .$portfoliocompany;
					} // $portfoliocompany != " loop ends
				} //if $i loop ends
			} //for each loop ends
		} // if $file loop ends
	}   //file exists condition
	else
	{
	?>
		<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
		<tr> <Td><b> File dont exists to read </b> </td></tR>
		</table>
	<?php
	}

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
<tr> <Td><b> Import count - <?php echo $importTotal; ?> </b> </td></tR>
</table>
<?php



/* function to insert the companies and return the company id if exists */
	function inst_investor($investor,$add1,$add2,$adcity,$zip,$tel,$fax,$email,$website,$description,$yearfounded,$no_emp,$firmtype,$otherloc,$ass_mgmt,$invested,$pref_stage,$lps,$no_fund,$no_activefund,$min_invested,$addinfor,$comment,$contact)
	{
		$dbpecomp = new dbInvestments();
		$investorname=trim($investor);
		$getPECompanySql = "select InvestorId from peinvestors where Investor like '$investorname'";
		//echo "<br>select Investor--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			if ($pecomp_cnt==0)
			{
			    //insert peinvestors
			    $insPECompanySql="insert into peinvestors(Investor,Address1,Address2,City,Zip,Telephone,Fax,Email,website,Description,yearfounded,NoEmployees,FirmType,OtherLocation,Assets_mgmt,AlreadyInvested,PreferredStage,LimitedPartners,NoFunds,NoActiveFunds,MinInvestment,AdditionalInfor,Comment,KeyContact) values('$investorname','$add1','$add2','$adcity','$zip','$tel','$fax','$email','$website','$description','$yearfounded','$no_emp','$firmtype','$otherloc','$ass_mgmt','$invested','$pref_stage','$lps','$no_fund','$no_activefund','$min_invested','$addinfor','$comment','$contact')";
			   // echo "<br>Insert Investor sql=" .$insPECompanySql;
			    if($rsInsPECompany = mysql_query($insPECompanySql))
			    {
				    $investorId=0;
				    return $investorId;
			    }
			}
			elseif($pecomp_cnt==1)
			{
			    While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
			    {
				    $investorId = $myrow[0];
				    $updatePECompanySql="Update peinvestors set Address1='$add1',Address2='$add2',City='$adcity',Zip='$zip',Telephone='$tel',Fax='$fax',Email='$email',website='$web',Description='$description',yearfounded='$yearfounded',NoEmployees='$no_emp',FirmType='$firmtype',OtherLocation='$otherloc',Assets_mgmt='$ass_mgmt',AlreadyInvested='$invested',PreferredStage='$pref_stage',LimitedPartners='$lps',NoFunds='$no_fund',NoActiveFunds='$no_activefund',MinInvestment='$min_invested',AdditionalInfor='$addinfor',Comment='$comment',KeyContact='$contact'	where InvestorId=$investorId";
				   // echo "<br>Update Investor sql=" .$updatePECompanySql;
				    if($rsupdatePECompany = mysql_query($updatePECompanySql))
				    {
					    return  $investorId;;
				    }

			    }
			}
		}
	//	$dbpecomp.close();
	}

//End of peinvestments insert

?>