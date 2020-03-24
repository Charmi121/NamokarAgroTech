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
	
    use Classes\Page as Page;
    $page = new Page($fpdo);
	
    use Classes\Errorcodes as Errorcodes;
    $errorcode = new Errorcodes();
    
    $seo_url = $custom->removeTags($_REQUEST['seo_url']);    
    $photo_category = $category->isCategoryPhoto($seo_url);
    
    $pageURL = BASEURL;
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Agrovision</title>
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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/lightgallery.min.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    </head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        <!-- End footer -->

        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Photo Gallery </h1>
            </div>
        </div>
        <div class="photo-gallery pb-5">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-3">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <a href="<?php echo CONFIG_PATH; ?>news-events.html">Photo Gallery</a>
                            <li>All</li>
                        </ul>
                    </div>
                </div>
                <?php
                        $categoryphoto = $category->getCategoryPhoto($photo_category['id']);
                ?>
                <h2 class="text-center pb-4"><?php echo $photo_category['photo_category_name'];?></h2>
                <ul class="row list-inline lightgallery gallery-one">
                    <?php if(!empty($categoryphoto)){
                                foreach($categoryphoto as $photo){ ?>
                                        <li class="col-6" data-src="<?php echo CONFIG_PATH.'uploads/photos/'.$photo['big_image'];?>"><figure><img src="<?php echo CONFIG_PATH.'uploads/photos/'.$photo['big_image'];?>" class="img-fluid" alt="Rotary Tiller"></figure><span><?php echo $photo['photo_title'];?></span></li>
                                <?php }
                    }
                    ?>
            </ul>
        </div>
           </div>
        <!-- Start footer -->
        <?php require_once("footer.php"); ?>
        <!-- Start footer -->

        <!-- JavaScript -->
        <script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/webslidemenu.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/lightgallery.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>
</html>