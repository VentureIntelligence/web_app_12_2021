<?php
        require_once("reconfig.php");
         
        $drilldownflag=0;
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
        //$videalPageName="PEIpo";
        $videalPageName="REInv";
        include ('checklogin.php');
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$SelCompRef=$value;
        $newValue=1;
        $getTotalQuery = "select count(IPOId) as totaldeals,sum(IPOSize)as totalamount
			from REipos where Deleted=0 and hideamount=0";
		//	echo "<br>*(((( ".$getTotalQuery;

        if ($totalrs = mysql_query($getTotalQuery))
        {
         While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
           {
                        $totDeals = $myrow["totaldeals"];
                        $totDealsAmount = $myrow["totalamount"];
                }
        }

            $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,RElogin_members as dm
                        where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                }
        }
        
        $yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from REipos order by IPODate desc";
        if($yearSql=mysql_query($yearsql))
        {
                if($type == 1)  
                {
                    if($_POST['year1']=='')
                    {
                        $year1;
                    }
                }
                else
                {
                    if($_POST['year1']=='')
                    {
                        $year1;
                    }
                }
                While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
                {
                        $lastStartYear = $myrow["Year"]."";
                       
                }		
        }
        
                $yearsql="select distinct DATE_FORMAT( IPODate, '%Y') as Year from REipos order by IPODate asc";
                if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$lastEndYear = $myrow["Year"];
				
			}		
		}
 
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
        if(trim($_POST['investorsearch'])!="" ||  trim($_POST['companysearch'])!="")
        {
            $_POST['industry']="";
        }
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
                $year1 = $lastStartYear;
                $month2= 12;
                $year2 = $lastEndYear; 
                $fixstart= $lastStartYear-2;
                $startyear =  $fixstart."-01-01";
                $fixend=$lastEndYear;
                $endyear = $lastEndYear."-12-31";
           
            }     
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= 01; 
             $year1 = $lastStartYear;
             $month2= 12;
             $year2 = $lastEndYear;
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch"))
            {
             $month1= 01; 
             $year1 = $lastStartYear;
             $month2= 12;
             $year2 = $lastEndYear;
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="")
            {
            
             //   if(trim($_POST['searchallfield'])!=""){
                    
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] :01;
                    $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : $lastStartYear;
                    $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : 12;
                    $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : $lastEndYear;
               // }
                
//                if(trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!=""){
//                    $month1=01; 
//                    $year1 = $lastStartYear;
//                    $month2= 12;
//                    $year2 = $lastEndYear;
//                }
            }elseif ((count($_POST['industry']) > 0) || ($_POST['exitstatus']!="--") )
            {
                if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                    $month1=01; 
                    $year1 = 2005;
                    $month2= 12;
                    $year2 = $lastEndYear;
                }else{
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] :01;
                    $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : $lastStartYear;
                    $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : 12;
                    $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : $lastEndYear;
                }
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] :01;
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : ($lastStartYear-2);
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : $lastEndYear;
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

        $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);
      
        $buttonClicked=$_POST['hiddenbutton'];
        $fetchRecords=true;
        $totalDisplay="";

        if($resetfield=="searchallfield")
        { 
            $_POST['searchallfield']="";
            $searchallfield="";
        }
        else 
        {
            $searchallfield=trim($_POST['searchallfield']);
            if($searchallfield != "")
                        {
               
                            $_POST['investorsearch'] = "";   $_POST['investorauto']="";
                            $_POST['companysearch'] = "";   $_POST['companyauto']="";
                        }
        }
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
        if($resetfield=="investorsearch")
        { 
            $_POST['investorsearch']="";
            $keyword="";
            $keywordhidden="";
             $investorauto='';
        }
        else 
        {
            $keyword=trim($_POST['investorsearch']);
            $keywordhidden=trim($_POST['investorsearch']);
            if($keyword!=''){
                $searchallfield='';
        }
             $investorauto=$_POST['investorauto'];
        }
        $keywordhidden =ereg_replace(" ","_",$keywordhidden);

        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $companysearch="";
             $companyauto='';
        }
        else 
        {
            $companysearch=trim($_POST['companysearch']);
            if($companysearch!=''){
                $searchallfield='';
        }
            $companyauto=$_POST['companyauto'];
        }
        $companysearchhidden=ereg_replace(" ","_",$companysearch);
       
        $advisorsearch="";
       
        $industry = array();
        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry=[];
        }
        else 
        {
            $industry=$_POST['industry'];
            if(!empty($industry) && count($industry)>0){
                $searchallfield='';
        }
        }


          if($resetfield=="exitstatus")
                { 
                 $_POST['exitstatus']="";
                 $exitstatusvalue="";
                }
                else 
                {
                 $exitstatusvalue=trim($_POST['exitstatus']);
                    if($exitstatusvalue!='--' && $exitstatusvalue!=''){
                        $searchallfield='';
                }
                }
        
        
                if($exitstatusvalue=="0")
                {$exitstatusdisplay="Partial Exit"; }
                elseif($exitstatusvalue=="1")
                {$exitstatusdisplay="Complete Exit";}
                elseif($exitstatusvalue=="--")
                {$exitstatusdisplay=""; }


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
            $cmonth1= date('n', strtotime(date('Y-m')." -2	 month"));
            $cyear1 = date('Y');
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
                $datevalueDisplay1="";
                $datevalueDisplay2="";
            }
            else
            {
                $datevalueCheck1="";
                $datevalueCheck2="";
                $datevalueDisplay1= $sdatevalueDisplay1;
                $datevalueDisplay2= $edatevalueDisplay2;
            }
            
            
            
       /* if($industry >0)
		{
			$industrysql= "select industry from reindustry where industryid=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
        }*/
                
        if(!empty($industry) && (count($industry) > 0))
        {
            $indusSql = $industryvalue = '';
            foreach($industry as $industrys)
            {
                $indusSql .= " IndustryId=$industrys or ";
		}
            $indusSql = trim($indusSql,' or ');
            $industrysql= "select industry from reindustry where $indusSql";

            if ($industryrs = mysql_query($industrysql))
            {
                While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                {
                        $industryvalue.=$myrow["industry"].',';
                }
            }
            $industryvalue=  trim($industryvalue,',');
            $industry_hide = implode($industry,',');
        }
        
        $aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize)
                                as totalamount from REipos as pe,reindustry as i,pecompanies as pec where";
        $addVCFlagqry = " and pec.industry =15 ";
                    //print_r($_POST);
                if(!$_POST || $companysearch != "" || $keyword !="") {
                       $exitstatusValue = '';
                      }
                    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
				 pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,ExitStatus
						 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
						 WHERE dates between '" . $getdt1. "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						  ".$getind." ".$getst." ".$getinvest." ".$getregion." ".$getrange." and pe.Deleted=0" .$addVCFlagqry. " AND pe.PEId NOT
                                                  IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE hide_pevc_flag =1
                                                    ) ";
                                 //echo "<br>all dashboard" .$companysql;
                        }
                      
                        else if(!$_POST){
                            //&& (trim($advisorsearch)=="")
                            //	echo "<br>Query for all records";
				$yourquery=0;
                                 $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
				$companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                                                    pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate1 , pec.website, pe.city,
                                                    pe.RegionId,r.Region,IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,ExitStatus
                                                    FROM REipos AS pe, reindustry AS i, REcompanies AS pec, region as r
                                                    WHERE  IPODate between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and r.RegionId=pe.RegionId
                                                    and pe.Deleted=0 " .$addVCFlagqry. "  ";
                           //echo "<br>all records" .$companysql;
			}
                        elseif ($searchallfield != "")
			{
			    $yourquery=1;
			    //$datevalueDisplay1="";
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";
                            
                            $searchExplode = explode( ' ', $searchallfield );
                            foreach( $searchExplode as $searchFieldExp ) {
                               
                                $cityLike .= "pec.city REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                $investorLike .= "inv.investor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";        
                            }
                            
                            $cityLike = '('.trim($cityLike,'AND ').')';
                            $companyLike = '('.trim($companyLike,'AND ').')';
                            $sectorLike = '('.trim($sectorLike,'AND ').')';
                            $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                            $investorLike = '('.trim($investorLike,'AND ').')';
                            
                            //$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' or pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                            $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike; 
                            
                            $companysql="SELECT DISTINCT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                            pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate1,
                            pec.website,pe.city, pe.RegionId,r.Region, pe.IPOId,
                            pe.Comment,pe.MoreInfor,pe.hideamount,pe.hidemoreinfor,ExitStatus
                            FROM  REipo_investors as peinv_inv,REinvestors as inv,REipos AS pe, reindustry AS i,
                            REcompanies AS pec,region as r
                            WHERE IPODate between '" . $dt1. "' and '" . $dt2 . "' AND inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid AND pe.IPOId=peinv_inv.IPOId and pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId 
                            AND ( $tagsval ) ";
                            
				
			//	echo "<br>Query for company search";
                        //echo "<br> Company search--" .$companysql;
			}
			elseif ($companysearch != "")
			{
                                $yourquery=1;
				//$datevalueDisplay1="";
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";
				$companysql="SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                                            pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate1,
                                            pec.website,pe.city, pe.RegionId,r.Region, IPOId,
                                            Comment,MoreInfor,hideamount,hidemoreinfor,ExitStatus
                                            FROM REipos AS pe, reindustry AS i,
                                            REcompanies AS pec,region as r
                                            WHERE IPODate between '" . $dt1. "' and '" . $dt2 . "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                            " AND pe.Deleted =0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId AND  pec.PECompanyId IN ($companysearch) 
                                            ";
			}
			elseif($keyword!="")
			{
			    $yourquery=1;
				//$datevalueDisplay1="";
                            $dt1 = $year1."-".$month1."-01";
                            $dt2 = $year2."-".$month2."-31";
				$companysql="select peinv.PECompanyId as PECompanyId,c.companyname,c.industry,i.industry,sector_business,peinv.IPOSize,peinv.IPOAmount,
                                            peinv_inv.InvestorId,peinv_inv.IPOId,inv.Investor,peinv.PECompanyId,
                                            c.companyname,DATE_FORMAT( peinv.IPODate, '%b-%Y' )as IPODate1,i.industry,hideamount,ExitStatus
                                            from REipo_investors as peinv_inv,REinvestors as inv,
                                            REipos as peinv,REcompanies as c,reindustry as i
                                            where IPODate between '" . $dt1. "' and '" . $dt2 . "' and c.industry =15 AND  inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId
                                            and  inv.InvestorId IN ($keyword) ";
                              // echo "<br> Investor search- ".$companysql;
			}
			elseif ((count($industry) > 0) || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")))
				{
					$yourquery=1;

					$dt1 = $year1."-".$month1."-01";
				//	echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,i.industry,
					pec.sector_business,pe.IPOSize,IPOAmount,IPOValuation,DATE_FORMAT(IPODate,'%b-%Y') as IPODate1,
					pec.website,pe.city,IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,ExitStatus
					from REipos as pe, reindustry as i,REcompanies as pec where";
					//echo "<br> individual where clauses have to be merged ";
					/*if ($industry > 0)
						{
							$whereind = " pec.industry=" .$industry ;
							$qryIndTitle="Industry - ";
						}*/
                                        if (count($industry) > 0)
                                        {
                                            $indusSql = '';
                                            foreach($industry as $industrys)
                                            {
                                                $indusSql .= " pec.industry=$industrys or ";
						}
                                            $indusSql = trim($indusSql,' or ');
                                            if($indusSql !=''){
                                                $whereind = ' ( '.$indusSql.' ) ';
                                            }
                                            $qryIndTitle="Industry - ";
                                            $addVCFlagqry='';
                                        }   
                                                
                                                
                                                 if($exitstatusvalue!="--" && ($exitstatusvalue!=""))
                                                    {    
                                                        $whereexitstatus=" pe.ExitStatus='".$exitstatusvalue."'" ." and "; ;
                                                    }else{
                                                        $whereexitstatus='';
                                                    }
                                                
                                                
			//	echo "<br> WHERE IND--" .$whereind;
						/*if ($region!= "--")
							{
								$qryRegionTitle="Region - ";
								$whereregion = " pe.region ='".$region."'";
							}
					//	echo " <bR> where REGION--- " .$whereregion;
						*/
						if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
						{
							$qryDateTitle ="Period - ";
							$wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";

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

					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}
					$companysql = $companysql . " ".$whereexitstatus.  "  i.industryid=pec.industry and
					pec.PEcompanyID = pe.PECompanyID  and
					pe.Deleted=0 " .$addVCFlagqry. " order";
		       		//echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
                $companysql .= " order by IPODate desc, companyname";
                //$companysql .= " order by IPODate desc, companyname";
	 
	$topNav = 'Deals';
	include_once('reipoindex_search.php');
       // echo "<div style='display:none'><br>^^^".$companysql.'</div>';
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div  id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('reiporefine.php');?>
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
        <div class="filter-key-result">  
            <div class="lft-cn"> 
                                            
            <?php if(!$_POST){?>
                                    
                <ul class="result-select closetagspace">
                    <li> 
                        <?php echo "Real Estate";?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                    
                    <?php
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

                <ul class="result-select closetagspace">
                    <?php
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
                    if($cl_count >= 8)
                    {
                    ?>
                    <li class="result-select-close"><a href="/re/reipoindex.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                    <?php
                    }
                    
                    if($industry >0 && $industry!=null){ $drilldownflag=0; ?>
                    <li>
                        <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                    <?php }else{ ?>
                        <li> 
                        <?php echo "Real Estate";?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                    if($keyword!="") { $drilldownflag=0; ?>
                    <li> 
                        <?php echo $investorauto;?><a  onclick="resetinput('investorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                    <?php } 
                    if($companysearch!=""){ $drilldownflag=0; ?>
                    <li> 
                        <?php echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                    <?php }
                    if($searchallfield!=""){ $drilldownflag=0; ?>
                    <li> 
                        <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                    <?php }
                    if($exitstatusdisplay!=''){ ?>
                                <li> 
                                   <?php echo trim($exitstatusdisplay)?><a  onclick="resetinput('exitstatus');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                    <?php } ?>
                 </ul>
                 <?php } ?>
            </div>                                
             <div class="result-rt-cnt">
              
              <div class="result-count">
                <span class="result-amount"></span>
                <span class="result-amount-no" id="show-total-amount"></span> 
                <span class="result-no" id="show-total-deal"> Results Found</span> 
                   
                <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl ?>images/help.png" alt="" style="vertical-align:middle">
                    <span>
                    <img class="callout" src="<?php echo $refUrl ?>images/callout.gif">
                    <strong>Definitions
                    </strong>
                    </span>
                </a>
                <div class="title-links " id="exportbtn"></div>
            </div>      
              
        </div>
    </div> 
       <!-- <div class="alert-note"> <div class="title-links " id="exportbtn"></div></div>
        <div class="list-tab"><ul>
        <li class="active"><a class="postlink"   href="index.php?value=<?php echo $SelCompRef;?>"  id="icon-grid-view"><i></i> List  View</a></li>
        <?php
         $count=0;
                                 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                {
                                        if($count == 0)
                                        {
                                                 $comid = $myrow["IPOId"];
                                                $count++;
                                        }
                                }
                                ?>
        <li><a id="icon-detailed-view" class="postlink" href="reipodealdetails.php?value=<?php echo $comid;?>" ><i></i> Detail View</a></li> 
        </ul></div>-->
       
       </div></div>	
	<a id="detailpost" class="postlink"></a>									
        <div class="view-table view-table-list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                <th style="width: 700px;">Company</th>
                <th style="width: 500px;">Sector</th>
                <th style="width: 300px;">Date</th>
                <th style="width: 227px;">Size(US$M)</th>
                <th style="width: 227px;">Exit Status</th>
                </tr></thead>
              <tbody id="movies">
                <?php
                if($notable==false)
                {
                    if ($company_cnt>0)
                      {
                            $icount=0;$hidecount=0;
                            if ($_SESSION['resultId']) 
                                unset($_SESSION['resultId']); 
                            if ($_SESSION['resultCompanyId']) 
                                unset($_SESSION['resultCompanyId']);
                            mysql_data_seek($companyrs,0);
                            While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                            { 


                              $prd=$myrow["IPODate1"];
                                    if($myrow["hideamount"]==1)
                                    {
                                            $hideamount="--";
                                            $hidecount=$hidecount+1;
                                    }
                                    else
                                    {
                                            $hideamount=$myrow[5];
                                    }
                                    if(trim($myrow["sector_business"])=="")
                                            $showindsec=$myrow["industry"];
                                    else
                                            $showindsec=$myrow["sector_business"];
                                    $_SESSION['resultId'][$icount] = $myrow["IPOId"];
                                    $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                                    
                                    
                                    if($myrow["ExitStatus"]=="0")
                                    {$Exit_Status="Partial Exit"; }
                                    elseif($myrow["ExitStatus"]=="1")
                                    {$Exit_Status="Complete Exit";}
                                    
                                    
                                    $icount++;
                    ?>             <tr class="details_link" valueId="<?php echo $myrow["IPOId"];?>">
                                        <td style="width: 700px;"><a class="postlink" href="reipodealdetails.php?value=<?php echo $myrow["IPOId"];?>"><?php echo trim($myrow["companyname"]);?>  </a></td>
                                        <td style="width: 500px;"><a class="postlink" href="reipodealdetails.php?value=<?php echo $myrow["IPOId"];?>"><?php echo trim($showindsec); ?></a></td>
                                        <td style="width: 300px;"><a class="postlink" href="reipodealdetails.php?value=<?php echo $myrow["IPOId"];?>"><?php echo $prd; ?></a></td>
                                        <td style="width: 227px;"><a class="postlink" href="reipodealdetails.php?value=<?php echo $myrow["IPOId"];?>"><?php echo $hideamount; ?>&nbsp;</a></td>
                                        <td style="width: 227px;"><a class="postlink" href="reipodealdetails.php?value=<?php echo $myrow["IPOId"];?>"><?php echo $Exit_Status; ?>&nbsp;</a></td>
                                    </tr>
                            <?php
                                    $industryAdded = $myrow[2];
                                    $totalInv=$totalInv+1;
                                    $totalAmount=$totalAmount+$hideamount;
                            }
                    }?>
            </tbody>
            </table>
       </div>			
			<?php
					}
                                        if($hidecount==1)
                                        {
                                                $totalAmount="--";
                                        }
				} 
			?>
             <div class="holder"></div>	                 
           <?php
			$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,RElogin_members as dm
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

                if($studentOption==1)
                {
                 ?>
                    <script type="text/javascript" >
                           $("#show-total-deal").html('<?php echo $totalInv; ?> Results found  ');  
                           $("#show-total-amount").html('<h2>Amount (US$ M) <?php 
                           if($totalAmount >0)
                               {
                                   echo number_format(round($totalAmount));
                               }
                               else
                               {
                                   echo "--";
                               }?></h2>');
                    </script>
                    <?php
                    if($exportToExcel==1)
                    {
                    ?>
                        <span style="float:right;margin-right: 20px;" class="one">
                        <input class ="export" type="button" id="expshowdealsbtn"  value="Export" name="showdeals">
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
                                $("#show-total-deal").html('<?php echo $totalInv; ?> Results found ');
                                $("#show-total-amount").html('<h2> Amount (US$ M) <?php 
                                if($totalAmount >0)
                               {
                                   echo number_format(round($totalAmount));
                               }
                               else
                               {
                                   echo "--";
                               }?></h2>');
                            </script>
                           
                    <?php
                    }
                    else
                    {
                    ?>
                            <script type="text/javascript" >
                                $("#show-total-deal").html('XXX Results found ');
                                $("#show-total-amount").html('<h2> Amount (US$ M) YYY</h2>');
                            </script>
                            <div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                            ?>
                                    <span style="float:right;margin-right: 20px;" class="one">
                                    <input class ="export" type="button" id="expshowdealsbtn"  value="Export" name="showipodeals">
                                    </span>
                                    <script type="text/javascript">
					$('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showipodeals">');
                                    </script>
                                    
                            <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            {												
                            ?>
                                    <div>
                                    <span>
                                    <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                                    <span style="float:right;margin-right: 20px;" class="one">
                                         <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                    <a class ="export" target="_blank" href="../xls/sample-pe-backed-IPOs-RE.xls">Sample Export</a>
                                    </span>
                                    <script type="text/javascript">
						$('#exportbtn').html('<a class="export"  href="../xls/sample-pe-backed-IPOs-RE.xls">Export Sample</a>');
                                    </script>
                                    </span>
            					</div>
                    <?php
                            }
              }
    ?>
    </div>
    <div class="overview-cnt mt-trend-tab">
        
                       <div class="showhide-link" id="trendnav" style="z-index: 100000"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i>Trend View</a></div>
                            <div  id="slidingTable" style="display: none;overflow:hidden;">
                               <?php
                                    include_once("reipotrendview.php");
                               ?>   
                               <table width="100%">
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
                                         <div class="showhide-link link-expand-table">
                                            <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
                                         </div><br>
                                         <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
                                            <div class="restable">
                                                <table class="testTable1" cellpadding="0" cellspacing="0" id="restable">
                                                    <tr><td>&nbsp;</td></tr>
                                                </table>
                                            </div>
                                         </div>
                                     </td>
                                    </tr>
                               </table>   
                            </div>
                       </div>
</td>

</tr>
</table>
 
</div>
</form>
            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalInv; ?>">
            <form name="pelisting" id="pelisting"  method="post" action="exportreipodeals.php">
                 <?php if($_POST) {
                     
                     foreach($industry as $indid){ ?>
                         <input type="hidden" name="txthideindustryid[]" value=<?php echo $indid; ?> >
                     <?php }
                ?>
                       <input type="hidden" name="txtsearchon" value="2" >
                <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
		<input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
		<input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
		<input type="hidden" name="txthideexitstatus" value=<?php echo $exitstatusvalue; ?> >

		<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
		<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
		<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

		<input type="hidden" name="txthideinvestor" value=<?php echo $keyword; ?> >
		<input type="hidden" name="txthidecompany" value=<?php echo $companysearch; ?> >
		<input type="hidden" name="txthideadvisor" value=<?php echo $advisorsearch; ?> >
                <input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfield; ?> >
                        
                 <?php } else { 
                        
                     $industry=[];
                                               
                     ?> 
                        
                                               
                        <input type="hidden" name="txtsearchon" value="1" >
           	        <input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
        	        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
			<input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryid[]" value="<?php  $industry; ?>">

                        <input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value="">
			<input type="hidden" name="txthidecompany" value="">
                        <input type="hidden" name="txthideadvisor" value="" >
                        
                        
                 <?php } ?>
		</form>		
<div class=""></div>

</div>

            <script type="text/javascript">
			
            /*$('#expshowdeals').click(function(){ 
                hrefval= 'exportreipodeals.php';
                $("#pelisting").attr("action", hrefval);
                $("#pelisting").submit();
                return false;
            });
            $(".export").click(function(){
                $("#pelisting").submit();
            });*/
    
            $('#expshowdeals').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });

            $('#expshowdealsbtn').click(function(){ 
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });

            function initExport(){ 
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec = <?php echo $totalInv; ?>;

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                            if (currentRec < remLimit){
                                hrefval= 'exportreipodeals.php';
                                $("#pelisting").attr("action", hrefval);
                                $("#pelisting").submit();
                                jQuery('#preloading').fadeOut();
                            }else{
                                jQuery('#preloading').fadeOut();
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem exporting...");
                        }

                    });
                }
    
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
                $(document).on('click', 'tr .details_link', function(){ 

                    idval=$(this).attr("valueId");
                    $("#detailpost").attr("href","http://www.ventureintelligence.com/re/reipodealdetails.php?value="+idval).trigger("click");
                });
            </script>
            
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
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


<?php if($type==1 && $vcflagValue==0){ ?>
    
    <script language="javascript">
	$(document).ready(function(){
		$("#ldtrend").click(function () {
			if($(".show_hide").attr('class')!='show_hide'){
				var htmlinner = $(".profile-view-title").html();
				$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
				//Execute SQL
				$.ajax({
					type : 'POST',
					url  : 'ajxQuery.php',
					dataType : 'json',
					data: {
						sql : '<?php echo addslashes($companysql); ?>',
					},
					success : function(data){
						drawVisualization(data);
						$(".profile-view-title").html(htmlinner);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('There was an error');
					}
				});
			}
		});
	});
	</script>

	
	<script type="text/javascript">
      function drawVisualization(dealdata) {
		
		var data = new google.visualization.DataTable();
		data.addColumn('string','Year');
		data.addColumn('number', 'No of Deals');
		data.addColumn('number', 'Amount($m)');
		data.addRows(dealdata.length);
		for (var i=0; i< dealdata.length ;i++){
			for(var j=0; j< dealdata[i].length ;j++){
				if (j!=0)
					data.setValue(i, j,Math.round(dealdata[i][j]-0));
				else
					data.setValue(i, j,dealdata[i][j]);
			}			
		}
				
		// Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
		
		divwidth  =  document.getElementById("visualization2").offsetWidth;
		divheight =  document.getElementById("visualization2").offsetHight;
		
       function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0&y='+topping;
             <?php if($drilldownflag==1){ ?>             
			 	window.location.href = 'index.php?'+query_string;            
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
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
             
			 //Fill table
			 var pintblcnt = '';
			 var tblCont = '';
			 			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
			 //pintblcnt = pintblcnt + '</thead>';
			 //pintblcnt = pintblcnt + '<tbody>';
			 
			 //tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
			 //tblCont = tblCont + '</thead>';
			 //tblCont = tblCont + '<tbody>';
			 for (var i=0; i< dealdata.length ;i++){
				tblCont = tblCont + '<tr>';
				for(var j=0; j< dealdata[i].length ;j++){
					if (j==0){
						pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
					}
					tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
				}
				tblCont = tblCont + '</tr>';
								
			 }
			 pintblcnt = pintblcnt + '</table>';
			 //tblCont = tblCont + '</tbody>';
			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
			 
			 //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    } else if($type==2 && $vcflagValue==0) {  //  print_r($deal);   

?>
    
    <script language="javascript">
	$(document).ready(function(){
		$("#ldtrend").click(function () {
			if($(".show_hide").attr('class')!='show_hide'){
				var htmlinner = $(".profile-view-title").html();
				$(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
				//Execute SQL
				$.ajax({
					type : 'POST',
					url  : 'ajxQuery.php',
					dataType : 'json',
					data: {
						sql : '<?php echo addslashes($companysql); ?>',
					},
					success : function(data){
						drawVisualization(data);
						$(".profile-view-title").html(htmlinner);
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert('There was an error');
					}
				});
			}
		});
	});
	</script>
    
    
	 <script type="text/javascript">
	 	function in_array(array, id) {
			for(var i=0;i<array.length;i++) {
				if(array[i] == id) {
					return true;
				}
			}
			return false;
		}	 
	 
      	function drawVisualization(dealdata) {  
		
			var data1 = new google.visualization.DataTable();
			data1.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data1.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][2]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);
			
        	// Create and populate the data table.       
       		var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
			divwidth=  document.getElementById("visualization1").offsetWidth;
        	divheight=  document.getElementById("visualization1").offsetHight;
			
       		function selectHandler() {
          		var selectedItem = chart1.getSelection()[0];
          		if (selectedItem) {
            		var topping = data1.getValue(selectedItem.row, 0);
            		var industry = data1.getColumnLabel(selectedItem.column).toString();
            		//alert('The user selected ' + topping +industry);
           
					var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
					<?php if($drilldownflag==1){ ?>
					 window.location.href = 'index.php?'+query_string;
					<?php } ?>
				  }
        	}
    
       		google.visualization.events.addListener(chart1, 'select', selectHandler);
          	chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true,
              });
			  
			  
			//Graph 2
			var data = new google.visualization.DataTable();
			data.addColumn('string','Year');
			for (var i=0; i< dealdata.length ;i++){
				data.addColumn('number',dealdata[i][0]);			
			}
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			arrhead.push('Year');
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			dataArray.push(arrhead);
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			//Data by Year and industry
			var datayear = [];
			
			for(var j=0; j < Years.length ;j++){
				var dataind = [];
				for (var i=0; i< dealdata.length ;i++){
					if (dealdata[i][1]==Years[j]){
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				var arrval = [];
				arrval.push(Years[j]);
				for (var i=1;i<arrhead.length;i++){
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);
			//var data = new google.visualization.DataTable();
			
			var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
		 
			 function selectHandler2() {
			  var selectedItem = chart2.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var industry = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
				var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
				<?php if($drilldownflag==1){ ?>
				 window.location.href = 'index.php?'+query_string;
				<?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart2, 'select', selectHandler2);
			  chart2.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
					isStacked : true
				  }
			  );   
			  
			  
			//Graph 3			
			var data3 = new google.visualization.DataTable();
			data3.addColumn('string','Industry');
			data3.addColumn('number', 'No of Deals');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(dealdata[i][2]-0);
					dataArray.push(temArray);
				}
			}
			
			data3.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data3.setValue(i,0,dataArray[i][0]);
				data3.setValue(i,1,dataArray[i][1]-0);			
			}
			
			
			
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization2')).
			  draw(data3, {title:"No of Deals"/*,
			 colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Graph 4
		
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Industry');
			data4.addColumn('number', 'Amount');
			
			//Remove Duplicate and make sum
			var dataArray = [];
			for (var i=0; i< dealdata.length ;i++){
				dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
				if (dealcnt==0){
					var temArray = [];
					temArray.push(dealdata[i][0]);
					temArray.push(Math.round(dealdata[i][3]-0));
					dataArray.push(temArray);
				}
			}
			
			//console.log(dataArray);
			//console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
    
			// Create and draw the visualization.
			new google.visualization.PieChart(document.getElementById('visualization3')).
			  draw(data4, {title:"Amount"/*,
			  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
			
			
			//Fill table
			
			//Create Head
			var dataArray = [];
			var arrhead = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(arrhead,dealdata[i][0]))
				 arrhead.push(dealdata[i][0]);
			}
			
					
			//Get Years
			var Years = [];
			for (var i=0; i< dealdata.length ;i++){
				if (!in_array(Years,dealdata[i][1]))
				 Years.push(dealdata[i][1]);
			}
			
			
			for(var i=0;i<arrhead.length;i++){
				var tempArr = [];
				for (var j=0; j< dealdata.length ;j++){
					var values = [];
					if (dealdata[j][0]==arrhead[i]){
						if (dealdata[j][2])
							values.push(dealdata[j][2]);
						else
							values.push('0');
							
						if (dealdata[j][3])
							values.push(dealdata[j][3]);
						else
							values.push('0');
							
						tempArr[dealdata[j][1]] =  values;
					}
				}
				dataArray[arrhead[i]] = tempArr;
			}
			
			//console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
			 
          	 tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				 if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
			 //tblCont = tblCont + '</thead>';
			 //tblCont = tblCont + '<tbody>';
			 
			 /*for(i=0;i<dataArray.length;i++){
				 console.log(dataArray[i]);
			 }*/
			var val= [];
			
			for(var i=0;i<arrhead.length;i++){
				tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
				pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
				
				//var flag =0;
				for(var j=0;j<Years.length;j++){
					var deal = '';
					var amt  = '';
					val = dataArray[arrhead[i]][Years[j]];
					if (val){
							deal = val['0'];
							amt = val['1'];
					}
					/*if(flag==1)
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
					else*/
						tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
					//flag =1;
				}
				tblCont = tblCont + '<tr>';
				//console.log(dataArray[arrhead[i]]);
			}
			
			 pintblcnt = pintblcnt + '</table>';
			// tblCont = tblCont + '</tbody>';

			 $('#restable').html(tblCont);
			 $('.pinned').html(pintblcnt);
		}
		
		function dealcount(ind,dataArray,dlCnt){
			var dealcount = 0;
			for(i=0;i<dataArray.length;i++){
				if(dataArray[i][0]==ind){
					dealcount = dataArray[i][1];
					dataArray[i][1] = (dealcount-0) + (dlCnt-0);
				}
			}
			return dealcount;
		}
    </script>
    <? 
     }  
   if($_GET['type']!="")
    { ?>
        <script language="javascript">
		$(document).ready(function(){
                    setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
                    },1000);

                });
        </script>
    <?php }
 mysql_close();
    ?>
 <script type="text/javascript" >
    
     var containerWidth = $('#container').width();  
       var refineWidth = $('#panel').width();                                                                                
       var searchkeyWidth = $('.result-rt-cnt').width();
       var searchTitleWidth = $('.result-title').width();

       var filtersHeight = $('.filter-key-result').height();
       var tabHeight = $('.list-tab').height();
       var alertHeight = $('.alert-note').height();
             
             
            // if (window.innerWidth > 1700)
            // {
            //     var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
            //     $('.result-select').css({"max-width":1190});
            // }
            // else if (window.innerWidth > 1024 )
            // {
            //     var searchTitleHeight = filtersHeight + tabHeight + alertHeight-30;
            //     $('.result-select').css({"max-width":530}); 
            //  }
            // else
            // {
            //     var searchTitleHeight = filtersHeight + tabHeight + alertHeight;
            //     $('.result-select').css({"max-width":390});
                  
            // }
            if (window.innerWidth > 1700)
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
                $('.result-select').css({"max-width":'100%'});
            }
            else if (window.innerWidth > 1024 )
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight-30;
                $('.result-select').css({"max-width":'100%'}); 
             }
            else
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight;
                $('.result-select').css({"max-width":'100%'});
                  
            }
            
            
            //$('.result-cnt').width(containerWidth-refineWidth+188);
            var resultcntHeight = $('.result-cnt').height();
            
            //$('.view-table').css({"margin-top":resultcntHeight});
            $('.expand-table').css({"margin-top":0});
            //$('.view-table').css({"margin-top":window.innerHeight-826});
			       
            var widthval = $('#myTable').width();
            $(".result-cnt").css("width",widthval);
            
            $('.btn-slide').click(function(){ 
                
                $('.result-select').css('width', 'auto');
                $('.alert-note #exportbtn').css('padding', '3px');
                
                var containerWidth = $('#container').width();  
                var refineWidth = $('#panel').width();      
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height(); 
			  
                //$('.result-cnt').width(containerWidth-refineWidth-40)
               // $('.result-select').width(searchTitleWidth-searchkeyWidth-250);
                // if (window.innerWidth > 1700)
                // {
                //     $('.result-select').css({"max-width":1190});
                // }
                // else if (window.innerWidth > 1024 )
                // {
                //     $('.result-select').css({"max-width":530});
                //  }
                // else
                // {
                //     $('.result-select').css({"max-width":390});
                // }
                if (window.innerWidth > 1700)
                {
                    $('.result-select').css({"max-width":'100%'});
                }
                else if (window.innerWidth > 1024 )
                {
                    $('.result-select').css({"max-width":'100%'});
                 }
                else
                {
                    $('.result-select').css({"max-width":'100%'});
                }
             
                if ($('.left-td-bg').width() < 264) {
                    $('.result-cnt').width(containerWidth-refineWidth-40); 

                     var searchTitleHeight = $('.result-cnt').height(); 
                                 //$('.view-table').css({"margin-top":searchTitleHeight});
                                 $('.expand-table').css({"margin-top":0});
                } else {
                    $('.result-cnt').width(containerWidth-refineWidth+188); 
                                //$('.result-select').width(searchTitleWidth-searchkeyWidth);
                               
                     var searchTitleHeight = $('.result-cnt').height(); 	
                                 //$('.view-table').css({"margin-top":searchTitleHeight});
                                 $('.expand-table').css({"margin-top":0});
                } 
            });		 
			 
			
            $(window).resize(function() { 		 
			
                var containerWidth = $('#container').width();   
                var refineWidth = $('#panel').width(); 
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height(); 
                
                //$('.view-table').css({"margin-top":searchTitleHeight});
                $('.expand-table').css({"margin-top":0});
                //$('.result-select').width(searchTitleWidth-searchkeyWidth);
                
                //  if (window.innerWidth > 1700)
                // {
                //     $('.result-select').css({"max-width":1190});
                // }
                // else if (window.innerWidth > 1024 )
                // {
                //     $('.result-select').css({"max-width":530});
                //  }
                // else
                // {
                //     $('.result-select').css({"max-width":390});
                // }
                if (window.innerWidth > 1700)
                {
                    $('.result-select').css({"max-width":'100%'});
                }
                else if (window.innerWidth > 1024 )
                {
                    $('.result-select').css({"max-width":'100%'});
                 }
                else
                {
                    $('.result-select').css({"max-width":'100%'});
                }
                if ($('.left-td-bg').width() < 264) {
                   // $('.result-cnt').width(containerWidth-refineWidth+188);  
                } else {
                   // $('.result-cnt').width(containerWidth-refineWidth-40); 
                } 
            });
            
        <?php /* if(($_SERVER['REQUEST_METHOD']=="GET" )||($_POST))
        { ?>
             $("#panel").animate({width: 'toggle'}, 200); 
             $(".btn-slide").toggleClass("active"); 

             if ($('.left-td-bg').css("min-width") == '264px') {
             $('.left-td-bg').css("min-width", '36px');
             $('.acc_main').css("width", '35px');
             }
             else {
             $('.left-td-bg').css("min-width", '264px');
             $('.acc_main').css("width", '264px');
             } 
        <?php } */?>
       $(document).on('click','#agreebtn',function(){
         $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExport();
        return false; 
     });
                                        
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });                               
    </script>  
 <?php  mysql_close(); ?>