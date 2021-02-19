<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/tmp");
//	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
	if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{  
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
		//global $dbemailsto;
		//echo "<br>---" .$dbemailsto;

		$displayMessage="";
		$mailmessage="";


			//	global $LoginAccess;
			//	global $LoginMessage;
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
					$submitemail=$_POST['txthideemail'];
					$MandAId=$_POST['txthideMandAId'];
					$SelCompRef=$MandAId;
					$filetitle="mandaexit";
					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,
				 pe.MandAId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
				pe.DealTypeId,dt.DealType,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,it.InvestorTypeName,
				Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type, pec.yearfounded
			 FROM manda AS pe, industry AS i, pecompanies AS pec,
			 dealtypes as dt ,investortype as it
			 WHERE  i.industryid=pec.industry
			 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MandAId=$SelCompRef
			 and dt.DealTypeId=pe.DealTypeId  and it.InvestorType=pe.InvestorType";
	//echo "<br>".$sql;
		
	
		
		$AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
		where peinv.MandAId=$SelCompRef and ac.AcquirerId=peinv.AcquirerId";

		$investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,inv.Investor,MultipleReturn,InvMoreInfo,IRR
                 from manda_investors as peinv,
		peinvestors as inv where peinv.MandAId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
		//echo "<br>".$investorSql;


	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame from peinvestments_advisoracquirer as advinv,
	advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;

// $sql=$companysql;
//echo "<br>---" .$sql;
 //execute query
 
//print_r($sql); die;
 
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
 $sep = " \t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "Portfolio Company"."\t";
	echo "Year Founded"."\t";
	echo "Exiting Investors"."\t";
	echo "Investor Type"."\t";
	echo "Exit Status"."\t";
        echo "Industry"."\t";
	echo "Sector_Business Description"."\t";
	echo "Deal Type"."\t";
	echo "Type"."\t";
	echo "Acquirer "."\t";
	echo "Deal Date"."\t";
	echo "Deal Amount (US\$M)"."\t";
	echo "Advisor-Company"."\t";
	echo "Advisor-Acquirer"."\t";
	echo "Website"."\t";
	echo "Addln Info"."\t";
	echo "Investment Details"."\t";
        echo "Link"."\t";
        echo "Return Multiple"."\t";
        echo "IRR (%)"."\t";
        echo "More Info(Returns)"."\t";
        echo "Company Valuation (INR Cr)"."\t";
        echo "Revenue Multiple"."\t";
        echo "EBITDA Multiple"."\t";
        echo "PAT Multiple"."\t";
		
		//New Feature 08-08-2016 start
		
			echo "Price to Book"."\t";
			
		//New Feature 08-08-2016 end
		
        echo "Valuation (More Info)"."\t";
        echo "Revenue"."\t";
        echo "EBITDA"."\t";
        echo "PAT"."\t";
			echo "Book Value Per Share"."\t";
			echo "Price Per Share"."\t";
	echo "Link for Financials"."\t";
        
       

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
	 	//print_r($row); die;
         //set_time_limit(60); // HaRa
         $schema_insert = "";
         $MandAId=$SelCompRef;

		$companyName=$row[1]; //companyname
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);

                if($row[26]==0)
                $exitstatusdisplay="Partial";
                elseif($row[26]==1)
                $exitstatusdisplay="Complete";

		if($compResult==0)
		{
		   $schema_insert .= $row[1].$sep;
			$webdisplay=$row[7];
		}
		 else
		{
			$schema_insert .= $searchStringDisplay.$sep;
			 $webdisplay="";
		}

$schema_insert .= $row[34].$sep; // year founded
	//	echo "<Br>".$advcompanysql;

		if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
		{
			While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
			{
				$Acquirer=$myAcquirerrow["Acquirer"];
				$AcquirerId=$myAcquirerrow["AcquirerId"];
			}
	     }
	      $invIRRString = "";
		if($investorrs = mysql_query($investorSql))
		 {
			 $investorString="";
			 $AddUnknowUndisclosedAtLast="";
			 $AddOtherAtLast="";
		   while($rowInvestor = mysql_fetch_array($investorrs))
			{
				$Investorname=$rowInvestor[2];
				$Investorname=strtolower($Investorname);
				$multiplereturn=$rowInvestor[4];
				$invmoreinfo=$rowInvestor[5];

				/*if($multiplereturn>0)
				{   $addreturnstring= ",".$multiplereturn."x";
                                if(($invmoreinfo!="") && ($invmoreinfo!= " "))
                                {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                                }
				else
                                {   $addreturnstring=" ";}
                                */
                if($rowInvestor[6] > 0.00 || $rowInvestor[6] > 0){

					$invIRRString.=$rowInvestor[2].",".$rowInvestor[6]."; ";	
				} 
				$invResult=substr_count($Investorname,$searchString);
				$invResult1=substr_count($Investorname,$searchString1);
				$invResult2=substr_count($Investorname,$searchString2);

				if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
				{
                                  $investorString=$investorString .", ".$rowInvestor[2];
                                  if($multiplereturn>0)
				  {   $addreturnstring= ",".$multiplereturn."x";
//                                      if(($invmoreinfo!="") && ($invmoreinfo!= " "))
//                                      {  
//                                        $addreturnstring= $addreturnstring .",".$invmoreinfo;  }
                                      $investorStringMoreInfo=$investorStringMoreInfo ."; ".$rowInvestor[2].$addreturnstring;
                                  }
				else
                                {   $addreturnstring=" ";}


                                }
				elseif(($invResult==1) || ($invResult1==1))
					$AddUnknowUndisclosedAtLast=$rowInvestor[2];
				elseif($invResult2==1)
					$AddOtherAtLast=$rowInvestor[2];


			}
			$invIRRString = rtrim(trim($invIRRString),';');
			$investorString =substr_replace($investorString, '', 0,1);
                        $investorStringMoreInfo=substr_replace($investorStringMoreInfo, '', 0,1);

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
				$advisorCompanyString=$advisorCompanyString.",".$row1[2];
			}
				$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
		}


		 if($advisoracquirerrs = mysql_query($adacquirersql))
		 {
			 $advisorAcquirerString="";
			 while($row2 = mysql_fetch_array($advisoracquirerrs))
			{
				$advisorAcquirerString=$advisorAcquirerString.",".$row2[2];
			}
				$advisorAcquirerString=substr_replace($advisorAcquirerString, '', 0,1);
		}

		//investors
			$schema_insert .= $investorString.$sep;
		//investor type
		 	$schema_insert .= $row[19].$sep;
		//exitstaus
                        $schema_insert .= $exitstatusdisplay.$sep;
                //industry
		 	$schema_insert .= $row[3].$sep;
		 //sector
			$schema_insert .= $row[4].$sep;
		//dealtype
			$schema_insert .= $row[14].$sep;
		//Type
                        if($row[13] == 4){
                            if($row[33] == 1){ $type_val = "IPO"; } else if($row[33] == 2){ $type_val = "Open Market Transaction"; }else if($row[33] == 3){ $type_val = "Reverse Merger";}else {$type_val = "Open Market Transaction";}
                        }else{
                            $type_val='';
                        }
			$schema_insert .= $type_val.$sep;
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

			//website
	         $schema_insert .= $webdisplay.$sep;

	         //additional info
                if($row[12]==1)
                    $hidemoreinfor="";
                else
                    $hidemoreinfor=$row[10];
	         $schema_insert .= $hidemoreinfor.$sep;
       	         $schema_insert .= $row[15].$sep; // Investment details
                 $schema_insert .= $row[16].$sep;  // link
                 $schema_insert .= $investorStringMoreInfo.$sep;
			if($row[17]!="")
		   	{
		   		$estimatedirrvalue=$row[17];
		   		$moreinforeturnsvalue=$row[18];
		   	}
		   	else
		   	{
		   		$estimatedirrvalue="";
		   		$moreinforeturnsvalue="";
		   	}
		   //	$schema_insert .= $estimatedirrvalue.$sep;  //Estimated IRR
		   	

                           $dec_company_valuation=$row[22];
                           if ($dec_company_valuation <=0)
                              $dec_company_valuation="";

                          $dec_revenue_multiple=$row[23];
                          if($dec_revenue_multiple<=0)
                              $dec_revenue_multiple="";

                          $dec_ebitda_multiple=$row[24];
                          if($dec_ebitda_multiple<=0)
                              $dec_ebitda_multiple="";

                          $dec_pat_multiple=$row[25];
                          if($dec_pat_multiple<=0)
                             $dec_pat_multiple="";
						
						//New Feature 08-08-2016 start
								 
						  $price_to_book=$row[30]; 
                          if($price_to_book<=0)
                             $price_to_book="";
						  
							 
					      $book_value_per_share=$row[31]; 
                          if($book_value_per_share<=0)
						  	$book_value_per_share="";
						  
						  
					     $price_per_share=$row[32]; 
                          if($price_per_share<=0)
                             $price_per_share="";
							 
					    //New Feature 08-08-2016 end
						 
                    $schema_insert .=$invIRRString.$sep;   // IRR          
                    $schema_insert .= $invmoreinfo.$sep;   // Moreinfo Returns
                          
                     $schema_insert .= $dec_company_valuation.$sep;  //company valuation
                     $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
                     $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
                     $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
					 
					 
					 $schema_insert .= $price_to_book.$sep;  //price_to_book
					
                     $schema_insert .= $row[20].$sep;  //Valuation

                    $dec_revenue=$row[27];
                    if($dec_revenue > 0 || $dec_revenue < 0){
                        $schema_insert .= $dec_revenue.$sep;  //Revenue
                    }else{
                        if($dec_company_valuation >0 && $dec_revenue_multiple >0){

                            $schema_insert .= number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '').$sep;
                        }
                        else{
                            $schema_insert .= ''.$sep;
                        }
                    }
                                                            

                    $dec_ebitda=$row[28];
                    if($dec_ebitda > 0 || $dec_ebitda < 0){
                        $schema_insert .= $dec_ebitda.$sep;  //EBITDA
                    }else{
                        if($dec_company_valuation >0 && $dec_ebitda_multiple >0){

                           $schema_insert .= number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '').$sep;
                        }
                        else{
                            $schema_insert .= ''.$sep;
                        }
                    }
                    
                    $dec_pat=$row[29];
                    if($dec_pat > 0 || $dec_pat < 0){
                        $schema_insert .= $dec_pat.$sep;  //PAT 
                    }else{
                        if($dec_company_valuation >0 && $dec_pat_multiple >0){

                            $schema_insert .= number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '').$sep;
                        }
                        else{
                            $schema_insert .= ''.$sep;
                        }
                    }
					 $schema_insert .= $book_value_per_share.$sep;  //book_value_per_share
					 $schema_insert .= $price_per_share.$sep;  //price_per_share
                                         
                    $schema_insert .= $row[21].$sep;  //Financial link
                                                            
                                                            
                     

                     
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

    print "\n";
	print "\n";
	print "\n";
	print "\n";
	print "\n";
	echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
 	print("\n");
 	print("\n");


     //mail sending

	 //if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
	 //		{
	 			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
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
									$subject="M&A-Exit Export by- ".$submitemail;
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
			}
  mysql_close();
    mysql_close($cnx);
    ?>


