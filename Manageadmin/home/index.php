<?php
include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");

if($_SESSION['core_session_sys_language']=="thai"){
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../libs/language_eng.php");
}
$txt_mod["billing:color"] = array('','success','danger');
$txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก');
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
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../include/include_header.php");?>
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
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
                                            <p>Welcome</p>
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
											for($i=0;$i<=23;$i++){
											$sql_sum = "SELECT sum(md_billing_detail_total) FROM md_billing_detail WHERE md_billing_detail_status!='2' AND md_billing_detail_credate LIKE '%".$month." ".sprintf("%02d",$i)."%'";
											$query_sum=$mysqli->query($sql_sum) or die("Error sql_sum:  <br/>$sql_sum<br />\n");
											$Row_sum=$query_sum->fetch_array();
											$arr_price=$Row_sum[0];
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
                                                            <h6 class="title">ยอดซื้อประจำวัน</h6>
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
											$sql_sum = "SELECT sum(md_billing_detail_total) FROM md_billing_detail WHERE md_billing_detail_status!='2' AND md_billing_detail_credate LIKE '%".$month."-".sprintf("%02d",$i)."%'";
											$query_sum=$mysqli->query($sql_sum) or die("Error sql_sum:  <br/>$sql_sum<br />\n");
											$Row_sum=$query_sum->fetch_array();
											$arr_price=$Row_sum[0];
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
                                                            <h6 class="title">ยอดซื้อประจำเดือน</h6>
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
                                                            <h6 class="title"><span class="mr-2">รายการบิลประจำวัน</span> </h6>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0 border-top">
                                                    <div class="card-inner">
                                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col"><span class="sub-text">เลขที่บิล</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">จำนวน</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        	<?php
                                                            $sql = "SELECT * FROM md_billing WHERE md_billing_credate LIKE '%".date("Y-m-d")."%' ORDER BY md_billing_id DESC LIMIT 30";
															$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
															$count_totalrecord=$query->num_rows;
															 
				$index=1;
				$color=0;
                if($count_totalrecord>0) {
				while($Row=$query->fetch_array()){
					$Row_id=		$Row["md_billing_id"];
					$Row_status=	$Row["md_billing_status"];
					
				 ?>
                                                       <tr class="nk-tb-item">
                                                       <td class="nk-tb-col">
                                                        	<a href="javascript:void(0)" data-toggle="modal" data-target="#modalview<?php echo $Row_id;?>"><span><?php echo $Row["md_billing_number"];?></span></a>
                                                        </td>
                                                       <td class="nk-tb-col">
                                                        	<span><?php echo number_format($Row["md_billing_total"],2);?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $Row_id?>">
                                                        <span class='badge badge-dim badge-outline-<?php echo $txt_mod["billing:color"][$Row["md_billing_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["billing:status"][$Row["md_billing_status"]];?></span>
                                                        
                                                        <div class="modal fade" tabindex="-1" id="modalview<?php echo $Row_id;?>">
                                                        <div class="modal-dialog" role="modalview<?php echo $Row_id;?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                    <h5 class="modal-title">เลขที่บิล <?php echo $Row['md_billing_number']?></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                   <table class="table table-hover table-striped table-data-list-button">
                    <thead>
                                    	<tr>
                                            <th scope="col"><span class="sub-text">สินค้า</span></th>
                                            <th scope="col"><span class="sub-text">ราคาต่อหน่วย</span></th>
                                            <th scope="col"><span class="sub-text">จำนวน</span></th>
                                            <th scope="col"><span class="sub-text">ราคารวม</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                         $sql_detail = "SELECT * FROM md_billing_detail WHERE md_billing_detail_billingid='".$Row['md_billing_id']."'";
										 $query_detail=$mysqli->query($sql_detail) or die("Error sql_detail:  <br/>$sql_detail<br />\n");
										 while($Row_detail=$query_detail->fetch_array()){
											 
										?>
                                    	<tr>
                                        	<th scope="row"><?php echo getProductName($Row_detail['md_billing_detail_productid'])?></th>
                                            <td><?php echo number_format($Row_detail["md_billing_detail_price"],2);?></td>
                                            <td><?php echo $Row_detail["md_billing_detail_amount"];?></td>
                                            <td><?php echo number_format($Row_detail["md_billing_detail_total"],2);?></td>
                                        </tr>
                                        <?php }?>
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
                                                            <h6 class="title"><span class="mr-2">รายการบิลประจำเดือน</span> </h6>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-inner -->
                                                <div class="card-inner p-0 border-top">
                                                    <div class="card-inner">
                                                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                        <th class="nk-tb-col"><span class="sub-text">เลขที่บิล</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">จำนวน</span></th>
                                                        <th class="nk-tb-col tb-col-md"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        	<?php
                                                            $sql = "SELECT * FROM md_billing WHERE md_billing_credate LIKE '%".date("Y-m")."%' ORDER BY md_billing_id DESC LIMIT 30";
															$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
															$count_totalrecord=$query->num_rows;
															 
				$index=1;
				$color=0;
                if($count_totalrecord>0) {
				while($Row=$query->fetch_array()){
					$Row_id=		$Row["md_billing_id"];
					$Row_name=		rechangeQuot($Row["md_billing_fname"])." ".rechangeQuot($Row["md_billing_lname"]);
					$Row_status=	$Row["md_billing_status"];
					
				 ?>
                                                       <tr class="nk-tb-item">
                                                        <td class="nk-tb-col">
                                                        	<a href="javascript:void(0)" data-toggle="modal" data-target="#modalview<?php echo $Row_id;?>"><span><?php echo $Row["md_billing_number"];?></span></a>
                                                        </td>
                                                       <td class="nk-tb-col">
                                                        	<span><?php echo number_format($Row["md_billing_total"],2);?></span>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $Row_id?>">
                                                        <span class='badge badge-dim badge-outline-<?php echo $txt_mod["billing:color"][$Row["md_billing_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["billing:status"][$Row["md_billing_status"]];?></span>
                                                        
                                                        <div class="modal fade" tabindex="-1" id="modalview<?php echo $Row_id;?>">
                                                        <div class="modal-dialog" role="modalview<?php echo $Row_id;?>">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                    <h5 class="modal-title">เลขที่บิล <?php echo $Row['md_billing_number']?></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                   <table class="table table-hover table-striped table-data-list-button">
                    <thead>
                                    	<tr>
                                            <th scope="col"><span class="sub-text">สินค้า</span></th>
                                            <th scope="col"><span class="sub-text">ราคาต่อหน่วย</span></th>
                                            <th scope="col"><span class="sub-text">จำนวน</span></th>
                                            <th scope="col"><span class="sub-text">ราคารวม</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                         $sql_detail = "SELECT * FROM md_billing_detail WHERE md_billing_detail_billingid='".$Row['md_billing_id']."'";
										 $query_detail=$mysqli->query($sql_detail) or die("Error sql_detail:  <br/>$sql_detail<br />\n");
										 while($Row_detail=$query_detail->fetch_array()){
											 
										?>
                                    	<tr>
                                        	<th scope="row"><?php echo getProductName($Row_detail['md_billing_detail_productid'])?></th>
                                            <td><?php echo number_format($Row_detail["md_billing_detail_price"],2);?></td>
                                            <td><?php echo $Row_detail["md_billing_detail_amount"];?></td>
                                            <td><?php echo number_format($Row_detail["md_billing_detail_total"],2);?></td>
                                        </tr>
                                        <?php }?>
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

    <script src="index.js"></script>
    
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
  		
		</script>
    
</body>

</html>