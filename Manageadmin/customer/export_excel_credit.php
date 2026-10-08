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
$txt_mod["financial:color"] = array('','warning','success','danger');
$txt_mod["financial:walletgroup"] = array('DF'=>'ฝากเงิน','WF'=>'ถอนเงิน','BL'=>'ออกบิล','CC'=>'ยกเลิกบิล');
$txt_mod["financial:walletgroupcolor"] = array('DF'=>'success','WF'=>'danger','BL'=>'warning','CC'=>'primary');
$txt_mod["financial:walletgroupicon"] = array('DF'=>'ni-arrow-down-right','WF'=>'ni-arrow-up-right','BL'=>'ni-arrow-up-right','CC'=>'ni-arrow-down-right');

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
  
	$sql = "SELECT * FROM md_wallet_credit WHERE 1=1";
	if($_REQUEST["InputSearch"]!=0){
		$sql .= " AND (md_wallet_customerid ='".$_REQUEST["InputSearch"]."')";
	}
	$sql .= " ORDER BY md_wallet_id DESC";
  	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
?>

<TABLE  x:str BORDER="1">	
	<br>
				<?php  
					if($_REQUEST["InputSearch"]!=0){
						$row_bl=$query->fetch_array();
						$PrevWallet_bk=$row_bl["md_wallet_balance"];
					}else{
						$sql_bk = "SELECT md_wallet_balance FROM md_wallet_credit WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
						$Query_bk=$mysqli->query($sql_bk);
						$Row_bk=$Query_bk->fetch_array();
						$PrevWallet_bk=$Row_bk["md_wallet_balance"];
					}
				?>
				
				<span class="sub-text">ยอดหนี้คงค้าง</span> <?php echo number_format($PrevWallet_bk,2);?>  บาท<br><br>	
					<thead>
						<tr>
							<th class="nk-tb-col "><span class="sub-text">รหัสทำรายการ</span></th>
							<th class="nk-tb-col "><span class="sub-text">ประเภท</span></th>
							<th class="nk-tb-col"><span class="sub-text">ชื่อลูกค้า</span></th> 
							<th class="nk-tb-col "><span class="sub-text">จำนวนเงิน</span></th> 
							<th class="nk-tb-col "><span class="sub-text">ยอดหนี้คงเหลือ</span></th> 
							<th class="nk-tb-col "><span class="sub-text">รายละเอียด</span></th> 
							<th class="nk-tb-col "><span class="sub-text">วันที่ทำรายการ</span></th> 
							<th class="nk-tb-col "><span class="sub-text">เจ้าหน้าที่</span></th>  
						</tr>
					</thead>
					<?php 

            	$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล   
					 
					$row_id=		$row["md_wallet_id"];
					$row_status=	$row["md_wallet_status"];
                    $row_customerid=	$row["md_wallet_customerid"];
				 	$coloractive=$txt_mod["financial:walletgroupcolor"][$row["md_wallet_group"]];
					if($row["md_wallet_deposit"]!=0){
						$amount=$row["md_wallet_deposit"];
					}else{
						$amount=$row["md_wallet_withdrawal"];
					}

                    $sql_customer = "SELECT * FROM md_customer WHERE md_customer_id='".$row_customerid."'";
                    $query_customer=$mysqli->query($sql_customer) or die("Error sql_customer: เกิดความผิดพลาด <br>$sql_customer\n"); 
                    $row_customer=$query_customer->fetch_array();

                    $sql_billing_sell = "SELECT * FROM md_billing_sell WHERE md_billing_number='".$row["md_wallet_billingnumber"]."'";
                    $query_billing_sell=$mysqli->query($sql_billing_sell) or die("Error sql_billing_sell: เกิดความผิดพลาด <br>$sql_billing_sell\n"); 
                    $row_billing_sell=$query_billing_sell->fetch_array();

                    if($row_billing_sell['md_billing_carcode']!='' && $row_billing_sell["md_billing_customerid"]==1){
                        $carcode=$row_billing_sell['md_billing_carcode'];
                    }else{
                        $carcode=$row_customer['md_customer_code'];
                    }
					?>    
					<tr class="nk-tb-item">
						<td class="nk-tb-col">
							<span><?php echo $row["md_wallet_code"]; ?></span>
						</td> 
						<td class="nk-tb-col">
							<?php echo $txt_mod["financial:walletgroup"][$row["md_wallet_group"]]?>
						</td>
						<td class="nk-tb-col">
							<?php echo $row_customer['md_customer_name']." (".$carcode.")" ?></span>
						</td>  
						<td class="nk-tb-col ">
							<?php echo number_format($amount,2)?><span class="dot dot-<?php echo $coloractive;?> d-md-none ml-1"></span>
						</td>

						<td class="nk-tb-col">
							<?php echo number_format($row["md_wallet_balance"],2)?><span class="dot dot-<?php echo $coloractive;?> d-md-none ml-1"></span>
						</td>
						<td class="nk-tb-col">
							<span><?php echo $row["md_wallet_detail"];?></span>
							<span><?php if($row['md_wallet_group']=='WF' && $row['md_wallet_reason']!=''){ echo "หมายเหตุ: ".$row["md_wallet_reason"]; } ?></span>
						</td>
						<td class="nk-tb-col">
							<span><?php echo $row["md_wallet_credate"];?></span>
						</td>
						<td class="nk-tb-col">
							<span><?php echo getStaffName($row["md_wallet_crebyid"]);?></span>
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
 
