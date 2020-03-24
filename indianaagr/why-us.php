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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    </head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        <!-- End footer -->
        
        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Why Us</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-5">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li><a href="<?php echo CONFIG_PATH; ?>profile.php">About Us</a></li>
                        <li>Why Us</li>
                    </ul>
                </div>
            </div>
            <div class="about-why pb-5">
                <div class="row align-items-center why-inset">    
                    <div class="col-md-6 text-center">
                        <img src="<?php echo CONFIG_PATH; ?>images/why-us.png" alt="why us" class="img-fluid">
                    </div>                
                    <div class="col-md-6">
                        <p>We named our company INDIA AGROVISION IMPLEMENTS because it signifies what we offer, how our clients respond to our work, and how we feel about delivering it.</p>
                        <p>Our work meets the requirements of the farmers - takes the weight off clients’ shoulders and leaves them delighted with the results.</p>
                        <h3 class="h4 pb-2">We achieve this because we believe in providing quality not just the first time, but every time.</h3>
                        <ul class="list-inline list-dot">
                            <li>Experience & knowledge of more than 50 years</li>
                            <li>Comparative prices</li>
                            <li>Top quality products</li>
                            <li>Transparent and ethical business practices</li>
                            <li>Strong network of dealers & distributors</li>
                            <li>Growth oriented philosophy</li>
                        </ul>
                    </div>
                </div>
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
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>
</html>