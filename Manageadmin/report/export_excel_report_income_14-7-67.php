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
           
   
		   $sql = "SELECT * FROM md_income WHERE md_income_status='1'";
		   if($_REQUEST["startdate"]!="" && $_REQUEST["enddate"]!=""){
			   $sql .= " AND md_income_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["enddate"])." 23:59:59'";
		   }  
		   //echo $sql;
		   $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");     
		   $Cell_index=4;
		   $index=1;
?>

<TABLE  x:str BORDER="1">					
					<thead>
						<tr>
              				<th>วันที่&nbsp;</th> 
							<th>รายการ</th>
							<th>จำนวนเงิน</th> 
							<th>รายละเอียด</th> 
                            <th>เจ้าหน้าที่</th> 
						</tr>
					</thead>
					<?php 
				$discount=0;
            	$count_row=$query->num_rows;  // นับจำนวนถวที่แสดง ทั้งหมด 
			   if($count_row>0){ 
				 while($row=$query->fetch_array()){ // วนลูปแสดงข้อมูล     
					$total=$total+$row["md_income_total"];
				 ?>
				 	<tr class="nk-tb-item">
                        <td align="left"><?php echo ShowDateTimeThai($row["md_income_date"]);?> </td> 
                        <td><?php echo getTypeIncome($row["md_income_typeid"])?></td>
                        <td><?php echo $row["md_income_total"];?></td>
						<td><?php echo $row["md_income_detail"];?></td>
                        <td><?php echo getStaffName($row["md_income_crebyid"]);?></td> 
                        </tr>
                <?php  
				}// while($Row=$query->fetch_array()){ 
			   }//if($count_row>0){ 
                  ?>
                  	<tr class="nk-tb-item">
                        <td></td>
                        <td></td>
						<td><?php echo number_format($total,2)?></td> 
						<td></td> 
					</tr>


           
</TABLE>
 
