<?php include_once("../globalconfig.php"); ?>
<?php
/* created : Nov-13-09
filename: exportreipodeals.php
invoked from: reipoview.php
*/
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
        
        
		//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

//Removed advisor search display in the mail.PLEASE ADD when its added in the ipoinput.php
//	Advisor$advisorsearch

				//global $LoginAccess;
				//global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					$submitemail=$_POST['txthideemail'];
					//variable that differentiates, PE/VC/RealEstate

					//VCFLAG VALUE
					$hidesearchon=$_POST['txtsearchon'];

					$industry=$_POST['txthideindustryid'];
					$hideindustrytext=$_POST['txthideindustry'];

					$keyword=$_POST['txthideinvestor'];
					$companysearch=$_POST['txthidecompany'];
					$advisorsearch=$_POST['txthideadvisor'];

                                        
                                         $txthideexitstatus = $_POST['txthideexitstatus'];
                                            if($txthideexitstatus=="0")
                                            {$exitstatusvalue="0"; }
                                            elseif($txthideexitstatus=="1")
                                            {$exitstatusvalue="1";}
                                            else
                                            {$exitstatusdisplay=""; }
                                            
                                            

					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];
                                        $searchallfield=$_POST['txthidesearchallfield'];
					$submitemail=$_POST['txthideemail'];
					$searchTitle = "List of RE-PE-backed IPOs ";
					$searchdisplay="Real Estate";

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


				/*echo "<br>Industry Id-----------------**".$hideindustryid;
				echo "<br>Inv type id-----------------**".$invtypevalueid;
				echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				echo "<br>End Range value-----------------**".$hiderangeEndValue;
				*/
				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$hidedateEndValue;
				//echo "<br>Date text-----------------**".$dateValue;
				//echo "<br>Deal Type---**". $dealtype;

                    $addVCFlagqry=" and pec.industry=15";
			if (($keyword == "") && ($companysearch=="") && ($advisorsearch=="") && (count($industry) <= 0 )  && 	($hidedateStartValue == "------01") && ($hidedateEndValue == "------01"))
				{
						 $companysql = "SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,
						 pe.PECompanyId,pec.industry,pec.companyname, i.industry, pec.sector_business,
				 DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
				 pec.website, MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
				 FROM REipos AS pe, reindustry AS i, REcompanies AS pec,region as r
				 WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
				 and pe.Deleted=0 and pec.industry=15 and r.RegionId=pe.RegionId order by companyname";

				//echo "<br>3 Query for All records" .$companysql;
					}
                                        elseif ($searchallfield != "")
					{

					$companysql="SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.PECompanyId,pec.industry, pec.companyname, i.industry, pec.sector_business,
					 DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
					pec.website,MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
					FROM REipos AS pe, reindustry AS i,	REcompanies AS pec,region as r
					WHERE IPODate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and r.RegionId=pe.RegionId
					AND pe.Deleted =0 " .$addVCFlagqry. " AND (pe.city LIKE '%$searchallfield%' OR pec.companyname LIKE '%$searchallfield%'
                                            OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%')
					order by companyname";
//						echo "<br>Query for all search";
//				 echo "<br> Company search--" .$companysql;
//                                 exit;
					}
				elseif ($companysearch != "")
					{

					$companysql="SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.PECompanyId,pec.industry, pec.companyname, i.industry, pec.sector_business,
					 DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
					pec.website,MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
					FROM REipos AS pe, reindustry AS i,	REcompanies AS pec,region as r
					WHERE IPODate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and r.RegionId=pe.RegionId
					AND pe.Deleted =0 " .$addVCFlagqry. " AND  pec.PECompanyId IN ($companysearch) 
					order by companyname";
					//	echo "<br>Query for company search";
			//	 echo "<br> Company search--" .$companysql;
					}
				elseif($keyword!="")
					{
							$companysql="select peinv.IPOId,peinv.IPOId, peinv.PECompanyId,c.industry,peinv_inv.InvestorId,peinv_inv.IPOId,
							inv.Investor,
							c.companyname,i.industry,sector_business,
							DATE_FORMAT( peinv.IPODate, '%M-%Y' )as IPODate,peinv.IPOSize,peinv.IPOAmount,peinv.IPOValuation,
							c.website,MoreInfor,hideamount,hidemoreinfor,peinv.city,r.Region,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
						from REipo_investors as peinv_inv,REinvestors as inv,REipos as peinv,REcompanies as c,reindustry as i,region as r
						where IPODate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND  inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid and r.RegionId=peinv.RegionId
						and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId
						 " .$addVCFlagqry." and inv.InvestorId IN ($keyword) order by companyname";

			//			echo "<br> Investor search- ".$companysql;
					}
				elseif($advisorssearch!="")
				{
				$companysql="(SELECT peinv.IPOId, adcomp.CIAId,peinv.PECompanyId,
				cia.CIAId, cia.cianame,	adcomp.PEId AS CompPEId, adcomp.CIAId AS CompCIAId,
				c.companyname, i.industry,
				c.sector_business,DATE_FORMAT( peinv.IPODate, '%M-%Y' )as IPODate,peinv.IPOSize,peinv.IPOAmount,peinv.IPOValuation,
				peinv.website,MoreInfor,hideamount,hidemoreinfor,peinv.city,r.Region,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
				FROM REadvisor_cias AS cia, REipos AS peinv,REcompanies AS c, reindustry AS i,region as r,
				REinvestments_advisorcompanies AS adcomp
				WHERE IPODate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' " .$addVCFlagqry." AND  c.industry = i.industryid and cia.CIAId=adcomp.CIAId and r.RegionId=peinv.RegionId
				AND c.PECompanyId = peinv.PECompanyId  AND cia.cianame LIKE '%$advisorsearch%' and adcomp.PEId=peinv.IPOId)";
			//	echo "<Br>Advisor search--" .$advisorsearch;
				}
				elseif (($industry > 0) || (($datevalue!="---to---")))
					{
							$companysql = "select IPOId,IPOId,IPOId,IPOId,IPOId,
							pe.PECompanyID,pec.industry,pec.companyname,i.industry,
					pec.sector_business,DATE_FORMAT(IPODate,'%M-%Y') as IPODate,pe.IPOSize,IPOAmount,IPOValuation,
					pec.website,MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
					from REipos as pe, reindustry as i,REcompanies as pec ,region as r where";
					$whereind="";
					$wheredates="";
						if (count($industry) > 0 && $industry[0]!='')
                                                {
                                                    $indusSql = '';
                                                    foreach($industry as $industrys)
                                                    {
                                                        $indusSql .= " pec.industry=$industrys or ";
                                                    }
                                                    $indusSql = trim($indusSql,' or ');
                                                    if($indusSql !=''){
                                                        $whereind = ' ( '.$indusSql.' ) ';
                                                    }
                                                    $qryIndTitle="Industry - ";
                                                    $addVCFlagqry='';
                                                } 
						if($datevalue!="---to---")
							$wheredates= " IPODate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";

					if ($whereind != "")
							$companysql=$companysql . $whereind ." and ";
					if(($wheredates !== "") )
						$companysql = $companysql . $wheredates ." and ";

                                        
                                        
                                                    if($exitstatusvalue!="--" && ($exitstatusvalue!=""))
                                                    {    
                                                        $whereexitstatus=" ExitStatus='".$exitstatusvalue."'" ." and "; ;
                                                    }else{
                                                        $whereexitstatus='';
                                                    }
                                                    

					$companysql = $companysql . " ".$whereexitstatus."  i.industryid=pec.industry and
					pec.PEcompanyID = pe.PECompanyID  and r.RegionId=pe.RegionId and
					pe.Deleted=0  " .$addVCFlagqry. " order by companyname ";
			//		echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}


//mail sending

//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
			
   $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,industry,period,companysearch,investorsearch)
 values('$submitemail','RE','IPO-Exit','$hideindustrytext','$dateValue','$companysearch','$keyword')";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {
        //echo "<br>***".$insert_downloadlog_sql;
      }

                        $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM RElogin_members AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{

				$cnt= mysql_num_rows($totalrs);
				//echo "<Br>mail count------------------" .$hidesearchon;
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
								//$to="sowmyakvn@gmail.com";
								$filetitle="RE-ipoexits";


									$subject="Send Excel Data: RE-IPO Exits - $searchdisplay";
									$message="<html><center><b><u> Send RE-IPO Data: $searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>

									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";


								mail($to,$subject,$message,$headers);
								//header( 'Location: https://www.ventureintelligence.com/deals/cthankyou.php' ) ;


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
	//	}


 $sql=$companysql;
//echo "<br>---" .$sql; exit;
 //execute query
 $result = @mysql_query($sql) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
 updateDownload($result);

 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
 //if parameter is not included, file returned will be in excel format ('.xls')
 $filetitle="RE-ipoexits";
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
 	{
 		echo("$title\n");
 	}

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
	echo "Portfolio Company"."\t";
	echo "PE Firm(s)"."\t";
	echo "Industry"."\t";
	echo "Sector_Business Description"."\t";
	echo "Date "."\t";
	echo "Size (US$ Million)"."\t";
	echo "Price (Rs.)"."\t";
	echo "IPO Valuation (US$ M)"."\t";
//	echo "Advisors"."\t";
	echo "City"."\t";
	echo "Region"."\t";
	echo "Exit Status"."\t";
	echo "Website"."\t";
	echo "Addln Info"."\t";
	echo "Investment Deals"."\t";
	echo "Link"."\t";
	 echo "Estimated Returns"."\t";
	echo "More Info(Returns)"."\t";


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
         $IPOId=$row[0];
	$companyName = $row[7];
	$companyName=strtolower($companyName);
	$compResult=substr_count($companyName,$searchString);

    if($compResult==0)
	{
	   $schema_insert .= $row[7].$sep;
		$webdisplay=$row[14];
	 }
	 else
	{
		$schema_insert .= $searchStringDisplay.$sep;
		 $webdisplay="";
	}



	$investorSql="select peinv.IPOId,peinv.InvestorId,i.Investor from REipo_investors as peinv,
	REinvestors as i where peinv.IPOId=$IPOId and i.InvestorId=peinv.InvestorId";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.PEId=$IPOId and advcomp.CIAId=cia.CIAId";
//	echo "<Br>".$advcompanysql;

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
						$investorString =substr_replace($investorString, '', 0,1);

						if($AddUnknowUndisclosedAtLast!=="")
							$investorString=$investorString .", ".$AddUnknowUndisclosedAtLast;

						if($AddOtherAtLast!="")
				  			$investorString=$investorString .", ".$AddOtherAtLast;
				}
				$schema_insert .= $investorString.$sep;

				//industry
				 $schema_insert .= $row[8].$sep;
				 //sector
				$schema_insert .= $row[9].$sep;
				//date
				$schema_insert .= $row[10].$sep;
				//ipo size
				if(($row[16]==1) || ($row[11]<=0))
					$hideamount="";
				else
					$hideamount=$row[11];
				$schema_insert .= $hideamount.$sep;

				//price
				if($row[12]>0)
					$price=$row[12];
				else
					$price="";
				$schema_insert .= $price.$sep;

	         	//valuation
	         	if($row[13]>0)
					$valuation=$row[13];
				else
					$valuation="";
	         	$schema_insert .= $valuation.$sep;

	/*	 if($advisorcompanyrs = mysql_query($advcompanysql))
		 {
			 $advisorCompanyString="";
		   while($row1 = mysql_fetch_array($advisorcompanyrs))
			{
				$advisorCompanyString=$advisorCompanyString.",".$row1[2];
			}
				$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
		}
				$schema_insert .= $advisorCompanyString.$sep;
*/
			//city
			 $schema_insert .= $row[18].$sep;
			//Region
			 $schema_insert .= $row[19].$sep;


                        if($row[24]=="0")
                        {$Exit_Status="Partial Exit"; }
                        elseif($row[24]=="1")
                        {$Exit_Status="Complete Exit";}
                        //Exit_Status
                        $schema_insert .= $Exit_Status.$sep;

			//website
	         $schema_insert .= $webdisplay.$sep;

	         //additional info
	         if($row[17]==1)
			 		$hidemoreinfor="";
			 else
					$hidemoreinfor=$row[15];
	         $schema_insert .= $hidemoreinfor.$sep;
                  $schema_insert .= $row[20].$sep;
                  $schema_insert .= $row[21].$sep; //Link

		  	 if($row[22]!="")
			{
				$estimatedirrvalue=$row[22];
				$moreinforeturnsvalue=$row[23];
			}
			else
			{
				$estimatedirrvalue="";
				$moreinforeturnsvalue="";
			}
			$schema_insert .= $estimatedirrvalue.$sep; //EstimatedIRR
		   	$schema_insert .= $moreinforeturnsvalue.$sep; // MoreInfo Returns

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

//		}
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
      mysql_close();  
?>


