<?php
include ('reunion_fns.php');
include('logged_in_user_class.php');
include ('admin_fns.php');

// include function files for this application
require_once('user_auth_fns.php');

do_html_header("Admin","Admin Reports");
// add functions for logged in admin user


if (login_check()) {
	$current_user = unserialize($_SESSION['current_user']);
	if ($current_user->admin == 'yes') {
		export_db_button();
		import_db_button();
		do_stats_output();
	} else {
		echo "<p>You are not authorized to enter the administration area.</p>";
	}
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();