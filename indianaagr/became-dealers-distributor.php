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
        <title>Agrovision Contact us</title>
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
                <h1 class="text-white heading-border">Distributorship Enquiry Form</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li>Distributorship Enquiry Form</li>
                    </ul>
                </div>
            </div>
            <div class="contactus pb-5 pt-4">
            
            <div class="contact-form dealer-form">
            <form>            
                <div class="contact-information common-form">
                    <div class="col-md-10 mx-auto">
                <div class="row form-outerbox">
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Name <span class="text-red">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Organization Name <span class="text-red">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Email ID <span class="text-red">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Phone Number <span class="text-red">*</span></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Website</label>
                        <input type="text" class="form-control" placeholder="www.">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Select Country <span class="text-red">*</span></label>
                        <select class="form-control">
                                <option>Select Country</option>
                                <option>India</option>
                                <option>UK</option>
                                <option>USA</option>
                                <option>Australia</option>
                            </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Models of Interest</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Enter Captcha <span class="text-red">*</span></label>
                        <div class="captcha position-relative">
                                <input type="text" class="form-control" placeholder="Enter Captcha">
                                <img src="<?php echo CONFIG_PATH; ?>images/code.jpg" alt="code" class="position-absolute">
                                <i class="fas fa-sync position-absolute"></i>
                            </div>
                    </div>
                   
                    <div class="col-md-12 text-center mt-4"><input type="submit" class="btn btn-orange text-uppercase" value="Submit"></div>
                    
                    
                    
                    
                    
                </div>
                        </div>
                </div>
                </form>
        </div></div>
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