<?php
require_once('reunion_fns.php');
include('logged_in_user_class.php');
if (isset($_SERVER['HTTP_REFERER'])) {
  if (isset($_POST['db_imported'])) {
    clear_user_session_data();
    session_start();
  }
  do_html_header("Login", " ");

  display_login_form();

  do_html_footer();
} else {
  echo "This page cannot be accessed";
}

