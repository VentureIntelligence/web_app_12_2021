<?php 

//error_reporting(0);
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$company=$_POST['queryString']."%";
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{       
        
    $getcompaniesSql="SELECT  DISTINCT  company_name FROM  angelco_fundraising_cos  WHERE company_name  like '%" .$company. "%'   ORDER BY company_name";

   if ($rsinvestors = mysql_query($getcompaniesSql))
   {
        $jsonarray=array();
           While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
           {

                           $compName = $myrow["company_name"];

                           $jsonarray[]=array('companyname'=>addslashes($compName),'companyid'=>$compName);

           }
            mysql_free_result($rsinvestors);
            echo json_encode($jsonarray);
   }

mysql_close();
    mysql_close($cnx);
}
    ?>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
							
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
?>
