<?php

require_once('reunion_fns.php');
session_start();

function login($username, $password) {
// check username and password with db
// if yes, return true
// else return false

  // connect to db
  $conn = db_connect();
  if (!$conn) {
    return 0;
  }

  // check if username is unique
  $result = $conn->query("select * from user
                         where username='".$username."'
                         and password = sha1('".$password."')");
  if (!$result) {
     return 0;
  }

  if ($result->num_rows>0) {
     return 1;
  } else {
     return 0;
  }
}

//function change_password($username, $old_password, $new_password) {
//// change password for username/old_password to new_password
//// return true or false
//
//  // if the old password is right
//  // change their password to new_password and return true
//  // else return false
//  if (login($username, $old_password)) {
//
//    if (!($conn = db_connect())) {
//      return false;
//    }
//
//    $result = $conn->query("update user
//                            set password = sha1('".$new_password."')
//                            where username = '".$username."'");
//    if (!$result) {
//      return false;  // not changed
//    } else {
//      return true;  // changed successfully
//    }
//  } else {
//    return false; // old password was wrong
//  }
//}

function login_check() {
  if (isset($_SESSION['current_user'])) {
    return true;
  }else {
    return false;
  }
}

function clear_user_session_data() {
  foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
  }
  // Tell PHP to delete all data associated with the current PHP session.
  session_destroy();
  // Immediately save the session data.
  session_commit();
}
?>
