<?php include_once("../globalconfig.php"); ?>
<?php
//  session_save_path("/tmp");
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
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					//VCFLAG VALUE
					//variable that differentiates PE/VC Investors frm which page
					//$pe_ipo_manda_flag=$_POST['hidepeipomandapage'];
					$pe_vc_flag=$_POST['hidevcflagValue'];
					$adtype=$_POST['hideadvisortype'];
					$isShowAll=$_POST['hideShowAll'];
                                        $columntitle="";
					$submitemail=$_POST['txthideemail'];
                                        if($adtype=="L")
      		                        {  $adtitledisplay ="Legal";}
		                        elseif($adtype=="T")
                                        {  $adtitledisplay="Transaction";}

                                        //echo "<br>-- ".$pe_ipo_manda_flag;
					//echo "<br>PE VC Flag-" .$pe_vc_flag;
					//echo "<bR>&&".$adtype;

					//echo "<br>End date-" .$hidedateEndValue;
				//	echo "<br>Date value-" .$dateValue;

					$tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


						if($pe_vc_flag == 0 || $pe_vc_flag == 1) //investment page
						{
                                                  $columntitle="Advisor - Investors";
							if($pe_vc_flag==0)
							{
								$addVCFlagqry="";
								$pagetitle="PE-Advisors-".$adtitledisplay;
							}
							elseif($pe_vc_flag==1)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
								$pagetitle="VC-Advisors-".$adtitledisplay;
							}
							$advisorsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                                            FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                                            AND adac.PEId = pe.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                                            FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                                            AND adac.PEId = pe.PEId ) order by Cianame	";
							//echo "<Br>PE - VC---" .$advisorsql;
						}
                                              
						else if($pe_vc_flag==9 ||$pe_vc_flag==10 || $pe_vc_flag==11) //manda
						{
                                                  $columntitle="Advisor - Investors";
                                                        if($pe_vc_flag==9)
							{
								$addVCFlagqry="";
								$pagetitle="Public-Market-Sale-Advisors-".$adtitledisplay;
							}
							if($pe_vc_flag==10)
							{
								$addVCFlagqry="";
								$pagetitle="PE-Exits-M&A-Advisors-".$adtitledisplay;
							}
							elseif($pe_vc_flag==11)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = " and VCFlag=1 ";
								$pagetitle="VC-Exits-M&A-Advisors-".$adtitledisplay;
							}
							$advisorsql="(
									SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
									FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
									WHERE Deleted =0
									AND c.PECompanyId = peinv.PECompanyId
									AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
									AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
									" )
									UNION (
									SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
									FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
									WHERE Deleted =0
									AND c.PECompanyId = peinv.PECompanyId
									AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
									AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
									" )	ORDER BY Cianame";
							//echo "<Br>M&A---" .$advisorsql;
					            }
                                                if($pe_vc_flag == 3 || $pe_vc_flag == 4 || $pe_vc_flag == 5) //investment page
						{
                                                  $columntitle="Advisor - Investors";
                                                        if($pe_vc_flag==3)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "";
								$pagetitle="SV-Advisors-".$adtitledisplay;
								$dbtype="SV";
							}
							elseif($pe_vc_flag==4)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "";
								$pagetitle="CT-Advisors-".$adtitledisplay;
								$dbtype="CT";
							}
							if($pe_vc_flag==5)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "";
								$pagetitle="IF-Advisors-".$adtitledisplay;
								$dbtype="IF";
							}
							$advisorsql="(
								SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
								FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
								peinvestments_advisorinvestors AS adac, stage as s ,peinvestments_dbtypes as pedb
								WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
								" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
								AND adac.CIAId = cia.CIAID   and AdvisorType='".$adtype ."'
								AND adac.PEId = peinv.PEId)
								UNION (
								SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
								FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
								peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
								WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
								" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
								AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
								AND adac.PEId = peinv.PEId ) order by Cianame	";
						 //echo "<Br>PE - VC---((()))" .$advisorsql;
						}
                                             /*   if($pe_ipo_manda_flag==4) //mama
						{
                                                  $columntitle="Advisor - Acquirer";
							if($pe_vc_flag==1)
							{
								$addVCFlagqry="";
								$pagetitle="M&A-Advisors-".$adtitledisplay;
							}

							$advisorsql="(
                        					SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        				        FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId
                        					AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                        					AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                        					" )
                        					UNION (
                        					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        			                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId
                        					AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
                        					AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                        					" )	ORDER BY Cianame";


						//	echo "<Br>M&A---" .$advisorsql;
					            }*/


				 $sql=$advisorsql;
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

				 //start of printing column names as names of MySQL fields
				 //-1 to avoid printing of coulmn heading country
				// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
				// {
				// 	echo mysql_field_name($result,$i) . "\t";
				// }
					echo "Advisor"."\t";
					echo "Advisor - Companies"."\t";
                                       echo $columntitle."\t";
					//echo "Advisor - Investors "."\t";
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


				        $AdvisorId=$row[0];//advisorid
					$schema_insert .=$row[1].$sep; //advisor name

					if($pe_ipo_manda_flag==1)
					{
						$advisor_to_companysql="
						SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
						DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
						FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
						peinvestments_advisorcompanies AS adac, stage as s
						WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId order by Cianame";

						$advisor_to_investorsql="
						SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
						DATE_FORMAT( dates, '%M-%Y' ) AS dt
						FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
						peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
						WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
						AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId order by dt";
					}
					elseif($pe_ipo_manda_flag==2)
					{
						$advisor_to_companysql="
						SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
						DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MandAId as PEId
						FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
						peinvestments_advisorcompanies AS adac
						WHERE peinv.Deleted=0 " .$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.MandAId and adac.CIAId=$AdvisorId order by Cianame";

						$advisor_to_investorsql="
						SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,
						DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
						FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
						peinvestments_advisoracquirer AS adac
						WHERE peinv.Deleted=0 ".$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.MandAId and adac.CIAId=$AdvisorId order by dt";
					}
					elseif($pe_ipo_manda_flag==3) //social investment /CT / IF advisors page
                                        {

                                                        $advisor_to_companysql="
							SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
							DATE_FORMAT( dates, '%M-%Y' ) AS dt
							FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
							peinvestments_advisorcompanies AS adac, stage as s
							WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
							" AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID
							AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId
                                                        AND peinv.PEId
                                                        IN (
                
                                                        SELECT PEId
                                                        FROM peinvestments_dbtypes AS db
                                                        WHERE DBTypeId='$dbtype'
                                                        )
                                                         order by dt";

							$advisor_to_investorsql="
							SELECT distinct peinv.PEId as PEId,peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,
							DATE_FORMAT( dates, '%M-%Y' ) AS dt
							FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
							peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
							WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
							" AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
							AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId
                                                        AND peinv.PEId
                                                        IN (
                
                                                        SELECT PEId
                                                        FROM peinvestments_dbtypes AS db
                                                        WHERE DBTypeId='$dbtype'
                                                        )
                                                        order by dt";
                                                        //echo "<br><br>".$advisor_to_companysql;
                                                        //echo "<br>".$advisor_to_investorsql;
                                        }
                                      elseif($pe_ipo_manda_flag==4) //mama
                                      {
                                       $advisor_to_investorsql="SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PEcompanyId,c.Companyname,
                        					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId as PEId
                                                                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId    and adac.CIAId=$AdvisorId
                        					AND adac.CIAId = cia.CIAID
                        					AND adac.MAMAId = peinv.MAMAId  order by dt";

                        				$advisor_to_companysql=
                                                        "SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId,peinv.PEcompanyId,c.Companyname,
                        					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId as PEId
                                                                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId  and adcomp.CIAId=$AdvisorId
                        					AND adcomp.CIAId = cia.CIAID
                        					AND adcomp.MAMAId = peinv.MAMAId order by dt";
                        				//echo "<BR>-- ".$advisor_to_companysql;
                        				//echo "<br>^^^".$advisor_to_investorsql;
                                      }
						if($rsMgmt= mysql_query($advisor_to_companysql))
						{
							$MgmtTeam="";
							While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
							{
								$cname= $mymgmtrow["Companyname"];
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
								$compname= $myinvestrow["Companyname"];
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
											$subject="Advisor Profile ";
											$message="<html><center><b><u> Advisor Profile : - $pagetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >
											<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
											<tr><td width=1%>Advisors</td><td width=99%>$pagetitle</td></tr>
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


