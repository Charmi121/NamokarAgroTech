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
    /*
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: products-import-excel.php");
        exit;
    }
    unset($_SESSION['tokencode']);
    */
    
    $dirFolder    = UPLOADPATH;
    $targetFolder = UPLOADPATH."/excels/";

    $maxid = rand(100,999);

    echo $_FILES['excel_file']['type'];
    
    if(floatval($_FILES['excel_file']['size']) > 0)  {
       
      //Add the allowed mime-type files to an 'allowed' array
      $allowed = array('application/vnd.ms-excel', 'application/octet-stream', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

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
               //header("Location: products-import-excel.php");
               exit;
           }           
      } else {
          $action = 2;
          $_SESSION['productimportstatus'] = "invalid_file";
          //header("Location: products-import-excel.php");
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
    
    
    $i = 0;
    $action = $duplicate = 0;  
    foreach($sheetData as $sheet) {
        $i = $i+1;
        if((int)$i > 1){
            if(!empty($sheet['B']) && !empty($sheet['C']) && !empty($sheet['D'])) {
                
                $id                 =   (!empty($sheet['A'])) ? $DB->RemoveTags($sheet['A']) : ''; 
                $category_name      =   trim($sheet['B']);
                $category_id        =   array_search(strtolower($category_name), $categories_list);
                
                $sku                =   trim($sheet['C']);
                $product_name       =   trim($sheet['D']);
                
                $type_name          =   trim($sheet['E']);
                $type_id            =   array_search(strtolower($type_name), $types_list);
                
                $fabric_name        =   trim($sheet['F']);
                $fabric_id          =   array_search(strtolower($fabric_name), $fabrics_list);
                
                $color_name         =   trim($sheet['G']);
                $color_id           =   array_search(strtolower($color_name), $colors_list);
                
                $product_price      =   trim($sheet['H']);
                $discount_price     =   trim($sheet['I']);
                $net_price          =   (float)$product_price - (float)$discount_price;

                $max_order_quantity =   (!empty($sheet['J'])) ? trim($sheet['J']) : 10;
                
                $size_arr           =   array();
                $size_arr[1]        =   trim($sheet['K']);
                $size_arr[2]        =   trim($sheet['L']);
                $size_arr[3]        =   trim($sheet['M']);
                $size_arr[4]        =   trim($sheet['N']);
                $size_arr[5]        =   trim($sheet['O']);
                $size_arr[6]        =   trim($sheet['P']);
                $size_arr[7]        =   trim($sheet['Q']);
                $size_arr[8]        =   trim($sheet['R']);
                
                $image_file_name    =   trim($sheet['S']);
                
                $meta_title         =   $product_name;
                $meta_keyword       =   $product_name;
                $meta_description   =   $product_name;
                $description        =   '';
                
                $slug1              =   preg_replace('/[\']/', '', $product_name);
                $slug               =   preg_replace('/[^a-z0-9\s]/', '', strtolower($slug1));
                $seo_result         =   array();
                $seo_result         =   $DB->seoURLExist("tblproducts", $slug, 0);
                $seo_url            =   $seo_result['seo_url'];
                
                $status             =   707;
                $sort_order         =   0;
                $created            =   date("Y-m-d H:i:s", strtotime('now'));
                $modified           =   date("Y-m-d H:i:s", strtotime('now'));
                /*
                echo $i." - ";
                echo $category_id." - Category ID: ";
                echo $product_name." - SKU: ";
                echo $sku;
                echo "<br/>";
                */
                
                if (!empty($category_id) && !empty($product_name) && !empty($sku)) {
                    try {
                        //echo "Entry - Cat -".$category_id." AND ".$type_id." - ".$fabric_id." - ".$color_id."";
                        //echo "<br/>";
                         
                        $sqlquery = $fpdo->insertInto('tblproducts', array(
                                                 'meta_title' => $meta_title,
                                                 'meta_keyword' => $meta_keyword,
                                                 'meta_description' => $meta_description,
                                                 
                                                 'product_name' => $product_name,
                                                 'sku' => $sku,
                                                 'description' => $description,
                                                 'product_price' => $product_price,
                                                 'discount_price' => $discount_price,
                                                 'net_price' => $net_price,                                             
                                                 //'product_weight' => $product_weight,                                             
                                                 //'tags' => $tags,
                                                 'max_order_quantity' => $max_order_quantity,
                                                 
                                                 'type_id' => $type_id,
                                                 //'story_id' => $type_id,
                                                 'fabric_id' => $fabric_id,
                                                 'color_id' => $color_id,
                                                 
                                                 'seo_url' => $seo_url,
                                                 'status' => $status,
                                                 'sort_order' => $sort_order,
                                                 'created' => $created,
                                                 'modified' => $modified
                                             ));
                        $product_id = $sqlquery->execute();
                        
                        //Insert Product To Category
                        if(!empty($category_id)){
                            $sqlquery = $fpdo->insertInto('tblproduct_categories', array(
                                                     'product_id' => $product_id,
                                                     'category_id' => $category_id,
                                                     'created' => $created,
                                                     'modified' => $modified
                                                 ));
                            $sqlquery->execute();                            
                        }
                        
                        //Insert Variants in Product Variants
                        if(!empty($size_arr)){
                            foreach($size_arr as $size_id => $quantity) {
                                   
                               if(!empty($size_id)) {            
                                    $sqlquery = $fpdo->insertInto('tblproduct_variants', array(
                                                     'product_id' => $product_id,
                                                     'size_id' => $size_id,
                                                     'quantity' => $quantity,
                                                     'created' => $created,
                                                     'modified' => $modified
                                                 ));
                                    $sqlquery->execute();
                               }    
                            }
                        }
                        
                        //Insert Images
                        if(!empty($image_file_name))
                        {
                            //Generate All Sizes of Images
                            //$image_file_name
                            
                            $sqlquery = $fpdo->insertInto('tblproduct_images', array(
                                                            'product_id' => $product_id,
                                                            'mini_image' => trim($mini_image),
                                                            'thumb_image' => trim($thumb_image),
                                                            'medium_image' => trim($medium_image),
                                                            'big_image' => trim($big_image),
                                                            'show_as_main' => $show_as_main,
                                                            'created' => $created,
                                                            'modified' => $modified
                                                         ));
                            $sqlquery->execute();    
                        }
                        
                    } catch (Exception $e) {
                        $message = $e->getMessage();
                    }
                }
            }
        }
    }
    
    if ((int)$action == 1) {
        $_SESSION['productimportstatus'] = "update";
        header("Location: displayproduct.php");
        exit;
    } else {
        $_SESSION['productimportstatus'] = "failure";
        header("Location: displayproduct.php");
        exit;
    }
?>