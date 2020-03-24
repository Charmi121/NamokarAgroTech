<?php
    require_once('session.php');
    require_once('rightusercheck.php');
    require_once('connect.inc.php');
    require_once('config.php');
    require_once('main.php');
    require_once('errorcodes.php');
    require_once('encryption.php');
    $DB = new DBConfig();

    //Check First for Valid Form Submission
    if (empty($_SESSION['tokencode']) || (trim($_POST['token']) != trim($_SESSION['tokencode']))) {
        unset($_SESSION['tokencode']);
        header("Location: register.php");
        exit;
    }
    unset($_SESSION['tokencode']);

    $edit          =   (!empty($_POST['edit'])) ? (int)$_POST['edit'] : 0;
    $id            =   (!empty($_POST['id'])) ? (int)$_POST['id'] : 0;

    $company_name  =   (!empty($_POST['company_name'])) ? $DB->RemoveTags($_POST['company_name']) : '';
    $business_number=  (!empty($_POST['business_number'])) ? $DB->RemoveTags($_POST['business_number']) : '';

    $email         =   (!empty($_POST['email'])) ? $DB->cleanInput($_POST['email']) : '';
    $password      =   (!empty($_POST['password'])) ? $DB->RemoveTags($_POST['password']) : '';

    $first_name    =   (!empty($_POST['first_name'])) ? $DB->cleanInput($_POST['first_name']) : '';
    $last_name     =   (!empty($_POST['last_name'])) ? $DB->cleanInput($_POST['last_name']) : '';
    $phone         =   (!empty($_POST['phone'])) ? $DB->RemoveTags($_POST['phone']) : '';
    $mobile        =   (!empty($_POST['mobile'])) ? $DB->RemoveTags($_POST['mobile']) : '';

    $address       =   (!empty($_POST['address'])) ? $DB->cleanInput($_POST['address']) : '';
    //$address_2     =   (!empty($_POST['address_2'])) ? $DB->cleanInput($_POST['address_2']) : '';

    $country_id    =   (!empty($_POST['country_id'])) ? (int)$DB->RemoveTags($_POST['country_id']) : 0;
    $state         =   (!empty($_POST['state'])) ? $DB->RemoveTags($_POST['state']) : '';
    $city          =   (!empty($_POST['city'])) ? $DB->RemoveTags($_POST['city']) : '';
    $zip           =   (!empty($_POST['zip'])) ? $DB->RemoveTags($_POST['zip']) : '';

    //$state         =   '';
    /*if(!empty($_POST['state'])) {
    $state  =   $DB->RemoveTags($_POST['state']);
    } elseif (!empty($_POST['other_state'])) {
    $state  =   $DB->cleanInput($_POST['other_state']);
    } else {
    $state  =   '';
    }   */
                       
    $is_verified   =   (!empty($_POST['is_verified'])) ? $DB->RemoveTags($_POST['is_verified']) : 0;  
    $allow_on_account= (!empty($_POST['allow_on_account'])) ? $DB->RemoveTags($_POST['allow_on_account']) : 0; 
    
    $status        =   (!empty($_POST['status'])) ? (int)$_POST['status'] : 707;
    $sort_order    =   (!empty($_POST['sort_order'])) ? (int)$_POST['sort_order'] : 0; 
    $verify_mail   =   (!empty($_POST['verify_mail'])) ? (int)$_POST['verify_mail'] : 0;

    $ipadd         =   $DB-> getRealIpAddr();
    $created       =   date("Y-m-d H:i:s", strtotime('now'));
    $modified      =   date("Y-m-d H:i:s", strtotime('now'));
    $action        =   0;
    /*
    Encrypting Standard Has Been Changed Refer front Encryption file
    if(!empty($password)){
        $salt               =   PasswordEncryption::genRandomPassword(32);
        $crypt              =   PasswordEncryption::getCryptedPassword($password, $salt);
        $crypted_password   =   $crypt . ':' . $salt;
    }
    */

    if (isset($edit) && !empty($first_name)){
        if ((int)$edit == 0){

            if( empty($email) || (int)$DB->checkemail($email) == 505 ){
                $_SESSION['registerstatus'] = 'invalid_email';
                header("Location: register.php");
                exit;
            } elseif ((int)checkEmailExist($email) == 505) {
                $_SESSION['registerstatus'] = 'email_exist';
                header("Location: register.php");
                exit;
            } elseif(!empty($email) && !empty($password) && !empty($firstname) && !empty($lastname) && (int)checkEmailExist($email)==707) {
                //First Step to save the registration
                $sqlquery = $fpdo->insertInto('tblregister', array(
                        //'company_name'  => $company_name,
                        //'business_number' => $business_number,
                        'email'       => $email,
                        'first_name'  => $first_name,
                        'last_name'   => $last_name,
                        'phone'       => $phone,
                        'mobile'      => $mobile,
                        'address'     => $address,
                        //'address_2'   => $address_2,
                        'country_id'  => $country_id,
                        'state'       => $state,
                        'city'        => $city,
                        'zip'         => $zip,
                        'is_verified' => $is_verified,
                        'allow_on_account' => $allow_on_account,
                        'status'      => $status,
                        'sort_order'  => $sort_order,
                        'created'     => $created,
                        'modified'    => $modified,
                    ));
                $register_id = $sqlquery->execute();

                //Enter Business Details
                // Code has not been written because of permission not provided in admin
                
                
                if(!empty($is_verified) && !empty($verify_mail) && (int)$verify_mail == 1) {
                    $params = array();
                    $params['id'] = $register_id;
                    $params['email'] = $email;

                    sendVerifyEmail($params);    
                } elseif (!empty($verify_mail) && (int)$verify_mail == 2) {
                    $params = array();
                    $params['id'] = $register_id;
                    $params['email'] = $email;

                    sendDisapproveEmail($params);
                }

                $action   = 1;
            }

        } else {

            $sqlquery = $fpdo->update('tblregister')
                             ->set(array(
                                    //'company_name'  => $company_name,
                                    //'business_number' => $business_number,
                                    'email'       => $email,
                                    'first_name'  => $first_name,
                                    'last_name'   => $last_name,
                                    'phone'       => $phone,
                                    'mobile'      => $mobile,
                                    'address'     => $address,
                                    //'address_2'   => $address_2,
                                    'country_id'  => $country_id,
                                    'state'       => $state,
                                    'city'        => $city,
                                    'zip'         => $zip,
                                    'is_verified' => $is_verified,
                                    'allow_on_account' => $allow_on_account,
                                    'status'      => $status,
                                    'sort_order'  => $sort_order,
                                    'modified'    => $modified,
                                ));
            /*
            if(!empty($password)) {
                $sqlquery->set(array("password" => $crypted_password));
            }
            */                    
            $sqlquery->where('id = ?', $id);
            $result = $sqlquery->execute();

            //Update Business Details
            $sqlquery = $fpdo->update('tblregister_billing_addresses')
                             ->set(array(
                                    'billing_company_name'  => $company_name,
                                    'billing_business_number' => $business_number,
                                    'modified'    => $modified,
                                ));
            $sqlquery->where('user_id = ?', $id);
            $result = $sqlquery->execute();
            
            
            if(!empty($is_verified) && !empty($verify_mail) && (int)$verify_mail == 1) {
                $params = array();
                $params['id'] = $id;
                $params['email'] = $email;

                sendVerifyEmail($params);    
            } elseif (!empty($verify_mail) && (int)$verify_mail == 2) {
                $params = array();
                $params['id'] = $id;
                $params['email'] = $email;

                sendDisapproveEmail($params);
            }

            $action = 2;
        }
    }

    if ((int)$action == 1) {
        $_SESSION['registerstatus'] =   "add";
        header("Location: displayregister.php");
        exit;
    } elseif ((int)$action == 2) {
        $_SESSION['registerstatus'] =   "update";
        header("Location: displayregister.php");
        exit;
    } else {
        $_SESSION['registerstatus'] =   "invalid";
        header("Location: register.php");
        exit;
    }   
?>

<?php
    function sendVerifyEmail($params = array())
    {
        global $fpdo;
        //Configuration Table
        $replacements = $store_info = $customer_info = array();
        $sqlquery = $fpdo->from('tblconfigurations')
                        ->select(null)
                        ->select('tblconfigurations.*')
                        ->where("tblconfigurations.status = :status", array(":status" => 1))
                        ->orderBy("tblconfigurations.id ASC");
        $rsstore = $sqlquery->fetchAll();
        if(!empty($rsstore)) {
            foreach($rsstore as $rowstore) {        
                $store_info = array(
                    '[[BASE_URL]]' => BASE_URL,
                    '[[STORE_URL]]' => BASE_URL,
                    '[[STORE_LOGO_URL]]' => BASE_URL."images/logo.jpg",
                    '[[STORE_NAME]]' => ucfirst($rowstore['website_title']),
                    '[[STORE_PHONE]]' => $rowstore['phone'],
                    '[[STORE_EMAIL]]' => $rowstore['feedback_email'],
                    '[[STORE_FROM_EMAIL]]' => $rowstore['from_email'],
                    '[[STORE_FEEDBACK_EMAIL]]' => $rowstore['feedback_email'],
                    '[[STORE_LOGIN_URL]]' => BASE_URL."login.html",
                    '[[STORE_FORGOT_PASSWORD_URL]]' => BASE_URL."forgot-password.html",

                    '[[STORE_FACEBOOK]]' => $rowstore['facebook_url'],
                    '[[STORE_TWITTER]]' => $rowstore['twitter_url'],
                    '[[STORE_GOOGLEPLUS]]' => $rowstore['google_plus_url'],
                    '[[STORE_PINTEREST]]' => $rowstore['pinterest_url']
                );
            }
        }

        //Customer Table
        $sqlquery = $fpdo->from('tblregister')
                        ->select(null)
                        ->select('tblregister.*')
                        ->where("tblregister.id = :id AND tblregister.status = :status", array(":id" => $params['id'], ":status" => 707))
                        ->orderBy("tblregister.id ASC");
        $rscustomer = $sqlquery->fetchAll();
        if(!empty($rscustomer)) {
            foreach($rscustomer as $rowcustomer) {
                $customer_info = array(
                    '[[CUSTOMER_NAME]]' => trim(strtoupper($rowcustomer['first_name']))." ".trim(strtoupper($rowcustomer['last_name'])),
                    '[[CUSTOMER_EMAIL]]' => trim(strtolower($rowcustomer['email'])),
                    '[[YEAR]]' => date("Y", strtotime('now'))
                );
            }
        }

        $replacements = array_merge($replacements, $store_info, $customer_info);

        //################ Send Email ##############//
        $mail = array();

        $mail['message'] = file_get_contents(BASE_URL."emails/customer-registration-verified.ctp");
        if(!empty($replacements)) {
            foreach($replacements as $find => $replace){
                $mail['message'] = str_replace($find, $replace, $mail['message']);
            }
        }

        $mail['subject'] = "Congratulations! Your registration is approved.";

        $mail['from_email'] = $store_info['[[STORE_FEEDBACK_EMAIL]]'];
        $mail['from_name'] = $store_info['[[STORE_NAME]]'];
        $mail['to_email'] = $customer_info['[[CUSTOMER_EMAIL]]'];

        // To send HTML mail, the Content-type header must be set
        $mail['headers'] = "MIME-Version: 1.0\n";
        $mail['headers'] .= "Content-Type: text/html; charset=iso-8859-1\n";
        $mail['headers'] .= "From: ".$mail['from_name']." <".$mail['from_email'].">\n";
        $mail['headers'] .= 'Bcc: '.$mail['from_email'].''. "\r\n";

        // Mail it
        mail($mail['to_email'], $mail['subject'], $mail['message'], $mail['headers']);    
    }
    
    function sendDisapproveEmail($params = array())
    {
        global $fpdo;
        //Configuration Table
        $replacements = $store_info = $customer_info = array();
        $sqlquery = $fpdo->from('tblconfigurations')
                        ->select(null)
                        ->select('tblconfigurations.*')
                        ->where("tblconfigurations.status = :status", array(":status" => 1))
                        ->orderBy("tblconfigurations.id ASC");
        $rsstore = $sqlquery->fetchAll();
        if(!empty($rsstore)) {
            foreach($rsstore as $rowstore) {        
                $store_info = array(
                    '[[BASE_URL]]' => BASE_URL,
                    '[[STORE_URL]]' => BASE_URL,
                    '[[STORE_LOGO_URL]]' => BASE_URL."images/logo.jpg",
                    '[[STORE_NAME]]' => ucfirst($rowstore['website_title']),
                    '[[STORE_PHONE]]' => $rowstore['phone'],
                    '[[STORE_EMAIL]]' => $rowstore['feedback_email'],
                    '[[STORE_FROM_EMAIL]]' => $rowstore['from_email'],
                    '[[STORE_FEEDBACK_EMAIL]]' => $rowstore['feedback_email'],
                    
                    '[[STORE_FACEBOOK]]' => $rowstore['facebook_url'],
                    '[[STORE_TWITTER]]' => $rowstore['twitter_url'],
                    '[[STORE_GOOGLEPLUS]]' => $rowstore['google_plus_url'],
                    '[[STORE_PINTEREST]]' => $rowstore['pinterest_url']
                );
            }
        }

        //Customer Table
        $sqlquery = $fpdo->from('tblregister')
                        ->select(null)
                        ->select('tblregister.*')
                        ->where("tblregister.id = :id AND tblregister.status = :status", array(":id" => $params['id'], ":status" => 707))
                        ->orderBy("tblregister.id ASC");
        $rscustomer = $sqlquery->fetchAll();
        if(!empty($rscustomer)) {
            foreach($rscustomer as $rowcustomer) {
                $customer_info = array(
                    '[[CUSTOMER_NAME]]' => trim(strtoupper($rowcustomer['first_name']))." ".trim(strtoupper($rowcustomer['last_name'])),
                    '[[CUSTOMER_EMAIL]]' => trim(strtolower($rowcustomer['email'])),
                    '[[YEAR]]' => date("Y", strtotime('now'))
                );
            }
        }

        $replacements = array_merge($replacements, $store_info, $customer_info);

        //################ Send Email ##############//
        $mail = array();

        $mail['message'] = file_get_contents(BASE_URL."emails/customer-registration-disapproved.ctp");
        if(!empty($replacements)) {
            foreach($replacements as $find => $replace){
                $mail['message'] = str_replace($find, $replace, $mail['message']);
            }
        }

        $mail['subject'] = "Sorry! Your registration is disapproved.";

        $mail['from_email'] = $store_info['[[STORE_FEEDBACK_EMAIL]]'];
        $mail['from_name'] = $store_info['[[STORE_NAME]]'];
        $mail['to_email'] = $customer_info['[[CUSTOMER_EMAIL]]'];

        // To send HTML mail, the Content-type header must be set
        $mail['headers'] = "MIME-Version: 1.0\n";
        $mail['headers'] .= "Content-Type: text/html; charset=iso-8859-1\n";
        $mail['headers'] .= "From: ".$mail['from_name']." <".$mail['from_email'].">\n";
        $mail['headers'] .= 'Bcc: '.$mail['from_email'].''. "\r\n";

        // Mail it
        mail($mail['to_email'], $mail['subject'], $mail['message'], $mail['headers']);    
    }
?>

<?php
    function checkEmailExist($email)
    {
        global $DB, $fpdo;
        $email      =   $DB->RemoveTags($email);
        $sqlquery   =   "SELECT id FROM tblregister WHERE email LIKE '".$email."' LIMIT 1 ";
        $rsemail    =   $fpdo->customResult($sqlquery)->fetchAll();
        if (count($rsemail) > 0){
            return 505;
        } else {
            return 707;
        }        
    }
?>