<?php include_once("../globalconfig.php"); ?>
<style>
    .ui-multiselect-menu.ui-widget.ui-widget-content.ui-corner-all {
        position: absolute;
        overflow: auto;
        display: none;
    }
    
    .selectgroup .ui-icon,
    .ui-helper-reset .ui-icon{
        display: inline-block;
    }
    
    .ui-multiselect-close {
        position: absolute;
        top: 5px;
        right: 3px;
        z-index: 1;
    }
    
    .ui-widget-header .ui-helper-reset {
        padding: 6px;
    }
    
    .ui-helper-reset li {
        display: inline-block;
        padding: 0 6px 0 0;
    }
    
    .ui-multiselect-checkboxes li {
        display: block;
    }
    
    .ui-helper-reset li a {
        font-size: 10px;
    }
    
    .ui-state-default .ui-icon {
        float: right;
        margin: 2px;
    }
    
    .ui-multiselect-checkboxes .ui-corner-all {
        padding: 4px;
        line-height: 28px;
    }
     .f-type.export-sec i{
        margin-top: 3px;
        margin-right: 10px;
    }
    .f-type.export-sec i b{
        margin:0px 6px;
    }
    .f-type.export-sec span:before{
        /*margin-top:3px;*/
        background:none !important;
    }
        
</style>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
    checkaccess( 'subscribers' );
//session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    //	echo "<br>1--";
    $companyIdtoEdit = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    $trialFlag="";$peindustries = array(); $maindustries = array();
    
    $getCompNameSql ="Select DCompanyName,custom_limit_enable,custom_export_limit,ExpiryDate,TrialLogin,Student,REInv,IPAdd,poc,MAMA,peindustries,maindustries,mobile_access from dealcompanies where DCompId=$companyIdtoEdit ";
    if($rsgetname =mysql_query($getCompNameSql))
    {
	//	echo "<br>2--";
        While($myrow=mysql_fetch_array($rsgetname, MYSQL_BOTH))
        {
            //		echo "<br>3--";
            $export_limit = $myrow['custom_export_limit'];
            $limit_enable = $myrow['custom_limit_enable'];


            $CompanyName=$myrow["DCompanyName"];
            $ExpDate=$myrow["ExpiryDate"];
            $trialLoginFlag=$myrow["TrialLogin"];
            $studentLoginFlag=$myrow["Student"];
            $reloginFlag=$myrow["REInv"];
            $maloginFlag=$myrow["MAMA"];
            $mobappFlag=$myrow["mobile_access"];
            $peindustries = explode(', ', $myrow["peindustries"]);
            $maindustries = explode(', ', $myrow["maindustries"]);

           
            $IpAddFlag=$myrow["IPAdd"];
            $poContact = $myrow["poc"];
            if ($poContact == '')
                $poContact = 'info@ventureintelligence.com';
            //echo "<br>--" .$studentLoginFlag;
            if($trialLoginFlag==1)
            {
//		//	echo "<br>4--";
                    $trialFlag="checked";
            }
            if($studentLoginFlag==1)
            {
                    $studentFlag="checked";
                    //echo "<Br>***".$studentFlag;
            }
            if($maloginFlag==1)
            {
                    $maflag="checked";
                    //echo "<Br>***".$studentFlag;
            }
            if($reloginFlag==1)
            {
                    $reflag="checked";
                    //echo "<Br>***".$studentFlag;
            }
            if($IpAddFlag==1)
            {
                    $ipflag="checked";
                    //echo "<Br>***".$studentFlag;
            }
            if($mobappFlag==1)
            {
                    $mobflag="checked";
                    //echo "<Br>***".$studentFlag;
            }
        }
    }  
    
    //Get IP Address - ADDED BY JFR-KUTUNG
    $sqlSelIp = "SELECT ipAddress,StartRange,EndRange FROM ipAddressKey WHERE DCompId='$companyIdtoEdit'";
    $ipContent = '';
    $ipCount = 0;
    if($rsgetip = mysql_query($sqlSelIp)){
        
        While($myIp=mysql_fetch_array($rsgetip, MYSQL_BOTH)){
            
            $usrIp = $myIp['ipAddress'];
            $usrsRng = $myIp['StartRange'];
            $usreRng = $myIp['EndRange'];
            $ipCount++;
                
            if ($ipCount==1){
                $ipContent.='
                    <p id="ipPr'.$ipCount.'">

                        <input type="text" name="ipAddress[]" placeholder="IP Address" value="'.$usrIp.'">
                        &nbsp;
                        <input type="text" name="startRange[]" placeholder="Start Range" size="7" value="'.$usrsRng.'">
                        &nbsp;
                        <input type="text" name="endRange[]" placeholder="End Range" size="7" value="'.$usreRng.'">
                        &nbsp;
                        <input type="button" name="addMore" id="addMore" value="Add More IP Range">
                    </p>';
            }else{
                $ipContent.='
                    <p id="ipPr'.$ipCount.'">
                        <input type="text" name="ipAddress[]" placeholder="IP Address" value="'.$usrIp.'">
                        &nbsp;
                        <input type="text" name="startRange[]" placeholder="Start Range" size="7" value="'.$usrsRng.'">
                        &nbsp;
                        <input type="text" name="endRange[]" placeholder="End Range" size="7" value="'.$usreRng.'">
                    </p>';
            }      
        }
    }
        
    if ($ipContent==''){
        
        $ipContent.='
            <p>
                <input type="text" name="ipAddress[]" placeholder="IP Address" value="">
                &nbsp;
                <input type="text" name="startRange[]" placeholder="Start Range" size="7" value="">
                &nbsp;
                <input type="text" name="endRange[]" placeholder="End Range" size="7" value="">
                &nbsp;
                <input type="button" name="addMore" id="addMore" value="Add">
            </p>';
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<!-- calendar stylesheet -->
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../js/jquery.validate.min.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" /> 
        <script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<style>
    .error{
        color:red;
        padding: 0px 0px 0px 10px;
    }
</style>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
 var chk = $('[name="perEmailId[]"]:checked').length;
 var chk1 = $('[name="perMAEmailId[]"]:checked').length;
 var chk2 = $('[name="perREEmailId[]"]:checked').length;
 var flaglogin;

 
 if($('[name="perEmailId[]"]:checked').length==0 && $('[name="perMAEmailId[]"]:checked').length==0 && $('[name="perREEmailId[]"]:checked').length==0)
 {
    flaglogin=0;
 }else{
    flaglogin=1;
 }
 $('.flaghidden').val(flaglogin);

});
    function deleteMembers(companyId){   
    
        var chk;
        var chk1;
        var chk2;
        var DelEmailId = new Array();
        var MADelEmailId = new Array();
        var REDelEmailId = new Array();

        chk = $('[name="DelEmailId[]"]:checked').length;
        chk1 = $('[name="MADelEmailId[]"]:checked').length;
        chk2 = $('[name="REDelEmailId[]"]:checked').length;

        $('input[name="DelEmailId[]"]:checked').each(function() {

            DelEmailId.push(this.value);
        });
        $('input[name="MADelEmailId[]"]:checked').each(function() {

            MADelEmailId.push(this.value);
        });
        $('input[name="REDelEmailId[]"]:checked').each(function() {

            REDelEmailId.push(this.value);
        });

        if ((chk > 0) || (chk1 > 0) || (chk2 > 0))
        {      
            if(confirm("Are you sure you want to delete selected members ? ")){
                var formData= new Array();
                formData.push({ name: 'DelEmailId', value: DelEmailId },{ name: 'MADelEmailId', value: MADelEmailId },{ name: 'REDelEmailId', value: REDelEmailId },{name:'companyId',value:companyId});
                $.ajax({

                    url: 'deletemembers.php',
                    type: "POST",
                    data: formData,
                    dataType:"json",
                    success: function(data) {

                    // window.location = 'https://www.ventureintelligence.com/adminvi/companyedit.php?value=1015268522';
                        window.location = '<?php echo BASE_URL; ?>adminvi/companyedit.php?value='+companyId;
                        //console.log(data.length);   
                        if(data.length > 0){
                            
                            alert("Users Deleted Successfully");
                        }else{
                            alert("User Deleted Successfully");
                        }
                       
        //                 $.each(data ,function(field,error){
        //                    console.log(error);
        //                });
                    }
                });
            }
        }
        else{

            alert("Pls select one or more to delete");
            return false;
        }
    
    }

    function permissionMembers(companyId){   
    
    var chk;
    var chk1;
    var chk2;
    var perEmailId = new Array();
    var perMAEmailId = new Array();
    var perREEmailId = new Array();
    var flaglogin = $('.flaghidden').val();
    
    chk = $('[name="perEmailId[]"]:checked').length;
    chk1 = $('[name="perMAEmailId[]"]:checked').length;
    chk2 = $('[name="perREEmailId[]"]:checked').length;
    

    $('input[name="perEmailId[]"]:checked').each(function() {

        perEmailId.push(this.value);
    });
    $('input[name="perMAEmailId[]"]:checked').each(function() {

        perMAEmailId.push(this.value);
    });
    $('input[name="perREEmailId[]"]:checked').each(function() {

        perREEmailId.push(this.value);
    });
    if ((chk > 0) || (chk1 > 0) || (chk2 > 0) ){
        flaglogin = 1;
    }

    if ( flaglogin==1)
    {      
        if(confirm("Are you sure you want to disable selected members ? ")){
            var formData= new Array();
            formData.push({ name: 'perEmailId', value: perEmailId },{ name: 'perMAEmailId', value: perMAEmailId },{ name: 'perREEmailId', value: perREEmailId },{name:'companyId',value:companyId});
            $.ajax({

                url: 'permembers.php',
                type: "POST",
                data: formData,
                dataType:"json",
                success: function(data) {

                // window.location = 'https://www.ventureintelligence.com/adminvi/companyedit.php?value=1015268522';
                    
                    //console.log(data.length);   
                    if(data.length > 0){
                        
                        alert("Users permission changed Successfully");
                    }else{
                        alert("User permission changed Successfully");
                    }
                    window.location = '<?php echo BASE_URL; ?>adminvi/companyedit.php?value='+companyId;
    //                 $.each(data ,function(field,error){
    //                    console.log(error);
    //                });
                }
            });
        }
    }
    else{

        alert("Pls select one or more user to disable");
        return false;
    }

}
    
    function ExporttoExel()
    {
        if(document.companyedit.txtStudent.checked==true)
        {
            document.companyedit.txtStudent.checked=false;
        }
    }
    
    function dealmemberexport()
    {
        document.export.action="dealcompanyexport.php";
        document.export.submit();
    }
    
    function Student()
    {
	/*if(document.companyedit.txtTrialLogin.checked==true)
	{
		document.companyedit.txtTrialLogin.checked=false;
	}*/
        
        //ADDED BY JFR-KUTUNG (For student IP Restriction is to be applied)
        if (document.companyedit.txtStudent.checked==true){
            document.companyedit.txtIPAdd.checked=true;
        }
            
    }
    //ADDED BY JFR-KUTUNG (For student IP Restriction is to be applied)
    function IPAdd(){
        
        if (document.companyedit.txtIPAdd.checked==false){
            document.companyedit.txtStudent.checked=false;
        }
    }

    $(document).ready(function(){
        
        $('#addMore').click(function(){
            var ipNum = $("#ipCount").val();
            ipNum = (ipNum * 1) + 1;
            var htmlpr = '<p id="ipPr'+ipNum+'"><input type="text" name="ipAddress[]" placeholder="IP Address" value="">&nbsp;<input type="text" name="startRange[]" placeholder="Start Range" size="7" value="">&nbsp;<input type="text" name="endRange[]" placeholder="End Range" size="7" value="">&nbsp;<img src="../dealsnew/images/cross.gif" onclick="removeip('+ ipNum +')"></p>';
            $("#ipCount").val(ipNum); 
            $("#IpRnglst").append(htmlpr);
        });
    });

    function removeip(idval){
    
        var temp = '#ipPr'+idval;
        $(temp).html('');
        $(temp).remove();
        $("#ipCount").val(idval-1);
    }

    /*function updateMembers()
    {
        //alert("99999999999999999");
        document.companyedit.action="updatemembers.php";
        document.companyedit.submit();
    }*/

    function AddMembers()
    {
        //alert("99999999999999999");
        document.companyedit.action="addcompany.php";
        document.companyedit.submit();
    }

    function resetExpLimit(){
        
        var resValue = document.getElementById('resetExp').value;
        if (resValue!=''){
            if (confirm('Are you sure to reset the export limit of all users')){
                $("[name='ExpLmt[]']").val(resValue);
                $("[name='ExpLmtMA[]']").val(resValue);
                $("[name='ExpLmtRE[]']").val(resValue);
                alert('Export Limit is set to '+resValue+'. Click Update Memebers to save. ');
            }
        }else{
            alert('Please enter the export limit');
        }
    }

    $(document).ready(function() {   
        
        $('#type_field').change(function(event) {
                    
            if($(this).val() == 1){

                $('.ip-file').val(''); 
                $('.acc-sections').hide();
                $('.form-fields').show();

            }else{

                $('input[type="text"][class="reset valid"]').val(''); 
                $('.form-fields').hide();
                $('.acc-sections').show();
            }
            //acc-section
        });
   
        $('#vconly').click(function(event) {  //on click 

            if(this.checked) { // check select status
                $('#loginerror').text('');
                $('#allpe').prop( "checked", true );
                $('.vconly').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                
                if ($('#peonly').prop('checked')==true){ 
                    $('#allpe').prop( "checked", true );
                }else{
                     $('#allpe').prop( "checked", false );
                }
                $('.vconly').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
        });
               
        $('.vconly').click(function(event) {  //on click 

            var vctotal =  $('.vconly').length;
            var vccount=0;
             $('.vconly').each(function() { //loop through each checkbox
                if(this.checked==true) { vccount++; }        
             });

            if(vccount==0){

                if ($('#peonly').prop('checked')==true){ 

                    $('#allpe').prop( "checked", true );
                }else{
                     $('#allpe').prop( "checked", false );
                }
                $('#vconly').prop( "checked", false );
            }

            if( vccount>0 ||  (vctotal == vccount) ){
                $('#loginerror').text('');
                $('#vconly').prop( "checked", true );
                $('#allpe').prop( "checked", true );
            }
        }); 
   
        $('#peonly').click(function(event) {  //on click 

            if(this.checked) { // check select status
                $('#loginerror').text('');
                $('#allpe').prop( "checked", true );
                $('.peonly').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                
                if ($('#vconly').prop('checked')==true){ 
                    $('#allpe').prop( "checked", true );
                }else{
                     $('#allpe').prop( "checked", false );
                }
                $('.peonly').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });         
            }
        });
             
        $('.peonly').click(function(event) {  //on click 

            var petotal =  $('.peonly').length;
            var pecount=0;
            $('.peonly').each(function() { //loop through each checkbox
               if(this.checked==true) { pecount++; }        
            });

            if(pecount==0){
                
                $('#peonly').prop( "checked", false );
                
                if ($('#vconly').prop('checked')==true){ 
                    
                    $('#allpe').prop( "checked", true );
                }else{
                     $('#allpe').prop( "checked", false );
                }
            }

            if( pecount>0 ||  (petotal == pecount) ){
                $('#loginerror').text('');
               $('#peonly').prop( "checked", true );
               $('#allpe').prop( "checked", true );
            }
        }); 
             
        $('#allpe').click(function(event) {  //on click 

            if(this.checked) { // check select status
                $('#loginerror').text('');
                $('#peonly').prop( "checked", true );
                $('#vconly').prop( "checked", true );
                $('.peonly').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
                $('.vconly').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"               
                });
            }else{
                $('#peonly').prop( "checked", false );
                $('#vconly').prop( "checked", false );
                $('.peonly').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                });    
                $('.vconly').each(function() { //loop through each checkbox
                    this.checked = false;  //select all checkboxes with class "checkbox1"               
                });
            }
        });
        
        $('.maonly').click(function(event) {  //on click 

            if($(this).prop('checked')==false){

                $('#allma').prop( "checked", false );
            }else{
                $('#loginerror').text('');
                $('#allma').prop( "checked", true );
            }

        }); 

        $('#allma').click(function(event) {

            if($(this).prop('checked') == false){

                $('.maonly').prop( "checked", false );
            }else{
                $('#loginerror').text('');
                $('.maonly').prop( "checked", true );
            }
        });

        $('#allre').click(function(event) {

            if($(this).prop('checked') == true){

                $('#loginerror').text('');
            }
        });
             
    });
    
    $(document).ready(function () {
              // Initialize form validation on the registration form.
              // It has the name attribute "registration"
              
        $("form[name='companyedit']").validate({
          // Specify validation rules

            rules: {
              // The key name on the left side is the name attribute
              // of an input field. Validation rules are defined
              // on the right side
                companyname: "required",
                date: "required"

            },
            messages: {
              companyname: "Please enter company name.",
              date: "Please select date."

            },
            // Make sure the form is submitted to the destination defined
            // in the "action" attribute of the form when valid
            submitHandler: function(form) {
                
                $('#loginerror,#industryerr-pe,#industryerr-ma').text('');
                if($('#sltindustrype').val()== null){

                    $('#industryerr-pe').text('Please select industry for PE.');
                    $('html, body').animate({
                        scrollTop: $('#industryerr-pe').offset().top
                        }, 1000);
                    return false;
                }

                if($('#sltindustryma').val()== null){

                    $('#industryerr-ma').text('Please select industry for MA.');
                    $('html, body').animate({
                        scrollTop: $('#industryerr-ma').offset().top
                        }, 1000);
                    return false;
                }
                        
                if($("input.logincheckbox:checked").length <= 0){
                     $('#loginerror').text('Please give access for at least one login either for PE or MA or RE Login.');
                     $('html, body').animate({
                        scrollTop: $('#loginerror').offset().top
                        }, 1000);
                    return false;
                }
                
                
                
                var mailedit = []; var nameedit=[]; var passedit=[];

                $("input[name='Mails[]']").each(function() {

                    var value = $(this).val();
                    if (value!='') {
                        $('#nameGroup').text('');
                        mailedit.push(value);
                    }else{
                        mailedit.push('');
                    }
                });
                $("input[name='Nams[]']").each(function() {

                    var value = $(this).val();
                    if (value!='') {
                        $('#nameGroup').text('');
                        nameedit.push(value);
                    }else{
                        $('#nameGroup').text('');
                        nameedit.push('');
                    }
                });

                $("input[name='Pwd[]']").each(function() {

                    var value = $(this).val();
                    if (value!='') {
                        passedit.push(value);
                    }else{
                        passedit.push('');
                    }
                });

                /*console.log(mailedit);
                console.log(nameedit);
                console.log(passedit);*/
    
                for(var i=0;i < mailedit.length; i++){

                    if(mailedit[i] !=''){

                        if(nameedit[i] =='' || passedit[i] ==''){
                            $('#listGroup').text('All the three respective fields are compulsory in list(Name, Email and Password).');
                            $('html, body').animate({
                            scrollTop: $('#listGroup').offset().top
                            }, 1000);
                            return false;
                        }
                    }else{

                        if(nameedit[i] !='' || passedit[i] !=''){
                            $('#listGroup').text('All the three respective fields are compulsory in list(Name, Email and Password).');
                            $('html, body').animate({
                            scrollTop: $('#listGroup').offset().top
                            }, 1000);
                            return false;
                        }
                    }
                }

            if($('#type_field option:selected').val()==1){
                
               var mail = []; var name=[]; var pass=[];

                $("input[name='Emails[]']").each(function() {

                    var value = $(this).val();
                    if (value!='') {
                        $('#nameGroup').text('');
                        mail.push(value);
                    }else{
                        mail.push('');
                    }
                });
                $("input[name='UNams[]']").each(function() {

                    var value = $(this).val();
                    if (value!='') {
                        $('#nameGroup').text('');
                        name.push(value);
                    }else{
                        $('#nameGroup').text('');
                        name.push('');
                    }
                });

                $("input[name='Passwd[]']").each(function() {

                    var value = $(this).val();
                    if (value!='') {
                        pass.push(value);
                    }else{
                        pass.push('');
                    }
                });

               /* console.log(mail);
                console.log(name);
                console.log(pass);*/

                if($('#limit_enable').prop('checked') == true)
                {
                    $('#limit_enable').val(1)
                }
                else{
                    $('#limit_enable').val(0)
                }

                $('#exp_limit').val();

                for(var i=0;i < mail.length; i++){
                    
                    if(mail[i] !=''){

                        if(name[i] =='' || pass[i] ==''){

                            $('#nameGroup').text('All the three respective fields are compulsory.');
                            $('html, body').animate({
                            scrollTop: $('#nameGroup').offset().top
                            }, 1000);
                            return false;
                        }
                    }else{
                        
                        if( name[i] !='' || pass[i] !=''){
                            
                            $('#nameGroup').text('All the three respective fields are compulsory.');
                            $('html, body').animate({
                            scrollTop: $('#nameGroup').offset().top
                            }, 1000);
                            return false;
                        }
                    }
                }
            } 
            else{
                
                
                    $('#nameGroup').text('');        
                    var fileName = $(".ip-file").val();
                    
                    if(fileName != '') { // returns true if the string is not empty

                        var extension = fileName.substr( (fileName.lastIndexOf('.') +1) );

                        if(extension.trim() != 'xls' && extension.trim() != 'xlsx' && extension.trim() != 'XLSX' && extension.trim() != 'XLS'){

                            $('#nameGroup').text('Please select the xls / xlsx file to upload');
                            $('html, body').animate({
                            scrollTop: $('#nameGroup').offset().top
                            }, 1000);
                            return false;
                        }else{
                            
                            $('#nameGroup').text('');
                        }

                    } 
                }
              
                $('#companyedit').attr('action', 'updatemembers.php');
                form.submit();
            }
        });


    });

</SCRIPT>
</head>

<body>
    <form name="companyedit"  enctype="multipart/form-data" id="companyedit" method="post" action="" >
        <div id="containerproductproducts">
        <!-- Starting Left Panel -->
        <?php include_once 'leftpanel.php'; ?>
        <!-- Ending Left Panel -->
          
        <!-- Starting Work Area -->
            <div style="width:570px; float:right; background-color:#FFF; ">
                <div style="width:565px; float:left; padding-left:2px;">
                    <div style="width:565px;">
                        <div id="maintextpro">
                            <div id="headingtextpro">
                                <h3 style="margin-bottom:15px;">Edit Company</h3>
                                <div class="f-type export-sec "  style="display: inline-flex;float:right;padding: 0px 0px 5px 0px;cursor: pointer;">
                                        <span style="display: inline-flex;" onclick="dealmemberexport();"> <i class="fa fa-download" aria-hidden="true" style="    font-size: 20px;"><!-- <b >Export</b> --></i>
                                            <input type="button" value="Export" name="soexport" >
                                        </span>
                                           <!--  <input type=checkbox name="txtTrialLogin"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $trialFlag; ?> onclick="ExporttoExel()" style="display:block;"><label style="margin: 3px 0px 0px 0px;">Export</label> -->
                                        
                                    </div>
                                <input type=hidden name="compId" value="<?php echo $companyIdtoEdit; ?>" >

                                <b>Company </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="../images/arrow.gif" />
                                <input type=text name="companyname" id="companyname" value="<?php echo $CompanyName; ?>" > <br /><br />
                                <b>Expiry Date </b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src="../images/arrow.gif" />
                                <input type="text" name="date" value="<?php echo $ExpDate; ?>" size="15" placeholder="yyyy-mm-dd" id="fromdate"><br /><br />
                              
                                 <div class="selectgroup">
                                        <label style="margin-right:30px;">Select Inudstry for PE</label>
                                        <img src="../images/arrow.gif" />
                                        <select name="industryPE[]" multiple="multiple"  id="sltindustrype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                        <?php
                                        
                                            $industrysql_search="select industryid,industry from industry where industryid !=15 order by industry";
                                            
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
                                                        if(count($peindustries)>0)
                                                        {
                                                            $indSel = (in_array($id,$peindustries))?'SELECTED':''; 
                                                            echo "<OPTION id='peindustry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                                        }
                                                        else
                                                        {
                                                            $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                                            echo "<OPTION id='peindustry_".$id. "' value=".$id." ".$isselected." >".$name."</OPTION> \n";
                                                        }

                                                    }
                                                    mysql_free_result($industryrs);
                                            }
                                        ?>
                                        </select>
                                        <p id="industryerr-pe" style="color: red;margin-left:160px;"></p>
                                     </div><br>
                                     
                                     <div class="selectgroup">
                                        <label style="margin-right:30px;">Select Inudstry for MA</label>
                                        <img src="../images/arrow.gif" />
                                        <select name="industryMA[]" multiple="multiple"  id="sltindustryma" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
                                        <?php
                                           
                                            $industrysql_search="select industryid,industry from industry where industryid !=15 order by industry";
                                            
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
                                                        if(count($maindustries)>0)
                                                        {
                                                            $indSel = (in_array($id,$maindustries))?'selected':''; 
                                                            echo "<OPTION id='maindustry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                                        }
                                                        else
                                                        {
                                                            $isselected = ($getindus==$name) ? 'SELECTED' : '';
                                                            echo "<OPTION id='maindustry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                                        }

                                                    }
                                                    mysql_free_result($industryrs);
                                            }
                                        ?>
                                        </select>
                                        <p id="industryerr-ma" style="color: red;margin-left:160px;"></p>
                                     </div>
                                <p id="loginerror" style="color: red;"></p>
                                <input type=checkbox name="txtPELogin" id="allpe" class="logincheckbox" value="1"> PE Login 
                                 <input type="checkbox" value="1" name="vconly" id="vconly"> VC Login 
                                <input type=checkbox name="txtMALogin" id="allma" class="logincheckbox" value="<?php echo $companyIdtoEdit; ?>" <?php echo $maflag; ?>> M & A Login 
                                <input type=checkbox name="txtRELogin" id="allre"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $reflag; ?> class="logincheckbox" > RELogin 
                               
                                <input type=checkbox name="txtStudent"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $studentFlag; ?> onclick="Student()" > Student 
                                <input type=checkbox name="txtIPAdd"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $ipflag; ?>  onclick="IPAdd();"> IP Add
                                  <input type=checkbox name="txtTrialLogin"  value=" <?php echo $companyIdtoEdit; ?>" <?php echo $trialFlag; ?> onclick="ExporttoExel()" > Export 
                                <br/>
                                
                                <div style="width: 542px; x-overflow: scroll;margin-bottom:10px;">
                                    
                                   <!--  <input type="checkbox" value="1" name="peonly" id="peonly" > <label for="peonly"><strong>PE-Only</strong></label> 
                                    <input type="checkbox" value="2" name="vconly" id="vconly"> <label for="vconly"><strong>VC-Only</strong></label>  -->
                                    <br>
                                    <table border="1" cellpadding="2" cellspacing="0" width="80%" style="margin-top: 0%;"  >
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <th>PE-Inv</th>
                                            <th>VC-Inv</th>
                                            <!--	<th>RE</th> -->
                                            <th>PE-IPO</th>
                                            <th>VC-IPO</th>
                                            <th>PE-M&A</th>
                                            <th>VC-M&A</th>
                                            <th>PE-Dir </th>
                                            <th>VC-Dir</th>
                                            <th>SP-Dir</th>
                                            <th>LP-Dir</th>
                                            <!-- <th>PE-back</th>
                                            <th>VC-back</th>
                                            <th>MA-MA</th> -->
                                            <th>Inc</th>
                                            <th>Angel-<br>Inv</th>
                                            <th>SV-<br>Inv</th>
                                            <th>If-<br>Tech</th>
                                            <th>CTech</th>
                                            <!--<th> </th> -->
                                        </tr>
                                    <?php

                                        $dealcompanySql="select * from dealcompanies where Deleted=0 and DCompId=$companyIdtoEdit";
                                        if ($companyrs = mysql_query($dealcompanySql))
                                        {	
                                            $company_cnt = mysql_num_rows($companyrs);	 
                                            
                                        }
                                            if ($company_cnt>0)
                                            {
                                                While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                                {
                                                    $PEInv="";
                                                    $VCInv="";
                                                    //$REInv="";
                                                    $PEIpo="";
                                                    $VCIpo="";
                                                    $PEMa="";
                                                    $VCMa="";
                                                    $PEDir="";
                                                    $VCDir="";
                                                    $SPDir="";
                                                    $LPDir="";
                                                    /*$PE_back="";
                                                    $VC_back="";
                                                    $Ma_Ma="";*/
                                                    $inc="";
                                                    $angelInv="";
                                                    $sv="";
                                                    $itech="";
                                                    $ctech="";

                                                    $permission = $myrow["permission"];

                                                    if($myrow["PEInv"]==1)
                                                            $PEInv="checked";
                                                    if($myrow["VCInv"]==1)
                                                            $VCInv="checked";
                                                    //if($myrow["REInv"]==1)
                                                    //	$REInv="checked";
                                                    if($myrow["PEIpo"]==1)
                                                            $PEIpo="checked";
                                                    if($myrow["VCIpo"]==1)
                                                            $VCIpo="checked";
                                                    if($myrow["PEMa"]==1)
                                                            $PEMa="checked";
                                                    if($myrow["VCMa"]==1)
                                                            $VCMa="checked";
                                                    if($myrow["PEDir"]==1)
                                                            $PEDir="checked";
                                                    if($myrow["VCDir"]==1)
                                                            $VCDir="checked";
                                                    if($myrow["SPDir"]==1)
                                                            $SPDir="checked";
                                                    if($myrow["LPDir"]==1)
                                                            $LPDir="checked";
                                                    /*if($myrow["PE_backDir"]==1)
                                                            $PE_back="checked";
                                                    if($myrow["VC_backDir"]==1)
                                                            $VC_back="checked";*/
                                                    if($myrow["MAMA"]==1)
                                                            $Ma_Ma="checked";
                                                    if($myrow["Inc"]==1)
                                                            $inc="checked";
                                                    if($myrow["AngelInv"]==1)
                                                        $angelInv="checked";
                                                    if($myrow["SVInv"]==1)
                                                        $sv="checked";
                                                    if($myrow["IfTech"]==1)
                                                        $itech="checked";
                                                    if($myrow["CTech"]==1)
                                                        $ctech="checked";
                                                   
                                            ?>
                                                <tr>
                                                    <td align=center><input name="PEInv" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEInv; ?>></td>
                                                    <td align=center><input name="VCInv" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>"<?php echo $VCInv; ?> ></td>
                                                    <!--<td align=center><input name="RE" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $REInv; ?> ></td>-->
                                                    <td align=center><input name="PEIpo" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEIpo; ?> ></td>
                                                    <td align=center><input name="VCIpo" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCIpo; ?> ></td>
                                                    <td align=center><input name="PEMa" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEMa; ?> ></td>
                                                    <td align=center><input name="VCMa" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCMa; ?> ></td>
                                                    <td align=center><input name="PEDir" class="peonly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEDir; ?> ></td>
                                                    <td align=center><input name="CODir" class="vconly" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCDir; ?> ></td>
                                                    <td align=center><input name="SPDir" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $SPDir; ?> ></td>
                                                    <td align=center><input name="LPDir" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $LPDir; ?> ></td>

                                                    <!-- <td align=center><input name="PE_back" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $PE_back; ?> ></td>
                                                    <td align=center><input name="VC_back" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $VC_back; ?> ></td>
                                                    <td align=center><input name="MA_MA" type="checkbox" class="maonly" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $Ma_Ma; ?> ></td> -->
                                                    <td align=center><input name="INC" class="vconly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $inc; ?> ></td>
                                                    <td align=center><input name="AngelInv" class="vconly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $angelInv; ?> ></td>
                                                    <td align=center><input name="SVInv" class="vconly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $sv; ?> ></td>
                                                    <td align=center><input name="IfTech" class="peonly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $itech; ?> ></td>
                                                    <td align=center><input name="CTech" class="peonly" type="checkbox" value="<?php echo $myrow["DCompId"]; ?>" <?php echo $ctech; ?> ></td>
                                                </tr> 
                                            </table>
                                        <?php
                                                } //end of while loop
                                            } //end of if loop
                                        ?>
                                </div>
                                <input type=checkbox name="mobappaccess" id="applogin" class="applogincheckbox" value="<?php echo $companyIdtoEdit; ?>" <?php echo $mobflag; ?>> Mobile app access
                                <!-- ADDED BY JFR - KUTUNG -->
                                <div style="margin-top: 15px;">
                                    <span style="font-size: 14px;font-weight:bold;">IP Range : </span> <Br />
                                    <div id="IpRnglst" style="width: 542px; overflow: auto;margin-bottom:20px;max-height: 200px;">
                                    <?php echo $ipContent; ?>
                                    <input type="hidden" name="ipCount" id="ipCount" value="<?php echo $ipCount; ?>">
                                </div>
                                </div>
                                
                
                                <b> Company Contact(s)</b> <i>(Add multiple email ID separated by comma's)</i> <br/> <textarea name="contacts" rows="1" cols="30"><?php echo $poContact; ?></textarea> 
                                <br/><br/>
                
                                <b>Reset Export Limit to</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/arrow.gif" /><input type="text" name="resetExp" id="resetExp"> <input type="button" name="limReset" value="Reset" onclick="resetExpLimit();">
                                <br /><br />

                                <div class="row" style="width: 300px;">
                                    <h2>Custom Export Option</h2>
                                    <input type="checkbox" id="limit_enable" name="limit_enable" <?php if($limit_enable==1) { echo "checked"; } else { }?>><b>Enable</b><br><br>
                                    <b>Export Limit</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="exp_limit" id="exp_limit" value="<?php echo $export_limit ?>"><br><br>
                                </div>
                                
                                <div style="margin-bottom: 15px;">
                                    <span style="font-size: 14px;font-weight:bold;">List of Members : </span> <Br />
                                    
                                </div>
                                <p id="listGroup" style="color: red;"></p>  
                                <div style="width: 542px; max-height: 310px; overflow: scroll;margin-bottom: 20px;">
                                    
                                    <table border="1" align=left cellpadding="2" cellspacing="0" width="70%"  >
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                        <th > Del</th>
                                        <th > Disabled</th>
                                        <th>Sl.No</th>
                                        <th >Name</th>
                                        <th> Email Id</th>
                                        <!-- <th>Password</th> -->
                                        <th>Devices Allowed</th>
                                        <th>Export Limit</th>
                                        </tr>
                                        <?php
                                            $emailCount=1;
                                            $getMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit,Deleted from dealmembers where DCompId=$companyIdtoEdit  order by EmailId";
                                            //echo "<Br>--" .$getMembersSql;
                                            if ($rsMembers=mysql_query($getMembersSql))
                                            {
                                                While($myrow=mysql_fetch_array($rsMembers, MYSQL_BOTH))
                                                {
                                        ?>
                                                    <tr style="font-family: Verdana; font-size: 8pt">
                                                    <td align=center BGCOLOR="#FF6699"><input name="DelEmailId[]" type="checkbox" value=" <?php echo $myrow["EmailId"]; ?>" >
                                                    <input type=hidden name="email[]" value="<?php echo $myrow['EmailId']; ?>"> </td>
                                                    <td align=center >
                                                    <input name="perEmailId[]" class="perEmailId" type="checkbox" <?php if($myrow["Deleted"]==1){ echo "checked";} ?>  value="<?php echo $myrow["EmailId"]; ?>" >
                                                    <input type=hidden name="peremail[]" value="<?php echo $myrow['EmailId']; ?>"> </td>
                                                    <td  align=center><?php echo $emailCount; ?></td>
                                                    <td  ><input type=text name="Nams[]"  value="<?php echo trim($myrow['Name']); ?>"> </td>
                                                    <td  > <input type=text name="Mails[]" value="<?php echo trim($myrow['EmailId']); ?> "></td>
                                                    <!-- <td  ><input type=password name="Pwd[]" value="<?php echo trim($myrow['Passwrd']); ?>" > </td> -->
                                                    <td  ><input type=text name="DevCnt[]" value="<?php echo trim($myrow['deviceCount']); ?>" > </td>
                                                    <td  ><input type=text name="ExpLmt[]" value="<?php echo trim($myrow['exportLimit']); ?>" > </td>
                                                    </tr>
                                        <?php
                                                    $emailCount=$emailCount+1;
                                                }
                                            }
                                            //Get members from malogin table
                                            $MAemailCount=1;
                                            $getMAMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit,Deleted from malogin_members where DCompId=$companyIdtoEdit  order by EmailId ";
                                            //echo "<Br>--" .$getMAMembersSql;
                                            if ($rsMAMembers=mysql_query($getMAMembersSql))
                                            {
                                                While($myMArow=mysql_fetch_array($rsMAMembers, MYSQL_BOTH))
                                                {
                                                ?>
                                                    <tr style="font-family: Verdana; font-size: 8pt">
                                                    <td align=center  BGCOLOR="#FFFF00"><input name="MADelEmailId[]" type="checkbox" value=" <?php echo $myMArow["EmailId"]; ?>" >
                                                    <input type=hidden name="emailMA[]" value="<?php echo $myMArow['EmailId']; ?>"> </td>
                                                    <td align=center  ><input name="perMAEmailId[]" type="checkbox" <?php if($myMArow["Deleted"]==1){ echo "checked";} ?> value="<?php echo $myMArow["EmailId"]; ?>" >
                                                    <input type=hidden name="peremailMA[]" value="<?php echo $myMArow['EmailId']; ?>"> </td>
                                                    <td  align=center><?php echo $MAemailCount; ?></td>

                                                    <td  ><input type=text name="NamsMA[]"  value="<?php echo trim($myMArow['Name']); ?>"> </td>
                                                    <td  > <input type=text name="MailsMA[]" value="<?php echo trim($myMArow['EmailId']); ?> "></td>
                                                   <!--  <td  ><input type=password name="PwdMA[]" value="<?php echo trim($myMArow['Passwrd']); ?>" > </td> -->
                                                    <td  ><input type=text name="DevCntMA[]" value="<?php echo trim($myMArow['deviceCount']); ?>" > </td>
                                                    <td  ><input type=text name="ExpLmtMA[]" value="<?php echo trim($myMArow['exportLimit']); ?>" > </td>
                                                    </tr>
                                            <?php
                                                    $MAemailCount=$MAemailCount+1;
                                                }
                                            }


                                            //Get members from RELogin table
                                            $REemailCount=1;
                                            $getREMembersSql ="Select Name,EmailId,Passwrd,deviceCount,exportLimit,Deleted from RElogin_members where DCompId=$companyIdtoEdit order by EmailId ";
                                            //echo "<Br>--" .$getREMembersSql;
                                            if ($rsREMembers=mysql_query($getREMembersSql))
                                            {
                                                While($myRErow=mysql_fetch_array($rsREMembers, MYSQL_BOTH))
                                                {
                                                    ?>
                                                    <tr style="font-family: Verdana; font-size: 8pt">
                                                    <td align=center  BGCOLOR="GREEN"><input name="REDelEmailId[]" type="checkbox" value=" <?php echo $myRErow["EmailId"]; ?>" >
                                                    <input type=hidden name="emailRE[]" value="<?php echo $myRErow['EmailId']; ?>"> </td>
                                                    <td align=center ><input name="perREEmailId[]" type="checkbox"  <?php if($myRErow["Deleted"]==1){ echo "checked";} ?> value="<?php echo $myRErow["EmailId"]; ?>" >
                                                    <input type=hidden name="peremailRE[]" value="<?php echo $myRErow['EmailId']; ?>"> </td>
                                                    <td  align=center><?php echo $REemailCount; ?></td>

                                                    <td  ><input type=text name="NamsRE[]"  value="<?php echo trim($myRErow['Name']); ?>"> </td>
                                                    <td  > <input type=text name="MailsRE[]" value="<?php echo trim($myRErow['EmailId']); ?> "></td>
                                                   <!--  <td  ><input type=password name="PwdRE[]" value="<?php echo trim($myRErow['Passwrd']); ?>" > </td> -->
                                                    <td  ><input type=text name="DevCntRE[]" value="<?php echo trim($myRErow['deviceCount']); ?>" > </td>
                                                    <td  ><input type=text name="ExpLmtRE[]" value="<?php echo trim($myRErow['exportLimit']); ?>" > </td>
                                                    </tr>
                                                <?php
                                                    $REemailCount=$REemailCount+1;

                                                }
                                            }
                                        ?>
                                    </table>
                                </div>
                                
                                <div style="margin-bottom: 15px;margin-top:20px;">
                                    <span style="font-size: 14px;font-weight:bold;">Add New Members : </span> <Br />
                                </div>
                                 <p id="nameGroup" style="color: red;"></p>       
                                <div class="ftype-wrapper comp_div" style="margin-bottom: 10px;">
                                   <div class="f-type type-title" style="width:150px;">
                                       <div class="filter-value">
                                           <span class="filter-label" style ="float: left;padding: 5px 10px 0px 10px;"><b>By</b></span>
                                           <select name="type_field" id="type_field" style="background-color: #ffffff;border: 1px solid #DED9CE;float:left;">
                                               <option value="1">Form fields</option>
                                               <option value="2">import</option>
                                           </select>
                                       </div>
                                   </div>
                                </div>
                                       
                                <div class="acc-sections" style="display:none;margin-top:30px;">
                                    <div class="accordian active">
                                        <h3 class="acc-title"><span>Upload Members</span></h3>
                                        <div class="acc-content">
                                            <p>Upload and .xls file through the window:</p>
                                            <div class="upload-sec">
                                                <input type="file" name="dealsmemberfilepath" class="ip-file">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                                <table border="1" align=left cellpadding="2" cellspacing="0" width="70%" class="form-fields" style="margin-bottom: 15px;">
                                    <tr><p id="field-error"></p></tr>
                                    <tr><span class="form-fields" style="font-size: 12px; color: #383838; margin-bottom: 5px;">(Note: All fields are manadatory. Please provide Email, Name, Pasword resp. )</span></tr>
                                    <tr style="font-family: Verdana; font-size: 8pt">
                                        <th> Email</th>
                                        <th >Name</th>
                                        <th>Password</th>
                                    </tr>
                                         <?php
                                         for ($counter = 0; $counter < 5; $counter += 1)
                                         {
                                         ?>
                                             <tr>
                                                <td><input type="text" name="Emails[]"  value="" class="reset"> </td>
                                                <td><input type="text" name="UNams[]" value="" class="reset"></td>
                                                <td><input type="text" name="Passwd[]" value="" class="reset"></td>
                                             </tr>
                                         <?php
                                         }
                                         ?>
                                    <tr></tr>
                                </table>
			<span style="padding: 10px 0px 0px 0px;" class="one" >
                            <input type="button" class="btn" value="Delete Members" name="deleteMember" onClick="deleteMembers(<?php echo $_GET["value"]; ?>);">
                            <input type="hidden" class="flaghidden" >
                            <input type="button" class="btn permission" value="Permission Members" name="permissionMember" onClick="permissionMembers(<?php echo $_GET["value"]; ?>);">
<!--                            <input type="button"  value="Delete Members" name="deleteMember" onClick="deleteMembers(<?php echo $_GET["value"]; ?>);">-->
<!--                            <input type="button"  value="Add Members" name="addMember" onClick="AddMembers();">-->
                            <input type="submit"  value="Update Member List" name="updateMember" style="float:right;">
			</span> <br /><br /></br>
                        
			<div id="headingtextprosmallfontbgPinkcolorAdmin">PE Logins </div>
                        <div id="headingtextprosmallfontbgYellowcolorAdmin">Merger Logins</div>
                        <div id="headingtextprosmallfontbgGreencolorAdmin">RE Logins</div>


		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
<script>
    $(document).ready(function() {   
    
    <?php if ($permission==1) { ?>
         $('#peonly').prop( "checked", true );
         $('#allpe').prop( "checked", true );
    <?php } else if($permission==2) { ?> 
         $('#vconly').prop( "checked", true );
         $('#allpe').prop( "checked", true );
    <?php  } else { ?>
             
                var pecheckcount=0;
                $('.peonly').each(function() { //loop through each checkbox
                   if(this.checked==true) { pecheckcount++; }        
                });                     
                if(pecheckcount > 0){
                   $('#peonly').prop( "checked", true );
                   $('#allpe').prop( "checked", true );
                }

                var vccheckcount=0;
                $('.vconly').each(function() { //loop through each checkbox
                   if(this.checked==true) { vccheckcount++; }        
                });                     
                if(vccheckcount > 0){
                   $('#vconly').prop( "checked", true );
                   $('#allpe').prop( "checked", true );
                }
                
    <?php  } ?>
});
</script>

   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   </form>
    <form name="export"  method="post" action="" >
                                
        <input type="hidden" name="companyid" value="<?php echo $companyIdtoEdit; ?>">
       
    </form>
  <script type="text/javascript">
        
            $(function(){
                
            $("#sltindustrype").multiselect();
            $("#sltindustryma").multiselect();
                $( "#fromdate" ).datepicker({ dateFormat: 'yy-mm-dd' });
            })
        </script>

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
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>