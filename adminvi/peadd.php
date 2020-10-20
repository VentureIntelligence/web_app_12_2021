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
		// SHP key
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
?>
<html><head>
<title>Add PE Investment Deal Info</title>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
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
                    $("#state option[value='--']").prop('selected', true);
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
   </style>
<SCRIPT LANGUAGE="JavaScript">
function checkCompany()
{
	//alert(document.adddeal.txtregion.selectedIndex)
	missinginfo = "";
	var compname="Undisclosed";
	var usercompname;
	usercompname=document.adddeal.txtcompanyname.value;
	//alert(usercompname);

	if(usercompname.toLowerCase() == compname.toLowerCase())
		missinginfo += "\n     -  Please use Undisclosed followed by some string delimted by "-" for the Company Name";
	if(document.adddeal.txtstage.selectedIndex ==0)
		missinginfo += "\n     -  Please select Stage from the list";

	if(document.adddeal.txtregion.selectedIndex==0)
		missinginfo += "\n     -  Please select Region";
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
 <form name=adddeal enctype="multipart/form-data" onSubmit="return checkCompany();" method=post action="peaddupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add Deal</b></td></tr>
		   						<tr style="display:none;"><td><input type="hidden" name="peid" value="<?php echo $IPO_MandAId;?>"/></td></tr>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Company</td>
								<td><input type="text" name="txtcompanyname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>
                                                                <tr>
                                                                    <td>Period</td>
                                                                    <Td width=5% align=left> 
                                                                    <SELECT NAME=month1>
                                                                        <OPTION id=1 value="--" > Month </option>
                                                                        <OPTION VALUE=1 selected>Jan</OPTION>
                                                                        <OPTION VALUE=2>Feb</OPTION>
                                                                        <OPTION VALUE=3>Mar</OPTION>
                                                                        <OPTION VALUE=4>Apr</OPTION>
                                                                        <OPTION VALUE=5>May</OPTION>
                                                                        <OPTION VALUE=6>Jun</OPTION>
                                                                        <OPTION VALUE=7>Jul</OPTION>
                                                                        <OPTION VALUE=8>Aug</OPTION>
                                                                        <OPTION VALUE=9>Sep</OPTION>
                                                                        <OPTION VALUE=10>Oct</OPTION>
                                                                        <OPTION VALUE=11>Nov</OPTION>
                                                                       <OPTION VALUE=12>Dec</OPTION>
                                                                    </SELECT>
								<SELECT NAME=year1>
								<OPTION id=2 value="--" > Year </option>
								<?php

								$i=1998;
								While($i<= $currentyear )
								{
								    $id = $i;
								    $name = $i;
								    if ($id==$currentyear)
								    {
									    echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
								    }
								    else
								    {
									    echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
								    }
								    $i++;
								}
								?> </SELECT>

	   				 			</td></tr>
                                                                <tr>
								<td >Listing Status</td>
								<td > 
<!--                                                                    <SELECT name="listingstatus">
								 <OPTION value="--" selected> Choose </option>
								<option value="L">Listed</option>
                                                                  <option value="U">Unlisted</option>
                                                               </select>-->
                                                            <label for="listed"><input type="radio" name="listingstatus" id="listed" value="L"> Listed </label>    
                                                            <label for="unlisted"><input type="radio" name="listingstatus" id="unlisted" value="U" checked="checked"> Unlisted </label>
                                                                
                                                                
                                                                </td>
								</tr>
                                                        <tr>
                                                            <td >Exit Status</td>
                                                            <td > 
                                                                <SELECT name="exitstatus">
                                                                    <OPTION value="0" selected>Select Exit Status </option>
<!--                                                                    <option value="1">Unexited</option>
                                                                    <option value="2">Partially Exited</option>
                                                                    <option value="3">Fully Exited</option>-->
                                                                    <?php

									$exitstatusSql = "select id,status from exit_status";
									if ($exitstatusrs = mysql_query($exitstatusSql))
									{
									  $exitstatus_cnt = mysql_num_rows($exitstatusrs);
									}
									if($exitstatus_cnt > 0)
									{
										While($myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
                                                                                    if($id==1){ 
                                                                                        
                                                                                        echo "<OPTION id=". $id. " value=". $id." selected>".$name."  </OPTION>\n";
										}
                                                                                    else{
                                                                                        echo "<OPTION id=". $id. " value=". $id.">".$name."  </OPTION>\n";
									}
                                                                                    
										}
									}
								?>
                                                                </select>
                                                            </td>
                                                        </tr>

							<tr><td >Industry</td><td>
								<SELECT name="txtindustry" style="font-family: Arial; color: #004646;font-size: 8pt">
							<OPTION id=0 value="--" selected> Choose Industry  </option>
							<?php
								 $industrysql="select industryid,industry from industry where industryid !=15 order by industry";
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
											echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
										}
										mysql_free_result($industryrs);
									}
		    				?></select></td></tr>


								<tr><td >Sector (Front end)</td>
								<td>
								<input type="text" name="txtsector" size="50" value=""> </td>
								</tr>
								
								<tr><td >Sector</td>
								<td>
								<input type="text" name="txtmainsector" size="50" value=""> </td>
								</tr>
								<tr><td >Sub Sector</td>
								<td>
								<input type="text" name="txtsubsector" size="50" value=""> </td>
								</tr>
								<tr><td >Additional Sub Sector</td>
								<td>
								<input type="text" name="txtaddsubsector" size="50" value=""> </td>
								</tr>

								<tr><td >Amount $M</td>
								<td >
								<input type="text" name="txtamount" size="10" value="">
								<input name="chkhideamount" type="checkbox" >

								</td>
								</tr>

								<tr><td >Amount INR</td>
								<td >
								<input type="text" name="txtamount_INR" size="10" value="">

								</td>
								</tr>

								<tr><td >Round</td> 
								<td>
								<!--<select name="txtround" id="round" >
                                                                    <option id="round_1" value="seed" >Seed</option>
                                                                    <?php
                                                                        $j=1; 
                                                                        $seed=13;
                                                                        for($i=1; $i<$seed; $i++) {
                                                                            $j++;
                                                                                echo '<option id="round_'.$j.'" value="'.$i.'" >'.$i.'</option>';
                                                                        }

                                                                        ?>
                                                                        <option id="round_Open" value="Open Market Transaction" >Open Market Transaction</option>
                                                                        <option id="round_Preferential" value="Preferential Allotment">Preferential Allotment</option>
                                                                        <option id="round_Rights" value="Rights Issue">Rights Issue</option>
                                                                        <option id="round_Share" value="Share Swap">Share Swap</option>                                                                        
                                                                        <option id="round_Special" value="Special Situation">Special Situation</option>                                                                      
                                                                        <option id="round_Debt" value="Debt">Debt</option> 
                                                            </select>-->
                                                                 <input type="text" name="txtround" id="round" size="30" value="">   
                                                                </td>
								</tr>

								<tr>
								<td >Stage</td>
								<td > <SELECT name="txtstage">
								 <OPTION value="--" > Choose Stage </option>
								<?php
								$stageSql = "select StageId,Stage from stage order by StageId";
									if ($rsStage = mysql_query( $stageSql))
									{
									  $stage_cnt = mysql_num_rows($rsStage);
									}
									if($stage_cnt > 0)
									{
										While($myrow=mysql_fetch_array($rsStage, MYSQL_BOTH))
										{
											$stageid = $myrow[0];
											$stagename = $myrow[1];
											echo "<OPTION id=". $stageid. " value=". $stageid." >".$stagename."  </OPTION>\n";

										}
										mysql_free_result($rsStage);
									}
								?>
								</select></td>
								</tr>

								<!--<tr>
									<td>Investors </td>
										<Td>
										<input name="txtinvestors" type="text" size="50" value="" >
										</td>
								</tr>-->
								<tr>
									<td>&nbsp;Investors
									<td valign="top" style="font-family: 'Verdana'; font-size: 8pt;" align='left'>
										<input type="hidden" name="hideIPOId" size="8" value="">
										<input type="button" value="Add Investors" name="addInvestor"
										onClick="window.open('addPEInvestors.php?value=PE/<?php echo $IPO_MandAId;?>','mywindow','width=700,height=500')">
									</td>
								</tr>
								<tr>
									<td>&nbsp;SHP
									<td valign="top" style="font-family: 'Verdana'; font-size: 8pt;" align='left'>
										<input type="hidden" name="hideSHPId" size="8" value="">
										<input type="button" value="Add SHP" name="addInvestor"
										onClick="window.open('addPESHP.php?value=PE/<?php echo $IPO_MandAId;?>','mywindow','width=700,height=500')">
									</td>
								</tr>

							<tr>
									 <td> Investor Type </td>
									 <Td width=5% align=left> <SELECT NAME=invType>


								<?php

									$investorTypeSql = "select InvestorType,InvestorTypeName from investortype";
									if ($invTypers = mysql_query($investorTypeSql))
									{
									  $invType_cnt = mysql_num_rows($invTypers);
									}
									if($invType_cnt > 0)
									{
										While($myrow=mysql_fetch_array($invTypers, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
										echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
										}
									}
								?>
								</SELECT></td></tr>


								<tr>
								<td >Stake Percentage</td>
								<td >
								<input type="text" name="txtstake" size="10" value="">
								<input name="chkhidestake" type="checkbox" ></td>

								</tr>
							 
								<tr>
								<td >Website</td>
								<td >
								<input type="text" name="txtwebsite" size="50" value=""> </td>
								</tr>

								<tr>
								<td >City</td>
								<td >
                                                                    <input type="hidden" id="cityauto" name="txtcity" value="<?php if($city!='') echo  $_POST['cityauto'];  ?>" placeholder="" style="width:220px;" autocomplete="off" <?php if($city!='') echo "readonly='readonly'";  ?>>
                                                                    <input type="text" id="citysearch" name="citysearch" value="<?php if(isset($city)) echo  $city;  ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>>
<!--								<input type="text" name="txtcity" size="50" value=""> </td>-->
								</tr>
								<tr>
								<td >State</td>
								<td >
                                     <SELECT NAME=txtstate id="state">
                                     	 <OPTION  value='--' selected>Choose State</OPTION>  
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

								</tr>

								<tr>
									 <td> Region</td>
									 <Td width=5% align=left> 
                                                                             <SELECT NAME=txtregion id="region">

								<?php
									$regionSql = "select RegionId,Region from region order by RegionId";
									if ($regionrs = mysql_query($regionSql))
									{
									  $region_cnt = mysql_num_rows($regionrs);
									}
									if($region_cnt > 0)
									{
										While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
										echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
										}
									}
								?>
								</SELECT></td></tr>

								<tr>
								<td >Advisors-Company</td>
								<td >
									<input name="txtAdvCompany" type="text" size="50" value="">
									</td></tr>


								<tr>
								<td >Advisors-Investors</td>
								<td>
									<input name="txtAdvInvestor" type="text" size="50" value=""  >
								</td></tr>


								<tr>
								<td >Comment</td>

								<td><textarea name="txtcomment" rows="3" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >More Information</td>
								<td><textarea name="txtmoreinfor" rows="3" cols="40"></textarea> </td>
								</tr>
								<tr>
								<td >Validation</td>
								<td><textarea name="txtvalidation" rows="2" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >Link</td>
								<td><textarea name="txtlink" rows="3" cols="40"></textarea> </td>
								</tr>

                                                                <tr>
								<td >Company Valuation (INR Cr)</td>
								<td >
                                                                    <ul class="add_ul"><li>Pre-Money</li><li> Post-Money</li><li> EV</li></ul>
                                                                    <input name="txtcompanyvaluation" id="txtcompanyvaluation" type="text" size="10" value='' > 
                                                                    <input name="txtcompanyvaluation1" id="txtcompanyvaluation1" type="text" size="10" value='' > 
                                                                    <input name="txtcompanyvaluation2" id="txtcompanyvaluation2" type="text" size="10" value='' >                                                                 
                                                                </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td >
                                                                    <input name="txtrevenuemultiple" id="txtrevenuemultiple" type="text" size="10" value='' >
                                                                    <input name="txtrevenuemultiple1" id="txtrevenuemultiple1" type="text" size="10" value='' >
                                                                    <input name="txtrevenuemultiple2" id="txtrevenuemultiple2" type="text" size="10" value='' >
                                                                </td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td >
                                                                    <input name="txtEBITDAmultiple" id="txtEBITDAmultiple" type="text" size="10" value='' >
                                                                    <input name="txtEBITDAmultiple1" id="txtEBITDAmultiple1" type="text" size="10" value='' >
                                                                    <input name="txtEBITDAmultiple2" id="txtEBITDAmultiple2" type="text" size="10" value='' >
                                                                </td>
								</tr>
								<tr>
									<td >PAT Multiple</td>
								<td >
                                                                    <input name="txtpatmultiple" id="txtpatmultiple" type="text" size="10" value=''>
                                                                    <input name="txtpatmultiple1" id="txtpatmultiple1" type="text" size="10" value=''>
                                                                    <input name="txtpatmultiple2" id="txtpatmultiple2" type="text" size="10" value='' >
                                                                </td>
								</tr>
								
								<!-- New feature 08-08-2016 start -->
								
									<tr>
										<td >Price to Book</td>
										<td ><input name="txtpricetobook" id="txtpricetobook" type="text" size="10" value="0.00"> </td>
									</tr>
								
								<!-- New feature 08-08-2016 end -->

                                                                <tr>
								<td >Valuation (More Info)</td>
								<td >
								<textarea name="txtvaluation" rows="3" cols="40"></textarea> </td>
								</tr>
                                                                
                                                                <tr>
                                                                    <td colspan="2" height="25"></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td ><b>Autofill Revenues (INR Cr), EBITDA (INR Cr), PAT (INR Cr) Values</b></td>
                                                                <td ><label> <input name="getrevenue_value" id="getrevenue_value" type="checkbox"  ></label> </td>
							        </tr>
								<tr>
                                                                    <td>Financial/Calendar Year</td>
                                                                    <td><input name="txtyear" id="txtyear" type="text" size="15" value=""> </td>
                                                                </tr>
								<tr>
								<td >Revenues (INR Cr)</td>
                                                                <td ><input name="txtrevenue" id="txtrevenue" type="text" size="10" value="0.00"> </td>
							        </tr>
								<tr>
								<td >EBITDA (INR Cr)</td>
								<td ><input name="txtEBITDA" id="txtEBITDA" type="text" size="10" value="0.00"> </td>
								</tr>
								<tr>
								<td >PAT (INR Cr)</td>
                                                                <td ><input name="txtpat" id="txtpat" type="text" size="10" value="0.00"> </td>
								</tr>
                                                                <tr>
									<td >Total Debt (INR Cr)</td>
									<td ><input name="txttot_debt" id="txttot_debt" type="text" size="10" value='' ></td>
								</tr>
								
								<tr>
									<td >Cash & Cash Equ. (INR Cr)</td>
									<td ><input name="txtcashequ" id="txtcashequ" type="text" size="10" value='' ></td>
								</tr>
                                                                <tr>
                                                                        <td >Book Value Per Share</td>
                                                                        <td ><input name="txtbookvaluepershare" id="txtbookvaluepershare" type="text" size="10" value="0.00"> </td>
                                                                </tr>

                                                                <tr>
                                                                        <td >Price Per Share</td>
                                                                        <td ><input name="txtpricepershare" id="txtpricepershare" type="text" size="10" value="0.00"> </td>
                                                                </tr>
								<tr>
                                                                    <td colspan="2" height="25"></td>
                                                                </tr>
								<tr>
								<td >Link for Financials (LISTED FIRM ONLY)</td>
								<td><textarea name="txtfinlink" rows="3" cols="40"></textarea> </td>
								</tr>
								
								<!--<tr>
								<td >&nbsp;Financial</td>
								<td valign=top><INPUT NAME="txtfilepath" TYPE="file" size=50>
								</td> </tr> -->

								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value=""  ></td>
								</tr>
								
								<tr><td >Hide for Aggregate (Tranche)</td>
								<td >
								<input name="chkhideAgg" type="checkbox" value="1" >

								</td>
								</tr>

                                                                <tr><td >Debt </td>
								<td >
								<input name="chkSPVdebt" type="checkbox" value="1" >

								</td>
								</tr>



                                             <!--  <tr>
								<th align=left >&nbsp;DB Type----HIDE as PE/VC Deal</th>
								<td><table>
                                                                					<?php
                                                 //echo mysql_num_rows(mysql_query('select DBTypeId,DBType from dbtypes'));
                                                 
                                                $dbtypesql = "select `DBTypeId`,`DBType` from `dbtypes`";
						if ($debtypers = mysql_query($dbtypesql))
						{
						  $db_cnt = mysql_num_rows($debtypers);
						}
                                                
						if($db_cnt > 0)
						 {
							 While($myrow=mysql_fetch_array($debtypers, MYSQL_BOTH))
							{
								$id = $myrow[0];
								$name = $myrow[1];
								//echo "<tr><td><input type=checkbox name=dbtype[] value=".$id." > ".$space .$name .$space;
								//	echo "&nbsp;-----<input type=checkbox name=showaspevc[] value=".$id." > ";
                                                                echo" </td></tr>";
							}
						 mysql_free_result($debtypers);
						}

					?>
                              		    </table></td></tr> -->


 						<?php $dbtypesql = "select `DBTypeId`,`DBType` from `dbtypes`";
												if ($debtypers = mysql_query($dbtypesql)) {
													$db_cnt = mysql_num_rows($debtypers);
												} 
												if ($db_cnt > 0) {
													while ($myrow = mysql_fetch_array($debtypers, MYSQL_BOTH)) {
														$id = $myrow[0];
														$name = $myrow[1];

														
															echo "<tr><td>". $name . "&nbsp;also</td>";echo "<td><input class='checkid $name'  type=checkbox name=dbtype[] value=" . $id . " ></td></tr>";
														/*if($id !='CT' && $id !="IF") {
															
														echo "<tr><td>". $name ."&nbsp;only </td>";echo "<td><input class='uncheckid $id' $ishidden type=checkbox name=showaspevc[] value=" . $id . "  ></td></tr>";
														}
*/
														// echo "<tr><td><input type=checkbox name=dbtype[] value=" . $id . " > " . $space . $name . $space;"</td>";
														// echo "<td>&nbsp;-----<input type=checkbox name=showaspevc[] value=" . $id . " > ";
														// echo "</td></tr>";
													}
													mysql_free_result($debtypers);
												}
						?>


	<tr> <td colspan=2>&nbsp; </td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="peadd.php">Add PE Deal </a></td></tr>
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
    
    </script>

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>