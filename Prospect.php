<?php 

class Prospect {
	private $name;
	private $email;
	private $phone;
	private $db;
	private $table;

	function __construct($db, $name, $email, $phone = '', $table = 'prospect') {		
		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
		$this->db = $db;

		$this->table = $table;
	}
	public function getTime() {
		return date('m-d-Y h:i:s a', time());
	}

	private function getIpClient() {
		    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		      return $_SERVER['HTTP_CLIENT_IP'];
		    }

		    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		      return $_SERVER['HTTP_X_FORWARDED_FOR'];
		    }
		    else {
		     return $_SERVER['REMOTE_ADDR'];
		    }
		}

	public function checkErrorAndReturn($var) {
		if($var) {
			return 1;
		} else {
			return 0;
		}
	}

	public function add()
	{	
		$values = "'".$this->name."', '".$this->email."', '".$this->phone."', '".$this->getTime()."', '".$this->getTime()."', '".$this->getIpClient()."'";
		$result = $this->db->query("INSERT INTO ".$this->table." (`id`, `name`, `email`, `phone`, `created_at`, `update_at`, `ip`) VALUES (NULL, ".$values.")");
		
		return $this->checkErrorAndReturn($result);

		
	}

}

 ?>