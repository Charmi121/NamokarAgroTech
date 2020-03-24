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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/aos.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    </head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        <!-- End footer -->

        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Milestones</h1>
            </div>
        </div>
        <div class="about-profile">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li>Milestones</li>
                        </ul>
                    </div>
                </div>
                <div class="row pb-5 pt-0 milestones">
                    <div class="col-md-12">

                        <div class="timeline">
                            <h2>2008</h2>

                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>

                            <h2>2009</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2010</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2011</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2012</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2013</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2014</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2015</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2016</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
                            <h2>2017</h2>
                            <ul>
                                <li class="d-flex" data-aos="fade-right" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/tilage.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                                <li class="d-flex" data-aos="fade-left" data-aos-once="true">
                                    <figure class="mr-2"><img src="<?php echo CONFIG_PATH; ?>images/posthar.png" alt="crop"></figure>
                                    <p>Established a new modern facility spread over the area of 20,000 sq. mtrs.</p>
                                </li>
                            </ul>
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
        <script src="<?php echo CONFIG_PATH; ?>js/aos.js"></script>
        <script>AOS.init();</script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>
</html>