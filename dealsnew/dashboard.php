<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	$videalPageName = 'DASHBOARD';
	 include ('checklogin.php');
	
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
        
	$topNav = 'Dashboard'; 
	include_once('header_dashboard.php');
?>


<div id="container">

<table cellpadding="0" cellspacing="0" width="100%" class="dashboard-table">
<tr>
 <?php
 //print_r($_POST);
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
    if($_POST['year1'] !='' && $_POST['month1'] !='')
    {
        $syear=$_POST['year1'];
        $smonth=$_POST['month1'];
        $fixstart=$_POST['year1'];
        $startyear=$syear."-".$smonth."-01";
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
                $month1= 1;
                $startyear=$preyear."-01-01";
        }
        else
        {
            $fixstart=2009;
            $month1=1;
            $startyear="2009-01-01";
        }
        
    }
    if($_POST['year2'] !='' && $_POST['month2'] !='')
    {

        $eyear=$_POST['year2'];
        $emonth=$_POST['month2'];
        $fixend=$_POST['year2'];
        $endyear = $eyear."-".$emonth."-31";
    }
    else
    {
        //echo $month2= date('n',12);
        $endyear=date("Y-m-d");
        $month2= date('n');
        $year2=date('Y');
        $fixend=date("Y");
    }
     $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm	where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        if($trialrs=mysql_query($TrialSql))
        {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                                $compId=$trialrow["compid"];
                        }
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
			and pe.amount != 0
            and dates between '".$startyear."' and '".$endyear."'
            AND pe.PEId NOT 
            IN (

            SELECT PEId
            FROM peinvestments_dbtypes AS db
            WHERE hide_pevc_flag =1
            )
            GROUP BY YEAR( pe.dates )";
         //echo $sqlYear;
        $resultYear= mysql_query($sqlYear);
        $totalRec = mysql_num_rows($resultYear);
    }
    elseif ($type==2) 
    {
       $sqlindus = "SELECT i.industry,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and  pe.Deleted = 0 AND pe.AggHide = 0 and pe.amount != 0 AND pe.SPV=0
						and dates between '".$startyear."' and '".$endyear."'
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
						pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 and pe.amount != 0 AND pe.SPV=0
						and dates between '".$startyear."' and '".$endyear."'
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
						pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 and pe.amount != 0 AND pe.SPV=0
						and pe.InvestorType=inv.InvestorType and dates between '".$startyear."' and '".$endyear."'
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
						pec.PEcompanyID = pe.PECompanyID and pec.RegionId=r.RegionId and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 and pe.amount != 0 AND pe.SPV=0
						and pe.InvestorType=inv.InvestorType and dates between '".$startyear."' and '".$endyear."'
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
     <span class="title-links " id="exportbtn"></span>
 </div>
<?php
if($type==1 || $type==2 || $type==3 || $type==4 || $type==5 || $type==6)
{
?>
<div class="refine">
<?php
        $month1 = ($_POST['month1']=='') ? '1' : $_POST['month1'];
    ?> 
    <br> <h4>From <span style="margin-left: 125px;"> To</span></h4>
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
<SELECT NAME="year1" id="year1">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
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
                        }else{
                          $year1=$_POST['year1'];
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
    <?php
        $month2 = ($_POST['month2']=='') ? '12' : $_POST['month2'];
    ?>
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
<SELECT NAME="year2" id="year2" >
    <OPTION id=2 value="--"> Year </option>
    <?php 
               
                if ($_POST['year2']==''){
                    $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc LIMIT 0,1";
                    $resYrSql = mysql_query($yearsql);
                    $yrValue = mysql_fetch_row($resYrSql);
                    $year2 = $yrValue[0];
                  }else{
                    $year2=$_POST['year2'];
                  }
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
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
    <input type="submit" name="fliter_stage" value="Go" class="datesubmit">
      <div class="title-links"><a href="#Table" >View Table</a></div>
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
							and pe.amount != 0
                            AND pe.SPV =0
                            and dates between '".$startyear."' and '".$endyear."'
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
							and pe.amount != 0
                            AND pe.SPV =0
                            and dates between '".$startyear."' and '".$endyear."'
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
            ['Year', 'No of Deals', 'Amount($m)']
            <?php   
            while($rowsyear = mysql_fetch_array($resultYear))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo round($rowsyear[2]); ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart=new google.visualization.LineChart(document.getElementById('visualization2'));
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
                    width:divwidth, height:400,is3D:true,
                    smoothLine: true, 
                    hAxis: {title: "Year"},
                    vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                   
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars"}
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
                       }?>]
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php 
                             
                             if(count($deal)>0){
                             foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?($values[$i]['dealcount']):0;
                            }
                             }
                            
                            ?>]
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
                title:"No of Deals",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
//                colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
//"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],
                isStacked : true,
                is3D: true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>]
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
                title:"Amount",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
//                colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
//"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2']
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  ,[ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
     piechart.draw(data3, {title:"No of Deals",sliceVisibilityThreshold:0 /*slices: { 
                    0: {offset: 0.2},
                    1: {offset: 0.2},
                    2: {offset: 0.2},
                    3: {offset: 0.2},
                    4: {offset: 0.2},
                    5: {offset: 0.2},
                    6: {offset: 0.2},
                    7: {offset: 0.2},
                    8: {offset: 0.2},
                    9: {offset: 0.2},
                    10: {offset: 0.2},
                    11: {offset: 0.2},
                    12: {offset: 0.2},
                    13: {offset: 0.2},
                    14: {offset: 0.2},
                    15: {offset: 0.2},
                    16: {offset: 0.2},
                    17: {offset: 0.2},
                    18: {offset: 0.2},
                    19: {offset: 0.2},
                    20: {offset: 0.2},
                    21: {offset: 0.2},
                    22: {offset: 0.2},
                    23: {offset: 0.2},
        backgroundColor: {stroke:'black', strokeSize: 5},
        borderColor:{stroke:'black', fill:'#eee', strokeSize: 1},*/
        
       /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2']
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  ,[ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                             echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]                            
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
        piechart1.draw(data4, {title:"Amount",sliceVisibilityThreshold:0/* slices: { 
                    0: {offset: 0.2},
                    1: {offset: 0.2},
                    2: {offset: 0.2},
                    3: {offset: 0.2},
                    4: {offset: 0.2},
                    5: {offset: 0.2},
                    6: {offset: 0.2},
                    7: {offset: 0.2},
                    8: {offset: 0.2},
                    9: {offset: 0.2},
                    10: {offset: 0.2},
                    11: {offset: 0.2},
                    12: {offset: 0.2},
                    13: {offset: 0.2},
                    14: {offset: 0.2},
                    15: {offset: 0.2},
                    16: {offset: 0.2},
                    17: {offset: 0.2},
                    18: {offset: 0.2},
                    19: {offset: 0.2},
                    20: {offset: 0.2},
                    21: {offset: 0.2},
                    22: {offset: 0.2},
                    23: {offset: 0.2},
          },*/
        
        /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    <?php 
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
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")? number_format((($values[$i]['dealcount']/$totaldealsarray[$i])*100),2,'.',''):0;
                            }?>]
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
                title:"No of Deals(%)",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals(%)"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
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
            $totalamt+=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
        }
        $totalamtsarray[$i]=$totalamt;
       } ?>
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")? number_format((($values[$i]['sumamount']/$totalamtsarray[$i])*100),2,'.',''):0;
                            }?>]
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
                title:"Amount(%)",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount(%)"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2']
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  ,[ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
        piechart3.draw(data3, {title:"No of Deals",sliceVisibilityThreshold:0
        /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2']
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  ,[ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
     piechart4.draw(data4, {title:"Amount",sliceVisibilityThreshold:0/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      

      }
      google.setOnLoadCallback(drawVisualization);
    </script>                    
    
       
    <?php 
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
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>]
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
                title:"No of Deals",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>]
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
                title:"Amount",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2']
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  ,[ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
      piechart5.draw(data3, {title:"No of Deals",sliceVisibilityThreshold:0/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2']
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  ,[ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
      piechart6.draw(data4, {title:"Amount",sliceVisibilityThreshold:0/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <?php 
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
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>]
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
                title:"No of Deals",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>]
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
                title:"Amount",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
        
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2']
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  ,[ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
        piechart7.draw(data3, {title:"No of Deals",sliceVisibilityThreshold:0/*,
        /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2']
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  ,[ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
      piechart8.draw(data4, {title:"Amount",sliceVisibilityThreshold:0/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>       
    <?php 
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
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>]
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
                title:"No of Deals",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                isStacked : true
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>]
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ,["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?round($values[$i]['sumamount']):0;
                            }?>]
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
                title:"Amount",
                width:700, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
              /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal','year1','year2']
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  ,[ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
      piechart9.draw(data3, {title:"No of Deals",sliceVisibilityThreshold:0/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount','year1','year2']
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  ,[ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?($values[$i]['sumamount']):0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount.",";
                            echo $fixstart.",";
                            echo $fixend-1+1;?>]
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
      piechart10.draw(data4, {title:"Amount",sliceVisibilityThreshold:0/*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
       
    <?php 
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
         
       
    <div  class="table-year-deals"  style="width:100%; overflow:hidden; position:absolute;">
    <div class="showhide-link">
        <a href="#" class="show_hide active" rel="#slidingDataTable" name="Table">Close Table</a>
    </div>
    <div class="view-table" id="slidingDataTable" style="padding:0 20px;display:block; overflow:hidden;">
    <div class="restable" >
            
            <table class="testTable1" cellpadding="0" cellspacing="0">
 
   
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

   
    <tr><th   style="text-align:center">Industry</th>
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
                    echo"<th  style=\"text-align:left\">&nbsp; </th>";
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
  <tr><th   style="text-align:center">Stage</th>
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
                    echo"<th   style=\"text-align:left\">&nbsp; </th>";
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
   
       <tr><th style="text-align:center">Investor</th>
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
                    echo"<th   style=\"text-align:left\">&nbsp; </th>";
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
        <tr><th   style="text-align:center">Range</th>
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
                    echo"<th   style=\"text-align:left\">&nbsp; </th>";
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
    <tr><th   style="text-align:center">Region</th>
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
                    echo"<th   style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php
    }
    ?>
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
        $totalRec = count($deal);
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
        $totalRec = count($deal);
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
        $totalRec = count($deal);
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
        $totalRec = count($deal);
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
        $totalRec = count($deal);
        foreach($deal as $Region => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            if($Region!='')
            {
            $content .= '<td>'.$Region.'</td>';
            }
            else
            {
                $content .= '<td>'."--".'</td>';
            }
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;
    }
    ?>
    

        </table>   
</div> 
         <!--div class="showhide-link"><a href="#" class="show_hide" rel="#slidingTable">View  Table</a></div-->
    </div>
        </div>
</td>

</tr>
</table>
 
</div>
 </form>
<div class=""></div>
<div>

            <!--input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalInv; ?>"-->
            <form name="pelisting" id="pelisting"  method="post" action="expdashboardPE.php">
                 <?php
                 if($type==1 || $type==2 || $type==3 || $type==4 || $type==5 || $type==6)
                 {
                     ?>
                        <input type="hidden" name="txttype" value=<?php echo $type; ?> >
        	        <input type="hidden" name="txtstartdate" value=<?php echo $startyear; ?> >
			<input type="hidden" name="txtenddate" value=<?php echo $endyear; ?> >
                         <input type="hidden" name="txtfixstart" value=<?php echo $fixstart; ?> >
			<input type="hidden" name="txtfixend" value=<?php echo $fixend; ?> >
                 <?php  
                 }
                 
                    if($exportToExcel==1)
                    {
                    ?>
                              <div class="title-links" id="exportbtn"></div>
                        <script type="text/javascript">
                              $('#exportbtn').html('<input class ="export" type="button" id="expshowdeals"  value="Export" name="showdeals">');
                        </script>
                    <?php
                    }
		
		
              ?>
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
     $('#expshowdeals').click(function(){
        jQuery('#preloading').fadeIn();   
        initExport();
        return false;
        /*hrefval= 'expdashboardPE.php';
        $("#pelisting").attr("action", hrefval);
        $("#pelisting").submit();*/
        return false;
    });
    
    function initExport(){ 
        $.ajax({
            url: 'ajxCheckDownload.php',
            dataType: 'json',
            success: function(data){
                var downloaded = data['recDownloaded'];
                var exportLimit = data.exportLimit;
                var currentRec = <?php echo $totalRec; ?>;

                //alert(currentRec + downloaded);
                var remLimit = exportLimit-downloaded;
                
                if (currentRec < remLimit){
                    hrefval= 'expdashboardPE.php';
                    $("#pelisting").attr("action", hrefval);
                    $("#pelisting").submit();
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

mysql_close();
    mysql_close($cnx);
    ?>







