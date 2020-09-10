<?php include_once("../globalconfig.php"); ?>
<?php
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

				//global $LoginAccess;
				//global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					$submitemail=$_POST['txthideemail'];
					//echo "<br>--- ".$submitemail;
					$MAMAId=$_POST['txthideMAMAId'];
					$SelCompRef=$MAMAId;
					$filetitle="RE-M&A";

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

		$sql="SELECT pe.PECompanyId, pec.companyname,pe.Stake, pec.industry, i.industry, pec.sector_business,
				pec.countryid as TargetCountryId,pec.city as TargetCity,
				Amount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,c.country as TargetCountry,
				 pe.MAMAId,pe.Comment,MoreInfor,pe.MADealTypeId,dt.MADealType,pe.AcquirerId,ac.Acquirer,pe.Asset,pe.city,r.Region,Link
				 FROM REmama AS pe, reindustry AS i, REcompanies AS pec,
				 madealtypes as dt,REacquirers as ac,country as c,region as r
				 WHERE  i.industryid=pec.industry and c.countryid=pec.countryid
				 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and r.RegionId=pe.RegionId and pe.MAMAId=$SelCompRef
				 and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId";
			//echo "<br>".$sql;

			$mama_advisorTargetSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from REmama_advisorcompanies as advcomp,
			REadvisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
			//echo "<Br>".$advcompanysql;

			$mama_advisoracquirerSql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from REmama_advisoracquirer as advinv,
			REadvisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;

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
 	echo "Target_Company"."\t";
 	echo "Acquirer"."\t";
 	echo "Industry_Target"."\t";
 	echo "Sector_Target"."\t";
 	echo "Amount (US$M)"."\t";
 	echo "Stake (%)"."\t";
	echo "Deal Date"."\t";
	echo "Type"."\t";
	echo "Advisor_Target"."\t";
	echo "Advisor_Acquirer"."\t";
	echo "City"."\t";
	echo "Region"."\t";
	echo "Country_Target"."\t";
	echo "City_Acquirer"."\t";
	echo "Country_Acquirer"."\t";
	echo "Website_Target"."\t";
	echo "More Information"."\t";
      	echo "Link"."\t";
 print("\n");
 /*print("\n");*/
 //end of printing column names
 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
     while($row = mysql_fetch_row($result))
     {
     	$searchString="Undisclosed";
		$searchString=strtolower($searchString);
		$searchStringDisplay="Undisclosed";

		$searchString1="Unknown";
		$searchString1=strtolower($searchString1);
		$searchString1Display="Unknown";

		$searchString2="Others";
		$searchString2=strtolower($searchString2);
		$searchString2Display="Others";

		$searchString4="PE Firm(s)";
		$searchString4ForDisplay="PE Firm(s)";
		$searchString4=strtolower($searchString4);

         //set_time_limit(60); // HaRa
         $schema_insert = "";
        $AcquirerId=$row[17];
        $PECompanyId=$row[0];
		$companyName=$row[1];
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
		$compResult1=substr_count($companyName,$searchString1);

		$acquirerName=$row[18];
		$acquirerName=strtolower($acquirerName);
		$compResultAcquirer=substr_count($acquirerName,$searchString4);
		$compResultAcquirer1=substr_count($acquirerName,$searchString);

		if(($compResult==0) && ($compResult1==0))
			$comp=$row[1];
		else
			$comp=$searchStringDisplay;

		//TargetCompany name
         if($row[19]==1)  //Assetflag checking
         	$schema_insert .= "("."$comp".")".$sep;
         else
         	$schema_insert .= "$comp".$sep;

		//Acquirer
		if(($compResultAcquirer==0) && ($compResultAcquirer1==0))
			$acquirerDisplay=$row[18];
		elseif($compResultAcquirer==1)
			$acquirerDisplay=$searchString4ForDisplay;
		elseif($compResultAcquirer1==1)
			$acquirerDisplay=$searchStringDisplay;
		$schema_insert .= $acquirerDisplay.$sep;
		$schema_insert .= $row[4].$sep; //industry
		$schema_insert .= $row[5].$sep; //Sector
		$schema_insert .= $row[8].$sep; //Amount
		if($row[2]<=0)
			$stake="";
		else
			$stake=$row[2];
		$schema_insert .= $stake.$sep; //Stake
		$schema_insert .= $row[9].$sep; //Deal Date
		$dealDate=$row[9];
		$schema_insert .= $row[16].$sep; //DealType

      	if($resultTarget = mysql_query($mama_advisorTargetSql))
				 {
					 $targetString="";
				   while($rowTarget = mysql_fetch_array($resultTarget))
					{
						$targetString=$targetString.",".$rowTarget[2]."(".$rowTarget[3].")";
					}
						$targetString=substr_replace($targetString, '', 0,1);
				}
				$schema_insert .= $targetString.$sep; //AdvisorTarget


		 if($result1 = mysql_query($mama_advisoracquirerSql))
		 {
			 $acquirerString="";
		   while($row1 = mysql_fetch_array($result1))
			{
				$acquirerString=$acquirerString.",".$row1[2]."(".$row1[3].")";
			}
				$acquirerString=substr_replace($acquirerString, '', 0,1);
		}
				$schema_insert .= $acquirerString.$sep; //AdvisorAcquirer


  			 $targetCityCountrySql="select pe.city,pe.CountryId,co.Country from
	      REcompanies as pe,country as co where pe.PECompanyId=$PECompanyId and co.CountryId=pe.CountryId";
	     // echo "<bR>---" .$targetCityCountrySql;
	      if($targetrs=mysql_query($targetCityCountrySql))
		  {
			while($targetrow=mysql_fetch_array($targetrs))
			{
				$targetCity=$targetrow[0];
				$targetCountry=$targetrow[2];
			}
	      }
	        $schema_insert .= $targetCity.$sep; //City
	        $schema_insert .= $row[21].$sep; //Region
			$schema_insert .= $targetCountry.$sep; //TargetCountry

	      $acquirerCityCountrySql="select ac.CityId,ac.CountryId,co.Country from
	      REacquirers as ac,country as co where ac.AcquirerId=$AcquirerId and co.CountryId=ac.CountryId";
	      if($acquirerrs=mysql_query($acquirerCityCountrySql))
	      {
	      	while($acquirerrow=mysql_fetch_array($acquirerrs))
	      	{
	      		$acquirerCity=$acquirerrow[0];
	      		$acquirerCountry=$acquirerrow[2];
	      	}
	      }
				$schema_insert .= $acquirerCity.$sep;
				$schema_insert .= $acquirerCountry.$sep;
	         $schema_insert .= $row[10].$sep; //WebsiteTarget
	         $schema_insert .= $row[14].$sep; //more infor
                  $schema_insert .= $row[22].$sep; //link       

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
      $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,companyname,dealdate)values('$submitemail','RE','MAMA','$companyName','$dealDate') ";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {

      }
                	$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM RElogin_members AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{
				$cnt= mysql_num_rows($totalrs);
				if ($cnt==1)
				{
					While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
					{
						if( date('Y-m-d')<=$myrow["ExpiryDate"])
						{
								$headers  = "MIME-Version: 1.0\n";
								$headers .= "Content-type: text/html;
								charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";
								/* additional headers
								$headers .= "Cc: sow_ram@yahoo.com\r\n"; */
								$RegDate=date("M-d-Y");
								$to="arun.natarajan@gmail.com,arun@ventureintelligence.com";
								//$to="sowmyakvn@gmail.com";
								$subject="RE M&A Export by- ".$submitemail;
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
	//	}


//		}
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
                         mysql_close();  
?>


