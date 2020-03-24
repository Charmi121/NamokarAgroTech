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
        <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- SmartMenus jQuery Bootstrap Addon CSS -->
        <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <?php require_once("header.php") ?>
        </header>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-6"><h3>Newsletter Subscribers</h3></div>
                </div>
                <div class="clearfix"></div>
                <?php
                    $email                   =   (!empty($_REQUEST['email']))? $DB->removeTags($_REQUEST['email']): null;
                    $newsletter_status       =   (!empty($_REQUEST['newsletter_status']))? $DB->removeTags($_REQUEST['newsletter_status']): null;
                    $date_picker_range       =   (!empty($_REQUEST['date_picker_range'])) ? $_REQUEST['date_picker_range'] : '';
                    $date_range              =   (!empty($_REQUEST['date_picker_range'])) ? explode("-", $_REQUEST['date_picker_range']) : array();
                    $from_date               =   (!empty($date_range[0])) ? date("Y-m-d", strtotime($date_range[0])) : null;
                    $to_date                 =   (!empty($date_range[1])) ? date("Y-m-d", strtotime($date_range[1])) : null;
                ?>
                <div class="form-actions margin-top20">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Filter Search Result <a id="apanel" href="#" class="pull-right"><i class="fa fa-plus-circle"></i></a></div>
                                <div class="panel-body">
                                    <form method="post" action="displaynewsletter.php" name="addform" id="addform">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="deal_name">Email</label>
                                                <input type="text" name="email" id="email" value="<?php echo stripslashes($email);?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date-range">Register Date Range</label>
                                                <div id="date-range" class="input-group col-md-12">
                                                    <input id="date_picker_range" name="date_picker_range" class="form-control" type="text" <?php if (!empty($from_date) && $DB->checkValidDate($from_date)) { ?> value="<?php echo $date_picker_range; ?>" <?php } ?> />
                                                    <span class="input-group-btn">
                                                        <button id="image_button" class="btn btn-default" type="button"><span class="glyphicon glyphicon-calendar"></span></button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date-range">Status</label>
                                                <div id="date-range" class="input-group col-md-12">
                                                    <select class="form-control" name="newsletter_status" id="newsletter_status">
                                                        <option value="">Select Status</option>
                                                        <option value="707" <?php if((int)$newsletter_status == 707){ echo "selected=\"selected\""; } ?> >Confirmed</option>
                                                        <option value="505" <?php if((int)$newsletter_status == 505){ echo "selected=\"selected\""; } ?>>Pending</option>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 margin-top20">
                                            <div class="form-group text-left">
                                                <label for="submit">&nbsp;</label>
                                                <input type="submit" name="submit" value="Submit" class="btn btn-default btn-primary" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

                        $offset = ($pageNum - 1) * $rowsPerPage;
                        $sqlquery = "SELECT tblnewsletter_subscribers.* FROM tblnewsletter_subscribers ";
                        $sqlquery = $sqlquery . " WHERE tblnewsletter_subscribers.id != 0 ";
                        if (!empty($email)){
                            $sqlquery = $sqlquery . " AND tblnewsletter_subscribers.email LIKE '%".$email."%'";
                        }
                        if(!empty($from_date)){
                            $sqlquery = $sqlquery . " AND DATE(tblnewsletter_subscribers.created) >= '".$from_date."'";
                        }
                        if(!empty($to_date)){
                            $sqlquery = $sqlquery . " AND DATE(tblnewsletter_subscribers.created) <= '".$to_date."'";
                        } 
                        if(!empty($newsletter_status)){
                            $sqlquery = $sqlquery . " AND tblnewsletter_subscribers.status = '".$newsletter_status."'";
                        }
                        $sqlquery = $sqlquery . " ORDER BY tblnewsletter_subscribers.id DESC LIMIT ".$offset.", ".$rowsPerPage."";
                        $rsdata     =   $fpdo->customResult($sqlquery)->fetchAll();
                        if (count($rsdata) > 0) {
                    ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">Sr. No.</th>
                                        <th class="col-md-5">E-Mail</th>
                                        <th class="col-md-1">Register Date</th>
                                        <th class="col-md-1">Status</th>
                                        <th class="col-md-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                        foreach ($rsdata as $rowdata){
                                            $intcnt = $intcnt+1;
                                    ?>
                                        <tr>
                                            <td><?php echo $intcnt; ?></td>
                                            <td><?php echo $rowdata['email']; ?></td>
                                            <td><?php echo date("d-M-Y", strtotime($rowdata['created'])); ?></td>
                                            <td><span class="label <?php if ((int)$rowdata['status'] == 707) { echo "label-success"; } else { echo "label-warning"; } ?>"><?php if ((int)$rowdata['status'] == 707) { echo "Confirm"; } else { echo "Pending"; } ?></span></td>
                                            <td><a href="javascript://" data-id="<?php echo $rowdata['id']; ?>"  data-toggle="modal" data-target="#modalDelete" class="btn btn-sm btn-danger adelete"><i class="fa fa-trash"></i> Delete</a></td>
                                        </tr>
                                        <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-center"> 
                                            <form method="POST" action="newsletter-excel-export.php">
                                                <input type="hidden" name="email" id="email" value="<?php echo $email; ?> ">
                                                <input type="hidden" name="from_date" id="from_date" value="<?php echo $from_date; ?> ">
                                                <input type="hidden" name="to_date" id="to_date" value="<?php echo $to_date; ?> ">
                                                <input type="hidden" name="newsletter_status" id="newsletter_status" value="<?php echo $newsletter_status; ?> ">
                                                <input type="submit" href="" class="btn btn-primary text-center" value="Excel Export" />
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="pagination">
                                                <?php
                                                    $queryrows  = "SELECT COUNT(*) AS numrows FROM tblnewsletter_subscribers";
                                                    $queryrows = $queryrows . " WHERE tblnewsletter_subscribers.id != 0 ";
                                                    if (!empty($email)){
                                                        $queryrows = $queryrows . " AND tblnewsletter_subscribers.email LIKE '%".$email."%'";
                                                    }
                                                    if(!empty($from_date)){
                                                        $queryrows = $queryrows . " AND DATE(tblnewsletter_subscribers.created) >= '".$from_date."'";
                                                    }
                                                    if(!empty($to_date)){
                                                        $queryrows = $queryrows . " AND DATE(tblnewsletter_subscribers.created) <= '".$to_date."'";
                                                    }
                                                    $resultrows     =   $fpdo->customResult($queryrows)->fetchAll();
                                                    if(count($resultrows) > 0) {
                                                        foreach ($resultrows as $row) {
                                                            $numrows = $row['numrows'];
                                                        }
                                                    }
                                                    $self       = $_SERVER['PHP_SELF'];
                                                    $querystring= "";
                                                    if(!empty($email)){
                                                        $querystring = $querystring . "&email=".$email."";
                                                    }
                                                    if(!empty($date_picker_range)){
                                                        $querystring = $querystring . "&date_picker_range=".$date_picker_range."";
                                                    }
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
        </section>
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myDeleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myDeleteLabel">Delete Newsletter ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>You have selected to delete this newsletter .</p>
                        <p>
                            If this was the action that you wanted to do,
                            please confirm your choice, or cancel and return
                            to the page.
                        </p>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        <form name="frmdelete" id="frmdelete" method="post" action="deletenewsletter.php">
                            <input type="hidden" name="delete" id="delete" value="1" />
                            <input type="hidden" name="id" id="id" value="0" />
                            <input type="hidden" name="page" id="page" value="<?php echo $pageNum; ?>" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" id="btndelete" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" media="screen">
        <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

        <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/moment.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" />

        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.NewsletterDisplay();
                    Admin.Utils.Newsletter.DeleteNewsletter();
            });
        </script>
    </body>
</html>
