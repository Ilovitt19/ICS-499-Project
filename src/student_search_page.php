<?php

include ('reunion_fns.php');
include('logged_in_user_class.php');
$conn = db_connect();
do_html_header("Find People","Student Search");
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
		<section id="left_side">
			<form id="generalform" class="container" method="post" action="student_search_page.php">
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
			</br>
			<form id="generalform" class="container" method="post" action="create_user_page.php">
				<h3>Create A New User Here</h3>
				<div class="field">
					<input type="submit" name="create_user" id="create_user" class="button" value="Create User"/>
				</div>
			</form>
		</section>
	</div>

  <?php
  if (isset($_POST['search_performed']) && !search_empty()) {
    $result_list = search_for_students($conn);
    if (!isset($result_list)) {
      echo '<p>No results found.</p>';
      } else {
        foreach ($result_list as $a_row) {
          ?>
		  <div id="wrapper">
			  <section id="right_side">
			  
			  <table>
				<tr>
				  <th>Last Name </th>
				  <th>First Name </th>
				  <th>Grad Year</th>
				  <th></th>
				  <?php
				  if ($admin == 'yes') echo "<th></th><th></th>"
				  ?>
				</tr>
				<tr>
				  <td><?php echo $a_row['last_name']; ?></td>
				  <td><?php echo $a_row['first_name']; ?></td>
				  <td><?php echo $a_row['grad_year']; ?></td>
				  <td>
					<form action="view_user_page.php" method="post">
					  <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
					  <input type="submit" name="view_user" class="button" value="View">
					</form>
				  </td>
				  <?php
				  if ($admin == 'yes') {
					?>
					<td>
					  <form action="edit_user_page.php" method="post">
						<input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
						<input type="submit" name="admin_edit" class="button" value="Edit">
					  </form>
					</td>
					<td>
					  <form action="delete_action.php" method="post">
						<input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
						<input type="hidden" name="delete_type" value="student">
						<input type="submit" name="delete_user" class="button" value="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
					  </form>
					</td>
				  <?php
				  }
				  ?>
				</tr>
			  </table>
			  </section>
		  </div>
        <?php
        }
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
 * @return mixed
 */
function search_for_students($conn) {
  try {
    $sql = 'SELECT first_name, last_name, grad_year, user_id
					FROM students
					WHERE (first_name = ? AND first_name IS NOT NULL)
					OR (last_name = ? AND last_name IS NOT NULL)
					OR (grad_year = ? AND grad_year != 0)';
    $stmt = $conn->stmt_init();
    if (!$stmt->prepare($sql)) {
      echo $stmt->error;
      return false;
    } else
      $rows = array();
      $first_name = $_POST['first_name'];
      $last_name = $_POST['last_name'];
      $grad_year = $_POST['grad_year'];
      $stmt->bind_param('sss', $first_name, $last_name, $grad_year);
      $stmt->execute();
      $stmt->bind_result($f, $l, $g, $i);
      while ($stmt->fetch()) {
        array_push($rows, array('first_name'=>$f, 'last_name'=>$l, 'grad_year'=>$g, 'user_id'=>$i));
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
  return empty($_POST['first_name']) && empty($_POST['last_name']) && empty($_POST['grad_year']);
}
?>
