<?php
include ('reunion_fns.php');
include('logged_in_user_class.php');
include ('admin_fns.php');

// include function files for this application
require_once('user_auth_fns.php');

do_html_header("Admin","Admin");
// add functions for logged in admin user


if (login_check()) {
	$current_user = unserialize($_SESSION['current_user']);
	if ($current_user->admin == 'yes') {
		// add functions for logged in admin user
		echo "<p>ADMIN REPORTS.</p>";
		export_db_button();
		import_db_button();
		//studentsPerClass(); //displays number of users for each year
		//registeredStudents(); //displays number of registered students
		//studentFunds(); //displays donation amount received from students
		//teacherFunds(); //displays donation amount received from teachers
	} else {
		echo "<p>You are not authorized to enter the administration area.</p>";
	}
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();