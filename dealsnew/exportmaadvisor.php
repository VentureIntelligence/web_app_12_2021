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
		include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

				global $LoginAccess;
				global $LoginMessage;
				global $TrialExpired;

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page
					$advisorId=$_POST['txthidePEId'];

					$submitemail=$_POST['txthideemail'];



					$tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

					$advisorSql="select Cianame from advisor_cias where CIAId=$advisorId";
					$pagetitle="MA-Advisor";


						$advisor_to_companysql="
							SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
							DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId
							FROM mama AS peinv, pecompanies AS c,  advisor_cias AS cia,
							mama_advisorcompanies AS adac
							WHERE peinv.Deleted=0
							 AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID
							AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$advisorId order by Cianame";

							$advisor_to_investorsql="
							SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MAMAId  ,c.Companyname,
							DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
							FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia,
							mama_advisoracquirer AS adac
							WHERE peinv.Deleted=0  AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID
							AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$advisorId order by dt";




				 $sql=$advisorSql;
				//echo "<br>---" .$sql;
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
				 header("Content-Disposition: attachment; filename=$pagetitle.$file_ending");
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


					echo "Advisor"."\t";
					echo "Advisor - Companies"."\t";

					echo "Advisor - Acquirer"."\t";
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

				     while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
						$advisorName=$row[0];
						$schema_insert .=$row[0].$sep; //advisor name


						if($rsMgmt= mysql_query($advisor_to_companysql))
						{
							$MgmtTeam="";


							While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
							{
                                                          
                                                          $companyname=trim($mymgmtrow["Companyname"]);
							  $companyname=strtolower($companyname);

                                                           $invResult=substr_count($companyname,$searchString);
                                                           $invResult1=substr_count($companyname,$searchString1);
                                                           $invResult2=substr_count($companyname,$searchString2);
                                                           	if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                                    $cname= $mymgmtrow["Companyname"];
                                                            else
                                                                    $cname= ucfirst("$searchString");
                                                            $dealperiod=$mymgmtrow["dt"];
                                                            $MgmtTeam=$MgmtTeam.",".$cname."-".$dealperiod;
							}
							$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
						}
						$schema_insert .=$MgmtTeam.$sep; //Advisor - Company


						if($rsInvestors= mysql_query($advisor_to_investorsql))
						{
							$strInvestor="";
							While($myinvestrow=mysql_fetch_array($rsInvestors, MYSQL_BOTH))
							{
								$companyname1=trim($myinvestrow["Companyname"]);
								$companyname1=strtolower($companyname1);

                                                                  $Result=substr_count($companyname1,$searchString);
                                                                  $Result1=substr_count($companyname1,$searchString1);
                                                                  $Result2=substr_count($companyname1,$searchString2);

                                                                if(($Result==0) && ($Result1==0) && ($Result2==0))
                                                                   $compname= $myinvestrow["Companyname"];
                                                                else
                                                                  $compname= ucfirst("$searchString");
								$dealperioddt=$myinvestrow["dt"];
								$strInvestor=$strInvestor.",".$compname."-".$dealperioddt;
							}
							$strInvestor=substr_replace($strInvestor, '', 0,1);
						}
						$schema_insert .=$strInvestor.$sep; //Advisor - Investor - Company


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

				$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM malogin_members AS dm,
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
											$subject="MA Advisor Profile";
											$message="<html><center><b><u> MA Advisor Profile : - $pagetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >
											<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
											<tr><td width=1%>Advisor</td><td width=99%>$advisorName</td></tr>
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


