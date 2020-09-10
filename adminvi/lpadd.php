<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
?>
<html><head>
<title>Add Limited Partner Info</title>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<!--
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
 <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> -->
 <link rel="stylesheet" href="css/jquery-ui.css" /> 
<script src="js/jquery-ui.js"></script>
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
                        console.log(data);
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
function checkCompany()
{
	//alert(document.adddeal.txtregion.selectedIndex)
	var missinginfo = "";
	/*var compname="Undisclosed";*/
  var institution=document.adddeal.txtinstitutionname.value;
  var contactperson= document.adddeal.txtcontactperson.value;
  var designation= document.adddeal.txtdesignation.value;
  var email=document.adddeal.txtemail.value;
  var address1= document.adddeal.txtaddress1.value;
  var address2= document.adddeal.txtaddress2.value;
 /* var city=document.adddeal.txtcity.value;*/
  var pincode= document.adddeal.txtpincode.value;
  var country= document.adddeal.txtstate.value;
  var phone=document.adddeal.txtphone.value;
  var fax= document.adddeal.txtfax.value;
  var website= document.adddeal.txtwebsite.value;
  var typeofinstitution= document.adddeal.txttypeofinstitution.value;
  
	/*var usercompname;
	usercompname=document.adddeal.txtcompanyname.value;*/
	//alert(usercompname);

	if(institution == '' )
  {
		missinginfo += "\n     -  Please Enter Institution name";
  }
  if(contactperson == '' )
  {
    missinginfo += "\n     -  Please Enter contact person";
  }
  if(designation == '' )
  {
    missinginfo += "\n     -  Please Enter designation";
  }
  if(email == '' )
  {
    missinginfo += "\n     -  Please Enter email";
  }
  if(address1 == '' )
  {
    missinginfo += "\n     -  Please Enter address1";
  }
  if(address2 == '' )
  {
    missinginfo += "\n     -  Please Enter address2";
  }
  /*if(city == '' )
  {
    missinginfo += "\n     -  Please Enter city";
  }*/
  if(pincode == '' )
  {
    missinginfo += "\n     -  Please Enter pincode";
  }
  if(country == '' )
  {
    missinginfo += "\n     -  Please Enter country";
  }
  if(phone == '' )
  {
    missinginfo += "\n     -  Please Enter phone";
  }
  if(fax == '' )
  {
    missinginfo += "\n     -  Please Enter fax";
  }
  if(website == '' )
  {
    missinginfo += "\n     -  Please Enter website";
  }
	if(typeofinstitution == '' )
  {
    missinginfo += "\n     -  Please Enter Type of institution";
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
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=adddeal enctype="multipart/form-data" onSubmit="return checkCompany();" method=post action="lpaddupdate.php">
 <table class="limitedpartner" border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add Limited Partner</b></td></tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Institution Name</td>
								<td><input type="text" name="txtinstitutionname" size="50" > </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Contact Person</td>
								<td><input type="text" name="txtcontactperson" size="50" > </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Designation</td>
								<td><input type="text" name="txtdesignation" size="50"> </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Email</td>
								<td><input type="text" name="txtemail" size="50"> </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Address1</td>
								<td><input type="text" name="txtaddress1" size="50"> </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Address2</td>
								<td><input type="text" name="txtaddress2" size="50"> </td>
								</tr>
								<tr>
								<td >City</td>
								<td >
                                   <input type="hidden" id="cityauto" name="txtcity" value="<?php if($city!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($city!='') echo "readonly='readonly'";  ?>>
                                    <input type="text" id="citysearch" name="citysearch" value="<?php if(isset($city)) echo  $city;  ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
<!--								<input type="text" name="txtcity" size="50" value=""> </td>-->
								</td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Pincode</td>
								<td><input type="text" name="txtpincode" size="50"> </td>
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
											echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
											}
										}
									?>
									</SELECT>
								</td>

								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Phone</td>
								<td><input type="text" name="txtphone" size="50"> </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Fax</td>
								<td><input type="text" name="txtfax" size="50"> </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Website</td>
								<td><input type="text" name="txtwebsite" size="50"> </td>
								</tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Type Of Institution</td>
								<td><input type="text" name="txttypeofinstitution" size="50"> </td>
								</tr>

                                               



	<tr> <td colspan=2>&nbsp; </td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><!-- <a href="lpadd.php">Add LP Dir </a> --></td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Add" name="AddDeal" > </td></tr></table>

     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>
   <script>
    /*$( document ).ready(function() {
        
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
 	$('.Venture').change(function() {
    	 if (this.checked) {
       		 $(".SV").attr('disabled',true).prop('checked',false);
    	 }else {
	       	$(".SV").removeAttr('disabled'); 
	     }
    });
    $('.SV').change(function() {
	    if (this.checked) {
	        $(".Venture").attr('disabled',true).prop('checked',false);
	       
	    }else {
	         $(".Venture").removeAttr('disabled');
	        }
    });
    */
    </script>

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>