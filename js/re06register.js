function checkFields()
{

missinginfo = "";
var namestr="";
var members="";
var attendee = document.re06register.noofattendee.value;
var e=document.getElementsByName("Names[]");
var f=document.getElementsByName("Emails[]");

for (var i=0;i<attendee;i++)
{
	chk=e[i].value;
	chkmail=f[i].value;
	members=members+ chk+ '/'+chkmail +',' ;

}

document.re06register.hidMembers.value=members;

   if(members !="")
   {

   }
   else
{ missinginfo += "\n     -  Email / Name";}



document.re06register.Paymode[0].checked==false

document.re06register.Paymode[1].checked==false
document.re06register.Paymode[2].checked==false



if (document.re06register.Fullname.value == "") {

missinginfo += "\n     -  First Name";

}



if (document.re06register.FirmName.value == "") {

missinginfo += "\n     -  Firm Name";

}



if (document.re06register.Address1.value == "") {

missinginfo += "\n     -  Address";

}



if (document.re06register.City.value == "") {

missinginfo += "\n     -  City";

}



if (document.re06register.State.value == "") {

missinginfo += "\n     -  State";

}



if (document.re06register.Postal.value == "") {

missinginfo += "\n     -  Postal Code";

}



if (document.re06register.Telephone.value == "") {

missinginfo += "\n     -  Telephone";

}



if (document.re06register.YourMail.value == "") {

missinginfo += "\n     -  Email Id";

}

if (document.re06register.YourMail.value.length != 0)
{

	if(document.re06register.YourMail.value.match(/[a-zA-Z0-9]+\@[a-zA-Z0-9-]+(\.([a-zA-Z0-9]{2}|[a-zA-Z0-9]{2}))+/)==null)

	{

		alert("Please enter a valid E-mail ID (eg: info@ventureintelligence.com)");

		document.re06register.YourMail.focus();

		return false;

	}

}
if ((document.re06register.pricingmode[0].checked==false) && (document.re06register.pricingmode[1].checked==false))

{

missinginfo += "\n      - Pricing Mode";

}




if ((document.re06register.Paymode[0].checked==false) && (document.re06register.Paymode[1].checked==false) && (document.re06register.Paymode[2].checked==false))

{

missinginfo += "\n      - Payment Mode";

}



if (missinginfo != "") {

missinginfo ="\n" +

"You failed to correctly fill in your:\n" +

missinginfo + "\n" +

"\nPlease re-enter and submit again!";

alert(missinginfo);



return false;

}

else return true;



}