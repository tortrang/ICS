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
           
   
	$sql = "SELECT * FROM md_billing WHERE 1=1";
	 
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
              				<th>รหัสใบเสร็จ&nbsp;</th> 
							<th>ชื่อลูกค้า</th>
							<th>จำนวนเงิน</th> 
							<th>การชำระเงิน</th> 
							<!--<th>vat</th>
							<th>ส่วนลด</th>-->
                            <th>วันที่</th>
							<th>สถานะ</th>
							<th>หมายเหตุ</th>
                            <th>เจ้าหน้าที่</th> 
						</tr>
					</thead>
					<?php 
				$discount=0;
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
						 $total2=$total2+$row['md_billing_carcost'];
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

						$discount+=$row['md_billing_discount'];
				 ?>
				 	<tr class="nk-tb-item">
                        <td align="left" width="80"><?php echo $row["md_billing_number"];?> </td> 
                        <td><?php echo $row_customer['md_customer_name']." (".$carcode.")";?></td>
                        <td><?php echo number_format($total2,2);?></td>
						<td><?php echo $paytyp_status;?></td>
						<!--<td><?php echo $paytvat_status;?></td>
						<td><?php echo $row['md_billing_discount'];?></td>-->
                        <td><?php echo ShowDateTimeThai($row["md_billing_credate"]);?></td>
						<td><?php echo $txt_mod["billing:status"][$row["md_billing_status"]];?></td>
						<td><?php echo $row["md_billing_cancel_detail"] ;?></td>
                        <td><?php echo getStaffName($row["md_billing_crebyid"]);?></td> 
                        </tr>
                <?php  
				$total=$total+$total2; 
				}// while($Row=$query->fetch_array()){ 
			   }//if($count_row>0){ 
                  ?>
                  	<tr class="nk-tb-item">
                        <td colspan="2"></td>
                        <td><?php echo number_format($total,2)?></td>
                        <td> </td> 
						<td> </td> 
						<td><?php echo number_format($discount,2)?></td> 
						<td> </td> 
						<td> </td> 
						<td> </td> 
					</tr>


           
</TABLE>
 
