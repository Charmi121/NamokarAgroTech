<!-- Start Header -->

<header class="header">
    <div class="menu-bar">
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <ul class="textlink list-inline d-flex">
                        <li><a href="mailto:sales@namokaragrotech.com
" class="mail">sales@namokaragrotech.com</a></li>
                       <!-- <li><a href="<?php echo CONFIG_PATH; ?>customer-survey.php">Customer Survey</a></li>-->
                    </ul>
                    <ul class="social list-inline d-flex">
                        <li><a href="https://www.facebook.com/Namokar-AgroTech-106005627711978" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="https://twitter.com/IndiaAgrovision" target="_blank"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="https://www.youtube.com/user/IndiaAgrovision" target="_blank"><i class="fab fa-youtube"></i></a></li>
                        <li><a href="https://www.instagram.com/namokar_agrotech/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/3733443/admin/" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                    <div class="search position-relative"><i class="fas fa-search" id="showform"></i>
                        <form name="addform" id="addform" method="post" action="<?php echo CONFIG_PATH; ?>product-search.html"  enctype="multipart/form-data" target="_self" autocomplete="off">
                            <input type="text" placeholder="Search by title" class="form-control" name="keyword">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom">
        <div class="container">
            <div class="row justify-content-between">
                 <div class="col-lg-4 col-md-3 logo">
                    <div class="india-flag"><img src="<?php echo CONFIG_PATH; ?>images/india-flag.svg" width="20"> India</div>
                    <a href="https://www.indiaagrovision.com">
                        <picture>
                            <source media="(max-width:767px)" srcset="images/m-logo.png">
                            <img src="<?php echo CONFIG_PATH; ?>images/nm.jpg" alt="logo" class="img-fluid">
                        </picture>
                    </a>
                </div>

                <div class="col-lg-8 col-md-9">
                    <div class="wsmenucontainer clearfix">
                        <div class="overlapblackbg"></div>
                        <div class="wsmobileheader clearfix"><a id="wsnavtoggle" class="animated-arrow"><span></span></a></div>

                        <nav class="wsmenu clearfix">
                            <ul class="mobile-sub wsmenu-list d-flex justify-content-end list-inline">
                                <!--<li><a href="#" class="nav-product text-uppercase d-flex flex-wrap text-center"><span class="d-block">Products</span></a>-->
                                    <div class="megamenu product-megamenu clearfix">
                                        <div class="row">
										<?php 
											$rscategories = $category->getParentCategories();
											if(!empty($rscategories)){
												foreach($rscategories as $key=>$rowcategory){
												//echo $key%4;
										?>
										<?php if($key%2 == 0){ ?>
										<div class="col-md-3">
										<?php } ?>
											<div class="megamenu-box">
												<a href="<?php echo CONFIG_PATH."categories".DS.$rowcategory["seo_url"].".html"; ?>" class="title"><img src="<?php echo $custom->showImagePath("category_logos", $rowcategory['category_logo']); ?>" alt="seeding"> <?php echo $rowcategory["category_name"]; ?></a>
										<?php
                                            $rssubcategories = $category->getChildCategories($rowcategory['id']);
                                            if(count($rssubcategories) > 0) {
                                        ?>
												<ul class="list-inline">
												<?php foreach ($rssubcategories as $rowsubcategory) { ?>
													<li><a href="<?php echo CONFIG_PATH."categories".DS.$rowsubcategory["seo_url"].".html"; ?>"> <?php echo $rowsubcategory["category_name"]; ?></a></li>
												<?php } ?>
												</ul>
                                        <?php } ?>
											</div>
										<?php if($key%2 == 1){ ?>
										</div>
										<?php } ?>
										<?php
												}
											}    
										?>
                                            <div class="col-md-3">
                                                <a href="#" class="title"><img src="<?php echo CONFIG_PATH; ?>images/seeding.png" alt="seeding"> Seeding & Plantation</a>
                                                <ul class="list-inline">
                                                    <li><a href="<?php echo CONFIG_PATH; ?>product-detail.php">Post Hole Digger</a></li>
                                                    <li><a href="#">Multi Crop Ridge Planter</a></li>
                                                    <li><a href="#">Zero Till Seed-Fertilizer Drill</a></li>
                                                    <li><a href="#">Seed cum Fertilizer Drill</a></li>
                                                </ul>
                                                <div class="megamenu-box">
                                                    <a href="#" class="title"><img src="<?php echo CONFIG_PATH; ?>images/crop.png" alt="crop"> Crop Protection</a>
                                                    <ul class="list-inline">
                                                        <li><a href="#">Boom Sprayer</a></li>
                                                        <li><a href="#">Fertilizer Spreader</a></li>
                                                    </ul>    
                                                </div>
                                            </div>
										</div>
                                    </div>
                                </li>-->
                                <li><a href="<?php echo CONFIG_PATH; ?>index.php"><i class="fas fa-home"></i> Home</a></li>
                                <li><a href="#"><i class="fas fa-users"></i> About Us</a>
                                    <div class="wsmenu-submenu clearfix">
                                        <ul class="list-inline">
                                            <li><a href="<?php echo CONFIG_PATH; ?>profile.php">Profile</a></li>
                                            <li><a href="<?php echo CONFIG_PATH; ?>vision-mission.php">Vision & Mission</a></li>
                                            <li><a href="<?php echo CONFIG_PATH; ?>core-values.php">Core Values</a></li>
                                            <li><a href="<?php echo CONFIG_PATH; ?>infrastructure.php">Infrastructure</a></li>
                                            <!-- <li><a href="<?php echo CONFIG_PATH; ?>milestones.php">Milestones </a></li> -->
                                            <li><a href="<?php echo CONFIG_PATH; ?>why-us.php">Why Us</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <!--<li><a href="<?php echo CONFIG_PATH; ?>partner-with-us.php" class="active-tab"><i class="fas fa-handshake"></i> Partner with Us</a></li>
                                <li><a href="<?php echo CONFIG_PATH; ?>global-footprints.php"><i class="fas fa-globe"></i> Global Footprints</a></li>-->
                                <li><a href="#"><i class="far fa-image"></i> Media</a>
                                    <div class="wsmenu-submenu clearfix">
                                        <ul class="list-inline">
                                           <!-- <li><a href="<?php echo CONFIG_PATH; ?>awards-credentials.php">Awards  & Credentials</a></li>-->
<!--                                            <li><a href="#">Trade Shows</a></li>-->
                                            <!-- <li><a href="<?php echo CONFIG_PATH; ?>photo-gallery.php">Events & Exhibitions</a></li> -->
                                            <li><a href="<?php echo CONFIG_PATH; ?>news-events.html">News & Events</a></li>
                                            <li><a href="<?php echo CONFIG_PATH; ?>photo-gallery-all.php">Video & Photo Gallery</a></li> 
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="<?php echo CONFIG_PATH; ?>contact-us.php"><i class="fas fa-phone-volume"></i> Contact Us</a>
                                    <div class="wsmenu-submenu clearfix">
                                        <ul class="list-inline">
                                            <li><a href="<?php echo CONFIG_PATH; ?>contact-us.php">Sales</a></li>
                                            <li><a href="<?php echo CONFIG_PATH; ?>join-us.php">Join Us</a></li>
                                            <li><a href="<?php echo CONFIG_PATH; ?>supply-to-us.php">Supply To Us </a></li>
                                            <!-- <li><a href="<?php echo CONFIG_PATH; ?>partner-with-us.php">Partner With Us </a></li> -->
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</header>
<!-- End Header -->

