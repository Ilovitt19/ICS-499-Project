<?php

include ('reunion_fns.php');
require_once ('user_auth_fns.php');
session_start();

do_html_header("Find People","Enter Search");
if (login_check() == 'true') {
  do_findpeople_form();
  do_query_results();
} else {
  echo "<p>You must be logged in to visit this page.</p>";
}

function do_findpeople_form(){
?>
<div  style="margin:auto;" >
    <form action="queryfinder.php" method="get">
   <table style="margin:auto;border-style:solid;padding: 10px;">
      <tr>
        <td width="150"></td>
        <td width="200"></td>
      </tr>
	  
     <tr>
	   
       <td>Student or Teacher:</td>
       <td align="left">
         <select name="select">
           <optgroup label = "">
             <option value="student">Student</option>
             <option value="teacher">Teacher</option>
           </optgroup>
         </select>
       </td>
     </tr>
      <tr>
        <td>First Name:</td>
        <td align="left"><input type="text" name="first_name" size="40" maxlength="40" required/></td>
      </tr>
      <tr>
        <td>Last Name:</td>
        <td align="left"><input type="text" name="last_name" size="40" maxlength="40" required/></td>
      </tr>
      <tr>
        <td>Nickname:</td>
        <td align="left"><input type="text" name="nickname" size="40" maxlength="40" /></td>
      
     
     
     <tr>
       <td>Graduation Year (Student):</td>
       <td align="left">
       <select name="grad_year">
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
           </optgroup>
         </select>
       </td>
     </tr>
     <tr>
       <td>Years Taught (Teacher):</td>
       <td align="left"><input type="text" name="start_year" size="4" maxlength="4" width="4"/> to
         <input type="text" name="end_year" size="4" maxlength="4" width="4"/></td>
     </tr>
     
     
     <tr>
       <td></td>
       <td><input type="submit" value="Submit"></td>
     </tr>
    </table>
    </form>
  </div>
<?php	
}
function do_query_results(){
?>
	<h2>Results</h2>
	<div  style="margin:auto;" >
    <form action="" method="get">
   <table style="margin:auto;border-style:solid;padding: 10px;">
      <tr>
        <td width="500"></td>
        <td width="200"></td>
      </tr>
     
     <tr>
       <!--<td>People Found:</td>-->
       <td align="left"><textarea type="text" name="people_found" rows="10" cols="100" maxlength="200" ></textarea></td>
     </tr>
     
     
    </table>
    </form>
  </div>
	
	

<?php
}


do_html_footer();
?>