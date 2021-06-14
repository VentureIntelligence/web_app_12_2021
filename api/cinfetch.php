<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	session_start();
	if( isset( $_POST ) ) {
		$week = $_POST[ 'week' ];
		$dateTo = date( 'Y-m-d');
		$dateFrom = date("Y-m-d", strtotime("-" . $week . " week"));
		$sel = "SELECT cin, created_on, run_type FROM log_table
				WHERE date(created_on) BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "'
				GROUP BY cin ORDER BY id DESC";
		$res= mysql_query( $sel ) or die( mysql_error() );
		$numrows = mysql_num_rows( $res );
		$str = '<table class="rec-tbl">
					<thead>
						<tr>
							<th>CIN</th>
							<th>Run Date</th>
							<th>Run Type</th>
						</tr>
					</thead>
					<tbody>';
		if( $numrows > 0 ) {
			while ( $result = mysql_fetch_array( $res ) ) {
				if( $result[ 'run_type' ] == 1 ) {
					$runType = 'XBRL';
				} else {
					$runType = 'Manual';
				}
			$str .= '	<tr>
							<td>' . $result[ 'cin' ] . '</td>
							<td>' . date( "F jS, Y H:i:s", strtotime(  $result[ 'created_on' ] ) ) . '</td>
							<td>' . $runType . '</td>
						</tr>';	
			}
		} else {
			$str .= '<tr>
						<td colspan="3">No CIN\'s processed</td>
					</tr>';
		}
		$str .= '</tbody>
				</table>';
	}

	echo $str;
?>