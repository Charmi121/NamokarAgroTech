<?php
final class DBConfig {

   var $host;
   var $user;
   var $pass;
   var $db;
   var $db_link;
   var $strvar;
   var $conn = false;
   var $persistant = false;
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

   public $error = false;

   public function config()
   { // class config
        $this->error = true;
        $this->persistant = false;
   }


   public function error($type='')
   { //Choose error type
        if (empty($type)) {
            return false;
        }
        else {
            if ($type==1)
                echo "<strong>Database could not connect</strong> ";
            else if ($type==2)
                echo "<strong>mysql error</strong> " . mysql_error();
            else if ($type==3)
                echo "<strong>error </strong>, Proses has been stopped";
            else
                echo "<strong>error </strong>, no connection !!!";
        }
   }

   public function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
   }

   public function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_,', '+/='));
   }

   public function RemoveTags($stext){
       $stext = trim($stext);
       $stext = strip_tags($stext);
       $stext = mysql_real_escape_string($stext);
       return $stext;
   }

    public function cleanInput($input)
    {
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
    public function generateToken()
    {
        $token = md5(uniqid(rand(), true));
        return $token;
    }


}
?>