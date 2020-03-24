<?php
    namespace Classes;
    
    class Press
    {
        private $FPDO;
        
        private $result = array(), $arr_cat = array(), $arr_breadcrumb = array();
        
        public function __construct($fpdo){
            try {
                $this->FPDO = $fpdo;    
            } catch( Exception $ex) {
                error_log($ex->getMessage(), 3, "error.log");
            }            
        }
        
        public function getPresses() {
            $this->result = array();
            $sqlquery = $this->FPDO->from('tblpresses')
                                   ->select(null)
                                   ->select('tblpresses.id, tblpresses.press_name, tblpresses.thumb_image, tblpresses.big_image')
                                   ->where("tblpresses.status = :status", array(":status" => 707))
                                   ->order('tblpresses.id DESC');
                                   //->order('tblpresses.sort_order = 0, tblpresses.sort_order ASC');
            
            $this->result = $sqlquery->fetchAll();

            return $this->result;
        }
    }
?>