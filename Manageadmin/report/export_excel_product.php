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
  
	$sql = "SELECT *,sum(md_billing_detail.md_billing_detail_amount)  as sumamount FROM md_billing_detail LEFT JOIN md_product ON md_product_id=md_billing_detail_productid WHERE md_billing_detail_status='1'";

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
              				<th>รหัสสินค้า&nbsp;</th>
                            <th>ชื่อสินค้า</th>
							<th>ราคา (เฉลี่ย)</th>
							<th>จำนวน (กก.)</th> 
						</tr>
					</thead>
					<?php 

            	$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล         
					
					if($_REQUEST["startdate"]=='' && $_REQUEST["enddate"]==''){
						$sqlpricedate = "";
					}else{
						$sqlpricedate = " AND (md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59')";
					}

					$sql_price = "SELECT * FROM md_billing_detail WHERE md_billing_detail_status='1' AND md_billing_detail_productid = '".$row["md_billing_detail_productid"]."' $sqlpricedate"; 
					// echo "<br>".$sql_price; 
					$query_price=$mysqli->query($sql_price) or die("Error sql_price: เกิดความผิดพลาด <br>$sql_price\n");
					$avg_sum =0;
					$avg_count =0;
					while($row_price=$query_price->fetch_array()) {
						// echo "<br>id: ".$row_price["md_billing_detail_productid"]." p:".$row_price["md_billing_detail_price"];
						$avg_sum += $row_price["md_billing_detail_price"];
						$avg_count++;
					}
					$avg_price =  $avg_sum/$avg_count;
				 ?>
				 	<tr class="nk-tb-item">
                        <td align="left" width="80"><?php echo getProductCode($row["md_billing_detail_productid"]);?> </td>
                        <td><?php echo getProductName($row["md_billing_detail_productid"]);?></td>
                        <td><?php echo number_format($avg_price,3);?></td>
                        <td><?php echo number_format($row['sumamount'],3);?></td>
                         
                        </tr>
                <?php  
				// $total=$total+$row["md_billing_detail_total"];
				$amount=$amount+$row['sumamount'];
				$amount_avg=$amount_avg+$avg_price;
				 }// while($Row=$query->fetch_array()){ 
			   }//if($count_row>0){ 
                  ?>
                  <tr class="nk-tb-item">
                        <td colspan="2"></td>
                        <td><?php echo number_format($amount_avg,2)?></td>  
						<td><?php echo number_format($amount,2)?></td>
                        </tr>


           
</TABLE>
 
