<?php
    namespace Classes;

    class RegisterBilling
    {
        private $FPDO;

        public function __construct($fpdo){
            try {
                $this->FPDO = $fpdo;    
            } catch( Exception $ex) {
                error_log($ex->getMessage(), 3, "error.log");
            }            
        }
        
        public function getUserBillingInfo($params = array()) {
            $user_id   =   (!empty($params['user_id'])) ? (int)$params['user_id']  : 0;
            $sqlquery  =   $this->FPDO
                                ->from('tblregister_billing_addresses')
                                ->where('tblregister_billing_addresses.user_id = :user_id', array(":user_id" => $params['user_id']))
                                ->order('tblregister_billing_addresses.id DESC'); 
            $this->result  =  $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function addUserBilling($params = array()) {
            $sqlquery = $this->FPDO
                            ->insertInto('tblregister_billing_addresses', array(
                                            'user_id'               => $params['user_id'],
                                            
                                            'billing_company_name'  => $params['billing_company_name'],
                                            'billing_business_number'=>$params['billing_business_number'],
                                            
                                            'billing_first_name'    => $params['billing_first_name'],
                                            'billing_last_name'     => $params['billing_last_name'],
                                            'billing_email'         => $params['billing_email'],
                                            'billing_phone'         => $params['billing_phone'],
                                            'billing_mobile'        => $params['billing_mobile'],
                                            'billing_address'       => $params['billing_address'],
                                            'billing_postal_code'   => $params['billing_postal_code'],
                                            'billing_city'          => $params['billing_city'],
                                            'billing_city_id'       => $params['billing_city_id'],
                                            'billing_state'         => $params['billing_state'],
                                            'billing_state_id'      => $params['billing_state_id'],
                                            'billing_country'       => $params['billing_country'],
                                            'billing_country_id'    => $params['billing_country_id'],
                                            
                                            'shipping_first_name'   => $params['shipping_first_name'],
                                            'shipping_last_name'    => $params['shipping_last_name'],
                                            'shipping_email'        => $params['shipping_email'],
                                            'shipping_phone'        => $params['shipping_phone'],
                                            'shipping_mobile'       => $params['shipping_mobile'],
                                            'shipping_address'      => $params['shipping_address'],
                                            'shipping_postal_code'  => $params['shipping_postal_code'],
                                            'shipping_city'         => $params['shipping_city'],
                                            'shipping_city_id'      => $params['shipping_city_id'],
                                            'shipping_state'        => $params['shipping_state'],
                                            'shipping_state_id'     => $params['shipping_state_id'],
                                            'shipping_country'      => $params['shipping_country'],
                                            'shipping_country_id'   => $params['shipping_country_id'],
                                            
                                            'created'               => $params['created'],
                                            'modified'              => $params['modified']
                                        ));
            $result = $sqlquery->execute();
            return $result;
        }
        
        public function updateUserBilling($params = array()){
            $sqlquery = $this->FPDO
                             ->update('tblregister_billing_addresses')
                             ->set(
                                array(
                                  'user_id'               => $params['user_id'],               
                                  
                                  'billing_company_name'  => $params['billing_company_name'],
                                  'billing_business_number'=>$params['billing_business_number'],
                                  
                                  'billing_first_name'    => $params['billing_first_name'],
                                  'billing_first_name'    => $params['billing_first_name'],
                                  'billing_last_name'     => $params['billing_last_name'],
                                  'billing_email'         => $params['billing_email'],
                                  'billing_phone'         => $params['billing_phone'],
                                  'billing_mobile'        => $params['billing_mobile'],
                                  'billing_address'       => $params['billing_address'],
                                  'billing_postal_code'   => $params['billing_postal_code'],
                                  'billing_city'          => $params['billing_city'],
                                  'billing_city_id'       => $params['billing_city_id'],
                                  'billing_state'         => $params['billing_state'],
                                  'billing_state_id'      => $params['billing_state_id'],
                                  'billing_country'       => $params['billing_country'],
                                  'billing_country_id'    => $params['billing_country_id'],
                                  
                                  'shipping_first_name'   => $params['shipping_first_name'],
                                  'shipping_last_name'    => $params['shipping_last_name'],
                                  'shipping_email'        => $params['shipping_email'],
                                  'shipping_phone'        => $params['shipping_phone'],
                                  'shipping_mobile'       => $params['shipping_mobile'],
                                  'shipping_address'      => $params['shipping_address'],
                                  'shipping_postal_code'  => $params['shipping_postal_code'],
                                  'shipping_city'         => $params['shipping_city'],
                                  'shipping_city_id'      => $params['shipping_city_id'],
                                  'shipping_state'        => $params['shipping_state'],
                                  'shipping_state_id'     => $params['shipping_state_id'],
                                  'shipping_country'      => $params['shipping_country'],
                                  'shipping_country_id'   => $params['shipping_country_id'],
                                  
                                  'modified'              => $params['modified']
                             ))
                             ->where('tblregister_billing_addresses.user_id = ?', $params['user_id']);
            $result = $sqlquery->execute();
            return $result;
        }
    }
?>