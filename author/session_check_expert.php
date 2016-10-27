<?php 

session_start(); 
if (!isset($_SESSION['IS_EXPERT'])) { header("Location: http://admin.iwine.com.tw/author/login.php"); }

?>