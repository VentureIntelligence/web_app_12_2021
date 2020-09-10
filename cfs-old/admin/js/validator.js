// JavaScript Document
function Validation(formName){

	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	retvalue = true;
	
	var element = document.getElementById('test');
	var elementsForms = getElementsByTagNames('input,select,textarea',element);
	var ErrorVariable = "";
	for (var intCounter = 0; intCounter < elementsForms.length; intCounter++){ 
		elm = elementsForms[intCounter];
		name = elm.getAttribute("name");
		ErrorName = elm.getAttribute("forError");
		id = elm.className;
		lname = 'req_'+name;
		element = document.forms[formName].elements[name];
		label = document.getElementById(lname);
		
		if(id == 'req_value') {
			if(element.value == '') {
				if(label != "null"){
					label.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label.setAttribute("class","");
				
			}
		} else if(id == 'req_digit') {
			if(element.value == '') {
				label.setAttribute("class","error");
				retvalue = false;
			} else if(isNaN(element.value)) {
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.setAttribute("class","");
			}
		} else if(id == 'req_file') {
			if(element.value == '' && document.forms[formName].elements[name+'_old'].value == '') {
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.setAttribute("class","");
			}
		} else if(id == 'req_email') {
			if(element.value == '') {
				label.setAttribute("class","error");
				retvalue = false;
			} else if (!(emailFilter.test(element.value))) {
				label.innerHTML = 'Invalid Email';
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.innerHTML = 'Email';
				label.setAttribute("class","");
			}
		} else if(id == 'req_password') {
			label_pwd_agn = document.getElementById('req_answer[password_again]');
			if(element.value == '') {
				label.setAttribute("class","error");
				label_pwd_agn.setAttribute("class","error");
				retvalue = false;
			} else if(element.value.length < 4) {
				label.innerHTML = 'Weak Password';
				label.setAttribute("class","error");
				label_pwd_agn.setAttribute("class","error");
				retvalue = false;
			} else if(element.value	!= 	document.forms[formName].password_again.value) {
				label.innerHTML = 'Passwords differs';
				label.setAttribute("class","error");
				label_pwd_agn.setAttribute("class","error");
				retvalue = false;
			} else {
				label.innerHTML = 'Password';
				label.setAttribute("class","");
				label_pwd_agn.setAttribute("class","");
			}
		}else if(id == 'req_checkbox'){
			if(element.checked == false) {
				if(label != "null"){
					label.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label.setAttribute("class","");
				
			}
		}else if(id == 'req_radiobtn'){
			if(element.checked == false) {
				if(label != "null"){
					label.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label.setAttribute("class","");
				
			}
		}
		
			

	}//For Ends 
	return retvalue;
}

function getElementsByTagNames(list,obj) {
	if (!obj) var obj = document;
	var tagNames = list.split(',');
	var resultArray = new Array();
	for (var i=0;i<tagNames.length;i++) {
		var tags = obj.getElementsByTagName(tagNames[i]);
		for (var j=0;j<tags.length;j++) {
			resultArray.push(tags[j]);
		}
	}
	var testNode = resultArray[0];
	if (!testNode) return [];
	if (testNode.sourceIndex) {
		resultArray.sort(function (a,b) {
				return a.sourceIndex - b.sourceIndex;
		});
	}
	else if (testNode.compareDocumentPosition) {
		resultArray.sort(function (a,b) {
				return 3 - (a.compareDocumentPosition(b) & 6);
		});
	}
	return resultArray;
}




function setid(op,extra) 	{
	document.detailsform.op.value=op;
	document.detailsform.extra.value=extra;
	document.detailsform.submit();
}

function deleteReg(op,extra)
{	if (confirm("Are you sure you want to delete? ")) {
		
	document.detailsform.op.value=op;
	document.detailsform.extra.value=extra;
	document.detailsform.submit();

    } else {
       document.detailsform.op.value=op;
    }


}


function replace(arrayName,replaceTo, replaceWith)
{
  for(var i=0; i<arrayName.length;i++ )
  {  
    if(arrayName[i]==replaceTo)
      arrayName.splice(i,1,replaceWith);          
  }        
}


function isValidEmail(str) {
	emailRe = /^\w+([\.-]?\w+)*@\w+([\.-]?(\w)+)*\.(\w{2}|(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum))$/
	phoneRe = /^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,3})|(\(?\d{2,3}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$/
	if (!emailRe.test(str))	
		return false;	
	else
		return true;			
}

function EmailCheck(form){
	var flag ="";	
	var	errmsg		=		"";
	var Email		=		$("txt_Email").value;
	
	if (Email == ""){
		errmsg	=	"Please Enter Email Address";
		$('txt_Email').focus();
		flag=1;
	}else if (!isValidEmail(Email)){
		errmsg	=	"Please Enter Valid Email Address";
		$('txt_Email').focus();
		flag=1;
	}
	
	if(flag	==	1){
		$('erpar').innerHTML= errmsg;
		return false;	 
	}	
	if(flag==0){
		document.forgot_passForm.submit();
	}
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

function isValidImage(str) {
		var error=0;
		var exterror=0;
		var nameerror=0;
		var lastcount=str.split('\\').length;
		var uploadimg=str.split('\\')[lastcount-1];		//alert('img='+uploadimg);
		var pos=uploadimg.lastIndexOf(".");				//alert('pos='+pos);
		var str1=uploadimg.substring(pos);				//alert(str1);
		var str=str1.toLowerCase();						//alert('ext='+str);
		//Check if the Image is a valid format
		if(str==".jpg" || str== ".gif" || str==".jpeg" || str==".png"){
			exterror=0;	//The image is not a .jpg or .gif
		}else{
			exterror=1;	
		}
		//Check if the imagename is valid
		var imagename=uploadimg.substring(0,pos);
		if(isalphanumeric(imagename)==false){
			nameerror=2;
		}
		if(exterror==0 && nameerror==0){
			error=0;
		}else if(exterror!=0){
			error=exterror;
		}else if(nameerror!=0){
			error=nameerror;
		}
		
	return(error);		
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


/*CFS Starts*/

function ShowHide(value){
	if(value == 'gcompany'){
			document.getElementById('ParentCopmanyShowHide').style.display = "block";
	}else{
		document.getElementById('ParentCopmanyShowHide').style.display = "none";
	}		
}


function loadState(key) {
	new Ajax.Request('ajaxAdmin.php?af=loadState&key='+key, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			 $('stateDropDown').innerHTML=response;
		 } 	 
	}); 
}

function loadCity(key) {
	new Ajax.Request('ajaxAdmin.php?af=loadCity&key='+key, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			 $('cityDropDown').innerHTML=response;
		 } 	 
	}); 
}

function loadSector(key) {
	new Ajax.Request('ajaxAdmin.php?af=loadSector&key='+key, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			 $('sectorDropDown').innerHTML=response;
		 } 	 
	}); 
}

function loadNaicsCode(key) {
	var industryID = document.getElementById('answer[Industry]').value;
	new Ajax.Request('ajaxAdmin.php?af=loadNaicsCode&key='+key+'&industryID='+industryID, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			 document.getElementById('answer[Naics_code]').value = response;
		 } 	 
	});
}


function CFSValidation(formName){

	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	retvalue = true;
	
	var element = document.getElementById('test');
	var elementsForms = getElementsByTagNames('input,select,textarea',element);
	var ErrorVariable = "";
	for (var intCounter = 0; intCounter < elementsForms.length; intCounter++){ 
		elm = elementsForms[intCounter];
		name = elm.getAttribute("name");
		ErrorName = elm.getAttribute("forError");
		id = elm.className;
		lname = 'req_'+name;
		element = document.forms[formName].elements[name];
		label = document.getElementById(lname);
		
		if(id == 'req_value') {
			if(element.value == '') {
				if(label != "null"){
					label.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label.setAttribute("class","");
				
			}
		} else if(id == 'req_digit') {
			if(element.value == '') {
				label.setAttribute("class","error");
				retvalue = false;
			} else if(isNaN(element.value)) {
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.setAttribute("class","");
			}
		} else if(id == 'req_file') {
			if(element.value == '' && document.forms[formName].elements[name+'_old'].value == '') {
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.setAttribute("class","");
			}
		} else if(id == 'req_email') {
			if(element.value == '') {
				label.setAttribute("class","error");
				retvalue = false;
			} else if (!(emailFilter.test(element.value))) {
				label.innerHTML = 'Invalid Email';
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.innerHTML = 'Email';
				label.setAttribute("class","");
			}
		} else if(id == 'req_password') {
			label_pwd_agn = document.getElementById('req_answer[password_again]');
			if(element.value == '') {
				label.setAttribute("class","error");
				label_pwd_agn.setAttribute("class","error");
				retvalue = false;
			} else if(element.value.length < 4) {
				label.innerHTML = 'Weak Password';
				label.setAttribute("class","error");
				label_pwd_agn.setAttribute("class","error");
				retvalue = false;
			} else if(element.value	!= 	document.forms[formName].password_again.value) {
				label.innerHTML = 'Passwords differs';
				label.setAttribute("class","error");
				label_pwd_agn.setAttribute("class","error");
				retvalue = false;
			} else {
				label.innerHTML = 'Password';
				label.setAttribute("class","");
				label_pwd_agn.setAttribute("class","");
			}
		}else if(id == 'req_checkbox'){
			if(element.checked == false) {
				if(label != "null"){
					label.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label.setAttribute("class","");
				
			}
		}else if(id == 'req_radiobtn'){
			if(element.checked == false) {
				if(label != "null"){
					label.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label.setAttribute("class","");
				
			}
		}
		
			

	}//For Ends 
	return retvalue;
}

function loadAutoSuggest(key) {
	if(key){
		new Ajax.Request('ajax.php?af=loadAutoSuggest&key='+key, {
			 onSuccess: function(transport) { 
				 var response = transport.responseText;
				 $('AutoSuggestRs').innerHTML=response;
			 } 	 
		}); 
	}else{
		$('AutoSuggestRs').innerHTML= "No Results Found";
	}
}



function insertautoVal(key) {
	$('Country').value=key;
	if(key){
		new Ajax.Request('ajax.php?af=insertautoVal&key='+key, {
			 onSuccess: function(transport) { 
				 var response = transport.responseText;
				 $('txt').value=response;
			 } 	 
		}); 
	}else{
		$('AutoSuggestRs').innerHTML= "No Results Found";
	}
}

function EnableDisableCPass(){
	CPass = 	document.getElementById('answer[Password]').value;	
	if(CPass.length > 3) {
		document.getElementById('password_again').disabled  = false;
	}else if(CPass.length < 3) {
		document.getElementById('password_again').disabled  = true;
	}
}

function UserNameExistChk(key) {
	$('req_answer[UserName]').innerHTML = '';
	$('UNameError').innerHTML= '';
	new Ajax.Request('ajaxAdmin.php?af=UserNameExistChk&key='+key, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			 if(response != ''){
				 $('req_answer[UserName]').innerHTML = "UserName Already Exists !";
				 $('UNameError').innerHTML= response;	 
			 }
			 
		 } 	 
	}); 
}

function EmailExistChk(key) {
	 $('req_answer[Email]').innerHTML = '';
	$('EmailError').innerHTML= '';
	new Ajax.Request('ajaxAdmin.php?af=EmailExistChk&key='+key, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			 if(response != ''){
				 $('req_answer[Email]').innerHTML = "Email Address Already Exists !";
				 $('EmailError').innerHTML= response;	 
			 }
			 
		 } 	 
	}); 
}


function CFSRegistration(formName){
	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	var ErrorVariable = "";
	retvalue = true;
	 
	for (var intCounter = 0; intCounter < 5; intCounter++){ 
		var myArray=[document.getElementsByName("answer[UserName]")[0],document.getElementsByName("answer[Password]")[0],document.getElementsByName("password_again")[0],
					document.getElementsByName("answer[Email]")[0],document.getElementsByName("answer[FirstName]")[0]]; 
		
		elm = myArray[intCounter];
		name = elm.getAttribute("name");
		
		ErrorName = elm.getAttribute("forError");
		id = elm.className;
		id = id.split(" ",1);
		lname = 'req_'+name;
		element = elm;
		label = document.getElementById(lname);
				
		if(id == 'req_value') {
			if(element.value == '') {
				if(label != "null"){
					$Msg = ErrorName+' Should not be Empty !';
					label.innerHTML = $Msg;
					label.setAttribute("class","error");
				}
				retvalue = false;

			}else if(document.getElementById('UNameError').innerHTML != '' || element.value == 'answer[UserName]'){
				$Msg = 'UserName Already Exists !';
				label.innerHTML = $Msg;
				label.setAttribute("class","error");
				retvalue = false;
			}else {
				label.setAttribute("class","success");
				label.innerHTML = "OK";
			}
		} else if(id == 'req_email') {

			if(element.value == '') {
				$Msg = ErrorName+' Should not be Empty !';
				label.innerHTML = $Msg;
				label.setAttribute("class","error");
				retvalue = false;
			} else if (!(emailFilter.test(element.value))) {
				label.innerHTML = 'Invalid Email';
				label.setAttribute("class","error");
				retvalue = false;
				
			}else if(document.getElementById('EmailError').innerHTML != ''){
				$Msg = 'Email Address Already Exists !';
				label.innerHTML = $Msg;
				label.setAttribute("class","error");
				retvalue = false;
			} else {
				label.innerHTML = 'Email';
				label.setAttribute("class","success");
				label.innerHTML = "OK";
			}
		} else if(id == 'req_password') {

			label_pwd_agn = document.getElementById('password_again');
			label_pagain = document.getElementById('req_answer[password_again]');
			//alert(label_pwd_agn);
			//alert(label_pagain);
			PasswordError = document.getElementById('PasswordError');
					if(element.value == '') {
						$Msg = ErrorName+' Should not be Empty !';
						label.innerHTML = $Msg;
						label.setAttribute("class","error");
						retvalue = false;
					} else if(element.value.length < 4) {
						PasswordError.innerHTML = 'Weak Password';
						PasswordError.setAttribute("class","error");
						label.innerHTML = '';
						label.setAttribute("class","");
						retvalue = false;
					} else {
						label_pwd_agn.disabled  = false;
						//document.getElementById('CPassword').style.display = 'block';
						PasswordError.innerHTML = '';
						label.innerHTML = '';
						label.setAttribute("class","");
					}
					//alert(label_pwd_agn.value);
					//alert(element.value);
					//alert(document.forms[formName].password_again.value);
					if(label_pwd_agn.value == '') {
							$Msg = 'Confirm Pass. Should not be Empty !';
							label_pagain.innerHTML = $Msg;
							label_pagain.setAttribute("class","error");
							retvalue = false;
						}else if(element.value	!= 	document.forms[formName].password_again.value) {
							label_pagain.innerHTML = '';
							//label_pwd_agn.setAttribute("class","");
							PasswordError.innerHTML = 'Passwords differs';
							PasswordError.setAttribute("class","error");
							
							retvalue = false;
						}else{
							label.innerHTML = '';
							label_pagain.innerHTML = '';
							label_pagain.setAttribute("class","");
							label.setAttribute("class","");
							//label_pwd_agn.setAttribute("class","");
							PasswordError.innerHTML = '';
							PasswordError.setAttribute("class","");
		
					}			
			}

	}//For Ends

	return retvalue;
}



function upDateFinancial(op)
{	if (confirm("Company Already Exists ! Are you sure you want to Overwrite? ")) {
		
	document.Frm_AddCFinancials.op.value=op;
	document.Frm_AddCFinancials.submit();

    } else {
     document.Frm_AddCFinancials.op.value=op;
    }


}

function PLStandardValidation(formName){
	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	retvalue = true;
	label1 = document.getElementById('req_answer[CompanyId]');
	label2 = document.getElementById('req_answer[PLStandard]');
	label1.setAttribute("class","error");
	label2.setAttribute("class","error");
	var CompanyId = document.getElementById('answer[CompanyId]');
	var PLStandard = document.getElementById('answer[PLStandard]');
	var ErrorVariable = "";
			if(CompanyId.value == '') {
				
				if(label1 != "null"){
					label1.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label1.setAttribute("class","");
			}
			
			if(PLStandard.value == '') {
				
				if(label2 != "null"){
					label2.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label2.setAttribute("class","");
				CompanyExists(CompanyId.value);
			}
	return false;
	return retvalue;
}

function CompanyExists(key) {
	new Ajax.Request('ajaxAdmin.php?af=CompanyExists&key='+key, {
		 onSuccess: function(transport) { 
		 	 var response = transport.responseText;
			if(response != ''){
				upDateFinancial('YesConfirm');
			 }else{
				 document.Frm_AddCFinancials.submit();
			 }
			 
		 } 	 
	}); 

}


function PLDetailedValidation(formName){
	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	retvalue = true;
	var AddPLDetailCompanyId = document.getElementById('answer[AddPLDetailCompanyId]');
	var PLDetailed = document.getElementById('answer[PLDetailed]');
	var ErrorVariable = "";
			if(AddPLDetailCompanyId.value == '') {
				label1 = document.getElementById('req_answer[AddPLDetailCompanyId]');
				if(label1 != "null"){
					label1.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label1.setAttribute("class","");
			}
			
			if(PLDetailed.value == '') {
				label2 = document.getElementById('req_answer[PLDetailed]');
				if(label2 != "null"){
					label2.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label2.setAttribute("class","");
			}

	return retvalue;
}

function BSValidation(formName){
	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	retvalue = true;
	var BSCompanyId = document.getElementById('answer[BSCompanyId]');
	var BalSheet = document.getElementById('answer[BalSheet]');
	var ErrorVariable = "";
			if(BSCompanyId.value == '') {
				label1 = document.getElementById('req_answer[BSCompanyId]');
				if(label1 != "null"){
					label1.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label1.setAttribute("class","");
			}
			
			if(BalSheet.value == '') {
				label2 = document.getElementById('req_answer[BalSheet]');
				if(label2 != "null"){
					label2.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label2.setAttribute("class","");
			}

	return retvalue;
}


function CFValidation(formName){
	var elm,id,name,lname,value,retvalue,element,label;
	var emailFilter=/^.+@.+\..{2,3}$/;
	retvalue = true;
	var CFCompanyId = document.getElementById('answer[CFCompanyId]');
	var Cashflow = document.getElementById('answer[Cashflow]');
	var ErrorVariable = "";
			if(CFCompanyId.value == '') {
				label1 = document.getElementById('req_answer[CFCompanyId]');
				if(label1 != "null"){
					label1.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label1.setAttribute("class","");
			}
			
			if(Cashflow.value == '') {
				label2 = document.getElementById('req_answer[Cashflow]');
				if(label2 != "null"){
					label2.setAttribute("class","error");
				}
				retvalue = false;

			} else {
				label2.setAttribute("class","");
			}

	return retvalue;
}


/*CFS Ends*/