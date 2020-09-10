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
			$target = $currentdir . "/importfiles/" . basename($_FILES['txtincfielpath']['name']);
			$file = "importfiles/" . basename($_FILES['txtincfielpath']['name']);
			if (!(file_exists($file)))
			{
      			if(move_uploaded_file($_FILES['txtincfielpath']['tmp_name'], $target))
				{
					//echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
					echo "<br>File is getting uploaded . Please wait..";
					$file = "importfiles/" . basename($_FILES['txtfilepath']['name']);
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
				{		$data .= fgets($fp, 1024);
				}
				fclose($fp);

				$values = explode("\n", $data);
					foreach ($values as $i)
					{
				     // 	echo "<br>full string- " .$i;
        				if($i != "")
					{
				    //	echo "<br>full string- " .$i;
	                             // $individualFlag=0;

					$fstring = explode("\t", $i);
					$portfoliocompany = trim($fstring[0]);
					$industryname = trim($fstring[1]);
					$sector=$fstring[2];

					$IncubatorString=$fstring[3];
					$IncubatorId=insert_incubator($IncubatorString);
                                       	if($IncubatorId==0)
						$IncubatorId=insert_incubator($IncubatorString);

       					$yearfounded=$fstring[4];
                                        if($yearfounded=="")
                                        	$yearfounded=0;
					$website=$fstring[5];
					$city=$fstring[6];
                                        $region=$fstring[7];
                                        $regionId=returnRegionId($region);
                                        $comment=$fstring[8];
                                      	$moreinfor=$fstring[9];
                                        $status  =$fstring[10];
					$statusId=retunIncStatusId($status);
                                        $individualFlag=$fstring[11];
                                        if($individualFlag!=1)
                                        {
                                         $individualFlag=0;}

                    if (trim($portfoliocompany) !="")
					{

						$indid=insert_industry(trim($industryname));
					//	echo "<br>First Industryid-".$indid;
						if($indid==0)
						{
							$indid= insert_industry(trim($industryname));
							echo "<br>AFter insert Industryid-".$indid;
						}

						$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$regionId,$yearfounded);
						if($companyId==0)
						{
							$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$regionId,$yearfounded);
						}
						//$companyId=0;
						if ($companyId >0)
						{
							$getIncSql = "select IncubateeId,YearFounded from incubatordeals
							where IncubateeId=$companyId and YearFounded=$yearfounded and Deleted=0";
                                                        //echo "<br>---" .$getIncSql;

							if ($rsIncDeal= mysql_query($getIncSql))
							{
							$inc_cnt = mysql_num_rows($rsIncDeal);
						        //echo "<br>Count**********-- " .$inc_cnt ;
							}
							if($inc_cnt==0)
							{
							$IncDealId= rand();
							//echo "<br>random MandAId--" .$PEId;
							$rsincdealSql="";
							$rsincdealSql= "INSERT INTO incubatordeals (IncDealId,IncubateeId,IncubatorId,YearFounded,Comment,MoreInfor,StatusId,Deleted,Individual)
							VALUES ($IncDealId,$companyId,$IncubatorId,$yearfounded,'$comment','$moreinfor',$statusId,0,$individualFlag)";
						      	echo "<br><br>**** :".$rsincdealSql;
							if ($rsinsert = mysql_query($rsincdealSql))
							{
								//echo "<br>Insert PE-" .$rsincdealSql;

								$importTotal=$importTotal+1;
								$datedisplay =  $yearfounded; //(date("Y F", $fullDateAfter));
							?>
							<Br>
							<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany ; ?>&nbsp; --> Imported</td> </tr>
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
						<tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Deal already exists</td> </tr>
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
			<tr> <Td><b> File dont exist to read </b> </td></tR>
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

    	function retunIncStatusId($incstatus)
	{
		$incstatus=trim($incstatus);
		$dbslinkss = new dbInvestments();
		$getStatusIdSql="select StatusId from incstatus where Status like '$incstatus'";
		if($rsgetStatusId=mysql_query($getStatusIdSql))
		{
			$dealtype_cnt=mysql_num_rows($rsgetStatusId);
		       /*	if($dealtype_cnt==0)
			{
				//insert deal ..mostly it wont get inserted as new..standard 9 region already exists
				$insAcquirerSql="insert into region(Region) values('$region')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$regionId=0;
					return regionId;
				}
			}  */
		      if($dealtype_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetStatusId, MYSQL_BOTH))
				{
					$statusId = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $statusId;
				}
			}
		}
		$dbslinkss.close();
	}
/* function to insert the pecompanies(INCUBATOR) and return the company id if exists */
	function insert_incubator($incubatorname)
	{
		$dbinc = new dbInvestments();
		$pecomp_cnt=0;
		$getIncSql = "select IncubatorId from incubators where Incubator='$incubatorname'";
		if ($rsgetIncId = mysql_query($getIncSql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetIncId);
			if($pecomp_cnt==0)
			{
					$insPECompanySql="insert into incubators(Incubator,countryid) values('$incubatorname','IN')";
					if($rsgetIncId = mysql_query($insPECompanySql))
					{
						$IncId=0;
						return $IncId;
					}
			}
			elseif($pecomp_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetIncId, MYSQL_BOTH))
				{
					$IncId = $myrow[0];
					return $IncId;
				}
			}
		}
		$dbinc.close();
	}


/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$city,$regionId,$foundedyear)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname= '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,RegionId,yearfounded)
					values('$companyname',$industryId,'$sector','$web','$city','$regionId',$foundedyear)";
				//	echo "<br>Ins company sql=" .$insPECompanySql;
					if($rsInsPECompany = mysql_query($insPECompanySql))
					{
						$companyId=0;
						return $companyId;
					}
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



?>
