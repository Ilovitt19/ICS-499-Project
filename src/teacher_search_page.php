<?php

include ('reunion_fns.php');
include('logged_in_user_class.php');
$conn = db_connect();
do_html_header("Find People","Teacher Search");
if (login_check()) {
$admin = unserialize($_SESSION['current_user'])->admin;
?>
<html>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="forms.css">
<body>
<?php if (isset($error)) {
  echo "<p>$error</p>";
}
?>
	<div id="wrapper">
		<section id="right_side">
			<form id="generalform" class="container" method="post" action="teacher_search_page.php">
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
					<label for="teach_year">Taught During Year:</label>
  					<input type="number" class="input" name="teach_year" id="teach_year" min="1991" max="2015">
  					<input type="hidden" name="search_performed" value="yes">
				</div>
				<input type="submit" name="search" id="search" class="button" value="Search"/>
			</form>
      <form id="generalform" class="container" method="post" action="teacher_search_page.php">
        <div class="field">
          <input type="submit" name="view_all" id="view_all" class="button" value="View All Teachers"/>
        </div>
      </form>
		</section>
	</div>

<?php
if ((isset($_POST['search_performed']) && !search_empty()) || isset($_POST['view_all'])) {
  $result_list = search_for_teachers($conn, isset($_POST['view_all']));
  if (!isset($result_list)) {
    echo '<p>No results found.</p>';
  } else { ?>
	<div class="scrollit">
	  <section id="left_side">
      <table>
        <tr>
          <th>Last Name </th>
          <th>First Name </th>
          <th>Start Year</th>
          <th>End Year</th>
          <th></th>
          <?php
          if ($admin == 'yes') echo "<th></th><th></th>"
          ?>
        </tr>
	<?php
    foreach ($result_list as $a_row) {
      ?>
        <tr>
          <td><?php echo $a_row['last_name']; ?></td>
          <td><?php echo $a_row['first_name']; ?></td>
          <td><?php echo $a_row['start_year']; ?></td>
          <td><?php echo $a_row['end_year']; ?></td>
          <td>
            <form action="view_user_page.php" method="post">
              <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
              <input type="hidden" name="teacher_result" value="yes">
              <input type="image" name="view_user" src ="images/View.png" class="button" value="View">
            </form>
          </td>
          <?php
          if ($admin == 'yes') {
            ?>
            <td>
              <form action="edit_user_page.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
                <input type="image" name="admin_edit" src ="images/Edit.png" class="button" value="Edit">
              </form>
            </td>
            <td>
              <form action="delete_action.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
                <input type="hidden" name="delete_type" value="teacher">
                <input type="image" name="delete_user" src="images/Delete.png" class="button" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
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
echo "</body>";
echo "</html>";
if (isset($conn)) {
  $conn->close();
}
?>

<?php
/**
 * @param $conn mysqli - The DB connection
 * @param $view_all - View all users?
 * @return mixed
 */
function search_for_teachers($conn, $view_all) {
  try {
    if ($view_all) {
      $sql = 'SELECT first_name, last_name, start_year, end_year, user_id
					FROM teachers
					WHERE first_name IS NOT NULL
					AND last_name IS NOT NULL
					AND start_year != 0
					ORDER BY last_name';
      $result = $conn->query($sql);
      $rows = array();
      while ($a_row = $result->fetch_row()) {
        array_push($rows, array('first_name' => $a_row[0], 'last_name' => $a_row[1], 'start_year' => $a_row[2], 'end_year' => $a_row[3], 'user_id' => $a_row[4]));
      }
    } else {
      $sql = 'SELECT first_name, last_name, start_year, end_year, user_id
					FROM teachers
					WHERE (first_name = ? AND first_name IS NOT NULL)
					OR (last_name = ? AND last_name IS NOT NULL)
					OR (start_year <= ? AND end_year >= ? AND start_year != 0)
					ORDER BY last_name';
      $stmt = $conn->stmt_init();
      if (!$stmt->prepare($sql)) {
        echo $stmt->error;
        return false;
      } else {
        $rows = array();
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $teach_year = $_POST['teach_year'];
        $stmt->bind_param('ssii', $first_name, $last_name, $teach_year, $teach_year);
        $stmt->execute();
        $stmt->bind_result($f, $l, $s, $e, $i);
        while ($stmt->fetch()) {
          array_push($rows, array('first_name' => $f, 'last_name' => $l, 'start_year' => $s, 'end_year' => $e, 'user_id' => $i));
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
function search_empty() {
  return empty($_POST['first_name']) && empty($_POST['last_name']) && empty($_POST['teach_year']);
}
?>
