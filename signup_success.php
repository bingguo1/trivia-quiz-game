<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>this is title</title>
  <link rel="stylesheet" type="text/css" href="css/signup.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


  <!-- Fonts -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"> </script>

</head>
<body>

  <script language="javascript" type="text/javascript">
  setTimeout("javascript:location.href='admin.html'", 5000);
  </script>

  <?php
  include "connect.php";

  // Read raw POST values — escaping is handled by PDO prepared statements
  $realname  = $_POST["realname"]  ?? '';
  $username  = $_POST["username"]  ?? '';
  $password  = $_POST["password"]  ?? '';
  $email     = $_POST["email"]     ?? '';
  $interests = $_POST["interests"] ?? '';

  $salt = "hello123dark matter like a unicorn";
  $hash = hash('sha512', $salt . $password);

  try {
    $stmt = $conn->prepare(
      "INSERT INTO tbusers (registertime, realname, username, password, email, level, interests)
       VALUES (NOW(), ?, ?, ?, ?, '1', ?)"
    );
    $stmt->execute([$realname, $username, $hash, $email, $interests]);

    echo "Insert successfully!";
    session_start();
    $_SESSION["signined"] = "yes";
  } catch (PDOException $e) {
    echo "Error inserting: " . $e->getMessage();
  }

  $conn = null;

  ?>


  <div class="container">
    <div class="row">
      this will jump to <a href="admin.html"> admin page </a> in 5 seconds!
    </div>
  </div>



</body>
