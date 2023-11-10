<?php

class  Database {


	// Attributes or Variable declaration
	private $hostname;
	private $dbname;
	private $username;
	private $password;

	private $conn;

	public function connect() {
		// variable initialization 
		$this->hostnamde = "localhost";
		$this->dbname = "db_rest_api_app";
		$this->username = "success";
		$this->password = "Taofeeq1993@";

		$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);

		if ($this->conn->connect_errno) {
			print_r($this->conn->connect_error);
			exit;
		}
		else
		{
			return $this->conn;
			// print_r($this->conn);
		}
	}

}


$db = new Database();
$db->connect(); 

?>