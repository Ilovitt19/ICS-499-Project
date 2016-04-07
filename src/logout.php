<?php

// include function files for this application
require_once('reunion_fns.php');
if (isset($_SESSION['current_user'])) {
  $old_user = $_SESSION['current_user'];  // store  to test if they *were* logged in
  clear_user_session_data();
  session_start();
}

// start output html
do_html_header("Logged Out", "Logout");

if (!empty($old_user)) {
  echo "<p>You Have Been Logged out</p>";
} else {
  // if they weren't logged in but came to this page somehow
  echo "<p>You were not logged in, and so have not been logged out.</p>";
}

do_html_footer();

?>
