<?php
	$host = "localhost";
   $user = "root";
  $pass = "mysqlpass";

  $databaseName = "dbquiz";
  $tableName = "active_guests";

  //--------------------------------------------------------------------------
  // 1) Connect to mysql database
  //--------------------------------------------------------------------------
  $con = mysql_connect($host,$user,$pass);
  $dbs = mysql_select_db($databaseName, $con);

  //--------------------------------------------------------------------------
  // 2) Query database for data
  //--------------------------------------------------------------------------
  $result = mysql_query("SELECT number FROM $tableName");          //query
  $array = mysql_fetch_row($result);                          //fetch result    

 echo json_encode($array);				      

?>
