<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'NAICS Code Check' );
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."industries.php";
$industries = new industries();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if( isset( $_POST[ 'export_naics' ] ) == 'Export' ) {
	$industry = $_POST[ 'com_industry' ];
	$where = "";
	if( !empty( $industry ) ) {
		$where = "WHERE c.Industry = '" . $industry . "'";
	}
	$select = "SELECT c.Company_Id, i.IndustryName, c.FCompanyName, c.CIN, i.Industry_Id, c.Sector
				FROM cprofile c
				INNER JOIN industries i
					ON i.Industry_Id = c.Industry
				" . $where . "
				";
	$res = mysql_query( $select ) or die( $select );
	$numrows = mysql_num_rows( $res );
	header("Content-Disposition: attachment; filename=\"companies_naics_check.csv\"");
	header("Content-Type: application/vnd.ms-excel;");
	header("Pragma: no-cache");
	header("Expires: 0");
	$out = fopen("php://output", 'w');
	fputcsv($out, array( 'Company Name', 'Compnay ID', 'CIN', 'Industry ID', 'Industry Name', 'Sector ID', 'Sector Name' ), ',', '"');
	if( $numrows > 0 ) {
		while( $result = mysql_fetch_array( $res ) ) {
			$sectorCheck = "SELECT Sector_Id, SectorName
							FROM sectors
							WHERE Sector_Id = " . $result[ 'Sector' ] . " AND IndustryId_FK = '" . $industry . "' AND ( naics_code = 0 OR naics_code = NULL )
							";
			$res1 = mysql_query( $sectorCheck ) or die( $sectorCheck );
			$numrows1 = mysql_num_rows( $res1 );
			$secRes = mysql_fetch_array( $res1 );
			if( $numrows1 > 0 ) {
				fputcsv($out, array( $result[ 'FCompanyName' ], $result[ 'Company_Id' ], $result[ 'CIN' ], $result[ 'Industry_Id' ], $result[ 'IndustryName' ], $secRes[ 'Sector_Id' ], $secRes[ 'SectorName' ] ), ',', '"');	
			}
		}
	}
	fclose($out);
	exit;
}

$template->assign("industries" , $industries->getIndustries($where1,$order1));
$template->assign('pageTitle',"NAICS code Check");
$template->assign('pageDescription',"NAICS code Check");
$template->assign('pageKeyWords',"NAICS code Check");
$template->display('admin/naicsCodeCheck.tpl');

?>