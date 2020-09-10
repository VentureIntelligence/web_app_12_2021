/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */


var lockClasses=[".investment-form",".exit-form",".vertical-form",".profile-view-left",".dealtype",".acc_container",".slide",'.dealinfo','.acquirerInfo','.moreInfo','.title-links','.result-title','.search-area','.show-by-list','.directroyList','.holder','.one','#directorymenu',".key-search","#sltindustry",".result-select",".tour-lock",".left-box"];

var Directorydemotour=0;

var tour = {
  id: 'hello-hopscotch',
  steps: [
    //////////////////Directory TOUR/////////////////////////////////
    
    { //1
      target: 'tour_directory',
      placement: 'bottom',
      title: 'Included Directories',
      yOffset: -5,
      width: 500,
      content: 'You can find contact information and other profile details for PE/VC Firms, PE/VC Backed Companies, Transaction / Investment Banking Advisory Firms and Legal Advisory Firms here. ',
      zindex:1000,
      showPrevButton : false,
      fixedElement: true, 
      onShow:function(){
         lockControls([],'For the purpose of the tour, leave the Directory Tab selected');
         warmsg = 'For the purpose of the tour, leave the Directory Tab selected';
        
         
                  
      }       
    },
    { //2
      target: 'peinvestor_tour',
      placement: 'bottom',
      title: 'Investor Profiles',
      content: 'The default view is that of investor profiles. To view profiles other than investors, you can change the selection in this area.',
      xOffset: -5,
      width: 450,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls([],'For the purpose of the tour, leave the "PE Investor" option selected.');
         warmsg = 'For the purpose of the tour, leave the "PE Investor" option selected.';
        
                  
      }       
    },
    { //3
      target: 'showbylist_tour',
      title: 'Alphabetical Listing',
      content: 'The profiles are listed alphabeticallly for easy navigation',
      placement: 'top',
      zindex:11,
       onShow:function(){            
         lockControls([],'For the purpose of the tour, click Next.');
          warmsg = 'For the purpose of the tour, click Next.';                  
                         
        },
        onNext:function(){
            $("#autocomplete").focus();
        }
    },
    { //4
      target: 'autocomplete',
      title: 'Search for Profiles',
      content: 'If you are searching for a specific firm, you can use the search box. For example, to search for Sequoia Capital, you can type "Seq.." and select Sequoia Capital India from the auto prompt.',
      placement: 'top',
      showNextButton : false,
      width:550,
      zindex:11,
       onShow:function(){        
         lockControls(['#autocomplete'],'For the purpose of the tour, please search and select Sequoia Capital India');
          warmsg = 'For the purpose of the tour, please search and select Sequoia Capital India';
          
         }
    
    },
    { //5
      target: 'lframe',
      title: 'LinkedIn Integration',
      content: "Apart from basic contact details to a relevant top executive made available in the directory, you can also discover and connect to this and other executives via the firm's LinkedIn profile intergrated into the directory.",
      placement: 'top',
      width: 500,
      zindex:1000,
      showPrevButton : false,
       onShow:function(){
          lockControls([],'To follow the guide, Click next');
          warmsg = 'To follow the guide, Click next';
         
      }   
      
    },
    { //6
      target: 'icon-grid-view',
      placement: 'top',
      title: 'Back to List View',
      content: 'You can return to the directory list view (from the detail view of a profile) by using this tab.',
      zindex:1000,
      width: 350,
      showNextButton : false,
      onShow:function(){
         lockControls(["#icon-grid-view"],'Please click on List View');
         warmsg = 'Please click on List View';
      }
    },    
    { //7
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
                   
      }
      
    }, 
    { //8
      target: 'tdfilter',
      title: 'Filter List of Deals',
      content: 'You can filter the directory using various transaction parameters',
      placement: 'right',
      showPrevButton : false,
      showNextButton : false,
      yOffset :400,
      xOffset:-2,
      width: 500,
      zindex:1000,
      fixedElement: true, 
       onShow:function(){        
         lockControls([],'Please select Agri-business as the industry');
          warmsg = 'Please select Agri-business as the industry';
         }
    
    },
    { //9
      target: 'sltindustry',
      title: 'By Industry',
      content: 'You can narrow down the directory to a specific list of firms using the deal based filters here. For instance, select Agri-business as the industry',
      placement: 'right',
     // showNextButton : false,
      yOffset: -16,
      width: 500,
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls(["#sltindustry"],'Please select Agri-business as the industry');
          warmsg = 'Please select Agri-business as the industry';
         
      }   
      
    }, 
    { //10
      target: 'tour_result_title',
      title: 'Aggregate Data',
      content: 'This area shows the number of firms based on the filters used',
      placement: 'right',
     // showNextButton : false,
      yOffset: -20,
      xOffset: -12,
      width: 500,
      zindex:1000,
      showPrevButton : false,
      fixedElement: true,      
       onShow:function(){
          lockControls([],'To follow the guide, Click next');
          warmsg = 'To follow the guide, Click next';
          
      }   
      
    },
    { //11
      target: 'investmentswitch',
      placement: 'bottom',
      title: 'VC Directories',
      content: 'Select the VC option if you are looking for VC / Angel / Incubation / Social or Impact Investors and related profiles.',
      xOffset: -5,
      width: 450,
      zindex:1000,
      fixedElement: true, 
      onShow:function(){
         lockControls([],'For the purpose of the tour, leave the "PE Investments" option selected for now.');
         warmsg = 'For the purpose of the tour, leave the "PE Investments" option selected for now.';
        
                  
      }       
    },
    { //12
      target: 'PEmaexits_tour',
      placement: 'bottom',
      title: 'Selecting Relevant Database',
      content: 'The directory is structured to correspond with the transaction databases. For instance, If you want to search for Legal Advisors to Exit deals, just select the Exits database option here and...  ',
      zindex:1000,
      showNextButton : false,
      fixedElement: true,
      onShow:function(){
         lockControls(["#PEmaexits_tour"],'For the purpose of the tour, select the "Exits via M&A" option ');
         warmsg = 'For the purpose of the tour, select the "Exits via M&A" option';
         
      }
    },
    { //13
      target: 'PElegalad_tour',
      placement: 'bottom',
      title: 'Selecting Relevant Database',
      content: 'Select Legal Advisor here.  ',
      zindex:1000,
      showNextButton : false,
      showPrevButton : false,
      fixedElement: true,
      onShow:function(){
         lockControls(["#PElegalad_tour"],'For the purpose of the tour, select the "Legal Advisor" option ');
         warmsg = 'For the purpose of the tour, select the "Legal Advisor" option';
         
      }
    },    
    { //14
      target: 'toursec',
      placement: 'bottom',
      title: 'Other Tours',
      content: 'This completes the Current Tour. Select another tour from the options as desired.',
      zindex:1000,
      yOffset: -7,
      xOffset:-160,
      arrowOffset:230,
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
    
    Directorydemotour=0;    
    unlockControls();
    
    $("#Directorydemotour").val('0');
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
     $("#stopDirectoryTourBtn").hide(); 
     $("#tourlibtn").show();
  },
  onEnd:function(){
    
     Directorydemotour=0;    
    unlockControls();
    
    $("#Directorydemotour").val('0');
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
   $("#stopDirectoryTourBtn").hide(); 
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
        Directorydemotour=1;
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
        Directorydemotour=0;
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