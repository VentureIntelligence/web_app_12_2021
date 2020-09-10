<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
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
					$filetitle="M&A";

					$tsjtitle="© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

		$sql="SELECT pe.PECompanyId, pec.companyname,pe.Stake, pec.industry, i.industry, pec.sector_business,
				pec.countryid as TargetCountryId,pec.city as TargetCity,
				Amount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,c.country as TargetCountry,
				 pe.MAMAId,pe.Comment,MoreInfor,pe.MADealTypeId,dt.MADealType,pe.AcquirerId,
				 ac.Acquirer,pe.Asset,pe.hideamount,Link,Valuation,FinLink,
				 Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
				 FROM mama AS pe, industry AS i, pecompanies AS pec,
				 madealtypes as dt,acquirers as ac,country as c
				 WHERE  i.industryid=pec.industry and c.countryid=pec.countryid
				 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MAMAId=$SelCompRef
				 and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId";
			//echo "<br>".$sql;

			$mama_advisorTargetSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
			advisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
			//echo "<Br>".$advcompanysql;

			$mama_advisoracquirerSql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advinv,
			advisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;

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
 	 	echo ("$tsjtitle");

 print("\n");
 	  print("\n");

 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character
 	echo "Target_Company"."\t";
 	echo "Target_Company Type"."\t";
 	echo "Acquirer"."\t";
 	echo "Acquirer Company Type"."\t";
 	echo "Industry_Target"."\t";
 	echo "Sector_Target"."\t";
 	echo "Amount (US\$M)"."\t";
 	echo "Stake (%)"."\t";
	echo "Deal Date"."\t";
	echo "Type"."\t";
	echo "Advisor_Target"."\t";
	echo "Advisor_Acquirer"."\t";
	echo "City_Target"."\t";
	echo "Country_Target"."\t";
	echo "City_Acquirer"."\t";
	echo "Country_Acquirer"."\t";
	echo "Website_Target"."\t";
	echo "More Information"."\t";
        echo "Link"."\t";
         echo "Company Valuation-Enterprise Value(INR Cr)"."\t";
 echo "Revenue Multiple(based on EV)"."\t";
 echo "EBITDA Multiple(based on EV)"."\t";
 echo "PAT Multiple(based on EV)"."\t";
	echo "Valuation (More Info)"."\t";
	echo "Link for Financials"."\t";
 print("\n");
 print("\n");
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

		$searchString3="Individual";
		$searchString3=strtolower($searchString3);
		$searchString3ForDisplay="Individual";

		$searchString4="PE Firm(s)";
		$searchString4ForDisplay="PE Firm(s)";
		$searchString4=strtolower($searchString4);

                $target_listing_status_display="";
                $acquirer_listing_status_display="";
                if($row[28]=="L")
                     $target_listing_status_display="Listed";
                elseif($row[28]=="U")
                     $target_listing_status_display="Unlisted";

                $acquirer_listing_status_display="";
                if($row[29]=="L")
                     $acquirer_listing_status_display="Listed";
                elseif($row[29]=="U")
                     $acquirer_listing_status_display="Unlisted";
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
		$compResultAcquirer3=substr_count($acquirerName,$searchString3);


		if(($compResult==0) && ($compResult1==0))
			$comp=$row[1];
		else
			$comp=$searchStringDisplay;

		//TargetCompany name
         if($row[19]==1)  //Assetflag checking
         	$schema_insert .= "("."$comp".")".$sep;
         else
         	$schema_insert .= "$comp".$sep;
                $schema_insert .= $target_listing_status_display.$sep;
      		//Acquirer

		if(($compResultAcquirer==0) && ($compResultAcquirer1==0) && ($compResultAcquirer3==0))
			$acquirerDisplay=$row[18];
		elseif($compResultAcquirer==1)
			$acquirerDisplay=$searchString4ForDisplay;
		elseif($compResultAcquirer1==1)
			$acquirerDisplay=$searchStringDisplay;
		elseif($compResultAcquirer3==1)
			$acquirerDisplay=$searchString3ForDisplay;

		$schema_insert .= $acquirerDisplay.$sep;
		$schema_insert .= $acquirer_listing_status_display.$sep;

		$schema_insert .= $row[4].$sep; //industry
		$schema_insert .= $row[5].$sep; //Sector
		if($row[20]==1)  //hideamount check
			$amount="";
		else
			$amount=$row[8];

		$schema_insert .= $amount.$sep; //Amount
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
			//	$schema_insert .= $targetString.$sep; //AdvisorTarget


		 if($result1 = mysql_query($mama_advisoracquirerSql))
		 {
			 $acquirerString="";
		   while($row1 = mysql_fetch_array($result1))
			{
				$acquirerString=$acquirerString.",".$row1[2]."(".$row1[3].")";
			}
				$acquirerString=substr_replace($acquirerString, '', 0,1);
		}
			//	$schema_insert .= $acquirerString.$sep; //AdvisorAcquirer


  			 $targetCityCountrySql="select pe.city,pe.CountryId,co.Country from
	      pecompanies as pe,country as co where pe.PECompanyId=$PECompanyId and co.CountryId=pe.CountryId";
	     // echo "<bR>---" .$targetCityCountrySql;
	      if($targetrs=mysql_query($targetCityCountrySql))
		  {
			while($targetrow=mysql_fetch_array($targetrs))
			{
				$targetCity=$targetrow[0];
				$targetCountry=$targetrow[2];
			}
	      }
	        $schema_insert .= $targetCity.$sep; //Targetcity
			$schema_insert .= $targetCountry.$sep; //TargetCountry

	      $acquirerCityCountrySql="select ac.CityId,ac.CountryId,co.Country from
	      acquirers as ac,country as co where ac.AcquirerId=$AcquirerId and co.CountryId=ac.CountryId";
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
                 $schema_insert .= $row[21].$sep; //link

		  
		     $dec_company_valuation=$row[24];
                                                                 if ($dec_company_valuation <=0)
                                                                    $dec_company_valuation="";

                                                                $dec_revenue_multiple=$row[25];
                                                                if($dec_revenue_multiple<=0)
                                                                    $dec_revenue_multiple="";

                                                                $dec_ebitda_multiple=$row[26];
                                                                if($dec_ebitda_multiple<=0)
                                                                    $dec_ebitda_multiple="";

                                                                $dec_pat_multiple=$row[27];
                                                                if($dec_pat_multiple<=0)
                                                                   $dec_pat_multiple="";

							   $schema_insert .= $dec_company_valuation.$sep;  //company valuation
                                                           $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
                                                           $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
                                                           $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
                                                            $schema_insert .= $row[22].$sep; //Valuation

		   $schema_insert .= $row[23].$sep; //link for financials

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


//mail sending
//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM malogin_members AS dm,
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
								$subject="M&A Export by- ".$submitemail;
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

mysql_close();
    mysql_close($cnx);
    ?>