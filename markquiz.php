<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href= "styles/style.css" rel= "stylesheet"/>
	<link href= "styles/login.css" rel= "stylesheet"/>

    <title>Quiz Marking Page</title>
</head>
<body>
<main></main>

    <?php include "menu.inc"   ?>
	 <div class="login-form">
  <form action="#" method="post">

    <h1>Result</h1>
    <div class="content">
    <?php
   
    require_once 'setting.php';


    $table_exist = "SELECT studentid
      FROM student";
$table_exist_result = mysqli_query($con, $table_exist);
if (empty($table_exist_result)) {
$table_exist = "CREATE TABLE student
( studentid INT PRIMARY KEY, 
firstname VARCHAR(30) NOT NULL , 
lastname VARCHAR(30) NOT NULL)
";
$table_exist_result = mysqli_query($con, $table_exist);
if (!$table_exist_result){
echo mysqli_error($con);
}
}
$table_exist1 = "SELECT studentid
FROM attempt";
$table_exist_result1 = mysqli_query($con, $table_exist1);
if (empty($table_exist_result1)) {
$table_exist1 = "CREATE TABLE attempt
( id INT PRIMARY key AUTO_INCREMENT,
studentid int,
dateatmp datetime,
score int,
atmpid int,
FOREIGN KEY (studentid) REFERENCES student(studentid))
";
$table_exist_result1 = mysqli_query($con, $table_exist1);
if (!$table_exist_result1){
echo mysqli_error($con);
}
} 
   
    
    $input=true;
    $firstatmp=false;
    $errMsg = "";
    function sanitise_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }

    if ($_POST["stu_id"]=="")
    {
        $errMsg .="<p>CANNOT FIND STUDENT ID!!!</p>";
        $input=false;
    }
    elseif(!preg_match("/^([0-9]{7}|[0-9]{10})$/",$_POST["stu_id"])){
      $errMsg .="<p>ONLY 7 OR 10 DIGITS ALLOWED IN YOUR STUDENT ID!!!</p>";
      $input=false;
    }
    else{
      $stu_id=sanitise_input($_POST["stu_id"]);
    }

    if ($_POST["firstname"]=="")
    {
        $errMsg .="<p>CANNOT FIND FIRST NAME!!!</p>";
        $input=false;
    }
    elseif (!preg_match("/^[a-zA-z\s-]*$/",$_POST["firstname"])){
      $errMsg .="<p>ONLY ALPHA LETTERS AND HYPHEN ALLOWED IN FIRSTNAME!!!</p>";
      $input=false;
    }
    else{
      $firstname=sanitise_input($_POST["firstname"]);
    }
  
    if ($_POST["lastname"]=="")
    {
        $errMsg .="<p>CANNOT FIND LAST NAME!!!</p>";
        $input=false;
    }
    elseif (!preg_match("/^[a-zA-z\s-]*$/",$_POST["lastname"])){
      $errMsg .="<p>ONLY ALPHA LETTERS AND HYPHEN ALLOWED IN LASTNAME!!!</p>";
      $input=false;
    }
    else{
      $lastname=sanitise_input($_POST["lastname"]);
    }
    if(!$input){
      print $errMsg;
    }
    else{

      $con= @mysqli_connect($host,$user,$pwd,$sql_db);
      if($con){
        $query = "SELECT * FROM attempt WHERE studentid=$stu_id and atmpid=2 ";
        $result= mysqli_query($con, $query);
        if ($result){
          $exist=mysqli_fetch_assoc($result);
          if(count($exist)!=0){
            $result= mysqli_query($con, $query);
            mysqli_free_result($result);
            $input=false;
          }
        }
      }
      if(!$input){
        print "<p>OUT OF ATTEMPTS!!!</p>";
      }
      else{
          $query = "SELECT * FROM student WHERE studentid=$stu_id";
          $result= mysqli_query($con, $query);
          if ($result){
            $exist=mysqli_fetch_assoc($result);
            if(count($exist) == 0){
              $firstatmp = true;
              mysqli_free_result($result);
              $query= "INSERT INTO student (`studentid`, `firstname`, `lastname`) VALUES ($stu_id, '$firstname', '$lastname')";
              $result= mysqli_query($con, $query);
            }
          }
          if(!isset($_POST["answer_1"])){
            $errMsg .= "<p>Question 1 answer not found!</p>";
            $input= false;
          }
          if(!isset($_POST["answer_2"])){
            $errMsg .= "<p>Question 2 answer not found!</p>";
            $input= false;
          }
          if($_POST["answer_3"]==""){
            $errMsg .= "<p>Question 3 answer not found!</p>";
            $input= false;
          }
          if($_POST["answer_4"]==""){
            $errMsg .= "<p>Question 4 answer not found!</p>";
            $input= false;
          }
          if($_POST["answer_5"]==""){
            $errMsg .= "<p>Question 5 answer not found!</p>";
            $input= false;
          }
          if(!$input){
            if($firstatmp){
              $query="DELETE FROM student WHERE studentid=$stu_id";
              $result= mysqli_query($con, $query);
            }
            echo $errMsg;
          }
          else{
            $answer_1 = sanitise_input($_POST["answer_1"]);
            $answer_2 = sanitise_input($_POST["answer_2"]);
            $answer_3 = sanitise_input($_POST["answer_3"]);
            $answer_4 = sanitise_input($_POST["answer_4"]);
            $answer_5 = sanitise_input($_POST["answer_5"]);

            $score = 0;
       if ($answer_1 == "software") {
           $score += 1;
        }
       if ($answer_2 == "google") {
            $score += 1 ;
        }
        if ($answer_3 == "Archie") {
            $score += 1;
        }
        if ($answer_4 == "Google" ) {
            $score += 1;
      
        }
        if ($answer_5 == "jaguar" ) {
            $score += 1;
        }
  
            if($firstatmp){
              $attemptid=1;
            } else{
              $attemptid=2;
            }
            $query= "INSERT INTO attempt (`dateatmp`,`studentid`, `score`, `atmpid`) VALUES (UTC_TIMESTAMP(), $stu_id, $score, $attemptid)";
            $result= mysqli_query($con, $query);
                    
                    echo "<p>Student name: " ,$firstname," ",$lastname,"</p>";
                    echo "<p>Student ID:", $stu_id,"</p>";
                    echo "<p>Number of attemps:", $attemptid ,"</p>";
                    echo "<p>Score of this attemps:", $score ,"</p>";
                    if ($score == 0) {
                      echo "<p>You have failed the quiz</p>";
                  }
                
          }
      }
    }
	

	
 ?>
 

    </div>
<div class="action">
      <input type="button" name="LOGOUT" value="RETRY" class="button" onClick="parent.location='quiz.php'" />
    </div>
  </form>
</div>
	  	<div class="bigboy"></div>

        <?php include "footer.inc" ?>
        </body>
        
        </html>
      