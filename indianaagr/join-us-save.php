<?php ob_start(); ?>
<?php
require_once("mail.php");
require_once('main.php');
require("connect.inc.php");
require("config.php");
$DB = new DBConfig();

$pageURL = BASEURL;

$first_name = (!empty($_POST['full_name']) ) ? $DB->cleanInput($_POST['full_name']) : '';
$email = (!empty($_POST['email']) ) ? $DB->cleanInput($_POST['email']) : '';
$age = (!empty($_POST['age']) ) ? ($_POST['age']) : '';
$mobile = (!empty($_POST['contact_number']) ) ? $_POST['contact_number'] : '';
$alternate_mobile = (!empty($_POST['alternate_contact_number']) ) ? $_POST['alternate_contact_number'] : '';
$qualification = (!empty($_POST['qualification']) ) ? $_POST['qualification'] : '';
$position_apply = (!empty($_POST['position_apply']) ) ? $_POST['position_apply'] : '';
$current_organisation = (!empty($_POST['current_organisation']) ) ? $_POST['current_organisation'] : '';
$designation = (!empty($_POST['designation']) ) ? $_POST['designation'] : '';
$current_ctc = (!empty($_POST['current_ctc']) ) ? $_POST['current_ctc'] : '';
$expected_ctc = (!empty($_POST['expected_ctc']) ) ? $_POST['expected_ctc'] : '';
$experience = (!empty($_POST['experience']) ) ? $_POST['experience'] : '';
$key_skills = (!empty($_POST['key_skills']) ) ? $_POST['key_skills'] : '';
$scope_of_work = (!empty($_POST['scope_of_work']) ) ? $_POST['scope_of_work'] : '';


if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
{
	 
		$secret = SECRET_KEY;
		$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		echo $verifyResponse;
		$responseData = json_decode($verifyResponse);
		if($responseData->success)
		{  
					$tempFolder      =   "uploads/resume/";
					if (!file_exists($tempFolder)) {
						mkdir($tempFolder, 0777, true);
					}
					$targetFolder = $dirFolder."/resume/"; // Relative to the root
					if (!file_exists($targetFolder)) {
						mkdir($targetFolder, 0777, true);
					}

					$maxid = rand();

					if(floatval($_FILES['big_image']['size']) > 0)  {
						//Check uploaded file type is in the above array (therefore valid)

						$fileext         =   pathinfo($_FILES['big_image']["name"], PATHINFO_EXTENSION);
						if($fileext == 'doc' || $fileext == 'docx' || $fileext == 'pdf') {
							//$resume_file  =   $maxid."resume.".$fileext;
							//$copy = copy($_FILES['big_image']['tmp_name'], $targetFolder.$resume_file);

							 //  $params['resume'] = $resume_file; 
							
						
						} else {
							
							$_SESSION['email_sent'] =   "invalid file";
							header("Location: join-us.html");
							exit;
						}
					} else {
						$_SESSION['email_sent'] =   "empty file";
						header("Location: join-us.html");
						exit;
					}

					if(!empty($_FILES['big_image']) && floatval($_FILES['big_image']['size']) > 0)
					{
						$maxid = rand();
						   
						
						$temp_image     =  $_FILES['big_image']["name"]; 
					   
					   
						
						move_uploaded_file($_FILES['big_image']["tmp_name"], $tempFolder.$temp_image);

					}

					$message = "<body>";
					$message .= "<table cellpadding='5' cellspacing='0' width='600px' border='1' bordercolor='#E3E3E3' style='border-collapse:collapse; font-family: Arial; font-size:11px;'>";

					$fullname = $first_name;
					$message .= "<tr><td colspan='2' style='background-color:#E3E3E3; font-weight:bold'>Job application received from " . $email . "</td></tr>";
					$message .= "<tr><td width='100px'><b>Full Name</b></td><td>" . $first_name . "</td></tr>";
					$message .= "<tr><td><b>Email</b></td><td>" . $email . "</td></tr>";
					$message .= "<tr><td><b>Age	</b></td><td>" . $age . "</td></tr>";
					$message .= "<tr><td><b>Contact Number</b></td><td>" . $mobile . "</td></tr>";
					$message .= "<tr><td><b>Alternate Mobile</b></td><td>" . $alternate_mobile . "</td></tr>";
					$message .= "<tr><td><b>Highest Qualification</b></td><td>" . $qualification . "</td></tr>";
					$message .= "<tr><td><b>Position Apply For</b></td><td>" . $position_apply . "</td></tr>";
					$message .= "<tr><td><b>Current Organisation</b></td><td>" . $current_organisation . "</td></tr>";
					$message .= "<tr><td><b>Current Designation</b></td><td>" . $designation . "</td></tr>";
					$message .= "<tr><td><b>Current CTC</b></td><td>" . $current_ctc . "</td></tr>";
					$message .= "<tr><td><b>Expected CTC</b></td><td>" . $expected_ctc . "</td></tr>";
					$message .= "<tr><td><b>Experience</b></td><td>" . $experience . "</td></tr>";
					$message .= "<tr><td><b>Key Skills</b></td><td>" . $key_skills . "</td></tr>";
					$message .= "<tr><td><b>Current Broad Scope Of Work</b></td><td>" . $scope_of_work . "</td></tr>";
					$message .= "<tr><td><b>Resume</b></td><td><a href='".$pageURL."/uploads/resume/". $temp_image."'>Resume</a></td></tr>";

					$message .= "</table>";
					$message .= "</body>";

					//echo $message; exit;
					$to = "info@indiaagrovision.com";
					$subject = 'Job application received from ' . $email;
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
					header("Location:join-us.php");
					exit();

		}
        
}
else
{
	$_SESSION['email_sent'] = 2;
	header("Location:join-us.php");
	exit();
}
?>