<?php

function do_html_header($title = '',$section = '') {
//Title of the page being cra
?>
  <html>
  <head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="../src/style.css"/>
  </head>
  <body>
  <h1>Village High School Reunion</h1>
  <div id="topnavBar" class="topnavMenu">
    <ul class="navbar">
      <li><a class="nav" title="Welcome" href="../src/Index.php">HOME</a></li>
      <li><a class="nav" title="Profile" href="../src/UserInfoPage.php">MY PROFILE</a></li>
      <li><a class="nav" title="Find People" href="Search.php">FIND PEOPLE</a></li>
      <?php
      if(isset($_SESSION['admin_user'])) {
        echo "<li><a class = 'nav-right' title='Admin' href='admin.php'>ADMIN</a></li>";
      } else {

      }
      ?>
      <li><a class="nav-right" title="Login" href="Login.php">LOGIN</a></li>
    </ul>
  </div>
  <tr>
  <td align="right" valign="bottom">
  <?php
     if(isset($_SESSION['admin_user'])) {
       echo "&nbsp;";
     } else {

     }
  ?>
  </td>
  <td align="right" rowspan="2" width="135">
  <?php
     if(isset($_SESSION['admin_user'])) {
       display_button('logout.php', 'log-out', 'Log Out');
     } else {

     }
  ?>
  </tr>
  <tr>
  <td align="right" valign="top">
  <?php
     if(isset($_SESSION['admin_user'])) {
       echo "&nbsp;";
     } else {

     }
  ?>
  </td>
  </tr>
  </table>
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


function do_html_heading($heading) {
  // print heading
?>
  <h1 class="heading"><?php echo $heading; ?></h1>
<?php
}

function do_html_URL($url, $name) {
  // output URL as link and br
?>
  <a href="<?php echo $url; ?>"><?php echo $name; ?></a><br />
<?php
}


function display_login_form() {
  // dispaly form asking for name and password
?>
 <form method="post" action="admin.php">
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

function display_button($target, $image, $alt) {
  echo "<div align=\"center\"><a href=\"".$target."\">
          <img src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
}

function display_form_button($image, $alt) {
  echo "<div align=\"center\"><input type=\"image\"
           src=\"images/".$image.".gif\"
           alt=\"".$alt."\" border=\"0\" height=\"50\"
           width=\"135\"/></div>";
}

?>
