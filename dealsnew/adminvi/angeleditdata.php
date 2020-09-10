<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	//if (session_is_registered("SessLoggedAdminPwd") )
	//{
//&& session_is_registered("SessLoggedIpAdd")
?>
<html><head>
<title>Angel Investment Deal Info</title>
<SCRIPT LANGUAGE="JavaScript">



</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=editdeal   method="post" action="angeleditupdate.php" >
 <table border=1 align=center cellpadding=0 cellspacing=0 width=70%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();

    $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    $SelCompRef=$value;
    $currentyear=date("Y");

    $getDatasql = "SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
    DATE_FORMAT( DealDate, '%M' )  as dates,
    pec.website, pec.city, pec.RegionId, AngelDealId,DATE_FORMAT( DealDate, '%Y' ) as dtyear, Comment,MoreInfor,
    Validation,Link,pec.countryid,MultipleRound,FollowonVCFund,Exited
    FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec
    WHERE pe.AngelDealId =" .$SelCompRef. " AND i.industryid = pec.industry
    AND pec.PEcompanyID = pe.InvesteeId ";
    $getInvestorsSql="select peinv.AngelDealId,peinv.InvestorId,inv.Investor from angel_investors as peinv,
    peinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.AngelDealId=$SelCompRef";
    $industrysql = "select distinct i.industryid,i.industry  from industry as i	order by i.industry";

    $countrysql="select countryid,country from country";
  //  echo "<br>-------------".$getDatasql;
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
	    $multipleangelrounds=0;
	    $followonVCfunding=0;
	    $exited=0;
	    if($mycomprow["MultipleRound"]==1)
		$multipleangelrounds="checked";
	    if($mycomprow["FollowonVCFund"]==1)
		$followonVCfunding="checked";
	    if($mycomprow["Exited"]==1)
		$exited="checked";
?>
	    <tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Deal</b></td></tr>
	    <tr>
	   

	    <!-- PE id -->
	    <tr><td colspan=2 style="font-family: Verdana; font-size: 8pt" align=left>
	    <input type="text" name="txtPEId" size="10" value="<?php echo $mycomprow["AngelDealId"]; ?>">

	    <!-- PECompanyid -->
	    <input type="text" name="txtcompanyid" size="10" value="<?php echo $mycomprow["InvesteeId"]; ?>">
	    </td></tr>

	    <tr width=20% style="font-family: Verdana; font-size: 8pt">
	    <td >Company</td>
	    <td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
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
		    if ($id==$mycomprow[2])
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
	    ?> </select> </td> </tR>

	    <tr><td >Sector</td>
	    <td>
	    <input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>"> </td>
	    </tr>

	    <tr><td >Multipe Angel Round? </td>
	    <td >
	    <input name="chkmultipleangelround" type="checkbox" value=" <?php echo $mycomprow["MultipleRound"]; ?>" <?php echo $multipleangelrounds; ?>>
	    </td>  </tr>

	   <tr><td >Follow on VC Funding?</td>
	    <td >
	    <input name="chkfollowonvcfund" type="checkbox" value=" <?php echo $mycomprow["FollowonVCFund"]; ?>" <?php echo $followonVCfunding; ?>>
	    </td>  </tr>
	    <tr><td >Exited?</td>
	    <td >
	    <input name="chkexited" type="checkbox" value=" <?php echo $mycomprow["Exited"]; ?>" <?php echo $exited; ?>>
	    </td>  </tr>
	    
	    <tr>
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


	    $i=2000;
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
	    <td >Comment</td>
	    <td><input type="text" name="txtcomment" size="50" value="<?php echo $mycomprow["Comment"]; ?>"> </td>

	    </tr>

	    <tr>
	    <td >More Information (pls use \ before apostrophe if apostrophe has to be inserted)</td>
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
	}
    }
	mysql_free_result($companyrs);


 ?>

</table>
<table align=center>
<tr> <Td>
	<input type="submit" value="Update" name="updateDeal" >
</td></tr></table>




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

 //} // if resgistered loop ends
 //else
 //	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>