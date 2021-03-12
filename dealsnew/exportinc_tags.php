<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{ 
	if( isset( $_POST[ 'startDate' ] ) && isset( $_POST[ 'endDate' ] ) ) {
		$dt1 = $_POST[ 'startDate' ];
		$dt2 = $_POST[ 'endDate' ];
	}

	header("Content-Disposition: attachment; filename=\"tag_report.csv\"");
	header("Content-Type: application/vnd.ms-excel;");
	header("Pragma: no-cache");
	header("Expires: 0");
	$out = fopen("php://output", 'w');
        
        $query ="SELECT pe.IncDealId, 
            pe.IncubateeId,
            pec.companyname, 
            pec.industry, 
            i.industry, 
            pec.tags,
            pec.sector_business  as sector_business,
            Individual,
            inc.Incubator,
            pec.AdCity,
            pec.PECompanyid as companyid, 
            pe.date_month_year                     
            FROM 
            incubatordeals AS pe, 
            industry AS i,
            pecompanies AS pec,
            incubators as inc
            WHERE 
            date_month_year between '" . $dt1. "' and '" . $dt2 . "' AND
            pec.industry = i.industryid AND 
            pec.PEcompanyID = pe.IncubateeId AND  
            inc.IncubatorId=pe.IncubatorId AND 
            pe.Deleted =0 AND 
            pec.industry !=15 AND 
            Defunct=0 order by pec.tags asc";
        
    $companyrs = mysql_query( $query ) or die( mysql_error() );
	$company_cnt = mysql_num_rows( $companyrs );
	$totalAmount = 0.00;
	$NoofDealsCntTobeDeducted = 0;
	$totalResult  = 0;
	while( $result = mysql_fetch_array( $companyrs ) ) {
		if( $result[ 'AggHide' ] == 1 ) {

		} else {
			$NoofDealsCntTobeDeducted = 0;
			$amtTobeDeductedforAggHide = 0;
		
			$totalResult = $totalResult + 1 - $NoofDealsCntTobeDeducted;
			$tagsExplode = explode( ', ', $result[ 'tags' ] );
			foreach( $tagsExplode as $tagExp ) {
				$tgExplode = explode( ':', $tagExp );
				if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
					$tgTrim = trim( $tgExplode[ 1 ] );
					if( array_key_exists( $tgTrim, $tags ) ) {
						$tags[ $tgTrim ][ 'count' ] = $tags[ $tgTrim ][ 'count' ] + 1;
						
						//$tagsCount[ $tgTrim ] = $tagsCount[ $tgTrim ] + 1;
					} else {
						$tags[ $tgTrim ][ 'count' ] = 1;
						
						//$tagsCount[ $tgTrim ] = 1;
					}
				}
			}
		}
	}
	$totalAmount = round( $totalAmount );
	fputcsv($out, array( 'Tag', 'No.of Deals' ), ',', '"');
	foreach( $tags as $key => $tag ) {
		fputcsv($out, array( ucfirst( $key ), $tag[ 'count' ] ), ',', '"');
	}
	fclose($out);
}
?>
