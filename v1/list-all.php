<?php

// ini_set("display_errors", 1); // setting our debugger
	// include headers 
	header("Access-Control-Allow-Origin: *"); // it allow all origins like localhost, or any domain or subdomain to access this api
	
	header("Access-Control-Allow-Methods: GET"); // Method type

// Include database file and student file 
include "../config/database.php";
include "../classes/student.php";

// create object for database 
$db = new Database();

$connection = $db->connect();

// create object for student
$student = new Student($connection);

if($_SERVER['REQUEST_METHOD']  === 'GET') {

	$data = $student->get_all_data();

	// print_r($data);
	if ($data->num_rows > 0) {
		$students['record'] = array();
		while ($row = $data->fetch_assoc()) {
			// print_r($row['name']);
			array_push($students['record'], array(
				"id" => $row['id'],
				"name" => $row['name'],
				"email" => $row['email'],
				"mobile" => $row['mobile'],
				"status" => $row['status'],
				"date" => date("Y-m-d",strtotime($row['created_at']))
			));
		}
		http_response_code(200);
		echo json_encode(array(
			"status" => 1,
			"data" => $students['record']
		));

		// var_dump($students['record']);
	}
} 
else 
{
	http_response_code(503);
	echo json_encode(array(
		"status" => 0,
		"message" => "Access Denied"
	));
}

?>