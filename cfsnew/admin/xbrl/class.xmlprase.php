<?php
/**
 * Class XmlFetch
 *
 * Parameter cin used for log table updated if any validations condition failed.
 * Parameter plArray used for plstandard conetxt reference, This context reference is cross checked with the XML field contect reference to fetch the corresponding data.
 * Parameter bsArray used for bs conetxt reference, This context reference is cross checked with the XML field contect reference to fetch the corresponding data.
 * For pl and bs some XML fileds are looped separately since number of occurrence is multiple times from which data cannot be fetched.
 *
 * 
 * Functions used xbrlNewFormatStandalone, xbrlNewFormatConsolidated, xbrlOldFormatStandalone, xbrlOldFormatConsolidated
 *
 * 
 * @author     Jagdeesh MV <jagadeesh@kutung.in>
 * @version    1.0
 * @created    20-07-2018
 */

class XmlFetch {
	
	function __construct() {
		# code...
	}

	/*
		NEW format standalone xml data fetching from the given XML field.
		Validation rules are applied.
		Returns: Data of both PL and BS in data key, Error data and error count is returned.
	*/
	public function xbrlNewFormatStandalone( $xbrlData = '', $fyYear = '', $cin = '', $plArray = '', $bsArray = '',$cfArray='' ) {
		global $logs;
		global $xbrl2;
		global $Insert_XBRL2;

		$xmlParseData = array();
		$i = 0;

		$isCSRExpenditure = false;
		$isCostOfMaterialsConsumed = false;
		$isExpenses = false;
		$isOtherExpenses = false;
		$isNextkey = '';
		
		foreach($xbrlData as $key=>$val) {
			
			if($key == 'MiscellaneousExpenses' && $isNextkey != ''){
				$isCSRExpenditure = false;
			} else {
				$isNextkey = '';
			}

			// if($key == 'CostOfMaterialsConsumed'){
			// 	$isCostOfMaterialsConsumed = true;
			// } 

			// if(($key == 'Expenses' || $key == 'OtherExpenses') && $isCostOfMaterialsConsumed == true){
				
			// 	if($key == 'Expenses') {
			// 		$isExpenses = true;
			// 	} else if($key == 'OtherExpenses'){
			// 		$isOtherExpenses = true;
			// 	}
			// }

			if($key == 'CSRExpenditure'){
			//if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && ($isExpenses == false || $isOtherExpenses == false)){
				$isCSRExpenditure = true;
				$isNextkey = 'MiscellaneousExpenses';
			}
		}

		/*foreach($xbrlData as $key=>$val) {
			
			if($key == 'CostOfMaterialsConsumed'){
				$isCostOfMaterialsConsumed = true;
				continue;
			} 
			
			if($key == 'Expenses' && $isCostOfMaterialsConsumed == true){
				$isExpenses = true;
				continue;
			} 
			
			if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && $isExpenses == false){
				$isCSRExpenditure = true;
				continue;
			}
		}*/

		$loopCount = $addval = count( $xbrlData[ 'RevenueFromOperations' ] );
		$bsloopCount = $addval = count( $xbrlData[ 'OtherEquity' ] );
		$cfloopCount = $addval = count( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ] );
		$dilutedCont = $basicCont = 4;
		$errorArray = array();
		$errorReport = 0;
		$addArray = array();
		$bsAddArray = array();
		$cfAddArray = array();
		$isXBRL2 = false;
		foreach( $fyYear as $fy ) { // Looping throught the FY years identified from the XML. Data push to corresponding FY.
			if( isset( $xbrlData[ 'RevenueFromOperations' ] ) || isset( $xbrlData[ 'EquityShareCapital' ] ) ) {
				// XML support condition check with the XML field exists or not.
				if( !in_array( $xbrlData[ 'RevenueFromOperations' ][ $i ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) && !empty( $xbrlData[ 'RevenueFromOperations' ][ $i ][ '_attributes:' ][ '_value:' ] ) ) {
					$logs->logWrite( "FY".$fy . " - Error Xml not supported", true );
					$errorArray[ $cin ]['common'][$fy][] = "FY".$fy . " - Error Xml not supported";
					$errorReport++;
					return array( 'data' => array(), 'error' => $errorReport, 'error_array' => $errorArray  );
				} else {
					$errorReport = $errorReport;
				}
			}
			// PL DATA STARTS
			$operationalIncome = $otherIncome = $totalIncomeCheck = $totalIncome = $expenses = $interest = $depreciation = $operationalAdminOtherExpenses = $operatingProfit = $EBITDA = $EBDT = $EBTbeforeExceptionalItems = $priorPeriodExceptionalExtraOrdinaryItems = $EBT = $tax = $EmployeeRelatedExpenses = $CostOfMaterialsConsumed = $PurchasesOfStockInTrade = $ChangesInInventories = $CSRExpenditure = $OtherExpenses = $CurrentTax = $DeferredTax = $PAT = $basicInINR = $dilutedInINR = $EBTbeforeExceptionalItemsCheck = $PATCheck = $earningForeignExchange = $outgoForeignExchange = 0;

			// MI5-T384
			$ExpenditureOnProduction = 0;

			/*
				Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
				Given XML field isset condition checked and PL Context array condition is checked.
			*/
			for( $loopInc = 0; $loopInc < $loopCount; $loopInc++ ) {
				if( isset( $xbrlData[ 'RevenueFromOperations' ] ) ) { // XML Field RevenueFromOperations - PL NS
					if( in_array( $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$operationalIncome = $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_value:' ];
						if( !$addArray[ $fy ] ) {
							$addArray[ $fy ] = true;	
						}
					} else {
						if( !$addArray[ $fy ] ) {
							$addArray[ $fy ] = false;
						}
					}
				}
				if( isset( $xbrlData[ 'OtherIncome' ] ) ) { // XML Field OtherIncome - PL NS
					if( in_array( $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$otherIncome = $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_value:' ];
					}
				}
				$totalIncomeCheck = $operationalIncome + $otherIncome;
				if( isset( $xbrlData[ 'Income' ] ) ) { // XML Field Income - PL NS
					if( in_array( $xbrlData[ 'Income' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$totalIncome = $xbrlData[ 'Income' ][ $loopInc ][ '_value:' ];
					}
				}
				
				if( isset( $xbrlData[ 'Expenses' ] ) ) { // XML Field Expenses - PL NS
					if( in_array( $xbrlData[ 'Expenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$expenses = $xbrlData[ 'Expenses' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'FinanceCosts' ] ) ) { // XML Field FinanceCosts - PL NS
					if( in_array( $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$interest = $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ] ) ) { // XML Field DepreciationDepletionAndAmortisationExpense - PL NS
					if( in_array( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$depreciation = $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_value:' ];
					}
				}
				if( !empty( $interest ) || !empty( $depreciation ) || !empty( $expenses ) ) {
					if( empty( $interest ) ) {
						$interest = 0;
					}
					if( empty( $depreciation ) ) {
						$depreciation = 0;
					}
					$operationalAdminOtherExpenses = $expenses - $interest - $depreciation;
				}
				if( !empty( $operationalIncome ) || ( !empty( $operationalAdminOtherExpenses ) ) ) {
					$operatingProfit = $operationalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $totalIncome ) || !empty( $operationalAdminOtherExpenses ) ) {
					$EBITDA = $totalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $EBITDA ) || !empty( $interest ) ) {
					$EBDT = $EBITDA - $interest;
				}
				if( isset( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ] ) ) { // XML Field ProfitBeforeExceptionalItemsAndTax - PL NS
					if( in_array( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$EBTbeforeExceptionalItems = $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ProfitBeforeTax' ] ) ) { // XML Field ProfitBeforeTax - PL NS
					if( in_array( $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$EBT = $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TaxExpense' ] ) ) { // XML Field TaxExpense - PL NS
					if( in_array( $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$tax = $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'EmployeeBenefitExpense' ] ) ) { // XML Field EmployeeBenefitExpense - PL NS
					if( in_array( $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$EmployeeRelatedExpenses = $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_value:' ];
					}
				}
				
				if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) ) { // XML Field CostOfMaterialsConsumed - PL NS
					if( in_array( $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$CostOfMaterialsConsumed = $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) ) { // XML Field PurchasesOfStockInTrade - PL NS
					if( in_array( $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$PurchasesOfStockInTrade = $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) ) { // XML Field ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade - PL NS
					if( in_array( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$ChangesInInventories = $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CSRExpenditure' ] ) && $isCSRExpenditure == true ) { // XML Field CSRExpenditure - PL NS
					if( in_array( $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$CSRExpenditure = $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherExpenses' ] ) ) { // XML Field OtherExpenses - PL NS
					if( in_array( $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$OtherExpenses = $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_value:' ];
					}
				}

				if( isset( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ] ) ) { // XML Field OtherExpenses - PL OS
						if( in_array( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ExpenditureOnProduction = $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_value:' ];
						}
					}
				if( isset( $xbrlData[ 'CurrentTax' ] ) ) { // XML Field CurrentTax - PL NS
					if( in_array( $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$CurrentTax = $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredTax' ] ) ) { // XML Field DeferredTax - PL NS
					if( in_array( $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$DeferredTax = $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_value:' ];
					}
				}

				if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) || isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) || 
					isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) || 
					isset( $xbrlData[ 'CSRExpenditure' ] ) || isset( $xbrlData[ 'OtherExpenses' ] ) || 
					isset( $xbrlData[ 'DeferredTax' ] ) || isset( $xbrlData[ 'CurrentTax' ] )) {
						$isXBRL2 = true;

				} else {
					$isXBRL2 = false;
				}
			}
			for( $profitLoassInc = 0; $profitLoassInc < count( $xbrlData[ 'ProfitLossForPeriod' ] ); $profitLoassInc++ ) {
				if( isset( $xbrlData[ 'ProfitLossForPeriod' ] ) ) { // XML Field ProfitLossForPeriod - PL NS
					if( in_array( $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ] ) ) {
							$PAT = $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $basicInc = 0; $basicInc < count( $xbrlData[ 'BasicEarningsLossPerShare' ] ); $basicInc++ ) {
				$newConttext = 'CONTXT_ID_'.$basicCont.'_D';
				$newConttext1 = 'CONTXT_ID_'.$basicCont.'_I';
				if( isset( $xbrlData[ 'BasicEarningsLossPerShare' ] ) ) { // XML Field BasicEarningsLossPerShare - PL NS
					if( in_array( $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ] ) ) {
							$basicInINR = $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_value:' ];
							break;
						}
					} else {
						$contextRef = explode("_",$xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ]);
						if(in_array($contextRef[0], $plArray[ $fy ])) {
							if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ] ) ) {
								$basicInINR = $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_value:' ];
								break;
							}
						}
					}
				}
			}
			for( $dilutedInc = 0; $dilutedInc < count( $xbrlData[ 'DilutedEarningsLossPerShare' ] ); $dilutedInc++ ) {
				$newConttext = 'CONTXT_ID_'.$dilutedCont.'_D';
				$newConttext1 = 'CONTXT_ID_'.$dilutedCont.'_I';
				if( isset( $xbrlData[ 'DilutedEarningsLossPerShare' ] ) ) { // XML Field DilutedEarningsLossPerShare - PL NS
					if( in_array( $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ] ) ) {
							if( !empty( $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ] ) ) {
								$dilutedInINR = $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ];
								break;
							}
						}
					} else {
						$contextRef = explode("_",$xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ]);
						if(in_array($contextRef[0], $plArray[ $fy ])) {
							if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ] ) ) {
								if( !empty( $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ] ) ) {
									$dilutedInINR = $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
			}
			if( empty( $dilutedInINR ) ) {
				$dilutedInINR = $basicInINR;
			}
			// Validation given in google sheet is added.
			if( $totalIncome != $totalIncomeCheck ) {
				$operationalIncome = $totalIncome - $otherIncome;
			}
			$priorPeriodExceptionalExtraOrdinaryItems = $EBTbeforeExceptionalItems - $EBT;
			$OtherExpenses = $OtherExpenses + $ExpenditureOnProduction;

			/*if( ( $PAT < 0 && ( $basicInINR >= 0 || $dilutedInINR >= 0 ) ) || ( $PAT >= 0 && ( $basicInINR < 0 || $dilutedInINR < 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) ) {
				$logs->logWrite( $fy . " - PAT, EPS mismatch" );
				$errorArray[ $cin ]['pl'][$fy][] = $fy . " - PAT, EPS mismatch";
				$errorReport++;
			}*/ // VI team asked to hide this condition.

			if( $EBITDA < $EBDT || $EBDT < $EBTbeforeExceptionalItems ) {
				$errorArray[ $cin ]['pl'][$fy][] = "FY".$fy . " - EBITDA, EBDT, EBT mismatch";
				$errorReport++;
			}
			$Insert_XBRL2['isXBRL'] = $isXBRL2;
			if( $addArray[ $fy ] ) {
			// XML parsed data assigned to variable which will be sent to excel file generation.
			/*if( !empty( $operationalIncome ) && !empty( $otherIncome ) && !empty( $totalIncome ) ) {*/
				$xmlParseData[ 'pl' ][ $fy ][ 'Operational Income' ] = $operationalIncome;
				$xmlParseData[ 'pl' ][ $fy ][ 'Other Income' ] = $otherIncome;
				$xmlParseData[ 'pl' ][ $fy ][ 'Total Income' ] = $totalIncome;
				$xmlParseData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ] = $CostOfMaterialsConsumed;
				$xmlParseData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ] = $PurchasesOfStockInTrade;
				$xmlParseData[ 'pl' ][ $fy ][ 'Changes In Inventories' ] = $ChangesInInventories;
				$xmlParseData[ 'pl' ][ $fy ][ 'CSR Expenditure' ] = $CSRExpenditure;
				$xmlParseData[ 'pl' ][ $fy ][ 'Other Expenses' ] = $OtherExpenses;
				$xmlParseData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ] = $operationalAdminOtherExpenses;
				$xmlParseData[ 'pl' ][ $fy ][ 'Operating Profit' ] = $operatingProfit;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBITDA' ] = $EBITDA;
				$xmlParseData[ 'pl' ][ $fy ][ 'Interest' ] = $interest;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBDT' ] = $EBDT;
				$xmlParseData[ 'pl' ][ $fy ][ 'Depreciation' ] = $depreciation;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ] = $EBTbeforeExceptionalItems;
				$xmlParseData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ] = $priorPeriodExceptionalExtraOrdinaryItems;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBT' ] = $EBT;
				$xmlParseData[ 'pl' ][ $fy ][ 'Tax' ] = $tax;
				$xmlParseData[ 'pl' ][ $fy ][ 'PAT' ] = $PAT;
				$xmlParseData[ 'pl' ][ $fy ][ 'CurrentTax' ] = $CurrentTax;
				$xmlParseData[ 'pl' ][ $fy ][ 'DeferredTax' ] = $DeferredTax;
				$xmlParseData[ 'pl' ][ $fy ][ '(Basic in INR)' ] = $basicInINR;
				$xmlParseData[ 'pl' ][ $fy ][ '(Diluted in INR)' ] = $dilutedInINR;
				$xmlParseData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ] = $EmployeeRelatedExpenses;
				$xmlParseData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ] = $earningForeignExchange;
				$xmlParseData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ] = $outgoForeignExchange;
				foreach( $errorArray[ $cin ]['pl'][$fy] as $pltext ) {
					$logs->logWrite( $pltext, true );
				}
			} else {
				// Unset the FY data if condition failed. remove curresponding FY error data.
				unset( $xmlParseData[ 'pl' ][ $fy ] );
				$errorReport = $errorReport - count( $errorArray[ $cin ]['pl'][$fy] );
				unset( $errorArray[ $cin ]['pl'][$fy] );
			}
			// PL DATA ENDS

			//BS DATA STARTS
			$ShareCapital = $ReservesandSurplus = $TotalShareholdersFunds = $ShareApplicationMoney = $MinorityInterest = $LongtermBorrowings = $DeferredTaxLiabilities = $otherNonCurrentLiabilities = $nonCurrentLiabilities = $LongTermProvisions = $TotalNonCurrentLiabilitiesCheck = $OtherLongTermLiabilities = $NonCurrentLiabilities = $ShortTermBorrowings = $TradePayable = $OtherCurrFinancialLiabilities = $OtherCurrLiabilities = $CurrentTaxLiabilities = $OtherCurrentLiabilities = $ShortTermProvisions = $TotalCurrentLiabilitiesCheck = $TotalCurrentLiabilities = $TotalEquityAndLiabilitiesCheck = $CapitalWorkInProgress = $InvestmentProperty = $Goodwill = $LongTermLoansAdvances = $OtherNonCurrentAssets = $TotalNonCurrentAssets = $TradeReceivables = $CashAndCashBalances = $BankCashAndCashBalances = $CashandBankBalances = $ShortTermLoansAdvances = $OtherCurrentFinancialAssets = $CurrentTaxAssets = $OtherCurrAssets = $OtherCurrentAssets = $TotalCurrentAssets = $TotalAssets = $PropertyPlantAndEquipment = $OtherIntangibleAssets = $NoncurrentInvestments = $CurrentInvestments = $Inventories = $DeferredTaxAssets = $TangibleAssets = $IntangibleAssets = $TotalFixedAssets = $TotalNonCurrentAssetsCheck = $TotalNonCurrentAssets = $TotalCurrentAssetsCheck = $TotalAssetsCheck = $TangibleAssetsCapitalWorkInProgress = $DeferredGovernmentGrantsCurrent = $LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale = $TradePayablesNoncurrent = $DeferredGovernmentGrantsNoncurrent = $IntangibleAssetsUnderDevelopmentOrWorkInProgress = $TradeReceivablesNoncurrent = $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $CurrentLiabilities = $NonCurrentAssets = $InvestmentsAccountedForUsingEquityMethod = $MoneyReceivedAgainstShareWarrants = $BiologicalAssetsOtherThanBearerPlants = 0;
			// Updated on 21-05-2019 for MI5-T224
			$OtherNonCurrAssets = $OtherNonCurrentFinancialAssets = $TotalEquityAndLiabilities = $NoncurrentAssetsClassifiedAsHeldForSale = 0;
			/*
				Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
				Given XML field isset condition checked and BS Context array condition is checked.
			*/
			for( $equityshareInc = 0; $equityshareInc < count( $xbrlData[ 'EquityShareCapital' ] ); $equityshareInc++ ) {
				if( isset( $xbrlData[ 'EquityShareCapital' ] ) ) { // XML Field EquityShareCapital - BS NS
					if( in_array( $xbrlData[ 'EquityShareCapital' ][ $equityshareInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'EquityShareCapital' ][ $equityshareInc ] ) ) {
							$ShareCapital = $xbrlData[ 'EquityShareCapital' ][ $equityshareInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $bsloopInc = 0; $bsloopInc < $bsloopCount; $bsloopInc++ ) {
				if( isset( $xbrlData[ 'OtherEquity' ] ) ) { // XML Field OtherEquity - BS NS
					if( in_array( $xbrlData[ 'OtherEquity' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ReservesandSurplus = $xbrlData[ 'OtherEquity' ][ $bsloopInc ][ '_value:' ];
						if( !$bsAddArray[ $fy ] ) {
							$bsAddArray[ $fy ] = true;	
						}
					} else {
						if( !$bsAddArray[ $fy ] ) {
							$bsAddArray[ $fy ] = false;	
						}
					}
				}
				if( isset( $xbrlData[ 'Equity' ] ) ) { // XML Field Equity - BS NS
					if( in_array( $xbrlData[ 'Equity' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalShareholdersFunds = $xbrlData[ 'Equity' ][ $bsloopInc ][ '_value:' ];
					}
				}
				
				if( isset( $xbrlData[ 'BorrowingsNoncurrent' ] ) ) { // XML Field BorrowingsNoncurrent - BS NS
					if( in_array( $xbrlData[ 'BorrowingsNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LongtermBorrowings = $xbrlData[ 'BorrowingsNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredTaxLiabilitiesNet' ] ) ) { // XML Field DeferredTaxLiabilitiesNet - BS NS
					if( in_array( $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$DeferredTaxLiabilities = $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentLiabilities' ] ) ) { // XML Field OtherNoncurrentLiabilities - BS NS
					if( in_array( $xbrlData[ 'OtherNoncurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$otherNonCurrentLiabilities = $xbrlData[ 'OtherNoncurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentFinancialLiabilities' ] ) ) { // XML Field OtherNoncurrentFinancialLiabilities - BS NS
					if( in_array( $xbrlData[ 'OtherNoncurrentFinancialLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$othernonCurrfinancialLiabilities = $xbrlData[ 'OtherNoncurrentFinancialLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TradePayablesNoncurrent' ] ) ) { // XML Field TradePayablesNoncurrent - BS NS
					if( in_array( $xbrlData[ 'TradePayablesNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TradePayablesNoncurrent = $xbrlData[ 'TradePayablesNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ] ) ) { // XML Field DeferredGovernmentGrantsNoncurrent - BS NS
					if( in_array( $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$DeferredGovernmentGrantsNoncurrent = $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				$ShareApplicationMoney = 0;
				if( isset( $xbrlData[ 'ProvisionsNoncurrent' ] ) ) { // XML Field ProvisionsNoncurrent - BS NS
					if( in_array( $xbrlData[ 'ProvisionsNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LongTermProvisions = $xbrlData[ 'ProvisionsNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'NoncurrentLiabilities' ] ) ) { // XML Field NoncurrentLiabilities - BS NS
					if( in_array( $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$NonCurrentLiabilities = $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'BorrowingsCurrent' ] ) ) { // XML Field BorrowingsCurrent - BS NS
					if( in_array( $xbrlData[ 'BorrowingsCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ShortTermBorrowings = $xbrlData[ 'BorrowingsCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TradePayablesCurrent' ] ) ) { // XML Field TradePayablesCurrent - BS NS
					if( in_array( $xbrlData[ 'TradePayablesCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TradePayable = $xbrlData[ 'TradePayablesCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentFinancialLiabilities' ] ) ) { // XML Field OtherCurrentFinancialLiabilities - BS NS
					if( in_array( $xbrlData[ 'OtherCurrentFinancialLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrFinancialLiabilities = $xbrlData[ 'OtherCurrentFinancialLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentLiabilities' ] ) ) { // XML Field DilutedEarningsLossPerShare - BS NS
					if( in_array( $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrLiabilities = $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentTaxLiabilities' ] ) ) { // XML Field CurrentTaxLiabilities - BS NS
					if( in_array( $xbrlData[ 'CurrentTaxLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CurrentTaxLiabilities = $xbrlData[ 'CurrentTaxLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredGovernmentGrantsCurrent' ] ) ) { // XML Field DeferredGovernmentGrantsCurrent - BS NS
					if( in_array( $xbrlData[ 'DeferredGovernmentGrantsCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$DeferredGovernmentGrantsCurrent = $xbrlData[ 'DeferredGovernmentGrantsCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ProvisionsCurrent' ] ) ) { // XML Field ProvisionsCurrent - BS NS
					if( in_array( $xbrlData[ 'ProvisionsCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ProvisionsCurrent = $xbrlData[ 'ProvisionsCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ] ) ) { // XML Field ProvisionsCurrent - BS NS
					if( in_array( $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale = $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentLiabilities' ] ) ) { // XML Field CurrentLiabilities - BS NS
					if( in_array( $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CurrentLiabilities = $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'EquityAndLiabilities' ] ) ) { // XML Field EquityAndLiabilities - BS NS
					if( in_array( $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalEquityAndLiabilities = $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CapitalWorkInProgress' ] ) ) { // XML Field CapitalWorkInProgress - BS NS
					if( in_array( $xbrlData[ 'CapitalWorkInProgress' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CapitalWorkInProgress = $xbrlData[ 'CapitalWorkInProgress' ][ $bsloopInc ][ '_value:' ];
					}
				}
				/*if( isset( $xbrlData[ 'Goodwill' ] ) ) { // XML Field Goodwill - BS NS
					if( in_array( $xbrlData[ 'Goodwill' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$Goodwill = $xbrlData[ 'Goodwill' ][ $bsloopInc ][ '_value:' ];
					}
				}*/
				if( isset( $xbrlData[ 'IntangibleAssetsUnderDevelopment' ] ) ) { // XML Field IntangibleAssetsUnderDevelopment - BS NS
					if( in_array( $xbrlData[ 'IntangibleAssetsUnderDevelopment' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$IntangibleAssetsUnderDevelopment = $xbrlData[ 'IntangibleAssetsUnderDevelopment' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'LoansNoncurrent' ] ) ) { // XML Field LoansNoncurrent - BS NS
					if( in_array( $xbrlData[ 'LoansNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LongTermLoansAdvances = $xbrlData[ 'LoansNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentFinancialAssets' ] ) ) { // XML Field OtherNoncurrentFinancialAssets - BS NS
					if( in_array( $xbrlData[ 'OtherNoncurrentFinancialAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherNonCurrentFinancialAssets = $xbrlData[ 'OtherNoncurrentFinancialAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentAssets' ] ) ) { // XML Field OtherNoncurrentAssets - BS NS
					if( in_array( $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherNonCurrAssets = $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'NoncurrentAssetsClassifiedAsHeldForSale' ] ) ) { // XML Field NoncurrentAssetsClassifiedAsHeldForSale - BS NS
					if( in_array( $xbrlData[ 'NoncurrentAssetsClassifiedAsHeldForSale' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$NoncurrentAssetsClassifiedAsHeldForSale = $xbrlData[ 'NoncurrentAssetsClassifiedAsHeldForSale' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'NoncurrentAssets' ] ) ) { // XML Field NoncurrentAssets - BS NS
					if( in_array( $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$NonCurrentAssets = $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TradeReceivablesCurrent' ] ) ) { // XML Field TradeReceivablesCurrent - BS NS
					if( in_array( $xbrlData[ 'TradeReceivablesCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TradeReceivables = $xbrlData[ 'TradeReceivablesCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CashAndCashEquivalents' ] ) ) { // XML Field CashAndCashEquivalents - BS NS
					if( in_array( $xbrlData[ 'CashAndCashEquivalents' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CashAndCashBalances = $xbrlData[ 'CashAndCashEquivalents' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'BankBalanceOtherThanCashAndCashEquivalents' ] ) ) { // XML Field BankBalanceOtherThanCashAndCashEquivalents - BS NS
					if( in_array( $xbrlData[ 'BankBalanceOtherThanCashAndCashEquivalents' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$BankCashAndCashBalances = $xbrlData[ 'BankBalanceOtherThanCashAndCashEquivalents' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'LoansCurrent' ] ) ) { // XML Field LoansCurrent - BS NS
					if( in_array( $xbrlData[ 'LoansCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ShortTermLoansAdvances = $xbrlData[ 'LoansCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentFinancialAssets' ] ) ) { // XML Field OtherCurrentFinancialAssets - BS NS
					if( in_array( $xbrlData[ 'OtherCurrentFinancialAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrentFinancialAssets = $xbrlData[ 'OtherCurrentFinancialAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentTaxAssets' ] ) ) { // XML Field CurrentTaxAssets - BS NS
					if( in_array( $xbrlData[ 'CurrentTaxAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CurrentTaxAssets = $xbrlData[ 'CurrentTaxAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentAssets' ] ) ) { // XML Field OtherCurrentAssets - BS NS
					if( in_array( $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrAssets = $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentAssets' ] ) ) { // XML Field CurrentAssets - BS NS
					if( in_array( $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalCurrentAssets = $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'Assets' ] ) ) { // XML Field Assets - BS NS
					if( in_array( $xbrlData[ 'Assets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalAssets = $xbrlData[ 'Assets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredTaxAssetsNet' ] ) ) { // XML Field DeferredTaxAssetsNet - BS NS
					if( in_array( $xbrlData[ 'DeferredTaxAssetsNet' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$DeferredTaxAssets = $xbrlData[ 'DeferredTaxAssetsNet' ][ $bsloopInc ][ '_value:' ];
					}
				}
			}
			for( $propertyplanteqInc = 0; $propertyplanteqInc < count( $xbrlData[ 'PropertyPlantAndEquipment' ] ); $propertyplanteqInc++ ) {
				if( isset( $xbrlData[ 'PropertyPlantAndEquipment' ] ) ) { // XML Field PropertyPlantAndEquipment - BS NS
					if( in_array( $xbrlData[ 'PropertyPlantAndEquipment' ][ $propertyplanteqInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'PropertyPlantAndEquipment' ][ $propertyplanteqInc ] ) ) {
							$PropertyPlantAndEquipment = $xbrlData[ 'PropertyPlantAndEquipment' ][ $propertyplanteqInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $tangiblecapitalworkprogInc = 0; $tangiblecapitalworkprogInc < count( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ] ); $tangiblecapitalworkprogInc++ ) {
				if( isset( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ] ) ) { // XML Field TangibleAssetsCapitalWorkInProgress - BS NS
					if( in_array( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $tangiblecapitalworkprogInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $tangiblecapitalworkprogInc ] ) ) {
							$TangibleAssetsCapitalWorkInProgress = $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $tangiblecapitalworkprogInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $otherIntassInc = 0; $otherIntassInc < count( $xbrlData[ 'OtherIntangibleAssets' ] ); $otherIntassInc++ ) {
				if( isset( $xbrlData[ 'OtherIntangibleAssets' ] ) ) { // XML Field OtherIntangibleAssets - BS NS
					if( in_array( $xbrlData[ 'OtherIntangibleAssets' ][ $otherIntassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'OtherIntangibleAssets' ][ $otherIntassInc ] ) ) {
							$OtherIntangibleAssets = $xbrlData[ 'OtherIntangibleAssets' ][ $otherIntassInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $intanassetunderdevInc = 0; $intanassetunderdevInc < count( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ); $intanassetunderdevInc++ ) {
				if( isset( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ) ) { // XML Field IntangibleAssetsUnderDevelopmentOrWorkInProgress - BS NS
					if( in_array( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intanassetunderdevInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intanassetunderdevInc ] ) ) {
							$IntangibleAssetsUnderDevelopmentOrWorkInProgress = $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intanassetunderdevInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $invsetaccountusingeqmet = 0; $invsetaccountusingeqmet < count( $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ] ); $invsetaccountusingeqmet++ ) {
				if( isset( $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ] ) ) { // XML Field InvestmentsAccountedForUsingEquityMethod - BS NS
					if( in_array( $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ][ $invsetaccountusingeqmet ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ][ $invsetaccountusingeqmet ] ) ) {
							$InvestmentsAccountedForUsingEquityMethod = $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ][ $invsetaccountusingeqmet ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $noncurinvInc = 0; $noncurinvInc < count( $xbrlData[ 'NoncurrentInvestments' ] ); $noncurinvInc++ ) {
				if( isset( $xbrlData[ 'NoncurrentInvestments' ] ) ) { // XML Field NoncurrentInvestments - BS NS
					if( in_array( $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ] ) ) {
							$NoncurrentInvestments = $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $curinvInc = 0; $curinvInc < count( $xbrlData[ 'CurrentInvestments' ] ); $curinvInc++ ) {
				if( isset( $xbrlData[ 'CurrentInvestments' ] ) ) { // XML Field CurrentInvestments - BS NS
					if( in_array( $xbrlData[ 'CurrentInvestments' ][ $curinvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'CurrentInvestments' ][ $curinvInc ] ) ) {
							$CurrentInvestments = $xbrlData[ 'CurrentInvestments' ][ $curinvInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $inventoriesInc = 0; $inventoriesInc < count( $xbrlData[ 'Inventories' ] ); $inventoriesInc++ ) {
				if( isset( $xbrlData[ 'Inventories' ] ) ) { // XML Field Inventories - BS NS
					if( in_array( $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'Inventories' ][ $inventoriesInc ] ) ) {
							$Inventories = $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $inventoriesInc = 0; $inventoriesInc < count( $xbrlData[ 'Inventories' ] ); $inventoriesInc++ ) {
				if( isset( $xbrlData[ 'Inventories' ] ) ) { // XML Field Inventories - BS NS
					if( in_array( $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'Inventories' ][ $inventoriesInc ] ) ) {
							$Inventories = $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $tradereceivnoncurrInc = 0; $tradereceivnoncurrInc < count( $xbrlData[ 'TradeReceivablesNoncurrent' ] ); $tradereceivnoncurrInc++ ) {
				if( isset( $xbrlData[ 'TradeReceivablesNoncurrent' ] ) ) { // XML Field Inventories - BS NS
					if( in_array( $xbrlData[ 'TradeReceivablesNoncurrent' ][ $tradereceivnoncurrInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'TradeReceivablesNoncurrent' ][ $tradereceivnoncurrInc ] ) ) {
							$TradeReceivablesNoncurrent = $xbrlData[ 'TradeReceivablesNoncurrent' ][ $tradereceivnoncurrInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $forcurrmontransassaccInc = 0; $forcurrmontransassaccInc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ); $forcurrmontransassaccInc++ ) {
				if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ) ) { // XML Field Inventories - BS NS
					if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $forcurrmontransassaccInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $forcurrmontransassaccInc ] ) ) {
							$ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $forcurrmontransassaccInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $forcurrmontransdiffacc = 0; $forcurrmontransdiffacc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ); $forcurrmontransdiffacc++ ) {
				if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ) ) { // XML Field Inventories - BS NS
					if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $forcurrmontransdiffacc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $forcurrmontransdiffacc ] ) ) {
							$ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $forcurrmontransdiffacc ][ '_value:' ];
							break;
						}
					}
				}
			}
			// Field Document 2.5.3
			for( $moneyRecAgainstShWar = 0; $moneyRecAgainstShWar < count( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ); $moneyRecAgainstShWar++ ) {
				if( isset( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ) ) { // XML Field Reserves and surplus - BS NS
					if( in_array( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgainstShWar ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgainstShWar ] ) ) {
							$MoneyReceivedAgainstShareWarrants = $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgainstShWar ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $bioassetotherbearerplant = 0; $bioassetotherbearerplant < count( $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ] ); $bioassetotherbearerplant++ ) {
				if( isset( $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ] ) ) { // XML Field BiologicalAssetsOtherThanBearerPlants - BS NS
					if( in_array( $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ][ $bioassetotherbearerplant ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ][ $bioassetotherbearerplant ] ) ) {
							$BiologicalAssetsOtherThanBearerPlants = $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ][ $bioassetotherbearerplant ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $invPropInc = 0; $invPropInc < count( $xbrlData[ 'InvestmentProperty' ] ); $invPropInc++ ) {
				if( isset( $xbrlData[ 'InvestmentProperty' ] ) ) { // XML Field InvestmentProperty - BS NS
					if( in_array( $xbrlData[ 'InvestmentProperty' ][ $invPropInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'InvestmentProperty' ][ $invPropInc ] ) ) {
							$InvestmentProperty = $xbrlData[ 'InvestmentProperty' ][ $invPropInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $goodwillInc = 0; $goodwillInc < count( $xbrlData[ 'Goodwill' ] ); $goodwillInc++ ) {
				if( isset( $xbrlData[ 'Goodwill' ] ) ) { // XML Field Goodwill - BS NS
					if( in_array( $xbrlData[ 'Goodwill' ][ $goodwillInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'Goodwill' ][ $goodwillInc ] ) ) {
							$Goodwill = $xbrlData[ 'Goodwill' ][ $goodwillInc ][ '_value:' ];
							break;
						}
					}
				}
			}

			$ReservesandSurplus = $ReservesandSurplus + $MoneyReceivedAgainstShareWarrants;
			// End os field document 2.5.3

			$OtherLongTermLiabilities = $otherNonCurrentLiabilities + $othernonCurrfinancialLiabilities + $TradePayablesNoncurrent + $DeferredGovernmentGrantsNoncurrent + $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount;
			$TotalNonCurrentLiabilitiesCheck = $LongtermBorrowings + $DeferredTaxLiabilities + $OtherLongTermLiabilities + $LongTermProvisions;
			$TotalNonCurrentLiabilities = $NonCurrentLiabilities + /*$DeferredGovernmentGrantsNoncurrent +*/ $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount;
			$diffTotalNonCurrentLiabilities = $TotalNonCurrentLiabilities - $TotalNonCurrentLiabilitiesCheck;
			$OtherCurrentLiabilities = $OtherCurrFinancialLiabilities + $OtherCurrLiabilities + $CurrentTaxLiabilities + $DeferredGovernmentGrantsCurrent;
			$ShortTermProvisions = $ProvisionsCurrent + $LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale;
			$TotalCurrentLiabilitiesCheck = $ShortTermBorrowings + $TradePayable + $OtherCurrentLiabilities + $ShortTermProvisions;
			$TotalCurrentLiabilities = $CurrentLiabilities /*+ $DeferredGovernmentGrantsCurrent*/ + $LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale;
			$diffTotalCurrentLiabilities = $TotalCurrentLiabilities - $TotalCurrentLiabilitiesCheck;
			$TotalEquityAndLiabilitiesCheck = $TotalCurrentLiabilities + $TotalNonCurrentLiabilities + $ShareApplicationMoney + $TotalShareholdersFunds;
			$diffTotalEquityAndLiabilities = $TotalEquityAndLiabilities - $TotalEquityAndLiabilitiesCheck;
			$CashandBankBalances = $CashAndCashBalances + $BankCashAndCashBalances;
			$OtherCurrentAssets = $OtherCurrentFinancialAssets + $CurrentTaxAssets + $OtherCurrAssets;
			$OtherNonCurrentAssets = $OtherNonCurrentFinancialAssets + $OtherNonCurrAssets + $NoncurrentAssetsClassifiedAsHeldForSale + $TradeReceivablesNoncurrent + $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount;
			$TangibleAssets = $PropertyPlantAndEquipment + $CapitalWorkInProgress + $InvestmentProperty + $TangibleAssetsCapitalWorkInProgress + $BiologicalAssetsOtherThanBearerPlants;
			$IntangibleAssets = $Goodwill + $OtherIntangibleAssets + $IntangibleAssetsUnderDevelopment + $IntangibleAssetsUnderDevelopmentOrWorkInProgress + $InvestmentsAccountedForUsingEquityMethod;
			$TotalFixedAssets = $TangibleAssets + $IntangibleAssets;
			$TotalNonCurrentAssets = $NonCurrentAssets + $NoncurrentAssetsClassifiedAsHeldForSale + $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount;
			$TotalNonCurrentAssetsCheck = $TotalFixedAssets + $NoncurrentInvestments + $DeferredTaxAssets + $LongTermLoansAdvances + $OtherNonCurrentAssets;
			$diffTotalNonCurrentAssets = $TotalNonCurrentAssets - $TotalNonCurrentAssetsCheck;
			$TotalCurrentAssetsCheck = $CurrentInvestments + $Inventories + $TradeReceivables + $CashandBankBalances + $ShortTermLoansAdvances + $OtherCurrentAssets;
			$diffTotalCurrentAssets = $TotalCurrentAssets - $TotalCurrentAssetsCheck;
			$TotalAssetsCheck = $TotalCurrentAssets + $TotalNonCurrentAssets;
			$diffTotalAssets = $TotalAssets - $TotalAssetsCheck;

			// Validation given in google sheet is added.
			$TotalShareholdersFundsCheck = $ShareCapital + $ReservesandSurplus;
			$diffTotalShareholdersFunds = $TotalShareholdersFunds - $TotalShareholdersFundsCheck;
			if( $TotalShareholdersFunds != $TotalShareholdersFundsCheck ) {
				if( abs( $diffTotalShareholdersFunds ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total shareholders' funds mismatch";
					$errorReport++;
				}
			}
			if( $TotalNonCurrentLiabilities != $TotalNonCurrentLiabilitiesCheck ) {
				if( abs( $diffTotalNonCurrentLiabilities ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total Non-Current Liabilites mismatch";
					$errorReport++;	
				}
			}
			if( $TotalCurrentLiabilities != $TotalCurrentLiabilitiesCheck ) {
				if( abs( $diffTotalCurrentLiabilities ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total current Liabilites mismatch";
					$errorReport++;	
				}
			}
			if( $TotalEquityAndLiabilities != $TotalEquityAndLiabilitiesCheck ) {
				if( abs( $diffTotalEquityAndLiabilities ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total equity and liabilities mismatch";
					$errorReport++;	
				}
			}
			if( $TotalNonCurrentAssets != $TotalNonCurrentAssetsCheck ) {
				if( abs( $diffTotalNonCurrentAssets ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total non-current assets mismatch";
					$errorReport++;	
				}
			}
			if( $TotalCurrentAssets != $TotalCurrentAssetsCheck ) {
				if( abs( $diffTotalCurrentAssets ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total current assets mismatch";
					$errorReport++;
				}
			}
			if( $TotalAssets != $TotalAssetsCheck ) {
				if( abs( $diffTotalAssets ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total assets mismatch";
					$errorReport++;	
				}
			}
			// Condition to check assest is equal to liabilities For MI5-T222
			$assestliabilitiesmismatch = false;
			if($TotalEquityAndLiabilities != $TotalAssets){
				//$assestliabilitiesmismatch = true; // Commented for T-598
				$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Values for the Assets and EquityAndLiabilities are not equal" ;
				$errorReport++;
			}

			// Reverting data to previous if not found
			if( ( empty( $ShareCapital ) || $ShareCapital == 0 ) && ( empty( $ReservesandSurplus ) || $ReservesandSurplus == 0 ) && ( empty( $TotalShareholdersFunds ) || $TotalShareholdersFunds == 0 ) && ( empty( $ShareApplicationMoney ) || $ShareApplicationMoney == 0 ) && 
				( empty( $LongtermBorrowings ) || $LongtermBorrowings == 0 ) && ( empty( $DeferredTaxLiabilities ) || $DeferredTaxLiabilities == 0 ) && ( empty( $OtherLongTermLiabilities ) || $OtherLongTermLiabilities == 0 ) && ( empty( $LongTermProvisions ) || $LongTermProvisions == 0 ) && 
				( empty( $TotalNonCurrentLiabilities ) || $TotalNonCurrentLiabilities == 0 ) && ( empty( $ShortTermBorrowings ) || $ShortTermBorrowings == 0 ) && ( empty( $TradePayable ) || $TradePayable == 0 ) && ( empty( $OtherCurrentLiabilities ) || $OtherCurrentLiabilities == 0 ) && 
				( empty( $ShortTermProvisions ) || $ShortTermProvisions == 0 ) && ( empty( $TotalCurrentLiabilities ) || $TotalCurrentLiabilities == 0 ) && ( empty( $TotalEquityAndLiabilities ) || $TotalEquityAndLiabilities == 0 ) && ( empty( $TangibleAssets ) || $TangibleAssets == 0 ) && 
				( empty( $IntangibleAssets ) || $IntangibleAssets == 0 ) && ( empty( $TotalFixedAssets ) || $TotalFixedAssets == 0 ) && ( empty( $NoncurrentInvestments ) || $NoncurrentInvestments == 0 ) && ( empty( $DeferredTaxAssets ) || $DeferredTaxAssets == 0 ) && 
				( empty( $LongTermLoansAdvances ) || $LongTermLoansAdvances == 0 ) && ( empty( $OtherNonCurrentAssets ) || $OtherNonCurrentAssets == 0 ) && ( empty( $TotalNonCurrentAssets ) || $TotalNonCurrentAssets == 0 ) && ( empty( $CurrentInvestments ) || $CurrentInvestments == 0 ) && 
				( empty( $Inventories ) || $Inventories == 0 ) && ( empty( $TradeReceivables ) || $TradeReceivables == 0 ) && ( empty( $CashandBankBalances ) || $CashandBankBalances == 0 ) && ( empty( $ShortTermLoansAdvances ) || $ShortTermLoansAdvances == 0 ) && 
				( empty( $OtherCurrentAssets ) || $OtherCurrentAssets == 0 ) && ( empty( $TotalCurrentAssets ) || $TotalCurrentAssets == 0 ) && ( empty( $TotalAssets ) || $TotalAssets == 0 ) ) {
					
			} else {
				/*if(!$assestliabilitiesmismatch){*/ // Commented for T-598
					if( $bsAddArray[ $fy ] ) {
					// XML parsed data assigned to variable which will be sent to excel file generation.
					/*if( !empty( $ShareCapital ) && !empty( $ReservesandSurplus ) && !empty( $TotalShareholdersFunds ) ) {*/
						$xmlParseData[ 'bs' ][ $fy ][ 'Share capital' ] = $ShareCapital;
						$xmlParseData[ 'bs' ][ $fy ][ 'Reserves and surplus' ] = $ReservesandSurplus;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total shareholders funds' ] = $TotalShareholdersFunds;
						$xmlParseData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ] = $ShareApplicationMoney;
						$xmlParseData[ 'bs' ][ $fy ][ 'Long-term borrowings' ] = $LongtermBorrowings;
						$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ] = $DeferredTaxLiabilities;
						$xmlParseData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ] = $OtherLongTermLiabilities;
						$xmlParseData[ 'bs' ][ $fy ][ 'Long-term provisions' ] = $LongTermProvisions;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ] = $TotalNonCurrentLiabilities;
						$xmlParseData[ 'bs' ][ $fy ][ 'Short-term borrowings' ] = $ShortTermBorrowings;
						$xmlParseData[ 'bs' ][ $fy ][ 'Trade payables' ] = $TradePayable;
						$xmlParseData[ 'bs' ][ $fy ][ 'Other current liabilities' ] = $OtherCurrentLiabilities;
						$xmlParseData[ 'bs' ][ $fy ][ 'Short-term provisions' ] = $ShortTermProvisions;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total current liabilities' ] = $TotalCurrentLiabilities;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ] = $TotalEquityAndLiabilities;
						$xmlParseData[ 'bs' ][ $fy ][ 'Tangible assets' ] = $TangibleAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Intangible assets' ] = $IntangibleAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total fixed assets' ] = $TotalFixedAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Non-current investments' ] = $NoncurrentInvestments;	
						$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ] = $DeferredTaxAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ] = $LongTermLoansAdvances;
						$xmlParseData[ 'bs' ][ $fy ][ 'Other non-current assets' ] = $OtherNonCurrentAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current assets' ] = $TotalNonCurrentAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Current investments' ] = $CurrentInvestments;
						$xmlParseData[ 'bs' ][ $fy ][ 'Inventories' ] = $Inventories;
						$xmlParseData[ 'bs' ][ $fy ][ 'Trade receivables' ] = $TradeReceivables;
						$xmlParseData[ 'bs' ][ $fy ][ 'Cash and bank balances' ] = $CashandBankBalances;
						$xmlParseData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ] = $ShortTermLoansAdvances;
						$xmlParseData[ 'bs' ][ $fy ][ 'Other current assets' ] = $OtherCurrentAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total current assets' ] = $TotalCurrentAssets;
						$xmlParseData[ 'bs' ][ $fy ][ 'Total assets' ] = $TotalAssets;
						foreach( $errorArray[ $cin ]['bs'][$fy] as $bstext ) {
							$logs->logWrite( $bstext, true );
						}	
					} else {
						// Unset the FY data if condition failed. remove curresponding FY error data.
						unset( $xmlParseData[ 'bs' ][ $fy ] );
						$errorReport = $errorReport - count( $errorArray[ $cin ]['bs'][$fy] );
						unset( $errorArray[ $cin ]['bs'][$fy] );
					}
				//}
			}
			//BS DATA ENDS
			// CF DATA STARTS
			$plBeforeExtraordinary = $operatingActivities = $investingActivities = $financingActivities = $incdecCashEquivalents = $cashEquivalentsBeginYear = $cashEquivalentsEndYear = 0;
			
			for( $loopcfInc = 0; $loopcfInc < $cfloopCount; $loopcfInc++ ) { 
				
                if( isset( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ] ) ) { // XML Field ProfitBeforeExceptionalItemsAndTax 
                    if( in_array( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $plBeforeExtraordinary = $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopcfInc ][ '_value:' ];
						if( !$cfAddArray[ $fy ] ) {
							$cfAddArray[ $fy ] = true;	
						}
					} else {
						if( !$cfAddArray[ $fy ] ) {
							$cfAddArray[ $fy ] = false;
						}
					}
					
					
                }
                if( isset( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ] ) ) { // XML Field CashFlowsFromUsedInOperatingActivities
                    if( in_array( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $operatingActivities = $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                if( isset( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ] ) ) { // XML Field CashFlowsFromUsedInInvestingActivities
                    if( in_array( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $investingActivities = $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                if( isset( $xbrlData[ 'CashFlowsFromUsedInFinancingActivities' ] ) ) { // XML Field CashFlowsFromUsedInFinancingActivities
                    if( in_array( $xbrlData[ 'CashFlowsFromUsedInFinancingActivities' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $financingActivities = $xbrlData[ 'CashFlowsFromUsedInFinancingActivities' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                if( isset( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ] ) ) { // XML Field IncreaseDecreaseInCashAndCashEquivalents
                    if( in_array( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $incdecCashEquivalents = $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                // For CashAndCashEquivalentsCashFlowStatement
					for( $cfloopInc1 = 0; $cfloopInc1 < count( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ] ); $cfloopInc1++ ) {
						if( isset( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ] ) ) {
							if( in_array( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
								$cashEquivalentsEndYear = $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_value:' ];
							}
						}
					}	
			}
			//$xmlParseData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] = $plBeforeExtraordinary;

			if( $cfAddArray[ $fy ] ) {
				// XML parsed data assigned to variable which will be sent to excel file generation.
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] = $plBeforeExtraordinary;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ] = $operatingActivities;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ] = $investingActivities;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used From Financing Activities' ] = $financingActivities;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ] = $incdecCashEquivalents;
				$xmlParseData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ] = $cashEquivalentsEndYear;
				foreach( $errorArray[ $cin ]['cf'][$fy] as $cftext ) {
					$logs->logWrite( $cftext, true );
				}
			} else {
				// Unset the FY data if condition failed. remove curresponding FY error data.
				unset( $xmlParseData[ 'cf' ][ $fy ] );
				$errorReport = $errorReport - count( $errorArray[ $cin ]['cf'][$fy] );
				unset( $errorArray[ $cin ]['cf'][$fy] );
			}
				// CF DATA ENDS

			$i++;
			$dilutedCont++;
			$basicCont++;
			$addval--;
		}
		return array( 'data' => $xmlParseData, 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	/*
		NEW format consolidated xml data fetching from the given XML field.
		Validation rules are applied.
		Returns: Data of both PL and BS in data key, Error data and error count is returned.
	*/
	public function xbrlNewFormatConsolidated( $xbrlData = '', $fyYear = '', $cin = '', $plArray = '', $bsArray = '',$cfArray='' ) {
		global $logs;
		global $xbrl2;
		global $Insert_XBRL2;

		$xmlParseData = array();
		$i = 0;

		$isCSRExpenditure = false;
		$isCostOfMaterialsConsumed = false;
		$isExpenses = false;
		$isOtherExpenses = false;
		$isNextkey = '';
		
		foreach($xbrlData as $key=>$val) {
			
			if($key == 'MiscellaneousExpenses' && $isNextkey != ''){
				$isCSRExpenditure = false;
			} else {
				$isNextkey = '';
			}

			// if($key == 'CostOfMaterialsConsumed'){
			// 	$isCostOfMaterialsConsumed = true;
			// } 

			// if(($key == 'Expenses' || $key == 'OtherExpenses') && $isCostOfMaterialsConsumed == true){
				
			// 	if($key == 'Expenses') {
			// 		$isExpenses = true;
			// 	} else if($key == 'OtherExpenses'){
			// 		$isOtherExpenses = true;
			// 	}
			// }

			if($key == 'CSRExpenditure'){
			//if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && ($isExpenses == false || $isOtherExpenses == false)){
				$isCSRExpenditure = true;
				$isNextkey = 'MiscellaneousExpenses';
			}
		}
		/*foreach($xbrlData as $key=>$val) {
			
			if($key == 'CostOfMaterialsConsumed'){
				$isCostOfMaterialsConsumed = true;
				continue;
			} 
			
			if($key == 'Expenses' && $isCostOfMaterialsConsumed == true){
				$isExpenses = true;
				continue;
			} 
			
			if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && $isExpenses == false){
				$isCSRExpenditure = true;
				continue;
			}
		}*/

		$loopCount = $addval = count( $xbrlData[ 'RevenueFromOperations' ] );
		$bsloopCount = $addval = count( $xbrlData[ 'OtherEquity' ] );
		$cfloopCount=$addval=count($xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ]);
		$dilutedCont = $basicCont = 4;
		$errorArray = array();
		$errorReport = 0;
		$addArray = array();
		$bsAddArray = array();
		$cfAddArray = array();
		$isXBRL2 = false;
		foreach( $fyYear as $fy ) { // Looping throught the FY years identified from the XML. Data push to corresponding FY.
			if( isset( $xbrlData[ 'RevenueFromOperations' ] ) || isset( $xbrlData[ 'EquityShareCapital' ] ) ) {
				if( !in_array( $xbrlData[ 'RevenueFromOperations' ][ $i ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) && !empty( $xbrlData[ 'RevenueFromOperations' ][ $i ][ '_attributes:' ][ '_value:' ] ) ) {
					// XML support condition check with the XML field exists or not.
					$logs->logWrite( "FY".$fy . " - Error Xml not supported", true );
					$errorArray[ $cin ]['common'][$fy][] = "FY".$fy . " - Error Xml not supported";
					$errorReport++;
					return array( 'data' => array(), 'error' => $errorReport, 'error_array' => $errorArray  );
				} else {
					$errorReport = $errorReport;
				}
			}
			// PL DATA STARTS
			$operationalIncome = $otherIncome = $totalIncomeCheck = $totalIncome = $expenses = $interest = $depreciation = $operationalAdminOtherExpenses = $operatingProfit = $EBITDA = $EBDT = $EBTbeforeExceptionalItems = $priorPeriodExceptionalExtraOrdinaryItems = $EBT = $tax = $profitMinorityInterest = $EmployeeRelatedExpenses = $CostOfMaterialsConsumed = $PurchasesOfStockInTrade = $ChangesInInventories = $CSRExpenditure = $OtherExpenses = $CurrentTax = $DeferredTax = $PAT = $totalProfitLossForPeriod = $basicInINR = $dilutedInINR = $EBTbeforeExceptionalItemsCheck = $PATCheck = $earningForeignExchange = $outgoForeignExchange = 0;

			// MI5-T384
			$ExpenditureOnProduction = 0;

			/*
				Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
				Given XML field isset condition checked and PL Context array condition is checked.
			*/
			for( $loopInc = 0; $loopInc < $loopCount; $loopInc++ ) { 
				if( isset( $xbrlData[ 'RevenueFromOperations' ] ) ) { // XML Field RevenueFromOperations - PL NC
					if( in_array( $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$operationalIncome = $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_value:' ];
						if( !$addArray[ $fy ] ) {
							$addArray[ $fy ] = true;	
						}
					} else {
						if( !$addArray[ $fy ] ) {
							$addArray[ $fy ] = false;	
						}
					}
				}
				if( isset( $xbrlData[ 'OtherIncome' ] ) ) { // XML Field OtherIncome - PL NC
					if( in_array( $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$otherIncome = $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_value:' ];
					}
				}
				$totalIncomeCheck = $operationalIncome + $otherIncome;
				if( isset( $xbrlData[ 'Income' ] ) ) { // XML Field Income - PL NC
					if( in_array( $xbrlData[ 'Income' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$totalIncome = $xbrlData[ 'Income' ][ $loopInc ][ '_value:' ];
					}
				}
				
				if( isset( $xbrlData[ 'Expenses' ] ) ) { // XML Field Expenses - PL NC
					if( in_array( $xbrlData[ 'Expenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$expenses = $xbrlData[ 'Expenses' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'FinanceCosts' ] ) ) { // XML Field FinanceCosts - PL NC
					if( in_array( $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$interest = $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ] ) ) { // XML Field DepreciationDepletionAndAmortisationExpense - PL NC
					if( in_array( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$depreciation = $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_value:' ];
					}
				}
				if( !empty( $interest ) || !empty( $depreciation ) || !empty( $expenses ) ) {
					if( empty( $interest ) ) {
						$interest = 0;
					}
					if( empty( $depreciation ) ) {
						$depreciation = 0;
					}
					$operationalAdminOtherExpenses = $expenses - $interest - $depreciation;
				}
				if( !empty( $operationalIncome ) || ( !empty( $operationalAdminOtherExpenses ) ) ) {
					$operatingProfit = $operationalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $totalIncome ) || !empty( $operationalAdminOtherExpenses ) ) {
					$EBITDA = $totalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $EBITDA ) || !empty( $interest ) ) {
					$EBDT = $EBITDA - $interest;
				}
				if( isset( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ] ) ) { // XML Field ProfitBeforeExceptionalItemsAndTax - PL NC
					if( in_array( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$EBTbeforeExceptionalItems = $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ProfitBeforeTax' ] ) ) { // XML Field ProfitBeforeTax - PL NC
					if( in_array( $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$EBT = $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TaxExpense' ] ) ) { // XML Field TaxExpense - PL NC
					if( in_array( $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$tax = $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'EmployeeBenefitExpense' ] ) ) { // XML Field EmployeeBenefitExpense - PL NC
					if( in_array( $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$EmployeeRelatedExpenses = $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_value:' ];
					}
				}

				if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) ) { // XML Field CostOfMaterialsConsumed - PL NS
					if( in_array( $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$CostOfMaterialsConsumed = $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) ) { // XML Field PurchasesOfStockInTrade - PL NS
					if( in_array( $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$PurchasesOfStockInTrade = $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) ) { // XML Field ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade - PL NS
					if( in_array( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$ChangesInInventories = $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CSRExpenditure' ] ) && $isCSRExpenditure == true ) { // XML Field CSRExpenditure - PL NS
					if( in_array( $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$CSRExpenditure = $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherExpenses' ] ) ) { // XML Field OtherExpenses - PL NS
					if( in_array( $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$OtherExpenses = $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ] ) ) { // XML Field OtherExpenses - PL OS
						if( in_array( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ExpenditureOnProduction = $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_value:' ];
						}
					}

				if( isset( $xbrlData[ 'CurrentTax' ] ) ) { // XML Field CurrentTax - PL NS
					if( in_array( $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$CurrentTax = $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredTax' ] ) ) { // XML Field DeferredTax - PL NS
					if( in_array( $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						$DeferredTax = $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_value:' ];
					}
				}

				if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) || isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) || 
					isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) || 
					isset( $xbrlData[ 'CSRExpenditure' ] ) || isset( $xbrlData[ 'OtherExpenses' ] ) || 
					isset( $xbrlData[ 'DeferredTax' ] ) || isset( $xbrlData[ 'CurrentTax' ] )) {
						$isXBRL2 = true;
				} else {
					$isXBRL2 = false;
				}
			}
			for( $profitLoassInc = 0; $profitLoassInc < count( $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ] ); $profitLoassInc++ ) {
				if( isset( $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ] ) ) { // XML Field ProfitLossForPeriodFromContinuingOperations - PL NC
					if( in_array( $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ][ $profitLoassInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ][ $profitLoassInc ] ) ) {
							if( !empty( $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ][ $profitLoassInc ][ '_value:' ] ) ) {
								$PAT = $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ][ $profitLoassInc ][ '_value:' ];
								break;	
							}
						}
					}
				}
			}
			for( $totalprofitLoassInc = 0; $totalprofitLoassInc < count( $xbrlData[ 'ProfitLossForPeriod' ] ); $totalprofitLoassInc++ ) {
				if( isset( $xbrlData[ 'ProfitLossForPeriod' ] ) ) { // XML Field ProfitLossForPeriod - PL NC
					if( in_array( $xbrlData[ 'ProfitLossForPeriod' ][ $totalprofitLoassInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ProfitLossForPeriod' ][ $totalprofitLoassInc ] ) ) {
							if( !empty( $xbrlData[ 'ProfitLossForPeriod' ][ $totalprofitLoassInc ][ '_value:' ] ) ) {
								$totalProfitLossForPeriod = $xbrlData[ 'ProfitLossForPeriod' ][ $totalprofitLoassInc ][ '_value:' ];
								break;	
							}
						}
					}
				}
			}
			for( $basicInc = 0; $basicInc < count( $xbrlData[ 'BasicEarningsLossPerShare' ] ); $basicInc++ ) {
				$newConttext = 'CONTXT_ID_'.$basicCont.'_D';
				$newConttext1 = 'CONTXT_ID_'.$basicCont.'_I';
				if( isset( $xbrlData[ 'BasicEarningsLossPerShare' ] ) ) { // XML Field BasicEarningsLossPerShare - PL NC
					if( in_array( $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ] ) ) {
							if( !empty( $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_value:' ] ) ) {
								$basicInINR = $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_value:' ];
								break;
							}
						}
					} else {
						$contextRef = explode("_",$xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ]);
						if(in_array($contextRef[0], $plArray[ $fy ])) {
							if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ] ) ) {
								if( !empty( $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_value:' ] ) ) {
									$basicInINR = $xbrlData[ 'BasicEarningsLossPerShare' ][ $basicInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
			}
			for( $dilutedInc = 0; $dilutedInc < count( $xbrlData[ 'DilutedEarningsLossPerShare' ] ); $dilutedInc++ ) {
				$newConttext = 'CONTXT_ID_'.$dilutedCont.'_D';
				$newConttext1 = 'CONTXT_ID_'.$dilutedCont.'_I';
				if( isset( $xbrlData[ 'DilutedEarningsLossPerShare' ] ) ) { // XML Field DilutedEarningsLossPerShare - PL NC
					if( in_array( $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ] ) ) {
							if( !empty( $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ] ) ) {
								$dilutedInINR = $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ];
								break;
							}
						}
					} else {
						$contextRef = explode("_",$xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ]);
						if(in_array($contextRef[0], $plArray[ $fy ])) {
							if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ] ) ) {
								if( !empty( $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ] ) ) {
									$dilutedInINR = $xbrlData[ 'DilutedEarningsLossPerShare' ][ $dilutedInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
			}
			if( empty( $dilutedInINR ) ) {
				$dilutedInINR = $basicInINR;
			}
			// Validation given in google sheet is added.
			if( $totalIncome != $totalIncomeCheck ) {
				$operationalIncome = $totalIncome - $otherIncome;
			}
			$profitMinorityInterest = $PAT - $totalProfitLossForPeriod;
			$priorPeriodExceptionalExtraOrdinaryItems = $EBTbeforeExceptionalItems - $EBT;
			$OtherExpenses = $OtherExpenses + $ExpenditureOnProduction;
			/*if( ( $PAT < 0 && ( $basicInINR >= 0 || $dilutedInINR >= 0 ) ) || ( $PAT >= 0 && ( $basicInINR < 0 || $dilutedInINR < 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) ) {
				$logs->logWrite( $fy . " - PAT, EPS mismatch" );
				$errorArray[ $cin ]['pl'][$fy][] = $fy . " - PAT, EPS mismatch";
				$errorReport++;
			}*/ // VI team asked to hide this condition.
			if( $EBITDA < $EBDT || $EBDT < $EBTbeforeExceptionalItems ) {
				$errorArray[ $cin ]['pl'][$fy][] = "FY".$fy . " - EBITDA, EBDT, EBT mismatch";
				$errorReport++;
			}
			$Insert_XBRL2['isXBRL'] = $isXBRL2;
			if( $addArray[ $fy ] ) {
			// XML parsed data assigned to variable which will be sent to excel file generation.
			/*if( !empty( $operationalIncome ) && !empty( $otherIncome ) && !empty( $totalIncome ) ) {*/
				$xmlParseData[ 'pl' ][ $fy ][ 'Operational Income' ] = $operationalIncome;
				$xmlParseData[ 'pl' ][ $fy ][ 'Other Income' ] = $otherIncome;
				$xmlParseData[ 'pl' ][ $fy ][ 'Total Income' ] = $totalIncome;
				$xmlParseData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ] = $CostOfMaterialsConsumed;
				$xmlParseData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ] = $PurchasesOfStockInTrade;
				$xmlParseData[ 'pl' ][ $fy ][ 'Changes In Inventories' ] = $ChangesInInventories;
				$xmlParseData[ 'pl' ][ $fy ][ 'CSR Expenditure' ] = $CSRExpenditure;
				$xmlParseData[ 'pl' ][ $fy ][ 'Other Expenses' ] = $OtherExpenses;
				$xmlParseData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ] = $operationalAdminOtherExpenses;
				$xmlParseData[ 'pl' ][ $fy ][ 'Operating Profit' ] = $operatingProfit;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBITDA' ] = $EBITDA;
				$xmlParseData[ 'pl' ][ $fy ][ 'Interest' ] = $interest;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBDT' ] = $EBDT;
				$xmlParseData[ 'pl' ][ $fy ][ 'Depreciation' ] = $depreciation;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ] = $EBTbeforeExceptionalItems;
				$xmlParseData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ] = $priorPeriodExceptionalExtraOrdinaryItems;
				$xmlParseData[ 'pl' ][ $fy ][ 'EBT' ] = $EBT;
				$xmlParseData[ 'pl' ][ $fy ][ 'Tax' ] = $tax;
				$xmlParseData[ 'pl' ][ $fy ][ 'PAT' ] = $PAT;
				$xmlParseData[ 'pl' ][ $fy ][ 'CurrentTax' ] = $CurrentTax;
				$xmlParseData[ 'pl' ][ $fy ][ 'DeferredTax' ] = $DeferredTax;
				$xmlParseData[ 'pl' ][ $fy ][ 'Profit (loss) of minority interest' ] = $profitMinorityInterest;
				$xmlParseData[ 'pl' ][ $fy ][ 'Total profit (loss) for period' ] = $totalProfitLossForPeriod;
				$xmlParseData[ 'pl' ][ $fy ][ '(Basic in INR)' ] = $basicInINR;
				$xmlParseData[ 'pl' ][ $fy ][ '(Diluted in INR)' ] = $dilutedInINR;
				$xmlParseData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ] = $EmployeeRelatedExpenses;
				$xmlParseData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ] = $earningForeignExchange;
				$xmlParseData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ] = $outgoForeignExchange;
				foreach( $errorArray[ $cin ]['pl'][$fy] as $pltext ) {
					$logs->logWrite( $pltext, true );
				}
			} else {
				// Unset the FY data if condition failed. remove curresponding FY error data.
				unset( $xmlParseData[ 'pl' ][ $fy ] );
				$errorReport = $errorReport - count( $errorArray[ $cin ]['pl'][$fy] );
				unset( $errorArray[ $cin ]['pl'][$fy] );
			}
			// PL DATA ENDS

			//BS DATA STARTS
			$ShareCapital = $ReservesandSurplus = $TotalShareholdersFunds = $ShareApplicationMoney = $MinorityInterest = $LongtermBorrowings = $DeferredTaxLiabilities = $otherNonCurrentLiabilities = $nonCurrentLiabilities = $LongTermProvisions = $TotalNonCurrentLiabilitiesCheck = $OtherLongTermLiabilities = $TotalNonCurrentLiabilities = $ShortTermBorrowings = $TradePayable = $OtherCurrFinancialLiabilities = $OtherCurrLiabilities = $CurrentTaxLiabilities = $OtherCurrentLiabilities = $ShortTermProvisions = $TotalCurrentLiabilitiesCheck = $TotalCurrentLiabilities = $TotalEquityAndLiabilitiesCheck = $CapitalWorkInProgress = $InvestmentProperty = $Goodwill = $LongTermLoansAdvances = $OtherNonCurrentAssets = $TotalNonCurrentAssets = $TradeReceivables = $CashAndCashBalances = $BankCashAndCashBalances = $CashandBankBalances = $ShortTermLoansAdvances = $OtherCurrentFinancialAssets = $CurrentTaxAssets = $OtherCurrAssets = $OtherCurrentAssets = $TotalCurrentAssets = $TotalAssets = $PropertyPlantAndEquipment = $OtherIntangibleAssets = $NoncurrentInvestments = $CurrentInvestments = $Inventories = $DeferredTaxAssets = $TangibleAssets = $IntangibleAssets = $TotalFixedAssets = $TotalNonCurrentAssetsCheck = $TotalNonCurrentAssets = $TotalCurrentAssetsCheck = $TotalAssetsCheck = $OtherNonCurrentFinancialAssets = $OtherNonCurrAssets = $TradePayablesNoncurrent = $DeferredGovernmentGrantsNoncurrent = $DeferredGovernmentGrantsCurrent = $ProvisionsCurrent = $LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale = $TangibleAssetsCapitalWorkInProgress = $IntangibleAssetsUnderDevelopmentOrWorkInProgress = $IntangibleAssetsUnderDevelopment = $InvestmentsAccountedForUsingEquityMethod = $TradeReceivablesNoncurrent = $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $NonCurrentLiabilities = $CurrentLiabilities = $NonCurrentAssets = $MoneyReceivedAgainstShareWarrants = $BiologicalAssetsOtherThanBearerPlants = 0;

			/*
				Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
				Given XML field isset condition checked and BS Context array condition is checked.
			*/
			for( $equityshareInc = 0; $equityshareInc < count( $xbrlData[ 'EquityShareCapital' ] ); $equityshareInc++ ) {
				if( isset( $xbrlData[ 'EquityShareCapital' ] ) ) { // XML Field EquityShareCapital - BS NC
					if( in_array( $xbrlData[ 'EquityShareCapital' ][ $equityshareInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'EquityShareCapital' ][ $equityshareInc ] ) ) {
							$ShareCapital = $xbrlData[ 'EquityShareCapital' ][ $equityshareInc ][ '_value:' ];
							break;	
						}
					} 
				}
			}
			for( $bsloopInc = 0; $bsloopInc < $bsloopCount; $bsloopInc++ ) {
				if( isset( $xbrlData[ 'OtherEquity' ] ) ) { // XML Field OtherEquity - BS NC
					if( in_array( $xbrlData[ 'OtherEquity' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ReservesandSurplus = $xbrlData[ 'OtherEquity' ][ $bsloopInc ][ '_value:' ];
						if( !$bsAddArray[ $fy ] ) {
							$bsAddArray[ $fy ] = true;	
						}
					} else {
						if( !$bsAddArray[ $fy ] ) {
							$bsAddArray[ $fy ] = false;	
						}
					}
				}
				if( isset( $xbrlData[ 'EquityAttributableToOwnersOfParent' ] ) ) { // XML Field EquityAttributableToOwnersOfParent - BS NC
					if( in_array( $xbrlData[ 'EquityAttributableToOwnersOfParent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalShareholdersFunds = $xbrlData[ 'EquityAttributableToOwnersOfParent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				$ShareApplicationMoney = 0;
				if( isset( $xbrlData[ 'NonControllingInterest' ] ) ) { // XML Field NonControllingInterest - BS NC
					if( in_array( $xbrlData[ 'NonControllingInterest' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$MinorityInterest = $xbrlData[ 'NonControllingInterest' ][ $bsloopInc ][ '_value:' ];
					}	
				}
				if( isset( $xbrlData[ 'BorrowingsNoncurrent' ] ) ) { // XML Field BorrowingsNoncurrent - BS NC
					if( in_array( $xbrlData[ 'BorrowingsNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LongtermBorrowings = $xbrlData[ 'BorrowingsNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredTaxLiabilitiesNet' ] ) ) { // XML Field DeferredTaxLiabilitiesNet - BS NC
					if( in_array( $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$DeferredTaxLiabilities = $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentLiabilities' ] ) ) { // XML Field OtherNoncurrentLiabilities - BS NC
					if( in_array( $xbrlData[ 'OtherNoncurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$otherNonCurrentLiabilities = $xbrlData[ 'OtherNoncurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentFinancialLiabilities' ] ) ) { // XML Field OtherNoncurrentFinancialLiabilities - BS NC
					if( in_array( $xbrlData[ 'OtherNoncurrentFinancialLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$nonCurrentLiabilities = $xbrlData[ 'OtherNoncurrentFinancialLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TradePayablesNoncurrent' ] ) ) { // XML Field TradePayablesNoncurrent - BS NC
					if( in_array( $xbrlData[ 'TradePayablesNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TradePayablesNoncurrent = $xbrlData[ 'TradePayablesNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ProvisionsNoncurrent' ] ) ) { // XML Field ProvisionsNoncurrent - BS NC
					if( in_array( $xbrlData[ 'ProvisionsNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LongTermProvisions = $xbrlData[ 'ProvisionsNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'NoncurrentLiabilities' ] ) ) { // XML Field NoncurrentLiabilities - BS NC
					if( in_array( $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$NonCurrentLiabilities = $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				
				if( isset( $xbrlData[ 'BorrowingsCurrent' ] ) ) { // XML Field BorrowingsCurrent - BS NC
					if( in_array( $xbrlData[ 'BorrowingsCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ShortTermBorrowings = $xbrlData[ 'BorrowingsCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TradePayablesCurrent' ] ) ) { // XML Field TradePayablesCurrent - BS NC
					if( in_array( $xbrlData[ 'TradePayablesCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TradePayable = $xbrlData[ 'TradePayablesCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentFinancialLiabilities' ] ) ) { // XML Field OtherCurrentFinancialLiabilities - BS NC
					if( in_array( $xbrlData[ 'OtherCurrentFinancialLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrFinancialLiabilities = $xbrlData[ 'OtherCurrentFinancialLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentLiabilities' ] ) ) { // XML Field OtherCurrentLiabilities - BS NC
					if( in_array( $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrLiabilities = $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentTaxLiabilities' ] ) ) { // XML Field CurrentTaxLiabilities - BS NC
					if( in_array( $xbrlData[ 'CurrentTaxLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CurrentTaxLiabilities = $xbrlData[ 'CurrentTaxLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'ProvisionsCurrent' ] ) ) { // XML Field ProvisionsCurrent - BS NC
					if( in_array( $xbrlData[ 'ProvisionsCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ProvisionsCurrent = $xbrlData[ 'ProvisionsCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentLiabilities' ] ) ) { // XML Field CurrentLiabilities - BS NC
					if( in_array( $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CurrentLiabilities = $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'EquityAndLiabilities' ] ) ) { // XML Field EquityAndLiabilities - BS NC
					if( in_array( $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalEquityAndLiabilities = $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CapitalWorkInProgress' ] ) ) { // XML Field CapitalWorkInProgress - BS NC
					if( in_array( $xbrlData[ 'CapitalWorkInProgress' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CapitalWorkInProgress = $xbrlData[ 'CapitalWorkInProgress' ][ $bsloopInc ][ '_value:' ];
					}
				}
				/*if( isset( $xbrlData[ 'Goodwill' ] ) ) { // XML Field Goodwill - BS NC
					if( in_array( $xbrlData[ 'Goodwill' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$Goodwill = $xbrlData[ 'Goodwill' ][ $bsloopInc ][ '_value:' ];
					}
				}*/
				if( isset( $xbrlData[ 'LoansNoncurrent' ] ) ) { // XML Field LoansNoncurrent - BS NC
					if( in_array( $xbrlData[ 'LoansNoncurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$LongTermLoansAdvances = $xbrlData[ 'LoansNoncurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentFinancialAssets' ] ) ) { // XML Field OtherNoncurrentFinancialAssets - BS NC
					if( in_array( $xbrlData[ 'OtherNoncurrentFinancialAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherNonCurrentFinancialAssets = $xbrlData[ 'OtherNoncurrentFinancialAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherNoncurrentAssets' ] ) ) { // XML Field OtherNoncurrentAssets - BS NC
					if( in_array( $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherNonCurrAssets = $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'NoncurrentAssetsClassifiedAsHeldForSale' ] ) ) { // XML Field NoncurrentAssetsClassifiedAsHeldForSale - BS NC
					if( in_array( $xbrlData[ 'NoncurrentAssetsClassifiedAsHeldForSale' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$NoncurrentAssetsClassifiedAsHeldForSale = $xbrlData[ 'NoncurrentAssetsClassifiedAsHeldForSale' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'NoncurrentAssets' ] ) ) { // XML Field NoncurrentAssets - BS NC
					if( in_array( $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$NonCurrentAssets = $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'TradeReceivablesCurrent' ] ) ) { // XML Field TradeReceivablesCurrent - BS NC
					if( in_array( $xbrlData[ 'TradeReceivablesCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TradeReceivables = $xbrlData[ 'TradeReceivablesCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CashAndCashEquivalents' ] ) ) { // XML Field CashAndCashEquivalents - BS NC
					if( in_array( $xbrlData[ 'CashAndCashEquivalents' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CashAndCashBalances = $xbrlData[ 'CashAndCashEquivalents' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'BankBalanceOtherThanCashAndCashEquivalents' ] ) ) { // XML Field BankBalanceOtherThanCashAndCashEquivalents - BS NC
					if( in_array( $xbrlData[ 'BankBalanceOtherThanCashAndCashEquivalents' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$BankCashAndCashBalances = $xbrlData[ 'BankBalanceOtherThanCashAndCashEquivalents' ][ $bsloopInc ][ '_value:' ];
					}
				}
				$CashandBankBalances = $CashAndCashBalances + $BankCashAndCashBalances;
				if( isset( $xbrlData[ 'LoansCurrent' ] ) ) { // XML Field LoansCurrent - BS NC
					if( in_array( $xbrlData[ 'LoansCurrent' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$ShortTermLoansAdvances = $xbrlData[ 'LoansCurrent' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentFinancialAssets' ] ) ) { // XML Field OtherCurrentFinancialAssets - BS NC
					if( in_array( $xbrlData[ 'OtherCurrentFinancialAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrentFinancialAssets = $xbrlData[ 'OtherCurrentFinancialAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'CurrentTaxAssets' ] ) ) { // XML Field CurrentTaxAssets - BS NC
					if( in_array( $xbrlData[ 'CurrentTaxAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$CurrentTaxAssets = $xbrlData[ 'CurrentTaxAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'OtherCurrentAssets' ] ) ) { // XML Field OtherCurrentAssets - BS NC
					if( in_array( $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$OtherCurrAssets = $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				$OtherCurrentAssets = $OtherCurrentFinancialAssets + $CurrentTaxAssets + $OtherCurrAssets;
				if( isset( $xbrlData[ 'CurrentAssets' ] ) ) { // XML Field CurrentAssets - BS NC
					if( in_array( $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalCurrentAssets = $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'Assets' ] ) ) { // XML Field Assets - BS NC
					if( in_array( $xbrlData[ 'Assets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$TotalAssets = $xbrlData[ 'Assets' ][ $bsloopInc ][ '_value:' ];
					}
				}
				if( isset( $xbrlData[ 'DeferredTaxAssetsNet' ] ) ) { // XML Field DeferredTaxAssetsNet - BS NC
					if( in_array( $xbrlData[ 'DeferredTaxAssetsNet' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						$DeferredTaxAssets = $xbrlData[ 'DeferredTaxAssetsNet' ][ $bsloopInc ][ '_value:' ];
					}
				}
			}

			for( $propertyplanteqInc = 0; $propertyplanteqInc < count( $xbrlData[ 'PropertyPlantAndEquipment' ] ); $propertyplanteqInc++ ) {
				if( isset( $xbrlData[ 'PropertyPlantAndEquipment' ] ) ) { // XML Field PropertyPlantAndEquipment - BS NC
					if( in_array( $xbrlData[ 'PropertyPlantAndEquipment' ][ $propertyplanteqInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'PropertyPlantAndEquipment' ][ $propertyplanteqInc ] ) ) {
							$PropertyPlantAndEquipment = $xbrlData[ 'PropertyPlantAndEquipment' ][ $propertyplanteqInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $tangibleassetsWorkInc = 0; $tangibleassetsWorkInc < count( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ] ); $tangibleassetsWorkInc++ ) {
				if( isset( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ] ) ) { // XML Field TangibleAssetsCapitalWorkInProgress - BS NC
					if( in_array( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $tangibleassetsWorkInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $tangibleassetsWorkInc ] ) ) {
							$TangibleAssetsCapitalWorkInProgress = $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $tangibleassetsWorkInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $otherIntassInc = 0; $otherIntassInc < count( $xbrlData[ 'OtherIntangibleAssets' ] ); $otherIntassInc++ ) {
				if( isset( $xbrlData[ 'OtherIntangibleAssets' ] ) ) { // XML Field OtherIntangibleAssets - BS NC
					if( in_array( $xbrlData[ 'OtherIntangibleAssets' ][ $otherIntassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'OtherIntangibleAssets' ][ $otherIntassInc ] ) ) {
							$OtherIntangibleAssets = $xbrlData[ 'OtherIntangibleAssets' ][ $otherIntassInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $otherIntassInc = 0; $otherIntassInc < count( $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ] ); $otherIntassInc++ ) {
				if( isset( $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ] ) ) { // XML Field InvestmentsAccountedForUsingEquityMethod - BS NC
					if( in_array( $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ][ $otherIntassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ][ $otherIntassInc ] ) ) {
							$InvestmentsAccountedForUsingEquityMethod = $xbrlData[ 'InvestmentsAccountedForUsingEquityMethod' ][ $otherIntassInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $otherIntassInc = 0; $otherIntassInc < count( $xbrlData[ 'IntangibleAssetsUnderDevelopment' ] ); $otherIntassInc++ ) {
				if( isset( $xbrlData[ 'IntangibleAssetsUnderDevelopment' ] ) ) { // XML Field IntangibleAssetsUnderDevelopment - BS NC
					if( in_array( $xbrlData[ 'IntangibleAssetsUnderDevelopment' ][ $otherIntassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssetsUnderDevelopment' ][ $otherIntassInc ] ) ) {
							$IntangibleAssetsUnderDevelopment = $xbrlData[ 'IntangibleAssetsUnderDevelopment' ][ $otherIntassInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $otherIntassInc = 0; $otherIntassInc < count( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ); $otherIntassInc++ ) {
				if( isset( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ) ) { // XML Field IntangibleAssetsUnderDevelopmentOrWorkInProgress - BS NC
					if( in_array( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $otherIntassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $otherIntassInc ] ) ) {
							$IntangibleAssetsUnderDevelopmentOrWorkInProgress = $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $otherIntassInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $noncurinvInc = 0; $noncurinvInc < count( $xbrlData[ 'NoncurrentInvestments' ] ); $noncurinvInc++ ) {
				if( isset( $xbrlData[ 'NoncurrentInvestments' ] ) ) { // XML Field NoncurrentInvestments - BS NC
					if( in_array( $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ] ) ) {
							$NoncurrentInvestments = $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $curinvInc = 0; $curinvInc < count( $xbrlData[ 'CurrentInvestments' ] ); $curinvInc++ ) {
				if( isset( $xbrlData[ 'CurrentInvestments' ] ) ) { // XML Field CurrentInvestments - BS NC
					if( in_array( $xbrlData[ 'CurrentInvestments' ][ $curinvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'CurrentInvestments' ][ $curinvInc ] ) ) {
							$CurrentInvestments = $xbrlData[ 'CurrentInvestments' ][ $curinvInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $inventoriesInc = 0; $inventoriesInc < count( $xbrlData[ 'Inventories' ] ); $inventoriesInc++ ) {
				if( isset( $xbrlData[ 'Inventories' ] ) ) { // XML Field Inventories - BS NC
					if( in_array( $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'Inventories' ][ $inventoriesInc ] ) ) {
							$Inventories = $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $deferredgovnoncurrInc = 0; $deferredgovnoncurrInc < count( $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ] ); $deferredgovnoncurrInc++ ) {
				if( isset( $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ] ) ) { // XML Field DeferredGovernmentGrantsNoncurrent - BS NC
					if( in_array( $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ][ $deferredgovnoncurrInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ][ $deferredgovnoncurrInc ] ) ) {
							$DeferredGovernmentGrantsNoncurrent = $xbrlData[ 'DeferredGovernmentGrantsNoncurrent' ][ $deferredgovnoncurrInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $deferredgovcurrInc = 0; $deferredgovcurrInc < count( $xbrlData[ 'DeferredGovernmentGrantsCurrent' ] ); $deferredgovcurrInc++ ) {
				if( isset( $xbrlData[ 'DeferredGovernmentGrantsCurrent' ] ) ) { // XML Field DeferredGovernmentGrantsCurrent - BS NC
					if( in_array( $xbrlData[ 'DeferredGovernmentGrantsCurrent' ][ $deferredgovcurrInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'DeferredGovernmentGrantsCurrent' ][ $deferredgovcurrInc ] ) ) {
							$DeferredGovernmentGrantsCurrent = $xbrlData[ 'DeferredGovernmentGrantsCurrent' ][ $deferredgovcurrInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $liaheldforsaleInc = 0; $liaheldforsaleInc < count( $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ] ); $liaheldforsaleInc++ ) {
				if( isset( $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ] ) ) { // XML Field LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale - BS NC
					if( in_array( $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ][ $liaheldforsaleInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ][ $liaheldforsaleInc ] ) ) {
							$LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale = $xbrlData[ 'LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale' ][ $liaheldforsaleInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $tradereceivnoncurInc = 0; $tradereceivnoncurInc < count( $xbrlData[ 'TradeReceivablesNoncurrent' ] ); $tradereceivnoncurInc++ ) {
				if( isset( $xbrlData[ 'TradeReceivablesNoncurrent' ] ) ) { // XML Field TradeReceivablesNoncurrent - BS NC
					if( in_array( $xbrlData[ 'TradeReceivablesNoncurrent' ][ $tradereceivnoncurInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'TradeReceivablesNoncurrent' ][ $tradereceivnoncurInc ] ) ) {
							$TradeReceivablesNoncurrent = $xbrlData[ 'TradeReceivablesNoncurrent' ][ $tradereceivnoncurInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $foreignTransDiffAssAcc = 0; $foreignTransDiffAssAcc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ); $foreignTransDiffAssAcc++ ) {
				if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ) ) { // XML Field ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount - BS NC
					if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignTransDiffAssAcc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignTransDiffAssAcc ] ) ) {
							$ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignTransDiffAssAcc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $foreignCurrMonTransLiaAcc = 0; $foreignCurrMonTransLiaAcc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ); $foreignCurrMonTransLiaAcc++ ) {
				if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ) ) { // XML Field ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount - BS NC
					if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMonTransLiaAcc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMonTransLiaAcc ] ) ) {
							$ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMonTransLiaAcc ][ '_value:' ];
							break;
						}
					}
				}
			}

			// Field changes document 2.5.3
			for( $moneyRecAgShrWar = 0; $moneyRecAgShrWar < count( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ); $moneyRecAgShrWar++ ) {
				if( isset( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ) ) { // XML Field MoneyReceivedAgainstShareWarrants - BS NC
					if( in_array( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgShrWar ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgShrWar ] ) ) {
							$MoneyReceivedAgainstShareWarrants = $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgShrWar ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $bioAssetOthanBearplan = 0; $bioAssetOthanBearplan < count( $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ] ); $bioAssetOthanBearplan++ ) {
				if( isset( $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ] ) ) { // XML Field BiologicalAssetsOtherThanBearerPlants - BS NC
					if( in_array( $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ][ $bioAssetOthanBearplan ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ][ $bioAssetOthanBearplan ] ) ) {
							$BiologicalAssetsOtherThanBearerPlants = $xbrlData[ 'BiologicalAssetsOtherThanBearerPlants' ][ $bioAssetOthanBearplan ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $invpropInc = 0; $invpropInc < count( $xbrlData[ 'InvestmentProperty' ] ); $invpropInc++ ) {
				if( isset( $xbrlData[ 'InvestmentProperty' ] ) ) { // XML Field InvestmentProperty - BS NC
					if( in_array( $xbrlData[ 'InvestmentProperty' ][ $invpropInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'InvestmentProperty' ][ $invpropInc ] ) ) {
							$InvestmentProperty = $xbrlData[ 'InvestmentProperty' ][ $invpropInc ][ '_value:' ];
							break;
						}
					}
				}
			}
			for( $goodwillInc = 0; $goodwillInc < count( $xbrlData[ 'Goodwill' ] ); $goodwillInc++ ) {
				if( isset( $xbrlData[ 'Goodwill' ] ) ) { // XML Field Goodwill - BS NC
					if( in_array( $xbrlData[ 'Goodwill' ][ $goodwillInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
						if( array_key_exists( '_value:', $xbrlData[ 'Goodwill' ][ $goodwillInc ] ) ) {
							$Goodwill = $xbrlData[ 'Goodwill' ][ $goodwillInc ][ '_value:' ];
							break;
						}
					}
				}
			}

			$ReservesandSurplus = $ReservesandSurplus + $MoneyReceivedAgainstShareWarrants; // document 2.5.3
			$TotalShareholdersFundsCheck = $ShareCapital + $ReservesandSurplus;
			// End of field changes document 2.5.3

			$OtherLongTermLiabilities = $otherNonCurrentLiabilities + $nonCurrentLiabilities + $TradePayablesNoncurrent + $DeferredGovernmentGrantsNoncurrent + $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount;
			$TotalNonCurrentLiabilities = $NonCurrentLiabilities /*+ $DeferredGovernmentGrantsNoncurrent*/ + $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount; // document 2.5.3
			$TotalNonCurrentLiabilitiesCheck = $LongtermBorrowings + $DeferredTaxLiabilities + $OtherLongTermLiabilities + $LongTermProvisions;

			$ShortTermProvisions = $ProvisionsCurrent + $LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale;

			$OtherCurrentLiabilities = $OtherCurrFinancialLiabilities + $OtherCurrLiabilities + $CurrentTaxLiabilities + $DeferredGovernmentGrantsCurrent;
			$TotalCurrentLiabilitiesCheck = $ShortTermBorrowings + $TradePayable + $OtherCurrentLiabilities + $ShortTermProvisions;

			$TotalCurrentLiabilities = $CurrentLiabilities /*+ $DeferredGovernmentGrantsCurrent*/ + $LiabilitiesDirectlyAssociatedWithAssetsInDisposalGroupClassifiedAsHeldForSale; // document 2.5.3
			$TotalEquityAndLiabilitiesCheck = $TotalCurrentLiabilities + $TotalNonCurrentLiabilities + $MinorityInterest + $ShareApplicationMoney + $TotalShareholdersFunds;

			$TangibleAssets = $PropertyPlantAndEquipment + $CapitalWorkInProgress + $InvestmentProperty + $TangibleAssetsCapitalWorkInProgress + $BiologicalAssetsOtherThanBearerPlants; // document 2.5.3
			$IntangibleAssets = $Goodwill + $OtherIntangibleAssets + $IntangibleAssetsUnderDevelopmentOrWorkInProgress + $IntangibleAssetsUnderDevelopment + $InvestmentsAccountedForUsingEquityMethod;
			$TotalFixedAssets = $TangibleAssets + $IntangibleAssets;

			$OtherNonCurrentAssets = $OtherNonCurrentFinancialAssets + $OtherNonCurrAssets + $NoncurrentAssetsClassifiedAsHeldForSale + $TradeReceivablesNoncurrent + $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount;
			$TotalNonCurrentAssets = $NonCurrentAssets + $NoncurrentAssetsClassifiedAsHeldForSale + $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount;
			$TotalNonCurrentAssetsCheck = $TotalFixedAssets + $NoncurrentInvestments + $DeferredTaxAssets + $LongTermLoansAdvances + $OtherNonCurrentAssets;
			$TotalCurrentAssetsCheck = $CurrentInvestments + $Inventories + $TradeReceivables + $CashandBankBalances + $ShortTermLoansAdvances + $OtherCurrentAssets;
			$TotalAssetsCheck = $TotalCurrentAssets + $TotalNonCurrentAssets;

			// Validation given in google sheet is added.
			$diffTotalShareholdersFunds = $TotalShareholdersFunds - $TotalShareholdersFundsCheck;
			if( $TotalShareholdersFunds != $TotalShareholdersFundsCheck ) {
				if( abs( $diffTotalShareholdersFunds ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total shareholders' funds mismatch";
					$errorReport++;	
				}
			}
			$diffTotalNonCurrentLiabilities = $TotalNonCurrentLiabilities - $TotalNonCurrentLiabilitiesCheck;
			if( $TotalNonCurrentLiabilities != $TotalNonCurrentLiabilitiesCheck ) {
				if( abs( $diffTotalNonCurrentLiabilities ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total Non-Current Liabilites mismatch";
					$errorReport++;	
				}
			}
			$diffTotalCurrentLiabilities = $TotalCurrentLiabilities - $TotalCurrentLiabilitiesCheck;
			if( $TotalCurrentLiabilities != $TotalCurrentLiabilitiesCheck ) {
				if( abs( $diffTotalCurrentLiabilities ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total Current Liabilites mismatch";
					$errorReport++;	
				}
			}
			$diffTotalEquityAndLiabilities = $TotalEquityAndLiabilities - $TotalEquityAndLiabilitiesCheck;
			if( $TotalEquityAndLiabilities != $TotalEquityAndLiabilitiesCheck ) {
				if( abs( $diffTotalEquityAndLiabilities ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total equity and liabilities mismatch";
					$errorReport++;	
				}
			}
			$diffTotalNonCurrentAssets = $TotalNonCurrentAssets - $TotalNonCurrentAssetsCheck;
			if( $TotalNonCurrentAssets != $TotalNonCurrentAssetsCheck ) {
				if( abs( $diffTotalNonCurrentAssets ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total non-current assets mismatch";
					$errorReport++;	
				}
			}
			$diffTotalCurrentAssets = $TotalCurrentAssets - $TotalCurrentAssetsCheck;
			if( $TotalCurrentAssets != $TotalCurrentAssetsCheck ) {
				if( abs( $diffTotalCurrentAssets ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total current assets mismatch";
					$errorReport++;	
				}
			}
			$diffTotalAssets = $TotalAssets - $TotalAssetsCheck;
			if( $TotalAssets != $TotalAssetsCheck ) {
				if( abs( $diffTotalAssets ) > 20 ) {
					$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total assets mismatch";
					$errorReport++;	
				}
			}
			if( $bsAddArray[ $fy ] ) {
			// XML parsed data assigned to variable which will be sent to excel file generation.
			/*if( !empty( $ShareCapital ) && !empty( $ReservesandSurplus ) && !empty( $TotalShareholdersFunds ) ) {*/
				$xmlParseData[ 'bs' ][ $fy ][ 'Share capital' ] = $ShareCapital;
				$xmlParseData[ 'bs' ][ $fy ][ 'Reserves and surplus' ] = $ReservesandSurplus;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total shareholders funds' ] = $TotalShareholdersFunds;
				$xmlParseData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ] = $ShareApplicationMoney;
				$xmlParseData[ 'bs' ][ $fy ][ 'Minority interest' ] = $MinorityInterest;
				$xmlParseData[ 'bs' ][ $fy ][ 'Long-term borrowings' ] = $LongtermBorrowings;
				$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ] = $DeferredTaxLiabilities;
				$xmlParseData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ] = $OtherLongTermLiabilities;
				$xmlParseData[ 'bs' ][ $fy ][ 'Long-term provisions' ] = $LongTermProvisions;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ] = $TotalNonCurrentLiabilities;
				$xmlParseData[ 'bs' ][ $fy ][ 'Short-term borrowings' ] = $ShortTermBorrowings;
				$xmlParseData[ 'bs' ][ $fy ][ 'Trade payables' ] = $TradePayable;
				$xmlParseData[ 'bs' ][ $fy ][ 'Other current liabilities' ] = $OtherCurrentLiabilities;
				$xmlParseData[ 'bs' ][ $fy ][ 'Short-term provisions' ] = $ShortTermProvisions;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total current liabilities' ] = $TotalCurrentLiabilities;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ] = $TotalEquityAndLiabilities;
				$xmlParseData[ 'bs' ][ $fy ][ 'Tangible assets' ] = $TangibleAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Intangible assets' ] = $IntangibleAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total fixed assets' ] = $TotalFixedAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Non-current investments' ] = $NoncurrentInvestments;	
				$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ] = $DeferredTaxAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ] = $LongTermLoansAdvances;
				$xmlParseData[ 'bs' ][ $fy ][ 'Other non-current assets' ] = $OtherNonCurrentAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current assets' ] = $TotalNonCurrentAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Current investments' ] = $CurrentInvestments;
				$xmlParseData[ 'bs' ][ $fy ][ 'Inventories' ] = $Inventories;
				$xmlParseData[ 'bs' ][ $fy ][ 'Trade receivables' ] = $TradeReceivables;
				$xmlParseData[ 'bs' ][ $fy ][ 'Cash and bank balances' ] = $CashandBankBalances;
				$xmlParseData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ] = $ShortTermLoansAdvances;
				$xmlParseData[ 'bs' ][ $fy ][ 'Other current assets' ] = $OtherCurrentAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total current assets' ] = $TotalCurrentAssets;
				$xmlParseData[ 'bs' ][ $fy ][ 'Total assets' ] = $TotalAssets;
				foreach( $errorArray[ $cin ]['bs'][$fy] as $bstext ) {
					$logs->logWrite( $bstext, true );
				}	
			} else {
				// Unset the FY data if condition failed. remove curresponding FY error data.
				unset( $xmlParseData[ 'bs' ][ $fy ] );
				$errorReport = $errorReport - count( $errorArray[ $cin ]['bs'][$fy] );
				unset( $errorArray[ $cin ]['bs'][$fy] );
			}
			//BS DATA ENDS
			// CF DATA STARTS
			$plBeforeExtraordinary = $operatingActivities = $investingActivities = $financingActivities = $incdecCashEquivalents = $cashEquivalentsBeginYear = $cashEquivalentsEndYear = 0;
			
			for( $loopcfInc = 0; $loopcfInc < $cfloopCount; $loopcfInc++ ) { 
				
                if( isset( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ] ) ) { // XML Field ProfitBeforeExceptionalItemsAndTax 
                    if( in_array( $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $plBeforeExtraordinary = $xbrlData[ 'ProfitBeforeExceptionalItemsAndTax' ][ $loopcfInc ][ '_value:' ];
						if( !$cfAddArray[ $fy ] ) {
							$cfAddArray[ $fy ] = true;	
						}
					} else {
						if( !$cfAddArray[ $fy ] ) {
							$cfAddArray[ $fy ] = false;
						}
					}
					
					
                }
                if( isset( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ] ) ) { // XML Field CashFlowsFromUsedInOperatingActivities
                    if( in_array( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $operatingActivities = $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                if( isset( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ] ) ) { // XML Field CashFlowsFromUsedInInvestingActivities
                    if( in_array( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $investingActivities = $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                if( isset( $xbrlData[ 'CashFlowsFromUsedInFinancingActivities' ] ) ) { // XML Field CashFlowsFromUsedInFinancingActivities
                    if( in_array( $xbrlData[ 'CashFlowsFromUsedInFinancingActivities' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $financingActivities = $xbrlData[ 'CashFlowsFromUsedInFinancingActivities' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                if( isset( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ] ) ) { // XML Field IncreaseDecreaseInCashAndCashEquivalents
                    if( in_array( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $loopcfInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
                        $incdecCashEquivalents = $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $loopcfInc ][ '_value:' ];
                    }
                }
                // For CashAndCashEquivalentsCashFlowStatement
					for( $cfloopInc1 = 0; $cfloopInc1 < count( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ]); $cfloopInc1++ ) {
						if( isset( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ] ) ) {
							if( in_array( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
								$cashEquivalentsEndYear = $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_value:' ];
							}
						}
					}	
			}
			//$xmlParseData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] = $plBeforeExtraordinary;

			if( $cfAddArray[ $fy ] ) {
				// XML parsed data assigned to variable which will be sent to excel file generation.
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] = $plBeforeExtraordinary;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ] = $operatingActivities;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ] = $investingActivities;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used From Financing Activities' ] = $financingActivities;
				$xmlParseData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ] = $incdecCashEquivalents;
				$xmlParseData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ] = $cashEquivalentsEndYear;
				foreach( $errorArray[ $cin ]['cf'][$fy] as $cftext ) {
					$logs->logWrite( $cftext, true );
				}
			} else {
				// Unset the FY data if condition failed. remove curresponding FY error data.
				unset( $xmlParseData[ 'cf' ][ $fy ] );
				$errorReport = $errorReport - count( $errorArray[ $cin ]['cf'][$fy] );
				unset( $errorArray[ $cin ]['cf'][$fy] );
			}
				// CF DATA ENDS

			$i++;
			$dilutedCont++;
			$basicCont++;
			$addval--;
		}
		return array( 'data' => $xmlParseData, 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	/*
		OLD format standalone xml data fetching from the given XML field.
		Validation rules are applied.
		Returns: Data of both PL and BS in data key, Error data and error count is returned.
	*/
	public function xbrlOldFormatStandalone( $xbrlData = '', $fyYear = '', $cin = '', $plArray = '', $bsArray = '', $cfArray = '', $yearMapp = '', $xmlParseData = array() ) {
		global $logs;
		global $xbrl2;
		global $Insert_XBRL2;
		$isXBRL2 = false;
		/*if( !empty( $xmlParseData[ 'bs' ][ '2014' ] ) ) {
			echo '<pre>'; print_r( $xmlParseData ); echo '</pre>';
			exit; 
		}*/
		//echo '<pre>'; print_r( $fyYear ); echo '</pre>';
		/*echo '(((((((((((((((((((((((((((((((((((((((((((((((((((';
		echo '<pre>'; var_dump( $plArray ); echo '</pre>';
		echo ')))))))))))))))))))))))))))))))))))))))))))))))))))';*/
		$i = 0;

		$isCSRExpenditure = false;
		$isCostOfMaterialsConsumed = false;
		$isExpenses = false;
		$isOtherExpenses = false;
		$isNextkey = '';
		
		foreach($xbrlData as $key=>$val) {
			
			if($key == 'MiscellaneousExpenses' && $isNextkey != ''){
				$isCSRExpenditure = false;
			} else {
				$isNextkey = '';
			}

			// if($key == 'CostOfMaterialsConsumed'){
			// 	$isCostOfMaterialsConsumed = true;
			// } 

			// if(($key == 'Expenses' || $key == 'OtherExpenses') && $isCostOfMaterialsConsumed == true){
				
			// 	if($key == 'Expenses') {
			// 		$isExpenses = true;
			// 	} else if($key == 'OtherExpenses'){
			// 		$isOtherExpenses = true;
			// 	}
			// }

			if($key == 'CSRExpenditure'){
			//if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && ($isExpenses == false || $isOtherExpenses == false)){
				$isCSRExpenditure = true;
				$isNextkey = 'MiscellaneousExpenses';
			}
		}

		/*foreach($xbrlData as $key=>$val) {
			
			if($key == 'CostOfMaterialsConsumed'){
				$isCostOfMaterialsConsumed = true;
				continue;
			} 
			
			if($key == 'Expenses' && $isCostOfMaterialsConsumed == true){
				$isExpenses = true;
				continue;
			} 
			
			if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && $isExpenses == false){
				$isCSRExpenditure = true;
				continue;
			}
		}*/

		if( count( $xbrlData[ 'RevenueFromOperations' ] ) > 0 ) {
			$loopCount = $addval = count( $xbrlData[ 'RevenueFromOperations' ] );	
		} else {
			$loopCount = $addval = count( $xbrlData[ 'OperatingRevenueNet' ] );
		}
		if( isset( $xbrlData[ 'ReservesAndSurplus' ] ) ) {
			$bsloopCount = $addval = count( $xbrlData[ 'ReservesAndSurplus' ] );
		} else {
			$bsloopCount = $addval = count( $xbrlData[ 'ReservesSurplus' ] );
		}
		// if( count( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) > 0 ) {
		// 	$cfloopCount = $addval = count( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] );	
		// } else if( count( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) > 0 ) {
		// 	$cfloopCount = $addval = count( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] );
		// } else {
		// 	$cfloopCount = $addval = count( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] );
		// }
		$cfloopCountarray = array();
		array_push($cfloopCountarray,count( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ),
				count( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ),
				count( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] ),
				count( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ] ),
				count( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ] ),
				count( $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ] ),
				count( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ] ));
		
		$cfloopCount = $addval = max($cfloopCountarray);

		$dilutedCont = $basicCont = 4;
		$errorArray = array();
		if( empty( $xmlParseData ) ) {
			$errorReport = 0;
		} else {
			$errorReport = $xmlParseData[ 'error' ];
		}
		$previousData = $xmlParseData[ 'data' ];
		$xmlParseData = $xmlParseData[ 'data' ];
		foreach( $fyYear as $fy ) { // Looping throught the FY years identified from the XML. Data push to corresponding FY.
			$addFlag  = 0;
			$addBSFlag  = 0;
			$addCFFlag  = 0;
			if( $loopCount > 0 ) {
				/*if( $fy == 2013 ) {
					echo '<pre>'; print_r( $previousData[ 'pl' ][ $fy ][ 'check' ] ); echo '</pre>';
					echo '<pre>'; print_r( $xbrlData[ 'EmployeeBenefitExpense' ] ); echo '</pre>';
					echo '<pre>'; print_r( $xbrlData[ 'EmployeeRelatedExpenses' ] ); echo '</pre>';
				}*/
				if( array_key_exists( $fy, $previousData[ 'pl' ] ) ) {
					//echo 'Key check staisfied' . $loopCount . '<br/>';
					if( $previousData[ 'pl' ][ $fy ][ 'check' ] == 'Partial' && $yearMapp[ $fy ] == 'Full' ) {
						if( isset( $xbrlData[ 'RevenueFromOperations' ] ) || isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) {
							$xmlParseData[ 'pl' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
							$addFlag = 1;
							//echo 'Partial Check == ' . $yearMapp[ $fy ] . '<br/>';
						}
					}
				} else {
					if( isset( $xbrlData[ 'RevenueFromOperations' ] ) || isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) {
						$xmlParseData[ 'pl' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
						$addFlag = 1;
						//echo 'Field check == ' . $yearMapp[ $fy ] . '<br/>';
					}
				}
			}
			if( $bsloopCount > 0 ) {
				/*if( $fy == 2014 ) {
					echo '<pre>'; print_r( $bsArray ); echo '</pre>';
					echo '<pre>'; print_r( $xbrlData ); echo '</pre>';
				}*/
				if( array_key_exists( $fy, $previousData[ 'bs' ] ) ) {
					//echo 'Key check staisfied' . $bsloopCount . '<br/>';
					if( $previousData[ 'bs' ][ $fy ][ 'check' ] == 'Partial' && $yearMapp[ $fy ] == 'Full' ) {
						if( isset( $xbrlData[ 'ShareCapital' ] ) || isset( $xbrlData[ 'PaidupShareCapital' ] ) ) {
							$xmlParseData[ 'bs' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
							$addBSFlag = 1;
							//echo 'Partial Check == ' . $yearMapp[ $fy ] . '<br/>';
						}
					}
				} else {
					if( isset( $xbrlData[ 'ShareCapital' ] ) || isset( $xbrlData[ 'PaidupShareCapital' ] ) ) {
						$xmlParseData[ 'bs' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
						$addBSFlag = 1;
						//echo 'Field check == ' . $yearMapp[ $fy ] . '<br/>';
					}
				}	
			}
			if( $cfloopCount > 0 ) {
				/*if( $fy == 2014 ) {
					echo '<pre>'; print_r( $bsArray ); echo '</pre>';
					echo '<pre>'; print_r( $xbrlData ); echo '</pre>';
				}*/
				if( array_key_exists( $fy, $previousData[ 'cf' ] ) ) {
					//echo 'Key check staisfied' . $bsloopCount . '<br/>';
					if( $previousData[ 'cf' ][ $fy ][ 'check' ] == 'Partial' && $yearMapp[ $fy ] == 'Full' ) {
						if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] )) {
							$xmlParseData[ 'cf' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
							$addCFFlag = 1;
							//echo 'Partial Check == ' . $yearMapp[ $fy ] . '<br/>';
						}
					}
				} else {
					if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] )) {
						$xmlParseData[ 'cf' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
						$addCFFlag = 1;
						//echo 'Field check == ' . $yearMapp[ $fy ] . '<br/>';
					}
				}	
			}
			//echo $addFlag . ' ==== ' . $fy .'<br/>';
			// PL DATA STARTS
			$operationalIncome = $otherIncome = $totalIncome = $totalIncomeCheck = $expenses = $interest = $depreciation = $operationalAdminOtherExpenses = $operatingProfit = $EBITDA = $EBDT = $profitBeforePriorperiodItemsTax = $profitBeforeItemsTax = $EBTbeforeExceptionalItems = $priorPeriodExceptionalExtraOrdinaryItems = $tax = $EmployeeRelatedExpenses = $earningForeignExchange = $expenditureInForeignCurrency = $valueOfImportsOfRawMaterials = $outgoForeignExchange=$CostOfMaterialsConsumed = $PurchasesOfStockInTrade = $ChangesInInventories = $CSRExpenditure = $OtherExpenses = $CurrentTax = $DeferredTax = $PAT = $basicInINR = $dilutedInINR = $EBT = 0;

			// MI5-T384
			$ExpenditureOnProduction = 0;

			if( $addFlag > 0 ) {
				if( !isset( $xbrlData[ 'RevenueFromOperations' ] ) && !isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) { // XML support condition check with the XML field exists or not.
					$logs->logWrite( "FY".$fy . " - Error Xml not supported", true );
					$errorArray[ $cin ]['common'][$fy][] = "FY".$fy . " - Error Xml not supported";
					$errorReport++;
					return array( 'data' => array(), 'error' => $errorReport, 'error_array' => $errorArray  );
				}
				/*
					Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
					Given XML field isset condition checked and PL Context array condition is checked.
				*/
				for( $loopInc = 0; $loopInc < $loopCount; $loopInc++ ) {
					if( isset( $xbrlData[ 'RevenueFromOperations' ] ) ) {
						if( in_array( $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$operationalIncome = $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_value:' ];	
						}
					} else if( isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) {
						$xbrlData[ 'OperatingRevenueNet' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ];
						if( in_array( $xbrlData[ 'OperatingRevenueNet' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$operationalIncome = $xbrlData[ 'OperatingRevenueNet' ][ $loopInc ][ '_value:' ];	
						}
					}
					if( isset( $xbrlData[ 'OtherIncome' ] ) ) {
						if( in_array( $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$otherIncome = $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'Revenue' ] ) ) {
						if( in_array( $xbrlData[ 'Revenue' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$totalIncome = $xbrlData[ 'Revenue' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'TotalIncome' ] ) ) {
						if( in_array( $xbrlData[ 'TotalIncome' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$totalIncome = $xbrlData[ 'TotalIncome' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'Expenses' ] ) ) {
						if( in_array( $xbrlData[ 'Expenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$expenses = $xbrlData[ 'Expenses' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'TotalExpenditure' ] ) ) {
						if( in_array( $xbrlData[ 'TotalExpenditure' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$expenses = $xbrlData[ 'TotalExpenditure' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'FinanceCosts' ] ) ) {
						if( in_array( $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$interest = $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'InterestFinancialCharges' ] ) ) {
						if( in_array( $xbrlData[ 'InterestFinancialCharges' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$interest = $xbrlData[ 'InterestFinancialCharges' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ] ) ) {
						if( in_array( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$depreciation = $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'DepreciationAmortisationImpairment' ] ) ) {
						if( in_array( $xbrlData[ 'DepreciationAmortisationImpairment' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$depreciation = $xbrlData[ 'DepreciationAmortisationImpairment' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBTbeforeExceptionalItems = $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBTbeforeExceptionalItems = $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] ) ) {
						if( in_array( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBTbeforeExceptionalItems = $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ][ $loopInc ][ '_value:' ];
						}
					}

					if( isset( $xbrlData[ 'ProfitBeforeTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBT = $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'NetProfitLossbeforeTax' ] ) ) {
						if( in_array( $xbrlData[ 'NetProfitLossbeforeTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBT = $xbrlData[ 'NetProfitLossbeforeTax' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'TaxExpense' ] ) ) {
						if( in_array( $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$tax = $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'ProvisionTaxation' ] ) ) {
						if( in_array( $xbrlData[ 'ProvisionTaxation' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$tax = $xbrlData[ 'ProvisionTaxation' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'EmployeeBenefitExpense' ] ) ) {
						if( in_array( $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EmployeeRelatedExpenses = $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'EmployeeRelatedExpenses' ] ) ) {
						if( in_array( $xbrlData[ 'EmployeeRelatedExpenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EmployeeRelatedExpenses = $xbrlData[ 'EmployeeRelatedExpenses' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'EarningsInForeignCurrency' ] ) ) {
						if( in_array( $xbrlData[ 'EarningsInForeignCurrency' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$earningForeignExchange = $xbrlData[ 'EarningsInForeignCurrency' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ExpenditureInForeignCurrency' ] ) ) {
						if( in_array( $xbrlData[ 'ExpenditureInForeignCurrency' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$expenditureInForeignCurrency = $xbrlData[ 'ExpenditureInForeignCurrency' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ValueOfImportsCalculatedOnCIFBasis' ] ) ) {
						if( in_array( $xbrlData[ 'ValueOfImportsCalculatedOnCIFBasis' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$valueOfImportsOfRawMaterials = $xbrlData[ 'ValueOfImportsCalculatedOnCIFBasis' ][ $loopInc ][ '_value:' ];
						}
					}

					if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) ) { // XML Field CostOfMaterialsConsumed - PL OS
						if( in_array( $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$CostOfMaterialsConsumed = $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) ) { // XML Field PurchasesOfStockInTrade - PL OS
						if( in_array( $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$PurchasesOfStockInTrade = $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) ) { // XML Field ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade - PL OS
						if( in_array( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ChangesInInventories = $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CSRExpenditure' ] ) && $isCSRExpenditure == true ) { // XML Field CSRExpenditure - PL OS
						if( in_array( $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$CSRExpenditure = $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherExpenses' ] ) ) { // XML Field OtherExpenses - PL OS
						if( in_array( $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$OtherExpenses = $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ] ) ) { // XML Field OtherExpenses - PL OS
						if( in_array( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ExpenditureOnProduction = $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CurrentTax' ] ) ) { // XML Field CurrentTax - PL OS
						if( in_array( $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$CurrentTax = $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'DeferredTax' ] ) ) { // XML Field DeferredTax - PL OS
						if( in_array( $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$DeferredTax = $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_value:' ];
						}
					}

					if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) || isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) || 
						isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) || 
						isset( $xbrlData[ 'CSRExpenditure' ] ) || isset( $xbrlData[ 'OtherExpenses' ] ) || 
						isset( $xbrlData[ 'DeferredTax' ] ) || isset( $xbrlData[ 'CurrentTax' ] )) {
							$isXBRL2 = true;

					} else {
						$isXBRL2 = false;
					}
				}

				if( isset( $xbrlData[ 'ProfitLossForPeriod' ] ) ) {
					for( $profitLoassInc = 0; $profitLoassInc < count( $xbrlData[ 'ProfitLossForPeriod' ] ); $profitLoassInc++ ) {
						if( in_array( $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ] ) ) {
								if( !empty( $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_value:' ] ) ) {
									$PAT = $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				} else if( isset( $xbrlData[ 'NetProfitLoss' ] ) ) {
					for( $profitLoassInc = 0; $profitLoassInc < count( $xbrlData[ 'NetProfitLoss' ] ); $profitLoassInc++ ) {
						if( in_array( $xbrlData[ 'NetProfitLoss' ][ $profitLoassInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'NetProfitLoss' ][ $profitLoassInc ] ) ) {
								if( !empty( $xbrlData[ 'NetProfitLoss' ][ $profitLoassInc ][ '_value:' ] ) ) {
									$PAT = $xbrlData[ 'NetProfitLoss' ][ $profitLoassInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				if( isset( $xbrlData[ 'BasicEarningPerEquityShare' ] ) ) {
					for( $basicInc = 0; $basicInc < count( $xbrlData[ 'BasicEarningPerEquityShare' ] ); $basicInc++ ) {
						if( in_array( $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ] ) ) {
								if( !empty( $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ][ '_value:' ] ) ) {
									$basicInINR = $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				} else if( isset( $xbrlData[ 'BasicEarningsPerShare' ] ) ) {
					for( $basicInc = 0; $basicInc < count( $xbrlData[ 'BasicEarningsPerShare' ] ); $basicInc++ ) {
						if( in_array( $xbrlData[ 'BasicEarningsPerShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningsPerShare' ][ $basicInc ] ) ) {
								if( !empty( $xbrlData[ 'BasicEarningsPerShare' ][ $basicInc ][ '_value:' ] ) ) {
									$basicInINR = $xbrlData[ 'BasicEarningsPerShare' ][ $basicInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				if( isset( $xbrlData[ 'DilutedEarningsPerEquityShare' ] ) ) {
					for( $dilutedInc = 0; $dilutedInc < count( $xbrlData[ 'DilutedEarningsPerEquityShare' ] ); $dilutedInc++ ) {
						if( in_array( $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ] ) ) {
								if( !empty( $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ][ '_value:' ] ) ) {
									$dilutedInINR = $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				} else if( isset( $xbrlData[ 'DilutedEarningsPerShare' ] ) ) {
					for( $dilutedInc = 0; $dilutedInc < count( $xbrlData[ 'DilutedEarningsPerShare' ] ); $dilutedInc++ ) {
						if( in_array( $xbrlData[ 'DilutedEarningsPerShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsPerShare' ][ $dilutedInc ] ) ) {
								if( !empty( $xbrlData[ 'DilutedEarningsPerShare' ][ $dilutedInc ][ '_value:' ] ) ) {
									$dilutedInINR = $xbrlData[ 'DilutedEarningsPerShare' ][ $dilutedInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}

				if( !empty( $interest ) || !empty( $depreciation ) || !empty( $expenses ) ) {
					if( empty( $interest ) ) {
						$interest = 0;
					}
					if( empty( $depreciation ) ) {
						$depreciation = 0;
					}
					$operationalAdminOtherExpenses = $expenses - $interest - $depreciation;
				}
				if( !empty( $operationalIncome ) || ( !empty( $operationalAdminOtherExpenses ) ) ) {
					$operatingProfit = $operationalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $totalIncome ) || !empty( $operationalAdminOtherExpenses ) ) {
					$EBITDA = $totalIncome - $operationalAdminOtherExpenses;
				}
				$totalIncomeCheck = $operationalIncome + $otherIncome;
				if( $totalIncome != $totalIncomeCheck ) {
					$operationalIncome = $totalIncome - $otherIncome;
				}
				if( !empty( $EBITDA ) || !empty( $interest ) ) {
					$EBDT = $EBITDA - $interest;
				}
				$OtherExpenses = $OtherExpenses + $ExpenditureOnProduction;
				$priorPeriodExceptionalExtraOrdinaryItems = $EBTbeforeExceptionalItems - $EBT;
				$outgoForeignExchange = $expenditureInForeignCurrency + $valueOfImportsOfRawMaterials;
				// Empty check and Reassign
				if( ( empty( $operationalIncome ) || $operationalIncome == 0 ) && 
					( empty( $otherIncome ) || $otherIncome == 0 ) && 
					( empty( $totalIncome ) || $totalIncome == 0 ) && 
					( empty( $CostOfMaterialsConsumed ) || $CostOfMaterialsConsumed == 0 ) && 
					( empty( $PurchasesOfStockInTrade ) || $PurchasesOfStockInTrade == 0 ) &&
					( empty( $ChangesInInventories ) || $ChangesInInventories == 0 ) &&
					( empty( $CSRExpenditure ) || $CSRExpenditure == 0 ) &&
					( empty( $OtherExpenses ) || $OtherExpenses == 0 ) &&
					( empty( $CurrentTax ) || $CurrentTax == 0 ) && 
					( empty( $DeferredTax ) || $DeferredTax == 0 ) &&
					( empty( $operationalAdminOtherExpenses ) || $operationalAdminOtherExpenses == 0 ) && 
					( empty( $operatingProfit ) || $operatingProfit == 0 ) && 
					( empty( $EBITDA ) || $EBITDA == 0 ) && 
					( empty( $interest ) || $interest == 0 ) && 
					( empty( $EBDT ) || $EBDT == 0 ) && 
					( empty( $depreciation ) || $depreciation == 0 ) && 
					( empty( $EBTbeforeExceptionalItems ) || $EBTbeforeExceptionalItems == 0 ) && 
					( empty( $priorPeriodExceptionalExtraOrdinaryItems ) || $priorPeriodExceptionalExtraOrdinaryItems == 0 ) && 
					( empty( $EBT ) || $EBT == 0 ) && 
					( empty( $tax ) || $tax == 0 ) && 
					( empty( $PAT ) || $PAT == 0 ) && 
					( empty( $basicInINR ) || $basicInINR == 0 ) && 
					( empty( $dilutedInINR ) || $dilutedInINR == 0 ) && 
					( empty( $EmployeeRelatedExpenses ) || $EmployeeRelatedExpenses == 0 ) && 
					( empty( $earningForeignExchange ) || $earningForeignExchange == 0 ) && 
					( empty( $outgoForeignExchange ) || $outgoForeignExchange == 0 ) ) {
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Operational Income' ] ) ) {
						$operationalIncome = $previousData[ 'pl' ][ $fy ][ 'Operational Income' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Other Income' ] ) ) {
						$otherIncome = $previousData[ 'pl' ][ $fy ][ 'Other Income' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Total Income' ] ) ) {
						$totalIncome = $previousData[ 'pl' ][ $fy ][ 'Total Income' ];	
					}

					if( isset( $previousData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ] ) ) {
						$CostOfMaterialsConsumed = $previousData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ] ) ) {
						$PurchasesOfStockInTrade = $previousData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'Changes In Inventories' ] ) ) {
						$ChangesInInventories = $previousData[ 'pl' ][ $fy ][ 'Changes In Inventories' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'CSR Expenditure' ] ) ) {
						$CSRExpenditure = $previousData[ 'pl' ][ $fy ][ 'CSR Expenditure' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'Other Expenses' ] ) ) {
						$OtherExpenses = $previousData[ 'pl' ][ $fy ][ 'Other Expenses' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ] ) ) {
						$operationalAdminOtherExpenses = $previousData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Operating Profit' ] ) ) {
						$operatingProfit = $previousData[ 'pl' ][ $fy ][ 'Operating Profit' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBITDA' ] ) ) {
						$EBITDA = $previousData[ 'pl' ][ $fy ][ 'EBITDA' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Interest' ] ) ) {
						$interest = $previousData[ 'pl' ][ $fy ][ 'Interest' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBDT' ] ) ) {
						$EBDT = $previousData[ 'pl' ][ $fy ][ 'EBDT' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Depreciation' ] ) ) {
						$depreciation = $previousData[ 'pl' ][ $fy ][ 'Depreciation' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ] ) ) {
						$EBTbeforeExceptionalItems = $previousData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ] ) ) {
						$priorPeriodExceptionalExtraOrdinaryItems = $previousData[ 'bs' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBT' ] ) ) {
						$EBT = $previousData[ 'pl' ][ $fy ][ 'EBT' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'CurrentTax' ] ) ) {
						$CurrentTax = $previousData[ 'pl' ][ $fy ][ 'CurrentTax' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'DeferredTax' ] ) ) {
						$DeferredTax = $previousData[ 'pl' ][ $fy ][ 'DeferredTax' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Tax' ] ) ) {
						$tax = $previousData[ 'pl' ][ $fy ][ 'Tax' ];	
					}
					
					if( isset( $previousData[ 'pl' ][ $fy ][ 'PAT' ] ) ) {
						$PAT = $previousData[ 'pl' ][ $fy ][ 'PAT' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ '(Basic in INR)' ] ) ) {
						$basicInINR = $previousData[ 'pl' ][ $fy ][ '(Basic in INR)' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ '(Diluted in INR)' ] ) ) {
						$dilutedInINR = $previousData[ 'pl' ][ $fy ][ '(Diluted in INR)' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ] ) ) {
						$EmployeeRelatedExpenses = $previousData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ] ) ) {
						$earningForeignExchange = $previousData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ] ) ) {
						$outgoForeignExchange = $previousData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ];	
					}
				}
				// Validation given in google sheet is added.
				/*if( ( $PAT < 0 && ( $basicInINR >= 0 || $dilutedInINR >= 0 ) ) || ( $PAT >= 0 && ( $basicInINR < 0 || $dilutedInINR < 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) ) {
					$logs->logWrite( $fy . " - PAT, EPS mismatch" );
					$errorArray[ $cin ]['pl'][$fy][] = $fy . " - PAT, EPS mismatch";
					$errorReport++;
				}*/ // VI team asked to hide this condition.
				//if( $EBITDA < $EBDT || $EBDT < $EBTbeforeExceptionalItems ) { // Updated On 20-05-2019 For MI5-T226
				if( ((int)$EBITDA < (int)$EBDT) || ((int)$EBDT < (int)$EBTbeforeExceptionalItems) ) {
					$errorArray[ $cin ]['pl'][$fy][] = "FY".$fy . " - EBITDA, EBDT, EBT mismatch";
					$errorReport++;
				}
				// XML parsed data assigned to variable which will be sent to excel file generation.
				/*if( $fy == '2015' || $fy == '2016' ) {
					echo $fy . ' === ' . $otherIncome . '<br/>';
				}*/
				$Insert_XBRL2['isXBRL'] = $isXBRL2;
				if( ( empty( $operationalIncome ) || $operationalIncome == 0 ) && 
					( empty( $otherIncome ) || $otherIncome == 0 ) && 
					( empty( $totalIncome ) || $totalIncome == 0 ) && 
					( empty( $CostOfMaterialsConsumed ) || $CostOfMaterialsConsumed == 0 ) && 
					( empty( $PurchasesOfStockInTrade ) || $PurchasesOfStockInTrade == 0 ) &&
					( empty( $ChangesInInventories ) || $ChangesInInventories == 0 ) &&
					( empty( $CSRExpenditure ) || $CSRExpenditure == 0 ) &&
					( empty( $OtherExpenses ) || $OtherExpenses == 0 ) &&
					( empty( $CurrentTax ) || $CurrentTax == 0 ) && 
					( empty( $DeferredTax ) || $DeferredTax == 0 ) &&
					( empty( $operationalAdminOtherExpenses ) || $operationalAdminOtherExpenses == 0 ) && 
					( empty( $operatingProfit ) || $operatingProfit == 0 ) && 
					( empty( $EBITDA ) || $EBITDA == 0 ) && 
					( empty( $interest ) || $interest == 0 ) && 
					( empty( $EBDT ) || $EBDT == 0 ) && 
					( empty( $depreciation ) || $depreciation == 0 ) && 
					( empty( $EBTbeforeExceptionalItems ) || $EBTbeforeExceptionalItems == 0 ) && 
					( empty( $priorPeriodExceptionalExtraOrdinaryItems ) || $priorPeriodExceptionalExtraOrdinaryItems == 0 ) && 
					( empty( $EBT ) || $EBT == 0 ) && 
					( empty( $tax ) || $tax == 0 ) && 
					( empty( $PAT ) || $PAT == 0 ) && 
					( empty( $basicInINR ) || $basicInINR == 0 ) && 
					( empty( $dilutedInINR ) || $dilutedInINR == 0 ) && 
					( empty( $EmployeeRelatedExpenses ) || $EmployeeRelatedExpenses == 0 ) && 
					( empty( $earningForeignExchange ) || $earningForeignExchange == 0 ) && 
					( empty( $outgoForeignExchange ) || $outgoForeignExchange == 0 ) ) {
					// Unset the FY data if condition failed. remove curresponding FY error data.
					unset( $xmlParseData[ 'pl' ][ $fy ] );
					$errorReport = $errorReport - count( $errorArray[ $cin ]['pl'][$fy] );
					unset( $errorArray[ $cin ]['pl'][$fy] );
				} else {
					$xmlParseData[ 'pl' ][ $fy ][ 'Operational Income' ] = $operationalIncome;
					$xmlParseData[ 'pl' ][ $fy ][ 'Other Income' ] = $otherIncome;
					$xmlParseData[ 'pl' ][ $fy ][ 'Total Income' ] = $totalIncome;
					$xmlParseData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ] = $CostOfMaterialsConsumed;
					$xmlParseData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ] = $PurchasesOfStockInTrade;
					$xmlParseData[ 'pl' ][ $fy ][ 'Changes In Inventories' ] = $ChangesInInventories;
					$xmlParseData[ 'pl' ][ $fy ][ 'CSR Expenditure' ] = $CSRExpenditure;
					$xmlParseData[ 'pl' ][ $fy ][ 'Other Expenses' ] = $OtherExpenses;
					$xmlParseData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ] = $operationalAdminOtherExpenses;
					$xmlParseData[ 'pl' ][ $fy ][ 'Operating Profit' ] = $operatingProfit;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBITDA' ] = $EBITDA;
					$xmlParseData[ 'pl' ][ $fy ][ 'Interest' ] = $interest;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBDT' ] = $EBDT;
					$xmlParseData[ 'pl' ][ $fy ][ 'Depreciation' ] = $depreciation;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ] = $EBTbeforeExceptionalItems;
					$xmlParseData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ] = $priorPeriodExceptionalExtraOrdinaryItems;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBT' ] = $EBT;
					$xmlParseData[ 'pl' ][ $fy ][ 'CurrentTax' ] = $CurrentTax;
				    $xmlParseData[ 'pl' ][ $fy ][ 'DeferredTax' ] = $DeferredTax;
					$xmlParseData[ 'pl' ][ $fy ][ 'Tax' ] = $tax;
					$xmlParseData[ 'pl' ][ $fy ][ 'PAT' ] = $PAT;
					$xmlParseData[ 'pl' ][ $fy ][ '(Basic in INR)' ] = $basicInINR;
					$xmlParseData[ 'pl' ][ $fy ][ '(Diluted in INR)' ] = $dilutedInINR;
					$xmlParseData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ] = $EmployeeRelatedExpenses;
					$xmlParseData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ] = $earningForeignExchange;
					$xmlParseData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ] = $outgoForeignExchange;
					foreach( $errorArray[ $cin ]['pl'][$fy] as $pltext ) {
						$logs->logWrite( $pltext, true );
					}
				}

				//echo '<pre>'; print_r( $xmlParseData[ 'pl' ] ); echo '</pre>';

				// Code after hiding the conditions
				//If( empty )
			}

			if( $addBSFlag > 0 ) {
				//BS DATA STARTS
				$ShareCapital = $ReservesandSurplus = $TotalShareholdersFunds = $ShareApplicationMoney = $LongtermBorrowings = $DeferredTaxLiabilities = $OtherLongTermLiabilities = $LongTermProvisions = $TotalNonCurrentLiabilitiesCheck = $TotalNonCurrentLiabilities = $ShortTermBorrowings = $TradePayable = $OtherCurrFinancialLiabilities = $OtherCurrentLiabilities = $ShortTermProvisions = $TotalCurrentLiabilitiesCheck = $TotalCurrentLiabilities = $TotalEquityAndLiabilitiesCheck = $TotalEquityAndLiabilities = $tangibleAssetsCapitalWorkInProgress = $TotalFixedAssets = $LongTermLoansAndAdvances = $OtherNonCurrentAssets = $TotalNonCurrentAssets = $CurrentInvestments = $CashandBankBalances = $ShortTermLoansAdvances = $OtherCurrentAssets = $TotalCurrentAssets = $TotalAssets = $TangibleAss = $TangibleAssets = $IntangibleAssets = $NoncurrentInvestments = $Inventories = $TradeReceivables = $DeferredTaxAssets = $TotalNonCurrentAssetsCheck = $TotalCurrentAssetsCheck = $TotalAssetsCheck = $TradePayable = $TotalShareholdersFundsCheck = $diffTotalShareholdersFunds = $diffTotalCurrentLiabilities = $diffTotalEquityAndLiabilities = $diffTotalNonCurrentAssets = $diffTotalCurrentAssets = $diffTotalAssets = $IntangibleAss = $IntangibleAssetsUnderDevelopmentOrWorkInProgress = $DeferredGovernmentGrants = $OtherLongTermLiabils = $NonCurrentLiabilities = $MoneyReceivedAgainstShareWarrants = $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = 0;
				if( isset( $xbrlData[ 'ShareCapital' ] ) ) {
					$shareLoop = count( $xbrlData[ 'ShareCapital' ] );
				} else {
					$shareLoop = count( $xbrlData[ 'PaidupShareCapital' ] );
				}
				/*
					Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
					Given XML field isset condition checked and PL Context array condition is checked.
				*/
				for( $equityshareInc = 0; $equityshareInc < $shareLoop; $equityshareInc++ ) {
					if( isset( $xbrlData[ 'ShareCapital' ] ) ) {
						if( in_array( $xbrlData[ 'ShareCapital' ][ $equityshareInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ShareCapital' ][ $equityshareInc ] ) ) {
								$ShareCapital = $xbrlData[ 'ShareCapital' ][ $equityshareInc ][ '_value:' ];
								break;	
							}
						}
					} else if( isset( $xbrlData[ 'PaidupShareCapital' ] ) ) {
						if( in_array( $xbrlData[ 'PaidupShareCapital' ][ $equityshareInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'PaidupShareCapital' ][ $equityshareInc ] ) ) {
								$ShareCapital = $xbrlData[ 'PaidupShareCapital' ][ $equityshareInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $bsloopInc = 0; $bsloopInc < $bsloopCount; $bsloopInc++ ) {
					if( isset( $xbrlData[ 'ReservesAndSurplus' ] ) ) {
						if( in_array( $xbrlData[ 'ReservesAndSurplus' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ReservesandSurplus = $xbrlData[ 'ReservesAndSurplus' ][ $bsloopInc ][ '_value:' ];
						}
					} /*else if( isset( $xbrlData[ 'ReservesSurplus' ] ) ) {
						if( in_array( $xbrlData[ 'ReservesSurplus' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ReservesandSurplus = $xbrlData[ 'ReservesSurplus' ][ $bsloopInc ][ '_value:' ];
						}
					}*/
					if( isset( $xbrlData[ 'ShareholdersFunds' ] ) ) {
						if( in_array( $xbrlData[ 'ShareholdersFunds' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalShareholdersFunds = $xbrlData[ 'ShareholdersFunds' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShareApplicationMoneyPendingAllotment' ] ) ) {
						if( in_array( $xbrlData[ 'ShareApplicationMoneyPendingAllotment' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShareApplicationMoney = $xbrlData[ 'ShareApplicationMoneyPendingAllotment' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'LongTermBorrowings' ] ) ) {
						if( in_array( $xbrlData[ 'LongTermBorrowings' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$LongtermBorrowings = $xbrlData[ 'LongTermBorrowings' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'DeferredTaxLiabilitiesNet' ] ) ) {
						if( in_array( $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$DeferredTaxLiabilities = $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherLongTermLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'OtherLongTermLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherLongTermLiabils = $xbrlData[ 'OtherLongTermLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'LongTermProvisions' ] ) ) {
						if( in_array( $xbrlData[ 'LongTermProvisions' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$LongTermProvisions = $xbrlData[ 'LongTermProvisions' ][ $bsloopInc ][ '_value:' ];
						}
					}
					
					if( isset( $xbrlData[ 'NoncurrentLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$NonCurrentLiabilities = $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShortTermBorrowings' ] ) ) {
						if( in_array( $xbrlData[ 'ShortTermBorrowings' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShortTermBorrowings = $xbrlData[ 'ShortTermBorrowings' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'TradePayables' ] ) ) {
						if( in_array( $xbrlData[ 'TradePayables' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TradePayable = $xbrlData[ 'TradePayables' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherCurrentLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherCurrentLiabilities = $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShortTermProvisions' ] ) ) {
						if( in_array( $xbrlData[ 'ShortTermProvisions' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShortTermProvisions = $xbrlData[ 'ShortTermProvisions' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CurrentLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalCurrentLiabilities = $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'EquityAndLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalEquityAndLiabilities = $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ] ) ) {
						if( in_array( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$tangibleAssetsCapitalWorkInProgress = $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'FixedAssets' ] ) ) {
						if( in_array( $xbrlData[ 'FixedAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalFixedAssets = $xbrlData[ 'FixedAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'LongTermLoansAndAdvances' ] ) ) {
						if( in_array( $xbrlData[ 'LongTermLoansAndAdvances' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$LongTermLoansAndAdvances = $xbrlData[ 'LongTermLoansAndAdvances' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherNoncurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherNonCurrentAssets = $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'NoncurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalNonCurrentAssets = $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashAndBankBalances' ] ) ) {
						if( in_array( $xbrlData[ 'CashAndBankBalances' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$CashandBankBalances = $xbrlData[ 'CashAndBankBalances' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShortTermLoansAndAdvances' ] ) ) {
						if( in_array( $xbrlData[ 'ShortTermLoansAndAdvances' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShortTermLoansAdvances = $xbrlData[ 'ShortTermLoansAndAdvances' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherCurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherCurrentAssets = $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalCurrentAssets = $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'Assets' ] ) ) {
						if( in_array( $xbrlData[ 'Assets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalAssets = $xbrlData[ 'Assets' ][ $bsloopInc ][ '_value:' ];
						}
					}
				}

				for( $currentInvInc = 0; $currentInvInc < count( $xbrlData[ 'CurrentInvestments' ] ); $currentInvInc++ ) {
					if( isset( $xbrlData[ 'CurrentInvestments' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ] ) ) {
								if( !empty( $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ][ '_value:' ] ) ) {
									$CurrentInvestments = $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}

				for( $tangibleAssInc = 0; $tangibleAssInc < count( $xbrlData[ 'TangibleAssets' ] ); $tangibleAssInc++ ) {
					if( isset( $xbrlData[ 'TangibleAssets' ] ) ) {
						if( in_array( $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ] ) ) {
								if( !empty( $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ][ '_value:' ] ) ) {
									$TangibleAss = $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				$TangibleAssets = $TangibleAss + $tangibleAssetsCapitalWorkInProgress;
				for( $intangibleInc = 0; $intangibleInc < count( $xbrlData[ 'IntangibleAssets' ] ); $intangibleInc++ ) {
					if( isset( $xbrlData[ 'IntangibleAssets' ] ) ) {
						if( in_array( $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ] ) ) {
								if( !empty( $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ][ '_value:' ] ) ) {
									$IntangibleAss = $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				for( $intassunderdevInc = 0; $intassunderdevInc < count( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ); $intassunderdevInc++ ) {
					if( isset( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ) ) {
						if( in_array( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intassunderdevInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intassunderdevInc ] ) ) {
								if( !empty( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intassunderdevInc ][ '_value:' ] ) ) {
									$IntangibleAssetsUnderDevelopmentOrWorkInProgress = $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intassunderdevInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				$IntangibleAssets  = $IntangibleAss + $IntangibleAssetsUnderDevelopmentOrWorkInProgress;
				for( $noncurinvInc = 0; $noncurinvInc < count( $xbrlData[ 'NoncurrentInvestments' ] ); $noncurinvInc++ ) {
					if( isset( $xbrlData[ 'NoncurrentInvestments' ] ) ) {
						if( in_array( $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ] ) ) {
								if( !empty( $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_value:' ] ) ) {
									$NoncurrentInvestments = $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}
				for( $inventoriesInc = 0; $inventoriesInc < count( $xbrlData[ 'Inventories' ] ); $inventoriesInc++ ) {
					if( isset( $xbrlData[ 'Inventories' ] ) ) {
						if( in_array( $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'Inventories' ][ $inventoriesInc ] ) ) {
								if( !empty( $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_value:' ] ) ) {
									$Inventories = $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_value:' ];	
									break;
								}
							}
						}
					}
				}
				for( $tradeReceivesInc = 0; $tradeReceivesInc < count( $xbrlData[ 'TradeReceivables' ] ); $tradeReceivesInc++ ) {
					if( isset( $xbrlData[ 'TradeReceivables' ] ) ) {
						if( in_array( $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ] ) ) {
								if( !empty( $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ][ '_value:' ] ) ) {
									$TradeReceivables = $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}
				for( $deferredtaxassInc = 0; $deferredtaxassInc < count( $xbrlData[ 'DeferredTaxAssetsNet' ] ); $deferredtaxassInc++ ) {
					if( isset( $xbrlData[ 'DeferredTaxAssetsNet' ] ) ) {
						if( in_array( $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ] ) ) {
								if( !empty( $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ][ '_value:' ] ) ) {
									$DeferredTaxAssets = $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}
				for( $deferredgovgrantsinc = 0; $deferredgovgrantsinc < count( $xbrlData[ 'DeferredGovernmentGrants' ] ); $deferredgovgrantsinc++ ) {
					if( isset( $xbrlData[ 'DeferredGovernmentGrants' ] ) ) {
						if( in_array( $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovgrantsinc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovgrantsinc ] ) ) {
								if( !empty( $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovgrantsinc ][ '_value:' ] ) ) {
									$DeferredGovernmentGrants = $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovgrantsinc ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}

				// Field matching document 2.5.3
				for( $moneyrecagainshareWar = 0; $moneyrecagainshareWar < count( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ); $moneyrecagainshareWar++ ) {
					if( isset( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ) ) {
						if( in_array( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyrecagainshareWar ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyrecagainshareWar ] ) ) {
								if( !empty( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyrecagainshareWar ][ '_value:' ] ) ) {
									$MoneyReceivedAgainstShareWarrants = $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyrecagainshareWar ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}
				for( $foreignCurrMontTransdiffacc = 0; $foreignCurrMontTransdiffacc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ); $foreignCurrMontTransdiffacc++ ) {
					if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ) ) {
						if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMontTransdiffacc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMontTransdiffacc ] ) ) {
								if( !empty( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMontTransdiffacc ][ '_value:' ] ) ) {
									$ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $foreignCurrMontTransdiffacc ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}
				for( $foreignCurrMontTrnsDiffAssetAcc = 0; $foreignCurrMontTrnsDiffAssetAcc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ); $foreignCurrMontTrnsDiffAssetAcc++ ) {
					if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ) ) {
						if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignCurrMontTrnsDiffAssetAcc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignCurrMontTrnsDiffAssetAcc ] ) ) {
								if( !empty( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignCurrMontTrnsDiffAssetAcc ][ '_value:' ] ) ) {
									$ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $foreignCurrMontTrnsDiffAssetAcc ][ '_value:' ];
									break;	
								}
							}
						}
					}
				}
				
				
				$ReservesandSurplus = $ReservesandSurplus + $MoneyReceivedAgainstShareWarrants;
				$OtherNonCurrentAssets = $OtherNonCurrentAssets + $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount;
				// End of field matching document 2.5.3

				$OtherLongTermLiabilities = $OtherLongTermLiabils + $DeferredGovernmentGrants + $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount;
				$TotalNonCurrentLiabilities = $NonCurrentLiabilities + $DeferredGovernmentGrants;

				// Reverting data to previous if not found
				if( ( empty( $ShareCapital ) || $ShareCapital == 0 ) && ( empty( $ReservesandSurplus ) || $ReservesandSurplus == 0 ) && ( empty( $TotalShareholdersFunds ) || $TotalShareholdersFunds == 0 ) && ( empty( $ShareApplicationMoney ) || $ShareApplicationMoney == 0 ) && 
					( empty( $LongtermBorrowings ) || $LongtermBorrowings == 0 ) && ( empty( $DeferredTaxLiabilities ) || $DeferredTaxLiabilities == 0 ) && ( empty( $OtherLongTermLiabilities ) || $OtherLongTermLiabilities == 0 ) && ( empty( $LongTermProvisions ) || $LongTermProvisions == 0 ) && 
					( empty( $TotalNonCurrentLiabilities ) || $TotalNonCurrentLiabilities == 0 ) && ( empty( $ShortTermBorrowings ) || $ShortTermBorrowings == 0 ) && ( empty( $TradePayable ) || $TradePayable == 0 ) && ( empty( $OtherCurrentLiabilities ) || $OtherCurrentLiabilities == 0 ) && 
					( empty( $ShortTermProvisions ) || $ShortTermProvisions == 0 ) && ( empty( $TotalCurrentLiabilities ) || $TotalCurrentLiabilities == 0 ) && ( empty( $TotalEquityAndLiabilities ) || $TotalEquityAndLiabilities == 0 ) && ( empty( $TangibleAssets ) || $TangibleAssets == 0 ) && 
					( empty( $IntangibleAssets ) || $IntangibleAssets == 0 ) && ( empty( $TotalFixedAssets ) || $TotalFixedAssets == 0 ) && ( empty( $NoncurrentInvestments ) || $NoncurrentInvestments == 0 ) && ( empty( $DeferredTaxAssets ) || $DeferredTaxAssets == 0 ) && 
					( empty( $LongTermLoansAndAdvances ) || $LongTermLoansAndAdvances == 0 ) && ( empty( $OtherNonCurrentAssets ) || $OtherNonCurrentAssets == 0 ) && ( empty( $TotalNonCurrentAssets ) || $TotalNonCurrentAssets == 0 ) && ( empty( $CurrentInvestments ) || $CurrentInvestments == 0 ) && 
					( empty( $Inventories ) || $Inventories == 0 ) && ( empty( $TradeReceivables ) || $TradeReceivables == 0 ) && ( empty( $CashandBankBalances ) || $CashandBankBalances == 0 ) && ( empty( $ShortTermLoansAdvances ) || $ShortTermLoansAdvances == 0 ) && 
					( empty( $OtherCurrentAssets ) || $OtherCurrentAssets == 0 ) && ( empty( $TotalCurrentAssets ) || $TotalCurrentAssets == 0 ) && ( empty( $TotalAssets ) || $TotalAssets == 0 ) ) {
					
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Share capital' ] ) ) {
						$ShareCapital = $previousData[ 'bs' ][ $fy ][ 'Share capital' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Reserves and surplus' ] ) ) {
						$ReservesandSurplus = $previousData[ 'bs' ][ $fy ][ 'Reserves and surplus' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total shareholders funds' ] ) ) {
						$TotalShareholdersFunds = $previousData[ 'bs' ][ $fy ][ 'Total shareholders funds' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ] ) ) {
						$ShareApplicationMoney = $previousData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Long-term borrowings' ] ) ) {
						$LongtermBorrowings = $previousData[ 'bs' ][ $fy ][ 'Long-term borrowings' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ] ) ) {
						$DeferredTaxLiabilities = $previousData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ] ) ) {
						$OtherLongTermLiabilities = $previousData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Long-term provisions' ] ) ) {
						$LongTermProvisions = $previousData[ 'bs' ][ $fy ][ 'Long-term provisions' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ] ) ) {
						$TotalNonCurrentLiabilities = $previousData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Short-term borrowings' ] ) ) {
						$ShortTermBorrowings = $previousData[ 'bs' ][ $fy ][ 'Short-term borrowings' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Trade payables' ] ) ) {
						$TradePayable = $previousData[ 'bs' ][ $fy ][ 'Trade payables' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other current liabilities' ] ) ) {
						$OtherCurrentLiabilities = $previousData[ 'bs' ][ $fy ][ 'Other current liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Short-term provisions' ] ) ) {
						$ShortTermProvisions = $previousData[ 'bs' ][ $fy ][ 'Short-term provisions' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total current liabilities' ] ) ) {
						$TotalCurrentLiabilities = $previousData[ 'bs' ][ $fy ][ 'Total current liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ] ) ) {
						$TotalEquityAndLiabilities = $previousData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Tangible assets' ] ) ) {
						$TangibleAssets = $previousData[ 'bs' ][ $fy ][ 'Tangible assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Intangible assets' ] ) ) {
						$IntangibleAssets = $previousData[ 'bs' ][ $fy ][ 'Intangible assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total fixed assets' ] ) ) {
						$TotalFixedAssets = $previousData[ 'bs' ][ $fy ][ 'Total fixed assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Non-current investments' ] ) ) {
						$NoncurrentInvestments = $previousData[ 'bs' ][ $fy ][ 'Non-current investments' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ] ) ) {
						$DeferredTaxAssets = $previousData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ] ) ) {
						$LongTermLoansAndAdvances = $previousData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other non-current assets' ] ) ) {
						$OtherNonCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Other non-current assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total non-current assets' ] ) ) {
						$TotalNonCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Total non-current assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Current investments' ] ) ) {
						$CurrentInvestments = $previousData[ 'bs' ][ $fy ][ 'Current investments' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Inventories' ] ) ) {
						$Inventories = $previousData[ 'bs' ][ $fy ][ 'Inventories' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Trade receivables' ] ) ) {
						$TradeReceivables = $previousData[ 'bs' ][ $fy ][ 'Trade receivables' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Cash and bank balances' ] ) ) {
						$CashandBankBalances = $previousData[ 'bs' ][ $fy ][ 'Cash and bank balances' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ] ) ) {
						$ShortTermLoansAdvances = $previousData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other current assets' ] ) ) {
						$OtherCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Other current assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total current assets' ] ) ) {
						$TotalCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Total current assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total assets' ] ) ) {
						$TotalAssets = $previousData[ 'bs' ][ $fy ][ 'Total assets' ];	
					}
				}

				$TotalNonCurrentLiabilitiesCheck = $LongtermBorrowings + $DeferredTaxLiabilities + $OtherLongTermLiabilities + $LongTermProvisions;
				$TotalCurrentLiabilitiesCheck = $ShortTermBorrowings + $TradePayable + $OtherCurrentLiabilities + $ShortTermProvisions;
				$TotalEquityAndLiabilitiesCheck = $TotalCurrentLiabilities + $TotalNonCurrentLiabilities + $ShareApplicationMoney + $TotalShareholdersFunds;
				$TotalNonCurrentAssetsCheck = $TotalFixedAssets + $NoncurrentInvestments + $DeferredTaxAssets + $LongTermLoansAndAdvances + $OtherNonCurrentAssets;
				$TotalCurrentAssetsCheck = $CurrentInvestments + $Inventories + $TradeReceivables + $CashandBankBalances + $ShortTermLoansAdvances + $OtherCurrentAssets;
				$TotalAssetsCheck = $TotalCurrentAssets + $TotalNonCurrentAssets;

				// Validation given in google sheet is added.
				$TotalShareholdersFundsCheck = $ShareCapital + $ReservesandSurplus;
				$diffTotalShareholdersFunds = $TotalShareholdersFunds - $TotalShareholdersFundsCheck;
				if( $TotalShareholdersFunds != $TotalShareholdersFundsCheck ) {
					if( abs( $diffTotalShareholdersFunds ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total shareholders' funds mismatch";
						$errorReport++;
					}
				}
				$diffTotalNonCurrentLiabilities = $TotalNonCurrentLiabilities - $TotalNonCurrentLiabilitiesCheck;
				if( $TotalNonCurrentLiabilities != $TotalNonCurrentLiabilitiesCheck ) {
					if( abs( $diffTotalNonCurrentLiabilities ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total Non-Current Liabilites mismatch";
						$errorReport++;
					}
				}
				$diffTotalCurrentLiabilities = $TotalCurrentLiabilities - $TotalCurrentLiabilitiesCheck;
				if( $TotalCurrentLiabilities != $TotalCurrentLiabilitiesCheck ) {
					if( abs( $diffTotalCurrentLiabilities ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total Current Liabilites mismatch";
						$errorReport++;
					}
				}
				$diffTotalEquityAndLiabilities = $TotalEquityAndLiabilities - $TotalEquityAndLiabilitiesCheck;
				if( $TotalEquityAndLiabilities != $TotalEquityAndLiabilitiesCheck ) {
					if( abs( $diffTotalEquityAndLiabilities ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total equity and liabilities mismatch";
						$errorReport++;
					}
				}
				$diffTotalNonCurrentAssets = $TotalNonCurrentAssets - $TotalNonCurrentAssetsCheck;
				if( $TotalNonCurrentAssets != $TotalNonCurrentAssetsCheck ) {
					if( abs( $diffTotalNonCurrentAssets ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total non-current assets mismatch";
						$errorReport++;
					}
				}
				$diffTotalCurrentAssets = $TotalCurrentAssets - $TotalCurrentAssetsCheck;
				if( $TotalCurrentAssets != $TotalCurrentAssetsCheck ) {
					if( abs( $diffTotalCurrentAssets ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total current assets mismatch";
						$errorReport++;
					}
				}
				$diffTotalAssets = $TotalAssets - $TotalAssetsCheck;
				if( $TotalAssets != $TotalAssetsCheck ) {
					if( abs( $diffTotalAssets ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total assets mismatch";
						$errorReport++;
					}
				}
				// XML parsed data assigned to variable which will be sent to excel file generation.
				if( ( ( empty( $ShareCapital ) || $ShareCapital == 0 ) && ( empty( $ReservesandSurplus ) || $ReservesandSurplus == 0 ) && ( empty( $TotalShareholdersFunds ) || $TotalShareholdersFunds == 0 ) && ( empty( $ShareApplicationMoney ) || $ShareApplicationMoney == 0 ) && 
					( empty( $LongtermBorrowings ) || $LongtermBorrowings == 0 ) && ( empty( $DeferredTaxLiabilities ) || $DeferredTaxLiabilities == 0 ) && ( empty( $OtherLongTermLiabilities ) || $OtherLongTermLiabilities == 0 ) && ( empty( $LongTermProvisions ) || $LongTermProvisions == 0 ) && 
					( empty( $TotalNonCurrentLiabilities ) || $TotalNonCurrentLiabilities == 0 ) && ( empty( $ShortTermBorrowings ) || $ShortTermBorrowings == 0 ) && ( empty( $TradePayable ) || $TradePayable == 0 ) && ( empty( $OtherCurrentLiabilities ) || $OtherCurrentLiabilities == 0 ) && 
					( empty( $ShortTermProvisions ) || $ShortTermProvisions == 0 ) && ( empty( $TotalCurrentLiabilities ) || $TotalCurrentLiabilities == 0 ) && ( empty( $TotalEquityAndLiabilities ) || $TotalEquityAndLiabilities == 0 ) && ( empty( $TangibleAssets ) || $TangibleAssets == 0 ) && 
					( empty( $IntangibleAssets ) || $IntangibleAssets == 0 ) && ( empty( $TotalFixedAssets ) || $TotalFixedAssets == 0 ) && ( empty( $NoncurrentInvestments ) || $NoncurrentInvestments == 0 ) && ( empty( $DeferredTaxAssets ) || $DeferredTaxAssets == 0 ) && 
					( empty( $LongTermLoansAndAdvances ) || $LongTermLoansAndAdvances == 0 ) && ( empty( $OtherNonCurrentAssets ) || $OtherNonCurrentAssets == 0 ) && ( empty( $TotalNonCurrentAssets ) || $TotalNonCurrentAssets == 0 ) && ( empty( $CurrentInvestments ) || $CurrentInvestments == 0 ) && 
					( empty( $Inventories ) || $Inventories == 0 ) && ( empty( $TradeReceivables ) || $TradeReceivables == 0 ) && ( empty( $CashandBankBalances ) || $CashandBankBalances == 0 ) && ( empty( $ShortTermLoansAdvances ) || $ShortTermLoansAdvances == 0 ) && 
					( empty( $OtherCurrentAssets ) || $OtherCurrentAssets == 0 ) && ( empty( $TotalCurrentAssets ) || $TotalCurrentAssets == 0 ) && ( empty( $TotalAssets ) || $TotalAssets == 0 ) ) || ( ( $TotalEquityAndLiabilities != $TotalAssets ) || ( ( $TotalEquityAndLiabilities == $TotalAssets ) && ( $TotalEquityAndLiabilities == 0 && $TotalAssets == 0 ) ) ) ) {
					// Unset the FY data if condition failed. remove curresponding FY error data.
					unset( $xmlParseData[ 'bs' ][ $fy ] );
					$errorReport = $errorReport - count( $errorArray[ $cin ]['bs'][$fy] );
					unset( $errorArray[ $cin ]['bs'][$fy] );
				} else {
					$xmlParseData[ 'bs' ][ $fy ][ 'Share capital' ] = $ShareCapital;
					$xmlParseData[ 'bs' ][ $fy ][ 'Reserves and surplus' ] = $ReservesandSurplus;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total shareholders funds' ] = $TotalShareholdersFunds;
					$xmlParseData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ] = $ShareApplicationMoney;
					$xmlParseData[ 'bs' ][ $fy ][ 'Long-term borrowings' ] = $LongtermBorrowings;
					$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ] = $DeferredTaxLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ] = $OtherLongTermLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Long-term provisions' ] = $LongTermProvisions;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ] = $TotalNonCurrentLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Short-term borrowings' ] = $ShortTermBorrowings;
					$xmlParseData[ 'bs' ][ $fy ][ 'Trade payables' ] = $TradePayable;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other current liabilities' ] = $OtherCurrentLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Short-term provisions' ] = $ShortTermProvisions;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total current liabilities' ] = $TotalCurrentLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ] = $TotalEquityAndLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Tangible assets' ] = $TangibleAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Intangible assets' ] = $IntangibleAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total fixed assets' ] = $TotalFixedAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Non-current investments' ] = $NoncurrentInvestments;	
					$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ] = $DeferredTaxAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ] = $LongTermLoansAndAdvances;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other non-current assets' ] = $OtherNonCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current assets' ] = $TotalNonCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Current investments' ] = $CurrentInvestments;
					$xmlParseData[ 'bs' ][ $fy ][ 'Inventories' ] = $Inventories;
					$xmlParseData[ 'bs' ][ $fy ][ 'Trade receivables' ] = $TradeReceivables;
					$xmlParseData[ 'bs' ][ $fy ][ 'Cash and bank balances' ] = $CashandBankBalances;
					$xmlParseData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ] = $ShortTermLoansAdvances;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other current assets' ] = $OtherCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total current assets' ] = $TotalCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total assets' ] = $TotalAssets;
					foreach( $errorArray[ $cin ]['bs'][$fy] as $bstext ) {
						$logs->logWrite( $bstext, true );
					}
				}
			}
			//CF DATA STARTS
			if( $addCFFlag > 0 ) {
				
				$plBeforeExtraordinary = $operatingActivities = $investingActivities = $financingActivities = $incdecCashEquivalents = $cashEquivalentsBeginYear = $cashEquivalentsEndYear = 0;
				//echo $cfloopCount; exit();
				for( $cfloopInc = 0; $cfloopInc < $cfloopCount; $cfloopInc++ ) {
					if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) && isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_value:' ];
						}
					}else if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ][$cfloopInc ][ '_value:' ];
						}
					} else {
						if( in_array( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ][$cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ] ) ) {
						if( in_array( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][$cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$operatingActivities = $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][ $cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ] ) ) {
						if( in_array( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$investingActivities = $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ] ) ) {
						if( in_array( $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ][$cfloopInc][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$financingActivities = $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ][ $cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ] ) ) {
						if( in_array( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$incdecCashEquivalents = $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $cfloopInc ][ '_value:' ];
						}
					}
					// For CashAndCashEquivalentsCashFlowStatement
					for( $cfloopInc1 = 0; $cfloopInc1 < count( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ]); $cfloopInc1++ ) {
						if( isset( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ] ) ) {
							if( in_array( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
								$cashEquivalentsEndYear = $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_value:' ];
							}
						}
					}
				}
					
					//$incdecCashEquivalents = $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $cfloopInc ][ '_value:' ];
				// Reverting data to previous if not found
				if( ( empty( $plBeforeExtraordinary ) || $plBeforeExtraordinary == 0 ) && ( empty( $operatingActivities ) || $operatingActivities == 0 ) && ( empty( $investingActivities ) || $investingActivities == 0 ) && ( empty( $financingActivities ) || $financingActivities == 0 ) && 
					( empty( $incdecCashEquivalents ) || $incdecCashEquivalents == 0 ) ) {
					
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] ) ) {
						$plBeforeExtraordinary = $previousData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ] ) ) {
						$operatingActivities = $previousData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ] ) ) {
						$investingActivities = $previousData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Cash Used From Financing Activities' ] ) ) {
						$financingActivities = $previousData[ 'cf' ][ $fy ][ 'Share application money pending allotment' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ] ) ) {
						$incdecCashEquivalents = $previousData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ] ) ) {
						$cashEquivalentsEndYear = $previousData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ];	
					}
					
				}

				
				// XML parsed data assigned to variable which will be sent to excel file generation.
				if( ( empty( $plBeforeExtraordinary ) || $plBeforeExtraordinary == 0 ) && ( empty( $operatingActivities ) || $operatingActivities == 0 ) && ( empty( $investingActivities ) || $investingActivities == 0 ) && ( empty( $financingActivities ) || $financingActivities == 0 ) && 
					( empty( $incdecCashEquivalents ) || $incdecCashEquivalents == 0 ) ) {
					
					unset( $xmlParseData[ 'cf' ][ $fy ] );
					$errorReport = $errorReport - count( $errorArray[ $cin ]['cf'][$fy] );
					unset( $errorArray[ $cin ]['cf'][$fy] );
				} else {
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] = $plBeforeExtraordinary;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ] = $operatingActivities;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ] = $investingActivities;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used From Financing Activities' ] = $financingActivities;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ] = $incdecCashEquivalents;
					$xmlParseData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ] = $cashEquivalentsEndYear;
					
					
					foreach( $errorArray[ $cin ]['cf'][$fy] as $bstext ) {
						$logs->logWrite( $bstext, true );
					}
				}
			
			//CF END

			}
		}
		//echo '<pre>'; print_r( $xmlParseData ); echo '</pre>'; 
		unset( $previousData );
		return array( 'data' => $xmlParseData, 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	/*
		OLD format consolidated xml data fetching from the given XML field.
		Validation rules are applied.
		Returns: Data of both PL and BS in data key, Error data and error count is returned.
	*/
	public function xbrlOldFormatConsolidated( $xbrlData = '', $fyYear = '', $cin = '', $plArray = '', $bsArray = '', $cfArray = '', $yearMapp = '', $xmlParseData = array() ) {

		global $logs;
		global $xbrl2;
		global $Insert_XBRL2;
		$isXBRL2 = false;
		$i = 0;

		$isCSRExpenditure = false;
		$isCostOfMaterialsConsumed = false;
		$isExpenses = false;
		$isOtherExpenses = false;
		$isNextkey = '';
		
		foreach($xbrlData as $key=>$val) {
			
			if($key == 'MiscellaneousExpenses' && $isNextkey != ''){
				$isCSRExpenditure = false;
			} else {
				$isNextkey = '';
			}

			// if($key == 'CostOfMaterialsConsumed'){
			// 	$isCostOfMaterialsConsumed = true;
			// } 

			// if(($key == 'Expenses' || $key == 'OtherExpenses') && $isCostOfMaterialsConsumed == true){
				
			// 	if($key == 'Expenses') {
			// 		$isExpenses = true;
			// 	} else if($key == 'OtherExpenses'){
			// 		$isOtherExpenses = true;
			// 	}
			// }

			if($key == 'CSRExpenditure'){
			//if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && ($isExpenses == false || $isOtherExpenses == false)){
				$isCSRExpenditure = true;
				$isNextkey = 'MiscellaneousExpenses';
			}
		}
		
		/*foreach($xbrlData as $key=>$val) {
			
			if($key == 'CostOfMaterialsConsumed'){
				$isCostOfMaterialsConsumed = true;
				continue;
			} 
			
			if($key == 'Expenses' && $isCostOfMaterialsConsumed == true){
				$isExpenses = true;
				continue;
			} 
			
			if($key == 'CSRExpenditure' && $isCostOfMaterialsConsumed == true && $isExpenses == false){
				$isCSRExpenditure = true;
				continue;
			}
		}*/

		if( count( $xbrlData[ 'RevenueFromOperations' ] ) > 0 ) {
			$loopCount = $addval = count( $xbrlData[ 'RevenueFromOperations' ] );	
		} else {
			$loopCount = $addval = count( $xbrlData[ 'OperatingRevenueNet' ] );
		}
		if( isset( $xbrlData[ 'ReservesAndSurplus' ] ) ) {
			$bsloopCount = $addval = count( $xbrlData[ 'ReservesAndSurplus' ] );
		} else {
			$bsloopCount = $addval = count( $xbrlData[ 'ReservesSurplus' ] );
		}
		// if( count( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) > 0 ) {
		// 	$cfloopCount = $addval = count( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] );	
		// } else if( count( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) > 0 ) {
		// 	$cfloopCount = $addval = count( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] );
		// } else {
		// 	$cfloopCount = $addval = count( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] );
		// }

		$cfloopCountarray = array();
		array_push($cfloopCountarray,count( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ),
				count( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ),
				count( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] ),
				count( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ] ),
				count( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ] ),
				count( $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ] ),
				count( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ] ));
		
		$cfloopCount = $addval = max($cfloopCountarray);
		
		$dilutedCont = $basicCont = 4;
		$errorArray = array();
		if( empty( $xmlParseData ) ) {
			$errorReport = 0;
		} else {
			$errorReport = $xmlParseData[ 'error' ];
		}
		$previousData = $xmlParseData[ 'data' ];
		$xmlParseData = $xmlParseData[ 'data' ];
		foreach( $fyYear as $fy ) { // Looping throught the FY years identified from the XML. Data push to corresponding FY.
			$addFlag  = 0;
			$addBSFlag  = 0;
			$addCFFlag = 0;
			if( $loopCount > 0 ) {
				if( array_key_exists( $fy, $previousData[ 'pl' ] ) ) {
					if( $previousData[ 'pl' ][ $fy ][ 'check' ] == 'Partial' && $yearMapp[ $fy ] == 'Full' ) {
						if( isset( $xbrlData[ 'RevenueFromOperations' ] ) || isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) {
							$xmlParseData[ 'pl' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
							$addFlag = 1;
						}
					}
				} else {
					if( isset( $xbrlData[ 'RevenueFromOperations' ] ) || isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) {
						$xmlParseData[ 'pl' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
						$addFlag = 1;
					}
				}
			}
			if( $bsloopCount > 0 ) {
				if( array_key_exists( $fy, $previousData[ 'bs' ] ) ) {
					//echo 'Key check staisfied' . $bsloopCount . '<br/>';
					/*if( $fy == 2016 ) {
						echo '<pre>'; print_r( $xbrlData ); echo '</pre>';
					}*/
					if( $previousData[ 'bs' ][ $fy ][ 'check' ] == 'Partial' && $yearMapp[ $fy ] == 'Full' ) {
						if( isset( $xbrlData[ 'ShareCapital' ] ) || isset( $xbrlData[ 'PaidupShareCapital' ] ) ) {
							//echo 'Partial Check == ' . $yearMapp[ $fy ] . '<br/>';
							$xmlParseData[ 'bs' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
							$addBSFlag = 1;
						}
					}
				} else {
					if( isset( $xbrlData[ 'ShareCapital' ] ) || isset( $xbrlData[ 'PaidupShareCapital' ] ) ) {
						$xmlParseData[ 'bs' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
						$addBSFlag = 1;
						//echo 'Field check == ' . $yearMapp[ $fy ] . '<br/>';
					}
				}
			}
			if( $cfloopCount > 0 ) {
				/*if( $fy == 2014 ) {
					echo '<pre>'; print_r( $bsArray ); echo '</pre>';
					echo '<pre>'; print_r( $xbrlData ); echo '</pre>';
				}*/
				if( array_key_exists( $fy, $previousData[ 'cf' ] ) ) {
					//echo 'Key check staisfied' . $bsloopCount . '<br/>';
					if( $previousData[ 'cf' ][ $fy ][ 'check' ] == 'Partial' && $yearMapp[ $fy ] == 'Full' ) {
						if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] ) ) {
							$xmlParseData[ 'cf' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
							$addCFFlag = 1;
							//echo 'Partial Check == ' . $yearMapp[ $fy ] . '<br/>';
						}
					}
				} else {
					if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) || isset( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ] ) ) {
						$xmlParseData[ 'cf' ][ $fy ][ 'check' ] = $yearMapp[ $fy ];
						$addCFFlag = 1;
						//echo 'Field check == ' . $yearMapp[ $fy ] . '<br/>';
					}
				}	
			}
			//echo $addBSFlag . ' ==== ' . $fy .'<br/>';
			// PL DATA STARTS
			$operationalIncome = $otherIncome = $totalIncome = $totalIncomeCheck = $expenses = $interest = $depreciation = $operationalAdminOtherExpenses = $operatingProfit = $EBITDA = $EBDT = $profitBeforePriorperiodItemsTax = $profitBeforeItemsTax = $EBTbeforeExceptionalItems = $priorPeriodExceptionalExtraOrdinaryItems = $tax = $EmployeeRelatedExpenses = $earningForeignExchange = $expenditureInForeignCurrency = $valueOfImportsOfRawMaterials = $outgoForeignExchange =$CostOfMaterialsConsumed = $PurchasesOfStockInTrade = $ChangesInInventories = $CSRExpenditure = $OtherExpenses = $CurrentTax = $DeferredTax = $PAT = $basicInINR = $dilutedInINR = $profitMinorityInterest = $profitLossMinor = $ShareOfProfitLossOfAssociates = $EBT = $totalProfitLossForPeriod = 0;

			// MI5-T384
			$ExpenditureOnProduction = 0;

			/*
				Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
				Given XML field isset condition checked and PL Context array condition is checked.
			*/
			if( $addFlag > 0 ) {
				if( !isset( $xbrlData[ 'RevenueFromOperations' ] ) && !isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) { // XML support condition check with the XML field exists or not.
					$logs->logWrite( "FY".$fy . " - Error Xml not supported", true );
					$errorArray[ $cin ]['common'][$fy][] = "FY".$fy . " - Error Xml not supported";
					$errorReport++;
					return array( 'data' => array(), 'error' => $errorReport, 'error_array' => $errorArray  );
				}

				for( $loopInc = 0; $loopInc < $loopCount; $loopInc++ ) {
					if( isset( $xbrlData[ 'RevenueFromOperations' ] ) ) {
						if( in_array( $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$operationalIncome = $xbrlData[ 'RevenueFromOperations' ][ $loopInc ][ '_value:' ];	
						}
					} else if( isset( $xbrlData[ 'OperatingRevenueNet' ] ) ) {
						$xbrlData[ 'OperatingRevenueNet' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ];
						if( in_array( $xbrlData[ 'OperatingRevenueNet' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$operationalIncome = $xbrlData[ 'OperatingRevenueNet' ][ $loopInc ][ '_value:' ];	
						}
					}
					if( isset( $xbrlData[ 'OtherIncome' ] ) ) {
						if( in_array( $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$otherIncome = $xbrlData[ 'OtherIncome' ][ $loopInc ][ '_value:' ];
						}
					}
					
					if( isset( $xbrlData[ 'Revenue' ] ) ) {
						if( in_array( $xbrlData[ 'Revenue' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$totalIncome = $xbrlData[ 'Revenue' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'Expenses' ] ) ) {
						if( in_array( $xbrlData[ 'Expenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$expenses = $xbrlData[ 'Expenses' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'FinanceCosts' ] ) ) {
						if( in_array( $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$interest = $xbrlData[ 'FinanceCosts' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ] ) ) {
						if( in_array( $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$depreciation = $xbrlData[ 'DepreciationDepletionAndAmortisationExpense' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBTbeforeExceptionalItems = $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ProfitBeforeTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EBT = $xbrlData[ 'ProfitBeforeTax' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'TaxExpense' ] ) ) {
						if( in_array( $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$tax = $xbrlData[ 'TaxExpense' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$PAT = $xbrlData[ 'ProfitLossForPeriodFromContinuingOperations' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ProfitLossOfMinorityInterest' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitLossOfMinorityInterest' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$profitLossMinor = $xbrlData[ 'ProfitLossOfMinorityInterest' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShareOfProfitLossOfAssociates' ] ) ) {
						if( in_array( $xbrlData[ 'ShareOfProfitLossOfAssociates' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ShareOfProfitLossOfAssociates = $xbrlData[ 'ShareOfProfitLossOfAssociates' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'EmployeeBenefitExpense' ] ) ) {
						if( in_array( $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$EmployeeRelatedExpenses = $xbrlData[ 'EmployeeBenefitExpense' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'EarningsInForeignCurrency' ] ) ) {
						if( in_array( $xbrlData[ 'EarningsInForeignCurrency' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$earningForeignExchange = $xbrlData[ 'EarningsInForeignCurrency' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ExpenditureInForeignCurrency' ] ) ) {
						if( in_array( $xbrlData[ 'ExpenditureInForeignCurrency' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$expenditureInForeignCurrency = $xbrlData[ 'ExpenditureInForeignCurrency' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ValueOfImportsCalculatedOnCIFBasis' ] ) ) {
						if( in_array( $xbrlData[ 'ValueOfImportsCalculatedOnCIFBasis' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$valueOfImportsOfRawMaterials = $xbrlData[ 'ValueOfImportsCalculatedOnCIFBasis' ][ $loopInc ][ '_value:' ];
						}
					}
					$outgoForeignExchange = $expenditureInForeignCurrency + $valueOfImportsOfRawMaterials;

					if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) ) { // XML Field CostOfMaterialsConsumed - PL NS
						if( in_array( $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$CostOfMaterialsConsumed = $xbrlData[ 'CostOfMaterialsConsumed' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) ) { // XML Field PurchasesOfStockInTrade - PL NS
						if( in_array( $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$PurchasesOfStockInTrade = $xbrlData[ 'PurchasesOfStockInTrade' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) ) { // XML Field ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade - PL NS
						if( in_array( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ChangesInInventories = $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CSRExpenditure' ] ) && $isCSRExpenditure == true ) { // XML Field CSRExpenditure - PL NS
						if( in_array( $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$CSRExpenditure = $xbrlData[ 'CSRExpenditure' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherExpenses' ] ) ) { // XML Field OtherExpenses - PL NS
						if( in_array( $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$OtherExpenses = $xbrlData[ 'OtherExpenses' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ] ) ) { // XML Field OtherExpenses - PL OS
						if( in_array( $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$ExpenditureOnProduction = $xbrlData[ 'ExpenditureOnProductionTransportationAndOtherExpenditurePertainingToExplorationAndProductionActivities' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CurrentTax' ] ) ) { // XML Field CurrentTax - PL NS
						if( in_array( $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$CurrentTax = $xbrlData[ 'CurrentTax' ][ $loopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'DeferredTax' ] ) ) { // XML Field DeferredTax - PL NS
						if( in_array( $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							$DeferredTax = $xbrlData[ 'DeferredTax' ][ $loopInc ][ '_value:' ];
						}
					}

					if( isset( $xbrlData[ 'CostOfMaterialsConsumed' ] ) || isset( $xbrlData[ 'PurchasesOfStockInTrade' ] ) || 
						isset( $xbrlData[ 'ChangesInInventoriesOfFinishedGoodsWorkInProgressAndStockInTrade' ] ) || 
						isset( $xbrlData[ 'CSRExpenditure' ] ) || isset( $xbrlData[ 'OtherExpenses' ] ) || 
						isset( $xbrlData[ 'DeferredTax' ] ) || isset( $xbrlData[ 'CurrentTax' ] )) {
							$isXBRL2 = true;

					} else {
						$isXBRL2 = false;
					}
				}
				for( $profitLoassInc = 0; $profitLoassInc < count( $xbrlData[ 'ProfitLossForPeriod' ] ); $profitLoassInc++ ) {
					if( isset( $xbrlData[ 'ProfitLossForPeriod' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ] ) ) {
								if( !empty( $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_value:' ] ) ) {
									$totalProfitLossForPeriod = $xbrlData[ 'ProfitLossForPeriod' ][ $profitLoassInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				for( $basicInc = 0; $basicInc < count( $xbrlData[ 'BasicEarningPerEquityShare' ] ); $basicInc++ ) {
					$newConttext = 'CONTXT_ID_'.$basicCont.'_D';
					$newConttext1 = 'CONTXT_ID_'.$basicCont.'_I';
					if( isset( $xbrlData[ 'BasicEarningPerEquityShare' ] ) ) {
						if( in_array( $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ] ) ) {
								if( !empty( $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ][ '_value:' ] ) ) {
									$basicInINR = $xbrlData[ 'BasicEarningPerEquityShare' ][ $basicInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}
				for( $dilutedInc = 0; $dilutedInc < count( $xbrlData[ 'DilutedEarningsPerEquityShare' ] ); $dilutedInc++ ) {
					$newConttext = 'CONTXT_ID_'.$dilutedCont.'_D';
					$newConttext1 = 'CONTXT_ID_'.$dilutedCont.'_I';
					if( isset( $xbrlData[ 'DilutedEarningsPerEquityShare' ] ) ) {
						if( in_array( $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ][ '_attributes:' ][ 'contextRef' ], $plArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ] ) ) {
								if( !empty( $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ][ '_value:' ] ) ) {
									$dilutedInINR = $xbrlData[ 'DilutedEarningsPerEquityShare' ][ $dilutedInc ][ '_value:' ];
									break;
								}
							}
						}
					}
				}																			
				$totalIncomeCheck = $operationalIncome + $otherIncome;
				if( !empty( $interest ) || !empty( $depreciation ) || !empty( $expenses ) ) {
					if( empty( $interest ) ) {
						$interest = 0;
					}
					if( empty( $depreciation ) ) {
						$depreciation = 0;
					}
					$operationalAdminOtherExpenses = $expenses - $interest - $depreciation;
				}
				if( !empty( $operationalIncome ) || ( !empty( $operationalAdminOtherExpenses ) ) ) {
					$operatingProfit = $operationalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $totalIncome ) || !empty( $operationalAdminOtherExpenses ) ) {
					$EBITDA = $totalIncome - $operationalAdminOtherExpenses;
				}
				if( !empty( $EBITDA ) || !empty( $interest ) ) {
					$EBDT = $EBITDA - $interest;
				}
				$OtherExpenses = $OtherExpenses + $ExpenditureOnProduction;
				$profitMinorityInterest = $PAT - $totalProfitLossForPeriod;
				$priorPeriodExceptionalExtraOrdinaryItems = $EBTbeforeExceptionalItems - $EBT;
				if( $totalIncome != $totalIncomeCheck ) {
					$operationalIncome = $totalIncome - $otherIncome;
				}
				// Reassign previous values
				if( ( empty( $operationalIncome ) || $operationalIncome == 0 ) && 
					( empty( $otherIncome ) || $otherIncome == 0 ) && 
					( empty( $totalIncome ) || $totalIncome == 0 ) && 
					( empty( $CostOfMaterialsConsumed ) || $CostOfMaterialsConsumed == 0 ) && 
					( empty( $PurchasesOfStockInTrade ) || $PurchasesOfStockInTrade == 0 ) &&
					( empty( $ChangesInInventories ) || $ChangesInInventories == 0 ) &&
					( empty( $CSRExpenditure ) || $CSRExpenditure == 0 ) &&
					( empty( $OtherExpenses ) || $OtherExpenses == 0 ) &&
					( empty( $CurrentTax ) || $CurrentTax == 0 ) && 
					( empty( $DeferredTax ) || $DeferredTax == 0 ) &&
					( empty( $operationalAdminOtherExpenses ) || $operationalAdminOtherExpenses == 0 ) && 
					( empty( $operatingProfit ) || $operatingProfit == 0 ) && 
					( empty( $EBITDA ) || $EBITDA == 0 ) && 
					( empty( $interest ) || $interest == 0 ) && 
					( empty( $EBDT ) || $EBDT == 0 ) && 
					( empty( $depreciation ) || $depreciation == 0 ) && 
					( empty( $EBTbeforeExceptionalItems ) || $EBTbeforeExceptionalItems == 0 ) && 
					( empty( $priorPeriodExceptionalExtraOrdinaryItems ) || $priorPeriodExceptionalExtraOrdinaryItems == 0 ) && 
					( empty( $EBT ) || $EBT == 0 ) && 
					( empty( $tax ) || $tax == 0 ) && 
					( empty( $PAT ) || $PAT == 0 ) && 
					( empty( $profitMinorityInterest ) || $profitMinorityInterest == 0 ) && 
					( empty( $totalProfitLossForPeriod ) || $totalProfitLossForPeriod == 0 ) && 
					( empty( $basicInINR ) || $basicInINR == 0 ) && 
					( empty( $dilutedInINR ) || $dilutedInINR == 0 ) && 
					( empty( $EmployeeRelatedExpenses ) || $EmployeeRelatedExpenses == 0 ) && 
					( empty( $earningForeignExchange ) || $earningForeignExchange == 0 ) && 
					( empty( $outgoForeignExchange ) || $outgoForeignExchange == 0 ) ) {

					if( isset( $previousData[ 'pl' ][ $fy ][ 'Operational Income' ] ) ) {
						$operationalIncome = $previousData[ 'pl' ][ $fy ][ 'Operational Income' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Other Income' ] ) ) {
						$otherIncome = $previousData[ 'pl' ][ $fy ][ 'Other Income' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Total Income' ] ) ) {
						$totalIncome = $previousData[ 'pl' ][ $fy ][ 'Total Income' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ] ) ) {
						$CostOfMaterialsConsumed = $previousData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ] ) ) {
						$PurchasesOfStockInTrade = $previousData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'Changes In Inventories' ] ) ) {
						$ChangesInInventories = $previousData[ 'pl' ][ $fy ][ 'Changes In Inventories' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'CSR Expenditure' ] ) ) {
						$CSRExpenditure = $previousData[ 'pl' ][ $fy ][ 'CSR Expenditure' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'Other Expenses' ] ) ) {
						$OtherExpenses = $previousData[ 'pl' ][ $fy ][ 'Other Expenses' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ] ) ) {
						$operationalAdminOtherExpenses = $previousData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Operating Profit' ] ) ) {
						$operatingProfit = $previousData[ 'pl' ][ $fy ][ 'Operating Profit' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBITDA' ] ) ) {
						$EBITDA = $previousData[ 'pl' ][ $fy ][ 'EBITDA' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Interest' ] ) ) {
						$interest = $previousData[ 'pl' ][ $fy ][ 'Interest' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBDT' ] ) ) {
						$EBDT = $previousData[ 'pl' ][ $fy ][ 'EBDT' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Depreciation' ] ) ) {
						$depreciation = $previousData[ 'pl' ][ $fy ][ 'Depreciation' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ] ) ) {
						$EBTbeforeExceptionalItems = $previousData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ] ) ) {
						$priorPeriodExceptionalExtraOrdinaryItems = $previousData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'EBT' ] ) ) {
						$EBT = $previousData[ 'pl' ][ $fy ][ 'EBT' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'CurrentTax' ] ) ) {
						$CurrentTax = $previousData[ 'pl' ][ $fy ][ 'CurrentTax' ];	
					}if( isset( $previousData[ 'pl' ][ $fy ][ 'DeferredTax' ] ) ) {
						$DeferredTax = $previousData[ 'pl' ][ $fy ][ 'DeferredTax' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Tax' ] ) ) {
						$tax = $previousData[ 'pl' ][ $fy ][ 'Tax' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'PAT' ] ) ) {
						$PAT = $previousData[ 'pl' ][ $fy ][ 'PAT' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Profit (loss) of minority interest' ] ) ) {
						$profitMinorityInterest = $previousData[ 'pl' ][ $fy ][ 'Profit (loss) of minority interest' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Total profit (loss) for period' ] ) ) {
						$totalProfitLossForPeriod = $previousData[ 'pl' ][ $fy ][ 'Total profit (loss) for period' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ '(Basic in INR)' ] ) ) {
						$basicInINR = $previousData[ 'pl' ][ $fy ][ '(Basic in INR)' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ '(Diluted in INR)' ] ) ) {
						$dilutedInINR = $previousData[ 'pl' ][ $fy ][ '(Diluted in INR)' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ] ) ) {
						$EmployeeRelatedExpenses = $previousData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ] ) ) {
						$earningForeignExchange = $previousData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ];	
					}
					if( isset( $previousData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ] ) ) {
						$outgoForeignExchange = $previousData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ];	
					}
				}
				// Validation given in google sheet is added.
				/*if( ( $PAT < 0 && ( $basicInINR >= 0 || $dilutedInINR >= 0 ) ) || ( $PAT >= 0 && ( $basicInINR < 0 || $dilutedInINR < 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $basicInINR < 0 && ( $PAT >= 0 || $dilutedInINR >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) || ( $dilutedInINR < 0 && ( $basicInINR >= 0 || $PAT >= 0 ) ) ) {
					$logs->logWrite( $fy . " - PAT, EPS mismatch" );
					$errorArray[ $cin ]['pl'][$fy][] = $fy . " - PAT, EPS mismatch";
					$errorReport++;
				}*/ // VI team asked to hide this condition.
				if( $EBITDA < $EBDT || $EBDT < $EBTbeforeExceptionalItems ) {
					$errorArray[ $cin ]['pl'][$fy][] = "FY".$fy . " - EBITDA, EBDT, EBT mismatch";
					$errorReport++;
				}
				$Insert_XBRL2['isXBRL'] = $isXBRL2;
				// XML parsed data assigned to variable which will be sent to excel file generation.
				if( ( empty( $operationalIncome ) || $operationalIncome == 0 ) && 
					( empty( $otherIncome ) || $otherIncome == 0 ) && 
					( empty( $totalIncome ) || $totalIncome == 0 ) && 
					( empty( $CostOfMaterialsConsumed ) || $CostOfMaterialsConsumed == 0 ) && 
					( empty( $PurchasesOfStockInTrade ) || $PurchasesOfStockInTrade == 0 ) &&
					( empty( $ChangesInInventories ) || $ChangesInInventories == 0 ) &&
					( empty( $CSRExpenditure ) || $CSRExpenditure == 0 ) &&
					( empty( $OtherExpenses ) || $OtherExpenses == 0 ) &&
					( empty( $CurrentTax ) || $CurrentTax == 0 ) && 
					( empty( $DeferredTax ) || $DeferredTax == 0 ) &&
					( empty( $operationalAdminOtherExpenses ) || $operationalAdminOtherExpenses == 0 ) && 
					( empty( $operatingProfit ) || $operatingProfit == 0 ) && 
					( empty( $EBITDA ) || $EBITDA == 0 ) && 
					( empty( $interest ) || $interest == 0 ) && 
					( empty( $EBDT ) || $EBDT == 0 ) && 
					( empty( $depreciation ) || $depreciation == 0 ) && 
					( empty( $EBTbeforeExceptionalItems ) || $EBTbeforeExceptionalItems == 0 ) && 
					( empty( $priorPeriodExceptionalExtraOrdinaryItems ) || $priorPeriodExceptionalExtraOrdinaryItems == 0 ) && 
					( empty( $EBT ) || $EBT == 0 ) && 
					( empty( $tax ) || $tax == 0 ) && 
					( empty( $PAT ) || $PAT == 0 ) && 
					( empty( $profitMinorityInterest ) || $profitMinorityInterest == 0 ) && 
					( empty( $totalProfitLossForPeriod ) || $totalProfitLossForPeriod == 0 ) && 
					( empty( $basicInINR ) || $basicInINR == 0 ) && 
					( empty( $dilutedInINR ) || $dilutedInINR == 0 ) && 
					( empty( $EmployeeRelatedExpenses ) || $EmployeeRelatedExpenses == 0 ) && 
					( empty( $earningForeignExchange ) || $earningForeignExchange == 0 ) && 
					( empty( $outgoForeignExchange ) || $outgoForeignExchange == 0 ) ) {
					// Unset the FY data if condition failed. remove curresponding FY error data.
					unset( $xmlParseData[ 'pl' ][ $fy ] );
					$errorReport = $errorReport - count( $errorArray[ $cin ]['pl'][$fy] );
					unset( $errorArray[ $cin ]['pl'][$fy] );
				} else {
					$xmlParseData[ 'pl' ][ $fy ][ 'Operational Income' ] = $operationalIncome;
					$xmlParseData[ 'pl' ][ $fy ][ 'Other Income' ] = $otherIncome;
					$xmlParseData[ 'pl' ][ $fy ][ 'Total Income' ] = $totalIncome;
					$xmlParseData[ 'pl' ][ $fy ][ 'Cost Of Materials Consumed' ] = $CostOfMaterialsConsumed;
					$xmlParseData[ 'pl' ][ $fy ][ 'Purchases Of Stock In Trade' ] = $PurchasesOfStockInTrade;
					$xmlParseData[ 'pl' ][ $fy ][ 'Changes In Inventories' ] = $ChangesInInventories;
					$xmlParseData[ 'pl' ][ $fy ][ 'CSR Expenditure' ] = $CSRExpenditure;
					$xmlParseData[ 'pl' ][ $fy ][ 'Other Expenses' ] = $OtherExpenses;
					$xmlParseData[ 'pl' ][ $fy ][ 'Operational, Admin & Other Expenses' ] = $operationalAdminOtherExpenses;
					$xmlParseData[ 'pl' ][ $fy ][ 'Operating Profit' ] = $operatingProfit;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBITDA' ] = $EBITDA;
					$xmlParseData[ 'pl' ][ $fy ][ 'Interest' ] = $interest;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBDT' ] = $EBDT;
					$xmlParseData[ 'pl' ][ $fy ][ 'Depreciation' ] = $depreciation;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBT before Exceptional Items' ] = $EBTbeforeExceptionalItems;
					$xmlParseData[ 'pl' ][ $fy ][ 'Prior period/Exceptional /Extra Ordinary Items' ] = $priorPeriodExceptionalExtraOrdinaryItems;
					$xmlParseData[ 'pl' ][ $fy ][ 'EBT' ] = $EBT;
					$xmlParseData[ 'pl' ][ $fy ][ 'CurrentTax' ] = $CurrentTax;
				    $xmlParseData[ 'pl' ][ $fy ][ 'DeferredTax' ] = $DeferredTax;
					$xmlParseData[ 'pl' ][ $fy ][ 'Tax' ] = $tax;
					$xmlParseData[ 'pl' ][ $fy ][ 'PAT' ] = $PAT;
					$xmlParseData[ 'pl' ][ $fy ][ 'Profit (loss) of minority interest' ] = $profitMinorityInterest;
					$xmlParseData[ 'pl' ][ $fy ][ 'Total profit (loss) for period' ] = $totalProfitLossForPeriod;
					$xmlParseData[ 'pl' ][ $fy ][ '(Basic in INR)' ] = $basicInINR;
					$xmlParseData[ 'pl' ][ $fy ][ '(Diluted in INR)' ] = $dilutedInINR;
					$xmlParseData[ 'pl' ][ $fy ][ 'Employee Related Expenses' ] = $EmployeeRelatedExpenses;
					$xmlParseData[ 'pl' ][ $fy ][ 'Earning in Foreign Exchange' ] = $earningForeignExchange;
					$xmlParseData[ 'pl' ][ $fy ][ 'Outgo in Foreign Exchange' ] = $outgoForeignExchange;
					foreach( $errorArray[ $cin ]['pl'][$fy] as $pltext ) {
						$logs->logWrite( $pltext, true );
					}
				}
			}

			if( $addBSFlag > 0 ) {
				//BS DATA STARTS
				$ShareCapital = $ReservesandSurplus = $TotalShareholdersFunds = $ShareApplicationMoney = $LongtermBorrowings = $DeferredTaxLiabilities = $OtherLongTermLiabilities = $LongTermProvisions = $TotalNonCurrentLiabilitiesCheck = $TotalNonCurrentLiabilities = $ShortTermBorrowings = $TradePayable = $OtherCurrFinancialLiabilities = $OtherCurrentLiabilities = $ShortTermProvisions = $TotalCurrentLiabilitiesCheck = $TotalCurrentLiabilities = $TotalEquityAndLiabilitiesCheck = $TotalEquityAndLiabilities = $tangibleAssetsCapitalWorkInProgress = $TotalFixedAssets = $LongTermLoansAndAdvances = $OtherNonCurrentAssets = $TotalNonCurrentAssets = $CurrentInvestments = $CashandBankBalances = $ShortTermLoansAdvances = $OtherCurrentAssets = $TotalCurrentAssets = $TotalAssets = $TangibleAss = $TangibleAssets = $IntangibleAssets = $NoncurrentInvestments = $Inventories = $TradeReceivables = $DeferredTaxAssets = $TotalNonCurrentAssetsCheck = $TotalCurrentAssetsCheck = $TotalAssetsCheck = $MinorityInterest = $TradePayable = $TotalShareholdersFundsCheck = $diffTotalShareholdersFunds = $diffTotalCurrentLiabilities = $diffTotalEquityAndLiabilities = $diffTotalCurrentAssets = $diffTotalAssets = $IntangibleAss = $IntangibleAssetsUnderDevelopmentOrWorkInProgress = $OtherLongTermLiabil = $DeferredGovernmentGrants = $NonCurrentLiabilities = $MoneyReceivedAgainstShareWarrants = $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $Goodwill = 0;
				if( isset( $xbrlData[ 'ShareCapital' ] ) ) {
					$shareLoop = count( $xbrlData[ 'ShareCapital' ] );
				} else {
					$shareLoop = count( $xbrlData[ 'PaidupShareCapital' ] );
				}
				/*
					Defined XML field count checked and looped for identifying the correspoding FY value fromt the XML.
					Given XML field isset condition checked and BS Context array condition is checked.
				*/
				for( $equityshareInc = 0; $equityshareInc < $shareLoop; $equityshareInc++ ) {
					if( isset( $xbrlData[ 'ShareCapital' ] ) ) {
						if( in_array( $xbrlData[ 'ShareCapital' ][ $equityshareInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ShareCapital' ][ $equityshareInc ] ) ) {
								$ShareCapital = $xbrlData[ 'ShareCapital' ][ $equityshareInc ][ '_value:' ];
								break;
							}
						}
					} else if( isset( $xbrlData[ 'PaidupShareCapital' ] ) ) {
						if( in_array( $xbrlData[ 'PaidupShareCapital' ][ $equityshareInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'PaidupShareCapital' ][ $equityshareInc ] ) ) {
								$ShareCapital = $xbrlData[ 'PaidupShareCapital' ][ $equityshareInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $bsloopInc = 0; $bsloopInc < $bsloopCount; $bsloopInc++ ) {
					if( isset( $xbrlData[ 'ReservesAndSurplus' ] ) ) {
						if( in_array( $xbrlData[ 'ReservesAndSurplus' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ReservesandSurplus = $xbrlData[ 'ReservesAndSurplus' ][ $bsloopInc ][ '_value:' ];
						}
					} /*else if( isset( $xbrlData[ 'ReservesSurplus' ] ) ) {
						if( in_array( $xbrlData[ 'ReservesSurplus' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ReservesandSurplus = $xbrlData[ 'ReservesSurplus' ][ $bsloopInc ][ '_value:' ];
						}
					}*/
					if( isset( $xbrlData[ 'ShareholdersFunds' ] ) ) {
						if( in_array( $xbrlData[ 'ShareholdersFunds' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalShareholdersFunds = $xbrlData[ 'ShareholdersFunds' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShareApplicationMoneyPendingAllotment' ] ) ) {
						if( in_array( $xbrlData[ 'ShareApplicationMoneyPendingAllotment' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShareApplicationMoney = $xbrlData[ 'ShareApplicationMoneyPendingAllotment' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'MinorityInterest' ] ) ) {
						if( in_array( $xbrlData[ 'MinorityInterest' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$MinorityInterest = $xbrlData[ 'MinorityInterest' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'LongTermBorrowings' ] ) ) {
						if( in_array( $xbrlData[ 'LongTermBorrowings' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$LongtermBorrowings = $xbrlData[ 'LongTermBorrowings' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'DeferredTaxLiabilitiesNet' ] ) ) {
						if( in_array( $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$DeferredTaxLiabilities = $xbrlData[ 'DeferredTaxLiabilitiesNet' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherLongTermLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'OtherLongTermLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherLongTermLiabil = $xbrlData[ 'OtherLongTermLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'LongTermProvisions' ] ) ) {
						if( in_array( $xbrlData[ 'LongTermProvisions' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$LongTermProvisions = $xbrlData[ 'LongTermProvisions' ][ $bsloopInc ][ '_value:' ];
						}
					}
					
					if( isset( $xbrlData[ 'NoncurrentLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$NonCurrentLiabilities = $xbrlData[ 'NoncurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShortTermBorrowings' ] ) ) {
						if( in_array( $xbrlData[ 'ShortTermBorrowings' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShortTermBorrowings = $xbrlData[ 'ShortTermBorrowings' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'TradePayables' ] ) ) {
						if( in_array( $xbrlData[ 'TradePayables' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TradePayable = $xbrlData[ 'TradePayables' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherCurrentLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherCurrentLiabilities = $xbrlData[ 'OtherCurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShortTermProvisions' ] ) ) {
						if( in_array( $xbrlData[ 'ShortTermProvisions' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShortTermProvisions = $xbrlData[ 'ShortTermProvisions' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CurrentLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalCurrentLiabilities = $xbrlData[ 'CurrentLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'EquityAndLiabilities' ] ) ) {
						if( in_array( $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalEquityAndLiabilities = $xbrlData[ 'EquityAndLiabilities' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ] ) ) {
						if( in_array( $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$tangibleAssetsCapitalWorkInProgress = $xbrlData[ 'TangibleAssetsCapitalWorkInProgress' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'FixedAssets' ] ) ) {
						if( in_array( $xbrlData[ 'FixedAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalFixedAssets = $xbrlData[ 'FixedAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'LongTermLoansAndAdvances' ] ) ) {
						if( in_array( $xbrlData[ 'LongTermLoansAndAdvances' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$LongTermLoansAndAdvances = $xbrlData[ 'LongTermLoansAndAdvances' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherNoncurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherNonCurrentAssets = $xbrlData[ 'OtherNoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'NoncurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalNonCurrentAssets = $xbrlData[ 'NoncurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					/*if( isset( $xbrlData[ 'CurrentInvestments' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentInvestments' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$CurrentInvestments = $xbrlData[ 'CurrentInvestments' ][ $bsloopInc ][ '_value:' ];
						}
					}*/
					if( isset( $xbrlData[ 'CashAndBankBalances' ] ) ) {
						if( in_array( $xbrlData[ 'CashAndBankBalances' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$CashandBankBalances = $xbrlData[ 'CashAndBankBalances' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'ShortTermLoansAndAdvances' ] ) ) {
						if( in_array( $xbrlData[ 'ShortTermLoansAndAdvances' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$ShortTermLoansAdvances = $xbrlData[ 'ShortTermLoansAndAdvances' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'OtherCurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$OtherCurrentAssets = $xbrlData[ 'OtherCurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CurrentAssets' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalCurrentAssets = $xbrlData[ 'CurrentAssets' ][ $bsloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'Assets' ] ) ) {
						if( in_array( $xbrlData[ 'Assets' ][ $bsloopInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							$TotalAssets = $xbrlData[ 'Assets' ][ $bsloopInc ][ '_value:' ];
						}
					}
				}
				
				for( $tangibleAssInc = 0; $tangibleAssInc < count( $xbrlData[ 'TangibleAssets' ] ); $tangibleAssInc++ ) {
					if( isset( $xbrlData[ 'TangibleAssets' ] ) ) {
						if( in_array( $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ] ) ) {
								$TangibleAss = $xbrlData[ 'TangibleAssets' ][ $tangibleAssInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				$TangibleAssets = $TangibleAss + $tangibleAssetsCapitalWorkInProgress;
				for( $intangibleInc = 0; $intangibleInc < count( $xbrlData[ 'IntangibleAssets' ] ); $intangibleInc++ ) {
					if( isset( $xbrlData[ 'IntangibleAssets' ] ) ) {
						if( in_array( $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ] ) ) {
								$IntangibleAss = $xbrlData[ 'IntangibleAssets' ][ $intangibleInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $intanassundedevworkInc = 0; $intanassundedevworkInc < count( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ); $intanassundedevworkInc++ ) {
					if( isset( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ] ) ) {
						if( in_array( $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intanassundedevworkInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intanassundedevworkInc ] ) ) {
								$IntangibleAssetsUnderDevelopmentOrWorkInProgress = $xbrlData[ 'IntangibleAssetsUnderDevelopmentOrWorkInProgress' ][ $intanassundedevworkInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $noncurinvInc = 0; $noncurinvInc < count( $xbrlData[ 'NoncurrentInvestments' ] ); $noncurinvInc++ ) {
					if( isset( $xbrlData[ 'NoncurrentInvestments' ] ) ) {
						if( in_array( $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ] ) ) {
								$NoncurrentInvestments = $xbrlData[ 'NoncurrentInvestments' ][ $noncurinvInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $inventoriesInc = 0; $inventoriesInc < count( $xbrlData[ 'Inventories' ] ); $inventoriesInc++ ) {
					if( isset( $xbrlData[ 'Inventories' ] ) ) {
						if( in_array( $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'Inventories' ][ $inventoriesInc ] ) ) {
								$Inventories = $xbrlData[ 'Inventories' ][ $inventoriesInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $tradeReceivesInc = 0; $tradeReceivesInc < count( $xbrlData[ 'TradeReceivables' ] ); $tradeReceivesInc++ ) {
					if( isset( $xbrlData[ 'TradeReceivables' ] ) ) {
						if( in_array( $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ] ) ) {
								$TradeReceivables = $xbrlData[ 'TradeReceivables' ][ $tradeReceivesInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $deferredtaxassInc = 0; $deferredtaxassInc < count( $xbrlData[ 'DeferredTaxAssetsNet' ] ); $deferredtaxassInc++ ) {
					if( isset( $xbrlData[ 'DeferredTaxAssetsNet' ] ) ) {
						if( in_array( $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ] ) ) {
								$DeferredTaxAssets = $xbrlData[ 'DeferredTaxAssetsNet' ][ $deferredtaxassInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $deferredgovtransinc = 0; $deferredgovtransinc < count( $xbrlData[ 'DeferredGovernmentGrants' ] ); $deferredgovtransinc++ ) {
					if( isset( $xbrlData[ 'DeferredGovernmentGrants' ] ) ) {
						if( in_array( $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovtransinc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovtransinc ] ) ) {
								$DeferredGovernmentGrants = $xbrlData[ 'DeferredGovernmentGrants' ][ $deferredgovtransinc ][ '_value:' ];
								break;
							}
						}
					}
				}

				// Fields document 2.5.3
				for( $moneyRecAgaShrWar = 0; $moneyRecAgaShrWar < count( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ); $moneyRecAgaShrWar++ ) {
					if( isset( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ] ) ) {
						if( in_array( $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgaShrWar ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgaShrWar ] ) ) {
								$MoneyReceivedAgainstShareWarrants = $xbrlData[ 'MoneyReceivedAgainstShareWarrants' ][ $moneyRecAgaShrWar ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $forCurrMonItTransDiffLiaAcc = 0; $forCurrMonItTransDiffLiaAcc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ); $forCurrMonItTransDiffLiaAcc++ ) {
					if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ] ) ) {
						if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $forCurrMonItTransDiffLiaAcc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $forCurrMonItTransDiffLiaAcc ] ) ) {
								$ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount' ][ $forCurrMonItTransDiffLiaAcc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $forCurrMnItTransDiffAssAcc = 0; $forCurrMnItTransDiffAssAcc < count( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ); $forCurrMnItTransDiffAssAcc++ ) {
					if( isset( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ] ) ) {
						if( in_array( $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $forCurrMnItTransDiffAssAcc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $forCurrMnItTransDiffAssAcc ] ) ) {
								$ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount = $xbrlData[ 'ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount' ][ $forCurrMnItTransDiffAssAcc ][ '_value:' ];
								break;
							}
						}
					}
				}
				for( $currentInvInc = 0; $currentInvInc < count( $xbrlData[ 'CurrentInvestments' ] ); $currentInvInc++ ) {
					if( isset( $xbrlData[ 'CurrentInvestments' ] ) ) {
						if( in_array( $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ] ) ) {
								$CurrentInvestments = $xbrlData[ 'CurrentInvestments' ][ $currentInvInc ][ '_value:' ];
								break;
							}
						}
					}
				}

				for( $goodwillInc = 0; $goodwillInc < count( $xbrlData[ 'Goodwill' ] ); $goodwillInc++ ) {
					if( isset( $xbrlData[ 'Goodwill' ] ) ) {
						if( in_array( $xbrlData[ 'Goodwill' ][ $goodwillInc ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
							if( array_key_exists( '_value:', $xbrlData[ 'Goodwill' ][ $goodwillInc ] ) ) {
								$Goodwill = $xbrlData[ 'Goodwill' ][ $goodwillInc ][ '_value:' ];
								break;
							}
						}
					}
				}
				$IntangibleAssets = $IntangibleAss + $IntangibleAssetsUnderDevelopmentOrWorkInProgress /*+ $Goodwill*/;

				$ReservesandSurplus = $ReservesandSurplus + $MoneyReceivedAgainstShareWarrants; // document 2.5.3
				$OtherNonCurrentAssets = $OtherNonCurrentAssets + $ForeignCurrencyMonetaryItemTranslationDifferenceAssetAccount; // document 2.5.3
				// End of fields document 2.5.3

				$OtherLongTermLiabilities = $OtherLongTermLiabil + $DeferredGovernmentGrants + $ForeignCurrencyMonetaryItemTranslationDifferenceLiabilityAccount; // document 2.5.3
				$TotalNonCurrentLiabilities = $NonCurrentLiabilities + $DeferredGovernmentGrants;
				// Reassign values from previous values.
				if( ( empty( $ShareCapital ) || $ShareCapital == 0 ) && ( empty( $ReservesandSurplus ) || $ReservesandSurplus == 0 ) && ( empty( $TotalShareholdersFunds ) || $TotalShareholdersFunds == 0 ) && 
					( empty( $ShareApplicationMoney ) || $ShareApplicationMoney == 0 ) && ( empty( $MinorityInterest ) || $MinorityInterest == 0 ) && ( empty( $LongtermBorrowings ) || $LongtermBorrowings == 0 ) && 
					( empty( $DeferredTaxLiabilities ) || $DeferredTaxLiabilities == 0 ) && ( empty( $OtherLongTermLiabilities ) || $OtherLongTermLiabilities == 0 ) && ( empty( $LongTermProvisions ) || $LongTermProvisions == 0 ) && 
					( empty( $TotalNonCurrentLiabilities ) || $TotalNonCurrentLiabilities == 0 ) && ( empty( $ShortTermBorrowings ) || $ShortTermBorrowings == 0 ) && ( empty( $TradePayable ) || $TradePayable == 0 ) && 
					( empty( $OtherCurrentLiabilities ) || $OtherCurrentLiabilities == 0 ) && ( empty( $ShortTermProvisions ) || $ShortTermProvisions == 0 ) && ( empty( $TotalCurrentLiabilities ) || $TotalCurrentLiabilities == 0 ) && 
					( empty( $TotalEquityAndLiabilities ) || $TotalEquityAndLiabilities == 0 ) && ( empty( $TangibleAssets ) || $TangibleAssets == 0 ) && ( empty( $IntangibleAssets ) || $IntangibleAssets == 0 ) && 
					( empty( $TotalFixedAssets ) || $TotalFixedAssets == 0 ) && ( empty( $NoncurrentInvestments ) || $NoncurrentInvestments == 0 ) && ( empty( $DeferredTaxAssets ) || $DeferredTaxAssets == 0 ) && 
					( empty( $LongTermLoansAndAdvances ) || $LongTermLoansAndAdvances == 0 ) && ( empty( $OtherNonCurrentAssets ) || $OtherNonCurrentAssets == 0 ) && ( empty( $TotalNonCurrentAssets ) || $TotalNonCurrentAssets == 0 ) && 
					( empty( $CurrentInvestments ) || $CurrentInvestments == 0 ) && ( empty( $Inventories ) || $Inventories == 0 ) && ( empty( $TradeReceivables ) || $TradeReceivables == 0 ) && 
					( empty( $CashandBankBalances ) || $CashandBankBalances == 0 ) && ( empty( $ShortTermLoansAdvances ) || $ShortTermLoansAdvances == 0 ) && ( empty( $OtherCurrentAssets ) || $OtherCurrentAssets == 0 ) && 
					( empty( $TotalCurrentAssets ) || $TotalCurrentAssets == 0 ) && ( empty( $TotalAssets ) || $TotalAssets == 0 ) ) {

					if( isset( $previousData[ 'bs' ][ $fy ][ 'Share capital' ] ) ) {
						$ShareCapital = $previousData[ 'bs' ][ $fy ][ 'Share capital' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Reserves and surplus' ] ) ) {
						$ReservesandSurplus = $previousData[ 'bs' ][ $fy ][ 'Reserves and surplus' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total shareholders funds' ] ) ) {
						$TotalShareholdersFunds = $previousData[ 'bs' ][ $fy ][ 'Total shareholders funds' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ] ) ) {
						$ShareApplicationMoney = $previousData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Minority interest' ] ) ) {
						$MinorityInterest = $previousData[ 'bs' ][ $fy ][ 'Minority interest' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Long-term borrowings' ] ) ) {
						$LongtermBorrowings = $previousData[ 'bs' ][ $fy ][ 'Long-term borrowings' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ] ) ) {
						$DeferredTaxLiabilities = $previousData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ] ) ) {
						$OtherLongTermLiabilities = $previousData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Long-term provisions' ] ) ) {
						$LongTermProvisions = $previousData[ 'bs' ][ $fy ][ 'Long-term provisions' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ] ) ) {
						$TotalNonCurrentLiabilities = $previousData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Short-term borrowings' ] ) ) {
						$ShortTermBorrowings = $previousData[ 'bs' ][ $fy ][ 'Short-term borrowings' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Trade payables' ] ) ) {
						$TradePayable = $previousData[ 'bs' ][ $fy ][ 'Trade payables' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other current liabilities' ] ) ) {
						$OtherCurrentLiabilities = $previousData[ 'bs' ][ $fy ][ 'Other current liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Short-term provisions' ] ) ) {
						$ShortTermProvisions = $previousData[ 'bs' ][ $fy ][ 'Short-term provisions' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total current liabilities' ] ) ) {
						$TotalCurrentLiabilities = $previousData[ 'bs' ][ $fy ][ 'Total current liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ] ) ) {
						$TotalEquityAndLiabilities = $previousData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Tangible assets' ] ) ) {
						$TangibleAssets = $previousData[ 'bs' ][ $fy ][ 'Tangible assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Intangible assets' ] ) ) {
						$IntangibleAssets = $previousData[ 'bs' ][ $fy ][ 'Intangible assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total fixed assets' ] ) ) {
						$TotalFixedAssets = $previousData[ 'bs' ][ $fy ][ 'Total fixed assets' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Non-current investments' ] ) ) {
						$NoncurrentInvestments = $previousData[ 'bs' ][ $fy ][ 'Non-current investments' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ] ) ) {
						$DeferredTaxAssets = $previousData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ] ) ) {
						$LongTermLoansAndAdvances = $previousData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ];	
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other non-current assets' ] ) ) {
						$OtherNonCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Other non-current assets' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total non-current assets' ] ) ) {
						$TotalNonCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Total non-current assets' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Current investments' ] ) ) {
						$CurrentInvestments = $previousData[ 'bs' ][ $fy ][ 'Current investments' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Inventories' ] ) ) {
						$Inventories = $previousData[ 'bs' ][ $fy ][ 'Inventories' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Trade receivables' ] ) ) {
						$TradeReceivables = $previousData[ 'bs' ][ $fy ][ 'Trade receivables' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Cash and bank balances' ] ) ) {
						$CashandBankBalances = $previousData[ 'bs' ][ $fy ][ 'Cash and bank balances' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ] ) ) {
						$ShortTermLoansAdvances = $previousData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Other current assets' ] ) ) {
						$OtherCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Other current assets' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total current assets' ] ) ) {
						$TotalCurrentAssets = $previousData[ 'bs' ][ $fy ][ 'Total current assets' ];
					}
					if( isset( $previousData[ 'bs' ][ $fy ][ 'Total assets' ] ) ) {
						$TotalAssets = $previousData[ 'bs' ][ $fy ][ 'Total assets' ];
					}
				}

				$TotalCurrentLiabilitiesCheck = $ShortTermBorrowings + $TradePayable + $OtherCurrentLiabilities + $ShortTermProvisions;
				$TotalEquityAndLiabilitiesCheck = $TotalCurrentLiabilities + $TotalNonCurrentLiabilities + $MinorityInterest + $ShareApplicationMoney + $TotalShareholdersFunds;
				$TotalNonCurrentLiabilitiesCheck = $LongtermBorrowings + $DeferredTaxLiabilities + $OtherLongTermLiabilities + $LongTermProvisions;
				$TotalNonCurrentAssetsCheck = $TotalFixedAssets + $NoncurrentInvestments + $DeferredTaxAssets + $LongTermLoansAndAdvances + $OtherNonCurrentAssets;
				$TotalCurrentAssetsCheck = $CurrentInvestments + $Inventories + $TradeReceivables + $CashandBankBalances + $ShortTermLoansAdvances + $OtherCurrentAssets;
				$TotalAssetsCheck = $TotalCurrentAssets + $TotalNonCurrentAssets;				


				// Validation given in google sheet is added.
				$TotalShareholdersFundsCheck = $ShareCapital + $ReservesandSurplus;
				$diffTotalShareholdersFunds = $TotalShareholdersFunds - $TotalShareholdersFundsCheck;
				if( $TotalShareholdersFunds != $TotalShareholdersFundsCheck ) {
					if( abs( $diffTotalShareholdersFunds ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total shareholders' funds mismatch";
						$errorReport++;
					}
				}
				$diffTotalNonCurrentLiabilities = $TotalNonCurrentLiabilities - $TotalNonCurrentLiabilitiesCheck;
				if( $TotalNonCurrentLiabilities != $TotalNonCurrentLiabilitiesCheck ) {
					if( abs( $diffTotalNonCurrentLiabilities ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total Non-Current Liabilites mismatch";
						$errorReport++;
					}
				}
				$diffTotalCurrentLiabilities = $TotalCurrentLiabilities - $TotalCurrentLiabilitiesCheck;
				if( $TotalCurrentLiabilities != $TotalCurrentLiabilitiesCheck ) {
					if( abs( $diffTotalCurrentLiabilities ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total current liabilities mismatch";
						$errorReport++;
					}
				}
				$diffTotalEquityAndLiabilities = $TotalEquityAndLiabilities - $TotalEquityAndLiabilitiesCheck;
				if( $TotalEquityAndLiabilities != $TotalEquityAndLiabilitiesCheck ) {
					if( abs( $diffTotalEquityAndLiabilities ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total equity and liabilities mismatch";
						$errorReport++;
					}
				}
				$diffTotalNonCurrentAssets = $TotalNonCurrentAssets - $TotalNonCurrentAssetsCheck;
				if( $TotalNonCurrentAssets != $TotalNonCurrentAssetsCheck ) {
					if( abs( $diffTotalNonCurrentAssets ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total non-current assets mismatch";
						$errorReport++;
					}
				}
				$diffTotalCurrentAssets = $TotalCurrentAssets - $TotalCurrentAssetsCheck;
				if( $TotalCurrentAssets != $TotalCurrentAssetsCheck ) {
					if( abs( $diffTotalCurrentAssets ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total current assets mismatch";
						$errorReport++;
					}
				}
				$diffTotalAssets = $TotalAssets - $TotalAssetsCheck;
				if( $TotalAssets != $TotalAssetsCheck ) {
					if( abs( $diffTotalAssets ) > 20 ) {
						$errorArray[ $cin ]['bs'][$fy][] = "FY".$fy . " - Total assets mismatch";
						$errorReport++;
					}
				}
				// XML parsed data assigned to variable which will be sent to excel file generation.
				if( ( ( empty( $ShareCapital ) || $ShareCapital == 0 ) && ( empty( $ReservesandSurplus ) || $ReservesandSurplus == 0 ) && ( empty( $TotalShareholdersFunds ) || $TotalShareholdersFunds == 0 ) && 
					( empty( $ShareApplicationMoney ) || $ShareApplicationMoney == 0 ) && ( empty( $MinorityInterest ) || $MinorityInterest == 0 ) && ( empty( $LongtermBorrowings ) || $LongtermBorrowings == 0 ) && 
					( empty( $DeferredTaxLiabilities ) || $DeferredTaxLiabilities == 0 ) && ( empty( $OtherLongTermLiabilities ) || $OtherLongTermLiabilities == 0 ) && ( empty( $LongTermProvisions ) || $LongTermProvisions == 0 ) && 
					( empty( $TotalNonCurrentLiabilities ) || $TotalNonCurrentLiabilities == 0 ) && ( empty( $ShortTermBorrowings ) || $ShortTermBorrowings == 0 ) && ( empty( $TradePayable ) || $TradePayable == 0 ) && 
					( empty( $OtherCurrentLiabilities ) || $OtherCurrentLiabilities == 0 ) && ( empty( $ShortTermProvisions ) || $ShortTermProvisions == 0 ) && ( empty( $TotalCurrentLiabilities ) || $TotalCurrentLiabilities == 0 ) && 
					( empty( $TotalEquityAndLiabilities ) || $TotalEquityAndLiabilities == 0 ) && ( empty( $TangibleAssets ) || $TangibleAssets == 0 ) && ( empty( $IntangibleAssets ) || $IntangibleAssets == 0 ) && 
					( empty( $TotalFixedAssets ) || $TotalFixedAssets == 0 ) && ( empty( $NoncurrentInvestments ) || $NoncurrentInvestments == 0 ) && ( empty( $DeferredTaxAssets ) || $DeferredTaxAssets == 0 ) && 
					( empty( $LongTermLoansAndAdvances ) || $LongTermLoansAndAdvances == 0 ) && ( empty( $OtherNonCurrentAssets ) || $OtherNonCurrentAssets == 0 ) && ( empty( $TotalNonCurrentAssets ) || $TotalNonCurrentAssets == 0 ) && 
					( empty( $CurrentInvestments ) || $CurrentInvestments == 0 ) && ( empty( $Inventories ) || $Inventories == 0 ) && ( empty( $TradeReceivables ) || $TradeReceivables == 0 ) && 
					( empty( $CashandBankBalances ) || $CashandBankBalances == 0 ) && ( empty( $ShortTermLoansAdvances ) || $ShortTermLoansAdvances == 0 ) && ( empty( $OtherCurrentAssets ) || $OtherCurrentAssets == 0 ) && 
					( empty( $TotalCurrentAssets ) || $TotalCurrentAssets == 0 ) && ( empty( $TotalAssets ) || $TotalAssets == 0 ) ) || ( ( $TotalEquityAndLiabilities != $TotalAssets ) || ( ( $TotalEquityAndLiabilities == $TotalAssets ) && ( $TotalEquityAndLiabilities == 0 && $TotalAssets == 0 ) ) ) ) {
					// Unset the FY data if condition failed. remove curresponding FY error data.
					unset( $xmlParseData[ 'bs' ][ $fy ] );
					$errorReport = $errorReport - count( $errorArray[ $cin ]['bs'][$fy] );
					unset( $errorArray[ $cin ]['bs'][$fy] );
				} else {
					$xmlParseData[ 'bs' ][ $fy ][ 'Share capital' ] = $ShareCapital;
					$xmlParseData[ 'bs' ][ $fy ][ 'Reserves and surplus' ] = $ReservesandSurplus;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total shareholders funds' ] = $TotalShareholdersFunds;
					$xmlParseData[ 'bs' ][ $fy ][ 'Share application money pending allotment' ] = $ShareApplicationMoney;
					$xmlParseData[ 'bs' ][ $fy ][ 'Minority interest' ] = $MinorityInterest;
					$xmlParseData[ 'bs' ][ $fy ][ 'Long-term borrowings' ] = $LongtermBorrowings;
					$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax liabilities (net)' ] = $DeferredTaxLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other long-term liabilities' ] = $OtherLongTermLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Long-term provisions' ] = $LongTermProvisions;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current liabilities' ] = $TotalNonCurrentLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Short-term borrowings' ] = $ShortTermBorrowings;
					$xmlParseData[ 'bs' ][ $fy ][ 'Trade payables' ] = $TradePayable;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other current liabilities' ] = $OtherCurrentLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Short-term provisions' ] = $ShortTermProvisions;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total current liabilities' ] = $TotalCurrentLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total equity and liabilities' ] = $TotalEquityAndLiabilities;
					$xmlParseData[ 'bs' ][ $fy ][ 'Tangible assets' ] = $TangibleAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Intangible assets' ] = $IntangibleAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total fixed assets' ] = $TotalFixedAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Non-current investments' ] = $NoncurrentInvestments;	
					$xmlParseData[ 'bs' ][ $fy ][ 'Deferred tax assets (net)' ] = $DeferredTaxAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Long-term loans and advances' ] = $LongTermLoansAndAdvances;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other non-current assets' ] = $OtherNonCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total non-current assets' ] = $TotalNonCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Current investments' ] = $CurrentInvestments;
					$xmlParseData[ 'bs' ][ $fy ][ 'Inventories' ] = $Inventories;
					$xmlParseData[ 'bs' ][ $fy ][ 'Trade receivables' ] = $TradeReceivables;
					$xmlParseData[ 'bs' ][ $fy ][ 'Cash and bank balances' ] = $CashandBankBalances;
					$xmlParseData[ 'bs' ][ $fy ][ 'Short-term loans and advances' ] = $ShortTermLoansAdvances;
					$xmlParseData[ 'bs' ][ $fy ][ 'Other current assets' ] = $OtherCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total current assets' ] = $TotalCurrentAssets;
					$xmlParseData[ 'bs' ][ $fy ][ 'Total assets' ] = $TotalAssets;
					foreach( $errorArray[ $cin ]['bs'][$fy] as $bstext ) {
						$logs->logWrite( $bstext, true );
					}
				}
			}
			//CF DATA STARTS
			if( $addCFFlag > 0 ) {
				
				$plBeforeExtraordinary = $operatingActivities = $investingActivities = $financingActivities = $incdecCashEquivalents = $cashEquivalentsBeginYear = $cashEquivalentsEndYear = 0;
				//echo $cfloopCount; exit();
				for( $cfloopInc = 0; $cfloopInc < $cfloopCount; $cfloopInc++ ) {
					if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) && isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_value:' ];
						}
					}else if( isset( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'ProfitBeforePriorPeriodItemsExceptionalItemsExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_value:' ];
						}
					} else if( isset( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ] ) ) {
						if( in_array( $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'ProfitBeforeExtraordinaryItemsAndTax' ][$cfloopInc ][ '_value:' ];
						}
					} else {
						if( in_array( $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$plBeforeExtraordinary = $xbrlData[ 'NetProfitLossbeforeTaxPriorPeriodAndExtraordinaryItems' ][$cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ] ) ) {
						if( in_array( $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][$cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$operatingActivities = $xbrlData[ 'CashFlowsFromUsedInOperatingActivities' ][ $cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ] ) ) {
						if( in_array( $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$investingActivities = $xbrlData[ 'CashFlowsFromUsedInInvestingActivities' ][ $cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ] ) ) {
						if( in_array( $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ][$cfloopInc][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$financingActivities = $xbrlData[ 'CashFlowsFromUsedInFinancingActivitiesBeforeExtraordinaryItems' ][ $cfloopInc ][ '_value:' ];
						}
					}
					if( isset( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ] ) ) {
						if( in_array( $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $cfloopInc ][ '_attributes:' ][ 'contextRef' ], $cfArray[ $fy ] ) ) {
							$incdecCashEquivalents = $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $cfloopInc ][ '_value:' ];
						}
					}
					// For CashAndCashEquivalentsCashFlowStatement
					for( $cfloopInc1 = 0; $cfloopInc1 < count( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ]); $cfloopInc1++ ) {
						if( isset( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ] ) ) {
							if( in_array( $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_attributes:' ][ 'contextRef' ], $bsArray[ $fy ] ) ) {
								$cashEquivalentsEndYear = $xbrlData[ 'CashAndCashEquivalentsCashFlowStatement' ][ $cfloopInc1 ][ '_value:' ];
							}
						}
					}
				}	
					//$incdecCashEquivalents = $xbrlData[ 'IncreaseDecreaseInCashAndCashEquivalents' ][ $cfloopInc ][ '_value:' ];
				// Reverting data to previous if not found
				if( ( empty( $plBeforeExtraordinary ) || $plBeforeExtraordinary == 0 ) && ( empty( $operatingActivities ) || $operatingActivities == 0 ) && ( empty( $investingActivities ) || $investingActivities == 0 ) && ( empty( $financingActivities ) || $financingActivities == 0 ) && 
					( empty( $incdecCashEquivalents ) || $incdecCashEquivalents == 0 ) ) {
					
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] ) ) {
						$plBeforeExtraordinary = $previousData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ] ) ) {
						$operatingActivities = $previousData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ] ) ) {
						$investingActivities = $previousData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Cash Used From Financing Activities' ] ) ) {
						$financingActivities = $previousData[ 'cf' ][ $fy ][ 'Share application money pending allotment' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ] ) ) {
						$incdecCashEquivalents = $previousData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ];	
					}
					if( isset( $previousData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ] ) ) {
						$cashEquivalentsEndYear = $previousData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ];	
					}
					
				}

				
				// XML parsed data assigned to variable which will be sent to excel file generation.
				if( ( empty( $plBeforeExtraordinary ) || $plBeforeExtraordinary == 0 ) && ( empty( $operatingActivities ) || $operatingActivities == 0 ) && ( empty( $investingActivities ) || $investingActivities == 0 ) && ( empty( $financingActivities ) || $financingActivities == 0 ) && 
					( empty( $incdecCashEquivalents ) || $incdecCashEquivalents == 0 ) ) {
					
					unset( $xmlParseData[ 'cf' ][ $fy ] );
					$errorReport = $errorReport - count( $errorArray[ $cin ]['cf'][$fy] );
					unset( $errorArray[ $cin ]['cf'][$fy] );
				} else {
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Profit/Loss Before Extraordinary Items And Tax' ] = $plBeforeExtraordinary;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net CashFlow From Operating Activities' ] = $operatingActivities;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used In Investing Activities' ] = $investingActivities;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Cash Used From Financing Activities' ] = $financingActivities;
					$xmlParseData[ 'cf' ][ $fy ][ 'Net Inc/Dec In Cash And Cash Equivalents' ] = $incdecCashEquivalents;
					$xmlParseData[ 'cf' ][ $fy ][ 'Cash And Cash Equivalents End Of Year' ] = $cashEquivalentsEndYear;
					
					
					foreach( $errorArray[ $cin ]['cf'][$fy] as $bstext ) {
						$logs->logWrite( $bstext, true );
					}
				}
			
			//CF END

			}
		}
		unset( $previousData ); // Previous data unset.
		return array( 'data' => $xmlParseData, 'error' => $errorReport, 'error_array' => $errorArray  );
	}
	
	/**
	 * NEW format standalone xml data fetching to process SHP.
	 * Validation rules are applied.
	 * Returns: Data of SHP in data key, Error data and error count is returned.
	*/
		
	public function xbrlSHP( $xbrlData = '', $cin = '') {
		global $logs;
		global $isSHP;
		$xmlParseData = array();
		
		$tagnameNew = ['DisclosureInBoardOfDirectorsReportExplanatoryTextBlock','DisclosureOfExtractOfAnnualReturnAsProvidedUnderSubSection3OfSection92TextBlock','DisclosureInBoardOfDirectorsReportExplanatory','DisclosureOfExtractOfAnnualReturnAsProvidedUnderSubSection3OfSection92Explanatory'];
		for ($i=0; $i < count($tagnameNew); $i++) { 
			if (array_key_exists($tagnameNew[$i],$xbrlData))
			{
				$str = $xbrlData[ $tagnameNew[$i] ][ 0 ][ '_value:' ];
				if ( preg_match("/\b(Shareholding of Promoter|Shareholding of Promoters)\b/i",$str) ) {
					
					$logs->logWrite( "Shareholding of Promoters Found In The XML");
					$tagContent = $xbrlData[ $tagnameNew[$i] ][ 0 ][ '_value:' ];
					$tagContent = str_replace("<span>","",$tagContent);
					$tagContent = str_replace("</span>","",$tagContent);
					$tagContent = str_replace("<br","",$tagContent);
					$tagContent = str_replace("/>","",$tagContent);
					//$tagContent = trim(preg_replace('/\s\s+/', ' ', $tagContent));
				}
			}
		}
		if($tagContent != ''){
			$tagContent = "<style>td{border:1px solid #ccc;padding:5px}table{border:1px solid #ccc;padding:5px}.promoters{padding:10px;background:#ff0}.promoters-content{background:#ff0}.promoters-end, .share-holders-end{background:red;padding:10px}.share-holders{background:#6868cc;color:#fff}.share-holders-content{background:#6868cc;color:#fff}</style>".$tagContent;
			$dom = new DOMDocument;
			libxml_use_internal_errors(true);
			$dom->loadHTML($tagContent);
			libxml_clear_errors();
			$xPath = new DOMXpath($dom);
			$domNodePromotersStart = $xPath->query('//*[contains(text(), "Shareholding of Promoters") or contains(text(),"Shareholding of Promoter") or contains(text(),"ShareholdingofPromoters") or contains(text(),"SHAREHOLDING OF PROMOTERS") or contains(text(),"SHAREHOLDING OF PROMOTER")]');
			$domNodePromotersEnd = $xPath->query('//*[contains(text(), "Change in Promoters") or contains(text(), "ChangeinPromoters")]');
			$domNodeShareholdingStart = $xPath->query('//*[contains(text(), "Shareholding Pattern of top ten Shareholders") or contains(text(), "Shareholding Pattern of Top Ten Shareholders") or contains(text(), "ShareholdingPattern of top ten Shareholders") or contains(text(), "SHAREHOLDING PATTERN OF TOP TEN SHAREHOLDERS") or contains(text(), "Shareholding pattern of top ten shareholders")]');
			$domNodeShareholdingEnd = $xPath->query('//*[contains(text(), "Shareholding of Directors and Key Managerial Personnel") or contains(text(), "ShareholdingofDirectorsandKeyManagerialPersonnel") or contains(text(), "Shareholding of Directors") or contains(text(), "SHAREHOLDING OF DIRECTORS AND KEY MANAGERIAL PERSONNEL")]');
			
			//echo $domNodeShareholdingEnd->length;
			foreach ($domNodePromotersStart as $element){ 
				$element->setAttribute('class', "promoters");
			}
			foreach ($domNodePromotersEnd as $element){ 
				$element->setAttribute('class', "promoters-end");
			}
			foreach ($domNodeShareholdingStart as $element){ 
				$element->setAttribute('class', "share-holders");
			}
			foreach ($domNodeShareholdingEnd as $element){ 
				$element->setAttribute('class', "share-holders-end");
			}
			$logs->logWrite( "Added Classname to the Generated HTML");
			$domNodePromotersHeading = $xPath->query("//*[@class='promoters']");
			
			foreach ($domNodePromotersHeading as $element){ 
				$nextSibling = $element->nextSibling;
				$nextSiblingTable = true;
				while ($nextSibling && $nextSiblingTable){
					if($nextSibling->nodeName == "table")
					{ 
						$nextSibling->setAttribute('class', "promoters-content");
						$nextSibling = $nextSibling->nextSibling;
					} else if ($nextSibling->nodeName == 'p' || $nextSibling->nodeName == 'div'){
						$clasaName = $nextSibling->getAttribute('class');
						if($clasaName == 'promoters-end' && $clasaName != ''){
							$nextSiblingTable = false;
							break;
						} else {
							$nextSibling = $nextSibling->nextSibling;
						}
					} else {
						$nextSibling = $nextSibling->nextSibling;
					}
				}
			}
			
			$domNodeShareholdingHeading = $xPath->query("//*[@class='share-holders']");
			foreach ($domNodeShareholdingHeading as $element){ 
				$nextSibling = $element->nextSibling;
				$nextSiblingTable = true;
				while ($nextSibling){
					//echo $nextSibling->nodeName;
					if($nextSibling->nodeName == "table")
					{ 
						$nextSibling->setAttribute('class', "share-holders-content");
						$nextSibling = $nextSibling->nextSibling;
					} else if ($nextSibling->nodeName == 'p' || $nextSibling->nodeName == 'div'){
						$clasaName = $nextSibling->getAttribute('class');
						if($clasaName == 'share-holders-end' && $clasaName != ''){
							$nextSiblingTable = false;
							break;
						} else {
							$nextSibling = $nextSibling->nextSibling;
						}
					} else {
						$nextSibling = $nextSibling->nextSibling;
					}
				}
			}
			
			$tagContent = $dom->saveHTML();
			$tagContent = preg_replace("/&#?[a-z0-9]+;/i","",$tagContent); 
			//echo $tagContent;
			//exit();
			$htmlFolderSHP  = "SHP_HTML";
			$Dir = FOLDER_CREATE_PATH.$htmlFolderSHP;
			try {
				if( !is_dir( $Dir ) ){
					mkdir($Dir,0777);chmod($Dir, 0777);
				}
			} catch( Exception $e ) {
				echo $e->getMessage();
			}
			$htmlFileName = "SHP_HTML_".$cin.".html";
			$target_Path = $Dir.'/';
			$fileOriginalPath = $target_Path.$htmlFileName;
			
			try {
				$fp = fopen($fileOriginalPath,"wb");
				fwrite($fp,$tagContent);
				fclose($fp);
			} catch( Exception $e ) {
				echo $e->getMessage();
			}
			$logs->logWrite( "Generated HTML file has been saved in the folder");
			
			$dom = new DomDocument;
			/* Load the HTML */
			$dom->loadHTMLFile($fileOriginalPath);
			// $dom->loadHTMLFile("SHP_HTML_U74130KA2005PTC087280.html");
			//$dom->loadHTMLFile("SHP_HTML_U85110KA1993PLC015001.html"); 
			/* Create a new XPath object */
			$xpath = new DomXPath($dom);  
			$xpath->registerNamespace('php', 'http://php.net/xpath');
			$xpath->registerPhpFunctions(array('preg_match'));
			
			//$shpPromotersContent = $xpath->query("//table[@class='promoters-content'][php:functionString('preg_match', '/No.\s?of Share/i', .//tr[2]/td[3]) > 0 and php:functionString('preg_match', '/No.\s?of Share/i', .//tr[2]/td[6]) > 0]");
			$shpPromotersContent = $xpath->query("//table[@class='promoters-content'][php:functionString('preg_match', '/No.\s?of Shares?/i', .//tr[2]/td[3]) > 0 and (php:functionString('preg_match', '/No.\s?of Shares?/i', .//tr[2]/td[6]) > 0 or php:functionString('preg_match', '/No.\s?of Shares?/i', .//tr[2]/td[7]) > 0)]");
			//echo 'shpPromotersContent = '.$shpPromotersContent->length."<br />";
			$endIteration = true;
			$firstOccurence = false;
			//echo $shpPromotersContent->length;exit(); 
			if($shpPromotersContent->length>=1) {
				$tables = $xpath->query("//table[@class='promoters-content']");
				foreach($tables as $table) { 
				$tableTrs = $xpath->query(".//tr",$table);
				$promoters = array();
				$count = 0;
				foreach($tableTrs as $indexRow=>$tableTr) { 
					$tableTds = $xpath->query('.//td', $tableTr);
					foreach($tableTds as $index=>$tableTd) {    
						if($indexRow==0) {  
							if(preg_match('/^(Shareholder)|Name/i',$tableTd->nodeValue)) {
								$SHN_P = $index;
								continue 2;
							} 
						} 
						else if($indexRow==1) { 
							if((!($firstOccurence)) && preg_match('/(No. of Shares?|No.of Shares?)/i',$tableTd->nodeValue)) {
								$BEG_P = $index;
								$firstOccurence = true;
								continue;
							} 
							if($firstOccurence && preg_match('/(No.of Shares?|No. of Shares?)/i',$tableTd->nodeValue)) {
								$END_P = $index;
							} 
						} else  { 
							
							if(preg_match('/(Total\s+|Total)$/i',$tableTd->nodeValue)) {
								break;
							}
							
							if($index == $SHN_P) {
								$count = $count + 1;
								$promoters[$count]["name"]=trim($tableTd->nodeValue); 
							} 
							if($index == $BEG_P) {
								$promoters[$count]["start-shares"]=trim(preg_replace('/[,]/', '', $tableTd->nodeValue));
							}
							if($index == $END_P) {
							$promoters[$count]["end-shares"]=trim(preg_replace('/[,]/', '', $tableTd->nodeValue));
							} 
							$isSHP = true;
							
						}
						
						
					} 
					
				}   
					$logs->logWrite( "Shareholding of Promoters Found");
				}
				}		else {
					$logs->logWrite( "Pattern Mismatch Found in the Shareholding of Promoters"); 
				}
	
		/******************   Top Ten Share Holders   **********/

			$noOfShare='false';
			//$tableTrs = $xpath->query("//table[@class='share-holders-content']//tr");
			$nextName = 'false';
			$SHN_P="";
			$shareHolderValidation = $xpath->query("//table[@class='share-holders-content'][php:functionString('preg_match', '/At the beginning of the year/i', .//tr[3]/td[3]) > 0 or php:functionString('preg_match', '/At the beginning of the year/i', .//tr[3]/td[2]) > 0]");
			$shareHolderValidation2 = $xpath->query("//table[@class='share-holders-content'][php:functionString('preg_match', '/^At the beginning of the year/i', .//tr[1]/td[2]) > 0]");
			$shareHolderValidation3 = $xpath->query("//table[@class='share-holders-content'][php:functionString('preg_match', '/At the beginning of the year/i', .//tr[4]/td[1]) > 0 and php:functionString('preg_match', '/No. of shares/i', .//tr[2]/td[2])]");

			//echo "shareHolderValidation->length=".$shareHolderValidation->length."<br />";
			$shareHoldercount = 0;
			$shareHolderArray = array();
			if($shareHolderValidation->length >=1 || $shareHolderValidation3->length >=1) {  
			$tables = $xpath->query("//table[@class='share-holders-content']");
			$foundAtFirstRow = false;
			foreach($tables as $table) {  
			$tableTrs =  $xpath->query('.//tr', $table);
			foreach($tableTrs as $indexRow=>$tableTr) { 
				$tableTds = $xpath->query('.//td', $tableTr);
				foreach($tableTds as $index=>$tableTd) {  
					if($indexRow==0) {  
						if(preg_match('/Name of the Shareholder|Name|Shareholders?/i',$tableTd->nodeValue)) {
							$SHN_P = $index;
							continue 2;
						} 
					} 

					if($indexRow!=0) {  
					
					if($indexRow==1 && $index == 0) {  
							if(preg_match('/[0-9]/',$tableTd->nodeValue)) {
							// if($index == $SHN_P) { 
									$nextelement = $xpath->query("following-sibling::td[1]", $tableTd); 
									$shareHoldercount = $shareHoldercount + 1;
									// $shareHolderArray[$shareHoldercount]["name"] = trim($nextelement[0]->nodeValue); 
									$shareHolderArray[$shareHoldercount]["name"] = 	preg_replace('/^([0-9]+.)/i', '', trim($nextelement[0]->nodeValue));  
									$nextName = 'false';
							// }
								$foundAtFirstRow = true;  
							}else { 
								$foundAtFirstRow = false;  
							}
					} else if($indexRow==2 && $foundAtFirstRow == false) {
							if($index == $SHN_P) { 
								$shareHoldercount = $shareHoldercount + 1; 
								// $shareHolderArray[$shareHoldercount]["name"] = trim($tableTd->nodeValue); 
								$shareHolderArray[$shareHoldercount]["name"] = preg_replace('/^([0-9]+.)/i', '', trim($tableTd->nodeValue)); 
								$nextName = 'false';
							}
					} else {
							if(@$nextName=='true') {
								if($index == $SHN_P) { 
									$shareHoldercount = $shareHoldercount + 1;
								//	$shareHolderArray[$shareHoldercount]["name"] = trim($tableTd->nodeValue); 
									$shareHolderArray[$shareHoldercount]["name"] = preg_replace('/^([0-9]+.)/i', '', trim($tableTd->nodeValue)); 
									
									$nextName = 'false';
								}	
							}
					} 
					if(preg_match('/(At the beginning of the year)/i',$tableTd->nodeValue)) {   
						$nextelement = $xpath->query("following-sibling::td[1]", $tableTd); 
						$shareHolderArray[$shareHoldercount]["start-shares"] = trim(preg_replace('/[,]/', '',  $nextelement[0]->nodeValue));
						$nextName = 'false'; 
					}
						
					if(preg_match('/(At the End of the year)/i',$tableTd->nodeValue)) {   
						$nextelement = $xpath->query("following-sibling::td[1]", $tableTd); 
						$shareHolderArray[$shareHoldercount]["end-shares"] = trim(preg_replace('/[,]/', '',  $nextelement[0]->nodeValue)); 
						$nextName = 'true'; 
					}
						$isSHP = true;
						$logs->logWrite( "Shareholding Pattern of top ten Shareholders Found");
					}  
			
				} // td
				
				} // tr 
			}  // Table
			
			
			} else {
				$logs->logWrite( "Pattern Mismatch Found in the Shareholding Pattern of top ten Shareholders");
			}
				return array( 'promoters' => $promoters, 'shareholder' => $shareHolderArray);
		} else {
			$logs->logWrite( "Shareholders Not Found");	
		}
	}
}
?>