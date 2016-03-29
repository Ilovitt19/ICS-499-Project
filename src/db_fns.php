<?php

function db_connect() {
   //comment out metrostate linux sever when working on local machine
   //$result = mysqli_connect('localhost', 'ics499sp160102', '299436', 'ics499sp160102');
   $result = mysqli_connect('localhost', 'root', '', 'reunion');
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
