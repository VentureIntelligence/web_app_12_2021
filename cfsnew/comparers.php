<?php
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."balancesheet.php";
$balancesheet = new balancesheet();
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);

$fields = array("*");
//print_r($_REQUEST);
$CompareCount = count($_REQUEST['answer']['CCompanies']);
if($_REQUEST['resetcompany']!="")
{
    $resetcompany=$_REQUEST['resetcompany'];
    if(($key = array_search($resetcompany, $_REQUEST['answer']['CCompanies'])) !== false) {
        /*echo $key;
        echo $_REQUEST['answer']['CCompanies'][$key];
        echo $_REQUEST['answer']['CCompanynames'][$key];*/
        unset($_REQUEST['answer']['CCompanies'][$key]);
        unset($_REQUEST['answer']['CCompanynames'][$key]);
        /* To reset the array index */
        $_REQUEST['answer']['CCompanies']=(array_values($_REQUEST['answer']['CCompanies']));
        $_REQUEST['answer']['CCompanynames']=(array_values($_REQUEST['answer']['CCompanynames']));
    }
}


//pr($CompareCount);
if($_REQUEST['answer']['CCompanies'] != ""){
		for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
			if($i == 0)
				$where .= "CId_FK = ".$_REQUEST['answer']['CCompanies'][$i]." AND FY = ".$_REQUEST['answer']['Year'];
			else
				$where .= " OR CId_FK = ".$_REQUEST['answer']['CCompanies'][$i]." AND FY = ".$_REQUEST['answer']['Year'];
		
		}
               
		$order = " SCompanyName ASC";
                //echo $where;
		$CompareResults = $plstandard->GetCompareCompanies($where,$order,"name");
                $ckid=array();
                $ckname=array();
                foreach($CompareResults as $resl)
                {
                    $ckname[]=$resl['SCompanyName'];
                    $ckid[]=$resl['CId_FK'];
                    
                }
               //print_r($ckid);print_r($_REQUEST['answer']['CCompanynames']);
                $unavailcomp=array_diff(($_REQUEST['answer']['CCompanynames']), $ckname);
                $unavailid=array_diff(($_REQUEST['answer']['CCompanies']), $ckid);
                $unavailcomp=(array_values($unavailcomp));
                $unavailid=(array_values($unavailid));
		$template->assign("CompareResults",$CompareResults);
                $template->assign("unavailcomp",$unavailcomp);
                $template->assign("unavailid",$unavailid);

/*For Chart Display Starts*/
	for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
		$TotalIncome[$CompareResults[$i]['SCompanyName']]  .= $CompareResults[$i]['TotalIncome'];
	}
	$TotalIncomeNegative = !(strpos(implode($TotalIncome), '-') === false);
	$template->assign("TotalIncomeNegative" , $TotalIncomeNegative);
	
	for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
		$EBITDA[$CompareResults[$i]['SCompanyName']]  .= $CompareResults[$i]['EBITDA'];
	}
	$EBITDAIncomeNegative = !(strpos(implode($EBITDA), '-') === false);
	$template->assign("EBITDAIncomeNegative" , $EBITDAIncomeNegative);
	
	for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
		$PAT[$CompareResults[$i]['SCompanyName']]  .= $CompareResults[$i]['PAT'];
	}
	$PATIncomeNegative = !(strpos(implode($EBITDA), '-') === false);
	$template->assign("PATIncomeNegative" , $PATIncomeNegative);
/*For Chart Display Ends*/
	$SCompanyName = array();
    for($i=0;$i<count($CompareResults);$i++){
		$SCompanyName[$i] = $CompareResults[$i]['SCompanyName'];
	}
	$template->assign("SCompanyName1",$SCompanyName);
	/*Mean Calculations Starts*/
		$Test = array();
		for($k=1;$k<count($CompareResults);$k++){
			for($i=0;$i<count($PL_STATNDARDFIELDS);$i++){
					//pr($CompareResults[$k][$PL_STATNDARDFIELDS[$i]]);
				$Test[$i] =  $CompareResults[$k][$PL_STATNDARDFIELDS[$i]] - $CompareResults[0][$PL_STATNDARDFIELDS[$i]];
			}	
			$CompareMean[$k-1] =  $Test ;		
			$Test = array();		
		}
		//pr($CompareMean);
		$template->assign("CompareMean",$CompareMean);
	/*Mean Calculations Ends*/
	
	/*Relative Mean Calculations Starts*/
		$Test1 = array();
                $Test2 = array();
		for($k=1;$k<count($CompareResults);$k++){
			for($i=0;$i<count($PL_STATNDARDFIELDS);$i++){
					//pr($CompareResults[$k][$PL_STATNDARDFIELDS[$i]]);
				$Test1[$i] = $CompareResults[$k][$PL_STATNDARDFIELDS[$i]] / $CompareResults[0][$PL_STATNDARDFIELDS[$i]];
                                if ($Test1[$i]!=0)
                                    $Test2[$i] = (($CompareResults[$k][$PL_STATNDARDFIELDS[$i]] / $CompareResults[0][$PL_STATNDARDFIELDS[$i]])-1)*100;
                                else
                                    $Test2[$i] = 0;
			}	
			$RelativeCompareMean[$k-1] =  $Test1;
                        $RelativeCompareMeanper[$k-1] =  $Test2;
                        $Test1 = array();
                        $Test2 = array();
		}
                //print_r($RelativeCompareMean);
		$template->assign("RealtiveCompareMean",$RelativeCompareMean);
                $template->assign("RelativeCompareMeanper",$RelativeCompareMeanper);
	/*Mean Calculations Ends*/

}//If Ends


/**Balance sheet start**/
$fields1 = array("*");
$CompareCount1 = count($_REQUEST['answer']['CCompanies']);
//pr($CompareCount);
if($_REQUEST['answer']['CCompanies'] != ""){
		for($i=0;$i<count($_REQUEST['answer']['CCompanies']);$i++){
			if($i == 0)
				$where1 .= "CId_FK = ".$_REQUEST['answer']['CCompanies'][$i]." AND FY = ".$_REQUEST['answer']['Year'];
			else
				$where1 .= " OR CId_FK = ".$_REQUEST['answer']['CCompanies'][$i]." AND FY = ".$_REQUEST['answer']['Year'];
		
		}
	
		$order1 = " SCompanyName ASC";
		$CompareResults1 = $balancesheet->GetCompareCompanies($where1,$order1,"name");
		//pr($CompareResults);
		$template->assign("FinanceAnnual1",$CompareResults1);
		
	/*Mean Calculations Starts*/
		for($i=0;$i<count($Balance_STATNDARDFIELDS);$i++){
				$Test1 = 0;
				for($k=0;$k<$CompareCount1;$k++){
					//pr($CompareResults[$k][$PL_STATNDARDFIELDS[$i]]);
						if($k == 0)
							$Test1 .= $CompareResults[$k][$Balance_STATNDARDFIELDS[$i]]; 
						else
							$Test1 = $Test1 + $CompareResults[$k][$Balance_STATNDARDFIELDS[$i]]; 	
		
				}
				// pr($Test);
				 $CompareMean1[$i] =  $Test1 / $CompareCount1;
		}
		$template->assign("CompareMean1",$CompareMean1);
	/*Mean Calculations Ends*/

}//If Ends	
/**End**/




if(isset($_POST['exportenable'])){
	include("exportcomparsion.php");
}
$template->assign('comparecompany',$_REQUEST['answer']['CCompanies']);
$curyear=date('Y');
$curyear=(str_split(($curyear),2));
$template->assign('comparecompanyname',$_REQUEST['answer']['CCompanynames']);
$template->assign('comparecompanyyear',($_REQUEST['answer']['Year']) ? $_REQUEST['answer']['Year'] : $curyear[1]);
$template->assign('CompareType',$_REQUEST['CompareType']);

$template->assign('results',$results);
$template->assign('pageTitle',"CFS :: Company Compare");
$template->assign('pageDescription',"CFS - Company Compare");
$template->assign('pageKeyWords',"CFS - Company Compare");

$template->display('comparers.tpl');
include("footer.php");

?>