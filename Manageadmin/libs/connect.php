<?php
## Database Connect #################################################

$db_config=array(
    "host"=>"localhost",  // กำหนด host
    "user"=>"root", // กำหนดชื่อ user
    "pass"=>"root",   // กำหนดรหัสผ่าน
    "dbname"=>"ics_system",  // กำหนดชื่อฐานข้อมูล
    "charset"=>"utf8"  // กำหนด charset
);
/*$db_config=array(
    "host"=>"localhost",  // กำหนด host
    "user"=>"gophomco_system", // กำหนดชื่อ user
    "pass"=>"kcaPDKbz",   // กำหนดรหัสผ่าน
    "dbname"=>"gophomco_system",  // กำหนดชื่อฐานข้อมูล
    "charset"=>"utf8"  // กำหนด charset
);*/
$mysqli = @new mysqli($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["dbname"]);
if(mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    exit;
}
if(!$mysqli->set_charset($db_config["charset"])) { // เปลี่ยน charset เป้น utf8 พร้อมตรวจสอบการเปลี่ยน
//    printf("Error loading character set utf8: %sn", $mysqli->error);  // ถ้าเปลี่ยนไม่ได้
}else{
//    printf("Current character set: %sn", $mysqli->character_set_name()); // ถ้าเปลี่ยนได้
}
############################################
function mysqli_result($res,$row=0,$col=0)
############################################
{ 
    $numrows = mysqli_num_rows($res); 
    if ($numrows && $row <= ($numrows-1) && $row >=0){
        mysqli_data_seek($res,$row);
        $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
        if (isset($resrow[$col])){
            return $resrow[$col];
        }
    }
    return false;
}
//echo $mysqli->character_set_name();  // แสดง charset เอา comment ออก
//echo 'Success... ' . $mysqli->host_info . "n";
//$mysqli->close();
?>