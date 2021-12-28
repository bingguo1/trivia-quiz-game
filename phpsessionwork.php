<?php

  session_start();
  $task=$_POST["task"];
  $key=$_POST["key"];
  $value=$_POST["value"];

  if($task=="set"){

    $_SESSION[$key]=$value;
    echo  "Set successfully!".$value;
  }
  else if($task=="get"){
    echo $_SESSION[$key];
  }
  else if($task=="remove"){

    $_SESSION[$key]="undefined";
    echo "Remove key '$key' successfully!";
  }

  else if($task=="clear"){

    echo "cleared all session variables";

  }
  else
    echo "Unrecognized session request task!";




?>
