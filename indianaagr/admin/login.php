<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    $DB = new DBConfig();

    if(!empty($_SESSION['adminkiranakingvalid']) && (int)$_SESSION['adminkiranakingvalid'] == 707) {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <base href="<?php echo BASEURL; ?>" />
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

    </head>
    <body class="body-gray">

        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center"><img src="images/logo.jpg" class="logo-admin"></div>
            </div>
        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-push-3 welcome">
                    <div>
                        <h1>Hi ! Welcome</h1>
                        <p>Please enter your login details.</p>
                    </div>

                    <div class="tab-pane fade active in" id="signin">
                        <?php $_SESSION['tokencode'] = $DB->generateToken(); ?>
                        <form class="form-horizontal" name="addform" id="addform" action="logincheck.php" method="POST" >
                            <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode']; ?>" />
                            <fieldset>
                                <?php if(!empty($_SESSION['loginerr'])) { ?>
                                    <div class="alert alert-danger" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <h4>Error!</h4>
                                        <?php echo $errorlist['login'][$_SESSION['loginerr']]; ?>
                                    </div>
                                    <?php unset($_SESSION['loginerr']); } ?>
                                <!-- Sign In Form -->
                                <!-- Text input-->
                                <div class="control-group">
                                    <label class="control-label signup" for="username">Username:</label>
                                    <div class="controls">
                                        <input type="text" name="username" id="username" placeholder="Enter your username" class="form-control input-medium input required" maxlength="30" />
                                    </div>
                                </div>

                                <!-- Password input-->
                                <div class="control-group">
                                    <label class="control-label signup" for="passwordinput">Password:</label>
                                    <div class="controls">
                                        <input type="password" name="password" id="password" placeholder="Enter your password" class="input-medium form-control input required" maxlength="30" />
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="control-group">
                                    <label class="control-label" for="signin"></label>
                                    <div class="controls">
                                        <button type="submit" id="signin" name="signin" class="btn btn-success btn-center">Login</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>




        <div class="col-md-12"><div class="blank-border"></div></div>


        <div class="container">
            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="foo">
                        <div class="copy">
                            <ul>
                                <li>&copy; 2016 Agrovision,  All Rights Reserved. <br /> </li>
                                <li>Powered by <a href="https://www.isolutiononline.com/" target="_blank">iSolution</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script language="javascript" type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.Login.validateLogin();
            });
        </script>
    </body>
</html>