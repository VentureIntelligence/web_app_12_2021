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
    $usersearch = $_POST['usersearch'];
    $fetech_by = $_POST['fetchby'];
    if(!isset($_POST['limit'])){
        
        $limit = 10;
    }else{
        
        $limit = $_POST['limit'];
    }
    
    $type = $_POST['type'];
    
    
    if($type==1){
        
        $userbydeviceSql="SELECT  COUNT(*) user_count,dealLog.EmailId,Max(dealLog.LoggedIn) as last_date, dealmembers.deviceCount FROM `dealLog` LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId WHERE `dealLog`.`EmailId` LIKE '".$usersearch."'  and PE_MA = 0 group by dealLog.EmailId";
    }elseif($type==3){
        
        $userbydeviceSql="SELECT  COUNT(*) user_count,dealLog.EmailId,Max(dealLog.LoggedIn) as last_date, malogin_members.deviceCount FROM `dealLog` LEFT JOIN malogin_members ON malogin_members.EmailId = dealLog.EmailId WHERE `dealLog`.`EmailId` LIKE '".$usersearch."'  and PE_MA = 1 group by dealLog.EmailId";
    }elseif($type==2){
        
        $userbydeviceSql="SELECT  COUNT(*) user_count,dealLog.EmailId,Max(dealLog.LoggedIn) as last_date, relogin_members.deviceCount FROM `dealLog` LEFT JOIN relogin_members ON relogin_members.EmailId = dealLog.EmailId WHERE `dealLog`.`EmailId` LIKE '".$usersearch."'  and PE_MA = 2 group by dealLog.EmailId";
    }
    if ($userdevicers = mysql_query($userbydeviceSql))
    {
       $userdevice_cnt= mysql_num_rows($userdevicers);
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

    document.log.action="userdevices.php";
    var e = document.getElementById("usersearch");
    if(e.value !=''){
        document.log.submit();  
    }else{
        alert('Please search for User by Email Id')
        return false;
    }
    
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
<!--<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> -->
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
<!--<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script>
    
    $(function() {
        
        $( "#companysearch" ).autocomplete({

            source: function( request, response ) {
            //$('#citysearch').val('');
                $.ajax({
                    type: "POST",
                    url: "ajaxuserSearch.php",
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        
                        if(data.length > 0){
                            
                            response( $.map( data, function( item ) {
                                return {
                                    label: item.label,
                                    value: item.value,
                                    id: item.id,
                                }
                            }));
                        }else{
                            var result = [
                                {
                                label: 'No result found', 
                                value: response.term
                                }
                            ];
                            response(result);
                        }
                    }
                });
            },
            minLength: 1,
            select: function( event, ui ) {
                console.log(ui);
                
                $('#company').val(ui.item.id);
                
            },
            open: function() {
      //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $('#companysearch').val()=="";
  
            }
        });
    });
</script>

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
                    <span class="tab-title" data-id="org" data-value="1"><a href="userlog.php">Organizations</a></span>
                    <span class="tab-title" data-id="ipa" data-value="2"><a href="userbyip.php">IP Addresses</a></span>
                    <span class="tab-title" data-id="use" data-value="3"><a href="topusers.php">Users</a></span>
                    <span class="tab-title" data-id="act" data-value="4"><a href="active-inactive.php">Active/Inactive</a></span>
                    <span class="tab-title" data-id="las" data-value="5"><a href="lastlogin.php">Last Login</a></span>
                    <span class="tab-title" data-id="sea" data-value="6"><a href="soreport.php">Site Search</a></span>
                    <span class="tab-title link-active" data-id="udev" data-value="7"><a href="userdevices.php">Devices</a></span>
                </div>
                <div id="maintextpro" style="background-color: #ffffff;width:100%; min-height: 738px;">
                    <div id="headingtextpro">
                        <div class="filter-sec" style="/*border:0px !important;*/">
                            <form name="log" method="post" action="" id="log">
                                <input type="hidden" name="orgsort" id="orgsort" value=<?php echo $orgsorted !='' ? $orgsorted:'desc'; ?>>
                                <input type="hidden" name="logsort" id="logsort"value=<?php echo $logsorted !='' ? $logsorted:'desc'; ?>>
                                <input type="hidden" name="datesort" id="datesort"value=<?php echo $datesorted !='' ? $datesorted:'desc'; ?>>
                                <input type="hidden" name="orgsortby" id="orgsortby" value="<?php echo $orgsortby !='' ? $orgsortby:0; ?>">
                                <input type="hidden" name="logsortby" id="logsortby" value="<?php echo $logsortby !='' ? $logsortby:0; ?>">
                                <input type="hidden" name="datesortby" id="datesortby" value="<?php echo $datesortby !='' ? $datesortby:0; ?>">
                                <input type="hidden" name="fetchby" value="1">  
                                
                                <div class="ftype-wrapper">
                                    <span class="filter-label">Type</span>
                                <div class="f-type type-title">
                                        
                                    <div class="filter-value">
                                        <select name="type" id="type">
                                            <option value="1" <?php if($_POST['type']==1){  echo 'SELECTED'; } ?>>PE</option>
                                            <option value="2" <?php if($_POST['type']==2){  echo 'SELECTED'; } ?>>RE</option>
                                            <option value="3" <?php if($_POST['type']==3){  echo 'SELECTED'; } ?>>M&A</option>
                                        </select>
                                    </div>
                                </div>
                                </div>
                             <div class="ftype-wrapper">   
                                 <span class="filter-label comp-label">User</span>
                                <div class="f-type">
                                
                                <div class="filter-value">
                                    <input type="text" value="<?php echo $_POST['usersearch']!='' ? $_POST['usersearch']: ""; ?>" id="usersearch" name="usersearch" size="18" placeholder="search" style="width:200px !important;">
<!--                                    <input type="hidden" value="<?php echo $_POST['company']!='' ? $_POST['company']: ""; ?>" id="company" name="company" >-->
                                </div>
                            </div>
                            </div>
                            <div class="f-type">
                                 <input type="hidden" name="limit" id="limit" value=""> 
                                <span style="" class="one">
                                    <input type="button" value="Fetch" name="search" onclick="findEmails();">
                                </span>
                            </div>
                            
                                <?php if($userdevice_cnt > 0){ ?>
                                <div class="f-type export-sec" onclick="orguserexport();">
                                    <span> <i>Export All</i>
                                        <input type="button" value="Export" name="soexport">
                                    </span>
                                </div>
                                <?php } ?>
                            </form>
                        </div> 
                        <form name="export"  method="post" action="" >                              
                            <input type="hidden" name="usersearch" value=<?php echo $usersearch; ?>>
                            <input type="hidden" name="sortby" value="<?php echo $exportsortby; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="hidden" name="fetchby" value="10">
                            
                        </form>

                    <div id="pe-section" class="pe-section">
                        <div class="all-items">
                            
                            
                            <div class="all-content pe-org" id="las">
                                <div class="title-sec">
                                    <div class="dev-num">
                                        #
                                    </div>
                                    <div>
                                        <span>Email Id</span>
                                    </div>
                                    <div class="text-right dev-login">
                                        <span># Logins </span>
                                    </div>
                                    <div>
                                        <span>Last Login </span>
                                    </div>
                                    <div>
                                        <span>Device Count</span>
                                    </div>
                                    <div></div>
                                </div>
                                
                                <?php 
                       
                                    if ($userdevice_cnt > 0)
                                    {
                                        $org=1; 
                                        While($myrow=mysql_fetch_array($userdevicers, MYSQL_BOTH))
                                        { 
                                        ?>
                                            <div class="content-sec">
                                                
                                                <div class="s-no-dev"><span><?php echo $org; ?></span></div>
                                                <div class="o-name"><span><?php echo $myrow['EmailId']; ?></span></div>
                                                <div class="dev-num-logins  text-right"><span><?php echo  $myrow['user_count']; ?></span></div>
                                                <div class="las-login"><span><?php echo  date('d-M-Y',  strtotime($myrow['last_date'])); ?></span></div>
                                                <div class="count-login text-right"><span><?php echo $myrow['deviceCount']; ?></span></div>
                                                
                                                
                                                </div>
                                            <?php
                                                $org++;
                                            }

                                        }else{ 

                                            echo '<div class="content-sec notdata"> No data found. Please search by Users email Id</div>';
                                        }
                                
                            ?>
                                
                            </div>
                            
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
                            $('#log').submit();
                        });
                            
                        $(document).on('change', '#type', function() {

                            if($('option:selected',this).attr('value')==1){
                                $('.datepick').show();
                            }else{
                                $('.datepick').hide();
                            }
                        });
                        
                        $(document).on('click', '#orgsort', function() {
                            
                             $( '#limit' ).val($( '#count' ).val());
                             $( '#orgsortby' ).val("1");
                             $( '#logsortby' ).val("0");
                             $( '#datesortby' ).val("0");
                             
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
                             $( '#datesortby' ).val("0");
                             $( '#logsortby' ).val("1");
                             if($( this ).attr('data-sortby')=='asc'){
                                 $( '#logsort' ).val("desc");
                             }else{
                                 $( '#logsort' ).val("asc");
                             
                             }
                             $( '#log' ).submit();
                         });
                         
                         $(document).on('click', '#datesort', function() {
                            
                             $( '#limit' ).val($( '#count' ).val());
                             $( '#orgsortby' ).val("0");
                             $( '#logsortby' ).val("0");
                             $( '#datesortby' ).val("1");
                             
                             if($( this ).attr('data-sortby')=='asc'){
                                 $( '#datesort' ).val('desc');
                             }else{
                                 $( '#datesort' ).val('asc');
                             
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