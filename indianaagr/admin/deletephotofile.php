<?php 
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    // Check if delete button active, start this
    if(!empty($_GET['delete'])) {
        $id        = (!empty($_GET['id'])) ? (int)$_GET['id'] : 0;
        $filename  = (!empty($_GET['filename'])) ? trim($_GET['filename']) : null;
        $filetype  = (!empty($_GET['filetype'])) ? trim($_GET['filetype']) : null;
        $action    = 0;

        $dirpath   = "../uploads/photos/";

        if(!empty($filename)){
            
            if(file_exists($dirpath.$filename)){
                unlink($dirpath.$filename);
            }

            if(trim($filetype) == "big_image" || trim($filetype) == "thumb_image") {
                $thumb_image  =  '';
                $big_image    =  ''; 
                $sqlquery     =  "UPDATE tblphotos SET thumb_image = '".$thumb_image."' AND big_image = '".$big_image."'";
                $sqlquery     =  $sqlquery." WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            }
            $action       =  1;
        }

        if ((int)$action == 1) {
            $_SESSION['photostatus'] = "filedeleted";
            header("Location: photo.php?id=".$id."&edit=1");
            exit;
        } else {
            $_SESSION['photostatus'] = "invalid";
            header("Location: photo.php?id=".$id."&edit=1");
            exit;
        }
    }
?>