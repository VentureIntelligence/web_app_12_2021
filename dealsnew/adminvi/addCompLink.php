<?php
 require("../dbconnectvi.php");
  $Db = new dbInvestments();

  	$companyId = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
  //	echo "<br>---". $companyId;
//on submission
	$compId=$_POST['txtinvId'];
	if($compId>0)
	{
		$companyLink=$_POST['txtCompanyLink'];
		$companyComment=$_POST['txtCompanyComment'];
                //echo "<bR>--".$companyLink;
		for ($j=0;$j<=4;$j++)
			{
				if(trim($companyLink[$j])!="")
				{
					//echo "<br>&&******".$j."--" .$companyLink[$j];
					$companyLinkString=$companyLink[$j];
					$companyCommentString=$companyComment[$j];
					if(inst_companies_link_comment($compId,trim($companyLinkString),trim($companyCommentString)))
					{
					echo "<br>" .$j+1 ."- Link, Comment Added";
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
<title>Company Profile-Link and Comment</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="addinvmgmt" method="post" action="addCompLink.php">
<td><input type="hidden" name="txtinvId" size="50" value="<?php echo $companyId; ?>"> </td>


<?php
	//echo "<br>--" .$InvestorId;
	$cnt=5;
	if($companyId>0)
	{
?>

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Add Company's Link & Comment</font> </b></center></p>
Please add in this format : <b>Link , Comment </b>
<table align=left width=60% align=center border=1 cellpadding=0 cellspacing=0>
<?php
		for ($k=0;$k<=$cnt-1;$k++)
		{
?>
		<tr>
                <td valign=top> <input type="text" name="txtCompanyLink[]"  size="60" > </td>
                <td><textarea name="txtCompanyComment[]" rows="3" cols="40"> </textarea> </td>
                </tr>
<?php
		}

?>
    <tr><td align=center colspan=2> <input type="submit" value="Update" name="updatecompMgmt" ></td></tr>
</table>


<?php
	}
?>
</form>
</body></html>

<?php

function inst_companies_link_comment($PECompanyId,$Link,$Comment)
{
	$dbexecmgmt = new dbInvestments();
	$insExecmgmtSql = "insert into pecompanies_links values ($PECompanyId,'$Link','$Comment')";

		if ($rsinsmgmt = mysql_query($insExecmgmtSql))
		{
                
			return true;
		}
	mysql_free_result($rsinsmgmt);
//	$dbexecmgmt.close();

}


?>