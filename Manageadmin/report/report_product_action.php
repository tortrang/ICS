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
			<form action="" method="post" name="myForm" id="myForm" enctype="multipart/form-data">
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
            <input name="InputSearchName" type="hidden" id="InputSearchName" value="<?php echo $_REQUEST["InputSearchName"]?>" /> 
           
<?php
  
    $chk_permissionID = getUserPermissionOnMenu($_SESSION["front_session_sys_grpid"],$_REQUEST['menukeyid']);
	
	// Check to set default value #########################
	$module_default_pagesize = 50;
	$module_default_pageshow = 1;
	$module_sort_number = "ASC";
	
	$module_pagesize = $_REQUEST["module_pagesize"];
	$module_pageshow = $_REQUEST["module_pageshow"];
	$module_adesc = $_REQUEST["module_adesc"];
	$module_orderby = $_REQUEST["module_orderby"];
	$InputSearchName=trim($_REQUEST["InputSearch"]);
	$input_api = $_REQUEST["input_api"];
	
	if($input_api==""){ $input_api = "2"; }
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = "md_product.md_product_code"; }
	if($InputSearchName!=""){ $InputSearchName=trim($InputSearchName); }
	
	// SQL SELECT #########################
    
    $sql = "SELECT *,sum(md_billing_detail.md_billing_detail_amount)  as sumamount FROM md_billing_detail LEFT JOIN md_product ON md_billing_detail_productid=md_product_id   WHERE md_billing_detail_status='1' ";
	 
	if($_REQUEST["input_catalog"]!="") {
        $sql .= " AND (md_product.md_product_catalogid = '".$_REQUEST["input_catalog"]."')"; 
	} 

	if($InputSearchName!=""){  
		$sql .= " AND (md_product.md_product_code LIKE '%".$InputSearchName."%')";
	}
 
	if($_REQUEST["input_startdate"]!="" && $_REQUEST["input_enddate"]!=""){
		$sql .= " AND md_billing_detail.md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["input_startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["input_enddate"])." 23:59:59'";
	}

    $sql .= "  GROUP BY md_billing_detail.md_billing_detail_productid ";
    
    /*if($_REQUEST["input_catalog"]==14){
        $type_cc = "ลัง";
    }elseif($_REQUEST["input_catalog"]==18){
        $type_cc = "ใบ";
    }else{
        $type_cc = "กก.";
    }*/
	$type_cc = "กก.";

	$query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
    $query_sum=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
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
    // echo $sql;
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
                                    
                                    
                                    
                                    <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
                                        	<div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        		<div class="row justify-between g-2">
                                                	<div class="">
                                                    	<input type="text" class="form-control form-control-sm" placeholder="ค้นหา" name="InputSearch" id="InputSearch" value="<?php echo $InputSearchName?>" onchange="submitpagelist('search',this.value);">
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
                                                                    $sql_branch = "SELECT * FROM md_catalog WHERE md_catalog_status='1' AND md_catalog_delete='0'";
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
                                                    	<a href="export_excel_product.php?startdate=<?php echo $_REQUEST["input_startdate"]?>&&enddate=<?php echo $_REQUEST["input_enddate"];?>&&catalog=<?php echo $_REQUEST["input_catalog"]?>" target="_blank" class="btn btn-sm btn-outline-success"><em class="icon ni ni-printer"></em><span>ออกรายงาน</span></a> 
                                                        <a href="javascript:void(0)" onclick="fnsearch();" class="btn btn-sm btn-primary"><em class="icon ni ni-search"></em><span>ค้นหา</span></a> 
                                                       
                                                    </div>
                                                    
                                             	</div><!-- .row justify-between g-2 -->
    										<div class="datatable-wrap my-3">
                                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                    	<th class="nk-tb-col tb-col-lg"><span class="sub-text">รหัสสินค้า</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">ชื่อสินค้า</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">ราคา (เฉลี่ย)</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">จำนวน (<?php echo $type_cc ?>)</span></th>
                                                         
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // while($row=$query_sum->fetch_array()) { 
                                                    //     $total_amount += $row['sumamount'];
                                                    // }

                                                    $index=1;
                                                    $color=0;
                                                    if($count_record>0) {
                                                    while($index<$count_record+1) {
                                                        $row=$query->fetch_array();
                                                        $row_id=		$row["md_billing_detail_id"];
                                                        $row_status=	$row["md_billing_detail_status"];
                                                        
                                                        $txt_mod["billing:color"] = array('','success','danger');
                                                        $txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก');
                                                        
                                                        if($_REQUEST["input_startdate"]=='' && $_REQUEST["input_enddate"]==''){
                                                            $sqlpricedate = "";
                                                        }else{
                                                            $sqlpricedate = " AND (md_billing_detail_credate BETWEEN '".DateFormatInsertRe_1($_REQUEST["input_startdate"])." 00:00:00' AND '".DateFormatInsertRe_1($_REQUEST["input_enddate"])." 23:59:59')";
                                                        }

                                                        $sql_price = "SELECT * FROM md_billing_detail WHERE md_billing_detail_status='1' AND md_billing_detail_productid = '".$row["md_billing_detail_productid"]."' $sqlpricedate"; 
                                                        // echo "<br>".$sql_price; 
                                                        $query_price=$mysqli->query($sql_price) or die("Error sql_price: เกิดความผิดพลาด <br>$sql_price\n");
                                                        $avg_sum =0;
                                                        $avg_count =0;
                                                        while($row_price=$query_price->fetch_array()) {
                                                            // echo "<br>id: ".$row_price["md_billing_detail_productid"]." p:".$row_price["md_billing_detail_price"];
                                                            $avg_sum += $row_price["md_billing_detail_price"];
                                                            $avg_count++;
                                                        }
                                                        $avg_price =  $avg_sum/$avg_count;
                                                        // echo "<br>id: ".$row["md_billing_detail_productid"]." avg: ".$avg_price;
                                                        ?>    
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col">
                                                                <div class="nk-tnx-type">
                                                                    <div class="nk-tnx-type-text">
                                                                        <span class="tb-lead"><?php echo  getProductCode($row["md_billing_detail_productid"]);?></span>
                                                                    </div>
                                                            </div>
                                                            </td>
                                                            <td class="nk-tb-col">
                                                                <span><?php echo getProductName($row["md_billing_detail_productid"]);?></span>
                                                            </td> 
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span><?php echo  number_format($avg_price,3);?></span> 
                                                            </td>
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span><?php echo  number_format($row['sumamount'],3);?></span>
                                                            </td>
                                                            
                                                        </tr><!-- .nk-tb-item  -->
                                                            <?php $index++;$color++; 
                                                        }//while($Row=$query->fetch_array()){?>
                                                        <?php }else{?>
                                                    <tr>
                                                        <td class="nk-tb-col" colspan="8" align="center"><?php echo $txt_language["txt:nodata"];?></td>
                                                    </tr><!-- .nk-tb-item  -->

                                                    <?php }//if($count_record>0)  ?>
                                                    
                                                    <!-- <tr class="nk-tb-item">
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
                                                                    <span class="tb-lead" id="sum_amount"><?php echo number_format($total_amount,2);?></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>  -->
                             
                                                </tbody>
                                            </table>
                                            </div><!-- .datatable-wrap my-3  -->
                                        
                                        <!-- Modal Form -->
                                        <div class="modal fade" tabindex="-1" id="loadmodal">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content" id="loadmodalcontent">
                                                    
                                                </div>
                                            </div>
                                        </div>     
                            
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
                                        
                                        </div><!-- .card-inner -->
                                      </div><!-- .card-preview -->
                                    </div><!-- .nk-block-head-content -->                  
                            </div><!-- .nk-block -->
</form>
<script type="text/javascript">
$('.input-daterange').datepicker({
    format: 'dd/mm/yyyy'
});
</script>
<?php }elseif($_POST["myaction"]=="addnew"){?>    
<?php }elseif($_POST["myaction"]=="insert"){?>  
<?php
					
					
}elseif($_POST["myaction"]=="changestatus"){
	$loaddder=$_POST['Valueloaddder'];
		$statusname=$_POST['Valuestatusname'];
		$statusid=$_POST['Valuestatusid'];
		$loadderstatus=$_POST['Valueloadderstatus'];
		$filestatus=$_POST['Valuefilestatus'];
		
		
		if($statusname=="1"){
		$inputstatusname="2";
		}else if($statusname=="2"){
		$inputstatusname="3";
		}else if($statusname=="3"){
		$inputstatusname="4";
		}
     	$sql = "UPDATE md_billing_detail SET md_billing_detail_status= '$inputstatusname'  WHERE md_billing_detail_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
	?>
    <a href="javascript:void(0)"  onclick="changeStatus('load_mainwaiting','<?php echo $inputstatusname?>','<?php echo $statusid?>','load_status<?php echo $statusid?>','<?php echo $myaction?>')">
    <?php  if($inputstatusname=="3"){?>
         <span class="tb-status text-success"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
	<?php  }else if($inputstatusname=="1"){?>   
		<span class="tb-status text-warning"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
        <?php  }else if($inputstatusname=="2"){?>   
		<span class="tb-status text-warning"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
    <?php }else{?>
		<span class="tb-status text-danger"><?php echo $txt_mod["financial:status"][$inputstatusname]?></span>
    <?php }?>
     </a>
<?php }elseif($_POST["myaction"]=="delete"){
		/*for($i=1;$i<=$TotalCheckBoxID;$i++) {
		$myVar="CheckBoxID".$i;
		if(strlen($$myVar)>0) {
		 $permissionID=$$myVar;
		
		 $sql="DELETE FROM sys_staff WHERE staff_id=".$permissionID." ";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		}}*/
?>
<?php }elseif($_POST["myaction"]=="view"){?>
            <?php
             $sql = "SELECT * FROM md_billing_detail WHERE md_billing_detail_id='". $_POST["myContantID"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			 ?>
            	 <div class="modal-header">
                    <h5 class="modal-title">รหัสการทำรายการ <?php echo $Row['md_billing_detail_number']?></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                   <table class="table table-hover table-striped table-data-list-button">
                    <tbody>
                    	<tr>
                            <td>Tracking</td>
                            <td class="info-name"><?php echo $Row['md_billing_detail_label']?></td>
                        </tr>
                        <tr>
                            <td>ชื่อ</td>
                            <td class="info-name"><?php echo $Row['md_billing_detail_toname']?></td>
                        </tr>
                        <tr>
                            <td>ที่อยู่</td>
                            <td class="info-name"><?php echo $Row['md_billing_detail_toaddress1']." ".$Row['md_billing_detail_todistrict']." ".$Row['md_billing_detail_tocity']." ".$Row['md_billing_detail_toprovince']." ".$Row['md_billing_detail_topostcode']?></td>
                        </tr>
                        <tr>
                            <td>เบอร์โทร</td>
                            <td class="info-name"><?php echo $Row['md_billing_detail_tophone']?></td>
                        </tr>
                        <tr>
                            <td>การขนส่ง</td>
                            <td class="info-name"><?php echo getAPIName($Row['md_billing_detail_api'])?></td>
                        </tr>
                        <tr>
                            <td>ยอดเก็บเงินปลายทาง</td>
                            <td class="info-name"><?php echo number_format($Row['md_billing_detail_codprice'],2)?></td>
                        </tr>
                        <tr>
                            <td>ค่าธรรมเนียม</td>
                            <td class="info-name"><?php echo number_format($Row['md_billing_detail_codfee']+$Row['md_billing_detail_codfeecom']+$Row['md_billing_detail_codfeecombranch'],2);?></td>
                        </tr>
                        <tr>
                            <td>วันที่ส่ง</td>
                            <td class="info-name"><?php echo ShowDateTimeThai($Row['md_billing_detail_credate'],2)?></td>
                        </tr>
                        <tr>
                            <td>วันที่สำเร็จ</td>
                            <td class="info-name"><?php echo ShowDateTimeThai($Row['md_billing_detail_updatedate'],2)?></td>
                        </tr>
                        <tr>
                            <td>สถานะ</td>
                            <td class="info-name"><span class='badge badge-dim badge-outline-<?php echo $txt_mod["order:color"][$Row["md_billing_detail_status"]];?> d-none d-md-inline-flex'><?php echo $txt_mod["order:status"][$Row["md_billing_detail_status"]];?></span></td>
                        </tr>
                        <?php if($Row["md_billing_detail_cod"]==1){?>
                         <tr>
                            <td>ข้อมูลทางบัญชี</td>
                            <td class="info-name"><?php 
							$sql_cod = "SELECT * FROM md_cod WHERE md_cod_phone='".$Row["md_billing_detail_phone"]."'";
							$query_cod=$mysqli->query($sql_cod) or die("Error sql_cod: เกิดความผิดพลาด <br>$sql\_codn");
							$Row_cod=$query_cod->fetch_array();
							echo getBankName($Row_cod['md_cod_bankid'])."<br> ชื่อบัญชี : ".$Row_cod['md_cod_bankaccount']." <br>เลขบัญชี : ".$Row_cod['md_cod_banknumber']."<br> สาขา : ".$Row_cod['md_cod_bankbranch'];?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                    </table>
                    <hr />
                    <div class="form-group" align="center"><button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">ปิด</button></div>
                </div>
                
             
<?php }elseif($_POST["myaction"]=="reject"){
	$sql_updat = "UPDATE md_billing_detail SET md_billing_detail_status= '3'  WHERE md_billing_detail_id='".$_POST["myContantID"]."'";
	$Query_updat=$mysqli->query($sql_updat)OR DIE("Error sql: <br>$sql_updat<br>\n");
?>
<?php }else if($_POST["myaction"]=="switchmode"){ 
 if($_SESSION["front_session_sys_mode"]==""){
	 $_SESSION["front_session_sys_mode"]="darkmode";
 }else{
	 $_SESSION["front_session_sys_mode"]="";
 }?>
<?php }?> 