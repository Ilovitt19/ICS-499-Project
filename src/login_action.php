<?php
require_once ('reunion_fns.php');
include ('LoggedInUser.php');
session_start();
$conn = db_connect();

do_html_header("Error"," Error");
if (isset($_POST['username']) && isset($_POST['passwd'])) {
	// they have just tried logging in



	if (login($_POST['username'], $_POST['passwd'])) {
		$current_user = new LoggedInUser($_POST['username']);
		$_SESSION['current_user'] = serialize($current_user);
		session_commit();
		if ($current_user->admin === "yes") {
			header('Location: admin.php');
			exit();
		} else {
			header('Location: welcome.php');
			exit();
		}

	} else {
		// unsuccessful login

		echo "<p>You could not be logged in.<br/>You must be logged in to view this page.</p>";
		display_login_form();
		exit();
	}

} else {
	// unsuccessful login

	echo "<p>You could not be logged in.<br/>You must be logged in to view this page.</p>";
	display_login_form();
	exit();
}

