<?php
	// include headers 
	header("Access-Control-Allow-Origin: *"); // it allow all origins like localhost, or any domain or subdomain to access this api
	header("Content-type: application/json; charset=UTF-8"); // data which we are getting inside request
	header("Access-Control-Allow-Methods: POST"); // Method type

// Include database file and student file 
include "../config/database.php";
include "../classes/student.php";

// create object for database 
$db = new Database();

$connection = $db->connect();

// create object for student
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD']  === 'POST') {

	$data = json_decode(file_get_contents("php://input"));

	if (!empty($data->name) && !empty($data->email) && !empty($data->mobile) && !empty($data->id)) 
	{
		$student->name = $data->name;
		$student->email = $data->email;
		$student->mobile = $data->mobile;
		$student->id = $data->id;

		if ($student->update_user())
		{
			http_response_code(200); // OK
			echo json_encode(array(
				"status" => 1,
				"message" => "Data successfully Updated"
			));
		}
		else
		{
			http_response_code(500); // Server Error
			echo json_encode(array(
				"status" => 0,
				"message" => "Failed to update data"
			));
		}
	}
	else
	{
		http_response_code(404); // Data not found
		echo json_encode(array(
			"status" => 0,
			"message" => "All data needed"
		));
	}
	
}
else 
{
	http_response_code(503); // service unavailable
	echo json_encode(array(
		"status" => 0,
		"message" => "Access Denied"
	));
}

?>