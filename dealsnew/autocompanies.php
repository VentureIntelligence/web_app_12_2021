<?php 

//error_reporting(0);
 require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
     {
              header('Location:../pelogin.php');
     }
     else
     {  
$company=$_POST['queryString']."%";
        
        
         $getcompaniesSql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
			    FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
			    WHERE pec.PECompanyId = pe.InvesteeId 
			    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
			    AND r.RegionId = pec.RegionId and pec.companyname like '" .$company. "'
			    ORDER BY pec.companyname";
         
                            $searchString="Undisclosed";
                            $searchString=strtolower($searchString);

                            $searchString1="Unknown";
                            $searchString1=strtolower($searchString1);

                            $searchString2="Others";
                            $searchString2=strtolower($searchString2);

                            if ($rsinvestors = mysql_query($getcompaniesSql))
                            {
                                 $jsonarray=array();
                                    While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                    {
                                            $companyname=trim($myrow["companyname"]);
                                            $companyname=strtolower($companyname);

                                            $invResult=substr_count($companyname,$searchString);
                                            $invResult1=substr_count($companyname,$searchString1);
                                            $invResult2=substr_count($companyname,$searchString2);

                                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                            {
                                                    $compName = $myrow["companyname"];
                                                    $companyId=$myrow["PECompanyId"];
                                                    $jsonarray[]=array('companyname'=>addslashes($compName),'companyid'=>$companyId);
                                            }
                                    }
                                     mysql_free_result($rsinvestors);
                                     echo json_encode($jsonarray);
                            }
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
							
            if ($rsinvestors = mysql_query($getInvestorSql)){
               $investor_cnt = mysql_num_rows($rsinvestors);
            }
			
            if($investor_cnt >0){
                $jsonarray=array();
             	 While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investorname=trim($myrow["Investor"]);
                        $Investorname=strtolower($Investorname);

                        $invResult=substr_count($Investorname,$searchString);
                        $invResult1=substr_count($Investorname,$searchString1);
                        $invResult2=substr_count($Investorname,$searchString2);

                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
                                $investor = $myrow["Investor"];
                                $investorId = $myrow["InvestorId"];
                                $jsonarray[]=array('investorname'=>addslashes($investor),'investorid'=>$investorId);
                        }
            	}
                mysql_free_result($invtypers);
                echo json_encode($jsonarray);
            }
        }
    ?>
