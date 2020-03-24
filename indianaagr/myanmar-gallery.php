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
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li><a href="<?php echo CONFIG_PATH; ?>photo-gallery.php">Photo Gallery</a></li>
                            <li>INDEE Myanmar</li>
                        </ul>
                    </div>
                </div>
                <h2 class="h2 text-center pb-4">INDEE Myanmar 2014<small class="d-block text-muted">(Thursday, March 13, 2014)</small></h2>
                <ul class="row list-inline lightgallery gallery-one justify-content-md-center">
                    <li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/myanmar1-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/myanmar1.jpg" class="img-fluid" alt="INDEE Myanmar"></figure><span>INDEE Myanmar 2014</span></li>
                    <li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/myanmar2-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/myanmar2.jpg" class="img-fluid" alt="INDEE Myanmar"></figure><span>INDEE Myanmar 2014</span></li>
                    <li class="col-md-3 col-6" data-src="<?php echo CONFIG_PATH; ?>images/myanmar3-big.jpg"><figure><img src="<?php echo CONFIG_PATH; ?>images/myanmar3.jpg" class="img-fluid" alt="INDEE Myanmar"></figure><span>INDEE Myanmar 2014</span></li>
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