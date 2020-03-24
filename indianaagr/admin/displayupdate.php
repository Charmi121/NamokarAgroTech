<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
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
            <h3>Company Updates</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <div class="clearfix"></div>
            <?php if(!empty($_SESSION['photostatus']) && $_SESSION['photostatus'] != "invalid") { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['updates'][$_SESSION['photostatus']]; ?>
                </div>
                <div class="clearfix"></div>
            <?php unset($_SESSION['photostatus']); } ?>
            
            <?php if(!empty($_SESSION['photostatus']) && $_SESSION['photostatus'] == "invalid") { ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Error!</h4>
                    <?php echo $errorlist['updates'][$_SESSION['photostatus']]; ?>
                </div>
                <div class="clearfix"></div>
            <?php unset($_SESSION['photostatus']); } ?>
            
            <div class="pull-right"><a href="company-update.php" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Updates</a></div>
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
                    
                    $sqlquery = $fpdo->from('tblcompany_update')
                                     ->order('tblcompany_update.sort_order = 0, tblcompany_update.sort_order ASC');
                    $rsdata   = $sqlquery->fetchAll();
                    if (count($rsdata) > 0) {
                ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">Sr. No.</th>
                                    <th class="col-md-4">Title</th>
									<th class="col-md-4">Description</th>
                                    <th class="col-md-2">Thumb Image</th>
                                    <th class="col-md-2">Sort Order</th>
                                    <th class="col-md-1">Status</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                    foreach($rsdata as $rowdata){
                                        $intcnt = $intcnt + 1;
                                        $level = 1;
                                ?>
                                    <tr>
                                        <td><?php echo $intcnt; ?></td>
                                        <td><?php echo $rowdata['title']; ?></td>
										<td><?php echo $rowdata['description']; ?></td>
                                        <td><?php if(!empty($rowdata['thumb_image'])){ ?><img src="../uploads/news-event/<?php echo $rowdata['thumb_image']; ?>" max-width="150" height="100"/><?php } ?></td> 
                                        <td><?php echo $rowdata['sort_order']; ?></td>
                                        <td><span class="label <?php if ((int)$rowdata['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowdata['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
                                        <td><a href="company-update.php?id=<?php echo $rowdata['id']; ?>&edit=1" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Modify</a>  &nbsp; <a href="javascript:void(0);" data-id="<?php echo $rowdata['id']; ?>" class="btn btn-sm btn-danger adelete" data-toggle="modal" data-target="#modalDelete"><i class="fa fa-trash"></i> Delete</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myDeleteLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                  <h4 class="modal-title" id="myDeleteLabel">Delete Company updates?</h4>
                              </div>
                              <div class="modal-body">
                               <p>You have selected to delete this Company updates.</p>
                               <p>
                                   If this was the action that you wanted to do,
                                   please confirm your choice, or cancel and return
                                   to the page.
                               </p>
                               <div class="clearfix"></div>
                              </div>
                              <div class="modal-footer">
                                <form name="frmdelete" id="frmdelete" method="post" action="deletecompany-update.php">
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
                    
                <?php } else { ?>
                    <table class="table">
                        <tr>
                            <td class="text-center">No Record Found</td>
                        </tr>
                    </table>
                <?php } ?>
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
                Admin.Utils.Photo.deletePhoto();
            });
        </script>
    </body>
</html>
