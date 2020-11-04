<?php
    include_once 'LeagueTables/db.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>League Tables | Venture Intelligence - Top Investment Banks & Law Firms in India </title>
<!--<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>-->
<link rel="shortcut icon" href="img/fave-icon.png">
<link rel="stylesheet" href="css/home-page-style.css">
<link rel="stylesheet" href="css/owl.carousel.css" >
<link rel="stylesheet" href="css/owl.theme.css" >
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/ios-reorient.js"></script>
<script type="text/javascript" src="js/ui.js"></script>
<script type="text/javascript" src="js/owl.carousel.js"></script>
<script src='js/jquery.min.js'></script>
<style>
.opne-nav-fix{ position:fixed; top:0;width:100%;background:none repeat scroll 0 0 hsla(0, 0%, 98%, 0.97);border-bottom:1px solid #E0E0E0}
.opne-nav-fix span{display:none}

img.fixed-logo{display:none}
.opne-nav-fix .site-nav ul li a{color:#000000}
.opne-nav-fix .site-nav ul li a:hover{color:#F2AB11}
</style>
<!-- Table Sort -->
<script type="text/javascript" language="javascript" src="LeagueTables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
        $(function() {
                /*$('.transcationpe').dataTable();
                $('.transcationma').dataTable();
                $('.legalpe').dataTable();
                $('.legalma').dataTable();*/
        });
</script>
<!-- Sort End -->

<!-- Tooltip Srarts -->
<link rel="stylesheet" type="text/css" href="css/tooltipster.css" />
<script type="text/javascript" src="js/jquery.tooltipster.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.tooltip').tooltipster({
			animation: 'grow',
			trigger: 'hover',
			position: 'right'
		});

	});
</script>
<!-- Tooltip Ends -->

<script>
    $(document).ready(function(){
        $('#OtherTransaction').click( function(e){
           if($('#OtherTransaction').is(":checked"))
           {
             //window.location.href="?others=1";
               $("#league_tables").attr('action','leagues.php?others=1');
           }else{
             //window.location.href="leagues.php";
               $("#league_tables").attr('action','leagues.php');
           }
           $('#submit').trigger( "click" );
           $('#league_tables').submit();
        });
    });

    $(function(){


	$("#transPEExport1").click(function() {

		var data='<table border="1">'+$(".transcationpe1").html().replace(/<a\<span\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='transcationpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
                $('#transcationpeData').submit().remove();
                return false;
	});

        $("#transPEExport2").click(function() {


		var data='<table border="1">'+$(".transcationpe2").html().replace(/<a\<span\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='transcationpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
                $('#transcationpeData').submit().remove();
                return false;
	});


	$("#transMAExport1").click(function() {
		var data='<table border="1">'+$(".transcationma1").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='transcationmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#transcationmaData').submit().remove();
		 return false;
	});
        $("#transMAExport2").click(function() {
		var data='<table border="1">'+$(".transcationma2").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='transcationmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#transcationmaData').submit().remove();
		 return false;
	});


	$("#legalPEExport1").click(function() {
		var data='<table border="1">'+$(".legalpe1").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='legalpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalpeData').submit().remove();
		 return false;
	});
        $("#legalPEExport2").click(function() {
		var data='<table border="1">'+$(".legalpe2").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='legalpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalpeData').submit().remove();
		 return false;
	});
        $("#legalPEExport3").click(function() {
		var data='<table border="1">'+$(".legalpe3").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='legalpeData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalpeData').submit().remove();
		 return false;
	});



	$("#legalMAExport1").click(function() {
		var data='<table border="1">'+$(".legalma1").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='legalmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalmaData').submit().remove();
		 return false;
	});

        $("#legalMAExport2").click(function() {
		var data='<table border="1">'+$(".legalma2").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='legalmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalmaData').submit().remove();
		 return false;
	});


        $("#legalMAExport3").click(function() {
		var data='<table border="1">'+$(".legalma3").html().replace(/<a\/?[^>]+>/gi, '')+'</table>';
		$('body').prepend("<form method='post' action='LeagueTables/exporttoexcel.php' style='display:none' id='legalmaData'><input type='text' name='tableData' value='"+data+"' ></form>");
		 $('#legalmaData').submit().remove();
		 return false;
	});

    });
</script>

</head>

<body>
        <?php
    $yearVal = mysql_query("SELECT YEAR(date) as year FROM league_table_data GROUP BY YEAR(date)");
    while ($y = mysql_fetch_array($yearVal)) {

        if($y['year']>0){
            $Lyears[] = $y['year'];
        }
    }
    $Lyears = array_unique($Lyears);
    rsort($Lyears);


    $Lindustry = mysql_query("SELECT i.id, l.industry FROM league_table_data l JOIN industry i ON i.industry=l.industry GROUP BY l.industry");


    ?>

<div class="wrapper">
  <header class="fd-header">
    <div class="top-nav-strip">
      <div class="l-page">
        <nav class="top-site-nav">
          <ul>
            <!--<li><a href="pricing.htm">Pricing</a></li>-->
            <li><a href="trial.htm">Request Trial</a></li>
            <li><a href="entrepreneurs.htm">For Entrepreneurs</a></li>
            <li><a href="events.htm">Events</a></li>
           <!-- <li><a href="news.htm">News</a></li>-->
            <li><a href="db.htm">Login</a></li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="header fd-sticky fc">
    <div class="sticky-wrapper">
        <section class="fd-home-sticky">
          <div class="l-page">
          <div class="logo-sec">
          <a href="index.htm" class="fd-logo"><img class="default" src="img/logo.png" alt="vi"> <img class="fixed-logo" src="img/logo-b.png" alt="vi">

          </a>
          <span>Private Company Financials, Transactions & Valuations.</span>
          </div>
            <nav class="site-nav">
              <ul>
                <li><a href="index.htm">Home</a></li>
                <li><a href="products.htm" >Products</a></li>
                <li><a href="leagues.php"  class="active">League Tables</a></li>
                <li><a href="index.htm#sec-new" >What's New</a></li>
                <li class="por-hide"><a href="aboutus.htm" >About Us</a></li>
                <li class="por-hide"><a href="contactus.htm" >Contact</a></li>
              </ul>
            </nav>
          </div>
        </section>

      </div>
    </div>
  </header>

  <!-- inner page header -->
  <div class="inner-header league-tables">
  	<div class="container-01">
    	<div class="content">
      		<div class="row">
                <h2>League Tables</h2>
            </div>
        </div>
    </div>
  </div>

  <div class="clearfix"></div>
  <div class="container-01">
    <div class="content">
      <div class="row">
        <div class="new-sec" id="sec-new">

        	<div class="inner-page">
            	<div class="league-tab">

                  <br>
                  <h3>League Tables - Updated Now For 2017 </h3>
                  <p class="">
                    The Venture Intelligence League Tables, the first such initiative exclusively tracking transactions involving India-based companies, are based on value of PE and M&A transactions advised by Transaction and Legal Advisory firms during the calendar year. The League Tables are compiled based on transactions submitted by the advisory firms and filtered using Venture Intelligence definitions
                  </p>

                  <div class="league-tab-col">

                        <div class="search-bar" style="<?php if(!isset($_POST['submit'])){echo 'display:none';} ?>">
                            <form method="post" name="league_tables" class="newsform" id="league_tables" action="">
                            	<p>
                                    <label for="year">Year</label>
                                    <?php
                                        //year to start with
                                        $startdate = 2000;

                                        //year to end with - this is set to current year. You can change to specific year
                                        $enddate = date("Y");

                                        $years = range ($startdate,$enddate);
                                         rsort($years);
                                        //print years
                                    ?>
                                    <select name="year" id="year">
                                        <?php
                                        foreach($Lyears as $year)
                                        {
                                            $yearsel = "";
                                            if(isset($_POST['submit'])){
                                                $selectedyear = $_POST['year'];
                                            if($year == $selectedyear){
                                                $yearsel = "selected";
                                            }else{
                                                $yearsel = "";
                                            }
                                        }
                                        ?>
                                        <option value="<?php echo $year; ?>" <?php echo $yearsel; ?>><?php echo $year; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                               	</p>
                                <p>
                            		<label for="industry">Industry</label>
                                    <select name="industry" id="industry">
                                    	<option value=""> -- Select Industry --</option>
                                        <?php
                                            $Industryselect = mysql_query("SELECT * FROM `industry` ORDER BY industry ASC") or die(mysql_error());



                                            while($fetch_industry = mysql_fetch_array($Lindustry)){
                                                if(isset($_POST['submit'])){
                                                $selecindustry = $_POST['industry'];
                                                if($fetch_industry['id'] == $selecindustry){
                                                $industrysel = "selected";
                                                }else{
                                                $industrysel = "";
                                                }
                                                }
                                               echo  "<option value='".$fetch_industry['id']."' ".$industrysel.">".$fetch_industry['industry']."</option>";
                                            }
                                        ?>
                                    </select>
                               	</p>
                                <p class="controls">
                                	<input type="submit" value="Search" name="submit" id="submit" />
                                        <input type="reset" value="Reset" name="reset" />
                                    <a href="javascript:;" class="down" title="Close Search!">&nbsp;</a>
                                </p>
                            </form>
                        </div>

                        <ul class="tabs">
                            <li class="tab-link current" data-tab="tab-1">Transaction</li>
                            <li class="tab-link" data-tab="tab-2">Legal</li>
                            <div class="search" id="searchDIV"><a style="<?php if(isset($_POST['submit'])){echo 'display:none';} ?>" href="javascript:;">Advanced Search</a></div>
                        </ul>

                        <div id="tab-1" class="tab-content current">

                            <ul class="stabs">
                                <li class="tab-link current" data-tab="stab-1-1"> PE </li>
                                <li class="tab-link" data-tab="stab-2-1"> M&A </li>

                                <div class="include">
                                    <input type="checkbox" name="OtherTransaction" id="OtherTransaction" value="other" <?php if(isset($_GET['others'])){ echo "checked"; }  ?> /><span>Include Due Diligence,Tax,Other Advisory Services</span>
                                </div>
                                <div class="include-deals">

                                    <div class="dealsby">
                                        Rank By  :
                                            <input type="radio" value="1" name="rank" id="amount" <?php echo ($_POST['rank']==1)?'Checked':'' ?> checked/>
                                            <label  for="amount">Amount</label>

                                            <input type="radio" value="2" name="rank" id="deals" <?php echo ($_POST['rank']==2)?'Checked':'' ?>/>
                                            <label  for="deals">Deals</label>
                                    </div>
                                </div>
                            </ul>
                            <?php
                                $exportId='';
                                $from = "";
                                $to = "";
                                $dealtype='';
                                $industry="";
                                $sector="";
                                if(isset($_POST['submit'])){

                                    $year = (trim($_POST['year']) != "") ? trim($_POST['year']) : "";

                                    $industry = (trim($_POST['industry']) != "") ? trim($_POST['industry']) : "";
                                    if($industry){
                                      $getIndustry = mysql_query("SELECT industry from industry WHERE id=$industry");
                                      $fetchIndustry = mysql_fetch_array($getIndustry);
                                      $industryName = $fetchIndustry['industry'];
                                    }
                                 }
                                 else{
                                      $year = $Lyears[0];
                                 }

                                    $from   = $year."-01-01";
                                    $to     = $year."-12-31";
                                 $whereCondition = "";

                                 if($from && $to){

                                     $whereCondition .= " AND date between '$from' AND '$to'";
                                 }
                              //   if($dealtype){
                              //     if($dealtype == 'ma'){
                              //       $whereCondition .= " AND deal_type='M&A'";
                              //     }
                              //     if($dealtype == 'pe'){
                              //       $whereCondition .= " AND deal_type='PE'";
                              //     }
                              //   }
                                 if($industry){
                                     $whereCondition .= " AND industry LIKE '$industryName'";
                                 }
                              //   if($sector){
                              //       $whereCondition .= " AND sector LIKE '$sectorName'";
                              //   }
                                 $others=0;
                                 if(isset($_REQUEST['others'])){
                                     $others=$_REQUEST['others'];
                                 }

                                if($others == "1"){
                                $advisortyp = "`advisor_type` LIKE ('%Transaction%') ";
                                }else{
                                  $advisortyp = "advisor_type='Transaction' ";
                                }
                               // echo "SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE $advisortyp $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY Volume DESC";

                                $sqlselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE $advisortyp $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY Volume DESC") or die(mysql_error());
                                $count = mysql_num_rows($sqlselect);

                            ?>

                            <div id="stab-1-1" class="stab-content current" data-current="stab-1-1">
                                 <table class="stabp-table transcationpe1">
                                     <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - PE</th>
                                        </tr>

                                        <tr class="top-header2">
                                          <!--  <th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                            <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>

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
                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$row['advisor_name']."' AND advisor_type LIKE 'Transaction%' AND deal_type='PE' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($row['Volume'] == '0'){
                                                     $amountFin = "";
                                                   }else{
                                                     $amountFin = number_format($row['Volume'], 2, '.', '');
                                                   }

                                                    $temp_points = $row['points'];
                                        ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $rank; ?></td>
                                            <td><?php echo $row['advisor_name']; ?></td>
                                            <td><?php echo $row['No_of_deals']; ?></td>
                                            <td><?php echo $amountFin; ?></td>
                                        </tr>
                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export to Excel" href="#" id="transPEExport1">Export to Excel</a></div>
                            </div>
                            <?php
                          //  echo "SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE $advisortyp$whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY No_of_deals DESC";
                                $sqlselect2 = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE $advisortyp $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY No_of_deals DESC") or die(mysql_error());
                                $count2 = mysql_num_rows($sqlselect2);

                            ?>

                            <div id="stab-1-2" class="stab-content" data-current="stab-1-2">
                                 <table class="stabp-table transcationpe2">
                                     <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - PE</th>
                                        </tr>

                                        <tr class="top-header2">
                                            <!--<th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                            <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($count2 == 0){
                                                echo '
                                                 <tr>
                                                     <td></td>
                                                     <td></td>
                                                     <td  style="display:inline-td;"  align="center">No Records found</td>

                                                     <td></td>
                                                 </tr>
                                                    ';
                                            }else{
                                               $temp_deals = "";
                                               $rank = 0;
                                               while($row2= mysql_fetch_array($sqlselect2)){


                                                    if($row2["No_of_deals"] == $temp_deals){
                                                        $rank = $rank;
                                                    }else{
                                                        $rank = $rank+1;
                                                    }
                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$row2['advisor_name']."' AND advisor_type LIKE 'Transaction%' AND deal_type='PE' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($row2['Volume'] == '0'){
                                                     $amountFin = "";
                                                   }else{
                                                     $amountFin = number_format($row2['Volume'], 2, '.', '');
                                                   }

                                                    $temp_deals = $row2['No_of_deals'];


                                        ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $rank; ?></td>
                                            <td><?php echo $row2['advisor_name']; ?></td>
                                            <td><?php echo $row2['No_of_deals']; ?></td>
                                            <td><?php echo $amountFin; ?></td>
                                        </tr>
                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export to Excel" href="#" id="transPEExport2">Export to Excel</a></div>
                            </div>
                            <?php
                               //echo "SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE  $advisortyp $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY Volume DESC";
                                $sqlMA = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE  $advisortyp $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY Volume DESC") or die(mysql_error());
                                $mAcount = mysql_num_rows($sqlMA);
                            ?>

                            <div id="stab-2-1" class="stab-content" data-current="stab-2-1">
                                 <table class="stabp-table transcationma1">
                                     <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - M&A</th>
                                        </tr>

                                        <tr class="top-header2">
                                           <!-- <th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                            <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>
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

                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$row['advisor_name']."' AND advisor_type LIKE 'Transaction%' AND deal_type='M&A' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($row['Volume'] == '0'){
                                                     $amountFin = "";
                                                   }else{
                                                     $amountFin = number_format($row['Volume'], 2, '.', '');
                                                   }

                                                    $Tr_ma_temp_points = $row['points'];

                                     ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $tr_ma_rank; ?></td>
                                            <td><?php echo $row['advisor_name']; ?></td>
                                            <td><?php echo $row['No_of_deals']; ?></td>
                                            <td><?php echo $amountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                 <div class="export"> <a title="Export To Excel" href="#" id="transMAExport1">Export To Excel</a></div>
                            </div>

                            <?php

                                $sqlMA2 = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE  $advisortyp $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY No_of_deals DESC") or die(mysql_error());
                                $mAcount2 = mysql_num_rows($sqlMA2);
                            ?>

                            <div id="stab-2-2" class="stab-content" data-current="stab-2-2" >
                                 <table class="stabp-table transcationma2">
                                     <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - M&A</th>
                                        </tr>

                                        <tr class="top-header2">
                                          <!--  <th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                             <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($mAcount2 == 0){
                                                echo '
                                                 <tr>
                                                     <td></td>
                                                     <td></td>
                                                     <td align="center">No Records found</td>

                                                     <td></td>
                                                 </tr>
                                                    ';
                                            }else{

                                               $Tr_ma_temp_deals = "";
                                               $tr_ma_rank = 0;
                                               while($row2 = mysql_fetch_array($sqlMA2)){


                                                    if($row2["No_of_deals"] == $Tr_ma_temp_deals){
                                                        $tr_ma_rank = $tr_ma_rank;
                                                    }else{
                                                        $tr_ma_rank = $tr_ma_rank+1;
                                                    }

                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$row2['advisor_name']."' AND advisor_type LIKE 'Transaction%' AND deal_type='M&A' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($row2['Volume'] == '0'){
                                                     $amountFin = "";
                                                   }else{
                                                     $amountFin = number_format($row2['Volume'], 2, '.', '');
                                                   }

                                                   $Tr_ma_temp_deals = $row2['No_of_deals'];


                                     ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $tr_ma_rank; ?></td>
                                            <td><?php echo $row2['advisor_name']; ?></td>
                                            <td><?php echo $row2['No_of_deals']; ?></td>
                                            <td><?php echo $amountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                 <div class="export"> <a title="Export To Excel" href="#" id="transMAExport2">Export To Excel</a></div>
                            </div>
                        </div>


                        <!-- Tab 2-1 -->
                        <div id="tab-2" class="tab-content">

                        	<ul class="dtabs">
                                <li class="tab-link current" data-tab="dtab-1-1"> PE </li>
                                <li class="tab-link" data-tab="dtab-2-1"> M&A </li>
                                <div class="include-deals">
                                    <div class="dealsby">
                                        Rank By  :
                                            <input type="radio" value="3" name="rank" id="amount1" <?php echo ($_POST['rank']==3)?'Checked':'' ?> Checked/>
                                            <label  for="amount1">Amount</label>

                                            <input type="radio" value="4" name="rank" id="deals1" <?php echo ($_POST['rank']==4)?'Checked':'' ?>/>
                                            <label  for="deals1">Deals</label>
                                    </div>
                                </div>
                            </ul>
                            <?php

                                $sqllegalselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY Volume DESC") or die(mysql_error());
                                $countlegal = mysql_num_rows($sqllegalselect);
                             ?>
                        	<div id="dtab-1-1" class="dtab-content current" data-current="dtab-1-1">
                             	<table class="stabp-table legalpe1">
                                    <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - PE</th>
                                        </tr>

                                        <tr class="top-header2">
                                           <!-- <th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                             <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>
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
                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow['advisor_name']."' AND advisor_type='Legal'AND deal_type='PE' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($legalrow['Volume'] == '0'){
                                                     $legalamountFin = "";
                                                   }else{
                                                     $legalamountFin = number_format($legalrow['Volume'], 2, '.', '');
                                                   }

                                                   $legal_pe_temp_points = $legalrow['points'];

                                         ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $legal_pe_rank; ?></td>
                                            <td><?php echo $legalrow['advisor_name']; ?></td>
                                            <td><?php echo $legalrow['No_of_deals']; ?></td>
                                            <td><?php echo $legalamountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export To Excel" href="#" id="legalPEExport1">Export To Excel</a></div>
                        	</div>
                             <?php

                                $sqllegalselect2 = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY No_of_deals DESC") or die(mysql_error());
                                $countlegal2 = mysql_num_rows($sqllegalselect2);
                             ?>
                            <div id="dtab-1-2" class="dtab-content " data-current="dtab-1-2"  >
                             	<table class="stabp-table legalpe2">
                                    <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - PE</th>
                                        </tr>

                                        <tr class="top-header2">
                                           <!-- <th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->


                                            <th>Rank</th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if($countlegal2 == 0){
                                                echo '
                                                 <tr>
                                                     <td></td>
                                                     <td></td>
                                                     <td align="center">No Records found</td>

                                                     <td></td>
                                                 </tr>
                                                    ';
                                            }else{

                                               $legal_pe_temp_deals = "";
                                               $legal_pe_rank2 = 0;
                                               while($legalrow2 = mysql_fetch_array($sqllegalselect2)){
                                                   if($legalrow2["No_of_deals"] == $legal_pe_temp_deals){
                                                    $legal_pe_rank2 = $legal_pe_rank2;
                                                   }else{
                                                    $legal_pe_rank2 = $legal_pe_rank2+1;
                                                   }
                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow2['advisor_name']."' AND advisor_type='Legal'AND deal_type='PE' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($legalrow2['Volume'] == '0'){
                                                     $legalamountFin = "";
                                                   }else{
                                                     $legalamountFin = number_format($legalrow2['Volume'], 2, '.', '');
                                                   }

                                                   $legal_pe_temp_deals = $legalrow2['No_of_deals'];

                                         ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $legal_pe_rank2; ?></td>
                                            <td><?php echo $legalrow2['advisor_name']; ?></td>
                                            <td><?php echo $legalrow2['No_of_deals']; ?></td>
                                            <td><?php echo $legalamountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export To Excel" href="#" id="legalPEExport2">Export To Excel</a></div>
                            </div>
                            <?php
                                $sqlMALegalselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY Volume DESC") or die(mysql_error());
                                $MAcountlegal = mysql_num_rows($sqlMALegalselect);
                            ?>
                            <div id="dtab-2-1" class="dtab-content" data-current="dtab-2-1">
                             	<table class="stabp-table legalma1">
                                    <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - M&A</th>
                                        </tr>

                                        <tr class="top-header2">
                                            <!--<th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                             <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>

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
                                               $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow['advisor_name']."' AND advisor_type='Legal'AND deal_type='M&A' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                               }
                                               if($legalrow['Volume'] == '0'){
                                                 $legalamountFin = "";
                                               }else{
                                                 $legalamountFin = number_format($legalrow['Volume'], 2, '.', '');
                                               }

                                               $legal_ma_temp_points = $legalrow['points'];

                                    ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $legal_m_rank; ?></td>
                                            <td><?php echo $legalrow['advisor_name']; ?></td>
                                            <td><?php echo $legalrow['No_of_deals']; ?></td>
                                            <td><?php echo $legalamountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export To Excel" href="#" id="legalMAExport1">Export To Excel</a></div>
                        	</div>
                                <?php
                                $sqlMALegalselect2 = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY No_of_deals DESC") or die(mysql_error());
                                $MAcountlegal2 = mysql_num_rows($sqlMALegalselect2);
                            ?>
                            <div id="dtab-2-2" class="dtab-content" data-current="dtab-2-2"  >
                             	<table class="stabp-table legalma2">
                                    <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - M&A</th>
                                        </tr>

                                        <tr class="top-header2">
                                            <!--<th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                            <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if($MAcountlegal2 == 0){
                                            echo '
                                             <tr>
                                                 <td></td>
                                                 <td></td>
                                                 <td align="center">No Records found</td>

                                                 <td></td>
                                             </tr>
                                                ';
                                        }else{

                                           $legal_ma_temp_deals = "";
                                           $legal_m_rank = 0;
                                           while($legalrow2 = mysql_fetch_array($sqlMALegalselect2)){
                                               if($legalrow2["No_of_deals"] == $legal_ma_temp_deals){
                                                $legal_m_rank = $legal_m_rank;
                                               }else{
                                                $legal_m_rank = $legal_m_rank+1;
                                               }
                                               $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow2['advisor_name']."' AND advisor_type='Legal'AND deal_type='M&A' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                               }
                                               if($legalrow2['Volume'] == '0'){
                                                 $legalamountFin = "";
                                               }else{
                                                 $legalamountFin = number_format($legalrow2['Volume'], 2, '.', '');
                                               }

                                               $legal_ma_temp_deals = $legalrow2['No_of_deals'];

                                    ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $legal_m_rank; ?></td>
                                            <td><?php echo $legalrow2['advisor_name']; ?></td>
                                            <td><?php echo $legalrow2['No_of_deals']; ?></td>
                                            <td><?php echo $legalamountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export To Excel" href="#" id="legalMAExport2">Export To Excel</a></div>
                            </div>
                        </div>

                        <!-- Tab 2-2 -->
                        <div id="tab-2" class="tab-content" style="display:none">

                        	<ul class="dtabs">
                                <li class="tab-link current" data-tab="dtab-1"> PE </li>
                                <li class="tab-link" data-tab="dtab-2"> M&A </li>

                            </ul>
                            <?php

                                $sqllegalselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='PE' GROUP BY advisor_name ORDER BY No_of_deals DESC") or die(mysql_error());
                                $countlegal = mysql_num_rows($sqllegalselect);
                             ?>
                        	<div id="dtab-1" class="dtab-content current">
                             	<table class="stabp-table legalpe3">
                                    <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - PE</th>
                                        </tr>

                                        <tr class="top-header2">
                                           <!-- <th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                             <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>
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
                                                   $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow['advisor_name']."' AND advisor_type='Legal'AND deal_type='PE' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                    $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                                   }
                                                   if($legalrow['Volume'] == '0'){
                                                     $legalamountFin = "";
                                                   }else{
                                                     $legalamountFin = number_format($legalrow['Volume'], 2, '.', '');
                                                   }

                                                   $legal_pe_temp_points = $legalrow['points'];

                                         ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $legal_pe_rank; ?></td>
                                            <td><?php echo $legalrow['advisor_name']; ?></td>
                                            <td><?php echo $legalrow['No_of_deals']; ?></td>
                                            <td><?php echo $legalamountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export To Excel" href="#" id="legalPEExport3">Export To Excel</a></div>
                        	</div>

                            <?php
                                $sqlMALegalselect = mysql_query("SELECT count( id ) AS No_of_deals, advisor_name, SUM( points ) AS points, SUM(amount) AS Volume FROM `league_table_data` WHERE advisor_type='Legal' $whereCondition AND deal_type='M&A' GROUP BY advisor_name ORDER BY Volume DESC") or die(mysql_error());
                                $MAcountlegal = mysql_num_rows($sqlMALegalselect);
                            ?>
                            <div id="dtab-2" class="dtab-content">
                             	<table class="stabp-table legalma3">
                                    <thead>
                                        <tr>
                                            <th class="top-header" colspan="4">Top Advisors - M&A</th>
                                        </tr>

                                        <tr class="top-header2">
                                            <!--<th>Rank <span class="down-arrow"></span></th>
                                            <th>Company Name <span class="down-arrow"></span></th>
                                            <th>#of Deals <span class="down-arrow"></span></th>
                                            <th>Amount $M <span class="down-arrow"></span></th>-->

                                            <th>Rank </th>
                                            <th>Company Name </th>
                                            <th>#of Deals </th>
                                            <th>Amount $M </th>
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
                                               $selectNotable = mysql_query("SELECT deal,notable FROM league_table_data WHERE advisor_name = '".$legalrow['advisor_name']."' AND advisor_type='Legal'AND deal_type='M&A' AND  date between '$from' AND '$to'  AND notable='Y'");
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
                                                $finalNotable = htmlentities("<b><u>Notable Deals</u></b><ul><li>NA</li></ul>");
                                               }
                                               if($legalrow['Volume'] == '0'){
                                                 $legalamountFin = "";
                                               }else{
                                                 $legalamountFin = number_format($legalrow['Volume'], 2, '.', '');
                                               }

                                               $legal_ma_temp_points = $legalrow['points'];

                                    ?>
                                        <tr class='tooltip' title='<?php echo $finalNotable; ?>'>
                                        	<td><?php echo $legal_m_rank; ?></td>
                                            <td><?php echo $legalrow['advisor_name']; ?></td>
                                            <td><?php echo $legalrow['No_of_deals']; ?></td>
                                            <td><?php echo $legalamountFin; ?></td>
                                        </tr>

                                        <?php
                                            }

                                        }
                                        ?>
                                 	</tbody>
                                 </table>
                                <div class="export"> <a title="Export To Excel" href="#" id="legalMAExport3">Export To Excel</a></div>
                        	</div>

                        </div>
<!--                         <div class="export">
                             <a href="#" >Export to Excel</a>
                         </div>
                       -->
                  </div>

				</div>
         	</div>

        </div>
      </div>
    </div>
  </div>

  <div class="clearfix"></div>
  <div class="container-02">
    <div class="content">
      <div class="row">
        <div class="col-1-2 address-sec" id="add-sec">
          <address>
          <a href="javascript:;"> <img src="img/foot_logo.png" width="170" height="46" alt="vi" title="vi"></a> <a href="javascript:;" class="email-li">bizdev@ventureintelligence.com </a> <a href="javascript:;" class="mob-no">+91-44-4218-5180 </a>
          <p>Venture Intelligence (TSJ Media Pvt. Ltd.) <br />
          1, Maharani Chinnamba Road; Alwarpet; Chennai - 600018. India.</p>
          </address>
          <!-- <a target="_blank" href="https://www.google.co.in/maps/place/Venture+Intelligence/@13.0363719,80.2549934,17z/data=!3m1!4b1!4m5!3m4!1s0x3a5266352a0fcfb9:0x73791623f88292ab!8m2!3d13.0363719!4d80.2571821?hl=en" class="directions">Directions</a>  -->
        </div>
        <div class="col-1-2">
          <div class="social-sec">
            <h4>Follow us on</h4>
            <nav>
            <a href="http://ventureintelligence.blogspot.in/" class="icon-block"></a>
            <a href="https://in.linkedin.com/in/ventureintelligence" class="icon-linkedin"></a>
            <a href="https://twitter.com/ventureindia" class="icon-twitter"></a>
            <a href="https://www.facebook.com/ventureintelligence" class="icon-fb"></a>
             <a href="https://plus.google.com/104062335450225242195" class="icon-gplues"></a>
             <a href="https://www.youtube.com/VentureIntelligence" class="you-tube"></a> </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <footer>
    <div class="footer-sec"> <span class="fl">© 2015 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
  </footer>
</div>
<script>
$(document).ready(function(){

        $('input[type=radio][value="1"]').prop('checked',true);

	$('.league-tab-col ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.league-tab-col ul.tabs li').removeClass('current');
		$('.league-tab-col .tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
                if(tab_id=='tab-1'){

                    $('input[type=radio][value="1"]').prop('checked',true);
                }
                else{

                    $('input[type=radio][value="3"]').prop('checked',true);
                }
	})

	/* Inner Tab 1 */
	$('.league-tab-col ul.stabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('.league-tab-col ul.stabs li').removeClass('current');
		$('.league-tab-col .stab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
                $('input[type=radio][value="1"]').prop('checked',true);
	})

	/* Inner Tab 2 */
	$('.league-tab-col ul.dtabs li').click(function(){

		var tab_id = $(this).attr('data-tab');

		$('.league-tab-col ul.dtabs li').removeClass('current');
		$('.league-tab-col .dtab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
                 $('input[type=radio][value="3"]').prop('checked',true);
	})

	/* Saerch Bar */
	$("#searchDIV a").click(function(){
		$('.search-bar').slideDown();
		$('#searchDIV a').fadeOut();
	})

	$(".down").click(function(){
		$('.search-bar').slideUp();
		$('#searchDIV a').fadeIn();
	})

         $('input[type=radio]').on('change', function() {

          if($(this).val()==1){

            //alert($(".league-tab-col .stab-content.current").attr('data-current'));
              if($(".league-tab-col .stab-content.current").attr('data-current')=='stab-1-2'){

                  $('#stab-1-2').removeClass('current');
                  $('#stab-1-1').addClass('current');
              }
              else if($(".league-tab-col .stab-content.current").attr('data-current')=='stab-2-2'){

                  $('#stab-2-2').removeClass('current');
                  $('#stab-2-1').addClass('current');
              }
          }
          else if($(this).val()==2){

                 //alert($(".league-tab-col .stab-content.current").attr('data-current'));
              if($('.league-tab-col .stab-content.current').attr('data-current')=='stab-1-1'){

                  $('#stab-1-1').removeClass('current');
                  $('#stab-1-2').addClass('current');
              }
              else if($(".league-tab-col .stab-content.current").attr('data-current')=='stab-2-1'){

                  $('#stab-2-1').removeClass('current');
                  $('#stab-2-2').addClass('current');
              }
          }
          else if($(this).val()==3){

                // alert($(".league-tab-col .dtab-content.current").attr('data-current'));
              if($('.league-tab-col .dtab-content.current').attr('data-current')=='dtab-1-2'){

                  $('#dtab-1-2').removeClass('current');
                  $('#dtab-1-1').addClass('current');
              }
              else if($(".league-tab-col .dtab-content.current").attr('data-current')=='dtab-2-2'){

                  $('#dtab-2-2').removeClass('current');
                  $('#dtab-2-1').addClass('current');
              }else{
                  $('#dtab-1-1').removeClass('current');
                  $('#dtab-2-2').addClass('current');
              }
          }
          else{
              //alert($(".league-tab-col .dtab-content.current").attr('data-current'));
              if($('.league-tab-col .dtab-content.current').attr('data-current')=='dtab-1-1'){

                  $('#dtab-1-1').removeClass('current');
                  $('#dtab-1-2').addClass('current');
              }
              else if($(".league-tab-col .dtab-content.current").attr('data-current')=='dtab-2-1'){

                  $('#dtab-2-1').removeClass('current');
                  $('#dtab-2-2').addClass('current');
              }
          }

    });

})
</script>
<script>

    $(document).ready(function() {
	 $(window).scroll(function(){
            if ($(this).scrollTop() > 100) {

                $('.header').addClass("opne-nav-fix");
              	$('img.fixed-logo').show();
				$('img.default').hide();

            } else {
                $('.header').removeClass("opne-nav-fix");
             $('img.default').show();
           $('img.fixed-logo').hide();

            }
        });

      var owl = $("#owl-demo");

      owl.owlCarousel({

      items : 2,
      itemsDesktop : [1000,2], //5 items between 1000px and 901px
      itemsDesktopSmall : [900,1], // betweem 900px and 601px
      itemsTablet: [600,1], //2 items between 600 and 0
      itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option

      });

      // Custom Navigation Events
      $(".next").click(function(){
        owl.trigger('owl.next');
      })
      $(".prev").click(function(){
        owl.trigger('owl.prev');
      })
      $(".play").click(function(){
        owl.trigger('owl.play',1000);
      })
      $(".stop").click(function(){
        owl.trigger('owl.stop');
      })




    });



    </script>
</body>
</html>
