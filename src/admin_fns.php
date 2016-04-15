<?php
/**
 * This file contains functions and code for:
 *  - Generating reports
 */
include_once ('db_fns.php');

function count_total_teachers() {
    $conn = db_connect();
    $sql= "SELECT COUNT(*) AS total FROM teachers";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['total'];
}


function count_total_students() {
    $conn = db_connect();
    $sql= "SELECT COUNT(*) AS total FROM students";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['total'];
}


function count_donations() {
    $conn = db_connect();
    $sql = "SELECT SUM(donation) AS total FROM teachers";
    $result = $conn->query($sql);
    $row_one = $result->fetch_assoc();
    $sql = "SELECT SUM(donation) AS total FROM students";
    $result= $conn->query($sql);
    $row_two = $result->fetch_assoc();
    $conn->close();
    return $row_one['total'] + $row_two['total'];
}


function count_students_attending() {
    $conn = db_connect();
    $sql = "SELECT COUNT(*) AS total FROM students WHERE attending = 'yes'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['total'];
}


function count_teachers_attending() {
    $conn = db_connect();
    $sql = "SELECT COUNT(*) AS total FROM teachers WHERE attending = 'yes'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['total'];
}

function count_admin_users() {
    $conn = db_connect();
    $sql = "SELECT COUNT(*) AS total FROM user WHERE admin = 'yes'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $conn->close();
    return $row['total'];
}

function count_updated_users() {
    $conn = db_connect();
    $sql = "SELECT COUNT(*) AS total FROM teachers WHERE first_name IS NOT NULL ";
    $result = $conn->query($sql);
    $row_one = $result->fetch_assoc();
    $sql = "SELECT COUNT(*) AS total FROM students WHERE first_name IS NOT NULL ";
    $result= $conn->query($sql);
    $row_two = $result->fetch_assoc();
    $conn->close();
    return $row_one['total'] + $row_two['total'];
}

function get_class_count_list() {
    $list = array();
    $conn = db_connect();
    $sql = "SELECT DISTINCT grad_year FROM students WHERE grad_year IS NOT NULL ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $grad_year = $row['grad_year'];
        $sql = "SELECT COUNT(*) AS total FROM students WHERE grad_year = '$grad_year'";
        $count_result = $conn->query($sql);
        $count_row = $count_result->fetch_assoc();
        array_push($list, array('grad_year'=>$grad_year, 'student_count'=>$count_row['total']));
    }
    $conn->close();
    $sorted_list = array();
    foreach ($list as $key => $row)
    {
        $sorted_list[$key] = $row['grad_year'];
    }
    array_multisort($sorted_list, SORT_ASC, $list);
    return $list;

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
        <button type="button" class="fakebutton"><a>Select a SQL file to import to the Database</a></button>
        <input class="fakebutton" type="file" name="fileToUpload" id="fileToUpload"><br>
        <input class="fakebutton" type="submit" value="Submit" class="button" name="submit"><br>
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
    $conn->close();
}

function do_stats_output() {
    ?>
  <div id="wrapper">
		<form id="generalform" class="container" method="post" action="">
			<table>
			<h3>System Metrics</h3>
				<tr>
					<td><label>Student Users Registered:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_total_students();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Teachers Users Registered:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_total_teachers();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Total Users Registered:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_total_teachers() + count_total_students();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Updated Profiles:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_updated_users();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Empty Profiles:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo (count_total_students() + count_total_teachers()) - count_updated_users();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Admin Users:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_admin_users();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Students Attending Reunion:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_students_attending();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Teachers Attending Reunion:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_teachers_attending();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Total Attending Reunion:</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo count_students_attending() + count_teachers_attending();?>" readonly></td>
				</tr>
				<tr>
					<td><label>Total Donation Count</label></td>
					<td align="left"><input type="text" name="" size="" maxlength="" value="<?php echo "$" . count_donations();?>" readonly></td>
				</tr>
			</table>
		</form>
	</div>
    <?php

}



