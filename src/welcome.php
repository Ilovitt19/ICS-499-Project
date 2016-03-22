<?php
include ('output_fns.php');
session_start();

// include function files for this application
require_once('user_auth_fns.php');

$conn = db_connect();


if (($_GET['username']) && ($_GET['passwd'])) {
	// they have just tried logging in

	$username = $_GET['username'];
	$passwd = $_GET['passwd'];

	if (login($username, $passwd)) {
		// if they are in the database register the user id

		$sql = "SELECT admin FROM user WHERE username = '$username'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$admin_check = $row["admin"];
		}



		if ($admin_check === "yes") {
			$_SESSION['admin_user'] = $username;
		} else {
			$_SESSION['user'] = $username;
		}

	} else {
		// unsuccessful login
		echo "<p>You could not be logged in.<br/>
            You must be logged in to view this page.</p>";
		do_html_url('login.php', 'Login');
		exit;
	}
}



do_html_header("Village High School Reunion","Welcome");

if (check_admin_user()) {
} else {
	echo "<p>You are not authorized to enter the administration area.</p>";
}

do_html_footer();