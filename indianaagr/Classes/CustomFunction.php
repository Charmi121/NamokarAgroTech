<?php
    namespace Classes;
    
    final class CustomFunction {

        var $badStrings = array("Content-Type:", "Content-Type: text/plain;", "MIME-Version:", "Content-Transfer-Encoding:", "Content-Transfer-Encoding: 7Bit", "to:", "bcc:", "cc:", "href=", "script");

        var $bad_words = array('a','and','the','an','it','is','with','can','of','why','not');

        //This string tells crypt to use blowfish for 5 rounds.
        var $blowfish_pre = '$2a$05$';
        var $blowfish_end = '$';

        // Blowfish accepts these characters for salts.
        var $allowed_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
        var $chars_len = 63;

        // 18 would be secure as well.
        var $salt_length = 21;
        
        public $result = array();

        public function getRealIpAddr() {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
                $ip = $_SERVER['REMOTE_ADDR'];
            }

            return $ip;
        }
        
        public function getIPVersion($txt) {
             return strpos($txt, ":") === false ? 4 : 6;
        }        
       
        public function fileExist($filepath) {
            $dirname = dirname($filepath);
            $filename = basename($filepath);
            $dir = dir($dirname);
            while (($file = $dir->read()) !== false) {
                if (strtolower($file) == strtolower($filename))
                {
                    $dir->close();
                    return true;
                }
            }
            $dir->close();
            return false;
        }
        
        public function checkFileExist($filepath) {
            if(is_file($filepath)){
                return 707;
            }else{
                return 505;
            }
        }

        public function genRandomString() {
            $length = 6;
            $characters = '0123456789';
            $ranstring = (isset($ranstring)) ? $ranstring : '';
            for ($p = 0; $p < $length; $p++) {
                $ranstring .= $characters[mt_rand(0, strlen($characters)-1)];
            }
            return $ranstring;
        }

        public function checkStringPattern($subject) {
            //if(preg_match("/[^a-zA-Z0-9]*/", $subject) || empty($subject)){
            $reg = "#[^a-z0-9\s-]#i";
            $matches = 0;
            $count = preg_match($reg, $subject, $matches);
            if ((int)$count > 0){
                return 505;
            } else {
                return 707;
            }
        }

        public function checkStringPatternValid($subject) {
            $reg = "#[^a-z0-9\s-]#i";
            $matches = 0;
            $count = preg_match($reg, $subject, $matches);
            echo $count;
            if ((int)$count > 0){
                return 505;
            } else {
                return 707;
            }
        }

        public function checkEmail($emailtext) {
            //if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $emailtext)) {
            if(!filter_var($emailtext, FILTER_VALIDATE_EMAIL)) {
                return 505;
            } else {
                return 707;
            }
        }

        public function checkComment($commenttext) {
            $pos = strpos($commenttext, "http");
            if(isset($commenttext) && $pos == true)
            {
                return false;
            } else {
                return true;
            }
        }

        public function checkVideoFileType($filename) {
            $mimetype= "";
            $allowedvideotypes =  array("video/x-flv", "video/mp4", "application/x-mpegURL ", "video/MP2T", "video/3gpp", "video/quicktime", "video/x-msvideo", "video/x-ms-wmv" );
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }
            if(in_array($mimetype ,$allowedvideotypes)){
                $pass = (int)1;
            } else {
                $pass = (int)0;
            }
            return (int)$pass;
        }

        public function checkPDFFileType($filename) {
            $mimetype= "";
            $allowedpdftypes =  array( "application/pdf" );
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME);
                $mimetype = finfo_file($finfo, $filename);
                finfo_close($finfo);
                return $mimetype;
            }
            if(in_array($mimetype ,$allowedpdftypes)){
                $pass = (int)1;
            } else {
                $pass = (int)0;
            }
            return (int)$pass;
        }

        public function checkUsername($username) {
            $regex = '/^[\w]{2,20}$/i';
            // Run the preg_match() function on regex against the email address
            if (preg_match($regex, $username)) {
                return 707;
            } else {
                return 505;
            }
        }

        public function addHTTP($url) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "http://" . $url;
            }
            return $url;
        }

        public function siteURL() {
            //$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            $domainName = $_SERVER['HTTP_HOST'];
            $webroot = dirname($_SERVER['PHP_SELF']);
            return $protocol.$domainName.$webroot;
        }

        public function setSEOURL($string) {
            $string = preg_replace("`\[.*\]`U","",$string);
            $string = preg_replace('`&(amp;)?#?[a-z0-9]+;`i','-',$string);
            $string = htmlentities($string, ENT_COMPAT, 'utf-8');
            $string = preg_replace( "`&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);`i","\\1", $string );
            $string = preg_replace( array("`[^a-z0-9]`i","`[-]+`") , "-", $string);
            return strtolower(trim($string, '-'));
        }

        public function all_ascii( $stringIn ) {
            $final = '';
            $search = array("\r","\n");
            $replace = array(" "," ");

            $hold = str_replace($search[0],$replace[0],$stringIn);
            $hold = str_replace($search[1],$replace[1],$hold);

            if(!function_exists('str_split')){
                function str_split($string,$split_length=1){
                    $count = strlen($string);
                    if($split_length < 1){
                        return false;
                    } elseif($split_length > $count){
                        return array($string);
                    } else {
                        $num = (int)ceil($count/$split_length);
                        $ret = array();
                        for($i=0;$i < $num;$i++){
                            $ret[] = substr($string,$i*$split_length,$split_length);
                        }
                        return $ret;
                    }
                }
            }

            $holdarr = str_split($hold);
            foreach ($holdarr as $val) {
                if (ord($val) < 128) $final .= $val;
            }
            return $final;
        }        

        public function generatePassword($length) {

            //fallback to mt_rand if php < 5.3 or no openssl available
            $characters = '0123456789';
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz/+';
            $charactersLength = strlen($characters) - 1;
            $randomCode = '';

            //select some random characters
            for ($i = 0; $i < $length; $i++) {
                $randomCode .= $characters[mt_rand(0, $charactersLength)];
            }

            return str_shuffle($randomCode);
        }

        public function setFolderName($folderstring) {
            $foldername   =   null;
            $productsku   =   strtoupper(trim($folderstring));
            $foldername   =   preg_replace('/[^a-zA-Z0-9]/', '-', $folderstring);
            return $foldername;
        }

        public function getBase64UrlEncode($input) {
            return strtr(base64_encode($input), '+/=', '-_,');
        }

        public function getBase64UrlDecode($input) {
            return base64_decode(strtr($input, '-_,', '+/='));
        }

        public function removeTags($stext) {
            $stext = strip_tags($stext);
            //$stext = mysql_real_escape_string($stext);
            return $stext;
        }

        public function cleanInput($input) {
            //remove whitespace...
            $input = trim($input);

            //strip HTML tags from input data
            $input = strip_tags($input);

            //disable magic quotes...
            $input = get_magic_quotes_gpc() ? stripslashes($input) : $input;

            //prevent sql injection...
            //$input = is_numeric($input) ? intval($input) : mysql_real_escape_string($input);

            //prevent xss...
            $input = htmlspecialchars($input,ENT_QUOTES,"UTF-8");
            return $input;
        }

        public function generateToken() {
            $token = md5(uniqid(rand(), true));
            return $token;
        }

        public function checkFileImage($ext, $imageinfo = array()) {
            if (($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png') && (trim($imageinfo['mime']) == 'image/gif' || trim($imageinfo['mime']) == 'image/jpeg' || trim($imageinfo['mime']) == 'image/png' || trim($imageinfo['mime']) == 'image/bmp')) {
                $pass = (int)1;
            } else {
                $pass = (int)0;
            }
            return (int)$pass;
        }

        public function checkFileExtension($ext) {
            if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png' ) {
                $pass = (int)1;
            } else {
                $pass = (int)0;
            }
            return (int)$pass;
        }

        public function getParagraph($myString){
            $dom = new DOMDocument;
            $dom->loadHTML($myString);
            $p = $dom->getElementsByTagName('p');
            //If each can contains other HTML elements(or not), create a function:

            function getInner(DOMElement $node) {
                $tmp = "";
                foreach($node->childNodes as $c) {
                    $tmp .= $c->ownerDocument->saveXML($c);
                }
                return $tmp;
            }
            //and then use that function when needing the paragraph like so:

            $p1 = getInner($p->item(0));
            $p2 = getInner($p->item(1));

            return array($p1, $p2);
            //Usage
            //$result = getParagraph($myString);
            // echo $result[0]; // $p1
            //echo $result[1]; // $p2
        }

        public function getPageURL() {
            $pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            
            $pageURL = preg_replace('/\?.*$/', '', $pageURL);
            return $pageURL;
        } 

        protected function checkHttpFileExist($url, $followRedirects = true) {
            $url_parsed = parse_url($url);
            extract($url_parsed);
            if (!@$scheme) $url_parsed = parse_url('http://'.$url);
            extract($url_parsed);
            if(!@$port) $port = 80;
            if(!@$path) $path = '/';
            if(@$query) $path .= '?'.$query;
            $out = "HEAD $path HTTP/1.0\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n\r\n";
            if(!$fp = @fsockopen($host, $port, $es, $en, 5)){
                return false;
            }
            fwrite($fp, $out);
            while (!feof($fp)) {
                $s = fgets($fp, 128);
                if(($followRedirects) && (preg_match('/^Location:/i', $s) != false)){
                    fclose($fp);
                    return $this->http_file_exists(trim(preg_replace("/Location:/i", "", $s)));
                }
                if(preg_match('/^HTTP(.*?)200/i', $s)){
                    fclose($fp);
                    return true;
                }
            }
            fclose($fp);
            return false;
        }

        public function loadCSS($folder_name, $file_name) {
            $file_path = BASEURL.$folder_name.DS.trim($file_name);

            if($this->checkHttpFileExist($file_path)) {
                return $file_path;
            } else {
                trigger_error($file_path." not found!");
                die;
            }
        }

        public function loadJS($folder_name, $file_name) {
            $file_path = BASEURL.$folder_name.DS.trim($file_name);

            if($this->http_file_exists($file_path)) {
                return $file_path;
            } else {
                trigger_error($file_name." not found!");
                die;
            }
        }

        public function remoteFileExists($url) {
            $curl = curl_init($url);

            //don't fetch the actual page, you only want to check the connection is ok
            curl_setopt($curl, CURLOPT_NOBODY, true);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

            //do request
            $result = curl_exec($curl);

            $ret = false;

            //if request did not fail
            if ($result !== false) {
                //if request was ok, check response code
                $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($statusCode == 200) {
                    $ret = true;
                }
            }

            curl_close($curl);

            return $ret;
        }

        public function checkFileExists($file_path) {    
            return (file_exists($file_path) && is_file($file_path)) ? 1 : 0;
        }
        
        public function showImage($folder_name, $file_name, $options = array()) {
            $file_path = CONFIG_PATH.$folder_name.trim($file_name);

            $absolute_file_url = ROOT.DS.$folder_name.trim($file_name);

            if (!empty($file_name) && is_file($absolute_file_url)) {
                return $file_path;
            } else {
                return CONFIG_PATH.'uploads/no-image/no-image.png';
            }
        }
        
        public function showImagePath($folder_name, $file_name){
            if(!empty($file_name) && (int)$this->checkFileExists(UPLOAD_PATH.DS.$folder_name.DS.$file_name) == 1 ){
                 $image_path = DISPLAY_PATH.DS.$folder_name.DS.$file_name; 
            } else {
                 $image_path = DISPLAY_PATH.DS."no-image".DS."no-image.png"; 
            } 
            return $image_path;
        }        

        public function moneyFormatIndia($num) {
            $explrestunits = "" ;
            $num=preg_replace('/,+/', '', $num);
            $words = explode(".", $num);
            $des="00";
            if(count($words)<=2){
                $num=$words[0];
                if(count($words)>=2){$des=$words[1];}
                //if(strlen($des)<2){$des="$des0";}else{$des=substr($des,0,2);}
                if(strlen($des)<2){$des="$des"."0";}else{$des=substr($des,0,2);}
            }
            if(strlen($num)>3){
                $lastthree = substr($num, strlen($num)-3, strlen($num));
                $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
                $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
                $expunit = str_split($restunits, 2);
                for($i=0; $i<sizeof($expunit); $i++){
                    // creates each of the 2's group and adds a comma to the end
                    if($i==0)
                    {
                        $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
                    }else{
                        $explrestunits .= $expunit[$i].",";
                    }
                }
                $thecash = $explrestunits.$lastthree;
            } else {
                $thecash = $num;
            }
            return "$thecash.$des"; // writes the final format where $currency is the currency symbol.
        }

        public function getShortenString($string, $wordsreturned) {
            $retval = $string;

            $array = explode(" ", $string);
            if (count($array)<=(int)$wordsreturned){
                $retval = $string;
            } else {
                array_splice($array, $wordsreturned);
                $retval = implode(" ", $array)." ...";
            }
            return $retval;
        }

        public function getStringLength($string, $length) {
            $retval = strlen($string) > $length ? substr($string,0,$length)."..." : $string;
            return $retval;
        }
        
        public function getArrayByKey($arr_data = array(), $key = 0){
            $this->result = array();
            if(!empty($arr_data[$key]) && is_array($arr_data[$key])) {
                $this->result = $arr_data[$key];     
            }
            return $this->result; 
        }
        
        public function searchArray($needle, array $haystack) {
            foreach ($haystack as $key => $value) {
                if(strcasecmp(trim($needle), trim($value)) == 0) {
                    //if (false !== stripos(trim($needle), $value)) {
                    return $key;
                }
            }
            return false;
        }
        
        public function getCategoryQuery($needle, array $haystack) {
            $this->response = '';
            foreach ($haystack as $key => $value) {
                if(strcasecmp(trim($needle), trim($value)) != 0) {
                    //if (false !== stripos(trim($needle), $value)) {
                    $this->response = $this->response . str_ireplace(' ', "+", $value)."-";
                }
            }
            return trim($this->response, "-");
        }
        
        public function getCurrentPageURL($seo_url = null, $folder_name = null) {
            if(!empty($folder_name)){
                $CurrentPageURL = CONFIG_PATH.$folder_name.DS.$seo_url.".html"; 
            } else {
                $CurrentPageURL = CONFIG_PATH.$seo_url.".html"; 
            }
            return $CurrentPageURL;
        }
        
        public function getPlusValue($value = null) {
            $plusValue = strtolower(urlencode($value)); 
            return $plusValue;
        }
        
        public function generateRandomCouponCode() {
            return strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 12));
        }
        
        public function generateGoogleConversionScript($order = array(), $order_details = array()) {
            
            $orderArr = array();
            $orderArr['order_no'] = $order['order_no'];
            $orderArr['store_domain_name'] = STORE_DOMAIN;
            $orderArr['total_payable_amount'] = $order['total_payable_amount'];
            
            $orderArr['total_order_amount'] = $order['total_order_amount'];
            $orderArr['total_tax'] = $order['total_tax'];
            $orderArr['total_discount'] = $order['total_discount'];
            $orderArr['total_shipping'] = $order['total_shipping'];
            
            $orderArr['shipping_country'] = $order['shipping_country'];
            $orderArr['shipping_state'] = $order['shipping_state'];
            $orderArr['shipping_city'] = $order['shipping_city'];
            
            $orderArr['currency_code'] = $order['currency_code'];
            $orderArr['currency_symbol'] = $order['currency_symbol'];
            
            
            $script_str = "";

            $script_str .= "var _gaq = _gaq || []; \r\n";
            $script_str .= "_gaq.push(['_setAccount', 'UA-82818244-1']); \r\n";
            $script_str .= "_gaq.push(['_setDomainName', '".STORE_DOMAIN."']); \r\n";
            $script_str .= "_gaq.push(['_trackPageview']); \r\n";

            $script_str .= "_gaq.push(['_addTrans', '".$orderArr['order_no']."', '".$orderArr['store_domain_name']."', '".$orderArr['total_payable_amount']."', '".$orderArr['total_tax']."', '".$orderArr['total_shipping']."', '".$orderArr['shipping_city']."', '".$orderArr['shipping_state']."', '".$orderArr['shipping_country']."']); \r\n";

            $currency_code = $orderArr['currency_code'];

            // add item might be called for every item in the shopping cart
            // where your ecommerce engine loops through each item in the cart and
            // prints out _addItem for each
            if(!empty($order_details)) {
                  foreach($order_details as $order_detail) {
                    $script_str .= "_gaq.push(['_addItem', '".$order_detail['order_no']."', '".$order_detail['sku']."', '".$order_detail['product_name']."', '', '".$order_detail['product_price']."', '".$order_detail['quantity']."']); \r\n";
                  }
            }

            $script_str .= "_gaq.push(['_set', 'currencyCode', '".$currency_code."']); \r\n";
            $script_str .= "_gaq.push(['_trackTrans']); \r\n";  //submits transaction to the Analytics servers

            $script_str .= "(function() {  \r\n
                               var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; \r\n
                               ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; \r\n
                               var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s); \r\n
                            })();";
                            
            return $script_str;
        }
    
    }
?>