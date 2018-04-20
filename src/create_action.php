<?php
include('reunion_fns.php');
include('logged_in_user_class.php');

if (isset($_SERVER['HTTP_REFERER'])) {
	$new_username = $_POST['new_username'];
	$new_password = $_POST['new_password'];
	$confirm_new_password = $_POST['confirm_new_password'];
	$new_user_type = $_POST['new_user_type'];
	$new_admin = $_POST['new_admin'];
	$conn = db_connect();
	$sql = "SELECT * FROM user WHERE username = '$new_username'";
	$result = $conn->query($sql);
	if ($result->num_rows != 0) {
		?>
		<div style="display:none;">
			<form id="username_fail" method="POST" action="create_user_page.php">
				<input type="hidden" name="new_username" value=" <?php echo $new_username; ?>"/>
				<input type="hidden" name="new_user_type" value="<?php echo $new_user_type; ?>"/>
				<input type="hidden" name="new_admin" value="<?php echo $new_admin; ?>"/>
				<input type="hidden" name="username_error" value="true"/>
				<?php
				?>
			</form>
			<script>
				document.getElementById("username_fail").submit();
			</script>
		</div>
		<?php
	} elseif ($new_password != $confirm_new_password) {
		?>
		<div style="display:none;">
			<form id="password_fail" method="POST" action="create_user_page.php">
				<input type="hidden" name="new_username" value=" <?php echo $new_username; ?>"/>
				<input type="hidden" name="new_user_type" value="<?php echo $new_user_type; ?>"/>
				<input type="hidden" name="new_admin" value="<?php echo $new_admin; ?>"/>
				<input type="hidden" name="password_error" value="true"/>
				<?php
				?>
			</form>
			<script>
				document.getElementById("password_fail").submit();
			</script>
		</div>
		<?php
	}

	if (create_user($conn, $new_username, $new_password, $new_admin, $new_user_type)) {
		$sql = "SELECT user_id FROM user WHERE username = '$new_username'";
		$result = $conn->query($sql);
		$row = $result->fetch_row();
		do_html_header("User Created", "Creation Successful\n User ID: " . $row[0]);
	} else {
		do_html_header("Creation Failed", "Failed to create user");
	}
	do_html_footer();


} else {
	echo "This page cannot be accessed";
}