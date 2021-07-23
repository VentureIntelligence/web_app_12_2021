<?php include_once("../globalconfig.php");
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('checklogin.php');
?>
<SCRIPT  type="text/javascript">
    $( "#searchallfield" ).keyup(function() {
            $("#searchallfieldHide").val('');     
            $("#sltindustry").val('');  
            $('#stage').val('');
            $("#dealtype").val('--'); 
            $("#targetType").val('--'); 
            $("#exitstatus").val('--'); 
            $('#investorauto_multiple').val();
            $('#acquirerauto').val();
            $('#companyauto').val();
            $('#sectorauto').val();
            $('#advisorsearch_legal').val();
            $('#advisorsearch_trans').val();
    });
function checkForAggregates()
{
	//alert("---");
	document.peinvestment.hiddenbutton.value='Aggregate';
	document.peinvestment.submit();
}

function indchange(list)
{
	//alert(list);
	//alert("---");
	//alert(list.options[list.selectedIndex].value);
	if(list.options[list.selectedIndex].value==15)
 	{
		document.reinvestment.stage.selectedIndex=0;
		document.reinvestment.stage.disabled=false;
                
	}
	else if(list.options[list.selectedIndex].value=="--" )
	{
		document.reinvestment.stage.selectedIndex=0;
		document.reinvestment.stage.disabled=false;
	}
	else if (list.options[list.selectedIndex].value!=15 )
	{
		document.reinvestment.stage.selectedIndex=0;
		document.reinvestment.stage.disabled=true;
	}
}


</SCRIPT>

<script>
  $(function() {
    
  
    
    
    
    ////////////// investor search start //////////////////////
    
      $( "#investorauto_multiple" ).keyup(function() {
             
             var investorauto = $("#investorauto_multiple").val();
              
             if(investorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxMultiAutosuggest.php?getinvestor",
                     data: {
                        search: investorauto,
                        getReInvestorsByValue:'3'
                     },
                     success: function(data) {
                         
                          var innerdata=$.parseJSON(data);
                         var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){
                          
                           multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="inv_selectall"> SELECT ALL</label><br>';
                            }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='investor_multi[]' value='"+item['investorid']+"' class='investor_slt' data-title='"+item['investorname']+"' >"+item['investorname']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#investorauto_load").fadeIn();
                            $("#investorauto_load").html(multiselect);
                            disableFileds();
                            }
                            else{
                                $("#investorauto_load").fadeOut();
                                $("#investorauto_load").html('');
                            }
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#investorauto_load").fadeOut();
                            enableFileds();
        }
        
    });    
    
      $("#inv_selectall").live("click", function() {
      
            clear_companysearch();
            clear_sectorsearch();
            clear_acquirersearch();
            clear_Legal_Trans();
            
            $('.investor_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltinvestor_multi ='';
                var sltcount=0;
                $('.investor_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_inves_id = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltinvestor_multi+=slt_inves_id; }
                             else { sltholder+=","+holder;   sltinvestor_multi+=","+slt_inves_id; }

                          sltcount++;
                          
                           //sltuserscout++;
                       }

                  });
                  $("#investorauto_multiple").attr('readonly','readonly'); 
                  $("#investorauto_multiple").val(sltholder);
                  $("#keywordsearch_multiple").val(sltinvestor_multi); 
                  $("#inv_clearall").fadeIn();
                    disableFileds();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#inv_clearall").fadeOut(); 
                   $("#investorauto_multiple").removeAttr('readonly');
                   $("#investorauto_multiple").val('');
                    enableFileds();
             }
//                $("#investorauto").attr('readonly','readonly');  
//                $("#investorauto").val(sltholder); 
//                $("#investorauto_load").show();
        });    
    
      $('.investor_slt').live("click", function() {  //on click 
                      
                      clear_companysearch();
                      clear_sectorsearch();
                      clear_acquirersearch();
                      clear_Legal_Trans();
            clear_searchallfield();
                      
                      var sltholder='';
                      var sltinvestor_multi ='';
                      var sltcount=0;
                      $('.investor_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_inves_id = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltinvestor_multi+=slt_inves_id;  }
                                else { sltholder+=","+holder;   sltinvestor_multi+=","+slt_inves_id;  }
                             
                             sltcount++;
                             $("#investorauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#investorauto_multiple").attr('readonly','readonly');  
                    $("#investorauto_multiple").val(sltholder); 
                    $("#keywordsearch_multiple").val(sltinvestor_multi); 
                    disableFileds();
                    
                    
                    if(sltcount==0){  $("#inv_clearall").fadeOut(); $("#investorauto_multiple").removeAttr('readonly');   }
                    else {   $("#inv_clearall").fadeIn();  }
                        
        if($(".investor_slt").length==$(".investor_slt:checked").length){
            
            $("#inv_selectall").attr("checked","checked");
        }else{
            $("#inv_selectall").removeAttr("checked");
        }
                     
                 
             });
             
     ////////////// investor search end //////////////////////        
     
        
    
    
     ////////////// company search start //////////////////////    
    
     $( "#companyauto" ).keyup(function() {
             
             var companyauto = $("#companyauto").val();
              
             if(companyauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxMultiAutosuggest.php?getcompany",
                     data: {
                        getAllReCompanies: '2',
                        search: companyauto
                     },
                     success: function(data) {
                           var innerdata=$.parseJSON(data);
                         var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){
                          
                               multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="com_selectall"> SELECT ALL</label><br>';
                                }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='company_multi[]' value='"+item['companyid']+"' class='company_slt' data-title='"+item['companyname']+"' >"+item['companyname']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#companyauto_load").fadeIn();
                            $("#companyauto_load").html(multiselect);
                            disableFileds();
                            }
                            else{
                                $("#companyauto_load").fadeOut();
                                $("#companyauto_load").html('');
                            }
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#companyauto_load").fadeOut();
        }
        
    });
    
     $("#com_selectall").live("click", function() {
    
            clear_keywordsearch();
            clear_sectorsearch();
            clear_acquirersearch();
            clear_Legal_Trans();
            clear_searchallfield();
           
            
            $('.company_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltcompany_multi ='';
                var sltcount=0;
                $('.company_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_comp_id = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id; }
                             else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id; }

                          sltcount++;
                         
                       }

                  });
                  $("#companyauto").attr('readonly','readonly'); 
                  $("#companyauto").val(sltholder);
                  $("#companysearch").val(sltcompany_multi); 
                  $("#com_clearall").fadeIn();
                    disableFileds();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#com_clearall").fadeOut(); 
                   $("#companyauto").removeAttr('readonly');
                   $("#companyauto").val('');
                    enableFileds();
             }
        });
    
     $('.company_slt').live("click", function() {  //on click 
                      
                       clear_keywordsearch();
                       clear_sectorsearch();
                       clear_acquirersearch();
                        clear_Legal_Trans();
            clear_searchallfield();
                     
                      
                      var sltholder='';
                      var sltcompany_multi ='';
                      var sltcount=0;
                      $('.company_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_comp_id = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id;  }
                                else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id;  }
                             
                             sltcount++;
                             $("#companyauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#companyauto").attr('readonly','readonly');  
                    $("#companyauto").val(sltholder); 
                    $("#companysearch").val(sltcompany_multi); 
                    disableFileds();
                    
                    
                    if(sltcount==0){  $("#com_clearall").fadeOut(); $("#companyauto").removeAttr('readonly');   }
                    else {   $("#com_clearall").fadeIn();  }
                        
        if($(".company_slt").length==$(".company_slt:checked").length){
            
            $("#com_selectall").attr("checked","checked");
        }else{
            $("#com_selectall").removeAttr("checked");
        }
                     
                 
             });
    
    ////////////// company search end //////////////////////
    
    
    
    
      ////////////// sector search start //////////////////////
    
      $( "#sectorauto" ).keyup(function() {
             
             var sectorauto = $("#sectorauto").val();
              
             if(sectorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                      url: "ajaxMultiAutosuggest.php?getsector",
                     data: {
                        getAllReSector:'2',
                        search: sectorauto
                     },
                     success: function(data) {
                         
                          var innerdata=$.parseJSON(data);
                         var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){
                          
                         //   multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="sec_selectall"> SELECT ALL</label><br>';
                            }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='sector_multi[]' value='"+item['sectorname']+"' class='sector_slt' data-title='"+item['sectorname']+"' >"+item['sectorname']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#sectorauto_load").fadeIn();
                            $("#sectorauto_load").html(multiselect);
                            disableFileds();
                            }
                            else{
                                $("#sectorauto_load").fadeOut();
                                $("#sectorauto_load").html('');
                            }
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#sectorauto_load").fadeOut();
        }
        
    });    
    
      $("#sec_selectall").live("click", function() {
    
            clear_keywordsearch();
            clear_companysearch();
            clear_acquirersearch();
            clear_Legal_Trans();
            clear_searchallfield();
          
        
            
            $('.sector_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltsector_multi ='';
                var sltcount=0;
                $('.sector_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_sec_name = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltsector_multi+="'"+slt_sec_name+"'"; }
                             else { sltholder+=","+holder;   sltsector_multi+=", '"+slt_sec_name+"'"; }

                          sltcount++;
                         
                       }

                  });
                  $("#sectorauto").attr('readonly','readonly'); 
                  $("#sectorauto").val(sltholder);
                  $("#sectorsearch_multiple").val(sltsector_multi); 
                  $("#sec_clearall").fadeIn();
                    disableFileds();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#sec_clearall").fadeOut(); 
                   $("#sectorauto").removeAttr('readonly');
                   $("#sectorauto").val('');
                    enableFileds();
             }
        });
    
      $('.sector_slt').live("click", function() {  //on click 
         
        
         if($(".sector_slt:checked").length >  10){
            
             this.checked = false;
             alert('Please select only 10 Sectors');
             return false;
        }
                      
           clear_keywordsearch();
            clear_companysearch();
            clear_acquirersearch();
            clear_Legal_Trans();
            clear_searchallfield();
                      
                      var sltholder='';
                      var sltsector_multi ='';
                      var sltcount=0;
                      $('.sector_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_sec_name = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltsector_multi+="'"+slt_sec_name+"'";  }
                                else { sltholder+=","+holder;   sltsector_multi+=", '"+slt_sec_name+"'";  }
                             
                             sltcount++;
                             $("#sectorauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#sectorauto").attr('readonly','readonly');  
                    $("#sectorauto").val(sltholder); 
                    $("#sectorsearch_multiple").val(sltsector_multi); 
                    disableFileds();
                    
                    if(sltcount==0){  $("#sec_clearall").fadeOut(); $("#sectorauto").removeAttr('readonly');   }
                    else {   $("#sec_clearall").fadeIn();  }
                        
//        if($(".sector_slt").length==$(".sector_slt:checked").length){
//            
//            $("#sec_selectall").attr("checked","checked");
//        }else{
//            $("#sec_selectall").removeAttr("checked");
//        }
                     
                 
             });
     
    ////////////// sector search end //////////////////////

    
    
       ////////////// acquirer search start //////////////////////    
    
     $( "#acquirerauto" ).keyup(function() {
             
             var acquirerauto = $("#acquirerauto").val();
              
             if(acquirerauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxMultiAutosuggest.php?getacquirer", 
                     data: {
                        acquirer: '1',
                        search: acquirerauto
                     },
                     success: function(data) {
                           var innerdata=$.parseJSON(data);
                         var datacount = innerdata.length;   
                          
                          if(datacount>0) {
                              var multiselect='';
                              
                              if(datacount>1){
                          
                               multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="acq_selectall"> SELECT ALL</label><br>';
                                }
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='acquirer_multi[]' value='"+item['acquirerid']+"' class='acquirer_slt' data-title='"+item['acquirername']+"' >"+item['acquirername']+"</label></br>";

                            });
                            
                            multiselect+="</br></br>"; 
                            
                            $("#acquirerauto_load").fadeIn();
                            $("#acquirerauto_load").html(multiselect);
                    disableFileds();
                            }
                            else{
                                $("#acquirerauto_load").fadeOut();
                                $("#acquirerauto_load").html('');
                            }
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#acquirerauto_load").fadeOut();
                    enableFileds();
        }
        
    });
    
     $("#acq_selectall").live("click", function() {
    
            clear_keywordsearch();
            clear_sectorsearch();
            clear_companysearch();
            clear_Legal_Trans();
           
            
            $('.acquirer_slt').attr('checked',this.checked);
            if(this.checked) 
            {                              
                var holder = $(this).val();                             
                var sltholder='';
                var sltacquirer_multi ='';
                var sltcount=0;
                $('.acquirer_slt').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).data("title"); 
                          var slt_acquirer_id = $(this).val(); 

                             if(sltcount==0) { sltholder+=holder; sltacquirer_multi+=slt_acquirer_id; }
                             else { sltholder+=","+holder;   sltacquirer_multi+=","+slt_acquirer_id; }

                          sltcount++;
                         
                       }

                  });
                  $("#acquirerauto").attr('readonly','readonly'); 
                  $("#acquirerauto").val(sltholder);
                  $("#acquirersearch_multiple").val(sltacquirer_multi); 
                  $("#acq_clearall").fadeIn();
                    disableFileds();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#acq_clearall").fadeOut(); 
                   $("#acquirerauto").removeAttr('readonly');
                   $("#acquirerauto").val('');
                    enableFileds();
             }
        });
    
     $('.acquirer_slt').live("click", function() {  //on click 
                      
                       clear_keywordsearch();
                       clear_sectorsearch();
                       clear_companysearch();
                        clear_Legal_Trans();
                     
                      
                      var sltholder='';
                      var sltacquirer_multi ='';
                      var sltcount=0;
                      $('.acquirer_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_acquirer_id = $(this).val(); 
                               
                                if(sltcount==0) { sltholder+=holder; sltacquirer_multi+=slt_acquirer_id;  }
                                else { sltholder+=","+holder;   sltacquirer_multi+=","+slt_acquirer_id;  }
                             
                             sltcount++;
                             $("#acquirerauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
                    $("#acquirerauto").attr('readonly','readonly');  
                    $("#acquirerauto").val(sltholder); 
                    $("#acquirersearch_multiple").val(sltacquirer_multi); 
                    disableFileds();
                    
                    
                    if(sltcount==0){  $("#acq_clearall").fadeOut(); $("#acquirerauto").removeAttr('readonly');   }
                    else {   $("#acq_clearall").fadeIn();  }
                        
        if($(".acquirer_slt").length==$(".acquirer_slt:checked").length){
            
            $("#acq_selectall").attr("checked","checked");
        }else{
            $("#acq_selectall").removeAttr("checked");
        }
                     
                 
             });
    
    ////////////// acquirer search end //////////////////////
    
    
    
    
    
    
    
  });
  
  
  
  
  function clear_keywordsearch(){
     $("#investorauto_multiple").removeAttr('readonly');  
     val='';
     $("#investorauto_multiple, #keywordsearch_multiple").val(val); 
     $("#investorauto_load").fadeOut();
     $("#inv_clearall").fadeOut(); 
}  
  function clear_companysearch(){
     $("#companyauto").removeAttr('readonly');  
     val='';
     $("#companyauto,#companysearch").val(val); 
     $("#companyauto_load").fadeOut();
     $("#com_clearall").fadeOut(); 
} 

  function clear_sectorsearch(){
     $("#sectorauto").removeAttr('readonly');  
     val='';
     $("#sectorauto,#sectorsearch_multiple").val(val); 
     $("#sectorauto_load").fadeOut();
     $("#sec_clearall").fadeOut(); 
} 

  function clear_acquirersearch(){
       $("#acquirerauto").removeAttr('readonly');  
     val='';
     $("#acquirerauto,#acquirersearch_multiple").val(val); 
     $("#acquirerauto_load").fadeOut();
     $("#acq_clearall").fadeOut(); 
} 

  function clear_keywordsearch1(){
     $("#investorauto_multiple").removeAttr('readonly');  
     val='';
     $("#investorauto_multiple, #keywordsearch_multiple").val(val); 
     $("#investorauto_load").fadeOut();
     $("#inv_clearall").fadeOut();  
     enableFileds();
}  
  function clear_companysearch1(){
     $("#companyauto").removeAttr('readonly');  
     val='';
     $("#companyauto,#companysearch").val(val); 
     $("#companyauto_load").fadeOut();
     $("#com_clearall").fadeOut();  
     enableFileds();
} 

  function clear_sectorsearch1(){
     $("#sectorauto").removeAttr('readonly');  
     val='';
     $("#sectorauto,#sectorsearch_multiple").val(val); 
     $("#sectorauto_load").fadeOut();
     $("#sec_clearall").fadeOut();  
     enableFileds();
} 

  function clear_acquirersearch1(){
       $("#acquirerauto").removeAttr('readonly');  
     val='';
     $("#acquirerauto,#acquirersearch_multiple").val(val); 
     $("#acquirerauto_load").fadeOut();
     $("#acq_clearall").fadeOut();  
     enableFileds();
} 

function clear_Legal_Trans(){
    
    var advisorsearch_legalbox = $("#advisorsearch_legal").combobox();
	var advisorsearch_transbox = $("#advisorsearch_trans").combobox();
    
     advisorsearch_legalbox.combobox("destroy") ;
     advisorsearch_transbox.combobox("destroy") ;
     
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
}


     $(function() {
	
	var advisorsearch_legalbox = $("#advisorsearch_legal").combobox();
	var advisorsearch_transbox = $("#advisorsearch_trans").combobox();
        
      

       advisorsearch_legalbox.on( "comboboxselect", function( event, ui ) {
          clear_keywordsearch();
          clear_companysearch();
          clear_sectorsearch();
          clear_acquirersearch();
          
          
           advisorsearch_transbox.combobox("destroy") ;
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           advisorsearch_transbox.combobox() ;
     disableFileds();
          
        } );
        
        
         advisorsearch_transbox.on( "comboboxselect", function( event, ui ) {
             
          clear_keywordsearch();
          clear_companysearch();
          clear_sectorsearch();
          clear_acquirersearch();  
        
           advisorsearch_legalbox.combobox("destroy") ;          
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           advisorsearch_legalbox.combobox() ;
     disableFileds();

        } );
       
        
        $("#resetall").click(function (){
         clear_keywordsearch();
          clear_companysearch();
          clear_sectorsearch();
          clear_acquirersearch();
          clear_Legal_Trans();
          enableFileds();
        });
    
 
        
  });
  
function disableFileds(){
    $("#sltindustry").val('--');
    $("#sltindustry").prop("disabled", true); 
    $("#dealtype").val('--');
    $("#dealtype").prop("disabled", true);   
    $("#stage").val('');
    $("#stage").prop("disabled", true);
    $("#targetType").val('');
    $("#targetType").prop("disabled", true);
    $("#exitstatus").val('--');
    $("#exitstatus").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $('#sltindustry,#exitstatus,#dealtype,#targetType').attr('style', 'background-color: #dddddd !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#sltindustry").prop("disabled", false);
    $("#stage").prop("disabled", false);
    $("#dealtype").prop("disabled", false);
    $("#targetType").prop("disabled", false);
    $("#exitstatus").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $('#sltindustry,#exitstatus,#dealtype,#targetType').attr('style', 'background-color: #ffffff !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #ffffff !important');
}
  function clear_searchallfield(){
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
} 
function submitfilter() {

localStorage.removeItem("pageno");

document.reinvestment.action = "remandaindex.php?value=2"
document.reinvestment.submit();

return true;
}
  </script>
  
  
  
<?php 
$vCFlagValue=1;
$VCFlagValue=1;
$pagetitle="Real Estate-PE-Exits M&A -> Search";
$stagesql_search="select RETypeId,REType from realestatetypes order by REType";
$industrysql_search="select industryid,industry from reindustry";
$dealtypesql = "select DealTypeId,DealType from dealtypes";
                 
             //   $regionsql="select RegionId,Region from region where Region!='' order by RegionId";

$showdealsbyflag=0;
if($investorsearch!="" || $acquirersearch !="" || $companysearch!="" || $sectorsearch!="" || $adcompanyacquirer_legal!="" || $adcompanyacquirer_trans!="")
{ 
    $showdealsbyflag=1;
    $disable_flag = "1";
    $background = "#dddddd  !important";       
}else{
    $disable_flag = "0";
    $background = "#ffffff";          
}   ?>




<h2 class="acc_trigger">
    <a href="#">Refine Search</a></h2>
<div class="acc_container" >
		<div class="block">
			<ul >
<li class="even" style="display:none;"><h4>Industry</h4>
                    <div class="selectgroup">
                        <select name="industry[]" multiple="multiple"  id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
		<?php
                
                        
                
			if ($industryrs = mysql_query($industrysql_search))
			{
			 $ind_cnt = mysql_num_rows($industryrs);
			}
                       
			if($ind_cnt>0)
			{
				 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$id = $myrow[0];
					$name = $myrow[1];
                                    if(count($industry)>0)
                                        {
                                        $indSel = (in_array($id,$industry))?'selected':''; 
                                        echo "<OPTION id='industry_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";
                                        }
                                        else
                                        {
                                            if($id==15){
                                                echo "<OPTION id='industry_".$id. "' value=".$id." selected>".$name."</OPTION> \n";

                                            }else{
                                                 echo "<OPTION id='industry_".$id. "' value=".$id.">".$name."</OPTION> \n";
                                        }
                                    }
					
				}
				mysql_free_result($industryrs);
			}
    	?>
    </select>
                    </div>
</li>


<li class="odd"><h4>Sector</h4>
<div class="selectgroup">
 <select name="stage[]" multiple="multiple" size="5" id='stage' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?> >
<?php
	
	if ($stagers = mysql_query($stagesql_search)){
  		$stage_cnt = mysql_num_rows($stagers);
	}
	if($stage_cnt > 0){
            $i=1;
		While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH)){
			$id = $myrow[0];
			$name = $myrow[1];
			$isselect='';
                        if($industry!='')
                        {
                            
			for($i=0;$i<count($stageval);$i++){
				$isselect = ($stageval[$i]==$id && $stageval[$i]!='') ? "SELECTED" : $isselect;
			}
                        $name=($name!="")?$name:"Other";
			echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                        }
                        else
                        {
                             $isselected = ($getstage==$name && $getstage!='' ) ? 'SELECTED' : '';
                             $name=($name!="")?$name:"Other";
                            echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                        }
		}
		 mysql_free_result($stagers);
	}
	
 ?>
</select> </div>
    
    <input type="button" name="fliter_stage" class="fliter_stage" value="Filter" <?php if($disable_flag == "1"){ echo "disabled"; } ?> onclick="submitfilter();">
 
</li>		

<?php if ($rsdealtype = mysql_query($dealtypesql)){
        $stage_cnt = mysql_num_rows($rsdealtype);
        }?>
<li class="odd"><h4>Deal Type<span ><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
                                             Definitions
                                             </span>
     </a></span></h4>
    <SELECT NAME="dealtype" id="dealtype" onchange="submitfilter();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
	<OPTION id=5 value="--" selected></option>
     <?php
           
        if ($rsdealtype = mysql_query($dealtypesql)){
        	  $stage_cnt = mysql_num_rows($rsdealtype);
        }
        if($stage_cnt >0){
            
        	While($myrow=mysql_fetch_array($rsdealtype, MYSQL_BOTH)){
            	$id = $myrow[0];
                $name = $myrow[1];
                 if($dealtype!='')
                  {
                        $isselcted = ($dealtype==$id) ? 'SELECTED' : "";
                        echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                  }
                  else
                  {
                      $isselcted = "";
                       echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                      
                  }
        	}
    		mysql_free_result($rsdealtype);
    	}
?>
</SELECT>
</li>

<li class="odd"><h4>Target Type</h4>
    <SELECT NAME="targetType" id="targetType" onchange="submitfilter();" id="comptype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION  value="--" selected>  </option>
    <OPTION value="1" <?php echo ($targetProjectTypeId=="1") ? 'SELECTED' : ""; ?>> Entity </option>
    <OPTION  value="2" <?php echo ($targetProjectTypeId=="2") ? 'SELECTED' : ""; ?>> Project / Asset </option>
</SELECT>

</li>
<li class="odd"><h4>Exit Status</h4>

   <select NAME="exitstatus" onchange="submitfilter();" id="exitstatus" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <option  value="--" selected>All</option>
       <option value="0" <?php if(isset($exitstatusvalue) && $exitstatusvalue=="0"){ echo 'selected="selected"'; } ?> >Partial</option>
       <option value="1" <?php if(isset($exitstatusvalue) && $exitstatusvalue=="1"){ echo 'selected="selected"'; } ?> >Complete</option>
   </select>

    
</li>

</ul></div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
<li class="ui-widget" style="position: relative"><h4>Investor</h4>
    
    <!--
<SELECT id="keywordsearch" NAME="investorsearch">
       <OPTION id="5" value=" " selected></option>
         <?php
                 include ('reinvestors_model.php');
                
                        
             $getInvestorSql=getReInvestorsByValue(3);
				
            if ($rsinvestors = mysql_query($getInvestorSql)){
                $investor_cnt = mysql_num_rows($rsinvestors);
            }
			
            if($investor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                	$Investorname=trim($myrow["Investor"]);
					$Investorname=strtolower($Investorname);

					$invResult=substr_count($Investorname,$searchString);
					$invResult1=substr_count($Investorname,$searchString1);
					$invResult2=substr_count($Investorname,$searchString2);
					
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ( $myrow["Investor"]!='') ){
						$investor = $myrow["Investor"];
						$investorId = $myrow["InvestorId"];
						//echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
						$isselcted = (trim($_POST['investorsearch'])==trim($investor)) ? 'SELECTED' : '';
						// echo "<OPTION value='".$investor."' ".$isselcted.">".$investor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsinvestors);
        	}
    ?>
</SELECT>
    -->
    
    
    <input type="text" id="investorauto_multiple" name="investorauto" value="<?php if($_POST['investorsearch']!='') echo  $_POST['investorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['investorsearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="keywordsearch_multiple" name="investorsearch" value="<?php if(isset($_POST['investorsearch'])) echo  $_POST['investorsearch'];  ?>" placeholder="" style="width:220px;">
     
     <span id="inv_clearall" title="Clear All" onclick="clear_keywordsearch1();" style="<?php if($_POST['investorsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="investorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
    
</li>

<li class="ui-widget" style="position: relative"><h4>Acquirer</h4>
   <?php 
       /* $acquirersearch_val=($_POST['acquirersearch']!="")? $_POST['acquirersearch'] :"";*/
   
   ?>
    <!--input type=text name="acquirersearch" value="<?php echo $acquirersearch_val; ?>" style="width: 95%;" autocomplete="off" -->
    
    <!--
    <select id="acquirersearch" name="acquirersearch" >
        <OPTION value=" " selected></option>
            <?php
                $getacquirerSql_search ="select peinv.AcquirerId,ac.Acquirer from  REmanda AS peinv,REacquirers as ac WHERE ac.AcquirerId = peinv.AcquirerId GROUP BY peinv.AcquirerId";
                if ($rsrequirer = mysql_query($getacquirerSql_search))
                { 
                        While($myrow1=mysql_fetch_array($rsrequirer, MYSQL_BOTH))
                        {

                                        $acqName = $myrow1["Acquirer"];
                                        $isselected = (trim($_POST['acquirersearch'])==trim($acqName)) ? 'SELECTED' : '';
                                        echo '<OPTION value="'.$acqName.'" '.$isselected.'>'.$acqName.'</OPTION> \n';
//	
                        }
                         mysql_free_result($rsrequirer);
                }
            ?>
   </select>
    -->
    
    
    <input type="text" id="acquirerauto" name="acquirerauto" value="<?php if($_POST['acquirersearch']!='') echo  $_POST['acquirerauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['acquirersearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="acquirersearch_multiple" name="acquirersearch" value="<?php if(isset($_POST['acquirersearch'])) echo  $_POST['acquirersearch'];  ?>" placeholder="" style="width:220px;">
     
     <span id="acq_clearall" title="Clear All" onclick="clear_acquirersearch1();" style="<?php if($_POST['acquirersearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="acquirerauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
    
</li>

<li class="ui-widget" style="position: relative"><h4>Company</h4>
    
    <!--
<select id="combobox" name="companysearch" >
		<OPTION value=" " selected></option>
		<?php
                         $getcompaniesSql_search =  getAllReCompanies(2);
			if ($rscompanies = mysql_query($getcompaniesSql_search))
			{ 
				While($myrow1=mysql_fetch_array($rscompanies, MYSQL_BOTH))
				{
                                    
					$companyname=trim($myrow1["companyname"]);
					$companyname=strtolower($companyname);
	
					$invResult=substr_count($companyname,$searchString);
					$invResult1=substr_count($companyname,$searchString1);
					$invResult2=substr_count($companyname,$searchString2);
//	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
					{
						$compName = $myrow1["companyname"];
						$isselected = (trim($_POST['companysearch'])==trim($compName)) ? 'SELECTED' : '';
						//  echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
//	
				}
                                 mysql_free_result($rscompanies);
			}
    	?>
   </select>	
    -->
    
     <input type="text" id="companyauto" name="companyauto" value="<?php if($_POST['companysearch']!='') echo  $_POST['companyauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['companysearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch1();" style="<?php if($_POST['companysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>


<li class="ui-widget" style="position: relative"><h4>Sub Sector</h4>
<!--
<select id="sectorsearch" NAME="sectorsearch" >
		<OPTION value=' ' selected></option>
		<?php
                $getsectorSql_search =  getAllReSector(2);
			if ($rssector = mysql_query($getsectorSql_search))
			{
				While($myrow=mysql_fetch_array($rssector, MYSQL_BOTH))
				{
					$sectorname=trim($myrow["sector_business"]);
					$sectorname=strtolower($sectorname);
	
					$invResult=substr_count($sectorname,$searchString);
					$invResult1=substr_count($sectorname,$searchString1);
					$invResult2=substr_count($sectorname,$searchString2);
	
					if(($invResult==0) && ($invResult1==0) && ($invResult2==0) && ($sectorname!=""))
					{
                                                $sectorName = $myrow["sector_business"];
						$isselected = (trim($_POST['sectorsearch'])==trim($sectorName)) ? 'SELECTED' : '';
						//echo '<OPTION value="'.$sectorName.'" '.$isselected.'>'.$sectorName.'</OPTION> \n';
				 		//$totalCount=$totalCount+1;
					}
				}
                                mysql_free_result($rssector);
			}
    	?>
   </select>	
    -->
    
      <input type="text" id="sectorauto" name="sectorauto" value="<?php if($_POST['sectorsearch']!='') echo  $_POST['sectorauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['sectorsearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="sectorsearch_multiple" name="sectorsearch" value="<?php if(isset($_POST['sectorsearch'])) echo  stripslashes($_POST['sectorsearch']);  ?>" placeholder="" style="width:220px;">
     
     <span id="sec_clearall" title="Clear All" onclick="clear_sectorsearch1();" style="<?php if($_POST['sectorsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="sectorauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
<li class="ui-widget"><h4>Legal Advisor</h4>
<?php
           $advisorsql=getReAdvisorsByValue("L2");
	
	
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_legal" NAME="adcompanyacquirersearch_legal">
       <OPTION id="5" value=" " selected></option>
         <?php
            /* populating the investortype from the investortype table */
			$searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);

            if($advisor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                	$adviosrname=trim($myrow["Cianame"]);
					$adviosrname=strtolower($adviosrname);

					$invResult=substr_count($adviosrname,$searchString);
					$invResult1=substr_count($adviosrname,$searchString1);
					$invResult2=substr_count($adviosrname,$searchString2);

					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
						$ladvisor = $myrow["Cianame"];
						$ladvisorid = $myrow["CIAId"];
						//echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
						$isselcted = (trim($_POST['adcompanyacquirersearch_legal'])==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
</li>

<li class="ui-widget"><h4>Transaction Advisor</h4>
<?php
	$advisorsql=getReAdvisorsByValue("T2");
        
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_trans" NAME="adcompanyacquirersearch_trans">
       <OPTION id="5" value=" " selected></option>
         <?php
            /* populating the investortype from the investortype table */
			$searchString="Undisclosed";
			$searchString=strtolower($searchString);
		
			$searchString1="Unknown";
			$searchString1=strtolower($searchString1);
		
			$searchString2="Others";
			$searchString2=strtolower($searchString2);

            if($advisor_cnt >0){
             	 While($myrow=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                                        $adviosrname=trim($myrow["Cianame"]);
					$adviosrname=strtolower($adviosrname);

					$invResult=substr_count($adviosrname,$searchString);
					$invResult1=substr_count($adviosrname,$searchString1);
					$invResult2=substr_count($adviosrname,$searchString2);

					if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){ 
						$ladvisor = $myrow["Cianame"];
						$ladvisorid = $myrow["CIAId"];
						//echo "<OPTION value=".$ladvisorid.">".$ladvisor."</OPTION> \n";
						$isselcted = (trim($_POST['adcompanyacquirersearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
    </li>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="submitfilter();" style="float: right;">
    </li>
    
</ul></div>
	</div>



