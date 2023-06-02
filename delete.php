<?php
require 'setting.php';
session_start();

if (isset($_SESSION["sid"])){
$studentid= $_SESSION["sid"];
  $query="DELETE FROM attempt WHERE studentid = $studentid";
  $result= mysqli_query($con, $query);
  if(!$result){
    echo "<p>Something is wrong with ",$query,"</p>";
  }

else {
  mysqli_close($con);
}
}
header('location:manage.php');


 ?>
