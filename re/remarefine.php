<SCRIPT  type="text/javascript">
    $( "#searchallfield" ).keyup(function() {    
            $("#sltindustry").val('');  
            $('#stage').val('');
            $("#dealtype").val('--'); 
            $("#targetType").val('--'); 
            $("#invrangestart").val('--'); 
            $("#invrangeend").val('--'); 
            $("#targetCountry").val('--'); 
            $("#acquirerCountry").val('--'); 
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
    
  
    
    
           ////////////// acquirer search start //////////////////////    
    
     $( "#acquirerauto" ).keyup(function() {
             
             var acquirerauto = $("#acquirerauto").val();
              
             if(acquirerauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxMultiAutosuggest.php?getacquirer", 
                     data: {
                        acquirer: '2', 
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
    
          
            clear_sectorsearch();
            clear_companysearch();
            clear_Legal_Trans();
            clear_searchallfield();
           
            
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
                      
                     
                       clear_sectorsearch();
                       clear_companysearch();
                        clear_Legal_Trans();
            clear_searchallfield();
                     
                      
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
           
    
    
     ////////////// company search start //////////////////////    
    
     $( "#companyauto" ).keyup(function() {
             
             var companyauto = $("#companyauto").val();
              
             if(companyauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                     url: "ajaxMultiAutosuggest.php?getcompany",
                     data: {
                        getAllReCompanies: '3',
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
    
            
            clear_sectorsearch();
            clear_acquirersearch();
            clear_Legal_Trans();
           
            
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
                    enableFileds();
               //  sltcount=0;sltholder='';
                   $("#com_clearall").fadeOut(); 
                   $("#companyauto").removeAttr('readonly');
                   $("#companyauto").val('');
             }
        });
    
     $('.company_slt').live("click", function() {  //on click 
                      
                      
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
                     
            
                    disableFileds();
                    $("#companyauto").attr('readonly','readonly');  
                    $("#companyauto").val(sltholder); 
                    $("#companysearch").val(sltcompany_multi); 
                    
                    
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
                        getAllReSector:'3',
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

    
  });
    

    
    
    
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
         
          clear_companysearch();
          clear_sectorsearch();
          clear_acquirersearch();
          
          
           advisorsearch_transbox.combobox("destroy") ;
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           advisorsearch_transbox.combobox() ;
          disableFileds();
          
        } );
        
        
         advisorsearch_transbox.on( "comboboxselect", function( event, ui ) {
             
        
          clear_companysearch();
          clear_sectorsearch();
          clear_acquirersearch();  
        
           advisorsearch_legalbox.combobox("destroy") ;          
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           advisorsearch_legalbox.combobox() ;
          disableFileds();

        } );
       
        
        $("#resetall").click(function (){
        
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
    $("#comptype").val('--');
    $("#comptype").prop("disabled", true);
    $("#invrangestart").val('--');
    $("#invrangestart").prop("disabled", true);
    $("#invrangeend").val('--');
    $("#invrangeend").prop("disabled", true);
    $("#targetCountry").val('--');
    $("#targetCountry").prop("disabled", true);
    $("#acquirerCountry").val('--');
    $("#acquirerCountry").prop("disabled", true);
    $(".fliter_stage").prop("disabled", true);
    $('#sltindustry,#dealtype, #comptype,#invrangestart,#invrangeend,#targetCountry,#acquirerCountry').attr('style', 'background-color: #dddddd !important');
}
function enableFileds(){ 
    $("#sltindustry").prop("disabled", false);
    $("#dealtype").prop("disabled", false);
    $("#comptype").prop("disabled", false);
    $("#invrangestart").prop("disabled", false);
    $("#invrangeend").prop("disabled", false);
    $("#targetCountry").prop("disabled", false);
    $("#acquirerCountry").prop("disabled", false);
    $(".fliter_stage").prop("disabled", false);
    $('#sltindustry, #dealtype, #comptype,#invrangestart,#invrangeend,#targetCountry,#acquirerCountry').attr('style', 'background-color: #ffffff !important');
}
  function clear_searchallfield(){
     $("#searchallfield").val('');
     $("#searchallfield").fadeOut();
} 
  </script>


<?php 
$vCFlagValue=1;
$VCFlagValue=1;
$pagetitle = "RE - Mergers & Acquistions";
$stagesql_search="select RETypeId,REType from realestatetypes order by REType";
$industrysql_search="select industryid,industry from reindustry";
                 
             //   $regionsql="select RegionId,Region from region where Region!='' order by RegionId";

$showdealsbyflag=0;
if($targetcompanysearch!="" || $sectorsearch!="" || $acquirersearch!="" || $advisorsearch_legal!="" || $advisorsearch_trans!="")
{ 
    $showdealsbyflag=1;
    $disable_flag = "1";
    $background = "#dddddd  !important";       
}else{
    $disable_flag = "0";
    $background = "#ffffff";          
}    ?>




<h2 class="acc_trigger">
    <a href="#">Refine Search</a></h2>
<div class="acc_container" >
            <div class="block">
                    <ul >
<li class="even" style="display:none;"><h4>Industry</h4>
                <div class="selectgroup">
                    <select name="industry[]" multiple="multiple" id="sltindustry" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
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

<?php 
$invtypesql = "select MADealTypeId,MADealType from madealtypes order by MADealTypeId ";

								
?>
<li class="odd"><h4>Deal Type<span ><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="<?php echo $refUrl; ?>images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="<?php echo $refUrl; ?>images/callout.gif">
                                             Definitions
                                             </span>
     </a></span></h4>
    <SELECT NAME="dealtype" id="dealtype" onchange="this.form.submit();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
	<OPTION id=5 value="--" selected> ALL </option>
     <?php
           
        if ($invtypers = mysql_query($invtypesql))
        {
        $invtype_cnt = mysql_num_rows($invtypers);
        }
        if($invtype_cnt >0)
        {
        While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH))
        {
            	$id = $myrow["MADealTypeId"];
                $name = $myrow["MADealType"];
                 if($_POST['dealtype']!='')
                  {
                        $isselcted = ($_POST['dealtype']==$id) ? 'SELECTED' : "";
                        echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                  }
                  else
                  {
                      $isselcted = "";
                       echo "<OPTION id='".$id. "' value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
                      
                  }
        	}
    		mysql_free_result($invtypers);
    	}
?>
</SELECT>
</li>

<li class="odd"><h4>Target Type</h4>
<!-- <label><input name="comptype[]" type="checkbox" value="L" />  Listed</label> 
 <label><input name="comptype[]" type="checkbox" value="U" /> Un-Listed</label>  -->

 <SELECT NAME="targetType" onchange="this.form.submit();" id="comptype" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
    <OPTION  value="--" selected> ALL </option>
    <OPTION value="1" <?php echo ($targetProjectTypeId=="1") ? 'SELECTED' : ""; ?>> Entity </option>
    <OPTION  value="2" <?php echo ($targetProjectTypeId=="2") ? 'SELECTED' : ""; ?>> Project / Asset </option>
</SELECT>

</li>


<li class="odd range-to"><h4>Deal Range (US $ M)</h4>

    <SELECT name="invrangestart" id="invrangestart" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>><OPTION id=4 value="--" selected>ALL  </option>
	<?php
                $counter=0;
                $incr=5;
                for ( $counter = 0; $counter <= 10000; $counter += $incr){
                    
                    if($_POST['invrangestart']!='')
                    {
			$isselcted = (($_POST['invrangestart']==$counter."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counter. " value=".$counter." ".$isselcted.">".$counter."</OPTION> \n";
                    }
                    else
                    {
                        $exprg = explode("-", $getrg);
                        $strg = $exprg[0];
                        $isselcted = (($strg==$counter."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counter. " value=".$counter." ".$isselcted.">".$counter."</OPTION> \n";
                    }
                    if($counter>=1000) {
                    $incr=1000;}
                    else if($counter>=100){
                    $incr=50;}
		}
          
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" id="invrangeend" onchange="this.form.submit();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>><OPTION id=5 value="--" selected>ALL  </option>
	<?php
        $counterto=0;
        $incr=5;
                for ( $counterto = 5; $counterto <= 50000; $counterto += $incr){
                    
                    if($_POST['invrangeend']!='')
                    {
			$isselcted = (($_POST['invrangeend']==$counterto."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                    }
                    else
                    {
                        $exprg = explode("-", $getrg);
                        $erg = $exprg[1];
                        $isselcted = (($strg==$counterto."")) ? 'SELECTED' : "";             
                	echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                    }
                    
                    if($counterto>=10000) {
                        $incr=10000; }
                    else if($counterto>=1000) {
                        $incr=1000; }
                    else if($counterto>=100){
                        $incr=50; }     
                }
        ?> 
</select>
<br/>
(Applicable only for deals with Announced Values)
<input type="button" name="fliter_stage" class="fliter_stage" value="Filter" onclick="this.form.submit();">
</li>

<li class="even"><h4>Country <br/>Target</h4>
    <select name="targetCountry" id="targetCountry" onchange="this.form.submit();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
		<OPTION id=0 value="--" selected></option>
		<?php
                        $countrysql="select countryid,country from country where countryid !=11 ";
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
                                        if($_POST['targetCountry']!='')
                                        {
                                            $isselected = ($_POST['targetCountry']==$id) ? 'SELECTED' : '';
                                            echo '<OPTION id="'.$id.'" value="'.$id.'" '.$isselected.'>'.$name.'</OPTION> \n';
                                        }
                                        else
                                        {
                                          echo '<OPTION id="'.$id.'" value="'.$id.'" >'.$name.'</OPTION> \n';
                                        }
					
                                    }
				mysql_free_result($countryrs);
			}
    	?>
    </select>


</li>


<li class="even"><h4>Acquirer Country</h4>
    <select name="acquirerCountry" id="acquirerCountry" onchange="this.form.submit();" style=" background: <?php echo $background; ?>;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
		<OPTION id=0 value="--" selected></option>
		<?php
                        $countrysql="select countryid,country from country where countryid !=11";
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
                                        if($_POST['acquirerCountry']!='')
                                        {
                                            $isselected = ($_POST['acquirerCountry']==$id) ? 'SELECTED' : '';
                                            echo "<OPTION id=".$id. " value=".$id." ".$isselected.">".$name."</OPTION> \n";
                                        }
                                        else
                                        {
                                             echo '<OPTION id="'.$id.'" value="'.$id.'" >'.$name.'</OPTION> \n';
                                        }
					
                                    }
				mysql_free_result($countryrs);
			}
    	?>
    </select>


</li>




</ul></div>
    </div>
	
	<h2 class="acc_trigger <?php 
            include ('reinvestors_model.php');
        if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show deals by</a></h2>
	<div  class="acc_container " style="display: none;">
<div class="block">
<ul >

<li  style="position: relative" ><h4>Acquirer</h4>
    
   <!-- 
  <select id="keywordsearch" name="keywordsearch" >
        <OPTION value=" " selected></option>
            <?php
                $getacquirerSql_search ="select peinv.AcquirerId,ac.Acquirer from  REmama AS peinv,REacquirers as ac WHERE ac.AcquirerId = peinv.AcquirerId GROUP BY peinv.AcquirerId";
                if ($rsrequirer = mysql_query($getacquirerSql_search))
                { 
                        While($myrow1=mysql_fetch_array($rsrequirer, MYSQL_BOTH))
                        {

                                        $acqName = $myrow1["Acquirer"];
                                        $isselected = (trim($_POST['keywordsearch'])==trim($acqName)) ? 'SELECTED' : '';
                                    //    echo '<OPTION value="'.$acqName.'" '.$isselected.'>'.$acqName.'</OPTION> \n';
//	
                        }
                         mysql_free_result($rsrequirer);
                }
            ?>
   </select>
   -->
     <input type="text" id="acquirerauto" name="acquirerauto" value="<?php if($_POST['keywordsearch']!='') echo  $_POST['acquirerauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['keywordsearch']!='') echo "readonly='readonly'";  ?>>
     <input type="hidden" id="acquirersearch_multiple" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">
     
     <span id="acq_clearall" title="Clear All" onclick="clear_acquirersearch1();" style="<?php if($_POST['keywordsearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     <div id="acquirerauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
   
</li>


<li class="ui-widget" style="position: relative"><h4>Company</h4>
    
    
    
    <!--
<select id="combobox" name="companysearch" >
		<OPTION value=" " selected></option>
		<?php
                         $getcompaniesSql_search =  getAllReCompanies(3);
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
						// echo '<OPTION value="'.$compName.'" '.$isselected.'>'.$compName.'</OPTION> \n';
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


<li class="ui-widget" style="position: relative"><h4>Sector</h4>

    <!--
<select id="sectorsearch" NAME="sectorsearch" >
		<OPTION value=' ' selected></option>
		<?php
                $getsectorSql_search =  getAllReSector(3);
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
						// echo '<OPTION value="'.$sectorName.'" '.$isselected.'>'.$sectorName.'</OPTION> \n';
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
           $advisorsql=getReAdvisorsByValue("L3");
	
	
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_legal" NAME="advisorsearch_legal">
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
						$isselcted = (trim($_POST['advisorsearch_legal'])==trim($ladvisor)) ? 'SELECTED' : '';
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
	$advisorsql=getReAdvisorsByValue("T3");
        
	if ($rsadvisor = mysql_query($advisorsql)){
		$advisor_cnt = mysql_num_rows($rsadvisor);
	}

?>
	<SELECT id="advisorsearch_trans" NAME="advisorsearch_trans">
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
						$isselcted = (trim($_POST['advisorsearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
						echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
					}
            	}
         		mysql_free_result($rsadvisor);
        	}
    ?>
	</SELECT>
    </li>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul></div>
	</div>



