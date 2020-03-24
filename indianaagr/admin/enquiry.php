<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    require_once('paging.php');
    $DB = new DBConfig();

    header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
    header("Cache-Control: post-check=0, pre-check=0",false);
    session_cache_limiter("must-revalidate");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Panel</title>
        <meta name="keywords" content="Admin Panel" />
        <meta name="description" content="Admin Panel" />

        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/media-queries.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- SmartMenus jQuery Bootstrap Addon CSS -->
        <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">

    </head>
    <body>
        <header>
            <?php require_once("header.php") ?>
        </header>
        <div class="container">
            <h3>Enquiry Details</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <?php if(!empty($_SESSION['enquirystatus']) &&  $_SESSION['enquirystatus']=="invalid" ) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['enquiry'][$_SESSION['enquirystatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['enquirystatus']);
                } elseif(!empty($_SESSION['enquirystatus']) &&  $_SESSION['enquirystatus']!="invalid") {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['enquiry'][$_SESSION['enquirystatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['enquirystatus']); } ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">
                <div class="table-responsive">

                    <?php
                        $edit        =  (!empty($_GET['edit'])) ? (int)$_GET['edit'] : 0; 
                        $enquiry_id  =  (!empty($_GET['enquiry_id'])) ? (int)$_GET['enquiry_id'] : 0;
                        if (!empty($enquiry_id))
                        {
                            $sqlquery = $fpdo->from("tblenquiries")
                                             ->where("tblenquiries.enquiry_id = :enquiry_id", array(":enquiry_id" => $enquiry_id));
                            $rsenquiries = $sqlquery->fetchAll();
                            if (count($rsenquiries)>0) {
                                foreach($rsenquiries as $rowenquiry) {
                                    $user_id        =   trim($rowenquiry['user_id']);
                                    $first_name     =   trim($rowenquiry['first_name']);
                                    $last_name      =   trim($rowenquiry['last_name']);
                                    $email          =   trim($rowenquiry['email']);
                                    $message        =   trim($rowenquiry['message']);
                                    $ip_address     =   trim($rowenquiry['ip_address']);
                                    $status         =   trim($rowenquiry['status']);
                                    $sort_order     =   trim($rowenquiry['sort_order']);
                                    $created        =   trim($rowenquiry['created']);
                                }
                            }
                    ?>
                        <table class="table">
                            <tr>
                                <td>
                                    <table class="table table-condensed">
                                        <tr>
                                            <td colspan="6" style="vertical-align:top;"><div><strong>Enquiry Number:</strong> <?php echo $rowenquiry['enquiry_id'];?></div></td>
                                        </tr> 
                                        <tr>
                                            <td colspan="6" style="vertical-align:top;"><div><strong>Enquiry Date:</strong> <?php echo date('d-M-Y', strtotime ($rowenquiry['created'])); ?></div></td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-4 col-sm-4 col-xs-12" style="vertical-align:top;">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <b> Customer Information </b>
                                                    </div>
                                                    <div class="panel-body">
                                                        <b>Name: </b><?php echo $rowenquiry['first_name']." ".$rowenquiry['last_name']; ?> <br />
                                                        <b>Email: </b> <a href="mailto:<?php echo $rowenquiry['email']; ?>"><?php echo $rowenquiry['email']; ?></a> <br />
                                                        <b>Address: </b><?php echo $rowenquiry['address']; ?> <br />
                                                        <b>Message: </b><?php echo $rowenquiry['message']; ?> <br />
                                                        <b>IP Address: </b><?php echo $rowenquiry['ip_address']; ?> <br />
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="width:20px;">&nbsp;</td>
                                        </tr>
                                    </table>

                                    <?php
                                        (int) $j = 0;
                                        $totalvalue = 0;
                                        $sqlquery  =  "SELECT tblenquiry_products.*, tblproducts.id AS product_id, tblproducts.sku as product_sku, tblproduct_images.thumb_image, ";
                                        $sqlquery  =  $sqlquery . " tbltypes.type_name, tblfabrics.fabric_name, tblcolors.color_name";
                                        $sqlquery  =  $sqlquery . " FROM tblenquiry_products";
                                        $sqlquery  =  $sqlquery . " INNER JOIN tblproducts ON tblproducts.id = tblenquiry_products.product_id";
                                        $sqlquery  =  $sqlquery . " LEFT JOIN tblproduct_images ON tblproduct_images.product_id = tblproducts.id AND tblproduct_images.show_as_main = 1";
                                        
                                        $sqlquery  =  $sqlquery . " LEFT JOIN tbltypes ON tbltypes.id = tblproducts.type_id";
                                        $sqlquery  =  $sqlquery . " LEFT JOIN tblfabrics ON tblfabrics.id = tblproducts.fabric_id";
                                        $sqlquery  =  $sqlquery . " LEFT JOIN tblcolors ON tblcolors.id = tblproducts.color_id";
                                        
                                        $sqlquery  =  $sqlquery . " INNER JOIN tblenquiries ON tblenquiries.enquiry_id = tblenquiry_products.enquiry_id";
                                        $sqlquery  =  $sqlquery . " WHERE tblenquiry_products.enquiry_id =".$enquiry_id." ";
                                        $sqlquery  =  $sqlquery . " ORDER BY tblenquiry_products.enquiry_product_id ASC ";
                                        $rscart    =  $fpdo->customResult($sqlquery)->fetchAll();
                                        if (count($rscart)>0) {
                                    ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <b> Product Information </b>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th class="col-md-2">Image</th>
                                                        <th class="col-md-3">Product Name</th>
                                                        <th class="col-md-2">SKU</th>
                                                        <th class="col-md-2">Type</th>
                                                        <th class="col-md-2">Fabric</th>
                                                        <th class="col-md-2">Color</th>
                                                    </tr>
                                                    <?php
                                                        foreach($rscart as $rowcart) {
                                                            $j = $j+1;
                                                    ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <?php if (!empty($rowcart['thumb_image'])) { ?>
                                                                    <img src="../uploads/products/<?php echo $rowcart['thumb_image']; ?>"  alt="<?php echo $rowcart['product_name']; ?>" style="max-height:100px;" />
                                                                <?php } else { ?>
                                                                    <img src="../uploads/no-image/no_image.jpg" alt="<?php echo $rowcart['product_name']; ?>" />
                                                                <?php } ?>
                                                            </td>
                                                            <td><div><?php echo $rowcart['product_name']; ?></div></td>
                                                            <td><?php echo $rowcart['sku']; ?></td>
                                                            <td><?php echo $rowcart['type_name']; ?></td>
                                                            <td><?php echo $rowcart['fabric_name']; ?></td>
                                                            <td><?php echo $rowcart['color_name']; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <form action="executeenquiry.php" method="post" name="executeenquiry" id="executeenquiry" class="form-horizontal">
                                        <input type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $enquiry_id;?>" />
                                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id;?>" />
                                        <table class="table table-bordered table-striped table-condensed">
                                            <tbody>
                                                <tr class="headingrow">
                                                    <th colspan="2">Enquiry Status</th>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-4"><div class="text-right">Remarks </div></td>
                                                    <td class="col-md-8">
                                                        <div class="col-md-12">
                                                            <textarea name="admin_remarks" id="admin_remarks" class="form-control"><?php echo $rowenquiry['admin_remarks']; ?></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-4"><div class="text-right">Status<span class="text-danger">*</span></div></td>
                                                    <td class="col-md-8">
                                                        <div class="col-md-6">
                                                            <select name="status" id="status" class="form-control">
                                                                <option value="505" <?php if((int)$rowenquiry['status'] == 505) { echo "selected=\"selected\""; } ?>>Pending</option>
                                                                <option value="707" <?php if((int)$rowenquiry['status'] == 707) { echo "selected=\"selected\""; } ?>>Executed</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="control-group form-actions">
                                            <input type="submit" name="execute" value="Submit" class="btn btn-success btn-large" />
                                            <a href="displayenquiry.php" class="btn btn-default btn-large">Return</a>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    <?php
                        } else {
                    ?>
                        <table class="table">
                            <tr class="darkrow">
                                <td style="height:300px; text-align:center;">No Order Found</td>
                            </tr>
                        </table>
                    <?php
                        }                        
                    ?>
                </div>
            </div>
        </div>
        <!--end middle part-->
        <div class="col-md-12"><div class="blank-border"></div></div>
        <footer>
            <?php require_once("footer.php") ?>
        </footer>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="js/jquery.smartmenus.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>

        <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" media="screen">
        <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/locales/bootstrap-datepicker.en.js" charset="UTF-8"></script>

        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.Enquiry.initEnquiry();
            });
        </script>
    </body>
</html>