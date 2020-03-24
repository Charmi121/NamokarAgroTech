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
                <h1 class="text-white heading-border">Join Agrovision Team</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb mb-4">
                        <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                        <li><a href="<?php echo CONFIG_PATH; ?>contact-us.php">Contact Us</a></li>
                        <li>Join Us</li>
                    </ul>
                </div>
            </div>
            <div class="contactus pb-5 pt-4">
            <div class="contact-form">
            <form>
                <div class="contact-information">
                <div class="row">
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="First Name">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group col-md-4">
                     
      <label class="sr-only" for="inlineFormInputGroup">Username</label>
      <div class="input-group mb-2" id="datetimepicker1">
          <input type="text" class="form-control" id="datepicker" placeholder="Date of Birth">
      </div>
  
                    </div>
                    <div class="form-group jointeam-radio col-md-4">
                        <p class="mb-1">Gender</p>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="gender" class="checked">
                        <label>Male</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="gender" class="checked">
                        <label>Female</label>
                        </div>
                    </div>
                    <div class="form-group jointeam-radio col-md-4">
                        <p class="mb-1">Marital Status:</p>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="married" class="checked">
                        <label>Single</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="married" class="checked">
                        <label>Married</label>
                        </div>
                    </div>
                    <div class="form-group jointeam-radio col-md-4">
                        <p class="mb-1">Any Disabled:</p>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="disabled" class="checked">
                        <label>Yes</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="disabled" class="checked">
                        <label>No</label>
                        </div>
                    </div>
                    <div class="form-group jointeam-radio col-md-4">
                        <p class="mb-1">Can you travel:</p>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="travel" class="checked">
                        <label>Yes</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="travel" class="checked">
                        <label>No</label>
                        </div>
                    </div>
                    <div class="form-group jointeam-radio col-md-4">
                        <p class="mb-1">Criminal Record:</p>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="record" class="checked">
                        <label>Yes</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="record" class="checked">
                        <label>No   </label>
                        </div>
                    </div>
                    <div class="form-group jointeam-radio col-md-4">
                        <p class="mb-1">Diriving License:</p>
                        <div class="custom-checkbox checked-radio">
                            <input type="radio" name="Diriving" class="checked">
                        <label>Yes</label>
                        </div>
                        <div class="custom-checkbox checked-radio">
                        <input type="radio" name="Diriving" class="checked">
                        <label>No</label>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Weight">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Height">
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control">
                            <option>Blood Group</option>
                            <option>A Positive</option>
                            <option>A Negative</option>
                            <option>A Unknown</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control">
                            <option>Post applied for</option>
                            <option>Engineer</option>
    <option>Lathe</option>
    <option>Welding</option>
    <option>Operator</option>
    <option>Driver</option>
    <option>Worker</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control">
                            <option>Veteran Status</option>
                            <option>Postponed</option>
    <option>Free</option>
    <option>I Did</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control">
                            <option>Any friend at our company</option>
                            <option>No</option>
                            <option>Yes</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Your Education">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Experience">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Your E-mail">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Street Address">
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control">
                            <option>Country</option>
                            <option>India</option>
                            <option>Aus</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select class="form-control">
                            <option>State</option>
                            <option>Assam</option>
                            <option>Bihar</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" class="form-control" placeholder="Mobile">
                    </div>
                    <div class="form-group col-md-4">
                       <div class="custom-file">
  <input type="file" class="custom-file-input" id="customFileLang" lang="es">
  <label class="custom-file-label" for="customFileLang">Attach Resume</label>
</div>
                        <small class="d-block pt-2">NOTE: Supports only pdf, jpg,txt & doc file format.</small>
                    </div>
                    <div class="d-flex flex-wrap bottom justify-content-between align-items-center mt-3">
                        <div class="col-md-6">
                            <div class="custom-checkbox">
                                 <input type="checkbox" class="checked">
                        <label>I agree to the accuracy of my information</label>
                        </div>
                            </div>
                        <div class="col-md-6 d-flex justify-content-end">
                            <input type="submit" value="Submit" class="btn btn-orange text-uppercase">
                        </div>
                    </div>
                    
                    
                    
                    
                    
                </div></div>
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