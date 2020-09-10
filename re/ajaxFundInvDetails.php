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

            //$getinvestorSql="SELECT DISTINCT InvestorId, Investor FROM REinvestors WHERE  Investor LIKE '".$search."%' ORDER BY Investor desc";
            $getinvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv, realestatetypes AS s
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND s.RETypeId = pe.StageId
                AND pe.IndustryId =15
                AND peinv.PEId = pe.PEId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 and inv.Investor LIKE '%".$search."%' order by inv.Investor";
            return $getinvestorSql;
        }
        
        //mysql_close();
        
        
                
                        
?>
