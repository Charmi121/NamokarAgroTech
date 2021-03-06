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
            <h3>Photo</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>

            <?php if (!empty($_SESSION['photostatus']) && $_SESSION['photostatus'] == "invalid") { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['photo'][$_SESSION['photostatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php
                unset($_SESSION['photostatus']);
            } elseif (!empty($_SESSION['photostatus']) && $_SESSION['photostatus'] != "invalid") {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
    <?php echo $errorlist['photo'][$_SESSION['photostatus']]; ?>
                </div>
                <div class="clearfix"></div>
    <?php unset($_SESSION['photostatus']);
} ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                if (!empty($_GET['edit']) && (int) $_GET['edit'] == 1) {
                    $edit = (int) $_GET['edit'];
                    $id = (int) $_GET['id'];

                    $sqlquery = $fpdo->from('tblphotos')
                            ->where('tblphotos.id = :id ', array(":id" => $id));
                    $rsdata = $sqlquery->fetchAll();
                    if (count($rsdata) > 0) {
                        foreach ($rsdata as $rowdata) {
                            $photo_title = trim($rowdata['photo_title']);
                            $thumb_image = trim($rowdata['thumb_image']);
                            $big_image = trim($rowdata['big_image']);
                            $sort_order = (int) $rowdata['sort_order'];
                            $status = (int) $rowdata['status'];
                        }
                    }
                } else {
                    $edit = 0;
                    $id = 0;
                    $photo_title = '';
                    $thumb_image = '';
                    $big_image = '';
                    $sort_order = 0;
                    $status = 0;
                }
                $_SESSION['tokencode'] = $DB->generateToken();
                ?>
                <form name="addform" id="addform" method="post" action="photosave.php" enctype="multipart/form-data" target="_self">
                    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode']; ?>" />
                    <input type="hidden" name="edit" id="edit" value="<?php echo $edit; ?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                            <tr>
                                <td class="col-md-3"><div class="text-right">Category<span class="text-danger">*</span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <?php
                                        $selectedcat = array();
                                        $sqlquery = $fpdo->from("tblproduct_categories")
                                                ->where("tblproduct_categories.product_id = :product_id", array(":product_id" => $id));
                                        $rsproduct_categories = $sqlquery->fetchAll();
                                        if (count($rsproduct_categories) > 0) {
                                            foreach ($rsproduct_categories as $rowproduct_category) {
                                                $selectedcat[] = $rowproduct_category['category_id'];
                                            }
                                        }
                                        ?>

                                        <select id="parent_id" name="photo_category_id" class="category" style="width:100%;" placeholder="Select Category" >
                                            <option value="0">Select Category</option>
                                            <?php
                                            $level = 0;
                                            $sqlquery = $fpdo->from("tblphoto_categories")
                                                    ->select(null)
                                                    ->select("tblphoto_categories.id, tblphoto_categories.photo_category_name")
                                                    ->where("tblphoto_categories.parent_id = :parent_id AND tblphoto_categories.status = :status", array(":parent_id" => 0, ":status" => 707))
                                                    //->where("tblcategories.status = :status", array(":status" => 707))
                                                    ->order("tblphoto_categories.photo_category_name");
                                                    $rsparentcategories = $sqlquery->fetchAll();
                                                    if (count($rsparentcategories) > 0) {
                                                        foreach ($rsparentcategories as $rowparentcategory) {
                                                            $level = 1;
                                                            ?>
                                                            <option value="<?php echo $rowparentcategory['id']; ?>" <?php if (in_array($rowparentcategory['id'], $selectedcat)) {
                                                        echo "selected=\"selected\"";
                                                    } ?>><?php echo $rowparentcategory['photo_category_name']; ?> </option> 
                                                            <?php
                                                        }
                                                    }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="col-md-3"><div class="text-right">Title<span class="text-danger"></span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="text" name="photo_title" id="photo_title" value="<?php echo $photo_title; ?>" maxlength="150" class=" form-control" title="Please enter photo name" />
                                    </div>
                                </td>
                            </tr>

<?php if (!empty($big_image) && (int) $DB->checkfileexist("../uploads/photos/" . $big_image . "") == 707) { ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Big Image</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/photos/<?php echo $big_image; ?>" style="max-width:600px;" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/photos/" . $big_image; ?>" download="<?php echo $big_image; ?>" class="btn btn-sm btn-info">Download File</a>
                                        </div>
                                    </td>
                                </tr>
<?php } ?>
                            <tr>
                                <td><div class="text-right">Upload Big Image</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="file" name="big_image" id="big_image" class="control" /><span class="text-danger">Best Size (width x height): 1000px X 650px | Best file format JPG</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Status</div></td>
                                <td>
                                    <div class="col-md-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="707" <?php if ((int) $status == 707) {
    echo "selected";
} ?>>Enable</option>
                                            <option value="505" <?php if ((int) $status == 505) {
    echo "selected";
} ?>>Disable</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Sort Order<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-2">
                                        <input type="text" name="sort_order" id="sort_order" value="<?php echo $sort_order; ?>" maxlength="10" class="required form-control" onKeyUp="allow_numeric(this);" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="col-md-6">
                                        <!--<a href="displayphoto.php" class="btn btn-warning"><i class="fa fa-undo"></i> Cancel</a>-->
                                        <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-large btn-primary">Submit <i class=" fa fa-arrow-right"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
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
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="js/jquery.smartmenus.js"></script>

        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
        <link href="assets/plugins/bootstrap-summernote/css/summernote.css" rel="stylesheet">
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/summernote.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/texteditor.js"></script>

        <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css" />
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript">
                                            $(document).ready(function () {
                                                Admin.Utils.initSummerNote();
                                                Admin.Utils.Category.initCategory();
                                                Admin.Utils.Category.validateCategory();
                                                Admin.Utils.Category.imageDelete();
                                            });
        </script>
    </body>
</html>
