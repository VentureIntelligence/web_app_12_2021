<?php
 //session_save_path("/tmp");
//session_start();

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
//echo $sqlSelCount;exit();
   if ($rowSelCount > 0){
       $upDownloads = $recCount + $downloads;
       $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
       $resUdt = mysql_query($sqlUdt) or die(mysql_error());
   }else{
       $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
       mysql_query($sqlIns) or die(mysql_error());
   }
}
		$investorId=$_POST['txthideinvestorId'];
                $VCFlagValue=$_POST['txthidepevalue'];
                $pe_vc_flag=$_POST['txthidepevalue'];
                $keyword=$_POST['txthidekeyword'];
                $searchallfield=$_POST['searchallfield'];
                $allexport=($_POST['hiddenexportall'])?$_POST['hiddenexportall']:0;
                $pe_re = 1;
                
                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);
                
                if ($pe_re == 1) {
                    $industryvalue = "!=15";
                    $dealpage = "dirdealdetails.php";
                } elseif ($pe_re == 2) {
                    $industryvalue = "=15";
                    $dealpage = "redealinfo.php";
                }
                $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                if($pe_vc_flag==1)
                {	$frmwhichpage="Investments";
                        $filetitle="Investors";

                }
                elseif($pe_vc_flag==0)
                {	$frmwhichpage="Investments";
                        $filetitle="Investors";
                }
                elseif($pe_vc_flag==2)
                {	$frmwhichpage="IPO-Exits";
                        $filetitle="Investors";
                }
                elseif($pe_vc_flag==3)
                {
                        $frmwhichpage="M&A-Exits";
                        $filetitle="Investors";
                }
                elseif($pe_vc_flag ==4)
                {
                        $frmwhichpage="PE Dir";
                        $filetitle="Investors";
                }
                elseif($pe_vc_flag==5)
                {
                        $frmwhichpage="Individual";
                        $filetitle="Investors";
                }
                elseif($pe_vc_flag==6)
                {
                        $frmwhichpage="Angel Investments";
                        $filetitle="Investors";
                }
                elseif($pe_vc_flag==7 || $pe_vc_flag==8 || $pe_vc_flag==9 || $pe_vc_flag==10 || $pe_vc_flag==11)
                {
                        $frmwhichpage="PE-VC IPO Exit";
                        $filetitle="Investors";
                } 
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

                     //define separator (defines columns in excel & tabs in word)
                     $sep = "\t"; //tabbed character

                     //start of printing column names as names of MySQL fields
                     //-1 to avoid printing of coulmn heading country
                    // for ($i =9; $i < mysql_num_fields($result)-4; $i++)
                    // {
                    // 	echo mysql_field_name($result,$i) . "\t";
                    // }
                            echo "Investor"."\t";
                            echo "Key Contact"."\t";
                            echo "Address"."\t";
                            echo ""."\t";
                            echo "City"."\t";
                            echo "Country"."\t";
                            echo "Zip"."\t";

                            echo "Telephone "."\t";
                            echo "Fax"."\t";
                            echo "Email"."\t";
                            echo "Website"."\t";
                            echo "Description"."\t";
                            echo "In India Since"."\t";
                            echo "Management"."\t";
                            echo "Firm Type"."\t";
                            echo "Other Location(s)"."\t";
                            echo "Locations (AngelList)"."\t";
                            echo "Assets Under Management (US $M)"."\t";
                            echo "Stage of Funding (Existing Investments)"."\t";
                            echo "Limited Partners"."\t";
                            echo "Number of Funds"."\t";
                            echo "Additional Info"."\t";
                            echo "Industry (Existing Investments)"."\t";
                            echo "Markets"."\t";
                            echo "PE/VC Investments"."\t";
                            /*echo "Investments (as per AngelList)"."\t";*/
                            echo "Exits"."\t";
                           /* echo "Exits - IPO"."\t";
                            echo "Exits - M&A"."\t";
                            echo "Social Venture Investments"."\t";
                            echo "Cleantech Investments"."\t";
                            echo "Infrastructure Investments"."\t";*/
                            print("\n");

                        /*print("\n");*/
                        
                                    
                               
              /*      if($keyword!="")
                    {
                            $allexpsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                WHERE pe.InvesteeId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.AngelDealId = pe.AngelDealId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                            
                    }
                    elseif($searchallfield!="")
                     {
                        $findTag = strpos($searchallfield,'tag:');
                        $findTags = "$findTag";
                        if($findTags == ''){
                            $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%'";                                    
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
                        $allexpsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c
                                    WHERE pe.InvesteeId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.AngelDealId = pe.AngelDealId
                                    AND inv.InvestorId = peinv.InvestorId and inv.countryid= c.countryid
                                    AND pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";

                     }
                    else
                    {

                            $allexpsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                WHERE pe.InvesteeId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.AngelDealId = pe.AngelDealId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall." order by inv.Investor ";
                            
                    }	*/
                        
                    $allexpsql= $_POST['sqlquery'];
                    $allexpresult = mysql_query($allexpsql);
                    updateDownload($allexpresult);

                                
                    while($allexpresultrow = mysql_fetch_array($allexpresult))
                    {
                        $sql = "select * from peinvestors where InvestorId=".$allexpresultrow['InvestorId'];
                                
				//echo "<br>---" .$sql;
				 //execute query
                
                        $result = @mysql_query($sql)
                             or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

                        // angelCo table
                         $query2 = mysql_query("SELECT angelco_invID FROM peinvestors WHERE  InvestorId=".$allexpresultrow['InvestorId']);
                         $result2 = mysql_fetch_array($query2);
                         $angelco_invID=$result2['angelco_invID'];
                                 
                                 
                        $AngelCount=0;

                        if($angelco_invID !=''){


                           $profileurl = "https://api.angel.co/1/users/$angelco_invID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&include_details=investor";

                           //role=founder&
                           $roleurl = "https://api.angel.co/1/users/$angelco_invID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";

                           $profilejson = file_get_contents($profileurl);
                           $profile = json_decode($profilejson);


                           $rolejson = file_get_contents($roleurl);
                           $roles = json_decode($rolejson);
                           $roles = $roles->startup_roles;

                           $AngelCount=1;

                        }

                        //end of printing column names

                        //start while loop to get data
                        /*
                        note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
                        */

				    while($row = mysql_fetch_row($result))
				     {
				         //set_time_limit(60); // HaRa
                                        $schema_insert="";
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";

				         $InvestorId=$row[0];//investorid
				         
				         $Investorname=$row[1];
                                         $Investorname=strtolower($Investorname);

                                         $invResult=substr_count($Investorname,$searchString);
                                         $invResult1=substr_count($Investorname,$searchString1);
                                         $invResult2=substr_count($Investorname,$searchString2);
                                         if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                         {
						$schema_insert .=trim($row[1]).$sep; //Investorname
                        $schema_insert .=trim($row[26]).$sep; //KeyContact
						$schema_insert .=trim($row[2]).$sep; //address
						$schema_insert .=trim($row[3]).$sep; //address line 2
						$schema_insert .=trim($row[4]).$sep; //city

						$txtcountryid= $row[25]; //countryid
                                                    $countrysql="select country from country where countryid='$txtcountryid'";
                                                    if($rscountry= mysql_query($countrysql))
                                                    {
                                                    While($mycountryrow=mysql_fetch_array($rscountry, MYSQL_BOTH))
                                                            {
                                                                    $countryname=$mycountryrow["country"];
                                                            }
                                                    }
						$schema_insert .=$countryname.$sep; //country

						$schema_insert .=trim($row[5]).$sep; //zip
						$schema_insert .=trim($row[6]).$sep; //Telephone
						$schema_insert .=trim($row[7]).$sep; //Fax
						$schema_insert .=trim($row[8]).$sep; //Email
						$schema_insert .=trim($row[9]).$sep; //Website
						$schema_insert .=trim($row[11]).$sep; //Description
						$schema_insert .=trim($row[12]).$sep; //Year founded
                                                
                                                
                                            $onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
						exe.ExecutiveName,exe.Designation,exe.Company from
						peinvestors as pec,executives as exe,peinvestors_management as mgmt
						where pec.InvestorId=".$allexpresultrow['InvestorId']." and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
						if($rsMgmt= mysql_query($onMgmtSql))
						{
							$MgmtTeam="";
							While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
							{
								$Exename= $mymgmtrow["ExecutiveName"];
								$Designation=$mymgmtrow["Designation"];
								if($Designation!="")
									$MgmtTeam=$MgmtTeam.";".$Exename.",".$Designation;
								else
									$MgmtTeam=$MgmtTeam.";".$Exename;
							}
							$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
						}
						$schema_insert .=$MgmtTeam.$sep; //Management Team

						$schema_insert .=trim($row[14]).$sep; //FirmType

						$schema_insert .=trim($row[15]).$sep; //Other Location
                                                
                                                
                                                if($AngelCount==1)
                                                {
                                                     
                                                    $locations = array();
                                                    foreach ($profile->locations as $l) {
                                                        if ($l->display_name) {
                                                            $locations[] = $l->display_name;
                                                        }
                                                    }
                                                    $location = implode(", ", $locations);
                                                    $schema_insert .=trim($location).$sep; // locations (angel list)
                                                }else{
                                                    
                                                    $schema_insert .="".$sep; // locations (angel list)
                                                }
                                                
                                                
                                                
						$assets_management=trim($row[16]);

						$schema_insert .=$assets_management.$sep; //Assets under managment

						$stageSql= "select distinct s.Stage,pe.StageId,peinv_inv.InvestorId
									from peinvestments_investors as peinv_inv,peinvestors as inv,peinvestments as pe,stage as s
									where peinv_inv.InvestorId=".$allexpresultrow['InvestorId']." and inv.InvestorId=peinv_inv.InvestorId
									and pe.PEId=peinv_inv.PEId and s.StageId=pe.StageId order by Stage ";
						if($rsStage= mysql_query($stageSql))
						{
							While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
								$strStage=$strStage.", ".$myStageRow["Stage"];
							}
							$strStage =substr_replace($strStage, '', 0,1);
						}
						$schema_insert .=$strStage.$sep; //Preferred Stage of funding
						$schema_insert .=trim($row[19]).$sep; //Limited Partners
						$schema_insert .=trim($row[20]).$sep; //Number of funds
						$schema_insert .=trim($row[23]).$sep; //Addtional Info

						$indSql= " select DISTINCT i.industry as ind,peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
                                                                    c.companyname,c.industry,i.industry as indname,
                                                                    DATE_FORMAT( peinv.DealDate, '%b-%Y' ) as dealperiod,inv.Investor
                                                                    from angel_investors as peinv_inv,peinvestors as inv,
                                                                    angelinvdeals as peinv,pecompanies as c,industry as i
                                                                    where peinv_inv.InvestorId=".$allexpresultrow['InvestorId']." and inv.InvestorId=peinv_inv.InvestorId
                                                                    and peinv.Deleted=0 and i.industryid=c.industry
                                                                    and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Exited=1
                                                                    and c.industry!=15";

          						if($rsInd= mysql_query($indSql))
							{
								While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
								{
									$strIndustry=$strIndustry.", ".$myIndrow["ind"];
								}
								$strIndustry =substr_replace($strIndustry, '', 0,1);
							}

						$schema_insert .=$strIndustry.$sep; //Industry for Existing investments
                                                
                                              
                                                
                                                
                                                if($AngelCount==1)
                                                {
                                                     
                                                    $market = array();
                                                    foreach ($profile->investor_details->markets as $m) {
                                                        if ($m->display_name) {
                                                            $market[] = $m->display_name;
                                                        }
                                                    }
                                                    $markets = implode(", ", $market);
                                                    $schema_insert .=trim($markets).$sep; // markets
                                                }
                                                else{
                                                    
                                                    $schema_insert .="".$sep; // locations (angel list)
                                                }
                                                
                                              
                                                $Investmentsql="select peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
                                                    c.companyname,c.industry,i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,inv.*
                                                    from angel_investors as peinv_inv,peinvestors as inv,
                                                    angelinvdeals as peinv,pecompanies as c,industry as i
                                                    where peinv_inv.InvestorId=".$allexpresultrow['InvestorId']." and inv.InvestorId=peinv_inv.InvestorId
                                                    and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Deleted=0
                                                    and c.industry $industryvalue  and i.industryid=c.industry
                                                    order by peinv.DealDate desc";
    

						if ($getcompanyinvrs = mysql_query($Investmentsql))
						{
							While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
							{
								$companyName=trim($myInvestrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);
                                                                if($myInvestrow["AggHide"]==1)
                                                                        $addTrancheWord="; Tranche";
                                                                else
                                                                        $addTrancheWord="";

								if(($compResult==0) && ($compResult1==0))
									$compdisplay=$myInvestrow["companyname"];
								else
									$compdisplay= $searchStringDisplay;

								$strCompany=$strCompany.",".$compdisplay."(".$myInvestrow["indname"] .";".$myInvestrow["dealperiod"].$addTrancheWord.")";
							}
						}
							$strInvestments =substr_replace($strCompany, '', 0,1);
							$schema_insert .=trim($strInvestments).$sep;  // Existing Investments with deal date
                                                        
                                                        
                                                        
                                                        if($AngelCount==1)
                                                        {

                                                            $AngelInv = array();
                                                            foreach ($roles as $f) {
                                                                //if ($f->role == 'past_investor') {
                                                                if($f->role == 'past_investor' || $f->role == 'current_investor') {     
                                                                    $AngelInv[] = $f->startup->name;
                                                                }
                                                            }
                                                            $AngelInvs = implode(", ", $AngelInv);
                                                          //  $schema_insert .=$AngelInvs.$sep; // Investments (as per AngelList)
                                                        }
                                                        else{
                                                    
                                                          //  $schema_insert .="".$sep; 
                                                        }
                                                            
                                                        $iposql="select peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
                                                            c.companyname,c.industry,i.industry as indname,
                                                            DATE_FORMAT( peinv.DealDate, '%b-%Y' ) as dealperiod,inv.Investor
                                                            from angel_investors as peinv_inv,peinvestors as inv,
                                                            angelinvdeals as peinv,pecompanies as c,industry as i
                                                            where peinv_inv.InvestorId=".$allexpresultrow['InvestorId']." and inv.InvestorId=peinv_inv.InvestorId
                                                            and peinv.Deleted=0 and i.industryid=c.industry
                                                            and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Exited=1
                                                            and c.industry !=15";     
                                    
                                                        
                                                       
                                                        
							if ($getcompanyipors = mysql_query($iposql))
							{
								While($myInvestiporow=mysql_fetch_array($getcompanyipors, MYSQL_BOTH))
								{
									$ipocompanyName=trim($myInvestiporow["companyname"]);
									$ipocompanyName=strtolower($ipocompanyName);
									$ipocompResult=substr_count($ipocompanyName,$searchString);
									$ipocompResult1=substr_count($ipocompanyName,$searchString1);
									$exitstatusvalueforIPO=$myInvestiporow["ExitStatus"];
                                                                        if($exitstatusvalueforIPO==0)
                    		                                        {$exitstatusdisplayforIPO="Partial Exit";}
                    		                                        elseif($exitstatusvalueforIPO==1)
                                                                        {  $exitstatusdisplayforIPO="Complete Exit";}
									if(($ipocompResult==0) && ($ipocompResult1==0))
										$ipocompdisplay=$myInvestiporow["companyname"];
									else
										$ipocompdisplay= $searchStringDisplay;

									$stripoCompany=$stripoCompany.",".$ipocompdisplay."(".$myInvestiporow["indname"] .";" .$myInvestiporow["dealperiod"].";". $exitstatusdisplayforIPO .")";
								}
							}
								$stripoInvestments =substr_replace($stripoCompany, '', 0,1);
								$schema_insert .=$stripoInvestments.$sep;  // Existing IPO Exits with deal date


							$mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
										c.companyname,c.industry, i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%y' )as dealperiod,peinv.ExitStatus,inv.*
										from manda_investors as peinv_inv,peinvestors as inv,
										manda as peinv,pecompanies as c,industry as i
										where peinv_inv.InvestorId=".$allexpresultrow['InvestorId']." and inv.InvestorId=peinv_inv.InvestorId
										and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
										and c.industry $industryvalue
										order by DealDate desc";
							if ($getcompanymandars = mysql_query($mandasql))
							{
								While($myInvestmandarow=mysql_fetch_array($getcompanymandars, MYSQL_BOTH))
								{
									$mandacompanyName=trim($myInvestmandarow["companyname"]);
									$mandacompanyName=strtolower($mandacompanyName);
									$mandacompResult=substr_count($mandacompanyName,$searchString);
									$mandacompResult1=substr_count($mandacompanyName,$searchString1);
									$exitstatusdisplay="";
                                                                        $exitstatusvalue=$myInvestmandarow["ExitStatus"];
                                                                        if($exitstatusvalue==0)
                    		                                        {$exitstatusdisplay="Partial Exit";}
                    		                                        elseif($exitstatusvalue==1)
                                                                        {  $exitstatusdisplay="Complete Exit";}
                                                                        if(($mandacompResult==0) && ($mandacompResult1==0))
										$mandacompdisplay=$myInvestmandarow["companyname"];
									else
										$mandacompdisplay= $searchStringDisplay;

									$strmandaCompany=$strmandaCompany.",".$mandacompdisplay."(".$myInvestmandarow["indname"]. ";" .$myInvestmandarow["dealperiod"].";". $exitstatusdisplay .")";
								}
							}
								$strmandaInvestments =substr_replace($strmandaCompany, '', 0,1);
								//$schema_insert .=$strmandaInvestments.$sep;  // Existing M&A Exits with deal date
								
                                                                
                                                                
                                                                
                                                                
                                                                 if($AngelCount==1)
                                                                    {
                                                                       
                                                                       // $schema_insert .="Exits (as per Angel List)".$sep;//Exits (as per Angel List)
                                                                    }
                                        
                                        
								
						  $SVInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId,
                                                   peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.AggHide,SPV
                                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                                    WHERE peinv.Deleted =0
                                                    AND c.PECompanyId = peinv.PECompanyId
                                                    AND c.industry!=15
                                                    AND i.industryid = c.industry
                                                    AND peinv_inv.InvestorId =".$allexpresultrow['InvestorId']." 
                                                    AND inv.InvestorId = peinv_inv.InvestorId
                                                    AND peinv.PEId = peinv_inv.PEId
                                                    AND peinv.PEId
                                                    IN (
                                                     SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeSV'
                                                    ) order by peinv.dates desc";

                                                   if ($getcompanysvrs = mysql_query($SVInvestmentsql))
							{
                                                          $strsvcompany="";
							 	While($mysvrow =mysql_fetch_array($getcompanysvrs, MYSQL_BOTH))
								{
									$SVcompanyName=trim($mysvrow["companyname"]);
					                         	$SVcompanyName=strtolower($SVcompanyName);
						                       $compResult=substr_count($SVcompanyName,$searchString);
						                       $compResult1=substr_count($SVcompanyName,$searchString1);
						                       if($mysvrow["AggHide"]==1)
                                                                        $addTrancheWord1="; Tranche";
                                                                        else
                                                                        $addTrancheWord1="";
                                                                         if($mysvrow["SPV"]==1)
                                                                        $addDebtWord1="; Debt";
                                                                         else
                                                                        $addDebtWord1="";
									if(($compResult==0) && ($compResult1==0))
									{	$svcompdisplay=$mysvrow["companyname"];   }
									else
									{	$svcompdisplay= $searchStringDisplay;  }

									$strsvcompany=$strsvcompany.",".$svcompdisplay."(".$mysvrow["indname"]. ";" .$mysvrow["dealperiod"].$addTrancheWord1.$addDebtWord1.")";
								}
                                                                //echo "<br>***".$strsvcompany;
							}
								$strsvinvestments =substr_replace($strsvcompany, '', 0,1);
								//$schema_insert .=$strsvinvestments.$sep;  // Existing SV Investments with deal date


                                                  $CTInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod
                                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                                    WHERE peinv.Deleted =0
                                                    AND c.PECompanyId = peinv.PECompanyId
                                                    AND c.industry!=15
                                                    AND i.industryid = c.industry
                                                    AND peinv_inv.InvestorId =".$allexpresultrow['InvestorId']." 
                                                    AND inv.InvestorId = peinv_inv.InvestorId
                                                    AND peinv.PEId = peinv_inv.PEId
                                                    AND peinv.PEId
                                                    IN (
                                                     SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeCT'
                                                    ) order by peinv.dates desc";

                                                   if ($getcompanyctrs = mysql_query($CTInvestmentsql))
							{
                                                          $strctcompany="";
							 	While($myctrow =mysql_fetch_array($getcompanyctrs, MYSQL_BOTH))
								{
									$CTcompanyName=trim($myctrow["companyname"]);
					                         	$CTcompanyName=strtolower($CTcompanyName);
						                       $compResult=substr_count($CTcompanyName,$searchString);
						                       $compResult1=substr_count($CTcompanyName,$searchString1);
									if(($compResult==0) && ($compResult1==0))
									{	$ctcompdisplay=$myctrow["companyname"];   }
									else
									{	$ctcompdisplay= $searchStringDisplay;  }

									$strctcompany=$strctcompany.",".$ctcompdisplay."(".$myctrow["indname"]. ";" .$myctrow["dealperiod"].")";
								}
                                                                //echo "<br>***".$strsvcompany;
							}
								$strctinvestments =substr_replace($strctcompany, '', 0,1);
								//$schema_insert .=$strctinvestments.$sep;  // Existing CTInvestments with deal date


                                                   $IFInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod
                                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                                    WHERE peinv.Deleted =0
                                                    AND c.PECompanyId = peinv.PECompanyId
                                                    AND c.industry!=15
                                                    AND i.industryid = c.industry
                                                    AND peinv_inv.InvestorId =".$allexpresultrow['InvestorId']." 
                                                    AND inv.InvestorId = peinv_inv.InvestorId
                                                    AND peinv.PEId = peinv_inv.PEId
                                                    AND peinv.PEId
                                                    IN (
                                                     SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeIF'
                                                    ) order by peinv.dates desc";

                                                   if ($getcompanyifrs = mysql_query($IFInvestmentsql))
							{
                                                          $strifcompany="";
							 	While($myifrow =mysql_fetch_array($getcompanyifrs, MYSQL_BOTH))
								{
									$IFcompanyName=trim($myifrow["companyname"]);
					                         	$IFcompanyName=strtolower($IFcompanyName);
						                       $compResult=substr_count($IFcompanyName,$searchString);
						                       $compResult1=substr_count($IFcompanyName,$searchString1);
									if(($compResult==0) && ($compResult1==0))
									{	$ifcompdisplay=$myifrow["companyname"];   }
									else
									{	$ifcompdisplay= $searchStringDisplay;  }

									$strifcompany=$strifcompany.",".$ifcompdisplay."(".$myifrow["indname"]. ";" .$myifrow["dealperiod"].")";
								}
                                                                //echo "<br>***".$strsvcompany;
							}
								$strifinvestments =substr_replace($strifcompany, '', 0,1);
								//$schema_insert .=$strifinvestments.$sep;  // Existing IF nvestments with deal date
                                                               

                                         }
                                            
                                        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                                        $schema_insert .= "\t";
                                        print(trim($schema_insert));
                                        print "\n";
                                   
                                         
                                        
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