<?php

//include 'connect.php';


$queryString=$_POST['queryString'];
$columnSets=$_POST['columnSets'];
$number=count($columnSets);
// Create connection


 class MyDB extends SQLite3 {
       function __construct() {
       $this->open('real.db');
		      }
}

   $db = new MyDB();
      if(!$db) {
            echo $db->lastErrorMsg();
	       } else {
	             echo "Opened database successfully\n";
		        }


// Check connection

// $sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
$result = $db->query($queryString);

if ($result->num_rows > 0) {

  $a=array();
  while($row=$result->fetchArray(SQLITE3_ASSOC)){
    //   echo $result->num_rows;
    //     array_push($a,$row["number"]);
    //     $a=array("question问题","anser答案","detail细节");
    foreach($columnSets as $column ){
      array_push($a, nl2br($row[$column]));
    }
  }
  echo json_encode($a);

} else {
  echo "0 results";
}
$db->close();

?>
