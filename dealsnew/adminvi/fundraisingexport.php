<?php include_once("../../globalconfig.php"); ?>
<?php

//use str_to_date() function of mysql

    //$sql = "INSERT INTO submissionfiledata "."(date,Name,FromEmailid,PhoneNumber,CountryName) "."VALUES " .
    //"STR_TO_DATE('05-13-2013', '%m-%d-%Y')  , '$name','$emailid', '$phone','$country')";



//fundraising export - jun/17/2013
     require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{

			//$file ="importfiles/peinvestmentsexport.txt";

			$currentdir=getcwd();
			echo "<BR>1. Current dir______________ ".basename($_FILES['txtfundraising']['name']);
			$target = $currentdir . "/importfiles/" . basename($_FILES['txtfundraising']['name']);
			$file = "importfiles/" . basename($_FILES['txtfundraising']['name']);

			echo"<br>2. ************".$file;
			if (!(file_exists($file)))
			{
                              echo "<br>3___________________";
				if(move_uploaded_file($_FILES['txtfundraising']['tmp_name'], $target))
				{
					echo "<Br>The file ". basename( $_FILES['txtfundraising']['name']). " has been uploaded";
					echo "<br>File is getting uploaded . Please wait..";
					$file = "importfiles/" . basename($_FILES['txtfundraising']['name']);
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
						//echo "<br>full string- " .$i;

						if($i != "")
						{
							//echo "<br>full string- " .$i;
							$fund_firm_typeId=0;
							$fundsize=0;
							$fundstatus=0;
							$fstring = explode("\t", $i);
							$investor_manager_string = trim($fstring[0]);
						//	if($investor_manager_string!="")
							$investorid=get_Investor($investor_manager_string);

						        $fundname = trim($fstring[1]);
							$fund_firm_type=$fstring[2];
							if($fund_firm_type!="")
							 { $fund_firm_typeId=return_firmtype($fund_firm_type); }
                                                        $fundsubtype=$fstring[3];
							$fundsize=$fstring[4];
							$fundstatus=$fstring[5];
                                                        if(trim($fundstatus)!="")
							{
								$fund_status_id=return_fundstatusid(trim($Stage));
							}
							$capitalsourceid=$fstring[6];

							$fundDate=$fstring[7];
							$moreinfor=trim($fstring[8]);
							$moreinfor=str_replace('"','',$moreinfor);
                                                        $source=$fstring[9]; //source

                                     				echo "<Br>INVESTOR ID----" .$investorId=0;
								if ($investorId >0)
								{

									if($investorId>0)
									{
											$PEId= rand();
											//echo "<br>random MandAId--" .$PEId;
											$insertcompanysql="";
											$insertcompanysql= "INSERT INTO fund_raising_details(InvestorId,fundname,FirmTypeId,subtype,size,fundstatusid,focuscapsourceid,funddate,moreinfo,source)
											VALUES ($investorid,'$fundname',$fund_firm_typeId,'$fundsubtype',$fundsize,$fund_status_id,$capitalsourceid,STR_TO_DATE('".$fund_Date."', '%m-%d-%Y'),'$moreinfor', '$source')";
											echo "<br>@@@@ :".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql_11))
											{


												$importTotal=$importTotal+1;
												$datedisplay =  $fundDate; //(date("Y F", $fullDateAfter));
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$investor_manager_string ; ?>&nbsp; --> Imported</td> </tr>
											<?php
											}
											else
											{
											?>
											<tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $investor_manager_string; ?>&nbsp; --> Import failed</td> </tr>
											<?php
											}
									//	echo "<br> insert-".$insertcompanysql;
									}

								}//if investorId >0 loop ends

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

 /*  returns the firm type id  */
	function return_firmtype($fund_firm_type)
	{
		$fund_firm_type=trim($fund_firm_type);
		$dbslinkss = new dbInvestments();
		$getfirmtypeSql="select FirmTypeId,FirmType from firmtypes where FirmType ='$fund_firm_type'";
	//	echo "<Br>DealSql--" .$getDealIdSql;
		if($rsfirmtype=mysql_query($getfirmtypeSql))
		{
			$firmtype_cnt=mysql_num_rows($rsfirmtype);
			if($firmtype_cnt==1)
			{
				While($myfrow=mysql_fetch_array($rsfirmtype, MYSQL_BOTH))
				{
					$firmtypeId = $myfrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $firmtypeId;
				}
			}
		}
		$dbslinkss.close();
	}


/*  returns the fundstatus id  */
	function return_fundstatusid($statusname)
	{
		$status=trim($statusname);
		$dbslinkss = new dbInvestments();
		$getfundstatussql="select fundstatusid,fundstatus from fundstatus where fundstatus ='$statusname'";
	//	echo "<Br>DealSql--" .$getDealIdSql;
		if($rsfund=mysql_query($getfundstatussql))
		{
			$fund_cnt=mysql_num_rows($rsfund);
			if($fund_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsfund, MYSQL_BOTH))
				{
					$statusid = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $statusid;
				}
			}
		}
		$dbslinkss.close();
	}

/* returns the investor id */
	function get_Investor($investor_mgr)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$InvestorId=0;
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor_mgr'";
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($investor_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$InvestorId = $myrow[0];
					return $InvestorId;
				}
			}
      		}
		$dblink.close();
	}


?>