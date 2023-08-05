<?php

include 'connect.php';


$queryString=$_POST['queryString'];
$columnSets=$_POST['columnSets'];
$number=count($columnSets);
// Create connection


$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo " connection failure";
}
// echo "Connected successfully";

// $sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
$result = $conn->query($queryString);

if ($result->num_rows > 0) {

  $a=array();
  while($row=$result->fetch_assoc()){
    //   echo $result->num_rows;
    //     array_push($a,$row["number"]);
    //     $a=array("question问题","anser答案","detail细节");
    foreach($columnSets as $column ){
      array_push($a, $row[$column]);
    }
  }
  echo json_encode($a);

} else {
  echo "0 results";
}
$conn->close();

?>
