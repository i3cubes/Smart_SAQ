<?php
session_start();
session_destroy();
//unset($_SESSION['DESIGNATION']);
header("Location:index");

//var_dump($_SESSION['DESIGNATION']);
exit();
?>