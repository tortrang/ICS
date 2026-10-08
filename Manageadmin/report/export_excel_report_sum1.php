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
$txt_mod["billing:color"] = array('','success','danger','warning');
$txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก','รอดำเนินการ');
 
//header("Content-Type: application/vnd.ms-excel");
//header('Content-Disposition: attachment; filename="excel_report.xls"');# ชื่อไฟล์

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
</HEAD>

<BODY>
<table BORDER='1'>
	<tr>
		<td align="center">สรุปบิลซื้อ</td>
		<td align="center">สรุปบิลขาย</td>
		<td align="center">สรุปบิลค่าใช้จ่าย</td>
	</tr>
	<tr>
		<td valign="top">
		<!--บิลซื้อ-->
		<TABLE  x:str BORDER="1">					
					<thead>
						<tr>
              				<th>วันที่</th> 
							<th>รายการ</th>
							<th>จำนวน</th> 
							<th>ราคาต่อหน่วย</th> 
							<th>ราคารวม</th>
						</tr>
					</thead>
				<?php 
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
					if($count_row_catalogid>0){ ?>
						<tr class="nk-tb-item">
							<td align="left"><?php echo $_REQUEST["startdate"];?> </td> 
							<td align="left" colspan="4"><?php echo getCatalogName($row_catalog['md_catalog_id']);?> </td> 
							</tr>
						<?php	
						
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
							?>
								<tr class="nk-tb-item">
									<td align="left" width="80"></td> 
									<td><?php echo getProductName($row_distinct["md_billing_detail_productid"])?></td>
									<td><?php echo $total_amout;?></td>
									<td><?php echo $md_billing_detail_price?></td>
									<td><?php echo $md_billing_detail_total;?></td>
								</tr>
				<?php  
							}//while($row1=$query1->fetch_array()){ 
					}//while($row_product=$query_product->fetch_array()){?>
						<tr class="nk-tb-item">
								<td></td>
								<td>รวม</td>
								<td><?php echo number_format($total_cat_amout,2)?></td> 
								<td></td>
								<td><?php echo number_format($total_cat_total,2)?></td> 
							</tr>
				<?php	}//if($count_row_catalogid>0){ 
					$totalamout=$totalamout+$total_cat_amout;
					$total=$total+$total_cat_total;
				}// while($row_catalog=$query_catalog->fetch_array()){
			   
                ?>
				<tr class="nk-tb-item">
					<td>&nbsp;</td>
					<td></td>
					<td></td> 
					<td></td>
					<td></td> 
				</tr>
                <tr class="nk-tb-item">
					<td></td>
					<td>รวมทั้งหมด</td>
					<td><?php echo number_format($totalamout,2)?></td> 
					<td></td>
					<td><?php echo number_format($total,2)?></td> 
				</tr>           
	</TABLE>
	<!--จบบิลซื้อ-->
	</td>
	
	<td valign="top">
		<!--บิลขาย-->
			<TABLE  x:str BORDER="1">					
					<thead>
						<tr>
              				<th>วันที่</th> 
							<th>รายการ</th>
							<th>จำนวน</th> 
							<th>ราคาต่อหน่วย</th> 
							<th>ราคารวม</th>
						</tr>
					</thead>
				<?php 
				$sql_catalog = "SELECT * FROM md_catalog WHERE md_catalog_status='1' ORDER BY md_catalog_name ASC";  
				$query_catalog=$mysqli->query($sql_catalog) or die("Error sql_catalog: เกิดความผิดพลาด <br>$sql_catalog\n");   
				 while($row_catalog=$query_catalog->fetch_array()){ 
					$sell_total_cat_amout=0;
					$sell_total_cat_total=0;
					$sql_catalogid = "SELECT md_product_catalogid FROM md_billing_detail_sell LEFT JOIN md_billing ON md_billing_id=md_billing_detail_billingid LEFT JOIN md_product ON md_product_id=md_billing_detail_productid WHERE md_billing_status='1'";  
					$sql_catalogid .= " AND md_product_catalogid='".$row_catalog['md_catalog_id']."'";
					$sql_catalogid .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59' LIMIT 1";
					//echo $sql;
					$query_catalogid=$mysqli->query($sql_catalogid) or die("Error sql1: เกิดความผิดพลาด <br>$sql_catalogid\n"); 
					$count_row_catalogid=$query_catalogid->num_rows; 
					if($count_row_catalogid>0){ ?>
						<tr class="nk-tb-item">
							<td align="left"><?php echo $_REQUEST["startdate"];?> </td> 
							<td align="left" colspan="4"><?php echo getCatalogName($row_catalog['md_catalog_id']);?> </td> 
							</tr>
						<?php	
						
						$sql_product = "SELECT * FROM md_product WHERE md_product_status='1' AND md_product_catalogid='".$row_catalog['md_catalog_id']."' ORDER BY md_product_name ASC";  
						$query_product=$mysqli->query($sql_product) or die("Error sql_product: เกิดความผิดพลาด <br>$sql_product\n");   
						while($row_product=$query_product->fetch_array()){
							$sell_total_amout=0;
							$sell_md_billing_detail_total=0;
							//md_billing_detail_basket,md_billing_detail_productid,md_billing_detail_price,md_billing_detail_amount,md_billing_detail_total
							$sql_distinct = "SELECT DISTINCT(md_billing_detail_productid) FROM md_billing_sell,md_billing_detail_sell WHERE md_billing_id=md_billing_detail_billingid AND md_billing_status='1' AND md_billing_detail_productid='".$row_product['md_product_id']."'";  
							$sql_distinct .= " AND md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
							//echo $sql;
							$query_distinct=$mysqli->query($sql_distinct) or die("Error sql_distinct: เกิดความผิดพลาด <br>$sql_distinct\n"); 
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
									$sell_total_amout=$total_amout+$md_billing_detail_amount;
									$sell_md_billing_detail_total=$md_billing_detail_total+$row_bill["md_billing_detail_total"];
									
								}//while($row_bill=$query_bill->fetch_array()){  
									$sell_total_cat_amout=$total_cat_amout+$total_amout;
									$sell_total_cat_total=$total_cat_total+$md_billing_detail_total;
							?>
								<tr class="nk-tb-item">
									<td align="left" width="80"></td> 
									<td><?php echo getProductName($row_distinct["md_billing_detail_productid"])?></td>
									<td><?php echo $sell_total_amout;?></td>
									<td><?php echo $md_billing_detail_price?></td>
									<td><?php echo $sell_md_billing_detail_total;?></td>
								</tr>
				<?php  
							}//while($row1=$query1->fetch_array()){ 
					}//while($row_product=$query_product->fetch_array()){?>
						<tr class="nk-tb-item">
								<td></td>
								<td>รวม</td>
								<td><?php echo number_format($sell_total_cat_amout,2)?></td> 
								<td></td>
								<td><?php echo number_format($sell_total_cat_total,2)?></td> 
							</tr>
				<?php	}//if($count_row_catalogid>0){ 
					$sell_totalamout=$sell_totalamout+$sell_total_cat_amout;
					$sell_total=$sell_total+$sell_total_cat_total;
				}// while($row_catalog=$query_catalog->fetch_array()){
			   
                ?>
				<tr class="nk-tb-item">
					<td>&nbsp;</td>
					<td></td>
					<td></td> 
					<td></td>
					<td></td> 
				</tr>
                <tr class="nk-tb-item">
					<td></td>
					<td>รวมทั้งหมด</td>
					<td><?php echo number_format($sell_totalamout,2)?></td> 
					<td></td>
					<td><?php echo number_format($sell_total,2)?></td> 
				</tr>           
	</TABLE></td>	
	<td valign="top">&nbsp;</td>		
</tr>
</table> 
