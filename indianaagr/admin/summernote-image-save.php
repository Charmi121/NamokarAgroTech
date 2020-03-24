<?php
    set_time_limit(0);
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    $DB = new DBConfig();

     $data         = array();
     $tempFolder   = UPLOADPATH.DS."temp-images".DS;
     $targetFolder = UPLOADPATH.DS."images".DS; // Relative to the root;


     if (!file_exists($targetFolder)) {
         mkdir($targetFolder);
     }

     if (!empty($_FILES)) {
         // Validate the file type
         $fileTypes = array('jpg','jpeg','gif','png'); // File extensions

         $fileParts['extension'] = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
         $fileParts['filename']  = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_FILENAME));

         if (in_array($fileParts['extension'],$fileTypes) && floatval($_FILES['file']['size']) > 0)
         {
             //Image Magician Code
             $maxid = rand(100000,999999);

             $filename       =   $DB->setFileName($fileParts['filename']);
             $fileext        =   strtolower(pathinfo($_FILES['file']["name"], PATHINFO_EXTENSION));
             $file_image     =   $filename."-".$maxid.".".$fileext;
             move_uploaded_file($_FILES['file']["tmp_name"], $targetFolder.$file_image);

             //$filepath = $DB->showImage(STORE_DOMAIN_NAME, "images", $file_image);
		     $filepath = DISPLAYPATH."images".DS.$file_image;
             //echo DISPLAYPATH.DS."images".DS.$file_image;
             echo $filepath;
	    }
     }
?>