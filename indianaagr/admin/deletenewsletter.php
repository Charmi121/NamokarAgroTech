<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    
    $action = 0;
    // Check if delete button active, start this
    if(!empty($_REQUEST['delete'])){
        $id       = (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : null;
        $page     = (!empty($_REQUEST['page'])) ? (int)$_REQUEST['page'] : null;
       
        $sqlquery =  "DELETE FROM tblnewsletter_subscribers WHERE tblnewsletter_subscribers.id = ".$id."";
        $rsdata   =   $fpdo->customResult($sqlquery);
        $action   =  1;
    }

    if ((int)$action == 1) {
        $_SESSION['newsletter_status'] = "delete";
        header("Location: displaynewsletter.php?page=".$page."");
        exit;
    } else {
        $_SESSION['newsletter_status'] = "invalid";
        header("Location: displaynewsletter.php?page=".$page."");
        exit;
    }
    $DB -> close();
?>