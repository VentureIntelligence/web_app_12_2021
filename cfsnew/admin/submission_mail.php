<?php
    $location = $_POST['location_for_mail'];

    // POST Details
    if($location == 'Partner API - CFS' || $location == 'Partner API - PE'){
        $userType = $_POST['partner_info'];
        $name = $_POST['partner_name'];
        $company = $_POST['partner_company'];
        $type = $_POST['partner_type'];
        $duration_from = $_POST['partner_duration_from'];
        $duration_to = $_POST['partner_duration_to'];
        $search_limit = $_POST['partner_search_limit'];
        $api_limit = $_POST['partner_api_limit'];
        $user_email = $_POST['partner_email'];
        $user_password = $_POST['partner_password'];
        $token = $_POST['partner_token'];
        $status = $_POST['partner_status'];
    }elseif($location == 'FULL API - WEB ACCESS ONLY - CFS' || $location == 'FULL API - WEB ACCESS ONLY - PE'){
        $name = $_POST['answer']['UserName'];
        $user_email = $_POST['answer']['Email'];
        $user_password = $_POST['answer']['Password'];
        $firstName = $_POST['answer']['FirstName'];
        $lastName = $_POST['answer']['LastName'];
        $userType = $_POST['answer']['user_type'];
        if($userType == 7){
            $userType = 'API';
        }else{
            $userType = '--';
        }
        $userFlag = $_POST['answer']['usr_flag'];
        
        if($userFlag == 4){
            $userFlag = 'Enable';
        }else{
            $userFlag = 'Disable';
        }
        
        $apiAccess = $_POST['answer']['external_api_access'];

        if($apiAccess == 1){
            $apiAccess = 'Yes';
        }else{
            $apiAccess = '--';
        }



    }elseif($location == 'FULL API - JSON ACCESS - PE'){
        $name = $_POST['fullapi_name'];
        $userType = $_POST['fullapi_info'];
        $search_limit = $_POST['fullapi_search_limit'];
        $api_limit = $_POST['fullapi_api_limit'];
        $company = $_POST['fullapi_company'];
        $type = $_POST['fullapi_type'];
        $duration_from = $_POST['fullapi_duration_from'];
        $duration_to = $_POST['fullapi_duration_to'];
        $user_email = $_POST['fullapi_email'];
        $user_password = $_POST['fullapi_password'];
        $fullapi_ip = $_POST['fullapi_ip'];
        $token = $_POST['fullapi_token'];
        $isadmin = $_POST['fullapi_isadmin'];
        $status = $_POST['fullapi_status'];

        if($isadmin == 1){
            $isadmin_mail = 'YES';
        }else{
            $isadmin_mail = 'NO';
        }
    }
    
    // Subject Message
    if($location == 'Partner API - CFS'){
        if($userType == 'internal'){
            $subject = 'Partner API - CFS - Internal User';    
        }else if($userType == 'external'){
            $subject = 'Partner API - CFS - External User';
        } 
    }elseif($location == 'Partner API - PE'){
        if($userType == 'internal'){
            $subject = 'Partner API - PE - Internal User';    
        }else if($userType == 'external'){
            $subject = 'Partner API - PE - External User';
        }    
    }elseif($location == 'FULL API - WEB ACCESS ONLY - CFS'){
        $subject = 'FULL API - WEB ACCESS ONLY - CFS';    
    }elseif($location == 'FULL API - WEB ACCESS ONLY - PE'){
        $subject = 'FULL API - WEB ACCESS ONLY - PE';    
    }elseif($location == 'FULL API - JSON ACCESS - PE'){
        $subject = 'FULL API - JSON ACCESS - PE';
    }
    
    //Send Email
    if($status == 1){
        $status_mail = 'YES';
    }else{
        $status_mail = 'NO';
    }

    $from 	= 'info@ventureintelligence.in';
    $to    = 'ram@ventureintelligence.com';
    $subject 	= $subject;
    // Header
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n";
    $headers .= 'Cc: arun@ventureintelligence.in' . "\r\n";
    $headers .= 'Bcc: vijayakumar.k@praniontech.com' . "\r\n";
    //$headers .= "Reply-To: vijayakumar.k@praniontech.com\r\n";
    
    // Message
    $message = '<!DOCTYPE html>
                <html>
                <head>
                <style>
                table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                }
                th, td {
                padding: 5px;
                text-align: left;    
                }
                </style>
                </head>
                <body>';
    $message .= '<h2>'.$subject.'</h2>';
    $message .= "<p>New User created, please check below of the details</p>";
    $message .= '<table style="width:50%"><tr><th colspan="2">'.$subject.' Details</th></tr>';
    if($location == 'Partner API - CFS' || $location == 'Partner API - PE' || $location == 'FULL API - JSON ACCESS - PE'){
        // $message .= "<tr><td>Name</td><td>".$name."</td></tr>";
        $message .= "<tr><td>Company Name</td><td>".$company."</td></tr>";
        if($userType == 'external'){
            $message .= "<tr><td>User E-Mail</td><td>".$user_email."</td></tr>";
            $message .= "<tr><td>User Password</td><td>".$user_password."</td></tr>";
        }
        $message .= "<tr><td>Token</td><td>".$token."</td></tr>";
        $message .= "<tr><td>Type</td><td>".$type."</td></tr>";
        $message .= "<tr><td>Period From</td><td>".$duration_from."</td></tr>";
        $message .= "<tr><td>Period To</td><td>".$duration_to."</td></tr>";
        
        // if($location == 'FULL API - JSON ACCESS - PE'){
        //     $message .= "<tr><td>IP Address</td><td>".$fullapi_ip."</td></tr>";
        //     $message .= "<tr><td>Is Admin</td><td>".$isadmin_mail."</td></tr>";
        // }
        // $message .= "<tr><td>Active</td><td>".$status_mail."</td></tr>";
    }elseif($location == 'FULL API - WEB ACCESS ONLY - CFS'){
        // $message .= "<tr><td>Name</td><td>".$name."</td></tr>";
        $message .= "<tr><td>User Email</td><td>".$user_email."</td></tr>";
        $message .= "<tr><td>User Password</td><td>".$user_password."</td></tr>";
        //$message .= "<tr><td>FirstName</td><td>".$firstName."</td></tr>";
        //$message .= "<tr><td>Last Name</td><td>".$lastName."</td></tr>";
        if($location == 'FULL API - WEB ACCESS ONLY - CFS'){
            $message .= "<tr><td>Type</td><td>".$userType."</td></tr>";
        }
        $message .= "<tr><td>Permission </td><td>".$userFlag."</td></tr>";
        $message .= "<tr><td>Login as admin</td><td>".$apiAccess."</td></tr>";

    }
    $message .= "</table></body></html>";
    
    if (@mail($to, $subject, $message, $headers)){
    }else{
    }
?>