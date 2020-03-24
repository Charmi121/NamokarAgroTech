<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    $DB = new DBConfig();
?>
<?php
    // Check if delete button active, start this
  if(!empty($_REQUEST['delete']))
  {
      $id                   =   (!empty($_REQUEST['id'])) ? (int)$_REQUEST['id'] : 0;
      $product_id           =   (!empty($_REQUEST['product_id'])) ? (int)$_REQUEST['product_id'] : 0;
      //$filename           =   (!empty($_REQUEST['filename'])) ? trim($_REQUEST['filename']) : null;
      $_REQUEST['filename'] =   (!empty($_REQUEST['filename'])) ? str_replace(", ", ",", $_REQUEST['filename']) : null;
      $filenames            =   (!empty($_REQUEST['filename'])) ? explode(",", $_REQUEST['filename']) : array();
      $foldername           =   (!empty($_REQUEST['foldername'])) ? trim($_REQUEST['foldername']) : null;
      $filetype             =   (!empty($_REQUEST['filetype'])) ? trim($_REQUEST['filetype']) : null;
      $action      =  0;

     $dirpath       =    "../uploads/products/";


     if(!empty($filenames) && $foldername){
        foreach ($filenames as $filename) {
            if(file_exists($dirpath."/".$foldername."/".$filename)){
                unlink($dirpath."/".$foldername."/".$filename);
            }
        }

        //if($filetype == "thumb_image"){
            $sqlquery  =  "DELETE FROM tblproduct_images WHERE tblproduct_images.id = ".$id." AND tblproduct_images.product_id = ".$product_id."";
            $result    =  $DB->deletedata($sqlquery);  
        //} 

        $action       =  1;
    }

    if ((int)$action == 1) {
        $_SESSION['productstatus'] = "filedeleted";
        header("Location: product.php?id=".$product_id."&edit=1");
        exit;
    }
    else
    {
        $_SESSION['productstatus'] = "invalid";
        header("Location: product.php?id=".$product_id."&edit=1");
        exit;
    }

  }
?>
<?php $DB -> close(); ?>