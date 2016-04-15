<?php
include('reunion_fns.php');
$conn = db_connect();

$sqlDump = $_FILES['fileToUpload']["tmp_name"];

$sqlSource = file_get_contents($sqlDump);

if (mysqli_multi_query($conn,$sqlDump) === TRUE) {
	echo "User data entered successfully <br>";
} else {
	echo "User data not entered: " . $conn->error . "<br>";
}