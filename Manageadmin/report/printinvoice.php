<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
     <link rel="shortcut icon" href="images/favicon.png">

	 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<title>พิมพ์ใบเสร็จ</title>
<style type="text/css">
* {
    margin:0;
    padding:0;
    font-family:Arial, "times New Roman", tahoma;
    font-size:14px;
}
html {
    font-family:Arial, "times New Roman", tahoma;
    font-size:14px;
    color:#000000;
}
body {
    font-family:Arial, "times New Roman", tahoma;
    font-size:14px;
    padding:0;
    margin:0;
    color:#000000;
	font-weight:600;
}
/* css ส่วนสำหรับการแบ่งหน้าข้อมูลสำหรับการพิมพ์ */
@media all
{
    .page-break { display:none; }
    .page-break-no{ display:none; }
}
@media print
{
    .page-break { display:block;height:1px; page-break-before:always; }
    .page-break-no{ display:block;height:1px; page-break-after:avoid; } 
}
.data1 {font-size: 14px; }
.style1 {font-size: 14px; }
.style10 {font-size: 12px; }
.style11 {font-size: 14px; }
.style12 {font-size: 14px; }
.style13 {font-size: 14px; }
h3 {font-size: 20px; }
b {font-weight:600}
</style>
<Script Language="JavaScript">
function CloseWindowsInTime(t){
t = t*1000;
setTimeout("window.close()",t);
}
CloseWindowsInTime(1); //ส่เวลาเป็นวินาทีนะครับตรงเลข 5
function myFunction() {
  window.print(); 
}
</script>

</head>
  
<body onLoad="myFunction()"> 
<?php

$number=$_GET["number"];
$type=$_GET["myRadio"];
$type2=$_GET["myRadio2"];

$sql = "SELECT * FROM md_billing WHERE md_billing_number='".$number."' AND md_billing_status='1' order by md_billing_id desc limit 1";
$Query=$mysqli->query($sql) OR DIE("Error sql: <br>$sql<br>\n");
$Row=$Query->fetch_array();	 							 	 
   
?>


<style>
	@font-face {
		font-family: angsa;
		src: url(angsa.ttf);
	}

	body {
		font-size: 11px !important;
		font-weight: 500;
	}

	table {
		font-size: 11px;
	}

	.table {
		border-collapse: collapse;
	}

	.table td,
	th {
		border: 1px solid black;
	}

	.table td {
		padding: 3px;
	}

	.table1 td,
	th {
		border: 0px;
	}

	.b-number {
		background-color: #000 !important;
		text-align: center;
		font-size: 50px;
		color: #FFF;
		font-weight: 900;
		line-height: normal;
	}

	@media print {
		@page {
			/*size: landscape;*/
			margin-left: 5px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 10px;
			/*width: 100.6mm;
				max-height:50mm; */
		}

		.b-number {
			background-color: #000 !important;
			text-align: center;
			font-size: 50px;
			color: #FFF;
			font-weight: 900;
			-webkit-print-color-adjust: exact;
		}
	}
</style>
</body> 
 
<table width="100%" id="teble_h1" border="0" cellspacing="0" cellpadding="0" class="table" style="margin-top:20px;">

<?php if($type==0 && $type2==3){ ?>
	<tr id="head33" >
		<td style="border:0px;justify-content: center;" colspan="1" width="10%"><img style="max-width:80%;max-height:70px;margin-left: 20px;" src="../../images/logo_invoice.png"> </td>
		<td style="border:0px;justify-content: center;" colspan="1" width="45%">
			<h5 style="margin-left: 30px;padding:0px; ">วงษ์พาณิชย์ สาขาท่าช้าง (หาดใหญ่)</h5><br>
			<p style="margin-left: 30px;padding:0px; font-size:11px">วงษ์พาณิชย์ สาขาท่าช้าง(หาดใหญ่)<br>ที่อยู่ : 312 ท่าช้าง อำเภอบางกล่ำ จังหวัดสงขลา, 90110 <br>โทร 090-007-9999</p>
		</td>
		<td style="border:0px;justify-content: center;margin-right: 20px;float: right;" colspan="1" width="45%">
			<u><h3 style="padding:0px;margin:0px;font-weight: bold" align="right">ใบรับสินค้า</h3></u><br>
			<h4 style="padding:0px;margin:0px;font-weight: bold" align="right">No. <?php echo $Row['md_billing_number']?></h4>
			<p style="padding:0px;margin:0px;font-size:13px" align="right">วันที่ <span style="text-decoration:underline dotted;font-weight: bold;"><?php echo DateFormat($Row['md_billing_credate']) ?></span> </p>
		</td>  
	</tr>
<?php }elseif($type==0 && $type2==4){ ?>
	<tr id="head44" >
		<td style="border:0px;justify-content: center;" colspan="1" width="10%"><img style="max-width:80%;max-height:70px;margin-left: 20px;" src="../../images/logo_invoice.png"> </td>
		<td style="border:0px;justify-content: center;" colspan="1" width="45%">
			<h5 style="margin-left: 30px;padding:0px; ">บริษัท ว.เต็มสุขรีไซเคิล จำกัด</h5><br>
			<p style="margin-left: 30px;padding:0px; font-size:11px">บริษัท ว.เต็มสุขรีไซเคิล จำกัด สาขา 00001<br>ที่อยู่ : 312 หมู่ 5 ตำบลท่าช้าง อำเภอบางกล่ำ จังหวัดสงขลา, 90110 <br><br></p>
			<p style="margin-left: 30px;padding:0px; font-size:11px">เลขที่ผู้เสียภาษี : 0905562005052<br>ศิริพร ศรประสิทธิ์ <br>โทร 080-5444-222 </p>
		</td>
		<td style="border:0px;justify-content: center;margin-right: 20px;float: right;" colspan="1" width="45%">
			<u><h3 style="padding:0px;margin:0px;font-weight: bold" align="right">ใบรับสินค้า</h3></u><br>
			<h4 style="padding:0px;margin:0px;font-weight: bold" align="right">No. <?php echo $Row['md_billing_number']?></h4>
			<p style="padding:0px;margin:0px;font-size:13px" align="right">วันที่ <span style="text-decoration:underline dotted;font-weight: bold;"><?php echo DateFormat($Row['md_billing_credate']) ?></span> </p>
		</td> 
		<!-- <td align="center"><img style="max-width:90%;max-height:50px;" src="">&nbsp;</td> -->
	</tr>
<?php }elseif($type==2 && $type2==0){ ?>
	<tr id="head55" >
		<!-- <td style="border:0px;justify-content: center;" colspan="1" width="10%"><img style="max-width:80%;max-height:70px;margin-left: 20px;" src="../../images/logo_invoice.png"> </td>
		<td style="border:0px;justify-content: center;" colspan="1" width="45%">
			<h5 style="margin-left: 30px;padding:0px; ">บริษัท ว.เต็มสุขรีไซเคิล จำกัด</h5><br>
			<p style="margin-left: 30px;padding:0px; font-size:11px">บริษัท ว.เต็มสุขรีไซเคิล จำกัด สาขา 00001<br>ที่อยู่ : 312 หมู่ 5 ตำบลท่าช้าง อำเภอบางกล่ำ จังหวัดสงขลา, 90110 <br><br></p>
			<p style="margin-left: 30px;padding:0px; font-size:11px">เลขที่ผู้เสียภาษี : 0905562005052<br>ศิริพร ศรประสิทธิ์ <br>โทร 080-5444-222 </p>
		</td> -->
		
		<td style="border:0px;justify-content: center;margin-right: 20px;float: right;" colspan="1" width="45%">
			<u><h3 style="padding:0px;margin:0px;font-weight: bold" align="right">ใบรับสินค้า</h3></u><br>
			<h4 style="padding:0px;margin:0px;font-weight: bold" align="right">No. <?php echo $Row['md_billing_number']?></h4>
			<p style="padding:0px;margin:0px;font-size:13px" align="right">วันที่ <span style="text-decoration:underline dotted;font-weight: bold;"><?php echo DateFormat($Row['md_billing_credate']) ?></span> </p>
		</td> 
		<!-- <td align="center"><img style="max-width:90%;max-height:50px;" src="">&nbsp;</td> -->
	</tr>
<?php } ?>
	 

    <?php
		$sql_custu = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1' AND md_customer_id='".$Row['md_billing_customerid']."'";
		$query_custu=$mysqli->query($sql_custu) or die("Error sql_custu: เกิดความผิดพลาด <br>$sql_custu\n");
		$Row_custu=$query_custu->fetch_array();

	  	if($Row['md_billing_carcode']!='' && $Row["md_billing_customerid"]==1){
			$carcode=$Row['md_billing_carcode'];
		}else{
			$carcode=$Row_custu['md_customer_code'];
		}
	  	
    ?>
	<tr id="head1" >
		<td colspan="3" valign="top" style="border:0px">
			<br><hr  ><br>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1" style="margin-left: 20px;">
				<tr>
					<td width="60%">รหัสลูกค้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $carcode; ?>  &nbsp;&nbsp;<?php if($Row_custu['md_customer_tel']!='' || $Row_custu['md_customer_tel']!='-'){ echo "Tel : ".$Row_custu['md_customer_tel']; } ?></td>
					<td width="40%">เลขที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Row['md_billing_number']?></td>
				</tr>
				<tr>
					<td width="60%">ชื่อลูกค้า : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Row_custu['md_customer_name']." (".$carcode.")" ?></td>
					<td width="40%">วันที่ : &nbsp;&nbsp; <?php echo DateFormat_time($Row['md_billing_credate']) ?></td>
				</tr>
				<tr>
					<td width="60%">ที่อยู่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Row_custu['md_customer_address'] ?></td>
					<td width="40%">ชื่อพนักงาน : &nbsp;&nbsp; <?php echo $_SESSION["core_session_sys_name"] ?></td>
				</tr>
			</table><br><hr> 
		</td> 
	</tr> 
	<tr>
    	<td colspan="3" valign="top" style="border:0px;text-align: center;"> 
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1" style="margin-left: 0px;">
				<tr>
					<td width="10%">ลำดับ</td> 
					<td width="10%">รหัสสินค้า</td> 
					<td width="30%">รายการสินค้า</td> 
					<!-- <td width="15%">น้ำหนัก</td>  -->
					<td width="20%">หมายเหตุ</td> 
					<td width="10%">จำนวน/หน่วยนับ</td> 
					<td width="10%">ราคา/หน่วย</td> 
					<td width="10%">จำนวนเงิน</td> 
				</tr> 
			</table> <hr> 
		</td>
	</tr>
		<td colspan="3" valign="top" style="border:0px;text-align: center;"> 
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1" style="margin-left: 0px;">
				
				<?php
					// ส่วนของ repeat content
					$sql_detail="SELECT * FROM md_billing_detail WHERE md_billing_detail_billingid='".$Row['md_billing_id']."' AND md_billing_detail_status='1' ORDER BY md_billing_detail_id ASC";
					$query_detail=$mysqli->query($sql_detail); 
					$index=1;
					$total=0;
					while($row_detail=$query_detail->fetch_array()){
						$sql_prod = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_id='".$row_detail['md_billing_detail_productid']."' ORDER BY md_product_name ASC";
						$query_prod=$mysqli->query($sql_prod) or die("Error sql_prod:  <br/>$sql_prod<br />\n");
						$Row_prod=$query_prod->fetch_array();
						$total += $row_detail['md_billing_detail_total'];
					 
						
						$reson ="";
						$inout = "";
						$a_inout = "";
						
						if($row_detail['md_billing_detail_amount_in']!=0 && $row_detail['md_billing_detail_amount_out']!=0){
							$inout = " (".$row_detail['md_billing_detail_amount_in']." - ".$row_detail['md_billing_detail_amount_out'].")";
							$a_inout = $row_detail['md_billing_detail_amount_in']-$row_detail['md_billing_detail_amount_out'];
						}
						if($row_detail['md_billing_detail_reason']!=''){
							$reson .= $row_detail['md_billing_detail_reason'];
						}
						if($row_detail['md_billing_detail_amount_deff']!=0){
							$reson .= " หัก ".number_format($row_detail['md_billing_detail_amount_deff'],2)." กก.";
						}

						if($Row_prod["md_product_catalogid"]==14){
							$type_cc = "ลัง";
						}else{
							$type_cc = "กก.";
						}
					?> 
					<tr>
						<td width="10%"><?php echo $index ?></td> 
						<td width="10%"><?php echo $Row_prod['md_product_code'] ?></td> 
						<td width="30%" style="text-align: left;"><?php echo getProductName($row_detail['md_billing_detail_productid'])?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $inout." ".$a_inout?></td> 
						
						<!-- <td width="15%"><?php echo $inout." ".$a_inout?> กก.</td>  -->
						<td width="20%" style="text-align: left;"><?php echo $reson ?> </td> 

						<td width="10%"><p style="float: right;"><?php echo number_format($row_detail['md_billing_detail_amount'],2).$type_cc ?></p></td> 
						<td width="10%"><p style="float: right;"><?php echo number_format($row_detail['md_billing_detail_price'],2) ?> </p></td> 
						<td width="10%"><p style="margin-right: 20px;float: right;"><?php echo number_format($row_detail['md_billing_detail_total'],2) ?> </p></td> 
					</tr> 
					<?php $index++;}  
				?> 
			</table> <hr> 
		</td>
	</tr>
			<td colspan="3" valign="top" style="border:0px;text-align: center;"> 
				<?php if($Row['md_billing_vattype']==2){ ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
						<?php if($Row['md_billing_discount']!=0){ ?>
							<tr >
								<td style="margin-left: 20px;float: left;"> </td> 
								<td><p style="margin-right: 20px;float: right;">ส่วนลด  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_discount'],2) ?> </p></td> 
							</tr> 
						<?php } ?>
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ราคาสินค้า  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_total'],2) ?> </p></td> 
						</tr> 
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ภาษีมูลค่าเพิ่ม 7%  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_vat'],2) ?> </p></td> 
						</tr> 
						<tr >
							<td style="margin-left: 20px;float: left;">(จำนวนเงินตัวอักษร) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<span style="text-decoration:underline dotted;font-weight: bold;"><?php echo GetTextMoney(number_format($Row['md_billing_totalprice'],2)) ?></span>)</td> 
							<td><p style="margin-right: 20px;float: right;">ยอดที่ต้องจ่ายสุทธิ  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="text-decoration:underline dotted;font-weight: bold;"><?php echo number_format($Row['md_billing_totalprice'],2) ?></span></p></td> 
						</tr> 
					</table> <hr> 
				<?php }elseif($Row['md_billing_vattype']==1){ ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
						<?php if($Row['md_billing_discount']!=0){ ?>
							<tr >
								<td style="margin-left: 20px;float: left;"> </td> 
								<td><p style="margin-right: 20px;float: right;">ส่วนลด  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_discount'],2) ?> </p></td> 
							</tr> 
						<?php } ?>
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ราคาสินค้า  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_total'],2) ?> </p></td> 
						</tr> 
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ราคาสินค้าก่อน vat  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_totalprice'],2) ?> </p></td> 
						</tr> 
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ภาษีมูลค่าเพิ่ม 7%  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_vat'],2) ?> </p></td> 
						</tr> 
						<tr >
							<td style="margin-left: 20px;float: left;">(จำนวนเงินตัวอักษร) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<span style="text-decoration:underline dotted;font-weight: bold;"><?php echo GetTextMoney(number_format($Row['md_billing_total'],2)) ?></span>)</td> 
							<td><p style="margin-right: 20px;float: right;">ยอดที่ต้องจ่ายสุทธิ  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="text-decoration:underline dotted;font-weight: bold;"><?php echo number_format($Row['md_billing_total'],2) ?></span></p></td> 
						</tr> 
					</table> <hr>  
				<?php }elseif($Row['md_billing_vattype']==0){ ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
						<?php if($Row['md_billing_discount']!=0){ ?>
							<tr >
								<td style="margin-left: 20px;float: left;"> </td> 
								<td><p style="margin-right: 20px;float: right;">ส่วนลด  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_discount'],2) ?> </p></td> 
							</tr> 
						<?php } ?>
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ราคาสินค้า  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_total'],2) ?> </p></td> 
						</tr> 
						<!-- <tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ราคาสินค้าก่อน vat  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_totalprice'],2) ?> </p></td> 
						</tr> 
						<tr >
							<td style="margin-left: 20px;float: left;"> </td> 
							<td><p style="margin-right: 20px;float: right;">ภาษีมูลค่าเพิ่ม 7%  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo number_format($Row['md_billing_vat'],2) ?> </p></td> 
						</tr>  -->
						<tr >
							<td style="margin-left: 20px;float: left;">(จำนวนเงินตัวอักษร) &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (<span style="text-decoration:underline dotted;font-weight: bold;"><?php echo GetTextMoney(number_format($Row['md_billing_total'],2)) ?></span>)</td> 
							<td><p style="margin-right: 20px;float: right;">ยอดที่ต้องจ่ายสุทธิ  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span style="text-decoration:underline dotted;font-weight: bold;"><?php echo number_format($Row['md_billing_total'],2) ?></span></p></td> 
						</tr> 
					</table> <hr> 
				<?php } ?>
			</td>
		</tr>
		<td colspan="3" valign="top" style="border:0px;text-align: center;"> 
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1" style="margin-top: 20px;">
				<tr>
					<td style="margin-left: 20px;float: left;">ผู้รับเงิน &nbsp;&nbsp; ......................................</td> 
					<td style="margin-right: 80px;float: right;">ผู้รับสินค้า &nbsp;&nbsp; ......................................</td> 
				</tr> 
				<tr>
					<?php if($Row['md_billing_type']==0){ ?>
						<td style="margin-left: 20px;float: left;">(เงินสด)</td>
					<?php }elseif($Row['md_billing_type']==1){ ?>
						<td style="margin-left: 20px;float: left;">(เงินโอน)<td>
					<?php } ?>
				</tr> 
				<tr> 
					<?php
						$sql_bank_maste = "SELECT * FROM md_bankname WHERE md_bankname_id='".$Row_custu['md_customer_bankid']."'";
						$query_bank_maste=$mysqli->query($sql_bank_maste);
						$Row_bank_name=$query_bank_maste->fetch_array();
						if($Row_custu['md_customer_bankid']=='' || $Row_custu['md_customer_bankid']==0){
							$bank_name = " ......................................";
						}else {
							$bank_name= $Row_bank_name['md_bankname_name'];
						}
						if($Row_custu['md_customer_bankcname']==''){
							$bankcname = " ......................................";
						}else {
							$bankcname= $Row_custu['md_customer_bankcname'];
						}
						if($Row_custu['md_customer_bankcnumber']==''){
							$bankcnumber = " ......................................";
						}else {
							$bankcnumber= $Row_custu['md_customer_bankcnumber'];
						}
					?> 
					<?php if($Row['md_billing_type']==1){ ?>
						<td style="margin-left: 20px;float: left;">ธนาคาร: <?php echo $bank_name ?>  &nbsp;&nbsp;ชื่อบัญชี: <?php echo $bankcname ?>  &nbsp;&nbsp;เลขบัญชี: <?php echo $bankcnumber ?>  <td>
					<?php } ?>
				</tr> 

			</table> 
		</td>
	</tr>
		
	</table>
</body>
</html>