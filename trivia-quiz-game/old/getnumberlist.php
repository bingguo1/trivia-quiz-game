<?php


include 'connect.php';

$categories=$_POST["categories"];

$condition=" ";
// you can't just use $categories[i] in if condition, what it transfer here is characters
if($categories[0]== "true") $condition .="(category>9 AND category<20) OR ";
if($categories[1]== "true") $condition .="(category>19 AND category<30) OR ";
if($categories[2]== "true") $condition .="(category>29 AND category<40) OR ";
if($categories[3]== "true") $condition .="(category>39 AND category<50) OR ";
if($categories[4]== "true") $condition .="(category>49 AND category<60) OR ";
if($categories[5]== "true") $condition .="(category>59 AND category<70) OR ";
if($categories[6]== "true") $condition .="(category>69 AND category<80) OR ";
if($categories[7]== "true") $condition .="(category>79 AND category<90) OR ";
$condition .=" number<0";

// Create connection


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    echo " connection failure";
}
// echo "Connected successfully";

$sql = "SELECT number FROM tbquiz where $condition ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

   $a=array();
   while($row=$result->fetch_assoc()){
//   echo $result->num_rows;
     array_push($a,$row["number"]);
}
     echo json_encode($a);

} else {
    echo "0 results";
}
$conn->close();


?>
