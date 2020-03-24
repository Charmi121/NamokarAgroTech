<?php
    require_once('session.php');
    require_once('connect.inc.php');
	require_once('config.php');
	require_once('main.php');
	require_once('errorcodes.php');
    require_once('php-image-magician/php_image_magician.php');
    $DB = new DBConfig();


    //Check First for Valid Form Submission
    /*if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: photogallery.php");
        exit;
    }
    unset($_SESSION['tokencode']); */
    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $photo_category_id  =   (!empty($_POST['photo_category_id'])) ? (int)$_POST['photo_category_id'] : 0;
    $title              =   (!empty($_POST['title'])) ? $DB->cleanInput($_POST['title']) : '';
    $uploadedfiles      =   (!empty($_POST['uploadedfiles'])) ? array_unique(explode(',', $_POST['uploadedfiles'])) : array();
    $countfiles         =   count($uploadedfiles);
    $sort_order			=	(!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 0;
    $now                =   date("Y-m-d H:i:s", strtotime('now'));
	$thumb_image		=	'';
	$big_image			=	'';
    $maxid              =   rand();
    $action             =   0;
	
    //Now check file exist
	$dirpath    =    "../uploads/";
    if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777, true);
    }
    $tempimages    =    "../uploads/temp-images/";
    if (!file_exists($tempimages)) {
        mkdir($tempimages, 0777, true);
    }
    $targetFolder    =    "../uploads/photo-galleries/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    if(floatval($_FILES['thumb_image']['size']) > 0)
    {
        $fileext        =   pathinfo($_FILES['thumb_image']["name"], PATHINFO_EXTENSION);

        $thumb_image     =   $maxid."photo-category-273.".$fileext;
        //$thumb_image     =   $maxid.".".$fileext;
        move_uploaded_file($_FILES['thumb_image']["tmp_name"], "../uploads/temp-images/".$thumb_image);

        $magicianObj = new imageLib('../uploads/temp-images/'.$thumb_image);
        //$magicianObj -> resizeImage(273, 243,  array('crop', 'm'), true);
        $magicianObj -> resizeImage(273, 243,  "auto", true);
        $magicianObj -> saveImage('../uploads/photo-galleries/'.$thumb_image, 100);

        if(file_exists('../uploads/temp-images/'.$thumb_image)){
            unlink('../uploads/temp-images/'.$thumb_image);
        }
    }  
	
   if(!empty($title)){
		$sqlquery = $fpdo->insertInto('tblphoto_galleries', array(
									'photo_category_id' => $photo_category_id,
									'title' => $title,
									'thumb_image' => $thumb_image,
									'big_image' => $big_image,
									'status' => 707,
									'sort_order' => $sort_order
								 ));
		$sqlquery->execute();  
		$action     =  1;		
    }
  
    if ((int)$action == 1) {
       $_SESSION['photogallerystatus'] =   "add";
        header("Location: displayphotogallery.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['photogallerystatus'] =   "update";
        header("Location: displayphotogallery.php");
        exit;
    } else {
        $_SESSION['photogallerystatus'] =   "invalid";
        header("Location: photogallery.php");
        exit;
    } 
?>	