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
    <h3>Products Import Excel</h3>
    <div class="col-md-12"><div class="blank-border"></div></div>
    <?php if(!empty($_SESSION['productimportstatus']) && $_SESSION['productimportstatus'] == "success") { ?>
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Success!</h4>
            <?php echo $errorlist['productimport'][$_SESSION['productimportstatus']]; ?>
        </div>
        <div class="clearfix"></div>
    <?php unset($_SESSION['productimportstatus']); } ?>
    <?php if(!empty($_SESSION['productimportstatus']) && $_SESSION['productimportstatus'] != "success") { ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <h4>Error!</h4>
            <?php echo $errorlist['productimport'][$_SESSION['productimportstatus']]; ?>
        </div>
        <div class="clearfix"></div>
    <?php unset($_SESSION['productimportstatus']); } ?>

    <div class="clearfix"></div>
    <div class="middlesection margin-top20">
        <?php $_SESSION['tokencode'] = $DB->generateToken(); ?>
        <form name="addform" id="addform" method="post" action="products-import-excel-save.php" enctype="multipart/form-data">
            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
            <table class="table table-bordered table-striped table-condensed">
                <tr>
                    <td class="col-md-3"><div class="text-right">Category<span class="text-danger">*</span></div></td>
                    <td class="col-md-9">
                        <select id="category_id" name="category_id" class="category" style="width:50%;" placeholder="Select Category">
                                <option value="0">Select Category</option>
                                <?php
                                    $sqlquery = $fpdo->from("tblcategories")
                                                     ->select(null)
                                                     ->select("tblcategories.id, tblcategories.category_name")
                                                     ->where("tblcategories.parent_id = :parent_id AND tblcategories.status = :status", array(":parent_id" => 0, ":status" => 707))
                                                     ->order("tblcategories.category_name");
                                    $rsparentcategories = $sqlquery->fetchAll();
                                    if (count($rsparentcategories)>0) {
                                        foreach($rsparentcategories as $rowparentcategory){
                                                $level = 1;
                                ?>
                                <option value="<?php echo $rowparentcategory['id'];?>"><?php echo $rowparentcategory['category_name'];?> </option>
                                <?php
                                         }
                                     }
                                ?>
                            </select>    
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-md-5">Select Products File<span class="text-danger">*</span></td>
                    <td>
                        <input type="file" name="excel_file" id="excel_file" class="fileinput-filename" required="required" title="Please select excel file to import" />
                        <span class="text-muted">Only excel format is allowed (.xls)</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <input type="submit" name="submit" value="Update" id="submitbutton" class="btn btn-large btn-primary" />
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

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
<script type="text/javascript" src="js/admin.js"></script>
<script src="//cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        Admin.Utils.ProductImport.initProductImport();
        Admin.Utils.ProductImport.validateProductImport();
    });
</script>
</body>
</html>