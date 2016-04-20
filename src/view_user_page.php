<?php

include ('reunion_fns.php');
include('logged_in_user_class.php');

if (isset($_POST['view_user'])) {
  $title = "View User: " . get_username_by_id($_POST['user_id']);
} elseif (isset($_POST['info_update'])) {
  $title = "My Profile Updated Successfully";
} elseif (isset($_POST['admin_view'])) {
  $title = "Admin Edit: User \"" . get_username_by_id($_POST['user_id']) . "\" Profile Updated Successfully";
} else {
  $title = "My Profile";
}
do_html_header($title, $title);

if (login_check()) {
  do_view_info_form();
  if (isset($_POST['admin_view']) || isset($_POST['view_user'])) {
    do_back_button(isset($_POST['teacher_result']) ? "teacher_search_page.php" : "student_search_page.php", "Back To Search");
  }
} else {
  echo "<p><br>You must be logged in to visit this page.</p>";
}

do_html_footer();