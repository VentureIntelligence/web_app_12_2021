<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
        
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
        
		$displayMessage="";
		$mailmessage="";

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

					$submitemail=$_POST['txthideemail'];
					$companyId=$_POST['txthideCompanyId'];
					$pe_ipo_manda_flag=$_POST['txthidepeipomandaflag'];
				$filetitle="RE_Comp-Profile";
				$getCompanySql="SELECT pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
  			stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
  			pec.Country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor
			FROM reindustry AS i,REcompanies AS pec
			WHERE pec.industry = i.industryid
			 AND  pec.PECompanyId=$companyId";

			 $sectorSql= "SELECT DISTINCT sector, PECompanyId
			 			FROM REinvestments
			WHERE PECompanyId=$companyId and sector!='' ";

                        if($pe_ipo_manda_flag==0)
                        {
  
                        $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt from
  			REinvestments as pe, REinvestments_investors as peinv,REcompanies as pec,
  			REinvestors as inv where pe.PECompanyId=$companyId and
  			peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
  			and pec.PEcompanyId=pe.PECompanyId";
		       }
		       elseif($pe_ipo_manda_flag==1)  //investors in RE-IPO Exits
        		{
        			$investorSql="select pe.IPOId as DealId,peinv.IPOId,peinv.InvestorId,inv.Investor,DATE_FORMAT( IPODate, '%b-%Y' ) as dt from
        			REipos as pe, REipo_investors as peinv,REcompanies as pec,
        			REinvestors as inv where pe.PECompanyId=$companyId and
        			peinv.IPOId=pe.IPOId and inv.InvestorId=peinv.InvestorId
        			and pec.PEcompanyId=pe.PECompanyId";
                        }
        		elseif($pe_ipo_manda_flag==2) // investors in RE-M&A Exits
        		{
        			$investorSql="SELECT pe.MandAId as DealId, peinv.MandAId, peinv.InvestorId, inv.Investor, DATE_FORMAT( DealDate, '%b-%Y' ) AS dt
        				FROM REmanda AS pe, REmanda_investors AS peinv, REcompanies AS pec, REinvestors AS inv
        				WHERE pe.PECompanyId =$companyId
        				AND peinv.MandAId = pe.MandAId
        				AND inv.InvestorId = peinv.InvestorId
        				AND pec.PEcompanyId = pe.PECompanyId";
        		}

                      //echo "<bR>**".$investorSql;
			if($rsSector= mysql_query($sectorSql))
			{
				While($myStageRow=mysql_fetch_array($rsSector, MYSQL_BOTH))
				{
					$strSector=$strSector.", ".trim($myStageRow["sector"]);
				}
				$strSector =substr_replace(trim($strSector), '', 0,1);
			}


				 $sql=$getCompanySql;
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
					echo "Company"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "Stock Code"."\t";
					echo "Year Founded"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Country"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "More Information"."\t";
					echo "Other Location(s)"."\t";
					echo "Investors"."\t";
					echo "Investor Board Members"."\t";
					echo "Top Management "."\t";
					echo "Exits "."\t";
					print("\n");

				 /*print("\n");*/
				 //end of printing column names

				 //start while loop to get data
				 /*
				 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
				 */

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";


				        $companyId=$row[0];//investorid
						$schema_insert .=$row[1].$sep; //CompanyName
						$companyName=$row[1];
						$schema_insert .=$row[3].$sep; //inudstry
						$schema_insert .=$strSector.$sep; //sector_business
						$schema_insert .=$row[6].$sep; //stockcode
						if($row[7]>0)
                                                {
                                                    $schema_insert .=$row[7].$sep; //yearfounded
                                                }
                                                else
                                                {
                                                    $schema_insert .= $sep;
                                                }

						$schema_insert .=$row[8].$sep; //address
						$schema_insert .=$row[9].$sep; //address line 2
						$schema_insert .=$row[10].$sep; //city
						$schema_insert .=$row[13].$sep; //Country
						$schema_insert .=$row[11].$sep; //Country
						$schema_insert .=$row[14].$sep; //Telephone
						$schema_insert .=$row[15].$sep; //Fax
						$schema_insert .=$row[16].$sep; //Email
						$schema_insert .=$row[5].$sep; //Website
						$schema_insert .=$row[17].$sep; //Description
						$schema_insert .=$row[12].$sep; //Description


						if($rsStage= mysql_query($investorSql))
						{
							While($myInvestorRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
								$strStage=$strStage.", ".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].")";
							}
							$strStage =substr_replace($strStage, '', 0,1);
						}
						//echo "<BR>*********************".$strStage;
						$schema_insert .=$strStage.$sep; //investors

					$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
						exe.ExecutiveName,exe.Designation,exe.Company from
						REcompanies as pec,executives as exe,REcompanies_board as bd
						where pec.PECompanyId=$companyId and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
								//echo "<Br>Board-" .$onBoardSql;

						if($rsBoard= mysql_query($onBoardSql))
						{
							$BoardTeam="";
							While($myboardrow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
							{
								$Exename= $myboardrow["ExecutiveName"];
								$Designation=$myboardrow["Designation"];
								if($Designation!="")
									$BoardTeam=$BoardTeam.";".$Exename.",".$Designation;
								else
									$BoardTeam=$BoardTeam.";".$Exename;

								$company=$myboardrow["Company"];
								if($company!="")
									$BoardTeam=$BoardTeam.";".$company;
								else
									$BoardTeam=$BoardTeam;

							}
							$BoardTeam=substr_replace($BoardTeam, '', 0,1);
						}
						$schema_insert .=$BoardTeam.$sep; //BoardTeam

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

			$strIpos="";
			$FinalStringIPOs="";
			$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry,
						IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId
						FROM REipos AS pe, reindustry AS i, REcompanies AS pec WHERE  i.industryid=pec.industry
						AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0  and pe.PECompanyId=$companyId order by dt desc";
					if($rsipoexit= mysql_query($ipoexitsql))
					{
					While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
						{
							$strIpos=$strIpos.",".$ipoexitrow["dt"];
						}
					}
						$strIpos=substr_replace($strIpos,'',0,1);
						if(trim(strIpos)!="")
						{
							$FinalStringIPOs="IPO:".$strIpos;
						}



			$strmas="";
			$FinalStringMAs="";

			$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry
			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId
			FROM REmanda AS pe, reindustry AS i, REcompanies AS pec WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0  and pe.PECompanyId=$companyId order by dt desc";
				if($rsmaexit= mysql_query($maexitsql))
					{
					While($maexitrow=mysql_fetch_array($rsmaexit, MYSQL_BOTH))
						{
							$strmas=$strmas.",".$maexitrow["dt"];
						}
					}
					$strmas=substr_replace($strmas, '', 0,1);
					if(strmas!="")
					{
						$FinalStringMAs="  M&A:".$strmas;
					}
				$schema_insert .=$FinalStringIPOs.$FinalStringMAs.$sep; // Exits IPOs-M&As


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
											$subject="Profile - $filetitle";
											$message="<html><center><b><u> Profile : - $filetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >

											<tr><td width=1%>Company</td><td width=99%>$companyName</td></tr>
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
				//	header( 'Location: '. GLOBAL_BASE_URL .'relogin.php' ) ;


 mysql_close();  
?>


