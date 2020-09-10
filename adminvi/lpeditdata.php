<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
    checkaccess( 'edit' );
session_save_path("/tmp");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
?>
<html><head>
<title>PE Investment Deal Info</title>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 

<script>
    
    $(function() {
        
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
                        $("#region").prop("disabled", false);
                        response( $.map( data, function( item ) {
                            return {
                                label: item.label,
                                value: item.value,
                                id: item.id,
                                regionId: item.regionId,
                                stateId:item.stateId
                            }
                        }));
                    }
                });
            },
            minLength: 1,
            select: function( event, ui ) {
                console.log(ui);
                $('#citysearch').val(ui.item.value);
                $('#cityauto').val(ui.item.value);
          
                if(ui.item.regionId > 0){
                    $("#region option[value="+ui.item.regionId+"]").prop('selected', true);  
                    //$("#region").prop("disabled", true);
                }else{
                    $("#region option[value=1]").prop('selected', true);
                    $("#region").prop("disabled", false);
                }
                if(ui.item.stateId > 0){
                    $("#state option[value="+ui.item.stateId+"]").prop('selected', true);  
                    //$("#region").prop("disabled", true);
                }else{
                    $("#state option[value=1]").prop('selected', true);
                    $("#state").prop("disabled", false);
                }
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
    });
</script>
<style>
    .add_ul{
        padding-left: 0px;
    }
    .add_ul li{
        list-style: none;
        float: left;
        width:103px;
        text-align: left;
        padding-left: 2px;
        font-weight: bold;
    }
    .limitedpartner tr td:first-child{
        padding:0px 5px;
    }
   </style>
<SCRIPT LANGUAGE="JavaScript">
function delUploadFile()
{
	document.adddeal.action="delpeuploadfile.php";
	document.adddeal.submit();
}
function delREUploadFile(str)
{
         document.adddeal.hiddenfile.value=str;
	document.adddeal.action="delpereuploadfile.php";
	document.adddeal.submit();
}
function checkFields()
{
	if(document.adddeal.txtfile.value!="")
	{
		if(document.adddeal.txtsource.value=="")
		{
			alert("Please enter the Source for the attached file");
			return false;
			}

	}

}

function UpdateDeals()
{

		document.adddeal.action="lpupdatedata.php";
		document.adddeal.submit();
}
/*function UpdateREDeals()
{
		document.adddeal.action="pereupdatedata.php";
		document.adddeal.submit();

}*/

</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=adddeal enctype="multipart/form-data" onSubmit="return checkFields();"  method=post >
<!--  <input type="text" name="hiddenfile" value=""> -->
 <table class="limitedpartner" border=1 align=center cellpadding=0 cellspacing=0 width=50%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	
$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
$stringtoExplode = explode("-", $value);
$pe_re=$stringtoExplode[0];
$companyIdtoEdit=$stringtoExplode[1];
   $currentyear = date("Y");
   //echo "<br>---" .$currentyear;
	$SelCompRef=$companyIdtoEdit;
	/*if($pe_re=="PE")
	{*/
		//$titleDisplay="Stage";
	   	$getDatasql = "select * from limited_partners where LPId = $SelCompRef";
		//	echo "<br>--" .$getDatasql;
	 /*$getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.leadinvestor,peinv.newinvestor from peinvestments_investors as peinv,
	 peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef";
	$industrysql = "select distinct i.industryid,i.industry  from industry as i	order by i.industry";*/
        
   
		 $countrysql="select countryid,country from country";


	//echo "<br>-------------".$getDatasql;



//echo "<br>-------------".$getInvestorsSql;

	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{

  		?>

		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit LP Directory</b></td></tr>
                <tr><td colspan=2 style="font-family: Verdana; font-size: 8pt" align=left>
                                <input type="hidden" name="txtLPId" size="10" value="<?php echo $mycomprow["LPId"]; ?>">

                                <!-- PECompanyid -->
                               <!--  <input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>"> -->
                                </td></tr>
                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Institution Name</td>
                                <td><input type="text" name="txtinstitutionname" size="50" value="<?php echo $mycomprow["InstitutionName"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Contact Person</td>
                                <td><input type="text" name="txtcontactperson" size="50" value="<?php echo $mycomprow["ContactPerson"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Designation</td>
                                <td><input type="text" name="txtdesignation" size="50" value="<?php echo $mycomprow["Designation"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Email</td>
                                <td><input type="text" name="txtemail" size="50" value="<?php echo $mycomprow["Email"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Address1</td>
                                <td><input type="text" name="txtaddress1" size="50" value="<?php echo $mycomprow["Address1"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Address2</td>
                                <td><input type="text" name="txtaddress2" size="50" value="<?php echo $mycomprow["Address2"]; ?>"> </td>
                                </tr>
                               <tr>
                                <td >City</td>
                                                                
                                <td >
<!--                                <input type="text" name="txtcity" size="50" value="<?php echo $mycomprow["city"]; ?>"> </td>-->
                                                                <input type="hidden" id="cityauto" name="txtcity" value="<?php echo $mycomprow["City"]; ?>" placeholder="" style="width:220px;" autocomplete="off">
                                                                <input type="text" id="citysearch" name="citysearch" value="<?php echo $mycomprow["City"]; ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>></td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Pincode</td>
                                <td><input type="text" name="txtpincode" size="50" value="<?php echo $mycomprow["PinCode"]; ?>"> </td>
                                </tr>
                                <!-- <tr>
                                <td >State</td>
                                <td >
                                     <SELECT NAME=txtstate id="state">

                                    <?php
                                        $stateSql = "select state_id, state_name from state order by state_id";
                                        if ($states = mysql_query($stateSql))
                                        {
                                          $state_cnt = mysql_num_rows($states);
                                        }
                                        if($state_cnt > 0)
                                        {
                                            While($myrow=mysql_fetch_array($states, MYSQL_BOTH))
                                            {
                                                $id = $myrow[0];
                                                $name = $myrow[1];
                                            echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
                                            }
                                        }
                                    ?>
                                    </SELECT>
                                </td>

                                </tr> -->
                                <tr>
                                <td >Country</td>
                                <td >
                                     <SELECT NAME=txtstate id="state">
                                        <OPTION id="" value="" >Select the country</OPTION>
                                    <?php
                                        $stateSql = "select countryid, country from country where country!='' and country!='--' order by country";
                                        if ($states = mysql_query($stateSql))
                                        {
                                          $state_cnt = mysql_num_rows($states);
                                        }
                                        if($state_cnt > 0)
                                        {
                                            While($myrow=mysql_fetch_array($states, MYSQL_BOTH))
                                            {
                                                $id = $myrow[0];
                                                $name = $myrow[1];
                                                if ($name==$mycomprow["Country"])
                                                {
                                                    echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
                                                }
                                                else
                                                {
                                                    echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
                                                
                                                }
                                            }
                                           
                                        }
                                    ?>
                                    </SELECT>
                                </td>

                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Phone</td>
                                <td><input type="text" name="txtphone" size="50" value="<?php echo $mycomprow["Phone"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Fax</td>
                                <td><input type="text" name="txtfax" size="50" value="<?php echo $mycomprow["Fax"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Website</td>
                                <td><input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["Website"]; ?>"> </td>
                                </tr>
                                <tr style="font-family: Verdana; font-size: 8pt">
                                <td >Type Of Institution</td>
                                <td><input type="text" name="txttypeofinstitution" size="50" value="<?php echo $mycomprow["TypeOfInstitution"]; ?>"> </td>
                                </tr>
				

                                                            
                                                                <?php
                                                                

                        }
								
							
								

								
							mysql_free_result($companyrs);
							}

 ?>


</table>
<table align=center>
<tr> <Td>

	<input type="button" value="Update" name="updateDeal" onClick="UpdateDeals();">

</td></tr></table>




     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>
<!--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>-->
   
   <script>
    $( document ).ready(function() {
        
        $('#getrevenue_value').change(function() {
        if($(this).is(":checked")) {
           //alert('sssssssssssssssss');
           
          
           
           var txtcompanyvaluation = $("#txtcompanyvaluation").val();
           
           var txtrevenuemultiple = $("#txtrevenuemultiple").val();
           var txtEBITDAmultiple = $("#txtEBITDAmultiple").val();
           var txtpatmultiple = $("#txtpatmultiple").val();
           
           
           if($.isNumeric(txtcompanyvaluation)==0 || txtcompanyvaluation=="0.00" || txtcompanyvaluation=="0"){
                alert('Please enter company valution');
                $('#getrevenue_value').removeAttr('checked');
               return false;
           }
           
           /*
           var txtrevenue = txtcompanyvaluation/txtrevenuemultiple;
           var txtEBITDA = txtcompanyvaluation/txtEBITDAmultiple;
           var txtpat = txtcompanyvaluation/txtpatmultiple;
           
                $("#txtrevenue").val(txtrevenue.toFixed(1));                
                $("#txtEBITDA").val(txtEBITDA.toFixed(1));
                $("#txtpat").val(txtpat.toFixed(1));
           */     
           
          
           
           // revenue
           if($.isNumeric(txtrevenuemultiple)==0 || txtrevenuemultiple=="0.00" || txtrevenuemultiple=="0"){
               $("#txtrevenue").val('0.00');
               // alert('Please enter revenue multiple');
              // return false;
           }else{
               var txtrevenue = txtcompanyvaluation/txtrevenuemultiple;
                $("#txtrevenue").val(txtrevenue.toFixed(1));
           }
           
           
           // ebita
           if($.isNumeric(txtEBITDAmultiple)==0 || txtEBITDAmultiple=="0.00" || txtEBITDAmultiple=="0"){
               $("#txtEBITDA").val('0.00');
               // alert('Please enter EBITDA multiple');
               //return false;
           }else{
               var txtEBITDA = txtcompanyvaluation/txtEBITDAmultiple;
               $("#txtEBITDA").val(txtEBITDA.toFixed(1));
           }
           
           
           // pat
           if($.isNumeric(txtpatmultiple)==0 || txtpatmultiple=="0.00" || txtpatmultiple=="0"){
               $("#txtpat").val('0.00');
               // alert('Please enter pat multiple');
               //return false;
           }else{
               var txtpat = txtcompanyvaluation/txtpatmultiple;
               $("#txtpat").val(txtpat.toFixed(1));
           }
           
            
           
            
           
           
            
            
           
        }else{
            $("#txtrevenue, #txtEBITDA, #txtpat").val('0.00');
        }
        
        });
    });
    $( document ).ready(function() {
      
    // this will contain a reference to the checkbox
    if ($('.Venture').is(':checked') == true) {
       $(".SV").attr('disabled',true).prop('checked',false);
    }else {
       $(".SV").removeAttr('disabled'); 
        }
   
    if ($('.SV').is(':checked') == true) {
        $(".Venture").attr('disabled',true).prop('checked',false);
       
    }else {
         $(".Venture").removeAttr('disabled');
        }
    });
   


  $('.Venture').change(function() {
    // this will contain a reference to the checkbox
    if (this.checked) {
        $(".SV").attr('disabled',true).prop('checked',false);
    }else {
       $(".SV").removeAttr('disabled'); 
        }
    });
      $('.SV').change(function() {
    // this will contain a reference to the checkbox
    if (this.checked) {
        $(".Venture").attr('disabled',true).prop('checked',false);
       
    }else {
         $(".Venture").removeAttr('disabled');
        }
    });
    
    </script>
 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>