<?php
  include('output_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Village High School Reunion","Event Info");

show_event_info();
  do_html_footer();
?>
