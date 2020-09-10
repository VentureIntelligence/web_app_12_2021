<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
	//	include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

			//	global $LoginAccess;
			//	global $LoginMessage;
			//	global $TrialExpired;

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page
					$pe_ipo_manda_flag=$_POST['hidepeipomandapage'];
					$pe_ipo_manda_flag=1;

					$pe_vc_flag=$_POST['hidevcflagValue'];
                                       // echo "<br>%%%%".$pe_vc_flag;
					$isShowAll=$_POST['hideShowAll'];

					$submitemail=$_POST['txthideemail'];

					$industry=$_POST['txthideindustryid'];
					$keyword=$_POST['txthidekeyword'];
					$stage=$_POST['txthidestageid'];
					$investorTypeId=$_POST['txthideinvestorTypeid'];
					$range=$_POST['txthiderange'];

					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];

					$investorID=$_POST['txthideinvestorId'];

					//echo "<br>PE VC Flag-" .$pe_vc_flag;
					//echo "<br>End date-" .$hidedateEndValue;
				//	echo "<br>Date value-" .$dateValue;

					$tsjtitle="© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                             
						// investments investors

                                                                 $filetitle="RE-Companies";
								$getInvestorSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
								FROM REcompanies AS pec, REinvestments AS pe, reindustry AS i, region AS r
								WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0
								AND i.industryid = pec.industry AND r.RegionId = pec.RegionId
							        ORDER BY pec.companyname";



				 $sql=$getInvestorSql;
			//	echo "<br>---" .$sql;
				 //execute query
				 $result = @mysql_query($sql)
				     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

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
					echo "CompanyName"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "StockCode"."\t";
					echo "Year Founded"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Region"."\t";
					echo "Country"."\t";
					echo "Zip"."\t";
					echo "Telephone"."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Other Location"."\t";
					echo "More Information"."\t";
					echo "Management"."\t";
					echo "Board Members"."\t";

					print("\n");
				 print("\n");
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

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";
						$companyname=$row[2];
						$companyname=strtolower($companyname);
						$invResult=substr_count($companyname,$searchString);
						$invResult1=substr_count($companyname,$searchString1);
						$invResult2=substr_count($companyname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{

								$companyId=$row[0];//CompanyId
								$schema_insert .=$row[2].$sep; //Companyname
								$schema_insert .=$row[23].$sep; //Industry
								$schema_insert .=$row[4].$sep; //sector
								$schema_insert .=$row[8].$sep; //Stock code
								$schema_insert .=$row[9].$sep; //Year founded
								$schema_insert .=$row[10].$sep; //Adress
								$schema_insert .=$row[11].$sep; //address line 2
								$schema_insert .=$row[12].$sep; //Ad city
								$schema_insert .=$row[24].$sep; //Region
								$schema_insert .=$row[15].$sep; //Country
								$schema_insert .=$row[13].$sep; //zip
								$schema_insert .=$row[17].$sep; //Telephone
								$schema_insert .=$row[18].$sep; //Fax
								$schema_insert .=$row[19].$sep; //Email
								$schema_insert .=$row[5].$sep; //website
								$schema_insert .=$row[14].$sep; //Other Location
								$schema_insert .=$row[20].$sep; //Moreinformation

								$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
								exe.ExecutiveName,exe.Designation,exe.Company from
								REcompanies as pec,executives as exe,REcompanies_management as mgmt
								where pec.PECompanyId=$companyId and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
								if($rsMgmt= mysql_query($onMgmtSql))
								{
									$MgmtTeam="";
									While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
									{
										$Exename= $mymgmtrow["ExecutiveName"];
										$Designation=$mymgmtrow["Designation"];
										if($Designation!="")
											$MgmtTeam=$MgmtTeam.";".$Exename.",".$Designation;
										else
											$MgmtTeam=$MgmtTeam.";".$Exename;
									}
									$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
								}
								$schema_insert .=$MgmtTeam.$sep; //Management Team

							$onBoardSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
								exe.ExecutiveName,exe.Designation,exe.Company from
								REcompanies as pec,executives as exe,REcompanies_board as mgmt
								where pec.PECompanyId=$companyId and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
								if($rsBoard= mysql_query($onBoardSql))
								{
									$MgmtTeam="";
									While($myBoardRow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
									{
										$Exename= $myBoardRow["ExecutiveName"];
										$Designation=$myBoardRow["Designation"];
										if($Designation!="")
											$MgmtTeam=$MgmtTeam.";".$Exename.",".$Designation;
										else
											$MgmtTeam=$MgmtTeam.";".$Exename;
									}
									$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
								}
								$schema_insert .=$MgmtTeam.$sep; //Management Team

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




				//		}
				//else
				//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;



				?>


