<?php
	require_once ('db_fns.php');

	$conn = db_connect();
	//set time zone here
	date_default_timezone_set("UTC");

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

?>
<script>
	alert("Successful Backup");
	window.location.href='admin_page.php';
</script>;