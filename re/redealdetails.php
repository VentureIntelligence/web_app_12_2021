<?php include_once("../globalconfig.php"); ?>
<?php
        require_once("reconfig.php");
	require_once("../dbconnectvi.php");
        $companyId=632270771;
        $compId=0;
	$Db = new dbInvestments();
        $videalPageName="REInv";
	include ('checklogin.php');
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	$mailurl= curPageURL();
        $exportToExcel=0;
        $notable=false;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        $newValue = $strvalue[1];
        
        
        $_SESSION['usebackaction']=$value;
        
        
//      Check  Is Trail Login  ?
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
        
        $SelCompRef=$strvalue[0];
        $sql="SELECT pe.PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector as sector_business,
				 amount, round, s.REType, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pe.city,
				 pe.RegionId,r.Region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
				pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.SPV,DATE_FORMAT(ModifiedDate, '%d-%m-%Y  %H:%m:%S') as ModifiedDate,
				pe.Link,pe.uploadfilename,pe.source,Valuation,FinLink,ProjectName,ProjectDetailsFileName,listing_status,Exit_Status
				 FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s, region as r,
			     investortype as its
				 WHERE pe.IndustryId = i.industryid
				 AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0
				 and pe.PEId=$SelCompRef and pe.StageId=s.ReTypeId and r.RegionId=pe.RegionId
				 and its.InvestorType=pe.InvestorType ";
	//echo "<br>".$sql;

	$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from REinvestments_investors as peinv,
		REinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
//	echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from REinvestments_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from REinvestments_advisorinvestors as advinv,
	REadvisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
        
        
         $resetfield=$_POST['resetfield'];
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
//                $month1= date('n', strtotime(date('Y-m')." -2   month")); 
//                $year1 = date('Y');
//                $month2= date('n');
//                $year2 = date('Y'); 
                
                $month1= date('n');
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
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
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
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
            
                if(trim($_POST['searchallfield'])!=""){
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
             $month1=01; 
                        $year1 = 2005;
             $month2= date('n');
             $year2 = date('Y');
                    }else{
                        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
                }
                if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!=""){
                    $month1=01; 
                    $year1 = 2005;
                    $month2= date('n');
                    $year2 = date('Y');
                }
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                
                
//             $month1 = date('n', strtotime($_POST['txthidedateStartValue']));
//             $year1 = date('Y', strtotime($_POST['txthidedateStartValue']));
//             $month2= date('n', strtotime($_POST['txthidedateEndValue']));
//             $year2 = date('Y', strtotime($_POST['txthidedateEndValue']));
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
        }
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
        
        if($resetfield=="keywordsearch")
        { 
            $_POST['keywordsearch']="";
            $keyword="";
            $keywordhidden="";
            
             $investorauto='';
        }
        else 
        {
            $keyword=trim($_POST['keywordsearch']);
            $keywordhidden=trim($_POST['keywordsearch']);
                   
             $investorauto=$_REQUEST['investorauto'];
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
       
            $companyauto=$_REQUEST['companyauto'];
        }
        $companysearchhidden=ereg_replace(" ","_",$companysearch);

        if($resetfield=="sectorsearch")
        { 
            $_POST['sectorsearch']="";
            $sectorsearch="";
            $sectorauto="";
        }
        else 
        {
            $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
            $sectorauto=$_REQUEST['sectorauto'];
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

        if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry="";
        }
        else 
        {
            $industry=$_POST['industry'];
        }
        
        if($resetfield=="city")
        { 
            $_POST['citysearch']="";
            $city="";
        }
        else 
        {
            $city=trim($_POST['citysearch']);
            if($city != NULL){
                $searchallfield='';
            }
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
        if($boolStage==true)
        {
            foreach($stageval as $stageid)
            {
                $stagesql="select RETypeId,REType from realestatetypes  where RETypeId='$stageid'";
                //	echo "<br>**".$stagesql;
                if ($stagers = mysql_query($stagesql))
                {
                    While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                    {
                            $cnt=$cnt+1;
                            if($myrow["REType"] !=''){
                                $stagevaluetext= $stagevaluetext. ",".$myrow["REType"] ;
                            }
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

//        if($resetfield=="dealtype_debtequity")
//        { 
//            $_POST['dealtype_debtequity']="";
//            $debt_equity="--";
//        }
//        else 
//        {
//            $debt_equity=trim($_POST['dealtype_debtequity']);
//        }

        if($resetfield=="invType")
        { 
            $_POST['invType']="";
            $investorType="--";
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
        $endRangeValue=$endRangeValue-0.01;
        //$endRangeValueDisplay =$endRangeValue;
        
        
        if($resetfield=="exitstatus")
        { 
            $_POST['exitstatus']="";
            $exitstatusValue="";
        }
        else 
        {
            $exitstatusValue = $_POST['exitstatus'];
            if($exitstatusValue != NULL && $exitstatusValue != '--'){
                $searchallfield='';
            }
        }
        
        if($exitstatusValue!=''){
            
            if($exitstatusValue==1){
                
                $exitstatusfilter='Unexited';
                
            }
            else if($exitstatusValue==2){
                
                $exitstatusfilter='Partially Exited';
                
            }
            else if($exitstatusValue==3){
                
                $exitstatusfilter='Fully Exited';
                
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
            
            
            
            /*if($industry >0)
		{
			$industrysql= "select industry from reindustry where IndustryId=$industry";
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
            
?>

<?php
	$topNav = 'Deals'; 
        $tour_reinve_page = 'redealdetails';
	include_once('reheader_search.php');
?>
  <style>
  .result-title{
    padding: 10px 0 10px;
  }
  .result-title h2{
  margin-bottom: 10px;
  }
  .profiletable li{
    min-height: auto;
  }
  </style> 
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
<td class="left-td-bg" >
      <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php
           $pageTitle="Real Estate Investments";
           $pageUrl="reindex.php";
           $refineUrl="rerefine.php";

           include_once('rerefine.php'); 
?>

<?php
        //GET PREV NEXT ID
        $prevNextArr = array();
        $prevNextArr = $_SESSION['resultId'];

        $currentKey = array_search($SelCompRef,$prevNextArr);
        $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
        $nextKey = $currentKey+1;
        
        $flagvalue=$value;
        $searchstring="";
        echo $sql;
        if ($companyrs = mysql_query($sql)){  
        ?>
            
            <? if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
        {
            $lastModifiedDate=$myrow["ModifiedDate"];
            $projectname=$myrow["ProjectName"];
            $finlink=$myrow["FinLink"];

            if($myrow["hideamount"]==1)
            {
                $hideamount="--";
            }
            else
            {
                $hideamount=$myrow["amount"];
            }

            if($myrow["hidestake"]==1)
            {
                $hidestake="--";
            }
            else
            {
                $hidestake=$myrow["stakepercentage"];
                if($myrow["stakepercentage"]>0)
                    $hidestake=$myrow["stakepercentage"];
                else
                    $hidestake="&nbsp;";
                        }
                        $col6=$myrow["Link"];
                        $linkstring=str_replace('"','',$col6);
            $linkstring=explode(";",$linkstring);

            $uploadname=$myrow["uploadfilename"];
            $projectdetails=$myrow["ProjectDetailsFileName"];
            $currentdir=getcwd();
            $target = $currentdir . "../uploadrefiles/" . $uploadname;

            $file = "../uploadrefiles/" . $uploadname;
                        if($projectdetails!="")
                            $file1 = "../uploadrefiles/" . $projectdetails;
                }
        }
                
     ?>
 
</div>
</div>
</td>
	<!-- you can put content here -->
<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt"> 
			<?php if ($accesserror==1){?>
                        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
            <?php
                    exit; 
                    } 
            ?>                               
    <div class="result-title">
                                            
                        <?php if(!$_POST){?>
                                <h2>
                                    <?php
                                    if($studentOption==1 || $exportToExcel==1){
                                    ?>
                                       <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span> 
                                    <?php }
                                    else {
                                    ?>
                                       <span class="result-no"> <?php echo count($prevNextArr); ?> Results Found</span> 
                                   <?php } ?>
                                       <span class="result-for">For Real Estate Investment</span>
                                </h2>
                                
                                 <div class="title-links">
                                
                                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                    <?php 

                                    if(($exportToExcel==1))
                                         {
                                         ?>
                                             <input class="export" type="button" id="expshowdeals"  value="Export" name="showREIPOdeal">
                                         <?php
                                         } else { ?>
                                             <a href="../../xls/Sample_Sheet_Investments-RE.xls" id="expshowdeals" target="_blank"  style="float:right">Sample Export</a>
                                             
<!--                                             <input class="export" type="button" id="expshowdeals"  value="Export Sample" name="showREIPOdeal">-->
                                         <?php      }
                                     ?>
                                </div>
                                <ul class="result-select closetagspace closetagspacedetail">
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
                                    if($studentOption==1 || $exportToExcel==1){
                                    ?>
                                       <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span> 
                                    <?php }
                                    else {
                                    ?>
                                       <span class="result-no"> <?php echo count($prevNextArr); ?> Results Found</span> 
                                   <?php } ?>
                                       <span class="result-for">For Real Estate Investment</span>
                                </h2>
                                <div class="title-links">
                                
                                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                     <?php 

                                    if(($exportToExcel==1))
                                         {
                                         ?>
                                             <input class="export" type="button" id="expshowdeals"  value="Export" name="showREIPOdeal">
                                         <?php
                                         } else { ?>
                                             <a href="../../xls/Sample_Sheet_Investments-RE.xls" id="expshowdeals" target="_blank"  style="float:right">Sample Export</a>
                                             
<!--                                             <input class="export" type="button" id="expshowdeals"  value="Export Sample" name="showREIPOdeal">-->
                                         <?php      }
                                     ?>
                                </div>
                                <ul class="result-select closetagspace closetagspacedetail">
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
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValue ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                    if($city!=""){ $drilldownflag=0; ?>
                                     <!-- City -->
                                    <li> 
                                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
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
                                    <?php echo $investorauto;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $sectorauto;?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                               if($exitstatusfilter!=''){ ?>
                                <li> 
                                   <?php echo trim($exitstatusfilter)?><a  onclick="resetinput('exitstatus');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                                if($cl_count >= 7)
                                {
                                ?>
                                <li class="result-select-close">
                                <?php 
                                if(GLOBAL_BASE_URL=='https://www.ventureintelligence.asia/dev/'){
                                ?>                                
                                <a href="reindex.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li></li>
                                <?php }else{ ?>
                                    <a href="/re/reindex.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                                
                                }
                                ?>
                             </ul>
                            <?php } ?>
                                                
                    
                    
                    
                    
                        </div>	
    <div class="overview-cnt"></div>                    
    <div class="list-tab  mt-list-tab"><ul>
            <li><a class="postlink"  href="<?php echo $actionlink; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="redealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
            </ul></div> 
     <div class="lb" id="popup-box">
	<div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Checkout this deal - <?php echo $myrow["companyname"]; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this deal - <?php echo $myrow["companyname"]; ?> - in Venture Intelligence"  />
                    <input type="hidden" name="basesubject" id="basesubject" value="Deal" />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                   
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['REUserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                    <h5>Your Message</h5><span style='float:right;'>Words left: <span id="word_left">200</span></span>
                    <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtn" />
            </div>

        </form>
    </div>
    <div class="view-detailed"> 
         <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2-->
             <div class="detailed-title-links"><h2> <A class="postlink" href='recompanydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$newValue.'/';?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="redealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="redealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>"> Next > </a>  <?php } ?>
                    </div> 
                        
 <div class="profilemain">
                <h2  id="profilemain">Deal Info  <span style="float: right;font-size: 12px;font-weight: normal;">Updated on : <?php echo $myrow["ModifiedDate"];?></span></h2>
                <div class="profiletable">

               <ul>
                <?php
                 if($projectname!=""){
                 ?>
                 <li><h4>&nbsp;Project Name </h4><p><?php echo $projectname;?></p></li>
                 <?php } ?>
                 <li><h4>Amount(US$M)</h4><p><?php 
                 if($hideamount >0)
                 {
                     echo $hideamount;
                 }
                 else
                 {
                  echo "--";
                 }?>
                     </p></li>
                 <li><h4>Date</h4><p><?php echo  $myrow["dt"];?></p></li>
                 <?php

			if($myrow["Valuation"]!="")
			{
			?>
			    <li><h4>Valuation</h4><p><?php print nl2br($myrow["Valuation"]);?></p></li>

			<?php
			} ?>
                            
                            
                             <?php
                 $exitstatusis='';
                $exitstatusSql = "select id,status from exit_status where id=".$myrow["Exit_Status"];
                if ($exitstatusrs = mysql_query($exitstatusSql))
                {
                  $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                }
                if($exitstatus_cnt > 0)
                {
                        While($Exit_myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                        {
                                $exitstatusis = $Exit_myrow[1];
                        }?>
                        <li><h4>Exit Status</h4><p><?php echo $exitstatusis;?></p></li>
                <?php } ?>
                
                  </ul>

                </div>
                </div>
    
  <div class="postContainer postContent masonry-container">
      <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2   id="investmentinfo">Investor Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody>
                        <tr>
                             <?php
					if ($getcompanyrs = mysql_query($investorSql))
					{ ?>
                            <td  id="tourreinvestor337"><h4>Investors</h4><p>
                    <?php
                                        $AddOtherAtLast="";
					While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                        {
	      				$Investorname=trim($myInvrow["Investor"]);
	      				$Investorname=strtolower($Investorname);

	      				$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
                                                    $_SESSION['investId'][$invcount++] = $myInvrow["InvestorId"];
	      		?>                  
					<a class="postlink"  id="reinvestor<?php echo $myInvrow["InvestorId"]; ?>" href='reinvestordetails.php?value=<?php echo $myInvrow["InvestorId"].'/'.$newValue.'/' ?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
				<?php
						}
						else
						{
							$AddOtherAtLast=$myInvrow["Investor"];
						}

					}
					
				?>
					<?php echo $AddOtherAtLast; ?>
			</td>
                        <?php } ?>
                        <?if($myrow["InvestorTypeName"]!="") { ?>
                        <td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td>
                        <?php } 
                        if($hidestake!="" && $hidestake!="&nbsp;") {
                        ?>
                        <td><h4>Stake %</h4><p><?php echo $hidestake;?></p></td>
                        <?php } ?>
                        </tr>
                        <?php if($rscomp= mysql_query($advcompanysql))
                        {
                             $comp_cnt = mysql_num_rows($rscomp);
                        }
                        if($comp_cnt>0)
                        {
                         ?>
                            <tr><td><h4>Advisor Company</h4><p>
                            <?php

                                    if ($getcompanyrs = mysql_query($advcompanysql))
                                    {
                                            While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                            {
                                                ?>
                                                    <A class="postlink" href='readvisor.php?value=<?php echo $myadcomprow["CIAId"].'/'.$newValue.'/'; ?><?php echo $flagvalue?>' >
                                                    <?php 
                                                    //advisor.php?value=<?php echo $myadinvrow["CIAId"];   /1/<?php echo $flagvalue 
                                                    echo $myadcomprow["cianame"]; ?> </a> (<?php echo $myadcomprow["AdvisorType"];?>)
                                                    
                                    <?php
                                            }
                                    } 
                                    ?>
                                    </p>
                                </td> 
                        <?php 
                           } 
				if($rsinvcomp= mysql_query($advinvestorssql))
				{
				     $compinv_cnt = mysql_num_rows($rsinvcomp);
				}
				
				if($compinv_cnt>0)
				{ ?>
                                    <td><h4>Advisor Investor</h4><p>
                                 <?php
					if ($getinvestorrs = mysql_query($advinvestorssql))
					{
                                            While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                                            { 
                                                ?>
                                            <A class="postlink" href='readvisor.php?value=<?php echo $myadinvrow["CIAId"]; ?>/1/<?php echo $flagvalue?>' >
                                            <?php 
                                            //advisor.php?value=<?php echo $myadinvrow["CIAId"];   /1/<?php echo $flagvalue 
                                            echo $myadinvrow["cianame"]; ?> </a> (<?php echo $myadinvrow["AdvisorType"];?>)
                                    <?php   }
				        }
					?>
                   </p></td></tr>
                    <?php
					}
				?> </tbody>
                    </table>
                    </div>   
                    
          	  <?php if(0) { ?>
         	   <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/tac-3/">
                   <h2>Exits Info</h2>
                        <table class="tablelistview" cellpadding="0" cellspacing="0">
                            <tr><td><h4>Valuation</h4><p><?php print nl2br($myrow["Valuation"]);?></p></td></tr>
                        </table>
                    </div>     
                    <?php } ?>
    
    
     		<div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2  id="companyinfo">Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                     <?php
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";

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

                                if($myrow["listing_status"]=="L")
                                $listing_stauts_display="Listed";
                                elseif($myrow["listing_status"]=="U")
                                $listing_stauts_display="Unlisted";

				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
				<td width="120"><h4>Company</h4> <p> <?php echo $openBracket;?><A class="postlink" href='recompanydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$newValue.'/';?>' >
				<?php echo rtrim($myrow["companyname"]);?></a><?php echo $closeBracket;?>
				</p></td>
		<?php
				}
				else
				{
					$webdisplay="";
		?>
				<td  ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>
                        <?php if($listing_stauts_display!=""){ ?><td><h4>Company Type</h4> <p><?php echo $listing_stauts_display;?></p></td> <?php } ?></tr>
                        <tr>
                             <?php if($myrow["industry"]!=""){ ?> <td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td><?php } ?>
                        <?php if($myrow["sector_business"]!=""){ ?><td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td><?php } ?></tr>
                        <tr><?php if($myrow["REType"]!=""){ ?><td><h4>Type</h4><p><?php echo $myrow["REType"];?></p></td><?php } ?></tr>
                        <tr><?php if($myrow["city"]!=""){ ?><td><h4>City</h4> <p><?php echo  $myrow["city"];?></p></td><?php } ?>
                         <?php if($myrow['Region']!=""){ ?><td><h4>Region</h4> <p><?php echo $myrow['Region'];?></p>	</td><?php } ?></tr>
                        <tr><?php if($webdisplay!=""){ ?><td colspan="2"><h4>Website</h4> <p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></td><?php } ?></tr> 
                        <tr><?php if(trim($linkstring[0])!=""){ ?><td colspan="2"><h4>Links</h4> <p style="word-break: break-all;">
                                <?php
                                foreach ($linkstring as $linkstr)
                                {
                                        if(trim($linkstr)!=="")
                                        {
				?>
						<a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a>
				<?php
                                        }
                                }
				?>   
                        </p>	</td><?php } ?></tr> 
                     
                    </table>
            </div>   
            <?php if($myrow["MoreInfor"]!="") { ?>
           <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2 id="moreinfo">More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($myrow["MoreInfor"]);?></p></td></tr></table>
           </div>
            <?php } ?>
                </div>             
</div></div>
</td>
</tr>
</table>
</div>
</form>
<form name="companyDisplay" id="companyDisplay" method="post" action="exportredealinfo.php">
    <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>">
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>">
</form>
<div class=""></div>
</div>
 <script type="text/javascript">
    /*$(".export").click(function(){
        $("#companyDisplay").submit();
    });*/
     $(document).ready(function() {
        $("#ymessage").on('keydown', function() {
            var words = this.value.match(/\S+/g).length;
            var character = this.value.length;
            
            if (words == 201) {
                
                $("#ymessage").attr('maxlength',character);
            }
            if(words > 200){
                 alert("Text reached above 200 words");
            }
            else {
                $('#word_left').text(200-words);
            }
        });
     });
     
   <?php if(($exportToExcel==1)){ ?> 
    $('#expshowdeals').click(function(){ 
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
    <?php } ?>
        
        
        
    $('#expshowdealsbtn').click(function(){ 
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
      
     $('#senddeal').click(function(){ 
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#popup-box').fadeIn();   
            return false;
        });
         $('#cancelbtn').click(function(){ 

            jQuery('#popup-box').fadeOut();   
             jQuery('#maskscreen').fadeOut(1000);
            return false;
        });
        function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
                function checkEmail() {

                    var email = $("#toaddress").val();
                        if (email != '') {
                            var result = email.split(",");
                            for (var i = 0; i < result.length; i++) {
                                if (result[i] != '') {
                                    if (!validateEmail(result[i])) {

                                        alert('Please check, `' + result[i] + '` email addresses not valid!');
                                        email.focus();
                                        return false;
                                    }
                                }
                            }
                    }
                    else
                    {
                        alert('Please enter email address');
                        email.focus();
                        return false;
                    }
                    return true;
            }
                
    function initExport(){ 
            $.ajax({
                url: 'ajxCheckDownload.php',
                dataType: 'json',
                success: function(data){
                    var downloaded = data['recDownloaded'];
                    var exportLimit = data.exportLimit;
                    var currentRec = 1;

                    //alert(currentRec + downloaded);
                    var remLimit = exportLimit-downloaded;

                    if (currentRec <= remLimit){
                        //hrefval= 'exportREmeracq.php';
                        //$("#pelisting").attr("action", hrefval);
                        $("#companyDisplay").submit();
                        jQuery('#preloading').fadeOut();
                    }else{
                        jQuery('#preloading').fadeOut();
                        //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                        alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.in");
                    }
                },
                error:function(){
                    jQuery('#preloading').fadeOut();
                    alert("There was some problem exporting...");
                }

            });
        }
    $('#mailbtn').click(function(){ 
                        
            if(checkEmail())
            {


            $.ajax({
                url: 'ajaxsendmail.php',
                 type: "POST",
                data: { to : $("#toaddress").val(), subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                success: function(data){
                        if(data=="1"){
                             alert("Mail Sent Successfully");
                            jQuery('#popup-box').fadeOut();   
                            jQuery('#maskscreen').fadeOut(1000);

                    }else{
                        jQuery('#popup-box').fadeOut();   
                        jQuery('#maskscreen').fadeOut(1000);
                        alert("Try Again");
                    }
                },
                error:function(){
                    jQuery('#preloading').fadeOut();
                    alert("There was some problem sending mail...");
                }

            });
            }

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
  // alert($('[name="'+fieldname+'"]').val());
     $("#resetfield").val(fieldname);
     hrefval= 'index.php';
     $("#pesearch").attr("action", hrefval);
     $("#pesearch").submit();
       return false;
   }
</script>



<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
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
 function highlightWords($text, $words)
 {

         /*** loop of the array of words ***/
         foreach ($words as $worde)
         {

                 /*** quote the text for regex ***/
                 $word = preg_quote($worde);
                 /*** highlight the words ***/
                 $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
         }
         /*** return the text ***/
         return $text;
 }

 	function return_insert_get_RegionIdName($regionidd)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionidd";

                if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionIdname = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionIdname;
				}
			}
		}
		$dbregionlink.close();
	}
function curPageURL() {
 $URL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $URL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $word='&scr=EMAIL';
if( strpos( $URL , $word ) !== false ) {
    $source='';
} else {
    $source='&scr=EMAIL';
}
 $pageURL=$URL.$source;
 return $pageURL;
}
mysql_close();
?>
<script type="text/javascript" >

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


 <script src="hopscotch.js"></script>
    <script src="demo.js"></script>
    
     <script type="text/javascript" >
    $(document).ready(function(){
        <?php if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){ ?>
   hopscotch.startTour(tour, 5); 
        <?php } ?>
           });
           
        </script>
        <?php  mysql_close();  ?>