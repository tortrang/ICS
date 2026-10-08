<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");

$name="รายงานสรุปประจำวันของ";
$text="วันที่";
$datenow=$_REQUEST["startdate"];
if($_REQUEST["startdate"]!=$_REQUEST["enddate"]){
	$datenow=$_REQUEST["startdate"]." - ".$_REQUEST["enddate"];
}

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
$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(5);
$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(15);
$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(30);
$spreadsheet->getActiveSheet()->getColumnDimension('S')->setWidth(15);

$spreadsheet->getActiveSheet()->mergeCells('A1:H1');
$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical('middle');
$spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical('middle');
$spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('H3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->mergeCells('A2:F2');
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('A2')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->mergeCells('H2:M2');
$spreadsheet->getActiveSheet()->getStyle('H2')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('H3')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('I3')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('J3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('K3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('L3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('M3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('O2')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->mergeCells('O2:S2');
$spreadsheet->getActiveSheet()->getStyle('O2')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('O3')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('P3')->getFont()->setBold(true); 
$spreadsheet->getActiveSheet()->getStyle('Q3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('R3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('S3')->getFont()->setBold(true);

   
$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', $name.$text." ".$datenow)
		->setCellValue('A2', 'สรุปบิลซื้อ')
		->setCellValue('A3', '#')
		->setCellValue('B3', 'วันที่')
		->setCellValue('C3', 'รายการ')
		->setCellValue('D3', 'จำนวน')
		->setCellValue('E3', 'ราคาต่อหน่วย')
		->setCellValue('F3', 'ราคารวม')
		->setCellValue('H2', 'สรุปบิลขาย')
		->setCellValue('H3', '#')
		->setCellValue('I3', 'วันที่')
		->setCellValue('J3', 'รายการ')
		->setCellValue('K3', 'จำนวน')
		->setCellValue('L3', 'ราคาต่อหน่วย')
		->setCellValue('M3', 'ราคารวม')
		->setCellValue('O2', 'บิลค่าใช้จ่าย')
		->setCellValue('O3', '#')
		->setCellValue('P3', 'วันที่')
		->setCellValue('Q3', 'รายการ')
		->setCellValue('R3', 'รายละเอียด')
		->setCellValue('S3', 'จำนวน');

//บิลซื้อ
$Cell_index=4;
$index=1;
$array=0;
$Cell_total_index = [];
$sql_catalog = "SELECT * FROM md_catalog WHERE md_catalog_status='1' ORDER BY md_catalog_name ASC";  
$query_catalog=$mysqli->query($sql_catalog) or die("Error sql_catalog: เกิดความผิดพลาด <br>$sql_catalog\n");   
while($row_catalog=$query_catalog->fetch_array()){ 
	$total_cat_amout=0;
	$total_cat_total=0;
	$sql_catalogid = "SELECT md_product_catalogid FROM md_billing_detail LEFT JOIN md_billing ON md_billing_id=md_billing_detail_billingid LEFT JOIN md_product ON md_product_id=md_billing_detail_productid WHERE md_billing_status='1'";  
	$sql_catalogid .= " AND md_product_catalogid='".$row_catalog['md_catalog_id']."'";
	$sql_catalogid .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59' LIMIT 1";
	//echo $sql;
	$query_catalogid=$mysqli->query($sql_catalogid) or die("Error sql1: เกิดความผิดพลาด <br>$sql_catalogid\n"); 
	$count_row_catalogid=$query_catalogid->num_rows; 
	if($count_row_catalogid>0){ 
		$spreadsheet->getActiveSheet()->getStyle('B'.$Cell_index)->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->setBold(true);
		$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('B'.$Cell_index, $_REQUEST["startdate"])
				->setCellValue('C'.$Cell_index, getCatalogName($row_catalog['md_catalog_id']));
			$Cell_index++;
			$Cell_cat_index=$Cell_index;
				

			$sql_product = "SELECT * FROM md_product WHERE md_product_status='1' AND md_product_catalogid='".$row_catalog['md_catalog_id']."' ORDER BY md_product_name ASC";  
			$query_product=$mysqli->query($sql_product) or die("Error sql_product: เกิดความผิดพลาด <br>$sql_product\n");   
			while($row_product=$query_product->fetch_array()){
				$total_amout=0;
				$md_billing_detail_total=0;
				//md_billing_detail_basket,md_billing_detail_productid,md_billing_detail_price,md_billing_detail_amount,md_billing_detail_total
				$sql_distinct = "SELECT DISTINCT(md_billing_detail_productid) FROM md_billing,md_billing_detail WHERE md_billing_id=md_billing_detail_billingid AND md_billing_status='1' AND md_billing_detail_productid='".$row_product['md_product_id']."'";  
				$sql_distinct .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
				//echo $sql;
				$query_distinct=$mysqli->query($sql_distinct) or die("Error sql_distinct: เกิดความผิดพลาด <br>$sql_distinct\n"); 
				$count_distinct=$query_distinct->num_rows; 
				while($row_distinct=$query_distinct->fetch_array()){    
					
					$sql_bill = "SELECT * FROM md_billing,md_billing_detail WHERE md_billing_id=md_billing_detail_billingid AND md_billing_status='1' AND md_billing_detail_productid='".$row_product['md_product_id']."'";  
					$sql_bill .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
					//echo $sql;
					$query_bill=$mysqli->query($sql_bill) or die("Error sql_bill: เกิดความผิดพลาด <br>$sql_bill\n"); 
					while($row_bill=$query_bill->fetch_array()){    

						if($row_bill["md_billing_detail_basket"]>0){
							$md_billing_detail_amount=$row_bill["md_billing_detail_amount"]*$row_bill["md_billing_detail_basket"];
						}else{
							$md_billing_detail_amount=$row_bill["md_billing_detail_amount"];
						}
						$md_billing_detail_price=$row_bill["md_billing_detail_price"];
						$total_amout=$total_amout+$md_billing_detail_amount;
						$md_billing_detail_total=$md_billing_detail_total+$row_bill["md_billing_detail_total"];
						
					}//while($row_bill=$query_bill->fetch_array()){  
						$total_cat_amout=$total_cat_amout+$total_amout;
						$total_cat_total=$total_cat_total+$md_billing_detail_total;
						
					$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
					$spreadsheet->setActiveSheetIndex(0)
								->setCellValue('A'.$Cell_index, $index)
								->setCellValue('C'.$Cell_index, getProductName($row_distinct["md_billing_detail_productid"]))
								->setCellValue('D'.$Cell_index, $total_amout)
								->setCellValue('E'.$Cell_index, $md_billing_detail_price)
								->setCellValue('F'.$Cell_index, $md_billing_detail_total);
			$Cell_index++;
			$index++;
				}//while($row1=$query1->fetch_array()){ 
		}//while($row_product=$query_product->fetch_array()){
			$calculate=$Cell_index-1;
			$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
			$spreadsheet->getActiveSheet()->setCellValue('C'.$Cell_index, 'ยอดรวม');
			$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
			$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$spreadsheet->getActiveSheet()->setCellValue('D'.$Cell_index, '=SUM(D'.$Cell_cat_index.':D'.$calculate.')');
			$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
			$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$spreadsheet->getActiveSheet()->setCellValue('F'.$Cell_index, '=SUM(F'.$Cell_cat_index.':F'.$calculate.')');
			
			$calculate++;
			$Cell_total_index[$array]=[
				"number" => $calculate
			];
			$Cell_index++;
			$array++;

	}//if($count_row_catalogid>0){ 
	$totalamout=$totalamout+$total_cat_amout;
	$total=$total+$total_cat_total;
}// while($row_catalog=$query_catalog->fetch_array()){
	foreach ($Cell_total_index as $key => $value){
		$cal="D".$Cell_total_index[0]['number'];
		if($key>0){
			$cal.="+D".$Cell_total_index[$key]['number'];
		}
		//$cal1="F".$Cell_total_index[0]['number'];
		//if($key>0){
			$cal1.="+F".$Cell_total_index[$key]['number'];
		//}
	}
	$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->setCellValue('C'.$Cell_index, 'รวมทั้งหมด');
	$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->getStyle('D'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$spreadsheet->getActiveSheet()->setCellValue('D'.$Cell_index, '=SUM('.$cal.')');
	$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->getStyle('F'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$spreadsheet->getActiveSheet()->setCellValue('F'.$Cell_index, '=SUM('.$cal1.')');

///////บิลขาย

$Cell_index=4;
$index=1;
$array=0;
$Cell_total_index = [];
$sql_catalog = "SELECT * FROM md_catalog WHERE md_catalog_status='1' ORDER BY md_catalog_name ASC";  
$query_catalog=$mysqli->query($sql_catalog) or die("Error sql_catalog: เกิดความผิดพลาด <br>$sql_catalog\n");   
while($row_catalog=$query_catalog->fetch_array()){ 
	$total_cat_amout=0;
	$total_cat_total=0;
	$sql_catalogid = "SELECT md_product_catalogid FROM md_billing_detail LEFT JOIN md_billing_sell ON md_billing_id=md_billing_detail_billingid LEFT JOIN md_product ON md_product_id=md_billing_detail_productid WHERE md_billing_status='1'";  
	$sql_catalogid .= " AND md_product_catalogid='".$row_catalog['md_catalog_id']."'";
	$sql_catalogid .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59' LIMIT 1";
	//echo $sql;
	$query_catalogid=$mysqli->query($sql_catalogid) or die("Error sql1: เกิดความผิดพลาด <br>$sql_catalogid\n"); 
	$count_row_catalogid=$query_catalogid->num_rows; 
	if($count_row_catalogid>0){ 
		$spreadsheet->getActiveSheet()->getStyle('B'.$Cell_index)->getFont()->setBold(true);
		$spreadsheet->getActiveSheet()->getStyle('C'.$Cell_index)->getFont()->setBold(true);
		$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('B'.$Cell_index, $_REQUEST["startdate"])
				->setCellValue('C'.$Cell_index, getCatalogName($row_catalog['md_catalog_id']));
			$Cell_index++;
			$Cell_cat_index=$Cell_index;
				

			$sql_product = "SELECT * FROM md_product WHERE md_product_status='1' AND md_product_catalogid='".$row_catalog['md_catalog_id']."' ORDER BY md_product_name ASC";  
			$query_product=$mysqli->query($sql_product) or die("Error sql_product: เกิดความผิดพลาด <br>$sql_product\n");   
			while($row_product=$query_product->fetch_array()){
				$total_amout=0;
				$md_billing_detail_total=0;
				//md_billing_detail_basket,md_billing_detail_productid,md_billing_detail_price,md_billing_detail_amount,md_billing_detail_total
				$sql_distinct = "SELECT DISTINCT(md_billing_detail_productid) FROM md_billing_sell,md_billing_detail_sell WHERE md_billing_id=md_billing_detail_billingid AND md_billing_status='1' AND md_billing_detail_productid='".$row_product['md_product_id']."'";  
				$sql_distinct .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
				//echo $sql;
				$query_distinct=$mysqli->query($sql_distinct) or die("Error sql_distinct: เกิดความผิดพลาด <br>$sql_distinct\n"); 
				$count_distinct=$query_distinct->num_rows; 
				while($row_distinct=$query_distinct->fetch_array()){    
					
					$sql_bill = "SELECT * FROM md_billing_sell,md_billing_detail_sell WHERE md_billing_id=md_billing_detail_billingid AND md_billing_status='1' AND md_billing_detail_productid='".$row_product['md_product_id']."'";  
					$sql_bill .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
					//echo $sql;
					$query_bill=$mysqli->query($sql_bill) or die("Error sql_bill: เกิดความผิดพลาด <br>$sql_bill\n"); 
					while($row_bill=$query_bill->fetch_array()){    

						if($row_bill["md_billing_detail_basket"]>0){
							$md_billing_detail_amount=$row_bill["md_billing_detail_amount"]*$row_bill["md_billing_detail_basket"];
						}else{
							$md_billing_detail_amount=$row_bill["md_billing_detail_amount"];
						}
						$md_billing_detail_price=$row_bill["md_billing_detail_price"];
						$total_amout=$total_amout+$md_billing_detail_amount;
						$md_billing_detail_total=$md_billing_detail_total+$row_bill["md_billing_detail_total"];
						
					}//while($row_bill=$query_bill->fetch_array()){  
						$total_cat_amout=$total_cat_amout+$total_amout;
						$total_cat_total=$total_cat_total+$md_billing_detail_total;
						
						$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
						$spreadsheet->setActiveSheetIndex(0)
									->setCellValue('H'.$Cell_index, $index)
									->setCellValue('J'.$Cell_index, getProductName($row_distinct["md_billing_detail_productid"]))
									->setCellValue('K'.$Cell_index, $total_amout)
									->setCellValue('L'.$Cell_index, $md_billing_detail_price)
									->setCellValue('M'.$Cell_index, $md_billing_detail_total);
			$Cell_index++;
			$index++;
				}//while($row1=$query1->fetch_array()){ 
		}//while($row_product=$query_product->fetch_array()){
			$calculate=$Cell_index-1;
			$spreadsheet->getActiveSheet()->getStyle('J'.$Cell_index)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('J'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
			$spreadsheet->getActiveSheet()->setCellValue('J'.$Cell_index, 'ยอดรวม');
			$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
			$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$spreadsheet->getActiveSheet()->setCellValue('K'.$Cell_index, '=SUM(K'.$Cell_cat_index.':K'.$calculate.')');
			$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getFont()->setBold(true);
			$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
			$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$spreadsheet->getActiveSheet()->setCellValue('M'.$Cell_index, '=SUM(M'.$Cell_cat_index.':M'.$calculate.')');
			
			$calculate++;
			$Cell_total_index[$array]=[
				"number" => $calculate
			];
			$Cell_index++;
			$array++;

	}//if($count_row_catalogid>0){ 
	$totalamout=$totalamout+$total_cat_amout;
	$total=$total+$total_cat_total;
}// while($row_catalog=$query_catalog->fetch_array()){
	$cal="";
	$cal1="";
	foreach ($Cell_total_index as $key => $value){
		$cal="K".$Cell_total_index[0]['number'];
		if($key>0){
			$cal.="+K".$Cell_total_index[$key]['number'];
		}
		//$cal1="M".$Cell_total_index[0]['number'];
		//if($key>0){
			$cal1.="+M".$Cell_total_index[$key]['number'];
		//}
	}
	if($cal!="" && $cal1!=""){
	$spreadsheet->getActiveSheet()->getStyle('J'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('J'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->setCellValue('J'.$Cell_index, 'รวมทั้งหมด');
	$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->getStyle('K'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$spreadsheet->getActiveSheet()->setCellValue('K'.$Cell_index, '=SUM('.$cal.')');
	$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->getStyle('M'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$spreadsheet->getActiveSheet()->setCellValue('M'.$Cell_index, '=SUM('.$cal1.')');
	}

////// ค่าใช้จ่าย	

$Cell_index=4;
$index=1;
$sql = "SELECT * FROM md_income WHERE md_income_status='1'";
$sql .= " AND md_income_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";  
$sql .= " ORDER BY md_income_typeid ASC";
$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");   
while($row=$query->fetch_array()){ 
	$spreadsheet->getActiveSheet()->getStyle('S'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('O'.$Cell_index, $index)
				->setCellValue('P'.$Cell_index, $_REQUEST["startdate"])
				->setCellValue('Q'.$Cell_index, getTypeIncome($row["md_income_typeid"]))		
				->setCellValue('R'.$Cell_index, $row["md_income_detail"])
				->setCellValue('S'.$Cell_index, $row["md_income_total"]);
$Cell_index++;
$index++;
}
	if($Cell_index>4){
	$calculate=$Cell_index-1;
	$spreadsheet->getActiveSheet()->getStyle('R'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('R'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->setCellValue('R'.$Cell_index, 'รวมทั้งหมด');
	$spreadsheet->getActiveSheet()->getStyle('S'.$Cell_index)->getFont()->setBold(true);
	$spreadsheet->getActiveSheet()->getStyle('S'.$Cell_index)->getFont()->getColor()->setARGB(Color::COLOR_RED);
	$spreadsheet->getActiveSheet()->getStyle('S'.$Cell_index)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
	$spreadsheet->getActiveSheet()->setCellValue('S'.$Cell_index, '=SUM(S4:S'.$calculate.')');
	}
// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('รายงานสรุปประจำวันของ');

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
