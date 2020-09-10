<?php
require "../dbconnectvi.php";
$Db = new dbInvestments();

$fullString1 = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
$fullString = explode("/", $fullString1);
$IPO_MandA_flag = $fullString[0];
$ipmandid = $fullString[1];
if ($ipmandid == 0) {$IPO_MandAId = rand();} else {
    $IPO_MandAId = $ipmandid;}
//on submission
if ($_POST) {
    $ipo_mandaflag = $_POST['txtpereflag'];
    $IPO_MandAId = $_POST['txtPEId'];
    if ($IPO_MandAId > 0) {
        echo "<bR>-----------------------" . $ipo_mandaflag;
        $exitInvestor = $_POST['txtinvestor'];
        $invReturnMultiple = $_POST['txtReturnMultiple'];
        $invMoreInfo = $_POST['txtInvmoreinfor'];

        $invMoreIRR = $_POST['irr'];
        $txtinvestorid = $_POST["txtinvestorid"];
        $rowcount = $_POST["rowcount"];
        $row_db_count = $_POST["row_db_count"];

        if ($fullString[0] == "IPO") {
            $getInvestorsSql = "select ipo.IPOId, ipo.InvestorId, inv.Investor, ipo.MultipleReturn, ipo.InvMoreInfo, ipo.IRR from ipo_investors as ipo, peinvestors as inv where inv.InvestorId=ipo.InvestorId and ipo.IPOId=$IPO_MandAId ";
        } elseif ($fullString[0] == "MA") {
            $getInvestorsSql = "select mandainv.MandAId, mandainv.InvestorId, inv.Investor, mandainv.MultipleReturn, mandainv.InvMoreInfo, mandainv.IRR  from manda_investors as mandainv, peinvestors as inv where inv.InvestorId=mandainv.InvestorId and mandainv.MandAId=$IPO_MandAId ";
        }
        if ($fullString[0] == "IPO") {
            if (mysql_query("delete from ipo_investors where IPOId=$IPO_MandAId ")) {
                //echo "<br>IPO Investor deleted";
            }
        } elseif ($fullString[0] == "MA") {
            if (mysql_query("delete from manda_investors where MandAId=$IPO_MandAId ")) {
                //echo "<br>Manda Investor deleted";
            }
        }

        // for ($j=0;$j<=4;$j++)
        // {
        //     //    echo "<br>String-" .$exitInvestor[$j];
        //     if(trim($exitInvestor[$j])!="")
        //     {
        //                       //echo "<bR>$$$$".$invReturnMultiple[$j];
        //         //if(($invReturnMultiple[j]="") || ($invReturnMultiple==" "))
        //         //   $invReturnValue=0;

        //                             $investorId=return_insert_get_Investor($exitInvestor[$j]);

        //         if($investorId==0)
        //         {    $investorId=return_insert_get_Investor($exitInvestor[$j]);
        //                             }
        //         //echo "<bR>--" .$investorId. "*** " .$ipo_mandaflag ;
        //         $ciaIdToInsert=insert_Investment_Investors($ipo_mandaflag,$IPO_MandAId,$investorId,$invReturnMultiple[$j],$invMoreInfo[$j]);
        //     }
        // }
        for ($j = 0; $j < $rowcount; $j++) {

            if (trim($exitInvestor[$j]) != "") { /**/

                if ($row_db_count > 0) {
                    $investorId = return_insert_get_Investor_edit_update($exitInvestor[$j], $txtinvestorid[$j]);
                    if ($investorId != '') {
                        $ciaIdToInsert = insert_Investment_Investors($ipo_mandaflag, $IPO_MandAId, $investorId, $invReturnMultiple[$j], $invMoreInfo[$j], $invMoreIRR[$j]);
                    } else {
                        $investorId = return_insert_get_Investor($exitInvestor[$j]);
                        ///echo "<bR>--1" .$investorId. "*** " .$ipo_mandaflag ;
                        if ($investorId != '') {
                            $ciaIdToInsert = insert_Investment_Investors($ipo_mandaflag, $IPO_MandAId, $investorId, $invReturnMultiple[$j], $invMoreInfo[$j], $invMoreIRR[$j]);
                        }
                    }
                } else {
                    $investorId = return_insert_get_Investor($exitInvestor[$j]);
                    /// echo "<bR>--2" .$investorId. "*** " .$ipo_mandaflag ;
                    if ($investorId != '') {
                        $ciaIdToInsert = insert_Investment_Investors($ipo_mandaflag, $IPO_MandAId, $investorId, $invReturnMultiple[$j], $invMoreInfo[$j], $invMoreIRR[$j]);
                    }
                }
            }
        }

        $deleted_investor = array();
        if ($rsinvestors = mysql_query($getInvestorsSql)) {
            while ($myInvrow = mysql_fetch_array($rsinvestors, MYSQL_BOTH)) {
                $InvestorName = $myInvrow['Investor'];
                $Investor_Id = $myInvrow['InvestorId'];
                if (!in_array($InvestorName, $exitInvestor)) {
                    if ($fullString[0] == "IPO") {
                        if (mysql_query("delete from ipo_investors where IPOId=$IPO_MandAId and InvestorId=$Investor_Id")) {
                            echo "<br>Manda Investor deleted";
                            //$deleted_investor[] = $InvestorName;
                        }
                    } elseif ($fullString[0] == "IPO") {
                        if (mysql_query("delete from manda_investors where MandAId=$IPO_MandAId and InvestorId=$Investor_Id")) {
                            echo "<br>Manda Investor deleted";
                            //$deleted_investor[] = $InvestorName;
                        }
                    }

                }
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
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
function returnIPOId()
{
	//alert(document.investorsexit.txtPEId.value);
    opener.document.addipo.hideIPOId.value= document.investorsexit.txtPEId.value;
	document.investorsexit.action="addInvestors_Exit.php?value=<?php echo $fullString1; ?>";
	document.investorsexit.submit();
}
function addMoreRow(){
    var rowcount = $('#rowcount').val() + 1;
    var str = '<tr><td valign=top><input type="text" name="txtinvestor[]"  size="30" > </td>';
        str += '<td valign=top> <input type="text" name="txtReturnMultiple[]"  size="5" value=0.00> </td>';
        str += '<td valign=top> <input type="text" name="irr[]"  size="5" value=0.00></td>';
        str += '<td><textarea name="txtInvmoreinfor[]" rows="3" cols="40"> </textarea></td>';
        str += '</tr>';
    $('#rowcount').val(rowcount);
    $('#mutiple_investor').append(str);
}
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="investorsexit" method="post" >
<td><input type="text" name="txtPEId" size="50" READONLY value="<?php echo $IPO_MandAId; ?>"> </td>
<td><input type="text" name="txtpereflag" size="50" READONLY value="<?php echo $IPO_MandA_flag; ?>"> </td>
<?php
$cnt = 5;
//if($IPO_MandAId>0)
//{
?>

<table width=60% align=left border=1 id="mutiple_investor" cellpadding=1 cellspacing=0>
<tr> <th>Investor </th><th> Return Multiple </th> <th>IRR</th> <th>More Info </th></tr>

<?php

if($fullString[0] == "IPO"){
	$getInvestorsSql = "select ipo.IPOId, ipo.InvestorId, inv.Investor, ipo.MultipleReturn, ipo.InvMoreInfo, ipo.IRR  from ipo_investors as ipo, peinvestors as inv where inv.InvestorId=ipo.InvestorId and ipo.IPOId=$IPO_MandAId   ORDER BY ipo.IPOId ASC";
} elseif($fullString[0] == "MA") {
	$getInvestorsSql = "select mandainv.MandAId, mandainv.InvestorId, inv.Investor, mandainv.MultipleReturn, mandainv.InvMoreInfo, mandainv.IRR  from manda_investors as mandainv, peinvestors as inv where inv.InvestorId=mandainv.InvestorId and mandainv.MandAId=$IPO_MandAId   ORDER BY mandainv.MandAId ASC";
} 

if ($rsinvestors = mysql_query($getInvestorsSql)) {
    $i = 0;
    while ($myInvrow = mysql_fetch_array($rsinvestors, MYSQL_BOTH)) {
        //print_r( $myInvrow);exit();
        ?>
				<input name="txtinvestorid[]" type="hidden" value="<?php echo $myInvrow["InvestorId"]; ?>" />
				<tr>
					<td valign=top> <input type="text" name="txtinvestor[]"  size="30" value="<?php echo $myInvrow["Investor"]; ?>"  > </td>
					<td valign=top> <input type="text" name="txtReturnMultiple[]"  value="<?php echo $myInvrow["MultipleReturn"]; ?>"  size="5"> </td>
					<td valign=top> <input type="text" name="irr[]"                value="<?php echo $myInvrow["IRR"]; ?>"  size="5" > </td>
					<td><textarea  name="txtInvmoreinfor[]" rows="3"  cols="40"><?php echo $myInvrow["InvMoreInfo"]; ?></textarea></td>
                </tr>

<?php
$i++;
    }
}
?>

<input type="hidden" name="row_db_count" value="<?php echo mysql_num_rows($rsinvestors); ?>">
<input type="hidden" name="rowcount"    id="rowcount" value="<?php echo $cnt + mysql_num_rows($rsinvestors); ?>">

<?php
for ($k = 0; $k <= $cnt - 1; $k++) {
    ?>
		<tr>   
			    <td valign=top> <input type="text" name="txtinvestor[]"  size="30" > </td>
				<td valign=top> <input type="text" name="txtReturnMultiple[]"  size="5" value=0.00> </td>
				<td valign=top> <input type="text" name="irr[]"  size="5" value=0.00> </td>
                <td><textarea name="txtInvmoreinfor[]" rows="3" cols="40"> </textarea></td>
         </tr>
<?php
}
?>
	<tr>
		<!-- <td align=center colspan=3><input type="button" value="Insert Investor(s)" name="insertExitInvestors"  onClick="returnIPOId();"  > </td> -->
		<table width=60% align=left cellpadding=1 cellspacing=0 style="margin-top: 10px;">
			<tr>
				<td align=right><input type="button" value="Add More" name="addmore" onClick="addMoreRow();" > </td>
				<td align=left><input type="button" value="Insert Investor(s)" name="insertExitInvestors"  onClick="returnIPOId();"  > </td>
				<td align=center>&nbsp;</td>
			</tr>
		</table>
	</tr>
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
    $dblink = new dbInvestments();
    $investor = trim($investor);
	// $getInvestorIdSql = "select InvestorId from peinvestors where Investor like '$investor%'"; 
	$getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor'";
    //echo "<br>select--" .$getInvestorIdSql;
    if ($rsgetInvestorId = mysql_query($getInvestorIdSql)) {
        $investor_cnt = mysql_num_rows($rsgetInvestorId);
        //echo "<br>Investor count-- " .$investor_cnt;
        if ($investor_cnt == 0) {
            //insert acquirer
            $insAcquirerSql = "insert into peinvestors(Investor) values('$investor')";
            if ($rsInsAcquirer = mysql_query($insAcquirerSql)) {
				$InvestorId = mysql_insert_id();
                return $InvestorId;
            }
        } elseif ($investor_cnt >= 1) {
            while ($myrow = mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH)) {
                $InvestorId = $myrow[0];
                //    echo "<br>Insert return investor id--" .$InvestorId;
                return $InvestorId;
            }
        }
    }
    $dblink . close();
}

function return_insert_get_Investor_edit_update($investor, $investor_id)
{
    $dblink = new dbInvestments();
    $investor = trim($investor);
    $getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor' and InvestorId = '$investor_id'";
    //echo "<br>select--" .$getInvestorIdSql;
    if ($rsgetInvestorId = mysql_query($getInvestorIdSql)) {
        $investor_cnt = mysql_num_rows($rsgetInvestorId);
        //echo "<br>Investor count-- " .$investor_cnt;
        if ($investor_cnt == 1) {
            return $investor_id;
        } else {
            return '';
        }
    } else {
        return '';
    }
    $dblink . close();
}


function insert_Investment_Investors($exit_flag, $dealId, $investorId, $returnValue, $moreinfo, $irr)
{
    
	$dbexecmgmt = new dbInvestments();
	
    if ($exit_flag == "IPO") {

		$getDealInvSql = "Select IPOId,InvestorId from ipo_investors where IPOId=$dealId and InvestorId=$investorId";
		
		
        if ($rsgetdealinvestor = mysql_query($getDealInvSql)) {

			$deal_invcnt = mysql_num_rows($rsgetdealinvestor);
			
            if ($deal_invcnt == 0) {
                $insDealInvSql = "insert into ipo_investors(IPOId,InvestorId,MultipleReturn,InvMoreInfo,IRR) values($dealId,$investorId,$returnValue,'$moreinfo',$irr)";
				
				if ($rsinsmgmt = mysql_query($insDealInvSql)) {
                    echo "<br>IPO Investor Inserted";
                    return true;
                }

            }
            // echo "<br>-***IPO--- ".$insDealInvSql;
        }
        mysql_free_result($rsinsmgmt);
    } elseif ($exit_flag == "MA") {

        //$insmDealInvSql = "insert into manda_investors(MandAId,InvestorId,MultipleReturn,InvMoreInfo,IRR) values($dealId,$investorId,$returnValue,'$moreinfo',$irr)";
        //echo "<br>&&&&";
        //echo "<br>MA---- ".$insmDealInvSql;
        $getmDealInvSql = "Select MandAId,InvestorId from manda_investors where MandAId=$dealId and InvestorId=$investorId";

        // if ($rsmgetdealinvestor = mysql_query($getmDealInvSql)) {
        //     $mdeal_invcnt = mysql_num_rows($rsmgetdealinvestor);

        //     if ($mdeal_invcnt == 0) {
        //         $insmDealInvSql = "insert into manda_investors(MandAId,InvestorId,MultipleReturn,InvMoreInfo,IRR) values($dealId,$investorId,$returnValue,'$moreinfo',$irr)";
        //         if ($rsminsmgmt = mysql_query($insmDealInvSql)) {
        //             echo "<br>MandA Exit Investor Inserted--- ";
        //             return true;
        //         }
        //         mysql_free_result($rsminsmgmt);
        //     }
        // }
		if ($rsgetdealinvestor = mysql_query($getmDealInvSql)) {

            $deal_invcnt = mysql_num_rows($rsgetdealinvestor);
            if ($deal_invcnt == 0) {
                $insDealInvSql ="insert into manda_investors(MandAId,InvestorId,MultipleReturn,InvMoreInfo,IRR) values($dealId,$investorId,$returnValue,'$moreinfo',$irr)";
				if ($rsinsmgmt = mysql_query($insDealInvSql)) {
					//print_r($insDealInvSql);
                    echo "<br>MandA Exit  Investor Inserted";
                    return true;
                }
            }
            // echo "<br>-***IPO--- ".$insDealInvSql;
        }
        mysql_free_result($rsinsmgmt);
    }
}
// function insert_Investment_Investors($exit_flag, $dealId, $investorId, $returnValue, $moreinfo, $irr)
// {
//     $dbexecmgmt = new dbInvestments();
//     if ($exit_flag == "IPO") {
//         $insDealInvSql = "insert into ipo_investors(IPOId,InvestorId,MultipleReturn,InvMoreInfo) values($dealId,$investorId,$returnValue,'$moreinfo')";
//         //echo "<br>-***--- ".$insDealInvSql;
//         $getDealInvSql = "Select IPOId,InvestorId from ipo_investors where IPOId=$dealId and InvestorId=$investorId";
//         if ($rsgetdealinvestor = mysql_query($getDealInvSql)) {
//             $deal_invcnt = mysql_num_rows($rsgetdealinvestor);
//             if ($deal_invcnt == 0) {
//                 if ($rsinsmgmt = mysql_query($insDealInvSql)) {
//                     echo "<br>IPO Exit Investor Inserted--- ";
//                     return true;
//                 }
//             }
//         }
//         mysql_free_result($rsinsmgmt);
//     } elseif ($exit_flag == "MA") {

//         $insmDealInvSql = "insert into manda_investors(MandAId,InvestorId,MultipleReturn,InvMoreInfo) values($dealId,$investorId,$returnValue,'$moreinfo')";
//         //echo "<br>&&&&";
//         //echo "<br>---- ".$insmDealInvSql;
//         $getmDealInvSql = "Select MandAId,InvestorId from manda_investors where MandAId=$dealId and InvestorId=$investorId";
//         if ($rsmgetdealinvestor = mysql_query($getmDealInvSql)) {
//             $mdeal_invcnt = mysql_num_rows($rsmgetdealinvestor);

//             if ($mdeal_invcnt == 0) {

//                 if ($rsminsmgmt = mysql_query($insmDealInvSql)) {
//                     echo "<br>MandA Exit Investor Inserted--- ";
//                     return true;
//                 }
//                 mysql_free_result($rsminsmgmt);
//             }
//         }
//     }
// }
?>