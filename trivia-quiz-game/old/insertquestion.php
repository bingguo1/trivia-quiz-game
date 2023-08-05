<?php

include 'connect.php';

$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo " connection failure";
}

$category=mysqli_real_escape_string($conn,$_POST["category"]);
$question=mysqli_real_escape_string($conn,$_POST["question"]);
$answer=mysqli_real_escape_string($conn,$_POST["answer"]);
//$answer=nl2br($answer);
$detail=mysqli_real_escape_string($conn,$_POST["detail"]);
//$detail=nl2br($detail);
// $sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
$sql="INSERT INTO tbquiz (category,question,answer,detail)
VALUES ('$category','$question','$answer','$detail')";


if ($conn->query($sql)===TRUE) {

 echo "Question inserted successfully!";

} else {
  echo "Error for inserting question:".$conn->error;
}
$conn->close();

?>
