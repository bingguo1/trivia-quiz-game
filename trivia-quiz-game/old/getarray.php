<?php
define ( 'DB_HOST', 'localhost' );
define ( 'DB_USER', 'root' );
define ( 'DB_PASS', 'mysqlpass' );
define ( 'DB_NAME', 'dbquiz' );
  $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query = "SELECT number FROM active_guests";
  $results = $con->query($query);
  
  while($row = $results->fetch_assoc()){
  $myjsons[] = json_encode(array($row));	
  }
  echo json_encode($myjsons);


?>
