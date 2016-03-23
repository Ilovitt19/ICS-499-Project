<?php
require_once ('reunion_fns.php');
session_start();
$conn = db_connect();
if (($_GET['username']) && ($_GET['passwd'])) {
	// they have just tried logging in



	if (login($_GET['username'], $_GET['passwd'])) {
		// if they are in the database register the user id
		$username = $_GET['username'];
		$passwd = $_GET['passwd'];

		$sql = "SELECT admin FROM user WHERE username = '$username'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()) {
			$admin_check = $row["admin"];
		}



		if ($admin_check === "yes") {
			$_SESSION['admin_user'] = $username;
			header('Location: admin.php');
		} else {
			$_SESSION['user'] = $username;
			header('Location: welcome.php');
		}

	} else {
		// unsuccessful login
		echo "<p>You could not be logged in.<br/>
            You must be logged in to view this page.</p>";
		do_html_url('login.php', 'Login');
		exit;
	}

}