<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
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
            <h3> Size </h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <?php if(!empty($_SESSION['size_status'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['size'][$_SESSION['size_status']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['size_status']); } ?>
            <div class="clearfix"></div>
            <div class="middlesection margin-top20">
                <?php
                    if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1) {
                        $edit   =   (int)$_GET['edit'];
                        $id     =   (int)$_GET['id'];

                        $sqlquery = $fpdo->from('tblsizes')
                                         ->where('tblsizes.id =:id ',array( ":id"=>$id) );
                        $rsdata   = $sqlquery->fetchAll();
                        if(count($rsdata) > 0) {
                            foreach($rsdata as $rowdata ) {
                                $size_name   =  $rowdata['size_name'];
                                $status      =  (int)$rowdata['status'];
                                $sort_order  =  (int)$rowdata['sort_order'];
                            }
                        }
                    } else {
                        $edit        =   0;
                        $id          =   0;
                        $size_name   = null;
                        $status      = 707;
                        $sort_order  = '';
                    }
                    $_SESSION['tokencode']  =   $DB->generateToken();
                ?>
                <div class="table-responsive">
                    <form name="addform" id="addform" method="post" action="sizesave.php"  enctype="multipart/form-data" target="_self">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                        <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                        <table class="table table-bordered table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Size<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="size_name" id="size_name" value="<?php echo $size_name; ?>" maxlength="150" class="required form-control" placeholder=" " title="Please enter Size"  />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">Status</div></td>
                                    <td>
                                        <div class="col-md-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="707" <?php if ((int) $status == 707) { echo "selected"; } ?>>Enable</option>
                                                <option value="505" <?php if ((int) $status == 505) { echo "selected"; } ?>>Disable</option>
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
                                            <a href="displaysizes.php" class="btn btn-warning"><i class="fa fa-undo"></i> Cancel</a>
                                            <button type="submit" name="btnsubmit" id="btnsubmit" class="btn btn-large btn-primary">Submit <i class=" fa fa-arrow-right"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
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
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.Master.validatesize();
            });
        </script>
    </body>
</html>

