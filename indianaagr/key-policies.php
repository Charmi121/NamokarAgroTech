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
        <!-- Start Header -->
        <?php require_once("header.php"); ?>
        <!-- End Header -->
        
        <div class="inner-banner">
            <div class="container text-center d-flex align-items-center justify-content-center">
                <h1 class="text-white heading-border">Key Policies</h1>
            </div>
        </div>
        <div class="about-profile mb-5 safty-policies">
        
        <div class="container">
            <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li>Key Policies</li>
                        </ul>
                    </div>
                </div>
            <div class="row pt-0 content-page">
                <div class="col-md-12">
                    <div class="pb-4">
                    <p>At India Agrovision Implements Pvt. Ltd., our goal isn't limited to business but encompasses the broader spectrum of serving humanity through social initiatives. Agrovision takes a stand as a socially responsible enterprise respectful of its environment.</p>
                    <p>Agrovision has been strongly devoted not only to environmental conservation programs but also expresses the increasingly inseparable balance between economic concerns, environmental and social issues faced by business. A business must not grow at the expense of mankind but must serve humankind at large.</p>
                    </div>
                </div>
            </div>
            
            <div class="row pt-0 content-page">
                <div class="col-md-5">
                    <img src="images/environment-policy.jpg" alt="Environment Policy" class="img-fluid">
                </div>
                <div class="col-md-7">
                    <h3>Environment Policy</h3>
                    <p>We have been committed to demonstrate excellence in our environmental performance on a continuous basis, as an intrinsic element of our corporate philosophy.</p>
                    <p><strong>To achieve this we commit ourselves to:</strong></p>
                    <ul class="list-inline list-dot list-cufont">
                        <li>Integrate environmental attributes and cleaner production in all our business processes and practices with specific consideration to substitution of hazardous chemicals and strengthening the greening of supply chain</li>
<li>Continue product innovations to improve environmental compatibility.</li>
<li>Comply with all applicable environmental legislation and also controlling our environmental discharges through the principles of "alara" (as low as reasonably achievable).</li>
<li>Institutionalize resource conservation in the areas of oil, water, electrical energy, paints and chemicals.</li>
<li>Enhance environmental awareness of our employees and dealers / vendors, while promoting their involvement in environmental management.</li>
                    </ul>
                </div>
                <div class="col-md-12 my-4"><hr></div>
            </div>
            
            <div class="row pt-0 content-page">
                <div class="col-md-5">
                    <img src="images/quality-policy.jpg" alt="Quality Policy    " class="img-fluid">
                </div>
                <div class="col-md-7">
                    <h3>Quality Policy</h3>
                    <p>Excellence in quality is the core value of Agrovision philosophy.</p>
                    <p>We are committed at all levels to achieve high quality in whatever we do, particularly in our products and services which will meet and exceed customer's growing aspirations through:</p>                    
                    <ul class="list-inline list-dot list-cufont">
                        <li>Innovation in products, processes and services.</li>
<li>Continuous improvement in our total quality management systems.</li>
<li>Teamwork and responsibility.</li>
                    </ul>
                </div>
                <div class="col-md-12 my-4"><hr></div>
            </div>
            
            <div class="row pt-0 content-page">
                <div class="col-md-5">
                    <img src="images/safety-policy.jpg" alt="Safety Policy" class="img-fluid">
                </div>
                <div class="col-md-7">
                    <h3>Safety Policy</h3>
                    <p>We believe that safe work practices lead to better business performance, motivated workforce and higher productivity.</p>
                    <p><strong>We shall create a safety culture in the organization by:</strong></p>
                    <ul class="list-inline list-dot list-cufont">
                        <li>Integrating safety and health matters in all our activities.</li>
<li>Promoting safety and health awareness amongst employees, suppliers and contractors.</li>
<li>Continuous improvements in safety performance through precautions besides participation and training of employees.</li>
<li>Ensuring compliance with all applicable legislative requirements.</li>
<li>Empowering employees to ensure safety in their respective work places.</li>
                    </ul>
                </div>                
            </div>
                
        </div>
            
        </div>
      
        <!-- Start footer -->
        <?php require_once("footer.php"); ?>
        <!-- End footer -->

        <!-- JavaScript -->
        <script src="<?php echo CONFIG_PATH; ?>js/jquery-3.3.1.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/webslidemenu.js"></script>
        <script src="<?php echo CONFIG_PATH; ?>js/custom.js"></script>
    </body>
</html>