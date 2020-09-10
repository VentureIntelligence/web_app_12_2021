var TODBFILEPATH	=	"/2db";
var HTSLASH		=	"/";

function trim(str){
	if(str != ''){
		 var s = str.replace(/^(\s)*/, '');
		 s = s.replace(/(\s)*$/, '');
		 return s;
	}else{
		 return str;	
	}
}

// for validating email address
function validate_email(s){
	var i = 1;
	var valid_chars = '%&*()\'\";:/';
	for (i=0;i<s.length;i++){
		if (valid_chars.indexOf(s.charAt(i)) != -1){
			return false; 
		}
	}
	var sLength = s.length;
	i=1;
	while ((i < sLength) && (s.charAt(i) != "@")){
		i++;
	}
	if ((i >= sLength) || (s.charAt(i) != "@"))
       	return false; 
	else 
		i += 2;
		
   	while ((i < sLength) && (s.charAt(i) != ".")){
        i++;
   	}
	if ((i >= sLength - 1) || (s.charAt(i) != ".")){
		return false;
	}
	return true;
}


/********  TRIM LEFT FUNCTION ******************/
function lTrim(str){
	var whitespace = new String(" \t\n\r");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(0)) != -1) {
		// We have a string with leading blank(s)...
	    var j=0, i = s.length;
		while (j < i && whitespace.indexOf(s.charAt(j)) != -1)
		j++;
	    s = s.substring(j, i);
	}
	return s;
}

/****** TRIM RIGHT FUNCTION ****************/
function rTrim(str){
	var whitespace = new String(" \t\n\r");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
		var i = s.length - 1;       // Get length of string
		while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1)
			i--;
		s = s.substring(0, i+1);
	}
	return s;
}

/**********   TRIM FUNCTION **********************************/
function Trimnew(str){
  return rTrim(lTrim(str));
}


/********** For Validating Email Address*********/
function isValidEmail(str) {
	emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?(\w)+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/
	phoneRe = /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,3})|(\(?\d{2,3}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/
	if (!emailRe.test(str))	
		return false;	
	else
		return true;			
}

/********** For Validating Email Address*********/
function isValidPhone(str) {
	emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?(\w)+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/
	phoneRe = /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,3})|(\(?\d{2,3}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/
	if (!phoneRe.test(str))	
		return false;	
	else
		return true;			
}

/**** To Validate If the given string contains only Alphabets & Numbers, nothing else*********/
function isalphanumeric(str)
{
	var bReturn = true;
	var valid="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-";
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

function onlytstring(str)
{
	var bReturn = true;
	var valid="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
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

function atleastonecharstring(str)
{
	var reg1 = /.*[a-zA-Z].*/;
	if(reg1.test(str)){ 
			return true;
	} 
	return false;
}

/**** To Validate If the given string contains only Numbers, nothing else*********/
function isNumeric(str)
	{
		var bReturn = true;
		var valid="0123456789+- ";
		var invalidfirst = "+- ";
		var invalidlast = "+- ";
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



function IsNumericcheck(sText){
	var ValidChars = "0123456789.+_-*/!@#$%^&*()?><,':;~`";
	var IsNumber=true;
	var Char;
	for (i = 0; i < sText.length && IsNumber == true; i++){ 
		Char = sText.charAt(i); 
		if (ValidChars.indexOf(Char) == -1){
				IsNumber = false;
		}
	}
	return IsNumber;
}



//Submit data for ContactUsMailSend
//Submit data for ContactUsMailSend
function ContactUsMailSend(form){
var flag ="";	
	var	errmsg		=		"";
	var name		=		Trimnew($("ContactUs_Name").value);
	var email		=		Trimnew($("ContactUs_Email").value);
	var mobileno	=		Trimnew($("ContactUs_Phone").value);
	var subject		=		Trimnew($('ContactUs_Sub').value);
	var Message		=		Trimnew($('ContactUs_Msg').value);
	var captcha		=		Trimnew($("security_code").value);
	var namelower=name.toLowerCase(); 

	
	if(name==""){
		errmsg	=	"Please Enter Name";
		$('ContactUs_Name').focus();
		flag=1;
	}else	if(email==""){
		errmsg	=	"Please Enter Email";
		$('ContactUs_Email').focus();
		flag=1;
	}else if (!isValidEmail(email)){
		errmsg	=	"Please Enter Valid Email Address";
		$('ContactUs_Email').focus();
		flag=1;
	}else if(mobileno == ""){
		errmsg	=	"Please Enter a Mobile Number";
		$('ContactUs_Phone').focus();
		flag=1;
	}else if(!isNumeric(mobileno)){
		errmsg	=	"Please Enter Valid Mobile Number";
		$('ContactUs_Phone').focus();
		flag=1;
	}else if(subject == ""){
		errmsg	=	"Please Enter a Subject";
		$('ContactUs_Sub').focus();
		flag=1;
	}else if(Message == ""){
		errmsg	=	"Please Enter a Message";
		$('ContactUs_Msg').focus();
		flag=1;
	}else if(captcha == ""){
		errmsg	=	"Please Enter a Security Code";
		$('security_code').focus();
		flag=1;
	}
	
		if(flag	==	1){
		$('erpar').innerHTML= errmsg;
	return false;	 
	}	

	if(flag==0){
		document.ContactusForm.submit();


	}
}