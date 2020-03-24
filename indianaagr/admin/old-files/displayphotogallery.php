<?php
    header('Cache-Control: max-age=900');
	require_once('session.php');
	require_once('rightusercheck.php');
	require_once('connect.inc.php');
	require_once('config.php');
	require_once('main.php');
	require_once('errorcodes.php');
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
            <h3>Photo Gallery</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <div class="clearfix"></div>
            <?php if(!empty($_SESSION['photogallerystatus'])) { ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['photo'][$_SESSION['photogallerystatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['photogallerystatus']); } ?>
            <div class="pull-right"><a href="photogallery.php" class="btn btn-info"><i class="fa fa-plus-circle"></i> Add Photo Gallery</a></div>
            <div class="clearfix"></div>
            <?php
                /* $photo_category_id   =   (!empty($_REQUEST['photo_category_id'])) ? (int)$DB->cleanInput($_REQUEST['photo_category_id']): 0;
                $title               =   (!empty($_REQUEST['title'])) ? $DB->cleanInput($_REQUEST['title']): null; */
            ?>
			<?php /*
            <div class="form-actions margin-top20">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Filter Search Result <a id="apanel" href="#" class="pull-right"><i class="fa fa-plus-circle"></i></a></div>
                            <div class="panel-body">
                                <form method="post" action="displayphotogallery.php" name="addform" id="addform">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="photo_category_id">Category</label>
                                            <select id="photo_category_id" name="photo_category_id" class="photo_category select2" style="width:220px;"  placeholder="Select Category">
                                                <option value="0" <?php if((int)$photo_category_id == 0){ echo "selected = \"selected\"";} ?>>Select Category</option>
                                                <?php
                                                    $sqlquery = $fpdo->from("tblphoto_categories")
																   ->where("status = 707")
																   ->order("tblphoto_categories.photo_category_name");
													$rscategory = $sqlquery->fetchAll();
													if (count($rscategory)>0) 
                                                    {   
														foreach($rscategory as $rowcategory)
                                                        {
                                                        ?>
                                                        <option value="<?php echo $rowcategory['id']?>" <?php if((int)$rowcategory['id'] == (int)$photo_category_id) { echo "selected='selected'"; } ?> ><?php echo $rowcategory['photo_category_name']; ?></option>
                                                        <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!--<div class="col-md-4">
                                    <div class="form-group">
                                    <label for="product_name">Title</label>
                                    <input type="text" name="title" id="title" value="<?php //echo stripslashes($title);?>" class="form-control" />
                                    </div>
                                    </div> -->

                                    <div class="col-md-8">
                                        <div class="form-group text-right margin-top20">
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
			*/ ?>
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
					$sqlquery = $fpdo->from("tblphoto_galleries")
									   ->select(null)
									   ->select("tblphoto_galleries.*")
									   //->innerJoin("tblphoto_categories ON tblphoto_categories.id = tblphoto_galleries.photo_category_id")
									   ->where("tblphoto_galleries.id != 0");
                    /* if(!empty($photo_category_id)){
                       $sqlquery->where(" AND tblphoto_galleries.photo_category_id =".$photo_category_id."");   
                    } */
						$sqlquery->order("tblphoto_galleries.id DESC");
                    //$sqlquery   =   $sqlquery . " LIMIT ".$offset.", ".$rowsPerPage."";
                    $rsdata     =   $sqlquery->fetchAll();
                    if (count($rsdata)>0) 
                    {
                    ?>
                    <form name="addform" id="addform" method="post" action="deletephotogallery.php">
                        <input type="hidden" name="delete" id="delete" value="1"/>
                        <input type="hidden" name="photo_category_id" id="photo_category_id" value="0"/>
                        <input type="hidden" name="page" id="page" value="<?php echo $pageNum; ?>" />
                        <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
                        <input type="hidden" name="rowsperpage" id="rowsperpage" value="<?php echo $rowsPerPage; ?>" /> 
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-md-1">Sr. No.</th>
                                        <!-- <th class="col-md-2">Category Name</th> -->
                                        <th class="col-md-2">Title</th>
                                        <th class="col-md-2">Thumb Image</th>
                                        <th class="col-md-3">Status</th>
                                        <th class="col-md-2" colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $intcnt = ($pageNum * $rowsPerPage) - $rowsPerPage;
                                        foreach($rsdata as $rowdata){
                                            $intcnt = $intcnt+1;
                                            $level = 1;
                                        ?>
                                        <tr>
                                            <td><?php echo $intcnt; ?></td>
                                            <!-- <td><?php //echo $rowdata['photo_category_name']; ?></td> -->
                                            <td><?php echo $rowdata['title']; ?></td>
                                            <td><?php if(!empty($rowdata['thumb_image'])){ ?><img src="../uploads/photo-galleries/<?php echo $rowdata['thumb_image']; ?>" max-width="150" height="100"/><?php } ?></td> 
                                            <td><span class="label <?php if ((int)$rowdata['status'] == 707) { echo "label-success"; } else { echo "label-danger"; } ?>"><?php if ((int)$rowdata['status'] == 707) { echo "Enable"; } else { echo "Disable"; } ?></span></td>
                                            <td>
                                                <a href="editphotogallery.php?id=<?php echo $rowdata['id']; ?>&edit=1" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Modify</a>  <!--&nbsp; <a href="deletephotogallery.php?=id<?php //echo $rowdata['id']; ?>&delete=1" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>-->
                                            </td>
                                            <td>
                                                <input type="checkbox" name="deletephotogallery<?php echo $rowdata['id']; ?>" id="deletephotogallery<?php echo $rowdata['id']; ?>" value="707" />
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <tr>
                                        <td colspan="5">&nbsp;</td>
                                        <td style="text-align:center;"><input type="submit" name="delete" id="delete" value="Delete" class="btn btn-md btn-danger adelete"></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <div class="pagination">
                                                <?php
													$queryrows = $fpdo->from("tblphoto_galleries")
																	   ->select(null)
																	   ->select("COUNT(*) AS numrows")
																	   ->where("tblphoto_galleries.id != 0");
                                                    /* if(!empty($photo_category_id)){
                                                       $queryrows->where(" AND tblphoto_galleries.photo_category_id =".$photo_category_id."");   
                                                    } */
                                                    $resultrows = $queryrows->fetchAll();
                                                    $numrows    = $resultrows[0]['numrows'];
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
                    </form>
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

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.PhotoGallery.displayPhotoGallery();
                    Admin.Utils.PhotoGallery.deletePhotoGallery();
            });
        </script>
    </body>
</html>