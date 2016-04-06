<?php

/**
 * Function used to get a database connection object
 * @return bool|mysqli the connection, if successful
 */
function db_connect() {
   //comment out metrostate linux sever when working on local machine
   //$result = mysqli_connect('localhost', 'ics499sp160102', '299436', 'ics499sp160102');
   $result = mysqli_connect('localhost', 'root', '', 'reunion');
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
function db_result_to_array($result) {
   $res_array = array();

   for ($count=0; $row = $result->fetch_assoc(); $count++) {
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
function create_user($conn, $username, $password, $is_admin, $user_type) {
   $query = "INSERT INTO user(username, password, admin, user_type)
	 VALUES ('$username', sha1('$password'), '$is_admin', '$user_type')";

   if ($conn->query($query) === TRUE) {
      $query = "SELECT user_id FROM user WHERE username = '$username'";
      $result = $conn->query($query);
      while($row = $result->fetch_assoc()) {
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
function create_student($conn, $user_id) {
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
function create_teacher($conn, $user_id) {
   $query = "INSERT INTO teachers(user_id, first_name, last_name, nickname, start_year, end_year, father_name, mother_name,
		email, phone, family_details, work_experience, awards, street, city, state, zip, notes,photo)
		VALUES('$user_id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)";

   return $conn->query($query) === TRUE;
}

?>
