<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	if( isset( $_POST[ 'startDate' ] ) && isset( $_POST[ 'endDate' ] ) ) {
		$dt1 = $_POST[ 'startDate' ];
		$dt2 = $_POST[ 'endDate' ];
	}

        if($_POST[ 'vcflagValue'] == 1){
            $vc = "and s.VCview=1 and pe.amount <=20 ";
        }
	header("Content-Disposition: attachment; filename=\"tag_report.csv\"");
	header("Content-Type: application/vnd.ms-excel;");
	header("Pragma: no-cache");
	header("Expires: 0");
	$out = fopen("php://output", 'w');

	$query = "SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.tags,
			pec.sector_business as sector_business,amount,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
			pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.dates as dates,pe.Exit_Status,
                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
			(SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                        from peinvestments as pe, industry as i,pecompanies as pec,stage as s
                        where                    
                        dates between '" . $dt1 . "' and '" . $dt2 . "' and  i.industryid=pec.industry and
                        pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId  and
                        pe.Deleted=0  and pec.industry !=15  ".$vc."
                        AND pe.PEId NOT
                        IN (
                        SELECT PEId
                        FROM peinvestments_dbtypes AS db
                        WHERE DBTypeId =  'SV'
                        AND hide_pevc_flag =1
                        )  GROUP BY pe.PEId order by  dates desc,companyname asc";
    $companyrs = mysql_query( $query ) or die( mysql_error() );
	$company_cnt = mysql_num_rows( $companyrs );
	$totalAmount = 0.00;
	$NoofDealsCntTobeDeducted = 0;
	$totalResult  = 0;
	while( $result = mysql_fetch_array( $companyrs ) ) {
		if( $result[ 'AggHide' ] == 1 || $result[ 'SPV' ] == 1 ) {

		} else {
			$NoofDealsCntTobeDeducted = 0;
			$amtTobeDeductedforAggHide = 0;
		
			$totalResult = $totalResult + 1 - $NoofDealsCntTobeDeducted;
			$totalAmount = $totalAmount + $result["amount"] - $amtTobeDeductedforAggHide;
			$tagsExplode = explode( ', ', $result[ 'tags' ] );
			foreach( $tagsExplode as $tagExp ) {
				$tgExplode = explode( ':', $tagExp );
				if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
					$tgTrim = trim( $tgExplode[ 1 ] );
					if( array_key_exists( $tgTrim, $tags ) ) {
						$tags[ $tgTrim ][ 'count' ] = $tags[ $tgTrim ][ 'count' ] + 1;
						$tags[ $tgTrim ][ 'amount' ] = $tags[ $tgTrim ][ 'amount' ] + $result[ 'amount' ];
						//$tagsCount[ $tgTrim ] = $tagsCount[ $tgTrim ] + 1;
					} else {
						$tags[ $tgTrim ][ 'count' ] = 1;
						$tags[ $tgTrim ][ 'amount' ] = $result[ 'amount' ];
						//$tagsCount[ $tgTrim ] = 1;
					}
				}
			}
		}
	}
	$totalAmount = round( $totalAmount );
	fputcsv($out, array( 'Tag', 'No.of Deals', 'Amount Invested($M)' ), ',', '"');
	foreach( $tags as $key => $tag ) {
		fputcsv($out, array( ucfirst( $key ), number_format( $tag[ 'count' ] ), round($tag[ 'amount' ], 2) ), ',', '"');
	}
	fclose($out);
?>
