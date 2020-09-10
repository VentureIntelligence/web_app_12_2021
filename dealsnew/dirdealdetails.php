<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();		
	
        $notable=false;
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        if(sizeof($strvalue)>1)
        {   
        $vcflagValue=$strvalue[1];
        $VCFlagValue=$strvalue[1];
        }
        else
        {
        $vcflagValue=0;
        $VCFlagValue=0;
        }
        if($VCFlagValue==0)
        {
          $videalPageName="PEInv";     
        }
        elseif($VCFlagValue==1)
        { $videalPageName="VCInv";
        }
        elseif($VCFlagValue==2)
        { $videalPageName="REInv";
        }
        elseif($VCFlagValue==3)
        { $videalPageName="SVInv";
        }
        elseif($VCFlagValue==4)
        { $videalPageName="CTech";
        }
        elseif($VCFlagValue==5)
        { $videalPageName="IfTech";
        }
	include ('checklogin.php');
        $dealvalue=$strvalue[2];
       // print_r($_POST);
        if($VCFlagValue==0)
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
		elseif($VCFlagValue==1)
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
		elseif($VCFlagValue==2)
		{
			$getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
			FROM REinvestments AS pe, pecompanies AS pec
			WHERE pec.Industry =15 and pe.Deleted=0
			AND pe.PEcompanyID = pec.PECompanyId ";
			$pagetitle="PE Investments - Real Estate -> Search";
			$stagesql_search="";
			 $industrysql_search="select industryid,industry from industry where industryid =15 ";

		}
                elseif($VCFlagValue==3)
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
                  $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
            peinvestments as pe,peinvestments_dbtypes as pedb
            where i.IndustryId !=15 and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
            and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
                }
                elseif($VCFlagValue==4)
                {
                  $dbtype='CT';
                  $showallcompInvFlag=9;
                  $pagetitle="Cleantech Investments -> Search";
                  $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
                  $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
            peinvestments as pe,peinvestments_dbtypes as pedb
            where i.IndustryId !=15 and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
            and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
                }
                elseif($VCFlagValue==5)
                {
                  $dbtype='IF';
                  $showallcompInvFlag=10;
                  $pagetitle="Infrastructure Investments -> Search";
                  $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
                  $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
                                        peinvestments as pe,peinvestments_dbtypes as pedb
                                        where i.IndustryId !=15 and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
                                        and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
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
        $keyword=trim($_POST['keywordsearch']);

        $keywordhidden=trim($_POST['keywordsearch']);
        //echo "<Br>--" .$keywordhidden;
        $keywordhidden =ereg_replace(" ","_",$keywordhidden);

        //echo "<br>--" .$keywordhidden;

        $companysearch=trim($_POST['companysearch']);
        $companysearchhidden=ereg_replace(" ","_",$companysearch);

        $sectorsearch=trim($_POST['sectorsearch']);
        $sectorsearchhidden=ereg_replace(" ","_",$sectorsearch);

        $advisorsearchstring_legal=trim($_POST['advisorsearch_legal']);
        $advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

        $advisorsearchstring_trans=trim($_POST['advisorsearch_trans']);
        $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

        $searchallfield=$_POST['searchallfield'];
        $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);

        //echo "<br>Key word ---" .$keyword;
        //$region=$_POST['region'];
        $industry=$_POST['industry'];
        $stageval=$_POST['stage'];
        if($_POST['stage'])
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
        $companyType=$_POST['comptype'];
        //echo "<BR>---" .$companyType;
        $debt_equity=$_POST['dealtype_debtequity'];
        $investorType=$_POST['invType'];

        $regionId=$_POST['txtregion'];

        //$range=$_POST['invrange'];
        $startRangeValue=$_POST['invrangestart'];
        $endRangeValue=$_POST['invrangeend'];
        $endRangeValueDisplay =$endRangeValue;
        //echo "<br>Stge**" .$range;
        $whereind="";
        $whereregion="";
        $whereinvType="";
        $wherestage="";
        $wheredates="";
        $whererange="";
        $wherelisting_status="";
        $month1=($_POST['month1']) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month")); ;
        $year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
        $month2=($_POST['month2']) ?  $_POST['month2'] : date('n');
        $year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

        /*if (!$_POST){
                $_POST['month1'] = $month1;
                $_POST['year1']  = $year1;
                $_POST['month2'] = $month2;
                $_POST['year2']  = $year2;
        }*/

$notable=false;
// $vcflagValue=$_POST['txtvcFlagValue'];
//echo "<br>FLAG VALIE--" .$vcflagValue;
$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
$splityear1=(substr($year1,2));
$splityear2=(substr($year2,2));

if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
	$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
	$wheredates1= "";
}
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

        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);                        
                               

?>

<?php
	$topNav = 'Directory'; 
	include_once('dirnew_header.php');
?>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 <?php if($dealvalue==101 && $vcflagValue !=2)
{
    ?>
<td class="left-td-bg"> 
    <div class="acc_main">
        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
  <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('pedirrefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
  </div>
    </div>
</td>
<?php 
}
    ?><!-- you can put content here -->
 </td>
 
 <?php
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
		
		//GET PREV NEXT ID
		$prevNextArr = array();
		$prevNextArr = $_SESSION['resultId'];

		/*$currentKey = array_search($SelCompRef,$prevNextArr);
		$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
		$nextKey = $currentKey+1;*/
		
        $flagvalue=$strvalue[1];
        $searchstring=$strvalue[2];
        if($flagvalue==0)
                         $pageTitle="index.php?value=0";
        elseif($flagvalue==1)
                   $pageTitle="index.php?value=1";
        elseif($flagvalue==3)
                   $pageTitle="svindex.php?value=3";
        elseif($flagvalue==4)
                   $pageTitle="svindex.php?value=4";
        elseif($flagvalue==5)
                                   $pageTitle="svindex.php?value=5";

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
					
					//$SelCompRef=$value;
  	$sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
	     amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city,
	     pec.region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
	    pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pe.uploadfilename,pe.source,
            pe.Valuation,pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,pe.SPV
	     FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
	    investortype as its,stage as s
	     WHERE pec.industry = i.industryid
	     AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
	     and pe.PEId=$SelCompRef and s.StageId=pe.StageId
	     and its.InvestorType=pe.InvestorType ";
	//echo "<br>********".$sql;

	$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisorinvestors as advinv,
	advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
		
		if ($companyrs = mysql_query($sql))
		{  ?>
                       
			<? if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
			{
                    $regionid=$myrow["RegionId"];
                   // echo "<Br>***".$regionid;
                    if($regionid>0)
                    { $regionname=return_insert_get_RegionIdName($regionid); }
                    else
                    { $regionname=$myrow["region"]; }
					if($myrow["SPV"]==1)
					{
						$openDebtBracket="[";
						$closeDebtBracket="]";
					}
					else
					{
						$openDebtBracket="";
						$closeDebtBracket="";
					
					}
					if($myrow["AggHide"]==1)
					{
						$openBracket="(";
						$closeBracket=")";
					}
					else
					{
						$openBracket="";
						$closeBracket="";
					}

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

                    if($myrow["listing_status"]=="L")
                        $listing_stauts_display="Listed";
                    elseif($myrow["listing_status"]=="U")
                        $listing_stauts_display="Unlisted";
		//echo "<bR>---".$valuationdata;


	      	$moreinfor=$myrow["MoreInfor"];
	      //$moreinfor=nl2br($moreinfor);
               //echo "<bR>".$moreinfor;
	      	$string = $moreinfor;
			/*** an array of words to highlight ***/
			$words = array($searchstring);
			//$words="warrants convertible";
			/*** highlight the words ***/
			$moreinfor =  highlightWords($string, $words);

			$col6=$myrow["Link"];
			$linkstring=str_replace('"','',$col6);
			$linkstring=explode(";",$linkstring);
			$uploadname=$myrow["uploadfilename"];
			$currentdir=getcwd();
			$target = $currentdir . "../uploadmamafiles/" . $uploadname;

			$file = "../uploadmamafiles/" . $uploadname;
		}
		
		}
	 ?>
<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt">  
        <?php if ($accesserror==1){?>
            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php  exit; } ?>                                                
    <div class="title-links">
                                
        <input class="senddeal" type="button" id="senddeal" value="Send this profile to your colleague" name="senddeal">
        <?php 

        if(($exportToExcel==1))
             {
             ?>
                    <input class="export exlexport" type="button"  value="Export" name="showdeal">

             <?php
             }
         ?>
    </div>
    <div class="list-tab mt-list-tab-directory"><ul>
            <li><a class="postlink"  href="pedirview.php?value=<?php echo $strvalue[1]."/". $strvalue[2]; ?>"  id="icon-grid-view"><i></i> List  View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink" href="dirdetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detailed  View</a></li> 
            </ul></div> 
    <div class="lb" id="popup-box">
        <div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject</h5>
                    <p>Checkout this profile -  <?php echo $myrow["companyname"]; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this profile-  <?php echo $myrow["companyname"]; ?> - in Venture Intelligence"  />
            </div>
            <div class="entry">
                    <h5>Message</h5>
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtn" />
            </div>

        </form>
    </div>    
    <div class="view-detailed">           
    <div class="detailed-title-links"> <h2> <a class="postlink" href='dircomdetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$VCFlagValue.'/'.$dealvalue;?>'> <?php echo $myrow["companyname"]; ?></a></h2></div>                        
  <div class="profilemain">
                <h2>Deals Info  </h2>
                <div class="profiletable">

               <ul>

                 <li><h4>Amount(US$M)</h4><p><?php echo $hideamount;?></p></li>
                 <li><h4>Stage</h4><p><?php echo $myrow["Stage"];?></p></li>
                 <li><h4>Round</h4><p><?php echo $myrow["round"];?></p></li>
                 <li><h4>Date</h4><p><?php echo  $myrow["dt"];?></p></li>
               
                  </ul>

                </div>
                </div>
    
    
    
    
        <div class="postContainer postContent masonry-container">
      <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Investment Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
                    <tbody>
                        <tr><td><h4>Investors</h4><p>
                   <?php
                                
                                        $invcount = 0;
					if ($_SESSION['investId']) 
					unset($_SESSION['investId']); 
					if ($getcompanyrs = mysql_query($investorSql))
					{
						$AddOtherAtLast="";
						$AddUnknowUndisclosedAtLast="";
					While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                        {
	      				//$AddOtherAtLast="";
	      				$Investorname=trim($myInvrow["Investor"]);
	      				$Investorname=strtolower($Investorname);

	      				$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{
                                                    $_SESSION['investId'][$invcount++] = $myInvrow["InvestorId"];
	      		?>                  
					<a class="postlink" href='newdirinv.php?value=<?php echo $myInvrow["InvestorId"].'/'.$VCFlagValue.'/'.$dealvalue;?>' ><?php echo $myInvrow["Investor"]; ?></a><br />
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
					<?php echo $AddUnknowUndisclosedAtLast; ?>

					<?php echo $AddOtherAtLast; ?>
			</td>
<td><h4>Investor Type</h4><p><?php echo $myrow["InvestorTypeName"] ;?></p></td>

<td><h4>Stake %</h4><p><?php echo $hidestake ;?></p></td>
</tr>
<?php
                 if($rscomp= mysql_query($advcompanysql))
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
						<A class="postlink" href='diradvisor.php?value=<?php echo $myadcomprow["CIAId"].'/'.$VCFlagValue.'/'.$dealvalue;?>' >
						<?php echo $myadcomprow["cianame"]; ?></a> (<?php echo $myadcomprow["AdvisorType"];?>)
				<?php
					}
					}
				?>
        </p></td>
				 
                 <?php
                    }

				  if($rsinvcomp= mysql_query($advinvestorssql))
				{
				     $compinv_cnt = mysql_num_rows($rsinvcomp);
				}
				
				if($compinv_cnt>0)
				{
                  ?>
    <td><h4>Advisor Investor</h4><p>
                 <?php
					if ($getinvestorrs = mysql_query($advinvestorssql))
					{
					While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
					{
				?>
					<A class="postlink" href='' >
					<?php 
                                        //advisor.php?value=<?php echo $myadinvrow["CIAId"];   /1/<?php echo $flagvalue 
                                        echo $myadinvrow["cianame"]; ?> </a> (<?php echo $myadinvrow["AdvisorType"];?>)
				<?php
					}
					}
					?>
                   </p></td></tr>
                    <?php
					}
				?>

                  
 <?php
    if($dec_company_valuation >0)
    {
    ?>
    <tr><td><h4>Company Valuation - Equity - Post Money (INR Cr) 
    </h4><p><?php echo $dec_company_valuation ;?></p></td>
     <?php
    }

    if($dec_revenue_multiple >0)
    {
    ?>
    <td><h4>&nbsp;Revenue Multiple (based on Equity Value / Market Cap)
    </h4><p><?php echo $dec_revenue_multiple ;?></p></td>
     <?php
    }

    if($dec_ebitda_multiple >0)
    {
    ?>
    <td ><h4>&nbsp;EBITDA Multiple (based on Equity Value)
    </h4><p><?php echo $dec_ebitda_multiple ;?></p></td></tr>
     <?php
    }

    if($dec_pat_multiple >0)
    {
    ?>
    <tr><td ><h4>PAT Multiple (based on Equity Value)
     </h4><p><?php echo $dec_pat_multiple ;?></p></td>
     <?php
    }
    
    ?>
<?php if(trim($myrow["Valuation"])!="")
{
?>
<td ><h4>&nbsp;Valuation (More Info)
 </h4><p>

<?php
    foreach($valuationdata as $valdata)
    {
        if($valdata!="")
        {
?>
   <?php print nl2br($valdata);?><br/>
<?php
        }
    }
?>
</p></td></tr>
<?php
}
?>
</tbody>
</table>
</div>    
     <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2>Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview">
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
				<td width="120"><h4>Company</h4> <p> <?php echo $openDebtBracket;?><?php echo $openBracket;?><A class="postlink" href='dircomdetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$VCFlagValue.'/'.$dealvalue;?>' >
				<?php echo rtrim($myrow["companyname"]);?></a><?php echo $closeBracket;?><?php echo $closeDebtBracket;?>
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
                        <td><h4>Company Type</h4> <p><?php echo $listing_stauts_display;?></p></td></tr>
                        <tr><td><h4>Industry</h4> <p><?php echo $myrow["industry"];?></p></td>
                        <td><h4>Sector</h4> <p><?php echo $myrow["sector_business"];?></p></td></tr>
                        <tr><td><h4>City</h4> <p><?php echo  $myrow["city"];?></p></td>
                         <td><h4>Region</h4> <p><?php echo $regionname;?></p>	</td></tr>
                        <tr><td colspan="2"><h4>Website</h4> <p><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></td></p>	</td></tr> 
                        <tr><td colspan="2"><h4>Links</h4> <p>
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
                        </p>	</td></tr> 
                     
                    </table>
                    </div>   
          	<div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/tac-3/">
                 <h2>More Info</h2>
                                                               
                  <table class="tablelistview" cellpadding="0" cellspacing="0">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
                                                                 
                                                                 </div>
                </div>	
                
                
</div>

                        
<?php include('dealcompanydetails.php'); ?>

    </div>

  
</td>

 

</tr>
</table>
 
</div>
</form>
<form name=companyDisplay id="companyDisplay" method="post" action="exportdealinfo.php">
     <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
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

          $("#pesearch").submit();
            return false;
        }
        $('.exlexport').click(function(){ 

        $("#companyDisplay").submit();
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
        $('#mailbtn').click(function(){ 
                        
            if(checkEmail())
            {


            $.ajax({
                    url: 'ajaxsendmail.php',
                     type: "POST",
                    data: { to : $("#toaddress").val(), subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
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
 $URL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $URL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL=$URL."&scr=EMAIL";
 return $pageURL;
}

   mysql_close();
    mysql_close($cnx);
    ?>
