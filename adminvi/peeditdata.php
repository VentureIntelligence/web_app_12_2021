<?php include_once("../../globalconfig.php"); ?>
<?php
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

		document.adddeal.action="peupdatedata.php";
		document.adddeal.submit();
}
function UpdateREDeals()
{
		document.adddeal.action="pereupdatedata.php";
		document.adddeal.submit();

}

</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=adddeal enctype="multipart/form-data" onSubmit="return checkFields();"  method=post >
 <input type="text" name="hiddenfile" value="">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=50%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
$stringtoExplode = explode("-", $value);
$pe_re=$stringtoExplode[0];
$companyIdtoEdit=$stringtoExplode[1];
   $currentyear = date("Y");
   //echo "<br>---" .$currentyear;
	$SelCompRef=$companyIdtoEdit;
	if($pe_re=="PE")
	{
		$titleDisplay="Stage";
	   	$getDatasql = "SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, pec.sector_business,
      	 pe.amount, pe.round,pe.StageId, s.stage, pe.stakepercentage, DATE_FORMAT( dates, '%M' )  as dates,
      	 pec.website, pec.city, pec.RegionId,r.Region, PEId,DATE_FORMAT( dates, '%Y' ) as dtyear, comment,MoreInfor,
      	 Validation,InvestorType,hideamount,hidestake,SPV,Link,pec.countryid,pec.uploadfilename,source,Valuation,FinLink,AggHide,
      	 Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,pe.Revenue,pe.EBITDA,pe.PAT,pe.Amount_INR
  			FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,region as r
  			WHERE pe.PEId =" .$SelCompRef.
  			" AND i.industryid = pec.industry   and r.RegionId=pec.RegionId
			AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId";
		//	echo "<br>--" .$getDatasql;
	 $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
	 peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef";
	$industrysql = "select distinct i.industryid,i.industry  from industry as i	order by i.industry";
	}
	elseif($pe_re=="RE")
	{
		$titleDisplay="Type";
		$getDatasql = "SELECT pe.PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector as sector_business,
			 pe.amount, pe.round,pe.StageId, s.REType, pe.stakepercentage, DATE_FORMAT( dates, '%M' )  as dates,
			 pec.website, pe.city, pe.RegionId,r.Region, PEId,DATE_FORMAT( dates, '%Y' ) as dtyear,
			 comment,MoreInfor,Validation,InvestorType,hidestake,hideamount,SPV,Link,pec.countryid,
			 uploadfilename,source,Valuation,FinLink,AggHide,ProjectName,ProjectDetailsFileName,listing_status,Exit_Status
			FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r
			WHERE pe.PEId =" .$SelCompRef .
			" AND i.industryid = pec.industry and r.RegionId=pe.RegionId
			AND pec.PEcompanyID = pe.PECompanyID and s.RETypeId=pe.StageId";

	 	$getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor from REinvestments_investors as peinv,
		 REinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef";

		 $industrysql = "select distinct i.industryid,i.industry  from reindustry as i";
	}

		 $countrysql="select countryid,country from country";


//	echo "<br>-------------".$getDatasql;



//echo "<br>-------------".$getInvestorsSql;

	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
				//$period = substr($mycomprow["dates"],0,3);
				//echo "<br>^^^^^^^^^^^^^".$period;

				$hideamount=0;
				$hidestake=0;
				$spvflag=0;
				$hideaggregate=0;

				if($mycomprow["hideamount"]==1)
					$hideamount="checked";
				if($mycomprow["hidestake"]==1)
					$hidestake="checked";
				if($mycomprow["SPV"]==1)
					$spvbracket="checked";
				if($mycomprow["AggHide"]==1)
   	                                $hideaggregate="checked";

					//echo "<br>checked- ".$hideamount;
					//echo "<br>checked stake- ".$hidestake;

  		?>

		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Deal</b></td></tr>
				<tr>

								<!-- industry id -->
								<td  style="font-family: Verdana; font-size: 87pt" align=left>
								<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow[2]; ?>"> </td></tr>

								<!-- PE id -->
								<tr><td colspan=2 style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtPEId" size="10" value="<?php echo $mycomprow["PEId"]; ?>">

								<!-- PECompanyid -->
								<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>">
								</td></tr>

								<tr><td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtpe_re" size="10" value="<?php echo $pe_re; ?>"> </td>
									</tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Company</td>
								<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>

                                                               
                                                                <?php
                                                                        $period = substr($mycomprow["dates"],0,3);

                                                                ?>
                                                        <tr>
                                                            <td>Period</td>
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
								<td>Listing Status</td>
								<td > <SELECT name="listingstatus">
                                                                 	<OPTION value="--" SELECTED> Choose  </option>
								<?php
								$listing_statusvalue=$mycomprow["listing_status"];
                                                					if ($listing_statusvalue=="L")
                                                                                        {   
                                                                                          echo "<OPTION  value='L' SELECTED>Listed  </OPTION>\n";
                                                                                          echo "<OPTION value='U' >Unlisted  </OPTION>\n";
                                                                                        }
                                                				         elseif($listing_statusvalue=="U")
                                                				         {
                                                                                            echo "<OPTION  value='L'>Listed  </OPTION>\n";
                                                                                            echo "<OPTION value='U' SELECTED>Unlisted  </OPTION>\n";
                                                                                          }
                                                                                          else
                                                                                          {
                                                                                           echo "<OPTION  value='L'>Listed  </OPTION>\n";
                                                                                            echo "<OPTION value='U' >Unlisted  </OPTION>\n";
                                                                                          }
                                                                  ?>
                                                                  	</select> </td> </tR>
                                                                 
                                                                <tr>
                                                                    <td >Exit Status</td>
                                                                    <td > 
                                                                        <SELECT name="exitstatus">
                                                                            <OPTION value="0" selected>Select Exit Status (--) </option>
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
//                                                                                                    if($mycomprow["Exit_Status"]!=0)
//                                                                                                    {
//                                                                                                        $exitstatus=$mycomprow["Exit_Status"];
//                                                                                                    }
//                                                                                                    else{
//                                                                                                        $exitstatus=1;
//                                                                                                    }
                                                                                                        
                                                                                                    if($mycomprow["Exit_Status"]==$id){
                                                                                                        
                                                                                                        echo "<OPTION id=".$id. " value=".$id." selected>".$name."  </OPTION>\n";
                                                                                                    }
                                                                                                    else{
                                                                                                        echo "<OPTION id=".$id. " value=".$id." >".$name."  </OPTION>\n";
                                                                                                    }
                                                                                            }
                                                                                    }
                                                                            ?>
<!--                                                                            <option value="1" <?php if($mycomprow["Exit_Status"]==1){echo 'selected';} ?>>Unexited</option>
                                                                            <option value="2" <?php if($mycomprow["Exit_Status"]==2){echo 'selected';} ?>>Partially Exited</option>
                                                                            <option value="3" <?php if($mycomprow["Exit_Status"]==3){echo 'selected';} ?>>Fully Exited</option>-->
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
								<tr>
								<td>Industry</td>
								<td > <SELECT name="industry">

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

								<tr><td >Amount $M</td>
								<td >
								<input type="text" name="txtamount" size="10" value="<?php echo $mycomprow["amount"]; ?>">
								<input name="chkhideamount" type="checkbox" value=" <?php echo $mycomprow["hideamount"]; ?>" <?php echo $hideamount; ?>>

								</td>
								</tr>

								<tr><td >Amount INR</td>
								<td >
								<input type="text" name="txtamount_INR" size="10" value="<?php echo $mycomprow["Amount_INR"]; ?>">

								</td>
								</tr>

								<tr><td >Round</td>
								<td>
								<input type="text" name="txtround" size="50" value="<?php echo $mycomprow["round"]; ?>"> </td>
<!--                                                                <SELECT name="txtround">
                                                                   <OPTION value="" > Choose Round </option>
                                                                   <OPTION  value="Open Market Transaction" <?php if($mycomprow[6]=="Open Market Transaction"){echo "SELECTED";} ?>>Open Market Transaction </OPTION>
                                                                   <OPTION  value="Preferential Allotment" <?php if($mycomprow[6]=="Preferential Allotment"){echo "SELECTED";} ?>>Preferential Allotment </OPTION>
                                                                </select> -->
								</tr>

								<tr>
								<td ><?php echo $titleDisplay; ?></td>
								<td > <SELECT name="stage">
								<?php
								if($pe_re=="PE")
									$stageSql = "select StageId,Stage from stage order by StageId";
								elseif($pe_re=="RE")
									$stageSql="select RETypeId,REType from realestatetypes order by RETypeId";

									if ($rsStage = mysql_query( $stageSql))
									{
									  $stage_cnt = mysql_num_rows($rsStage);
									}
									if($stage_cnt > 0)
									{
										While($myrow=mysql_fetch_array($rsStage, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											if ($id==$mycomprow["StageId"])
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
											}
										}
										mysql_free_result($rsStage);
									}
								?>
								</td>
								</tr>

								<!--<tr>
									<td>Investors
									<td valign=topstyle="font-family: Verdana; font-size: 8pt" align=left>
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									$strInvestor="";
									   if ($rsinvestors = mysql_query($getInvestorsSql))
									  {
										While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
										{
											$strInvestor=$strInvestor .", ".$myInvrow["Investor"];
										?>
									<tr><td valign=top width="100" style="font-family: Verdana; font-size: 8pt" >
									<input name="txtinvestorid[]" type="hidden" value=" <?php echo $myInvrow["InvestorId"]; ?>"  >
									</td></tr>

									<?php
										}
										  $strInvestor =substr_replace($strInvestor, '', 0,1);

									?>
										<tr><td valign=top >
										<input name="txtinvestors" type="text" size="49" value=" <?php echo trim($strInvestor); ?>"  >
										</td></tr>

									<?php
									}
									?>
									</table>
									</td>
								</tr>-->
                                                                <tr>
									<td>&nbsp;Investors
									<td valign="top" style="font-family: 'Verdana'; font-size: 8pt;" align='left'>
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									echo  $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo from peinvestments_investors as peinv,
									  peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef";
                                                                         //echo "<bR>--" .$getInvestorsSql;
									  if ($rsinvestors = mysql_query($getInvestorsSql))
									  {
										While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
										{
										?>
									<input name="txtinvestorid[]" type="hidden" value=" <?php echo $myInvrow["InvestorId"]; ?>"  >
										<tr><td valign=top >
                                                                                        <?php echo trim(($myInvrow["Investor"].' - '.$myInvrow["Amount_M"].' - '.$myInvrow["Amount_INR"].' - '.$myInvrow["InvMoreInfo"]),' - '); ?>
                                                                                </td></tr>

									<?php
                                                                                }
									}
									?>
									</table><input type="hidden" name="hideIPOId" size="8" value="">
                                                                        <input type="button" value="Add Investors" name="addInvestor"
                              					onClick="window.open('addPEInvestors.php?value=PE/<?php echo $SelCompRef;?>','mywindow','width=700,height=500')">
									</td>
								</tr>

								<?php
									$investType=$mycomprow["InvestorType"];

								?>
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


								<tr>
								<td >Stake Percentage</td>
								<td >
								<input type="text" name="txtstake" size="10" value="<?php echo $mycomprow["stakepercentage"]; ?>">
								<input name="chkhidestake" type="checkbox" value=" <?php echo $mycomprow["hidestake"]; ?>" <?php echo $hidestake; ?>> </td>

								</tr>
								<tr>
								<td >Website</td>
								<td >
								<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
								</tr>

								<tr>
								<td >City</td>
								<td >
								<input type="text" name="txtcity" size="50" value="<?php echo $mycomprow["city"]; ?>"> </td>
								</tr>



								<tr>
									<td >Region</td>
									 <Td> <SELECT NAME=txtregion>

									<?php

									$regionSql = "select RegionId,Region from region";
									if ($regionrs = mysql_query($regionSql))
									{
										While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											if ($id==$mycomprow["RegionId"])
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
											}
										}
										mysql_free_result($regionrs);
									}

									?>
									</td></tr>
								<?php

									?>


							<tr>
								<td>Country</td>
								<td > <SELECT name="txtcountry">

								<?php
									if ($countryrs = mysql_query( $countrysql))
									{
									  $country_cnt = mysql_num_rows($countryrs);
									}
								  	if($country_cnt > 0)
									{
								 		While($mycountryrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
										{
											$id = $mycountryrow[0];
											$name = $mycountryrow[1];
											if ($id==$mycomprow["countryid"])
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
											}
										}
							 			mysql_free_result($countryrs);
									}

								?>
								</select> </td> </tR>


								<tr>
								<td >Advisors-Company
								<input type="button" value="Add Advisor Company" name="btnaddadvcompany"
									onClick="window.open('addAdvisorCompanyInvestor.php?value=<?php echo $pe_re;?>-<?php echo $SelCompRef;?>','mywindow','width=400,height=600')">
								</td>
								<td >
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									$strAdvComp="";
									if($pe_re=="PE")
									 $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
										advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
									elseif($pe_re=="RE")
									 $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame ,cia.AdvisorType from REinvestments_advisorcompanies as advcomp,
										REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
									  //echo "<Br>".$advcompanysql;
									  if ($rsAdvisorCompany = mysql_query($advcompanysql))
									  {
										While($myInvrow=mysql_fetch_array($rsAdvisorCompany, MYSQL_BOTH))
										{
											$strAdvComp=$strAdvComp.",".$myInvrow["cianame"]."/" .$myInvrow["AdvisorType"];
										?>
									<tr><td >
									<input name="txtAdvcompId[]" type="text" READONLY value=" <?php echo $myInvrow["CIAId"]; ?>"  >
										</td></tr>
									<?php
										}
										  $strAdvComp =substr_replace($strAdvComp, '', 0,1);

									?>
										<tr><td >
										<input name="txtAdvCompany" type="text" size="49" value=" <?php echo trim($strAdvComp); ?>"  >
										</td></tr>
									<?php
									}
									?>
									</table>
									</td>
								</tr>

								<tr>
								<td >Advisors-Investors

								<input type="button" value="Add Advisor Investor" name="btnaddadvinv"
									onClick="window.open('addAdvisorCompanyInvestor.php?value=<?php echo $pe_re;?>-<?php echo $SelCompRef;?>','mywindow','width=400,height=600')">
								</td>

								<td >
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									$strAdvInv="";
									if($pe_re=="PE")
										$advinvestorsql="select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorinvestors as advinv,
										advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
									elseif($pe_re=="RE")
										$advinvestorsql="select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from REinvestments_advisorinvestors as advinv,
										REadvisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
									//echo "<Br>".$advinvestorsql;
									if ($rsAdvisorInvestor = mysql_query($advinvestorsql))
									  {
										While($myInvestorrow=mysql_fetch_array($rsAdvisorInvestor, MYSQL_BOTH))
										{
											$strAdvInv=$strAdvInv .", ".$myInvestorrow[2]. "/" .$myInvestorrow[3];

										?>
									<tr><td >
									<input name="txtAdvInvId[]" type="text" READONLY value=" <?php echo $myInvestorrow["CIAId"]; ?>"  >
									</td></tr>
									<?php
										}
										 $strAdvInv =substr_replace($strAdvInv, '', 0,1);

									?>
									<tr><td>
									<input name="txtAdvInvestor" type="text" size="49" value="<?php echo $strAdvInv; ?>"  >
								</td></tr>

									<?php
									}
									?>
									</table>
									</td>
								</tr>

								<tr>
								<td >Comment</td>
								<td><textarea name="txtcomment" rows="2" cols="40"><?php echo $mycomprow["comment"]; ?> </textarea> </td>
								</tr>

								<tr>
								<td >More Information</td>
								<td><textarea name="txtmoreinfor" rows="2" cols="40"><?php echo $mycomprow["MoreInfor"]; ?> </textarea> </td>
								</tr>

								<tr>
								<td >Validation</td>
								<td><textarea name="txtvalidation" rows="2" cols="40"><?php echo $mycomprow["Validation"]; ?> </textarea> </td>

								</tr>

								<tr>
								<td >Link</td>
								<td><textarea name="txtlink" rows="2" cols="40"><?php echo $mycomprow["Link"]; ?> </textarea> </td>
								</tr>

                                                                 
                                                                 <?php
                                                                	if($pe_re=="PE")
									{
                                                                          ?>
                                                                <tr>
								<td >Company Valuation (INR Cr)</td>
								<td >
								<input name="txtcompanyvaluation" id="txtcompanyvaluation" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation"]; ?> > </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td ><input name="txtrevenuemultiple" id="txtrevenuemultiple" type="text" size="10" value=<?php echo $mycomprow["Revenue_Multiple"];?> ></td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td ><input name="txtEBITDAmultiple" id="txtEBITDAmultiple" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple"];?> ></td>
								</tr>
								<tr>
									<td >PAT Multiple</td>
									<td ><input name="txtpatmultiple" id="txtpatmultiple" type="text" size="10" value=<?php echo $mycomprow["PAT_Multiple"];?> ></td>
								</tr>
								
								<!-- New feature 08-08-2016 start -->
									
									<tr>
										<td >Price to Book</td>
										<td ><input name="txtpricetobook" id="txtpricetobook" type="text" size="10" value="<?php echo $mycomprow["price_to_book"]; ?>"> </td>
									</tr>
								
								<!-- New feature 08-08-2016 end -->


                                                                     <?php
                                                                     }
                                                                     ?>


								<tr>
								<td >Valuation (More Info)</td>
								<td><textarea name="txtvaluation" rows="2" cols="40"><?php echo $mycomprow["Valuation"]; ?> </textarea>
								</td></tr>
                                                                <?php
                                                                	if($pe_re=="PE")
									{
                                                                            
                                                                            if($mycomprow["Revenue"] >0 || $mycomprow["EBITDA"] >0 || $mycomprow["PAT"] >0){
                                                                                
                                                                                $checked='Checked';
                                                                            }
                                                                          ?>
                                                                <tr>
                                                                    <td ><b>Autofill Revenues (INR Cr), EBITDA (INR Cr), PAT (INR Cr) Values</b></td>
                                                                <td ><label> <input name="getrevenue_value" id="getrevenue_value" type="checkbox" <?php echo $checked; ?>></label> </td>
							        </tr>
                                                                
								<tr>
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

                                                                     <?php
                                                                     }
                                                                     ?>
								<tr>
								<td >Link for Financials (LISTED FIRM ONLY)</td>
								<td><textarea name="txtfinlink" rows="3" cols="40"><?php echo $mycomprow["FinLink"]; ?></textarea> </td>
								</tr>
								<tr>
								<td >&nbsp;Financial <br>
								</td>
								<td valign=top><INPUT NAME="txtfilepath" TYPE="file" value="<?php echo $mycomprow["uploadfilename"]; ?>" size=50>
								<input name="txtfile" type="text" size="22" value="<?php echo $mycomprow["uploadfilename"]; ?>" >
								<?php
									if($pe_re=="PE")
									{
									?>
										<input type="button" value="Delete File" name="deletepeuploadfile" onClick="delUploadFile();"  >
									<?php
									}
									else
									{
									?>
										<input type="button" value="Delete File" name="deletereuploadfile" onClick="delREUploadFile('F');"  >
									<?php
									}
									?>


								</td>


								</tr>

								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value="<?php echo $mycomprow["source"]; ?>" ></td>
								</tr>

                                                                <tr><td >Hide for Aggregate (Tranche)</td>
								<td >
								<input name="chkhideAgg" type="checkbox" value=" <?php echo $mycomprow["AggHide"]; ?>" <?php echo $hideaggregate; ?>>

								</td>
								</tr>

                                                                <tr>
								<th align=left >&nbsp;DB Type----HIDE as PE/VC Deal</th>
								<td><table>
								
								 <?php
                                                //$dbtypesql = "select DBTypeId,DBType from dbtypes";
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
								$name=$myrow[1];
								$dbsql="select * from peinvestments_dbtypes where DBTypeId='$id' and PEId=$SelCompRef";
								//echo "<Br>~~~~~".$dbsql;
								if($rschk=mysql_query($dbsql))
							        {
                                                                  $cnt=mysql_num_rows($rschk);
                                                                  if($cnt==1)
                                                                  {
                                                                  While($myrow1=mysql_fetch_array($rschk, MYSQL_BOTH))
                                                                  {
                                                                     if($myrow1["hide_pevc_flag"]==1)
                                                                     {     $hideflag="checked";}

                                                                  ?>
                                                                  <tr><td>
								<input name="dbtype[]" type="checkbox" value=" <?php echo $id; ?>" checked><?php echo $name; ?>
       	                                                   -----<input name="showaspevc[]" type="checkbox"  value="<?php echo $id; ?>" <?php echo $hideflag;?> >    </td>

                                                               </td></tr>
                                                               <?php
                                                                  }
                                                               }   //if cnt==1 loop
                                                               else
                                                                {
                                                                  $hideflag ="";
                                                                  ?>
                                                                <tr><td>	<input name="dbtype[]" type="checkbox" value=" <?php echo $id; ?>" ><?php echo $name; ?>
       	                                                   -----<input name="showaspevc[]" type="checkbox"  value="<?php echo $id; ?>" <?php echo $hideflag;?> >    </td>
                                                               <?php
                                                                }
                                                             }  //if rscheck loop


						         }
						 mysql_free_result($debtypers);
						}
                                     	?>

                                      		    </table></td></tr>

                                                               <?php
								if($pe_re=="PE")
								{
							?>
								<tr>
								<td width="250"><font size="2" face="Verdana">Debt </font></td>
								<td><input name="chkSPVdebt" type="checkbox" value=" <?php echo $mycomprow["SPV"]; ?>" <?php echo $spvbracket; ?>>
								</td></tr>
                                                                <?php
                                                                }


								if($pe_re=="RE")
								{
							?>
								<tr>
								<td width="250"><font size="2" face="Verdana">SPV</font></td>
								<td><input name="chkspv" type="checkbox" value=" <?php echo $mycomprow["SPV"]; ?>" <?php echo $spvbracket; ?>>
								</td></tr>

								<tr>
								<td >Project Name (for SPVs)</td>
								<td >
								<input name="txtprojectname" type="text" size="50" value="<?php echo $mycomprow["ProjectName"];?>">
								</td></tr>


                                                                <tr>
								<td >&nbsp;Project Details <br>
								</td>
								<td valign=top><INPUT NAME="txtprojectfilepath" TYPE="file" value="<?php echo $mycomprow["ProjectDetailsFileName"]; ?>" size=50>
								<input name="txtprojectfile" type="text" size="22" value="<?php echo $mycomprow["ProjectDetailsFileName"]; ?>" >
								<?php
									if($pe_re=="PE")
									{
									?>
									<!--	<input type="button" value="Delete File" name="deletepeuploadfile" onClick="delUploadFile();"  >-->
									<?php
									}
									else
									{
									?>
										<input type="button" value="Delete File" name="deletereuploadfile" onClick="delREUploadFile('P');"  >
									<?php
									}
									?>
    	        	      				        </td>
                 		                                </tr>
                                                             	<?php
								}

								}
							mysql_free_result($companyrs);
							}

 ?>

</table>
<table align=center>
<tr> <Td>
<?php
if($pe_re=="PE")
{
?>
	<input type="button" value="Update" name="updateDeal" onClick="UpdateDeals();">
<?php
}
if($pe_re=="RE")
{
?>
	<input type="button" value="Update" name="REupdateDeal" onClick="UpdateREDeals();">

<?php
}
?>
</td></tr></table>




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