<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    require_once('plugins/php-image-magician/php_image_magician.php');
    $DB = new DBConfig();
    
    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: pages.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $meta_title         =   (!empty($_POST['meta_title'])) ?  htmlentities($_POST['meta_title'],ENT_QUOTES,"utf-8") : null;
    $meta_keyword       =   (!empty($_POST['meta_keyword'])) ? htmlentities($_POST['meta_keyword'],ENT_QUOTES,"utf-8") :null;
    $meta_description   =   (!empty($_POST['meta_description'])) ? htmlentities($_POST['meta_description'],ENT_QUOTES,"utf-8") : null;
    $seo_url            =   (!empty($_POST['seo_url'])) ? $DB->cleanInput($_POST['seo_url']): null;
    $page_title         =   (!empty($_POST['page_title'])) ? $DB->cleanInput($_POST['page_title']): null;
    $description        =   (!empty($_POST['description'])) ? htmlentities($_POST['description'],ENT_QUOTES,"utf-8") : null;
    $display_home       =   (!empty($_POST['display_home'])) ? (int)$_POST['display_home'] : 505;
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 1;
    $banner_image       =    null;
    $action             =    0;
    $created            =   date("Y-m-d H:i:s", strtotime('now'));
    $modified           =   date("Y-m-d H:i:s", strtotime('now'));

    $maxid = rand();

    /* if(floatval($_FILES['banner_image']['size']) > 0){
        $maxid          =   rand();

        $dirpath    =    "../uploads/pages/";
        if (!file_exists($dirpath)) {
            mkdir($dirpath);
        }

        $fileext     =  pathinfo($_FILES['banner_image']["name"], PATHINFO_EXTENSION);

        $filename     =  $maxid.".".$fileext;
        $banner_image  =  $maxid."_banner.".$fileext;
        move_uploaded_file($_FILES['banner_image']["tmp_name"], "../uploads/temp-images/".$filename);


        //Thumb Image
        $magicianObj =  new imageLib('../uploads/temp-images/'.$filename);
        //$magicianObj -> resizeImage(130, 130, 'auto');
        $magicianObj -> resizeImage(1365, 550,  2, true);
        $magicianObj -> saveImage($dirpath.$banner_image, 70);

        if(file_exists('../uploads/temp-images/'.$filename)){
            unlink('../uploads/temp-images/'.$filename);
        }
    } */
    
    $dirpath          = "../uploads/";
    if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777, true);
    }
    $tempimages       = "../uploads/temp-images/";
    if (!file_exists($tempimages)) {
        mkdir($tempimages, 0777, true);
    }
    $targetFolder     = "../uploads/pages/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    if(floatval($_FILES['banner_image']['size']) > 0) {
        $filename     = $DB->setFileName(strtolower(pathinfo($_FILES['banner_image']['name'], PATHINFO_FILENAME)));            
        $fileext      = strtolower(pathinfo($_FILES['banner_image']["name"], PATHINFO_EXTENSION));
        $banner_image = $filename."-".$maxid.".".$fileext;
        move_uploaded_file($_FILES['banner_image']["tmp_name"], $targetFolder.$banner_image);
    }
    
    $slug1                  =   preg_replace('/[\']/', '', $_POST['page_title']);
    $slug                   =   preg_replace('/[^a-z0-9\s]/', '', strtolower($slug1));
    $seo_result             =   array();
    $seo_result             =   $DB->seoURLExist("tblpages", $slug, $id);
    $seo_url                =   $seo_result['seo_url'];

    if (isset($edit) && !empty($page_title)) {
        if ((int)$edit == 0){
            //$sqlquery   =  "INSERT INTO tblpages (title, meta_keyword, meta_description, catid, subcatid, page_title, description, bigimage, status, sort_order) ";
            $sqlquery   =  "INSERT INTO tblpages (meta_title, meta_keyword, meta_description, seo_url, page_title, description, banner_image, display_home, status, sort_order, created, modified) ";
            $sqlquery   =  $sqlquery." VALUES('".$meta_title."', '".$meta_keyword."', '".$meta_description."', '".$seo_url."', '".$page_title."', '".$description."', '".$banner_image."', ".$display_home.", ".$status.", ".$sort_order.", '".$created."', '".$modified."')";
            $result     =  $fpdo->customResult($sqlquery);
            $action     =  1;
        } else {
            $sqlquery   = "UPDATE tblpages SET meta_title = '".$meta_title."', meta_keyword = '".$meta_keyword."', meta_description = '".$meta_description."', seo_url = '".$seo_url."', page_title = '".$page_title."', description = '".$description."', display_home = ".$display_home.", status = ".$status.", sort_order = ".$sort_order.", modified = '".$modified."'";
            if(!empty($banner_image)) {
                $sqlquery   =  $sqlquery.", banner_image = '".$banner_image."'";
            }
            $sqlquery   =  $sqlquery." WHERE id = ".$id."";
            $result     =  $fpdo->customResult($sqlquery);
            $action     =  2;
        }
    }


    if ((int)$action == 1) {
        $_SESSION['pagestatus'] = "add";
        header("Location: displaypages.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['pagestatus'] = "update";
        header("Location: displaypages.php");
        exit;
    } else {
        $_SESSION['pagestatus'] = "invalid";
        header("Location: displaypages.php");
        exit;
    }
?>