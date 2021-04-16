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
        //  $dbType             = 'PE';
        $dbType             = $_POST['sltdb']; 
        $investorId='';
        $fundnameId='';
        if($_POST['investoradd']!='' && $dbType =='PE') 
        {
            
            $sqlinv = "INSERT INTO `peinvestors` (`investor`) VALUES ('".$_POST['investoradd']."') ";
            $res = mysql_query($sqlinv) or die(mysql_error());
            $investorId = mysql_insert_id();
        }
        else if($_POST['investoradd']!='' && $dbType =='RE') 
        {
            
            $sqlinv = "INSERT INTO `REinvestors` (`investor`) VALUES ('".$_POST['investoradd']."') ";
            $res = mysql_query($sqlinv) or die(mysql_error());
            $investorId = mysql_insert_id();
            
        }
       else{
          
            if($dbType =='PE')
                {
                  $investorId = $_POST['investor'];
                   
                }
                else if($dbType =='RE')
                {
                    $investorId = $_POST['reinvestor'];
                }
       
       }
       
       if($_POST['fundNameadd']!='') 
        {
            
          //  $sqlfun = "INSERT INTO `fundNames` (`investorId`,`fundName`) VALUES (".$investorId.",'".$_POST['fundNameadd']."') ";
           $sqlfun = "INSERT INTO `fundNames` (`investorId`,`fundName`,`dbtype`) VALUES (".$investorId.", '".$_POST['fundNameadd']."', '".$dbType."' ) ";
           // echo $sqlfun;
            $funres = mysql_query($sqlfun) or die(mysql_error());
            $fundnameId = mysql_insert_id();
        }
       else{
           $fundnameId = $_POST['fundName'];
       }
        
       
       if($dbType =='PE')
       {
           
           if($_POST['peindustryname']!=NULL && $_POST['peindustryname']!=" "){                
               $peindustryname = $_POST['peindustryname'];
               mysql_query("INSERT INTO fundType (focus,fundTypeName,dbtype) VALUES ('Industry','$peindustryname','PE')");
               $fundTypIndy = mysql_insert_id();
              
           }
           else {
                $fundTypIndy        = $_POST['fundTypeIndustry'];
           }
           
           
           $fundTypStage       = $_POST['fundTypeStage'];
       }
       else if($dbType =='RE')
       {
           $REsector        = $_POST['REsector'];
       }
       
        $fundMan            = $_POST['fundMan'];
        
        
        $fundSize           = $_POST['size'];
        $amount_raised      = $_POST['amount_raised'];
        $fundStatus         = $_POST['fundStatus'];
        $fundCloseStatus    = $_POST['fundCloseStatus'];
       // $fundDate           = $_POST['date'];
        $fundDate           = "$_POST[year]-$_POST[month]-01";
        //$launchDate         = "$_POST[launchyear]-$_POST[launchmonth]-01";
        $capitalSource      = $_POST['capitalSource'];
        $moreInfo           = mysql_real_escape_string($_POST['moreInfo']);
        $source             = mysql_real_escape_string($_POST['source']);
        if(($_POST['hideaggregate']))
            { $HideAggregate=1;}
        else
            { $HideAggregate=0;}

            if($_POST['launchyear'] != 0 && $_POST['launchmonth'] != 0)
            {
             $launchDate = "$_POST[launchyear]-$_POST[launchmonth]-01";
            }
            else
            {
            $launchDate ="";
            }

        $dbType1 = ($dbType!="")?'dbTYpe = "'.$dbType.'"':'';
        $investorId = ($investorId!="")?', investorId = "'.$investorId.'"':'';
        $fundnameId = ($fundnameId!="")?', fundName = "'.$fundnameId.'"':'';
        $fundMan = ($fundMan!="")?', fundManager = "'.$fundMan.'"':'';
        $fundTypStage = ($fundTypStage!="")?', fundTypeStage = "'.$fundTypStage.'"':'';
        $fundTypIndy = ($fundTypIndy!="")?', fundTypeIndustry = "'.$fundTypIndy.'"':'';
        $fundSize = ($fundSize!="")?', size = "'.$fundSize.'"':'';
        $fundStatus = ($fundStatus!="")?', fundStatus = "'.$fundStatus.'"':'';
        $fundCloseStatus = ($fundCloseStatus!="")?', fundClosedStatus = "'.$fundCloseStatus.'"':'';
        $fundDate = ($fundDate!="")?', fundDate = "'.$fundDate.'"':'';
        $launchDate = ($launchDate!="")?', launchDate = "'.$launchDate.'"':'';

        $capitalSource = ($capitalSource!="")?', capitalSource = "'.$capitalSource.'"':'';
        $moreInfo = ($moreInfo!="")?', moreInfo = "'.$moreInfo.'"':'';
        $source = ($source!="")?', source = "'.$source.'"':'';
        $amount_raised = ($amount_raised!="")?', amount_raised = "'.$amount_raised.'"':'';
        $REsector = ($REsector!="")?', REsector = "'.$REsector.'"':'';
        $HideAggregate = ($HideAggregate!="")?', hideaggregate = "'.$HideAggregate.'"':'';
if($dbType =='PE')
       {
        //Insert into Table
        /*$sqlIns = "INSERT INTO `fundRaisingDetails` (`dbType`,`investorId`,`fundName`,`fundManager`,`fundTypeStage`,`fundTypeIndustry`,`size`,`fundStatus`,`fundClosedStatus`,`fundDate`,`capitalSource`,`moreInfo`,`source`,`amount_raised`) ";
        $sqlIns .= " VALUES ('".$dbType."','".$investorId."','".$fundnameId."','".$fundMan."','".$fundTypStage."','".$fundTypIndy."',".$fundSize.",'".$fundStatus."','".$fundCloseStatus."','".$fundDate."','".$capitalSource."','".$moreInfo."','".$source."'," . $amount_raised . ")";*/
        $sqlIns = "INSERT INTO `fundRaisingDetails` SET " . $dbType1 . $investorId . $fundnameId . $fundMan . $fundTypStage . $fundTypIndy . $fundSize . $fundStatus . $fundCloseStatus . $fundDate . $launchDate .$capitalSource . $moreInfo . $source . $amount_raised . $HideAggregate. "";

 }
 else if($dbType =='RE')
       {
      //Insert into Table
        /*$sqlIns = "INSERT INTO `fundRaisingDetails` (`dbType`,`investorId`,`fundName`,`fundManager`,`REsector`,`size`,`fundStatus`,`fundClosedStatus`,`fundDate`,`capitalSource`,`moreInfo`,`source`,`amount_raised`) ";
        $sqlIns .= " VALUES ('".$dbType."','".$investorId."','".$fundnameId."','".$fundMan."','".$REsector."',".$fundSize.",'".$fundStatus."','".$fundCloseStatus."','".$fundDate."','".$capitalSource."','".$moreInfo."','".$source."'," . $amount_raised . ")";*/
        $sqlIns = "INSERT INTO `fundRaisingDetails` SET " . $dbType1 . $investorId . $fundnameId . $fundMan . $REsector . $fundSize . $fundStatus . $fundCloseStatus . $fundDate . $capitalSource . $moreInfo . $source . $amount_raised . $HideAggregate. "";
 }      
        
        $res = mysql_query($sqlIns) or die(mysql_error());
        
        header("location:fundlist.php");
    }       
    
?>
<html><head>
<title>Add Fund Raising Details</title>
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
    jQuery(document).ready(function($) {
        
        $( '.modal-content .close' ).click(function() {
          $( '#myModal' ).hide();
          showModal = false;
        });
        $("#investor").tokenInput("ajaxphp.php?dbtype=PE&opt=investor",{
                hintText: "Start typing the investor name",
                noResultsText: "No Investors matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                onAdd: function (item) {
                    
                    $.post("ajaxphp.php?dbtype=PE&opt=fundname&inv="+item.id, function(data) {
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
            }
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
            }
            });
        //jQuery('input[type=radio]')
        $("input:radio[name='fundStatus']").click(function(){
            if(this.value==2){
                 jQuery('#closeStatus').show();
            }else{
                jQuery('#closeStatus').hide();
            }
        });
        
        
        
        
        $("#reinvestor").tokenInput("ajaxphp.php?dbtype=RE&opt=investor",{
   
                hintText: "Start typing the investor name",
                noResultsText: "No Investors matched your search",
                searchingText: "Please wait...",
                resultsLimit: 50,
                tokenLimit: 1,
                minChars:2,
                onAdd: function (item) {
                    
                    $.post("ajaxphp.php?dbtype=RE&opt=fundname&inv="+item.id, function(data) {
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
            }
            
       }); 
        
        
        
        
        
        
        
        
    });
   
 


</script>


<SCRIPT LANGUAGE="JavaScript">
    var investor_db_id = '';
    var showModal = true;
    function monthyearcheck()
{
         var checkmonth = document.addfund.month.value;
         var checkyear = document.addfund.year.value;
         
       
       var sltdb = document.addfund.sltdb.value;
       if(sltdb=='PE'){
           var checkinvestor = document.addfund.investor.value;
       }
       else if(sltdb=='RE'){      
           var checkinvestor = document.addfund.reinvestor.value;
       }
       
       //alert (checkinvestor);
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
        reinvestor=jQuery("#reinvestor").val();
        investoradd=jQuery("#addinvestor").val();
       
        fundName=jQuery("#fundName").val();
        fundadd=jQuery("#fundadd").val();
       
//       if(investor!="" || investoradd!="")
//       {
//            if(fundName!="" || fundadd!="")
//            {
//                
//            }else{
//                 missinginfo += "\n     -  Please select Fund Name";
//            }
//        }else if(fundName!="" || fundadd!="")
//        {
//            if(investor!="" || investoradd!="")
//           {
                
//           }else{
//                 missinginfo += "\n     -  Please select Investor";
//           }
//       }
      
        
        
        
        
        


      
       if(investor =="" && reinvestor =="")
       {
           if(investoradd =="")
            {
                 missinginfo += "\n     -  Please select Investor";
            }
            else if(investoradd ==" ")
            {
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
        
        if(document.addfund.datecheck.value !='0'){
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
        {
         /* if( chkvalue == 2 && chkvalue2 == 3 && showModal ) {
            var addinvestor = jQuery( '#addinvestor' ).val();
            investor_db_id = $('#investor').val();
            var dbType = $( 'input[name=sltdb]:checked' ).val();
            if( addinvestor == '' ) {
              if( showModal ) {
                jQuery( '#myModal' ).show();
              }
            }*//* else {
              if( showModal ) {
                var data_obj = {"investor":addinvestor, "dbType":dbType};
                $.ajax({
                  type: 'POST',
                  url: 'ajx_check_investor.php',
                  data: data_obj,
                  success: function( msg ) {
                    var respData = JSON.parse( msg );
                    if( respData.Status == 'Success' ) {
                      investor_db_id = respData.Data;
                      jQuery( '#myModal' ).show();
                    } else {
                      alert( respData.Data );
                    }
                  }
                });
              }
            }*/
            /*return false;
          } else{*/
            return true;
          /*}*/
        }
}
</SCRIPT>
<script type="text/javascript">

$(document).ready(function() {
   $('#hideaggregate').change(function(){
        this.value = (Number(this.checked));
    });

  $("input:radio[name='fundCloseStatus']").click( function(){
    if( $( this ).val() == 3 ) {
      var dbType = $( 'input[name=sltdb]:checked' ).val();
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
              var dbType = $( 'input[name=sltdb]:checked' ).val();
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
             //$("#token-input-fundName,#fundnameadd").attr('disabled',"true");
            //$("#fundlist").html("Show Manager");
            $("#investoradd").click(function(){
                showModal = false;
                $("#addinvestor").show();
              //  $(this).html('Suggest Investor');
                $("#token-input-investor").hide();
                $(".token-input-list").css('border','none');
             //   this.id="suggestinvestor";
                $("#autofill").hide();
                
                $("#investoradd").hide();
                 $("#suggestinvestor").show();
              
                
            });
            
            
            
            $("#suggestinvestor").click(function(){
                showModal = true;
                $("#addinvestor").hide();
              //  $(this).html('Add Investor');
                $("#token-input-investor").show();
                $(".token-input-list").css('border','none');
              //  this.id="investoradd";
                $("#autofill").show();
                
                 $("#investoradd").show();
                 $("#suggestinvestor").hide();
                              
            });
            
                       
            
            $("#fundnameadd").click(function(){
               
                $("#fundadd").show();
             //   $(this).html('Suggest FundName');
                $("#token-input-fundName").hide();
                $(".token-input-list").css('border','none');
                
                $("#suggestfundname").show();
                $("#fundnameadd").hide();
                
                
            });
            
             $("#suggestfundname").click(function(){
               
                $("#fundadd").hide();
              //   $(this).html('Suggest FundName');
               $("#token-input-fundName").show();
                $(".token-input-list").css('border','none');
                
                $("#fundnameadd").show();
                $("#suggestfundname").hide();
                
            });
            
            
            
            
             $("#pedb").click(function(){ 
              if( $('.pefund').is(':hidden') ) {
                showModal = true;
              }          
                
                $(".refund").hide();
                $(".pefund").show();
                $("#addinvestor").hide();
                document.getElementById("datecheck").value=0;
            });
            
             $("#redb").click(function(){
              if( $('.refund').is(':hidden') ) {
                showModal = true;
              }
                $(".pefund").hide();
                $(".refund").show();
                $("#addinvestor").hide();
                document.getElementById("datecheck").value=0;
            });
            
            
    
            $("#addpeindustry").click(function(){
                $("#peindustryname").val('');
                $('#fundTypeIndustry').val('');
                $("#sltpeindustrytab").hide();
                $("#addpeindustrytab").show();
            });
            
            $("#sltpeindustry").click(function(){
                $("#peindustryname").val('');
                $('#fundTypeIndustry').val('');
                $("#sltpeindustrytab").show();
                $("#addpeindustrytab").hide();
            });
            
      
  
});
  
</script>
<style>
    .refund
    {
        display: none;
    }
</style>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->

</head>

<body>
<form name="addfund" onSubmit="return checklist();" method=post action="addfund.php">
    <input type="hidden" value="0" id="datecheck" name="datecheck">
 <table border=1 align=center cellpadding="5px" cellspacing="0px" width="900px" style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111"  bgcolor="#F5F0E4">

        <tr bgcolor="#808000"><td colspan=3 align=center style="color: #FFFFFF" ><b> Add Fund Raising Details</b></td></tr>
        
        
        <tr>
            <td width="300px">DB-Type</td>
            <td colspan="2">
                <label for ='pedb'> <input type="radio" name="sltdb" id="pedb" value="PE" checked> PE </label>
                
                <label for ='redb'> <input type="radio" name="sltdb" id="redb" value="RE">RE </label>
               
                 
            </td>
            
        </tr>
        
        
        <tr>
            <td width="300px">Investor</td>
            <td colspan="2">
                
                <div id='autofill'>
                    
                <div class='pefund'>    
                 <input type="text" name="investor" id="investor">   
                </div>
                
                <div class='refund'>    
                 <input type="text" name="reinvestor" id="reinvestor">   
                </div>
                 
                
                </div>    
                    
                <input type="text" name="investoradd" id="addinvestor" style="display:none">
<!--                <span id="addinvestor"> </span>-->

                 <button type="button" id="investoradd" value="">Add Investor</button>
                 <button type="button" id="suggestinvestor" value=""  style="display:none">Suggest Investor</button>
                 
            </td>
            
        </tr>
        
              
        
        
        <tr>
            <td>Fund Name</td>
            <td colspan="2">
                <input type="text" name="fundName" id="fundName" size="50">
<!--                <span id="addfund"> </span>-->
                <input type="text" name="fundNameadd" id="fundadd" style="display:none">
               
                <button type="button" id="fundnameadd" value="">Add FundName</button>
                <button type="button" id="suggestfundname" value=""   style="display:none">Suggest FundName</button>
            </td>
        </tr>
        
        
        
        
        
        
        
        
        
        
        <tr>
            <td>Fund Manager</td>
            <td colspan="2">
                <input type="text" name="fundMan" id="fundMan" size="50">
            </td>
        </tr>
        <tr>
            <td>Fund Type</td>
            <td colspan="2">
              

             <span class='pefund'>   
              <?php
                    $sql = "SELECT `id`,`fundTypeName` FROM fundType WHERE `focus`='Stage' AND dbtype='PE' ";
                    $res = mysql_query($sql) or die(mysql_error());
                    $option = '';
                    
                    while($rows=mysql_fetch_array($res)){ 
                        $id = $rows['id'];
                        $fundTypeName = $rows['fundTypeName'];
                        $option .= '<option value="'.$id.'">'.$fundTypeName.'</option>';
                    }
                ?>
                
                <select name="fundTypeStage">
                    <option value="">---STAGE---</option>
                    <?php echo $option; ?>
                </select> 
             </span>
                
                
                 <span class='pefund'>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <?php
                    $sql = "SELECT `id`,`fundTypeName` FROM fundType WHERE `focus`='Industry'";
                    $res = mysql_query($sql) or die(mysql_error());
                    $option = '';
                    while($rows=mysql_fetch_array($res)){
                        $id = $rows['id'];
                        $fundTypeName = $rows['fundTypeName'];
                        $option .= '<option value="'.$id.'">'.$fundTypeName.'</option>';
                    }
                ?>
                
                <span id="sltpeindustrytab">
                <select name="fundTypeIndustry" id="fundTypeIndustry">
                    <option value="">---INDUSTRY---</option>
                    <?php echo $option; ?>
                </select>                           
                <button type="button" id="addpeindustry" value="">Add Industry</button>
                </span>
                
                <span id="addpeindustrytab" style="display:none">
                <input type="text" name="peindustryname" id="peindustryname" value="" > 
                <button type="button" id="sltpeindustry" value="">Select Industry</button>
                </span>
                
                
                
                
                </span>
                
              
                <!-- re -->
                
                <span class='refund'>   
                 <select name="REsector">
                     <option value="">---SECTOR---</option>
                    <?php
                            $sql="select * from realestatetypes order by REType";
                            $stagesql_search = mysql_query($sql) or die(mysql_error());
                                    While($myrow=mysql_fetch_array($stagesql_search)){

                                            $id = $myrow['RETypeId'];
                                            $name = $myrow['REType'];
                                            $name=($name!="")?$name:"Other";
                                                echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION>";
                                           
                                    }
                                    
                           
                     ?>
                </select> 
             </span>
                
                  <!-- re -->  
                
                
                
                
            </td>
        </tr>
        <tr>
            <td>Size (US$M)</td>
            <td colspan="2">
                <input type="text" name="size" id="size">
            </td>
        </tr>
        <tr class="amount_raised">
            <td>Amount Raised (US$M)</td>
            <td colspan="2">
                <input type="text" name="amount_raised" id="amount_raised">
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
                        echo '<input type="radio" name="fundStatus" value="'.$id.'">&nbsp;'.$fundStatus.'&nbsp;&nbsp;' ;
                    }
                ?>
            </td>
            <td id="closeStatus" style="display:none;"> 
                &nbsp;&nbsp;Close Status :
                <?php
                $sql ="SELECT * FROM fundCloseStatus";
                    $res = mysql_query($sql) or die(mysql_error());
                    $count=0;
                    while($rows = mysql_fetch_array($res)){
                        echo ($count==0) ? '&nbsp;&nbsp;&nbsp;' : '';
                        $id = $rows['id'];
                        $closeStatus = $rows['closeStatus'];
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
                        echo '<input type="radio" name="capitalSource" value="'.$id.'">&nbsp;'.$source.'&nbsp;&nbsp;' ;
                    }
                ?>
                
            </td>
        </tr>
        <tr>
            <td>Date</td>
            <td colspan="2">
                 <!--                <input type="date" name="date" size="50" value="<?php echo date('Y-m-d');?>" >-->
                <select name="month" id="month"  onchange="monthyearcheck();" >
                     <option value="0">Month</option>
                     <option value="01">Jan</option>
                    <option value="02">Feb</option>
                    <option value="03">Mar</option>
                    <option value="04">Apr</option>
                    <option value="05">May</option>
                    <option value="06">Jun</option>
                    <option value="07">Jul</option>
                    <option value="08">Aug</option>
                    <option value="09">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                   <option value="12">Dec</option>
                </select>
                
                
                <select name="year" id="year"  onchange="monthyearcheck();">
                <option  value="0">Year</option>
                
                <?php
                 $i=1998;
                        While($i<= $currentyear )
                        {
                        $id = $i;
                        $name = $i;
                       // $isselected = ($year1==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i++;
                        }
              ?>
<!--                 <option id="1998" value="1998">1998</option>
                <option id="1999" value="1999">1999</option>
                <option id="2000" value="2000">2000</option>
                <option id="2001" value="2001">2001</option>
                <option id="2002" value="2002">2002</option>
                <option id="2003" value="2003">2003</option>
                <option id="2004" value="2004">2004</option>
                <option id="2005" value="2005">2005</option>
                <option id="2006" value="2006">2006</option>
                <option id="2007" value="2007">2007</option>
                <option id="2008" value="2008">2008</option>
                <option id="2009" value="2009">2009</option>
                <option id="2010" value="2010">2010</option>
                <option id="2011" value="2011">2011</option>
                <option id="2012" value="2012">2012</option>
                <option id="2013" value="2013">2013</option>
                <option id="2014" value="2014">2014</option>-->
                

                </select>
            </td>
        </tr>
        <tr>
            <td>Launch Date</td>
            <td colspan="2">
                 <!--                <input type="date" name="date" size="50" value="<?php echo date('Y-m-d');?>" >-->
                <select name="launchmonth" id="launchmonth"   >
                     <option value="0">Month</option>
                     <option value="01">Jan</option>
                    <option value="02">Feb</option>
                    <option value="03">Mar</option>
                    <option value="04">Apr</option>
                    <option value="05">May</option>
                    <option value="06">Jun</option>
                    <option value="07">Jul</option>
                    <option value="08">Aug</option>
                    <option value="09">Sep</option>
                    <option value="10">Oct</option>
                    <option value="11">Nov</option>
                   <option value="12">Dec</option>
                </select>
                
                
                <select name="launchyear" id="launchyear"  >
                <option  value="0">Year</option>
                
                <?php
                 $i=1998;
                        While($i<= $currentyear )
                        {
                        $id = $i;
                        $name = $i;
                       // $isselected = ($year1==$id) ? 'SELECTED' : '';
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
                <textarea name="moreInfo"></textarea>
            </td>
        </tr>
        <tr>
            <td>Source</td>
            <td colspan="2">
                <textarea name="source"></textarea>
            </td>
        </tr>
        <tr>
            <td>Hide for Aggregate</td>
            <td colspan="2">
                <input type="checkbox" name="hideaggregate" id="hideaggregate" value="0">
            </td>
        </tr>
        
        <tr><td colspan="3">&nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a></td><td align=right colspan="2"> <a href="fundlist.php">Funds List</a> </td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Add Fund" name="actionlist" > </td></tr></table>




     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
     
   </script>

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

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>
