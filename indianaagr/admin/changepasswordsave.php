<?php
    require_once('session.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('rightusercheck.php');
    require_once('encryption.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || empty($_POST['token']) || (trim($_POST['token']) != trim($_SESSION['tokencode']))) {
        unset($_SESSION['tokencode']);
        header("Location: changepassword.php");
        exit;
    }
    unset($_SESSION['tokencode']);



    $userid         =   (isset($_SESSION['adminorientiqueuserid'])) ? (int)$_SESSION['adminorientiqueuserid'] : 0;
    $oldpassword    =   (!empty($_POST['oldpassword'])) ? $DB->cleanInput($_POST['oldpassword']) : null;
    $newpassword    =   (!empty($_POST['newpassword'])) ? $DB->cleanInput($_POST['newpassword']) : null;
    $now            =   date("Y-m-d H:i:s", strtotime('now'));

    $action     =   0;


    if (!empty($oldpassword) && !empty($newpassword)) {
        $sqlquery = $fpdo->from('tbladminuser')
                         ->where('tbladminuser.id =:id ',array( ":id"=>$userid) );
        $rsdata   = $sqlquery->fetchAll();
        if (count($rsdata)>0) {
            foreach ($rsdata as $rowdata) {
                $parts     = explode(':', $rowdata['password']);
                $crypt     = $parts[0];
                $salt      = @$parts[1];
                $testcrypt = PasswordEncryption::getCryptedPassword($oldpassword, $salt);

                if(trim($crypt) == trim($testcrypt)) {
                    $salt               =   PasswordEncryption::genRandomPassword(32);
                    $cryptnew           =   PasswordEncryption::getCryptedPassword($newpassword, $salt);
                    $crytednewpassword  =   $cryptnew . ':' . $salt;   //To be saved in database

                    $sqlquery = $fpdo->update('tbladminuser') ->set(array( 'password'   => $crytednewpassword ));
                    $sqlquery->where('id = ?', $userid);
                    $result = $sqlquery->execute();
                    if ($result == true)
                    {
                        $action = 1;
                    } else {
                        $action = 2;
                    }
                } else{
                    $action = 3;
                }
            }
        }

    } else {
        $action = 4;
    }

    if ((int)$action == 1) {
        $_SESSION['changepasswordstatus'] =   "success";
        header("Location: changepassword.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['changepasswordstatus'] =   "failure";
        header("Location: changepassword.php");
        exit;
    } elseif ((int)$action == 3) {
        $_SESSION['changepasswordstatus'] =   "nomatch";
        header("Location: changepassword.php");
        exit;
    } else{
        $_SESSION['changepasswordstatus'] =   "incomplete";
        header("Location: changepassword.php");
        exit;
    }
?>