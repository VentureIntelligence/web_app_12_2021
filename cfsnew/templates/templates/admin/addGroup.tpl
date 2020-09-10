{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>


 <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="//loopj.com/jquery-tokeninput/src/jquery.tokeninput.js"></script>
    <link rel="stylesheet" href="//loopj.com/jquery-tokeninput/styles/token-input.css" type="text/css" />


{literal}
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/* CSS Clearfix */
.clearfix:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}
.clearfix{clear:both;}
.clearfix {display: inline-table;}
/* Hides from IE-mac \*/
* html .clearfix {height: 1%;}
.clearfix {display: block;}
/* End hide from IE-mac */
ul, ol, dl {
list-style:none outside none;

}

p, pre, ul, ol, dl, dd, blockquote, address, fieldset, .gallery-row, .post-thumb, .post-thumb-single, .entry-meta {
padding-bottom:0px;
}
							/*END OF COMMON CODE*/

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
    width: 550px;
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

#token-input-demo-input{
    width: 100% !important;
}
ul.token-input-list {
    float: right !important;
width: 300px !important;
margin-bottom: 20px !important;
margin-top: -18px !important;
}
</style>

<script>
    $(document).ready(function(){ 
        $('#addMore').click(function(){
            var ipNum = $("#ipCount").val();
            ipNum = (ipNum * 1) + 1;
            var htmlpr = '<p id="ipPr'+ipNum+'"><label>&nbsp;</label><input type="text" id="ipAddress" name="ipAddress[]" forError="ipAddress" placeholder="IP Address" style="width:100px;margin-left:38px;" value="">&nbsp;<input type="text" id="startRange" name="startRange[]" forError="startRange" placeholder="Start" style="width:50px;" value="">&nbsp;<input type="text" id="endRange" name="endRange[]" forError="endRange" placeholder="End" style="width:50px;" value=""><img src="../images/close-selected.gif" onclick="removeip('+ ipNum +')">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>';
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
    
  
    $(document).ready(function() {
        $("#demo-input").tokenInput("industry_list.php", {
                preventDuplicates: true
            });
    });
    
    
     $(document).ready(function(){ 
         
      
        
        $('#Frm_AddGroup').submit(function(){
            
            var gname = $("#gname").val();
            var vlimit =  $("#vlimit").val();
            //var ExLimit =  $("#ExLimit").val();
            var subLimit =  $("#subLimit").val();
            var poc =  $("#poc").val();
            
           if( $.trim(gname) == '' ){  alert('Please Enter Group Name'); return false; }
           if(! isFinite(vlimit) || $.trim(vlimit) == '' ){  alert('Please Enter Valid Visit Limit'); return false; }
          // if(! isFinite(ExLimit) || $.trim(ExLimit) == '' ){  alert('Please Enter Valid Excel Limit'); return false; }
           if(! isFinite(subLimit) || $.trim(subLimit) == '' ){  alert('Please Enter Valid Submit Limit'); return false; }
           
           
        });
        
        
        
        
       $('#gname').live('blur', function(e) { 
       
       //var currentname =$.trim($("#gname").val());
       //if(currentname=='') { return false;} 
      var currentname =$("#gname").val(); 
      
      if($.trim(currentname)=='') { return false;}      
             
       $.ajax({
            type: "POST",
            url: "ajaxcheckgroupname.php",
            data: { G_Name: currentname }
          })
            .done(function( msg ) {
                var count =msg;
                if(msg!=0){
                    alert( "Already Exists: " + currentname );                   
                    $("#gname").val('');
                    return false;
                   
                }
                
            });
        
         });
        
        
       
    });
    
   
</script>

{/literal}
</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<form name="Frm_AddGroup" id="Frm_AddGroup" action="" method="post" onSubmit="return Validation('Frm_AddGroup')" enctype="multipart/form-data">
<input type="hidden" name="AddGroup" id="AddGroup" value="AddGroup" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
			<li>
                            <div class="adminbox" style="width: 620px;">
                     <div align="center"> <a href="editGroup.php" style="float: right;">Back to Group List</a> </div>  
                     
		<div>{$SuccessMsg}</div>
		<div class="adtitle" align="center">Add Group</div>
		<div align="center">
			<label id="req_answer[Group]">Group Name :<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="gname" size="26" name="answer[Group]" class="req_value" forError="Group" required />		
		</div><br />
<br />
		<div align="center">
			<label id="req_answer[Limit]">Visit Limit:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="vlimit" size="26" name="answer[Limit]" class="req_value" forError="Limit" required />		
		</div><br />
<br />
		 <div align="center">
			<label id="req_answer[Limit]">Excel  Limit:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="ExLimit" size="26" name="answer[ExLimit]" class="req_value" forError="Limit" required/>		
		</div><br />
<br />
		<div align="center">
			<label id="req_answer[Limit]">Submit / Search Limit:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="subLimit" size="26" name="answer[subLimit]" class="req_value" forError="Limit" required/>		
		</div><br />
<br />
                
                <div align="center">
			<label id="req_answer[poc]">Contact Email:</label>
			<input type="email" id="poc" name="answer[poc]" forerror="poc" required><br>
		</div><br />
<br />

                <div align="center" id="IpRnglst">
                                          
                       <p id="ipPr0}">
                           <label id="req_answer[ipRange]">IP Range:</label>
                            <input type="text" id="ipAddress" name="ipAddress[]" forError="ipAddress" placeholder="IP Address" style="width:100px;margin-left:38px;" value="">
                            <input type="text" id="startRange" name="startRange[]" forError="startRange" placeholder="Start" style="width:50px;" value="">
                            <input type="text" id="endRange" name="endRange[]" forError="endRange" placeholder="End" style="width:50px;" value="">
                            <input type="button" name="addMore" id="addMore" value="Add IP">
                        </p>
                        <input type="hidden" name="ipCount" id="ipCount" value="0">
		</div><br />
<br />

                
                <div align="center">
                    <label>Industry :</label>
                    <select id="industry" name="industry[]"  class="req_value" forError="Industry" multiple="multiple">
							{html_options options=$industries}
				</select>
                    
                  <!--   <input type="text" id="demo-input" name="industry" />
                    <input type="button" value="Submit" id="getid" /> --> 
                   
                </div><br />
<br />

<div align="center" style="float: left;margin-bottom: 5%;">
			<label id="req_answer[Permissions]" >Permissions:</label>
                        <select forerror="permissions" class="req_value" name="answer[Permissions]" id="answer[Permissions]" style="margin-left:42px;">
				   						<option value="0">Transacted</option>
						<option value="1">Non Transacted</option>
                                                <option value="2" selected="">Both</option>
								   </select>
		</div>

<br />
<br />

<div align="">
      <label id="api_access" >Api Access:</label>
      <input type="checkbox" name="api_access" id="api_access" value="1" style="margin-left:42px; position: relative; top: 6px;" />
    </div>

<br />
<br />

<div align="" style="margin-bottom: 5%;">
      <label id="mobile_app_access" >Mobile App Access:</label>
      <input type="checkbox" name="mobile_app_access" id="mobile_app_access" value="1" style="margin-left:42px; position: relative; top: 6px;" />
    </div>

<br />
<br />

	<div align="center">
		<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />

	
	</div><br />
	</li>
			</ul>
		</div>
	</div>

</div>
</form>


</div>