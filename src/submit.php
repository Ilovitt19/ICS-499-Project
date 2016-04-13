<?php
require_once ('reunion_fns.php');
include ('LoggedInUser.php');

$conn = db_connect();
if (isset($_POST['admin_edit'])) {
  $username = get_username_by_id($_POST['user_id']);
  $current_user = new LoggedInUser($username);
} else {
  $current_user = unserialize($_SESSION['current_user']);
}
$user_type = $current_user->user_type;
$user_id = $current_user->user_id;
$username = $current_user->username;
if (isset($_POST['first_name'])) {
	$first_name = $_POST["first_name"];
	$last_name = $_POST["last_name"];
	$nickname = $_POST["nickname"];
	$father_name = $_POST["father_name"];
	$mother_name = $_POST["mother_name"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$family_details = $_POST["family_details"];
	$work_experience = $_POST["work_experience"];
	$awards = $_POST["awards"];
	$street = $_POST["street"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];
	$notes = $_POST["notes"];
	$attending = $_POST["attending"];


//need to add a check if data exists for this user
//if user has an entry in db already do update else do insert

	if ($user_type == "student") {
    $grad_year = $_POST["grad_year"];
    $sql = "UPDATE students SET first_name = '$first_name', last_name = '$last_name', nickname = '$nickname',
     grad_year = '$grad_year', father_name = '$father_name', mother_name = '$mother_name', email = '$email',
      phone = '$phone', family_details = '$family_details', work_experience ='$work_experience', awards ='$awards',
       street ='$street', city ='$city', state ='$state', zip ='$zip', notes ='$notes', attending='$attending' WHERE user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
      echo "Your record has been updated successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  } else {
    $start_year = $_POST["start_year"];
    $end_year = $_POST["end_year"];
    $sql = "UPDATE teachers SET first_name = '$first_name', last_name = '$last_name', nickname = '$nickname',
       start_year = '$start_year', end_year = '$end_year', father_name = '$father_name', mother_name = '$mother_name', email = '$email',
        phone = '$phone', family_details = '$family_details', work_experience ='$work_experience', awards ='$awards',
       street ='$street', city ='$city', state ='$state', zip ='$zip', notes ='$notes', attending-'$attending' WHERE user_id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
      echo "Your record has been updated successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
$conn->close();
if (!isset($_POST['admin_edit'])) {
  unset($_SESSION['current_user']);
  $updated_user = new LoggedInUser($username);
  $_SESSION['current_user'] = serialize($updated_user);
  do_back_button("UserInfo.php", "Back To Edit");
} else {
  ?>
  <form action="UserInfo.php" method="post">
    <input type="hidden" name="admin_edit" value="yes">
    <input type="hidden" name="user_id" value="<?php echo $user_id?>">
    <input type="submit" name="back_button" value="Back">
  </form>
<?php
}

//Change this file to edit_info... create new UserInfo file to display info only
//header('Location: UserInfo.php');

