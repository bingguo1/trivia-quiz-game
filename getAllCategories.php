<?php
include 'connect.php';

$sql = "SELECT name, Id,topCategory  from categories where subCategory=0";
$sql2= "SELECT * from categories where subCategory!=0";
try {
    $stmt = $conn->prepare($sql);
    //$stmt->execute([$_POST['number']]);
    $stmt->execute();
    $topcats = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare($sql2);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $topcatsNew=[];

    foreach ($topcats as $topcat) {
      //print_r($topcat);
      $topcatsNew[$topcat['topCategory']]=$topcat;
      $topcatsNew[$topcat['topCategory']]['subcats']=[];
      $topcatsNew[$topcat['topCategory']]['subids']=[];
      $topcatsNew[$topcat['topCategory']]['subnames']=[];
    }
    foreach ($rows as $row) {
      //print_r($row);
      array_push($topcatsNew[$row['topCategory']]['subcats'], $row['subCategory']);
      array_push($topcatsNew[$row['topCategory']]['subids'], $row['Id']);
      array_push($topcatsNew[$row['topCategory']]['subnames'], $row['name']);
      //echo $topcats[$row['topCategory']];
    }
    //print_r($topcatsNew);
    echo json_encode($topcatsNew);

} catch (PDOException $e) {
    echo json_encode(array("error", " error check exising username:" . $e->getMessage(), $sql));
}

$conn = null;

?>

