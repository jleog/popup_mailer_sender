<?php
require './Email.php';
require './Prospect.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getVar($var) {
	if(!empty($_REQUEST[$var])) {
		return $var;
	} else {
		return '';
	}
}

$jsonOut = [
	'prospectReg' => 0,
	'emailSend' => 0
];


$name = 		getVar('pName');
$emailAddress = getVar('pEmail');
$phone = 		getVar('pPhone');

$db = mysqli_connect(
	$_ENV["DATABASE_HOST"],
	$_ENV["DATABASE_USER"],
	$_ENV["DATABASE_PASSWORD"],
	$_ENV["DATABASE_NAME"]
	);

$email = new Email(
	$_ENV["EMAIL_HOST"],
	$_ENV["EMAIL_USER"],
	$_ENV["EMAIL_PASSWORD"],
	$_ENV["EMAIL_PORT"],
);

$prospect = new Prospect($db, $name, $emailAddress, $phone);


$email->setFrom('mundocripto@foromundocripto.com', 'Mundocripto MA');
$email->setSend($emailAddress, $name);
$email->setSubject("Bienvenido");
$email->setBodyFile('./email_template.html');

//Register prospect
if($prospect->add()) {
	$jsonOut['prospectReg'] = 1;
}

//Send mail
/*if($email->send()) {
	$jsonOut['emailSend'] = 1;
}*/

die(json_encode($jsonOut));








//$email->sendMail();




//Load Composer's autoloader


//Create an instance; passing `true` enables exceptions








//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function






?>