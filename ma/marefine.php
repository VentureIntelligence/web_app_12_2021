
<?php 
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('machecklogin.php');
if($acquirersearch!="" || $targetcompanysearch!="" || $targetsectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
{ 
    $disable_flag = "1";
    $background = "#dddddd  !important";       
}else{
    $disable_flag = "0";
    $background = "#ffffff";          
}
/*$showdealsbyflag=0;
if($keyword!="" || $companysearch!="" || $sectorsearch!="" || $advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
{ 
    $showdealsbyflag=1; 
    
}  */?>

<script>
    // moorthi
    
    
  $(function() {
  //    $('#popup_keyword').bind('input propertychange', function() {
    /*$( "#popup_keyword" ).keyup(function() {
        var popup_select = $('#popup_select').val();
        var advisor_type = $('#advisor_type').val();
        if(popup_select !=''){
            if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                var tokenLimit = 1;
            }else{
                var tokenLimit = 100;
            }
            var request_url = "ajaxPopupSearch.php?select_type="+popup_select+"&test= ";
            $("#popup_keyword").tokenInput(request_url, {
                theme: "facebook",
                minChars:1,
                queryParam: "search",
                hintText: "",
                noResultsText: "No Result Found",
                preventDuplicates: true,
                tokenLimit:tokenLimit,
                onAdd: function (item) {
                    clear_keywordsearch();
                    clear_companysearch();
                    clear_sectorsearch();
                    clear_searchallfield();

                },
                onResult: null
            });
                $('#token-input-popup_keyword').focus();
        }
    });
    $( "#popup_select" ).change(function() {
            var popup_select = $('#popup_select').val();
            var advisor_type = '';
            if(popup_select !=''){
                $('#advisor_type').val(advisor_type);
             //  $('#popup_keyword').tokenInput("clear");
            //    $('.token-input-list').remove();
                $(".token-input-list-facebook").remove();
                var popup_select = $('#popup_select').val();
                var advisor_type = $('#advisor_type').val();
                if(popup_select == 'legal_advisor' || popup_select == 'transaction_advisor'){
                    var tokenLimit = 1;
                }else{
                    var tokenLimit = 100;
                }
                var request_url = "ajaxPopupSearch.php?select_type="+popup_select+"&test= ";
                $("#popup_keyword").tokenInput(request_url, {
                    theme: "facebook",
                    minChars:1,
                    queryParam: "search",
                    hintText: "",
                    noResultsText: "No Result Found",
                    preventDuplicates: true,
                    tokenLimit:tokenLimit,
                    onAdd: function (item) {
                        clear_keywordsearch()
                        clear_companysearch();
                        clear_sectorsearch();
                        clear_searchallfield();

                    },
                    onResult: null
                });
                $('#token-input-popup_keyword').focus();
            }else{
                $('#popup_keyword').tokenInput("clear");
                $('.token-input-list').remove();
                $(".token-input-list-facebook").remove();
                $('#popup_keyword').show();
            }
    });*/
   
    
         $( "#popup_select" ).change(function() {

            $('#popup_keyword').val('');
            $('#search_load').html('');
            $("#popup_keyword").removeAttr('readonly');
        });
        
        $( "#popup_keyword" ).keyup(function() {
             
            var popup_select = $('#popup_select').val();
            var advisor_type = $('#advisor_type').val();
            var search_term = $(this).val();
            if(popup_select !=''){
                
                $.ajax({
                        type: "post",
                        url: "ajaxPopupSearch.php",
                        data: {
                             search: search_term,select_type: popup_select
                        },
                        success: function(data) {

                             var innerdata=$.parseJSON(data);
                             var datacount = innerdata.length;   

                             if(datacount>0) {
                                 
                                var multiselect='';

                                if(datacount>1){

                                    multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="search_selectall"> SELECT ALL</label><br>';
                                }
                                $.each(innerdata, function (key, item) {

                                    multiselect+="<label style='clear: both;'><input type='checkbox' name='search_multi[]' value='"+item['id']+"' class='search_slt' data-title='"+item['name']+"' >"+item['name']+"</label></br>";

                                });
                                multiselect+="</br></br>"; 

                                $("#search_load").fadeIn();
                                $("#search_load").html(multiselect);
                                disableFileds();
                            }
                            else{
                                $("#search_load").fadeOut();
                                $("#search_load").html('');
                            }
                        }
                });
        }
        else{
             $("#searchselector").fadeOut();
        }
        
    });
    
    $('.search_slt').live("click", function() {  //on click 
          
        var sltholder='';
        var sltsector_multi ='';
        
        var allChecked = $('.search_slt:checked').length === $('.search_slt').length;
        $('#search_selectall').prop('checked', allChecked);
        
       
        $('.search_slt').each(function() { //loop through each checkbox

            if(this.checked) {  
                
                var holder = $(this).data("title"); 
                var slt_sec_name = $(this).val(); 

                sltholder+=","+holder;   
                sltsector_multi+=",'"+slt_sec_name+"'";  

                $("#searchselector").show();
            }

        });
        if($('.search_slt:checked').length > 0){
            $("#popup_keyword").attr('readonly','readonly');  
        }else{
            $("#popup_keyword").removeAttr('readonly');
        }
        $("#popup_keyword").val(sltholder.substr(1));

    });
    
    $("#search_selectall").live("click", function() {
    

        $('.search_slt').attr('checked',this.checked);
        if(this.checked) 
        {                              
            var holder = $(this).val();                             
            var sltholder='';
            var sltsearch_multi ='';
            var sltcount=0;
            $('.search_slt').each(function() { //loop through each checkbox

                if(this.checked) {                              
                   var holder = $(this).data("title"); 
                   var slt_search_name = $(this).val(); 

                      /*if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id; }
                      else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id; }*/
                    sltholder+=","+holder;   
                    sltsearch_multi+=",'"+slt_search_name+"'";
                   sltcount++;
                }
              });
              $("#popup_keyword").attr('readonly','readonly'); 
              $("#popup_keyword").val(sltholder.substr(1));
              //$("#popup_keyword").val(sltsearch_multi); 
              $("#popup_keyword").fadeIn();
            disableFileds();
        }
        else{
            enableFileds();
            //$("#search_load").fadeOut(); 
            $("#popup_keyword").removeAttr('readonly');
            $("#popup_keyword").val('');
        }
    });
    
    $(document).on("click",function(e) {
        

        if(e.target.id == "popup_keyword"  || e.target.id == "search_load" || $(e.target).parents('#search_load').length){
            $('#search_load').show();
        } else {
            $('#search_load').hide();
        }
    });
    
});
  $(document).ready(function() {
  
    // Target company search with checkbox start //
        $( "#companysearch" ).keyup(function() {
             
             var companySearch = $("#companysearch").val();
              
             if(companySearch.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "autosuggestTargetComp.php",
                     data: {
                       queryString: companySearch
                     },
                     success: function(data) {
                         
                           var innerdata=$.parseJSON(data);
                           var multiselect='';
                           if(innerdata.length > 0)
                           {
                                if(innerdata.length > 1)
                                {
                                    var multiselect='<label><input style="width:auto !important;" type="checkbox" id="selectall">SELECT ALL</label><br>';
                                }
                                $.each(innerdata, function (key, item) {
                               
                                    multiselect+="<label style='clear: both;'><input style='width:auto !important;' type='checkbox' name='charge_holder[]' value='"+item['companyid']+"' class='ch_holder' data-title='"+item['companyname']+"' >"+item['companyname']+"</label></br>";

                                });
                            }
                           
                            $("#testholder").fadeIn();
                            $("#testholder").html(multiselect);
                             disableFileds();
                     }
                   });

                 /*  $.post('chargefilter_autosuggest_test.php',{chargeholder:'test',xcxzc:'asdas'},function(data){
                       console.log(data);
                   }); */
        }
        else{
             $("#testholder").fadeOut();
             enableFileds();
        }
        
    });
    
        $("#selectall").live("click", function() {
            clear_acquire();
            clear_sectorSearch();
            clear_searchallfield();
            $('.ch_holder').attr('checked',this.checked);
            var sltholder='';
            var sltcompId='';
            var sltcount=0;
            if(this.checked) 
            {  
                $('.ch_holder').each(function() { //loop through each checkbox

                       if(this.checked) {                              
                          var holder = $(this).parent().text();    
                          var compId = $(this).val();    

                             if(sltcount==0) { sltholder+=holder;sltcompId+=compId; }
                             else { sltholder+=","+holder;sltcompId+=","+compId; }

                          sltcount++;
                       }

                  });
                   $("#companysearch").attr('readonly','readonly');  
                   $("#charge_clearall").fadeIn();
                   disableFileds();
             }
             else{
                 
                 if(sltcount==0){  $("#charge_clearall").fadeOut(); $("#companysearch").removeAttr('readonly');   }
                    else {   $("#charge_clearall").fadeIn();  }
                    enableFileds();
             }
               
                $("#companysearch").val(sltholder); 
                 $("#companyId").val(sltcompId); 
                $("#testholder").show();
        });
    
        $('.ch_holder').live("click", function() {  //on click 
                      clear_acquire();
                      clear_sectorSearch();
            clear_searchallfield();
                      var sltholder='';
                      var sltcompId='';
                      var sltcount=0;
                      $('.ch_holder').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                             var holder = $(this).parent().text();                             
                             var compId = $(this).val();  
                             
                                if(sltcount==0) { sltholder+=holder; sltcompId+=compId;}
                                else { sltholder+=","+holder; sltcompId+=","+compId;}
                             
                             sltcount++;
                             
                              //sltuserscout++;
                          }
                          
                     });
                     $("#testholder").show();
                    $("#companysearch").attr('readonly','readonly');  
                    $("#companysearch").val(sltholder); 
                    $("#companyId").val(sltcompId); 
                    disableFileds();
                    
                    if(sltcount==0){  $("#charge_clearall").fadeOut(); $("#companysearch").removeAttr('readonly');   }
                    else {   $("#charge_clearall").fadeIn();  }
                        
        if($(".ch_holder").length==$(".ch_holder:checked").length){
            
            $("#selectall").attr("checked","checked");
        }else{
            $("#selectall").removeAttr("checked");
        }
                     
                 
             });
           
    // Target company search with checkbox end // moorthi
   
    // Acquirers search with checkbox starts 
   
        $( "#askeywordsearch" ).keyup(function() {
             
             var acquireSearch = $("#askeywordsearch").val();
              
             if(acquireSearch.length > 2 ) {
                $.ajax({
                    type: "post",
                    url: "autosuggestAcquirer.php",
                    data: {
                       queryString: acquireSearch
                     },
                    success: function(data) {
                         
                        var innerdata=$.parseJSON(data);
                        var multiselect='';
                        if(innerdata.length > 0)
                        {
                            if(innerdata.length > 1)
                            {
                                var multiselect='<label><input style="width:auto !important;" type="checkbox" id="acq_selectall">SELECT ALL</label><br>';
                            }
                             $.each(innerdata, function (key, item) {

                                 multiselect+="<label style='clear: both;'><input style='width:auto !important;' type='checkbox' name='acquire_holder[]' value='"+item['ladvisorid']+"' class='ch_acquire' data-title='"+item['ladvisor']+"' >"+item['ladvisor']+"</label></br>";

                             });
                         }

                        $("#testacquire").fadeIn();
                        $("#testacquire").html(multiselect);
                        disableFileds();
                     }
                   });
        }
        else{
             $("#testacquire").fadeOut();
        }
        
    });
    
        $("#acq_selectall").live("click", function() {
            clear_chholder();
            clear_sectorSearch();
            clear_searchallfield();
            $('.ch_acquire').attr('checked',this.checked);
            var acquireText='';
            var acqCompId='';
            var acqCount=0;
            if(this.checked) 
            {  
                $('.ch_acquire').each(function() { //loop through each checkbox

                    if(this.checked) {                              
                       var holder = $(this).parent().text();    
                       var compId = $(this).val();    

                          if(acqCount==0) { acquireText+=holder;acqCompId+=compId; }
                          else { acquireText+=","+holder;acqCompId+=","+compId; }

                       acqCount++;
                    }

                  });
                $("#askeywordsearch").attr('readonly','readonly');  
                $("#acquire_clearall").fadeIn();
                disableFileds();
             }
             else{
                  enableFileds();
                 if(acqCount==0){  $("#acquire_clearall").fadeOut(); $("#askeywordsearch").removeAttr('readonly');   }
                    else {   $("#acquire_clearall").fadeIn();  }
             }
               
            $("#askeywordsearch").val(acquireText); 
            $("#acquireId").val(acqCompId); 
            $("#testacquire").show();
        });
    
        $('.ch_acquire').live("click", function() {  //on click 
            clear_chholder();
            clear_sectorSearch();
            clear_searchallfield();
            var acquireText='';
            var acqCompId='';
            var acqCount=0;
            $('.ch_acquire').each(function() { //loop through each checkbox

                if(this.checked) {                              
                   var holder = $(this).parent().text();                             
                   var compId = $(this).val();  

                      if(acqCount==0) { acquireText+=holder; acqCompId+=compId;}
                      else { acquireText+=","+holder; acqCompId+=","+compId;}

                   acqCount++;

                    //sltuserscout++;
                }

            });
            $("#testacquire").show();
            $("#askeywordsearch").attr('readonly','readonly');  
            $("#askeywordsearch").val(acquireText); 
            $("#acquireId").val(acqCompId); 

disableFileds();
            if(acqCount==0){  $("#acquire_clearall").fadeOut(); $("#askeywordsearch").removeAttr('readonly');   }
            else {   $("#acquire_clearall").fadeIn();  }
                        
            if($(".ch_acquire").length==$(".ch_acquire:checked").length){

                $("#acq_selectall").attr("checked","checked");
            }else{
                $("#acq_selectall").removeAttr("checked");
            }
                     
                 
        });
    // Acquirers search with checkbox End // 
   
    // Target Sector Search Starts
   
   
      $( "#assectorsearch" ).keyup(function() {
             
             var sectorauto = $("#assectorsearch").val();
              
             if(sectorauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                        url: "autosuggestSector.php",
                        data: {
                            queryString: sectorauto
                        },
                        success: function(data) {
                         
                            var innerdata=$.parseJSON(data);
                            var datacount = innerdata.length;   

                            if(datacount>0) {
                                var multiselect='';
                                //if(datacount>1){
                            //   multiselect+='<label> <input style="width:auto !important;" type="checkbox" id="sec_selectall"> SELECT ALL</label><br>';
                            //}
                            $.each(innerdata, function (key, item) {
                                
                               multiselect+="<label style='clear: both;'><input type='checkbox' name='sector_multi[]' value='"+item['sectorname']+"' class='sector_slt' data-title='"+item['sectorname']+"' >"+item['sectorname']+"</label></br>";

                            });
                            //multiselect+="</br></br>"; 
                            
                            $("#testSector").fadeIn();
                            $("#testSector").html(multiselect);
                            clear_searchallfield();
                            disableFileds();
                            }
                            else{
                                $("#testSector").fadeOut();
                                $("#testSector").html('');
                            }
                     }
                   });
        }
        else{
             $("#testSector").fadeOut();
        }
        
    });    
    
    $('.sector_slt').live("click", function() {  //on click 
        
         if($(".sector_slt:checked").length >  10){
            
             this.checked = false;
             alert('Please select only 10 Sectors');
             return false;
        }
          
        clear_chholder();
        clear_acquire();
        
        var sltholder='';
        var sltsector_multi ='';
        var sltcount=0;

        $('.sector_slt').each(function() { //loop through each checkbox

            if(this.checked) {                              
                  var holder = $(this).data("title"); 
                  var slt_sec_name = $(this).val(); 

                  if(sltcount==0) { sltholder+=holder; sltsector_multi+="'"+slt_sec_name+"'";  }
                  else { sltholder+=","+holder;   sltsector_multi+=",'"+slt_sec_name+"'";  }

               sltcount++;
               $("#testSector").show();
                //sltuserscout++;
            }

       });

        $("#assectorsearch").attr('readonly','readonly');  
        $("#assectorsearch").val(sltholder); 
        $("#sectorsearch").val(sltsector_multi); 


        if(sltcount==0){  $("#sector_clearall").fadeOut(); $("#assectorsearch").removeAttr('readonly');   }
        else {   $("#sector_clearall").fadeIn();  }

//        if($(".sector_slt").length==$(".sector_slt:checked").length){
//            
//            $("#sec_selectall").attr("checked","checked");
//        }else{
//            $("#sec_selectall").removeAttr("checked");
//        }
    });
   
   // target Sector Search Ends
   });
   
   
   
//$(document).mouseup(function (e){
// 
//    $("#testholder").hide();
//    $("#testacquire").hide();
//    $("#testSector").hide();
//});
function submitfilter() {

localStorage.removeItem("pageno");

document.pesearch.action = 'index.php';
document.pesearch.submit();

return true;
}
   
function clear_chholder(){
     $("#companysearch").removeAttr('readonly');  
     $("#companysearch").val(''); 
     $("#companyId").val('');
     $("#testholder").fadeOut();
     $("#charge_clearall").fadeOut(); 
}   
    
function clear_acquire(){
     $("#askeywordsearch").removeAttr('readonly');  
     $("#askeywordsearch").val(''); 
     $("#acquireId").val('');
     $("#testacquire").fadeOut();
     $("#acquire_clearall").fadeOut(); 
}  
function clear_sectorSearch(){
     $("#assectorsearch").removeAttr('readonly');  
     $("#assectorsearch").val(''); 
     $("#sectorsearch").val('');
     $("#testSector").fadeOut();
     $("#sector_clearall").fadeOut(); 
}   
  function clear_searchallfield(){ 
     $("#searchallfieldHide").val('remove');
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
}  
function clear_chholder1(){
     $("#companysearch").removeAttr('readonly');  
     $("#companysearch").val(''); 
     $("#companyId").val('');
     $("#testholder").fadeOut();
     $("#charge_clearall").fadeOut(); 
     enableFileds();
}   
    
function clear_acquire1(){
     $("#askeywordsearch").removeAttr('readonly');  
     $("#askeywordsearch").val(''); 
     $("#acquireId").val('');
     $("#testacquire").fadeOut();
     $("#acquire_clearall").fadeOut(); 
     enableFileds();
}  
function clear_sectorSearch1(){
     $("#assectorsearch").removeAttr('readonly');  
     $("#assectorsearch").val(''); 
     $("#sectorsearch").val('');
     $("#testSector").fadeOut();
     $("#sector_clearall").fadeOut(); 
     enableFileds();
}  
    //
    
 // Company
 $(function() {
    $( "#companysearch_old" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestTargetComp.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.companyname,
                value: item.companyname,
                 id: item.companyname
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#companysearch').val(ui.item.value);
        $('#askeywordsearch,#assectorsearch,#asadvisorsearch_legal,#asadvisorsearch_trans').val("");
        clear_searchallfield();
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#companysearch').val()=="")
             $( "#companysearch" ).val('');  
      }
      
    });
    
   //Sector 
    $( "#assectorsearch_old" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestSector.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.sectorname,
                value: item.sectorname,
                 id: item.sectorname
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#assectorsearch').val(ui.item.value);
        $('#askeywordsearch,#companysearch,#asadvisorsearch_legal,#asadvisorsearch_trans').val("");
        clear_searchallfield();
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#assectorsearch').val()=="")
             $( "#assectorsearch" ).val('');  
      }
    });
    
    //Acquirers
    $( "#askeywordsearch_old" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestAcquirer.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.ladvisor,
                value: item.ladvisor,
                 id: item.ladvisorid
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#askeywordsearch').val(ui.item.value);
        $('#assectorsearch,#companysearch,#asadvisorsearch_legal,#asadvisorsearch_trans').val("");
        clear_searchallfield();
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#askeywordsearch').val()=="")
             $( "#askeywordsearch" ).val('');  
      }     
    });
    
    //Legal Advisor
    $( "#asadvisorsearch_legal" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestLegalAdv.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.ladvisor,
                value: item.ladvisor,
                 id: item.ladvisorid
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#asadvisorsearch_legal').val(ui.item.id);
        $('#assectorsearch,#companysearch,#askeywordsearch,#asadvisorsearch_trans').val("");
        clear_searchallfield();
            disableFileds();
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if($('#asadvisorsearch_legal').val()=="")
                $( "#asadvisorsearch_legal" ).val('');  
      }    
    });
    
    //Transcation Advisor
    $( "#asadvisorsearch_trans" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
            type: "POST",
            url: "autosuggestTransAdv.php",
            dataType: "json",
          data: {
            queryString: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.ladvisor,
                value: item.ladvisor,
                 id: item.ladvisorid
              }
            }));
          }
        });
      },
      minLength: 2,
        select: function( event, ui ) {
       $('#asadvisorsearch_trans').val(ui.item.value);
        $('#assectorsearch,#companysearch,#askeywordsearch,#asadvisorsearch_legal').val("");
        clear_searchallfield();
            disableFileds();
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if($('#asadvisorsearch_trans').val()=="")
                $( "#asadvisorsearch_trans" ).val('');  
      }   
    });
    

        });
  </script>


<h2 class="acc_trigger">
    <a href="#">Refine Search</a></h2>
<div class="acc_container" >
		<div class="block">
			<ul >
<li class="even"><h4>Industry</h4>

<div class="selectgroup">
	<select name="industry[]" multiple="multiple" id="industry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
		<!--<OPTION id=0 value="--" selected> Select an Industry </option>-->
		<?php
                 $industrysql="select industryid,industry from industry where industryid IN (".$_SESSION['MA_industries'].") " . $hideIndustry ." order by industry";
                if ($industryrs = mysql_query($industrysql))
			{
			 $ind_cnt = mysql_num_rows($industryrs);
			}
                       
			if($ind_cnt>0)
			{
				 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$id = $myrow[0];
					$name = $myrow[1];
                            $isselected = (in_array($id,$_POST['industry'])) ? 'SELECTED' : '';
                            echo "<OPTION id='industry_".$id. "' value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                        }
				mysql_free_result($industryrs);
			}
    	?>
    </select>
</div>

</li>
<!--<li class="even"><h4>Deal Type <span ><a href="#popup3" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
    <span>
    <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
    Definitions
    </span>
           </a>
    </span></h4>
  <?php 
    $invtypesql_search = "select MADealTypeId,MADealType from madealtypes order by MADealTypeId ";
    if ($invtypers = mysql_query($invtypesql_search))
    {
        $invtype_cnt = mysql_num_rows($invtypers);
    }
  ?>
 <SELECT NAME="dealtype" onchange="this.form.submit();">
    <OPTION  value="--" selected>ALL</option>
    <?php
       /* populating the madealtypes from the madealtypes table */
       
        if($invtype_cnt >0)
        {
         While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
        {
                    $id = $myrow["MADealTypeId"];
                    $name = $myrow["MADealType"];
                    if($_POST['dealtype']!='')
                    {
                        $isselected = ($_POST['dealtype']==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                    }
                  /*  else
                    {
                        $isselected = ($getindus==$name) ? 'SELECTED' : '';
                        echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                    }*/
                    else
                    echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
           }
           mysql_free_result($invtypers);
        }
?>
</SELECT>
</li>-->

<li class="odd"><h4>Target Company Type</h4>

    <SELECT NAME="targetcompanytype" onchange="submitfilter()" id="targetcompanytype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION  value="--" selected> Both </option>
    <OPTION value="L" <?php echo ($_POST['targetcompanytype']=="L") ? 'SELECTED' : ""; ?>> Listed </option>
    <OPTION  value="U" <?php echo ($_POST['targetcompanytype']=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
</SELECT>

</li>
<li class="odd"><h4>Acquirer Company Type</h4>

    <SELECT NAME="acquirercompanytype" onchange="submitfilter();" id="acquirercompanytype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION  value="--" selected> Both </option>
    <OPTION value="L" <?php echo ($_POST['acquirercompanytype']=="L") ? 'SELECTED' : ""; ?>> Listed </option>
    <OPTION  value="U" <?php echo ($_POST['acquirercompanytype']=="U") ? 'SELECTED' : ""; ?>> Unlisted </option>
</SELECT>

</li>
<li class="odd"><h4>Target Country </h4>
<div class="selectgroup">
    <SELECT NAME="targetCountry[]" multiple="multiple" id="targetCountry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
	<!--<OPTION  value="--" selected> ALL </option>-->
        <?php
        $countrysql="select countryid,country from country where countryid NOT IN  ('','--','10','11') order by country";
               if ($countryrs = mysql_query($countrysql))
               {
                $ind_cnt = mysql_num_rows($countryrs);
               }
               if($ind_cnt>0)
               {
                       While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                       {
                               $id = $myrow[0];
                               $name = $myrow[1];
                               $isselected = (in_array($id,$_POST['targetCountry'])) ? 'SELECTED' : '';
                               echo "<OPTION id='targetCountry_".$id."' value=".$id." ".$isselected." >".$name."</OPTION> \n";
                       }
                       mysql_free_result($countryrs);
               }
        ?>
</SELECT>
</div>
</li>

<li class="even"><h4>Acquirer Country</h4>
<div class="selectgroup">
  
    <SELECT NAME="acquirerCountry[]" multiple="multiple" id="acquirerCountry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
       <!--<OPTION  value="--" selected> ALL </option>-->
       <?php
            $countrysql="select countryid,country from country where countryid NOT IN  ('','--','10','11') order by country";
            if ($countryrs = mysql_query($countrysql))
            {
             $ind_cnt = mysql_num_rows($countryrs);
            }
            if($ind_cnt>0)
            {
                     While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                    {
                            $id = $myrow[0];
                            $name = $myrow[1];
                            $isselected = (in_array($id,$_POST['acquirerCountry'])) ? 'SELECTED' : '';
                            echo "<OPTION id='acquirerCountry_".$id."' value=".$id." ".$isselected." >".$name."</OPTION> \n";
                    }
                    mysql_free_result($countryrs);
            }
       ?>
</SELECT>
</div>
</li>


<li class="odd range-to"><h4>Deal Range (US $ M)</h4>

    <SELECT name="invrangestart" id="invrangestart" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>><OPTION id=4 value="--" selected>ALL  </option>
	<?php
                $intialValue=1;
                //$counter=5;
                     $isselected = ($_POST['invrangestart']==1) ? 'SELECTED' : '';
                    echo "<OPTION id=".$intialValue. " value=".$intialValue." ".$isselected.">".$intialValue."</OPTION> \n";
                   for ( $counter = 5; $counter <= 100; $counter += 5)
                   {
                       $isselected = ($_POST['invrangestart']==$counter) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counter. " value=".$counter." ".$isselected.">".$counter."</OPTION> \n";
                   }
                    for ( $counter = 150; $counter <= 1000; $counter += 50)
                    {
                        $isselected = ($_POST['invrangestart']==$counter) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counter. " value=".$counter." ".$isselected.">".$counter."</OPTION> \n";
                    }
                   for ( $counter = 2000; $counter <= 10000; $counter += 1000)
                   {
                       $isselected = ($_POST['invrangestart']==$counter) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counter." value=".$counter." ".$isselected.">".$counter."</OPTION> \n";
                   }
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" id="invrangeend" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?> onchange="submitfilter();"><OPTION  value="--" selected>ALL  </option>
	<?php
                for ($counterTo = 5; $counterTo <= 100; $counterTo += 5)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
                for ($counterTo = 150; $counterTo <= 1000; $counterTo += 50)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
                for ($counterTo = 2000; $counterTo <= 10000; $counterTo += 1000)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
                for ($counterTo = 20000; $counterTo <= 50000; $counterTo += 10000)
                {
                    $isselected = ($_POST['invrangeend']==$counterTo) ? 'SELECTED' : '';
                    echo "<OPTION id=".$counterTo." value=".$counterTo." ".$isselected.">".$counterTo."</OPTION> \n";
                }
        ?> 
</select>
</li>

<!-- -->

<li class="odd"><h4>Valuations </h4>
<div class="selectgroup">
   
<select name="valuations[]" multiple="multiple" size="3" id='valuations' style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <option value="Revenue_Multiple"  <?php if($boolvaluations==TRUE && ( $valuations[0]=='Revenue_Multiple' || $valuations[1]=='Revenue_Multiple' || $valuations[2]=='Revenue_Multiple' )) { echo 'selected';} ?> >Revenue Multiple</option>
    <option value="EBITDA_Multiple"   <?php if($boolvaluations==TRUE && ($valuations[0]=='EBITDA_Multiple' || $valuations[1]=='EBITDA_Multiple' || $valuations[2]=='EBITDA_Multiple' )) { echo 'selected';} ?>>EBITDA Multiple</option>
    <option value="PAT_Multiple"   <?php if($boolvaluations==TRUE && ($valuations[0]=='PAT_Multiple' || $valuations[1]=='PAT_Multiple' || $valuations[2]=='PAT_Multiple') ) { echo 'selected';} ?>>PAT Multiple</option>
</select> </div>
</li>
<!-- -->


<li><input type="button" name="fliter_stage" class="fliter_stage" value="Filter" id="filter-refine" style="float: right;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>></li>
</ul></div>
	</div>
	
	<h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<ul >
    
    <li class="ui-widget" style=" position: relative;"><h4>Target Company</h4>
    <?php if($_POST['popup_select'] == 'company'){
            $csearch = $company_filter;
            //$cauto = $_POST['popup_keyword'];
            $cauto=trim(implode(',', $_POST['search_multi']));
        }else{
            $csearch = $_POST['companysearch'];
            $cauto = $_POST['companyId'];
            
        } ?>
        <input type="text" value="<?php echo $csearch; ?>" <?php if($csearch) echo 'readonly="readonly"'; ?> name="companysearch" id="companysearch"  class=""  autocomplete=off  style="width:220px;"/>
        <input type="hidden" name="companyId" id="companyId" value="<?php echo $cauto; ?>" />
         <span id="charge_clearall" title="Clear All" onclick="clear_chholder1();" style=" <?php if($csearch=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute; top:28px;  right: 31px; cursor: pointer;  padding: 4px;">(X)</span> 
         <div id="testholder" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none; width:225px;"></div>
    </li>
    <li class="ui-widget" style=" position: relative;"><h4>Target Sectors</h4>
    <?php if($_POST['popup_select'] == 'sector'){
            //$ssearch = $_POST['popup_keyword'];
            $ssearch=trim(implode(',', $_POST['search_multi']));
            $sauto = $sectors_filter;
        }else{
            $ssearch = $_POST['sectorsearch'];
            $sauto = $_POST['assectorsearch'];
            
        } ?>
        <input type="text" value="<?php if(isset($ssearch)) echo  $sauto; ?>" <?php if($ssearch) echo 'readonly="readonly"'; ?> name="assectorsearch" id="assectorsearch"  class=""  autocomplete=off style="width:220px;"/>	
        <input type="hidden" id="sectorsearch" name="sectorsearch" value="<?php if(isset($ssearch)) echo  stripslashes(trim($ssearch));  ?>" placeholder="" style="width:220px;">
        <span id="sector_clearall" title="Clear All" onclick="clear_sectorSearch1();" style="<?php if($ssearch=='') echo 'display:none;';  ?>background: #BFA074; top:28px;  position: absolute;  right: 31px; cursor: pointer;  padding: 4px;">(X)</span> 
        <div id="testSector" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none; width:225px;"></div>
    </li>
    <li class="ui-widget" style=" position: relative;"><h4>Acquirers</h4>
    <?php if($_POST['popup_select'] == 'acquirers'){
            $isearch = $invester_filter;
            //$iauto = $_POST['popup_keyword'];
            $iauto = trim(implode(',', $_POST['search_multi']));
        }else{
            $isearch = $_POST['keywordsearch'];
            $iauto = $_POST['acquireId'];
            
        } ?>
        <input type="text" value="<?php echo $isearch; ?>" <?php if($isearch) echo 'readonly="readonly"'; ?> name="keywordsearch" id="askeywordsearch"  class=""  autocomplete=off style="width:220px;"/>	
        <input type="hidden" name="acquireId" id="acquireId" value="<?php echo $iauto; ?>" />
        <span id="acquire_clearall" title="Clear All" onclick="clear_acquire1();" style="<?php if($isearch=='') echo 'display:none;';  ?>background: #BFA074; top:28px;  position: absolute;  right: 31px; cursor: pointer;  padding: 4px;">(X)</span> 
        <div id="testacquire" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none; width:225px;"></div>
       
    </li>
    <li class="ui-widget"><h4>Legal Advisor</h4>
        <?php if($_POST['popup_select'] == 'legal_advisor'){
            $lauto = $legal_filter;
        }else{
            $lauto = $_POST['advisorsearch_legal'];            
        } ?>
        <input type="text" value="<?php echo $lauto; ?>" name="advisorsearch_legal" id="asadvisorsearch_legal"  class=""  autocomplete=off style="width:220px;"/>	
    </li>


    <li class="ui-widget"><h4>Transaction Advisor</h4>
        <?php if($_POST['popup_select'] == 'transaction_advisor'){
            $tauto = $transaction_filter;
        }else{
            $tauto = $_POST['advisorsearch_trans'];
            
        } ?>
        <input type="text" value="<?php echo $tauto; ?>" name="advisorsearch_trans" id="asadvisorsearch_trans"  class=""  autocomplete=off style="width:220px;"/>	
    </li>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" id="filter-refine1" style="float: right;">
    </li>
    
</ul></div>
	</div>
	<h2 class="acc_trigger"><a href="#">Search All Fields</a></h2>
	<div  class="acc_container " style="display: none;">
		<div class="block">
<form name="searchallleftmenu" action="<?php echo $actionlink; ?>" method="post" id="searchallleftmenu">   
<ul > 
<li class="ui-widget">
    <input type="text" id="searchKeywordLeft" name="searchKeywordLeft" value="<?php //if(isset($searchallfield)) echo  $searchallfield;  ?>" placeholder="" style="width:220px;">
</li>
    <li>
        <input type="button" name="fliter_stage" value="Search" onclick="submitfilter()" style="float: right;">
    </li>

</ul>
</form></div>
	</div>


        <script>
         
          $( "#filter-refine, #filter-refine1" ).click(function() {
        submitSearchRemove();
    });

    function submitSearchRemove(){
        localStorage.removeItem("pageno");
        $('#hide_company_array').val('');
        $('#pe_checkbox_disbale').val('');
        $('#pe_checkbox_enable').val('');
        $('#all_checkbox_search').val('');
                      
        $('#total_inv_deal').val('');
        $('#total_inv_amount').val('');
        $('#total_inv_inr_amount').val('');
        $('#total_inv_company').val('');

        $('#real_total_inv_deal').val('');
        $('#real_total_inv_amount').val('');
        $('#real_total_inv_inr_amount').val('');
        $('#real_total_inv_company').val('');
        $("#pesearch").submit();
    }
    
function disableFileds(){
    $("#industry").val('--');
    $("#industry").prop("disabled", true);    
    $("#targetcompanytype").val('');
    $("#targetcompanytype").prop("disabled", true);
    $("#acquirercompanytype").val('--');
    $("#acquirercompanytype").prop("disabled", true);
    $("#targetCountry").val('--');
    $("#targetCountry").prop("disabled", true);
    $("#acquirerCountry").val('');
    $("#acquirerCountry").prop("disabled", true);
    $("#invrangestart").val('--');
    $("#invrangestart").prop("disabled", true);
    $("#invrangeend").val('--');
    $("#invrangeend").prop("disabled", true);
    $("#valuations").val('');
    $("#valuations").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $('#targetcompanytype, #acquirercompanytype,#invrangestart,#invrangeend').attr('style', 'background-color: #dddddd !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#industry").prop("disabled", false);
    $("#targetcompanytype").prop("disabled", false);
    $("#acquirercompanytype").prop("disabled", false);
    $("#targetCountry").prop("disabled", false);
    $("#acquirerCountry").prop("disabled", false);
    $("#invrangestart").prop("disabled", false);
    $("#invrangeend").prop("disabled", false);
    $("#valuations").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $(' #targetcompanytype, #acquirercompanytype,#invrangestart,#invrangeend').attr('style', 'background-color: #ffffff !important');
    $('.selectgroup button').attr('style', 'width: 223px; background-color: #ffffff !important');
}   
    $( "#asadvisorsearch_legal" ).keyup(function() {
        var val = $("#asadvisorsearch_legal").val();
        if(val.length < 1){
            enableFileds();
        }else{
            disableFileds();            
        }
    });  
    $( "#asadvisorsearch_trans" ).keyup(function() {
        var val = $("#asadvisorsearch_trans").val();
        if(val.length < 1){
            enableFileds();
        }else{
            disableFileds();            
        }
    });
    
    $( "#searchallfield" ).keyup(function() {   
        $("#industry").val('');  
        $("#targetcompanytype").val('');
        $("#acquirercompanytype").val('--');
        $("#targetCountry").val('');
        $("#acquirerCountry").val('');
        $("#invrangestart").val('--');
        $("#invrangeend").val('--');
        $("#valuations").val('');    
    });
            </script>
