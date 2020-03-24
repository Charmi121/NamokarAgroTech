<?php
    set_time_limit(0);
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('plugins/php-image-magician/php_image_magician.php');
    $DB = new DBConfig();
    
    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: product.php");
        exit;
    }
    unset($_SESSION['tokencode']);
    

    $edit               =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $product_id         =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;

    $meta_title         =   (!empty($_POST['meta_title'])) ? htmlentities($_POST['meta_title'],ENT_QUOTES,"utf-8") : '';
    $meta_keyword       =   (!empty($_POST['meta_keyword'])) ? htmlentities($_POST['meta_keyword'],ENT_QUOTES,"utf-8") : '';
    $meta_description   =   (!empty($_POST['meta_description'])) ? htmlentities($_POST['meta_description'],ENT_QUOTES,"utf-8") : '';
    
    $horsepower   =   (!empty($_POST['horsepower'])) ? $_POST['horsepower'] : '';
    $machine_width   =   (!empty($_POST['machine_width'])) ? $_POST['machine_width'] : '';
    $hitch_types   =   (!empty($_POST['hitch_types'])) ? $_POST['hitch_types'] : '';

    //$category_id        =   (!empty($_POST['category_id'])) ? (int)$_POST['category_id'] : 0;
    $category_ids       =   (!empty($_POST['category_id'])) ? $_POST['category_id'] : array();

    $product_name       =   (!empty($_POST['product_name'])) ? $DB->RemoveTags($_POST['product_name']) : '';
    $sku                =   (!empty($_POST['sku'])) ? $DB->cleanInput($_POST['sku']) : '';
    $description        =   (!empty($_POST['description'])) ? htmlentities($_POST['description'],ENT_QUOTES,"utf-8") : '';
    $tech_description   =   (!empty($_POST['tech_description'])) ? htmlentities($_POST['tech_description'],ENT_QUOTES,"utf-8") : '';
    $advantage   		=   (!empty($_POST['advantage'])) ? htmlentities($_POST['advantage'],ENT_QUOTES,"utf-8") : '';
    $feature   			=   (!empty($_POST['feature'])) ? htmlentities($_POST['feature'],ENT_QUOTES,"utf-8") : '';
    $video_url          =   (!empty($_POST['video_url'])) ? $DB->cleanInput($_POST['video_url']) : '';

    $product_price      =   (!empty($_POST['product_price'])) ? floatval($_POST['product_price']) : 0;
    $discount_price     =   (!empty($_POST['discount_price'])) ? floatval($_POST['discount_price']) : 0;
    //$discount_rate      =   (!empty($_POST['discount_rate'])) ? floatval($_POST['discount_rate']):0;
    //$discount_price     =   0;
    $net_price          =   0;
    //$discount_price     =   round(($product_price * $discount_rate)/100, 2);
    $net_price          =   floatval($product_price - $discount_price);

    $product_weight     =   (!empty($_POST['product_weight'])) ? floatval($_POST['product_weight']) : 0;
    $max_order_quantity =   (!empty($_POST['max_order_quantity'])) ? floatval($_POST['max_order_quantity']) : 0;
    
    $is_new             =   (!empty($_POST['is_new'])) ? (int)$_POST['is_new'] : 0;
    $status             =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order         =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 1;

    $no_of_variants     =   (!empty($_POST['no_of_variants'])) ? (int)$_POST['no_of_variants'] : 0;
    $tags               =   (!empty($_POST['tags'])) ? $DB->RemoveTags($_POST['tags']) : '';
    
    $type_id            =   (!empty($_POST['type_id'])) ? $DB->RemoveTags($_POST['type_id']) : '';
    //$story_id           =   (!empty($_POST['story_id'])) ? $DB->RemoveTags($_POST['story_id']) : '';
    $fabric_id          =   (!empty($_POST['fabric_id'])) ? $DB->RemoveTags($_POST['fabric_id']) : '';
    $color_id           =   (!empty($_POST['color_id'])) ? $DB->RemoveTags($_POST['color_id']) : '';
    
    $now                =   date("Y-m-d H:i:s", strtotime('now'));
    $created            =   date("Y-m-d H:i:s", strtotime('now'));
    $modified           =   date("Y-m-d H:i:s", strtotime('now'));
    $maxid              =   rand();
    $action             =   0;
    $pdf_file           =   '';

    $slug1              =   preg_replace('/[\']/', '', $_POST['product_name']);
    $slug               =   preg_replace('/[^a-z0-9\s]/', '', strtolower($slug1));
    $seo_result         =   array();
    $seo_result         =   $DB->seoURLExist("tblproducts", $slug, $product_id);
    $seo_url            =   $seo_result['seo_url'];
    
    $dirpath            =   "../uploads/";
    if (!file_exists($dirpath)) {
        mkdir($dirpath, 0777, true);
    }
    $tempFolder         =   "../uploads/temp-images/";
    if (!file_exists($tempFolder)) {
        mkdir($tempFolder, 0777, true);
    }
    $targetFolder       =    "../uploads/products/";
    if (!file_exists($targetFolder)) {
        mkdir($targetFolder, 0777, true);
    }
	$pdfTargetFolder       =    "../uploads/product_brochure/";
    if (!file_exists($pdfTargetFolder)) {
        mkdir($pdfTargetFolder, 0777, true);
    }
    
    if(floatval($_FILES['pdf_file']['size']) > 0)  {
		//Check uploaded file type is in the above array (therefore valid)
		$fileext         =   pathinfo($_FILES['pdf_file']["name"], PATHINFO_EXTENSION);
		if($fileext == 'pdf') {
			$pdf_file  =   $maxid."pdf_file.".$fileext;
			$copy = copy($_FILES['pdf_file']['tmp_name'], $pdfTargetFolder.$pdf_file);
		} else {
			$_SESSION['productstatus'] =   "invalid_file";
			if($edit == 1){
				header("Location: product.php?id=".$product_id."&edit=1");
				exit;
			} else {
				header("Location: product.php");
				exit;
			}
		}
	}
	
	
    if (isset($edit) && !empty($product_name) ){
        if ((int)$edit == 0){
            try {                
                //Begin transaction
                $fpdo->beginTransaction();
                $sqlquery = $fpdo->insertInto('tblproducts', array(
                                                 'meta_title'       => $meta_title,
                                                 'meta_keyword'     => $meta_keyword,
                                                 'meta_description' => $meta_description,
                                                 
                                                 'product_name'     => $product_name,
                                                 'sku'              => $sku,
                                                 'description'      => $description,
                                                 'advantage'      	=> $advantage,
                                                 'feature'      	=> $feature,
                                                 'tech_description' => $tech_description,
                                                 'pdf_file'         => $pdf_file,
                                                 'video_url'        => $video_url,
                                                 'product_price'    => $product_price,
                                                 'discount_price'   => $discount_price,
                                                 'net_price'        => $net_price,                                             
                                                 'tags'             => $tags,
                                                 
                                                 'seo_url'          => $seo_url,
                                                 'is_new'           => $is_new,
                                                 'status'           => $status,
                                                 'sort_order'       => $sort_order,
                                                 'horsepower'       => $horsepower,
                                                 'machine_width'       => $machine_width,
                                                 'hitch_types'       => $hitch_types,
                                                 'created'          => $created,
                                                 'modified'         => $modified
                                             ));
                $product_id = $sqlquery->execute();
                
                //Insert Product To Category
                if(!empty($category_ids)){
                    foreach($category_ids AS $category_id) {
                        $sqlquery = $fpdo->insertInto('tblproduct_categories', array(
                                                 'product_id' => $product_id,
                                                 'category_id' => $category_id,
                                                 'created' => $created,
                                                 'modified' => $modified
                                             ));
                        $sqlquery->execute();
                    }
                }
                
                /*
                //Insert Product Type
                if(!empty($type_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_types', array(
                                             'product_id' => $product_id,
                                             'type_id' => $type_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                
                //Insert Product Story
                if(!empty($story_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_stories', array(
                                             'product_id' => $product_id,
                                             'story_id' => $story_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                
                //Insert Product Fabric
                if(!empty($fabric_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_fabrics', array(
                                             'product_id' => $product_id,
                                             'fabric_id' => $fabric_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                
                //Insert Product Color
                if(!empty($color_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_colors', array(
                                             'product_id' => $product_id,
                                             'color_id' => $color_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                */

                
                //Insert Images
                for($i = 1; $i <= 11; $i++) {
                    $big_image        =    '';
                    $medium_image     =    '';
                    $thumb_image      =    '';
                    $mini_image       =    '';
                    $show_as_main     =    ((int)$i == 1) ? 1 : 0;
                    $is_featured      =    ((int)$i == 2) ? 1 : 0;
                    $is_banner     	  =    ((int)$i == 3) ? 1 : 0;

                    if(!empty($_FILES['big_image_'.$i.'']) && floatval($_FILES['big_image_'.$i.'']['size']) > 0)
                    {
                        $maxid = rand();
                       
                        //Create subfolder according to sku
                        $fileext        =  pathinfo($_FILES['big_image_'.$i.'']["name"], PATHINFO_EXTENSION);
                        $filename       =  $DB->setFileName(strtolower(pathinfo($_FILES['big_image_'.$i.'']["name"], PATHINFO_FILENAME)));
                        
                        $temp_image     =  $filename.".".$fileext; 
                        $big_image      =  $filename."_".$maxid."_xl.".$fileext;
                        $medium_image   =  $filename."_".$maxid."_l.".$fileext;
                        $thumb_image    =  $filename."_".$maxid."_m2.".$fileext;
                        $mini_image     =  $filename."_".$maxid."_xs.".$fileext;
                        $alt_text       =  (!empty($_POST['alt_text_'.$i.''])) ? $_POST['alt_text_'.$i.''] : '';
                        move_uploaded_file($_FILES['big_image_'.$i.'']["tmp_name"], $tempFolder.$temp_image);

                        //Large Image
                        list($image_width, $image_height, $image_type, $image_attr) = getimagesize($tempFolder.$temp_image);
            
                        $thumbimage   = $filename."-".$maxid."_s.".$fileext;
                        
                        $magicianObj =  new imageLib($tempFolder.$temp_image);
                        if((int)$image_width <= 2000) {
                            copy($tempFolder.$temp_image, $targetFolder.$big_image);
                        } else {                
                            //Large Image
                            $magicianObj -> resizeImage(2000, 2000, 'landscape');
                            $magicianObj -> saveImage($targetFolder.$big_image, 90);
                        }

                        //Medium Image
                        //$magicianObj =  new imageLib($tempFolder.$temp_image);
                        $magicianObj -> resizeImage(700, 700, 'landscape');
                        $magicianObj -> saveImage($targetFolder.$medium_image, 90);

                        //Thumb Image
                        //$magicianObj =  new imageLib($tempFolder.$temp_image);
                        $magicianObj -> resizeImage(300, 300, 'landscape');
                        $magicianObj -> saveImage($targetFolder.$thumb_image, 90);

                        //Mini Image
                        //$magicianObj =  new imageLib($tempFolder.$temp_image);
                        $magicianObj -> resizeImage(80, 80, 'landscape');
                        $magicianObj -> saveImage($targetFolder.$mini_image, 90);

                        if(file_exists($tempFolder.$temp_image)){
                            unlink($tempFolder.$temp_image);
                        }

                        if(!empty($product_id) && !empty($big_image)){
                            $sqlquery = $fpdo->insertInto('tblproduct_images', array(
                                                            'product_id' => $product_id,
                                                            'mini_image' => trim($mini_image),
                                                            'thumb_image' => trim($thumb_image),
                                                            'medium_image' => trim($medium_image),
                                                            'big_image' => trim($big_image),
                                                            'show_as_main' => $show_as_main,
                                                            'is_featured' => $is_featured,
                                                            'is_banner' => $is_banner,
                                                            'alt_text' => $alt_text,
                                                            'created' => $created,
                                                            'modified' => $modified
                                                         ));
                            $sqlquery->execute();
                        }
                    } 
                }
                
                //Commit Transaction
                $fpdo->endTransaction();            
                $action = 1;
            
            } catch (Exception $e) {
                $message = $e->getMessage();
                //Rollback transaction
                $fpdo->cancelTransaction();
            }
        } else {
            try {                
                //Begin transaction
                $fpdo->beginTransaction();
                    
                $sqlquery = $fpdo->update('tblproducts')->set(array(
                                            'meta_title'       => $meta_title,
                                            'meta_keyword'     => $meta_keyword,
                                            'meta_description' => $meta_description,
                                            
                                            'product_name'     => $product_name,
                                            'sku'              => $sku,
                                            'description'      => $description,
                                            'advantage'		   => $advantage,
                                            'feature' 		   => $feature,
                                            'tech_description' => $tech_description,
                                            'video_url'        => $video_url,
                                            'product_price'    => $product_price,
                                            'discount_price'   => $discount_price,
                                            'net_price'        => $net_price,                                                  
                                            'tags'             => $tags,
                                            'seo_url'          => $seo_url,
                                            'is_new'          => $is_new,
                                            'status'           => $status,
                                            'sort_order'       => $sort_order,
                                             'horsepower'       => $horsepower,
                                             'machine_width'       => $machine_width,
                                             'hitch_types'       => $hitch_types,
                                            'modified'         => $modified
                                       ));
				if(!empty($pdf_file)){
					$sqlquery->set(array('pdf_file'	=>	$pdf_file));
				}
                $sqlquery->where('tblproducts.id = ?', $product_id);
                $sqlquery->execute();
                
                $sqlquery = $fpdo->deleteFrom('tblproduct_categories')
                                 ->where('product_id = :product_id', array(":product_id"  => $product_id));
                $sqlquery->execute();            

                //Insert Product To Category
                if(!empty($category_ids)){
                    foreach($category_ids AS $category_id) {
                        $sqlquery = $fpdo->insertInto('tblproduct_categories', array(
                                                 'product_id' => $product_id,
                                                 'category_id' => $category_id,
                                                 'created' => $created,
                                                 'modified' => $modified
                                             ));
                        $sqlquery->execute();
                    }
                }
                
                /*
                //Insert Product Type
                $sqlquery = $fpdo->deleteFrom('tblproduct_types')
                                 ->where('product_id = :product_id', array(":product_id"  => $product_id));
                $sqlquery->execute();
                
                if(!empty($type_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_types', array(
                                             'product_id' => $product_id,
                                             'type_id' => $type_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                
                //Insert Product Story
                $sqlquery = $fpdo->deleteFrom('tblproduct_stories')
                                 ->where('product_id = :product_id', array(":product_id"  => $product_id));
                $sqlquery->execute();
                
                if(!empty($story_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_stories', array(
                                             'product_id' => $product_id,
                                             'story_id' => $story_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                
                //Insert Product Fabric
                $sqlquery = $fpdo->deleteFrom('tblproduct_fabrics')
                                 ->where('product_id = :product_id', array(":product_id"  => $product_id));
                $sqlquery->execute();
                
                if(!empty($fabric_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_fabrics', array(
                                             'product_id' => $product_id,
                                             'fabric_id' => $fabric_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                
                //Insert Product Color
                $sqlquery = $fpdo->deleteFrom('tblproduct_colors')
                                 ->where('product_id = :product_id', array(":product_id"  => $product_id));
                $sqlquery->execute();
                
                if(!empty($color_id)) {
                    $sqlquery = $fpdo->insertInto('tblproduct_colors', array(
                                             'product_id' => $product_id,
                                             'color_id' => $color_id,
                                             'created' => $created,
                                             'modified' => $modified
                                         ));
                    $sqlquery->execute();    
                }
                */
                
                
                //Product Images
                $sqlquery = $fpdo->deleteFrom('tblproduct_images')
                                 ->where('product_id = :product_id', array(":product_id"  => $product_id));
                $sqlquery->execute();

                for($i = 1; $i <= 11; $i++) {
                        $big_image        =    null;
                        $medium_image     =    null;
                        $thumb_image      =    null;
                        $mini_image       =    null;
                        $show_as_main     =    ((int)$i == 1) ? 1 : 0;   
                        $is_featured      =    ((int)$i == 2) ? 1 : 0;
						$is_banner     	  =    ((int)$i == 3) ? 1 : 0;
                        if(!empty($_FILES['big_image_'.$i.'']) && floatval($_FILES['big_image_'.$i.'']['size']) > 0)
                        {
                            $maxid = rand();
                           
                            
                            //Create subfolder according to sku
                            $fileext        =  pathinfo($_FILES['big_image_'.$i.'']["name"], PATHINFO_EXTENSION);
                            $filename       =  $DB->setFileName(strtolower(pathinfo($_FILES['big_image_'.$i.'']["name"], PATHINFO_FILENAME)));
                            
                            $temp_image     =  $filename.".".$fileext; 
                            $big_image      =  $filename."_".$maxid."_xl.".$fileext;
                            $medium_image   =  $filename."_".$maxid."_l.".$fileext;
                            $thumb_image    =  $filename."_".$maxid."_m2.".$fileext;
                            $mini_image     =  $filename."_".$maxid."_xs.".$fileext;
							$alt_text       =  (!empty($_POST['alt_text_'.$i.''])) ? $_POST['alt_text_'.$i.''] : '';
                            move_uploaded_file($_FILES['big_image_'.$i.'']["tmp_name"], $tempFolder.$temp_image);

                            //Large Image
                            $magicianObj =  new imageLib($tempFolder.$temp_image);
                            $magicianObj -> resizeImage(2000, 2000, 'landscape');
                            $magicianObj -> saveImage($targetFolder.$big_image, 90);

                            //Medium Image
                            //$magicianObj =  new imageLib($tempFolder.$temp_image);
                            $magicianObj -> resizeImage(700, 700, 'landscape');
                            $magicianObj -> saveImage($targetFolder.$medium_image, 90);

                            //Thumb Image
                            //$magicianObj =  new imageLib($tempFolder.$temp_image);
                            $magicianObj -> resizeImage(300, 300, 'landscape');
                            $magicianObj -> saveImage($targetFolder.$thumb_image, 90);

                            //Mini Image
                            //$magicianObj =  new imageLib($tempFolder.$temp_image);
                            $magicianObj -> resizeImage(80, 80, 'landscape');
                            $magicianObj -> saveImage($targetFolder.$mini_image, 90);

                            if(file_exists($tempFolder.$temp_image)){
                                unlink($tempFolder.$temp_image);
                            }

                            if(!empty($product_id) && !empty($big_image)){
                                $sqlquery = $fpdo->insertInto('tblproduct_images')
                                                 ->values(array(
                                                                'product_id' => $product_id,
                                                                'mini_image' => trim($mini_image),
                                                                'thumb_image' => trim($thumb_image),
                                                                'medium_image' => trim($medium_image),
                                                                'big_image' => trim($big_image),
                                                                "show_as_main" => $show_as_main,
																'is_featured' => $is_featured,
																'is_banner' => $is_banner,
																'alt_text' => $alt_text,
                                                                'created' => $created,
                                                                'modified' => $modified
                                                             ));
                                $sqlquery->execute();
                            }
                        
                        } elseif (!empty($_POST['product_image_filenames_'.$i.''])) {
                            $filename = array();
                            $filename = explode(",", $_POST['product_image_filenames_'.$i.'']);
							$alt_text =  (!empty($_POST['alt_text_'.$i.''])) ? $_POST['alt_text_'.$i.''] : '';
                            $sqlquery = $fpdo->insertInto('tblproduct_images')
                                             ->values(array(
                                                            'product_id' => $product_id,
                                                            'mini_image' => trim($filename[0]),
                                                            'thumb_image' => trim($filename[1]),
                                                            'medium_image' => trim($filename[2]),
                                                            'big_image' => trim($filename[3]),
                                                            "show_as_main" => $show_as_main,
															'is_featured' => $is_featured,
                                                            'is_banner' => $is_banner,
                                                            'alt_text' => $alt_text,
                                                            'created' => $created,
                                                            'modified' => $modified
                                                         ));
                            $sqlquery->execute();
                        }  
                    }
                
                //Commit Transaction
                $fpdo->endTransaction();            
                
                $action = 2;
            
            } catch (Exception $e) {
                $message = $e->getMessage();
                //Rollback transaction
                $fpdo->cancelTransaction();
            }
        }
    }
    
    if ((int)$action == 1) {
        $_SESSION['productstatus'] =   "add";
        header("Location: displayproduct.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['productstatus'] =   "update";
        header("Location: product.php?id=".$product_id."&edit=1");
        exit;
    } else {
        $_SESSION['productstatus'] =   "invalid";
        header("Location: product.php");
        exit;
    } 
?>
