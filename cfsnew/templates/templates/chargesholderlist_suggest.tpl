{include file="header.tpl"}

{include file="leftpanel_ioc.tpl"}

<div class="container-right">
{if $searchupperlimit gte $searchlowerlimit}   
{include file="filters_ioc.tpl"}
{literal}
    <style>
.search-main li label,form.custom .custom.disabled{
    opacity:0.6
}
.entry-pad{
padding:0px 10px; 
}
.btn-cnt .home_export {
    min-width: auto;
    padding: 6px 10px;
}
    </style>
{/literal}

<div class="list-tab"  style="margin-top: 5px;">
<ul>
<li><a  href="#" class="active postlink"><i></i> LIST VIEW</a></li>
<li>
<a class="postlink" {if count($SearchResults) neq 0} href="companylist_suggest.php?id={$SearchResults[0].cin}&ioc_fstatus=1&ioc_c={$companyURL}{if $ioc_fstatus eq 1}{if $ioc_faddress neq ''}&chargeaddress={$ioc_faddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{elseif $companyURL neq ''}&ioc_c={$companyURL}{/if}" {else} href="#"{/if}><i class="i-detail-view"></i> DETAIL VIEW</a></li>
{* <li><a class="postlink" href="{if count($SearchResults) neq 0}details.php?id={$SearchResults[0].id}{if $ioc_fstatus eq 1}&ioc_fstatus={$ioc_fstatus}{if $ioc_faddress neq ''}&chargeaddress={$ioc_faddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{elseif $companyURL neq ''}&ioc_c={$companyURL}{/if}{else}#{/if}"><i class="i-detail-view"></i> DETAIL VIEW</a></li> *}
{* <li><a class="postlink" href="companylist_suggest.php?id={$SearchResults[0].id}&ioc_fstatus=1{if $ioc_fstatus eq 1}{if $ioc_faddress neq ''}&chargeaddress={$ioc_faddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{elseif $companyURL neq ''}&ioc_c={$companyURL}{/if}" style="color:#414141;text-decoration: none;"><b>{$SearchResults[List].company_name}</b></a></li> *}

</ul>
<div class="page-no" style="position: initial;"><span></span></div>
</div>

<div class="companies-list">
<form method="post" id="Frm_HmeSearch1" action="companylist_suggest.php">
                      <input type="hidden" name="holderhiddenval" class="holderhiddenval" value="{$ChargesholderName}">
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <thead> 
    <tr>
      <th  class="sorthead {if $sortby eq "sortcompany"} {$sortorder} {/if}" id="sortcompany">Company Name</th>
    </tr>
  </thead>
  <tbody>  
    {section name=List loop=$SearchResults}  
      <tr>
        <td>
            <a class="postlinkval" href="companylist_suggest.php?id={$SearchResults[List].cin}&ioc_fstatus=1&ioc_c={$companyURL}{if $ioc_fstatus eq 1}{if $ioc_faddress neq ''}&chargeaddress={$ioc_faddress}{/if}{if $ioc_fchargefromdate neq ''}&chargefromdate={$ioc_fchargefromdate}{/if}{if $ioc_fchargetodate neq ''}&chargetodate={$ioc_fchargetodate}{/if}{if $ioc_fchargefromamount neq ''}&chargefromamount={$ioc_fchargefromamount}{/if}{if $ioc_fchargetoamount neq ''}&chargetoamount={$ioc_fchargetoamount}{/if}{elseif $companyURL neq ''}&ioc_c={$companyURL}{/if}" style="color:#414141;text-decoration: none;"><b>{$SearchResults[List].company_name}</b></a></td>
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
</body>
</html>
{literal}

 

    <script type="text/javascript">
    $("a.postlinkval").live('click',function(){
        hrefval= $(this).attr("href");
        $("#Frm_HmeSearch1").attr("action", hrefval);
        $("#Frm_HmeSearch1").submit();
        return false;
     });
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
          url: "ajaxchargesholderlist_suggest.php",
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
                    form.custom .custom.dropdown ul li { width: 100%;}
        #export-popup .agree-export {
            margin-right: 10px;
        }

        #export-popup .close-lookup {
            background-color: #000;
        }
    </style>
{/literal}
