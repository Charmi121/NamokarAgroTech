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
        <link rel="stylesheet" href="<?php echo CONFIG_PATH; ?>css/bootstrapfonts.css">
        <link href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" async="async" rel="stylesheet">
        <style>
		.error{ color: red; }
		</style>
    </head>
    <body>
        <!-- Start footer -->
        <?php require_once("header.php"); ?>
        <!-- End footer -->
        
        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Customer Survey</h1>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li>Customer Survey</li>
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
                            Your customer survey sent successfully.
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
			<form id="contactform" name="contactform"  action="customer-survey-save.php" method="post" autocomplete="off"> 
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-uppercase"> Agrovision Customer Survey</h3>
                        <p>We ask for your personal information for our purposes only. We will never sell your information or share it with anyone outside of Agrovision .However, we may want to contact you regarding something you've shared in this survey.</p>
                    </div>
                </div>

                <div class="py-4">
                    <hr />
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Customer Information</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-6">
                                <label>First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" id="first_name" class="form-control required" title="Please enter first name" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" id="last_name" class="form-control required" title="Please enter last name" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email Address <span class="text-danger">*</span></label>
                                <input type="text" name="email" id="email" class="form-control required email" title="Please enter email" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" id="phone" class="form-control required number" title="Please enter phone no" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address 1 </label>
                                <input type="text" name="add1" id="add1" class="form-control required" title="Please enter address" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address 2 </label>
                                <input type="text" name="add2" id="add2" class="form-control" title="Please enter address" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>City <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city" class="form-control required" title="Please enter city" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>State <span class="text-danger">*</span></label>
                                <input type="text" name="state" id="state" class="form-control required" title="Please enter state" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>ZIP / Postal Code</label>
                                <input type="text" name="post_code" id="post_code" maxlength="6" class="form-control required number" title="Please enter Postal Code" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Country <span class="text-danger">*</span></label>
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
                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Product Information </span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-6">
                                <label>Product Name / Model Number <span class="text-danger">*</span></label>
                                <input type="text" name="prod_name" id="prod_name"  class="form-control required" title="Please enter product name" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Serial Number</label>
                                <input type="text" name="serial_no" id="serial_no"  class="form-control" title="Please enter serial number" placeholder="">
                            </div>
                            <div class="form-group col-md-6">
                                <label>When was your approximate date of purchase?</label>
                                <input type="text" name="date_purchase"  class="form-control" id="datepicker"  placeholder="">
                            </div>
                                                 
                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Branding</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label>How did you learn about the Agrovision brand for the product you purchased?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="abrand_opt[]" value="Dealer"> Dealer</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="abrand_opt[]" value="Magazine Advertisement"> Magazine Advertisement</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="abrand_opt[]" value="Internet"> Internet</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="abrand_opt[]" value="Prior Agrovision Purchase"> Prior Agrovision Purchase</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="abrand_opt[]" value="Other"> Other</label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Did your dealer give you other brand options to choose from?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="dbrand_opt[]" value="Yes"> Yes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="dbrand_opt[]" value="No"> No</label>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </div>


                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Product</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label>How do you rate the fit and finish of Agrovision product as you took delivery.</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt[]" value="Great"> Great</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt[]" value="Good"> Good</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt[]" value="Average"> Average</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt[]" value="Disappointing"> Disappointing</label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>If you have used Agrovision implement, are you pleased?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt1[]" value="Yes"> Yes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt1[]" value="No"> No</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="prod_opt1[]" value="Not Yet Used"> Not Yet Used</label>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Purchase</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label>Have you purchased Agrovision implements before?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="purchase_opt[]" value="Yes"> Yes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="purchase_opt[]" value="No"> No</label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>If you have used Agrovision implement, are you pleased?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="purchase_opt1[]" value="Yes"> Yes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="purchase_opt1[]" value="No"> No</label>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Operator's Manual</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label>Did you find the Operator’s Manual helpful?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="operat_opt[]" value="Yes"> Yes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="operat_opt[]" value="No"> No</label>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Was the Operator’s Manual in good shape upon delivery to you?</label>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="shape_opt[]" value="Yes"> Yes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" name="shape_opt[]" value="No"> No</label>
                                </div>
                            </div>

                        </div>
                    </fieldset>
                </div>

                <div class="fieldset">
                    <fieldset>
                        <legend><span class="fieldset-legend">Comments</span></legend>
                        <div class="row p-3">
                            <div class="form-group col-md-12">
                                <label>Comments</label>
                                <textarea class="form-control" name="comments" id="comments" style="min-height:130px;"></textarea>
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
        <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />

        <script>
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap'
            });
       </script> 
	   <script type="text/javascript" src="js/jquery.validate.js" charset="utf-8"></script>
        <script type="text/javascript">
                $('#contactform').validate();
        </script>
       
    </body>
</html>