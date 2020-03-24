<?php
    namespace Classes;
    
    class Country
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
        
        public function getCountries() {
            $this->result = array();
            $sqlquery = $this->FPDO->from('tblcountries')
                                   ->select(null)
                                   ->select('tblcountries.id, tblcountries.countryname, tblcountries.status')
                                   ->where("tblcountries.status = :status", array(":status" => 707))
                                   ->orderBy("tblcountries.countryname");
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function getCountryInfo($country_id = 0) {
            try {
                $sqlquery = $this->FPDO
                                 ->from('tblcountries')
                                 ->where("tblcountries.id = :country_id AND tblcountries.status = :status", array(":country_id" => $country_id, ":status" => 707))
                                 ->limit(1);
                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing currency: ", $e->getMessage(), "\n";
            }
        }
        
        public function getCountryID($country_name = ''){
            $sqlquery = $this->FPDO
                                 ->from('tblcountries')
                                 ->where("tblcountries.countryname = :country_name AND tblcountries.status = :status", array(":country_name" => $country_name, ":status" => 707))
                                 ->limit(1);
                $this->result = $sqlquery->fetchAll();
                return $this->result;
        }
    }
?>