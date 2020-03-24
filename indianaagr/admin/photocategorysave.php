<?php
    require_once('session.php');
    require_once('connect.inc.php');
	require_once('config.php');
	require_once('main.php');
	require_once('errorcodes.php');
    require_once('php-image-magician/php_image_magician.php');
    $DB = new DBConfig();


    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: photocategory.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $meta_title         =   (!empty($_POST['meta_title'])) ?  htmlentities($_POST['meta_title'],ENT_QUOTES,"utf-8") : '';
    $meta_keyword       =   (!empty($_POST['meta_keyword'])) ? htmlentities($_POST['meta_keyword'],ENT_QUOTES,"utf-8") :'';
    $meta_description   =   (!empty($_POST['meta_description'])) ? htmlentities($_POST['meta_description'],ENT_QUOTES,"utf-8") : '';
    $description        =   (!empty($_POST['description'])) ? htmlentities($_POST['description'],ENT_QUOTES,"utf-8") : '';
    $photo_category_name=   (!empty($_POST['photo_category_name']) ) ? $DB->RemoveTags($_POST['photo_category_name']) : '';
    $seo_url            =   (!empty($_POST['seo_url']) ) ? $DB->RemoveTags($_POST['seo_url']) : '';
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 0;
    $thumb_image        =   '';
    $banner_image       =   '';
    $now                =   date("Y-m-d H:i:s", strtotime('now'));
    $maxid              =   rand();
    $action             =   0;


    $dirpath    =    "../uploads/";
    if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777, true);
    }
    $tempimages    =    "../uploads/temp-images/";
    if (!file_exists($tempimages)) {
        mkdir($tempimages, 0777, true);
    }
    $targetFolder    =    "../uploads/photo-categories/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    if(floatval($_FILES['thumb_image']['size']) > 0)
    {
        $fileext        =   pathinfo($_FILES['thumb_image']["name"], PATHINFO_EXTENSION);
        $filename       =  $DB->setFileName(strtolower(pathinfo($_FILES['thumb_image']["name"], PATHINFO_FILENAME)));
        $thumb_image     =  $maxid.$filename.".".$fileext; 
        move_uploaded_file($_FILES['thumb_image']["tmp_name"], "../uploads/photo-categories/".$thumb_image);
    }  

    /* if(floatval($_FILES['banner_image']['size']) > 0)
    {
    $fileext        =   pathinfo($_FILES['banner_image']["name"], PATHINFO_EXTENSION);

    $banner_image     =   $maxid."category-1600.".$fileext;
    //$banner_image     =   $maxid.".".$fileext;
    move_uploaded_file($_FILES['banner_image']["tmp_name"], "../uploads/temp-images/".$banner_image);

    $magicianObj = new imageLib('../uploads/temp-images/'.$banner_image);
    $magicianObj -> resizeImage(1600, 375, "auto", true);
    $magicianObj -> saveImage('../uploads/photo-categories/'.$banner_image, 100);

    if(file_exists('../uploads/temp-images/'.$banner_image)){
    unlink('../uploads/temp-images/'.$banner_image);
    }
    }    */

    /*function seoURLExist($table_name, $seo_url) {
    $result =  null;
    $slug = $seo_url;
    $i    = 0;
    $sqlquery   =   "SELECT * FROM ".$table_name."";
    $sqlquery   =   $sqlquery . " WHERE seo_url LIKE '".$slug."%', ".$rowsPerPage."";
    $sqlquery   =   $sqlquery . " ORDER BY id DESC LIMIT 1 ";
    $rsseo      =   $DB->getdata($sqlquery);
    if (mysql_num_rows($rsseo)>0)
    {
    while($rowseo = mysql_fetch_array($rsseo)) {
    $slug = $rowseo['seo_url'];
    }
    if (!preg_match ('/-{1}[0-9]+$/', $slug )) {
    $slug .= '-' . ++$i;
    } else {
    $max = explode("-", $slug);
    $num = (count($max) - 1);
    $slug = preg_replace ('/[0-9]+$/', ++$max[$num], $slug );
    }
    $result  = $slug;
    }else {
    $result = $slug;
    }
    return $result;
    }    */


    $slug1          = preg_replace('/[\']/', '', $photo_category_name);
    $slug           = preg_replace('/[^a-z0-9\s]/', '', strtolower($slug1));
    $seo_result     =   array();
    $seo_result     =   $DB->seoURLExist("tblphoto_categories", $slug, $id);
    $seo_url        =   $seo_result['seo_url'];

    // echo $seo_url;


    if (isset($edit) && !empty($photo_category_name)){
        if ((int)$edit == 0){
            $ipadd      =   $DB->getRealIpAddr();
            $sqlquery = $fpdo->insertInto('tblphoto_categories', array(
                                            'meta_title' => $meta_title,
                                            'meta_keyword' => $meta_keyword,
                                            'meta_description' => $meta_description,
                                            'photo_category_name' => $photo_category_name,
                                            'seo_url' => $seo_url,
                                            'description' => $description,
                                            'thumb_image' => $thumb_image,
                                            'banner_image' => $banner_image,
                                            'status' => $status,
                                            'sort_order' => $sort_order,
                                            'created' => $now,
                                            'modified' => $now,
                                         ));
            $sqlquery->execute();          
            $action     =  1;
        } else {
           
            $sqlquery = $fpdo->update('tblphoto_categories')->set(array(
                                        'meta_title' => $meta_title,
                                        'meta_keyword' => $meta_keyword,
                                        'meta_description' => $meta_description,
                                        'photo_category_name' => $photo_category_name,
                                        'seo_url' => $seo_url,
                                        'description' => $description,
                                        'status' => $status,
                                        'sort_order' => $sort_order
                                   ));
			if(!empty($thumb_image)) {
				$sqlquery->set(array(
                                "thumb_image" => $thumb_image
                              ));   
            }
            if(!empty($banner_image)) {
				$sqlquery->set(array(
                                "banner_image" => $banner_image
                              ));   
            }
			$sqlquery->where('tblphoto_categories.id = ?', $id);
            $sqlquery->execute();
            $action     =  2;
        }
    }

    if ((int)$action == 1) {
        $_SESSION['photocategorystatus'] =   "add";
        header("Location: displayphotocategory.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['photocategorystatus'] =   "update";
        header("Location: displayphotocategory.php");
        exit;
    } else {
        $_SESSION['photocategorystatus'] =   "invalid";
        header("Location: photocategory.php");
        exit;
    } 
?>