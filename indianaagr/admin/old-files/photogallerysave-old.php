<?php
    require_once('session.php');
    require_once('connect.inc.php');
	require_once('config.php');
	require_once('main.php');
	require_once('errorcodes.php');
   // require_once('php-image-magician/php_image_magician.php');
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
    $maxid              =   rand();
    $action             =   0;
    
    //Now check file exist
    $temppath   =   "../uploads/photo-galleries/";
    for($i=0; $i<(int)$countfiles; $i++){
		
        //if(is_file($temppath.$uploadedfiles[$i]) && is_file($temppath.$uploadedfiles[$i+1])){
        if(!empty($uploadedfiles[$i]) && !empty($uploadedfiles[$i+1])) {
			$sqlquery = $fpdo->insertInto('tblphoto_galleries', array(
                                            'photo_category_id' => $photo_category_id,
                                            'title' => $title,
                                            'thumb_image' => $uploadedfiles[$i],
                                            'big_image' => $uploadedfiles[$i+1],
                                            'status' => 707,
											'sort_order' => $sort_order
                                         ));
            $sqlquery->execute();  
            $action     =  1;
        }
        $i = $i+1;
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