<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){
                $fullapi_id = $_POST['fullapi_id'];
                $fullapi_name = $_POST['fullapi_name'];
                $fullapi_company = $_POST['fullapi_company'];
                $fullapi_type = $_POST['fullapi_type'];
                $fullapi_token = $_POST['fullapi_token'];
                $fullapi_validate_from = $_POST['fullapi_validate_from'];
                $fullapi_validate_to = $_POST['fullapi_validate_to'];
                $fullapi_search_count = $_POST['fullapi_search_count'];
                $fullapi_api_count = $_POST['fullapi_api_count'];
                $fullapi_email = $_POST['fullapi_email'];
                $fullapi_password = $_POST['fullapi_password'];
                $fullapi_status = $_POST['fullapi_status'];
                $fullapi_isadmin = $_POST['fullapi_isadmin'];
                $fullapi_ip = $_POST['fullapi_ip'];
                
                $password = md5($fullapi_password);
                $user_id = $_POST['user_id'];
                
                if($fullapi_isadmin == "on"){
                    $isadmin = '1';
                }else if($fullapi_isadmin == ""){
                    $isadmin = '0';
                }

                if($fullapi_status == "on"){
                    $status = '1';
                }else if($fullapi_status == ""){
                    $status = '0';
                }
                
                if($fullapi_type == "internal_user"){
                    if($fullapi_name != '' && $fullapi_company != '' && $fullapi_validate_from != '' && $fullapi_validate_to != '' && $fullapi_search_count != '' && $fullapi_api_count != '' ){
                        $sql = 'UPDATE `fullapi_user` SET 
                                `userName` = "'.$fullapi_name.'", 
                                `user_company` = "'.$fullapi_company.'",
                                `userType` = "'.$fullapi_type.'", 
                                `userToken` = "'.$fullapi_token.'", 
                                `validityFrom` = "'.$fullapi_validate_from.'", 
                                `validityTo` = "'.$fullapi_validate_to.'", 
                                `serachCount` = "'.$fullapi_search_count.'", 
                                `apiCount` = "'.$fullapi_api_count.'", 
                                `user_status` = "'.$status.'", 
                                `updatedAt` = now() 
                                WHERE `fullapi_user_id` = "'.$fullapi_id.'"';
                            
                        $fullapi_updated = mysql_query($sql);
                    }
                        
                        if($fullapi_updated == TRUE) {
                            echo "1";
                        }else{
                            echo "0";
                            die('Could not enter data: ' . mysql_error());
                        }
                    }
                    else if($fullapi_type == "external_user"){
                        //echo "select password from external_api_users WHERE `user_id` = '$user_id'";
                        $sql_pass = mysql_query("select password from external_fullapi_users WHERE `fullapi_user_id` = '$user_id'");

                        $old_password = mysql_fetch_object($sql_pass)->password;
                        
                        if($fullapi_password != ''){
                            $update_password = $password;
                        }else{
                            $update_password = $old_password;
                        }
                        
                        if($fullapi_name != '' && $fullapi_email != '' && $fullapi_company != '' && $update_password != '' && $fullapi_company != '' && $fullapi_ip != '' && $status != '' ){
                        
                        $sql_external = 'UPDATE `external_fullapi_users` SET 
                                        `fullapi_username` = "'.$fullapi_name.'",
                                        `username` = "'.$fullapi_email.'", 
                                        `password` = "'.$update_password.'",
                                        `companyName` = "'.$fullapi_company.'",
                                        `ipAddress` =  "'.$fullapi_ip.'",
                                        `user_status` = "'.$status.'", 
                                        `isadmin` = "'.$isadmin.'", 
                                        `updatedAt` = now() 
                                        WHERE `fullapi_user_id` = "'.$user_id.'"';
                        $sql_external_updated = mysql_query($sql_external);

                        }

                        if($sql_external_updated == TRUE) {

                                $sql = 'UPDATE `fullapi_user` SET 
                                    `userName` = "'.$fullapi_name.'", 
                                    `user_company` = "'.$fullapi_company.'",
                                    `userType` = "'.$fullapi_type.'", 
                                    `userToken` = "'.$fullapi_token.'", 
                                    `validityFrom` = "'.$fullapi_validate_from.'", 
                                    `validityTo` = "'.$fullapi_validate_to.'", 
                                    `serachCount` = "'.$fullapi_search_count.'", 
                                    `apiCount` = "'.$fullapi_api_count.'", 
                                    `user_status` = "'.$status.'", 
                                    `updatedAt` = now() 
                                    WHERE `fullapi_user_id` = "'.$fullapi_id.'"';

                            $fullapi_updated = mysql_query($sql);

                            if($fullapi_updated == TRUE) {
                                echo "1";
                            }else{
                                echo "0";
                                die('Could not enter data: ' . mysql_error());
                            }
                        }else{
                            echo "0";
                                die('Could not enter data: ' . mysql_error());
                        }
                    }
?>