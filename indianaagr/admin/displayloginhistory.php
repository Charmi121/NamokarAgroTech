<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    require_once('paging.php');
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
            <h3>Login History</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <div class="clearfix"></div>

            <div class="middlesection margin-top20">

                <?php
                    $rowsPerPage = 30;
                    $pageNum = 1;

                    if(!empty($_GET['page']) && (int)$_GET['page'] > 0){
                        $pageNum = (int)$_GET['page'];
                    } else {
                        $pageNum =  1;
                    }

                    $userid     =   (isset($_SESSION['adminvitronaturalsuserid'])) ? (int)$_SESSION['adminvitronaturalsuserid'] : 0;
                    $offset     =   ($pageNum - 1) * $rowsPerPage;
                    $sqlquery   =   "SELECT * FROM tbladminlogindetails ";
                    $sqlquery   =   $sqlquery ." WHERE userid =". $userid."";
                    $sqlquery  =   $sqlquery . " ORDER BY id ";
                    $sqlquery   =   $sqlquery . " LIMIT ".$offset.", ".$rowsPerPage."";

                    $rsdata     =   $fpdo->customResult($sqlquery)->fetchAll();
                    if (count($rsdata)>0)
                    {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">Sr.No.</th>
                                    <th class="col-md-3">Login Date</th>
                                    <th class="col-md-2">Login Time</th>
                                    <th class="col-md-1">Login IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                    foreach($rsdata as $rowdata){
                                        $intcnt = $intcnt+1;
                                    ?>
                                    <tr>
                                        <td class="col-md-1"><?php echo $intcnt; ?></td>
                                        <td class="col-md-3"><?php echo date("d-M-Y", strtotime($rowdata['logindate'])); ?></td>
                                        <td class="col-md-2"><?php echo date("H:i:s", strtotime($rowdata['logindate'])); ?></td>
                                        <td class="col-md-1"><?php echo $rowdata['loginip']; ?></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        <div class="pagination">
                                            <?php
                                                $queryrows  = "SELECT COUNT(*) AS numrows FROM tbladminlogindetails";
                                                $rsdata     =   $fpdo->customResult($sqlquery)->fetchAll();
                                                if(count($resultrows) > 0) {
                                                    foreach ($resultrows as $row) {
                                                        $numrows = $row['numrows'];
                                                    }
                                                }
                                                $self       = $_SERVER['PHP_SELF'];

                                                $querystring= "";
                                                //print the paging result
                                                doPages($rowsPerPage, $self, $querystring, $numrows);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <?php } else { ?>
                    <table>
                        <tr>
                            <td class="text-center">No Record Found</td>
                        </tr>
                    </table>
                    <?php
                    }
                ?>
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
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.City.displayCity();
            });
        </script>
    </body>
</html>
