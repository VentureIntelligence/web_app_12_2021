<?php
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();

$fields = array("*");
$CompareCount = count($_REQUEST['answer']['CCompanies']);

		for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
			if($i == 0)
				$where .= "CId_FK = ".$_REQUEST['answer']['CCompanies'][$i]." AND FY = ".$_REQUEST['answer']['Year'];
			else
				$where .= " OR CId_FK = ".$_REQUEST['answer']['CCompanies'][$i]." AND FY = ".$_REQUEST['answer']['Year'];
		}
		$order = " SCompanyName ASC";
		$CompareResults = $plstandard->GetCompareCompanies($where,$order,"name");

for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
	$TotalIncome[$CompareResults[$i]['SCompanyName']]  .= $CompareResults[$i]['TotalIncome'];
}
$TotalIncomeNegative = !(strpos(implode($TotalIncome), '-') === false);
//$template->assign("TotalIncomeNegative" , $TotalIncomeNegative);

for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
	$EBITDA[$CompareResults[$i]['SCompanyName']]  .= $CompareResults[$i]['EBITDA'];
}
$EBITDAIncomeNegative = !(strpos(implode($EBITDA), '-') === false);
//$template->assign("EBITDAIncomeNegative" , $EBITDAIncomeNegative);

for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
	$PAT[$CompareResults[$i]['SCompanyName']]  .= $CompareResults[$i]['PAT'];
}
$PATIncomeNegative = !(strpos(implode($EBITDA), '-') === false);
//$template->assign("PATIncomeNegative" , $PATIncomeNegative);
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php if($TotalIncomeNegative != 1) { ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
<?php
        // query MySQL and put results into array $results
		foreach ($TotalIncome as $row=>$RS) {
            echo "data.addRow(['{$row}', {$RS}]);";
        }
?>	   
        var options = {
          width: 450, height: 300,
          title: 'Revenue',
		  is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('optnlIncome'));
        chart.draw(data, options);
      }
    </script>
<?php } ?>
<?php if($EBITDAIncomeNegative != 1) { ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
<?php
        // query MySQL and put results into array $results
		foreach ($EBITDA as $ebit=>$RSebit) {
            echo "data.addRow(['{$ebit}', {$RSebit}]);";
        }
?>	   
        var options = {
          width: 450, height: 300,
          title: 'EBITDA',
		  is3D: true
        };
		var chart = new google.visualization.PieChart(document.getElementById('EBITDA'));
        chart.draw(data, options);
      }
    </script>
<?php } ?>



<?php if($PATIncomeNegative != 1) { ?>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
<?php
        // query MySQL and put results into array $results
		foreach ($PAT as $PATrow=>$PATRS) {
            echo "data.addRow(['{$PATrow}', {$PATRS}]);";
        }
?>	   
        var options = {
          width: 450, height: 300,
          title: 'PAT',
		  is3D: true
        };
		var chart = new google.visualization.PieChart(document.getElementById('PAT'));
        chart.draw(data, options);
      }
    </script>
<?php }

mysql_close();?>



</html>