<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    $featured_products_list =   (!empty($_POST['products_list'])) ? $_POST['products_list'] : array();
    $created                =   date("Y-m-d H:i:s", strtotime('now'));
    $modified               =   date("Y-m-d H:i:s", strtotime('now'));
    
    //Truncate Data From Table
    $sqlquery   =  "TRUNCATE table tblproduct_featured";
    $result     =  $fpdo->customResult($sqlquery);
    
    foreach($featured_products_list as $key => $product_id){
        $sqlquery = $fpdo->insertInto('tblproduct_featured', array(
                                         'product_id' => $product_id,
                                         'created' => $created,
                                         'modified' => $modified
                                     ));
        $sqlquery->execute();
    }
    $action = 2;


    if ((int)$action == 1) {
        $_SESSION['productfeaturedstatus'] =   "add";
        header("Location: featuredproducts.php");
        exit;
    } elseif ((int)$action == 2) {
       $_SESSION['productfeaturedstatus'] =   "update";
       header("Location: featuredproducts.php");
       exit;
    } else {
        $_SESSION['productfeaturedstatus'] =   "invalid";
        header("Location: featuredproducts.php");
        exit;
    }
?>