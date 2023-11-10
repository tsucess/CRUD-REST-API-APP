<?php
	// include headers 
	header("Access-Control-Allow-Origin: *"); // it allow all origins like localhost, or any domain or subdomain to access this api
	
	// passing json data or data type while calling this api
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
	

	$param = json_decode(file_get_contents("php://input"));


	if (!empty($param->id)){

		$student->id = $param->id;
		
		$data = $student->get_single_data();

		// print_r($data);
	
		if ($data) {
			$students['data'] = array();
			// while($row = $data->fetch_assoc($data)){
			
				$students['data'] = array(
					"id" => $data['id'],
					"name" => $data['name'],
					"email" => $data['email'],
					"mobile" => $data['mobile'],
					"status" => $data['status'],
					"date" => date("Y-m-d",strtotime($data['created_at']))
				);
			
	
			http_response_code(200); // OK data successful
			echo json_encode(array(
				"status" => 1,
				"data" => $students['data']
			));
		}
		else 
		{
			http_response_code(404); // data not found
			echo json_encode(array(
				"status" => 0,
				"message" => "User not found"
			));
		}
	}

}
else {
	http_response_code(503); // service unavailable
	echo json_encode(array(
		"status" => 0,
		"message" => "Access Denied"
	));

}
?>