<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$select_type = $_REQUEST['select_type'];
$VCFlagValue=$_REQUEST['vcflag'];
$search=$_REQUEST['search'];
if($select_type == 'investor'){
       $getinvestorSql = geINVSql($search);
        $jsonarray=array();
        
        if ($rsinvestors = mysql_query($getinvestorSql))
        {
                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                {

                    $invName = $myrow["Investor"];
                    $invId= $myrow["InvestorId"];

                    $jsonarray[]=array('id'=>$invId,'name'=>$invName);
                    //$totalCount=$totalCount+1;
                }
        }
        echo json_encode($jsonarray);
}else if($select_type == 'company'){    
        $flag = $_REQUEST['getAllReCompanies'];  
      
        $query = getAllReCompanies($flag,$search); 
    
        $result = mysql_query($query);
        while($row=  mysql_fetch_array($result)){
            
            $companyId=$row['PECompanyId'];
            $compName=$row['companyname'];
           
            $jsonarray[]=array('id'=>$companyId,'name'=>addslashes($compName));
        }
    
       echo json_encode($jsonarray);
            
}else if($select_type == 'sector'){
       $flag = $_REQUEST['getAllReSector'];
        
        $query = getAllReSector($flag,$search);
        $result = mysql_query($query);
        while($row=  mysql_fetch_array($result)){
            
           // $sector=$row['sector_business'];
            
            $sector = trim($row["sector_business"]);
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
            
            $jsonarray[]=array('id'=>$sectorName,'name'=>addslashes($sectorName));
        }
        
         echo json_encode($jsonarray);        
        
        
}else if($select_type == 'legal_advisor'){
    
    $advisorsql=getReAdvisorsByValue("L1",$search);	
	
    if ($rsadvisor = mysql_query($advisorsql)){
            $advisor_cnt = mysql_num_rows($rsadvisor);
    }
    $searchString="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $searchString2="Others";
    $searchString2=strtolower($searchString2);

    if($advisor_cnt >0){
         While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
            $adviosrname=trim($myrow["Cianame"]);
            $adviosrname=strtolower($adviosrname);

            $invResult=substr_count($adviosrname,$searchString);
            $invResult1=substr_count($adviosrname,$searchString1);
            $invResult2=substr_count($adviosrname,$searchString2);

            if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
                $ladvisor = $myrow["Cianame"];
                $ladvisorid = $myrow["CIAId"];
                $jsonarray[]=array('id'=>$ladvisorid,'name'=>addslashes($ladvisor));
            }
        }
         echo json_encode($jsonarray);   
    }
      
}else if($select_type == 'transaction_advisor'){
    $advisorsql=getReAdvisorsByValue("T1",$search);
        
    if ($rsadvisor = mysql_query($advisorsql)){
            $advisor_cnt = mysql_num_rows($rsadvisor);
    } 
    $searchString="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $searchString2="Others";
    $searchString2=strtolower($searchString2);
    if($advisor_cnt >0){
        While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
            $adviosrname=trim($myrow["Cianame"]);
            $adviosrname=strtolower($adviosrname);

            $invResult=substr_count($adviosrname,$searchString);
            $invResult1=substr_count($adviosrname,$searchString1);
            $invResult2=substr_count($adviosrname,$searchString2);

            if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
                $ladvisor = $myrow["Cianame"];
                $ladvisorid = $myrow["CIAId"];
                $jsonarray[]=array('id'=>$ladvisorid,'name'=>addslashes($ladvisor));
            }
        }
         echo json_encode($jsonarray);   
    }
}   
        function geINVSql($search)
        {

            $getinvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                FROM REinvestments AS pe, REcompanies AS pec, REinvestments_investors AS peinv, REinvestors AS inv, realestatetypes AS s
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND s.RETypeId = pe.StageId
                AND pe.IndustryId =15
                AND peinv.PEId = pe.PEId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 and inv.Investor LIKE '".$search."%' order by inv.Investor";
            return $getinvestorSql;
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
                    WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0 AND pec.companyname LIKE  '".$search."%'  ORDER BY pec.companyname";

            }

            elseif($peorvcflag==1) //RE IPO-Exits
            {
                    $pagetitle="RE PE-backed IPO Companies";

                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 AND pec.companyname LIKE  '".$search."%'  ORDER BY pec.companyname";
            //	echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==2) //RE - M&A Exits
            {
                    $pagetitle="RE PE-Exits M&A Companies";
                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REmanda AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 AND pec.companyname LIKE  '".$search."%'  ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==3) //RE - M&A
            {
                   $pagetitle="RE M&A Companies";
                $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REmama AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 AND pec.companyname LIKE  '".$search."%'  ORDER BY pec.companyname";
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
                    $getcompaniesSql_search="SELECT DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REinvestments AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0  and  pec.sector_business LIKE   '".$search."%'    ORDER BY pec.companyname";

            }

            elseif($peorvcflag==1) //RE IPO-Exits
            {
                    $pagetitle="RE PE-backed IPO Companies";

                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0  and  pec.sector_business LIKE   '".$search."%'    ORDER BY pec.companyname";
            //	echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==2) //RE - M&A Exits
            {
                    $pagetitle="RE PE-Exits M&A Companies";
                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REmanda AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0  and  pec.sector_business LIKE   '".$search."%'    ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==3) //RE - M&A
            {
                   $pagetitle="RE M&A Companies";
                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REmama AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0  and  pec.sector_business LIKE   '".$search."%'    ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            return $getcompaniesSql_search;
      }
      function getReAdvisorsByValue($peorvcflag,$search)
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
                                            AND cia.Cianame like '$search%'
                                            AND adac.PEId = peinv.PEId)
                                            UNION (
                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REinvestments AS peinv, REcompanies AS c, REadvisor_cias AS cia,
                                            REinvestments_advisorcompanies AS adac
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' AND cia.Cianame like '$search%'
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
                                            AND cia.Cianame like '$search%'
                                            AND adac.PEId = peinv.MandAId)
                                            UNION (
                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                            FROM REmanda AS peinv, REcompanies AS c,  REadvisor_cias AS cia,
                                            REinvestments_advisorcompanies AS adac
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' AND cia.Cianame like '$search%'
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
                                             AND cia.Cianame like '$search%'
                                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                                            )
                                            UNION (
                                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                                            WHERE Deleted =0
                                            AND c.PECompanyId = peinv.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID
                                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."' AND cia.Cianame like '$search%'
                                            )
                                            ORDER BY Cianame";

            }
            
            //echo "<Br>PE - VC---" .$advisorsql;
            
            return $advisorsql;


         
      }
       mysql_close();  
?>
