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
        $id       = (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
        $page     = (!empty($_REQUEST['page'])) ? (int)$_REQUEST['page'] : 1;
       
	  
        $sqlquery = $fpdo->deleteFrom('tblcompany_update')->where('id = ?', $id);
        $response = $sqlquery->execute();
        $action   = 1;
    }
    
    if ((int)$action == 1) {
        $_SESSION['photostatus'] = "delete";
        header("Location: displayupdate.php?page=".$page."");
        exit;
    } else {
        $_SESSION['photostatus'] = "invalid";
        header("Location: displayupdate.php?page=".$page."");
        exit;
    }
?>