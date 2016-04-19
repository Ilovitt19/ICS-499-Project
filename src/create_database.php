<?php

require_once('reunion_fns.php');

$db_hostname = 'SP-CFSICS.METROSTATE.EDU';
$db_username = 'ics499sp160102';
$db_password = '299436';
$db_database = 'Alligators';


$mysql_connection = new mysqli('localhost', 'root', '');

if ($mysql_connection->connect_errno) {
	printf("Failed to connect to the MySQL database server: %s<br>", $mysql_connection->connect_error);
}

$reunion = "CREATE DATABASE reunion";
if ($mysql_connection->query($reunion) === TRUE) {
	echo "Database created successfully<br>";
} else {
	echo "Error creating database: " . $mysql_connection->error . "<br>";
}
$mysql_connection->close();
$mysql_connection = db_connect();

reset_database();


$students = "CREATE TABLE students(
	user_id int(6) PRIMARY KEY,
	first_name varchar(15),
	last_name varchar(20),
	nickname varchar(20),
	grad_year int(4),
	father_name varchar(15),
	mother_name varchar(15),
	email varchar(40),
	phone varchar(10),
	family_details varchar(100),
	work_experience varchar(200),
	awards varchar(200),
	street varchar(50),
	city varchar(20),
	state varchar(2),
	zip int(5),
	notes varchar(50),
	photo varchar (30),
	donations FLOAT(10,2) NOT NULL DEFAULT '0.00',
	attending varchar(4) DEFAULT 'no')";

if ($mysql_connection->query($students) === TRUE) {
	echo "Students table created successfully <br>";
} else {
	echo "Table not created: " . $mysql_connection->error . "<br>";
}

$teachers = "CREATE TABLE teachers(
 	user_id int(6) PRIMARY KEY,
	first_name varchar(15),
	last_name varchar(20),
	nickname varchar(20),
	start_year int(4),
	end_year int(4),
	father_name varchar(15),
	mother_name varchar(15),
	email varchar(40),
	phone varchar(10),
	family_details varchar(100),
	work_experience varchar(200),
	awards varchar(200),
	street varchar(50),
	city varchar(20),
	state varchar(2),
	zip int(5),
	notes varchar(50),
	photo varchar(30),
	donations FLOAT(10,2) NOT NULL DEFAULT '0.00',
	attending varchar(4) DEFAULT 'no')";


if ($mysql_connection->query($teachers) === TRUE) {
	echo "Teachers table created successfully <br>";
} else {
	echo "Table not created: " . $mysql_connection->error . "<br>";
}

$user = "CREATE TABLE user(
	username varchar(15),
	password varchar(40),
	admin varchar(3),
	user_type varchar(7),
	user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY)";

if ($mysql_connection->query($user) === TRUE) {
	echo "User table created successfully <br>";
} else {
	echo "Table not created: " . $mysql_connection->error . "<br>";
}
/*
if (create_user($mysql_connection, 'admin', 'admin', 'yes', 'student')) {
	echo "New record \"admin\" created successfully" . "<br>";
} else {
	echo "Error: " . $mysql_connection->error . "<br>";
}

if (create_user($mysql_connection, 'student', 'student', 'no', 'student')) {
	echo "New record \"student\" created successfully" . "<br>";
} else {
	echo "Error: " . $mysql_connection->error . "<br>";
}

if (create_user($mysql_connection, 'teacher', 'teacher', 'no', 'teacher')) {
	echo "New record \"teacher\" created successfully" . "<br>";
} else {
	echo "Error: " . $mysql_connection->error . "<br>";
}
*/
load_user_data();
load_students_data();
load_teachers_data();

echo "<br>";
    echo "<a href='admin_page.php'>Return to Admin</a>";

$mysql_connection->close();

function reset_database(){
	$mysql_connection = db_connect();
	$drop_table = "DELETE FROM students";

	if ($mysql_connection->query($drop_table) === TRUE) {
		echo "Students table cleared <br>";
	} else {
		echo "Table not cleared: " . $mysql_connection->error . "<br>";
	}
	$drop_table = "DELETE FROM teachers";

	if ($mysql_connection->query($drop_table) === TRUE) {
		echo "Teachers table cleared <br>";
	} else {
		echo "Table not cleared: " . $mysql_connection->error . "<br>";
	}
	$drop_table = "DELETE FROM user";

	if ($mysql_connection->query($drop_table) === TRUE) {
		echo "User table cleared <br>";
	} else {
		echo "Table not cleared: " . $mysql_connection->error . "<br>";
	}
	$drop_table = "DROP TABLE students";

	if ($mysql_connection->query($drop_table) === TRUE) {
		echo "Students dropped <br>";
	} else {
		echo "Table not dropped: " . $mysql_connection->error . "<br>";
	}
	$drop_table = "DROP TABLE teachers";

	if ($mysql_connection->query($drop_table) === TRUE) {
		echo "Teachers dropped <br>";
	} else {
		echo "Table not dropped: " . $mysql_connection->error . "<br>";
	}
	$drop_table = "DROP TABLE user";

	if ($mysql_connection->query($drop_table) === TRUE) {
		echo "User dropped <br>";
	} else {
		echo "Table not dropped: " . $mysql_connection->error . "<br>";
	}
}

function load_students_data() {
	$conn = db_connect();
	$sqlDump = file_get_contents('sql_files/students.sql');
	if (mysqli_multi_query($conn,$sqlDump) === TRUE) {
		echo "Student data entered successfully <br>";
	} else {
		echo "Student data not entered: " . $conn->error . "<br>";
	}
}
function load_teachers_data() {
	$conn = db_connect();
	$sqlDump = file_get_contents('sql_files/teachers.sql');
	if (mysqli_multi_query($conn,$sqlDump) === TRUE) {
		echo "Teacher data entered successfully <br>";
	} else {
		echo "Teacher data not entered: " . $conn->error . "<br>";
	}
}
function load_user_data() {
	$conn = db_connect();
	$sqlDump = file_get_contents('sql_files/user.sql');

	if (mysqli_multi_query($conn,$sqlDump) === TRUE) {
		echo "User data entered successfully <br>";
	} else {
		echo "User data not entered: " . $conn->error . "<br>";
	}
}