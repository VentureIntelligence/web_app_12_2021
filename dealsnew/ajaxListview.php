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
$companysql=  urldecode(stripslashes($_POST['sql']));
$vcflagValue=$_POST['vcflagvalue'];
$orderby=$_POST['orderby'];
$searchallfieldFlag = $_POST[ 'searchField' ];
$industryflag= $_POST['industry'];
$roundflag=$_POST['round'];
$companyflag=$_POST['company'];
$dealtypeflag=$_POST['dealtype'];
$syndicationflag=$_POST['syndication'];
$regionflag=$_POST['region'];
$cityflag=$_POST['city'];
$investortypeflag=$_POST['investortype'];
$startrangeflag=$_POST['startrange'];
$endrangeflag=$_POST['endrange'];
$exitflag=$_POST['exit'];
$valuationflag=$_POST['valuation'];
$investorflag=$_POST['investor'];
$companysearchflag=$_POST['companysearch'];
$sectorsearchflag=$_POST['sectorsearch'];
$legalAdvisorflag=$_POST['legalAdvisor'];
$transactionAdvisorflag=$_POST['transactionAdvisor'];
$tagsearchflag=$_POST['tagsearch'];
$listallcompany = $_POST['listallcompany'];

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

if($orderby=="amount")
    $orderby="hideamount,amount";

$ordertype=$_POST['ordertype'];

if($companysql!="" && $orderby!="" && $ordertype!="") {
    
    if($orderby=="sector_business")
        $orderstr="order by ".$orderby." ".$ordertype.","." i.industry ".$ordertype ;
    else
        $orderstr="order by ".$orderby." ".$ordertype;
    
    $companysql = $companysql . " ". $orderstr ;  
}
//echo $companysql;
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
    <thead>
        <tr>
            <?php 
            if( $searchallfieldFlag != '' || $industryflag!='' || $roundflag!='' || $companyflag!='' || $dealtypeflag!='' || $syndicationflag!='' || $regionflag!='' || $cityflag!='' || $investortypeflag!='' || $startrangeflag!='' || $endrangeflag!='' || $exitflag!='' || $valuationflag!='' || $investorflag!='' || $companysearchflag!='' || $sectorsearchflag!='' || $legalAdvisorflag!='' || $transactionAdvisorflag!='' || $tagsearchflag!='' ) {

                if(count($uncheckArray) == 0){ 

                    $allchecked= 'checked'; 
                }
                
                if($_POST['full_uncheck_flag']!='' && $_POST['full_uncheck_flag'] ==1 ){

                    $allchecked='';
                } 
                ?>
                <th class=""><input type="checkbox" class="all_checkbox" id="all_checkbox" <?php echo $allchecked; ?>/></th>
            <?php } ?>
                <th style="width: 22%;" class="header <?php echo ($orderby=="companyname")?$ordertype:""; ?>" id="companyname">Company</th>
                <th style="width: 34%;" class="header <?php echo ($orderby=="sector_business")?$ordertype:""; ?>" id="sector_business">Sector</th>
                <th style="width: 16%;" class="header <?php echo ($orderby=="Investor")?$ordertype:""; ?>" id="investor">investor</th>
                <th style="width: 10%;" class="header <?php echo ($orderby=="dates")?$ordertype:""; ?>" id="dates">Date</th>
                <th style="width: 10%;" class="header <?php echo ($orderby=="Exit_Status")?$ordertype:""; ?>" id="Exit_Status">Exit Status</th>
                <th style="width: 8%;" class="alignr header <?php echo ($orderby=="amount" ||$orderby=="hideamount,amount")?$ordertype:""; ?>" id="amount">Amount</th>
        </tr>
    </thead>
    <tbody id="movies">
    <?php
    if ($company_cnt>0)
    {
        $hidecount=0;  $hideBracketRow = false; 
        mysql_data_seek($companyrs,0);
        //Code to add PREV /NEXT
        $totaldet=0;
        
        while($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
        {
            $hideFlagset = 0;
            //SPV changed to AggHide
            $amtTobeDeductedforAggHide=0;
            $hidecount=0;
            $prd=$myrow["dealperiod"];

            // if ($myrow["AggHide"] == 1 || $myrow["SPV"] == 1) {
            //     $hideBracketRow = true;
            // } else {
            //     $hideBracketRow = false;
            // }

            
            if($myrow["AggHide"]==1)
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
            
            if($myrow["SPV"]==1)          //Debt
            {
                $openDebtBracket="[";
                $closeDebtBracket="]";
                $hideFlagset = 1;
            }
            else
            {
                $openDebtBracket="";
                $closeDebtBracket="";
            }
            
            if(trim($myrow[17])=="")
            {
                $compDisplayOboldTag="";
                $compDisplayEboldTag="";
            }
            else
            {
                $compDisplayOboldTag="<b><i>";
                $compDisplayEboldTag="</b></i>";
            }
            
            if($myrow["hideamount"]==1)
            {
                $hideamount="--";
                $hidecount=$hidecount+1;
            }
            else
            {
                $hideamount=$myrow["amount"];
            }
            
            if($myrow["amount"]==0)
            {
               $NoofDealsCntTobeDeducted=1;
            }
            
            if(($vcflagValue==0)||($vcflagValue==1))
            {
                if(trim($myrow["sector_business"])=="")
                    $showindsec=$myrow["industry"];
                else
                    $showindsec=$myrow["sector_business"];
            }

            $companyName=trim($myrow["companyname"]);
            $companyName=strtolower($companyName);
            $compResult=substr_count($companyName,$searchString);
            $compResult1=substr_count($companyName,$searchString1);

            if($myrow["Exit_Status"]==1){
                $exitstatus_name = 'Unexited';
            }
            else if($myrow["Exit_Status"]==2){
                $exitstatus_name = 'Partially Exited';
            }
            else if($myrow["Exit_Status"]==3){
                $exitstatus_name = 'Fully Exited';
            }
            else{
                $exitstatus_name = '--';
            }
            
             if( $searchallfieldFlag != '' || $industryflag!='' || $roundflag!='' || $companyflag!='' || $dealtypeflag!='' || $syndicationflag!='' || $regionflag!='' || $cityflag!='' || $investortypeflag!='' || $startrangeflag!='' || $endrangeflag!='' || $exitflag!='' || $valuationflag!='' || $investorflag!='' || $companysearchflag!='' || $sectorsearchflag!='' || $legalAdvisorflag!='' || $transactionAdvisorflag!='' || $tagsearchflag!='' ) {
            /* echo "ddddddddddd". count($uncheckArray);
             print_r($uncheckArray);
             echo "ccccc". count($checkedArray);
             echo ($checkedArray[0]);*/
                //=============================================junaid===========================================
                if(count($uncheckArray) > 0 && $uncheckArray[0]!='' &&  count($checkedArray) > 0 && $checkedArray[0]!=''){

                    if( (in_array( $myrow["PEId"], $uncheckArray )) ) {
                        $checked = '';
                        $rowClass = 'event_stop';
                    } 
                    elseif( (in_array( $myrow["PEId"], $checkedArray )) ) {
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
                    
                }elseif(count($uncheckArray) > 0 && $uncheckArray[0]!=''){

                    if( (in_array( $myrow["PEId"], $uncheckArray )) ) {
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
                                  
                    if( (in_array( $myrow["PEId"], $checkedArray )) ) {
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
                ?>
		                                    
                                  
                    <tr class="details_link <?php echo $rowClass; ?>" <?php if ($hideBracketRow == true && $listallcompany != 1) {echo "style='display:none';";}?> valueId="<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?>">
                                         
                    <td><input type="checkbox" data-deal-amount="<?php echo $myrow[ 'amount' ]; ?>" data-deal-inramount="<?php echo $myrow["Amount_INR"]; ?>" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow[ 'PECompanyId' ]; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["PEId"];?>" /></td>
                    <?php } 
                    
                    if(($compResult==0) && ($compResult1==0))
                    { ?>
                    
                        <td style="width: 22%;"><?php echo $openDebtBracket;?><?php echo $openBracket ; ?><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo trim($myrow["companyname"]);?>  </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
                    <?php }else{ ?>
                        
                        <td style="width: 22%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo ucfirst("$searchString");?></a></td>
                    <?php } ?>

                        <td style="width: 34%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo trim($showindsec); ?></a></td>
                        <td style="width: 16%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $myrow["Investor"]; ?></a></td>
                        <td style="width: 10%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $prd; ?></a></td>
                        <td style="width: 10%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $exitstatus_name; ?>&nbsp;</a></td>
                        <td style="width: 8%; text-align: right;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo $hideamount; ?>&nbsp;</a></td>

                </tr>
    <?php
        }
    }
?>
    </tbody>
</table>
<script>
   
$('input').iCheck({
    checkboxClass: 'icheckbox_flat-red',
    radioClass: 'iradio_flat-red'
});

$( '.pe_checkbox' ).on( 'ifChanged', function(event) {
            
    var amountChnage = true;
    var peuncheckCompdId = $( event.target ).val();
    var peuncheckAmount = $(event.target).data('deal-amount');
    var peuncheckCompany = $( event.target ).data( 'company-id' );
    var pehideFlag = $(event.target).data('hide-flag');
    var total_invdeal = $("#real_total_inv_deal").val();
    var total_invcompany = $("#real_total_inv_company").val();

    if( peuncheckAmount == '--' || pehideFlag == 1 ) {
        amountChnage = false;
    } else {
        peuncheckAmount = parseFloat( $(event.target).data('deal-amount') );
    }

    var cur_val = $("#pe_checkbox_disbale").val();
    var cur_val1 = $("#hide_company_array").val();
    var cur_va2 = $("#pe_checkbox_enable").val();

    var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');

    if( $( event.target ).prop('checked') ) {

        $(event.target).parents('.details_link').removeClass('event_stop');
        if( cur_va2 != '' ) {
            $('#pe_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
            $('#export_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );

        } else {
            $('#pe_checkbox_enable').val( peuncheckCompdId );
            $('#export_checkbox_enable').val( peuncheckCompdId );

        }
        var strArray = cur_val.split(',');
        for( var i = 0; i < strArray.length; i++ ) {
            if ( strArray[i] === peuncheckCompdId ) {
                strArray.splice(i, 1);
            }
        }
        $('#pe_checkbox_disbale').val( strArray );
        $('#txthidepe').val( strArray );

        var strArray1 = cur_val1.split(',');
        for( var i = 0; i < strArray1.length; i++ ) {
            if ( strArray1[i] === peuncheckCompdId ) {
                strArray1.splice(i, 1);
            }
        }
        if( pehideFlag == 1 ) {

            $( '#hide_company_array' ).val( strArray1 );
        }

        updateCountandAmount( peuncheckAmount, 'add', amountChnage, pehideFlag, total_invdeal);
        updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag,total_invcompany );
    }else {

        $(event.target).parents('.details_link').addClass('event_stop');

        var strArray2 = cur_va2.split(',');
        for( var i = 0; i < strArray2.length; i++ ) {
            if ( strArray2[i] === peuncheckCompdId ) {
                strArray2.splice(i, 1);
            }
        }
        $('#pe_checkbox_enable').val( strArray2 );
        $('#export_checkbox_enable').val( strArray2 );

        if( cur_val != '' ){
            $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
            $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
        }else{
            $('#pe_checkbox_disbale').val( peuncheckCompdId );
            $('#txthidepe').val( peuncheckCompdId );
        }
        if( pehideFlag == 1 ) {

            if( cur_val1 != '' ) {
                $('#hide_company_array').val( cur_val1 + "," + peuncheckCompdId );
            } else {
                $('#hide_company_array').val( peuncheckCompdId );
            }

        }
        updateCountandAmount( peuncheckAmount, 'remove', amountChnage, pehideFlag,total_invdeal);
        updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag,total_invcompany );
    }

    });

    $( '.all_checkbox' ).on( 'ifChanged', function(event) {

if( $( event.target ).prop('checked') ) {

    $( '#pe_checkbox_company' ).val($("#array_comma_company").val());

    $( '#show-total-deal span.res_total' ).text( $("#real_total_inv_deal").val() );
    $( '#show-total-amount h2 span' ).text($("#real_total_inv_amount").val() );
    $( '#show-total-inr-amount h2 span' ).text($("#real_total_inv_inr_amount").val() );
    $( '#show-total-deal span.comp_total' ).text($("#real_total_inv_company").val());
    $( '#pe_checkbox_disbale' ).val('');

    $( '#total_inv_deal' ).val($("#real_total_inv_deal").val());
    $( '#total_inv_amount' ).val($("#real_total_inv_amount").val());
    $( '#total_inv_inr_amount' ).val($("#real_total_inv_inr_amount").val());
    $( '#total_inv_company' ).val($("#real_total_inv_company").val());
    $( '#txthidepe' ).val('');
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
    $( '#hide_company_array' ).val('');
    $( '#export_checkbox_enable' ).val('');
    $( '#pe_checkbox_disbale').val('');
    $( '#show-total-deal span.res_total' ).text( 0 );
    $( '#show-total-amount h2 span' ).text(0 );
    $( '#show-total-inr-amount h2 span' ).text(0 );
    $( '#show-total-deal span.comp_total' ).text(0);
    $( '#total_inv_deal' ).val('0');
    $( '#total_inv_amount' ).val('0');
    $( '#total_inv_inr_amount' ).val('0');
    $( '#total_inv_company' ).val('0');
    $( '#all_checkbox_search' ).val('1');
    $( '#export_full_uncheck_flag' ).val('1');
    $( '#expshowdeals').hide();

    $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

       $(this).parents('.details_link').addClass('event_stop');
       $(this).prop('checked',false);
    });
    $('.icheckbox_flat-red').removeClass('checked');
}
});
     $(document).ready(function(){

        $('input.listall').on('ifToggled', function(event){
          var list=$("#Listall").val();
          console.log(list);
         $list1=$('.listhidden').val(list);
         
         $(".datesubmit").trigger('click');

        });
           $(".listall").parent().removeClass();
           $(".listall").removeAttr('style');
           $('.include label div').css("display","inline-block");
           $('.include input').css("vertical-align","middle");

        });
</script>
	<?php

						mysql_close();
    mysql_close($cnx);
						?>
