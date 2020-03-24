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
        <title>Downloads</title>
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
                <h1 class="text-white heading-border">Downloads</h1>
            </div>
        </div>
        <div class="about-profile">

            <div class="container downloads">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="breadcrumb mb-5">
                            <li><a href="<?php echo CONFIG_PATH; ?>index.php">Home</a></li>
                            <li>Downloads</li>
                        </ul>
                    </div>
                </div>
                <div class="row pb-5 pt-0 content-page">
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Single Speed Gear Drive Rotary Tiller (Rotavator)</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-RTI</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/single-speed-gear-drive-rotary-tiller-rotavator.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Multi Speed Gear Drive Rotary Tiller (Rotavator)</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MSGDRT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/multi-speed-gear-drive-rotary-tiller-rotavator.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Mounted Disc Plough (MF Type)</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-DPMF</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/disc-plough-mf-type.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Disc Plough-Regular Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-DPTFs</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/disc-plough-regular-model.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Poly Disc Plough / Harrow</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-PDH</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/poly-disc-plough-harrow.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Mounted Offset Disc Harrow</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MODH</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/mounted-offset-disc-harrow.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Trailed Offset Disc Harrow (Compact Model)</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HDMCTODHC</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/mounted-cum-trailed-offset-disc-harrow-compact-model.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Hydraulic Heavy Duty Trailed Offset Disc Harrow</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HHDTODH</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/hydraulic-disc-harrow.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Mounted Tandom Disc Harrow</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MTDH</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/mounted-tendom-disc-harrow.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Trailed Offset Disc Harrow</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HDTODH</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/trailed-offset-disc-harrow.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Hydraulic Tipping Trailer-Single Axle</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HTT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/hydraulic-tipping-trailer-single-axle.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Hydraulic Tipping Trailer-Double Axle</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HTTDA</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/hydraulic-tipping-trailer-double-axle.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">MB Plough-Regular Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MBP</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/mb-plough-regular-model.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Hydraulic Reversible MB Plough</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HRMBP</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/hydraulic-reversible-mb-plough.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Disc Ridger</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-DR</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/disc-ridger.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Tine Ridger</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-TR</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/tyne-ridger.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Medium Duty Spring Loaded Tiller / Cultivator</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MDSLT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/medium-duty-spring-loaded-tiller-cultivator.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Spring Loaded Cultivator</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HDSLT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/heavy-duty-spring-loaded-tiller-cultivator.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Medium Duty Spring Loaded Cultivator / Tiller Compact/Folding Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MDSCT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/medium-duty-spring-loaded-tiller-cultivator-compact.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Spring Loaded Cultivator / Tiller Compact/Folding Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HDSLTFM</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/heavy-duty-spring-loaded-tiller-cultivator-compact.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Sub Soilers</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-SS</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/sub-soilers.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Rigid Tiller/Cultivator-Regular Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HDRT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/heavy-duty-rigid-tiller-cultivator-regular-model.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Rigid Tiller/Cultivator Compact/Folding Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-RTFM</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/heavy-duty-rigid-tiiller-cultivator-compact-folding-model.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Heavy Duty Land Leveller</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HDLL</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/heavy-duty-land-leveller.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Reversible Land Leveller</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-RLL</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/reversible-land-leveller.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Post Hole Digger-Regular Model</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-PHD</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/post-hole-digger-regular-model.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Hydraulic Post Hole Digger</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HPHD</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/hydraulic-post-hole-digger.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Rotary Slasher / Lawn Mower</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-RS / LM</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/rotary-slasher.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Rotary Harrow</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-RH</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/rotary-harrows-power-harrows.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Seed cum Fertilizer Drills / Planters</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-SCFD</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/seed-cum-fertilizer-drills-planters.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Front Dozers</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-TFD</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/front-dozers.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Industrial Loader</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-TFL</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/industrial-loader.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Trench Diggers / Trenchers</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-TDD</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/trench-diggers-trenchers.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Mobile Tanker</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-MWT</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/mobile-tanker.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bxouter">
                        <div class="download-pdf d-flex justify-content-between align-items-center">
                            <section class="left d-flex align-items-center">
                                <figure class="mr-3 mb-0"><img src="images/pdf.png" alt="pdf"></figure>
                                <article>
                                    <p class="mb-1">Chaff Cutter</p>
                                    <p class="mb-0"><strong>Product Code:</strong> A-HCPOCC</p>
                                </article>
                            </section>
                            <div class="right">
                                <a target="_blank" href="pdf/chaff-cutter.pdf" class="btn btn-success btn-radius">Download <i class="fas fa-cloud-download-alt"></i></a>
                            </div>
                        </div>
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