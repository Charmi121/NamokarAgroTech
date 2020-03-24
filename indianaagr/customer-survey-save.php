<?php ob_start(); ?>
<?php
require_once("mail.php");
require_once('main.php');
require("connect.inc.php");
require("config.php");
$DB = new DBConfig();
$DB->config();

function foropt($val)
{
	if(!empty($val))
	{
		$val2='';
		foreach($val as $row)
		{
		  $val2.=$row.','; 
		}
		$val3=substr($val2,0,strlen($val2)-1);
		return $val3;
	}
	else
	{
      return '';
	}
}



$first_name = (!empty($_POST['first_name']) ) ? $DB->cleanInput($_POST['first_name']) : '';
$last_name = (!empty($_POST['last_name']) ) ? $DB->cleanInput($_POST['last_name']) : '';
$email = (!empty($_POST['email']) ) ? $DB->cleanInput($_POST['email']) : '';
$phone = (!empty($_POST['phone']) ) ? $_POST['phone'] : '';
$add1 = (!empty($_POST['add1']) ) ? ($_POST['add1']) : '';
$add2 = (!empty($_POST['add2']) ) ? $_POST['add2'] : '';
$city = (!empty($_POST['city']) ) ? $_POST['city'] : '';
$state = (!empty($_POST['state']) ) ? $_POST['state'] : '';
$post_code = (!empty($_POST['post_code']) ) ? $_POST['post_code'] : '';
$country = (!empty($_POST['country']) ) ? $_POST['country'] : '';
$prod_name = (!empty($_POST['prod_name']) ) ? $DB->cleanInput($_POST['prod_name']) : '';
$serial_no = (!empty($_POST['serial_no']) ) ? $DB->cleanInput($_POST['serial_no']) : '';
$date_purchase = (!empty($_POST['date_purchase']) ) ? $_POST['date_purchase'] : '';

$abrand_opt = (!empty($_POST['abrand_opt']) ) ? $_POST['abrand_opt'] : '';
$abrandopt=foropt($abrand_opt);

$dbrandopt = (!empty($_POST['dbrand_opt']) ) ? $_POST['dbrand_opt'] : '';
//$dbrandopt=foropt($dbrand_opt);

$prodopt = (!empty($_POST['prod_opt']) ) ? $_POST['prod_opt'] : '';
//$prodopt=foropt($prod_opt);

$prodopt1= (!empty($_POST['prod_opt1']) ) ? $_POST['prod_opt1'] : '';
//$prodopt1=foropt($prod_opt1);

$purchaseopt= (!empty($_POST['purchase_opt']) ) ? $_POST['purchase_opt'] : '';
//$purchaseopt=foropt($purchase_opt);

$purchaseopt1= (!empty($_POST['purchase_opt1']) ) ? $_POST['purchase_opt1'] : '';
//$purchaseopt1=foropt($purchase_opt1);

$operatopt= (!empty($_POST['operat_opt']) ) ? $_POST['operat_opt'] : '';
//$operatopt=foropt($operat_opt);

$shapeopt= (!empty($_POST['shape_opt']) ) ? $_POST['shape_opt'] : '';
//$shapeopt=foropt($shape_opt);

$comments= (!empty($_POST['comments']) ) ? $_POST['comments'] : '';
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
		$message .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Customer survey received from " . $email . "</td></tr>";
		$message .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
		$message .= "<tr><td><b>Phone</b></td><td>" . $phone . "</td></tr>";
		$message .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
		$message .= "<tr><td><b>Address1</b></td><td>" . $add1 . "</td></tr>";
		$message .= "<tr><td><b>Address2</b></td><td>" . $add2 . "</td></tr>";
		$message .= "<tr><td><b>City</b></td><td>" . $city . "</td></tr>";
		$message .= "<tr><td><b>State</b></td><td>" . $state . "</td></tr>";
		$message .= "<tr><td><b>Post  Code</b></td><td>" . $post_code . "</td></tr>";
		$message .= "<tr><td><b>Country</b></td><td>" . $country . "</td></tr>";
		$message .= "<tr><td><b>Product Name</b></td><td>" . $prod_name . "</td></tr>";
		$message .= "<tr><td><b>Serial No</b></td><td>" . $serial_no . "</td></tr>";
		$message .= "<tr><td><b>Date Purchase</b></td><td>" . $date_purchase . "</td></tr>";
		$message .= "<tr><td><b>How did you learn about the Agrovision brand for the product you purchased?</b></td><td>" . $abrandopt . "</td></tr>";
		$message .= "<tr><td><b>Did your dealer give you other brand options to choose from?</b></td><td>" . $dbrandopt . "</td></tr>";
		$message .= "<tr><td><b>How do you rate the fit and finish of Agrovision product as you took delivery</b></td><td>" .$prodopt. "</td></tr>";
		$message .= "<tr><td><b>If you have used Agrovision implement, are you pleased?</b></td><td>" . $prodopt1 . "</td></tr>";
		$message .= "<tr><td><b>Have you purchased Agrovision implements before?</b></td><td>" .$purchaseopt. "</td></tr>";
		$message .= "<tr><td><b>If you have used Agrovision implement, are you pleased?</b></td><td>" . $purchaseopt1 . "</td></tr>";
		$message .= "<tr><td><b>Did you find the Operator’s Manual helpful?</b></td><td>" . $operatopt . "</td></tr>";
		$message .= "<tr><td><b>Was the Operator’s Manual in good shape upon delivery to you?</b></td><td>" . $shapeopt . "</td></tr>";
		$message .= "<tr><td><b>Comments</b></td><td>" . $comments . "</td></tr>";
		$message .= "</table>";
		$message .= "</body>";


		//echo $message; exit;

		$to = "info@indiaagrovision.com";

		$subject = 'Customer survey received from ' . $email;
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
				$messageauto .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Customer survey received from " . $email . "</td></tr>";
				$messageauto .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $fullname . "</td></tr>";
				$messageauto .= "<tr><td><b>Phone</b></td><td>" . $phone . "</td></tr>";
				$messageauto .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
				$messageauto .= "<tr><td><b>Address1</b></td><td>" . $add1 . "</td></tr>";
				$messageauto .= "<tr><td><b>Address2</b></td><td>" . $add2 . "</td></tr>";
				$messageauto .= "<tr><td><b>City</b></td><td>" . $city . "</td></tr>";
				$messageauto .= "<tr><td><b>State</b></td><td>" . $state . "</td></tr>";
				$messageauto .= "<tr><td><b>Post  Code</b></td><td>" . $post_code . "</td></tr>";
				$messageauto .= "<tr><td><b>Country</b></td><td>" . $country . "</td></tr>";
				$messageauto .= "<tr><td><b>Product Name</b></td><td>" . $prod_name . "</td></tr>";
				$messageauto .= "<tr><td><b>Serial No</b></td><td>" . $serial_no . "</td></tr>";
				$messageauto .= "<tr><td><b>Date Purchase</b></td><td>" . $date_purchase . "</td></tr>";
				$messageauto .= "<tr><td><b>How did you learn about the Agrovision brand for the product you purchased?</b></td><td>" . $abrandopt . "</td></tr>";
				$messageauto .= "<tr><td><b>Did your dealer give you other brand options to choose from?</b></td><td>" . $dbrandopt . "</td></tr>";
				$messageauto .= "<tr><td><b>How do you rate the fit and finish of Agrovision product as you took delivery</b></td><td>" .$prodopt. "</td></tr>";
				$messageauto .= "<tr><td><b>If you have used Agrovision implement, are you pleased?</b></td><td>" . $prodopt1 . "</td></tr>";
				$messageauto .= "<tr><td><b>Have you purchased Agrovision implements before?</b></td><td>" .$purchaseopt. "</td></tr>";
				$messageauto .= "<tr><td><b>If you have used Agrovision implement, are you pleased?</b></td><td>" . $purchaseopt1 . "</td></tr>";
				$messageauto .= "<tr><td><b>Did you find the Operator’s Manual helpful?</b></td><td>" . $operatopt . "</td></tr>";
				$messageauto .= "<tr><td><b>Was the Operator’s Manual in good shape upon delivery to you?</b></td><td>" . $shapeopt . "</td></tr>";
				$messageauto .= "<tr><td><b>Comments</b></td><td>" . $comments . "</td></tr>";

				$messageauto .= "</table>";
				$messageauto .= "</body>";

				$headersauto = "From: " . $to . "\n";
				$headersauto .= "Content-Type: text/html\r\n";

				@mail($from, $subjectauto, $messageauto, $headersauto);
			}
		}

		$_SESSION['email_sent'] = 1;
		header("Location: customer-survey.php");
		exit();
	}
        
   }
   else
	{
		$_SESSION['email_sent'] = 2;
		header("Location:customer-survey.php");
		exit();
	}	
?>