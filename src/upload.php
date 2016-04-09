<?php
require ('reunion_fns.php');
include ('LoggedInUser.php');

if (isset($_POST['admin_edit'])) {
	$username = get_username_by_id($_POST['user_id']);
	$current_user = new LoggedInUser($username);
} else {
	$current_user = unserialize($_SESSION['current_user']);
}
$last_name = $current_user->last_name;
$user_id = $current_user->user_id;
//echo "NOTE TO Jasthi... I have tried several ways to upload to the server but it seems there is<br>";
//echo "a lack of permission on the Linux server to allow php to read/write<br>";
create_folder();
$target_dir = "images/photos/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$temp_file = $_FILES["fileToUpload"]["tmp_name"];
	if(!empty($temp_file) && getimagesize($temp_file)) {
		$uploadOk = 1;
	} else {
		echo "File is not a valid image.<br>";
		$uploadOk = 0;
	}
}
// Check file size

// Allow certain file formats
if(strcasecmp($imageFileType, "jpg") != 0 && strcasecmp($imageFileType, "png") != 0 &&
	strcasecmp($imageFileType, "jpeg") != 0 && strcasecmp($imageFileType, "gif") != 0 ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
	$target_file = "images/Photos/" . $last_name . "_" . $user_id . "." . $imageFileType;
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) &&
		save_to_database($target_file, $current_user->user_type, $user_id)) {
		if (isset($_POST['admin_edit'])) {
			?>
			<div style="display:none;">
				<form id="edit_form" method="POST" action="UserInfo.php">
					<input type="hidden" name="user_id" value=" <?php echo $_POST['user_id'] ?>" />
					<input type="hidden" name="admin_edit" value="yes" />
				</form>
				<script>
					document.getElementById("edit_form").submit();
				</script>
			</div>
			<?php
		} else {
			$username = $current_user->username;
			unset($_SESSION['current_user']);
			$updated_user = new LoggedInUser($username);
			$_SESSION['current_user'] = serialize($updated_user);
			session_commit();
			header('Location: UserInfo.php',"Refresh:0");
			exit();
		}
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}


function save_to_database($target_file, $user_type, $user_id) {
	$conn = db_connect();
	$query = $user_type == "student" ?
		"UPDATE students SET photo = '$target_file' WHERE user_id = '$user_id'" :
		"UPDATE teachers SET photo = '$target_file' WHERE user_id = '$user_id'";
	if ($conn->query($query) === TRUE) {
		$conn->close();
		return true;
	}
	echo "Error: " . $conn->error;
	$conn->close();
	return false;
}
function create_folder() {
	$dir = 'images/Photos';

	if (!file_exists($dir)) {
		mkdir($dir,0755);
	}
}

