<?php
require_once('db_fns.php');

function do_html_header($title = '', $section = '')
{
//Title of the page being created
	?>
	<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
	<div id="container">
	<div id="header">
		<h1><img src="images/wildcat-logo-small.png" class="imgFlipped" height="80px" width="80px">Village High School
			Reunion<img src="images/wildcat-logo-small.png" height="80px" width="80px"></h1>
		<div id="topnavBar" class="topnavMenu">
			<ul class="navbar">
				<?php
				if (isset($_SESSION['current_user'])) {
					$current_user = unserialize($_SESSION['current_user']);
					echo "<li><a class = 'nav' title='Welcome' href='welcome_page.php'>HOME</a></li>";
				} else {
					echo "<li><a class = 'nav' title='Home' href='index.php'>HOME</a></li>";
				}

				if (isset($current_user)) {
					echo "<li><a class='nav' title='Student Search' href='student_search_page.php'>STUDENT SEARCH</a></li>";
					echo "<li><a class='nav' title='Teacher Search' href='teacher_search_page.php'>TEACHER SEARCH</a></li>";
					echo "<li><a class = 'nav-right' title='Logout' href='login_page.php'>LOGOUT</a></li>";
					if (isset($current_user) && isset($current_user->first_name)) {
						echo "<li><a class = 'nav-right' title='Welcome' href='view_user_page.php'>" . strtoupper($current_user->first_name) . " " . strtoupper($current_user->last_name) . "</a></li>";
					} else {
						echo "<li><a class = 'nav-right' title='Welcome' href='view_user_page.php'>MY PROFILE</a></li>";
					}
				} else {
					echo "<li><a class = 'nav-right' title='Login' href='login_page.php'>LOGIN</a></li>";
				}
				if (isset($current_user) && $current_user->admin == 'yes') {
					?>
					<li><a class='nav-right' title='Admin' href='admin_page.php'>ADMIN REPORTS</a></li>
					<li><a class='nav' title='Create' href='create_user_page.php'>CREATE USER</a></li>
					<li><a class='nav-right' title='Export Database' href='backup_database.php'>EXPORT DATABASE</a></li>
					<li>
						<a class='nav-right' title='Import Database' onclick="MyFunction()">IMPORT DATABASE</a>
					</li>
					<?php
				}
				?>
			</ul>
			<form action='import_database.php' id="upload_form" enctype='multipart/form-data' method='post'
			      style="visibility: hidden">
				<input id='excelupload' name='excelupload' type='file' style="visibility: hidden"/>
				<script>
					document.getElementById("excelupload").onchange = function () {
						document.getElementById("upload_form").submit();
					};

					function MyFunction() {
						document.getElementById("excelupload").click();
					}
				</script>
			</form>
		</div>
	</div>

	<div id="body">
	<?php
	if ($section) {
		do_html_heading($section);
	}
}

function show_event_info()
{
	?>
	<div id="info">
		<img src="images/Hilton.jpg">
		<p>Saturday June 1st, 2016<br>Hilton Hotel<br>Minneapolis, Minnesota</p><br>
		<p><a href="https://www.google.com/maps/place/Hilton+Minneapolis/@44.9725457,-93.27
    50422,17z/data=!3m1!4b1!4m2!3m1!1s0x52b3329636a6b7f5:0x4f9e989c1a078a2" target="_blank">Map & Directions</a></p>
	</div>
	<?php
}

function do_html_footer()
{
	// print an HTML footer
	?>
	</div>
	<div id="footer">
		<div class="footer_text">Questions? Need to register? Interested in Donating?</div>
		<div class="footer_text">Contact an Administrator Here:</div>
		<a class="footer_link_text" href="mailto:web_admin@villagehigh.edu?Subject=Request%20Account">
			web_admin@villagehigh.edu</a>
		<br><br>
		&copy; 2016 Aligators ICS 499
	</div>
	</div>
	</body>
	</html>
	<?php
}

function do_html_URL($url, $name)
{
	// output URL as link and br
	?>
	<a href="<?php echo $url; ?>"><?php echo $name; ?></a><br/>
	<?php
}


function do_html_heading($heading)
{
	// print heading
	?>
	<h1 class="heading"><?php echo $heading; ?></h1>
	<?php
}


function display_login_form()
{
	if (isset($_POST['db_imported'])) {
		echo "<h4>Database imported successfuly, please log in again</h4>";
	}
	?>
	<div id="wrapper">
		<aside id="left_side">
			<img src="images/loginbanner.png"/>
		</aside>
		<section id="rigt_side">
			<form id="generalform" class="container_center" method="POST" action="login_action.php">
				<h3>Log In</h3>
				<?php //echo @$error_message; ?>
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" class="input" id="username" name="username" maxlength="20"/>
				</div>
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" class="input" id="password" name="passwd" maxlength="20"/>
				</div>
				<input type="submit" name="submit" id="submit" class="button" value="Submit"/>
			</form>
		</section>
	</div>

	<?php
}

function display_logged_out()
{
	?>
	<div id=wrapper">
		<aside id="left_side">
			<img src="images/loggedout.png"/>
		</aside>
		<section id="right_side">
		</section>
	</div>
	<?php
}

function create_database()
{
	include_once('create_database.php');
}

function do_edit_info_form()
{
	$admin_self = false;
	if (isset($_POST['admin_edit'])) {
		$username = get_username_by_id($_POST['user_id']);
		$current_user = new LoggedInUser($username);
	} else {
		$current_user = unserialize($_SESSION['current_user']);
		$admin_self = $current_user->admin == "yes";
	}

	?>
	<div id="ProfilePage">
		<div id="LeftCol">

			<div id="generalformphoto" class="photoContainer">
				<?php display_photo($current_user, "edit_mode"); ?>
			</div>
		</div>
		<div id="infoForm">
			<form id="generalform" class="container" action="update_info_action.php" method="post">
				<?php
				if (isset($_POST['admin_edit'])) {
					echo "<input type = \"hidden\" name='admin_edit' value='yes'>";
					echo "<input type = \"hidden\" name='user_id' value='" . $_POST['user_id'] . "'>";
				}
				?>
				<table>
					<tr>
						<td width="150"></td>
						<td width="200"></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Attending Reunion:</label></td>
						<?php
						if ($current_user->attending === "yes") {
							echo "<td align='left'><input type='radio' name='attending'  title='Attending' value='no'/>No";
							echo "<input type='radio' name='attending' value='yes' checked/>Yes";
						} else {
							echo "<td align='left'><input type='radio' name='attending'  title='Attending' value='no' checked/>No";
							echo "<input type='radio' name='attending' value='yes'/>Yes";
						}
						echo "<td>"
						?>
					</tr>
					<tr>
						<td><label class="info_form_label">First Name:</label></td>
						<td align="left"><input type="text" name="first_name" title="First Name" size="30"
						                        maxlength="40" value="<?php echo $current_user->first_name; ?>"
						                        required/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Last Name:</label></td>
						<td align="left"><input type="text" name="last_name" title="Last Name" size="30" maxlength="40"
						                        value="<?php echo $current_user->last_name; ?>" required/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Nickname:</label></td>
						<td align="left"><input type="text" name="nickname" title=" Nickname" size="30" maxlength="40"
						                        value="<?php echo $current_user->nickname; ?>"/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Email:</label></td>
						<td align="left"><input type="text" name="email" title="Email" size="30" maxlength="40"
						                        value="<?php echo $current_user->email; ?>" required/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Phone:</label></td>
						<td align="left"><input type="text" name="phone" title="phone" size="30" maxlength="40"
						                        value="<?php echo $current_user->phone; ?>"/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Street Address:</label></td>
						<td align="left"><input type="text" name="street" title="Title" size="30" maxlength="40"
						                        value="<?php echo $current_user->street; ?>"/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">City:</label></td>
						<td align="left"><input type="text" name="city" title="City" size="30" maxlength="40"
						                        value="<?php echo $current_user->city; ?>"/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">State:</label></td>
						<td align="left">
							<select name="state" title="State">
								<option></option>
								<optgroup label="USA">
									<option selected><?php echo $current_user->state; ?></option>
									<option value="AL">Alabama (AL)</option>
									<option value="AK">Alaska (AK)</option>
									<option value="AZ">Arizona (AZ)</option>
									<option value="AR">Arkansas (AR)</option>
									<option value="CA">California (CA)</option>
									<option value="CO">Colorado (CO)</option>
									<option value="CT">Connecticut (CT)</option>
									<option value="DE">Delaware (DE)</option>
									<option value="FL">Florida (FL)</option>
									<option value="GA">Georgia (GA)</option>
									<option value="HI">Hawaii (HI)</option>
									<option value="ID">Idaho (ID)</option>
									<option value="IL">Illinois (IL)</option>
									<option value="IN">Indiana (IN)</option>
									<option value="IA">Iowa (IA)</option>
									<option value="KS">Kansas (KS)</option>
									<option value="KY">Kentucky (KY)</option>
									<option value="LA">Louisiana (LA)</option>
									<option value="ME">Maine (ME)</option>
									<option value="MD">Maryland (MD)</option>
									<option value="MA">Massachusetts (MA)</option>
									<option value="MI">Michigan (MI)</option>
									<option value="MN">Minnesota (MN)</option>
									<option value="MS">Mississippi (MS)</option>
									<option value="MO">Missouri (MO)</option>
									<option value="MT">Montana (MT)</option>
									<option value="NE">Nebraska (NE)</option>
									<option value="NV">Nevada (NV)</option>
									<option value="NH">New Hampshire (NH)</option>
									<option value="NJ">New Jersey (NJ)</option>
									<option value="NM">New Mexico (NM)</option>
									<option value="NY">New York (NY)</option>
									<option value="NC">North Carolina (NC)</option>
									<option value="ND">North Dakota (ND)</option>
									<option value="OH">Ohio (OH)</option>
									<option value="OK">Oklahoma (OK)</option>
									<option value="OR">Oregon (OR)</option>
									<option value="PA">Pennsylvania (PA)</option>
									<option value="RI">Rhode Island (RI)</option>
									<option value="SC">South Carolina (SC)</option>
									<option value="SD">South Dakota (SD)</option>
									<option value="YN">Tennessee (TN)</option>
									<option value="TX">Texas (TX)</option>
									<option value="UT">Utah (UT)</option>
									<option value="VT">Vermont (VT)</option>
									<option value="VA">Virginia (VA)</option>
									<option value="WA">Washington (WA)</option>
									<option value="WV">West Virginia (WV)</option>
									<option value="WI">Wisconsin (WI)</option>
									<option value="WY">Wyoming (WY)</option>
								</optgroup>
								<optgroup label="Canada">
									<option value="AB">Alberta (AB)</option>
									<option value="BC">British Columbia (BC)</option>
									<option value="MB">Manitoba (MB)</option>
									<option value="NB">New Brunswick (NB)</option>
									<option value="NL">New Foundland (NL)</option>
									<option value="NS">Nova Scotia (NS)</option>
									<option value="ON">Ontario (ON)</option>
									<option value="PE">Prince Edward Island (PE)</option>
									<option value="QC">Quebec (QC)</option>
									<option value="SL">Saskatchewan (SL)</option>
								</optgroup>
							</select>
						</td>
					</tr>
					<tr>
						<td><label class="info_form_label">Zip Code:</label></td>
						<td align="left"><input type="text" name="zip" title="Zip" size="5" maxlength="5"
						                        value="<?php echo !empty($current_user->zip) ? $current_user->zip : "" ?>"/>
						</td>
					</tr>
					<?php
					$current_user->user_type == 'student' ? edit_student_year($current_user->grad_year)
						: edit_teacher_year($current_user->start_year, $current_user->end_year);
					?>

					<tr>
						<td><label class="info_form_label">Father's Name:</label></td>
						<td align="left"><input type="text" name="father_name" title="Fathers Name" size="30"
						                        maxlength="40" value="<?php echo $current_user->father_name; ?>"/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Mother's Name:</label></td>
						<td align="left"><input type="text" name="mother_name" title="Mothers Name" size="30"
						                        maxlength="40" value="<?php echo $current_user->mother_name; ?>"/></td>
					</tr>
					<tr>
					<tr>
						<td><label class="info_form_label">Family Details:</label></td>
						<td align="left"><input type="text" name="family_details" title="Family Details" size="30"
						                        maxlength="40" value="<?php echo $current_user->family_details; ?>"/>
						</td>
					</tr>
					<tr>
						<td><label class="info_form_label">Work Experience:</label></td>
						<td align="left"><textarea name="work_experience" title="Work Experience" rows="3" cols="30"
						                           maxlength="200"><?php echo $current_user->work_experience; ?></textarea>
						</td>
					</tr>
					<tr>
						<td><label class="info_form_label">Awards:</label></td>
						<td align="left"><textarea name="awards" title="Awards" rows="3" cols="30"
						                           maxlength="200"><?php echo $current_user->awards; ?></textarea></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Notes:</label></td>
						<td align="left"><textarea name="notes" title="Notes" rows="3" cols="30"
						                           maxlength="200"><?php echo $current_user->notes; ?></textarea></td>
					</tr>
					<?php
					if (isset($_POST['admin_edit']) || $admin_self) {
						?>
						<tr>
							<td><label class="info_form_label">Donations ($)</label></td>
							<td align="left"><input type="text" name="donations" title="Donations" rows="3" cols="30"
							                        maxlength="10" value="<?php echo $current_user->donations; ?>"></td>
						</tr>
						<?php
					}
					?>
					<tr>
						<td></td>
						<td><input type="submit" class="button" value="Save"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>

	<?php
}

function edit_student_year($grad_year)
{
	?>
	<tr>
		<td><label class="info_form_label" for="user_type">Type:</label></td>
		<td align="left"><input type="text" name="user_type" title="User Type" size="30" maxlength="40" value="Student"
		                        readonly/></td>
	</tr>
	<tr>
		<td><label class="info_form_label" for="grad_year">Graduation Year (Student):</label></td>
		<td align="left">
			<select name="grad_year" title="Grad Year" required>
				<?php
				if (!empty($grad_year)) echo "<option selected>" . $grad_year . "</option>";
				?>
				<optgroup label="Year">
					<option value="2015">2015</option>
					<option value="2014">2014</option>
					<option value="2013">2013</option>
					<option value="2012">2012</option>
					<option value="2011">2011</option>
					<option value="2010">2010</option>
					<option value="2009">2009</option>
					<option value="2008">2008</option>
					<option value="2007">2007</option>
					<option value="2006">2006</option>
					<option value="2005">2005</option>
					<option value="2004">2004</option>
					<option value="2003">2003</option>
					<option value="2002">2002</option>
					<option value="2001">2001</option>
					<option value="2000">2000</option>
					<option value="1999">1999</option>
					<option value="1998">1998</option>
					<option value="1997">1997</option>
					<option value="1996">1996</option>
					<option value="1995">1995</option>
					<option value="1994">1994</option>
					<option value="1993">1993</option>
					<option value="1992">1992</option>
					<option value="1991">1991</option>
				</optgroup>
			</select>
		</td>
	</tr>
	<?php
}

function edit_teacher_year($start_year, $end_year)
{
	?>
	<tr>
		<td><label class="info_form_label" for="user_type">Type:</label></td>
		<td align="left"><input type="text" name="user_type" title="User Type" size="30" maxlength="40" value="Teacher"
		                        readonly/></td>
	</tr>
	<tr>
		<td><label class="info_form_label" for="grad_year">Years Taught (Teacher):</label></td>
		<td align="left"><input type="text" name="start_year" title="Start Year" size="4" maxlength="4" width="4"
		                        value="<?php echo $start_year; ?>" required/> <label class="info_form_label">to</label>
			<input type="text" name="end_year" title="End Year" size="4" maxlength="4" width="4"
			       value="<?php echo $end_year; ?>" required/></td>
	</tr>
	<?php
}

function upload_photo()
{
	?>
	<form action="upload_photo_action.php" method="post" enctype="multipart/form-data">
		Select profile picture to upload:<br><br>
		<input type="file" name="fileToUpload""><br><br>
		<input type="submit" value="Upload Image" class="button" name="submit"><br>
		<?php
		if (isset($_POST['admin_edit'])) {
			echo "<input type = \"hidden\" name='admin_edit' value='yes'>";
			echo "<input type = \"hidden\" name='user_id' value='" . $_POST['user_id'] . "'>";
		}
		?>
	</form>
	<?php
}

function display_photo($current_user, $mode)
{
	if ($current_user->photo == !NULL) {
		echo "<img class='photo' src='$current_user->photo' align='middle'><br>";
	} else {
		echo "<img class='photo' src='images/Profile_0.jpg' align='middle'><br>";
	}
	if ($mode == "edit_mode") {
		upload_photo();
	}
}


function scroll()
{

	?>
	<h2>Students and Teachers</h2>
	<div id="scroll_container">
		<?php
		//gets list of photos from folder  alphabetically
		$dir = scandir("images/Photos");
		//build the html output
		$html = '<div class="photobanner">';
		$counter = 0;
		//remove directory markers '.' and '..' which are the first two elements in the array
		unset($dir[0]);
		unset($dir[1]);
		//randomize photos
		shuffle($dir);
		//the 'first' photo below starts the animation the rest follow
		$html .= '<img class="first" src = "images/Photos/' . $dir[0] . '" alt = "" />';
		foreach ($dir as $photo) {
			if ($counter++ >= 1) {
				$html .= '<img class="photo" src = "images/Photos/' . $photo . '" alt = "" />';
			}
		}
		//reset counter
		$counter = 0;
		//another loop needed to add 6 photos to the end so there is no gap in the scroll
		foreach ($dir as $photo) {
			if ($counter++ <= 5) {
				$html .= '<img class="photo" src = "images/Photos/' . $photo . '" alt = "" />';
			}
		}
		$html .= '</div>';
		echo $html;
		?>
	</div>
	<?php
}

function do_back_button($destination_page, $button_title)
{
	?>
	<div id="wrapper">
		<section id="left_side">
			<form action="<?php echo $destination_page ?>" method="post">
				<input type="submit" class="button" name="back_button" value="<?php echo $button_title ?>">
			</form>
		</section>
	</div>

	<?php
}

function do_user_create_form()
{
	?>
	<div id="wrapper_centered">
		<form id="create_form" action="create_action.php" method="post">
			<?php
			if (isset($_POST['username_error'])) {
				echo "<h3>Error: Username already exists!</h3>";
			} elseif (isset($_POST['password_error'])) {
				echo "<h3>Error: Passwords do not match</h3>";
			}
			?>
			<table>
				<tr>
					<td><label>Username:</label></td>
					<td align="left"><input type="text" name="new_username" size="30" maxlength="40"
					                        value="<?php echo isset($_POST['new_username']) ? $_POST['new_username'] : ""; ?>"
					                        required/></td>
				</tr>
				<tr>
					<td><label>Password:</label></td>
					<td align="left"><input type="password" name="new_password" size="30" maxlength="40"
					                        value="<?php echo isset($_POST['new_password']) ? $_POST['new_password'] : ""; ?>"
					                        required/></td>
				</tr>
				<tr>
					<td><label>Confirm Password:</label></td>
					<td align="left"><input type="password" name="confirm_new_password" size="30" maxlength="40"
					                        value="<?php echo isset($_POST['confirm_new_password']) ? $_POST['confirm_new_password'] : ""; ?>"
					                        required/></td>
				</tr>
				<tr>
					<td><label>User Type:</label></td>
					<?php
					if (isset($_POST['new_user_type']) && $_POST['new_user_type'] == 'student') {
						echo "<td align='left'><input type='radio' name='new_user_type' value='teacher'/> Teacher  ";
						echo "<br>";
						echo "<input type='radio' name='new_user_type' value='student' checked/> Student  ";
					} else {
						echo "<td align='left'><input type='radio' name='new_user_type' value='teacher' checked/> Teacher  ";
						echo "<br>";
						echo "<input type='radio' name='new_user_type' value='student'/> Student  ";
					}
					echo "<td>"
					?>
				</tr>
				<tr>
					<td><label>Admin User:</label></td>
					<?php
					if (isset($_POST['new_admin']) && $_POST['new_admin'] == 'yes') {
						echo "<td align='left'><input type='radio' name='new_admin' value='no'/> No  ";
						echo "<br>";
						echo "<input type='radio' name='new_admin' value='yes' checked/> Yes  ";
					} else {
						echo "<td align='left'><input type='radio' name='new_admin' value='no' checked/> No  ";
						echo "<br>";
						echo "<input type='radio' name='new_admin' value='yes'/> Yes  ";
					}
					echo "<td>"
					?>
				</tr>
			</table>
			<input type="submit" name="submit" class="button" value="Create">
		</form>
	</div>


	<?php
}

function do_view_info_form()
{
	$admin_self = false;
	if (isset($_POST['view_user']) || isset($_POST['admin_view'])) {
		$username = get_username_by_id($_POST['user_id']);
		$current_user = new LoggedInUser($username);
	} else {
		$current_user = unserialize($_SESSION['current_user']);
		$admin_self = $current_user->admin == "yes";
	}

	?>
	<div id="ProfilePage">
		<div id="LeftCol">
			<div id="generalformphoto" class="photoContainer">
				<?php display_photo($current_user, "view_mode"); ?>
			</div>
		</div>
		<div id="infoForm">
			<form id="generalform" class="container" method="post">
				<table>
					<tr>
						<td width="150"></td>
						<td width="200"></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Attending Reunion:</label></td>
						<td align='left'><input type='text' name='attending' title='Attending'
						                        value='<?php echo $current_user->attending; ?>' readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">First Name:</label></td>
						<td align="left"><input type="text" name="first_name" title="First Name" size="30"
						                        maxlength="40" value="<?php echo $current_user->first_name; ?>"
						                        readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Last Name:</label></td>
						<td align="left"><input type="text" name="last_name" title="Last Name" size="30" maxlength="40"
						                        value="<?php echo $current_user->last_name; ?>" readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Nickname:</label></td>
						<td align="left"><input type="text" name="nickname" title=" Nickname" size="30" maxlength="40"
						                        value="<?php echo $current_user->nickname; ?>" readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Email:</label></td>
						<td align="left"><input type="text" name="email" title="Email" size="30" maxlength="40"
						                        value="<?php echo $current_user->email; ?>" readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Phone:</label></td>
						<td align="left"><input type="text" name="phone" title="phone" size="30" maxlength="40"
						                        value="<?php echo $current_user->phone; ?>" readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Street Address:</label></td>
						<td align="left"><input type="text" name="street" title="Title" size="30" maxlength="40"
						                        value="<?php echo $current_user->street; ?>" readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">City:</label></td>
						<td align="left"><input type="text" name="city" title="City" size="30" maxlength="40"
						                        value="<?php echo $current_user->city; ?>" readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">State:</label></td>
						<td align="left">
							<input type="text" name="state" title="State" value="<?php echo $current_user->state; ?>"
							       readonly></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Zip Code:</label></td>
						<td align="left"><input type="text" name="zip" title="Zip" size="5" maxlength="5"
						                        value="<?php echo !empty($current_user->zip) ? $current_user->zip : "" ?>"
						                        readonly/></td>
					</tr>
					<?php
					$current_user->user_type == 'student' ? view_student_year($current_user->grad_year)
						: view_teacher_year($current_user->start_year, $current_user->end_year);
					?>

					<tr>
						<td><label class="info_form_label">Father's Name:</label></td>
						<td align="left"><input type="text" name="father_name" title="Fathers Name" size="30"
						                        maxlength="40" value="<?php echo $current_user->father_name; ?>"
						                        readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Mother's Name:</label></td>
						<td align="left"><input type="text" name="mother_name" title="Mothers Name" size="30"
						                        maxlength="40" value="<?php echo $current_user->mother_name; ?>"
						                        readonly/></td>
					</tr>
					<tr>
					<tr>
						<td><label class="info_form_label">Family Details:</label></td>
						<td align="left"><input type="text" name="family_details" title="Family Details" size="30"
						                        maxlength="40" value="<?php echo $current_user->family_details; ?>"
						                        readonly/></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Work Experience:</label></td>
						<td align="left"><textarea name="work_experience" title="Work Experience" rows="3" cols="30"
						                           maxlength="200"
						                           readonly><?php echo $current_user->work_experience; ?></textarea>
						</td>
					</tr>
					<tr>
						<td><label class="info_form_label">Awards:</label></td>
						<td align="left"><textarea name="awards" title="Awards" rows="3" cols="30" maxlength="200"
						                           readonly><?php echo $current_user->awards; ?></textarea></td>
					</tr>
					<tr>
						<td><label class="info_form_label">Notes:</label></td>
						<td align="left"><textarea name="notes" title="Notes" rows="3" cols="30" maxlength="200"
						                           readonly><?php echo $current_user->notes; ?></textarea></td>
					</tr>
					<?php
					if (isset($_POST['admin_view']) || $admin_self || isset($_POST['admin_search'])) {
						?>
						<tr>
							<td><label class="info_form_label">Donations ($)</label></td>
							<td align="left"><input type="text" name="donations" title="Donations" rows="3" cols="30"
							                        maxlength="10" value="<?php echo $current_user->donations; ?>"
							                        readonly></td>
						</tr>
						<?php
					}
					?>
				</table>
			</form>
			<?php
			if (!isset($_POST['info_update']) && !isset($_POST['admin_view']) && !isset($_POST['view_user'])) {
				do_edit_button();
			}
			?>
		</div>
	</div>

	<?php
}

function view_teacher_year($start_year, $end_year)
{
	?>
	<tr>
		<td><label class="info_form_label" for="user_type">Type:</label></td>
		<td align="left"><input type="text" name="user_type" title="User Type" size="30" maxlength="40" value="Teacher"
		                        readonly/></td>
	</tr>
	<tr>
		<td><label class="info_form_label" for="grad_year">Years Taught (Teacher):</label></td>
		<td align="left"><input type="text" name="start_year" title="Start Year" size="4" maxlength="4" width="4"
		                        value="<?php echo $start_year; ?>" readonly/> <label class="info_form_label">to</label>
			<input type="text" name="end_year" title="End Year" size="4" maxlength="4" width="4"
			       value="<?php echo $end_year; ?>" readonly/></td>
	</tr>
	<?php
}

function view_student_year($grad_year)
{
	?>
	<tr>
		<td><label class="info_form_label" for="user_type">Type:</label></td>
		<td align="left"><input type="text" name="user_type" title="User Type" size="30" maxlength="40" value="Student"
		                        readonly/></td>
	</tr>
	<tr>
		<td><label class="info_form_label" for="grad_year">Graduation Year (Student):</label></td>
		<td align="left">
			<input type="text" name="grad_year" title="Grad Year" value="<?php echo $grad_year; ?>" readonly></td>
	</tr>
	<?php
}

function do_edit_button()
{
	?>
	<form action="edit_user_page.php" method="post">
		<input type="submit" name="user_edit" class="button" value="Edit Your Info">
	</form>
	<?php
}