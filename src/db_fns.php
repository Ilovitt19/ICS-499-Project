<?php

function db_connect() {
   $result = mysqli_connect('localhost', 'ics499sp160102', '299436', 'ics499sp160102');
   if (!$result) {
      return false;
   }
   $result->autocommit(TRUE);
   return $result;
}

function db_result_to_array($result) {
   $res_array = array();

   for ($count=0; $row = $result->fetch_assoc(); $count++) {
     $res_array[$count] = $row;
   }

   return $res_array;
}

?>
