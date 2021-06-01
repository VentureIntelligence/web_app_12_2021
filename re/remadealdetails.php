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

        $searchString3="Individual";
        $searchString3=strtolower($searchString3);

        $searchString4="PE Firm(s)";
        $searchString4ForDisplay="PE Firm(s)";
        $searchString4=strtolower($searchString4);
        
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$SelCompRef=$value;
        $newValue=3;

        $mailurl= curPageURL();
        $exportToExcel=0;
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
        $hideamount="";
        $hidemoreinfor="";
        
        $sql="SELECT pe.PECompanyId, pec.companyname,pe.Stake, pec.industry, i.industry, pec.sector_business,
		pec.countryid as TargetCountryId,pec.city as TargetCity,
		Amount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt,DATE_FORMAT(ModifiedDate,'%m/%d/%Y %H:%i:%s') as modifieddate,
		pec.website,c.country as TargetCountry,
		 pe.MAMAId,pe.Comment,MoreInfor,pe.MADealTypeId,dt.MADealType,pe.AcquirerId,ac.Acquirer,pe.Asset,pe.city,r.Region,Link,pe.uploadfilename,pe.source
		 FROM REmama AS pe, reindustry AS i, REcompanies AS pec,
		 madealtypes as dt,REacquirers as ac,country as c,region as r
		 WHERE  i.industryid=pec.industry and c.countryid=pec.countryid
		 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0  and pe.MAMAId=$SelCompRef
		 and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId and r.RegionId=pe.RegionId";
	//echo "<br>".$sql;

	$advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame ,AdvisorType from REmama_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from REmama_advisoracquirer as advinv,
	REadvisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;
        
        
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
                $month1= date('n'); 
                $year1 = 2005;
                $month2= date('n');
                $year2 = date('Y'); 
            if($type==1)
            {
                $fixstart=2005;
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
             $month1= date('n'); 
             $year1 = 2005;
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n'); 
             $year1 = 2005;
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!=""  || trim($_POST['acquirerauto']) != '')
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
                if(trim($_POST['acquirersearch'])!="" || trim($_POST['investorsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['adcompanyacquirersearch_legal'])!="" ||  trim($_POST['adcompanyacquirersearch_trans'])!="" || trim($_POST['acquirerauto']) != ''){
                    $month1=01; 
                    $year1 = 2005;
                    $month2= date('n');
                    $year2 = date('Y');
                }
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : 2005;
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

       /* $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,RElogin_members as dm
        where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                        $exportToExcel=$trialrow["TrialLogin"];
                }
        }*/
          
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
            $acquirerauto="";
            
        }
        else 
        {
            $acquirersearch=trim($_POST['keywordsearch']);
        
             $acquirerauto=$_POST['acquirerauto'];
        }
        if($resetfield=="companysearch")
        { 
            $_POST['companysearch']="";
            $targetcompanysearch="";
             $companyauto='';
        }
        else 
        {
            $targetcompanysearch=trim($_POST['companysearch']);
        
             $companyauto=$_POST['companyauto'];
        }
       	$stringToHide=ereg_replace(" ","-",$targetcompanysearch);

        if($resetfield=="sectorsearch")
        { 
            $_POST['sectorsearch']="";
            $sectorsearch="";
             $sectorauto='';
        }
        else 
        {
            $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
            if($sectorsearch!=''){
                $searchallfield='';
        }
             $sectorauto=$_POST['sectorauto'];
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
            $targetCountryId="";
        }
        else 
        {
            $targetCountryId=trim($_POST['targetCountry']);
        }
         if($resetfield=="acquirerCountry")
        { 
            $_POST['acquirerCountry']="";
            $acquirerCountryId="";
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
?>

<?php
	$topNav = 'Deals'; 
	include_once('remaheader_search.php');
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

 <td class="left-td-bg">
   <div class="acc_main">
 <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide">Slide Panel</a></div> 
 <div  id="panel">
<?php
           $pageTitle="";
           $pageUrl="remaindex.php";
           $refineUrl="remarefine.php";

           include_once('remarefine.php'); ?>
 
</div>
</div>
</td>
	<!-- you can put content here -->

 <?php
      	//GET PREV NEXT ID
        $prevNextArr = array();
        $prevNextArr = $_SESSION['resultId'];

        $currentKey = array_search($SelCompRef,$prevNextArr);
        $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
        $nextKey = $currentKey+1;
		
        $flagvalue=$value;
        $searchstring="";

       
	 ?>
<td class="profile-view-left" style="width:100%;">
    <?php
     if ($companyrs = mysql_query($sql)){  
       
            $hideamount="";
            $hidemoreinfor="";
            if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{

                    $col6=$myrow["Link"];
                    $linkstring=str_replace('"','',$col6);
                    $linkstring=explode(";",$linkstring);

                    $uploadname=$myrow["uploadfilename"];
                    $currentdir=getcwd();
                    $target = $currentdir . "../uploadrefiles/" . $uploadname;

                    $file = "../uploadrefiles/" . $uploadname;



                    $acquirerId=$myrow["AcquirerId"];
            //	echo "<br>---" .$acquirerId;
                    $getAcquirerCityCountrySql = "select ac.CityId,ac.countryid,co.country from REacquirers as ac,
                    country as co where ac.AcquirerId=$acquirerId  and co.countryid=ac.CountryId";
            //	echo "<br>----" .$getAcquirerCityCountrySql;
                    if($cityrs=mysql_query($getAcquirerCityCountrySql))
                    {
                            if($mycityrow=mysql_fetch_array($cityrs,MYSQL_BOTH))
                            {
                                    $Acquirercityname=$mycityrow["CityId"];
                                    $Acquirercountryname=$mycityrow["country"];
                            }
                     }
                     $acquirerName=trim($myrow["Acquirer"]);
								$acquirerName=strtolower($acquirerName);
								$compResult3=substr_count($acquirerName,$searchString);
								$compResult4=substr_count($acquirerName,$searchString4);
								//echo "<Br>--" .$compResult4;

								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);

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
									$hideamount="";
								else
									$hideamount=$myrow["Amount"];

								if($myrow["Stake"]==0)
									$hidestake="";
								else
									$hidestake=$myrow["Stake"];

								$webdisplay="";   
                     

        
    
    ?>
    
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
                                       <span class="result-for">For RE - Mergers & Acquistions</span>
                                </h2>
                               
                                <div class="title-links">
                                
                                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                    <?php 

                                    if(($exportToExcel==1))
                                         {
                                         ?>
                                              <input class="export" type="button" id="expshowdeals" value="Export" name="showmandadeal">
                                         <?php
                                         }
                                     ?>
                                </div>
                               <ul class="result-select closetagspace closetagspacedetail">
                                   <?php
                                  if(trim($datevalueDisplay1)!="" && trim($datevalueDisplay2) !=''){  
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
                                           <span class="result-for">For RE - Mergers & Acquistions</span>
                                    </h2>
                                        
                                 <div class="title-links">
                                
                                    <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                    <?php 

                                    if(($exportToExcel==1))
                                         {
                                         ?>
                                              <input class="export" type="button" id="expshowdeals" value="Export" name="showmandadeal">
                                         <?php
                                         }
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
                                 if($dealtype!="--" && $dealtype!=null && $dealtypevalue !='') { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $dealtypevalue;?><a  onclick="resetinput('dealtypevalue');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                                if(trim($datevalueDisplay1)!="" && trim($datevalueDisplay2) !=''){  ?>
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
                                    <?php echo $acquirerauto;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($targetcompanysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $companyauto?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  tripslashes(str_replace("'","",trim($sectorsearch))) ?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
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
                                ?>
                             </ul>
                                        <?php } ?>
                        </div>	
                        
    <div class="overview-cnt mt-trend-tab"></div>
    <div class="list-tab"><ul>
            <li><a class="postlink"  href="<?php echo $actionlink; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="remadealdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail View</a></li> 
            </ul></div> 
    
    <div class="lb" id="popup-box" style="top:100px;">
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
         <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]."/".$newValue; ?></h2-->
             <div class="detailed-title-links"><h2> <A class="postlink" href='recompanydetails.php?value=<?php echo $myrow["PECompanyId"]."/".$newValue;?>' ><?php echo rtrim($myrow["companyname"]);?></a></h2>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="remadealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="remadealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>"> Next > </a>  <?php } ?>
                    </div> 
                        
 <div class="profilemain">
     <h2>Deals Info  <span style="float: right;font-size: 12px;font-weight: normal;">Updated on : <?php echo $myrow["modifieddate"];?></span> </h2> 
                <div class="profiletable">
                    <ul>
                      <li><h4>Deal Amount (US $M)</h4><p>
                            <?php 
                            if($hideamount >0)
                            {
                                echo $hideamount;
                            }
                            else
                            {
                             echo "--";
                            }?>
                          </p></li>
                      <?php if(trim($hidestake)!="&nbsp;" &&  trim($hidestake)!="") { ?><li><h4>Stake (%)</h4><p><?php echo $hidestake;?></p></li> <?php } ?>
                      <?php if(trim($myrow["MADealType"])!="") { ?> <li><h4>&nbsp;Deal Type </h4><p><?php echo $myrow["MADealType"];?></p></li><?php } ?>
                      <?php if(trim($myrow["dt"])!="") { ?><li><h4>Deal Period</h4><p><?php echo  $myrow["dt"];?></p></li><?php } ?>
                    </ul>
                </div>
</div>
    
    
    
  <div class="postContainer postContent masonry-container">
      <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                      <tr>  
                        <td width="120"><h4>Target Company</h4> 
                        <?php
                                    
                                    if(($compResult==0) && ($compResult1==0))
                                    {
                                        $webdisplay=$myrow["website"];
				?>
                                        <p> <?php echo $openBracket;?>
                                            <A class="postlink" href='recompanydetails.php?value=<?php echo $myrow["PECompanyId"]."/".$newValue;?>' > <?php echo rtrim($myrow["companyname"]);?></a><?php echo $closeBracket;?>
                                        </p>
                                     <?php }
                                     else
                                     { $webdisplay=$myrow["website"]; ?>
                                        <p><?php echo ucfirst("$searchString") ;?></p>
                                    <?php  } ?>
                        </td>

                        <tr> <?php if(trim($myrow["industry"])!="") { ?><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td><?php } ?>
                             <?php if(trim($myrow["sector_business"])!="") { ?><td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td><?php } ?></tr>
                        <tr> <?php if(trim($myrow["city"])!="") { ?><td><h4>City (Target)</h4> <p><?php echo  $myrow["city"];?></p></td><?php } ?>
                             <?php if(trim($myrow["TargetCountry"])!="") { ?><td><h4>Country (Target)</h4> <p><?php echo  $myrow["TargetCountry"];?></p></td> <?php } ?></tr>
                        <tr> <?php if(trim($myrow["website"])!="") { ?><td colspan="2"><h4>Website</h4> <p><a href=<?php echo $myrow["website"]; ?> target="_blank"><?php echo $myrow["website"]; ?></a></p>	</td> <?php } ?></tr> 
                       <?php if(trim($linkstring[0])!="") { ?> <tr> <td colspan="2"><h4>Links</h4> <p style="word-break: break-all;">
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
                       </p>	</td> </tr> <?php } ?>
                    </tbody>
                    </table>
                </div>
                <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Acquirer Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody> 
                        <tr><td colspan="2"><h4>Acquirer</h4> 
                                <p>
                                    <?php
					if(($compResult3==0) &&  ($compResult4==0)){
                                        ?>
                                            <a href='reacquirerdetails.php?value=<?php echo $myrow["AcquirerId"]."/".$newValue;?>' > <?php echo rtrim($myrow["Acquirer"]);?> </a>
                                        <?php
                                        }
                                        elseif($compResult4==1){
                                            $webdisplay="";
                                        ?>
                                            <?php echo ucfirst("$searchString4ForDisplay") ;?>
                                        <?php  
                                        }
                                        elseif($compResult3==1)
                                        {
                                        $webdisplay="";
                                        ?>
                                            <?php echo ucfirst("$searchString") ;?>
                                        <?php } ?>

                                </p>	
                            </td>
                        </tr>
                        <?php if(trim($Acquirercityname)!="") { ?><tr><td><h4>City (Acquirer)</h4> <p><?php echo  $Acquirercityname;?></p></td> </tr><?php } ?>
                        <?php if(trim($Acquirercountryname)!="") { ?><tr><td><h4>Country (Acquirer)</h4> <p><?php echo  $Acquirercountryname;?></p></td></tr><?php } ?>
                       
                        
                       
                     
                    </table>
            </div> 
            <?php
            
                $getcompanyrs = mysql_query($advcompanysql);
                if (mysql_num_rows($getcompanyrs)>0)
                {
                ?>
            <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>Advisor - Target</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p>
                        <?php
                               While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                    {?>
                                        <?php echo $myadcomprow["cianame"];?> (<?php echo $myadcomprow["AdvisorType"];?>) <br/>
                                      <?php
                                    }
                              ?>
                              </p>
                          </td></tr></table>
           </div> 
                <?php } 
                $getinvestorrs = mysql_query($adacquirersql);
                if (mysql_num_rows($getinvestorrs)>0)
                {
                    
                ?>
           <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>Advisor - Acquirer</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p>
                        <?php
                           
                            While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                            {?>
                                       <?php echo $myadinvrow["cianame"];?> (<?php echo $myadinvrow["AdvisorType"];?>) <br/>
                                      <?php
                                    }
                             
                              ?>
                              </p>
                          </td></tr></table>
           </div>
                <?php } ?>
      <?php if(trim($myrow["MoreInfor"])!="") { ?>
           <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($myrow["MoreInfor"]);?></p></td></tr></table>
           </div>
      <?php } ?>
                </div>       
</div>
    </div>
     <?php }
     } ?>
</td>
</tr>
</table>
 
</div>
 </form>
 <form name="companyDisplay" id="companyDisplay"   method="post" action="exportREMA.php">
      <input type="hidden" name="txthideMAMAId" value="<?php echo $SelCompRef;?>" >
            <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
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
     
   $('#expshowdeals').click(function(){ 
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
                       // hrefval= 'exportrecompanyprofile.php';
                       // $("#companyDisplay").attr("action", hrefval);
                        $("#companyDisplay").submit();
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
                                alert("There was some problem exporting...");
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
        $portArray = array( '80', '443' );
        if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
        $URL .= "://";
        if (!in_array( $_SERVER["SERVER_PORT"], $portArray)) {
         $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
         $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        $pageURL=$URL."&scr=EMAIL";
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
 <?php  mysql_close();   ?>