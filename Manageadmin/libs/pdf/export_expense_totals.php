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

//$footer =  'พิมพ์เมื่อ ' . date("d") . " " .$MonthFullName[date("m")][0] . " " . (date("Y")+543) . " เวลา " . date("H:i:s"). " น.";
$header = 'ตารางแสดงยอดรวมรายรับรายจ่ายทั้งหมด';
$footer =  'DOC-REF.  EX-A-'.date("Y").'-'.sprintf("%04d",date("md")).' / ' . date("Y-m-d H:i:s") ." / ";
$pdf=new ThaiPDF('P','mm','A4');
$pdf->SetThaiFont();
$pdf->SetHeader( '', 0, 'R', 1);
$pdf->SetFooter($footer, 1, 'R', 1);
$pdf->AddPage();
$pdf->SetFont('CordiaNew','B',14); 
$pdf->SetTextColor(0,0,0);
$pdf->Image('i2b_logo.png',8,5, 75, 23);
$pdf->Ln(5);
$i = 0;
$count = 0;
$exp_total = 0;
$inc_total = 0;
$sql = "select * from projects where proj_status > 0";
//echo $sql;
$result = db_query($sql);
if(db_count_result($sql)) {
	while($pj = db_fetch_result($result)) {
		$bgcolor = ($count%2) ? "#ffffff" : "#efefef";
		$pj->exp_total = 0;
		$pj->inc_total = 0;
		$sql = "select * from expenses where proj_id = $pj->proj_id and rec_status = 1 and rec_code like 'EXP%'";
		$result2 = db_query($sql);
		if(db_count_result($sql)) {
			while($rec = db_fetch_result($result2)) {
				$pj->exp_total += $rec->rec_money;
			}
		}
		$sql = "select * from expenses where proj_id = $pj->proj_id and rec_status = 1 and rec_code like 'INC%'";
		$result2 = db_query($sql);
		if(db_count_result($sql)) {
			while($rec = db_fetch_result($result2)) {
				$pj->inc_total += $rec->rec_money;
			}
		}
		$inc_total += $pj->inc_total;
		$exp_total += $pj->exp_total;

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
			$pdf->Cell(25,7,'รหัสโครงการ',1,0,'C');
			$pdf->Cell(95,7,'โครงการ',1,0,'C');
			$pdf->Cell(35,7,'รายรับ',1,0,'C');
			$pdf->Cell(35,7,'รายจ่าย',1,0,'C');
			$pdf->Ln(7);	
		}
		++$i;
		$pdf->SetFont('CordiaNew','',14); 
		$pdf->Cell(25,7,sprintf("%04d",$pj->proj_id),1,0,'C');
		$pdf->Cell(95,7,' ' . $pj->proj_name ,1,0,'L');
		$pdf->Cell(35,7, number_format($pj->inc_total,2) . '  ',1,0,'R');
		$pdf->Cell(35,7, number_format($pj->exp_total,2) . '  ',1,0,'R');
		$pdf->Ln(7);
	}
}
if($i > 0 ) {
	$pdf->Ln(1);
	$pdf->SetFont('CordiaNew','',14); 
	$pdf->Cell(120,7, 'ยอดรวม  ',0,0,'R');
	$pdf->Cell(35,7, number_format($inc_total,2) . '  ',1,0,'R');
	$pdf->Cell(35,7, number_format($exp_total,2) . '  ',1,0,'R');
	$pdf->Ln(7);
	$pdf->SetFont('CordiaNew','',14); 
	$pdf->Cell(120,7, 'คงเหลือ  ',0,0,'R');
	$pdf->Cell(35,7, '',1,0,'R');
	$pdf->Cell(35,7, number_format(($inc_total - $exp_total),2) . '  ',1,0,'R');

	$pdf->Ln(7);
}

$pdf->Output();


?>
