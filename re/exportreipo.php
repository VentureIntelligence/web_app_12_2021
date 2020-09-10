<?php include_once("../globalconfig.php"); ?>
<?php
/* created : Nov-13-09
filename: exportreipo.php
invoked from: reipodealinfo.php
*/
 session_save_path("/tmp");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
		//include('onlineaccount.php');
		//global $dbemailsto;
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
				//global $LoginAccess;
				//global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					$submitemail=$_POST['txthideemail'];
					//variable that differentiates, PE/VC/RealEstate
					$IpoId=$_POST['txthideIPOId'];
					$SelCompRef=$IpoId;

				$filetitle="RE-ipoexit";


					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
  	pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,
  	pec.website, pe.city, r.Region,pe.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,ExitStatus
   	FROM REipos AS pe, reindustry AS i, REcompanies AS pec,region as r
  	WHERE pec.industry = i.industryid and pe.IPOId=$SelCompRef and r.RegionId=pe.RegionId and pec.PEcompanyId = pe.PECompanyId
  	 and pe.Deleted=0 order by IPOSize desc,i.industry";
	//echo "<br>".$sql;

	$investorSql="SELECT peinv.IPOId, peinv.InvestorId, inv.Investor
	FROM REipo_investors AS peinv, REinvestors AS inv
	WHERE peinv.IPOId =$SelCompRef
	AND inv.InvestorId = peinv.InvestorId";

//	echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from REinvestments_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

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
	//echo "Advisors"."\t";
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
       $companyName=$row[1]; //companyname
   	$companyName=strtolower($companyName);
   	$compResult=substr_count($companyName,$searchString);

	if($compResult==0)
	{
   	   $schema_insert .= $row[1].$sep;
   		$webdisplay=$row[9];
   	}
   	 else
   	{
   		$schema_insert .= $searchStringDisplay.$sep;
   		 $webdisplay="";
	}
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
				$schema_insert .= $investorString.$sep;  //investor

				//industry
				 $schema_insert .= $row[3].$sep;
				 //sector
				$schema_insert .= $row[4].$sep;
				//date
				$schema_insert .= $row[8].$sep;
				$dealDate=$row[8];
				//ipo size
				if(($row[15]==1) || ($row[5]<=0))
					$hideamount="";
				else
					$hideamount=$row[5];
				$schema_insert .= $hideamount.$sep;

				//price
				if($row[6]>0)
					$price=$row[6];
				else
					$price="";
				$schema_insert .= $price.$sep;

	         	//valuation
	         	if($row[7]>0)
					$valuation=$row[7];
				else
					$valuation="";
	         	$schema_insert .= $valuation.$sep;

		/* if($advisorcompanyrs = mysql_query($advcompanysql))
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
				$schema_insert .= $row[10].$sep;
			//Region
				$schema_insert .= $row[11].$sep;
                                
                        if($row[21]=="0")
                        {$Exit_Status="Partial Exit"; }
                        elseif($row[21]=="1")
                        {$Exit_Status="Complete Exit";}
                        //Exit_Status
                        $schema_insert .= $Exit_Status.$sep;
                        
                        
			//website
	         $schema_insert .= $webdisplay.$sep;

	         //additional info
	         if($row[16]==1)
			 		$hidemoreinfor="";
			 else
					$hidemoreinfor=$row[14];
	         $schema_insert .= $hidemoreinfor.$sep;

			//inv dealsummary
 			$schema_insert .= $row[17].$sep;
 			$schema_insert .= $row[18].$sep;  //link

 			  if($row[19]!="")
			{
				$estimatedirrvalue=$row[19];
				$moreinforeturnsvalue=$row[20];
			}
			else
			{
				$estimatedirrvalue="";
				$moreinforeturnsvalue="";
			}
			$schema_insert .= $estimatedirrvalue.$sep;  // Estimated IRR
		   	$schema_insert .= $moreinforeturnsvalue.$sep; // More Info Returns

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
    echo ("$tsjtitle");
 	print("\n");
 	print("\n");


//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
			//		{
   $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,companyname,dealdate)values('$submitemail','RE','IPO-Exit','$companyName','$dealDate') ";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {

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
											//$to=$dbemailsto;
											$to="arun@ventureintelligence.com,arun.natarajan@gmail.com";
												$subject="IPO-Exit Export by- ".$submitemail;
												$message=" $companyName - $dealDate ";
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






//		}
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
mysql_close();  
?>


