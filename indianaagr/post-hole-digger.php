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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    </head>
    <body>
       <?php require_once("header.php"); ?>
            <div class="protop-banner">
                <img src="images/product-banner.jpg" alt="post hole digger">
            </div>

            <div class="product-namesec" id="product-name">
                <div class="container home-ultra">
                    <div class="row py-4 align-items-center">
                        <div class="col-md-7">
                            <h1 class="heading-leaf heading-leaf-left text-uppercase">Post Hole Digger</h1>
                            <ul class="list-inline list-arrow pt-1">
                                <li>It is a PTO driven implement.</li>
                                <li>Fastest method to make pits / holes. </li>
                                <li>It can drill / dig holes of 6" , 9" , 12" , 18" and 24" diameter. </li>
                                <li>Robust and highly efficient gear box. </li>
                                <li>PTO shaft with shear bolt for overload protection. </li>
                                <li>Easy and quick attachment to tractor. </li>
                            </ul>
<!--                            <a href="#" class="btn btn-orange text-uppercase mt-4"><i class="far fa-file-pdf"></i> Get Brochure</a>-->
                        </div>
                        <div class="col-md-5 text-center">
                            <img src="images/post-hole-digger.png" alt="img" class="img-fluid">
                            <p>Available Shades</p>
                            <img src="images/shades.jpg" alt="shades">
                        </div>
                    </div>
                </div>
                <hr>
            </div>

            <div class="container">
                <div class="product-features" id="features">

                    <div class="inset">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="fealist pt-4">
                                    <div class="feaheading mb-4"><h2 class="heading-leaf heading-leaf-left">Features</h2></div>
                                    <figure class="text-center">
                                        <img src="images/post-hole-digger-features.png" class="img-fluid" alt="Desgined">
                                    </figure>
                                    <!--                                    <ul class="list-inline common-dot">
                                                                            <li>Designed for toughest operations</li>
                                                                            <li>Extra Heavy Duty Gear Box</li>
                                                                            <li>Shocker for vibration control</li>
                                                                            <li>Augur Angle Adjustment</li>
                                                                        </ul>-->
                                </div>
                            </div>
                            <div class="col-md-7 proslide-right p-4">
                                <div class="slider slider-for">
                                    <div>
                                        <h4 class="pb-4">Designed for toughest operations</h4>
                                        <img src="images/product-detail-1.png" alt="Disc Ridger" class="img-fluid">
                                    </div>
                                    <div>
                                        <h4 class="pb-4">Extra Heavy Duty Gear Box</h4>
                                        <img src="images/product-slide2.png" alt="Disc Ridger" class="img-fluid"></div>
                                    <div>
                                        <h4 class="pb-4">Shocker for vibration control</h4>
                                        <img src="images/product-slide3.png" alt="Disc Ridger" class="img-fluid">
                                    </div>
                                    <div>
                                        <h4 class="pb-4">Augur Angle Adjustment</h4>
                                        <img src="images/product-slide4.png" alt="Disc Ridger" class="img-fluid">
                                    </div>
                                </div>
                                <div class="slider slider-nav">
                                    <div><div class="imgout position-relative"><img src="images/product-detail-1.png" alt="Disc Ridger" class="img-fluid"></div></div>
                                    <div><div class="imgout position-relative"><img src="images/product-slide2.png" alt="Disc Ridger" class="img-fluid"></div></div>
                                    <div><div class="imgout position-relative"><img src="images/product-slide3.png" alt="Disc Ridger" class="img-fluid"></div></div>
                                    <div><div class="imgout position-relative"><img src="images/product-slide4.png" alt="Disc Ridger" class="img-fluid"></div></div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="product-spec py-5 mb-5" id="specs">
                    <h2 class="heading-leaf heading-leaf-left pb-4">Technical Specification</h2>
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-tb-sm font-italic">
                                <tr>
                                    <td class="text-red"><strong>Product Code</strong></td>
                                    <td class="text-red"><strong>A-PHD</strong></td>
                                </tr>
                                <tr>
                                    <td>Input Rpm</td>
                                    <td>540</td>
                                </tr>
                                <tr>
                                    <td>Gear Box</td>
                                    <td>Compatible with 90 HP Tractors (Max.)</td>
                                </tr>
                                <tr>
                                    <td>Main Frame Structure</td>
                                    <td>90 x 90 mm</td>
                                </tr>
                                <tr>
                                    <td>3 Point Linkage</td>
                                    <td>65 x 65 mm</td>
                                </tr>
                                <tr>
                                    <td>Bearings</td>
                                    <td>Taper Roller</td>
                                </tr>
                                <tr>
                                    <td>P.T.O</td>
                                    <td>Telescope Type with Shear Bolt</td>
                                </tr>
                                <tr>
                                    <td>Nut / Bolts</td>
                                    <td>High-Tensile</td>
                                </tr>
                                <tr>
                                    <td>Tractor Power Required</td>
                                    <td>35 HP & Above</td>
                                </tr>
                                <tr>
                                    <td>Approx Weight</td>
                                    <td>300 Kgs.</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <img src="images/video-blank.jpg" alt="video" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>

            <div class="product-notification text-center">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="mb-0"><em>* The Weight and working data contained are supplied for information only and are not binding. Specification ad size can be altered as a part of ongoing product modification/imporvement.</em></p>
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
        <script src="<?php echo CONFIG_PATH; ?>js/slick.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
        <script>
            //Product detial page slider
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                //fade: true,

                asNavFor: '.slider-nav'
            });

            $('.slider-nav').slick({
                slidesToShow: 4,
                asNavFor: '.slider-for',
                dots: false,
                centerMode: false,
                focusOnSelect: true
            });
        </script>
    </body>
</html>