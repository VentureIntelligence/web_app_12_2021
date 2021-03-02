<?php
	require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
    {
        header('Location:../pelogin.php');
    }
    else
    {
	/*$query = "SELECT pec.tags, amount
  			 	FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
  			 	WHERE dates between '2018-1-01' and '2018-2-28' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0 and pec.industry !=15   AND pe.PEId NOT IN (
				     SELECT PEId
				     FROM peinvestments_dbtypes AS db
				     WHERE DBTypeId = 'SV'
				     AND hide_pevc_flag =1
				     )
				GROUP BY pe.PEId  order by  dates desc,companyname asc";*/
	if($vcflagValue=="0" || $vcflagValue=="1") {
	    $actionlink1="index.php?value=".$vcflagValue;
	} else if($vcflagValue=="4" || $vcflagValue=="5" || $vcflagValue=="3") {
	        $actionlink1="svindex.php?value=".$vcflagValue;
	} else if($vcflagValue=="6") {
	        $actionlink1="incindex.php";
	} else if($vcflagValue=="2") {
	     $actionlink1="angelindex.php";
	}
        
        if($vcflagValue=="1"){
            $vc = "and s.VCview=1 and pe.amount <=20 ";
        }
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";
        
         if($_SESSION['PE_industries']!=''){
            
            $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';

        }
	/*$query = "SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.tags,
					pec.sector_business as sector_business,amount,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
					pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.dates as dates,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
					(SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                        from peinvestments as pe, industry as i,pecompanies as pec,stage as s
                                          where                    
                                         dates between '" . $dt1 . "' and '" . $dt2 . "' and  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId  and
						pe.Deleted=0  and pec.industry !=15  
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  'SV'
                                                AND hide_pevc_flag =1
                                                )  GROUP BY pe.PEId order by  dates desc,companyname asc";*/
    /*$query = "SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.tags,
					pec.sector_business as sector_business,amount,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
					pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.dates as dates,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
					(SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                        from peinvestments as pe, industry as i,pecompanies as pec,stage as s
                                          where                    
                                         dates between '2017-2-01' and '2018-4-31' and  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId  and
						pe.Deleted=0  and pec.industry !=15
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  'SV'
                                                AND hide_pevc_flag =1
                                                )  GROUP BY pe.PEId order by  dates desc,companyname asc";*/
        // $query =  "SELECT distinct pe.PECompanyId as PECompanyId,
        // pec.companyname, 
        // pec.industry, 
        // i.industry as industry,
        // pec.tags,
        // pec.sector_business as sector_business, 
        // pe.amount, 
        // pe.round, 
        // s.Stage, 
        // pe.stakepercentage, 
        // DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , 
        // pec.website, 
        // pec.city, 
        // pec.region, 
        // pe.PEId, 
        // pe.COMMENT,
        // pe.MoreInfor,
        // pe.hideamount,
        // pe.hidestake,
        // pe.StageId,
        // pe.SPV,
        // pe.AggHide,
        // pe.dates as dates,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
        // FROM peinvestments AS pe, 
        // industry AS i, 
        // pecompanies AS pec,
        // stage as s, 
        // peinvestments_investors as peinv_invs,
        // peinvestors as invs 
        // WHERE 
        // dates between '" . $dt1. "' and '" . $dt2 . "'
        // AND pec.industry = i.industryid 
        // AND pec.PEcompanyID = pe.PECompanyID 
        // and pe.StageId=s.StageId 
        // AND invs.InvestorId=peinv_invs.InvestorId 
        // and pe.PEId=peinv_invs.PEId 
        // and pe.Deleted =0 
        // and pec.industry !=15 ".$vc."
        // AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) $comp_industry_id_where
        // GROUP BY pe.PEId order by dates desc,companyname asc";

        $query =  "SELECT distinct pe.PECompanyId as PECompanyId,pec.companyname,pec.industry,i.industry as industry,pec.tags,pec.sector_business as sector_business,pe.amount, 
        pe.round,s.Stage,pe.stakepercentage,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pec.website,pec.city, pec.region, pe.PEId, pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,
        pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
        FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
        JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
        JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
        JOIN industry AS i ON pec.industry = i.industryid
        JOIN stage AS s ON s.StageId=pe.StageId
        WHERE pe.dates between '" . $dt1. "' and '" . $dt2 . "'
        and pe.Deleted=0 AND pec.industry !=15 ".$vc."   
        AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1) $comp_industry_id_where
        GROUP BY pe.PEId order by  dates desc,companyname asc";

	$companyrs = mysql_query( $query ) or die( mysql_error() );
	$company_cnt = mysql_num_rows( $companyrs );
	$totalAmount = 0.00;
	$NoofDealsCntTobeDeducted = 0;
	$totalResult  = 0;
        $noresult = 0;
      // echo "dddddddddd".$company_cntall = mysql_num_rows($companyrs);
       
	while( $result = mysql_fetch_array( $companyrs ) ) {
            
            $tagsExplode = explode( ', ', $result[ 'tags' ] );
            foreach( $tagsExplode as $tagExp ) {
                $tgExplode = explode( ':', $tagExp );
                if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
                    $tgTrim = $tgExplode[ 1 ];
                    if( array_key_exists( $tgTrim, $totalTags ) ) {
                        $totalTags[ $tgTrim ] =  $totalTags[ $tgTrim ] + 1;
                    } else {
                        $totalTags[ $tgTrim ] =  1;
                    }
                }
            }
                        
		if( $result[ 'AggHide' ] == 1 ) {
                    $aggcheckTotal += 1; 
                        $tagsExplode = explode( ', ', $result[ 'tags' ] );
                        foreach( $tagsExplode as $tagExp ) {
                            $tgExplode = explode( ':', $tagExp );
                            if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
                                $tgTrim = strtolower(trim( $tgExplode[ 1 ] ));
                                if( array_key_exists( $tgTrim, $aggTags ) ) {
                                    $aggTags[ $tgTrim ] =  $aggTags[ $tgTrim ] + 1;
                                } else {
                                    $aggTags[ $tgTrim ] =  1;
                                }
                            }
                        }
                
			/*$NoofDealsCntTobeDeducted = 1;
			$amtTobeDeductedforAggHide = $result["amount"];*/
		} else if( $result[ 'SPV' ] == 1 ) {
                    $spvcheckTotal += 1;
                        $tagsExplode = explode( ', ', $result[ 'tags' ] );
                        foreach( $tagsExplode as $tagExp ) {
                            $tgExplode = explode( ':', $tagExp );
                            if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
                                $tgTrim = strtolower(trim( $tgExplode[ 1 ] ));
                                if( array_key_exists( $tgTrim, $spvTags ) ) {
                                    $spvTags[ $tgTrim ] =  $spvTags[ $tgTrim ] + 1;
                                } else {
                                    $spvTags[ $tgTrim ] =  1;
                                }
                            }
                        }
                
			/*$NoofDealsCntTobeDeducted = 1;
			$amtTobeDeductedforAggHide = $result["amount"];*/
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
                        //$tagsExplode['companyid']=$result[ 'PECompanyId' ];
//                        echo '<pre>';
//                        print_r($tagsExplode);
//                        echo '</pre>';
			foreach( $tagsExplode as $tagExp ) {
				$tgExplode = explode( ':', $tagExp );
				if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
					$tgTrim = strtolower(trim( $tgExplode[ 1 ] ));
					if( array_key_exists( $tgTrim, $tagsCount ) ) {
						/*$tags[ $tgTrim ][ 'count' ] = $tags[ $tgTrim ][ 'count' ] + 1;
						$tags[ $tgTrim ][ 'amount' ] = $tags[ $tgTrim ][ 'amount' ] + $result[ 'amount' ];*/
						$tagsCount[ $tgTrim ] = $tagsCount[ $tgTrim ] + 1;
					} else {
						/*$tags[ $tgTrim ][ 'count' ] = 1;
						$tags[ $tgTrim ][ 'amount' ] = $result[ 'amount' ];*/
						$tagsCount[ $tgTrim ] = 1;
					}
					if( array_key_exists( $tgTrim, $tagsAmount ) ) {
                                            if( $hideAmount ) {
                                                if( array_key_exists( $tgTrim, $tagsHideCount) ) {
                                                        $tagsHideCount[ $tgTrim ] = $tagsHideCount[ $tgTrim ] + 1;
                                                }else{
                                                        $tagsHideCount[ $tgTrim ] = 1;
                                                }
                                            }
                                            $tagsAmount[ $tgTrim ] = $tagsAmount[ $tgTrim ] + $result[ 'amount' ];
					} else {
                                            
                                            if( $hideAmount ) {
                                                    $tagsHideCount[ $tgTrim ] = 1;
                                            }
                                            $tagsAmount[ $tgTrim ] = $result[ 'amount' ];
					}
				}
			}
		}
	}
  	arsort( $tagsCount );
  	arsort( $tagsAmount );
        //echo $aggcheckTotal;
        //echo $spvcheckTotal;
        //echo "aggsum".array_sum($aggTags);
        //echo "spvsum".array_sum($spvTags);
        
        
        //echo '<pre>'; print_r( $totalTags ); echo '</pre>';
        //echo '<pre>'; print_r( $spvTags ); echo '</pre>';
        //echo '<pre>'; print_r( $aggTags ); echo '</pre>';
  	//echo '<pre>'; print_r( $tagsHideCount ); echo '</pre>';
	$totalAmount = round( $totalAmount );
	$str = '<style>
				ul.taglist_1 li {
				    display: inline-block;
				}
				ul.taglist_1 li a {
					border: 1px solid #cb9929;
				    border-radius: 5px;
				    box-shadow: 0px 0px 2px #e1c586;
				    padding: 10px;
				    margin: 0px 10px 10px 0px;
				    display: block;
				    text-decoration: none;
				    font-size:13px;
				    text-transform: capitalize;
				}
				ul.taglist_1 li a:hover {
					border: 1px solid #41352a;
				}
				.showhide-link .lbl-action {
					line-height: 30px;
				    margin-top: 5px;
				    background: #a2753a;
				    color: #fff;
				    text-transform: capitalize;
				    padding: 0px 10px;
				    float: right;
				    margin-right: 7px;
				}
				.showhide-link .betaversion {
					line-height: normal;
				    color: #fff;
				    text-transform: capitalize;
				    float: none;
    				margin: -12px 0 0 3px !important;
    				position: relative;
    				top: -10px;
				}
			</style>
			<div class="overview-cnt mt-trend-tab2">
        		<div class="showhide-link-wrap"> 
        			<div class="showhide-link2" style="z-index: 100000;">
        				<a href="#" class="show_hide" rel="#tagTablelist"><i></i>Sector Trends<b class="betaversion">Beta</b><b href="javascript:;" class="lbl-action">Export</b></a>
        			</div>
        			<div id="tagTablelist" style="margin-top:10px;display:none">
        			<div id="sec-header">
        				<table cellpadding="0" cellspacing="0" style="height: auto;">
				 			<tbody>
					 			<tr>
									<td>
		                                <label><input class="typeoff-tagnva2" name="tag_show" type="radio"  value="1" checked>No. of Deals</label>
		                                <label><input class="typeoff-tagnva2" name="tag_show" type="radio"  value="2">Amount Invested</label>
									</td>
		                        </tr>
					    	</tbody>
					    </table>
        			</div>
          			<ul class="taglist_1">';
			/*foreach( $tags as $key => $tag ) {
				$countPercent = ($tag[ 'count' ]/$totalResult)*100;
				//$tags[ $key ][ 'count' ] = array( $tag[ 'count' ], $countPercent );
				$amountPercent = (round($tag[ 'amount' ])/$totalAmount)*100;
				//$tags[ $key ][ 'amount' ] = array( $tag[ 'amount' ], $amountPercent );
				$str .= '<li class="count_percent" title="' . $tag[ 'count' ] . ' deals worth ' . round($tag[ 'amount' ]) . ' $M">
							<a href="javascript:;" data-name="' . $key . '">' . $key . ' - ' . number_format( $countPercent, 2 ) . '%</a>
						</li>
						<li class="amount_percent" style="display: none;" title="' . $tag[ 'count' ] . ' deals worth ' . round($tag[ 'amount' ]) . ' $M">
							<a href="javascript:;" data-name="' . $key . '">' . $key . ' - ' . number_format( $amountPercent, 2 ) . '%</a>
						</li>';
			}*/
			foreach( $tagsCount as $key => $tag ) {
				$countPercent = ($tag/$totalResult)*100;
				$dealAmount = round( $tagsAmount[ $key ] );
                                
                                
                                if($tagsHideCount[$key] > 1){
                                    
                                    $str .= '<li class="count_percent" title="' . $tag . ' Deal(s) worth $' . number_format( $dealAmount ) . ' M">';
                                }elseif($tagsHideCount[$key]==''){
                                    
                                     $str .= '<li class="count_percent" title="' . $tag . ' Deal(s) worth $' . number_format( $dealAmount ) . ' M">';
                                    
                                }else{
                                    
                                    $str .= '<li class="count_percent" title="' . $tag . ' Deal(s) worth -- ">';
                                }   
                                 $str .= '<a href="javascript:;" data-name="' . $key . '">' . $key . ' - ' . number_format( $countPercent, 1 ) . '%</a>
                                </li>';
			}
			foreach( $tagsAmount as $key => $tag1 ) {
				$amountPercent = (round($tag1)/$totalAmount)*100;
                                if($tagsHideCount[$key] > 1){
                                    $str .= '<li class="amount_percent" style="display: none;" title="' . $tagsCount[ $key ] . ' Deal(s) worth $' . number_format( round( $tag1 ) ) . ' M">
                                                <a href="javascript:;" data-name="' . $key . '">' . $key . ' - ' . number_format( $amountPercent, 1 ) . '%</a>
                                            </li>';
                                }elseif($tagsHideCount[$key]==''){
                                    
                                     $str .= '<li class="amount_percent" style="display: none;" title="' . $tagsCount[ $key ] . ' Deal(s) worth $' . number_format( round( $tag1 ) ) . ' M">
                                                <a href="javascript:;" data-name="' . $key . '">' . $key . ' - ' . number_format( $amountPercent, 1 ) . '%</a>
                                            </li>';
                                    
                                }else{
                                    $str .= '<li class="amount_percent" style="display: none;" title="' . $tagsCount[ $key ] . ' Deal(s) worth --">
                                                <a href="javascript:;" data-name="' . $key . '">' . $key . ' - </a>
                                            </li>';
                                }
			}
			$str .= '</ul>
					</div>
    			</div> 
   			 </div>
                         </form>
   			 <form action="' . $actionlink1 . '" target="_blank" name="tagForm" id="tagForm"  method="post">
                             
                            <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
                            <input type="hidden" value="' . $month1 . '" name="month1" />
                            <input type="hidden" value="' . $year1 . '" name="year1" />
                            <input type="hidden" value="' . $month2 . '" name="month2" />
                            <input type="hidden" value="' . $year2 . '" name="year2" />
                                
                            <input type="hidden" value="1" name="tagsfield" id="tagsfield" />
                          </form>
                        <form action="export_tags.php" method="post" name="export_tags" id="export_tags">
                                <input type="hidden" name="startDate" value=' . $dt1 . '>
				<input type="hidden" name="endDate" value=' . $dt2 .'>
                                <input type="hidden" value="' . $vcflagValue . '" name="vcflagValue" />
                        </form>';

       echo $str;
        }
?>
