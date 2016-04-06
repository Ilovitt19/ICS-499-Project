<?php

function do_html_header($title = '',$section = '')
{
//Title of the page being cra
  ?>
  <html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>
  <body>
	<h1><img src="images/wildcat-logo-small.png" class="imgFlipped" height="80px" width="80px">Village High School Reunion<img src="images/wildcat-logo-small.png" height="80px" width="80px"></h1>
  <div id="topnavBar" class="topnavMenu">
  <ul class="navbar">
    <?php
    if (isset($_SESSION['admin_user']) || isset($_SESSION['user'])) {
	    get_user_data();
    echo "<li><a class = 'nav' title='Welcome' href='welcome.php'>HOME</a></li>";
    } else {
    echo "<li><a class = 'nav' title='Home' href='index.php'>HOME</a></li>";
    }

    if ((isset($_SESSION['admin_user']) || isset($_SESSION['user'])) && isset($_SESSION['first_name'])){
		  echo "<li><a class = 'nav' title='Welcome' href='UserInfo.php'>" . strtoupper ($_SESSION['first_name']) . " " . strtoupper ($_SESSION['last_name']) . "</a></li>";
    } else {
		  echo "<li><a class = 'nav' title='Welcome' href='UserInfo.php'>MY PROFILE</a></li>";
    }
	  ?>
  <li><a class="nav" title="Find People" href="Search.php">FIND PEOPLE</a></li>
  <?php
  /*
   * To hide navbar buttons if user is not logged in
   *
   *
   *if (login_check() == 'true') {
   *  echo "<li><a class='nav' title='Profile' href='UserInfo.php'>MY PROFILE</a></li>";
   *  echo "<li><a class='nav' title='Find People' href='Search.php'>FIND PEOPLE</a></li>";
   *}
   */
  if (isset($_SESSION['admin_user'])) {
    echo "<li><a class = 'nav-right' title='Admin' href='admin.php'>ADMIN</a></li>";
  }

  if (isset($_SESSION['admin_user']) || isset($_SESSION['user'])) {
    echo "<li><a class = 'nav-right' title='Logout' href='logout.php'>LOGOUT</a></li>";
  } else {
    echo "<li><a class = 'nav-right' title='Login' href='login.php'>LOGIN</a></li>";
  }
      ?>
    </ul>
  </div>

<?php
	if($section) {
		do_html_heading($section);
	}
}

function show_event_info() {
?>
  <div id="info">
    <p>Saturday June 1st, 2016<br>Hilton Hotel<br>Minneapolis, Minnesota</p>
  </div>
  <?php
}

function do_html_footer() {
  // print an HTML footer
?>
  </body>
  </html>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
  ?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
  <?php
}


function do_html_heading($heading) {
  // print heading
?>
  <h1 class="heading"><?php echo $heading; ?></h1>
<?php
}



function display_login_form() {
  // display form asking for name and password
?>
 <form method="post" action="login_action.php">
 <table bgcolor="#cccccc" align="center">
   <tr>
     <td>Username:</td>
     <td><input type="text" name="username"/></td></tr>
   <tr>
     <td>Password:</td>
     <td><input type="password" name="passwd"/></td></tr>
   <tr>
     <td colspan="2" align="center">
     <input type="submit" value="Log in"/></td></tr>
   <tr>
 </table></form>
<?php
}

function display_admin_menu() {
?>
<br />
<a href="index.php">Go to main site</a><br />
<a href="insert_category_form.php">Add a new category</a><br />
<a href="insert_book_form.php">Add a new book</a><br />
<a href="change_password_form.php">Change admin password</a><br />
<?php
}


function initialize_database() {
  ?>
    <button onclick="create_database()" type="button">Create Database</button>
  <?php
}
function create_database() {
  include_once('CreateDatabase.php');
}

function do_info_form(){
  ?>
  <div  >
    <form id="infoForm" action="submit.php" method="post">
   <table style="margin:auto;border-style:solid;padding: 10px;">
      <tr>
        <td width="150"></td>
        <td width="200"></td>
      </tr>
      <tr>
        <td>First Name:</td>
        <td align="left"><input type="text" name="first_name" size="40" maxlength="40" value="<?php echo $_SESSION['first_name']; ?>" required/></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td align="left"><input type="text" name="last_name" size="40" maxlength="40" value="<?php echo $_SESSION['last_name']; ?>" required/></td>
      </tr>
      <tr>
        <td>Nickname:</td>
        <td align="left"><input type="text" name="nickname" size="40" maxlength="40" value="<?php echo $_SESSION['nickname']; ?>" /></td>
      </tr>
       <td>Email:</td>
       <td align="left"><input type="text" name="email" size="40" maxlength="40" value="<?php echo $_SESSION['email']; ?>" required/></td>
     </tr>
     <tr>
       <td>Phone:</td>
       <td align="left"><input type="text" name="phone" size="40" maxlength="40" value="<?php echo $_SESSION['phone']; ?>" /></td>
     </tr>
     <tr>
       <td>Street Address:</td>
       <td align="left"><input type="text" name="street" size="40" maxlength="40" value="<?php echo $_SESSION['street']; ?>" /></td>
     </tr>
     <tr>
       <td>City:</td>
       <td align="left"><input type="text" name="city" size="40" maxlength="40" value="<?php echo $_SESSION['city']; ?>" /></td>
     </tr>
     <tr>
       <td>State:</td>
       <td align="left">
         <select name="state">
           <option></option>
         <optgroup label = "USA">
           <option selected><?php echo $_SESSION['state']; ?></option>
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
         <optgroup label = "Canada">
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
       <td>Zip Code:</td>
       <td align="left"><input type="text" name="zip" size="5" maxlength="5" value="<?php echo $_SESSION['zip']; ?>"/></td>
     </tr>
     <?php
        student_or_teacher();
     ?>

     <tr>
       <td>Father's Name:</td>
       <td align="left"><input type="text" name="father_name" size="40" maxlength="40" value="<?php echo $_SESSION['father_name']; ?>"/></td>
     </tr>
     <tr>
       <td>Mother's Name:</td>
       <td align="left"><input type="text" name="mother_name" size="40" maxlength="40" value="<?php echo $_SESSION['mother_name']; ?>"/></td>
     </tr>
     <tr>
     <tr>
       <td>Family Details:</td>
       <td align="left"><input type="text" name="family_details" size="40" maxlength="40" value="<?php echo $_SESSION['family_details']; ?>"/></td>
     </tr>
     <tr>
       <td>Work Experience:</td>
       <td align="left"><textarea type="text" name="work_experience" rows="3" cols="30" maxlength="200"><?php echo $_SESSION['work_experience']; ?></textarea></td>
     </tr>
     <tr>
       <td>Awards:</td>
       <td align="left"><textarea type="text" name="awards" rows="3" cols="30" maxlength="200"><?php echo $_SESSION['awards']; ?></textarea></td>
     </tr>
     <tr>
       <td>Notes:</td>
       <td align="left"><textarea type="text" name="notes" rows="3" cols="30" maxlength="200" ><?php echo $_SESSION['notes']; ?></textarea></td>
     </tr>
     <tr>
       <td></td>
       <td><input type="submit" value="Save"></td>
     </tr>
    </table>
    </form>
  </div>
<?php
}

function student_or_teacher() {
  $sql = get_user_type();
  if ($sql == 'student') {
    student_year();
  } else {
    teacher_year();
  }
}


function student_year () {
  ?>
    <tr>
      <td>Type:</td>
      <td align="left"><input type="text" name="user_type" size="40" maxlength="40" value="Student" readonly /></td>
    </tr>
  <tr>
       <td>Graduation Year (Student):</td>
       <td align="left">
       <select name="grad_year" required>
          <option></option>
         <option>Grad Year</option>
         <optgroup label = "Year">
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
           <option selected><?php echo $_SESSION['grad_year']; ?></option>
           </optgroup>
         </select>
       </td>
     </tr>
<?php
}

function teacher_year() {
  ?><tr>
    <td>Type:</td>
    <td align="left"><input type="text" name="user_type" size="40" maxlength="40" value="Teacher" readonly /></td>
  </tr>
  <tr>
    <td>Years Taught (Teacher):</td>
    <td align="left"><input type="text" name="start_year" size="4" maxlength="4" width="4" value="<?php echo $_SESSION['start_year']; ?>" required/> to
      <input type="text" name="end_year" size="4" maxlength="4" width="4" value="<?php echo $_SESSION['end_year']; ?>" required/></td>
  </tr>
<?php
}

function upload_photo(){
	?>
	<form style="align='center'" action="upload.php" method="post" enctype="multipart/form-data">
		Select image to upload:<br>
		<input type="file" name="fileToUpload" id="fileToUpload"><br>
		<input type="submit" value="Upload Image" name="submit"><br>
	</form>
	<?php
}

function display_photo() {
	?>
	<div id="photo">
	<img class="photo" src="<?php echo $_SESSION['photo']; ?>" align="middle"><br>
		<?php upload_photo(); ?>
	</div>
<?php
}

