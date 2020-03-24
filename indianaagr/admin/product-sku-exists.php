<?php
  require_once('session.php');
  require_once('rightusercheck.php');
  require_once('connect.inc.php');
  require_once('config.php');
  require_once('main.php');
  $DB = new DBConfig();
  
  $sku = $DB->removeTags($_POST['sku']);
  if(!empty($sku)) {
    $sqlquery = $fpdo->from("tblproducts")
                     ->select(null)
                     ->select("tblproducts.id")
                     ->where("tblproducts.sku LIKE :sku", array(":sku" => "".$sku.""));
    $rsproducts = $sqlquery->fetchAll();
    if (count($rsproducts)>0) {
        echo "1";
	    exit();
	} else {
        echo "0";
        exit();
    }
  } else {
      echo "invalid";
      exit();
  }
?>