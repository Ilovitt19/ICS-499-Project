<?php
require_once ('reunion_fns.php');
include('logged_in_user_class.php');
$conn = db_connect();


if (isset($_POST['username']) && isset($_POST['passwd'])) {
	// they have just tried logging in



	if (login($_POST['username'], $_POST['passwd'])) {
		session_start();
		$current_user = new LoggedInUser($_POST['username']);
		$_SESSION['current_user'] = serialize($current_user);
		session_commit();
		if ($current_user->admin === "yes") {
			header('Location: admin_page.php');
			exit();
		} else {
			header('Location: welcome_page.php');
			exit();
		}

	} else {
		// unsuccessful login
        echo "<script language='JavaScript'>alert('Failed to log in');</script>";
        do_html_header("Login"," ");
        session_destroy();
		display_login_form();
		do_html_footer();
		exit();
	}

} else {
	// unsuccessful login

	echo "<script language='JavaScript'>
alert('Failed to log in');
</script>";
	do_html_header("Login"," ");
	session_destroy();
	display_login_form();
	do_html_footer();
	exit();
}

