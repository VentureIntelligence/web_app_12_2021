<?php include_once("../globalconfig.php"); ?>
<?php
   session_start();
   $username= $_SESSION[ 'name' ];	
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
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
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
         border-radius: 20px;
         width: 40%;
         }
         ul.token-input-list-facebook {
         width:400px;
         }
         ul.exportcolumn {
         -webkit-column-count: 4;
         -moz-column-count: 4;
         column-count: 4;
         font-size:12px;
         }
         .exportcolumn li,.copyright-body label{
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
            border-radius:1.2rem!important;
         }
         .btn-color{
            border-color: rgb(163,119,46)!important;
            background-color: rgb(163,119,46)!important;
            color:white!important;
         }
         .error
         {
            color:red;
         }
         .hide{
         display: none
         }
         /* .buttonColor{
         background-color:gray!important;
         border-radius:20px!important;
         height: 30px!important;
         }
         .buttonColor2{
         border:2px solid red!important;
         border-radius:20px!important;
         height: 30px!important;
         background-color:white!important;
         color:black!important;
         } */
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
      <?php if($vcflagValue=="0" || $vcflagValue=="1" || $vcflagValue=="2")
         {
             $actionlink="index.php?value=".$vcflagValue;
         }
         else 
         {
                 $actionlink="svindex.php?value=".$vcflagValue;
         }
         ?>
      <!--<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    -->
      <section>
         <form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">
            <div id="header">
               <table cellpadding="0" cellspacing="0">
                  <tr>
                     <td class="left-box">
                        <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div>
                     </td>
                     <td class="right-box">
                        <?php include('top_export_submenu.php'); ?>
                        <ul class="fr">
                           <li class="classic-btn tour-lock"><a class="export_new" id="savefiltersbt" name="savefilterbtn" style="border-radius: 15px;opacity:1">saved Filters</a></li>
                           <li class="classic-btn tour-lock" style="display:none"><a href="pefaq.php" id="faq-btn" style="opacity: 1;">FAQ</a></li>
                           <!--    <li class="classic-btn tour-lock"><a href="http://www.ventureintelligence.com/deals/dealhome.php" >Classic View</a></li>-->
                           <?php //include('TourStartbtn.php'); ?>
                           <li style="display:none">
                              <div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" id="searchallfield" name="searchallfield" placeholder="Search"
                                 value="<?php if($searchallfield!="") echo $searchallfield; ?>" style="padding:5px;"  /> 
                                 <input type="button" name="fliter_stage" id="fliter_stage" value="Go" style="padding: 5px;"/>
                              </div>
                           </li>
                           <input type="hidden" value="remove" name="searchallfieldHide" id="searchallfieldHide" />
                           <?php if($_SESSION['student']!="1") { ?>   
                           <li class="user-avt" id="accoutlist" ><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
                              <?php } 
                                 else {
                                 ?>       
                           <li class="user-avt" style="display:none">
                              <span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
                              <?php    
                                 }?>
                              <?php if($_SESSION['student']!="1") { ?>
                              <div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
                                 <ul class="dropdown-menu">
                                    <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                                    <li class="o_link"><a href="../malogin.php" target="_blank">M&A Deals Database</a></li>
                                    <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                                    <li><a href="changepassword.php?value=P">Change Password</a></li>
                                    <li id="logout"><a href="logoff.php?value=P">Logout</a></li>
                                 </ul>
                              </div>
                              <?php } ?>
                           </li>
                        </ul>
                     </td>
                  </tr>
               </table>
            </div>
            <!--</form>
               <form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">  -->
            <?php
               $passwrd = $_GET['value'];
               if($passwrd != 'P')
               {
               ?>
            <!--div id="sec-header" class="sec-header-fix"-->
            <div id="sec-header" class="sec-header-fix dealsindex">
               <table cellpadding="0" cellspacing="0">
                  <tr>
                     <?php
                        if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
                        {
                        ?>
                     <!--<td class="vertical-form" id="disselect">-->
                     <?php
                        }
                        else
                        {
                        ?>
                     <!--    <td class="vertical-form">-->
                     <?php
                        }?>
                     <td class="vertical-form">
                        <h3 id="investmenttype">PE-Deals > Advanced Export</h3>
                        <?php
                           }
                           ?>
                     </td>
                  </tr>
                  </tbody>
               </table>
            </div>
         </form>
      </section>
      <section>
         <div class="container-fluid">
         <div class="row" style="margin-top:7%">
            <div class="col-md-9">
               <div class="ml-3 mt-3">
                     <h6>Search Investors</h6>
                     <p style="font-size: 12px;">you are allowed to add up to 50 investors by typing (auto suggest)</p>
                     <h6>Investor</h6>
                     <div class="block">
                        <ul style="display:flex">
                        <div class="row">
                            <div class="col-md-9">
                           <li class="ui-widget" style="position: relative">
                              <div style="width:100%;">
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
                                 <input type="text" id="investorauto_sug" name="investorauto_sug" value="<?php if($iauto!='') echo  $iauto;  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
                                 <span class="error" style="display:none" id="investorErr">Enter the Investor Name</span>
                                 <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($isearch)) echo  $isearch;  ?>" placeholder="" style="width:220px;">
                                 <input type="hidden" id="invradio" name="invradio" value="<?php if($invandor!=''){echo $invandor;}else {echo 1;}?>" placeholder="" style="width:220px;"> 
                                 <!-- <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch();" style="<?php if($_POST['keywordsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>-->
                                 <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
                                 </div>
                           </li></div>
                           <div class="col-md-1">
                           <li><p style="font-size:12px;">OR</p></li></div>
                           <div class="col-md-2" >
                           <li> <span  class="one">
                           <button  class ="export_new btn bt btn-color btn-circle" style="    margin-top: -10px;" id="impshowdealsbt" name="showdealsimport">Import</button>
                           </span></li></div></div>
                        </ul>
                        </div>
                     </div>
                     <div class="row ml-3">
                        <h6>Select Duration</h6>
                                 </div>
                                 <div class="row ml-3">
                                 <div class="col-md-1"><label>From</label>
    </div>
                        <?php
                       if(!$_POST)
                       {
                        $year1=$year2=date('Y');
                        $month1='01';
                        $month2='12';
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
                        <div  class="sort-by-date">

<div class="period-date">
<label>To</label>
<SELECT NAME="month1" id="mon1" onChange="selectMonth1()">
     <OPTION id=1 value="--" selected> Month </option>
     <OPTION VALUE='1'  >Jan</OPTION>
     <OPTION VALUE='2' >Feb</OPTION>
     <OPTION VALUE='3' >Mar</OPTION>
     <OPTION VALUE='4' >Apr</OPTION>
     <OPTION VALUE='5' >May</OPTION>
     <OPTION VALUE='6' >Jun</OPTION>
     <OPTION VALUE='7' >Jul</OPTION>
     <OPTION VALUE='8' >Aug</OPTION>
     <OPTION VALUE='9' >Sep</OPTION>
     <OPTION VALUE='10'>Oct</OPTION>
     <OPTION VALUE='11'>Nov</OPTION>
    <OPTION VALUE='12'>Dec</OPTION>
</SELECT>

<SELECT NAME="year1" id="yr1"  id="year1" onChange="selectYear1()">
    <OPTION id=2 value="" selected> Year </option>
    <?php 
    $yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
    echo 'hai'.$yearsql;
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
                        $isselected = ($year1==$id) ? '' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
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

<SELECT NAME="month2" id='mon2' onChange="selectMonth2()">
      <OPTION id=1 value="--" selected> Month </option>
     <OPTION VALUE='1'>Jan</OPTION>
     <OPTION VALUE='2'>Feb</OPTION>
     <OPTION VALUE='3'>Mar</OPTION>
     <OPTION VALUE='4'>Apr</OPTION>
     <OPTION VALUE='5'>May</OPTION>
     <OPTION VALUE='6'>Jun</OPTION>
     <OPTION VALUE='7'>Jul</OPTION>
     <OPTION VALUE='8'>Aug</OPTION>
     <OPTION VALUE='9'>Sep</OPTION>
     <OPTION VALUE='10'>Oct</OPTION>
     <OPTION VALUE='11'>Nov</OPTION>
    <option VALUE='12'>Dec</OPTION>
</SELECT>

<SELECT NAME="year2" id="yr2" onchange="selectYear2();" id='year2'>
    <option id=2 value="" selected> Year </option>
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
                        $isselected = ($year2==$id) ? '' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
                        }
      }
   ?> 
</SELECT>
 <input type="hidden" value="<?php echo $listallcompany ?>" name="listhidden" class="listhidden">
</div>
</div>
                     </div>
                     <div class="copyright-body">
                        <div class="row">   
                           <h6>Select fields for excel file export</h6>
                        </div>
                        <div style="float:right">
                           <span class="one">
                           <button  class ="export_new btn btn-circle btn-dark"  id="expshowdealsbt" name="showdeals">Export</button>
                           </span>
                           <span class="one">
                           <button class ="export_new btn btn-circle btn-secondary" id="saveshowdealsbt" name="showdeals">Save Filter</button>
                           </span>
                        </div>
                        <label style="font-weight: 600;font-size: 14px;"><input type="checkbox" class="allexportcheck" id="allexportcheck" checked/> Select All</label>
                        <div class="row ml-1">
                           <ul class="exportcolumn">
                              <!-- <li><input type="checkbox" class="companyexportcheck" name="skills" value="Company" checked/> <span> Company</span></li> -->
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Company"/> <span> Company</span></li>
                              <!-- <li><input type="checkbox" class="exportcheck" name="skills" value="Company Type" /> Company Type</li> -->
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Company Type" />
                              <select NAME="comptype" id="comptype" onChange="getcompanyType()">
                              <option  value="" selected> Company Type </option>
                              <option  value=""  > Both </option>
                              <option value="L" > Listed </option>
                              <option  value="U"> Unlisted </option>
                              </select>
                              </li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Industry" /> 
                              <div class="selectgroup">
                              <select name="industry"   id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
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
                    </select></div></li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Sector" /> Sector</li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Amount(US$M)" /> Amount (US$M)</li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Amount(INR Cr)" /> Amount(INR Cr)</li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Round" /> 
                              <div class="selectgroup">
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
                </div>
                              </li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Stage" /> 
                              <div class="selectgroup">
                    <select name="stage[]" multiple="multiple" size="5" id='stage' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                    <?php
	
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
                </div>
                              </li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Investors" /> Investors</li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Investor Type" />
                              <SELECT NAME="invType" id="invType" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <OPTION id="5" value="--" selected> ALL </option>
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
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Date"/> Date</li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Exit Status" />
                              <div class="selectgroup">
    <SELECT NAME="exitstatus[]" id="exitstatus" multiple="multiple" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <!--<OPTION  value="--" selected>All</option>-->
        <?php
    
            $exitstatusSql = "select id,status from exit_status";
            if ($exitstatusrs = mysql_query($exitstatusSql))
            {
              $exitstatus_cnt = mysql_num_rows($exitstatusrs);
            }
            if($exitstatus_cnt > 0)
            {
                While($myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                {
                    $id = $myrow[0];
                    $name = $myrow[1];
                    
                    if(count($exitstatusValue) > 0){
                        $isselcted = (in_array($id,$exitstatusValue))?'selected':''; 
                    }else{
                        $isselcted ='';
                    }
                    echo "<OPTION id='exitstatus_".$id. "' value=".$id." $isselcted>".$name."  </OPTION>\n";
                }
            }
        ?>
<!--       <OPTION value="1" <?php echo ($exitstatusValue=="1") ? 'SELECTED' : ""; ?>>Unexited</option>
       <OPTION  value="2" <?php echo ($exitstatusValue=="2") ? 'SELECTED' : ""; ?>>Partially Exited</option>
       <OPTION  value="3" <?php echo ($exitstatusValue=="3") ? 'SELECTED' : ""; ?>>Fully Exited</option>-->
   </SELECT>
    </div>
                              </li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Website" /> Website</li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Year Founded" /> Year Founded</li>
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
                              <li><input type="checkbox" class="exportcheck" name="skills" value="State" /> 
                              <div class="selectgroup">
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
                </div>
                              </li>
                              <li><input type="checkbox" class="exportcheck" name="skills" value="Region" /> 
                              <div class="selectgroup">
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
    </div>
                              </li>
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
                        </div>
                        <br><br><br>
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
                        </form>
                        <form name="pelistingexcelInv" id="pelistingexcelInv"  method="post" action="importexcelsheetbyname.php">
                           <input type="hidden" name="investorname" id="investorname" value="" >
                        </form>
                     </div>
               </div>
               <div class="col-md-3 border">
                  <!-- <div class="border w-100" style="height:auto"> -->
                  <div class="row border d-flex justify-content-center">
                     <h5 class="p-2">Saved Fliters</h5>
                  </div>
                  <div class="row">
                     <ul class="list-group list-group-flush border w-100" id="getFilterName">
                     </ul>
                  </div>
                  <div class="footer" >
                     <div class="row border-top p-2" style="width:114%">
                        <div class="col-md-4">
                           <button type="button" class="btn btn-outline-secondary btn-circle btn-sm" onClick="exportfiltr();">Export</button>
                        </div>
                        <div class="col-md-3">
                           <button type="button" class="btn btn-outline-dark btn-circle btn-sm" onClick="EditFilter();">Edit</button>
                        </div>
                        <div class="col-md-5">
                           <button type="button" class="btn btn-outline-danger btn-circle btn-sm" onClick="deleteFilter();">Delete</button>
                        </div>
                     </div>
                     <!-- </div> -->
                  </div>
               </div>
            </div>
            <input type="hidden" value="A" id="mode">
         </div>
      </section>
      <div class="lb" id="popup-box-copyrights-filter" style="width:650px !important;">
         <span id="expcancelbtn-filter" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
         <form name="dealsupload" enctype="multipart/form-data" id="leaguefile" method="post" >
            <div class="accordian">
               <h3 class="acc-title" style="padding:10px;    text-align: center;"><span>Upload excel File</span> <i class="zmdi zmdi-chevron-down"></i></h3>
               <div class="acc-content">
                  <div class="upload-sec" style="padding:10px"> 
                     <input type="file" name="leaguefilepath" class="ip-file">
                     <input type="hidden" name="username" value="<?php echo $username; ?>">
                  </div>
                  <div class="btn-sec text-right" style="padding:10px">
                     <input type="button" class="btn" value="Upload" onClick="getLeagueImport();">
                  </div>
               </div>
            </div>
         </form>
      </div>
      <div class="lb" id="popup-box-copyrights-savefilter" style="width:650px !important;">
         <span id="expcancelbtn-savefilter" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
         <form name="dealsupload" id="leaguefile" method="post" >
            <div class="accordian">
               <h5 class="acc-title" style="padding:10px;text-align: center;"><span>Save Filter</span> <i class="zmdi zmdi-chevron-down"></i></h5>
               <div class="acc-content ">
               <div class="row">
               <div class="col-md-4">
                  <span style="font-weight: bold;margin-left: 80px;">Filter Name:</span></div>
                  <div class="col-md-7"> <input type="text" name="filtername" id="filter_name" class="form-control">
                  <span class="error" style="display:none" id="filterErr">Please Enter the Filter Name<span>
                  </div></div><br>
                  <div class="row"><div class="col-md-4">
                  <span style="font-weight: bold;margin-left: 50px;">Filter Description:</span></div>
                  <div class="col-md-7">
                   <textarea name="filterdesc" id="filter_desc" class="form-control"></textarea></div></div>
                  <div class="btn-sec text-right" style="padding:20px">
                     <button type="button" class="btn btn-circle btn-dark btn-circle btn-sm" style="width: 100px;"  onClick="saveFilterName();">Save</button>
                     <button type="button" class="btn btn-outline-dark btn-circle btn-sm" style="width: 100px;"  onClick="cancelFilterName();">Cancel</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
      <script>
      var filterDescrip='';
         $(document).ready(function(){ 
         
         $('.exportcolumn .exportcheck').attr('checked', true); 
         $(".resultarray").val('Select-All');
         getfilterName();
         var currentURL=window.location.href;
         //alert(currentURL);
         if(currentURL)
         {
             var createElement=document.createElement("link");
             createElement.rel="stylesheet";
             createElement.href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css";
             //createElement.integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm";
             //createElement.crossorigin="anonymous";
             $('head').append(createElement);

         }
                                     
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
                     
                     });
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
         
         
         
                         $('#expshowdealsbt').click(function(){
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
         
                         $(document).on('click','#impshowdealsbt',function(){
         
                             //$('#popup-box-copyrights').fadeOut();   
                             $('#maskscreen').fadeIn();
                             $('#preloading').fadeIn();  
                             $('#popup-box-copyrights-filter').fadeIn(); 
                             
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
         
                             $(document).on('click','#saveshowdealsbt',function(){

                                 if($('#investorauto_sug').tokenInput("get").length == 0)
                                  {
                                       $('#investorErr').show();
                                 }
                                  else
                                  {
                                    $('#investorErr').hide();

                                 $('#maskscreen').fadeIn();
                                 $('#preloading').fadeIn();  
                                 $('#popup-box-copyrights-savefilter').fadeIn(); 
                                     mode=$('#mode').val();
                                         if(mode == 'A')
                                         {
                                         $('#filter_name').val('')
                                         }
                                         else
                                         {
                                             $('#filter_name').val(filterNameId);
                                             $('filter_desc').val(filterDescrip);

                                         }
                                }
                                 });
         
                                 $(document).on('click','#expcancelbtn-savefilter',function(){
                                    $('#filterErr').hide()
                                 jQuery('#popup-box-copyrights-savefilter').fadeOut();   
                                 jQuery('#maskscreen').fadeOut(1000);
                                 $('#preloading').fadeOut();
                                 return false;
                                 });

                                 function cancelFilterName()
                                 {
                                    $('#filterErr').hide()

                                    jQuery('#popup-box-copyrights-savefilter').fadeOut();   
                                 jQuery('#maskscreen').fadeOut(1000);
                                 $('#preloading').fadeOut();
                                 return false;
                                 }
         
                                 function getfilterName()
                                 {
                                 $.ajax({
                                     url: 'saveFilter.php',
                                     type: "POST",
                                     data:{mode:"saveFilter"},
                                     success: function(data){
                                         var dataVal=$.trim( data.replace( /[\s\n\r]+/g, ' ' ) ).split(',');
         
                                             var div='';
                                             if(data.trim() != "")
                                             {
                                             for(i=0;i<dataVal.length;i++)
                                             {
                                             
                                                 div +='<li class="list-group-item" onclick="activate(this)">'+dataVal[i]+'</li>'
                                             }
                                             }
                                             else{
                                                 div +='<li class="list-group-item">No Records Found</li>'
                                             }
         
                                             $('#getFilterName').html(div);
                                     },
         
                                     });
                                 }
         
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
                         $('#maskscreen').fadeOut();
                             $('#preloading').fadeOut();  
                             $('#popup-box-copyrights-filter').fadeOut();
                             for(i=0;i<dataValue.length;i++)
                             {
                             $("#investorauto_sug").tokenInput("add",{id: dataValue[i]['InvestorId'], name: dataValue[i]['Investor']});
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
             var selectedValues = $('#investorauto_sug').tokenInput("get");
             
                 for(i=0;i<selectedValues.length;i++)
                 {
                     investornameArray.push(selectedValues[i]["name"])
                 }
         var filtername=$('#filter_name').val()
         var filterDesc=$('#filter_desc').val()

         var checkboxName=$('.exportcheck:checked').map(function() {return this.value;}).get().join(',')

         if(filtername == '')
         {
            //$('.error').html('Enter the filter Name')
            $('#filterErr').show();
         }
         else
         {
            $('#filterErr').hide();
               $.ajax({
                     url: 'saveFilter.php',
                     type: "POST",
                     data: {filtername: filtername,EditFilter:filterNameId,filterDesc:filterDesc,checkboxName:checkboxName, investorval: JSON.stringify(investornameArray),mode: 'A'},
                     success: function(data){
                         swal({
                             title: "Saved Successfully!",
                             //text: "You clicked the button!",
                             icon: "success",
                             //button: "Aww yiss!",
                             });
                         //swal( "saved successfully!", "success");
                         getfilterName();
                         $('#investorauto_sug').tokenInput("clear");
                         $('.allexportcheck ').attr('checked', true); 
         
                         $('.exportcolumn .exportcheck').attr('checked', true); 
         
                         jQuery('#popup-box-copyrights-savefilter').fadeOut();   
                                 jQuery('#maskscreen').fadeOut(1000);
                                 $('#preloading').fadeOut();
                         
         
         
                     },
                     });
         }
         
         }
         var filterNameId=''
         function activate(id)
         {  
             filterNameId=id.innerText;
             var current = document.querySelector('.active');
                 if (current) {
                     current.classList.remove('active');
                 }
                 id.classList.add('active');
         
         }
         
         function exportfiltr()
         {
         
             $.ajax({
                     url: 'saveFilter.php',
                     type: "POST",
                     data: {filterName: filterNameId, mode: 'export'},
                     success: function(data){
                         var dataval=data.replace(/[\u0000-\u0019]+/g,"")
                         var dataset=JSON.parse(JSON.stringify(dataval))
                         var dataValue=JSON.parse(dataset);
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
                         $('#investorvalue').val(div);
         
                         hrefval= 'exportinvdealsExcel.php';
                                         $("#pelistingexcel").attr("action", hrefval);
                                         $("#pelistingexcel").submit();
         
                     },
             });
         }
         
         
         function deleteFilter()
         {
            if(document.getElementsByClassName("list-group-item active").length== 0)
            {
               swal('Select Filter Name');
            }
            else{
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
                              
                                 swal('Deleted successfully')
                                 $('#maskscreen').fadeOut();
                                     $('#preloading').fadeOut();  
                                     $('#popup-box-copyrights-getfilter').fadeOut(); 
                                     getfilterName();
                 
                             },
                     });
                 }
             });
            }
         
         }
         var getFilterName='';
         function EditFilter()
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
                         $('#maskscreen').fadeOut();
                             $('#preloading').fadeOut();  
                             $('#popup-box-copyrights-getfilter').fadeOut();
                             for(i=0;i<dataValue.length;i++)
                             {
                             $("#investorauto_sug").tokenInput("add",{id: dataValue[i]['InvestorId'], name: dataValue[i]['Investor']});
                             }
                             filterDescrip=$('#filter_desc').val(dataValue[0].filter_desc)

                             if(dataValue[0].column_name)
                             {
                                 $('.allexportcheck').attr('checked', true);
                                 $('.exportcheck').attr('checked', false)
                                 var columnName=dataValue[0].column_name.split(',')
                                 for(i=0;i<columnName.length;i++)
                                 {
                                     $("input[value='"+columnName[i]+"']").prop('checked', true);
                                 }
                             }         
                     },
             });
         
         }
         
         function getcompanyType() {
           var companytype= $('#comptype').val()
            $('#companytype').val(companytype)
         }
         function selectMonth1()
        {
         var month1= $('#mon1').val()
            $('#month1').val(month1)
        }
        function selectMonth2()
        {
         var month2= $('#mon2').val()
            $('#month2').val(month2)
        }
        function selectYear1(){
         var year1= $('#yr1').val()
            $('#year1').val(year1)
        }
        function selectYear2(){
         var year2= $('#yr2').val()
            $('#year2').val(year2)            
        }

        $(function(){
    $("#citysearch").multiselect({noneSelectedText: 'Select City', showCheckAll:false, showUncheckAll:false, selectedList: 0}).multiselectfilter();
    //$('li:contains("Uncheck all")').css( "background-color", "red" );  
});

$(function(){
	$(".selectgroup select").multiselect();
   //  $(".selectgroup #sltindustry").multiselect({noneSelectedText: 'Select options', selectedList: 0, showCheckAll:false, showUncheckAll:false,    uncheckAllText: ''}).multiselectfilter();
    
    // $(".selectgroup #sltsector,.selectgroup #sltsubsector").multiselectfilter({noneSelectedText: 'Select options', selectedList: 0, checkAllText: '',  uncheckAllText: '', showCheckAll:false, showUncheckAll:false});
    // $(".citysearch #citysearch").multiselect({ showCheckAll:true, showUncheckAll:true}).multiselectfilter();
});

$(document).ready(function(){
  $('#citysearch').on("change",function(){
    var citytotalcount = $('#citysearch option').length; 
      var citytotalcount_selected = $('#citysearch option:selected').length;
      var allcityflag = 0;
      if(citytotalcount == citytotalcount_selected)
      {
         allcityflag = 0;
          $("#cityflag").val(allcityflag);
          $("#cityflag1").val(allcityflag);
      }
      else{  allcityflag = 1;$("#cityflag").val(allcityflag);$("#cityflag1").val(allcityflag);}
    });
});

$( "#citysearch" ).autocomplete({
         
         source: function( request, response ) {
         //$('#citysearch').val('');
             $.ajax({
                 type: "POST",
                 url: "ajaxCitySearch.php",
                 dataType: "json",
                 data: {
                     vcflag: '<?php echo $VCFlagValue; ?>',
                     search: request.term
                 },
                 success: function( data ) {
                     response( $.map( data, function( item ) {
                         return {
                             label: item.label,
                             value: item.value,
                             id: item.id
                         }
                     }));
                 }
             });
         },
         minLength: 1,
         select: function( event, ui ) {
          $('#citysearch').val(ui.item.value);
          $(this).parents("form").submit();
         },
         open: function() {
         },
         close: function() {
             $('#citysearch').val()=="";
                 }
     });

      </script>
   </body>
</html>