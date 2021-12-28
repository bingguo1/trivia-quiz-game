<?php
include 'connect.php';

$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo  "connection failure";
}
$info=$_POST["info"];

//$info=array("realname","bing21","physics","ejflej@efe.com","flejflj");
$realname=mysqli_real_escape_string($conn,$info[0]);
$username=mysqli_real_escape_string($conn,$info[1]);
$password=mysqli_real_escape_string($conn,$info[2]);
$email=mysqli_real_escape_string($conn,$info[3]);
$interests=mysqli_real_escape_string($conn,$info[4]);


$sql="SELECT username FROM tbusers where username='$username'";
$result=$conn->query($sql);
if($result->num_rows >0 ) {
  echo "overlap";
  return;
}


$salt = "hello123dark matter like a unicorn";
$hash = hash('sha512',$salt.$password);


$sql="INSERT INTO tbusers (registertime,realname,username,password,email,level,interests)
VALUES (NOW(),'$realname','$username','$hash','$email','1','$interests')
";

if($conn->query($sql)===TRUE){

  echo "true";
}
else {
  echo json_encode("error inserting:".$conn->error);
}

$conn->close();

?>
