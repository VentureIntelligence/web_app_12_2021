<?php include_once("../globalconfig.php"); ?>
<?php
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        if(!isset($_SESSION['UserNames']))
        {
        header('Location:../pelogin.php');
        }
        else
        {	
       // print_r($_POST);
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] :0;
        //$dealvalue = isset($_POST['showdeals']) ? $_POST['showdeals'] :101;
        if($resetfield=="autocomplete")
        { 
         $_POST['autocomplete']="";
         $dirsearch="";
        }
        else 
        {
         $dirsearch=trim($_POST['autocomplete']);
        }
        if($_REQUEST['sv'] =='')
        {
            if($_POST['autocomplete'] != '')
            {
               $_POST['showdeals'] ='';
            }
            if($_POST['showdeals'] != '')
            {
                $dealvalue = $_POST['showdeals'];
            }
            else {
                     $dealvalue = isset($_REQUEST['showvalue']) ? $_REQUEST['showvalue']:101; 
            }
        }
        else         
        {
        $dealvalue= isset($_REQUEST['sv']) ? $_REQUEST['sv'] : 101;
        }
        if ($vcflagValue==0)
        {
                $videalPageName="PEDir";
                $defvalue=41;
        }
        else if ($vcflagValue==1)
        {
                $videalPageName="VCDir";
                $defvalue=42;
        }
			
        include('checklogin.php');
        
        $search= isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
        $totalCount=0;

        $resetfield=$_POST['resetfield'];
        if($resetfield=="keywordsearch")
        { 
        $_POST['keywordsearch']="";
        $keyword="";
        }
        else 
        {
        $keyword=trim($_POST['keywordsearch']);
        }

         if($resetfield=="industry")
        { 
         $_POST['industry']="";
         $industry="";
        }
        else 
        {
         $industry=trim($_POST['industry']);
        }
         if($resetfield=="stage")
            { 
             $_POST['stage']="";
             $stageval="";
            }
            else 
            {
             $stageval=$_POST['stage'];
            }
           
            if($_POST['stage'] && $stageval!="")
            {
                    $boolStage=true;
            }
            else
            {
                    $stage="--";
                    $boolStage=false;
            }
            if($resetfield=="invType")
            { 
             $_POST['invType']="";
             $investorType="";
            }
            else 
            {
             $investorType=trim($_POST['invType']);
            }            
             if($resetfield=="range")
            { 
            $_POST['invrangestart']="";
            $_POST['invrangeend']="";
            $startRangeValue="--";
            $endRangeValue="--";
            $regionId="";
            }
            else 
            {
             $startRangeValue=$_POST['invrangestart'];
             $endRangeValue=$_POST['invrangeend'];
            }
            $endRangeValueDisplay =$endRangeValue;
            $whereind="";
            $whereinvType="";
            $wherestage="";
            $wheredates="";
            $whererange="";
         
               if($resetfield=="searchallfield")
               { 
                $_POST['searchallfield']="";
                $searchallfield="";
               }
               else 
               {
                $searchallfield=trim($_POST['searchallfield']);
               }
               
                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);
 
		if($industry >0)
                {
                        $industrysql= "select industry from industry where IndustryId=$industry";
                        if ($industryrs = mysql_query($industrysql))
                        {
                                While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                {
                                        $industryvalue=$myrow["industry"];
                                }
                        }
                }

		if($boolStage==true)
		{
			foreach($stageval as $stageid)
			{
				$stagesql= "select Stage from stage where StageId=$stageid";
			//	echo "<br>**".$stagesql;
				if ($stagers = mysql_query($stagesql))
				{
					While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
					{
						$stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
					}
				}
			}
			$stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
		}
		else
                {
			$stagevaluetext="";
			
                        if($investorType !="")
                        {
                                $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
                                if ($invrs = mysql_query($invTypeSql))
                                {
                                        While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
                                        {
                                                $invtypevalue=$myrow["InvestorTypeName"];
                                        }
                                }
			}
                }
		//echo "<br>*************".$stagevaluetext;
		if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";

                if($investorType !="")
                {
                        $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
                        if ($invrs = mysql_query($invTypeSql))
                        {
                                While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
                                {
                                        $invtypevalue=$myrow["InvestorTypeName"];
                                }
                        }
                }

		if($regionId >0)
		{
			$regionSql= "select Region from region where RegionId=$regionId";
                        if ($regionrs = mysql_query($regionSql))
                        {
                                While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                                {
                                        $regionvalue=$myregionrow["Region"];
                                }
                        }
		}

                if($search !='')
                {
                    if($dealvalue ==101)
                    {
                        $search=" and Investor like '$search%'";
                    }
                    else if($dealvalue ==102)
                    {
                        $search=" and  pec.companyname like '$search%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $search=" and  cia.Cianame like '$search%'";
                    }
                }
                if($dirsearch !='')
                {
                    if($dealvalue ==101)
                    {
                        $dirsearchall=" and Investor like '$dirsearch%'";
                    }
                    else if($dealvalue ==102)
                    {
                        $dirsearchall=" and  pec.companyname like '$dirsearch%'";
                    }
                    else if($dealvalue ==103 || $dealvalue ==104)
                    {
                        $dirsearchall=" and  cia.Cianame like '$dirsearch%'";
                    }
                }
                
                if($vcflagValue==0)
                {
                        $addVCFlagqry="";
                        $pagetitle="PE Investors";
                }
                elseif($vcflagValue==1)
                {
                        //$addVCFlagqry="";
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        $pagetitle="VC Investors";
                }
                else if($vcflagValue==2)
                {
                       $addVCFlagqry="";
			$pagetitle="Angel Investments - Investors";
                }
                elseif($vcflagValue==3)
                {
                        $addVCFlagqry = "";
			$dbtype="SV";
			$pagetitle="Social Venture Investments - Investors";
                }
                else if($vcflagValue==4)
                {
                        $addVCFlagqry = "";
			$dbtype="CT";
			$pagetitle="CleanTech Investments - Investors";
                }
                elseif($vcflagValue==5)
                {
                        $addVCFlagqry = "";
			$dbtype="IF";
			$pagetitle="Infrastructure Investments - Investors";
                }
                elseif($vcflagValue==7)
                {
                        $addVCFlagqry="";
			$pagetitle="PE Backed IPOs - Investors";
                }
                else if($vcflagValue==8)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
                        $pagetitle="VC Backed IPOs - Investors";
                }
                else if($vcflagValue==9)
                {
                        $addVCFlagqry = "";
                        $pagetitle="PMS - Investors";
                }
                else if($vcflagValue==10)
                {
                        $addVCFlagqry="";
                        $pagetitle="PE Exits M&A - Investors";
                }
                elseif($vcflagValue==11)
                {
                        $addVCFlagqry = " and VCFlag=1 ";
			$pagetitle="VC Exits M&A - Investors";
                }
                if($dealvalue == 103)
                {
                    $adtype = "L";
                }
                else
                {
                    $adtype = "T";
                }
                
                if($vcflagValue==0 || $vcflagValue==1)
                {
                       if($dealvalue==101)
                       {
                            if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                            $showallsql = "select distinct peinv.InvestorId,inv.Investor
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15 and
                                pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                        
                                //echo $showallsql;
                            }
                                
                       }
                       elseif($dealvalue==102)
                       {
                          $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                        ORDER BY pec.companyname";
                          
                          //echo $showallsql;
                       }
                       else if($dealvalue==103 || $dealvalue==104)
                       {
                            
                           $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
				AND adac.PEId = pe.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s
				WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
				AND adac.PEId = pe.PEId ) order by Cianame	";
                           //echo $showallsql;
                           
                       }
                }
                else if($vcflagValue==2)
                {
                       if($dealvalue==101)
                       {
                           if($keyword!="")
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall." order by inv.Investor ";
                            }
                       }
                       else if($dealvalue==102)
                       {
                            $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.InvesteeId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                        ORDER BY pec.companyname";
                       }
                }
                elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                {
                       if($dealvalue==101)
                       {
                           if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                              $showallsql = "select distinct peinv.InvestorId,inv.Investor
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                            }
                       }
                        else if($dealvalue==102)
                       {
                       
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                            ORDER BY pec.companyname";
                         }
                        else if($dealvalue==103 || $dealvalue==104)
                       {
                            $showallsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
				" AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
				AND adac.PEId = peinv.PEId ) order by Cianame";
                            //echo $showallsql;
                        }
                }
                elseif($vcflagValue==7 || $vcflagValue==8)
                {
                        if($dealvalue==101)
                       {
                            
                            if($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                            }
                            else
                            {
                             $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                       }
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                            }
                               // echo $showallsql;
                            
                       }
                       else if($dealvalue==102)
                       {
                          $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
				FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
				WHERE pec.PECompanyId = pe.PEcompanyId 
				AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
				AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall." 
				ORDER BY pec.companyname";
                       
                         }
                }
                
                else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                {
                         if($dealvalue==101)
                       {
                            if($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor";
                            }
                            else
                            {
                              $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor
							FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv WHERE ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                       }
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
							AND pec.industry !=15
							AND peinv.MandAId = pe.MandAId
							AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";  
                                
                                //echo $showallsql;
                            }
                       }
                       else if($dealvalue==102)
                       {
                       
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
			    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
			    WHERE pec.PECompanyId = pe.PEcompanyId 
			    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
			    AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall." 
			    ORDER BY pec.companyname";
                         }
                        else if($dealvalue==103 || $dealvalue==104)
                        {
                              $showallsql="(
                                         SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                         AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )
                                         UNION (
                                         SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                                         FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
                                         WHERE Deleted =0
                                         AND c.PECompanyId = peinv.PECompanyId
                                         AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                         AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                         " )	ORDER BY Cianame";
                        }
                }
               
	$topNav = 'Directory';
        $defpage=$defvalue;
        $stagedef=1;
	include_once('dirnew_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<?php if($dealvalue==101 && $vcflagValue !=2)
{
    ?>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('newdirrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>	
</div>

</td>
 <?php
}
			$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}

			
                            $totalDisplay="Total";
                            $industryAdded ="";
                            $totalAmount=0.0;
                            $totalInv=0;
                            $compDisplayOboldTag="";
                            $compDisplayEboldTag="";
                   
                            if ($rsinvestor = mysql_query($showallsql))
                            {
                                 $investor_cnt = mysql_num_rows($rsinvestor);
                            }
                            if($investor_cnt > 0)
                            {
                                         //$searchTitle=" List of Deals";
                            }
                            else
                            {
                                 $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
                                 $notable=true;
                                 writeSql_for_no_records($companysql,$emailid);
                            }


		           ?>


<td class="profile-view-left" style="width:100%;">
<div class="result-cnt">
<?php if ($accesserror==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php" target="_blank">Click here</a></b></div>
        <?php
        exit; 
        } 
        ?>  
<div class="result-title result-title-nofix"> 
    
                                            
                        	<?php if(!$_POST){
                                    ?>
                                      
                                  <?php  if($vcflagValue==0)
                                   {
                                     ?>    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           <span class="result-for">for PE Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                              <?php }
                                    else if($vcflagValue==1)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for VC Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                                else if($vcflagValue==2)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Angel Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==3)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Social Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==4)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Cleantech Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==5)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Infrastructure Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==7)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for IPO(PE) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==8)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for IPO(VC) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==9)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for PMS Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==10)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for M&A(PE) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==11)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for M&A(VC) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                              ?>
                                    <div class="title-links " id="exportbtn"></div>
                                    <?php
                                   }
                                   else 
                                   {
                                   if($vcflagValue==0)
                                   {
                                     ?>    <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                           <span class="result-for">for PE Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                           </h2>
    
                              <?php }
                                    else if($vcflagValue==1)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for VC Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php }
                                else if($vcflagValue==2)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Angel Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==3)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Social Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==4)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Cleantech Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==5)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for Infrastructure Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              else if($vcflagValue==7)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for IPO(PE) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==8)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for IPO(VC) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==9)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for PMS Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==10)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for M&A(PE) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                               else if($vcflagValue==11)
                                        {?> <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo $investor_cnt; ?> Results found</span>
                                            <span class="result-for">for M&A(VC) Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                            </h2>
                              <?php } 
                              ?>
                             <div class="title-links " id="exportbtn"></div>
                             <ul class="result-select">
                                <?php
                               if($industry >0 && $industry!=null){ ?>
                                <li title="Industry">
                                    <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId>0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($datevalueDisplay1!=""){ ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('year1');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($dirsearch!="") { ?>
                                <li> 
                                    <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                               $_POST['resetfield']="";
                                foreach($_POST as $value => $link) 
                                { 
                                    if($link == "" || $link == "--" || $link == " ") 
                                    { 
                                        unset($_POST[$value]); 
                                    } 
                                }
                                //print_r($_POST);
                                $cl_count = count($_POST);
                                if($cl_count > 4)
                                {
                                ?>
                                <li class="result-select-close"><a href="directorynew.php?value=<?php echo $vcflagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                             </ul>
                             <?php } ?>
                                            
                        </div>
                      	
                        <?php
                        if($notable==false)
                        { 
                        ?>
                       <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"  href="directorynew.php?value=<?php echo $_GET['value'];?>"  id="icon-grid-view"><i></i> List  View</a></li>
                         <?php
                            $count=0;
                             While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                            {
                                    if($count == 0)
                                    {
                                             $comid = $myrow["InvestorId"];
                                            $count++;
                                    }
                            }
                        ?>
                        <li><a id="icon-detailed-view" class="postlink" href="dirdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detail  View</a></li> 
                        </ul></div>
				<?php  $rowlimit=25;
                                $offset=0;
                                $i=1;
                                $j=1;
                                $newrowflag=1;
                                $newcolumnflag=1;
                                $columncount=1;
                                 $columnlimit=4;?>

       
        <div class="directory-cnt"> 
        <div class="search-area">
             <input type="hidden" name="showvalue" value="<?php echo $dealvalue?>"> 
<input type="text" id="autocomplete"  name="autocomplete" type="text" placeholder="Directory Search"  value="">
<script>
$( "#autocomplete" ).autocomplete({
   // source: [ 'c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby' ]
   source: [<?php
            /* populating the investortype from the investortype table */
		$searchStrings="Undisclosed";
			$searchStrings=strtolower($searchStrings);
		
			$searchStrings1="Unknown";
			$searchStrings1=strtolower($searchStrings1);
		
			$searchStrings2="Others";
			$searchStrings2=strtolower($searchStrings2);
		if($dealvalue==101)	
                {
                        if($vcflagValue==2)
                        {
                             $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor
                                                FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                                WHERE pe.InvesteeId = pec.PEcompanyId
                                                AND pec.industry !=15
                                                AND peinv.AngelDealId = pe.AngelDealId
                                                AND inv.InvestorId = peinv.InvestorId
                                                AND pe.Deleted=0 order by inv.Investor ";
                        }
                        else if($vcflagValue==7 || $vcflagValue==8)
                        {
                             $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
				FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND pec.industry !=15
				AND peinv.IPOId = pe.IPOId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 order by inv.Investor ";
                          
                        }
                        else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                              $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                        }
                        else {
                              $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor,pec.sector_business
				FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
				WHERE pe.PECompanyId = pec.PEcompanyId
				AND s.StageId = pe.StageId
				AND pec.industry !=15
				AND peinv.PEId = pe.PEId
				AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 group by inv.Investor ";
                        }
                  
                        if ($rsinvestors = mysql_query($getInvestorSqls)){
                                $investors_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if($investors_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                             While($myrows=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                                    $Investornames=trim($myrows["Investor"]);
                                                    $Investornames=strtolower($Investornames);

                                                    $invResults=substr_count($Investornames,$searchStrings);
                                                    $invResults1=substr_count($Investornames,$searchStrings1);
                                                    $invResults2=substr_count($Investornames,$searchStrings2);

                                                    if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
                                                            $investors = $myrows["Investor"];
                                                            $investorsId = $myrows["InvestorId"];
                                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($investors)) ? 'SELECTED' : '';
                                                            echo "'".$investors."',";
                                                    }
                            }
                    }
                }
                else if($dealvalue==102)
                {
                     if($vcflagValue==2)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                WHERE pec.PECompanyId = pe.InvesteeId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
                                ORDER BY pec.companyname";
                        }
                        else if($vcflagValue==7 || $vcflagValue==8)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
				FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
				WHERE pec.PECompanyId = pe.PEcompanyId 
				AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
				AND r.RegionId = pec.RegionId ORDER BY pec.companyname";
                          
                        }
                        else if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                            $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                                WHERE pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId ORDER BY pec.companyname";
                        }
                        else {
                             $getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId ORDER BY pec.companyname";
                        }
                  
                        if ($rsinvestors = mysql_query($getcompaniesSql)){
                                $companies_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if( $companies_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $companies = $myrow["companyname"] ;
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($companies)) ? 'SELECTED' : '';
                                            echo "'".$companies."',";
                                        }
                                }                          
                    }
                }
                else if($dealvalue==103 || $dealvalue==104)
                {                     
                    if($dealvalue==103)
                    {
                        $adtype="L";
                    }
                    else if($dealvalue==104)
                    {
                        $adtype="T";
                    }
                     
                        if($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                        {
                           $advisorsql="(
				SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId)
				UNION (
				SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
				FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
				WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
				AND adac.PEId = peinv.PEId ) order by Cianame";
                            //echo $advisorsql;
                        }
                        else {
                             $advisorsql="(
					SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
					AND adac.PEId = peinv.MandAId)
					UNION (
					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
					WHERE Deleted =0
					AND c.PECompanyId = peinv.PECompanyId
					AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
					AND adcomp.PEId = peinv.MandAId) ORDER BY Cianame";
                             
                             //echo $advisorsql;
                        }
                  
                        if ($rsinvestors = mysql_query($advisorsql)){
                                $advisor_cnts = mysql_num_rows($rsinvestors);
                        }
			
                        if($advisor_cnts >0){
                             mysql_data_seek($rsinvestor ,0);
                                While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                {
                                        $companyname=trim($myrow["Cianame"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            $advisors = $myrow["Cianame"] ;
                                            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                            $isselcted = (trim($_POST['keywordsearchmain'])==trim($advisors)) ? 'SELECTED' : '';
                                            echo "'".$advisors."',";
                                        }
                                }                          
                    }
                }
    ?>]
});
</script>
<input type="button" name="fliter_dir" value="" onclick="this.form.submit();" >
</div>
</form>
    <?php if($dealvalue==101)
    {
        ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportinvestorprofile1.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >    
            <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
            <input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
            <input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?>>
            <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
            <input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
            <input type="hidden" name="txthideindustryid" value="<?php echo $industry;?>" >
            <input type="hidden" name="txthidekeyword" value="<?php echo $keyword;?>" >
            <input type="hidden" name="txthidestageid" value="<?php echo $stageidvalue;?>" >
            <input type="hidden" name="txthiderange" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="txthiderangeEnd" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="txthideinvestorTypeid" value="<?php echo $investorType;?>" >
            <input type="hidden" name="hidepeipomandapage" value="4" >
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
       <?php
       }
       else if($dealvalue==102)
       {
       ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportcompaniesprofile.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >     
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <!--input type="hidden" name="searchvalue" value="<?php echo $vcflagValue;?>" -->
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <?php
    }
     else if($dealvalue==103 || $dealvalue==104)
       {
       ?>
            <form name="pegetdata" id="pegetdata"  method="post" action="exportadvisorsprofile.php" >
            <input type="hidden" name="txthidedv" value=<?php echo $dealvalue; ?> >     
            <!--input type="hidden" name="hidepeipomandapage" value="<?php echo $dealvalue;?>" -->
            <input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="hideadvisortype" value="<?php echo $adtype;?>" >
            <input type="hidden" name="hideShowAll" value="ShowAll" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
    <?php
    }
    ?>
<h3>Show by:</h3>
        <div class="show-by-list">
        <ul><li>
        <a href="directorynew.php?value=<?php echo $_GET['value']?>&sv=<?php echo $dealvalue;?>" class="postlink <?php if(!$_REQUEST['s']){?> active<?php } ?>" >All</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=a&sv=<?php echo $dealvalue;?>" class="postlink <?php if(a==$_REQUEST['s']){?> active<?php }?>">A</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=b&sv=<?php echo $dealvalue;?>" <?php if(b==$_REQUEST['s']){?>class="active" <?php }?>>B</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=c&sv=<?php echo $dealvalue;?>" class="postlink <?php if(c==$_REQUEST['s']){?> active<?php }?>">C</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=d&sv=<?php echo $dealvalue;?>" <?php if(d==$_REQUEST['s']){?>class="active" <?php }?>>D</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=e&sv=<?php echo $dealvalue;?>" class="postlink <?php if(e==$_REQUEST['s']){?> active<?php }?>">E</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=f&sv=<?php echo $dealvalue;?>" <?php if(f==$_REQUEST['s']){?>class="active" <?php }?>>F</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=g&sv=<?php echo $dealvalue;?>" class="postlink <?php if(g==$_REQUEST['s']){?> active<?php }?>">G</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=h&sv=<?php echo $dealvalue;?>" <?php if(h==$_REQUEST['s']){?>class="active" <?php }?>>H</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=i&sv=<?php echo $dealvalue;?>" class="postlink <?php if(i==$_REQUEST['s']){?> active<?php }?>">I</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=j&sv=<?php echo $dealvalue;?>" <?php if(j==$_REQUEST['s']){?>class="active" <?php }?>>J</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=k&sv=<?php echo $dealvalue;?>" class="postlink <?php if(k==$_REQUEST['s']){?> active<?php }?>">K</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=l&sv=<?php echo $dealvalue;?>" <?php if(l==$_REQUEST['s']){?>class="active" <?php }?>>L</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=m&sv=<?php echo $dealvalue;?>" class="postlink <?php if(m==$_REQUEST['s']){?> active<?php }?>">M</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=n&sv=<?php echo $dealvalue;?>" <?php if(n==$_REQUEST['s']){?>class="active" <?php }?>>N</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=o&sv=<?php echo $dealvalue;?>" class="postlink <?php if(o==$_REQUEST['s']){?> active<?php }?>">O</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=p&sv=<?php echo $dealvalue;?>" <?php if(p==$_REQUEST['s']){?>class="active" <?php }?>>P</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=q&sv=<?php echo $dealvalue;?>" class="postlink <?php if(q==$_REQUEST['s']){?> active<?php }?>">Q</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=r&sv=<?php echo $dealvalue;?>" <?php if(r==$_REQUEST['s']){?>class="active" <?php }?>>R</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=s&sv=<?php echo $dealvalue;?>" class="postlink <?php if(s==$_REQUEST['s']){?> active<?php }?>">S</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=t&sv=<?php echo $dealvalue;?>" <?php if(t==$_REQUEST['s']){?>class="active" <?php }?>>T</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=u&sv=<?php echo $dealvalue;?>" class="postlink <?php if(u==$_REQUEST['s']){?> active<?php }?>">U</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=v&sv=<?php echo $dealvalue;?>" <?php if(v==$_REQUEST['s']){?>class="active" <?php }?>>V</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=w&sv=<?php echo $dealvalue;?>" class="postlink <?php if(w==$_REQUEST['s']){?> active<?php }?>">W</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=x&sv=<?php echo $dealvalue;?>" <?php if(x==$_REQUEST['s']){?>class="active" <?php }?>>X</a></li>
    <li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=x&sv=<?php echo $dealvalue;?>" class="postlink <?php if(y==$_REQUEST['s']){?> active<?php }?>">Y</a></li><li><a href="directorynew.php?value=<?php echo $_GET['value']?>&s=z&sv=<?php echo $dealvalue;?>" <?php if(z==$_REQUEST['s']){?>class="active" <?php }?>>Z</a></li>
</ul></div>  
			<div class="list-view-table">
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTables">
                              <thead><tr>
                                      <?php
                                      if($vcflagValue == 0)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of PE Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 1)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of VC Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 2)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Angel Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Angel Companies</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 3)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Social Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 4)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of CleanTech Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 5)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Infrastructure Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 7)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(PE) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(PE) Companies</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 8)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(VC) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of IPO(VC) Companies</th>
                                      <?php
                                          }
                                          
                                      }
                                      else if($vcflagValue == 9)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of Public Market Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 10)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(PE) Advisors</th>
                                      <?php
                                          }
                                      }
                                      else if($vcflagValue == 11)
                                      {
                                          if($dealvalue==101)
                                          {
                                           ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Investors</th>
                                      <?php
                                          }
                                          else if($dealvalue==102)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Companies</th>
                                      <?php
                                          }
                                          else if($dealvalue==103 || $dealvalue==104)
                                          {
                                      ?>
                                              <th colspan="<?php echo $columnlimit; ?>">List of M&A(VC) Advisors</th>
                                      <?php
                                          }
                                      }
                                      ?>
                              </tr></thead>
                              <tbody id="movies">
                                <?php
                                        //Code to add PREV /NEXT
                                        $icount = 0;
                                        if ($_SESSION['investeeId']) 
                                        unset($_SESSION['investeeId']);
//                                        if ($_SESSION['resultCompanyId']) 
//                                        unset($_SESSION['resultCompanyId']); 
                                    
                                        mysql_data_seek($rsinvestor ,0);
                                     $count=mysql_num_rows($rsinvestor);
                                if($dealvalue==101)
                                {
                                    While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                    {
                                            $Investorname=trim($myrow["Investor"]);
                                            $Investorname=strtolower($Investorname);

                                            $invResult=substr_count($Investorname,$searchString);
                                            $invResult1=substr_count($Investorname,$searchString1);
                                           $invResult2=substr_count($Investorname,$searchString2);
                                           if($newrowflag==1)
                                               echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";

                                            if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                            {
                                             $_SESSION['investeeId'][$icount++] = $myrow["InvestorId"];
                                           //  $_SESSION['resultCompanyId'][$icount++] = $myrow["InvestorId"];
                                             if($dealvalue==6)
                                             {
                            ?><tr>
                                <td ><a class="postlink" href="dirinvdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"><?php echo $myrow["Investor"];?> </a></td></tr>
                            <?php
                                            $totalCount=$totalCount+1;
                                            }
                                            else
                                            {
                                            ?><tr>
                                <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["InvestorId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"><?php echo $myrow["Investor"];?> </a></td></tr>
                            <?php    
                                            }
                                            }

                                            $newrowflag=0;
                                            if($i==$rowlimit)
                                            {  
                                               $i=1;
                                               echo "</table></td>";
                                               if($count>$i && $columncount<$columnlimit)
                                               {

                                                   echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                               }
                                               elseif ($j==$count) 
                                               {

                                                  echo "</table></td></tr>";
                                               }
                                            if($columncount==$columnlimit)
                                            {
                                                $columncount=1;
                                                $newrowflag=1;
                                            }
                                            else
                                            {

                                            $columncount++;
                                            }
                                            }
                                            elseif ($j==$count) 
                                            {
                                                  echo "</table></td></tr>";
                                            }
                                            else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                $i++;
                                            }
                                                    $j++;
                                       }
                                     }  
                                     else if($dealvalue==102)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $companyname=trim($myrow["companyname"]);
                                                $companyname=strtolower($companyname);

                                                $invResult=substr_count($companyname,$searchString);
                                                $invResult1=substr_count($companyname,$searchString1);
                                                $invResult2=substr_count($companyname,$searchString2);
                                               if($newrowflag==1)
                                                   echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                   
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                    $_SESSION['resultCompanyId'][$icount++] = $myrow["InvestorId"];
                                                   
                                   ?><tr>
                                       <td ><a class="postlink" href="dircomdetails.php?value=<?php echo $myrow["PECompanyId"];?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?> "><?php echo $myrow["companyname"];?> </a></td></tr>
                                   <?php
                                                   $totalCount=$totalCount+1;
                                                  
                                                }
						
                                                $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                           }
                                     }
                                     else if($dealvalue==103 || $dealvalue==104)
                                     {
                                        While($myrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                        {
                                                $adviosrname=trim($myrow["Investor"]);
                                                $adviosrname=strtolower($adviosrname);

                                                $invResult=substr_count($adviosrname,$searchString);
                                                $invResult1=substr_count($adviosrname,$searchString1);
                                                $invResult2=substr_count($adviosrname,$searchString2);
                                                if($newrowflag==1)
                                                echo "<tr><td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";
                                                
                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                {
                                                        $querystrvalue= $myrow["CIAId"]."/".$vcflagValue;
                                         ?>
                                                        <tr><td>
                                                        <a style="text-decoration: none" href='diradvisor.php?value=<?php echo $querystrvalue;?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>' >
                                                        <?php echo $myrow["Cianame"]; ?></a></td></tr>
                                                <?php
                                                        $totalCount=$totalCount+1;
                                                }
                                                 $newrowflag=0;
                                                if($i==$rowlimit)
                                                {  
                                                   $i=1;
                                                   echo "</table></td>";
                                                   if($count>$i && $columncount<$columnlimit)
                                                   {

                                                       echo "<td width=".(100/4)."% ><table cellspacing='0' cellpadding='0' border='0'>";                                                           
                                                   }
                                                   elseif ($j==$count) 
                                                   {

                                                      echo "</table></td></tr>";
                                                   }
                                                if($columncount==$columnlimit)
                                                {
                                                    $columncount=1;
                                                    $newrowflag=1;
                                                }
                                                else
                                                {

                                                $columncount++;
                                                }
                                                }
                                                elseif ($j==$count) 
                                                {
                                                      echo "</table></td></tr>";
                                                }
                                                else if(($invResult==0) && ($invResult1==0) && ($invResult2==0)) { 
                                                    $i++;
                                                }
                                                        $j++;
                                        }
                                     }
					
						?>
                        </tbody>
                  </table>
                       
                </div>	
        </div>
			<?php
					}
				 
			?>
             <div class="holder"></div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
		<?php
		if(($exportToExcel==1))
		{
		?>
				<span style="float:right" class="one">
				<input class="export" id="expshowdeals" type="submit"  value="Export" name="showprofile">
				</span>
				 <script type="text/javascript">
                        $('#exportbtn').html('<input class ="export" type="submit" id="expshowdeals"  value="Export" name="showprofile">');
                 </script>
		<?php
		}
		?>
    </div>

</td>

</tr>
</table>
 
</div>
<div class=""></div>

</div>
</form>
       <script type="text/javascript">
                $("a.postlink").click(function(){
                 
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval); 
                    $("#pesearch").submit();
                    
                    return false;
                    
                });
                   $('#expshowdeals').click(function(){ 
                      	hrefval= 'exportinvestorprofile.php';
						$("#pegetdata").submit();
						return false;
					});
                function resetinput(fieldname)
                {
                 
                //alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val(fieldname));
                  $("#pesearch").submit();
                    return false;
                }
            </script>
</body>
</html>

<?php
        }
	function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}
function writeSql_for_no_records($sqlqry,$mailid)
 {
 $write_filename="pe_query_no_records.txt";
 //echo "<Br>***".$sqlqry;
					$schema_insert="";
					//TRYING TO WRIRE IN EXCEL
								 //define separator (defines columns in excel & tabs in word)
									 $sep = "\t"; //tabbed character
									 $cr = "\n"; //new line

									 //start of printing column names as names of MySQL fields

										print("\n");
										 print("\n");
									 //end of printing column names
									 		$schema_insert .=$cr;
									 		$schema_insert .=$mailid.$sep;
											$schema_insert .=$sqlqry.$sep;
										        $schema_insert = str_replace($sep."$", "", $schema_insert);
									    $schema_insert .= ""."\n";

									 		if (file_exists($write_filename))
											{
												//echo "<br>break 1--" .$file;
												 $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
													 if($fp)
													 {//echo "<Br>-- ".$schema_insert;
														fwrite($fp,$schema_insert);    //    Write information to the file
														  fclose($fp);  //    Close the file
														// echo "File saved successfully";
													 }
													 else
														{
														echo "Error saving file!"; }
											}

							         print "\n";

 }


    ?>

