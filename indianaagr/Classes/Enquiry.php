<?php
    namespace Classes;

    class Enquiry
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

        public function getEnquiries() {
            $this->result = array();
            $sqlquery = $this->FPDO->from('tblenquiries')
                                   ->select(null)
                                   ->select('tblenquiries.enquiry_id')
                                   ->where("tblenquiries.status = :status ", array(":status" => 707));
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }

        public function getEnquiryInfo($params = array()) {
            try {
                $this->result = array();
                $sqlquery = $this->FPDO
                                ->from('tblenquiries')
                                ->limit(1);
                if(!empty($params['session_id'])) {
                    $sqlquery->where("tblenquiries.session_id = :session_id", array(":session_id" => $params['session_id']));
                }

                if(!empty($params['enquiry_id'])) {
                    $sqlquery->where("tblenquiries.enquiry_id = :enquiry_id", array(":enquiry_id" => $params['enquiry_id']));
                }

                $this->result = $sqlquery->fetchAll();
                return $this->result;
            } catch (Exception $e) {
                echo "Exception while processing order: ", $e->getMessage(), "\n";
            }
        }

        public function setEnquiryNo($params = array()) {
            $enquiry_id = 0;  
            $sqlquery = $this->FPDO->insertInto('tblenquiries')
                                   ->values(
                                       array(
                                           'session_id' => $params['session_id'],
                                           'user_id' => $params['user_id'],
                                           'status' => $params['status'],
                                           'sort_order' => $params['sort_order'],
                                           'ip_address' => $params['ip_address'],
                                           'created' => $params['created'],
                                           'modified' => $params['modified']
                                       ));

            $enquiry_id = $sqlquery->execute();

            return $enquiry_id;
        }

        public function getCurrentEnquiryInfo(){
            $sqlquery = $this->FPDO
                            ->from('tblenquiries')
                            ->where('tblenquiries.session_id = :session_id AND tblenquiries.status != :status', array(":session_id" => $_SESSION['orientique']['session_id'], ":status" => 909))
                            ->order('enquiry_id ASC'); 
            $this->result = $sqlquery->fetchAll();
            return $this->result;
        }

        public function updateCurrentOrderInfo($params = array()){
            $sqlquery = $this->FPDO
                            ->update('tblenquiries')
                            ->set(array(
                                    'session_id' => $params['session_id'],
                                    'user_id'    => $params['user_id']
                                ));
            $sqlquery->where('tblenquiries.enquiry_id = ?', $params['enquiry_id']);
            $result = $sqlquery->execute();
        }

        public function updateEnquiryInfo($params = array()){
            $sqlquery = $this->FPDO
                             ->update('tblenquiries')
                             ->set($params)
                             ->where('tblenquiries.enquiry_id = ?', $params['enquiry_id']);
            $result = $sqlquery->execute();
            return $this->result;
        }

        public function getTotalEnquiryCount($params = array()){
            $sqlquery = $this->FPDO
                             ->from('tblenquiries')
                             ->select('COUNT(enquiry_id) as numrows') 
                             ->where("tblenquiries.user_id = :user_id AND tblenquiries.status != :status", array(":user_id" => $params['user_id'], ":status" => 909));
            $this->result = $sqlquery->fetchAll(); 
            return $this->result;                        
        }

        /*
        public function SendEnquiryMail_Old($enquiry_id = 0) {

            $msgtext    =   "<body>";
            $msgtext    =   $msgtext . "<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\" bordercolor=\"#F8F8F8\" style=\"border-color:#E3E3E3; border-collapse:collapse; font-size:12px; font-family:Calibri; width:700px;\">";
            $msgtext    =   $msgtext . "<tr>";

            $sqlquery = $this->FPDO
                            ->from('tblconfiguration')
                            ->order('tblconfiguration.id ASC')
                            ->limit(1); 
            $rsconfig = $sqlquery->fetchAll();

            if (!empty($rsconfig))
            {
                foreach ($rsconfig as $rowconfig)
                {
                    $msgtext    =   $msgtext . "<td style=\"width:290px;\"><a href=\"\"><img src=\"".BASEURL."images/logo.jpg\" alt=\"".$rowconfig['websitetitle']."\" width=\"180\" height=\"105\" /></a></td>";
                    $msgtext    =   $msgtext . "<td style=\"width:230px;\">";
                    $msgtext    =   $msgtext . "<b>".$rowconfig['websitetitle']."</b> <br />";
                    $msgtext    =   $msgtext . "".nl2br(html_entity_decode($rowconfig['address'],ENT_QUOTES,"UTF-8"))." <br />";
                    $msgtext    =   $msgtext . "Phone: ".$rowconfig['phoneno']." <br />";
                    //$msgtext    =   $msgtext . "Fax: ".$rowconfig['fax']." <br />";
                    $msgtext    =   $msgtext . "Email: <a href=\"mailto:".$rowconfig['ordermail']."\">".$rowconfig['ordermail']."</a>";
                    $msgtext    =   $msgtext . "</td>";
                }
            }
            $msgtext    =   $msgtext . "<td style=\"width:180px;\">";
            $msgtext    =   $msgtext . "Enquiry Date: ".date("d-M-Y", strtotime('now'))."<br />";
            $msgtext    =   $msgtext . "</td>";
            $msgtext    =   $msgtext . "</tr>";
            $msgtext    =   $msgtext . "<tr>";
            $msgtext    =   $msgtext . "<td colspan=\"3\" style=\"font-size:16px; font-weight:bold; text-align:center;\">Enquiry Info</td>";
            $msgtext    =   $msgtext . "</tr>";

            $params = array();
            $params['enquiry_id'] = $enquiry_id;
            $rsenquiry    =  $this->getEnquiryInfo($params); 
            if (!empty($rsenquiry))
            {
                foreach ($rsenquiry as $rowenquiry)
                {
                    $msgtext    =   $msgtext . "<tr>";
                    $msgtext    =   $msgtext . "<td colspan=\"3\">";
                    $msgtext    =   $msgtext . "<table>";
                    $msgtext    =   $msgtext . "<tr>";
                    $msgtext    =   $msgtext . "<td style=\"width:300px; vertical-align:top;\">";
                    $msgtext    =   $msgtext . "<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\" bordercolor=\"#F8F8F8\" style=\"border-color:#E3E3E3; border-collapse:collapse; font-size:12px; font-family:Calibri; width:100%;\">";
                    $msgtext    =   $msgtext . "<tr>";
                    $msgtext    =   $msgtext . "<td style=\"background-color:#E3E3E3; font-weight:bold;\">Billing Information</td>";
                    $msgtext    =   $msgtext . "</tr>";
                    $msgtext    =   $msgtext . "<tr>";
                    $msgtext    =   $msgtext . "<td>";
                    $msgtext    =   $msgtext . "".$rowenquiry['payment_firstname']." ".$rowenquiry['payment_lastname']."<br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['payment_address_1']."<br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['payment_address_2']."<br />";
                    //$msgtext    =   $msgtext . "".$rowenquiry['payment_suite']."<br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['payment_city'].", ".$rowenquiry['payment_state'].", ".$rowenquiry['payment_country']."<br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['payment_postcode']."<br />";
                    $msgtext    =   $msgtext . "Phone: ".$rowenquiry['payment_phone']."";
                    $msgtext    =   $msgtext . "</td>";
                    $msgtext    =   $msgtext . "</tr>";
                    $msgtext    =   $msgtext . "</table>";
                    $msgtext    =   $msgtext . "</td>";
                    $msgtext    =   $msgtext . "<td style=\"width:100px;\">&nbsp;</td>";
                    $msgtext    =   $msgtext . "<td style=\"width:300px; vertical-align:top;\">";
                    $msgtext    =   $msgtext . "<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\" bordercolor=\"#F8F8F8\" style=\"border-color:#E3E3E3; border-collapse:collapse; font-size:12px; font-family:Calibri; width:100%;\">";
                    $msgtext    =   $msgtext . "<tr>";
                    $msgtext    =   $msgtext . "<td style=\"background-color:#E3E3E3; font-weight:bold;\">Shipping Information</td>";
                    $msgtext    =   $msgtext . "</tr>";
                    $msgtext    =   $msgtext . "<tr>";
                    $msgtext    =   $msgtext . "<td>";
                    $msgtext    =   $msgtext . "".$rowenquiry['shipping_firstname']." ".$rowenquiry['shipping_lastname']." <br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['shipping_address_1']." <br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['shipping_address_2']." <br />";
                    //$msgtext    =   $msgtext . "".$rowenquiry['shipping_suite']." <br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['shipping_city'].", ".$rowenquiry['shipping_state'].", ".$rowenquiry['shipping_country']."<br />";
                    $msgtext    =   $msgtext . "".$rowenquiry['shipping_postcode']." <br />";
                    $msgtext    =   $msgtext . "Phone: ".$rowenquiry['shipping_phone']."";
                    $msgtext    =   $msgtext . "</td>";
                    $msgtext    =   $msgtext . "</tr>";
                    $msgtext    =   $msgtext . "</table>";
                    $msgtext    =   $msgtext . "</td>";
                    $msgtext    =   $msgtext . "</tr>";
                    $msgtext    =   $msgtext . "</table>";
                    $msgtext    =   $msgtext . "</td>";
                    $msgtext    =   $msgtext . "</tr>";

                    // Get order product details  
                    $params     = array() ;
                    $params['enquiry_id'] = $enquiry_id;
                    $enquiryProduct = new EnquiryProduct($this->FPDO);
                    $rsenquirydtl = $enquiryProduct->getEnquiryProducts($params);
                    if(!empty($rsenquirydtl))
                    {
                        $msgtext    =   $msgtext . "<tr>";
                        $msgtext    =   $msgtext . "<td colspan=\"3\">";
                        $msgtext    =   $msgtext . "<table cellpadding=\"5\" cellspacing=\"0\" border=\"1\" bordercolor=\"#F8F8F8\" style=\"border-color:#E3E3E3; border-collapse:collapse; font-size:12px; font-family:Calibri; width:100%;\">";
                        $msgtext    =   $msgtext . "<tr style=\"background-color:#E3E3E3; font-weight:bold;\">";
                        $msgtext    =   $msgtext . "<td style=\"text-align:center;\">Image</td>";
                        $msgtext    =   $msgtext . "<td>Description</td>";
                        $msgtext    =   $msgtext . "</tr>";
                        $subtotal = 0;
                        foreach ($rsenquirydtl as $rowenquirydtl)
                        {
                            $productsku =   null;
                            $productsku =   strtoupper(trim($rowenquirydtl['sku']));
                            $foldername =   preg_replace('/[^a-zA-Z0-9]/', '-', $productsku);
                            //Create subfolder according to sku
                            $dirpath    =   BASEURL."uploads/products/".$foldername."/";

                            $msgtext    =   $msgtext . "<tr>"; 
                            if($rowenquirydtl['product_id']) {  
                                if($rowenquirydtl['metal_name']== "White Gold"){ 
                                    $msgtext    =   $msgtext . "<td style=\"vertical-align:middle; text-align:center;\"><a href=\"".BASEURL.$rowenquirydtl['seo_url'].".html"."\" target=\"_blank\"><img src=\"".$dirpath.$rowenquirydtl['mini_image_3']."\" alt=\"".$rowenquirydtl['product_name']."\" width=\"100px\"></a></td>";
                                } else {
                                    $msgtext    =   $msgtext . "<td style=\"vertical-align:middle; text-align:center;\"><a href=\"".BASEURL.$rowenquirydtl['seo_url'].".html"."\" target=\"_blank\"><img src=\"".$dirpath.$rowenquirydtl['mini_image']."\" alt=\"".$rowenquirydtl['product_name']."\" width=\"100px\"></a></td>";
                                }
                            }

                            if($rowenquirydtl['solitaire_id'])  {
                                if(!empty($rowenquirydtl['stone_shape_name'])){

                                    $params = array();
                                    $params['mould_shape'] = $rowenquirydtl['stone_shape_name'];

                                    $stoneShape = new StoneShape($this->FPDO);
                                    $rsresult = $stoneShape->getStoneShape($params);
                                    if(!empty($rsresult)){
                                        foreach($rsresult as $rowresult){
                                            if(!empty($rowresult['thumb_image'])){
                                                $msgtext    =   $msgtext . "<td style=\"vertical-align:middle; text-align:center;\"><a href=\"".BASEURL.$rowenquirydtl['seo_url'].".html"."\" target=\"_blank\"><img src=\"uploads/stone-shape/".$rowenquirydtl['thumb_image']."\" alt=\"".$rowenquirydtl['product_name']."\" width=\"100px\"></a></td>";
                                            }
                                        }
                                    }
                                }
                            }

                            $msgtext    =   $msgtext . "<td style=\"padding-left:5px;\"><strong>".$rowenquirydtl['product_name']."</strong><br/>";
                            $msgtext    =   $msgtext . "SKU : <span style=\"text-decoration:underline;\"><a href=\"".BASEURL.$rowenquirydtl['seo_url'].".html"."\" target=\"_blank\">".$rowenquirydtl['sku']."</a></span><br/>";

                            $params = array();
                            $params['enquiry_id']         = $rowenquirydtl['enquiry_id'];
                            $params['order_product_id'] = $rowenquirydtl['order_product_id'];
                            $params['product_id']       = $rowenquirydtl['product_id'];

                            $orderOption = new OrderOption($this->FPDO);
                            $rsoption = $orderOption->getOrderOption($params);

                            if(!empty($rsoption))
                            {
                                foreach ( $rsoption as $rowoption ) {
                                    $msgtext    =   $msgtext . "<strong>".$rowoption['option_name'].": ".$rowoption['option_value_name']."</strong><br/>";
                                }
                            }
                            if($rowenquirydtl['metal_id']){
                                $msgtext    =   $msgtext . "<strong>Metal: ".$rowenquirydtl['metal_purity_name']." ".$rowenquirydtl['metal_name']."</strong><br/>";
                            }
                            if(!empty($rowenquirydtl['stone_clarity_id'])) {
                                $msgtext  =   $msgtext . "<strong>Diamond Clarity: ".$rowenquirydtl['stone_clarity_name']."</strong><br/>";
                            }
                            if(!empty($rowenquirydtl['product_size'])) {
                                $msgtext   =   $msgtext . "<strong>".$rowenquirydtl['size_type_name'].": ".$rowenquirydtl['product_size']."</strong><br/>";
                            }
                            if(!empty($rowenquirydtl['description'])) {
                                $msgtext   =   $msgtext . "<strong>".$rowenquirydtl['description']."</strong><br/>";
                            }


                            //$gia_certificate_cost = 0;
                            if (!empty($rowenquirydtl['gia_certificate_cost']) && floatval($rowenquirydtl['gia_certificate_cost'])> 0.00) {
                                $msgtext    =   $msgtext . "<strong>GIA Certificate: ".  $_SESSION['orientique_currency_symbol']. sprintf("%0.00f",($rowenquirydtl['gia_certificate_cost']))."</strong><br/>";
                                //$gia_certificate_cost = sprintf("%0.02f", $rowenquirydtl['gia_certificate_cost']);
                            }

                            $msgtext    =   $msgtext . "</td>";

                            //Unit Price
                            //$product_unit    =  sprintf('%0.2f', ($rowenquirydtl['product_price']));
                            $msgtext    =   $msgtext . "<td style=\"vertical-align:middle; text-align:center;\">".$rowenquiry['currency_code'].sprintf('%0.00f', $rowenquirydtl['product_price']/ $rowenquirydtl['currency_value'])."</td>";
                            $msgtext    =   $msgtext . "<td style=\"vertical-align:middle; text-align:center;\">".$rowenquirydtl['quantity']."</td>";

                            //Product Total Value
                            //$product_total= sprintf('%0.2f',  sprintf('%0.2f', (($rowenquirydtl['quantity'] * ($rowenquirydtl['product_price'] + $rowenquirydtl['gia_certificate_cost'])))));
                            $msgtext    =   $msgtext . "<td style=\"vertical-align:middle; text-align:center;\">".$rowenquiry['currency_code'].sprintf('%0.00f', $rowenquirydtl['total']/ $rowenquirydtl['currency_value'])."</td>";
                            $msgtext    =   $msgtext . "</tr>";

                            //Sub-Total Of Order
                            $subtotal   =   $subtotal + sprintf('%0.0f',  sprintf('%0.0f', (($rowenquirydtl['quantity'] * ($rowenquirydtl['product_price'] + $rowenquirydtl['gia_certificate_cost']) ) / $rowenquirydtl['currency_value'] ) ) );
                        }
                        $grand_total = 0;
                    }
                    
                    $msgtext    =   $msgtext . "</table>";
                    $msgtext    =   $msgtext . "</td>";
                    $msgtext    =   $msgtext . "</tr>";

                    $email      =   trim($rowenquiry['payment_email']);
                }
            }
            $msgtext    =   $msgtext . "</table>";
            $msgtext    =   $msgtext . "</body>";

            //Send Mail
            $toemail  = $email;

            $message  = $msgtext;

            // subject
            $subject  = 'Thankyou for order at www.orientique.com';
            $fromemail= "order@orientique.com";

            // To send HTML mail, the Content-type header must be set
            $headers  = "MIME-Version: 1.0\n";
            $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
            $headers .= "From: ".STORE_WEBSITETITLE." <".$fromemail.">\n";
            $headers .= 'Cc: '.STORE_CONTACTEMAIL.''. "\r\n";
            $headers .= 'Bcc: '.$fromemail.''. "\r\n";

            // Mail it
            mail($toemail, $subject, $message, $headers);
        }
        */
        
        public function SendEnquiryMail($mail_params = array()) {
        
            $custom = new CustomFunction();
            
            // Only To Check Format Of Email
            $replacements = $store_info = $enquiry_info = $enquiry_product_info = array();
            //Get Store Info
            $configuration = new Configuration($this->FPDO);
            $rsstores = $configuration->getConfigurationInfo();
            if(!empty($rsstores)) {
                 foreach($rsstores as $rowstore) {
                    $store_info = array(
                                   '[[BASE_URL]]' => BASEURL,
                                   '[[STORE_URL]]' => BASEURL,
                                   '[[STORE_LOGO_URL]]' => BASEURL."images/logo.jpg",
                                   '[[STORE_NAME]]' => ucfirst($rowstore['website_title']),
                                   '[[STORE_PHONE]]' => $rowstore['phone'],
                                   '[[STORE_EMAIL]]' => $rowstore['feedback_email'],
                                   
                                   '[[STORE_FACEBOOK]]' => $rowstore['facebook_url'],
                                   '[[STORE_TWITTER]]' => $rowstore['twitter_url'],
                                   '[[STORE_GOOGLEPLUS]]' => $rowstore['google_plus_url'],
                                   '[[STORE_PINTEREST]]' => $rowstore['pinterest_url']
                               );
                 }
            }
            
            //Get Order Info
            $params = array();
            $params['enquiry_id'] = (!empty($mail_params['enquiry_id'])) ? $mail_params['enquiry_id'] : 0;
            $params['session_id'] = (!empty($mail_params['session_id'])) ? $mail_params['session_id'] : 0;
            
            $rsenquiries = $this->getEnquiryInfo($params);
            if(!empty($rsenquiries)) {
                 foreach($rsenquiries as $rowenquiry) {
                    $enquiry_info = array(
                       '[[ENQUIRY_NO]]' => $rowenquiry['enquiry_id'],
                       '[[ENQUIRY_DATE]]' => date("d-F-Y", strtotime($rowenquiry['created'])),
                       
                       '[[CUSTOMER_NAME]]' => trim(ucwords($rowenquiry['first_name']))." ".trim(ucwords($rowenquiry['last_name'])),
                       '[[CUSTOMER_EMAIL]]' => $rowenquiry['email'],
                       '[[CUSTOMER_ADDRESS]]' => $rowenquiry['address'],
                       '[[CUSTOMER_MESSAGE]]' => $rowenquiry['message'],
                       
                       '[[YEAR]]' => date("Y", strtotime('now'))
                    );
                 }
            }
            
            //Get Order Product Info
            $params = array();
            $params['enquiry_id'] = (!empty($mail_params['enquiry_id'])) ? $mail_params['enquiry_id'] : 0;
            $enquiry_product_detail = '';
            
            $enquiryProduct = new EnquiryProduct($this->FPDO);
            $rsenquiry_products = $enquiryProduct->getEnquiryProducts($params);
            if(!empty($rsenquiry_products)) {
                foreach($rsenquiry_products as $rowenquiry_product) {
                    
                    $enquiry_product_detail = $enquiry_product_detail . "<tr>";
                    $enquiry_product_detail = $enquiry_product_detail . "<td><img src=\"".$custom->showImagePath("products", $rowenquiry_product['mini_image'])."\" /></td>";
                    $enquiry_product_detail = $enquiry_product_detail . "<td>";
                    $enquiry_product_detail = $enquiry_product_detail . "<strong>".$rowenquiry_product['product_name']."</strong><br/>";
                    $enquiry_product_detail = $enquiry_product_detail . "SKU: ".$rowenquiry_product['sku']."<br/>";
                    $enquiry_product_detail = $enquiry_product_detail . "Type: ".$rowenquiry_product['type_name']."<br/>";
                    $enquiry_product_detail = $enquiry_product_detail . "Fabric: ".$rowenquiry_product['fabric_name']."<br/>";
                    $enquiry_product_detail = $enquiry_product_detail . "Color: ".$rowenquiry_product['color_name']."<br/>";
                    $enquiry_product_detail = $enquiry_product_detail . "</td>";
                    $enquiry_product_detail = $enquiry_product_detail . "</tr>";
                    
                }
            }
            
            $enquiry_product_info = array('[[ENQUIRY_DETAIL]]' => $enquiry_product_detail);
            
            $replacements = array_merge($replacements, $store_info, $enquiry_info, $enquiry_product_info);
            
            //################ Send Email ##############//
            $mail = array();

            $mail['message'] = file_get_contents(BASEURL."emails/customer-enquiry.ctp");
            if(!empty($replacements)) {
                foreach($replacements as $find => $replace){
                     $mail['message'] = str_replace($find, $replace, $mail['message']);
                }
            }
            
            $mail['subject'] = "Customer Wishlist is received";

            $mail['from_email'] = STORE_FEEDBACKEMAIL;
            $mail['from_name'] = ucfirst(STORE_WEBSITETITLE);
            $mail['to_email'] = $enquiry_info['[[CUSTOMER_EMAIL]]'];
            
            // To send HTML mail, the Content-type header must be set
            $mail['headers'] = "MIME-Version: 1.0\n";
            $mail['headers'] .= "Content-Type: text/html; charset=iso-8859-1\n";
            $mail['headers'] .= "From: ".$mail['from_name']." <".$mail['from_email'].">\n";
            $mail['headers'] .= 'Bcc: '.$mail['from_email'].''. "\r\n";

            // Mail it
            mail($mail['to_email'], $mail['subject'], $mail['message'], $mail['headers']);
                
        }
        
    }
?>