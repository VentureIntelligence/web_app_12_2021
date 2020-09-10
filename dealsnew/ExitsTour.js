/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */


var lockClasses=[".investment-form",".exit-form",".vertical-form",".profile-view-left",".dealtype",".acc_container",".slide",'.dealinfo','.acquirerInfo','.moreInfo','.title-links','.result-title','.search-area','.show-by-list','.directroyList','.holder','.one','#directorymenu',".key-search","#sltindustry",".result-select",".tour-lock",".left-box"];

var EXITSdemotour=0;

var tour = {
  id: 'hello-hopscotch',
  steps: [
    //////////////////EXITS TOUR/////////////////////////////////
    
    { //1
      target: 'exits_ma_tour',
      placement: 'bottom',
      title: 'Included Databases',
      yOffset: -5,
      width: 500,
      content: 'Exits are classified as either via M&A (including Strategic Sales, Secondary Sales to other PE/VC Investors and Buybacks) OR via Public Market Sales (including IPOs and sales via the public stock market).',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'For the purpose of the tour, leave the "PE Exits via M&A" option selected.');
         warmsg = 'For the purpose of the tour, leave the "PE Exits via M&A" option selected.';
         
                  
      }       
    },
    { //2
      target: 'exitswitch',
      placement: 'bottom',
      title: 'VC Exits',
      content: 'VC Exits are a subset of PE Exits. To view VC exits exclusively, you just have to select the VC from the dropdown.',
      xOffset: -5,
      width: 450,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls([],'For the purpose of the tour, leave the "PE Exits via M&A" option selected');
         warmsg = 'For the purpose of the tour, leave the "PE Exits via M&A" option selected';
        
                  
      }       
    },
    { //3
      target: 'openRefine',
      title: 'Refine Search Options',
      content: 'Please click on the "Refine Search Arrow"',
      placement: 'right',
      showNextButton : false,
      showPrevButton : false,
      yOffset : -11,
      xOffset:0,
      width: 500,
      zindex:1000,
      fixedElement: true,
       onShow:function(){            
         lockControls(["#openRefine"],'To proceed, Click on the refine search arrow');
          warmsg = 'To proceed, Click on the refine search arrow';                   
          $(".hopscotch-bubble").addClass("tourboxshake");
                  var tourshake =  setInterval(function(){  
                       if(hopscotch.getCurrStepNum()==2) { $(".tourboxshake").effect( "shake",{times:1}, 2000 ); }
                   },5000); 
                   
      }
//      ,
//      onPrev:function(){
//          hopscotch.prevStep();         
//      }
    },
    { //4
      target: 'tdfilter',
      title: 'Filter List of Deals',
      content: 'You can Filter the transactions using various parameters',
      placement: 'right',
      showPrevButton : false,
      showNextButton : false,
      yOffset :400,
      xOffset:-2,
      width: 500,
      zindex:1000,
      fixedElement: true, 
       onShow:function(){
        
         lockControls(['#sltindustry'],'To proceed, Select the industry as IT & ITES');
          warmsg = 'To proceed, Select the industry as IT & ITES';
          
          
         }
    
    },
    { //5
      target: 'sltindustry',
      title: 'By Industry',
      content: 'For the purpose of the tour, please select IT & ITES as the Industry',
      placement: 'right',
     // showNextButton : false,
      yOffset: -16,
      width: 500,
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls(["#sltindustry"],'To proceed, Select the industry as IT & ITES');
          warmsg = 'To proceed, Select the industry as IT & ITES';
         
      }   
      
    },
    { //6
      target: 'month1',
      placement: 'bottom',
      title: 'Period of Transaction',
      content: 'Please select the dates as Apr 2013 - Jun 2013',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#datesubmit"],'For the purpose of the tour, select the indicated date range.');
         warmsg = 'For the purpose of the tour, select the indicated date range.';
         
      }
    },    
    { //7
      target: 'tour_result_title',
      title: 'Aggregate Statistics',
      content: 'This shows the no of transactions and the amount realized by the investors during the period (and based on the search filters applied)',
      placement: 'right',
     // showNextButton : false,
      yOffset: -25,
      xOffset: -12,
      width: 500,
      zindex:1000,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls(["#sltindustry"],'To follow the guide, Click next');
          warmsg = 'To follow the guide, Click next';
          
      }   
      
    },
    { //8
      target: 'vcexits1161888502',
      placement: 'bottom',
      title: 'Transaction Details',
      content: 'Click on "Redbus" ',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tour1161888502","#vcexits1161888502"],'For the purpose of the tour, please click on "Redbus" ');
         warmsg = 'For the purpose of the tour, please click on "Redbus"';
         
      }
    },
    { //9
      target: 'profilemain',
      placement: 'top',
      title: 'Deal Information',
      content: 'Here, you can view the Deal Amount (Realized by Investors), Deal Type, Exit Status (ie, whether Complete or Partial), Transaction Date and the Buyer.',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         
      }
    },
    { //10
      target: 'moredetails',
      placement: 'top',
      title: 'Deal Information',
      content: 'Information on the deal.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
        
      }
    },
    { //11
      target: 'tour_returnmultiple',
      placement: 'top',
      title: 'Return Information',
      content: 'You can view the Returns made by the PE/VC investors here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
        
      }
    },
    { //12
      target: 'clickhere',
      placement: 'top',
      title: 'Offline Support',
      content: 'Subscribers can request additional information (that they do not find in the database immediately) including supporting docs, etc.',
      zindex:1000,
      onShow:function(){
         lockControls(["#clickhere"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
        
      }
    },
    { //13
      target: 'icon-grid-view',
      placement: 'top',
      title: 'Back to List View',
      content: 'You can return to the filtered deals list (from the detail view of a deal) by using this tab.',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#icon-grid-view"],'To proceed, click on "List View" tab.');
         warmsg = 'To proceed, click on "List View" tab.';
         $('#tourlistview').val('startstep14');
         
      }
    },
    { //14
      target: 'exits_public_tour',
      placement: 'bottom',
      title: 'Exits via Public Markets',
      yOffset: -5,
      content: 'This database captures exits made by investors via IPOs and sales via the public stock market.',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#exits_public_tour"],'To proceed, click on Public Market Sales.');
         warmsg = 'To proceed, click on Public Market Sales.';
         
                  
      }       
    },
    { //15
      target: 'month1',
      placement: 'bottom',
      title: 'Period of Transaction',
      content: 'Please select the dates as Jul 2014 - Sep 2014',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#datesubmit"],'To proceed, click on the indicated date range.');
         warmsg = 'To proceed, click on the indicated date range.';
        
      }
    },
    { //16
      target: 'vcexits1080927690',
      placement: 'bottom',
      title: 'Sample Transaction',
      content: 'Please click on Repco Home Finance ',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      //scrollDuration : -5000,
      onShow:function(){
         lockControls(["#tour1080927690","#vcexits1080927690"],'To proceed, please click on Repco Home Finance ');
         warmsg = 'To proceed, please click on Repco Home Finance';
         
      }
    },
    { //17
      target: 'moredetails',
      placement: 'top',
      title: 'IPOs',
      content: 'Those companies in which the investor had invested at least 6 months before the IPO are indicated (using "IPO") in the more details section.',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#clickhere"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         
      }
    },    
    { //18
      target: 'searchallfield',
      placement: 'bottom',
      title: 'Search',
      content: 'Use the search box to search this database (ie, Public Market Sales). For instance, please type Justdial',
      zindex:1000,
      xOffset: 'center',
      arrowOffset: 'center',
      showNextButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#searchallfield","#fliter_stage"],'For the purpose of the tour, please type Justdial ');
         warmsg = 'For the purpose of the tour, please type Justdial ';
         
      }
    },
    { //19
      target: 'toursec',
      placement: 'bottom',
      title: 'Other Tours',
      content: 'This completes the Current Tour. Select another tour from the options as desired.',
      zindex:1000,
      yOffset: -7,
      xOffset: 20,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click Done.');
         warmsg = 'To follow the guide, Click Done.';
         
                  
      }         
    }
    
    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,
  onClose:function(){
    
    EXITSdemotour=0;    
    unlockControls();
    
    $("#EXITSdemotour").val('0');
    $.ajax({
           type: "POST",
           url: 'ajaxWebTour.php',
           data: { meth: "unset"},
           success: function(data){

           },
           error:function(){
               alert("Network Error");
           }

   });
   
   
     $("#restartTourBtn").val("Stop Tour");     
     $("#stopEXITSTourBtn").hide(); 
     $("#tourlibtn").show();
  },
  onEnd:function(){
    
     EXITSdemotour=0;    
    unlockControls();
    
    $("#EXITSdemotour").val('0');
    $.ajax({
           type: "POST",
           url: 'ajaxWebTour.php',
           data: { meth: "unset"},
           success: function(data){
           },
           error:function(){
               alert("Network Error");
           }

   });
   $("#stopEXITSTourBtn").hide(); 
   $("#tourlibtn").show(); 
   
  
  },
//  onStart:function(){
//    demotour=1;
//    $("#demoTour").val('1');
//    $.ajax({
//           type: "POST",
//           url: 'ajaxTourSession.php',
//           data: { meth: "set"},
//           success: function(data){
//
//           },
//           error:function(){
//               console.log("Network Error");
//           }
//
//   });
//   
//      
//    $("#startTourBtn,#restartTourBtn").val("Stop PE Investments"); 
//  },
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



  
  
   $("#autostartstopbtn").click(function() {
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
               window.location.href="/dealsnew/index.php";
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
    
    $("#autostartstopbtn").val("PE Investments");
    
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
               window.location.href="/dealsnew/index.php";
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