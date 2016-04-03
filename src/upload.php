<?php
require ('reunion_fns.php');
get_user_data();
$last_name = $_SESSION['last_name'];
$user_id = $_SESSION['user_id'];

$target_dir = "images/photos/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if($check !== false) {
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}
// Check file size

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
	$target_file = "images/photos/" . $last_name . "_" . $user_id . "." . $imageFileType;
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		save_to_database($target_file);
		echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been renamed to " . $last_name . $user_id . " and uploaded.";
	} else {
		echo "Sorry, there was an error uploading your file.";
	}
}

function save_to_database($target_file) {
	$conn = db_connect();
	$user_id = get_user_id();
	$select = get_user_type();
	if ($select == "student") {
		$query = "SELECT * FROM students WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result)== 0) {
			$sql = "INSERT INTO students(image_url) VALUES ('$target_file')";
			if ($conn->query($sql) === TRUE) {
				echo "Your photo has been uploaded successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} elseif (mysqli_num_rows($result)== 1) {
			$sql = "UPDATE students SET image_url = '$target_file'";
			if ($conn->query($sql) === TRUE) {
				echo "Your photo has been updated successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	} else {
		$query = "SELECT * FROM teachers WHERE user_id = '$user_id'";
		$result = mysqli_query($conn, $query);

		if (mysqli_num_rows($result) == 0) {
			$sql = "INSERT INTO teachers(image_url) VALUES ('$target_file')";
			if ($conn->query($sql) === TRUE) {
				echo "Your photo has been uploaded successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		} elseif (mysqli_num_rows($result) == 1) {
			$sql = "UPDATE teachers SET image_url = '$target_file'";
			if ($conn->query($sql) === TRUE) {
				echo "Your photo has been updated successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}

}

//header('Location: UserInfo.php');
