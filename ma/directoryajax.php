<?php
            require_once("../dbconnectvi.php");//including database connectivity file
            $Db = new dbInvestments();
            include ('machecklogin.php');
            $jsonarray = array();
            $dealvalue = $_REQUEST['dealvalue'];
            $queryString = $_REQUEST['queryString'];
            /* populating the investortype from the investortype table */
		$searchStrings="Undisclosed";
			$searchStrings=strtolower($searchStrings);
		
			$searchStrings1="Unknown";
			$searchStrings1=strtolower($searchStrings1);
		
			$searchStrings2="Others";
			$searchStrings2=strtolower($searchStrings2);
		
               if($dealvalue==101)
                {
                     $getcompaniesSql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business FROM
                        mama AS pe, industry AS i, pecompanies AS pec WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                        AND pe.Deleted =0 and pec.industry != 15 AND pec.companyname like '%".$queryString."%'  order by pec.companyname limit 0,100";
                            
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if( $companies_cnts >0){
                             //mysql_data_seek($rsinvestor ,0);
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);
                                        $companyId=$myrow["PECompanyId"];
                                        
                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $companies = $myrow["companyname"] ;
                                            $jsonarray[]=array('companyname'=>addslashes($companies),'dealvalue'=>$dealvalue,'companyId'=>$companyId);
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            //$isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            //echo "'".$companies."',";
                                        }
                                }                          
                    }
                }
                else if($dealvalue==102)
                {
                     $getcompaniesSql="SELECT distinct peinv.AcquirerId, ac.Acquirer
                                    FROM acquirers AS ac, mama AS peinv
                                    WHERE ac.AcquirerId = peinv.AcquirerId and
                                    peinv.Deleted=0 and ac.Acquirer like '%".$queryString."%' order by Acquirer";
                            
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if( $companies_cnts >0){
                             //mysql_data_seek($rsinvestor ,0);
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Acquirer"]);
                                        $companyname=strtolower($companyname);
                                        $companyId=$myrow["AcquirerId"];

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $companies = $myrow["Acquirer"] ;
                                            $jsonarray[]=array('companyname'=>addslashes($companies),'dealvalue'=>$dealvalue,'companyId'=>$companyId);
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            //$isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            //echo "'".$companies."',";
                                        }
                                }                          
                    }
                }
                else if($dealvalue==103 || $dealvalue==104)
                {                     
                    if($dealvalue==103)
                    {
                        $adtype="L";
                    }
                    else if($dealvalue==104)
                    {
                        $adtype="T";
                    }

//                    $advisorsql="(
//                             SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
//                             FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
//                             WHERE Deleted =0
//                             AND c.PECompanyId = peinv.PECompanyId
//                             AND adac.CIAId = cia.CIAID and  AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
//                             AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
//                             " AND cia.Cianame like '%".$queryString."%')
//                             UNION (
//                             SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
//                             FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
//                             WHERE Deleted =0
//                             AND c.PECompanyId = peinv.PECompanyId
//                             AND adcomp.CIAId = cia.CIAID  and  AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
//                             AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
//                             " AND cia.Cianame like '%".$queryString."%')	ORDER BY Cianame";
                    
                    
                    $advisorsql="(
                             SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                             FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                             WHERE Deleted =0
                             AND c.PECompanyId = peinv.PECompanyId
                             AND adac.CIAId = cia.CIAID and  AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                             AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                             " AND cia.Cianame like '%".$queryString."%')
                             UNION (
                             SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                             FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                             WHERE Deleted =0
                             AND c.PECompanyId = peinv.PECompanyId
                             AND adcomp.CIAId = cia.CIAID  and  AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                             AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                             " AND cia.Cianame like '%".$queryString."%')	ORDER BY Cianame";

                            if ($rsinvestors = mysql_query($advisorsql)){
                                    $advisor_cnts = mysql_num_rows($rsinvestors);
                            }

                            if($advisor_cnts >0){
                                 mysql_data_seek($rsinvestor ,0);
                                    While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                    {
                                            $companyname=trim($myrow["Cianame"]);
                                            $companyname=strtolower($companyname);
                                            $companyId=$myrow["CIAId"];
                                            
                                            $invResult=substr_count($companyname,$searchString);
                                            $invResult1=substr_count($companyname,$searchString1);
                                            $invResult2=substr_count($companyname,$searchString2);

                                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                            {
                                                $advisors = $myrow["Cianame"] ;
                                                $jsonarray[]=array('advisors'=>addslashes($advisors),'dealvalue'=>$dealvalue,'companyId'=>$companyId);
                                                //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                               // $isselcted = (trim($_POST['keywordsearchmain'])==trim($advisors)) ? 'SELECTED' : '';
                                               // echo "'".$advisors."',";
                                            }
                                    }                          
                        }
                        
                }
                
                
                 echo json_encode($jsonarray);
                 mysql_close();
    ?>