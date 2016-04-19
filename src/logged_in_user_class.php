<?php


class LoggedInUser {

  var $user_id;
  var $username;
  var $admin;
  var $user_type;
  var $first_name;
  var $last_name;
  var $nickname;
  var $grad_year;
  var $start_year;
  var $end_year;
  var $father_name;
  var $mother_name;
  var $email;
  var $phone;
  var $family_details;
  var $work_experience;
  var $awards;
  var $street;
  var $city;
  var $state;
  var $zip;
  var $notes;
  var $photo;
  var $attending;
  var $donations;

  public function __construct($username) {
    $conn = db_connect();
    $user_fields = get_user_fields($conn, $username);
    $other_fields = get_other_fields($conn, $user_fields['user_id'], $user_fields['user_type']);
    $all_fields = array_merge($user_fields, $other_fields);
    foreach ($this as $key => $value) {
      if (isset($all_fields[$key])) {
        $this->$key = $all_fields[$key];
      }
    }
    $conn->close();
  }
}