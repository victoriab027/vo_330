<!--
  This page executes the form from new_login.html. It checks to see if they have a valid login, making
  sure to use password_verify() for checking the password and not == or === for security
-->
<?php
session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));
?>

<html>
<body>
<h2>Welcome to Bears News!</h2>
<h3>Login</h3>

<form action = "login_execute.php" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
    <input type="submit" value="Submit">
  </form> 
 

</form>
<p>Or <a href="guest.php">continue as guest</a></p> 
<p>Or <a href="new_user.php">create an account</a></p> 

</body>
</html>
