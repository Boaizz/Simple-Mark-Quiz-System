<?php
 $host = "";
$user = "";
$pwd ="";
$sql_db = "";
$con = @mysqli_connect($host,$user,$pwd,$sql_db);


if (mysqli_connect_error())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
