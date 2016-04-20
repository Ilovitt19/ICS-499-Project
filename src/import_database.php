<?php

require_once 'db_fns.php';
/****** Include the EXCEL Reader Factory ***********/
error_reporting(0);
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'Classes/PHPExcel/IOFactory.php';
$conn = db_connect();
if(isset($_POST) && !empty($_FILES['excelupload']['name']))
{
//print_r($_FILES['excelupload']);
	$namearr = explode(".",$_FILES['excelupload']['name']);
	if(end($namearr) != 'xls' && end($namearr) != 'xlsx')
	{
		echo '<p> Invalid File </p>';
		$invalid = 1;
	}
	if($invalid != 1)
	{
		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["excelupload"]["name"]);
		$response = move_uploaded_file($_FILES['excelupload']['tmp_name'],$target_file); // Upload the file to the current folder
		if($response)
		{
			reset_tables();
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($target_file);
			} catch(Exception $e) {
				die('Error : Unable to load the file : "'.pathinfo($_FILES['excelupload']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			//choose sheet - user
			$allDataInSheet = $objPHPExcel->setActiveSheetIndex(0)->toArray(null,true,true,true);
//print_r($allDataInSheet);
			$arrayCount = count($allDataInSheet); // Total Number of rows in the uploaded EXCEL file
//echo $arrayCount;

			for($i=2;$i<=$arrayCount;$i++){
				$string = "INSERT INTO user (username, password, admin, user_type, user_id) VALUES ";

				$username = trim($allDataInSheet[$i]["A"]);
				$password = trim($allDataInSheet[$i]["B"]);
				$admin = trim($allDataInSheet[$i]["C"]);
				$user_type = trim($allDataInSheet[$i]["D"]);
				$user_id = trim($allDataInSheet[$i]["E"]);


				$string .= "('".$username."' , '".$password ."','".$admin ."', '".$user_type ."', '".$user_id ."'),";
				$string = substr($string,0,-1);
				$conn->query($string);
			}
//echo $string;


			//next sheet - students
			$allDataInSheet = $objPHPExcel->setActiveSheetIndex(1)->toArray(null,true,true,true);
//print_r($allDataInSheet);
			$arrayCount = count($allDataInSheet); // Total Number of rows in the uploaded EXCEL file
//echo $arrayCount;

			for($i=2;$i<=$arrayCount;$i++){
				$string = "INSERT INTO students (user_id, first_name, last_name, nickname, grad_year, father_name,
 				mother_name, email, phone, family_details, work_experience, awards, street, city, state, zip,
 				notes, photo, donations, attending) VALUES ";


				$user_id = trim($allDataInSheet[$i]["A"]);
				$first_name = trim($allDataInSheet[$i]["B"]);
				$last_name = trim($allDataInSheet[$i]["C"]);
				$nickname = trim($allDataInSheet[$i]["D"]);
				$grad_year = trim($allDataInSheet[$i]["E"]);
				$father_name = trim($allDataInSheet[$i]["F"]);
				$mother_name = trim($allDataInSheet[$i]["G"]);
				$email = trim($allDataInSheet[$i]["H"]);
				$phone = trim($allDataInSheet[$i]["I"]);
				$family_details = trim($allDataInSheet[$i]["J"]);
				$work_experience = trim($allDataInSheet[$i]["K"]);
				$awards = trim($allDataInSheet[$i]["L"]);
				$street = trim($allDataInSheet[$i]["M"]);
				$city = trim($allDataInSheet[$i]["N"]);
				$state = trim($allDataInSheet[$i]["O"]);
				$zip = trim($allDataInSheet[$i]["P"]);
				$notes = trim($allDataInSheet[$i]["Q"]);
				$photos = trim($allDataInSheet[$i]["R"]);
				$donations = trim($allDataInSheet[$i]["S"]);
				$attending = trim($allDataInSheet[$i]["T"]);

				$string .= "('".$user_id."' , '".$first_name ."','".$last_name ."', '".$nickname ."', '".$grad_year ."',
				'".$father_name ."', '".$mother_name ."', '".$email ."', '".$phone ."', '".$family_details ."',
				'".$work_experience ."', '".$awards ."', '".$street ."', '".$city ."', '".$state  ."', '".$zip ."',
				'".$notes ."', '".$photos ."', '".$donations ."', '".$attending ."'),";
				$string = substr($string,0,-1);
				 // Insert all the data into one query
				$conn->query($string);
			}
//echo $string;



			//next sheet - teachers
			$allDataInSheet = $objPHPExcel->setActiveSheetIndex(2)->toArray(null,true,true,true);
//print_r($allDataInSheet);
			$arrayCount = count($allDataInSheet); // Total Number of rows in the uploaded EXCEL file
//echo $arrayCount;

			for($i=2;$i<=$arrayCount;$i++){
				$string = "INSERT INTO teachers (user_id, first_name, last_name, nickname, start_year, end_year,
 				father_name, mother_name, email, phone, family_details, work_experience, awards, street,
 				city, state, zip, notes, photo, donations, attending) VALUES ";

				$user_id = trim($allDataInSheet[$i]["A"]);
				$first_name = trim($allDataInSheet[$i]["B"]);
				$last_name = trim($allDataInSheet[$i]["C"]);
				$nickname = trim($allDataInSheet[$i]["D"]);
				$start_year = trim($allDataInSheet[$i]["E"]);
				$end_year = trim($allDataInSheet[$i]["F"]);
				$father_name = trim($allDataInSheet[$i]["G"]);
				$mother_name = trim($allDataInSheet[$i]["H"]);
				$email = trim($allDataInSheet[$i]["I"]);
				$phone = trim($allDataInSheet[$i]["J"]);
				$family_details = trim($allDataInSheet[$i]["K"]);
				$work_experience = trim($allDataInSheet[$i]["L"]);
				$awards = trim($allDataInSheet[$i]["M"]);
				$street = trim($allDataInSheet[$i]["N"]);
				$city = trim($allDataInSheet[$i]["O"]);
				$state = trim($allDataInSheet[$i]["P"]);
				$zip = trim($allDataInSheet[$i]["Q"]);
				$notes = trim($allDataInSheet[$i]["R"]);
				$photos = trim($allDataInSheet[$i]["S"]);
				$donations = trim($allDataInSheet[$i]["T"]);
				$attending = trim($allDataInSheet[$i]["U"]);

				$string .= "('".$user_id."' , '".$first_name ."', '".$last_name ."', '".$nickname ."', '".$start_year ."',
				'".$end_year ."', '".$father_name ."', '".$mother_name ."', '".$email ."', '".$phone ."', '".$family_details ."',
				  '".$work_experience ."', '".$awards ."', '".$street ."', '".$city ."', '".$state  ."', '".$zip ."',
				   '".$notes ."', '".$photos ."', '".$donations ."', '".$attending ."'),";
				$string = substr($string,0,-1);
				$conn->query($string);
			}


//echo $string;


		}
	}// End Invalid Condition
	echo "<div style='color:#3C7C64'>Import Successful</div>";
}

function reset_tables(){
	$mysql_connection = db_connect();
	$drop_table = "DELETE FROM students";

	if ($mysql_connection->query($drop_table) === FALSE) {
		echo "Students table not cleared: " . $mysql_connection->error . "<br>";
		exit;
	}
	$drop_table = "DELETE FROM teachers";

	if ($mysql_connection->query($drop_table) === FALSE) {
		echo "Teachers table not cleared: " . $mysql_connection->error . "<br>";
		exit;
	}
	$drop_table = "DELETE FROM user";

	if ($mysql_connection->query($drop_table) === FALSE) {
		echo "User table not cleared: " . $mysql_connection->error . "<br>";
		exit;
	}
}


?>
