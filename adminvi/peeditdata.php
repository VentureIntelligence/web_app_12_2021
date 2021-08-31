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
      	 Validation,InvestorType,hideamount,hidestake,SPV,Link,pec.countryid,pec.uploadfilename,source,Valuation,crossBorder,FinLink,AggHide,
      	 Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,pe.Revenue,pe.EBITDA,pe.PAT,pe.Amount_INR,pe.Company_Valuation_pre,pe.Company_Valuation_EV,pe.Revenue_Multiple_pre,pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_pre,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_pre,pe.PAT_Multiple_EV,pe.Total_Debt,pe.Cash_Equ,pe.financial_year,pec.stateid,dates as dataperiod
  			FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,region as r
  			WHERE pe.PEId =" .$SelCompRef.
  			" AND i.industryid = pec.industry   and r.RegionId=pec.RegionId
			AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId";
		//	echo "<br>--" .$getDatasql;
	 $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.leadinvestor,peinv.newinvestor from peinvestments_investors as peinv,
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
			 uploadfilename,source,Valuation,FinLink,AggHide,ProjectName,ProjectDetailsFileName,listing_status,Exit_Status,dates as dataperiod
			FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r
			WHERE pe.PEId =" .$SelCompRef .
			" AND i.industryid =  pe.IndustryId and r.RegionId=pe.RegionId
			AND pec.PEcompanyID = pe.PECompanyID and s.RETypeId=pe.StageId";

	 	$getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor from REinvestments_investors as peinv,
		 REinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef";

		 $industrysql = "select distinct i.industryid,i.industry  from reindustry as i";
	}

		 // $countrysql="select countryid,country from country";
    $countrysql="select countryid,country from country where countryid NOT IN('','--','10','11') order by country asc";


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
                                //print_r($mycomprow);
				$hideamount=0;
				$hidestake=0;
				$spvflag=0;
				$hideaggregate=0;
                $txtCrossborder=0;

				if($mycomprow["hideamount"]==1)
					$hideamount="checked";
				if($mycomprow["hidestake"]==1)
					$hidestake="checked";
				if($mycomprow["SPV"]==1)
					$spvbracket="checked";
				if($mycomprow["AggHide"]==1)
   	                                $hideaggregate="checked";
                                       if($mycomprow["crossBorder"]==1)
   	                                $txtCrossborder="checked";

					//echo "<br>checked- ".$mycomprow["crossBorder"];
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
                                                                        $datess=$mycomprow["dataperiod"];
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
                                                                        if($pe_re=="PE"){
                                                                            
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
                                                                        }else{
                                                                            
                                                                            
                                                                            if($ind_cnt > 0)
                                                                            {
                                                                                    While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                                                                    {
                                                                                            $id = $myrow[0];
                                                                                            $name = $myrow[1];

                                                                                            if ($name==$mycomprow["industry"])
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
                                                                        }
								  	

								?>
								</select> </td> </tR>

								<tr><td >Sector (Front end)</td>
								<td>
								<input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>"> </td>
								</tr>

                                <?php 

                                $sectorsql="select pe.PEId,pe.PECompanyId,pes.sector_id,pes.sector_name,pess.subsector_id,pess.subsector_name,pess.Additional_subsector from peinvestments AS pe,pe_sectors as pes,pe_subsectors as pess where pe.PEId =" .$SelCompRef." and pe.PECompanyId=pess.PECompanyId and pess.sector_id=pes.sector_id GROUP BY pe.PECompanyId";
                                //echo $sectorsql;
                                $sectorname=$subsectorname=$AdditionalSubsector="";
                                if ($rssector = mysql_query($sectorsql))
                                      {
                                        
                                        While($mysectorrow=mysql_fetch_array($rssector, MYSQL_BOTH))
                                        {
                                           /* print_r($mysectorrow);*/
                                          $sectorname=$mysectorrow['sector_name'];
                                          $subsectorname=$mysectorrow['subsector_name'];
                                          $AdditionalSubsector=$mysectorrow['Additional_subsector'];
                                     ?>
                                
                                <?php }}?>
                               
                                <tr><td >Sector</td>
                                <td>
                                <input type="text" name="txtmainsector" size="50" value="<?php echo $sectorname; ?>"> </td>
                                <tr><td >Sub Sector</td>
                                <td>
                                <input type="text" name="txtsubsector" size="50" value="<?php echo $subsectorname; ?>"> </td>
                                </tr> 
                                <tr><td >Additional Sub Sector</td>
                                <td>
                                <input type="text" name="txtaddsubsector" size="50" value="<?php echo $AdditionalSubsector; ?>"> </td>
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
                                                                    <?php $round = $mycomprow["round"]; ?>
                                                               <!-- <select name="txtround" id="round" >
                                                                    <option id="round_1" value="seed" <?php if($round == "seed") echo 'selected'; ?>>Seed</option>
                                                                    <?php
                                                                        $j=1; 
                                                                        $seed=13;
                                                                        for($i=1; $i<$seed; $i++) {
                                                                            $j++;
                                                                            $roundSel = ($round == $i)?'selected':''; 
                                                                            echo '<option id="round_'.$j.'" value="'.$i.'" '.$roundSel.'>'.$i.'</option>';
                                                                        }

                                                                        ?>
                                                                        <option id="round_Open" value="Open Market Transaction" <?php if($round == "Open Market Transaction") echo 'selected'; ?>>Open Market Transaction</option>
                                                                        <option id="round_Preferential" value="Preferential Allotment" <?php if($round == "Preferential Allotment") echo 'selected'; ?>>Preferential Allotment</option>
                                                                        <option id="round_Rights" value="Rights Issue" <?php if($round == "Rights Issue") echo 'selected'; ?>>Rights Issue</option>
                                                                        <option id="round_Share" value="Share Swap" <?php if($round == "Share Swap") echo 'selected'; ?>>Share Swap</option>                                                                        
                                                                        <option id="round_Special" value="Special Situation" <?php if($round == "Special Situation") echo 'selected'; ?>>Special Situation</option>                                                                         
                                                                        <option id="round_Debt" value="Debt" <?php if($round == "Debt") echo 'selected'; ?>>Debt</option> 
                                                                </select>-->
                                                                    <input type="text" name="txtround" id="round" size="30" value="<?php echo $round; ?>">   
                                                                </td>
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

                                                                 <?php
                                                                	if($pe_re=="RE")
									{
                                                                          ?>
								<tr>
									<td>Investors
									<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
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
								</tr>
                                                                        <?php } else{ ?>
                                                                <tr>
									<td>&nbsp;Investors
									<td valign="top" style="font-family: 'Verdana'; font-size: 8pt;" align='left'>
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									  /*$getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo from peinvestments_investors as peinv,
									  peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef ORDER BY Investor='others',InvestorId desc";*/
                                     $getInvestorsSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo,peinv.investorOrder,peinv.leadinvestor,peinv.newinvestor,peinv.existinvestor from peinvestments_investors as peinv,peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.PEId=$SelCompRef ORDER BY peinv.investorOrder ASC";
                                                                         //echo "<bR>--" .$getInvestorsSql;
									  if ($rsinvestors = mysql_query($getInvestorsSql))
									  {
										While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
										{
										?>
									<input name="txtinvestorid[]" type="hidden" value=" <?php echo $myInvrow["InvestorId"]; ?>"  >
										<tr>
                                            <td valign=top >
                                                <?php 
                                                    if($myInvrow["leadinvestor"] == 1) {
                                                        echo trim(($myInvrow["Investor"].' (L) - '.$myInvrow["Amount_M"].' - '.$myInvrow["Amount_INR"].' - '.$myInvrow["InvMoreInfo"]),' - '); 
                                                    } else if($myInvrow["newinvestor"] == 1){
                                                        echo trim(($myInvrow["Investor"].' (N) - '.$myInvrow["Amount_M"].' - '.$myInvrow["Amount_INR"].' - '.$myInvrow["InvMoreInfo"]),' - '); 
                                                    }else if($myInvrow["existinvestor"] == 1){
                                                        echo trim(($myInvrow["Investor"].' (E) - '.$myInvrow["Amount_M"].' - '.$myInvrow["Amount_INR"].' - '.$myInvrow["InvMoreInfo"]),' - '); 
                                                    }else {
                                                        echo trim(($myInvrow["Investor"].' - '.$myInvrow["Amount_M"].' - '.$myInvrow["Amount_INR"].' - '.$myInvrow["InvMoreInfo"]),' - '); 
                                                    }
                                                ?>
                                            </td>
                                        </tr>

									<?php
                                                                                }
									}
									?>
									</table><input type="hidden" name="hideIPOId" size="8" value="">
                                                                        <input type="button" value="Add Investors" name="addInvestor"
                                                                        onClick="window.open('addPEInvestors.php?value=PE/<?php echo $SelCompRef;?>/<?php echo $mycomprow["PECompanyId"]; ?>/<?php echo $datess; ?>','mywindow','width=700,height=500')">
									</td>
								</tr>
                                                                        <?php } ?>
								<?php
									$investType=$mycomprow["InvestorType"];

								?>
                                <tr>
									<td>&nbsp;SHP
									<td valign="top" style="font-family: 'Verdana'; font-size: 8pt;" align='left'>
										<input type="hidden" name="hideIPOId" size="8" value="">
										<input type="button" value="Add SHP" name="addInvestor"
										onClick="window.open('addPESHP.php?value=PE/<?php echo $SelCompRef;?>','mywindow','width=700,height=500')">
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
<!--								<input type="text" name="txtcity" size="50" value="<?php echo $mycomprow["city"]; ?>"> </td>-->
                                                                <input type="hidden" id="cityauto" name="txtcity" value="<?php echo $mycomprow["city"]; ?>" placeholder="" style="width:220px;" autocomplete="off">
                                                                <input type="text" id="citysearch" name="citysearch" value="<?php echo $mycomprow["city"]; ?>" placeholder="" style="width:220px;" <?php if($disable_flag == "1"){ echo "disabled"; } ?>></td>
								</tr>

<?php 
if($pe_re=="PE")
    {
        ?>
								<tr>
                                                                    <tr>
                                <td >State</td>
                                <td >
                                     <SELECT NAME=txtstate id="state">
                                        <OPTION  value='--' >Choose State</OPTION>  
                                    <?php
                                        $stateSql = "select state_id, state_name from state ";
                                        if ($states = mysql_query($stateSql))
                                        {
                                          
                                            While($myrow=mysql_fetch_array($states, MYSQL_BOTH))
                                            {
                                                $id = $myrow[0];
                                                $name = $myrow[1];

                                            if ($id==$mycomprow["stateid"])
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
                            <?php  } ?>
									<td >Region</td>
									 <Td> <SELECT NAME=txtregion id="region">

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
                                        if($mycomprow["countryid"] == 11)
                                            {
                                                echo "<OPTION id=". $mycomprow["countryid"]. " value='11' SELECTED>Choose Country</OPTION> \n";
                                            }else{
                                                echo "<OPTION id=". $mycomprow["countryid"]. " value='11' >Choose Country</OPTION> \n";
                                            }
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
                                                                    <ul class="add_ul"><li>Pre-Money</li><li> Post-Money</li><li> EV</li></ul>
                                                                    <input name="txtcompanyvaluation" id="txtcompanyvaluation" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation_pre"]; ?> > 
                                                                    <input name="txtcompanyvaluation1" id="txtcompanyvaluation1" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation"]; ?> > 
                                                                    <input name="txtcompanyvaluation2" id="txtcompanyvaluation2" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation_EV"]; ?> >                                                                 
                                                                </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td >
                                                                    <input name="txtrevenuemultiple" id="txtrevenuemultiple" type="text" size="10" value=<?php echo $mycomprow["Revenue_Multiple_pre"];?> >
                                                                    <input name="txtrevenuemultiple1" id="txtrevenuemultiple1" type="text" size="10" value=<?php echo $mycomprow["Revenue_Multiple"];?> >
                                                                    <input name="txtrevenuemultiple2" id="txtrevenuemultiple2" type="text" size="10" value=<?php echo $mycomprow["Revenue_Multiple_EV"];?> >
                                                                </td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td >
                                                                    <input name="txtEBITDAmultiple" id="txtEBITDAmultiple" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple_pre"];?> >
                                                                    <input name="txtEBITDAmultiple1" id="txtEBITDAmultiple1" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple"];?> >
                                                                    <input name="txtEBITDAmultiple2" id="txtEBITDAmultiple2" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple_EV"];?> >
                                                                </td>
								</tr>
								<tr>
									<td >PAT Multiple</td>
								<td >
                                                                    <input name="txtpatmultiple" id="txtpatmultiple" type="text" size="10" value=<?php echo $mycomprow["PAT_Multiple_pre"];?> >
                                                                    <input name="txtpatmultiple1" id="txtpatmultiple1" type="text" size="10" value=<?php echo $mycomprow["PAT_Multiple"];?> >
                                                                    <input name="txtpatmultiple2" id="txtpatmultiple2" type="text" size="10" value=<?php echo $mycomprow["PAT_Multiple_EV"];?> >
                                                                </td>
								</tr>
								
								<!-- New feature 08-08-2016 start -->
									
									
								
								<!-- New feature 08-08-2016 end -->


                                                                     <?php
                                                                     }
                                                                     ?>
 <tr>
                                                                    <td >Crossborder deal</td>
                                                                <td ><label> <input name="txtCrossborder" type="checkbox" value=" <?php echo $mycomprow["crossBorder"]; ?>" <?php echo $txtCrossborder; ?>>
 </td>
							        </tr>

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
                                                                    <td>Financial/Calendar Year</td>
                                                                    <td><input name="txtyear" id="txtyear" type="text" size="15" value="<?php echo $mycomprow["financial_year"];?>"> </td>
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
									<td >Total Debt (INR Cr)</td>
									<td ><input name="txttot_debt" id="txttot_debt" type="text" size="10" value=<?php echo $mycomprow["Total_Debt"];?> ></td>
								</tr>
								
								<tr>
									<td >Cash & Cash Equ. (INR Cr)</td>
									<td ><input name="txtcashequ" id="txtcashequ" type="text" size="10" value=<?php echo $mycomprow["Cash_Equ"];?> ></td>
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
										<td >Price to Book</td>
										<td ><input name="txtpricetobook" id="txtpricetobook" type="text" size="10" value="<?php echo $mycomprow["price_to_book"]; ?>"> </td>
									</tr>
                                                                     <?php
                                                                     }
                                                                     ?>
								<tr>
								<td >Link for Financials (LISTED FIRM ONLY)</td>
								<td><textarea name="txtfinlink" rows="3" cols="40"><?php echo $mycomprow["FinLink"]; ?></textarea> </td>
								</tr>
								<!-- <tr>
								<td >&nbsp;Financial <br>
								</td>
								<td valign=top>
                                <INPUT NAME="txtfilepath" TYPE="file" value="<?php //echo $mycomprow["uploadfilename"]; ?>" size=50>
								<input name="txtfile" type="text" size="22" value="<?php //echo $mycomprow["uploadfilename"]; ?>" >
								<?php
									// if($pe_re=="PE")
									// {
									?>
										<input type="button" value="Delete File" name="deletepeuploadfile" onClick="delUploadFile();"  >
									<?php
									// }
									// else
									// {
									?>
										<input type="button" value="Delete File" name="deletereuploadfile" onClick="delREUploadFile('F');"  >
									<?php
									// }
									?>


								</td>


								</tr> -->

								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value="<?php echo $mycomprow["source"]; ?>" ></td>
								</tr>

                                                                <tr><td >Hide for Aggregate (Tranche)</td>
								<td >
								<input name="chkhideAgg" type="checkbox" value=" <?php echo $mycomprow["AggHide"]; ?>" <?php echo $hideaggregate; ?>>

								</td>
								</tr>
<!-- 
                                                                <tr>
								<th align=left >&nbsp;DB Type----HIDE as PE/VC Deal</th>
								<td><table>
								
								 <?php
                                                //$dbtypesql = "select DBTypeId,DBType from dbtypes";
                                              //  $dbtypesql = "select `DBTypeId`,`DBType` from `dbtypes`";

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
								//$dbsql="select * from peinvestments_dbtypes where DBTypeId='$id' and PEId=$SelCompRef";
								//echo "<Br>~~~~~".$dbsql;
								if($rschk=mysql_query($dbsql))
							        {
                                                                  $cnt=mysql_num_rows($rschk);
                                                                  if($cnt==1)
                                                                  {
                                                               //   While($myrow1=mysql_fetch_array($rschk, MYSQL_BOTH))
                                                                  {
                                                                     $hideflag ="";
                                                                    // if($myrow1["hide_pevc_flag"]==1)
                                                                   //  {     $hideflag="checked";}

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

                                      		    </table></td></tr> -->

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
 <?php $dbtypesql = "select `DBTypeId`,`DBType` from `dbtypes`";

            if ($debtypers = mysql_query($dbtypesql)) {
                $db_cnt = mysql_num_rows($debtypers);
            }
            if ($db_cnt > 0) {

                while ($myrow = mysql_fetch_array($debtypers, MYSQL_BOTH)) {
                    $id = $myrow[0];
                    $name = $myrow[1];
                    $dbsql = "select * from peinvestments_dbtypes where DBTypeId='$id' and PEId=$SelCompRef";
                  
                  //  echo "<Br>~~~~~".$dbsql;
                    if ($rschk = mysql_query($dbsql)) {
                        $cnt = mysql_num_rows($rschk);
                        if ($cnt == 1) {
                            while ($myrow1 = mysql_fetch_array($rschk, MYSQL_BOTH)) {
                                $hideflag = "";
                                if ($myrow1["DBTypeId"]!="" && $myrow1["hide_pevc_flag"] == 1) {$hideflag = "checked";}
                                 if ($myrow1["DBTypeId"]!="" && $myrow1["hide_pevc_flag"] == 0) {$dbflag = "checked";}
                                    ?>

                        <tr>  <td>  <?php echo $name . "&nbsp;also" ?></td>  <td><input name="dbtype[]" type="checkbox" class="<?php echo $name; ?>" value=" <?php echo $id; ?>" <?php echo $dbflag; ?>></td> </tr>
                        <?php if ($id != 'CT' && $id != "IF") {?>

                        <!-- <tr>  <td>  <?php echo $name . "&nbsp;only" ?> <td><input name="showaspevc[]" type="checkbox" <?php echo $ishidden?> class="<?php echo $id; ?>" value="<?php echo $id; ?>" <?php echo $hideflag; ?> /> </td> </tr> -->
                        <?php
}
}
                        } //if cnt==1 loop
                        else {
                            $hideflag = "";
                           /*if ($myrow1["DBTypeId"]!="" && $myrow1["hide_pevc_flag"] == 1) {$hideflag = "checked";}
                                 if ($myrow1["DBTypeId"]!="" && $myrow1["hide_pevc_flag"] == 0) {$dbflag = "checked";}*/
                                ?>
                            <tr>  <td>  <?php echo $name. "&nbsp;also" ?></td>  <td><input name="dbtype[]" class="<?php echo $name; ?>" type="checkbox" value=" <?php echo $id; ?>" /></td> </tr>
                            <?php if ($id != 'CT' && $id != "IF") {?>
                           <!--  <tr>  <td>  <?php echo $name. "&nbsp;only" ; ?> <td><input name="showaspevc[]" type="checkbox" class="<?php echo $id; ?>" <?php echo $ishidden?> value="<?php echo $id; ?>" /> </td> </tr> -->
                           
 <?php
}
}
                    } //if rscheck loop

                }
                mysql_free_result($debtypers);
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