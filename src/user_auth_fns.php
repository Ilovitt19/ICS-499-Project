<?php

require_once('db_fns.php');
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

function check_admin_user() {
// see if somebody is logged in and notify them if not

  if (isset($_SESSION['admin_user'])) {
    return true;
  } else {
    return false;
  }
}

function get_user_type() {
  $conn = db_connect();
  if (isset($_SESSION['user'])) {
    $current_user = $_SESSION['user'];
    $sql = $conn->query("select user_type from user where username = '$current_user'");
    $sql_result = $sql->fetch_assoc();
    $user_type = $sql_result['user_type'];
    return $user_type;
  } else {
    $current_user = $_SESSION['admin_user'];
    $sql = $conn->query("select user_type from user where username = '$current_user'");
    $sql_result = $sql->fetch_assoc();
    $user_type = $sql_result['user_type'];
    return $user_type;
  }
}

function get_user_id() {
  $conn = db_connect();
  if (isset($_SESSION['user'])) {
    $current_user = $_SESSION['user'];
    $sql = $conn->query("select user_id from user where username = '$current_user'");
    $sql_result = $sql->fetch_assoc();
    $user_id = $sql_result['user_id'];
    return $user_id;
  } else {
    $current_user = $_SESSION['admin_user'];
    $sql = $conn->query("select user_id from user where username = '$current_user'");
    $sql_result = $sql->fetch_assoc();
    $user_id = $sql_result['user_id'];
    return $user_id;
  }
}

function change_password($username, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else return false
  if (login($username, $old_password)) {

    if (!($conn = db_connect())) {
      return false;
    }

    $result = $conn->query("update user
                            set password = sha1('".$new_password."')
                            where username = '".$username."'");
    if (!$result) {
      return false;  // not changed
    } else {
      return true;  // changed successfully
    }
  } else {
    return false; // old password was wrong
  }
}

function login_check() {
  if (isset($_SESSION['admin_user']) || isset($_SESSION['user'])) {
    return true;
  }else {
    return false;
  }
}




?>
