<?php 
include("../lib/config.php");

//###################################### by Yoseigi (21 July 2014) #### 
class format {
//#####################################################################


public function date1($DateTime) { // by Yoseigi (21 July 2014)
//### Format 'Y-m-d' to 'd/m/Y'
	global $System_Session_Language;
	$DateTimeArr = explode(" ",$DateTime);
	$Date = $DateTimeArr[0];
	$Time = $DateTimeArr[1];
	$DateArr = explode("-",$Date);
	if($System_Session_Language=="Thai") $DateArr[0] = ($DateArr[0] + 543)- 2500;
	return $DateArr[2]."/".$DateArr[1]."/".$DateArr[0];
}

} // Class Format



//###################################### by Yoseigi (21 July 2014) #### 
class calculate { 
//#####################################################################

public function cal_expire($date) { // by Yoseigi (21 July 2014)
	if($date<date('Y-m-d')){
		echo "<span style='color:#aa7316;'>Expired</span>";
	}else{
		$format = new format;
		echo $format->date1($date);
	}
}


} // Class calculate


//###################################### by Yoseigi (25 July 2014) #### 
class formatString { 
//#####################################################################

public function fullGender($gender) { // by Yoseigi (28 July 2014)
  if($gender!=NULL){
	if($gender=="M"){
		echo "Male"; 
	}else if($gender=="F"){
		echo "Female"; 
	}else{
		echo "&nbsp;";	
	}
  }
}

public function confirmPackage($status) { // by Yoseigi (25 July 2014)
  if($status!=NULL){
	if($status=="Y"){
		echo "Confirm";
	}else if($status=="N"){
		echo "Not Confirm";
	}else{
		echo "&nbsp;";
	}
  }
}

public function statusVerrify($statusVerrify) { // by Yoseigi (29 July 2014)
  if($statusVerrify!=NULL){
	if($statusVerrify==1){
		echo "Not Verify"; 
	}else if($statusVerrify==2){
		echo "Verify"; 
	}
  }
}

public function chkNull($data) { // by Yoseigi (29 July 2014)
	if($data==NULL){	
		echo "-"; 
	}else{
		echo $data; 
	}
}

} // Class formatString


class getName { // by Yoseigi (31 July 2014)

public function statusCheckup($statusid){ // by Yoseigi (31 July 2014)
	global $core_db_name, 
		$mod_chk_chk_status, 
		$mod_chk_chk_status_id, 
		$mod_chk_chk_status_name;
	
	$sql = "SELECT ".$mod_chk_chk_status_name." 
		FROM ".$mod_chk_chk_status." 
		WHERE 1=1 
		AND ".$mod_chk_chk_status_id."='".$statusid."'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row[$mod_chk_chk_status_name];
}

public function compName($compid){ // by Yoseigi (31 July 2014)
	global $core_db_name, 
		$mod_set_comp, 
		$mod_set_comp_id, 
		$mod_set_comp_name;
	
	$sql = "SELECT ".$mod_set_comp_name." 
		FROM ".$mod_set_comp." 
		WHERE 1=1 
		AND ".$mod_set_comp_id."='".$compid."'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row[$mod_set_comp_name];
}

public function grpName($grpid){ // by Yoseigi (31 July 2014)
	global $core_db_name, 
		$mod_set_grp, 
		$mod_set_grp_id, 
		$mod_set_grp_name;
	
	$sql = "SELECT ".$mod_set_grp_name." 
		FROM ".$mod_set_grp." 
		WHERE 1=1 
		AND ".$mod_set_grp_id."='".$grpid."'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row[$mod_set_grp_name];
}

public function provNameEN($provid){ // by Yoseigi (01 August 2014)
	global $core_db_name, 
		$mod_sys_prov, 
		$mod_sys_prov_code, 
		$mod_sys_prov_nameen;
	
	$sql = "SELECT ".$mod_sys_prov_nameen." 
		FROM ".$mod_sys_prov." 
		WHERE 1=1 
		AND ".$mod_sys_prov_code."='".$provid."'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row[$mod_sys_prov_nameen];
}

public function saleName($salesid){ // by ต้อสุดหล่อ
	global $core_db_name, 
		$mod_set_user, 
		$mod_set_user_id, 
		$mod_set_user_fname, 
		$mod_set_user_lname;
	
	$sql = "SELECT ".$mod_set_user_fname.", ".$mod_set_user_lname." 
		FROM ".$mod_set_user." 
		WHERE 1=1 
		AND ".$mod_set_user."_id = '".$salesid."'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row[$mod_set_user_fname]." ".$row[$mod_set_user_lname];
}

} // Class getName
?>