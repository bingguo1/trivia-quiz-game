<?php
include 'connect.php';

$info=$_POST["info"];

//$info=array("realname","bing21","physics","ejflej@efe.com","flejflj");
//$realname=mysqli_real_escape_string($conn,$info[0]);
//$username=mysqli_real_escape_string($conn,$info[1]);
//$password=mysqli_real_escape_string($conn,$info[2]);
//$email=mysqli_real_escape_string($conn,$info[3]);
//$interests=mysqli_real_escape_string($conn,$info[4]);
$realname=$info[0];
$username=$info[1];
$password=$info[2];
$email=$info[3];
$interests=$info[4];

$sql="SELECT username FROM tbusers where username='$username'";
try{
    $result=$conn->query($sql);
    $row=$result->fetch();
    if($row) {
	echo json_encode(array("overlap"));
	die();
    }
}catch(PDOException $e){
    echo json_encode(array("error"," error check exising username:".$e->getMessage(), $sql));
 }


$salt = "hello123dark matter like a unicorn";
$hash = hash('sha512',$salt.$password);


//$sql="INSERT INTO tbusers (registertime,realname,username,password,email,level,interests)
//VALUES (NOW(),'$realname','$username','$hash','$email','1','$interests')
//";
try{
    $stmt = $conn->prepare("INSERT INTO tbusers (registertime,realname,username,password,email,level,interests) VALUES (datetime(),?,?,?,?,?,?)");
    $inserted = $stmt->execute([$realname, $username, $hash, $email, 1, $interests ]);
    echo json_encode(array("succeed"));
}
catch (PDOException $e) {
    echo json_encode(array("error"," error inserting:".$e->getMessage()));
}

$conn=null;

?>
