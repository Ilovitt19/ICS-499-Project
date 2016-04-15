<?php
/**
 * This file contains functions and code for:
 *  - Generating reports
 */
include_once ('db_fns.php');
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

function export_db_button () {
    ?>
    <button type="button" class="fakebutton"  onclick="myFunction()"><a>Backup Database</a></button>
    <script>
        function myFunction() {
            <?php export_database(); ?>
            confirm("Database Backed up\n File saved to src/sql_files");
        }
    </script>
<?php

}
function import_db_button () {
    ?>
    <form action="import_database_action.php" method="post" enctype="multipart/form-data">
        Select SQL file to import to DB<br>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input type="submit" value="Import SQL" class="button" name="submit"><br>
    <?php
   }
function export_database()
{
    $conn = db_connect();

    $sql = "SELECT * FROM students";

    $result = $conn->query($sql);
    //output to file location change file path if needed. Default is src/sql_files/
    $output_file = fopen("sql_files/reunion_db_" . date("dMY") . "_backup.sql", "w");

    if ($result !== false) {

        while ($row_array = $result->fetch_assoc()) {
            $build_query = " INSERT INTO students (";
            foreach ($row_array as $key => $value) {
                $build_query .= $key . ", ";
            }
            $build_query = substr($build_query, 0, -2) . ") VALUES (";
            foreach ($row_array as $key => $value) {
                $build_query .= "'" . $value . "', ";
            }
            $build_query = substr($build_query, 0, -2) . ");\n";
            fwrite($output_file, $build_query);

        }
    }
    $sql = "SELECT * FROM teachers";

    $result = $conn->query($sql);

    if ($result !== false) {

        while ($row_array = $result->fetch_assoc()) {
            $build_query = " INSERT INTO teachers (";
            foreach ($row_array as $key => $value) {
                $build_query .= $key . ", ";
            }
            $build_query = substr($build_query, 0, -2) . ") VALUES (";
            foreach ($row_array as $key => $value) {
                $build_query .= "'" . $value . "', ";
            }
            $build_query = substr($build_query, 0, -2) . ");\n";
            fwrite($output_file, $build_query);

        }
    }
    $sql = "SELECT * FROM user";

    $result = $conn->query($sql);

    if ($result !== false) {


        while ($row_array = $result->fetch_assoc()) {
            $build_query = " INSERT INTO user (";
            foreach ($row_array as $key => $value) {
                $build_query .= $key . ", ";
            }
            $build_query = substr($build_query, 0, -2) . ") VALUES (";
            foreach ($row_array as $key => $value) {
                $build_query .= "'" . $value . "', ";
            }
            $build_query = substr($build_query, 0, -2) . ");\n";
            fwrite($output_file, $build_query);

        }
    }
}



