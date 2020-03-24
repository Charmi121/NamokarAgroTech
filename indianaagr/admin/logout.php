<?php
 session_start();
 unset($_SESSION['adminkiranakingvalid']);
 session_unset();
 session_destroy();
 header("Location: login.php");
 exit;
?>