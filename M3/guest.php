<!DOCTYPE html>
<!--
    When a user selects to login, a guest, this file is quickly directed to to start a session. It sets a username as
    as guest for display purposes and notes that it is not a registred user.
-->
<?php
session_start();
$_SESSION["username"] = "guest";
$_SESSION["reg"] = false;
header("Location: index.php?guest=true");
exit;

?>