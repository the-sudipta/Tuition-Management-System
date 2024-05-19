<?php

session_start();
$_SESSION["data"] = null;
$_SESSION["user_id"] = -1;
setcookie("user_id", -1, time() - 3600, "/");
session_destroy();
$Logout_Page = '/Tuition-Management-System/view/logout.php';
header("Location: {$Logout_Page}");
