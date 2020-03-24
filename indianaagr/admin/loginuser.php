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
            <h3>Login User</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>

            <?php if(!empty($_SESSION['loginuserstatus']) &&  $_SESSION['loginuserstatus']=="invalid" ) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['loginuser'][$_SESSION['loginuserstatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['loginuserstatus']);
                } elseif(!empty($_SESSION['loginuserstatus']) &&  $_SESSION['loginuserstatus']!="invalid") {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['loginuser'][$_SESSION['loginuserstatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['loginuserstatus']); } ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                    if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1)
                    {

                        $edit     = (int)$_GET['edit'];
                        $id       = (int)$_GET['id'];
                        $sqlquery = $fpdo->from('tbladminuser')
                                         ->where('tbladminuser.id =:id ',array( ":id"=>$id) );
                        $rsdata   = $sqlquery->fetchAll();
                        if (count($rsdata) > 0)
                        {
                            foreach($rsdata as $rowdata)
                            {
                                $fullname   =   trim($rowdata['fullname']);
                                $email      =   trim($rowdata['email']);
                                $phoneno    =   trim($rowdata['phoneno']);
                                $username   =   trim($rowdata['username']);
                                $password   =   null;
                                $address    =   html_entity_decode($rowdata['address'],ENT_QUOTES,"UTF-8");
                                $rights     =   trim($rowdata['rights']);
                                $status     =   trim($rowdata['status']);
                            }
                        }
                    }
                    else
                    {
                        $edit           =   0;
                        $id             =   0;
                        $fullname       =   null;
                        $email          =   null;
                        $phoneno        =   null;
                        $username       =   null;
                        $password       =   null;
                        $address        =   null;
                        $rights         =   null;
                        $status         =   707;
                    }

                    $_SESSION['tokencode']  =   $DB->generateToken();
                ?>
                <form name="addform" id="addform" method="post" action="loginusersave.php" enctype="multipart/form-data" target="_self" >
                    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                    <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                            <tr>
                                <td class="col-md-3"><div class="text-right">Full Name<span class="text-danger">*</span></div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <input type="text" name="fullname" id="fullname" value="<?php echo $fullname; ?>" maxlength="150" class="required form-control" placeholder="Enter Fullname" title="Please enter fullname"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Username<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="username" id="username" value="<?php echo $username; ?>" maxlength="50" class="required form-control" placeholder="Enter Username " title="Please enter username" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Password<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="password" name="password" id="password" value="<?php echo $password;?>" maxlength="50"  class="required form-control" placeholder="Enter Password" />
                                        <div class="text-danger">(One-time password) You must enter <b>new password</b>, whenever you update information.</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Email <span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="email" id="email" value="<?php echo $email; ?>" maxlength="150" class="required email form-control" placeholder="Enter Email" title="Please enter email" />
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="text-right">Phone No.</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="phoneno" id="phoneno" value="<?php echo $phoneno; ?>" maxlength="20" class="form-control" placeholder="Enter Phone No." />
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="text-right">Address</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <textarea name="address" id="address" placeholder="Enter Address" cols="80" class="form-control"><?php echo $address; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Rights</div></td>
                                <td>
                                    <div class="col-md-3">
                                        <select name="rights" id="rights" class="form-control">
                                            <option value="Administrator" <?php if ($rights == "Administrator") { echo "selected"; } ?>>Administrator</option>
                                            <option value="Manager" <?php if ($rights == "Manager") { echo "selected"; } ?>>Manager</option>
                                            <option value="Executive" <?php if ($rights == "Executive") { echo "Executive"; } ?>>Executive</option>
                                        </select>
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
                    Admin.Utils.LoginUser.validateLoginUser();
            });
        </script>
    </body>
</html>
