<?php 

class Student {

	public $name;
	public $email;
	public $mobile;
	public $id;


	private $conn;
	private $table_name;


public function __construct($db){
	
	$this->conn = $db;
	$this->table_name = "students";
}

	public function create_user () {
			// sql query to insert data
			$query = "INSERT INTO ". $this->table_name . " SET name = ?, email =?, mobile = ?";

			// prepare statement 
			$obj = $this->conn->prepare($query);

			// sanitize input variables => basically removes extra characters like special symbols as well as some tags available in input value
			$this->name = htmlspecialchars(strip_tags($this->name));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->mobile = htmlspecialchars(strip_tags($this->mobile));

			// binding parameters with prepared statements 
			$obj->bind_param("sss", $this->name, $this->email, $this->mobile);

			if ($obj->execute()) { // executing query
				return true;
			}
				return false;
	}


	public function get_all_data () {

		$query = "SELECT * FROM ".$this->table_name;

		$std_obj = $this->conn->prepare($query);
		
		// execute query
		$std_obj->execute();

		return $std_obj->get_result();
	}

	public function get_single_data() {
		$query = "SELECT * FROM ". $this->table_name . " WHERE id = ? LIMIT 1";

		//prepared statement
		$std_obj = $this->conn->prepare($query);

		// bind parameters
		$std_obj->bind_param("i", $this->id);

		// execute query
		$std_obj->execute();

		$data = $std_obj->get_result();

		return $data->fetch_assoc();
	}

	public function update_user() {
		$query = "UPDATE ". $this->table_name . " SET name =?, email =?, mobile =? WHERE id =?";

		// prepared statement 
		$obj = $this->conn->prepare($query);

		// sanitize inputs 
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->mobile = htmlspecialchars(strip_tags($this->mobile));

		//bind parameters 
		$obj->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

		// execute query
		if ($obj->execute())
		{
			return true ;
		}
			return false;
	}


	public function delete_user()
	{
		$query = "DELETE FROM ".$this->table_name." WHERE id =? LIMIT 1";

		// prepared statement
		$obj = $this->conn->prepare($query);

		// bind parameter 
		$obj->bind_param("i", $this->id);

		// execute query 
		if ($obj->execute())
		{
			return true;
		}
			return false;
	}

}

?>