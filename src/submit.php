<?php
require_once ('reunion_fns.php');

$select = get_user_type();
$user_id = get_user_id();
$first_name = $_GET["first_name"];
$last_name = $_GET["last_name"];
$nickname = $_GET["nickname"];
$father_name = $_GET["father_name"];
$mother_name = $_GET["mother_name"];
$email = $_GET["email"];
$phone = $_GET["phone"];
$family_details = $_GET["family_details"];
$work_experience = $_GET["work_experience"];
$awards = $_GET["awards"];
$street = $_GET["street"];
$city = $_GET["city"];
$state = $_GET["state"];
$zip = $_GET["zip"];
$notes = $_GET["notes"];

$conn = db_connect();

//need to add a check if data exists for this user
//if user has an entry in db already do update else do insert

if ($select == "student") {
	$query = "SELECT * FROM students WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $query);

	$grad_year = $_GET["grad_year"];
	if (mysqli_num_rows($result)== 0) {
		$sql = "INSERT INTO students(user_id, first_name, last_name, nickname, grad_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes) VALUES
	('$user_id', '$first_name', '$last_name', '$nickname' ,'$grad_year' ,'$father_name' ,'$mother_name', '$email', '$phone', '$family_details',
		'$work_experience', '$awards', '$street', '$city', '$state', '$zip', '$notes')";
		if ($conn->query($sql) === TRUE) {
			echo "New " . $select . " record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} elseif (mysqli_num_rows($result)== 1) {
		$sql = "UPDATE students SET first_name = '$first_name', last_name = '$last_name', nickname = '$nickname',
 	grad_year = '$grad_year', father_name = '$father_name', mother_name = '$mother_name', email = '$email',
 	 phone = '$phone', family_details = '$family_details', work_experience ='$work_experience', awards ='$awards',
 	  street ='$street', city ='$city', state ='$state', zip ='$zip', notes ='$notes' WHERE user_id = '$user_id'";
		if ($conn->query($sql) === TRUE) {
			echo "Your record has been updated successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
} else {
	$query = "SELECT * FROM teachers WHERE user_id = '$user_id'";
	$result = mysqli_query($conn, $query);

	$start_year = $_GET["start_year"];
	$end_year = $_GET["end_year"];
	if (mysqli_num_rows($result) == 0) {
		$sql = "INSERT INTO teachers(user_id, first_name, last_name, nickname, start_year, end_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes) VALUES
	('$user_id', '$first_name', '$last_name', '$nickname' , '$start_year', '$end_year','$father_name' ,'$mother_name', '$email',
	'$phone', '$family_details','$work_experience', '$awards', '$street', '$city', '$state', '$zip', '$notes')";
		if ($conn->query($sql) === TRUE) {
			echo "New " . $select . " record created successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}	elseif(mysqli_num_rows($result) == 1){
		$sql = "UPDATE teachers SET first_name = '$first_name', last_name = '$last_name', nickname = '$nickname',
 	start_year = '$start_year', end_year = '$end_year', father_name = '$father_name', mother_name = '$mother_name', email = '$email',
 	 phone = '$phone', family_details = '$family_details', work_experience ='$work_experience', awards ='$awards',
 	  street ='$street', city ='$city', state ='$state', zip ='$zip', notes ='$notes' WHERE user_id = '$user_id'";
		if ($conn->query($sql) === TRUE) {
			echo "Your record has been updated successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

$conn->close();

//Change this file to edit_info... create new UserInfo file to display info only
//header('Location: UserInfo.php');

