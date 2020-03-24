<?php
    namespace Classes;
    
    class EnquiryProduct
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
        
        public function getEnquiryProducts($params = array()){
            $this->result = array();
            $sqlquery = $this->FPDO
                             ->from('tblenquiry_products')
                             ->select(null)
                             ->select('tblenquiry_products.*, tblproduct_images.mini_image, tblproduct_images.thumb_image, tblproducts.seo_url')
                             //->select('tblcategories.seo_url AS cat_seo_url')
                             ->select('tbltypes.type_name, tblcolors.color_name, tblfabrics.fabric_name')
                             ->innerJoin('tblenquiries ON tblenquiries.enquiry_id = tblenquiry_products.enquiry_id')
                             ->leftJoin('tblproducts ON tblproducts.id = tblenquiry_products.product_id')
                             
                             ->leftJoin('tbltypes ON tbltypes.id = tblproducts.type_id')
                             ->leftJoin('tblcolors ON tblcolors.id = tblproducts.color_id')
                             ->leftJoin('tblfabrics ON tblfabrics.id = tblproducts.fabric_id')
                             
                             ->leftJoin('tblproduct_images ON tblproduct_images.product_id = tblenquiry_products.product_id AND tblproduct_images.show_as_main = 1')
                             //->leftJoin('tblcategories ON tblcategories.id = tblproducts.product_id')
                             ->where("tblenquiry_products.enquiry_id = :enquiry_id", array(":enquiry_id" => $params['enquiry_id']));
            
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function getEnquiryProductInfo($params = array()) {
            try {
                $this->result = array();
                $sqlquery = $this->FPDO
                                 ->from('tblenquiry_products')
                                 ->limit(1);
                if(!empty($params['enquiry_id'])) {
                    $sqlquery->where("tblenquiry_products.enquiry_id = :enquiry_id", array(":enquiry_id" => $params['enquiry_id']));
                }
                
                if(!empty($params['enquiry_product_id'])) {
                    $sqlquery->where("tblenquiry_products.enquiry_product_id = :enquiry_product_id", array(":enquiry_product_id" => $params['enquiry_product_id']));
                }
                
                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing order: ", $e->getMessage(), "\n";
            }
        }
        
        public function checkEnquiryProductExist($params = array()) {
            try {
                $this->result = array();
                $sqlquery = $this->FPDO
                                 ->from('tblenquiry_products')
                                 ->limit(1);
                if(!empty($params['enquiry_id'])) {
                    $sqlquery->where("tblenquiry_products.enquiry_id = :enquiry_id", array(":enquiry_id" => $params['enquiry_id']));
                }
                
                if(!empty($params['product_id'])) {
                    $sqlquery->where("tblenquiry_products.product_id = :product_id", array(":product_id" => $params['product_id']));
                }
                
                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing order: ", $e->getMessage(), "\n";
            }
        }
        
        public function updateEnquiryProduct($params = array()) {
            $sqlquery = $this->FPDO->update('tblenquiry_products')
                                   ->set(
                                        array(
                                            'enquiry_id' => $params['enquiry_id'],
                                            'product_id' => $params['product_id'],
                                            'product_name' => $params['product_name'],
                                            'sku' => $params['sku'],
                                            'created' => $params['created'],
                                            'modified' => $params['modified']
                                        )
                                     );
            
            if(!empty($params['enquiry_id'])) {
                $sqlquery->where("tblenquiry_products.enquiry_id = ?", $params['enquiry_id']);
            }
            
            if(!empty($params['product_id'])) {
                $sqlquery->where("tblenquiry_products.product_id = ?", $params['product_id']);
            }
            
            $enquiry_product_id = $sqlquery->execute();
            return $enquiry_product_id;    
        }
        
        public function addEnquiryProduct($params = array()){
            $sqlquery = $this->FPDO->insertInto('tblenquiry_products')
                                   ->values(
                                        array(
                                            'enquiry_id' => $params['enquiry_id'],
                                            'product_id' => $params['product_id'],
                                            'product_name' => $params['product_name'],
                                            'sku' => $params['sku'],
                                            'created' => $params['created'],
                                            'modified' => $params['modified']
                                        )
                                     );
            
            $enquiry_product_id = $sqlquery->execute();
            return $enquiry_product_id;    
        }
        
        public function getTotalEnquiryProductCost($params = array()) {
            $this->result = array();
            $sqlquery = $this->FPDO
                             ->from('tblenquiry_products')
                             ->select(null)
                             ->select("SUM(product_total) AS total_product_cost")
                             ->innerJoin('tblenquiries ON tblenquiries.enquiry_id = tblenquiry_products.enquiry_id')
                             ->where('tblenquiry_products.enquiry_id = :enquiry_id', array(":enquiry_id" => $params["enquiry_id"]));
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function getTotalEnquiryProductQuantity($params = array()){
            $this->result = array();
            $sqlquery = $this->FPDO
                             ->from('tblenquiry_products')
                             ->select(null)
                             ->select("COUNT(tblenquiry_products.enquiry_product_id) AS total_products")
                             ->innerJoin('tblenquiries ON tblenquiries.enquiry_id = tblenquiry_products.enquiry_id')
                             ->where('tblenquiry_products.enquiry_id = :enquiry_id', array(":enquiry_id" => $params["enquiry_id"]));
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }
        
        public function deleteEnquiryProduct($params = array()) {
            $this->result = array();
            $sqlquery = $this->FPDO
                             ->deleteFrom('tblenquiry_products')
                             ->where('enquiry_id = :enquiry_id AND enquiry_product_id = :enquiry_product_id', array(":enquiry_id" => $params["enquiry_id"], ":enquiry_product_id" => $params['enquiry_product_id']));
            $this->result = $sqlquery->execute();
        }
        
    }
?>