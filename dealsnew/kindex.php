<?php
        
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        include ('checklogin.php');
        $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0; 
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
        $getyear = $_REQUEST['y'];
        $getsy = $_REQUEST['sy'];
        $getey = $_REQUEST['ey'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        $resetfield=$_POST['resetfield'];
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
            echo "1";
            if($getyear!="")
            {
                $month1= 01;
                $year1 = $getyear;
                $month2= 12;
                $year2 = $getyear;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
            }
            else if($getsy !='' && $getey !='')
            {
                $month1= 01;
                $year1 = $getsy;
                $month2= 12;
                $year2 = $getey;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
                //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
            }
            else
            {
                $month1= date('n', strtotime(date('Y-m')." -2   month")); 
                $year1 = date('Y');
                $month2= date('n');
                $year2 = date('Y'); 
            if($type==1)
            {
                $fixstart=1998;
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = $endyear = date("Y-m-d");
            }
            else 
            {
                $fixstart=2009;
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
             }
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            echo "2";
            if($resetfield=="period")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }
            else
            {
             $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
             $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
        
        
        if($getyear !='')
        {
            $getdt1 = $getyear.'-01-01';
            $getdt2 = $getyear.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getsy !='' && $getey !='')
        {
            $getdt1 = $getsy.'-01-01';
            $getdt2 = $getey.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getindus !='')
        { 
            $isql="select industryid,industry from industry where industry='".$getindus."'" ;
            $irs=mysql_query($isql);
            $irow=mysql_fetch_array($irs);
            $geti = $irow['industryid'];
            $getind=" and pec.industry=".$geti;
        }
         if($getstage !='')
        { 
            $ssql="select StageId,Stage from stage where Stage='".$getstage."'" ;
            $srs=mysql_query($ssql);
            $srow=mysql_fetch_array($srs);
            $gets = $srow['StageId'];
            $getst=" and pe.StageId=" .$gets;
        }
        if($getinv !='')
        {
            $invsql = "select InvestorType,InvestorTypeName from investortype where Hide=0 and InvestorTypeName='".$getinv."'" ;
            $invrs = mysql_query($invsql);
            $invrow=mysql_fetch_array($invrs);
            $getinv = $invrow['InvestorType'];
            $getinvest = " and pe.InvestorType = '".$getinv ."'";
        }
        if($getreg!='')
        {
            if($getreg =='empty')
            {
                $getreg='';
            }
            else
            {
                $getreg;
            }
            $regsql = "select RegionId,Region from region where Region='".$getreg."'" ;
            $regrs = mysql_query($regsql);
            $regrow=mysql_fetch_array($regrs);
            $getreg = $regrow['RegionId'];
            $getregion = " and pec.RegionId  =".$getreg." and pec.RegionId IS NOT NULL";
        }
        if($getrg!='')
        {
            if($getrg == '200+')
            {
                $getrange = " and pe.amount > 200";
            }
            else
            {
                $range = explode("-", $getrg);
                $getrange = " and pe.amount > ".$range[0]." and pe.amount <= ".$range[1]."";
            }

        }
        $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm	where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        if($trialrs=mysql_query($TrialSql))
        {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                                $compId=$trialrow["compid"];
                        }
        }
        if($compId==$companyId)
        { 
           $hideIndustry = " and display_in_page=1 "; 

        }
        else
        {
           $hideIndustry="";     
        }
       
        $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
        if($vcflagValue==0)
        {
            $addVCFlagqry = " and pec.industry !=15 ";
            $checkForStage = ' && ('.'$stage'.' =="--")';
            //$checkForStage = " && (" .'$stage'."=='--') ";
            $checkForStageValue = " || (" .'$stage'.">0) ";
            $searchTitle = "List of PE Investments ";
            $searchAggTitle = "Aggregate Data - PE Investments ";
            $aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
            pecompanies as pec,industry as i where ";
            $samplexls="../xls/Sample_Sheet_Investments.xls";
        }
        elseif($vcflagValue==1)
        {
            $addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";

            $checkForStage = '&& ('.'$stage'.'=="--") ';
            //$checkForStage = " && (" .'$stage'."=='--') ";
            $checkForStageValue =  " || (" .'$stage'.">0) ";
            $searchTitle = "List of VC Investments ";
            $searchAggTitle = "Aggregate Data - VC Investments ";
            $aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
            $samplexls="../xls/Sample_Sheet_Investments(VC Deals).xls";
            //	echo "<br>Check for stage** - " .$checkForStage;
        }
				
        if( $vcflagValue ==0)
        {
            $getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM peinvestments AS pe, pecompanies AS pec
            WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
            AND pec.industry !=15 and pe.AggHide=0 and
            pe.PEId NOT
                    IN (
                    SELECT PEId
                    FROM peinvestments_dbtypes AS db
                    WHERE DBTypeId ='SV'
                    AND hide_pevc_flag =1
                    )";
            $pagetitle="PE Investments -> Search";
            $stagesql_search = "select StageId,Stage from stage ";
            $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
            // echo "<br>***".$industrysql;
        }
        elseif( $vcflagValue ==1)
        {
            $getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                 FROM peinvestments AS pe, stage AS s ,pecompanies as pec
                 WHERE s.VCview =1 and  pe.amount<=20 and pec.industry !=15 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId
                 and pe.Deleted=0
                 and
                 pe.PEId NOT
                         IN (
                         SELECT PEId
                         FROM peinvestments_dbtypes AS db
                         WHERE DBTypeId =  'SV'
                         AND hide_pevc_flag =1
                         )  ";
                 $pagetitle="VC Investments -> Search";
                 $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
                  $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";

                 //echo "<Br>---" .$getTotalQuery;
        }
       
        if ($totalrs = mysql_query($getTotalQuery))
        {
            While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
            {
                         $totDeals = $myrow["totaldeals"];
                         $totDealsAmount = $myrow["totalamount"];
            }
        }
          
        $dbTypeSV="SV";
        $dbTypeIF="IF";
        $dbTypeCT="CT";

        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);
      
        $buttonClicked=$_POST['hiddenbutton'];
        $fetchRecords=true;
        $totalDisplay="";

        if($resetfield=="keywordsearch")
        { 
            $_POST['keywordsearch']="";
            $keyword="";
            $keywordhidden="";
        }
        else 
        {
            $keyword=trim($_POST['keywordsearch']);
            $keywordhidden=trim($_POST['keywordsearch']);
        }
        $keywordhidden =ereg_replace(" ","_",$keywordhidden);

        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $companysearch="";
        }
        else 
        {
            $companysearch=trim($_POST['companysearch']);
        }
        $companysearchhidden=ereg_replace(" ","_",$companysearch);

        if($resetfield=="sectorsearch")
        { 
            $_POST['sectorsearch']="";
            $sectorsearch="";
        }
        else 
        {
            $sectorsearch=trim($_POST['sectorsearch']);
        }
        $sectorsearchhidden=ereg_replace(" ","_",$sectorsearch);

        if($resetfield=="advisorsearch_legal")
        { 
            $_POST['advisorsearch_legal']="";
            $advisorsearchstring_legal="";
        }
        else 
        {
            $advisorsearchstring_legal=trim($_POST['advisorsearch_legal']);
        }
        $advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

        if($resetfield=="advisorsearch_trans")
        { 
            $_POST['advisorsearch_trans']="";
            $advisorsearchstring_trans="";
        }
        else 
        {
            $advisorsearchstring_trans=trim($_POST['advisorsearch_trans']);
        }
        $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

        if($resetfield=="searchallfield")
        { 
            $_POST['searchallfield']="";
            $searchallfield="";
        }
        else 
        {
            $searchallfield=trim($_POST['searchallfield']);
        }
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);

       
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
            $stageval="--";
        }
        else 
        {
            $stageval=$_POST['stage'];
        }

        if($_POST['stage'] && $stageval!="")
        {
            $boolStage=true;
            //foreach($stageval as $stage)
            //	echo "<br>----" .$stage;
        }
        else
        {
            $stage="--";
            $boolStage=false;
        }


        //echo "<br>**" .$stage;
        if($resetfield=="comptype")
        { 
            $_POST['comptype']="";
            $companyType="--";
        }
        else 
        {
            $companyType=trim($_POST['comptype']);
        }

        if($resetfield=="dealtype_debtequity")
        { 
            $_POST['dealtype_debtequity']="";
            $debt_equity="--";
        }
        else 
        {
            $debt_equity=trim($_POST['dealtype_debtequity']);
        }

        if($resetfield=="invType")
        { 
            $_POST['invType']="";
            $investorType="--";
        }
        else 
        {
            $investorType=trim($_POST['invType']);
        }

        if($resetfield=="txtregion")
        { 
            $_POST['txtregion']="";
            $regionId="";
        }
        else 
        {
            $regionId=trim($_POST['txtregion']);
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
//        if($resetfield=="period")
//        {    
//                $_POST['month1']="";
//                $_POST['year1']="";
//                $_POST['month2']="";
//                $_POST['year2']="";
//            }
        $endRangeValueDisplay =$endRangeValue;
        //echo "<br>Stge**" .$range;
        $whereind="";
        $whereregion="";
        $whereinvType="";
        $wherestage="";
        $wheredates="";
        $whererange="";
        $wherelisting_status="";
            
//        if($_POST['year1'] !='' || $_POST['month1']!='')
//        {
//            $syear=$_POST['year1'];
//            $smonth=$_POST['month1'];
//            $fixstart=$_POST['year1'];
//            if($smonth !='')
//            {
//                $startyear=$syear."-".$smonth."-01";
//            }
//            else
//            {
//                 $startyear=$syear."-01-01";
//            }
//        }
//        else
//        {
//            if($type==1)
//            {
//                $month1=1;
//                $year1=1998;
//                $fixstart=1998;
//                $startyear =  $year1."-".$month1."-01";
//            }
//            else 
//            {
//                $month1=1;
//                $year1=2009;
//                 $fixstart=2009;
//                $startyear =  $year1."-".$month1."-01";
//             }   
//        }
//        
//        if($_POST['year2'] =='' || $_POST['month2']=='')
//        {
//            $year2 = date("Y");
//            $month2 = date("m");
//            $endyear = date("Y-m-d");
//            $fixend = date("Y-m-d"); 
//        }
//        else
//        {
//            $year2 = $_POST['year2'];
//            $month2 = $_POST['month2'];
//            $eyear=$_POST['year2'];
//            $emonth=$_POST['month2'];
//            $fixend=$_POST['year2'];
//            if($emonth !='')
//            {
//                 $endyear=$eyear."-12-31";
//            }
//            else
//            {
//                $endyear=$eyear."-". $emonth."-31";
//            }
//        } 
        
        $whereaddHideamount="";
  
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
            {      $stagevaluetext="All Stages";
            
            }
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
                
            if($investorType !="--")
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
            $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
            $splityear1=(substr($year1,2));
            $splityear2=(substr($year2,2));

           if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
            {	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
            }
             //print_r($_POST);
                    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
				 pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide
						 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
						 WHERE dates between '" . $getdt1. "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						  ".$getind." ".$getst." ".$getinvest." ".$getregion." ".$getrange." and pe.Deleted=0" .$addVCFlagqry. " AND pe.PEId NOT
                                                  IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE hide_pevc_flag =1
                                                    ) order by dates DESC";
                                 //echo "<br>all dashboard" .$companysql;
                        }
                      
                        else if(!$_POST){
                         $yourquery=0;
                         $stagevaluetext="";
                         $industry=0;
                  
//                         $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
//                         $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
//                         $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
//                         $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');
//                         $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
//                         $splityear1=(substr($year1,2));
//                         $splityear2=(substr($year2,2));
//
//                       if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
//                       {
//                           $datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
//                            $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
//
//                                $wheredates1= "";
//                        }
                         $dt1 = $year1."-".$month1."-01";
                         $dt2 = $year2."-".$month2."-31";
                         //echo "<br>Query for all records";
                          $companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                          amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
                          pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide
                                          FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
                                          WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                          and pe.Deleted=0" .$addVCFlagqry. " AND pe.PEId NOT
                                           IN (
                                           SELECT PEId
                                           FROM peinvestments_dbtypes AS db
                                           WHERE DBTypeId = '$dbTypeSV'
                                           AND hide_pevc_flag =1
                                           ) order by dates DESC";
                 	    //echo "<br>all records" .$companysql;
			}
			elseif ($companysearch != "" && $sectorsearch =="")
			{
				$yourquery=1;
        			$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				website, city, region, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,AggHide FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND  (pec.companyname LIKE '%$companysearch%') AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
				order by dates DESC";
			//	echo "<br>Query for company search";
		 //echo "<br> Company search--" .$companysql;
			}
			elseif ($companysearch != "" && $sectorsearch !="")
			{
				$yourquery=1;
        			$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				website, city, region, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,AggHide FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND  (pec.companyname LIKE '%$companysearch%' && sector_business LIKE '%$sectorsearch%') AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
				order by dates DESC";
			//	echo "<br>Query for company search";
		 //echo "<br> Company search--" .$companysql;
			}
			elseif ($sectorsearch != "" && $companysearch =="")
			{
				$yourquery=1;
        			$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				website, city, region, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,AggHide FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND (sector_business LIKE '%$sectorsearch%')  AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
				order by dates DESC";
			//	echo "<br>Query for company search";
		 //echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
				$yourquery=1;
				$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="select pe.PECompanyId,pec.companyname,pec.industry,i.industry,sector_business,pe.amount,
				peinv_inv.InvestorId,peinv_inv.PEId,inv.Investor,pe.PECompanyId,pec.industry,
				pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,i.industry,hideamount,SPV,AggHide
			from peinvestments_investors as peinv_inv,peinvestors as inv,
			peinvestments as pe,pecompanies as pec,industry as i,stage as s
			where inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and  pe.StageId=s.StageId and pe.Deleted=0
			and pe.PEId=peinv_inv.PEId and pec.PECompanyId=pe.PECompanyId " .$addVCFlagqry." AND inv.investor like '$keyword%'
                        AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
                        order by dates DESC";


			//echo "<br> Investor search- ".$companysql;
			}
			elseif($advisorsearchstring_legal!="")
			{
                          $stagevaluetext="";
				$yourquery=1;
				$industry=0;
				$datevalueDisplay1="";
			$companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s

				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) )
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s
				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )  )   order by dates DESC";
			//echo "<br>LEGAL -".$companysql;
			}
			elseif($advisorsearchstring_trans!="")
			{
                          $stagevaluetext="";
				$yourquery=1;
				$industry=0;
				$datevalueDisplay1="";
			$companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s
				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_trans%'   and AdvisorType='T'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) )
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s
				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )  )   order by dates DESC";
			//echo "<br>TRANS-".$vcflagValue;
			}
			elseif($searchallfield!="")
			{
				$yourquery=1;
				$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				website, city, region, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,AggHide FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$searchallfield%'
				OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' )
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )

				order by dates DESC";
			//	echo "<bR>---" .$companysql;
			}

			elseif (($industry > 0) || ($companyType!="--") || ($debt_equity!="--") || ($investorType != "--") || ($regionId>0)  || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
				{
					$yourquery=1;

					/*if(($year1<2004) && ($year2>=2004))
                                        {
                                           $exportdt1="2004-".$month1."-01";
                                           $exportdt2 = $year2."-".$month2."-01";
                                        }
                                        elseif(($year1<2004)&&($year2< 2004))
                                        {
                                           //$exportFlag="N";
				           $exportdt1 = "--------";
				           $exportdt2= "--------";
                                        }
                                        elseif(($year1>=2004)&&($year2>=2004))
                                        {

                                         	$exportdt1 = $year1."-".$month1."-01";
  					        $exportdt2 = $year2."-".$month2."-01";
                                        }
                                        elseif(($year1>=2004)&&($year2<2004))
                                        {

                                           $exportdt1 = "------01";
				           $exportdt2= "------01";
                                        }*/
                                        // if($year2<2004)
                                        //   $exportdt2="2004-".$month2."-01";
                                       // else
				        //   $exportdt2 = $year2."-".$month2."-01";
					//echo "<BR>DATE1---" .$dt1;
					/*$dt1 = $year1."-".$month1."-01";
					$dt2 = $year2."-".$month2."-01";*/
                                        $dt1 = $year1."-".$month1."-01";
                                        $dt2 = $year2."-".$month2."-31";
					$companysql = "select pe.PECompanyID,pec.companyname,pec.industry,i.industry,
					pec.sector_business,amount,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
					pec.website,pec.city,pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s where";
				//	echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
						{
							$whereind = " pec.industry=" .$industry ;
							$qryIndTitle="Industry - ";
						}
			//	echo "<br> WHERE IND--" .$whereind;
						if ($regionId > 0)
						{
							$qryRegionTitle="Region - ";
							$whereregion = " pec.RegionId  =".$regionId;
							}
					//	echo " <bR> where REGION--- " .$whereregion;
					        if($companyType!="--" && $companyType!="")
					        {
                                                  $wherelisting_status=" pe.listing_status='".$companyType."'";
                                                  }
						if($debt_equity!="--" && $debt_equity!="")
                                                {  $whereSPVdebt=" pe.SPV='".$debt_equity."'"; }
                                                if ($investorType!= "--")
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
					//	echo "<br>Where stge---" .$wherestage;
						if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
						{
							$startRangeValue=$startRangeValue;
							$endRangeValue=$endRangeValue-0.01;
							$qryRangeTitle="Deal Range (M$) - ";
							if($startRangeValue < $endRangeValue)
							{
								$whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ." and AggHide=0";
							}
							elseif(($startRangeValue = $endRangeValue) )
							{
								$whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
							}
						}
						//echo "<Br>***".$whererange;

						if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
						{
							$qryDateTitle ="Period - ";
							$wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";

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
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}

					//the foll if was previously checked for range
					if($whererange  !="")
					{
						$companysql = $companysql . " pe.hideamount=0 and  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
						pe.Deleted=0 " . $addVCFlagqry . "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                )
                                                order by dates DESC ";
					//	echo "<br>----" .$whererange;
					}
					elseif($whererange="--")
					{
						$companysql = $companysql . "  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
						pe.Deleted=0 " .$addVCFlagqry. "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                )
                                                order by dates DESC ";
					}
                                      //echo   $companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//}
	//END OF POST
	
	

	
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
        $defpage=$vcflagValue;
	include_once('tvheader_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide">Slide Panel</a></div>
    
    <div class="acc_main" id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('refine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
	
	
	 
	
</div>

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
					$totalDisplay="Total";
				    	$industryAdded ="";
				    	$totalAmount=0.0;
				    	$totalInv=0;
						$compDisplayOboldTag="";
						$compDisplayEboldTag="";
				 	  //echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
                                                
                                            if ($companyrs = mysql_query($companysql))
                                            {
                                                $company_cnt = mysql_num_rows($companyrs);
                                            }

				           if($company_cnt > 0)
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
<div class="result-title">
                                            
                        	<?php if(!$_POST){
                                   // echo $VCFlagValue;
                                   if( $vcflagValue ==0)
                                   {
                                     ?>
                                          <h2 id="show-total-deal" style=""></h2><h2>&nbsp;&nbsp;Result For PE Investment</h2>
                                          
                                <?php } 
                                    else
                                    {?>
                                          <h2 id="show-total-deal" style=""></h2><h2> &nbsp;&nbsp;Result For VC Investment</h2>
                                           
                              <?php } if($datevalueDisplay1!=""){ ?>
                                          <ul>
                                              <li> 
                                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          </ul>
                                <?php } }
                                   else 
                                   {
                                   if( $vcflagValue ==0)
                                   { ?>
                                             <h2 id="show-total-deal" style=""></h2><h2> &nbsp;&nbsp;Result For PE Investment</h2>
                                           
                                                <?php }
                                else
                                   {?>
                                            <h2 id="show-total-deal" style=""></h2><h2> &nbsp;&nbsp;Result For VC Investment</h2>
                                              
                                 <?php } ?>
                                
                            <ul>
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ ?>
                                <li>
                                    <?php echo $industryvalue; ?> <a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?> <a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companyType!="--" && $companyType!=null){ ?>
                                <li> 
                                    <?php echo $companyTypeDisplay; ?> <a  onclick="resetinput('comptype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?> <a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($regionId>0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?> <a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?> <a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($datevalueDisplay1!=""){ ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?> <a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($debt_equity!="--" && $debt_equity!=null) { ?>
                                <li> 
                                    <?php echo  $debt_equityDisplay;?> <a  onclick="resetinput('dealtype_debtequity');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?> <a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=""){ ?>
                                <li> 
                                    <?php echo $companysearch?> <a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ ?>
                                <li> 
                                    <?php echo  $sectorsearch?> <a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_legal!="") { ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?> <a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=""){ ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?> <a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ ?>
                                <li> 
                                    <?php echo $searchallfield?> <a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                ?>
                             </ul>
                             <?php } ?>
                                                <br><br><h2 id="show-total-amount" style=""> </h2>
                    <a href="#popup1" class="help-icon"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle"></a>
                    <div class="title-links " id="exportbtn"></div>
                    
                    <div class="alert-note">Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
Target/Company in [] indicates a debt investment. Not included in aggregate data.
            </div>
                        </div>				
<?php

        if($notable==false)
        {

?>
    <div class="overview-cnt">
                        <div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable"><i></i><span>Trend View</span></a></div>

                      <div  id="slidingTable" style="display: block;overflow:hidden;">  
                       <?php
                       include_once("trendviewlatest.php");
                       ?>     
                    </div>
                    </div>
                        <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"   href="index.php?value=0"  id="icon-grid-view"><i></i> List  View</a></li>
                        <?php
                         $count=0;
						 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							if($count == 0)
							{
								 $comid = $myrow["PEId"];
								$count++;
							}
						}
						?>
                        <li><a id="icon-detailed-view" class="postlink" href="dealdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detail View</a></li> 
                        </ul></div>	

										
						<div class="view-table">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th>Company</th>
                                <th>Sector</th>
                                <th>Date</th>
                                <th>Amount</th>
                                </tr></thead>
                              <tbody id="movies">
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
							mysql_data_seek($companyrs,0);
							
							//Code to add PREV /NEXT
							$icount = 0;
							if ($_SESSION['resultId']) 
								unset($_SESSION['resultId']); 
								
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
							   //SPV changed to AggHide
							   $amtTobeDeductedforAggHide=0;
							   $prd=$myrow["dealperiod"];
								if($myrow["AggHide"]==1)
								{
									$openBracket="(";
									$closeBracket=")";
									$amtTobeDeductedforAggHide=$myrow["amount"];
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
									$openBracket="";
									$closeBracket="";
									$amtTobeDeductedforAggHide=0;
									$NoofDealsCntTobeDeducted=0;
								}
                                                                if($myrow["SPV"]==1)          //Debt
								{
									$openDebtBracket="[";
									$closeDebtBracket="]";
									$amtTobeDeductedforDebt=$myrow["amount"];
									$amtTobeDeductedforAggHide= $myrow["amount"];
									$NoofDealsCntTobeDeductedDebt=1;
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
									$openDebtBracket="";
									$closeDebtBracket="";
									$amtTobeDeductedforDebt=0;
									$NoofDealsCntTobeDeductedDebt=0;
								}

								if(trim($myrow[17])=="")
								{
									$compDisplayOboldTag="";
									$compDisplayEboldTag="";
								}
								else
								{
									$compDisplayOboldTag="<b><i>";
									$compDisplayEboldTag="</b></i>";
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
									$hidecount=$hidecount+1;
								}
								else
								{
									$hideamount=$myrow["amount"];
								}
								if($myrow["amount"]==0)
								{
								   $NoofDealsCntTobeDeducted=1;
								}
								if(($vcflagValue==0)||($vcflagValue==1))
								{
									if(trim($myrow["sector_business"])=="")
										$showindsec=$myrow["industry"];
									else
										$showindsec=$myrow["sector_business"];
								}

								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);

					   ?>
								<!--<tbody class="scrollContent">-->
                                  
									<tr>
                                
						<?php
								if(($compResult==0) && ($compResult1==0))
								{
									//Session Variable for storing Id. To be used in Previous / Next Buttons
									$_SESSION['resultId'][$icount++] = $myrow["PEId"];
						?>
                                                                            <td ><?php echo $openDebtBracket;?><?php echo $openBracket ; ?><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo trim($myrow["companyname"]);?>  </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
						<?php
								}
								else
								{
						?>
								<td><?php echo ucfirst("$searchString");?></td>
						<?php
								}
						?>

										<td><?php echo trim($showindsec); ?></td>
										<td><?php echo $prd; ?></td>
										<td><?php echo $hideamount; ?>&nbsp;</td>
										<!--<td>
						<?php
						if(($vcflagValue==0)||($vcflagValue==1))
						{
						?>
										<A href="dealinfo.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "
									   target="popup" onClick="MyWindow=window.open('dealinfo.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>','popup','scrollbars=1,width=580,height=400,status=0,toolbar=no,menubar=no,location=0');MyWindow.focus(top);return false">
									   click here


						<?php
						}

						elseif($vcflagValue==2)
						{
						?>
								<A href="redealinfo.php?value=<?php echo $myrow["PEId"];?> "
								target="popup" onclick="MyWindow=window.open('redealinfo.php?value=<?php echo $myrow["PEId"];?>', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
								click here

						<?php
						}
						?>
								 	</A>   </td>-->
									</tr>
								<!--</tbody>-->
							<?php
								$industryAdded = $myrow[2];
								$totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
								$totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;

							}
						}
						?>
                        </tbody>
                  </table>
                       
                </div>			
			<?php
					}
				} 
			?>
             <div class="holder"></div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
             <div>&nbsp;</div>
            </form>
            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalInv; ?>">
            <form name="pelisting" id="pelisting"  method="post" action="exportinvdeals.php">
                 <?php if($_POST) { ?>
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo ($industryvalue)?$industryvalue:""; ?> >
			<input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthidestage" value=<?php echo $stagevaluetext; ?> >
			<input type="hidden" name="txthidestageid" value=<?php echo $stageidvalue; ?> >
                        <input type="hidden" name="txthidecomptype" value=<?php echo $companyType; ?> >
                        <input type="hidden" name="txthidedebt_equity" value=<?php echo $debt_equity; ?> >
			<input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
			<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
			<input type="hidden" name="txthideregionvalue" value=<?php echo $regionvalue; ?> >
			<input type="hidden" name="txthideregionid" value=<?php echo $regionId; ?> >

			<input type="hidden" name="txthiderange" value=<?php echo $startRangeValue; ?>-<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >

			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
			<input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
                        
                 <?php } else { ?> 
                        
                                               
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryid" value="--">
			<input type="hidden" name="txthidestage" value="">
			<input type="hidden" name="txthidestageid" value="">
                        <input type="hidden" name="txthidecomptype" value="--">
                        <input type="hidden" name="txthidedebt_equity" value="--">
			<input type="hidden" name="txthideinvtype" value="">
			<input type="hidden" name="txthideinvtypeid" value="--">
			<input type="hidden" name="txthideregionvalue" value="">
			<input type="hidden" name="txthideregionid" value="--">

			<input type="hidden" name="txthiderange" value="-----">
			<input type="hidden" name="txthiderangeStartValue" value="--">
			<input type="hidden" name="txthiderangeEndValue" value="--">

                        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value="">
			<input type="hidden" name="txthidecompany" value="">
			<input type="hidden" name="txthideadvisor_legal" value="">
			<input type="hidden" name="txthideadvisor_trans" value="">
			<input type="hidden" name="txthidesearchallfield" value="">
                        
                        
                 <?php } ?>
						                 
                <?php
                if($studentOption==1)
                {
                 ?>
                         <script type="text/javascript" >
                                $("#show-total-deal").html('<h2><?php echo $totalInv; ?></h2>');
                                $("#show-total-amount").html('<h2> Amount (US$ M) <?php echo $totalAmount; ?></h2>');
                            </script>
                            

                <?php
                if($exportToExcel==1 )
                {
                ?>
                  <span style="float:right" class="one">
                  <input class ="export" type="submit"  value="Export" name="showdeals">
                  </span>
                        <div class="title-links" id="exportbtn"></div>
                  <script type="text/javascript">
                        $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                </script>
                <?php
                }
		}
		else
		{
                    if($exportToExcel==1)
                    {
                    ?>
                             <script type="text/javascript" >
                                $("#show-total-deal").html('<h2><?php echo $totalInv; ?> </h2>');
                                $("#show-total-amount").html('<h2> Amount (US$ M) <?php echo $totalAmount; ?></h2>');
                            </script>
                           
                    <?php
                    }
                    else
                    {
                    ?>
                            <div id="headingtextproboldbcolor">&nbsp;No. of Deals - XX &nbsp;&nbsp;&nbsp;&nbsp;Value (US$ M) - YYY <br />Aggregate data for each search result is displayed here for Paid Subscribers <br /></div>
                    <?php
                    }
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                            ?>
                                    <span style="float:right" class="one">
                                    <input class ="export" type="submit"  value="Export" name="showdeals">
                                    </span>
                                    <script type="text/javascript">
					$('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                                    </script>
                                    
                            <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            {
																
                            ?>
                    			<div>
                                    <span>
                                    <b>Note:</b> Only paid subscribers will be able to export data on to Excel.
                                    <span style="float:right" class="one">
                                    <a target="_blank" href="<?php echo $samplexls;?> "><u>Click Here</u> </a> for a sample spreadsheet containing PE investments
                                    </span>
                                    <script type="text/javascript">
						$('#exportbtn').html('<a class="export"  href="<?php echo $samplexls;?>">Export</a>');
                                    </script>
                                    </span>
            					</div>
                    <?php
                            }
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
			
            $('#expshowdeals').click(function(){ 
                    hrefval= 'exportinvdeals.php';
            $("#pelisting").attr("action", hrefval);
            $("#pelisting").submit();
            return false;
            });
			
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                function resetinput(fieldname)
                {
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            </script>
</body>
</html>

<?php
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
