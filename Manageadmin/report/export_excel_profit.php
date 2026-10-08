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
  
	$sql = "SELECT *,sum(md_billing_detail.md_billing_detail_amount*md_billing_detail.md_billing_detail_basket)  as sumamount, sum(md_billing_detail.md_billing_detail_total)  as sum_pricetotal FROM md_billing_detail LEFT JOIN md_product ON md_product_id=md_billing_detail_productid WHERE md_billing_detail_status='1'";

	if($_REQUEST["catalog"]!="") {
		$sql .= " AND (md_product.md_product_catalogid = '".$_REQUEST["catalog"]."')"; 
	} 

	if($_REQUEST["startdate"]!="" && $_REQUEST["enddate"]!=""){
		$sql .= " AND md_billing_detail.md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
	}  
	$sql .= "  GROUP BY md_billing_detail.md_billing_detail_productid ORDER BY md_product.md_product_code";
	
	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
?>

<TABLE  x:str BORDER="1">					
					<thead>
						<tr>
							<th class="nk-tb-col tb-col-lg"><span class="sub-text">รหัสสินค้า</span></th>
							<th class="nk-tb-col"><span class="sub-text">ชื่อสินค้า</span></th> 
							<th class="nk-tb-col tb-col-lg"><span class="sub-text">จำนวนซื้อเข้า (กก.)</span></th>
							<th class="nk-tb-col tb-col-lg"><span class="sub-text">ซื้อเข้า (บาท)</span></th>
							<th class="nk-tb-col tb-col-lg"><span class="sub-text">จำนวนขายออก (กก.)</span></th>
							<th class="nk-tb-col tb-col-lg"><span class="sub-text">ขายออก (บาท)</span></th>
							<th class="nk-tb-col tb-col-lg"><span class="sub-text">กำไร - ขาดทุน (บาท)</span></th>
						</tr>
					</thead>
					<?php 

            	$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล         

					$row_id=		$row["md_billing_detail_id"];
					$row_status=	$row["md_billing_detail_status"];
					
					$txt_mod["billing:color"] = array('','success','danger');
					$txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก');
					

					// SQL SELECT ######################### 
					$sql_sell = "SELECT *,sum(md_billing_detail_sell.md_billing_detail_amount*md_billing_detail_sell.md_billing_detail_basket)  as sumamount, sum(md_billing_detail_sell.md_billing_detail_total)  as sum_pricetotal FROM md_billing_detail_sell LEFT JOIN md_product ON md_billing_detail_productid=md_product_id   WHERE md_billing_detail_status='1' AND md_product_id='".$row["md_billing_detail_productid"]."'";
					
					if($_REQUEST["input_catalog"]!="") {
						$sql_sell .= " AND (md_product.md_product_catalogid = '".$_REQUEST["input_catalog"]."')"; 
					}  
					
					if($_REQUEST["startdate"]!="" && $_REQUEST["enddate"]!=""){
						$sql_sell .= " AND md_billing_detail_sell.md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
					}
					$sql_sell .= "  GROUP BY md_billing_detail_sell.md_billing_detail_productid ";
					$query_sell=$mysqli->query($sql_sell) or die("Error sql_sell: เกิดความผิดพลาด <br>$sql_sell\n");
					$row_sell=$query_sell->fetch_array();

					$profit = $row_sell['sum_pricetotal']-$row['sum_pricetotal'];
					if($profit>0){ 
						$color_profit ="success";
					}else{
						$color_profit ="danger";
					}
					?>    
					<tr class="nk-tb-item">
						<td class="nk-tb-col">
							<div class="nk-tnx-type">
								<div class="nk-tnx-type-text">
									<span class="tb-lead"><?php echo  getProductCode($row["md_billing_detail_productid"]);?></span>
								</div>
						</div>
						</td>
						<td class="nk-tb-col">
							<span><?php echo getProductName($row["md_billing_detail_productid"]);?></span>
						</td> 
						<td class="nk-tb-col tb-col-md">
							<span><?php echo  number_format($row['sumamount'],3);?></span>
						</td>
						<td class="nk-tb-col tb-col-md">
							<span><?php echo  number_format($row['sum_pricetotal'],2);?></span>
						</td>
						<td class="nk-tb-col tb-col-md">
							<span><?php echo  number_format($row_sell['sumamount'],3);?></span>
						</td>
						<td class="nk-tb-col tb-col-md">
							<span><?php echo  number_format($row_sell['sum_pricetotal'],2);?></span>
						</td>

						<td class="nk-tb-col tb-col-md">
							<span class="text-<?php echo $color_profit ?>"><?php echo  number_format($profit,2);?></span>
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
					<tr class="nk-tb-item">
                        <td colspan="2"></td>
                        <td><?php echo number_format($amount_buy,2)?></td>  
						<td><?php echo number_format($pricr_total_buy,2)?></td>
						<td><?php echo number_format($amount_sell,2)?></td>  
						<td><?php echo number_format($pricr_total_sell,2)?></td>
						<td><?php echo number_format($profit_sum,2)?></td>
                        </tr>


           
</TABLE>
 
