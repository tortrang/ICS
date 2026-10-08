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
$txt_mod["financial:color"] = array('','warning','success','danger');
$txt_mod["financial:walletgroup"] = array('DF'=>'เข้าสต็อก','WF'=>'ออกสต็อก','BL'=>'ออกบิล','CC'=>'ยกเลิกบิล');
$txt_mod["financial:walletgroupcolor"] = array('DF'=>'success','WF'=>'danger','BL'=>'warning','CC'=>'primary');
$txt_mod["financial:walletgroupicon"] = array('DF'=>'ni-arrow-down-right','WF'=>'ni-arrow-up-right','BL'=>'ni-arrow-up-right','CC'=>'ni-arrow-down-right');
?>
<?php if($_POST["myaction"]=="datalist"){?>
<script type="text/javascript">
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
		document.myForm.input_typeincome.value=value;	   
	}else{
		document.myForm.InputSearch.value=value;
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
	if($module_orderby==""){ $module_orderby = "md_income_id"; }
	if($inputSearch!=""){ $inputSearch=trim($inputSearch); }
	
	// SQL SELECT #########################

	
	$sql = "SELECT * FROM md_income WHERE 1=1";
    if($_REQUEST["input_startdate"]!="" && $_REQUEST["input_enddate"]!=""){
        $sql .= " AND md_income_date BETWEEN '".DateFormatInsertRe_1($_REQUEST["input_startdate"])."' AND '".DateFormatInsertRe_1($_REQUEST["md_income_date"])."'";
    }
	if($_REQUEST["input_typeincome"]!=""){
		$sql .= " AND md_income_typeid='".$_REQUEST["input_typeincome"]."'";
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
                                             <?php if($chk_permissionID="RW"){?>
                                            <div class="nk-block-head-content">
                                                <div class="toggle-wrap nk-block-tools-toggle">
                                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    <div class="toggle-expand-content" data-content="pageMenu">
                                                        <ul class="nk-block-tools g-3">
                                                            <li><a href="javascript:void(0)" class="btn btn-primary" onclick="document.myForm.myContantID.value ='';modLoadAddNew();"><em class="icon ni ni-plus"></em><span><?php echo $txt_language["but:addnew"]?></span></a></li>
                                                            <li><a href="javascript:void(0)" class="btn btn-danger" onclick="if(Paging_CountChecked('CheckBoxID',document.myForm.TotalCheckBoxID.value)&gt;0) { if(confirm('คุณต้องการลบข้อมูลหรือไม่?')) {modDeleteContant();}}else{alert('กรุณาเลือกข้อมูลที่จะลบ');}"><em class="icon ni ni-trash-alt"></em><span><?php echo $txt_language["but:delete"]?></span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head-content -->
                                            <?php }?>
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .nk-block-head -->
   
                                    <!-- Modal Form -->
                                        <div class="modal fade" tabindex="-1" id="loadmodal">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">รายการสินค้า</h5>
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
    
                                    <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
    										<div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        		<div class="row justify-between g-2"> 
                                                    <div class="col-12 col-sm-9 text-left" style="display: inline-block;">
                                                        <div id="InputSearch" class="dataTables_filter" style="display: inline-block;">
                                                            <label>
                                                                <input type="search" class="form-control form-control-sm" placeholder="Type in to Search" aria-controls="InputSearch" id="InputSearch" name="InputSearch" value="<?php echo $InputSearch?>" onchange="submitpagelist('search',this.value);">
                                                            </label>
                                                        </div> 
                                                       
                                                        <div class="form-control-select" style="display: inline-block;"> 
                                                            <select name="input_typeincome" id="input_typeincome" class="custom-select  form-control  " onchange="submitpagelist('catalog',this.value);">
                                                                    <option value="">เลือกประเภทรายจ่าย</option>
                                                                <?php
                                                                    echo $sql_catalog = "SELECT * FROM md_typeincome WHERE md_typeincome_status='1'";
                                                                    $Query_catalog=$mysqli->query($sql_catalog) OR DIE("Error sql_catalog: <br>$sql_catalog<br>\n");
                                                                    while($Row_catalog=$Query_catalog->fetch_array()){
                                                                    $Row_catalog_id=$Row_catalog['md_typeincome_id'];
                                                                    $Row_catalog_name=$Row_catalog['md_typeincome_name'];									
                                                                ?>
                                                                <option value="<?php echo $Row_catalog_id?>" <?php echo ($Row_catalog["md_typeincome_id"]==$_REQUEST["input_typeincome"])?"selected":""?>><?php echo $Row_catalog_name?></option>
                                                                <?php }?>
                                                            </select> 
                                                        </div> 
                                                        <div class="" style="display: inline-block;">
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
                                                        <div class="form-control-select" style="display: inline-block;"> 
                                                            <a href="javascript:void(0)"  class="btn btn-md btn-primary" onclick="submitpagelist();"><em class="icon ni ni-search"></em><span>ค้นหา</span></a>
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
                                                        <th class="nk-tb-col"><span class="sub-text">วันที่</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">ชื่อรายจ่าย</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">จำนวนเงิน</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">รายละเอียด</span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_language["txt:status"]?></span></th>
                                                        
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_language["but:lastedit"]?></span></th>
                                                        <th class="nk-tb-col nk-tb-col-tools text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
				$index=1;
				$color=0;
                if($count_record>0) {
				while($index<$count_record+1) {
					$row=$query->fetch_array();
					$row_id=		$row["md_income_id"];
					$row_name=		getTypeIncome($row["md_income_typeid"]);
					$row_status=	$row["md_income_status"];
					
				 ?>    
                                                    <tr class="nk-tb-item">
                                                    	<td class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" name="CheckBoxID<?php echo $index?>" id="CheckBoxID<?php echo $index?>" class="custom-control-input" onclick="Paging_CheckAllHandle(document.myForm.CheckBoxAll,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" value="<?php echo $row_id?>"/>
                                                                <label class="custom-control-label" for="CheckBoxID<?php echo $index?>"></label>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <?php echo  DateFormat($row['md_income_date']);?>
                                                        </td>
                                                        <td class="nk-tb-col"> 
                                                        	<div class="nk-tnx-type">
                                                                <div class="nk-tnx-type-text">
                                                                	<span class="tb-lead"><?php echo $row_name;?></span>
                                                                </div>
                                                           </div> 
                                                        </td>

                                                        <td class="nk-tb-col">
                                                        	<?php echo number_format($row["md_income_total"],2);?>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                        	<?php echo $row["md_income_detail"];?>
                                                        </td>

                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $row_id?>">
                                                            <?php if($chk_permissionID="RW"){?>
                                                            <a href="javascript:void(0)"  onclick="changeStatus('load_mainwaiting','<?php echo $row_status?>','<?php echo $row_id?>','load_status<?php echo $row_id?>','changestatus')">
                                                                <?php if($row["md_income_status"]=='1'){
                                                                echo "<span class='badge badge-dim badge-outline-success d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["md_income_status"]]."</span></a>";
                                                                }else{
                                                                echo "<span class='badge badge-dim badge-outline-danger d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["md_income_status"]]."</span>";
                                                                }//if($row["group_status"]=='Y'){
                                                            }else{
                                                                if($row["md_income_status"]=='1'){
                                                                echo "<md_income_status class='badge badge-dim badge-outline-success d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["md_income_status"]]."</span></a>";
                                                                }else{
                                                                echo "<span class='badge badge-dim badge-outline-danger d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["md_income_status"]]."</span>";
                                                                }//if($row["group_status"]=='Y'){
                                                            }//if($chk_permissionID="RW"){?>
                                                            </a>
                                                        </td>
                                                        
                                                        <td class="nk-tb-col">
                                                         	<span><?php echo DateFormatTime($row["md_income_updatedate"]);?></span>
                                                        </td>
                                                        
                                                        
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-2">
                                                            <li class="nk-tb-action-hidden">
                                                                <a href="javascript:void(0)" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_language["but:view"]?>" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadView();"><em class="icon ni ni-eye"></em></a>
                                                            </li>
                                                            <?php if($chk_permissionID="RW"){?>
                                                            <li class="nk-tb-action-hidden" id="buttom_approved<?php echo $row["wf_id"]?>">
                                                                <a href="javascript:void(0)" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_language["but:edit"]?>" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadAddNew();"><em class="icon ni ni-edit"></em></a>
                                                            </li>
                                                            <li class="nk-tb-action-hidden">
                                                                <a href="javascript:void(0)" class="bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_language["but:delete"]?>" onclick="if(confirm('<?php echo $txt_language["system:popupdelele"]?>')){Paging_CheckedThisItem( document.myForm.CheckBoxAll, <?php echo $index;?>, 'CheckBoxID', document.myForm.TotalCheckBoxID.value );modDeleteContant();}"><em class="icon ni ni-trash-alt"></em></a>
                                                            </li>
                                                            <?php }?>
                                                            
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="dropdown-toggle bg-white btn btn-sm btn-outline-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-opt">
                                                                        	<li><a href="javascript:void(0)" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadView();"><em class="icon ni ni-eye"></em><span><?php echo $txt_language["but:view"]?></span></a></li>
                                                                        	<?php if($chk_permissionID="RW"){?>
                                                                            <li><a href="javascript:void(0)" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadAddNew();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:edit"]?></span></a></li>
                                                                            <li><a href="javascript:void(0)" onclick="if(confirm('<?php echo $txt_language["system:popupdelele"]?>')){Paging_CheckedThisItem( document.myForm.CheckBoxAll, <?php echo $index;?>, 'CheckBoxID', document.myForm.TotalCheckBoxID.value );modDeleteContant();}"><em class="icon ni ni-trash-alt"></em><span><?php echo $txt_language["but:delete"]?></span></a></li>
                                                                            <?php }?>
                                                                            
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
                                                	<td class="nk-tb-col" colspan="7" align="center"><?php echo $txt_language["txt:nodata"];?></td>
                                                </tr><!-- .nk-tb-item  -->

							<?php }//if($count_record>0) {?>
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
/*NioApp.DataTable('.datatable-init', {
      responsive: {
        details: true,
		order: [[0, 'asc']],
      }
    });*/
    $('.input-daterange').datepicker({
        format: 'dd/mm/yyyy'
    });
</script>
<?php }elseif($_POST["myaction"]=="addnew"){?> 
            <?php
			if($_POST["myContantID"]!=""){
                $sql = "SELECT * FROM md_income WHERE md_income_id='".$_POST["myContantID"]."'";
                $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
                $Row=$query->fetch_array();
			}
			 ?>

                                                  		 <!--<div class="form-group" align="center">
                                                            <div class="" style="cursor:pointer" onclick="document.getElementById('inputPicUpload').click();" id="load_filePicnew"><img src="<?php  if($Row["md_income_picname"]!=""){echo $mod_path_pictures_fornt."/".$Row["md_income_picname"];}else{ echo "../../images/avatar/no-image.jpg";}?>" alt=""><input type="hidden" id="input_picnoinsert" name="input_picnoinsert" value=""></div>
                                                            
                                                             <input type="file" id="inputPicUpload" name="inputPicUpload"  onchange="return ajaxFileUploadPic();" style="display:none">
                                                            <div id="loadWaitingPic" class="user-avatar xl" style="display:none">
                                                            <div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>
                                                            </div>
                                                        </div>-->
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="inputmin">ประเภท </label>
                                                                    <div class="form-control-select">
                                                                        <select class="form-control" id="income_type" name="income_type">
                                                                            <option value="" selected="">เลือกประเภท</option>
                                                                            <?php
                                                                                $sql_catalog = "SELECT * FROM md_typeincome WHERE md_typeincome_status='1'";
                                                                                $query_catalog=$mysqli->query($sql_catalog) or die("Error sql_catalog:  <br/>$sql_catalog<br />\n");
                                                                                while($Row_catalog=$query_catalog->fetch_array()){
                                                                            ?>
                                                                            <option value="<?php echo $Row_catalog['md_typeincome_id']?>" <?php echo ($Row_catalog['md_typeincome_id']==$Row['md_income_typeid'])?"selected":""?>><?php echo $Row_catalog['md_typeincome_name']?></option>	
                                                                            <?php }?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="inptfee">ค่าใช้จ่าย</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="income_total" name="income_total" value="<?php echo $Row['md_income_total']?>" required>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="inptfee">รายละเอียด</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="income_detail" name="income_detail" value="<?php echo $Row['md_income_detail']?>" required>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                            
                                                        </div> 

                                                        <hr/>
                                                        <div class="form-group" align="right">
                                                            <a href="javascript:void(0)" class="btn btn btn-sm btn-primary" onclick="loadchkaddform();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:save"];?></span></a>&nbsp;&nbsp;
                                                             <a href="javascript:void(0)" class="btn btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
                                                        </div>
    <script> 
        document.body.onkeydown = function(e) {
            if (e.keyCode == 13)
            loadchkaddform();
        };
    </script>
    <script type="text/javascript" src="ajaxfileupload.js"></script> 
    <script type="text/javascript">     
        //UploadPic
        function ajaxFileUploadPic(){
            var valuefilename = jQuery("input#inputPicName").val();
            var valueallfliename = jQuery("input#insertPicname").val();
            jQuery("#load_filePicnew").hide();
            jQuery("#loadWaitingPic").show();

            jQuery.ajaxFileUpload
            (
                {
                    url:'uploadPic.php?masterkey=<?php echo $_REQUEST["masterkey"]?>&myContantID=<?php echo $_REQUEST["myContantID"]?>&menuid=<?php echo $_REQUEST["menukeyid"]?>',
                    secureuri:false,
                    fileElementId:'inputPicUpload',
                    dataType: 'json',
                    success: function (data, status){ 
                        if(typeof(data.error) != 'undefined')
                        {
                        alert(data.msg);
                            if(data.error != '')
                            {
                                alert(data.error);
                                jQuery("#loadWaitingPic").hide();
                                jQuery("#load_filePicnew").show();
                                jQuery("#load_filePicnew").html(data.msg);
                            
                            }else
                            {
                                jQuery("#loadWaitingPic").hide();
                                jQuery("#load_filePicnew").show();
                                jQuery("#load_filePicnew").html(data.msg);
                                
                            }
                        }
                    },
                    error: function (data, status, e)
                    {
                        alert(e);
                    }
                }
            )

            return false;

        }
    </script>   
<?php }elseif($_POST["myaction"]=="insert"){
	
    $income_total=$_POST['income_total'];
    $income_type=$_POST['income_type'];
    $income_detail=$_POST['income_detail'];

    if($_POST["myContantID"]!=""){
        
		unset($update);
        $update[]="md_income_typeid='".$income_type."'";
        $update[]="md_income_total='".$income_total."'";
        $update[]="md_income_detail='".$income_detail."'";

        $update[]="md_income_updatedate=NOW()";
        $update[]="md_income_updatebyid='".$_SESSION["core_session_sys_id"]."'";

        $sql_update="UPDATE md_income SET ".implode(",",$update)." WHERE md_income_id='".$_POST["myContantID"]."'";
        $Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
        
        // $detail="อับเดทสินค้า ".getProductName($_POST["myContantID"]);
        // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
    }else{
        unset($insert);
        $insert["md_income_typeid"] = "'".$income_type."'";
        $insert["md_income_total"] = "'".$income_total."'";
        $insert["md_income_detail"] = "'".$income_detail."'";

        $insert["md_income_status"] = "'1'";
        $insert["md_income_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_income_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
        $insert["md_income_credate"] = "NOW()";
        $insert["md_income_updatedate"] = "NOW()";
        $insert["md_income_date"] = "NOW()";

        //echo	"sql_insert=".
        $sql_insert="INSERT INTO md_income(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
        $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        $contantID=$mysqli->insert_id;
        
        // $detail="เพิ่มสินค้า ".$product_name;
        // insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
    
    }
}elseif($_POST["myaction"]=="changestatus"){
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
     	$sql = "UPDATE md_income SET md_income_status= '$inputstatusname'  WHERE md_income_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		// $detail="เปลี่ยนสถานะสินค้า ".getProductName($statusid)." เป็น ".$txt_language["system:status:name"][$inputstatusname];
		// insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
		
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
            
            $sql="UPDATE md_income SET md_income_delete='1' WHERE md_income_id='".$permissionID."'";;
            $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");

            }
        }
?>
<?php }elseif($_POST["myaction"]=="loadaddstock"){  ?>
    <?php 
        if($_REQUEST['product_id']==''){ 
            unset($insert);
            $insert["md_income_typeid"] = "'".$_REQUEST['income_type']."'";
            $insert["md_income_typeid"] = "'".$_REQUEST['product_name']."'";
            $insert["md_income_sell"] = "'".$_REQUEST['product_sell']."'";
            $insert["md_income_buy"] = "'".$_REQUEST['product_buy']."'";
            $insert["md_income_buy1"] = "'".$_REQUEST['product_buy1']."'";
            $insert["md_income_buy2"] = "'".$_REQUEST['product_buy2']."'";
            $insert["md_income_buy3"] = "'".$_REQUEST['product_buy3']."'";
            $insert["md_income_buy4"] = "'".$_REQUEST['product_buy4']."'";
			$insert["md_income_buy5"] = "'".$_REQUEST['product_buy5']."'";
			$insert["md_income_buy6"] = "'".$_REQUEST['product_buy6']."'";
			$insert["md_income_buy7"] = "'".$_REQUEST['product_buy7']."'";
			$insert["md_income_buy8"] = "'".$_REQUEST['product_buy8']."'";
			$insert["md_income_buy9"] = "'".$_REQUEST['product_buy9']."'";
			$insert["md_income_buy10"] = "'".$_REQUEST['product_buy10']."'";
            // $insert["md_income_picname"] = "'".$FileName."'";
            $insert["md_income_status"] = "'1'";
            
            $insert["md_income_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
            $insert["md_income_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
            $insert["md_income_credate"] = "NOW()";
            $insert["md_income_updatedate"] = "NOW()";

            //echo	"sql_insert=".
            $sql_insert="INSERT INTO md_income(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
            $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
            $contantID=$mysqli->insert_id;
            $_REQUEST['product_id'] = $contantID;
        }
       $code='WS-'.strtotime(date('YmdHis'));
       $md_deposit_amount="เพิ่มสต็อกสินค้า จำนวน ".$_REQUEST['product_stock'];
        // ." product_id ".$_REQUEST['product_id']
       $PrevWalletStock = getBalanceWalletStock($_REQUEST['product_id']);
       $BalanceWalletStock = $PrevWalletStock+$_REQUEST['product_stock'];

       unset($insert);
       $insert["md_stock_code"] = "'".$code."'"; 
       $insert["md_stock_product_id"] = "'".$_REQUEST['product_id']."'";
       $insert["md_stock_date"] = "'".date('Y-m-d H:i:s')."'";
       $insert["md_stock_detail"] = "'".$md_deposit_amount."'"; // "'เพิ่มสต็อกสินค้า จำนวน ".$md_deposit_amount."'";
       $insert["md_stock_price"] = "'".$_REQUEST['product_stock_price']."'";
       $insert["md_stock_deposit"] = "'".$_REQUEST['product_stock']."'";
       $insert["md_stock_withdrawal"] = "'0'";		
       $insert["md_stock_prevbalance"] = "'".$PrevWalletStock."'";	
       $insert["md_stock_balance"] = "'".$BalanceWalletStock."'";	
       $insert["md_stock_group"] = "'DF'";			 
       $insert["md_stock_staffid"] = "'".$_SESSION["core_session_sys_id"]."'";
       $insert["md_stock_credate"] = "'".date('Y-m-d H:i:s')."'";

       // echo	"sql_insert=".
       $sql_insert="INSERT INTO md_wallet_stock(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
       $Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
        if($Query_insert){
            echo "success";
        }else{
            echo "error";
        }
    ?>



<?php }elseif($_POST["myaction"]=="view"){?>
    <?php
        $sql = "SELECT * FROM md_income WHERE md_income_id='". $_POST["myContantID"]."'";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
        $row_id=$Row['group_id'];
    ?>
           
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="inputmin">ประเภท </label>
                <div class="form-control-select">
                    <select class="form-control" id="income_type" name="income_type" disabled="disabled">
                        <option value="" selected="">เลือกประเภท</option>
                        <?php
                            $sql_catalog = "SELECT * FROM md_typeincome WHERE md_typeincome_status='1'";
                            $query_catalog=$mysqli->query($sql_catalog) or die("Error sql_catalog:  <br/>$sql_catalog<br />\n");
                            while($Row_catalog=$query_catalog->fetch_array()){
                        ?>
                        <option value="<?php echo $Row_catalog['md_typeincome_id']?>" <?php echo ($Row_catalog['md_typeincome_id']==$Row['md_income_typeid'])?"selected":""?>><?php echo $Row_catalog['md_typeincome_name']?></option>	
                        <?php }?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-label" for="inptfee">ค่าใช้จ่าย</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="income_total" name="income_total" value="<?php echo $Row['md_income_total']?>" readonly>
                </div>
            </div> 
        </div> 
    </div> 

    <!-- <hr/>
    <div class="form-group" align="right">
            <a href="javascript:void(0)" class="btn btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
    </div> -->
             
<?php }?>