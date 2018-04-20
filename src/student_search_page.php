<?php

include('reunion_fns.php');
include('logged_in_user_class.php');
$conn = db_connect();
do_html_header("Find People", "Student Search");
if (login_check()) {
	$admin = unserialize($_SESSION['current_user'])->admin;
	?>
	<div id="wrapper">
		<section id="left_side">
			<form id="generalform" class="container_center" method="post" action="student_search_page.php">
				<h3>Enter in Criteria</h3>
				<div class="field">
					<label for="first_name">First Name:</label>
					<input type="text" class="input" id="first_name" name="first_name" maxlength="20"/>
				</div>
				<div class="field">
					<label for="last_name">Last Name:</label>
					<input type="text" class="input" id="last_name" name="last_name" maxlength="20"/>
				</div>
				<div class="field">
					<label for="grad_year">Grad Year:</label>
					<input type="number" class="input" name="grad_year" id="grad_year" min="1991" max="2015">
					<input type="hidden" name="search_performed" value="yes">
				</div>
				<input type="submit" name="search" id="search" class="button" value="Search"/>
			</form>
			<form id="generalform" class="container_center" method="post" action="student_search_page.php">
				<div class="field">
					<input type="submit" name="view_all" id="view_all" class="button" value="View All Students"/>
				</div>
			</form>
		</section>
	</div>

	<?php
	if ((isset($_POST['search_performed']) && !search_empty()) || isset($_POST['view_all'])) {
		$result_list = search_for_students($conn, isset($_POST['view_all']));
		if (!isset($result_list)) {
			echo '<p>No results found.</p>';
		} else { ?>
			<div class="scrollit">
				<section id="right_side">
					<table class="search_result_table">
						<tr>
							<th>Last Name</th>
							<th>First Name</th>
							<th>Grad Year</th>
							<th></th>
							<?php
							if ($admin == 'yes') echo "<th></th><th></th>"
							?>
						</tr>
						<?php foreach ($result_list as $a_row) {
							?>
							<tr>
								<td><?php echo $a_row['last_name']; ?></td>
								<td><?php echo $a_row['first_name']; ?></td>
								<td><?php echo $a_row['grad_year']; ?></td>
								<td>
									<form action="view_user_page.php" method="post">
										<input type="hidden" name="user_id" value="<?php echo $a_row['user_id'] ?>">
										<?php
										if ($admin == 'yes') {
											echo "<input type='hidden' name='admin_search' value='yes'>";
										}
										?>
										<input style="width: 60%; height: 60%;" type="image" name="view_user"
										       src="images/View.png" class="button" value="View">
									</form>
								</td>
								<?php
								if ($admin == 'yes') {
									?>
									<td>
										<form action="edit_user_page.php" method="post">
											<input type="hidden" name="user_id" value="<?php echo $a_row['user_id'] ?>">
											<input style="width: 60%; height: 60%;" type="image" name="admin_edit"
											       src="images/Edit.png" class="button" value="Edit">
										</form>
									</td>
									<td>
										<form action="delete_action.php" method="post">
											<input type="hidden" name="user_id" value="<?php echo $a_row['user_id'] ?>">
											<input type="hidden" name="delete_type" value="student">
											<input style="width: 60%; height: 60%;" type="image" name="delete_user"
											       src="images/Delete.png" class="button" value="Delete"
											       onclick="return confirm('Are you sure you want to delete this user?');">
										</form>
									</td>
									<?php
								}
								?>
							</tr>
							<?php
						}
						?>
					</table>
				</section>
			</div>
			<?php
		}
	}
} else {
	echo "<p>You must be logged in to visit this page.</p>";
}
if (isset($conn)) {
	$conn->close();
}
do_html_footer();

/**
 * @param $conn mysqli - The DB connection
 * @param $view_all - View all users?
 * @return mixed
 */
function search_for_students($conn, $view_all)
{
	try {
		if ($view_all) {
			$sql = 'SELECT first_name, last_name, grad_year, user_id
					FROM students
					WHERE first_name IS NOT NULL
					AND last_name IS NOT NULL
					AND grad_year != 0
					ORDER BY last_name';
			$result = $conn->query($sql);
			$rows = array();
			while ($a_row = $result->fetch_row()) {
				array_push($rows, array('first_name' => $a_row[0], 'last_name' => $a_row[1], 'grad_year' => $a_row[2], 'user_id' => $a_row[3]));
			}
		} else {
			$sql = 'SELECT first_name, last_name, grad_year, user_id
					FROM students
					WHERE (first_name = ? AND first_name IS NOT NULL)
					OR (last_name = ? AND last_name IS NOT NULL)
					OR (grad_year = ? AND grad_year != 0)
					AND (grad_year !=0)
					ORDER BY last_name';
			$stmt = $conn->stmt_init();
			if (!$stmt->prepare($sql)) {
				echo $stmt->error;
				return false;
			} else {
				$rows = array();
				$first_name = $_POST['first_name'];
				$last_name = $_POST['last_name'];
				$grad_year = $_POST['grad_year'];
				$stmt->bind_param('sss', $first_name, $last_name, $grad_year);
				$stmt->execute();
				$stmt->bind_result($f, $l, $g, $i);
				while ($stmt->fetch()) {
					array_push($rows, array('first_name' => $f, 'last_name' => $l, 'grad_year' => $g, 'user_id' => $i));
				}
			}
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	return $rows;
}

/**
 * @return bool
 */
function search_empty()
{
	return empty($_POST['first_name']) && empty($_POST['last_name']) && empty($_POST['grad_year']);
}

