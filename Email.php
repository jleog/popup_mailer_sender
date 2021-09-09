<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class Email {
	private $mail;
	private $debug;

	private $host;
	private $username;
	private $password;
	private $port;

	private $addressFrom;
	private $nameFrom;
	private $addressSend;
	private $nameSend;

	private $subject;
	private $body;
	private $isBodyFile;

	function __construct($host, $username, $password, $port, $addressFrom = '', $addressSend = '', $debug = 0) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->port = $port;
		$this->addressFrom = $addressFrom;
		$this->addressSend = $addressSend;
		$this->debug = $debug;
		$this->isBodyFile = false;

		$this->mail = new PHPmailer(true);
	}

	public function setFrom($address, $name) {
		$this->addressFrom = $address;
		$this->nameFrom = $name;
	}

	public function setSend($address, $name) {
		$this->addressSend = $address;
		$this->nameSend = $name;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function setBody($body) {
		$this->body = $body;
	}

	public function setBodyFile($path) {
		$this->setBody(file_get_contents($path)); 
	}


	public function send() {
		try {
		    $this->mail->SMTPDebug = $this->debug;                      //Enable verbose debug output
		    $this->mail->isSMTP();                                            //Send using SMTP
		    $this->mail->Host       = $this->host;                     //Set the SMTP server to send through
		    $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		    $this->mail->Username   = $this->username;                     //SMTP username
		    $this->mail->Password   = $this->password;                               //SMTP password
		    $this->mail->SMTPSecure = PHPmailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		    $this->mail->Port       = $this->port;                                    //TCP port to connect to; use 587 if you 

		    //Recipients
		    $this->mail->setFrom($this->addressFrom, $this->nameFrom);
		    $this->mail->addAddress($this->addressSend, $this->nameSend);     //Add a recipient

		    //Content
		    $this->mail->isHTML(true);                                  //Set ethis->mail format to HTML
		    $this->mail->Subject = $this->subject;
		    $this->mail->Body    = $this->body;

		    $this->mail->send();
		    return 1;
		} catch (Exception $e) {
		    return 0;
		}

	}


}




?>