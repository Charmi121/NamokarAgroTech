<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    require_once('encryption.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode'])))
    {
        unset($_SESSION['tokencode']);
        header("Location: loginuser.php");
        exit;
    }
    unset($_SESSION['tokencode']);


    $edit         =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id           =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;
    $fullname     =   (!empty($_POST['fullname'])) ? $DB->cleanInput($_POST['fullname']) : null;
    $username     =   (!empty($_POST['username'])) ? $DB->cleanInput($_POST['username']) : null;
    $password     =   (!empty($_POST['password'])) ? $DB->cleanInput($_POST['password']) : null;
    $email        =   (!empty($_POST['email'])) ? $DB->cleanInput($_POST['email']) : null;
    $phoneno      =   (!empty($_POST['phoneno'])) ? $DB->cleanInput($_POST['phoneno']) : null;
    $address      =   (!empty($_POST['address'])) ? htmlentities($_POST['address'],ENT_QUOTES,"UTF-8") : null;
    $rights       =   (!empty($_POST['rights'])) ? $DB->cleanInput($_POST['rights']) : null;
    $status       =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;

    $action       =   0;

    $salt         =   PasswordEncryption::genRandomPassword(32);
    $crypt        =   PasswordEncryption::getCryptedPassword($password, $salt);
    $password     =   $crypt . ':' . $salt;

    if (isset($edit) && !empty($username)) {
      if ((int)$edit == 0){
        $sqlquery   = "INSERT INTO tbladminuser(fullname,username,password,email,phoneno,address,rights,status) VALUES('".$fullname."','".$username."','".$password."','".$email."','".$phoneno."','".$address."','".$rights."','".$status."')";
        $fpdo->customResult($sqlquery);
        $action     =  1;
      } else {
        $sqlquery   = "UPDATE tbladminuser SET fullname = '".$fullname."', username = '".$username."', password = '".$password."', email = '".$email."', phoneno = '".$phoneno."', address = '".$address."', rights = '".$rights."', status = '".$status."' WHERE id = ".$id."";
        $result     =  $fpdo->customResult($sqlquery);
        $action     =  2;
      }
    }

    if ((int)$action == 1) {
        $_SESSION['loginuserstatus'] =   "add";
        header("Location: displayloginuser.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['loginuserstatus'] =   "update";
        header("Location: displayloginuser.php");
        exit;
    } else {
        $_SESSION['loginuserstatus'] =   "invalid";
        header("Location: loginuser.php");
        exit;
    }

?>