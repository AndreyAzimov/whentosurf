<?php
header("Access-Control-Allow-Origin: *");

$to = 'azimov.andrey@gmail.com';


$from = @trim(stripslashes($_POST['email'])); 
if (isset($_POST['name'])) {
	$name = @trim(stripslashes($_POST['name'])); 
} else {
	$name = $from;
}
$subject = "When to surf feedback "; 
$message = @trim(stripslashes($_POST['message'])); 
$header="from: $from\r\n";

$sent = mail($to,$subject,$message,$header);

/*
		require("sendgrid-php/sendgrid-php.php");
		$sendgrid = new SendGrid('#########################################');
		$email = new SendGrid\Email();
		$email
			->addTo($to)
			->setFrom($from)
			->setFromName($name)
			->setSubject($subject)
			->setText($message)
		;
		$sendgrid->send($email);
*/

echo 1;
?>