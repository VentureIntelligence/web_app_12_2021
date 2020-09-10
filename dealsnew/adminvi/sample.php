<?php
require("mod_cfs.php");
 // require ("../dbConnect_cfs.php");
 //  $dbconn = new db_connection();
// echo "<bR>*************1";
$val_timeid =return_timeid('2012-10-13');
echo "<br>Time ID = ".$val_timeid;
$compname="TSJ Media";
$company_id=  return_companyid($compname);
echo "<bR>Company Id= " .$company_id;

//$listedcompetitor="Repco Bank";
//$listedcompetitor_1_id=insert_company($listedcompetitor);
//echo "<bR>----- NEW ID- ".$listedcompetitor_1_id;

     /*function callbranch($parent)
	{
         
   $dbconn = new db_connection();
	  $op .='<table border=0 cellpadding="1" cellspacing=1><tr><td width="16"><a href="javascript:Toggle(\''.$parent.'\');"><img src="imageclose.jpg" width="16" height="16" hspace="0" vspace="0" border="0"></a></td><td><b><a href="javascript:Toggle(\''.$parent.'\');">'.$parent.'</a></b></table>';
	  $op .='<div id="'.$parent.'" style="display: none; margin-left: 2em;">';

	  $childparents=mysql_query("select  company_id from company_dim");
	  while($childparents_row=mysql_fetch_array($childparents))
	     $childp[]=$childparents_row["parent_id"];

	  $child=mysql_query("select company_name,company_id from company_dim where company_id in (select id from company_dim  where parent_comnpany_id='')");
	  while($childrow=mysql_fetch_array($child))
	  {
	    if (in_array($childrow["id"], $childp))
	      $getop=callbranch($childrow["name"]);
	    if ($getop)
	    {
	      $op .='<table border=0 cellpadding="1" cellspacing=1><tr><td>'.$getop.'</td></tr></table>';
	      unset($getop);
	    }
	    else
	      $op .='<table border=0 cellpadding="1" cellspacing=1><tr><td width="16"><img src="imagedoc.jpg" width="16" height="16" hspace="0" vspace="0" border="0"></td><td>'.$childrow["name"].'</a></td></tr></table>';
	  }
	  return $op;
	}

	$op .='<script type="text/javascript">
	function Toggle(item)
	{
	   obj=document.getElementById(item);
	   visible=(obj.style.display!="none")

	   key=document.getElementById("x" + item);
	   if (visible)
	   {
	     obj.style.display="none";
	     key.innerHTML="<img src=\'imageclose.jpg\' width=\'16\' height=\'16\' hspace=\'0\' vspace=\'0\' border=\'0\'>";
	   }
	   else
	   {
	      obj.style.display="block";
	      key.innerHTML="<img src=\'imageopen.jpg\' width=\'16\' height=\'16\' hspace=\'0\' vspace=\'0\' border=\'0\'>";
	   }
	}
 </script>';

	$op .='<table border=0 cellpadding="10" cellspacing=0><tr><td>';
	$parent1=mysql_query("select company_id,parent_company_id,company_name from company_dim where parent_company_id=''");
	echo "<br>****".$parent1;
	while($parentrow=mysql_fetch_array($parent1))
	{
	  $parentname[]=$parentrow["company_name"];
	  $parentid[]=$parentrow["parent_company_id"];
	}
	for ($i=0;$i<count($parentname);$i++)
	{
	  $getop =callbranch($parentname[$i]);
	  $op .=$getop;
	  $op .='</div>';
	}
	$op .='</td></tr></table>';
	echo $op;
    */

?>
