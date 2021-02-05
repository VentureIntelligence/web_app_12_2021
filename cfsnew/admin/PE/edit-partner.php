<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){
                $partner_id = $_POST['partner_id'];
                $partner_name = $_POST['partner_name'];
                $partner_company = $_POST['partner_company'];
                $partner_subapi = $_POST['sub_api_partner'];
                $partner_type = $_POST['partner_type'];
                $partner_token = $_POST['partner_token'];
                // $partner_validate_from = $_POST['partner_validate_from'];
             
               
                // $partner_validate_to = $_POST['partner_validate_to'];

                $partner_validate_from_o = $_POST['partner_validate_from'];
                $partner_validate_to_o = $_POST['partner_validate_to'];
                $date1=date_create_from_format("d/m/Y",trim($partner_validate_from_o));
                $partner_validate_from = date_format($date1,"Y-m-d H:i:s");
                $date2=date_create_from_format("d/m/Y",trim($partner_validate_to_o));
                $partner_validate_to = date_format($date2,"Y-m-d H:i:s");
                



                $partner_search_count = $_POST['partner_search_count'];
                $partner_api_count = $_POST['partner_api_count'];
                $partner_overall_count = $_POST['partner_overall_count'];
                $partner_email = $_POST['partner_email'];
                $partner_password = $_POST['partner_password'];
                $partner_status = $_POST['partner_status'];
                
                $password = md5($partner_password);
                $user_id = $_POST['user_id'];
                
                if($partner_status == "on"){
                    $status = '1';
                }else if($partner_status == ""){
                    $status = '0';
                }
                
                if($partner_type == "internal_partner"){
                    if($partner_name != '' && $partner_company != '' && $partner_validate_from != '' && $partner_validate_to != '' && $partner_search_count != '' && $partner_api_count != '' ){
                        $sql = 'UPDATE `pe_api_partner` SET 
                                `partnerName` = "'.$partner_name.'", 
                                `partner_company` = "'.$partner_company.'",
                                `partnerType` = "'.$partner_type.'", 
                                `partnerToken` = "'.$partner_token.'", 
                                `validityFrom` = "'.$partner_validate_from.'", 
                                `validityTo` = "'.$partner_validate_to.'", 
                                `dealCount` = "'.$partner_search_count.'", 
                                `companyCount` = "'.$partner_api_count.'", 
                                `overallCount` = "'.$partner_overall_count.'",
                                `partner_status` = "'.$status.'", 
                                `api_type` ="'.$partner_subapi.'",
                                `updatedAt` = now() 
                                WHERE `partner_id` = "'.$partner_id.'"';
                            
                        $partner_updated = mysql_query($sql);
                    }
                        
                        if($partner_updated == TRUE) {
                            echo "1";
                        }else{
                            echo "0";
                            die('Could not enter data: ' . mysql_error());
                        }
                    }
                    else if($partner_type == "external_partner"){
                        //echo "select password from external_api_users WHERE `user_id` = '$user_id'";
                        $sql_pass = mysql_query("select password from pe_external_api_users WHERE `user_id` = '$user_id'");

                        $old_password = mysql_fetch_object($sql_pass)->password;
                        
                        if($partner_password != ''){
                            $update_password = $password;
                        }else{
                            $update_password = $old_password;
                        }
                        
                        if($partner_name != '' && $partner_email != '' && $partner_company != '' && $update_password != '' && $partner_company != '' && $status != '' ){
                        
                        // $sql_external = 'UPDATE `pe_external_api_users` SET 
                        //                 `partnername` = "'.$partner_name.'",
                        //                 `username` = "'.$partner_email.'", 
                        //                 `password` = "'.$update_password.'",
                        //                 `companyName` = "'.$partner_company.'", 
                        //                 `partner_status` = "'.$status.'", 
                        //                 `updatedAt` = now() 
                        //                 WHERE `user_id` = "'.$user_id.'"';
                        $sql_external = 'UPDATE `pe_external_api_users` SET 
                                        `username` = "'.$partner_email.'", 
                                        `password` = "'.$update_password.'",
                                        `companyName` = "'.$partner_company.'", 
                                        `partner_status` = "'.$status.'", 
                                        `api_type` ="'.$partner_subapi.'",
                                        `updatedAt` = now() 
                                        WHERE `user_id` = "'.$user_id.'"';
                        $sql_external_updated = mysql_query($sql_external);

                        }

                        if($sql_external_updated == TRUE) {

                                $sql = 'UPDATE `pe_api_partner` SET 
                                    `partnerName` = "'.$partner_name.'", 
                                    `partner_company` = "'.$partner_company.'",
                                    `partnerType` = "'.$partner_type.'", 
                                    `partnerToken` = "'.$partner_token.'", 
                                    `validityFrom` = "'.$partner_validate_from.'", 
                                    `validityTo` = "'.$partner_validate_to.'", 
                                    `dealCount` = "'.$partner_search_count.'", 
                                    `companyCount` = "'.$partner_api_count.'", 
                                    `overallCount` = "'.$partner_overall_count.'",
                                    `partner_status` = "'.$status.'", 
                                    `api_type` ="'.$partner_subapi.'",
                                    `updatedAt` = now() 
                                    WHERE `partner_id` = "'.$partner_id.'"';

                            $partner_updated = mysql_query($sql);

                            if($partner_updated == TRUE) {
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