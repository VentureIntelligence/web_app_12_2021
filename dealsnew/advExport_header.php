<?php include_once("../globalconfig.php"); ?>
<?php
   // session_start();
   require("../dbconnectvi.php");
   $Db = new dbInvestments();
   include_once 'checklogin.php';
   
   $dlogUserEmail = $_SESSION['UserEmail'];
   $username=$_SESSION['UserNames'];
   //echo $dlogUserEmail;
   //$username= $_SESSION[ 'name' ];	
   
   $sqlQuery="SELECT dc.DCompanyName as companyName,dc.custom_export_limit as expplimit FROM dealmembers dm INNER JOIN dealcompanies dc on dc.DCompId=dm.DCompId WHERE EmailId='$dlogUserEmail' ";   
   $sqlSelResult = mysql_query($sqlQuery) or die(mysql_error());
   while ($row = mysql_fetch_assoc($sqlSelResult)) {
   
   $custom_export_limit= $row['expplimit']  ;
   $companyName=$row['companyName'];
   
   }
   
   $query="SELECT COUNT(name) as count FROM `advance_export_filter_log` where name='$username' ";
   $queryRes = mysql_query($query) or die(mysql_error());
   while ($row = mysql_fetch_assoc($queryRes)) {
   
   $DownloadCount= $row['count']  ;
   
   }
 // echo $DownloadCount;
   
   ?>
<?php
   if(!$_POST)
   {
   $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
   
   $year1 = date('Y', strtotime(date('Y') . " -1  Year"));
   $month1='01';
   $month2=date('m');
   $dt1 = $year1.'-'.$month1.'-01';
   $dt2 = $year2.'-'.$month2.'-31';
   }
   else{
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
   ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
      <title>Private Equity Deal Database</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
      <link href="css/skin_1.css" rel="stylesheet" type="text/css" />
      <link href="css/popstyle.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" type="text/css" href="css/detect800.css" />
      <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>  
      <!-- <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script> -->
      <link rel="stylesheet" type="text/css" href="css/token-input.css" />
      <link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
      <!--<script type="text/javascript" src="js/jquery.tablesorter.js"></script>-->
      <script type="text/javascript" src="js/popup.js"></script>
      <link href="hopscotch.min.css" rel="stylesheet">
      </link>
      <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
      <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
      <!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
      <!--script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script-->
      <script src="js/jquery.table2excel.js"></script>
      <script type="text/javascript" src="js/jquery.multiselect.js"></script> 
      <script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
      <link rel="stylesheet" type="text/css" href="css/jquery.multiselect.filter.css" />
      <script type="text/javascript" src="js/jquery.multiselect.filter.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <div class="B">
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <link rel="stylesheet" href="filter.css">
      <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         
         gtag('config', 'UA-168374697-1');
      </script>
      <script type="text/javascript" src="js/expand.js"></script>
      <script src="js/showHide.js" type="text/javascript"></script>
      <script src="js/jquery.flexslider.js"></script>
      <script src="js/jquery.masonry.min.js"></script>
      <!--  <script src="js/switch.min.js" type="text/javascript"></script>-->
      <!-- <link href="css/switch.css" type="text/css" rel="stylesheet">-->
      <?php if($tour!='Allow'){ ?>
      <script src="TourStart.js"></script> 
      <?php } ?>
      <style type="text/css">
         dl, ol, ul {
         margin-top: 0!important;
         margin-bottom: 0!important;
         }
         .sidebar {
         height: 100%; /* 100% Full-height */
         width: 0px; /* 0 width - change this with JavaScript */
         position: absolute; /* Stay in place */
         z-index: 9999; /* Stay on top */
         top: -100px;
         left: 0;
         background-color: #e5e1d5; /* Black*/
         overflow-x: hidden; /* Disable horizontal scroll */
         padding-top: 60px; /* Place content 60px from the top */
         transition: 0.5s; /* 0.5 second transition effect to slide in the sidebar */
         border-top: 2px solid grey;
         }
         /* The sidebar links */
         .sidebar a {
         padding: 8px 8px 8px 32px;
         text-decoration: none;
         font-size: 25px;
         color: #818181;
         display: block;
         transition: 0.3s;
         /* 100% Full-height */
         }
         /* When you mouse over the navigation links, change their color */
         .sidebar a:hover {
         color: #f1f1f1;
         }
         /* Position and style the close button (top right corner) */
         .sidebar .closebtn {
         position: absolute;
         top: -8px;
         right: 25px;
         font-size: 36px;
         margin-left: 50px;
         }
         /* The button used to open the sidebar */
         .openbtn {
         font-size: 20px;
         cursor: pointer;
         background-color: #111;
         color: white;
         padding: 10px 15px;
         border: none;
         }
         .openbtn:hover {
         background-color: #444;
         }
         /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
         #savefiltersbt {
         transition: margin-left .5s; /* If you want a transition effect */
         padding: 20px;
         }
         /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
         @media screen and (max-height: 450px) {
         .sidebar {padding-top: 15px;}
         .sidebar a {font-size: 18px;}
         }
         .highlight{
         background-color:  grey;
         color: white;
         border: 2px solid grey;
         }
         .btnvalType{
         background-color: white;
         color: black;
         border: 2px solid grey;
         }
         .token-input-list-facebook{
         border-radius: 5px;
         width: 40%;
         }
         ul.token-input-list-facebook {
         width:100%;
         min-height: 34px !important;
         z-index: 1;
         }
         ul.token-input-list-facebook{width:100% !important;border:none !important;}
            ul.token-input-list-facebook li input{
            margin: 5px 0 !important;
            }
            li.token-input-token-facebook{
            margin: 6px 3px !important;
            }
         ul.exportcolumn {
         -webkit-column-count: 4;
         -moz-column-count: 4;
         column-count: 4;
         font-size:12px;
         color: #414141d6;
         }
         .exportcolumn li,.copyright-body label{
         line-height:32px;
         }
         ul.exitexportcolumn {
         -webkit-column-count: 4;
         -moz-column-count: 4;
         column-count: 4;
         font-size:12px;
         color: #414141d6;
    
         }
         .exitexportcolumn li,.copyright-body label{
         line-height:32px;
         }
         #investorauto_sug{
         width: 50%;
         border-radius: 20px;
         height: 30px;
         border: 1px solid gray;
         }
         /* #filter_name{
         width: 50%;
         border-radius: 5px;
         height: 30px;
         border: 1px solid gray;
         } */
         .token-input-dropdown-facebook {
            width: 27.5% !important;
            }
         #preloading {
         background:url(images/linked-in.gif) no-repeat center center;
         height: 100px;
         width: 100px;
         position: fixed;
         left: 50%;
         top: 50%;
         margin: -25px 0 0 -25px;
         z-index: 1000;
         }
         #maskscreen
         {
         position: fixed;
         left: 0;
         top: 0;
         background: #000;
         z-index: 8000;
         overflow: hidden;
         }
         .exit-form h3{
         opacity: 0.5;
         }
         .exit-form h3:hover{
         opacity: 1;
         }
         .export_newExcel{
         border-radius: 15px;
         width: 120%;
         text-align: center;
         background: #413529;
         }
         .filter_newExcel{
         border-radius: 15px;
         width: 120%;
         text-align: center;
         background: #413529;
         }
         .btnval{
         background-color: grey;
         border-radius: 10px;
         width: 18%;
         }
         body{
         margin:0;
         padding:0;
         width:100%;
         height:100%;
         /* overflow-x:hidden; */
         }
         .footer{
         position:absolute;
         /* bottom:0; */
         /* left: -5%; */
         }
         .list-group .active {
         background-color: #a2753a;
         border-color: #a2753a;
         }
         h6{
         font-weight: bold!important;
         }
         .btn-circle{
         border-radius: 5px!important;
         }
         .btn-color{
         border-color: rgb(163,119,46)!important;
         background-color: rgb(163,119,46)!important;
         color:white!important;
         }
         .error
         {
         color:red;
         font-size: 12px;
         margin-left: 5px;
         }
         .hide{
         display: none
         }
         .period-date select {
         /* width: 85px!important;
         font-size: 14px!important;; */
         width: 60px!important;
         font-size: 14px!important;
         padding: 0px 2px !important;
         }
         li.token-input-token-facebook
         {
            border: 1px solid #a2753a!important;
            background-color: #a2753a!important;
            color: white!important;
         }
         li.token-input-token-facebook span {
                color: white!important;
         }
         #header
         {
            border-bottom: 1px solid white!important;
         }
         .dropdown{
position:fixed !important;
}
.dropdown-menu{
display: initial !important;
position:relative !important;
margin-top: 13px !important;
border-radius:0rem !important;
padding:0rem !important;
}
      </style>
   </head>
   <?php if($_SESSION['PE_TrialLogin']==1){ ?>
   <body >
      <?php }else { ?>
      <!-- <body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> -->
      <?php } ?>
      <div id="maskscreen" ></div>
      <div id="preloading"></div>
      <div id="preloadingInv"></div>
      <script type="text/javascript" >
         $('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
         jQuery(window).load(function(){
         jQuery('#preloading').fadeOut(1000);
         jQuery('#maskscreen').fadeOut(1000);
         });
      </script>
      <!-- <?php include_once('definitions.php');?>
         <?php include_once('refinedef.php');?> -->
      <!--Header-->
      <!-- <?php if($vcflagValue=="0" || $vcflagValue=="1" || $vcflagValue=="2")
         {
         $actionlink="index.php?value=".$vcflagValue;
         }
         else 
         {
         $actionlink="svindex.php?value=".$vcflagValue;
         }
         ?> -->
      <div id="header">
         <table cellpadding="0" cellspacing="0">
            <tr>
               <td class="left-box">
                  <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div>
               </td>
               <td class="right-box">
                  <?php include('top_export_submenu.php'); ?>
                  <ul class="fr">
                     <!-- <li class="classic-btn tour-lock"><a href="pefaq.php" id="faq-btn" style="opacity: 1;">FAQ</a></li> -->
                     <!--    <li class="classic-btn tour-lock"><a href="http://www.ventureintelligence.com/deals/dealhome.php" >Classic View</a></li>-->
                     <?php //include('TourStartbtn.php'); ?>
                     <!-- <li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" id="searchallfield" name="searchallfield" placeholder="Search"
                        value="<?php if($searchallfield!="") echo $searchallfield; ?>" style="padding:5px;"  /> 
                        <input type="button" name="fliter_stage" id="fliter_stage" value="Go" style="padding: 5px;"/>
                        </div></li> -->
                     <input type="hidden" value="remove" name="searchallfieldHide" id="searchallfieldHide" />
                     <?php if($_SESSION['student']!="1") { ?>   
                     <li class="user-avt" id="accoutlist"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
                        <?php } 
                           else {
                           ?>       
                     <li class="user-avt">
                        <span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
                        <?php    
                           }?>
                        <div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
                           <ul class="dropdown-menu">
                              <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                              <li class="o_link"><a href="../malogin.php" target="_blank">M&A Deals Database</a></li>
                              <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                              <li><a href="changepassword.php?value=P">Change Password</a></li>
                              <li id="logout"><a href="logoff.php?value=P">Logout</a></li>
                           </ul>
                        </div>
                     </li>
                  </ul>
               </td>
            </tr>
         </table>
      </div>
      <!--</form>
         <form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">  -->
      <div id="sec-header" class="sec-header-fix dealsindex">
         <ul class="navbar navbar-expand-sm  navbar-dark navigation">
            <span class="navbar-brand dashboard">Dashboard >Advanced Filters</span>
            <div class="button-group text-right  ml-auto">
               <button class="btn  advanced" href="#">Advanced Filters</button>
               <button class="btn  advanced " href="#" style="opacity:0.5">Trends Reports</button>
            </div>
         </ul>
      </div>
      <div class="container-fluid"  id="container" style="margin-top: 110px;">
      <div class="row ">
         <div class="col-md-4 mb-2" style="padding-right:0px">
            <div class="card cardfilter">
               <div class="card-header myfilter" style="height:45px">
                  <h4 class="text-center h4 mt-1">My Filters</h4>
               </div>
                         
            </div>
            <div class="card navCard">
                              <div class="container">
               <div class="nav nav-pills myfilters mt-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link col-6 active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-investmentsfilter" role="tab" aria-controls="v-pills-home" aria-selected="true" value=Investments >Investments Filters</a>
                  <a class="nav-link col-6" id="v-pills-profiletab" data-toggle="pill" href="#v-pills-exitfilters" role="tab" aria-controls="v-pills-profile" aria-selected="false" value=Exit >Exit Filters</a>
               </div>
                        </div>
               <div class="tab-content" id="v-pills-tabContent">
                  <?php
                     $keyword="";
                     $keyword=$_POST['repDBtype'];
                     
                     $nanoSql="SELECT * FROM `saved_filter` where vi_filter=0 and filter_type='Investments'";
                     if ($reportrs = mysql_query($nanoSql))
                     {
                     $report_cnt = mysql_num_rows($reportrs);
                     }
                     
                     ?> 
                  <div class="tab-pane fade show active" id="v-pills-investmentsfilter" role="tabpanel" aria-labelledby="v-pills-home-tab" >
                     <?php
                        if ($report_cnt>0)
                        {
                        While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                        {	
                        if($myrow['filter_type'] == "Investments"){
                        ?> 
                     <div class="card invest">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-10 col-10">
                                 <h6 class="card-title q4"><?php echo $myrow['filter_name'] ?></h6>
                                 <p class="redesign"><?php echo $myrow['filter_desc'] ?></p>
                                 <p class="create">Created on <?php echo date('d M y', strtotime($myrow['created_on']));?></p>
                              </div>
                              <div class="col-md-2 col-2">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteFilter('<?php echo $myrow['id'] ?>')">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                           </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                           <button type="button" class="btn edit w-100 text-center" onclick="EditFilter('<?php echo $myrow['id'] ?>')">EDIT</button>
                           <?php if($DownloadCount  >=  $custom_export_limit){?>
                           <button type="button" class="btn exportFilt w-100 text-center"  onclick="exportfiltrErr(<?php echo $custom_export_limit ?>)">EXPORT</button>
                           <?php }
                              else {?>
                           <button type="button" class="btn exportFilt w-100 text-center" onclick="exportfiltr(1,'<?php echo $myrow['filter_type'] ?>','<?php echo $myrow['id'] ?>','<?php echo $myrow['filter_name'] ?>')">EXPORT</button>
                           <?php } ?>
                        </div>
                     </div>
                     <?php
                        } } }
                        else {?>
                     <div class="card data">
                        <div class="card-body" style="text-align: center;font-size:12px;color:black">
                           No Data Found
                        </div>
                     </div>
                     <?php } ?>
                  </div>
                  <?php
                     $keyword="";
                     $keyword=$_POST['repDBtype'];
                     
                     $nanoSql="SELECT * FROM `saved_filter` where vi_filter=0 and filter_type='Exit'";
                     if ($reportrs = mysql_query($nanoSql))
                     {
                     $report_cnt = mysql_num_rows($reportrs);
                     }
                     ?> 
                  <div class="tab-pane fade show " id="v-pills-exitfilters" role="tabpanel" aria-labelledby="v-pills-profile-tab" >
                     <?php
                        if ($report_cnt>0)
                        {
                        While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                        {	
                        if($myrow['filter_type'] == "Exit"){
                        ?> 
                     <div class="card invest">
                        <div class="card-body">
                           <div class="row">
                              <div class="col-md-10 col-10">
                                 <h6 class="card-title q4"><?php echo $myrow['filter_name'] ?></h6>
                                 <p class="redesign"><?php echo $myrow['filter_desc'] ?></p>
                                 <p class="create">Created on <?php echo date('d M y', strtotime($myrow['created_on']));?></p>
                              </div>
                              <div class="col-md-2 col-2">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="deleteFilter('<?php echo $myrow['id'] ?>')">
                                 <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                           </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="Basic example">
                           <button type="button" class="btn edit w-100 text-center" onclick="EditFilter('<?php echo $myrow['id'] ?>')">EDIT</button>
                           <?php if($DownloadCount  >=  $custom_export_limit){?>
                           <button type="button" class="btn exportFilt w-100  text-center"  onclick="exportfiltrErr(<?php echo $custom_export_limit ?>)">EXPORT</button>
                           <?php }
                              else {?>
                           <button type="button" class="btn exportFilt w-100 text-center" onclick="exportfiltr(1,'<?php echo $myrow['filter_type'] ?>','<?php echo $myrow['id'] ?>','<?php echo $myrow['filter_name'] ?>')">EXPORT</button>
                           <?php } ?>
                        </div>
                     </div>
                     <?php
                        } } }
                        else {?>
                     <div class="card data">
                        <div class="card-body" style="text-align: center;font-size:12px;color:black">
                           No Data Found
                        </div>
                     </div>
                     <?php } ?>  
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-8 mb-2" style="    padding-left: 0px;">
            <div class="nav rightpanel nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="height:45px">
               <a class="filter ml-3 active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-vifilters" role="tab" aria-controls="v-pills-home" aria-selected="true" value=ViFilter>VI Filters</a>
               <a class="filter ml-1" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-investment" role="tab" aria-controls="v-pills-profile" aria-selected="false" value=Investments>Investments</a>
               <a class="filter ml-1" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-exits" role="tab" aria-controls="v-pills-messages" aria-selected="false" value=Exit>Exits</a>
               <!-- <a class="btn btn-primary  ml-1" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a> -->
            </div>
            <div class="tab-content" id="v-pills-tabContent">
               <?php
                  $keyword="";
                  $keyword=$_POST['repDBtype'];
                  
                  $nanoSql="SELECT * FROM `saved_filter` where vi_filter=1 and filter_active='active' ORDER BY filter_order_no ASC";
                  if ($reportrs = mysql_query($nanoSql))
                  {
                  $report_cnt = mysql_num_rows($reportrs);
                  }
                  ?> 
               <div class="tab-pane ml-3 fade show active" id="v-pills-vifilters" role="tabpanel" aria-labelledby="v-pills-home-tab">
                  <div class="card">
                     <div class="row mt-2">
                        <?php
                           if ($report_cnt>0)
                           {
                           While($myrow=mysql_fetch_array($reportrs, MYSQL_BOTH))
                           {	
                           ?> 
                        <div class="col-md-6 mb-3">
                           <div class="card invest viadmin">
                              <div class="card-body ">
                                 <div class="row ">
                                    <div class="col-md-10 col-10">
                                       <h6 class="card-title q4"><?php echo $myrow['filter_name'] ?></h6>
                                       <p class="redesign"><?php echo $myrow['filter_desc'] ?></p>
                                       <p class="create">Created on <?php echo date('d M y', strtotime($myrow['created_on']));?></p>
                                    </div>
                                    <!-- <div class="col-md-2 col-2">
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                       </button>
                                    </div> -->
                                 </div>
                              </div>
                              <!-- <div class="card-footer edit"> -->
                              <?php if($DownloadCount  >=  $custom_export_limit){?>
                                 <button  class ="btn exportFilt w-100 text-center" onclick="exportfiltrErr(<?php echo $custom_export_limit ?>)" name="showdeals">Export</button>
                            <?php }
                              else {?>
                                 <button type="button" class="btn exportFilt w-100 text-center" onclick="ExportAdminFilter('<?php echo $myrow['id'] ?>','<?php echo $myrow['filter_name'] ?>','<?php echo $myrow['filter_type'] ?>')">Export</button>
                           <?php } ?>
                              <!-- <h5 class="text-center ">Export</h5> -->
                              <!-- </div> -->
                           </div>
                        </div>
                        <?php
                           } }
                           else {?>
                        <p class="data" style="margin-left:350px;font-size:12px;color:black;padding-top:200px">No Data Found</p>
                        <?php } ?>       
                     </div>
                  </div>
               </div>
                    <div class="tab-pane ml-3 fade" id="v-pills-investment" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="card"> 
                    <div class="ml-3 mt-3">
                        <h6 class="invHeading">Input Investor`s Name</h6>
                        <p style="font-size: 12px;color:#919BA2;">You are allowed to add up to 50 investors by typing (auto suggest)</p>
                        <!-- <h6>Investor</h6> -->
                      
                              <div class="row">
                                 <div class="col-md-6">
                                    <li class="ui-widget" style="position: relative">
                                    <div style="width:100%;border: 1px solid #dad9d9;display:inline-flex;border-radius:5px;">
                                          <span style="position: absolute;
                                             right: 25px;">
                                          </span>
                                          <!-- <input type="text" id="investorauto" name="investorauto" value="<?php if($_POST['keywordsearch']!='') echo  $_POST['investorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                                             <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">-->
                                          <?php if($_POST['popup_select'] == 'investor'){
                                             $isearch = $_POST['popup_keyword'];
                                             $iauto = $invester_filter;
                                             //echo 'hiiiii';
                                             }else  if($_POST['investorauto_sug_other'] != ''){
                                             $isearch = $_POST['keywordsearch_other'];
                                             $iauto = $investorauto;
                                             //echo 'hello';
                                             }else{
                                             $isearch = $_POST['keywordsearch'];
                                             $iauto = 1675;
                                             // echo 'hai';
                                             //echo $isearch;
                                             
                                             } ?>  
                                             <i class="fa fa-search" aria-hidden="true" style="margin-top: 11px;margin-left: 15px;margin-right: 0px"></i>
 
                                          <input type="text" id="investorauto_sug" name="investorauto_sug" value="<?php if($iauto!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                                          <span class="error" style="display:none" id="investorErr">Enter the Investor Name</span>
                                          <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
                                          <input type="hidden" id="invradio" name="invradio" value="<?php if($invandor!=''){echo $invandor;}else {echo 1;}?>" placeholder="" style="width:220px;"> 
                                          <!-- <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_POST['keywordsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>-->
                                          <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;"></div>
                                    </li>
                                    </div>
                                    <div class="col-md-1" style="padding: 10px 0px 0px 30px;">
                                     
                                          <p style="font-size:12px;">OR</p>
                                       
                                    </div>
                                    <div class="col-md-4" >
                                      
                                       <button type="button" class="btn exportFilt text-center" data-toggle="modal" data-target=".impshowdealsbt" style="height: 35px;padding: 0px 45px;"><span>Import</span></button>

                                          <!-- <button  class ="export_new btn bt btn-color btn-circle" style="    margin-top: -10px;" id="impshowdealsbt" name="showdealsimport">Import</button> -->
                                         
                                    </div>
                                 </div>
                          
                        </div>
                        <div class="row ml-3 mt-2">
                           <h6 class="duration">Select Duration</h6>
                        </div>
                        <div class="row ml-4">
                           <!-- <div class="col-md-1"><label>From</label></div> -->
                           <div  class="sort-by-date">
                           <div class="row">
                              
                              <label class="label">From</label>
                              <!-- <div class="col-md-5"> -->
                              <div class="period-date pl-2">
                                
                                 <!-- <label>To</label> -->
                                
                                 <SELECT NAME="month1" id="mon1" class="form-control date" >
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
                                 <SELECT NAME="year1" id="yr1"  id="year1" class="form-control date">
                                    <OPTION id=2 value=""> Year </option>
                                    <?php 
                                       $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                                       
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
                                       
                                       $currentyear = date("Y");
                                       $i=$currentyear;
                                       While($i>= 1998 )
                                       {
                                       $id = $i;
                                       $name = $i;
                                       $isselected = ($year1==$id) ? 'SELECTED' : '';
                                       echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                                       $i--;
                                       }
                                       
                                       
                                       }
                                       ?> 
                                 </SELECT>
                                    </div>
                              <!-- </div> -->
                              <!-- <div class="col-md-1" style="padding-top: 10px;padding-left:0px"> -->
                              <label style="margin-left:0px" class="label">To</label>
                           <!-- </div>  -->

                              <!-- <div class="col-md-5"> -->
                              <div class="period-date pl-3">
                                 <SELECT NAME="month2" id='mon2' class="form-control date">
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
                                    <option VALUE='12' <?php echo ($month2 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
                                 </SELECT>
                                 <SELECT NAME="year2" id="yr2" id="year2" class="form-control date">
                                 <?php 
                                    $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                                    if($_POST['year2']=='')
                                    {
                                    $year2=date("Y");
                                    }
                                    if($yearSql=mysql_query($yearsql))
                                    {
                                    
                                    $currentyear = date("Y");
                                    $i=$currentyear;
                                    While($i>= 1998 )
                                    {
                                    $id = $i;
                                    $name = $i;
                                    $isselected = ($year2==$id) ? 'SELECTED' : '';
                                    echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                                    $i--;
                                    }
                                    }
                                    ?> 
                                 </SELECT>
                                 <input type="hidden" value="<?php echo $listallcompany ?>" name="listhidden" class="listhidden">
                              </div>
                           <!-- </div> -->
                        </div></div>
                     </div>
                        <span class="error" style="display:none" id="durationErr">Select the duration time</span>
                        <div class="copyright-body mt-2">
                              <h6 class="duration">Select fields for excel file export</h6>
                          
                           <label style="font-weight: 600;font-size: 14px;" ><input type="checkbox" class="allexportcheck duration" id="allexportcheck" checked/ > Select All</label>
                           <div class="row ml-1">
                              <ul class="exportcolumn">
                                 <!-- <li><input type="checkbox" class="companyexportcheck" name="skills" value="Company" checked/> <span> Company</span></li> -->
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Company"/> <span> Company</span></li>
                                 <!-- <li><input type="checkbox" class="exportcheck" name="skills" value="Company Type" /> Company Type</li> -->
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Company Type" />
                                    <select NAME="comptype" id="comptype" onChange="getcompanyType()" >
                                       <option  value="" selected> Company Type </option>
                                       <option  value=""  > Both </option>
                                       <option value="L" > Listed </option>
                                       <option  value="U"> Unlisted </option>
                                    </select>
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Industry" /> 
                                    <!-- <div class="selectgroup"> -->
                                    <select name="sltindustry[]" multiple="multiple" size="5" id='sltindustry' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                    <?php
                                       if ($_SESSION['DcompanyId'] != 269229159) {
                                       $industrysql_search = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
                                       } else {
                                       $industrysql_search = "select industryid,industry from industry industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
                                       }
                                       if ($industryrs = mysql_query($industrysql_search))
                                       {
                                       $ind_cnt = mysql_num_rows($industryrs);
                                       }
                                       
                                       if($ind_cnt>0)
                                       {
                                       While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                       {
                                       $id = $myrow[0];
                                       $name = $myrow[1];
                                       if(count($industry)>0)
                                       {
                                       $indSel = (in_array($id,$industry))?'selected':''; 
                                       echo "<OPTION id='industry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                       }
                                       else
                                       {
                                       $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                       echo "<OPTION id='industry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                       }
                                       
                                       }
                                       mysql_free_result($industryrs);
                                       }
                                       ?>
                                    </select> 
                                    <!-- </div> -->
                                 </li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="City" /> 
                                    <select name="city[]" multiple="multiple"  id="citysearch" style=" background: <?php echo $background; ?>;" <?php if($disable_flag_city == "1"){ echo "disabled"; } ?>>
                                    <?php
                                       echo "stateval----".$statevalueid;
                                       
                                       if($statevalueid !=""){
                                       $citysql = " SELECT DISTINCT city.city_id,city.city_name from city,pecompanies,peinvestments where pecompanies.PEcompanyID = peinvestments.PECompanyID and pecompanies.city=city.city_name and city.city_name!='' and city.city_name!='Not Identified - City' and city.city_name!='undefined' and city.city_StateID_FK IN (".$statevalueid.") ORDER BY city.city_name ASC  ";
                                       }else{
                                       $citysql = "SELECT DISTINCT city.city_id,city.city_name from city,pecompanies,peinvestments where pecompanies.PEcompanyID = peinvestments.PECompanyID and pecompanies.city=city.city_name and city.city_name!='' and city.city_name!='Not Identified - City' and city.city_name!='undefined' ORDER BY city.city_name ASC ";
                                       }
                                       
                                       if ($cityrs = mysql_query($citysql))
                                       {
                                       $ind_cnt = mysql_num_rows($cityrs);
                                       }
                                       if($ind_cnt > 0)
                                       {
                                       While($myrow=mysql_fetch_array($cityrs, MYSQL_BOTH))
                                       {
                                       $id = $myrow[0];
                                       $name = $myrow[1];
                                       $name =ucwords(strtolower($name));
                                       if(count($city)>0) {
                                       $indSel = (in_array($id,$city))?'selected':''; 
                                       echo "<OPTION id='city_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                       } else {
                                       echo "<option value=".$id.">".ucwords(strtolower($name)) ."</option>\n";
                                       }
                                       }
                                       mysql_free_result($cityrs);
                                       }
                                       ?>
                                    </select>
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="State" /> 
                                    <!-- <div class="selectgroup"> -->
                                    <select name="state[]" multiple="multiple"  id="sltstate" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                    <?php
                                       $statesql= "SELECT s.state_id, s.state_name FROM pecompanies as pec, state as s WHERE s.state_id=pec.stateid and pec.state !='' Group by s.state_id ORDER BY s.state_name ASC ";
                                       if ($statesearch = mysql_query($statesql))
                                       {
                                       $state_cnt = mysql_num_rows($statesearch);
                                       /*$myrow=mysql_fetch_array($statesearch, MYSQL_BOTH);
                                       print_r($myrow);*/
                                       
                                       }
                                       
                                       if($state_cnt>0)
                                       
                                       {
                                       While($myrow=mysql_fetch_array($statesearch, MYSQL_BOTH))
                                       {
                                       
                                       
                                       $id = $myrow[0];
                                       $name = $myrow[1];
                                       if(count($state)>0)
                                       {
                                       $indSel = (in_array($id,$state))?'selected':''; 
                                       echo "<OPTION id='state_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                       }
                                       else
                                       {
                                       // $isselected = ($getstate==$name) ? 'SELECTED' : '';
                                       echo "<OPTION id='state_".$id. "' value=".$id.">".$name."</OPTION> \n";
                                       }
                                       
                                       }
                                       /*echo $state;
                                       exit();*/
                                       mysql_free_result($statesearch);
                                       }
                                       ?>
                                    </select>
                                    <!-- </div> -->
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Region" /> 
                                    <!-- <div class="selectgroup"> -->
                                    <SELECT NAME="txtregion[]" id="txtregion" multiple="multiple" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                       <!--<OPTION id=5 value="--" selected> ALL </option>-->
                                       <?php
                                          /* populating the region from the Region table */
                                          $regionsql = "select RegionId,Region from region where Region!='' order by RegionId";
                                          if ($regionrs = mysql_query($regionsql)){
                                          $region_cnt = mysql_num_rows($regionrs);
                                          }
                                          if($region_cnt >0){
                                          While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH)){
                                          $id = $myregionrow["RegionId"];
                                          $name = $myregionrow["Region"];
                                          if(count($regionId)>0)
                                          {
                                          $isselcted = (in_array($id,$regionId))?'selected':''; 
                                          echo "<OPTION id='region_".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                          }
                                          else
                                          {
                                          $isselcted = ($getreg==$name) ? 'SELECTED' : "";
                                          echo "<OPTION id='region_".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                          
                                          }
                                          }
                                          mysql_free_result($regionrs);
                                          }
                                          ?>
                                    </SELECT>
                                    <!-- </div> -->
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Exit Status" />
                                    <SELECT NAME="exitstatus" id="exitstatus" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                       <OPTION  value="" selected> Select </option>
                                       <OPTION  value="0" <?php if($exitstatus=="0") echo "selected" ?>> Partial </option>
                                       <OPTION  value="1" <?php if($exitstatus=="1") echo "selected" ?>> Complete </option>
                                    </SELECT>
                                    <!-- </div> -->
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Round" /> 
                                    <!-- <div class="selectgroup"> -->
                                    <select name="round[]" multiple="multiple" id="round" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                       <option id="round_0" value="bridge" <?php if(in_array("bridge",$round)) echo 'selected'; ?>>Bridge</option>
                                       <option id="round_1" value="seed" <?php if(in_array("seed",$round)) echo 'selected'; ?>>Seed</option>
                                       <?php
                                          $j=1;
                                          if($vcflagValue==0){
                                          $seed=13;
                                          }else{
                                          $seed=5;
                                          }
                                          for($i=1; $i<$seed; $i++) {
                                          $j++;
                                          $roundSel = (in_array($i,$round))?'selected':''; 
                                          echo '<option id="round_'.$j.'" value="'.$i.'" '.$roundSel.'>'.$i.'</option>';
                                          }
                                          if($vcflagValue==0){
                                          
                                          ?>
                                       <option id="round_Open" value="Open Market Transaction" <?php if(in_array("Open Market Transaction",$round)) echo 'selected'; ?>>Open Market Transaction</option>
                                       <option id="round_Preferential" value="Preferential Allotment" <?php if(in_array("Preferential Allotment",$round)) echo 'selected'; ?>>Preferential Allotment</option>
                                       <option id="round_Special" value="Special Situation" <?php if(in_array("Special Situation",$round)) echo 'selected'; ?>>Special Situation</option>
                                       <?php } ?>
                                    </select>
                                    <!-- </div> -->
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Stage" /> 
                                    <!-- <div class="selectgroup"> -->
                                    <select name="stage[]" multiple="multiple" size="5" id='stage' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                    <?php
                                       $stagesql_search = "select StageId,Stage from stage ";
                                       
                                       if ($stagers = mysql_query($stagesql_search)){
                                       $stage_cnt = mysql_num_rows($stagers);
                                       }
                                       if($stage_cnt > 0){
                                       $i=1;
                                       While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH)){
                                       $id = $myrow[0];
                                       $name = $myrow[1];
                                       if(count($stageval) > 0){
                                       $isselect = (in_array($id,$stageval))?'selected':''; 
                                       }else{
                                       $isselect = ''; 
                                       }
                                       
                                       echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                                       
                                       }
                                       mysql_free_result($stagers);
                                       }
                                       ?>
                                    </select> 
                                    <!-- </div> -->
                                 </li>
                                 <li>
                                    <input type="checkbox" class="exportcheck" name="skills" value="Investor Type" />
                                    <SELECT NAME="invType" id="invType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                       <OPTION id="5" value="" selected> Investor Type </option>
                                       <OPTION id="5" value="--" > ALL </option>
                                       <?php
                                          /* populating the investortype from the investortype table */
                                          $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
                                          if ($invtypers = mysql_query($invtypesql)){
                                          $invtype_cnt = mysql_num_rows($invtypers);
                                          }
                                          if($invtype_cnt >0){
                                          While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH)){
                                          $id = $myrow["InvestorType"];
                                          $name = $myrow["InvestorTypeName"];
                                          /* if($regionId!='')
                                          {
                                          $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                                          echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                          }
                                          else
                                          {
                                          $isselcted = ($getinv==$name) ? 'SELECTED' : "";
                                          echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                          }*/
                                          $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                                          echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                          }
                                          mysql_free_result($invtypers);
                                          }
                                          ?>
                                    </SELECT>
                                 </li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Stake (%)"/> Stake (%)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Investors" /> Investors</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Date"/> Date</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Website" /> Website</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Year Founded" /> Year Founded</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Sector" /> Sector</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Amount(US$M)" /> Amount (US$M)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Amount(INR Cr)" /> Amount(INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Advisor-Company" /> Advisor-Company</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Advisor-Investors" /> Advisor-Investors</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="More Details" /> More Details</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Link" /> Link</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Pre Money Valuation (INR Cr)" /> Pre Money Valuation (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue Multiple (Pre)" /> Revenue Multiple (Pre)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA Multiple (Pre)" /> EBITDA Multiple (Pre)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="PAT Multiple (Pre)" /> PAT Multiple (Pre)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Post Money Valuation (INR Cr)" /> Post Money Valuation (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue Multiple (Post)" /> Revenue Multiple (Post)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA Multiple (Post)" /> EBITDA Multiple (Post)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="PAT Multiple (Post)" /> PAT Multiple (Post)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Enterprise Valuation (INR Cr)" /> Enterprise Valuation (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue Multiple (EV)" /> Revenue Multiple (EV)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA Multiple (EV)" /> EBITDA Multiple (EV)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="PAT Multiple (EV)" /> PAT Multiple (EV)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Price to Book" /> Price to Book</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Valuation" /> Valuation</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue (INR Cr)" /> Revenue (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA (INR Cr)" /> EBITDA (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="PAT (INR Cr)" /> PAT (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Total Debt (INR Cr)" /> Total Debt (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Cash & Cash Equ. (INR Cr)" /> Cash & Cash Equ. (INR Cr)</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Book Value Per Share" /> Book Value Per Share</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Price Per Share" /> Price Per Share</li>
                                 <li><input type="checkbox" class="exportcheck" name="skills" value="Link for Financials" /> Link for Financials</li>
                              </ul>
                           </div><br>
                          
                           <div style="float:left">
                              <span class="one">
                              <?php if($DownloadCount  >=  $custom_export_limit){?>
                                 <button  class ="export_new btn btn-circle btn-exp" onclick="exportfiltrErr(<?php echo $custom_export_limit ?>)" name="showdeals">Export</button>

                           <?php }
                              else {?>
                              <button  class ="export_new btn btn-circle btn-exp"  id="expshowdealsbt" name="showdeals">Export</button>
                           <?php } ?>
                              </span>
                              <span class="one">
                              <button class="export_new btn  btn-save savevalidatefilter" >Save Filter</button>

                              <!-- <button class ="export_new btn btn-circle btn-secondary" id="saveshowdealsbt" name="showdeals">Save Filter</button> -->
                              </span>
                           </div>
                           <form name="pelistingexcel" id="pelistingexcel"  method="post" action="exportinvdealsExcel.php">
                              <input type="hidden" name="investorvalue" id="investorvalue" value="" >
                              <input type="hidden" name="companytype" id="companytype" value="">
                              <input type="hidden" name="month1" id="month1" value="">
                              <input type="hidden" name="month2" id="month2" value="">
                              <input type="hidden" name="year1" id="year1" value="">
                              <input type="hidden" name="year2" id="year2" value="">
                              <input type="hidden" name="industry" id="industry" value="">
                              <input type="hidden" name="city" id="city" value="">
                              <input type="hidden" name="state" id="state" value="">
                              <input type="hidden" name="region" id="region" value="">
                              <input type="hidden" name="exitStatus" id="sltexitStatus" value="">
                              <input type="hidden" name="round" id="sltround" value="">
                              <input type="hidden" name="stage" id="sltstage" value="">
                              <input type="hidden" name="investorType" id="investorType" value="">
                              <input type="hidden" class="resultarray" name="resultarray" value=""/>
                              <input type="hidden" id="invquery" name="invquery"  value=""/>

                           </form>
                           <form name="pelistingexcelInv" id="pelistingexcelInv"  method="post" action="importexcelsheetbyname.php">
                              <input type="hidden" name="investorname" id="investorname" value="" >
                           </form>
                        </div><br>
                        
                     </div></div>
                     <div class="tab-pane container fade" id="v-pills-exits" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                     <div class="card">   
                     <div class="ml-3 mt-3">
                           <h6 class="invHeading">Input Investor`s Name</h6>
                           <p style="font-size: 12px;color:#919BA2;">You are allowed to add up to 50 investors by typing (auto suggest)</p>
                           <!-- <h6>Investor</h6> -->
                         
                                 <div class="row">
                                    <div class="col-md-6">
                                       <li class="ui-widget" style="position: relative">
                                       <div style="width:100%;border: 1px solid #dad9d9;display:inline-flex;border-radius:5px;">
                                             <span style="position: absolute;
                                                right: 25px;">
                                             </span>
                                             <!-- <input type="text" id="investorauto" name="investorauto" value="<?php if($_POST['keywordsearch']!='') echo  $_POST['investorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                                                <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">-->
                                             <?php if($_POST['popup_select'] == 'investor'){
                                                $isearch = $_POST['popup_keyword'];
                                                $iauto = $invester_filter;
                                                //echo 'hiiiii';
                                                }else  if($_POST['investorauto_sug_other'] != ''){
                                                $isearch = $_POST['keywordsearch_other'];
                                                $iauto = $investorauto;
                                                //echo 'hello';
                                                }else{
                                                $isearch = $_POST['keywordsearch'];
                                                $iauto = 1675;
                                                // echo 'hai';
                                                //echo $isearch;
                                                
                                                } ?>   
                                             <i class="fa fa-search" aria-hidden="true" style="margin-top: 11px;margin-left: 7px;"></i>

                                             <input type="text" id="expinvestorauto_sug" name="expinvestorauto_sug" value="<?php if($iauto!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                                             <span class="error" style="display:none" id="exitinvestorErr">Enter the Investor Name</span>
                                             <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
                                             <input type="hidden" id="invradio" name="invradio" value="<?php if($invandor!=''){echo $invandor;}else {echo 1;}?>" placeholder="" style="width:220px;"> 
                                             <!-- <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_POST['keywordsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>-->
                                             <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;"></div>
                                       </li>
                                       </div>
                                       <div class="col-md-1" style="padding: 10px 0px 0px 30px;">
                                         
                                             <p style="font-size:12px;">OR</p>
                                         
                                       </div>
                                       <div class="col-md-4" >
                                          
                                          <button type="button" class="btn exportFilt text-center" data-toggle="modal" data-target=".impshowdealsbt" style="height: 35px;padding: 0px 45px;">Import</button>
                                            
                                       </div>
                                    </div>
                             
                           </div>
                           <div class="row ml-3 mt-2">
                              <h6 class="duration">Select Duration</h6>
                           </div>
                           <div class="row ml-4">
                              <div  class="sort-by-date">
                              <div class="row">
                              
                              <label class="label">From</label> 
                                 <div class="period-date pl-2">
                                    <SELECT NAME="month1" id="exitmon1" class="form-control date">
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
                                    <SELECT NAME="year1" id="exityr1" class="form-control date" >
                                       <OPTION id=2 value=""> Year </option>
                                       <?php 
                                          $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                                          
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
                                          
                                          $currentyear = date("Y");
                                          $i=$currentyear;
                                          While($i>= 1998 )
                                          {
                                          $id = $i;
                                          $name = $i;
                                          $isselected = ($year1==$id) ? 'SELECTED' : '';
                                          echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                                          $i--;
                                          }
                                          
                                          
                                          }
                                          ?> 
                                    </SELECT>
                                 </div>
                              <label style="margin-left:0px" class="label">To</label>

                                 <div class="period-date pl-3">
                                    <SELECT NAME="month2" id='exitmon2'class="form-control date" >
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
                                       <option VALUE='12' <?php echo ($month2 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
                                    </SELECT>
                                    <SELECT NAME="year2" id="exityr2" class="form-control date">
                                    <?php 
                                       $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                                       if($_POST['year2']=='')
                                       {
                                       $year2=date("Y");
                                       }
                                       if($yearSql=mysql_query($yearsql))
                                       {
                                       
                                       $currentyear = date("Y");
                                       $i=$currentyear;
                                       While($i>= 1998 )
                                       {
                                       $id = $i;
                                       $name = $i;
                                       $isselected = ($year2==$id) ? 'SELECTED' : '';
                                       echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                                       $i--;
                                       }
                                       }
                                       ?> 
                                    </SELECT>
                                    <input type="hidden" value="<?php echo $listallcompany ?>" name="listhidden" class="listhidden">
                                 </div>
                           </div></div></div>
                           <span class="error" style="display:none" id="durationErr">Select the duration time</span>
                           <div class="copyright-body mt-2">
                              <!-- <div class="row"> -->
                                 <h6 class="duration">Select fields for excel file export</h6>
                              <!-- </div> -->
                            
                              <label style="font-weight: 600;font-size: 14px;"><input type="checkbox" class="exitallexportcheck duration" id="exitallexportcheck" checked/> Select All</label>
                              <div class="row ml-1">
                                 <ul class="exitexportcolumn">
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="PortfolioCompany"/> <span>Portfolio Company</span></li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="YearFounded" /> Year Founded</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="ExitingInvestors" /> Exiting Investors</li>
                                    <li>
                                       <input type="checkbox" class="exitexportcheck" name="skills" value="InvestorType" />
                                       <SELECT NAME="invType" id="exitinvType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                          <OPTION id="5" value="--" selected> Investor Type </option>
                                          <OPTION id="5" value="--" > ALL </option>
                                          <?php
                                             /* populating the investortype from the investortype table */
                                             $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
                                             if ($invtypers = mysql_query($invtypesql)){
                                             $invtype_cnt = mysql_num_rows($invtypers);
                                             }
                                             if($invtype_cnt >0){
                                             While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH)){
                                             $id = $myrow["InvestorType"];
                                             $name = $myrow["InvestorTypeName"];
                                             /* if($regionId!='')
                                             {
                                             $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                                             echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                             }
                                             else
                                             {
                                             $isselcted = ($getinv==$name) ? 'SELECTED' : "";
                                             echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                             }*/
                                             $isselcted = ($investorType==$id) ? 'SELECTED' : "";
                                             echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                                             }
                                             mysql_free_result($invtypers);
                                             }
                                             ?>
                                       </SELECT>
                                    </li>
                                    <li>
                                       <input type="checkbox" class="exitexportcheck" name="skills" value="ExitStatus" />
                                       <SELECT NAME="exitstatus" id="exitFlstatus" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                          <OPTION  value="--" selected> Exit Status </option>
                                          <OPTION  value="0" > Partial </option>
                                          <OPTION  value="1" > Complete </option>
                                       </SELECT>
                                    </li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="Industry" /> 
                                       <select name="exitsltindustry[]" multiple="multiple" size="5" id='exitsltindustry' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                       <?php
                                          if ($_SESSION['DcompanyId'] != 269229159) {
                                          $industrysql_search = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
                                          } else {
                                          $industrysql_search = "select industryid,industry from industry industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
                                          }
                                          if ($industryrs = mysql_query($industrysql_search))
                                          {
                                          $ind_cnt = mysql_num_rows($industryrs);
                                          }
                                          
                                          if($ind_cnt>0)
                                          {
                                          While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                          {
                                          $id = $myrow[0];
                                          $name = $myrow[1];
                                          if(count($industry)>0)
                                          {
                                          $indSel = (in_array($id,$industry))?'selected':''; 
                                          echo "<OPTION id='industry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                          }
                                          else
                                          {
                                          $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                          echo "<OPTION id='industry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                          }
                                          
                                          }
                                          mysql_free_result($industryrs);
                                          }
                                          ?>
                                       </select>
                                    </li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="SectorBusinessDescription" /> Sector_Business Description</li>
                                    <li>
                                       <input type="checkbox" class="exitexportcheck" name="skills" value="DealType" />
                                       <SELECT name="dealtype[]" multiple="multiple" id="exitdealtype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                          <!--<OPTION id=1 value="--" selected>ALL </option>-->
                                          <?php
                                             $hide_pms=0;
                                             $dealtypesql = "select DealTypeId,DealType from dealtypes where hide_for_exit=".$hide_pms;
                                             if ($rsdealtype = mysql_query($dealtypesql))
                                             {
                                             $stage_cnt = mysql_num_rows($rsdealtype);
                                             }
                                             if($stage_cnt > 0)
                                             {
                                             While($myrow=mysql_fetch_array($rsdealtype, MYSQL_BOTH))
                                             {
                                             $id = $myrow[0];
                                             $name = $myrow[1];
                                             if(count($dealtype) >0){
                                             $isselcted = (in_array($id,$dealtype))?'selected':'';
                                             }else{
                                             $isselcted ='';
                                             }
                                             echo "<OPTION id=".$id. " value=".$id." ".$isselcted.">".$name."</OPTION> \n";
                                             }
                                             mysql_free_result($rsdealtype);
                                             }
                                             ?>
                                       </select>
                                    </li>
                                    <li>
                                       <input type="checkbox" class="exitexportcheck" name="skills" value="Type" /> 
                                       <SELECT NAME="InType" id="exitInType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                          <option value="--"> Type </option>
                                          <option value="--"> ALL </option>
                                          <option value="1" <?php if($types==1) { echo "selected"; } ?>> IPO </option>
                                          <option value="2" <?php if($types==2) { echo "selected"; } ?>> Open Market Transaction </option>
                                          <option value="3" <?php if($types==3) { echo "selected"; } ?>> Reverse Merger </option>
                                       </SELECT>
                                    </li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="Acquirer" /> Acquirer</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="DealDate" /> Deal Date</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="DealAmount" /> Deal Amount (US\$M)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="AdvisorSeller" /> Advisor-Seller</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="AdvisorBuyer" /> Advisor-Buyer</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="Website" /> Website</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="AddlnInfo" /> Addln Info</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="InvestmentDetails" /> Investment Details</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="Link" /> Link</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="ReturnMultiple" /> ReturnMultiple</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="IRR" /> IRR (%)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="MoreInfo" /> More Info(Returns)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="CompanyValuation" /> Company Valuation (INR Cr)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="RevenueMultiple" /> Revenue Multiple</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="EBITDAMultiple" /> EBITDA Multiple</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="PATMultiple" /> PAT Multiple</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="PricetoBook" /> Price to Book</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="Valuation" /> Valuation (More Info)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="Revenue" /> Revenue (INR Cr)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="EBITDA" /> EBITDA (INR Cr)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="PAT" /> PAT (INR Cr)</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="BookValuePerShare" /> Book Value Per Share</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="PricePerShare" /> Price Per Share</li>
                                    <li><input type="checkbox" class="exitexportcheck" name="skills" value="LinkforFinancials" /> Link for Financials</li>
                                 </ul>
                              </div><br>
                              <div style="float:left">
                              <span class="one">
                              <?php if($DownloadCount  >=  $custom_export_limit){?>
                                 <button  class ="export_new btn  btn-exp" onclick="exportfiltrErr(<?php echo $custom_export_limit ?>)" name="showdeals">Export</button>

                           <?php }
                              else {?>
                              <button  class ="export_new btn  btn-exp"  id="exitexpshowdealsbt" name="showdeals">Export</button>
                           <?php } ?>
                              </span>
                              <span class="one">
                              <button class="export_new btn  btn-save savevalidatefilter"  >Save Filter</button>

                              <!-- <button class ="export_new btn btn-circle btn-secondary" id="saveshowdealsbt" name="showdeals">Save Filter</button> -->
                              </span>
                           </div>
                              <form name="exitpelistingexcel" id="exitpelistingexcel"  method="post" action="exportexitinExcel.php">
                                 <!-- <input type="hidden" name="investorvalue" id="investorvalue" value="" >
                                    <input type="hidden" name="companytype" id="companytype" value="">
                                    <input type="hidden" name="month1" id="month1" value="">
                                    <input type="hidden" name="month2" id="month2" value="">
                                    <input type="hidden" name="year1" id="year1" value="">
                                    <input type="hidden" name="year2" id="year2" value="">
                                    <input type="hidden" class="exitresultarray" name="exitresultarray" value=""/> -->
                                 <input type="hidden" name="txtsearchon" value="3" >
                                 <input type="hidden" name="txttitle" id="txttitle" value=0>
                                 <input type="hidden" name="txthide_pms"  id="txthide_pms" value=2>
                                 <input type="hidden" name="txthidename" id="txthidename" value="<?php echo $username ?>">
                                 <input type="hidden" name="txthideemail" id="txthideemail" value="<?php echo $dlogUserEmail?>">
                                 <input type="hidden" name="txthideindustry" id="txthideindustry">
                                 <input type="hidden" name="txthideindustryid" id="txthideindustryid">
                                 <input type="hidden" name="txthidetype" id="txthidetype" >
                                 <input type="hidden" name="txthidedealtype" id="txthidedealtype" >
                                 <input type="hidden" name="txthidedealtypeid" id="txthidedealtypeid">
                                 <input type="hidden" name="txthideinvtype" id="txthideinvtype" >
                                 <input type="hidden" name="txthideinvtypeid" id="txthideinvtypeid" >
                                 <input type="hidden" name="txthideInType" id="txthideInType" >
                                 <input type="hidden" name="txthideexitstatusvalue" id="txthideexitstatusvalue">
                                 <input type="hidden" name="txthiderange" id="txthiderange" >
                                 <input type="hidden" name="txthidedate" id="txthidedate" >
                                 <input type="hidden" name="txthidedateStartValue" id="txthidedateStartValue"  >
                                 <input type="hidden" name="txthidedateEndValue" id="txthidedateEndValue" >
                                 <input type="hidden" name="txthideReturnMultipleFrm" id="txthideReturnMultipleFrm"> 
                                 <input type="hidden" name="txthideReturnMultipleTo" id="txthideReturnMultipleTo" >
                                 <input type="hidden" name="txthideinvestor" id="txthideinvestor" >
                                 <input type="hidden" name="txthideInvestorString" id="txthideInvestorString">
                                 <input type="hidden" name="txthidecompany"  id="txthidecompany">
                                 <input type="hidden" name="txthideCompanyString" id="txthideCompanyString" >
                                 <input type="hidden" name="txthidesectorsearch" id="txthidesectorsearch">
                                 <input type="hidden" name="txthidesectorsearchval" id="txthidesectorsearchval">
                                 <input type="hidden" name="txthidesubsectorsearch" id="txthidesubsectorsearch">
                                 <input type="hidden" name="txthideadvisor_legal" id="txthideadvisor_legal">
                                 <input type="hidden" name="txthideadvisor_trans" id="txthideadvisor_trans">
                                 <input type="hidden" name="txthideacquirer" id="txthideacquirer">
                                 <input type="hidden" name="txthidesearchallfield" id="txthidesearchallfield">
                                 <input type="hidden" name="yearafter" id="yearafter">
                                 <input type="hidden" name="yearbefore" id="yearbefore">
                                 <input type="hidden" name="invhead" id="invhead" >
                                 <input type="hidden" name="tagsearchval" id="tagsearchval">
                                 <input type="hidden" id="invradio" name="invradio" value=1> 
                                 <input type="hidden" name="txthidepe" id="txthidepe" >
                                 <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" >
                                 <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag">
                                 <input type="hidden" name="exitquery" id="exitquery">

                                 <!-- T960 -->
                                 <input type="hidden" class="exitresultarray" name="exitresultarray" value=""/>
                                 <!-- T960 end -->
                              </form>
                              <form name="pelistingexcelInv" id="pelistingexcelInv"  method="post" action="importexcelsheetbyname.php">
                                 <input type="hidden" name="investorname" id="investorname" value="" >
                              </form>
                           </div><br>
                        </div>
                     </div>
                  </div>
                                          </div>
                  <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
               </div>
            </div>
         </div>
      </div>


      <!-- Modal -->
               <div  class="modal fade impshowdealsbt" role="dialog">
               <div class="modal-dialog modal-dialog-centered">

                  <!-- Modal content-->
                  <div class="modal-content">
                     <div class="modal-header">
                     <h4 class="modal-title" style="font-size: 17px;">File upload form</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>

                     </div>
                     <div class="modal-body">
                     <!-- Form -->
                     <form name="dealsupload" enctype="multipart/form-data" id="leaguefile" method="post" >
                      <input type='file' name="leaguefilepath" id='file' class='form-control ip-file' style="font-size: 13px;"><br>
                      <input type="button" class="btn" value="Upload" onClick="getLeagueImport();" style="    height: 30px; float: right;">

                     </form>
                     </div>
               
                  </div>

               </div>
               </div>

      <!-- <div class="lb" id="popup-box-copyrights-savefilter" style="width:650px !important;">
         <span id="expcancelbtn-savefilter" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
         <form name="dealsupload" id="leaguefileFilter" method="post" >
            <div class="accordian">
               <h5 class="acc-title" style="padding:10px;text-align: center;"><span>Save Filter</span> <i class="zmdi zmdi-chevron-down"></i></h5>
               <div class="acc-content ">
                  <div class="row">
                     <div class="col-md-4">
                        <span style="font-weight: bold;margin-left: 80px;">Filter Name:</span>
                     </div>
                     <div class="col-md-7"> <input type="text" name="filtername" id="filter_name" class="form-control">
                        <span class="error" style="display:none" id="filterErr">Please Enter the Filter Name<span>
                     </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-md-4">
                        <span style="font-weight: bold;margin-left: 50px;">Filter Description:</span>
                     </div>
                     <div class="col-md-7">
                        <textarea name="filterdesc" id="filter_desc" class="form-control"></textarea>
                        <span class="error" style="display:none" id="filterDescErr">Please Enter the Filter Description<span>
                     </div>
                  </div>
                  <div class="btn-sec text-right" style="padding:20px">
                     <button type="button" class="btn btn-circle btn-dark btn-circle btn-sm" style="width: 100px;"  onClick="saveFilterName();">Save</button>
                     <button type="button" class="btn btn-outline-dark btn-circle btn-sm" style="width: 100px;"  onClick="cancelFilterName();">Cancel</button>
                  </div>
               </div>
            </div> -->
            <div class="modal fade saveshowdealsbt"   tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <!-- <div class="modal-header Header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Name for your Custom Filter</h5>
      </div> -->
      <div class="modal-body">
      <div class="modal-header Header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Name for your Custom Filter</h5>
      </div>
      <div class="form-group">
            <input type="text" class="form-control" name="filtername" id="filter_name" style="font-size:14px" placeholder="Enter Name for your Custom Filter">
            <span class="error" style="display:none" id="filterErr" >Please Enter the Filter Name<span>
          </div>
          <div class="form-group">
            <textarea class="form-control " name="filterdesc" id="filter_desc" placeholder="Notes" style="font-size:14px"></textarea>
            <span class="error" style="display:none" id="filterDescErr" >Please Enter the Filter Description<span>
          </div>
          <div class="Footer">
      <button type="button" class="export_new btn  btn-exp mr-auto" onClick="saveFilterName();" >Save</button>
        <button type="button" class="export_new btn  btn-save" style="margin-right: 110px;" data-dismiss="modal" onClick="cancelFilterName();">Close</button>
      </div>
        </form>
      </div>
   
    </div>
  </div>
</div>
         </form>
      </div>
     <script>
        $(document).ready(function(){
         $('.exportcolumn .exportcheck').attr('checked', true); 
         $(".resultarray").val('Select-All');
         $('.exitexportcolumn .exitexportcheck').attr('checked', true); 
         $(".exitresultarray").val('Select-All');
         
         //getfilterName();
          // var currentURL=window.location.href;
         // //alert(currentURL);
         // if(currentURL)
         // {
         // var createElement=document.createElement("link");
         // createElement.rel="stylesheet";
         // createElement.href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css";
         // //createElement.integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm";
         // //createElement.crossorigin="anonymous";
         // $('head').append(createElement);
         
         // }

         $('#allexportcheck').click(function(){
         if(this.checked)
         {
         $('.exportcolumn .exportcheck').attr('checked', true); 
         }
         else
         {
         $('.exportcolumn .exportcheck').attr('checked', false); 
         }
         
         })
         $('#exitallexportcheck').click(function(){
         if(this.checked)
         {
         $('.exitexportcolumn .exitexportcheck').attr('checked', true); 
         
         }
         else
         {
         $('.exitexportcolumn .exitexportcheck').attr('checked', false); 
         
         }
         
         })
         var mode='';
         $(document).on("change",".exportcheck",function() {
         var result = $('.exportcolumn input[type="checkbox"]:checked'); // this return collection of items checked
         var totalcheckbox = $('.exportcolumn input[type="checkbox"]');
         if (result.length > 0) {
         var resultString ="";
         result.each(function () {
         resultString += $(this).val() + "," ;
         // resultString+= $(this).val() + "<br/>";
         });
         resultString =  resultString.replace(/,\s*$/, "");
         $(".resultarray").val(resultString);
         }
         if(result.length==totalcheckbox.length)
         {
         $('.allexportcheck').attr('checked', true);
         }
         else{
         $('.allexportcheck').attr('checked', false);
         }
         });
         
         $(document).on("change",".exitexportcheck",function() {
         var result = $('.exitexportcolumn input[type="checkbox"]:checked'); // this return collection of items checked
         var totalcheckbox = $('.exitexportcolumn input[type="checkbox"]');
         if (result.length > 0) {
         var resultString ="";
         result.each(function () {
         resultString += $(this).val() + "," ;
         // resultString+= $(this).val() + "<br/>";
         });
         resultString =  resultString.replace(/,\s*$/, "");
         $(".exitresultarray").val(resultString);
         }
         if(result.length==totalcheckbox.length)
         {
         $('.exitallexportcheck').attr('checked', true);
         }
         else{
         $('.exitallexportcheck').attr('checked', false);
         }
         });
        });
        
        var globalfilterNameId='';
        var globalfilterId='';
        var globalfilterDescrip='';
        var exitglobalfilterNameId='';
        var exitglobalfilterId='';
        var exitglobalfilterDescrip='';
         function EditFilter(filterNameId)
         {

         $('#investorauto_sug').tokenInput("clear");
         
         getFilterName=$('#mode').val('E');
         $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {filterName: filterNameId, mode: 'E'},
         success: function(data){
         var dataval=data.replace(/[\u0000-\u0019]+/g,"")
         var dataset=JSON.parse(JSON.stringify(dataval))
         var dataValue=JSON.parse(dataset);
        


         if(dataValue[0].filter_type == "Exit")
         {
            $('#v-pills-messages-tab').trigger('click');

            exitglobalfilterDescrip=dataValue[0].filter_desc;
         exitglobalfilterNameId=dataValue[0].filter_name;
         exitglobalfilterId=dataValue[0].id;
         $("#exitFlstatus").val(dataValue[0].exit_status)
         
         $("#exitsltindustry").val(dataValue[0].industry.split(','))
         $("#exitsltindustry").multiselect('refresh') 
         
         $("#exitdealtype").val(dataValue[0].dealtype.split(','))
         $("#exitdealtype").multiselect('refresh') 
         
         $("#exitinvType").val(dataValue[0].investor_type);
         $("#exitInType").val(dataValue[0].intype);
         $('#exitmon1').val(dataValue[0].start_date);
            $('#exitmon2').val(dataValue[0].end_date);
            $('#exityr1').val(dataValue[0].start_year);
            $('#exityr2').val(dataValue[0].end_year)  
         }
         else{
            $('#v-pills-profile-tab').trigger('click');

            globalfilterDescrip=dataValue[0].filter_desc;
         globalfilterNameId=dataValue[0].filter_name;
         globalfilterId=dataValue[0].id;
            $('#mon1').val(dataValue[0].start_date);
            $('#mon2').val(dataValue[0].end_date);
            $('#yr1').val(dataValue[0].start_year);
            $('#yr2').val(dataValue[0].end_year)  
         $("#sltindustry").val(dataValue[0].industry.split(','))
         $("#sltindustry").multiselect('refresh') 
         
         $("#citysearch").val(dataValue[0].city.split(','))
         $("#citysearch").multiselect('refresh') 
         
         $("#sltstate").val(dataValue[0].state.split(','))
         $("#sltstate").multiselect('refresh') 
         
         $("#txtregion").val(dataValue[0].region.split(','))
         $("#txtregion").multiselect('refresh') 
         
         $("#exitstatus").val(dataValue[0].exit_status.split(','))
         $("#exitstatus").multiselect('refresh') 
         
         $("#round").val(dataValue[0].round.split(','))
         $("#round").multiselect('refresh') 
         
         $("#stage").val(dataValue[0].stage.split(','))
         $("#stage").multiselect('refresh') 
         
         $("#invType").val(dataValue[0].investor_type);
         $("#comptype").val(dataValue[0].company_type);
         }
         $('#maskscreen').fadeOut();
         $('#preloading').fadeOut();  
         $('#popup-box-copyrights-getfilter').fadeOut();
         for(i=0;i<dataValue.length;i++)
         {
         if(dataValue[i]['filter_type'] == "Investments")
         {
         $("#investorauto_sug").tokenInput("add",{id: dataValue[i]['InvestorId'], name: dataValue[i]['Investor']});
         }
         else{
         $("#expinvestorauto_sug").tokenInput("add",{id: dataValue[i]['InvestorId'], name: dataValue[i]['Investor']});
         
         }
         }
         filterDescrip=$('#filter_desc').val(dataValue[0].filter_desc)
         
         if(dataValue[0].column_name)
         {
         if(dataValue[0].filter_type == "Investments")
         {
         $('.allexportcheck').attr('checked', true);
         $('.exportcheck').attr('checked', false)
         var columnName=dataValue[0].column_name.split(',')
         for(i=0;i<columnName.length;i++)
         {
         $("input[value='"+columnName[i]+"']").prop('checked', true);
         }
         } 
         else{
         $('.exitallexportcheck').attr('checked', true);
         $('.exitexportcheck').attr('checked', false)
         var columnName=dataValue[0].column_name.split(',')
         for(i=0;i<columnName.length;i++)
         {
         $("input[value='"+columnName[i]+"']").prop('checked', true);
         }
         
         }  
         }
         },
         });
         
         }

      $("#investorauto_sug").tokenInput("ajaxInvestorDetails_auto.php?vcf=<?php echo $VCFlagValue; ?>",{
         theme: "facebook",
         minChars:2,
         queryParam: "pe_q",
         hintText: "",
         noResultsText: "No Result Found",
         preventDuplicates: true,
         onAdd: function (item) {
         $('#keywordsearch,#sectorsearch,#advisorsearch_trans,#searchallfield,#advisorsearch_legal,#tagsearch').val("");
         $('#investorauto,#sectorsearchauto,#advisorsearch_transauto,#advisorsearch_legalauto,#tagsearch_auto').val("");
         
         },
         onDelete: function (item) {
         var selectedValues = $('#investorauto_sug').tokenInput("get");
         var inputCount = selectedValues.length;
         if(inputCount==0){ 
         
         }
         },
         prePopulate : <?php if($investorsug_response!=''){echo   $investorsug_response; }else{ echo 'null'; } ?>
         });
         

      $("#expinvestorauto_sug").tokenInput("ajaxInvestorDetails_auto.php?vcf=<?php echo $VCFlagValue; ?>",{
         theme: "facebook",
         minChars:2,
         queryParam: "pe_q",
         hintText: "",
         noResultsText: "No Result Found",
         preventDuplicates: true,
         onAdd: function (item) {
         $('#keywordsearch,#sectorsearch,#advisorsearch_trans,#searchallfield,#advisorsearch_legal,#tagsearch').val("");
         $('#investorauto,#sectorsearchauto,#advisorsearch_transauto,#advisorsearch_legalauto,#tagsearch_auto').val("");
         
         },
         onDelete: function (item) {
         var selectedValues = $('#expinvestorauto_sug').tokenInput("get");
         var inputCount = selectedValues.length;
         if(inputCount==0){ 
         
         }
         },
         prePopulate : <?php if($investorsug_response!=''){echo   $investorsug_response; }else{ echo 'null'; } ?>

         });

         $(function(){
            $("#citysearch").multiselect({noneSelectedText: 'City', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
            $("#sltstate").multiselect({noneSelectedText: 'state', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
            $("#sltindustry").multiselect({noneSelectedText: 'Industry', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
            $("#exitsltindustry").multiselect({noneSelectedText: 'Industry', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
          $("#exitstatus").multiselect({noneSelectedText: 'Exit status', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
          $("#txtregion").multiselect({noneSelectedText: 'Region', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
          $("#round").multiselect({noneSelectedText: 'Round', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
            $("#stage").multiselect({noneSelectedText: 'Stage', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });
         $(function(){
            $("#exitdealtype").multiselect({noneSelectedText: 'Deal Type', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
         });

         function deleteFilter(filterNameId)
         {
         $('#investorauto_sug').tokenInput("clear");
         $('input[type=checkbox]').prop('checked',true);
         $('.allexportcheck .exportcheck').attr('checked', true); 
         
         swal({
         title: "Are you sure?",
         text: "You want to delete this record!",
         icon: "warning",
         buttons: true,
         dangerMode: true,
         })
         .then((willDelete) => {
         if (willDelete) {
         $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {filterName: filterNameId, mode: 'D'},
         success: function(data){
         
         swal('Deleted successfully').then(function() {
            location.reload();

         });
         $('#maskscreen').fadeOut();
         $('#preloading').fadeOut();  
         $('#popup-box-copyrights-getfilter').fadeOut(); 
         
         },
         });
         }
         });
         }


         function exportfiltr(value,filterType,filterNameId,filter_name)
         {
            if(value == 1)
            {
               $.ajax({
               url: 'saveFilter.php',
               type: "POST",
               data: {companyName:'<?php echo $companyName?>',filterType:filterType,filterName:filter_name,filterNameId: filterNameId, mode: 'export'},
               success: function(data){
               var dataval=data.replace(/[\u0000-\u0019]+/g,"")
               var dataset=JSON.parse(JSON.stringify(dataval))
               var dataValue=JSON.parse(dataset);
               var Type=dataValue[0].filter_type
               if(Type == "Exit")
               {
                  $("#txthideexitstatusvalue").val(dataValue[0].exit_status)
               
               $("#txthideindustryid").val(dataValue[0].industry.split(','))
               
               $("#txthidedealtypeid").val(dataValue[0].dealtype.split(','))
               
               $("#txthideinvtypeid").val(dataValue[0].investor_type);
               $("#txthidetype").val(dataValue[0].intype);  
                  var month1= dataValue[0].start_date
               var month2= dataValue[0].end_date
               var year1= dataValue[0].start_year
               var year2= dataValue[0].end_year
               var months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
               var betweenDateMonth1=months[month1-1]
               var betweenDateMonth2=months[month2-1]
               
               var betweenDate=betweenDateMonth1+'-'+year1+'to'+betweenDateMonth2+'-'+year2
               
               $('#txthidedate').val(betweenDate)
               var startDate=year1 +'-'+ month1 +'-'+ 01 
               $('#txthidedateStartValue').val(startDate);
               
               var endDate=year2 +'-'+ month2 +'-'+ 31;
               $('#txthidedateEndValue').val(endDate);
               }
               else{
                  $('#industry').val(dataValue[0].industry);
                  $('#city').val(dataValue[0].city);
                  $('#state').val(dataValue[0].state);
                  $('#region').val(dataValue[0].region);
                  $('#exitStatus').val(dataValue[0].exit_status);
                  $('#round').val(dataValue[0].round);
                  $('#stage').val(dataValue[0].stage);
                  $('#investorType').val(dataValue[0].investor_type);
                  $('#month1').val(dataValue[0].start_date);
                  $('#month2').val(dataValue[0].end_date);
                  $('#year1').val(dataValue[0].start_year);
                  $('#year2').val(dataValue[0].end_year)   
               }

               if(dataValue.length != 0)
               {
               var div='';
               for(i=0;i<dataValue.length;i++)
               {
               div +=dataValue[i].InvestorId
               if(i<(dataValue.length-1))
               {
               div +=',' 
               } 
               }
               if(dataValue[0].column_name)
               {
               $(".resultarray").val(dataValue[0].column_name);
               
               }
               
               if(dataValue[0].filter_type =="Exit")
               {
                  $('#txthideinvestor').val(div);
               hrefval= 'exportexitinExcel.php';
               $("#exitpelistingexcel").attr("action", hrefval);
               $("#exitpelistingexcel").submit();
               }
               else{
                  $('#investorvalue').val(div);

               hrefval= 'exportinvdealsExcel.php';
               $("#pelistingexcel").attr("action", hrefval);
               $("#pelistingexcel").submit();
               }
               }
               },
               });
            }
            setTimeout(function(){
               window.location.reload(1);
            }, 500);
         }

         $(document).on('click','#impshowdealsbt',function(){
         
         //$('#popup-box-copyrights').fadeOut();   
         $('#maskscreen').fadeIn();
         $('#preloading').fadeIn();  
         $('#popup-box-copyrights-filter').fadeIn(); 
         
         });


         function getLeagueImport()
         {
         var formData = new FormData($('#leaguefile')[0]);
         //$(".popup_main").show();
         $(".loader").show();
         
         $.ajax({
         url: 'importexcelsheetbyname.php',
         type: "POST",
         data: formData,
         processData: false,
         contentType: false,
         success: function(data){
         
         $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {investorName:data,mode:'getInvestorId'},
         
         success: function(data){
         var dataval=data.replace(/[\u0000-\u0019]+/g,"")
         var dataset=JSON.parse(JSON.stringify(dataval))
         var dataValue=JSON.parse(dataset);
         var filterType=$(".rightpanel").find(".active").attr('value')
        $('.impshowdealsbt').modal('hide')
         if(filterType == "Exit")
         {
            $('#file').val('')
         for(i=0;i<dataValue.length;i++)
         {
         $("#expinvestorauto_sug").tokenInput("add",{id: dataValue[i]['InvestorId'], name: dataValue[i]['Investor']});
         }
         }
         else
         {
            $('#file').val('')
         for(i=0;i<dataValue.length;i++)
         {
         $("#investorauto_sug").tokenInput("add",{id: dataValue[i]['InvestorId'], name: dataValue[i]['Investor']});
         }
         }
         jQuery('#preloading').fadeOut();
         
         },
         });
         },
         error:function(){
         $(".loader").hide();
         $("#popup_main").hide();
         alert("There was some problem ...");
         }
         
         });
         
         }
         var investornameArray=[];
         function saveFilterName()
         {
         investornameArray=[];
         
         var filterType=$(".rightpanel").find(".active").attr('value')
         
         var filtername=$('#filter_name').val()
         var filterDesc=$('#filter_desc').val().trim()
         $.ajax({
                  url: 'saveFilter.php',
                  type: "POST",
                  data: {filtername:filtername,filterType:filterType, mode: 'getData'},
               success: function(data){

                  if(data == 'failure')
                  {
                     $('.saveshowdealsbt').modal('hide');

                     swal("You are already enter the filter name in '"+filterType+"' Filter ")
                     return false;
                  }
      else{
         if(filterType == "Investments")
         {
         var Industry=$('#sltindustry').val();
         var city=$('#citysearch').val();
         var state=$('#sltstate').val();
         var region=$('#txtregion').val();
         var exitStatus=$('#exitstatus').val();
         var round=$('#round').val();
         var stage=$('#stage').val();
         var investorType=$('#invType').val();
         var companytype=$('#comptype').val();
         var checkboxName=$('.exportcheck:checked').map(function() {return this.value;}).get().join(',')
         var selectedValues = $('#investorauto_sug').tokenInput("get");
         var month1=$('#mon1').val();
         var month2=$('#mon2').val();
         var year1=$('#yr1').val();
         var year2=$('#yr2').val();

         for(i=0;i<selectedValues.length;i++)
         {
         investornameArray.push(selectedValues[i]["name"])
         }
         var editfilterId=globalfilterId;
         }
         else
         {
          var editfilterId= exitglobalfilterId
         var checkboxName=$('.exitexportcheck:checked').map(function() {return this.value;}).get().join(',')
         var selectedValues = $('#expinvestorauto_sug').tokenInput("get");
         var exitStatus=$('#exitFlstatus').val();
         var investorType=$('#exitinvType').val();
         var Industry=$('#exitsltindustry').val();
         var Intype=$('#exitInType').val();
         var dealType=$('#exitdealtype').val();
         var month1=$('#exitmon1').val();
         var month2=$('#exitmon2').val();
         var year1=$('#exityr1').val();
         var year2=$('#exityr2').val();
         for(i=0;i<selectedValues.length;i++)
         {
         investornameArray.push(selectedValues[i]["name"])
         }
         
         }
         if(filtername == '')
         {
         //$('.error').html('Enter the filter Name')
         $('#filterErr').show();
         
         }
         else if(filterDesc == '')
         {
         //$('.error').html('Enter the filter Name')
         $('#filterDescErr').show();
         
         }
         else if(parseInt(year1) > parseInt(year2))
         {
         swal("Error: 'To' Year cannot be before 'From' Year");
         }
         else
         {
         $('#filterErr').hide();
         $('#filterDescErr').hide();
         $('#durationErr').hide()
         
         $.ajax({
         url: 'saveFilter.php',
         type: "POST",
         data: {start_date:month1,end_date:month2,start_year:year1,end_year:year2,Intype:Intype,dealType:dealType,filterType:filterType,companytype:companytype,investorType:investorType,stage:stage,round:round,exitStatus:exitStatus,
         region:region,state:state,city:city,Industry:Industry, filtername: filtername,
         EditFilter:editfilterId,
         filterDesc:filterDesc,
         checkboxName:checkboxName,
         investorval: JSON.stringify(investornameArray),mode: 'A'},
         success: function(data){
            $('.saveshowdealsbt').modal('hide')

         swal({
         title: "Saved Successfully!",
         //text: "You clicked the button!",
         icon: "success",
         //button: "Aww yiss!",
         }).then(function() {
            location.reload();

         });
         $('#investorauto_sug').tokenInput("clear");
         $('.allexportcheck ').attr('checked', true); 
         
         $('.exportcolumn .exportcheck').attr('checked', true); 
         
         },
         });
         }
      }
   },
            });
         
         }

         $(document).on('click','.savevalidatefilter',function(){

            if($(".rightpanel").find(".active").attr('value') == "Investments")
               {
                  
                  if($('#investorauto_sug').tokenInput("get").length == 0)
                  {
                  $('#investorErr').show();
                  $('.saveshowdealsbt').modal('hide');
                  }
                  else if(parseInt($('#yr1').val()) > parseInt($('#yr2').val()))
                  {
                  swal("Error: 'To' Year cannot be before 'From' Year");
                  }
                  else
                  {
                  $('#investorErr').hide();
                  
                  $('.saveshowdealsbt').modal('show');

                  mode=$('#mode').val();
                  if(mode == 'A')
                  {
                  $('#filter_name').val('')
                  $('filter_desc').val('');

                  }
                  else
                  {
                  $('#filter_name').val(globalfilterNameId);
                  $('filter_desc').val(globalfilterDescrip);
               
                  }
                  }
               }
               else{
                  if($('#expinvestorauto_sug').tokenInput("get").length == 0)
                  {
                  $('#exitinvestorErr').show();
                  $('.saveshowdealsbt').modal('hide');
                  }
                  else if(parseInt($('#exityr1').val()) > parseInt($('#exityr2').val()))
                  {
                  swal("Error: 'To' Year cannot be before 'From' Year");
                  }
                  else
                  {
                  $('#exitinvestorErr').hide();
                  
                  $('.saveshowdealsbt').modal('show');

                  mode=$('#mode').val();
                  if(mode == 'A')
                  {
                  $('#filter_name').val('')
                  $('filter_desc').val('');

                  }
                  else
                  {
                  $('#filter_name').val(exitglobalfilterNameId);
                  $('filter_desc').val(exitglobalfilterDescrip);
               
                  }
                  }
               }
         });

        
         $(document).on('click','#expcancelbtn-savefilter',function(){
         $('#filterErr').hide()
         $('#filterDescErr').hide()
         $('#durationErr').hide()
         jQuery('#popup-box-copyrights-savefilter').fadeOut();   
         jQuery('#maskscreen').fadeOut(1000);
         $('#preloading').fadeOut();
         return false;
         });

           $(document).on('click','#expcancelbtn-savefilter',function(){
         $('#filterErr').hide()
         $('#filterDescErr').hide()
         $('#durationErr').hide()
         jQuery('#popup-box-copyrights-savefilter').fadeOut();   
         jQuery('#maskscreen').fadeOut(1000);
         $('#preloading').fadeOut();
         return false;
         });

                $(document).on('click','#expcancelbtn-filter',function(){
         jQuery('#popup-box-copyrights-filter').fadeOut();   
         jQuery('#maskscreen').fadeOut(1000);
         $('#preloading').fadeOut();
         return false;
         });
         
         
         $(document).on('click','#expcancelbtn-getfilter',function(){
         jQuery('#popup-box-copyrights-getfilter').fadeOut();   
         jQuery('#maskscreen').fadeOut(1000);
         $('#preloading').fadeOut();
         return false;
         });


         $('#expshowdealsbt').click(function(){
         var month1= $('#mon1').val()
         $('#month1').val(month1)
         var month2= $('#mon2').val()
         $('#month2').val(month2)
         var year1= $('#yr1').val()
         $('#year1').val(year1)
         var year2= $('#yr2').val()
         $('#year2').val(year2) 
         $('#filter_name').val(' ');
         $('#filter_desc').val(' ')
         var investorval=$('#investorauto_sug').val();
         $('#investorvalue').val(investorval);
         var Industry=$('#sltindustry').val();
         $('#industry').val(Industry);
         var city=$('#citysearch').val();
         $('#city').val(city);
         var state=$('#sltstate').val();
         $('#state').val(state);
         var region=$('#txtregion').val();
         $('#region').val(region);
         var exitStatus=$('#exitstatus').val();
         $('#sltexitStatus').val(exitStatus);
         var round=$('#round').val();
         $('#sltround').val(round);
         var stage=$('#stage').val();
         $('#sltstage').val(stage);
         var investorType=$('#invType').val();
         $('#investorType').val(investorType);
         if($('#investorauto_sug').tokenInput("get").length == 0)
         {
         $('#investorErr').show();
         }
         else if(($('#mon1').val() && $('#mon2').val() && $('#yr1').val() && $('#yr2').val()) == '')
         {
         $('#durationErr').show()
         
         }
         else if(parseInt(year1) > parseInt(year2))
         {
         swal("Error: 'To' Year cannot be before 'From' Year");
         }
         else
         {
         $('#investorErr').hide();
         $.ajax({
         url: 'ajxCheckDownload.php',
         dataType: 'json',
         success: function(data){
         var downloaded = data['recDownloaded'];
         var exportLimit = data.exportLimit;
         var currentRec = 807;
         
         //alert(exportLimit)
         var remLimit = exportLimit-downloaded;
         //alert(remLimit);
         var filterType= $(".rightpanel").find(".active").attr('value')       
         exportfiltr(1,filterType,globalfilterId,globalfilterNameId);
         if (currentRec < remLimit){
         hrefval= 'exportinvdealsExcel.php';
         $("#pelistingexcel").attr("action", hrefval);
         $("#pelistingexcel").submit();
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
         });
         
         $('#exitexpshowdealsbt').click(function(){
         if($('#exitdealtype').val() != null)
         {
         var dealtype=$('#exitdealtype').val().toString();
         $('#txthidedealtypeid').val(dealtype);
         }
         
         if($('#exitinvType').val() != "")
         {
         var invType=$('#exitinvType').val();
         $('#txthideinvtypeid').val(invType);
         $('#txthideinvtype').val($('#exitinvType').find(":selected").text());
         }
         
         var InType=$('#exitInType').val();
         $('#txthidetype').val(InType);
         
         if($('#exitsltindustry').val() != null)
         {
         $('#txthideindustryid').val($('#exitsltindustry').val().toString());
         }
         
         var exitStatus=$('#exitFlstatus').val();
         $('#txthideexitstatusvalue').val(exitStatus);
         
         
         var month1= $('#exitmon1').val()
         var month2= $('#exitmon2').val()
         var year1= $('#exityr1').val()
         var year2= $('#exityr2').val()
         var months = ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
         var betweenDateMonth1=months[month1-1]
         var betweenDateMonth2=months[month2-1]
         
         var betweenDate=betweenDateMonth1+'-'+year1+'to'+betweenDateMonth2+'-'+year2
         
         $('#txthidedate').val(betweenDate)
         var startDate=year1 +'-'+ month1 +'-'+ 01 
         $('#txthidedateStartValue').val(startDate);
         
         var endDate=year2 +'-'+ month2 +'-'+ 31;
         $('#txthidedateEndValue').val(endDate);
         
         $('#filter_name').val(' ');
         $('#filter_desc').val(' ')
         var investorval=$('#expinvestorauto_sug').val();
         $('#txthideinvestor').val(investorval);
         var investorvalStr= $('#expinvestorauto_sug').val() ; 
         investorvalStr += '+';
         $('#txthideInvestorString').val(investorvalStr);
         
         if($('#expinvestorauto_sug').tokenInput("get").length == 0)
         {
         $('#exitinvestorErr').show();
         }
         else if(($('#exitmon1').val() && $('#exitmon1').val() && $('#exityr1').val() && $('#exityr2').val()) == '')
         {
         $('#durationErr').show()
         
         }
         else if(parseInt(year1) > parseInt(year2))
         {
         swal("Error: 'To' Year cannot be before 'From' Year");
         }
         else
         {
         $('#exitinvestorErr').hide();
         $.ajax({
         url: 'ajxCheckDownload.php',
         dataType: 'json',
         success: function(data){
         var downloaded = data['recDownloaded'];
         var exportLimit = data.exportLimit;
         var currentRec = 807;
         
         //alert(exportLimit)
         var remLimit = exportLimit-downloaded;
         //alert(remLimit);
         
         var filterType= $(".rightpanel").find(".active").attr('value')       
         exportfiltr(1,filterType,exitglobalfilterId,exitglobalfilterNameId);
         if (currentRec < remLimit){
         hrefval= 'exportexitinExcel.php';
         $("#exitpelistingexcel").attr("action", hrefval);
         $("#exitpelistingexcel").submit();
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
         });
         
         $(document).on('click','#impshowdealsbt',function(){
         
         //$('#popup-box-copyrights').fadeOut();   
         $('#maskscreen').fadeIn();
         $('#preloading').fadeIn();  
         $('#popup-box-copyrights-filter').fadeIn(); 
         
         }); 

         function cancelFilterName()
         {
         $('#filterErr').hide()
         $('#filterDescErr').hide()
         $('#durationErr').hide()
         jQuery('#popup-box-copyrights-savefilter').fadeOut();   
         jQuery('#maskscreen').fadeOut(1000);
         $('#preloading').fadeOut();
         return false;
         }

         function ExportAdminFilter(id,name,type)
         {
               $.ajax({
                  url: 'saveFilter.php',
                  type: "POST",
                  data: {filterid: id,filterName:name,filterType:type, mode: 'adminExport'},
               success: function(data){
                  var dataval=data.replace(/[\u0000-\u0019]+/g,"")
                  var dataset=JSON.parse(JSON.stringify(dataval))
                  var dataValue=JSON.parse(dataset);

                  if(dataValue[0].filter_type =="Exit")
                     {
                        $('#exitquery').val(dataValue[0].query)
                     hrefval= 'exportexitinExcel.php';
                     $("#exitpelistingexcel").attr("action", hrefval);
                     $("#exitpelistingexcel").submit();
                     }
                     else{
                        $('#invquery').val(dataValue[0].query)

                     hrefval= 'exportinvdealsExcel.php';
                     $("#pelistingexcel").attr("action", hrefval);
                     $("#pelistingexcel").submit();
                     }
                           
               },
            });
         }
         function exportfiltrErr(exportLimit)
         {
            swal("Currently your export action is crossing the limit of "+ exportLimit +" records.  To increase the limit please contact info@ventureintelligence.com");
         }


         // function checkfilterName(filtername)
         // {
         //    $.ajax({
         //          url: 'saveFilter.php',
         //          type: "POST",
         //          data: {filtername:filtername, mode: 'getData'},
         //       success: function(data){

         //          if(data == 'failure')
         //          {
         //             swal("You are already enter the filter name")
         //             return false;
         //          }
                

         //       },
         //    });
         // }
     </script>
   </body>
</html>