<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$select_type = $_REQUEST['select_type'];
$VCFlagValue=$_REQUEST['vcflag'];
$search=$_REQUEST['search'];
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{
if($select_type == 'investor'){
        
        if(($VCFlagValue=="0" || $VCFlagValue=="1") && trim(search)!="" )
        {
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        $addVCFlagqry="";    
        $getInvestorSql=getPESql_investor($VCFlagValue,$search);
        $jsonarray=array();
        if ($rsinvestors = mysql_query($getInvestorSql)){
               $investor_cnt = mysql_num_rows($rsinvestors);
        }
        if($investor_cnt >0){
            
             While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                    $Investorname=trim($myrow["Investor"]);
                                    $Investorname=strtolower($Investorname);

                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);

                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
                                            $investor = $myrow["Investor"];
                                            $investorId = $myrow["InvestorId"];
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearch'])==trim($investor)) ? 'SELECTED' : '';
                                            
                                            $jsonarray[]=array('id'=>$investorId,'name'=>$investor);
                                            //echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
                                    }
            }
         
                    mysql_free_result($rsinvestors);
            }
            echo json_encode($jsonarray);
        }
        else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==7 || $VCFlagValue==8 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11 || $VCFlagValue=='0-2'|| $VCFlagValue=='0-0'|| $VCFlagValue=='0-1'|| $VCFlagValue=='1-0'|| $VCFlagValue=='1-1'){
            
            $showallcompInvFlag=$_REQUEST['showallcompInvFlag'];
            $searchString="Undisclosed";
            $searchString=strtolower($searchString);

            $searchString1="Unknown";
            $searchString1=strtolower($searchString1);

            $searchString2="Others";
            $searchString2=strtolower($searchString2);
            $getInvestorSql=getSVSql_investor($showallcompInvFlag,$VCFlagValue,$search);
            $jsonarray=array();
            if ($rsinvestors = mysql_query($getInvestorSql)){
               $investor_cnt = mysql_num_rows($rsinvestors);
            }
			
            if($investor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investorname=trim($myrow["Investor"]);
					$Investorname=strtolower($Investorname);

					$invResult=substr_count($Investorname,$searchString);
					$invResult1=substr_count($Investorname,$searchString1);
					$invResult2=substr_count($Investorname,$searchString2);
					
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
						$investor = $myrow["Investor"];
						$investorId = $myrow["InvestorId"];
                                                $jsonarray[]=array('id'=>$investorId,'name'=>$investor);
					}
            	}
         		
        	}
            echo json_encode($jsonarray);
        }   
        
}else if($select_type == 'company'){
    
         $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        if(($VCFlagValue=="0" || $VCFlagValue=="1") && trim(search)!="" )
        {
            
       
        $addVCFlagqry="";    
        $getcompaniesSql=getPESql_company($VCFlagValue,$search);
        $jsonarray=array();
        
        
        if ($rsinvestors = mysql_query($getcompaniesSql))
            {
                    While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                    {
                            $companyname=trim($myrow["companyname"]);
                            $companyname=strtolower($companyname);

                             $invResult=substr_count($companyname,$searchString);
                            $invResult1=substr_count($companyname,$searchString1);
                            $invResult2=substr_count($companyname,$searchString2);

                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                            {
                                    $compName = $myrow["companyname"];
                                    $compId= $myrow["PECompanyId"];
                                  
                                    $jsonarray[]=array('id'=>$compId,'name'=>$compName);
                                    //$totalCount=$totalCount+1;
                            }

                    }
            }
            echo json_encode($jsonarray);
            
        }
         else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==7 || $VCFlagValue==8 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11 || $VCFlagValue=='0-2'|| $VCFlagValue=='0-0'|| $VCFlagValue=='0-1'|| $VCFlagValue=='1-0'|| $VCFlagValue=='1-1'){
            
            $showallcompInvFlag=$_REQUEST['showallcompInvFlag'];
            $getcompaniesSql=getSVSql_company($showallcompInvFlag,$search);
            $jsonarray=array();
            if($rsinvestors = mysql_query($getcompaniesSql))
            {
                    While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                    {
                            $companyname=trim($myrow["companyname"]);
                            $companyname=strtolower($companyname);

                            $invResult=substr_count($companyname,$searchString);
                            $invResult1=substr_count($companyname,$searchString1);
                            $invResult2=substr_count($companyname,$searchString2);

                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                            {
                                    $compName = $myrow["companyname"];
                                    $compId= $myrow["PECompanyId"];
                                    $jsonarray[]=array('id'=>$compId,'name'=>$compName);
                            }

                    }
            }
           echo json_encode($jsonarray);
             
         }
}else if($select_type == 'sector'){
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
            $getcompaniesSql=getPESql_sector($VCFlagValue,$search);
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
                                                $jsonarray[] = array('id' => $sectorName, 'name' => $sectorName);


                                }
                        }
                }
                echo json_encode($jsonarray);

            }
            else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==7 || $VCFlagValue==8 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11 || $VCFlagValue=='0-2'|| $VCFlagValue=='0-0'|| $VCFlagValue=='0-1'|| $VCFlagValue=='1-0'|| $VCFlagValue=='1-1'){
                        
                        $showallcompInvFlag=$_REQUEST['showallcompInvFlag']; 
                        $getcompaniesSql=getSVSql_sector($showallcompInvFlag,$search);
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
                                                $jsonarray[] = array('id' => $sectorName, 'name' => $sectorName);


                                        }
				}
			}
                        echo json_encode($jsonarray);


            }
        
        
        
}else if($select_type == 'legal_advisor' || $select_type == 'transaction_advisor'){
    
        $type=$_REQUEST['type'];
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);
        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        
        if(($VCFlagValue=="0" || $VCFlagValue=="1") && trim(search)!="" )
        {
            
            
            $addVCFlagqry="";    
            $advisorsql=getPESql_advisor($VCFlagValue,$search,$type);
            $jsonarray=array();

            if ($rsadvisor = mysql_query($advisorsql))
            {
             
                While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                                   $adviosrname=trim($myrow["Cianame"]);
                                   $adviosrname=strtolower($adviosrname);

                                   $invResult=substr_count($adviosrname,$searchString);
                                   $invResult1=substr_count($adviosrname,$searchString1);
                                   $invResult2=substr_count($adviosrname,$searchString2);

                                   if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
                                           $ladvisor = $myrow["Cianame"];
                                           $ladvisorid = $myrow["CIAId"];
                                           //echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
                                             $jsonarray[]=array('id'=>$ladvisorid,'name'=>$ladvisor);
                                   }
               }
            }
            echo json_encode($jsonarray);
        }
         else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11 || $VCFlagValue=='0-2'|| $VCFlagValue=='0-0'|| $VCFlagValue=='0-1'|| $VCFlagValue=='1-0'|| $VCFlagValue=='1-1' ){
              $peorvcflg=$_REQUEST['peorvcflg'];
              $advisorsql= getAllAdvisor_advisor($type,$peorvcflg,$VCFlagValue,$search);
              $jsonarray=array();
              if ($rsadvisor = mysql_query($advisorsql)){
                        $advisor_cnt = mysql_num_rows($rsadvisor);
              }
              
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
                                $jsonarray[]=array('id'=>$ladvisorid,'name'=>$ladvisor);
                        }
            	}
        	}
                  echo json_encode($jsonarray);

          }
      
}
}

        
        
        function getPESql_investor($VCFlagValue,$search)
        {
        
        if($VCFlagValue==0)
        {
                $addVCFlagqry="";
                $pagetitle="PE Investors";
        }
        elseif($VCFlagValue==1)
        {
                //$addVCFlagqry="";
                $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                $pagetitle="VC Investors";
        }
        $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
        FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
        WHERE pe.PECompanyId = pec.PEcompanyId
        AND s.StageId = pe.StageId
        AND pec.industry !=15
        AND peinv.PEId = pe.PEId
        AND inv.InvestorId = peinv.InvestorId
        AND pe.Deleted=0 " .$addVCFlagqry. " AND inv.Investor LIKE '".$search."%' order by inv.Investor ";
        return $getInvestorSql;
        }  
        
        function getPESql_company($VCFlagValue,$search)
        {

            $addVCFlagqry="";
            //0- pecompanies,1-vccompanies
            if($VCFlagValue==0)
            {
                    $addVCFlagqry="";
                    $pagetitle="PE-backed Companies";

                    $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                    WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND (r.RegionId = pec.RegionId OR r.RegionId =1)  AND pec.companyname LIKE '".$search."%' " .$addVCFlagqry. "
                                    GROUP BY pe.PECompanyId ORDER BY pec.companyname";

            }
            elseif($VCFlagValue==1)
            {
                    $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                    $pagetitle="VC-backed Companies";

                    $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                    WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId AND pec.companyname LIKE '".$search."%' " .$addVCFlagqry. "
                                    ORDER BY pec.companyname";
            } 
            return $getcompaniesSql;
        }
        
        function getSVSql_company($showallcompInvFlag,$search)
        {
                $addVCFlagqry="";
                if($showallcompInvFlag==0)
                {
                        $addVCFlagqry="";
                        $pagetitle="PE-backed Companies";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";

                }
                elseif($showallcompInvFlag==1)
                {
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        $pagetitle="VC-backed Companies";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                }
                elseif($showallcompInvFlag==2) // Incubatees
                        {
                        $addVCFlagqry="";
                        $pagetitle="Incubatee(s)";
                        $getcompaniesSql="SELECT DISTINCT pe.IncubateeId, pec. *
                        FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                        WHERE pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                         and pe.Deleted=0 and pec.industry!=15
                        ORDER BY pec.companyname";
                        }
                elseif($showallcompInvFlag==3) //PE_ipos
                {
                        $addVCFlagqry="";
                        $pagetitle="PE-backed IPO Companies";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                        WHERE pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==4) //VC-ipos
                {
                        $addVCFlagqry="and VCFlag=1";
                        $pagetitle="VC-backed IPO Companies";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                        WHERE pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==5) //PE-EXits M&A Companies
                {
                        $addVCFlagqry="";
                        $pagetitle="PE-Exits M&A Companies";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                        FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                        WHERE pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==6) //VC-EXits M&A Companies
                {
                    $addVCFlagqry="and VCFlag=1";
                    $pagetitle="VC-Exits M&A Companies";

                    $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                    ORDER BY pec.companyname";
                        //echo "<br>--" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==7) //Angel Companies
                {
                    $addVCFlagqry="";
                    $pagetitle="Angel-backed Companies";
                    $getcompaniesSql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                    FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                    WHERE pec.PECompanyId = pe.InvesteeId 
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                    ORDER BY pec.companyname";
                //	echo "<br>--" .$getcompaniesSql;

                }
                elseif($showallcompInvFlag==8)     //social venture investment companies
                {
                        $addVCFlagqry = " ";
                        $pagetitle="SV-backed Companies";
                        $dbtype="SV";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                        stage AS s ,peinvestments_dbtypes as pedb
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId   AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                        //echo"<BR>---" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==9)     //cleantech investment companies
                {
                        $addVCFlagqry = " ";
                        $pagetitle="CleanTech-backed Companies";
                        $dbtype="CT";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                        stage AS s ,peinvestments_dbtypes as pedb
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                        //echo"<BR>---" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==10)     //Infrastructure investment companies
                {
                        $addVCFlagqry = " ";
                        $pagetitle="Infrastructure-backed Companies";
                        $dbtype="IF";

                        $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                        stage AS s ,peinvestments_dbtypes as pedb
                                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                        AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                        ORDER BY pec.companyname";
                        //echo"<BR>---" .$getcompaniesSql;
                }
                elseif($showallcompInvFlag==11) //public market
                {
                    $addVCFlagqry="";
                    $pagetitle="VC-Exits M&A Companies";

                    $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                    WHERE pec.PECompanyId = pe.PEcompanyId 
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId  AND pec.companyname LIKE '".$search."%'  " .$addVCFlagqry. "
                    ORDER BY pec.companyname";
                        //echo "<br>--" .$getcompaniesSql;
                }
                return $getcompaniesSql;
        }
        function getPESql_sector($VCFlagValue,$search)
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
        
        
        function getSVSql_sector($showallcompInvFlag,$search)
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
        function getPESql_advisor($VCFlagValue,$search,$type)
        {
            if($VCFlagValue==0)
            {
                    $addVCFlagqry="";
                    $pagetitle="PE Advisors - ".$adtitledisplay;
            }
            elseif($VCFlagValue==1)
            {
                    //$addVCFlagqry="";
                    $addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
                    $pagetitle="VC Advisors - ".$adtitledisplay;
            }
            $advisorsql="(
                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                            peinvestments_advisorinvestors AS adac, stage as s
                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                            " AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID and AdvisorType='".$type."'
                            AND adac.PEId = peinv.PEId  AND cia.Cianame LIKE '".$search."%')
                            UNION (
                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                            FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                            peinvestments_advisorcompanies AS adac, stage as s
                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                            " AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID and AdvisorType='".$type."'
                            AND adac.PEId = peinv.PEId AND cia.Cianame LIKE '".$search."%' ) order by Cianame	";
            
            return $advisorsql;
        }
        function getSVSql_investor($showallcompInvFlag,$VCFlagValue,$search)
        {
            
                $addVCFlagqry=$getInvestorSql="";
                if($showallcompInvFlag==3) 
		{
		    
                    if($vcflagValue==7)
                    {
                            $addVCFlagqry="";
                            $pagetitle="PE Backed IPOs - Investors";
                    }
                    
                     $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%' order by inv.Investor ";
		}
                if($showallcompInvFlag==4) 
		{
		    
                    if($vcflagValue==8)
                    {
                            $addVCFlagqry = " and VCFlag=1 ";
                            $pagetitle="VC Backed IPOs - Investors";
                    }
                    
                    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%' order by inv.Investor ";
		}
                if($showallcompInvFlag==5) 
		{
		    
                    if($VCFlagValue==10)
                    {
                        $addVCFlagqry="";
                        $pagetitle="PE Exits M&A - Investors";
                    }
                    
                    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%'  order by inv.Investor";
		}
                if($showallcompInvFlag==6)  
		{
                
                    if($VCFlagValue==11)
                    {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $pagetitle="VC Exits M&A - Investors";
                    }
                    
              	   $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%'  order by inv.Investor";
		}
                if($showallcompInvFlag==8)  //Social Venture Investments investors
		{
		    if($VCFlagValue==3)
		    {
			$addVCFlagqry = "";
			$dbtype="SV";
			$pagetitle="Social Venture Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$search."%' " .$addVCFlagqry. " order by inv.Investor ";
		}
		if($showallcompInvFlag==9)  //CleanTech Investments investors
		{
		    if($VCFlagValue==4)
		    {
			$addVCFlagqry = "";
			$dbtype="CT";
			$pagetitle="CleanTech Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$search."%' " .$addVCFlagqry. " order by inv.Investor ";
		}
                if($showallcompInvFlag==10)  //Social Venture Investments investors
		{
		    if($VCFlagValue==5)
		    {
			$addVCFlagqry = "";
			$dbtype="IF";
			$pagetitle="Infrastructure Investments - Investors";
		    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, 
                                stage AS s,peinvestments_dbtypes as pedb
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND pe.Deleted=0 AND inv.Investor LIKE '".$search."%' " .$addVCFlagqry. " order by inv.Investor ";
		}
                
                if($showallcompInvFlag==11) 
		{
		   
                    if($VCFlagValue==9)
                    {
                        $addVCFlagqry = "";
                        $pagetitle="PMS - Investors";
                    }
              	    $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '".$search."%'  order by inv.Investor";
		}
                return $getInvestorSql;
        }
        
      function getAllAdvisor_advisor($adtype,$peorvcflg,$VCFlagValue,$search) 
    {
                if($adtype=="L")
		{  
                    $adtitledisplay ="Legal";
                }
		elseif($adtype=="T")
                {  
                    $adtitledisplay="Transaction";
                }
                
                $addVCFlagqry="";
		//0- peinvestors,1-vcinvestors in the second parameter
 	    if($peorvcflg==1) //investment page
		{
			if($VCFlagValue==0)
			{
				$addVCFlagqry="";
				$pagetitle="PE Advisors - ".$adtitledisplay;
			}
			elseif($VCFlagValue==1)
			{
				//$addVCFlagqry="";
				$addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
				$pagetitle="VC Advisors - ".$adtitledisplay;
			}
			$advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId and cia.Cianame LIKE '".$search."%' )
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId and cia.Cianame LIKE '".$search."%'  ) order by Cianame	";
			//echo "<Br>PE - VC---" .$advisorsql;
		}

		if($peorvcflg==4) //manda
		{
			if($VCFlagValue==9)
                        {
                                $addVCFlagqry = "";
                                $pagetitle="PMS - Investors";
                        }
                        else if($VCFlagValue==10)
                        {
                                $addVCFlagqry="";
                                $pagetitle="PE Exits M&A - Investors";
                        }
                        elseif($VCFlagValue==11)
                        {
                                $addVCFlagqry = " and VCFlag=1 ";
                                $pagetitle="VC Exits M&A - Investors";
                        }
			$advisorsql="(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
					AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
					" and cia.Cianame LIKE '".$search."%'  )
					UNION (
					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
					AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
					" and cia.Cianame LIKE '".$search."%'  )	ORDER BY Cianame";
			//echo "<Br>M&A---" .$advisorsql;
                        }
                	if($peorvcflg==3) //social /cleantech / infrastructure investment page
		        {
        			if($VCFlagValue==3)
        			{
        				//$addVCFlagqry="";
        				$addVCFlagqry = "";
        				$pagetitle="Social Venture Investments-Advisors - ".$adtitledisplay;
        				$dbtype="SV";
        			}
        			elseif($VCFlagValue==4)
        			{
        				//$addVCFlagqry="";
        				$addVCFlagqry = "";
        				$pagetitle="CleanTech Investments-Advisors - ".$adtitledisplay;
        				$dbtype="CT";
        			}
        			elseif($VCFlagValue==5)
        			{
        				//$addVCFlagqry="";
        				$addVCFlagqry = "";
        				$pagetitle="Infrastructure Investments-Advisors - ".$adtitledisplay;
        				$dbtype="IF";
        			}
        			$advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId and cia.Cianame LIKE '".$search."%' )
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId and cia.Cianame LIKE '".$search."%'  ) order by Cianame";
			//echo "<Br>PE - VC---" .$advisorsql;
		      }
                // echo "<bR>--" .$peorvcflag[1];
		 if($peorvcflg==2) //mama
		{
			if($VCFlagValue==9)
                        {
                                $addVCFlagqry = "";
                                $pagetitle="PMS - Investors";
                        }
                        else if($VCFlagValue==10)
                        {
                                $addVCFlagqry="";
                                $pagetitle="PE Exits M&A - Investors";
                        }
                        elseif($VCFlagValue==11)
                        {
                                $addVCFlagqry = " and VCFlag=1 ";
                                $pagetitle="VC Exits M&A - Investors";
                        }
			$advisorsql="(
					SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
					AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
					" and cia.Cianame LIKE '".$search."%'  )
					UNION (
					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
					AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
					"  and cia.Cianame LIKE '".$search."%'  )	ORDER BY Cianame";
			//echo "<Br>M&A---" .$advisorsql;
		}
                //echo "<Br>M&A---" .$advisorsql;
                return $advisorsql;
    
    }
    
                        
?>
