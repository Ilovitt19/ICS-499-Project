<?php
/**
 * Created by IntelliJ IDEA.
 * User: Ian
 * Date: 4/10/2016
 * Time: 5:27 PM
 */

include ('reunion_fns.php');
include ('LoggedInUser.php');
do_html_header("Find People","Select Search Type");
if (login_check()) {
?>
  <form action="student_search.php" method="post">
    <input type="submit" name="search_student" value="Search For Students">
  </form>
  <form action="teacher_search.php" method="post">
    <input type="submit" name="admin_search" value="Search For Teachers">
  </form>

<?php
} else {
  echo "<p>You must be logged in to visit this page.</p>";
}
echo "</body>";
echo "</html>";
