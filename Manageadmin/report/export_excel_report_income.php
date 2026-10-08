<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");

$name="รายงานสรุปค่าใช้จ่ายประจำวันของ";
$text="วันที่";
$datenow=$_REQUEST["startdate"];

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

$spreadsheet = new Spreadsheet();


// กำหนด รูปภาพ style ที่จะใช้  
$styleArray = array(
    'font'  => array( 
        'size'  => 18,
        'name'  => 'Angsana New'  // ภาษาไทย  
    ) 
);
$spreadsheet->getDefaultStyle()
	->applyFromArray($styleArray)  
	->getAlignment()  
	->setVertical(Alignment::VERTICAL_CENTER)  
	->setHorizontal(Alignment::HORIZONTAL_CENTER); 

$spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);

$spreadsheet->getActiveSheet()->mergeCells('A1:H1');
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical('middle');
$spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal('center');
 

$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
   
$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', $name.$text." ".$datenow)
		->setCellValue('A2', '#')
		->setCellValue('B2', 'วันที่')
		->setCellValue('C2', 'รายการ')
		->setCellValue('D2', 'จำนวนเงิน')
		->setCellValue('E2', 'รายละเอียด')
		->setCellValue('F2', 'เจ้าหน้าที่');

$sql = "SELECT * FROM md_income WHERE md_income_status='1'";
if($_REQUEST["startdate"]!="" && $_REQUEST["enddate"]!=""){
	$sql .= " AND md_income_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
}  
//echo $sql;
$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
$Cell_index=3;
$index=1;
$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
if($count_row>0){ 
	while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล     
$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$spreadsheet->getActiveSheet()->getStyle('E'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A'.$Cell_index, $index)
		->setCellValue('B'.$Cell_index, ShowDateTimeThai($row["md_income_date"]))
		->setCellValue('C'.$Cell_index, getTypeIncome($row["md_income_typeid"]))
		->setCellValue('D'.$Cell_index, $row["md_income_total"])
		->setCellValue('E'.$Cell_index, $row["md_income_detail"])
		->setCellValue('F'.$Cell_index, getStaffName($row["md_income_crebyid"]));
$Cell_index++;
$index++;
	}// while($Row=$query->fetch_array()){ 
}//if($count_row>0){ 
$calculate=$Cell_index-1;
$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
$spreadsheet->getActiveSheet()->setCellValue('C'.$Cell_index, 'ยอดรวม');
$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$spreadsheet->getActiveSheet()->setCellValue('D'.$Cell_index, '=SUM(D3:D'.$calculate.')');
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('รายงานค่าใช้จ่ายประจำวัน');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$name.$text." ".$datenow.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$xlsxWriter = PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
exit($xlsxWriter->save('php://output'));
