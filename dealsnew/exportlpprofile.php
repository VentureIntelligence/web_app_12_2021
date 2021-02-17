<?php include_once("../globalconfig.php"); ?>
<?php //session_save_path("/tmp");
ini_set ( 'max_execution_time', 300);
//session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
header('Location:../pelogin.php');
}
else
{
//print_r($_POST);
//exit();
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
                    $displayMessage="";
                    $mailmessage="";

                    //global $LoginAccess;
                    //global $LoginMessage;
                    $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
                     $dbTypeSV="SV";
                    $dbTypeIF="IF";
                    $dbTypeCT="CT";
                    $wheredates="";
                    $invname=$_POST['invname'];
                    $pe_vc_flag=$_POST['hidevcflagValue'];
                                
                    //VCFLAG VALUE
                    if($pe_vc_flag==0)
                        {
                                $addVCFlagqry="";
                              
                        }
                        elseif($pe_vc_flag==1)
                        {
                                $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                              
                        }
                        else if($pe_vc_flag==3)
                        {
                                $addVCFlagqry = "";
                                $dbtype="SV";
                                
                        }
                        else if($pe_vc_flag==4)
                        {
                                $addVCFlagqry = "";
                                $dbtype="CT";
                                
                        }
                        elseif($pe_vc_flag==5)
                        {
                                $addVCFlagqry = "";
                                $dbtype="IF";
                                
                        }
                        elseif($pe_vc_flag==7) //PE_ipos
                        {
                                $addVCFlagqry="";
                                
                        }
                        elseif($pe_vc_flag==8) //VC-ipos
                        {
                                $addVCFlagqry="and VCFlag=1";
                                
                        }
                        elseif($pe_vc_flag==10) //PE-EXits M&A Companies
                        {
                                $addVCFlagqry="";
                               
                        }
                        elseif($pe_vc_flag==11) //VC-EXits M&A Companies
                        {
                            $addVCFlagqry="and VCFlag=1";
                            
                        }

                        elseif($pe_vc_flag==9)
                        {
                                $addVCFlagqry="";
                                
                        }
                        elseif($pe_vc_flag==12)
                        {
                                $addVCFlagqry="and VCFlag=1";
                                
                        }

                    $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                   
                    if($invname!=""){
                             $filetitle=$invname." - LP Profile - VI";
                        }else{
                            $filetitle="Limited Partner Profile";
                        }
                if(!isset($_POST[ 'sqlquery' ])){
                
                   
                        if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> company search-0 or 1 ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                    
                                   $getInvestorSql=$showallsql;
                                //echo "<br> sector search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor )
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* 
                                        from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                        pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry. "
                                        and cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' order by inv.Investor )";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br>advisor_legal search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor )
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* 
                                        from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                        pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry. "
                                        and cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' order by inv.Investor )";
                                    
                                   $getInvestorSql=$showallsql;
                                //echo "<br> $advisor_trans search 0 or 1- ".$showallsql;
                            }elseif($searchallfield!=""){
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
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
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;                                
                            }
                            else
                            {
                           
                                if(isset($_REQUEST['txthidelpId']) && $_REQUEST['txthidelpId']!=''){
                                $InvestorId = $_REQUEST['txthidelpId'];    
                                $showallsql = "select distinct lp.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,limited_partners as lp
                                where  lp.LPId='$InvestorId' AND ";
                                }
                                else
                                {
                                    $showallsql = "select distinct lp.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,limited_partners as lp
                                where ";
                                }
                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                            if($stage !=''){
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                            }
                                        }
                                        if($stageidvalue !=''){
                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;
                                        }
                                }
                                //
                                
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                                if($dt1!='' && $dt2!=''){

                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                                }
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                                }
                                
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15 and
                                pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                                        
                                //echo $showallsql;
                            }
                    
                    
                    
                    $sql=$getInvestorSql;
                    
                }else{
                    $getInvestorSql = $_POST[ 'sqlquery' ];
                    $sql=$getInvestorSql;
                    $isUpdated = false;
                    if($pe_vc_flag==0 || $pe_vc_flag==1)
                    {
                        $isUpdated = true;
                    } 
                   
                }

                if( $dt1 != '' && $dt2 != '' ) {
                    $pevcInvestmentWhere = " and peinv.dates between '" . $dt1. "' and '" . $dt2 . "'";
                    $IPOInvestmentWhere = " and peinv.IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                    $MAInvestmentWhere = " and peinv.DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                } else {
                    $pevcInvestmentWhere = '';
                    $IPOInvestmentWhere = '';
                    $MAInvestmentWhere = '';
                }

                if( $dt1 != '' && $dt2 != '' ) {
                    $wheredate = " dates between '" . $dt1. "' and '" . $dt2 . "'";
                } else {
                    $wheredate = '';
                }

                if($industry > 0){
                    $ind_where = " and i.industryid = '$industry' ";
                }else{
                    $ind_where = "";                                    
                }

                
                

              
//                    echo $_REQUEST['txthideinvestorId']."<br>---" .$sql;
//                   exit();
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
                    {       echo("$title\n");   }
                        
                    /*echo ("$tsjtitle");
                    print("\n");
                    print("\n");*/

                    //define separator (defines columns in excel & tabs in word)
                    $sep = " \t"; //tabbed character

                    //start of printing column names as names of MySQL fields
                    //-1 to avoid printing of coulmn heading country
                   // for ($i =9; $i < mysql_num_fields($result)-4; $i++)
                   // {
                   //   echo mysql_field_name($result,$i) . "\t";
                   // }
                    echo "Institution Name"."\t";
                    echo "Contact Person"."\t";
                    echo "Designation"."\t";
                    echo "Email"."\t";
                    echo "Address"."\t";
                    echo ""."\t";
                    echo "City"."\t";
                    echo "Pincode"."\t";
                    echo "Country"."\t";
                    echo "Telephone "."\t";
                    echo "Fax"."\t";
                    echo "Website"."\t";
                    echo "TypeOfInstitution"."\t";
                    echo "Investor"."\t";
                    
                    print("\n");

                    /*print("\n");*/
                    //end of printing column names

                    //start while loop to get data
                    /*
                    note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
                    */



                    while($row = mysql_fetch_row($result))
                     {
                        
                         //set_time_limit(60); // HaRa
                         $schema_insert = "";
                         $strStage="";
                         $strIndustry="";
                         $strCompany="";
                         $stripoCompany="";
                         $strmandaCompany="";

                         $InvestorId=$row[0];//investorid


                        /* $Investorname=$row[1];
                         $Investorname=strtolower($Investorname);

                         $invResult=substr_count($Investorname,$searchString);
                         $invResult1=substr_count($Investorname,$searchString1);
                         $invResult2=substr_count($Investorname,$searchString2);
                         if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                         {*/
                                $schema_insert .=trim($row[1]).$sep; //LP Name
                                $schema_insert .=trim($row[2]).$sep;//Contact person
                                $schema_insert .=trim($row[3]).$sep;//Designation
//                                $schema_insert .=strip_tags(str_replace(','," ",$row[4])).$sep; //address
//                                $schema_insert .=strip_tags(str_replace(','," ",$row[5])).$sep; //address line 2
                                $schema_insert .=trim($row[4]).$sep; //Email
                                $schema_insert .=trim($row[5]).$sep; //Address1
                                $schema_insert .=trim($row[6]).$sep; //Address2
                                $schema_insert .=trim($row[7]).$sep; //City
                                $schema_insert .=trim($row[8]).$sep; //PinCode
                                $schema_insert .=trim($row[9]).$sep; //Country
                                $schema_insert .=trim($row[10]).$sep; //Phone
                                $schema_insert .=trim($row[11]).$sep; //Fax
                                $schema_insert .= trim($row[12]).$sep; //Website
                                $schema_insert .= trim($row[13]).$sep; //TypeOfInstitution
                                
                                                          

                               
                               
                               
                                   /* $Investmentsql = "SELECT inv.Investor
                   FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv,limited_partners as lp
                   WHERE peinv.Deleted =0
                   AND c.PECompanyId = peinv.PECompanyId
                   AND c.industry !=15
                   AND i.industryid = c.industry
                   AND lp.LPId = $InvestorId and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)
                   AND inv.InvestorId = peinv_inv.InvestorId
                   AND peinv.PEId = peinv_inv.PEId
                   group by inv.Investor order by peinv.dates desc"; */
                   $Investmentsql = "SELECT inv.Investor
                   FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv,limited_partners as lp
                   WHERE peinv.Deleted =0
                   AND c.PECompanyId = peinv.PECompanyId
                   AND c.industry !=15
                   AND i.industryid = c.industry
                   AND lp.LPId = $InvestorId and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName,  REPLACE( inv.LimitedPartners,', ',','))
                   AND inv.InvestorId = peinv_inv.InvestorId
                   AND peinv.PEId = peinv_inv.PEId
                   group by inv.Investor order by peinv.dates desc";
                  // echo $Investmentsql;
                   
                                    if($rsStage= mysql_query($Investmentsql))
                                    {
                                            While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
                                            {
                                                    $strStage=$strStage.", ".$myStageRow["Investor"];
                                            }
                                            $strStage =substr_replace($strStage, '', 0,1);
                                    }
                                    $schema_insert .=$strStage.$sep; //Preferred Stage of funding
                                

                                

                          
                                 $schema_insert .= ""."\n";
                                //following fix suggested by Josue (thanks, Josue!)
                                //this corrects output in excel when table fields contain \n or \r
                                //these two characters are now replaced with a space
                                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                         $schema_insert .= "\t";
                         print($schema_insert);
                         print "\n";
                         
                        // } //endof if loop for investorname check         
                        //commented the foll line in order to get printed $ symbol in excel file
                        // $schema_insert = str_replace($sep."$", "", $schema_insert);

                           
                     }

                    print "\n";
                    print "\n";
                    print "\n";
                    print "\n";
                    print "\n";
                    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
                    print("\n");
                    print("\n");

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
                                            $subject="Investor Profile - $filetitle";
                                            $message="<html><center><b><u> Investor Profile :$frmwhichpage - $filetitle - $submitemail</u></b></center><br>
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

                }
                //      }
                //else
                //  header( 'Location: http://www.ventureintelligence.com/pelogin.php' ) ;

    ?>