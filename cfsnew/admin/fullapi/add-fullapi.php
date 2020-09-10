<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){
                $fullapi_name = $_POST['fullapi_name'];
                $fullapi_type = $_POST['fullapi_type'];
                $fullapi_token = $_POST['fullapi_token'];
                $fullapi_status = $_POST['fullapi_status'];
                $fullapi_isadmin = $_POST['fullapi_isadmin'];

                if($fullapi_status !=''){
                   $status = $fullapi_status;
                }else{
                  $status = '0';
                }

               if($fullapi_isadmin !='')
               {
                  $isadmin = $fullapi_isadmin;
               }else{
                  $isadmin = '0';
               }

                
               
                $fullapi_duration_from_o = $_POST['fullapi_duration_from'];
                $date_1 = str_replace('/', '-', $fullapi_duration_from_o );
                $fullapi_duration_from = date("Y-m-d", strtotime($date_1));
                
                $fullapi_duration_to_o = $_POST['fullapi_duration_to'];
                $date_2 = str_replace('/', '-', $fullapi_duration_to_o );
                $fullapi_duration_to = date("Y-m-d", strtotime($date_2));
               
                //$fullapi_duration_from->format('Y-m-d h:i');
                
                $fullapi_search_limit = $_POST['fullapi_search_limit'];
                $fullapi_api_limit = $_POST['fullapi_api_limit'];
                
                $fullapi_info = $_POST['fullapi_info'];
                $fullapi_email = $_POST['fullapi_email'];
                $fullapi_password = $_POST['fullapi_password'];
                $password = md5($fullapi_password);
                $fullapi_company = $_POST['fullapi_company'];
                $fullapi_ip = $_POST['fullapi_ip'];
               
               
               $validate_fullapi_email = "select count(*) as user from external_fullapi_users WHERE username = '$fullapi_email'";
               $ex_fullapi_valid = mysql_query($validate_fullapi_email);
               $valid_fullapi = mysql_fetch_array($ex_fullapi_valid);
               $valid_user = $valid_fullapi['user'];
               
                if($fullapi_info == "internal"){
                  if($fullapi_name != '' && $fullapi_company != '' && $fullapi_duration_from != '' && $fullapi_duration_to != '' && $fullapi_search_limit != '' && $fullapi_api_limit != ''){
                     $sql = "INSERT INTO fullapi_user (userName, user_company, userType, userToken, validityFrom, validityTo, serachCount, apiCount, user_id, user_status, createdAt) 
                     VALUES ('$fullapi_name', '$fullapi_company', '$fullapi_type', '$fullapi_token', '$fullapi_duration_from', '$fullapi_duration_to', '$fullapi_search_limit', '$fullapi_api_limit', '0', '$status', now())";
                     
                     $fullapi_added = mysql_query($sql);
                  }
                     if($fullapi_added == TRUE) {
                        echo "1";
                     }else{
                        echo "0";
                        die('Could not enter data: ' . mysql_error());
                     }
                  }else if($fullapi_info == "external"){

                     if($valid_user == '0'){

                     if($fullapi_name != '' && $fullapi_email != '' && $fullapi_company != '' && $fullapi_password != '' && $fullapi_duration_from != '' && $fullapi_duration_to != '' && $fullapi_search_limit != '' && $fullapi_api_limit != '' && $fullapi_ip != ''){

                        $sql_external = "INSERT INTO external_fullapi_users (fullapi_username, username, password, companyName, ipAddress, user_status, isadmin, createdAt) 
                                    VALUES ('$fullapi_name', '$fullapi_email', '$password', '$fullapi_company', '$fullapi_ip', '$status', '$isadmin', now())";
                        $fullapi_external_added = mysql_query($sql_external);
                        $external_fullapi_id = mysql_insert_id();
                     }
                     
                     if($fullapi_external_added == TRUE) {

                        $sql = "INSERT INTO fullapi_user (userName, user_company, userType, userToken, validityFrom, validityTo, serachCount, apiCount, user_id, user_status, createdAt)
                                 VALUES ('$fullapi_name', '$fullapi_company', '$fullapi_type', '$fullapi_token', '$fullapi_duration_from', '$fullapi_duration_to', '$fullapi_search_limit', '$fullapi_api_limit', '$external_fullapi_id', '$status', now())";
                        $fullapi_added = mysql_query($sql);

                        //Send Email
                        // if($isadmin == 1){
                        //    $isadmin_mail = 'YES';
                        // }else{
                        //    $isadmin_mail = 'NO';
                        // }

                        // if($status == 1){
                        //    $status_mail = 'YES';
                        // }else{
                        //    $status_mail = 'NO';
                        // }

                        // $from 	= 'info@ventureintelligence.com';
                        // $to    = 'kalaiselvan.s@praniontech.com';
                        // $subject 	= "Full API - JSON [ New Form ]";
                        // Header
                        // $headers  = 'MIME-Version: 1.0' . "\r\n";
                        // $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        // $headers .= "From: $from\r\n";
                        // $headers .= "Reply-To: kalaiselvan.s@praniontech.com\r\n";
                        // $headers .= 'Bcc: vijayakumar.k@praniontech.com' . "\r\n";

                        //Message
                        // $message = '<!DOCTYPE html>
                        //             <html>
                        //             <head>
                        //             <style>
                        //             table, th, td {
                        //             border: 1px solid black;
                        //             border-collapse: collapse;
                        //             }
                        //             th, td {
                        //             padding: 5px;
                        //             text-align: left;    
                        //             }
                        //             </style>
                        //             </head>
                        //             <body>';
                        // $message .= '<h2>External User Details</h2>';
                        // $message .= "<p>New User created from External User form</p>";
                        // $message .= '<table style="width:50%"><tr><th colspan="2">External User Details - JSON</th></tr>';
                        // $message .= "<tr><td>Name</td><td>".$fullapi_name."</td></tr>";
                        // $message .= "<tr><td>Company Name</td><td>".$fullapi_company."</td></tr>";
                        // $message .= "<tr><td>Type</td><td>".$fullapi_type."</td></tr>";
                        // $message .= "<tr><td>Period From</td><td>".$fullapi_duration_from."</td></tr>";
                        // $message .= "<tr><td>Period To</td><td>".$fullapi_duration_to."</td></tr>";
                        // $message .= "<tr><td>User E-Mail</td><td>".$fullapi_email."</td></tr>";
                        // $message .= "<tr><td>User Password</td><td>".$fullapi_password."</td></tr>";
                        // $message .= "<tr><td>IP Address</td><td>".$fullapi_ip."</td></tr>";
                        // $message .= "<tr><td>Token</td><td>".$fullapi_token."</td></tr>";
                        // $message .= "<tr><td>Is Admin</td><td>".$isadmin_mail."</td></tr>";
                        // $message .= "<tr><td>Active</td><td>".$status_mail."</td></tr>";
                        // $message .= "</table></body></html>";
                        
                        // if (@mail($to, $subject, $message, $headers)){
                        // }else{
                        // }
                        // End Mail

                        if($fullapi_added == TRUE) {
                           echo "1";
                        }else{
                           echo "0";
                           die('Could not enter data: ' . mysql_error());
                        }
                     
                     }else{
                        echo "0";
                        die('Could not enter data: ' . mysql_error());
                     }

                  }else{
                     echo 'not_valid_email';
                  }
                }     
?>