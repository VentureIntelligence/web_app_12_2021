<?php
        
        /*$companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
		$Db = new dbInvestments();
        include ('checklogin.php');*/
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] :4; 
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] :1;
        
       
               $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";

                    if($vcflagValue==3)
                    {
                            $dbtype='SV';
                            $pagetitle="Social Venture Investments -> Search";
                            $showallcompInvFlag=8;
                            $stagesql_search =  "SELECT DISTINCT pe.StageId, Stage
                            FROM peinvestments AS pe, peinvestments_dbtypes AS pedb, stage AS s
                            WHERE pedb.PEId = pe.PEId
                            AND pe.Deleted =0
                            AND pedb.DBTypeId = '$dbtype'
                            AND s.StageId = pe.StageId
                            ORDER BY DisplayOrder";
                    }
                    elseif($vcflagValue==4)
                    {
                            $dbtype='CT';
                            $showallcompInvFlag=9;
                            $pagetitle="Cleantech Investments -> Search";
                            $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
                    //	echo "<br>Check for stage** - " .$checkForStage;
                    }
                    elseif($vcflagValue==5)
                    {
                             $dbtype='IF';
                            $showallcompInvFlag=10;
                            $pagetitle="Infrastructure Investments -> Search";
                            $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
                    }
                   

                     if($vcflagValue==3)
                        {
                               $addVCFlagqry = " and pec.industry!=15 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of Social Venture Investments ";
					$dbtype="SV";
                                         $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
					//$searchAggTitle = "Aggregate Data - VC Investments ";
					//$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					//FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
                        }
                        elseif($vcflagValue==4)
                        {
                          $addVCFlagqry = " and pec.industry!=15 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of CleanTech Investments ";
					$dbtype="CT";
                                         $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
					//$searchAggTitle = "Aggregate Data - VC Investments ";
					//$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					//FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
                        }
                         elseif($vcflagValue==5)
                        {
                           $addVCFlagqry = " and pec.industry!=15 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of Infrastructure Investments ";
					$dbtype="IF";
                                         $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
					//$searchAggTitle = "Aggregate Data - VC Investments ";
					//$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					//FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
                        }
				$dbTypeSV="SV";
                $dbTypeIF="IF";
                $dbTypeCT="CT";

                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);

                $buttonClicked=$_POST['hiddenbutton'];
                $fetchRecords=true;
                $totalDisplay="";
               

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
		$stageCnt=0;
                $cnt=0;
                $stageCntSql="select count(StageId) as cnt from stage";
                if($rsStageCnt=mysql_query($stageCntSql))
                {
                  while($mystagecntrow=mysql_fetch_array($rsStageCnt,MYSQL_BOTH))
                   {
                     $stageCnt=$mystagecntrow["cnt"];
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
                                                $cnt=$cnt+1;
						$stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
					}
				}
			}
			$stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
			if($cnt==$stageCnt)
			{      $stagevaluetext="All Stages";}
       		}
		else
			$stagevaluetext="";
		//echo "<br>*************".$stagevaluetext;
		if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";
                if($debt_equity == 0)
		        $debt_equityDisplay="Equity only";
		elseif($debt_equity == 1)
                        $debt_equityDisplay="Debt only";
 	        elseif($debt_equity == "--")
                        $debt_equityDisplay="Both";

                if($invType !="--")
                {
                    $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$invType'";
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
                 //print_r($_POST);
                        if(!$_POST){
                           // echo $startyear;
							$yourquery=0;
							$stagevaluetext="";
							$industry=0;
                                //echo "<br>Query for all records";
                                 if($type==1)
                                { 
                                     $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and dates between '".$startyear."' and '".$endyear."' group by year(pe.dates)"; 
                                    //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                     $companysql = "select i.industry,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and dates between '".$startyear."' and '".$endyear."' group by i.industry, year(pe.dates)";
                                    //echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                                elseif($type==3)
                                {
                                     $companysql = "select s.Stage,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and dates between '".$startyear."' and '".$endyear."' group by s.Stage, year(pe.dates)";
                                    
                                   //echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                                
                                else if($type ==4)
                                {
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and (pe.amount > 200) and dates between '".$startyear."' and '".$endyear."' group by year(pe.dates)";
                                   
                                              //echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                             $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and (pe.amount > ".$elimit[0]." and pe.amount <= ".$elimit[1].") and dates between '".$startyear."' and '".$endyear."' group by year(pe.dates)";
                                            //echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                       /* else
                                        {
                                            $deal='';
                                        }*/
                                     }
                                }
                                elseif($type==5)
                                {
                                     $companysql = "select inv.InvestorTypeName,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe,investortype as inv, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pe.InvestorType=inv.InvestorType and  pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and dates between '".$startyear."' and '".$endyear."' group by inv.InvestorTypeName, year(pe.dates)";
                                 
                                  //echo  $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
                                elseif($type==6)
                                {
                                    $companysql = "select re.Region ,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe,investortype as inv,region as re , industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pec.RegionId = re.RegionId and  pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and re.Region !=  '' and dates between '".$startyear."' and '".$endyear."' group by re.Region , year(pe.dates)";
                                 
                                  //echo $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
                          //    echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                            if($type != 4)
                            {
                                if($keyword != "")
                                {
                                        $keybef=", peinvestors as peinv, peinvestments_investors as p_inv";
                                }
                                if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                {
                                        $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
                                        $albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac";
                                }
                              
                                if($type==1)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select year(dates),count(DISTINCT PEId),sum(DISTINCT amount)from (";
                                             $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef." where";
                                            $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef2." where";
                                    }
                                    else {
                                        $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef." where";
                                    }
                                   // $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef.$albef." where";
                                }
                                else if($type==2)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select industry, year(dates), count(DISTINCT PEId), sum(DISTINCT amount)from (";
                                             $companysql= $companyadd."select i.industry, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef." where pec.industry = i.industryid and "; 
                                             $companysql2 = "select i.industry, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$albef2." where pec.industry = i.industryid and "; 
                                    }
                                    else {
                                        $companysql = "select i.industry,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef." where pec.industry = i.industryid and "; 
                                    }
                                   //$companysql = "select i.industry,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef.$albef." where pec.industry = i.industryid and "; 
                                
                                }
                                else if($type==3)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Stage, year(dates), count(DISTINCT PEId), sum(DISTINCT amount)from (";
                                             $companysql= $companyadd."select s.Stage, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb  ".$albef." where pe.StageId = s.StageId and "; 
                                             $companysql2 = "select s.Stage, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$albef2." where pe.StageId = s.StageId and "; 
                                    }
                                    else {
                                        $companysql = "select s.Stage,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef." where pe.StageId = s.StageId and "; 
                                    } 
                                    //$companysql = "select s.Stage,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef.$albef." where pe.StageId = s.StageId and "; 
                                
                                }
                                else if($type==5)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select InvestorTypeName, year(dates), count(DISTINCT PEId), sum(DISTINCT amount)from (";
                                             $companysql= $companyadd."select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef." where pe.InvestorType = inv.InvestorType and "; 
                                             $companysql2 = "select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef2." where pe.InvestorType = inv.InvestorType and "; 
                                    }
                                    else {
                                        $companysql = "select inv.InvestorTypeName,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$keybef." where pe.InvestorType = inv.InvestorType and "; 
                                    } 
                                   // $companysql = "select inv.InvestorTypeName,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb , investortype as inv ".$keybef.$albef." where pe.InvestorType = inv.InvestorType and "; 
                                
                                }
                                else if($type==6)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Region, year(dates), count(DISTINCT PEId), sum(DISTINCT amount)from (";
                                             $companysql= $companyadd."select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$albef." where pec.RegionId = re.RegionId and"; 
                                             $companysql2 = "select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef2." where pec.RegionId = re.RegionId and"; 
                                    }
                                    else {
                                        $companysql = "select re.Region,year(pe.dates),count(DISTINCT pe.PEId),sum(DISTINCT pe.amount)from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$keybef." where pec.RegionId = re.RegionId and"; 
                                    } 
                                    //$companysql = "select re.Region ,year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb,region as re ".$keybef.$albef." where pec.region =  re.Region and "; 
                                }
                            
				//echo "<br> individual where clauses have to be merged ";
					if ($industry > 0 && $industry != "")
                                        {
                                                $whereind = " pec.industry='" .$industry ."'";
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($regionId > 0 && $regionId !="")
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pec.RegionId  ='".$regionId."'";
                                        }
                                        if($companyType != "--" && $companyType!=" " && $companyType!="")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                        }
                                        if($debt_equity != "--" && $debt_equity!="" && $debt_equity!=" ")
                                        {  
                                            $whereSPVdebt=" pe.SPV='".$debt_equity."'"; 
                                        }
                                        if ($invType != "--" && $invType != "" && $invType != " ")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                        }
                                        if ($boolStage==true)
                                        {
                                                $stagevalue="";
                                                $stageidvalue="";
                                                foreach($stageval as $stage)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $stagevalue= $stagevalue. " pe.StageId='" .$stage."' or ";
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
                                //	echo "<br>Where stge---" .$wherestage;
                                        if (($startRangeValue != "--") && ($endRangeValue != "--") && ($startRangeValue != "") && ($endRangeValue != ""))
                                        {
                                           // echo "dddddddddddddd";
                                                $startRangeValue=$startRangeValue;
                                                $endRangeValue=$endRangeValue-0.01;
                                                $qryRangeTitle="Deal Range (M$) - ";
                                                if($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.amount >  ".$startRangeValue ." and pe.amount <= ". $endRangeValue ." and AggHide=0";
                                                }
                                                elseif(($startRangeValue = $endRangeValue) )
                                                {
                                                        $whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
                                                }
                                        }
                               
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                           $qryDateTitle ="Period - ";
                                           $wheredates= " and dates between '" . $dt1. "' and '" . $dt2 . "' ";
                                        }
                                       if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                       if (($whereregion != "") )
                                        {
                                            $companysql=$companysql . $whereregion . " and " ;
                                            $aggsql=$aggsql . $whereregion ." and ";
                                            $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;

                                        }
                                       if($wherelisting_status!="")
                                        {
                                         $companysql=$companysql .$wherelisting_status . " and ";
                                        }
                                        if($whereSPVdebt!="")
                                        { $companysql=$companysql .$whereSPVdebt ." and "; }
                                         if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                      if (($whererange != "" && $whererange !="--"))
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $aggsql=$aggsql .$whererange . " and ";
                                                $bool=true;
                                        }
                                           if($keyword != "")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        else if($sectorsearch != "")
                                        {
                                                $ssaft=" pec.sector_business LIKE '%$sectorsearch%' ";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                         else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        //the foll if was previously checked for range
                                        if($whererange  != "--")
                                        {
                                                $companysql = $companysql . " i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " . $addVCFlagqry . "";
                                                
                                                $companysql2 = $companysql2 . " i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " . $addVCFlagqry . "";
                                        //	echo "<br>----" .$whererange;
                                        }
                                        elseif($whererange == "--")
                                        {
                                                $companysql = $companysql . "  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " .$addVCFlagqry. "";
                                                
                                                 $companysql2 = $companysql2 . "  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " .$addVCFlagqry. "";
                                        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                        }
                                        if(($wheredates != "") )
                                        {
                                                $companysql = $companysql . $wheredates ;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                                
                                                 $companysql2 = $companysql2 . $wheredates ;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        if($advisorsearchstring_legal!="")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " and ";
						$companysql2=$companysql2 . $alaft . " and ";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . " and ";
						$companysql2=$companysql2 . $ataft . " and ";
                                        }
                                        if($advisorsearchstring_legal!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearchstring_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                         if($type == 1)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $groupby=" group by year(dates)";
                                            }
                                            else {
                                                    $groupby=" group by year(pe.dates)";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $groupby=" group by industry, year(dates)";
                                            }
                                            else {
                                                    $groupby=" group by i.industry,year(pe.dates)";
                                            }
                                        }
                                        if($type == 3)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $groupby=" group by Stage, year(dates)";
                                            }
                                            else {
                                                    $groupby=" group by s.Stage, year(pe.dates)";
                                            }
                                          
                                        }
                                        if($type == 5)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $groupby=" group by  InvestorTypeName, year(dates)";
                                            }
                                            else {
                                                    $groupby=" group by inv.InvestorTypeName, year(pe.dates)";
                                            }
                                        }
                                        if($type == 6)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $groupby=" group by Region, year(dates)";
                                            }
                                            else {
                                                    $groupby=" group by re.Region, year(pe.dates)";
                                            }
                                        }
                                        if($groupby != "")
                                        {
                                             $companysql = $companysql . $groupby ;
                                                $aggsql = $aggsql . $groupby ;
                                                $bool=true;
                                        }
                                       //echo "SQL POST".$companysql;
                                         $resultcompany= mysql_query($companysql) or die(mysql_error());;
										
                               }  
                                if($type == 4 && $_POST)
                                {
                                     if (($startRangeValue == "--") && ($endRangeValue == "--")  )
                                       {
                                            $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                       }
                                    if (($startRangeValue!= "--") && ($endRangeValue != "--")  )
                                       {
                                            $startFlag=0;$endFlag=0;
                                            $arr_range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                            $range = array();
                                            foreach($arr_range as $value)
                                            {
                                                $arr_srange= spliti('-', $value);
                                                
                                                if($startFlag == 0 || $endFlag == 0)
                                                {
                                                    if(($arr_srange[0] >= $startRangeValue))
                                                    { 
                                                        if ($startFlag == 0){
                                                            $finalsrange = $startRangeValue;
                                                            $startFlag = 1;
                                                        }else{
                                                            $finalsrange = $arr_srange[0];
                                                        }
                                                    }
                                                    
                                                    
                                                    //echo $arr_srange[1];
                                                    if( $startFlag == 1)
                                                    {
                                                        if($endRangeValue >= $arr_srange[1])
                                                        {
                                                            if($endFlag == 0)
                                                            {
                                                                $finalerange = $arr_srange[1];
                                                                
                                                            }
                                                            else
                                                            {
                                                                 $finalerange = $endRangeValue;
                                                                 
                                                            }
                                                        }else{
                                                            $finalerange = $endRangeValue;
                                                            $endFlag=1;
                                                        }
                                                    }
                                                     //echo $finalsrange."-".$finalerange."</br>";
                                                    
                                                   if($finalsrange !='' && $finalerange!='')
                                                   {
                                                        $comserange="$finalsrange"."-"."$finalerange";
                                                        array_push($range, $comserange);
                                                   }
                                                }
                                            }
                                       }     
                                     //print_r($range);
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        
                                        if($keyword != "")
                                        {
                                                $keybef=", peinvestors as peinv, peinvestments_investors as p_inv";
                                        }
                                        else if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac";
                                                    $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
                                            }
                              
                                        if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                $companyadd = "select year(dates),count(DISTINCT PEId),sum(DISTINCT amount)from (";
                                                $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe,peinvestments_dbtypes as pedb, industry as i,pecompanies as pec,stage as s ".$albef." where";
                                                $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe,peinvestments_dbtypes as pedb, industry as i,pecompanies as pec,stage as s ".$albef2." where";
                                        }
                                        else {
                                            $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb  ".$keybef." where";
                                        }
                                        
          
                            //$companysql = "select year(pe.dates),count(DISTINCT  pe.PEId),sum(pe.amount) from peinvestments as pe ,peinvestments_dbtypes as pedb , industry as i,pecompanies as pec,stage as s ".$keybef.$albef." where";
                                    
				//echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pec.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType!=null)
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                        }
                                        if($debt_equity != "--")
                                        {  
                                            $whereSPVdebt=" pe.SPV='".$debt_equity."'"; 
                                        }
                                        if ($invType != "--")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                        }
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
                                        
                                       
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                        if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                        {
                                            $whererange = " pe.amount > ".$elimit[0] ." and pe.amount <= ". $elimit[1] ." and AggHide=0"; 
                                        }
                                        else if($elimit[0] >= 200 || $elimit[1] >= 200)
                                        {
                                            $whererange = " pe.amount > 200 and AggHide=0";
                                        }

                              
                                        if($type==4)
                                        {
                                            $groupby = "group by year(pe.dates)";
                                        }
                                
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                           $qryDateTitle ="Period - ";
                                           $wheredates= " and dates between '" . $dt1. "' and '" . $dt2 . "' ";
                                        }
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                        if (($whereregion != "") )
                                        {
                                //		echo "<br>TRUE";
                                        $companysql=$companysql . $whereregion . " and " ;
                                                $aggsql=$aggsql . $whereregion ." and ";
                                //	echo "<br>----comp sql after region-- " .$companysql;
                                        $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;

                                        }
                                        if($wherelisting_status!="")
                                        {
                                         $companysql=$companysql .$wherelisting_status . " and ";
                                        }
                                        if($whereSPVdebt!="")
                                        { $companysql=$companysql .$whereSPVdebt ." and "; }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $aggsql=$aggsql .$whererange . " and ";
                                                $bool=true;
                                        }
                                         if($keyword != "")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if($companysearch != "")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        if($sectorsearch != "")
                                        {
                                                $ssaft=" pec.sector_business LIKE '%$$sectorsearch%' ";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " and ";
						$companysql2=$companysql2 . $alaft . " and ";
                                        }
                                        else if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . " and ";
						$companysql2=$companysql2 . $ataft . " and ";
                                        }
                                        if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        //the foll if was previously checked for range
                                        if($whererange  != "--")
                                        {
                                                $companysql = $companysql . " i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " . $addVCFlagqry . "";
                                                
                                                $companysql2 = $companysql2 . " i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " . $addVCFlagqry . "";
                                        //	echo "<br>----" .$whererange;
                                        }
                                        elseif($whererange == "--")
                                        {
                                                $companysql = $companysql . "  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " .$addVCFlagqry. "";
                                                
                                                 $companysql2 = $companysql2 . "  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
						and pe.Deleted=0 " .$addVCFlagqry. "";
                                        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                        }
                                        if(($wheredates != "") )
                                        {
                                                $companysql = $companysql . $wheredates ;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                                
                                                 $companysql2 = $companysql2 . $wheredates ;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
					if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($type == 4)
                                        {
                                            if(($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ") || ($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" "))
                                            {
                                                    $groupby=" group by year(dates)";
                                            }
                                            else {
                                                    $groupby=" group by year(pe.dates)";
                                            }
                                        }
                                        if($groupby != "")
                                        {
                                             $companysql = $companysql . $groupby ;
                                                $aggsql = $aggsql . $groupby ;
                                                $bool=true;
                                        }
                                         //echo "TYPE 4 AND POST".$companysql;
                                         $resultcompany= mysql_query($companysql) or die(mysql_error());
                                        
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                      
                                     }
                                }
                             
		}	else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//}
	//END OF POST
	
	
//	echo $companysql;
	$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
		where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
	if($trialrs=mysql_query($TrialSql))
	{
		while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
		{
			$exportToExcel=$trialrow["TrialLogin"];
			$compId=$trialrow["compid"];

		}
	}
	
   if($compId==$companyId){ 
   		$hideIndustry = " and display_in_page=1 "; 
	} else { 
		$hideIndustry=""; 
	}
	
	//INDUSTRY
	$industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
	
	//Company Sector
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	
	$addVCFlagqry="";
	$pagetitle="PE-backed Companies";

	$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
					FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
					WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
					AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
					AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
	ORDER BY pec.companyname";
	
	//Stage
	$stagesql = "select StageId,Stage from stage ";
	

?>

<?php 
	$topNav = 'Deals';
	//include_once('tvheader_search.php');
?>

<div>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td >

<?php //include_once('refine.php');?>
    <input type="hidden" name="resetfield" value="" id="resetfield"/>
</td>
 <?php

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

			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
					if(trim($buttonClicked==""))
					{
		           ?>


<td>
    <!--div style="float:right;padding: 20px" class="key-search"><b></b> <input type="text" name="searchallfield" placeholder=" Keyword Search"> <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();"></div-->

<div class="result-cnt">		
<!--                       <div class="veiw-tab"><ul>
                         <li class="active"><a href="svtrendview.php?type=1&value=4"><i class="i-trend-view"></i>Trend View</a></li>
                        <li ><a  href="svindex.php?value=<?php echo $vcflagValue; ?>"><i class="i-list-view"></i>List View</a></li>
                        <?php
						/*$count=0;
						 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							if($count == 0)
							{
								 $comid = $myrow["PEId"];
								$count++;
							}
						}*/
						?>
                        li><a class="postlink" href="dealdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><i class="i-profile-view"></i>Details View</a></li
                       
                        </ul></div>		-->
       <?php
if($vcflagValue==3)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav23" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav23" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav23" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav23" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav23" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav23" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

</td></tr>
</table>
</div>
<?php
}
else if($vcflagValue==4)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav24" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav24" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav24" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav24" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav24" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav24" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

</td></tr>
</table>
</div>
<?php     
}
else if($vcflagValue==5)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav25" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav25" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav25" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav25" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav25" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav25" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

</td></tr>
</table>
</div>
<?php     
}
?>
 <div class="profile-view-title"> 
 <?php 
 if($type==1 && $vcflagValue==4)
 {
 ?>
    <h2>Cleantech - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==4)
 {
     ?>
     <h2>Cleantech - By Industry</h2>
 <?php
 }
  elseif($type==3 && $vcflagValue==4)
 {
     ?>
     <h2>Cleantech - By Stage</h2>
 <?php
 }
  elseif($type==4 && $vcflagValue==4)
 {
     ?>
     <h2>Cleantech - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==4)
 {
     ?>
     <h2>Cleantech - By Investor</h2>
 <?php
 } elseif($type==6 && $vcflagValue==4)
 {
     ?>
     <h2>Cleantech - By Region</h2>
 <?php
 }
  else if($type==1 && $vcflagValue==5)
 {
 ?>
    <h2>Infrastructure - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==5)
 {
     ?>
     <h2>Infrastructure - By Industry</h2>
 <?php
 }
  elseif($type==3 && $vcflagValue==5)
 {
     ?>
     <h2>Infrastructure - By Stage</h2>
 <?php
 }
  elseif($type==4 && $vcflagValue==5)
 {
     ?>
     <h2>Infrastructure - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==5)
 {
     ?>
     <h2>Infrastructure - By Investor</h2>
 <?php
 } elseif($type==6 && $vcflagValue==5)
 {
     ?>
     <h2>Infrastructure - By Region</h2>
 <?php
 }
 else if($type==1 && $vcflagValue==3)
 {
 ?>
    <h2>Social Venture - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==3)
 {
     ?>
     <h2>Social Venture  - By Industry</h2>
 <?php
 }
  elseif($type==3 && $vcflagValue==3)
 {
     ?>
     <h2>Social Venture  - By Stage</h2>
 <?php
 }
  elseif($type==4 && $vcflagValue==3)
 {
     ?>
     <h2>Social Venture  - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==3)
 {
     ?>
     <h2>Social Venture  - By Investor</h2>
 <?php
 } elseif($type==6 && $vcflagValue==3)
 {
     ?>
     <h2>Social Venture  - By Region</h2>
 <?php
 }
 ?>
 </div><br>
    
 <table cellpadding="0" cellspacing="0" width="100%">
<?php
if($type==2)
{
    if(mysql_num_rows($resultcompany)>0)
    {
        while($rowindus = mysql_fetch_array($resultcompany))	
        {  
           $deal[$rowindus['industry']][$rowindus[1]]['dealcount']=$rowindus[2];
           $deal[$rowindus['industry']][$rowindus[1]]['sumamount']=$rowindus[3];  
        }  
    }
    else
    {
        $deal='';
    }
}
elseif($type==3)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowstage = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowstage['Stage']][$rowstage[1]]['dealcount']=$rowstage[2];
          $deal[$rowstage['Stage']][$rowstage[1]]['sumamount']=$rowstage[3];  
       }
    }
    else
    {
        $deal='';
    }
}
else if($type==5)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowinvestor = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['dealcount']=$rowinvestor[2];
          $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['sumamount']=$rowinvestor[3];  
       }
     }
    else
    {
        $deal='';
    }
}
else if($type==6)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowregion = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowregion['Region']][$rowregion[1]]['dealcount']=$rowregion[2];
          $deal[$rowregion['Region']][$rowregion[1]]['sumamount']=$rowregion[3];  
       }
    }
    else
    {
        $deal='';
    }
}
?>
 </div>          		

</form>
   <?php
    if($type==1 && $vcflagValue==4)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'No of Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo round($rowsyear[2]); ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=4&y='+topping;
             <?php if($drilldownflag==1){ ?>
              window.location.href = 'svindex.php?'+query_string;
            <?php } ?>
            
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
                    //$('#slidingTable').hide();  
					<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==1 && $vcflagValue==5)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'No of Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo round($rowsyear[2]); ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=5&y='+topping;
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
                   // $('#slidingTable').hide(); 
				   <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
     else if($type==1 && $vcflagValue==3)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'No of Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo round($rowsyear[2]); ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=3&y='+topping;
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
                    //$('#slidingTable').hide();  
					<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==2 && $vcflagValue==4)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=4&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=4&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});

      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>

      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
      else if($type==2 && $vcflagValue==5)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=5&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=5&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
      else if($type==2 && $vcflagValue==3)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=3&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=3&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
    else if($type==3 && $vcflagValue==4)
    {
        ?>
    
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
        <?php 
       $totaldealsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totaldeals=0;
        foreach($deal as $industry => $values)
        {
            $totaldeals+=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
        }
        $totaldealsarray[$i]=$totaldeals;
       } ?>
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?number_format((($values[$i]['dealcount']/$totaldealsarray[$i])*100),2,'.',''):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
           <?php 
       $totalamtsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totalamt=0;
        foreach($deal as $industry => $values)
        {
            $totalamt+=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
        }
        $totalamtsarray[$i]=$totalamt;
       } ?>
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?number_format((($values[$i]['sumamount']/$totalamtsarray[$i])*100),2,'.',''):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
          var selectedItem = chart5.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var stage = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart5, 'select', selectHandler2);
         chart5.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
      chart.draw(data4, {title:"Amount",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      google.visualization.events.addListener(chart, 'select', function() {
    var selection = chart.getSelection();
    console.log(selection);  
});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>    
    
       
    <? 
     }
     else if($type==3 && $vcflagValue==5)
    {
        ?>
    
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
        <?php 
       $totaldealsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totaldeals=0;
        foreach($deal as $industry => $values)
        {
            $totaldeals+=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
        }
        $totaldealsarray[$i]=$totaldeals;
       } ?>
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?number_format((($values[$i]['dealcount']/$totaldealsarray[$i])*100),2,'.',''):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          <?php 
       $totalamtsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totalamt=0;
        foreach($deal as $industry => $values)
        {
            $totalamt+=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
        }
        $totalamtsarray[$i]=$totalamt;
       } ?>
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?number_format((($values[$i]['sumamount']/$totalamtsarray[$i])*100),2,'.',''):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
          var selectedItem = chart5.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var stage = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart5, 'select', selectHandler2);
         chart5.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
      chart.draw(data4, {title:"Amount",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      google.visualization.events.addListener(chart, 'select', function() {
    var selection = chart.getSelection();
    console.log(selection);  
});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>    
    
       
    <? 
     }
     else if($type==3 && $vcflagValue==3)
    {
        ?>
    
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
        <?php 
       $totaldealsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totaldeals=0;
        foreach($deal as $industry => $values)
        {
            $totaldeals+=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
        }
        $totaldealsarray[$i]=$totaldeals;
       } ?>
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")? number_format((($values[$i]['dealcount']/$totaldealsarray[$i])*100),2,'.',''):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
           <?php 
       $totalamtsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totalamt=0;
        foreach($deal as $industry => $values)
        {
            $totalamt+=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
        }
        $totalamtsarray[$i]=$totalamt;
       } ?>
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?number_format((($values[$i]['sumamount']/$totalamtsarray[$i])*100),2,'.',''):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
          var selectedItem = chart5.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var stage = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart5, 'select', selectHandler2);
         chart5.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
     colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
      chart.draw(data4, {title:"Amount",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      google.visualization.events.addListener(chart, 'select', function() {
    var selection = chart.getSelection();
    console.log(selection);  
});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>    
    
       
    <? 
     }
    else if($type == 4 && $vcflagValue==4 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
     else if($type == 4 && $vcflagValue==5 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?round($values[$i]['dealcount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
     else if($type == 4 && $vcflagValue==3 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type==5 && $vcflagValue==4)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
     // $('#slidingTable').hide();  
	 <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
      else if($type==5 && $vcflagValue==5)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
      else if($type==5 && $vcflagValue==3)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
     else if($type==6 && $vcflagValue==4)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=4&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=4&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
     else if($type==6 && $vcflagValue==5)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=5&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=5&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type==6 && $vcflagValue==3)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=3&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=3&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      //$('#slidingTable').hide();  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    if($type == 4 && $vcflagValue==4 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=4&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
     // $('#slidingTable').hide();  
	 <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    else  if($type == 4 && $vcflagValue==5 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=5&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
     // $('#slidingTable').hide();  
	 <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    else  if($type == 4 && $vcflagValue==3 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=3&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>              window.location.href = 'svindex.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:divwidth, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});  
	  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    ?>
    
<?php
if($type!=1)
{
 ?>
<tr>
<td width="50%" class="profile-view-left">
 <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
<td class="profile-view-rigth" width="50%" >
  <div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>  
</td>
</tr> 

<tr>
<td width="50%" class="profile-view-left" id="chartbar">
    <div id="visualization1" style="max-width: 100%; height: 750px;overflow-x: auto;overflow-y: hidden;"></div>    
</td>
<td  id="chartbar" class="profile-view-rigth" width="50%" >
    <div id="visualization" style="max-width: 100%; height: 700px;overflow-x: auto;overflow-y: hidden;"></div> 
</td>
</tr>
<?php
}
else
{
?>
<tr>
    <td width="100%" class="profile-view-left" colspan="2">
<div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
</tr> 
<?php
}
?>
<tr>
    <td class="profile-view-left" colspan="2">
        <div class="showhide-link link-expand-table"><a href="#" class="show_hide" rel="#slidingDataTable">View Table</a></div>

     
	 <div class="view-table expand-table" id="slidingDataTable" style="display:none;width: 100%; overflow:hidden;">
     <div class="restable" >
         <table class="responsive" cellpadding="0" cellspacing="0">

    <thead>
   
    <?php
    if($type==1)
    {
        ?>
    
        <tr><th colspan="1" style="text-align:center">Year</th>
            <th colspan="1" style="text-align:center">No. of Deals</th>
            <th colspan="1" style="text-align:center">Amount($m)</th>
        </tr>
<?php
    }
    elseif($type==2)
    {
    ?>

   
    <tr><th rowspan="2"  style="text-align:center">Industry</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
  <?php   
    }
    elseif($type==3)
    {
        ?>
  <tr><th rowspan="2"  style="text-align:center">Stage</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                 if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==5)
    {
        ?>
   
       <tr><th rowspan="2"  style="text-align:center">Investor</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
           echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php     
    }
    else if($type==4)
    {
        ?>
        <tr><th rowspan="2"  style="text-align:center">Range</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==6)
    {
        ?>
    <tr><th rowspan="2"  style="text-align:center">Region</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
             echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php
    }
    ?></thead>

     <tbody>
      <?php
    if($type==1)
    {
        if(mysql_num_rows($resultcompany)>0)
        {    
            mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
            {
                    echo "<tr style=\"text-align:center;\">
                    <td>".$rowsyear[0]."</td>
                    <td>".$rowsyear[1]."</td>
                    <td>".$rowsyear[2]."</td>
                    </tr>";		                                                                           
            }
        }
        else
        {
             echo "<tr style=\"text-align:center;\">
                    No Data Found
                    </tr>";
        }
    }
    else if($type==2)
    {
         if($deal !='')
        {
            $content ='';

            foreach($deal as $industry => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$industry.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 
            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==3)
    {
        if($deal !='')
        {
            $content ='';

            foreach($deal as $Stage => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$Stage.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 
            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type == 4 &&  !$_POST)
    {
        if($deal!='')
        {
            $content ='';
            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==5)
    {
        if($deal !='')
        {
            $content ='';

           foreach($deal as $InvestorTypeName => $values){
               $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
               $content .= '<td>'.$InvestorTypeName.'</td>';
                for($i=$fixstart;$i<=$fixend;$i++){
                    $content .= "<td>".$values[$i]['dealcount']."</td>";
                    $content .= "<td>".$values[$i]['sumamount']."</td>";
                }
                $content.= '</tr>';
           } 

           echo $content; 
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==6)
    {
        if($deal !='')
        {
            $content ='';

            foreach($deal as $region => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$region.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    if($type == 4 && $_POST)
    {
        if($deal!='')
        {
            $content ='';

            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    ?>
    </tbody>
 </table></div>       
   
</div>
    </form>
    </div>
</td>
</tr>
</table>
 </td>
  <? 
    }
    ?>
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
                function resetinput(fieldname)
                {
                    
                  $("#resetfield").val(fieldname);
                  $("#pesearch").submit();
                    return false;
                }
            </script>


<?php
	/*function returnMonthname($mth)
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

 }*/

?>
