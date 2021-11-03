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
<title>Add MA_MA Exit Deal Info</title>



<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="styles/token-input.css" type="text/css" />
<link rel="stylesheet" href="styles/token-input-facebook.css" type="text/css" />





</head>

<body>
 <form name=mamaadd enctype="multipart/form-data"  method=post action="mamaaddupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php

?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add MA_MA Deal</b></td></tr>

				<tr style="font-family: Arial; font-size: 8pt">
				<td >&nbsp;Target Company</td>
				<td><input type="text" name="txtcompanyname" id = "txtcompanyname" class ="company_name" size="50" value="<?php echo $mycomprow["companyname"]; ?>" onkeyup = "nocompanyname(this.value);"> </td>
				</tr>


				<tr style="font-family: Arial; font-size: 8pt">
				<td >&nbsp;Group (Company)</td>
				<td><input type="text" name="txtcompanygroup" id = "txtcompanygroup" class ="company_group" size="50" value="" > </td>
				</tr>




                                <tr>
                                <td > &nbsp;Target Company Type</td>
                                <td > <SELECT name="target_listingstatus">
                                <OPTION value="--" selected> Choose </option>
                                <option value="L">Listed</option>
                                <option value="U">Unlisted</option>
                                 </select></td> </tr>

				<tr><td >&nbsp;Industry</td><td>
					<SELECT name="txtindustry"  id = "txtindustry"  style="font-family: Arial; color: #004646;font-size: 8pt">
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

								<tr><td >&nbsp;Sector</td>
								<td><input type="text" name="txtsector"  id = "txtsector"  size="50" value=""> </td></tr>


								<tr><td >&nbsp;Amount(US $M)</td>
								<td ><input type="text" name="txtsize" size="10" value="0" STYLE="text-align:right">
								<input name="chkhideamount" type="checkbox" >
								</td></tr>

				<tr><td >&nbsp;Stake (%)</td>
					<td >	<input type="text" name="txtstake" size="10" value="" STYLE="text-align:right">
					</td>
				</tr>

						<tr>
						 <td>&nbsp;Period</td>
						<Td width=5% align=left> <SELECT NAME=month1 style="font-family: Arial; color: #004646;font-size: 8pt">
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
							<SELECT NAME=year1 style="font-family: Arial; color: #004646;font-size: 8pt">
							<OPTION id=2 value="--" > Year </option>
							<?php

							$i=2004;
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


				<tr><td >&nbsp;Deal Type</td><td>
					<SELECT name="txtdealtype" style="font-family: Arial; color: #004646;font-size: 8pt">
				<OPTION id=0 value="--" selected> Choose Deal Type  </option>
				<?php
					 $dealtypesql="select MADealTypeId,MADealType from madealtypes order by MADealTypeId";
						if ($rsdealtypes = mysql_query($dealtypesql))
						{
						 $dealtype_cnt = mysql_num_rows($rsdealtypes);
						}
						if($dealtype_cnt>0)
						{
							 While($myrow=mysql_fetch_array($rsdealtypes, MYSQL_BOTH))
							{
								$id = $myrow[0];
								$name = $myrow[1];
								echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
							}
							mysql_free_result($rsdealtypes);
						}
				?></select></td></tr>

								<tr>
								<td >&nbsp;Advisors-Target Company</td>
								<td >
								<input name="txtAdvTargetCompany" type="text" size="50" value="">
                                            </td>
                                        </tr>
						<tr>
					<td >&nbsp;City (Target)</td>
					<td>
						<input name="txtTargetCity" id = "txtTargetCity" type="text" size="50" value=""  >
					</td></tr>


					<tr>
					 <td> &nbsp;Region (Target)</td>
					 <Td width=5% align=left> <SELECT NAME=txtregion>
					 <OPTION value="1" selected> Choose Region </option>

				<?php
					$regionSql = "select RegionId,Region from region where Region!=''";
					if ($regionrs = mysql_query($regionSql))
					{
					  $region_cnt = mysql_num_rows($regionrs);
					}
					if($region_cnt > 0)
					{
						While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$id = $myregionrow[0];
							$name = $myregionrow[1];
						echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
						}
					}
				?>
				</SELECT></td></tr>


							<tr><td >&nbsp;Country (Target)</td><td>
							<SELECT name="txtTargetCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
						<OPTION id=0 value="--" selected> Choose Country  </option>
						<?php
							 $dealtypesql="select CountryId,Country from country where countryid NOT IN('','--','10','11') order by country asc";
								if ($rsdealtypes = mysql_query($dealtypesql))
								{
								 $dealtype_cnt = mysql_num_rows($rsdealtypes);
								}
								if($dealtype_cnt>0)
								{
									 While($myrow=mysql_fetch_array($rsdealtypes, MYSQL_BOTH))
									{
										$id = $myrow[0];
										$name = $myrow[1];
										echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
									}
									mysql_free_result($rsdealtypes);
								}
				?></select></td></tr>

					<tr>
					<td >&nbsp;Website (Target)</td>
					<td >
					<input type="text" name="txtTargetwebsite" id = "txtTargetwebsite" size="50" value=""> </td>
						</tr>

				<tr>
                                    <td >&nbsp;Acquirer</td>

                                    <td><input type="text" name="txtacquirer"  id = "txtacquirer" class = "acquirer" size="50" value=""  onkeyup = "noacquirername(this.value)">
					</td>
				</tr>
                                 <tr>
                                    <td >&nbsp;Acquirer Company Type</td>
                                <td > <SELECT name="acquirer_listingstatus">
                                <OPTION value="--" selected> Choose </option>
                                <option value="L">Listed</option>
                                <option value="U">Unlisted</option>
                                    </select></td> 
                                </tr>
                                  <tr><td >&nbsp;Industry (Acquirer)</td><td>
                                        <SELECT name="txtacqindustry" id = "txtacqindustry" style="font-family: Arial; color: #004646;font-size: 8pt">
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
				<tr>
                                    <td >&nbsp;Group (Acquirer)</td>
                                    <td>
                                        <input type="text" name="txtacquirergroup" size="50" value="">
                                    </td>
				</tr>
				<tr>
					<td >&nbsp;City (Acquirer)</td>
					<td>
                                            
						<input name="txtAcquirorCity"  id= "txtAcquirorCity" type="text" size="50" value=""  >
					</td></tr>



						<tr><td >&nbsp;Country (Acquirer)</td><td>
						<SELECT name="txtAcquirorCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
					<OPTION id=0 value="--" selected> Choose Country  </option>
					<?php
						 $dealtypesql="select CountryId,Country from country where countryid NOT IN('','--','10','11') order by country asc";
							if ($rsdealtypes = mysql_query($dealtypesql))
							{
							 $dealtype_cnt = mysql_num_rows($rsdealtypes);
							}
							if($dealtype_cnt>0)
							{
								 While($myrow=mysql_fetch_array($rsdealtypes, MYSQL_BOTH))
								{
									$id = $myrow[0];
									$name = $myrow[1];
									echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
								}
								mysql_free_result($rsdealtypes);
							}
						?></select></td></tr>

								<tr>
								<td >&nbsp;Advisors-Acquirer</td>
								<td>
									<input name="txtAdvAcquiror" type="text" size="50" value=""  >
								</td></tr>




								<tr>
								<td >&nbsp;Comment</td>

								<td><textarea name="txtcomment" rows="3" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >&nbsp;More Information</td>
								<td valign=top><textarea name="txtmoreinfor" rows="3" cols="40"></textarea>
							</td>

								</tr>

								<tr>
								<td >&nbsp;Validation</td>
								<td><textarea name="txtvalidation" rows="1" cols="40"> </textarea> </td>

								</tr>

								<tr><td>&nbsp;Asset </td>
								<Td><input name="chkAssetFlag" type="checkbox" ></td></tr>

								<tr>
								<td >&nbsp;Link</td>
								<td valign=top><textarea name="txtlink" rows="3" cols="37"></textarea>
								</td></tr>


                                                                <tr>
								<td >Company Valuation (INR Cr)</td>
								<td >
								<input name="txtcompanyvaluation" id="txtcompanyvaluation" type="text" size="10" value="0.00"> </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td ><input name="txtrevenuemultiple" id="txtrevenuemultiple" type="text" size="10" value="0.00"> </td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td ><input name="txtEBITDAmultiple" id="txtEBITDAmultiple" type="text" size="10" value="0.00"> </td>
								</tr>
								<tr>
									<td >PAT Multiple</td>
									<td ><input name="txtpatmultiple" id="txtpatmultiple" type="text" size="10" value="0.00"> </td>
								</tr>
								
								<!-- New feature 08-08-2016 start 
								
									<tr>
										<td >Price to Book</td>
										<td ><input name="txtpricetobook" id="txtpricetobook" type="text" size="10" value="0.00"> </td>
									</tr>
									
									<tr>
										<td >Book Value Per Share</td>
										<td ><input name="txtbookvaluepershare" id="txtbookvaluepershare" type="text" size="10" value="0.00"> </td>
									</tr>
									
									<tr>
										<td >Price Per Share</td>
										<td ><input name="txtpricepershare" id="txtpricepershare" type="text" size="10" value="0.00"> </td>
									</tr>
								
								 New feature 08-08-2016 end -->
                                                                	<tr>
								<td >Valuation (More Info)</td>
								<td >
								<textarea name="txtvaluation" rows="3" cols="40"></textarea> </td>
								</tr>
                                                                <tr>
                                                                    <td ><b>Autofill Revenues (INR Cr), EBITDA (INR Cr), PAT (INR Cr) Values</b></td>
                                                                <td ><label> <input name="getrevenue_value" id="getrevenue_value" type="checkbox"  ></label> </td>
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
								<td >Link for Financials (LISTED FIRM ONLY)</td>
								<td><textarea name="txtfinlink" rows="3" cols="40"></textarea> </td>
								</tr>
								
								<tr>
								<td >&nbsp;Financial</td>
								<td valign=top><INPUT NAME="txtfilepath" TYPE="file" size=50>
								</td> </tr>

								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value=""  ></td>
								</tr>
									<tr><td >Hide for Aggregate (Tranche)</td>
								<td >
								<input name="chkhideAgg" type="checkbox" value="1" >

								</td>
								</tr>



<tr> <td rowspan=2>&nbsp; </td></tr>
	<tr> <td colspan=2>&nbsp; </td></tr>
	<tr style="font-family: Arial; color: #004646;font-size: 10pt"><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="mamaadd.php">Add MA_MA Deal </a></td></tr>
</table>
<table align=center>
<tr> <Td> <input type="submit" value="Add MA_MA" name="AddMAMA" > </td></tr></table>


     </form>
 <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>
		<!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
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




	// Company Name Search
    $( ".company_name" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
            type: "POST",
            url: "ajax_companyname_search_ma.php?dbtype=PE&opt=investor",
            dataType: "json",
            data: {
                search: request.term
            },
            success: function( data ) {
			
				response( $.map( data, function( item ) {
					return {
						label: item.label,
						value: item.value,
						city: item.city,
						stateid: item.stateid,
						RegionId: item.RegionId,
						industry: item.industry,
						sector_business: item.sector_business,
						website: item.website,
					}
				}));
             }
            });
        },
        minLength: 1,
		select: function( event, ui ) {
			
			$('#txtTargetCity').val(ui.item.city);
			$('#txtTargetCity').val(ui.item.city);
			$('#txtsector').val(ui.item.sector_business);
			$('#txtTargetwebsite').val(ui.item.website);
			
			if(ui.item.RegionId > 0){
				$("#region option[value="+ui.item.RegionId+"]").prop('selected', true); 
			}else{
				$("#region option[value=1]").prop('selected', true);
				$("#region").prop("disabled", false);
			}

			if(ui.item.stateid > 0){
				$("#state option[value="+ui.item.stateid+"]").prop('selected', true);  
			}else{
				$("#state option[value='--']").prop('selected', true);
				$("#state").prop("disabled", false);
			}

			if(ui.item.industry > 0){
				$("#txtindustry option[value="+ui.item.industry+"]").prop('selected', true);  
				// $(".industry").prop('disabled',true);
			}else{
				$("#txtindustry option[value='--']").prop('selected', true);
				$("#txtindustry").prop("disabled", false);
			}
		},
		open: function() {
		},
		close: function() {
			$('.company_name').val()=="";
		}
    }); 


	// Acquirer Name Search
	$( ".acquirer" ).autocomplete({
        source: function( request, response ) {
            $.ajax({
            type: "POST",
            url: "ajax_acquirer_search_ma.php?dbtype=PE&opt=investor",
            dataType: "json",
            data: {
                search: request.term
            },
            success: function( data ) {
			
				response( $.map( data, function( item ) {
					return {
						label: item.label,
						value: item.value,
						city: item.city,
						industry: item.industry,
					}
				}));
             }
            });
        },
        minLength: 1,
		select: function( event, ui ) {
			
			$('#txtAcquirorCity').val(ui.item.city);
			$('#txtAcquirorCity').val(ui.item.city);

			if(ui.item.industry > 0){
				$("#txtacqindustry option[value="+ui.item.industry+"]").prop('selected', true);  
				// $(".industry").prop('disabled',true);
			}else{
				$("#txtacqindustry option[value='--']").prop('selected', true);
				$("#txtacqindustry").prop("disabled", false);
			}
		},
		open: function() {
		},
		close: function() {
			$('.acquirer').val()=="";
		}
    });

	function nocompanyname(val)
	{
		$('#txtTargetCity').val("");
		$('#txtsector').val("");		
		$('#txtindustry').val("");
		$('#txtTargetwebsite').val("");
	}

	function noacquirername(val)
	{
		$('#txtAcquirorCity').val("");
		$('#txtacqindustry').val("");	
	}

 
    
    </script>
 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>