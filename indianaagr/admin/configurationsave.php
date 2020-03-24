<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('rightusercheck.php');
    require_once('paging.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: configuration.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit                   =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id                     =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $meta_title             =   (!empty($_POST['meta_title'])) ?  htmlentities($_POST['meta_title'],ENT_QUOTES,"utf-8") : null;
    $meta_keyword           =   (!empty($_POST['meta_keyword'])) ? htmlentities($_POST['meta_keyword'],ENT_QUOTES,"utf-8") :null;
    $meta_description       =   (!empty($_POST['meta_description'])) ? htmlentities($_POST['meta_description'],ENT_QUOTES,"utf-8") : null;
    $website_title          =   (!empty($_POST['website_title'])) ? trim($_POST['website_title']) : null;
    $from_email             =   (!empty($_POST['from_email'])) ? trim($_POST['from_email']) : null;
    $contact_email          =   (!empty($_POST['contact_email'])) ? trim($_POST['contact_email']) : null;
    $feedback_email         =   (!empty($_POST['feedback_email'])) ? trim($_POST['feedback_email']) : null;
    $order_email            =   (!empty($_POST['order_email'])) ? trim($_POST['order_email']) : null;
    $phone                  =   (!empty($_POST['phone'])) ? trim($_POST['phone']) : null;
    $support_phone          =   (!empty($_POST['support_phone'])) ? trim($_POST['support_phone']) : null;
    $fax                    =   (!empty($_POST['fax'])) ? trim($_POST['fax']) : null;
    $address                =   (!empty($_POST['address'])) ? htmlentities($_POST['address'],ENT_QUOTES,"utf-8") : null;
    $facebook_url           =   (!empty($_POST['facebook_url'])) ? htmlentities($_POST['facebook_url'],ENT_QUOTES,"utf-8") : null;
    $google_plus_url        =   (!empty($_POST['google_plus_url'])) ? htmlentities($_POST['google_plus_url'],ENT_QUOTES,"utf-8") : null;
    $pinterest_url          =   (!empty($_POST['pinterest_url'])) ? htmlentities($_POST['pinterest_url'],ENT_QUOTES,"utf-8") : null;
    $twitter_url            =   (!empty($_POST['twitter_url'])) ? htmlentities($_POST['twitter_url'],ENT_QUOTES,"utf-8") : null;
    $youtube_url            =   (!empty($_POST['youtube_url'])) ? htmlentities($_POST['youtube_url'],ENT_QUOTES,"utf-8") : null;
    $instagram_url          =   (!empty($_POST['instagram_url'])) ? htmlentities($_POST['instagram_url'],ENT_QUOTES,"utf-8") : null;
    $linkedin_url           =   (!empty($_POST['linkedin_url'])) ? htmlentities($_POST['linkedin_url'],ENT_QUOTES,"utf-8") : null;
    $google_analytics_code  =   (!empty($_POST['google_analytics_code'])) ? htmlentities($_POST['google_analytics_code'],ENT_QUOTES,"utf-8") : null;

    //$min_order_amount       =   (!empty($_POST['min_order_amount'])) ? trim($_POST['min_order_amount']) : null;
    $action                 =    0;

    if (isset($edit) && !empty($website_title)) {
        if ((int)$edit == 0){
            $sqlquery   =  "INSERT INTO tblconfigurations (meta_title, meta_keyword, meta_description, website_title,from_email, contact_email, feedback_email, order_email, phone, support_phone, fax, address, facebook_url, google_plus_url, pinterest_url, twitter_url, youtube_url, instagram_url, linkedin_url, google_analytics_code ) ";
            $sqlquery   =  $sqlquery." VALUES('".$meta_title."', '".$meta_keyword."', '".$meta_description."', '".$website_title."', '".$from_email."', '".$contact_email."', '".$feedback_email."','".$order_emaill."', '".$phone."', '".$support_phone."','".$fax."','".$address."', '".$facebook_url."','".$google_plus_url."','".$pinterest_url."','".$twitter_url."', '".$youtube_url."', '".$instagram_url."', '".$linkedin_url."', '".$google_analytics_code."' )";
            $rsdata     =  $fpdo->customResult($sqlquery);
            $action     =  1;
        } else {
            $sqlquery   =  "UPDATE tblconfigurations SET meta_title = '".$meta_title."', meta_keyword = '".$meta_keyword."', meta_description = '".$meta_description."', website_title = '".$website_title."', from_email = '".$from_email."', contact_email = '".$contact_email."', feedback_email = '".$feedback_email."', order_email = '".$order_email."', phone = '".$phone."', support_phone = '".$support_phone."', fax = '".$fax."', address = '".$address."', facebook_url = '".$facebook_url."', google_plus_url = '".$google_plus_url."', pinterest_url = '".$pinterest_url."', twitter_url = '".$twitter_url."', youtube_url = '".$youtube_url."', instagram_url = '".$instagram_url."', linkedin_url = '".$linkedin_url."', google_analytics_code = '".$google_analytics_code."'  ";
            $sqlquery   =  $sqlquery." WHERE id = ".$id."";
            $rsdata     =  $fpdo->customResult($sqlquery);
            $action     =  2;
        }
    }

    if ((int)$action == 1) {
        $_SESSION['configurationstatus'] =   "add";
        header("Location: displayconfiguration.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['configurationstatus'] =   "update";
        header("Location: displayconfiguration.php");
        exit;
    } else {
        $_SESSION['configurationstatus'] =   "invalid";
        header("Location: displayconfiguration.php");
        exit;
    }
?>