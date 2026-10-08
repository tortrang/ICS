<?php
session_start();
setcookie("cookie_id", $_SESSION["core_session_sys_id"],strtotime("+3 month")); 
#############################
##    BASE Session       ##
#############################
// Session Handle Current User Information ------------------
if(!isset($_SESSION["core_session_sys_id"])) {
   $_SESSION["core_session_sys_id"]="";
}
if(!isset($_SESSION["core_session_sys_name"])){
    $_SESSION["core_session_sys_name"]="";
}
if(!isset($_SESSION["core_session_sys_level"])){
   $_SESSION["core_session_sys_level"]="";
}
if(!isset($_SESSION["core_session_sys_grpid"])){
   $_SESSION["core_session_sys_grpid"]="";
}
if(!isset($_SESSION["core_session_sys_language"])){
   $_SESSION["core_session_sys_language"]="thai";
}
if(!isset($_SESSION["core_session_sys_permission"])){
   $_SESSION["core_session_sys_permission"]="";
}
if(!isset($_SESSION["core_session_sys_mode"])){
   $_SESSION["core_session_sys_mode"]="";
}
if(!isset($_SESSION["core_session_sys_menu"])){
   $_SESSION["core_session_sys_menu"]="../home/home.php?masterkey=home";
}
if($_SESSION["core_session_sys_id"]==""){
  if($_COOKIE["cookie_id"]!=""){ 
	$_SESSION["core_session_sys_id"]	= $_COOKIE["cookie_id"];	
  }else{
	  if(strstr($_SERVER['REQUEST_URI'],"home/login.php")!="home/login.php"){
		echo "<script type='text/javascript'>
		   parent.document.location.href = '../home/login.php';	
		   </script>";
	  }
  }
}
?>