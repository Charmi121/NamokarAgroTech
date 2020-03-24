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
    $rsparentcategory = array();
    $seo_url = $custom->removeTags($_REQUEST['seo_url']);
	
    if(($product_id = $product->isProduct($seo_url)) !== false) {
        $rsproducts = $product->getProductInfo($product_id);
		
        if(!empty($rsproducts)) {
            foreach($rsproducts as $rowproduct) {
                $response['id']               = $rowproduct['id']; 
                $response['product_name']     = $rowproduct['product_name'];
                $response['meta_title']       = $rowproduct['meta_title'];
                $response['meta_keyword']     = $rowproduct['meta_keyword'];
                $response['meta_description'] = $rowproduct['meta_description'];
                $response['meta_description'] = $rowproduct['meta_description'];
                $response['pdf_file']         = $rowproduct['pdf_file'];
                $response['video_url'] 	      = $rowproduct['video_url'];
                $response['seo_url']          = $rowproduct['seo_url'];
                $response['description']      = html_entity_decode($rowproduct['description'], ENT_QUOTES, "UTF-8");
                $response['is_product']       = 1;
                $response['is_error']         = 0;
			}
		}
		$limit = 1;
		$rsproductscategory = $product->getProductCategories($product_id,$limit);
		if(!empty($rsproductscategory)) {
            foreach($rsproductscategory as $rowproductcategory) {
                $category_id = $rowproductcategory['category_id']; 
                $rsparentcategory = $category->getBreadcrumbs($category_id);
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
    $currentURL = $custom->getCurrentPageURL($seo_url, "");
?>
<!doctype html>
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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/slick.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
	</head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        
        
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">
					  <li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemprop="item" href="<?php echo CONFIG_PATH; ?>/"><i class="fa fa-home" aria-hidden="true"></i></a></li>
					  <?php if(!empty($rsparentcategory)) { ?>
						  <?php foreach($rsparentcategory as $rowparentcategory){ ?>
							<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="<?php echo CONFIG_PATH; ?><?php echo CONFIG_PATH."categories".DS.$rowparentcategory["seo_url"].".html"; ?>" itemprop="name"><?php echo $rowparentcategory['category_name'];?></a></li>
						  <?php } ?>
					  <?php } ?>
					  <?php if(!empty($response['product_name'])) { ?>
					  <li class="breadcrumb-item active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemprop="name"><?php echo $response['product_name'];?></a></li>
					  <?php } ?>
					</ol>
				</div>
			</div>
            <?php if(empty($response['is_error'])) { ?>
			<?php 
				if(count($rsproducts) > 0) { 
					foreach($rsproducts as $rowproduct) {
			?>
            <div class="product-detail">
                <div class="row">
                    <div class="col-md-6">
                        <div class="slider slider-for">
							<?php
								$rsproductimages = $product->getProductImages($product_id);
								if (!empty($rsproductimages)) {
									foreach($rsproductimages as $rowproductimage) {						
							?>
							<div><img src="<?php echo $custom->showImagePath("products", $rowproductimage['thumb_image']); ?>" alt="<?php echo $rowproduct['product_name']; ?>" class="img-fluid"></div>
							<?php
									}
								}
							?>
						</div>
						<div class="slider slider-nav">
							<?php
								if (!empty($rsproductimages)) {
									foreach($rsproductimages as $rowproductimage) {						
							?>
							<div><img src="<?php echo $custom->showImagePath("products", $rowproductimage['thumb_image']); ?>" alt="<?php echo $rowproduct['product_name']; ?>" class="img-fluid"></div>
							<?php
									}
								}
							?>
						</div>
					</div>
                    <div class="col-md-6">
                        <h1 class="h1 heading-border"><?php echo $rowproduct['product_name']; ?></h1>
                        <p class="text-muted"><strong>Code : <?php echo $rowproduct['sku']; ?></strong></p>
                        <p><?php echo html_entity_decode($rowproduct['description'], ENT_QUOTES, "UTF-8"); ?></p>
                        <div class="buttons mt-3">
							<?php if(!empty($rowproduct['pdf_file'])){ ?>
                            <a href="<?php echo $custom->showImagePath("product_brochure", $rowproduct['pdf_file']); ?>" target="_blank" class="btn btn-orange-border"><i class="far fa-file-pdf"></i> E-Brochure</a>
							<?php } ?>
                            <a href="<?php echo CONFIG_PATH; ?>contact-us.php" class="btn btn-orange"><i class="far fa-envelope"></i> Enquiry Now</a>
						</div>
                        <div class="accordion py-4">
                            <div class="box">
                                <div class="heading-panel active">Advantage</div>
                                <div class="text-panel" style="display: block">
                                    <ul class="list-dot list-inline">
                                       <?php echo html_entity_decode($rowproduct['advantage'], ENT_QUOTES, "UTF-8"); ?>
									</ul>
								</div>
							</div>
							<div class="box">
                                <div class="heading-panel active">Features</div>
                                <div class="text-panel">
                                    <ul class="list-dot list-inline">
                                       <?php echo html_entity_decode($rowproduct['feature'], ENT_QUOTES, "UTF-8"); ?>
									</ul>
								</div>
							</div>
                            <div class="box">
                                <div class="heading-panel">Technical Specification</div>
                                <div class="text-panel">
                                    <?php echo html_entity_decode($rowproduct['tech_description'], ENT_QUOTES, "UTF-8"); ?>
								</div>
							</div>
							<div class="box">
                                <div class="heading-panel">Video</div>
                                <div class="text-panel">
                                    <?php echo $rowproduct['video_url']; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <?php 
					} 
				}    
			?>
			<?php } ?>
		</div>
		
		
        <!-- Start footer -->
        <?php require_once("footer.php"); ?>
        <!-- Start footer -->
		
        <!-- JavaScript -->
        <script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/webslidemenu.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/slick.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
        <script>
            //Product detial page slider
            $('.slider-for').slick({
				slidesToShow: 1,
				slidesToScroll: 1,
				arrows: false,
				fade: true,
				asNavFor: '.slider-nav'
			});
			
			$('.slider-nav').slick({
				slidesToShow: 4,
				slidesToScroll: 1,
				asNavFor: '.slider-for',
				dots: false,
				centerMode: false,
				focusOnSelect: true
			});
		</script>
	</body>
</html>