<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
require_once('../main.php');
$DB = new DBConfig();
 
//define('SITE_URL', $DB->siteURL());

// Define a destination
//Relative Path
$tempFolder = "../../uploads/tempnewsletter/";
$targetFolder = "../../uploads/newsletter/"; // Relative to the root

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile     = $_FILES['Filedata']['tmp_name'];
    $targetPath   = $targetFolder; 
    //$targetPath = SITE_URL . $targetFolder;
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
	
	// Validate the file type
	//$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
    $fileTypes = array('pdf'); // File extensions
    $fileParts['extension'] = strtolower(pathinfo($_FILES['Filedata']['name'], PATHINFO_EXTENSION));
	$fileParts['filename'] = strtolower(pathinfo($_FILES['Filedata']['name'], PATHINFO_FILENAME));
    
	if (in_array($fileParts['extension'],$fileTypes)) 
    {
		$maxid = rand();
    
        if(floatval($_FILES['Filedata']['size']) > 0)
        {
            $filename       =   $fileParts['filename'];
            $fileext        =   strtolower(pathinfo($_FILES['Filedata']["name"], PATHINFO_EXTENSION));
            $bigimage       =   $maxid.$filename.".".$fileext;
            move_uploaded_file($_FILES['Filedata']["tmp_name"], $targetFolder.$bigimage);
        }
        
        echo $bigimage;
	} else {
		echo 'Invalid file type.';
	}
}
?>