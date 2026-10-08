<?php

include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");
include("../md_structure/config.php");


//echo"input_EmployeeCodeDefualt=".
$input_usernameDefualt = $_REQUEST["input_usernameDefualt"];
//echo"input_EmployeeCode=". 
$input_username = $_REQUEST["input_username"];
if($input_username!=""){
	if($input_usernameDefualt!=$input_username){
$sql = "select * from ".$mod_sys_staff." where ".$mod_sys_staff."_username = '$input_username'";

//echo $sql;
$result = $mysqli->query($sql);
$num = $result->num_rows; //นับจำนวนแถวที่ query ได้

if($num == 0){ // query ไม่ได้เลย = login ไม่ผ่าน
	echo $input_username;
}

}else{
	echo $input_username;
}
}else{
	echo "1";
}
?>