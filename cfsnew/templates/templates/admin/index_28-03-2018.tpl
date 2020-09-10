<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$pageTitle}</title>
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_DIR}validator.js"></script>
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_DIR}prototype.js"></script>
{include file='admin/header.tpl'}
{literal}
<style type="text/css">
div{margin:0; padding:0;}
.boxcont{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#999;
}
.boxcont a{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#999;
}

.bcontainer
{
width:820px;
margin:0 auto;
background-color:#eee;
border-left:#000000 solid 1px;
border-right:#000000 solid 1px;

border-bottom:#000000 solid 1px;
padding:15px;

}

.label a{
float: left;
width: 250px;
font-weight: bold;
margin-right:15px;
font-size:18px;
}

.label h2
{
font:bold 18px Arial, Helvetica, sans-serif;
margin-top:5px;
}
input, textarea{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#777;
}

textarea{
width: 250px;
height: 150px;
padding:5px 10px;
}


</style>
{/literal}
</head>
<body>
<div class="bcontainer">
    <div class="label" style="margin-bottom:10px;">
    <h2>CFS Admin</h2>
    </div>
    <div style="clear:both"></div>
    <div>

  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="addCity.php">Add City</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="addState.php">Add State</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="addArchive.php">Add Archive</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="shareholder.php">Add Shareholder Information</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="competitors.php">Add Competitors</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="othercomparables.php">Add Other Comparables</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="rating.php">Add Rating</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="news.php">Add News</a></h2>{/if}  
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="addRound.php">Add ShareRound</a></h2>{/if}
  
  
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="editGroup.php"> Group Management </a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="users.php"> User Management </a></h2>{/if}

  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="deletePlstandard.php">Delete P & L Standard</a></h2>{/if}
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="deleteSector.php">Delete Sector</a></h2>{/if}
  
  {if $Usr_Flag eq 1}<h2 style="font-size:13px;"><a href="otherReport.php">Report Management</a></h2>{/if}
    </div>
	<div style="clear:both;">&nbsp;</div>
    <div style="clear:both"></div>
</div>
</body>
</html>