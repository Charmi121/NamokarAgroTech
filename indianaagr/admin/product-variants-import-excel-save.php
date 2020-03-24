<?php
    set_time_limit(0);
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    $DB = new DBConfig();
    
    require_once ('plugins/phpexcel/Classes/PHPExcel.php');
    require_once ('plugins/phpexcel/Classes/PHPExcel/IOFactory.php');

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: product-variants-import-excel.php");
        exit;
    }
    unset($_SESSION['tokencode']);
    
    
    $dirFolder    = UPLOADPATH;
    $targetFolder = UPLOADPATH."/excels/";

    $maxid = rand(100,999);

    if(floatval($_FILES['excel_file']['size']) > 0) {
       
      //Add the allowed mime-type files to an 'allowed' array
      $allowed = array('application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

      //Check uploaded file type is in the above array (therefore valid)
      if(in_array($_FILES['excel_file']['type'], $allowed)) {
          
           //If filetypes allowed types are found, continue to upload
           $fileext         =   pathinfo($_FILES['excel_file']["name"], PATHINFO_EXTENSION);
           if($fileext == 'xls' || $fileext == 'xlsx'){
               $excel_file  =   $maxid."excel.".$fileext;
               //move_uploaded_file($_FILES['excel_file']["tmp_name"], $targetFolder.$excel_file);
               
               $copy = copy($_FILES['excel_file']['tmp_name'], $targetFolder.$excel_file);
           } else {
               $action = 2;
               $_SESSION['productimportstatus'] = "invalid_file";
               header("Location: product-variants-import-excel.php");
               exit;
           }
           
      } else {
          $action = 2;
          $_SESSION['productimportstatus'] = "invalid_file";
          header("Location: product-variants-import-excel.php");
          exit;
      }
    } 
 
    
    //define cachemethod
    $cacheMethod   = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
    $cacheSettings = array('memoryCacheSize' => '20MB');
    //set php excel settings
    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

    $arrayLabel = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T");
    
    //=== set object reader
    //$objectReader = PHPExcel_IOFactory::createReader('Excel2007');
    
    $fileType = PHPExcel_IOFactory::identify($targetFolder.$excel_file);
    $objectReader = PHPExcel_IOFactory::createReader($fileType);
    $objectReader->setReadDataOnly(true);
   
    //load excel file
    $objPHPExcel = $objectReader->load($targetFolder.$excel_file);
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    //$objWorksheet = $objPHPExcel->setActiveSheetIndexbyName('Sheet1');
    
    /*
    $starting = 1;
    $end      = 60;
    for($i=$starting; $i<=$end; $i++)
    {
       for($j=0;$j<count($arrayLabel);$j++)
       {
           //== display each cell value
           //echo $objWorksheet->getCell($arrayLabel[$j].$i)->getValue();
       }
    }
    */

    //or dump data
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    
    /*
    $category_id = (!empty($_POST['category_id'])) ? (int)$_POST['category_id'] : 0;
    
    //Categories List
    $categories_list = array();
    $sqlquery     = "SELECT tblcategories.id, tblcategories.category_name FROM tblcategories WHERE status = 707 AND parent_id = ".$category_id." ORDER BY id";
    $rscategories = $fpdo->customResult($sqlquery)->fetchAll();
    if(count($rscategories) > 0) {
        foreach ($rscategories as $rowcategory) {
            $categories_list[$rowcategory['id']] = strtolower(trim($rowcategory['category_name'])); 
        }
    }
    
    //Types List
    $types_list = array();
    $sqlquery = "SELECT tbltypes.id, tbltypes.type_name FROM tbltypes WHERE status = 707 AND category_id = ".$category_id." ORDER BY id";
    $rstypes = $fpdo->customResult($sqlquery)->fetchAll();
    if(count($rstypes) > 0) {
        foreach ($rstypes as $rowtype) {
            $types_list[$rowtype['id']] = strtolower(trim($rowtype['type_name'])); 
        }
    }
    
    //Fabrics List
    $fabrics_list = array();
    $sqlquery = "SELECT tblfabrics.id, tblfabrics.fabric_name FROM tblfabrics WHERE status = 707 AND category_id = ".$category_id." ORDER BY id";
    $rsfabrics = $fpdo->customResult($sqlquery)->fetchAll();
    if(count($rsfabrics) > 0) {
        foreach ($rsfabrics as $rowfabric) {
            $fabrics_list[$rowfabric['id']] = strtolower(trim($rowfabric['fabric_name'])); 
        }
    }
    
    //Colors List
    $colors_list = array();
    $sqlquery = "SELECT tblcolors.id, tblcolors.color_name FROM tblcolors WHERE status = 707 ORDER BY id";
    $rscolors = $fpdo->customResult($sqlquery)->fetchAll();
    if(count($rscolors) > 0) {
        foreach ($rscolors as $rowcolor) {
            $colors_list[$rowcolor['id']] = strtolower(trim($rowcolor['color_name'])); 
        }
    }
    */
    
    
    $i = 0;
    $action = 0;  
    foreach($sheetData as $sheet) {
        $i = $i+1;
        if((int)$i > 1){
            if(!empty($sheet['A']) && !empty($sheet['B']) && !empty($sheet['C'])) {
                
                $product_id         =   (!empty($sheet['A'])) ? $DB->RemoveTags($sheet['A']) : ''; 
                $product_name       =   trim($sheet['B']);
                $sku                =   trim($sheet['C']);
                
                $size_arr           =   array();
                $size_arr[0]        =   0;
                $size_arr[1]        =   trim($sheet['G']);
                $size_arr[2]        =   trim($sheet['H']);
                $size_arr[3]        =   trim($sheet['I']);
                $size_arr[4]        =   trim($sheet['J']);
                $size_arr[5]        =   trim($sheet['K']);
                $size_arr[6]        =   trim($sheet['L']);
                $size_arr[7]        =   trim($sheet['M']);
                $size_arr[8]        =   trim($sheet['N']);
                
                $modified           =   date("Y-m-d H:i:s", strtotime('now'));
                
                if (!empty($product_id) && !empty($product_name)) {
                    try {
                        
                        //Insert Variants in Product Variants
                        if(!empty($size_arr)> 0){
                            foreach($size_arr as $size_id => $quantity) {
                                   
                               if(!empty($size_id)) {            
                                   $sqlquery = $fpdo->update('tblproduct_variants')
                                                    ->set(array(
                                                           'size_id' => $size_id,
                                                           'quantity' => $quantity,
                                                           'modified' => $modified,
                                                       ));
                               
                                   $sqlquery->where('product_id = ? AND size_id = ?', $product_id, $size_id);
                                   $result = $sqlquery->execute(); 
                               }    
                            }
                        }
                        
                        $action = 1;
                        
                    } catch (Exception $e) {
                        $message = $e->getMessage();
                        echo $message;
                    }
                }
            }
        }
    }
    
    if ((int)$action == 1) {
        $_SESSION['productimportstatus'] = "update";
        header("Location: displayproductinventory.php");
        exit;
    } else {
        $_SESSION['productimportstatus'] = "invalid";
        header("Location: displayproductinventory.php");
        exit;
    }
?>