<?php

include ('reunion_fns.php');
include ('LoggedInUser.php');
$conn = db_connect();
do_html_header("Find People","Student Search");
if (login_check()) {
$admin = unserialize($_SESSION['current_user'])->admin;
?>
  <html>
  <link rel="stylesheet" href="styles.css">
  <body>
  <?php if (isset($error)) {
    echo "<p>$error</p>";
  }
  ?>
  <br>
  <br>
  <form method="post" action="student_search.php">
    <fieldset>
      <p>
        <label for="first_name">First Name: </label>
        <input type="text" name="first_name" id="first_name">
        <label for="last_name">Last Name: </label>
        <input type="text" name="last_name" id="last_name">
        <label for="grad_year">Grad Year: </label>
        <input type="number" name="grad_year" id="grad_year" min = "1991" max="2015">
        <input type="hidden" name="search_performed" value="yes">

        <input type="submit" name="search" value="Search">
      </p>
    </fieldset>
  </form>

  <?php
  if (isset($_POST['search_performed']) && !search_empty()) {
    $result_list = search_for_students($conn);
    if (!isset($result_list)) {
      echo '<p>No results found.</p>';
      } else {
        foreach ($result_list as $a_row) {
          ?>
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
                <form action="view_user.php" method="post">
                  <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
                  <input type="submit" name="view_user" value="View">
                </form>
              </td>
              <?php
              if ($admin == 'yes') {
                ?>
                <td>
                  <form action="UserInfo.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
                    <input type="submit" name="admin_edit" value="Edit">
                  </form>
                </td>
                <td>
                  <form action="delete_action.php" method="post">
                    <input type="hidden" name="user_id" value="<?php echo $a_row['user_id']?>">
                    <input type="submit" name="delete_user" value="Delete">
                  </form>
                </td>
              <?php
              }
              ?>
            </tr>
          </table>
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
