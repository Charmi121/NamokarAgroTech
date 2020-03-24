<?php
    header('Cache-Control: max-age=900');
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('paging.php');
    require_once('plugins/php-image-magician/php_image_magician.php');
    $DB = new DBConfig();
    
    $targetFolder = "../uploads/products/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }
    
    $sqlquery = $fpdo->from("tblproduct_images")
                     ->select(null)
                     ->select("tblproduct_images.id, tblproduct_images.product_id, tblproduct_images.thumb_image, tblproduct_images.show_as_main")
                     ->order("tblproduct_images.id");
    $rsproduct_images = $sqlquery->fetchAll();
    if (count($rsproduct_images) > 0){
        foreach($rsproduct_images as $rowproduct_image) {
            if(!empty($rowproduct_image['thumb_image']) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$rowproduct_image['thumb_image']) == 1){
                
                //Thumb Image
                $magicianObj =  new imageLib(UPLOAD_PATH."/products/".$rowproduct_image['thumb_image']);
                $magicianObj -> resizeImage(300, 300, 'landscape');
                $magicianObj -> saveImage($targetFolder.$rowproduct_image['thumb_image'], 90);
            }
        }
    }
?>