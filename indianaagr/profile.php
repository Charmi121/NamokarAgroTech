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
                <h1 class="text-white heading-border">About India Agrovision</h1>
            </div>
        </div>
        <div class="about-profile">
        
        <div class="container">
            <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li>About India Agrovision</li>
                        </ul>
                    </div>
                </div>
            <div class="row pb-5 pt-0">
            <div class="col-md-6">
                <figure class="position-relative figure-innerborder"><img src="<?php echo CONFIG_PATH; ?>images/profile.jpg" alt="profile" class="img-fluid img-rounded"></figure>
            </div>
            <div class="col-md-6">
                <p>India Agrovision Implements Pvt. Ltd. is a globally renowned manufacturer of Agriculture Farm Implements under the brand name AGROVISION. Our range of products include Rotary Tillers (Rotavator), Disc Plough, Disc Harrows, Disc Ridgers (Bund Maker), Tyne Ridgers, Tipping Trailers, Spring Loaded Tillers, Rigid Tillers, Backhoe Loaders, Rotary Harrows, Seed cum Fertilizer Drills (Planters), Trench Diggers, Land Levellers, Post Hole Diggers, Sub Soilers, Rotary Slashers, etc. marked by more than 50 years of experience, we have been contributing to agricultural growth of the country by providing innovative implements at the most affordable prices.</p>
                <p>We use best quality of raw material and sustainable engineering designs for manufacturing innovative implements of International standards. Our employees often come from rural areas and agriculture backgrounds - they know the products they build and they understand how our customers will use them. This knowledge helps us build a product that will perform as expected for years to come. Our implements are all designed and manufactured in compliance with the latest industry standards. When you buy a Agrovision product, you know that it has been tested – and passed – in real-world situations that are more rugged and demanding than it will likely see in its service life.</p>
                <p>We’re glad you stopped by for a virtual visit today. Please look around. Check out the specs on our products. If you are interested in becoming our dealer, fill out <u><a href="partner-with-us.php" class="font-weight-bold" style="color:#ff9900" >Dealership form</a></u> and our sales team will contact you soon.</p>
            </div>
         </div>

        <div class="about-total pb-5">
            <div class="container">
                <ul class="d-flex flex-wrap align-items-center text-uppercase list-inline justify-content-between">
                    <li><i class="fa fa-flask"></i><span><strong>50 </strong>Year of Experience</span></li>
                    <!-- <li><i class="fa fa-globe"></i> <span><strong>6</strong> Continents</span></li> -->
                    <li><i class="fa fa-flag"></i> <span><strong>28</strong> Presence in 28 Countries</span></li>
                    <li><img src="images/product-icon.png" class="img-fluid pb-2"> <span><strong>50</strong> Over 50 Products to fit with your Tractor </span></li>
                    <li><i class="fa fa-users"></i> <span><strong>98% </strong>Happy Customers</span></li>
                </ul>
            </div>
        </div>

        <div class="container mt-4">
            <div class="row pb-3">
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/complete-farm.jpg" class="img-fluid"></figure>
                </div>

                <div class="col-md-6 col-sm-8 col-12 d-flex align-items-center">
                    <div>
                        <h3>Complete Farm Mechanization</h3>
                        <p>Our product portfolio covers Tillage, Haulage, Crop Protection, Harvest, Post-Harvest, Seeding & Plantation, Landscaping and other miscellaneous products.</p>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row py-3">
                <div class="col-md-6 ml-auto col-sm-8 col-12 d-flex align-items-center text-right">
                    <div>
                        <h3>World Wide Presence</h3>
                        <p>Our vast network of sales and after sales services has enabled us to successfully cater to the needs of the clients in a prompt and efficient manner. We have a huge clientage spread across nations.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/world-map-4.png" class="img-fluid"> </figure>
                </div>
            </div>

             <hr />

            <div class="row pt-3">
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/quality-standards.jpg" class="img-fluid"></figure>
                </div>
                <div class="col-md-6 col-sm-8 col-12  d-flex align-items-center">
                    <div>
                        <h3>International Quality Standards</h3>
                        <p>Stringent quality standards are followed by the company. We have been certified by ISO 9001: 2008, EMS 14001, OHSAS and CE.</p>
                    </div>
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