/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */

var tourdealid="1146969717";
var tourDirAdvisor="9877040";
var tourIndustry ="Education";
var tourDeal="IIJT";
var lockClasses=[".investment-form",".vertical-form",".dealtype",".acc_container",".profile-view-left",".slide",'.dealinfo','.acquirerInfo','.moreInfo','.title-links','.result-title','.search-area','.show-by-list','.directroyList','.holder','.one','#directorymenu','.key-search'];
var demotour=0;
var tour = {
  id: 'hello-hopscotch',
  steps: [
    {  //0
      target: 'definition_step',
      title: 'Definition',
      content: 'Click Here for definitions of the M&A deal types.',
      placement: 'bottom',
      xOffset: -25,
      zindex:1000,
      onShow:function(){
         lockControls(["#definition_step"],'To follow the guide, please click on "Definitions"');
      }
    },
    { //1
      target: jQuery('.dealtype')[2],
      title: 'Deal Types',
      content: 'You can view either all types or uncheck 1 or 2 types.',
      placement: 'bottom',
      width: 500,
      zindex:1000,
      onShow:function(){
        lockControls([".dealtype,.icheckbox,#checksearch"],'To follow the guide, Please leave domestic deals checked for the purpose of the tour');
      },
      onNext: function(){
        var isDomestic=0;
        $('[name="dealtype[]"]:checked').each(function(){
        if($(this).val()=='3')
            isDomestic=1;
        });
        if(isDomestic==1){
                hopscotch.showStep(2);
        }else{
            hopscotch.showStep(1);
            showErrorDialog("Please leave domestic deals checked for the purpose of the tour");
            
        }
      }
    },
    { //2
      target: 'checksearch',
      placement: 'bottom',
      title: 'Search',
      content: 'Click on "search" to submit the query.',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls([".dealtype","#checksearch,.icheckbox"],'To follow the guide, please leave all deal types checked');
      }
    },
    { //3
      target: 'show-total-amount',
      placement: 'bottom',
      title: 'Aggregate Results',
      content: 'This area displays aggregate data based on existing filters (Date & Deal Types).',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#show-total-amount"],'To follow the guide, Click next');
      }
    },
    { //4
      target: 'month1',
      placement: 'bottom',
      title: 'Deal Period',
      content: 'You can change the default dates here. Please change the date range to Jan  2010 - Dec 2010 to view deals from that period.',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#dealsubmit"],'To follow the guide, please select From date as Jan 2010 and To Date as Dec 2010');
      }
    },
    { //5
      target: 'openRefine',
      placement: 'right',
      title: 'Expand Filter',
      content: 'Click Here to view Filter Options',
      zindex:1000,
      yOffset : -10,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#openRefine"],'To follow the guide, please click here');
      }
    },
    { //6
      target: 'industry',
      placement: 'right',
      title: 'Select Industry',
      content: 'Click on the industry tab and select "Education" to proceed further',
      zindex:1000,
      yOffset : -20,
      showNextButton : false,
      onShow:function(){
         lockControls(["#industry"],'To follow the guide, please select '+tourIndustry+'');
      }
    },
    { //7
      target: 'dealid'+tourdealid,
      placement: 'bottom',
      title: 'Deal',
      content: 'Click '+tourDeal+' to view the transaction details',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#dealid"+tourdealid],'To follow the guide, please select '+tourDeal+'');
      }
    },
    {//8
      target: 'dealinfo',
      placement: 'top',
      title: 'Deal Information',
      content: 'You can view Deal Amount,Stake,Deal Type,Company Valuation here.',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#dealinfo"],'To follow the guide, Click next');
      }
    },
    { //9
      target: 'companyInfo',
      placement: 'top',
      title: 'Company Information',
      content: 'You can view company details here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
      }
    },
    { //10
      target: 'acquirerInfo',
      placement: 'top',
      title: 'Acquirer Information',
      content: 'You can view Acquirer details here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
      }
    },
    { //11
      target: 'requestLink',
      placement: 'top',
      title: 'Offline Support',
      content: 'You can avail offline support by sending your queries right from within the database',
      zindex:1000,
      onShow:function(){
         lockControls(['#requestLink'],'To follow the guide, please select "Click Here"');
         $('#requestLink').closest('td').unbind("mousedown");
         $("#requestLink").click(function(){
            hopscotch.showStep(12);
         });
       
      }
    },
    { //12
      target: 'senddeal',
      placement: 'left',
      title: 'Send this Deal',
      content: 'Share deals with your colleagues',
      zindex:1000,
      yOffset: -22,
      onShow:function(){
         lockControls(["#senddeal"],'To follow the guide, Click next');
      }
    },
    { //13
      target: 'listviewtab',
      placement: 'top',
      title: 'List View',
      content: 'Click List view to check the other deals',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         $(window).scrollTop(0,0);
         lockControls(["#listviewtab"],'To follow the guide, please select "List View"');
         
      }
    },
    { //14
      target: 'expshowdeals',
      placement: 'left',
      yOffset : -20,
      title: 'Export to Excel Feature',
      content: 'Click on "Export" to an excel to slice and dice according to your requirement',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#expshowdeals,#expsampledeals"],'To follow the guide, please select "Export"');
      }
    },
    { //15
      target: 'directorymenu',
      placement: 'bottom',
      title: 'Directory Section',
      content: 'Click Directory icon to view profiles',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#directorymenu"],'To follow the guide, please click "directory"');
      }
    },
    { //16
      target: 'transaction-adv',
      placement: 'bottom',
      title: 'Show By',
      content: 'You can select from the options here; For the demo, select Transaction Advisor',
      zindex:1000,
      showPrevButton : false,
      showNextButton : false,
      onShow:function(){
         lockControls(["#transaction-adv"],'To follow the guide, please click "Transaction Advisor"');
      }
    },
    { //17
      target: 'directorySearch',
      placement: 'top',
      title: 'Show By',
      content: 'You can either search for an advisor or browse by alphabetical listing. Type Avendus in the search box and select it from the prompt',
      zindex:1000,
      width:440,
      showPrevButton : false,
      showNextButton : false,
      onShow:function(){
         lockControls(["#directorySearch"],'To follow the guide, type & select Avendus in the search box');
      }
    },
    { //18
      target: 'advisortoTargets',
      placement: 'top',
      title: 'Deals',
      content: 'List of transactions is displayed here',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#advisortoTargets"],'To follow the guide, Click next');
      }
    },
    { //19
      target: 'lframe',
      placement: 'top',
      title: 'LinkedIn Profile',
      content: 'View Professionals via the LinkedIn Integration Feature & Begin Networking Rightaway!',
      zindex:1000,
      width:440,
      onShow:function(){
         lockControls(["#lframe"],'To follow the guide, Click next');
      },
              
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
               window.location.href="/ma/index.php";
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
               window.location.href="/ma/index.php";
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
        $(equalClassname+" input:radio,"+equalClassname+" input:checkbox,"+equalClassname).unbind("ifClicked");
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