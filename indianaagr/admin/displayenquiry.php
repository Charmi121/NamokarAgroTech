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
        <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">


    </head>
    <body>
        <header>
            <?php require_once("header.php") ?>
        </header>
        <div class="container">
            <h3> Enquiries </h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <div class="clearfix"></div>
            <?php if(!empty($_SESSION['enquiry_status'])) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['size'][$_SESSION['enquiry_status']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['enquiry_status']); } ?>
            <div class="clearfix"></div>
            <div class="middlesection margin-top20">
                <?php
                    $rowsPerPage = 100;
                    $pageNum = 1;

                    $offset = ($pageNum - 1) * $rowsPerPage;
                    $sqlquery   =   "SELECT tblcontactus.*  ";         
                    $sqlquery   =   $sqlquery . " FROM tblcontactus ";
                    $sqlquery   =   $sqlquery . " WHERE LENGTH(tblcontactus.full_name) > 0";
                    $sqlquery   =   $sqlquery . " ORDER BY tblcontactus.created DESC ";
                    $sqlquery   =   $sqlquery . " LIMIT ".$offset.", ".$rowsPerPage."";
                    $rsdata     =   $fpdo->customResult($sqlquery)->fetchAll();
                    if (count($rsdata)>0){
                ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-md-1">Sr. No.</th>
                                    <th class="col-md-1">Enquiry Date</th>
                                    <th class="col-md-2">Full Name</th>
                                    <th class="col-md-2">Email</th>
                                    <th class="col-md-2">Mobile</th>
                                    <th class="col-md-3">Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                    foreach($rsdata as $rowdata) {
                                        $intcnt = $intcnt+1;
                                    ?>
                                    <tr>
                                        <td><?php echo $intcnt; ?></td>
                                        <td><?php echo date("d-M-Y", strtotime($rowdata['created'])); ?></td>
                                        <td><?php echo $rowdata['full_name']; ?></td>
                                        <td><?php echo $rowdata['email']; ?></td>
                                        <td><?php echo $rowdata['mobile_no']; ?></td>
                                        <td><?php echo $rowdata['comment']; ?></td>
                                    </tr>
                                    <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="pagination">
                                            <?php
                                                $queryrows   =   "SELECT COUNT(*) AS numrows ";
                                                $queryrows   =   $queryrows . " FROM tblcontactus";      
												$queryrows   =   $queryrows . " WHERE LENGTH(tblcontactus.full_name) > 0";
                                                $rsrows      =   $fpdo->customResult($queryrows)->fetchAll();
                                                if(count($rsrows) > 0) {
                                                    foreach ($rsrows as $rsrow) {
                                                        $numrows = $rsrow['numrows'];
                                                    }
                                                }
                                                $self       = $_SERVER['PHP_SELF'];

                                                //$querystring= "category_id=$category_id&product_name=$product_name&sku=$sku&brand=$brand";
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
        <script type="text/javascript">  </script>
    </body>
</html>