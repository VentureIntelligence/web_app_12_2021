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

<SCRIPT LANGUAGE="JavaScript">
function delUploadFile()
{
	document.addipo.action="delipovaluationworking.php";
	document.addipo.submit();
}
</SCRIPT>

<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=addipo method=post action="ipoupdatedata.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=65%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
	$currentyear = date("Y");
   	$getDatasql = "SELECT pe.PECompanyId, pe.price_to_book,pe.book_value_per_share,pe.price_per_share, pec.companyname, pec.industry, pec.sector_business,pec.website,
      	 pe.IPOSize, pe.IPOAmount,IPOValuation, DATE_FORMAT( IPODate, '%M' )  as dates,
      	 pec.website, pec.city, pec.region, IPOId,DATE_FORMAT( IPODate, '%Y' ) as dtyear, Comment,MoreInfor,
      	 Validation,pe.InvestorType,hideamount,hidemoreinfor,VCFlag,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,
         Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors ,Valuation,FinLink ,ExitStatus,Valuation_Working_fname,Revenue,EBITDA,PAT,pe.stakeSold
  			FROM ipos AS pe, industry AS i, pecompanies AS pec
  			WHERE pe.IPOId =" .$SelCompRef.
  			" AND i.industryid = pec.industry
			AND pec.PEcompanyID = pe.PECompanyID ";
	//echo "<br>-------------".$getDatasql;
// $getAdvCompanySql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
//										advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
//	echo "<Br>".$getAdvCompanySql;



	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
				if($mycomprow["hideamount"]==1)
					$hideamount="checked";
				if($mycomprow["hidemoreinfor"]==1)
					$hidemoreinfor="checked";
				if($mycomprow["VCFlag"]==1)
					$vcflag="checked";

                                if($mycomprow["InvestorSale"]==1)
                                {   $chk_investorsale="checked"; }
                                // echo "<br>%%%%%%%%%%%%%%%%%%%%".
					//echo "<br>checked- ".$hideamount;
					//echo "<br>checked stake- ".$hidestake;
			  $strAdvComp="";
			  $advcompanysql="select advcomp.PEId,advcomp.ACIAId,cia.Advisor_cianame from peinvestments_advisorcompanies as advcomp,
				advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.ACIAId=cia.ACIAId";
			  //echo "<Br>".$advcompanysql;
			  if ($rsAdvisorCompany = mysql_query( $advcompanysql))
			  {
				While($myInvrow=mysql_fetch_array($rsAdvisorCompany, MYSQL_BOTH))
				{
					$strAdvComp=$strAdvComp .", ".$myInvrow["Advisor_cianame"];
				}
				  $strAdvComp =substr_replace($strAdvComp, '', 0,1);
			  }

			?>

		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Deal</b></td></tr>
				<tr>

								<!-- industry id -->
								<td>
								<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow["industry"]; ?>"> </td>

								<!-- PE id -->
								<td>
								<input type="hidden" name="txtIPOId" size="10" value="<?php echo $mycomprow["IPOId"]; ?>"> </td>

								<!-- PECompanyid -->
								<td>
								<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>"> </td>
								</tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Company</td>
								<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>

								<tr>
								<td>&nbsp;Industry</td>
								<td > <SELECT name="industry">

								<?php

								 	$industrysql = "select distinct i.industryid,i.industry  from industry as i
									order by i.industry";
									if ($industryrs = mysql_query( $industrysql))
									{
									  $ind_cnt = mysql_num_rows($industryrs);
									}
								  	if($ind_cnt > 0)
									{
								 		While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											if ($id==$mycomprow["industry"])
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
											}
										}
							 			mysql_free_result($industryrs);
									}

								?>
								</select> </td> </tR>

								<tr><td >&nbsp;Sector (Rs)</td>
								<td >
								<input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>">

								<tr><td >&nbsp;Deal Size (US $M)</td>
								<td>
								<input type="text" name="txtdealSize" size="10" value="<?php echo $mycomprow["IPOSize"]; ?>">
								<input name="chkhideamount" type="checkbox" value=" <?php echo $mycomprow["hideamount"]; ?>" <?php echo $hideamount; ?>></td>
								</tr>

								<tr><td >&nbsp;Deal Amount (Rs)</td>
								<td >
								<input type="text" name="txtamount" size="10" value="<?php echo $mycomprow["IPOAmount"]; ?>">


								</td>
								</tr>

								<tr><td >&nbsp;Deal Valuation (US $M)</td>
								<td>
								<input type="text" name="txtvaluation" size="10" value="<?php echo $mycomprow["IPOValuation"]; ?>"> </td>
								</tr>
								<tr><td >&nbsp;Stake Sold</td>
								<td >
								<input type="text" name="txtstakesold" size="10" value="<?php echo $mycomprow["stakeSold"]; ?>">
								</td>
								</tr>

								<tr>
									<td>&nbsp;Investors , Multiple Return, More Info
									<td valign=topstyle="font-family: Verdana; font-size: 8pt" align=left>
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									//$strInvestor=array();
									$i=0;
									  $getInvestorsSql="select peinv.IPOId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,peinv.InvMoreInfo,peinv.IRR from ipo_investors as peinv,
									  peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.IPOId=$SelCompRef";
                                               				  if ($rsinvestors = mysql_query($getInvestorsSql))
									  {
										While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
										{
											$investorString=$myInvrow["Investor"];
											$strInvestorValue =ereg_replace(" ","/",$investorString);
                                                                                        $strInvestor[$i]=$strInvestorValue.",".$myInvrow["MultipleReturn"].",".$myInvrow["IRR"];
                                                                                        $invMoreInfo[$i]=$myInvrow["InvMoreInfo"];
   										?>
									<!-- <tr>    
										    <td valign=top width="100" style="font-family: Verdana; font-size: 8pt" > -->
												<input name="txtinvestorid[]" type="hidden" value=" <?php echo $myInvrow["InvestorId"]; ?>"  >
											<!-- </td>
									</tr> -->
                                                                	<?php
                                                                	          $i=$i+1;
										}
										  $cnt=count($strInvestor);
										  $strInvestorValueString="";
										  //$strInvestor =substr_replace($strInvestor, '', 0,1);
										  for ($k=0;$k<=$cnt-1;$k++)
		                                                                    {
                                                                                     // echo "<br>****".$strInvestor[$k];
                                                                                      $strInvestorValueString =ereg_replace("/"," ",$strInvestor[$k]);
                                                                                      $invMoreInfoString=$invMoreInfo[$k];
                                                                                     // echo "<br>^^^^".$strInvestorValueString;
                                                                          ?>
										<tr><td> 
											<?php echo $strInvestorValueString;?>
												<!-- <input type="text" name="txtinvestorsReturn[]"  size="48" value="<?php //echo $strInvestorValueString;?>" >
                                                                                <textarea name="txtinvmoreinfo[]" rows="1" cols="40"><?php //echo $invMoreInfoString; ?> </textarea> </td> -->
                                                                                </tr>
                                                                     	<?php
                                                                                    } // end of kloop
									}
									?>
									</table>
									</td>
								</tr>
								<tr> <td> <input type="hidden" name="hideIPOId" size="7" value="">
                                                                 </td><td><input type="button" value="Add Investors,Return Multiple and More Info" name="addInvestor"
                              					onClick="window.open('addInvestors_Exit.php?value=IPO/<?php echo $SelCompRef;?>','mywindow','width=700,height=500')"> </td></tR>
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
											if ($id==$mycomprow["InvestorType"])
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
											}
										}
										mysql_free_result($invTypers);
									}
								?>
								</SELECT></td></tr>


                                                <tr><td >&nbsp;Investor Sale ?</td>
								<td>
								<input name="chkinvestorsale" type="checkbox" value=" <?php echo $mycomprow["InvestorSale"]; ?>" <?php echo $chk_investorsale; ?>></td>
								</tr>

                                                 <tr>
								<td>Exit Status</td>
								<td > <SELECT name="exitstatus">
                                                                 	<OPTION value="--" SELECTED> Choose  </option>
								<?php
								$exit_statusvalue=$mycomprow["ExitStatus"];
                                                					if ($exit_statusvalue==0)
                                                                                        {
                                                                                          echo "<OPTION  value=0 SELECTED>Partial  </OPTION>\n";
                                                                                          echo "<OPTION value=1 >Complete  </OPTION>\n";
                                                                                        }
                                                				         elseif($exit_statusvalue==1)
                                                				         {
                                                                                            echo "<OPTION  value=0>Partial  </OPTION>\n";
                                                                                            echo "<OPTION value=1 SELECTED>Complete  </OPTION>\n";
                                                                                          }
                                                                                          else
                                                                                          {
                                                                                           echo "<OPTION  value=0>Partial  </OPTION>\n";
                                                                                            echo "<OPTION value=1 >Complete  </OPTION>\n";
                                                                                          }
                                                                  ?>
                                                                  	</select> </td> </tR>

						<?php
						$period = substr($mycomprow["dates"],0,3);

					?>
								 <tr>
										 			 <td>&nbsp;Period</td>
										     		 <Td width=5% align=left> <SELECT NAME=month1>

													<?php
													if($period=="Jan")
													{
													?>
													 <OPTION VALUE=1 SELECTED>Jan</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=1>Jan</OPTION>
													<?php
													}

													if($period=="Feb")
													{
													?>
													 <OPTION VALUE=2 SELECTED>Feb</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=2>Feb</OPTION>
													<?php
													}

													if($period=="Mar")
													{
													?>
													 <OPTION VALUE=3 selected>Mar</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=3>Mar</OPTION>
													<?php
													}

													if($period=="Apr")
													{
													?>
													 <OPTION VALUE=4 selected>Apr</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=4>Apr</OPTION>
													<?php
													}

													if($period=="May")
													{
													?>
													 <OPTION VALUE=5 SEELCTED>May</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=5>May</OPTION>
													<?php
													}
													if($period=="Jun")
													{
													?>
													 <OPTION VALUE=6 SELECTED>Jun</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=6>Jun</OPTION>
													<?php
													}
													if($period=="Jul")
													{
													?>
													 <OPTION VALUE=7 SELECTED>Jul</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=7>Jul</OPTION>
													<?php
													}
													if($period=="Aug")
													{
													?>
													 <OPTION VALUE=8 SELECTED>Aug</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=8>Aug</OPTION>
													<?php
													}
													if($period=="Sep")
													{
													?>
													 <OPTION VALUE=9 SELECTED>Sep</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=9>Sep</OPTION>
													<?php
													}
													if($period=="Oct")
													{
													?>
													 <OPTION VALUE=10 SELECTED>Oct</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=10>Oct</OPTION>
													<?php
													}
													if($period=="Nov")
													{
													?>
													 <OPTION VALUE=11 SELECTED>Nov</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=11>Nov</OPTION>
													<?php
													}
													if($period=="Dec")
													{
													?>
													 <OPTION VALUE=12 SELECTED>Dec</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=12>Dec</OPTION>
													<?php
													}

											?>
										  			</SELECT>
										 			<SELECT NAME=year1>
										 			<OPTION id=2 value="--" selected> Year </option>
										 			<?php


										 			$i=1998;
										 			While($i<=$currentyear)
										 			{
										 			$id = $i;
										 			$name = $i;
										 			if($id == $mycomprow["dtyear"])
										 			{
										 				echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
										 			}
										 			else
										 			{
										 				echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
										 			}
										 			$i++;
										 			}
										 			?>
						 			</td></tr>

								<tr>
								<td >&nbsp;Advisors-Company</td>
								<td >
									<table border=1 width=100% cellpadding=1 cellspacing=0>
									<?php
									$strAdvComp="";
									 $getAdvCompanySql="select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
										advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
									  //echo "<Br>".$advcompanysql;
									  if ($rsadvisors = mysql_query($getAdvCompanySql))
										  {
											While($myadvrow=mysql_fetch_array($rsadvisors, MYSQL_BOTH))
											{
												$strAdvComp=$strAdvComp.", ".$myadvrow[2]."/" .$myadvrow[3];
										?>
										<tr><td valign=top width="100" style="font-family: Verdana; font-size: 8pt" >
										<input name="CIAId[]" type="hidden" value=" <?php echo $myadvrow["CIAId"]; ?>"  >
										</td></tr>

										<?php
											}
											  $strAdvComp =substr_replace($strAdvComp, '', 0,1);
										?>
											<tr><td valign=top >
											<input name="txtadvisors" type="text" size="49" value="<?php echo trim($strAdvComp );?>">
											</td></tr>
										<?php
										}
										?>
										</table>
										</td>
									</tr>


								<tr>
								<td >&nbsp;Comment</td>
								<td><textarea name="txtcomment" rows="2" cols="40"><?php echo $mycomprow["Comment"]; ?> </textarea> </td>
								</tr>

                                                                <tr>
								<td >&nbsp;Selling Investors</td>
								<td><textarea name="txtsellinginvestors" rows="2" cols="40"><?php echo $mycomprow["SellingInvestors"]; ?> </textarea> </td>
                                                                </tr>

								<tr>
								<td >&nbsp;More Information</td>
								<td><textarea name="txtmoreinfor" rows="3" cols="40"><?php echo $mycomprow["MoreInfor"]; ?> </textarea>
								<input name="chkhidemoreinfor" type="checkbox" value=" <?php echo $mycomprow["hidemoreinfor"]; ?>" <?php echo $hidemoreinfor; ?>></td>
								</td>
								</tr>


								<tr>
								<td >&nbsp;Inv Deal(Summary)</td>
								<td><textarea name="txtinvdealsummary" rows="3" cols="40"><?php echo $mycomprow["InvestmentDeals"]; ?> </textarea>
								</td>
								</tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Website</td>
								<td><input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
								</tr>

								<tr>
								<td >&nbsp;Validation</td>
								<td><textarea name="txtvalidation" rows="1" cols="40"><?php echo $mycomprow["Validation"]; ?> </textarea> </td>

								</tr>

								<tr>
								<td>&nbsp;VC Flag </td><td>
								<input name="chkvcflag" type="checkbox" value=" <?php echo $mycomprow["VCFlag"]; ?>" <?php echo $vcflag; ?>></td>
							</tr>

							<tr>
								<td >&nbsp;Link</td>
								<td><textarea name="txtlink" rows="3" cols="40"><?php echo $mycomprow["Link"]; ?> </textarea>
								</td>
								</tr>
								
                                                                  <tr>
								<td >Company Valuation (INR Cr)</td>
								<td >
								<input name="txtcompanyvaluation" id="txtcompanyvaluation" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation"]; ?> > </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td ><input name="txtsalesmultiple" id="txtsalesmultiple" type="text" size="10" value=<?php echo $mycomprow["Sales_Multiple"];?> ></td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td ><input name="txtEBITDAmultiple" id="txtEBITDAmultiple" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple"];?> ></td>
								</tr>
								<tr>
								<td >PAT Multiple</td>
								<td ><input name="txtnetprofitmultiple" id="txtnetprofitmultiple" type="text" size="10" value=<?php echo $mycomprow["Netprofit_Multiple"];?> ></td>
								</tr>
								
								<!-- New feature 08-08-2016 start -->
								
									<tr>
										<td >Price to Book</td>
										<td ><input name="txtpricetobook" id="txtpricetobook" type="text" size="10" value="<?php echo $mycomprow["price_to_book"];?>"> </td>
									</tr>
								
								<!-- New feature 08-08-2016 end -->


                                                                <tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Estimated Return Multiple</td>
								<td><textarea name="txtestimatedirr" rows="3" cols="40"><?php echo $mycomprow["EstimatedIRR"]; ?> </textarea>
								</tr>

								<tr>
								<td >&nbsp;More Infor (Returns)</td>
								<td><textarea name="txtmoreinforeturns" rows="3" cols="40"><?php echo $mycomprow["MoreInfoReturns"]; ?> </textarea>
								</td>
								</tr>
								
								<tr>
								<td >Valuation (More Info)</td>
								<td><textarea name="txtvaluationmoreinfo" rows="2" cols="40"><?php echo $mycomprow["Valuation"]; ?> </textarea>
								</td></tr>
                                                                <?php
                                                                            
                                                                    if($mycomprow["Revenue"] >0 || $mycomprow["EBITDA"] >0 || $mycomprow["PAT"] >0){

                                                                        $checked='Checked';
                                                                    }
                                                                ?>
                                                                <tr>
                                                                    <td ><b>Autofill Revenues (INR Cr), EBITDA (INR Cr), PAT (INR Cr) Values</b></td>
                                                                <td ><label> <input name="getrevenue_value" id="getrevenue_value" type="checkbox" <?php echo $checked; ?>></label> </td>
							        </tr>
                                                                <tr>
								<td >Revenues (INR Cr)</td>
								<td ><input name="txtrevenue" id="txtrevenue" type="text" size="10" value=<?php echo $mycomprow["Revenue"];?> ></td>
							        </tr>
								<tr>
								<td >EBITDA (INR Cr)</td>
								<td ><input name="txtEBITDA" id="txtEBITDA" type="text" size="10" value=<?php echo $mycomprow["EBITDA"];?> ></td>
								</tr>
								<tr>
								<td >PAT (INR Cr)</td>
								<td ><input name="txtpat" id="txtpat" type="text" size="10" value=<?php echo $mycomprow["PAT"];?> ></td>
								</tr>
									
                                                                <tr>
                                                                        <td >Book Value Per Share</td>
                                                                        <td ><input name="txtbookvaluepershare" id="txtbookvaluepershare" type="text" size="10" value="<?php echo $mycomprow["book_value_per_share"];?>"> </td>
                                                                </tr>

                                                                <tr>
                                                                        <td >Price Per Share</td>
                                                                        <td ><input name="txtpricepershare" id="txtpricepershare" type="text" size="10" value="<?php echo $mycomprow["price_per_share"];?>"> </td>
                                                                </tr>
                                                                        
								<tr>
								<td >Link for Financials </td>
								<td><textarea name="txtfinlink" rows="3" cols="40"><?php echo $mycomprow["FinLink"]; ?></textarea> </td>
								</tr>
								
								<tr>
								<td >&nbsp;Valuation Working <br>
								</td>
								<td valign=top>
								<!-- <INPUT NAME="txtvaluationworkingfilepath" TYPE="file" value="<?php //echo $mycomprow["Valuation_Working_fname"]; ?>" size=50> -->
								<input name="txtvaluationworkingfile" type="text" size="22" value="<?php echo $mycomprow["Valuation_Working_fname"]; ?>" >

								<input type="button" value="Delete File" name="deletepeuploadfile" onClick="delUploadFile();"  >

								</td>


								</tr>


						<?php
								}
							mysql_free_result($companyrs);
							}

 ?>

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update IPO Exit" name="updateDeal" > </td></tr></table>




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
           
           var txtrevenuemultiple = $("#txtsalesmultiple").val();
           var txtEBITDAmultiple = $("#txtEBITDAmultiple").val();
           var txtpatmultiple = $("#txtnetprofitmultiple").val();
           
           
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
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>