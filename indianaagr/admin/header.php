<div class="container">
    <div class="row">
        <div class="col-md-8 col-sm-9 col-xs-6"><img src="images/logo.jpg" class="logo"></div>

        <div class="col-md-4 col-sm-3 col-xs-6">
            <div class="btn-group user"> <a href="#" data-toggle="dropdown" class="btn dropdown-toggle"> <?php echo $_SESSION['adminkiranakingfullname']; ?> <span class="caret"></span> </a>
                <ul aria-labelledby="dLabel" role="menu" class="dropdown-menu">
                    <li><a href="loginuser.php?id=<?php echo $_SESSION['adminkiranakinguserid'];?>&edit=1" tabindex="-1">Edit Profile</a></li>
                    <li><a href="changepassword.php" tabindex="-1">Change Password</a></li>
                    <li class="divider"></li>
                    <li><a href="logout.php" tabindex="-1">Logout</a></li>
                </ul>
            </div>
        </div>

    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <span class="pull-right" style="color:#000000;"><b>Last Login</b><img src="images/x.gif" width="5px" alt="" />Date:<img src="images/x.gif" width="5px" alt="" /><?php if(!empty($_SESSION['adminkiranakinglastlogindate'])) { echo Date('d-m-Y', strtotime($_SESSION['adminkiranakinglastlogindate'])); } ?><img src="images/x.gif" width="5px" alt="" />|<img src="images/x.gif" width="5px" alt="" />Time:<img src="images/x.gif" width="5px" alt="" /><?php if(!empty($_SESSION['adminkiranakinglastlogindate'])) { echo Date('h:i:s', strtotime($_SESSION['adminkiranakinglastlogintime'])); } ?><img src="images/x.gif" width="5px" alt="" />|<img src="images/x.gif" width="5px" alt="" />IP:<img src="images/x.gif" width="5px" alt="" /><?php if(!empty($_SESSION['adminkiranakinglastlogindate'])) { echo $_SESSION['adminkiranakinglastloginip']; } ?></span>
    </div>
</div>
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav">
                <li><a href="index.php"><i class="fa fa-home"></i></a></li>
                <li><a href="#">MASTERS</a>
                    <ul class="dropdown-menu">
                        <li><a href="displaycategory.php">CATEGORY</a></li>
                        <!--<li><a href="displaysizes.php">SIZE</a></li>-->
                    </ul>
                </li>   
                <li><a href="#">PRODUCT</a>
                    <ul class="dropdown-menu">
                        <li><a href="displayproduct.php">PRODUCTS</a></li>
                        <!-- <li><a href="featuredproducts.php">FEATURED PRODUCTS</a></li> -->
                        <!-- <li><a href="products-import-excel.php">PRODUCTS IMPORT EXCEL</a></li> -->
                    </ul>
                </li>
                <!-- <li><a href="#">ORDERS</a>
                    <ul class="dropdown-menu">
                        <li><a href="displayorder.php">CONFIRMED ORDERS</a></li>
                        <li><a href="displayabandonedorder.php">ABANDONED ORDERS</a></li>
                    </ul>
                </li>
                <li><a href="displayregister.php">CUSTOMERS</a></li>
                <li><a href="#">COUPONS</a>
                     <ul class="dropdown-menu">
                        <li><a href="displaycoupon.php">COUPONS</a></li>
                        <li><a href="displayredeemcoupon.php">COUPONS REDEEM</a></li>
                     </ul>
                </li>   -->              
                <li><a href="#">PAGES</a>
                    <ul class="dropdown-menu">
                        <!-- <li><a href="displayhomepagecontent.php">HOMEPAGE</a></li> -->
                        <li><a href="displayslider.php">HOMEPAGE SLIDERS</a></li>
                        <li><a href="displaypages.php">OTHER WEBPAGES</a></li>
                        <!--
                        <li><a href="#">FAQ</a>
                            <ul class="dropdown-menu">
                                <li><a href="displayfaqcategory.php">FAQ CATAGORY</a></li>
                                <li><a href="displayfaq.php">FAQ's</a></li>
                            </ul>
                        </li>
                        -->
                    </ul>
                </li>
                <li><a href="#">MEDIA</a>
                    <ul class="dropdown-menu">
                        <li><a href="displayphotocategory.php">CATEGORY</a></li> 
                        <li><a href="displayphoto.php">PHOTO GALLERY</a></li>
						 <li><a href="displayaward.php">Awards</a></li>
						 <li><a href="displaynews_event.php">News & Events</a></li>
						 <li><a href="displayupdate.php">Company Updates</a></li>
                        <!--
                        <li><a href="#">FAQ</a>
                            <ul class="dropdown-menu">
                                <li><a href="displayfaqcategory.php">FAQ CATAGORY</a></li>
                                <li><a href="displayfaq.php">FAQ's</a></li>
                            </ul>
                        </li>
                        -->
                    </ul>
                </li>
<!--                <li><a href="displaypress.php">PRESS</a></li>-->
                <li><a href="#">REPORTS</a>
                    <ul class="dropdown-menu">
                        <!-- <li><a href="displayproductinventory.php">INVENTORY MANAGEMENT</a></li> -->
                        <li><a href="displayenquiry.php">ENQUIRY</a></li>
                        <!-- <li><a href="displaynewsletter.php">NEWSLETTER</a></li> -->
                    </ul>
                </li> 
                
                <?php /*  <li><a href="#">MEDIA</a>
                    <ul class="dropdown-menu">
                         <li><a href="displaymediaevents.php">MEDIA & EVENTS</a></li>
                         <li><a href="displaycampaigns.php">CAMPAIGNS</a></li>
                    </ul>
                </li> */?>
                <li><a href="displayconfiguration.php">CONFIGURATION</a></li>
                <li><a href="#">Admin User</a>
                    <ul class="dropdown-menu">
                        <li><a href="displayloginuser.php">USER LIST</a></li>
                        <li><a href="displayloginhistory.php">LOGIN HISTORY</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container -->
      </div>