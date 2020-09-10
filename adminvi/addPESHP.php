<?php
require("../dbconnectvi.php");
    $Db = new dbInvestments();
    $fullString1 = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    $fullString=explode("/", $fullString1);
	$IPO_MandA_flag=$fullString[0];
	$ipmandid=$fullString[1];
    if($ipmandid==0)
    {   
        $IPO_MandAId= rand();
    }
    else
    {
        $IPO_MandAId=$ipmandid;    
    }

    // Main Table Values For Percentage
    $getMainTablesSql="select * from pe_shp where PEId=$IPO_MandAId limit 1";
    $mainTableValidate = mysql_query($getMainTablesSql);
    $Maintable_Valid_Count = mysql_num_rows($mainTableValidate);

    if($Maintable_Valid_Count != 0){
        $mainTable = mysql_fetch_array($mainTableValidate);
        $mainTable_ESOP = $mainTable['ESOP'];
        $mainTable_Others = $mainTable['Others'];
        $mainTable_investor_total = $mainTable['pe_shp_investor_total'];
        $mainTable_promoters_total = $mainTable['pe_shp_promoters_total'];
    }else{
        $mainTable_ESOP = "";
        $mainTable_Others = "";
        $mainTable_investor_total = "0";
        $mainTable_promoters_total = "0";
    }
    
    

    // End Main Table Values

    //on submission
    if($_POST['submit'])
    {
        $ipo_mandaflag=$_POST['txtpereflag'];
        $IPO_MandAId=$_POST['txtPEId'];
            
        if($IPO_MandAId>0)
        {

            $exitInvestor=$_POST['txtinvestor'];
            $txtinvestoramount=$_POST['txtinvestoramount'];
            $txtpromoters=$_POST['txtpromoters'];
            $txtpromotersamount=$_POST['txtpromotersamount'];

            if(in_array("0", $txtpromotersamount) || in_array("0", $txtinvestoramount) ){
                echo "<p style='text-align: center;
                    margin: 6px 0 6px 0;
                    color: red;
                    font-weight: 600;'>'Investor & Promoter' value cannot be zero or empty</p>";
            }else{
                if($_POST['txtesopamount'] != ""){
                    $txtesopamount=$_POST['txtesopamount'];
                    $txt_esopamount_valid = (double)$txtesopamount;
                }else{
                    $txtesopamount="--";
                    $txt_esopamount_valid = 0;
                }

                if($_POST['txtothersamount'] != ""){
                    $txtothersamount=$_POST['txtothersamount'];
                    $txt_othersamount_valid = (double)$txtothersamount;
                }else{
                    $txtothersamount="--";
                    $txt_othersamount_valid = 0;
                }

                // Count Array 
                $investor_count_total = count($exitInvestor);  
                $promoters_count_total = count($txtpromoters);
                // Investor Total Values
                if($investor_count_total != 0){
                    for($i=0; $i<$investor_count_total; $i++){
                        $investor_total += $txtinvestoramount[$i];
                    }
                }else{
                    $investor_total = 0;
                }

                // Promoter Total
                if($promoters_count_total !=0){
                    for($i=0; $i<$promoters_count_total; $i++)  
                    {
                        $promoters_total += $txtpromotersamount[$i];

                    }
                }else{
                    $promoters_total = 0;
                }
                // return_insert_total_values($investor_total, $promoters_total);
                $submission_percentage_validation_round = $investor_total + $promoters_total + $txt_esopamount_valid + $txt_othersamount_valid;
                //$valid_input_feild = $valid_input_feild.toFixed(2);
                //$valid_input_feild = number_format($valid_input_feild, 2); 
                $submission_percentage_validation = round($submission_percentage_validation_round, 2);
                if( $submission_percentage_validation == 100 ){
                    //Validate Added Datas Or New Datas 
                    $getInvestorsSHPSql=mysql_query("select * from pe_shp where PEId=$IPO_MandAId");
                    $check_getInvestorsSHPSql = mysql_num_rows($getInvestorsSHPSql);
                    if($check_getInvestorsSHPSql == 0){
                        // Insert Main Table
                        $pe_shp_insert = "insert into pe_shp (PEId,ESOP,Others,pe_shp_investor_total,pe_shp_promoters_total,created_at) values($IPO_MandAId,'$txtesopamount','$txtothersamount',$investor_total,$promoters_total,now())";
                        mysql_query($pe_shp_insert);
                        // Inserting Investor
                        if($investor_count_total > 0)  
                        {  
                            for($i=0; $i<$investor_count_total; $i++)  
                            {  
                                if(trim($exitInvestor[$i] != ''))  
                                {  
                                    $pe_shp_investor_insert = "insert into pe_shp_investor (PEId,investor_name,stake_held,created_at) values($IPO_MandAId,'$exitInvestor[$i]',$txtinvestoramount[$i],now())"; 
                                    mysql_query($pe_shp_investor_insert);
                                    
                                }  
                                
                            }  
                        }
                        // Inserting Promoters
                        if($promoters_count_total > 0)  
                        {  
                            for($i=0; $i<$promoters_count_total; $i++)  
                            {  
                                if(trim($txtpromoters[$i] != ''))  
                                {  
                                    $pe_shp_promoters_insert = "insert into pe_shp_promoters (PEId,promoters_name,stake_held,created_at) values($IPO_MandAId,'$txtpromoters[$i]',$txtpromotersamount[$i],now())";
                                    mysql_query($pe_shp_promoters_insert); 
                                }  
                            }  
                            // echo "Promoters Inserted";  
                        }
                
                        // Main Table Values For Percentage
                        $getMainTablesSql="select * from pe_shp where PEId=$IPO_MandAId limit 1";
                        $mainTableValidate = mysql_query($getMainTablesSql);
                        $Maintable_Valid_Count = mysql_num_rows($mainTableValidate);

                        if($Maintable_Valid_Count != 0){
                            $mainTable = mysql_fetch_array($mainTableValidate);
                            $mainTable_ESOP = $mainTable['ESOP'];
                            $mainTable_Others = $mainTable['Others'];
                            $mainTable_investor_total = $mainTable['pe_shp_investor_total'];
                            $mainTable_promoters_total = $mainTable['pe_shp_promoters_total'];
                        }else{
                            $mainTable_ESOP = "";
                            $mainTable_Others = "";
                            $mainTable_investor_total = "";
                            $mainTable_promoters_total = "";
                        }
                        echo "<p style='text-align: center;
                        margin-bottom: 0px;
                        color: #008000;
                        font-weight: 600;'>Inserted successfully</p>";
                    }
                    else if($check_getInvestorsSHPSql != 0){
                        //  Delete Previews Datas
                        $pe_shp_delete = mysql_query("delete from pe_shp where PEId=$IPO_MandAId");
                        $pe_shp_investor_delete = mysql_query("delete from pe_shp_investor where PEId=$IPO_MandAId");
                        $pe_shp_promoters_delete = mysql_query("delete from pe_shp_promoters where PEId=$IPO_MandAId");
                        // Insert Main Table
                        $pe_shp_insert = "insert into pe_shp (PEId,ESOP,Others,pe_shp_investor_total,pe_shp_promoters_total,created_at) values($IPO_MandAId,'$txtesopamount','$txtothersamount','$investor_total','$promoters_total',now())";
                        mysql_query($pe_shp_insert);
                            // Count Values
                            $investor_count = count($exitInvestor);  
                            $promoters_count = count($txtpromoters);

                            // Insert Investor 
                            if($investor_count > 0)  
                            {  
                                for($i=0; $i<$investor_count; $i++)  
                                {  
                                    if(trim($exitInvestor[$i] != ''))  
                                    {  
                                        $pe_shp_investor_insert = "insert into pe_shp_investor (PEId,investor_name,stake_held,created_at) values($IPO_MandAId,'$exitInvestor[$i]',$txtinvestoramount[$i],now())"; 
                                        mysql_query($pe_shp_investor_insert);
                                    }  
                                    
                                }  
                                // echo "Investor Inserted";
                            }

                            // Insert Promoter
                            if($promoters_count > 0)  
                            {  
                                for($i=0; $i<$promoters_count; $i++)  
                                {  
                                    if(trim($txtpromoters[$i] != ''))  
                                    {  
                                        $pe_shp_promoters_insert = "insert into pe_shp_promoters (PEId,promoters_name,stake_held,created_at) values($IPO_MandAId,'$txtpromoters[$i]',$txtpromotersamount[$i],now())";
                                        mysql_query($pe_shp_promoters_insert); 
                                    }  
                                }  
                                // echo "Promoters Inserted";  
                            }
                            // Main Table Values For Percentage
                            $getMainTablesSql="select * from pe_shp where PEId=$IPO_MandAId limit 1";
                            $mainTableValidate = mysql_query($getMainTablesSql);
                            $Maintable_Valid_Count = mysql_num_rows($mainTableValidate);

                            if($Maintable_Valid_Count != 0){
                                $mainTable = mysql_fetch_array($mainTableValidate);
                                $mainTable_ESOP = $mainTable['ESOP'];
                                $mainTable_Others = $mainTable['Others'];
                                $mainTable_investor_total = $mainTable['pe_shp_investor_total'];
                                $mainTable_promoters_total = $mainTable['pe_shp_promoters_total'];
                            }else{
                                $mainTable_ESOP = "";
                                $mainTable_Others = "";
                                $mainTable_investor_total = "";
                                $mainTable_promoters_total = "";
                            }
                            echo "<p style='text-align: center;
                            margin-bottom: 0px;
                            color: #008000;
                            font-weight: 600;'>Updated successfully</p>";
                    }
                }else{
                    echo "<p style='text-align: center;
                            margin: 6px 0 6px 0;
                            color: red;
                            font-weight: 600;'>SHP percentage value should be 100%</p>";
                }
            }
        }
    }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title></title>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<style>
.btn{
    -webkit-appearance: button;
    -webkit-writing-mode: horizontal-tb !important;
    text-rendering: auto;
    color: buttontext;
    letter-spacing: normal;
    word-spacing: normal;
    text-transform: none;
    text-indent: 0px;
    text-shadow: none;
    display: inline-block;
    text-align: center;
    align-items: flex-start;
    cursor: default;
    background-color: buttonface;
    box-sizing: border-box;
    margin: 0em;
    font: 400 13.3333px Arial;
    padding: 1px 6px;
    border-width: 2px;
    border-style: outset;
    border-color: buttonface;
    border-image: initial;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
</style>
<SCRIPT LANGUAGE="JavaScript">
    $(document).ready(function(){
       
    $("#mutiple_investor").on('click','.remCF',function(){
        $(this).parent().parent().parent().remove();
    });
    $("#mutiple_promotors").on('click','.remCF',function(){
        $(this).parent().parent().parent().remove();
    });

    });
function returnIPOId()
{
    $(".txthideamount:not(:checked)").each(function() {
        $(this).val(0);
        $(this).prop("checked", true);
	});
    $(".txtexcludedp:not(:checked)").each(function() {
        $(this).val(0);
        $(this).prop("checked", true);
	});
    $(".leadinvestor:not(:checked)").each(function()
    {
        $(this).val(0);
        $(this).prop("checked", true);
    });
    $(".newinvestor:not(:checked)").each(function() {
        $(this).val(0);
        $(this).prop("checked", true);
    });
      
    opener.document.adddeal.hideSHPId.value= document.shpexit.txtPEId.value;
	document.shpexit.action="addPESHP.php?value=<?php echo $fullString1; ?>";
	document.shpexit.submit();
}


function addMoreInvestorsRow(){
    var rowInvestorscount = $('#rowInvestorscount').val() + 1;
    var str = '<tr class="investorrow"><td valign=top> <input type="text" name="txtinvestor[]" id="txtinvestor" style="width:100%;"> </td>';
        str += '<td valign=top > <input type="number" name="txtinvestoramount[]" value="0.00" step="0.01" style="width:60px;"> % <span style="margin-left: 10px;float: right;margin-right: 10px;margin-top: 3px;"><a href="javascript:void(0);" class="remCF"> <i class="fa fa-trash" aria-hidden="true" style="color: #d21f1f;"></i> </a></span></td>';
        str += '</tr>';
    $('#rowInvestorscount').val(rowInvestorscount);
    $('#mutirow_investor').append(str);
    $( ".submitBtn" ).prop( "disabled", true );
}
function addMorePromotersRow(){
    var rowPromoterscount = $('#rowPromoterscount').val() + 1;
    var str = '<tr class="promotorrow"><td valign=top> <input type="text" name="txtpromoters[]" style="width:100%;"> </td>';
        str += '<td valign=top > <input type="number" name="txtpromotersamount[]" value="0.00" step="0.01" style="width:60px;"> %  <span style="margin-left: 10px;float: right;margin-right: 10px;margin-top: 3px;"><a href="javascript:void(0);" class="remCF"> <i class="fa fa-trash" aria-hidden="true" style="color: #d21f1f;"></i> </a></span></td>';
        str += '</tr>';
    $('#rowPromoterscount').val(rowPromoterscount);
    $('#mutirow_promoters').append(str);
    $( ".submitBtn" ).prop( "disabled", true );
}
function calculateValue(){
    // debugger;
    // Investor
    var investorMemberAmount = 1;
    var promoterMemberAmount = 1;
    var investor_cal_value = $('input[name="txtinvestoramount[]"]');
    var investor_count_total = investor_cal_value.length;  
    var investor_total = 0;
    if(investor_count_total >= 0){
        for(var i=0; i<investor_count_total; i++){
            var txtinvestoramount = $('input[name="txtinvestoramount[]"]')[i].value;
           if(txtinvestoramount == "" || txtinvestoramount == "0.00" || txtinvestoramount == 0){
                txtinvestoramount = 0;
                investorMemberAmount = 0;
            }

            investor_total += parseFloat(txtinvestoramount);
        }
    }else{
        investor_total = 0;
    }

    // Promoters
    var promoter_cal_value = $('input[name="txtpromotersamount[]"]');
    var promoter_count_total = promoter_cal_value.length;  
    var promoter_total = 0;
    if(promoter_count_total >= 0){
        for(var i=0; i<promoter_count_total; i++){
            var txtpromoteramount = $('input[name="txtpromotersamount[]"]')[i].value;
            if(txtpromoteramount == "" || txtpromoteramount == "0.00" || txtpromoteramount == 0){
                txtpromoteramount = 0;
                promoterMemberAmount = 0;
            }
            promoter_total += parseFloat(txtpromoteramount);
        }
    }else{
        promoter_total = 0;
    }
    var esop_cal_val = Number($('input[name="txtesopamount"]').val());
    var others_cal_val = Number($('input[name="txtothersamount"]').val());
    // Controlls
    var valid_input_feild = (investor_total + promoter_total) + (esop_cal_val + others_cal_val);
    valid_input_feild = valid_input_feild.toFixed(2);
    //alert(valid_input_feild);
    if(investorMemberAmount != 0 && promoterMemberAmount != 0){
        if(valid_input_feild == 100){
            $('#investor_total').empty();
            $('#investor_total').html((investor_total.toFixed(2))+"%");
            $('#promoters_total').empty();
            $('#promoters_total').html((promoter_total.toFixed(2))+"%");
            $('.submitBtn').removeAttr("disabled");
        }else{
            alert("SHP percentage value should be 100%");
            $( ".submitBtn" ).prop( "disabled", true );
        }
    }else{
        alert("'Investor & Promoter' value cannot be zero or empty");
        $( ".submitBtn" ).prop( "disabled", true );
    }
}

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
    <form name="shpexit" method="post" style="text-align: center !important;">
        <td><input type="text" name="txtPEId" size="50" READONLY value="<?php echo $IPO_MandAId; ?>"> </td>
        <td><input type="text" name="txtpereflag" size="50" READONLY value="<?php echo $IPO_MandA_flag; ?>"> </td>
        <?php $cnt=6; ?>
        <td>
            <table align=left id="mutiple_investor" style="width: 90%;
                padding: 0px;
                margin: 25px 0px 0px 25px;" border=1 cellpadding=1 cellspacing=0>
                <thead>
                    <tr>
                        <th colspan="2">Post Deal Shareholding Pattern (as if converted basis)</th>
                    </tr>
                    <tr>
                        <th style="width: 50%;">Shareholders</th>
                        <th> Stake held</th>
                    </tr>
                </thead>
                <tbody id="mutirow_investor">
                    <tr>
                        <td valign=top style="width: 50%;"><b>PE-VC Investors</b></td>
                        <td valign=top><span style="float:right;" id="investor_total"><?php echo $mainTable_investor_total; ?>%</span></td>
                    </tr>
                    <!-- Edit Investor -->
                    <?php
                        $getInvestorsSql="select * from pe_shp_investor where PEId=$IPO_MandAId ORDER BY id ASC";
                        if ($rsinvestors = mysql_query($getInvestorsSql))
                        {
                            $validate_investor = mysql_num_rows($rsinvestors);
                            if($validate_investor != 0){
                            $i=0;
                            While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                            {
                    ?>
                <tr class="investorrow">
                    <td valign=top> <input type="text" style="width:100%;" name="txtinvestor[]" value="<?php echo $myInvrow["investor_name"]; ?>"> </td>
                    <td valign=top > <input type="number" name="txtinvestoramount[]" step="0.01" value="<?php echo $myInvrow["stake_held"]; ?>" style="width:60px;"> % <span style="margin-left: 10px;float: right;margin-right: 10px;margin-top: 3px;"><a href="javascript:void(0);" class="remCF"> <i class="fa fa-trash" aria-hidden="true" style="color: #d21f1f;"></i>
 </a></span></td>
                    
                </tr>

                <?php
                    $i++;
                            }
                    }
                    }
                ?>
                <!-- End edit Investor -->
                    <!-- <tr>
                        <td valign=top> <input type="text" style="width:100%;" name="txtinvestor[]"> </td>
                        <td valign=top> <input type="text" name="txtinvestoramount[]" value="0.00" style="width:100%;"> </td>
                        <input type="hidden" name="rowInvestorscount" id="rowInvestorscount" value="0" />
                    </tr> -->
                    </tbody>
                    <tr >
                        <td valign=top> <input type="button" value="Add More" name="addmoreinvestors" onClick="addMoreInvestorsRow();" > </td>
                        <td valign=top> </td>
                    </tr>
            </table>
            <table align=left id="mutiple_promotors" border=1 cellpadding=1 cellspacing=0 style="width: 90%;
                padding: 0px;
                margin: 0px 0px 0px 25px;">
                <thead>
                    <tr>
                        <td valign=top style="width: 50%;"><b>Promoters</b></td>
                        <td valign=top><span style="float:right;" id="promoters_total"><?php echo $mainTable_promoters_total; ?>%</span></td>
                    </tr>
                </thead>
                <tbody id="mutirow_promoters">
                <?php
                        $getPromotorsSql="select * from pe_shp_promoters where PEId=$IPO_MandAId ORDER BY id ASC";
                        if ($rspromotors = mysql_query($getPromotorsSql))
                        {
                            $validate_promoters = mysql_num_rows($rspromotors);
                            if($validate_promoters != 0){
                            $i=0;
                            While($myProrow=mysql_fetch_array($rspromotors, MYSQL_BOTH))
                            {
                    ?>
                <tr class="promotorrow">
                        <td valign=top> <input type="text" name="txtpromoters[]" style="width:100%;" value="<?php echo $myProrow["promoters_name"]; ?>"> </td>
                        <td valign=top> <input type="number" name="txtpromotersamount[]" step="0.01" value="<?php echo $myProrow["stake_held"]; ?>" style="width:60px;"> %  <span style="margin-left: 10px;float: right;margin-right: 10px;margin-top: 3px;"><a href="javascript:void(0);" class="remCF"><i class="fa fa-trash" aria-hidden="true" style="color: #d21f1f;"></i>
</a></span></td>
                        
                    </tr>

                <?php
                    $i++;
                            }
                    }
                    }
                ?>
                
                    <!-- <tr>
                        <td valign=top> <input type="text" name="txtpromoters[]" style="width:100%;"> </td>
                        <td valign=top> <input type="text" name="txtpromotersamount[]" value="0.00" style="width:100%;"> </td>
                        <input type="hidden" name="rowPromoterscount" id="rowPromoterscount" value="0" />
                    </tr> -->
                </tbody>
                <tr>
                    <td valign=top> <input type="button" value="Add More" name="addmorepromoters" onClick="addMorePromotersRow();" > </td>
                    <td valign=top> </td>
                </tr>
            </table>
            <table align=left id="mutiple_investor_others" border=1 cellpadding=1 cellspacing=0 style="width: 90%;
                padding: 0px;
                margin: 0px 0px 0px 25px;">
                <tr>
                    <td valign=top style="width: 50%;"><b> ESOP </b></td>
                    <td valign=top> <input type="number" name="txtesopamount" step="0.01" style="width:94%;text-align:right;" value="<?php echo $mainTable_ESOP; ?>"> % </td>
                </tr>
                <tr>
                    <td valign=top><b> Others </b></td>
                    <td valign=top> <input type="number" name="txtothersamount" step="0.01" style="width:94%;text-align:right;" value="<?php echo $mainTable_Others; ?>"> % </td>
                </tr>
            </table>
            <table align=left border=1 cellpadding=1 cellspacing=0 style="width: 90%;
                padding: 0px;
                margin: 0px 0px 0px 25px;">
                <tr>
                   <td align=left>
                        <span class="btn" onClick="calculateValue();">Calculate</span>
                        <input type="submit" name="submit" class="submitBtn" value="Insert SHP" disabled/>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
<?php
function insert_Investment_Investors($exit_flag,$dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,$moreinfo,$investorOrder,$leadinvestor,$newinvestor)
{
	$dbexecmgmt = new dbInvestments();
	if($exit_flag=="PE")
	{
        $getDealInvSql="Select PEId,InvestorId,investorOrder from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";
        if($rsgetdealinvestor = mysql_query($getDealInvSql))
	    {
            $deal_invcnt=mysql_num_rows($rsgetdealinvestor);
            if($deal_invcnt==0)
            {
                $insDealInvSql="insert into peinvestments_investors (PEId,InvestorId,Amount_M,Amount_INR,hide_amount,exclude_dp,InvMoreInfo,investorOrder,leadinvestor,newinvestor) values($dealId,$investorId,$returnValue,$returnValueINR,$returnHideAmount,$invexp_dp,'$moreinfo','$investorOrder','$leadinvestor','$newinvestor')";
                if ($rsinsmgmt = mysql_query($insDealInvSql))
                {
                    echo "<br>PE Investor Inserted" ;
                    return true;
                }
            }
            
        }
        mysql_free_result($rsinsmgmt);
    }
}
/* inserts and return the investor id */
function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
                //insert acquirer
                $insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                                        $InvestorId = mysql_insert_id();
                    return $InvestorId;
                }
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$InvestorId = $myrow[0];
				//	echo "<br>Insert return investor id--" .$InvestorId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}
    function return_insert_get_Investor_edit($investor,$investor_id)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId != '$investor_id'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==0)
            {
                $insAcquirerSql="UPDATE peinvestors set Investor='$investor' where InvestorId ='$investor_id'";
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                    return $investor_id;
                }
            }else{
                $rsgetInvestorId1 = mysql_fetch_array($rsgetInvestorId);
                return $rsgetInvestorId1['InvestorId'];
            }
        }
        $dblink.close();
    }
    function return_insert_get_Investor_edit_update($investor,$investor_id)
    {
        $dblink= new dbInvestments();
        $investor=trim($investor);
        $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId = '$investor_id'";
        //echo "<br>select--" .$getInvestorIdSql;
        if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
        {
            $investor_cnt=mysql_num_rows($rsgetInvestorId);
            //echo "<br>Investor count-- " .$investor_cnt;
            if ($investor_cnt==1)
            {
                return $investor_id;
            }else{
                return '';
            }
        }else{
            return '';
        }
        $dblink.close();
    }
?>