<?php
include('reunion_fns.php');

$conn = db_connect();

if (empty($_FILES['fileToUpload']["tmp_name"])) {
	header('Location: admin_page.php');
	exit();
}
$sqlDump = $_FILES['fileToUpload']["tmp_name"];

$sqlSource = file_get_contents($sqlDump);

if (mysqli_multi_query($conn, $sqlSource) === TRUE) {
	echo "User data entered successfully <br>";
} else {
	echo "User data not entered: " . $conn->error . "<br>";
}
do_back_button('admin.php', "Back To Admin");
