<?php
$dbFile = "db/bgDatabase_triviaQuiz_sqlite3.db";
try {	    
    $conn = new PDO("sqlite:$dbFile");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //    $conn->exec('set names utf8');  /// <--- this creates problem for sqlite3
    //	    echo "Connected successfully";
} catch(PDOException $e) {
    echo json_encode(array("fail","Connection failed: " . $e->getMessage()));
    die();
  }
?>
