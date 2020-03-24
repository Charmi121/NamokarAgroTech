<?php 
ini_set("session.gc_maxlifetime",3*60*60);
ini_set("session.gc_probability",1);
ini_set("session.gc_divisor",1);
date_default_timezone_set('Asia/Kolkata');
error_reporting(E_ALL);
ini_set('display_errors', '1');  
@session_start();
$currentCookieParams = session_get_cookie_params();
$sidvalue = session_id();  
setcookie(  
    'PHPSESSID',//name  
    $sidvalue,//value  
    0,//expires at end of session  
    $currentCookieParams['path'],//path  
    $currentCookieParams['domain'],//domain  
    false, //secure,
    true //httponly
);    
$inactive = 108000;
?>