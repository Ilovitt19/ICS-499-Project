<?php
require_once('reunion_fns.php');
if (isset($_SERVER['HTTP_REFERER'])) {
  do_html_header("Login", "Login");

  display_login_form();

  do_html_footer();
} else {
  echo "This page cannot be accessed";
}
?>
