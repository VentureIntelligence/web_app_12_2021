 <script>
    $(function(){
      $(".selectgroup select").multiselect();
        $("#city, #countryNIN").multiselect({ noneSelectedText: 'Select options', selectedList: 0}).multiselectfilter();
    });
    $(document).ready(function(){ 
 
     $("#firstrefine select, #firstrefine input").on('change',function(){
        $("#tagsearch").val("");
        $('#tagsearch_auto').val("");
    }); 
    $("#sltindustry, #round, #invType, #invrangeend, #followonVCFund, #exitedstatus, #txtregion").on('change',function(){
        $("#tagsearch").val("");
        $('#tagsearch_auto').val("");
        $("#pesearch").submit();
    });
  });
  $(function() {
    $( "#investorauto" ).autocomplete({
      source: function( request, response ) {
        $('#keywordsearch').val('');
        $.ajax({
            type: "POST",
          url: "ajaxInvestorDetails.php",
          dataType: "json",
          data: {
            vcflag: '<?php echo $vcflagValue; ?>',
            search: request.term,
            showallcompInvFlag:'<?php echo $showallcompInvFlag; ?>'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#keywordsearch').val(ui.item.value);
        $('#companysearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans,#tagsearch').val("");
         $('#companyauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto,#tagsearch_auto').val("");
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#keywordsearch').val()=="")
             $( "#investorauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    }); 
    
      $( "#companyauto" ).autocomplete({
      source: function( request, response ) {
        $('#companysearch').val('');
        $.ajax({
            type: "POST",
          url: "ajaxCompanyDetails.php",
          dataType: "json",
          data: {
            vcflag: '<?php echo $vcflagValue; ?>',
            search: request.term,
            showallcompInvFlag:'<?php echo $showallcompInvFlag; ?>'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#companysearch').val(ui.item.value);
       $('#keywordsearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans,#tagsearch').val("");
       $('#investorauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto,#tagsearch_auto').val("");
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if( $('#companysearch').val()=="")
             $( "#companyrauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
    
    $( "#sectorauto" ).autocomplete({
      source: function( request, response ) {
        $('#sectorsearch').val('');
        $.ajax({
            type: "POST",
          url: "ajaxSectorDetails.php",
          dataType: "json",
          data: {
            vcflag: '<?php echo $vcflagValue; ?>',
            search: request.term,
            showallcompInvFlag:'<?php echo $showallcompInvFlag; ?>'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#sectorsearch').val(ui.item.value);
        $('#keywordsearch,#companysearch,#advisorsearch_legal,#advisorsearch_trans,#tagsearch').val("");
         $('#investorauto,#companyauto,#advisorsearch_legalauto,#advisorsearch_transauto,#tagsearch_auto').val("");
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if( $('#sectorsearch').val()=="") 
             $( "#sectorauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
        ///////////// City Search autocomplete strats //////
    
     $( "#citysearch" ).autocomplete({
         
        source: function( request, response ) {
        //$('#citysearch').val('');
            $.ajax({
                type: "POST",
                url: "ajaxCitySearch.php",
                dataType: "json",
                data: {
                    vcflag: '<?php echo $VCFlagValue; ?>',
                    search: request.term
                },
                success: function( data ) {
                    response( $.map( data, function( item ) {
                        return {
                            label: item.label,
                            value: item.value,
                            id: item.id
                        }
                    }));
                }
            });
        },
        minLength: 1,
        select: function( event, ui ) {
         $('#citysearch').val(ui.item.value);
         $(this).parents("form").submit();
        },
        open: function() {
  //        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $('#citysearch').val()=="";
               //$( "#companyrauto" ).val('');  
  //        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
    
     $( "#advisorsearch_legalauto" ).autocomplete({
      source: function( request, response ) {
        $('#advisorsearch_legal').val('');
        $.ajax({
            type: "POST",
          url: "ajaxAdvisorDetails.php",
          dataType: "json",
          data: {
            vcflag: '<?php echo $vcflagValue; ?>',
            search: request.term,
            type :'L',
            peorvcflg:'<?php echo $peorvcflg; ?>'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#advisorsearch_legal').val(ui.item.value);
       $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_trans,#tagsearch').val("");
       $('#investorauto,#companyauto,#sectorauto,#advisorsearch_transauto,#tagsearch_auto').val("");
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if( $('#advisorsearch_legal').val()=="") 
             $( "#advisorsearch_legalauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
    $( "#advisorsearch_transauto" ).autocomplete({
      source: function( request, response ) {
        $('#advisorsearch_trans').val('');
        $.ajax({
            type: "POST",
          url: "ajaxAdvisorDetails.php",
          dataType: "json",
          data: {
            vcflag: '<?php echo $vcflagValue; ?>',
            search: request.term,
            type :'T',
            peorvcflg:'<?php echo $peorvcflg; ?>'
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
       $('#advisorsearch_trans').val(ui.item.value);
       $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_legal,#tagsearch').val("");
       $('#investorauto,#companyauto,#sectorauto,#advisorsearch_legalauto,#tagsearch_auto').val("");
//       $('#form').submit();
      },
      open: function() {
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if( $('#advisorsearch_trans').val()=="") 
             $( "#advisorsearch_transauto" ).val('');  
//        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });
    
    $("#resetall").click(function(){
        $('#keywordsearch,#companysearch,#sectorsearch,#advisorsearch_legal,#advisorsearch_trans').val("");
       $('#investorauto,#companyauto,#sectorauto,#advisorsearch_legalauto,#advisorsearch_transauto').val("");
    });
    
  });
 
  </script>
  <?php if($dealvalue == 102){?>
<style>
  .ui-multiselect-filter input {	
    width: 195px !important;	
}
</style>
<?php } ?>
  <style>
    .showtextlarge {
    border: 0 none;
    position: absolute;
    top: -9px;
    z-index: 20;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}
a.tooltip span {
    display: none;
    line-height: 20px;
    margin-left: 5px;
    padding: 10px 15px 7px 10px;
    z-index: 10;
    margin-top: 10px;
}

a.tooltip:hover span {
    font-size: 12px !important;
    font-weight: normal !important;
    display: inline;
    position: absolute;
    color: #111;
    border: 1px solid #DCA;
    background: #fffAF0;
}
  </style>

 

<h2 class="acc_trigger"><a href="#">Refine Search</a></h2>
  <div class="acc_container" id="firstrefine">
    <div class="block">
      <ul >
<li class="even"><h4>Industry</h4>
<select name="industry" onchange="industrypesearch();"    id="sltindustry">
      <OPTION id=0 value="" selected> ALL  </option>
    <?php
       $industrysql="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")  " . $hideIndustry ." order by industry";
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
                                                $isselcted = ($_POST['industry']==$id) ? 'SELECTED' : "";
            echo "<OPTION id=".$id. " value=".$id." ".$isselcted.">".$name."</OPTION> \n";
          }
          mysql_free_result($industryrs);
        }
        ?>
</SELECT>
</li>
<?php
if($vcflagValue==0 || $vcflagValue==1 ||$vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
{
?>

<li class="odd"><h4>Stage
     <span ><a href="#popup2" class="help-icon1 tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                             <span>
                                             <img class="callout1" src="images/callout.gif">
                                             Definitions
                                             </span>
     </a></span></h4>
<div class="selectgroup">
   
<select name="stage[]" multiple="multiple" size="5" id='stage'>
<?php
  $stagesql_search = "select StageId,Stage from stage ";
  if ($stagers = mysql_query($stagesql_search)){
      $stage_cnt = mysql_num_rows($stagers);
  }
  if($stage_cnt > 0){
            $i=1;
    While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH)){
      $id = $myrow[0];
      $name = $myrow[1];
      $isselect='';
      for($i=0;$i<count($_POST['stage']);$i++){
        $isselect = ($_POST['stage'][$i]==$id) ? "SELECTED" : $isselect;
      }
      echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
    }
     mysql_free_result($stagers);
  }
  
 ?>
</select> </div>

</li>

<li><h4>Firm Type</h4>
  <div class="selectgroup">
  
    <select name="firmtype[]" multiple="multiple" size="5" id="firmtype" >
       <!--  <option id=0 value="--"> All </option> -->
        <?php
            $firmtypesql = "select FirmTypeId,FirmType from firmtypes  ORDER BY FIELD(FirmTypeId,13,2,1,14,12,8,7,4,9,6,10,5,11,3)";

            if ($firmtypers = mysql_query($firmtypesql)) {
                $firmtype_cnt = mysql_num_rows($firmtypers);
                /*echo $firmtype_cnt;*/
            }
            if ($firmtype_cnt > 0) {
               $i=1;
                While ($myftrow = mysql_fetch_array($firmtypers, MYSQL_BOTH)) {
                    $id   = $myftrow[0];
                    $name = $myftrow[1];
                    $isselect='';

                    for($i=0;$i<count($_POST['firmtype']);$i++){
                      $isselect = ($_POST['firmtype'][$i]==$id) ? "SELECTED" : $isselect;
                      
                    }
                    echo '<OPTION value="'.$id.'" '.$isselect.'>'.$name.'</OPTION> \n';
                 
                }
                mysql_free_result($firmtypers);
            }
        ?>
    </select></div>
  </li>
  <?php
}
?>
<li>

<input type="button" name="fliter_stage" value="Filter" onclick="document.pesearch.submit();">
</li>

</ul>
                    </div>
  </div>
  
 