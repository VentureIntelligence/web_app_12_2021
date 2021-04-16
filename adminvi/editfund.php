<?php
//error_reporting(E_ALL); 
//ini_set( 'display_errors','1');
require("../dbconnectvi.php");
    $Db = new dbInvestments();  
    require("checkaccess.php");
  checkaccess( 'fund_raising' ); 
 session_save_path("/tmp");
 session_start();
 if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd")){
    $currentyear = date("Y");
    
            
    
    if ($_POST){
        $dbType             = 'PE';
        $investorId='';
        $fundnameId='';
        if($_POST['investoradd']!='') 
        {
            
            $sqlinv = "INSERT INTO `peinvestors` (`investor`) VALUES ('".$_POST['investoradd']."') ";
            $res = mysql_query($sqlinv) or die(mysql_error());
            $investorId = mysql_insert_id();
        }
       else{
           $investorId = $_POST['investor'];
       }
       
       if($_POST['fundNameadd']!='') 
        {
            
            $sqlfun = "INSERT INTO `fundNames` (`investorId`,`fundName`, `dbtype`) VALUES (".$investorId.",'".$_POST['fundNameadd']."', '$dbType') ";
            $funres = mysql_query($sqlfun) or die(mysql_error());
            $fundnameId = mysql_insert_id();
        }
       else{
           $fundnameId = $_POST['fundName'];
       }
        $fundId             = $_POST['id'];
        $fundMan            = $_POST['fundMan'];
        $fundTypStage       = $_POST['fundTypeStage'];
        $fundTypIndy        = $_POST['fundTypeIndustry'];
        $fundSize           = $_POST['size'];
        if( isset( $_POST[ 'amount_raised' ] ) && !empty( $_POST[ 'amount_raised' ] ) ) {
            $amount_raised = $_POST[ 'amount_raised' ];
        } else {
            $amount_raised = 0;
        }
        $fundStatus         = $_POST['fundStatus'];
        $fundCloseStatus    = $_POST['fundCloseStatus'];
         //$fundDate           = $_POST['date'];
        $fundDate           = "$_POST[year]-$_POST[month]-01";
        $capitalSource      = $_POST['capitalSource'];
        $moreInfo           = mysql_real_escape_string($_POST['moreInfo']);
        $source             = $_POST['source'];
       // $launchDate         = "$_POST[launchyear]-$_POST[launchmonth]-01";
       if($_POST['launchyear'] != 0 && $_POST['launchmonth'] != 0)
        {
         $launchDate         = "$_POST[launchyear]-$_POST[launchmonth]-01";
        }
        else
        {
        $launchDate ="";
        }

        if(($_POST['hideaggregate']))
       { $HideAggregate=1;
       }
       else
       { $HideAggregate=0;
       }
       
        
        //$sqlUpdate ="UPDATE `fundRaisingDetails` SET `launchDate`='$launchDate',`dbType` = '$dbType',`investorId` = '".$investorId."',`fundName` = '".$fundnameId."',`fundManager` = '".$fundMan."',`fundTypeStage` = '".$fundTypStage."',`fundTypeIndustry` = '".$fundTypIndy."',`size` = ".$fundSize.",`fundStatus` = '".$fundStatus."',`fundClosedStatus` = '".$fundCloseStatus."',`fundDate` = '".$fundDate."',`capitalSource` = '".$capitalSource."',`moreInfo` = '".$moreInfo."',`source` = '".$source."', `amount_raised` = " . $amount_raised . ",`hideaggregate`='".$HideAggregate."' WHERE `id` = '".$fundId."'";
        if($launchDate != "")
        {
        $sqlUpdate ="UPDATE `fundRaisingDetails` SET `launchDate`='$launchDate',`dbType` = '$dbType',`investorId` = '".$investorId."',`fundName` = '".$fundnameId."',`fundManager` = '".$fundMan."',`fundTypeStage` = '".$fundTypStage."',`fundTypeIndustry` = '".$fundTypIndy."',`size` = ".$fundSize.",`fundStatus` = '".$fundStatus."',`fundClosedStatus` = '".$fundCloseStatus."',`fundDate` = '".$fundDate."',`capitalSource` = '".$capitalSource."',`moreInfo` = '".$moreInfo."',`source` = '".$source."', `amount_raised` = " . $amount_raised . ",`hideaggregate`='".$HideAggregate."' WHERE `id` = '".$fundId."'";
        }
        else
        {
            $sqlUpdate ="UPDATE `fundRaisingDetails` SET `launchDate`=NULL,`dbType` = '$dbType',`investorId` = '".$investorId."',`fundName` = '".$fundnameId."',`fundManager` = '".$fundMan."',`fundTypeStage` = '".$fundTypStage."',`fundTypeIndustry` = '".$fundTypIndy."',`size` = ".$fundSize.",`fundStatus` = '".$fundStatus."',`fundClosedStatus` = '".$fundCloseStatus."',`fundDate` = '".$fundDate."',`capitalSource` = '".$capitalSource."',`moreInfo` = '".$moreInfo."',`source` = '".$source."', `amount_raised` = " . $amount_raised . ",`hideaggregate`='".$HideAggregate."' WHERE `id` = '".$fundId."'";
        }
        $res = mysql_query($sqlUpdate) or die(mysql_error());
       /* echo $sqlUpdate;
        exit();*/
        header("location:fundlist.php");
    }    
    
    //Fetch values from DB
    $selectedId = $_GET['id'];
    $sqlGet = "SELECT * FROM `fundRaisingDetails` WHERE `id`='".$selectedId."'";
    $resGet = mysql_query($sqlGet) or die(mysql_error());
    while($row=mysql_fetch_array($resGet)){
        $dtfundId             = $row['id'];
        $dtinvestorId         = $row['investorId'];
        $dtfundName           = $row['fundName'];
        $dtfundMan            = $row['fundManager'];
        $dtfundTypeStage      = $row['fundTypeStage'];
        $dtfundTypeIndustry   = $row['fundTypeIndustry'];
        $dtfundSize           = $row['size'];
        $dtfundAmountRaised   = $row[ 'amount_raised' ];
        $dtfundStatus         = $row['fundStatus'];
        $dtfundClosedStatus   = $row['fundClosedStatus'];
        $dtfundDate           = $row['fundDate'];
        $dtcapitalSource      = $row['capitalSource'];
        $dtmoreInfo           = $row['moreInfo'];
        $dtsource             = $row['source'];
        $launchDate = $row['launchDate'];
        $hideaggregate=0;
        if($row['hideaggregate']==1)
                    $hideaggregate ="checked";
        
        //Get Investor Name
        $sqlInv = "SELECT `Investor` FROM `peinvestors` WHERE `InvestorId` = '".$dtinvestorId."'";
        $resInv = mysql_query($sqlInv) or die(mysql_error());
        $rowsInv = mysql_fetch_row($resInv);
        $dtinvestorName       = $rowsInv[0];
        
        $sqlfund = "SELECT `fundName` FROM `fundNames` WHERE `fundId` = '".$dtfundName."'";
        $resfund = mysql_query($sqlfund) or die(mysql_error());
        $rowsfund = mysql_fetch_row($resfund);
        $fundname       = $rowsfund[0];
    }
    
    
?>
<html><head>
<title>Edit Fund Raising Details</title>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="styles/token-input.css" type="text/css" />
<link rel="stylesheet" href="styles/token-input-facebook.css" type="text/css" />
<style>
  /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Header */
.modal-header {
    padding: 2px 16px;
    background-color: #807f01;
    color: white;
}
.modal-header h3 {
  margin: 5px 0px;
  padding: 0px;
}

/* Modal Body */
.modal-body {padding: 2px 16px;}
.modal-body p {
  text-align: center;
}

/* Modal Footer */
.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: 15% auto;
    padding: 0;
    border: 1px solid #888;
    width: 20%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@keyframes animatetop {
    from {top: -300px; opacity: 0}
    to {top: 0; opacity: 1}
}

/* The Close Button */
.close {
    /*color: #aaa;*/
    float: right;
    font-size: 28px;
    font-weight: bold;
    top: -5px;
    position: relative;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

<script type="text/javascript">
    
    /**
     * $(document).ready(function() {
            $("#demo-input-pre-populated-with-tokenlimit").tokenInput("http://shell.loopj.com/tokeninput/tvshows.php", {
                prePopulate: [
                    {id: 123, name: "Slurms MacKenzie"},
                    {id: 555, name: "Bob Hoskins"},
                    {id: 9000, name: "Kriss Akabusi"}
                ],
                tokenLimit: 3
            });
        });
     * 
     * **/
    
    jQuery(document).ready(function($) {

        $( '.modal-content .close' ).click(function() {
          $( '#myModal' ).hide();
          showModal = false;
        });

        $("#investor").tokenInput("ajaxphp.php?opt=investor",{
                hintText: "Start typing the investor name",
                noResultsText: "No Investors matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                onAdd: function (item) {
                    
                    $.post("ajaxphp.php?opt=fundname&inv="+item.id, function(data) {
                            data=$.parseJSON(data);
                            if(data.length > 0)
                            {
                                data=data[0];
                                $("#fundName").tokenInput("add", {id: data.id, name: data.name});
                            }else{
                                $("#fundName").tokenInput("clear");
                            }
                            
                                
                 });
                    
                   $('#investoradd').attr('disabled',"true");
                   
            },
             onDelete: function (item) {
                   $('#investoradd').removeAttr('disabled');
                    $("#fundName").tokenInput("clear");
            },
                <?php if ($dtinvestorName!=""){?>
                
                prePopulate: [
                    {id:<?php echo $dtinvestorId;?>, name: "<?php echo $dtinvestorName; ?>"} ],
                     
                <?php } ?>
            });
            
           $("#fundName").tokenInput("ajaxphp.php?opt=allfundname",{
                hintText: "Start typing the fundname",
                noResultsText: "No name matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                onAdd: function (item) {
                   $('#fundnameadd').attr('disabled',"true");
            },
             onDelete: function (item) {
                   $('#fundnameadd').removeAttr('disabled');
            },
                <?php if ($fundname !=""){?>
                prePopulate: [
                    {id:<?php echo $dtfundName;?>, name: "<?php echo $fundname; ?>"} ],
                <?php } ?>
            }); 
        //jQuery('input[type=radio]')
        $("input:radio[name='fundStatus']").click(function(){
            if(this.value==2){
                 jQuery('#closeStatus').show();
            }else{
                jQuery('#closeStatus').hide();
            }
        });
    });
</script>


<SCRIPT LANGUAGE="JavaScript">

    function monthyearcheck()
{
         var checkmonth = document.addfund.month.value;
         var checkyear = document.addfund.year.value;
         var checkinvestor = document.addfund.investor.value;
       
       var sltdb ='PE';
     
       
        var xmlhttp;
      //  var str ='test';
       
        if (window.XMLHttpRequest)
          {// code for IE7+, Firefox, Chrome, Opera, Safari
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
             //document.getElementById("property_type_box").innerHTML=xmlhttp.responseText;
             document.getElementById("datecheck").value=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","ajaxphp.php?opt=checkdate&dbtype="+sltdb+"&checkmonth="+checkmonth+"&checkyear="+checkyear+"&checkinvestor="+checkinvestor,true);
        xmlhttp.send();
        
        
}
    
function checklist()
{
	missinginfo = "";
        
        investor=jQuery("#investor").val();
        investoradd=jQuery("#addinvestor").val();
       
        fundName=jQuery("#fundName").val();
        fundadd=jQuery("#fundadd").val();
       
       if(investor!="" || investoradd!="")
        {
//            if(fundName!="" || fundadd!="")
//            {
//                
//            }else{
//                 missinginfo += "\n     -  Please select Fund Name";
//            }
        }else if(fundName!="" || fundadd!="")
        {
            if(investor!="" || investoradd!="")
            {
                
            }else{
                 missinginfo += "\n     -  Please select Investor";
            }
        }
        var elem=document.forms['addfund'].elements['fundStatus'];
        len=elem.length-1;
        chkvalue='';
        for(i=0; i<=len; i++)
        {
            if(elem[i].checked)chkvalue=elem[i].value;
        }
        
        if(chkvalue=='')
        {
            missinginfo += "\n     -  Please select Fund Status";
        }
        else if(chkvalue==2){
            
            var elem2=document.forms['addfund'].elements['fundCloseStatus'];
            len2=elem2.length-1;
            
            chkvalue2='';
            for(j=0; j<=len2; j++)
            {
                if(elem2[j].checked)chkvalue2=elem2[j].value;
            }
           
            if(chkvalue2=='')
            {
                missinginfo += "\n     -  Please select Close Status";
            }
        
        }   
        
//        if(document.addfund.date.value =='')
//            missinginfo += "\n     -  Please enter Date";
        
        if(document.addfund.datecheck.value > '1'){
            missinginfo += "\n     -  Month & Year already exists !!!";
        }
        
        if(document.addfund.month.value =='0'){
            missinginfo += "\n     -   Please select Month";
        }
        
        if(document.addfund.year.value =='0'){
            missinginfo += "\n     -   Please select Year";
        }
        
        
	if (missinginfo != "")
	{
		alert(missinginfo);
		return false;
	}
	else
		return true;
}
</SCRIPT>
<script type="text/javascript">
var investor_db_id = '';
var showModal = true;
$(document).ready(function() {
             $('#hideaggregate').change(function(){
                this.value = (Number(this.checked));
            });
            
            $("input:radio[name='fundCloseStatus']").click( function(){
                if( $( this ).val() == 3 ) {
                  var dbType = 'PE';
                  if( dbType == 'PE' ) {
                    investor_db_id = $('#investor').val();
                  } else {
                    investor_db_id = $('#reinvestor').val();
                  }
                  if( showModal && investor_db_id != '' ) {
                    jQuery( '#myModal' ).show();
                  }
                }
              });

            $( '#investor_addaumbtn' ).click( function() {
              var dbType = 'PE';
              var investor_addaum = $( '#investor_addaum' ).val();
              if( investor_addaum == '' ) {
                alert( 'Please enter the Add AUM' );
                return false;
              }
              var data_obj = {"investor_addaum":investor_addaum,"investor_db_id":investor_db_id,"dbType":dbType};
              $.ajax({
                type: 'POST',
                url: 'update_investor_aum.php',
                data: data_obj,
                success: function( msg ) {
                  var respData = JSON.parse( msg );
                  if( respData.Status == 'Success' ) {
                    $( '#investor_addaum' ).val('');
                    showModal = false;
                    jQuery( '#myModal' ).hide();
                  } else {
                    alert( respData.Data );
                  }
                }
              })
            });

            //$("#fundlist").html("Show Manager");
            $("#investoradd").click(function(){
                showModal = false;
                $("#addinvestor").show();
                $(this).html('Suggest Investor');
                $("#token-input-investor").hide();
                $(".token-input-list").css('border','none');
            });
            $("#fundnameadd").click(function(){
               
                $("#fundadd").show();
                $(this).html('Suggest FundName');
                $("#token-input-fundName").hide();
                $(".token-input-list").css('border','none');
            });
            
  
});
</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->

</head>

<body>
<form name="addfund" onSubmit="return checklist();" method=post action="editfund.php">
    <input type="hidden" value="1" id="datecheck" name="datecheck">
 <table border=1 align=center cellpadding="5px" cellspacing="0px" width="900px" style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111"  bgcolor="#F5F0E4">

        <tr bgcolor="#808000"><td colspan=3 align=center style="color: #FFFFFF" ><b> Edit Fund Raising Details</b></td></tr>
        
        <tr>
            <td width="300px">Investor</td>
            <td colspan="2">
                <input type="text" name="investor" id="investor">
                <input type="text" name="investoradd" id="addinvestor" style="display:none">
                 <button type="button" id="investoradd" value="" >Add Investor</button>
            </td>
        </tr>
        <tr>
            <td>Fund Name</td>
            <td colspan="2">
                <input type="text" name="fundName" id="fundName" size="50" value="<?php echo $dtfundName; ?>">
                <input type="text" name="fundNameadd" id="fundadd" style="display:none">
                <button type="button" id="fundnameadd" value="" >Add FundName</button>
            </td>
        </tr>
        <tr>
            <td>Fund Manager</td>
            <td colspan="2">
                <input type="text" name="fundMan" id="fundMan" size="50" value="<?php echo $dtfundMan; ?>">
            </td>
        </tr>
        <tr>
            <td>Fund Type</td>
            <td colspan="2">
                <?php
                    $sql = "SELECT `id`,`fundTypeName` FROM fundType WHERE `focus`='Stage' AND dbtype='PE' ";
                    $res = mysql_query($sql) or die(mysql_error());
                    $option = '';
                    
                    while($rows=mysql_fetch_array($res)){ 
                        $id = $rows['id'];
                        $fundTypeName = $rows['fundTypeName'];
                        if ($dtfundTypeStage == $id)
                            $option .= '<option value="'.$id.'" SELECTED>'.$fundTypeName.'</option>';
                        else
                            $option .= '<option value="'.$id.'" >'.$fundTypeName.'</option>';
                    }
                ?>
                
                <select name="fundTypeStage">
                    <option value="">---STAGE---</option>
                    <?php echo $option; ?>
                </select> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <?php
                    $sql = "SELECT `id`,`fundTypeName` FROM fundType WHERE `focus`='Industry'  AND dbtype='PE'  ";
                    $res = mysql_query($sql) or die(mysql_error());
                    $option = '';
                    while($rows=mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $fundTypeName = $rows['fundTypeName'];
                        if ($dtfundTypeIndustry == $id)
                            $option .= '<option value="'.$id.'" SELECTED>'.$fundTypeName.'</option>';
                        else
                            $option .= '<option value="'.$id.'" >'.$fundTypeName.'</option>';
                    }
                ?>
                <select name="fundTypeIndustry">
                    <option value="">---INDUSTRY---</option>
                    <?php echo $option; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Size (US$M)</td>
            <td colspan="2">
                <input type="text" name="size" id="size" value="<?php echo $dtfundSize; ?>">
            </td>
        </tr>
        <tr>
            <td>Amount Raised (US$M)</td>
            <td colspan="2">
                <input type="text" name="amount_raised" id="amount_raised" value="<?php echo $dtfundAmountRaised; ?>">
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <?php
                    $sql ="SELECT * FROM fundRaisingStatus";
                    $res = mysql_query($sql) or die(mysql_error());
                    while($rows = mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $fundStatus = $rows['fundStatus'];
                        if ($dtfundStatus == $id)
                            echo '<input type="radio" name="fundStatus" value="'.$id.'" CHECKED>&nbsp;'.$fundStatus.'&nbsp;&nbsp;' ;
                        else
                            echo '<input type="radio" name="fundStatus" value="'.$id.'">&nbsp;'.$fundStatus.'&nbsp;&nbsp;' ;
                    }
                ?>
            </td>
            <td id="closeStatus" style="<?php echo ($dtfundStatus == 2) ? '' : 'display:none;'; ?>"> 
                &nbsp;&nbsp;Close Status :
                <?php
                $sql ="SELECT * FROM fundCloseStatus";
                    $res = mysql_query($sql) or die(mysql_error());
                    $count=0;
                    while($rows = mysql_fetch_array($res)){
                        echo ($count==0) ? '&nbsp;&nbsp;&nbsp;' : '';
                        $id = $rows['id'];
                        $closeStatus = $rows['closeStatus'];
                        if ($dtfundClosedStatus == $id)
                            echo '<input type="radio" name="fundCloseStatus" value="'.$id.'" CHECKED>&nbsp;'.$closeStatus.'&nbsp;&nbsp;' ;
                        else
                            echo '<input type="radio" name="fundCloseStatus" value="'.$id.'">&nbsp;'.$closeStatus.'&nbsp;&nbsp;' ;
                    }
                ?>
            </td>
        </tr>
        <tr>
            <td>Capital Source</td>
            <td colspan="2">
                <?php
                    $sql ="SELECT * FROM fundCapitalSource";
                    $res = mysql_query($sql) or die(mysql_error());
                    while($rows = mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $source = $rows['source'];
                        if ($dtcapitalSource == $id)
                            echo '<input type="radio" name="capitalSource" value="'.$id.'" CHECKED>&nbsp;'.$source.'&nbsp;&nbsp;' ;
                        else
                            echo '<input type="radio" name="capitalSource" value="'.$id.'">&nbsp;'.$source.'&nbsp;&nbsp;' ;
                    }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>Date</td>
            <td colspan="2">
<!--                <input type="date" name="date" size="50" value="<?php echo $dtfundDate;?>" >-->
                 <?php 
                $month = date("m",strtotime($dtfundDate)); 
                $year = date("Y",strtotime($dtfundDate)); 
                ?>
                 <select name="month" id="month"  onchange="monthyearcheck();" >
                     <option value="0" >Month</option>
                     <option value="01"  <?php if($month=='01'){ echo "selected"; } ?> >Jan</option>
                    <option value="02"  <?php if($month=='02'){ echo "selected"; } ?>>Feb</option>
                    <option value="03"  <?php if($month=='03'){ echo "selected"; } ?> >Mar</option>
                    <option value="04"  <?php if($month=='04'){ echo "selected"; } ?> >Apr</option>
                    <option value="05"  <?php if($month=='05'){ echo "selected"; } ?> >May</option>
                    <option value="06"  <?php if($month=='06'){ echo "selected"; } ?> >Jun</option>
                    <option value="07"  <?php if($month=='07'){ echo "selected"; } ?> >Jul</option>
                    <option value="08"  <?php if($month=='08'){ echo "selected"; } ?> >Aug</option>
                    <option value="09"  <?php if($month=='09'){ echo "selected"; } ?> >Sep</option>
                    <option value="10"  <?php if($month=='10'){ echo "selected"; } ?> >Oct</option>
                    <option value="11"  <?php if($month=='11'){ echo "selected"; } ?> >Nov</option>
                   <option value="12"  <?php if($month=='12'){ echo "selected"; } ?> >Dec</option>
                </select>
                
                
                <select name="year" id="year"  onchange="monthyearcheck();">
                <option  value="0">Year</option>
                <?php 
                $cur_date = date("Y");
                for($s=1998;$s<=$cur_date;$s++){ ?>
                <option id="<?php echo $s; ?>" value="<?php echo $s; ?>" <?php if($year==$s){ echo "selected"; } ?> ><?php echo $s; ?></option>                
                <?php } ?>
                </select>
                
            </td>
        </tr>
        <tr>
            <td>Launch Date</td>
            <td colspan="2">
            <?php
          
$launchmonth = date("m",strtotime($launchDate));
$year = date("Y",strtotime($launchDate));
if($launchDate == "")
{
$month = "0";
$year = "0";
}
?>
<select name="launchmonth" id="launchmonth" >
<option value="0" <?php if($launchmonth=='0'){ echo "selected"; } ?>>Month</option>
<option value="01" <?php if($launchmonth=='01'){ echo "selected"; } ?> >Jan</option>
<option value="02" <?php if($launchmonth=='02'){ echo "selected"; } ?>>Feb</option>
<option value="03" <?php if($launchmonth=='03'){ echo "selected"; } ?> >Mar</option>
<option value="04" <?php if($launchmonth=='04'){ echo "selected"; } ?> >Apr</option>
<option value="05" <?php if($launchmonth=='05'){ echo "selected"; } ?> >May</option>
<option value="06" <?php if($launchmonth=='06'){ echo "selected"; } ?> >Jun</option>
<option value="07" <?php if($launchmonth=='07'){ echo "selected"; } ?> >Jul</option>
<option value="08" <?php if($launchmonth=='08'){ echo "selected"; } ?> >Aug</option>
<option value="09" <?php if($launchmonth=='09'){ echo "selected"; } ?> >Sep</option>
<option value="10" <?php if($launchmonth=='10'){ echo "selected"; } ?> >Oct</option>
<option value="11" <?php if($launchmonth=='11'){ echo "selected"; } ?> >Nov</option>
<option value="12" <?php if($launchmonth=='12'){ echo "selected"; } ?> >Dec</option>
</select>
                
                
                <select name="launchyear" id="launchyear"  >
                <option  value="0">Year</option>
                
                <?php
                 $i=1998;
                        While($i<= $currentyear )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i++;
                        }
              ?>

                </select>
            </td>
        </tr>
        <tr>
            <td>More Info</td>
            <td colspan="2">
                <textarea name="moreInfo"><?php echo $dtmoreInfo; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Source</td>
            <td colspan="2">
                <textarea name="source"><?php echo $dtsource; ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Hide for Aggregate</td>
            <td colspan="2">
                <input type="checkbox" name="hideaggregate" id="hideaggregate" value="<?php echo  $row['hideaggregate']; ?>" <?php echo $hideaggregate; ?>>

            </td>
        </tr>
        
        <tr><td colspan="3">&nbsp;<input type="hidden" name="id" value="<?php echo $selectedId;?>"></td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a></td><td align=right colspan="2"> <a href="fundlist.php">Funds List</a> </td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Update Fund" name="actionlist" > </td></tr></table>




     </form>

     <!-- The Modal -->
  <div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
      <div class="modal-header">
        <span class="close">&times;</span>
        <h3>Add AUM($M)</h3>
      </div>
      <div class="modal-body">
        <p><input type="text" name="investor_addaum" id="investor_addaum"></p>
        <p><button name="investor_addaumbtn" id="investor_addaumbtn">Update</button></p>
      </div>
    </div>
  </div>
  
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();

    
   </script>

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>