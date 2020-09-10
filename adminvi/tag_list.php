<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;

		$delPEIdArrayLength=0;
		$delPEId=$_POST['PEId'];
		$delPEIdArrayLength= count($delPEId);

		$hidePEIdArrayLength=0;
                $hidePEId=$_POST['hideAgg'];
                $hidePEIdArrayLength=count($hidePEId);
                //echo "<br>****".$hidePEIdArrayLength;

		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update peinvestments set Deleted=1 where PEId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
				//echo "<Br>--".$updateSql;
				}
			}
		}
		if($hidePEIdArrayLength>0)
		{
			foreach ($hidePEId as $hidePEIdtoHide)
			{
				$updateAggHideSql="Update peinvestments set AggHide=1 where PEId=".$hidePEIdtoHide ;
				if ($companyrs=mysql_query($updateAggHideSql))
				{
				//echo "<Br>--".$updateAggHideSql;
				}
			}
		}


                		$month1=$_POST['month1'];
				$year1 = $_POST['year1'];
				$month2=$_POST['month2'];
				$year2 = $_POST['year2'];

			//	$notable=false;
			//	$vcflagValue=$_POST['txtvcFlagValue'];
			//	echo "<br>FLAG VALIE--" .$vcflagValue;

					$addVCFlagqry = " and pec.industry !=15 ";
					$searchTitle = "List of PE Investments ";

			if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
			{
			 $companysql = "SELECT pe.PEId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							 amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,pe.comment,pe.uploadfilename,FinLink,AggHide
							 FROM peinvestments AS pe, industry AS i, pecompanies AS pec ,stage as s
							 WHERE pec.industry = i.industryid
							 AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId
							 and pe.Deleted=0" .$addVCFlagqry.
						 "order by companyname";

			}
			elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
				{

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.PEId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
					amount,DATE_FORMAT(dates,'%b-%Y') as dealperiod,pe.comment,pe.uploadfilename,FinLink ,AggHide
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s where pec.industry=i.industryid
					and dates between '".$dt1."' and '".$dt2 ."'
					and	pec.PEcompanyID = pe.PECompanyID  and s.StageId=pe.StageId
					and pe.Deleted=0 " .$addVCFlagqry. "order by companyname  ";
	//				echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
			else
			{
				echo "<br> INVALID DATES GIVEN ";
				$fetchRecords=false;
				}
		//echo "<br>--" .$companysql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - PE Investments</title>

<script type="text/javascript">
function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("PEId[]");
		for(var i=0;i<e.length;i++)
		{
			chk=e[i].checked;
		//	alert(chk);
			if(chk==true)
			{
				if (confirm("Are you sure you want to delete selected deals ? "))
				{
					e[i].checked=true;
					document.pegetdata.action="pegetdata.php";
					document.pegetdata.submit();
					break;
				}
			}
		}


	if (chk==false)
		{
			alert("Pls select one or more to delete");
			return false;
		}
}
function aggHide()
{

	var chk1;
	var e1=document.getElementsByName("hideAgg[]");
		for(var j=0;j<e1.length;j++)
		{
			chk1=e1[j].checked;
		//	alert(chk);
			if(chk1==true)
			{
				if (confirm("Are you sure you want to hide the selected deals ? "))
				{
					e1[j].checked=true;

					document.pegetdata.action="pegetdata.php";
					document.pegetdata.submit();
					break;
				}
			}
		}


	if (chk1==false)
		{
			alert("Pls select one or more to hide");
			return false;
		}
}
</script>

<style type="text/css">


</style>
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body>

<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>
   <style>.box{ width:100%; padding: 20px;}
   .inner_box{ float:left; width: 32%;   }
   .box_1{
        border-color: #efefef;
        border-style: solid;
        border-width: 1px 1px 0 1px;
   }
   .box_2{border-top:1px solid #efefef;}
   .box_3{
        border-color: #efefef;
        border-style: solid;
        border-width: 1px 1px 0 1px;} 
   .innerContent{ padding: 10px; border-bottom:1px solid #efefef; }
   .innerContent.title{ font-weight: bold; font-size:12px; }</style>
	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; margin-top:5px;overflow-y: scroll;" class="main_content_container" >
	    <div id="maintextpro">
                <?php 
                    $Industry_result = mysql_query("SELECT tag_name FROM tags WHERE tag_type ='Industry Tags' order by tag_name");
                    $Industry_count = mysql_num_rows($Industry_result);
                    $Sector_result = mysql_query("SELECT tag_name FROM tags WHERE tag_type ='Sector Tags' order by tag_name");
                    $Sector_count = mysql_num_rows($Sector_result);
                    $Competitor_result = mysql_query("SELECT tag_name FROM tags WHERE tag_type ='Competitor Tags' order by tag_name");
                    $Competitor_count = mysql_num_rows($Competitor_result);
                    $max_count = max($Industry_count,$Sector_count,$Competitor_count);
                ?>
                <div class="box content_container">
                    <div class="inner_box box_1">
                        <div class="innerContent title">Industry Tags</div>
                        <?php 
                        $i=0;
                        while($res1 = mysql_fetch_array($Industry_result)){ ?>
                        <div class="innerContent"><?php echo $res1['tag_name']; ?></div>
                        <?php $i++; }
                        if($i<$max_count){
                            for($l=$i;$l<$max_count;$l++){ ?>
                            <div class="innerContent">&nbsp;</div>
                            <?php } } ?>
                    </div>
                    <div class="inner_box box_2">
                        <div class="innerContent title">Sector Tags</div>
                        <?php 
                        $j=0;
                        while($res2 = mysql_fetch_array($Sector_result)){ ?>
                        <div class="innerContent"><?php echo $res2['tag_name']; ?></div>
                        <?php $j++; }
                        if($j<$max_count){
                            for($l=$j;$l<$max_count;$l++){ ?>
                            <div class="innerContent">&nbsp;</div>
                            <?php } } ?>
                    </div>
                    <div class="inner_box box_3">
                        <div class="innerContent title">Competitor Tags</div>
                        <?php 
                        $k=0;
                        while($res3 = mysql_fetch_array($Competitor_result)){ ?>
                        <div class="innerContent"><?php echo $res3['tag_name']; ?></div>
                        <?php $k++; } 
                        if($k<$max_count){ 
                            for($l=$k;$l<$max_count;$l++){ ?>
                        <div class="innerContent">&nbsp;</div>
                            <?php } } ?>
                    </div>
                </div>


	        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>


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
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>