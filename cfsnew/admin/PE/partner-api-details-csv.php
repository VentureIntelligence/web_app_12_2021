<?php
include "header.php";
include( dirname(__FILE__)."/../../etc/conf.php");

    //export apiTracking
        $user_data = $_POST['user_data'];
        $duration_data = $_POST['duration_data'];
        $dates = explode("-", $duration_data);
        $from_date = date('Y-m-d', strtotime($dates[0]));
        $to_date = date('Y-m-d', strtotime($dates[1]));
        $profile_count = $_POST['profile_data_count'];
        $financial_count = $_POST['financial_data_count'];
        $search_data = $_POST['search_data_h'];
        $total_data = $_POST['total_data'];
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen("php://output", "w");
        fputcsv($output, array('Profile List'));
        fputcsv($output, array('apiName', 'apiURL', 'user', 'deviceId', 'deviceType', 'companyName', 'apiType', 'createdAt'));
       // fputcsv($output, array($user_data, $duration_data, $profile_count, $financial_count, $search_data, $total_data));
       //Select Datas
        $profileList = "select * from pe_partner_apitracking WHERE user = '$user_data' and apiName='/profileData' and date(createdAt) between '$from_date' and '$to_date'";
        $profileListView = mysql_query($profileList);

        while($row = mysql_fetch_assoc($profileListView)){
            fputcsv($output, $row);
        }
        fputcsv($output, array('Financial List'));
        $financialList = "select * from pe_partner_apitracking WHERE user = '$user_data' and apiName='/financialData' and date(createdAt) between '$from_date' and '$to_date'";
        $financialListView = mysql_query($financialList);

        while($row = mysql_fetch_assoc($financialListView)){
            fputcsv($output, $row);
        }
        fclose($output);
?>