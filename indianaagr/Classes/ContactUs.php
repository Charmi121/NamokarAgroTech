<?php
    namespace Classes;
    
    class ContactUs
    {
        private $FPDO;
        
        protected $result = array();
        
        public function __construct($fpdo){
            try {
                $this->FPDO = $fpdo;    
            } catch( Exception $ex) {
                error_log($ex->getMessage(), 3, "error.log");
            }            
        }
        
        public function addEnquiry($params = array()) {
            $sqlquery = $this->FPDO
                             ->insertInto('tblcontactus', $params);
            $result = $sqlquery->execute();
            return $result;
        }
    }
?>