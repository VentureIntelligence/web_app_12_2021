<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/tmp");
	//session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
	if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{ 
        //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['UserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
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
            $dlogUserEmail = $_SESSION['UserEmail'];
            $today = date('Y-m-d');

            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;

           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
        
        
        
        
		//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

				//global $LoginAccess;
				//global $LoginMessage;
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";


					$submitemail=$_POST['txthideemail'];
					$incubatorid=$_POST['txthideincubatorid'];
					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

					$filetitle= "Incubators";

					$getIncubatorsSql="SELECT DISTINCT pe.IncubatorId, inc.*,incftype.incTypeName
					FROM incubatordeals AS pe, incubators as inc,incfirmtypes as incftype
					WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 and inc.IncubatorId=$incubatorid and inc.incFirmTypeId= incftype.IncFirmTypeId";
				 $sql=$getIncubatorsSql;
				//echo "<br>---" .$sql;
				 //execute query
				 $result = @mysql_query($sql)
				     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                                 updateDownload($result);
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

				 	/*echo ("$tsjtitle");
				 	 print("\n");
				 	  print("\n");*/

				 //define separator (defines columns in excel & tabs in word)
				 $sep = "\t"; //tabbed character


					echo "Incubator"."\t";
                                        echo "Firm Type"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Zip"."\t";
					echo "Telephone"."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Funds Available"."\t";
					echo "Additional Information"."\t";
					echo "Management"."\t";
					echo "Incubatee"."\t";

					print("\n");
				 /*print("\n");*/
				 //end of printing column names

				 //start while loop to get data
				 /*
				 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
				 */

				 	$searchString="Undisclosed";
				 	$searchString=strtolower($searchString);
					$searchStringDisplay="Undisclosed";

				 	$searchString1="Unknown";
				 	$searchString1=strtolower($searchString1);

				 	$searchString2="Others";
				 	$searchString2=strtolower($searchString2);
					$invResult=substr_count($companyname,$searchString);
					$invResult1=substr_count($companyname,$searchString1);
					$invResult2=substr_count($companyname,$searchString2);

					
					$Investmentsql="select inc.IncDealId,inc.IncubatorId,inc.IncubateeId,pec.Companyname,inc.Individual
					from incubatordeals as inc, pecompanies as pec
					where inc.IncubatorId=$incubatorid and inc.IncubateeId=pec.PEcompanyId order by Companyname";
					//echo "<br>----" .$Investmentsql;
					if($getcompanyinvrs = mysql_query($Investmentsql))
					{
					    While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
					    {
						if($myInvestrow["Individual"]==1)
						{
							$openBracket="(";
							$closeBracket=")";
						}
						else
						{
							$openBracket="";
							$closeBracket="";
						}
						$companyName=$myInvestrow["Companyname"];
						$strIncubatee=$strIncubatee.",".$openBracket.$companyName.$closeBracket;
					    }
					    $strIncubatee =substr_replace($strIncubatee, '', 0,1);
					}
					//echo "<br>***************".$strIncubatee;
						
				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";

						$companyname=$row[2];
						$companyname=strtolower($companyname);
						$invResult=substr_count($companyname,$searchString);
						$invResult1=substr_count($companyname,$searchString1);
						$invResult2=substr_count($companyname,$searchString2);
					
						
						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
						    $companyId=$row[0];//CompanyId
						    $schema_insert .=$row[2].$sep; //Companyname
                                                    $schema_insert .=$row[15].$sep; //FirmType
						    $schema_insert .=$row[3].$sep; //Adress
						    $schema_insert .=$row[4].$sep; //address line 2
						    $schema_insert .=$row[5].$sep; //Ad city
						    $schema_insert .=$row[6].$sep; //zip
						    $schema_insert .=$row[7].$sep; //Telephone
						    $schema_insert .=$row[8].$sep; //Fax
						    $schema_insert .=$row[9].$sep; //Email
						    $schema_insert .=$row[10].$sep; //website
						    $schema_insert .=$row[11].$sep; //funds available
						    $schema_insert .=$row[12].$sep; //Moreinformation
						    $schema_insert .=$row[13].$sep; // Management
						    $schema_insert .=$strIncubatee.$sep; // Incubatee
   
						//commented the foll line in order to get printed $ symbol in excel file
					    // $schema_insert = str_replace($sep."$", "", $schema_insert);

				            $schema_insert .= ""."\n";
				 		//following fix suggested by Josue (thanks, Josue!)
				 		//this corrects output in excel when table fields contain \n or \r
				 		//these two characters are now replaced with a space
				 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
				         $schema_insert .= "\t";
				         print(trim($schema_insert));
				         print "\n";
				     	}
				     }

				    print "\n";
					print "\n";
					print "\n";
					print "\n";
					print "\n";
					echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
				 	print("\n");
				 	print("\n");

	/* mail sending area starts*/
							//mail sending

				$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
															dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
															dm.EmailId='$submitemail' AND dc.Deleted =0";
					if ($totalrs = mysql_query($checkUserSql))
					{
						$cnt= mysql_num_rows($totalrs);
						//echo "<Br>mail count------------------" .$checkUserSql;
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
											$subject="Export - $filetitle";
											$message="<html><center><b><u> Export - $filetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											    $companyname;
											</body>
											</html>";
										//mail($to,$subject,$message,$headers);
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

				}
  mysql_close();
    mysql_close($cnx);
    ?>