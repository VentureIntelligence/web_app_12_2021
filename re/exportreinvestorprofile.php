<?php include_once("../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();

        
        //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['REUserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='RE'";
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
            $dlogUserEmail = $_SESSION['REUserEmail'];
            $today = date('Y-m-d');

            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;

           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','RE','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
        
		//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

				//global $LoginAccess;
				//global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
				//global $dbemailsto;

				//echo "<br>---" .$dbemailsto;
					$strinvestorID=$_POST['txthideinvestorId'];
					$investorFlag=$_POST['txthideinvestorflag'];

                                        $industry=$_POST['txthideindustryid'];

					//echo "<br>PE VC Flag-" .$pe_vc_flag;
					//echo "<br>End date-" .$hidedateEndValue;
//					echo "<br>Date value-" .$strinvestorID;

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
				if($strinvestorID=="ShowAll")
				{
                                          if($investorFlag==0)
        				 {		$filetitle="RE-Investors";
        							$getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
        							FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv
        							WHERE pe.PECompanyId = pec.PEcompanyId
        							AND pec.industry =15
        							AND peinv.PEId = pe.PEId
        							AND inv.InvestorId = peinv.InvestorId
        							AND pe.Deleted=0  order by inv.Investor ";
        				}
        				elseif($investorFlag==1)
        				{
                                          $filetitle="RE-Investors-Investments";
        				$getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
        				FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv, realestatetypes AS s
        				WHERE pe.PECompanyId = pec.PEcompanyId
        				AND s.RETypeId = pe.StageId
        				AND pe.IndustryId =15
        				AND peinv.PEId = pe.PEId
        				AND inv.InvestorId = peinv.InvestorId
        				AND pe.Deleted=0 order by inv.Investor ";
        				}
                                        elseif($investorFlag==2)
                			{
                                          $filetitle="RE-Investors-IPOs";
                                           $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                				FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                				WHERE pe.PECompanyId = pec.PEcompanyId
                				AND pec.industry =15
                				AND peinv.IPOId = pe.IPOId
                				AND inv.InvestorId = peinv.InvestorId
                				AND pe.Deleted=0  order by inv.Investor ";
                                          }
                                        elseif($investorFlag==3)	//echo "<br>--" .$getInvestorSql;
                                        {
                                          $filetitle="RE-Investors-M&A";
                                           $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                							FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                							WHERE pe.PECompanyId = pec.PEcompanyId
                							AND pec.industry =15
                							AND peinv.MandAId = pe.MandAId
                							AND inv.InvestorId = peinv.InvestorId
                				AND pe.Deleted=0  order by inv.Investor ";
                                        }
                                        	//		echo "<br>--PE-" .$getInvestorSql;
				}
				elseif($strinvestorID>0)
				{
					$filetitle="RE-Investor";
					$getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
					FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv
					WHERE pe.PECompanyId = pec.PEcompanyId
					AND pec.industry =15
					AND peinv.PEId = pe.PEId
					AND inv.InvestorId = peinv.InvestorId and inv.InvestorId=$strinvestorID
					AND pe.Deleted=0  order by inv.Investor ";
				//	echo "<br>--- ".$getInvestorSql;
				}



				 $sql=$getInvestorSql;
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

				 //start of printing column names as names of MySQL fields
				 //-1 to avoid printing of coulmn heading country
				// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
				// {
				// 	echo mysql_field_name($result,$i) . "\t";
				// }
					echo "Investor"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Management"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Description"."\t";
					echo "Firm Type"."\t";
					echo "Other Location(s)"."\t";
					echo "Assets Under Management (US $M)"."\t";
					echo "Type"."\t";
					echo "Limited Partners"."\t";
					echo "Number of Funds"."\t";
					echo "Additional Info"."\t";
					echo "Industry (Existing Investments)"."\t";
					echo "Investments"."\t";
					echo "Exits - IPO"."\t";
					echo "Exits - M&A"."\t";
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
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";

				         $InvestorId=$row[0];//investorid
						$schema_insert .=$row[1].$sep; //Investorname
						$schema_insert .=$row[4].$sep; //address
						$schema_insert .=$row[5].$sep; //address line 2
						$schema_insert .=$row[6].$sep; //city
						$schema_insert .=$row[7].$sep; //zip
						$schema_insert .=$row[8].$sep; //Telephone
						$schema_insert .=$row[9].$sep; //Fax

						$onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
						exe.ExecutiveName,exe.Designation,exe.Company from
						REinvestors as pec,executives as exe,REinvestors_management as mgmt
						where pec.InvestorId=$InvestorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
						if($rsMgmt= mysql_query($onMgmtSql))
						{
							$MgmtTeam="";
							While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
							{
								$Exename= $mymgmtrow["ExecutiveName"];
								$Designation=$mymgmtrow["Designation"];
								if($Designation!="")
									$MgmtTeam=$MgmtTeam.";".$Exename."-".$Designation;
								else
									$MgmtTeam=$MgmtTeam.";".$Exename;
							}
							$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
						}
						$schema_insert .=$MgmtTeam.$sep; //Management Team

						$schema_insert .=$row[10].$sep; //Email
						$schema_insert .=$row[11].$sep; //Website
						$schema_insert .=$row[13].$sep; //Description

						$schema_insert .=$row[16].$sep; //Firm Type
						$schema_insert .=$row[17].$sep; //Other Location
						$schema_insert .=$row[18].$sep; //Assets under managment

						$stageSql= "select distinct s.REType,pe.StageId,peinv_inv.InvestorId
									from REinvestments_investors as peinv_inv,REinvestors as inv,REinvestments as pe,realestatetypes as s
									where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
									and pe.PEId=peinv_inv.PEId and s.RETypeId=pe.StageId and REType!='' order by REType ";
						if($rsStage= mysql_query($stageSql))
						{
							While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
								$strStage=$strStage.", ".$myStageRow[0];
							}
							$strStage =substr_replace($strStage, '', 0,1);
						}
						$schema_insert .=$strStage.$sep; //Type
						$schema_insert .=$row[21].$sep; //Limited Partners
						$schema_insert .=$row[22].$sep; //Number of funds
						$schema_insert .=$row[25].$sep; //Addtional Info

						/*$indSql= " SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
											FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
											WHERE peinv_inv.InvestorId =$InvestorId
											AND inv.InvestorId = peinv_inv.InvestorId
											AND c.PECompanyId = peinv.PECompanyId
											AND peinv.PEId = peinv_inv.PEId
							AND i.industryid = c.industry order by i.industry";*/
                                                
                                                if($industry > 0){
                                                    $indSql= " SELECT DISTINCT i.industry as ind, peinv.IndustryId, peinv_inv.InvestorId
    FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
    WHERE peinv_inv.InvestorId =$InvestorId AND inv.InvestorId = peinv_inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
    AND peinv.PEId = peinv_inv.PEId AND i.industryid = peinv.IndustryId and peinv.IndustryId = $industry  order by i.industry";
                                                }else{
                                                    $indSql = "SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
											FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
											WHERE peinv_inv.InvestorId =$InvestorId
											AND inv.InvestorId = peinv_inv.InvestorId
											AND c.PECompanyId = peinv.PECompanyId
											AND peinv.PEId = peinv_inv.PEId
							AND i.industryid = c.industry order by i.industry";
                                                }    

						if($rsInd= mysql_query($indSql))
							{
								While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
								{
									$strIndustry=$strIndustry.", ".$myIndrow["ind"];
								}
								$strIndustry =substr_replace($strIndustry, '', 0,1);
							}

						$schema_insert .=$strIndustry.$sep; //Industry for Existing investments

				// Existing Investments with deal date

						$Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
								c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.*
								from REinvestments_investors as peinv_inv,REinvestors as inv,
								REinvestments as peinv,REcompanies as c
								where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
								and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
								 and c.PECompanyId=peinv.PECompanyId
								order by peinv.dates desc";
                                                
                                                if($industry > 0){
                                                    $indSql1 = mysql_query("select peinv_inv.PEId
                                                    FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
                                                    WHERE peinv_inv.InvestorId =$InvestorId and inv.InvestorId = peinv_inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                                                    AND peinv.PEId = peinv_inv.PEId AND i.industryid = peinv.IndustryId AND peinv.IndustryId = $industry group by peinv_inv.PEId order by i.industry");
                                                    $PEIds= ' ( ';
                                                        While($indSqlrow=mysql_fetch_array($indSql1, MYSQL_BOTH))
                                                        {
                                                            $PEIds .= " peinv_inv.PEId=".$indSqlrow['PEId'].' or ';
                                                        }
                                                        $PEIds = trim($PEIds, ' or ');
                                                        if($PEIds== ' ( '){
                                                            $PEIds = '';
                                                        }else{
                                                            $PEIds .= ' ) ';                                                                                    
                                                        }
                                                    $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
								c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.*
								from REinvestments_investors as peinv_inv,REinvestors as inv,
								REinvestments as peinv,REcompanies as c
								where $PEIds and peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
								and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
								 and c.PECompanyId=peinv.PECompanyId
								order by peinv.dates desc";
                                                }else{
                                                    $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
								c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.*
								from REinvestments_investors as peinv_inv,REinvestors as inv,
								REinvestments as peinv,REcompanies as c
								where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
								and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
								 and c.PECompanyId=peinv.PECompanyId
								order by peinv.dates desc";
                                                }
                                                
						if ($getcompanyinvrs = mysql_query($Investmentsql))
						{
							While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
							{
								$companyName=trim($myInvestrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);
								if(($compResult==0) && ($compResult1==0))
									$compdisplay=$myInvestrow["companyname"];
								else
									$compdisplay= $searchStringDisplay;

								$strCompany=$strCompany.",".$compdisplay." - ".$myInvestrow["dealperiod"];
							}
						}
							$strInvestments =substr_replace($strCompany, '', 0,1);
							$schema_insert .=$strInvestments.$sep;

						// Existing IPO Exits with deal date

						$iposql="select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,c.companyname,DATE_FORMAT( peinv.IPODate, '%b-%Y' ) as dealperiod,inv.*from REipo_investors as peinv_inv,REinvestors as inv,	REipos as peinv,REcompanies as c where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId and peinv.Deleted=0 and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId";

							if ($getcompanyipors = mysql_query($iposql))
							{
								While($myInvestiporow=mysql_fetch_array($getcompanyipors, MYSQL_BOTH))
								{
									$ipocompanyName=trim($myInvestiporow["companyname"]);
									$ipocompanyName=strtolower($ipocompanyName);
									$ipocompResult=substr_count($ipocompanyName,$searchString);
									$ipocompResult1=substr_count($ipocompanyName,$searchString1);
									if(($ipocompResult==0) && ($ipocompResult1==0))
										$ipocompdisplay=$myInvestiporow["companyname"];
									else
										$ipocompdisplay= $searchStringDisplay;

									$stripoCompany=$stripoCompany.",".$ipocompdisplay."-".$myInvestiporow["dealperiod"];
								}
							}
								$stripoInvestments =substr_replace($stripoCompany, '', 0,1);
								$schema_insert .=$stripoInvestments.$sep;



				// Existing M&A Exits with deal date
							$mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
								c.companyname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,inv.*
								from REmanda_investors as peinv_inv,REinvestors as inv,
								REmanda as peinv,REcompanies as c
								where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
								and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
								order by DealDate desc";
							if ($getcompanymandars = mysql_query($mandasql))
							{
								While($myInvestmandarow=mysql_fetch_array($getcompanymandars, MYSQL_BOTH))
								{
									$mandacompanyName=trim($myInvestmandarow["companyname"]);
									$mandacompanyName=strtolower($mandacompanyName);
									$mandacompResult=substr_count($mandacompanyName,$searchString);
									$mandacompResult1=substr_count($mandacompanyName,$searchString1);
									if(($mandacompResult==0) && ($mandacompResult1==0))
										$mandacompdisplay=$myInvestmandarow["companyname"];
									else
										$mandacompdisplay= $searchStringDisplay;

									$strmandaCompany=$strmandaCompany.",".$mandacompdisplay."-".$myInvestmandarow["dealperiod"];
								}
							}
								$strmandaInvestments =substr_replace($strmandaCompany, '', 0,1);
							$schema_insert .=$strmandaInvestments.$sep;


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
				    print("\n");
				    print("\n");
				    print("\n");
				    print("\n");
				    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
				 	print("\n");
				 	print("\n");

	/* mail sending area starts*/
							//mail sending

				$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM RElogin_members AS dm,
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
											$subject="Investor Profile - $filetitle";
											$message="<html><center><b><u> Investor Profile : - $filetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >
											<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
											<tr><td width=1%>Investor Type</td><td width=99%>$strinvestorID</td></tr>
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
				//	header( 'Location: http://www.ventureintelligence.com/pelogin.php' ) ;

 mysql_close();  

				?>


