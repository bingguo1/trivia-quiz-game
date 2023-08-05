<?php

include 'connect.php';

//$conn->set_charset("utf8");

//$detail=nl2br($detail);
// $sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
try{
    if($_POST["sqlmode"]=="update"){
	$sql="UPDATE tbquiz SET category=?, question=?, answer=?,detail=? where number=?";
	$stmt=$conn->prepare($sql);
	$result=$stmt->execute([$_POST["category"],$_POST["question"],$_POST["answer"],$_POST["detail"], $_POST["number"]]);
    }
    else{
	$sql="INSERT INTO tbquiz (category,question,answer,detail) VALUES (?,?,?,?)";
	$stmt=$conn->prepare($sql);
	$result=$stmt->execute([$_POST["category"],$_POST["question"],$_POST["answer"],$_POST["detail"]]);
    }     
    
    if ($result){
	
	echo json_encode(array("succeed", $_POST["sqlmode"]." number: ".$_POST["number"]));
	
    } else {
	echo json_encode(array("fail"));
    }
}catch(PDOException $e){
    echo json_encode(array("error"," error check exising username:".$e->getMessage(), $sql));
 }
$conn=null;

?>
