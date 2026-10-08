<?php
include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");
?>

            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="container-xl wide-xl">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head nk-block-head-sm">
                                <div class="nk-block-between">
                                    <div class="nk-block-head-content">
                                        <h3 class="nk-block-title page-title">Investment Dashboard</h3>
                                        <div class="nk-block-des text-soft">
                                            <p>Welcome to DashLite Dashboard Template.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <div class="toggle-wrap nk-block-tools-toggle">
                                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            <div class="toggle-expand-content" data-content="pageMenu">
                                                <ul class="nk-block-tools g-3">
                                                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
                                                    <li><a href="#" class="btn btn-white btn-dim btn-outline-primary"><em class="icon ni ni-reports"></em><span>Reports</span></a></li>
                                                    <li class="nk-block-tools-opt">
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#"><em class="icon ni ni-user-add-fill"></em><span>Add User</span></a></li>
                                                                    <li><a href="#"><em class="icon ni ni-coin-alt-fill"></em><span>Add Order</span></a></li>
                                                                    <li><a href="#"><em class="icon ni ni-note-add-fill-c"></em><span>Add Page</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div><!-- .toggle-expand-content -->
                                        </div><!-- .toggle-wrap -->
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="row g-gs">
                                    <div class="col-md-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="subtitle">Total Deposit</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Deposited"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"> 49,595.34 <span class="currency currency-usd">USD</span>
                                                    </span>
                                                    <span class="change up text-danger"><em class="icon ni ni-arrow-long-up"></em>1.93%</span>
                                                </div>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title">This Month</div>
                                                            <div class="amount">2,940.59 <span class="currency currency-usd">USD</span></div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">This Week</div>
                                                            <div class="amount">1,259.28 <span class="currency currency-usd">USD</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-ck">
                                                        <canvas class="iv-data-chart" id="totalDeposit1"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="subtitle">Total Withdraw</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Withdraw"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"> 49,595.34 <span class="currency currency-usd">USD</span>
                                                    </span>
                                                    <span class="change down text-danger"><em class="icon ni ni-arrow-long-down"></em>1.93%</span>
                                                </div>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title">This Month</div>
                                                            <div class="amount">2,940.59 <span class="currency currency-usd">USD</span></div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">This Week</div>
                                                            <div class="amount">1,259.28 <span class="currency currency-usd">USD</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-ck">
                                                        <canvas class="iv-data-chart" id="totalWithdraw1"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    <div class="col-md-4">
                                        <div class="card card-bordered  card-full">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-0">
                                                    <div class="card-title">
                                                        <h6 class="subtitle">Balance in Account</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <em class="card-hint icon ni ni-help-fill" data-toggle="tooltip" data-placement="left" title="Total Balance in Account"></em>
                                                    </div>
                                                </div>
                                                <div class="card-amount">
                                                    <span class="amount"> 79,358.50 <span class="currency currency-usd">USD</span>
                                                    </span>
                                                </div>
                                                <div class="invest-data">
                                                    <div class="invest-data-amount g-2">
                                                        <div class="invest-data-history">
                                                            <div class="title">This Month</div>
                                                            <div class="amount">2,940.59 <span class="currency currency-usd">USD</span></div>
                                                        </div>
                                                        <div class="invest-data-history">
                                                            <div class="title">This Week</div>
                                                            <div class="amount">1,259.28 <span class="currency currency-usd">USD</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="invest-data-ck">
                                                        <canvas class="iv-data-chart" id="totalBalance1"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                   <div class="col-lg-8">
                                        <div class="card card-bordered h-100">
                                            <div class="card-inner">
                                                <div class="card-title-group align-start mb-3">
                                                    <div class="card-title">
                                                        <h6 class="title">Orders Overview</h6>
                                                        <p>In last 15 days buy and sells overview. <a href="#" class="link link-sm">Detailed Stats</a></p>
                                                    </div>
                                                    <div class="card-tools mt-n1 mr-n1">
                                                        <div class="drodown">
                                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                            <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                                <ul class="link-list-opt no-bdr">
                                                                    <li><a href="#" class="active"><span>15 Days</span></a></li>
                                                                    <li><a href="#"><span>30 Days</span></a></li>
                                                                    <li><a href="#"><span>3 Months</span></a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-title-group -->
                                                <div class="nk-order-ovwg">
                                                    <div class="row g-4 align-end">
                                                        <div class="col-xxl-8">
                                                            <div class="nk-order-ovwg-ck">
                                                                <canvas class="order-overview-chart" id="orderOverview"></canvas>
                                                            </div>
                                                        </div><!-- .col -->
                                                        <div class="col-xxl-4">
                                                            <div class="row g-4">
                                                                <div class="col-sm-6 col-xxl-12">
                                                                    <div class="nk-order-ovwg-data buy">
                                                                        <div class="amount">12,954.63 <small class="currenct currency-usd">USD</small></div>
                                                                        <div class="info">Last month <strong>39,485 <span class="currenct currency-usd">USD</span></strong></div>
                                                                        <div class="title"><em class="icon ni ni-arrow-down-left"></em> Buy Orders</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-xxl-12">
                                                                    <div class="nk-order-ovwg-data sell">
                                                                        <div class="amount">12,954.63 <small class="currenct currency-usd">USD</small></div>
                                                                        <div class="info">Last month <strong>39,485 <span class="currenct currency-usd">USD</span></strong></div>
                                                                        <div class="title"><em class="icon ni ni-arrow-up-left"></em> Sell Orders</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .col -->
                                                    </div>
                                                </div><!-- .nk-order-ovwg -->
                                            </div><!-- .card-inner -->
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    
                                    <div class="col-lg-4">
                                        <div class="card card-bordered card-full">
                                                    <div class="card-inner">
                                                        <div class="card-title-group align-start mb-2">
                                                            <div class="card-title">
                                                                <h6 class="title">Top Coin in Orders</h6>
                                                                <p>In last 30 days buy and sells overview.</p>
                                                            </div>
                                                        </div><!-- .card-title-group -->
                                                        <div class="nk-coin-ovwg">
                                                            <div class="nk-coin-ovwg-ck">
                                               <canvas class="coin-overview-chart" id="coinOverview1"></canvas>
                                                            </div>
                                                            <ul class="nk-coin-ovwg-legends">
                                                                <li><span class="dot dot-lg sq" data-bg="#f98c45"></span><span>EURUSDc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#9cabff"></span><span>EURUSDc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#8feac5"></span><span>GBPAUDc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#6b79c8"></span><span>USDCADc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#79f1dc"></span><span>AUDUSDc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#79f1dc"></span><span>AUDJPYc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#79f1dc"></span><span>CADJPYc</span></li>
                                                                <li><span class="dot dot-lg sq" data-bg="#79f1dc"></span><span>NZDUSDc</span></li>
                                                            </ul>
                                                        </div><!-- .nk-coin-ovwg -->
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card -->
                                    </div><!-- .col -->
                                    
                                    <div class="col-lg-8">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Recent Investment</h6>
                                                    </div>
                                                    <div class="card-tools">
                                                        <a href="../financial/deposit.php?masterkey=depositfunds&&menukeyid=4&&MenuActive=3&&SubMenuActive=4" class="link">View All</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-tb-list">
                                                <div class="nk-tb-item nk-tb-head">
                                                    <div class="nk-tb-col"><span>Transaction</span></div>
                                                    <div class="nk-tb-col tb-col-sm"><span>Username</span></div>
                                                    <div class="nk-tb-col tb-col-lg"><span>Payment</span></div>
                                                    <div class="nk-tb-col"><span>Amount</span></div>
                                                    <div class="nk-tb-col tb-col-sm"><span>&nbsp;</span></div>
                                                    <div class="nk-tb-col"><span>&nbsp;</span></div>
                                                </div>
												<?php
                                                $sql_deposit = "SELECT * FROM md_finanial_deposit WHERE df_status!='RJ' ORDER BY df_credate DESC LIMIT 5";
												$query_deposit=$mysqli->query($sql_deposit) or die("Error sql_deposit: เกิดความผิดพลาด <br>$sql_deposit");
												while($row_deposit=$query_deposit->fetch_array()){
												$coloractive=$txt_mod["financial:ststuscolor"][$row_deposit["df_status"]];
												?>
                                                <div class="nk-tb-item">
                                                    <div class="nk-tb-col">
                                                        <div class="nk-tnx-type">
                                                            	<div class="nk-tnx-type-icon bg-<?php echo $coloractive;?>-dim text-<?php echo $coloractive;?>">
                                                                	<em class="icon ni ni-arrow-up-right"></em>
                                                                </div>
                                                                <div class="nk-tnx-type-text">
                                                                	<span class="tb-lead"><?php echo $row_deposit["df_number"];?></span>
                                                                    <span class="tb-date"><?php echo ShowDateEngTime($row_deposit["df_credate"]);?></span>
                                                                </div>
                                                           </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <div class="user-card">
                                                            <div class="user-name">
                                                                <span class="tb-lead"><?php echo getUsername($row_deposit["account_id"]);?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-lg">
                                                        <span class="tb-sub"><?php echo $txt_mod["financial:payment"][$row_deposit["df_type"]]?></span>
                                                    </div>
                                                    <div class="nk-tb-col">
                                                        <span class="tb-sub tb-amount">$<?php echo number_format($row_deposit["df_deposit"],2)?></span>
                                                    </div>
                                                    <div class="nk-tb-col tb-col-sm">
                                                        <span class="tb-sub text-<?php echo $coloractive;?>"><?php echo $txt_mod["financial:ststus"][$row_deposit["df_status"]]?></span>
                                                    </div>
                                                </div>
                                                <?php }//while($row_deposit=$query_deposit->fetch_array()){?>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    
                                    <div class="col-lg-4">
                                        <div class="card card-bordered card-full">
                                            <div class="card-inner border-bottom">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h6 class="title">Recent Activities</h6>
                                                    </div>
                                                    <!--<div class="card-tools">
                                                        <ul class="card-tools-nav">
                                                            <li><a href="#"><span>Cancel</span></a></li>
                                                            <li class="active"><a href="#"><span>All</span></a></li>
                                                        </ul>
                                                    </div>-->
                                                </div>
                                            </div>
                                            <ul class="nk-activity">
                                            	<?php
                                                $sql_event = "SELECT * FROM md_transaction_event WHERE account_id!='0' ORDER BY tr_credate DESC LIMIT 6";
												$query_event=$mysqli->query($sql_event) or die("Error sql_event: เกิดความผิดพลาด <br>$sql_event");
												$index_event=1;
												while($row_event=$query_event->fetch_array()){
													
												$bgcolor=array("bg-dim-primary","bg-success","bg-info","bg-danger","bg-purple","bg-dark","bg-warning");
												$sql_account = "SELECT * FROM md_account WHERE account_id='".$row_event["account_id"]."'";
												$query_account=$mysqli->query($sql_account) or die("Error sql_account: เกิดความผิดพลาด <br>$sql_account");
												$row_account=$query_account->fetch_array();
												?>
                                                <li class="nk-activity-item">
                                                    <div class="nk-activity-media user-avatar bg-<?php echo $bgcolor?>">
                                                    <?php if($row_account["account_photo"]!=""){?>
                                                      <img src="../../uploads/account/<?php echo $row_account["account_photo"];?>" alt="">
                                                    <?php }else{?>
                                                      <span><?php echo substr($row_account["account_fname"],0,1).substr($row_account["account_lname"],0,1);?></span>
                                                     <?php }?>
                                                    </div>
                                                    <div class="nk-activity-data">
                                                        <div class="label"><?php echo $row_event['tr_desc'];?></div>
                                                        <span class="time"><?php echo $row_event['tr_credate'];?></span>
                                                    </div>
                                                </li>
                                                <?php $index_event++;}?>
                                            </ul>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
                                    
                                  
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->

    <!-- JavaScript -->
    <script src="../../assets/js/bundle.js?ver=2.2.0"></script>
    <script src="../../assets/js/scripts.js?ver=2.2.0"></script>
    <script src="../../assets/js/charts/gd-invest.js?ver=2.2.0"></script>
    <script src="../../assets/js/charts/gd-default.js?ver=2.2.0"></script>
    <script type="text/javascript">
	
	var totalDeposit1 = {
    labels: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan"],
    dataUnit: 'USD',
    stacked: true,
    datasets: [{
      label: "Active User",
      color: [NioApp.hexRGB("#6576ff", .2), NioApp.hexRGB("#6576ff", .2), NioApp.hexRGB("#6576ff", .2), NioApp.hexRGB("#6576ff", .2), NioApp.hexRGB("#6576ff", .2), NioApp.hexRGB("#6576ff", .2), "#6576ff"],
      data: [7200, 8200, 7800, 9500, 5500, 9200, 9690]
    }]
  };
  var totalWithdraw1 = {
    labels: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan"],
    dataUnit: 'USD',
    stacked: true,
    datasets: [{
      label: "Active User",
      color: [NioApp.hexRGB("#816bff", .2), NioApp.hexRGB("#816bff", .2), NioApp.hexRGB("#816bff", .2), NioApp.hexRGB("#816bff", .2), NioApp.hexRGB("#816bff", .2), NioApp.hexRGB("#816bff", .2), "#816bff"],
      data: [7200, 8200, 7800, 9500, 5500, 9200, 9690]
    }]
  };
  var totalBalance1 = {
    labels: ["01 Jan", "02 Jan", "03 Jan", "04 Jan", "05 Jan", "06 Jan", "07 Jan"],
    dataUnit: 'USD',
    stacked: true,
    datasets: [{
      label: "Active User",
      color: [NioApp.hexRGB("#559bfb", .2), NioApp.hexRGB("#559bfb", .2), NioApp.hexRGB("#559bfb", .2), NioApp.hexRGB("#559bfb", .2), NioApp.hexRGB("#559bfb", .2), NioApp.hexRGB("#559bfb", .2), "#559bfb"],
      data: [6000, 8200, 7800, 9500, 5500, 9200, 9690]
    }]
  };
  
	var coinOverview1 = {
    labels: ["EURUSDc", "EURUSDc", "GBPAUDc", "USDCADc", "AUDUSDc", "AUDJPYc", "CADJPYc", "NZDUSDc"],
    stacked: true,
    datasets: [{
      label: "Buy Orders",
      color: ["#f98c45", "#9cabff", "#8feac5", "#6b79c8", "#79f1dc", "#79f1dc", "#79f1dc", "#79f1dc"],
      data: [1750, 2500, 1820, 1200, 1600, 2500, 2500, 2500]
    }, {
      label: "Sell Orders",
      color: [NioApp.hexRGB('#f98c45', .2), NioApp.hexRGB('#9cabff', .4), NioApp.hexRGB('#8feac5', .4), NioApp.hexRGB('#6b79c8', .4), NioApp.hexRGB('#79f1dc', .4), NioApp.hexRGB('#79f1dc', .4), NioApp.hexRGB('#79f1dc', .4), NioApp.hexRGB('#79f1dc', .4)],
      data: [2420, 1820, 3000, 5000, 2450, 1820, 2500, 2500]
    }]
  };
	</script>