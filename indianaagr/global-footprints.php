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
                <h1 class="text-white heading-border">Global Footprints</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li>Global Footprints</li>
                    </ul>
                </div>
            </div>
            
            <div class="global-footprints pt-4 pb-5">
                
                <div class="row">

                    <div class="col-md-6 box">
                        <h2><img src="<?php echo CONFIG_PATH; ?>images/world.svg" alt="world">Overseas</h2>
                        <p class="top-para">Agrovision is a trusted brand by the farmers of more than 28 countries globally. Confirming our global acceptance and compatibility, we are also involved in consistent business across the globe. In order to cater to the ever-expanding demands of our global customers, our dedicated team works passionately to deliver superior quality products for our global audience. </p>
                        <p class="boxpara">Today the name Agrovision has become a synonym to exceptional and impeccable manufacturer of agriculture machinery across the world. Agrovision has always focused on customers and is committed to provide dedicated post sales services through its extensive network of competent & experienced after sales service team. Going forward, Agrovision continues with the spirit to explore unchartered territories and has aggressive plans to capture new avenues globally.</p>
                    </div>
                    
                    <div class="col-md-6">
                        <img src="images/world-map-3.png" class="img-fluid">
                    </div>

                    
                      <div class="col-md-12 mt-4">
                        <div class="row box box-left">
                                    <div class="col-lg-3 col-md-3">
                                        <ul class="list-inline">
                                            <li>Nepal</li>
                                            <li>Kenya</li>
                                            <li>Algeria</li>
                                            <li>Myanmar</li>
                                            <li>Nigeria </li>
                                            <li>Thailand </li>
                                            <li>New Zealand </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <ul class="list-inline">
                                            <li>Bangladesh</li>
                                            <li>Sri Lanka </li>
                                            <li>South Africa </li>
                                            <li>U.A.E.</li>
                                            <li>Papua New Guinea </li>
                                            <li>Philippines </li>
                                            <li>Vietnam </li>
                                             
                                        </ul>
                                    </div>
                                    <div class="col-lg-3 col-md-3">
                                        <ul class="list-inline">
                                            <li>Brazil </li>
                                            <li>Singapore </li>
                                            <li>Sudan</li>
                                            <li>Ethiopia</li>
                                            <li>Tanzania </li>
                                            <li>Ghana </li>
                                            <li>Namibia</li>
                                        </ul>
                                    </div>

                                    <div class="col-lg-3 col-md-3">
                                        <ul class="list-inline">
                                            <li>Swaziland</li>
                                            <li>Lesotho</li>
                                            <li>Mozambique</li>
                                            <li>Zimbabwe</li>
                                            <li>Botswana</li>
                                            <li>Zambia </li>
                                            <li>Angola</li>
                                        </ul>
                                    </div>
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