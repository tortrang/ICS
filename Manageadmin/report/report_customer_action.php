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
  
  $chk_permissionID = getUserPermissionOnMenu($_SESSION["core_session_sys_grpid"],$_REQUEST['menukeyid']);
	
	// Check to set default value #########################
	$module_default_pagesize = 10;
	$module_default_pageshow = 1;
	$module_sort_number = "ASC";
	
	$module_pagesize = $_REQUEST["module_pagesize"];
	$module_pageshow = $_REQUEST["module_pageshow"];
	$module_adesc = $_REQUEST["module_adesc"];
	$module_orderby = $_REQUEST["module_orderby"];
	$InputSearch=trim($_REQUEST["InputSearch"]);
	
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = "md_customer_code"; }
	if($inputSearch!=""){ $inputSearch=trim($inputSearch); }
	
	// SQL SELECT #########################

	
	$sql = "SELECT * FROM md_customer WHERE md_customer_delete='0'";
	if($_REQUEST["InputSearch"]!=""){
		$sql .= " AND (md_customer_name LIKE '%".$_REQUEST["InputSearch"]."%' OR md_customer_code LIKE '%".$_REQUEST["InputSearch"]."%')";
	}
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
                                    <div class="modal fade show"   id="viewbillload">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                 
                                                <div class="modal-body">
                                                    <div id="loadcontentview"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                     
                                       
                                    
                                    <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
                                        	<div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        		<div class="row  g-2">
                                                	<div class="">
                                                    	<input type="text" class="form-control form-control-sm" placeholder="ค้นหา" name="InputSearch" id="InputSearch" value="<?php echo $InputSearch?>" onchange="submitpagelist('search',this.value);">
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
                                                    <!-- <div class="">
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
                                                    </div> -->
                                                    <!-- <div class="">
                                                         <div class="form-group">      
                                                         	<div class="form-control-wrap">        
                                                            	<div class="input-daterange date-picker-range input-group">
                                                                	<input type="text" id="input_startdate" name="input_startdate" class="form-control form-control-sm" value="<?php echo $_REQUEST["input_startdate"];?>" onchange="submitpagelist('startdate',this.value);" />            
                                                                    <div class="input-group-addon">TO</div>            
                                                                    <input type="text" id="input_enddate" name="input_enddate" class="form-control form-control-sm" value="<?php echo $_REQUEST["input_enddate"];?>" onchange="submitpagelist('enddate',this.value);" />        
                                                                </div> 
                                                                  
                                                            </div>
                                                         </div>
                                                    </div> -->
                                                    <div class="">
                                                    	<a href="export_excel_customer_name.php" target="_blank" class="btn btn-sm btn-outline-success"><em class="icon ni ni-printer"></em><span>ออกรายงาน</span></a> 
                                                        <a href="javascript:void(0)" onclick="fnsearch();" class="btn btn-sm btn-primary"><em class="icon ni ni-search"></em><span>ค้นหา</span></a> 
                                                    </div>
                                                    
                                             	</div><!-- .row justify-between g-2 -->
    										<div class="datatable-wrap my-3">
                                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                    	<th class="nk-tb-col tb-col-lg"><span class="sub-text">รหัสลูกค้า</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">ชื่อลูกค้า</span></th> 
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text">เบอร์ติดต่อ</span></th>
                                                        <th class="nk-tb-col tb-col-lg"> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                   

                                                    $index=1;
                                                    $color=0;
                                                    if($count_record>0) {
                                                    while($index<$count_record+1) {
                                                        $row=$query->fetch_array();
                                                        $row_id=		$row["md_customer_id"];
                                                        $row_name=		rechangeQuot($row["md_customer_name"]);
                                                        $row_tel=	$row["md_customer_tel"];
                                                        $row_status=	$row["md_customer_status"];
                                                        $row_code=	$row["md_customer_code"];
                                                        
                                                        $txt_mod["billing:color"] = array('','success','danger');
                                                        $txt_mod["billing:status"]= array('','สำเร็จ','ยกเลิก');
                                                         
                                                        ?>    
                                                        <tr class="nk-tb-item">
                                                            <td class="nk-tb-col">
                                                                <div class="nk-tnx-type">
                                                                    <div class="nk-tnx-type-text">
                                                                        <span class="tb-lead"><?php echo  $row_code;?></span>
                                                                    </div>
                                                            </div>
                                                            </td>
                                                            <td class="nk-tb-col">
                                                                <span><?php echo $row_name; ?></span>
                                                            </td>  
                                                            <td class="nk-tb-col tb-col-md">
                                                                <span><?php echo  $row_tel;?></span>
                                                            </td>
                                                            <td class="nk-tb-col nk-tb-col-tools">
                                                                <ul class="nk-tb-actions gx-2"> 
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="javascript:void(0)" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_language["but:view"]?>" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadView();"><em class="icon ni ni-eye"></em></a>
                                                                    </li> 
                                                                    <li class="nk-tb-action-hidden">
                                                                        <a href="javascript:void(0)" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="<?php echo "ออกรายงาน"?>"   onclick="Viewbill_coustomer('<?php echo $row_id?>');"><em class="icon ni ni-clipboad-check"></em></a>
                                                                    </li>
                                                                    <li>
                                                                        <div class="dropdown">
                                                                            <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <ul class="link-list-opt">
                                                                                    <li><a href="javascript:void(0)" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadView();"><em class="icon ni ni-eye"></em><span><?php echo $txt_language["but:view"]?></span></a></li>
                                                                                    <li><a href="javascript:void(0)"  onclick="Viewbill_coustomer('<?php echo $row_id?>');"><em class="icon ni ni-clipboad-check"></em><span><?php echo "ออกรายงาน"?></span></a></li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </td>

                                                        </tr><!-- .nk-tb-item  -->
                                                            <?php $index++;$color++; 
                                                        }//while($Row=$query->fetch_array()){?>
                                                        <?php }else{?>
                                                    <tr>
                                                        <td class="nk-tb-col" colspan="8" align="center"><?php echo $txt_language["txt:nodata"];?></td>
                                                    </tr><!-- .nk-tb-item  -->

                                                    <?php }//if($count_record>0)  ?>
                            
                             
                                                </tbody>
                                            </table>
                                            </div><!-- .datatable-wrap my-3  -->
                                        
                                        <!-- Modal Form -->
                                        <div class="modal fade" tabindex="-1" id="loadmodal" style=" overflow-y: auto;">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content" id="loadmodalcontent">
                                                    
                                                </div>
                                            </div>
                                        </div>     
                                        <!-- Modal Form -->
                                        <div class="modal fade" tabindex="-1" id="loadmodal_detail" style=" overflow-y: auto;">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content" id="loadmodalcontent_detail">
                                                    
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


<?php }elseif($_POST["myaction"]=="Viewbill_coustomer"){?>
        <?php
            $sql_cus = "SELECT * FROM md_customer WHERE md_customer_id='". $_POST["customer_id"]."'";
            $query_cus=$mysqli->query($sql_cus) or die("Error sql_cus:  <br/>$sql_cus<br />\n");
            $Row_cus=$query_cus->fetch_array();
        ?>
        <div class="modal-header">
            <h5 class="modal-title">รายงานลูกค้า <?php echo $Row_cus['md_customer_name']." (".$Row_cus['md_customer_code'].")"?></h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div> 
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
              </div>
          </div>
          <div class="form-group" align="right"> 
                <a href="#" class="btn btn-primary" onclick="print_billreport('<?php echo $_POST['customer_id'] ?>')"><em class="icon ni ni-printer"></em> พิมพ์รายงาน</a>
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


<?php }elseif($_POST["myaction"]=="view"){?>
            <?php
                $sql_cus = "SELECT * FROM md_customer WHERE md_customer_id='". $_POST["myContantID"]."'";
                $query_cus=$mysqli->query($sql_cus) or die("Error sql_cus:  <br/>$sql_cus<br />\n");
                $Row_cus=$query_cus->fetch_array();

                $sql = "SELECT * FROM md_billing WHERE md_billing_customerid='". $_POST["myContantID"]."' order by md_billing_id DESC"; 
                $query=$mysqli->query($sql) or die("Error sql: เกิดความผิดพลาด <br>$sql\n");
                $count_record=$query->num_rows;

            ?>
                <div class="modal-header">
                    <h5 class="modal-title">รายการซื้อ <?php echo $Row_cus['md_customer_name']." (".$Row_cus['md_customer_code'].")"?></h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body" >
                    <div class="card card-preview">
                        <div class="card-inner">
                            <ul class="nav nav-tabs mt-n3">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabItem1">บิลซื้อ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabItem2">บิลขาย</a>
                                </li> 
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabItem1">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head"> 
                                                <th class="nk-tb-col"><span class="sub-text">รหัสใบเสร็จ</span></th>  
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">ชื่อลูกค้า</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">จำนวนเงิน</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">การชำระเงิน</span></th>
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
                                            ?>    
                                                <tr class="nk-tb-item"> 
                                                    <td class="nk-tb-col">
                                                        
                                                        <span class="tb-lead"><a href="#" onclick="modLoadView_detail('<?php echo $row_id?>');"><?php echo $row["md_billing_number"];?></a></span>
                
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
                                            }//if($count_record>0) { ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="tabItem2">
                                    <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                        <thead>
                                            <tr class="nk-tb-item nk-tb-head"> 
                                                <th class="nk-tb-col"><span class="sub-text">รหัสใบเสร็จ</span></th>  
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">ชื่อลูกค้า</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">จำนวนเงิน</span></th>
                                                <th class="nk-tb-col"><span class="sub-text">การชำระเงิน</span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">วันที่</span></th>
                                                
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">หมายเหตุ</span></th> 
                                                <th class="nk-tb-col tb-col-lg"><span class="sub-text">เจ้าหน้าที่</span></th> 
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_sell = "SELECT * FROM md_billing_sell WHERE md_billing_customerid='". $_POST["myContantID"]."' order by md_billing_id DESC"; 
                                            $query_sell=$mysqli->query($sql_sell) or die("Error sql_sell: เกิดความผิดพลาด <br>$sql_sell\n");
                                            $count_record_sell=$query_sell->num_rows;
                                            $index_sell=1;
                                            $color_sell=0;
                                            $per=0;
                                            if($count_record_sell>0) {
                                            while($index_sell<$count_record_sell+1) {
                                                $row=$query_sell->fetch_array();
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
                                            ?>    
                                                <tr class="nk-tb-item"> 
                                                    <td class="nk-tb-col">
                                                        
                                                        <span class="tb-lead"><a href="#" onclick="modLoadView_detail_sell('<?php echo $row_id?>');"><?php echo $row["md_billing_number"];?></a></span>
                
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
                
                                                <?php $index_sell++;$color_sell++; 
                                            }//while($row=$query->fetch_array()){
                                            }//if($count_record>0) { ?>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                        </div>
                    </div><!-- .card-preview -->      
                    <hr />
                    <div class="form-group" align="center"><button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">ปิด</button></div>
                </div>
             

<?php }elseif($_POST["myaction"]=="Viewbill"){?>
    <?php
    if($_POST["myContantID"]!=""){
        $sql = "SELECT * FROM md_billing WHERE md_billing_id='".$_POST["myContantID"]."'";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
    }
    ?>        
    <div class="nk-modal-head mb-3 mb-sm-5">
        <h4 class="nk-modal-title title">รหัสใบเสร็จ<small class="text-primary"> <?php echo $Row["md_billing_number"]?></small></h4>
    </div>
    <div class="nk-tnx-details">
        <div class="card-inner">
            <div class="row ">
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p0" name="customRadio" value="0" onclick="showStuff(1)" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_id_p0">เอาหัวใบเสร็จ</label>
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">ไม่เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p2" name="customRadio" value="2" class="custom-control-input"  onclick="showStuff(2)">
                            <label class="custom-control-label" for="type_id_p2">ไม่เอาหัวใบเสร็จ</label>
                        </div>
                    </div>
                </div> 
            </div><br>
            <div class="row " id="havetype">
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
        <!-- printinvoice.php?number=<?php echo $Row["md_billing_number"];?> -->
            <a href="#"   class="btn btn-primary" onclick="printinvoice('<?php echo $Row['md_billing_number'];?>')"><em class="icon ni ni-printer"></em>  พิมพ์ใบเสร็จ</a>
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

<?php }elseif($_POST["myaction"]=="Viewbill_sell"){?>
    <?php
    if($_POST["myContantID"]!=""){
        $sql = "SELECT * FROM md_billing_sell WHERE md_billing_id='".$_POST["myContantID"]."'";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
    }
    ?>        
    <div class="nk-modal-head mb-3 mb-sm-5">
        <h4 class="nk-modal-title title">รหัสใบเสร็จ<small class="text-primary"> <?php echo $Row["md_billing_number"]?></small></h4>
    </div>
    <div class="nk-tnx-details">
        <div class="card-inner">
            <div class="row ">
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p0" name="customRadio" value="0" onclick="showStuff(1)" checked class="custom-control-input">
                            <label class="custom-control-label" for="type_id_p0">เอาหัวใบเสร็จ</label>
                                
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="preview-block">
                        <!-- <span class="preview-title overline-title">ไม่เอาหัวใบเสร็จ</span> -->
                        <div class="custom-control custom-radio">
                            <input type="radio" id="type_id_p2" name="customRadio" value="2" class="custom-control-input"  onclick="showStuff(2)">
                            <label class="custom-control-label" for="type_id_p2">ไม่เอาหัวใบเสร็จ</label>
                        </div>
                    </div>
                </div> 
            </div><br>
            <div class="row " id="havetype">
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
        <!-- printinvoice.php?number=<?php echo $Row["md_billing_number"];?> -->
            <a href="#"   class="btn btn-primary" onclick="printinvoice_sell('<?php echo $Row['md_billing_number'];?>')"><em class="icon ni ni-printer"></em>  พิมพ์ใบเสร็จ</a>
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


<?php }elseif($_POST["myaction"]=="modLoadView_detail"){?>
    <div class="modal fade show"   id="viewbillload_2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">พิมพ์ใบเสร็จ</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <div id="loadcontentview_2"></div>
                </div>
            </div>
        </div>
    </div>  
    
    <?php
    if($_POST["row_id"]!=""){
        $sql = "SELECT * FROM md_billing WHERE md_billing_id='".$_POST["row_id"]."' ";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
        
    }
    ?>        
    <div class="modal-header">
        <div class="nk-modal-head mb-3 mb-sm-5">
            <h4 class="nk-modal-title title">รหัสใบเสร็จ<small class="text-primary"> <?php echo $Row["md_billing_number"]?></small></h4>
        </div>
    </div>
    <div class="modal-body" >
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
                    <li> 
                        <a href="javascript:void(0)"  class="btn btn-sm btn-primary" onclick="document.myForm.myContantID.value ='<?php echo $_POST['row_id']?>';Viewbill();"><em class="icon ni ni-printer"></em><span>พิมพ์ใบเสร็จ</span></a>
                    </li>
                </ul>
            </div>
            
            <div class="nk-modal-head mt-sm-5 mt-4 mb-4">
                <h5 class="title">Details</h5>
                <?php if($Row["md_billing_cancel_detail"]!=''){ ?>
                    <p> <B class="title">หมายเหตุ : </B> <?php echo $Row["md_billing_cancel_detail"]?></p>
                <?php } ?>
            </div>
            <div class="row gy-3">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><span class="sub-text">รหัสสินค้า</span></th>
                                <th scope="col"><span class="sub-text">สินค้า</span></th>
                                <th scope="col"><span class="sub-text">ราคาต่อหน่วย</span></th>
                                <th scope="col"><span class="sub-text">น้ำหนัก</span></th>
                                <th scope="col"><span class="sub-text">ราคารวม</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sql_detail = "SELECT * FROM md_billing_detail WHERE md_billing_detail_billingid='".$Row['md_billing_id']."' AND md_billing_detail_status!='2'";
                                $query_detail=$mysqli->query($sql_detail) or die("Error sql_detail:  <br/>$sql_detail<br />\n");
                                while($Row_detail=$query_detail->fetch_array()){

                                    $sql_p = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_id='".$Row_detail['md_billing_detail_productid']."'";
                                    $query_p=$mysqli->query($sql_p) or die("Error sql_p:  <br/>$sql_p<br />\n");
                                    $Row_p=$query_p->fetch_array();
                                    
                                    $reson ="";
                                    $inout = "";
                                    $a_inout = "";
                                    
                                    if($Row_detail['md_billing_detail_amount_in']!=0 && $Row_detail['md_billing_detail_amount_out']!=0){
                                        $inout = " (".$Row_detail['md_billing_detail_amount_in']." - ".$Row_detail['md_billing_detail_amount_out'].")";
                                        $a_inout = $Row_detail['md_billing_detail_amount_in']-$Row_detail['md_billing_detail_amount_out'];
                                    }
                                    if($Row_detail['md_billing_detail_reason']!=''){
                                        $reson .= $Row_detail['md_billing_detail_reason'];
                                    }
                                    if($Row_detail['md_billing_detail_amount_deff']!=0){
                                        $reson .= " หัก ".number_format($Row_detail['md_billing_detail_amount_deff'],2)." กก.";
                                    }
                                    
                            ?>
                            <tr>
                                <th scope="row"><?php echo $Row_p['md_product_code'] ?></th>
                                <!-- <th scope="row"><?php echo getProductName($Row_detail['md_billing_detail_productid'])."  ".$Row_detail['md_billing_detail_reason']?></th> -->
                                <th scope="row"><?php echo getProductName($Row_detail['md_billing_detail_productid']) ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $inout." ".$a_inout."  ".$reson?></th>
                                <td><?php echo number_format($Row_detail["md_billing_detail_price"],2);?></td>
                                <td><?php echo $Row_detail["md_billing_detail_amount"];?></td>
                                <td><?php echo number_format($Row_detail["md_billing_detail_total"],2);?></td>
                            </tr>
                            <?php }?>
                            <?php if($Row["md_billing_discount"]!=0){ ?>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <td></td>
                                    <td>ส่วนลด</td>
                                    <td><?php echo number_format($Row["md_billing_discount"],2);?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <td></td>
                                <td>ราคารวมสุทธิ</td>
                                <td><?php echo  number_format($Row["md_billing_total"],2);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- .row -->
            <hr />
            <div class="form-group" align="center"><button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">ปิด</button></div>

            
        </div><!-- .nk-tnx-details -->   
    </div>
        
 
<?php }elseif($_POST["myaction"]=="modLoadView_detail_sell"){?>
    <div class="modal fade show"   id="viewbillload_2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">พิมพ์ใบเสร็จ</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <div id="loadcontentview_2"></div>
                </div>
            </div>
        </div>
    </div>  
    
    <?php
    if($_POST["row_id"]!=""){
        $sql = "SELECT * FROM md_billing_sell WHERE md_billing_id='".$_POST["row_id"]."' ";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
        
    }
    ?>        
    <div class="modal-header">
        <div class="nk-modal-head mb-3 mb-sm-5">
            <h4 class="nk-modal-title title">รหัสใบเสร็จ<small class="text-primary"> <?php echo $Row["md_billing_number"]?></small></h4>
        </div>
    </div>
    <div class="modal-body" >
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
                    <li> 
                        <a href="javascript:void(0)"  class="btn btn-sm btn-primary" onclick="document.myForm.myContantID.value ='<?php echo $_POST['row_id']?>';Viewbill_sell();"><em class="icon ni ni-printer"></em><span>พิมพ์ใบเสร็จ</span></a>
                    </li>
                </ul>
            </div>
            
            <div class="nk-modal-head mt-sm-5 mt-4 mb-4">
                <h5 class="title">Details</h5>
                <?php if($Row["md_billing_cancel_detail"]!=''){ ?>
                    <p> <B class="title">หมายเหตุ : </B> <?php echo $Row["md_billing_cancel_detail"]?></p>
                <?php } ?>
            </div>
            <div class="row gy-3">
                <div class="col-lg-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><span class="sub-text">รหัสสินค้า</span></th>
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

                                    $sql_p = "SELECT * FROM md_product WHERE md_product_delete!='1' AND md_product_status!='2' AND md_product_id='".$Row_detail['md_billing_detail_productid']."'";
                                    $query_p=$mysqli->query($sql_p) or die("Error sql_p:  <br/>$sql_p<br />\n");
                                    $Row_p=$query_p->fetch_array();
                                    
                                    $reson ="";
                                    $inout = "";
                                    $a_inout = "";
                                    
                                    if($Row_detail['md_billing_detail_amount_in']!=0 && $Row_detail['md_billing_detail_amount_out']!=0){
                                        $inout = " (".$Row_detail['md_billing_detail_amount_in']." - ".$Row_detail['md_billing_detail_amount_out'].")";
                                        $a_inout = $Row_detail['md_billing_detail_amount_in']-$Row_detail['md_billing_detail_amount_out'];
                                    }
                                    if($Row_detail['md_billing_detail_reason']!=''){
                                        $reson .= $Row_detail['md_billing_detail_reason'];
                                    }
                                    if($Row_detail['md_billing_detail_amount_deff']!=0){
                                        $reson .= " หัก ".number_format($Row_detail['md_billing_detail_amount_deff'],2)." กก.";
                                    }
                                    
                            ?>
                            <tr>
                                <th scope="row"><?php echo $Row_p['md_product_code'] ?></th>
                                <!-- <th scope="row"><?php echo getProductName($Row_detail['md_billing_detail_productid'])."  ".$Row_detail['md_billing_detail_reason']?></th> -->
                                <th scope="row"><?php echo getProductName($Row_detail['md_billing_detail_productid']) ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $inout." ".$a_inout."  ".$reson?></th>
                                <td><?php echo number_format($Row_detail["md_billing_detail_price"],2);?></td>
                                <td><?php echo $Row_detail["md_billing_detail_amount"];?></td>
                                <td><?php echo number_format($Row_detail["md_billing_detail_total"],2);?></td>
                            </tr>
                            <?php }?>
                            <?php if($Row["md_billing_discount"]!=0){ ?>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <td></td>
                                    <td>ส่วนลด</td>
                                    <td><?php echo number_format($Row["md_billing_discount"],2);?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <td></td>
                                <td>ราคารวมสุทธิ</td>
                                <td><?php echo  number_format($Row["md_billing_total"],2);?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- .row -->
            <hr />
            <div class="form-group" align="center"><button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">ปิด</button></div>

            
        </div><!-- .nk-tnx-details -->   
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