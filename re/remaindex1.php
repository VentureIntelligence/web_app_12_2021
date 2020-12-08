<?php include_once("../globalconfig.php"); ?>
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
        $videalPageName="MAMA";
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
        //print_r($_POST);
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
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= 01; 
             $year1 = date('Y', strtotime(date('Y')." -1  Year"));
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
             $month1=01; 
             $year1 = 2005;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y');
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
       
        $getTotalQuery = "select count(MandAId) as totaldeals,sum(DealAmount)
			as totalamount from REmanda where Deleted=0 and hideamount=0";
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
        where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                }
        }
          
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
            $acquirersearch="";
        }
        else 
        {
            $acquirersearch=trim($_POST['keywordsearch']);
        }
        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $targetcompanysearch="";
        }
        else 
        {
            $targetcompanysearch=trim($_POST['companysearch']);
        }
       	$stringToHide=ereg_replace(" ","-",$targetcompanysearch);

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
            $advisorsearch_legal="";
        }
        else 
        {
            $advisorsearch_legal=trim($_POST['advisorsearch_legal']);
        }
        
         $advisorsearch_legal_hidden=ereg_replace(" ","-",$advisorsearch_legal);

        if($resetfield=="advisorsearch_trans")
        { 
            $_POST['advisorsearch_trans']="";
            $advisorsearch_trans="";
        }
        else 
        {
            $advisorsearch_trans=trim($_POST['advisorsearch_trans']);
            $splitStringAcquirer=explode(" ", $advisorsearch_trans);
            $splitString1Acquirer=$splitStringAcquirer[0];
            $splitString2Acquirer=$splitStringAcquirer[1];
            $stringToHideAcquirer_legal=$splitString1Acquirer. "+" .$splitString2Acquirer;
            
        }
       $advisorsearch_trans_hidden=ereg_replace(" ","-",$advisorsearch_trans);

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

        if($resetfield=="dealtype")
        { 
            $_POST['dealtype']="";
            $dealtype="--";
        }
        else 
        {
            $dealtype=trim($_POST['dealtype']);
        }

       
        if($resetfield=="targetType")
        { 
            $_POST['targetType']="";
            $targetProjectTypeId="--";
        }
        else 
        {
            $targetProjectTypeId=trim($_POST['targetType']);
        }
        
        
        if($targetProjectTypeId==1)
            $entityProjectvalue="Entity";
        elseif($targetProjectTypeId==2)
            $entityProjectvalue="Project / Asset";

        
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
        
        if($resetfield=="targetCountry")
        { 
            $_POST['targetCountry']="";
            $targetCountryId="--";
        }
        else 
        {
            $targetCountryId=trim($_POST['targetCountry']);
        }
         if($resetfield=="acquirerCountry")
        { 
            $_POST['acquirerCountry']="";
            $acquirerCountryId="--";
        }
        else 
        {
            $acquirerCountryId=trim($_POST['acquirerCountry']);
        }
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
            if($dealtype >0)
            {
                    $dealtypesql= "select MADealType from madealtypes where MADealTypeId=$dealtype";
                    if ($dealtypers = mysql_query($dealtypesql))
                    {
                            While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
                            {
                                    $dealtypevalue=$myrow["MADealType"];
                            }
                    }
            }
            if($targetProjectTypeId ==1)
                    $projecttypename="Entity";
            elseif($targetProjectTypeId ==2)
                    $projecttypename="Project / Asset";

            if($targetCountryId !="--" && $targetCountryId !="")
            {
                    $countrySql= "select countryid,country from country where countryid='$targetCountryId'";
                    if ($countryrs = mysql_query($countrySql))
                    {
                            While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                            {
                                    $targetcountryvalue=$myrow["country"];
                            }
                    }
            }


            if($acquirerCountryId !="--" && $acquirerCountryId !="")
            {
                    $AcountrySql= "select countryid,country from country where countryid='$acquirerCountryId'";
                    if ($Acountryrs = mysql_query($AcountrySql))
                    {
                            While($Amyrow=mysql_fetch_array($Acountryrs, MYSQL_BOTH))
                            {
                                    $acquirercountryvalue=$Amyrow["country"];
                            }
                    }
            }
            //echo "<br>***".$startRangeValue;
            //echo "<br>***".$endRangeValue;
            if(($startRangeValue != "--")&& ($endRangeValue != ""))
            {
                    if($startRangeValue==$endRangeValue)
                    {
                            //echo "<br>--EQUALS";
                    }
                    elseif($startRangeValue < endRangeValue)
                    {
                            //echo "<br>--Less than";
                            $startRangeValue=$startRangeValue;
                            $endRangeValue=$endRangeValue-0.01;
                            $rangeText=$myrow["RangeText"];
                    }

            }
                if (!$_POST)
                {
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $yourquery=0;
                        $companysqlFinal = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                                            Amount, MAMAId,Asset,pe.AcquirerId,ac.Acquirer FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                                            WHERE  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0  and ac.AcquirerId=pe.AcquirerId 
                                            and DealDate between '" . $dt1. "' and '" . $dt2 . "' order by companyname";
                        $fetchRecords=true;
                        $fetchAggregate==false;
                }
                elseif ($searchallfield != "")
                {
                $yourquery=1;
                $datevalueDisplay1="";
                        $companysqlFinal="SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                        pe.Amount,MAMAId,Asset,pe.AcquirerId,ac.Acquirer FROM
                        REmama AS pe, 
                        reindustry AS i, 
                        REcompanies AS pec,
                        REacquirers as ac 
                        WHERE 
                        pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                        AND pe.Deleted =0 AND  ( pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' Or ac.Acquirer LIKE '%$searchallfield%' )
                            order by companyname";
                        $fetchRecords=true;
                        $fetchAggregate==false;
                //echo "<br>Query for company search";
        //	 echo "<br> Company search--" .$companysqlFinal;
                }
               elseif ($targetcompanysearch != "")
                {
                $yourquery=1;
                $datevalueDisplay1="";
                        $companysqlFinal="SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                        pe.Amount,MAMAId,Asset,pe.AcquirerId,ac.Acquirer FROM
                        REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                        AND pe.Deleted =0 AND  pec.companyname LIKE '%$companysearch%'
                                order by companyname";
                        $fetchRecords=true;
                        $fetchAggregate==false;
                //echo "<br>Query for company search";
        //	 echo "<br> Company search--" .$companysqlFinal;
                }
                elseif ($sectorsearch != "")
                {
                $yourquery=1;
                $datevalueDisplay1="";
                        $companysqlFinal="SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                        pe.Amount,MAMAId,Asset,pe.AcquirerId,ac.Acquirer FROM
                        REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                        AND pe.Deleted =0 AND  pec.sector_business LIKE '%$sectorsearch%' 
                                order by companyname";
                        $fetchRecords=true;
                        $fetchAggregate==false;
                //echo "<br>Query for company search";
        //	 echo "<br> Company search--" .$companysqlFinal;
                }
                elseif($acquirersearch!="")
                {
                $yourquery=1;
                $datevalueDisplay1="";
                        $companysqlFinal="SELECT peinv.PECompanyId as PECompanyId, peinv.MAMAId,c.companyname, c.industry, i.industry, sector_business,
                        peinv.Amount, peinv.AcquirerId, ac.Acquirer,peinv.Asset
                        FROM REacquirers AS ac, REmama AS peinv, REcompanies AS c, reindustry AS i
                        WHERE ac.AcquirerId = peinv.AcquirerId
                        AND c.industry = i.industryid
                        AND c.PECompanyId = peinv.PECompanyId and peinv.Deleted=0
                        AND ac.Acquirer LIKE '%$acquirersearch%'
                        order by companyname ";

        //		echo "<br> Acquirer search- ".$companysqlFinal;
                }
                elseif($advisorsearch_legal!="")
                {
                        $yourquery=1;
                        $datevalueDisplay1="";

                        $companysqlFinal="(select peinv.MAMAId,peinv.PECompanyId as PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                        cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset
                        from REmama AS peinv, REcompanies AS c, reindustry AS i,REadvisor_cias AS cia,REmama_advisoracquirer AS adac,REacquirers as ac
                        where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and
                        c.PECompanyId=peinv.PECompanyId and adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId   and AdvisorType='L'
                        and cia.cianame LIKE '%$advisorsearch_legal%')
                        UNION
                        (select peinv.MAMAId,peinv.PECompanyId as PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                        cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset
                        from REmama AS peinv, REcompanies AS c, reindustry AS i,REadvisor_cias AS cia,REmama_advisorcompanies AS adcomp,REacquirers as ac
                        where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and
                        c.PECompanyId=peinv.PECompanyId and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='L'
                        and cia.cianame LIKE '%$advisorsearch_legal%')
                        order by companyname";

                //echo "<br> Advisor  search- ".$companysqlFinal;
                }
                elseif($advisorsearch_trans!="")
                {
                        $yourquery=1;
                        $datevalueDisplay1="";

                        $companysqlFinal="(select peinv.MAMAId,peinv.PECompanyId as PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                        cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset
                        from REmama AS peinv, REcompanies AS c, reindustry AS i,REadvisor_cias AS cia,REmama_advisoracquirer AS adac,REacquirers as ac
                        where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and
                        c.PECompanyId=peinv.PECompanyId and adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='T'
                        and cia.cianame LIKE '%$advisorsearch_trans%')
                        UNION
                        (select peinv.MAMAId,peinv.PECompanyId as PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                        cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset
                        from REmama AS peinv, REcompanies AS c, reindustry AS i,REadvisor_cias AS cia,REmama_advisorcompanies AS adcomp,REacquirers as ac
                        where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and
                        c.PECompanyId=peinv.PECompanyId and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='T'
                        and cia.cianame LIKE '%$advisorsearch_trans%')
                        order by companyname";

                //echo "<br> Advisor  search- ".$companysqlFinal;
                }
                elseif (($industry > 0) || ($dealtypeId != "--") || ($targetProjectTypeId!="--") || ($startRangeValue !="--") || ($endRangeValue != "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))|| ($targetCountryId!="--") || ($acquirerCountryId!="--"))
                {
                        $yourquery=1;
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";


                        $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry,
                        sector_business, pe.Amount, pe.MAMAId, i.industry,pec.countryId,c.country,
                        pe.AcquirerId,ac.Acquirer,ac.countryid,pe.Asset
                        FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac

                        where";

                        if ($industry > 0)
                        {
                                $whereind = " pec.industry=" .$industry ;
                        }
                        if ($dealtypeId > 0)
                        {
                                $wheredealtype = " pe.MADealTypeId =" .$dealtypeId;
                        }

                       if($targetProjectTypeId==1)
                               $whereSPVCompanies=" pe.Asset=0";
                        elseif($targetProjectTypeId==2)
                               $whereSPVCompanies=" pe.Asset=1";

                      //         echo "<Br>&&&&&&".$whereSPVCompanies;
                        $acrossDealsDisplay="";
                        if(($startRangeValue != "--") && ($endRangeValue != ""))
                        {

                                if($startRangeValue == $endRangeValue)
                                {
                                //	echo "<br>**********";
                                        $whererange = " pe.Amount = ".$startRangeValue ."";
                                }
                                elseif($startRangeValue < $endRangeValue)
                                {
                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                }
                                elseif($endRangeValue!="--")
                                {
                                        $endRangeValue=50000;
                                        $endRangeValueDisplay=50000;
                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                }

                                $acrossDealsDisplay=1;
                        }
                        if($targetCountryId !="--")
                        {
                                $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
                        }
                        if($acquirerCountryId!="--")
                        {
                                $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
                        }

                        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                        {
                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                        }

                        if ($whereind != "")
                        {
                                $companysql=$companysql . $whereind ." and ";
                                $bool=true;
                        }
                        if (($wheredealtype != ""))
                        {
                                $companysql=$companysql . $wheredealtype . " and " ;
                                $bool=true;
                        }
                        if (($whereSPVCompanies != "") )
                        {
                                $companysql=$companysql .$whereSPVCompanies . " and ";
                                $bool=true;
                        }
                        if (($whererange != "") )
                        {
                                $companysql=$companysql .$whererange . " and ";
                                $bool=true;
                        }
                        if($wheretargetCountry!="")
                        {
                                $companysql=$companysql .$wheretargetCountry . " and ";
                        }
                        if(($wheredates !== "") )
                        {
                                $companysql = $companysql . $wheredates ." and ";
                                $bool=true;
                        }
                        $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                        and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
                        and pe.Deleted=0  order by companyname ";
                        if($whereacquirerCountry!="")
                        {

                                $companysql=$companysql .$whereacquirerCountry . " and ";
                                $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                and  ac.AcquirerId = pe.AcquirerId
                                and pe.Deleted=0  order by companyname ";
                        }


                        $fetchRecords=true;
                        $fetchAggregate==false;
          	//echo "<br><br>WHERE CLAUSE SQL---" .$companysqlFinal;
                }
                else
                {
                        //echo "<br> INVALID DATES GIVEN ";
                        $fetchRecords=false;
                        $fetchAggregate==false;
                }

?>

<?php 
        
	$topNav = 'Deals';
        $defpage=$vcflagValue;
        $investdef=1;
        $stagedef=1;
	include_once('remaheader_search.php');
//        /echo "<br>^^^".$companysql;
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
      <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('remarefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
	    
	
	 
    </div>
</div>

</td>


 <?php
			if($yourquery==1)
                                $queryDisplayTitle="Query:";
                        elseif($yourquery==0)
                                $queryDisplayTitle="";
                                $totalDisplay="Total";
                        if(trim($buttonClicked==""))
                        {
                            $industryAdded ="";
                            $totalAmount=0.0;
                            $totalInv=0;
                                    $compDisplayOboldTag="";
                                    $compDisplayEboldTag="";
                            // echo "<br> query final-----" .$companysql;
                                  /* Select queries return a resultset */
                                     if ($companyrs = mysql_query($companysqlFinal))
                                     {
                                        $company_cnt = mysql_num_rows($companyrs);
                                     }

                               if($company_cnt > 0)
                               {
                                            //$searchTitle=" List of PE Exits - M & A";
                               }
                               else
                               {
                                    $searchTitle= " No Deals(s) found for this search ";
                                    $notable=true;
                               }

		           ?>




<td class="profile-view-left" style="width:100%;">
    

<div class="result-cnt">
			<?php if ($accesserror==1){?>
                            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php">Click here</a></b></div>
				<?php
                        exit; 
                        } 
                ?>
<div class="result-title">
                                            
                        	<?php if(!$_POST){?>
                                <h2>
                                           <span class="result-amount"></span>
                                           <span class="result-amount-no" id="show-total-amount"></span> 
                                            <span class="result-no" id="show-total-deal">Results found</span>
                                
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
                              else { ?> 
                                <h2>
                                    <span class="result-amount"></span>
                                    <span class="result-amount-no" id="show-total-amount"></span> 
                                     <span class="result-no" id="show-total-deal">Results found</span>

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
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=""){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($dealtype!="--" && $dealtype!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $dealtypevalue;?><a  onclick="resetinput('dealtype');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                 
                                 if($targetProjectTypeId!="--" && $targetProjectTypeId!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $projecttypename;?><a  onclick="resetinput('targetType');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                
                                 
                                 if($targetCountryId!="--" && $targetCountryId!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $targetcountryvalue;?><a  onclick="resetinput('targetCountry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                
                                 
                                 if($acquirerCountryId!="--" && $acquirerCountryId!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $acquirercountryvalue;?><a  onclick="resetinput('acquirerCountry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                                if($acquirersearch!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $acquirersearch;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($targetcompanysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $targetcompanysearch?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $sectorsearch?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearch_legal!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearch_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearch_trans!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearch_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                                if($cl_count >= 8)
                                {
                                ?>
                                <li class="result-select-close"><a href="/re/remaindex.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                ?>
                             </ul>
                                        <?php } ?>
                            
                    <div class="alert-note">Note: Target in () indicates sale of asset rather than the company.
            </div>
                        </div>				
<?php

        if($notable==false)
        {

?>
 <div class="overview-cnt mt-trend-tab">
        
                       <div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i>Trend View</a></div>
                            <div  id="slidingTable" style="display: none;overflow:hidden;">
                               <?php
                                    include_once("rematrendview.php");
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
                                         </div>
                                         <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
                                            <div class="restable">
                                                <table class="responsive" cellpadding="0" cellspacing="0" id="restable">
                                                    <tr><td>&nbsp;</td></tr>
                                                </table>
                                            </div>
                                         </div>
                                     </td>
                                    </tr>
                               </table>   
                            </div>
                       </div>
                                     
                        <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"   href="remaindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
                        <?php
                         $count=0;
						 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							if($count == 0)
							{
								 $comid = $myrow["MAMAId"];
								$count++;
							}
						}
						?>
                        <li><a id="icon-detailed-view" class="postlink" href="remadealdetails.php?value=<?php echo $comid;?>" ><i></i> Detail View</a></li> 
                        </ul></div>	

										
						<div class="view-table">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th>Target</th>
                                <th>Acquirer</th>
                                <th>Amount (US$M)</th>
                                </tr></thead>
                              <tbody id="movies">
						<?php
						if ($company_cnt>0)
                                                {


                                                        $acrossDealsCnt=0;
                                                        $icount=0;
                                                          mysql_data_seek($companyrs, 0);
                                                        While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                                        {
                                                                $searchString4="PE Firm(s)";
                                                                $searchString4=strtolower($searchString4);
                                                                $searchString4ForDisplay="PE Firm(s)";
                                                                $searchString="Undisclosed";
                                                                $searchString=strtolower($searchString);
                                                                $companyName=trim($myrow["companyname"]);
                                                                $companyName=strtolower($companyName);
                                                                $compResult=substr_count($companyName,$searchString);
                                                                $compResult4=substr_count($companyName,$searchString4);

                                                                $acquirerName=$myrow["Acquirer"];
                                                                $acquirerName=strtolower($acquirerName);

                                                                $compResultAcquirer=substr_count($acquirerName,$searchString4);
                                                                $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);

                                                                if($compResult==0)
                                                                        $displaycomp=$myrow["companyname"];
                                                                elseif($compResult4==1)
                                                                        $displaycomp=ucfirst("$searchString4");
                                                                elseif($compResult==1)
                                                                        $displaycomp=ucfirst("$searchString");

                                                                if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0))
                                                                        $displayAcquirer=$myrow["Acquirer"];
                                                                elseif($compResultAcquirer==1)
                                                                        $displayAcquirer=ucfirst("$searchString4ForDisplay");
                                                                elseif($compResultAcquirerUndisclosed==1)
                                                                        $displayAcquirer=ucfirst("$searchString");;

                                                                if($myrow["Asset"]==1)
                                                                {
                                                                        $openBracket="(";
                                                                        $closeBracket=")";
                                                                }
                                                                else
                                                                {
                                                                        $openBracket="";
                                                                        $closeBracket="";
                                                                }
                                                                if($myrow["Amount"]==0)
                                                                {
                                                                        $hideamount="";
                                                                }
                                                                else
                                                                {
                                                                        $hideamount=$myrow["Amount"];
                                                                        $acrossDealsCnt=$acrossDealsCnt+1;
                                                                }
                                                                if(trim($myrow["sector_business"])=="")
                                                                        $showindsec=$myrow["industry"];
                                                                else
                                                                        $showindsec=$myrow["sector_business"];

                                                ?>
                                  
                                                <tr>
                                
						<?php
								//Session Variable for storing Id. To be used in Previous / Next Buttons
								$_SESSION['resultId'][$icount] = $myrow["MAMAId"];
                                                                $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                                                                $icount++;
						?>
                                                                <td ><?php echo $openBracket;?><a class="postlink" href="remadealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaycomp; ?> </a> <?php echo $closeBracket ; ?></td>
                                                                <td><?php echo $displayAcquirer; ?></td>
                                                                <td><?php echo $hideamount; ?>&nbsp;</td>
                                                </tr>
							<?php
								$industryAdded = $myrow["industry"];
                                                                $totalInv=$totalInv+1;
                                                                $totalAmount=$totalAmount+ $myrow["Amount"];
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
            <form name="pelisting" id="pelisting"  method="post" action="exportREmeracq.php">
                 <?php if($_POST) { ?>
                
                        <input type="hidden" name="txtsearchon" value="4" >
                        
                        <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthideindustryvalue" value=<?php echo $industryvalue; ?> >
			<input type="hidden" name="txthidedealtype" value=<?php echo $dealtypeId; ?> >
			<input type="hidden" name="txthidedealtypevalue" value=<?php echo $dealtypevalue; ?> >
			<input type="hidden" name="txthideSPV" value=<?php echo $targetProjectTypeId; ?> >

			<input type="hidden" name="txthiderange" value=<?php echo $rangeText; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?> >
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthidecompany" value=<?php echo $stringToHide; ?> >
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearch_legal_hidden; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearch_trans_hidden; ?> >
			<input type="hidden" name="txthideacquirer" value=<?php echo $acquirersearch; ?> >
			<input type="hidden" name="txttargetcountry" value=<?php echo $targetCountryId; ?>>
			<input type="hidden" name="txtacuquirercountry" value=<?php echo $acquirerCountryId; ?>>
                        
                 <?php } else { ?> 
                        <input type="hidden" name="txtsearchon" value="4">

			 <input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value="--">
			<input type="hidden" name="txthideindustryvalue" value="">
			<input type="hidden" name="txthidedealtype" value="--">
			<input type="hidden" name="txthidedealtypevalue" value="">
			<input type="hidden" name="txthideSPV" value="--">

			<input type="hidden" name="txthiderange" value="">
			<input type="hidden" name="txthiderangeStartValue" value="--">
			<input type="hidden" name="txthiderangeEndValue" value="--">
			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthidecompany" value="">
			<input type="hidden" name="txthideadvisor_legal" value="">
			<input type="hidden" name="txthideadvisor_trans" value="">
			<input type="hidden" name="txthideacquirer" value="">
			<input type="hidden" name="txttargetcountry" value="--">
			<input type="hidden" name="txtacuquirercountry" value="--">
                        
                 <?php } ?>
						                 
           <?php
                $totalAmount=round($totalAmount, 0);
                $totalAmount=number_format($totalAmount);
                

			$exportToExcel=0;
                        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,RElogin_members as dm
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
                           $("#show-total-deal").html('<h2> Total No. of Deals  <?php echo $totalInv; ?></h2>');
                           $("#show-total-amount").html('<h2>Announced Value (US$ M) <?php
                            if($totalAmount >0)
                            {
                                echo $totalAmount;
                            }
                            else
                            {
                                echo "--";
                            }?> across  <?php echo $acrossDealsCnt; ?> deals;</h2>');
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
                                $("#show-total-deal").html('<h2> Total No. of Deals  <?php echo $totalInv; ?></h2>');
                                $("#show-total-amount").html('<h2>Announced Value (US$ M) <?php
                                if($totalAmount >0)
                                {
                                    echo $totalAmount;
                                }
                                else
                                {
                                    echo "--";
                                }?> across  <?php echo $acrossDealsCnt; ?> deals;</h2>');
                            </script>
                           
                    <?php
                    }
                    else
                    {
                    ?>
                            <script type="text/javascript" >
                                 $("#show-total-deal").html('<h2> Total No. of Deals XXX</h2>');
                                $("#show-total-amount").html('<h2>Announced Value(US$ M) YYY  across ZZZ deals; </h2>');
                            </script>
                            <div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
                    <?php
                    }
                            if(($totalInv>0) &&  ($exportToExcel==1))
                            {
                            ?>
                                    <span style="float:right" class="one">
                                    <input class ="export" type="submit"  value="Export" name="showmandadeals">
                                    </span>
                                    <script type="text/javascript">
					$('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showmandadeals">');
                                    </script>
                                    
                            <?php
                            }
                            elseif(($totalInv>0) && ($exportToExcel==0))
                            {												
                            ?>
                                    <div>
                                    <span>
                                    <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.  </p>
                                    <span style="float:right" class="one">
                                         <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                    <a class ="export" target="_blank" href="../xls/Sample_merger_acq_data-RE.xls">Sample Export</a>
                                    </span>
                                    <script type="text/javascript">
						$('#exportbtn').html('<a class="export"  href="../xls/Sample_merger_acq_data-RE.xls">Export Sample</a>');
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
                    hrefval= 'exportREmeracq.php';
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

<?php if($type==1){ ?>
    
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
			 	//window.location.href = 'index.php?'+query_string;            
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
                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
             
			 //Fill table
			 var pintblcnt = '';
			 var tblCont = '';
			 			 
			 pintblcnt = '<table><thead>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
			 //pintblcnt = pintblcnt + '</thead>';
			 //pintblcnt = pintblcnt + '<tbody>';
			 
			 tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
			 tblCont = tblCont + '</thead>';
			 tblCont = tblCont + '<tbody>';
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
			 pintblcnt = pintblcnt + '</thead></table>';
			 tblCont = tblCont + '</tbody>';
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
					// window.location.href = 'index.php?'+query_string;
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
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
    "#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
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
				 //window.location.href = 'index.php?'+query_string;
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
					 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46","#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
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
			  draw(data3, {title:"No of Deals",
			   colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
			"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
			
			
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
			  draw(data4, {title:"Amount",
			   colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
			"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
			
			
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
			
			console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table><thead>';
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
			  
			 
			 tblCont = tblCont + '</thead>';
			 tblCont = tblCont + '<tbody>';
			 
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
			
			 pintblcnt = pintblcnt + '</thead></table>';
			 tblCont = tblCont + '</tbody>';

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
     }  else if($type == 4 && $vcflagValue==0){
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
							sql : '<?php echo addslashes($compRangeSql); ?>',
							typ : '4',
							rng : '<?php echo implode('#',$range);?>',
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
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			//Graph 1
			var data1 = google.visualization.arrayToDataTable(dataArray);  
			
			var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
			  var selectedItem = chart6.getSelection()[0];
			  if (selectedItem) {
				var topping = data1.getValue(selectedItem.row, 0);
				var range = data1.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>          //   window.location.href = 'index.php?'+query_string;          
                                               <?php } ?>
			  }
			}
			 google.visualization.events.addListener(chart6, 'select', selectHandler);
			  chart6.draw(data1,
				   {
					title:"No of Deals",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "No of Deals"},
					colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
	"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
					isStacked : true
				  }
	
			  );  
			  
			  
			  
			//Graph 2
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
						dataind[dealdata[i][0]] = dealdata[i][3]-0;
					}
				}
				datayear[j] = dataind;
			}
	
			var arrbody = [];
			for(var j=0;j<Years.length;j++){
				//var totalDeals = 0;
				var arrval = [];
				arrval.push(Years[j]);
				
				//get totlal deal count of the year
				/*for (var i=1;i<arrhead.length;i++){
					totalDeals += datayear[j][arrhead[i]]; 
				}*/
				
				for (var i=1;i<arrhead.length;i++){					
					if (datayear[j][arrhead[i]])
						arrval.push(datayear[j][arrhead[i]]-0);					
					else
						arrval.push(0)
				}
				dataArray.push(arrval);	
			}
			
			var data = google.visualization.arrayToDataTable(dataArray);  
			
			var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
                         function selectHandler2() {
			  var selectedItem = chart7.getSelection()[0];
			  if (selectedItem) {
				var topping = data.getValue(selectedItem.row, 0);
				var range = data.getColumnLabel(selectedItem.column).toString();
				//alert('The user selected ' + topping +industry);
			   
			   var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
				 <?php if($drilldownflag==1){ ?>          //   window.location.href = 'index.php?'+query_string;          
                                               <?php } ?>
			  }
                          }
                          
			 google.visualization.events.addListener(chart7, 'select', selectHandler2);
			  chart7.draw(data,
				   {
					title:"Amount",
					width:500, height:700,
					hAxis: {title: "Year"},
					vAxis: {title: "Amount"},
					colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
	"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
					isStacked : true
				  }
			  );
			
			//Graph 3
			 var data3 = new google.visualization.DataTable();
			  data3.addColumn('string','Stage');
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
				  draw(data3, {title:"No of Deals",
				  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
			"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
			
			
			
			//Graph 4
			var data4 = new google.visualization.DataTable();
			data4.addColumn('string','Stage');
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
			
			console.log(dataArray);
			console.log(dealdata);
			
			data4.addRows(dataArray.length);
			for (var i=0; i< dataArray.length ;i++){
				data4.setValue(i,0,dataArray[i][0]);
				data4.setValue(i,1,dataArray[i][1]-0);			
			}
			
			// Create and draw the visualization.
			  new google.visualization.PieChart(document.getElementById('visualization3')).
				  draw(data4, {title:"Amount",
				  colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
			"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
			
			
			
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
			
			console.log(dataArray);
			
			 var tblCont = '';
			 var pintblcnt = '';
			 
			 pintblcnt = '<table><thead>';
			 pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';
			 
          	 tblCont = '<thead>';
			 tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
			 for (var i=0; i< Years.length ;i++){
				if (i==0){
					 pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
				 }
				tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  tblCont = tblCont + '<tr><th style="text-align:center"></th>';
			 for (var i=0; i< Years.length ;i++){
				tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';		
			 }
			 tblCont = tblCont + '</tr>';
			  
			 
			 tblCont = tblCont + '</thead>';
			 tblCont = tblCont + '<tbody>';
			 
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
				
				//console.log(dataArray[arrhead[i]]);
			}
			
			 
			 tblCont = tblCont + '</tbody>';
			 pintblcnt = pintblcnt + '</thead></table>';

			 $('#restable').html(tblCont);	 
			 $('.pinned').html(pintblcnt);
	
		}
	</script>
       
    <?php }
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
        <?php  if(($_SERVER['REQUEST_METHOD']=="GET" )||($_POST))
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
        <?php } ?>
                                        
    </script>  
