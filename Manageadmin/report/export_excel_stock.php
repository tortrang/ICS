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
  
	$sql = "SELECT * FROM md_product WHERE md_product_delete='0' ";
	// if($_REQUEST["InputSearch"]!=""){
	// 	$sql .= " AND ((md_product_name LIKE '%".$_REQUEST["InputSearch"]."%') OR (md_product_code LIKE '%".$_REQUEST["InputSearch"]."%'))";
	// }
	if($_REQUEST["catalog"]!=""){
		$sql .= " AND md_product_catalogid='".$_REQUEST["catalog"]."'";
	}
	if($_REQUEST["catalog"]==14){
        $type_cc = "ลัง";
    }else{
        $type_cc = "กก.";
    }

	$sql .= " ORDER BY  md_product_code ASC";
	// echo $sql;
	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");  
	$count_record=$query->num_rows;   
?>

<TABLE  x:str BORDER="1">					
 
		<thead>
			<tr class="nk-tb-item nk-tb-head">
				<th class="nk-tb-col tb-col-lg"><span class="sub-text">รหัสสินค้า</span></th>
				<th class="nk-tb-col"><span class="sub-text">ชื่อสินค้า</span></th>
				<th class="nk-tb-col tb-col-lg"><span class="sub-text">ราคา (เฉลี่ย)</span></th>
				<th class="nk-tb-col tb-col-lg"><span class="sub-text">จำนวน (<?php echo  $type_cc ?>)</span></th>
				<th class="nk-tb-col tb-col-lg"><span class="sub-text">จำนวนเงิน</span></th>
					
			</tr>
		</thead>
		<tbody>
			<?php
			

			$index=1;
			$color=0;
			if($count_record>0) {
			while($index<$count_record+1) {
				$row=$query->fetch_array();
				$row_id=		$row["md_billing_detail_id"];
				$row_status=	$row["md_billing_detail_status"];
				
				$txt_mod["billing:color"] = array('','success','danger');
				$txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก'); 


				$amount_total = getBalanceWalletStock($row["md_product_id"]);

				$sql_price = "SELECT * FROM md_billing_detail WHERE md_billing_detail_status='1' AND md_billing_detail_productid = '".$row["md_product_id"]."' "; 
				$query_price=$mysqli->query($sql_price) or die("Error sql_price: เกิดความผิดพลาด <br>$sql_price\n");
				$avg_sum =0;
				$avg_count =0;
				while($row_price=$query_price->fetch_array()) {
					// echo "<br>id: ".$row_price["md_billing_detail_productid"]." p:".$row_price["md_billing_detail_price"];
					$avg_sum += $row_price["md_billing_detail_price"];
					$avg_count++;
				}
				if($avg_count){
					$avg_price =  $avg_sum/$avg_count;
				}else {
					$avg_price =  0;
				} 

				$price_total=  round($amount_total,3)*round($avg_price,3);
				$total_sum+=$price_total;
				?>    
				<tr class="nk-tb-item">
					<td class="nk-tb-col">
						<div class="nk-tnx-type">
							<div class="nk-tnx-type-text">
								<span class="tb-lead"><?php echo  getProductCode($row["md_product_id"]);?></span>
							</div>
					</div>
					</td>
					<td class="nk-tb-col">
						<span><?php echo getProductName($row["md_product_id"]);?></span>
					</td> 
					<td class="nk-tb-col tb-col-md">
						<span><?php echo  number_format($avg_price,3);?></span> 
					</td>
					<td class="nk-tb-col tb-col-md">
						<span><?php echo  number_format($amount_total,3);?></span>
					</td>
					<td class="nk-tb-col tb-col-md">
						<span><?php echo  number_format($price_total,3);?></span> 
					</td>
				</tr><!-- .nk-tb-item  -->
					<?php $index++;$color++; 
				}//while($Row=$query->fetch_array()){?>
				<?php }else{?>
			<tr>
				<td class="nk-tb-col" colspan="8" align="center"><?php echo $txt_language["txt:nodata"];?></td>
			</tr><!-- .nk-tb-item  -->

			<?php }//if($count_record>0)  ?>


		</tbody> 

           
</TABLE>
 
