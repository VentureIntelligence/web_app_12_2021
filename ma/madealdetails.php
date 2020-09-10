<?php
        require_once("maconfig.php");
	require_once("../dbconnectvi.php");
        
        // Guided tour attributes 
        $tourIndustryId="24";
        $tourIndustryName="Education";
        // End of Tour Attributes
        
        /*echo '<pre>';
      print_r($_POST);
      echo '</pre>';*/
        
	$Db = new dbInvestments();
    include ('machecklogin.php');
    echo $_POST[ 'pe_checkbox_disbale' ];
	$mailurl= curPageURL();	
        $notable=false;
        $drilldownflag=1;
       $searchString="Undisclosed";
        $searchString=strtolower($searchString);

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);

        $searchString2="Others";
        $searchString2=strtolower($searchString2);

        $searchString3="Individual";
        $searchString3=strtolower($searchString3);
        //$searchString3ForDisplay=$searchString3;

        $searchString4="PE Firm(s)";
        $searchString4ForDisplay="PE Firm(s)";
        $searchString4=strtolower($searchString4);               
        
        $searchString6="Promoters";
        $searchString6=strtolower($searchString6);
         if( isset( $_POST[ 'period_flag' ] ) ) {
            $period_flag = $_POST[ 'period_flag' ];
        } else {
            $period_flag = 1;
        }

      
        if( isset( $_POST[ 'pe_checkbox_disbale' ] ) ) {
            $pe_checkbox = $_POST[ 'pe_checkbox_disbale' ];
        } else {
            $pe_checkbox = '';
        }
       $listallcompany = $_POST['listallcompanies'];
        if( isset( $_POST[ 'pe_checkbox_amount' ] ) ) {
            $pe_amount = $_POST[ 'pe_checkbox_amount' ];
        } else {
            $pe_amount = '';
        }
//==================================junaid================================================
        if( isset( $_POST[ 'pe_checkbox_company' ] ) ) {
            $pe_company = $_POST[ 'pe_checkbox_company' ];
        } else {
            $pe_company = 0;
        }

        
        if( isset( $_POST[ 'hide_company_array' ] ) ) {
            $hideCompanyFlag = $_POST[ 'hide_company_array' ];
        } else {
            $hideCompanyFlag = '';
        }

       
       // print_r($_POST);
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
            } else if(trim($_GET['searchallfield'])!="")
            {
            
                if(trim($_GET['searchallfield'])!=""){
                 
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                        $month1=01; 
                        $year1 = 2004;
                        $month2= date('n');
                        $year2 = date('Y');
                        
                    }else{
                        $month1=01; 
                        $year1 = 2004;
                        $month2= date('n');
                        $year2 = date('Y');
                    }
                }
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
             $_GET['searchallfield']="";
            }
            else if(trim($_GET['searchallfield'])!="" || trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" || trim($_POST['keywordsearch'])!="" )
            {
            
                if(trim($_POST['searchallfield'])!="" || trim($_GET['searchallfield'])!=""){
                 
                    if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                        $month1=01; 
                        $year1 = 2004;
                        $month2= date('n');
                        $year2 = date('Y');
                        
                    }else{
                        $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                        
                    }
                }
                if(trim($_POST['investorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['advisorsearch_legal'])!="" || trim($_POST['advisorsearch_trans'])!="" || trim($_POST['keywordsearch'])!=""){
                    /*$month1=01; 
                    $year1 = 2004;
                    $month2= date('n');
                    $year2 = date('Y');*/
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                        $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                        $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                        $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                }
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
        if($resetfield=="sectorsearch")
        { 
            $_POST['sectorsearch']="";
            $targetsectorsearch="";
        }
        else 
        {
            $targetsectorsearch=stripslashes(trim($_POST['sectorsearch']));
        }
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
            if($_POST['searchallfield'] != ""){
                $searchallfield=trim($_POST['searchallfield']);
            } else if($_GET['searchallfield'] != ""){
                $searchallfield=trim($_GET['searchallfield']);
            }
            
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
            $industry=$_POST['industry'];
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
            $acquirer_comptype = $_POST['acquirercompanytype'];
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
            $targetCountryId = $_POST['targetCountry'];
       }
        if($resetfield=="acountry")
        { 
            $_POST['acquirerCountry']="";
            $acquirerCountryId="--";
        }
        else 
        {
            $acquirerCountryId = $_POST['acquirerCountry'];
       }
       if(count($targetCountryId) > 0)
                {
                    $targetCountrySql = $targetcountryvalue = '';
                    foreach($targetCountryId as $targetCountryIds)
                    {
                        $targetCountrySql .= " countryid='$targetCountryIds' or ";
                    }
                    $targetCountrySql = trim($targetCountrySql,' or ');
                    $countrySql= "select countryid,country from country where $targetCountrySql";

                if ($targetCountryrs = mysql_query($countrySql))
        {
                        While($myrow=mysql_fetch_array($targetCountryrs, MYSQL_BOTH))
                {
                                $targetcountryvalue.=$myrow["country"].',';
                        }
                }
                    $targetcountryvalue=  trim($targetcountryvalue,',');
                    $targetcountry_hide = implode($targetCountryId,',');
        }

        if($acquirerCountryId !="--" && (count($acquirerCountryId) > 0))
        {
            $acquirerCountrySql = $acquirercountryvalue = '';
            foreach($acquirerCountryId as $acquirerCountryIds)
            {
                $acquirerCountrySql .= " countryid='$acquirerCountryIds' or ";
            }
            $acquirerCountrySql = trim($acquirerCountrySql,' or ');
            $AcountrySql= "select countryid,country from country where $acquirerCountrySql ";
                if ($Acountryrs = mysql_query($AcountrySql))
                {
                        While($Amyrow=mysql_fetch_array($Acountryrs, MYSQL_BOTH))
                        {
                        $acquirercountryvalue.=$Amyrow["country"].',';
                        }
                }
            $acquirercountryvalue=  trim($acquirercountryvalue,',');
            $acquirercountry_hide = implode($acquirerCountryId,',');
        }
       
       
       //valuation
        if($resetfield=="valuations")
        { 
            $_POST['valuations']="";
            $valuations="--";
            
        }
        else 
        {
            $valuations=$_POST['valuations'];
            $c=1;
            foreach($valuations as $v)
            {
                if($c > 1) { $coa=','; }
                $valuationstxt.= "$coa $v";
                $c++;
            }
            
            
        }

        if($_POST['valuations'] && $valuations!="")
        {
           $boolvaluations=TRUE;
           $valuationsql='';          
           $count = count($valuations);              
            if($count==1) { $valuationsql= "pe.$valuations[0]!=0 AND "; }
            else if ($count==2) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0   AND "; }
            else if ($count==3) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND "; }   
        }
        else
        {
            $boolvaluations=FALSE;
            $valuations="--";
            $valuationsql='';  
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
        /*if($industry >0)
        {
                $industrysql= "select industry from industry where IndustryId=$industry";
                if ($industryrs = mysql_query($industrysql))
                {
                        While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                        {
                                $industryvalue=$myrow["industry"];
                        }
                }
        }*/
        if($industry !='' && (count($industry) > 0))
        {
                    $indusSql = $industryvalue = '';
                    foreach($industry as $industrys)
                    {
                        $indusSql .= " IndustryId=$industrys or ";
                    }
                    $indusSql = trim($indusSql,' or ');
                    $industrysql= "select industry from industry where $indusSql";

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
            {	$sdatevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
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
            $sdatevalueCheck1 = trim($sdatevalueCheck1);
            $edatevalueCheck2 = trim($edatevalueCheck2);
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
	$topNav = 'Deals'; 
    include_once('maheader_search_new.php');
?>
   
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" style="margin-top:-10px;">
<tr>

 <td class="left-td-bg"> 
     <div class="acc_main">
     <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">
<?php  include_once('marefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
</div>
</td>

 
 <?php
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $SelCompRef=$value;
		
        //GET PREV NEXT ID
        $prevNextArr = array();
        $prevNextArr = $_SESSION['resultId'];

        $currentKey = array_search($SelCompRef,$prevNextArr);
        $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
        $nextKey = $currentKey+1;
	
        $exportToExcel=0;
        $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
        where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        //echo "<br>---" .$TrialSql;
        if($trialrs=mysql_query($TrialSql))
        {
                while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                {
                     $exportToExcel=$trialrow["TrialLogin"];
                }
        }
					
  	$sql="SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname,pe.Stake, pec.industry as industryId, i.industry, pec.sector_business,
		pec.countryid as TargetCountryId,pec.city as TargetCity,
		Amount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt,DATE_FORMAT(ModifiedDate,'%m/%d/%Y %H:%i:%s') as modifieddate,
		pec.website,c.country as TargetCountry, pe.MAMAId,pe.Comment,MoreInfor,pe.MADealTypeId,
		dt.MADealType,pe.AcquirerId,ac.Acquirer,pe.Asset,pe.hideamount,pe.Link,
		pe.uploadfilename,pe.source,pe.Valuation,pe.FinLink,
		Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,Revenue,EBITDA,PAT
		 FROM mama AS pe, industry AS i, pecompanies AS pec,
		 madealtypes as dt,acquirers as ac,country as c
		 WHERE  i.industryid=pec.industry and c.countryid=pec.countryid
		 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MAMAId=$SelCompRef
		 and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId";
	//echo "<br>********".$sql;
        
     $advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
     
     $advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
        
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advinv,
	advisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
    
    $companyidquery="SELECT pe.PECompanyId ,DATE_FORMAT( DealDate, '%b-%Y' ) as dt FROM mama AS pe, pecompanies AS pec
     WHERE pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MAMAId=$SelCompRef";
    $companyidexe=mysql_query($companyidquery);
    $companyidval = mysql_fetch_row($companyidexe);
    $companyid = $companyidval[0];
    $date = $companyidval[1];
    $acqidquery="SELECT pe.AcquirerId,ac.Acquirer FROM mama AS pe, acquirers as ac
     WHERE  pe.Deleted=0  and ac.AcquirerId=pe.AcquirerId  and pe.MAMAId=$SelCompRef";
    $acqidexe=mysql_query($acqidquery);
    $acqidval = mysql_fetch_row($acqidexe);
    $acqid = $acqidval[0];
    //echo "query:".$acqidquery." value:".$acqid;
    //$acqdate = $companyidval[1];
    //echo "values:".$companyid."".$date;

   $historysql="SELECT pe.PECompanyId,  pec.companyname,pe.Stake,  DATE_FORMAT( DealDate, '%b-%Y' ) as dt,
   Amount, pe.MAMAId,pe.AcquirerId,ac.Acquirer,pe.hideamount FROM mama AS pe, pecompanies AS pec,acquirers as ac
    WHERE pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 
    and ac.AcquirerId=pe.AcquirerId and pe.PECompanyId=$companyid group by pe.MAMAId order by DealDate desc";
    
    $acqtargetlistsql="SELECT pe.PECompanyId, pec.companyname,
    Amount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MAMAId,pe.AcquirerId,ac.Acquirer FROM mama AS pe,  pecompanies AS pec,
    acquirers as ac
     WHERE pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 
      and ac.AcquirerId=pe.AcquirerId and pe.AcquirerId=$acqid group by pe.MAMAId order by DealDate desc ";
     // echo  $acqtargetlistsql;
      //echo "query:".$acqtargetlistsql;

		
		if ($companyrs = mysql_query($sql))
		{  ?>
                      
                        
                    <?php if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
                    {
                        
                        $uploadname=$myrow["uploadfilename"];
			$currentdir=getcwd();
			$target = $currentdir . "../uploadmamafiles/" . $uploadname;

			$file = "../uploadmamafiles/" . $uploadname;

			$acquirerId=$myrow["AcquirerId"];
			$finlink=$myrow["FinLink"];
                        $industryId=$myrow["industryId"];
		//	echo "<br>---" .$acquirerId;
			$getAcquirerCityCountrySql = "select ac.CityId,ac.countryid,co.country,ac.IndustryId,i.industry,ac.Acqgroup from acquirers as ac,
			country as co,industry as i where ac.AcquirerId=$acquirerId  and co.countryid=ac.CountryId and i.industryid=ac.IndustryId";
		//	echo "<br>----" .$getAcquirerCityCountrySql;
                        if($cityrs=mysql_query($getAcquirerCityCountrySql))
                        {
                                if($mycityrow=mysql_fetch_array($cityrs,MYSQL_BOTH))
                                {
                                        $Acquirercityname=$mycityrow["CityId"];
                                        $Acquirercountryname=$mycityrow["country"];
                                        $AcquirerIndustryname=$mycityrow["industry"];
                                        $Acquirergroupname=$mycityrow["Acqgroup"];
                                }
                        }

                        $acquirerName=trim($myrow["Acquirer"]);
                        $acquirerName=strtolower($acquirerName);
                        $compResult3=substr_count($acquirerName,$searchString);
                        $compResult4=substr_count($acquirerName,$searchString4);
                        $compResult5=substr_count($acquirerName,$searchString3); //checking_for Individual string

                        $compResult6=substr_count($acquirerName,$searchString6);

                        //echo "<Br>--" .$compResult5;

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
                        elseif($myrow["hideamount"]==1)
                                $hideamount="";
                        else
                                $hideamount=$myrow["Amount"];

                        if($myrow["Stake"]==0)
                                $hidestake="";
                        else
                                $hidestake=$myrow["Stake"];

                        $moreinfor = $myrow["MoreInfor"];
                        $valuation=$myrow["Valuation"];
                        if($valuation!="")
                        {
                            $valuationdata = explode("\n", $valuation);
                        }

                        if($myrow["Company_Valuation"]<=0)
                            $dec_company_valuation=0.00;
                        else
                            $dec_company_valuation=$myrow["Company_Valuation"];
                        if($myrow["Revenue_Multiple"]<=0)
                            $dec_revenue_multiple=0.00;
                        else
                            $dec_revenue_multiple=$myrow["Revenue_Multiple"];

                        if($myrow["EBITDA_Multiple"]<=0)
                            $dec_ebitda_multiple=0.00;
                        else
                            $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
                        if($myrow["PAT_Multiple"]<=0)
                            $dec_pat_multiple=0.00;
                        else
                            $dec_pat_multiple=$myrow["PAT_Multiple"];
							
							

                        // New Feature 08-08-2016 start 

                                if($myrow["price_to_book"]<=0)
                                        $price_to_book=0.00;
                                else
                                        $price_to_book=$myrow["price_to_book"];


                                if($myrow["book_value_per_share"]<=0)
                                        $book_value_per_share=0.00;
                                else
                                        $book_value_per_share=$myrow["book_value_per_share"];


                                if($myrow["price_per_share"]<=0)
                                        $price_per_share=0.00;
                                else
                                        $price_per_share=$myrow["price_per_share"];
						
                                // New Feature 08-08-2016 end

                        
                                //if($myrow["Revenue"]!=0 && $myrow["Revenue"]!='' && $myrow["Revenue"]!='0.00'){
                                            
                                            $dec_revenue=$myrow["Revenue"];
                                       // }

                                       // if($myrow["EBITDA"]!=0 && $myrow["EBITDA"]!='' && $myrow["EBITDA"]!='0.00'){    
                                            
                                            $dec_ebitda=$myrow["EBITDA"];
                                        //}
                                        
                                       // if($myrow["PAT"]!=0 && $myrow["PAT"]!='' && $myrow["PAT"]!='0.00'){    
                                            $dec_pat=$myrow["PAT"];
                                      //  }
                        
                        if($myrow["target_listing_status"]=="L")
                              $target_listing_stauts_display="Listed";
                        elseif($myrow["target_listing_status"]=="U")
                              $target_listing_stauts_display="Unlisted";

                        if($myrow["acquirer_listing_status"]=="L")
                              $acquirer_listing_stauts_display="Listed";
                        elseif($myrow["acquirer_listing_status"]=="U")
                              $acquirer_listing_stauts_display="Unlisted";
                //	echo "<br>".$moreinfor;
                //echo "<br>".$searchstring;

                                /*** an array of words to highlight ***/
                                $words = array($searchstring);
                                //$words="warrants convertible";
                                /*** highlight the words ***/
                                $moreinfor =  highlightWords($moreinfor, $words);


                                $col6=$myrow["Link"];
                                $linkstring=str_replace('"','',$col6);
                                $linkstring=explode(";",$linkstring);


                        $webdisplay="";
                        if(($compResult==0) && ($compResult1==0))
                        {
                                $webdisplay=$myrow["website"];
                        }
                        }
		}
	 ?>
<style>
/* css for the 931 start */
.countryscroll{
    height:90px;
    overflow-y:scroll;
}
.result-title li.countryht{
                word-break: break-all ;
            }
.tooltip-box6{
    top: -21px;
}
.tooltip-box6{
        text-transform: unset !important;
        width: 96%;
    word-break: break-all;
    }
    .linkanchor {
    text-transform: unset !important;
    width: 89%;
    word-break: break-all;
    top: 22px;
}
.linkanchor a{
    display: block;
    font-weight: 500 !important;
}
.linkanchor{
    width: 93%;    top: 24px;
}
.linkanchor {
    position: absolute;
    background: #fff;
    color: #4e4e4e !important;
    text-transform: capitalize;
    font-size: 12px;
    padding: 5px;
    display: none;
    z-index: 1000;
    top: 50px;
    /* min-width: 364px; */
    border: 1px solid;
    line-height: 12px;
    box-shadow: 5px 4px 5px #969393;
}
.linkanchor {
    text-transform: unset !important;
    width: 89%;
    word-break: break-all;
    top: -35px;
}
.newslinktooltip{
    font-weight: 600;
    font-size: 13px;
}

input.senddeal{
padding: 4px 10px 4px 35px !important;
    background: #fff url(../dealsnew/images/deal-icon.png) no-repeat 10px 5px !important;
    text-transform: uppercase !important;
    font-weight: 700;
    font-size: 12px !important;
    border: 1px solid #e2e2e2 !important;
}
/* .result-select{
    border:none !important; 
} */
/* css for the 931 end */

    .mt-list-tab{
        margin-top: 100px;
    }
    #popup-box{
        top: 6%;
    }
    .entry p{
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .moreinfo_1,.moreinfo_1 td
    {
        background-color: transparent !important;
    }
    .dealinfo-content{
        height: 155px;
    }
    .moreinfo_1{
        height: 135px;
    }
    .more-info{
        padding: 5px 10px 20px 3px !important;
    }
    .moreinfo {
    color: #333 !important;
    /* font-size: 22px !important; */
    font-size: 19px !important;
    /*padding: 12px 13px !important;*/
    padding: 13px 13px 5px 0px !important;
    font-weight: 500;
    }
    .advisorinfo tbody td:last-child{
        border-bottom: 1px solid #e6e5e5 !important;
    }
    @media (min-width:1921px){
        .more_info .moreinfo_1{
            padding-right:0px !important;
        }
    }
</style>
<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt"> 
			<?php if ($accesserror==1){?>
                        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
            <?php
                    exit; 

                    } 
                   
                $ma_industries = explode(',', $_SESSION['MA_industries']);
                if(!in_array($industryId,$ma_industries)){

                    echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
                    exit;
                } 
            ?>                               
    <div class="result-title"> 
        
        <?php if(!$_POST){ ?> 
                            <h2>
                            <?php
                                if($studentOption==1 || $exportToExcel==1)
                                {
                             ?>
                                 <!--  <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span>  -->
                            <?php   } 
                                else 
                                {
                              ?>
                                   <!--   <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span>  -->
                           <?php
                                }
                               ?>
                                        <!--   <span class="result-for">  for Mergers & Acquisitions</span>
                                          <span class="result-amount-no" id="show-total-amount"><?php echo (isset($_SESSION['aggvalue'])?$_SESSION['aggvalue']:"") ?></span>  -->
                              
                             </h2>
                              <div class="title-links">
                                
                                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                        <?php 

                                        if(($exportToExcel==1))
                                             {
                                             ?>
                                                 <input class="export" type="button"  value="Export" name="showdeal">
                                             <?php
                                             }
                                         ?>
                                </div>
                              
                            <ul class="result-select" >
                                   <?php 
                                   if(trim($datevalueDisplay1)!="" && trim($datevalueDisplay2) !=''){  ?>
                                    <li> 
                                        <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } 
                                    else if(trim($datevalueCheck1) !="" && trim($datevalueCheck2) !='')
                                    {
                                     ?>
                                     <li > 
                                        <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
    
                                    
                                    <?php
                                    }
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

                                      <li class="industrytag"> 
                                        <?php echo $getindusvalue;?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                <?php }
                                
                                if($valuationstxt!=""){  ?>

                                <li> 
                                  <?php echo $valuationstxt;?><a  onclick="resetinput('valuations');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                 <?php } 
                                   
                                
                                ?>

                                <?php if($searchallfield!="" || $_GET['searchallfield'] !=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>

                               </ul> 
                                <?php
                                   }
                                   else 
                                   { ?> 
                                   <h2>
                                   <?php
                                 if($studentOption==1 || $exportToExcel==1)
                                        {
                                     ?>
                                         <!--  <span class="result-no"><?php echo count($prevNextArr); ?> Results Found</span>  -->
                                <?php   } 
                                        else 
                                        {
                                      ?>
                                            <!--  <span class="result-no"> <?php echo count($prevNextArr); ?> Results Found</span>  -->
                                   <?php
                                        } 
                                     ?>
                                           <!--   <span class="result-for">  for Mergers & Acquisitions </span> 
                                             <span class="result-amount-no" id="show-total-amount"><?php echo (isset($_SESSION['aggvalue'])?$_SESSION['aggvalue']:"") ?></span> -->
                                 
                             </h2>
                                 
                                <div class="title-links">
                                
                                        <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                                        <?php 

                                        if(($exportToExcel==1))
                                             {
                                             ?>
                                                 <input class="export" type="button"  value="Export" name="showprofile">
                                             <?php
                                             }
                                         ?>
                                </div>
                                <ul class="result-select">
                                <?php
                                 if(trim($datevalueDisplay1)!="" && trim($datevalueDisplay2) !=''){  ?>
                                    <li style="clear:both" > 
                                        <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php } 
                                    else if(trim($datevalueCheck1) !="" && trim($datevalueCheck2) !='')
                                    {
                                     ?>
                                     <li style="clear:both"> 
                                        <?php echo $datevalueCheck1. "-" .$datevalueCheck2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php
                                    }
                                    else if(trim($_GET['searchallfield'])!="" || trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
                                     {
                                        if(trim($sdatevalueDisplay1) !=''){
                                     ?>
                                     <li style="clear:both"> 
                                        <?php echo $sdatevalueDisplay1. "-" .$edatevalueDisplay2;?><a  onclick="resetinput('period');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php
                                     } }
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ $drilldownflag=0; ?>
                                <li >
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($dealtypeId >0){ $drilldownflag=0; ?>
                                <li>
                                    <?php echo $dealtypevalue; ?><a  onclick="resetinput('dealtype');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($target_comptype !="--" && $target_comptype !="") { $drilldownflag=0;?>
                                <li > 
                                    <?php echo $target_comptype_display; ?><a  onclick="resetinput('targetct');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($acquirer_comptype !="--" && $acquirer_comptype !=""){ $drilldownflag=0; ?>
                                <li > 
                                    <?php echo $acquirer_comptype_display; ?><a  onclick="resetinput('acquirerct');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if (($startRangeValue!= "--") && ($endRangeValue != "--") && ($startRangeValue!= "") && ($endRangeValue != "")){ $drilldownflag=0; ?>
                                <li > 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }                                
                                
                                if($valuationstxt!=""){  ?>

                                <li > 
                                  <?php echo $valuationstxt;?><a  onclick="resetinput('valuations');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                 <?php } 
                                 
                               
                                if($targetCountryId !="--" && $targetCountryId !="") { $drilldownflag=0; ?>
                                <li class="countryht"> 
                                    <?php echo  $targetcountryvalue;?><a  onclick="resetinput('tcountry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($acquirerCountryId !="--" && $acquirerCountryId !="") { $drilldownflag=0; ?>
                                <li class="countryht"> 
                                    <?php echo  $acquirercountryvalue;?><a  onclick="resetinput('acountry');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($targetcompanysearch!="" && $targetcompanysearch!=" "){ $drilldownflag=0; ?>
                                <li > 
                                    <?php echo $targetcompanysearch?><a  onclick="resetinput('companysearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($targetsectorsearch!="" && $targetsectorsearch!=" "){ $drilldownflag=0; ?>
                                <li > 
                                    <?php echo str_replace("'","",trim($targetsectorsearch));?><a  onclick="resetinput('sectorsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($acquirersearch)!="") { $drilldownflag=0; ?>
                                <li > 
                                    <?php echo $acquirersearch;?><a  onclick="resetinput('keywordsearch');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                               
                                if(trim($advisorsearchstring_legal)!="") { $drilldownflag=0; ?>
                                <li > 
                                    <?php echo $advisorsearchstring_legal?><a  onclick="resetinput('advisorsearch_legal');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if(trim($advisorsearchstring_trans)!=""){ $drilldownflag=0; ?>
                                <li > 
                                    <?php echo $advisorsearchstring_trans?><a  onclick="resetinput('advisorsearch_trans');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($searchallfield!="" || $_GET['searchallfield'] !=""){ $drilldownflag=0; ?>
                                <li > 
                                    <?php echo $searchallfield?><a  onclick="resetinput('searchallfield');"><img src="<?php echo $refUrl; ?>images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                //print_r($_POST);
//                                $cl_count = count($_POST);
                                if($drilldownflag ==0)
                                {
                                ?>
                                <!-- <li class="result-select-close"><a href="/ma/index.php"><img width="7" height="7" border="0" alt="" src="<?php echo $refUrl; ?>images/icon-close-ul.png"> </a></li> -->
                                <?php
                                }
                                ?>
                             </ul>
                                   <?php }?>
        
    </div>
    <div class="list-tab mt-list-tab"  style="background: #fff !important;">
    <?php
                           if(($compResult==0) && ($compResult1==0))
                           {
                               $display = 'no';
                               $string =rtrim($myrow["companyname"]);
                               $string = strip_tags($string);
                               if (strlen($string) > 40) { 
                                   $pos=strpos($string, ' ', 40);
                                   if($pos != ''){
                                       $string = substr($string,0,$pos );
                                   }else{
                                       $string = substr($string,0,40 );                            
                                   }
                                   $string = trim($string).'...';
                                   $display = 'yes';
                               }
                       ?>
                       <!--companydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$VCFlagValue.'/';?>-->
                               <h2 class="detailtitle text-center"> <a class="postlink companyProfileBox" href='javascript:void(0)'><?php echo stripslashes($string);?>
                                   <?php if($display == 'yes'){ ?>
                                        <div class="tooltip-box">
                                             <?php echo trim($myrow["companyname"]);?>
                                        </div>
                                   <?php } ?>                                   
                                </a>

                              </h2>
                      <?php
                           }else{
                      ?>
                              <h2 class="detailtitle text-center">  <?php echo rtrim($searchString);?></h2>
                      <?php
                           }
                           ?>
                           <div>
                      <ul class="inner-list inner-list_width1">
                        <li><a class="postlink list-view"  href="<?php echo $actionlink; ?>"  id="icon_grid-view"><!--<img src="images/list-icon.png" />--><i></i> <!-- List View --></a></li>
                        <li class="active"><a id="icon_detailed-view" class="postlink detail-view"  href="madealdetails.php?value=<?php echo $_GET['value'];?>" ><!--<img src="images/bar-icon.png" />--><i></i> <!-- Detail View --></a></li> 
                        </ul> 
      
            <?php
            //if($strvalue[3]!='Directory'){ ?>
                
                    <div class="inner-section inner-section-width1 redirection-icon">
                        <div class="action-links">
                        <?php if ($prevKey!='-1') {?> 
                            <a  class="postlink" id="previous" href="madealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>"> 
                            <!-- <img src="images/back_black.png" title="Previous" alt="Previous" /> -->
                            <span class="previous-icon"></span>
                            </a>
                        <?php }else{ ?>
                            <!-- <img src="images/back_grey.png" style="cursor:no-drop; margin-right:10px;" /> -->
                             <?php } ?>
                        <?php if ($nextKey < count($prevNextArr)) { ?>
                            <a class="postlink" id="next" href="madealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>">
                               <!--  <img src="images/forward_black.png" title="Next" alt="Next" />    -->
                               <span class="next-icon"></span>
                            </a>  
                            <?php }else{ ?><!-- <img src="images/forward_grey.png" style="cursor:no-drop;" />  -->
                        <?php } ?>
                        </div>
                    </div>
               
           
            <?php //} ?>
            </div> 
             </div>
             <br/>
             <div class="row masonry ">
             <div class="col-12">
                    <div  class="work-masonry-thumb1 col-6 companyinfo" id="company_info">
                        <div class="accordions">
                            <div class="accordions_dealtitle"><span></span>
                            <h2 id="companyinfo" class="box_heading content-box ">Deal Info <a style="float: right;font-size: 12px;margin-right:10px;color: #624C34;font-weight: normal;">Updated on : <?php echo $myrow["modifieddate"];?></a></h2>
                            </div>
                            <div class="accordions_dealcontent  dealinfo-content" style="    background: rgb(255, 255, 255);">
                     <table cellpadding="0" cellspacing="0" class="tablelistview3 companyinfo_table">
                    <tbody> 
                   
                      <tr>  
                            <td><h4>Deal Amount(US$M)</h4> </td>
                            <?php if($hideamount >0)
                        {
                            ?><td><p><?php echo $hideamount; ?></p></td> 
                            <?php
                        }
                        else
                        {
                            ?><td><?php echo "--";
                            ?></td> 
                            <?php
                        }?>                             
                      </tr>
                      <tr>  
                            <td><h4>Stake (%)</h4> </td>
                            <td><p><?php echo $hidestake; ?></p></td>                             
                      </tr>
                      <tr>  
                            <td><h4>Deal Type</h4> </td>
                            <td><p><?php echo $myrow["MADealType"]; ?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Deal Date</h4> </td>
                            <td><p><?php echo $myrow["dt"]; ?></p></td>                            
                      </tr>
                      
                                                                  </tbody>
                    </table>
                </div>
                        </div>
                    </div>
                    <div  class="work-masonry-thumb1 col-6 more_info"  style="   border: 1px solid transparent;    border-bottom: 1px solid transparent;margin-right:0px !important;">
                        <h3 id="moreinfo" class="moreinfo more-content"  style="border-bottom: 1px solid transparent;">More Info</h3>
                          <table class="tablelistview moreinfo_1" cellpadding="0" cellspacing="0" >
                                                                    <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                                                                              <?php if(trim($moreinfor) != ''){
                                                                                  echo '<br><br><br>';
                                                                              }?>
                                                                            <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-MandA&body=<?php echo $mailurl;?> " id="requestLink" >
                                      Click Here</a> to request more details for this deal. Please specify what details you would like and we will revert with the data points as available.
                                       </p></td></tr></table>
                    </div>
                    
            </div>

            </div>

    
    <div style="clear:both"></div>
    <div class="row section1 masonry" style="display: inline-flex;">
           
             <div class=" col-6 companyinfo" id="company_info" style="">
                 <div class="accordions">
                    <div class="accordions_dealtitle "><span></span>
                    <h2 id="companyinfo" class="box_heading content-box ">Target Info </h2>
                    </div>
                     <div class="accordions_dealcontent companydealcontent " style="    background: rgb(255, 255, 255);"><div id="mCSB_1" class="mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                     <table cellpadding="0" cellspacing="0" class="tablelistview3 companyinfo_table">
                    <tbody> 
                    <tr>  
                    <?php
				$companyName=trim($myrow["companyname"]);
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);
				$webdisplay="";
				$finlink=$myrow["FinLink"];
				if(($compResult==0) && ($compResult1==0))
				{
					$webdisplay=$myrow["website"];
		?>
                     
                                               <td style=""><h4>Company</h4></td>
                          
                          <td class="" style=""> 
                                    <div class="tooltip-4" style="float:left;"><p> <?php echo $openBracket;?><?php echo rtrim($myrow["companyname"]);?><?php echo $closeBracket ; ?>
                                            </p>
                                    </div>
                          </td>
                          <?php
				}
				else
				{
					$webdisplay=$myrow["website"];
		?>
				<td  ><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></td>
		<?php
				}
		?>

                                                
                      </tr>
                      <tr>  
                            <td><h4>Company Type</h4> </td>
                            <td class=""><p><?php if($target_listing_stauts_display!=""){  echo $target_listing_stauts_display;}else{echo "-";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Industry</h4> </td>
                            <td class=""><p><?php if($myrow["industry"]!=""){  echo $myrow["industry"];}else{echo "-";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Sector</h4> </td>
                            <td class=""><p><?php if($myrow["sector_business"]!=""){  echo $myrow["sector_business"];}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>City, Country</h4> </td>
                            <td class=""><p><?php if($myrow["TargetCity"]!=""){  echo $myrow["TargetCity"];} if($myrow["TargetCity"]!="" && $myrow["TargetCountry"]!=''){echo ", ";}if($myrow["TargetCountry"]!=''){  echo $myrow["TargetCountry"];}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Website</h4> </td>
                            <td class=""><p><?php if($myrow["website"]!=""){  echo $myrow["website"];}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Financials</h4> </td>
                            <td class=""><p><?php if($myrow["uploadfilename"]!=""){  ?><a href=<?php echo $file;?> target="_blank" > Click here </a> <?php }else{echo "";}?></p></td>                              
                      </tr>
                      <tr>
                        <td><h4>Link</h4></td>
                        <?php  foreach ($linkstring as $linkstr)
					{
						if(trim($linkstr)!=="")
						{ $showlink=1;
                                                }
                                        }
					?> 
                          <?php if($showlink==1){ ?>
                        <td class="newslinktooltip"> 
                           

                        <?php 
                            $display = 'no'; $news_link='';$count = 0;$showlinktext = false;
                            if(count($linkstring)>0) { 
                                $string = $stortlink = '';
                                foreach ($linkstring as $linkstr) {
                                    if(trim($linkstr)!=="") {
                                        $count = $count + 1;
                                        if($count > 1){
                                            $showlinktext = true;
                                        } else {
                                            $showlinktext = false;
                                        }
                                        if($string == '' && $display == 'no'){
                                            $string = strip_tags($linkstr);
                                            if (strlen($string) > 50) {
                                                $string = substr($string,0,50);  
                                                $string = trim($string).'...';
                                                $display = 'yes';
                                             }
                                            $stortlink = "<a href='".$linkstr."' target='_blank' data-target='#Link".$count."'>".$string."</a>";
                                        }

                                        // if($news_link != ''){
                                        //     $display = 'yes';
                                        // }
                                        $linktext .= "<a href='".$linkstr."' target='_blank' data-target='#Link".$count."'>Link ".$count."</a>".", ";
                                        $news_link = "<a href='".$linkstr."' target='_blank'>".$linkstr."</a>";   
                                        ?>
                                        <div class="linkanchor" id='Link<?php echo $count;?>'>
                                            <?php echo $news_link;?>
                                        </div>
                                 <?php        

                                    }
                                }
                                if($showlinktext){
                                    echo rtrim(trim($linktext), ',');
                                } else {
                                    echo $stortlink;
                                }
                            }else{ echo '&nbsp;'; } ?>
                        <?php if($display == ''){ ?>
                         <div class="tooltip-box6 linkanchor">
                    <?php echo $news_link; ?>
                        </div> <?php } 
                 }
				?>   
                       
                        </td>
                     </tr>
                                                                  </tbody>
                    </table>
                </div></div></div>

            </div>  
        </div>  
        <div class="col-6 companyinfo" id="company_info" style="margin-right: 0px;
/* width: 50%; */">
                 <div class="accordions">
                    <div class="accordions_dealtitle "><span></span>
                    <h2 id="companyinfo" class="box_heading content-box ">Acquirer Info </h2>
                    </div>
                     <div class="accordions_dealcontent companydealcontent " style="    background: rgb(255, 255, 255);"><div id="mCSB_1" class="mCustomScrollBox mCS-dark-3 mCSB_vertical mCSB_inside" tabindex="0"><div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                    <table cellpadding="0" cellspacing="0" class="tablelistview3 companyinfo_table">
                    <tbody> 
                      <tr>  
                                               <td style=""><h4>Acquirer</h4></td>
                          
                          <td class="" style=""> 
                                             <div class="tooltip-4" style="float:left;"><p>                                                 
                        
                                             <?php  if( ($compResult3==0) &&  ($compResult4==0) &&  ($compResult5==0) && ($compResult6==0))
                         {
         ?>
                         <b>
                         <a class="postlink" href='acquirerdetails.php?value=<?php echo $myrow["AcquirerId"];?>' >
                         <?php echo rtrim($myrow["Acquirer"]);?>
                         </a>
                         </b>
         <?php
                         }
                         elseif($compResult4==1)
                         {
                                 $webdisplay="";
         ?>
                         <b><?php echo ucfirst("$searchString4ForDisplay") ;?></b>
         <?php
                         }
                         elseif($compResult3==1)
                         {
                                         $webdisplay="";
                         ?>
                            <b><?php echo ucfirst("$searchString") ;?></b>
                         <?php
                         }
                         elseif($compResult5==1)
                         {
                                         $webdisplay="";
                         ?>
                                         <b><?php echo ucfirst("$searchString3") ;?></b>
                         <?php
                         } elseif($compResult6==1)
                         {
                                         $webdisplay="";
                         ?>
                                         <b><?php echo ucfirst("$searchString6") ;?></b>
                         <?php
                         }
                         ?>
                        
                        
                                            </p>
                        </div>
                        </td>
                                                
                      </tr>
                      <tr>  
                            <td><h4>Acquirer Company Type</h4> </td>
                            <td class=""><p><?php if($acquirer_listing_stauts_display!=""){  echo $acquirer_listing_stauts_display;}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Industry</h4> </td>
                            <td class=""><p><?php if($AcquirerIndustryname!=""){  echo $AcquirerIndustryname;}else{echo "";}?></p></td>                              
                      </tr>
                      <!-- <tr>  
                            <td><h4>Group</h4> </td>
                            <td class=""><p><?php if($Acquirergroupname!=""){  echo $Acquirergroupname;}else{echo "";}?></p></td>                              
                      </tr> -->
                      <tr>  
                            <td><h4>City, Country</h4> </td>
                            <td class=""><p><?php if($Acquirercityname!=""){  echo $Acquirercityname;} if($Acquirercityname!="" && $Acquirercountryname!=""){echo ", ";}if($Acquirercountryname!=""){ echo $Acquirercountryname;}?></p></td>                              
                      </tr>
                      </tbody>
                    </table>

                </div></div></div>

            </div>  
        </div>
             <div class="clear-sm"></div>
        
         </div>
         <div style="clear:both"></div>
    <div class="row masonry ">
       <div class="accordian-group">
            <div class="col-6 valuationinfo" >
                <div  class="work-masonry-thumb1 accordian-group">
                     <div class="accordions">
                        <div class="accordions_dealtitle active"><span></span>
                        <h2 class="box_heading content-box ">Valuation Info</h2>
                        </div>
                        <?php if($dec_company_valuation >0 || $dec_revenue_multiple >0 || $dec_ebitda_multiple >0 || $dec_pat_multiple >0 || $price_to_book >0 || $book_value_per_share >0 || $price_per_share >0 || $dec_revenue > 0 || $dec_revenue < 0 ||   $dec_ebitda > 0 || $dec_ebitda < 0 || $dec_pat > 0 || $dec_pat < 0 ){ ?>
                        <div class="accordions_dealcontent valuationcontent"  style="display: none;">
                        <?php } else {?>
                            <div class="accordions_dealcontent"  style="display: none;">
                        <?php }?>
                         <table cellpadding="0" cellspacing="0" class="tablelistview3 companyinfo_table valuation_info">
                    <tbody> 
                    <?php if($dec_company_valuation >0 || $dec_revenue_multiple >0 || $dec_ebitda_multiple >0 || $dec_pat_multiple >0 || $price_to_book >0 || $book_value_per_share >0 || $price_per_share >0 || $dec_revenue > 0 || $dec_revenue < 0 ||  $dec_ebitda > 0 || $dec_ebitda < 0 || $dec_pat > 0 || $dec_pat < 0  ){ ?>
                      <tr>  
                            <td><h4>Company Valuation - Enterprise Value (INR Cr)</h4> </td>
                            <td class=""><p><?php if($dec_company_valuation > 0){  echo $dec_company_valuation;}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Revenue Multiple (Based on EV)</h4> </td>
                            <td class=""><p><?php if($dec_revenue_multiple > 0){  echo $dec_revenue_multiple;}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>EBITDA Multiple (Based on EV)</h4> </td>
                            <td class=""><p><?php if($dec_ebitda_multiple > 0){  echo $dec_ebitda_multiple;}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>PAT Multiple (Based on EV)</h4> </td>
                            <td class=""><p><?php if($dec_pat_multiple >0){ echo $dec_pat_multiple;}else{echo "";}?></p></td>                              
                      </tr>
                      <!-- <tr>  
                            <td><h4>Price to Book</h4> </td>
                            <td class=""><p><?php if($price_to_book >0){  echo $price_to_book;}else{echo "";}?></p></td>                              
                      </tr>

                      <tr>  
                            <td><h4>Book Value Per Share</h4> </td>
                            <td class=""><p><?php if($book_value_per_share >0){  echo $book_value_per_share;}else{echo "";}?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Price Per Share</h4> </td>
                            <td class=""><p><?php if($price_per_share >0){  echo $price_per_share;}else{echo "";}?></p></td>                              
                      </tr> -->
                      <tr>  
                            <td><h4>Valuation (More Info)</h4> </td>
                            <td class=""><p><?php if(trim($myrow["Valuation"])!=""){  
                                foreach($valuationdata as $valdata)
                                    {
                                            if($valdata!="")
                                            {
                                                    print nl2br($valdata);
                                            }
                                    }
                             }else{echo "";}?>
                             </p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>Revenue (INR Cr)</h4> </td>
                            <td class=""><p><?php if($dec_revenue > 0 || $dec_revenue < 0){  echo $dec_revenue;}else{
                                if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                                    echo number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '');
                                }else{
                                    echo "";
                                }
                            }?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>EBITDA (INR Cr)</h4> </td>
                            <td class=""><p><?php if($dec_ebitda > 0 || $dec_ebitda < 0){  echo $dec_ebitda;}else{
                                 if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                                    echo number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                                 }
                                else{echo "";}
                                
                                }?></p></td>                              
                      </tr>
                      <tr>  
                            <td><h4>PAT (INR Cr)</h4> </td>
                            <td class=""><p><?php if($dec_pat > 0 || $dec_pat < 0){  echo $dec_pat;}else{
                                 if($dec_company_valuation >0 && $dec_pat_multiple >0){
                                    echo number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', ''); 
                                 }
                                else{echo "";}
                                
                                }?></p></td>                              
                      </tr>
                      <?php } else { ?>
                                        <tr>
                                            <td style="border-bottom: none !important;padding:0px !important;">
                                                <p class="text-center" style="padding: 10px;"> No data available. 
                                                    <!-- <a id="clickhere" href="mailto:database@ventureintelligence.com?subject=Request for more deal data-VC Investment&amp;body=http://localhost/ventureintelligence/dealsnew/dealdetails.php?value=144184063/0/&amp;scr=EMAIL " style="color: #624C34 !important;text-decoration: underline;">Click Here</a> -->
                                                    <a id="clickhere" href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> " style="color: #624C34 !important;text-decoration: underline;">Click Here</a>  
                                                to request.</p>
                                            </td>
                                        </tr>
                                   <?php }?>
                       </tbody>
                    </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                
               <?php 
                if($getcompanyrs= mysql_query($advcompanysql))
                {
                    $comp_cnt = mysql_num_rows($getcompanyrs);
                }
                if($rsinvcomp= mysql_query($adacquirersql)) {
                    $compinv_cnt = mysql_num_rows($rsinvcomp);
                }
                $totalInvestor = count($investor_ID);
                $totalAdvisor = $comp_cnt + $compinv_cnt;
                ?> 
            <div  class="work-masonry-thumb1 accordian-group advisorinfo" >
                     <div class="accordions">
                        <div class="accordions_dealtitle active"><span></span>
                        <h2 id="companyinfo" class="box_heading content-box ">Advisor Info</h2>
                        </div>
                         <div class="accordions_dealcontent" style="display: none;">
                            
                            <table cellspacing="0" cellpadding="0" class="tableInvest advisor_Table" >
                                <tbody>
                               <?php if($comp_cnt>0 || $compinv_cnt>0){ ?>  
                                <?php if($comp_cnt>0) { ?>
                                        <tr>
                                            <td style="width: 22%;">
                                                                              <h4 style="padding-top: 8px;">Advisor Target</h4></td>
                                            <td style="">
                                                <table cellspacing="0" cellpadding="0" class="tableInvest" style="border-left: 1px solid #ccc;">
                                                    <tbody>
                                                        
                                                        <tr>
                                                            
                                                            <td>
                                                                <table class="advisor_innerTable">
                                                                    <?php $firstChild = 0; While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH)) { ?>
                                                                        <tr>
                                                                                                                                       
                                                                            <td class="">
                                                                                <p><a href='maadvisor.php?value=<?php echo $myadcomprow["CIAId"];?>' target="_blank" style="color: #666 !important;">
                                                                                <?php echo $myadcomprow["cianame"]; ?></a> (<?php echo $myadcomprow["AdvisorType"];?>)
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </td>
                                            
                                        </tr>
                                    <?php } ?>
                                    <?php if($compinv_cnt>0) { ?>
                                        <tr>
                                             <td style="width: 22%;">
                                                                                <h4 style="padding-top: 8px;">Advisor - Acquirer</h4>
                                                                               </td>
                                            <td>
                                                <table cellspacing="0" cellpadding="0" class="tableInvest" style="border-left: 1px solid #ccc;">
                                                    <tbody>
                                                        
                                                        <tr>
                                                            
                                                            <td>
                                                                <table class="advisor_innerTable advisor_innerTable1">
                                                                <?php
                                                                        if ($getinvestorrs = mysql_query($adacquirersql))
                                                                        {
                                                                        While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                                                                        {
                                                                ?>
                                                                            <tr>
                                                                               
                                                                                <td class="">
                                                                                    <p>
                                                                                    <a  href='maadvisor.php?value=<?php echo $myadinvrow["CIAId"];?>' target="_blank" style="color: #666 !important;" >
                                                                                            <?php echo $myadinvrow["cianame"]; ?> (<?php echo $myadinvrow[3];?>)
                                                                                            </a>  
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                     <?php } else { ?>
                                        <tr>
                                            <td style="border-bottom: none !important;padding:0px !important;">
                                                <p class="text-center" style="padding: 10px;"> No data available. 
                                                    </p>
                                            </td>
                                        </tr>
                                     <?php } ?>
                                </tbody>
                            </table>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
            </div>

        </div>

    
    <div style="clear:both"></div>
    <div class="row masonry ">
            <div class="col-6">
                <div  class="work-masonry-thumb1 accordian-group">
                     <div class="accordions">
                        <div class="accordions_dealtitle active"><span></span>
                        <h2 id="companyinfo" class="box_heading content-box ">History of Transaction</h2>
                        </div>
                         <div class="accordions_dealcontent" style="display: none;padding-left:40px;">
                            <table cellspacing="0" cellpadding="0" class="tableInvest tablefin historytrans">
                                

                                    <?php 
                                   // echo $historysql;
                                    $historyexe= mysql_query($historysql);
                                    $historycount=mysql_num_rows($historyexe);
                                    if($historycount == 1){ ?>
                                        <tbody>
                                        <tr>
                                            <td style="border-bottom: none !important;padding:0px !important;">
                                                <p class="text-center" style="padding: 10px;font-weight:bold;"> No other transactions in the target company.</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    <?php } else { ?>
                                         <thead>

                                                                <tr>
                                                                    <th style="width: 35%;">Acquirer</th> 
                                                                    <th style="width: 25%;">Date</th>
                                                                    <th style="width: 25%;" class="table-width1">Amount(US$M)</th>
                                                                    <th class="table-width2">Stake</th>
                                                                   </tr>
                                                            </thead>
                                                            <tbody>
                                                          <?php  While($myrow=mysql_fetch_array($historyexe, MYSQL_BOTH))
				{  $acquirerName=trim($myrow["Acquirer"]);
                    $acquirerName=strtolower($acquirerName);
                    $compResult3=substr_count($acquirerName,$searchString);
                    $compResult4=substr_count($acquirerName,$searchString4);
                    $compResult5=substr_count($acquirerName,$searchString3); //checking_for Individual string

                    $compResult6=substr_count($acquirerName,$searchString6);

                    // if($SelCompRef != $myrow['MAMAId']){
                        ?>
                                                    <tr>
                                                
   <!-- <td><p><a  href="acquirerdetails.php?value=<?php echo $myrow['AcquirerId']; ?>" target="_blank"><?php echo $myrow['Acquirer']; ?></a></p></td>  -->
   <td class="" style=""> 
                                             <div class="tooltip-4" style="float:left;"><p>                                                 
                        
                                             <?php  if( ($compResult3==0) &&  ($compResult4==0) &&  ($compResult5==0) && ($compResult6==0))
                         {
         ?>
                         <b>
                         <a  href='acquirerdetails.php?value=<?php echo $myrow["AcquirerId"];?>' target="_blank">
                         <?php echo rtrim($myrow["Acquirer"]);?>
                         </a>
                         </b>
         <?php
                         }
                         elseif($compResult4==1)
                         {
                                 $webdisplay="";
         ?>
                         <b> <a  href='acquirerdetails.php?value=<?php echo $myrow["AcquirerId"];?>' target="_blank"><?php echo ucfirst("$searchString4ForDisplay") ;?></a></b>
         <?php
                         }
                         elseif($compResult3==1)
                         {
                                         $webdisplay="";
                         ?>
                            <b><a  href='acquirerdetails.php?value=<?php echo $myrow["AcquirerId"];?>' target="_blank"><?php echo ucfirst("$searchString") ;?></a></b>
                         <?php
                         }
                         elseif($compResult5==1)
                         {
                                         $webdisplay="";
                         ?>
                                         <b><a  href='acquirerdetails.php?value=<?php echo $myrow["AcquirerId"];?>' target="_blank"><?php echo ucfirst("$searchString3") ;?></a></b>
                         <?php
                         } elseif($compResult6==1)
                         {
                                         $webdisplay="";
                         ?>
                                         <b><a  href='acquirerdetails.php?value=<?php echo $myrow["AcquirerId"];?>' target="_blank"><?php echo ucfirst("$searchString6") ;?></a></b>
                         <?php
                         }
                         ?>
                        
                        
                                            </p>
                        </div>
                        </td>
   
   <td><p><a  href="madealdetails.php?value=<?php echo $myrow['MAMAId']; ?>" target="_blank"><?php echo $myrow["dt"]; ?></a></p></td> 
   <?php
   if($myrow["Amount"] >0)
   {
      ?><td><p><?php echo $myrow["Amount"]; ?></p></td> 
      <?php
   }
   else
   {
    ?><td><?php echo "--";
    ?></td> 
      <?php
   }?>
   <?php
   if($myrow["Stake"] >0)
   {
      ?><td><p><?php echo $myrow["Stake"]; ?></p></td> 
      <?php
   }
   else
   {
    ?><td><?php echo " ";
    ?></td> 
      <?php
   }?>
   <!-- <td><p><?php //echo $myrow["Stake"]; ?><p></td>  -->
  
                                                    </tr>
<?php //}
}
?>
                                                    
            </tbody>
                                           
                                    <?php } ?>
                                
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                
               <?php 
                if($getcompanyrs= mysql_query($advcompanysql))
                {
                    $comp_cnt = mysql_num_rows($getcompanyrs);
                }
                if($rsinvcomp= mysql_query($adacquirersql)) {
                    $compinv_cnt = mysql_num_rows($rsinvcomp);
                }
                $totalInvestor = count($investor_ID);
                $totalAdvisor = $comp_cnt + $compinv_cnt;
                ?> 
            <div  class="work-masonry-thumb1 accordian-group" >
                     <div class="accordions">
                        <div class="accordions_dealtitle active"><span></span>
                        <h2 id="companyinfo" class="box_heading content-box ">Other Deals by Same Acquirer</h2>
                        </div>
                         <div class="accordions_dealcontent" style="display: none;padding-left:40px;">
                         <table cellspacing="0" cellpadding="0" class="tableInvest tablefin historytrans">
                         <?php 
                       //  echo $acqtargetlistsql;
                         $acqexe= mysql_query($acqtargetlistsql);
                                    $acqcount=mysql_num_rows($acqexe);
                                    if($acqcount == 1){ ?>
                                        <tbody>
                                        <tr>
                                            <td style="border-bottom: none !important;padding:0px !important;">
                                                <p class="text-center" style="padding: 10px;font-weight:bold;">No data available on Acquirer's other transactions.</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                    <?php } else { ?>
                                         <thead>

                                                                <tr>
                                                                    <th style="width: 35%;">Target</th> 
                                                                    <th style="width: 25%;">Date</th>
                                                                    <th style="width: 25%;" class="table-width1">Amount(US$M)</th>
                                                                    
                                                                   </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php  While($myrow=mysql_fetch_array($acqexe, MYSQL_BOTH))
                                                           // print_r($myrow);
				{ 
                   // if( $SelCompRef != $myrow['MAMAId']){
                        ?>
                                                    <tr>
                                                
   <td><p><a href="madealdetails.php?value=<?php echo $myrow['MAMAId']; ?>" target="_blank"><?php echo $myrow['companyname']; ?></a></p></td> 
   <td><p><a href="madealdetails.php?value=<?php echo $myrow['MAMAId']; ?>" target="_blank"><?php echo $myrow["dt"]; ?></p></td> 
   <?php
   if($myrow["Amount"] >0)
   {
      ?><td><p><?php echo $myrow["Amount"]; ?></p></td> 
      <?php
   }
   else
   {
    ?><td><?php echo "--";
    ?></td> 
      <?php
   }?>
  
  
                                                    </tr>
<?php //}
}?>
            </tbody>
                                           
                                    <?php } ?>
                                
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

        </div>

    
    <div style="clear:both"></div>
    



    </div>
  
</td>

 

</tr>
</table>
 
</div>
<input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
<!-- <input type="hidden" name="pe_checkbox" id="pe_checkbox" value="<?php echo $pe_checkbox; ?>" /> -->
<input type="hidden" name="pe_amount" id="pe_amount" value="<?php echo $pe_amount; ?>" />
<input type="hidden" name="pe_hide_companies" id="pe_hide_companies" value="<?php echo $hideCompanyFlag; ?>" />
<?php if($_POST['all_checkbox_search']==1){ ?>
    <input type="hidden" name="pe_company" id="pe_company" value="" />
    
<?php }else{ ?>
    
    <input type="hidden" name="pe_company" id="pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<?php } ?>
<input type="hidden" name="hide_pe_company" id="hide_pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<input type="hidden" name="uncheckRows" id="uncheckRows" value="<?php echo $_POST['pe_checkbox_disbale']; ?>" /> 
<input type="hidden" name="full_uncheck_flag" id="full_uncheck_flag" value="<?php echo $_POST['all_checkbox_search']; ?>" />

<?php if($_POST['real_total_inv_deal']!=''){ ?>
    <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php echo $_POST['real_total_inv_deal']; ?>" />
<?php }
if($_POST['real_total_inv_amount']!='') { ?>
    <input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php echo $_POST['real_total_inv_amount']; ?>" />
<?php } 
if($_POST['real_total_inv_company']!='') { ?>
    <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php echo $_POST['real_total_inv_company']; ?>" />
<?php }

/*if($_POST['all_checkbox_search']==1){ */?>
    
<input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php echo $_POST['total_inv_deal']; ?>">
<input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php echo $_POST['total_inv_amount']; ?>">
<input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php echo $_POST['total_inv_company']; ?>">

<?php //} 

if($_POST['pe_checkbox_enable']!=''){ ?>
    <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo $_POST['pe_checkbox_enable']; ?>">
<?php }
?>

</form>
<form name="companyDisplay" id="companyDisplay" method="post" action="exportMA.php">
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
        $(".newslinktooltip a").mouseover(function(){
            $($(this).attr('data-target')).css("display","block");
        });  
        $(".newslinktooltip a").mouseout(function(){
            $($(this).attr('data-target')).css("display","none");
        });
        $('.list-tab').css('margin-top',$('.result-title').height()+45);
        $('#cancelbtnn').on('click',function(){ 
            jQuery('#popup-box').fadeOut();   
            jQuery('#maskscreen').fadeOut(1000);
            return false;
        });
        $('#mailbtn').click(function(){ 
                        
                        if(checkEmail())
                        {
            
            
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress").val(), subject : $("#subject").val() , basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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
    
     $('.export').click(function(){ 
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
    
    $('#senddeal').click(function(){ 
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#popup-box').fadeIn();   
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

                    if (currentRec < remLimit){
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

                    
                 $("a.postlink").click(function(){
                  
                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    
                    $("#pesearch").attr("action", hrefval);
                    setCurControl("postlink");
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
 $portArray = array( '80', '443' );
 if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
 $URL .= "://";
 if (!in_array( $_SERVER["SERVER_PORT"], $portArray) ) {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL=$URL."&scr=EMAIL";
 
 return $pageURL;
}

mysql_close();
?>
<div class="lb" id="popup-box">
	<div class="title">Send this deal to your Colleague</div>
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
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>" />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['MAUserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                    <h5>Your Message<span style='float:right;font-weight: 500;'>Words left: <span id="word_left">200</span></span></h5>
                    <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtnn" />
            </div>

        </form>
    </div>
<script type="text/javascript" >
             
             $("#panel").animate({width: 'toggle'}, 200); 
             $(".btn-slide").toggleClass("active"); 
             if ($('.left-td-bg').css("min-width") == '264px') {
                $('.left-td-bg').css("min-width", '36px');
                $('.acc_main').css("width", '35px');
                $('.result-select').css('max-width', '94%');
               
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
<script>
        //   $("#panel").animate({width: 'toggle'}, 200); 
        //      $(".btn-slide").toggleClass("active"); 

        //      if ($('.left-td-bg').css("min-width") == '264px') {
        //      $('.left-td-bg').css("min-width", '36px');
        //      $('.acc_main').css("width", '35px');


        //      }
        //      else {
        //      $('.left-td-bg').css("min-width", '264px');
        //      $('.acc_main').css("width", '264px');
        //      } 
        //        $(".btn-slide").click(function(){
        //         if($(window).width()<1300){
        //                     hidestring=27;
        //                     hidestring1 = 20;
        //                 }


        //         if ($('.left-td-bg').css("min-width") == '264px') {
        //             if($(window).width()<1500 && $(window).width() > 1280){
        //                 $('.col-md-6').css("width", '82%');
        //             } else if($(window).width() > 1500){
        //                 $('.col-md-6').css("width", '75%');
        //             } else if($(window).width() < 1280){
        //                 $('.col-md-6').css("width", '100%');
        //             }
        //          }
        //          else {
        //            // if($(window).width()<1500 && $(window).width() > 1280){
        //                 $('.col-md-6').css("width", '100%');
        //            // }
        //          } 
        //        });                         
    $(document).ready(function(){
         
        var companytableoverall=$(".companyinfo_table").outerHeight()+50;
        var companytable=$(".companyinfo_table").outerHeight()+30;
        //alert(companytable);
        //$(".moreinfo_1").css("height",companytable);
        var tablecontent=$(".companyinfo").height();
        var topmanagement = '-'+$(".topmanagement").outerHeight();
        $(".topmanagement").css("top",topmanagement);

        // var linkanchor = '-'+$(".linkanchor").outerHeight();
        // $(".linkanchor").css("top",topmanagement);
        
        //$(".companydealcontent").css("height",companytableoverall);
        $('.moreinfo_1').mCustomScrollbar({ 
                theme:"dark-3",
            });
    });
   /* $(".accordions_dealtitle span").on("click", function() {
    
    $(this).parent().toggleClass("active").next().slideToggle();
    });*/
    
    $(document).on('click','#allfinancial',function(event){
            event.stopPropagation();
            $(".popup_main").show();
            $('body').css('overflow', 'hidden');
    });
    
    $(document).on('click','#allshp',function(event){
            event.stopPropagation();
            $(".popup_shp").show();
            $('body').css('overflow', 'hidden');
    });

    // $(".accordions_dealtitle span").on("click", function() {
    
    //     $(this).toggleClass("active").next().slideToggle();
    // });
    // (function($){
    //     $(window).on("load",function(){

    //         $(".moreinfo_1").mCustomScrollbar('update');
             
    //     });
    // })(jQuery); 
</script>

<?php //if($board_cnt > 0) { ?>
     <script>
        $('.companydealcontent').mCustomScrollbar({ 
                theme:"dark-3"        
            }); 
            $('.valuationcontent').mCustomScrollbar({ 
                theme:"dark-3"        
            }); 
            $(".tooltip7 span.lead").mouseover(function(){
               
                    $(this).next().css("display","block");
                });
               $(".tooltip7 span.lead").mouseout(function(){
                        $(this).next().css("display","none");
                    }); 

               $(".tooltip7 span.new").mouseover(function(){
                
                    $(this).next().css("display","block");
                });
               $(".tooltip7 span.new").mouseout(function(){
              
                        $(this).next().css("display","none");
                    });    
     </script>
<script src="../dealsnew/hopscotch.js"></script>
    <script src="../dealsnew/demo.js"></script>
    
        <script type="text/javascript" >
              $(document).ready(function(){
    <?php 
    // Guided tour attributes 
    $tourIndustryId="24";
    // End of Tour Attributes
     if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1'){
    if(isset($_POST["searchpe"])){?>
            //init();
            hopscotch.startTour(tour, 3);
    <?php } 
          else if(isset($_POST["controlName"])) {
            
                switch ($_POST["controlName"]) {
                    case 'dealperiod': ?>
                           hopscotch.startTour(tour, 5);
                   <?php break;
                   case 'industry':
                       if($_POST["industry"]==$tourIndustryId){
                       ?>
                           hopscotch.startTour(tour, 7);
                       <?php }else { ?>
                           hopscotch.startTour(tour, 6);
                       <?php } break;
                   case 'postlink':
                       ?>
                           hopscotch.startTour(tour, 8);
                       <?php break;
                    default:  ?>
                        init();
                   <?php break;
                }
            
        }  
        else { ?>
                    init();
     <?php } }else { ?> 
      init();
     <?php  } ?>
                });
        //     $( window ).scroll(function() {
        //     hopscotch.refreshBubblePosition();
        //   });
           
        </script>
        <?php mysql_close(); ?>