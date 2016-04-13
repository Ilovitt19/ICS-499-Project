<?php
/**
 * This file contains functions and code for:
 *  - Generating reports
 */
include ('db_fns.php');
/*
 * This function takes in the year and displays all of the students with names
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
 * This function displays the numbers of teachers in the database, and displays
 * their first and last names
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
/*
 * This function takes in the year and displays total number of students in
 * each class year
 */
function studentsPerClass () {
    $numberOfStudentsSQL= "SELECT COUNT(userID), grad_year FROM students GROUP BY grad_year";
    echo "Number of students for every year:  " + $numberOfStudentsSQL;
}
/**
 * Returns the number of registered students that are in the database
 * @param $year
 */
function registeredStudents () {
    $numberOfStudentsSQL= "SELECT COUNT(userID) FROM user";
    echo "There are " + $numberOfStudentsSQL + "registered students";
}
/**
 * Returns the total amount of donation students have raised
 */
function studentFunds () {
    $funds = "SELECT SUM(donation_field) FROM students";
    echo "There are $" + $funds + "dollars raised from students ";
}
/**
 * Returns the total amount of donation teachers have raised
 */
function teacherFunds () {
    $funds = "SELECT SUM(donation_field) FROM teachers";
    echo "There are $" + $funds + " dollars raised from teachers ";
}