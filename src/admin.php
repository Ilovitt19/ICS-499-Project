<?php
include ('reunion_fns.php');
include ('LoggedInUser.php');

// include function files for this application
require_once('user_auth_fns.php');

do_html_header("Admin","Admin");
// add functions for logged in admin user


if (isset($_SESSION['current_user'])) {
	$current_user = unserialize($_SESSION['current_user']);
	if ($current_user->admin == 'yes') {
		// add functions for logged in admin user

	} else {
		echo "<p>You are not authorized to enter the administration area.</p>";
	}
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();