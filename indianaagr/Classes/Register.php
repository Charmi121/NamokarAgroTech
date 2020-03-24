<?php
    namespace Classes;

    class Register
    {
        private $FPDO;

        public function __construct($fpdo){
            try {
                $this->FPDO = $fpdo;    
            } catch( Exception $ex) {
                error_log($ex->getMessage(), 3, "error.log");
            }            
        }
        
        public function checkEmailExist($email) {
            $sqlquery = $this->FPDO
                             ->from('tblregister')
                             ->where("tblregister.email = :email" , array(":email" => $email))
                             ->limit(1);
            $this->result = $sqlquery->fetchAll();
            if(count($this->result) > 0){
                return 707;
            } else {
                return 505;
            }
        }
        
        public function getUserInfo($email = null){
            $sqlquery    =   $this->FPDO
                                  ->from('tblregister')
                                  ->where("tblregister.status = :status", array(":status" => 707));
            if(!empty($email)) {
                $sqlquery->where("tblregister.email LIKE :email", array(":email" => $email));    
            }
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function getUserDetails($email){
            $sqlquery     = $this->FPDO
                                 ->from('tblregister')
                                 ->where("tblregister.email = :email" , array(":email" => $email));
            $this->result = $sqlquery->fetchAll();
            if(count($this->result) > 0) {
                return $this->result;
            } else {
                return 0;
            }
        }
        
        public function getUserEditInfo($user_id){
            $sqlquery=   $this->FPDO
                              ->from('tblregister')
                              ->where("tblregister.id = :id" , array(":id" => $user_id));
            $result  =   $sqlquery->fetchAll();
            return $result;
        }
        
        public function getUserInformation($user_id){
            $sqlquery    =   $this->FPDO
                                  ->from('tblregister')
                                  ->where("tblregister.id = :id" , array(":id" => $user_id));
            $result  =   $sqlquery->fetchAll();
            return $result;
        }
        
        public function getContry(){
            $sqlquery      =   $this->FPDO
                                    ->from('tblcountry')
                                    ->order('countryname');
            $this->result  =   $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function getCheckoutProduct(){
            $session_id  =   $_SESSION['orientique']['session_id'];
            $sqlquery    =   $this->FPDO
                                  ->from('tblorders')
                                  ->where('tblorders.session_id = :session_id AND tblorders.payment_status = :status', array(":session_id" => $session_id,":status" =>505) )
                                  ->order('order_id ASC'); 
            $this->result  =   $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function addUserLoginDetails($param = array()){
            $sqlquery = $this->FPDO
                            ->insertInto('tbluser_login_details', array(
                                            'userid'             => $param['userid'],
                                            'login_date'         => $param['login_date'],
                                            'ipaddress'          => $param['ipaddress'],
                                            'browser'            => $param['browser'],
                                            'os'                 => $param['os'],
                                ));
            $result = $sqlquery->execute();
            return $this->result;
        }
        
        public function addNewUser($params = array()){
            $register_id = 0;
            $sqlquery = $this->FPDO
                            ->insertInto('tblregister', array(
                                            //'company_name'      => $params['company_name'], 
                                            //'business_number'   => $params['business_number'],
                                            'email'             => $params['email'],
                                            
                                            'salt'              => $params['salt'], 
                                            'password'          => $params['crypted_password'],
                                            
                                            'first_name'        => $params['first_name'],
                                            'last_name'         => $params['last_name'],
                                            'address'           => $params['address'],
                                            //'address_2'         => $params['address_2'],
                                            'phone'             => $params['phone'],
                                            'mobile'            => $params['mobile'],
                                            'country_id'        => $params['country_id'],
                                            'state_id'          => $params['state_id'],
                                            'state'             => $params['state'],
                                            'city'              => $params['city'],
                                            'zip'               => $params['zip'],
                                            'ipadd'             => $params['ipadd'],
                                            'enter_date'        => $params['enter_date'],
                                            'status'            => 707,
                                            'created'           => $params['created'],
                                            'modified'          => $params['modified'],
                                            
                                        ));
            $register_id = $sqlquery->execute();
            return $register_id;
        }
        
        public function updateProfile($params = array()){
             $sqlquery = $this->FPDO
                             ->update('tblregister')
                             ->set($params)
                             ->where('tblregister.id = ?', $params['id']);
            $result = $sqlquery->execute();
            return $result;
        }
        
        public function updatePassword($params = array()){
             $sqlquery = $this->FPDO
                             ->update('tblregister')
                             ->set($params)
                             ->where('tblregister.id = ?', $params['id']);
            $result = $sqlquery->execute();
            return $result;
        }
        
    }
?>