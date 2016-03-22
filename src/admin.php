<?php
include ('reunion_fns.php');
session_start();

// include function files for this application
require_once('user_auth_fns.php');

do_html_header("Admin","Admin");


if (($_POST['username']) && ($_POST['passwd'])) {
	// they have just tried logging in

	$username = $_GET['username'];
	$passwd = $_GET['passwd'];

	if (login($username, $passwd)) {
		// if they are in the database register the user id
		$_SESSION['admin_user'] = $username;

	} else {
		// unsuccessful login
		do_html_header("Problem:");
		echo "<p>You could not be logged in.<br/>
            You must be logged in to view this page.</p>";
		do_html_url('login.php', 'Login');
		do_html_footer();
		exit;
	}
}

if (check_admin_user()) {
} else {
	echo "<p>You are not authorized to enter the administration area.</p>";
}






do_html_footer();