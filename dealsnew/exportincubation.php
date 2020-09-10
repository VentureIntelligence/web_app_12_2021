<?php
 //session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();

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

                        $columntitle="";
                        $submitemail=$_POST['txthideemail'];
                        $pe_ipo_manda_flag=$_POST['hidepeipomandapage'];
                        $pe_vc_flag=$_POST['hidevcflagValue'];
                        $dealvalue=$_POST['txthidedv'];
                        $isShowAll=$_POST['hideShowAll'];
                        $industry=$_POST['txthideindustryid'];
                        $stageval=substr($_POST['txthidestageid'],1);
                        $investorType=$_POST['txthideinvestorTypeid'];
                        //echo "<bR>*******************".$investorTypeId;
                        $startRangeValue=$_POST['txthiderange'];
                        $endRangeValue=$_POST['txthiderangeEnd'];
                        //echo "<bR>-----" .$range;
                        $hidedateStartValue=$_POST['txthidedateStartValue'];
                        $hidedateEndValue=$_POST['txthidedateEndValue'];

                        $companysearch=$_POST['txthidecompany'];
                        $keyword=$_POST['txthidekeyword'];
                        $sectorsearch=$_POST['txthidesector'];
                        $advisorsearch_legal=$_POST['txthideadvisorlegal'];
                        $advisorsearch_trans=$_POST['txthideadvisortrans'];
                        $searchallfield=$_POST['searchallfield'];

                        $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                       
                        
                       if($dealvalue==105)
                        {
                                $addVCFlagqry="";
                                $filetitle="Incubator/Accelerator";
                        }
                        elseif($dealvalue==106)
                        {
                                $addVCFlagqry = "";
                                $filetitle="Incubatee";
                        }
                        
                        if($dealvalue==105)
                        {
                                $frmwhichpage="incubator";
                        }
                        elseif($dealvalue==106){
                                $frmwhichpage="incubatee";
                        }
                        
                      /* if($dealvalue==105)
                       {
                            if($searchallfield !=''){
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inc.Incubator like '$searchallfield%' or inc.City LIKE '$searchallfield%'
                                            OR inc.AdditionalInfor like '%$searchallfield%' or inc.Address1 like '%$searchallfield%' or inc.Address2 like '%$searchallfield%' or inc.Zip like '%$searchallfield%' or inc.Telephone like '%$searchallfield%' or inc.Fax like '%$searchallfield%' or inc.Email like '%$searchallfield%' or inc.website like '%$searchallfield%' or inc.Management like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                                $showallsql="SELECT DISTINCT pe.IncubatorId, inc.*
                                    FROM incubatordeals AS pe,  incubators as inc, pecompanies AS pec
                                         WHERE inc.IncubatorId=pe.IncubatorId and pec.PECompanyId = pe.IncubateeId and pe.Deleted=0 and ( $tagsval ) ".$search." ".$dirsearchall."
                                          order by inc.Incubator";                                
                            }else{
                                $showallsql="SELECT DISTINCT pe.IncubatorId, inc.*
                                     FROM incubatordeals AS pe,  incubators as inc
				WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 ".$search." ".$dirsearchall."
				 order by inc.Incubator";
                            }
                           
                           $getcompanySql=$showallsql;
                       }
                       else if($dealvalue==106)
                       {
                            if($searchallfield !=''){
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%'";                                    
                                }else{
                                    $tags = '';
                                    $ex_tags = explode(',',$searchallfield);
                                    if(count($ex_tags) > 0){
                                        for($l=0;$l<count($ex_tags);$l++){
                                            if($ex_tags[$l] !=''){
                                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                $tags .= "pec.tags like '%:$value%' or ";
                                            }
                                        }
                                    }
                                    $tagsval = trim($tags,' or ');
                                }
                            $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *,i.industry
				FROM pecompanies AS pec, incubatordeals AS pe,industry as i
				WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                                     and pe.Deleted=0 ".$search." ".$dirsearchall." and pec.industry!=15 and ( $tagsval )
                                    ORDER BY pec.companyname";
                            }else{
                                $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *,i.industry
				FROM pecompanies AS pec, incubatordeals AS pe,industry as i
				WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
				 and pe.Deleted=0 ".$search." ".$dirsearchall." and pec.industry!=15
				ORDER BY pec.companyname";
                            }
                            
                            $getcompanySql=$showallsql;
                       }
  			*/
                                $sql = $_POST['sqlquery'];
  				 //$sql=$getcompanySql;
				//echo "<br>---" .$sql;
				 //execute query
				 $result = @mysql_query($sql) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
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
                            if($dealvalue==105)
                            {
				 //define separator (defines columns in excel & tabs in word)
				 $sep = "\t"; //tabbed character

				        echo "Incubator"."\t";
					echo "Address1"."\t";
					echo "Address2"."\t";
					echo "City"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Funds Available"."\t";
					echo "Additional Info"."\t";
					echo "Management "."\t";
					echo "Incubatee"."\t";

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
				         
                                                
                                        $schema_insert .=$row[2].$sep;//Incubator
                                        $schema_insert .=$row[3].$sep; //Address
                                        $schema_insert .=$row[4].$sep; //Address1
                                        $schema_insert .=$row[5].$sep; //sector
                                        $schema_insert .=$row[6].$sep; //Stock code
                                        $schema_insert .=$row[7].$sep; //Year founded
                                        $schema_insert .=$row[8].$sep; //Adress
                                        $schema_insert .=$row[9].$sep; //address line 2
                                        $schema_insert .=$row[10].$sep; //Ad city
                                        //$schema_insert .=$row[24].$sep; //Region
                                        $schema_insert .=$row[11].$sep; //Country
                                        $schema_insert .=$row[12].$sep; //zip
                                        $schema_insert .=$row[13].$sep; //Telephone
                                        //$schema_insert .=$row[20].$sep; //Moreinformation

                                                    $strIncubatee = '';
                                                    $Investmentsql="select inc.IncDealId,inc.IncubatorId,inc.IncubateeId,pec.Companyname,inc.Individual
                                                    from incubatordeals as inc, pecompanies as pec
                                                    where inc.IncubatorId='".$row[0]."' and inc.IncubateeId=pec.PEcompanyId order by Companyname";
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
                            }else if($dealvalue==106){
                                
                                //define separator (defines columns in excel & tabs in word)
				 $sep = "\t"; //tabbed character

				        echo "Company"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "Stock Code"."\t";
					echo "Year Founded"."\t";
					echo "Address"."\t";
                                        echo "Address2"."\t";
					echo "City"."\t";
					//echo "Region"."\t";
					echo "Country"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Other Location(s)"."\t";
					//echo "More Information"."\t";

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
                                        $companyname=$row[2];
                                        $companyname=strtolower($companyname);
                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            //set_time_limit(60); // HaRa
                                           $schema_insert = "";

                                            $schema_insert .=$row[2].$sep; //Companyname
                                            $schema_insert .=$row[25].$sep; //Industry
                                            $schema_insert .=$row[4].$sep; //sector
                                            $schema_insert .=$row[8].$sep; //Stock code
                                            $schema_insert .=$row[9].$sep; //Year founded
                                            $schema_insert .=$row[10].$sep; //Adress
                                            $schema_insert .=$row[11].$sep; //address line 2
                                            $schema_insert .=$row[12].$sep; //Ad city
                                            //$schema_insert .=$row[24].$sep; //Region
                                            $schema_insert .=$row[15].$sep; //Country
                                            $schema_insert .=$row[13].$sep; //zip
                                            $schema_insert .=$row[17].$sep; //Telephone
                                            $schema_insert .=$row[18].$sep; //Fax
                                            $schema_insert .=$row[19].$sep; //Email
                                            $schema_insert .=$row[5].$sep; //website
                                            $schema_insert .=$row[14].$sep; //Other Location
                                            //$schema_insert .=$row[20].$sep; //Moreinformation

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
    mysql_close($cnx);
    ?>



