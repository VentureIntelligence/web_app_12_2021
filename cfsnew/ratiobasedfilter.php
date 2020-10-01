<?php 
        // T975 RATIO BASED SEARCH - QUERY With Conditions Start
        $Rend=count($_REQUEST['answer']['RatioSearchFieds'])-1;
        for($i=0;$i<count($_REQUEST['answer']['RatioSearchFieds']);$i++){
            if($_REQUEST['answer']['RatioSearchFieds'][$i] != ""){
                    $RGtrt = 'RGrtr_'.$i;
                    $value=$PL_STNDRATIOFIELDS[$_REQUEST['answer']['RatioSearchFieds'][$i]];
                    if($_REQUEST['RCommonandor'] == "" || $_REQUEST['RCommonandor'] == "and"){
                        if($_REQUEST[$RGtrt] != ""){
                            if($value == "Current Ratio"){
                                $where .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                
                            }elseif($value == "Quick Ratio"){
                                    
                                $where .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                
                            }elseif($value == "Debt Equity Ratio"){
                                
                                $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "RoE"){
                                
                                $where .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "RoA"){
                                
                                $where .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "Asset Turnover Ratio"){
                                $where .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "EBITDA Margin. (%)"){
                                
                                $where .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "PAT Margin. (%)"){
                                
                                $where .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "Contribution margin. (%)"){
                                $valueValid = " and (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                $where .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }else{
                                
                                $where .= "" ;
                                $whereCountNew .= "" ;
                                $whereHomeCountNew .= " " ;
                            }
                        }
                        $RLess = 'RLess_'.$i;
                        if($_REQUEST[$RLess] != ""){
                            if($value == "Current Ratio"){
                                $where .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                
                            }elseif($value == "Quick Ratio"){
                                    
                                $where .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                
                            }elseif($value == "Debt Equity Ratio"){
                                
                                $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "RoE"){
                                
                                $where .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "RoA"){
                                
                                $where .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "Asset Turnover Ratio"){
                                $where .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "EBITDA Margin. (%)"){
                                
                                $where .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "PAT Margin. (%)"){
                                
                                $where .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "Contribution margin. (%)"){
                                $valueValid = " and (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                $where .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }else{
                                
                                $where .= "" ;
                                $whereCountNew .= "" ;
                                $whereHomeCountNew .= " " ;
                        
                            }
                        }
                    }elseif($_REQUEST['RCommonandor'] == "or" ){
                        $RGtrt = 'RGrtr_'.$i;
                        if($RGtrt=='RGrtr_0' && !empty($_REQUEST['RGrtr_0'])){
                            if($i == 0){
                                if($_REQUEST[$RGtrt] != ''){
                                    if($value == "Current Ratio"){
                                        $where .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        
                                    }elseif($value == "Quick Ratio"){
                                            
                                        $where .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                        
                                    }elseif($value == "Debt Equity Ratio"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "RoE"){
                                        
                                        $where .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "RoA"){
                                        
                                        $where .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "Asset Turnover Ratio"){
                                        $where .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "EBITDA Margin. (%)"){
                                        
                                        $where .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "PAT Margin. (%)"){
                                        
                                        $where .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "Contribution margin. (%)"){
                                        $valueValid = " and (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                        $where .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }else{
                                        
                                        $where .= "" ;
                                        $whereCountNew .= "" ;
                                        $whereHomeCountNew .= " " ;
                                
                                    }
                                    
                                }
                            }else{
                                if($_REQUEST[$RGtrt] != ''){
                                    if($value == "Current Ratio"){
                                        $where .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        
                                    }elseif($value == "Quick Ratio"){
                                            
                                        $where .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                        
                                    }elseif($value == "Debt Equity Ratio"){
                                        
                                        $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "RoE"){
                                        
                                        $where .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "RoA"){
                                        
                                        $where .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "Asset Turnover Ratio"){
                                        $where .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "EBITDA Margin. (%)"){
                                        
                                        $where .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "PAT Margin. (%)"){
                                        
                                        $where .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= " and (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }
                                    elseif($value == "Contribution margin. (%)"){
                                        $valueValid = " and (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                        $where .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                        $whereHomeCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                    }else{
                                        
                                        $where .= "" ;
                                        $whereCountNew .= "" ;
                                        $whereHomeCountNew .= " " ;
                                
                                    }
                                    
                                }
                            }

                        }elseif($_REQUEST[$RGtrt] != ""){
                            if($value == "Current Ratio"){
                                $where .= " or ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or ((bsn.T_current_assets / bsn.T_current_liabilities) >= "  .($_REQUEST[$RGtrt]).")" ;
                                
                            }elseif($value == "Quick Ratio"){
                                    
                                $where .= " or ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities >= "  .($_REQUEST[$RGtrt]).")" ;
                                
                            }elseif($value == "Debt Equity Ratio"){
                                
                                $where .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "RoE"){
                                
                                $where .= " or ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or ((a.PAT / bsn.TotalFunds) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "RoA"){
                                
                                $where .= " or ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or ((a.PAT / bsn.Total_assets) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "Asset Turnover Ratio"){
                                $where .= " or (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "EBITDA Margin. (%)"){
                                
                                $where .= " or (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or (((a.EBITDA / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "PAT Margin. (%)"){
                                
                                $where .= " or (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= " or (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= " or (((a.PAT / a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }
                            elseif($value == "Contribution margin. (%)"){
                                $valueValid = " or (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                $where .= $valueValid." or ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereCountNew .= $valueValid." or ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                                $whereHomeCountNew .= $valueValid." or ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) >= "  .($_REQUEST[$RGtrt]).")" ;
                            }else{
                                
                                $where .= "" ;
                                $whereCountNew .= "" ;
                                $whereHomeCountNew .= " " ;
                        
                            }
                        }
                        $RLess = 'RLess_'.$i;
                        if($RLess=='RLess_0' && !empty($_REQUEST['RLess_0'])){
                            if($value == "Current Ratio"){
                                $where .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                
                            }elseif($value == "Quick Ratio"){
                                    
                                $where .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                
                            }elseif($value == "Debt Equity Ratio"){
                                
                                $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "RoE"){
                                
                                $where .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "RoA"){
                                
                                $where .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "Asset Turnover Ratio"){
                                $where .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "EBITDA Margin. (%)"){
                                
                                $where .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "PAT Margin. (%)"){
                                
                                $where .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "Contribution margin. (%)"){
                                $valueValid = " and (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                $where .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }else{
                                
                                $where .= "" ;
                                $whereCountNew .= "" ;
                                $whereHomeCountNew .= " " ;
                        
                            }
                        }elseif($_REQUEST[$RLess] != ""){
                            if($value == "Current Ratio"){
                                $where .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets / bsn.T_current_liabilities) < "  .($_REQUEST[$RLess]).")" ;
                                
                            }elseif($value == "Quick Ratio"){
                                    
                                $where .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.T_current_assets - bsn.Inventories) / bsn.T_current_liabilities < "  .($_REQUEST[$RLess]).")" ;
                                
                            }elseif($value == "Debt Equity Ratio"){
                                
                                $where .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((bsn.L_term_borrowings + bsn.S_term_borrowings) / bsn.TotalFunds < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "RoE"){
                                
                                $where .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.TotalFunds) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "RoA"){
                                
                                $where .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and ((a.PAT / bsn.Total_assets) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "Asset Turnover Ratio"){
                                $where .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (a.TotalIncome / ((bsn.Total_assets+bsn1.Total_assets)/2) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "EBITDA Margin. (%)"){
                                
                                $where .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (((a.EBITDA / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "PAT Margin. (%)"){
                                
                                $where .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= " and (((a.PAT / a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }
                            elseif($value == "Contribution margin. (%)"){
                                $valueValid = " and (((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) != 100";
                                $where .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                                $whereHomeCountNew .= $valueValid." and ((((a.TotalIncome - a.CostOfMaterialsConsumed - a.PurchasesOfStockInTrade - a.ChangesInInventories)/a.TotalIncome)*100) < "  .($_REQUEST[$RLess]).")" ;
                            }else{
                                
                                $where .= "" ;
                                $whereCountNew .= "" ;
                                $whereHomeCountNew .= " " ;
                        
                            }
                        }
                    }
                    // print_r($value);
            }//Main If Ends
            //pr($where);
    }//For Ends
    // Please check
    // if($_REQUEST['RCommonandor'] == "or" ){
    //     $where .= " )" ;
    //     $whereCountNew .= " )" ;
    //     $whereHomeCountNew .= " )" ;
    // }
        // exit();
    // T975 RATIO BASED SEARCH End
?>