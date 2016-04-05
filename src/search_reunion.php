

<?php
//search_for_students();
function search_for_students(){
	$result = db_connect();
	if(isset($_GET['search'])){

		
		try{
			//require_once 'db_fns.php';
			
			$sql = 'SELECT first_name, last_name, grad_year, email
					FROM students
					WHERE (first_name = ? )
					OR (last_name LIKE ? )
					OR (grad_year = ?)
					ORDER BY last_name';
			$stmt = $result->stmt_init();
			if(!$stmt->prepare($sql)){
				$error = $stmt->error;
			} else {
				$stmt->bind_param('ssi', $first_name, $last_name, $_GET['grad_year']);
				$first_name = $_GET['first_name'];
				$last_name = '%'. $_GET['last_name'] . '%';
				//$stmt->bind_param('ss', $f_name, $l_name);
				$stmt->execute();
				$stmt->bind_result($f_name, $l_name, $year, $contact_info);
			}
			
		} catch(Exception $e){
			$error = $e->getMessage();
		}
		
		
	}
	?>
	
	<link rel="stylesheet" href="styles.css">
	<body>
	<?php if (isset($error)) {
		echo "<p>$error</p>";
	} ?>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<fieldset>
			<legend>Search For Students</legend>
		<p>
			<label for="first_name">First Name: </label>
			<input type="text" name="first_name" id="first_name">
			<label for="last_name">Last Name: </label>
			<input type="text" name="last_name" id="last_name">
			<label for="grad_year">Grad Year: </label>
			<input type="text" name="grad_year" id="grad_year">
			
			<!--<select name="grad_year" id="grad_year">
			<option>Year</option> -->
				<?php //for ($y = 1991; $y <= 2016; $y+=1) {
					//echo "<option>$y</option>";
			   // } ?>
		   <!-- </select> -->
			
			<input type="submit" name="search" value="Search">
		</p>
		</fieldset>
	</form>


	<?php

	if (isset($_GET['search'])) {
		$stmt->store_result();
		$numrows = $stmt->num_rows;
		if (!$numrows) {
			echo '<p>No results found.</p>';
		} else {
			?>
			<table>
				<tr>
					<th>Last Name </th>
					<th>First Name </th>
					<th>Grad Year</th>
					<th>Email<h> 
				</tr>
				<?php while ($stmt->fetch()) { ?>
					<tr>
						<td><?php echo $l_name; ?></td>
						<td><?php echo $f_name; ?></td>
						<td><?php echo $year; ?></td>
						<td><?php echo $contact_info; ?></td>
					</tr>
				<?php }  ?>
			</table>
		<?php }
	}
	if (isset($result)) {
		$result->close();
	}
	?>
	</body>
	</html>
<?php
}
?>