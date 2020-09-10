<?php
    function getReInvestorsByValue($flagvalue)
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
                AND pe.Deleted=0 order by inv.Investor";
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
                AND pe.Deleted=0 order by inv.Investor ";
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
                AND pe.Deleted=0  order by inv.Investor ";
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
                AND pe.Deleted=0  order by inv.Investor ";
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
      
      
      function getAllReCompanies($peorvcflag)
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
                    WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0 ORDER BY pec.companyname";

            }

            elseif($peorvcflag==1) //RE IPO-Exits
            {
                    $pagetitle="RE PE-backed IPO Companies";

                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ORDER BY pec.companyname";
            //	echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==2) //RE - M&A Exits
            {
                    $pagetitle="RE PE-Exits M&A Companies";
                    $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REmanda AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==3) //RE - M&A
            {
                   $pagetitle="RE M&A Companies";
                $getcompaniesSql_search="SELECT DISTINCT pe.PECompanyId, pec.companyname
                    FROM REcompanies AS pec, REmama AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            return $getcompaniesSql_search;
      }
      
      function getAllReSector($peorvcflag)
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
                    WHERE pec.PECompanyId = pe.PEcompanyId  and pe.Deleted=0 ORDER BY pec.companyname";

            }

            elseif($peorvcflag==1) //RE IPO-Exits
            {
                    $pagetitle="RE PE-backed IPO Companies";

                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REipos AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ORDER BY pec.companyname";
            //	echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==2) //RE - M&A Exits
            {
                    $pagetitle="RE PE-Exits M&A Companies";
                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REmanda AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            elseif($peorvcflag==3) //RE - M&A
            {
                   $pagetitle="RE M&A Companies";
                    $getcompaniesSql_search="SELECT  DISTINCT pec.sector_business
                    FROM REcompanies AS pec, REmama AS pe
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    and pe.Deleted=0 ORDER BY pec.companyname";
                    //echo "<br>--" .$getcompaniesSql;
            }
            return $getcompaniesSql_search;
      }
?>
