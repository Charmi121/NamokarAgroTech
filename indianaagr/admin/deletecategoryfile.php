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

        $dirpath   	=  "../uploads/categories/";
		$logodirpath =  "../uploads/category_logos/";
        if(!empty($file_name)){

            if(file_exists($dirpath.$file_name)){
                unlink($dirpath.$file_name);
            }
			
			if(file_exists($logodirpath.$file_name)){
                unlink($logodirpath.$file_name);
            }

            if($filetype == "thumb_image"){
                $thumb_image  =  null;
                $sqlquery     =  "UPDATE tblcategories SET thumb_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "medium_image"){
                $background_image  =  null;
                $sqlquery     =  "UPDATE tblcategories SET medium_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "background_image"){
                $background_image  =  null;
                $sqlquery     =  "UPDATE tblcategories SET background_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "banner_image"){
                $banner_image =  null;
                $sqlquery     =  "UPDATE tblcategories SET banner_image = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            } elseif($filetype == "category_logo"){
                $sqlquery     =  "UPDATE tblcategories SET category_logo = ''";
                $sqlquery     =  $sqlquery . " WHERE id = ".$id."";
                $result       =  $fpdo->customResult($sqlquery);
            }
            $action       =  1;
        }

        
        if ((int)$action == 1) {
            $_SESSION['categorystatus'] = "filedeleted";
            header("Location: category.php?id=".$id."&edit=1");
            exit;
        } else {
            $_SESSION['categorystatus'] = "invalid";
            header("Location: category.php?id=".$id."&edit=1");
            exit;
        }

    }
?>