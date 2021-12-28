<?php

include 'connect.php';


$num=$_POST['xu'];

// Create connection


 $conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo " connection failure";
}
// echo "Connected successfully";

$sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $a=array();
   	while($row=$result->fetch_assoc()){
//   echo $result->num_rows;
//     array_push($a,$row["number"]);
//     $a=array("question问题","anser答案","detail细节");
       $a=array($row["question"],$row["answer"],$row["detail"]);
}
     echo json_encode($a);

} else {
    echo "0 results";
}
$conn->close();

?>
