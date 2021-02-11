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
$investor=$_POST['queryString']."%";
        
        $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                    WHERE pe.InvesteeId = pec.PEcompanyId
                    AND pec.industry !=15
                    AND peinv.AngelDealId = pe.AngelDealId
                    AND inv.InvestorId = peinv.InvestorId
                    AND pe.Deleted=0 and inv.investor like '" .$investor. "' order by inv.Investor ";
        
            $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
							
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
