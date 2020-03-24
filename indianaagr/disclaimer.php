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
                <h1 class="text-white heading-border">Disclaimer</h1>
            </div>
        </div>
        <div class="about-profile">
        
        <div class="container">
            <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li>Disclaimer</li>
                        </ul>
                    </div>
                </div>
            <div class="row pb-5 pt-0 content-page">
                <div class="col-md-12">
                    <div class="pb-4">
                    <h3 class="h3">Legal Disclaimer</h3>
                    <p>All the content but not limited to text, graphics, designs and trademarks of this site is &copy; India Agrovision Implements Pvt. Ltd. You may download the content only for your personal use and for non-commercial purposes only. Modification of content or further reproduction or incorporation in any work, publication or site whether in hard copy or electronic format including postings to any other site is strictly prohibited and India Agrovision Implements Pvt. Ltd. reserves all other rights. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">E-Mail Disclaimer</h3>
                    <p>The information in this e-mail, and any attachments therein, is privileged and confidential and for use by the addressee only. If you are not the intended recipient, please return the e-mail to the sender and delete it from your computer. If you have received this communication in error, please be informed that any review, dissemination, distribution, or copying of this message is strictly prohibited.</p>
                    <p>The sender confirms that and India Agrovision Implements Pvt. Ltd. shall not be responsible if this email message is used for any indecent, unsolicited or illegal purposes, which are in violation of any existing laws and the same shall solely be the responsibility of the sender and that India Agrovision Implements Pvt. Ltd. shall at all times be indemnified of any civil and/ or criminal liabilities or consequences thereof.</p>
                    <p>Although we attempt to sweep e-mail and attachments for viruses, we do not guarantee that either are virus-free and accept no liability for any damage sustained as a result of viruses.</p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Designs, Specifications &AMP; Features</h3>
                    <p>Designs, specifications, features and information are subject to change without notice. Specifications and features typically describe current production models.</p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Photos</h3>
                    <p>Products may be shown with optional equipment. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Models</h3>
                    <p>There may be models listed here that are no longer in production. However, there may be field inventory available for sale from dealers. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Warranty</h3>
                    <p>Warranty periods may change on certain products. Any warranty period described herein, pertains to models currently in production. </p>
                    <p>India Agrovision Implements Pvt. Ltd. assumes no responsibility for errors or omissions. Neither is any liability assumed for damages resulting from the use of the information contained herein. India Agrovision Implements Pvt. Ltd. reserves the right to revise and improve its products as it sees fit. This website describes the state of this product at the time of its publication, and may not reflect the product in the future.</p>
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