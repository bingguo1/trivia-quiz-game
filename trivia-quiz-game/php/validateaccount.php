<?php

include 'connect.php';
//$conn->set_charset("utf8");

// Check connection
$username=$_POST["username"];
$password=$_POST["password"];


$salt = "hello123dark matter like a unicorn";
$hash = hash('sha512',$salt.$password);
$sql = "SELECT password FROM tbusers  WHERE username='$username' ";

try{
    $result = $conn->query($sql);
    $row=$result->fetch();
     if($row) {
	 $truepass=$row["password"];
	 if($truepass==$hash) {
	     echo json_encode(array("succeed"));
	 }
	 else echo json_encode(array("wrong password"));
	 
     }else{
	 echo json_encode(array("this user doesnot exist!"));
     }    
}catch(PDOException $e){
     echo json_encode(array("error"," error when doing query for validateaccount:".$e->getMessage(), $sql));
 }
    
$conn=null;

?>
