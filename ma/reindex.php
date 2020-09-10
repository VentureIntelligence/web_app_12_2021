<?php
        require_once("reconfig.php");
        $drilldownflag=1;
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        $vCFlagValue=1;
        $VCFlagValue=1;
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
         if($VCFlagValue==1)  // RE Investments
        {
                $getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                FROM REinvestments AS pe, REcompanies AS pec
                WHERE pe.Deleted=0 and hideamount=0   and pe.IndustryId=15
                AND pe.PEcompanyID = pec.PECompanyId ";
                $pagetitle="PE Investments - Real Estate -> Search";
                $stagesql_search="select RETypeId,REType from realestatetypes order by REType";
                 $industrysql_search="select industryid,industry from reindustry";
                 
                $regionsql="select RegionId,Region from region where Region!='' order by RegionId";
        }
        $videalPageName="REInv";
        include ('checklogin.php');
        
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
        if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
        {
            $_POST['industry']="";
            $_POST['stage']="";
            $_POST['comptype']="";
            $_POST['txtregion']="";
            $_POST['invType']="";
            $_POST['EntityProjectType']="";
            $_POST['invrangestart']="";
            $_POST['invrangeend']="";
        }
       /* elseif(trim($_POST['industry'])!="" || trim($_POST['stage'])!="" || trim($_POST['comptype'])!="" || trim($_POST['txtregion'])!="" || trim($_POST['invType'])!="" || trim($_POST['EntityProjectType'])!="" || trim($_POST['invrangestart'])!="" || trim($_POST['invrangeend'])!="")
        {
            $_POST['searchallfield']="";
            $_POST['keywordsearch']="";
            $_POST['sectorsearch']="";
            $_POST['companysearch']="";
            $_POST['advisorsearch_legal']="";
            $_POST['advisorsearch_trans']="";
        }
        print_r($_POST);*/
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
           // echo "1";
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
                $month1= 01;
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
                $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= 01; 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")|| ($resetfield=="sectorsearch") ||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= 01; 
             $year1 =  date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
             $month1=01; 
             $year1 = 2005;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : 01;
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));;
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
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
  
        if($compId==$companyId)
        { 
           $hideIndustry = " and display_in_page=1 "; 

        }
        else
        {
           $hideIndustry="";     
        }
       
        
       
        if ($totalrs = mysql_query($getTotalQuery))
        {
         While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
           {
                        $totDeals = $myrow["totaldeals"];
                        $totDealsAmount = $myrow["totalamount"];
                        $totalAmount=round($totDealsAmount, 0);
                        $totalAmount=number_format($totalAmount);

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
            $splitStringAcquirer=explode(" ", $advisorsearchstring_legal);
            $splitString1Acquirer=$splitStringAcquirer[0];
            $splitString2Acquirer=$splitStringAcquirer[1];
            $stringToHideAcquirer_legal=$splitString1Acquirer. "+" .$splitString2Acquirer;
            
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
       $stageCnt=0;
        $cnt=0;
        $stageCntSql="select count(RETypeId) as cnt from realestatetypes";
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
                $stagesql= "select REType from realestatetypes where RETypeId=$stageid";
                //	echo "<br>**".$stagesql;
                if ($stagers = mysql_query($stagesql))
                {
                    While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                    {
                            $cnt=$cnt+1;
                            $stagevaluetext= $stagevaluetext. ",".$myrow["REType"] ;
                    }
                }
            }
            $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
            if($cnt == $stageCnt)
            {      $stagevaluetext="All Stages";
            
            }
        }
        else
            $stagevaluetext="";
        if($getstage !='')
        {
            $stagevaluetext = $getstage;
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
        if($resetfield=="invType")
        { 
            $_POST['invType']="";
            $investorType="";
        }
        else 
        {
            $investorType=trim($_POST['invType']);
        }
        
        if($resetfield=="EntityProjectType")
        { 
            $_POST['EntityProjectType']="";
            $entityProject="--";
        }
        else 
        {
            $entityProject=trim($_POST['EntityProjectType']);
        }
        if($entityProject==1)
            $entityProjectvalue="Entity";
        elseif($entityProject==2)
            $entityProjectvalue="Project";

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
        $endRangeValueDisplay =$endRangeValue;
        //echo "<br>Stge**" .$range;
        $whereind="";
        $whereregion="";
        $whereinvType="";
        $wherestage="";
        $wheredates="";
        $whererange="";
        $wherelisting_status="";
        $whereaddHideamount="";
     
                 
            $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
            $splityear1=(substr($year1,2));
            $splityear2=(substr($year2,2));

           if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
            {
                $sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                $edatevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                $wheredates1= "";
            }
            
            $cmonth1= 01;
            $cyear1 = date('Y', strtotime(date('Y')." -1  Year"));
            $cmonth2= date('n');
            $cyear2 = date('Y');
            $csplityear1=(substr($cyear1,2));
            $csplityear2=(substr($cyear2,2));
            $sdatevalueCheck1 = returnMonthname($cmonth1) ." ".$csplityear1;
            $edatevalueCheck2 = returnMonthname($cmonth2) ."  ".$csplityear2;
            
            if($sdatevalueDisplay1 == $sdatevalueCheck1)
            {
                $datevalueCheck1=$sdatevalueCheck1;
                $datevalueCheck2=$edatevalueCheck2;
                $datevalueDisplay1=="";
                $datevalueDisplay2=="";
            }
            else
            {
                $datevalueCheck1=="";
                $datevalueCheck2=="";
                $datevalueDisplay1= $sdatevalueDisplay1;
                $datevalueDisplay2= $edatevalueDisplay2;
            }
            
            
            if($industry >0)
		{
			$industrysql= "select industry from reindustry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}

		if($stage >0)
		{
			$stagesql= "select REType from realestatetypes where RETypeId=$stage";

			if ($stagers = mysql_query($stagesql))
			{
				While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$stagevalue=$myrow["REType"];
				}
			}
		}
		
		if($regionId >0)
				{
					$regionsql= "select Region from region where RegionId=$regionId";
					if ($regionrs = mysql_query($regionsql))
					{
						While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$regionvalue=$myrow["Region"];
						}
					}
		}

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

		if($entityProject==1)
		    $entityProjectvalue="Entity";
		elseif($entityProject==2)
		    $entityProjectvalue="Project";

                if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";
            
                if($vcflagValue==0)
                {
                        //$addVCFlagqry = " and pec.industry !=15 ";
                        $addVCFlagqry = "";
                        $checkForStage = ' && ('.'$stage'.' =="--")';
                        //$checkForStage = " && (" .'$stage'."=='--') ";
                        $checkForStageValue = " || (" .'$stage'.">0) ";
                        $searchTitle = "List of PE Investments ";
                        $searchAggTitle = "Aggregate Data - PE Investments ";
                        $aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
                        recompanies as pec,industry as i where ";
                }
                elseif($vcflagValue==1)
                {
                        //$addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";
                        $addVCFlagqry = " and s.VCview=1 and pe.amount <=20 ";

                        $checkForStage = '&& ('.'$stage'.'=="--") ';
                        //$checkForStage = " && (" .'$stage'."=='--') ";
                        $checkForStageValue =  " || (" .'$stage'.">0) ";
                        $searchTitle = "List of VC Investments ";
                        $searchAggTitle = "Aggregate Data - VC Investments ";
                        $aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                        FROM REinvestments AS pe,REcompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
                //	echo "<br>Check for stage** - " .$checkForStage;
                }
                elseif($vcflagValue==2)
                {
                        //$addVCFlagqry = " and pec.industry =15 ";
                        $checkForStage = "";
                        $checkForStageValue = "";
                        $searchTitle = "List of PE Investments - Real Estate";
                        $searchAggTitle = "Aggregate Data - PE Investments - Real Estate";
                        $aggsql= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                        FROM REinvestments AS pe, REcompanies AS pec,industry as i where	";
                }
            
                    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
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
                               $dt1 = $year1."-".$month1."-01";
                               $dt2 = $year2."-".$month2."-31";
				 $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				 amount, round, s.REType,  stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod, pec.website, pec.city,
				PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity ,AggHide
						 FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
						 WHERE pe.IndustryId = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and pe.Deleted=0" .$addVCFlagqry." and dates between '" . $dt1. "' and '" . $dt2 . "' order by companyname";
				   //echo "<br>all records" .$companysql;
			}
                        elseif ($searchallfield != "")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
                                
                                $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				pec.website, pec.city, pec.region, pe.PEId,
				pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s,REinvestments_investors as peinv_inv,REinvestors as inv
				WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
				AND inv.InvestorId=peinv_inv.InvestorId and pe.PEId=peinv_inv.PEId and pe.Deleted =0 AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
				OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' or inv.investor like '$searchallfield%')
				order by companyname";
			//	echo "<br>Query for company search";
                       //echo "<br> Company search--" .$companysql;
			}
			elseif ($companysearch != "")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId  as PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
				website, pec.city, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity,AggHide
				FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s
				WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$companysearch%' )
				order by companyname";
			//	echo "<br>Query for company search";
			// echo "<br> Company search--" .$companysql;
			}
                        elseif ($sectorsearch != "")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId  as PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
				website, pec.city, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity,AggHide
				FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s
				WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND ( sector_business LIKE '%$sectorsearch%')
				order by companyname";
			//	echo "<br>Query for company search";
			// echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
				$companysql="select pe.PECompanyId  as PECompanyId,pec.companyname,pe.IndustryId,i.industry,pe.sector,pe.amount,
				peinv_inv.InvestorId,peinv_inv.PEId,inv.Investor,pe.PECompanyId,pec.industry,
				pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,i.industry,hideamount,SPV,s.REType,pe.city as dealcity,AggHide
			from REinvestments_investors as peinv_inv,REinvestors as inv,
			REinvestments as pe,REcompanies as pec,reindustry as i,realestatetypes as s
			where inv.InvestorId=peinv_inv.InvestorId and pe.IndustryId = i.industryid and  pe.StageId=s.RETypeId and pe.Deleted=0
			and pe.PEId=peinv_inv.PEId and pec.PECompanyId=pe.PECompanyId " .$addVCFlagqry." AND inv.investor like '$keyword%' order by companyname";
			//echo "<br> Investor search- ".$companysql;
			}
			elseif($advisorsearchstring_legal!="")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
			$companysql="(
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide ,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
				AND cia.cianame LIKE '$advisorsearchstring_legal%'
				)
				UNION (
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid	AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
				AND cia.cianame LIKE '$advisorsearchstring_legal%'
				)";
			//echo "<Br>ADvisor search--" . $companysql;
			}
			elseif($advisorsearchstring_trans!="")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
			$companysql="(
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide ,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
				AND cia.cianame LIKE '$advisorsearchstring_trans%'
				)
				UNION (
				SELECT peinv.PEId,peinv.PECompanyId  as PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide ,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid	AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
				AND cia.cianame LIKE '$advisorsearchstring_trans%'
				)";
				//echo "<Br>Trans search--" . $companysql;
		       }
                      
			elseif (($industry > 0) || ($invType !="--") || ($companyType!="--") || ($regionId> 0) ||  ($entityProject!="--") || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
				{
				    $yourquery=1;

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.PECompanyID  as PECompanyId,pec.companyname,pe.IndustryId,i.industry,
					pe.sector,amount,round,s.REType,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
					pec.website,pec.city,pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity,AggHide
					from REinvestments as pe, reindustry as i,REcompanies as pec,realestatetypes as s,region as r where";
				//	echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
                                        {
                                                $whereind = " pe.IndustryId=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                //	echo "<br> WHERE IND--" .$whereind;
                                        if ($regionId > 0 )
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pe.RegionId= $regionId ";
                                        }
                                //	echo " <bR> where REGION--- " .$whereregion;
                                        if($companyType!="--" && $companyType!="")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                          }
                                        if ($investorType !="--" && $investorType!="" && $investorType!=" ")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType ='".$investorType."'";
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

                                        if($entityProject==1)
                                                $whereSPVCompanies=" pe.SPV=0";
                                        elseif($entityProject==2)
                                                $whereSPVCompanies=" pe.SPV=1";


                                //	echo "<br>Where stge---" .$wherestage;
                                        if (($startRangeValue!= "--") && ($endRangeValue != ""))
                                        {
                                                $startRangeValue=$startRangeValue;
                                                $endRangeValue=$endRangeValue-0.01;
                                                $qryRangeTitle="Deal Range (M$) - ";
                                                if($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ." and AggHide=0";
                                                }
                                                elseif($startRangeValue = $endRangeValue)
                                                {
                                                        $whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
                                                }
                                        }

                                        if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
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
					if($whereregion!="")
					{
						$companysql=$companysql .$whereregion . " and ";
					}

					if (($wherestage != ""))
						{
							$companysql=$companysql . $wherestage . " and " ;
							$aggsql=$aggsql . $wherestage ." and ";
							$bool=true;
						}

					if (($whereInvType != "") )
						{
							$companysql=$companysql .$whereInvType . " and ";
							$aggsql = $aggsql . $whereInvType ." and ";
							$bool=true;
						}
					if (($whereSPVCompanies != "") )
						{
							$companysql=$companysql .$whereSPVCompanies . " and ";
							$aggsql = $aggsql . $whereSPVCompanies ." and ";
							$bool=true;
						}
					if($wherelisting_status!="")
                                        	{
                                                 $companysql=$companysql .$wherelisting_status . " and ";
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
						$companysql = $companysql . " pe.hideamount=0 and  i.industryid=pe.IndustryId and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId and
						pe.Deleted=0 " . $addVCFlagqry . " order by companyname ";
					//	echo "<br>----" .$whererange;
					}
					elseif($whererange!="--")
					{
						$companysql = $companysql . "  i.industryid=pe.IndustryId and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId and
						pe.Deleted=0 " .$addVCFlagqry. " order by companyname ";
				//		echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
					}
                                    //echo "<br>^^^".$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//END OF POST
        $topNav = 'Deals';
        $defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
	include_once('reheader_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
      <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('rerefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>
</div>
</td>
 <?php
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
			<?php if ($accesserror==1){?>
                            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm">Click here</a></b></div>
				<?php
                        exit; 
                        } 
                ?>
<div class="result-title">
                                            
                        	<?php if(!$_POST){?>
                                    <h2>
                                 <?php
                                   if( $vcflagValue ==0)
                                   {
                                     ?>
    
                                          
                                           <span class="result-amount"></span>
                                           <span class="result-amount-no" id="show-total-amount"></span> 
                                            <span class="result-no" id="show-total-deal">Results found</span>
                                <?php } 
                                    else
                                    {?>
                                         
                                           <span class="result-amount"></span>
                                            <span class="result-amount-no" id="show-total-amount"></span>
                                              <span class="result-no" id="show-total-deal">Results found </span>
                                    <?php } 
                                          ?>
                                   </h2>
                                          <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout" src="<?php echo $refUrl; ?>images/callout.gif">
                                             <strong>Definitions
                                             </strong>
                                             </span>
                                        </a>
                              <div class="title-links " id="exportbtn"></div>
                               <ul class="result-select">
                                   <?php
                                if($stagevaluetext!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $stagevaluetext;?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          
                                <?php }
                                 if (($getrangevalue!= "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$getrangevalue; ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if (($getinvestorvalue!= "")){ ?>
                                <li> 
                                    <?php echo $getinvestorvalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if (($getregionevalue != "")){ ?>
                                <li> 
                                    <?php echo $getregionevalue ; ?><a  onclick="resetinput('txtregion');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                        if($getindusvalue!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $getindusvalue;?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                <?php }
                                  if($datevalueDisplay1!=""){  
                                         ?>
                                        <li> 
                                          <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                <?php }
                                else if($datevalueCheck1 !="")
                                {
                                ?>
                                    <li style="padding:1px 10px 1px 10px;"> 
                                      <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                    </li>
                                <?php 
                                }
                                ?>
                               </ul>
                              <?php            
                              }
                                   else 
                                   {  ?> 
                                        <h2>
                                       <?php 
                                   if( $vcflagValue ==0)
                                   {
                                     ?>
    
                                          <span class="result-amount"></span>
                                            <span class="result-amount-no" id="show-total-amount"></span>
                                              <span class="result-no" id="show-total-deal">Results found </span>
                                    
                                          
                                <?php } 
                                    else
                                    {?>
                                            <span class="result-amount"></span>
                                            <span class="result-amount-no" id="show-total-amount"></span>
                                              <span class="result-no" id="show-total-deal">Results found </span>
                                <?php } ?>
                                            
                                   </h2>
                                        <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout" src="images/callout.gif">
                                             <strong>Definitions
                                             </strong>
                                             </span>
                                        </a>
                                          
                              
                            <div class="title-links " id="exportbtn"></div>
                            <ul class="result-select">
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($stagevaluetext!="" && $stagevaluetext!=null) { $drilldownflag=0;?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companyType!="--" && $companyType!=null){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companyTypeDisplay; ?><a  onclick="resetinput('comptype');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($investorType !="--" && $investorType!=null){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId>0){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($datevalueDisplay1!=""){  ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                else if($datevalueCheck1 !="")
                                {
                                 ?>
                                 <li style="padding:1px 10px 1px 10px;"> 
                                    <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?>
                                </li>
                                <?php
                                }
                                if($entityProject!="--" && $entityProject!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $entityProjectvalue;?><a  onclick="resetinput('EntityProjectType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($keyword!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companysearch?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $sectorsearch?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_legal!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                ?>
                             </ul>
                                        <?php } ?>
                    <div class="alert-note">Note: Note: Target in () indicates sale of SPV/ Project rather than the company.
            </div>
                        </div>				
<?php
        if($notable==false)
        {
?>  
    <div class="overview-cnt mt-trend-tab">
        
                        <div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? 'active' : ''; ?>" rel="#slidingTable"><i></i><span>Trend View</span></a></div>

                      <div  id="slidingTable" style="display: block;overflow:hidden;">  
                       <?php
                            include_once("trendviewre.php");
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
                        <li><a id="icon-detailed-view" class="postlink" href="redealdetails.php?value=<?php echo $comid;?>" ><i></i> Detail View</a></li> 
                        </ul></div>	

										
						<div class="view-table">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th>Company</th>
                                <th>City</th>
                                <th style="width: 150px;">Date</th>
                                <th>Amount</th>
                                </tr></thead>
                              <tbody id="movies">
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
						  	$acrossDealsCnt=0;
                                                         mysql_data_seek($companyrs,0);
                                                         $icount = 0;
                                                        if ($_SESSION['resultId']) 
                                                           unset($_SESSION['resultId']); 
                                                         if ($_SESSION['resultCompanyId']) 
                                                           unset($_SESSION['resultCompanyId']); 
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
                                                                $amtTobeDeductedforAggHide=0;
                                                                $prd=$myrow["dealperiod"];
								if($myrow["SPV"]==1)
								{
									$openBracket="(";
									$closeBracket=")";
								}
								else
								{
									$openBracket="";
									$closeBracket="";
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
								if($myrow["REType"]!="")
								{
									$showindsec=$myrow["REType"];
								}
								else
								{
									$showindsec="&nbsp;";
								}

								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);

								if($myrow["amount"]==0)
								{
									$hideamount="";
									$amountobeAdded=0;
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="";
									$amountobeAdded=0;

								}
								elseif($myrow["hideamount"]==0)
								{
									$hideamount=$myrow["amount"];
                                                                        $acrossDealsCnt=$acrossDealsCnt+1;
									$amountobeAdded=$myrow["amount"];
								}
                                                ?>
                                  
                                                <tr>
                                
						<?php
								if(($compResult==0) && ($compResult1==0))
								{
									//Session Variable for storing Id. To be used in Previous / Next Buttons
									$_SESSION['resultId'][$icount] = $myrow["PEId"];
                                                                        $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                                                                        $icount++;
						?>
                                                                            <td ><?php echo $openBracket;?><a class="postlink" href="redealdetails.php?value=<?php echo $myrow["PEId"];?>"><?php echo trim($myrow["companyname"]);?>  </a> <?php echo $closeBracket ; ?></td>
						<?php
								}
								else
								{
						?>
								<td><?php echo ucfirst("$searchString");?></td>
						<?php
								}
						?>

										<td><?php echo $myrow["city"]; ?></td>
										<td><?php echo $prd; ?></td>
										<td align=right><?php echo $hideamount; ?>&nbsp;</td>
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
								$totalInv=$totalInv+1;
								$totalAmount=$totalAmount+ $amountobeAdded;

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
            <form name="pelisting" id="pelisting"  method="post" action="exportreinvdeals.php">
                 <?php if($_POST) { ?>
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
                        <input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo ($industryvalue)?$industryvalue:""; ?> >
			<input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthidestage" value=<?php echo $stagevalue; ?> >
                        <input type="hidden" name="txthideSPVCompany" value=<?php echo $entityProject; ?> >
			<input type="hidden" name="txthideSPVCompanyValue" value=<?php echo $entityProjectvalue; ?> >
                        <input type="hidden" name="txthidestage" value=<?php echo $stagevaluetext; ?> >
			<input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
			<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
                        <input type="hidden" name="txthidecomptype" value=<?php echo $companyType; ?> >
			<input type="hidden" name="txthiderange" value=<?php echo $startRangeValue; ?>-<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthideregionid" value=<?php echo $regionId; ?> >
			<input type="hidden" name="txthideregionvalue" value=<?php echo $regionvalue; ?> >


			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
			<input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
                        
			<input type="hidden" name="txthideadvisorstring_legal" value=<?php echo $stringToHideAcquirer_legal; ?> >
                        
                 <?php } else { ?> 
                        
                                               
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
			<input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryid" value="--">
			<input type="hidden" name="txthidestage" value="">
			<input type="hidden" name="txthidestageid" value="">
                        <input type="hidden" name="txthidecomptype" value="--">
                        <input type="hidden" name="txthidedebt_equity" value="--">
                        <input type="hidden" name="txthideSPVCompany" value="--" >
			<input type="hidden" name="txthideSPVCompanyValue" value="" >
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
                        <input type="hidden" name="txthideadvisorstring_legal" value="" >
                        
                        
                 <?php } ?>
						                 
           <?php
           $exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}
                        $totalAmount=round($totalAmount, 0);
			$totalAmount=number_format($totalAmount);
                if($studentOption==1)
                {
                 ?>
                    <script type="text/javascript" >
                           $("#show-total-deal").html('<h2> Total No. of Deals <?php echo $totalInv; ?></h2>');
                           $("#show-total-amount").html('<h2>Announced Value(US$ M) <?php echo $totalAmount; ?>  across  <?php echo $acrossDealsCnt; ?> deals</h2>');
                    </script>
                    <?php
                    if($exportToExcel==1)
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
                                $("#show-total-deal").html('<h2> Total No. of Deals <?php echo $totalInv; ?></h2>');
                                $("#show-total-amount").html('<h2>Announced Value(US$ M) <?php echo $totalAmount; ?>  across  <?php echo $acrossDealsCnt; ?> deals</h2>');
                            </script>
                           
                    <?php
                    }
                    else
                    {
                    ?>
                            <script type="text/javascript" >
                                $("#show-total-deal").html('<h2> Total No. of Deals XXX</h2>');
                                $("#show-total-amount").html('<h2>Announced Value(US$ M) YYY  across ZZZ deals</h2>');
                            </script>
                            <div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
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
                                    <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                                    <span style="float:right" class="one">
                                         <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                    <a class ="export" target="_blank" href="<?php echo $samplexls;?> ">Sample Export</a>
                                    </span>
                                    <script type="text/javascript">
						$('#exportbtn').html('<a class="export"  href="<?php echo $samplexls;?>">Export Sample</a>');
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
                    hrefval= 'exportreinvdeals.php';
            $("#pelisting").attr("action", hrefval);
            $("#pelisting").submit();
            return false;
            });
			
                $("a.postlink").click(function(){
                  
                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
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
 
 mysql_close();
?>
