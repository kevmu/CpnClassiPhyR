<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php

require('db.php');

session_start();

//$create_db = "CREATE TABLE \"users\" ( id SERIAL NOT NULL PRIMARY KEY, username varchar(50) NOT NULL, email varchar(50) NOT NULL, password varchar(50) NOT NULL, trn_date timestamp NOT NULL);";

//$query = $create_db;
//$result = pg_query($con,$query) or die(pg_last_error());

// If form submitted, insert values into the database.
if (isset($_POST['username'])){
        // removes backslashes
	$username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
	$username = pg_escape_string($con,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = pg_escape_string($con,$password);
	//Checking is user existing in the database or not
        $query = "SELECT * FROM users WHERE username='$username'
and password='" . md5($password) . "'";
	$result = pg_query($con,$query) or die(pg_last_error());
	$rows = pg_num_rows($result);
        if($rows==1){
	    $_SESSION['username'] = $username;
            // Redirect user to index.php
	    header("Location: index.php");
         }else{
	echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a href='login.php'>Login</a></div>";
	}
    }else{
?>
<div class="form">
<h1>Log In</h1>
<form action="" method="post" name="login">
<input type="text" name="username" placeholder="Username" required />
<input type="password" name="password" placeholder="Password" required />
<input name="submit" type="submit" value="Login" />
</form>
<p>Not registered yet? <a href='registration.php'>Register Here</a></p>
</div>
<?php } ?>
</body>
</html>

