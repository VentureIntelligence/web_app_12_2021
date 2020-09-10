/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */

var tourdealid="1755951779";
var tourDirAdvisor="9877040";
var tourIndustry ="Real Estate";
var tourDeal="Assetz Property Group";
var tourAdvisorId="13";
var tourAdvisor="Avendus";
//var lockClasses=[".definition_step_lock", ".vertical-form",".dealtype",".acc_container",".profile-view-left",".slide",'.dealinfo','.acquirerInfo','.moreInfo','.title-links','.result-title','.search-area','.show-by-list','.directroyList','.holder','.one','#directorymenu','.key-search','#sltindustry'];

var lockClasses=[".investment-form",".vertical-form",".profile-view-left",".dealtype",".acc_container",".slide",'.dealinfo','.acquirerInfo','.moreInfo','.title-links','.result-title','.search-area','.show-by-list','.directroyList','.holder','.one','#directorymenu',".key-search","#sltindustry",".result-select",".tour-lock",".left-box"];

var demotour=0;

var tour = {
  id: 'hello-hopscotch',
  steps: [
    {  //0
      target: 'definition_step',
      title: 'Included Databases',
      content: 'The primary focus of this database is tracking activity of Private Equity Funds in Real Estate (PE-RE) - including investments, IPOs of PE-backed Real Estate Cos and Exits via M&A. The database also records publicly announced M&A transactions in the Real Estate sector (under "Other M&A").',
      placement: 'bottom',
      xOffset: -5,
      width: 450,
      zindex:1000,
      onShow:function(){
         lockControls(["#definition_step"],'To proceed, leave the "Private Equity Investments" option selected ');
         warmsg = 'To proceed, leave the "Private Equity Investments" option selected';
      }
    
    },
    { //1
      target: 'openRefine',
      title: 'Refine Search Options',
      content: 'Please click on the "Refine Search Arrow"',
      placement: 'right',
      showNextButton : false,
      yOffset : -5,
      width: 500,
      zindex:1000,
       onShow:function(){
         lockControls(["#openRefine"],'To proceed, Click on the refine search arrow');
          warmsg = 'To proceed, Click on the refine search arrow';
      }
      
      
    
    },
    { //2
      target: 'sltindustry',
      title: 'Industries',
      content: 'The database, apart from core Real Estate industry, also provides access to deals in related industries like Hotels & Resorts, Engg & Construction, Warehousing (under Shipping & Logisitcs) and Retail (Shopping Malls). Please select Real Estate as the industry.',
      placement: 'right',
     // showNextButton : false,
      yOffset: -16,
      width: 500,
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
       onShow:function(){
          lockControls(["#sltindustry"],'To proceed, Select the industry as '+tourIndustry+'');
          warmsg = 'To proceed, Select the industry as '+tourIndustry+'';
      }
      
      
    
    }
    ,
    { //3
      target: 'month1',
      placement: 'bottom',
      title: 'Period of Transaction',
      content: 'Please select the dates as Jan 2014- March 2014.',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#datesubmit"],'To proceed, click on the incated date range. ');
         warmsg = 'To proceed, click on the incated date range.';
      }
    }
    ,
    
    { //4
      target: 'dealid'+tourdealid,
      placement: 'bottom',
      title: 'Transaction Details',
      content: 'Click '+tourDeal+' to view the transaction details',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#dealid"+tourdealid],'To proceed, please click on the row with "'+tourDeal+'"');
         warmsg = 'To proceed, please click on the row with "'+tourDeal+'"';
      }
    }
    ,
    { //5
      target: 'profilemain',
      placement: 'top',
      title: 'Deal Information',
      content: 'You can view investment amount, date and other deal related information (as available) here',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
      }
    }
    ,
    { //6
      target: 'investmentinfo',
      placement: 'top',
      title: 'Investment Information',
      content: 'You can view details like investor name, investor type and transaction advisors here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
      }
    }
    ,
    { //7
      target: 'companyinfo',
      placement: 'top',
      title: 'Company Information',
      content: 'You can view details about the developer company here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
      }
    }
    ,
    { //8
      target: 'moreinfo',
      placement: 'top',
      title: 'More Information',
      content: 'You can view more details about the transaction here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
      }
    }
    ,
    { //9
      target: 'senddeal',
      placement: 'left',
      title: 'Share this deal',
      content: 'Share the deal with your colleagues',
      yOffset: -22,
      zindex:1000,
      onShow:function(){
         lockControls(["#senddeal","#toaddress","#mailbtn","#cancelbtn"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
      }
    },
    { //10
      target: 'expshowdeals',
      placement: 'left',
      title: 'Export',
      content: 'Subscribers can export the deals to a spreadsheet',
      yOffset: -22,
      zindex:1000,
      onShow:function(){
         lockControls(["#expshowdeals"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
      }
    }
    ,
    { //11
      target: 'reinvestor337',
      placement: 'right',
      title: 'Investor Profile',
      content: 'Click to view investor profile',
      yOffset: -20,
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tourreinvestor337","#reinvestor337"],'To proceed please click on the investor name');
         warmsg = 'To proceed please click on the investor name';
      }
    }
    ,
    { //12
      target: 'definition_step3',
      placement: 'bottom',
      title: 'Exit Deals',
      content: 'Click to view Exit tansactions',      
      showNextButton : false,
      showPrevButton : false,
      zindex:1000,
      onShow:function(){
         lockControls([],'To proceed, click on the PE Exits via M&A option');
         warmsg = 'To proceed, click on the PE Exits via M&A option';
         
      }
    }
    ,
    { //13
      target: 'month1',
      placement: 'bottom',
      title: 'Period of Transaction',
      content: 'Please select the dates as Jan 2012 - March 2012',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#datesubmit"],'To proceed, click on the indicated date.');
         warmsg = 'To proceed, click on the indicated date.';
      }
    }
    ,
    { //14
      target: 'show-total-amount',
      placement: 'left',
      title: 'Aggregate Deal Data',
      yOffset: -6,
      content: 'This area displays aggregate deal data based on the existing query filters',
      zindex:1000,
      yOffset: -18,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click next.');
         warmsg = 'To follow the guide, Click next.';
         
      }
    }
    ,
    { //15
      target: 'remanda1415174490',
      placement: 'bottom',
      title: 'Exit Transaction',
      content: 'Click to view transaction details',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tour_remanda1415174490","#remanda1415174490"],'To proceed, click on the deal');
          warmsg = 'To proceed, click on the deal';
      }
    }
    ,
    { //16
      target: 'refundtour',
      placement: 'bottom',
      title: 'Fund Raising',
      content: 'Click to see the Fund Raising data',
      zindex:1000,
      yOffset : -5,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#refundtour"],'To proceed, click on the Funds tab');
          warmsg = 'To proceed, click on the Funds tab';
      }
    }
    ,
    { //17
      target: 'fundtour292',
      placement: 'bottom',
      title: 'HDFC Property',
      content: 'To proceed, click on the fund name.',
      zindex:1000,
      yOffset : -5,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#fundtour292","#tdfundtour292"],'To proceed, click on the fund name');
          warmsg = 'To proceed, click on the fund name';
      }
    }
    , 
     { //18
      target: 'redirectorytour',
      placement: 'bottom',
      title: 'Locating Contacts',
      content: 'You can search for specific investors, companies and advisory firms in this section - via search or alphabetical listing.',
      zindex:1000,
      yOffset : -5,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#redirectorytour"],'To proceed, click on Directory');
          warmsg = 'To proceed, click on Directory';
      }
    }
    ,
    { //19
      target: 'autocomplete',
      placement: 'top',
      title: 'Locating Contacts',
      content: 'For this demo, lets search for the investor, Xander. Please type Xander and select the firm  name from the list.. ',
      zindex:1000,
      yOffset : -5,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#autocomplete"],'To follow the guide, Please type Xander');
         warmsg = 'To follow the guide, Please type Xander';
      }
    }
    ,
    { //20
      target: 'tabsholder2',
      placement: 'top',
      title: 'Transactions',
      content: 'You can view the list of investments and exits ',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
          warmsg = 'To follow the guide, Click next';
      }
    } ,
    { //21
      target: 'lframe',
      placement: 'top',
      title: 'LinkedIn integration',
      content: 'View professionals at the firm via the LinkedIn integration feature & begin Networking Rightaway ',
      zindex:1000,
      xOffset: 'center',
      arrowOffset: 'center',
      onShow:function(){
         lockControls(["#lframe"],'To follow the guide, Click Done');
         warmsg = 'To follow the guide, Click Done';
      }
    }
    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,
  onClose:function(){
    
    demotour=0;
    unlockControls();
    $("#demoTour").val('0');
    $.ajax({
           type: "POST",
           url: 'ajaxTourSession.php',
           data: { meth: "unset"},
           success: function(data){

           },
           error:function(){
               alert("Network Error");
           }

   });
     $("#startTourBtn,#restartTourBtn").val("Start Tour");
  },
  onEnd:function(){
    
    demotour=0;
    unlockControls();
    $("#demoTour").val('0');
    $.ajax({
           type: "POST",
           url: 'ajaxTourSession.php',
           data: { meth: "unset"},
           success: function(data){

           },
           error:function(){
               alert("Network Error");
           }

   });
     $("#startTourBtn,#restartTourBtn").val("Start Tour");
  },
  onStart:function(){
      
    demotour=1;
    $("#demoTour").val('1');
    $.ajax({
           type: "POST",
           url: 'ajaxTourSession.php',
           data: { meth: "set"},
           success: function(data){

           },
           error:function(){
               console.log("Network Error");
           }

   });
   $("#startTourBtn,#restartTourBtn").val("Stop Tour");
  },
},

/* ========== */
/* TOUR SETUP */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},

init = function() {
 //  alert("adsasdasd");
  var startBtnId = 'startTourBtn',
      calloutId = 'startTourCallout',
      mgr = hopscotch.getCalloutManager(),
      state = hopscotch.getState();

  if (state && state.indexOf('hello-hopscotch:') === 0) {
        mgr.removeAllCallouts();
    // Already started the tour at some point!

  }
  else {
      
    // Looking at the page for the first(?) time.
//    setTimeout(function() {
//        
//      mgr.createCallout({
//        id: calloutId,
//        target: startBtnId,
//        placement: 'right',
//        title: 'Take a tour',
//        content: 'Start by taking an simple guided tour !',
//        yOffset: -25,
//        arrowOffset: 20,
//        width: 240,
//        zindex:1000
//      });
//    }, 100);
  }

//  addClickListener(document.getElementById(startBtnId), function() {
//    if (!hopscotch.isActive) {
//      mgr.removeAllCallouts();
//        hopscotch.endTour();
//        hopscotch.startTour(tour);
//        demotour=1;
//        $("#demoTour").val(1);
//    }else{
//    }
//    
//  });
};

  $("#startTourBtn").click(function() {
    var mgr = hopscotch.getCalloutManager();
    if (!hopscotch.isActive) {
        mgr.removeAllCallouts();
        hopscotch.endTour();
        //hopscotch.startTour(tour); 
        demotour=1;
        $("#demoTour").val(1);
        $.ajax({
           type: "POST",
           url: 'ajaxTourSession.php',
           data: { meth: "set"},
           success: function(data){
               window.location.href="/re/reindex.php";
           },
           error:function(){
               alert("Network Error");
           }

        });
       
    }else{
        mgr.removeAllCallouts();
        hopscotch.endTour();
        demotour=0;
        $("#demoTour").val(0);
    }
    
  });
  
 $("#restartTourBtn").click(function() {
    var mgr = hopscotch.getCalloutManager();
    if (!hopscotch.isActive) {
        mgr.removeAllCallouts();
        hopscotch.endTour();
        $.ajax({
           type: "POST",
           url: 'ajaxTourSession.php',
           data: { meth: "set"},
           success: function(data){
               window.location.href="/dev/re/reindex.php";
           },
           error:function(){
               alert("Network Error");
           }

        });
    }else{
        mgr.removeAllCallouts();
        hopscotch.endTour();
        demotour=0;
        $("#demoTour").val(0);
    }
    
  });

//$(document).ready(function(){
//   $(".icheckbox_flat-red").each(function(){
//           $(this).css("pointer-events","none");
//        });
//});

function lockControls(unlockclass,errorMsg)
{
    
    $(".icheckbox_flat-red,.iradio_flat-red").each(function(){
           $(this).css("pointer-events","none");
    });
    
    $(lockClasses).each(function(index,classname){
        
      $(".icheckbox").each(function(){
            $(this).off('mousedown').on('mousedown', function(event){
                showErrorDialog(errorMsg);
                event.preventDefault();
                 return false;
            });
        });
        
        $(".iradio").each(function(){
            $(this).off('mousedown').on('mousedown', function(event){
                showErrorDialog(errorMsg);
                event.preventDefault();
                 return false;
            });
        });
        
        $(".header,#dashboardmenu,#dealsmenu,#directorymenu,.classic-link,.user-avt").each(function(){
            $(this).off('mousedown').on('mousedown', function(event){
                showErrorDialog(errorMsg);
                event.preventDefault();
                 return false;
            });
        });
        
//       $(document).on('mousedown', '.icheckbox_flat-red', function(event){
//             showErrorDialog(errorMsg);
//                event.preventDefault();
//                return false;
//       });

//        $(".icheckbox_flat-red").off('mousedown').on('mousedown', function(event){
//                showErrorDialog(errorMsg);
//                event.preventDefault();
//                return false;
//        });
        
        
//      $(".").off('mousedown').on('mousedown', function(event){
//            $(this).css("pointer-events","none");
//            event.stopPropagation();
//            event.preventDefault();
//            showErrorDialog(errorMsg);
//            return false;
//      });
//      

//        $(classname+" input:radio,"+classname+" input:checkbox").each(function(){
//           $(this).css("pointer-events","none");
//        });
        
//      $(classname+" input:radio,"+classname+" input:checkbox").off('ifClicked').on('ifClicked', function(event){
//        //alert(event.type + ' callback');
//        if(true){
//         if( !$(this).parent().hasClass("checked") ){
//        $(this).trigger('ifClicked');
//         }
//        }
//      });
      
      
       $(classname+" select").each(function(){
            $(this).off('mousedown').on('mousedown', function(event){
                showErrorDialog(errorMsg);
                event.preventDefault();
                 return false;
            });
        });
        $(classname+" input:button,"+classname+" input:text,"+classname+" input:submit").each(function(){
            $(this).off('mousedown').on('mousedown', function(event){
                showErrorDialog(errorMsg);
                event.preventDefault();
                 return false;
            });
        });
        $(classname+" a,"+classname+" td" ).each(function(){
            $(this).off('mousedown').on('mousedown', function(event){
                showErrorDialog(errorMsg);
                event.preventDefault();
                 return false;
            });
        }); 
//        $(classname).each(function(){
//            $(this).off('mousedown').on('mousedown', function(event){
//                showErrorDialog(errorMsg);
//                event.preventDefault();
//                 return false;
//            });
//        });
    });   
     $(unlockclass).each(function(index,equalClassname){
         
        $(equalClassname).unbind("mousedown");
        $(equalClassname+" select").unbind("mousedown");
        $(equalClassname+" a").unbind("mousedown");
        
         $(equalClassname+" a").each(function(){
            $(this).unbind("mousedown");
        }); 
       
        $(equalClassname+" input:button,"+equalClassname+" input:text,"+equalClassname+" input:submit").unbind("mousedown");
        $(equalClassname+" input:radio,"+equalClassname+" input:checkbox,"+equalClassname).unbind("ifClicked");
        if(equalClassname=="#dealid"+tourdealid)
            {
                $(equalClassname).closest('td').unbind("mousedown");
            }
     });
     
}

function unlockControls()
{
    $(".icheckbox_flat-red,.iradio_flat-red").each(function(){
           $(this).css("pointer-events","auto");
    });
    
    $(".icheckbox").each(function(){
            $(this).unbind("mousedown");
    });
        
    $(".iradio").each(function(){
            $(this).unbind("mousedown");
    });
     $(".header,#dashboardmenu,#dealsmenu,#directorymenu,.classic-link,.user-avt").each(function(){
            $(this).unbind("mousedown");
    });
   $(lockClasses).each(function(index,equalClassname){    
        $(equalClassname).unbind("mousedown");
        $(equalClassname+" select").unbind("mousedown");
        $(equalClassname+" a").unbind("mousedown");
        $(equalClassname+" td").unbind("mousedown");
        $(equalClassname+" input:button,"+equalClassname+" input:text,"+equalClassname+" input:submit").unbind("mousedown");
        $(equalClassname+" input:radio,"+equalClassname+" input:checkbox,"+equalClassname).unbind("click");
     });
}

function showErrorDialog(errorMsg)
{
    $("#alertSpan").html(errorMsg);
    $( "#dialog-confirm" ).dialog({
      resizable: false,
      height:"auto",
      overflow: "hidden",
      modal: true,
      width:450,
      dialogClass: "tourDialog",
      buttons: {
        Ok: function() {
            $( this ).dialog( "close" );
        },
        "Close Tour": function() {
          hopscotch.endTour(); 
          $( this ).dialog( "close" );
          unlockControls();
          $("#demoTour").val('0');
        }
      },close: function( event, ui ) {
        
      }
    });
    return false;
}