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
$acq=$_POST['queryString']."%";
        
        
         $getacqSql="select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
        where ac.Acquirer LIKE '%".$acq."%' and ac.AcquirerId=peinv.AcquirerId GROUP BY peinv.AcquirerId";
         
                            $searchString="Undisclosed";
                            $searchString=strtolower($searchString);

                            $searchString1="Unknown";
                            $searchString1=strtolower($searchString1);

                            $searchString2="Others";
                            $searchString2=strtolower($searchString2);

                            if ($acq = mysql_query($getacqSql))
                            {
                                 $jsonarray=array();
                                    While($myrow=mysql_fetch_array($acq, MYSQL_BOTH))
                                    {
                                        
                                                    $acquirer = $myrow["Acquirer"];
                                                    $acquirerid=$myrow["AcquirerId"];
                                                    $jsonarray[]=array('acquirer'=>addslashes($acquirer),'acquirerid'=>$acquirerid);
                                            
                                    }
                                     mysql_free_result($acq);
                                     echo json_encode($jsonarray);
                                     /*if(count($jsonarray) > 0){
                                        
                                     }else{
                                         echo json_encode(array('status'=> 0));
                                     }*/
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
