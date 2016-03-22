<?php
require_once ('output_fns.ph');

$select = $_GET["select"];
$first_name = $_GET["first_name"];
$last_name = $_GET["last_name"];
$nickname = $_GET["nickname"];
$grad_year = $_GET["grad_year"];
$start_year = $_GET["start_year"];
$end_year = $_GET["end_year"];
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


if ($select==="student") {
	$sql = "INSERT INTO students(first_name, last_name, nickname, grad_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes) VALUES
	('$first_name', '$last_name', '$nickname' ,'$grad_year' ,'$father_name' ,'$mother_name', '$email', '$phone', '$family_details',
		'$work_experience', '$awards', '$street', '$city', '$state', '$zip', '$notes')";
}
else {
	$sql = "INSERT INTO teachers(first_name, last_name, nickname, start_year, end_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes) VALUES
	('$first_name', '$last_name', '$nickname' , '$start_year', '$end_year','$father_name' ,'$mother_name', '$email',
	'$phone', '$family_details','$work_experience', '$awards', '$street', '$city', '$state', '$zip', '$notes')";
}

if ($conn->query($sql) === TRUE) {
	echo "New record created successfully";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();