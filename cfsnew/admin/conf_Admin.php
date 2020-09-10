<?php


$GroupCStaus = array("1" =>"Parent",
					 "2" =>"Subsidiary",
					 "3" =>"Standalone",
					);
$ListingStatus = array(//"1" =>"Listed",
					  "2" =>"UnListed",
					);

$CountryList = array("113" =>"India",
					);
		
$adminuser->select($_SESSION['business']['Ident']);
$template->assign('Usr_Flag', $adminuser->elements['usr_flag']);
$template->assign('Usr_Type', $adminuser->elements['usr_type']);


?>