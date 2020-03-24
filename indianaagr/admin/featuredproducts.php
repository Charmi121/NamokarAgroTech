<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    $DB = new DBConfig();
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
    <h3>Edit Featured Products</h3>
    <div class="col-md-12"><div class="blank-border"></div></div>
    <?php if(!empty($_SESSION['productfeaturedstatus'])) { ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Success!</h4>
            <?php echo $errorlist['productfeatured'][$_SESSION['productfeaturedstatus']]; ?>
        </div>
        <div class="clearfix"></div>
    <?php unset($_SESSION['productfeaturedstatus']); } ?>

    <div class="clearfix"></div>
    <div class="middlesection margin-top20">
        <form name="addform" id="addform" method="post" action="featuredproductssave.php">
            <table class="table table-condensed">
                <tr>
                    <td style="width:500px;" colspan="3">
                        <b>Featured Products List:</b><br/>
                        <?php
                            $selected_products = array();
                            $sqlquery = "SELECT DISTINCT tblproduct_featured.product_id FROM tblproduct_featured WHERE tblproduct_featured.id != 0";
                            $rsfeatured = $fpdo->customResult($sqlquery)->fetchAll();
                            if (count($rsfeatured) > 0){
                                foreach($rsfeatured as $rowfeatured){
                                    $selected_products[] =  $rowfeatured['product_id'];
                                }
                            }
                        ?>
                        <select class="deals" name="products_list[]" id="products_list" multiple="multiple" size="20" style="width:320px;">
                            <?php
                                $sqlquery = "SELECT tblproducts.id, tblproducts.product_name, tblproducts.sku  FROM tblproducts";
                                $sqlquery = $sqlquery ." WHERE tblproducts.id != 0 AND tblproducts.status = 707";
                                $sqlquery = $sqlquery ." ORDER BY tblproducts.product_name ASC";
                                $rsproducts = $fpdo->customResult($sqlquery)->fetchAll();
                                if (count($rsproducts) > 0){
                                    foreach($rsproducts as $rowproduct){
                            ?>
                                <option value="<?php echo $rowproduct['id']; ?>" <?php if(in_array($rowproduct['id'], $selected_products ) ){echo "selected=\"selected\""; } ?>><?php echo $rowproduct['product_name']." (".$rowproduct['sku'].")"; ?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <div class="text-center">
                            <input type="submit" name="submit" value="Update" id="submitbutton" class="btn btn-large btn-primary" />
                        </div>
                    </td>
                </tr>
            </table>
        </form>
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
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>

<link href="css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
<script src="js/jquery.multi-select.js" type="text/javascript"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
<script type="text/javascript" src="js/admin.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        Admin.Utils.Product.featuredProduct();
    });
</script>
</body>
</html>