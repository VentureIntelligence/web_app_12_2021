<script language="javascript" type="text/javascript" src="http://www.clawdigital.com/js/tinymce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="http://www.clawdigital.com/js/tinymce/loadTiny.js"></script>
{include file='groupon/admin/header.tpl'}
{literal}
<script  type="text/javascript" language="javascript1.2">
tinyMCE.init({
    width:"200px"
});


function Add_Deal() {
/*	var flag		=		0;

	var Home = $('Home').value;
	var Aboutus = $('Aboutus').value;
	var Services = $('Services').value;
	var Contactus = $('Contactus').value;
	
	
	
	if(Home ==""){
		$('CatErrorMsg').innerHTML = "Please Enter the Home Content !";
		$('Home').focus();
		flag=1;	
	}else if(Aboutus ==""){
		$('CatErrorMsg').innerHTML = "Please Enter the Aboutus Content!";
		$('Aboutus').focus();
		flag=1;	
	}else if(Services ==""){
		$('CatErrorMsg').innerHTML = "Please Enter the Services Content !";
		$('Services').focus();
		flag=1;	
	}else if(Contactus ==""){
		$('CatErrorMsg').innerHTML = "Please Enter the Contact Us Content !";
		$('Contactus').focus();
		flag=1;	
	}
	
	
	if(flag == 0){
		
	}
}*/
document.Frm_AddDeals.submit();

}

function CheckPayorFree(value){
	if(value == 1){
		$('SaveImages').style.display = "none";
		$('ShowPrice').style.display = "block";
	}else{
		$('ShowPrice').style.display = "none";
		$('SaveImages').style.display = "block";
	}	
}


/**** To Validate If the given string contains only Alphabets & Numbers, nothing else*********/
function isnumeric(str)
{
	var bReturn = true;
	var valid="0123456789.";
	var invalidfirst = "_-";
	var invalidlast = "_-";
	for (var i=0; i<str.length; i++) {
		if ( i == 0 && (invalidfirst.indexOf(str.charAt(i)) > 0))
		{
			bReturn = false;
			break;
		}
		else if ( i == (str.length-1) && (invalidlast.indexOf(str.charAt(i)) > 0))
		{
			bReturn = false;
			break;
		}
		else if (valid.indexOf(str.charAt(i)) < 0)
		{
			bReturn = false;
			break;
		}
	}
	return(bReturn);
}



</script>
<style style="text/css">
.bcontainer
{
width:950px;
margin:0 auto;
background-color:#eee;
border:#000000 solid 1px;
padding:15px;

}
.label{
float: left;
width: 180px;
font-weight: bold;
margin-right:15px;
}
.label h2
{
font:bold 18px Arial, Helvetica, sans-serif;
margin-top:5px;
}
input, textarea{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#777;
}

textarea{
width: 250px;
height: 150px;
padding:5px 10px;
}
</style>
{/literal}
<body>
<form name="Frm_AddDeals" id="Frm_AddDeals" method="post"  enctype="multipart/form-data">
<h2 style="margin-left:185px;">CMS</h2>
<div class="bcontainer">
<div style="width:530px; font-size:14px;color:#990000; margin:15px;font-weight:bold;" id="CatErrorMsg" align="center"></div>
<div style="clear:both"></div>
    <div style="clear:both"></div>


    <div style="clear:both"></div>

    <div style="clear:both"></div>


    <div style="clear:both"></div>



    <div class="label" style="margin-top:10px;">
    <h2>About Us </h2>
    </div>
    <div style="margin-top:10px;">
		<textarea name="Aboutus" id="Aboutus" rows="15" cols="80">{$cms.Aboutus}</textarea>
    </div>
    <div style="clear:both"></div>


    <div style="margin-top:10px;"></div>
    <div style="clear:both"></div>

    <div></div>
    <div style="clear:both"></div>


    <div></div>
    <div style="clear:both"></div>

    <div></div>
    <div style="clear:both"></div>


    <div></div>
    <div style="clear:both"></div>

    <div></div>
    <div style="clear:both"></div>


    <div></div>
    <div style="clear:both"></div>

    <div></div>
    <div style="clear:both"></div>


    <div class="label">
    <h2>Services </h2>
    </div>
    <div>
		<textarea name="Services" id="Services" rows="15" cols="80" >{$cms.Services}</textarea>
    </div>
    <div style="clear:both"></div>
    <div class="label">
    <h2>Contactus</h2>
    </div>
    <div>
		<textarea name="Contactus" id="Contactus" rows="15" cols="80">{$cms.Contactus}</textarea>
    </div>
    <div style="clear:both"></div>

    <div style="margin-top:10px;"></div>
    <div style="clear:both"></div>


    <div style="clear:both"></div>

    <div></div>
    <div style="clear:both"></div>


    <div align="center">
		 <img src="images/save.png" onClick="Add_Deal();" style="width:58px; height:29px; border:0;cursor:pointer;" />	
    </div>
    <div style="clear:both"></div>

</div>
<div style="clear:both">&nbsp;</div>
<div style="clear:both">&nbsp;</div>
</form>
{literal}
<script>
	loadTiny();
</script>
{/literal}	

</body>
