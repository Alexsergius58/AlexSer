<?php 	

session_start();
$_SESSION = [];
session_unset();
session_destroy();
// setrawcookie('login');

header("Location:login.php");
exit;



 ?>