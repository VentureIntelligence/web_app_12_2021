<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '0';
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
        }
        else
        {
            $vcflagValue=$strvalue[0];
            $VCFlagValue=$strvalue[0];
        }
        
	if($vcflagValue==0)
        {$videalPageName="PEIpo";}
        else {$videalPageName="VCIpo";}
        include('checklogin.php');
        $mailurl= curPageURL();
        $getyear = $_REQUEST['y'];
        $getindus = $_REQUEST['i'];
        $getstage = $_REQUEST['s'];
        $getinv = $_REQUEST['inv'];
        $getreg = $_REQUEST['reg'];
        $getrg = $_REQUEST['rg'];
        
         $fetchRecords=true;
        $totalDisplay="";

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
            //     $month1= date('n', strtotime(date('Y-m')." -2   month")); 
            //     $year1 = date('Y');
            //     $month2= date('n');
            //     $year2 = date('Y'); 
            // if($type==1)
            // {
            //     $fixstart=1998;
            //     $startyear =  $fixstart."-01-01";
            //     $fixend=date("Y");
            //     $endyear = $endyear = date("Y-m-d");
            // }
            // else 
            // {
            //     $fixstart=2009;
            //     $startyear =  $fixstart."-01-01";
            //     $fixend=date("Y");
            //     $endyear = date("Y-m-d");
            //  }

              if($type == 1)
                {
                    $month1= date('n', strtotime(date('Y-m')." - 1   month")); 
                    $year1 = date('Y');
                    $month2= date('n');
                    $year2 = date('Y'); 
                    $fixstart=1998;
                    $startyear =  $fixstart."-01-01";
                    $fixend=date("Y");
                    $endyear = date("Y-m-d");
                }
                else 
                {
                    $month1= date('n');
                    $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                    $month2= date('n');
                    $year2 = date('Y');
                    $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                    $startyear =  $fixstart."-".$month1."-01";
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
            }elseif (($resetfield=="searchallfield")||($resetfield=="investorsearch")||($resetfield=="sectorsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch"))
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
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['investorsearch'])!="" || trim($_POST['sectorsearch'])!=""  || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch'])!=""  )
            {
            
             $month1=01; 
             $year1 = 1998;
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
        
        if($resetfield=="investorsearch")
        { 
         $_POST['investorsearch']="";
         $keyword="";
        }
        else 
        {
          $keyword= $_POST['investorsearch'];
        }
        $keywordhidden= trim($keyword);
        
        if($resetfield=="companysearch")
        { 
         $_POST['companysearch']="";
         $companysearch="";
        }
        else 
        {
         $companysearch=trim($_POST['companysearch']);
        }
        $companysearchhidden= trim($companysearch);
        if($resetfield=="advisorsearch")
        { 
         $_POST['advisorsearch']="";
         $advisorsearch="";
        }
        else 
        {
         $advisorsearch=trim($_POST['advisorsearch']);
        }
        $advisorsearchhidden= trim($advisorsearch);
        $advisorsearch="";
        
        
        
        if($getyear !='')
        {
            $getdt1 = $getyear.'-01-01';
            $getdt2 = $getyear.'-12-31';
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
            if($resetfield=="industry")
            { 
             $_POST['industry']="";
             $industry="";
            }
            else 
            {
             $industry=trim($_POST['industry']);
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
            if($resetfield=="exitstatus")
            { 
             $_POST['exitstatus']="";
             $exitstatusvalue="";
            }
            else 
            {
             $exitstatusvalue=trim($_POST['exitstatus']);
            }
          // echo "<br>___".$exitstatusvalue;
            if($resetfield=="investorSale")
            { 
             $_POST['invSale']="";
             $investorSale="";
            }
            else 
            {
             $investorSale=trim($_POST['invSale']);
            }
            if($resetfield=="returnmultiple")
            { 
             $_POST['txtmultipleReturnFrom']="";
             $txtfrm=""; 
             $_POST['txtmultipleReturnTo']="";
             $txtto="";
            }
            else 
            {
             $txtfrm=trim($_POST['txtmultipleReturnFrom']);
             $txtto=trim($_POST['txtmultipleReturnTo']);
            }
            

            $notable=false;
            $vcflagValue=$_POST['txtvcFlagValue'];

            $searchallfield=$_POST['searchallfield'];
            $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

            //	echo "<br>FLAG VALIE--" .$vcflagValue;
            if($vcflagValue==0)
            {
                    $addVCFlagqry = "" ;
                    $searchTitle = "List of PE-backed IPOs ";
                    $searchAggTitle = "Aggregate Data - PE-backed IPOs ";
            }
            elseif($vcflagValue==1)
            {
                    $addVCFlagqry = " and VCFlag=1 ";
                    $searchTitle = "List of VC-backed IPOs ";
                    $searchAggTitle = "Aggregate Data - VC-backed IPOs ";
            }
             //echo "<br> InvestorType=". $investorType;
            //echo "<br>Investor search*- ". $keyword ;
            /*echo "<br>Company search*- " .$companysearch;
            echo "<br>Advisor search*- " .$advisorsearch;
            echo "<br>Industry*- " .$industry;
            echo "<br>Dates- " .$month1 ." ** " .$year1. " ** " .$month2. " ** " .$year2 ; */


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
                
		$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
		$splityear1=(substr($year1,2));
		$splityear2=(substr($year2,2));

		if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
		{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
			$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                        
                        $dt1 = $year1."-".$month1."-01";
                        $dt2 = $year2."-".$month2."-01";
                        $wheredates1= "";
		}

	       $aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize) as totalamount from ipos as pe,industry as i,pecompanies as pec where";

		if($range != "--")
		{
			$rangesql= "select startRange,EndRange from investmentrange where InvestRangeId=". $range ." ";
			if ($rangers = mysql_query($rangesql))
			{
				While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
				{
					$startRangeValue=$myrow["startRange"];
					$endRangeValue=$myrow["EndRange"];
					$rangeText=$myrow["RangeText"];

				}
			}
		}
		if($exitstatusvalue=="0")
		  $exitstatusdisplay="Partial Exit";
		elseif($exitstatusvalue=="1")
                  $exitstatusdisplay="Complete Exit";
                else
                  $exitstatusdisplay="";

	$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

		$strvalue = explode("/", $value);
                $SelCompRef=$strvalue[0];
                $pe_re=$strvalue[1];
		$searchstring=$strvalue[1];
                $dealvalue=$strvalue[2];
	//$SelCompRef=$value;

  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
  	pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,
  	pec.website, pec.city, pec.region,pe.IPOId,Comment,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,
          pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,pe.InvestorType, its.InvestorTypeName,Valuation,FinLink,
          Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,ExitStatus
   	FROM ipos AS pe, industry AS i, pecompanies AS pec,investortype as its
  	WHERE pec.industry = i.industryid and pe.IPOId=$SelCompRef  and
  	pec.PEcompanyId = pe.PECompanyId     and its.InvestorType=pe.InvestorType
  	and pe.Deleted=0 order by IPOSize desc,i.industry";
	//echo "<br>".$sql;

	$investorSql="SELECT peinv.IPOId, peinv.InvestorId, inv.Investor,MultipleReturn,InvMoreInfo
	FROM ipo_investors AS peinv, peinvestors AS inv
	WHERE peinv.IPOId =$SelCompRef
	AND inv.InvestorId = peinv.InvestorId";

	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;
        
        $industrysql = $industrysql_search = "select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")" . $hideIndustry . " order by industry";
	
        
	if($strvalue[3]=='Directory'){

        $dealvalue=$strvalue[2];
	$topNav = 'Directory';
	include_once('dirnew_header.php');
    }else{
        $topNav = 'Deals'; 
        include_once('tvheader_search_detail.php');
    }
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr><?php
if($dealvalue==101)
{
 ?>

<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;"> 
<?php //include_once('newdirrefine.php');?>
        <?php
            if($VCFlagValue==0){

                $pageUrl="index.php?value=0";
                $pageTitle="VC Investment";
                $refineUrl="refine.php";
            }elseif($VCFlagValue==1){

                $pageTitle="PE Investment";
                $pageUrl="index.php?value=1";
                $refineUrl="refine.php";
            }elseif($VCFlagValue==3){

                $pageTitle="Social Venture Investment";
                $pageUrl="svindex.php?value=3";
                $refineUrl="svrefine.php";
            }elseif($VCFlagValue==4){

                $pageUrl="CleanTech Investment";
                $pageUrl="svindex.php?value=4";
                $refineUrl="svrefine.php";
            }elseif($VCFlagValue==5) {

                $pageTitle="Infrastructure Investment";
                $pageUrl="svindex.php?value=5";
                $refineUrl="svrefine.php";
            }
            include_once($refineUrl); 
            ?>

     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
    </div>
</td>
    <?php
}

	//GET PREV NEXT ID
	$prevNextArr = array();
	$prevNextArr = $_SESSION['resultId'];
	$currentKey = array_search($SelCompRef,$prevNextArr);
	$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
	$nextKey = $currentKey+1;

  	if ($companyrs = mysql_query($sql))
        {
        
	?>
		

		<?php
			$exportToExcel=0;
			$TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
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
			$hideamount="";
			$hidemoreinfor="";
			$moreinfo_returns="";
			$selling_investors_value="";
		if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
		{
                        $investor_sale_value=$myrow["InvestorSale"];
                        if($investor_sale_value==1)
                           $investor_sale_display="Yes";
                        else
                           $investor_sale_display="No";
                        if($myrow["Company_Valuation"]<=0)
                           $dec_company_valuation=0.00;
                        else
                           $dec_company_valuation=$myrow["Company_Valuation"];
                        if($myrow["Sales_Multiple"]<=0)
                            $dec_sales_multiple=0.00;
                        else
                            $dec_sales_multiple=$myrow["Sales_Multiple"];

                       	if($myrow["EBITDA_Multiple"]<=0)
                            $dec_ebitda_multiple=0.00;
                        else
                            $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];
                       	if($myrow["Netprofit_Multiple"]<=0)
                            $dec_netprofit_multiple=0.00;
                        else
                            $dec_netprofit_multiple=$myrow["Netprofit_Multiple"];

                        if(($myrow["SellingInvestors"]!=""))
                        { 
                          //echo "<br>**";
                          $selling_investors_value=$myrow["SellingInvestors"];}
                        else
                        {$selling_investors_value=""; }
                       $valuation=$myrow["Valuation"];
		       if($valuation!="")
		       {      $valuationdata = explode("\n", $valuation);      }
                        $finlink=$myrow["FinLink"];
                        //echo "<bR>--" .$finlink;
			if($myrow["hideamount"]==1)
			{
				$hideamount="--";
			}
			else
			{
				$hideamount=$myrow["IPOSize"];
			}

			if($myrow["hidemoreinfor"]==1)
			{
				$hidemoreinfor="--";
			}
			else
			{
				$hidemoreinfor=$myrow["MoreInfor"];
	      	        }
	      	        if($hidemoreinfor!="--")
			{
				$string = $hidemoreinfor;
				/*** an array of words to highlight ***/
				$words = array($searchstring);
				//$words="warrants convertible";
				/*** highlight the words ***/
				$hidemoreinfor =  highlightWords($string, $words);
			}
			$moreinfo_returns=$myrow["MoreInfoReturns"];
                        if(($moreinfo_returns=="")&& ($moreinfo_returns==" "))
                        {
                          $moreinfo_returns="";
                        }

			$investmentdeals=$myrow["InvestmentDeals"];
			if($investmentdeals!="")
			{
				$words = array($searchstring);
				$investmentdeals =  highlightWords($investmentdeals, $words);
			}
                        $iposize=$myrow["IPOAmount"];
                        if($iposize<=0)
                        { $iposize="";}
                        $ipovaluation=$myrow["IPOValuation"];
                        if($ipovaluation<=0)
                        {  $ipovaluation="";}

	      	        $col6=$myrow["Link"];
			$linkstring=str_replace('"','',$col6);
			$linkstring=explode(";",$linkstring);

			$estimatedirrvalue=$myrow['EstimatedIRR'];
			$estimatedirrvalue=trim($estimatedirrvalue);
			
			
		     ?>
<td class="profile-view-left" style="width:100%;">

<div class="result-cnt">

   <?php if ($accesserror == 1){?>
            <div class="alert-note"><b style="font-size: 16px;">You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
        exit; 
        } 
        ?> 

    <?php

        $pe_industries = explode(',', $_SESSION['PE_industries']);
        if(!in_array($myrow["industryId"],$pe_industries)){

            echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
            exit;
        }
    ?>
<div class="result-title"> 
                
               <?php 
               if ($companylistrs = mysql_query($companysql))
                     {
                        $company_cnt = mysql_num_rows($companylistrs);
                     }
                    if(!$_POST)
                    {
                        if(($exportToExcel==1))
                        {
                        ?>
                        <div class="title-links " id="export-btn"><input type="button" class="export exlexport"  value="Export" name="showdeal"></div><br>
                        <?php
                        }
                        
                  }
                  else 
                   { 
                    if(($exportToExcel==1))
                    {
                    ?>
                    <div class="title-links " id="export-btn"><input type="button" class="export exlexport"  value="Export" name="showdeal"></div><br>
                    <?php
                    }
                     } ?>    
            </div>
        <div class="list-tab mt-list-tab"><ul>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="diripodetails.php?value=<?php echo $SelCompRef;?>/<?php echo $pe_re;?>/<?php echo $dealvalue;?>"><i></i> Detail  View</a></li> 
            </ul>
        </div>  
    <div class="view-detailed">
       
        <div class="detailed-title-links"><h2 style="margin-bottom: -15px;"> <A class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"]."/".$pe_re."/".$dealvalue.'/'.$topNav;?>'><?php echo rtrim($myrow["companyname"]);?></a></h2>
            <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a> </div> 
        
        <div class="profilemain">
             <h2>Deal Info  </h2>
             <div class="profiletable">
                <ul>
                    <?php if($hideamount!="") { ?> <li><h4>IPO Size (US $M)</h4><p><?php echo $hideamount;?></p></li> <?php } ?>
                    <?php if($iposize!="") { ?> <li><h4>IPO Price (Rs.)</h4><p><?php echo $iposize;?></p></li> <?php } ?>
                    <?php if($ipovaluation!="") { ?> <li><h4>IPO Valuation (US $M)</h4><p><?php echo $ipovaluation;?></p></li>   <?php } ?>
                    <?php if($myrow["IPODate"]!="") { ?> <li><h4>Deal Period</h4><p><?php echo  $myrow["IPODate"];?></p></li>  <?php } ?>
                  <!--  <li><h4></h4><p></p></li> -->
                    
                </ul>
            </div>
        </div>
    
    
    
      <div class="postContainer postContent masonry-container"> 
       <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Company Info</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
            <?php
                $companyName=trim($myrow["companyname"]);
                $companyName=strtolower($companyName);
                $compResult=substr_count($companyName,$searchString);
                $compResult1=substr_count($companyName,$searchString1);
                $webdisplay="";
                if(($compResult==0) && ($compResult1==0))
                {
                    $webdisplay=$myrow["website"];
            ?>
                <td><h4>Company</h4>
                    <p><A class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"]."/".$pe_re."/".$dealvalue.'/'.$topNav;?>' ><?php echo rtrim($myrow["companyname"]);?></a></p>
                </td>
            <?php
                }
                else
                {
                    $webdisplay="";
            ?>
                <td><h4>Company</h4><p><?php echo ucfirst("$searchString") ;?></p>
                </td>
            <?php
                }
            ?></tr>
          <?php if($myrow["industry"]!="") { ?> <tr><td><h4>Industry</h4><p><?php echo $myrow["industry"];?></p></td></tr> <?php } ?>
        <?php if($webdisplay!="") { ?> <tr><td><h4>Website</h4><p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></p></td></tr> <?php } ?>
        </tbody>
        </table>
        </div>
        <?php if(nl2br($investmentdeals)!="") { ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investment Details</h2>    
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
            <td><p style="word-break: break-all;"><?php print nl2br($investmentdeals) ;?></p></td>
        </tr>
        </tbody>
        </table> 
        </div>
        <?php } ?>
          <?php if(nl2br($hidemoreinfor)!="") { ?>
       <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>More Details(Overall IPO)</h2>
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <tr>
           <td><p><?php print nl2br($hidemoreinfor) ;?></p></td>
        </tr>
        </tbody>
        </table>
        </div>
           <?php } ?>
          
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>More Info</h2>    
        <table cellpadding="0" cellspacing="0"  class="tableview">
        <tbody> <?php
            if($dec_company_valuation >0)
            {
            ?>
              <tr><td><h4>Company Valuation (INR Cr) </h4><p><?php echo $dec_company_valuation ;?></p></td></tr>
             <?php
            }

            if($dec_sales_multiple >0)
            {
            ?>
              <tr><td ><h4>Sales Multiple </h4><p><?php echo $dec_sales_multiple ;?></p></td></tr>
             <?php
            }

            if($dec_ebitda_multiple >0)
            {
            ?>
              <tr><td ><h4>EBITDA Multiple </h4><p><?php echo $dec_ebitda_multiple ;?></p></td></tr>
             <?php
            }

            if($dec_netprofit_multiple >0)
            {
            ?>
              <tr><td ><h4>Netprofit Multiple </h4><p ><?php echo $dec_netprofit_multiple ;?></p></td></tr>
             <?php
            }

            if(trim($myrow["Valuation"])!="")
            {
              $valdata=$myrow["Valuation"];
            ?>
            <tr><td><b>Valuation (More Info)</b>
                       <p><?php print nl2br($valdata);?></p></tr>
                </td>
            </tr>
        <?php
        }
?>
                 <tr>  <td class="more-info">
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitlemail;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like and we will revert with the data points as available.
                              </p></td></tr>
        </tbody>
        </table>
    </div>
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Investor Info</h2>    
        <table cellpadding="0" cellspacing="0"  class="tableview">
        <tbody>
            <tr>
                <td ><h4>Investors<h4>
                     <p>
                    <?php
                            if ($getcompanyrs = mysql_query($investorSql))
                            {
                                    $AddOtherAtLast="";
                                    $AddUnknowUndisclosedAtLast="";
                                    $bool_returnFlag=0;
                            While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                            {
                                    $Investorname=trim($myInvrow["Investor"]);
                                    $Investorname=strtolower($Investorname);
                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);

                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                    {
                                     if($myInvrow["MultipleReturn"]>0)
                                      {  $bool_returnFlag=1;}
                                      $invReturnString[]=$myInvrow["Investor"].",".$myInvrow["MultipleReturn"];
                                      $invMoreInfoString[]=$myInvrow["InvMoreInfo"];

                    ?>

                            <a class="" target="_blank" href='dirdetails.php?value=<?php echo $myInvrow["InvestorId"]."/".$pe_re."/".$dealvalue.'/'.$topNav;?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
                    <?php
                                    }
                                    elseif(($invResult==1) || ($invResult1==1))
                                            $AddUnknowUndisclosedAtLast=$myInvrow["Investor"];
                                    elseif($invResult2==1)
                                    {
                                            $AddOtherAtLast=$myInvrow["Investor"];
                                    }
                            }
                            }
                    ?>
                    </p>
                </td>
            </tr>
              <?php if($myrow["InvestorTypeName"]!="") { ?><tr><td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td></tr><?php } ?>
              <?php if($exitstatusdisplay!="") { ?><tr><td><h4>Exit Status </h4><p><?php echo $exitstatusdisplay ;?></p></td></tr><?php } ?>
              <?php if($investor_sale_display!="") { ?><tr><td><h4>Investor Sale in IPO?</h4><p><?php echo $investor_sale_display ;?></p></td></tr><?php } ?>
            <?php
             if(($selling_investors_value!="") && ($selling_investors_value!="  "))
             {
             ?>
            <tr><td><h4>Selling Investors</h4><p><?php print nl2br($selling_investors_value);?></p></td></tr>
            <?php
             } ?>
            <?php 
       if(sizeof($linkstring)>0) 
       { 
       ?> 
            <tr><td><h4>Link</h4>
                    <p style="word-break: break-all;">
                         <?php  foreach ($linkstring as $linkstr)
                                { 
                                    if(trim($linkstr)!=="")
                                    {
                                ?>
                          <a href=<?php echo $linkstr; ?> target="_blank"><?php print nl2br($linkstr); ?></a><br/>

                                    <?php } } ?>
                    </p>
                 </td>
            </tr>
       <?php } ?> 
        </tbody>
        </table>
        </div>
        
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
        <h2>Return Info</h2>    
        <table cellpadding="0" cellspacing="0" width="100%" class="tableview">
        <tbody>
        <?php
        if(($estimatedirrvalue!=" ") && ($estimatedirrvalue!=""))
        {
        ?>
            <tr><td ><h4>Estimated Returns </h4><p><?php echo $estimatedirrvalue;?></p></td></tr>
        <?php
        } ?>
        
        <?php
        $invStringArrayCount=count($invReturnString);
        if($bool_returnFlag==1)  //to display the title ifandonlyif atleast one investor has mutliplereturn value >0
         {
        ?>
            <tr ><td><h4>Return Mutliple</h4>
                 <p> 
                    <?php
                      for($i=0;$i<$invStringArrayCount;$i++)
                      {
                      //echo "<br>^^^^^".$invReturnString;
                      $invStringToSplit=$invReturnString[$i];
                       $invString  =explode(",",$invStringToSplit);
                       $investorName=$invString[0];
                       $returnValue=$invString[1];
                       $investormoreinfo=$invMoreInfoString[$i];
                   //echo "<br>****".$invString[1];

                        if($returnValue>0)
                        {
                  ?>
                        <b><?php echo $investorName;?> </b>, <?php echo $returnValue;?>x
                         <br />
                          <?php
                           if( trim($investormoreinfo!="") && ($investormoreinfo!=" "))
                           {
                            echo ($investormoreinfo) ;
                           }
                         ?>

                        

                  <?php echo "<br/>";
                      }
                      }
                  ?>
                 </p>
                 </td>
              </tr>                 
          <?php
                 } 
                 if(trim($moreinfo_returns!="") && ($moreinfo_returns!=" "))
                {
                ?>
                <tr><td ><h4>More Info (Returns)</h4><p><?php print nl2br($moreinfo_returns);?></p></td></tr>
                <?php
                 } ?>

                
                
                
        </tbody>
        </table>
        </div>
      </div>
         </div>
    
    
   </div>             
        <?php }} ?> </td> 
</tr>
</table>   
    </div>
</form>
<form name=ipodealinfo id="ipodealinfo" method="post" action="exportipo.php">
    <input type="hidden" name="txthideIPOId" value="<?php echo $SelCompRef;?>" >
    <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>

<div class=""></div>

</div>

    <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                 function resetinput(fieldname)
                {
                 
               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                 
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
            $('.exlexport').click(function(){ 
             
            $("#ipodealinfo").submit();
            return false;
            });
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
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
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
</script>
<?php
mysql_close();
    mysql_close($cnx);
    ?>
