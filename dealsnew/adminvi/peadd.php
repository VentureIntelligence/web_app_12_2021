<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
?>
<html><head>
<title>Add PE Investment Deal Info</title>
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
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add Deal</b></td></tr>

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


								<tr><td >Sector</td>
								<td>
								<input type="text" name="txtsector" size="50" value=""> </td>
								</tr>

								<tr><td >Amount</td>
								<td >
								<input type="text" name="txtamount" size="10" value="">
								<input name="chkhideamount" type="checkbox" >

								</td>
								</tr>

								<tr><td >Round</td>
								<td>
								<input type="text" name="txtround" size="50" value=""> </td>
<!--                                                                <SELECT name="txtround">
                                                                   <OPTION value="--" > Choose Round </option>
                                                                   <OPTION  value="Open Market Transaction" >Open Market Transaction </OPTION>
                                                                   <OPTION  value="Preferential Allotment" >Preferential Allotment </OPTION>
                                                                </select>   -->
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

								<tr>
									<td>Investors </td>
										<Td>
										<input name="txtinvestors" type="text" size="50" value="" >
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
								<input type="text" name="txtcity" size="50" value=""> </td>
								</tr>

								<tr>
									 <td> Region</td>
									 <Td width=5% align=left> <SELECT NAME=txtregion>

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



                                              <tr>
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
								echo "<tr><td><input type=checkbox name=dbtype[] value=".$id." > ".$space .$name .$space;
								echo "&nbsp;-----<input type=checkbox name=showaspevc[] value=".$id." > ";
                                                                echo" </td></tr>";
							}
						 mysql_free_result($debtypers);
						}

					?>
                              		    </table></td></tr>


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

   
   
   <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
   
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
 
    
    </script>

 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>