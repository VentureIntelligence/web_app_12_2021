<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){
                $partner_name = $_POST['partner_name'];
                $partner_token = $_POST['partner_token'];
                $partner_status = $_POST['partner_status'];

                if($partner_status !=''){
                   $status = $partner_status;
                }else{
                  $status = '0';
                }

                
               
                

                $partner_validate_from_o = $_POST['partner_duration_from'];
                $partner_validate_to_o = $_POST['partner_duration_to'];
                $date1=date_create_from_format("d/m/Y",trim($partner_validate_from_o));
                $partner_duration_from = date_format($date1,"Y-m-d H:i:s");
                $date2=date_create_from_format("d/m/Y",trim($partner_validate_to_o));
                $partner_duration_to = date_format($date2,"Y-m-d H:i:s");
               //  $date_2 = str_replace('/', '-', $partner_duration_to_o );
               //  $partner_duration_to = date("Y-m-d", strtotime($date_2));
               
                //$partner_duration_from->format('Y-m-d h:i');
               
                $partner_duration_from = date('Y-m-d H:i:s', strtotime($partner_duration_from .' -1 day')); //needs to modify after api changes
               //  $partner_search_limit = $_POST['partner_search_limit'];
               //  $partner_api_limit = $_POST['partner_api_limit'];
                $partner_overall_limit = $_POST['partner_overall_limit'];
                
                $partner_info = $_POST['partner_info'];
                $partner_subapi_info = $_POST['partner_subapi_info'];
                $partner_type = $_POST['partner_type'];
                $partner_email = $_POST['partner_email'];
                $partner_password = $_POST['partner_password'];
                $password = md5($partner_password);
                $partner_company = $_POST['partner_company'];


               //  echo '<pre>'; print_r($_POST); echo '</pre>'; 
               //  exit;
               
               
               $validate_partner_email = "select count(*) as partner from pe_external_api_users WHERE username = '$partner_email'";
               $ex_partner_valid = mysql_query($validate_partner_email);
               $valid_partner = mysql_fetch_array($ex_partner_valid);
               $valid_user = $valid_partner['partner'];

              
                if($partner_info == "news_api_partner"){

                  if($valid_user == '0'){

                  if($partner_name != '' && $partner_email != '' && $partner_company != '' && $partner_password != '' && $partner_duration_from != '' && $partner_duration_to != ''){

                     // $sql_external = "INSERT INTO pe_external_api_users (partnername, username, password, companyName, partner_status, createdAt) 
                     //             VALUES ('$partner_name', '$partner_email', '$password', '$partner_company', '$status', now())";
                     $sql_external = "INSERT INTO pe_external_api_users ( username, password, companyName, partner_status,api_type, createdAt,updatedAt) 
                                 VALUES ( '$partner_email', '$password', '$partner_company', '$status','$partner_subapi_info', now(), now())";
                     $partner_external_added = mysql_query($sql_external);
                     $external_partner_id = mysql_insert_id();
                  }

                  // echo 'news api partners';
                  // exit;
                  
                  if($partner_external_added == TRUE) {

                     // $sql = "INSERT INTO pe_api_partner (partnerName, partner_company, partnerType, partnerToken, validityFrom, validityTo, serachCount, apiCount, user_id, partner_status, createdAt) 
                     //          VALUES ('$partner_name', '$partner_company', '$partner_type', '$partner_token', '$partner_duration_from', '$partner_duration_to', '$partner_search_limit', '$partner_api_limit', '$external_partner_id', '$status', now())";
                     $sql = "INSERT INTO news_api_partner (partnerName, partner_company, partnerType, partnerToken, validityFrom, validityTo,overallCount , user_id , partner_status, createdAt,updatedAt,api_type) 
                     VALUES ('$partner_name', '$partner_company', '$partner_type', '$partner_token', '$partner_duration_from', '$partner_duration_to','$partner_overall_limit', '$external_partner_id', '$status', now(),now(),'$partner_subapi_info')";
                    
                    $partner_added = mysql_query($sql);

                     if($partner_added == TRUE) {
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