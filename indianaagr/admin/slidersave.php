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
        header("Location: slider.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $title              =   (!empty($_POST['title']) ) ? $DB->RemoveTags($_POST['title']) : '';
    $link_url           =   (!empty($_POST['link_url']) ) ? $DB->RemoveTags($_POST['link_url']) : '';
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 1;
    $thumb_image        =   '';
    $big_image          =   '';
    $created            =   date("Y-m-d H:i:s", strtotime('now'));
    $modified           =   date("Y-m-d H:i:s", strtotime('now'));
    $maxid              =   rand();
    $action             =   0;

    $dirpath            =   "../uploads/";
    if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777, true);
    }
    $tempFolder      =   "../uploads/temp-images/";
    if (!file_exists($tempFolder)) {
        mkdir($tempFolder, 0777, true);
    }
    $targetFolder    =    "../uploads/sliders/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }

    if(!empty($_FILES['big_image']) && floatval($_FILES['big_image']['size']) > 0)
    {
        $maxid = rand();
       
        //Create subfolder according to sku
        $fileext        =  pathinfo($_FILES['big_image']["name"], PATHINFO_EXTENSION);
        $filename       =  $DB->setFileName(strtolower(pathinfo($_FILES['big_image']["name"], PATHINFO_FILENAME)));
        
        $temp_image     =  $filename.".".$fileext; 
        $big_image      =  $filename."_".$maxid."_xl.".$fileext;
        $thumb_image    =  $filename."_".$maxid."_m2.".$fileext;
        
        move_uploaded_file($_FILES['big_image']["tmp_name"], $tempFolder.$temp_image);

        list($image_width, $image_height, $image_type, $image_attr) = getimagesize($tempFolder.$temp_image);
    
        //Large Image
        $magicianObj =  new imageLib($tempFolder.$temp_image);
        if((int)$image_width <= 2000) {
            copy($tempFolder.$temp_image, $targetFolder.$big_image);
        } else {                
            $magicianObj -> resizeImage(2000, 2000, 'landscape');
            $magicianObj -> saveImage($targetFolder.$big_image, 80);
        }

        //Thumb Image
        $magicianObj -> resizeImage(400, 400, 'landscape');
        $magicianObj -> saveImage($targetFolder.$thumb_image, 90);

        if(file_exists($tempFolder.$temp_image)){
            unlink($tempFolder.$temp_image);
        }
    }
    
    if (isset($edit) && !empty($title)){
        if ((int)$edit == 0){
            
            $sqlquery = $fpdo->insertInto('tblsliders', array(
                                            'title' => $title,
                                            'link_url' => trim($link_url),
                                            'thumb_image' => trim($thumb_image),
                                            'big_image' => trim($big_image),                                            
                                            'status' => $status,
                                            'sort_order' => $sort_order,
                                            'created' => $created,
                                            'modified' => $modified
                                         ));
            $sqlquery->execute();            
            $action = 1;
                        
        } else {
            
            $sqlquery = $fpdo->update('tblsliders')->set(array(
                                        'title' => $title,
                                        'link_url' => trim($link_url),
                                        'status' => $status,
                                        'sort_order' => $sort_order,
                                        'modified' => $modified
                                   ));
            if(!empty($big_image)) {
                $sqlquery->set(array(
                                "thumb_image" => $thumb_image,
                                "big_image" => $big_image
                              ));   
            }

            $sqlquery->where('tblsliders.id = ?', $id);
            $sqlquery->execute();
            
            $action = 2;
            
        }
    }
    
    if ((int)$action == 1) {
        $_SESSION['sliderstatus'] = "add";
        header("Location: displayslider.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['sliderstatus'] = "update";
        header("Location: displayslider.php");
        exit;
    } else {
        $_SESSION['sliderstatus'] = "invalid";
        header("Location: slider.php");
        exit;
    }
?>