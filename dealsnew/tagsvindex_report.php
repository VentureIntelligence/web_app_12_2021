<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	if(!isset($_SESSION['UserNames']))
    {
        header('Location:../pelogin.php');
    }
    else
    {
        if($vcflagValue==3)
        {
                $addVCFlagqry = " and pec.industry!=15 ";
                $dbtype="SV";
                $actionlink1="svindex.php?value=".$vcflagValue;
        }
        elseif($vcflagValue==4)
        {
                $addVCFlagqry = " and pec.industry!=15 ";
                $dbtype="CT";
                $actionlink1="svindex.php?value=".$vcflagValue;
        }
        elseif($vcflagValue==5)
        {
                $addVCFlagqry = " and pec.industry!=15 ";
                $dbtype="IF";
                $actionlink1="svindex.php?value=".$vcflagValue;
        }
        
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";
	
        if($_SESSION['PE_industries']!=''){
            
            $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';

        }
                    
        /*$query =  "SELECT distinct pe.PECompanyId as PECompanyId,
        pec.companyname, 
        pec.industry, 
        i.industry as industry,
        pec.tags,
        pec.sector_business as sector_business, 
        pe.amount, 
        pe.round, 
        s.Stage, 
        pe.stakepercentage, 
        DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , 
        pec.website, 
        pec.city, 
        pec.region, 
        pe.PEId, 
        pe.COMMENT,
        pe.MoreInfor,
        pe.hideamount,
        pe.hidestake,
        pe.StageId,
        pe.SPV,
        pe.AggHide,
        pe.dates as dates,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
        FROM peinvestments AS pe, 
        industry AS i, 
        pecompanies AS pec,
        stage as s, 
        peinvestments_investors as peinv_invs,
        peinvestors as invs 
        WHERE 
        dates between '" . $dt1. "' and '" . $dt2 . "'
        AND pec.industry = i.industryid 
        AND pec.PEcompanyID = pe.PECompanyID 
        and pe.StageId=s.StageId 
        AND invs.InvestorId=peinv_invs.InvestorId 
        and pe.PEId=peinv_invs.PEId 
        and pe.Deleted =0 
        and pec.industry !=15
        AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 )
        GROUP BY pe.PEId order by dates desc,companyname asc";*/
        
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
            pe.Deleted =0 " .$addVCFlagqry. " AND 
            peinv_inv.PEId=pe.PEId AND 
            inv.InvestorId=peinv_inv.InvestorId  $comp_industry_id_where
            GROUP BY pe.PEId ";

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
				.showhide-link2 .lbl-action {
					line-height: 30px;
				    margin-top: 5px;
				    background: #a2753a;
				    color: #fff;
				    text-transform: capitalize;
				    padding: 0px 10px;
				    float: right;
				    margin-right: 7px;
				}
				.showhide-link2 .betaversion {
					line-height: normal;
				    color: #fff;
				    text-transform: capitalize;
				    float: none;
    				margin: -12px 0 0 3px !important;
    				position: relative;
    				top: -10px;
				}
			</style>
			<div class="overview-cnt2 mt-trend-tab2">
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
			$str .= '</ul></div></div> </div>
                            <form></form>
   			 <form action="' . $actionlink1 . '" target="_blank" name="tagForm" id="tagForm"  method="post">
                             
                            <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
                            <input type="hidden" value="' . $month1 . '" name="month1" />
                            <input type="hidden" value="' . $year1 . '" name="year1" />
                            <input type="hidden" value="' . $month2 . '" name="month2" />
                            <input type="hidden" value="' . $year2 . '" name="year2" />
                            <input type="hidden" value="1" name="tagsfield" id="tagsfield" />
                        </form>
                        <form action="exportsv_tags.php" method="post" name="export_tags" id="export_tags">
                            <input type="hidden" name="startDate" value=' . $dt1 . '>
                            <input type="hidden" name="endDate" value=' . $dt2 .'>
                            <input type="hidden" name="dbtype" value=' . $dbtype .'>
                        </form>';

       echo $str;
        }
?>
