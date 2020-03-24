<?php 
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    $DB = new DBConfig();

    require_once ('plugins/phpexcel/Classes/PHPExcel.php');
    require_once ('plugins/phpexcel/Classes/PHPExcel/IOFactory.php');

    $objPHPExcel = new PHPExcel();
    //Set the active Excel worksheet to sheet 0 
    $objPHPExcel->setActiveSheetIndex(0);  
    //Initialise the Excel row number 
    $rowCount = 1;

    $category_id     =   (!empty($_REQUEST['category_id'])) ? (int)$_REQUEST['category_id']: 0;
    $product_name    =   (!empty($_REQUEST['product_name'])) ? $DB->cleanInput($_REQUEST['product_name']) : '';
    $sku             =   (!empty($_REQUEST['sku'])) ? $DB->cleanInput($_REQUEST['sku']) : '';

    //Start of printing column names as names of MySQL fields  
    //$column = 'A';

    // Get User Data
    $sqlquery  =  "SELECT tblproducts.id, tblproducts.product_name, tblproducts.sku, tblproducts.net_price, tblproducts.status, tbltypes.type_name, tblfabrics.fabric_name, tblcolors.color_name, tblproduct_images.mini_image FROM tblproducts";
    $sqlquery  =  $sqlquery . " LEFT JOIN tbltypes ON tbltypes.id = tblproducts.type_id";
    $sqlquery  =  $sqlquery . " LEFT JOIN tblfabrics ON tblfabrics.id = tblproducts.fabric_id";
    $sqlquery  =  $sqlquery . " LEFT JOIN tblcolors ON tblcolors.id = tblproducts.color_id";
    
    $sqlquery  =  $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";
    if(!empty($category_id)){
        $sqlquery = $sqlquery . " INNER JOIN (SELECT DISTINCT(tblproduct_categories.product_id) AS product_id, tblproduct_categories.category_id FROM tblproduct_categories INNER JOIN tblcategories ON tblproduct_categories.category_id = tblcategories.id WHERE tblcategories.id = ".$category_id." OR tblcategories.parent_id = ".$category_id." GROUP BY tblproduct_categories.product_id ) AS tblproduct_categories ON tblproduct_categories.product_id = tblproducts.id";                    
    }                    
    $sqlquery  =  $sqlquery . " WHERE tblproducts.id != 0 ";
    if(!empty($product_name)){
        $sqlquery = $sqlquery . " AND tblproducts.product_name LIKE '".$product_name."%'";
    }
    if(!empty($sku)){
        $sqlquery = $sqlquery . " AND tblproducts.sku LIKE '".$sku."%'";
    }
    //$sqlquery  = $sqlquery . " LIMIT 0, 10";
    $rsdata   = $fpdo->customResult($sqlquery)->fetchAll();
    if (count($rsdata) > 0) {    
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product ID');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Product Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'SKU');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Type');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Fabric');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Color');
        
        $sqlquery = $fpdo->from('tblsizes')
                         ->select(null)
                         ->select('tblsizes.id, tblsizes.size_name, tblsizes.status, tblsizes.sort_order')
                         ->where('tblsizes.status = :status', array(":status" => 707)); 
        $rssizes =  $sqlquery->fetchAll();
        if(!empty($rssizes)) {
            $i = 1;
            foreach($rssizes as $rowsize) {
                $objPHPExcel->getActiveSheet()->setCellValue(''.chr(70+$i).'1', $rowsize['size_name']);
                $i++;
            }
        }
        
        //$objPHPExcel->getActiveSheet()->setCellValue(''.chr(68+$i).'1', 'Status');
        
        
        //Start while loop to get data
        $rowCount = 2;
        $inicnt = 0;
        foreach($rsdata as $rowdata ){
            $inicnt++;
            //$objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount.'', $inicnt);
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount.'', $DB->RemoveTags($rowdata['id']));
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount.'', $DB->RemoveTags($rowdata['product_name']));
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount.'', $DB->RemoveTags($rowdata['sku']));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount.'', $DB->RemoveTags($rowdata['type_name']));
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount.'', $DB->RemoveTags($rowdata['fabric_name']));
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount.'', $DB->RemoveTags($rowdata['color_name']));
            
            $product_variants = array();
            $sqlquery = $fpdo->from('tblproduct_variants')
                             ->select(null)
                             ->select('tblproduct_variants.id, tblproduct_variants.product_id, tblproduct_variants.size_id, tblproduct_variants.quantity')
                             ->where('tblproduct_variants.product_id = :product_id', array(":product_id" => $rowdata['id']))
                             ->order('tblproduct_variants.size_id ASC'); 
            $rsproduct_variants = $sqlquery->fetchAll();
            if(!empty($rsproduct_variants)) {
                foreach($rsproduct_variants as $rowproduct_variant) {
                   array_push($product_variants, $rowproduct_variant);
                }
            }           
           
            if(!empty($rssizes)) {
               $i = 1;
               foreach($rssizes as $rowsize) {
                   $variant_info = array();
                   $variant_info = getProductVariant($rowdata['id'], $rowsize['id'], $product_variants);
                   
                   $objPHPExcel->getActiveSheet()->setCellValue(''.chr(70+$i).$rowCount, (int)$variant_info['quantity']);
                   $i++;
               }
            } 
            
            if((int)$DB->RemoveTags($rowdata['status']) == 707) { 
                $status = "Enable"; 
            } elseif ((int)$DB->RemoveTags($rowdata['status'] == 505)) { 
                $status = "Disable"; 
            }
            //$objPHPExcel->getActiveSheet()->setCellValue(''.chr(70+$i).$rowCount, $status);
            
            $rowCount++;
        }
        
    }
    //End of adding column names  

    //Redirect output to a client’s web browser (Excel5) 
    $filename = "products-export-excel" . date('Ymd') . ".xls";
    header('Content-Type: application/vnd.ms-excel'); 
    header('Content-Disposition: attachment;filename="'.$filename.'"'); 
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); 
    $objWriter->save('php://output');
?>
<?php
     function getProductVariant($product_id = 0, $size_id = 0, $product_variants = array()){
         foreach($product_variants as $product_variant){
             if(((int)$product_variant['product_id'] == (int)$product_id) && ((int)$product_variant['size_id'] == (int)$size_id)) {
                return $product_variant;
                break;  
             }
         }
         return null;
     }
?>