<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    require_once('plugins/php-image-magician/php_image_magician.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: category.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $parent_id          =   (!empty($_POST['parent_id'])) ? (int)$_POST['parent_id'] : 0;
    $meta_title         =   (!empty($_POST['meta_title'])) ?  htmlentities($_POST['meta_title'],ENT_QUOTES,"utf-8") : null;
    $meta_keyword       =   (!empty($_POST['meta_keyword'])) ? htmlentities($_POST['meta_keyword'],ENT_QUOTES,"utf-8") :null;
    $meta_description   =   (!empty($_POST['meta_description'])) ? htmlentities($_POST['meta_description'],ENT_QUOTES,"utf-8") : null;
    $short_description  =   (!empty($_POST['short_description'])) ? htmlentities($_POST['short_description'],ENT_QUOTES,"utf-8") : null;
    $description        =   (!empty($_POST['description'])) ? htmlentities($_POST['description'],ENT_QUOTES,"utf-8") : null;
    $category_name      =   (!empty($_POST['category_name']) ) ? $DB->RemoveTags($_POST['category_name']) : null;
    $seo_url            =   (!empty($_POST['seo_url']) ) ? $DB->RemoveTags($_POST['seo_url']) : null;
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $show_home          =   (!empty($_POST['show_home'])) ? (int)$_POST['show_home'] : 0;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 0;
    $category_logo      =   null;
    $thumb_image        =   null;
    $medium_image       =   null;
    $background_image   =   null;
    $banner_image       =   null;
    $now                =   date("Y-m-d H:i:s", strtotime('now'));
    $created            =   date("Y-m-d H:i:s", strtotime('now'));
    $modified           =   date("Y-m-d H:i:s", strtotime('now'));
    $maxid              =   rand();
    $action             =   0;

    $dirpath            =   "../uploads/";
    if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777, true);
    }
    $tempimages         =   "../uploads/temp-images/";
    if (!file_exists($tempimages)) {
        mkdir($tempimages, 0777, true);
    }
    $targetFolder    =    "../uploads/categories/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }
	$categoryTargetFolder    =    "../uploads/category_logos/";
    if (!file_exists($categoryTargetFolder)) {
        mkdir($categoryTargetFolder, 0777, true);
    }
	
	if(floatval($_FILES['category_logo']['size']) > 0) {
        $filename     = $DB->setFileName(strtolower(pathinfo($_FILES['category_logo']['name'], PATHINFO_FILENAME)));            
        $fileext      = strtolower(pathinfo($_FILES['category_logo']["name"], PATHINFO_EXTENSION));
		if($fileext == 'png') {
			$category_logo  = $filename."-".$maxid.".".$fileext;
			move_uploaded_file($_FILES['category_logo']["tmp_name"], $categoryTargetFolder.$category_logo);
		} else {
			$_SESSION['categorystatus'] =   "invalid_file";
			if($edit == 1){
				header("Location: category.php?id=".$product_id."&edit=1");
				exit;
			} else {
				header("Location: category.php");
				exit;
			}
		}
    }

    if(floatval($_FILES['thumb_image']['size']) > 0) {
        $filename     = $DB->setFileName(strtolower(pathinfo($_FILES['thumb_image']['name'], PATHINFO_FILENAME)));            
        $fileext      = strtolower(pathinfo($_FILES['thumb_image']["name"], PATHINFO_EXTENSION));
        $thumb_image  = $filename."-".$maxid.".".$fileext;
        move_uploaded_file($_FILES['thumb_image']["tmp_name"], $targetFolder.$thumb_image);
    }
    
    if(floatval($_FILES['medium_image']['size']) > 0) {
        $filename     = $DB->setFileName(strtolower(pathinfo($_FILES['medium_image']['name'], PATHINFO_FILENAME)));
        $fileext      = strtolower(pathinfo($_FILES['medium_image']["name"], PATHINFO_EXTENSION));
        $medium_image = $filename."-".$maxid.".".$fileext;
        move_uploaded_file($_FILES['medium_image']["tmp_name"], $targetFolder.$medium_image);
    }
    
	if(floatval($_FILES['banner_image']['size']) > 0) {
        $filename     = $DB->setFileName(strtolower(pathinfo($_FILES['banner_image']['name'], PATHINFO_FILENAME)));
        $fileext      = strtolower(pathinfo($_FILES['banner_image']["name"], PATHINFO_EXTENSION));
        $banner_image = $filename."-".$maxid.".".$fileext;
        move_uploaded_file($_FILES['banner_image']["tmp_name"], $targetFolder.$banner_image);
    }
	
    $slug1          =   preg_replace('/[\']/', '', $category_name);
    $slug           =   preg_replace('/[^a-z0-9\s]/', '', strtolower($slug1));
    $seo_result     =   array();
    $seo_result     =   $DB->seoURLExist("tblcategories", $slug, $id);
    $seo_url        =   $seo_result['seo_url'];

    if (isset($edit) && !empty($category_name)){
        if ((int)$edit == 0){
            $sqlquery   =   "INSERT INTO tblcategories (meta_title, meta_keyword, meta_description, parent_id, category_name, seo_url, short_description, description, category_logo, thumb_image, medium_image, background_image,  banner_image, show_home, status, sort_order, created, modified) ";
            $sqlquery   =   $sqlquery . " VALUES ('".$meta_title."', '".$meta_keyword."', '".$meta_description."', ".$parent_id.", '".$category_name."', '".$seo_url."', '".$short_description."', '".$description."', '".$category_logo."', '".$thumb_image."', '".$medium_image."', '".$background_image."','".$banner_image."', ".$show_home.",".$status.", ".$sort_order.", '".$created."', '".$modified."')";
            $rsdata     =   $fpdo->customResult($sqlquery);
            $action     =   1;
        } else {
            $sqlquery   =  "UPDATE tblcategories SET meta_title = '".$meta_title."', meta_keyword = '".$meta_keyword."', meta_description = '".$meta_description."', parent_id = ".$parent_id.", category_name = '".$category_name."', seo_url = '".$seo_url."', short_description = '".$short_description."', description = '".$description."',  status = ".$status.", show_home = ".$show_home.", sort_order = ".$sort_order."";
            if(!empty($category_logo)) {
                $sqlquery   =  $sqlquery.", category_logo = '".$category_logo."'";
            }
			if(!empty($thumb_image)) {
                $sqlquery   =  $sqlquery.", thumb_image = '".$thumb_image."'";
            }
            if(!empty($medium_image)) {
                $sqlquery   =  $sqlquery.", medium_image = '".$medium_image."'";
            }
            if(!empty($background_image)) {
                $sqlquery   =  $sqlquery.", background_image = '".$background_image."'";
            }
            if(!empty($banner_image)) {
                $sqlquery   =  $sqlquery.", banner_image = '".$banner_image."'";
            }
            $sqlquery   =  $sqlquery." WHERE id = ".$id."";
            $result     =  $fpdo->customResult($sqlquery);
            $action     =  2;
        }
    }

    if ((int)$action == 1) {
        $_SESSION['categorystatus'] =   "add";
        header("Location: displaycategory.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['categorystatus'] =   "update";
        header("Location: displaycategory.php");
        exit;
    } else {
        $_SESSION['categorystatus'] =   "invalid";
        header("Location: category.php");
        exit;
    }
?>