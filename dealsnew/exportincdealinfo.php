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

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page

					$submitemail=$_POST['txthideemail'];
					$PEId=$_POST['txthideIncDealId'];
					$companyname=$_POST['txthidecompanyname'];
					$txthideDealdate=$_POST['txthideDealdate'];
					$SelCompRef=$PEId;
					$date = explode("-",$txthideDealdate);
					$datenew=date_create($date[1]."-".$date[0]."-01");
					$dateformated = date_format($datenew,"My");

					$filename = $companyname." ".$dateformated;
					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

			$sql="SELECT pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 pec.website, pec.AdCity,
				 pec.region,MoreInfor,pe.IncubatorId,inc.Incubator,pec.RegionId,
				 pe.StatusId,pec.yearfounded,Individual,s.Status,FollowonFund,pec.CINNo
				 		 FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,
					     incubators as inc,incstatus as s
						 WHERE pec.industry = i.industryid
						 AND pec.PEcompanyID = pe.IncubateeId and pe.Deleted=0 and pec.industry !=15
						 and pe.IncDealId=$SelCompRef and s.StatusId=pe.StatusId
						 and inc.IncubatorId=pe.IncubatorId";

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
				 header("Content-Disposition: attachment; filename=$filename.$file_ending");
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

				 //start of printing column names as names of MySQL fields
				 //-1 to avoid printing of coulmn heading country
				// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
				// {
				// 	echo mysql_field_name($result,$i) . "\t";
				// }
					echo "Company"."\t";
					echo "CIN"."\t";
					echo "Year Founded"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "City"."\t";
					echo "Region"."\t";
					echo "Website"."\t";
					echo "Incubator"."\t";
					echo "Status"."\t";
					echo "Angel/VC Funded"."\t";    
					echo "More Details"."\t";

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

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				         $strIndustry="";
				         $strCompany="";



								if($row[14]==1)
								{
									$openBracket="(";
									$closeBracket=")";
								}
								else
								{
									$openBracket="";
									$closeBracket="";
								}
								$regionId=$row[11];
								if($regionId>0)
								{
									$getRegionSql="select Region from region where RegionId=$regionId";
									if ($rsregion = mysql_query($getRegionSql))
									{
										While($regionrow=mysql_fetch_array($rsregion, MYSQL_BOTH))
										{
											$regiontext=$regionrow["Region"];
										}
									}
								}
								else
									{$regiontext=$row["Region"];
								}


								if($row[13] >0)
									$yearfounded=$row[13];
								else
									$yearfounded="";


						$companyName = $row[1];
						$companyName=strtolower($companyName);
						$compResult=substr_count($companyName,$searchString);
							if($compResult==0)
							{
							  $schema_insert .= $openBracket .$row[1].$closeBracket .$sep;
							   $webdisplay=$row[5];
							 }
							 else
							{
								$schema_insert .= $searchStringDisplay.$sep;
								 $webdisplay="";
							}
							$schema_insert .=$row[17].$sep; //cinno
							$schema_insert .=$yearfounded.$sep; //year founded
						$schema_insert .=$row[3].$sep; //industry
						$schema_insert .=$row[4].$sep; //sector


						$schema_insert .=$row[6].$sep; //city
				 		$schema_insert .= $regiontext.$sep; //regiontext
						$schema_insert .=$webdisplay.$sep; //Website

						$schema_insert .= $row[10].$sep; //Incubator
						$schema_insert .=$row[15].$sep; //status
						
						if($row[16]==1)
						    $funding="Obtained";
						else
						    $funding="None";
						$schema_insert .=$funding.$sep; //Follow on  funding

						$schema_insert .= $row[8].$sep; //MoreInfor

						//COMMENTED THE FOLLOWING LINE INORDER TO AVOID COLUMNS THAT HAS $ HAS THE FIRST CHARCTER PRINTING IN THE PREV COLUMN
					     //$schema_insert = str_replace($sep."$", "", $schema_insert);
				            $schema_insert .= ""."\n";
				 		//following fix suggested by Josue (thanks, Josue!)
				 		//this corrects output in excel when table fields contain \n or \r
				 		//these two characters are now replaced with a space
				 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
				         $schema_insert .= "\t";
				         print(trim($schema_insert));
				         print "\n";
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
											$subject="Incubator Deal Export by- ".$submitemail;
											$message=" $companyName ";
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
				}
  mysql_close();
    mysql_close($cnx);
    ?>


