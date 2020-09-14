<?php /* Smarty version 2.5.0, created on 2019-07-25 07:34:49
         compiled from admin/editadmingroup.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'assign', 'admin/editadmingroup.tpl', 332, false),
array('function', 'html_options', 'admin/editadmingroup.tpl', 367, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
jquery.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="http://loopj.com/jquery-tokeninput/src/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="http://loopj.com/jquery-tokeninput/styles/token-input.css" type="text/css" />
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php echo '   
<style type="text/css">

/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/*.slider-bg {
	height:472px;
	position:absolute;
	width:980px;
	left: 155px;
	top: -39px;
	z-index:1000;
}*/
ul#primary-nav {
	float:left;
	height:75px;
	left:225px;
	position:absolute;
	top:57px;
	width: 746px;
}

ul#primary-nav {
margin:0; padding:0;
}

ul#primary-nav li {display:block; float:left; margin-right:22px;} 

ul#primary-nav li.home:hover{background: url(images/homehover.png) left top; width:77px; height:50px;}
ul#primary-nav li.aboutus:hover{background: url(images/abouthover.png) left top; width:114px; height:50px;}
ul#primary-nav li.services:hover{background: url(images/serviceshover.png) left top; width:114px; height:50px;}
ul#primary-nav li.contactus:hover{background: url(images/contactushover.png) left top; width:134px; height:50px;}

ul#primary-nav li.home a
{
background:url(images/home.png) no-repeat;
line-height:64px;
padding:19px 38px;
}

ul#primary-nav li.aboutus a
{
background:url(images/aboutus.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.services a
{
background:url(images/services.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.contactus a
{
background:url(images/contactus.png) no-repeat;
line-height:64px;
padding:19px 67px;
}

ul#primary-nav li a{
height:19px;
width:auto;
}
.contentbg
{
height:auto;
position:relative;
}
.content
{
width:930px;
height:auto;
margin:0 auto;
padding-top:42px;

}
.wrapper {
padding:0px 0px 20px;
width:300px;
float:left;
}
.breadtext
{
font:13px Verdana, Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
text-indent:15px;
}
.breadcrumb
{
width:100%;
/*background-color:#000000;*/
/*padding:15px 0;*/
}
.title {
color:#FFFFFF;
font:lighter 25px impact;
text-transform:uppercase;
text-align:left;
}
.imagebg
{
background-color:#FFFFFF;
width:278px;
height:auto;
margin:25px auto;
border:1px solid #cecece;
padding:6px;
}
.conttext
{
font:12px/1.8 Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
width:290px;

}
h1{
display:inline;
}
.ListText{
	font:18px Arial, Helvetica, sans-serif;
	bor

}
#slidecontent {

    position: relative;
}
ol#controls {
    height: 28px;
    left: 360px;
    margin: 1em 0;
    padding: 0;
    position: absolute;
    top: 121px;
    z-index: 1000;
}
.adminbox {
    border: 1px solid #589711;
	background-color:#FFFFFF;
    border-radius: 10px 10px 10px 10px;
	-webkit-border-radius: 10px 10px 10px 10px;
    box-shadow: 2px 2px 2px #B0AEA6;
    padding: 10px;
	
    margin: 20px auto;
    height: auto;
    padding: 20px;
    width: 500px;
}
.adtitle
{
font:bold 24px "Courier New", Courier, monospace;
margin:15px 0;
color:#000;
clear:both;

}
select, input
{
padding:5px;
width:250px;
}
label{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
float:left;
width:275px;
color:#333333;
text-align:left;
}
input[type=radio]{
width:20px;
}
.dob{
	width:60px;
	padding:0px;
}

#token-input-demo-input-pre-populated{
    width: 100% !important;
}
ul.token-input-list {
    float: right !important;
width: 300px !important;
margin-bottom: 20px !important;
margin-top: -18px !important;
}
</style>


<script type="text/javascript">
   
    $(document).ready(function(){ 
        $(\'#addMore\').click(function(){
            
            var ipNum = $("#ipCount").val();
            ipNum = (ipNum * 1) + 1;
            var htmlpr = \'<p id="ipPr\'+ipNum+\'"><label>&nbsp;</label><input type="text" id="ipAddress" name="ipAddress[]" forError="ipAddress" placeholder="IP Address" style="width:100px;margin-left:38px;" value="">&nbsp;<input type="text" id="startRange" name="startRange[]" forError="startRange" placeholder="Start" style="width:50px;" value="">&nbsp;<input type="text" id="endRange" name="endRange[]" forError="endRange" placeholder="End" style="width:50px;" value=""><img src="../images/close-selected.gif" onclick="removeip(\'+ ipNum +\')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\';
            $("#ipCount").val(ipNum); 
            $("#IpRnglst").append(htmlpr);
        });
    });
    function removeip(idval){
        var temp = \'#ipPr\'+idval;
        $(temp).html(\'\');
        $(temp).remove();
        $("#ipCount").val(idval-1);
    }
    
    /*
    $(document).ready(function() {
            $("#demo-input-pre-populated").tokenInput("industry_list.php", {
                 
                prePopulate: '; ?>
 <?php echo $this->_tpl_vars['getindustries']; ?>
 <?php echo ',
                preventDuplicates: true
            });
        });
    
    
      */ 

$(document).ready(function(){ 
         
      var dateFormat = "dd-mm-yy",
        from = $( "#exp_date" ).datepicker({
	          	//defaultDate: "+1w",
	          	changeMonth: true,
                        minDate: 0,
	          	dateFormat: "dd-mm-yy",
	         	//numberOfMonths: 3
        });
      
        $(\'#Frm_EditUser\').submit(function(){
            
            var gname = $("#gname").val();
            var vlimit =  $("#vlimit").val();
            //var ExLimit =  $("#ExLimit").val();
            var subLimit =  $("#subLimit").val();
            var poc =  $("#poc").val();
            
          // if( $.trim(gname) == \'\' ){  alert(\'Please Enter Group Name\'); return false; }
          // if(! isFinite(vlimit) || $.trim(vlimit) == \'\' ){  alert(\'Please Enter Valid Visit Limit\'); return false; }
           //if(! isFinite(ExLimit) || $.trim(ExLimit) == \'\' ){  alert(\'Please Enter Valid Excel Limit\'); return false; }
         //  if(! isFinite(subLimit) || $.trim(subLimit) == \'\' ){  alert(\'Please Enter Valid Submit Limit\'); return false; }
           
           
        });
        
       
    });
    
    
</script>

'; ?>
	
        
        
</head>

<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<form name="Frm_EditUser" id="Frm_EditUser" action="" method="post" onSubmit="return Validation('Frm_EditUser')" enctype="multipart/form-data">
<input type="hidden" name="EditUser" id="EditUser" value="EditUser" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
				<li><div class="adminbox" style="width: 620px;">
                                        <div align="center"> <a href="editGroup-api-pe.php" style="float: right;">Back to Company List</a> </div>  
                                        
                                        
		<div class="adtitle" align="center">Edit PE Company</div>
                <?php if ($this->_tpl_vars['updated']): ?> <h3 style="text-align: center;color: green;margin-bottom: 4%;"> <?php echo $this->_tpl_vars['updated']; ?>
 </h3><?php endif; ?>
		<div align="center">
			<label id="req_answer[Group]">Company Name:</label>
	    <input type="text" id="gname" size="26" name="answer[Group]" class="req_value" forError="VisitLimit" value="<?php echo $this->_tpl_vars['GroupList1'][0]['DCompanyName']; ?>
" required/>		
		</div><br />
		 
                 
<div align="">
      <label id="api_access" >Api Access:</label>
      <input type="checkbox" name="api_access" id="api_access" <?php if ($this->_tpl_vars['GroupList1'][0]['api_access'] == 1): ?>checked<?php endif; ?> value="1" style="margin-left:42px; position: relative; top: 6px;" />
    </div>

<br />
<br />
<div align="">
      <label id="admin_api_access" >Admin Api Access:</label>
      <input type="checkbox" name="admin_api_access" id="admin_api_access" <?php if ($this->_tpl_vars['GroupList1'][0]['admin_api_access'] == 1): ?>checked<?php endif; ?> value="1" style="margin-left:42px; position: relative; top: 6px;" />
    </div>

<br />
<br />
 

	<div align="center" style="">
		<input type="image" name="edit_business"  src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />

	
	</div><br />

	
	
	
	
	</li>
				
							
			</ul>
		</div>
	</div>

</div>
</form>

</div>