<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name ="description" content = "Manage Page" />
	<meta name = "keywords"	 content = "Manage" />
	<meta name = "author" content = "Three Jets" />
	<link rel="icon" href="images/logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Manage Page </title>
	<link href= "styles/style.css" rel= "stylesheet"/>
	<link href= "styles/manage.css" rel= "stylesheet"/>

</head>
<body>

<?php
        require ("menu.inc"); 
        ?>
<?php

function sanitise_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}



if(isset($_POST["sort"])){

    if ($_POST["sort"]== "all"){
      $_SESSION["choice"]=0;}
    elseif ($_POST["sort"]== "max") {
      $_SESSION["choice"]=1;}
  elseif ($_POST["sort"]== "half") {
      $_SESSION["choice"]=2;}
  elseif ($_POST["sort"]== "name"){
    $_SESSION["choice"]=3;}
  elseif ($_POST["sort"]== "id") {
    $_SESSION["choice"]=4;}
}

 ?>
	<main></main>
  <div class="login-form">
    <form action="manage.php" method="post">
	    <h1>Manage attempts</h1>
    <div class="content">

      <p><label for="firstname">First name</label>
		<input type="text" name="firstname" value= "<?php if(isset($_SESSION["firstname"])) { echo $_SESSION["firstname"]; } ?>"   maxlength="30" id="firstname" size="20" />
	</p>

  <p><label for="lastname">Last name</label>
		<input type="text" name="lastname" value= "<?php if(isset($_SESSION["lastname"])) { echo $_SESSION["lastname"]; } ?>" maxlength="30" id="lastname" size="20"  />
	 </p>
   <p><label for="sid">Student ID</label>
		<input type="text"  name="sid" value= "<?php if(isset($_SESSION["sid"])) { echo $_SESSION["sid"]; } ?>"  id="sid" size="20"  />
	 </p>
   <p>
		<label for="sort">Sort By</label>
		<select name="sort" id="sort" >


      <option value="all"
      <?php if(isset($_SESSION["choice"]))
     {if ($_SESSION["choice"]==0) echo "selected"; }
       ?>
      >All attempt</option>
			<option value="max" <?php if(isset($_SESSION["choice"]))
      {if ($_SESSION["choice"]==1) echo "selected"; }
        ?>
      >100% on first attempt</option>
			<option value="half"
      <?php if(isset($_SESSION["choice"]))
     {if ($_SESSION["choice"]==2) echo "selected"; }
       ?>
      > Lower than 50% on second attempt</option>
			<option value="name"
      <?php if(isset($_SESSION["choice"]))
     {if ($_SESSION["choice"]==3) echo "selected"; }
       ?>
      >Name (Input both first and family name)</option>
			<option value="id"
      <?php if(isset($_SESSION["choice"]))
     {if ($_SESSION["choice"]==4) echo "selected"; }
       ?>
      >Student ID</option>
		</select>
	</p>
	    </div>
<div class="action">
      <input type="button" name="LOGOUT" value="LOGOUT" class="button" onClick="parent.location='logout.php'" />

   <input type="submit" name="submit" value="FIND" class="button" />
</div>
     </form>
</div>




    <?php
      require_once 'setting.php';
      require_once 'session.php';
      
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


  if(isset($_POST['submit'])&& isset($_POST["sort"])&& $_POST["sort"]!="none"){

        if ($_POST["sort"]=="all") {
        
         if (!$con){
           echo "<p>Database connection failure</p>";
         }
         else{
           $query ="SELECT student.firstname, student.lastname,  student.studentid, attempt.dateatmp, attempt.score, attempt.atmpid, attempt.id
                    FROM student
                    INNER JOIN attempt ON student.studentid = attempt.studentid";
           $result= mysqli_query($con, $query);
           if(!$result){
             echo "<p>Something is wrong with ",$query,"</p>";
           }
           else{
             echo "<table class='table table-sm'>\n";
             echo "<tr>\n"
                 ."<th scope=\"col\">Student ID</th>\n"
                 ."<th scope=\"col\">First name</th>\n"
                 ."<th scope=\"col\">Family name</th>\n"
                 ."<th scope=\"col\">Date of attempt</th>\n"
                ."<th scope=\"col\">Attempt number</th>\n"
                 ."<th scope=\"col\">Score</th>\n"
                 ."<th scope=\"col\">Change score</th>\n"
                 ."</tr>\n";
             while ($row=mysqli_fetch_assoc($result)){
               echo "<tr>\n";
               echo "<td>",$row["studentid"],"</td>\n";
               echo "<td>",$row["firstname"],"</td>\n";
               echo "<td>",$row["lastname"],"</td>\n";
               echo "<td>",$row["dateatmp"],"</td>\n";
               echo "<td>",$row["atmpid"],"</td>\n";
               echo "<form  action=\"change.php\" method=\"post\">";
               echo "<input name =\"tryatmpt\" type=\"hidden\" value= ",$row["id"],">";
               echo "<td><input type=\"number\" value= ",$row["score"]," id=\"score\" name=\"score\" min=\"0\" max=\"5\"></td>\n";
               echo "<td> <input class='btn btn-secondary' type='submit' value='Update'> </td>";
               echo "</form>";
               echo "</tr>\n";
             }
             echo "</table>\n";
             mysqli_free_result($result);
           }
           mysqli_close($con);
         }
       }
       elseif ($_POST["sort"]=="max"){
         if (!$con){
           echo "<p>Database connection failure</p>";
         }
         else{
           $query ="SELECT student.firstname, student.lastname, student.studentid, attempt.dateatmp, attempt.score, attempt.atmpid
                    FROM student
                    INNER JOIN attempt ON student.studentid = attempt.studentid WHERE attempt.atmpid = 1 and attempt.score=5";
           $result= mysqli_query($con, $query);
           if(!$result){
             echo "<p>Something is wrong with ",$query,"</p>";
           }
           else{
             echo "<table class='table table-sm' >\n";
             echo "<tr>\n"
             ."<th scope=\"col\">Student ID</th>\n"
             ."<th scope=\"col\">First name</th>\n"
             ."<th scope=\"col\">Family name</th>\n"
             ."<th scope=\"col\">Date of attempt</th>\n"
             ."<th scope=\"col\">Attempt number</th>\n"
             ."<th scope=\"col\">Score</th>\n"
             ."</tr>\n";
             while ($row=mysqli_fetch_assoc($result)){
               echo "<tr>\n";
               echo "<td>",$row["studentid"],"</td>\n";
               echo "<td>",$row["firstname"],"</td>\n";
               echo "<td>",$row["lastname"],"</td>\n";
               echo "<td>",$row["dateatmp"],"</td>\n";
               echo "<td>",$row["atmpid"],"</td>\n";
               echo "<td>",$row["score"],"</td>\n";
               echo "</tr>\n";
             }
             echo "</table>\n";
             mysqli_free_result($result);
           }
           mysqli_close($con);
         }
       }

       elseif ($_POST["sort"]=="half"){
         if (!$con){
           echo "<p>Database connection failure</p>";
         }
         else{
           $query ="SELECT student.firstname, student.lastname, student.studentid, attempt.dateatmp, attempt.score, attempt.atmpid
                    FROM student
                    INNER JOIN attempt ON student.studentid = attempt.studentid WHERE attempt.atmpid = 2 and attempt.score< 3";
           $result= mysqli_query($con, $query);
           if(!$result){
             echo "<p>Something is wrong with ",$query,"</p>";
           }
           else{
             echo "<table class='table table-sm' >\n";
             echo "<tr>\n"
             ."<th scope=\"col\">Student ID</th>\n"
             ."<th scope=\"col\">First name</th>\n"
             ."<th scope=\"col\">Family name</th>\n"
             ."<th scope=\"col\">Date of attempt</th>\n"
             ."<th scope=\"col\">Attempt number</th>\n"
             ."<th scope=\"col\">Score</th>\n"
             ."</tr>\n";
             while ($row=mysqli_fetch_assoc($result)){
               echo "<tr>\n";
               echo "<td>",$row["studentid"],"</td>\n";
               echo "<td>",$row["firstname"],"</td>\n";
               echo "<td>",$row["lastname"],"</td>\n";
               echo "<td>",$row["dateatmp"],"</td>\n";
               echo "<td>",$row["atmpid"],"</td>\n";
               echo "<td>",$row["score"],"</td>\n";
               echo "</tr>\n";
             }
             echo "</table>\n";
             mysqli_free_result($result);
           }
           mysqli_close($con);
         }
       }
       elseif ($_POST["sort"]=="name") {
         $input=true;
          $firstname=$_POST["firstname"];
           $lastname=$_POST["lastname"];
         if($_POST["firstname"]==""){
           echo "<p>You have to input student first name</p>";
           $input=false;
         }
         elseif (!preg_match("/^[a-zA-z\s-]*$/",$firstname)){
           echo "<p>Only alpha letters and hyphen allowed in your first name.</p>";
              $input=false;
         }
         else {
           $firstname=sanitise_input($_POST["firstname"]);
         }
         if($_POST["lastname"]==""){
           echo "<p>You have to input student family name</p>";
              $input=false;
         }
         elseif (!preg_match("/^[a-zA-z\s-]*$/",$lastname)){
           echo "<p>Only alpha letters and hyphen allowed in your last name.</p>";
              $input=false;
         }
         else {
           $lastname=sanitise_input($_POST["lastname"]);
       }
       if ($input){
         if (!$con){
           echo "<p>Database connection failure</p>";
         }
         else{
           $query ="SELECT student.firstname, student.lastname,  student.studentid, attempt.dateatmp, attempt.score, attempt.atmpid, attempt.id
                    FROM student
                    INNER JOIN attempt ON student.studentid = attempt.studentid WHERE student.firstname=\"$firstname\" and  student.lastname=\"$lastname\"";
           $result= mysqli_query($con, $query);
           if(!$result){
             echo "<p>Something is wrong with ",$query,"</p>";
           }
           else{
             echo "<table class='table table-sm' >\n";
             echo "<tr>\n"
             ."<th scope=\"col\">Student ID</th>\n"
             ."<th scope=\"col\">First name</th>\n"
             ."<th scope=\"col\">Last name</th>\n"
             ."<th scope=\"col\">Date of attempt</th>\n"
             ."<th scope=\"col\">Attempt number</th>\n"
             ."<th scope=\"col\">Score</th>\n"
             ."<th scope=\"col\">Change score</th>\n"
             ."</tr>\n";
             while ($row=mysqli_fetch_assoc($result)){
               echo "<tr>\n";
               echo "<td>",$row["studentid"],"</td>\n";
               echo "<td>",$row["firstname"],"</td>\n";
               echo "<td>",$row["lastname"],"</td>\n";
               echo "<td>",$row["dateatmp"],"</td>\n";
               echo "<td>",$row["atmpid"],"</td>\n";
               echo "<form  action=\"change.php\" method=\"post\">";
               echo "<input name =\"tryatmpt\" type=\"hidden\" value= ",$row["id"],">";
               echo "<td><input type=\"number\" value= ",$row["score"]," id=\"score\" name=\"score\" min=\"0\" max=\"5\"></td>\n";
               echo "<td> <input class='btn btn-secondary' type='submit' value='Update'> </td>";
               echo "</form>";
               echo "</tr>\n";
             }
             echo "</table>\n";
             mysqli_free_result($result);
           }
           mysqli_close($con);
         }

       }
     }

     elseif ($_POST["sort"]=="id"){
      
       $input=true;
        $studentid= $_POST["sid"];
       if ($_POST["sid"]==""){
         echo "<p>You have to input the student ID</p>";
         $input=false;
       }
       elseif (!preg_match("/^([0-9]{7}|[0-9]{10})$/",$studentid)){
         echo "<p>Please input number with the length of 7 or 10 numbers.</p>";
            $input=false;
       }
       else {
         $studentid=$_POST["sid"];
         $_SESSION["sid"]=$_POST["sid"];
       }
       if ($input){
         if (!$con){
           echo "<p>Database connection failure</p>";
         }
         else{
           $query ="SELECT student.firstname, student.lastname,  student.studentid, attempt.dateatmp, attempt.score, attempt.atmpid, attempt.id
                    FROM student
                    INNER JOIN attempt ON student.studentid = attempt.studentid WHERE student.studentid=\"$studentid\" ";
           $result= mysqli_query($con, $query);
           if(!$result){
             echo "<p>Something is wrong with ",$query,"</p>";
           }
           else{
             echo "<table class='table table-sm' >\n";
             echo "<tr>\n"
             ."<th scope=\"col\">Student ID</th>\n"
             ."<th scope=\"col\">First name</th>\n"
             ."<th scope=\"col\">Last name</th>\n"
             ."<th scope=\"col\">Date of attempt</th>\n"
             ."<th scope=\"col\">Attempt number</th>\n"
             ."<th scope=\"col\">Score</th>\n"
             ."<th scope=\"col\">Change score</th>\n"
             ."<th scope=\"col\">Delete</th>\n"
             ."</tr>\n";

             while ($row=mysqli_fetch_assoc($result)){
               echo "<tr>\n";
               echo "<td>",$row["studentid"],"</td>\n";
               echo "<td>",$row["firstname"],"</td>\n";
               echo "<td>",$row["lastname"],"</td>\n";
               echo "<td>",$row["dateatmp"],"</td>\n";
               echo "<td>",$row["atmpid"],"</td>\n";
               echo "<form  action=\"change.php\" method=\"post\">";
               echo "<input name =\"tryatmpt\" type=\"hidden\" value= ",$row["id"],">";
               echo "<td><input type=\"number\" value= ",$row["score"]," id=\"score\" name=\"score\" min=\"0\" max=\"5\"></td>\n";
               echo "<td> <input class='btn btn-secondary' type='submit' value='Update'> </td></form>";
               echo "<form action=\"delete.php\" method=\"post\">";
               echo "<td><input type='submit' class='btn btn-danger' value='Delete'></td>";
               echo "</form>";
               echo "</tr>\n";
             }
             echo "</table>\n";
             mysqli_free_result($result);
           }
           mysqli_close($con);
         } 
       }
     }
    }

     ?>

	 
	  	<div class="bigboy"></div>

	 
     <?php 
    require("footer.inc")
    ?>
	
  </body>
</html>
