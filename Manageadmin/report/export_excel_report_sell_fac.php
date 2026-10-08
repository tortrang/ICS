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
           
  
   
	$sql = "SELECT * FROM md_billing_sell_factory WHERE 1=1";
	 
	if($_REQUEST["startdate"]!="" && $_REQUEST["enddate"]!=""){
		$sql .= " AND md_billing_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
	}

	if($_REQUEST['report_b']==0 ){
		$sql .= " AND md_billing_status='1'";
		if($_REQUEST['report_b_type']==3){
			$sql .= " AND md_billing_type='0'";
		}else if($_REQUEST['report_b_type']==4){
			$sql .= " AND md_billing_type='1'";
		}else if($_REQUEST['report_b_type']==5){
			$sql .= " AND (md_billing_type='0' OR md_billing_type='1')";
		}
	}else if($_REQUEST['report_b']==1 ){
		$sql .= " AND md_billing_status='2'";
		if($_REQUEST['report_b_type']==3){
			$sql .= " AND md_billing_type='0'";
		}else if($_REQUEST['report_b_type']==4){
			$sql .= " AND md_billing_type='1'";
		}else if($_REQUEST['report_b_type']==5){
			$sql .= " AND (md_billing_type='0' OR md_billing_type='1')";
		}
	}else if($_REQUEST['report_b']==2 ){
		$sql .= " AND (md_billing_status='1' OR md_billing_status='2')";
		if($_REQUEST['report_b_type']==3){
			$sql .= " AND md_billing_type='0'";
		}else if($_REQUEST['report_b_type']==4){
			$sql .= " AND md_billing_type='1'";
		}else if($_REQUEST['report_b_type']==5){
			$sql .= " AND (md_billing_type='0' OR md_billing_type='1')";
		}
	}

	
	if($_REQUEST['report_vat_type']==6){
		$sql .= " AND md_billing_vattype='0'";
	}else if($_REQUEST['report_vat_type']==7){
		$sql .= " AND md_billing_vattype='1'";
	}else if($_REQUEST['report_vat_type']==8){
		$sql .= " AND md_billing_vattype='2'";
	}else if($_REQUEST['report_vat_type']==9){
		$sql .= " AND (md_billing_vattype='0' OR md_billing_vattype='1' OR md_billing_vattype='2')";
	}

	$sql .= " order by md_billing_id ASC";
	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
?>

<TABLE  x:str BORDER="1">					
					<thead>
						<tr>
						<th>รหัสใบเสร็จ</th>
						<th >วันที่</th> 
						<th >สินค้า</th>
						<th >วันที่ออกสินค้า</th>
						<th >ทะเบียน</th>
						<th >สถานที่ลง</th>

						<th >น้ำหนักออก</th>
						<th >ราคาซื้อเฉลี่ย</th>
						<th >ยอดซื้อ</th>
						
						
						<th >น้ำหนักรับ</th>
						<th >ราคาขาย</th>
						<th >ยอดขาย</th>
						<th >หัก</th>
						<th >หาย</th>

						

						<th >กำไร/ขาดทุน</th> 

						<th >ค่าบรรทุก</th>
						<th >กำไร/ขาดทุน สุทธิ</th> 
						<th >ชื่อลูกค้า</th> 
						
						<th >vat</th>
						<th >ราคา vat</th>
						<th >ราคารวม vat</th>
						<th >การชำระเงิน</th>
						<th >วันที่โอน</th>
						<th >บัญชี</th>
						<th >เลขบัญชี</th> 

						<th >สถานะ</th>
						<th >หมายเหตุ</th> 
						<th >เจ้าหน้าที่</th> 
				</tr>
					</thead>
					<?php 

            	$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล     
						$sql_customer = "SELECT * FROM md_customer WHERE md_customer_id='".$row["md_billing_customerid"]."'";
                        $query_customer=$mysqli->query($sql_customer) or die("Error sql_customer: เกิดความผิดพลาด <br>$sql_customer\n"); 
                        $row_customer=$query_customer->fetch_array();

						$vatetype = $row['md_billing_vattype'];
                        if($vatetype==1){  //ใน
                            $total2=$row['md_billing_total'];
                        }elseif($vatetype==2){ //นอก
                            $total2=$row['md_billing_totalprice'];
                        }else{ //ไม่คิด
                            $total2=$row['md_billing_total'];
                        }

                        if($row['md_billing_carcode']!='' && $row["md_billing_customerid"]==1){
                            $carcode=$row['md_billing_carcode'];
                        }else{
                            $carcode=$row_customer['md_customer_code'];
                        }     
						
						$paytype = $row['md_billing_type'];
                        if($paytype==0){   
                            $paytyp_status="เงินสด";
                            $paytyp_color="primary";
                        }elseif($paytype==1){  
                            $paytyp_status="เงินโอน";
                            $paytyp_color="info";
                        } 

						$vat = $row['md_billing_vattype'];
                        if($vat==0){   
                            $paytvat_status="ไม่มี vat";
                            $paytvat_color="primary";
                        }elseif($vat==1){  
                            $paytvat_status="vat ใน";
                            $paytvat_color="info";
                        }elseif($vat==2){  
                            $paytvat_status="vat นอก";
                            $paytvat_color="warning";
                        } 

						$date = "";
                        if($row["md_billing_date"]!='0000-00-00 00:00:00'){
                            $date = ShowDateTimeThai2($row["md_billing_date"]);
                        }
				 ?>
				 	<tr class="nk-tb-item">
                        <td align="left" width="80"><?php echo $row["md_billing_number"];?> </td> 
						<td><?php echo ShowDateTimeThai($row["md_billing_credate"]);?></td>

						<?php
							$sql_detail_fac = "SELECT * FROM md_billing_detail_sell_factory WHERE md_billing_detail_billingid='".$row["md_billing_id"]."' AND md_billing_detail_status='1'";
							$query_detail_fac=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_2=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_3=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_4=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_5=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_6=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_7=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_8=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_9=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_10=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
							$query_detail_fac_11=$mysqli->query($sql_detail_fac) or die("Error sql_detail_fac: เกิดความผิดพลาด <br>$sql_detail_fac\n");  
						?>
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac=$query_detail_fac->fetch_array()){ ?>
									<tr>
										<td><?php echo getProductName($row_detail_fac['md_billing_detail_productid']) ?></td> 
									</tr> 
								<?php } ?>
							</table>
						</td>
						<td><?php echo $date;?></td> 
                        <td><?php echo $row['md_billing_carcode'];?></td> 
						<td><?php echo $row['md_billing_car_drop'] ?></td>

						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_2=$query_detail_fac_2->fetch_array()){ ?>
									<tr>
										<td><?php echo $row_detail_fac_2['md_billing_detail_amount'] ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td> 
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_3=$query_detail_fac_3->fetch_array()){ ?>
									<tr>
										<td><?php echo $row_detail_fac_3['md_billing_detail_price'] ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_4=$query_detail_fac_4->fetch_array()){ ?>
									<tr>
										<td><?php echo $row_detail_fac_4['md_billing_detail_total'] ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>
						

						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_5=$query_detail_fac_5->fetch_array()){ ?>
									<tr>
										<td><?php echo $row_detail_fac_5['md_billing_detail_amount_fac'] ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_6=$query_detail_fac_6->fetch_array()){ ?>
									<tr>
										<td><?php echo $row_detail_fac_6['md_billing_detail_price_fac'] ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_7=$query_detail_fac_7->fetch_array()){ ?>
									<tr>
										<td><?php echo $row_detail_fac_7['md_billing_detail_total_fac'] ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_9=$query_detail_fac_9->fetch_array()){  ?>
									<tr>
										<td><?php echo $row_detail_fac_9['md_billing_detail_amount_deff_fac']  ?></td> 
									</tr> 
								<?php } ?>
							</table>  
						</td>
						<td>
							<table border="1"  >
								<?php
								while($row_detail_fac_10=$query_detail_fac_10->fetch_array()){  
									$amountelse = ($row_detail_fac_10["md_billing_detail_amount_fac"]+$row_detail_fac_10["md_billing_detail_amount_deff_fac"])-$row_detail_fac_10["md_billing_detail_amount"];
								?>
									<tr>
										<td><?php echo $amountelse ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>
					
						<td> 
							<table border="1"  >
								<?php
								while($row_detail_fac_8=$query_detail_fac_8->fetch_array()){ 
									$price_profit = $row_detail_fac_8["md_billing_detail_total_fac"]-$row_detail_fac_8["md_billing_detail_total"];
									$total__fac_profit += $price_profit;
								?>
									<tr>
										<td><?php echo $price_profit ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td>

						<td><?php echo $row['md_billing_car_cost'] ?></td> 
						<td>
							<table border="1"  >
								<?php
								while($row_detail_fac_11=$query_detail_fac_11->fetch_array()){ 
									$price_profit = $row_detail_fac_11["md_billing_detail_total_fac"]-$row_detail_fac_11["md_billing_detail_total"];
									$price_profit_sum = $price_profit-$row["md_billing_car_cost"];
									 
								?>
									<tr>
										<td><?php echo round($price_profit_sum,2) ?></td> 
									</tr> 
								<?php } ?>
							</table> 
						</td> 

						<td><?php echo $row_customer['md_customer_name'] ?></td>
						<td><?php echo $paytvat_status;?></td>
						<td><?php echo $row['md_billing_vat'];?></td>
						<td><?php echo $total2;?></td>
						<td><?php echo $paytyp_status;?></td>

						<td><?php echo $row["md_billing_transfer_date"] ;?></td>
						<td><?php echo $row["md_billing_bankcname"] ;?></td>
						<td><?php echo $row["md_billing_bankcnumber"] ;?></td>
						<td><?php echo $txt_mod["billing:status"][$row["md_billing_status"]];?></td>
						<td><?php echo $row["md_billing_cancel_detail"]." ".$row["md_billing_reson"] ;?></td>
						<td><?php echo getStaffName($row["md_billing_crebyid"]);?></td> 
 
					</tr>
                <?php  
				$total=$total+$total2; 
				}// while($Row=$query->fetch_array()){ 
			   }//if($count_row>0){ 
                  ?>
                   


           
</TABLE>
 
