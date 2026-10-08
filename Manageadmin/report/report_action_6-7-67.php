<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");
	
if($_SESSION['core_session_sys_language']=="thai"){
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../libs/language_eng.php");
}
$txt_mod["billing:color"] = array('','success','danger','warning');
$txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก','รอดำเนินการ');
?>


<?php if($_POST["myaction"]=="datalist"){?>
    <script type="text/javascript">
        function fnsearch() {
            document.myForm.input_startdate.value =document.getElementById('input_startdate').value;
            document.myForm.input_enddate.value =document.getElementById('input_enddate').value;
            modLoadContent();
                
        }
        function submitpagelist(name,value) {
            if(name=="prev"){
                document.myForm.module_pageshow.value--;
            }else if(name=="next"){
                if(document.myForm.module_pageshow.value==""){document.myForm.module_pageshow.value=1;};
                document.myForm.module_pageshow.value++;
                
            }else if(name=="number"){
                document.myForm.module_pageshow.value=value;	  
            }else if(name=="size"){
                document.myForm.module_pagesize.value=value;	
            }else if(name=="catalog"){
                document.myForm.input_catalog.value=value;
            }else if(name=="startdate"){
                document.myForm.input_startdate.value=value;
            }else if(name=="enddate"){
                document.myForm.input_enddate.value=value;	   
            }else{
                document.myForm.InputSearchName.value=value;
                document.getElementById('InputSearch').value=value;
            }
            
            modLoadContent();  
        }
    </script>

    <form action="" method="post" name="myForm" id="myForm">
    <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
    <input name="myaction" type="hidden" id="myaction" value="" />
    <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
    <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
    <input name="myContantID" type="hidden" id="myContantID" value="" /> 
    <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
    <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
    <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
    <input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
    <input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
    <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" /> 
          
    <input name="row_id" type="hidden" id="row_id" value="<?php echo $_REQUEST["row_id"]?>" />
    <input name="customer_id" type="hidden" id="customer_id" value="<?php echo $_REQUEST["customer_id"]?>" />
    <?php

    $chk_permissionID = getUserPermissionOnMenu($_SESSION["front_session_sys_grpid"],$_REQUEST['menukeyid']);
	
	// Check to set default value #########################
	$module_default_pagesize = 10;
	$module_default_pageshow = 1;
	$module_sort_number = "DESC";
	
	$module_pagesize = $_REQUEST["module_pagesize"];
	$module_pageshow = $_REQUEST["module_pageshow"];
	$module_adesc = $_REQUEST["module_adesc"];
	$module_orderby = $_REQUEST["module_orderby"];
	$InputSearch=trim($_REQUEST["InputSearch"]);
	
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = "md_billing_id"; }
	if($InputSearch!=""){ $InputSearch=trim($InputSearch); }
	
	// SQL SELECT #########################
    // md_billing_status='1'
    $sql = "SELECT * FROM md_billing WHERE md_billing_status=1 ";
    if($_REQUEST["InputSearch"]!=""){
        $sql .= " AND (md_billing_number LIKE '%".$_REQUEST["InputSearch"]."%')";
    }
    if($_REQUEST["input_startdate"]!="" && $_REQUEST["input_enddate"]!=""){
        $sql .= " AND md_billing_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["input_startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["input_enddate"])." 23:59:59'";
    }
    // echo "<br>".$sql;
    $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
    $count_totalrecord=$query->num_rows;
    // Find max page size #########################
    if($count_totalrecord>$module_pagesize) {
        $numberofpage= ceil($count_totalrecord/$module_pagesize);
    } else {
        $numberofpage=1;
    }

    // Recover page show into range #########################
    if($module_pageshow>$numberofpage) { $module_pageshow=$numberofpage; }

    // Select only paging range #########################
	$recordstart = ($module_pageshow-1)*$module_pagesize;
	$sql .= " ORDER BY $module_orderby $module_adesc LIMIT $recordstart , $module_pagesize ";

	$query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
	$count_record=$query->num_rows;
    ?>
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head nk-block-head-sm">
            <div class="nk-block-between g-3">
                <div class="nk-block-head-content">
                    <h3 class="nk-block-title page-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h3>
                    <div class="nk-block-des text-soft">
                    <p>You have total <?php echo $count_record;?> record.</p>
                    </div>
                </div><!-- .nk-block-head-content -->
           
            </div><!-- .nk-block-between -->
        </div><!-- .nk-block-head -->
    
        <!-- Modal Form -->
        <div  class="modal fade" aria-hidden="true" id="loadcreatebill" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ออกใบเสร็จ</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div id="loadmodalcreatebill"></div>
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- Modal Form -->
        <div class="modal fade show"   id="loadmodalview">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">รายละเอียด</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div id="loadmodalcontent"></div>
                    </div>
                </div>
            </div>
        </div>                           
        <!-- .modal -->
        <!-- Modal Form -->
        <div class="modal fade show"   id="viewbillload">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">รายงานบิลซื้อ</h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <em class="icon ni ni-cross"></em>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div id="loadcontentview"></div>
                    </div>
                </div>
            </div>
        </div>                           
        <!-- .modal -->
        <div class="nk-block nk-block-lg">
            <div class="card card-preview">
                <div class="card-inner">
                    <!-- <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row justify-between g-2">
                            <div class="col-7 col-sm-6 text-left">
                                <div id="InputSearch" class="dataTables_filter">
                                <label>
                                    <input type="search" class="form-control form-control-sm" placeholder="Type in to Search" aria-controls="InputSearch" id="InputSearch" name="InputSearch" value="<?php echo $InputSearch?>" onchange="submitpagelist('search',this.value);">
                                </label>
                                </div>
                            </div>
                            
                            <div id="module_pagesize" class="dataTables_length">
                                <label>
                                    <span class="d-none d-sm-inline-block">Show</span>
                                    <div class="form-control-select"> 
                                        <select name="module_pagesize" id="module_pagesize" aria-controls="module_pagesize" class="custom-select custom-select-sm form-control form-control-sm" onchange="submitpagelist('size',this.value);">
                                            <option value="10" <?php echo ($module_pagesize==10)?"selected":""?>>10</option>
                                            <option value="25" <?php echo ($module_pagesize==25)?"selected":""?>>25</option>
                                            <option value="50" <?php echo ($module_pagesize==50)?"selected":""?>>50</option>
                                            <option value="100" <?php echo ($module_pagesize==100)?"selected":""?>>100</option>
                                        </select> 
                                    </div>
                                </label>
                            </div>
                            
                        </div> 
                    <div class="datatable-wrap my-3"> -->

                    <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="row justify-between g-2">
                            <div class="">
                                <input type="search" class="form-control form-control-sm" placeholder="ค้นหา" name="InputSearch" id="InputSearch" value="<?php echo $InputSearch?>" onchange="submitpagelist('search',this.value);">
                            </div>
                            <div class="">
                            แสดง
                                <label>
                                    <div class="form-control-select"> 
                                        <select name="module_pagesize" id="module_pagesize" onchange="submitpagelist('size',this.value);" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="10" <?php echo ($module_pagesize==10)?"selected":""?>>10</option>
                                        <option value="25" <?php echo ($module_pagesize==25)?"selected":""?>>25</option>
                                        <option value="50" <?php echo ($module_pagesize==50)?"selected":""?>>50</option>
                                        <option value="100" <?php echo ($module_pagesize==100)?"selected":""?>>100</option>
                                        </select>
                                        </div>
                                    </label>
                                    รายการ
                            </div>
                            <div class="">
                                <label>
                                    <div class="form-control-select"> 
                                    <select name="input_catalog" id="input_catalog" class="custom-select custom-select-sm form-control form-control-sm" onchange="submitpagelist('catalog',this.value);">
                                            <option value="">เลือกประเภทสินค้า</option>
                                        <?php
                                            $sql_branch = "SELECT * FROM md_catalog WHERE md_catalog_status='1'";
                                            $Query_branch=$mysqli->query($sql_branch) OR DIE("Error sql_branch: <br>$sql_branch<br>\n");
                                            while($Row_branch=$Query_branch->fetch_array()){
                                            $Row_branch_id=$Row_branch['md_catalog_id'];
                                            $Row_branch_name=$Row_branch['md_catalog_name'];									
                                        ?>
                                        <option value="<?php echo $Row_branch_id?>" <?php echo ($Row_branch["md_catalog_id"]==$_REQUEST["input_catalog"])?"selected":""?>><?php echo $Row_branch_name?></option>
                                        <?php }?>
                                    </select>
                                    </div>
                                    </label>
                            </div> 
                            <div class="">
                                    <div class="form-group">      
                                    <div class="form-control-wrap">        
                                        <div class="input-daterange date-picker-range input-group">
                                            <input type="text" id="input_startdate" name="input_startdate" class="form-control form-control-sm" value="<?php echo $_REQUEST["input_startdate"];?>" onchange="submitpagelist('startdate',this.value);" />            
                                            <div class="input-group-addon">TO</div>            
                                            <input type="text" id="input_enddate" name="input_enddate" class="form-control form-control-sm" value="<?php echo $_REQUEST["input_enddate"];?>" onchange="submitpagelist('enddate',this.value);" />        
                                        </div> 
                                            
                                    </div>
                                    </div>
                            </div>
                            <div class="">
                                <!-- <a href="export_excel_report.php?startdate=<?php echo $_REQUEST["input_startdate"]?>&&enddate=<?php echo $_REQUEST["input_enddate"];?>&&catalog=<?php echo $_REQUEST["input_catalog"]?>" target="_blank" class="btn btn-sm btn-outline-success"><em class="icon ni ni-printer"></em><span>ออกรายงาน</span></a> -->

                                <a href="javascript:void(0)" class="btn btn-sm btn-outline-success" onclick="Viewbill();"><em class="icon ni ni-printer"></em><span>ออกรายงาน</span></a>&nbsp;

                                <a href="javascript:void(0)" onclick="fnsearch();" class="btn btn-sm btn-primary"><em class="icon ni ni-search"></em><span>ค้นหา</span></a> 
                                
                            </div>
                            
                        </div><!-- .row justify-between g-2 -->
                    <div class="datatable-wrap my-3">
                        
                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head">
                                <th class="nk-tb-col nk-tb-col-check">
                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                        <input type="checkbox" name="CheckBoxAll" id="CheckBoxAll" class="custom-control-input" onclick="Paging_CheckAll(this,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" />
                                        <label class="custom-control-label" for="CheckBoxAll"></label>
                                    </div>
                                </th>
                                <th class="nk-tb-col"><span class="sub-text">รหัสใบเสร็จ</span></th>
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">ชื่อลูกค้า</span></th>
                                <th class="nk-tb-col"><span class="sub-text">จำนวนเงิน</span></th>
                                <th class="nk-tb-col"><span class="sub-text">การชำระเงิน</span></th>
                                <!--<th class="nk-tb-col"><span class="sub-text">vat</span></th>-->
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">วันที่</span></th>
                                
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">หมายเหตุ</span></th> 
                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">เจ้าหน้าที่</span></th> 
                                
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    $index=1;
                    $color=0;
                    $per=0;
                    if($count_record>0) {
                    while($index<$count_record+1) {
                        $row=$query->fetch_array();
                        $row_id=		$row["md_billing_id"];
                        $customer_id=	$row["md_billing_customerid"];
                        $row_name=		rechangeQuot($row["md_billing_fname"])." ".rechangeQuot($row["md_billing_lname"]);
                        $row_status=	$row["md_billing_status"];
                        
                        $vatetype = $row['md_billing_vattype'];
                        if($vatetype==1){  //ใน
                            $total2=$row['md_billing_total'];
                        }elseif($vatetype==2){ //นอก
                            $total2=$row['md_billing_totalprice'];
                        }else{ //ไม่คิด
                            $total2=$row['md_billing_total'];
                        }
						
						$total2=$total2+$row['md_billing_carcost'];

                        $sql_customer = "SELECT * FROM md_customer WHERE md_customer_id='".$row["md_billing_customerid"]."'";
                        $query_customer=$mysqli->query($sql_customer) or die("Error sql_customer: เกิดความผิดพลาด <br>$sql_customer\n"); 
                        $row_customer=$query_customer->fetch_array();

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
                    ?>    
                                <tr class="nk-tb-item">
                                    <td class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" name="CheckBoxID<?php echo $index?>" id="CheckBoxID<?php echo $index?>" class="custom-control-input" onclick="Paging_CheckAllHandle(document.myForm.CheckBoxAll,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" value="<?php echo $row_id?>"/>
                                            <label class="custom-control-label" for="CheckBoxID<?php echo $index?>"></label>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="nk-tnx-type">
                                            <div class="nk-tnx-type-text">
                                                <span class="tb-lead"><?php echo $row["md_billing_number"];?></span>
                                            </div>
                                    </div>
                                    </td>
                                    <td class="nk-tb-col tb-col-lg">
                                        <span class="tb-lead "><?php echo $row_customer['md_customer_name']." (".$carcode.")"?></span>
                                        <!-- <input type="hidden" id="customerID" name="customerID" value="<?php echo $row_customer['md_customer_id'] ?>"> -->
                                    </td>
                                    
                                    <td class="nk-tb-col"> 
                                        <span><?php echo number_format($total2,2);?></span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md" id="load_paystatus<?php echo $row_id?>">
                                        <span class='badge badge-dim badge-outline-<?php echo $paytyp_color;?> d-none d-md-inline-flex'><?php echo $paytyp_status;?></span>
                                    </td>

                                    <!--<td class="nk-tb-col tb-col-md" id="load_paystatusvat<?php echo $row_id?>">
                                        <span class='tb-sub text-<?php echo $paytvat_color;?>'><?php echo $paytvat_status;?></span>
                                    </td>-->

                                    <td class="nk-tb-col tb-col-md">
                                        <span><?php echo ShowDateTimeThai($row["md_billing_credate"]);?></span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md" id="load_status<?php echo $row_id?>">
                                    <span class='badge badge-dim badge-outline-<?php echo $txt_mod["billing:color"][$row["md_billing_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["billing:status"][$row["md_billing_status"]];?></span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        <span><?php echo $row["md_billing_cancel_detail"];?></span>
                                    </td>
                                    <td class="nk-tb-col tb-col-md">
                                        <span><?php echo getStaffName($row["md_billing_crebyid"]);?></span>
                                    </td>
                                    
                                    
                                </tr><!-- .nk-tb-item  --> 

                    <?php $index++;$color++; 
                            }//while($row=$query->fetch_array()){
                    }//if($count_record>0) {?>
                        </tbody>
                    </table>
                    </div><!-- .datatable-wrap my-3  -->

                    <?php
                    $minpage = $module_pageshow-2;
                    $maxpage = $module_pageshow+2;
                    if($minpage<1) { $minpage=1; }
                    if($maxpage>$numberofpage) { $maxpage=$numberofpage; }
                    if($maxpage<5) { $maxpage=5; }
                    if($maxpage-$minpage<=3) { $minpage=$maxpage-4; }
                    if($numberofpage<5) { $maxpage=$numberofpage; }
                    ?>
                        
                        <div class="row align-items-center">
                            <?php //if($numberofpage>1){?> 
                            <div class="col-7 col-sm-12 col-md-9">
                                <nav>    
                                    <ul class="pagination">        
                                        <li class="page-item <?php if($module_pageshow==1){echo "disabled";}?> "><a class="page-link"  href="javascript:void(0)" <?php if($module_pageshow!=1){?> onclick="submitpagelist('prev','');"<?php }?> tabindex="-1" aria-disabled="true">Prev</a></li>        											<?php for($i=$minpage;$i<=$maxpage;$i++){?>     
                                        <li class="page-item <?php if($i==$module_pageshow){?> active <?php }?>" aria-current="page"><a class="page-link" href="javascript:void(0)" onclick="submitpagelist('number','<?php echo $i?>');"><?php echo $i;?> <span class="sr-only">(current)</span></a></li>        
                                        <?php }?>      
                                        <li class="page-item <?php if($maxpage==$module_pageshow){echo "disabled";};?>"><a class="page-link" href="javascript:void(0)" <?php if($maxpage!=$module_pageshow){?> onclick="submitpagelist('next','');"<?php }?>>Next</a></li>    
                                    </ul>
                                </nav>
                            </div><!-- .col-7 col-sm-12 col-md-9 -->
                            <?php //}?>
                            <div class="col-5 col-sm-12 col-md-3 text-left text-md-right">
                                <div class="dataTables_info" role="status" aria-live="polite"><?php echo $txt_language["system:All"]." ".$count_totalrecord." ".$txt_language["system:record"]?></div>
                            </div>
                        </div><!-- .row align-items-center -->
                    
                    </div><!-- .dataTables_wrapper -->
                    </div>
                </div><!-- .card-preview -->
                </div><!-- .nk-block-head-content -->                  
        </div><!-- .nk-block -->
        <input name="TotalCheckBoxID" type="hidden" id="TotalCheckBoxID" value="<?php echo $index-1?>" />
    </form>
    <script type="text/javascript">
    $('.input-daterange').datepicker({
        format: 'dd/mm/yyyy'
    });
    </script>
    
<?php }elseif($_POST["myaction"]=="addnew"){?> 

            <form action="" method="post" name="myForm" id="myForm" onsubmit="return(false);">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <input name="productid" type="hidden" id="productid" value="<?php echo $_REQUEST["productid"]?>" />

            <input name="InputSearch_p" type="hidden" id="InputSearch_p" value="<?php echo $_REQUEST["InputSearch_p"]?>" />
            <input name="input_catalog" type="hidden" id="input_catalog" value="<?php echo $_REQUEST["input_catalog"]?>" />
            <input name="product_waletstock" type="hidden" id="product_waletstock" value="<?php echo $_REQUEST["product_waletstock"]?>" />

            <input name="row_id" type="hidden" id="row_id" value="<?php echo $_REQUEST["row_id"]?>" />
            <input name="myRadio" type="hidden" id="myRadio" value="<?php echo $_REQUEST["myRadio"]?>" />
            <input name="customer_id" type="hidden" id="customer_id" value="<?php echo $_REQUEST["customer_id"]?>" />

            <!-- <input type="hidden" id="customerID" name="customerID" value="<?php echo $row_customer['customer_id_createb'] ?>"> -->
            <!-- Modal Form -->
            <div class="modal fade" id="loadmodal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" id="loadmodalcontent">
                        
                    </div>
                </div>
            </div>
         				
            <!-- Modal Form -->
            <div  class="modal fade" aria-hidden="true" id="modvatload" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ออกใบเสร็จ</h5>
                            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                <em class="icon ni ni-cross"></em>
                            </a>
                        </div>
                        <div class="modal-body">
                            <div id="loadvatview"></div>
                        </div>
                    </div>
                </div>
            </div>       
                                
            <div class="nk-block nk-block-lg">
                
                <div class="nk-block-between g-3">
                        <div class="nk-block-head-content">
                                <h4 class="nk-block-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h4>
                                <br />
                        </div>
                        <div class="nk-block-head-content">
                            <!-- <a href="javascript:void(0)" class="btn btn-primary" onclick="document.myForm.myContantID.value ='';modLoadSelectProduct();"><em class="icon ni ni-plus"></em><span>เพิ่มสินค้า</span></a>&nbsp; -->
                            <!-- <a href="javascript:void(0)" class="btn btn-success" onclick="document.myForm.myContantID.value ='';modInsertContent();"><em class="icon ni ni-printer"></em><span>ออกใบเสร็จ</span></a>&nbsp; -->
                            <a href="javascript:void(0)" class="btn btn-warning" onclick="modLoadContent();"><em class="icon ni ni-arrow-long-left"></em><span><?php echo $txt_language["but:back"]?></span></a>
                        </div>
                    </div>
                </div><!-- .nk-block-head -->
                <style>
                    .redtext {
                        color: red;
                    }
                </style>
                <div class="card card-bordered">
                    <div class="card-inner">
                        
                        <?php
                            $sql_cc = "SELECT * FROM md_billing WHERE md_billing_id='".$_REQUEST["row_id"]."'";
                            $query_cc=$mysqli->query($sql_cc) or die("Error sql_cc: เกิดความผิดพลาด <br>$sql_cc\n");
                            $row_cc=$query_cc->fetch_array();
                            
                            $sql_resive = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1'";
                            $query_resive=$mysqli->query($sql_resive) or die("Error sql_resive: เกิดความผิดพลาด <br>$sql_resive\n");
                            $count_record_resive=$query_resive->num_rows;
                        ?>

                        <div class="form-group" style="display: inline-block;">
                            <div class="form-control-wrap col-12" style="display: inline-block;">
                                <label class="form-label">ชื่อลูกค้า</label> 
                                <select class="form-select form-control form-control-md formsss_r " data-search="on" id="customer_resive"  name="customer_resive" >
                                    <option value="0">กรุณาเลือกลูกค้า</option>
                                    <?php 
                                        while($row_resive=$query_resive->fetch_array()) { 
                                            $row_id=		$row_resive["md_customer_id"];
                                            $row_name=		rechangeQuot($row_resive["md_customer_name"])." (".$row_resive["md_customer_code"].")";
                                            $row_status=	$row_resive["md_customer_status"];  ?>    

                                            <option value="<?php echo $row_id ?>" <?php if($_REQUEST['customer_id']==$row_id){echo "selected";} ?>><?php echo $row_name ?></option>
                
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 
                         
                        <?php if($_REQUEST["customer_id"]==1){ ?>
                            <div class="form-group" style="display: inline-block;">
                                <div class="form-control-wrap col-12" style="display: inline-block;">
                                    <label class="form-label">ทะเบียนรถ</label> 
                                    <input type="text" class="form-control" id="car_code"  name="car_code" placeholder="ทะเบียนรถ" value="<?php echo $row_cc['md_billing_carcode'] ?>"> 
                                </div>
                            </div>
                        <?php } ?>
                        <hr>


                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" name="CheckBoxAll" id="CheckBoxAll" class="custom-control-input" onclick="Paging_CheckAll(this,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" />
                                            <label class="custom-control-label" for="CheckBoxAll"></label>
                                        </div>
                                    </th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">รหัสสินค้า</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">ชื่อสินค้า</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">ราคาต่อหน่วย</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">น้ำหนัก</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">ราคารวม</span></th>
                                    <!-- <th class="nk-tb-col tb-col-lg"><span class="sub-text">ชื่อลูกค้า</span></th> -->
                                    <th class="nk-tb-col tb-col-lg"></th>
                                </tr>
                            </thead>
                        <tbody> 
                    <?php
                    $index=1;
                    $color=0;
                    $sql = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' ";
                    if($_POST['row_id']!=''){
                        $sql .= " AND md_order_billID='".$_POST['row_id']."'";
                    }else{
                        $sql .= " AND md_order_billID='0'";
                    }
                    $sql .= " ORDER BY md_order_id ASC";
                    // echo "dd: ".$sql."<br>";
                    $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
                    $count_totalrecord=$query->num_rows;
                    while($row=$query->fetch_array()) {
                        
                        $row_id=		$row["md_order_id"];
                        $row_name=		rechangeQuot($row["md_order_name"]);
                        $row_status=	$row["md_order_status"];
                        $total=$total+$row["md_order_total"];
                        $total_amount=$total_amount+$row["md_order_amount"];

                        $sql_customer = "SELECT * FROM md_customer WHERE md_customer_id='".$row["md_order_customerid"]."'";
                        $query_customer=$mysqli->query($sql_customer) or die("Error sql_customer: เกิดความผิดพลาด <br>$sql_customer\n"); 
                        $row_customer=$query_customer->fetch_array();
                        

                        if($row["md_order_status_same"]==1){
                            $redtext = "style='color: red;'";
                        }else{
                            $redtext = "";
                            if($row["md_order_billdetail_status"]==0){
                                $redtext = "style='color: orange;'";
                            }else{
                                $redtext = "";
                            } 
                        } 
                        
                        ?>    
                        <input type="hidden"  id="order_id[]" name="order_id[]" value="<?php echo  $row_id ?>"> 
                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" name="CheckBoxID<?php echo $index?>" id="CheckBoxID<?php echo $index?>" class="custom-control-input" onclick="Paging_CheckAllHandle(document.myForm.CheckBoxAll,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" value="<?php echo $row_id?>"/>
                                    <label class="custom-control-label" for="CheckBoxID<?php echo $index?>"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-lg " >
                                <div class="nk-tnx-type">
                                    <div class="nk-tnx-type-text" >
                                        <span class="tb-lead " <?php echo $redtext ?>><?php echo getProductCode($row["md_order_productid"]);?></span>
                                        <!-- <span class="tb-date " <?php echo $redtext ?>><?php echo ShowDateTimeThai($row["md_order_credate"]);?></span> -->
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-lg " >
                                <div class="nk-tnx-type">
                                    <div class="nk-tnx-type-text" >
                                        <span class="tb-lead " <?php echo $redtext ?>><?php echo getProductName($row["md_order_productid"]);?></span>
                                        <input type="text" class="form-control" id="product_reason_cr[<?php echo  $row_id ?>]"  name="product_reason_cr[<?php echo  $row_id ?>]" placeholder="หมายเหตุ" style="margin-top: 10px;" onkeyup="callreason(<?php echo  $row_id ?>,this.even);" value="<?php echo  $row["md_order_reason"] ?>"> 
                                        <!-- <span class="tb-date " <?php echo $redtext ?>><?php echo ShowDateTimeThai($row["md_order_credate"]);?></span> -->
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <!-- <span class="tb-lead " <?php echo $redtext ?>><?php echo number_format($row["md_order_price"],2);?></span> -->
                                <input type="number" class="form-control" id="product_price_cr[<?php echo  $row_id ?>]"  name="product_price_cr[<?php echo  $row_id ?>]" placeholder="ราคาขาย" onkeyup="callreason(<?php echo  $row_id ?>,this.even);" value="<?php echo number_format($row["md_order_price"],2);?>" > 
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <?php if($row["md_order_amount"]>0){ ?>
                                    <span class="tb-lead " <?php echo $redtext ?>><?php echo number_format($row["md_order_amount"],2);?></span>
                                    <input type="hidden"  id="product_weight_cr[<?php echo  $row_id ?>]"  name="product_weight_cr[<?php echo  $row_id ?>]" value="<?php echo number_format($row["md_order_amount"],2) ?>">
                                <?php }else{ ?>
                                    <input type="number" class="form-control" id="product_weight_cr[<?php echo  $row_id ?>]"  name="product_weight_cr[<?php echo  $row_id ?>]" placeholder="น้ำหนัก" onkeyup="callreason(<?php echo  $row_id ?>,this.even);"  value="<?php if($row["md_order_amount"]!=0){ echo number_format($row["md_order_amount"],2);}else{echo null;}?>"> 
                                <?php } ?>
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <span class="tb-lead " <?php echo $redtext ?> id="product_total_cr[<?php echo  $row_id ?>]"><?php echo number_format($row["md_order_total"],2);?></span>
                            </td> 
                            <td class="nk-tb-col nk-tb-col-tools">
                                <ul class="nk-tb-actions gx-2">
                                    <?php if($chk_permissionID="RW"){?> 
                                        <li class="nk-tb-action-hidden" id="buttom_approved<?php echo $row["wf_id"]?>">
                                            <a href="javascript:void(0)" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="ลบ" onclick="if(confirm('<?php echo $txt_language['system:popupdelele']?>')){Paging_CheckedThisItem( document.myForm.CheckBoxAll, <?php echo $index;?>, 'CheckBoxID', document.myForm.TotalCheckBoxID.value );modDeleteProduct();}"><em class="icon ni ni-trash-alt"></em></a>
                                        </li>
                                    <?php }?>
                                    
                                    <li>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt">
                                                    <?php if($chk_permissionID="RW"){?>
                                                        <li><a href="javascript:void(0)" onclick="if(confirm('<?php echo $txt_language['system:popupdelele']?>')){Paging_CheckedThisItem( document.myForm.CheckBoxAll, <?php echo $index;?>, 'CheckBoxID', document.myForm.TotalCheckBoxID.value );modDeleteProduct();}"><em class="icon ni ni-trash-alt"></em><span>ลบ</span></a></li>
                                                    <?php }?> 
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
                            </td>
                        </tr><!-- .nk-tb-item  --> 

                            <?php $index++;$color++; 
                        }//while($row=$query->fetch_array()){
                        ?>

                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check">
                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                    <input type="checkbox" name="CheckBoxID<?php echo $index?>" id="CheckBoxID<?php echo $index?>" class="custom-control-input" onclick="Paging_CheckAllHandle(document.myForm.CheckBoxAll,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" value="<?php echo $row_id?>"/>
                                    <label class="custom-control-label" for="CheckBoxID<?php echo $index?>"></label>
                                </div>
                            </td>
                            <td class="nk-tb-col tb-col-lg"> 
                                <input type="text" class="form-control" id="product_code_cr" placeholder="รหัสสินค้า" onchange="loadproduct_id(document.getElementById('product_code_cr').value,<?php echo $_REQUEST['customer_id'] ?>,<?php echo $_REQUEST['row_id'] ?>)"> 
                            </td>
                            <td class="nk-tb-col tb-col-lg " >
                                <a href="javascript:void(0)" class="btn btn-primary" ><em class="icon ni ni-plus"></em><span>เพิ่มสินค้า</span></a>&nbsp;
                                <!-- <div class="nk-tnx-type">
                                    <div class="nk-tnx-type-text" >
                                        <input type="text" class="form-control" id="product_name_cr" placeholder="ชื่อสินค้า" readonly> 
                                    </div>
                                </div> -->
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <!-- <input type="text" class="form-control" id="product_pricr_cr" placeholder="ราคาต่อหน่วย" readonly>  -->
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <!-- <input type="text" class="form-control" id="product_weight_cr" placeholder="น้ำหนัก" >  -->
                            </td>
                            <td class="nk-tb-col tb-col-lg">
                                <!-- <input type="text" class="form-control" id="product_total_cr" placeholder="ราคารวม" readonly>  -->
                            </td>
                            <!-- <td class="nk-tb-col tb-col-lg">
                                <span class="tb-lead " <?php echo $redtext ?>><?php echo $row_customer['md_customer_name']." (".$row_customer['md_customer_code'].")"?></span>
                                <input type="hidden" id="customerID" name="customerID" value="<?php echo $row_customer['md_customer_id'] ?>">
                            </td> -->
                            <td class="nk-tb-col tb-col-lg"> 
                                <!-- <a href="javascript:void(0)" class="btn btn-primary" ><em class="icon ni ni-plus"></em><span>เพิ่มสินค้า</span></a>&nbsp; -->
                            </td>
                        </tr><!-- .nk-tb-item  --> 

                        <tr class="nk-tb-item">
                            <td class="nk-tb-col nk-tb-col-check"></td>
                            <td class="nk-tb-col tb-col-md"></td>
                            <td class="nk-tb-col tb-col-md"></td>
                            <td class="nk-tb-col">
                                <div class="nk-tnx-type">
                                    <div class="nk-tnx-type-text">
                                        <span class="tb-lead">ยอดรวมทั้งหมด</span> 
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="nk-tnx-type">
                                    <div class="nk-tnx-type-text">
                                        <span class="tb-lead"  id="sum_amount"><?php echo number_format($total_amount,2);?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="nk-tnx-type">
                                    <div class="nk-tnx-type-text">
                                        <span class="tb-lead" id="sum_pricetotal"><?php echo number_format($total,2);?></span>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="nk-tb-col nk-tb-col-tools"><div id="loadprice"></div></td>
                        </tr><!-- .nk-tb-item  --> 
                    </tbody>
                </table>
                <div align="right">
                    <?php if($_POST['row_id']==''){ ?><?php } ?>
                    <a href="javascript:void(0)" class="btn btn-primary" onclick="document.myForm.myContantID.value ='';modInsertbillcheck_2();"><em class="icon ni ni-check"></em><span>บันทึก</span></a>&nbsp;
                    <!-- modInsertContent(); -->
                    <a href="javascript:void(0)" class="btn btn-success" onclick="document.myForm.myContantID.value ='';viewvat();"><em class="icon ni ni-printer"></em><span>ออกใบเสร็จ</span></a>&nbsp;
                </div>
            </div>
        </div>
    </div><!-- .nk-block -->
    <input name="TotalCheckBoxID" type="hidden" id="TotalCheckBoxID" value="<?php echo $index-1?>" />

    </form>
    <script >  
        NioApp.Select2('.formsss_r');  
    </script> 
    <script> 
        function callreason(my_id,e) { 

            let textbox = document.getElementById("product_reason_cr["+my_id+"]");
            textbox.addEventListener("keypress", function onEvent(event) {
                if (event.key === "Enter") {
                    console.log(my_id);
                    updatereason_cr(document.getElementById('product_reason_cr['+my_id+']').value,'<?php echo $_REQUEST['customer_id'] ?>','<?php echo $_REQUEST['row_id'] ?>',my_id);
                }
            });
 
            let textpricr = document.getElementById("product_price_cr["+my_id+"]");
            textpricr.addEventListener("keypress", function onEvent(event) {
                if (event.key === "Enter") { 
                    updatepricr_cr(document.getElementById('product_price_cr['+my_id+']').value,'<?php echo $_REQUEST['customer_id'] ?>','<?php echo $_REQUEST['row_id'] ?>',my_id);
                }
            }); 
            
            let textweight = document.getElementById("product_weight_cr["+my_id+"]");
            textweight.addEventListener("keypress", function onEvent(event) {
                if (event.key === "Enter") { 
                    updateweight_cr(document.getElementById('product_weight_cr['+my_id+']').value,'<?php echo $_REQUEST['customer_id'] ?>','<?php echo $_REQUEST['row_id'] ?>',my_id);
                }
            }); 

        }
   </script>

<?php }elseif($_POST["myaction"]=="updatereason_cr"){ ?>
    <?php

    unset($array_Orde_id);
    $index=0;
    $sql = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' ";
    if($_POST['row_id']!=''){
        $sql .= " AND md_order_billID='".$_POST['row_id']."'";
    }else{
        $sql .= " AND md_order_billID='0'";
    }
    $sql .= " ORDER BY md_order_id ASC"; 
    $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");


    while($row=$query->fetch_array()) {
        array_push($array_Orde_id, $row['md_order_id']);
    }

    foreach($array_Orde_id as $key => $value){
        // echo "<br>".$value," ".$key;
        if($value==$_REQUEST['order_id']){
            $next_key=$key+1;
            break;
        }
    }
    // echo "<br>".
    $nextid=$array_Orde_id[$next_key];

    // print_r($_REQUEST);
    $sql_up = "UPDATE md_order_sell SET md_order_reason= '".$_REQUEST['my_value']."'  WHERE md_order_id='".$_REQUEST['order_id']."'";
    $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");

    $sql_up_d = "UPDATE md_billing_detail_sell SET md_billing_detail_reason= '".$_REQUEST['my_value']."'  WHERE md_billing_detail_orderid='".$_REQUEST['order_id']."'";
    $Query_up_d=$mysqli->query($sql_up_d)OR DIE("Error sql_up_d: <br>$sql_up_d<br>\n");

    echo json_encode(array("order_ID" => $_REQUEST['order_id'],"next_id" => $nextid,"status" => "success"));
    ?>


<?php }elseif($_POST["myaction"]=="updatepricr_cr"){ ?>
    <?php

    unset($array_Orde_id);
    $index=0;
    $sql = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' ";
    if($_POST['row_id']!=''){
        $sql .= " AND md_order_billID='".$_POST['row_id']."'";
    }else{
        $sql .= " AND md_order_billID='0'";
    }
    $sql .= " ORDER BY md_order_id ASC"; 
    $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");


    while($row=$query->fetch_array()) {
        array_push($array_Orde_id, $row['md_order_id']);
    }

    foreach($array_Orde_id as $key => $value){
        // echo "<br>".$value," ".$key;
        if($value==$_REQUEST['order_id']){
            $next_key=$key+1;
            break;
        }
    }
    // echo "<br>".
    $nextid=$array_Orde_id[$next_key];


    $sql_or = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' AND md_order_id='".$_REQUEST['order_id']."'"; 
    $query_or=$mysqli->query($sql_or) or die("Error sql_or: เกิดความผิดพลาด <br>$sql_or\n"); 
    $row_or=$query_or->fetch_array(); 
    $sumtotal = $_REQUEST['my_value']*$row_or['md_order_amount'];

    // print_r($_REQUEST);
    $sql_up = "UPDATE md_order_sell SET md_order_price= '".$_REQUEST['my_value']."', md_order_total= '".$sumtotal."'  WHERE md_order_id='".$_REQUEST['order_id']."'";
    $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");

    $sql_up_d = "UPDATE md_billing_detail_sell SET md_billing_detail_price= '".$_REQUEST['my_value']."',md_billing_detail_total='".$sumtotal."'  WHERE md_billing_detail_orderid='".$_REQUEST['order_id']."'";
    $Query_up_d=$mysqli->query($sql_up_d)OR DIE("Error sql_up_d: <br>$sql_up_d<br>\n");


    $sql_or_total = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' AND md_order_billID='".$_POST['row_id']."'"; 
    $query_or_total=$mysqli->query($sql_or_total) or die("Error sql_or_total: เกิดความผิดพลาด <br>$sql_or_total\n");
    while($row_or_total=$query_or_total->fetch_array()) {
        $amount_total += $row_or_total['md_order_amount'];
        $sumprice_total += $row_or_total['md_order_total']; 
    } 

    echo json_encode(array("order_ID" => $_REQUEST['order_id'],"next_id" => $nextid,"sumtotal" => $sumtotal,"amount_total"=> $amount_total,"sumprice_total" => $sumprice_total,"status" => "success"));
    ?>


<?php }elseif($_POST["myaction"]=="updateweight_cr"){ ?>
    <?php
    
    $sql_check = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_id='".$_REQUEST['order_id']."'";
    $query_check=$mysqli->query($sql_check) or die("Error sql_check: เกิดความผิดพลาด <br>$sql_check\n");
    $row_check=$query_check->fetch_array();
    $PrevWalletStock_ck = getBalanceWalletStock($row_check['md_order_productid']);
    $BalanceWalletStock_ck = $PrevWalletStock_ck-$_REQUEST['my_value'];
    if($BalanceWalletStock_ck>=0){
        unset($array_Orde_id);
        $index=0;
        $sql = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' ";
        if($_POST['row_id']!=''){
            $sql .= " AND md_order_billID='".$_POST['row_id']."'";
        }else{
            $sql .= " AND md_order_billID='0'";
        }
        $sql .= " ORDER BY md_order_id ASC"; 
        $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");


        while($row=$query->fetch_array()) {
            array_push($array_Orde_id, $row['md_order_id']);
        }

        foreach($array_Orde_id as $key => $value){
            // echo "<br>".$value," ".$key;
            if($value==$_REQUEST['order_id']){
                $next_key=$key+1;
                break;
            }
        }
        // echo "<br>".
        $nextid=$array_Orde_id[$next_key];

    
    
        $sql_or = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' AND md_order_id='".$_REQUEST['order_id']."'"; 
        $query_or=$mysqli->query($sql_or) or die("Error sql_or: เกิดความผิดพลาด <br>$sql_or\n");
        $query_or_stk=$mysqli->query($sql_or) or die("Error sql_or: เกิดความผิดพลาด <br>$sql_or\n");
        $row_or=$query_or->fetch_array(); 
        $sumtotal = $row_or['md_order_price']*$_REQUEST['my_value'];
    
        while($row_or_stk=$query_or_stk->fetch_array()) { 
            // ==============================
            if($row_or_stk['md_order_amount']==0){
                $sql_billing = "SELECT * FROM md_billing WHERE md_billing_id='".$_REQUEST['row_id']."'";
                $Query_billing=$mysqli->query($sql_billing);
                $Row_billing=$Query_billing->fetch_array();
                $product_amount=$_REQUEST['my_value'];

                $code='SD-'.strtotime(date('YmdHis')); //ขายสินค้า
                $md_deposit_amount="ขายสินค้า billing_number: ".$Row_billing['md_billing_number'];
                $PrevWalletStock = getBalanceWalletStock($row_or_stk['md_order_productid']);
                $BalanceWalletStock = $PrevWalletStock-$product_amount;
                

                unset($insert);
                $insert["md_stock_code"] = "'".$code."'"; 
                $insert["md_stock_product_id"] = "'".$row_or_stk['md_order_productid']."'";
                $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
                $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; //  
                $insert["md_stock_price"] = "'".$row_or_stk['md_order_price']."'";
                $insert["md_stock_deposit"] = "'0'";
                $insert["md_stock_withdrawal"] = "'".$product_amount."'";
                $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
                $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
                $insert["md_stock_group"] = "'WF'";			 
                $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
                $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'";
                // echo	"sql_insert=".
                $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
            } 
        }


        // print_r($_REQUEST);
        $sql_up = "UPDATE md_order_sell SET md_order_amount= '".$_REQUEST['my_value']."', md_order_total='".$sumtotal."'  WHERE md_order_id='".$_REQUEST['order_id']."'";
        $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");

        $sql_up_d = "UPDATE md_billing_detail SET md_billing_detail_amount= '".$_REQUEST['my_value']."', md_billing_detail_total='".$sumtotal."'  WHERE md_billing_detail_orderid='".$_REQUEST['order_id']."'";
        $Query_up_d=$mysqli->query($sql_up_d)OR DIE("Error sql_up_d: <br>$sql_up_d<br>\n");

        $sql_or_total = "SELECT * FROM md_order_sell WHERE  md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_customerid='".$_REQUEST["customer_id"]."' AND md_order_billID='".$_POST['row_id']."'"; 
        $query_or_total=$mysqli->query($sql_or_total) or die("Error sql_or_total: เกิดความผิดพลาด <br>$sql_or_total\n");
        while($row_or_total=$query_or_total->fetch_array()) {
            $amount_total += $row_or_total['md_order_amount'];
            $sumprice_total += $row_or_total['md_order_total']; 
        } 

        echo json_encode(array("order_ID" => $_REQUEST['order_id'],"next_id" => $nextid,"sumtotal" => $sumtotal,"amount_total"=> $amount_total,"sumprice_total" => $sumprice_total,"status" => "success"));
        exit;
    }else{
        echo json_encode(array("order_ID" => $_REQUEST['order_id'],"next_id" => $nextid,"status" => "error"));
        exit;
    }


    ?>

<?php }elseif($_POST["myaction"]=="loadproduct_id"){?>
    <?php
        
        $sql_custumer = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1' AND md_customer_id='".$_REQUEST['c_id']."'";
        $query_custumer=$mysqli->query($sql_custumer) or die("Error sql_custumer: เกิดความผิดพลาด <br>$sql_custumer\n");
        $row_custumer=$query_custumer->fetch_array();
 
        $sql = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_code ='".$_POST["p_code"]."'";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $count_record=$query->num_rows;
        $Row=$query->fetch_array();
        // echo "<br><br>";
        // print_r($row_custumer);
        // echo "<br><br>";
        // print_r($Row); 
        $priceproduct=$Row['md_product_sell'];
        if($count_record>0){
            echo json_encode(array("product_id" => $Row['md_product_id'],"customer_id" => $row_custumer['md_customer_id'],"priceproduct" => $priceproduct,"row_id" => $_REQUEST['row_id'],"status" => "success"));
        }else{
            echo json_encode(array("product_id" => $Row['md_product_id'],"customer_id" => $row_custumer['md_customer_id'],"priceproduct" => $priceproduct,"row_id" => $_REQUEST['row_id'],"status" => "error"));   
        }
    ?>

<?php }elseif($_POST["myaction"]=="checkweight"){?>
    <?php
         
        // $sql = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_id ='".$_POST["p_id"]."'";
        // $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        // $count_record=$query->num_rows;
        // $Row=$query->fetch_array(); 

        $balance_stock = getBalanceWalletStock($_POST["p_id"]);
        $BalanceWalletStock = $balance_stock-$_POST["weight"];

        if($BalanceWalletStock>=0){
            echo json_encode(array("product_id" => $_POST["p_id"],"row_id" => $_REQUEST['row_id'],"order_id" => $_REQUEST['order_id'],"balance_stock" => $balance_stock,"status" => "success"));
        }else{
            echo json_encode(array("product_id" => $_POST["p_id"],"row_id" => $_REQUEST['row_id'],"order_id" => $_REQUEST['order_id'],"balance_stock" => $balance_stock,"status" => "error"));
        }
    ?>

<?php }elseif($_POST["myaction"]=="modLoadcreatebill"){?>
	 
    <style>
        .tableFixHead          { overflow: auto; height: 600px; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .tableFixHead::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .tableFixHead {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        }
        /* Just common table stuff. Really. */
        table  { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 16px; } 
    </style>    
    <?php
        $sql = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1'";
        $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
	    $count_record=$query->num_rows;

    ?>
    <div class="modal-body ">
        <div class="form-group">
            <label class="form-label">ชื่อลูกค้า</label> 
            <div class="form-control-wrap">
                <select class="form-select form-control form-control-lg formsss " data-search="on" id="customer_id_IC"  name="customer_id_IC" onchange="modloadProduce(document.getElementById('customer_id_IC').value);">
                    <option value="0">กรุณาเลือกลูกค้า</option>
                    <?php 
                        while($row=$query->fetch_array()) { 
                            $row_id=		$row["md_customer_id"];
                            $row_name=		rechangeQuot($row["md_customer_name"])." (".$row["md_customer_code"].")";
                            $row_status=	$row["md_customer_status"];  ?>    

                            <option value="<?php echo $row_id ?>"><?php echo $row_name ?></option>
 
                    <?php } ?>
                </select>
            </div>
        </div>
        <hr>
        <a href="javascript:void(0)" class="btn btn-primary" style="float: right;" onclick="modLoadAddNew();"><em class="icon ni ni-check"></em><span>ยืนยัน</span></a>
    </div> 
    <script >  
        NioApp.Select2('.formsss'); 
        NioApp.Select2('.search_p_too'); 
    </script>   


<?php }elseif($_POST["myaction"]=="selectproduct"){?>
	<div class="modal-header">
        <h5 class="modal-title">เลือกสินค้า</h5>
        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
            <em class="icon ni ni-cross"></em>
        </a>
    </div>

    <style>
        .tableFixHead          { overflow: auto; height: 600px; }
        .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .tableFixHead::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .tableFixHead {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        }
        /* Just common table stuff. Really. */
        table  { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px 16px; } 
    </style>    
    <?php
        $sql = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1'";
        $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
	    $count_record=$query->num_rows;

    ?>
    <div class="modal-body ">
        <div class="form-group">
            <label class="form-label">ชื่อลูกค้า</label> 
            
            <div class="form-control-wrap">
                <select class="form-select form-control form-control-lg formsss " data-search="on" id="customer_id"  name="customer_id" onchange="modloadProduce(document.getElementById('customer_id').value);">
                    <option value="0">กรุณาเลือกลูกค้า</option>
                    <?php 
                        while($row=$query->fetch_array()) { 
                            $row_id=		$row["md_customer_id"];
                            $row_name=		rechangeQuot($row["md_customer_name"])." (".$row["md_customer_code"].")";
                            $row_status=	$row["md_customer_status"];  ?>    

                            <option value="<?php echo $row_id ?>"><?php echo $row_name ?></option>
 
                    <?php } ?>
                </select>
            </div>
        </div>
        <hr>
        
        <div class="tableFixHead">
            <div class="nk-tb-list " id="loadproduct"> 
                <div class="row">
                    <div class="col-6 col-sm-6 text-left">
                        <div id="InputSearch" class="dataTables_filter">
                            <div>
                                <label>ค้นหา</label>
                                <input type="search"   class="form-control form-control-md" placeholder="Type in to Search" aria-controls="InputSearch_p" id="InputSearch_p" name="InputSearch_p" value="<?php echo $_REQUEST["InputSearch_p"]?>" onchange="modLoadsearch(this.value);">
                            </div><br>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6 text-left" >
                        <label>ประเภทสินค้า</label>
                        <select class="form-control form-control-sm search_p_too " data-search="on" id="input_catalog"  name="input_catalog"   onchange="modLoadtype(this.value,'');" >
                            <option value="0">ค้นหาประเภทสินค้า</option>
                            <?php 
                                $sql_product_type = "SELECT * FROM md_catalog WHERE md_catalog_delete=0 "; 
                                $query_product_type=$mysqli->query($sql_product_type) or die("Error sql_product_type: เกิดความผิดพลาด <br>$sql_product_type\n");
                                while($row_product_type=$query_product_type->fetch_array()) { 
                                    $row_product_type_id=		$row_product_type["md_catalog_id"];
                                    $row_product_type_name=		rechangeQuot($row_product_type["md_catalog_name"]); ?>  

                                    <option value="<?php echo $row_product_type_id ?>"  <?php echo ($row_product_type["md_catalog_id"]==$_REQUEST["input_catalog"])?"selected":""?>><?php echo $row_product_type_name ?></option>
        
                            <?php } ?>
                        </select>
                    </div>
                </div>

               
                <?php
                $sql_cat = "SELECT * FROM md_catalog WHERE md_catalog_status!='2' ";
                if($_REQUEST["input_catalog"]!=0){
                    $sql_cat .= " AND md_catalog_id='".$_REQUEST["input_catalog"]."'";
                }
                $sql_cat .= " ORDER BY md_catalog_name ASC";
                $query_cat=$mysqli->query($sql_cat) or die("Error sql_cat:  <br/>$sql_cat<br />\n");
                while($Row_cat=$query_cat->fetch_array()){
                    $sql = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_catalogid='".$Row_cat["md_catalog_id"]."' ORDER BY md_product_name ASC";
                    $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
                    $count_totalrecord=$query->num_rows;
                    if($count_totalrecord>0){ ?> 
                        <div class="nk-tb-item">
                            <div class="nk-tb-col tb-col-sm">
                                <span class="tb-sub text-success"><h5><?php echo $Row_cat["md_catalog_name"]?></h5></span>
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                
                            </div>
                            <div class="nk-tb-col tb-col-sm">
                                
                            </div> 
                        </div> 
                        <div class="nk-tb-item nk-tb-head bg-light">
                            <div class="nk-tb-col tb-col-sm"><span>รหัสสินค้า</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>ชื่อสินค้า</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>ราคา/หน่วย</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>จำนวนคงเหลือ</span></div>
                            <div class="nk-tb-col tb-col-sm"><span>&nbsp;</span></div>
                            <!-- <div class="nk-tb-cosl"><span>&nbsp;</span></div> -->
                        </div> 
                        <?php
                        while($Row=$query->fetch_array()){ ?>
                            <?php
                                $balance_stock = getBalanceWalletStock($Row['md_product_id']);
                            ?>
                            <div class="nk-tb-item">
                                <div class="nk-tb-col tb-col-sm">
                                    <div class="user-card"> 
                                        <a href="#"><span class="tb-sub ml-2">#<?php echo $Row['md_product_code'];?> </span></a>
                                    </div>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <div class="user-card"> 
                                        <div class="user-name">
                                            <span class="tb-lead"><?php echo $Row['md_product_name'];?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <span class="tb-sub"><?php echo $Row['md_product_sell'];?></span>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <span class="tb-sub tb-amount"><?php echo $balance_stock;?> <span>Kg.</span></span>
                                </div>
                                <div class="nk-tb-col tb-col-sm">
                                    <a href="javascript:void(0)" onclick="document.myForm.productid.value ='<?php echo $Row['md_product_id'];?>',document.myForm.product_waletstock.value ='<?php echo $balance_stock;?>';modLoadAddProduct();" class="btn btn-sm btn-wider btn-success" style="display: flex;justify-content: space-around">เลือก</a>
                                </div> 
                            </div> 
                        <?php 
                        } //while($Row=$query->fetch_array()){
                    }//if($count_totalrecord>0){
                }//while($Row_cat=$query_cat->fetch_array()){ 
                ?> 
                
            </div>
        </div>   
    </div> 
    <script >  
        NioApp.Select2('.formsss'); 
        NioApp.Select2('.search_p_too'); 
    </script>   
<?php }elseif($_POST["myaction"]=="addproduct"){
            $sql_custumer = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1' AND md_customer_id='".$_REQUEST['customer_id']."'";
            $query_custumer=$mysqli->query($sql_custumer) or die("Error sql_custumer: เกิดความผิดพลาด <br>$sql_custumer\n");
            $row_custumer=$query_custumer->fetch_array();

			if($_POST["productid"]!=""){
             $sql = "SELECT * FROM md_product WHERE md_product_id='".$_POST["productid"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			}
 
            $priceproduct = $Row['md_product_sell'];
            ?>
            <div class="modal-header">
                <h5 class="modal-title">เพิ่มสินค้า</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="customer_id" name="customer_id" value="<?php echo $row_custumer['md_customer_id']?>" >
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="inptfee">รหัสลูกค้า</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="customer_code" name="customer_code" value="<?php echo $row_custumer['md_customer_code']?>" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="inptfee">ชื่อลูกค้า</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $row_custumer['md_customer_name']?>" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="inptfee">เบอร์โทรลูกค้า</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="<?php echo $row_custumer['md_customer_tel']?>" readonly="readonly">
                            </div>
                        </div>
                    </div>
                </div><hr>

                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="inptfee">ชื่อสินค้า</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo $Row['md_product_name']?>" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="inptfee">ราคาซื้อ</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="product_buy" name="product_buy" value="<?php echo $priceproduct?>" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="inptfee">น้ำหนัก</label>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" id="product_amount" name="product_amount" value="" style="border-color: #5bdb09;">
                            </div>
                        </div>
                    </div>
                </div><br>
                <!-- 
                <div class="row g-3">
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('1')">1</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('2')">2</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('3')">3</button></div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('4')">4</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('5')">5</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('6')">6</button></div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('7')">7</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('8')">8</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('9')">9</button></div>
                </div> 
                
                <div class="row g-3">
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light"  onclick="calculate('0')">0</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('00')">00</button></div>
                    <div class="col-lg-4"><button type="button" class="btn btn-lg btn-block btn-light" onclick="calculate('.')">.</button></div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-6"><button type="button" class="btn btn-lg btn-block btn-danger"  onclick="calculate('d')"><em class="icon ni ni-arrow-long-left"></em></button></div>
                    <div class="col-lg-6"><button type="button" class="btn btn-lg btn-block btn-danger"  onclick="calculate('c')">CLEAR</button></div>
                </div> -->
                
                <hr/>
                <div class="row g-3" align="right">
                    <div class="col-lg-6"><a href="javascript:void(0)" class="btn btn btn-block btn-lg btn-primary" onclick="loadchkaddform();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:save"];?></span></a></div>
                    <div class="col-lg-6">
                        <a href="javascript:void(0)" class="btn btn btn-block btn-lg btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
                        </div>
                </div>
            </div>  
<?php }elseif($_POST["myaction"]=="insertproduct"){ 
        $check=0;
        $sql_order = "SELECT * FROM md_order_sell WHERE md_order_customerid='".$_POST["customer_id"]."' AND md_order_crebyid ='".$_SESSION["core_session_sys_id"]."'";
        if($_POST['row_id']!=0){
            $sql_order .= " AND md_order_billID= '".$_POST['row_id']."'";
        }else{
            $sql_order .= " AND md_order_billID='0'";
        }
        $query_order=$mysqli->query($sql_order) or die("Error sql_order:  <br/>$sql_order<br />\n");
        while($Row_order=$query_order->fetch_array()){
            if($Row_order['md_order_productid']==$_POST["productid"]){ 
                // && $Row_order['md_order_amount']==$_POST['product_amount']
                $check=1;
                break;
            }
        }

        $total=$_POST['product_amount']*$_POST['product_buy'];
        
        unset($insert);
        $insert["md_order_productid"] = "'".$_POST["productid"]."'";
        $insert["md_order_customerid"] = "'".$_POST["customer_id"]."'";
        $insert["md_order_price"] = "'".$_POST['product_buy']."'";
        $insert["md_order_amount"] = "'".$_POST['product_amount']."'";
        $insert["md_order_total"] = "'".$total."'";
        
        $insert["md_order_billID"] = "'".$_POST['row_id']."'";
        
        if($check==1){
            $insert["md_order_status_same"] = "'1'"; //ซ้ำ
        }

        $insert["md_order_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_order_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_order_credate"] = "NOW()";
        $insert["md_order_updatedate"] = "NOW()";

        $sql_insert="INSERT INTO md_order_sell(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        $order_ID_product=$mysqli->insert_id;

        $code='AD-'.strtotime(date('YmdHis')); //ซื้อเข้า
        $md_deposit_amount="ซื้อสินค้าเข้า stock จำนวน ".$_POST['product_amount'];
        // ." product_id ".$_REQUEST['productid']
        $PrevWalletStock = getBalanceWalletStock($_REQUEST['productid']);
        $BalanceWalletStock = $PrevWalletStock+$_REQUEST['product_amount'];

        unset($insert);
        $insert["md_stock_code"] = "'".$code."'"; 
        $insert["md_stock_product_id"] = "'".$_REQUEST['productid']."'";
        $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
        $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; // "'เพิ่มสต็อกสินค้า จำนวน ".$md_deposit_amount."'";
        $insert["md_stock_price"] = "'".$_REQUEST['product_buy']."'";
        $insert["md_stock_deposit"] = "'".$_REQUEST['product_amount']."'";
        $insert["md_stock_withdrawal"] = "'0'";		
        $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
        $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
        $insert["md_stock_group"] = "'DF'";			 
        $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'";

        // echo	"sql_insert=".
        $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert_st=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        if($Query_insert_st){
            if($_REQUEST['row_id']!=''){
                //echo "<br>sql_insert=".
                $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."' AND md_order_billdetail_status='0'";
                $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
                while($Row_order=$Query_order->fetch_array()){
                
                    unset($insert);
                    $insert["md_billing_detail_billingid"] = "'".$_REQUEST['row_id']."'";
                    $insert["md_billing_detail_productid"] = "'".$Row_order['md_order_productid']."'"; 
                    $insert["md_billing_detail_orderid"] = "'".$Row_order['md_order_id']."'";
                    $insert["md_billing_detail_amount"] = "'".$Row_order['md_order_amount']."'";
                    $insert["md_billing_detail_price"] = "'".$Row_order['md_order_price']."'";
                    $insert["md_billing_detail_total"] = "'".$Row_order['md_order_total']."'";
                    $insert["md_billing_detail_status"] = "'1'";
                    $insert["md_billing_detail_credate"] = "NOW()";
        
                    //echo	"<br>sql_insert=".
                    $sql_insert="INSERT INTO md_billing_detail_sell(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        
                    // $total += $Row_order['md_order_total'];
                    
                    $sql_up = "UPDATE md_order_sell SET md_order_billdetail_status= '1'  WHERE md_order_id='".$Row_order['md_order_id']."'";
                    $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");
                    // $sql_detale="DELETE FROM md_order_sell WHERE md_order_id='".$Row_order['md_order_id']."'";
                    // $Query=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
                
                }//while($Row_order=$Query_order->fetch_array()){
            
        
                $sql_order = "SELECT sum(md_order_total) FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."'";
                $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
                $Row_order=$Query_order->fetch_array();
                
        
                if($vatetype==1){
                    if($vatetype2==3){
                        $vatetype=1;
                        $vat_out = $total*(7/107);
                        $sumtotal=$total-$vat_out;  //$total
                    }elseif($vatetype2==4){
                        $vatetype=2;
                        $vat_out = $total*(7/100);
                        $sumtotal=$total+$vat_out;
                    } 
                }else{
                    $vatetype=0;
                    $vat_out = 0;
                    $sumtotal=$total;
                } 
        
                $sql = "UPDATE md_billing SET md_billing_total= '".round($Row_order[0],2)."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."'  WHERE md_billing_id='".$_REQUEST['row_id']."'";
                $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
                   
                // $detail="ออกบิล ".$maxOrderMemAdd." จำนวน ".$total;
                // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
                
                // echo "success";
                echo json_encode(array("md_billing" => $_REQUEST['row_id'],"customer_id" => $_REQUEST['customer_id'],"order_ID" => $order_ID_product,"status" => "success"));
        
            }else{
                $new_id =mysqli_result($mysqli->query("Select Max(substr(md_billing_number,-5))+1 as MaxID from md_billing"),0,"MaxID");//เลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
                //$myYear = $_SESSION["front_session_sys_branch"];
                if($new_id==''){ // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
                    $maxOrderMemAdd="S00001";
                }else{
                    $maxOrderMemAdd="S".sprintf("%05d",$new_id);//ถ้าไม่ใช่ค่าว่าง
                }
                
                unset($insert);
                $insert["md_billing_number"] = "'".$maxOrderMemAdd."'";
                
                $insert["md_billing_status"] = "'3'";
                $insert["md_billing_customerid"] = "'".$_REQUEST['customer_id']."'";
                $insert["md_billing_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                $insert["md_billing_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                $insert["md_billing_credate"] = "NOW()";
                $insert["md_billing_updatedate"] = "NOW()";
        
                //echo	"sql_insert=".
                $sql_insert="INSERT INTO md_billing(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
                $billingID=$mysqli->insert_id;
                
                //echo "<br>sql_insert=".
                $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='0'";
                $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
                while($Row_order=$Query_order->fetch_array()){
                
                    unset($insert);
                    $insert["md_billing_detail_billingid"] = "'".$billingID."'";
                    $insert["md_billing_detail_orderid"] = "'".$Row_order['md_order_id']."'";
                    $insert["md_billing_detail_productid"] = "'".$Row_order['md_order_productid']."'";
                    $insert["md_billing_detail_amount"] = "'".$Row_order['md_order_amount']."'";
                    $insert["md_billing_detail_price"] = "'".$Row_order['md_order_price']."'";
                    $insert["md_billing_detail_total"] = "'".$Row_order['md_order_total']."'";
                    $insert["md_billing_detail_status"] = "'1'";
                    $insert["md_billing_detail_credate"] = "NOW()";
        
                    //echo	"<br>sql_insert=".
                    $sql_insert="INSERT INTO md_billing_detail_sell(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        
                    $total=$total+$Row_order['md_order_total'];
                    
                    $sql_up = "UPDATE md_order_sell SET md_order_billID= '".$billingID."' ,md_order_billdetail_status= '1'  WHERE md_order_id='".$Row_order['md_order_id']."'";
                    $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");
                    // $sql_detale="DELETE FROM md_order_sell WHERE md_order_id='".$Row_order['md_order_id']."'";
                    // $Query=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
                
                }//while($Row_order=$Query_order->fetch_array()){
             
                    
                if($vatetype==1){
                    if($vatetype2==3){
                        $vatetype=1;
                        $vat_out = $total*(7/107);
                        $sumtotal=$total-$vat_out;  //$total
                    }elseif($vatetype2==4){
                        $vatetype=2;
                        $vat_out = $total*(7/100);
                        $sumtotal=$total+$vat_out;
                    } 
                }else{
                    $vatetype=0;
                    $vat_out = 0;
                    $sumtotal=$total;
                } 
        
                $sql = "UPDATE md_billing SET md_billing_total= '".round($total,2)."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."'  WHERE md_billing_id='".$billingID."'";
                $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
        
                // $detail="ออกบิล ".$maxOrderMemAdd." จำนวน ".$total;
                // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
            
                if($Query){
                    // echo "success";
                    echo json_encode(array("md_billing" => $billingID,"customer_id" => $_REQUEST['customer_id'],"order_ID" => $order_ID_product,"status" => "success"));
                }else{
                    // echo "error";
                    echo json_encode(array("md_billing" => $billingID,"customer_id" => $_REQUEST['customer_id'],"order_ID" => $order_ID_product,"status" => "error"));
                }
            }
        }else{
            // echo "error";
            echo json_encode(array("md_billing" => $billingID,"customer_id" => $_REQUEST['customer_id'],"order_ID" => $order_ID_product,"status" => "error"));
        }
    ?>
<?php }elseif($_POST["myaction"]=="insert"){
    // print_r($_POST); 
    $vatetype = $_POST['vatRadio'];
    if($vatetype==1){
        $vatetype2 = $_POST['vatRadio2'];
    } 
    if($_REQUEST['row_id']!=''){ 
         
        $sql_detale="DELETE FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."'";
        $Query_detale=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
        
        $sql_bill = "SELECT * FROM md_billing WHERE md_billing_id='".$_REQUEST['row_id']."'";
        $Query_bill=$mysqli->query($sql_bill) OR DIE("Error sql_bill: <br>$sql_bill<br>\n");
        $Row_bill=$Query_bill->fetch_array();
        $total=$Row_bill['md_billing_total'];


        if($vatetype==1){
            if($vatetype2==3){
                $vatetype=1;
                $vat_out = $total*(7/107);
                $sumtotal=$total-$vat_out;  //$total
            }elseif($vatetype2==4){
                $vatetype=2;
                $vat_out = $total*(7/100);
                $sumtotal=$total+$vat_out;
            } 
        }else{
            $vatetype=0;
            $vat_out = 0;
            $sumtotal=$total;
        }

        $sql = "UPDATE md_billing SET md_billing_total= '".$total."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."',md_billing_status='1', md_billing_updatedate='NOW()'  WHERE md_billing_id='".$_REQUEST['row_id']."'";
        $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");



        $sql = "SELECT md_wallet_balance FROM md_wallet WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
        $Query=$mysqli->query($sql);
        $Row=$Query->fetch_array();
        $PrevWallet=$Row["md_wallet_balance"];
        
        $type="BL";
        $detail="ออกบิล ".$Row_bill['md_billing_number']." จำนวน ".$total;
        $withdrawal=$total;
        $BalanceWallet=$PrevWallet-$withdrawal;

        unset($insert);
        $insert["md_wallet_code"] = "'".$Row_bill['md_billing_number']."'";
        //$insert["md_wallet_date"] = "NOW()";
        $insert["md_wallet_detail"] = "'".$detail."'";
        $insert["md_wallet_deposit"] = "'".$deposit."'";
        $insert["md_wallet_withdrawal"] = "'".$withdrawal."'";		
        $insert["md_wallet_prevbalance"] = "'".$PrevWallet."'";	
        $insert["md_wallet_balance"] = "'".$BalanceWallet."'";	
        $insert["md_wallet_group"] = "'".$type."'";			 
        $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_credate"] = "NOW()";
        $insert["md_wallet_updatedate"] = "NOW()";
    
        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_wallet(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        
        // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
        
        if($Query_insert){
            echo "success";
        }else{
            echo "error";
        }
    }else{
        $new_id =mysqli_result($mysqli->query("Select Max(substr(md_billing_number,-5))+1 as MaxID from md_billing"),0,"MaxID");//เลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
        //$myYear = $_SESSION["front_session_sys_branch"];
        if($new_id==''){ // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
            $maxOrderMemAdd="S00001";
        }else{
            $maxOrderMemAdd="S".sprintf("%05d",$new_id);//ถ้าไม่ใช่ค่าว่าง
        }
        
        unset($insert);
        $insert["md_billing_number"] = "'".$maxOrderMemAdd."'";
        
        $insert["md_billing_status"] = "'1'";
        $insert["md_billing_customerid"] = "'".$_REQUEST['customerID']."'";
        $insert["md_billing_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_billing_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_billing_credate"] = "NOW()";
        $insert["md_billing_updatedate"] = "NOW()";

        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_billing(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        $billingID=$mysqli->insert_id;
        
        //echo "<br>sql_insert=".
        $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND  md_order_billID='0' AND md_order_billdetail_status='0'";
        $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
        while($Row_order=$Query_order->fetch_array()){
        
            unset($insert);
            $insert["md_billing_detail_billingid"] = "'".$billingID."'";
            $insert["md_billing_detail_productid"] = "'".$Row_order['md_order_productid']."'";
            $insert["md_billing_detail_orderid"] = "'".$Row_order['md_order_id']."'";
            $insert["md_billing_detail_amount"] = "'".$Row_order['md_order_amount']."'";
            $insert["md_billing_detail_price"] = "'".$Row_order['md_order_price']."'";
            $insert["md_billing_detail_total"] = "'".$Row_order['md_order_total']."'";
            $insert["md_billing_detail_status"] = "'1'";
            $insert["md_billing_detail_credate"] = "NOW()";
            //echo	"<br>sql_insert=".
            $sql_insert="INSERT INTO md_billing_detail_sell(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
            $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");

            $total=$total+$Row_order['md_order_total'];
            
            $sql_detale="DELETE FROM md_order_sell WHERE md_order_id='".$Row_order['md_order_id']."' AND md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='0'";
            $Query=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
        
        }//while($Row_order=$Query_order->fetch_array()){
        
        if($vatetype==1){
            if($vatetype2==3){
                $vatetype=1;
                $vat_out = $total*(7/107);
                $sumtotal=$total-$vat_out;  //$total
            }elseif($vatetype2==4){
                $vatetype=2;
                $vat_out = $total*(7/100);
                $sumtotal=$total+$vat_out;
            } 
        }else{
            $vatetype=0;
            $vat_out = 0;
            $sumtotal=$total;
        }
         
        $sql = "UPDATE md_billing SET md_billing_total= '".$total."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."'  WHERE md_billing_id='".$billingID."'";
        $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
         
        $sql = "SELECT md_wallet_balance FROM md_wallet WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
        $Query=$mysqli->query($sql);
        $Row=$Query->fetch_array();

        $PrevWallet=$Row["md_wallet_balance"];
        
        $type="BL";
        $detail="ออกบิล ".$maxOrderMemAdd." จำนวน ".$total;
        $withdrawal=$total;
        $BalanceWallet=$PrevWallet-$withdrawal;

        unset($insert);
        $insert["md_wallet_code"] = "'".$maxOrderMemAdd."'";
        //$insert["md_wallet_date"] = "NOW()";
        $insert["md_wallet_detail"] = "'".$detail."'";
        $insert["md_wallet_deposit"] = "'".$deposit."'";
        $insert["md_wallet_withdrawal"] = "'".$withdrawal."'";		
        $insert["md_wallet_prevbalance"] = "'".$PrevWallet."'";	
        $insert["md_wallet_balance"] = "'".$BalanceWallet."'";	
        $insert["md_wallet_group"] = "'".$type."'";			 
        $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_credate"] = "NOW()";
        $insert["md_wallet_updatedate"] = "NOW()";
    
        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_wallet(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
         
        if($Query_insert){
            echo "success";
        }else{
            echo "error";
        }
    }
		
    ?>
    <!-- <script type="text/javascript">
        window.open('printinvoice_sell.php?number=<?php echo $maxOrderMemAdd;?>');
        modLoadContent();
    </script> -->

<?php }elseif($_POST["myaction"]=="insert_2"){
    $total=0; 
    $total_amount=0;
    // print_r($_POST); 
    $vatetype = $_POST['vatRadio'];
    if($vatetype==1){
        $vatetype2 = $_POST['vatRadio2'];
    }
    // print_r($_REQUEST);
    $array_product_weight_cr = $_REQUEST['product_weight_cr'];
    $array_product_reason_cr = $_REQUEST['product_reason_cr'];
    $array_product_price_cr = $_REQUEST['product_price_cr'];
    $array_order_id = $_REQUEST['order_id'];
    
    if($_REQUEST['row_id']!=''){
        $i = 0;
        while($i < count($array_order_id)){
            // echo $array_order_id[$i]."<br>";
            // echo $array_product_weight_cr[$array_order_id[$i]]."<br>";

            $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."' AND md_order_billdetail_status='1' AND md_order_id='".$array_order_id[$i]."'";
            $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
            while($Row_order=$Query_order->fetch_array()){
                // echo "<br>".$Row_order['md_order_id']." : ".$array_product_weight_cr[$array_order_id[$i]]."<br>";
                $product_amount = $array_product_weight_cr[$array_order_id[$i]];
                $product_reason = $array_product_reason_cr[$array_order_id[$i]];
                $product_price = $array_product_price_cr[$array_order_id[$i]];

                if($Row_order['md_order_amount']==0){
                    $order_amount= "md_order_amount= '".$product_amount."',";
                    $detail_amount= "md_billing_detail_amount= '".$product_amount."',";
                }else{
                    $product_amount=$Row_order['md_order_amount'];
                }

                $sum_amount= $product_amount*$product_price;
                $sql_up = "UPDATE md_order_sell SET md_order_amount= '".$product_amount."', md_order_total='".$sum_amount."', md_order_reason='".$product_reason."', md_order_price='".$product_price."', md_order_updatedate='NOW()'  WHERE md_order_id='".$Row_order['md_order_id']."'";
                $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");

                $sql_detail = "UPDATE md_billing_detail_sell SET md_billing_detail_amount= '".$product_amount."', md_billing_detail_total='".$sum_amount."', md_billing_detail_reason='".$product_reason."', md_billing_detail_price='".$product_price."'  WHERE md_billing_detail_orderid='".$Row_order['md_order_id']."'";
                $Query_updetail=$mysqli->query($sql_detail)OR DIE("Error sql_detail: <br>$sql_detail<br>\n");


                if($Row_order['md_order_amount']==0){
                    $code='SD-'.strtotime(date('YmdHis')); //ซื้อเข้า
                    $md_deposit_amount="ขายสินค้าใน stock จำนวน ".$product_amount." กก.";
                    // ." product_id ".$_REQUEST['productid']
                    $PrevWalletStock = getBalanceWalletStock($Row_order['md_order_productid']);
                    $BalanceWalletStock = $PrevWalletStock-$product_amount;
    
                    unset($insert);
                    $insert["md_stock_code"] = "'".$code."'"; 
                    $insert["md_stock_product_id"] = "'".$Row_order['md_order_productid']."'";
                    $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
                    $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; // "'เพิ่มสต็อกสินค้า จำนวน ".$md_deposit_amount."'";
                    $insert["md_stock_price"] = "'".$Row_order['md_order_price']."'";
                    $insert["md_stock_deposit"] = "'0'";		
                    $insert["md_stock_withdrawal"] = "'".$product_amount."'";
                    $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
                    $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
                    $insert["md_stock_group"] = "'WF'";			 
                    $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'"; 
                    $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert_st=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
                }

                $total += $sum_amount;
                $total_amount += $product_amount;

                $sql_detale="DELETE FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."' AND md_order_billdetail_status='1' AND md_order_id='".$array_order_id[$i]."'";
                $Query_detale=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
            }
	        $i++; 
        }
 
        if($vatetype==1){
            if($vatetype2==3){
                $vatetype=1;
                $vat_out = $total*(7/107);
                $sumtotal=$total-$vat_out;  //$total
                $total2=$total;
            }elseif($vatetype2==4){
                $vatetype=2;
                $vat_out = $total*(7/100);
                $sumtotal=$total+$vat_out;
                $total2=$sumtotal;
            } 
        }else{
            $vatetype=0;
            $vat_out = 0;
            $sumtotal=$total;
            $total2=$sumtotal;
        } 

        $sql = "UPDATE md_billing SET md_billing_total= '".round($total,2)."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."',md_billing_status='1', md_billing_updatedate='NOW()', md_billing_carcode='".$_REQUEST['car_code']."'  WHERE md_billing_id='".$_REQUEST['row_id']."'";
        $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
        
        $sql_bill = "SELECT * FROM md_billing WHERE md_billing_id='".$_REQUEST['row_id']."'";
        $Query_bill=$mysqli->query($sql_bill) OR DIE("Error sql_bill: <br>$sql_bill<br>\n");
        $Row_bill=$Query_bill->fetch_array();

        $sql_balance = "SELECT md_wallet_balance FROM md_wallet WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
        $Query_balance=$mysqli->query($sql_balance);
        $Row_balance=$Query_balance->fetch_array();
        $PrevWallet=$Row_balance["md_wallet_balance"];
        
        $type="BS";
        $detail="ออกบิลขาย ".$Row_bill['md_billing_number']." จำนวน ".$total." บาท";
        $deposit=$total;
        $BalanceWallet=$PrevWallet+$deposit;

        unset($insert);
        $insert["md_wallet_code"] = "'".$Row_bill['md_billing_number']."'"; 
        $insert["md_wallet_detail"] = "'".$detail."'";
        $insert["md_wallet_deposit"] = "'".$deposit."'";
        $insert["md_wallet_withdrawal"] = "'".$withdrawal."'";		
        $insert["md_wallet_prevbalance"] = "'".$PrevWallet."'";	
        $insert["md_wallet_balance"] = "'".$BalanceWallet."'";	
        $insert["md_wallet_group"] = "'".$type."'";			 
        $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_credate"] = "NOW()";
        $insert["md_wallet_updatedate"] = "NOW()"; 
        $sql_insert="INSERT INTO md_wallet(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
         

        // ===========
        $sql_bket = "SELECT md_stockbasket_balance FROM md_stockbasket WHERE md_stockbasket_customerid='".$Row_bill["md_billing_customerid"]."' ORDER BY md_stockbasket_id DESC LIMIT 1";
        $Query_bket=$mysqli->query($sql_bket);
        $Row_bket=$Query_bket->fetch_array();
        $PrevWalletbasket=$Row_bket["md_stockbasket_balance"];
         
        $outTradeNo= 'SD-'.strtotime(date('YmdHis')); //เพิ่มหนี้
        $type="DF";
        $detail="ขายสินค้า จำนวน ".$total2."บาท billing number: ".$Row_bill['md_billing_number'];
        $depositbasket=$total2;
        $BalanceWalletbasket=$PrevWalletbasket+$depositbasket;
        
        unset($insert);
        $insert["md_stockbasket_code"] = "'".$outTradeNo."'"; 
        $insert["md_stockbasket_billingnumber"] ="'".$Row_bill['md_billing_number']."'";
        $insert["md_stockbasket_customerid"] = "'".$Row_bill["md_billing_customerid"]."'";
        $insert["md_stockbasket_detail"] = "'".$detail."'";
        $insert["md_stockbasket_deposit"] = "'".$depositbasket."'";
        $insert["md_stockbasket_withdrawal"] = "'0'";		
        $insert["md_stockbasket_prevbalance"] = "'".$PrevWalletbasket."'";	
        $insert["md_stockbasket_balance"] = "'".$BalanceWalletbasket."'";	
        $insert["md_stockbasket_group"] = "'".$type."'";			 
        $insert["md_stockbasket_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_stockbasket_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_stockbasket_credate"] = "NOW()";
        $insert["md_stockbasket_updatedate"] = "NOW()";
        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_stockbasket(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
         
        // ///////////////
        $sql_bk = "SELECT md_wallet_balance FROM md_wallet_basket WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
        $Query_bk=$mysqli->query($sql_bk);
        $Row_bk=$Query_bk->fetch_array();
        $PrevWallet_bk=$Row_bk["md_wallet_balance"];
         
        $BalanceWallet_BK=$PrevWallet_bk+$depositbasket;
          
        unset($insert);
        $insert["md_wallet_code"] = "'".$outTradeNo."'"; 
        $insert["md_wallet_detail"] = "'".$detail."'";
        $insert["md_wallet_deposit"] = "'".$depositbasket."'";
        $insert["md_wallet_withdrawal"] = "'0'";		
        $insert["md_wallet_prevbalance"] = "'".$PrevWallet_bk."'";	
        $insert["md_wallet_balance"] = "'".$BalanceWallet_BK."'";	
        $insert["md_wallet_group"] = "'".$type."'";			 
        $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_wallet_credate"] = "NOW()";
        $insert["md_wallet_updatedate"] = "NOW()";
        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_wallet_basket(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        // ==========

        echo "success";

    }  
    ?>
    <script type="text/javascript">
        var myRadio = $("input[name='customRadio']:checked").val();
	
        if(myRadio==0){
            var myRadio2 = $("input[name='customRadio2']:checked").val();
        }else{
            var myRadio2 = 0;
        }
        window.open('printinvoice_sell.php?number=<?php echo $Row_bill['md_billing_number'];?>'+'&myRadio='+myRadio+'&myRadio2='+myRadio2); 
        modLoadContent();
    </script>

<?php }elseif($_POST["myaction"]=="insertbillcheck"){
    $total=0;
    // print_r($_POST); 
    $vatetype = $_POST['vatRadio'];
    if($vatetype==1){
        $vatetype2 = $_POST['vatRadio2'];
    } 

    if($_REQUEST['row_id']!=''){
        //echo "<br>sql_insert=".
        $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."' AND md_order_billdetail_status='0'";
        $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
        while($Row_order=$Query_order->fetch_array()){
        
            unset($insert);
            $insert["md_billing_detail_billingid"] = "'".$_REQUEST['row_id']."'";
            $insert["md_billing_detail_productid"] = "'".$Row_order['md_order_productid']."'"; 
            $insert["md_billing_detail_orderid"] = "'".$Row_order['md_order_id']."'";
            $insert["md_billing_detail_amount"] = "'".$Row_order['md_order_amount']."'";
            $insert["md_billing_detail_price"] = "'".$Row_order['md_order_price']."'";
            $insert["md_billing_detail_total"] = "'".$Row_order['md_order_total']."'";
            $insert["md_billing_detail_status"] = "'1'";
            $insert["md_billing_detail_credate"] = "NOW()";

            //echo	"<br>sql_insert=".
            $sql_insert="INSERT INTO md_billing_detail_sell(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
            $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");

            // $total += $Row_order['md_order_total'];
            
            $sql_up = "UPDATE md_order_sell SET md_order_billdetail_status= '1'  WHERE md_order_id='".$Row_order['md_order_id']."'";
            $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");
            // $sql_detale="DELETE FROM md_order_sell WHERE md_order_id='".$Row_order['md_order_id']."'";
            // $Query=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
        
        }//while($Row_order=$Query_order->fetch_array()){
    

        $sql_order = "SELECT sum(md_order_total) FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."'";
        $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
        $Row_order=$Query_order->fetch_array();
        

        if($vatetype==1){
            if($vatetype2==3){
                $vatetype=1;
                $vat_out = $total*(7/107);
                $sumtotal=$total-$vat_out;  //$total
            }elseif($vatetype2==4){
                $vatetype=2;
                $vat_out = $total*(7/100);
                $sumtotal=$total+$vat_out;
            } 
        }else{
            $vatetype=0;
            $vat_out = 0;
            $sumtotal=$total;
        } 

        $sql = "UPDATE md_billing SET md_billing_total= '".round($Row_order[0],2)."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."'  WHERE md_billing_id='".$_REQUEST['row_id']."'";
        $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
           
        // $detail="ออกบิล ".$maxOrderMemAdd." จำนวน ".$total;
        // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
        
        echo "success";

    }else{
        $new_id =mysqli_result($mysqli->query("Select Max(substr(md_billing_number,-5))+1 as MaxID from md_billing"),0,"MaxID");//เลือกเอาค่า id ที่มากที่สุดในฐานข้อมูลและบวก 1 เข้าไปด้วยเลย
        //$myYear = $_SESSION["front_session_sys_branch"];
        if($new_id==''){ // ถ้าได้เป็นค่าว่าง หรือ null ก็แสดงว่ายังไม่มีข้อมูลในฐานข้อมูล
            $maxOrderMemAdd="S00001";
        }else{
            $maxOrderMemAdd="S".sprintf("%05d",$new_id);//ถ้าไม่ใช่ค่าว่าง
        }
        
        unset($insert);
        $insert["md_billing_number"] = "'".$maxOrderMemAdd."'";
        
        $insert["md_billing_status"] = "'3'";
        $insert["md_billing_customerid"] = "'".$_REQUEST['customerID']."'";
        $insert["md_billing_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_billing_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_billing_credate"] = "NOW()";
        $insert["md_billing_updatedate"] = "NOW()";

        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_billing(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        $billingID=$mysqli->insert_id;
        
        //echo "<br>sql_insert=".
        $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='0'";
        $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
        while($Row_order=$Query_order->fetch_array()){
        
            unset($insert);
            $insert["md_billing_detail_billingid"] = "'".$billingID."'";
            $insert["md_billing_detail_orderid"] = "'".$Row_order['md_order_id']."'";
            $insert["md_billing_detail_productid"] = "'".$Row_order['md_order_productid']."'";
            $insert["md_billing_detail_amount"] = "'".$Row_order['md_order_amount']."'";
            $insert["md_billing_detail_price"] = "'".$Row_order['md_order_price']."'";
            $insert["md_billing_detail_total"] = "'".$Row_order['md_order_total']."'";
            $insert["md_billing_detail_status"] = "'1'";
            $insert["md_billing_detail_credate"] = "NOW()";

            //echo	"<br>sql_insert=".
            $sql_insert="INSERT INTO md_billing_detail_sell(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
            $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");

            $total=$total+$Row_order['md_order_total'];
            
            $sql_up = "UPDATE md_order_sell SET md_order_billID= '".$billingID."' ,md_order_billdetail_status= '1'  WHERE md_order_id='".$Row_order['md_order_id']."'";
            $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");
            // $sql_detale="DELETE FROM md_order_sell WHERE md_order_id='".$Row_order['md_order_id']."'";
            // $Query=$mysqli->query($sql_detale)OR DIE("Error sql_detale: <br>$sql_detale<br>\n");
        
        }//while($Row_order=$Query_order->fetch_array()){
     
            
        if($vatetype==1){
            if($vatetype2==3){
                $vatetype=1;
                $vat_out = $total*(7/107);
                $sumtotal=$total-$vat_out;  //$total
            }elseif($vatetype2==4){
                $vatetype=2;
                $vat_out = $total*(7/100);
                $sumtotal=$total+$vat_out;
            } 
        }else{
            $vatetype=0;
            $vat_out = 0;
            $sumtotal=$total;
        } 

        $sql = "UPDATE md_billing SET md_billing_total= '".round($total,2)."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."'  WHERE md_billing_id='".$billingID."'";
        $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");

        // $detail="ออกบิล ".$maxOrderMemAdd." จำนวน ".$total;
        // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
    
        if($Query){
            echo "success";
        }else{
            echo "error";
        }
    }   
		
    ?>
    <!-- <script type="text/javascript">
        window.open('printinvoice_sell.php?number=<?php echo $maxOrderMemAdd;?>');
        modLoadContent();
    </script> -->
    
<?php }elseif($_POST["myaction"]=="insertbillcheck_2"){
    $total=0; 
    $total_amount=0;
    // print_r($_POST); 
    $vatetype = $_POST['vatRadio'];
    if($vatetype==1){
        $vatetype2 = $_POST['vatRadio2'];
    }
    // print_r($_REQUEST);
    $array_product_weight_cr = $_REQUEST['product_weight_cr'];  
    $array_product_reason_cr = $_REQUEST['product_reason_cr'];
    $array_product_price_cr = $_REQUEST['product_price_cr'];
    $array_order_id = $_REQUEST['order_id'];

    if($_REQUEST['row_id']!=''){
        $i = 0;
        while($i < count($array_order_id)){
            // echo $array_order_id[$i]."<br>";
            // echo $array_product_reason_cr[$array_order_id[$i]]."<br>";

            $sql_order = "SELECT * FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$_REQUEST['row_id']."' AND md_order_billdetail_status='1' AND md_order_id='".$array_order_id[$i]."'";
            $Query_order=$mysqli->query($sql_order) OR DIE("Error sql_order: <br>$sql_order<br>\n");
            while($Row_order=$Query_order->fetch_array()){
                // echo "<br>".$Row_order['md_order_id']." : ".$array_product_weight_cr[$array_order_id[$i]]."<br>";
                $product_amount = $array_product_weight_cr[$array_order_id[$i]];
                $product_reason = $array_product_reason_cr[$array_order_id[$i]];
                $product_price = $array_product_price_cr[$array_order_id[$i]];

                if($Row_order['md_order_amount']==0){
                    $order_amount= "md_order_amount= '".$product_amount."',";
                    $detail_amount= "md_billing_detail_amount= '".$product_amount."',";
                }else{
                    $product_amount=$Row_order['md_order_amount'];
                }
                
                // $Row_order['md_order_price'];
                $sum_amount= $product_amount*$product_price;
                $sql_up = "UPDATE md_order_sell SET $order_amount md_order_total='".$sum_amount."', md_order_reason='".$product_reason."', md_order_price='".$product_price."', md_order_updatedate='NOW()', md_order_customerid='".$_REQUEST['customer_resive']."'  WHERE md_order_id='".$Row_order['md_order_id']."'";
                $Query_up=$mysqli->query($sql_up)OR DIE("Error sql_up: <br>$sql_up<br>\n");

                $sql_detail = "UPDATE md_billing_detail_sell SET $detail_amount md_billing_detail_total='".$sum_amount."', md_billing_detail_reason='".$product_reason."', md_billing_detail_price='".$product_price."' WHERE md_billing_detail_orderid='".$Row_order['md_order_id']."'";
                $Query_updetail=$mysqli->query($sql_detail)OR DIE("Error sql_detail: <br>$sql_detail<br>\n");
 
                // ==============================
                if($Row_order['md_order_amount']==0){
                    $sql_billing = "SELECT * FROM md_billing WHERE md_billing_id='".$_REQUEST['row_id']."'";
                    $Query_billing=$mysqli->query($sql_billing);
                    $Row_billing=$Query_billing->fetch_array();
                    
                    $code='SD-'.strtotime(date('YmdHis')); //ขายสินค้า
                    $md_deposit_amount="ขายสินค้า billing_number: ".$Row_billing['md_billing_number'];
                    $PrevWalletStock = getBalanceWalletStock($Row_order['md_order_productid']);
                    $BalanceWalletStock = $PrevWalletStock-$product_amount;
                    
                    unset($insert);
                    $insert["md_stock_code"] = "'".$code."'"; 
                    $insert["md_stock_product_id"] = "'".$Row_order['md_order_productid']."'";
                    $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
                    $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; //  
                    $insert["md_stock_price"] = "'".$Row_order['md_order_price']."'";
                    $insert["md_stock_deposit"] = "'0'";
                    $insert["md_stock_withdrawal"] = "'".$product_amount."'";
                    $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
                    $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
                    $insert["md_stock_group"] = "'WF'";			 
                    $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'";
                    // echo	"sql_insert=".
                    $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
                }
                
                // ==============================

                $total += $sum_amount;
                $total_amount += $product_amount;
            }
	        $i++; 
        }
 
        if($vatetype==1){
            if($vatetype2==3){
                $vatetype=1;
                $vat_out = $total*(7/107);
                $sumtotal=$total-$vat_out;  //$total
            }elseif($vatetype2==4){
                $vatetype=2;
                $vat_out = $total*(7/100);
                $sumtotal=$total+$vat_out;
            } 
        }else{
            $vatetype=0;
            $vat_out = 0;
            $sumtotal=$total;
        } 

        $sql = "UPDATE md_billing SET md_billing_total= '".round($total,2)."',md_billing_vat='".round($vat_out,2)."',md_billing_totalprice='".round($sumtotal,2)."',md_billing_vattype='".$vatetype."', md_billing_customerid='".$_REQUEST['customer_resive']."', md_billing_carcode='".$_REQUEST['car_code']."'  WHERE md_billing_id='".$_REQUEST['row_id']."'";
        $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
            
        echo "success";

    }  
    ?>
 

<?php }elseif($_POST["myaction"]=="changestatus"){
	$loaddder=$_POST['Valueloaddder'];
		$statusname=$_POST['Valuestatusname'];
		$statusid=$_POST['Valuestatusid'];
		$loadderstatus=$_POST['Valueloadderstatus'];
		$filestatus=$_POST['Valuefilestatus'];
		$myaction=$_POST['myaction'];
		
		
		if($statusname=="1"){
		$inputstatusname="2";
		}else if($statusname=="2"){
		$inputstatusname="1";
		}
     	$sql = "UPDATE md_billing SET md_billing_status= '$inputstatusname'  WHERE md_billing_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		$sql = "UPDATE md_billing_detail_sell SET md_billing_detail_status= '$inputstatusname'  WHERE md_billing_detail_billingid='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
	?>
    <a href="javascript:void(0)"  onclick="changeStatus('load_mainwaiting','<?php echo $inputstatusname?>','<?php echo $statusid?>','load_status<?php echo $statusid?>','<?php echo $myaction?>')">
    <?php  if($inputstatusname=="1"){?>
         <span class="badge badge-dim badge-outline-success d-none d-md-inline-flex"><?php echo $txt_language["system:status:name"][$inputstatusname]?></span>
    <?php }else{?>
		<span class="badge badge-dim badge-outline-danger d-none d-md-inline-flex"><?php echo $txt_language["system:status:name"][$inputstatusname]?></span>
    <?php }?>
     </a>
<?php }elseif($_POST["myaction"]=="delete"){
	
		for($i=1;$i<=$_POST["TotalCheckBoxID"];$i++) {
            $myVar=$_POST["CheckBoxID".$i];
            if(strlen($myVar)>0) { 
                $permissionID=$myVar;

                $sql_billing = "SELECT * FROM md_billing WHERE md_billing_id='". $permissionID."'";
                $Query_billing=$mysqli->query($sql_billing);
                $Row_billing=$Query_billing->fetch_array();
                if($Row_billing['md_billing_status']==3){
                    $sql_or="DELETE FROM md_order_sell WHERE md_order_billID='".$permissionID."' AND md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' ";
                    $Query_or=$mysqli->query($sql_or)OR DIE("Error sql_or: <br>$sql_or<br>\n");
                }
      
                if($Row_billing['md_billing_status']==1){
                    $code='RX-'.strtotime(date('YmdHis')); //ยกเลิกบิลขาย
                    $md_deposit_amount="ยกเลิกบิลขาย ".$Row_billing['md_billing_number'];

                    $sql_detail="SELECT * FROM md_billing_detail_sell WHERE md_billing_detail_billingid='".$Row_billing['md_billing_id']."' AND md_billing_detail_status='1' ORDER BY md_billing_detail_id ASC";
                    $query_detail=$mysqli->query($sql_detail);  
                    while($row_detail=$query_detail->fetch_array()){
                        
                        $PrevWalletStock = getBalanceWalletStock($row_detail['md_billing_detail_productid']);
                        $BalanceWalletStock = $PrevWalletStock+$row_detail['md_billing_detail_amount'];
                        
                        unset($insert);
                        $insert["md_stock_code"] = "'".$code."'"; 
                        $insert["md_stock_product_id"] = "'".$row_detail['md_billing_detail_productid']."'";
                        $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
                        $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; // "'ลบสต็อกสินค้า จำนวน ".$md_deposit_amount."'";
                        $insert["md_stock_price"] = "'".$row_detail['md_billing_detail_price']."'";
                        $insert["md_stock_deposit"] = "'".$row_detail['md_billing_detail_amount']."'";
                        $insert["md_stock_withdrawal"] = "'0'";
                        $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
                        $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
                        $insert["md_stock_group"] = "'DF'";			 
                        $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
                        $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'";

                        // echo	"sql_insert=".
                        $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                        $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
                    } 
                }


                $sql_bl = "UPDATE md_billing SET md_billing_status= '2',md_billing_updatedate=NOW(),md_billing_updatebyid= '".$_SESSION["core_session_sys_id"]."'  WHERE md_billing_id='". $permissionID."'";
                $Query_bl=$mysqli->query($sql_bl)OR DIE("Error sql_bl: <br>$sql_bl<br>\n");
                
                $sql = "UPDATE md_billing_detail_sell SET md_billing_detail_status= '3'  WHERE md_billing_detail_billingid='". $permissionID."' AND md_billing_detail_status!=2";
                $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");


                if($Row_billing['md_billing_status']==1){
                    $sql_balance = "SELECT md_wallet_balance FROM md_wallet WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
                    $Query_balance=$mysqli->query($sql_balance);
                    $Row_balance=$Query_balance->fetch_array();
                    $PrevWallet=$Row_balance["md_wallet_balance"];
                    
                    $type="CC";
                    $detail="ยกเลิกบิล ".$Row_billing['md_billing_number']." จำนวน ".$Row_billing['md_billing_total'];
                    $deposit=$Row_billing['md_billing_total'];
                    $BalanceWallet=$PrevWallet+$deposit;

                    unset($insert);
                    $insert["md_wallet_code"] = "'".$code."'"; 
                    $insert["md_wallet_detail"] = "'".$detail."'";
                    $insert["md_wallet_deposit"] = "'".$deposit."'";
                    $insert["md_wallet_withdrawal"] = "'".$withdrawal."'";		
                    $insert["md_wallet_prevbalance"] = "'".$PrevWallet."'";	
                    $insert["md_wallet_balance"] = "'".$BalanceWallet."'";	
                    $insert["md_wallet_group"] = "'".$type."'";			 
                    $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_wallet_credate"] = "NOW()";
                    $insert["md_wallet_updatedate"] = "NOW()";
                
                    //echo	"sql_insert=".
                    $sql_insert="INSERT INTO md_wallet(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");


                    // =================
                    $vatetype = $Row_billing['md_billing_vattype'];
                    if($vatetype==1){ 
                        $total2=$Row_billing['md_billing_total'];
                    }elseif($vatetype==2){
                        $total2=$Row_billing['md_billing_totalprice'];
                    }else{
                        $total2=$Row_billing['md_billing_total'];
                    }
                    
                    $sql_bsk = "SELECT md_stockbasket_balance FROM md_stockbasket WHERE md_stockbasket_customerid='".$Row_billing["md_billing_customerid"]."' ORDER BY md_stockbasket_id DESC LIMIT 1";
                    $Query_bsk=$mysqli->query($sql_bsk);
                    $Row_bsk=$Query_bsk->fetch_array();
                    $PrevWallet=$Row_bsk["md_stockbasket_balance"];
                    
                    $outTradeNo= 'SW-'.strtotime(date('YmdHis')); //ตัดหนี้
                    $type="WF";
                    $detail="ยกเลิกบิลขาย ".$Row_billing['md_billing_number']." จำนวน ".$total2." บาท";
                    $withdrawal=$total2;
                    $BalanceWallet=$PrevWallet-$withdrawal;
                   
                    unset($insert);
                    $insert["md_stockbasket_code"] = "'".$outTradeNo."'"; 
                    $insert["md_stockbasket_billingnumber"] ="'".$Row_billing['md_billing_number']."'";
                    $insert["md_stockbasket_customerid"] = "'".$Row_billing["md_billing_customerid"]."'";
                    $insert["md_stockbasket_detail"] = "'".$detail."'";
                    $insert["md_stockbasket_deposit"] = "'0'";
                    $insert["md_stockbasket_withdrawal"] = "'".$withdrawal."'";		
                    $insert["md_stockbasket_prevbalance"] = "'".$PrevWallet."'";	
                    $insert["md_stockbasket_balance"] = "'".$BalanceWallet."'";	
                    $insert["md_stockbasket_group"] = "'".$type."'";			 
                    $insert["md_stockbasket_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_stockbasket_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_stockbasket_credate"] = "NOW()";
                    $insert["md_stockbasket_updatedate"] = "NOW()";
                    //echo	"sql_insert=".
                    $sql_insert="INSERT INTO md_stockbasket(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");

                    // ///////////////
                    $sql_bk = "SELECT md_wallet_balance FROM md_wallet_basket WHERE 1=1 ORDER BY md_wallet_id DESC LIMIT 1";
                    $Query_bk=$mysqli->query($sql_bk);
                    $Row_bk=$Query_bk->fetch_array();
                    $PrevWallet_bk=$Row_bk["md_wallet_balance"];
                    
                    $BalanceWallet_BK=$PrevWallet_bk-$total2;
                    
                    unset($insert);
                    $insert["md_wallet_code"] = "'".$outTradeNo."'"; 
                    $insert["md_wallet_detail"] = "'".$detail."'";
                    $insert["md_wallet_deposit"] = "'0'";
                    $insert["md_wallet_withdrawal"] = "'".$total2."'";		
                    $insert["md_wallet_prevbalance"] = "'".$PrevWallet_bk."'";	
                    $insert["md_wallet_balance"] = "'".$BalanceWallet_BK."'";	
                    $insert["md_wallet_group"] = "'".$type."'";			 
                    $insert["md_wallet_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_wallet_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
                    $insert["md_wallet_credate"] = "NOW()";
                    $insert["md_wallet_updatedate"] = "NOW()";
                    //echo	"sql_insert=".
                    $sql_insert="INSERT INTO md_wallet_basket(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
                    $Query_insert=$mysqli->Query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
                    // =================
                }
            }
        }
    ?>
<?php }elseif($_POST["myaction"]=="deleteproduct"){
	
		for($i=1;$i<=$_POST["TotalCheckBoxID"];$i++) {
		$myVar=$_POST["CheckBoxID".$i];
		if(strlen($myVar)>0) { 
		    $permissionID=$myVar; 
            
            $sql_order = "SELECT * FROM md_order_sell WHERE md_order_id='".$permissionID."' AND md_order_crebyid ='".$_SESSION["core_session_sys_id"]."'";
            $query_order=$mysqli->query($sql_order) or die("Error sql_order:  <br/>$sql_order<br />\n");
            $Row_order=$query_order->fetch_array();
 

            $sql_od="DELETE FROM md_order_sell WHERE md_order_id='".$permissionID."' AND md_order_crebyid ='".$_SESSION["core_session_sys_id"]."'";
            $Query_od=$mysqli->query($sql_od)OR DIE("Error sql_od: <br>$sql_od<br>\n");

            $sql_order_q = "SELECT sum(md_order_total) FROM md_order_sell WHERE md_order_crebyid ='".$_SESSION["core_session_sys_id"]."' AND md_order_billID='".$Row_order['md_order_billID']."'";
            $Query_order_q=$mysqli->query($sql_order_q) OR DIE("Error sql_order_q: <br>$sql_order_q<br>\n");
            $Row_order_q=$Query_order_q->fetch_array();
            
            $sql_bl = "UPDATE md_billing SET md_billing_total= '".round($Row_order_q[0],2)."',md_billing_totalprice= '".round($Row_order_q[0],2)."'  WHERE md_billing_id='".$Row_order['md_order_billID']."'";
            $Query_bl=$mysqli->query($sql_bl)OR DIE("Error sql_bl: <br>$sql_bl<br>\n");

            $sql_dl = "UPDATE md_billing_detail_sell SET md_billing_detail_status= '2'  WHERE md_billing_detail_orderid='".$permissionID."'";
            $Query_dl=$mysqli->query($sql_dl)OR DIE("Error sql_dl: <br>$sql_dl<br>\n");

            // =======================
            $sql_billing = "SELECT * FROM md_billing WHERE md_billing_id='".$Row_order['md_order_billID']."'";
            $Query_billing=$mysqli->query($sql_billing);
            $Row_billing=$Query_billing->fetch_array();
            
            $code='SR-'.strtotime(date('YmdHis')); //ลบสินค้า
            $md_deposit_amount="ลบรายการขายสินค้า billing_number: ".$Row_billing['md_billing_number'];
            $PrevWalletStock = getBalanceWalletStock($Row_order['md_order_productid']);
            $BalanceWalletStock = $PrevWalletStock+$Row_order['md_order_amount'];
            
            unset($insert);
            $insert["md_stock_code"] = "'".$code."'"; 
            $insert["md_stock_product_id"] = "'".$Row_order['md_order_productid']."'";
            $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
            $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; //  
            $insert["md_stock_price"] = "'".$Row_order['md_order_price']."'";
            $insert["md_stock_deposit"] = "'".$Row_order['md_order_amount']."'";
            $insert["md_stock_withdrawal"] = "'0'";
            $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
            $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
            $insert["md_stock_group"] = "'DF'";			 
            $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
            $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'";
            // echo	"sql_insert=".
            $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
            $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
            // =======================

            if($Query_dl){
                echo "success";
            }else{
                echo "error";
            }
		
		}}
    ?>
    
<?php }elseif($_POST["myaction"]=="viewvat"){?>
    <div class="nk-tnx-details">
        <div class="card-inner">
            <div class="row ">
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_vat_p1" name="vatRadio" value="1" checked onclick="showStuff(1)"  class="custom-control-input">
                            <label class="custom-control-label" for="type_vat_p1">คิดภาษี</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">ไม่เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_vat_p2" name="vatRadio" value="2" onclick="showStuff(2)"  class="custom-control-input" >
                            <label class="custom-control-label" for="type_vat_p2">ไม่คิดภาษี</label>
                        </div>
                    </div>
                </div> 
            </div><br>
            <div class="row " id="havetype">
                <div class="col-md-12 col-sm-12">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_vat_p3" name="vatRadio2" value="3" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_vat_p3">vat ใน</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_vat_p4" name="vatRadio2" value="4" class="custom-control-input">
                            <label class="custom-control-label" for="type_vat_p4">vat นอก</label>
                        </div>
                    </div>
                </div> 
            </div>
            <hr>
             
            <div class="row ">
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p0" name="customRadio" value="0" onclick="showStuff2(1)" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_id_p0">เอาหัวใบเสร็จ</label>
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">ไม่เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p2" name="customRadio" value="2" class="custom-control-input"  onclick="showStuff2(2)">
                            <label class="custom-control-label" for="type_id_p2">ไม่เอาหัวใบเสร็จ</label>
                        </div>
                    </div>
                </div> 
            </div><br>
            <div class="row " id="havetype2">
                <div class="col-md-12 col-sm-12">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p3" name="customRadio2" value="3" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_id_p3">วงษ์พาณิชย์</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p4" name="customRadio2" value="4" class="custom-control-input">
                            <label class="custom-control-label" for="type_id_p4">นิติบุคคล</label>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
        <div class="form-group" align="right">
        <!-- printinvoice_sell.php?number=<?php echo $Row["md_billing_number"];?> -->
            <a href="#" class="btn btn-success" data-dismiss="modal"  onclick="modInsertContent_2();"><em class="icon ni ni-printer"></em>  ออกใบเสร็จ</a>
        </div>
    </div><!-- .nk-tnx-details -->  
    <script>
        function showStuff(type) {
            if(type==1){
                document.getElementById('havetype').style.display = 'block';  
            }else{
                document.getElementById('havetype').style.display = 'none';  
            } 
        }
        function showStuff2(type) {
            if(type==1){
                document.getElementById('havetype2').style.display = 'block';  
            }else{
                document.getElementById('havetype2').style.display = 'none';  
            } 
        }
    </script> 

<?php }elseif($_POST["myaction"]=="view"){?>
    <?php
    if($_POST["myContantID"]!=""){
        $sql = "SELECT * FROM md_billing WHERE md_billing_id='".$_POST["myContantID"]."' ";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
    }
    ?>        
    <div class="nk-modal-head mb-3 mb-sm-5">
        <h4 class="nk-modal-title title">รหัสใบเสร็จ<small class="text-primary"> <?php echo $Row["md_billing_number"]?></small></h4>
    </div>
    <div class="nk-tnx-details">
        <div class="nk-block-between flex-wrap g-3">
            <div class="nk-tnx-type">
                <div class="nk-tnx-type-icon bg-<?php echo $txt_mod["billing:color"][$Row["md_billing_status"]];?> text-white" id="modalstatus<?php echo $row["md_deposit_id"]?>">
                    <em class="icon ni ni-arrow-up-right"></em>
                </div>
                <div class="nk-tnx-type-text">
                    <h5 class="title"><?php echo number_format($Row["md_billing_total"],2)?></h5>
                    <span class="sub-text mt-n1"><?php echo ShowDateTimeThai($Row["md_billing_credate"]);?></span>
                </div>
            </div>
            <ul class="align-center flex-wrap gx-3">
                <li>
                <span class="badge badge-sm badge-<?php echo $txt_mod["billing:color"][$Row["md_billing_status"]];?>"> <?php echo $txt_mod["billing:status"][$Row["md_billing_status"]];?></span>
            
                </li>
            </ul>
        </div>
        
        <div class="nk-modal-head mt-sm-5 mt-4 mb-4">
            <h5 class="title">Details</h5>
        </div>
        <div class="row gy-3">
            <div class="col-lg-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col"><span class="sub-text">สินค้า</span></th>
                            <th scope="col"><span class="sub-text">ราคาต่อหน่วย</span></th>
                            <th scope="col"><span class="sub-text">น้ำหนัก</span></th>
                            <th scope="col"><span class="sub-text">ราคารวม</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql_detail = "SELECT * FROM md_billing_detail_sell WHERE md_billing_detail_billingid='".$Row['md_billing_id']."' AND md_billing_detail_status!='2'";
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
            </div>
        </div><!-- .row -->

        <hr />
            <div class="row gy-3" align="right" >
                <div class="col-lg-12">
                    <?php if($Row["md_billing_status"]==1) { ?>                
                        <!-- <a href="#" class="btn btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="พิมพ์ใบเสร็จ" onclick="document.myForm.myContantID.value ='<?php echo $_POST["myContantID"]?>';Viewbill();"><em class="icon ni ni-printer"></em><span>พิมพ์ใบเสร็จ</span></a>&nbsp;&nbsp; -->
                    <?php } ?>
                </div>
            </div>

    </div><!-- .nk-tnx-details -->     
    
<?php }elseif($_POST["myaction"]=="Viewbill"){?>
      
    <div class="nk-tnx-details">
        <div class="card-inner">
            <div class="row ">
                <div class="col-md-4 col-sm-4">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="report_b_0" name="report_b" value="0" onclick="showStuff(1)" checked class="custom-control-input">
                            <label class="custom-control-label" for="report_b_0">สำเร็จ</label>
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">ไม่เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="report_b_1" name="report_b" value="1" class="custom-control-input"  onclick="showStuff(1)">
                            <label class="custom-control-label" for="report_b_1">ยกเลิก</label>
                        </div>
                    </div>
                </div> 
                <div class="col-md-4 col-sm-4">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="report_b_2" name="report_b" value="2" onclick="showStuff(1)"  class="custom-control-input">
                            <label class="custom-control-label" for="report_b_2">ทั้งหมด</label>
                        </div>
                    </div>
                </div>
            </div><br><hr>
            <div class="row " id="havetype">
                <div class="col-md-12 col-sm-12">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_b_3" name="report_b_type" value="3"  class="custom-control-input">
                            <label class="custom-control-label" for="type_report_b_3">เงินสด</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_b_4" name="report_b_type" value="4" class="custom-control-input">
                            <label class="custom-control-label" for="type_report_b_4">เงินโอน</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_b_5" name="report_b_type" value="5" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_report_b_5">ทั้งหมด</label>
                        </div>
                    </div>
                </div> 
            </div><hr>
            <!--<div class="row " id="havetype_vat">
                <div class="col-12">
                    <div class="preview-block">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_vat_6" name="report_vat_type" value="6"  class="custom-control-input">
                            <label class="custom-control-label" for="type_report_vat_6">ไม่คิด vat</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_vat_7" name="report_vat_type" value="7" class="custom-control-input">
                            <label class="custom-control-label" for="type_report_vat_7">คิด vat ใน</label>
                        </div>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_vat_8" name="report_vat_type" value="8" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_report_vat_8">คิด vat นอก</label>
                        </div> 
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_report_vat_9" name="report_vat_type" value="9" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_report_vat_9">ทั้งหมด</label>
                        </div>
                    </div>
                </div> 
            </div>-->
        </div>
        <div class="form-group" align="right"> 
            <!-- href="export_excel_report.php?startdate=<?php echo $_REQUEST["input_startdate"]?>&&enddate=<?php echo $_REQUEST["input_enddate"];?>&&catalog=<?php echo $_REQUEST["input_catalog"]?>" target="_blank" -->
            <a href="#" class="btn btn-primary" onclick="print_billreport('<?php echo $_REQUEST['input_startdate'];?>','<?php echo $_REQUEST['input_enddate'];?>')"><em class="icon ni ni-printer"></em> พิมพ์รายงาน</a>
        </div>
    </div><!-- .nk-tnx-details -->  
    <script>
        function showStuff(type) {
            if(type==1){
                document.getElementById('havetype').style.display = 'block';  
            }else{
                document.getElementById('havetype').style.display = 'none';  
            }
            
        }
    </script>  
<?php }else if($_POST["myaction"]=="modloadproduct"){  ?>  
    <div class="row">
        <div class="col-6 col-sm-6 text-left">
            <div id="InputSearch" class="dataTables_filter">
                <div>
                    <label>ค้นหา</label>
                    <input type="search"   class="form-control form-control-md" placeholder="Type in to Search" aria-controls="InputSearch_p" id="InputSearch_p" name="InputSearch_p" value="<?php echo $_REQUEST["InputSearch_p"]?>" onchange="modLoadsearch(this.value);">
                    <!-- <a href="#" class="btn btn-icon btn-sm btn-primary"><em class="icon ni ni-search"></em></a> -->
                </div><br>
            </div>
        </div>
        <div class="col-6 col-sm-6 text-left">
            <label>ประเภทสินค้า</label>
            <select class="form-select form-control form-control-lg  search_p_too " data-search="on" id="input_catalog"  name="input_catalog" style="margin-top:-10px;" onchange="modLoadtype(this.value,'<?php echo $_REQUEST['my_id'] ?>');">
                <option value="0">ค้นหาประเภทสินค้า</option>
                <?php 
                    $sql_product_type = "SELECT * FROM md_catalog WHERE md_catalog_delete=0"; 
                    $query_product_type=$mysqli->query($sql_product_type) or die("Error sql_product_type: เกิดความผิดพลาด <br>$sql_product_type\n");
                    while($row_product_type=$query_product_type->fetch_array()) { 
                        $row_product_type_id=		$row_product_type["md_catalog_id"];
                        $row_product_type_name=		rechangeQuot($row_product_type["md_catalog_name"]); ?>  

                        <option value="<?php echo $row_product_type_id ?>"  <?php echo ($row_product_type["md_catalog_id"]==$_REQUEST["input_catalog"])?"selected":""?>><?php echo $row_product_type_name ?></option>

                <?php } ?>
            </select>
        </div>
    </div>
 
    <?php
    $sql_custumer = "SELECT * FROM md_customer WHERE md_customer_delete='0' AND md_customer_status='1' AND md_customer_id='".$_REQUEST['my_id']."'";
    $query_custumer=$mysqli->query($sql_custumer) or die("Error sql_custumer: เกิดความผิดพลาด <br>$sql_custumer\n");
    $row_custumer=$query_custumer->fetch_array();

    $sql_cat = "SELECT * FROM md_catalog WHERE md_catalog_status!='2' ";
    if($_REQUEST["input_catalog"]!='' && $_REQUEST["input_catalog"]!=0){
        $sql_cat .= " AND md_catalog_id='".$_REQUEST["input_catalog"]."'";
    }
    $sql_cat .= " ORDER BY md_catalog_name ASC";
    $query_cat=$mysqli->query($sql_cat) or die("Error sql_cat:  <br/>$sql_cat<br />\n");
    while($Row_cat=$query_cat->fetch_array()){
        $sql = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_catalogid='".$Row_cat["md_catalog_id"]."' ";
        if($_REQUEST["InputSearch_p"]!=''){
            $sql .= " AND md_product_name LIKE '%".$_REQUEST["InputSearch_p"]."%'";
        }
        $sql .= "  ORDER BY md_product_name ASC";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $count_totalrecord=$query->num_rows;
        if($count_totalrecord>0){ ?> 
            <div class="nk-tb-item">
                <div class="nk-tb-col tb-col-sm">
                <span class="tb-sub text-success"><h5><?php echo $Row_cat["md_catalog_name"]?></h5></span>
                </div>
                <div class="nk-tb-col tb-col-sm">
                    
                </div>
                <div class="nk-tb-col tb-col-sm">
                    
                </div>
                <div class="nk-tb-col tb-col-sm">
                    
                </div>
                <div class="nk-tb-col tb-col-sm">
                    
                </div> 
            </div> 
            <div class="nk-tb-item nk-tb-head bg-light">
                <div class="nk-tb-col tb-col-sm"><span>รหัสสินค้า</span></div>
                <div class="nk-tb-col tb-col-sm"><span>ชื่อสินค้า</span></div>
                <div class="nk-tb-col tb-col-sm"><span>ราคา/หน่วย</span></div>
                <div class="nk-tb-col tb-col-sm"><span>จำนวนคงเหลือ</span></div>
                <div class="nk-tb-col tb-col-sm"><span>&nbsp;</span></div>
                <!-- <div class="nk-tb-cosl"><span>&nbsp;</span></div> -->
            </div> 
            <?php
            while($Row=$query->fetch_array()){  
                // echo "KK: ".$row_custumer['md_customer_price_type'];
                 
                $priceproduct = $Row['md_product_sell'];
                
                $balance_stock = getBalanceWalletStock($Row['md_product_id']);
                ?>
                <div class="nk-tb-item">
                    <div class="nk-tb-col tb-col-sm">
                        <div class="user-card"> 
                            <a href="#"><span class="tb-sub ml-2">#<?php echo $Row['md_product_code'];?> </span></a>
                        </div>
                    </div>
                    <div class="nk-tb-col tb-col-sm">
                        <div class="user-card"> 
                            <div class="user-name">
                                <span class="tb-lead"><?php echo $Row['md_product_name'];?></span>
                            </div>
                        </div>
                    </div>
                    <div class="nk-tb-col tb-col-sm">
                        <span class="tb-sub"><?php echo $priceproduct;?></span>
                    </div>
                    <div class="nk-tb-col tb-col-sm">
                        <span class="tb-sub tb-amount"><?php echo $balance_stock;?> <span>Kg.</span></span>
                    </div>
                    <div class="nk-tb-col tb-col-sm">
                        <a href="javascript:void(0)" onclick="document.myForm.productid.value ='<?php echo $Row['md_product_id'];?>',document.myForm.product_waletstock.value ='<?php echo $balance_stock;?>';modLoadAddProduct();" class="btn btn-sm btn-wider btn-success" style="display: flex;justify-content: space-around">เลือก</a>
                    </div> 
                </div> 
            <?php 
            } //while($Row=$query->fetch_array()){
        }//if($count_totalrecord>0){
    }//while($Row_cat=$query_cat->fetch_array()){ 
    ?> 
    
    <script >  
        NioApp.Select2('.search_p_too'); 
    </script> 

<?php }else if($_POST["myaction"]=="switchmode"){ 
    if($_SESSION["front_session_sys_mode"]==""){
        $_SESSION["front_session_sys_mode"]="darkmode";
    }else{
        $_SESSION["front_session_sys_mode"]="";
    }?>
<?php }?> 