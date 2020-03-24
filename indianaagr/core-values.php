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
                <h1 class="text-white heading-border">Core Values</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-5">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li><a href="<?php echo CONFIG_PATH; ?>profile.php">About Us</a></li>
                        <li>Core Values</li>
                    </ul>
                </div>
            </div>
            <!-- <div class="about-team pb-5">
                <div class="row">
                    <div class="col-md-6"><figure class="figure-innerborder position-relative"><img src="<?php echo CONFIG_PATH; ?>images/our-team.jpg" alt="director" class="img-fluid"></figure></div>
                <div class="col-md-6">
                    <h2>Core Values</h2>
                    <p>All the activities of our company are performed by a team of diligent and dedicated professionals that has the requisites to do so. The members of our team work in sync with each other to make sure that none of their efforts is in vain. The team work of these professionals leads to the accomplishment of our organization’s goals. Further, the management conducts various training sessions and workshops for our professionals. These sessions keep the team abreast with the latest methodologies and technologies of our domain. Our team includes the following professionals:</p>
                    <ul class="list-inline list-dot font-weight-500">
                        <li>Engineers</li>
                        <li>Quality Controllers</li>
                        <li>R & D Experts</li>
                        <li>Trade & Marketing Experts</li>
                        <li>Skilled & Semi Skilled Workers</li>
                    </ul>
                </div>
                </div>
            </div> -->

            <div class="row pb-3">
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/integrity.jpg" class="img-fluid"></figure>
                </div>

                <div class="col-md-6 col-sm-8 col-12 d-flex align-items-center">
                    <div>
                        <h3>INTEGRITY</h3>
                        <p>We conduct our business in accordance with the highest standards of professional behavior and ethics. We are transparent, honest and ethical in all our interactions with employees, clients, consumers, vendors and the public.</p>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row py-3">
                <div class="col-md-6 ml-auto col-sm-8 col-12 d-flex align-items-center text-right">
                    <div>
                        <h3>QUALITY</h3>
                        <p>We take pride in providing high value products and services that we stand behind, which ensures customer satisfaction, profitability and the future of our employees and our growth.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/quality-1.jpg" class="img-fluid"> </figure>
                </div>
            </div>

             <hr />

            <div class="row pt-3">
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/commitment.jpg" class="img-fluid"></figure>
                </div>
                <div class="col-md-6 col-sm-8 col-12  d-flex align-items-center">
                    <div>
                        <h3>COMMITMENT</h3>
                        <p>Commitment comes to life through being passionate about solving complex business problems and helping shape the next generation of financial services. We are intensely focused on serving our customers and helping them achieve their objectives. We do what we say we are going to do. As individuals and as an organization, we create value.</p>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row py-3">
                <div class="col-md-6 ml-auto col-sm-8 col-12 d-flex align-items-center text-right">
                    <div>
                        <h3>INNOVATION</h3>
                        <p>We foster a work environment where creative thinking is encouraged and rewarded in order to create opportunities for process improvement and more cost-effective sustainable products and services, providing value to the Company and our customers.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/innovation1.jpg" class="img-fluid"> </figure>
                </div>
            </div>

            <hr />

            <div class="row pt-3">
                <div class="col-md-3 col-sm-4 col-12">
                    <figure><img src="images/customer-care.jpg" class="img-fluid"></figure>
                </div>
                <div class="col-md-6 col-sm-8 col-12  d-flex align-items-center">
                    <div>
                        <h3>CUSTOMER CARE</h3>
                        <p>We strive to provide exceptional customer service through flexible scheduling, quality products, efficient services, and innovative solutions resulting in value to the customer and company.</p>
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