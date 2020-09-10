<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){
                $partner_name = $_POST['partner_name'];
                $partner_type = $_POST['partner_type'];
                $partner_token = $_POST['partner_token'];
                $partner_status = $_POST['partner_status'];

                if($partner_status !=''){
                   $status = $partner_status;
                }else{
                  $status = '0';
                }

                
               
                $partner_duration_from_o = $_POST['partner_duration_from'];
                $date_1 = str_replace('/', '-', $partner_duration_from_o );
                $partner_duration_from = date("Y-m-d", strtotime($date_1));
                
                $partner_duration_to_o = $_POST['partner_duration_to'];
                $date_2 = str_replace('/', '-', $partner_duration_to_o );
                $partner_duration_to = date("Y-m-d", strtotime($date_2));
               
                //$partner_duration_from->format('Y-m-d h:i');
                
                $partner_search_limit = $_POST['partner_search_limit'];
                $partner_api_limit = $_POST['partner_api_limit'];
                
                $partner_info = $_POST['partner_info'];
                $partner_email = $_POST['partner_email'];
                $partner_password = $_POST['partner_password'];
                $password = md5($partner_password);
                $partner_company = $_POST['partner_company'];
               
               
               $validate_partner_email = "select count(*) as partner from external_api_users WHERE username = '$partner_email'";
               $ex_partner_valid = mysql_query($validate_partner_email);
               $valid_partner = mysql_fetch_array($ex_partner_valid);
               $valid_user = $valid_partner['partner'];
               
                if($partner_info == "internal"){
                  if($partner_name != '' && $partner_company != '' && $partner_duration_from != '' && $partner_duration_to != '' && $partner_search_limit != '' && $partner_api_limit != ''){
                     $sql = "INSERT INTO api_partner (partnerName, partner_company, partnerType, partnerToken, validityFrom, validityTo, serachCount, apiCount, user_id, partner_status, createdAt) 
                     VALUES ('$partner_name', '$partner_company', '$partner_type', '$partner_token', '$partner_duration_from', '$partner_duration_to', '$partner_search_limit', '$partner_api_limit', '0', '$status', now())";
                     
                     $partner_added = mysql_query($sql);
                  }
                     if($partner_added == TRUE) {
                        echo "1";
                     }else{
                        echo "0";
                        die('Could not enter data: ' . mysql_error());
                     }
                  }else if($partner_info == "external"){

                     if($valid_user == '0'){

                     if($partner_name != '' && $partner_email != '' && $partner_company != '' && $partner_password != '' && $partner_duration_from != '' && $partner_duration_to != '' && $partner_search_limit != '' && $partner_api_limit != ''){

                        $sql_external = "INSERT INTO external_api_users (partnername, username, password, companyName, partner_status, createdAt) 
                                    VALUES ('$partner_name', '$partner_email', '$password', '$partner_company', '$status', now())";
                        $partner_external_added = mysql_query($sql_external);
                        $external_partner_id = mysql_insert_id();
                     }
                     
                     if($partner_external_added == TRUE) {

                        $sql = "INSERT INTO api_partner (partnerName, partner_company, partnerType, partnerToken, validityFrom, validityTo, serachCount, apiCount, user_id, partner_status, createdAt) 
                                 VALUES ('$partner_name', '$partner_company', '$partner_type', '$partner_token', '$partner_duration_from', '$partner_duration_to', '$partner_search_limit', '$partner_api_limit', '$external_partner_id', '$status', now())";
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