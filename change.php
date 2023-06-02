<?php
require 'setting.php';
if(isset($_POST["score"])&& isset($_POST["tryatmpt"])){
  $score= $_POST["score"];
  $id= $_POST["tryatmpt"];
$query ="UPDATE attempt SET score = '$score' WHERE id = $id ";
$result= mysqli_query($con, $query);
if(!$result){
  echo "<p>Something is wrong with ",$query,"</p>";
}
else{
mysqli_close($con);
}
}
header("location:manage.php");
 ?>
