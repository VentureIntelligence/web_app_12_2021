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
if($vcflagValue==0){
    $view_table = "PEnew_portfolio_cos";
}else{
    $view_table = 'VCnew_portfolio_cos';
}

if (!$_POST) {

    $year1=$year2=date('Y');
    $month1=$month2=date('m') - 1;
    // $month1='01';
    // $month2='12';
    $dt1 = $year1.'-'.$month1.'-01';
    $dt2 = $year2.'-'.$month2.'-31';

    // if($vcflagValue==0){
        
    //     $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
    //     where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
    //     and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 group by `peinvestments_investors`.`InvestorId`";
    // }
    // else{

    //     $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PEcompanyID`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from 
    //         `peinvestments_investors`,`peinvestments`,`peinvestors` ,`pecompanies`,`industry`,`stage` where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` 
    //         and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `pecompanies`.`PEcompanyID` = `peinvestments`.`PECompanyID` 
    //         and `pecompanies`.`industry` = `industry`.`industryid` and `peinvestments`.`StageId` = `stage`.StageId and `peinvestments`.`dates` between '" . $dt1 . "' 
    //         and '" . $dt2 . "' and `peinvestments`.`amount` <=20 and `stage`.`VCview`=1 and `pecompanies`.`industry` !=15 and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 group by `peinvestments_investors`.`InvestorId`";
  
    // }
    // $totalreportsql = $reportsql;
    //echo "<br>all records" .$reportsql;

    $defaultyear=1998;
    $defaultmonth=01;
    $prevyear = $year2 - 1;
    $defaultday= $defaultyear.'-'.$defaultmonth.'-01';
    $endDate= date('Y-m', strtotime($dt1." -1 month")).'-31';
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
    $defaultyear=1998;
    $defaultmonth=01;
    $prevyear = $year2 - 1;
    $defaultday= $defaultyear.'-'.$defaultmonth.'-01';
    $endDate= date('Y-m', strtotime($dt1." -1 month")).'-31';
}

if($vcflagValue==0){
        
    $reportsql = "SELECT count(peinv_inv.PEId) as deals,inv.Investor as investor,inv.InvestorId as id, count(DISTINCT pec.PECompanyId) as cos,pe.dates
    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
    and pe.dates between '" . $dt1 . "' and '" . $dt2 . "' and peinv_inv.InvestorId !=9 and pe.Deleted = 0 and pec.industry !=15
    and peinv_inv.InvestorId NOT IN (SELECT peinv_inv.InvestorId from peinvestments_investors AS peinv_inv, peinvestments as pe  
           where pe.PEId = peinv_inv.PEId and pe.dates between  '" . $defaultday . "'  and  '" . $endDate . "' )
    group by peinv_inv.InvestorId";

}else{

    $reportsql = "SELECT count(peinv_inv.PEId) as deals,inv.Investor as investor,inv.InvestorId as id, count(DISTINCT pec.PECompanyId) as cos,pe.dates
    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
    JOIN industry AS i ON pec.industry = i.industryid
    JOIN stage AS s ON pe.StageId = s.StageId
    and pe.dates between '" . $dt1 . "' and '" . $dt2 . "' and peinv_inv.InvestorId !=9 and pe.Deleted = 0 and s.VCview=1 and pe.amount <=20  and pec.industry !=15  
    and peinv_inv.InvestorId NOT IN (SELECT peinv_inv.InvestorId from peinvestments_investors AS peinv_inv, peinvestments as pe  
           where pe.PEId = peinv_inv.PEId and pe.dates between  '" . $defaultday . "'  and  '" . $endDate . "' )
    group by peinv_inv.InvestorId ";

}
//echo date('Y-m', strtotime($dt1." -1 month"));

$totalreportsql = $reportsql;
$orderby = "investor";
$ordertype = "asc";
$order = " order by investor asc";
$ajaxcompanysql = urlencode($reportsql);


 $reportsql .= $order;

$topNav='Directory';
include_once('investor_search.php');
//include_once('dirnew_header.php');
?>
</form>
<?php if($vcflagValue==0){
$actionUrl = "newinvestorreport.php"; }
else{
$actionUrl = "newinvestorreport.php?flag=1";     
}
?>

<style type="text/css">
    .pagetitle{
        text-align: center;
        font-size: 24px;
        margin-bottom: -20px;
        margin-top: 5px;
    }
</style>
<form name="newinvestorreport" action="<?php echo $actionUrl; ?>" method="post" id="newinvestorreport">
<div id="container">
    <table cellpadding="0" cellspacing="0" width="100%" >
        <tr>
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
                    <div style="display: none"><?php echo $reportsqlwithlimit; ?></div>

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
                                <span class="result-for">for New Investor</span> 
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php echo $investor_cnt; ?>">
                                <div class="investorfilter">
                                 <div class="period-date">
<label>To</label>
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
  <?php if($report_cnt > 0){?><div class="title-links " id="exportbtn"></div><?php } ?>
  </div> 
                                  <!--<input class ="export_new" type="button" id="expshowdeals"  value="Export" name="showdeals" style="float:right; margin-right:2%">-->
                            </h2>
    
                          
                                           
                        </div>
                        <div class="view-detailed" >
                            <div class="detailed-title-links" style="padding-bottom:0px !important;">
                                <div class="pagetitle">NEW INVESTORS</div>
                                <a class="postlink" id="previous" href="pedirview.php?value=<?php echo $vcflagValue; ?>">&lt; Back</a>
                                <!-- <h2 style="margin-left:0px;"> New Investors</h2> -->
                                <div style="float:right; margin-top: -6px;" >
  
  
                              <!-- <label><b>Year</b></label>
                                    <SELECT NAME="month1" id='month1'>
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
                                    <SELECT NAME="year" id="year"  id="year" sytle="float:left;">

                                        <?php 
                                            $yearsql1="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                                            if($yearSql=mysql_query($yearsql1))
                                            {
                                                   /* if($type == 1)  
                                                    {
                                                        if($_POST['year']=='')
                                                        {
                                                            $year;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        if($_POST['year']=='')
                                                        {
                                                            $year;
                                                        }
                                                    }*/

                                                    $currentyear = 1998;
                                                    $i=date("Y");
                                                    While($i>= $currentyear )
                                                    {
                                                        $id = $i;
                                                        $name = $i;
                                                        $isselected = ($year==$i) ? 'SELECTED' : '';
                                                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                                                        $i--;
                                                    }
                                            } ?> 
                                    </SELECT>-->
                             </div>
                          <!--      <a  class="postlink" id="previous" href="javascript:history.back(-1)">< Back</a>-->

                            </div>  
                        </div> 
                          <input type="hidden" name="flag" value="<?php echo $vcflagValue; ?>" />
                          <input type="hidden" name="orderby" class="orderby" value="<?php echo $orderby; ?>" />
                          <input type="hidden" name="ordertype" class="ordertype" value="<?php echo $ordertype; ?>" />

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
                                                        <!-- <th class="header <?php //echo ($orderby=="newPCos")?$ordertype:""; ?>" id="newPCos">New Portfolio Cos</th>   -->

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
                                                                        <td><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $vcflagValue;?>/<?php echo $dealshow;?> " ><?php echo $myrow["investor"]; ?></a></td>
                                                                        <td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a></td>
                                                                        <td style="padding-left:5%"><a data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a></td>
                                                                    </tr>  
                                                                <?php } else { ?>
                                                                    <tr>
                                                                    
                                                                        <td><a class="postlink" href="dirdetails.php?value=<?php echo $myrow["id"];?>/<?php echo $vcflagValue;?>/<?php echo $dealshow;?> " ><?php echo $myrow["investor"]; ?></a></td>
                                                                        <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["deals"]; ?></a></td>
                                                                        <td style="padding-left:5%"><a class="postlink" href="index.php?value=<?php echo $vcflagValue; ?>" data-investorid="<?php echo $myrow["id"]; ?>"><?php echo $myrow["cos"]; ?></a></td>
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
               
                <input type="hidden" name="date_year1" value="<?php echo $year1; ?>" >
                <input type="hidden" name="date_year2" value="<?php echo $year2; ?>" >
                <input type="hidden" name="date_month1" value="<?php echo $month1; ?>" >
                <input type="hidden" name="date_month2" value="<?php echo $month2; ?>" >
                <input type="hidden" name="flaghidden" value="<?php echo $vcflagValue; ?>" >
                <input type="hidden" name="dealhidden" value="<?php echo $vcflagValue; ?>" >
            </form>
    <script src="<?php echo $refUrl; ?>js/listviewfunctions.js"></script>
    <script type="text/javascript">
                                    var orderby = $('.orderby').val();
                                    var ordertype = $('.ordertype').val();
                                    var pageno;
                                    $(".jp-next").live("click", function() {
                                        var orderby = $('.orderby').val();
                                        var ordertype = $('.ordertype').val();
                                        if (!$(this).hasClass('jp-disabled')) {
                                            pageno = $("#next").val();
                                            loadhtml(pageno, orderby, ordertype);
                                        }
                                        return  false;
                                    });
                                    $(".jp-page").live("click", function() {
                                        var orderby = $('.orderby').val();
                                        var ordertype = $('.ordertype').val();
                                        pageno = $(this).text();
                                        loadhtml(pageno, orderby, ordertype);
                                        return  false;
                                    });
                                    $(".jp-previous").live("click", function() {
                                        var orderby = $('.orderby').val();
                                        var ordertype = $('.ordertype').val();
                                        if (!$(this).hasClass('jp-disabled')) {
                                            pageno = $("#prev").val();
                                            loadhtml(pageno, orderby, ordertype);
                                        }
                                        return  false;
                                    });
                                    $(".header").live("click", function() {
                                        $(".header").removeClass('current');
                                        $(this).addClass('current');
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
                                        $('.orderby').val(orderby);
                                        $('.ordertype').val(ordertype);
                                        loadhtml(1, orderby, ordertype);
                                        return  false;
                                    });
                                    function loadhtml(pageno, orderby, ordertype)
                                    {
                                        jQuery('#preloading').fadeIn(1000);
                                        $.ajax({
                                            type: 'POST',
                                            url: 'ajaxNewInvestorreport.php',
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
                                    function resetinput(fieldname)
                                    {
                                        $("#resetfield").val(fieldname);
                                        //alert( $("#resetfield").val());
                                        $("#pesearch").submit();
                                        return false;
                                    }
</script>
<script type="text/javascript">

      $('#expshowdeals').click(function(){
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
                    var currentRec = <?php echo $report_cnt; ?>;

                    //alert(currentRec + downloaded);
                    var remLimit = exportLimit-downloaded;

                    if (currentRec < remLimit){
                        hrefval= 'exportnewinvreport.php';
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
                    $("#newinvestorreport").submit();
                }
        }
        else
        {
                $("#newinvestorreport").submit();
        }
    
}
</script>
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

mysql_close();
?>
<script type="text/javascript" >
    var Directorydemotour=0;
<?php if ($_POST || $vcflagValue == 6) {
    ?>
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
