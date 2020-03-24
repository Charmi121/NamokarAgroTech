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
                $response['horsepower'] = $rowproduct['horsepower'];
                $response['machine_width'] = $rowproduct['machine_width'];
                $response['hitch_types'] = $rowproduct['hitch_types'];
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
    
     $sqlquery = $fpdo->from('tblproduct_categories')
                                 ->where("tblproduct_categories.product_id = :product_id", array(":product_id" => $product_id))
                               ;
      $productCategory = $sqlquery->fetch();
      $categoryId = 0;
      if(!empty($productCategory)){
            $categoryId = $productCategory['category_id'];
      }
      $params['cat_subcat_ids'] = $categoryId;
      $categoryProducts = $product->getProductByCategories($params);
      $catProductArray = array();
      $dd = 0;
      foreach($categoryProducts as $catproduct){
            if($catproduct['id'] != $product_id){
                $catProductArray[$dd]['id']  = $catproduct['id'];
                $catProductArray[$dd]['seo_url']  = $catproduct['seo_url'];
                $catProductArray[$dd]['image']  = $catproduct['medium_image'];
                $productname = $catproduct['product_name'];
                if(strlen($productname) > 25){
                        $productname = substr($productname, 0, 23).'...';
                }
                $catProductArray[$dd]['product_name']  = ucwords(strtolower($productname));
                $dd++;
            }
      }
      
      
       $sqlquery = $fpdo->from('tblproduct_gallery_images')
                                 ->where("tblproduct_gallery_images.product_id = :product_id AND tblproduct_gallery_images.status = :status", array(":product_id" => $product_id, ":status"=>707))
                                ->order("tblproduct_gallery_images.sort_order ASC")
                               ;
      $productgallery = $sqlquery->fetchAll();
      
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>India Agrovision Implements</title>
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
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/lightgallery.min.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/owl.carousel.css">

    <style>
    .gal {

        -ms-column-count: 4;
        -webkit-column-count: 4;
        -moz-column-count: 4;
        column-count: 4;
    }

    .gal li {
        padding-bottom: 0 !important;
        margin-bottom: 12px !important;
    }

    .gal img {
        width: 100%;
    }


    .owl-theme .owl-controls .owl-buttons .owl-prev {
        left: -2rem;
        top: 7rem;
    }

    .owl-theme .owl-controls .owl-buttons .owl-next {
        right: -2rem;
        top: 7rem;
    }

    .modal-dialog {
        max-width: 700px;
        margin: 1.75rem auto;
    }

    .modal .close {
        position: absolute;
        right: 0px;
        top: 0px;
        z-index: 999;
        background: #fff;
        color: #000;
        padding: 0.5rem 1rem;
        opacity: 1
    }

    .btn-orange {
        padding: 0.6rem 0;
    }

    @media (max-width: 767px) {

        .gal {
            -ms-column-count: 2;
            -webkit-column-count: 2;
            /* Chrome, Safari, Opera */
            -moz-column-count: 2;
            /* Firefox */
            column-count: 2;
        }

        .gal li {
            padding: 0 10px 0 10px !important;
            margin-bottom: 12px !important;
        }

    }
    </style>

</head>

<body>
    <?php require_once("header.php"); ?>
    <div class="protop-banner">
        <?php
				$rsproductbanners = $product->getProductBannerImage($product_id);
				if (!empty($rsproductbanners)) {
					foreach($rsproductbanners as $productbannerimage) {						
					?>
        <img src="<?php echo $custom->showImagePath("products", $productbannerimage['big_image']); ?>"
            alt="<?php echo $response['product_name']; ?>" class="img-fluid">
        <?php
					}
				}
			?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="<?php echo CONFIG_PATH; ?>">Home</a></li>
                    <?php
                        if(isset($rsparentcategory) && !empty($rsparentcategory)){
                                foreach($rsparentcategory as $cat){
                                    echo  '<li><a href="'.CONFIG_PATH.'categories/'.$cat['seo_url'].'.html">'.$cat['category_name'].'</a></li>';
                                }
                        }
                    ?>
                    <li><?php echo $response['product_name']; ?></li>
                </ul>
            </div>
        </div> 
    </div>

    <div class="product-namesec pb-5" id="product-name">
        <div class="container home-ultra">
		<?php if(isset($_SESSION['email_sent']) && $_SESSION['email_sent'] == 1){ ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Success!</h4>
                            Your requirement sent successfully.
                        </div>
                        <div class="clearfix"></div>
                <?php unset($_SESSION['email_sent']); }
				else if(isset($_SESSION['email_sent']) && $_SESSION['email_sent'] == 2){ ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Error!</h4>
                            Robot verification failed, please try again..
                        </div>
                        <div class="clearfix"></div>
                <?php unset($_SESSION['email_sent']); } ?>
            <div class="row py-4 align-items-top">
                <div class="col-md-6">
                    <h1 class="heading-leaf heading-leaf-left text-uppercase"><?php echo $response['product_name']; ?>
                    </h1>
                    <div class="pdc-descul pt-1">
                        <?php echo $response['description']; ?>
                    </div>

                </div>
                <div class="col-md-6 text-center">
                    <div class="product-bdr clearfix">
                        <?php
                                $rsproductimages = $product->getProductMainImage($product_id);
                                if (!empty($rsproductimages)) {
                                    foreach($rsproductimages as $rowproductimages) {						
                                    ?>
                        <img src="<?php echo $custom->showImagePath("products", $rowproductimages['big_image']); ?>"
                            alt="<?php echo $response['product_name']; ?>" class="img-fluid">
                        <?php
                                    }
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-icons-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-6 text-center">
                    <div class="product-icon">
                        <figure><img src="<?php echo CONFIG_PATH; ?>images/kubota_matched.png" class="img-fluid">
                        </figure>
                        <h4 class="icon-bdr font-weight-normal">Horsepower Required</h4>
                        <p><?php echo $response['horsepower'];?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6 text-center">
                    <div class="product-icon">
                        <figure><img src="<?php echo CONFIG_PATH; ?>images/widths.png" class="img-fluid"></figure>
                        <h4 class="icon-bdr font-weight-normal">Working Widths</h4>
                        <p><?php echo $response['machine_width'];?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6 text-center">
                    <div class="product-icon">
                        <figure><img src="<?php echo CONFIG_PATH; ?>images/hitches.png" class="img-fluid"></figure>
                        <h4 class="icon-bdr font-weight-normal">Hitch Types</h4>
                        <p><?php echo $response['hitch_types'];?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6 text-center">
                    <div class="product-icon bdr-none">
                        <figure><img src="<?php echo CONFIG_PATH; ?>images/colors.png" class="img-fluid"></figure>
                        <h4 class="icon-bdr font-weight-normal">Available Colors</h4>
                        <img src="<?php echo CONFIG_PATH; ?>images/shades.jpg" class="img-fluid">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>


    <div class="container">
        <div class="product-features" id="features">

            <div class="inset">
                <div class="row">
                    <div class="col-md-5">
                        <div class="fealist pt-4">
                            <div class="feaheading mb-4">
                                <h2 class="heading-leaf heading-leaf-left">Features</h2>
                            </div>
                            <figure class="text-center">
                                <?php
										$rsproductfeaturedimage = $product->getProductFeaturedImage($product_id);
										if (!empty($rsproductfeaturedimage)) {
											foreach($rsproductfeaturedimage as $rowproductfeaturedimage) {						
											?>
                                <img src="<?php echo $custom->showImagePath("products", $rowproductfeaturedimage['big_image']); ?>"
                                    alt="<?php echo $rowproductfeaturedimage['alt_text']; ?>" class="img-fluid">
                                <?php
											}
										}
									?>
                            </figure>
                            <!--                                    <ul class="list-inline common-dot">
									<li>Designed for toughest operations</li>
									<li>Extra Heavy Duty Gear Box</li>
									<li>Shocker for vibration control</li>
									<li>Augur Angle Adjustment</li>
								</ul>-->
                        </div>
                    </div>
                    <div class="col-md-7 proslide-right pt-3">
                        <div class="slider slider-for">
                            <?php
									$rsproductimages = $product->getProductImages($product_id);
									if (!empty($rsproductimages)) {
										foreach($rsproductimages as $rowproductimage) {						
										?>
                            <div class="d-flex align-items-center justify-content-center">
                                <div>
                                    <h4 class="pb-1"><?php echo $rowproductimage['alt_text']; ?></h4>
                                    <img src="<?php echo $custom->showImagePath("products", $rowproductimage['big_image']); ?>"
                                        alt="<?php echo $rowproductimage['alt_text']; ?>" class="img-fluid">
                                </div>
                            </div>
                            <?php
										}
									}
								?>
                        </div>
                        <div class="slider-nav">
                            <?php
									if (!empty($rsproductimages)) {
										foreach($rsproductimages as $key=>$rowproductimage) {						
										?>
                            <div>
                                <div class="imgout position-relative">
                                    <!--<span class="position-absolute"><?php echo $key + 1; ?></span>--><img
                                        src="<?php echo $custom->showImagePath("products", $rowproductimage['thumb_image']); ?>"
                                        alt="<?php echo $rowproductimage['alt_text']; ?>" class="img-fluid"></div>
                            </div>

                            <?php
										}
									}
								?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="product-spec pt-5" id="specs">
            <h2 class="heading-leaf heading-leaf-left pb-4">Technical Specification</h2>
            <div class="row">
                <div class="col-md-12 d-flex ">
                    <div class="product-spec-tabouter">
                        <?php
								$rsproducttechspec = $product->getProductTechSpec($product_id);
								$techspec_count = count($rsproducttechspec);
								if (!empty($rsproducttechspec)) {
									if($techspec_count > 1){
										
									?>
                        <ul class="nav nav-tabs flex-column nav-pills text-uppercase mr-5 mt-3" role="tablist">
                            <?php foreach($rsproducttechspec as $key=>$rowproducttechspec) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo (empty($key)) ? "active" : ""; ?>" data-toggle="tab"
                                    href="#tab_<?php echo $rowproducttechspec['id']; ?>"><?php echo $rowproducttechspec['title']; ?></a>
                            </li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                            <?php foreach($rsproducttechspec as $key=>$rowproducttechspec) { ?>
                            <div id="tab_<?php echo $rowproducttechspec['id']; ?>"
                                class="tab-pane <?php echo (empty($key)) ? "active" : ""; ?>">
                                <?php echo html_entity_decode($rowproducttechspec['tech_description'], ENT_QUOTES, "UTF-8"); ?>
                            </div>
                            <?php } ?>
                        </div>
                        <?php 	
										} else {
										foreach($rsproducttechspec as $rowproducttechspec) {
											echo html_entity_decode($rowproducttechspec['tech_description'], ENT_QUOTES, "UTF-8"); 
										}
									}
								}
							?>
                    </div>
                </div>

               <div class="col-12">
                    <p class="mb-0" style="font-size:13px; font-weight:500"><em>* The Weight and working data contained are supplied for information only and are not binding. Specification and size can be altered as a part of ongoing product modification / improvement.</em></p>
               </div>

                <!-- <div class="col-md-4 col-sm-4 col-12">
                    <figure><a href="#"><img src="<?php echo CONFIG_PATH; ?>images/get-a-quote.jpg" class="img-fluid"></a></figure>
                </div>

                <div class="col-md-4 col-sm-4 col-12">
                    <figure><a href="#"><img src="<?php echo CONFIG_PATH; ?>images/watch-video.jpg" class="img-fluid"></a></figure>
                </div>

                <div class="col-md-4 col-sm-4 col-12">
                    <figure><a href="#"><img src="<?php echo CONFIG_PATH; ?>images/download-brochure.jpg" class="img-fluid"></a></figure>
                </div> -->

                <div class="col-12">
                    <div class="row mt-3 no-gutters">
                        <div class="col-lg-3 col-md-3 col-12">
                            
                            <figure><a href="#" data-toggle="modal" data-target="#enquiry-form">
                                <img src="<?php echo CONFIG_PATH; ?>images/get-a-quote.png" class="img-fluid">
                            </a></figure>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <figure><a href="<?php echo CONFIG_PATH; ?>partner-with-us.html">
                                <img src="<?php echo CONFIG_PATH; ?>images/dealer.png" class="img-fluid">
                            </a></figure>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">

                            <a href="#" data-toggle="modal" data-target="#exampleModal">
                                <img src="<?php echo CONFIG_PATH; ?>images/watch-video.png" class="img-fluid">
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="modal-body">
                                            <?php if(!empty($response['video_url'])){  ?>
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item"
                                                    src="<?php echo $response['video_url']; ?>" frameborder="0"
                                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen></iframe>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-12">
                            <?php if (!empty($response['pdf_file'])) { ?>
                            <a href="<?php echo $custom->showImagePath("product_brochure", $rowproduct['pdf_file']); ?>" target="_blank">
                                <img src="<?php echo CONFIG_PATH; ?>images/download-brochure.png" class="img-fluid">
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <!-- <div class="photo-gallery pt-5 pb-5">
						
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									
								</div>
							</div>
							<h2 class="">Photo Gallery</h2>
							<hr>
							<ul class="row list-inline lightgallery gallery-one">
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery1-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery1.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery2-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery2.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery3-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery3.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery4-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery4.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery5-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery5.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery6-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery6.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery7-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery7.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								<li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/photo-gallery8-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/photo-gallery8.jpg" class="img-fluid" alt="Rotary Tiller"></figure><span>Rotary Tiller</span></li>
								
							</ul>
						</div>
					</div> -->

                <div class="clearfix"></div>

                <?php if(count($productgallery) > 0){  ?>
                <div class="photo-gallery pt-5 pb-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="heading-leaf heading-leaf-left pb-2">Photo Gallery</h2>
                                <hr>
                            </div>
                            <div class="col-md-12 clearfix">
                                <ul class="gal clearfix list-inline lightgallery gallery-one">
                                    <?php foreach($productgallery as $gallery){ ?>
                                    <li data-src="<?php echo DISPLAY_PATH.'/products/'.$gallery['big_image'] ;?>">
                                        <figure><img
                                                src="<?php echo DISPLAY_PATH.'/products/'.$gallery['thumb_image'] ;?>"
                                                class="img-fluid" alt="<?php echo $gallery['alt_text'] ;?>"></figure>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>


            </div>
        </div>
    </div>

    <style>
        .slick-dots{
            display:none !important
        }

        .slick-slide img {
            display: block;
            padding: 0.3rem;
        }
        .item {
            margin: 0.3rem;
        }
        .item figure{
            min-height: 260px;     
        }
    </style>

    <?php if($catProductArray) { ?>
    <div class="product-gallery">
        <div class="container">
            <div class="row">
                <div class="col-md-12 foot-gallery">
                    <h2 class="heading-leaf-left pb-4 text-center">Other Models</h2>
                    <div class="text-center regular">
                        <?php foreach($catProductArray as $catproduct) { ?>
                        <a href="<?php echo CONFIG_PATH; ?>product/<?php echo $catproduct['seo_url']; ?>.html">
                            <div class="slide item  mb-0">
                               <div style="background:#fff"> 
                                    <figure class="d-flex align-items-center justify-content-center mb-0">
                                        <img src="<?php echo DISPLAY_PATH.'/products/'.$catproduct['image'] ;?>" class="img-fluid">
                                    </figure>
                                    <p><?php echo $catproduct['product_name'];?></p>
                               </div>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php } ?>

    <!-- <div class="product-notification text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-0"><em>* The Weight and working data contained are supplied for information only and
                            are not binding. Specification ad size can be altered as a part of ongoing product
                            modification/imporvement.</em></p>
                </div>
            </div>
        </div>
    </div> -->


<!-- The modal -->
<div class="modal fade" id="enquiry-form" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mx-auto" id="modalLabel">Get a Quote</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-4">
			 <form id="contactform" name="contactform"  action="<?php echo CONFIG_PATH; ?>get-quote-save.php"  method="post" autocomplete="off">
			 <input type="hidden" name="seo_url" value="<?=$seo_url;?>" >
                <div class="form-group">
                    <label>Describe Your Buying Requirements in Detail</label>
                     <textarea class="form-control mb-4 required" name="requirement" title="Please enter requirement" ></textarea>
                </div>
                <div class="row no-gutters">
                    <div class="form-group col-md-6">
                        <label>First Name</label>
                        <input type="text" class="form-control required" placeholder="">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Last Name</label>
                        <input type="text" class="form-control required" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>E-mail</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Company Name</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Website</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-12">
                        <label>Street Address</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>City</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>State</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Postal Code</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Country</label>
                        <select class="form-control">
                            <option>Country</option>
                            <option>India</option>
                            <option>Aus</option>
                            <option>UK</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Telephone</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Mobile</label>
                        <input type="text" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-md-12">
								<div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>								
					</div>
                    <div class="form-group col-md-4 mx-auto col-12 mt-3">
                        <input type="submit" value="Submit" class="btn btn-orange btn-block text-uppercase">
                    </div>
                </div>
			</form>	
            </div>
        </div>
    </div>
</div>


    <!-- Start footer -->
    <?php require_once("footer.php"); ?>
    <!-- JavaScript -->
    <script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>js/webslidemenu.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>js/slick.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>js/lightgallery.min.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    <script src="<?php echo CONFIG_PATH; ?>js/owl.carousel.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js" charset="utf-8"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
    $(document).ready(function() {
	
	$('#contactform').validate();

        //Sort random function
        function random(owlSelector) {
            owlSelector.children().sort(function() {
                return Math.round(Math.random()) - 0.5;
            }).each(function() {
                $(this).appendTo(owlSelector);
            });
        }

        $("#owl-demo").owlCarousel({
            navigation: true,
            autoPlay : 3000,
            stopOnHover : true,
            paginationSpeed : 1000,
            goToFirstSpeed : 2000,
            navigationText: [
                "<i class='fas fa-chevron-left icon-white'></i>",
                "<i class='fas fa-chevron-right icon-white'></i>"
            ],
            //Call beforeInit callback, elem parameter point to $("#owl-demo")
            beforeInit: function(elem) {
                random(elem);
            }

        });

    });


    //Product detial page slider
    $('.slider-for').slick({

        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 2000,
        //fade: true,

        asNavFor: '.slider-nav'
        
    });

    $('.slider-nav').slick({
        slidesToShow: 8,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: false,
        focusOnSelect: true
    });


    $('.regular').slick({
    dots: true,
    infinite: true,
    autoplay: true,
    autoplaySpeed: 1000,
    speed: 200,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
        {
        breakpoint: 1024,
        settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
            infinite: true,
            dots: true
        }
        },
        {
        breakpoint: 600,
        settings: {
            slidesToShow: 2,
            slidesToScroll: 2
        }
        },
        {
        breakpoint: 480,
        settings: {
            slidesToShow: 1,
            slidesToScroll: 1
        }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
    });

    // $(".regular").slick({
    //     dots: true,
    //     infinite: true,
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     slidesToScroll: 1,
    //     autoplay: true,
    //     autoplaySpeed: 2000,
    // });

 
 </script>
</body>

</html>