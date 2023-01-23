<!DOCTYPE html>
<!--
This file exectus when a user would like to create a new profile/registered user. It asks them to create a username and
password (which we hash for secuirty before adding it to the table of users in the database) and then automatically logs
them into the index page. They will be able to change their profile picture in the profile tab
-->
<html>
<title>Bears News Create a User</title>
<header>
    <h1>Bears News</h1>
</header>
</html>
<style>
  header {
    background-color: rgb(119, 101, 101);
    color: white;    
    padding: 10px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    margin-bottom: 20px;
  }
  nav {
    display: flex;
    background-color: rgb(156, 148, 148);
    padding: 0px;
    justify-content: space-between;
  }
  nav ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
  }
  nav li {
    margin: 0 0px;
    border: solid;
    padding: 15px;
  }
  nav a {
    color: white;
    text-decoration: none;
  }
	.box {
    width: 550px;
    height: 30px;
	  padding: 5px;
	  margin: 10px;
    background-color: #ccc;
    border: 1px solid #333;
	  font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
  .title {
    width: 100%;
    height: 25px;
    margin-top: 15px;
    background-color: rgb(82, 64, 64);
    color: white;
    padding: 10px;
    font-size: 20px;
    font-family:'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
  }
</style>
<?php
require 'database.php'; ?>
<div class = title><strong>Create a User</strong></div>
<form  method=post>
  <label for=username>Username:</label><br>
  <input type=text id=username name=username><br>
	<label for=password>Password:</label><br>
  <input type=password id=password name=password><br>
  <input type=submit value=Submit>
</form>

<?php
  if(isset($_POST['username'])&& isset($_POST['password'])){//they submitted a username and password
	//add this title to the SQL database
	$username = $_POST['username'];
	$password = $_POST['password'];
  //hash the password for encryption
  $hashed_pass = password_hash($password, PASSWORD_BCRYPT);
	$sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_pass')";

	if ($mysqli->query($sql) === TRUE) {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['reg'] = true;
    $mysqli->close();
    header("Location: news_index.php");
    exit;
	} else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
	}
}
$mysqli->close();
?>