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
            <h3>Configuration</h3>
            <div class="col-md-12"><div class="blank-border"></div></div>
            <?php if(!empty($_SESSION['configurationstatus'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <h4>Invalid!</h4>
                    <?php echo $errorlist['configuration'][$_SESSION['configurationstatus']]; ?>
                </div>
                <div class="clearfix"></div>
                <?php unset($_SESSION['configurationstatus']); } ?>

            <div class="clearfix"></div>
            <div class="middlesection margin-top20">

                <?php
                    if (!empty($_GET['edit']) && (int)$_GET['edit'] == 1) {
                        $edit   =   (int)$_GET['edit'];
                        $id     =   (int)$_GET['id'];

                        $sqlquery = $fpdo->from('tblconfigurations')
                                         ->where('tblconfigurations.id =:id ',array( ":id"=>$id) );
                        $rsdata   = $sqlquery->fetchAll();
                        if(count($rsdata) > 0) {
                            foreach($rsdata as $rowdata){
                                $meta_title             =   html_entity_decode($rowdata['meta_title'],ENT_QUOTES,"utf-8");
                                $meta_keyword           =   html_entity_decode($rowdata['meta_keyword'],ENT_QUOTES,"utf-8");
                                $meta_description       =   html_entity_decode($rowdata['meta_description'],ENT_QUOTES,"utf-8");
                                $website_title          =   trim($rowdata['website_title']);
                                
                                $from_email             =   trim($rowdata['from_email']);
                                $contact_email          =   trim($rowdata['contact_email']);
                                $feedback_email         =   trim($rowdata['feedback_email']);
                                $order_email            =   trim($rowdata['order_email']);
                                
                                $phone                  =   trim($rowdata['phone']);
                                $support_phone          =   trim($rowdata['support_phone']);
                                $fax                    =   trim($rowdata['fax']);
                                $address                =   trim($rowdata['address']);
                                $facebook_url           =   trim($rowdata['facebook_url']);
                                $google_plus_url        =   trim($rowdata['google_plus_url']);
                                $pinterest_url          =   trim($rowdata['pinterest_url']);
                                $twitter_url            =   trim($rowdata['twitter_url']);
                                $youtube_url            =   trim($rowdata['youtube_url']);
                                $instagram_url          =   trim($rowdata['instagram_url']);
                                $linkedin_url           =   trim($rowdata['linkedin_url']);
                                $google_analytics_code  =   html_entity_decode($rowdata['google_analytics_code'],ENT_QUOTES,"utf-8");
                            }
                        }
                    } else {
                        $edit                   =   0;
                        $id                     =   0;
                        $meta_title             =   null;
                        $meta_keyword           =   null;
                        $meta_description       =   null;
                        $website_title          =   null;
                        
                        $from_email             =   null;
                        $contact_email          =   null;
                        $feedback_email         =   null;
                        $order_email            =   null;
                        
                        $phone                  =   null;
                        $support_phone          =   null;
                        $fax                    =   null;
                        $address                =   null;
                        $facebook_url           =   null;
                        $google_plus_url        =   null;
                        $pinterest_url          =   null;
                        $twitter_url            =   null;
                        $youtube_url            =   null;
                        $instagram_url          =   null;;
                        $linkedin_url           =   null;
                        $google_analytics_code  =   null;
                        $minimum_amount         =  '';
                    }
                    $_SESSION['tokencode']  =   $DB->generateToken();
                ?>
                <div class="table-responsive">
                    <form name="addform" id="addform" method="post" action="configurationsave.php" enctype="multipart/form-data" target="_self">
                        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['tokencode'];?>" />
                        <input type="hidden" name="edit" id="edit" value="<?php echo $edit;?>" />
                        <input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
                        <table class="table table-bordered table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Website Title<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="website_title" id="website_title" value="<?php echo $website_title; ?>" maxlength="150" class="required form-control" placeholder="Enter Website Title"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">From Email<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="from_email" id="from_email" value="<?php echo $from_email; ?>" maxlength="150"  size="50"  class="required email form-control" placeholder="Enter From Email" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Contact Email<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="contact_email" id="contact_email" value="<?php echo $contact_email; ?>" maxlength="150"  size="50"  class="required email form-control" placeholder="Enter Contact PersonEmail" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Feedback Email<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="feedback_email" id="feedback_email" value="<?php echo $feedback_email; ?>" maxlength="150"  size="50"  class="required email form-control" placeholder="Enter Feedback Email" />
                                        </div>
                                    </td>
                                </tr>
                                <!--
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Support Email<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="support_email" id="support_email" value="<?php echo $support_email; ?>" maxlength="150"  size="50"  class="required email form-control" placeholder="Enter Support Email" />
                                        </div>
                                    </td>
                                </tr>
                                -->
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Order EMail<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="order_email" id="order_email"  value="<?php echo $order_email; ?>" maxlength="150" class="required email form-control" placeholder="Enter Order Email Address"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Fax</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="fax" id="fax" value="<?php echo $fax; ?>" maxlength="150" class="form-control" placeholder="Enter Fax"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Phone No.</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>" maxlength="150" class="required form-control" placeholder="Enter Pnone No." />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Support Phone No.</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-6">
                                            <input type="text" name="support_phone" id="support_phone" value="<?php echo $support_phone; ?>" maxlength="150" class="required form-control" placeholder="Enter Support Phone No." />
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><div class="text-right">Address</div></td>
                                    <td>
                                        <div class="col-md-12">
                                            <textarea cols="50" rows="2" name="address" id="address" placeholder="Please enter address" class="required form-control" cols="80"><?php echo $address; ?></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Facebook</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="facebook_url" id="facebook_url" value="<?php echo $facebook_url;?>" maxlength="250" size="70" class="form-control"  placeholder="Enter Facebook Link" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Google Plus</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="google_plus_url" id="google_plus_url" value="<?php echo $google_plus_url;?>" maxlength="250" size="70" class="form-control" placeholder="Enter Google Plus Link" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Pinterest</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="pinterest_url" id="pinterest_url" value="<?php echo $pinterest_url;?>" maxlength="250" size="70" class="form-control" placeholder="Enter Pinterest Link"  />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Twitter</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="twitter_url" id="twitter_url" value="<?php echo $twitter_url;?>" maxlength="250" size="70" class="form-control" placeholder="Enter Twitter Link"  />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">You Tube</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="youtube_url" id="youtube_url" value="<?php echo $youtube_url;?>" maxlength="250" size="70" class="form-control" placeholder="Enter You Tube Link" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Instagram</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="instagram_url" id="instagram_url" value="<?php echo $instagram_url;?>" maxlength="250" size="70" class="form-control" placeholder="Enter Instagram Link" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Linkedin</div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="linkedin_url" id="linkedin_url" value="<?php echo $linkedin_url;?>" maxlength="250" size="70" class="form-control" placeholder="Enter Linkedin Link" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><div class="text-right">Google Analytics</div></td>
                                    <td>
                                        <div class="col-md-12">
                                            <textarea cols="50" rows="2" name="google_analytics_code" id="google_analytics_code" placeholder="Please enter google analytics code" class="form-control" cols="80"><?php echo $google_analytics_code; ?></textarea>
                                        </div>
                                    </td>
                                </tr> 
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Meta Title<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="meta_title" id="meta_title" value="<?php echo $meta_title;?>" maxlength="70" class="form-control <?php if((int)$edit==1) { echo "required"; } ?> " placeholder="Enter Title"  title="Please enter title" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Meta Keyword <span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="meta_keyword" id="meta_keyword" value="<?php echo $meta_keyword;?>" maxlength="160" class="form-control <?php if((int)$edit==1) { echo "required"; } ?> control" title="Please enter meta keyword" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><div class="text-right">Meta Description<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                        <div class="col-md-12">
                                            <input type="text" name="meta_description" id="meta_description" value="<?php echo $meta_description;?>" maxlength="250" class="form-control <?php if((int)$edit==1) { echo "required"; } ?> control" title="Please enter meta description"/>
                                        </div>
                                    </td>
                                </tr>
                                <?php /*
                                    <tr>
                                    <td class="col-md-3"><div class="text-right">Minimum Order Amount<span class="text-danger">*</span></div></td>
                                    <td class="col-md-9">
                                    <div class="col-md-12">
                                    <input type="text" name="min_order_amount" id="min_order_amount" value="<?php echo $minimum_amount;?>" maxlength="160"  class="form-control control" title="Please enter Minimum order Amount"/>
                                    </div>
                                    </td>
                                    </tr>
                                */?>
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
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="js/jquery.smartmenus.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
        <link href="assets/plugins/bootstrap-summernote/css/summernote.css" rel="stylesheet">
        <script src="assets/plugins/bootstrap-summernote/js/summernote.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-summernote/js/texteditor.js"></script>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/3.4.4/select2.js"></script>

        <!--<link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.en.js" charset="UTF-8"></script>-->

        <link type="text/css" rel="stylesheet" href="assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" media="screen">
        <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

        <script type="text/javascript" src="js/admin.js"></script>
        <script type="text/javascript" src="js/jquery.validate.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                    Admin.Utils.Configuration.setDefaultMeta();
                    Admin.Utils.Configuration.validateConfiguration();
            });
        </script>
    </body>
</html>
