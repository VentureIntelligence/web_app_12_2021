{include file="header.tpl"}

{include file="leftpanel.tpl"}

<div class="container-right">
{if $searchupperlimit gte $searchlowerlimit}   
{include file="filters.tpl"}
{literal}
    <style>
.entry-pad{
padding:0px 10px; }
        .mobileRedirectPopup {
            position: fixed !important;
            background: #fff;
            height: 185px;
            width:700px;
            border-radius: 10px;
            left:50%;
            top:25%;
            margin-top:-92.5px;
            margin-left:-350px;
            -webkit-box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            z-index:1000;
            display:none;
        }
        .backdrop{
            height:100vh;
            width:100vw;
            background:rgba(50, 50, 50, 0.75);
            z-index:500;
            position:absolute;
            top:0px;
            left:0px;
            overflow:hidden;
        }
        .app-text-col h5{
            font-size:1em !important;
            color:#302922 !important;
            margin-left: 20px;
        }
        h5 {
            margin: 10px 0px;
        }

        .text-left {
            text-align: left;
        }

        .btn {
            padding: 10px;
            width: 100%;
            border-radius: 25px;
            border: 0px solid #000;
            -webkit-box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            text-decoration: none;
        }
         .redirect-button-col .btn {
            margin-top: 2px;
        }
        .redirect-button-col .btn-primary {
            background: #302922 !important;
        }
        .redirect-button-col .btn-primary a{
            color: white !important;
        }
        .redirect-button-col .btn-default {
            background: unset !important;
            color: #302922;
        }

        .d-none {
            display: none;
        }

        .d-block {
            display: block;
        }

        .row {
            width: 100%;
            display: flex;
            /* margin-left: -15px;
            margin-left: -15px; */
            margin: 10px 0;
        }

        .image-col {
            width: 18%;
            padding-right: 0px;
            padding-left: 15px;
        }

        .app-text-col {
            width: 50%;
            padding-right: 15px;
            padding-left: 0px;
        }

        .redirect-button-col {
            width: 35%;
            padding-right: 15px;
            padding-left: 15px;
            text-align: center;
        }

        .w-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }
        .popup-title{
            padding-left:20px;
            padding-right:20px;
            margin-bottom:15px;
        }
        .popup-title h5 {
            border-bottom: 1.25px solid #302922;
            padding-bottom: 10px;
            padding-top: 5px;
            font-size:1rem;
        }

        .image-col img {
            max-width: 50px !important;
            border-radius: 50px;
            height: 40px;
            margin-top:1px;
        }

        .btn a {
            text-decoration: none;
            color: #000;
        }

        .btn.btn-primary a {
            color: #fff !important;
        }

        .btn:focus {
            outline: none;
        }
    </style>
{/literal}
<div class="backdrop"></div>
<div class="list-tab"  style="margin-top: 26px;">
<ul>
<li><a  href="home.php" class="active postlink"><i></i> LIST VIEW</a></li>
<li><a class="postlink" href="{if count($SearchResults[List]) gt 0}details.php?vcid={$SearchResults[0].Company_Id}{else}#{/if}"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul><div class="page-no" style="position: initial;"><span>(in Rs. Cr) &nbsp;&nbsp;</span></div>
</div>

<div class="companies-list">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
        <th  class="sorthead {if $sortby eq "sortcompany"} {$sortorder} {/if}" id="sortcompany">Company Name</th>
<th class="sorthead {if $sortby eq "sortrevenue"} {$sortorder} {/if}" id="sortrevenue">Revenue</th>
<th class="sorthead {if $sortby eq "sortebita"} {$sortorder} {/if}" id="sortebita">EBITDA</th>
<th class="sorthead {if $sortby eq "sortpat"} {$sortorder} {/if}" id="sortpat">PAT</th>
<th class="sorthead {if $sortby eq "sortdetailed"} {$sortorder} {/if}" id="sortdetailed">Detailed</th>

{if $chargewhere neq ''}

 <th style='background:none'> Date of Charge</th> 
 <th style='background:none'> Charge Amount</th> 
 <th style='background:none'> Charge Holder</th> 
{/if}


{*<th> Filings	</th>*}</tr></thead>
<tbody>  
  
  {section name=List loop=$SearchResults}  
    
      <tr><td class="name-list" style="text-transform: uppercase"> <span class="has-tip" data-tooltip="" title="{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} Listed{elseif $SearchResults[List].ListingStatus eq '2'} Privately held(Ltd){elseif $SearchResults[List].ListingStatus eq '3'} Partnership {elseif $SearchResults[List].ListingStatus eq '4'} Proprietorship{/if}">{if $SearchResults[List].ListingStatus eq '0'}Both{elseif $SearchResults[List].ListingStatus eq '1'} L{elseif $SearchResults[List].ListingStatus eq '2'} PVT{elseif $SearchResults[List].ListingStatus eq '3'} PART {elseif $SearchResults[List].ListingStatus eq '4'} PROP{/if}</span>
              {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>	

        {else}
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >{$SearchResults[List].SCompanyName|lower|capitalize}</a>

        {/if}
              </td>
    <td>{if $SearchResults[List].TotalIncome eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].TotalIncome}{else}{math equation="x / y" x=$SearchResults[List].TotalIncome y=10000000 format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].EBITDA eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].EBITDA}{else}{math equation="x / y" x=$SearchResults[List].EBITDA y=10000000 format="%.2f"}{/if}</td>
    <td>{if $SearchResults[List].PAT eq 0}&nbsp;{elseif $SearchResults[List].GrowthPerc_Id or $SearchResults[List].CAGR_Id}{$SearchResults[List].PAT}{else}{math equation="x / y" x=$SearchResults[List].PAT y=10000000 format="%.2f"}{/if}</td>
    {if $SearchResults[List].FY gt 0}
    <td>
        {assign var="FY" value=" "|explode:$SearchResults[List].FY}
        {if $SearchResults[List].COMPANYNAME}
            <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}&c={$SearchResults[List].COMPANYNAME}" title="Click here to view Annual Report" 
         
        >FY{$FY[0]} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	

        {else}
        
        <a class="postlink" href="details.php?vcid={$SearchResults[List].Company_Id}" title="Click here to view Annual Report" 
       
        >FY{$FY[0]} </a>	(upto {if $SearchResults[List].FYValue eq 1} {$SearchResults[List].FYValue} Year {elseif $SearchResults[List].FYValue neq ''} {$SearchResults[List].FYValue} Years{/if} {if $SearchResults[List].GFY eq 1} {$SearchResults[List].GFY} Year {elseif $SearchResults[List].GFY neq ''} {$SearchResults[List].GFY} Years{/if} )	
        {/if}
       
    </td> 
     {else}
         <td><a> </a></td>
     {/if}
     
    {if $chargewhere neq ''}
  
    <td> {$SearchResults[List].dateofcharge} </td> 
    <td> {math equation="x / y" x=$SearchResults[List].chargeamt|replace:',':''  y=10000000 format="%.2f"} </td> 
    <td> {$SearchResults[List].chargeholder} </td> 
   {/if}
     
     
    {*<td>
        {if $SearchResults[List].filing eq "true"}
            <a class="postlink" href="viewfiling.php?c={$SearchResults[List].FCompanyName|escape:"url"}">View</a>
        {else}
            -
        {/if}
    </td>*}
  </tr>
  {/section}
   
  </tbody>
  </table>

{include file="pagination.tpl"}
</div>
<input type="hidden" name="sortby" id="sortby" value="{$sortby}"/>
<input type="hidden" name="sortorder" id="sortorder" value="{$sortorder}"/>
<input type="hidden" name="pageno" id="pageno" value="{$curPage}"/>
<input type="hidden" name="searchv" id="searchv" value="{$searchv}"/>
<input type="hidden" name="countflag" value="{$countflag}" class="countflag"/>
               <input type="hidden" id="filterData_top" name="filterData_top" value="{if $smarty.session.totalResults}{$smarty.session.totalResults_top}{/if}"/>
</form>

{if $searchexport}
    {if $chargewhere neq ''}
    <form name="Frm_Compare" id="exportform" action="homeexportwithcharges.php" method="post" enctype="multipart/form-data">
    {else}
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
    {/if}    
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel" value="{$searchexport}"/>
            <div class="btn-cnt p10" style="float:right;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
</div>

{elseif $searchexport2}
 {if $chargewhere neq ''}
    <form name="Frm_Compare" id="exportform" action="homeexportwithcharges.php" method="post" enctype="multipart/form-data">
    {else}
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
    {/if} 
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel1" value="{$searchexport2}"/>
            <div class="btn-cnt p10" style="float:right;"><input class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>


{elseif $searchexport3}
    {if $chargewhere neq ''}
    <form name="Frm_Compare" id="exportform" action="homeexportwithcharges.php" method="post" enctype="multipart/form-data">
    {else}
 <form name="Frm_Compare" id="exportform" action="homeexport.php" method="post" enctype="multipart/form-data">
    {/if} 
            <!--input type="hidden" name="exportenable" id="exportenable" value="0"/-->
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>     
            <input type="hidden" id="exportexcel" name="exportexcel2" value="{$searchexport3}"/>
            <div class="btn-cnt p10" style="float:right;"><input  class="home_export" name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
</div>

{/if}
</div>
  
{else}
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
{/if}

<!-- End of container-right -->

</div>
<!-- End of Container -->

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
<div class="lb" id="export-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" class="agree-export">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div class="mobileRedirectPopup">
        <div class="popup-title ">
            <h5 class="text-center">See Venture Intelligence in ...</h5>
        </div>
        <div class="row">
            <div class="image-col text-center"><img
                    src="images/cfs_app_icon@2x.png"></div>
            <div class="app-text-col">
                <h5 class="text-left vi_app">
                    VI <span class="login-type"></span> App
                </h5>
            </div>
            <div class="redirect-button-col">
                <button class="btn btn-primary"><a href="#" class="redirectApp">Open</a></button>
            </div>
        </div>
        <div class="row">
            <div class="image-col text-center">
            {if $user_browser eq "Safari"}
                <img
                    src="https://www.pngfind.com/pngs/m/314-3147164_download-png-ico-icns-flat-safari-icon-png.png"
            alt="">{/if}{if $user_browser eq  "Chrome"}
            <img
                    src="https://www.pngfind.com/pngs/m/98-981105_chrome-icon-free-download-at-icons8-icono-google.png"
                    alt="">
                   {/if}
                   </div>
            <div class="app-text-col">
                <h5 class="text-left">
                    {$user_browser}
                </h5>
            </div>
            <div class="redirect-button-col">
                <button class="btn btn-default continue">Continue</button>
            </div>
        </div>
    </div>
</body>
</html>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            var userAgent = navigator.userAgent.toLowerCase();
            var login = "cfs";
            var Android = navigator.userAgent.match(/Android/i);
            var IOS = navigator.userAgent.match(/iPhone|iPad|iPod|macintosh/i);
            var redirectButton = $(".redirectApp");
            var loginTextSpan = $(".login-type");
            if (Android) {
                $(".mobileRedirectPopup").show();
                if (login == "cfs") {
                    loginTextSpan.text("CFS");
                    redirectButton.attr("href", "intent://scan/#Intent;scheme=Venture+intelligence;package=com.venture.intelligence;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.venture.intelligence;end")

                } else if (login == "pe") {
                    loginTextSpan.text("PE");
                    redirectButton.attr("href", " intent://scan/#Intent;scheme=Venture+intelligence;package=com.intelligence.venture;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.intelligence.venture;end")
                }
                // alert("Android")
            } else if (IOS) {
                // alert("IOS")
                $(".mobileRedirectPopup").hide();
                $(".backdrop").hide();
            }else{
                //alert("desktop");
                $(".mobileRedirectPopup").hide();
                $(".backdrop").hide();
            }
        })
        var Android = navigator.userAgent.match(/Android/i);
        if (!Android) {
                if (login == "cfs") {
                    loginTextSpan.text("CFS");
                    redirectButton.attr("href", "intent://scan/#Intent;scheme=Venture+intelligence;package=com.venture.intelligence;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.venture.intelligence;end")

                }
               
            } else {
                // alert("IOS")
                $(".mobileRedirectPopup").hide();
                $(".backdrop").hide();
            }
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        $(".redirect-button-col .btn").on("click", function () {
            setCookie("mobilepopupcfs", "show", 1);
        });
        $(".continue").on("click", function () {
            $(".mobileRedirectPopup").hide();
            $(".backdrop").hide();
            setCookie("mobilepopupcfs", "show", 1);
        })

        $(document).ready(function(){
          
           var Android = navigator.userAgent.match(/Android/i);
            IOS = navigator.userAgent.match(/iPhone|iPad|iPod|macintosh/i);
            if(Android ){
                 
                    var popup = getCookie("mobilepopupcfs");
                    if (popup == "show") {
                        $(".mobileRedirectPopup").hide();
                        $(".backdrop").hide();  
                    }else{
                        
                            $(".mobileRedirectPopup").show();
                            $(".backdrop").show();
                        
                    }
                        
            }else{
                        $(".mobileRedirectPopup").hide();
                        $(".backdrop").hide();
                    }
       })

        $(document).ready(function() {
              $(".sorthead").live('click',function(){
                 // $(this).html($(this).text()+'<img src="images/ajax-loader.gif" style="float:right;height:20px;"/>');
                 $(this).addClass('loadingth');
                sortby=$(this).attr('id');
                if($(this).hasClass("asc")){
                    sortorder="desc";
                }
                else if($(this).hasClass("desc")){
                    sortorder="asc";
                }
                else{
                    sortorder="desc";
                }
                 $("#sortby").val(sortby);
                 $("#sortorder").val(sortorder);
                   $.ajax({
            type: "POST",
          url: "ajaxhome.php",
          data: $("#Frm_HmeSearch").serializeArray(),
          success: function( data ) {
              $('.companies-list').html(data);
             // alert(data);
          }
        });
                 //$("#Frm_HmeSearch").submit();
              });
        });
        
        
        $('input[name=exportcompare]#exportcompare').click(function(){
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
                            var currentRec =  {/literal}{$totalrecord}{literal};

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                                    if (currentRec < remLimit){
                                $("#exportform").submit();
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
            
        
 $('.oldFinacialData').click(function(){ 
     $('#oldFinacialDataFlag').val('display');
                    $('#Frm_HmeSearch').submit();
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
       $(document).ready(function(){
         $('.refine').on('click',function(){    
            $('.countflag').val('1');   
        });
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
       });
    </script>
    <style>
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
                    .custom.dropdown ul li { width: 100%;}
        #export-popup .agree-export {
            margin-right: 10px;
        }

        #export-popup .close-lookup {
            background-color: #000;
        }
    </style>
{/literal}

{include file="popup.tpl"}