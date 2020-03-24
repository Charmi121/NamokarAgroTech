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
                
               
                <div class="common-form contact-information">	 
                    <h2 class="mb-4 pb-2 h3 text-center">Tell us about yourself we will contact you for relevant vacancies.</h2>
                    <form name="frmcareer" id="frmcareer" method="post" action="careers-save.html" autocomplete="off" novalidate="novalidate" enctype="multipart/form-data">
						<input type="hidden" name="token" id="token" value="" />
						<input type="hidden" name="page_url" id="page_url" value="" />
                        <div class="col-md-10 mx-auto">
                            <div class="row">
                                <div class="row" style="background: #efefef; padding:2rem; border-radius:10px; border: solid 1px #ddd;">
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="full_name">Name<span class="text-red">*</span></label>
                                            <input type="text" name="full_name" id="full_name" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="email">Email<span class="text-red">*</span></label>
                                            <input type="text" name="email" id="email" class="form-control input-md input-filed email required" value="" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="age">Age/DOB<span class="text-red">*</span></label>
                                            <input type="text" name="age" id="age" class="form-control input-md input-filed required" value=""  />
                                        </div>
                                    </div>
                                    
                                    <!-- Text input-->
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="contact_number">Contact Number:<span class="text-red">*</span></label>
                                            <input type="text" name="contact_number" id="contact_number" class="form-control input-md input-filed required" value=""  />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="alternate_contact_number">Alternate Contact Number:</label>
                                            <input type="text" name="alternate_contact_number" class="form-control input-md input-filed" id="alternate_contact_number" value=""  />
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="qualification">Highest Qualification:<span class="text-red">*</span></label>
                                            <input type="text" name="qualification" id="qualification" class="form-control input-md input-filed required" value=""  />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="position_apply">Position Applied For:<span class="text-red">*</span></label>
                                            <input type="text" name="position_apply" id="position_apply" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="current_organisation">Current Organisation:<span class="text-red">*</span></label>
                                            <input type="text" name="current_organisation" id="current_organisation" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div>
                    
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="designation">Current Designation:<span class="text-red">*</span></label>
                                            <input type="text" name="designation" id="designation" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div>
                    
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="current_ctc">Current CTC:<span class="text-red">*</span></label>
                                            <input type="text" name="current_ctc" id="current_ctc" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="expected_ctc">Expected CTC:<span class="text-red">*</span></label>
                                            <input type="text" name="expected_ctc" id="expected_ctc" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div>
                    
                                    <!-- Select Basic -->
                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="experience">Total Years Of Experience:<span class="text-red">*</span></label>
                                            <input type="text" name="experience" class="form-control input-md input-filed required" id="experience" value="" />
                                        </div>
                                    </div>
                    
                                    <!-- <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="notice_period">Notice Period/Joining Time:<span class="text-red">*</span></label>
                                            <input type="text" name="notice_period" id="notice_period" class="form-control input-md input-filed required" value="" />
                                        </div>
                                    </div> -->

                                    <div class="col-md-4 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="key_skills">Key Skill Areas:<span class="text-red">*</span></label>
                                            <input type="text" name="key_skills" id="key_skills" class="form-control input-md input-filed required" value=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="scope_of_work">Current Broad Scope Of Work:<span class="text-red">*</span></label>
                                            <textarea type="text" colms="5" rows="6" name="scope_of_work" id="scope_of_work" class="form-control input-md input-filed required"  ></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label text-dark-light" for="resume">Resume :<span class="text-red">*</span></label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFileLang" lang="es">
                                                <label class="custom-file-label" for="customFileLang">Attach Resume</label>
                                                <br>
                                                <span class="text-danger d-block mt-1">*Allowed file types for resume are DOC, DOCX AND PDF.</span>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Button -->
                                    <div class="col-md-12">
                                        <div class="form-group mt-3 text-center">
                                            <button type="submit" name="submit" value="Submit" class="btn btn-orange text-uppercase">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
					
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
        <script src="<?php echo CONFIG_PATH; ?>js/datepicker.js" type="text/javascript"></script>
        <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>
</html>