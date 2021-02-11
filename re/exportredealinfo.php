<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
    include ('checklogin.php');    
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

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page

					$submitemail=$_POST['txthideemail'];
					$PEId=$_POST['txthidePEId'];
					$SelCompRef=$PEId;

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

			$sql="SELECT pe.PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector as sector_business,
                        amount, round, s.REType, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pe.city,
                        r.Region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
                        pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.SPV,pe.RegionId,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status
                        FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,
                        investortype as its,realestatetypes as s,region as r
                        WHERE pe.IndustryId = i.industryid
                        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0
                        and pe.PEId=$SelCompRef and s.RETypeId=pe.StageId and r.RegionId=pe.RegionId
                        and its.InvestorType=pe.InvestorType ";

                        $investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from REinvestments_investors as peinv,
                        REinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
                        //echo "<Br>Investor".$investorSql;

                        $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from REinvestments_advisorcompanies as advcomp,
                        REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
                        //echo "<Br>".$advcompanysql;

                        $advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from REinvestments_advisorinvestors as advinv,
                        REadvisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";

//                        echo "<br>---" .$sql;
//                        exit;
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
				 header("Content-Disposition: attachment; filename=RE_dealInfo.$file_ending");
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
					echo "Project Name"."\t";
					echo "Industry"."\t";
					echo "Sector 1"."\t";
						echo "Sector 2 "."\t";
                                        echo "Amount (US$M)"."\t";
					echo "Round"."\t";

					echo "Investors"."\t";
					echo "Investor Type"."\t";
					echo "Stake (%)"."\t";
					echo "Date"."\t";
					echo "City"."\t";
					echo "Region"."\t";
                                        echo "Exit Status" . "\t";
					echo "Website"."\t";
					echo "Advisor-Company"."\t";
					echo "Advisor-Investors"."\t";
					echo "More Details"."\t";
					echo "Link"."\t";
					echo "Valuation"."\t";
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
                                         
                                       // echo "<pre>"; print_r($row); exit;
                                         
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

						if($row[21]==1)
							{
								$openBracket="(";
								$closeBracket=")";
							}
							else
							{
								$openBracket="";
								$closeBracket="";
							}

                                                if($compResult==0)
							{
							  $schema_insert .= $openBracket.$row[1].$closeBracket.$sep;
							   $webdisplay=$row[10];
							 }
							 else
							{
								$schema_insert .= $searchStringDisplay.$sep;
								$webdisplay="";
							}
						if($row[27]=="L")
                                                       $listing_status_display="Listed";
                                                elseif($row[27]=="U")
                                                       $listing_status_display="Unlisted";

                                                $schema_insert.=$listing_status_display.$sep; //listingstatus
						$schema_insert .=$row[26].$sep; //Project Name for SPV companies
						$schema_insert .=$row[3].$sep; //industry
						$schema_insert .=$row[4].$sep; //sector
                                                $schema_insert .=$row[7].$sep; //sector
						 if($row[16]==1)
						 	$hideamount="";
						else
							$hideamount=$row[5];
	         			$schema_insert .= $hideamount.$sep; //amount
						$schema_insert .=$row[6].$sep; //round

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

								if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
									$investorString=$investorString .", ".$rowInvestor[2];
								elseif(($invResult==1) || ($invResult1==1))
									$AddUnknowUndisclosedAtLast=$rowInvestor[2];
								elseif($invResult2==1)
									$AddOtherAtLast=$rowInvestor[2];
							}

								if($AddUnknowUndisclosedAtLast!=="")
								{	$investorString=$investorString .", ".$AddUnknowUndisclosedAtLast;
								 //       $investorString =substr_replace($investorString, '', 0,1);
							        }
								if($AddOtherAtLast!="")
								{
									$investorString=$investorString .", ".$AddOtherAtLast;
								//	$investorString =substr_replace($investorString, '', 0,1);
							         }
						}               $investorString =substr_replace($investorString, '', 0,1);

						$schema_insert .= $investorString.$sep;
						$schema_insert .=$row[19].$sep; //InvestorType
						if($row[17]==1 || ($row[8]<=0))
							$hidestake="";
						 else
							$hidestake=$row[8];
				 		 $schema_insert .= $hidestake.$sep; //stakepercentage

						$schema_insert .=$row[9].$sep; //Date
						$dealDate = $row[9];
						$schema_insert .=$row[11].$sep; //City
						$schema_insert .=$row[12].$sep; //Region
                                                
                                                //
                                                $exitstatusis='';
                                                $exitstatusSql = "select id,status from exit_status where id=$row[28]";
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

                                                $schema_insert .= $exitstatusis . $sep;
                                                //
                                                
                                                
						$schema_insert .=$webdisplay.$sep; //Website


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

							    $schema_insert .= $row[15].$sep;    //more infor
								 $schema_insert .= $row[23].$sep;  //Link
								  $schema_insert .= $row[24].$sep;  //Valuation
								   $schema_insert .= $row[25].$sep;  //Link for financials



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
	
	 $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,companyname,dealdate)   values('$submitemail','RE','Inv','$companyName','$dealDate') ";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {

      }
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
											$subject="RE Deal Export by- ".$submitemail;
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
				/* mail sending area ends */


				//		}
				//else
				//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;

 mysql_close();  

				?>