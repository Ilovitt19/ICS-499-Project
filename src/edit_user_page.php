<?php

include ('reunion_fns.php');
require_once ('user_auth_fns.php');
include('logged_in_user_class.php');
$title = isset($_POST['admin_edit']) ? "Admin: Edit User Profile" : "Edit My Profile";
do_html_header($title, $title);

if (login_check()) {
	do_edit_info_form();
} else {
	echo "<p><br>You must be logged in to visit this page.</p>";
}

do_html_footer();
