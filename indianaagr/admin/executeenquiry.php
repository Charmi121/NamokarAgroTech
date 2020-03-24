<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();
    

    $user_id	        =  (!empty($_POST['user_id'])) ? (int)$_POST['user_id'] : 0;
    $enquiry_id         =  (!empty($_POST['enquiry_id'])) ? (int)$_POST['enquiry_id'] : 0;
    $admin_remarks      =  (!empty($_POST['admin_remarks'])) ? htmlentities($DB->RemoveTags($_POST['admin_remarks'],ENT_QUOTES,"utf-8")) : '';
	$status             =  (!empty($_POST['status']))? (int)$_POST['status'] : 0;
    $modified           =  date("Y-m-d H:i:s", strtotime('now')); 
    $action             =  0;
    
    if (!empty($enquiry_id)) {
        $sqlquery   =  "UPDATE tblenquiries SET 
                                             admin_remarks = '".$admin_remarks."',
                                             status = ".$status.",
                                             modified = '".$modified."'
                                             ";
        $sqlquery   =  $sqlquery." WHERE user_id = ".$user_id." AND enquiry_id = ".$enquiry_id." ";
        $rsresult   =  $fpdo->customResult($sqlquery);
        $action     =  2;
    }    

    if ((int)$action == 2){
        $_SESSION['enquirystatus'] = "update_execute";
        header("Location: enquiry.php?enquiry_id=".$enquiry_id."&edit=1");
        exit;
    } else {
        header("Location: enquiry.php?enquiry_id=".$enquiry_id."&edit=1");
        exit;
    }
?>