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
            <h3>Page</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <?php if(!empty($_SESSION['pagestatus']) &&  $_SESSION['pagestatus']=="invalid" ) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['page'][$_SESSION['pagestatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['pagestatus']);
                } elseif(!empty($_SESSION['pagestatus']) &&  $_SESSION['pagestatus']!="invalid") {
                ?>
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Success!</h4>
                    <?php echo $errorlist['page'][$_SESSION['pagestatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['pagestatus']); } ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                    if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1){
                        $edit = (int)$_GET['edit'];
                        $id = (int)$_GET['id'];

                        $sqlquery = $fpdo->from('tblpages')
                                         ->where('tblpages.id =:id ',array( ":id"=>$id) );
                        $rsdata   = $sqlquery->fetchAll();
                        if(COUNT($rsdata) > 0){
                            foreach($rsdata as $rowdata ){
                                $meta_title          =   html_entity_decode($rowdata['meta_title'],ENT_QUOTES,"utf-8");
                                $meta_keyword        =   html_entity_decode($rowdata['meta_keyword'],ENT_QUOTES,"utf-8");
                                $meta_description    =   html_entity_decode($rowdata['meta_description'],ENT_QUOTES,"utf-8");
                                $page_title          =   trim($rowdata['page_title']);
                                $seo_url             =   trim($rowdata['seo_url']);
                                $description         =   html_entity_decode($rowdata['description'],ENT_QUOTES,"utf-8");
                                $thumb_image         =   trim($rowdata['thumb_image']);
                                $big_image           =   trim($rowdata['big_image']);
                                $banner_image        =   trim($rowdata['banner_image']);
                                $sort_order          =   (int)$rowdata['sort_order'];
                                $status              =   (int)$rowdata['status'];
                            }
                        }
                    } else {
                        $edit                =   0;
                        $id                  =   0;
                        $meta_title          =   null;
                        $meta_keyword        =   null;
                        $meta_description    =   null;
                        $page_title          =   null;
                        $seo_url             =   null;
                        $description         =   null;
                        $thumb_image         =   null;
                        $big_image           =   null;
                        $banner_image        =   null;
                        $sort_order          =   0;
                        $status              =   0;
                    }
                    $_SESSION['tokencode']  =   $DB->generateToken();
                ?>
                <div class="table-responsive">
                    <form name="addform" id="addform" method="post" action="pagessave.php"  enctype="multipart/form-data" target="_self">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                        <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                        <table class="table table-bordered table-striped table-condensed">
                            <tbody>

                                <tr>
                                    <td class="col-md-2"><div class="text-right">Page Title<span class="text-danger">*</span></div></td>
                                    <td class="col-md-10">
                                        <div class="col-md-6">
                                            <input type="text" name="page_title" id="page_title" value="<?php echo $page_title; ?>" maxlength="150" class="required form-control" title="Please enter page title"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-2"><div class="text-right">SEO URL<span class="text-danger">*</span></div></td>
                                    <td class="col-md-10">
                                        <div class="col-md-6">
                                            <input type="text" name="seo_url" id="seo_url" value="<?php echo $seo_url; ?>" maxlength="150" class="form-control"  size="50"  title="Please enter SEO URL" readonly="readonly" />
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

                                <?php if(!empty($banner_image) && (int)$DB->checkfileexist("../uploads/pages/".$banner_image."") == 707 ){ ?>
                                    <tr>
                                        <td><div class="text-right">Previously Uploaded Banner Image</div></td>
                                        <td><img src="<?php echo DISPLAYPATH; ?>pages/<?php echo $banner_image; ?>" width="300"/></td>
                                    </tr>
                                    <tr>
                                        <td><div class="text-right">&nbsp;</div></td>
                                        <td>
                                            <a href="<?php echo "../uploads/pages/".$banner_image; ?>" download="<?php echo $banner_image; ?>" class="btn btn-mini btn-info">Download File</a>
                                            &nbsp; <a href="deletepagesfile.php?id=<?php echo $id;?>&filename=<?php echo $banner_image; ?>&filetype=banner_image&delete=1" class="btn btn-mini btn-danger adelete">Delete File</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td><div class="text-right">Upload Banner Image</div></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" name="banner_image" id="banner_image" class="control" /><br /><span class="text-danger">Best Size (width x height): 1700 X 247</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-2"><div class="text-right">Meta Title<span class="text-danger">*</span></div></td>
                                    <td class="col-md-10">
                                        <div class="col-md-9">
                                            <input type="text" name="meta_title" id="meta_title" value="<?php echo $meta_title;?>" maxlength="70" class="form-control required control"   title="Please enter meta title" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-2"><div class="text-right">Meta Keyword <span class="text-danger">*</span></div></td>
                                    <td class="col-md-10">
                                        <div class="col-md-9">
                                            <input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $meta_keyword;?>" maxlength="160"  class="form-control required control" title="Please enter meta keyword" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-2"><div class="text-right">Meta Description<span class="text-danger">*</span></div></td>
                                    <td class="col-md-10">
                                        <div class="col-md-9">
                                            <input type="text" name="meta_description" id="meta_description" value="<?php echo $meta_description;?>" maxlength="250"  class="form-control required control" title="Please enter meta description"/>
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
                                            <!--<a href="displaydeals.php" class="btn btn-warning"><i class="fa fa-undo"></i> Cancel</a>-->
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="js/jquery.smartmenus.js"></script>
        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
        
        <link href="assets/plugins/bootstrap-summernote/css/summernote.css" rel="stylesheet">
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/summernote.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/texteditor.js"></script>

        <script type="text/javascript" src="js/jquery.validate.js"></script>
        
        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.initSummerNote();
                    Admin.Utils.Page.initPage();
                    Admin.Utils.Page.seoURL();
                    Admin.Utils.Page.validatePage();
                    Admin.Utils.Page.deletePageImages();
            });
        </script>
    </body>
</html>
