<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $search=$_REQUEST['search'];
            
        $getinvestorSql = geINVSql($search);
        $jsonarray=array();
        
        if ($rsinvestors = mysql_query($getinvestorSql))
        {
                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                {

                    $invName = $myrow["Investor"];
                    $invId= $myrow["InvestorId"];

                    $jsonarray[]=array('id'=>$invId,'label'=>$invName,'value'=>$invName);
                    //$totalCount=$totalCount+1;
                }
        }
        echo json_encode($jsonarray);
        
        function geINVSql($search)
        {

                $getinvestorSql="SELECT DISTINCT p.InvestorId, p.Investor FROM peinvestors p INNER JOIN fundRaisingDetails f ON f.InvestorId=p.InvestorId WHERE  p.Investor LIKE '".$search."%'   ORDER BY p.Investor desc";

                return $getinvestorSql;
        }
              
                        
?>
