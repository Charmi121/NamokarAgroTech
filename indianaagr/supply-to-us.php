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
        <link rel="stylesheet" type="text/css"  href="css/smart-forms.css">
		<style>
		.error { color: red !important; }
		</style>
    </head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        <!-- End footer -->
        
        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Supply to Us</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li><a href="<?php echo CONFIG_PATH; ?>contact-us.php">Contact Us</a></li>
                        <li>Supply to Us</li>
                    </ul>
                </div>
            </div>
            <div class="contactus pb-5 pt-4">
            
            <div class="smart-forms">
                <?php if(isset($_SESSION['email_sent']) && $_SESSION['email_sent'] == 1){ ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Success!</h4>
                            Your Query sent successfully.
                        </div>
                        <div class="clearfix"></div>
                <?php unset($_SESSION['email_sent']); } 
				else if(isset($_SESSION['email_sent']) && $_SESSION['email_sent'] == 2){ ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Error!</h4>
                            Robot verification failed, please try again..
                        </div>
                        <div class="clearfix"></div>
                <?php unset($_SESSION['email_sent']); } ?>
            <form id="contactform" name="contactform"  action="supply-to-us-save.php" method="post" autocomplete="off">    
                <div class="contact-information common-form">
                    <div class="col-md-6 mx-auto">
                <div class="row form-outerbox">
                    <div class="form-group col-md-12 text-left">
                        <h3>Query form</h3>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="field prepend-icon">
                            <input class="gui-input required " type="text" name="first_name" id="first_name"  title="Please enter first name" maxlength="150" placeholder="Name"/>
                            <span class="field-icon"><i class="fa fa-user"></i></span>  
                        </label>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="field prepend-icon">
                            <input class="form-control required " type="text" name="last_name" id="last_name"  title="Please enter last name" maxlength="150"  placeholder="Last Name"/>
                            <span class="field-icon"><i class="fa fa-user"></i></span>  
                        </label>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="field prepend-icon">
                            <input class="form-control required email" type="text" name="email" id="email"  title="Please enter email address" maxlength="150" placeholder="Your Email"/>
                            <span class="field-icon"><i class="fa fa-envelope"></i></span>  
                        </label>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="field prepend-icon">
                            <input class="form-control required number" type="text" name="mobile" id="mobile"  title="Please enter mobile" maxlength="150" placeholder="Mobile/Phone"/>
                            <span class="field-icon"><i class="fa fa-mobile"></i></span>  
                        </label>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="field prepend-icon">
                            <input class="form-control  required" type="text" name="company_name" id="company_name"  title="Please enter company name" maxlength="150" placeholder="Company Name"/>
                            <span class="field-icon"><i class="fa fa-globe"></i></span>  
                        </label>
                    </div>

                    <div class="form-group col-md-12">
                        <label class="field prepend-icon">
                            <input class="form-control " type="text" name="website" id="website"  title="Please enter website" maxlength="150" placeholder="Company Website"/>
                            <span class="field-icon"><i class="fa fa-globe"></i></span>  
                        </label>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label class="field prepend-icon">
                            <textarea class="gui-textarea required" id="comment" name="comment" placeholder="Query"></textarea>
                            <span class="field-icon"><i class="fa fa-comments"></i></span>
                        </label>
                    </div>
					<div class="form-group col-md-6">
								<div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>								
					</div>
                    <div class=" col-md-12 text-left mt-0">
                        <input type="submit" value="Submit" class="btn btn-orange text-uppercase text-white">
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
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
         <script type="text/javascript" src="js/jquery.validate.js" charset="utf-8"></script>
        <script type="text/javascript">
                $('#contactform').validate();
        </script>
    </body>
</html>