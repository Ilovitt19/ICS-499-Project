<?php
  include('output_fns.php');
  require_once('user_auth_fns.php');

  session_start();
  do_html_header("Village High School Reunion","Event Info");

  show_event_info();
  do_html_footer();
?>
