<?php

include ('reunion_fns.php');
require_once ('user_auth_fns.php');
include ('LoggedInUser.php');

do_html_header("My Profile","My Profile");

if (login_check()) {
	do_info_form();
} else {
	echo "<p><br>You must be logged in to visit this page.</p>";
}

do_html_footer();
