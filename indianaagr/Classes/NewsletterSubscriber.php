<?php
    namespace Classes;

    class NewsletterSubscriber
    {
        private $FPDO;

        public function __construct($fpdo){
            try {
                $this->FPDO = $fpdo;    
            } catch( Exception $ex) {
                error_log($ex->getMessage(), 3, "error.log");
            }            
        }
        
        public function getNewsletterSubscriberInfo($params = array()) {
            $email     =   (!empty($params['email'])) ? trim($params['email']) : '';
            $sqlquery  =   $this->FPDO
                                ->from('tblnewsletter_subscribers')
                                ->where('tblnewsletter_subscribers.email = :email', array(":email" => $email))
                                ->order('tblnewsletter_subscribers.id DESC'); 
            $this->result  =  $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function addNewsletterSubscriber($params = array()) {
            $sqlquery = $this->FPDO
                            ->insertInto('tblnewsletter_subscribers', array(
                                            'email'          => $params['email'],
                                            "status"         => $params['status'],   
                                            "ip_address"     => $params['ip_address'],                  
                                            'created'        => $params['created'],
                                            'modified'       => $params['modified']
                                        ));
            $result = $sqlquery->execute();
            return $result;
        }
        
        public function updateNewsletterSubscriber($params = array()){
            $sqlquery = $this->FPDO
                             ->update('tblnewsletter_subscribers')
                             ->set(
                                array(
                                  'email'          => $params['email'],
                                  "status"         => $params['status'],   
                                  "ip_address"     => $params['ip_address'],
                                  "modified"       => $params['modified']
                             ))
                             ->where('tblnewsletter_subscribers.email = ?', $params['email']);
            $result = $sqlquery->execute();
            return $result;
        }
    }
?>