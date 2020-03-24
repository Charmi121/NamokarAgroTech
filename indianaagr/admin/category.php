<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
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

            <?php if(!empty($_SESSION['categorystatus']) &&  $_SESSION['categorystatus']=="invalid" ) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['category'][$_SESSION['categorystatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['categorystatus']);
                } elseif(!empty($_SESSION['categorystatus']) &&  $_SESSION['categorystatus']!="invalid") {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['category'][$_SESSION['categorystatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['categorystatus']); } ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                    if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1)
                    {
                        $edit   =   (int)$_GET['edit'];
                        $id     =   (int)$_GET['id'];

                        $sqlquery = $fpdo->from('tblcategories')
                                          ->where('tblcategories.id =:id ',array( ":id"=>$id) );
                        $rsdata   = $sqlquery->fetchAll();
                        if(count($rsdata) > 0) {
                            foreach($rsdata as $rowdata ) {
                                $meta_title             =   html_entity_decode($rowdata['meta_title'],ENT_QUOTES,"utf-8");
                                $meta_keyword           =   html_entity_decode($rowdata['meta_keyword'],ENT_QUOTES,"utf-8");
                                $meta_description       =   html_entity_decode($rowdata['meta_description'],ENT_QUOTES,"utf-8");
                                $category_name          =   trim($rowdata['category_name']);
                                $seo_url                =   trim($rowdata['seo_url']);
                                $short_description      =   html_entity_decode($rowdata['short_description'],ENT_QUOTES,"utf-8");
                                $description            =   html_entity_decode($rowdata['description'],ENT_QUOTES,"utf-8");
                                $category_logo          =   trim($rowdata['category_logo']);
                                $thumb_image            =   trim($rowdata['thumb_image']);
                                $medium_image           =   trim($rowdata['medium_image']);
                                $background_image       =   trim($rowdata['background_image']);
                                $banner_image           =   trim($rowdata['banner_image']);
                                $parent_id              =   (int)$rowdata['parent_id'];
                                $show_home              =   (int)$rowdata['show_home'];
                                $sort_order             =   (int)$rowdata['sort_order'];
                                $status                 =   (int)$rowdata['status'];
                            }
                        }
                    } else {
                        $edit               =   0;
                        $id                 =   0;
                        $meta_title         =   null;
                        $meta_keyword       =   null;
                        $meta_description   =   null;
                        $category_name      =   null;
                        $seo_url            =   null;
                        $short_description  =   null;
                        $description        =   null;
                        $category_logo      =   null;
                        $thumb_image        =   null;
                        $medium_image       =   null;    
                        $background_image   =   null;
                        $banner_image       =   null;
                        $parent_id          =   0;
                        $show_home          =   0;
                        $sort_order         =   0;
                        $status             =   0;
                    }
                    $_SESSION['tokencode']  =   $DB->generateToken();
                ?>
                <form name="addform" id="addform" method="post" action="categorysave.php" enctype="multipart/form-data" target="_self">
                    <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                    <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                    <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                    <table class="table table-bordered table-striped table-condensed">
                        <tbody>
                            <tr>
                                <td class="col-md-3"><div class="text-right">Select Parent</div></td>
                                <td class="col-md-9">
                                    <div class="col-md-9">
                                        <select id="parent_id" name="parent_id" class="parent control" style="width:60%"  placeholder="Select Parent Category">
                                            <option value="0">No Parent</option>
                                            <?php
                                                $level = 0;
                                                $sqlquery    = "SELECT * FROM tblcategories WHERE parent_id = 0";
                                                if(!empty($edit) && !empty($id) ) {
                                                    $sqlquery    = $sqlquery ." AND id !=".$id."";
                                                }
                                                //$sqlquery    = $sqlquery ." AND status = 707 ORDER BY category_name";
                                                $sqlquery    = $sqlquery ." ORDER BY category_name";
                                                $rsparentcat =   $fpdo->customResult($sqlquery)->fetchAll();
                                                if(count($rsparentcat) > 0) {
                                                    foreach ($rsparentcat as $rowparentcat) {
                                                        $level = 1;

                                            ?>
                                                    <option value="<?php echo $rowparentcat['id'];?>" <?php if((int)$rowparentcat['id'] == $parent_id){ echo "selected=\"selected\""; } ;?>><?php echo $rowparentcat['category_name'];?> </option>
                                                    <?php display_children($rowparentcat['id'], $level); ?>
                                            <?php
                                                    }
                                                }
                                            ?>
                                            <?php
                                                // $parent_id is the parent id of the children we want to see
                                                // $level is increased when we go deeper into the tree, used to display a nice indented tree
                                                function display_children($parent_cat_id, $level) {
                                                    global $fpdo;
                                                    global $parent_id;
                                                    global $edit;
                                                    global $id;
                                                    // retrieve all children of $parent_cat_id
                                                    $sqlquery    = "SELECT * FROM tblcategories WHERE parent_id =".$parent_cat_id."";
                                                    if(!empty($edit) && !empty($id) ) {
                                                        $sqlquery  = $sqlquery ." AND id !=".$id."";
                                                    }
                                                    $sqlquery  = $sqlquery ." AND status = 707 ORDER BY category_name";
                                                    $rssubcategories = $fpdo->customResult($sqlquery)->fetchAll();
                                                    foreach($rssubcategories as $rowsubcategory ){
                                                        // indent and display the title of each child
                                            ?>
                                                    <option value="<?php echo $rowsubcategory['id'];?>" <?php if((int)$rowsubcategory['id'] == $parent_id){ echo "selected=\"selected\""; } ;?>><?php  echo str_repeat('- ',$level).$rowsubcategory['category_name'];?> </option>
                                            <?php
                                                        // call this function again to display category_name
                                                        // child's children
                                                        display_children($rowsubcategory['id'], $level+1);
                                                    }
                                                    return false;
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Category Name<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="category_name" id="category_name" value="<?php echo $category_name; ?>" maxlength="150" class="required form-control" placeholder="Enter Category Name" title="Please enter category name"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">SEO URL<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="seo_url" id="seo_url" value="<?php echo $seo_url; ?>" maxlength="150" class="required form-control" placeholder="Enter SEO URL" title="Please enter SEO URL" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Caption</div></td>
                                <td>
                                    <div class="col-md-12">
                                        <textarea cols="50" rows="2" name="short_description" id="short_description" placeholder="Please enter caption" class="form-control"><?php echo $short_description; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Description</div></td>
                                <td>
                                    <div class="col-md-12">
                                        <textarea cols="50" rows="2" name="description" id="description" placeholder="Please enter description" class="form-control inbox-editor inbox-wysihtml5"><?php echo $description; ?></textarea>
                                    </div>
                                </td>
                            </tr>
							<?php if(!empty($category_logo) && (int)$DB->checkfileexist("../uploads/category_logos/".$category_logo."") == 707 ){ ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Logo</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/category_logos/<?php echo $category_logo; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/category_logos/".$category_logo; ?>" download="<?php echo $category_logo; ?>" class="btn btn-sm btn-info">Download File</a>
                                            &nbsp; <a href="deletecategoryfile.php?id=<?php echo $id;?>&filename=<?php echo $category_logo; ?>&filetype=category_logo&delete=1" class="btn btn-sm btn-danger adelete">Delete File</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
							<tr>
                                <td><div class="text-right">Upload Category Logo</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="file" name="category_logo" id="category_logo" class="control" /><span class="text-danger">Best Size (width x height): 19 X 20 | Best file format PNG</span>
                                    </div>
                                </td>
                            </tr>
                            <?php if(!empty($thumb_image) && (int)$DB->checkfileexist("../uploads/categories/".$thumb_image."") == 707 ){ ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Thumb Image</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/categories/<?php echo $thumb_image; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/categories/".$thumb_image; ?>" download="<?php echo $thumb_image; ?>" class="btn btn-sm btn-info">Download File</a>
                                            &nbsp; <a href="deletecategoryfile.php?id=<?php echo $id;?>&filename=<?php echo $thumb_image; ?>&filetype=thumb_image&delete=1" class="btn btn-sm btn-danger adelete">Delete File</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td><div class="text-right">Upload Thumb Image</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="file" name="thumb_image" id="thumb_image" class="control" /><span class="text-danger">Best Size (width x height): 500 X 500 | Best file format JPG</span>
                                    </div>
                                </td>
                            </tr>
                            <?php if(!empty($medium_image) && (int)$DB->checkfileexist("../uploads/categories/".$medium_image."") == 707 ){ ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Thumb Image</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/categories/<?php echo $medium_image; ?>" style="max-width:600px;" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/categories/".$medium_image; ?>" download="<?php echo $medium_image; ?>" class="btn btn-sm btn-info">Download File</a>
                                            &nbsp; <a href="deletecategoryfile.php?id=<?php echo $id;?>&filename=<?php echo $medium_image; ?>&filetype=medium_image&delete=1" class="btn btn-sm btn-danger adelete">Delete File</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><div class="text-right">Upload Medium Image</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="file" name="medium_image" id="medium_image" class="control" /><span class="text-danger">Best Size (width x height): 950 X 740 | Best file format JPG</span>
                                    </div>
                                </td>
                            </tr>


                            <?php /* if(!empty($background_image) && (int)$DB->checkfileexist("../uploads/categories/".$background_image."") == 707 ){ ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Background Image</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/categories/<?php echo $background_image; ?>" style="max-width: 700px;"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/categories/".$background_image; ?>" download="<?php echo $background_image; ?>" class="btn btn-sm btn-info">Download File</a>
                                            &nbsp; <a href="deletecategoryfile.php?id=<?php echo $id;?>&filename=<?php echo $background_image; ?>&filetype=background_image&delete=1" class="btn btn-sm btn-danger adelete">Delete File</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td><div class="text-right">Upload Background Image</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="file" name="background_image" id="background_image" class="control" /><br /><span class="text-danger">Best Size (width x height): 533 X 247</span>
                                    </div>
                                </td>
                            </tr>
							*/ ?>

                            <?php if(!empty($banner_image) && (int)$DB->checkfileexist("../uploads/categories/".$banner_image."") == 707 ){ ?>
                                <tr>
                                    <td><div class="text-right">Previously Uploaded Banner Image</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <img src="../uploads/categories/<?php echo $banner_image; ?>" style="max-width: 700px;"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">&nbsp;</div></td>
                                    <td>
                                        <div class="col-md-9">
                                            <a href="<?php echo "../uploads/categories/".$banner_image; ?>" download="<?php echo $banner_image; ?>" class="btn btn-sm btn-info">Download File</a>
                                            &nbsp; <a href="deletecategoryfile.php?id=<?php echo $id;?>&filename=<?php echo $banner_image; ?>&filetype=banner_image&delete=1" class="btn btn-sm btn-danger adelete">Delete File</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php }  ?>

                            <tr>
                                <td><div class="text-right">Upload Banner Image</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="file" name="banner_image" id="banner_image" class="control" /><br /><span class="text-danger">Best Size (width x height): 1600 X 375</span>
                                    </div>
                                </td>
                            </tr>
                          
                            
                            <tr>
                                <td><div class="text-right">Show on Homepage?</div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="checkbox" name="show_home" id="show_home" value="1" <?php if($show_home == 1) { echo "checked = \"checked\"";} ?> />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Meta Title<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="meta_title" id="meta_title" value="<?php echo $meta_title;?>" maxlength="70" class="required form-control" title="Please enter meta title" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Meta Keyword <span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $meta_keyword;?>" maxlength="160" class="required form-control" title="Please enter meta keyword" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><div class="text-right">Meta Description<span class="text-danger">*</span></div></td>
                                <td>
                                    <div class="col-md-9">
                                        <input type="text" name="meta_description" id="meta_description" value="<?php echo $meta_description;?>"  maxlength="250" class="required form-control" title="Please enter meta description"/>
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

        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
        <link href="assets/plugins/bootstrap-summernote/css/summernote.css" rel="stylesheet">
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/summernote.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/texteditor.js"></script>

        <link type="text/css" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css" />
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.initSummerNote();
                    Admin.Utils.Category.initCategory();
                    Admin.Utils.Category.validateCategory();
                    Admin.Utils.Category.imageDelete();
            });
        </script>
    </body>
</html>
