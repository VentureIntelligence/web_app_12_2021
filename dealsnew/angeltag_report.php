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
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";
        
    if($_SESSION['PE_industries']!=''){
            
        $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
    }
        
       $query =  "SELECT pe.AngelDealId,
            pe.InvesteeId,
            pe.AggHide,
            pec.PECompanyId, 
            pec.companyname, 
            pec.industry, 
            i.industry, 
            pec.tags,
            pec.sector_business as sector_business,
            DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,
            pe.Comment,
            pe.MoreInfor,
            pe.Dealdate as Dealdate, 
            GROUP_CONCAT( inv.Investor ORDER BY Investor='others' ) AS Investor 
            FROM angelinvdeals AS pe,
            industry AS i,    
            pecompanies AS pec,
            angel_investors as peinv_inv,
            peinvestors as inv
            WHERE 
            DealDate between '" . $dt1. "' and '" . $dt2 . "' and 
            pec.industry = i.industryid AND 
            pec.PEcompanyID = pe.InvesteeId AND 
            pe.Deleted =0 and 
            pec.industry !=15 and 
            peinv_inv.AngelDealId=pe.AngelDealId and 
     inv.InvestorId=peinv_inv.InvestorId $comp_industry_id_where
            GROUP BY pe.AngelDealId ";
                

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
            }else {
                
                if( $result[ 'hideamount' ] == 1 ) {
                        $hideAmount = true;
                } else {
                        $hideAmount = false;
                }
                $NoofDealsCntTobeDeducted = 0;

                $totalResult = $totalResult + 1 - $NoofDealsCntTobeDeducted;

                $tagsExplode = explode( ', ', $result[ 'tags' ] );
                $tagsExplode['companyid']=$result[ 'PECompanyId' ];
                      
                foreach( $tagsExplode as $tagExp ) {
                    
                    $tgExplode = explode( ':', $tagExp );
                    if( $tgExplode[ 0 ] == 'i' || $tgExplode[ 0 ] == 's' ) {
                        
                        $tgTrim = strtolower(trim( $tgExplode[ 1 ] ));

                        if( array_key_exists( $tgTrim, $tagsCount ) ) {

                            $tagsCount[ $tgTrim ] = $tagsCount[ $tgTrim ] + 1;
                        } else {

                            $tagsCount[ $tgTrim ] = 1;
                        }
                    }
                }
            }
	}
  	arsort( $tagsCount );
  	//arsort( $tagsAmount );
        //echo $aggcheckTotal;
        //echo $spvcheckTotal;
        //echo "aggsum".array_sum($aggTags);
        //echo "spvsum".array_sum($spvTags);
        
        
        //echo '<pre>'; print_r( $tagsCount ); echo '</pre>';
        //echo '<pre>'; print_r( $spvTags ); echo '</pre>';
        //echo '<pre>'; print_r( $aggTags ); echo '</pre>';
  	//echo '<pre>'; print_r( $tagsHideCount ); echo '</pre>';
	//$totalAmount = round( $totalAmount );
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
                <div class="overview-cnt mt-trend-tab">
                <div class="showhide-link-wrap"> 
                        <div class="showhide-link2" style="z-index: 100000;">
                                <a href="#" class="show_hide" rel="#tagTablelist"><i></i>Sector Trends<b class="betaversion">Beta</b><b href="javascript:;" class="lbl-action">Export</b></a>
                        </div>
                        <div id="tagTablelist" style="margin-top:10px;display:none;">
                        <div id="sec-header">
                            <label style="font-size:18px;font-weight:bold;">No. of Deals</label>
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
                                
                                    
                                $str .= '<li class="count_percent" title="' . $tag . ' Deal(s) ">';
                                   
                                 $str .= '<a href="javascript:;" data-name="' . $key . '">' . $key . ' - ' . number_format( $countPercent, 1 ) . '%</a>
                                </li>';
			}
			/*foreach( $tagsAmount as $key => $tag1 ) {
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
			}*/
			$str .= '</ul>
					</div>
    			</div> 
   			 </div>';
                         
   			 $str .='<form action="' . $actionlink1 . '" target="_blank" name="dummy" id="dummy"  method="post"></form>';
                       
                       $str .=' <form action="' . $actionlink1 . '" target="_blank" name="tagForm" id="tagForm"  method="post">
                           <form action="' . $actionlink1 . '" target="_blank" name="tagForm" id="tagForm"  method="post">
                            <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
                            <input type="hidden" value="' . $month1 . '" name="month1" />
                            <input type="hidden" value="' . $year1 . '" name="year1" />
                            <input type="hidden" value="' . $month2 . '" name="month2" />
                            <input type="hidden" value="' . $year2 . '" name="year2" />
                            <input type="hidden" value="1" name="tagsfield" id="tagsfield" />
                        </form>
                         <form action="exportangel_tags.php" method="post" name="export_tags" id="export_tags">
                                <input type="hidden" name="startDate" value=' . $dt1 . '>
				<input type="hidden" name="endDate" value=' . $dt2 .'>
                        </form> <div></div>';

       echo $str;
        }
?>
