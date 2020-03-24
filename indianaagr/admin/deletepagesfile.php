<?php 
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    // Check if delete button active, start this
    if(!empty($_GET['delete']))
    {
        $id        = (!empty($_GET['id'])) ? (int)$_GET['id'] : 0;
        $file_name = (!empty($_GET['filename'])) ? trim($_GET['filename']) : null;
        $filetype  = (!empty($_GET['filetype'])) ? trim($_GET['filetype']) : null;
        $action    =  0;

        $dirpath   =  "../uploads/pages/";

        if(!empty($file_name)){

            if(file_exists($dirpath.$file_name)){
                unlink($dirpath.$file_name);
            }

            if($filetype == "thumb_image"){
                $thumb_image  =  null;
                $sqlquery     =  "UPDATE tblpages SET thumb_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "medium_image"){
                $background_image  =  null;
                $sqlquery     =  "UPDATE tblpages SET medium_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "background_image"){
                $background_image  =  null;
                $sqlquery     =  "UPDATE tblpages SET background_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "banner_image"){
                $banner_image =  null;
                $sqlquery     =  "UPDATE tblpages SET banner_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            }
            $action       =  1;
        }

        
        if ((int)$action == 1) {
            $_SESSION['pagestatus'] = "filedeleted";
            header("Location: pages.php?id=".$id."&edit=1");
            exit;
        } else {
            $_SESSION['pagestatus'] = "invalid";
            header("Location: pages.php?id=".$id."&edit=1");
            exit;
        }

    }
?>