<?php
//echo "checkurl=".
$checkurl = $_SERVER['HTTP_HOST'];
//echo "<br>checkname=".
$checkname1="www.pp-casita.com";
$checkname2="pp-casita.com";
//if( strpos( $checkurl, $checkname )) {
if ($checkurl==$checkname1 || $checkurl==$checkname2){   
	//echo "พบคำที่ค้นหา";

}else{
	//echo "ไม่พบคำที่ค้นหา";
	$Subject = "ละเมิดลิขสิทธิ์ระบบ Southern Web & Service(".$checkurl.")";
    $to = "jirasak.usp@gmail.com";
    $subject = "=?utf-8?B?".base64_encode($Subject)."?=";
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";
    //$header .= "From: ".$Row_info[$mod_sys_info."_title"]."";
    //$header .= "<".$Row_info[$mod_sys_info."_emailsystem"].">";
    $message = '<b>ตรวจสอบพบว่ามีการนำไประบบไปใช้โดยไม่รับการอนุญาตจากเจ้าของ</b><br>
				<p>ที่มาของระบบ : '.$checkname1.'</p>
				<p>ที่มาของระบบ : '.$checkname2.'</p>
				<p>การนำไปใช้งาน : '.$_SERVER['HTTP_HOST'].'</p>
				<p>ลงวันที่ : '.date("d/m/Y H:i:s").'</p>';
                //แจ้งไปที่ลูกค้า       
    @mail($to, $subject, $message, $header);
	/*if(@mail){
		echo "<br>Send";
	}else{
		echo "<br>Not Send";
	}*/
}
?>                                                                    