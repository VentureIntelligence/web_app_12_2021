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
    
    $type_result = $_POST['type_result'];
    
    if( $type_result==2 && $type==1 ){
        
        
        $company_name = $_POST['compname'];
        $company_name = str_replace("www.", "", $company_name);
        $bycompany_name = " and dealLog.EmailId REGEXP '[[:<:]]".$company_name."[[:>:]]' ";
        
    }elseif( $type_result==2 && $type==2 ){
        
        $company_name = $_POST['compname'];
        $company_name = str_replace("www.", "", $company_name);
        $bycompany_name = " and userlog_device.EmailId REGEXP '[[:<:]]".$company_name."[[:>:]]' ";
        
    }else{
        
        $bycompany_name = "";
        
    }
    
    // ---------------------sort code-------------------
    
    if(isset($_POST['orgsortby']) && $_POST['orgsortby']==1)
    {   
        
        if(!isset($_POST['orgsort'])){

            $orgsort = ' domain desc';
        }else{
            $orgsort = ' domain '.$_POST['orgsort'];
            $orgsorted = $_POST['orgsort'];
            
        }
        $orgsortby = 1;
    }else{
        $orgsort = '';
        $orgsortby = 0;
    }
    
    if(isset($_POST['logsortby']) && $_POST['logsortby']==1)
    { 
        if(!isset($_POST['logsort'])){

            $logsort = ' email_count desc';
        }else{

            $logsort = ' email_count '.$_POST['logsort'];
            $logsorted = $_POST['logsort'];

        }
        $logsortby = 1;
    }else{
        $logsort = '';
        $logsortby = 0;
    }
    
    if(!isset($_POST['orgsortby']) && !isset($_POST['logsortby']) || ($_POST['orgsortby']==0 && $_POST['logsortby']==0))
    { 
        $order_by = ' email_count desc';
    }
    
    $exportsortby = $logsort . $orgsort . $order_by;
    
    // ---------------------sort code end-------------------
    
    $stryear = strtotime('-1 year');
    $fromdate = date("Y-m-d",$stryear);
    $todaysdate=date("Y-m-d");
    
    //echo "<br>*******-".$logindate;
    if(($logdate1=="") || ($logdate2==""))
    {
        //	echo "<Br>empty dates";
        $querydate="";
        $allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d' ) between '" . $fromdate. "' and '" . $todaysdate . "'";
        //	echo "<Br>All Query string- " .$allquerydate;
        //$allquerydate="" ;
    }
    else
    {
        $querydate=" and DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
        $allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
        //	echo "<Br>--All Query string- " .$allquerydate;
    }

    
    
    if($type==1){
        
        $UserorgSql="SELECT substring_index(EmailId, '@', -1) domain, COUNT(*) email_count FROM dealLog " .$allquerydate." and PE_MA = 0 and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1) NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', -1) ORDER BY ".$logsort ." ".$orgsort. $order_by."  LIMIT $limit";
        if ($userorgrs = mysql_query($UserorgSql))
        {
            $userorg_cnt = mysql_num_rows($userorgrs);
        }
    }else{

        $cfsorgSql="SELECT substring_index(EmailId, '@', -1) domain, COUNT(*) email_count FROM userlog_device where dbTYpe = 'CFS' and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1) NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', -1) ORDER BY ".$logsort ." ".$orgsort. $order_by."  LIMIT $limit";
        if ($cfsuserorgrs = mysql_query($cfsorgSql))
        {
            $cfsuserorg_cnt = mysql_num_rows($cfsuserorgrs);
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

    document.log.action="userlog.php";
    
    var e = document.getElementById("type_result");
    var type_result = e.options[e.selectedIndex].value;
    
    if(type_result == 2){
        
        
        if(document.getElementById("compname").value == ''){
            
            alert('Please enter company domain address');
            return false;
        }else{
            
           
            var pattern = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;    

            if(!pattern.test(document.getElementById("compname").value)){
                alert('Please enter Valid domain address');
                return false;
            }
        }
    }
    
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
<!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
<SCRIPT>
   call()
</script>-->
	<div style="width:565px; float:left; padding-left:2px;">
            <div style=" width:565px;  margin-top:4px;">
                <div class="tab-header">
                    <span class="tab-title link-active" data-id="org" data-value="1"><a href="userlog.php">Organizations</a></span>
                    <span class="tab-title" data-id="ipa" data-value="2"><a href="userbyip.php">IP Addresses</a></span>
                    <span class="tab-title" data-id="use" data-value="3"><a href="topusers.php">Users</a></span>
                    <span class="tab-title" data-id="act" data-value="4"><a href="active-inactive.php">Active/Inactive</a></span>
                    <span class="tab-title" data-id="las" data-value="5"><a href="lastlogin.php">Last Login</a></span>
                    <span class="tab-title" data-id="sea" data-value="6"><a href="soreport.php">Site Search</a></span>
                    <span class="tab-title " data-id="udev" data-value="7"><a href="userdevices.php">Devices</a></span>
                </div>
                <div id="maintextpro" style="background-color: #ffffff;width:100%; min-height: 738px;">
                    <div id="headingtextpro">
                        <div class="filter-sec" style="/*border:0px !important;*/">
                            <form name="log" method="post" action="" id="log">
                                <input type="hidden" name="orgsort" id="orgsort" value=<?php echo $orgsorted !='' ? $orgsorted:'desc'; ?>>
                                <input type="hidden" name="logsort" id="logsort"value=<?php echo $logsorted !='' ? $logsorted:'desc'; ?>>
                                <input type="hidden" name="orgsortby" id="orgsortby" value="<?php echo $orgsortby !='' ? $orgsortby:0; ?>">
                                <input type="hidden" name="logsortby" id="logsortby" value="<?php echo $logsortby !='' ? $logsortby:0; ?>">
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
                                    <div class="f-type">
                                    <div class="filter-value">
                                        <input type="text" name="date1" value="<?php echo $logdate1 !='' ? $logdate1:$fromdate; ?>" size="15" placeholder="yyyy-mm-dd" id="fromdate">
                                    </div>
                                </div>
                                </div>

                                <div class="ftype-wrapper datepick">
                                    <span class="filter-label">To</span>
                                    <div class="f-type">
                                    <div class="filter-value">
                                        <input type="text" name="date2" value="<?php echo $logdate2 !='' ? $logdate2:$todaysdate; ?>" size="15" placeholder="yyyy-mm-dd" id="todate">
                                    </div>
                                </div>
                                </div>

                                <div class="ftype-wrapper comp_div">
                                    <span class="filter-label">By</span>
                                    <div class="f-type type-title">
                                        <div class="filter-value">
                                            <select name="type_result" id="type_result">
                                                <option value="1" <?php if($_POST['type_result']==1){  echo 'SELECTED'; } ?>>All</option>
                                                <option value="2" <?php if($_POST['type_result']==2){  echo 'SELECTED'; } ?>>Company</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="comp-name" style="display: <?php echo $_POST['type_result'] ==2 ? '':none; ?>" id="comp_name">
                                        <input type="text" name="compname" id="compname" value="<?php echo $_POST['compname'] !='' ? $_POST['compname']:''; ?>" placeholder="Search by domain">
                                    </div>
                                </div>

                                <div class="f-type filter-btn">
                                    <input type="hidden" name="fetchby" value="1">   
                                    <input type="hidden" name="limit" id="limit" value=""> 
                                    <span style="" class="one">
                                        <input type="button" value="Fetch" name="search" onclick="findEmails();">
                                    </span>
                                </div>
                                <?php if($userorg_cnt > 0 || $cfsuserorg_cnt > 0){ ?>
                                <div class="f-type export-sec" onclick="orguserexport();">
                                    <span> <i>Export All</i>
                                        <input type="button" value="Export" name="soexport">
                                    </span>
                                </div>
                                <?php } ?>
                            </form>
                        </div> 
                        <form name="export"  method="post" action="" >
                                
                                <input type="hidden" name="date1" value="<?php echo $logdate1 !='' ? $logdate1:$fromdate; ?>">
                                <input type="hidden" name="date2" value="<?php echo $logdate2 !='' ? $logdate2:$todaysdate; ?>">
                                <input type="hidden" name="sortby" value="<?php echo $exportsortby; ?>">
                                <input type="hidden" name="searchby" value="<?php echo $bycompany_name; ?>">
                                <?php if($type==1){ ?>
                                
                                    <input type="hidden" name="fetchby" value="1">
                                <?php }else{ ?>
                                    
                                    <input type="hidden" name="fetchby" value="4">
                                <?php } ?>
                        </form>
                   
<!--                    <div class="filter-sec filter-sec1">
                        <form name="logcom" id="log" method="post" action="">
                            <?php /*if($_POST['fetchby']==2){ ?>
                                <input type="hidden" name="fetchby" value="2">  
                            <?php }else{ ?>
                                <input type="hidden" name="fetchby" value="1">  
                            <?php } */ ?>
                            
                            <div class="f-type type-title">
                                <span class="filter-label">Type</span>
                                <div class="filter-value">
                                    <select name="type">
                                        <option>PE</option>
                                        <option>CFS</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="f-type type-title">
                                <span class="filter-label">Status</span>
                                <div class="filter-value">
                                    <select name="type" class="status-select">
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="f-type">
                                <span class="filter-label comp-label">Company</span>
                                <div class="filter-value">
                                    <input type="text" name="date1" value="07/12/2018" size="15" placeholder="yyyy-mm-dd" id="fromdate2">
                                </div>
                            </div>
                            
                            <div class="f-type">
                                 
                                <span style="" class="one">
                                    <input type="button" value="Fetch Logs" name="search" onclick="findEmails();">
                                </span>
                            </div>

                            <div class="f-type export-sec">
                                <span> <i>Export</i>
                                    <input type="button" value="Export" name="soexport" onclick="orguserexport();">
                                </span>
                            </div>
                                    
                        </form>
                    </div>-->


                    <div id="pe-section" class="pe-section">
                        <div class="all-items">
                            
                            
                            <div class="all-content pe-org" id="org">
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
                                        <span>Organization name <i class="sort" id="orgsort" data-sortby="<?php echo $orgsorted !='' ? $orgsorted:'desc'; ?>"></i></span>
                                    </div>
                                    <div class="text-right">
                                        <span># Logins <i class="sort" id="loginsort" data-sortby="<?php echo $logsorted !='' ? $logsorted:'desc'; ?>"></i></span>
                                    </div>
                                    <div></div>
                                </div>
                                
                                <?php 
                                
                                if($type == 1){
                                    
                                    if ($userorg_cnt > 0)
                                    {
                                        $org=1; 
                                        While($myrow=mysql_fetch_array($userorgrs, MYSQL_BOTH))
                                        { 
                                        ?>
                                            <div class="content-sec">
                                                <div class="s-no"><span><?php echo $org; ?></span></div>
                                                <div class="o-name"><span><?php echo $myrow['domain']; ?></span></div>
                                                <div class="expand-icon"><span class="zmdi zmdi-chevron-down"></span></div>
                                                <div class="num-logins  text-right"><span><?php echo  $myrow['email_count']; ?></span></div>
                                                <div class="inner-content">
                                                    <div class="inner-cont-title">
                                                            <div>#</div>
                                                            <div>Email ID</div>
                                                            <div class="text-right"># Logins</div>
                                                    </div>
                                                    <div class="inner-content-all">
                                                    <?php 

                                                           $userbyorgSql="SELECT substring_index(dealLog.EmailId, '@', 1) User, COUNT(*) user_count, dealmembers.Name,dealLog.EmailId FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId ".$allquerydate." and dealLog.EmailId LIKE '%".$myrow['domain']."%' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY user_count desc";   

                                                            if ($userrs = mysql_query($userbyorgSql))
                                                            {
                                                                $user_cnt = mysql_num_rows($userrs);
                                                            }
                                                            if ($user_cnt > 0)
                                                            {
                                                                $us=1;
                                                                While($myrow=mysql_fetch_array($userrs, MYSQL_BOTH))
                                                                { 

                                                                ?>

                                                                    <div><div><?php echo $us; ?></div>
                                                                    <div>
                                                                    <?php /*if($myrow['Name']!=''){
                                                                        
                                                                        echo $myrow['Name']; 
                                                                    }else{
                                                                        echo $myrow['User']; 
                                                                    } */
                                                                        echo $myrow['EmailId'];
                                                                    ?>
                                                                    </div>
                                                                    <div class="text-right"><?php echo $myrow['user_count']; ?></div></div>

                                                            <?php     
                                                                    $us++;   
                                                                }

                                                            }else{
                                                                echo '<div class="content-sec notdata"> No data found.</div>';
                                                            }
                                                        ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                $org++;
                                            }

                                        }else{ 

                                            echo '<div class="content-sec notdata"> No data found.</div>';
                                        }
                                }else{
                                    
                                    if ($cfsuserorg_cnt > 0)
                                    {
                                        $org=1; 
                                        While($myrow=mysql_fetch_array($cfsuserorgrs, MYSQL_BOTH))
                                        { 
                                        ?>
                                            <div class="content-sec">
                                                <div class="s-no"><span><?php echo $org; ?></span></div>
                                                <div class="o-name"><span><?php echo $myrow['domain']; ?></span></div>
                                                <div class="expand-icon"><span class="zmdi zmdi-chevron-down"></span></div>
                                                <div class="num-logins  text-right"><span><?php echo  $myrow['email_count']; ?></span></div>
                                             
                                                
                                                <div class="inner-content">
                                                    <div class="inner-cont-title">
                                                            <div>#</div>
                                                            <div>Email ID</div>
                                                            <div class="text-right"># Logins</div>
                                                    </div>
                                                    <div class="inner-content-all">
                                                    <?php 
                                                    
                                                        $cfsuserbyorgSql="SELECT substring_index(EmailId, '@', 1) User, COUNT(*) user_count,users.firstname as username,EmailId FROM userlog_device LEFT JOIN users ON users.username = userlog_device.EmailId where EmailId LIKE '%".$myrow['domain']."%' and dbTYpe = 'CFS' GROUP BY substring_index(EmailId, '@', 1) ORDER BY user_count desc limit 10";
                                                        if ($userrs = mysql_query($cfsuserbyorgSql))
                                                        {
                                                            $user_cnt = mysql_num_rows($userrs);
                                                        }
                                                        if ($user_cnt > 0)
                                                        {
                                                            $us=1;
                                                            While($myrow=mysql_fetch_array($userrs, MYSQL_BOTH))
                                                            { 

                                                            ?>
                                                                <div><div><?php echo $us; ?></div>
                                                               
                                                                <div>
                                                                    <?php /*if($myrow['username']!=''){
                                                                        
                                                                        echo $myrow['username']; 
                                                                    }else{
                                                                        echo $myrow['User']; 
                                                                    }*/
                                                                    
                                                                    echo $myrow['EmailId']; ?>
                                                                </div>
                                                                <div class="text-right"><?php echo $myrow['user_count']; ?></div></div>

                                                            <?php     
                                                                $us++;   
                                                            }

                                                        }else{
                                                            echo '<div class="content-sec notdata"> No data found.</div>';
                                                        }
                                                    ?>
                                                        </div>
                                                    </div>
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
                            
                            
                 
                            
<!--                             <div class="all-content" id="act">
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
                                        <span>Organization name</span>
                                    </div>
                                    <div class="text-right">
                                        <span>No. of login times</span>
                                    </div>
                                    <div></div>
                                </div>
                                <div class="content-sec">
                                    <div class="s-no"><span>1</span></div>
                                    <div class="o-name"><span>Ventureintelligence.com</span></div>
                                    <div class="num-logins  text-right"><span>1000</span></div>
                                    <div class="expand-icon"><span class="zmdi zmdi-chevron-down"></span></div>
                                    <div class="inner-content">
                                            <div class="inner-cont-title">
                                                <div>#</div>
                                                <div>Name</div>
                                                <div class="text-right">No. of login times</div>
                                            </div>
                                            
                                        <div class="inner-content-all">
                                            <div>
                                                <div>1</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>2</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>3</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>4</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>5</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>6</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                        </div>
                                            
                                    </div>
                                </div>
                                <div class="content-sec">
                                    <div class="s-no"><span>2</span></div>
                                    <div class="o-name"><span>Ventureintelligence.com</span></div>
                                    <div class="num-logins  text-right"><span>1000</span></div>
                                    <div class="expand-icon"><span class="zmdi zmdi-chevron-down"></span></div>
                                    <div class="inner-content">
                                        <div class="inner-cont-title">
                                            <div>#</div>
                                            <div>Name</div>
                                            <div class="text-right">No. of login times</div>
                                        </div>

                                        <div class="inner-content-all">
                                            <div>
                                                <div>1</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>2</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>3</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            
                            
<!--                               <div class="all-content" id="las">
                                    <div class="title-sec">
                                    <div>
                                        <select name="count">
                                            <option>10</option>
                                            <option>20</option>
                                            <option>30</option>
                                            <option>40</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>
                                    <div>
                                        <span>Organization name</span>
                                    </div>
                                    <div class="text-right">
                                        <span>No. of login times</span>
                                    </div>
                                    <div>
                                        <span>Last Login</span>
                                    </div>
                                </div>
                                <div class="content-sec">
                                    <div class="s-no"><span>1</span></div>
                                    <div class="o-name"><span>Ventureintelligence.com</span></div>
                                    <div class="num-logins  text-right"><span>1000</span></div>
                                    <div class="las-login"><span>12.05.2013</span></div>
                                    <div class="inner-content">
                                            <div class="inner-cont-title">
                                                <div>#</div>
                                                <div>Name</div>
                                                <div class="text-right">No. of login times</div>
                                            </div>
                                            
                                        <div class="inner-content-all">
                                            <div>
                                                <div>1</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>2</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>3</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>4</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>5</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>6</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                        </div>
                                            
                                    </div>
                                </div>
                                
                                
                                <div class="content-sec">
                                    <div class="s-no"><span>2</span></div>
                                    <div class="o-name"><span>Ventureintelligence.com</span></div>
                                    <div class="num-logins  text-right"><span>1000</span></div>
                                    <div class="las-login"><span>12.05.2013</span></div>
                                    <div class="inner-content">
                                        <div class="inner-cont-title">
                                            <div>#</div>
                                            <div>Name</div>
                                            <div>No. of login times</div>
                                        </div>

                                        <div class="inner-content-all">
                                            <div>
                                                <div>1</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>2</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            <div>
                                                <div>3</div>
                                                <div>Arun</div>
                                                <div>150</div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            
<!--                            <div class="all-content" id="sea">
                                <div class="title-sec">
                                    <div>
                                        <select name="count">
                                            <option>10</option>
                                            <option>20</option>
                                            <option>30</option>
                                            <option>40</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>
                                    <div>
                                        <span>User</span>
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
                                <div class="content-sec">
                                    <div class="s-no"><span>1</span></div>
                                    <div class="ip-add"><span>team@kutung.com</span></div>
                                    <div class="o-name"><span>PEPSICO INDIA HOLDINGS PRIVATE LIMITED</span></div>
                                    <div class="result"><span>Yes</span></div>
                                    <div class="date-login"><span>12/05/2016</span></div>
                                    <div class="det-link"><span><a href="" title="http://localhost/vigit/vi/adminvi/userlog-dummy.php">Go</a></span></div>
                             
                                </div>
                                
                            </div>-->
                        </div>
                </div>
                    
                   
                <script type="text/javascript">
                    $(function(){
                        
                        $('.loader-wrapper').hide();
                        $("body").removeClass("overlay");
                        
                        $(document).on('click', '.ip-link', function() {
                            
                             $( '#ipaddress' ).val($( this ).attr('data-ip'));
                             $( '#ipdetails' ).submit();
                         });

                        if($('option:selected','#type').attr('value')==1){
                            $('.datepick').show();
                        }else{
                            $('.datepick').hide();
                        }

                        $(document).on('change', '.org-pe-count', function() {

                            $('#limit').val($('option:selected',this).attr('value'));
                            $('#limit').val($('option:selected',this).attr('value'));
                            $('#log').submit();
                        });
                            
                        $(document).on('change', '#type_result', function() {

                            $('#compname').val('');
                            if($( this ).val()==2){
                                $('#comp_name').show();
                            }else{
                                $('#comp_name').hide();
                            }
                        });
                            
                            
                        $(document).on('change', '#type', function() {

                            if($('option:selected',this).attr('value')==1){
                                $('.datepick,.comp_div').show();
                            }else{
                                $('.datepick').hide();
                            }


                        });
                        
                        $(document).on('click', '#orgsort', function() {
                            
                             $( '#limit' ).val($( '#count' ).val());
                             $( '#orgsortby' ).val("1");
                             $( '#logsortby' ).val("0");
                             
                             if($( this ).attr('data-sortby')=='asc'){
                                 $( '#orgsort' ).val('desc');
                             }else{
                                 $( '#orgsort' ).val('asc');
                             
                             }
                             $( '#log' ).submit();
                         });
                         
                         $(document).on('click', '#loginsort', function() {
                            
                             $( '#limit' ).val($( '#count' ).val());
                             $( '#orgsortby' ).val("0");
                             $( '#logsortby' ).val("1");
                             if($( this ).attr('data-sortby')=='asc'){
                                 $( '#logsort' ).val("desc");
                             }else{
                                 $( '#logsort' ).val("asc");
                             
                             }
                             $( '#log' ).submit();
                         });
                             
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
        <div id="copyright">©  TSJ Media Pvt. Ltd</div>
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
?>