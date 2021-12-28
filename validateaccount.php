<?php

include 'connect.php';
$conn->set_charset("utf8");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
  echo " connection failure";
}


$username=mysqli_real_escape_string($conn,$_POST["username"]);
$password=mysqli_real_escape_string($conn,$_POST["password"]);
// echo "Connected successfully";
$salt = "hello123dark matter like a unicorn";
$hash = hash('sha512',$salt.$password);
$sql = "SELECT password FROM tbusers  WHERE username='$username' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

  while($row=$result->fetch_assoc()){
    //   echo $result->num_rows;
    //     array_push($a,$row["number"]);
    //     $a=array("question问题","anser答案","detail细节");
    $truepass=$row["password"];
  }
  if($truepass==$hash) {
    echo "true";
  }
  else echo "false";

}
else {
  echo "0 results";
}
$conn->close();

?>
