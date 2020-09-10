<?php include_once("../../globalconfig.php"); ?>
<?php

 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
session_start();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{

?>
<html><head>
<title>Incubator Deal Info</title>
</head>

<body>
 <form name=inceditdeal method=post action="incdealupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=30%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $currentyear = date("Y");
	$SelCompRef=$value;
   	$getDatasql = "SELECT pe.IncDealId,pe.IncubateeId,pec.companyname,
                         	pe.IncubatorId,incu.Incubator ,pec.yearfounded,pe.Comment,MoreInfor,pe.StatusId,
                                inc.Status,Individual,FollowonFund,Defunct,DATE_FORMAT( date_month_year, '%M' ) as dtmonth,
                                DATE_FORMAT( date_month_year, '%Y' ) as dtyear ,pec.sector_business,pec.industry
				FROM incubatordeals AS pe, pecompanies AS pec ,incubators as incu,incstatus as inc
				WHERE pec.PEcompanyID = pe.IncubateeId and incu.IncubatorId=pe.IncubatorId
				and inc.StatusId=pe.StatusId and pe.IncDealId=$SelCompRef";
        $industrysql = "select distinct i.industryid,i.industry  from industry as i	order by i.industry";
	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
	     	While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
              	if($mycomprow["Individual"]==1)
		 {$individual="checked";}

                  $followonVCfunding=0;
	       if($mycomprow["FollowonFund"]==1)
		{$followonfunding="checked"; }
                  $defunct=0;
                 if($mycomprow["Defunct"]==1)
		{$defunct="checked"; }


			?>
                       	<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Deal</b></td></tr>
				<tr>



				<!-- IncDealId -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtIncDealId" size="10" value="<?php echo $mycomprow["IncDealId"]; ?>"> </td>

				<!-- PECompanyid/Incubatee Id -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["IncubateeId"]; ?>"> </td>
				</tr>
                                                            <!-- Incubator Id -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtincubatorId" size="10" value="<?php echo $mycomprow["IncubatorId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >&nbsp;Incubatee</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
				</tr>

                                	<tr>
								<td>Industry</td>
								<td > <SELECT name="industryid">

								<?php
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

								<tr><td >Sector</td>
								<td>
								<input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>"> </td>
								</tr>

                                <tr style="font-family: Verdana; font-size: 8pt">
				<td >&nbsp;Incubator </td>
				<td><input type="text" name="txtincubator" size="50" value="<?php echo $mycomprow["Incubator"]; ?>"> </td>
				</tr>
                                  <tr><td >Follow on Funding?</td>
                        	    <td >
                        	    <input name="chkfollowonvcfund" type="checkbox" value=" <?php echo $mycomprow["FollowonFund"]; ?>" <?php echo $followonfunding; ?>>
                        	    </td>  </tr>

                               <!-- <tr><td >&nbsp;Year Founded</td>
				<td>
				<input type="text" name="txtyearfounded" size="10" value="<?php echo $mycomprow["yearfounded"]; ?>">
				</tr> -->

				<?php
						$period = substr($mycomprow["dtmonth"],0,3);

					?>
								 <tr>
				 			             <td>Deal Date</td>
                                                                     <Td width=5% align=left> <SELECT NAME=month1>
                                                                                               <OPTION id=1 value="--" selected> Month </option>
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
													 <OPTION VALUE=5 selected>May</OPTION>
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
													 <OPTION VALUE=6 selected>Jun</OPTION>
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
													 <OPTION VALUE=7 selected>Jul</OPTION>
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
													 <OPTION VALUE=8 selected>Aug</OPTION>
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
													 <OPTION VALUE=9 selected>Sep</OPTION>
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
													 <OPTION VALUE=10 selected>Oct</OPTION>
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
													 <OPTION VALUE=11 selected>Nov</OPTION>
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
													 <OPTION VALUE=12 selected>Dec</OPTION>
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
				<td>&nbsp;Status</td>
				<td > <SELECT name="status">

				<?php

				 	$industrysql = "select StatusId,Status from incstatus";
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
							if ($id==$mycomprow[8])
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

                                 <tr>
				<td>&nbsp;Defunct </td><td>
				<input name="chkDefunct" type="checkbox" value=" <?php echo $mycomprow["Defunct"]; ?>" <?php echo $defunct; ?>></td>
			</tr>
				<tr>
				<td >&nbsp;Comment</td>
				<td><textarea name="txtcomment" rows="2" cols="40"><?php echo $mycomprow["Comment"]; ?> </textarea> </td>
				</tr>

				<tr>
				<td >&nbsp;More Information</td>
				<td><textarea name="txtmoreinfor" rows="3" cols="40"><?php echo $mycomprow["MoreInfor"]; ?> </textarea>
				</td>
				</tr>


				<tr>
				<td>&nbsp;Individual </td><td>
				<input name="chkindividual" type="checkbox" value=" <?php echo $mycomprow["Individual"]; ?>" <?php echo $individual; ?>></td>
			</tr>


		    	<?php
		} //end of while

	mysql_free_result($companyrs);
	}

 ?>

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update inc deal" name="updateDeal" > </td></tr></table>


     </form>
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
 	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
