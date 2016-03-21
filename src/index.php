<?php
  include('output_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Village High School Reunion","Event Info");

show_event_info();

  // if logged in as admin, show add, delete, edit cat links
  if(isset($_SESSION['admin_user'])) {
    display_button("admin.php", "admin-menu", "Admin Menu");
  }
  do_html_footer();
?>
