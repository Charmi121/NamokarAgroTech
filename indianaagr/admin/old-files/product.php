<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    $DB = new DBConfig();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <meta name="keywords" content="Admin Panel" />
    <meta name="description" content="Admin Panel" />

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/media-queries.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">


  </head>
  <body>
    <header>
        <?php require_once("header.php") ?>
    </header>
    <div class="container">
      <h3>Product</h3>
      <div class="col-md-12"><div class="blank-border"></div></div>
      <?php if(!empty($_SESSION['productstatus']) &&  $_SESSION['productstatus']=="invalid" ) { ?>
          <div class="alert alert-danger" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Invalid!</h4>
              <?php echo $errorlist['product'][$_SESSION['productstatus']]; ?>
          </div>
          <div class="clearfix"></div>
      <?php unset($_SESSION['productstatus']);
           } elseif(!empty($_SESSION['productstatus']) &&  $_SESSION['productstatus']!="invalid") {
      ?>
          <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Success!</h4>
              <?php echo $errorlist['product'][$_SESSION['productstatus']]; ?>
          </div>
          <div class="clearfix"></div>
      <?php unset($_SESSION['productstatus']); } ?>

      <div class="clearfix"></div>
      <div class="middlesection margin-top20">

      <?php
          if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1)
          {
              $edit = (int)$_GET['edit'];
              $id = (int)$_GET['id'];

              $sqlquery = $fpdo->from("tblproducts")
                               ->where("tblproducts.id = :id", array(":id" => $id));
              $rsproducts = $sqlquery->fetchAll();
              if (count($rsproducts)>0) {
                foreach($rsproducts as $rowproduct){
                      $meta_title          =   html_entity_decode($rowproduct['meta_title'],ENT_QUOTES,"utf-8");
                      $meta_keyword        =   html_entity_decode($rowproduct['meta_keyword'],ENT_QUOTES,"utf-8");
                      $meta_description    =   html_entity_decode($rowproduct['meta_description'],ENT_QUOTES,"utf-8");
                      //$category_id         =   (int)$rowproduct['category_id'];
                      $selectedcat         =   array(0);
                      //$selectedcities      =   array(0);
                      $product_name        =   trim($rowproduct['product_name']);
                      
                      $product_price       =   trim($rowproduct['product_price']);
                      $discount_price      =   trim($rowproduct['discount_price']);
                      $net_price           =   trim($rowproduct['net_price']);
                      //$quantity            =   trim($rowproduct['quantity']);
                      $product_weight      =   trim($rowproduct['product_weight']);
                      $max_order_quantity  =   trim($rowproduct['max_order_quantity']);  
                      
                      $type_id             =   (int)$rowproduct['type_id'];
                      $fabric_id           =   (int)$rowproduct['fabric_id'];
                      $color_id            =   (int)$rowproduct['color_id'];
                      
                      $seo_url             =   trim($rowproduct['seo_url']);
                      $sku                 =   trim($rowproduct['sku']);
                      $description         =   html_entity_decode($rowproduct['description'],ENT_QUOTES,"utf-8");
                      
                      $tags                =   trim($rowproduct['tags']);

                      $sort_order          =   (int)$rowproduct['sort_order'];
                      $status              =   (int)$rowproduct['status'];
                      /*
                      $mini_image_1        =   trim($rowproduct['mini_image_1']);
                      $thumb_image_1       =   trim($rowproduct['thumb_image_1']);
                      $medium_image_1      =   trim($rowproduct['medium_image_1']);
                      $big_image_1         =   trim($rowproduct['big_image_1']);

                      $mini_image_2        =   trim($rowproduct['mini_image_2']);
                      $thumb_image_2       =   trim($rowproduct['thumb_image_2']);
                      $medium_image_2      =   trim($rowproduct['medium_image_2']);
                      $big_image_2         =   trim($rowproduct['big_image_2']);

                      $mini_image_3        =   trim($rowproduct['mini_image_3']);
                      $thumb_image_3       =   trim($rowproduct['thumb_image_3']);
                      $medium_image_3      =   trim($rowproduct['medium_image_3']);
                      $big_image_3         =   trim($rowproduct['big_image_3']);
                      
                      $mini_image_4        =   trim($rowproduct['mini_image_4']);
                      $thumb_image_4       =   trim($rowproduct['thumb_image_4']);
                      $medium_image_4      =   trim($rowproduct['medium_image_4']);
                      $big_image_4         =   trim($rowproduct['big_image_4']);
                      
                      $mini_image_5        =   trim($rowproduct['mini_image_5']);
                      $thumb_image_5       =   trim($rowproduct['thumb_image_5']);
                      $medium_image_5      =   trim($rowproduct['medium_image_5']);
                      $big_image_5         =   trim($rowproduct['big_image_5']);
                      */
                      $foldername          =   "products";    
                }
              }
          } else {
              $edit                =   0;
              $id                  =   0;
              $meta_title          =   null;
              $meta_keyword        =   null;
              $meta_description    =   null;
              $selectedcat         =   array(0);              
              $product_name        =   null;
              $seo_url             =   null;
              $sku                 =   null;
              $description         =   null;              
              $product_price       =   null;
              $discount_price      =   null;
              $net_price           =   null;              
              $product_weight      =   null;
              $max_order_quantity  =   0;
              $type_id             =   0;
              $fabric_id           =   0;
              $color_id            =   0;   
              $tags                =   null;
              $sort_order          =   0;
              $status              =   0;
          }
          
          $sqlquery = $fpdo->from("tblproduct_variants")
                           ->where("tblproduct_variants.product_id = :product_id", array(":product_id" => $id));
          $rsproduct_variants = $sqlquery->fetchAll();
          
          $_SESSION['tokencode']  =   $DB->generateToken();
      ?>
          <div class="table-responsive">
              <form name="addform" id="addform" method="post" action="productsave.php"  enctype="multipart/form-data" target="_self">
                 <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                 <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                 <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                  <table class="table table-bordered table-striped table-condensed">
                     <tbody>
                        <tr>
                            <td class="col-md-2"><div class="text-right">Category Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-12">
                                <?php
                                   $selectedcat = array();
                                   $sqlquery = $fpdo->from("tblproduct_categories")
                                                    ->where("tblproduct_categories.product_id = :product_id", array(":product_id" => $id));
                                   $rsproduct_categories = $sqlquery->fetchAll();
                                   if (count($rsproduct_categories)>0) {
                                        foreach($rsproduct_categories as $rowproduct_category){
                                            $selectedcat[] = $rowproduct_category['category_id'];
                                        }
                                   }
                                ?>

                              <select id="category_id" name="category_id[]" class="category" style="width:100%;" placeholder="Select Category" >
                                <option value="0">Select Category</option>
                                <?php
                                    $level = 0;
                                    
                                    $sqlquery = $fpdo->from("tblcategories")
                                                     ->select(null)
                                                     ->select("tblcategories.id, tblcategories.category_name")
                                                     ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => 0, ":status" => 707))
                                                     ->order("tblcategories.category_name");
                                    $rsparentcategories = $sqlquery->fetchAll();
                                    if (count($rsparentcategories)>0) {
                                        foreach($rsparentcategories as $rowparentcategory){
                                                $level = 1;
                                ?>
                                <!--<option value="<?php //echo $rowparentcat['id'];?>" <?php //if((int)$rowparentcat['id'] == $category_id){ echo "selected=\"selected\""; } ;?>><?php echo $rowparentcategory['category_name'];?> </option>-->
                                <optgroup label="<?php echo $rowparentcategory['category_name'];?>">
                                <?php /* <option value="<?php echo $rowparentcategory['id'];?>" <?php if(in_array($rowparentcategory['id'], $selectedcat)) { echo "selected=\"selected\""; } ?>><?php echo $rowparentcategory['category_name'];?> </option> */ ?>
                                <?php display_children($rowparentcategory['id'], $level); ?>
                                </optgroup>
                                <?php
                                         }
                                     }
                                ?>
                                <?php
                                  // $parent_cat_id is the parent id of the children we want to see
                                  // $level is increased when we go deeper into the tree, used to display a nice indented tree
                                  function display_children($parent_cat_id, $level) {
                                      global $fpdo;
                                      //global $category_id;
                                      global $selectedcat;
                                      $sqlquery = $fpdo->from("tblcategories")
                                                       ->select(null)
                                                       ->select("tblcategories.id, tblcategories.category_name")
                                                       ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => $parent_cat_id, ":status" => 707))
                                                       ->order("tblcategories.category_name");
                                      $rssubcategories = $sqlquery->fetchAll();
                                      if (count($rssubcategories)>0) {
                                          foreach($rssubcategories as $rowsubcategory){
                                ?>
                                <!--<option value="<?php //echo $rowsubcategory['id'];?>" <?php //if((int)$rowsubcategory['id'] == $category_id){ echo "selected=\"selected\""; } ;?>><?php  echo str_repeat('- ',$level).$rowsubcategory['category_name'];?> </option>-->
                                <option value="<?php echo $rowsubcategory['id'];?>" <?php if(in_array( $rowsubcategory['id'],$selectedcat )){ echo "selected=\"selected\""; } ;?>><?php  echo str_repeat('- ',$level).$rowsubcategory['category_name'];?> </option>
                                <?php
                                                display_children($rowsubcategory['id'], $level+1);
                                           }
                                      }
                                  }
                                ?>
                            </select>
                            </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2"><div class="text-right">Product Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-12">
                                    <input type="text" name="product_name" id="product_name" value="<?php echo $product_name; ?>" maxlength="150" class="required form-control" title="Please enter product name"/>
                                </div>
                            </td>
                        </tr>
                         <tr>
                            <td class="col-md-2"><div class="text-right">SEO URL<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-12">
                                    <input type="text" name="seo_url" id="seo_url" value="<?php echo $seo_url; ?>" maxlength="150" class="form-control"  size="50"  title="Please enter SEO URL" readonly="readonly" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2"><div class="text-right">SKU<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-8">
                                    <input type="text" name="sku" id="sku"  value="<?php echo $sku; ?>" maxlength="20" class="required form-control" title="Please enter SKU"/>
                                    <div id="skuinfo"></div>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td><div class="text-right">Description</div></td>
                            <td>
                                <div class="col-md-12">
                                    <textarea cols="50" rows="2" name="description" id="description" placeholder="Please enter description" class="form-control inbox-editor inbox-wysihtml5"><?php echo $description; ?></textarea>
                                </div>
                            </td>
                        </tr>
                        <?php /* if($edit == 0 || ($edit == 1 && count($rsproduct_variants) == 0)) { */ ?>
                        <tr>
                            <td><div class="text-right">Product Price (in $)<span class="text-danger">*</span></div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="text" name="product_price" id="product_price"  value="<?php echo $product_price; ?>" maxlength="20" class="required form-control" title="Please enter product price"  onKeyUp="allow_numeric(this);"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="text-right">Discount Price (in $)</div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="text" name="discount_price" id="discount_price"  value="<?php echo $discount_price; ?>" maxlength="20" class="form-control" title="Please enter discount price" onKeyUp="allow_numeric(this);"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="text-right">Net Price (in $)</div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="text" name="net_price" id="net_price"  value="<?php echo $net_price; ?>" maxlength="20" class="form-control"  title="Please enter net price" onKeyUp="allow_numeric(this);" readonly="readonly"/>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="text-right">Product Weight (gm)<span class="text-danger">*</span></div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="text" name="product_weight" id="product_weight"  value="<?php echo $product_weight; ?>" maxlength="20" class="form-control"  title="Please enter product weight" onKeyUp="allow_numeric(this);"/>
                                </div>
                            </td>
                        </tr>
                        <!--<tr>
                            <td><div class="text-right">Quantity<span class="text-danger">*</span></div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="text" name="quantity" id="quantity"  value="<?php //echo $quantity; ?>" maxlength="20" class="form-control required"  title="Please enter quantity" onKeyUp="allow_numeric(this);"/>
                                </div>
                            </td>
                        </tr> -->
                        <?php /* } */ ?>
                        
                        <tr>
                            <td><div class="text-right">Max Order Quantity<span class="text-danger">*</span></div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="text" name="max_order_quantity" id="max_order_quantity"  value="<?php echo $max_order_quantity; ?>" maxlength="20" class="form-control"  title="Please enter max order quantity" onKeyUp="allow_numeric(this);"/>
                                </div>
                            </td>
                        </tr>
                        
                        
                        <!-- <tr>
                            <td><div class="text-right">Discount Rate (in %)</div></td>
                            <td> <input type="text" name="discount_rate" id="discount_rate" value="<?php //echo $discount_rate;?>" maxlength="50" class="control" onkeyup="allow_numeric(this);"/></td>
                        </tr>
                        <tr>
                            <td><div class="text-right">Min Shipping Days<span class="text-danger">*</span></div></td>
                            <td><input type="text" name="min_shipping_days" id="min_shipping_days" value="<?php //echo $min_shipping_days; ?>" maxlength="10" class="required control" onkeyup="allow_numeric(this);" /></td>
                        </tr>   -->
                        <!--<tr>
                            <td><div class="text-right">Min Shipping Days (Out of Stock)<span class="text-danger">*</span></div></td>
                            <td><input type="text" name="min_shipping_days_outofstock" id="min_shipping_days_outofstock" value="<?php //echo $min_shipping_days_outofstock; ?>" maxlength="10" class="required control" onkeyup="allow_numeric(this);" /></td>
                        </tr> -->
                     
                        
                      <?php /* if(count($rsproduct_variants) == 0) { ?>  
                        <tr>
                            <td><div class="text-right">Variants</div></td>
                            <td>
                                <div class="col-md-12">
                                    <div class="checkbox" style="margin-top:0px;">
                                         <label>
                                             <input type="checkbox" name="product_multiple_options" id="product_multiple_options" tabindex="14" value="1" style="margin-top:15px;" /><span class="checkbox"></span>&nbsp; This product has multiple options <span class="text-muted"> <span class="font400-italic">e.g. Multiple sizes and/or colors</span></span>
                                         </label> 
                                     </div>
                                </div>
                            </td>
                        </tr>
                        <?php } */ ?>
                        
                        <tr>
                             <td><div class="text-right">Variants / Options</div></td>
                             <td>
                                 <div class="col-md-12 col-sm-12 col-xs-12 arrow-indication">
                                     <div class="row">
                                         <div class="col-md-12">
                                             <table id="tblproduct-variants" class="table table-bordered">
                                                 <thead>
                                                     <tr class="active">
                                                         <th class="col-md-2"><span>Sr. No.</span></th>
                                                         <th class="col-md-3"><span>Size Name</span></th>
                                                         <th class="col-md-5"><span>Quantity</span></th>
                                                     </tr>
                                                 </thead>
                                                 <tbody> 
                                                     <?php
                                                         $j = 0;
                                                         $sqlquery = $fpdo->from("tblsizes")
                                                                          ->where("tblsizes.status = :status", array(":status" => 707));
                                                         $rssizes = $sqlquery->fetchAll();
                                                         if (count($rssizes)>0) {
                                                              foreach($rssizes as $rowsize){
                                                              $j++;
                                                     ?>  
                                                         <?php 
                                                            $product_variants = array(); 
                                                            $product_variants = variantSearch($rsproduct_variants, "size_id", $rowsize['id']); 
                                                            if(!empty($product_variants)) {
                                                         ?>
                                                             <?php foreach($product_variants as $product_variant) { ?>
                                                             <tr>
                                                                 <td>
                                                                     <input type="hidden" id="product_variant_id_<?php echo $j; ?>" name="product_variant_id_<?php echo $j; ?>" value="<?php echo $product_variant['id']; ?>" />
                                                                     <label><?php echo $j; ?></label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="hidden" id="size_id_<?php echo $j; ?>" name="size_id_<?php echo $j; ?>" value="<?php echo $product_variant['size_id']; ?>" />
                                                                     <label><?php echo $rowsize['size_name']; ?></label>
                                                                 </td>
                                                                 <td><input type="text" id="quantity_<?php echo $j; ?>" name="quantity_<?php echo $j; ?>" value="<?php echo $product_variant['quantity']; ?>" class="form-control" onkeyup="allow_numeric(this)" /></td>
                                                             </tr>
                                                             <?php } ?>
                                                         <?php } else { ?>
                                                             <tr>
                                                                 <td><input type="hidden" id="product_variant_id_<?php echo $j; ?>" name="product_variant_id_<?php echo $j; ?>" value="0" />
                                                                     <label><?php echo $j; ?></label>
                                                                 </td>
                                                                 <td>
                                                                     <input type="hidden" id="size_id_<?php echo $j; ?>" name="size_id_<?php echo $j; ?>" value="<?php echo $rowsize['id']; ?>" />
                                                                     <label><?php echo $rowsize['size_name']; ?></label>
                                                                 </td>
                                                                 <td><input type="text" id="quantity_<?php echo $j; ?>" name="quantity_<?php echo $j; ?>" value="0" class="form-control" onkeyup="allow_numeric(this)" /></td>
                                                             </tr>
                                                         <?php } ?>
                                                     <?php 
                                                              }
                                                         } 
                                                     ?>
                                                 </tbody>
                                                 <tfoot>
                                                    <tr>
                                                        <td colspan="5">
                                                            <input type="hidden" name="no_of_variants" id="no_of_variants" value="<?php echo $j; ?>" />
                                                             <?php
                                                                function variantSearch($variantArray, $key, $value)
                                                                {
                                                                    $variant_results = array();

                                                                    if (is_array($variantArray)) {
                                                                        if (isset($variantArray[$key]) && $variantArray[$key] == $value) {
                                                                            $variant_results[] = $variantArray;
                                                                        }

                                                                        foreach ($variantArray as $variantSubArray) {
                                                                            $variant_results = array_merge($variant_results, variantSearch($variantSubArray, $key, $value));
                                                                        }
                                                                    }

                                                                    return $variant_results;
                                                                }
                                                             ?>
                                                         </td>
                                                    </tr>
                                                 </tfoot>
                                             </table>
                                         </div>
                                     </div>
                                 </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-2"><div class="text-right">Type Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <?php
                                   $selectedtype = array();
                                   $sqlquery = $fpdo->from("tblproduct_types")
                                                    ->where("tblproduct_types.product_id = :product_id", array(":product_id" => $id));
                                   $rsproduct_types = $sqlquery->fetchAll();
                                   if (count($rsproduct_types)>0) {
                                        foreach($rsproduct_types as $rowproduct_type){
                                            $selectedtype[] = $rowproduct_type['type_id'];
                                        }
                                   }
                                ?>
                               <select id="type_id" name="type_id" class="type_id select2 col-md-6" placeholder="Select Type">
                                <option value="0">Select Type</option>
                                <?php
                                    $sqlquery = $fpdo->from("tbltypes")
                                                     ->select(null)
                                                     ->select("tbltypes.id, tbltypes.type_name")
                                                     ->where("tbltypes.category_id IN (:category_id) AND tbltypes.status = :status", array(":category_id" => implode(",", $selectedcat), ":status" => 707))
                                                     ->order("tbltypes.type_name");
                                    $rstypes = $sqlquery->fetchAll();
                                    if (count($rstypes)>0) {
                                        foreach($rstypes as $rowtype){
                                ?>
                                <option value="<?php echo $rowtype['id'];?>" <?php if(in_array($rowtype['id'], $selectedtype)) { echo "selected=\"selected\""; } ?>><?php echo $rowtype['type_name'];?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                            </td>
                        </tr>
                        <?php
                            /*
                        <tr>
                            <td class="col-md-2"><div class="text-right">Story Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                 <?php
                                   $selectedstory = array();
                                   $sqlquery = $fpdo->from("tblproduct_stories")
                                                    ->where("tblproduct_stories.product_id = :product_id", array(":product_id" => $id));
                                   $rsproduct_stories = $sqlquery->fetchAll();
                                   if (count($rsproduct_stories)>0) {
                                        foreach($rsproduct_stories as $rowproduct_story){
                                            $selectedstory[] = $rowproduct_story['story_id'];
                                        }
                                   }
                                ?>

                                <select id="story_id" name="story_id" class="story_id select2 col-md-6" placeholder="Select Story">
                                <option value="0">Select Story</option>
                                <?php
                                    $sqlquery = $fpdo->from("tblstories")
                                                     ->select(null)
                                                     ->select("tblstories.id, tblstories.story_name")
                                                     ->where("tblstories.status = :status", array(":status" => 707))
                                                     ->order("tblstories.story_name");
                                    $rsstories = $sqlquery->fetchAll();
                                    if (count($rsstories)>0) {
                                        foreach($rsstories as $rowstory){
                                ?>
                                <option value="<?php echo $rowstory['id'];?>" <?php if(in_array($rowstory['id'], $selectedstory)) { echo "selected=\"selected\""; } ?>><?php echo $rowstory['story_name'];?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                            </td>
                        </tr>
                            */
                        ?>
                        
                        <tr>
                            <td class="col-md-2"><div class="text-right">Fabric Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <?php
                                   $selectedfabric = array();
                                   $sqlquery = $fpdo->from("tblproduct_fabrics")
                                                    ->where("tblproduct_fabrics.product_id = :product_id", array(":product_id" => $id));
                                   $rsproduct_fabrics = $sqlquery->fetchAll();
                                   if (count($rsproduct_fabrics)>0) {
                                        foreach($rsproduct_fabrics as $rowproduct_fabric){
                                            $selectedfabric[] = $rowproduct_fabric['fabric_id'];
                                        }
                                   }
                                ?>
                                <select id="fabric_id" name="fabric_id" class="fabric_id select2 col-md-6" placeholder="Select Type">
                                <option value="0">Select Fabric</option>
                                <?php
                                    $sqlquery = $fpdo->from("tblfabrics")
                                                     ->select(null)
                                                     ->select("tblfabrics.id, tblfabrics.fabric_name")
                                                     ->where("tblfabrics.status = :status", array(":status" => 707))
                                                     ->order("tblfabrics.fabric_name");
                                    $rsfabrics = $sqlquery->fetchAll();
                                    if (count($rsfabrics)>0) {
                                        foreach($rsfabrics as $rowfabric){
                                ?>
                                <option value="<?php echo $rowfabric['id'];?>" <?php if(in_array($rowfabric['id'], $selectedfabric)) { echo "selected=\"selected\""; } ?>><?php echo $rowfabric['fabric_name'];?></option>
                                <?php
                                        }
                                    }
                                ?>
                            </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="col-md-2"><div class="text-right">Color Name<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                 <div>
                                 <?php
                                   $selectedcolor = array();
                                   $sqlquery = $fpdo->from("tblproduct_colors")
                                                    ->where("tblproduct_colors.product_id = :product_id", array(":product_id" => $id));
                                   $rsproduct_colors = $sqlquery->fetchAll();
                                   if (count($rsproduct_colors)>0) {
                                        foreach($rsproduct_colors as $rowproduct_color){
                                            $selectedcolor[] = $rowproduct_color['color_id'];
                                        }
                                   }
                                ?>

                              <select id="color_id" name="color_id" class="color_id select2 col-md-6" placeholder="Select Color">
                                <option value="0">Select Color</option>
                                <?php
                                    $sqlquery = $fpdo->from("tblcolors")
                                                     ->select(null)
                                                     ->select("tblcolors.id, tblcolors.color_name")
                                                     ->where("tblcolors.status = :status", array(":status" => 707))
                                                     ->order("tblcolors.color_name");
                                    $rscolors = $sqlquery->fetchAll();
                                    if (count($rscolors)>0) {
                                        foreach($rscolors as $rowcolor){
                                ?>
                                <option value="<?php echo $rowcolor['id'];?>" <?php if(in_array($rowcolor['id'], $selectedcolor)) { echo "selected=\"selected\""; } ?>><?php echo $rowcolor['color_name'];?></option>
                                <?php
                                        }
                                    }
                                ?>
                               </select>
                            </td>
                        </tr>
                        
                        <?php if($edit == 0){ ?>
                        <?php if(!empty($thumb_image_1) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$thumb_image_1) == 1){ ?>
                        <tr>
                            <td><div class="text-right">Previously Uploaded Image 1</div></td>
                            <td><img src="<?php echo DISPLAY_PATH."/products/".$thumb_image_1; ?>" /></td>
                        </tr>
                        <tr>
                            <td><div class="text-right">&nbsp;</div></td>
                            <td>
                                <?php /*<a href="<?php echo "../uploads/products/".$thumb_image_1; ?>" download="<?php echo $thumb_image_1; ?>" class="btn btn-mini btn-info">Download File</a>*/ ?>
                                &nbsp; <a href="deleteproductfile.php?id=<?php echo $id;?>&filename=<?php echo $mini_image_1.",".$thumb_image_1.",".$medium_image_1.",".$big_image_1.""; ?>&filetype=thumb_image_1&foldername=<?php echo $foldername; ?>&delete=1" class="btn btn-mini btn-danger adelete">Delete File</a>
                            </td>
                        </tr>
                        <?php } ?>

                        <tr>
                            <td><div class="text-right">Upload Image 1<br/>(Default Image)</div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="file" name="big_image_1" id="big_image_1" class="control" /><span class="text-danger">Best Size (width x height): 2000px X 2000px</span>
                                </div>
                            </td>
                        </tr>
                        <!--
                        <?php  if(!empty($thumb_image_2) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$thumb_image_2) == 1){ ?>
                        <tr>
                            <td><div class="text-right">Previously Uploaded Image 2</div></td>
                            <td><img src="<?php echo DISPLAY_PATH."/products/".$thumb_image_2; ?>" /></td>
                        </tr>
                        <tr>
                            <td><div class="text-right">&nbsp;</div></td>
                            <td>
                                <?php /* <a href="<?php echo "../uploads/products/".$thumb_image_2; ?>" download="<?php echo $thumb_image_2; ?>" class="btn btn-mini btn-info">Download File</a>*/ ?>
                                &nbsp; <a href="deleteproductfile.php?id=<?php echo $id;?>&filename=<?php echo $mini_image_2.",".$thumb_image_2.",".$medium_image_2.",".$big_image_2.""; ?>&filetype=thumb_image_2&foldername=<?php echo $foldername; ?>&delete=1" class="btn btn-mini btn-danger adelete">Delete File</a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <tr>
                            <td><div class="text-right">Upload Image 2</div></td>
                            <td>
                                <div class="col-md-6">
                                <input type="file" name="big_image_2" id="big_image_2" class="control" /><br /><span class="text-danger">Best Size (width x height): 2000 X 2000</span>
                                </div>
                            </td>
                        </tr>

                        <?php if(!empty($thumb_image_3) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$thumb_image_3."") == 1 ){ ?>
                        <tr>
                            <td><div class="text-right">Previously Uploaded Image 3</div></td>
                            <td><img src="<?php echo DISPLAY_PATH."/products/".$thumb_image_3; ?>" /></td>
                        </tr>
                        <tr>
                            <td><div class="text-right">&nbsp;</div></td>
                            <td>
                               <?php /* <a href="<?php echo "../uploads/products/".$thumb_image_3; ?>" download="<?php echo $thumb_image_3; ?>" class="btn btn-mini btn-info">Download File</a> */ ?>
                                &nbsp; <a href="deleteproductfile.php?id=<?php echo $id;?>&filename=<?php echo $mini_image_3.",".$thumb_image_3.",".$medium_image_3.",".$big_image_3.""; ?>&filetype=thumb_image_3&foldername=<?php echo $foldername; ?>&delete=1" class="btn btn-mini btn-danger adelete">Delete File</a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <tr>
                            <td><div class="text-right">Upload Image 3</div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="file" name="big_image_3" id="big_image_3" class="control" /><br /><span class="text-danger">Best Size (width x height): 2000 X 2000</span>
                                </div>
                            </td>
                        </tr>

                        <?php if(!empty($thumb_image_4) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$thumb_image_4."") == 1){ ?>
                        <tr>
                            <td><div class="text-right">Previously Uploaded Image 4</div></td>
                            <td><img src="<?php echo DISPLAY_PATH."/products/".$thumb_image_4; ?>" /></td>
                        </tr>
                        <tr>
                            <td><div class="text-right">&nbsp;</div></td>
                            <td>
                               <?php /*<a href="<?php echo "../uploads/products/".$thumb_image_4; ?>" download="<?php echo $thumb_image_4; ?>" class="btn btn-mini btn-info">Download File</a>*/ ?>
                                &nbsp; <a href="deleteproductfile.php?id=<?php echo $id;?>&filename=<?php echo $mini_image_4.",".$thumb_image_4.",".$medium_image_4.",".$big_image_4.""; ?>&filetype=thumb_image_4&foldername=<?php echo $foldername; ?>&delete=1" class="btn btn-mini btn-danger adelete">Delete File</a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <tr>
                            <td><div class="text-right">Upload Image 4</div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="file" name="big_image_4" id="big_image_4" class="control" /><br /><span class="text-danger">Best Size (width x height): 2000 X 2000</span>
                                </div>
                            </td>
                        </tr>

                        <?php if(!empty($thumb_image_5) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$thumb_image_5."") == 1){ ?>
                        <tr>
                            <td><div class="text-right">Previously Uploaded Image 5</div></td>
                            <td><img src="<?php echo DISPLAY_PATH."/products/".$thumb_image_5; ?>" /></td>
                        </tr>
                        <tr>
                            <td><div class="text-right">&nbsp;</div></td>
                            <td>
                               <?php /* <a href="<?php echo "../uploads/products/".$thumb_image_5; ?>" download="<?php echo $thumb_image_5; ?>" class="btn btn-mini btn-info">Download File</a> */ ?>
                                &nbsp; <a href="deleteproductfile.php?id=<?php echo $id;?>&filename=<?php echo $mini_image_5.",".$thumb_image_5.",".$medium_image_5.",".$big_image_5.""; ?>&filetype=thumb_image_5&foldername=<?php echo $foldername; ?>&delete=1" class="btn btn-mini btn-danger adelete">Delete File</a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <tr>
                            <td><div class="text-right">Upload Image 5</div></td>
                            <td>
                                <div class="col-md-6">
                                    <input type="file" name="big_image_5" id="big_image_5" class="control" /><br /><span class="text-danger">Best Size (width x height): 2000 X 2000</span>
                                </div>
                            </td>
                        </tr>
                        -->
                        
                      <?php } else { ?>
                          
                          <?php
                              $imgrowcount = 0;
                              $i = 1;
                              
                              $sqlquery = $fpdo->from("tblproduct_images")
                                               ->where("tblproduct_images.product_id = :product_id", array(":product_id" => $id));
                              $rsproduct_images = $sqlquery->fetchAll();
                              if (count($rsproduct_images)>0) {
                                foreach($rsproduct_images as $rowproduct_image){      
                                    $filenames = $rowproduct_image['mini_image'].", ".$rowproduct_image['thumb_image'].", ".$rowproduct_image['medium_image'].", ".$rowproduct_image['big_image'];
                          ?>
                                <?php if(!empty($rowproduct_image['mini_image']) && (int)$DB->checkFileExists(UPLOAD_PATH."/products/".$rowproduct_image['thumb_image']."") == 1){ ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Image <?php echo $i; ?></div></td>
                                    <td style="vertical-align: bottom;">
                                        <div class="col-md-2"><img src="<?php echo DISPLAY_PATH."/products/".$rowproduct_image['mini_image']; ?>" /></div>
                                        
                                        <div class="col-md-2">
                                            <a href="<?php echo DISPLAY_PATH."/products/".$rowproduct_image['big_image']; ?>" download="<?php echo $rowproduct_image['big_image']; ?>" class="btn btn-xs btn-info"><i class="fa fa-download"></i></a>
                                            &nbsp;<!-- <a href="deleteproductimagefile.php?id=<?php echo $rowproduct_image['id'];?>&product_id=<?php echo $id;?>&filename=<?php echo $rowproduct_image['mini_image'].",".$rowproduct_image['thumb_image'].",".$rowproduct_image['medium_image'].",".$rowproduct_image['big_image'].""; ?>&filetype=thumb_image&foldername=<?php echo $foldername; ?>&delete=1" class="btn btn-xs btn-danger adelete"><i class="fa fa-trash"></i></a>-->
                                            <a href="javascript://" data-id="<?php echo $rowproduct_image['id']; ?>" data-productid="<?php echo $id; ?>" data-filename="<?php echo $rowproduct_image['mini_image'].",".$rowproduct_image['thumb_image'].",".$rowproduct_image['medium_image'].",".$rowproduct_image['big_image'].""; ?>"  data-foldername="<?php echo $foldername; ?>" data-filetype="image" data-toggle="modal" data-target="#modalDelete" class="btn btn-sm btn-danger adelete"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td><div class="text-right">Upload Image <?php echo $i; ?><br/> <?php if($i == 1){ ?>( Default Image) <?php } ?></div></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="hidden" name="product_image_id_<?php echo $i; ?>" value="<?php echo $rowproduct_image['id'];?>"   />
                                            <input type="hidden" name="product_image_filenames_<?php echo $i; ?>" value="<?php echo $filenames;?>" />
                                            <input type="file" name="big_image_<?php echo $i; ?>" id="big_image_<?php echo $i; ?>" class="control" /><br /><span class="text-danger">Best Size (width x height): 2000 X 2000</span>
                                        </div>
                                    </td>
                                </tr>
                          <?php
                                  $i++;
                                }
                              }
                          ?>
                          
                          <?php for($icount = $i; $icount <= 1; $icount++) { ?>
                          <tr>
                              <td><div class="text-right">Upload Image <?php echo $icount; ?><br/><?php if($icount == 1){ ?>(Default Image) <?php } ?></div></td>
                              <td><div class="col-md-6"><input type="file" name="big_image_<?php echo $icount; ?>" id="big_image_<?php echo $icount; ?>" class="control" /><br /><span class="text-danger">Best Size (width x height): 2000 X 2000</span></div></td>
                          </tr>
                          <?php } ?>
                        
                        <?php } ?>
                        
                        <?php
                            /*
                        <tr>
                            <td><div class="text-right">Tag(s) for searching<span class="text-danger">*</span></div></td>
                            <td>
                                <div class="col-md-9">
                                     <!--<input type="text" name="tags" id="tags" value="<?php echo $tags; ?>" class="form-control required" placeholder="Enter comma separated strings" />-->
                                     <input type="text" class="form-control" id="tags_input" name="tags_input" tabindex="15" value="<?php echo $tags;?>" />
                                     <br><span class="text-muted font400-italic">(e.g. Little, Littles, Little's)</span>
                                     <input type="hidden" id="tags" name="tags" value="<?php echo $tags; ?>" class="original"/>
                                </div>
                            </td>
                        </tr>
                            */
                        ?>
                        
                        <?php //if((int)$edit==1) { ?>
                        <tr>
                            <td class="col-md-2"><div class="text-right">Meta Title<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-9">
                                    <input type="text" name="meta_title" id="meta_title" value="<?php echo $meta_title;?>" maxlength="70" class="form-control <?php if((int)$edit==1) { echo "required"; } ?> "  title="Please enter title" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2"><div class="text-right">Meta Keyword <span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-9">
                                    <input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $meta_keyword;?>" maxlength="160"  class="form-control <?php if((int)$edit==1) { echo "required"; } ?> control" title="Please enter meta keyword" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2"><div class="text-right">Meta Description<span class="text-danger">*</span></div></td>
                            <td class="col-md-10">
                                <div class="col-md-9">
                                    <input type="text" name="meta_description" id="meta_description" value="<?php echo $meta_description;?>" maxlength="160"  class="form-control <?php if((int)$edit==1) { echo "required"; } ?> control" title="Please enter meta description"/>
                                </div>
                            </td>
                        </tr>
                        <?php //} ?>
                        
                        
                        <tr>
                            <td><div class="text-right">Status</div></td>
                            <td>
                                <div class="col-md-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="707" <?php if ((int) $status == 707) { echo "selected"; } ?>>Enable</option>
                                        <option value="505" <?php if ((int) $status == 505) { echo "selected"; } ?>>Disable</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="text-right">Sort Order<span class="text-danger">*</span></div></td>
                            <td>
                                <div class="col-md-2">
                                    <input type="text" name="sort_order" id="sort_order" value="<?php echo $sort_order; ?>" maxlength="10" class="required form-control" onKeyUp="allow_numeric(this);" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                            <div class="col-md-6">
                                <!--<a href="displaydeals.php" class="btn btn-warning"><i class="fa fa-undo"></i> Cancel</a>-->
                                <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-large btn-primary">Submit <i class=" fa fa-arrow-right"></i></button>
                            </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
              </form>
          </div>
      </div>
    </div>
    
    
    <div class="modal fade" id="addVariantModal" tabindex="-1" role="dialog" aria-labelledby="addVariantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="product-variant-form" id="product-variant-form"  role="form" action="new-product-variant-save.php" method="POST">
                    <input type="hidden" name="product_id" id="product_id" value="<?php echo $id; ?>" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title text-center" id="myModalLabel">Variants/Options</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissable" id="div-already-exists" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Invalid!</strong>
                            Unable to create new variant. Product Variant already exists!
                        </div>
                        
                        <div class="clearfix"></div>
                        <div class="row">
                            <?php if(!empty($variant_value_1_exists )){ ?>
                                <div class="col-md-4">
                                    <div class="form-groups">
                                        <label for="product_variant_size"><?php echo $variant_name_1; ?><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="product_variant_value_1" name="product_variant_value_1" title="Please enter variant value 1" />
                                    </div>
                                </div>
                            <?php } ?>
                            <?php /*if(!empty($variant_value_2_exists )){ ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="product_variant_color"><?php echo $variant_name_2; ?><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="product_variant_value_2" name="product_variant_value_2" title="Please enter variant value 2"/>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!empty($variant_value_3_exists )){ ?>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="product_variant_material"><?php echo $variant_name_3; ?><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control required" id="product_variant_value_3" name="product_variant_value_3" title="Please enter variant value 3"/>
                                    </div>
                                </div>
                            <?php } */?>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_selling_price">Product Price<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required" id="product_variant_product_price" name="product_variant_product_price" title="Please enter product price" onkeyup="allow_numeric(this);"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_price">Discount Price<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="product_variant_discount_price" name="product_variant_discount_price" value="0" title="Please enter discount price" onkeyup="allow_numeric(this);"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_price">Net Price<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control required" id="product_variant_net_price" name="product_variant_net_price" value="0" title="Please enter net price" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_sku">SKU<span class="small text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" id="product_variant_sku" name="product_variant_sku" />
                                </div>
                            </div>
                           <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_barcode">Barcode<span class="small text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" id="product_variant_barcode" name="product_variant_barcode" />
                                </div>
                            </div>
                        </div>
                        <div class="row"> -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_weight">Weight</label>
                                    <input type="text" class="form-control" id="product_variant_weight" name="product_variant_weight" />
                                </div>
                            </div>
                            <!--<div class="col-md-4">
                                <div class="form-group">
                                    <label for="product_variant_quantity">Quantity<span class="small text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" id="product_variant_quantity" name="product_variant_quantity" />
                                </div>
                            </div> -->

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnvariantsubmit" name="btnvariantsubmit" value="Save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    
    
    
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myDeleteLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myDeleteLabel">Delete Image ?</h4>
                    </div>
                    <div class="modal-body">
                     <p>You have selected to delete this image.</p>
                     <p>
                         If this was the action that you wanted to do,
                         please confirm your choice, or cancel and return
                         to the page.
                     </p>
                     <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                      <form name="frmdelete" id="frmdelete" method="post" action="deleteproductimagefile.php">
                         <input type="hidden" name="delete" id="delete" value="1" />
                         <input type="hidden" name="id" id="id" value="0" />
                         <input type="hidden" name="product_id" id="product_id" value="" />
                         <input type="hidden" name="filetype" id="filetype" value="" />
                         <input type="hidden" name="filename" id="filename" value="" />
                         <input type="hidden" name="foldername" id="foldername" value="" />
                         <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                         <button type="submit" id="btndelete" class="btn btn-danger">Delete</button>
                      </form>
                    </div>
                  </div>
              </div>
          </div>
<!--end middle part-->
<div class="col-md-12"><div class="blank-border"></div></div>
<footer>
    <?php require_once("footer.php") ?>
</footer>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>  -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
<link href="assets/plugins/bootstrap-summernote/css/summernote.css" rel="stylesheet">
<script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/summernote.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/texteditor.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>

<!--<link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.en.js" charset="UTF-8"></script>-->

<link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!--Scripts for tags manager-->
<link type="text/css" href="assets/plugins/tags-manager/inputosaurus.css" rel="stylesheet">
<link type="text/css" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" rel="stylesheet">

<script type="text/javascript" src="assets/plugins/tags-manager/inputosaurus.js"></script>
<!--<link type="text/css" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css" rel="stylesheet">  -->
<!--<script type="text/javascript" src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>-->

<link type="text/css" href="assets/plugins/tagmanager-master/tagmanager.css" rel="stylesheet">
<script type="text/javascript" src="assets/plugins/tagmanager-master/tagmanager.js"></script>

<script type="text/javascript" src="js/admin.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    Admin.Utils.initSummerNote();
    Admin.Utils.Product.initProduct();
    Admin.Utils.Product.setDefaultMeta();
    Admin.Utils.Product.addVariants();
    Admin.Utils.Product.initNewVariant();
    Admin.Utils.Product.validateNewVariant();
    Admin.Utils.Product.deleteMultipleVariant();
    Admin.Utils.Product.validateProduct();    
    Admin.Utils.Product.deleteProductImages();
});
</script>
</body>
</html>