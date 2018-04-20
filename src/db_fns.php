<?php

/**
 * Function used to get a database connection object
 * @return bool|mysqli the connection, if successful
 */
function db_connect()
{
	//comment out metrostate linux sever when working on local machine
	//$result = mysqli_connect('localhost', 'ics499sp160102', '299436', 'ics499sp160102');
	$result = mysqli_connect('localhost', 'root', 'test', 'reunion');
	if (!$result) {
		return false;
	}
	$result->autocommit(TRUE);
	return $result;
}

/**
 * Function to get an array of data from a database query result
 *
 * @param $result mysqli_result - the query result
 * @return array - the array of results
 */
function db_result_to_array($result)
{
	$res_array = array();

	for ($count = 0; $row = $result->fetch_assoc(); $count++) {
		$res_array[$count] = $row;
	}

	return $res_array;
}

/**
 * Creates a new user with specified parameters and enters stores appropriate data
 * in the users table and the student or teacher table.
 *
 * @param $conn mysqli - The connection
 * @param $username - The new user's username
 * @param $password - The password
 * @param $is_admin - Is this user to be an admin?
 * @param $user_type - Student or Teacher?
 * @return bool - Was the user created successfully?
 */
function create_user($conn, $username, $password, $is_admin, $user_type)
{
	$query = "INSERT INTO user(username, password, admin, user_type)
	 VALUES ('$username', sha1('$password'), '$is_admin', '$user_type')";

	if ($conn->query($query) === TRUE) {
		$query = "SELECT user_id FROM user WHERE username = '$username'";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc()) {
			$user_id = $row["user_id"];
		}
		if ($user_type == 'student') {
			return create_student($conn, $user_id);
		} elseif ($user_type == 'teacher') {
			return create_teacher($conn, $user_id);
		}
	} else {
		return false;
	}


}

/**
 * Enter student data for a new user
 *
 * @param $conn mysqli - The DB connection
 * @param $user_id - The user ID
 * @return bool - Was record created successfully?
 */
function create_student($conn, $user_id)
{
	$query = "INSERT INTO students(user_id, first_name, last_name, nickname, grad_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes, photo)
		VALUES('$user_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

	return $conn->query($query) === TRUE;
}

/**
 * Enter teacher data for a new user
 *
 * @param $conn mysqli - The DB connection
 * @param $user_id - The user ID
 * @return bool - Was record created successfully?
 */
function create_teacher($conn, $user_id)
{
	$query = "INSERT INTO teachers(user_id, first_name, last_name, nickname, start_year, end_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes,photo)
		VALUES('$user_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

	return $conn->query($query) === TRUE;
}

/**
 * @param $conn mysqli - The DB connection
 * @param $username - The username
 * @return array - The array of 'user' table data
 */
function get_user_fields($conn, $username)
{
	$query = "SELECT username, admin, user_type, user_id FROM user WHERE username = ?";
	$stmt = $conn->stmt_init();
	if ($stmt->prepare($query)) {
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($u, $a, $t, $i);
		$stmt->fetch();
		return array('username' => $u, 'admin' => $a, 'user_type' => $t, 'user_id' => $i);
	}
	return false;
}

/**
 * @param $conn - The DB connection
 * @param $user_id - The user ID
 * @param $user_type - Is this a teacher or student user?
 * @return array|boolean - The array of teacher/student field data
 */
function get_other_fields($conn, $user_id, $user_type)
{
	if ($user_type == 'student') {
		return get_student_fields($conn, $user_id);
	} elseif ($user_type == 'teacher') {
		return get_teacher_fields($conn, $user_id);
	}
	return false;
}

/**
 * @param $conn mysqli - The DB connection
 * @param $user_id - The user ID
 * @return bool
 */
function get_student_fields($conn, $user_id)
{
	$query = "SELECT * FROM students WHERE user_id = '$user_id'";
	if ($result = $conn->query($query)) {
		return $result->fetch_assoc();
	}
	return false;
}

/**
 * @param $conn mysqli - The DB connection
 * @param $user_id
 * @return bool
 */
function get_teacher_fields($conn, $user_id)
{
	$query = "SELECT * FROM teachers WHERE user_id = '$user_id'";
	if ($result = $conn->query($query)) {
		return $result->fetch_assoc();
	}
	return false;
}

function get_username_by_id($user_id)
{
	$conn = db_connect();
	$query = "SELECT username FROM user WHERE user_id = '$user_id'";
	$result = $conn->query($query)->fetch_assoc();
	return $result['username'];
}

function get_type_by_id($user_id)
{
	$conn = db_connect();
	$query = "SELECT user_type FROM user WHERE user_id = '$user_id'";
	$result = $conn->query($query)->fetch_assoc();
	return $result['user_type'];
}

?>
