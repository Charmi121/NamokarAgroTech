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
                <h1 class="text-white heading-border">Partner with Us</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li>Partner with Us</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="container">
			     <?php if(isset($_SESSION['email_sent']) && $_SESSION['email_sent'] == 1){ ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Success!</h4>
                            Your requirement sent successfully.
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
                <div class="row">
                    <div class="col-12">
                        <h3>Become a Dealer/ Distributorship</h3>
                        <p>Our dealers are the lifeblood of our business. They know we will stand behind our products, which gives them the confidence to make a commitment to their customers.</p>
                    </div>
                </div>

                <div class="py-4">
                    <hr />
                </div>
                <form id="contactform" name="contactform"  action="partner-with-us-save.php" method="post" autocomplete="off">
                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Contact Information</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input type="text"  name="first_name" id="first_name" class="form-control required" title="Please enter first name" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control required" title="Please enter last name" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input type="text" name="title" id="title" class="form-control required" title="Please enter Title" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Dealership Name </label>
                                <input type="text" name="dealer_name" id="dealer_name" class="form-control required" title="Please enter Dealership name" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address 1 </label>
                                <input type="text" name="add1" id="add1" class="form-control required" title="Please enter address" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address 2 </label>
                                <input type="text" name="add2" id="add2" class="form-control" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input type="text" name="city" id="city" class="form-control required" title="Please enter city" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>State</label>
                                <input type="text" name="state" id="state" class="form-control required" title="Please enter state"  placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Postal Code</label>
                                <input type="text" name="post_code" id="post_code" maxlength="6" class="form-control required" title="Please enter Postal Code"  placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control required number" title="Please enter Phone" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control required email" title="Please enter email" placeholder="">
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Dealership Details</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-6">
                                <label>Major Product line </label>
                                <input type="text" name="mpline" id="mpline" class="form-control required" title="Please enter Product line" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Shortlines </label>
                                <input type="text" name="shortline" id="shortline" class="form-control" title="Please enter Shortlines" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>with Number of Products Sold Annually</label>
                                <input type="text" name="sold_annual" id="sold_annual" class="form-control"  placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Annual Dealership Sales </label>
                                <input type="text" name="annual_sale" id="annual_sale" class="form-control" placeholder="">
                            </div>                        
                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Questions or Comments</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label>Please include any questions, comments or details below </label>
                                <textarea name="quest" id="quest" class="form-control required" title="Please include any questions, comments or details" style="min-height:130px;"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>
                 <div class="form-group col-md-6">
								<div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>								
							</div>
                <div class="row">
				 <div class="col-md-12 pb-3">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" class="checked" name="send_me_equiry" value="1">
                                        <label>Send me a copy of this enquiry</label>
                                    </div>
                                </div>
                    <div class="col-md-12">
                        <input type="submit" value="Submit" class="btn btn-orange text-uppercase">
                    </div>
                </div>
               </form>
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
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script type="text/javascript" src="js/jquery.validate.js" charset="utf-8"></script>
        <script type="text/javascript">
                $('#contactform').validate();
        </script>
    </body>
</html>