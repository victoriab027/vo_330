<?php
session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));
header("Location: login.html");
exit;

?>