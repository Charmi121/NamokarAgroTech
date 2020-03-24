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
                <h1 class="text-white heading-border">Privacy Policy</h1>
            </div>
        </div>
        <div class="about-profile">
        
        <div class="container">
            <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li>Privacy Policy</li>
                        </ul>
                    </div>
                </div>
            <div class="row pb-5 pt-0 content-page">
                <div class="col-md-12">
                    <div class="pb-4">
                        <p>Thank you for visiting www.indiaagrovision.com. We utmost respect your privacy and consider it to be a pertinent element of our business. This privacy policy statement applies to www.indiaagrovision.com only. It does not apply to information collected and stored by means other than the website. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Privacy of Personal Information</h3>
                    <p>With due respect to the privacy of its users, India Agrovision Implements Pvt. Ltd. website (http://www.indiaagrovision.com) abstains from getting personal information from users without their denotative consent. India Agrovision Implements Pvt. Ltd. does not distribute, sell or rent any personal information collected via its website. This is also true for personal information (email address, postal address, etc.) sent to the website’s email addresses, contact notes. India Agrovision Implements Pvt. Ltd. does not send unsolicited emails to users of its site and the personal information entered via the site’s registration forms such as, feedback form, complaint form etc., is protected by security features. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">On-line surveys</h3>
                    <p>For better understanding the needs and profile of our visitors we conduct on-line surveys. When we conduct the survey, we will try to let you know how we shall use said information at the time of collecting information from you on the Internet. However the same is not obligatory on our part. You recognize and understand that there is no compulsion on your part to provide us with your personal information and all personal information provided by you to us is with your full consent, own will and desire to provide such personal information. You also understand that we are under no obligation to verify the source from which the personal information about you is provided to us and is deemed to be provided by you. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Links to other websites</h3>
                    <p>India Agrovision Implements Pvt. Ltd. website may contain links to other sites and we try to link only those sites that share our high standards and respect for privacy. We are not responsible for the content or the privacy practices used by other sites. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Changes to the "Privacy Statement"</h3>
                    <p>With effect from the future, India Agrovision Implements Pvt. Ltd. reserves the right to change this privacy statement from time to time. For material changes to this privacy statement, we will notify placing a notice on this Web Site. </p>
                    </div>
                    <div class="pb-4">
                    <h3 class="h3">Security</h3>
                    <p>India Agrovision Implements Pvt. Ltd. endeavors to take reasonable and appropriate measures to protect your personal information from unauthorized access or disclosure. However, we do not warrant or represent that your personal information is completely safe from hackers and other security threats.</p>
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