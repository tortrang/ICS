<?php
	define('OFFICE_EXEC', 1);
	define('OFFICE_PATH_BASE', "../..");
	
	require_once( OFFICE_PATH_BASE . "/includes/settings.inc.php");
	require_once( OFFICE_PATH_BASE . "/includes/function.inc.php");
	require_once( OFFICE_PATH_BASE . "/includes/database.mysql.php");
	require_once("thaipdfclass.php");

	# database connection
	$connect = db_connect();
	# check authentication
	require_once( OFFICE_PATH_BASE . "/includes/authentication.php");

		$MonthFullName = array(
			"01" => array("มกราคม", "ม.ค."),
			"02" => array("กุมภาพันธ์", "ก.พ."),
			"03" => array("มีนาคม", "มี.ค."),
			"04" => array("เมษายน", "ม.ย"),
			"05" => array("พฤษภาคม", "พ.ค."),
			"06" => array("มิถุนายน", "มิ.ย."),
			"07" => array("กรกฏาคม", "ก.ค"),
			"08" => array("สิงหาคม", "ส.ค."),
			"09" => array("กันยายน", "ก.ย."),
			"10" => array("ตุลาคม", "ต.ค."),	
			"11" => array("พฤศจิกายน", "พ.ย."),
			"12" => array("ธันวาคม", "ธ.ค." )
		);
	
function utf8_to_tis620($string) {
  $str = $string;
  $res = "";
  for ($i = 0; $i < strlen($str); $i++) {
    if (ord($str[$i]) == 224) {
      $unicode = ord($str[$i+2]) & 0x3F;
      $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
      $unicode |= (ord($str[$i]) & 0x0F) << 12;
      $res .= chr($unicode-0x0E00+0xA0);
      $i += 2;
    } else {
      $res .= $str[$i];
    }
  } 
  return $res;
}

$month = explode("-", $_REQUEST['month']);
#$footer =  'เลขที่เอกสาร EX-M-'.date("Y").'-'.sprintf("%04d", date("m")).' พิมพ์เมื่อ ' . date("d") . " " .$MonthFullName[date("m")][0] . " " . (date("Y")+543) . " เวลา " . date("H:i:s"). " น.";
$footer =  'DOC-REF. EX-M-'.date("Y").'-'.sprintf("%04d", date("m")).' / ' . date("Y-m-d H:i:s") ." / ";
$header = 'ตารางบัญชีรายรับรายจ่ายเดือน' . $MonthFullName[$month[1]][0] . " " .( $month[0]+543 );
$pdf=new ThaiPDF('P','mm','A4');
$pdf->SetThaiFont();
$pdf->SetHeader( '', 0, 'R', 1);
$pdf->SetFooter($footer, 1, 'R', 1);
$pdf->AddPage();
$pdf->SetFont('CordiaNew','B',14); 
$pdf->SetTextColor(0,0,0);
$pdf->Image('idea_header.png',8,5, 80, 23);
$pdf->Ln(5);
$i = 0;
$sql = "select * from expenses, payments,projects where expenses.rec_date like  '".$_REQUEST['month']."%' and expenses.rec_payment = payments.payment_id and projects.proj_id = expenses.proj_id and expenses.rec_status = 1 order by expenses.rec_date, expenses.rec_id";
//echo $sql;
	$exp_total = 0;
	$inc_total = 0;
$result = mssql_query($sql);
while($data = mysql_fetch_object($result)) {
if(substr($data->rec_code,0,3) == "EXP") {
	$sql = "select expense_name as result from expenses_code where expense_id = '".substr($data->rec_code,4)."'";
	//echo $sql;
	$data->rec_code = db_get_one($sql);
	$data->color = "#990000";
	$data->type = "รายจ่าย";
	$exp_total += $data->rec_money;
} else {
	 $sql = "select income_name as result from incomes_code where income_id = '".substr($data->rec_code,4)."'";
	//echo $sql;
	$data->rec_code = db_get_one($sql);
	$data->type = "รายรับ";
	$data->color = "#990000";
	$inc_total += $data->rec_money;
}

	if($i % 21 == 0) {
		if($i != 0) { 
			$pdf->AddPage();
			$pdf->SetFont('CordiaNew','B',14); 
			$pdf->SetTextColor(0,0,0);
			$pdf->Image('i2b_logo.png',8,5, 75, 23);
			$pdf->Ln(7);
		}
		$pdf->Cell(0,10,$header ,0,1,'L');
		$pdf->SetFont('CordiaNew','B',14); 
		//$pdf->Cell(15,7,'ลำดับ',1,0,'C');
		$pdf->Cell(13,7,'รหัส',1,0,'C');
		$pdf->Cell(22,7,'วันที่',1,0,'C');
		$pdf->Cell(60,7,'รายการ',1,0,'C');
		$pdf->Cell(47,7,'ประเภทรายการ',1,0,'C');
		//$pdf->Cell(50,7,'สำหรับ',1,0,'C');
		//$pdf->Cell(32,7,'วิธีการจ่ายเงิน',1,0,'C');
		$pdf->Cell(25,7,'รายรับ',1,0,'C');
		$pdf->Cell(25,7,'รายจ่าย',1,0,'C');
		//$pdf->Cell(30,7,'เอกสารอ้างอิง',1,0,'C');
		$pdf->Ln(7);	
	}
	++$i;
	$pdf->SetFont('CordiaNew','',14); 
	//$pdf->Cell(15,7, $i. '.',1,0,'C');
	$pdf->Cell(13,7, sprintf("%04d",$data->rec_id) ,1,0,'C');
	$pdf->Cell(22,7, $data->rec_date ,1,0,'C');
	$pdf->Cell(60,7,' ' . $data->rec_details ,1,0,'L');
	$pdf->Cell(47,7,' ' . $data->rec_code  ,1,0,'L');
	//$pdf->Cell(50,7,' ' . $data->proj_name ,1,0,'L');
	//$pdf->Cell(32,7,' ' . $data->payment_name ,1,0,'L');
	if($data->type == "รายรับ") {
		$pdf->Cell(25,7, number_format($data->rec_money,2) . '  ',1,0,'R');
		$pdf->Cell(25,7, '',1,0,'R');
	} else {
		$pdf->Cell(25,7, '',1,0,'R');
		$pdf->Cell(25,7, number_format($data->rec_money,2) . '  ',1,0,'R');
	}
	//$pdf->Cell(30,7,' ' . utf8_to_tis620($data->rec_docs) ,1,0,'L');
	$pdf->Ln(7);
}
if($i > 0 ) {
	$pdf->Ln(1);
	$pdf->SetFont('CordiaNew','',14); 
	$pdf->Cell(142,7, 'ยอดรวม  ',0,0,'R');
		$pdf->Cell(25,7, number_format($inc_total,2) . '  ',1,0,'R');
		$pdf->Cell(25,7, number_format($exp_total,2) . '  ',1,0,'R');
	$pdf->Ln(7);
	$pdf->SetFont('CordiaNew','',14); 
	$pdf->Cell(142,7, 'คงเหลือ  ',0,0,'R');
	if($inc_total - $exp_total > 0) {
		$pdf->Cell(25,7, number_format(($inc_total - $exp_total),2) . '  ',1,0,'R');
		$pdf->Cell(25,7, '',1,0,'R');
	} else {
		$pdf->Cell(25,7, '',1,0,'R');
		$pdf->Cell(25,7, number_format(($inc_total - $exp_total),2) . '  ',1,0,'R');
	}
	$pdf->Ln(7);
}

$pdf->Ln(4);
$pdf->Output();


?>
