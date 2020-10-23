{include file="header.tpl"}
{include file="leftpanel.tpl"}
{* {if ($BASE_URL neq "//www.ventureintelligence.asia/dev/")}
{literal}
<style>
.finance-filter{
    display: none !important;
}
</style>
{/literal}
{/if} *}
{literal}
<!-- <link href="css/growth.css" rel="stylesheet" type="text/css" /> -->
<style type="text/css">
.finance-filter{
    display: none !important;
}
.growth_fulldetails{position:relative;margin:0;padding:0}.firstyear_growth{width:440px;height:auto;margin:12px 5px 17px 0;display:inline-block}.thirdyear_growth{width:440px;height:auto;margin:12px 5px 17px 0;display:inline-block}.fifthyear_growth{width:440px;height:auto;margin:12px 0 17px;display:inline-block}.growth_heading{background:#414141;color:#eee;font-size:14px;font-family:calibri;font-weight:700;text-align:center;padding:15px 0;text-transform:uppercase}.growth_content{padding:12px 10px;background:#dcdcdc;overflow:hidden}.ebitda,.pat,.total_income{width:140px;height:auto;float:left}.ebitda_heading,.income_heading,.pat_heading{text-align:center;font-family:calibri;font-weight:400;font-size:14px;color:#000}.growth_details{background:#ececec;padding:16px 6px}.ebitda_details,.income_details,.pat_details{width:140px;display:inline-block}.up_bg{background:url(images/spriteimage1.png) no-repeat center;width:21px;height:13px;background-position:-181px -5px;display:block;margin:6px auto}.down_bg{background:url(images/spriteimage1.png) no-repeat center;width:21px;height:13px;background-position:-212px -5px;display:block;margin:6px auto}.down_content,.up_content{color:#fff;display:block;margin-bottom:12px}.up_content p{background:#249724}.down_content p{background:#ff1414}.down_content p,.up_content p{padding:0 3px;margin:0 auto;font-size:13px;font-family:calibri;width:46px;text-align:center;font-weight:700}.down_amount,.up_amount{font-family:calibri;color:#000;font-size:13px;display:block;text-align:center}.up_amount{color:#249724}.down_amount{color:#ff1414}.growth_fulldetails{width:100%;overflow:hidden;text-align:center}.fifthyear_growth,.firstyear_growth,.thirdyear_growth{width:32.5%!important}.ebitda,.pat,.total_income{width:33%!important}.growth_details{padding:16px 0!important;overflow:hidden}.growth_content{padding:12px 0!important}.fifthyear_growth .ebitda,.fifthyear_growth .total_income,.thirdyear_growth .pat,.thirdyear_growth .total_income{width:33%!important}.fifthyear_growth .ebitda_details,.fifthyear_growth .income_details,.thirdyear_growth .income_details,.thirdyear_growth .pat_details{width:33%!important;float:left}.ebitda_details,.income_details,.pat_details{width:33%!important;float:left}.fifthyear_growth{margin-right:2px}.fifthyear_growth:last-child{margin-right:0!important}.cfs_menu{width:100%;font-size:large}.cfs_menu ul li{float:left;margin-right:0;background:#413529;margin-bottom:10px;width:12.5%;cursor:pointer;text-align:center;color:rgba(255,255,255,1);display:table-cell;vertical-align:middle;height:60px;line-height:60px;font-size:16px;padding:0 10px}@media (max-width:992px){.cfs_menu ul li{font-size:11px!important}}.cfs_menu ul .current{box-shadow:none;margin-right:0;margin-top:0;color:#413529;background:#fff!important;border-top:1px solid #413529!important;border-bottom:1px solid #413529!important}.cfs_menu ul li.current{box-shadow:none;margin-right:0;margin-top:0;color:#413529;background:#fff!important;border-top:1px solid #413529!important;border-bottom:1px solid #413529!important;padding:0 10px}.cfs_menu ul li:first-child.current{border-left:1px solid #413529!important}.cfs_menu ul li:last-child.current{border-right:1px solid #413529!important}.cfs_menu ul li.current:hover{color:#413529}.cfs_menu ul li:hover{color:#fff;curser:pointer}.container-right .companies-fount-new h1{float:left}.companies-fount-new .compare-new{float:right;margin-top:20px}.companies-fount-new{overflow:hidden;margin:0 0 30px}.click-top a{position:fixed;right:20px;bottom:20px;width:50px;height:50px}.click-top{position:fixed;bottom:20px;right:20px;display:none}.tab_menu{display:none}#balancesheet{margin-top:10px}.no_data{padding:10px;text-align:center}
#tdShowDirectorMasterdata a {
    color: #000 !important;
    text-decoration: underline;
}
#mca_data,#mca_data1,#mca_data2 {text-align:center;}
ul.social li {
    padding: 10px 14px 5px 10px;
}
ul.social li i {
    font-size: 23px;
}

.tooltip4 {
    outline: none;
     text-decoration: none;
}

.tooltip4 strong {
    line-height: 10px;
    padding-left: 5px;
}
.tooltip0 strong {
    line-height: 10px;
    padding-left: 5px;
}
.tooltip4:hover {
    text-decoration: none;
}

.tooltip4 span {
    display: none;
    line-height: 20px;
    margin-left: 5px;
    padding: 10px 15px 7px 10px;
    z-index: 10;
    margin-top: 6px;
}

.tooltip4:hover span {
    font-size: 12px !important;
    font-weight: normal !important;
    display: inline;
    position: absolute;
    color: #111;
    border: 1px solid #DCA;
    background: #fffAF0;
    
}
.tooltip0 span {
    display: none;
    line-height: 20px;
    margin-left: 5px;
    padding: 10px 15px 7px 10px;
    z-index: 10;
    margin-top: 6px;
}

.tooltip0:hover span {
    font-size: 12px !important;
    font-weight: normal !important;
    display: inline;
    position: absolute;
    color: #111;
    border: 1px solid #DCA;
    background: #fffAF0;
    
}

.callout {
    border: 0 none;
    left: -6px;
    position: absolute;
    top: 6px;
    z-index: 20;
}
.showtextlarge4 {
    border: 0 none;
    left: 120px;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}
.showtextlarge0 {
    border: 0 none;
    left: 37px;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}
.showtextlarge3 {
    border: 0 none;
    left: 50px;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}
.showtextlarge2 {
    border: 0 none;
    left: 20px;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}.showtextlarge1 {
    border: 0 none;
    left: 10px;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
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
    
    
.view-table {  display:block; overflow:hidden; padding:0px 20px;margin-top:10px;margin-bottom: 20px;}
.view-table table{  font-size:14px;  width:100%;}
.view-table th{ color:#fff; text-align:left;   border-bottom:1px solid #999;border-top:1px solid #999; font-size:16px; text-transform:uppercase; color:#000; font-weight:bold; padding:10px;}
.view-table td{ font-size:16px; padding:10px;  border-bottom:1px solid #c1c1c1;} 
/*.view-table th:last-child, .view-table td:last-child{ border-right:0 !important;}*/
.view-table td a { font-weight:bold; color:#414141;text-decoration:none;}
.view-table td a:hover {color:#414141;text-decoration:underline;}
.view-table table thead { background: none repeat scroll 0 0 #FFFFFF;/*position: fixed;*/z-index:11; vertical-align: top;}
.view-table tr:hover td{ background:#F2EDE1 !important;cursor: pointer;}
.view-table tr:hover td a, .view-table td a:hover{ color:#2D241B; text-decoration:underline;}
.view-table table thead{ padding:20px 0 0 !important;}
.view-table table colgroup{display:none;}
#myTable { border-top: 0 !important;  border-bottom: 0 !important;   }
#myTable th.headertb{ background: url(images/icon-sort-black.png) no-repeat left center; border-top:1px solid #999; 
          border-bottom:1px solid #999; padding:10px 10px 14px 15px; font-size:16px; color:#000; font-weight:bold; text-transform:uppercase;border-right: 0 !important;}
#myTable td{ padding-left:15px;border-right: 0 !important;}
.view-table tr:last-child td{ border-bottom: 0;}
.result-cnt {
    padding: 0px 0px 0px 20px;
    /* position: fixed; */
    z-index: 11 !important;
    width: 96%;
    display: block;
}
.result-title {
    padding: 0 !important;
    width: auto !important;
    background: #fff;
     z-index: 11 !important;
     display: block;
    overflow: hidden;
}
.filter-key-result {
    display: block;
    overflow: hidden;
    padding: 10px 0 0;
}
.result-rt-cnt {
    float: right;
}
.result-count {
    float: left;
    font-size: 19px;
    font-weight: normal;
    padding: 0;
    margin-top: 10px;
    text-transform: none !important;
}
span.result-no {
    color: #000;
    float: left;
    font-weight: bold;
    padding: 5px 10px 0 0;
    text-transform: none !important;
}
span.result-amount {
    border-left: 2px solid #bfa07c;
    color: #bfa07c;
    float: left;
    font-size: 16px;
    font-weight: bold;
    padding: 0 5px 0 10px;
    text-transform: none !important;
}
span.result-amount-no {
    color: #bfa07c;
    float: left;
}
.result-title h2 {
    margin-right: 0px !important;
}
.result-title h2 {
    margin: 0;
    padding: 0;
    float: right;
    margin-right: 90px;
    font-size: 19px;
    font-weight: bold;
    text-transform: none !important;
}
.finance-filter-custom {
    font-size: 16px;
    clear: both;
    width: 110px;
    overflow: visible;
    display: block;
    position: absolute;
    right: 15px;
    padding: 0px;
    padding-top: 17px;
    background: none;
    border-top: none;
    margin-top: 0px;
}

form.custom .finance-filter-custom .custom.dropdown {
    height: 27px !important;
    font-size: 14px;
}

form.custom .finance-filter-custom .custom.dropdown .current {
    line-height: 27px;
    margin-right: 1.3125em;
}

form.custom .finance-filter-custom .custom.dropdown .selector {
    height: 27px;
}
.btn-cnt {
    right: 120px !important;
}

.tooltipratio {
    outline: none;
     text-decoration: none;
}

.tooltipratio td{
    position: relative;
}

.tooltipratio strong {
    line-height: 10px;
    padding-left: 5px;
}
.tooltipratio:hover {
    text-decoration: none;
}
.tooltipratio span {
    display: none;
    line-height: 20px;
    margin-left: 5px;
    padding: 7px 10px;
    z-index: 10;
    margin-top: 6px;
}
.tooltipratio .showtextlarge4 {
    border: 0 none;
    left: -5px;
    position: absolute;
    top: 7px;
    z-index: 20;
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
}
.tooltipratio:hover span {
    font-size: 12px !important;
    font-weight: normal !important;
    display: inline;
    position: absolute;
    color: #111;
    border: 1px solid #DCA;
    background: #fffAF0;
    
}
</style> 
<!--<script src="http://foundation.zurb.com/docs/assets/vendor/custom.modernizr.js"></script>-->
<script type="text/javascript">
    $('#pgLoading').show();//Display the loader
    var fundAjax = '';
    var cin = '{/literal}{$CIN}{literal}';
    //$(document).ready(function() {
    $(window).load(function() {
        $.urlParam = function(name){
            var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        }
        var vcid=$.urlParam('vcid');
        var ccur1 = 'INR';
        var str = 'c';
        $.get("ajaxmilliCurrency.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+""}, function(data){
                $('#profit_loss_parent').html(data);
                $(".tab_menu_parent").hide();
                $("#profit_loss_parent").show();

                $('.displaycmp').hide();
                             $('#stMsg').hide();
                             $('.companies-details').show();
                             $('#pgLoading').hide();//Hide the loader after loading data
                resetfoundation();
        });
    });

function millconversion(str,vcid){
    //alert(str + "," +vcid);
        $('#pgLoading').show();
    var ccur1 = $('#ccur').val();
        var yoy1= $('#yoy').val();
        var yoy2= $('#cagr').val();
        if(yoy1 !='')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
    if(ccur1 =='-- select currency --'){
        ccur1 = 'INR';
    }
     clickflagprofitloss = 0;  
     clickflagbalancesheet = 0; 
     clickflagcashflow = 0;
     clickflagratio = 0;
    $.get("ajaxmilliCurrency.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+"",yoy:""+yoyr+""}, function(data){
        
        $(".cfs_menu").hide();$(".finance-filter").hide();
        $(".tab_menu").hide();
        
            $('#profit_loss_parent').html(data);
                $(".tab_menu_parent").hide();
                $("#profit_loss_parent").show();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                        $('#pgLoading').hide();
            resetfoundation();
                        
        });
}
function currencyconvert(inputString,vcid){
    //alert("ddddddddddddddd");
    $('#pgLoading').show();
    if(inputString =='INR')
    { 
         var ccur1 = 'c';
    }
    else
    {
        var ccur1 = 'm';
    }
        var yoy1= $('#yoy').val();
        var yoy2= $('#cagr').val();
        if(yoy1 !='')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
        clickflagprofitloss = 0;  
     clickflagbalancesheet = 0; 
     clickflagcashflow = 0;
     clickflagratio = 0;
        //alert(ccur1+","+yoyr+","+inputString);
    $.get("ajaxCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
            $('#result').html(data);
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                        $(".cfs_menu ul li").removeClass('current');
                        var row = $('#activeSubmenu').val();
                        if(row == 'profit-loss') {
                            $( '.cagrlabel' ).show();
                        } else {
                            $( '.cagrlabel' ).hide();
                        }
                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
            //alert(data);
        });
}
function valueconversion(inputString1,vcid1){
  
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    //alert(ccur1);
    var inputString= $('#ccur').val();
        var yoy1= $('#yoy').val();
        var yoy2= $('#cagr').val();
        if(yoy1 !='')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
        if(inputString1 == 'G'){
            filename = 'ajaxGrowth.php';
        } else {
           filename = 'ajaxCurrency.php';
        }
    $.get(filename, {queryString: ""+inputString+"",queryString1: ""+inputString1+"",vcid:""+vcid1+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
            $('#result').html(data);
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                        $(".cfs_menu ul li").removeClass('current');
                        var row = $('#activeSubmenu').val();
                        $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
            //alert(data);
        });
}
function projectdisplay(){
        $('#pgLoading').show();
    var projvcid = $('#projvcid').val();
    var noofyear = $('#noofyear').val();
    var CAGR = $('#CAGR').val();
    var projnext = $('#projnext').val();
    //alert(projvcid);
    $.get("ajaxCAGR.php", {vcid: ""+projvcid+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
        $('#result').html(data);
        $('.displaycmp').hide();
                $('#pgLoading').hide();
                resetfoundation();
                
        //alert(data);
    });
}
function check(newLink)
{
    location.href= newLink; //document.getElementById("google-link").value; //  "http://www.yahoo.com/";
    return false;   // so important
}
function resetfoundation()
{
  $(document).foundation();
                    $(".multi-select").dropdownchecklist('destroy');
                    $(".multi-select").dropdownchecklist({emptyText: "Please select ...",
        onItemClick: function(checkbox, selector){
    var justChecked = checkbox.prop("checked");
    var checkCount = (justChecked) ? 1 : -1;
    for( i = 0; i < selector.options.length; i++ ){
        if ( selector.options[i].selected ) checkCount += 1;
    }
      if ( checkCount > 3 ) {
        alert( "Limit is 3" );
        throw "too many";
    }
}
});
// T975 Ratio Based Filter
    $(".ratiofilter").dropdownchecklist('destroy');
    $(".ratiofilter").dropdownchecklist({emptyText: "Please select ...",
    onItemClick: function(checkbox, selector){
        var justChecked = checkbox.prop("checked");
        var checkCount = (justChecked) ? 1 : -1;
        for( i = 0; i < selector.options.length; i++ ){
            if ( selector.options[i].selected ) checkCount += 1;
        }
            if ( checkCount > 9 ) {
            alert( "Limit is 3" );
            throw "too many";
        }
        }
    });

}


function openpl_ex(elem){

 //alert('aaa'+$(elem).attr("data-check"));
    if ($(elem).attr("data-check") == 'close') {
       
        $("#pl_ex").show();
        $(elem).attr("data-check", "open");
    }else if($(elem).attr("data-check") == 'open'){
        $("#pl_ex").hide();
        $(elem).attr("data-check", "close");
            
            
    }else{
        $("#pl_ex").hide();
        $(elem).attr("data-check", "close");
    }
}
function openbalancesheet_ex(elem){

    if ($(elem).attr("data-check1") == 'close') {
        
        $("#balancesheet_ex").show();
        $(elem).attr("data-check1", "open");
    }else{
        $("#balancesheet_ex").hide();
        $(elem).attr("data-check1", "close");
    }
}
function cashflow_ex(elem){

    if ($(elem).attr("data-check2") == 'close') {
        
        $("#cashflow_ex").show();
        $(elem).attr("data-check2", "open");
    }else{
        $("#cashflow_ex").hide();
        $(elem).attr("data-check2", "close");
    }
}

$(document).mouseup(function (e)
{
  
  /*if( ( !$(e.target).is("#check") ) && ( $('#check').attr('data-check') == 'open' ) ) {
        $("#pl_ex").hide();  
        $('#check').attr("data-check", "close");
     }*/
    /*if($('#check').attr("data-check")=='open'){
         $("#pl_ex").hide();  
         $('#check').attr("data-check1", "close");
    }
    
    if($('#check1').attr("data-check1")=='open'){
       $("#balancesheet_ex").hide(); 
         $('#check1').attr("data-check1", "open")
    }*/
    //$('#check').attr("data-check", "close");
    
});


      function balsheet_ch(){         
          
           var selected = jQuery(".template:checked");
            var selectedValue = selected.val();
            if(selectedValue==1){
                $("#new_balsheet").hide();
                $("#old_balsheet").show();
                $("#new_ratio").hide();
                $("#old_ratio").show();
            }
            else if(selectedValue==2){
                $("#old_balsheet").hide();
                $("#new_balsheet").show();
                $("#old_ratio").hide();
                $("#new_ratio").show();
            }
      }
      function tabMenu(row){

        if( fundAjax.readyState ) {
            fundAjax.abort();
        }
        $('.tab_menu').hide();
        $('#'+row).show();
        if((row =='profit-loss') || (row == 'balancesheet') || (row == 'ratio')||(row =='cashflow')){
            $('.finance-filter').show();        
        }else{        
            $('.finance-filter').hide();
        }
        /*if(row =='chargesRegistered'){
            $('#mca_data2').show();        
        }
        if((row == 'companyProfile')){
            $('#mca_data').show();        
        }
        if(row == 'signatories_result'){
            $('#mca_data1').show();              
        }*/
        if(row =='companyProfile'){
            $('#companyMasterData_result').show();  
            $('#registered').show();           
        }
        if((row == 'balancesheet') || (row == 'ratio')){
            if(row == 'balancesheet'){
                $('#balancesheet_parent #templateShow').show();  
                $('#balancesheet_parent [for=new_temp] .radio').addClass('checked');
                
            } else {
                $('#ratio_parent #templateShow').show();      
                $('#ratio_parent [for=new_temp] .radio').addClass('checked'); 
            }
        }else{        
            $('#templateShow').hide();
        }
      }
</script>
    <style>
.entry-pad{
padding:0px 10px; }

#mail-boxDetail {
    width: 840px !important;
    border: 1px solid #ccc !important;
    box-shadow: 0 0 2px #eaeaea !important;
    overflow: hidden !important;
    margin: 0 auto !important;
    z-index: 9000 !important;
    margin-top: 15px !important;
 
    background-color: #fff !important;
    left: 25% !important;
    top: 5% !important;
}
#mail-boxDetail  .full-width {
    width: 100% !important;
}
 #mail-boxDetail .entry { overflow:hidden; padding:10px; }
#mail-boxDetail .entry label { display:block; width:80px; color:#000; font-size:13px; margin-bottom:5px; font-weight:bold;}
#mail-boxDetail .entry input[type='text'] {
        float: left;
        width: 100%;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        box-sizing: border-box;
        height: 34px;
        border-radius: 0px;
}
#mail-boxDetail .entry p {color:#6C6C6C; font-size:13px; border: #ccc thin solid;padding: 5px;word-break: break-all;}
#mail-boxDetail .entry h5 { margin-bottom:3px; font-size:13px;}
#mail-boxDetail .entry input[type='button'] { float:left; margin-right:10px;}
#mail-boxDetail .entry {
    float: left;
    width: 50%;
    padding: 0px 15px;
    position: relative;
    box-sizing: border-box;
}
.clearfix{
    clear: both;
}
.box-sizing{
    box-sizing: border-box;
}
.full-width{
    width:100%;
}
#mail-boxDetail{
    font-family:Arial, Helvetica, sans-serif;
    overflow-y: auto !important;
}
#mail-boxDetail .entry .textarea {
    width: 100%;
    box-sizing: border-box;
    margin-bottom: 20px;
    border: 1px solid #cccccc;
    height: 395px;
    overflow-y: scroll;
    position: relative;
    padding-top: 20px;
    padding-left: 15px;
}
#mail-boxDetail .entry .radio-lable {
    display: inline-block;
    width: 96%;
    color: #000;
    font-size: 13px;
    margin-bottom: 5px;
    font-weight: normal;
    position: relative;
}
#mail-boxDetail input[type=radio] {
    width: 20px;
    height: auto; 
    padding: 0;
    margin: 3px 0;
    line-height: normal;
    border: none;
}
#mail-boxDetail .radio-button {
    position: absolute;
    left: 4px;
    box-shadow: none !important;
    margin-top: 8px !important;
    z-index: 1;
}
#mail-boxDetail .entry .link-box .label-financials {
    display: inline-block;
    width: 9%;
    color: #000;
    font-size: 13px;
    margin-bottom: 0px;
    font-weight: normal;
}

#mail-boxDetail .entry .link-box input[type='text'].text-financials {
    display: inline-block;
    width: 91%;
    border: none;
    box-shadow: none;
    padding: 0px;
    height: 30px;
    margin-bottom: 15px;
    pointer-events: none;
    color: #15c;
    text-decoration: underline;
    background-color: #FFF !important;
}
#mail-boxDetail .entry .link-box .label-filings {
    display: inline-block;
    width: 12%;
    color: #000;
    font-size: 13px;
    margin-bottom: 5px;
    font-weight: normal;
}
#mail-boxDetail .entry .link-box input[type='text'].text-filings {
    display: inline-block;
    width: 88%;
    border: none;
    box-shadow: none;
    padding: 0px;
    height: 30px;
    margin-bottom: 15px;
    pointer-events: none;
    color: #15c;
    text-decoration: underline;
    background-color: #FFF !important;
}
#mail-boxDetail .full-width textarea {
    width: 100%;
    height: auto;
    margin-top: 20px;
}
#mail-boxDetail .entry input[type='text'].fyyear {
    float: none;
    width: 19px;
    padding: 0px;
    border: none;
    box-shadow: none;
    border-bottom: 2px dashed #000;
    margin-bottom: 0px;
    box-sizing: border-box;
    height: 18px;
    border-radius: 0px;
    pointer-events: none;
    color: #000;
    letter-spacing: 2px;
        margin-left: 3px;
    margin-right: 3px;
}
#mail-boxDetail .entry .textarea p {
    color: #000;
    font-size: 13px;
    border: none;
    padding: 0px 10px;
    word-break: break-all;
    margin-top: 45px;
    outline: none;
}
#mail-boxDetail .btn-custom {
    align-items: flex-start;
    text-align: center;
    cursor: default;
    color: buttontext;
    background-color: buttonface;
    box-sizing: border-box;
    padding: 2px 6px 3px;
    border-width: 2px;
    border-style: outset;
    border-color: buttonface;
    border-image: initial;
}
#mail-boxDetail .link-box {
    padding: 0px 25px;
    box-sizing: border-box;
}
#mail-boxDetail .financial-lable {
    /*padding-left: 25px;
    display: block;*/
    display: inline-flex;
    width: 96%;
    color: #000;
    font-size: 13px;
    margin-top: 6px;
    font-weight: normal;
     position: relative;
        margin-bottom: 10px;
}#mail-boxDetail .entry .link-box .label-financials,#mail-boxDetail .entry .link-box .label-filings{float:left;line-height: 30px;}
#mail-boxDetail .custom.radio{
        margin-right: 5px !important;
}
#mail-boxDetail .entry.floatnone{
    float:none;
}
.successmsg {
    position: absolute;
    left: 0px;
    top: 0;
    right: 0px;
    bottom: 0;
    background: rgba(255, 255, 255, 0.6);
    z-index: 10000;
    /* overflow: hidden; */
    display: none;
    box-sizing: border-box;
}
.successmsg-text {
    text-align: center;
    color: green;
    font-size: 18px;
    padding: 20px;
    box-sizing: border-box;
    /* background: rgba(255, 255, 255, 0.59); */
}
.smcmodel{
   padding: 20px 0px; 
}
p.textareanew {
    margin: 20px !important;
    min-height: 100px;
    border: 1px solid #cccccc !important;
    margin-left: 15px !important;
    margin-right: 15px !important;
    padding: 8px !important;
}
p.textareanew:focus {
    -webkit-box-shadow: 0 0 5px #999999;
    -moz-box-shadow: 0 0 5px #999999;
    box-shadow: 0 0 5px #999999;
    border-color: #999999;
}
@media(device-width:768px)
{
   #mail-boxDetail{
       width:100% !important;
       left:0% !important;
   }
}
    </style>
{/literal}
<input type="hidden" name="activeSubmenu" id="activeSubmenu" value="profit-loss" />
<input type="hidden" name="countflag" value="{$countflag}"/>
 <div class="lb" id="popup-box">
    <div class="title">Email this to your Colleague</div>
    <form>
        <div class="entry">
            <label> To Email</label>
                <input type="text" name="toaddress" id="toaddress"  />
        </div>
        <div class="entry">
            <h5>Subject</h5>
            <p>Checkout this {$SCompanyName} Company's Financials</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this {$SCompanyName} Company's Financials" />
        </div>
        <div class="entry"> 
            <h5>Message</h5>
                <p>{$curpageURL}  <input type="hidden" name="message" id="message" value="{$curpageURL}" />   <input type="hidden" name="useremail" id="useremail" value="{$SESSION_UserEmail}"  /> </p>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailbtn" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

    </form>
</div>

<div class="lb" id="popup-boxDetail">
    <div class="title">Update Financials</div>
        <form name="addDBFinacials" id="addDBFinacials">
            <div class="entry entry-pad" style="padding-top:10px;">
            <label> From</label>
                <input type="text" name="u_fromaddress" id="u_fromaddress" value="{$SESSION_UserEmail}"  />
        </div>
        <div class="entry entry-pad">
            <label> To</label>
                <input type="text" name="u_toaddress" id="u_toaddress" value="cfs@ventureintelligence.com" readonly="" />
        </div>
        <div class="entry entry-pad">
            <label> CC</label>
                <input type="text" name="u_cc" id="u_cc" value="" />
        </div>
                <input type="hidden" name="u_subject" id="u_subject" value="Request for Latest Financials" readonly="" />
        <div class="entry entry-pad"> 
            <h5>Message</h5>
                <textarea name="u_textMessage" id="u_textMessage" rows="5" cols="50"> Please update latest financials for the company - <br/> {$curpageURL}</textarea>
        </div>
        <div class="entry">
            <input type="button" value="Send" id="mailbtnDetail" />
            <input type="button" value="Cancel" id="cancelbtnDetail" />
        </div>

    </form>
</div>
<div class="container-right">

{*{include file="filters.tpl"}*}
{if ($grouplimit[0][2] gte $grouplimit[0][5])}

<div class="list-tab cfsDeatilPage" style="clear: both;margin-top:15px;">
    <ul style="float:left;">
    <li><a class="postlink" href="home.php{if $pageno}?page={$pageno}{/if}"><i class="i-grid-view"></i> LIST VIEW</a></li>
    <li><a  href="details.php?vcid={$VCID}" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
    </ul>
    <ul style="float: right;" class="social">       
     <li>
        {if $COMPANYDETAILS_MEDIA_PATH}
          <span style="cursor:pointer;"  class="postlink tooltip0" id="exportall" title="" ><!-- <i class="fa fa-file-excel-o" aria-hidden="true"></i> --><i class="fa fa-download" aria-hidden="true"></i>
     <span class="" style="right:184px;">
                    <!-- <img class="showtextlarge0" src="/dealsnew/images/callout.gif"> -->
                    <div class="callout showtextlarge0" ></div>
                    <strong>Download
                    </strong>
                    </span></span>
                 
        {/if}
  
                    
    </li> 
    {* <li>
     <span   class="senddeal tooltip4" onclick='location.href = "projectionall.php?vcid={$Company_Id}";' style="cursor:pointer;"  title=""><i class="fa fa-line-chart" aria-hidden="true"></i> 
    <span class=" " style="right:85px;">
                   <!--  <img class="showtextlarge1 " src="/dealsnew/images/callout.gif"> -->
                    <div class="callout showtextlarge1 "></div>
                    <strong>See Projection
                    </strong>
                    </span></span>
    </li> *}
     <li>
      <span   class="senddeal tooltip4" id="senddeal"  style="cursor:pointer;"  title=""><i class="fa fa-share-square-o" aria-hidden="true"></i> 
    <span class=" " style="right:10px;">
                    <!-- <img class="showtextlarge2 " src="/dealsnew/images/callout.gif"> -->
                    <div class="callout showtextlarge2 " ></div>
                    <strong>Share with Colleague
                    </strong>
                    </span></span>
                    
                    
                    </li>

        <li>
      <span class="postlink updateFinancialDetail1 tooltip4"  style="cursor:pointer;"  title=""><i class="fa fa-wrench" aria-hidden="true"></i> 
    <span class="" style="right:10px;">
                   <!--  <img class="showtextlarge3" src="/dealsnew/images/callout.gif"> -->
                    <div class="callout showtextlarge3" ></div>
                    <strong>Update financials
                    </strong>
                    </span></span>
                 
                    </li>

    <li>
     {if $User eq 1}

          <span style="cursor:pointer;"  class="postlink sendmailcustomer btn-sendmail tooltip4" title="" ><i class="fa fa-envelope-o" aria-hidden="true"></i>
     <span class="" style="right:17px;">
                    <!-- <img class="showtextlarge4" src="/dealsnew/images/callout.gif"> -->
                    <div class="callout showtextlarge4" ></div>
                    <strong>Send mail to customer
                    </strong>
                    </span></span>
                      
        {/if}
  
                    
    </li>
  </ul>
</div>

<div class="companies-details">
    
    <div class="detailed-title-links"> <h2>{$FCompanyName} - {$SCompanyName}</h2> 

        {if $prevKey neq '-1'}<a class="previous postlink" id="previous" href="details.php?vcid={$prevNextArr[$prevKey]}">< Previous</a>{/if}
        {if $prevNextArr|@count gt $nextKey}<a class="next postlink" id="next" href="details.php?vcid={$prevNextArr[$nextKey]}"> Next > </a>{/if}
    <!--a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a--> 
    </div>
<div align="center">
    <div class="btn-cnt p10" style="{if $file_pl_cnt eq 2 || $file_bs_cnt eq 2 } margin-bottom: 0px {elseif $file_pl_cnt eq 1 || $file_bs_cnt eq 1} margin-bottom:  0px {else} margin-bottom:  0px {/if} ">
           {if $PLSTANDARD_MEDIA_PATH || $PLSTANDARD_MEDIA_PATH_CON}    
              <!-- <span style="  position: relative;"> 
              <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="openpl_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />

          <div id="pl_ex" data-slide="close" style=" position: absolute;  width: 100%; display: none; {if $file_pl_cnt > 0 && $file_bs_cnt > 0} left: 0 {else} left: 0 {/if}">
          {if $PLSTANDARD_MEDIA_PATH}<input  name="" type="button" value="Standalone" onClick="window.open('downloadtrack.php?vcid={$Company_Id}','_blank')" style="  width: 180px;border-top: 0;" />{/if}
          {if $PLSTANDARD_MEDIA_PATH_CON}<input  name="" type="button" value="Consolidated" onClick="window.open('downloadtrack.php?vcid={$Company_Id}&type=consolidated','_blank')" style="  width: 180px;border-top: 0;" />{/if}
              </div>
              </span> -->

           {/if}
           {if $PLSTANDARD_MEDIA_NEW_PATH || $PLSTANDARD_MEDIA_NEW_PATH_CON || $PLSTANDARD_MEDIA_OLD_PATH || $PLSTANDARD_MEDIA_OLD_PATH_CON}    
              <span style="  position: relative;"> 
              <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="openpl_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />

          <div id="pl_ex" data-slide="close" style=" position: absolute;  width: 100%; display: none; {if $file_pl_cnt > 0 && $file_bs_cnt > 0} left: 0 {else} left: 0 {/if}">
          {if $PLSTANDARD_MEDIA_NEW_PATH || $PLSTANDARD_MEDIA_OLD_PATH}<input  name="" type="button" value="Standalone" onClick="genDownloadExcel('pl', 's', {$VCID});" style="  width: 180px;border-top: 0;" />{/if}
          {if $PLSTANDARD_MEDIA_NEW_PATH_CON || $PLSTANDARD_MEDIA_OLD_PATH_CON}<input  name="" type="button" value="Consolidated" onClick="genDownloadExcel('pl', 'c', {$VCID});" style="  width: 180px;border-top: 0;" />{/if}
              </div>
              </span>
            {elseif $PLSTANDARD_MEDIA_PATH || $PLSTANDARD_MEDIA_PATH_CON}
            <!--    <span style="  position: relative;"> 
                  <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="openpl_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />

              <div id="pl_ex" data-slide="close" style=" position: absolute;  width: 100%; display: none; {if $file_pl_cnt > 0 && $file_bs_cnt > 0} left: 0 {else} left: 0 {/if}">-->
              {if $PLSTANDARD_MEDIA_PATH}
             <!--  <input  name="" type="button" value="Standalone" onClick="window.open('downloadtrack.php?vcid={$Company_Id}','_blank')" style="  width: 180px;border-top: 0;" /> -->
            <!-- <input  name="plexportcompare" type="button" value="Standalone" id="plexportcompare" style="  width: 180px;border-top: 0;" />-->
              {/if}
              {if $PLSTANDARD_MEDIA_PATH_CON}
             <!--  <input  name="" type="button" value="Consolidated" onClick="window.open('downloadtrack.php?vcid={$Company_Id}&type=consolidated','_blank')" style="  width: 180px;border-top: 0;" /> -->
            <!-- <input  name="plconexportcompare" type="button" value="Consolidated" id="plconexportcompare" style="  width: 180px;border-top: 0;" />-->
              {/if}
               <!--   </div>
                  </span>-->
            {else}

               <!-- <span style="  position: relative;"> 
                    <input  name="" type="button" id="check" data-check="close" value="P&L EXPORT" onClick="plDataUpdateReq()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:180px; " />
                </span>-->
           {/if}
           {if $PLDETAILED_MEDIA_PATH}

            <!--   <input  name="" type="button"  value="Detailed P&L EXPORT" onClick="window.open('{$MEDIA_PATH}pldetailed/PLDetailed_{$VCID}.xls?time={$smarty.now}','_blank')" />-->
                   <!--div>&nbsp;</div><div class="anchorblue">To download Detailed P&L   :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="{$MEDIA_PATH}pldetailed/PLDetailed_{$VCID}.xls">Click Here</a></div-->
           {/if}
       {if $BSHEET_MEDIA_PATH_NEW || $BSHEET_MEDIA_PATH_NEW1}   
              <!-- <span style="  position: relative;"> 
              <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="openbalancesheet_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />

              <div id="balancesheet_ex" style="position: absolute;  top: 26px; width: 100%; display: none;  right: 0; text-align: right;">
           {if $BSHEET_MEDIA_PATH_NEW}<input  name="" type="button" value="Standalone" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}.xls','_blank')" style="  width: 180px;border-top: 0;" />{/if}
           {if $BSHEET_MEDIA_PATH_NEW1}<input  name="" type="button" value="Consolidated" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}_1.xls','_blank')" style="  width: 180px;border-top: 0;" />{/if}
              </div>
              </span> -->

           {/if}
           {if $BSHEET_MEDIA_OLD_PATH_NEW || $BSHEET_MEDIA_OLD_PATH_NEW1 || $BSHEET_MEDIA_NEW_PATH_NEW || $BSHEET_MEDIA_NEW_PATH_NEW1}  
              <span style="  position: relative;"> 
              <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="openbalancesheet_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />

              <div id="balancesheet_ex" style="position: absolute;  top: 26px; width: 100%; display: none;  right: 0; text-align: right;">
           {if $BSHEET_MEDIA_OLD_PATH_NEW || $BSHEET_MEDIA_NEW_PATH_NEW}<input  name="" type="button" value="Standalone" onClick="genDownloadExcel('bs', 's', {$VCID});" style="  width: 180px;border-top: 0;" />{/if}
           {if $BSHEET_MEDIA_NEW_PATH_NEW1 || $BSHEET_MEDIA_OLD_PATH_NEW1}<input  name="" type="button" value="Consolidated" onClick="genDownloadExcel('bs', 'c', {$VCID});" style="  width: 180px;border-top: 0;" />{/if}
              </div>
              </span>
            {elseif $BSHEET_MEDIA_PATH_NEW || $BSHEET_MEDIA_PATH_NEW1}
              <!--  <span style="  position: relative;"> 
                  <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="openbalancesheet_ex(this)" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />

                  <div id="balancesheet_ex" style="position: absolute;  top: 26px; width: 100%; display: none;  right: 0; text-align: right;">-->
               {if $BSHEET_MEDIA_PATH_NEW}
               <!-- <input  name="" type="button" value="Standalone" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
              <!-- <input  name="bsexportcompare"  type="button" value="Standalone"  id="bsexportcompare" style="  width: 180px;border-top: 0;" />-->
               {/if}
               {if $BSHEET_MEDIA_PATH_NEW1}
               <!-- <input  name="" type="button" value="Consolidated" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}_1.xls','_blank')" style="  width: 180px;border-top: 0;" /> -->
              <!-- <input  name="bsconexportcompare" type="button" value="Consolidated"  id="bsconexportcompare" style="  width: 180px;border-top: 0;" />-->
               {/if}
                 <!-- </div>
                  </span> -->
            {else}
              <!--  <span style="  position: relative;"> 
                    <input  name="" type="button" id="check1" data-check1="close" value="BALANCE SHEET EXPORT" onClick="bsDataUpdateReq()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 163px 6px; width:180px; " />
                </span>-->
           {/if}
           {if $CASHFLOW_MEDIA_PATH}

                   <!-- <input  name="" type="button" value="CASHFLOW EXPORT" onClick="window.open('{$MEDIA_PATH}cashflow/Cashflow_{$VCID}.xls','_blank')" /> -->
                   <!--div>&nbsp;</div><div class="anchorblue">To download CashFlow :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="{$MEDIA_PATH}cashflow/Cashflow_{$VCID}.xls">Click Here</a></div-->
           {/if}
          <!-- <input class="postlink" type="button" onclick='location.href = "projectionall.php?vcid={$Company_Id}{if ($searchv ne NULL)}&searchv={$searchv}{/if}";' value="SEE PROJECTION" name="senddeal">
           <input class="senddeal" type="button" id="senddeal" value="SHARE" name="senddeal">
       <input class="postlink updateFinancialDetail1" type="button"  value="UPDATE FINANCIALS " name="senddeal">-->
       {if $User eq 1}
      <!--  <input class="postlink sendmailcustomer btn-sendmail" type="button"  value="Send Mail to cust" name="sendmailcustomer">-->
        {/if}
        </div>
</div>
<div class="finance-cnt" id="result">
{*<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid={$Company_Id}">See Projection</a></div>*}
<!-- <div id="stMsg"></div>
<div class="finance-filter">
<div class="left-cnt"> 
    <label> <input type="radio" name="yoy" id="yoy" value="V" onChange="javascript:valueconversion('V',{$VCID});" checked="checked" /> Value</label>
    <label>   <input type="radio" name="yoy" id="cagr" value="G" onChange="javascript:valueconversion('G',{$VCID});" /> Growth</label> 
    <select onChange="javascript:currencyconvert(this.value,{$VCID})" name="ccur" id="ccur">
        <option>-- select currency --</option>
        <option value="GBP">British Pound GBP</option>
        <option value="EUR">Euro EUR</option>
        <option value="USD">US Dollar USD</option>
        <option value="JPY">Japanese Yen JPY</option>
        <option value="CNY">Chinese Yuan CNY</option>
        <option value="AUD">Australian Dollar AUD</option>
        <option value="CHF">Swiss Franc CHF</option>
        <option value="CAD">Canadian Dollar CAD</option>
        <option value="THB">Thai Baht THB</option>   
        <option value="INR" selected="selected">Indian Rupee INR</option>
        <option value="IDR">Indonesian Rupiah IDR</option>
        <option value="HKD">Hong Kong Dollar HKD</option>
    </select> 
</div>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype" onchange="javascript:millconversion(this.value,{$VCID});">
        <option value='c'>Crores</option>
        <option value='r'>Actual Value</option>
        <option value='m'>Millions</option>
    </select> </div>
</div>

            
            

  <br>
  <div style="font-size: 16px;">

  <a class="updateFinancialDetail" href="javascript:void(0)" >Click here to check for latest financial year availability</a><br><br>
  </div> -->

   <div class="tab_menu_parent" id="profit_loss_parent" style="display:none;"></div>
   <div class="tab_menu_parent" id="balancesheet_parent" style="display:none;"></div>
   <div class="tab_menu_parent" id="cashflow_parent" style="display:none;"></div>
   <div class="tab_menu_parent" id="ratio_parent" style="display:none;"></div>  

   </div>

  <div class="finance-cnt postContainer postContent masonry-container">
    
   <div  class=" col-4 tab_menu" id="companyProfile" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
   <!--<div  class="work-masonry-thumb "> <h2>  COMPANY PROFILE</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>

    <tr>
        <td>
            <table style="border: 0;">
                <tr>
                    {if $CompanyProfile.IndustryName neq ""}
                        <td>Industry<span>{$CompanyProfile.IndustryName}</span></td>
                    {else}
                        <td></td>
                    {/if}
                </tr>
                <tr>
                    {if $CompanyProfile.SectorName neq ""}
                    <td>Sector<span>{$CompanyProfile.SectorName}</span></td>
                    {/if}
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    {if $CompanyProfile.BusinessDesc neq ""} <td>Business Description<span>{$CompanyProfile.BusinessDesc}</span></td>{/if}
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr id="viewlinkedin_loginbtn">
                    {if $companylinkedIn neq ""}
                    <td>View LinkedIn Profile<span> {literal} <script type="in/Login"></script> {/literal}</span></td>
                    {/if}
                </tr>
            </table>
        </td>
        <td>
            <table  style="border: 0;">
                <tr>
                    {if $CompanyProfile.CIN neq ""}
                    <td>CIN Number<span>{$CompanyProfile.CIN}</span></td>
                    {/if}
                </tr>
                <tr>
                    {if $CompanyProfile.IncorpYear neq ""}<td>Year Founded<span>{$CompanyProfile.IncorpYear}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.ListingStatus neq ""}
                    <td>Status<span>{if $CompanyProfile.ListingStatus eq '0'}Both{elseif $CompanyProfile.ListingStatus eq '1'} Listed{elseif $CompanyProfile.ListingStatus eq '2'} Privately held(Ltd){elseif $CompanyProfile.ListingStatus eq '3'} Partnership {elseif $CompanyProfile.ListingStatus eq '4'} Proprietorship{/if}</span></td>
                    {/if}
                </tr>
                <tr>
                    {if $CompanyProfile.Permissions1 neq ""}
                    <td>Transaction Status<span>{if $CompanyProfile.Permissions1 eq '0'}Transacted{elseif $CompanyProfile.Permissions1 eq '1'} Non Transacted{elseif $CompanyProfile.Permissions1 eq '2'} Non-Transacted  and Fund Raising{/if}</span></td>
                    {/if}
                </tr>
                 <tr>
                    {if $CompanyProfile.company_status neq ""}
                    <td>Company Status<span>{ $CompanyProfile.company_status }</span></td>
                    {/if}
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    {if $CompanyProfile.FormerlyCalled neq ""}<td>Former Name<span>{$CompanyProfile.FormerlyCalled}</span></td>{/if}
                </tr>
            </table>
        </td>
        <td>
            <table  style="border: 0;">
                <tr>
                    {if $CompanyProfile.CEO neq ""}
                    <td>Contact Name<span>{$CompanyProfile.CEO}</span></td>
                    {/if}
                </tr>
                <tr>
                    {if $CompanyProfile.CFO neq ""}<td>Designation<span>{$CompanyProfile.CFO}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.auditor_name neq ""}<td>Auditor Name<span>{$CompanyProfile.auditor_name}</span></td>{/if}
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
            </table>
        </td>
        <td>
            <table  style="border: 0;">
                <tr>
                    {if $CompanyProfile.AddressHead neq ""}<td>Address<span>{$CompanyProfile.AddressHead}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.city_name neq ""}<td>City<span>{$CompanyProfile.city_name}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.Country_Name neq ""}<td>Country<span>{$CompanyProfile.Country_Name}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.Phone neq ""}<td>Telephone<span>{$CompanyProfile.Phone}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.Email neq ""}<td>Email<span>{$CompanyProfile.Email}</span></td>{/if}
                </tr>
                <tr>
                    {if $CompanyProfile.Website neq ""}
                    <td>Website<span><a href="{$CompanyProfile.Website_url}" target="_blank">{$CompanyProfile.Website}</a></span></td>
                    {else}
                       <td> Website
                            <span><a href="https://www.google.com/search?btnI=1&q={$SCompanyName}" target="_blank">Click Here</a></span>
                        </td> 
                    {/if}
                </tr>
            </table>
        </td>
    </tr>
     
    <div class="linkedin-bg">
{literal}
     <script type="text/javascript" > 
            
            $(document).ready(function () {
        $('#lframe,#lframe1').on('load', function () {
//            $('#loader').hide();
            
        });
            });
            
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}


 </script>
 {/literal}{if $CompanyProfile.LinkedIn neq ""}
{php}

    $link = $this->get_template_vars('CompanyProfile');
    $url=$link['LinkedIn'];
     $keys = parse_url($url); // parse the url
     $path = explode("/", $keys['path']); // splitting the path
     $companyid = (int)end($path); // get the value of the last element  
{/php}
{literal}

<script type="text/javascript" src="//platform.linkedin.com/in.js"> 
        api_key:65623uxbgn8l
        authorize:true
        onLoad: onLinkedInLoad
        </script>
        <script type="text/javascript" >
           
        var idvalue={/literal}{php} echo $companyid;{/php}{literal};

        function onLinkedInLoad() {
           $("#viewlinkedin_loginbtn").hide(); 
           var profileDiv = document.getElementById("sample");
                    
                    if(idvalue)
                    {                          
                        $("#lframe").css({"height": "220px"});
                        $("#lframe1").css({"height": "300px"});

                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                        $('#lframe').attr('src',inHTML);
                        $('#lframe1').attr('src',inHTML2);
                    }
                    else
                    {
                         $('#lframe').hide();
                         $('#lframe1').hide();
                         $('#loader').hide();
                    }
                     
          }

    </script>
{/literal}

{else}

{literal}
    <script type="text/javascript" src="//platform.linkedin.com/in.js">
        api_key:65623uxbgn8l
        authorize:true
        onLoad: LinkedAuth
    </script>
    <script type="text/javascript" > 
        var idvalue;
         //document.getElementById("sa").textContent='asdasdasd'; 
         
        function LinkedAuth() {

            if(IN.User.isAuthorized()==1){
               $("#viewlinkedin_loginbtn").hide();      
            }
            else {
                 $("#viewlinkedin_loginbtn").show();   
            }
            
            IN.Event.on(IN, "auth", onLinkedInLoad);

          } 
        
        function onLinkedInLoad() {
           $("#viewlinkedin_loginbtn").hide(); 
           var profileDiv = document.getElementById("sample");

               //var url = "/companies?email-domain=<?php echo $linkedinSearchDomain ?>";
               var url ="/company-search:(companies:(id,website-url))?keywords={/literal}{$SCompanyName}{literal}";

                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   
                   
                    console.log(response);  
                    //console.log(response['companies']['values'].length);                  
                    //console.log(response['companies']['values'][0]['id']);
                    //console.log(response['companies']['values'][0]['websiteUrl']);
                    var searchlength = response['companies']['values'].length;
                    
                    var domain='';
                    var website = '{/literal}{$companylinkedIn}{literal}';
                   
                    for(var i=0; i<searchlength; i++){
                        
                        if(response['companies']['values'][i]['websiteUrl']){
                            domain = response['companies']['values'][i]['websiteUrl'].replace('www.','');
                            domain = domain.replace('http://','');
                            domain = domain.replace('/','');
                            if(domain == website){
                                idvalue = response['companies']['values'][i]['id'];
                                console.log(idvalue);
                                break;
                                
                            }
                        }
                    }
                 
                    
                    if(idvalue)
                        {                          
                    $("#lframe").css({"height": "220px"});
                    $("#lframe1").css({"height": "300px"});
                   
                   var inHTML='loadlinkedin.php?data_id='+idvalue;
                    var inHTML2='linkedprofiles.php?data_id='+idvalue;
                    $('#lframe').attr('src',inHTML);
                    $('#lframe1').attr('src',inHTML2);
                    }
                    else
                        {
                             $('#lframe').hide();
                             $('#lframe1').hide();
                             $('#loader').hide();
                        }
                        
                    //  profileDiv.innerHtml=inHTML;
                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                }).error( function(error){
                   console.log(error);
                   $('#lframe').hide();
                   $('#lframe1').hide();
                   $('#loader').hide(); });
          }


        </script>
     
        
        {/literal}
   {/if}

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
        
        <tr><td colspan="5">  <div  id="sample" style="padding:10px 10px 0 0;" class="fl">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
    </div> <div class="fl" style="padding:10px 10px 0 0;" ><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> </td>    </tr>
    </tbody>
    </table> 
    </div>
    <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/" >
    <h2>  COMPANY RATING</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>
        {if $ICRArating neq ""}
    <tr>
        <td>
            ICRA    
            <span><a href="{$ICRAratingUrl}" target="_blank">View Rating</a> ( {$ICRArating} )</span>
        </td>
     </tr>
        {/if}
     <tr>
         <td>
            {if $FCompanyName neq "ANI TECHNOLOGIES PRIVATE LIMITED"}
             CRISIL <span><a href="{$crisilRating}" target="_blank">View Rating</a></span>
        {/if}
        </td>
         <td>
             CARE <span><a href="{$careRating}" target="_blank">View Rating</a></span>
        </td>
         <td>
             &nbsp;
        </td>
     </tr>
     <tr>
         <td>
             SMERA <span><a href="javascript:void(0)" id="smera_link"> View Rating</a></span>
        </td>
        <form action="//www.smera.in/live_ratings.php" name="smera_form" id="smera_form" method="post" target='_blank'>
        {*<input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="">
        <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="">
        <input type="hidden" name="__LASTFOCUS" id="__LASTFOCUS" value="">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwULLTIxNDY5MjcxMzUPZBYCAgMPZBYSAgUPEGRkFgFmZAIHD2QWAgIBDxQrAAIPFgQeC18hRGF0YUJvdW5kZx4LXyFJdGVtQ291bnQCpl9kZBYCZg9kFigCAQ9kFgICAQ9kFgJmDxUFCTEyIEFwciAxNhA8dGQgY29sc3Bhbj0nMic+8AY8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9BY29yZUluZHVzdHJpZXNQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0Fjb3JlSW5kdXN0cmllc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDEyLnBkZicgdGFyZ2V0PSdfYmxhbmsnPkFjb3JlIEluZHVzdHJpZXMgUHJpdmF0ZSBMaW1pdGVkPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMTIuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEIgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkNhc2ggQ3JlZGl0PC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAxLjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgIPZBYCAgEPZBYCZg8VBQkxMiBBcHIgMTYQPHRkIGNvbHNwYW49JzInProLPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvUmFqYXN0aGFuRGlnaXRhbFRpbGVzUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTIucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9SYWphc3RoYW5EaWdpdGFsVGlsZXNQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5SYWphc3RoYW4gRGlnaXRhbCBUaWxlcyBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDggQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+RXhwb3J0IFBhY2thZ2luZyBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAxIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkxldHRlciBvZiBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAyIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkJhbmsgR3VhcmFudGVlPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMC41IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCAw9kFgICAQ9kFgJmDxUFCTEyIEFwciAxNhA8dGQgY29sc3Bhbj0nMic+1QY8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9DYWxjdXR0YU92ZXJzZWFzLVJSLTIwMTYwNDEyLnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvQ2FsY3V0dGFPdmVyc2Vhcy1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5DYWxjdXR0YSBPdmVyc2VhczwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5Gb3JlaWduIERvY3VtZW50YXJ5IEJpbGwgUHVyY2hhc2UgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMTggQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNCs8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlBhY2thZ2luZyBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA1IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQrPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgQPZBYCAgEPZBYCZg8VBQkxMiBBcHIgMTYQPHRkIGNvbHNwYW49JzInPpgJPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvVmVlVmVlQ29udHJvbHNQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1ZlZVZlZUNvbnRyb2xzUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTIucGRmJyB0YXJnZXQ9J19ibGFuayc+VmVlIFZlZSBDb250cm9scyBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCQkItICAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9SZWFmZmlybWVkLmdpZicgdGl0bGU9UmVhZmZpcm1lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMiBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCQi0gIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1JlYWZmaXJtZWQuZ2lmJyB0aXRsZT1SZWFmZmlybWVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+QmFuayBHdWFyYW50ZWU8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA2Ljc1IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTM8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvUmVhZmZpcm1lZC5naWYnIHRpdGxlPVJlYWZmaXJtZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgUPZBYCAgEPZBYCZg8VBQkxMSBBcHIgMTYQPHRkIGNvbHNwYW49JzInPpkJPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvSWNvbkRlc2lnbkF1dG9tYXRpb25Qcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0ljb25EZXNpZ25BdXRvbWF0aW9uUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+SWNvbiBEZXNpZ24gQXV0b21hdGlvbiBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+VGVybSBMb2FuPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA0LjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMS41IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIGD2QWAgIBD2QWAmYPFQUJMTEgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz7DBDxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1ByYWd5YVdvb2RQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1ByYWd5YVdvb2RQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5QcmFneWEgV29vZCBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA1IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIHD2QWAgIBD2QWAmYPFQUJMTEgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz78BDxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1JhamthbWFsQnVpbGRlcnNJbmZyYXN0cnVjdHVyZVByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDExLnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvUmFqa2FtYWxCdWlsZGVyc0luZnJhc3RydWN0dXJlUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+UmFqa2FtYWwgQnVpbGRlcnMgSW5mcmFzdHJ1Y3R1cmUgUHJpdmF0ZSBMaW1pdGVkPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkJhbmsgR3VhcmFudGVlPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgNjAgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBMjxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIID2QWAgIBD2QWAmYPFQUJMTEgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz7uBjxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1NocmVlTWFoYXZpck9pbCZHZW5lcmFsTWlsbHMtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9TaHJlZU1haGF2aXJPaWwmR2VuZXJhbE1pbGxzLVJSLTIwMTYwNDExLnBkZicgdGFyZ2V0PSdfYmxhbmsnPlNocmVlIE1haGF2aXIgT2lsICYgR2VuZXJhbCBNaWxsczwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgNiBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5UZXJtIExvYW48L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgkPZBYCAgEPZBYCZg8VBQkxMSBBcHIgMTYQPHRkIGNvbHNwYW49JzInPugGPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvTk1Gb29kSW1wZXhQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL05NRm9vZEltcGV4UHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+Tk0gRm9vZCBJbXBleCBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCKyAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+UGFja2luZyBDcmVkaXQvRkRCL0ZCRTwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEwIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCCg9kFgICAQ9kFgJmDxUFCTA5IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+8Ag8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9DaGllbkhzaW5nVGFubmVyeS1SUi0yMDE2MDQwOS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0NoaWVuSHNpbmdUYW5uZXJ5LVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPkNoaWVuIEhzaW5nIFRhbm5lcnk8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDQuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEIgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkV4cG9ydCBQYWNraW5nIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0PGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5Gb3JlaWduIEJpbGwgUHVyY2hhc2U8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAILD2QWAgIBD2QWAmYPFQUJMDkgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz7BBjxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL01hcnNDb25zdHJ1Y3Rpb24tUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9NYXJzQ29uc3RydWN0aW9uLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPk1hcnMgQ29uc3RydWN0aW9uPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkNhc2ggQ3JlZGl0PC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAyIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQisgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkJhbmsgR3VhcmFudGVlPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMyBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0PGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgwPZBYCAgEPZBYCZg8VBQkwOSBBcHIgMTYQPHRkIGNvbHNwYW49JzInPtgGPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvUy5NLkNvbnN1bWVyc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvUy5NLkNvbnN1bWVyc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlMuTS4gQ29uc3VtZXJzIFByaXZhdGUgTGltaXRlZDwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5UZXJtIExvYW48L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDUuNDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBEPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMS40IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgRDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIND2QWAgIBD2QWAmYPFQUJMDkgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz6tCzxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL0EuUy5JbmR1c3RyaWVzLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvQS5TLkluZHVzdHJpZXMtUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+QS4gUy4gSW5kdXN0cmllczwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5TZWN1cmVkIG92ZXJkcmFmdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMi41IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQkItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1N1c3BlbmRlZC5naWYnIHRpdGxlPVN1c3BlbmRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMi41OSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9TdXNwZW5kZWQuZ2lmJyB0aXRsZT1TdXNwZW5kZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5JbmxhbmQgTGV0dGVyIG9mIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuOSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0PGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1N1c3BlbmRlZC5naWYnIHRpdGxlPVN1c3BlbmRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlByb3Bvc2VkIExvbmcgVGVybSBCYW5rIEZhY2lsaXR5PC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjUxIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQkItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1N1c3BlbmRlZC5naWYnIHRpdGxlPVN1c3BlbmRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCDg9kFgICAQ9kFgJmDxUFCTA5IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+vQ08ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9TYWt0aGlHZWFyUHJvZHVjdHMtUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9TYWt0aGlHZWFyUHJvZHVjdHMtUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+U2FrdGhpIEdlYXIgUHJvZHVjdHM8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDYgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCQiAgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvVXBncmFkZWQuZ2lmJyB0aXRsZT1VcGdyYWRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMS4zOCBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCICAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9VcGdyYWRlZC5naWYnIHRpdGxlPVVwZ3JhZGVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdCA8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjQ3IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQrPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1VwZ3JhZGVkLmdpZicgdGl0bGU9VXBncmFkZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5MZXR0ZXIgb2YgR3VhcmFudGVlIDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuMDUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNCs8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvVXBncmFkZWQuZ2lmJyB0aXRsZT1VcGdyYWRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlByb3Bvc2VkIEJhbmsgRmFjaWxpdHk8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuNTMgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCQiAgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCDw9kFgICAQ9kFgJmDxUFCTA3IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+nQs8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9CTlByZWNhc3RQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQwNy5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0JOUHJlY2FzdFByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPkJOIFByZWNhc3QgUHJpdmF0ZSBMaW1pdGVkPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbiBJPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjc3IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+VGVybSBMb2FuIElJPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAzLjAxIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEuMjYgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5Qcm9wb3NlZDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMC4wOSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEIgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCEA9kFgICAQ9kFgJmDxUFCTA3IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+tQQ8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9TaHJlZUdhcm9kaVN0ZWVscy1SUi0yMDE2MDQwNy5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1NocmVlR2Fyb2RpU3RlZWxzLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlNocmVlIEdhcm9kaSBTdGVlbHM8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+U2VjdXJlZCBvdmVyZHJhZnQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDExIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQkIgIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAhEPZBYCAgEPZBYCZg8VBQkwNyBBcHIgMTYQPHRkIGNvbHNwYW49JzInPpQJPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvU3BhcmtsaW5lRXF1aXBtZW50c1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvU3BhcmtsaW5lRXF1aXBtZW50c1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlNwYXJrbGluZSBFcXVpcG1lbnRzIFByaXZhdGUgTGltaXRlZDwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCICAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEyIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQrPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5CYW5rIEd1YXJhbnRlZTwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNCs8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCEg9kFgICAQ9kFgJmDxUFCTA2IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+2AQ8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9BbWJpY2FJcm9uJlN0ZWVsUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MDYucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9BbWJpY2FJcm9uJlN0ZWVsUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MDYucGRmJyB0YXJnZXQ9J19ibGFuayc+QW1iaWNhIElyb24gJiBTdGVlbCBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA2IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQisgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCEw9kFgICAQ9kFgJmDxUFCTA2IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+3wY8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9Qb25tdXJ1Z2FuRGhhbGxNaWxscy1SUi0yMDE2MDQwNi5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1Bvbm11cnVnYW5EaGFsbE1pbGxzLVJSLTIwMTYwNDA2LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlBvbm11cnVnYW4gRGhhbGwgTWlsbHM8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDkuOSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+UHJvcG9zZWQgTm9uIEZ1bmQgQmFzZWQgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMC4wMyBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0KzxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIUD2QWAgIBD2QWAmYPFQUJMDYgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz6bCTxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1JpY2hjb3JlTGlmZXNjaWVuY2VzUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MDYucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9SaWNoY29yZUxpZmVzY2llbmNlc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA2LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlJpY2hjb3JlIExpZmVzY2llbmNlcyBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+VGVybSBMb2FuPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA1LjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdCA8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIJDw8WAh4EVGV4dGVkZAIPDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUIQ2F0ZWdvcnkfAGdkEBUKC05HTyBHcmFkaW5nEUJhbmsgTG9hbiBSYXRpbmdzIkNvcnBvcmF0ZSAmIEluZnJhc3RydWN0dXJlIFJhdGluZ3MWTlNJQyBEJkIgU01FUkEgUmF0aW5ncwtTTUUgUmF0aW5ncyhNaWNybyBGaW5hbmNlIEluc3RpdHV0aW9ucyBHcmFkaW5nIChNRkkpE1JFU0NPL1NvbGFyIEdyYWRpbmckTWFyaXRpbWUgVHJhaW5pbmcgSW5zdGl0dXRpb25zIChNVEkpKVByb2plY3QgR3JhZGluZy9HcmVlbmZpZWxkIGFuZCBCcm93bmZpZWxkDUdyZWVuIFJhdGluZ3MVCgIxMQExATUBNAEyATMCMTABNgE4ATkUKwMKZ2dnZ2dnZ2dnZ2RkAhsPFCsAAmQQFgAWABYAZAIdDw8WAh4HVmlzaWJsZWhkZAIfDw8WAh8CBSNTaG93aW5nIDEgdG8gMTIxOTggb2YgMTIxOTggcmVjb3Jkc2RkAiEPDxYCHwVoZGQCIw8PZBYCHgVzdHlsZQUNZGlzcGxheTpub25lO2QYAwUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFhAFDmhlYWRlcjEkaW1nYnRuBQxDaGtQcm9kdWN0JDAFDENoa1Byb2R1Y3QkMQUMQ2hrUHJvZHVjdCQyBQxDaGtQcm9kdWN0JDMFDENoa1Byb2R1Y3QkNAUMQ2hrUHJvZHVjdCQ1BQxDaGtQcm9kdWN0JDYFDENoa1Byb2R1Y3QkNwUMQ2hrUHJvZHVjdCQ4BQxDaGtQcm9kdWN0JDkFDENoa1Byb2R1Y3QkOQUOQnRuRmluYWxTZWFyY2gFEWJ0bmNsZWFyc2VsZWN0aW9uBRZEYXRhUGFnZXIxJGN0bDAwJGN0bDAwBRZEYXRhUGFnZXIxJGN0bDAyJGN0bDAwBQpEYXRhUGFnZXIxDxQrAARkZAIUAqZfZAUGTHN0U01FDxQrAA5kZGRkZGRkPCsAFAACpl9kZGRmAhRktN+aK0koX65tvgEiYJbOxF9S4A1ZDPobHYfYrkLpO9I=">

        <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="4AD88828">*}
        {*<!--input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEdACFlF39g5oQfRe874tZaaPFhZnyT7mhEczBnOZh7VM+/IlOhAn/YhUrcrtqAeI6+OkiCayLekQ77MYsrgRXByfQgF0Dhpkl1nNz5e6dmE6dnzHRTr3s3m8GcmwVu2qYu5ecXP6t0Rcqexq4DNVm7nvD+Dy4FclcPPIrz9uFm9ZVt+v6DZBrlp4Wv154ssZZW8VzVK4xUN5MTWA2Q4+HdbBMXNLkTIHg9xHcv2OSivhFeVjMQ5kispLpi+GfUulZFP9m7kE33ytKotW52m5UaflgVUYBiQauv67NsiUdxmWjOtrO1C7lE/c33D3DXsU1LVMMfqASBqjdtbF7L2z5VhQbVbY3m2KYppm4VVgUBGeE6GnfOdvkoHBbtMsQtH1HPfya4MuQKxLvDyuqaOrN8b4KyzsoKVM0lTE5Ymrt36nSnM2aLkCCLnVxqWAc1dVRXdb8JNT0JOYkdhzKbJTtzbwRSQ5UhdGvk3TctiQB8SJ8f261Pm+/5aT4TB3Xnw1s66+KknSDv+dGkMzfxzMpA+SMoFejdtvsuIJjd933uIAkUJsZvdfSDdKKibaf+giRyS6y+aAgxGPHO/fZuhI6L/xpUkvDbheG+TO9QQxm8+yJTO9ZoeaA/UoiEk4gtvGX/vVKQWLIo8nlUkh4jiurJf2EmMXRmKK0eQ5t13d2bgn72exlw577zXeceGN1AFH+9I8IsKf5CioyJlmMp/Qz1OSMMWII9OxOBnRk+BIHproa9Ag=="-->*}
         <!--   <input type="hidden" name="company_name" id="company_name" value="{$SCompanyName}" />
        </form>
            {literal}
                <script type="text/javascript" >
                $( "#smera_link" ).click(function() {
                  $( "#smera_form" ).submit();
                });    
                </script>
            {/literal}
         <td>
             BRICKWORK
            <form action="//www.brickworkratings.com/CreditRatings.aspx" name="form1" id="form1" method="post" target='_blank'>    
           <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="">
           <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="">
          <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="{$B_VIEWSTATE}" />

           <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="D090B1EF">
               <input type="hidden" name="__SCROLLPOSITIONX" id="__SCROLLPOSITIONX" value="0" />
               <input type="hidden" name="__SCROLLPOSITIONY" id="__SCROLLPOSITIONY" value="0" />
               <input type="hidden" name="__VIEWSTATEENCRYPTED" id="__VIEWSTATEENCRYPTED" value="" />
           <input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="{$B_EVENTVALIDATION}" />
               <input type="hidden" name="txtSearch" value="{$SCompanyName}" />
               <span> <input type="submit" name="btnSearch" style="border:none;color: #c0a172; font-weight: bold; text-decoration: underline; font-size: 16px; text-align: left; background: none; padding: 0;" value="View Rating" /> </span>
           </form>
        </td>
        <td>
             ICRA
             <span><a href="http://www.icra.in/search.aspx?word={$SCompanyName_url}" target="_blank">View Rating</a></span>
        </td>
     </tr> 
    </tbody>
    </table> 
    </div>  -->
    </div>  
    {if $roc}
          <div  class="work-masonry-thumb col-4 tab_menu" id="registered" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>REGISTERED</h2>
        <ul class="registered-trade"> <li><span>{$roc}</span></li></ul>
        </div>     
      {/if}  
      <!-- <span id="mca_data" class="tab_menu"><div style="margin-bottom:20px;">MCA data look up... <img src="images/loadingAnimation.gif" style="margin-left:10px;"/></div></span> -->  
        
          <div  class="work-masonry-thumb col-4 tab_menu" href="http://erikjohanssonphoto.com/work/aishti-ss13/" id="filings">
     <!--  {if $searchResults}
    <h2>FILINGS <a class="postlink" href="viewfiling.php?c={$encodedcompany}&cid={$Company_Id}"> View all</a></h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links">
    <thead><tr><th>File Name </th> <th>Date</th></tr></thead>
    <tbody>
         {section name=customer loop=$searchResults} 
             {if $smarty.section.customer.index lt 5}
        <tr><td style="alt">{$searchResults[customer].name}</td>
            <td> {if $searchResults[customer].uploaddate} {$searchResults[customer].uploaddate} {else} -- {/if} </td>    </tr>  
        {/if}
        {/section}
    </tbody>
    </table> 
    {else}
        <h2>FILINGS </h2>
        <div class="no_data">No data found</div>
       {/if}   -->
    </div>
   <!-- <span id="mca_data1" class="tab_menu"><div style="margin-bottom:20px;">MCA data look up... <img src="images/loadingAnimation.gif" style="margin-left:10px;"/></div></span> -->
       
    
   <!-- {if $indexofchargeitems}   
    <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>Index Of Charge</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links">
    <thead><tr><th>Charge ID </th> <th>Date of Charge </th> <th>Charge amount</th>  <th>Charge Holder Name</th> <th>Charge Holder Address</th> </tr></thead>
    {$indexofchargeitems}
    </table> 
    </div>    
    {/if}    
    -->
   
   <!-- <span id="mca_data2" class="tab_menu"><div style="margin-bottom:20px;">MCA data look up... <img src="images/loadingAnimation.gif" style="margin-left:10px;"/></div></span> -->
      
    <div id="funding-ajax" class="tab_menu work-masonry-thumb col-4"></div>

    <!-- <div id="master-data"  class="work-masonry-thumb col-4 tab_menu empty-container">
        <h2>COMPANY MASTER DATA</h2>
        <div class="data-ext-load">
            <div id="mca_data">
                <b>This data is being fetched from an external web site (Ministry Of Corporate Affairs). </b></br/></br/>
                <b><span class="btn-center"><a href="javascript:;">OK, Please Load.</a></span></b><br/><br/>
                <span class="bottom-text"> It can be upto 2 minutes to load.</span>
            </div>
        </div>
    </div>
    <div id="signatories_result"  class="work-masonry-thumb col-4 tab_menu empty-container">
        <h2>BOARD OF DIRECTORS</h2>
        <div class="data-ext-load">
             <div id="mca_data1">
                <b>This data is being fetched from an external web site (Ministry Of Corporate Affairs). </b></br/></br/>
                <b><span class="btn-center"><a href="javascript:;">OK, Please Load.</a></span></b><br/><br/>
                <span class="bottom-text"> It can be upto 2 minutes to load.</span>
            </div>
        </div>
    </div>
    <div id="chargesRegistered"  class="work-masonry-thumb col-4 tab_menu empty-container">
        <h2>INDEX OF CHARGES</h2>
        <div class="data-ext-load">
             <div id="mca_data2">
                <b>This data is being fetched from an external web site (Ministry Of Corporate Affairs). </b></br/></br/>
                <b><span class="btn-center"><a href="javascript:;">OK, Please Load.</a></span></b><br/><br/>
                <span class="bottom-text">It can be upto 2 minutes to load.</span>
            </div>
        </div> 
    </div>-->
     <div id="master-data-all"  class=" col-4 tab_menu empty-container1" style="display:none;">

     
     <div class="master-data-header" style="">
        <ul class="primary">
            <li  class="active"> <a href="javascript:;" data-head="cmd" >  Company Master Data   </a> &nbsp; /</li>
            <li class="active" style="padding-left:0px;"> <a href="javascript:;"  data-head="bod" style="text-decoration: underline;">Board of Directors</a>  </li>
        </ul>

        <ul class="secondary">
            <li> <a href="javascript:;" data-head="ioc">  Index of Charges   </a>   </li>
        </ul> 

    </div>

    <div style="clear:both"> 

    </div>



     <div id="master-data">  
       <div class="work-masonry-thumb empty-container"> 
        <h2>COMPANY MASTER DATA</h2>
        <div class="data-ext-load">
            <div id="mca_data">
                <b>This data is being fetched from an external web site (Ministry Of Corporate Affairs). </b></br/></br/>
                <b><span class="btn-center"><a href="javascript:;">OK, Please Load.</a></span></b><br/><br/>
                <span class="bottom-text">It can be upto 2 minutes to load. </span>
            </div>
        </div>
        </div>

    </div>


    <div id="signatories_result" style="display:none;">

    <div id="signatories_result1"  class="work-masonry-thumb empty-container">
        <h2>BOARD OF DIRECTORS</h2>
        <div class="data-ext-load">
             <div id="mca_data1">
                <b>This data is being fetched from an external web site (Ministry Of Corporate Affairs). </b></br/></br/>
                <b><span class="btn-center"><a href="javascript:;">OK, Please Load.</a></span></b><br/><br/>
                <span class="bottom-text"> It can be upto 2 minutes to load.</span>
            </div>
        </div>
    </div>
 </div>



<div id="chargesRegistered" style="display:none;">
 <div id="chargesRegistered1" class="work-masonry-thumb empty-container">
        <h2>INDEX OF CHARGES</h2>
        <div class="data-ext-load">
            <div id="mca_data2">
                    <b>This data is being fetched from an external web site (Ministry Of Corporate Affairs).</b></br/></br/>
                    <b><span class="btn-center"><a href="javascript:;">OK, Please Load.</a></span></b><br/><br/>
                    <span class="bottom-text"> It can be upto 2 minutes to load. </span>
            </div>
        </div>
 </div>
 </div>



 </div>


               </div> 
  </form>
        
  
</div>
{else}
            <h5>"Your Subscription limit of {$grouplimit[0][2]} companies has been reached. Please contact info@ventureintelligence.com to top up your subscription"</h5><br/>
                    {/if}
</div>
<div class="click-top">
    <a href="javascript:;"><!-- <img src="images/arrow-up-.png" title="Back to Top" alt="Back to Top" class="backtotop"/> --><div class="scrollarrow backtotop"></div></a>
</div>

<div id="maskscreen" class="maskscreenMCA"></div>
<div class="lb" id="lookup-box">
    <div class="title"></div>
    <div class="lookup-body">
        MCA data look up. It can be upto 2 minutes to load... <img src="images/loadingAnimation.gif" style="margin-left:10px;"/><br/><br/>
        <b><a href="javascript:;" class="close-lookup">Cancel.</a></b><br/><br/> 
        <span>This is too slow.</span>
    </div>
</div>

<div id="maskscreen"></div>
<div class="lb" id="exportall-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-head" style="padding: 0px 20px;padding-top: 10px;"><h3 style="text-align:center">Export Data</h3></div>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      &copy; TSJ Media Pvt. Ltd. All financial data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" onClick="window.open('downloadtrackAll.php?vcid={$VCID}','_blank')" class="agree-exportall">I Agree</a></b>
      <!-- <b><a href="javascript:;" onClick="window.open('{$MEDIA_PATH}companyDetail/companyDetail_{$VCID}.xls','_blank')" class="agree-exportall">I Agree</a></b> --><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>
<div class="lb" id="popup-box-deals">
    <div class="title">Send this to Venture</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress_fc" id="toaddress_fc"  value="research@ventureintelligence.com"/>
            </div>
            <div class="entry">
                    <h5>Subject*</h5>

                    {if $CompanyProfile.Permissions1 eq '0'}
                        <p>Request for funding data</p>
                        <input type="hidden" name="subject_fc" id="subject_fc" value="Request for funding data"  />
                    {else}
                        <p>To double check if the company is transacted</p>
                        <input type="hidden" name="subject_fc" id="subject_fc" value="To double check if the company is transacted"  />
                    {/if}
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p>www.ventureintelligence.com/cfsnew/details.php?vcid={$VCID}  <input type="hidden" name="message_fc" id="message_fc" value="http://www.ventureintelligence.com/cfsnew/details.php?vcid={$VCID}"  />   
                    <input type="hidden" name="useremail_fc" id="useremail_fc" value="{$SESSION_UserEmail}"  /> </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailfnbtn" />
                <input type="button" value="Cancel" id="cancelfnbtn" />
            </div>

        </form>
    </div>

<div class="lb" id="popup-box-FY-data">
    <div class="title">Send this to Venture</div>
        <form>
            <div class="entry">
                <label> To*</label>
                <p>cfs@ventureintelligence.com</p>
                <input type="hidden" name="toaddress_fc" id="toaddress_fc"  value="cfs@ventureintelligence.com"/>
            </div>
            <div class="entry">
                <h5>Subject*</h5>
                <p>To add Balance Sheet data</p>
                <input type="hidden" name="subject_fc" id="subject_fc" value="To add Balance Sheet data"  />
            </div>
            <div class="entry">
                <h5>Message</h5>
                <p>Add financial year data for company {$FCompanyName} - {$SCompanyName}
                    <input type="hidden" name="message_fc" id="message_fc" value="Add financial data for company {$FCompanyName} - {$SCompanyName}"  />   
                    <input type="hidden" name="useremail_fc" id="useremail_fc" value="{$SESSION_UserEmail}"  />
                </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailfybtn" />
                <input type="button" value="Cancel" id="cancelfybtn" />
            </div>

        </form>
    </div> 
    <div id="maskscreen"></div>
<!-- <div class="successmsg"><div class="successmsg-text">Your request has been sent successfully</div></div> -->
<div class="model">
        <div class="lb" id="successmsgpopup">
            <div class="title">Send Mail to Customer</div>
            <div class="successmsg-text">Your mail has been sent successfully</div>
        </div>
    </div>

<div class="model">
    <div class="lb" id="mail-boxDetail">
        <div class="title">Send Mail to Customer</div>
            <form class="box-sizing smcmodel">
            <div class="entry entry-pad">
                <label> From</label>
                    <input type="text" name="smc_fromaddress" id="smc_fromaddress" value="cfs@ventureintelligence.in"  />
            </div>
            <div class="entry entry-pad">
                <label> To</label>
                    <input type="text" name="smc_toaddress" id="smc_toaddress" value="" />
            </div>
            <div class="entry entry-pad">
                <label> CC</label>
                    <input type="text" name="smc_cc" id="smc_cc" value="" />
            </div>
            <div class="entry entry-pad">
                <label> BCC</label>
                    <input type="text" name="smc_bcc" id="smc_bcc" value="" />
            </div>
                  
                    <input type="hidden" name="smc_companyname" id="smc_companyname" value="{$FCompanyName} - {$SCompanyName}" />
                    <input type="hidden" name="smc_companyid" id="smc_companyid" value="{$Company_Id}" />
            <div class="entry entry-pad full-width"> 
                <label>Message</label>
                <div class="textarea"  >
                        
                        <input type="radio" value="0" name="smc_message" class="radio-button" id="financials">
                        <label class="radio-lable">
                            <span >We have updated Latest Financials and Annual Filings of the company. Please visit the following link to access the same:</span>
                        </label>
                        <br>
                        <div class="link-box">
                            <label class="label-financials">Financials:</label>
                            <input type="text" name="u_financials" id="u_financials" value="{$link}"  class="text-financials" />
                            <label class="label-filings">Annual Filings:</label>
                            <input type="text" name="u_annual_filings" id="u_annual_filings" value=""  class="text-filings" />
                            <div class="clearfix mb-0"></div>
                        </div>
                        
                            <input type="radio" value="1" name="smc_message" class="radio-button" id="filings">
                        
                        <div class="financial-lable">
                            <span>Latest financial FY</span> <input type="text" name="latest_financials" id="latest_financials" maxlength="2" class="fyyear"> <span>unavailable.</span> 
                            <span>Company has last filed FY</span> <input type="text" name="last_filled" id="last_filled" maxlength="2" class="fyyear"> .
                        </div>
                        <br>
                        <!-- <div class="entry full-width floatnone"> 
                            
                                <textarea name="smc_textMessage" id="smc_textMessage" rows="5" cols="50"></textarea>
                        </div> -->
                        <p class="textareanew" contenteditable="true"></p>
                        <p class="signature" contenteditable="true">Thanks & Regards, <br>Venture Intelligence CFS Team <br>Tel: 91-44-4218-5182</p>
                    </div>
                   
            </div>
            <div class="entry">
                <input type="button" value="Send" id="mailbtnDetail1">
    
                <input type="button" value="Cancel" id="cancelbtnDetail1">
            </div>
            <div class="clearfix"></div>
        </form>
    </div>
</div>
            {literal}
<script>

     $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
            $('#cancelbtn').click(function(){ 

               jQuery('#popup-box').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
           $("#result").on('click', '.updateFinancialDetail', function() {
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-boxDetail').fadeIn();   
                    return false;
                });
           $(".updateFinancialDetail1").on('click', function() {
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-boxDetail').fadeIn();   
                    return false;
                });
            $('#cancelbtnDetail').click(function(){ 

               jQuery('#popup-boxDetail').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
           
       $(document).ready(function(){
 $('#mailbtnDetail').click(function(e){
        e.preventDefault(); 
        var to = $('#u_toaddress').val().trim();
        var subject = $('#u_subject').val().trim();
        var textMessage = $('#u_textMessage').val().trim();
        var from = $('#u_fromaddress').val().trim();
        var cc = $('#u_cc').val().trim();
        if(from ==''){
            alert("Please enter the from address");
            $('#u_fromaddress').focus();
            return false;
        }
        else if(!(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/).test(from)){
            alert('Invalid from address');
            $('#u_fromaddress').focus();
            return false;
        }
        else if((cc !='') && (!(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/).test(from))){
            alert('Invalid CC');
            $('#u_fromaddress').focus();
            return false;
        }
        else if(textMessage =='')
        {
          alert("Please enter the message");
            $('#u_textMessage').focus();
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
                         $('#u_fromaddress').val('');
                         $('#u_textMessage').val('');
                         $('#u_cc').val('');
                         jQuery('#popup-boxDetail').fadeOut();   
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
            function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
            function checkEmail() {

                var email = $("#toaddress").val();
                    if (email != '') {
                        var result = email.split(",");
                        for (var i = 0; i < result.length; i++) {
                            if (result[i] != '') {
                                if (!validateEmail(result[i])) {

                                    alert('Please check, `' + result[i] + '` email addresses not valid!');
                                    email.focus();
                                    return false;
                                }
                            }
                        }
                }
                else
                {
                    alert('Please enter email address');
                    email.focus();
                    return false;
                }
                return true;
            }
            
             $('#mailbtn').click(function(){ 
                        
                        if(checkEmail())
                        {
                            
                        
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress").val(), subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                        });
                        }
                        
                    });

$(".btn-sendmail").click(function(){
                    $('#maskscreen').fadeIn(1000);
                    if($(window).height() < 780 ){
                        $("#mail-boxDetail").css({"height": $(window).height() - 100});
                    }
                    $('#mail-boxDetail').fadeIn();  
                    $('.smcmodel').trigger("reset");
                    $('.textareanew').html(""); 
                    $('#mail-boxDetail .custom.radio').removeClass('checked');   
                    return false;
                });

    $("#cancelbtnDetail1").click(function(){
                    $('#mail-boxDetail').fadeOut();   
                    $('#maskscreen').fadeOut(1000);
                    return false;
                });
    
    $('input[type=radio][name=smc_message]').change(function() {

        if($(this).val() == 0){
            $('.text-financials').css('pointer-events','auto');   
            $('.text-filings').css('pointer-events','auto'); 
            $('.fyyear').css('pointer-events','none');  
        } else {
            $('.text-financials').css('pointer-events','none');   
            $('.text-filings').css('pointer-events','none');
            $('.fyyear').css('pointer-events','auto');
            
        }
    });
    $(document).ready(function(){
        $('#mailbtnDetail1').click(function(e){
            e.preventDefault(); 
            var to = $('#smc_toaddress').val().trim();
            var from = $('#smc_fromaddress').val().trim();
            var cc = $('#smc_cc').val().trim();
            var bcc = $('#smc_bcc').val().trim();
            //var textMessage = $('#smc_textMessage').val();
            var textMessage = $('.textareanew').html();
            var financials = $('#u_financials').val().trim();
            var annual_filings = $('#u_annual_filings').val().trim();
            var latest_financials= $('#latest_financials').val().trim();
            var last_filled = $('#last_filled').val().trim();
            var message = $("input[name='smc_message']:checked").val();
            var companyId = $('#smc_companyid').val();
            var companyName = $('#smc_companyname').val();
            var signature = $('.signature').html();
            //var forfinacial = jQuery('#forfinacial').html();
            //var forfilled = jQuery('#forfilled').html();
            //alert(companyId);
            
            if(to ==''){
                alert("Please enter To address");
                return false;
            }
           else if(message =='' &&  textMessage=='' ){
                alert('Please select message');
                return false;
            } 

            else if(message ==undefined &&  textMessage=='' ){
                alert('Please select message');
                return false;
            }  
            else{
                    jQuery.ajax({
                        url: 'ajaxupdatesendmails.php',
                        type: "POST",
                        data: { 
                            to : to, 
                            cc: cc, 
                            from : from,
                            bcc : bcc,
                            financials:financials,
                            annual_filings:annual_filings,
                            latest_financials:latest_financials,
                            last_filled:last_filled,
                            message:message,
                            companyId:companyId,
                            companyName:companyName,
                            signature:signature,
                            textMessage:textMessage
                        },
                        success: function(data){
                            
                            if(data=="1"){       
                                    $('#mail-boxDetail').fadeOut();  
                                    $('#successmsgpopup').fadeIn();
                                    setTimeout(function(){
                                        $('#maskscreen').fadeOut(1000);
                                        $('#successmsgpopup').fadeOut(1000); 
                                    }, 1000);
                                    return true;
                            }
                            else{
                                    $('#mail-boxDetail').fadeOut();  
                                    $('#successmsgpopup').fadeIn();
                                    setTimeout(function(){
                                        $('#maskscreen').fadeOut(1000);
                                        $('#successmsgpopup').fadeOut(1000); 
                                    }, 1000);
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


        $('#exportall').click(function(){
              jQuery('#maskscreen').fadeIn(1000);
              $( '#exportall-popup' ).show();
              return false; 
            });
        $( '.agree-exportall').on( 'click', function() {    
            jQuery('#maskscreen').fadeOut(1000);
            $( '#exportall-popup' ).hide();
            return false;
        });
        $( '#exportall-popup' ).on( 'click', '.close-lookup', function() {
            $( '#exportall-popup' ).hide();
            jQuery('#maskscreen').fadeOut(1000);
        });
        
var xhrMca = '';
//$(".click-top").on('click', '.backtotop', function() { 
$( ".backtotop" ).click(function(e) {  
    e.preventDefault();
    var position = $(".cfs_menu").position();
    var position_top = position.top - 15;
    $("html").animate({ scrollTop: position_top }, "slow");
    return false;
});
 
$(window).scroll(function() {
    var height = $(window).scrollTop();
    if(height  > 400) {
        $('.click-top').show();
    }else{
        $('.click-top').hide();        
    }
});
$( '#mca_data a' ).on( 'click', function() {
    $( '#lookup-box .title' ).text( 'COMPANY MASTER DATA' );
    $( '#lookup-box' ).fadeIn();
    $( '.maskscreenMCA' ).fadeIn();
    /*if( cin == 'U99999MH1993PLC072892' || 'L99999GJ1987PLC009768' ) {
        var tttt = 'ajax_mca_profile_1.php';
    } else {
        var tttt = 'ajax_mca_profile.php';
    }*/
    xhrMca = $.ajax({
        type: 'GET',
        url: 'ajax_mca_profile_1.php',
        data: {cin: ""+cin+""},
        success: function(data) {
             var respData = $( data );
             if(data ==403 || data == 302 || data == 0 || data == 404 || data.startsWith("Javascript") == true){
                $( '#mca_data a' ).trigger('click');
              
            }else{
            mcadataload( respData );
            }
        },
        timeout: 180000
    });
});
$( '#mca_data1 a' ).on( 'click', function() {
    $( '#lookup-box .title' ).text( 'BOARD OF DIRECTORS' );
    $( '#lookup-box' ).fadeIn();
    $( '.maskscreenMCA' ).fadeIn();
    /*if( cin == 'U99999MH1993PLC072892' || 'L99999GJ1987PLC009768' ) {
        var tttt = 'ajax_mca_director_1.php';
    } else {
        var tttt = 'ajax_mca_director.php';
    }*/
    xhrMca = $.ajax({
        type: 'GET',
        url: 'ajax_mca_director_1.php',
        dataType : 'html',
        data: {cin: ""+cin+""},
        success: function(data) {
            var respData = $( data );
            mcadataload( respData );
        },
        timeout: 180000
    });
});
$( '#mca_data2 a' ).on( 'click', function() {
    $( '#lookup-box .title' ).text( 'INDEX OF CHARGES' );
    $( '#lookup-box' ).fadeIn();
    $( '.maskscreenMCA' ).fadeIn(); 
    /*if( cin == 'U99999MH1993PLC072892' || 'L99999GJ1987PLC009768' ) {
        var tttt = 'ajax_mca_charges_1.php';
    } else {
        var tttt = 'ajax_mca_charges.php';
    }*/
    xhrMca = $.ajax({
        type: 'GET',
        url: 'ajax_mca_charges_1.php',
        data: {cin: ""+cin+""},
        success: function(data) {
            var respData = $( data );
             if(data ==403 || data == 302 || data == 0 || data == 404 || data.startsWith("Javascript") == true){
               
                 $( '#mca_data2 a' ).trigger('click');
            } else {
                 mcachargeload(respData); 
            }
        },
        timeout: 180000
    });

});
$( '.close-lookup' ).on( 'click', function() {
    if( xhrMca.readyState ) {
        xhrMca.abort();
    }
    $.ajax({
        type: 'GET',
        url: 'ajax_mca_close.php',
        data: "",
        success: function(data) {
            
        }
    });
   $( '#lookup-box' ).fadeOut();
   $( '#maskscreen' ).fadeOut(); 
});
$('.master-data-header li a' ).on( 'click', function() {
   $dataHead = $(this).attr("data-head");
   // alert($dataHead);
     if($dataHead == 'cmd') {
        $("#master-data").show();
        $("#chargesRegistered, #signatories_result").hide();
        $(".primary li:first-child a").css("text-decoration","none");
        $(".primary li:last-child a").css("text-decoration","underline");
        $(".secondary li a").css("text-decoration","none");
        $(".secondary li").removeClass("active");
        $(".primary li").addClass("active");
    } else if($dataHead == 'bod') {
        $("#signatories_result").show();
        $("#master-data, #chargesRegistered").hide();
        $(".primary li:first-child a").css("text-decoration","underline");
        $(".primary li:last-child a").css("text-decoration","none");
        $(".secondary li a").css("text-decoration","none");
        $(".secondary li").removeClass("active");
        $(".primary li").addClass("active");
    } else if($dataHead == 'ioc') {
        $("#chargesRegistered").show();
        $("#master-data, #signatories_result").hide();
        $(".primary li:first-child a").css("text-decoration","none");
        $(".primary li:last-child a").css("text-decoration","none");
        $(".secondary li a").css("text-decoration","none");
        $(".primary li").removeClass("active");
        $(".secondary li").addClass("active");
    }
});
function mcachargeload(respData){
      if( respData.attr("id") == "masterData_403_error" ) {
                $('#chargesRegistered #mca_data2').html(respData);
            } else {
                var LLPMasterCharge = respData.find('table#charges');
                if( LLPMasterCharge.length ) {
                    var finData = `<div  class="col-4 indexChargesBox" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                                        <h2 style="color:#c0a172;font-size:18px;border-bottom:1px solid #d4d4d4">Index Of Charges</h2>
                                        `+LLPMasterCharge[0].outerHTML+`             
                                    </div>`;
                    $( '#chargesRegistered' ).removeClass( 'empty-container' );
                } else {
                    var finData = `<div  class="col-4 indexChargesBox" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                                       <h2 style="color:#c0a172;font-size:18px;border-bottom:1px solid #d4d4d4">Index Of Charges</h2><div class="no_data">No data found</div>             
                                    </div>`;
                    $( '#chargesRegistered' ).addClass( 'empty-container' );
                }
                $('#chargesRegistered').html(finData);
            }
            $( '#lookup-box' ).fadeOut();
            $( '.maskscreenMCA' ).fadeOut();

}

function mcadataload( data ) {
    if( data.attr("id") == "masterData_403_error" ) {
        $('#signatories_result #mca_data1, #master-data #mca_data').html(data);
    } else {
        // MASTER DATA STARTS
        if( data.find('form#exportCompanyMasterData').length > 0 ) {
            var LLPMasterProfile = data.find('div#companyMasterData');
            var llpMasterData = data.find('div#llpMasterData');
            var LLPMasterSignatories = data.find('div#signatories');
            var LLPMasterFormSubmit = data.find('input#exportCompanyMasterData_0');
            var LLPMasterFormAltScheme = data.find('input#altScheme');
            var LLPMasterFormExportCompanyMasterData_companyID = data.find('input#exportCompanyMasterData_companyID');
            var LLPMasterFormExportCompanyMasterData_companyName = data.find('input#exportCompanyMasterData_companyName');
            var masterData = `<style>#resultTab1{width:100%} /*#chargesRegistered div,*/ #signatories div{padding: 0px 10px 10px 10px;
                                margin: 0;
                                border-bottom: 1px solid #d4d4d4;
                                color: #c09f74 !important;
                                font-weight: bold;
                                font-size: 18px;} .table-header th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; padding: 10px; }


                            /* The Modal (background) */
                            .modal {
                                display: none; /* Hidden by default */
                                position: fixed; /* Stay in place */
                                z-index: 1; /* Sit on top */
                                padding-top: 100px; /* Location of the box */
                                left: 0;
                                top: 0;
                                width: 100%; /* Full width */
                                height: 100%; /* Full height */
                                overflow: auto; /* Enable scroll if needed */
                                background-color: rgb(0,0,0); /* Fallback color */
                                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                            }

                            /* Modal Content */
                            .modal-content {
                                background-color: #fefefe;
                                margin: auto;
                                padding: 20px;
                                border: 1px solid #888;
                                width: 80%;
                                min-height: 500px;
                            }

                            /* The Close Button */
                            .close {
                                color: #aaaaaa;
                                float: right;
                                font-size: 28px;
                                font-weight: bold;
                            }

                            .close:hover,
                            .close:focus {
                                color: #000;
                                text-decoration: none;
                                cursor: pointer;
                            }
                            .modal-content #resultsTab2, .modal-content #resultsTab3{ width : 100%;}
                            .modal-content table tr th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; }
                            .modal-content table{ border:1px solid #d4d4d4; }
                            .modal-content #dirMasterData span{ color: #c09f74 !important; font-weight: bold;}
                            table{
                                    border-spacing: 0px;
                            }
                            .finance-cnt .imgButton{
                                    margin: 0;
                                font-size: 14px;
                                border: 1px solid #000;
                                float: left;
                                background: #a37635;
                                padding: 3px 5px;
                                text-transform: uppercase;
                                color: #fff;
                                font-weight: bold;
                            }
                            #charges b{color:#c0a172;font-size:18px;}
                            #resultTab1{ border-bottom: none;}
                            </style>`;
                masterData += `<form id="exportCompanyMasterData" name="exportCompanyMasterData" action="http://www.mca.gov.in/mcafoportal/exportCompanyMasterData.do" method="post">   
                            <div  class="col-4" id="companyMasterData_result" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                                <h2> Company Master Data <span style="float:right;">`+LLPMasterFormSubmit[0].outerHTML+`</span></h2>
                                <span id='llp_result'>
                               `+LLPMasterProfile[0].outerHTML+`
                                </span>
                           </div>
                            `+LLPMasterFormAltScheme[0].outerHTML+`
                            `+LLPMasterFormExportCompanyMasterData_companyID[0].outerHTML+`
                            `+LLPMasterFormExportCompanyMasterData_companyName[0].outerHTML+`
                                </form>`;

                $('#master-data').html(masterData);
                $( '#master-data' ).removeClass( 'empty-container' );
                var companyMasterData = $('#companyMasterData').html();
                var companyMasterData_val = $.trim(companyMasterData);
                if(companyMasterData_val == ''){
                    $('#llp_result').html(llpMasterData[0].outerHTML);
                }
                $( '#lookup-box' ).fadeOut();
                $( '.maskscreenMCA' ).fadeOut();
        } else {
            var finData = `<div  class="col-4" id="companyMasterData_result" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                            <h2> Company Master Data</h2>
                            <div class="no_data">No data found</div>
                        </div>`;
            
            $('#master-data').html(masterData);
            $('#master-data').addClass( 'empty-container' );
        }
        // MASTER DATA ENDS
        // BOARD OF DIRECTORS STARTS
        if( data.find('form#exportCompanyMasterData').length > 0 ) {
            var boardData = `<style>#resultTab1{width:100%} /*#chargesRegistered div,*/ #signatories div{padding: 0px 10px 10px 10px;
                            margin: 0;
                            border-bottom: 1px solid #d4d4d4;
                            color: #c09f74 !important;
                            font-weight: bold;
                            font-size: 18px;} .table-header th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; padding: 10px; }


                        /* The Modal (background) */
                        .modal {
                            display: none; /* Hidden by default */
                            position: fixed; /* Stay in place */
                            z-index: 1; /* Sit on top */
                            padding-top: 100px; /* Location of the box */
                            left: 0;
                            top: 0;
                            width: 100%; /* Full width */
                            height: 100%; /* Full height */
                            overflow: auto; /* Enable scroll if needed */
                            background-color: rgb(0,0,0); /* Fallback color */
                            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
                        }

                        /* Modal Content */
                        .modal-content {
                            background-color: #fefefe;
                            margin: auto;
                            padding: 20px;
                            border: 1px solid #888;
                            width: 80%;
                            min-height: 500px;
                        }

                        /* The Close Button */
                        .close {
                            color: #aaaaaa;
                            float: right;
                            font-size: 28px;
                            font-weight: bold;
                        }

                        .close:hover,
                        .close:focus {
                            color: #000;
                            text-decoration: none;
                            cursor: pointer;
                        }
                        .modal-content #resultsTab2, .modal-content #resultsTab3{ width : 100%;}
                        .modal-content table tr th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; }
                        .modal-content table{ border:1px solid #d4d4d4; }
                        .modal-content #dirMasterData span{ color: #c09f74 !important; font-weight: bold;}
                        table{
                                border-spacing: 0px;
                        }
                        .finance-cnt .imgButton{
                                margin: 0;
                            font-size: 14px;
                            border: 1px solid #000;
                            float: left;
                            background: #a37635;
                            padding: 3px 5px;
                            text-transform: uppercase;
                            color: #fff;
                            font-weight: bold;
                        }
                        #charges b{color:#c0a172;font-size:18px;}
                        #resultTab1{ border-bottom: none;}
                        </style>`;
            var LLPMasterSignatories = data.find( 'div#signatories' );
            if( LLPMasterSignatories.length ) {
                boardData += `<div  class="col-4 signatories_result" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                                    `+LLPMasterSignatories[0].outerHTML+`
                                    <div id="myModal" class="modal">
                                       <!-- Modal content -->
                                       <div class="modal-content" style="position:relative !important;">
                                         <span class="close" style="background-image:none !important;">x</span>
                                         <p id="resultContent"></p>
                                         <div style=" text-align: center; margin: 0 auto; width: 100%;">
                                            <img src="images/loading_page1.gif" id="loading_img" alt="" style="display: none;"/></div>
                                       </div>
                                   </div>
                                </div>`;
            } else {
                boardData += `<div  class="col-4 signatories_result" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                                <h2> BOARD OF DIRECTORS</h2>
                                <div class="no_data">No data found</div>
                            </div>`;
            }
            boardData += `<script type="text/javascript" >
                                     // Get the modal
                                    var modal = document.getElementById('myModal');

                                    // Get the <span> element that closes the modal
                                    var span = document.getElementsByClassName("close")[0];
                                    
                                     $("#aShowDirectorMasterdata[href='#']").attr('href', 'javascript:;');
                                    function showDirectorMasterData(din=''){
                                        if(din != ''){
                                            $('#resultContent').html('');
                                            modal.style.display = "block";
                                            $("#loading_img").show(); 
                                            $.ajax({
                                                url: 'ajaxDataFetch.php',
                                                type: 'POST',
                                                data: { din: din},
                                                timeout: 30000, // in milliseconds
                                                success: function(data) { 
                                                    $("#loading_img").hide(); 
                                                    $('#resultContent').html(data);
                                                    return false;
                                                }
                                            });
                                        }else{
                                            return false;
                                        }
                                    }

                                    // When the user clicks on <span> (x), close the modal
                                    span.onclick = function() {
                                        modal.style.display = "none";
                                    }

                                    // When the user clicks anywhere outside of the modal, close it
                                    window.onclick = function(event) {
                                        if (event.target == modal) {
                                            modal.style.display = "none";
                                        }
                                    }
                                <\/script>`;
            $( '#signatories_result' ).removeClass( 'empty-container' );
            $('#signatories_result').html(boardData);
        } else {
            var boardData = `<div  class="col-4 signatories_result" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
                                <h2> BOARD OF DIRECTORS</h2>
                                <div class="no_data">No data found</div>
                            </div>`;
            $( '#signatories_result' ).addClass( 'empty-container' );
            $('#signatories_result').html(boardData);
        }
        // BOARD OF DIRECTORS ENDS
    }
    $( '#lookup-box' ).fadeOut();
    $( '.maskscreenMCA' ).fadeOut();
}
var clickflagfunding = 0;
$(document).on( 'click','#funding', function() {
    if(clickflagfunding == 0){
        var transaction_status = {/literal}{$CompanyProfile.Permissions1}{literal};
         
         var formData = new Array();

        formData.push({ name: 'cin', value: cin },{ name: 'trans_status', value: transaction_status });
        
        $.ajax({
            type: 'POST',
            url: 'ajax_pecfs.php',
            data: formData,
            success: function(data) {
                clickflagfunding = 1;
                var dataResp = $.parseJSON(data);
                if( dataResp.count == 0 ) {
                    $('#funding-ajax').addClass( 'empty-container' );   
                } else {
                    $('#funding-ajax').removeClass( 'empty-container' );
                }
                 $('#funding-ajax').html(dataResp.html);
                 $('#funding-ajax').show();
            }
        });
    }
});
// T-949 Start Changes here and top inline styles.
$(document).on( 'click','.close', function() {
    $('.modal').hide();
});
// End Changes
$(document).on( 'click','.headertb', function() {

     var formData = new Array();

    formData.push({ name: 'cin', value: cin },{ name: 'orderby', value: this.id },{ name: 'order', value: $(this).data('order') });
    
    $.ajax({
        type: 'POST',
        url: 'ajax_pecfs.php',
        data: formData,
        success: function(data) {
            
             $('#funding-ajax').html($.parseJSON(data));
        }
    });

});



$(document).on( 'click','.subMenu', function() {

    var row = $(this).attr('data-row');
    if(row == 'profit-loss') {
        $( '.cagrlabel' ).show();
    } else {
        $( '.cagrlabel' ).hide();
    }
    
    $( '.cagrvalue .radio' ).addClass('checked');$('#balancesheet_parent [for=new_temp] .radio').addClass('checked');  $('#ratio_parent [for=new_temp] .radio').addClass('checked'); 
    if(row != 'profit-loss' && row != 'balancesheet' && row != 'cashflow' && row != 'ratio') {
       $(".cfs_menu ul li").removeClass('current');
        $(this).addClass('current');
        $('#activeSubmenu').val(row);
        tabMenu(row);
    }
    $('#activeSubmenu').val(row);
    
});

var clickflagfilings = 0;
$(document).on( 'click','#filingsMenu', function() {
    if(clickflagfilings == 0){
        $('#pgLoading').show();
        var cname = '{/literal}{$CompanyProfile.FCompanyName}{literal}';
         
         var cid = '{/literal}{$Company_Id}{literal}';
         var formData = new Array();

        formData.push({ name: 'cin', value: cin },{ name: 'cname', value: cname },{ name: 'cid', value: cid });
        
        $.ajax({
            type: 'POST',
            url: 'ajax_filings.php',
            data: formData,
            success: function(data) {
                clickflagfilings = 1;
                var dataResp = $.parseJSON(data);
                if( dataResp.count == 0 ) {
                    $('#filings').addClass( 'empty-container' );   
                } else {
                    $('#filings').removeClass( 'empty-container' );
                }
                $('#pgLoading').hide();
                 $('#filings').html(dataResp.html);
                 $('#filings').show();
            }
        });
    } else {

    }
});
var clickflagcompanyProfile = 0;
$(document).on( 'click','#companyProfileMenu', function() {
    if(clickflagcompanyProfile == 0){
        $('#pgLoading').show();
        var cid = '{/literal}{$Company_Id}{literal}';
        $.get("ajax_companyProfile.php", {cid: ""+cid+""}, function(data){
            clickflagcompanyProfile = 1;
            $('#companyProfile').html(data);
            $('#pgLoading').hide();
        });
    }
});

var clickflagprofitloss = 1;
function plresult(vcid1){
$(".tab_menu_parent").hide();
    $("#profit_loss_parent").show();
  if(clickflagprofitloss == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajaxmilliCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagprofitloss=1;
            $('#profit_loss_parent').html(data);
            
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#profit_loss_parent .cfs_menu ul li").removeClass('current');
                       var row = 'profit-loss';
                       $('#profit_loss_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    } else {
        $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#profit_loss_parent .cfs_menu ul li").removeClass('current');
                       var row = 'profit-loss';
                       $('#profit_loss_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
    }
}
var clickflagbalancesheet = 0;
function balancesheetresult(vcid1){
    $(".tab_menu_parent").hide();
    $("#balancesheet_parent").show();
  if(clickflagbalancesheet == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajax_balancesheet.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagbalancesheet=1;
            $('#balancesheet_parent').html(data);
           
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#balancesheet_parent .cfs_menu ul li").removeClass('current');
                       var row = 'balancesheet';
                       $('#balancesheet_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    } else {
        $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#balancesheet_parent .cfs_menu ul li").removeClass('current');
                       var row = 'balancesheet';
                       $('#balancesheet_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
    }
}
var clickflagcashflow = 0;
function cfresult(vcid1){
    $(".tab_menu_parent").hide();
            $("#cashflow_parent").show();
   if(clickflagcashflow == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajax_cashflow.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagcashflow=1;
            $('#cashflow_parent').html(data);
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#cashflow_parent .cfs_menu ul li").removeClass('current');
                       var row = 'cashflow';
                       $('#cashflow_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    } else {
        $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#cashflow_parent .cfs_menu ul li").removeClass('current');
                       var row = 'cashflow';
                       $('#cashflow_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
    }
}
var clickflagratio = 0;
function ratioresult(vcid1){
    $(".tab_menu_parent").hide();
    $("#ratio_parent").show();

   if(clickflagratio == 0){
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajax_ratio.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
         clickflagratio=1;
            $('#ratio_parent').html(data);
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#ratio_parent .cfs_menu ul li").removeClass('current');
                       var row = 'ratio';
                       $('#ratio_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
    } else {
        $('.displaycmp').hide();
                        $('#stMsg').hide();
                       $("#ratio_parent .cfs_menu ul li").removeClass('current');
                       var row = 'ratio';
                       $('#ratio_parent .cfs_menu ul li[data-row = '+row+']').addClass('current');
                        tabMenu(row);
                        resetfoundation();
    }
}

function resulttypestandalone(vcid1){
  
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajaxstandalone.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
            $('#result').html(data);
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                        $(".cfs_menu ul li").removeClass('current');
                       var row = $('#activeSubmenu').val();

                       $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        $('.primary .subMenu').removeClass('current');
                        $('.primary .subMenu.standalone').addClass('current');
                         tabMenu(row);
                        resetfoundation();
           
        });
}

function resulttypeconsolidate(vcid1){
  
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    var inputString= $('#ccur').val();
    $.get("ajaxconsolidated.php", {queryString: ""+inputString+"",vcid:""+vcid1+"",rconv:""+ccur1+""}, function(data){
            $('#result').html(data);
                        $('#pgLoading').hide();
            $('.displaycmp').hide();
                        $('#stMsg').hide();
                        $(".cfs_menu ul li").removeClass('current');
                       var row = $('#activeSubmenu').val();
                       $('.cfs_menu ul li[data-row = '+row+']').addClass('current');
                        $('.primary .subMenu').removeClass('current');
                        $('.primary .subMenu.consolidated').addClass('current');
                        tabMenu(row);
                        resetfoundation();
           
        });
}




$(document).on('click','.details_link',function(){

    window.open('//www.ventureintelligence.com/dealsnew/dealdetails.php?value='+$(this).data("row")+'&cfs=1', '_blank');
});
$(document).on( 'click','#deals_data', function() {

    jQuery('#maskscreen').fadeIn(1000);
    jQuery('#popup-box-deals').fadeIn();   
    return false;
    
});
$('#cancelfnbtn').click(function(){ 
                     
            jQuery('#popup-box-deals').fadeOut();   
            jQuery('#maskscreen').fadeOut(1000);
            return false;
        });
        
         $('#mailfnbtn').click(function(e){ 
            e.preventDefault();

                $.ajax({
                    url: 'ajaxsendmail.php',
                     type: "POST",
                    data: { to : $("#toaddress_fc").val(), subject : $("#subject_fc").val(), message : $("#message_fc").val() , userMail : $("#useremail_fc").val() , toventure : 1 },
                    success: function(data){
                            if(data=="1"){
                                 alert("Mail Sent Successfully");
                                jQuery('#popup-box-deals').fadeOut();   
                                jQuery('#maskscreen').fadeOut(1000);

                        }else{
                            jQuery('#popup-box-deals').fadeOut();   
                            jQuery('#maskscreen').fadeOut(1000);
                            alert("Try Again");
                        }
                    },
                    error:function(){
                        jQuery('#preloading').fadeOut();
                        alert("There was some problem sending mail...");
                    }

                });

            return false;
        });
$( '#cancelfybtn' ).click( function() {
    jQuery('#popup-box-FY-data').fadeOut();   
    jQuery('#maskscreen').fadeOut(1000);
    return false;
});
$('#mailfybtn').click(function(e){ 
    e.preventDefault();

        $.ajax({
            url: 'ajaxsendfymail.php',
             type: "POST",
            data: { to : $("#popup-box-FY-data #toaddress_fc").val(), subject : $("#popup-box-FY-data #subject_fc").val(), message : $("#popup-box-FY-data #message_fc").val() , userMail : $("#popup-box-FY-data #useremail_fc").val() , toventure : 1 },
            success: function(data){
                    if(data=="1"){
                        alert("Mail Sent Successfully");
                        jQuery('#popup-box-FY-data').fadeOut();   
                        jQuery('#maskscreen').fadeOut(1000);

                }else{
                    jQuery('#popup-box-FY-data').fadeOut();   
                    jQuery('#maskscreen').fadeOut(1000);
                    alert("Try Again");
                }
            },
            error:function(){
                jQuery('#preloading').fadeOut();
                alert("There was some problem sending mail...");
            }

        });

    return false;
});
function bsDataUpdateReq() {
    jQuery('#maskscreen').fadeIn(1000);
    jQuery( jQuery( '#popup-box-FY-data form .entry' )[1] ).find('p').text( 'To add Balance Sheet data' );
    jQuery( '#popup-box-FY-data form .entry #subject_fc' ).val( 'To add Balance Sheet data' );
    jQuery('#popup-box-FY-data').fadeIn();
}
function plDataUpdateReq() {
    jQuery('#maskscreen').fadeIn(1000);
    jQuery( jQuery( '#popup-box-FY-data form .entry' )[1] ).find('p').text( 'To add P&L data' );
    jQuery( '#popup-box-FY-data form .entry #subject_fc' ).val( 'To add P&L data' );
    jQuery('#popup-box-FY-data').fadeIn();
}
function genDownloadExcel( excel_type = '', format = '', companyID = '' ) {
    //window.open('https://support.wwf.org.uk', '_blank');
    javascript:window.open('fydownexcel.php?excel_type='+excel_type+'&format='+format+'&companyID='+companyID, '_blank');
}
</script>
            {/literal}
