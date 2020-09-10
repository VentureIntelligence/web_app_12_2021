/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */


var lockClasses=[".investment-form",".exit-form",".vertical-form",".profile-view-left",".dealtype",".acc_container",".slide",'.dealinfo','.acquirerInfo','.moreInfo','.title-links','.result-title','.search-area','.show-by-list','.directroyList','.holder','.one','#directorymenu',".key-search","#sltindustry",".result-select",".tour-lock",".left-box"];

var demotour=0;
var vcdemotour=0;

var tour = {
  id: 'hello-hopscotch',
  steps: [
  ///////////////// PE Tour /////////////////
  
    {  //0
      target: 'definition_step',
      title: 'Included Databases',
      content: 'The primary focus of this database is tracking Investments and Exits of Private Equity Funds across various industries (excluding Real Estate). It includes Sub-Databases for Venture Capital; Social VC / Impact Investments; Angel Investments; Incubation, Cleantech, Infrastructure, etc.',
      placement: 'bottom',
      xOffset: -5,
      width: 450,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#definition_step"],'To proceed, leave the "Private Equity Investments" option selected');
         warmsg = 'To proceed, leave the "Private Equity Investments" option selected';
      }
    
    },
    { //1
      target: 'month1',
      placement: 'bottom',
      title: 'Period of Transaction',
      content: 'Please select the dates as Jan 2014 - Mar 2014',
      zindex:1000,
      showNextButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#datesubmit"],'To proceed, click on the indicated date range.');
         warmsg = 'To proceed, click on the indicated date range.';
      }
    },
    { //2
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
      }
    },
    { //3
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
        
         lockControls([],'To proceed, select Shipping & Logistics from the Industries list');
          warmsg = 'To proceed, select Shipping & Logistics from the Industries list';
          
         }
    
    },
    { //4
      target: 'sltindustry',
      title: 'By Industry',
      content: 'For the purpose of the tour, please select Shipping & Logistics as the Industry',
      placement: 'right',
     // showNextButton : false,
      yOffset: -16,
      width: 500,
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls(["#sltindustry"],'To proceed, select Shipping & Logistics from the Industries list');
          warmsg = 'To proceed, select Shipping & Logistics from the Industries list';
      }   
      
    },    
    { //5
      target: 'show-total-deal',
      title: 'Aggregate Data',
      content: 'This area shows the aggregate deal data based on the query parameters.',
      placement: 'left',
     // showNextButton : false,
      yOffset: -18,
      width: 500,
      zindex:1000,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls(["#sltindustry"],'To follow the guide, Click next');
          warmsg = 'To follow the guide, Click next';
          $('.hopscotch-bubble-number').html('6<small style="font-weight: normal;">a</small>');
      }   
      
    },
    { //6
      target: 'dealid1446889345',
      placement: 'bottom',
      title: 'Transaction Details',
      content: 'Click on "Samson Maritime" to view the deal in more detail.',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tour1446889345","#dealid1446889345"],'To proceed, please click on "Samson Maritime"');
         warmsg = 'To proceed, please click on "Samson Maritime"';
         $('.hopscotch-bubble-number').html('6<small style="font-weight: normal;">b</small>');
      }
    },
    { //7
      target: 'icon-grid-view',
      placement: 'top',
      title: 'Return to List of Deals',
      content: 'You can switch from the Detail View to the list of deals by clicking here',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls(["#dealid1446889345"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('6<small style="font-weight: normal;">c</small>');
      }
    },        
    { //8
      target: 'profilemain',
      placement: 'top',
      title: 'Deal Information',
      content: 'You can view basic details like transaction date, investment amount and Stage of Development of the Target Company here.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('7');
      }
    },
    { //9
      target: 'investmentinfo',
      placement: 'top',
      title: 'Investment Information',
      content: 'You can view details on the investment including list of investors, advisors to the transaction, % stake acquired by the Investor and Valuation Information (as available) here.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('8');
      }
    },
    { //10
      target: 'companyinfo',
      placement: 'top',
      title: 'Company Information',
      content: 'You can view more details about the target company here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('9');
      }
    },
    { //11
      target: 'moreinfo',
      placement: 'top',
      title: 'More Information',
      content: 'You can view more details about the transaction here - including structuring of the deal, board seats, etc.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('10');
      }
    },
    { //12
      target: 'clickhere',
      placement: 'top',
      title: 'Offline support',
      content: 'As a subscriber, you can request additional information, supporting documents. etc relating to a transaction.',
      zindex:1000,
      onShow:function(){
         lockControls(["#clickhere"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('11');
      }
    },
    { //13
      target: 'senddeal',
      placement: 'left',
      title: 'Share this deal',
      content: 'You can forward deal / profile links to be viewed by your colleagues ',
      yOffset: -22,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#senddeal","#toaddress","#mailbtn","#cancelbtn"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('12');
      }
    },
    { //14
      target: 'expshowdeals',
      placement: 'left',
      title: 'Export',
      content: 'Subscribers can export details being viewed on screen to a spreadsheet',
      yOffset: -22,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#expshowdeals"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('13');
      }
    },
    { //15
      target: 'investor21',
      placement: 'right',
      title: 'Investor Profile',
      content: 'Click to view investor profile',
      yOffset: -20,
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tourinvestor","#investor21"],'To proceed please click on the investor name');
         warmsg = 'To proceed please click on the investor name';
         $('.hopscotch-bubble-number').html('14');
         $('body').animate({scrollTop:200},1000); 
      }
    },    
    { //16
      target: 'lframe',
      placement: 'top',
      title: 'LinkedIn Profile',
      content: 'View who you know in this firm via the LinkedIn integration feature ',
      zindex:1000,
      xOffset: 'center',
      arrowOffset: 'center',
      showPrevButton : false,
      onShow:function(){
           
         lockControls(["#lframe"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('15');
      }
    },    
    { //17
      target: 'searchallfield',
      placement: 'bottom',
      title: 'Search',
      content: 'At any point, you can search using keywords - example for sectors, companies, investors, etc. - across the database. For example, type Offshore',
      zindex:1000,
      xOffset: 'center',
      arrowOffset: 'center',
      showNextButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#searchallfield","#fliter_stage"],'To follow the guide, Please type "Offshore" ');
         warmsg = 'To follow the guide, Please type "Offshore" ';
         $('.hopscotch-bubble-number').html('16');
      }
    },
    { //18
      target: 'toursec',
      placement: 'bottom',
      title: 'Other Tours',
      xOffset: 25,
      content: 'This Completes the current tour. Please select another tour from the options.',
      zindex:1000,
      yOffset: -15,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click Done.');
         warmsg = 'To follow the guide, Click Done.';
         $('.hopscotch-bubble-number').html('17');
         $('.hopscotch-next').html('Done');
                  
      },
     onNext:function(){
            return false; 
     }         
    }
    
    ///////////////// VC Tour /////////////////
          ,
    { //19
      target: 'investmentswitch',
      placement: 'bottom',
      title: 'Selecting Venture Capital Database',
      content: 'To view the subset of Venture Capital transactions along with related databases on Social VC / Impact Investments, Angel Investments, Incubation, etc, Please leave the "VC" option selected.',
      xOffset: -5,
      width: 450,
      zindex:1000,
      fixedElement: true, 
      showPrevButton : false,
      onShow:function(){
         lockControls(["#investmentswitch"],'To proceed, leave the "Venture Capital" option selected');
         warmsg = 'To proceed, leave the "Venture Capital" option selected';
         $('.hopscotch-bubble-number').html('1');
         
      }
    },
    { //20
      target: 'vc_definition_step',
      placement: 'bottom',
      title: 'Related Databases',
      content: 'You can access the VC related databases of Angel Investments, Social VC / Impact Investments, Incubation, etc, from under this menu.',
      xOffset: -5,
      width: 450,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls([],'To proceed, retain the "Venture Capital" option');
         warmsg = 'To proceed, retain the "Venture Capital" option';
         $('.hopscotch-bubble-number').html('2');
         
      }
    },
    { //21
      target: 'month1',
      placement: 'bottom',
      title: 'Period of Transaction',
      content: 'Please select the dates as Jan 2011- Mar 2011',
      zindex:1000,
      showNextButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#month1","#year1","#month2","#year2","#datesubmit"],'To proceed, click on the indicated date range.');
         warmsg = 'To proceed, click on the indicated date range.';
         $('.hopscotch-bubble-number').html('3');
      }
    },
    { //22
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
          $('.hopscotch-bubble-number').html('4');
      }
    },
    { //23
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
        
         lockControls([],'To proceed, Select the industry as IT & ITES');
          warmsg = 'To proceed, Select the industry as IT & ITES';
          $('.hopscotch-bubble-number').html('5');
          
         }
    
    },
    { //24
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
          $('.hopscotch-bubble-number').html('6');
      }   
      
    },    
    { //25
      target: 'show-total-deal',
      title: 'Aggregate Data',
      content: 'This area shows the aggregate deal data based on the query parameters.',
      placement: 'left',
     // showNextButton : false,
      yOffset: -18,
      width: 500,
      zindex:1000,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls(["#sltindustry"],'To follow the guide, Click next');
          warmsg = 'To follow the guide, Click next';
          $('.hopscotch-bubble-number').html('7<small style="font-weight: normal;">a</small>');
      }   
      
    },
    { //26
      target: 'dealid306639826',
      placement: 'bottom',
      title: 'Transaction Details',
      content: 'Click on "Snapdeal.com" ',
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tour306639826","#dealid306639826"],'To proceed, please click on "Snapdeal.com" transaction ');
         warmsg = 'To proceed, please click on "Snapdeal.com" transaction ';
         $('.hopscotch-bubble-number').html('7<small style="font-weight: normal;">b</small>');
      }
    },
    { //27
      target: 'icon-grid-view',
      placement: 'top',
      title: 'Return to List of Deals',
      content: 'You can switch from the Detail View to the list of deals by clicking here',
      zindex:1000,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To proceed with the tour, please remain on the Detail View');
         warmsg = 'To proceed with the tour, please remain on the Detail View';
         $('.hopscotch-bubble-number').html('7<small style="font-weight: normal;">c</small>');
      }
    },        
    { //28
      target: 'profilemain',
      placement: 'top',
      title: 'Deal Information',
      content: 'You can view basic details like transaction date, investment amount and Stage of Development of the Target Company here.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('8');
      }
    },
    { //29
      target: 'investmentinfo',
      placement: 'top',
      title: 'Investment Information',
      content: 'You can view details on the investment including list of investors, advisors to the transaction, % stake acquired by the investors and Valuation Information (as available) here.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('9');
      }
    },
    { //30
      target: 'companyinfo',
      placement: 'top',
      title: 'Company Information',
      content: 'You can view more details about the target company here',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('10');
      }
    },
    { //31
      target: 'moreinfo',
      placement: 'top',
      title: 'More Information',
      content: 'You can view more details about the transaction here - including structuring of the deal, board seats, etc.',
      zindex:1000,
      onShow:function(){
         lockControls([],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('11');
      }
    },
    { //32
      target: 'clickhere',
      placement: 'top',
      title: 'Offline support',
      content: 'As a subscriber, you can request additional information, supporting documents. etc relating to a transaction.',
      zindex:1000,
      onShow:function(){
         lockControls(["#clickhere"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('12');
      }
    },
    { //33
      target: 'senddeal',
      placement: 'left',
      title: 'Share this deal',
      content: 'You can forward deal / profile links to be viewed by your colleagues',
      yOffset: -22,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#senddeal","#toaddress","#mailbtn","#cancelbtn"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('13');
      }
    },
    { //34
      target: 'expshowdeals',
      placement: 'left',
      title: 'Export',
      content: 'Subscribers can export details being viewed on screen to a spreadsheet',
      yOffset: -22,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#expshowdeals"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('14');
      }
    },
    { //35
      target: 'investor118',
      placement: 'right',
      title: 'Investor Profile',
      content: 'Click to view investor profile',
      yOffset: -20,
      zindex:1000,
      showNextButton : false,
      onShow:function(){
         lockControls(["#tourinvestor","#investor118"],'To proceed please click on the investor name');
         warmsg = 'To proceed please click on the investor name';
         $('.hopscotch-bubble-number').html('15');
         $("#investor70").attr('href','javascript::')
         $("#investor70").attr('onclick', 'showErrorDialog(warmsg);');
         $('body').animate({scrollTop:200},1000); 
      }
    },    
    { //36
      target: 'lframe',
      placement: 'top',
      title: 'LinkedIn Profile',
      content: 'Connect with fellow professionals',
      zindex:1000,
      xOffset: 'center',
      arrowOffset: 'center',
      showPrevButton : false,
      onShow:function(){
           
         lockControls(["#lframe"],'To follow the guide, Click next');
         warmsg = 'To follow the guide, Click next';
         $('.hopscotch-bubble-number').html('16');
      }
    },    
    { //37
      target: 'searchallfield',
      placement: 'bottom',
      title: 'Search',
      content: 'At any point, you can search using keywords - example for sectors, companies, investors, etc. - across the database. For example, type E-Commerce',
      zindex:1000,
      xOffset: 'center',
      arrowOffset: 'center',
      showNextButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls(["#searchallfield","#fliter_stage"],'Please search for "E-Commerce" for the purpose of the tour ');
         warmsg = 'Please search for "E-Commerce" for the purpose of the tour';
         $('.hopscotch-bubble-number').html('17');
      }
    },
    { //38
      target: 'toursec',
      placement: 'bottom',
      title: 'Other Tours',
      xOffset: 25,
      content: 'This Completes the current tour. Please select another tour from the options.',
      zindex:1000,
      yOffset: -15,
      showPrevButton : false,
      onShow:function(){
         lockControls([],'To follow the guide, Click Done.');
         warmsg = 'To follow the guide, Click Done.';
         $('.hopscotch-bubble-number').html('18');
                  
      }       
    }        
    
  ],
  showPrevButton: true,
  scrollTopMargin: 100,
  onClose:function(){
    
    demotour=0;
    vcdemotour=0;
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
   $.ajax({
           type: "POST",
           url: 'ajaxVCTourSession.php',
           data: { meth: "unset"},
           success: function(data){

           },
           error:function(){
               alert("Network Error");
           }

   });
   
     $("#startTourBtn,#restartTourBtn").val("Stop Tour");
     $("#stopTourBtn").hide(); 
     $("#stopVCTourBtn").hide(); 
     $("#tourlibtn").show();
  },
  onEnd:function(){
    
    demotour=0;
    vcdemotour=0;
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
   $.ajax({
           type: "POST",
           url: 'ajaxVCTourSession.php',
           data: { meth: "unset"},
           success: function(data){

           },
           error:function(){
               alert("Network Error");
           }

   });
   
     $("#startTourBtn,#restartTourBtn").val("PE Investments");
     $("#stopTourBtn").hide(); 
     $("#stopVCTourBtn").hide(); 
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

  $("#startTourBtn,#stopTourBtn").click(function() {
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
        $("#stopTourBtn").hide();        
        $("#tourlibtn").show();
        //$("#tourlist").show();
    }
    
  });
  
  
  
    $("#startVCTourBtn,#stopVCTourBtn").click(function() {
    var mgr = hopscotch.getCalloutManager();
    if (!hopscotch.isActive) {
        mgr.removeAllCallouts();
        hopscotch.endTour();
        //hopscotch.startTour(tour); 
        vcdemotour=1;
        $("#demoTour").val(1);
        $.ajax({
           type: "POST",
           url: 'ajaxVCTourSession.php',
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
        vcdemotour=0;
        $("#demoTour").val(0);
        $("#stopVCTourBtn").hide();        
        $("#tourlibtn").show();
        //$("#tourlist").show();
        
        $("#investor70").attr('href','investordetails.php?value=70/1/0/306639826')
    }
    
  });
  
  
      $("#startEXITSTourBtn,#stopEXITSTourBtn").click(function() {
    var mgr = hopscotch.getCalloutManager();
    if (!hopscotch.isActive) {
        mgr.removeAllCallouts();
        hopscotch.endTour();
        //hopscotch.startTour(tour); 
        EXITSdemotour=1;
        $("#demoTour").val(1);
        $.ajax({
           type: "POST",
           url: 'ajaxWebTour.php',
           data: { meth: "set", toursection:"Exits"},           
           success: function(data){
               window.location.href="/dealsnew/mandaindex.php?value=0-0";
           },
           error:function(){
               alert("Network Error");
           }

        });
       
    }else{
        mgr.removeAllCallouts();
        hopscotch.endTour();
        EXITSdemotour=0;
        $("#demoTour").val(0);
        $("#stopEXITSTourBtn").hide();        
        $("#tourlibtn").show();
        //$("#tourlist").show();
        
    }
    
  });
  
  
   $("#startDirectoryTourBtn,#startDirectoryTourBtn2").click(function() {
       $.ajax({
          type: "POST",
          url: 'ajaxWebTour.php',
         data: { meth: "set", toursection:"Directory"},
          success: function(data){
              window.location.href="/dealsnew/pedirview.php";
          },
          error:function(){
              alert("Network Error");
          }
  
       }); 

 });  
  
  
  
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