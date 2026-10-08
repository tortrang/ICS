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
		document.myForm.input_catalog.value=value;	   
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
	$module_sort_number = "DESC";
	
	$module_pagesize = $_REQUEST["module_pagesize"];
	$module_pageshow = $_REQUEST["module_pageshow"];
	$module_adesc = $_REQUEST["module_adesc"];
	$module_orderby = $_REQUEST["module_orderby"];
	$InputSearch=trim($_REQUEST["InputSearch"]);
	
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = "md_customer_id"; }
	if($inputSearch!=""){ $inputSearch=trim($inputSearch); }
	
	// SQL SELECT #########################

	
	$sql = "SELECT * FROM md_customer WHERE md_customer_delete='0'";
	if($_REQUEST["InputSearch"]!=""){
		$sql .= " AND (md_customer_name LIKE '%".$_REQUEST["InputSearch"]."%')";
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
                                                            <li><a href="javascript:void(0)" class="btn btn-danger" onclick="
if(Paging_CountChecked('CheckBoxID',document.myForm.TotalCheckBoxID.value)&gt;0) { if(confirm('คุณต้องการลบข้อมูลหรือไม่?')) {modDeleteContant();}}else{alert('กรุณาเลือกข้อมูลที่จะลบ');}"><em class="icon ni ni-trash-alt"></em><span><?php echo $txt_language["but:delete"]?></span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head-content -->
                                            <?php }?>
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .nk-block-head -->
   
   <!-- Modal Form -->
    <div class="modal fade" tabindex="-1" id="loadmodal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ข้อมูลลูกค้า</h5>
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
    
    <!-- Modal Form -->
    <div class="modal fade" tabindex="-1" id="loadmodalbasket">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">จัดการตะกร้า</h5>
                    <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee">รหัสลูกค้า</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="customer_code" name="customer_code" value="<?php echo $Row['md_customer_code']?>" required>
                                                            </div>
                                                        </div>
                   										<div class="form-group">
                                                            <label class="form-label" for="inptfee">ชื่อลูกค้า</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $Row['md_customer_name']?>" required>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee">จำนวน</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="customer_amount" name="customer_amount" value="<?php echo $Row['md_customer_tel']?>" onkeypress="checkNumber();">
                                                            </div>
                                                        </div>
                                                        
                                                        <hr/>
                                                        <div class="form-group" align="right">
                                                            <a href="javascript:void(0)" class="btn btn btn-sm btn-primary" onclick="loadchkaddform2();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:save"];?></span></a>&nbsp;&nbsp;
                                                             <a href="javascript:void(0)" class="btn btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
                                                        </div>
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
                                                    <div class="col-12 col-sm-4 text-left">
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
                                                        <th class="nk-tb-col"><span class="sub-text">รหัสลูกค้า</span></th>
                                                        <th class="nk-tb-col"><span class="sub-text">ชื่อลูกค้า</span></th>
                                                        <!-- <th class="nk-tb-col"><span class="sub-text">จำนวนตะกร้า</span></th> -->
                                                        
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
					$row_id=		$row["md_customer_id"];
					$row_name=		rechangeQuot($row["md_customer_name"]);
					$row_status=	$row["md_customer_status"];
					$row_code=	$row["md_customer_code"];
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
                                                                	<span class="tb-lead"><?php echo $row_code;?></span>
                                                                </div>
                                                           </div> 
                                                        </td>
                                                        <td class="nk-tb-col">
                                                        
                                                        	<div class="nk-tnx-type">
                                                                <div class="nk-tnx-type-text">
                                                                	<span class="tb-lead"><?php echo $row_name;?></span>
                                                                </div>
                                                           </div> 
                                                        </td>
                                                        
                                                        <!-- <td class="nk-tb-col">
                                                        	<?php echo $row["md_customer_amount"];?>
                                                        </td> -->
                                                        
                                                         
                                                        <td class="nk-tb-col">
                                                         	<span><?php echo DateFormatTime($row["md_customer_updatedate"]);?></span>
                                                        </td>
                                                        
                                                        
                                                        <td class="nk-tb-col nk-tb-col-tools">
                                                            <ul class="nk-tb-actions gx-2">
                                                            <!-- <li class="nk-tb-action-hidden">
                                                                <a href="#loadmodalbasket" data-toggle="modal" class="bg-white btn btn-sm btn-outline-light btn-icon" data-placement="top" title="จัดการตะกร้า" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>'"><em class="icon ni ni-archived"></em></a>
                                                            </li> -->
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
                                                                        	<!-- <li><a href="#loadmodalbasket" data-toggle="modal" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>'"><em class="icon ni ni-archived"></em><span>จัดการตะกร้า</span></a></li> -->
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
</script>
<?php }elseif($_POST["myaction"]=="addnew"){?> 
            <?php
			if($_POST["myContantID"]!=""){
             $sql = "SELECT * FROM md_customer WHERE md_customer_id='".$_POST["myContantID"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			}
            ?>

            <div class="form-group">
                <label class="form-label" for="inptfee">รหัสลูกค้า</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="customer_code_insert" name="customer_code_insert" value="<?php echo $Row['md_customer_code']?>" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="inptfee">ชื่อลูกค้า</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="customer_name_insert" name="customer_name_insert" value="<?php echo $Row['md_customer_name']?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="inptfee">เบอร์ติดต่อ</label>
                <div class="form-control-wrap">
                    <input type="text" class="form-control" id="customer_tel_insert" name="customer_tel_insert" value="<?php echo $Row['md_customer_tel']?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label" for="inptfee">ประเภทราคา</label> 
                <div class="form-control-wrap">
                    <select class="form-select form-control form-control-md" id="price_type_insert" name="price_type_insert" required>
                        <option value="0" <?php echo ($Row['md_customer_price_type']==0)?"selected":""?>>ราคาซื้อทั่วไป</option>
                        <option value="1" <?php echo ($Row['md_customer_price_type']==1)?"selected":""?>>ราคา 1</option>
                        <option value="2" <?php echo ($Row['md_customer_price_type']==2)?"selected":""?>>ราคา 2</option>
                        <option value="3" <?php echo ($Row['md_customer_price_type']==3)?"selected":""?>>ราคา 3</option>
                        <option value="4" <?php echo ($Row['md_customer_price_type']==4)?"selected":""?>>ราคา 4</option>
                    </select>
                </div> 
            </div>
            
            <hr/>
            <div class="form-group" align="right">
                <a href="javascript:void(0)" class="btn btn btn-sm btn-primary" onclick="loadchkaddform();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:save"];?></span></a>&nbsp;&nbsp;
                    <a href="javascript:void(0)" class="btn btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
            </div>
                                                    
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
	            $customer_code=$_POST['customer_code_insert'];
				$customer_name=$_POST['customer_name_insert'];
				$customer_tel=$_POST['customer_tel_insert'];
                $price_type=$_POST['price_type_insert'];

				if($_POST["myContantID"]!=""){
					$update[]="md_customer_code='".$customer_code."'";
					$update[]="md_customer_name='".$customer_name."'";
                    
					$update[]="md_customer_tel='".$customer_tel."'";
                    $update[]="md_customer_price_type='".$price_type."'";

					$update[]="md_customer_updatedate=NOW()";
					$update[]="md_customer_updatebyid='".$_SESSION["core_session_sys_id"]."'";
	
					$sql_update="UPDATE md_customer SET ".implode(",",$update)." WHERE md_customer_id='".$_POST["myContantID"]."'";
					$Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
					
					$detail="อับเดทข้อมูลลูกค้า ".getProductName($_POST["myContantID"]);
					insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
				}else{
					$FileName = $_FILES['inputPicUpload']['name'];		// รับค่าชื่อไฟล์
					
					unset($insert);
                    $insert["md_customer_code"] = "'".$customer_code."'";
					$insert["md_customer_name"] = "'".$customer_name."'";
					$insert["md_customer_tel"] = "'".$customer_tel."'";
                    $insert["md_customer_price_type"] = "'".$price_type."'";
					$insert["md_customer_status"] = "'1'";
					
					$insert["md_customer_crebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
					$insert["md_customer_updatebyid"] = "'".$_SESSION["core_session_sys_id"]."'";
					$insert["md_customer_credate"] = "NOW()";
					$insert["md_customer_updatedate"] = "NOW()";

                    //echo	"sql_insert=".
					$sql_insert="INSERT INTO md_customer(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
					$Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
					$contantID=$mysqli->insert_id;
					
					$detail="เพิ่มลูกค้า ".$customer_name;
					insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
					
					
					/*if($FileName){ 	// มีการอัพโหลดไฟล์ใหม่
						//เอาชื่อไฟล์เก่าออกให้เหลือแต่นามสกุล
						 $type = strrchr($_FILES['inputPicUpload']['name'],".");
							
						//ตั้งชื่อไฟล์ใหม่โดยใช้รหัสบุคลากรตามด้วย _pic
						$customer_pic = $contantID."_pic".$type;
						$path_copy=$mod_path_pictures_fornt."/".$customer_pic;
						
						//คัดลอกไฟล์ไปเก็บที่เว็บเซริ์ฟเวอร์
						//move_uploaded_file($_FILES['file']['tmp_name'],$path_copy); 
			
					}
					if(@copy($_FILES['inputPicUpload']['tmp_name'],$path_copy))
				   {   	       $images =$path_copy;
							   //$new_images ="member_pic/".$member_id."_logo.jpg"; //$new_images = "photoresize/".$photono.".jpg";
							   $width=150; 
							   $size=GetimageSize($images);
							   $height=round($width*$size[1]/$size[0]);
							   //$images_orig = ImageCreateFromJPEG($images);
							   //$photoX = ImagesX($images);
							   //$photoY = ImagesY($images);
							   $images_fin = ImageCreateTrueColor($width, $height);
							   //$ImageCopyResampled($images_fin, $images, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
							   //ImageJPEG($images_fin,$new_images);
							   //ImageDestroy($images_orig);
							   ImageDestroy($images_fin);		
							   //print"file1";	
							   //echo 	$images;
				   }*/

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
     	$sql = "UPDATE md_customer SET md_customer_status= '$inputstatusname'  WHERE md_customer_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		$detail="เปลี่ยนสถานะสินค้า ".getProductName($statusid)." เป็น ".$txt_language["system:status:name"][$inputstatusname];
		insertlog($_SESSION["core_session_sys_id"],$_POST['masterkey'],$detail);
		
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
		
		 $sql="UPDATE md_customer SET md_customer_delete='1' WHERE md_customer_id='".$permissionID."'";;
		 $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		}}
?>
<?php }elseif($_POST["myaction"]=="view"){?>
    <?php
        $sql = "SELECT * FROM md_customer WHERE md_customer_id='". $_POST["myContantID"]."'";
        $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
        $Row=$query->fetch_array();
        $row_id=$Row['group_id'];
    ?>

        <div class="form-group">
            <label class="form-label" for="inptfee">รหัสลูกค้า</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="customer_code" name="customer_code" value="<?php echo $Row['md_customer_code']?>" readonly>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="inptfee">ชื่อลูกค้า</label>
            <div class="form-control-wrap">
                <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?php echo $Row['md_customer_name']?>" readonly>
            </div>
        </div>
    
        <div class="form-group">
        <label class="form-label" for="inptfee">เบอร์ติดต่อ</label>
        <div class="form-control-wrap">
            <input type="text" class="form-control" id="customer_tel" name="customer_tel" value="<?php echo $Row['md_customer_tel']?>" readonly>
        </div>
    </div>
    
    <div class="form-group">
        <label class="form-label" for="inptfee">ประเภทราคา</label> 
        <div class="form-control-wrap">
            <select class="form-select form-control form-control-md" id="price_type" name="price_type" disabled>
                <option value="0" <?php echo ($Row['md_customer_price_type']==0)?"selected":""?>>ราคาซื้อทั่วไป</option>
                <option value="1" <?php echo ($Row['md_customer_price_type']==1)?"selected":""?>>ราคา 1</option>
                <option value="2" <?php echo ($Row['md_customer_price_type']==2)?"selected":""?>>ราคา 2</option>
                <option value="3" <?php echo ($Row['md_customer_price_type']==3)?"selected":""?>>ราคา 3</option>
                <option value="4" <?php echo ($Row['md_customer_price_type']==4)?"selected":""?>>ราคา 4</option>
            </select>
        </div> 
    </div>
    
    <hr/>
    <div class="form-group" align="right">
        <a href="javascript:void(0)" class="btn btn btn-sm btn-primary"  onclick="document.myForm.myContantID.value ='<?php echo $Row["md_customer_id"]?>';modLoadAddNew();"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:edit"];?></span></a>&nbsp;&nbsp;
            <a href="javascript:void(0)" class="btn btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:cancel"];?></span></a>
    </div>

<?php }?>