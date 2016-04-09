<?php

include ('reunion_fns.php');
require_once ('user_auth_fns.php');
include ('LoggedInUser.php');
$title = isset($_POST['admin_edit']) ? "Admin: Edit User" : "My Profile";
do_html_header($title, $title);

if (login_check()) {
	do_info_form();
} else {
	echo "<p><br>You must be logged in to visit this page.</p>";
}

do_html_footer();
