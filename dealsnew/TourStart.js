var EXITSdemotour=0;
var Directorydemotour=0;

$(document).ready(function() {
    // PE Tour 
$("#startTourBtn,#stopTourBtn").click(function() {    
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

 });

// VC Tour  
$("#startVCTourBtn,#stopVCTourBtn").click(function() {
       $.ajax({
          type: "POST",
          url: 'ajaxVCTourSession.php',
          data: { meth: "set"},
          success: function(data){
              window.location.href="/dealsnew/index.php?value=1";
          },
          error:function(){
              alert("Network Error");
          }

       }); 

 });
 
 
  
// Exits Tour  

// other page
$("#startEXITSTourBtn2,#stopVCTourBtn2").click(function() {
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
  
  
  
// Directory


 $("#startDirectoryTourBtn").click(function() {
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

//OTHER PAGE
 
 $("#startDirectoryTourBtn2").click(function() {
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

$("#stopDirectoryTourBtn").click(function() {
    
    hopscotch.endTour();
    Directorydemotour=0;
    $("#stopDirectoryTourBtn").hide();        
    $("#tourlibtn").show();
            
            
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
            

});



  
  
  
// tour button

  $("#tourlibtn").click(function(){
      $("#tourlist").show();
  });
  
  
});


$(document).mouseup(function (e)
{
    $("#tourlist").hide();
});
  
  
  
  
  
