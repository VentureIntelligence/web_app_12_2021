<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

    //export apiTracking
        $user_data = $_POST['user_data'];
        $duration_data = $_POST['duration_data'];
        $profile_count = $_POST['profile_data_count'];
        $financial_count = $_POST['financial_data_count'];
        $search_data = $_POST['search_data_h'];
        $total_data = $_POST['total_data'];
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('User', 'Duration', 'Profile Data', 'Financial Data', 'Search Count', 'Total Count'));
        fputcsv($output, array($user_data, $duration_data, $profile_count, $financial_count, $search_data, $total_data));
        fclose();


?>