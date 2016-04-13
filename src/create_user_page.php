<?php
include ('reunion_fns.php');
include('logged_in_user_class.php');

do_html_header("Create User", "Admin: Create New User");

if (login_check()) {
  $current_user = unserialize($_SESSION['current_user']);
  if ($current_user->admin == 'yes') {
    do_user_create_form();
    do_back_button("search_select_page.php", "Back To Search");
  } else {
    echo "<p>You are not authorized to enter the administration area.</p>";
  }
} else {
  echo "<p>You must be logged in to visit this page.</p>";
}
do_html_footer();