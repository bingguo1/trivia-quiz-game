<?php

include 'connect.php';


$queryString=$_POST['queryString'];
$columnSets=$_POST['columnSets'];
$number=count($columnSets);

// $sql = "SELECT question,answer,detail FROM tbquiz  WHERE number=$num ";
$result = $conn->query($queryString);

if ($result){

  $a=array("succeed");
  while($row=$result->fetch()){
    //   echo $result->num_rows;
    //     array_push($a,$row["number"]);
    //     $a=array("question问题","anser答案","detail细节");
    foreach($columnSets as $column ){
	array_push($a, nl2br(stripcslashes($row[$column])));
    }
  }
  echo json_encode($a);

} else {
    echo json_encode(array("fail","0 results"));
}

$conn=null;

?>
