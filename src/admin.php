<?php
include ('output_fns.php');
session_start();

// include function files for this application
require_once('user_auth_fns.php');

do_html_header("Admin","Admin");

if (check_admin_user()) {
} else {
	echo "<p>You are not authorized to enter the administration area.</p>";
}

do_html_footer();