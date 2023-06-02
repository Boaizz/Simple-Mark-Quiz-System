<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name ="description" content = "Login Page" />
	<meta name = "keywords"	 content = "Login" />
	<meta name = "author" content = "Three Jets" />
	<link rel="icon" href="images/logo.png">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>Login Page </title>
	<link href= "styles/style.css" rel= "stylesheet"/>
	<link href= "styles/login.css" rel= "stylesheet"/>

</head>
<body>
	<main></main>
<?php
        require ("menu.inc"); 
		require_once 'setting.php';
		
  $table_exist = "CREATE TABLE IF NOT EXISTS `users` (

	`username` varchar(50) NOT NULL,
	`password` varchar(50) NOT NULL
  )
  ";
  $table_exist_result = mysqli_query($con, $table_exist);
  if (!$table_exist_result){
  echo mysqli_error($con);
  }

  $query = "INSERT INTO `users` (`username`, `password`) VALUES
  ('3jets', '3jets')";
  $result= mysqli_query($con, $query);
        ?>
<?php session_start();
 include('setting.php');
 function sanitise_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
 }
$atmp = 0;
if (isset($_POST['login'])) { 
		
	$username = $_POST['user'];
	$password = $_POST['pass'];
	$username = sanitise_input($username);
	$password = sanitise_input($password);
	$atmp = $_POST['hidden'];
	if ($atmp <5) {
	$query 		= "SELECT * FROM users WHERE  password ='$password' and username ='$username'";
	
	$result = mysqli_query($con, $query);
	$row= mysqli_fetch_array($result);
	if ($result){
		if (($row['username']==$username) && ($row['password']==$password)) {
				$_SESSION['username'] = $row['username'];
				$_SESSION['password'] =$row['password'];

	
				
				header('location:manage.php');
			
		}
		else {
			$atmp++;
			
			
			
	
		}
	}
				
}
	
} ?>


<html>
<head>

</head>
<body>



<div class="login-form">
  <form action="#" method="post">
  <?php 
echo " <input type='hidden' name='hidden' value='$atmp'>"; 
?>
    <h1>Supervisor Login</h1>
    <div class="content">
      <div class="input-field">
  	<input type="text" name="user" required="required" <?php if($atmp==5){?> disabled="disabled" <?php } ?> placeholder="Username">
      </div>
      <div class="input-field">
  	<input type="password" name="pass" required="required" <?php if($atmp==5){?> disabled="disabled" <?php } ?> placeholder="Password">
      </div>
	  <div><?php
	  $a = 5-$atmp;
	   echo "<p>Number of attempts left is $a.</p> "; ?></div>
    </div>
<div class="action">
	<input type="submit" class="button" title="Log In"  <?php if($atmp==5){?> disabled="disabled" <?php } ?> name="login" value="Login"></input>
    </div>
  </form>
</div>

 	<div class="bigboy"></div>

<?php 
    require("footer.inc")
    ?>
	
</body>
</html>