<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('encryption.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode']))){
        $_SESSION['loginerr'] = 'invalid';
        unset($_SESSION['tokencode']);
        header("Location: login.php");
        exit;
    }
    unset($_SESSION['tokencode']);

    $username   =   (!empty($_POST['username'])) ? $DB->cleanInput($_POST['username']) : null;
    $password   =   (!empty($_POST['password'])) ? $DB->cleanInput($_POST['password']) : null;

    if (!empty($username) && !empty($password)) {
        $sqlquery = $fpdo->from('tbladminuser')
                         ->where('tbladminuser.username =:username ',array( ":username"=>$username) );
        $rsdata   = $sqlquery->fetchAll();
        if(count($rsdata)>0){
            foreach($rsdata as $rowdata){
                $parts     = explode(':', $rowdata['password']);
                $crypt     = $parts[0];
                $salt      = @$parts[1];
                $testcrypt = PasswordEncryption::getCryptedPassword($password, $salt);

                if(trim($crypt) == trim($testcrypt)) {
                    $_SESSION['adminkiranakingvalid']        =   707;
                    $_SESSION['adminkiranakinguserid']       =   $rowdata['id'];
                    $_SESSION['adminkiranakingfullname']     =   $rowdata['fullname'];
                    $_SESSION['adminkiranakingusername']     =   $rowdata['username'];
                    $_SESSION['adminkiranakingemail']        =   $rowdata['email'];
                    $_SESSION['adminkiranakingrights']       =   $rowdata['rights'];

                    //Set login detail in php
                    $sqlquery = $fpdo->from('tbladminlogindetails')
                                     ->where('tbladminlogindetails.userid =:userid ',array( ":userid"=>$rowdata['id']) );
                    $rsdetail = $sqlquery->fetchAll();
                    
                    if (count($rsdetail)>0) {
                       foreach($rsdetail as $rowdetail) {
                            $_SESSION['adminkiranakinglastlogindate']   =    $rowdetail['logindate'];
                            $_SESSION['adminkiranakinglastlogintime']   =    $rowdetail['logintime'];
                            $_SESSION['adminkiranakinglastloginip']     =    $rowdetail['loginip'];
                       }
                    }
                    $now      =  date("Y-m-d H:i:s", strtotime('now'));
                    $loginip  =  $DB->getRealIpAddr();
                    $sqlquery = $fpdo->insertInto('tbladminlogindetails', array(
                                    'userid' => $_SESSION['adminkiranakinguserid'], 
                                    'logindate' => $now, 
                                    'logintime' => $now, 
                                    'loginip' => $loginip
                    ));
                    $result   = $sqlquery->execute();
                    
                    header("Location: ".CONFIG_PATH."index.php");
                    exit;
               } else {
                   $_SESSION['loginerr'] = 'invalid';
                   header("Location: ".CONFIG_PATH."login.php");
                   exit;
               }
            }
        } else {
            $_SESSION['loginerr'] = 'invalid';
            header("Location: ".CONFIG_PATH."login.php");
            exit;
        }
    } else {
        $_SESSION['loginerr'] = 'invalid';
        header("Location: ".CONFIG_PATH."login.php");
        exit;
    }
?>