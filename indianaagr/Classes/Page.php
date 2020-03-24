<?php
    namespace Classes;
    
    class Page
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
        
        public function getPageInfo($page_id = 0) {
            try {
                $sqlquery = $this->FPDO
                                 ->from('tblpages')
                                 ->where("tblpages.id = :page_id AND tblpages.status = :status", array(":page_id" => $page_id, ":status" => 707))
                                 ->limit(1);
                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing category: ", $e->getMessage(), "\n";
            }
        }        
        
        public function isPage($seo_url = null) {
            if(!empty($seo_url)) {
                $sqlquery = $this->FPDO->from('tblpages')
                                       ->select(null)
                                       ->select('tblpages.id')
                                       ->where("tblpages.seo_url = :seo_url AND tblpages.status = :status", array(":seo_url" => $seo_url, ":status" => 707));
                $rspages = $sqlquery->fetchAll();
                if(count($rspages) > 0) {
                    foreach ($rspages as $rowpage) {
                        $this->result['id'] = $rowpage['id']; 
                        return $this->result['id'];
                    }    
                }
            } 
             
            return false;
        }
        
        public function getPageDetail($page_id = 0) {
            $this->result = array();
            
            $sqlquery = $this->FPDO->from('tblpages')
                                   ->where("tblpages.id = :page_id AND tblpages.status = :status", array(":page_id" => $page_id, ":status" => 707));
            $this->result = $sqlquery->fetchAll();
            
            return $this->result;
        }
        
        public function getPages() {
            $this->result = array();
            
            $sqlquery = $this->FPDO->from('tblpages')
                                   ->select(null)
                                   ->select('tblpages.id, tblpages.page_title, tblpages.seo_url')
                                   ->where("tblpages.status = :status", array(":status" => 707));
            $this->result = $sqlquery->fetchAll();
            
            return $this->result;
        }
    }
?>