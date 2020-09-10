<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
        
        //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['MAUserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='MA'";
        $resUserLogSel = mysql_query($sqlUserLogSel);
        $cntUserLogSel = mysql_num_rows($resUserLogSel);
        if ($cntUserLogSel > 0){
            $resUserLogSel = mysql_fetch_array($resUserLogSel);
            $logSessionId = $resUserLogSel['sessionId'];
            if ($logSessionId != $sesID){
                header( 'Location: logoff.php?value=caccess' ) ;
            }
        }
        
        function updateDownload($res){
            //Added By JFR-KUTUNG - Download Limit
            $recCount = mysql_num_rows($res);
            $dlogUserEmail = $_SESSION['MAUserEmail'];
            $today = date('Y-m-d');

            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='MA' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;

           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='MA' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','MA','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
		$displayMessage="";
		$mailmessage="";

					$tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

					$submitemail=$_POST['txthideemail'];
					//$submitemail1=$_POST['txthideemail1'];
					$AcqId=$_POST['txthideAcqId'];
					//echo "<bR>-- ".$AcqId;
				$filetitle="Acquirer-Profile";
				if($AcqId>0)
			       { 	$getCompanySql="select ac.* from acquirers as ac where AcquirerId=$AcqId";
                               }
			       else
                               { 	$getCompanySql="SELECT distinct peinv.AcquirerId, ac.Acquirer,ac.IndustryId
							FROM acquirers AS ac, mama AS peinv
							WHERE ac.AcquirerId = peinv.AcquirerId and
							peinv.Deleted=0 order by Acquirer";
                                }
				 $sql=$getCompanySql;
				//echo "<br>---" .$sql;
				 //execute query
				 $result = @mysql_query($sql)
				     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                                 //updateDownload($result);
                                 echo mysql_num_rows($result);
                                exit;
				 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
				 //if parameter is not included, file returned will be in excel format ('.xls')
				 	if (isset($w) && ($w==1))
				 	{
				 		$file_type = "msword";
				 		$file_ending = "doc";
				 	}
				 	else
				 	{
				 		$file_type = "vnd.ms-excel";
				 		$file_ending = "xls";
					}
				 //header info for browser: determines file type ('.doc' or '.xls')
				 header("Content-Type: application/$file_type");
				 header("Content-Disposition: attachment; filename=$filetitle.$file_ending");
				 header("Pragma: no-cache");
				 header("Expires: 0");

				 /*    Start of Formatting for Word or Excel    */
				 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
				 	//create title with timestamp:
				 	if ($Use_Title == 1)
				 	{ 		echo("$title\n"); 	}

				 	echo ("$tsjtitle");
				 	 print("\n");
				 	  print("\n");

				 //define separator (defines columns in excel & tabs in word)
				 $sep = "\t"; //tabbed character

				 //start of printing column names as names of MySQL fields
				 //-1 to avoid printing of coulmn heading country
				// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
				// {
				// 	echo mysql_field_name($result,$i) . "\t";
				// }
					echo "Acquirer"."\t";
					echo "Industry"."\t";
					/*echo "Sector"."\t";
					echo "Stock Code"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Country"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";*/
				  echo "Website"."\t";
				/*	echo "Other Location(s)"."\t";
					echo "More Information"."\t"; */
					echo "Existing Industry"."\t";
					echo "Targets "."\t";
					print("\n");

				 print("\n");
				 //end of printing column names

				 //start while loop to get data
				 /*
				 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
				 */

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				          $AcqId=$row[0];//AcquirerId

						  $AcquirerName=$row[1];
				        $schema_insert .=$row[1].$sep; //AcquirerName

				        $AcIndustry=$row[2]; //Acquirer Industryid

						$acqIndustrySql="select industry from industry where industryid=".$AcIndustry;
						if ($rsindrow = mysql_query($acqIndustrySql))
						{
							if($myindrow=mysql_fetch_array($rsindrow,MYSQL_BOTH))
							{
								$acquirerIndustry=$myindrow["industry"];
							}
						}
						$schema_insert .=$acquirerIndustry.$sep; //Acquirer Industry

					/*	$schema_insert .=$row[3].$sep; //sector
						$schema_insert .=$row[4].$sep; //stock code
						$schema_insert .=$row[5].$sep; //Address
						$schema_insert .=$row[6].$sep; //Address1
						$schema_insert .=$row[7].$sep; //Cityyid(city)
						$schema_insert .=$row[16].$sep; //country, 9 is countryid
						$schema_insert .=$row[8].$sep; //zip
						$schema_insert .=$row[10].$sep; //Telephone
						$schema_insert .=$row[11].$sep; //Fax

						$schema_insert .=$row[12].$sep; //Email
					*/
						$schema_insert .=$row[13].$sep; //Website
					/*		$schema_insert .=$row[14].$sep; //Other Locations
						$schema_insert .=$row[15].$sep; //Additional Information
						*/
						$indSql= " SELECT DISTINCT i.industry AS ind, c.industry
								FROM pecompanies AS c, mama AS peinv, industry AS i
								WHERE peinv.AcquirerId =$AcqId
								AND c.PECompanyId = peinv.PECompanyId
								AND i.industryid !=15
								AND i.industryid = c.industry
								ORDER BY i.industry";
						if($rsind= mysql_query($indSql))
						{
                                                  $strInd="";
							While($myindrow=mysql_fetch_array($rsind, MYSQL_BOTH))
							{
								$strInd=$strInd.", ".$myindrow["ind"];
							}
							$strInd =substr_replace($strInd, '', 0,1);
						}
						$schema_insert .=$strInd.$sep; //Target industries

						$mandasql="select peinv.MAMAId,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,peinv.AcquirerId,
										peinv.PECompanyId,c.companyname,c.industry,i.industry as indname, inv.*
										from acquirers as inv,mama as peinv,pecompanies as c,industry as i
										where inv.AcquirerId=$AcqId and peinv.AcquirerId=inv.AcquirerId
									and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and c.industry=i.industryid
									and c.industry !=15
									order by DealDate desc";
						if($rsmanda= mysql_query($mandasql))
						{
                                                  $strMandA="";
							While($mymandarow=mysql_fetch_array($rsmanda, MYSQL_BOTH))
							{
								$strMandA=$strMandA.", ".$mymandarow["companyname"]."(".$mymandarow["indname"]. ";" .$mymandarow["dealperiod"].")";
							}
							$strMandA =substr_replace($strMandA, '', 0,1);
						}
						$schema_insert .=$strMandA.$sep; //MAMA deal


				     $schema_insert = str_replace($sep."$", "", $schema_insert);
				            $schema_insert .= ""."\n";
				 		//following fix suggested by Josue (thanks, Josue!)
				 		//this corrects output in excel when table fields contain \n or \r
				 		//these two characters are now replaced with a space
				 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
				         $schema_insert .= "\t";
				         print(trim($schema_insert));
				         print "\n";
				     }

	/* mail sending area starts*/
							//mail sending

			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM malogin_members AS dm,
															dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
															dm.EmailId='$submitemail1' AND dc.Deleted =0";
					if ($totalrs = mysql_query($checkUserSql))
					{
						$cnt= mysql_num_rows($totalrs);
						if ($cnt==1)
						{
							While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
							{
								if( date('Y-m-d')<=$myrow["ExpiryDate"])
								{
										$OpenTableTag="<table border=1 cellpadding=1 cellspacing=0 ><td>";
										$CloseTableTag="</table>";
										$headers  = "MIME-Version: 1.0\n";
										$headers .= "Content-type: text/html;
										charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";
										/* additional headers
										$headers .= "Cc: sow_ram@yahoo.com\r\n"; */
										$RegDate=date("M-d-Y");
										$to="arun.natarajan@gmail.com,arun@ventureintelligence.com";
										//$to="sow_ram@yahoo.com";
											$subject="Acquirer Profile - $AcquirerName";
											$message="<html><center><b><u> Acquirer Profile :- $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >
											<tr><td width=1%>Acquirer</td><td width=99%>$AcquirerName</td></tr>
											<td width=29%> $CloseTableTag</td></tr>
											</table>
											</body>
											</html>";
										mail($to,$subject,$message,$headers);
								}
								elseif($myrow["ExpiryDate"] >= date('y-m-d'))
								{
									$displayMessage= $TrialExpired;
									$submitemail="";
									$submitpassword="";
								}
							}
						}
						elseif ($cnt==0)
						{
							$displayMessage= "Invalid Login / Password";
							$submitemail="";
							$submitpassword="";
						}
					}
				/* mail sending area ends */


				//		}
				//else
				//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;

                                        mysql_close();

				?>


