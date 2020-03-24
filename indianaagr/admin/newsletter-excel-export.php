<?php 
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    require_once ('plugins/phpexcel/Classes/PHPExcel.php');
    require_once ('plugins/phpexcel/Classes/PHPExcel/IOFactory.php');

    $objPHPExcel = new PHPExcel();
    //Set the active Excel worksheet to sheet 0 
    $objPHPExcel->setActiveSheetIndex(0);  
    //Initialise the Excel row number 
    $rowCount = 1;

    $email             =   (!empty($_POST['email']))? $DB->removeTags($_POST['email']): '';
    $newsletter_status =   (!empty($_POST['newsletter_status']))? $DB->removeTags($_POST['newsletter_status']) : '';
    $from_date         =   (!empty($_POST['from_date']))? date("y-m-d", strtotime( $_POST['from_date'])) : '';
    $to_date           =   (!empty($_POST['to_date']))? date("y-m-d", strtotime( $_POST['to_date'])): '';

    //Start of printing column names as names of MySQL fields  
    //$column = 'A';

    // Get User Data
    $sqlquery = " SELECT tblnewsletter_subscribers.id , tblnewsletter_subscribers.email, tblnewsletter_subscribers.status FROM tblnewsletter_subscribers ";
    $sqlquery = $sqlquery . "  WHERE tblnewsletter_subscribers.id != 0 ";
    if(!empty($newsletter_status) && strlen($newsletter_status) > 2){
        $sqlquery = $sqlquery . " AND tblnewsletter_subscribers.status = ".$newsletter_status." ";
    }
    if(!empty($from_date)){
        $sqlquery = $sqlquery . " AND DATE(tblnewsletter_subscribers.created) >= '".$from_date."'";
    }
    if(!empty($to_date)){
        $sqlquery = $sqlquery . " AND DATE(tblnewsletter_subscribers.created) <= '".$to_date."'";
    }
    $sqlquery = $sqlquery . " ORDER BY tblnewsletter_subscribers.email ";
    
    $rsdata   = $fpdo->customResult($sqlquery)->fetchAll();
    if (count($rsdata) > 0) {    
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Sr. No.');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Email');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Status');
        //Start while loop to get data
        $rowCount = 2;
        $inicnt = 0;
        foreach($rsdata as $rowdata ){
            $inicnt++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount.'', $inicnt);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount.'', $DB->RemoveTags($rowdata['email']));
            if((int)$DB->RemoveTags($rowdata['status']) == 707) { 
                $status = "Confirm"; 
            } elseif ((int)$DB->RemoveTags($rowdata['status'] == 505)) { 
                $status = "Pending"; 
            }
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount.'', $status );
            $rowCount++;
        }
    }
    //End of adding column names  

    //Redirect output to a client’s web browser (Excel5) 
    $filename = "export-newsletter-report-excel" . date('Ymd') . ".xls";
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="'.$filename.'"'); 
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    $objWriter->save('php://output');
?>