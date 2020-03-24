<?php
    namespace Classes;
    
    class HomePageContent
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
        
        public function getHomePageContents() {
            $sqlquery = $this->FPDO->from('tblhome_page_contents')
                                   ->where("tblhome_page_contents.status = :status", array(":status" => 707))
                                   ->order('tblhome_page_contents.sort_order = 0, tblhome_page_contents.sort_order ASC');
            $this->result = $sqlquery->fetchAll();            
            return $this->result;
        }
    }
?>