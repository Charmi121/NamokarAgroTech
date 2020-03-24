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
$street_address = (!empty($_POST['street_address']) ) ? $_POST['street_address'] : '';
$city = (!empty($_POST['city']) ) ? $_POST['city'] : '';
$state = (!empty($_POST['state']) ) ? $_POST['state'] : '';
$post_code = (!empty($_POST['post_code']) ) ? $_POST['post_code'] : '';
$country = (!empty($_POST['country']) ) ? $_POST['country'] : '';
$telephone = (!empty($_POST['telephone']) ) ? $_POST['telephone'] : '';
$mobile = (!empty($_POST['mobile']) ) ? $_POST['mobile'] : '';
$requirement = (!empty($_POST['requirement']) ) ? $_POST['requirement'] : '';
$send_me_equiry = (!empty($_POST['send_me_equiry']) ) ? $_POST['send_me_equiry'] : 0;


 //echo $_POST['g-recaptcha-response']; exit;

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
			$message .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Salse enquiry received from " . $email . "</td></tr>";
			$message .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
			$message .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
			$message .= "<tr><td><b>Mobile</b></td><td>" . $mobile . "</td></tr>";
			$message .= "<tr><td><b>Telephone</b></td><td>" . $telephone . "</td></tr>";
			$message .= "<tr><td><b>Company Name</b></td><td>" . $company_name . "</td></tr>";
			$message .= "<tr><td><b>Website</b></td><td>" . $website . "</td></tr>";
			$message .= "<tr><td><b>Address</b></td><td>" . $street_address . "</td></tr>";
			$message .= "<tr><td><b>City</b></td><td>" . $city . "</td></tr>";
			$message .= "<tr><td><b>State</b></td><td>" . $state . "</td></tr>";
			$message .= "<tr><td><b>Country</b></td><td>" . $country . "</td></tr>";
			$message .= "<tr><td><b>Post  Code</b></td><td>" . $post_code . "</td></tr>";

			$message .= "<tr><td><b>Requirement</b></td><td>" . $requirement . "</td></tr>";
			$message .= "</table>";
			$message .= "</body>";

			$to = "info@indiaagrovision.com";

			$subject = 'Salse enquiry received from ' . $email;
			$message = $message;
			$from = $email;

			$headers = "From: " . $from . "\r\n";
			$headers .= "Content-Type: text/html\r\n";

			// $headers .= "X-Mailer: PHP".phpversion();                          
			//send the mail
			//send the mail
			$ok = @mail($to, $subject, $message, $headers);
			if ($ok) {
				if($send_me_equiry){
					$subjectauto = "Your enquiry is submitted successfully";

					$messageauto = "<body>";
					$messageauto .= "<table cellpadding='5' cellspacing='0' width='600px' border='1' bordercolor='#E3E3E3' style='border-collapse:collapse; font-family: Arial; font-size:14px; line-height:20px;'>";
					$messageauto .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Enquiry submitted successfully</td></tr>";
					$messageauto .= "<tr><td>Dear " . $fullname . ",<br>
																Thanks for getting in touch with us.<br>
																Looking forward to a meaningful association with you.<br><br></td></tr>";
					$messageauto .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Enquiry received from " . $email . "</td></tr>";
					$messageauto .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
					$messageauto .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
					$messageauto .= "<tr><td><b>Mobile</b></td><td>" . $mobile . "</td></tr>";
					$messageauto .= "<tr><td><b>Telephone</b></td><td>" . $telephone . "</td></tr>";
					$messageauto .= "<tr><td><b>Company Name</b></td><td>" . $company_name . "</td></tr>";
					$messageauto .= "<tr><td><b>Website</b></td><td>" . $website . "</td></tr>";
					$messageauto .= "<tr><td><b>Address</b></td><td>" . $street_address . "</td></tr>";
					$messageauto .= "<tr><td><b>City</b></td><td>" . $city . "</td></tr>";
					$messageauto .= "<tr><td><b>State</b></td><td>" . $state . "</td></tr>";
					$messageauto .= "<tr><td><b>Country</b></td><td>" . $country . "</td></tr>";
					$messageauto .= "<tr><td><b>Post  Code</b></td><td>" . $post_code . "</td></tr>";
					$messageauto .= "<tr><td><b>Requirement</b></td><td>" . $requirement . "</td></tr>";
					
					$messageauto .= "</table>";
					$messageauto .= "</body>";

					$headersauto = "From: " . $to . "\n";
					$headersauto .= "Content-Type: text/html\r\n";

					@mail($from, $subjectauto, $messageauto, $headersauto);
				}
			}

			$_SESSION['email_sent'] = 1;
			header("Location: contact-us.php");
			exit();
		}
        
   }
   else
	{
		$_SESSION['email_sent'] = 2;
		header("Location: contact-us.php");
		exit();
	}
?>