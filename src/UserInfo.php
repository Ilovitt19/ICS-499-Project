<?php

include ('output_fns.php');
require_once ('user_auth_fns.php');
session_start();

do_html_header("My Profile","My Profile");

if (login_check() == 'true') {
	do_info_form();
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}
