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
		$conn = db_connect();
		echo "<p>ADMIN REPORTS.</p>";
		export_db_button();
		import_db_button();
		$student_count = count_total_students();
		$teacher_count = count_total_teachers();
		$user_count = $student_count + $teacher_count;
		$students_attending = count_students_attending();
		$teachers_attending = count_teachers_attending();
		$total_attending = $students_attending + $teachers_attending;
		$admin_count = count_admin_users();
		$updated_count = count_updated_users();
		$not_updated_count = $user_count - $updated_count;
		$test_list = get_class_count_list();
		echo $student_count . "\n";
		echo $teacher_count . "\n";
		echo $user_count . "\n";
		echo $students_attending . "\n";
		echo $teachers_attending . "\n";
		echo $total_attending . "\n";
		echo $admin_count . "\n";
		echo $updated_count . "\n";
		echo $not_updated_count . "\n";
	} else {
		echo "<p>You are not authorized to enter the administration area.</p>";
	}
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();