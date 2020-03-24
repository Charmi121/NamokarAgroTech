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
        header("Location: news-event.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $photo_title        =   (!empty($_POST['photo_title']) ) ? $DB->RemoveTags($_POST['photo_title']) : '';
    $desc       	    =   (!empty($_POST['desc']) ) ? $DB->RemoveTags($_POST['desc']) : '';
	$location       	    =   (!empty($_POST['location']) ) ? $DB->RemoveTags($_POST['location']) : '';
	$url       	    =   (!empty($_POST['url']) ) ? $DB->RemoveTags($_POST['url']) : '';
	$seo_url            =   (!empty($_POST['seo_url']) ) ? $DB->RemoveTags($_POST['seo_url']) : null;
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 0;
    $thumb_image        =   '';
    $big_image          =   '';   
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
    $targetFolder    =    "../uploads/news-event/";
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
        //if((int)$image_width <= 2000) {
            //copy($tempFolder.$temp_image, $targetFolder.$big_image);
        //} else {                
            $magicianObj -> resizeImage(1000, 650, 'landscape');
            $magicianObj -> saveImage($targetFolder.$big_image, 90);
        //}

        //Thumb Image
        $magicianObj -> resizeImage(86, 68, array('crop', 'm'), true);
        $magicianObj -> saveImage($targetFolder.$thumb_image, 100);

        if(file_exists($tempFolder.$temp_image)){
            unlink($tempFolder.$temp_image);
        }
    }
    //echo $seo_url ; exit;
    if (isset($edit)){
        if ((int)$edit == 0){
            $sqlquery = $fpdo->insertInto('tblcompany_update', array(
                                            'title' => $photo_title,
											'seo_url' => $seo_url,
                                            'description' => $desc,
											'location' => $location,
											'url' => $url,
                                            'thumb_image' => trim($thumb_image),
                                            'big_image' => trim($big_image),
                                            'status' => $status,
                                            'sort_order' => $sort_order                                            
                                         ));
            $sqlquery->execute();            
            $action = 1;
            
        } else {
            
            $sqlquery = $fpdo->update('tblcompany_update')->set(array(
                                        'title' => $photo_title,
										'seo_url' => $seo_url,
                                        'description' => $desc,
										'location' => $location,
										'url' => $url,
                                        'status' => $status,
                                        'sort_order' => $sort_order                                       
                                   ));
            if(!empty($big_image)) {
                $sqlquery->set(array(
                                "thumb_image" => $thumb_image,
                                "big_image" => $big_image
                              ));   
            }

            $sqlquery->where('tblcompany_update.id = ?', $id);
            $sqlquery->execute();
            
            $action = 2;
        }
    }
    
    if ((int)$action == 1) {
        $_SESSION['photostatus'] =   "add";
        header("Location: displayupdate.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['photostatus'] =   "update";
        header("Location: displayupdate.php");
        exit;
    } else {
        $_SESSION['photostatus'] =   "invalid";
        header("Location: company-update.php");
        exit;
    }
?>