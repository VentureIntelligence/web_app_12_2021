<?php
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 $searchString="Undisclosed";
 $searchString=strtolower($searchString);
 $searchString1="Unknown";
 $searchString1=strtolower($searchString1);

//Company Sector
$searchString="Undisclosed";
$searchString=strtolower($searchString);

$searchString1="Unknown";
$searchString1=strtolower($searchString1);

$searchString2="Others";
$searchString2=strtolower($searchString2);
$company_cntall=$_POST['totalrecords'];
$companysql=  urldecode($_POST['sql']);
$vcflagValue=$_POST['vcflagvalue'];
$orderby=$_POST['orderby'];
$ordertype=$_POST['ordertype'];
$searchallfieldFlag = $_POST[ 'searchField' ];
$industryFlag = $_POST[ 'industry' ];
$statusFlag = $_POST[ 'status' ];
$incfirmtypeFlag = $_POST[ 'incfirmtype' ];
$followonFlag = $_POST[ 'followon' ];
$regionIdFlag = $_POST[ 'regionId' ];
$cityFlag = $_POST[ 'city' ];
$investorFlag = $_POST[ 'investor' ];
$companyFlag = $_POST[ 'company' ];
$tagsearchFlag = $_POST[ 'tagsearch' ];

if(!isset($_SESSION['UserNames']))
        {
                header('Location:../pelogin.php');
        }
        else
        {
//==============================junaid===========================
if(!empty($_POST[ 'uncheckRows' ])){
    
$uncheckRows = $_POST[ 'uncheckRows' ];
$uncheckArray = explode( ',', $uncheckRows );
}else{
    $uncheckArray=[];
}

if(!empty($_POST[ 'checkedRow' ])){
    
    $checkedRow = $_POST[ 'checkedRow' ];
    $checkedArray = explode( ',', $checkedRow );
}else{
    $checkedArray=[];
}
//==============================================================
if($companysql!="" && $orderby!="" && $ordertype!="") {
    if($orderby=="sector_business")
        $orderstr="order by ".$orderby." ".$ordertype.","." i.industry ".$ordertype ;
    else
        $orderstr="order by ".$orderby." ".$ordertype;
    $companysql = $companysql . " ". $orderstr ;  
        
}
if($company_cntall > 0)
{
 $rec_limit = 50;
 $rec_count = $company_cntall;

if( isset($_POST['page']) )
{
   
  $currentpage=$_POST['page']-1;
  $page = $_POST['page']-1;
  $offset = $rec_limit * $page ;
}
else
{
   $currentpage=1;
   $page = 1;
   $offset = 0;
}
 $left_rec = $rec_count - ($page * $rec_limit);
 $companysqlwithlimit=$companysql." limit $offset, $rec_limit";
 if ($companyrs = mysql_query($companysqlwithlimit))
 {
     $company_cnt = mysql_num_rows($companyrs);
 }
             //$searchTitle=" List of Deals";
}
else
{
     $searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
     $notable=true;
     writeSql_for_no_records($companysql,$emailid);
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
                <?php 
                    if( $searchallfieldFlag != '' || $industryflag!='' || $statusFlag!='' || $incfirmtypeFlag!='' || $followonFlag!='' || $regionIdFlag!='' || $cityFlag!='' ||$investorFlag!='' || $companyFlag!='' ||$tagsearchFlag!='') {

                        if(count($uncheckArray) == 0){ 

                           $allchecked= 'checked'; 

                        }
                       if($_POST['full_uncheck_flag']!='' && $_POST['full_uncheck_flag'] ==1 ){

                           $allchecked='';
                       } 

                ?>
                    <th class=""><input type="checkbox" class="all_checkbox" id="all_checkbox" <?php echo $allchecked; ?>/></th>
                <?php
                    }
                ?>
                 <th class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname" >Incubatee</th>
                <th class="header <?php echo ($orderby=="Incubator")?$ordertype:""; ?>" id="Incubator" >Incubator</th>
                <th class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                <th class="header <?php echo ($orderby=="date_month_year")?$ordertype:""; ?>" id="date_month_year">Date</th>
               </tr></thead>
              
              <tbody id="movies">
                     <?php
                        if ($company_cnt>0)
                          {
                                $hidecount=0;
                                //Code to add PREV /NEXT
                                mysql_data_seek($companyrs,0);
                                While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                                {
                                    $hideFlagset = 0;
                                    if($myrow["Individual"]==1)
                                    {
                                            $openBracket="(";
                                            $closeBracket=")";
                                            $hideFlagset = 1;
                                    }
                                    else
                                    {
                                            $openBracket="";
                                            $closeBracket="";
                                    }
                                    if(trim($myrow["sector_business"])=="")
                                            $showindsec=$myrow["industry"];
                                    else
                                            $showindsec=$myrow["sector_business"];
                                    $incubatorname=$myrow["Incubator"];
                                    $companyName=trim($myrow["companyname"]);
                                    $companyName=strtolower($companyName);
                                    $compResult=substr_count($companyName,$searchString);
                                    $compResult1=substr_count($companyName,$searchString1);

                                    if($myrow['date_month_year']!='0000-00-00'){
                                    $date = date('M-Y', strtotime($myrow['date_month_year']));
                                    }else{
                                    $date ='-';
                                    }
                                //=============================================junaid===========================================
                                    if(count($uncheckArray) > 0 && $uncheckArray[0]!='' &&  count($checkedArray) > 0 && $checkedArray[0]!=''){


                                            if( (in_array( $myrow["IncDealId"], $uncheckArray )) ) {
                                                    $checked = '';
                                      $rowClass = 'event_stop';

                                            } 
                                            elseif( (in_array( $myrow["IncDealId"], $checkedArray )) ) {
                                                    $checked = 'checked';
                                                    $rowClass = '';

                                            } 
                                            elseif($_POST['full_uncheck_flag']==1){
                                                $checked = '';
                                                $rowClass = 'event_stop';
                                            }
                                            elseif($_POST['full_uncheck_flag']==''){
                                                $rowClass = '';
                                                $checked = 'checked';
                                            }


                                    }
                                    elseif(count($uncheckArray) > 0 && $uncheckArray[0]!=''){

                                        if( (in_array( $myrow["IncDealId"], $uncheckArray )) ) {
                                            $checked = '';
                                            $rowClass = 'event_stop';

                                        }elseif($_POST['full_uncheck_flag']==1){

                                            $checked = '';
                                            $rowClass = 'event_stop';

                                    } else {
                                                $checked = 'checked';
                                      $rowClass = '';
                                    }

                                    }elseif(count($checkedArray) > 0 && $checkedArray[0]!=''){

                                        if( (in_array( $myrow["IncDealId"], $checkedArray )) ) {
                                            $checked = 'checked';
                                            $rowClass = '';

                                        }elseif($_POST['full_uncheck_flag']==1){

                                                    $checked = '';
                                            $rowClass = 'event_stop';

                                                  } else {
                                                    $checked = 'checked';
                                            $rowClass = '';
                                                  }

                                    }elseif($_POST['full_uncheck_flag']==1){

                                        $checked = '';
                                        $rowClass = 'event_stop';

                                    }elseif($_POST['full_uncheck_flag']=='' && count($uncheckArray) <= 1 && count($checkedArray) <= 1){

                                        $rowClass = '';
                                        $checked = 'checked';
                                    }
                                 //=================================================================================================  

                           ?>           <tr class="details_link <?php echo $rowClass; ?>" valueId="<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?>">
                                             <?php 
                                                if( $searchallfieldFlag != '' || $industryflag!='' || $statusFlag!='' || $incfirmtypeFlag!='' || $followonFlag!='' || $regionIdFlag!='' || $cityFlag!='' ||$investorFlag!='' || $companyFlag!='' ||$tagsearchFlag!='') {
                                                  
                                            ?>
                                            <td><input type="checkbox" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'companyid' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["IncDealId"];?>" /></td>
                                            <?php
                                                }
                                            ?>
                                            
                                <?php
                                                if(($compResult==0) && ($compResult1==0))
                                                {

                                ?>
                                                <td ><?php echo $openBracket ; ?><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?></td>
                                <?php
                                                }
                                                else
                                                {
                                ?>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo ucfirst("$searchString");?></a></td>
                                <?php
                                                }
                                ?>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($incubatorname); ?></a></td>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($showindsec); ?></a></td>
                                                <td><a class="postlink" href="incdealdetails.php?value=<?php echo $myrow["IncDealId"];?>/<?php echo $vcflagValue;?> "><?php echo trim($date); ?></a></td>

                                        </tr>
                                                <!--</tbody>-->
                                        <?php
                                        }
                                }
                            }
                                ?>
        </tbody>
    </table>
    <script type="text/javascript">
      $('input').iCheck({
          checkboxClass: 'icheckbox_flat-red',
          radioClass: 'iradio_flat-red'
      });
     /* $( '.pe_checkbox' ).on( 'ifChanged', function(event) {
          var peuncheckCompdId = $( event.target ).val();
          var peuncheckCompany = $( event.target ).data( 'company-id' );
          var pehideFlag = $(event.target).data('hide-flag');
          var cur_val = $("#pe_checkbox_disbale").val();
          var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');
          if( $( event.target ).prop('checked') ) {
              $(event.target).parents('.details_link').removeClass('event_stop');
              var strArray = cur_val.split(',');
              for( var i = 0; i < strArray.length; i++ ) {
                  if ( strArray[i] === peuncheckCompdId ) {
                      strArray.splice(i, 1);
                  }
              }
              $('#pe_checkbox_disbale').val( strArray );
              $('#txthidepe').val( strArray );
              updateCountandAmount( 'add', pehideFlag );
              updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag );
          } else {
              $(event.target).parents('.details_link').addClass('event_stop');
              if( cur_val != '' ) {
                  $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
                  $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
              } else {
                  $('#pe_checkbox_disbale').val( peuncheckCompdId );
                  $('#txthidepe').val( peuncheckCompdId );
              }
              updateCountandAmount( 'remove', pehideFlag );
              updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag );
          }
          
      });*/
    
        $( '.pe_checkbox' ).on( 'ifChanged', function(event) {

        var peuncheckCompdId = $( event.target ).val();
        var peuncheckCompany = $( event.target ).data( 'company-id' );
        var pehideFlag = $(event.target).data('hide-flag');
        var total_invdeal = $("#real_total_inv_deal").val(); //junaid
        var total_invcompany = $("#real_total_inv_company").val();//junaid

        var cur_val = $("#pe_checkbox_disbale").val();
        var cur_val1 = $("#hide_company_array").val();//junaid
        var cur_va2 = $("#pe_checkbox_enable").val();//junaid

        var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');
        if( $( event.target ).prop('checked') ) {

            $(event.target).parents('.details_link').removeClass('event_stop');

            //------------------------------junaid--------------------------------
                if( cur_va2 != '' ) {
                    $('#pe_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
                    $('#export_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );

                } else {
                    $('#pe_checkbox_enable').val( peuncheckCompdId );
                    $('#export_checkbox_enable').val( peuncheckCompdId );

                }
            //----------------------------------------------------------------------------------

            var strArray = cur_val.split(',');
            for( var i = 0; i < strArray.length; i++ ) {
                if ( strArray[i] === peuncheckCompdId ) {
                    strArray.splice(i, 1);
                }
            }
            $('#pe_checkbox_disbale').val( strArray );
            $('#txthidepe').val( strArray );

            //------------------------------junaid--------------------------------
                var strArray1 = cur_val1.split(',');
                for( var i = 0; i < strArray1.length; i++ ) {
                    if ( strArray1[i] === peuncheckCompdId ) {
                        strArray1.splice(i, 1);
                    }
                }
                if( pehideFlag == 1 ) {
                    $( '#hide_company_array' ).val( strArray1 );
                }
           //--------------------------------------------------------------     
            updateCountandAmount( 'add', pehideFlag , total_invdeal);
            updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag,total_invcompany );
        } else {

            $(event.target).parents('.details_link').addClass('event_stop');

            //------------------------------junaid--------------------------------   
                var strArray2 = cur_va2.split(',');
                for( var i = 0; i < strArray2.length; i++ ) {
                    if ( strArray2[i] === peuncheckCompdId ) {
                        strArray2.splice(i, 1);
                    }
                }
                   $('#pe_checkbox_enable').val( strArray2 );
                   $('#export_checkbox_enable').val( strArray2 );
            //-------------------------------------------------------------- 

            if( cur_val != '' ) {
                $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
                $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
            } else {
                $('#pe_checkbox_disbale').val( peuncheckCompdId );
                $('#txthidepe').val( peuncheckCompdId );
            }
        //------------------------------jagadeesh rework--------------------------------     
            if( pehideFlag == 1 ) {
                if( cur_val1 != '' ) {
                    $('#hide_company_array').val( cur_val1 + "," + peuncheckCompdId );
                } else {
                    $('#hide_company_array').val( peuncheckCompdId );
        }
            }
        //---------------------------------------------------------------
            updateCountandAmount( 'remove', pehideFlag , total_invdeal );
            updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag ,total_invcompany);
        }

    });

    //------------------------------junaid--------------------------------

        $( '.all_checkbox' ).on( 'ifChanged', function(event) {

            if( $( event.target ).prop('checked') ) {

               $( '#pe_checkbox_company' ).val($("#array_comma_company").val());

               $( '.result-count .result-no span.res_total' ).text( $("#real_total_inv_deal").val() );
               $( '.result-count .result-no span.comp_total' ).text($("#real_total_inv_company").val());
               $( '#pe_checkbox_disbale' ).val('');

               $( '#total_inv_deal' ).val($("#real_total_inv_deal").val());
                $( '#total_inv_company' ).val($("#real_total_inv_company").val());

                $( '#pe_checkbox_enable' ).val('');
                $( '#export_checkbox_enable' ).val('');
                $( '#all_checkbox_search' ).val('');
                $( '#export_full_uncheck_flag' ).val('');
                $( '#hide_company_array' ).val('');

                $( '#expshowdeals').show();

                $('.pe_checkbox').each(function(){ //iterate all listed checkbox items
                   $(this).prop("checked",true);
                   $(this).parents('.details_link').removeClass('event_stop');
                   $(this).parents('.icheckbox_flat-red').addClass('checked');
               });

            }else{

                $(event.target).parents('.details_link').addClass('event_stop');
                $( '#pe_checkbox_company' ).val('');
                $( '#pe_checkbox_enable' ).val('');
                $( '#export_checkbox_enable' ).val('');
                $( '#pe_checkbox_disbale').val('');
                $( '.result-count .result-no span.res_total' ).text('0');
                $( '.result-count .result-no span.comp_total' ).text('0');
                $( '#total_inv_deal' ).val('0');
                $( '#total_inv_amount' ).val('0');
                $( '#total_inv_company' ).val('0');
                $( '#all_checkbox_search' ).val('1');
                $( '#export_full_uncheck_flag' ).val('1');
                $( '#hide_company_array' ).val('');
                $( '#expshowdeals').hide();

               $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

                   $(this).parents('.details_link').addClass('event_stop');
                   $(this).prop('checked',false);
               });
               $('.icheckbox_flat-red').removeClass('checked');

            }
       });
   //---------------------------------------------------------------------------------------
    </script>
<?php function writeSql_for_no_records($sqlqry,$mailid)
    {
    $write_filename="pe_query_no_records.txt";
    //echo "<Br>***".$sqlqry;
            $schema_insert="";
            //TRYING TO WRIRE IN EXCEL
            //define separator (defines columns in excel & tabs in word)
                    $sep = "\t"; //tabbed character
                    $cr = "\n"; //new line

                    //start of printing column names as names of MySQL fields

                           print("\n");
                            print("\n");
                    //end of printing column names
                                   $schema_insert .=$cr;
                                   $schema_insert .=$mailid.$sep;
                                   $schema_insert .=$sqlqry.$sep;
                                   $schema_insert = str_replace($sep."$", "", $schema_insert);
                       $schema_insert .= ""."\n";

                                   if (file_exists($write_filename))
                                   {
                                           //echo "<br>break 1--" .$file;
                                            $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
                                                    if($fp)
                                                    {//echo "<Br>-- ".$schema_insert;
                                                           fwrite($fp,$schema_insert);    //    Write information to the file
                                                             fclose($fp);  //    Close the file
                                                           // echo "File saved successfully";
                                                    }
                                                    else
                                                           {
                                                           echo "Error saving file!"; }
                                   }

            print "\n";

    }
    mysql_close();
    mysql_close($cnx)
 ?>