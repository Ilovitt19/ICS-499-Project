<?php
include ('output_fns.php');
session_start();
do_html_header("Admin","Admin");

initialize_database();

do_html_footer();