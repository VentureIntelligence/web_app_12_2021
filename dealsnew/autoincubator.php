<?php 

//error_reporting(0);
 require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$incubator=$_POST['queryString']."%";
if(!isset($_SESSION['UserNames']))
     {
              header('Location:../pelogin.php');
     }
     else
     {  
$getIncubatorsSql="SELECT DISTINCT pe.IncubatorId, inc.Incubator
                    FROM incubatordeals AS pe,  incubators as inc
                    WHERE inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 and inc.Incubator!=''
                     and inc.Incubator like '" .$incubator. "'order by inc.Incubator ";
        
                        $searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);
				
                        if ($rsinvestors = mysql_query($getIncubatorsSql)){
                           $investor_cnt = mysql_num_rows($rsinvestors);
                        }

                        if($investor_cnt >0){
                              $jsonarray=array();
                             While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                                    $Investorname=trim($myrow["Incubator"]);
                                    $Investorname=strtolower($Investorname);

                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);

                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                    {
                                            $incubator = $myrow["Incubator"];
                                            $incubatorId = $myrow["IncubatorId"];
                                            $jsonarray[]=array('incubatorname'=>addslashes($incubator),'incubatorid'=>$incubatorId);
                                    }
                            }
                             mysql_free_result($invtypers);
                            echo json_encode($jsonarray);
                    }
                }
    ?>
