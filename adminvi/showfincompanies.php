<?php
       require ("../dbConnect_cfs.php");
       $Db = new db_connection();
session_save_path("/tmp");
session_start();
?>
<html><head>
<title></title>
<script type="text/javascript">
function changeparent(el)
{

window.opener.document.companycfs.parentcompany.value=el.cells[0].innerHTML;
window.opener.document.companycfs.parentcompany_id.value=el.cells[1].innerHTML;
window.opener.document.chkparentcompany.checked=false;
self.close();
}
</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>
<body>
 <form name="showfincompany" method="post" action="">
<?php
       //if ((session_is_registered("UserNames")) )
	//{
  		if ($rsadvsiors = mysql_query("select company_id,company_name from company_dim order by company_name"))
		{
	?>
     			<table border=1 align=center cellpadding=0 cellspacing=0 width=40%
			        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
        					<?php
						   While($myrow=mysql_fetch_array($rsadvsiors, MYSQL_BOTH))
							{
								$companyname=trim($myrow["company_name"]);
								$companyid=trim($myrow["company_id"]);
                                                               ?>
									<tr onclick="changeparent(this);"><Td> <?php echo $companyname; ?></td> <td> <?php echo $companyid;?> </td></tr>
                                                       <?php
                                                       }
              					?>
                            </table>
              		<?php
                } //if loop
//} //session registered
?>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
   </script>
</form>
  </body>
 </html>