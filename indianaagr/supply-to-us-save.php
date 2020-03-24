<?php ob_start(); ?>
<?php
require_once("mail.php");
require_once('main.php');
require("connect.inc.php");
require("config.php");
$DB = new DBConfig();
$DB->config();

$first_name = (!empty($_POST['first_name']) ) ? $DB->cleanInput($_POST['first_name']) : '';
$last_name = (!empty($_POST['last_name']) ) ? $DB->cleanInput($_POST['last_name']) : '';
$email = (!empty($_POST['email']) ) ? $DB->cleanInput($_POST['email']) : '';
$company_name = (!empty($_POST['company_name']) ) ? $DB->cleanInput($_POST['company_name']) : '';
$website = (!empty($_POST['website']) ) ? $_POST['website'] : '';
$mobile = (!empty($_POST['mobile']) ) ? $_POST['mobile'] : '';
$comment = (!empty($_POST['comment']) ) ? $_POST['comment'] : '';

if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
  {
	 
	$secret = SECRET_KEY;
	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	echo $verifyResponse;
	$responseData = json_decode($verifyResponse);
	if($responseData->success)
	{

			$message = "<body>";
			$message .= "<table cellpadding='5' cellspacing='0' width='600px' border='1' bordercolor='#E3E3E3' style='border-collapse:collapse; font-family: Arial; font-size:11px;'>";

			$fullname = $first_name.' '.$last_name;
			$message .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Supplier request received from " . $email . "</td></tr>";
			$message .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
			$message .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
			$message .= "<tr><td><b>Mobile</b></td><td>" . $mobile . "</td></tr>";
			$message .= "<tr><td><b>Company Name</b></td><td>" . $company_name . "</td></tr>";
			$message .= "<tr><td><b>Website</b></td><td>" . $website . "</td></tr>";
			$message .= "<tr><td><b>Query Message</b></td><td>" . $comment . "</td></tr>";
			$message .= "</table>";
			$message .= "</body>";
			$to = "info@indiaagrovision.com";
			$subject = 'Supplier request received from ' . $email;
			$message = $message;
			$from = $email;

			$headers = "From: " . $from . "\r\n";
			$headers .= "Content-Type: text/html\r\n";

			// $headers .= "X-Mailer: PHP".phpversion();                          
			//send the mail
			//send the mail
			$ok = @mail($to, $subject, $message, $headers);
			if ($ok) {
				
			}

			$_SESSION['email_sent'] = 1;
			header("Location: supply-to-us.php");
			exit();
	}
        
}
else
{
	$_SESSION['email_sent'] = 2;
	header("Location: supply-to-us.php");
	exit();
}		
?>