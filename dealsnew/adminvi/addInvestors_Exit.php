<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$fullString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $fullString=explode("/", $fullString);
	$IPO_MandA_flag=$fullString[0];
	$ipmandid=$fullString[1];
        if($ipmandid==0)
        {        $IPO_MandAId= rand();       }
        else
         {
               $IPO_MandAId=$ipmandid;    }
//on submission
        if($_POST)
        {
    	    $ipo_mandaflag=$_POST['txtpereflag'];
            $IPO_MandAId=$_POST['txtPEId'];
 	if($IPO_MandAId>0)
	{
          echo "<bR>-----------------------" .$ipo_mandaflag;
		$exitInvestor=$_POST['txtinvestor'];
		$invReturnMultiple=$_POST['txtReturnMultiple'];
		$invMoreInfo=$_POST['txtInvmoreinfor'];
			for ($j=0;$j<=4;$j++)
			{
				//	echo "<br>String-" .$exitInvestor[$j];
				if(trim($exitInvestor[$j])!="")
				{
                                  //echo "<bR>$$$$".$invReturnMultiple[$j];
					//if(($invReturnMultiple[j]="") || ($invReturnMultiple==" "))
					//   $invReturnValue=0;

                                        $investorId=return_insert_get_Investor($exitInvestor[$j]);

					if($investorId==0)
					{    $investorId=return_insert_get_Investor($exitInvestor[$j]);
                                        }
					//echo "<bR>--" .$investorId. "*** " .$ipo_mandaflag ;
					$ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invMoreInfo[$j]);
				}
			}
	}
      }
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title></title>

<SCRIPT LANGUAGE="JavaScript">
function returnIPOId()
{
	//alert(document.investorsexit.txtPEId.value);
        opener.document.addipo.hideIPOId.value= document.investorsexit.txtPEId.value;
	document.investorsexit.action="addInvestors_Exit.php";
	document.investorsexit.submit();
}

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="investorsexit" method="post" >
<td><input type="text" name="txtPEId" size="50" READONLY value="<?php echo $IPO_MandAId; ?>"> </td>
<td><input type="text" name="txtpereflag" size="50" READONLY value="<?php echo $IPO_MandA_flag; ?>"> </td>
<?php
	$cnt=5;
	//if($IPO_MandAId>0)
	//{
?>

<table width=60% align=left border=1 cellpadding=1 cellspacing=0>
<tr> <th>Investor </th><th> Return Multiple </th> <th>More Info </th></tr>

<?php
		for ($k=0;$k<=$cnt-1;$k++)
		{
?>
		<tr><td valign=top> <input type="text" name="txtinvestor[]"  size="30" > </td>
                <td valign=top> <input type="text" name="txtReturnMultiple[]"  size="5" value=0.00> </td>
                <td><textarea name="txtInvmoreinfor[]" rows="3" cols="40"> </textarea></td>
                </tr>
<?php
		}
?>
<tr><td align=center colspan=3><input type="button" value="Insert Investor(s)" name="insertExitInvestors"  onClick="returnIPOId();"  > </td></tr>
</table>

<?php
	//}
?>
</form>
</body></html>



<?php
/* inserts and return the investor id */
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor like '$investor%'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//insert acquirer
					$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
					if($rsInsAcquirer = mysql_query($insAcquirerSql))
					{
						$InvestorId=0;
						return $InvestorId;
					}
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$InvestorId = $myrow[0];
				//	echo "<br>Insert return investor id--" .$InvestorId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}


function insert_Investment_Investors($exit_flag,$dealId,$investorId,$returnValue,$moreinfo)
{
	$dbexecmgmt = new dbInvestments();
	if($exit_flag=="IPO")
	{
          $insDealInvSql="insert into ipo_investors(IPOId,InvestorId,MultipleReturn,InvMoreInfo) values($dealId,$investorId,$returnValue,'$moreinfo')";
          //echo "<br>-***--- ".$insDealInvSql;
          $getDealInvSql="Select IPOId,InvestorId from ipo_investors where IPOId=$dealId and InvestorId=$investorId";
          if($rsgetdealinvestor = mysql_query($getDealInvSql))
	  {
		$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
		if($deal_invcnt==0)
		{
                        if ($rsinsmgmt = mysql_query($insDealInvSql))
        		{
                                echo "<br>IPO Exit Investor Inserted--- " ;
        			return true;
        		}
                }
          }
          mysql_free_result($rsinsmgmt);
         }
         elseif($exit_flag=="MA")
	{

          $insmDealInvSql="insert into manda_investors(MandAId,InvestorId,MultipleReturn,InvMoreInfo) values($dealId,$investorId,$returnValue,'$moreinfo')";
          //echo "<br>&&&&";
          //echo "<br>---- ".$insmDealInvSql;
          $getmDealInvSql="Select MandAId,InvestorId from manda_investors where MandAId=$dealId and InvestorId=$investorId";
          if($rsmgetdealinvestor = mysql_query($getmDealInvSql))
	  {
		$mdeal_invcnt=mysql_num_rows($rsmgetdealinvestor);

		if($mdeal_invcnt==0)
		{

                        if ($rsminsmgmt = mysql_query($insmDealInvSql))
        		{
                                echo "<br>MandA Exit Investor Inserted--- ";
                        	return true;
        		}
        		mysql_free_result($rsminsmgmt);
                }
          }
         }
}
?>