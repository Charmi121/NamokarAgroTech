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
	
    $pageURL = BASEURL;
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Agricultural organic Farming</title>
        <meta name="description" content="Namokar AgroTech Hybrid far in the nersery with fully organic system. and is a centerwhere we produce high quality plants.">
        <meta name="keywords" content="organic,nersery,plants,low cost farming solutions">

        <meta name="copyright" content="India Agro Vision Implements Private Limited - India, 2006 - 2016">
        <meta name="author" content="www.indiaagrovision.com">
        <meta name="Reply-to" content="sales@namokaragrotech.com">
        <meta name="googlebot" content="noodp">
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="canonical" href="http://www.indiaagrovision.com">
        <meta name="google-site-verification" content="Dn6qK3SAiQvxBVOw9iTQGbdxwjXnBMi0RwTf7qjzfus" />
        
        
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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
	</head>
    <body>


        <?php require_once("header.php"); ?>
        <!-- Start Banner -->
        <div class="home-banner">
            <div id="demo" class="carousel slide" data-ride="carousel">
				
                <!-- Indicators -->
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                    <li data-target="#demo" data-slide-to="3"></li>
                    <li data-target="#demo" data-slide-to="4"></li>
				</ul>
				
                <!-- The slideshow -->
                <div class="carousel-inner">
                    <!--
                    <div class="carousel-item ">
                        <img src="<?php echo CONFIG_PATH; ?>images/banner1.jpg" alt="">
                    </div>
                    -->
                    <div class="carousel-item active">
                        <img src="<?php echo CONFIG_PATH; ?>images/banner2.jpg" alt="">
					</div>
                    <div class="carousel-item">
                        <img src="<?php echo CONFIG_PATH; ?>images/banner3.jpg" alt="">
					</div>
                    <div class="carousel-item">
                        <img src="<?php echo CONFIG_PATH; ?>images/banner4.jpg" alt="">
					</div>
                    <div class="carousel-item">
                        <img src="<?php echo CONFIG_PATH; ?>images/slider-image1.jpg" alt="">
					</div>
				</div>
				
                <!-- Left and right controls -->
                <a class="carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
				</a>
                <a class="carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
				</a>
				
			</div>
		</div>
        <!--End Banner -->
        <!--start middle -->
        <div class="home-comfarm  text-center py-3">
            <div class="container">
                <div class="row">



                   <!-- <div class="col-md-12">
                        <span class="pb-1">Complete Farm Mechanization</span>
                        <ul class="list-inline d-flex flex-wrap">
							<li><i class="icon-sprite icon-seeding"></i>Seeding & Plantation</li>
							<li><i class="icon-sprite icon-tillage"></i>Tillage</li>
							<li><i class="icon-sprite icon-crop"></i>Crop Protection</li>
							<li><i class="icon-sprite icon-haulage"></i>Haulage</li>
							<li><i class="icon-sprite icon-post"></i>Post Harvest</li>
							<li><i class="icon-sprite icon-harvest"></i>Harvest</li>
                            <li><i class="icon-sprite icon-land"></i>Landscaping</li>
							<li><i class="icon-sprite icon-miscellaneous"></i>Miscellaneous</li>
						</ul>
					</div>-->
				</div>
			</div>
		</div>
		
        <!--<div class="bg-gray pt-3">
            <div class="container">
                <div class="row home-event py-5">
                    <div class="col-lg-4 col-md-6">
                        <div class="box box1 d-flex flex-column">
                            <div class="top"><h1 class="heading-leaf">Farm <strong>Equipments</strong></h1></div>
                            <div class="bottom">
                                <a href="<?php echo CONFIG_PATH; ?>categories/tillage.html" class="btn-orange">View Products</a>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="box box2 d-flex flex-column">
							<div class="top"><h2 class="heading-leaf">Become <strong>Our Dealer <br> or Distributor</strong></h2></div>
							<div class="bottom">
								<a href="partner-with-us.html" class="btn-orange">Apply</a>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12">
						<div class="box box3">
							<h2 class="heading bg-orange mb-2">Company <strong>Updates</strong></h2>
							<div class="content mCustomScrollbar compny-scroll home-carsoul" id="content-1">
								<div class="list-wrpaaer" style="height:380px">
									<ul class="list-inline" id="marquee-vertical">
									 <?php
                                    
                                    
                                     $sqlquery = $fpdo->from('tblcompany_update');                                                             ;
                                     $rsdata = $sqlquery->fetchAll();
                                     foreach($rsdata as $row)
									 {
                                   ?>
										<li>
											<a href="<?=$row['url'];?>" class="d-flex">
												<figure style="min-width:90px"><img src="<?php echo CONFIG_PATH; ?>uploads/news-event/<?=$row['thumb_image'];?>" alt="img"></figure>
												<p><?=$row['title'];?>
													<small><?=$row['description'];?><br /><?=$row['location'];?></small>
												</p>
											</a>
										</li>	
									 <?php } ?>	
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="home-product text-center pb-5">
					<h3 class="heading-border">Product Portfolio</h3>
					<div class="row inset">
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/seeding-plantation.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct1.png" alt="img" class="img-fluid"></figure>
								Seeding and Plantation
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/tillage.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct2.png" alt="img" class="img-fluid"></figure>
								Tillage
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/crop-protection.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct3.png" alt="img" class="img-fluid"></figure>
								Crop Protection
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/haulage.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct4.png" alt="img" class="img-fluid"></figure>
								Haulage
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/post-harvest.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct5.png" alt="img" class="img-fluid"></figure>
								Post Harvest
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/harvest.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct6.png" alt="img" class="img-fluid"></figure>
								Harvest
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/landscaping.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct7.png" alt="img" class="img-fluid"></figure>
								Landscaping
							</a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo CONFIG_PATH; ?>categories/miscellaneous.html">
								<figure class="d-flex align-items-center justify-content-center mb-2"><img src="<?php echo CONFIG_PATH; ?>images/proudct8.png" alt="img" class="img-fluid"></figure>
								Miscellaneous
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		
                                <?php
                                    $rsproducts = $product->getNewProductInfo();
                                     if(!empty($rsproducts)) { 
                                     $sqlquery = $fpdo->from('tblproduct_categories')
                                                                 ->select(null)
                                                                 ->select('tblcategories.id, tblcategories.category_name')
                                                                ->leftJoin('tblcategories ON tblcategories.id = tblproduct_categories.category_id')
                                                                ->where("tblproduct_categories.product_id = :product_id", array(":product_id" => $rsproducts['id']))
                                                              ;
                                     $productCategory = $sqlquery->fetch();
                                  
                                   ?>
                                        <div class="container home-ultra">
                                                    <div class="row py-5 align-items-center">
                                                            <div class="col-md-6 text-center">
                                                                    <?php
                                                                    $rowproductimage = $product->getProductMainImage($rsproducts['id']); 
                                                                    if(!empty($rowproductimage[0]['medium_image'])){
                                                                        $imgpath = $custom->showImagePath("products", $rowproductimage[0]['medium_image']);
                                                                    }else{
                                                                        $imgpath = $custom->showImagePath("no-image", 'no-image.png');
                                                                    }
                                                                    ?>
                                                                    <img src="<?php echo $imgpath; ?>" alt="img" class="img-fluid">
                                                            </div>
                                                            <div class="col-md-6">
                                                                    <h2 class="heading-leaf"><strong>New</strong> <?php echo $rsproducts['product_name']; ?></h2>
                                                                    <span class="d-none"><?php echo $productCategory['category_name'];?></span>
                                                                    <div class="pdc-descul"><?php echo html_entity_decode($rsproducts['description'], ENT_QUOTES, "UTF-8"); ?></div>
                                                                    <a href="<?php echo CONFIG_PATH; ?>product/<?php echo $rsproducts['seo_url']; ?>.html" class="btn btn-orange text-uppercase mt-4">Read More</a>
                                                            </div>-->

   </div>

<!--<br>
<br>
<br>
<img src="images/A1.jpg" height="50%" width="50%"/>-->
                                       </div>
                                <?php } ?>
		<!--End middle -->
		
		<!-- Start footer -->
		<?php require_once("footer.php"); ?>
		<!-- Start footer -->
		
		<!-- JavaScript -->
		<script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
		<script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
		<script src="<?php echo CONFIG_PATH; ?>js/webslidemenu.js"></script>
		<!-- scrollbar plugin -->
		<script src="<?php echo CONFIG_PATH; ?>js/jquery.mCustomScrollbar.concat.min.js"></script>
		<script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
		<script type="text/javascript" src="js/jquery.marquee.min.js"></script>

		<script type="text/javascript">
			$(function () {
				$('#marquee-vertical').marquee({direction:'vertical', delay:0, timing:50});  
			});
		</script>		

</body>
</html>											