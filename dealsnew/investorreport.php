<?php
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
//$videalPageName = "PEInv";
include ('checklogin.php');
$lgDealCompId = $_SESSION['DcompanyId'];
$usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
$usrRgres = mysql_query($usrRgsql) or die(mysql_error());
$usrRgs = mysql_fetch_array($usrRgres);

$orderby = "";
$ordertype = "";
$vcflagValue = $_REQUEST['flag'];
$dealshow=101;
$dealvalue=$dealshow;
if($vcflagValue==0 || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5){
    $view_table = "PEnew_portfolio_cos";
}else{
    $view_table = 'VCnew_portfolio_cos';
}
if (!$_POST) {

    $year1=$year2=date('Y');
    $month1='01';
    $month2='12';
    $dt1 = $year1.'-'.$month1.'-01';
    $dt2 = $year2.'-'.$month2.'-31';
    //echo "<br>all records" .$reportsql;
} else {
    
    $year1=$_POST['year1'];
    $year2=$_POST['year2'];
    $month1=$_POST['month1'];
    $month2=$_POST['month2'];
    $dt1 = $year1.'-'.$month1.'-01';
    $dt2 = $year2.'-'.$month2.'-31';
    if($dt1 > $dt2){        
        $year1=$year2=date('Y');
        $month1='01';
        $month2='12';
    }


}
$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
                $splityear1=(substr($year1,2));
                $splityear2=(substr($year2,2));
                $sdatevalueCheck1 = returnMonthname($month1) ." ".$splityear1;
                $edatevalueCheck2 = returnMonthname($month2) ."  ".$splityear2;
//exit();
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
if($resetfield=="industry")
        { 
            $_POST['industry']="";
            $industry="";
        }
        else 
        {
            $industry=trim($_POST['industry']);
            /*if ($industry != '--' && count($industry) > 0) {
                $searchallfield = '';
            }*/
        }
        if($resetfield=="stage")
            { 
             $_POST['stage']="";
             $stageval="";
            }
            else 
            {
             $stageval=$_POST['stage'];
            }
           
            if($_POST['stage'] && $stageval!="")
            {
                    $boolStage=true;
            }
            else
            {
                    $stage="--";
                    $boolStage=false;
            }
            if($resetfield=="firmtype")
            { 
                $_POST['firmtype']="";
                $firmtypetxt="";
            }
            else 
            {
                $firmtypetxt=$_POST['firmtype'];
            }
    
            $firmtypevalue=implode(",",$firmtypetxt);
            foreach($firmtypetxt as $firmid)
                        {
                                $firmsql= "select FirmType from firmtypes where FirmTypeId=$firmid";
                        //  echo "<br>**".$stagesql;
                                if ($firmtyp = mysql_query($firmsql))
                                {
                                        While($myrow=mysql_fetch_array($firmtyp, MYSQL_BOTH))
                                        {
                                                $firmvaluetext= $firmvaluetext.",".$myrow["FirmType"] ;
                                               // print_r($firmvaluetext);
                                        }
                                }
                        }
                        $firmvaluetext = substr_replace($firmvaluetext, '', 0,1);
    
            if ($boolStage==true)
                            {
                                $stagevalue="";
                                $stageidvalue="";
                                foreach($stageval as $stage)
                                {
                                        //echo "<br>****----" .$stage;
                                        $stagevalue= $stagevalue. " `peinvestments`.StageId=" .$stage." or ";
                                        $stageidvalue=$stageidvalue.",".$stage;
                                }

                                $wherestage = $stagevalue ;
                                $qryDealTypeTitle="Stage  - ";
                                $strlength=strlen($wherestage);
                                $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage =" and (".$wherestage.")";
                             //echo "<br>---" .$stringto;

                            }

            if ($firmtypetxt!= "" && $firmtypetxt != "--")
                $wherefirmtypetxt = " AND `peinvestors`.FirmTypeId IN (".$firmtypevalue.")";
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
if($_POST['industry']!=''){

    $comp_industry_id_where = ' AND `pecompanies`.industry IN ('.$_POST['industry'].') ';
}else{
    $comp_industry_id_where = "";
}
    if($vcflagValue==0){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' AND hide_pevc_flag =1 )  $comp_industry_id_where $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId`";
    }else if($vcflagValue==1){

        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PEcompanyID`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from 
            `peinvestments_investors`,`peinvestments`,`peinvestors` ,`pecompanies`,`industry`,`stage` where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` 
            and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `pecompanies`.`PEcompanyID` = `peinvestments`.`PECompanyID` 
            and `pecompanies`.`industry` = `industry`.`industryid` and `peinvestments`.`StageId` = `stage`.StageId and `peinvestments`.`dates` between '" . $dt1 . "' 
            and '" . $dt2 . "' and `peinvestments`.`amount` <=20 and `stage`.`VCview`=1 and `pecompanies`.`industry` !=15 and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' AND hide_pevc_flag =1 ) $comp_industry_id_where $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId`";
    }else if($vcflagValue==3){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' )  $comp_industry_id_where $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId`";
    }else if($vcflagValue==4){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'CT'  )  $comp_industry_id_where $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId`";
    }else if($vcflagValue==5){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'IF'  ) $comp_industry_id_where $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId`";
    }else if($vcflagValue==2){
        
        $reportsql = "SELECT count(peinv_inv.AngelDealId) as deals, inv.Investor as investor, inv.InvestorId as id, count(peinv.InvesteeId) as cos
FROM angel_investors AS peinv_inv, peinvestors AS inv, angelinvdeals AS peinv, pecompanies AS c
WHERE inv.InvestorId = peinv_inv.InvestorId
AND peinv.AngelDealId = peinv_inv.AngelDealId
AND c.PECompanyId = peinv.InvesteeId
AND peinv.Deleted =0 and inv.InvestorId !=9 and peinv.DealDate between '" . $dt1 . "' and '" . $dt2 . "' $comp_industry_id_where $wherestage $wherefirmtypetxt
Group by inv.InvestorId"; 
}
    $totalreportsql = $reportsql;
$order = " order by deals desc";
$ajaxcompanysql = urlencode($reportsql);

 $reportsql .= $order;
 echo "<div style='display:none'>$reportsql</div>";

$topNav='Directory';
include_once('investor_search.php');
//include_once('dirnew_header.php');
?>

<?php if($vcflagValue==0){
$actionUrl = "investorreport.php"; }
else if($vcflagValue==1){
$actionUrl = "investorreport.php?flag=1";     
}else if($vcflagValue==2){
$actionUrl = "investorreport.php?flag=2";     
}else if($vcflagValue==3){
$actionUrl = "investorreport.php?flag=3";     
}else if($vcflagValue==4){
$actionUrl = "investorreport.php?flag=4";     
}else if($vcflagValue==5){
$actionUrl = "investorreport.php?flag=5";     
}
//echo "<br>all records : " .$reportsql;
?>
<?php 
if(($vcflagValue==3)|| ($vcflagValue==4)|| ($vcflagValue==5)){
    $redirecturl="svindex.php";
}
else if($vcflagValue==2){
    $redirecturl="angelindex.php";
}else
{
    $redirecturl="index.php";
}
?>

<div id="container">
    <table cellpadding="0" cellspacing="0" width="100%" >
        <tr>
        <td class="left-td-bg" id="tdfilter" <?php if($dealvalue==111){echo "style=display:none;";}?>>
    <div class="acc_main" id="acc_main" >
        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active" id="openRefine">Slide Panel</a></div>    
        <div id="panel" style="display:block; overflow:visible; clear:both;">
<?php 

//if($vcflagValue!=2 && $dealvalue!=111){
   
    include_once('dirrefineactiveinvestor.php');
//}elseif($vcflagValue == 2 && $dealvalue!=110 && $dealvalue!=111){

  //  include_once('dirangelrefine.php');
//}
?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/> 
    </div>  
</div>

</td>
            <?php
            $exportToExcel = 0;
            $TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                            where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
//echo "<br>---" .$TrialSql;
            if ($trialrs = mysql_query($TrialSql)) {
                while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
                    $exportToExcel = $trialrow["TrialLogin"];
                    $studentOption = $trialrow["Student"];
                }
            }
            if ($yourquery == 1)
                $queryDisplayTitle = "Query:";
            elseif ($yourquery == 0)
                $queryDisplayTitle = "";
            if (trim($buttonClicked == "")) {
                $totalDisplay = "Total";
                $industryAdded = "";
                $totalAmount = 0.0;
                $totalInv = 0;
                $compDisplayOboldTag = "";
                $compDisplayEboldTag = "";
                //echo $status;
                //  /   echo "<br> query final-----" .$companysql."//".$iftest."/".$TrialSql."/".$studentOption."/".$companysearch;
                /* Select queries return a resultset */

                //echo $reportsql;
                if ($reportall = mysql_query($reportsql)) {
                    $report_cntall = mysql_num_rows($reportall);
                }
                if ($report_cntall > 0) {

                    $rec_limit = 50;

                    $rec_count = $report_cntall;
                    if (isset($_GET{'page'})) {
                        $currentpage = $page;
                        $page = $_GET{'page'} + 1;
                        $offset = $rec_limit * $page;
                    } else {
                        $currentpage = 1;
                        $page = 1;
                        $offset = 0;
                    }

                    if ($_POST)
                        $reportsqlwithlimit = $reportsql . " limit $offset, $rec_limit";
                    else
                        $reportsqlwithlimit = $reportsql . " limit 0, 50";

                    // echo  $reportsqlwithlimit;
                    if ($reportrs = mysql_query($reportsqlwithlimit)) {
                        $report_cnt = mysql_num_rows($reportrs);
                    }
                } else {
                    $searchTitle = $searchTitle . " -- No Deal(s) found for this search ";
                    $notable = true;
                }

                ?>     
                <td class="profile-view-left" style="width:100%;">

                    <div class="result-cnt" style="margin-bottom: 30px;">
                        <?php if ($accesserror == 1) { ?>
                            <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
                            <?php
                            exit;
                        }
                        ?>
                        <div class="result-title"> 
                            <h2>
                                <span class="result-no" id="show-total-deal"> <?php echo $report_cntall; ?> Results found</span>
                                <span class="result-for">for Most Active Investor</span> 
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                  <div class="investorfilter" style="width:33%;margin-top: -3px;">
                                  <div class="inves">
                                  <div class="period-date">
<label>To</label>
<?php
        $month1 = ($_POST['month1']=='') ? '1' : $_POST['month1'];
    ?>  
<SELECT NAME="month1" id="month1">
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month1 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month1 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month1 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month1 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month1 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month1 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month1 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month1 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month1 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month1 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month1 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month1 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year1" id="year1"  id="year1">
    <OPTION id=2 value=""> Year </option>
    <?php 
                    echo    $currentyear = date("Y");
		echo $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
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
                        
                        $i=1998;
                        While($i<= $currentyear )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year1==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i++;
                        }

			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}*/		
		}
	?> 
</SELECT>
</div>
<div class="period-date">

<SELECT NAME="month2" id='month2'>
      <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month2 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month2 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month2 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month2 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month2 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month2 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month2 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month2 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month2 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month2 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month2 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month2 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year2" id="year2" onchange="checkForDate();" id='year2'>
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
                 if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}*/
                    $currentyear = date("Y");
                        $i=1998;
                        While($i<= $currentyear )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year2==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i++;
                        }
		}
	?> 
</SELECT>
</div>
  <div class="search-btn"  > <input name="searchpe" type="submit" value="" class="datesubmit" id="datesubmit"/></div>
  </div>
  <?php if($report_cnt>0){?><div class="title-links " id="exportbtn"></div><?php } ?>
  
                                    <!-- <input class ="export_new" type="button" id="expshowdeals"  value="Export" name="showdeals" style="margin-right:2%"> -->
                                  </div>
                            </h2>
    
                          
                            <ul class="result-select">
                                <?php
                                $cl_count = count($_POST);
                                if($cl_count > 4)
                                {
                                   ?>
                                <li class="result-select-close" style="border:none;"><a href="investorreport.php?value=<?php echo $vcflagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                <?php
                                }
                               if($industry >0 && $industry!=null){ ?>
                                <li title="Industry">
                                    <?php echo $industryvalue; ?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }if($followonVC!="--" && $followonVC!=""){ ?>
                            <li>
                            <?php echo $followonVCFundText ?><a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } if($exited !="--" && $exitedText !=''){ ?>
                            <li>
                            <?php echo $exitedText?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }    
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                    if($round!="--" && $round!=null){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $round; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                    <?php } 
                                if($investorType !="--" && $investorType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($regionId > 0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }   
                                if($txtregion !="--" && $txtregion !=""){ ?>
                            <li>
                            <?php echo $regionText?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($city!=""){ $drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php } 
                                if (trim($sdatevalueCheck1) !=''){ ?>
                                <li> 
                                    <?php echo $sdatevalueCheck1. "-" .$edatevalueCheck2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if($firmvaluetext!="--" && $firmvaluetext!=null) { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo  $firmvaluetext;?><a  onclick="resetinput('firmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                // echo $cityname;
                                // exit();
                                 if($vcflagValue != 6 && $dealvalue != 103 && $dealvalue != 104){ 
                                    if($countryname!="--" && $countryname!=null && ($cityname != '' || $countryNINname != '')) { $drilldownflag=0; ?>
                                        <li> 
                                        <?php $cross_city = str_replace("'", " ", $cityname_list); ?>
                                        <?php 
                                            $cross_country = str_replace("'", " ", $countryname_list); 
                                            if($cross_country == ''){
                                                $cross_country = $countryname;
                                            }
                                        ?>
                                        <?php
                                            if($countrytxt != "NIN"){
                                                if($cityname =="All City"){
                                                    ?>
                                                    <?php echo $cross_country." - ".ucwords(strtolower($cityname));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>        
                                                <?php
                                                    }else{
                                                ?>
                                            <?php echo $cross_country." - ".ucwords(strtolower($cross_city));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                            <?php }
                                            }else{ ?>
                                                <?php if($countryNINname == "All Countries"){
                                                    ?>
                                                <?php echo $cross_country." - ".ucwords(strtolower($countryNINname));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                                <?php }else{ ?>
                                                    <?php echo "Non India - ".$cross_country;?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                                <?php } ?>
                                            <?php } ?>
                                        </li>
                                    <?php } 
                                }

                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!="") { ?>
                                <li> 
                                    <?php echo $companysearch;?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!="") { ?>
                                <li> 
                                    <?php echo $sectorsearch;?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($advisorsearch_trans!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_trans;?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearch_legal!="") { ?>
                                <li> 
                                    <?php echo $advisorsearch_legal;?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                 if($dirsearch!="") { ?>
                                <li> 
                                    <?php echo $dirsearch;?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } if($searchallfield!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo trim($searchallfield)?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                 if ($tagsearch != '') {

                                            $ex_tags_filter = explode(':', $tagsearch);

                                            if (count($ex_tags_filter) > 1) {
                                                $tagsearch = trim($tagsearch);
                                          } else {

                                                $tagsearch = "tag:" . trim($tagsearch);
                                            }
                                            ?>
                                                <li><?php echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                                            <?php
                                }
                               $_POST['resetfield']="";
                                foreach($_POST as $value => $link) 
                                { 
                                    if($link == "" || $link == "--" || $link == " ") 
                                    { 
                                        unset($_POST[$value]); 
                                    } 
                                }
                                //print_r($_POST);
                                
                                ?>
                             </ul>                 
                        </div>
                        <div class="view-detailed" >
                            <div class="detailed-title-links" style="padding-bottom:0px !important;">
                                
                                <a class="postlink" id="previous" href="pedirview.php?value=<?php echo $vcflagValue; ?>">&lt; Back</a>
                                <h2 style="margin-left:0px;">  Most Active Investors</h2>
                               
                            </div>  
                        </div> 
                          <input type="hidden" name="flag" value="<?php echo $vcflagValue; ?>" />
                           
                                    <?php
                                    if ($notable == false) {
                                        ?>	

                                        <div class="list-tab <?php echo ($cls != "") ? $cls : "mt-list-tab-directory"; ?>" style="padding-top:0px !important;margin-top:0px !important;"></div>
                                        <div class="view-table view-table-list" style="padding-top: 0px !important;">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                                                <thead><tr>
                                                        <th class="header <?php echo ($orderby=="investor")?$ordertype:""; ?>" id="investor">Investor </th>
                                                        <th class="header desc <?php echo ($orderby=="deals")?$ordertype:""; ?>" id="deals">No.of Deals</th>
                                                        <th class="header <?php echo ($orderby=="cos")?$ordertype:""; ?>" id="cos">No.of Cos</th>
                                                        <?php if($vcflagValue!=2){?><th class="header <?php echo ($orderby=="newPCos")?$ordertype:""; ?>" id="newPCos">New Portfolio Cos</th> <?php }?>   

                                                    </tr></thead>

                                                <tbody id="movies">
                                                    <?php
                                                    if ($report_cnt > 0) {
                                                        $hidecount = 0;
                                                        //Code to add PREV /NEXT
                                                        mysql_data_seek($reportrs, 0);
                                                        While ($myrow = mysql_fetch_array($reportrs, MYSQL_BOTH)) {
                                                            ?>           
                                                            <?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
                                                                <tr>
                                                                    <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $vcflagValue;?>/<?php echo $dealshow;?> " ><?php echo $myrow["investor"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a></td>
                                                                    <?php if($vcflagValue!=2){?><td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["newPCos"]; ?></a></td><?php }?>  
                                                                </tr>
                                                            <?php } else { ?>
                                                                <tr>
                                                                    <td ><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $vcflagValue;?>/<?php echo $dealshow;?> " ><?php echo $myrow["investor"]; ?></a></td>
                                                                   <!--  <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a></td>
                                                                    <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>&newCos=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["newPCos"]; ?></a></td> -->
                                                                    <td style="padding-left:5%">
                                                                        
                                                                        <a class="postlink" href="<?php echo $redirecturl;?>?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a>
                                                                        
                                                                    </td>
                                                                    <td style="padding-left:5%">
                                                                        
                                                                        <a class="postlink" href="<?php echo $redirecturl;?>?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a>
                                                                       
                                                                    </td>
                                                                  <?php if($vcflagValue!=2){?>  
                                                                    <td style="padding-left:5%">
                                                                        
                                                                        <a class="postlink" href="<?php echo $redirecturl;?>?value=<?php echo $vcflagValue; ?>&newCos=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["newPCos"]; ?></a>
                                                                       
                                                                    </td>
                                                                <?php }?>
                                                                </tr>
                                                            <?php } ?>
                                                            <?php
                                                        }
                                                    }
                                                    else{ ?>
                                                        
                                                        <tr><td >No Result Found</td></tr>
                                                    <?php }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>			
                                       

                                    <div class="holder" style="float:none; text-align: center;">
                                        <div class="paginate-wrapper" style="display: inline-block;">
                                        <?php
                                        $totalpages = ceil(mysql_num_rows(mysql_query($totalreportsql)) / $rec_limit);
                                        $firstpage = 1;
                                        $lastpage = $totalpages;
                                        $prevpage = (( $currentpage - 1) > 0) ? ($currentpage - 1) : 1;
                                        $nextpage = (($currentpage + 1) < $totalpages) ? ($currentpage + 1) : $totalpages;
                                        ?>

                                        <?php
                                        $pages = array();
                                        $pages[] = 1;
                                        $pages[] = $currentpage - 2;
                                        $pages[] = $currentpage - 1;
                                        $pages[] = $currentpage;
                                        $pages[] = $currentpage + 1;
                                        $pages[] = $currentpage + 2;
                                        $pages[] = $totalpages;
                                        $pages = array_unique($pages);
                                        sort($pages);
                                        if ($currentpage < 2) {
                                            ?>
                                            <a class="jp-previous jp-disabled" >&#8592;  Previous</a>
                                        <?php } else { ?>
                                            <a class="jp-previous" >&#8592;  Previous</a>
                                            <?php
                                        } for ($i = 0; $i < count($pages); $i++) {
                                            if ($pages[$i] > 0 && $pages[$i] <= $totalpages) {
                                                ?>
                                                <a class='<?php echo ($pages[$i] == $currentpage) ? "jp-current" : "jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                                                <?php
                                            }
                                        }
                                        if ($currentpage < $totalpages) {
                                            ?>
                                            <a class="jp-next">Next &#8594;</a>
                                        <?php } else { ?>
                                            <a class="jp-next jp-disabled">Next &#8594;</a>
                                        <?php } ?>
                                        </div>
                                    </div>
 <?php
                                    }
                                    else{ 
                                                        
                                        echo "No Result Found";
                                     }
                                    ?>
                                    </div>
                                    <?php
                                } 
                                ?>
                                </div>

                                </td>

                                </tr>
                                </table>

                                </div>
                                
                                <div class=""></div>
                                <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
                                <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
                                <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
                                

            </form>
            <form name="invreport" id="invreport"  method="post" action="exportinvreport.php">
                <input type="hidden" name="showprofile" id="showprofile" value="" >
                <input type="hidden" name="date_year1" value="<?php echo $year1; ?>" >
                <input type="hidden" name="date_year2" value="<?php echo $year2; ?>" >
                <input type="hidden" name="date_month1" value="<?php echo $month1; ?>" >
                <input type="hidden" name="date_month2" value="<?php echo $month2; ?>" >
                <input type="hidden" name="flaghidden" value="<?php echo $vcflagValue; ?>" >
                <input type="hidden" name="dealhidden" value="<?php echo $vcflagValue; ?>" >

            </form>
    <script src="<?php echo $refUrl; ?>js/listviewfunctions.js"></script>
    <script type="text/javascript">
                                    var orderby = '<?php echo $orderby; ?>';
                                    var ordertype = '<?php echo $ordertype; ?>';
                                    $(".jp-next").live("click", function() {
                                        if (!$(this).hasClass('jp-disabled')) {
                                            pageno = $("#next").val();
                                            loadhtml(pageno, orderby, ordertype);
                                        }
                                        return  false;
                                    });
                                    $(".jp-page").live("click", function() {
                                        pageno = $(this).text();
                                        loadhtml(pageno, orderby, ordertype);
                                        return  false;
                                    });
                                    $(".jp-previous").live("click", function() {
                                        if (!$(this).hasClass('jp-disabled')) {
                                            pageno = $("#prev").val();
                                            loadhtml(pageno, orderby, ordertype);
                                        }
                                        return  false;
                                    });
                                    $(".header").live("click", function() {
                                        var orderby = $(this).attr('id');

                                        if ($(this).hasClass("desc")){
                                            ordertype = "asc";
                                        }else{
                                            if(!$(this).hasClass("desc") && !$(this).hasClass("asc") && orderby== 'investor'){
                                                ordertype = "asc";
                                            }else{
                                                ordertype = "desc";
                                            }
                                        }
                                        loadhtml(1, orderby, ordertype);
                                        return  false;
                                    });
                                    function loadhtml(pageno, orderby, ordertype)
                                    {
                                        jQuery('#preloading').fadeIn(1000);
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxInvestorreport.php',
                                            data: {
                                                sql: '<?php echo addslashes($ajaxcompanysql); ?>',
                                                totalrecords: '<?php echo addslashes($report_cntall); ?>',
                                                page: pageno,
                                                vcflagvalue: '<?php echo $vcflagValue; ?>',
                                                orderby: orderby,
                                                ordertype: ordertype,
                                                usrRgsPEInv: '<?php echo $usrRgs['PEInv']; ?>',
                                                usrRgsVCInv: '<?php echo $usrRgs['VCInv']; ?>',
                                                dateYear: '<?php echo $year; ?>'
                                            },
                                            success: function(data) {

                                                $(".view-table-list").html(data);
                                                $(".jp-current").text(pageno);
                                                var prev = parseInt(pageno) - 1
                                                if (prev > 0)
                                                    $("#prev").val(pageno - 1);
                                                else
                                                {
                                                    $("#prev").val(1);
                                                    //                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                                                }
                                                $("#current").val(pageno);
                                                var next = parseInt(pageno) + 1;
                                                if (next < <?php echo $totalpages ?>)
                                                    $("#next").val(next);
                                                else
                                                {
                                                    $("#next").val(<?php echo $totalpages ?>);
                                                    //                        $(".jp-next").addClass('.jp-disabled').removeClass('.jp-next');
                                                }
                                                drawNav(<?php echo $totalpages ?>, parseInt(pageno))
                                                jQuery('#preloading').fadeOut(500);

                                                return  false;


                                            },
                                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                                jQuery('#preloading').fadeOut(500);
                                                alert('There was an error');
                                            }
                                        });
                                    }
                                    $("a.postlink").live('click', function() {
                                        investorid = $(this).attr("data-investorid");
                                        $('<input>').attr({
                                            type: 'hidden',
                                            id: 'foo',
                                            name: 'investorauto_sug',
                                            value: investorid
                                        }).appendTo('#pesearch');

                                        $('<input>').attr({
                                            type: 'hidden',
                                            id: 'foo',
                                            name: 'month1',
                                            value: <?php echo $month1;?>
                                        }).appendTo('#pesearch');
                                        $('<input>').attr({
                                            type: 'hidden',
                                            id: 'foo',
                                            name: 'month2',
                                            value: <?php echo $month2;?>
                                        }).appendTo('#pesearch');
                                        $('<input>').attr({
                                            type: 'hidden',
                                            id: 'foo',
                                            name: 'year1',
                                            value: <?php echo $year1;?>
                                        }).appendTo('#pesearch');
                                        $('<input>').attr({
                                            type: 'hidden',
                                            id: 'foo',
                                            name: 'year2',
                                            value: <?php echo $year2;?>
                                        }).appendTo('#pesearch');

                                        hrefval = $(this).attr("href");
                                        $("#pesearch").attr("action", hrefval);
                                        $("#pesearch").submit();
                                        return false;

                                    });

                                    /*$("a.postlink").live('click', function() {

                                        $('<input>').attr({
                                            type: 'hidden',
                                            id: 'foo',
                                            name: 'searchallfield',
                                            value: '<?php echo $searchallfield; ?>'
                                        }).appendTo('#pesearch');
                                        hrefval = $(this).attr("href");
                                        $("#pesearch").attr("action", hrefval);
                                        $("#pesearch").submit();
                                        return false;

                                    });*/
                                    function resetinput(fieldname)
                                    {
                                        $("#resetfield").val(fieldname);
                                        //alert( $("#resetfield").val());
                                        $("#pesearch").submit();
                                        return false;
                                    }
</script>
<script type="text/javascript">

      $(document).on('click','.profile-invs',function(){
            jQuery('#maskscreen').fadeIn();
            jQuery('#popup-box-copyrights').fadeIn();   
            return false;
        });
        $(document).on('click','.exportdealsinvest',function(){ 
                    $("#showprofile").val($(this).attr("data-invs"));
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });

        function initExporttable(){ 
            $.ajax({
                url: 'ajxCheckDownload.php',
                dataType: 'json',
                success: function(data){
                    var downloaded = data['recDownloaded'];
                    var exportLimit = data.exportLimit;
                    var currentRec = <?php echo $report_cnt; ?>;

                    //alert(currentRec + downloaded);
                    var remLimit = exportLimit-downloaded;

                    if (currentRec < remLimit){
                        hrefval= 'exportinvreport.php';
                        $("#invreport").attr("action", hrefval);
                        $("#invreport").submit();
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
function checkForDate()
{
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
                    
        if(year1 > year2)
        {
                alert("Error: 'To' date cannot be before 'From' date");
                return false;
        }
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
                return false;
            } 
            else
                {
                    $("#investorreport").submit();
                }
        }
        else
        {
                $("#investorreport").submit();
        }
	
}
</script>
</div>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtntable" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtntable" />
    </div>

</div>
</body>
</html>

<?php

mysql_close();
?>
<script type="text/javascript" >
    var Directorydemotour=0;
<?php if ($_POST || $vcflagValue == 6) {
    ?>
    $("#panel").animate({width: 'toggle'}, 200);
    $(".btn-slide").toggleClass("active");
    $(document).ready(function(){
    if ($('.left-td-bg').css("min-width") == '264px') {
        $('.left-td-bg').css("min-width", '36px');
        $('.acc_main').css("width", '35px');
        
    }
    else {
        $('.left-td-bg').css("min-width", '264px');
        $('.acc_main').css("width", '264px');
    }
});
    
<?php } ?>
    
    $(document).on('click','#agreebtntable',function(){
         $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExporttable();
        return false; 
     });
    
     $(document).on('click','#expcancelbtntable',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });

</script>
<script type="text/javascript">
    $('#exportbtn').html('<a class ="export" onClick="open_ex(this)" data-check="close"  style="background: #a37635 url(../cfsnew/images/arrow-dropdown.png) no-repeat 90px 8px;width: 80px;">Export</a><div style="display:none;" class="exportinvest"><div class="with-invs exportdealsinvest" data-invs="0">Profile only</div><div class="without-invs exportdealsinvest" data-invs="1">Profile with inv.</div><div class="profile-invs exportdealsinvest" data-invs="2">Table only</div></div>');
    function open_ex(element){
                    if ($(element).attr("data-check") == 'close') {
                        $(".exportinvest").show();
                        $(element).attr("data-check", "open");
                    }else if($(element).attr("data-check") == 'open'){
                        $(".exportinvest").hide();
                        $(element).attr("data-check", "close");
                    }else{
                        $(".exportinvest").hide();
                        $(element).attr("data-check", "close");
                    }
                }
              
</script>
<?php
mysql_close();
    mysql_close($cnx);
    ?>
