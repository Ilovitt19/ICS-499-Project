<?php
/*
 * Welcome.php acts as Home page while user is logged in
 */
include ('reunion_fns.php');


do_html_header("Village High School Reunion","Welcome");

if (login_check() == 'true') {
	show_event_info();
	scroll();
	// add functions for logged in users
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}

do_html_footer();