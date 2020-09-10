<?php
    include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
     //print_r($_POST);
     //exit();
        $logdate1=$_POST['date1'];
        $logdate2=$_POST['date2'];
        $sort_by=$_POST['sortby'];
        $fetchby = $_POST['fetchby'];
        $bycompany_name = $_POST['searchby'];
        
        $todaysdate=date("Y-m-d");
        //echo "<br>*******-".$logindate;
        if(($logdate1=="") || ($logdate2==""))
        {
                $querydate="";
                $allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d' ) between '" . $todaysdate. "' and '" . $todaysdate . "'";
                $sodate=" where DATE_FORMAT( search_date, '%Y-%m-%d' ) between '" . $todaysdate. "' and '" . $todaysdate . "'";
                $logdate1 = $todaysdate;
                $logdate2 = $todaysdate;
        }
        else
        {
                $querydate=" and DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
                $allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
                $sodate=" where DATE_FORMAT( search_date, '%Y-%m-%d' ) between '" . $logdate1. "' and '" . $logdate2 . "'";
        }
        
        if($fetchby==1){
            
            $UserorgSql="SELECT substring_index(EmailId, '@', -1) domain, COUNT(*) email_count FROM dealLog " .$allquerydate." and PE_MA = 0 and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', -1) ORDER BY ".$sort_by;
            if ($userorgrs = mysql_query($UserorgSql))
            {
                $user_cnt = mysql_num_rows($userorgrs);
            }
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("PE - Organisation Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objRichText->createTextRun('AS OF DATE : ')->getFont()->setBold(TRUE);
            $objRichText->createText(date('d-m-Y', strtotime($logdate1)).' - ' .date('d-m-Y', strtotime($logdate2)));
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Organisation Name')
                                            ->setCellValueByColumnAndRow(2,2,'Email IDs');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($userorgrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['domain']."(".$myrow['email_count'].")")->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
               /*$userbyorgSql="SELECT substring_index(dealLog.EmailId, '@', 1) User, COUNT(*) user_count, dealmembers.Name,dealLog.EmailId FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId ".$allquerydate." and dealLog.EmailId LIKE '%".$myrow['domain']."%' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY user_count desc";*/

                $userbyorgSql="SELECT GROUP_CONCAT(
                                    DISTINCT CONCAT(emailID, '(', cnt, ')') 
                                ) userVal, domain1 FROM (
                                    SELECT COUNT(*) cnt, dealLog.EmailId as emailID, substring_index(dealLog.EmailId, '@', -1) domain1 FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId ".$allquerydate." and dealLog.EmailId LIKE '%".$myrow['domain']."%' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY cnt desc
                                ) q";

                if ($userrs = mysql_query($userbyorgSql))
                {
                    $user_cnt = mysql_num_rows($userrs);
                }
                if ($user_cnt > 0)
                {
                    $userRow = mysql_fetch_row( $userrs, MYSQL_BOTH );
                    $user_insert='';
                    /*While($myrow=mysql_fetch_array($userrs, MYSQL_BOTH))
                    { 
                        $user_insert =$user_insert.$myrow['EmailId'].' ('.$myrow['user_count'].') , ';
                        }*/
                    //$objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, rtrim($user_insert,", "))->getStyle('C'.$sno)->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, rtrim($userRow[ 'userVal' ],", "))->getStyle('C'.$sno)->getAlignment()->setWrapText(true);
                }else{
                    $user_insert = 'No users found';
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $schema_insert);
                }
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("60");

            //clean the output buffer
            ob_end_clean();
            $filename='PE-OrganisationReport-'.date('d-m-Y', strtotime($logdate1)).'-To-'.date('d-m-Y', strtotime($logdate2)).'.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output'); 
            
        }
        
        elseif($fetchby==2){
            
            $UserbyIPSql="SELECT ipAdd IP,substring_index(EmailId, '@', -1) domain, COUNT(*) ip_count FROM dealLog " .$allquerydate." and PE_MA = 0 and ipAdd !='' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') ".$bycompany_name." GROUP BY IP ORDER BY ".$sort_by;
            if ($UserIPrs = mysql_query($UserbyIPSql))
            {
                $userip_cnt = mysql_num_rows($UserIPrs);
            }
            
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("PE - IP Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objRichText->createTextRun('AS OF DATE : ')->getFont()->setBold(TRUE);
            $objRichText->createText(date('d-m-Y', strtotime($logdate1)).' - ' .date('d-m-Y', strtotime($logdate2)));
            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArrayBorder);
            
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'IP Address')
                                            ->setCellValueByColumnAndRow(2,2,'Organisation Name')
                                            ->setCellValueByColumnAndRow(3,2,'# Logins')
                                            ->setCellValueByColumnAndRow(4,2,'Email IDs');
            $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($UserIPrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['IP'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['domain'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, $myrow['ip_count'])->getStyle('D'.$sno)->getAlignment()->setHorizontal('right')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                //$userbyipSql="SELECT substring_index(dealLog.EmailId, '@', 1) user, COUNT(*) user_count, dealmembers.Name,dealLog.EmailId FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId ".$allquerydate." and IpAdd LIKE '".$myrow['IP']."' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY user_count desc";

                $userbyipSql = "SELECT GROUP_CONCAT( DISTINCT CONCAT( emailID,  '(', cnt,  ')' ) ) userVal
                                FROM (
                                    SELECT COUNT(*) cnt, dealLog.EmailId as emailID FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId ".$allquerydate." and IpAdd LIKE '".$myrow['IP']."' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY cnt desc
                                    ) x";

                if ($userrs = mysql_query($userbyipSql))
                {
                    $user_cnt = mysql_num_rows($userrs);
                }
                if ($user_cnt > 0)
                {
                    $user_insert='';
                    $userRow = mysql_fetch_row( $userrs, MYSQL_BOTH );
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, rtrim($userRow[ 'userVal' ],", "))->getStyle('E'.$sno)->getAlignment()->setWrapText(true);
                    /*While($myrow=mysql_fetch_array($userrs, MYSQL_BOTH))
                    { 
                        $user_insert =$user_insert.$myrow['EmailId'].' ('.$myrow['user_count'].') , ';
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, rtrim($user_insert,", "))->getStyle('E'.$sno)->getAlignment()->setWrapText(true);*/
                    
                }else{
                    $user_insert = 'No users found';
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, $schema_insert);
                }
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            //$objPHPExcel->getActiveSheet()->getStyle('A'.$sno.':E'.$sno)->applyFromArray($styleArrayBorder);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("60");

            //clean the output buffer
            ob_end_clean();
            $filename='PE-IPReport-'.date('d-m-Y', strtotime($logdate1)).'-To-'.date('d-m-Y', strtotime($logdate2)).'.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output'); 
        }
        
        elseif($fetchby==3){
            
            $UsertopSql="SELECT substring_index(EmailId, '@', 1) users,substring_index(EmailId, '@', -1) domain, COUNT(*) user_count,EmailId FROM dealLog " .$allquerydate." and PE_MA = 0 and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', 1) ORDER BY ".$sort_by;
            if ($usersrs = mysql_query($UsertopSql))
            {
                $users_cnt = mysql_num_rows($usersrs);
            }
            
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("PE - User Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objRichText->createTextRun('AS OF DATE : ')->getFont()->setBold(TRUE);
            $objRichText->createText(date('d-m-Y', strtotime($logdate1)).' - ' .date('d-m-Y', strtotime($logdate2)));
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Users Email')
                                            ->setCellValueByColumnAndRow(2,2,'Organisation Name')
                                            ->setCellValueByColumnAndRow(3,2,'# Logins');
                                            
            $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($usersrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['EmailId'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['domain'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
               $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, $myrow['user_count'])->getStyle('D'.$sno)->getAlignment()->setHorizontal('right')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

            //clean the output buffer
            ob_end_clean();
            $filename='PE-UserReport-'.date('d-m-Y', strtotime($logdate1)).'-To-'.date('d-m-Y', strtotime($logdate2)).'.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        }
        
        elseif($fetchby==4){
            
            $cfsorgSql="SELECT substring_index(EmailId, '@', -1) domain, COUNT(*) email_count,EmailId FROM userlog_device where dbTYpe = 'CFS' and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', -1) ORDER BY ".$sort_by;
           
            if ($cfsuserorgrs = mysql_query($cfsorgSql))
            {
                $cfsuser_cnt = mysql_num_rows($cfsuserorgrs);
            }
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("CFS - Organisation Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Organisation Name')
                                            ->setCellValueByColumnAndRow(2,2,'Email IDs');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($cfsuserorgrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['domain']."(".$myrow['email_count'].")")->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                /*$cfsuserbyorgSql="SELECT substring_index(EmailId, '@', 1) User, COUNT(*) user_count,users.firstname as username,EmailId FROM userlog_device LEFT JOIN users ON users.username = userlog_device.EmailId where EmailId LIKE '%".$myrow['domain']."%' and dbTYpe = 'CFS' GROUP BY substring_index(EmailId, '@', 1) ORDER BY user_count desc";*/
                $cfsuserbyorgSql = "SELECT GROUP_CONCAT(
                                        DISTINCT CONCAT(emailID, '(', cnt, ')') 
                                    ) userVal FROM (
                                        SELECT COUNT(*) cnt, EmailId as emailID FROM userlog_device LEFT JOIN users ON users.username = userlog_device.EmailId where EmailId LIKE '%".$myrow['domain']."%' and dbTYpe = 'CFS' GROUP BY substring_index(EmailId, '@', 1) ORDER BY cnt desc
                                        ) q";
                if ($userrs = mysql_query($cfsuserbyorgSql))
                {
                    $user_cnt = mysql_num_rows($userrs);
                }
                if ($user_cnt > 0)
                {
                    $user_insert='';
                    $userRow = mysql_fetch_row( $userrs, MYSQL_BOTH );
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, rtrim($userRow[ 'userVal' ],", "))->getStyle('C'.$sno)->getAlignment()->setWrapText(true);
                    /*While($myrow=mysql_fetch_array($userrs, MYSQL_BOTH))
                    { 
                        $user_insert =$user_insert.$myrow['EmailId'].' ('.$myrow['user_count'].') , ';
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, rtrim($user_insert,", "))->getStyle('C'.$sno)->getAlignment()->setWrapText(true);*/
                    
                }else{
                    $user_insert = 'No users found';
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $schema_insert);
                }
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("60");

            //clean the output buffer
            ob_end_clean();
            $filename='CFS-OrganisationReport-'.date('d-m-Y', strtotime($logdate1)).'-To-'.date('d-m-Y', strtotime($logdate2)).'.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output'); 
        }
        
        elseif($fetchby==5){
            
            $cfsUsertopSql="SELECT substring_index(EmailId, '@', 1) users,substring_index(EmailId, '@', -1) domain, COUNT(*) user_count FROM userlog_device where dbTYpe = 'CFS' and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', 1) ORDER BY ".$sort_by;
        
             if ($usersrs = mysql_query($cfsUsertopSql))
            {
                $users_cnt = mysql_num_rows($usersrs);
            }
            
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("CFS - User Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:D1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Users Email')
                                            ->setCellValueByColumnAndRow(2,2,'Organisation Name')
                                            ->setCellValueByColumnAndRow(3,2,'# Login');
                                            
            $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:D2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:D2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($usersrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['users'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['domain'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
               $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, $myrow['user_count'])->getStyle('D'.$sno)->getAlignment()->setHorizontal('right')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

            //clean the output buffer
            ob_end_clean();
            $filename='CFS-UserReport.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        }
        
        elseif($fetchby==6){ // Last login report
            
           $UserorgSql="SELECT substring_index(EmailId, '@', -1) domain, COUNT(*) email_count, MAX(LoggedIn) as last_date FROM dealLog " .$allquerydate." and PE_MA = 0 and substring_index(EmailId, '@', -1) !='' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') ".$bycompany_name." GROUP BY substring_index(EmailId, '@', -1) ORDER BY ".$sort_by;
            if ($userllrs = mysql_query($UserorgSql))
            {
                $user_cnt = mysql_num_rows($userllrs);
            }
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("Last Login Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Organisation Name')
                                            ->setCellValueByColumnAndRow(2,2,'# Logins')
                                            ->setCellValueByColumnAndRow(3,2,'Last Login Date')
                                            ->setCellValueByColumnAndRow(4,2,'Email IDs');
            $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($userllrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['domain'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['email_count'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('right')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, date('d-M-Y',  strtotime($myrow['last_date'])))->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
              
                //$userbyorgSql="SELECT substring_index(dealLog.EmailId, '@', 1) User, COUNT(*) user_count, dealmembers.Name,dealLog.EmailId FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId " .$allquerydate."  and dealLog.EmailId LIKE '%".$myrow['domain']."%' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY user_count desc";

                $userbyorgSql = "SELECT GROUP_CONCAT(
                                    DISTINCT CONCAT(emailID, '(', cnt, ')') 
                                ) userVal FROM (
                                    SELECT COUNT(*) cnt, dealLog.EmailId FROM dealLog LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId " .$allquerydate."  and dealLog.EmailId LIKE '%".$myrow['domain']."%' and PE_MA = 0 GROUP BY substring_index(dealLog.EmailId, '@', 1) ORDER BY cnt desc
                                    ) q";

                if ($userrs = mysql_query($userbyorgSql))
                {
                    $user_cnt = mysql_num_rows($userrs);
                }
                if ($user_cnt > 0)
                {
                    $user_insert='';
                    $userRow = mysql_fetch_row( $userrs, MYSQL_BOTH );
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, rtrim($userRow[ 'userVal' ],", "))->getStyle('E'.$sno)->getAlignment()->setWrapText(true);
                    /*While($myrow=mysql_fetch_array($userrs, MYSQL_BOTH))
                    { 
                        $user_insert =$user_insert.$myrow['EmailId'].' ('.$myrow['user_count'].') , ';
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, rtrim($user_insert,", "))->getStyle('E'.$sno)->getAlignment()->setWrapText(true);*/
                    
                }else{
                    $user_insert = 'No users found';
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, $schema_insert);
                }
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("60");

            //clean the output buffer
            ob_end_clean();
            $filename='LastLoginReport.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output'); 
            
        }elseif($fetchby==7){ // PE Site search
            
            $soexportsql = "select * from search_operations " . $sodate . " and PE=1 order by search_date desc";
            
             if ($soexportsrs = mysql_query($soexportsql))
            {
                $soexport_cnt = mysql_num_rows($soexportsrs);
            }
            
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("PE - Search Operation Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objRichText->createTextRun('AS OF DATE : ')->getFont()->setBold(TRUE);
            $objRichText->createText(date('d-m-Y', strtotime($logdate1)).' - ' .date('d-m-Y', strtotime($logdate2)));
            $objPHPExcel->getActiveSheet()->mergeCells('A1:F1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Users Email')
                                            ->setCellValueByColumnAndRow(2,2,'Keyword Search')
                                            ->setCellValueByColumnAndRow(3,2,'Result Found')
                                            ->setCellValueByColumnAndRow(4,2,'Search Date')
                                            ->setCellValueByColumnAndRow(5,2,'Search URL');
                                            
            $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($soexportsrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['user_id'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['keyword_search'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    
                if( $myrow['result_found'] ==1){
                
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, 'Yes')->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, 'No')->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, date('d-M-Y  h:i A',strtotime($myrow['search_date'])))->getStyle('E'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$sno, $myrow['search_url'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

            //clean the output buffer
            ob_end_clean();
            $filename='PE-SearchReport.xls'.date('d-m-Y', strtotime($logdate1)).'-To-'.date('d-m-Y', strtotime($logdate2)).'.xls';  //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        }
        elseif($fetchby==8){ // CFS Site search
            
            $soexportsql = "select * from search_operations " . $sodate . " and CFS=1 order by search_date desc";
            
             if ($soexportsrs = mysql_query($soexportsql))
            {
                $soexport_cnt = mysql_num_rows($soexportsrs);
            }
            
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("CFS - Search Operation Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objRichText->createTextRun('AS OF DATE : ')->getFont()->setBold(TRUE);
            $objRichText->createText(date('d-m-Y', strtotime($logdate1)).' - ' .date('d-m-Y', strtotime($logdate2)));
            $objPHPExcel->getActiveSheet()->mergeCells('A1:F1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Users Email')
                                            ->setCellValueByColumnAndRow(2,2,'Keyword Search')
                                            ->setCellValueByColumnAndRow(3,2,'Result Found')
                                            ->setCellValueByColumnAndRow(4,2,'Search Date')
                                            ->setCellValueByColumnAndRow(5,2,'Search URL');
                                            
            $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:F2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:F2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($soexportsrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['user_id'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['keyword_search'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    
                if( $myrow['result_found'] ==1){
                
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, 'Yes')->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, 'No')->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, date('d-M-Y  h:i A',strtotime($myrow['search_date'])))->getStyle('E'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$sno, $myrow['search_url'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

            //clean the output buffer
            ob_end_clean();
            $filename='CFS-SearchReport.xls'.date('d-m-Y', strtotime($logdate1)).'-To-'.date('d-m-Y', strtotime($logdate2)).'.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
        }
        elseif($fetchby==9){ // Active/In-active
            
         
           $type = $_POST['type'];
            $company_id = $_POST['companyid'];
            
            if($type==1){
        
                $activesql = "SELECT dealmembers.DCompId,dealmembers.EmailId,dealmembers.Name,Max(dealLog.LoggedIn) as lastdate FROM `dealmembers` INNER JOIN dealLog ON dealLog.EmailId = dealmembers.EmailId WHERE DCompId = ".$company_id." group by dealmembers.EmailId order by ". $sort_by;
                $title = 'Active';
                
            }else{

                $activesql = "SELECT dealmembers.DCompId,dealmembers.EmailId,dealmembers.Name,Max(dealLog.LoggedIn) as lastdate FROM dealmembers WHERE dealmembers.EmailId NOT IN(SELECT deallog.EmailId FROM dealLog) and DCompId = ".$company_id." group by dealmembers.EmailId order by ".$sort_by;
                $title = 'In-active';
                
            }
            if ($activeuserrs = mysql_query($activesql))
            {
                $activeuser_cnt= mysql_num_rows($activeuserrs);
            }
    
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("PE - ".$title." Users Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:C1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'Users Email')
                                            ->setCellValueByColumnAndRow(2,2,'Last Login Date');
                                            
                                            
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:C2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:C2')->applyFromArray($styleArrayBorder);
            
            $sno=3;
            While($myrow=mysql_fetch_array($activeuserrs, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['EmailId'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, date('d-M-Y',  strtotime($myrow['lastdate'])))->getStyle('C'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        
                $sno++;
            }
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

            //clean the output buffer
            ob_end_clean();
            $filename='PE -'.$title.'.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output');
            
        }elseif($fetchby==10){ // Device Report
            
            $type = $_POST['type'];
            $usersearch = $_POST['usersearch'];
            
            if($type==1){
        
                $userbydeviceSql="SELECT  COUNT(*) user_count,dealLog.EmailId,Max(dealLog.LoggedIn) as last_date, dealmembers.deviceCount FROM `deallog` LEFT JOIN dealmembers ON dealmembers.EmailId = dealLog.EmailId WHERE `dealLog`.`EmailId` LIKE '".$usersearch."'  and PE_MA = 0 group by dealLog.EmailId";
            }elseif($type==3){

                $userbydeviceSql="SELECT  COUNT(*) user_count,dealLog.EmailId,Max(dealLog.LoggedIn) as last_date, malogin_members.deviceCount FROM `deallog` LEFT JOIN malogin_members ON malogin_members.EmailId = dealLog.EmailId WHERE `dealLog`.`EmailId` LIKE '".$usersearch."'  and PE_MA = 1 group by dealLog.EmailId";
            }elseif($type==2){

                $userbydeviceSql="SELECT  COUNT(*) user_count,dealLog.EmailId,Max(dealLog.LoggedIn) as last_date, relogin_members.deviceCount FROM `deallog` LEFT JOIN relogin_members ON relogin_members.EmailId = dealLog.EmailId WHERE `dealLog`.`EmailId` LIKE '".$usersearch."'  and PE_MA = 2 group by dealLog.EmailId";
            }
            
          
            if ($userdevicers = mysql_query($userbydeviceSql))
            {
                $userdevice_cnt= mysql_num_rows($userdevicers);
            }
            // Create new PHPExcel object
            $objPHPExcel = new PHPExcel();
            
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            
            $styleArrayBorder = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('argb' => '00000000'),
                    ),
                ),
            );
            
            // Style Part of Text to
            $objRichText=new PHPExcel_RichText();
            $objRichText->createTextRun("Device Report\n")->getFont()->setSize(15)->setBold(TRUE);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1')->setCellValue('A1',$objRichText)->getStyle('A1')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArrayBorder);
          
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,2,'S.No')
                                            ->setCellValueByColumnAndRow(1,2,'User')
                                            ->setCellValueByColumnAndRow(2,2,'# Logins')
                                            ->setCellValueByColumnAndRow(3,2,'Last Login Date')
                                            ->setCellValueByColumnAndRow(4,2,'Device Count');
            $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(TRUE)
                        ->getActiveSheet()->getStyle('A2:E2')->getAlignment()->setHorizontal('center');
            $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($styleArrayBorder);
            
            $sno=3;$schema_insert = "";
            While($myrow=mysql_fetch_array($userdevicers, MYSQL_BOTH))
            { 
                
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$sno, $sno-2)->getStyle('A'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$sno, $myrow['EmailId'])->getStyle('B'.$sno)->getAlignment()->setHorizontal('left')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$sno, $myrow['user_count'])->getStyle('C'.$sno)->getAlignment()->setHorizontal('right')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$sno, date('d-M-Y',  strtotime($myrow['last_date'])))->getStyle('D'.$sno)->getAlignment()->setHorizontal('center')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$sno, $myrow['deviceCount'])->getStyle('E'.$sno)->getAlignment()->setHorizontal('right')->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                //$objPHPExcel->getActiveSheet()->getStyle('C'.$sno)->applyFromArray($style_right);
                $sno++;
            }
            
            
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

            //clean the output buffer
            ob_end_clean();
            $filename='DeviceReport.xls'; //save our workbook as this file name
            // Redirect output to a clients web browser (Excel2007)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            //force user to download the Excel file without writing it to server's HD
            $objWriter->save('php://output'); 
            
        }
        
    }
?>     
        
			
