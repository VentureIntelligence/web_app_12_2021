<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	if( isset( $_POST[ 'startDate' ] ) && isset( $_POST[ 'endDate' ] ) ) {
		$dt1 = $_POST[ 'startDate' ];
		$dt2 = $_POST[ 'endDate' ];
	}
        $dbtype = $_POST[ 'dbtype' ];
	header("Content-Disposition: attachment; filename=\"tag_report.csv\"");
	header("Content-Type: application/vnd.ms-excel;");
	header("Pragma: no-cache");
	header("Expires: 0");
	$out = fopen("php://output", 'w');

	$query ="SELECT pe.PECompanyId as companyid, 
            pec.companyname, 
            pec.industry, 
            i.industry, 
            pec.tags,
            pec.sector_business as sector_business,
            pe.amount, 
            pe.round, 
            s.Stage,  
            pe.stakepercentage, 
            DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
            pec.website, 
            pec.city, 
            pec.region, 
            pe.PEId,
            pe.COMMENT,
            pe.MoreInfor,
            pe.hideamount,
            pe.hidestake,
            pe.StageId,
            SPV,
            AggHide,
            pe.dates as dates,
            GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor 
            FROM peinvestments AS pe, 
            industry AS i,
            pecompanies AS pec,
            stage as s,
            peinvestments_dbtypes as pedb,
            peinvestments_investors as peinv_inv,
            peinvestors as inv
            WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and 
            pec.industry = i.industryid AND 
            pec.PEcompanyID = pe.PECompanyID AND 
            pe.StageId=s.StageId AND 
            pedb.PEId=pe.PEId AND 
            pedb.DBTypeId='$dbtype' AND 
            pe.Deleted =0 and 
            pec.industry!=15 AND 
            peinv_inv.PEId=pe.PEId AND 
            inv.InvestorId=peinv_inv.InvestorId  
            GROUP BY pe.PEId ";
        
    $companyrs = mysql_query( $query ) or die( mysql_error() );
	$company_cnt = mysql_num_rows( $companyrs );
	$totalAmount = 0.00;
	$NoofDealsCntTobeDeducted = 0;
	$totalResult  = 0;
	while( $result = mysql_fetch_array( $companyrs ) ) {
		if( $result[ 'AggHide' ] == 1 || $result[ 'SPV' ] == 1 ) {

		} else {
                    
                    if( $result[ 'hideamount' ] == 1 ) {
                        $hideAmount = true;
                    } else {
                        $hideAmount = false;
                    }
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
                        if( array_key_exists( $tgTrim, $tagsAmount ) ) {
                            
                           /* if( $hideAmount ) {
                                
                                if( array_key_exists( $tgTrim, $tagsHideCount) ) {
                                    
                                    $tagsHideCount[ $tgTrim ] = $tagsHideCount[ $tgTrim ] + 1;
                                }else{
                                    $tagsHideCount[ $tgTrim ] = 1;
                                }
                            }*/
                            $tagsAmount[ $tgTrim ] = $tagsAmount[ $tgTrim ] + $result[ 'amount' ];
                        } else {

                            /*if( $hideAmount ) {
                                
                                $tagsHideCount[ $tgTrim ] = 1;
                            }*/
                            $tagsAmount[ $tgTrim ] = $result[ 'amount' ];
                        }
                    }
		}
	}

	$totalAmount = round( $totalAmount );
	fputcsv($out, array( 'Tag', 'No.of Deals', 'Amount Invested($M)' ), ',', '"');
	foreach( $tags as $key => $tag ) {
            
            fputcsv($out, array( ucfirst( $key ), $tag[ 'count' ],  number_format($tag[ 'amount' ], 2) ), ',', '"');
           /* if($tagsHideCount[$key] > 1){
                
                fputcsv($out, array( ucfirst( $key ), $tag[ 'count' ],  number_format($tag[ 'amount' ], 2) ), ',', '"');
            }elseif($tagsHideCount[$key]==''){
                
                fputcsv($out, array( ucfirst( $key ), $tag[ 'count' ],  number_format($tag[ 'amount' ], 2) ), ',', '"');
            }else{
                
                 fputcsv($out, array( ucfirst( $key ), $tag[ 'count' ],  '--' ), ',', '"');
            }*/
		
	}
	fclose($out);
?>
