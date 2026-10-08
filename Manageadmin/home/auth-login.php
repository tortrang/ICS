<?php
session_start();
//include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");

$inputUser = trim($_POST["inputUser"]);
$inputPass= trim($_POST["inputPass"]);

	$_SESSION["core_session_logout"]=1;
	//echo "<br> sql == ".
	$sql = "SELECT sys_staff_id, sys_staff_password, sys_staff_fname, sys_staff_lname, sys_staff_perid,sys_staff_email FROM sys_staff INNER JOIN sys_group ON sys_staff_perid = sys_group_id WHERE sys_staff_username ='".$inputUser."' AND sys_staff_status ='1'";
	$Query = $mysqli->query($sql) OR DIE("Error: <br />$sql<br />\n");
	$RecordCount = $Query->num_rows;
	//exit;
	if($RecordCount>=1) {
		$Row=$Query->fetch_array();

		$myPassword=decodeStr($Row["sys_staff_password"]);
		if($myPassword==$inputPass){
			$_SESSION["core_session_sys_id"]	= $Row["sys_staff_id"];
			$_SESSION["core_session_sys_grpid"]	= $Row["sys_staff_perid"];
			$_SESSION["core_session_sys_name"]	= $Row["sys_staff_fname"]." ".$Row["sys_staff_lname"];
			$_SESSION["core_session_sys_level"]="Administrator";
			$_SESSION["core_session_sys_email"]	= $Row["sys_staff_email"];

			//echo "<br> UPDATE == ".
			$sql = "UPDATE sys_staff SET sys_staff_logdate =NOW() WHERE sys_staff_id ='".$_SESSION["core_session_sys_id"]."'";
			$Query=$mysqli->query($sql);

			$ipaddress = $_SERVER['REMOTE_ADDR'];

			unset($insert);
			$insert["log_signinout_memid"] = "'".$_SESSION["core_session_sys_id"]."'";
			$insert["log_signinout_date"] = "'".date('Y-m-d H:i:s')."'";
			$insert["log_signinout_type"] = "'Login'";
			$insert["log_signinout_ip"] = "'".$ipaddress."'";
			$insert["log_signinout_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
			$insert["log_signinout_credate"] = "'".date('Y-m-d H:i:s')."'";
			//echo "<br> INSERT == ".
			$sql="INSERT INTO log_signinout(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
			$Query=$mysqli->query($sql) OR DIE("Error:  <br>$sql<br>\n");
			//echo "<br> 1";
			Header("Location:../home/index.php");
					
		}else{//if($myPassword==$inputPass){
			//echo "<br> 2";
			Header("Location:../home/login.php?alert=yesNoPass");		
		}
	}else{//if($RecordCount>=1) {
		//echo "<br> 3";
		Header("Location:../home/login.php?alert=yesNoUser");
	}

include("../libs/disconnect.php");

?>