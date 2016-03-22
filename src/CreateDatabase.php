<?php

$db_hostname = '127.0.0.1';
$db_username = 'root';
$db_password = '';
$db_database = 'reunion';

$mysql_connection = new mysqli($db_hostname, $db_username, $db_password);

if ($mysql_connection->connect_errno) {
	printf("Failed to connect to the MySQL database server: %s\n", $mysql_connection->connect_error);
}

$reunion = "CREATE DATABASE reunion";
if ($mysql_connection->query($reunion) === TRUE) {
	echo "Database created successfully\n";
} else {
	echo "Error creating database: " . $mysql_connection->error . "\n";
}

$mysql_connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);

$students = "CREATE TABLE students(
	user_id int(6) PRIMARY KEY,
	first_name varchar(15) NOT NULL,
	last_name varchar(20) NOT NULL,
	nickname varchar(20),
	grad_year int(4) NOT NULL,
	father_name varchar(15),
	mother_name varchar(15),
	email varchar(40) NOT NULL,
	phone varchar(10),
	family_details varchar(100),
	work_experience varchar(200),
	awards varchar(200),
	street varchar(50),
	city varchar(20),
	state varchar(2),
	zip int(5),
	notes varchar(50),
	photo varchar (30))";

//

if ($mysql_connection->query($students) === TRUE) {
	echo "Students table created successfully \n";
} else {
	echo "Table not created: " . $mysql_connection->error . "\n";
}


$teachers = "CREATE TABLE teachers(
 	user_id int(6) PRIMARY KEY,
	first_name varchar(15) NOT NULL,
	last_name varchar(20) NOT NULL,
	nickname varchar(20),
	start_year int(4) NOT NULL,
	end_year int(4) NOT NULL,
	father_name varchar(15),
	mother_name varchar(15),
	email varchar(40) NOT NULL,
	phone varchar(10),
	family_details varchar(100),
	work_experience varchar(200),
	awards varchar(200),
	street varchar(50),
	city varchar(20),
	state varchar(2),
	zip int(5),
	notes varchar(50),
	photo varchar(30))";


if ($mysql_connection->query($teachers) === TRUE) {
	echo "Teachers table created successfully \n";
} else {
	echo "Table not created: " . $mysql_connection->error . "\n";
}

$user = "CREATE TABLE user(
	username varchar(15),
	password varchar(40),
	admin varchar(3),
	user_type varchar(7),
	user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY)";

if ($mysql_connection->query($user) === TRUE) {
	echo "User table created successfully \n";
} else {
	echo "Table not created: " . $mysql_connection->error . "\n";
}
$admin_passwd = sha1("admin");

$admin = "INSERT INTO user(username, password, admin, user_type)
	VALUES ('admin', '$admin_passwd', 'yes', 'student')";

if ($mysql_connection->query($admin) === TRUE) {
	echo "New record created successfully" . "\n";
} else {
	echo "Error: " . $mysql_connection . "<br>" . $conn->error . "\n";
}
$student_passwd = sha1("student");

$student_user = "INSERT INTO user(username, password, admin, user_type)
	VALUES ('student', '$student_passwd', 'no', 'student')";

if ($mysql_connection->query($student_user) === TRUE) {
	echo "New record created successfully" . "\n";
} else {
	echo "Error: " . $mysql_connection . "<br>" . $conn->error . "\n";
}

$teacher_passwd = sha1("teacher");

$teacher_user = "INSERT INTO user(username, password, admin, user_type)
	VALUES ('teacher', '$teacher_passwd', 'no', 'teacher')";

	if ($mysql_connection->query($teacher_user) === TRUE) {
		echo "New record created successfully" . "\n";
	} else {
		echo "Error: " . $mysql_connection . "<br>" . $conn->error . "\n";
	}

$mysql_connection->close();