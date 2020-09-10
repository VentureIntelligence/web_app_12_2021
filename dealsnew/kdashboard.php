<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	 include ('checklogin.php');
                                $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
				$dbTypeSV="SV";
				$dbTypeIF="IF";
				$dbTypeCT="CT";

				$searchString="Undisclosed";
			 	$searchString=strtolower($searchString);

			 	$searchString1="Unknown";
				$searchString1=strtolower($searchString1);
					
				$searchString2="Others";
				$searchString2=strtolower($searchString2);

			 	$buttonClicked=$_POST['hiddenbutton'];
				$fetchRecords=true;
				$totalDisplay="";
				$keyword=$_POST['keywordsearch'];

				$keywordhidden=$_POST['keywordsearch'];
				//echo "<Br>--" .$keywordhidden;
				$keywordhidden =ereg_replace(" ","_",$keywordhidden);

				//echo "<br>--" .$keywordhidden;

				$companysearch=$_POST['companysearch'];
				$companysearchhidden=ereg_replace(" ","_",$companysearch);

				$advisorsearchstring_legal=$_POST['advisorsearch_legal'];
				$advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

                                $advisorsearchstring_trans=$_POST['advisorsearch_trans'];
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
				$month1=($_POST['month1']) ?  $_POST['month1'] : '1';
				$year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
				$month2=($_POST['month2']) ?  $_POST['month2'] : '12';
				$year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

				$notable=false;
			//	echo "<br>FLAG VALIE--" .$vcflagValue;
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
					$samplexls="../Sample_Sheet_Investments.xls";
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
					$samplexls="Sample_Sheet_Investments(VC Deals).xls";
				//	echo "<br>Check for stage** - " .$checkForStage;
				}
				elseif($vcflagValue==2)
				{
					$addVCFlagqry = " and pec.industry =15 ";
					$stage="--";
					$checkForStage = "";
					$checkForStageValue = "";
					$searchTitle = "List of PE Investments - Real Estate";
					$searchAggTitle = "Aggregate Data - PE Investments - Real Estate";
					$aggsql= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					FROM peinvestments AS pe, pecompanies AS pec,industry as i where	";
				}

                                 if($vcflagValue==0)
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
                                    elseif($vcflagValue==1)
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
	$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
		where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
	if($trialrs=mysql_query($TrialSql))
	{
		while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
		{
			$exportToExcel=$trialrow["TrialLogin"];
			$compId=$trialrow["compid"];

		}
	}
	
   if($compId==$companyId){ 
   		$hideIndustry = " and display_in_page=1 "; 
	} else { 
		$hideIndustry=""; 
	}
	
	
	/*$getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
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
	$stagesql = "select StageId,Stage from stage ";*/
	
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
	$topNav = 'Dashboard'; 
	include_once('header_dashboard.php');
?>

<div id="container">
<table cellpadding="0" cellspacing="0" width="100%" class="dashboard-table">
<tr>
 <?php
 //print_r($_POST);
    $type=$_REQUEST['type'];
    if($_POST['year1'] !='')
    {
        $syear=$_POST['year1'];
        $fixstart=$_POST['year1'];
        $startyear=$syear."-01-01";
    }
    else
    {
        if($type==1)
        {
            $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc limit 1";
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$preyear = $myrow["Year"];
			}		
		}
                $fixstart=$preyear;
                $startyear=$preyear."-01-01";
        }
        else
        {
            $fixstart=2009;
            $startyear="2009-01-01";
        }
        
    }
    if($_POST['year2'] !='')
    {

        $eyear=$_POST['year2'];
        $fixend=$_POST['year2'];
        $endyear=$eyear."-01-01";
    }
    else
    {
        $endyear=date("Y-m-d");
        $fixend=date("Y-m-d");
    }
    if($type==1)
    {
         $sqlYear = "SELECT YEAR( pe.dates ) , COUNT( pe.PEId ) , SUM( pe.amount ) 
            FROM peinvestments AS pe, industry AS i, pecompanies AS pec
            WHERE i.industryid = pec.industry
            AND pec.PEcompanyID = pe.PECompanyID
            AND pe.Deleted =0
            AND pe.AggHide =0
            AND pe.SPV =0
            and dates > '".$startyear."' and dates <= '".$endyear."'
            AND pe.PEId NOT 
            IN (

            SELECT PEId
            FROM peinvestments_dbtypes AS db
            WHERE hide_pevc_flag =1
            )
            GROUP BY YEAR( pe.dates )";
        // echo $sqlYear;
        $resultYear= mysql_query($sqlYear);
    }
    elseif ($type==2) 
    {
       $sqlindus = "SELECT i.industry,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and  pe.Deleted = 0 AND pe.AggHide = 0 AND pe.SPV=0
						and dates > '".$startyear."' and dates <= '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY i.industry,YEAR(pe.dates)";
       $resultindus= mysql_query($sqlindus);
    }
    elseif($type==3)
    {
       $sqlstage = "SELECT s.Stage,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 AND pe.SPV=0
						and dates > '".$startyear."' and dates <= '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY s.Stage,YEAR(pe.dates) ";
       $resultstage= mysql_query($sqlstage);
    }
    elseif($type==5)
    {
       $sqlinvestor = "SELECT inv.InvestorTypeName,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s,investortype as inv where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 AND pe.SPV=0
						and pe.InvestorType=inv.InvestorType and dates > '".$startyear."' and dates <= '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY inv.InvestorTypeName,YEAR(pe.dates) ";
     
       $resultinvestor= mysql_query($sqlinvestor);
    }
    elseif($type==6)
    {
       $sqlregion = "SELECT r.Region,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s,investortype as inv, region as r where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pec.region =  r.Region and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 AND pe.SPV=0
						and pe.InvestorType=inv.InvestorType and dates > '".$startyear."' and dates <= '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY r.Region,YEAR(pe.dates)";
       $resultregion= mysql_query($sqlregion);
    }
 ?>

    <td width="100%" class="profile-view-left" colspan="2">

<div class="result-cnt">

 <div class="profile-view-title"> 
 <?php 
 if($type==1)
 {
     $charttitle=" By Year on Year Chart";
 ?>
    <h2>PE - Year on Year</h2>
<?php
 }
 elseif($type==2)
 {
     $charttitle=" By Industry chart";
     ?>
     <h2>PE - By Industry</h2>
 <?php
 }
  elseif($type==3)
 {
      $charttitle=" By Stage Chart";
     ?>
     <h2>PE - By Stage</h2>
 <?php
 }
  elseif($type==4)
 {
      $charttitle=" By Range chart ";
     ?>
     <h2>PE - By Range</h2>
 <?php
 }
  elseif($type==5)
 {
      $charttitle="By Investor Chart";
     ?>
     <h2>PE - By Investor</h2>
 <?php
 } elseif($type==6)
 {
     $charttitle=" By Region Chart";
     ?>
     <h2>PE - By Region</h2>
 <?php
 }
 ?>
 </div>
    <!--div class="profile-view-title"> 
        <A HREF="#Pie"> Overall </a>
        <?php 
        if($type !=1)
        {
        ?>
        <A HREF="#Stack">By Industry</a>
        <?php
        }?>
        <A HREF="#Table">Show Table</a>
    </div-->
<?php
if($type==1 || $type==2 || $type==3 || $type==4 || $type==5 || $type==6)
{
?>
<div class="refine">
    <br> <h4>From <span style="margin-left: 35px;"> To</span></h4>
<SELECT NAME="year1" id="year1">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
                        
                        if($_POST['year1']=='')
                        {
                            if($type == 1)
                            {
                                $year1=$fixstart;
                            }
    else {
        $year1=2009;
    }
                        }
                        
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
                                $isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>

<SELECT NAME="year2" id="year2" >
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
    <input type="submit" name="fliter_stage" value="Go">
    </form>
    <?php 
        if($type !=1)
        {
        ?>
        <div class="title-links"><a href="#Stack">View Chart</a></div>
        <?php
        }?>
      <div class="title-links"><a href="#Table">View Table</a></div>
    </div>
</div>
<?php
}
if($type==2)
{
    while($rowindus = mysql_fetch_array($resultindus))	
    {  
       $deal[$rowindus['industry']][$rowindus[1]]['dealcount']=$rowindus[2];
       $deal[$rowindus['industry']][$rowindus[1]]['sumamount']=$rowindus[3];  
    }  
}
elseif($type==3)
{
     while($rowstage = mysql_fetch_array($resultstage))	
    {  
       $deal[$rowstage['Stage']][$rowstage[1]]['dealcount']=$rowstage[2];
       $deal[$rowstage['Stage']][$rowstage[1]]['sumamount']=$rowstage[3];  
    }
}
else if($type ==4)
{
    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
    for($r=0;$r<count($range);$r++)
    {
        if($r == count($range)-1)
        {
              $sqlrange = "SELECT YEAR( pe.dates ) , COUNT( pe.PEId ) , SUM( pe.amount ) 
                            FROM peinvestments AS pe, industry AS i, pecompanies AS pec
                            WHERE i.industryid = pec.industry
                            AND pec.PEcompanyID = pe.PECompanyID and  (pe.amount > 200)
                            AND pe.Deleted =0
                            AND pe.AggHide =0
                            AND pe.SPV =0
                            and dates > '".$startyear."' and dates <= '".$endyear."'
                            AND pe.PEId NOT 
                            IN (

                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE hide_pevc_flag =1
                            )
                            GROUP BY YEAR( pe.dates )";
           
              $resultrange= mysql_query($sqlrange);
        }
        else
        {
            $limit=(string)$range[$r];
            $elimit=explode("-", $limit);
           $sqlrange = "SELECT YEAR( pe.dates ) , COUNT( pe.PEId ) , SUM( pe.amount ) 
                            FROM peinvestments AS pe, industry AS i, pecompanies AS pec
                            WHERE i.industryid = pec.industry
                            AND pec.PEcompanyID = pe.PECompanyID and  (pe.amount > ".$elimit[0]." and pe.amount<= ".$elimit[1].")
                            AND pe.Deleted =0
                            AND pe.AggHide =0
                            AND pe.SPV =0
                            and dates > '".$startyear."' and dates <= '".$endyear."'
                            AND pe.PEId NOT 
                            IN (

                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE hide_pevc_flag =1
                            )
                            GROUP BY YEAR( pe.dates )";
            
             $resultrange= mysql_query($sqlrange);
        }
        while ($rowrange = mysql_fetch_array($resultrange))
        {
            $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
            $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
        }

    }
}
else if($type==5)
{
     while($rowinvestor = mysql_fetch_array( $resultinvestor))	
    {  
       $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['dealcount']=$rowinvestor[2];
       $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['sumamount']=$rowinvestor[3];  
    }
}
else if($type==6)
{
     while($rowregion = mysql_fetch_array( $resultregion))	
    {  
       $deal[$rowregion['Region']][$rowregion[1]]['dealcount']=$rowregion[2];
       $deal[$rowregion['Region']][$rowregion[1]]['sumamount']=$rowregion[3];  
    }
}
?>  
    </div>
      <?php
      if($type==1)
    { 
     ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'Deals', 'Amount($m)']
            <?php   
            while($rowsyear = mysql_fetch_array($resultYear))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo $rowsyear[2]; ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart=new google.visualization.ColumnChart(document.getElementById('visualization2'));
           function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0&y='+topping;
             window.location.href = 'index.php?'+query_string;
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
                                title: 'Deals',
                            },
                            1: {
                                title: 'Amounts'
                            }
                        },
                    colors: ["#a2753a","#FCCB05"],
                   
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "line",curveType: "function"}
                            }
                }
              );
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
    
      <?php
    }
     else if($type==2)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
        
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?($values[$i]['dealcount']):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"By Industry - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"By Industry - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
    var piechart=new google.visualization.PieChart(document.getElementById('visualization2'));
     function onAreaSliceSelect() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart.getSelection()[0];
          if (selectedItem) {
              
            var industry = data3.getValue(selectedItem.row, 0);
            var topping = data3.getValue(selectedItem.row, 2);
            var topping2 = data3.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
            var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&i='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart, 'select', onAreaSliceSelect);
     piechart.draw(data3, {title:"By Deal",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                             echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],                            
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart1=new google.visualization.PieChart(document.getElementById('visualization3'));
  function onAreaSliceSelected() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart1.getSelection()[0];
          if (selectedItem) {
              
            var industry = data4.getValue(selectedItem.row, 0);
            var topping = data4.getValue(selectedItem.row, 2);
            var topping2 = data4.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
            var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&i='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart1, 'select', onAreaSliceSelected);
      piechart1.draw(data4, {title:"By Amout",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    <? 
     }
   else if($type==3)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       <?php 
       $totaldealsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totaldeals=0;
        foreach($deal as $industry => $values)
        {
            $totaldeals+=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
        }
        $totaldealsarray[$i]=$totaldeals;
       } ?>
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?(($values[$i]['dealcount']/$totaldealsarray[$i])*100):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
     
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
           <?php 
       $totalamtsarray=array();
       for($i=$fixstart;$i<=$fixend;$i++)
       {
        $totalamt=0;
        foreach($deal as $industry => $values)
        {
            $totalamt+=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
        }
        $totalamtsarray[$i]=$totalamt;
       } ?>
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?(($values[$i]['sumamount']/$totalamtsarray[$i])*100):0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
          var selectedItem = chart5.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var stage = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart5, 'select', selectHandler2);
         chart5.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2'],
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart3=new google.visualization.PieChart(document.getElementById('visualization2'));
     function onAreaSliceSelect() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart3.getSelection()[0];
          if (selectedItem) {
              
            var industry = data3.getValue(selectedItem.row, 0);
            var topping = data3.getValue(selectedItem.row, 2);
            var topping2 = data3.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
           var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&s='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart3, 'select', onAreaSliceSelect);
      piechart3.draw(data3, {title:"By Deal",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2'],
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart4=new google.visualization.PieChart(document.getElementById('visualization3'));
  function onAreaSliceSelected() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart4.getSelection()[0];
          if (selectedItem) {
              
            var industry = data4.getValue(selectedItem.row, 0);
            var topping = data4.getValue(selectedItem.row, 2);
            var topping2 = data4.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
            var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&s='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart4, 'select', onAreaSliceSelected);
     piechart4.draw(data4, {title:"By Amout",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      

      }
      google.setOnLoadCallback(drawVisualization);
    </script>                    
    
       
    <? 
     }
    else if($type == 4)
    {
        ?>
   <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart5 = new google.visualization.PieChart(document.getElementById('visualization2'));
           function onAreaSliceSelect() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart5.getSelection()[0];
          if (selectedItem) {
              
            var industry = data3.getValue(selectedItem.row, 0);
            var topping = data3.getValue(selectedItem.row, 2);
            var topping2 = data3.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
           var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&rg='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart5, 'select', onAreaSliceSelect);
      piechart5.draw(data3, {title:"By Deal",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart6 = new google.visualization.PieChart(document.getElementById('visualization3'));
          function onAreaSliceSelected() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart6.getSelection()[0];
          if (selectedItem) {
              
            var industry = data4.getValue(selectedItem.row, 0);
            var topping = data4.getValue(selectedItem.row, 2);
            var topping2 = data4.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
            var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&rg='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart6, 'select', onAreaSliceSelected);
      piechart6.draw(data4, {title:"By Amout",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type==5)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart7 = new google.visualization.PieChart(document.getElementById('visualization2'));
      function onAreaSliceSelect() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart7.getSelection()[0];
          if (selectedItem) {
              
            var industry = data3.getValue(selectedItem.row, 0);
            var topping = data3.getValue(selectedItem.row, 2);
            var topping2 = data3.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
           var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&inv='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart7, 'select', onAreaSliceSelect);
      piechart7.draw(data3, {title:"By Deal",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart8 = new google.visualization.PieChart(document.getElementById('visualization3'));
            function onAreaSliceSelected() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart8.getSelection()[0];
          if (selectedItem) {
              
            var industry = data4.getValue(selectedItem.row, 0);
            var topping = data4.getValue(selectedItem.row, 2);
            var topping2 = data4.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
            var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&inv='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart8, 'select', onAreaSliceSelected);
      piechart8.draw(data4, {title:"By Amout",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>       
    <? 
     }
    else if($type==6)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"By Stage - Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2'],
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart9 = new google.visualization.PieChart(document.getElementById('visualization2'));
          function onAreaSliceSelect() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart9.getSelection()[0];
          if (selectedItem) {
              
            var industry = data3.getValue(selectedItem.row, 0);
            var topping = data3.getValue(selectedItem.row, 2);
            var topping2 = data3.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
           var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&reg='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart9, 'select', onAreaSliceSelect);
      piechart9.draw(data3, {title:"By Deal",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2'],
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var piechart10 = new google.visualization.PieChart(document.getElementById('visualization3'));
    function onAreaSliceSelected() {
         
        // var chartObject = piechart.getChart();
          var selectedItem = piechart10.getSelection()[0];
          if (selectedItem) {
              
            var industry = data4.getValue(selectedItem.row, 0);
            var topping = data4.getValue(selectedItem.row, 2);
            var topping2 = data4.getValue(selectedItem.row, 3);
            //alert('The user selected ' + topping +industry);
            var query_string = 'value=0&sy='+topping+'&ey='+topping2+'&reg='+encodeURIComponent(industry);
             window.location.href = 'index.php?'+query_string;
          }
        }
         google.visualization.events.addListener(piechart10, 'select', onAreaSliceSelected);
      piechart10.draw(data4, {title:"By Amout",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
       
    <? 
     }
    ?>
</td></tr>
<?php
if($type!=1)
{
 ?>

<tr>   
 <td width="50%" class="profile-view-left">
    <A NAME="Pie">     
    <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
<td class="profile-view-rigth" width="50%" >
  <div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>  
</td>
</tr> 
<tr>
<td width="50%" class="profile-view-left" id="chartbar">
    <A NAME="Stack">
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
 <td width="100%" class="profile-view-left">
<div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>

</tr> 
<?php
}//id="slidingTable"
?>

<tr>
    <td class="profile-view-left" colspan="2">
        
    <div NAME="Table" class="table-year-deals"  style="width:100%; overflow:hidden; position:absolute;">
    <div class="showhide-link"><a href="#" class="show_hide" rel="#slidingDataTable">View Table</a></div>
    <div class="view-table" id="slidingDataTable" style="padding:0 20px;display:block; overflow:hidden;">
    <div class="restable" >
            
            <table class="responsive" cellpadding="0" cellspacing="0">
    <thead>
   
    <?php
    if($type==1)
    {
        ?>
    
        <tr><th colspan="1" style="text-align:center">Year</th>
            <th colspan="1" style="text-align:center">No. of Deals</th>
            <th colspan="1" style="text-align:center">Amount($m)</th>
        </tr>
<?php
    }
    elseif($type==2)
    {
    ?>

   
    <tr><th rowspan="2"  style="text-align:center">Industry</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
  <?php   
    }
    elseif($type==3)
    {
        ?>
  <tr><th rowspan="2"  style="text-align:center">Stage</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                 if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==5)
    {
        ?>
   
       <tr><th rowspan="2"  style="text-align:center">Investor</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
           echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php     
    }
    else if($type==4)
    {
        ?>
        <tr><th rowspan="2"  style="text-align:center">Range</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==6)
    {
        ?>
    <tr><th rowspan="2"  style="text-align:center">Region</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
             echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php
    }
    ?></thead>
     <tbody>
      <?php
    if($type == 1)
    {
       mysql_data_seek($resultYear, 0);
        while($rowsyear = mysql_fetch_array($resultYear))	
        {
                echo "<tr style=\"text-align:center;\">
                <td>".$rowsyear[0]."</td>
                <td>".$rowsyear[1]."</td>
                <td>".$rowsyear[2]."</td>
                </tr>";		                                                                           
        }
    }
    else if($type==2)
    {
        $content ='';
   
        foreach($deal as $industry => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$industry.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 
        echo $content;
    }
    else if($type==3)
    {
        $content ='';
   
        foreach($deal as $Stage => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$Stage.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 
        echo $content;
    }
    else if($type == 4)
    {
        $content ='';
   
        foreach($deal as $range => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$range.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;
    }
    else if($type==5)
    {
         $content ='';
   
        foreach($deal as $InvestorTypeName => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$InvestorTypeName.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;   
    }
    else if($type==6)
    {
        $content ='';

        foreach($deal as $range => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$range.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;
    }
    ?>
    </tbody>

        </table>   
</div> 
         <!--div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable">View  Table</a></div-->
    </div>
        </div>
</td>

</tr>
</table>
 
</div>

<div class=""></div>
</form>
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
                    
                  $("#resetfield").val(fieldname);
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

    ?>







