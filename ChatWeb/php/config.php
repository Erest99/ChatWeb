<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chat";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);     //připoj se k DB
  if($conn){
    //echo "DB connected ";
  }
  else{
    echo "Database connection error".mysqli_connect_error();            //Při chybě ji vypiš
  }
?>
