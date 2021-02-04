<?php include_once("../globalconfig.php"); ?>
<?php
/* created : Nov-13-09
filename: exportremanda.php
invoked from: remandadealinfo.php
*/
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
		//global $dbemailsto;
		//echo "<br>---" .$dbemailsto;

		$displayMessage="";
		$mailmessage="";

				//global $LoginAccess;
				//global $LoginMessage;
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					$submitemail=$_POST['txthideemail'];
					$MandAId=$_POST['txthideMandAId'];
					$SelCompRef=$MandAId;
					$filetitle="RE-mandaexit";
					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, s.REType,
				 DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,
				 pe.MandAId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,
				pe.DealTypeId,dt.DealType,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,SPV,ProjectName,ExitStatus
			 FROM REmanda AS pe, reindustry AS i, REcompanies AS pec,
			 dealtypes as dt,region as r ,realestatetypes as s
			 WHERE  i.industryid=pec.industry and r.RegionId=pe.RegionId
			 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and s.RETypeId=pe.StageId and pe.MandAId=$SelCompRef
			 and dt.DealTypeId=pe.DealTypeId";
	//echo "<br>".$sql;

		$AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from REmanda as peinv,REacquirers as ac
		where peinv.MandAId=$SelCompRef and ac.AcquirerId=peinv.AcquirerId";

		$investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor from REmanda_investors as peinv,
		REinvestors as inv where peinv.MandAId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
		//echo "<br>".$investorSql;


	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from REinvestments_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from REinvestments_advisoracquirer as advinv,
	REadvisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;

// $sql=$companysql;
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
	echo "Sector"."\t";
        echo "Project Name"."\t";
	echo "Type"."\t";
	echo "Acquirer "."\t";
	echo "Deal Date"."\t";
	echo "Deal Amount (US$ M)"."\t";
	echo "Advisor-Company"."\t";
	echo "Advisor-Acquirer"."\t";
	echo "City"."\t";
	echo "Region"."\t";
	echo "Exit Status"."\t";
	echo "Website"."\t";
	echo "Addln Info"."\t";
	echo "Investment Details"."\t";
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
         $MandAId=$SelCompRef;

		$companyName=$row[1]; //companyname
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
                //SPV
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
			$webdisplay=$row[7];
		}
		 else
		{
			$schema_insert .= $searchStringDisplay.$sep;
			 $webdisplay="";
		}


	//	echo "<Br>".$advcompanysql;

		if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
		{
			While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
			{
				$Acquirer=$myAcquirerrow["Acquirer"];
				$AcquirerId=$myAcquirerrow["AcquirerId"];
			}
	     }

		if($investorrs = mysql_query($investorSql))
		 {
			 $investorString="";
			 $AddUnknowUndisclosedAtLast="";
			 $AddOtherAtLast="";
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

		 if($advisorcompanyrs = mysql_query($advcompanysql))
		 {
			 $advisorCompanyString="";
			 while($row1 = mysql_fetch_array($advisorcompanyrs))
			{
				$advisorCompanyString=$advisorCompanyString.",".$row1[2]."(".$row1[3].")";
			}
				$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
		}


		 if($advisoracquirerrs = mysql_query($adacquirersql))
		 {
			 $advisorAcquirerString="";
			 while($row2 = mysql_fetch_array($advisoracquirerrs))
			{
				$advisorAcquirerString=$advisorAcquirerString.",".$row2[2]."(".$row2[3].")";
			}
				$advisorAcquirerString=substr_replace($advisorAcquirerString, '', 0,1);
		}

		//investors
			$schema_insert .= $investorString.$sep;
		//industry
		 	$schema_insert .= $row[3].$sep;
		 //sector
			$schema_insert .= $row[4].$sep;
			//Proejct Name
			$schema_insert .= $row[22].$sep;
		//dealtype
			$schema_insert .= $row[16].$sep;
		//AcquirerName
			$schema_insert .= $Acquirer.$sep;
		//deal date
			$schema_insert .= $row[6].$sep;
			$dealDate=$row[6];
		//deal amount
			if(($row[11]==1) || ($row[5]<=0))
				$hideamount="";
			else
				$hideamount=$row[5];
			$schema_insert .= $hideamount.$sep;
			$schema_insert .= $advisorCompanyString.$sep;
			$schema_insert .= $advisorAcquirerString.$sep;

			//city
	         $schema_insert .= $row[13].$sep;
			//region
	         $schema_insert .= $row[14].$sep;
                 
                 
                        if($row[23]=="0")
                        {$Exit_Status="Partial Exit"; }
                        elseif($row[23]=="1")
                        {$Exit_Status="Complete Exit";}
                        //Exit_Status
                        $schema_insert .= $Exit_Status.$sep;
                 
			//website
	         $schema_insert .= $webdisplay.$sep;

	         //additional info
	         if($row[12]==1)
			 		$hidemoreinfor="";
			 else
					$hidemoreinfor=$row[10];
	         $schema_insert .= $hidemoreinfor.$sep;

	         //investment deals summary
	         $schema_insert .= $row[17].$sep;
                 //link
                  $schema_insert .= $row[18].$sep;

		  if($row[19]!="")
	        	$estimatedirrvalue=$row[19];
                else
			$estimatedirrvalue="";
	        if($row[20]!="")
                        	$moreinforeturnsvalue=$row[20];
        	else
			$moreinforeturnsvalue="";
		
		$schema_insert .= $estimatedirrvalue.$sep;  //Estimated IRR
		$schema_insert .= $moreinforeturnsvalue.$sep;   // Moreinfo Returns



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


     //mail sending

	 //if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
	 //		{
           $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,companyname,dealdate)values('$submitemail','RE','M&A-Exit','$companyName','$dealDate') ";
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
	 								$to="arun.natarajan@gmail.com,pawan@ventureintelligence.com";
	 								//$to="sowmyakvn@gmail.com";
	 								//$to=$dbemailsto;
									$to="arun@ventureintelligence.com,arun.natarajan@gmail.com";
									$subject="RE-M&A-Exit Export by- ".$submitemail;
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


