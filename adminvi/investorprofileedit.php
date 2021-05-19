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
<title>PE Investment Company Profile</title>
<SCRIPT LANGUAGE="JavaScript">


</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=editcompprofile method=post action="investorprofileeditupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT InvestorId,Investor,Address1,Address2,City,Zip,
   	Telephone,Fax,Email,website,linkedIn,Description,yearfounded,NoEmployees,FirmType,
   	OtherLocation,Assets_mgmt,AlreadyInvested,LimitedPartners,
   	NoFunds,NoActiveFunds,MinInvestment,AdditionalInfor,Comment,countryid,FirmTypeId,focuscapsourceid,KeyContact,angelco_invID,dry_hide,exitamount_hide
			FROM peinvestors WHERE InvestorId=$SelCompRef";
   
        $getinvestorAmount = "select SUM(peinvestments_investors.Amount_M) as total_amount FROM peinvestments 
        JOIN peinvestments_investors ON peinvestments_investors.PEId = peinvestments.PEId 
        JOIN pecompanies ON pecompanies.PECompanyId = peinvestments.PECompanyId 
        where peinvestments_investors.InvestorId = ".$SelCompRef." and peinvestments_investors.exclude_dp = 0 AND peinvestments.Deleted=0 AND 
        peinvestments.AggHide=0 and peinvestments.SPV = 0 and pecompanies.industry !=15 AND 
        peinvestments.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 )";
        
        $getexitamount="select SUM(manda_investors.Amount_M) as total_amount FROM manda 
        JOIN manda_investors ON manda_investors.MandAId = manda.MandAId 
        JOIN pecompanies ON pecompanies.PECompanyId = manda.PECompanyId 
        where manda_investors.InvestorId = ".$SelCompRef." AND manda.Deleted=0 and pecompanies.industry !=15";

		
		$investor_amount='';
        $investoramountrs = mysql_query($getinvestorAmount);
        $investorrowrow = mysql_fetch_row($investoramountrs, MYSQL_BOTH);
        $investor_amount = $investorrowrow['total_amount'];

		$exitamountrs = mysql_query($getexitamount);
        $exitrowrow = mysql_fetch_row($exitamountrs, MYSQL_BOTH);
        $exit_amount = $exitrowrow['total_amount'];
        
//echo "<br>--" .$getDatasql;
	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
                    
                     $angelco_invID = $mycomprow["angelco_invID"];
?>
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Investor Profile</b></td></tr>
				<tr>

				<!-- InvestorId -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtInvestorId" size="10" value="<?php echo $mycomprow["InvestorId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >Investor</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $investorname = $mycomprow["Investor"]; ?>"> </td>
				</tr>

                                <tr style="font-family: Verdana; font-size: 8pt">
				<td >Key Contact (for angel investors)</td>
				<td><input type="text" name="txtKeyContact" size="50" value="<?php echo $mycomprow["KeyContact"]; ?>"> </td>
				</tr>

				<tr><td >Address1 </td>
				<td><textarea name="txtaddress1" rows="2" cols="50"><?php echo $mycomprow["Address1"]; ?> </textarea> </td>
				</tr>
				<tr><td >&nbsp; </td>
				<td >
				<input type="text" name="txtaddress2" size="50" value="<?php echo $mycomprow["Address2"]; ?>">
				</td>
				</tr>
				<tr><td >City</td>
				<td>
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["City"]; ?>"> </td>
				</tr>
				<tr><td >Zip</td>
				<td>
				<input type="text" name="txtzip" size="50" value="<?php echo $mycomprow["Zip"]; ?>"> </td>
				</tr>

				<tr>
				<td>Country (Headquarters)</td>
				<td > <SELECT name="country">
					<OPTION id=0 value="--" selected> Choose Country  </option>
				<?php

					$countrysql = "select i.countryid,i.country  from country as i where i.countryid NOT IN('','--','10','11') order by i.country asc";
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
							if ($id==$mycomprow[24] && $mycomprow[24] != '')
							{
								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
							}
							else
							{
								if($mycomprow[24] == '' && $id =='IN'){
									echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION> \n";
								} else {
									echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
								}
								//echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
							}
						}
						mysql_free_result($countryrs);
					}

				?>
			</select> </td> </tR>


				<tr><td >Telephone</td>
				<td>
				<input type="text" name="txttelephone" size="50" value="<?php echo $mycomprow["Telephone"]; ?>"> </td>
				</tr>
				<tr><td >Fax</td>
				<td>
				<input type="text" name="txtfax" size="50" value="<?php echo $mycomprow["Fax"]; ?>"> </td>
				</tr>
				<tr><td >Email</td>
				<td><textarea name="txtemail" rows="2" cols="50"><?php echo $mycomprow["Email"]; ?> </textarea> </td>
				</tr>
				<tr><td >Website</td>
				<td>
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
				</tr>
                                <tr><td >LinkedIn URL</td>
				<td>
				<input type="text" name="txtlinkedin" size="50" value="<?php echo $mycomprow["linkedIn"]; ?>"> </td>
				</tr>
				<tr><td >Description</td>
				<td><textarea name="txtdescription" rows="2" cols="50"><?php echo $mycomprow["Description"]; ?> </textarea> </td>
				</tr>
				<tr><td >In India since</td>
				<td >
				<input type="text" name="txtyearfounded" size="50" value="<?php echo $mycomprow["yearfounded"]; ?>">
				</td>
				</tr>
				<tr><td >No Of Employees</td>
				<td>
				<input type="text" name="txtnoemployees"  size="50" value="<?php echo $mycomprow["NoEmployees"]; ?>"> </td>
				</tr>
				<tr><td >Firm Type(Old)</td>
				<td >
				<input type="text" name="txtfirmtype" size="50" value="<?php echo $mycomprow["FirmType"]; ?>">
				</td>
				</tr>

				<tr>
				<td>Firm Type</td>
				<td> <SELECT name="firmtype">
				<OPTION id=0 value=0 selected> Choose </option>
				<?php

                                        $firmtypesql = "select FirmTypeId,FirmType from firmtypes  ORDER BY FIELD(FirmTypeId,13,2,1,14,12,8,7,4,9,6,10,5,11,3)";
					if ($firmtypers = mysql_query($firmtypesql))
					{
					  $firmtype_cnt = mysql_num_rows($firmtypers);
					}
					if($firmtype_cnt > 0)
					{
						While($myftrow=mysql_fetch_array($firmtypers, MYSQL_BOTH))
						{
							$id = $myftrow[0];
							$name = $myftrow[1];
							if ($id==$mycomprow[25])
							{
								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
							}
							else
							{
								echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
							}
						}
						mysql_free_result($firmtypers);
					}
				?>
			       </select> </td> </tR>

			       	<tr>
				<td>Focus & Capital Source</td>
				<td> <SELECT name="focuscapitalsource">
				<OPTION id=0 value=0 selected> Choose </option>
				<?php

					$foucscapitalsql = "select focuscapsourceid,focuscapsource from focus_capitalsource ";
					if ($foucscapitalrs = mysql_query($foucscapitalsql))
					{
					  $focus_cap_cnt = mysql_num_rows($foucscapitalrs);
					}
					if($focus_cap_cnt > 0)
					{
						While($myfoccaprow=mysql_fetch_array($foucscapitalrs, MYSQL_BOTH))
						{
							$id = $myfoccaprow[0];
							$name = $myfoccaprow[1];
							if ($id==$mycomprow[26])
							{
								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
							}
							else
							{
								echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
							}
						}
						mysql_free_result($firmtypers);
					}
				?>
			       </select> </td> </tR>



				<tr><td >Other Location(s)</td>
				<td><textarea name="txtotherlocation" rows="2" cols="50"><?php echo $mycomprow["OtherLocation"]; ?> </textarea> </td>
				</tr>
				<tr><td >Assets Under Management (US$ Million)</td>
				<td>
                               
				<input type="text" name="txtassets_mgmt" size="50" value="<?php echo $mycomprow["Assets_mgmt"]; ?>"> </td>
				</tr>
				<tr><td >Already Invested (US$ Million)</td>
				<td>
				<input type="text" name="txtalreadyinvested" size="50" readonly value="<?php echo $investor_amount; ?>"> </td>
				</tr>
				<tr><td >Already Exited (US$ Million)</td>
				<td>
				<input type="text" name="txtexitamount" size="50" readonly value="<?php echo $exit_amount; ?>"> 
                <input type="checkbox" name="txthideexitamount" value="1" <?php if($mycomprow["exitamount_hide"]==1){ echo 'checked';} ?>>Hide Exit Amount 
                                </td>
				</tr>
                                <tr><td >Dry Powder (US$ Million)</td>
				<td>
                                    <?php 
                                    
                                        if($mycomprow["Assets_mgmt"]!=''){
                                           $Assets_mgmt = (int)preg_replace("/[^0-9\.]/", '', $mycomprow["Assets_mgmt"]);
                                        }else{
                                            $Assets_mgmt = 0;
                                        }
                                    ?>
				<input type="text" name="txtalreadyinvested" size="50" readonly value="<?php echo  $Assets_mgmt - $investor_amount; ?>"> 
                                <input type="checkbox" name="txthidedrypowder" value="1" <?php if($mycomprow["dry_hide"]==1){ echo 'checked';} ?>>Hide Dry powder 
                                </td>
				</tr>
				<tr><td >Limited Partners</td>
				<td>
				<input type="text" name="txtlps" size="50"  value="<?php echo $mycomprow["LimitedPartners"]; ?>"> </td>
				</tr>
				<tr><td >No of Funds</td>
				<td>
				<input type="text" name="txtnofunds" size="50"  value="<?php echo $mycomprow["NoFunds"]; ?>"> </td>
				</tr>
				<tr><td >No of Active Funds</td>
				<td>
				<input type="text" name="txtactivefunds" size="50"  value="<?php echo $mycomprow["NoActiveFunds"]; ?>"> </td>
				</tr>
				<tr><td >Minimum Investment Size (US$ Million)</td>
				<td>
				<input type="text" name="txtmininvestment" size="50"  value="<?php echo $mycomprow["MinInvestment"]; ?>"> </td>
				</tr>
				<tr><td >Additional Information</td>
				<td><textarea name="txtaddinfor" rows="2" cols="50"><?php echo $mycomprow["AdditionalInfor"]; ?> </textarea> </td>
				</tr>
				<tr><td >Comment</td>
				<td><textarea name="txtcomment" rows="2" cols="50"><?php echo $mycomprow["Comment"]; ?> </textarea> </td>
				</tr>


					<tr>
					<td>Management
					<input type="button" value="Add Executive" name="btnaddmgmt"
					onClick="window.open('addinvestorMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=400')">

					</td>
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strManagement="";
					 $getInvestorsSql="select peinv.InvestorId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
					 peinvestors_management as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.InvestorId=$SelCompRef";

					  if ($rsinvestors = mysql_query($getInvestorsSql))
					  {
						While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
						{
							$strManagement=$strManagement.", ".$myInvrow["ExecutiveName"];
							if(trim($myInvrow["Designation"])!="")
								$strManagement=$strManagement.", ".$myInvrow["Designation"];
							if(trim($myInvrow["Company"])!="")
								$strManagement=$strManagement.", ".$myInvrow["Company"];
						  $strManagement =substr_replace($strManagement, '', 0,1);

							//$strManagement=$strManagement.";";
						?>
					<tr style="font-family: Verdana; font-size: 8pt" >
					<td valign=top width="20" >
					<input name="txtmgmtExecutiveId[]" type="text" READONLY size="10" value=" <?php echo $myInvrow["ExecutiveId"]; ?>"  >
					</td>
					<td> <input type="text" name="txtmgmtExecutiveName[]"  size="50" value="<?php echo trim($strManagement); ?> "> </td>
					</tr>

					<?php
						$strManagement="";
						}

					?>
						<!--<tr><td valign=top >
						<td valign=top><textarea name="txtboard" rows="2" cols="50"><?php echo trim($strManagement); ?> </textarea> </td>
						</tr> -->

					<?php
					}
					?>
					</table>
					</td>
				</tr>




			<?php
				}
			mysql_free_result($companyrs);
		}

 ?>

                                
                                
                                    <tr>
                                        <td style="padding: 50px 10px; font-size: 13px;"  colspan='2' >

                                            <span>  <u>Angel.co</u> Company ID :     </span> <input type="text" value="<?php echo $angelco_invID ?>" id="angelco_compID" name="angelco_compID" size="50" >

                                            <br><br><br>
                                            <b> Search <u>Angel.co</u>  Api  </b>

                                            <input type="text" value="<?php echo $investorname; ?>" name="search_txt" id="search_txt" size="50" >
                                            <input type="button" value="Search" id="search_angelcoAPI" name="search_angelcoAPI" >
                                            <br><br>
                                            <div id="results" style="display: none">

                                            </div>
                                        </td>
                                    </tr>  

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update" name="updateDeal" > </td></tr></table>


     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>

   
   
   
   
   
    <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
   
   <script type="text/javascript" >
    $(document).ready(function () {
        
        
         $('div').on("click", ".angelcomp", function() {
             var angelco_compID=  $("input[name=angelcomp]:checked").val();
             
             $('#angelco_compID').val(angelco_compID);
        
         });
        

        $('#search_angelcoAPI').click(function (e) {
          $('#results').hide();
           $('#results').html('');
          
          var searchtxt = $('#search_txt').val();
            var formData ={'search':searchtxt};

            $.ajax({
                url: 'searcAngelCoAPI.php?investorsearch',
                type: 'POST',
                data: formData,
                timeout: 30000, // in milliseconds
                success: function (data) {
                    
//                    data = $.parseJSON(data);
//                    count = data['count'];
//                    results = data['count'];
                    
                    if(data==0){
                        
                       // alert('No results');
                       $('#results').html('<br><i style="color:red">No results found</i>');
                       $('#results').show();
                        return false;
                    }
                    else{
                         $('#results').html(data);
                         $('#results').show();
                         return false;
                    }
                    
                },
                error: function (request, statusCode, err) {
                    alert("Check Network Connectivity and Try Again");
                    return false;
                }
            });
            return false;
        });

    });
</script>


 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>