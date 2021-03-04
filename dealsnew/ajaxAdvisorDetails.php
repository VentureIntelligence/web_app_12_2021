<?php

        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $VCFlagValue=$_REQUEST['vcflag'];
        $search=$_REQUEST['search'];
        $type=$_REQUEST['type'];
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);
        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        if(!isset($_SESSION['UserNames']))
        {
                header('Location:../pelogin.php');
        }
        else
        {
        if(($VCFlagValue=="0" || $VCFlagValue=="1") && trim(search)!="" )
        {
            
            
            $addVCFlagqry="";    
            $advisorsql=getPESql($VCFlagValue,$search,$type);
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
                                             $jsonarray[]=array('id'=>$ladvisorid,'label'=>$ladvisor,'value'=>$ladvisor);
                                   }
               }
            }
            echo json_encode($jsonarray);
        }
         else if($VCFlagValue==3 || $VCFlagValue==4 || $VCFlagValue==5 || $VCFlagValue==9 || $VCFlagValue==10 || $VCFlagValue==11){
              $peorvcflg=$_REQUEST['peorvcflg'];
              $advisorsql= getAllAdvisor($type,$peorvcflg,$VCFlagValue,$search);
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
                                $jsonarray[]=array('id'=>$ladvisorid,'label'=>$ladvisor,'value'=>$ladvisor);
                        }
            	}
        	}
                  echo json_encode($jsonarray);

          }
        
        }
        
        
        function getPESql($VCFlagValue,$search,$type)
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
      
      function getAllAdvisor($adtype,$peorvcflg,$VCFlagValue,$search) 
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
                        
mysql_close();
    mysql_close($cnx);
    ?>
