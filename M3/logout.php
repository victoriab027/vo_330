<!DOCTYPE html>
<!--
    This file destorys the current session in order to logout the current user and 
    directs them back to the login page
-->
<?php
session_destroy();
header("Location: login.php");
exit;

?>