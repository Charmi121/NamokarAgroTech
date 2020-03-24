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
$title = (!empty($_POST['title']) ) ? $DB->cleanInput($_POST['title']) : '';
$dealer_name = (!empty($_POST['dealer_name']) ) ? $DB->cleanInput($_POST['dealer_name']) : '';
$add1 = (!empty($_POST['add1']) ) ? ($_POST['add1']) : '';
$add2 = (!empty($_POST['add2']) ) ? $_POST['add2'] : '';
$city = (!empty($_POST['city']) ) ? $_POST['city'] : '';
$state = (!empty($_POST['state']) ) ? $_POST['state'] : '';
$post_code = (!empty($_POST['post_code']) ) ? $_POST['post_code'] : '';
$country = (!empty($_POST['country']) ) ? $_POST['country'] : '';
$phone = (!empty($_POST['phone']) ) ? $_POST['phone'] : '';
$email = (!empty($_POST['email']) ) ? $DB->cleanInput($_POST['email']) : '';
$mpline = (!empty($_POST['mpline']) ) ? $_POST['mpline'] : '';
$shortline = (!empty($_POST['shortline']) ) ? $_POST['shortline'] : '';
$sold_annual = (!empty($_POST['sold_annual']) ) ? $_POST['sold_annual'] : '';
$annual_sale = (!empty($_POST['annual_sale']) ) ? $_POST['annual_sale'] : '';
$quest = (!empty($_POST['quest']) ) ? $_POST['quest'] : '';
$send_me_equiry = (!empty($_POST['send_me_equiry']) ) ? $_POST['send_me_equiry'] : 0;

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
				$message .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Partner request received from " . $email . "</td></tr>";
				$message .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
				$message .= "<tr><td><b>Title</b></td><td>" . $title . "</td></tr>";
				$message .= "<tr><td><b>DealerShip Name</b></td><td>" . $dealer_name . "</td></tr>";
				$message .= "<tr><td><b>Address1</b></td><td>" . $add1 . "</td></tr>";
				$message .= "<tr><td><b>Address2</b></td><td>" . $add2 . "</td></tr>";
				$message .= "<tr><td><b>City</b></td><td>" . $city . "</td></tr>";
				$message .= "<tr><td><b>State</b></td><td>" . $state . "</td></tr>";
				$message .= "<tr><td><b>Post  Code</b></td><td>" . $post_code . "</td></tr>";

				$message .= "<tr><td><b>Phone</b></td><td>" . $phone . "</td></tr>";
				$message .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
				$message .= "<tr><td><b>Major Product line</b></td><td>" . $mpline . "</td></tr>";
				$message .= "<tr><td><b>Shortlines</b></td><td>" . $shortline . "</td></tr>";
				$message .= "<tr><td><b>Products Sold Annually</b></td><td>" . $sold_annual . "</td></tr>";
				$message .= "<tr><td><b>Annual Dealership Sales</b></td><td>" . $annual_sale . "</td></tr>";
				$message .= "<tr><td><b>Questions or Comments</b></td><td>" . $quest . "</td></tr>";
				$message .= "</table>";
				$message .= "</body>";


				//echo $message; exit;
				$to = "info@indiaagrovision.com";

				$subject = 'Partner request received from ' . $email;
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
						$messageauto .= "<table cellpadding='5' cellspacing='0' width='600px' border='1' bordercolor='#E3E3E3' style='border-collapse:collapse; font-family: Arial; font-size:11px;'>";

						$fullname = $first_name.' '.$last_name;
						$messageauto .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Partner request received from " . $email . "</td></tr>";
						$messageauto .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
						$messageauto .= "<tr><td><b>Title</b></td><td>" . $title . "</td></tr>";
						$messageauto .= "<tr><td><b>DealerShip Name</b></td><td>" . $dealer_name . "</td></tr>";
						$messageauto .= "<tr><td><b>Address1</b></td><td>" . $add1 . "</td></tr>";
						$messageauto .= "<tr><td><b>Address2</b></td><td>" . $add2 . "</td></tr>";
						$messageauto .= "<tr><td><b>City</b></td><td>" . $city . "</td></tr>";
						$messageauto .= "<tr><td><b>State</b></td><td>" . $state . "</td></tr>";
						$messageauto .= "<tr><td><b>Post  Code</b></td><td>" . $post_code . "</td></tr>";

						$messageauto .= "<tr><td><b>Phone</b></td><td>" . $phone . "</td></tr>";
						$messageauto .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
						$messageauto .= "<tr><td><b>Major Product line</b></td><td>" . $mpline . "</td></tr>";
						$messageauto .= "<tr><td><b>Shortlines</b></td><td>" . $shortline . "</td></tr>";
						$messageauto .= "<tr><td><b>Products Sold Annually</b></td><td>" . $sold_annual . "</td></tr>";
						$messageauto .= "<tr><td><b>Annual Dealership Sales</b></td><td>" . $annual_sale . "</td></tr>";
						$messageauto .= "<tr><td><b>Questions or Comments</b></td><td>" . $quest . "</td></tr>";
						
						$messageauto .= "</table>";
						$messageauto .= "</body>";

						$headersauto = "From: " . $to . "\n";
						$headersauto .= "Content-Type: text/html\r\n";

						@mail($from, $subjectauto, $messageauto, $headersauto);
					}
				}

				$_SESSION['email_sent'] = 1;
				header("Location: partner-with-us.php");
				exit();
	}
        
   }
   else
	{
		$_SESSION['email_sent'] = 2;
		header("Location: partner-with-us.php");
		exit();
	}			
?>