<script>
     $(function() {
     ////////////// Company search start //////////////////////
    
        $('#resetall').click(function() {
            clear_companysearch();
            $("#location, #amount_from, #amount_to").val('');
          
        });
    
          $( "#companyauto" ).keyup(function() {
             
             var companyauto = $("#companyauto").val();
              
             if(companyauto.length > 2 ) {
                    $.ajax({
                       type: "post",
                      url: "angelco_companies.php",
                     data: {                       
                        queryString: companyauto
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

                             if(sltcount==0) { sltholder+=holder; sltcompany_multi+= "'"+slt_comp_id+"'"; }
                             else { sltholder+=","+holder;   sltcompany_multi+=",'"+slt_comp_id+"'"; }

                          sltcount++;
                         
                       }

                  });
                  $("#companyauto").attr('readonly','readonly'); 
                  $("#companyauto").val(sltholder);
                  $("#companysearch").val(sltcompany_multi); 
                  $("#com_clearall").fadeIn();
             }
             else{
               //  sltcount=0;sltholder='';
                   $("#com_clearall").fadeOut(); 
                   $("#companyauto").removeAttr('readonly');
                   $("#companyauto").val('');
             }
        });
    
          $('.company_slt').live("click", function() {  //on click 
                      
                     
                      
                      var sltholder='';
                      var sltcompany_multi ='';
                      var sltcount=0;
                      $('.company_slt').each(function() { //loop through each checkbox
                          
                          if(this.checked) {                              
                                var holder = $(this).data("title"); 
                                var slt_comp_id = $(this).val(); 
                               
//                                if(sltcount==0) { sltholder+=holder; sltcompany_multi+=slt_comp_id;  }
//                                else { sltholder+=","+holder;   sltcompany_multi+=","+slt_comp_id;  }

                             if(sltcount==0) { sltholder+=holder; sltcompany_multi+= "'"+slt_comp_id+"'"; }
                             else { sltholder+=","+holder;   sltcompany_multi+=",'"+slt_comp_id+"'"; }
                             
                             sltcount++;
                             $("#companyauto_load").show();
                              //sltuserscout++;
                          }
                          
                     });
                     
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
    
    ////////////// Company search start //////////////////////
    
   });
   
   
   
      function clear_companysearch(){
     $("#companyauto").removeAttr('readonly');  
     val='';
     $("#companyauto,#companysearch").val(val); 
     $("#companyauto_load").fadeOut();
     $("#com_clearall").fadeOut(); 
}  
</script>    

<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
	<div class="acc_container">
		<div class="block">
			<ul >
                            
<li class="ui-widget" style="position: relative"><h4>Company</h4>   

    <input type="text" id="companyauto" name="companyauto" value="<?php if($_POST['companysearch']!='') echo  $_POST['companyauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($_POST['companysearch']!='') echo "readonly='readonly'";  ?>>
    <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo stripslashes($_POST['companysearch']);?>" placeholder="" style="width:220px;">
     
    <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="<?php if($_POST['companysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span>
     
    <div id="companyauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
</li>


<li class="even">
    <h4>Location</h4>

 <SELECT name="location" id="location" style="font-family: Arial; color: #004646;font-size: 8pt">
    <OPTION  value="" selected> ALL </option>
        <?php
                $industrysql="SELECT DISTINCT  location FROM  angelco_fundraising_cos ";
                if ($industryrs = mysql_query($industrysql))
                {
                 $ind_cnt = mysql_num_rows($industryrs);
                }
                if($ind_cnt>0)
                {
                         While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                        {
                                
                                $name = $myrow['location'];
                                
                                if($location==$name)
                                    echo "<OPTION selected  value='$name' >$name</OPTION>";
                                else
                                   echo "<OPTION  value='$name' >$name</OPTION>";
                        }
                        mysql_free_result($industryrs);
                }
         ?></select>
</li>

<li class="odd">
    <h4>Raising Amount (US $ K)</h4>
    <?php if($_POST){ ?> 
    <input type="text" name="amount_from" id="amount_from" size="10" placeholder="From" value="<?php if(isset($_POST['amount_from'])) echo stripslashes($_POST['amount_from']);?>">
    <input type="text" name="amount_to"  id="amount_to" size="10" placeholder="To" value="<?php if(isset($_POST['amount_to'])) echo stripslashes($_POST['amount_to']);?>" style="margin-left: 15px;">
    <?php } else { ?>
    <input type="text" name="amount_from" id="amount_from" size="10" placeholder="From" value="10">
    <input type="text" name="amount_to"  id="amount_to" size="10" placeholder="To" value="<?php if(isset($_POST['amount_to'])) echo stripslashes($_POST['amount_to']);?>" style="margin-left: 15px;">
    <?php } ?> 
</li>

<li>
    	<input name="reset" id="resetall" class="reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
</li>
</ul>
       </div>
	</div>             
	
	
	