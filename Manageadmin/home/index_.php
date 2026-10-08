<?php
include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");

include("../../libs/language_thai.php");	
include("../libs/language_thai.php");
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="FXTRB">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../../images/favicon.png">
    <!-- Page Title  -->
    <title><?php echo $core_name_header;?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../../assets/css/dashlite.css?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="../../assets/css/theme.css?ver=2.2.0"> 
    
    
</head>
<body class="nk-body bg-lighter npc-general has-sidebar <?php if($_SESSION["core_session_sys_mode"]=="darkmode"){ echo "dark-mode";}?>">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include("../include/include_left.php");?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include("../include/include_header.php");?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <!--<div id="load_mainwaiting">
                                     <div class="tb-cell">
                                        <div id="page-loading">
                                            <div></div>
                                        </div>
                                    </div>
                                </div>-->

                                <form action="" method="post" name="myForm" id="myForm">
                                <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
                                <input name="myaction" type="hidden" id="myaction" value="" />
                                <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
                                <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
                                <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
                                <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
                                </form>	
                                
                           <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Dashboard</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>Welcome to I Speed Express.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                   
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            
                            <div class="nk-block">
                                <div class="row g-gs">
                                	
                                    <div class="col-xxl-6">
                                    		<?php 
											$month=date("Y-m-d");
											$dayprice=array();
											for($i=0;$i<=24;$i++){
											$sql_sum = "SELECT sum(md_order_price),sum(md_order_codfee),sum(md_order_codfeecom),sum(md_order_codfeecombranch) FROM md_order WHERE md_order_status!='CC' AND md_order_credate LIKE '%".$month." ".sprintf("%02d",$i)."%'";
											$query_sum=$mysqli->query($sql_sum) or die("Error sql_sum:  <br/>$sql_sum<br />\n");
											$Row_sum=$query_sum->fetch_array();
											$arr_price=$Row_sum[0]+$Row_sum[1]+$Row_sum[2]+$Row_sum[3];
											$dayprice[]=number_format($arr_price,2,'.','');
											$totalday=$totalday+$arr_price;
											}
											//print_r($dateprice);
											$dayprice=json_encode($dayprice);
											?>
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">ยอดขายประจำวัน</h6>
                                                            <p>ในการขายการส่งพัสดุ 1 วัน</p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount">฿<?php echo number_format($totalday,2)?></span>
                                                        </div>
                                                        <!--<div class="nk-sale-data">
                                                            <span class="amount sm">1,937 <small>Subscribers</small></span>
                                                        </div>-->
                                                    </div>
                                                    <div class="nk-sales-ck large pt-4">
                                                        <canvas class="sales-overview-chart" id="salesOverviewDay"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        
                                        <div class="col-xxl-6">
                                    		<?php 
											$month=date("Y-m");
											$dateprice=array();
											for($i=1;$i<=31;$i++){
											$sql_sum = "SELECT sum(md_order_price),sum(md_order_codfee),sum(md_order_codfeecom),sum(md_order_codfeecombranch) FROM md_order WHERE md_order_status!='CC' AND md_order_credate LIKE '%".$month."-".sprintf("%02d",$i)."%'";
											$query_sum=$mysqli->query($sql_sum) or die("Error sql_sum:  <br/>$sql_sum<br />\n");
											$Row_sum=$query_sum->fetch_array();
											$arr_price=$Row_sum[0]+$Row_sum[1]+$Row_sum[2]+$Row_sum[3];
											$dateprice[]=number_format($arr_price,2,'.','');
											$totalmonth=$totalmonth+$arr_price;
											}
											//print_r($dateprice);
											$dateprice=json_encode($dateprice);
											?>
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group align-start gx-3 mb-3">
                                                        <div class="card-title">
                                                            <h6 class="title">ยอดขายประจำเดือน</h6>
                                                            <p>ในการขายการส่งพัสดุ 30 วัน</p>
                                                        </div>
                                                    </div>
                                                    <div class="nk-sale-data-group align-center justify-between gy-3 gx-5">
                                                        <div class="nk-sale-data">
                                                            <span class="amount">฿<?php echo number_format($totalmonth,2)?></span>
                                                        </div>
                                                        <!--<div class="nk-sale-data">
                                                            <span class="amount sm">1,937 <small>Subscribers</small></span>
                                                        </div>-->
                                                    </div>
                                                    <div class="nk-sales-ck large pt-4">
                                                        <canvas class="sales-overview-chart" id="salesOverview"></canvas>
                                                    </div>
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        
									<div class="col-lg-12 col-xxl-6">
                                            <div class="card card-bordered card-full">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title"><span class="mr-2">รายการส่งพัสดุประจำวัน</span> </h6>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0 border-top">
                                                    <div class="card-inner">
                                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col"><span class="sub-text">บริษัท</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">สาขา</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">Tracking</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">ปลายทาง</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">น้ำหนัก</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">ขนาด</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">COD</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">ราคารวม</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        	<?php
                                                            $sql = "SELECT * FROM md_order WHERE md_order_credate LIKE '%".date("Y-m-d")."%' ORDER BY md_order_id DESC LIMIT 30";
															$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
															$count_totalrecord=$query->num_rows;
															 
				$index=1;
				$color=0;
                if($count_totalrecord>0) {
				while($Row=$query->fetch_array()){
					$Row_id=		$Row["md_order_id"];
					$Row_name=		rechangeQuot($Row["md_order_fname"])." ".rechangeQuot($Row["md_order_lname"]);
					$Row_status=	$Row["md_order_status"];
					
				 ?>
                                                       <tr class="nk-tb-item">
                                                       <td class="nk-tb-col">
                                                        	<span><?php echo getAPIName($Row["md_order_api"]);?></span>
                                                        </td>
                                                       <td class="nk-tb-col">
                                                        	<span><?php echo getBranchName($Row["md_order_branchid"]);?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                             <span class="tb-lead"><a href="javascript:void(0)" data-toggle="modal" data-target="#modalview<?php echo $Row_id;?>"><?php echo $Row["md_order_label"];?></a></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_toprovince"];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_totalweight"];?></span>
                                                        </td>
                                                         <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_width"]."x".$Row["md_order_length"]."x".$Row["md_order_height"];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_codprice"];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_price"]+$Row['md_order_remotearea']+$Row['md_order_insureprice']+$Row['md_order_codfee']+$Row['md_order_codfeecom']+$Row['md_order_codfeecombranch'];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $Row_id?>">
                                                        <span class='badge badge-dim badge-outline-<?php echo $txt_mod["order:color"][$Row["md_order_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["order:status"][$Row["md_order_status"]];?></span>
                                                        
                                                        <div class="modal fade" tabindex="-1" id="modalview<?php echo $Row_id;?>">
                                                        <div class="modal-dialog" role="modalview<?php echo $Row_id;?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                    <h5 class="modal-title">รหัสการทำรายการ <?php echo $Row['md_order_number']?></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                   <table class="table table-hover table-striped table-data-list-button">
                    <tbody>
                    	<tr>
                            <td>Tracking</td>
                            <td class="info-name"><?php echo $Row['md_order_label']?></td>
                        </tr>
                        <?php if($Row['md_order_labelreturn']==1){?>
                        <tr>
                            <td>รหัสตีกลับ</td>
                            <td class="info-name"><?php echo $Row['md_order_labelreturn']?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td>ชื่อ</td>
                            <td class="info-name"><?php echo $Row['md_order_toname']?></td>
                        </tr>
                        <tr>
                            <td>ที่อยู่</td>
                            <td class="info-name"><?php echo $Row['md_order_toaddress1']." ".$Row['md_order_todistrict']." ".$Row['md_order_tocity']." ".$Row['md_order_toprovince']." ".$Row['md_order_topostcode']?></td>
                        </tr>
                        <tr>
                            <td>เบอร์โทร</td>
                            <td class="info-name"><?php echo $Row['md_order_tophone']?></td>
                        </tr>
                        <tr>
                            <td>น้ำหนัก (กรัม)</td>
                            <td class="info-name"><?php echo $Row['md_order_totalweight']?></td>
                        </tr>
                        <tr>
                            <td>ขนาดกล่อง( ซม. )</td>
                            <td class="info-name"><?php echo $Row["md_order_width"]."x".$Row["md_order_length"]."x".$Row["md_order_height"];?></td>
                        </tr>
                         <tr>
                            <td>ค่าขนส่ง</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_price']+$Row['md_order_remotearea']+$Row['md_order_insureprice'],2)?></td>
                        </tr>
                        <?php if($Row['md_order_cod']==1){?>
                        <tr>
                            <td>ยอดเก็บเงินปลายทาง</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_codprice'],2)?></td>
                        </tr>
                        <tr>
                            <td>ค่าธรรมยอดเก็บเงินปลายทาง</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_codfee']+$Row['md_order_codfeecom']+$Row['md_order_codfeecombranch'],2)?></td>
                        </tr>
                        <?php }?>
                         <tr>
                            <td>รวม</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_price']+$Row['md_order_remotearea']+$Row['md_order_insureprice']+$Row['md_order_codfee']+$Row['md_order_codfeecom']+$Row['md_order_codfeecombranch'],2)?></td>
                        </tr>
                        <?php if($Row['md_order_remark']!=""){?>
                         <tr>
                            <td>หมายเหตุ</td>
                            <td class="info-name"><?php echo $Row["md_order_remark"]?></td>
                        </tr>
                        <?php }?>
                        <?php if($Row['md_order_problem']==1){?>
                         <tr>
                            <td>ปัญหา</td>
                            <td class="info-name"><?php echo $Row["md_order_message"]?></td>
                        </tr>
                        <?php }?>
                        <?php if($Row['md_order_comment']!=""){?>
                         <tr>
                            <td>Comment</td>
                            <td class="info-name"><?php echo $Row["md_order_comment"]?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td>วันที่สร้างรายการ</td>
                            <td class="info-name"><?php echo ShowDateTimeThai($Row["md_order_credate"]);?></td>
                        </tr>
                         <tr>
                            <td>สถานะ</td>
                            <td class="info-name"><span class='badge badge-dim badge-outline-<?php echo $txt_mod["order:color"][$Row["md_order_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["order:status"][$Row["md_order_status"]];?></span></td>
                        </tr>
                         
                    </tbody>
                    </table>
                    <hr />
                    <div class="form-group" align="center"><button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">ปิด</button></div>
                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                        </td>
                                                    </tr><!-- .nk-tb-item  --> 
    												
                                                    
    
                                          <?php $index++;$color++; 
									}//while($Row=$query->fetch_array()){
							}//if($count_record>0) {?>
                                                </tbody>
                                            </table>

                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner-sm border-top text-center d-sm-none">
                                                    <a href="#" class="btn btn-link btn-block">See History</a>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        
                                        <div class="col-lg-12 col-xxl-6">
                                            <div class="card card-bordered card-full">
                                                <div class="card-inner">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title"><span class="mr-2">รายการส่งพัสดุประจำเดือน</span> </h6>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0 border-top">
                                                    <div class="card-inner">
                                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col"><span class="sub-text">บริษัท</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">สาขา</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">Tracking</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">ปลายทาง</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">น้ำหนัก</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">ขนาด</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">COD</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text">ราคารวม</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        	<?php
                                                            $sql = "SELECT * FROM md_order WHERE md_order_credate LIKE '%".date("Y-m")."%' ORDER BY md_order_id DESC LIMIT 30";
															$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
															$count_totalrecord=$query->num_rows;
															 
				$index=1;
				$color=0;
                if($count_totalrecord>0) {
				while($Row=$query->fetch_array()){
					$Row_id=		$Row["md_order_id"];
					$Row_name=		rechangeQuot($Row["md_order_fname"])." ".rechangeQuot($Row["md_order_lname"]);
					$Row_status=	$Row["md_order_status"];
					
				 ?>
                                                       <tr class="nk-tb-item">
                                                        <td class="nk-tb-col">
                                                        	<span><?php echo getAPIName($Row["md_order_api"]);?></span>
                                                       </td>
                                                       <td class="nk-tb-col">
                                                        	<span><?php echo getBranchName($Row["md_order_branchid"]);?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                             <span class="tb-lead"><a href="javascript:void(0)" data-toggle="modal" data-target="#modalview<?php echo $Row_id;?>"><?php echo $Row["md_order_label"];?></a></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_toprovince"];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_totalweight"];?></span>
                                                        </td>
                                                         <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_width"]."x".$Row["md_order_length"]."x".$Row["md_order_height"];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_codprice"];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php echo $Row["md_order_price"]+$Row['md_order_remotearea']+$Row['md_order_insureprice']+$Row['md_order_codfee']+$Row['md_order_codfeecom']+$Row['md_order_codfeecombranch'];?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $Row_id?>">
                                                        <span class='badge badge-dim badge-outline-<?php echo $txt_mod["order:color"][$Row["md_order_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["order:status"][$Row["md_order_status"]];?></span>
                                                        
                                                        <div class="modal fade" tabindex="-1" id="modalview<?php echo $Row_id;?>">
                                                        <div class="modal-dialog" role="modalview<?php echo $Row_id;?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                    <h5 class="modal-title">รหัสการทำรายการ <?php echo $Row['md_order_number']?></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                   <table class="table table-hover table-striped table-data-list-button">
                    <tbody>
                    	<tr>
                            <td>Tracking</td>
                            <td class="info-name"><?php echo $Row['md_order_label']?></td>
                        </tr>
                        <?php if($Row['md_order_labelreturn']==1){?>
                        <tr>
                            <td>รหัสตีกลับ</td>
                            <td class="info-name"><?php echo $Row['md_order_labelreturn']?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td>ชื่อ</td>
                            <td class="info-name"><?php echo $Row['md_order_toname']?></td>
                        </tr>
                        <tr>
                            <td>ที่อยู่</td>
                            <td class="info-name"><?php echo $Row['md_order_toaddress1']." ".$Row['md_order_todistrict']." ".$Row['md_order_tocity']." ".$Row['md_order_toprovince']." ".$Row['md_order_topostcode']?></td>
                        </tr>
                        <tr>
                            <td>เบอร์โทร</td>
                            <td class="info-name"><?php echo $Row['md_order_tophone']?></td>
                        </tr>
                        <tr>
                            <td>น้ำหนัก (กรัม)</td>
                            <td class="info-name"><?php echo $Row['md_order_totalweight']?></td>
                        </tr>
                        <tr>
                            <td>ขนาดกล่อง( ซม. )</td>
                            <td class="info-name"><?php echo $Row["md_order_width"]."x".$Row["md_order_length"]."x".$Row["md_order_height"];?></td>
                        </tr>
                         <tr>
                            <td>ค่าขนส่ง</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_price']+$Row['md_order_remotearea']+$Row['md_order_insureprice'],2)?></td>
                        </tr>
                        <?php if($Row['md_order_cod']==1){?>
                        <tr>
                            <td>ยอดเก็บเงินปลายทาง</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_codprice'],2)?></td>
                        </tr>
                        <tr>
                            <td>ค่าธรรมยอดเก็บเงินปลายทาง</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_codfee']+$Row['md_order_codfeecom']+$Row['md_order_codfeecombranch'],2)?></td>
                        </tr>
                        <?php }?>
                         <tr>
                            <td>รวม</td>
                            <td class="info-name"><?php echo number_format($Row['md_order_price']+$Row['md_order_remotearea']+$Row['md_order_insureprice']+$Row['md_order_codfee']+$Row['md_order_codfeecom']+$Row['md_order_codfeecombranch'],2)?></td>
                        </tr>
                        <?php if($Row['md_order_remark']!=""){?>
                         <tr>
                            <td>หมายเหตุ</td>
                            <td class="info-name"><?php echo $Row["md_order_remark"]?></td>
                        </tr>
                        <?php }?>
                        <?php if($Row['md_order_problem']==1){?>
                         <tr>
                            <td>ปัญหา</td>
                            <td class="info-name"><?php echo $Row["md_order_message"]?></td>
                        </tr>
                        <?php }?>
                        <?php if($Row['md_order_comment']!=""){?>
                         <tr>
                            <td>Comment</td>
                            <td class="info-name"><?php echo $Row["md_order_comment"]?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td>วันที่สร้างรายการ</td>
                            <td class="info-name"><?php echo ShowDateTimeThai($Row["md_order_credate"]);?></td>
                        </tr>
                         <tr>
                            <td>สถานะ</td>
                            <td class="info-name"><span class='badge badge-dim badge-outline-<?php echo $txt_mod["order:color"][$Row["md_order_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["order:status"][$Row["md_order_status"]];?></span></td>
                        </tr>
                         
                    </tbody>
                    </table>
                    <hr />
                    <div class="form-group" align="center"><button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">ปิด</button></div>
                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                        </td>
                                                    </tr><!-- .nk-tb-item  --> 
    												
                                                    
    
                                          <?php $index++;$color++; 
									}//while($Row=$query->fetch_array()){
							}//if($count_record>0) {?>
                                                </tbody>
                                            </table>

                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner-sm border-top text-center d-sm-none">
                                                    <a href="#" class="btn btn-link btn-block">See History</a>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                       
                                        
                                        <div class="col-lg-6 col-xxl-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner border-bottom">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">สรุปข้อมูลการจัดส่งพัสดุตามจังหวัดปลายทาง</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-inner">
                                                
                                                 <div id="mapdiv" style="width: 100%; height: 500px;"></div>
                                                   
                                                </div>
                                            </div><!-- .card -->
                                        </div><!-- .col -->
										<?php
											$sql_distinct = "SELECT DISTINCT(md_postcode_provincecode),md_postcode_provincethai FROM md_postcode WHERE 1=1 ORDER BY md_postcode_provincecode ASC";
											$query_distinct=$mysqli->query($sql_distinct) or die("Error sql_distinct:  <br/>$sql_distinct<br />\n");
											$index=0;
											$Data = [];
											$provincedata = [];
											while($Row_distinct=$query_distinct->fetch_array()){
												$code=substr($Row_distinct["md_postcode_provincecode"],0,2);
												$number=substr($Row_distinct["md_postcode_provincecode"],2);
												$sql_order = "SELECT * FROM md_order WHERE md_order_toprovince='".$Row_distinct["md_postcode_provincethai"]."' AND md_order_status!='CC'";
												$query_order=$mysqli->query($sql_order) or die("Error sql_order:  <br/>$sql_order<br />\n");
												$count_totalrecord=$query_order->num_rows;
												$Data[$index]["id"] 			= $code."-".$number;
												$Data[$index]["value"] 			= $count_totalrecord;
												
												$provincedata[$index]["province"] 			= $Row_distinct["md_postcode_provincethai"];
												$provincedata[$index]["value"] 			= $count_totalrecord;												
												$index++;
												$total=$total+$count_totalrecord;
											}
											$province=json_encode($Data);
											
?>
                                        <div class="col-lg-6 col-xxl-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner border-bottom">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                            <h6 class="title">10 อันดับจังหวัดปลายทางที่มีการส่งพัสดุมากที่สุด</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-list is-loose">
                                                    <?php 
													
													foreach ($provincedata as $key => $Row) {
													$arrival[$key]  = $Row['value'];
													}
												
													array_multisort($arrival, SORT_DESC, $provincedata);
													//print_r($provincedata);
	
                                                    for($i=0;$i<10;$i++){
														//echo "key= $key val=$val<br>";
                                                        //if($key<10){
															//$province1=explode(":",$val);
															//if($province1[0]>0){
													?>
                                                        <div class="nk-tb-item">
                                                            <div class="nk-tb-col">
                                                                <div class="icon-text">
                                                                    <em class="text-primary icon ni ni-globe"></em>
                                                                    <span class="tb-lead"><?php echo $provincedata[$i]['province']?></span>
                                                                </div>
                                                            </div>
                                                            <?php $progress=($provincedata[$i]['value']*100)/$total?>
                                                            <div class="nk-tb-col text-right">
                                                                <span class="tb-sub tb-amount"><span><?php echo number_format($progress,2)?>%</span></span>
                                                            </div>
                                                            <div class="nk-tb-col">
                                                                <div class="fake-class">
                                                                    <div class="progress progress-lg">
                                                                        <div class="progress-bar" data-progress="<?php echo number_format($progress,2)?>"></div>
                                                                        <div class="progress-amount">&nbsp;&nbsp;&nbsp;</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="nk-tb-col text-right">
                                                                <span class="tb-sub tb-amount"><span><?php echo $provincedata[$i]['value']?> ชิ้น</span></span>
                                                            </div>
                                                            
                                                        </div><!-- .nk-tb-item -->
                                                        <?php 
															//}//if($province1[0]>0){
														//}//if($key<10){
                                                    }//for($i=0;$i<10;$i++){
													?>
                                                    
                                                    
                                                </div><!-- .nk-tb-list -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                    
                                </div>
                                
                                
                            </div>						
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
               <?php include("../include/include_footer.php");?>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->

    <!-- JavaScript -->
    <script src="../../assets/js/bundle.js?ver=2.2.0"></script>
    <script src="../../assets/js/scripts.js?ver=2.2.0"></script>  
    <script src="../../ammap/ammap.js" type="text/javascript"></script>

    <script src="index.js"></script>
	<!-- map file should be included after ammap.js -->
	<script src="../../ammap/maps/js/thailandHigh.js" type="text/javascript"></script>
    
	<script>
	"use strict";

!function (NioApp, $) {
  "use strict"; //////// for developer - User Balance //////// 
	
	var salesOverview = {
    labels: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31"],
    dataUnit: 'บาท',
    lineTension: 0.1,
    datasets: [{
      label: "Sales Overview",
      color: "#798bff",
      background: NioApp.hexRGB('#798bff', .3),
      data: <?php echo $dateprice?>
    }]
  };
  
  var salesOverviewDay = {
    labels: ["00","01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23"],
    dataUnit: 'บาท',
    lineTension: 0.1,
    datasets: [{
      label: "Sales Overview Day",
      color: "#798bff",
      background: NioApp.hexRGB('#798bff', .3),
      data: <?php echo $dayprice?>
    }]
  };

  function lineSalesOverview(selector, set_data) {
    var $selector = selector ? $(selector) : $('#salesOverview');
    $selector.each(function () {
      var $self = $(this),
          _self_id = $self.attr('id'),
          _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];

      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          tension: _get_data.lineTension,
          backgroundColor: _get_data.datasets[i].background,
          borderWidth: 2,
          borderColor: _get_data.datasets[i].color,
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: _get_data.datasets[i].color,
          pointBorderWidth: 2,
          pointHoverRadius: 3,
          pointHoverBorderWidth: 2,
          pointRadius: 3,
          pointHitRadius: 3,
          data: _get_data.datasets[i].data
        });
      }

      var chart = new Chart(selectCanvas, {
        type: 'line',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              position: NioApp.State.isRTL ? "right" : "left",
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                fontColor: '#9eaecf',
                padding: 10,
                callback: function callback(value, index, values) {
                  return '฿ ' + value;
                },
                min: 100,
                stepSize: 3000
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 10,
                reverse: NioApp.State.isRTL
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });
    });
  } // init chart
  
  function lineSalesOverviewDay(selector, set_data) {
    var $selector = selector ? $(selector) : $('#salesOverviewDay');
    $selector.each(function () {
      var $self = $(this),
          _self_id = $self.attr('id'),
          _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

      var selectCanvas = document.getElementById(_self_id).getContext("2d");
      var chart_data = [];

      for (var i = 0; i < _get_data.datasets.length; i++) {
        chart_data.push({
          label: _get_data.datasets[i].label,
          tension: _get_data.lineTension,
          backgroundColor: _get_data.datasets[i].background,
          borderWidth: 2,
          borderColor: _get_data.datasets[i].color,
          pointBorderColor: "transparent",
          pointBackgroundColor: "transparent",
          pointHoverBackgroundColor: "#fff",
          pointHoverBorderColor: _get_data.datasets[i].color,
          pointBorderWidth: 2,
          pointHoverRadius: 3,
          pointHoverBorderWidth: 2,
          pointRadius: 3,
          pointHitRadius: 3,
          data: _get_data.datasets[i].data
        });
      }

      var chart = new Chart(selectCanvas, {
        type: 'line',
        data: {
          labels: _get_data.labels,
          datasets: chart_data
        },
        options: {
          legend: {
            display: _get_data.legend ? _get_data.legend : false,
            labels: {
              boxWidth: 30,
              padding: 20,
              fontColor: '#6783b8'
            }
          },
          maintainAspectRatio: false,
          tooltips: {
            enabled: true,
            rtl: NioApp.State.isRTL,
            callbacks: {
              title: function title(tooltipItem, data) {
                return data['labels'][tooltipItem[0]['index']];
              },
              label: function label(tooltipItem, data) {
                return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
              }
            },
            backgroundColor: '#eff6ff',
            titleFontSize: 13,
            titleFontColor: '#6783b8',
            titleMarginBottom: 6,
            bodyFontColor: '#9eaecf',
            bodyFontSize: 12,
            bodySpacing: 4,
            yPadding: 10,
            xPadding: 10,
            footerMarginTop: 0,
            displayColors: false
          },
          scales: {
            yAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              position: NioApp.State.isRTL ? "right" : "left",
              ticks: {
                beginAtZero: true,
                fontSize: 11,
                fontColor: '#9eaecf',
                padding: 10,
                callback: function callback(value, index, values) {
                  return '฿ ' + value;
                },
                min: 100,
                stepSize: 300
              },
              gridLines: {
                color: NioApp.hexRGB("#526484", .2),
                tickMarkLength: 0,
                zeroLineColor: NioApp.hexRGB("#526484", .2)
              }
            }],
            xAxes: [{
              display: true,
              stacked: _get_data.stacked ? _get_data.stacked : false,
              ticks: {
                fontSize: 9,
                fontColor: '#9eaecf',
                source: 'auto',
                padding: 10,
                reverse: NioApp.State.isRTL
              },
              gridLines: {
                color: "transparent",
                tickMarkLength: 0,
                zeroLineColor: 'transparent'
              }
            }]
          }
        }
      });
    });
  } // init chart


  NioApp.coms.docReady.push(function () {
    lineSalesOverview();
	lineSalesOverviewDay();
  });
	
}(NioApp, jQuery);
  		
	var map;
	AmCharts.ready(function() {
		map 		= new AmCharts.AmMap();
		map.type 	= "map";
		map.theme 	= "none";
		map.colorSteps = 11;

		map.valueLegend = {
			right : 10,
			minValue: "น้อย",
			maxValue: "มาก"
		};

		map.areasSettings = {
			autoZoom :false,
		    outlineAlpha: 1,
		    rollOverOutlineColor: "#666666",
		    outlineThickness: 1, // Border between area
		    color: "#ededed", // BG MAP",
		    balloonText: "<b>[[title]]</b> </br>จำนวนพัสดุ [[value]]",
		    colorSolid: "#0079a5"
		};

	    var dataProvider = {
	        mapVar: AmCharts.maps['thailandHigh'],
    		getAreasFromMap:true,
			zoomLevel: 0.9,
		    areas: <?php echo $province;?>	    
		};

	    map.dataProvider = dataProvider;

	    map.write("mapdiv");

	});

		</script>
    
</body>

</html>