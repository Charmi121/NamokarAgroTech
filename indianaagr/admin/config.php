<?php
if (!defined('DS')) {
    define('DS', "/");
}
if (!defined('ROOT')) {
    define('ROOT', dirname(__FILE__));
}
if (!defined('HTTP_HOST')) {
    define('HTTP_HOST', $_SERVER['HTTP_HOST']);
}
if(!defined('PROTOCOL')) {
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    define('PROTOCOL', $protocol);
}
if (!defined('BASEURL')) {
    define('BASEURL', PROTOCOL.HTTP_HOST.DS.'indianaagr'.DS."admin".DS);
    //define('BASEURL', PROTOCOL.HTTP_HOST.DS.'~agrovisioncom'.DS."admin".DS);
    //define('BASEURL', PROTOCOL.HTTP_HOST.DS."admin".DS);
}
if (!defined('BASE_URL')) {
    define('BASE_URL', PROTOCOL.HTTP_HOST.DS.'indianaagr'.DS);
    //define('BASE_URL', PROTOCOL.HTTP_HOST.DS.'~agrovisioncom'.DS);
    // define('BASE_URL', PROTOCOL.HTTP_HOST.DS."admin".DS);
}
if (!defined('UPLOAD_PATH')) {
    define('UPLOAD_PATH', realpath(dirname(__FILE__) . '/../uploads'));
}
if (!defined('DISPLAY_PATH')) {
    define('DISPLAY_PATH', BASE_URL.'uploads');
}
if (!defined('EMAIL_PATH')) {
    define('EMAIL_PATH', BASE_URL.'emails');
}
if(!defined('CONFIG_PATH')){
    define('CONFIG_PATH', DS.'indianaagr'.DS."admin".DS);
    //define('CONFIG_PATH', DS.'~agrovisioncom'.DS."admin".DS);
    //define('CONFIG_PATH', DS."admin".DS);
}
if(!defined('CURRENT_YEAR')){
    define('CURRENT_YEAR', date("Y", strtotime('now')));
}
if(!defined('SEO_URL_HEAD')) {
    define('SEO_URL_HEAD', PROTOCOL.HTTP_HOST.DS.'indianaagr'.DS."admin".DS);
    //define('SEO_URL_HEAD', PROTOCOL.HTTP_HOST.DS.'~agrovisioncom'.DS."admin".DS);
     //define('SEO_URL_HEAD', PROTOCOL.HTTP_HOST.DS."admin".DS);
}
if (!defined('RECORDS_PER_PAGE')) {
    define('RECORDS_PER_PAGE', 50);
}
if(!defined('MASTER_PASSWORD')) {
   define('MASTER_PASSWORD', 'isolution#406');
}
if (!defined('UPLOADPATH')) {
    define('UPLOADPATH', realpath(dirname(__FILE__) . '/../uploads/'));
}
if (!defined('DISPLAYPATH')) {
    define('DISPLAYPATH', PROTOCOL.HTTP_HOST.DS.'indianaagr/uploads'.DS);
    //define('DISPLAYPATH', PROTOCOL.HTTP_HOST.DS.'~agrovisioncom/uploads'.DS);
    //define('DISPLAYPATH', PROTOCOL.HTTP_HOST.DS.'uploads'.DS);
}
?>
