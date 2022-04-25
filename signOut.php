<?php
session_start();
session_destroy();
//unset($_SESSION['DESIGNATION']);
header("Location:index");
print "<script type='text/javascript'>sessionStorage.removeItem('JWT');</script>";
//var_dump($_SESSION['DESIGNATION']);
exit();
?>