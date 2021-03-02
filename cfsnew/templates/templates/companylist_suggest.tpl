{include file="header.tpl"}

</form>
<div class="container-right">
<!-- {if $searchupperlimit gte $searchlowerlimit}   --> 

{literal}
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<style>
#previous{
float: left;
    margin-left: 0 !important;
    text-decoration: none;
    font-size: 14px;
    text-transform: uppercase;
    float: left;
    padding: 5px 10px;
    color: #fff;
    background-color: #A2753A;
    display: inline-block;
}
 #maskscreen {
            position: fixed;
            left: 0;
            top: 0;
            right:0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            z-index: 8000;
            overflow: hidden;
            display: none;
        }
 
hr{
  border: none;
    height: 3px;
    background: #ccc;
    margin-bottom: 12px;
}
#chargesholderDetails tr td {
    padding: 15px;
    border-bottom: 2px solid transparent !important;
}
#chargesholderDetails tr:last-child td{
  border-bottom: 2px solid #aaa !important;
}
#chargesholderDetails tr td:last-child,#chargesholderDetails tr th:last-child  {
    
   
    
    border-right: 2px solid transparent !important;
}
#chargesholderDetails tr td:first-child,#chargesholderDetails tr th:first-child
{
  
    border-left: 2px solid transparent !important;
}

table#chargesholderDetails{
  margin-bottom:10px;
  margin-top: 12px;
  

}
.btn-cnt .home_export {
    min-width: auto;
    padding: 6px 10px;
}
.list-tab li a.active, .list-tab li a:hover {
    height: 38px;
}
  .container-right{
        padding: 0 40px !important;
  }
  .entry-pad{
  padding:0px 10px; }
  #sec-header,.sec-header-fix{
        display: none !important;
  }
  #header .left-box,.logo{
    border-bottom: 1px solid #000;
  }
  .result-cnt{
        padding: 10px 20px 0px 20px !important;
  }
    
  .faq-title{
    font-weight: 700;
    font-size: 17px;
    cursor: pointer;
    margin-top:20px;
    margin-bottom: 10px;
  }
  .faq-content {
    font-size: 14px;
    color: black;
  }

  .faq-asset {
    cursor: pointer;
    color: blue;
    text-decoration: underline;
  }

  .faq-asset-pdf {
    cursor: pointer;
    color: blue;
  }

  .faq-answer,.search-main {
  display: none;
  }
  .slide-bg{
    background: none !important;
  }
  #search_by{
          font-weight: 600;
    font-size: 16px;
    padding-bottom: 5px;
    margin-bottom: 5px;
  }

  .form-control{
    font-family: calibri !important;
    font-size: 16px !important;
    height: 35px !important;
    padding: 5px !important;
    width: 225px !important;
    border-color: black;
  }
 .updateFinancialHome{
       float: right;
    position: absolute;
    right: 0;
    top: 5px;
 }   
 .exportbutton{
       float: right;
    position: absolute;
    right: 0;
    top: 0px;
 }   
table, td, th {  
  border: 2px solid #aaa;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  padding: 15px;
}

#maskscreen {
position: fixed;
left: 0;
top: 0;
right:0;
bottom: 0;
background: rgba(0,0,0,0.8);
z-index: 8000;
overflow: hidden;
display: none;
}
.lookup-body { margin-bottom:20px; padding:10px; text-align: center; }
.lookup-body a,
.lookup-body a:hover,
.lookup-body a:focus,
.lookup-body a:visited { color: #fff; background: #7f6000; text-decoration: none; padding: 5px; }
.lookup-body span { font-size: 12px; }
.name-list{
text-transform: uppercase !important;
}
.filter-selected{
overflow: visible !important;
}
.list-tab{
clear:both !important;
}
form.custom .custom.dropdown ul li { width: 100%;}
#export-popup .agree-export {
margin-right: 10px;
}

#export-popup .close-lookup {
background-color: #000;
}
.fa-sort{
  float:right !important;
  margin-top: 2px;
}
.valuesort:hover{
  cursor:pointer;
}

</style>
{/literal}
<div id="container" >
 <form method="post" id="Frm_HmeSearch1" action="chargesholderlist_suggest.php">
                      <input type="hidden" name="holderhiddenval" class="holderhiddenval" value='{$ChargesholderName}'>
</form>    

{if $Companyid !=''}
<div style="padding:0px !important;font-size: 17px;position:relative;margin-top: 25px;">
<a class="postlink" id="previous" href="indexofcharges.php?value=0" >&lt; Back</a>
  <h2 style="color: #9f7917;font-size: 20px;text-align: center;"><a style="color: #9f7917;font-size: 20px;" target="_blank" href='details.php?vcid={$Companyid}'>{$FCompanyName} 
  <b style="font-size: 17px;color: #414141;">(Brand Name: <u>{$SCompanyName}</u>)</b></a></h2>
  <div class="exportbutton" >
  
    <form name="Frm_Compare" id="exportform_company" action="ioc_companylist.php" method="post" class="custom" enctype="multipart/form-data">

    <div class="btn-cnt" style="float:right; padding-top:0px !important;padding-bottom:0px !important">
      <input name="company_exportid" type="hidden" value="{$CompanyID}">
      <input name="exportcompare_company" class="home_export" id="exportcompare_company" type="button" value="EXPORT">
    </div>
    </form>

  </div>
  
  {else}
  <div style="padding:0px !important;font-size: 17px;position:relative;top: -40px;"><a href="javascript:void(0)" class="updateFinancialHome" >Click here to request for financials</a></div>

  <div style="padding:0px !important;font-size: 17px;position:relative;margin-top: 50px;">
<a class="postlink" id="previous" href="indexofcharges.php?value=0" >&lt; Back</a>
  <h2 style="color: #9f7917;font-size: 20px;text-align: center;">{$Searchcompany}</h2>
  <div class="exportbutton" >
  
    <form name="Frm_Compare" id="exportform_company" action="ioc_companylist.php" method="post" class="custom" enctype="multipart/form-data">

    <div class="btn-cnt" style="float:right; padding-top:0px !important;padding-bottom:0px !important">
      <input name="company_exportid" type="hidden" value="{$CompanyID}">
      <input name="exportcompare_company" class="home_export" id="exportcompare_company" type="button" value="EXPORT">
    </div>
    </form>

  </div>
  {* <h2 style="color: #9f7917;font-size: 20px;text-align: center;">{$Searchcompany}</h2>
  <form name="Frm_Compare" id="exportform_company" action="ioc_companylist.php" method="post" class="custom" enctype="multipart/form-data">
<div class="exportbutton" >
    <div class="btn-cnt" style="float:right; padding-top:0px !important;padding-bottom:0px !important">
      <input name="company_exportid" type="hidden" value="{$CompanyID}">
      <input name="exportcompare_company" class="home_export" id="exportcompare_company" type="button" value="EXPORT">
    </div>
    </form>
    </div> *}
   {* <a href="javascript:void(0)" class="updateFinancialHome" >Click here to request for financials</a> *}
   <div style="float:right;">
  
  </div>
  {/if}
  
</div>  
<div class="lb" id="popup-box">
	<div class="title">Dont find a Company ?</div>
        <form name="addDBFinacials" id="addDBFinacials">
            <div class="entry entry-pad" style="padding-top:10px"> 
        	<label> From</label>
                <input type="text" name="fromaddress" id="fromaddress" value="{$userEmail}"  />
        </div>
        <div class="entry entry-pad">
        	<label> To</label>
                <input type="text" name="toaddress" id="toaddress" value="cfs@ventureintelligence.com" readonly="" />
        </div>
        <div class="entry entry-pad">
        	<label> CC</label>
                <input type="text" name="cc" id="cc" value="" />
        </div>
                <input type="hidden" name="subject" id="subject" value="Please add financials of the company to the Database" readonly="" />
        <div class="entry entry-pad"> 
        	<h5>Message</h5>
                <textarea name="textMessage" id="textMessage">Please add to the database financials for the company. </textarea>
        </div>
        <div class="entry">
            <input type="button" value="Send" id="mailbtn1" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

    </form>
</div>
<div id="maskscreen"></div>
{if $ioc_fstatus}
    <div class="list-tab"  style="margin-top: 12px;">
<ul>

<li><a class="postlinkval" {if $ioc_fstatus eq 1}href="chargesholderlist_suggest.php?ioc_fstatus=1{if $ioc_fchargeaddress neq ''}&chargeaddress={$ioc_fchargeaddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{/if}{if $pageno}&page={$pageno}{/if}{if $stateid neq ''}&stateid={$stateid}{/if}{if $cityid neq ''}&cityid={$cityid}{/if}"><i class="i-grid-view"></i> LIST VIEW</a></li>

<li><a class="postlink active" href="#"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>

<div class="page-no" style="position: initial;"><span></span></div>
</div>
{/if}
<hr />
<b style="margin: 0px 16px; font-size: 15px;">Charges Registered</b>
<br />

<table class="table table-bordered" id="chargesholderDetails">
    <thead>
      <tr>
        <th width="3%">SNo</th>
        <th width="3%">SRN</th>
        <th width="5%">Charge Id</th>
        <th width="12%">Charge Holder Name</th>
        <th width="11%" class="valuesort" onclick="sortTable(4)" >Date of Creation  <i class="fa fa-fw fa-sort"></i></th>
        <th width="12%">Date of Modification</th>
        <th width="13%" class="valuesort" onclick="sortTable(6)">Date of Satisfaction <i class="fa fa-fw fa-sort"></i></th>
        <th width="12%" class="valuesort" onclick="sortTable(7)">Amount (INR Cr) <i class="fa fa-fw fa-sort"></i></th>
        <th width="25%" >Address</th>
      </tr>
    </thead>
    <tbody>
    {assign var=val value=1}
    {section name=List loop=$SearchResults} 
    
      <tr>
        <td>{math equation="($val)"}</td>
        <td>{$SearchResults[List].SRN}</td>
        <td>{$SearchResults[List].chargeid}</td>
        <td>{$SearchResults[List].chargeholder}</td>
        <td style="text-align: center;">
          {if $SearchResults[List].Created_Date != ''}
            {$SearchResults[List].Created_Date|date_format:"%d/%m/%G"}
            {else}
            <center> - </center>
          {/if}
        </td>
        <td style="text-align: center;">
          {if $SearchResults[List].Modified_Date != ''}
            {$SearchResults[List].Modified_Date|date_format:"%d/%m/%G"}
            {else}
            <center> - </center>
          {/if}
        </td>
        <td style="text-align: center;">
         {if $SearchResults[List].dateofcharge != ''}
            {$SearchResults[List].dateofcharge|date_format:"%d/%m/%G"}
            {else}
            <center> - </center>
          {/if} 
        </td>
        <td>{math equation="x/y" format="%.2f" x=$SearchResults[List].amount y=10000000}</td>
        <td style="word-break: break-all;" >{$SearchResults[List].Address|replace:',':', '}</td>
 
      </tr>
      {assign var=val value=$val+1}
    {/section}
    {if count($SearchResults) eq 0}
    <tr><td colspan="9"><center> No data found </center></td></tr>
    {/if}
    </tbody>
  </table>


<div id="maskscreen"></div>
<div class="lb" id="export-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
<span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
<div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
<b><a href="javascript:;" class="agree-export">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> -->
</div>
</div>
<!-- {else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if} -->

<!-- End of container-right -->

</div>
<!-- End of Container -->
{literal}

 <script>
 $("a.postlinkval").live('click',function(){
        hrefval= $(this).attr("href");
        $("#Frm_HmeSearch1").attr("action", hrefval);
        $("#Frm_HmeSearch1").submit();
        return false;
     });
 $('.updateFinancialHome').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
            $('#cancelbtn').click(function(){ 
        
               jQuery('#popup-box').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
 function updateFinancials(from, to, subject, link){ 
        var textMessage = $('#textMessage').val();
          if(textMessage !='')
          {
              $.ajax({
                 url: 'ajaxsendmails.php',
                  type: "POST",
                 data: { to : to, subject : subject, message : textMessage , url_link : link, from : from },
                 success: function(data){
                        if(data=="1"){
                            alert("Your request has been sent successfully");
                           jQuery('#popup-box').fadeOut();   
                           jQuery('#maskscreen').fadeOut(1000);
                    }else{
                        alert("Try Again");
                    }
                 },
                 error:function(){
                     alert("There was some problem sending request...");
                 }

             });
           }
       }
        $(document).on('click','.faq-title',function () {
$('.faq-answer').hide();

$(this).next('.faq-answer').fadeIn();
});

$(document).on('click','.faq-asset',function () {
var assetUrl = $(this).attr('data-link');


});
$(document).on('click','.faq-asset',function(){
    $(".video-link").attr("src","");
    $(".faqvideo").css("display","block");
    var value=$(this).attr("data-link");
    $(".video-link").attr("src",value);
    $(".faqvideo").load();
    $(".faqvideo").play();
});

$( "#chargeholderlist" ).keyup(function() {
  var chargeholder = $("#chargeholderlist").val();
  if(chargeholder.length > 3 ) {
    $.ajax({
      type: "post",
      url: "chargeholder_list.php",
      data: {
        chargeholder: chargeholder
      },
      success: function(data) {
        $("#testholder").fadeIn();
        $("#testholder").html(data);
      }
    });
  }
  else{
  $("#testholder").fadeOut();
}

});

$( "#companylist" ).keyup(function() {
  var companyname = $("#companylist").val();
  if(companyname.length > 3 ) {
    $.ajax({
      type: "post",
      url: "company_list.php",
      data: {
        companyname: companyname
      },
      success: function(data) {
        $("#testcompany").fadeIn();
        $("#testcompany").html(data);
      }
    });
  }
  else{
  $("#testcompany").html('No Data Found');
}

});

</script>
<script>
function sortTable(n) {
 var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("chargesholderDetails");
  switching = true;
  //Set the sorting direction to ascending:
  dir = "asc"; 
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      if(n!=7){
      x = rows[i].getElementsByTagName("TD")[n];
      var dateAr = x.innerHTML.split('/');
      var newDate = dateAr[3] + '-' + dateAr[2] + '-' + dateAr[1];

      y = rows[i + 1].getElementsByTagName("TD")[n];
      var dateAr1 = y.innerHTML.split('/');
      var newDate1 = dateAr1[3] + '-' + dateAr1[2] + '-' + dateAr1[1];

      
       if (dir == "asc") {
        
        if (newDate.toLowerCase() > newDate1.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (newDate.toLowerCase() < newDate1.toLowerCase()) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
      }else{
        
        x =rows[i].getElementsByTagName("TD")[n];
     // console.log(x);
       y = rows[i + 1].getElementsByTagName("TD")[n];
        if (dir == "asc") {
       // alert(typeof(parseInt(x.innerHTML)));
        if (parseFloat(x.innerHTML) > parseFloat(y.innerHTML)) {
          //if so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
       
        if (parseFloat(x.innerHTML) < parseFloat(y.innerHTML)) {
          //if so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
      }
      /*check if the two rows should switch place,
      based on the direction, asc or desc:*/
     
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      //Each time a switch is done, increase this count by 1:
      switchcount ++;      
    } else {
      /*If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again.*/
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
$('table tr').each(function(index) {
$(this).find('td:nth-child(1)').html(index+0);
});
}

     // Export ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$('input[name=exportcompare_company]#exportcompare_company').click(function(){
jQuery('#maskscreen').fadeIn(1000);
$( '#export-popup' ).show();
return false;
});
$( '.agree-export' ).on( 'click', function() {
initExport();
jQuery('#maskscreen').fadeOut(1000);
$( '#export-popup' ).hide();
return false;
});
$( '#export-popup' ).on( 'click', '.close-lookup', function() {
$( '#export-popup' ).hide();
jQuery('#maskscreen').fadeOut(1000);
});
function initExport(){
$.ajax({
url: 'ajxCheckDownload.php',
dataType: 'json',
success: function(data){
var downloaded = data['recDownloaded'];
var exportLimit = data.exportLimit;
var currentRec = 123
//alert(currentRec + downloaded);
var remLimit = exportLimit-downloaded;
$("#exportform_company").submit();
if (currentRec < remLimit){
$("#exportform_company").submit();
}else{
//alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
}
},
error:function(){
alert("There was some problem exporting...");
}

});
}
 $('#mailbtn1').click(function(e){
        e.preventDefault(); 
        var to = $('#toaddress').val().trim();
        var subject = $('#subject').val().trim();
        var textMessage = $('#textMessage').val().trim();
        var from = $('#fromaddress').val().trim();
        var cc = $('#cc').val().trim();
        if(from ==''){
            alert("Please enter the from address");
            $('#fromaddress').focus();
            return false;
        }
        else if(!(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/).test(from)){
            alert('Invalid from address');
            $('#fromaddress').focus();
            return false;
        }
        else if((cc !='') && (!(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/).test(from))){
            alert('Invalid CC');
            $('#fromaddress').focus();
            return false;
        }
        else if(textMessage =='')
        {
          alert("Please enter the message");
            $('#textMessage').focus();
            return false;
        }else{
            $.ajax({
               url: 'ajaxsendmails.php',
                type: "POST",
               data: { to : to, subject : subject, message : textMessage , cc: cc, from : from },
               success: function(data){
                      if(data=="1"){       
                          alert("Your request has been sent successfully"); 
                         // $('#addDBFinacials')[0].reset();
                         $('#fromaddress').val('');
                         $('#textMessage').val('');
                         $('#cc').val('');
                         jQuery('#popup-box').fadeOut();   
                         jQuery('#maskscreen').fadeOut(1000); 
                        return true;
                  }else{
                      alert("Try Again");
                        return false;
                  }
               },
               error:function(){
                   alert("There was some problem sending request...");
                    return false;
               }
           });
           }
       }); 
     
</script>
{/literal}


</body>
</html>
