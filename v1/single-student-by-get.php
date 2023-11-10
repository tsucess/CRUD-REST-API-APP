<?php
	// include headers 
	header("Access-Control-Allow-Origin: *"); // it allow all origins like localhost, or any domain or subdomain to access this api
	
	header("Access-Control-Allow-Methods: GET"); // Method type

// Include database file and student file 
include "../config/database.php";
include "../classes/Student.php";

// create object for database 
$db = new Database();

$connection = $db->connect();


// create object for student
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD']  === 'GET') {
	

	$student_id = isset($_GET['id']) ? intval($_GET['id']) : "";


	if (!empty($student_id)){ 

		$student->id = $student_id;
		
		$data = $student->get_single_data();

		// print_r($data);
	
		if (!empty($data)) {

			$students['data'] = array();
				$students['data'] = array(
					"id" => $data['id'],
					"name" => $data['name'],
					"email" => $data['email'],
					"mobile" => $data['mobile'],
					"status" => $data['status'],
					"date" => date("Y-m-d",strtotime($data['created_at']))
				);
			
	
			http_response_code(200); // OK data fetch successful
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