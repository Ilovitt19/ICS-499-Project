<?php
include ('reunion_fns.php');

session_start();

do_html_header("Village High School Reunion","Welcome");

if (login_check() == 'true') {
	// add functions for logged in users - isn't a function already called from UserInfo.php?
	// route them to information display page after they log in
    do_info_form(); // Might be redundant
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();