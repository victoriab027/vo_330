<!--
  This page executes the form from new_login.html. It checks to see if they have a valid login, making
  sure to use password_verify() for checking the password and not == or === for security
-->

<?php
require 'database.php';

//gather data from SQL
$stmt = $mysqli->prepare("SELECT COUNT(*), username, password FROM users WHERE username = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
// Bind the parameter
$user = $_POST['username'];
$stmt->bind_param('s', $user);
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $username, $pwd_hash);
$stmt->fetch();

//gather data from user 
$pwd_guess = $_POST['password'];

$isAUser = false;
$validPass = false;

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
    // Login succeeded!
    $stmt->close();
    session_start();
    $_SESSION["username"] = $username;
    $_SESSION["reg"] = true; // is a registered user
    $mysqli->close();
    header("Location: news_index.php"); //direct to index/home page
    exit;
} 
else {
    echo "Invalid login";
}


?>