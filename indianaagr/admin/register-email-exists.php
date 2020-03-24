<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    $DB = new DBConfig();
    
    $email = $DB->cleanInput($_POST['email']);
    $id = $DB->removeTags($_POST['id']);
    if(!empty($email))
    {
      $sqlquery = $fpdo->from('tblregister')
                       ->where('tblregister.id != :id AND tblregister.email LIKE :email', array(":id" => $id, ":email" => $email));
      $rsdata   = $sqlquery->fetchAll();
      if(count($rsdata) > 0) {
        echo "1";
      } else {
        echo "0";  
      }  
    } else {
        echo "invalid";
    }
    exit();
?>