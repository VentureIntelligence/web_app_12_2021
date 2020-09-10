<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $VCFlagValue=$_REQUEST['vcflag'];
        $search=$_REQUEST['search'];
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        if(($VCFlagValue=="0" || $VCFlagValue=="1") && trim(search)!="" )
        {
            $searchString="Undisclosed";
            $searchString=strtolower($searchString);
            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
            $addVCFlagqry="";    
            $getcompaniesSql=getPESql($VCFlagValue,$search);
            $jsonarray=array();

            if ($rssector = mysql_query($getcompaniesSql))
            {
                $temp_array=array();
                
                        While($myrow=mysql_fetch_array($rssector, MYSQL_BOTH))
                        {
                                $sectorname=trim($myrow["sector_business"]);
                                $sectorname=strtolower($sectorname);

                                $invResult=substr_count($sectorname,$searchString);
                                $invResult1=substr_count($sectorname,$searchString1);
                                $invResult2=substr_count($sectorname,$searchString2);

                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ($sectorname!=""))
                                {
                                            $sector = trim($myrow["sector_business"]);
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
                                                $jsonarray[] = array('id' => $sectorName, 'label' => $sectorName, 'value' => $sectorName);


                }
                        }
                }
                echo json_encode($jsonarray);

            }
            else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==7 || $VCFlagValue==8 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11){
                        
                        $showallcompInvFlag=$_REQUEST['showallcompInvFlag']; 
                        $getcompaniesSql=getSVSql($showallcompInvFlag,$search);
                        $jsonarray=array();        
                        if ($rssector = mysql_query($getcompaniesSql))
			{
				$temp_array=array();
                                
				While($myrow=mysql_fetch_array($rssector, MYSQL_BOTH))
				{
					$sectorname=trim($myrow["sector_business"]);
					$sectorname=strtolower($sectorname);
	
					$invResult=substr_count($sectorname,$searchString);
					$invResult1=substr_count($sectorname,$searchString1);
					$invResult2=substr_count($sectorname,$searchString2);
	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ($sectorname!=""))
					{
                                            $sector = trim($myrow["sector_business"]);
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
                                                $jsonarray[] = array('id' => $sectorName, 'label' => $sectorName, 'value' => $sectorName);


			}
				}
			}
                        echo json_encode($jsonarray);


            }
        
        
        
        
        function getPESql($VCFlagValue,$search)
        {

        $addVCFlagqry="";
        //0- pecompanies,1-vccompanies
            if($VCFlagValue==0)
            {
                    $addVCFlagqry="";
                    $pagetitle="PE-backed Companies";

                     $getcompaniesSql="SELECT DISTINCT pec.sector_business
                                                    FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                    WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                    AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%' " .$addVCFlagqry. "
                    ORDER BY pec.sector_business";

            }
            elseif($VCFlagValue==1)
            {
                    $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                    $pagetitle="VC-backed Companies";

                    $getcompaniesSql="SELECT DISTINCT pec.sector_business FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                    WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                    AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%' " .$addVCFlagqry. "
                    ORDER BY pec.sector_business";
            }
            return $getcompaniesSql;
        }
        
        
        function getSVSql($showallcompInvFlag,$search)
        {
           
                $addVCFlagqry="";
                if($showallcompInvFlag==0)
                {
                        $addVCFlagqry="";
                        $pagetitle="PE-backed Companies";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";

                }
                elseif($showallcompInvFlag==1)
                {
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        $pagetitle="VC-backed Companies";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";
                }
                elseif($showallcompInvFlag==2) // Incubatees
                        {
                            $addVCFlagqry="";
                        $pagetitle="Incubatee(s)";
                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                        FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                        WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                         and pe.Deleted=0 and pec.industry!=15 AND pec.sector_business LIKE '".$search."%' 
                        ORDER BY pec.sector_business";
                        }
                elseif($showallcompInvFlag==3) //PE_ipos
                {
                        $addVCFlagqry="";
                        $pagetitle="PE-backed IPO Companies";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                        WHERE pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==4) //VC-ipos
                {
                        $addVCFlagqry="and VCFlag=1";
                        $pagetitle="VC-backed IPO Companies";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                        WHERE pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId  AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. " 
                        ORDER BY pec.sector_business";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==5) //PE-EXits M&A Companies
                {
                        $addVCFlagqry="";
                        $pagetitle="PE-Exits M&A Companies";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                        FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                        WHERE pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==6) //VC-EXits M&A Companies
                {
                    $addVCFlagqry="and VCFlag=1";
                    $pagetitle="VC-Exits M&A Companies";

                    $getcompaniesSql="SELECT DISTINCT pec.sector_business
                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                    ORDER BY pec.sector_business";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==7) //Angel Companies
                {
                    $addVCFlagqry="";
                    $pagetitle="Angel-backed Companies";
                    $getcompaniesSql="SELECT DISTINCT pec.sector_business
                    FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                    WHERE pec.PECompanyId = pe.InvesteeId 
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                    ORDER BY pec.sector_business";
                //	echo "<br>--" .$getcompaniesSql;

                }
                elseif($showallcompInvFlag==8)     //social venture investment companies
                {
                        $addVCFlagqry = " ";
                        $pagetitle="SV-backed Companies";
                        $dbtype="SV";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                        stage AS s ,peinvestments_dbtypes as pedb
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";
                        //echo"<BR>---" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==9)     //cleantech investment companies
                {
                        $addVCFlagqry = " ";
                        $pagetitle="CleanTech-backed Companies";
                        $dbtype="CT";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                        stage AS s ,peinvestments_dbtypes as pedb
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";
                        //echo"<BR>---" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==10)     //Infrastructure investment companies
                {
                        $addVCFlagqry = " ";
                        $pagetitle="Infrastructure-backed Companies";
                        $dbtype="IF";

                        $getcompaniesSql="SELECT DISTINCT pec.sector_business
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                        stage AS s ,peinvestments_dbtypes as pedb
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.sector_business";
                        //echo"<BR>---" .$getcompaniesSql;
                }
                 elseif($showallcompInvFlag==11) //PMS Companies
                {
                    $addVCFlagqry="";
                    $pagetitle="VC-Exits M&A Companies";

                    $getcompaniesSql="SELECT DISTINCT pec.sector_business
                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId AND pec.sector_business LIKE '".$search."%'  " .$addVCFlagqry. "
                    ORDER BY pec.sector_business";
                        //echo "<br>--" .$getcompaniesSql;
                }
                return $getcompaniesSql;
        }
                
                        
mysql_close();
    mysql_close($cnx);
    ?>
