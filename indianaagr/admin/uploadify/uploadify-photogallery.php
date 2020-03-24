<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/
require_once('../php-image-magician/php_image_magician.php');
require_once('../main.php');
$DB = new DBConfig();

//define('SITE_URL', $DB->siteURL());

// Define a destination
//Relative Path


$tempFolder   = "../../uploads/temp-images/";
$targetFolder = "../../uploads/photo-galleries/"; // Relative to the root
$verifyToken = md5('unique_salt' . $_POST['timestamp']);

 $dirpath    =    "../../uploads/photo-galleries/";
  if (!file_exists($dirpath)) {
      mkdir($dirpath);
  }

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
    $tempFile     = $_FILES['Filedata']['tmp_name'];
    $targetPath   = $targetFolder;
    //$targetPath = SITE_URL . $targetFolder;
    //$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

    // Validate the file type
    $fileTypes = array('jpg','jpeg','gif','png'); // File extensions
    //$fileTypes = array('png'); // File extensions
    $fileParts['extension'] = strtolower(pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION));
    $fileParts['filename'] = strtolower(pathinfo($_FILES['Filedata']['name'], PATHINFO_FILENAME));

    if (in_array($fileParts['extension'],$fileTypes))
    {
        //Image Magician Code
        $maxid = rand();

        if(floatval($_FILES['Filedata']['size']) > 0)
        {
            $filename       =   $fileParts['filename'];
            $fileext        =   strtolower(pathinfo($_FILES['Filedata']["name"], PATHINFO_EXTENSION));
            $tempimage      =   $maxid.$filename.".".$fileext;
            move_uploaded_file($_FILES['Filedata']["tmp_name"], $tempFolder.$tempimage);

            $big_image    =  $maxid."_xl.".$fileext;
            //$medium_image =  $maxid."_l.".$fileext;
            $thumb_image  =  $maxid."_m2.".$fileext;
            //$mini_image   =  $maxid."_xs.".$fileext;


            //Large Image
            $magicianObj =  new imageLib('../../uploads/temp-images/'.$tempimage);
            $magicianObj -> resizeImage(1200, 1200, 'auto');
            $magicianObj -> saveImage($targetFolder.$big_image, 90);

            //Medium Image
            $magicianObj =  new imageLib('../../uploads/temp-images/'.$tempimage);
            $magicianObj -> resizeImage(200, 200, 'auto');
            $magicianObj -> saveImage($targetFolder.$thumb_image, 80);

            /*
            //Mini Image
            $magicianObj =  new imageLib('../../uploads/temp-images/'.$tempimage);
            $magicianObj -> resizeImage(80, 80, 'auto');
            $magicianObj -> saveImage($targetFolder.$mini_image, 100);
            */

            if(file_exists('../../uploads/temp-images/'.$filename)){
            unlink('../../uploads/temp-images/'.$filename);
            }
        }

        echo $thumb_image.",".$big_image;
    } else {
        echo 'Invalid file type.';
    }
}
?>