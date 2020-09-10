<?php
        
        /*$companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
		$Db = new dbInvestments();
        include ('checklogin.php');*/
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] :4; 
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] :1;
        $sector_filter = implode(" OR ", $sector_sql);
       
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
                                     $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and dates between '".$startyear."' and '".$endyear." ' group by year(pe.dates)"; 
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
//                                   $resultcompany= mysql_query($companysql);
                                }
                                
                                elseif($type ==4)
                                {
                                    $compRangeSql="";
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                           $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and (pe.amount > 200) and dates between '".$startyear."' and '".$endyear."' group by year(pe.dates)";
                                   
//                                              echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                             $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount) FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes as pedb WHERE  i.industryid=pec.industry AND
                                             pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 " .$addVCFlagqry. " and (pe.amount > ".$elimit[0]." and pe.amount <= ".$elimit[1].") and dates between '".$startyear."' and '".$endyear."' group by year(pe.dates)";
//                                            echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
                                        $compRangeSql .= $companysql."#";   
//                                        if(mysql_num_rows($resultcompany)>0)
//                                        {
//                                            while ($rowrange = mysql_fetch_array($resultcompany))
//                                            {
//                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
//                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
//                                            }
//                                        }
                                       /* else
                                        {
                                            $deal='';
                                        }*/
                                     }
                                     $compRangeSql= urlencode($compRangeSql);
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
                                        $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac ";
                                        $albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac ";
                                }
                              
                                if($type==1)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select year(dates),count(DISTINCT PEId),sum(DISTINCT amount)from (";
                                             $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef." where ";
                                            $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef2." where ";
                                    }
                                    else {
                                        $companysql = "select year(pe.dates),count(DISTINCT pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ,peinvestments_dbtypes as pedb ".$keybef." where ";
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
                                             $companysql2 = "select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s,peinvestments_dbtypes as pedb ".$albef2." where pec.RegionId = re.RegionId and "; 
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
                                                if($wherestage !=''){
                                                $wherestage ="(".$wherestage.")";
                                                }
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
                                            $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                                            $sector_sql = array(); // Stop errors when $words is empty

                                            foreach($sectorsearchArray as $word){
                                                $word =trim($word);
                                    //                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                                $sector_sql[] = " pec.sector_business = '$word' ";
                                                                $sector_sql[] = " pec.sector_business LIKE '$word(%' ";
                                                                $sector_sql[] = " pec.sector_business LIKE '$word (%' ";
                                            }
                                            $sector_filter = implode(" OR ", $sector_sql);
                                            if($sector_filter !=''){
                                                $ssaft=" ( $sector_filter ) "; 
                                            }
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                         else if($searchallfield!="")
                                        {
                                             $findTag = strpos($searchallfield,'tag:');
                                            $findTags = "$findTag";
                                            if($findTags == ''){
                                                $tagsval = "city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%'";                                    
                                            }else{
                                                $tags = '';
                                                $ex_tags = explode(',',$searchallfield);
                                                if(count($ex_tags) > 0){
                                                    for($l=0;$l<count($ex_tags);$l++){
                                                        if($ex_tags[$l] !=''){
                                                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                            $tags .= "pec.tags like '%:$value%' or ";
                                        }
                                                    }
                                                }
                                                $tagsval = trim($tags,' or ');
                                            }
                                            
                                                $companysql.="( $tagsval ) AND";
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
                                                $alaft="and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . "  ";
						$companysql2=$companysql2 . $alaft . "  ";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft="and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . "  ";
						$companysql2=$companysql2 . $ataft . "  ";
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
                                          $compRangeSql = '';
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
                                                if($wherestage !=''){
                                                $wherestage ="(".$wherestage.")";
                                                }
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
                                                $ssaft=" pec.sector_business LIKE '%$sectorsearch%' ";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                $alaft="and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . "  ";
						$companysql2=$companysql2 . $alaft . "  ";
                                        }
                                        else if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                $ataft="and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . "  ";
						$companysql2=$companysql2 . $ataft . "  ";
                                        }
                                        if($searchallfield!="")
                                        {
                                            $findTag = strpos($searchallfield,'tag:');
                                            $findTags = "$findTag";
                                            if($findTags == ''){
                                                $tagsval = "city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%'";                                    
                                            }else{
                                                $tags = '';
                                                $ex_tags = explode(',',$searchallfield);
                                                if(count($ex_tags) > 0){
                                                    for($l=0;$l<count($ex_tags);$l++){
                                                        if($ex_tags[$l] !=''){
                                                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                            $tags .= "pec.tags like '%:$value%' or ";
                                        }
                                                    }
                                                }
                                                $tagsval = trim($tags,' or ');
                                            }
                                            
                                                $companysql.="( $tagsval ) AND";
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
                                        $compRangeSql .= $companysql."#";                                        
                                         //echo "TYPE 4 AND POST".$companysql;
//                                         $resultcompany= mysql_query($companysql) or die(mysql_error());
//                                        
//                                        if(mysql_num_rows($resultcompany)>0)
//                                        {
//                                            while ($rowrange = mysql_fetch_array($resultcompany))
//                                            {
//                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
//                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
//                                            }
//                                        }
                                      
                                     }
                                     $compRangeSql = urlencode($compRangeSql);
                                }
                             
		}	else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//}
	//END OF POST
	
	
	//echo $companysql;die;
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
	
$companysql=  urlencode($companysql);

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
<!--    <input type="hidden" name="resetfield" value="" id="resetfield"/>-->
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
 </td>
  <? 
    }
    ?>
</tr>
</table>

</div>
<div class=""></div>

