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
$response = array();

$response['meta_title'] = 'Search Product - '.STORE_WEBSITETITLE;
$response['meta_keyword'] = "";
$response['meta_description'] = "";
$response['is_error'] = 1;
header("HTTP/1.0 404 Not Found");

$keyword = (!empty($_POST['keyword'])) ? $_POST['keyword'] : '';

$pageURL = $custom->getPageURL();
$currentURL = 'product-search.html';
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo STORE_METATITLE; ?></title>
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
        <?php echo STORE_GOOGLEANALYTICS; ?>
    </head>

    <body>
        <header>
                    <?php require_once("header.php"); ?>
        </header>

        <section class="page-section clearfix">
            <div class="mt-2 clearfix">
                <div class="container">
                    <div class="clearfix">
                        <div class="row">
                            <div class="col-md-4">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="breadcrumb mb-5">
                                    <li><a href="<?php echo CONFIG_PATH; ?>">Home</a></li>
                                    <li>Search Product
                                        <?php if(isset($keyword)) { echo 'for "'.$keyword.'"'; } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>                    

                        <?php
                            $params = array();
                            $params['keyword'] = $keyword;
                            $rsproducts = $product->getSearchProducts($params);
                            if (count($rsproducts) > 0) {
                            ?>
                            <div class="product-display">
                                <div class="row">
                                    <?php
                                    foreach ($rsproducts as $rowproduct) {
                                        $rsproductimages = $product->getProductMainImage($rowproduct['id']);
                                        if (!empty($rsproductimages)) {
                                            foreach ($rsproductimages as $rowproductimage) {
                                                ?>
                                                <div class="col-md-3 col-sm-3 col-xs-12 text-center mb-1 child">
                                                    <div class="product-section clearfix mb-2">
                                                        <figure class="d-flex align-items-center justify-content-center mb-0"><a href="<?php echo CONFIG_PATH; ?>product/<?php echo $rowproduct['seo_url']; ?>.html"><img src="<?php echo $custom->showImagePath("products", $rowproductimage['medium_image']); ?>" class="img-fluid"></a>
                                                        </figure>
                                                        <div class="text-uppercase h5"><a href="<?php echo CONFIG_PATH; ?>product/<?php echo $rowproduct['seo_url']; ?>.html"><?php echo $rowproduct['product_name']; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }else{ ?>
                        <div class="text-center text-muted" style="padding: 40px 0 70px 0; font-size: 20px">No Record Found</div>
                        <?php }  ?>
                    </div>
                </div>
            </div>
        </section>

        <footer>
<?php require_once("footer.php"); ?>
        </footer>
        <!-- JavaScript -->
        <script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>

</html>