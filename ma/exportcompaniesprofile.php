<?php
	//session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
		//include('onlineaccount.php');
        include ('machecklogin.php'); 
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

				//global $LoginAccess;
				//global $LoginMessage;
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page
					$pe_ipo_manda_flag=$_POST['hidepeipomandapage'];
					$pe_ipo_manda_flag=1;

					$pe_vc_flag=$_POST['hidevcflagValue'];
                                       // echo "<br>%%%%".$pe_vc_flag;
					$isShowAll=$_POST['hideShowAll'];
					$submitemail=$_POST['txthideemail'];
                                        
					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                                if($isShowAll!="")
                                {
                                    if($pe_vc_flag==9)	
                                    {
                                       
                                        $getInvestorSql="SELECT  DISTINCT pe.PECompanyId,pec.companyname, pec.industry, i.industry, pec.sector_business,
                                        stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,
                                        pec.Telephone,pec.Fax,pec.Email,website,pec.OtherLocation,pec.AdditionalInfor,linkedin_companyname, pec.companyname, pec.industry,
                                        i.industry, sector_business FROM mama AS pe, industry AS i, pecompanies AS pec WHERE pec.industry = i.industryid 
                                        AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and industryid IN (".$_SESSION['MA_industries'].")  order by pec.companyname";
                                    }
                                }
  
  				 $sql=$getInvestorSql;
//				echo "<br>---" .$sql;
//                                exit;
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
                              
                                $filetitle="M&A_Companies";

				 //header info for browser: determines file type ('.doc' or '.xls')
				 header("Content-Type: application/$file_type");
				 header("Content-Disposition: attachment; filename=M&A_Companies.$file_ending");
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
					echo "Other Location(s)"."\t";

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

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";
                                        $companyname=$row[3];
                                        $companyname=strtolower($companyname);
                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $schema_insert .=$row[1].$sep; //Companyname
                                            $schema_insert .=$row[3].$sep; //Industry
                                            $schema_insert .=$row[4].$sep; //sector
                                            $schema_insert .=$row[5].$sep; //Stock code
                                            $schema_insert .=$row[6].$sep; //Year founded
                                            $schema_insert .=$row[7].$sep; //Adress
                                            $schema_insert .=$row[8].$sep; //address line 2
                                            $schema_insert .=$row[9].$sep; //Ad city
                                            //$schema_insert .=$row[24].$sep; //Region
                                            $schema_insert .=$row[16].$sep; //Country
                                            $schema_insert .=$row[10].$sep; //zip
                                            $schema_insert .=$row[11].$sep; //Telephone
                                            $schema_insert .=$row[12].$sep; //Fax
                                            $schema_insert .=$row[13].$sep; //Email
                                            $schema_insert .=$row[14].$sep; //website
                                            $schema_insert .=$row[15].$sep; //Other Location
                                            //$schema_insert .=$row[20].$sep; //Moreinformation
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

mysql_close();
?>


