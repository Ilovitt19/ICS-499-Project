<?php
require_once ('reunion_fns.php');
if (isset($_SERVER['HTTP_REFERER'])) {
  $conn = db_connect();
  $user_id = $_POST['user_id'];
  $user_sql = "DELETE FROM user WHERE user_id = '$user_id'";
  if ($_POST['delete_type'] == 'student') {
    $other_sql = "DELETE FROM students WHERE user_id = '$user_id'";
  } else {
    $other_sql = "DELETE FROM teachers WHERE user_id = '$user_id'";
  }

  if ($conn->query($user_sql) && $conn->query($other_sql)) {
    echo "User has been deleted successfully.";
  } else {
    echo "There was an error in deleting the user.";
  }
  if ($_POST['delete_type'] == 'student') {
    do_back_button("student_search.php");
  } else {
    do_back_button('teacher_search.php');
  }
  $conn->close();
} else {
  echo "This page cannot be accessed";
}