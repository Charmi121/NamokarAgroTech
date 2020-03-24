<?php
    namespace Ecommerce;

    require("connect.inc.php");
    require("config.php");
	
    use Classes\CustomFunction as CustomFunction;
    $custom = new CustomFunction();

    use Classes\Currency as Currency;
    $currency = new Currency($fpdo);

    use Classes\Category as Category;
    $category = new Category($fpdo);
	
	use Classes\Product as Product;
    $product = new Product($fpdo);
    
    use Classes\Page as Page;
    $page = new Page($fpdo);
	
    use Classes\Errorcodes as Errorcodes;
    $errorcode = new Errorcodes();
	
	$response = array();
    $seo_url = $custom->removeTags($_REQUEST['seo_url']);
	
	$arrBreadcrumbs = array();
	 if(($cat_id = $category->isCategory($seo_url)) !== false) {
        $rscategory = $category->getCategoryInfo($cat_id);

        if(!empty($rscategory)) {
            foreach($rscategory as $rowcategory) {
                $response['id'] = $rowcategory['id']; 
                $response['page_title'] = $rowcategory['category_name'];
                $response['meta_title'] = $rowcategory['meta_title'];
                $response['meta_keyword'] = $rowcategory['meta_keyword'];
                $response['meta_description'] = $rowcategory['meta_description'];
                $response['seo_url'] = $rowcategory['seo_url'];
                $response['description'] = html_entity_decode($rowcategory['description'], ENT_QUOTES, "UTF-8");
                $response['banner_image'] = $rowcategory['banner_image'];
                $response['alt_text'] = $rowcategory['alt_text'];
                $response['parent_id'] = $rowcategory['parent_id'];
                $response['is_cat'] = 1;
                $response['is_error'] = 0;
                
                $arrBreadcrumbs[] = array("page_title" => $rowcategory['category_name'], "seo_url" => $rowcategory['seo_url']); 
            }
			$rsparentcategory = $category->getBreadcrumbs($cat_id);
			//$response['parent_category'] = $rsparentcategory[0]['category_name'];
                                                $response['root_cat_id'] = $category->getRootCategoryId($response['id']);
                                                if($response['parent_id'] != 0){
				$rsischild = $category->isChildCategory($response['id']);
				if(count($rsischild) > 0) {
					foreach($rsischild as $rowischild){ 
						header("Location: ".CONFIG_PATH."categories".DS.$rowischild["seo_url"].".html");
					}
				}
			}
        }
    } else {
        $response['meta_title'] = STORE_WEBSITETITLE;
        $response['meta_keyword'] = "";
        $response['meta_description'] = "";
        $response['is_error'] = 1;
        header("HTTP/1.0 404 Not Found");
    }
	
    $pageURL = $custom->getPageURL();
    $currentURL = $custom->getCurrentPageURL($seo_url, "categories");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo STORE_METATITLE; ?></title>
    <!-- Fav Icoin -->
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo CONFIG_PATH; ?>images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo CONFIG_PATH; ?>images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo CONFIG_PATH; ?>images/favicon-16x16.png">
    <link rel="manifest" href="<?php echo CONFIG_PATH; ?>images/manifest.json">
    <link rel="mask-icon" href="<?php echo CONFIG_PATH; ?>images/safari-pinned-tab.svg" color="#f88a1e">
    <meta name="theme-color" content="#f88a1e">
    <!--CSS -->
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/fontawesome-all.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    <?php echo STORE_GOOGLEANALYTICS; ?>
</head>

<body>

    <header>
        <?php require_once("header.php"); ?>
    </header>

    <section class="page-section clearfix">
        <div class="mt-2 clearfix">
            <div class="container">
                <div class="clearfix">

                    <div class="row">
                        <div class="col-md-4">
                            <?php /*?><h1 class="text-xs-center category-title"><?php echo $response['page_title']; ?>
                            </h1><?php */?>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="breadcrumb mb-5">
                                <li><a href="<?php echo CONFIG_PATH; ?>">Home</a></li>
                                 <?php
                                    $lastCat = array_pop($rsparentcategory);
                                    
                                    if(count($rsparentcategory) > 0){
                                        foreach($rsparentcategory as $cat){
                                            echo  '<li><a href="'.CONFIG_PATH.'categories/'.$cat['seo_url'].'.html">'.$cat['category_name'].'</a></li>';
                                        }
                                    }
                                 ?>
                                 <li><?php echo $lastCat['category_name'];?></li>
                            </ul>
                        </div>
                    </div>                    

                    <div class="row category-hold">
                        <?php
                                $params = array();
                                $params['cat_id'] = $response['id'];
                                $rscategories = $category->getChildCategories($params['cat_id']);
                                if(count($rscategories) > 0) {
                                        foreach($rscategories as $rowcategory){ 
                                            ?>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                <div class="category">
                                                    <a href="<?php echo CONFIG_PATH."categories".DS.$rowcategory["seo_url"].".html"; ?>">
                                                        <figure>
                                                            <img src="<?php echo $custom->showImagePath("categories", $rowcategory['thumb_image']); ?>"
                                                                alt="<?php echo $rowcategory['category_name']; ?>"
                                                                class="img-fluid margin0auto">
                                                        </figure>
                                                        <?php echo $rowcategory['category_name']; ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php 
                                            }  ?>
                                            <div class="col-md-12 col-sm-12 col-xs-12 my-2"><hr /></div>
                      <?php   }  ?>
                    </div>
                    <?php
						$params = array();
                        $params['category_id'] = $response['id'];
						$rsproducts = $product->getCategoryProductDetail($params);
						if(count($rsproducts) > 0) {
					?>
                    <div class="row">
                        <div class="col-12 mb-2">
                            <h1 class="h2 text-center"><?php echo $response['page_title']; ?></h1>
                        </div>
                    </div>

                    <div class="product-display">
                        <div class="row inset">
                            <?php
                                foreach ($rsproducts as $rowproduct) {
                                                                    $rsproductimages = $product->getProductMainImage($rowproduct['id']);
                                    if (!empty($rsproductimages)) {
                                        foreach($rsproductimages as $rowproductimage) {	
                            ?>
                            <div class="col-md-3 col-sm-3 col-6 text-center mb-1 child">
                                <div class="product-section clearfix mb-2">
                                    <a href="<?php echo CONFIG_PATH; ?>product/<?php echo $rowproduct['seo_url']; ?>.html">
                                        <figure class="d-flex align-items-center justify-content-center mb-0">
                                            <img src="<?php echo $custom->showImagePath("products", $rowproductimage['medium_image']); ?>" class="img-fluid">
                                        </figure>
                                        <div class="h5 mt-3"><?php echo $rowproduct['product_name']; ?>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <?php  
                                    }
                                }
                            }
                        ?>
                        </div>
                    </div>
                    <?php  
						} 
					?>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <?php require_once("footer.php"); ?>
    </footer>
    <!-- JavaScript -->
    <script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
</body>

</html>