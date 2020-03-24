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
                <h1 class="text-white heading-border">Contact Us</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li>Contact Us</li>
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
                <div class="row contact-office">
                    <div class="col-md-6 col-12">
                        <div class="box">
                            <h3 class="h3">Manufacturing & Sales</h3>
                            <div class="one">
                                <ul class="list-inline">
                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-12">
                                                <Address>Address:</Address>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <p><strong>India Agrovision Implements Pvt. Ltd.</strong>
                                                    <br />
                                                    PA-010-007 & 008, Light Eng. Zone (SEZ), 
                                                    Mahindra World City, Th. Sanganer,
                                                    Jaipur – 302037 (Rajasthan) INDIA
                                                </p>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-12">
                                                <Address>Telephone:</Address>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <p><a href="<?php echo CONFIG_PATH; ?>tel:+91-99290 52289">+91-99290 52289</a>, <a href="<?php echo CONFIG_PATH; ?>+91-96364 94375">+91-96364 94375</a>
                                                </p>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-12">
                                                <Address>Email:</Address>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <p><a href="<?php echo CONFIG_PATH; ?>mailto:info@indiaagrovision.com">info@indiaagrovision.com</a></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <div class="mb-0 pl-2">
                                    <a class="btn btn-primary small text-uppercase map-btn" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        Map View
                                    </a>
                                </div>
                                <div class="collapse pl-1 pt-1" id="collapseExample">
                                    <div class="card card-body p-0 mb-4">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56944.16007010618!2d75.67748804530261!3d26.871423235110075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c358b2c90123f%3A0x9686433abbbdf693!2sIndia+Agrovision+Implements+Private+Limited!5e0!3m2!1sen!2sin!4v1547903747605" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>                            
                        </div>

                        <div class="clear"></div>

                         <div class="clear"></div>

                        <div class="box">
                            <h3 class="h3">Registered / Corporate Office</h3>
                            <div class="one">
                                <ul class="list-inline">
                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-12">
                                                <Address>Address:</Address>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <p><strong>India Agrovision Implements Pvt. Ltd.  </strong>
                                                    <br />
                                                   Jaipur – Sikar Highway, Rampura, Jaipur – 303704 (Rajasthan) INDIA 
                                                </p>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-12">
                                                <Address>Telephone:</Address>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <p><a href="<?php echo CONFIG_PATH; ?>tel:+91-99290 52289">+91-99290 52289</a>, <a href="<?php echo CONFIG_PATH; ?>+91-96364 94375">+91-96364 94375</a></p>
                                            </div>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="row">
                                            <div class="col-md-2 col-12">
                                                <Address>Email:</Address>
                                            </div>
                                            <div class="col-md-10 col-12">
                                                <p><a href="<?php echo CONFIG_PATH; ?>mailto:info@indiaagrovision.com">info@indiaagrovision.com</a></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-3">
                                <div class="mb-0 pl-2">
                                    <a class="btn btn-primary small text-uppercase map-btn" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample2">
                                        Map View
                                    </a>
                                </div>
                                <div class="collapse pl-1 pt-1" id="collapseExample2">
                                    <div class="card card-body p-0 mb-4">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d56944.16007010618!2d75.67748804530261!3d26.871423235110075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c358b2c90123f%3A0x9686433abbbdf693!2sIndia+Agrovision+Implements+Private+Limited!5e0!3m2!1sen!2sin!4v1547903747605" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12 contact-form">
                        <form id="contactform" name="contactform"  action="contact-us-save.php" method="post" autocomplete="off">
                        <div class="form-group">
                            <h2 class="h3 text-left pb-2">Business Enquiry Form</h2>
                            <h4 class="h5 mb-2">Describe Your Buying Requirements in Detail</h4>
                            <textarea class="form-control mb-4 required" name="requirement" title="Please enter requirement" ></textarea>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input class="form-control required " type="text" name="first_name" id="first_name"  title="Please enter first name" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input class="form-control required " type="text" name="last_name" id="last_name"  title="Please enter last name" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>E-mail</label>
                                <input class="form-control required email" type="text" name="email" id="email"  title="Please enter email address" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Company Name</label>
                                <input class="form-control  " type="text" name="company_name" id="company_name"  title="Please enter company name" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Website</label>
                                <input class="form-control required url" type="text" name="website" id="website"  title="Please enter website" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Street Address</label>
                                <input class="form-control required " type="text" name="street_address" id="street_address"  title="Please enter street address" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>City</label>
                                <input class="form-control required " type="text" name="city" id="city"  title="Please enter city" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>State</label>
                                <input class="form-control required " type="text" name="state" id="state"  title="Please enter state" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Postal Code</label>
                                <input class="form-control required " maxlength="6" type="text" name="post_code" id="post_code"  title="Please enter post code" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Country</label>
                                <select class="form-control required" name="country" title="Please select country" >
                                    <option value="">Country</option>
									<?php 
									 $sql=	$fpdo->from("tblcountries");
									 $res=	$sql->fetchAll();
									 foreach($res as $row)
									 {
									?>
                                    <option value="<?=$row['countryname'];?>"><?=$row['countryname'];?></option>
									 <?php } ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Telephone</label>
                                <input class="form-control required number" type="text" name="telephone" id="telephone"  title="Please enter telephone" maxlength="150"/>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mobile</label>
                                <input class="form-control required number" type="text" name="mobile" id="mobile"  title="Please enter mobile" maxlength="150"/>
                            </div>
                             <div class="form-group col-md-6">
                            <div class="g-recaptcha" data-sitekey="<?php echo SITE_KEY; ?>"></div>	
							
							</div>
                            <div class="d-flex flex-wrap bottom justify-content-between align-items-center mt-3">
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
                        </div>
                        </form>
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
		<script src='https://www.google.com/recaptcha/api.js'></script>
        <script type="text/javascript" src="js/jquery.validate.js" charset="utf-8"></script>
        <script type="text/javascript">
                $('#contactform').validate();
        </script>
    </body>
</html>