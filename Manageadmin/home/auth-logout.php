<?php
ob_start();
include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");

$ipaddress = $_SERVER['REMOTE_ADDR'];

unset($insert);
$insert["log_signinout_memid"] = "'".$_SESSION["core_session_sys_id"]."'";
$insert["log_signinout_date"] = "NOW()";
$insert["log_signinout_type"] = "'Logout'";
$insert["log_signinout_ip"] = "'".$ipaddress."'";
$insert["log_signinout_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
$insert["log_signinout_credate"] = "NOW()";

$sql="INSERT INTO log_signinout(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
$Query=$mysqli->query($sql) OR DIE("Error:  <br>$sql<br>\n");

$_SESSION["core_session_sys_id"]="";
$_SESSION["core_session_sys_name"]="";
$_SESSION["core_session_sys_level"]="";
$_SESSION["core_session_sys_language"]="";
$_SESSION["core_session_sys_permission"]="";
$_SESSION["core_session_logout"]="";
$_SESSION["core_session_sys_type"]="";
$_SESSION["core_session_sys_grpid"]="";
session_destroy();
header('Location: ../home/login.php');

?>