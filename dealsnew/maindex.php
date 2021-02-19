<?php include_once("../globalconfig.php"); ?>
  <?php
  require_once("../dbconnectvi.php");
  $Db = new dbInvestments();
  if(!isset($_SESSION['UserNames']))
  {
          header('Location:../pelogin.php');
  }
  else
  {
        $drilldownflag=1;
        $companyId=632270771;
        $compId=0;
        require_once("../dbconnectvi.php");//including database connectivity file
        $Db = new dbInvestments();
        ob_start();
        $videalPageName="MAMA"; 
        include ('machecklogin.php');
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] : 1; //get trendview type
        $getyear = $_REQUEST['y'];
        $getsy = $_REQUEST['sy'];
        $getey = $_REQUEST['ey'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
        {
            $_POST['industry']="--";
            $_POST['stage']="--";
            $_POST['dealtype']="--";
            $_POST['targetcompanytype']="--";
            $_POST['acquirercompanytype']="--";
            $_POST['invrangestart']="--";
            $_POST['invrangeend']="--";
            $_POST['targetCountry']="--";
            $_POST['acquirerCountry']="--";
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
        
        $resetfield=$_POST['resetfield'];//reset post value
        
        //condition for date parameter. Both get and post value
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
             $year1 = 1998;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : 01;
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
        
        $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,malogin_members as dm where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
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
        
        //show deals by POST values
        if($resetfield=="keywordsearch")
        { 
            $_POST['keywordsearch']="";
            $acquirersearch="";
            $acquirersearchhidden="";
        }
        else 
        {
           $acquirersearch = $_POST['keywordsearch'];
           $acquirersearchhidden=trim($_POST['keywordsearch']);
        }
        $acquirersearchhidden =ereg_replace(" ","_",$acquirersearchhidden);

        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $targetcompanysearch="";
        }
        else 
        {
            $targetcompanysearch=$_POST['companysearch'];
        }
        $companysearchhidden=ereg_replace(" ","_",$targetcompanysearch);

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

       //Refine POST values
        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry="--";
        }
        else 
        {
            $industry=trim($_POST['industry']);
        }
        if($resetfield=="dealtype")
        { 
            $_POST['dealtype']="";
            $dealtypeId = "--";
        }
        else 
        {
            $dealtypeId = trim($_POST['dealtype']);
        }
        if($resetfield=="targetct")
        { 
            $_POST['targetcompanytype']="";
            $target_comptype="--";
        }
        else 
        {
            $target_comptype = trim($_POST['targetcompanytype']);
        }
        if($resetfield=="acquirerct")
        { 
            $_POST['acquirercompanytype']="";
            $acquirer_comptype="--";
        }
        else 
        {
            $acquirer_comptype = trim($_POST['acquirercompanytype']);
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
       if($resetfield=="tcountry")
        { 
            $_POST['targetCountry']="";
            $targetCountryId="--";
        }
        else 
        {
            $targetCountryId = trim($_POST['targetCountry']);
       }
        if($resetfield=="acountry")
        { 
            $_POST['acquirerCountry']="";
            $acquirerCountryId="--";
        }
        else 
        {
            $acquirerCountryId = trim($_POST['acquirerCountry']);
       }
       
        //echo "<br>Stge**" .$range;
        $whereind="";
        $wheredealtype="";
        $wheredates="";
        $whererange="";
        $wheretargetCountry="";
        $whereacquirerCountry="";
        $wheretargetcomptype="";
        $whereacquirercomptype="";
        
        //search label display values
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
        if($dealtypeId >0)
        {
                $dealtypesql= "select MADealType from madealtypes where MADealTypeId=$dealtypeId";
                if ($dealtypers = mysql_query($dealtypesql))
                {
                        While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
                        {
                                $dealtypevalue=$myrow["MADealType"];
                        }
                }
        }
        if($target_comptype=="L")
        {   $target_comptype_display="Target Type-Listed";}
        elseif($target_comptype=="U")
        {   $target_comptype_display="Target Type-Unlisted";}
        else
        {    $target_comptype_display="";}


        if($acquirer_comptype=="L")
        $acquirer_comptype_display="Acquirer Type-Listed";
        elseif($acquirer_comptype=="U")
        $acquirer_comptype_display="Acquirer Type-Unlisted";
        else
        $acquirer_comptype_display="";

        if($targetCountryId !="--")
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


        if($acquirerCountryId !="--")
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
             //print_r($_POST);
                    if($getyear !='' || $getindus !='' || $getstage !='' || $getinv !='' || $getreg!='' || $getrg!='')
                        {
                            $companysqlFinal = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
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
                                 //echo "<br>all dashboard" .$companysqlFinal;
                        }
                      
                        else if(!$_POST){
                         $yourquery=0;
                         $stagevaluetext="";
                         $industry=0;
                  
                         $dt1 = $year1."-".$month1."-01";
                         $dt2 = $year2."-".$month2."-31";
                       
                        $companysqlFinal = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business, pe.Amount, pe.MAMAId, i.industry,
                        pec.countryId,c.country, pe.AcquirerId,ac.Acquirer,ac.countryid,pe.Asset,pe.hideamount FROM mama AS pe, industry AS i,
                        pecompanies AS pec,country as c,acquirers as ac where DealDate between '" . $dt1. "' and '" . $dt2 . "' and i.industryid=pec.industry 
                        and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 
                        and pe.Deleted=0 order by companyname";
                       
                 	//echo "<br>all records" .$companysqlFinal;
			}
			elseif($searchallfield != "")
			{
				$yourquery=1;
				$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
                                
                                $companysqlFinal ="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                                pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer FROM
                                mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                                AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry." AND  (pec.companyname LIKE '%$searchallfield%' or sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%')
                                order by companyname";
				
			//echo "<bR>---searchallfield" .$companysqlFinal;
			}
			elseif ($targetcompanysearch != "")
			{
				$yourquery=1;
        			$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysqlFinal ="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                                pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer FROM
                                mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
                                AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
                                " AND  (pec.companyname LIKE '%$targetcompanysearch%' or sector_business like '%$targetcompanysearch%')
                                order by companyname";
			
                            //echo "<br> Company search--" .$companysqlFinal;
			}
			
			elseif($acquirersearch != " " && $acquirersearch != "")
			{
                            $yourquery=1;
                            $industry=0;
                            $stagevaluetext="";
                            $datevalueDisplay1="";
                            $companysqlFinal ="SELECT peinv.PECompanyId, peinv.MAMAId,c.companyname, c.industry, i.industry, sector_business,
                            peinv.Amount, peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount
                            FROM acquirers AS ac, mama AS peinv, pecompanies AS c, industry AS i
                            WHERE ac.AcquirerId = peinv.AcquirerId
                            AND c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and peinv.Deleted=0
                            AND c.industry !=15  AND ac.Acquirer LIKE '%$acquirersearch%'
                            order by companyname ";
			
                           // echo "<br> acquire search--" .$companysqlFinal;
			}
			
			elseif($advisorsearchstring_legal!=" " && $advisorsearchstring_legal!="")
			{
                            $stagevaluetext="";
                            $yourquery=1;
                            $industry=0;
                            $datevalueDisplay1="";
                            $companysqlFinal ="(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisoracquirer AS adac,acquirers as ac
                            where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId and
                            adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearchstring_legal%')
                            UNION
                            (select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisorcompanies AS adcomp,acquirers as ac
                            where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId
                            and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearchstring_legal%')
                            order by companyname";
                                
			//echo "<br>LEGAL -".$companysqlFinal;
			}
			elseif($advisorsearchstring_trans!=" " && $advisorsearchstring_trans!="")
			{
                            $stagevaluetext="";
                            $yourquery=1;
                            $industry=0;
                            $datevalueDisplay1="";

                            $companysqlFinal ="(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisoracquirer AS adac,acquirers as ac
                            where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId
                            and adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearchstring_trans%')
                            UNION
                            (select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
                            cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount
                            from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisorcompanies AS adcomp,acquirers as ac
                            where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId
                            and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearchstring_trans%')
                            order by companyname";
                        //echo "trans".$companysqlFinal;
			}

			elseif (($industry > 0) || ($dealtypeId >0) || ($target_comptype!="--") || ($acquirer_comptype!= "--") || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")))
				{
					$yourquery=1;

                                        $dt1 = $year1."-".$month1."-01";
                                        $dt2 = $year2."-".$month2."-31";
					$companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							sector_business, pe.Amount, pe.MAMAId, i.industry,pec.countryId,c.country,
							pe.AcquirerId,ac.Acquirer,ac.countryid,pe.Asset,pe.hideamount
							FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac where";
                                        if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                        }
					
                                        if ($dealtypeId!= "--")
                                        {
                                                $wheredealtype = " pe.MADealTypeId =" .$dealtypeId;
                                        }
                                        if($target_comptype!="--")
                                                $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
                                        if($acquirer_comptype!="--")
                                                $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";
                                        if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--"))
                                        {

                                                if($startRangeValue == $endRangeValue)
                                                {
                                                //	echo "<br>**********";
                                                        $whererange = " pe.Amount = ".$startRangeValue ." and pe.hideamount=0 ";
                                                }
                                                elseif($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                }
                                                elseif($endRangeValue="--")
                                                {
                                                        $endRangeValue=50000;
                                                        $endRangeValueDisplay=50000;
                                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                }

                                                $acrossDealsDisplay=1;
                                        }
					       
                                        if($targetCountryId !="--")
                                        {
                                                $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
                                        }
                                        if($acquirerCountryId !="--")
                                        {
                                                $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
                                        }

					/*if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
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
                                        }*/
                                        //echo "<Br>***".$whererange;
                                         
                                        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                        {
                                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                        }
                                         	
					if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                 $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
					if (($wheredealtype != "") )
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $bool=true;
                                        }
                                        if (($wheretargetcomptype != ""))
                                        {
                                                $companysql=$companysql . $wheretargetcomptype . " and " ;
                                                $bool=true;
                                        }
                                        if($whereacquirercomptype !="")
                                        {
                                            $companysql=$companysql .$whereacquirercomptype. " and ";
                                             $bool=true;
                                        }  
					if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $bool=true;
                                        }
                                        if (($wheretargetCountry != "") )
                                        {
                                                $companysql=$companysql .$wheretargetCountry . " and ";
                                                $bool=true;
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
							and pec.industry != 15 and pe.Deleted=0  order by companyname ";
                                        if($whereacquirerCountry != "")
                                        {

                                                $companysql=$companysql .$whereacquirerCountry . " and ";
                                                $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  ac.AcquirerId = pe.AcquirerId
                                                and pec.industry != 15 and pe.Deleted=0  order by companyname ";
                                        }
					
                                      //echo    "refine".$companysqlFinal;
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
        $investdef=1;
        $stagedef=1;
	include_once('maheader_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php include_once('marefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>	
</div>
    </div>
</td>

 <?php
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,malogin_members as dm
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

            if ($companyrs = mysql_query($companysqlFinal))
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
                writeSql_for_no_records($companysqlFinal,$emailid);
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
                                         <span class="result-no" id="show-total-deal"> Results Found</span> 
                                           <span class="result-for">For Mergers & Acquistions </span>
                                           <span class="result-amount"></span>
                                           <span class="result-amount-no" id="show-total-amount"></span> 
                                
                                   </h2>
                              <div class="title-links " id="exportbtn"></div>
                               <ul class="result-select">
                                   <?php
                                if($stagevaluetext!=""){  ?>
                                          
                                              <li> 
                                                <?php echo $stagevaluetext;?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          
                                <?php }
                                 if (($getrangevalue!= "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$getrangevalue; ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if (($getinvestorvalue!= "")){ ?>
                                <li> 
                                    <?php echo $getinvestorvalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if (($getregionevalue != "")){ ?>
                                <li> 
                                    <?php echo $getregionevalue ; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($getindusvalue!=""){  ?>

                                      <li> 
                                        <?php echo $getindusvalue;?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                <?php }
                                   if($datevalueDisplay1!=""){  
                                         ?>
                                        <li> 
                                          <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
                                        <span class="result-no" id="show-total-deal"> Results Found</span> 
                                           <span class="result-for">For Mergers & Acquistions </span>
                                           <span class="result-amount"></span>
                                           <span class="result-amount-no" id="show-total-amount"></span> 
                                
                                   </h2>
                              
                            <div class="title-links " id="exportbtn"></div>
                            <ul class="result-select">
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($dealtypeId >0){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($target_comptype !="--") { $drilldownflag=0;?>
                                <li> 
                                    <?php echo $target_comptype_display; ?><a  onclick="resetinput('targetct');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($acquirer_comptype !="--"){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $acquirer_comptype_display; ?><a  onclick="resetinput('acquirerct');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                              if($datevalueDisplay1 !=""){ 
                                ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
                                else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
                                {
                                 ?>
                                 <li style="padding:1px 10px 1px 10px;"> 
                                    <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?>
                                </li>
                                <?php
                                }
                                if($targetCountryId !="--") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $targetcountryvalue;?><a  onclick="resetinput('tcountry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($acquirerCountryId !="--") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $acquirercountryvalue;?><a  onclick="resetinput('acountry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($targetcompanysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $targetcompanysearch?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($acquirersearch)!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $acquirersearch;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                               
                                if(trim($advisorsearchstring_legal)!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($advisorsearchstring_trans)!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                ?>
                             </ul>
                                        <?php } ?>
                                   
                    <div class="alert-note">Note:  Target in () indicates sale of asset rather than the company. </div>
                        </div>				
<?php

        if($notable==false)
        {

?>
                <div class="overview-cnt mt-trend-tab">
                        <div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type']!='') ? 'active' : ''; ?>" rel="#slidingTable"><i></i><span>Trend View</span></a></div>

                      <div  id="slidingTable" style="display: block;overflow:hidden;">  
                       <?php
                       include_once("trendviewma.php");
                       ?>     
                    </div>
                    </div>
                                     
                        <div class="list-tab"><ul>
                        <li class="active"><a class="postlink"   href="maindex.php?value=0"  id="icon-grid-view"><i></i> List  View</a></li>
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
                        <li><a id="icon-detailed-view" class="postlink" href="madealdetails.php?value=<?php echo $comid;?>" ><i></i> Detail View</a></li> 
                        </ul></div>	

										
						<div class="view-table">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th>Target</th>
                                <th>Acquirer</th>
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
                                                        $searchString4="PE Firm(s)";
                                                        $searchString4=strtolower($searchString4);
                                                        $searchString4ForDisplay="PE Firm(s)";

                                                        $searchString="Undisclosed";
                                                        $searchString=strtolower($searchString);

                                                        $searchString3="Individual";
                                                        $searchString3=strtolower($searchString3);

                                                        $companyName=trim($myrow["companyname"]);
                                                        $companyName=strtolower($companyName);
                                                        $compResult=substr_count($companyName,$searchString);
                                                        $compResult4=substr_count($companyName,$searchString4);

                                                        $acquirerName=$myrow["Acquirer"];
                                                        $acquirerName=strtolower($acquirerName);

                                                        $compResultAcquirer=substr_count($acquirerName,$searchString4);
                                                        $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);
                                                        $compResultAcquirerIndividual=substr_count($acquirerName,$searchString3);

                                                        if($compResult==0)
                                                                $displaycomp=$myrow["companyname"];
                                                        elseif($compResult4==1)
                                                                $displaycomp=ucfirst("$searchString4");
                                                        elseif($compResult==1)
                                                                $displaycomp=ucfirst("$searchString");

                                                        if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0) && ($compResultAcquirerIndividual==0))
                                                                $displayAcquirer=$myrow["Acquirer"];
                                                        elseif($compResultAcquirer==1)
                                                                $displayAcquirer=ucfirst("$searchString4ForDisplay");
                                                        elseif($compResultAcquirerUndisclosed==1)
                                                                $displayAcquirer=ucfirst("$searchString");
                                                        elseif($compResultAcquirerIndividual==1)
                                                                $displayAcquirer=ucfirst("$searchString3");

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
                                                                $amountobeAdded=0;
                                                        }
                                                        elseif($myrow["hideamount"]==1)
                                                        {
                                                                $hideamount="";
                                                                $amountobeAdded=0;

                                                        }
                                                        else
                                                        {
                                                                $hideamount=$myrow["Amount"];
                                                                $acrossDealsCnt=$acrossDealsCnt+1;
                                                                $amountobeAdded=$myrow["Amount"];
                                                        }
                                                        if(trim($myrow["sector_business"])=="")
                                                                $showindsec=$myrow["industry"];
                                                        else
                                                                $showindsec=$myrow["sector_business"];

                                                        ?>
                                                        <tr>
                                                        <?php

                                                        //Session Variable for storing Id. To be used in Previous / Next Buttons
                                                        $_SESSION['resultId'][$icount++] = $myrow["MAMAId"];
                                                        ?>
                                                            <td ><?php echo $openDebtBracket;?><?php echo $openBracket ; ?><a class="postlink" href="madealdetails.php?value=<?php echo $myrow["MAMAId"];?>"><?php echo $displaycomp;?>  </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                                                                <td><?php echo $displayAcquirer; ?></td>
                                                                <td><?php echo $hideamount; ?>&nbsp;</td>

                                                        </tr>
								<!--</tbody>-->
							<?php
                                                                $industryAdded = $myrow["industry"];
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
            <form name="pelisting" id="pelisting"  method="post" action="exportmeracq.php">
                 <?php if($_POST) { ?>
                       
                        <input type="hidden" name="txtsearchon" value="4" >
			<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthideindustryvalue" value=<?php echo $industryvalue; ?> >
			<input type="hidden" name="txthidetargetcomptype" value=<?php echo $target_comptype; ?> >
			<input type="hidden" name="txthideacquirercomptype" value=<?php echo $acquirer_comptype; ?> >
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
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthideacquirer" value=<?php echo $stringToHideAcquirer; ?> >
			<input type="hidden" name="txttargetcountry" value=<?php echo $targetCountryId; ?>>
			<input type="hidden" name="txtacquirercountry" value=<?php echo $acquirerCountryId; ?>>
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
                 <?php } else { ?> 
                        
                         <input type="hidden" name="txtsearchon" value="4" >
			<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
			<input type="hidden" name="txthideindustry" value="">
			<input type="hidden" name="txthideindustryvalue" value="--">
			<input type="hidden" name="txthidetargetcomptype" value="">
			<input type="hidden" name="txthideacquirercomptype" value="" >
			<input type="hidden" name="txthidedealtype" value="--" >
			<input type="hidden" name="txthidedealtypevalue" value="" >
			<input type="hidden" name="txthideSPV" value="--" >

			<input type="hidden" name="txthiderange" value="" >
			<input type="hidden" name="txthiderangeStartValue" value="" >
			<input type="hidden" name="txthiderangeEndValue" value="" >
			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthidecompany" value="" >
			<input type="hidden" name="txthideadvisor_legal" value="" >
			<input type="hidden" name="txthideadvisor_trans" value="" >
			<input type="hidden" name="txthideacquirer" value="" >
			<input type="hidden" name="txttargetcountry" value="">
			<input type="hidden" name="txtacquirercountry" value="">
			<input type="hidden" name="txthidesearchallfield" value="" >
                        
                 <?php } ?>
						                 
                <?php
                
			$totalAmount=round($totalAmount, 0);
			$totalAmount=number_format($totalAmount);
	
                if($studentOption==1)
                {
                 ?>
                         <script type="text/javascript" >
                                $("#show-total-deal").html<?php echo $totalInv; ?> (' Results found  ');
                                $("#show-total-amount").html('<h2>Amount (US$ M) <?php echo $totalAmount; ?></h2>');
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
                                $("#show-total-deal").html('<?php echo $totalInv; ?> Results found ');
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
                    hrefval= 'exportmeracq.php';
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
  }
?>
