<?php

include ('reunion_fns.php');
require_once ('user_auth_fns.php');

do_html_header("My Profile","My Profile");

if (login_check() == 'true') {

	echo get_user_id();
	echo get_user_type();
	do_info_form();
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();
