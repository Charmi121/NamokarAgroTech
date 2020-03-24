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
        <title>Namokar AgroTech</title>
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
                <h1 class="text-white heading-border">Vision & Mission</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-5">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li><a href="<?php echo CONFIG_PATH; ?>profile.php">About Us</a></li>
                        <li>vision & Mission</li>
                    </ul>
                </div>
            </div>
            <div class="about-vision">
                <div class="row">
                    <div class="col-md-4"><figure><img src="<?php echo CONFIG_PATH; ?>images/director.jpg" alt="director" class="img-fluid"></figure></div>
                <div class="col-md-8">
                    <h2>From The Director's Desk</h2>
                    <p>I am happy and proud to great you through this message Namokar AgroTech. Ltd. was established with the aim of providing quality agriculture farm implements, on par with international standards. In our pursuit of excellence, we persistently seek and adopt innovative methods to improve the quality of implements. </p>
                    <p>Namokar AgroTechhas always been dedicated to those who are linked to the land farmers, ranchers and landowners. And Agrovision has never outgrown, nor forgotten, its founder's original core values: integrity, quality, commitment and innovation. Those values determine the way we work, the quality we offer, and the unsurpassed treatment you get as a custormer. </p>
                    <p>The young and dedicated team of professional workers round the clock to deliver result oriented services at economical prices to Agrovision's custormers.</p>
                    <p><strong class="d-block">Mrs. N.D. JANGID</strong></p>
                </div>
                </div>
                <hr />
                <div class="row text-center abvimi py-5">
                    <div class="col-md-6 box">
                        <i><img src="<?php echo CONFIG_PATH; ?>images/vision.svg" alt="vision"></i>
                        <h3 class="pt-3">Vision</h3>
                        <p>To become the world's leading agriculture farm machinery / Implements Company and a major player in agriculture sector.</p>
                        <p>To provide value for money to the customers by producing high quality innovative products at competitive price.</p>
                    </div>
                    <div class="col-md-6 box">
                        <i><img src="<?php echo CONFIG_PATH; ?>images/mission.svg" alt="mission"></i>
                        <h3 class="pt-3">Mission</h3>
                        <p>Our mission is to manufacture & supply the most technologically advanced agricultural farm implements worldwide, with acknowledged reliability, outstanding quality and with support by excellent services.</p>
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