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
 
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="excel_report.xls"');# ชื่อไฟล์


?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
</HEAD>

<BODY>
<?php   
  
  	$sql = "SELECT * FROM md_customer WHERE md_customer_delete='0' ORDER BY md_customer_code ASC";
	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
?>

<TABLE  x:str BORDER="1">					
					<thead>
						<tr>
							<th class="nk-tb-col "><span class="sub-text">รหัสลูกค้า</span></th>
							<th class="nk-tb-col"><span class="sub-text">ชื่อลูกค้า</span></th> 
							<th class="nk-tb-col "><span class="sub-text">เบอร์ติดต่อ</span></th> 
							<th class="nk-tb-col "><span class="sub-text">ชื่อธนาคาร</span></th> 
							<th class="nk-tb-col "><span class="sub-text">ชื่อบัญชี</span></th> 
							<th class="nk-tb-col "><span class="sub-text">เลขบัญชี</span></th> 
							<th class="nk-tb-col "><span class="sub-text">ประเภทราคา</span></th> 
							<th class="nk-tb-col "><span class="sub-text">ที่อยู่</span></th> 
						</tr>
					</thead>
					<?php 

            	$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล   
					$row_id=		$row["md_customer_id"];
					$row_name=		rechangeQuot($row["md_customer_name"]);
					$row_tel=	$row["md_customer_tel"];
					$row_status=	$row["md_customer_status"];
					$row_code=	$row["md_customer_code"];
					
					$txt_mod["billing:color"] = array('','success','danger');
					$txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก');
					 

					$sql_bank_maste = "SELECT * FROM md_bankname WHERE md_bankname_id='".$row['md_customer_bankid']."'";
					$query_bank_maste=$mysqli->query($sql_bank_maste);
					$Row_bank_name=$query_bank_maste->fetch_array();
					$price_type="";
					if($row['md_customer_price_type']==0){
						$price_type = "ราคาซื้อทั่วไป"; 
					}else if($row['md_customer_price_type']==1){
						$price_type = "ราคา 1"; 
					}else if($row['md_customer_price_type']==2){
						$price_type = "ราคา 2"; 
					}else if($row['md_customer_price_type']==3){
						$price_type = "ราคา 3"; 
					}else if($row['md_customer_price_type']==4){
						$price_type = "ราคา 4"; 
					}else if($row['md_customer_price_type']==5){
						$price_type = "ราคา 5"; 
					}else if($row['md_customer_price_type']==6){
						$price_type = "ราคา 6"; 
					}else if($row['md_customer_price_type']==7){
						$price_type = "ราคา 7"; 
					}else if($row['md_customer_price_type']==8){
						$price_type = "ราคา 8"; 
					}else if($row['md_customer_price_type']==9){
						$price_type = "ราคา 9"; 
					}else if($row['md_customer_price_type']==10){
						$price_type = "ราคา 10"; 
					} 
					?>    
					<tr class="nk-tb-item">
						<td class="nk-tb-col">
							<?php echo  $row_code;?> 
						</td>
						<td class="nk-tb-col">
							<span><?php echo $row_name; ?></span>
						</td>  
						<td class="nk-tb-col ">
							<span><?php echo  $row_tel;?></span>
						</td>

						<td class="nk-tb-col">
							<?php echo  $Row_bank_name["md_bankname_name"];?> 
						</td>
						<td class="nk-tb-col">
							<?php echo  $row["md_customer_bankcnumber"];?> 
						</td>
						<td class="nk-tb-col">
							<?php echo  $row["md_customer_bankcname"];?> 
						</td>
						<td class="nk-tb-col">
							<?php echo  $price_type;?> 
						</td>
						<td class="nk-tb-col">
							<?php echo  $row["md_customer_address"];?> 
						</td>
					</tr><!-- .nk-tb-item  -->
                <?php  
				// $total=$total+$row["md_billing_detail_total"];
					$amount_buy=$amount_buy+$row['sumamount'];
					$pricr_total_buy=$pricr_total_buy+$row['sum_pricetotal'];

					$amount_sell=$amount_sell+$row_sell['sumamount'];
					$pricr_total_sell=$pricr_total_sell+$row_sell['sum_pricetotal'];

					$profit_sum = $profit_sum+$profit;
				}// while($Row=$query->fetch_array()){ 
			}//if($count_row>0){ 
					?>
					 


           
</TABLE>
 
