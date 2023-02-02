
<?php
require 'database.php';

session_start();
//test for validity of the CSRF token on the server side
if(!hash_equals($_SESSION['token'], $_POST['token'])){
    printf("%s, %s", $_SESSION['token'], $_POST['token']);
      die("Request forgery detected");
  }


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
    $_SESSION["username"] = $username;
    $_SESSION["reg"] = true; // is a registered user
    $mysqli->close();
    header("Location: index.php"); //direct to index/home page
    exit;
} 
else {
    echo "Invalid login";
}


?>