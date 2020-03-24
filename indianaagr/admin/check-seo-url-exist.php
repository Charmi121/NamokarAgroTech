<?php
    header('Content-Type: application/json');
     require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    $DBCHECK = new DBConfig();
    
    //$_POST['seo_url'] = "Kabuli Chana 500 GM";
    //$_POST['table_name'] = "tblproducts";
    
    $seo_url    = (!empty($_POST['seo_url'])) ? $DBCHECK->SEOURL($DBCHECK->RemoveTags($_POST['seo_url'])) : "";
    $table_name = (!empty($_POST['table_name'])) ? $DBCHECK->cleanInput($_POST['table_name']) : "";
    $id = (!empty($_POST['id'])) ? $DBCHECK->cleanInput($_POST['id']) : 0;
    if (!empty($table_name) && !empty($seo_url)) {
       echo json_encode($DBCHECK->seoURLExist($table_name, $seo_url, $id));
       exit;
    } else {
       $result['status']  = "failure";
       echo json_encode($result);
       exit;
    }
    $DBCHECK->close();
?>