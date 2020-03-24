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
        <link href="<?php echo CONFIG_PATH; ?>css/datepicker.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/menu.css">
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/custom.css">
    </head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        <!-- End footer -->
        
        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Sales in India</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li>Sales in India</li>
                    </ul>
                </div>
            </div>
            <div class="contactus pb-5 pt-4">
            <div class="contact-form">
            <form>
                <div class="contact-information common-form">
                    <div class="col-md-10 mx-auto">
                <div class="row form-outerbox">
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Name</label>
                        <input type="text" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Your Email</label>
                        <input type="text" class="form-control" placeholder="Your Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Company Email</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">Telephone</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label text-dark-light">Address</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">City</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="control-label text-dark-light">State</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group jointeam-radio col-md-12">
                        <label class="control-label text-dark-light d-block">Products are you interested:</label>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="interested" class="checked">
                        <label>Implements</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="interested" class="checked">
                        <label> Spare Parts</label>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="control-label text-dark-light">Describe Your Buying Requirements</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    
                    
                    <div class=" col-md-12 button text-center mt-3">
                        <input type="submit" value="Submit" class="btn btn-orange text-uppercase">
                    </div>
                   
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
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
        <script src="<?php echo CONFIG_PATH; ?>js/datepicker.js" type="text/javascript"></script>
        <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>
</html>