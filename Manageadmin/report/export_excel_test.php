<?php
require '../../vendor/autoload.php'; // include the PHPExcel library
 
 
// import the PhpSpreadsheet Class
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
   
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
   
// การกำหนดค่า ข้อมูลเกี่ยวกับไฟล์ excel 
 $spreadsheet->getProperties()
    ->setCreator("Maarten Balliauw")
    ->setLastModifiedBy("Maarten Balliauw")
    ->setTitle("Office 2007 XLSX Test Document")
    ->setSubject("Office 2007 XLSX Test Document")
    ->setDescription(
        "Test document for Office 2007 XLSX, generated using PHP classes."
    )
    ->setKeywords("office 2007 openxml php")
    ->setCategory("Test result file");
   
$sheet->setCellValue('A1', 'Hello World !'); // กำหนดค่าใน cell A1
$sheet->setCellValue('B1', 'ทดสอบข้อความภาษาไทย !'); // กำหนดค่าใน cell B1
   
$writer = new Xls($spreadsheet);
  
// ชื่อไฟล์
$file_export= "Excel-".date("dmY-Hs");
  
  
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$file_export.'.xls"');
header("Content-Transfer-Encoding: binary ");
  
$writer->save('php://output');
exit(); 
?>