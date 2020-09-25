{include file="header.tpl"}
{include file="leftpanel_ioc.tpl"}

<div class="container-right">
<!-- {if $searchupperlimit gte $searchlowerlimit}   --> 

{literal}
<style>
.search-main li label,form.custom .custom.disabled{
    opacity:0.6
}
  .entry-pad{
  padding:0px 10px; }
  #sec-header,.sec-header-fix{
        display: none !important;
  }
  #header .left-box,.logo{
    border-bottom: 1px solid #000;
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

  .faq-answer {
  display: none;
  }
  .slide-bg{
    background: none !important;
  }
  #search_by{
    font-weight: 600;
    font-size: 18px;
    padding-bottom: 5px;
    margin-bottom: 5px;
  }

  .form-control{
    font-family: calibri !important;
    font-size: 16px !important;
    height: 42px !important;
    padding: 10px !important;
    border-width: 1.7px;
    width: 225px !important;
    border-color: black;
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
        .result-cnt{
          padding: 2% 0% 8% 0% ;
        }
#result_cc:hover{
  width: 100%;
    background-color: #ccc;
   padding: 2px 5px;
    border: 1px solid #999;
}   
#result_cc{
  width: 100%;
  padding: 2px 5px;
  border: 1px solid transparent;
} 
#result_cc label:hover{
  cursor:pointer;
}
.company_name, #testcompany, #testholderval{
  width:375px !important;
}    
 #testcompany, #testholderval{
    max-height: 195px !important;
 }
 @media (min-width: 1025px) and (max-width: 1281px) {
   .company_name, #testcompany, #testholderval {
    width: 330px !important;
}

}

    </style>
{/literal}

<div id="container " >
{include file="filters_ioc.tpl"}
    <div class="result-cnt" >
        <div id="container" style="width:100%;margin-top: 10px;    display: inline-flex;">
            <div style="word-break: break-all;">
               
                    
                <div id="accordion" style="margin-top:6px;">
                 <label id="search_by"  style="font-size:22px;float: left;padding: 12px 20px;font-weight: 600;">Search by:</label>
                    <div style="float:left">
                    <input typr="text" class="form-control company_name" id="companylist" autocomplete="off" placeholder="Company Name" style="border:1px solid #ccc;"/> 
                    <div id="testcompany" style="  overflow-y: auto;  max-height: 118px;  background: #e6e6e6;display:none; width:225px;">
                    </div>
                    </div>
                    <div style="font-size: 18px;float: left;padding: 12px 20px;font-weight: 600;">
                      <label > or </label>
                    </div>
                    <div style="float:left">
                      <input typr="text" class="form-control company_name" id="chargeholderlist" autocomplete="off" placeholder="Charge Holder Name" style="border:1px solid #ccc;"/> 
                      <div id="testholderval" style="  overflow-y: auto;  max-height: 118px;  background: #e6e6e6;display:none; width:225px;">
                      </div>
                    </div>
                </div>
                
            </div>
        </div>

<!-- {else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if} -->

<!-- End of container-right -->

</div>
<div class="" style="margin-left: 20px;">
        <p class="findcom">
            <label>Dont find a Company ?</label>
            <a href="javascript:void(0)" class="updateFinancialHome" style="color:#000;">Click here to request for Charge details</a>
        </p>
       
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

<!-- End of Container -->
{literal}

 <script>
 $(document).ready(function () {
$('#companylist,#chargeholderlist').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});
 });

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
        $("#testholderval").fadeIn();
        $("#testholderval").html(data);
        var drop = $('#testholderval').height();
        if(drop >= 150){
        $(".result-cnt").css("padding","2% 0% 0% 0%");
        }else{
          $(".result-cnt").css("padding","2% 0% 8% 0%");
        }
      }
    });
  }
  else{
  
  $("#testholderval").fadeOut();
  $("#testholderval").empty();
  $(".result-cnt").css("padding","2% 0% 8% 0%");
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
         var drop = $('#testcompany').height();
        if(drop >= 150){
         $(".result-cnt").css("padding","2% 0% 0% 0%");
        }else{
          $(".result-cnt").css("padding","2% 0% 8% 0%");
        }
      }
    });
  }
  else{
  $("#testcompany").fadeOut();
  $("#testcompany").empty();
  $(".result-cnt").css("padding","2% 0% 8% 0%");
}

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
    
        $('#testcompany #result_cc label').live("click", function() {  //on click 
                      
                       var sltholder='';
                       var sltcount=0;
                                                   
                              var holder = $(this).text();                             
                             
                                 if(sltcount==0) { sltholder+=holder; }
                                 else { sltholder+=","+holder; }
                             
                              $("#testcompany").show();
                     $("#companylist").attr('readonly','readonly');  
                     $("#companylist").val(sltholder); 
                      $('#pgLoading').css('display', 'block');
                       $('#pgLoading')
  .delay(15000)
  .queue(function (next) { 
    $(this).css('display', 'none'); 
    next(); 
  });
             });
        $('#testholderval #result_cc label').live("click", function() {  //on click 
                      
                       var sltholder='';
                       var sltcount=0;
                                                   
                              var holder = $(this).text();                             
                             
                                 if(sltcount==0) { sltholder+=holder; }
                                 else { sltholder+=","+holder; }
                             
                              $("#testholderval").show();
                     $("#chargeholderlist").attr('readonly','readonly');  
                     $("#chargeholderlist").val(sltholder); 
                      $('#pgLoading').css('display', 'block');
                       $('#pgLoading')
  .delay(15000)
  .queue(function (next) { 
    $(this).css('display', 'none'); 
    next(); 
  });
             });

      // $('.ch_holder').live("click", function() {  //on click 
                      
      //                 var sltholder='';
      //                 var sltcount=0;
      //                 $('.ch_holder').each(function() { //loop through each checkbox
                          
      //                     if(this.checked) {                              
      //                        var holder = $(this).val();                             
                             
      //                           if(sltcount==0) { sltholder+=holder; }
      //                           else { sltholder+=","+holder; }
                             
      //                        sltcount++;
      //                        $("#testholder").show();
      //                         //sltuserscout++;
      //                     }
                          
      //                });
                     
      //               $("#chargeholderlist").attr('readonly','readonly');  
      //               $("#chargeholderlist").val(sltholder); 
                    
                    
      //               if(sltcount==0){  $("#charge_clearall").fadeOut(); $("#chargeholderlist").removeAttr('readonly');   }
      //               else {   $("#charge_clearall").fadeIn();  }
                        
      //   if($(".ch_holder").length==$(".ch_holder:checked").length){
            
      //       $("#selectall").attr("checked","checked");
      //   }else{
      //       $("#selectall").removeAttr("checked");
      //   }
                     
                 
      //        });
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
