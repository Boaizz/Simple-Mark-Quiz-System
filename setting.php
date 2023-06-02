<?php
 $host = "feenix-mariadb.swin.edu.au";
$user = "s103797499";
$pwd ="swinburnemaria145";
$sql_db = "s103797499_db";
$con = @mysqli_connect($host,$user,$pwd,$sql_db);


if (mysqli_connect_error())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
