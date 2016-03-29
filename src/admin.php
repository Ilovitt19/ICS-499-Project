<?php
include ('reunion_fns.php');
session_start();

// include function files for this application
require_once('user_auth_fns.php');

do_html_header("Admin","Admin");
// add functions for logged in admin user
echo "<a href='CreateDatabase.php'>Create Database</a>";

if (login_check() == 'true') {
	if (check_admin_user()) {
		// add functions for logged in admin user

	} else {
		echo "<p>You are not authorized to enter the administration area.</p>";
	}
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();