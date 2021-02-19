<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 include ('checklogin.php');
     $search = $_REQUEST['search'];

if(isset($_REQUEST['getcompany'])){    

    
    $flag = $_REQUEST['getAllReCompanies'];
    
      
        $query = getAllReCompanies($flag,$search); 
    
    
        $result = mysql_query($query);
        while($row=  mysql_fetch_array($result)){
            
            $companyId=$row['PECompanyId'];
            $compName=$row['companyname'];
           
            $jsonarray[]=array('companyname'=>addslashes($compName),'companyid'=>$companyId);
    }
    
       echo json_encode($jsonarray);
      
}

if(isset($_REQUEST['getsector'])){    
    $flag = $_REQUEST['getAllReSector'];
        
        $query = getAllReSector($flag,$search);
        $result = mysql_query($query);
        $temp_array= array();
        while($row=  mysql_fetch_array($result)){
            
           // $sector=$row['sector_business'];
            if($flag == 0){
                $sector = trim($row["sector"]);
            } else {
                $sector = trim($row["sector_business"]);
            }
                                                $pos = strpos($sector, '(');

                                                if ($pos == false) {
                                                    $sectorName = $sector;                                        
                                                } else {
                                                    $sectorName = substr_replace($sector, '', $pos);

        }
        
                                                $sectorName = trim($sectorName);

                                                if (in_array($sectorName, $temp_array)) {
                                                    continue;
                                                }
                                                $temp_array[] = $sectorName;
            
            $jsonarray[]=array('sectorname'=>addslashes($sectorName),'id'=>$sectorName);
        }
        
         echo json_encode($jsonarray);
        
      
    
}


if(isset($_REQUEST['getinvestor'])){    
    $flag = $_REQUEST['getReInvestorsByValue'];
        
         $query = getReInvestorsByValue($flag,$search);
        $result = mysql_query($query);
        while($row=  mysql_fetch_array($result)){
            
            $investor = $row["Investor"];
            $investorId = $row["InvestorId"];
            $jsonarray[]=array('investorname'=>addslashes($investor),'investorid'=>$investorId);
                                
          
        }
        
         echo json_encode($jsonarray);
        
     
    
}




if(isset($_REQUEST['getacquirer'])){    
   if($_REQUEST['acquirer']==1) {
        
        $query = "select peinv.AcquirerId,ac.Acquirer from  REmanda AS peinv,REacquirers as ac WHERE ac.AcquirerId = peinv.AcquirerId AND ac.Acquirer LIKE '%".$search."%'  GROUP BY peinv.AcquirerId";
        $result = mysql_query($query);
        while($row=  mysql_fetch_array($result)){
            
            $acquirer = $row["Acquirer"];
            $acquirerId = $row["AcquirerId"];
            $jsonarray[]=array('acquirername'=>addslashes($acquirer),'acquirerid'=>$acquirerId);
                                
          
        }
        
         echo json_encode($jsonarray);
        
   }
   elseif($_REQUEST['acquirer']==2) {
        
        $query = "select peinv.AcquirerId,ac.Acquirer from  REmama AS peinv,REacquirers as ac WHERE ac.AcquirerId = peinv.AcquirerId AND ac.Acquirer LIKE '%".$search."%'  GROUP BY peinv.AcquirerId";
        $result = mysql_query($query);
        while($row=  mysql_fetch_array($result)){
            
            $acquirer = $row["Acquirer"];
            $acquirerId = $row["AcquirerId"];
            $jsonarray[]=array('acquirername'=>addslashes($acquirer),'acquirerid'=>$acquirerId);
                                
          
        }
        
         echo json_encode($jsonarray);
        
   }
    
}




    function getReInvestorsByValue($flagvalue,$search)
    {
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);

        
        if($flagvalue==0)
        {
          $pagetitle="RE Investors";
                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv, realestatetypes AS s
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND s.RETypeId = pe.StageId
                AND pe.IndustryId =15
                AND peinv.PEId = pe.PEId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 AND inv.Investor and LIKE '%".$search."%' order by inv.Investor";
        }


        if($flagvalue==1)
        {
          $pagetitle="RE Investors- Investments";
                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv, realestatetypes AS s
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND s.RETypeId = pe.StageId
                AND pe.IndustryId =15
                AND peinv.PEId = pe.PEId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 and  inv.Investor LIKE '%".$search."%'  order by inv.Investor ";
        }
        elseif($flagvalue==2)
        {
          $pagetitle="RE Investors - IPOs";
           $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry =15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 and  inv.Investor LIKE '%".$search."%'   order by inv.Investor ";
          }
        elseif($flagvalue==3)	//echo "<br>--" .$getInvestorSql;
        {
          $pagetitle="RE Investors- M&A";
           $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                                        WHERE pe.PECompanyId = pec.PEcompanyId
                                        AND pec.industry =15
                                        AND peinv.MandAId = pe.MandAId
                                        AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 and  inv.Investor LIKE '%".$search."%'   order by inv.Investor ";
        }
        return $getInvestorSql;
    }
    
      function getReAdvisorsByValue($peorvcflag)
      {
            
            $adtype=substr($peorvcflag,0,1);
            $peorvcflagvalue=substr($peorvcflag,1,1);
            $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
            $addVCFlagqry="";
            if($adtype=="L")
            {  $adtitledisplay ="Legal";}
            elseif($adtype=="T")
            {  $adtitledisplay="Transaction";}
            
            //1- RE Inv advisors , 2- RE Exits Advisors , 3 - RE M&A Advisors
            if($peorvcflagvalue==1)
            {
                    $addVCFlagqry="";
                    $pagetitle="RE Advisors - ".$adtitledisplay;
                    $advisorsql="(
                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REinvestments AS peinv, REcompanies AS c, REadvisor_cias AS cia,
                                            REinvestments_advisorinvestors AS adac
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                                            AND adac.PEId = peinv.PEId)
                                            UNION (
                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REinvestments AS peinv, REcompanies AS c, REadvisor_cias AS cia,
                                            REinvestments_advisorcompanies AS adac
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
                                            AND adac.PEId = peinv.PEId ) order by Cianame";

            }
            elseif($peorvcflagvalue==2)
            {
                    $addVCFlagqry = "";
                    $pagetitle="RE Exits Advisors- ".$adtitledisplay;
                    $advisorsql="(
                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REmanda AS peinv, REcompanies AS c, REadvisor_cias AS cia,
                                            REinvestments_advisoracquirer AS adac
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID   and AdvisorType='".$adtype ."'
                                            AND adac.PEId = peinv.MandAId)
                                            UNION (
                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REmanda AS peinv, REcompanies AS c,  REadvisor_cias AS cia,
                                            REinvestments_advisorcompanies AS adac
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                                            AND adac.PEId = peinv.MandAId ) order by Cianame";
            }
            elseif($peorvcflagvalue==3)
            {
                    $addVCFlagqry="";
                    $pagetitle="RE M&A Advisors- ".$adtitledisplay;
                    $advisorsql="(
                                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                                            WHERE Deleted =0
                                            AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID
                                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                                            )
                                            UNION (
                                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                                            WHERE Deleted =0
                                            AND c.PECompanyId = peinv.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID
                                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                                            )
                                            ORDER BY Cianame";

            }
            
            //echo "<Br>PE - VC---" .$advisorsql;
            
            return $advisorsql;


            
      }
      
      
      function getAllReCompanies($peorvcflag,$search)
      {
          $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
            if($peorvcflag==0) //RE - PE companies
            {
                    $pagetitle="RE PE-backed Companies";
                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname 
                    FROM REcompanies AS pec, REinvestments AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0 AND pec.companyname LIKE  '%".$search."%'  ORDER BY pec.companyname";

            }

            elseif($peorvcflag==1) //RE IPO-Exits
            {
                    $pagetitle="RE PE-backed IPO Companies";

                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 AND pec.companyname LIKE  '%".$search."%'  ORDER BY pec.companyname";
            //	echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==2) //RE - M&A Exits
            {
                    $pagetitle="RE PE-Exits M&A Companies";
                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REmanda AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 AND pec.companyname LIKE  '%".$search."%'  ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==3) //RE - M&A
            {
                   $pagetitle="RE M&A Companies";
                $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REmama AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 AND pec.companyname LIKE  '%".$search."%'  ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            return $getcompaniesSql_search;
      }
      
      function getAllReSector($peorvcflag,$search)
      {
          $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
            if($peorvcflag==0) //RE - PE companies
            {
                    $pagetitle="RE PE-backed Companies";
                    /*$getcompaniesSql_search="SELECT DISTINCT pec.sector_business FROM REcompanies AS pec, REinvestments AS pe WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0  and  pec.sector_business LIKE   '%".$search."%'    ORDER BY pec.companyname";*/
                    $getcompaniesSql_search="SELECT DISTINCT pe.sector
                    FROM REcompanies AS pec, REinvestments AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0  and  pe.sector LIKE   '%".$search."%'    ORDER BY pec.companyname";

            }

            elseif($peorvcflag==1) //RE IPO-Exits
            {
                    $pagetitle="RE PE-backed IPO Companies";

                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0  and  pec.sector_business LIKE   '%".$search."%'    ORDER BY pec.companyname";
            //	echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==2) //RE - M&A Exits
            {
                    $pagetitle="RE PE-Exits M&A Companies";
                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REmanda AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0  and  pec.sector_business LIKE   '%".$search."%'    ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==3) //RE - M&A
            {
                   $pagetitle="RE M&A Companies";
                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REmama AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0  and  pec.sector_business LIKE   '%".$search."%'    ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            return $getcompaniesSql_search;
      }
      mysql_close();
?>
