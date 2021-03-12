<?php include_once("../globalconfig.php"); ?>
<?php
//  session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
// 	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
	if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{ 
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

                        $tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                       
                        
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
                        
                       if($dealvalue==105)
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
                            $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
				FROM pecompanies AS pec, incubatordeals AS pe,industry as i
				WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                                     and pe.Deleted=0 ".$search." ".$dirsearchall." and pec.industry!=15 and ( $tagsval )
                                    ORDER BY pec.companyname";                            
                            }else{
                                $showallsql="SELECT DISTINCT pe.IncubateeId, pec. *
                                    FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                                    WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
				 and pe.Deleted=0 ".$search." ".$dirsearchall." and pec.industry!=15
				ORDER BY pec.companyname";
                            }
                            
                            $getcompanySql=$showallsql;
                       }
  			
  				 $sql=$getcompanySql;
				//echo "<br>---" .$sql;
				 //execute query
				 $result = @mysql_query($sql)
				     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

                                 echo mysql_num_rows($result);
                                 exit;
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

				        echo "Incubator"."\t";
					echo "Address1"."\t";
					echo "Address2"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Funds Available"."\t";
					echo "Additional Info"."\t";
					echo "Management "."\t";

                                	print("\n");
				 print("\n");
				 //end of printing column names

				 //start while loop to get data
				 /*
				 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
				 */

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
                                        $schema_insert = "";
				         
                                                
                                        $companyId=$row[2];//CompanyId
                                        $schema_insert .=$row[3].$sep; //Companyname
                                        $schema_insert .=$row[4].$sep; //Industry
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
											$subject="company Profile - $filetitle";
											$message="<html><center><b><u> Company Profile :$frmwhichpage - $filetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >
											<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
											<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
											<tr><td width=1%>Stage</td><td width=99%>$hidestagetext</td></tr>
											<tr><td width=1%>Investor Type</td><td width=99%>$invtypevalue</td></tr>
											<tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
											<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
											<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
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
				//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
				}
mysql_close();
    mysql_close($cnx);
    ?>



