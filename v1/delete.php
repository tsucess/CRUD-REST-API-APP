<?php 
	// Include headers 
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Methods: GET");


	// include databse file and student file 
	include "../config/database.php";
	include "../classes/Student.php";


	// create object for database
	$db = new Database();
	$connection = $db->connect();

	// create object for student

	$student = new Student($connection);

	if ($_SERVER['REQUEST_METHOD'] === 'GET') 
	{
		$student_id = isset($_GET['id']) ? intval($_GET['id']): "";

		if (!empty($student_id))
		{
			$student->id = $student_id;
			// echo $student_id;
			if($student->delete_user()) 
			{
				http_response_code(200); // OK data deleted successfully
				echo json_encode(array(
					"status" => 1,
					"data" => "User deleted successfully"
				));
			}
			else 
			{
				http_response_code(500); // Server Error
				echo json_encode(array(
					"status" => 0,
					"message" => "Failed to delete data"
				));
			}
		}
		else 
		{
			http_response_code(404); // No Data Found
			echo json_encode(array(
				"status" => 0,
				"message" => "No user Found"
			));
		}

		
	}
	else
	{
		http_response_code(503); // Service not available
		echo json_encode(array(
			"status" => 0,
			"message" => "Access Denid"
		));
	}
?>