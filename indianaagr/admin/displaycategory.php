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
            <h3>Category</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <div class="clearfix"></div>
            <?php if(!empty($_SESSION['categorystatus'])) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['category'][$_SESSION['categorystatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['categorystatus']); } ?>
            <div class="pull-right"><a href="category.php" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Category</a></div>
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
                    $sqlquery   =   "SELECT * FROM tblcategories WHERE parent_id = 0 ORDER BY category_name";
                    //$sqlquery   =   $sqlquery . " LIMIT ".$offset.", ".$rowsPerPage."";
                     $sqlquery = $fpdo->from('tblcategories')
                                        ->where('tblcategories.parent_id =0 ')
                                        ->order('category_name');
                        $rsdata   = $sqlquery->fetchAll();
                    if (count($rsdata)>0) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1">Sr. No.</th>
                                    <th class="col-md-6">Category Name</th>
                                    <th class="col-md-2">Thumb Image</th>
                                    <!--<th class="col-md-1">Show Home</th>-->
                                    <th class="col-md-3">Status</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                    foreach($rsdata as $rowdata ){
                                        $intcnt = $intcnt+1;
                                        $level = 1;
                                    ?>
                                    <tr>
                                        <td><?php echo $intcnt; ?></td>
                                        <td><?php echo $rowdata['category_name']; ?></td>
                                        <td><?php if(!empty($rowdata['thumb_image'])){ ?><img src="../uploads/categories/<?php echo $rowdata['thumb_image']; ?>" max-width="150" height="100"/><?php } ?></td> 
                                        <td><span class="label <?php if ((int)$rowdata['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowdata['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
                                        <td><a href="category.php?id=<?php echo $rowdata['id']; ?>&edit=1" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Modify</a>  <!--&nbsp; <a href="deletecategory.php?=id<?php echo $rowdata['id']; ?>&delete=1" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>--></td>
                                    </tr>
                                    <?php display_children($rowdata['id'], $level); ?>
                                    <?php } ?>
                            </tbody>
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

        <?php
            // $parent_id is the parent id of the children we want to see
            // $level is increased when we go deeper into the tree, used to display a nice indented tree
            function display_children($parent_cat_id, $level) {
                global $DB;
                global $parent_id;
                global $intcnt;
                global $fpdo;
                // retrieve all children of $parent_cat_id
                $sqlquery = $fpdo->from('tblcategories')
                                 ->where('tblcategories.parent_id =:parent_id ',array( ":parent_id"=>$parent_cat_id) )
                                 ->order('category_name');
                $rssubcategories   = $sqlquery->fetchAll();
                if(count($rssubcategories)>0){
                    foreach($rssubcategories as $rowsubcategory){
                        $intcnt = $intcnt+1;
                        //indent and display the title of each child
                    ?>          <tr>
                        <td><?php echo $intcnt; ?></td>
                        <td><?php  echo str_repeat('- ',$level).$rowsubcategory['category_name'];?></td>
                        <td><?php if(!empty($rowsubcategory['thumb_image'])){ ?><img src="../uploads/categories/<?php echo $rowsubcategory['thumb_image']; ?>" max-width="150" height="100"/><?php } ?></td> 
                        <td><span class="label <?php if ((int)$rowsubcategory['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowsubcategory['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
                        <td><a href="category.php?id=<?php echo $rowsubcategory['id']; ?>&edit=1" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Modify</a> <!-- &nbsp; <a href="deletecategory.php?=id<?php //echo $rowsubcategory['id']; ?>&delete=1" class="btn btn-sm btn-danger"><i class="class="fa fa-trash></i> Delete</a></td>-->
                    </tr>
                    <?php
                        // call this function again to display category_name
                        // child's children
                        display_children($rowsubcategory['id'], $level+1);
                    }
                }
                return false;
            }
        ?>
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
                    Admin.Utils.Category.displayCategory();
            });
        </script>
    </body>
</html>
