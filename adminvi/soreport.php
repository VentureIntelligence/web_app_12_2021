<?php include_once("../globalconfig.php"); ?>
<?php

require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'reports' );
 session_save_path("/tmp");
session_start();
//print_r($_POST);
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    //echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];
    $logdate1 = $_POST['date1'];
    $logdate2 = $_POST['date2'];
    $fetech_by = $_POST['fetchby'];
    if(!isset($_POST['limit'])){
        
        $limit = 10;
    }else{
        
        $limit = $_POST['limit'];
    }
    if(!isset($_POST['type'])){
        
        $type = 1;
    }else{
        $type = $_POST['type'];
    }
    
    $stryear = strtotime('-1 year');
    $fromdate = date("Y-m-d",$stryear);
    $todaysdate=date("Y-m-d");
    
    //echo "<br>*******-".$logindate;
    if(($logdate1=="") || ($logdate2==""))
    {
        //	echo "<Br>empty dates";
        $querydate="";
        $allquerydate=" where DATE_FORMAT( search_date, '%Y-%m-%d' ) between '" . $fromdate. "' and '" . $todaysdate . "'";
        //	echo "<Br>All Query string- " .$allquerydate;
        //$allquerydate="" ;
    }
    else
    {
        $querydate=" and DATE_FORMAT( search_date, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
        $allquerydate=" where DATE_FORMAT( search_date, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
        //	echo "<Br>--All Query string- " .$allquerydate;
    }
    
        if($type==1){
            
            $soexportsql = "select * from search_operations $allquerydate  and PE=1 and substring_index(user_id, '@', -1)  NOT IN ('kutung.com') order by search_date desc LIMIT $limit";
            if ($search_optrs = mysql_query($soexportsql))
            {
                $soexport_cnt = mysql_num_rows($search_optrs);
            }
        }else{
        
            $soexportsql = "select * from search_operations $allquerydate  and CFS=1 and substring_index(user_id, '@', -1)  NOT IN ('kutung.com') order by search_date desc LIMIT $limit";
            if ($search_optrs = mysql_query($soexportsql))
            {
                $soexport_cnt = mysql_num_rows($search_optrs);
            }
        }
        
       
    //$dealcompanySql="SELECT substring_index(EmailId, '@', 1) domain, COUNT(*) email_count FROM dealLog where EmailId LIKE '%ventureintelligence.com%' and DATE_FORMAT( LoggedIn, '%Y-%m-%d') between '2017-07-09' and '2018-07-09' GROUP BY substring_index(EmailId, '@', 1) ORDER BY email_count desc limit 10";
    //$dealcompanySql="SELECT substring_index(EmailId, '@', 1) user, COUNT(*) user_count FROM dealLog where IpAdd LIKE '203.199.22.1' and DATE_FORMAT( LoggedIn, '%Y-%m-%d') between '2017-07-09' and '2018-07-09' GROUP BY substring_index(EmailId, '@', 1) ORDER BY user_count desc limit 10";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function findEmails()
{

    document.log.action="soreport.php";
    
    var e = document.getElementById("count");
    var strUser = e.options[e.selectedIndex].value;
    document.log.limit.value = strUser;
    
    document.log.submit();  
}
function orguserexport()
{
    document.export.action="orguserexport.php";
    document.export.submit();
}

</SCRIPT>
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">

</head>
<body class="overlay">
    <div class="loader-wrapper">
        <div class="loadersmall"></div>
    </div>

<div id="containerproductproducts">

<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">

	<div style="width:565px; float:left; padding-left:2px;">
            <div style=" width:565px;  margin-top:4px;">
                <div class="tab-header">
                    <span class="tab-title" data-id="org" data-value="1"><a href="userlog.php">Organizations</a></span>
                    <span class="tab-title" data-id="ipa" data-value="2"><a href="userbyip.php">IP Addresses</a></span>
                    <span class="tab-title" data-id="use" data-value="3"><a href="topusers.php">Users</a></span>
                    <span class="tab-title" data-id="act" data-value="4"><a href="active-inactive.php">Active/Inactive</a></span>
                    <span class="tab-title" data-id="las" data-value="5"><a href="lastlogin.php">Last Login</a></span>
                    <span class="tab-title link-active" data-id="sea" data-value="6"><a href="soreport.php">Site Search</a></span>
                    <span class="tab-title " data-id="udev" data-value="7"><a href="userdevices.php">Devices</a></span>
                </div>
                <div id="maintextpro" style="background-color: #ffffff;width:100%; min-height: 738px;">
                    <div id="headingtextpro">
                        <div class="filter-sec" style="/*border:0px !important;*/">
                            <form name="log" method="post" action="" id="log">
                                
                                <input type="hidden" name="fetchby" value="1">  
                                
                                <div class="ftype-wrapper">
                                    <span class="filter-label">Type</span>
                                <div class="f-type type-title">
                                        
                                    <div class="filter-value">
                                        <select name="type" id="type">
                                            <option value="1" <?php if($_POST['type']==1){  echo 'SELECTED'; } ?>>PE</option>
                                            <option value="2" <?php if($_POST['type']==2){  echo 'SELECTED'; } ?>>CFS</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                                
                                <div class="ftype-wrapper datepick">
                                     <span class="filter-label">From</span>
                                <div class="f-type datepick">

                                    <div class="filter-value">
                                        <input type="text" name="date1" value="<?php echo $logdate1 !='' ? $logdate1:$fromdate; ?>" size="15" placeholder="yyyy-mm-dd" id="fromdate">
                                    </div>
                                </div>
                                </div>

                                <div class="ftype-wrapper datepick">
                                     <span class="filter-label">To</span>
                                <div class="f-type datepick">

                                    <div class="filter-value">
                                        <input type="text" name="date2" value="<?php echo $logdate2 !='' ? $logdate2:$todaysdate; ?>" size="15" placeholder="yyyy-mm-dd" id="todate">
                                    </div>
                                </div>
                                </div>    
                                <div class="f-type filter-btn">
                                    <input type="hidden" name="fetchby" value="1">   
                                    <input type="hidden" name="limit" id="limit" value=""> 
                                    <span style="" class="one">
                                        <input type="button" value="Fetch" name="search" onclick="findEmails();">
                                    </span>
                                </div>
                                <?php if($soexport_cnt > 0){ ?>
                                <div class="f-type export-sec" onclick="orguserexport();">
                                    <span> <i>Export All</i>
                                        <input type="button" value="Export" name="soexport">
                                    </span>
                                </div>
                                <?php } ?>
                            </form>
                        </div> 
                        <form name="export"  method="post" action="" >                              
                            <input type="hidden" name="date1" value=<?php echo $logdate1 !='' ? $logdate1:$fromdate; ?>>
                            <input type="hidden" name="date2" value=<?php echo $logdate2 !='' ? $logdate2:$todaysdate; ?>>
                            <?php if($type==1){ ?>
                                
                                    <input type="hidden" name="fetchby" value="7">
                                <?php }else{ ?>
                                    
                                    <input type="hidden" name="fetchby" value="8">
                                <?php } ?>
                        </form>
                        
                        <div class="all-content" id="sea">
                                <div class="title-sec">
                                    <div>
                                        <select name="count" id="count" class="org-pe-count">
                                            <option value="10" <?php if($_POST['limit']==10){ echo 'SELECTED'; } ?>>10</option>
                                            <option value="20" <?php if($_POST['limit']==20){ echo 'SELECTED'; } ?>>20</option>
                                            <option value="30" <?php if($_POST['limit']==30){ echo 'SELECTED'; } ?>>30</option>
                                            <option value="40" <?php if($_POST['limit']==40){ echo 'SELECTED'; } ?>>40</option>
                                            <option value="50" <?php if($_POST['limit']==50){ echo 'SELECTED'; } ?>>50</option>
                                            <option value="100" <?php if($_POST['limit']==100){ echo 'SELECTED'; } ?>>100</option>
                                        </select>
                                    </div>
                                    <div>
                                        <span>User Email</span>
                                    </div>
                                    <div>
                                        <span>Keyword</span>
                                    </div>
                                    <div>
                                        <span>Result</span>
                                    </div>
                                    <div>
                                        <span>Date</span>
                                    </div>
                                    <div>
                                        <span>URL</span>
                                    </div>
                                </div>
                                
                                 <?php 
                                
                                if($type == 1){
                                    
                                    if ($soexport_cnt > 0)
                                    {
                                        $org=1; 
                                        While($myrow=mysql_fetch_array($search_optrs, MYSQL_BOTH))
                                        { 
                                        ?>
                                            <div class="content-sec">
                                                <div class="s-no"><span><?php echo $org; ?></span></div>
                                                <div class="ip-add"><span><?php echo $myrow['user_id']; ?></span></div>
                                                <div class="o-name"><span><?php echo $myrow['keyword_search']; ?></span></div>
                                                <div class="result"><span>
                                                   <?php     
                                                      if( $myrow['result_found'] ==1){
                                                          
                                                          echo 'Yes';
                                                      }else{
                                                          echo 'No';
                                                      
                                                      } 
                                                  ?>      
                                                    
                                                </span></div>
                                                <div class="date-login"><span><?php echo date('d-M-Y',strtotime($myrow['search_date'])); ?></span></div>
                                                <?php if($myrow['search_url']!=''){ ?>
                                                    <div class="det-link"><span><a href="<?php echo $myrow['search_url']; ?>" title="<?php echo $myrow['search_url']; ?>" target="_blank">Go</a></span></div>
                                                <?php } ?>

                                            </div>
                                               
                                 <?php
                                                $org++;
                                            }

                                        }else{ 

                                            echo '<div class="content-sec notdata"> No data found.</div>';
                                        }
                                }else{
                                    
                                    if ($soexport_cnt > 0)
                                    {
                                        $org=1; 
                                        While($myrow=mysql_fetch_array($search_optrs, MYSQL_BOTH))
                                        { 
                                        ?>
                                
                                            <div class="content-sec">
                                                <div class="s-no"><span><?php echo $org; ?></span></div>
                                                <div class="ip-add"><span><?php echo $myrow['user_id']; ?></span></div>
                                                <div class="o-name"><span><?php echo $myrow['keyword_search']; ?></span></div>
                                                <div class="result"><span>
                                                   <?php     
                                                      if( $myrow['result_found'] ==1){
                                                          
                                                          echo 'Yes';
                                                      }else{
                                                          echo 'No';
                                                      
                                                      } 
                                                  ?>      
                                                    
                                                </span></div>
                                                <div class="date-login"><span><?php echo date('d-M-Y',strtotime($myrow['search_date'])); ?></span></div>
                                                <?php if($myrow['search_url']!=''){ ?>
                                                    <div class="det-link"><span><a href="<?php echo $myrow['search_url']; ?>" title="<?php echo $myrow['search_url']; ?>" target="_blank">Go</a></span></div>
                                                <?php } ?>

                                            </div>
                                
                                <?php
                                                $org++;
                                            }

                                        }else{ 

                                            echo '<div class="content-sec notdata"> No data found.</div>';
                                        }
                                        
                                }
                            ?>
                            </div>
                       
                    
                   
                <script type="text/javascript">
                    $(function(){
                         
                        $('.loader-wrapper').hide();
                        $("body").removeClass("overlay");
                        
                        $(document).on('click', '.ip-link', function() {
                            
                             $( '#ipaddress' ).val($( this ).attr('data-ip'));
                             $( '#ipdetails' ).submit();
                         });

                       /* if($('option:selected','#type').attr('value')==1){
                            $('.datepick').show();
                        }else{
                            $('.datepick').hide();
                        }*/

                        $(document).on('change', '.org-pe-count', function() {

                            $('#limit').val($('option:selected',this).attr('value'));
                            $('#log').submit();
                        });
                            
                       /* $(document).on('change', '#type', function() {

                            if($('option:selected',this).attr('value')==1){
                                $('.datepick').show();
                            }else{
                                $('.datepick').hide();
                            }


                        });*/
    
                        
                             
                        $(".all-content#org").addClass("active");
                        //$(".tab-title:first-child").addClass("link-active");

                        $(".tab-title").on('click', function(){

                            //alert($(this).attr("data-value"));
                            if($(this).attr("data-value")==2){
                                //$("#type").prop("disabled", true);
                                $(".datepick").hide();
                                $(".type-title").hide();
                                $(".filter-btn").hide();
                                $(".pe-section").css('margin-top','50px');
                                
                            }else{
                                //$("#type").prop("disabled", false);
                                $(".datepick .type-title .filter-btn").show();
                            }
                            
                            $(".tab-title").removeClass("link-active");
                            $(this).addClass("link-active");
                            var link = $(this).attr("data-id");//fetchby
                            $(".all-content").removeClass("active");
                            $(".all-content#"+link).addClass("active");
                        });
                           
                           
                        $('.content-sec .expand-icon').on("click", function(){
                             $(this).closest(".content-sec").toggleClass("tab-open");
                        });

                        $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
                        $( "#fromdate2" ).datepicker({ dateFormat: 'yy-mm-dd' });
                        $( "#todate" ).datepicker({ dateFormat: 'yy-mm-dd' });
                })
        </script>
           
                    
	</div><!-- end of headingtextpro-->
                
            </div> <!-- end of maintext pro-->
            
	  </div>
	</div>
  
  </div>

  

    <div class="bottom-section">
        <div style="padding-top: 10px;height: 25px;font-size: 11px;margin-left: 0px;padding-left: 25px; width: 75%; float: left;">
            <span><a href="../index.htm">Home</a> I <a href="../products.htm">Products</a> I </span>
            <span><a href="../events.htm">Events</a> I<a href="../investors.htm"> Investors</a> I </span>
            <span><a href="../entrepreneurs.htm">Entrepreneurs</a> I <a href="../serviceproviders.htm">Service Providers</a> I  </span>
            <span><a  href="../news.htm">News</a> I <a href="../aboutus.htm">About Us</a> I</span>
            <span><a href="../contactus.htm"> Contact Us</a>	</span>
        </div>
        <div id="copyright">© TSJ Media Pvt. Ltd</div>
    </div>

  
  </div>
  <!-- Ending Work Area -->


<!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>-->

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>
   
<script>
    
    
    $(document).ready(function(){
       
        $(".org-section").click(function () {
            
            //alert('#org-user-section'+$(this).data("org"));
           if($('#org-user-section'+$(this).data("org")).is(':visible')){
               $('#org-user-section'+$(this).data("org")).toggle();
               $('.plus').html("+");
                $('.plus').css("border-color", "#4b8d4f");
               
           }else{
               
                $('.users-sec').css("display", "none");
                $('.plus').html("+");
                $('.plus').css("border-color", "#4b8d4f");
                $('#plus'+$(this).data("org")).html("-");
                $('#plus'+$(this).data("org")).css("border-color", "#f40909");
                $('#org-user-section'+$(this).data("org")).toggle();
           }
           
        });
        
        $(".ip-section").click(function () {
            
            if($('#ip-user-section'+$(this).data("ip")).is(':visible')){
               $('#ip-user-section'+$(this).data("ip")).toggle();
               $('.plus').html("+");
                $('.plus').css("border-color", "#4b8d4f");
               
           }else{
               
                $('.users-sec').css("display", "none");
                $('.plus').html("+");
                $('.plus').css("border-color", "#4b8d4f");
                $('#plusip'+$(this).data("ip")).html("-");
                $('#plusip'+$(this).data("ip")).css("border-color", "#f40909");
                $('#ip-user-section'+$(this).data("ip")).toggle();
           }
           
        });
        
        $(".cfs-org-section").click(function () {
            
            //alert('#org-user-section'+$(this).data("org"));
            
           if($('#cfsorg-user-section'+$(this).data("cfsorg")).is(':visible')){
               $('#cfsorg-user-section'+$(this).data("cfsorg")).toggle();
               $('.cfsplus').html("+");
                $('.cfsplus').css("border-color", "#4b8d4f");
               
           }else{
               
                $('.cfs-users-sec').css("display", "none");
                $('.cfsplus').html("+");
                $('.cfsplus').css("border-color", "#4b8d4f");
                $('#cfsplus'+$(this).data("cfsorg")).html("-");
                $('#cfsplus'+$(this).data("cfsorg")).css("border-color", "#f40909");
                $('#cfsorg-user-section'+$(this).data("cfsorg")).toggle();
           }
           
        });
        
        $('input[type=radio][name=report]').change(function() {
            
            if (this.value == 1) {
                
                $('.filter-sec').show();
                $('.pe-section').show();
                $('.cfs-section').hide();
                
            }
            else if (this.value == 2) {
                
                $('.filter-sec').hide();
                $('.pe-section').hide();
                $('.cfs-section').show();
            }
        });

    });
</script>
</body>
</html>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;












/*include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
require("../dbconnectvi.php");
$Db = new dbInvestments();
 //session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    $currentyear = date("Y");
    $noresult = "";
    
    if($_POST){
    $monthtoAdd=$_POST['month1'];
    $yeartoAdd=$_POST['year1'];
    $fromDate=returnDate($monthtoAdd,$yeartoAdd);
    
    $monthtoAdd2=$_POST['month2'];
    $yeartoAdd2=$_POST['year2'];
    $toDate=returnDate($monthtoAdd2,$yeartoAdd2);
    
    $soexportsql = "select * from search_operations where search_date >= '".$fromDate."' and search_date <= '".$toDate."'";

    if ($rssearchexport = mysql_query($soexportsql))
    {
        if(mysql_num_rows($rssearchexport) > 0){
            
            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true)->setFitToWidth(TRUE);

            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            $style_right = array(
            'borders' => array(
              'right' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            $style_bottom = array(
            'borders' => array(
              'bottom' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
        
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("Search Report \n")->getFont()->setSize(15)->setBold(TRUE);
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->mergeCells('A1:H1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center')->setVertical('top');
            // border
            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->applyFromArray($styleArrayBorder);
            $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray($styleArrayBorder);  

            $objPHPExcel->getActiveSheet()->setCellValue('A2','User ID');
            $objPHPExcel->getActiveSheet()->setCellValue('B2','User Name');
            $objPHPExcel->getActiveSheet()->setCellValue('C2','Keyword Search');
            $objPHPExcel->getActiveSheet()->setCellValue('D2','PE');
            $objPHPExcel->getActiveSheet()->setCellValue('E2','CFS');
            $objPHPExcel->getActiveSheet()->setCellValue('F2','Search Date');
            $objPHPExcel->getActiveSheet()->setCellValue('G2','Search URL');
            $objPHPExcel->getActiveSheet()->setCellValue('H2','Result Found');

            $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold(TRUE)
                     ->getActiveSheet()->getStyle('A2:H2')->getAlignment()->setHorizontal('center');

            $sno = 3;
            While($myrow=mysql_fetch_array($rssearchexport, MYSQL_BOTH))
            {
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $myrow[1]);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow[2]);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow[3]);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, $myrow[5])->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical('top');
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, $myrow[6])->getStyle('E'.$sno)->getAlignment()->setHorizontal('center')->setVertical('top');
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$sno, $myrow[7])->getStyle('F'.$sno)->getAlignment()->setHorizontal('center')->setVertical('top');
                $objPHPExcel->getActiveSheet()->setCellValue('G'.$sno, $myrow[8]);
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$sno, $myrow[4])->getStyle('H'.$sno)->getAlignment()->setHorizontal('center')->setVertical('top');

                $objPHPExcel->getActiveSheet()->getStyle('H'.$sno)->applyFromArray($style_right);


                $sno++;
            }
             $objPHPExcel->getActiveSheet()->getStyle('A'.($sno-1).':H'.($sno-1))->applyFromArray($style_bottom);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("40");
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);

            $objPHPExcel->getActiveSheet()->setTitle('Search_Report');

            $objPHPExcel->setActiveSheetIndex(0);

            ob_end_clean();
            $filename='Search_Report.xlsx'; 
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public');
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
            $objWriter->save('php://output');
             
            
        }else{
            $noresult = '<div style="padding:10px 10px 10px 10px;color:red;text-align: center;">No Result Found</div>';
        }
    }else{
       die("Error in connection:<br>");
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Venture Intelligence</title>
    <SCRIPT LANGUAGE="JavaScript">
    function getsoexport()
    {
            document.soreportinput.submit();
    }

    </SCRIPT>

    <link href="../css/vistyle.css" rel="stylesheet" type="text/css">
    </head>
    <body>
<form name="soreportinput" method="post" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">

		<div id="vertMenu">
		        	<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
		      	</div>
		      	<div id="linksnone"><a href="dealsinput.php">Investment Deals</a> |  <a href="companyinput.php">Profiles</a><br />

		         <!-- <a href="investorinput.php">Investor Profile</a><br /> -->
				</div>


		<div id="vertMenu">
				<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
			</div>
			<div id="linksnone">
			<a href="pegetdatainput.php">Deals / Profile</a><br />
                        <a href="peadd.php">Add PE Inv </a> |  <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a> |

			<A href="peadd_RE.php"> RE Inv</a> | <A href="reipoadd.php"> RE-IPO</a> | <A href="remandaadd.php"> RE-M&A</a><br /> | <a href="remamaadd.php">RE-MA </a> |
		</div>
                <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
                </div>
                <div id="linksnone">
                    <a href="admin.php">Subscriber List</a><br />
                    <a href="addcompany.php">Add Subscriber / Members</a><br />
                    <a href="delcompanylist.php">List of Deleted Companies</a><br />
                    <a href="delmemberlist.php">List of Deleted Emails</a><br />
                    <a href="deallog.php">Log</a><br />

                </div>
				
                <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Admin Report</span></div>
                </div>
                <div id="linksnone">
                        <a href="viewlist.php">View Report</a><br />
                        <a href="addlist.php">Add Report</a><br />
		</div>
                <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Fund Raising</span></div>
                </div>
                <div id="linksnone">
                    <a href="fundlist.php">View Funds</a><br />
                    <a href="addfund.php">Add Fund</a><br />
		</div>
                <div id="vertMenu">
                <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Upload Deals</span></div>
                </div>
                <div id="linksnone">
                    <a href="uploaddeals.php">Upload</a><br />
                </div>
                <div id="vertMenu">
                <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Reports</span></div>
                </div>
                <div id="linksnone">
                     <a href="soreport.php">Search Operation Report</a><br />
                    <a href="userreports.php">User Login Reports</a><br />
                </div>
                <div id="vertMenu">
                    <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
                </div>
                <div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
 <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:687px; margin-top:4px;">
	    <div id="maintextpro">
                
        <div id="headingtextpro" style="border: 2px solid #806230;margin: 65px 0px 0px 20px;">
            <?php echo $noresult; ?>
         <div id="headingtextproboldfontcolor" style="padding: 30px 4px 30px 55px;">Period
	   		<img src="../images/arrow.gif" style="padding: 0px 20px 0px 5px;"/>
                            <SELECT NAME=month1>
	   			 <OPTION id=1 value="--" > Month </option>
	   			 <OPTION VALUE=1 selected>Jan</OPTION>
	   			 <OPTION VALUE=2>Feb</OPTION>
	   			 <OPTION VALUE=3>Mar</OPTION>
	   			 <OPTION VALUE=4>Apr</OPTION>
	   			 <OPTION VALUE=5>May</OPTION>
	   			 <OPTION VALUE=6>Jun</OPTION>
	   			 <OPTION VALUE=7>Jul</OPTION>
	   			 <OPTION VALUE=8>Aug</OPTION>
	   			 <OPTION VALUE=9>Sep</OPTION>
	   			 <OPTION VALUE=10>Oct</OPTION>
	   			 <OPTION VALUE=11>Nov</OPTION>
	   			<OPTION VALUE=12>Dec</OPTION>
	   			</SELECT>
	   				<SELECT NAME=year1>
	   				<OPTION id=2 value="--" > Year </option>
	   				<?php

	   				$i=1998;
	   				While($i<= $currentyear )
					{
						$id = $i;
						$name = $i;
						if ($id==$currentyear)
						{
							echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
						}
						else
						{
							echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
						}
						$i++;
					}
	   				?> </SELECT>
	   			<SELECT NAME=month2>
	   			 <OPTION id=3 value="--" > Month </option>
	   			 <OPTION VALUE=1>Jan</OPTION>
	   			 <OPTION VALUE=2>Feb</OPTION>
	   			 <OPTION VALUE=3>Mar</OPTION>
	   			 <OPTION VALUE=4>Apr</OPTION>
	   			 <OPTION VALUE=5>May</OPTION>
	   			 <OPTION VALUE=6>Jun</OPTION>
	   			 <OPTION VALUE=7>Jul</OPTION>
	   			 <OPTION VALUE=8>Aug</OPTION>
	   			 <OPTION VALUE=9>Sep</OPTION>
	   			 <OPTION VALUE=10>Oct</OPTION>
	   			 <OPTION VALUE=11>Nov</OPTION>
	   			 <OPTION VALUE=12 selected>Dec</OPTION>
	   			</SELECT>
	   			<SELECT name=year2     style="margin-right: 10px;">
	   			<OPTION id=4 value="--" > Year </option>

	   			<?php
	   			$endYear=1998;
	   			While($endYear<= $currentyear )
				{
					$ids=$endYear;
					if($ids==$currentyear)
					{
						echo "<OPTION id=". $endYear. "value=". $endYear." selected>".$endYear."</OPTION>\n";
					}
					else
					{
						echo "<OPTION id=". $endYear. "value=". $endYear." >".$endYear."</OPTION>\n";
					}

				$endYear++;
				}
	   			?> </SELECT>
                                <input type="button" value="Export" name="soexport" onClick="getsoexport();" style="padding: 3px 3px 3px 3px;">
			</div> 
                        



		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   </form>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

</body>
</html>
<?php

} // if resgistered loop ends
else{
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
}

function returnDate($mth,$yr)
{
	//this function returns the date

	$fulldate= $yr ."-" .$mth ."-01";
	if (checkdate (01,$mth, $yr))
	{
		return $fulldate;
	}
}*/
?>