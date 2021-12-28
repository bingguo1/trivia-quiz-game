<?php

include 'connect.php';

$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo " connection failure";
}
session_start();
$number=$_SESSION["number"];

$category=mysqli_real_escape_string($conn,$_POST["category"]);
$question=mysqli_real_escape_string($conn,$_POST["question"]);
$answer=mysqli_real_escape_string($conn,$_POST["answer"]);
//$answer=nl2br($answer);
$detail=mysqli_real_escape_string($conn,$_POST["detail"]);
//$detail=nl2br($detail);
// $sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
$sql="UPDATE tbquiz SET category='$category',question='$question',answer='$answer',detail='$detail' where number='$number'";


if ($conn->query($sql)===TRUE) {

 echo "Question updated successfully!".$category.$question.$answer.$detail.$number;

} else {
  echo "Error for updating question:".$conn->error;
}
$conn->close();

?>
