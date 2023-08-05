<?php
include 'connect.php';


$sql="SELECT category FROM tbquiz where number = ?";
try{
    $stmt =$conn->prepare($sql);
    $stmt->execute([$_POST['number']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
	echo json_encode(array($row["category"]));
    }
    else{
	echo json_encode(array("fail"));
    }
}catch(PDOException $e){
    echo json_encode(array("error"," error check exising username:".$e->getMessage(), $sql));
 }


$conn=null;

?>
