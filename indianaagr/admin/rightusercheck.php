<?php
    //session_start();
    if (!empty($_SESSION['adminkiranakingrights'])) {
        $_SESSION['adminkiranakingvalid']    =   707;
        $_SESSION['adminkiranakinguserid']   =   $_SESSION['adminkiranakinguserid'];
        $_SESSION['adminkiranakingusername'] =   $_SESSION['adminkiranakingusername'];
        $_SESSION['adminkiranakingemail']    =   $_SESSION['adminkiranakingemail'];
        $_SESSION['adminkiranakingrights']   =   $_SESSION['adminkiranakingrights'];
    } else {
        $_SESSION['adminkiranakingvalid'] = 505;
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }
?>