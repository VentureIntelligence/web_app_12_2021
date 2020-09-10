<?php
include_once 'db.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Venture Intelligence - League Table</title>
<style type="text/css">
<!--
@import url("style.css");
-->
</style>
		<style type="text/css" title="currentStyle">
			@import "media/css/demo_page.css";
			@import "media/css/demo_table.css";
		</style>
                <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script type="text/javascript" language="javascript" src="media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(function() {
				$('.transcationpe').dataTable();
                                $('.transcationma').dataTable();
                                $('.legalpe').dataTable();
                                $('.legalma').dataTable();
			});
		</script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
	<link rel="stylesheet" type="text/css" href="media/css/tooltipster.css" />
	<script type="text/javascript" src="media/js/jquery.tooltipster.js"></script>	
	<script type="text/javascript">
		$(document).ready(function() {
			

			
			$('.tooltip').tooltipster({
			    animation: 'grow',
			    trigger: 'hover',
			    position: 'right'
			});
			
		});
	</script>
<script>
$(function() {
$( "#tabs" ).tabs();
$( "#tabs2" ).tabs();
$( "#tabsmain" ).tabs();
});
</script> 
<script>
    $(document).ready(function(){
       $("#industry").change( function() {             
             $.ajax({
                     type: "POST",
               data: "id=" + $(this).val(),
               url: "fetchSector.php",
               success: function(msg){
                 $("#sector").html(msg);
               }
            });
       });   
       $("#type").change( function() {             
             var type = $("#type").val();
             if(type == "annual"){
                 $("#quarter").css("display","none");
                 $("#half").css("display","none");
             }
             if(type == "halfyearly"){
                 $("#quarter").css("display","none");
                 $("#half").css("display","block");                 
             }
             if(type == "quarterly"){
                 $("#quarter").css("display","block");
                 $("#half").css("display","none");                 
             }             
       });          
         $("#custom").click( function() {
            $('#league-tables').slideToggle('slow', function() {
           // Animation complete.
           });         
        });      
    });
$(function(){	   


	$("#transPEExport").click(function() {									   
		var data='<table border="1">'+$(".transcationpe").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='exporttoexcel.php' style='display:none' id='transcationpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#transcationpeData').submit().remove();
		 return false;
	});
	$("#transMAExport").click(function() {									   
		var data='<table border="1">'+$(".transcationma").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='exporttoexcel.php' style='display:none' id='transcationmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#transcationmaData').submit().remove();
		 return false;
	});       
	$("#legalPEExport").click(function() {									   
		var data='<table border="1">'+$(".legalpe").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='exporttoexcel.php' style='display:none' id='legalpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalpeData').submit().remove();
		 return false;
	}); 
	$("#legalMAExport").click(function() {									   
		var data='<table border="1">'+$(".legalma").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='exporttoexcel.php' style='display:none' id='legalmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalmaData').submit().remove();
		 return false;
	});           

});    
</script>
</head>
<body>
    <div style="cursor:pointer;margin:0px 10px 0 45px;" id="custom">
        <img src="media/images/search.jpg" style="width:100px;height:75px;">
    </div>    
<div id="league-tables">
	<form class="newsform" id="league_tables" method="POST" action="">			
        	<div style="clear:both; height:30px; padding-bottom:10px;width:100%;">
	 	 <label>Year</label>
<?php
//year to start with
$startdate = 2000;
 
//year to end with - this is set to current year. You can change to specific year
$enddate = date("Y");
 
$years = range ($startdate,$enddate);
 rsort($years);
//print years
?>                 
		 <select id="year" name="year" style="float:left;">
		   <option value="">--Select--</option>
<?php
foreach($years as $year)
{
?>
		    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
<?php
}
?>
		 </select>
		</div>
		<div style="clear:both; height:30px; padding-bottom:10px;">
		<label> Type </label>	
		<select id="type" name="type" style="float:left;">
                    <option value="annual">Annual</option>
                    <option value="halfyearly">Half Yearly</option>
                    <option value="quarterly">Quarterly</option>
                </select>    
		<select id="half" name="half" style="margin-left:5px;float:left;">		  
                    <option value="H1">H1</option>
                    <option value="H2">H2</option>
                </select>  
		<select id="quarter" name="quarter" style="margin-left:5px;float:left;">		  
                    <option value="Q1">Q1</option>
                    <option value="Q2">Q2</option>
                    <option value="Q3">Q3</option>
                    <option value="Q4">Q4</option>                    
                </select>                  
		</div>            
		<div style="clear:both; height:30px; padding-bottom:10px;">
		<label>Deal Type </label>	
			<span><input type="radio" checked="" value="ma" name="deal_type">M&amp;A </span>
			<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" value="pe" name="deal_type">Private Equity </span>
		</div>
		<div style="clear:both; height:30px; padding-bottom:10px;">
		<label>Industry</label>
		<select id="industry" name="industry" style="float:left;">
		    <option value="">-- Select Industry --</option>
                    <?php
                    $Industryselect = mysql_query("SELECT * FROM `industry` ORDER BY industry ASC") or die(mysql_error());  
                    while($fetch_industry = mysql_fetch_array($Industryselect)){
                       echo  "<option value='".$fetch_industry['id']."'>".$fetch_industry['industry']."</option>";
                    }
                    ?>
		</select>
			</div>
		<div style="clear:both; height:30px; padding-bottom:10px;">
		<label>Sector</label>
		<select id="sector" name="sector" style="float:left;">
                    <option value="" selected=""> -- Select Sector -- </option>
		</select>
			</div>            
		 <input type="submit" class="search-button" name="submit" id="submit" value="Search">  
                 <input type="reset" class="reset-button" value="Reset" id="reset_button">    
	 </form>
</div>
<div id="tabsmain">
<ul>
<li id="tbs"><a href="#tabsmain-1">Transaction</a></li>
<li id="tbs"><a href="#tabsmain-2">Legal</a></li>
</ul>
<div id="tabsmain-1">
<div id="tabs">
<ul>
<li id="tbs"><a href="#tabs-1">PE</a></li>
<li id="tbs"><a href="#tabs-2">M&A</a></li>
</ul>    
<?php
   if($_POST['submit']){
      $year = (trim($_POST['year']) != "") ? trim($_POST['year']) : "";
      $type = (trim($_POST['type']) != "") ? trim($_POST['type']) : "";
      $from = "";
      $to = "";
      if($type == "annual"){
          $from = $year."-01-01";
          $to = $year."-12-01";
      }
      if($type == "halfyearly"){
          $half = (trim($_POST['half']) != "") ? trim($_POST['half']) : "";
          if($half == "H1"){
          $from = $year."-01-01";
          $to = $year."-06-01";
          }else{
          $from = $year."-07-01";
          $to = $year."-12-01";              
          }
      }
      if($type == "quarterly"){
          $quarter = (trim($_POST['quarter']) != "") ? trim($_POST['quarter']) : "";
          if($quarter == "Q1"){
          $from = $year."-01-01";
          $to = $year."-03-01";
          }
          if($quarter == "Q2"){
          $from = $year."-04-01";
          $to = $year."-06-01";              
          }
          if($quarter == "Q3"){
          $from = $year."-07-01";
          $to = $year."-09-01";              
          }  
          if($quarter == "Q4"){
          $from = $year."-10-01";
          $to = $year."-12-01";              
          }            
      }
      $dealtype = (trim($_POST['deal_type']) != "") ? trim($_POST['deal_type']) : "";
      $industry = (trim($_POST['industry']) != "") ? trim($_POST['industry']) : "";
      if($industry){
        $getIndustry = mysql_query("SELECT industry from industry WHERE id=$industry");
        $fetchIndustry = mysql_fetch_array($getIndustry);
        $industryName = $fetchIndustry['industry'];
      }
      $sector = (trim($_POST['sector']) != "") ? trim($_POST['sector']) : "";
      if($industry){
        $getSector = mysql_query("SELECT sector from sector WHERE id=$sector");
        $fetchSector = mysql_fetch_array($getSector);
        $sectorName = $fetchSector['sector'];
      }      
   }
   $whereCondition = "";
   if($from && $to){
       $whereCondition .= " AND date between '$from' AND '$to'";
   }
   if($dealtype){
     if($dealtype == 'ma'){
       $whereCondition .= " AND deal_type='M&A'";  
     }
     if($dealtype == 'pe'){
       $whereCondition .= " AND deal_type='PE'";  
     }     
   }
   if($industry){
       $whereCondition .= " AND industry LIKE '$industryName'";
   }  
   if($sector){
       $whereCondition .= " AND sector LIKE '$sectorName'";
   }      
   mysql_select_db("league_tables"); 
   $sqlselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Transaction'$whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY points DESC") or die(mysql_error());
   $count = mysql_num_rows($sqlselect);
?>   
<div id="tabs-1">    
<table id="box-table-a" class="transcationpe" summary="Employee Pay Sheet">
    <thead>
       <tr> 
       <th colspan="5"><b> Top Advisors - PE </b></th>
       </tr>    
    	<tr>
            <th scope="col">Rank</th>            
            <th scope="col">Company Name</th>
            <th scope="col"># of Deals</th>
            <th scope="col">Points</th>
            <th scope="col">Amount $M</th>            
        </tr>
    </thead>
    <tbody>

<?php 
   if($count == 0){
       echo '
        <tr>
            <td></td>
            <td></td>
            <td  style="display:inline-td;"  align="center">No Records found</td>
            <td></td>
            <td></td>
        </tr>           
           ';
   }else{
      $temp_points = ""; 
      $rank = 0;
      while($row = mysql_fetch_array($sqlselect)){
          if($row["points"] == $temp_points){
           $rank = $rank;
          }else{
           $rank = $rank+1;   
          }
          $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$row['advisor_name']."' AND advisor_type='Transaction'AND deal_type='PE' AND notable='Y'");
          $notable = "";
          $finalNotable = "";
          while($fetchNotable = mysql_fetch_array($selectNotable)){
           $notable .= $fetchNotable['deal'].",";
          }
          if($notable != ""){
           $finalNotabl = explode(",",rtrim($notable , ","));
           $finalNotable = "<b><u>Notable Deals</u></b>";
           $finalNotable .= "<ul>";
           foreach($finalNotabl as $val){
            $finalNotable .= "<li>$val</li>";
           }
            $finalNotable .= "</ul>";
            $finalNotable = htmlentities($finalNotable);
          }else{
           $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>No Deal</li></ul>");
          }
          echo "<tr class='tooltip' title='$finalNotable'>";
          echo "<td>".$rank."</td>";
           echo "<td>".$row['advisor_name']."</td>";
           echo "<td>".$row['No_of_deals']."</td>";
           echo "<td>".$row['points']."</td>";
           echo "<td>".$row['Volume']."</td>";           
          echo "</tr>"; 
          $temp_points = $row['points'];
       }  
       
   }
?>
    </tbody>
</table>
<div id="frame1"> <a title="Export To Excel" href="#" id="transPEExport"><img alt="Export To Excel" src="table-images/excel-icon.png"></a></div>    
</div>  
<?php
   $sqlMA = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Transaction'$whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY points DESC") or die(mysql_error());
   $mAcount = mysql_num_rows($sqlMA);
?>
<div id="tabs-2">    
<table id="box-table-a" class="transcationma" summary="Employee Pay Sheet">
    <thead>
       <tr> 
       <th colspan="5"><b> Top Advisors - M&A </b></th>
       </tr>    
    	<tr>
            <th scope="col">Rank</th>             
            <th scope="col">Company Name</th>
            <th scope="col"># of Deals</th>
            <th scope="col">Points</th>
            <th scope="col">Amount $M</th>            
        </tr>
    </thead>
    <tbody>

<?php 
   if($mAcount == 0){
       echo '
        <tr>
            <td></td>
            <td></td>
            <td align="center">No Records found</td>
            <td></td>
            <td></td>
        </tr>           
           ';
   }else{
      $Tr_ma_temp_points = ""; 
      $tr_ma_rank = 0;       
      while($row = mysql_fetch_array($sqlMA)){
          if($row["points"] == $Tr_ma_temp_points){
           $tr_ma_rank = $tr_ma_rank;
          }else{
           $tr_ma_rank = $tr_ma_rank+1;   
          }          
          $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$row['advisor_name']."' AND advisor_type='Transaction'AND deal_type='M&A' AND notable='Y'");
          $notable = "";
          $finalNotable = "";
          while($fetchNotable = mysql_fetch_array($selectNotable)){
           $notable .= $fetchNotable['deal'].",";
          }
          if($notable != ""){
           $finalNotabl = explode(",",rtrim($notable , ","));
           $finalNotable = "<b><u>Notable Deals</u></b>";
           $finalNotable .= "<ul>";
           foreach($finalNotabl as $val){
            $finalNotable .= "<li>$val</li>";
          }
            $finalNotable .= "</ul>";
            $finalNotable = htmlentities($finalNotable);
          }else{
           $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>No Deal</li></ul>");
          }
          echo "<tr class='tooltip' title='$finalNotable'>";
          echo "<td>".$tr_ma_rank."</td>";          
           echo "<td>".$row['advisor_name']."</td>";
           echo "<td>".$row['No_of_deals']."</td>";
           echo "<td>".$row['points']."</td>";
           echo "<td>".$row['Volume']."</td>";           
          echo "</tr>"; 
          $Tr_ma_temp_points = $row['points'];
       }  
       
   }
?>
    </tbody>
</table>
<div id="frame1"> <a title="Export To Excel" href="#" id="transMAExport"><img alt="Export To Excel" src="table-images/excel-icon.png"></a></div>            
</div> 
</div>
</div>
<div id="tabsmain-2">
<div id="tabs2">
<ul>
<li id="tbs"><a href="#tabs2-1">PE</a></li>
<li id="tbs"><a href="#tabs2-2">M&A</a></li>
</ul>    
<?php
   mysql_select_db("league_tables");
   $sqllegalselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY points DESC") or die(mysql_error());
   $countlegal = mysql_num_rows($sqllegalselect);
?>   
<div id="tabs2-1">    
<table id="box-table-a" class="legalpe" summary="Employee Pay Sheet">
    <thead>
       <tr> 
       <th colspan="5"><b> Top Advisors - PE </b></th>
       </tr>    
    	<tr>
            <th scope="col">Rank</th>               
            <th scope="col">Company Name</th>
            <th scope="col"># of Deals</th>
            <th scope="col">Points</th>
            <th scope="col">Amount $M</th>               
        </tr>
    </thead>
    <tbody>

<?php 
   if($countlegal == 0){
       echo '
        <tr>
            <td></td>
            <td></td>
            <td align="center">No Records found</td>
            <td></td>
            <td></td>
        </tr>           
           ';
   }else{
      $legal_pe_temp_points = ""; 
      $legal_pe_rank = 0;            
      while($legalrow = mysql_fetch_array($sqllegalselect)){
          if($legalrow["points"] == $legal_pe_temp_points){
           $legal_pe_rank = $legal_pe_rank;
          }else{
           $legal_pe_rank = $legal_pe_rank+1;   
          }          
          $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow['advisor_name']."' AND advisor_type='Legal'AND deal_type='PE' AND notable='Y'");
          $notable = "";
          $finalNotable = "";
          while($fetchNotable = mysql_fetch_array($selectNotable)){
           $notable .= $fetchNotable['deal'].",";
          }
          if($notable != ""){
           $finalNotabl = explode(",",rtrim($notable , ","));
           $finalNotable = "<b><u>Notable Deals</u></b>";
           $finalNotable .= "<ul>";
           foreach($finalNotabl as $val){
            $finalNotable .= "<li>$val</li>";
           }
            $finalNotable .= "</ul>";
            $finalNotable = htmlentities($finalNotable);
          }else{
           $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>No Deal</li></ul>");
          }
          echo "<tr class='tooltip' title='$finalNotable'>";
          echo "<td>".$legal_pe_rank."</td>"; 
           echo "<td>".$legalrow['advisor_name']."</td>";
           echo "<td>".$legalrow['No_of_deals']."</td>";
           echo "<td>".$legalrow['points']."</td>";
           echo "<td>".$legalrow['Volume']."</td>";           
          echo "</tr>";       
          $legal_pe_temp_points = $row['points'];
       }  
       
   }
?>
    </tbody>
</table>
<div id="frame1"> <a title="Export To Excel" href="#" id="legalPEExport"><img alt="Export To Excel" src="table-images/excel-icon.png"></a></div>                
</div>  
<?php
   $sqlMALegalselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY points DESC") or die(mysql_error());
   $MAcountlegal = mysql_num_rows($sqlMALegalselect);
?>
<div id="tabs2-2">    
<table id="box-table-a" class="legalma" summary="Employee Pay Sheet">
    <thead>
       <tr> 
       <th colspan="5"><b> Top Advisors - M&A </b></th>
       </tr>    
    	<tr>
            <th scope="col">Rank</th>              
            <th scope="col">Company Name</th>
            <th scope="col"># of Deals</th>
            <th scope="col">Points</th>
            <th scope="col">Amount $M</th>
        </tr>
    </thead>
    <tbody>

<?php 
   if($MAcountlegal == 0){
       echo '
        <tr>
            <td></td>
            <td></td>
            <td align="center">No Records found</td>
            <td></td>
            <td></td>
        </tr>           
           ';
   }else{
      $legal_ma_temp_points = ""; 
      $legal_m_rank = 0;           
      while($legalrow = mysql_fetch_array($sqlMALegalselect)){
          if($legalrow["points"] == $legal_ma_temp_points){
           $legal_m_rank = $legal_m_rank;
          }else{
           $legal_m_rank = $legal_m_rank+1;   
          }          
          $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow['advisor_name']."' AND advisor_type='Legal'AND deal_type='M&A' AND notable='Y'");
          $notable = "";
          $finalNotable = "";
          while($fetchNotable = mysql_fetch_array($selectNotable)){
           $notable .= $fetchNotable['deal'].",";
          }
          if($notable != ""){
           $finalNotabl = explode(",",rtrim($notable , ","));
           $finalNotable = "<b><u>Notable Deals</u></b>";
           $finalNotable .= "<ul>";
           foreach($finalNotabl as $val){
            $finalNotable .= "<li>$val</li>";
           }
            $finalNotable .= "</ul>";
            $finalNotable = htmlentities($finalNotable);
          }else{
           $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>No Deal</li></ul>");
          }
          echo "<tr class='tooltip' title='$finalNotable'>";
          echo "<td>".$legal_m_rank."</td>"; 
           echo "<td>".$legalrow['advisor_name']."</td>";
           echo "<td>".$legalrow['No_of_deals']."</td>";
           echo "<td>".$legalrow['points']."</td>";
           echo "<td>".$legalrow['Volume']."</td>";           
          echo "</tr>";         
       }  
       
   }
?>
    </tbody>
</table>
<div id="frame1"> <a title="Export To Excel" href="#" id="legalMAExport"><img alt="Export To Excel" src="table-images/excel-icon.png"></a></div>                    
</div>    
</div>    
</div>
</div>
</body>
</html>
