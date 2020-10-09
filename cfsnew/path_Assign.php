<?php

$CF_Bedrooms = array(
			"1"  => "1",
			"2"  => "2",
			"3"  => "3",
			"4"  => "4",
			"5"  => "5",
			"6"  => "6",
			"7"  => "7",
			"8"  => "8",
			"9"  => "9",
		  );
$template->assign('CF_Bedrooms', $CF_Bedrooms);

$CF_Price = array(
			"1"  => "Below 7 Lacs",
			"2"  => "7 to 15 Lacs",
			"3"  => "15 to 25 Lacs",
			"4"  => "25 to 40 Lacs",
			"5"  => "40 to 60 Lacs",
			"6"  => "60 to 100 Lacs",
			"7"  => "1 to 1.5 Crores",
			"8"  => "1.5 to 2 Crores",
			"9"  => "2 to 2.5 Crores",
			"10"  => "2.5 to 5 Crores",
			"11"  => "5 to 10 Crores",
			"12"  => "10 to 15 Crores",
			"13"  => "15 to 20 Crores",
			"14"  => "20 to 25 Crores",
			"15"  => "25 to 30 Crores",
			"16"  => "30 to 35 Crores",
			"17"  => "35 to 40 Crores",
			"18"  => "40 to 45 Crores",
			"19"  => "45 to 50 Crores",
			"20"  => "50 to 55 Crores",
			"21"  => "55 to 60 Crores",
			"22"  => "60 to 65 Crores",
			"23"  => "65 to 70 Crores",
			"24"  => "70 to 75 Crores",
			"25"  => "75 to 80 Crores",
			"26"  => "80 to 85 Crores",
			"27"  => "90 to 95 Crores",
			"28"  => "95 to 100 Crores",
			"29"  => "Above 100 Crores",
		  );
$template->assign('CF_Price', $CF_Price);

$PL_STATNDARDFIELDS = array(
			"0"  => "OptnlIncome",
			"1"  => "OtherIncome",
                        "2"  => "TotalIncome",
			"3"  => "OptnlAdminandOthrExp",
			"4"  => "OptnlProfit",
			"5"  => "EBITDA",
			"6"  => "Interest",
			"7"  => "EBDT",
			"8"  => "Depreciation",
			"9"  => "EBT",
			"10"  => "Tax",
			"11"  => "PAT",
			"12"  => "BINR",
			"13"  => "DINR",
			
			
		  );
$template->assign('PL_STATNDARDFIELDS', $PL_STATNDARDFIELDS);

$PL_STNDSEARCHFIELDS = array(
			"0"  => "TotalIncome",
			"1"  => "EBITDA",
			"2"  => "EBDT",
			"3"  => "EBT",
			"4"  => "PAT",
                        "5"  => "Total Debt",
                        "6"  => "Networth",
                        "7"  => "Capital Employed",
		  );
$template->assign('PL_STNDSEARCHFIELDS', $PL_STNDSEARCHFIELDS);

// T975 Start
$PL_STNDRATIOFIELDS = array(
	"0"  => "Current Ratio",
	"1"  => "Quick Ratio",
	"2"  => "Debt Equity Ratio",
	"3"  => "RoE",
	"4"  => "RoA",
	"5"  => "Asset Turnover Ratio",
	"6"  => "EBITDA Margin. (%)",
	"7"  => "PAT Margin. (%)",
	"8"  => "Contribution margin. (%)",
  );
$template->assign('PL_STNDRATIOFIELDS', $PL_STNDRATIOFIELDS);
// T975 End
		  
?>