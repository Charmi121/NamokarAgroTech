<?php
    namespace Classes;
    
    class Slider
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
        
        public function getSliders() {
            $sqlquery = $this->FPDO->from('tblsliders')
                                   ->where("tblsliders.status = :status", array(":status" => 707))
                                   ->order('tblsliders.sort_order = 0, tblsliders.sort_order ASC');
            $this->result = $sqlquery->fetchAll();            
            return $this->result;
        }
    }
?>