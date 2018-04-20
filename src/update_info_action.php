<?php
require_once('reunion_fns.php');
include('logged_in_user_class.php');

if (isset($_SERVER['HTTP_REFERER'])) {
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
		$donation_sql = "UPDATE students SET donations = ? WHERE user_id = '$user_id'";
	} else {
		$start_year = $_POST["start_year"];
		$end_year = $_POST["end_year"];
		$donation_sql = "UPDATE teachers SET donations = ? WHERE user_id = '$user_id'";
	}
	$result = true;
	if (isset($_POST['donations']) || $current_user->admin == 'yes') {
		$stmt = $conn->stmt_init();
		if ($stmt->prepare($donation_sql)) {
			$stmt->bind_param("d", $_POST['donations']);
			$result = $stmt->execute();
		} else {
			$result = false;
		}
	}

	$sql = $user_type == "student" ?
		"UPDATE students SET first_name = '$first_name', last_name = '$last_name', nickname = '$nickname',
       grad_year = '$grad_year', father_name = '$father_name', mother_name = '$mother_name', email = '$email',
        phone = '$phone', family_details = '$family_details', work_experience ='$work_experience', awards ='$awards',
         street ='$street', city ='$city', state ='$state', zip ='$zip', notes ='$notes', attending='$attending' WHERE user_id = '$user_id'"
		:
		"UPDATE teachers SET first_name = '$first_name', last_name = '$last_name', nickname = '$nickname',
         start_year = '$start_year', end_year = '$end_year', father_name = '$father_name', mother_name = '$mother_name', email = '$email',
          phone = '$phone', family_details = '$family_details', work_experience ='$work_experience', awards ='$awards',
         street ='$street', city ='$city', state ='$state', zip ='$zip', notes ='$notes', attending ='$attending' WHERE user_id = '$user_id'";

	if ($conn->query($sql) && $result) {
		if (!isset($_POST['admin_edit'])) {
			unset($_SESSION['current_user']);
			$updated_user = new LoggedInUser($username);
			$_SESSION['current_user'] = serialize($updated_user);
			?>
			<div style="display:none;">
				<form id="reg_view" method="POST" action="view_user_page.php">
					<input type="hidden" name="info_update" value="yes"/>
				</form>
				<script>
					document.getElementById("reg_view").submit();
				</script>
			</div>
			<?php
		} else {
			?>
			<div style="display:none;">
				<form id="ad_view" method="POST" action="view_user_page.php">
					<input type="hidden" name="admin_view" value="yes"/>
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>"/>
				</form>
				<script>
					document.getElementById("ad_view").submit();
				</script>
			</div>
			<?php
		}
	} else {
		do_html_header("Error", "Error: Profile Failed To Update");
	}
	do_html_footer();
	$conn->close();
} else {
	echo "This page cannot be accessed";
}

