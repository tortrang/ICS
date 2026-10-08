<?php 
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");
	
if($_SESSION['core_session_sys_language']=="thai"){
	include("../order/language_thai.php");
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../order/language_eng.php");	
	include("../libs/language_eng.php");
}
include("../../libs/language_thai.php");;
?>
<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../libs/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// กำหนด รูปภาพ style ที่จะใช้  
$styleArray = array(  
    'font'  => array(  
//        'bold'  => true,  
//        'color' => array('rgb' => 'FF0000'),  
        'size'  => 16,  
        'name'  => 'Angsana New'  // ภาษาไทย  
    )
	
);
$styleArray=array(
	'borders'=>array(
		'allborders'=>array(
			'style'=>PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);
	
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
// การจัดรูปแบบของ cell  
$objPHPExcel->getDefaultStyle()  
                        ->applyFromArray($styleArray)  
                        ->getAlignment()  
                        ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)  
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
						
						 
                        //HORIZONTAL_CENTER //VERTICAL_CENTER  
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);

$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:A3');
$objPHPExcel->getActiveSheet()->mergeCells('B2:B3');
$objPHPExcel->getActiveSheet()->mergeCells('C2:C3');
$objPHPExcel->getActiveSheet()->mergeCells('D2:D3');
$objPHPExcel->getActiveSheet()->mergeCells('E2:E3');
$objPHPExcel->getActiveSheet()->mergeCells('F2:F3');
$objPHPExcel->getActiveSheet()->mergeCells('G2:G3');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('F')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
// Add some data
	
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', "รายงานยอดซื้อ")
            ->setCellValue('A2', 'รหัสใบเสร็จ')
			->setCellValue('B2', 'สินค้า')
			->setCellValue('C2', 'ราคาต่อหน่วย')
			->setCellValue('D2', 'จำนวน')
			->setCellValue('E2', 'ราคารวม')
			->setCellValue('F2', 'วันที่')
			->setCellValue('G2', 'เจ้าหน้าที่');
			   
		   $sql = "SELECT * FROM md_billing_detail WHERE md_billing_detail_status!='2'";
			if($_REQUEST["product"]!=""){
				$sql .= " AND md_billing_detail_productid = '".$_REQUEST["product"]."'";
			}
			if($_REQUEST["startdate"]!="" && $_REQUEST["enddate"]!=""){
				$sql .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
			}  
			$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
			$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล         
                                        
$objPHPExcel->getActiveSheet()->getStyle('C'.$Cell_index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel->getActiveSheet()->getStyle('E'.$Cell_index)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel->getActiveSheet()->getRowDimension($Cell_index)->setRowHeight(20);
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$Cell_index, getBillCode($row["md_billing_detail_billingid"]))
			->setCellValue('B'.$Cell_index, getProductName($row["md_billing_detail_productid"]))
			->setCellValue('C'.$Cell_index, $row["md_billing_detail_price"])
			->setCellValue('D'.$Cell_index, $row["md_billing_detail_amount"])
			->setCellValue('E'.$Cell_index, $row["md_billing_detail_total"])
			->setCellValue('F'.$Cell_index, ShowDateTimeThai($row["md_billing_detail_credate"]))
			->setCellValue('G'.$Cell_index, getBillCrebyid($row["md_billing_detail_billingid"]));
			
$Cell_index++;
$index++;
	 }// while($Row=$query->fetch_array()){ 
			   }//if($count_row>0){ 

$calculate=$Cell_index-1;
$objPHPExcel->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E'.$Cell_index)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValue('C'.$Cell_index, '=SUM(C4:C'.$calculate.')');
$objPHPExcel->getActiveSheet()->setCellValue('E'.$Cell_index, '=SUM(E4:E'.$calculate.')');
	
	
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('รายงานยอดซื้อ');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="รายงานยอดซื้อ.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
