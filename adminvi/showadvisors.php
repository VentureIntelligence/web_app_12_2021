<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	if($_POST)
	{
         $adtype=$_POST['advisortype'];
         $advid=$_POST['AdvisorId'];
         $advidarray=0;
         $advidarray=count($advid);
         if($advidarray>0)
         {
            $cnt=0;
         	foreach ($advid as $advisorid)
	        {
                  // echo "<br>---" .$advisorid;
                   $updateAdvisorTypeSql="update advisor_cias set AdvisorType= '$adtype' where CIAId=$advisorid";
                     if($rsupdateAdvisor = mysql_query($updateAdvisorTypeSql))
                    {
                              //echo "<br>----- ".$updateAdvisorTypeSql;
                               $cnt=$cntt+1;
			}
                }
                //echo "<br>Total rows affected-".$cnt;
         }
        }
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;


			$advisorssearch=$_POST['advisorssearch'];
			$searchTitle = "List of Advisors ";
                        $getinvSql="(
                          SELECT DISTINCT adac.CIAId, cia.cianame, adac.CIAId AS AcqCIAId ,cia.AdvisorType,cia.website
                          FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac, stage AS s
                          WHERE peinv.Deleted =0
                          AND s.StageId = peinv.StageId
                          AND c.PECompanyId = peinv.PECompanyId
                          AND adac.CIAId = cia.CIAID
                          AND adac.PEId = peinv.PEId
                          AND cia.cianame like '%$advisorssearch%'
                          )
                          UNION (
                          
                          SELECT DISTINCT adac.CIAId, cia.cianame, adac.CIAId AS AcqCIAId ,cia.AdvisorType,cia.website
                          FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac, stage AS s
                          WHERE peinv.Deleted =0
                          AND s.StageId = peinv.StageId
                          AND c.PECompanyId = peinv.PECompanyId
                          AND adac.CIAId = cia.CIAID
                          AND adac.PEId = peinv.PEId
                          AND cia.cianame like '%$advisorssearch%'
                          )
                          UNION (
                          
                          SELECT DISTINCT adac.CIAId, cia.cianame, adac.CIAId AS AcqCIAId ,cia.AdvisorType,cia.website
                          FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND adac.CIAId = cia.CIAID
                          AND adac.PEId = peinv.MandAId
                          AND cia.cianame like '%$advisorssearch%'
                          )
                          UNION (
                          
                          SELECT DISTINCT adac.CIAId, cia.cianame, adac.CIAId AS AcqCIAId ,cia.AdvisorType,cia.website
                          FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND adac.CIAId = cia.CIAID
                          AND adac.PEId = peinv.MandAId
                          AND cia.cianame like '%$advisorssearch%'
                          )
                          UNION (

                          SELECT DISTINCT adac.CIAId, cia.cianame, adac.CIAId AS AcqCIAId,cia.AdvisorType,cia.website
                          FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND adac.CIAId = cia.CIAID
                          AND adac.MAMAId = peinv.MAMAId
                          AND cia.cianame like '%$advisorssearch%'
                          )
                          UNION (
                          
                          SELECT DISTINCT adac.CIAId, cia.cianame, adac.CIAId AS AcqCIAId,cia.AdvisorType,cia.website
                          FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adac
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND adac.CIAId = cia.CIAID
                          AND adac.MAMAId = peinv.MAMAId
                          AND cia.cianame like '%$advisorssearch%'
                          )
                          ORDER BY cianame";
                      //  echo "<bR>--" .$getinvSql;


		//echo "<br>--" .$companysql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - Advisors</title>

<script type="text/javascript">

</script>

<style type="text/css">


</style>
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body>

<form name="getinvestor"  method="post" action="showadvisors.php" >
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
	<div style="background-color:#FFFFFF; width:565px; float:left; padding-left:2px;">
	  <div style="width:565px; /*height:440px;*/ margin-top:5px;" class="main_content_container">
	    <div id="maintextpro">
        <div id="headingtextpro">

		<?php
					$totalInv=0;
				 	  // echo "<br> query final-----" .$getcompSql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($getinvSql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }
				           if($company_cnt > 0)
				           {
				           	//	$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Advisor found for this search ";
				           }

		           ?>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  <br /> </div>
					<?php
					if($company_cnt>0)
					{

					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 542px; /*height:305px;*/ overflow: scroll;" class="content_container">
								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
								<tr><th> Advisors</th><th> Type</th><th> Website </th></tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
							 ?>
							 	<A style="text-decoration:none" href="peeditdata.php?value=PE-<?php echo $myrow["PEId"];?> "
								   target="popup" onclick="window.open('peeditdata.php?value=PE-<?php echo $myrow["PEId"];?>', 'popup', 'scrollbars=1,width=600,height=500');return false">
								   <?php echo $myrow["companyname"]; ?>

							<tr><Td><input type="checkbox" name="AdvisorId[]" value="<?php echo $myrow["CIAId"];?>" >
						
                                                	<A href="advisoredit.php?value=<?php echo $myrow["CIAId"];?> "
						   target="popup" onclick="MyWindow=window.open('advisoredit.php?value=<?php echo $myrow["CIAId"];?>', 'popup', 'scrollbars=1,width=600,height=500');MyWindow.focus(top);return false">

                                                        <?php echo $myrow["cianame"];?> </td> <td> <?php echo $myrow["AdvisorType"];?> </td>
                                                        <td> <?php echo $myrow["website"];?> </td>
						</tr>
							<?php

							}
						?>
					 </table>
					</div>

		<?php
					}
		?> <br /><br />
               Choose Advisor Type and Submit
                 <SELECT NAME="advisortype">
                 <OPTION VALUE="0" SELECTED> Pls Select </OPTION>
                <OPTION VALUE="L" >Legal</OPTION>
                <OPTION VALUE="T">Transaction</OPTION> </SELECT>
                
                <input type="submit" name="advisorsubmit" value="Submit">
                

		</div>
       	        </div> <!-- end of maintext pro-->


	  </div>

	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
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
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>