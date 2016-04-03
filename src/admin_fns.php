<?php

/**
 * This file contains functions and code for:
 *  - Generating reports
 */

include ('db_fns.php');

//Store database array into an excel file
function arrayToExcel() {

    $array = db_result_to_array(db_connect());

    header("Content-Disposition: attachment; filename=\"VillageHighSchoolReunionData.xls\"");
    header("Content-Type: application/vnd.ms-excel;");
    header("Pragma: no-cache");
    header("Expires: 0");
    $out = fopen("php://output", 'w');
    foreach ($array as $data)
    {
        fputcsv($out, $data,"\t");
    }
    fclose($out);
}


/*
 * This function takes in the year and displays total number of students in
 * the reunion of that year.
 */
function numberOfStudents ($year) {
    $numberOfStudentsSQL= "SELECT * FROM students WHERE grad_year = $year";
    $result = db_result_to_Array($numberOfStudentsSQL);
    $numberOfRows = len($result);
    echo "There are " + $numberOfRows + "students of year " + $year;
    while($row = $result) { // displaying the actual rows
        echo $row[first_name] + " " + $row[last_name]; // display the student names
    }
}

/*
 * This function displays the numbers of teachers in the database
 */
function numberOfTeachers () {
    $numberOfTeachersSQL= "SELECT * FROM teachers";
    $result = db_result_to_Array($numberOfTeachersSQL);
    $numberOfRows = len($result);
    echo "There are " + $numberOfRows + "teachers of year";
    while($row = $result) { // displaying the actual rows
        echo $row[first_name] + " " + $row[last_name]; // display the teacher names
    }
}

//BELOW IS CODE TO EXPORT DATABASE DIRECTLY TO EXCEL FILE

//function cleanData(&$str)
//{
//    $str = preg_replace("/\t/", "\\t", $str);
//    $str = preg_replace("/\r?\n/", "\\n", $str);
//    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
//}
//
//// filename for download
//$filename = "VillageHighReunionDatabase_" . date('Ymd') . ".xls";
//
//header("Content-Disposition: attachment; filename=\"$filename\"");
//header("Content-Type: application/vnd.ms-excel");
//
//$flag = false;
//$result = pg_query("SELECT * FROM student") or die('Query failed!');
//while(false !== ($row = pg_fetch_assoc($result))) {
//    if(!$flag) {
//        // display field/column names as first row
//        echo implode("\t", array_keys($row)) . "\r\n";
//        $flag = true;
//    }
//    array_walk($row, 'cleanData');
//    echo implode("\t", array_values($row)) . "\r\n";
//}
//
//exit;

//function create_database() {
//    $db_hostname = '127.0.0.1';
//    $db_username = 'root';
//    $db_password = '';
//    $db_database = 'reunion';
//
//    $mysql_connection = new mysqli($db_hostname, $db_username, $db_password);
//
//    if ($mysql_connection->connect_errno) {
//        printf("Failed to connect to the MySQL database server: %s\n", $mysql_connection->connect_error);
//    }
//
//    $reunion = "CREATE DATABASE reunion";
//    if ($mysql_connection->query($reunion) === TRUE) {
//        echo "Database created successfully\n";
//    } else {
//        echo "Error creating database: " . $mysql_connection->error . "\n";
//    }
//
//    $mysql_connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
//
//    $students = "CREATE TABLE students(
//	user_id int(6) PRIMARY KEY,
//	first_name varchar(15) NOT NULL,
//	last_name varchar(20) NOT NULL,
//	nickname varchar(20),
//	grad_year int(4) NOT NULL,
//	father_name varchar(15),
//	mother_name varchar(15),
//	email varchar(40) NOT NULL,
//	phone varchar(10),
//	family_details varchar(100),
//	work_experience varchar(200),
//	awards varchar(200),
//	street varchar(50),
//	city varchar(20),
//	state varchar(2),
//	zip int(5),
//	notes varchar(50),
//	photo varchar (30))";
//
////
//
//    if ($mysql_connection->query($students) === TRUE) {
//        echo "Students table created successfully \n";
//    } else {
//        echo "Table not created: " . $mysql_connection->error . "\n";
//    }
//
//
//    $teachers = "CREATE TABLE teachers(
// 	user_id int(6) PRIMARY KEY,
//	first_name varchar(15) NOT NULL,
//	last_name varchar(20) NOT NULL,
//	nickname varchar(20),
//	start_year int(4) NOT NULL,
//	end_year int(4) NOT NULL,
//	father_name varchar(15),
//	mother_name varchar(15),
//	email varchar(40) NOT NULL,
//	phone varchar(10),
//	family_details varchar(100),
//	work_experience varchar(200),
//	awards varchar(200),
//	street varchar(50),
//	city varchar(20),
//	state varchar(2),
//	zip int(5),
//	notes varchar(50),
//	photo varchar(30))";
//
//
//    if ($mysql_connection->query($teachers) === TRUE) {
//        echo "Teachers table created successfully \n";
//    } else {
//        echo "Table not created: " . $mysql_connection->error . "\n";
//    }
//
//    $user = "CREATE TABLE user(
//	username varchar(15),
//	password varchar(40),
//	admin varchar(3),
//	user_type varchar(7),
//	user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY)";
//
//    if ($mysql_connection->query($user) === TRUE) {
//        echo "User table created successfully \n";
//    } else {
//        echo "Table not created: " . $mysql_connection->error . "\n";
//    }
//    $admin_passwd = sha1("admin");
//
//    $admin = "INSERT INTO user(username, password, admin, user_type)
//	VALUES ('admin', '$admin_passwd', 'yes', 'student')";
//
//    if ($mysql_connection->query($admin) === TRUE) {
//        echo "New record created successfully" . "\n";
//    } else {
//        echo "Error: " . $mysql_connection . "<br>" . $mysql_connection->error . "\n";
//    }
//    $student_passwd = sha1("student");
//
//    $student_user = "INSERT INTO user(username, password, admin, user_type)
//	VALUES ('student', '$student_passwd', 'no', 'student')";
//
//    if ($mysql_connection->query($student_user) === TRUE) {
//        echo "New record created successfully" . "\n";
//    } else {
//        echo "Error: " . $mysql_connection . "<br>" . $mysql_connection->error . "\n";
//    }
//
//    $teacher_passwd = sha1("teacher");
//
//    $teacher_user = "INSERT INTO user(username, password, admin, user_type)
//	VALUES ('teacher', '$teacher_passwd', 'no', 'teacher')";
//
//    if ($mysql_connection->query($teacher_user) === TRUE) {
//        echo "New record created successfully" . "\n";
//    } else {
//        echo "Error: " . $mysql_connection . "<br>" . $mysql_connection->error . "\n";
//    }
//
//    $mysql_connection->close();
//
//}

