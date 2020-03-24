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
        header("Location: press.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                 =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $press_name         =   (!empty($_POST['press_name']) ) ? $DB->RemoveTags($_POST['press_name']) : null;
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 1;
    $thumb_image        =   null;
    $big_image          =   null;
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
    $targetFolder    =    "../uploads/presses/";
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
            $magicianObj -> saveImage($targetFolder.$big_image, 90);
        }

        //Thumb Image
        $magicianObj -> resizeImage(380, 380, 'landscape');
        $magicianObj -> saveImage($targetFolder.$thumb_image, 100);

        if(file_exists($tempFolder.$temp_image)){
            unlink($tempFolder.$temp_image);
        }
    }
    
    if (isset($edit) && !empty($press_name)){
        if ((int)$edit == 0){
            $sqlquery = $fpdo->insertInto('tblpresses', array(
                                            'press_name' => $press_name,
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
            $sqlquery = $fpdo->update('tblpresses')->set(array(
                                        'press_name' => $press_name,
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

            $sqlquery->where('tblpresses.id = ?', $id);
            $sqlquery->execute();
            
            $action = 2;
        }
    }
    
    if ((int)$action == 1) {
        $_SESSION['pressstatus'] =   "add";
        header("Location: displaypress.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['pressstatus'] =   "update";
        header("Location: displaypress.php");
        exit;
    } else {
        $_SESSION['pressstatus'] =   "invalid";
        header("Location: press.php");
        exit;
    }
?>