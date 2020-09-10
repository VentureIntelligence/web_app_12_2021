<?php include_once("../globalconfig.php"); ?>
<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();
 session_save_path("/tmp");
  session_start();
  	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
		//$file ="importfiles/pecompanyprofileexport.txt";

		$currentdir=getcwd();
		$target = $currentdir . "/importfiles/" . basename($_FILES['txtcompfilepath']['name']);
		$file = "importfiles/" . basename($_FILES['txtcompfilepath']['name']);

		//echo "<br>Target- " .$target;
		if (!(file_exists($file)))
		{
			if(move_uploaded_file($_FILES['txtcompfilepath']['tmp_name'], $target))
			{
				//echo "<Br>The file ". basename( $_FILES['txtcompfilepath']['name']). " has been uploaded";
				echo "<br>File is getting uploaded . Please wait..";
				$file = "importfiles/" . basename($_FILES['txtcompfilepath']['name']);
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
			echo "<br>It will take time to import all data. Please wait....";
			$fp = fopen($file, "r") or die("Couldn't open file");
			//$data = fread($fp, filesize($fp));
			while(!feof($fp))
			{		$data .= fgets($fp, 1024);
			}
			fclose($fp);
			$values = explode("\n", $data);
				foreach ($values as $i)
				{
					//echo "<br>full string- " .$i;
					//$i="";
					if($i != "")
					{
						//echo "<br>full string- " .$i;
						$fstring = explode("\t", $i);
						$portfoliocompany = $fstring[0];
						$portfoliocompany=str_replace('"','',$portfoliocompany);
						//echo "<br>company. ".$portfoliocompany;
						$stock = $fstring[1];
						$industryname=$fstring[2];

						$boardString=trim($fstring[3]);
						$boardString=str_replace('"','',$boardString);

						$mgmtString=trim($fstring[4]);
						$mgmtString=str_replace('"','',$mgmtString);

						$sector=trim($fstring[5]);  			//6 -  investors
						$website=trim($fstring[7]);
						$yearfounded=trim($fstring[8]);
						$address1=$fstring[9];
						$address1=str_replace('"','',$address1);
						$address2=$fstring[10];
						$address2=str_replace('"','',$address2);


						$adcity=trim($fstring[11]);
						$zip=$fstring[12];
						$otherlocation=trim($fstring[13]);
						$otherlocation=str_replace('"','',$otherlocation);

						$country=trim($fstring[14]);
						$telephone=trim($fstring[15]);
						$telephone=str_replace('"','',$telephone);
						$fax=trim($fstring[16]);
						$email=trim($fstring[17]);	//email
						$email=str_replace('"','',$email);

						$addinfor=$fstring[18]; //moreinfor in the excel
						$addinfor=str_replace('"','',$addinfor);

						$city=$fstring[19];
						$region=$fstring[20];
						$regionId=returnRegionId($region);

						if (trim($portfoliocompany) !="")
						{
							$indid=insert_industry(trim($industryname));
							if($indid==0)
							{
								$indid= insert_industry(trim($industryname));
							}
							//echo "<br>Industryid-".$indid;
							$companyId=insert_company($portfoliocompany,$indid,$sector,$city,$website,$stock,$yearfounded,$address1,$address2,$adcity,$zip,$otherlocation,$country,$telephone,$fax,$email,$addinfor,$regionId);
							//	echo "<Br>first check-" .$companyId;
							if($companyId<=0)
							{
								$companyId=insert_company($portfoliocompany,$indid,$sector,$city,$website,$stock,$yearfounded,$address1,$address2,
								$adcity,$zip,$otherlocation,$country,$telephone,$fax,$email,$addinfor,$regionId);
							}

							//echo "<br>Companyid*******" .$companyId;

								if($companyId>0)
								{
									$boardString=str_replace('"','',$boardString);
									if(trim($boardString)!="")
									{
										$boardArray=explode(";",$boardString); // this has executive name, desig,comapny
										$boardArrayLength=count($boardArray);
										if($boardArrayLength >0)
										{
											for ($i=0;$i<=$boardArrayLength-1;$i++)
											{
												$board=$boardArray[$i];
												$boardSplit=explode(",",$board);
												$exename=$boardSplit[0];
												$desig=$boardSplit[1];
												$company=$boardSplit[2];
												$execId=rand();
												//echo "<br>Board Row--" .$i. "---" .$exename. " * " .$desig. " * " .$company;
												if(insert_Executives($execId,trim($exename),trim($desig),trim($company)))
												{
													//insert into pecompanies_board
													//echo "<br>Board Company - " .$companyId;
													if(insert_companies_board($companyId,$execId))
													{
													}
												}
											} //for array ends
										} //array length > 0 ends
									}
									$mgmtString=str_replace('"','',$mgmtString);
									if(trim($mgmtString)!="")
									{
										$mgmtArray=explode(";",$mgmtString); // this has executive name,desig
										$mgmtArrayLength=count($mgmtArray);
										if($mgmtArrayLength> 0)
										{
											for ($j=0;$j<=$mgmtArrayLength-1;$j++)
											{
												$mgmt=$mgmtArray[$j];
												$mgmtSplit=explode(",",$mgmt);
												$mgmtexename=$mgmtSplit[0];
												$mgmtdesig=$mgmtSplit[1];
												$mgmtcompany="";
												//echo "<br>Mgmt Row--" .$j. "----" .$mgmtexename. " * " .$mgmtdesig. " * " .$mgmtcompany;
												$mgmtexecId=rand();
												if(insert_Executives($mgmtexecId,trim($mgmtexename),trim($mgmtdesig),trim($mgmtcompany)))
												{
													//echo "<br>Mgmt Company - " .$companyId;
													if(insert_companies_managment($companyId,$mgmtexecId))
													{
													}
												}
											}
										}
									}
								$importTotal=$importTotal+1;
								echo "<br>Profile Imported - ".$importTotal .".  " .$portfoliocompany;
							} // if $companyid >0 loop ends
						} // $portfoliocompany != " loop ends


					} //if $i loop ends
				} //for each loop ends
			} // if $file loop ends
		} //file exists loop ends

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


/* function to insert executives in a common table */
function insert_Executives($executiveId,$executivename,$designation,$company)
{
	$dbexec = new dbInvestments();
	$insExecSql = "insert into executives(ExecutiveId,ExecutiveName,Designation,Company) values
	($executiveId,'$executivename','$designation','$company')";
	//echo "<br>Ins executive-  ". $insExecSql;
		if ($rsinsExecutive = mysql_query($insExecSql))
		{
			return true;
		}
//	$dbexec.close();
}

function insert_companies_board($PEcompanyId,$executiveId)
{
	$dbexecboard = new dbInvestments();
	$insExecBoardSql = "insert into REcompanies_board values ($PEcompanyId,$executiveId)";
	//echo "<br>Ins Board-  ". $insExecBoardSql;
		if ($rsinsExecutive = mysql_query($insExecBoardSql))
		{
			return true;
		}
	//$dbexecboard.close();
}

function insert_companies_managment($PEcompanyId,$executiveId)
{
	$dbexecmgmt = new dbInvestments();
	$insExecmgmtSql = "insert into REcompanies_management values ($PEcompanyId,$executiveId)";
		//echo "<br>Ins Mgm t-  ". $insExecmgmtSql;

		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
			return true;
		}
//	$dbexecmgmt.close();
}


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
	function insert_company($companyname,$industryId,$sector,$city,$web,$stockcode,$yearfounded,$add1,$add2,$adcity,$zip,$otherloc,$country,$tel,$fax,$email,$addinfor,$regionId)
	{
		$dbpecomp = new dbInvestments();
		$companyname=trim($companyname);
		$getPECompanySql = "select PECompanyId from REcompanies where companyname like '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			//echo "<br>Count-" .$pecomp_cnt;

			if ($pecomp_cnt==0)
			{
					//echo "<Br>Insert company";
					$insPECompanySql="insert into
					REcompanies(companyname,industry,sector_business,city,website,stockcode,yearfounded,Address1,Address2,AdCity,Zip,OtherLocation,Country,Telephone,Fax,Email,AdditionalInfor,RegionId)
					values('$companyname',$industryId,'$sector','$city','$web','$stockcode','$yearfounded','$add1','$add2','$adcity','$zip','$otherloc','$country','$tel','$fax','$email','$addinfor',$regionId)";
					//echo "<br>Ins company sql=" .$insPECompanySql;
					if($rsInsPECompany = mysql_query($insPECompanySql))
					{
						$companyId=0;
						return $companyId;
					}
			}
			elseif($pecomp_cnt==1)
			{
				//echo "<Br>Retrieve Company Id";
				While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
				{
					$companyId = $myrow[0];
					$updatePECompanySql="Update REecompanies set
					industry=$industryId,sector_business='$sector',website='$web',city='$city'
					stockcode='$stockcode',yearfounded='$yearfounded',Address1='$add1',Address2='$add2',
					AdCity='$adcity',Zip='$zip',OtherLocation='$otherloc',Country='$country',Telephone='$tel',
					Fax='$fax',Email='$email',AdditionalInfor='$addinfor',RegionId=$regionId where
					PEcompanyId=$companyId ";
					//echo "<br>Update company sql=" .$updatePECompanySql;
					if($rsupdatePECompany = mysql_query($updatePECompanySql))
					{
						return  $companyId;
					}
				}
				//echo "<Br>Retrieve Company Id-" .$companyId;
			}
		}
	//	$dbpecomp.close();
	}

/* function to insert the industry and return the industry id if exists */
	function insert_industry($industryname)
	{
		$dbindustrylink = new dbInvestments();
		$industryname=trim($industryname);
		$getIndustrySql = "select IndustryId from industry where industry like '$industryname'";
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
						return $IndustryId;
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
		//$dbindustrylink.closeDB();
	}


?>