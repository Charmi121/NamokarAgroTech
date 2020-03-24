<?php
    namespace Classes;

    class Currency
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

        public function getCurrencies() {
            $this->result = array();
            $sqlquery = $this->FPDO->from('tblcurrencies')
                                   ->select(null)
                                   ->select('tblcurrencies.id, tblcurrencies.currency_code, tblcurrencies.currency_value')
                                   ->where("tblcurrencies.status = :status", array(":status" => 707));
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }

        public function getCurrencyInfo($currency_id = 0) {
            try {
                $sqlquery = $this->FPDO
                                 ->from('tblcurrencies')
                                 ->where("tblcurrencies.id = :currency_id AND tblcurrencies.status = :status", array(":currency_id" => $currency_id, ":status" => 707))
                                 ->limit(1);
                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing currency: ", $e->getMessage(), "\n";
            }
        }

        public function getDefaultCurrencyInfo() {
            try {
                $sqlquery = $this->FPDO
                                 ->from('tblcurrencies')
                                 ->where("tblcurrencies.is_default = :is_default AND tblcurrencies.status = :status", array(":is_default" => 1, ":status" => 707))
                                 //->where("tblcurrencies.is_default = :is_default AND tblcurrencies.status = :status", array(":is_default" => 2, ":status" => 707))
                                 ->limit(1);
                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing currency: ", $e->getMessage(), "\n";
            }
        }

        public function setSessionCurrencyInfo(){
            try {
                if(empty($_SESSION['orientique']['currency_id'])) {
                    $sqlquery = $this->FPDO
                                     ->from('tblcurrencies')
                                     ->where("tblcurrencies.is_default = :is_default AND tblcurrencies.status = :status", array(":is_default" => 1, ":status" => 707))
                                     ->limit(1);
                    $this->result = $sqlquery->fetchAll();
                    if(!empty($this->result)) {
                        foreach($this->result as $rowcurrency) {
                            $_SESSION['orientique']['currency_id']    = $rowcurrency['id'];
                            $_SESSION['orientique']['currency_code']  = $rowcurrency['currency_code'];
                            $_SESSION['orientique']['currency_value'] = $rowcurrency['currency_value'];
                            $_SESSION['orientique']['currency_symbol']= html_entity_decode($rowcurrency['currency_symbol'], ENT_QUOTES, "UTF-8");
                            $_SESSION['orientique']['country_flag']   = $rowcurrency['country_flag'];
                        }
                    }
                }    
            } catch (Exception $e) {
                echo "Exception while processing currency: ", $e->getMessage(), "\n";
            } 
        }
        public function getCurrencyDetail($currency_code = null) {
            $this->result = array();
            if(!empty($currency_code)) {
                $sqlquery = $this->FPDO
                                 ->from('tblcountries')
                                 ->select(null)
                                 ->select('tblcurrencies.id, tblcurrencies.currency_title, tblcurrencies.currency_code, tblcurrencies.currency_symbol, tblcurrencies.currency_value, tblcurrencies.country_flag')
                                 ->innerJoin('tblcurrencies ON tblcurrencies.currency_code = tblcountries.currency_code')
                                 ->where("tblcountries.iso2 = :country_code AND tblcountries.status = :status", array(":country_code" => $currency_code, ":status" => 707))
                                 ->limit(1);
                $rsresult = $sqlquery->fetchAll();
            }
            return $rsresult;
        }

    }
?>