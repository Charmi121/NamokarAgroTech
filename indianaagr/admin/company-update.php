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
            <h3>Company Updates</h3>
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

                    $sqlquery = $fpdo->from('tblcompany_update')
                            ->where('tblcompany_update.id = :id ', array(":id" => $id));
                    $rsdata = $sqlquery->fetchAll();
                    if (count($rsdata) > 0) {
                        foreach ($rsdata as $rowdata) {
                            $photo_title = trim($rowdata['title']);
							$seo_url = trim($rowdata['seo_url']);
							$desc = trim($rowdata['description']);
							$location = trim($rowdata['location']);
							$url = trim($rowdata['url']);
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
					$seo_url = '';
					$desc = '';
					$location = '';
					$url = '';
                    $thumb_image = '';
                    $big_image = '';
                    $sort_order = 0;
                    $status = 0;
                }
                $_SESSION['tokencode'] = $DB->generateToken();
                ?>
                <form name="addform" id="addform" method="post" action="company-updatesave.php" enctype="multipart/form-data" target="_self">
                    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode']; ?>" />
                    <input type="hidden" name="edit" id="edit" value="<?php echo $edit; ?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                        
                            <tr>
                                <td class="col-md-3"><div class="text-right">Title<span class="text-danger"></span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="text" name="photo_title" id="title" value="<?php echo $photo_title; ?>" maxlength="150" class=" form-control" title="Please enter title" />
                                    </div>
                                </td>
                            </tr>
							<tr>
                                <td><div class="text-right">SEO URL<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="seo_url" id="seo_url" value="<?php echo $seo_url; ?>" maxlength="150" class="required form-control" placeholder="Enter SEO URL" title="Please enter SEO URL" readonly="readonly" />
                                    </div>
                                </td>
                            </tr>
							 <tr>
                                <td class="col-md-3"><div class="text-right">Description<span class="text-danger"></span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="text" name="desc" id="desc" value="<?php echo $desc; ?>" maxlength="150" class=" form-control" title="Please enter description" />
                                    </div>
                                </td>
                            </tr>
							<tr>
                                <td class="col-md-3"><div class="text-right">Location<span class="text-danger"></span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="text" name="location" id="location" value="<?php echo $location; ?>" maxlength="150" class=" form-control" title="Please enter location" />
                                    </div>
                                </td>
                            </tr>
							<tr>
                                <td class="col-md-3"><div class="text-right">URL<span class="text-danger"></span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="text" name="url" id="url" value="<?php echo $url; ?>" maxlength="150" class=" form-control" title="Please enter url" />
                                    </div>
                                </td>
                            </tr>

<?php if (!empty($big_image) && (int) $DB->checkfileexist("../uploads/news-event/" . $big_image . "") == 707) { ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Big Image</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/news-event/<?php echo $big_image; ?>" style="max-width:600px;" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/news-event/" . $big_image; ?>" download="<?php echo $big_image; ?>" class="btn btn-sm btn-info">Download File</a>
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
		<script language="javascript" type="text/javascript">
    $(document).ready(function() {
            //$("#addform").validate();

     
        $('#title').blur(function() {
		
                
                    var category_name = $('#title').val();

                    
                    category_name = category_name.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '-');
                    $('#seo_url').val(category_name.toLowerCase());    
                 //alert(category_name.toLowerCase());
					
              
        });
    });
</script>
    </body>
</html>
