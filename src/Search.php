<?php

include ('reunion_fns.php');
include ('search_reunion.php');

do_html_header("Find People","Enter Search");
if (login_check() == 'true') {
  search_for_students();
  //do_query_results();
} else {
  echo "<p>You must be logged in to visit this page.</p>";
}

?>
