<?php
/**
 * Created by PhpStorm.
 * User: Teufel Hunden
 * Date: 3/15/2016
 * Time: 6:39 PM
 */
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

$students = "CREATE TABLE students(first_name varchar(15), last_name varchar(20),
nickname varchar(20), grad_year int(4), father_name varchar(15), mother_name varchar(15),
email varchar(40), phone varchar(10) primary key, family_details varchar(100), work_experience varchar(200),
awards varchar(100), street varchar(50), city varchar(20), state varchar(2), zip int(5), notes varchar(50))";


if ($mysql_connection->query($students) === TRUE) {
	echo "Students table created successfully \n";
} else {
	echo "Table not created: " . $mysql_connection->error . "\n";
}


$teachers = "CREATE TABLE teachers(first_name varchar(15), last_name varchar(20),
nickname varchar(20), start_year int(4), end_year int(4), father_name varchar(15), mother_name varchar(15),
email varchar(40), phone varchar(10) primary key, family_details varchar(100), work_experience varchar(200),
awards varchar(100), street varchar(50), city varchar(20), state varchar(2), zip int(5), notes varchar(50))";


if ($mysql_connection->query($teachers) === TRUE) {
	echo "Teachers table created successfully \n";
} else {
	echo "Table not created: " . $mysql_connection->error;
}

$mysql_connection->close();