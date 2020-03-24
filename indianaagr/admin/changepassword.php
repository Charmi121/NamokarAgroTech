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
            <h3>Change Password</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>

            <?php if(!empty($_SESSION['changepasswordstatus']) &&  $_SESSION['changepasswordstatus']=="invalid" ) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['changepassword'][$_SESSION['changepasswordstatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['changepasswordstatus']);
                } elseif(!empty($_SESSION['changepasswordstatus']) &&  $_SESSION['changepasswordstatus']!="invalid") {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['changepassword'][$_SESSION['changepasswordstatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['changepasswordstatus']); } ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                    $_SESSION['tokencode']  =   $DB->generateToken();
                ?>
                <form name="addform" id="addform" method="post" action="changepasswordsave.php"  enctype="multipart/form-data" target="_self">
                    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                            <tr>
                                <td class="col-md-3"><div class="text-right">Old Password<span class="text-danger">*</span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="password" name="oldpassword" id="oldpassword"  maxlength="150" class="required form-control" placeholder="Enter Old Password"  />
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="text-right">New Password<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="password" name="newpassword" id="newpassword"  maxlength="150" class="required form-control" placeholder="Enter New Password"  />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Confirm Password<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="password" name="confirmpassword" id="confirmpassword"  maxlength="150" class="required form-control" placeholder="Confirm Password"  />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="col-md-6">
                                        <!--<a href="displaycategory.php" class="btn btn-warning"><i class="fa fa-undo"></i> Cancel</a>-->
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
        <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css" />
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.LoginUser.validateChangePassword();
            });
        </script>
    </body>
</html>
