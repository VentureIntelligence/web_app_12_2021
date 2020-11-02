 <script>
    $(function(){
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
<?php if($vcflagValue==0 || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
        {
            $stagesql_search = "select StageId,Stage from stage ";
        }
        elseif( $vcflagValue ==1)
        {
                 $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
        }
        ?>
        <h2 class="acc_trigger helptag" ><a href="#" style="display: inline-block;">Tag Search</a>
                <!-- <span class="helplineTag helplinetagicon" style=""> 
                        <a href="#popup6" class="help-icon1 tooltip tagpopup"><i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
                            <span >
                                
                                <img class="showtextlarge" src="images/callout.gif" style="left: 50px;">
                                    Tag List
                            </span>
                        </a>
                </span>  -->
                </h2> 
  <div  class="acc_container tag" style="display: none;">
    <div class="block">

<ul > 

            <?php if($_POST['tagsearch']){
                $tagauto = $_POST['tagsearch'];            
            } ?>
            <li class="ui-widget ">
               <input type="hidden" id="tagsearch" name="tagsearch" value="<?php echo  $tagsearch;  ?>" placeholder="" style="width:220px;">
            <input type="text" id="tagsearch_auto" name="tagsearch_auto" value="<?php echo  $tagkeyword;  ?>" placeholder="" style="width:220px;"> 
           
            <input type="hidden" id="tagradio" name="tagradio" value="<?php if($tagandor!=''){echo $tagandor;}else {echo 0;}?>" placeholder="" style="width:220px;"> 
</li>
    <li class="tagpadding">
         <div class="btn-cnt"> 
               <!--  <label class="optname">Option</label> -->
                <div class="switchtag-and-or"> 
                     <input type="radio" id="and" value="0" name="tagandor" class="hidden-field" checked="checked"/><span class="custom radio "></span>
                    <input type="radio" value="1" id="or" name="tagandor" class="hidden-field"/><span class="custom radio "></span>
                    <label for="and" class="cb-enable "><span>AND</span></label>
                    <label for="or" class="cb-disable"><span>OR</span></label>
                </div>
            </div>
            <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul>
  </div>
    </div>
    <span class="helplineTag helplinetagicon" style="position: absolute;
    top: 0;
    right: 35px;
"> 
                        <a href="#popup6" class="help-icon1 tooltip tagpopup"><i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
                            <span style="right: 0% !important;width: 55px;box-shadow: 2px 1px 3px 0px rgba(255, 255, 255, 0.5);padding-right: 10px;">
                                
                                <img class="showtextlarge" src="images/callout.gif" style="left: 40px;">
                                TAG LIST
                            </span>
                        </a>
                </span> 

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
</SELECT></li>
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
<?php
}
?>
</li>
<?php
if($vcflagValue==0 || $vcflagValue==1 ||$vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
{
?>
<li class="even"><h4>Round</h4>
  <select name="round" onchange="this.form.submit();" id="round">
            <OPTION id=0 value="--" <?php if($round == "--") echo 'selected'; ?>> Select Round </option>
                <option id="1" value="seed" <?php if($round == "seed") echo 'selected'; ?>>Seed</option>
                <?php
                    $j=1;
                    if($vcflagValue==0){
                        $seed=13;
                    }else{
                        $seed=5;
}
                    for($i=1; $i<$seed; $i++) {
                        $j++;
                        if($round == $i)
                            echo '<option id="'.$j.'" value="'.$i.'" selected>'.$i.'</option>';
                        else
                          echo '<option id="'.$j.'" value="'.$i.'">'.$i.'</option>';  
                    }
                    if($vcflagValue==0){
                        
?>
                
                    <option id="1" value="Open Market Transaction" <?php if($round == "Open Market Transaction") echo 'selected'; ?>>Open Market Transaction</option>
                    <option id="1" value="Preferential Allotment" <?php if($round == "Preferential Allotment") echo 'selected'; ?>>Preferential Allotment</option>
                    <option id="1" value="Special Situation" <?php if($round == "Special Situation") echo 'selected'; ?>>Special Situation</option> 
              <?php } ?>
        </select>
</li>
<?php } ?>
<li>
<input type="button" name="fliter_stage" value="Filter" onclick="document.pesearch.submit();">
</li>
<li class="even"><h4>Investor Type</h4>
    
    <SELECT NAME="invType" onchange="this.form.submit();" id="invType">
       <OPTION id="5" value="" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table */
            $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
            if ($invtypers = mysql_query($invtypesql)){
               $invtype_cnt = mysql_num_rows($invtypers);
            }
            if($invtype_cnt >0){
              While($myrow=mysql_fetch_array($invtypers, MYSQL_BOTH)){
                  $id = $myrow["InvestorType"];
                  $name = $myrow["InvestorTypeName"];
          $isselcted = ($_POST['invType']==$id) ? 'SELECTED' : "";
                  echo "<OPTION id=".$id. " value='".$id."' ".$isselcted.">".$name."</OPTION> \n";
              }
            mysql_free_result($invtypers);
          }
    ?>
</SELECT>
</li>
<?php if($dealvalue == 102){ ?>
<li class="even"><h4>Investors Headquarters</h4>
        <select name="country" id="country" onchange="cascadingCountry(this);">
            <option value=""></option>
            <option value="IN" <?php if($countrytxt == 'IN') { echo "selected"; }?>>India</option>
            <option value="NIN" <?php if($countrytxt == 'NIN') { echo "selected"; }?>>Non-India</option>
        </select>
</li>
        <li class="even forCountry" <?php if($countrytxt == "" || $countrytxt != "NIN") { echo 'style="display:none;"';}?>><h4>Select Country</h4>
        <select name="countryNIN[]" multiple id="countryNIN" >
               <?php
                //$countrysql = "SELECT DISTINCT (peinvestors.countryid),country.country from peinvestors JOIN country on country.countryid=peinvestors.countryid ORDER BY country ASC";
                if($vcflagValue == 4 || $vcflagValue == 5 || $vcflagValue == 3){
                    $countrysql = "SELECT DISTINCT(inv.countryid),cou.country
                    FROM peinvestments_investors AS peinv, peinvestments AS pe, pecompanies AS pec, peinvestors AS inv, peinvestments_dbtypes AS pedb,country AS cou
                    WHERE pe.PECompanyId = pec.PECompanyId
                    AND peinv.PEId = pe.PEId
                    AND inv.InvestorId = peinv.InvestorId
                    AND pedb.PEId = pe.PEId
                    AND inv.countryid = cou.countryid
                    AND pedb.DBTypeId = '$dbtype'
                    ORDER BY cou.country";
                } else {
                    $countrysql = "SELECT DISTINCT (peinvestors.countryid),country.country from peinvestors JOIN country on country.countryid=peinvestors.countryid ORDER BY country ASC";
                }
                if ($countryrs = mysql_query($countrysql))
                {
                    $ind_cnt = mysql_num_rows($countryrs);
                }
                if($ind_cnt > 0)
                {
                  While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
                  {
                    $id = $myrow[0];
                    $name = $myrow[1];
                    
                    if($id != "IN" && $id != "10" && $id != "11" && $id != "" && $id != "--" ){ 
                        $indSel = (in_array($id,$countryNINidList))?'selected':'';
                        
                        ?>
                        
                        <option value="<?php echo $id; ?>" id="country_<?php echo $id; ?>" <?php echo $indSel; ?>><?php echo $name; ?> </option>
                    <?php } else { ?>
                        
                    <?php } 
                  }
                    mysql_free_result($countryrs);
                }
            ?>
        </select>
        </li>
        <li class="even forCity" <?php if($countrytxt == "" || $countrytxt != "IN") { echo 'style="display:none;"';}?>><h4>Select City</h4>
        <select name="city[]" multiple id="city">
            <?php
                $citysql = "select distinct(c.city_name),c.city_id from city as c GROUP BY c.city_name ORDER BY c.city_name ASC";
                if ($cityrs = mysql_query($citysql))
                {
                    $ind_cnt = mysql_num_rows($cityrs);
                }
                if($ind_cnt > 0)
                {
                  While($myrow=mysql_fetch_array($cityrs, MYSQL_BOTH))
                  {
                    $name = $myrow[0];
                    $id = $myrow[1];
                    if(count($city)>0){ 
                        $indSel = (in_array($id,$cityid))?'selected':''; 
                        $name =ucwords(strtolower($name));
                        echo "<OPTION id='city_".$id. "' value=".$id." ".$indSel.">".$name."</OPTION> \n";  
                    } else {
                        echo "<option value=".$id.">".$name."</option>\n";
                    }
                  }
                    mysql_free_result($cityrs);
                }
            ?>
        </select>
        </li>
        <?php }?>
<!-- For Firm Type -->
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
<li class="odd range-to"><h4>Deal Range (US $ M)</h4>
    <SELECT name="invrangestart" id="invrangestart"><OPTION id=4 value="--" selected>ALL  </option>
  <?php
        $counter=0;
            
            if($vcflagValue==1 || $vcflagValue==3)
            {
                for ( $counter = 0; $counter <= 20; $counter += 1){
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
    }
            }
           else
            {
                for ( $counter = 0; $counter <= 100; $counter += 1){
                    
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
        }
            }
        ?> 
</select>
<span class="range-text"> to</span>
<SELECT name="invrangeend" id="invrangeend" onchange="this.form.submit();"><OPTION id=0.5 value="--" selected>ALL  </option>
  <?php
        $counter=0;
           
            if($vcflagValue==1 || $vcflagValue==3)
            {
                if($_POST['invrangeend']!='')
                {
                    $counterto = "0.5";
                    $isselcted = (($_POST['invrangeend']==$counterto."")) ? 'SELECTED' : "";             
                    echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                }
                else
                {
                    $counterto = "0.5";
                    $exprg = explode("-", $getrg);
                    $erg = $exprg[1];
                    $isselcted = (($erg==$counterto."")) ? 'SELECTED' : "";             
                    echo "<OPTION id=".$counterto. " value=".$counterto." ".$isselcted.">".$counterto."</OPTION> \n";
                }
                for ( $counterto = 1; $counterto <= 20; $counterto += 1){
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
    }
            }
            else
            {
                for ( $counterto = 5; $counterto <= 2000; $counterto += 1){
                    
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
        }
            }
        ?> 
</select>
</li>

<li class="odd range-to" style="display:none;"><h4>Dates Between</h4>
    <SELECT NAME=month1 id="tour_month1" style="font-family: Arial; color: #004646;font-size: 8pt">
       <OPTION id=1 value="--" selected> Month </option>
       <OPTION VALUE=1 <?php echo ($_POST['month1']=='1') ? 'Selected' : ''; ?>>Jan </OPTION>
       <OPTION VALUE=2 <?php echo ($_POST['month1']=='2') ? 'Selected' : ''; ?>>Feb</OPTION>
       <OPTION VALUE=3 <?php echo ($_POST['month1']=='3') ? 'Selected' : ''; ?>>Mar</OPTION>
       <OPTION VALUE=4 <?php echo ($_POST['month1']=='4') ? 'Selected' : ''; ?>>Apr</OPTION>
       <OPTION VALUE=5 <?php echo ($_POST['month1']=='5') ? 'Selected' : ''; ?>>May</OPTION>
       <OPTION VALUE=6 <?php echo ($_POST['month1']=='6') ? 'Selected' : ''; ?>>Jun</OPTION>
       <OPTION VALUE=7 <?php echo ($_POST['month1']=='7') ? 'Selected' : ''; ?>>Jul</OPTION>
       <OPTION VALUE=8 <?php echo ($_POST['month1']=='8') ? 'Selected' : ''; ?>>Aug</OPTION>
       <OPTION VALUE=9 <?php echo ($_POST['month1']=='9') ? 'Selected' : ''; ?>>Sep</OPTION>
       <OPTION VALUE=10 <?php echo ($_POST['month1']=='10') ? 'Selected' : ''; ?>>Oct</OPTION>
       <OPTION VALUE=11 <?php echo ($_POST['month1']=='11') ? 'Selected' : ''; ?>>Nov</OPTION>
      <OPTION VALUE=12 <?php echo ($_POST['month1']=='12') ? 'Selected' : ''; ?>>Dec</OPTION>
      </SELECT>
        <SELECT NAME=year1 id="tour_year1" style="font-family: Arial; color: #004646;font-size: 8pt">
        <OPTION id=2 value="--" selected> Year </option>
        <?php
                                $currentyear = date("Y");
        $i=1998;
        While($i<= $currentyear )
        {
                                    $id = $currentyear;
                                    $name = $currentyear;
                                    if ($_POST['year1'])
                                        $selected = ($_POST['year1']==$currentyear) ? 1 : 0;

                                    if ($selected)
                                    {
                                            echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
                                    }
                                    else
                                    {
                                            echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
                                    }
                                    $currentyear--;
        }
        ?> </SELECT>
      <SELECT NAME=month2 id="tour_month2" style="font-family: Arial; color: #004646;font-size: 8pt">
       <OPTION id=3 value="--" selected> Month </option>
       <OPTION VALUE=1 <?php echo ($_POST['month2']=='1') ? 'Selected' : ''; ?>>Jan</OPTION>
       <OPTION VALUE=2 <?php echo ($_POST['month2']=='2') ? 'Selected' : ''; ?>>Feb</OPTION>
       <OPTION VALUE=3 <?php echo ($_POST['month2']=='3') ? 'Selected' : ''; ?>>Mar</OPTION>
       <OPTION VALUE=4 <?php echo ($_POST['month2']=='4') ? 'Selected' : ''; ?>>Apr</OPTION>
       <OPTION VALUE=5 <?php echo ($_POST['month2']=='5') ? 'Selected' : ''; ?>>May</OPTION>
       <OPTION VALUE=6 <?php echo ($_POST['month2']=='6') ? 'Selected' : ''; ?>>Jun</OPTION>
       <OPTION VALUE=7 <?php echo ($_POST['month2']=='7') ? 'Selected' : ''; ?>>Jul</OPTION>
       <OPTION VALUE=8 <?php echo ($_POST['month2']=='8') ? 'Selected' : ''; ?>>Aug</OPTION>
       <OPTION VALUE=9 <?php echo ($_POST['month2']=='9') ? 'Selected' : ''; ?>>Sep</OPTION>
       <OPTION VALUE=10 <?php echo ($_POST['month2']=='10') ? 'Selected' : ''; ?>>Oct</OPTION>
       <OPTION VALUE=11 <?php echo ($_POST['month2']=='11') ? 'Selected' : ''; ?>>Nov</OPTION>
       <OPTION VALUE=12 <?php echo ($_POST['month2']=='12') ? 'Selected' : ''; ?>>Dec</OPTION>
      </SELECT>
      <SELECT name=year2 id="tour_year2" style="font-family: Arial; color: #004646;font-size: 8pt">
      <OPTION id=4 value="--" selected> Year </option>

      <?php
                        $currentyear2 = date("Y");
      $endYear=1998;
      While($endYear<= $currentyear2 )
      {
        $ids=$currentyear2;
                                if ($_POST['year2'])
                                    $selected = ($_POST['year2']==$currentyear2) ? 1 : 0;
                                

                                if ($selected)
        {
          echo "<OPTION id=". $currentyear2. "value=". $currentyear2." selected>".$currentyear2."</OPTION>\n";
        }
        else
        {
          echo "<OPTION id=". $currentyear2. "value=". $currentyear2." >".$currentyear2."</OPTION>\n";
        }

      $currentyear2--;
      }
      ?> 
                        </SELECT>
</li>

<?php 
/*if($dealvalue==101){?>
<li class="ui-widget"><h4>Investor</h4>
<SELECT id="keywordsearch" NAME="keywordsearch">
       <OPTION id="5" value="" selected> ALL </option>
        <?php
           /* populating the investortype from the investortype table ///////////////////////////////////////////////
            $searchStrings="Undisclosed";
            $searchStrings=strtolower($searchStrings);

            $searchStrings1="Unknown";
            $searchStrings1=strtolower($searchStrings1);

            $searchStrings2="Others";
            $searchStrings2=strtolower($searchStrings2);

            $getInvestorSqls="SELECT DISTINCT inv.InvestorId, inv.Investor,pec.sector_business
                            FROM peinvestments AS pe, pecompanies AS pec, peinvestments_investors AS peinv, peinvestors AS inv, stage AS s
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND s.StageId = pe.StageId
                            AND pec.industry !=15
                            AND peinv.PEId = pe.PEId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 " .$addVCFlagqry. " group by inv.Investor ";

            if ($rsinvestors = mysql_query($getInvestorSqls)){
            $investors_cnts = mysql_num_rows($rsinvestors);
            }

            if($investors_cnts >0){
                
                mysql_data_seek($rsinvestor ,0);
                While($myrows=mysql_fetch_array($rsinvestors, MYSQL_BOTH)){
                       $Investornames=trim($myrows["Investor"]);
                                       $Investornames=strtolower($Investornames);

                                       $invResults=substr_count($Investornames,$searchStrings);
                                       $invResults1=substr_count($Investornames,$searchStrings1);
                                       $invResults2=substr_count($Investornames,$searchStrings2);

                                       if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
                                               $investors = $myrows["Investor"];
                                               $investorsId = $myrows["InvestorId"];
                                               //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                               $isselcted = (trim($_POST['keywordsearch'])==trim($investors)) ? 'SELECTED' : '';
                                               echo "<OPTION value='".$investors."' ".$isselcted.">".$investors."</OPTION> \n";
                                       }
                }
                mysql_free_result($rsinvestors);
            }
        ?>
</SELECT>
</li>
<?php 
}
elseif($dealvalue==102){?>
<li class="ui-widget"><h4>Company</h4>
<SELECT id="companysearch" NAME="companysearch">
       <OPTION id="5" value="" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table ////////////////////////////////////////////////////////////////
    $searchStrings="Undisclosed";
      $searchStrings=strtolower($searchStrings);
    
      $searchStrings1="Unknown";
      $searchStrings1=strtolower($searchStrings1);
    
      $searchStrings2="Others";
      $searchStrings2=strtolower($searchStrings2);
                        if($vcflagValue==0 || $vcflagValue==1)
                         {  
                         $getcomapnySqls="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                         FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                         WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                         AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ORDER BY pec.companyname ";
                         }
                         elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
                         {
                             $getcomapnySqls="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                             FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                             stage AS s ,peinvestments_dbtypes as pedb
                                             WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                             and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                             AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                             AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ORDER BY pec.companyname";
                         }
                         elseif($vcflagValue==7 || $vcflagValue==8)
                         {
                             $getcomapnySqls="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                     FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                                     WHERE pec.PECompanyId = pe.PEcompanyId 
                                                     AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                     AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ORDER BY pec.companyname";

                         }
                         elseif($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
                         {
                             $getcomapnySqls="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                             FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r
                                             WHERE pec.PECompanyId = pe.PEcompanyId 
                                             AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                             AND r.RegionId = pec.RegionId " .$addVCFlagqry." ORDER BY pec.companyname";

                         }
        
            if ($rscompany= mysql_query($getcomapnySqls)){
               $company_cnts = mysql_num_rows($rscompany);
            }
      
            if($company_cnts >0){
                 mysql_data_seek($rscompany ,0);
               While($myrows=mysql_fetch_array($rscompany, MYSQL_BOTH)){
                  $comnames=trim($myrows["companyname"]);
                        $comnames=strtolower($comnames);

                        $invResults=substr_count($comnames,$searchStrings);
                        $invResults1=substr_count($comnames,$searchStrings1);
                        $invResults2=substr_count($comnames,$searchStrings2);

                        if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
                                $company = $myrows["companyname"];
                                $companyId = $myrows["PECompanyId"];
                                //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
                                $isselcted = (trim($_POST['companysearch'])==trim($company)) ? 'SELECTED' : '';
                                echo "<OPTION value='".$company."' ".$isselcted.">".$company."</OPTION> \n";
                        }
              }
            mysql_free_result($rscompany);
          }
    ?>
</SELECT>
</li>

<?php
}
elseif($dealvalue==103){?>
    
<li class="ui-widget"><h4>Legal Advisor</h4>
<SELECT id="advisorsearch_legal" NAME="advisorsearch_legal">
       <OPTION id="6" value="" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table ////////////////////////////////////////////////////////
    $searchStrings="Undisclosed";
      $searchStrings=strtolower($searchStrings);
    
      $searchStrings1="Unknown";
      $searchStrings1=strtolower($searchStrings1);
    
      $searchStrings2="Others";
      $searchStrings2=strtolower($searchStrings2);
      
            if($vcflagValue==0 || $vcflagValue==1)
            { 
                $getadvisorSqls="(
        SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
        peinvestments_advisorinvestors AS adac, stage as s
        WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
        " AND c.PECompanyId = pe.PECompanyId
        AND adac.CIAId = cia.CIAID and AdvisorType='L'
        AND adac.PEId = pe.PEId)
        UNION (
        SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
        peinvestments_advisorcompanies AS adac, stage as s
        WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
        " AND c.PECompanyId = pe.PECompanyId
        AND adac.CIAId = cia.CIAID and AdvisorType='L'
        AND adac.PEId = pe.PEId ) order by Cianame  ";
            }
            elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
            {
                $getadvisorSqls="(
        SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
        WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
        " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
        AND adac.CIAId = cia.CIAID and AdvisorType='L'
        AND adac.PEId = peinv.PEId)
        UNION (
        SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
        peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
        WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
        " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
        AND adac.CIAId = cia.CIAID and AdvisorType='L'
        AND adac.PEId = peinv.PEId ) order by Cianame";
            }
            elseif($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
            {
                $getadvisorSqls="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                        WHERE Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID  and AdvisorType='L'
                        AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                        " )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
                        WHERE Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID and AdvisorType='L'
                        AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                        " ) ORDER BY Cianame";
                
            }
            
            if ($rsadvisor = mysql_query($getadvisorSqls)){
               $advisor_cnts = mysql_num_rows($rsadvisor);
            }
      
            if($advisor_cnts >0){
                 mysql_data_seek($rsadvisor ,0);
               While($myrows=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                  $Investornames=trim($myrows["Cianame"]);
          $Investornames=strtolower($Investornames);

          $invResults=substr_count($Investornames,$searchStrings);
          $invResults1=substr_count($Investornames,$searchStrings1);
          $invResults2=substr_count($Investornames,$searchStrings2);
          
          if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
            $ladvisor = $myrows["Cianame"];
            $investorsId = $myrows["CIAId"];
            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
            $isselcted = (trim($_POST['advisorsearch_legal'])==trim($ladvisor)) ? 'SELECTED' : '';
            echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
          }
              }
            mysql_free_result($invtypers);
          }
    ?>
</SELECT>
</li>
<?php 
}
elseif($dealvalue==104){?><li class="ui-widget"><h4>Transaction Advisor</h4>
<SELECT id="advisorsearch_trans" NAME="advisorsearch_trans">
       <OPTION id="6" value="" selected> ALL </option>
         <?php
            /* populating the investortype from the investortype table ////////////////////////////////////////////////////////////
            $searchStrings="Undisclosed";
            $searchStrings=strtolower($searchStrings);

            $searchStrings1="Unknown";
            $searchStrings1=strtolower($searchStrings1);

            $searchStrings2="Others";
            $searchStrings2=strtolower($searchStrings2);
      if($vcflagValue==0 || $vcflagValue==1)
            { 
                $getadvisorSqls="(
        SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
        peinvestments_advisorinvestors AS adac, stage as s
        WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
        " AND c.PECompanyId = pe.PECompanyId
        AND adac.CIAId = cia.CIAID and AdvisorType='T'
        AND adac.PEId = pe.PEId)
        UNION (
        SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
        peinvestments_advisorcompanies AS adac, stage as s
        WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
        " AND c.PECompanyId = pe.PECompanyId
        AND adac.CIAId = cia.CIAID and AdvisorType='T'
        AND adac.PEId = pe.PEId ) order by Cianame  ";
            }
            elseif($vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5)
            {
                $getadvisorSqls="(
        SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
        WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
        " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
        AND adac.CIAId = cia.CIAID and AdvisorType='T'
        AND adac.PEId = peinv.PEId)
        UNION (
        SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
        FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
        peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
        WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
        " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
        AND adac.CIAId = cia.CIAID and AdvisorType='T'
        AND adac.PEId = peinv.PEId ) order by Cianame";
            }
            elseif($vcflagValue==9 ||$vcflagValue==10 || $vcflagValue==11)
            {
                $getadvisorSqls="(
                        SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                        WHERE Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adac.CIAId = cia.CIAID  and AdvisorType='T'
                        AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                        " )
                        UNION (
                        SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, acquirers AS ac
                        WHERE Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID and AdvisorType='T'
                        AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                        " ) ORDER BY Cianame";
            }
            if ($rsadvisor = mysql_query($getadvisorSqls)){
               $advisor_cnts = mysql_num_rows($rsadvisor);
            }
      
            if($advisor_cnts >0){
                 mysql_data_seek($rsadvisor ,0);
               While($myrows=mysql_fetch_array($rsadvisor, MYSQL_BOTH)){
                  $Investornames=trim($myrows["Cianame"]);
          $Investornames=strtolower($Investornames);

          $invResults=substr_count($Investornames,$searchStrings);
          $invResults1=substr_count($Investornames,$searchStrings1);
          $invResults2=substr_count($Investornames,$searchStrings2);
          
          if(($invResults==0) && ($invResults1==0) && ($invResults2==0)){
            $ladvisor = $myrows["Cianame"];
            $investorsId = $myrows["CIAId"];
            //echo "<OPTION value=".$investorId.">".$investor."</OPTION> \n";
            $isselcted = (trim($_POST['advisorsearch_trans'])==trim($ladvisor)) ? 'SELECTED' : '';
            echo "<OPTION value='".$ladvisor."' ".$isselcted.">".$ladvisor."</OPTION> \n";
          }
              }
            mysql_free_result($invtypers);
          }
    ?>
</SELECT>
</li>
<?php }*/ ?>

<li class="ui-widget" style="position: relative"><h4>City (OF TARGET COMPANY)</h4>
    <input type="hidden" id="cityauto" name="cityauto" value="<?php if($city!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($city!='') echo "readonly='readonly'";  ?>>
    <input type="text" id="citysearch" name="citysearch" value="<?php if(isset($city)) echo  $city;  ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
     
    <!-- <span id="com_clearall" title="Clear All" onclick="clear_companysearch();" style="<?php if($_POST['citysearch']=='') echo 'display:none;';  ?>background: #BFA074;  position: absolute;  top: 29px;  right: 30px;  padding: 3px;">(X)</span> -->
     
    <div id="cityauto_load" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;  width: 223px;">
        
    </div>
     
</li>
    <li>
      <input type="button" name="fliter_stage" value="Filter" onclick="document.pesearch.submit();">
    </li>
</ul>
                    </div>
  </div>
  
  <h2 class="acc_trigger <?php if($showdealsbyflag==1){ ?> showdeal <?php } ?>"><a href="#">Show directory by</a></h2>
  <div  class="acc_container " style="display: none;">
    <div class="block">
<ul >
<?php 

if($vcflagValue!=7 && $vcflagValue!=8){
    
if($dealvalue!=101){?>
<li class="ui-widget"><h4>Investor</h4>
    <input type="text" id="investorauto" name="investorauto" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">
</li>
<?php }if($dealvalue!=102){?>
<li class="ui-widget"><h4>Company</h4>
    <input type="text" id="companyauto" name="companyauto" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="" style="width:220px;">
</li>
<?php }?>
<li class="ui-widget"><h4>Sector</h4>
    <input type="text" id="sectorauto" name="sectorauto" value="<?php if(isset($_POST['sectorsearch'])) echo  $_POST['sectorsearch'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="sectorsearch" name="sectorsearch" value="<?php if(isset($_POST['sectorsearch'])) echo  $_POST['sectorsearch'];  ?>" placeholder="" style="width:220px;">
</li>
<?php
if($dealvalue!=103){?>
<li class="ui-widget"><h4>Legal Advisor</h4>
    <input type="text" id="advisorsearch_legalauto" name="advisorsearch_legalauto" value="<?php if(isset($_POST['advisorsearch_legal'])) echo  $_POST['advisorsearch_legal'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="advisorsearch_legal" name="advisorsearch_legal" value="<?php if(isset($_POST['advisorsearch_legal'])) echo  $_POST['advisorsearch_legal'];  ?>" placeholder="" style="width:220px;">
</li>
<?php }if($dealvalue!=104){?>
<li class="ui-widget"><h4>Transaction Advisor</h4>
    <input type="text" id="advisorsearch_transauto" name="advisorsearch_transauto" value="<?php if(isset($_POST['advisorsearch_trans'])) echo  $_POST['advisorsearch_trans'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="advisorsearch_trans" name="advisorsearch_trans" value="<?php if(isset($_POST['advisorsearch_trans'])) echo  $_POST['advisorsearch_trans'];  ?>" placeholder="" style="width:220px;">
</li>
<?php }

} else{
    if($dealvalue!=101){?>
<li class="ui-widget"><h4>Investor</h4>
    <input type="text" id="investorauto" name="investorauto" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="keywordsearch" name="keywordsearch" value="<?php if(isset($_POST['keywordsearch'])) echo  $_POST['keywordsearch'];  ?>" placeholder="" style="width:220px;">
</li>
<?php }if($dealvalue!=102){?>
<li class="ui-widget"><h4>Company</h4>
    <input type="text" id="companyauto" name="companyauto" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="" style="width:220px;">
     <input type="hidden" id="companysearch" name="companysearch" value="<?php if(isset($_POST['companysearch'])) echo  $_POST['companysearch'];  ?>" placeholder="" style="width:220px;">
</li>
<?php }
    
}
?>
    <li><input name="reset" id="resetall" class="refine reset-btn" type="button" value="Reset" style="float: left;" />
        <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>

</ul></div>
  </div>
   <!-- <h2 class="acc_trigger helptag" ><a href="#" style="display: inline-block;">Tag Search</a>
               <span class="helplineTag helplinetagicon" style=""> 
                        <a href="#popup6" class="help-icon1 tooltip tagpopup"><i class="far fa-question-circle" style="color: #fff;background-image: none;"></i>
                            <span >
                                
                                <img class="showtextlarge" src="images/callout.gif" style="left: 50px;">
                                    Tag List
                            </span>
                        </a>
                </span> 
                </h2>
  <div  class="acc_container tag" style="display: none;">
    <div class="block">

<ul > 

            <?php //if($_POST['tagsearch']){
                //$tagauto = $_POST['tagsearch'];            
            //} ?>
            <li class="ui-widget ">
              
               <input type="hidden" id="tagsearch" name="tagsearch" value="<?php echo  $tagsearch;  ?>" placeholder="" style="width:220px;">
            <input type="text" id="tagsearch_auto" name="tagsearch_auto" value="<?php echo  $tagkeyword;  ?>" placeholder="" style="width:220px;"> 
              
            <input type="hidden" id="tagradio" name="tagradio" value="<?php if($tagandor!=''){echo $tagandor;}else {echo 0;}?>" placeholder="" style="width:220px;"> 
</li>
    <li class="tagpadding">
         <div class="btn-cnt"> 
                <div class="switchtag-and-or"> 
                     <input type="radio" id="and" value="0" name="tagandor" class="hidden-field" checked="checked"/><span class="custom radio "></span>
                    <input type="radio" value="1" id="or" name="tagandor" class="hidden-field"/><span class="custom radio "></span>
                    <label for="and" class="cb-enable "><span>AND</span></label>
                    <label for="or" class="cb-disable"><span>OR</span></label>
                </div>
            </div>
            <input type="button" name="fliter_stage" value="Filter" onclick="this.form.submit();" style="float: right;">
    </li>
    
</ul>
  </div>
    </div>
     -->