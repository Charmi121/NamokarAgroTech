<?php

set_time_limit(0);
require_once('session.php');
require_once('rightusercheck.php');
require_once('connect.inc.php');
require_once('config.php');
require_once('main.php');
require_once('plugins/php-image-magician/php_image_magician.php');
$DB = new DBConfig();
/*
  //Check First for Valid Form Submission
  if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
  {
  unset($_SESSION['tokencode']);
  header("Location: product.php");
  exit;
  }
  unset($_SESSION['tokencode']);
 */

//echo '<pre>';
//print_r($_FILES);exit;

$edit = (!empty($_POST['edit'])) ? (int) $_POST['edit'] : 0;
$delete = (!empty($_POST['delete'])) ? (int) $_POST['delete'] : 0;
$title = (!empty($_POST['alt_text'])) ? trim($_POST['alt_text']) : '';
$product_id = (!empty($_POST['product_id'])) ? (int) $_POST['product_id'] : 0;
$id = (!empty($_POST['id'])) ? (int) $_POST['id'] : 0;
$status = (!empty($_POST['status'])) ? (int) $_POST['status'] : 707;
$sort_order = (!empty($_POST['sort_order'])) ? (int) $_POST['sort_order'] : 0;
$now = date('Y-m-d H:i:s', strtotime('now'));
if (!empty($product_id) && empty($edit) && empty($delete)) {
        $tempFolder         =   "../uploads/temp-images/";
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0777, true);
        }
        $targetFolder       =    "../uploads/products/";
        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }
        $i = 1;
        if(!empty($_FILES['big_image_'.$i.'']) && floatval($_FILES['big_image_'.$i.'']['size']) > 0){
            $maxid = rand();

            //Create subfolder according to sku
            $fileext        =  pathinfo($_FILES['big_image_'.$i.'']["name"], PATHINFO_EXTENSION);
            $filename       =  $DB->setFileName(strtolower(pathinfo($_FILES['big_image_'.$i.'']["name"], PATHINFO_FILENAME)));

            $temp_image     =  $filename.".".$fileext; 
            $big_image      =  $filename."_".$maxid."_xl.".$fileext;
            $thumb_image    =  $filename."_".$maxid."_m2.".$fileext;
           
            move_uploaded_file($_FILES['big_image_'.$i.'']["tmp_name"], $tempFolder.$temp_image);

            //Large Image
            list($image_width, $image_height, $image_type, $image_attr) = getimagesize($tempFolder.$temp_image);
            $thumbimage   = $filename."-".$maxid."_s.".$fileext;

            $magicianObj =  new imageLib($tempFolder.$temp_image);
            if((int)$image_width <= 2000) {
                copy($tempFolder.$temp_image, $targetFolder.$big_image);
            } else {                
                //Large Image
                $magicianObj -> resizeImage(2000, 2000, 'landscape');
                $magicianObj -> saveImage($targetFolder.$big_image, 90);
            }

            //Thumb Image
            //$magicianObj =  new imageLib($tempFolder.$temp_image);
            $magicianObj -> resizeImage(300, '', 'landscape');
            $magicianObj -> saveImage($targetFolder.$thumb_image, 90);

            if(file_exists($tempFolder.$temp_image)){
                unlink($tempFolder.$temp_image);
            }
        }

    $sqlquery = $fpdo->insertInto('tblproduct_gallery_images', array(
        'product_id' => $product_id,
        'alt_text' => $title,
        'status' => $status,
        'sort_order' => $sort_order,
        'thumb_image' => $thumb_image,
        'big_image' => $big_image,
        'created' => $now,
        'modified' => $now
    ));
    $sqlquery->execute();
    $action = 1;
} else if (!empty($product_id) && !empty($edit) && !empty($id) && empty($delete)) {
    $sqlquery = $fpdo->update('tblproduct_gallery_images')->set(array(
                'product_id' => $product_id,
                'alt_text' => $title,
                'status' => $status,
                'sort_order' => $sort_order,
                'modified' => $now
            ))->where('id = ?', $id);
    $sqlquery->execute();

    $action = 2;
} else if (!empty($product_id) && !empty($delete) && !empty($id)) {
    $sqlquery = $fpdo->update('tblproduct_gallery_images')->set(array(
                'status' => 909,
                'modified' => $now
            ))->where('id = ?', $id);
    $sqlquery->execute();

    $action = 3;
}

if ((int) $action == 1) {
    $_SESSION['gallerystatus'] = "add";
    header("Location: product-gallery.php?product_id=" . $product_id . "&edit=0");
    exit;
} elseif ((int) $action == 2) {
    $_SESSION['gallerystatus'] = "update";
    header("Location: product-gallery.php?product_id=" . $product_id . "&edit=0");
    exit;
} elseif ((int) $action == 3) {
    $_SESSION['gallerystatus'] = "deleted";
    header("Location: product-gallery.php?product_id=" . $product_id . "&edit=0");
    exit;
} else {
    $_SESSION['gallerystatus'] = "invalid";
    header("Location: displayproduct.php");
    exit;
}
?>