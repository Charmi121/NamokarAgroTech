<?php
    defined('ECOMMERCE') or die;
    ini_set("session.gc_maxlifetime",3*60*60);
    ini_set("session.gc_probability",1);
    ini_set("session.gc_divisor",1);
    //date_default_timezone_set('Australia/Adelaide');
    date_default_timezone_set('Asia/Kolkata');
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
    $inactive = 108000;

    if(isset($_SESSION['ecommerce']['timeout'])) {
        $session_life = time() - $_SESSION['ecommerce']['timeout'];
        if($session_life > $inactive)
        { session_destroy(); header("Location: index.html"); exit(); }
    }
    $_SESSION['ecommerce']['timeout'] = time();

    $_SESSION['ecommerce']['session_id'] = (!empty($_SESSION['ecommerce']['session_id'])) ? $_SESSION['ecommerce']['session_id'] : session_id();

    if (!defined('DS')) {
        define('DS', "/");
    }

    if (!defined('ROOT')) {
        define('ROOT', dirname(__FILE__));
    }

    if(!defined('PROTOCOL')) {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        define('PROTOCOL', $protocol);
    }

    if (!defined('HTTP_HOST')) {
        define('HTTP_HOST', $_SERVER['HTTP_HOST']);
    }

    if (!defined('CURRENT_DIRECTORY')) {
        define('CURRENT_DIRECTORY', basename(__DIR__));
    }

    if (!defined('BASEURL')) {
        define('BASEURL', PROTOCOL.HTTP_HOST.DS.CURRENT_DIRECTORY.DS);
        //define('BASEURL', PROTOCOL.HTTP_HOST.DS);
        //define('BASEURL', PROTOCOL.HTTP_HOST.DS."demo/ark-stone/website".DS);
    }

    if(!defined('CONFIG_PATH')) {
        define('CONFIG_PATH', DS.CURRENT_DIRECTORY.DS);
        //define('CONFIG_PATH', DS);
        //define('CONFIG_PATH', DS."demo/ark-stone/website".DS);
    }

    if (!defined('UPLOAD_PATH')) {
        define('UPLOAD_PATH', realpath(dirname(__FILE__) . DS.'uploads'));
    }

    if (!defined('DISPLAY_PATH')) {
        define('DISPLAY_PATH', BASEURL.'uploads');
    }

    if (!defined('RECORDS_PER_PAGE')) {
        define('RECORDS_PER_PAGE', 56);
    }

    if (!defined('STORE_CONFIG')) {
        define('STORE_CONFIG', true);
        $sqlquery = $fpdo->from('tblconfigurations')
                         ->limit(1);
        $rsconfig = $sqlquery->execute();
        if(count($rsconfig) > 0) {
            foreach ($rsconfig as $rowconfig) {
                define("STORE_METATITLE", trim($rowconfig['meta_title']));
                define("STORE_METAKEYWORD", trim($rowconfig['meta_keyword']));
                define("STORE_METADESCRIPTION", trim($rowconfig['meta_description']));
                define('STORE_WEBSITETITLE', $rowconfig['website_title']);

                define('STORE_FROMEMAIL', $rowconfig['from_email']);
                define('STORE_CONTACTEMAIL', $rowconfig['contact_email']);
                define('STORE_ORDEREMAIL', $rowconfig['order_email']);
                define('STORE_FEEDBACKEMAIL', $rowconfig['feedback_email']);

                define('STORE_PHONENO', $rowconfig['phone']);
                define('STORE_FAX', $rowconfig['fax']);
                define('STORE_ADDRESS', $rowconfig['address']);

                define("STORE_FACEBOOK", trim($rowconfig['facebook_url']));
                define("STORE_TWITTER", trim($rowconfig['twitter_url']));
                define("STORE_GOOGLEPLUS", trim($rowconfig['google_plus_url']));
                define("STORE_PINTEREST", trim($rowconfig['pinterest_url']));
                define("STORE_INSTAGRAM", trim($rowconfig['instagram_url']));
                define("STORE_LINKEDIN", trim($rowconfig['linkedin_url']));

                define("STORE_YOUTUBE", trim($rowconfig['youtube_url']));
                define("STORE_GOOGLEANALYTICS", html_entity_decode($rowconfig['google_analytics_code'], ENT_QUOTES, "UTF-8"));
                define('STORE_TAX_RATE', $rowconfig['tax_rate']);
            }
        }
    }

    /*
    if (!defined('STORE_VAT')) {
        $sqlquery = $fpdo->from('tbltax')
                         ->select(null)
                         ->select('tbltaxes.tax')
                         ->where('tbltaxes.countryid = :country_id AND state = :state AND status = :status', array(":country_id" => 254, ":state" => 0, ":status" => 707))
                         ->limit(1);
        $rstax = $sqlquery->fetchAll();
        if(count($rstax) > 0) {
            foreach ($rstax as $rowtax) {
                define('STORE_VAT', $rowtax['tax']);
            }
        }
    }
    */

    if (!defined('STORE_DOMAIN')) {
        define('STORE_DOMAIN', "www.agrovision.com");
    }

    if(!defined('CURRENT_YEAR')){
        define('CURRENT_YEAR', date("Y", strtotime('now')));
    }

    spl_autoload_register( function($className) {

        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DS, $namespace) . DS;
        }
        $fileName .= str_replace('_', DS, $className) . '.php';

        include_once($fileName);
        //require $fileName;
    });
?>
