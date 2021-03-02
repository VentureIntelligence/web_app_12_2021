<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/tmp");
	//session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
        $displayMessage="";
	$mailmessage="";
	if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{   
        //Check Session Id 
        $sesID=session_id();
		$emailid=$_SESSION['UserEmail'];
		$comname=$_POST['comname'];
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

	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

					$submitemail=$_POST['txthideemail'];
					$companyId=$_POST['txthideCompanyId'];
				// $filetitle="Comp-Profile";
				$filetitle=$comname." - Comp-Profile";
				$getCompanySql="SELECT pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
  			stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
  			c.country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,pec.angelco_compID,pec.CINNo
			FROM industry AS i,pecompanies AS pec,country as c
			WHERE pec.industry = i.industryid  and c.countryid=pec.countryid
			 AND  pec.PECompanyId=$companyId";
			 
			 $angelinvsql="SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor
				FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
   	                        angel_investors as peinv,peinvestors as inv
                                 WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                                 pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=$companyId
                                 and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";

				 $sql=$getCompanySql;
				//echo "<br>---" .$sql;
				 //execute query
				 $result = @mysql_query($sql)
				     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                                 updateDownload($result);

                                 
                                 
                                 
                                 // angelCo table
                                 $query2 = mysql_query("SELECT angelco_compID FROM pecompanies WHERE  PECompanyId=$companyId");
                                 $result2 = mysql_fetch_array($query2);
                                 $angelco_compID=$result2['angelco_compID'];
                                  $CIN=$result['CINNo'];
                                 
                                 
                                 $AngelCount=0;
                                 
                                 if($angelco_compID !=''){
      
      
                                    $profileurl ="https://api.angel.co/1/startups/$angelco_compID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";

                                    //role=founder&
                                    $roleurl ="https://api.angel.co/1/startups/$angelco_compID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";

                                    $profilejson = file_get_contents($profileurl);
                                    $profile = json_decode($profilejson);


                                    $rolejson = file_get_contents($roleurl);
                                    $roles = json_decode($rolejson);
                                    $roles = $roles->startup_roles;

                                    $AngelCount=1;
                                  }
  
                                 
                                 

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
					//echo "Stock Code"."\t";
					if($CIN !=" "){
						echo "CIN No "."\t";
					}
					echo "Year Founded"."\t";
					//echo "Address"."\t";
					//echo ""."\t";
					echo "City"."\t";
					echo "Country"."\t";
					//echo "Zip"."\t";
					echo "Telephone "."\t";
					//echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
                                        
                                         if($AngelCount==1)
                                        {
                                            echo "Description"."\t";
                                        }
                                        
					echo "Additional Information"."\t";
					echo "Other Location(s)"."\t";
					echo "Investors"."\t";
					echo "Investor Board Members"."\t";
                                        
                                         if($AngelCount==1)
                                        {
                                            echo "Founders"."\t";
                                        }
                                        
					echo "Top Management "."\t";
					echo "Exits "."\t";
					echo "Angel Investors "."\t";

                                         if($AngelCount==1)
                                        {
                                            echo "Investors (as per AngelList)"."\t";
                                        }
                                        

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
						$schema_insert .=$row[4].$sep; //sector_business
						//$schema_insert .=$row[6].$sep; //stockcode
						if($row[19] != "")
                        {
                            $schema_insert .=$row[19].$sep; //CIN
                        }
                        else
                        {
                            $schema_insert .= $sep;
                        }
                                                if($row[7]>0)
                                                {
                                                    $schema_insert .=$row[7].$sep; //yearfounded
                                                }
                                                else
                                                {
                                                    $schema_insert .= $sep;
                                                }

						//$schema_insert .=$row[8].$sep; //address
						//$schema_insert .=$row[9].$sep; //address line 2
						$schema_insert .=$row[10].$sep; //city
						$schema_insert .=$row[13].$sep; //Country
						//$schema_insert .=$row[11].$sep; //Country
						$schema_insert .=$row[14].$sep; //Telephone
						//$schema_insert .=$row[15].$sep; //Fax
						$schema_insert .=$row[16].$sep; //Email
						$schema_insert .=$row[5].$sep; //Website
                                                
                                                if($AngelCount==1)
                                                {
                                                    $schema_insert .=$profile->product_desc.$sep; // description
                                                }
                                        
						$schema_insert .=$row[17].$sep; //Description
						$schema_insert .=$row[12].$sep; //Other location

						$investorSql="select pe.PEId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
									peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
									peinvestors as inv where pe.PECompanyId=$companyId and
									peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
									and pec.PEcompanyId=pe.PECompanyId order by dates desc";

                                                 if($rsStage= mysql_query($investorSql))
						{

							While($myInvestorRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
                                                           $Investorname=trim($myInvestorRow["Investor"]);
							   $Investorname=strtolower($Investorname);
							   $invResult=substr_count($Investorname,$searchString);
							   $invResult1=substr_count($Investorname,$searchString1);
							   $invResult2=substr_count($Investorname,$searchString2);
							   if($myInvestorRow["AggHide"]==1)
                                                                    $addTrancheWord="; Tranche";
                                                                else
                                                                    $addTrancheWord="";
                                                            if($myInvestorRow["SPV"]==1)
                                                                    $addDebtWord="; Debt";
                                                                else
                                                                    $addDebtWord="";

                                                           if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
							   {
								$strStage=$strStage.", ".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].$addTrancheWord.$addDebtWord.")";
                                                           }
                                                         }
                                                        // echo "<br>***".$strStage;
                                                 }
                                               if($getcompanyrs1= mysql_query($investorSql))
					{
                                          $AddOtherAtLast="";
					      While($myInvestorrow1=mysql_fetch_array($getcompanyrs1, MYSQL_BOTH))
						{
							$Investorname1=trim($myInvestorrow1["Investor"]);
							$Investorname1=strtolower($Investorname1);
							$invResulta=substr_count($Investorname1,$searchString);
							$invResult1b=substr_count($Investorname1,$searchString1);
							$invResult2c=substr_count($Investorname1,$searchString2);
							if($myInvestorrow1["AggHide"]==1)
                                                                    $addTrancheWord1="; Tranche";
                                                                else
                                                                    $addTrancheWord1="";
							if(($invResulta==1)|| ($invResult1b==1) || ($invResult2c==1))
							    {
								$strStage=$strStage.", ".$myInvestorrow1["Investor"]."(".$myInvestorrow1["dt"].$addTrancheWord1.")";
							    }
					                 }

						}
						$strStage =substr_replace($strStage, '', 0,1);
						$schema_insert .=$strStage.$sep; //Investors


				/*		if($rsStage= mysql_query($investorSql))
						{
							While($myInvestorRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
								$Investorname=trim($myInvestorrow["Investor"]);
								$Investorname=strtolower($Investorname);
								$invResult=substr_count($Investorname,$searchString);
								$invResult1=substr_count($Investorname,$searchString1);
								$invResult2=substr_count($Investorname,$searchString2);
								if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
								{
									$strStage=$strStage.", ".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].")";
								}
								else
									$addOtherAtLast=$addOtherAtLast.",".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].")";

							}

							$strStage =substr_replace($strStage, '', 0,1);
							$addOtherAtLast=substr_replace($addOtherAtLast, '', 0,1);

							$strInvestor=$strStage.$addOtherAtLast;
						}
						$schema_insert .=$strInvestor.$sep; //Investors

					*/

					$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
						exe.ExecutiveName,exe.Designation,exe.Company from
						pecompanies as pec,executives as exe,pecompanies_board as bd
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

                                                
                                                if($AngelCount==1)
                                                {
                                                    
                                                    foreach ($roles as $ro) {  
                                                        if($ro->role == 'founder') { 
                                                            $Angelfounder[] = $ro->tagged->name;
                                                        }
                                                    }
                                                    $Angelfounders = implode(',', $Angelfounder);
                                                    $schema_insert .=$Angelfounders.$sep; //Founders
                                                    
                                                }

				$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
				exe.ExecutiveName,exe.Designation,exe.Company from
				pecompanies as pec,executives as exe,pecompanies_management as mgmt
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
			$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
						IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
						FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                                WHERE  i.industryid=pec.industry
						AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$companyId 
                                                 and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId
                                                order by dt desc";
					if($rsipoexit= mysql_query($ipoexitsql))
					{
					While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
						{
							$exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
                                                        if($exitstatusvalueforIPO==0)
                    		                        {$exitstatusdisplayforIPO="Partial Exit";}
                    		                        elseif($exitstatusvalueforIPO==1)
                                                        {  $exitstatusdisplayforIPO="Complete Exit";}
                                                        $strIpos=$strIpos.",".$ipoexitrow["Investor"]." ".$ipoexitrow["dt"].", ".$exitstatusdisplayforIPO;
						}
						$strIpos=substr_replace($strIpos,'',0,1);
						if((trim(strIpos)!=" ") &&($strIpos!=""))
						{
							$FinalStringIPOs="IPO:".$strIpos.";";
						}
					}




			$strmas="";
			$FinalStringMAs="";

			$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId,pe.ExitStatus,pe.DealTypeId, dt.DealType
			FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                        WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$companyId 
			and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId  and pe.DealTypeId=dt.DealTypeId

                        order by dt desc";
				if($rsmaexit= mysql_query($maexitsql))
					{
					While($maexitrow=mysql_fetch_array($rsmaexit, MYSQL_BOTH))
						{
                                                        $exitstatusvalue=$maexitrow["ExitStatus"];
                                                        if($exitstatusvalue==0)
                    		                        {$exitstatusdisplay="Partial Exit";}
                    		                        elseif($exitstatusvalue==1)
                                                        {  $exitstatusdisplay="Complete Exit";}
							$strmas=$strmas.",".$maexitrow["Investor"]." " .$maexitrow["dt"].", ".$maexitrow["DealType"] .", ".$exitstatusdisplay;
						}
					}
					$strmas=substr_replace($strmas, '', 0,1);
					if($strmas!="")
					{
						$FinalStringMAs="".$strmas;
					}
				$schema_insert .=$FinalStringIPOs."" .$FinalStringMAs.$sep; // Exits IPOs-M&As


				if($rsangel= mysql_query($angelinvsql))
				{
				     $angel_cnt = mysql_num_rows($rsangel);
				}
                               	While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
				{
                                  	$strangelinvs=$strangelinvs.",".$angelrow["Investor"]."(".$angelrow["dt"].")";
				}
				$strangelinvs=substr_replace($strangelinvs, '', 0,1);
					$schema_insert .=$strangelinvs.$sep; // Angel investments

                                        
                                        
                                        
                                        if($AngelCount==1)
                                                {
                                                    foreach ($roles as $ro) {  
                                                        if($ro->role == 'past_investor' || $ro->role == 'current_investor') { 
                                                                $Angelinvestor[] =  $ro->tagged->name;
                                                        }
                                                    }
                                                        $Angelinvestors = implode(',', $Angelinvestor);
                                                        $schema_insert .=$Angelinvestors.$sep;        //Investors (as per AngelList)
                                                                
                                                }
                                                
                                                
                                                

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
											$subject="Company Profile - $filetitle";
											$message="<html><center><b><u> Company Profile :$frmwhichpage - $filetitle - $submitemail</u></b></center><br>
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
				//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
				}
   mysql_close();
    mysql_close($cnx);
    ?>


