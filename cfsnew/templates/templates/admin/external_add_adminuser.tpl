{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>

 
{literal}
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
#slidecontent ul li {list-style-type: none;}
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

}
select, input
{
padding:5px;
width:250px;
}
label {
font-family: Arial, Helvetica, sans-serif;
font-size: 18px;
float: left;
width: 150px;
color: #333333;
text-align: left;
}
input[type=radio]{
width:20px;
}
.dob{
	width:60px;
	padding:0px;
}

</style>

	<script type="text/javascript" language="javascript1.3">
            

            
            
            
		/*var $j = jQuery.noConflict();
		$j(document).ready(function(){	
			$j("#slider").easySlider({
				//auto: false, 
				//continuous: true,
				numeric: true
			});
		});*/	



/*function Validation(id){
  var flag		=		0;
  if(id == 1 && id != undefined){
	var email = document.getElementById('emailaddress').value;
	var City = document.getElementById('City').value;
	 if(email==""){
		$('CatErrorMsg').innerHTML = "Please Enter Email";
		$('emailaddress').focus();
		flag=1;
	 }else if (!isValidEmail(email)){
		$('CatErrorMsg').innerHTML = "Please Enter Valid Email Address";
		$('emailaddress').focus();
		flag=1;
	}
  }	
	if(flag == 0 && email != "" && email != undefined){
		document.authcheck.submit();
	}
}
*/
function IndexKeyPress(id,e){
		// look for window.event in case event isn't passed in
		if (window.event) { e = window.event; }
		if (e.keyCode == 13){
		return true;
			//	validation(id);
		}
}



</script>
<script>
    $(document).ready(function(){ 
        $('#addMore').click(function(){
            
            var ipNum = $("#ipCount").val();
            ipNum = (ipNum * 1) + 1;
            var htmlpr = '<tr id="userrow'+ipNum+'"> <td>'+ipNum+'</td>'+
                            '<td><input type="text" id="answer[FirstName]"  style="width:100%;" name="FirstName[]" placeholder="First Name" class="" forError="FirstName" required></td>'+		

                            '<td><input type="text" id="answer[LastName]" style="width:100%;" name="LastName[]" placeholder="Last Name" class="" forError="LastName" /></td>'+

                            '<td><input type="text" id="email_'+ipNum+'"  style="width:100%;" name="Email[]" placeholder="Email" class="email" forError="Email" required/></td>'+

                            '<td><input type="password" id="answer[Password]" style="width:100%;"  name="Password[]" placeholder="Password" class="" forError="Password" required/></td>'+

                            '<td><input type="text" id="devCnt" name="devCnt[]" style="width:100%;" placeholder="Devices Allowed" forError="devCnt" required></td>'+

                            '<td><input type="text" id="expLmt" name="expLmt[]" style="width:75%;" forError="expLmt" placeholder="Export Limit" required> <img src="../images/close-selected.gif" onclick="removeip('+ ipNum +')"> </td>'+
                    
                            '</tr>';
                            
            $("#ipCount").val(ipNum); 
            $("#userrange").append(htmlpr);
        });
        
        
      
        
    });

    function removeip(idval){
        var temp = '#userrow'+idval;
        $(temp).html('');
        $(temp).remove();
        $("#ipCount").val(idval-1);
    }
    
  
    $(document).ready(function() {
        $("#demo-input").tokenInput("industry_list.php");
    });
    
</script>    
  

 <script type='text/javascript' src='//code.jquery.com/jquery-1.6.2.js'></script>
 <script type='text/javascript'>//<![CDATA[    
    $(document).ready(function() {
    
   
       $('.email').live('blur', function(e) { 
       
       var currenttxt =$.trim($(this).val());
       if(currenttxt=='') { return false;} 
       
       var thisid =  this.id;
       
       $.ajax({
            type: "POST",
            url: "ajaxcheckusername.php",
            data: { username: currenttxt }
          })
            .done(function( msg ) {
                var count =msg;
                if(msg!=0){
                    alert( "Already Exists: " + currenttxt );                   
                    $("#"+thisid).val('');
                    return false;
                   
                }
                
            });
             
           
        
        var dupcount=1;
        
         $(".email").each(function( i ) {       
        if ($.trim($(this).val()) == currenttxt) {            
           
            if(dupcount>1) {
            alert('Please enter different Email');           
            $(this).val('');
            }
            dupcount++;
        }
        });
        
        
        
    });
    
    

  });   
//]]>  

</script>



	{/literal}
</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<form name="Frm_EditUser" id="Frm_EditUser" action="external_add_adminuser.php" method="post" onSubmit="return Validation('Frm_EditUser')" enctype="multipart/form-data">
<input type="hidden" name="Registration" id="Registration" value="Registration" />
<div id="slidecontainer">


	<div id="slidecontent">
            
                                
		<div id="slider">
			<ul>
                            <li>
                                <div class="adminbox">
                                <div class="adtitle" align="center">Add External API User</div>    
                                
                                 <div class="errormsg" style="padding:3px;padding: 3px;font-size: 14px;text-align: center;color: red;">{$ExistError}</div>
                                 <div class="sucsmsg" style="padding:3px;padding: 3px;font-size: 14px;text-align: center;color: green;">{$SucsMsg}</div>    
                                                
                                <br><br>
                                <div align="center">
                                       <label  >User Name</label>	
                                        <input type="text" id="answer[UserName]" size="26" name="answer[UserName]" class="req_value"  forError="UserName" value="{$Request.UserName}" />
                                </div>                                 <br><br>
                                <div align="center">
                                        <label >Password</label>		
					<input type="password" id="answer[Password]" size="26" name="answer[Password]" class="req_password" forError="Password"  value=""  />
                                </div>                                 <br><br>
                                <div align="center">
                                        <label >Retype Password</label>		
					<input type="password" id="password_again" size="26" name="password_again" class="req_password_again" forError="req_password_again" disabled="disabled" />
                                </div>                                 <br><br>
                                <div align="center">
                                       <label >Email</label>	
                                        <input type="text" id="answer[Email]" size="26" name="answer[Email]" class="req_email" forError="Email" value="{$Request.Email}" />
                                </div> <br><br>
                                <div align="center">
                                      <label >First Name</label>	
                                        <input type="text" id="answer[FirstName]" size="26" name="answer[FirstName]" class="req_value"  forError="FirstName"  value="{$Request.FirstName}" />
                                </div> <br><br>
                                <div align="center">
                                     <label >Last Name</label>	
				 <input type="text" id="answer[LastName]" size="26" name="answer[LastName]" class="req_value"  forError="LastName"  value="{$Request.LastName}" />
                                </div><br><br>
                                  <div align="center">
                                     <label >User Type</label>  
                                    <select id="answer[user_type]" name="answer[user_type]" class="req_value"  forError="user_type" disabled>
                                         <option value="7">API</option> 
                                        <option value="2">Intern</option>
                                        <option value="1">Admin</option>
                                        <option value="4">XBRL Automation</option>
                                        <option value="6">Intern + XBRL Automation</option>
                                        
                                    </select>
                                </div> 
                                <input type="hidden" name="answer[external_api_access]" id="answer[external_api_access]" value="1"/>
                                 <div align="center">
                                     <label >Enable Permission</label>	
                                        <input type="checkbox" name="answer[usr_flag]" id="answer[usr_flag]" class="usr_flag" {if $Request.usr_flag eq 1}checked{/if} value="4"  style="position: relative;left: -115px; top: 6px;"   />
                                </div> 
                                {* <input type="hidden" name="answer[external_api_access]" id="answer[external_api_access]" value="1"/>
                                *}
                                <br><br>
                               
                                 {* <div align="center">
                                     <label >API Access</label>	
                                        <input type="checkbox" name="answer[external_api_access]" id="answer[external_api_access]" class="external_api_access" {if $Request.external_api_access eq 1}checked{/if} value="1"  style="position: relative;left: -115px; top: 6px;"   />
                                </div>
                                 
                               
                                *}
                
                
                
                <br><br>
		<div align="center">
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
{*include file ="groupon/footer.tpl"*}


	