<?php include_once("../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
        
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
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.in";

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page

					$submitemail=$_POST['txthideemail'];
					$PEId=$_POST['txthidePEId'];
					$company_name=$_POST['company_name'];
					$deal_date=$_POST['deal_date'];
					$SelCompRef=$PEId;

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

			$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city,
				r.Region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
				pe.InvestorType, its.InvestorTypeName,pe.StageId,Link,Valuation,FinLink ,AggHide,
				Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,Amount_INR, Company_Valuation_pre, Revenue_Multiple_pre, EBITDA_Multiple_pre, PAT_Multiple_pre, Company_Valuation_EV, Revenue_Multiple_EV, EBITDA_Multiple_EV, PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state
				FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
				investortype as its,stage as s,region as r
				WHERE pec.industry = i.industryid
				AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
				and pe.PEId=$SelCompRef and s.StageId=pe.StageId and   (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
				and its.InvestorType=pe.InvestorType ";

                                //echo "<Br>**" .$sql;
                    $investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                    peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',InvestorId desc";
            //echo "<Br>Investor".$investorSql;

                $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
                advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
                //echo "<Br>".$advcompanysql;

                $advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorinvestors as advinv,
                advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";

				//echo "<br>---" .$sql;exit;
				 //execute query
				 $result = @mysql_query($sql)
				     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                                 updateDownload($result);
                     $filetitle=$company_name."-".$deal_date;
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
					echo "Company Type"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "Amount (US\$M)"."\t";
					echo "Amount (INR)"."\t";
					echo "Round"."\t";
					echo "Stage "."\t";
					echo "Investors"."\t";
					echo "Investor Type"."\t";
					echo "Stake (%)"."\t";
					echo "Date"."\t";
                                        echo "Exit Status"."\t";
					echo "Website"."\t";
					echo "Year Founded"."\t";
					echo "City"."\t";
					echo "State"."\t";
					echo "Region"."\t";

					echo "Advisor-Company"."\t";
					echo "Advisor-Investors"."\t";
                                        
                                         echo "More Details"."\t";
					echo "Link"."\t";
                                        //Changes 30-08-2017
                                        /*echo "Company Valuation-Equity - Post Money (INR Cr)"."\t";
                                        echo "Revenue Multiple(based on Equity Value/Market Cap)"."\t";
                                        echo "EBITDA Multiple(based on Equity Value)"."\t";
                                        echo "PAT Multiple(based on Equity Value)"."\t";*/
                                        echo "Pre-Money"."\t";
                                        echo "Revenue Multiple"."\t";
                                        echo "EBITDA Multiple"."\t";
                                        echo "PAT Multiple"."\t";
                                        echo "Post-Money"."\t";
                                        echo "Revenue Multiple"."\t";
                                        echo "EBITDA Multiple"."\t";
                                        echo "PAT Multiple"."\t";
                                        echo "EV (Enterprise Valuation)"."\t";
                                        echo "Revenue Multiple"."\t";
                                        echo "EBITDA Multiple"."\t";
                                        echo "PAT Multiple"."\t";
                                        /////////
                                        
										//New Feature 08-08-2016 start
		
											echo "Price to Book"."\t";
											
										//New Feature 08-08-2016 end
                                        
                                        echo "Valuation (More Info)"."\t";
                                        echo "Revenue (INR Cr)"."\t";
                                        echo "EBITDA (INR Cr)"."\t";
                                        echo "PAT (INR Cr)"."\t";
                                        echo "Total Debt (INR Cr)" . "\t";
										echo "Cash & Cash Equ. (INR Cr)" . "\t";
											echo "Book Value Per Share"."\t";
											echo "Price Per Share"."\t";
					echo "Link for Financials"."\t";
                                       


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
				     	/*echo '<pre>'; print_r( $row ); echo '</pre>';
				     	exit;*/
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";

						$companyName = $row[1];
						$companyName=strtolower($companyName);
						$compResult=substr_count($companyName,$searchString);
						$listing_status_display="";
						if($row[29]=="L")
                                                       $listing_status_display="Listed";
                                                elseif($row[29]=="U")
                                                       $listing_status_display="Unlisted";

						 if($row[24]==1)
		                                       {
		                                       $openBracket="(";
		                                       $closeBracket=")";
                                                       }
                                                       else
                                                       {
		                                       $openBracket="";
		                                       $closeBracket="";
                                                       }
                                                  if($row[31]==1)
		                                       {
		                                       $openDebtBracket="[";
		                                       $closeDebtBracket="]";
                                                       }
                                                       else
                                                       {
		                                       $openDebtBracket="";
		                                       $closeDebtBracket="";
                                                       }

							if($compResult==0)
							{
							  $schema_insert .= $openDebtBracket.$openBracket.$row[1].$closeBracket.$closeDebtBracket.$sep;
							   $webdisplay=$row[10];
							 }
							 else
							{
								$schema_insert .=$openDebtBracket.$openBracket.$searchStringDisplay.$closeBracket.$closeDebtBracket.$sep;
								 $webdisplay="";
							}

                                                        $schema_insert.=$listing_status_display.$sep; //listingstatus
						$schema_insert .=$row[3].$sep; //industry
						$schema_insert .=$row[4].$sep; //sector

						/* if($row[16]==1)
						 	$hideamount="";
						else
							$hideamount=$row[5];*/
                                                $hideamount_INR="";
                                                if($row[16]==1){
                                                    $hideamount="";
                                                }else{
                                                    $hideamount=$row[5];
                                                    if($row[38] != 0.00){
                                                        $hideamount_INR=$row[38];
                                                    }
                                                }
	         		       		$schema_insert .= $hideamount.$sep; //amount
	         		       		$schema_insert .= $hideamount_INR.$sep; //amount INR
						$schema_insert .=$row[6].$sep; //round
						$schema_insert .=$row[7].$sep; //sector
						if($investorrs = mysql_query($investorSql))
						 {
							$investorString="";
							$AddOtherAtLast="";
							$AddUnknowUndisclosedAtLast="";
						   while($rowInvestor = mysql_fetch_array($investorrs))
							{
								$Investorname=$rowInvestor[2];
								$Investorname=strtolower($Investorname);

								$invResult=substr_count($Investorname,$searchString);
								$invResult1=substr_count($Investorname,$searchString1);
								$invResult2=substr_count($Investorname,$searchString2);

                                                                $investor_detail =trim($rowInvestor[2]);
                                                                if($investor_detail !=''){
                                                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
                                                                            //$investor_detail =trim(($rowInvestor[2].' - '.$rowInvestor[3].' - '.$rowInvestor[4].' - '.$rowInvestor[5]),' - ');
                                                                            $investorString .=", ".$investor_detail;
                                                                    }elseif(($invResult==1) || ($invResult1==1)){
                                                                            $AddUnknowUndisclosedAtLast .=", ".$investor_detail;
                                                                    }elseif($invResult2==1){
                                                                            $AddOtherAtLast .=", ".$investor_detail;
							}
                                                                }
							}

                                                                  $investorString =trim($investorString, ', ');
								if($AddUnknowUndisclosedAtLast!="")
								{
                                                                  $AddUnknowUndisclosedAtLast =trim($AddUnknowUndisclosedAtLast, ', ');
                                                                  $investorString .= ", ".$AddUnknowUndisclosedAtLast;
                                                                  }
								if($AddOtherAtLast!="")
								{
                                                                  $AddOtherAtLast = trim($AddOtherAtLast, ', ');
									$investorString .=", ".$AddOtherAtLast;
								}
						}              //$investorString =substr_replace($investorString, '', 0,1);
						$schema_insert .= $investorString.$sep;
						$schema_insert .=$row[19].$sep; //InvestorType
						if($row[17]==1 || ($row[8]<=0))
							$hidestake="";
						 else
							$hidestake=$row[8];
				 		 $schema_insert .= $hidestake.$sep; //stakepercentage

						$schema_insert .=$row[9].$sep; //Date
                                                $exitstatusis='';
                                                $exitstatusSql = "select id,status from exit_status where id=$row[30]";
                                                if ($exitstatusrs = mysql_query($exitstatusSql))
                                                {
                                                  $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                                                }
                                                if($exitstatus_cnt > 0)
                                                {
                                                        While($myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                                                        {
                                                                $exitstatusis = $myrow[1];
                                                        }
                                                }
                                                else{
                                                    $exitstatusis='';
                                                }

                                            //    if($row[33]==1){
                                            //        $exitstatusis='Unexited';
                                            //    }
                                            //    else if($row[33]==2){
                                            //        $exitstatusis='Partially Exited';
                                            //    }
                                            //    else if($row[33]==3){
                                            //        $exitstatusis='Fully Exited';
                                            //    }
                                            //    else{
                                            //        $exitstatusis='';
                                            //    }
                                                $schema_insert .= $exitstatusis . $sep;
						$dealDate = $row[9];
							$schema_insert .=$webdisplay.$sep; //Website
							$schema_insert .= $row[49].$sep;  //year founded
						$schema_insert .=$row[11].$sep; //City
						$schema_insert .=$row[50].$sep; //State
						$schema_insert .=$row[12].$sep; //Region



						 if($advisorcompanyrs = mysql_query($advcompanysql))
						 {
							 $advisorCompanyString="";
						   while($row1 = mysql_fetch_array($advisorcompanyrs))
							{
								$advisorCompanyString=$advisorCompanyString.",".$row1[2]."(".$row1[3].")";
							}
								$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
						}
								$schema_insert .= $advisorCompanyString.$sep; //Advisor-company


						if($advisorinvestorrs = mysql_query($advinvestorssql))
						 {
							 $advisorInvestorString="";
						   while($row2 = mysql_fetch_array($advisorinvestorrs))
							{
								$advisorInvestorString=$advisorInvestorString.",".$row2[2]."(".$row2[3].")";
							}
								$advisorInvestorString=substr_replace($advisorInvestorString, '', 0,1);
						}
								$schema_insert .= $advisorInvestorString.$sep; //Advisor-Investor

							     $resmoreinfo = preg_replace('/(\v|\s)+/', ' ', $row[15]);//more details
                                                            $schema_insert .=  $resmoreinfo.$sep; 
                                                            
                                                            $schema_insert .= $row[21].$sep;  //link


                                                                $dec_company_valuation=$row[25];

                                                                $dec_revenue_multiple=$row[26];

                                                                $dec_ebitda_multiple=$row[27];

                                                                $dec_pat_multiple=$row[28];
                                                                
																   
                                                                //New Feature 08-08-2016 start

                                                                  $price_to_book=$row[35]; 
                                                                  if($price_to_book<=0)
                                                                         $price_to_book="";


                                                                  $book_value_per_share=$row[36]; 
                                                                  if($book_value_per_share<=0)
                                                                        $book_value_per_share="";


                                                                 $price_per_share=$row[37]; 

                                                                //New Feature 08-08-2016 end
                                                            //Pre Money
                                                            $schema_insert .= $row[39].$sep;  //company valuation
                                                            $schema_insert .= $row[40].$sep;  //Revenue Multiple
                                                            $schema_insert .= $row[41].$sep;  //EBITDA Multiple
                                                            $schema_insert .= $row[42].$sep;  //PAT Multiple
                                                            
                                                            //Post Money                                                            
                                                            $schema_insert .= $dec_company_valuation.$sep;  //company valuation
                                                            $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
                                                            $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
                                                            $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
                                                            
                                                            //Equity
                                                            $schema_insert .= $row[43].$sep;  //company valuation
                                                            $schema_insert .= $row[44].$sep;  //Revenue Multiple
                                                            $schema_insert .= $row[45].$sep;  //EBITDA Multiple
                                                            $schema_insert .= $row[46].$sep;  //PAT Multiple
                                                          
														   $schema_insert .= $price_to_book.$sep;  //price_to_book
                                                          
                                                           $schema_insert .= trim($row[22]).$sep;  //Valuation
                                                            
                                                           $dec_revenue=$row[32];
                                                            if($dec_revenue > 0 || $dec_revenue < 0){
                                                                $schema_insert .= $dec_revenue.$sep;  //Revenue 
                                                            }else{
                                                               if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                                                            
                                                                   $schema_insert .= number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '').$sep;
                                                               }
                                                               else{
                                                               $schema_insert .= '0'.$sep;
                                                               }
                                                            }

                                                                $dec_ebitda=$row[33];
                                                            if($dec_ebitda > 0 || $dec_ebitda < 0){
                                                                $schema_insert .= $dec_ebitda.$sep;  //EBITDA 
                                                            }else{
                                                                if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                                                                    
                                                                   $schema_insert .= number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '').$sep;
                                                               }
                                                               else{
                                                                $schema_insert .= '0'.$sep;
                                                               }
                                                            }

                                                                $dec_pat=$row[34];
                                                            if($dec_pat > 0 || $dec_pat < 0){
                                                                $schema_insert .= $dec_pat.$sep;  //PAT 
                                                            }else{
                                                                if($dec_company_valuation >0 && $dec_pat_multiple >0){
                                                                   
                                                                   $schema_insert .= number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '').$sep;
                                                               }
                                                               else{
                                                                $schema_insert .= '0'.$sep;
                                                               }
                                                            }
                                                            
														   $schema_insert .= $row[47].$sep;  //Total Debt
														   $schema_insert .= $row[48].$sep;  //Cash & Cash Equ.

														   $schema_insert .= $book_value_per_share.$sep;  //book_value_per_share
														   $schema_insert .= $price_per_share.$sep;  //price_per_share
                                                                                                                   
                                                            $schema_insert .= $row[23].$sep;  //Financial link
                                                            
                                                           
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
										$to="arun.natarajan@gmail.com,arun@ventureintelligence.in";
										//$to="sow_ram@yahoo.com";
											$subject="PE Deal Export by- ".$submitemail;
											$message=" $companyName - $dealDate ";
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

					print "\n";
					print "\n";
					print "\n";
					print "\n";
					print "\n";
					echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
				 	print("\n");
				 	print("\n");
				/* mail sending area ends */


				//		}
				//else
				//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;

    mysql_close();
    mysql_close($cnx);
    ?>