<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 //session_save_path("/tmp");
	session_start();
//	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
// 	{
?>
<?php
	//$localpath = $_SERVER[ 'DOCUMENT_ROOT' ] . "/vi_file_upload/";
	$keyword="";
	$keyword=$_POST[ 'email_search' ];

	$fromDate=$_POST[ 'from_date' ];
	$toDate=$_POST[ 'to_date' ];

	if( ( $fromDate == "" ) || ( $toDate == "" ) ) {
		$querydate="";
		$allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d' ) between '" . $fromDate. "' and '" . $toDate . "'";
	} else {
		$querydate=" and DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $fromDate. "' and '" . $toDate . "'";
		$allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $fromDate. "' and '" . $toDate . "'";
	}
	if( trim( $keyword ) != "" ) {
		$csvFileName = 'deallog_report_' . $keyword . '_'. $fromDate . 'to'.$toDate.'.csv';
		$dealcompanySql="select EmailId,LoggedIn, DATE_FORMAT( LoggedIn, '%m-%d-%y %H:%i:%S') as dt,IpAdd,DATE_FORMAT( LoggedOff, '%m-%d-%Y %H:%i:%S') as logoff,UnAuthorized,PE_MA from dealLog where EmailId like '%$keyword%'" .$querydate. " order by LoggedIn desc";
	} else {
		$csvFileName = 'deallog_report_'. $fromDate . 'to'.$toDate.'.csv';
		$dealcompanySql="select EmailId,LoggedIn, DATE_FORMAT( LoggedIn, '%m-%d-%Y %H:%i:%S' ) as dt,IpAdd,DATE_FORMAT( LoggedOff, '%m-%d-%Y %H:%i:%S' ) as logoff,UnAuthorized,PE_MA from dealLog" .$allquerydate. "  order by LoggedIn desc";
	}
	header("Content-Disposition: attachment; filename=\"". $csvFileName ."\"");
    header("Content-Type: application/vnd.ms-excel;");
    header("Pragma: no-cache");
    header("Expires: 0");
    $out = fopen("php://output", 'w');
    fputcsv( $out, array( 'Email ID', 'DB', 'Logged In(m/dd/yy)', 'IP Add', 'Logout Time', 'Unauthorized' ), ',', '"' );
	if( $companyrs = mysql_query( $dealcompanySql ) ) {
		$company_cnt = mysql_num_rows($companyrs);
	}
	if ( $company_cnt > 0 ) {
		While ($myrow = mysql_fetch_array( $companyrs, MYSQL_BOTH ) ) {
			if( $myrow[ "UnAuthorized" ] == 1 ) {
				$access = "Yes";
			} else {
				$access = "No";
			}
			if( $myrow[ "PE_MA" ] == 1 ) {
				$bgcolorMA = 'MA';
			} else if( $myrow[ "PE_MA" ] == 0 ) {
				$bgcolorMA = 'PE';
			} else if( $myrow[ "PE_MA" ] == 2 ) {
				$bgcolorMA = 'RE';
			}
			fputcsv( $out, array( $myrow["EmailId"], $bgcolorMA, $myrow["dt"], $myrow["IpAdd"], $myrow["logoff"], $access ), ',', '"' );
		}
	}
	fclose($out);

?>