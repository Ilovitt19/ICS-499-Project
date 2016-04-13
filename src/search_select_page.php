<?php

include ('reunion_fns.php');
include('logged_in_user_class.php');
do_html_header("Find People","Select Search Type");
if (login_check()) {
?>
<html>
	<link rel="stylesheet" href="forms.css">
	<link rel="stylesheet" href="list.css">
<body>
	<div id="wrapper">
		<aside id="left_side">
			<img src="images/search_logo.png"/>
		</aside>
		<section id="right_side">
			<form id="generalform" class="container">
			<h3>Choose Search</h3>
				<ul>
					<li><a class="a" href="student_search_page.php">Students</a><li>
					<li><a class="a" href="teacher_search_page.php">Teachers</a><li>
				<ul>
			</form>
		<section>	
	</div>
</body>

<?php
} else {
  echo "<p>You must be logged in to visit this page.</p>";
}
echo "</body>";
echo "</html>";
