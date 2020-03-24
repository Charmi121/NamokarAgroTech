<?php
    namespace Classes;
    
    class Configuration
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
        
        public function getConfigurationInfo($params = array()) {
            $this->result = array();
            $sqlquery = $this->FPDO->from("tblconfigurations")
                                   ->where("tblconfigurations.status = :status", array(":status" => 1))
                                   ->limit(1);
            $this->result = $sqlquery->fetchAll();            
            return $this->result;
        }
    }
?>