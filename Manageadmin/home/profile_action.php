<?php
require_once("../libs/session.php");
require_once("../libs/config.php");
require_once("../libs/connect.php");
require_once("../libs/function.php");
	
if($_SESSION['core_session_sys_language']=="thai"){
	include("../structure/language_thai.php");
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../structure/language_eng.php");	
	include("../libs/language_eng.php");
}

?>
<?php if($_POST["myaction"]=="datalist"){?>

			<form action="" method="post" name="myForm" id="myForm">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["$module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["$module_pagesize"]?>" />
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
	$inputSearch=trim($_REQUEST["inputSearch"]);
	
	if($module_pagesize==""){ $module_pagesize = $module_default_pagesize; }
	if($module_pageshow==""){ $module_pageshow = $module_default_pageshow; }
	if($module_adesc==""){ $module_adesc = $module_sort_number; }
	if($module_orderby==""){ $module_orderby = "sys_staff_id"; }
	if($inputSearch!=""){ $inputSearch=trim($inputSearch); }
	
	// SQL SELECT #########################

	
$sql = "SELECT * FROM sys_staff WHERE 1=1";
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
	//$sql .= " ORDER BY $module_orderby $module_adesc LIMIT $recordstart , $module_pagesize ";

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
                                            <div class="nk-block-head-content">
                                                <div class="toggle-wrap nk-block-tools-toggle">
                                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                    <div class="toggle-expand-content" data-content="pageMenu">
                                                        <ul class="nk-block-tools g-3">
                                                            <li><a href="javascript:void(0)" class="btn btn-primary" onclick="modLoadAddNew();"><em class="icon ni ni-plus"></em><span><?php echo $txt_language["but:addnew"]?></span></a></li>
                                                            <li><a href="javascript:void(0)" class="btn btn-danger" onclick="
if(Paging_CountChecked('CheckBoxID',document.myForm.TotalCheckBoxID.value)&gt;0) { if(confirm('คุณต้องการลบข้อมูลหรือไม่?')) {modDeleteContant();}}else{alert('กรุณาเลือกข้อมูลที่จะลบ');}"><em class="icon ni ni-trash-alt"></em><span><?php echo $txt_language["but:delete"]?></span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head-content -->
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .nk-block-head -->
                                    <div class="nk-block nk-block-lg">
                                    <div class="card card-preview">
                                        <div class="card-inner">
    
                                            <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                                                <thead>
                                                    <tr class="nk-tb-item nk-tb-head">
                                                    	<th class="nk-tb-col nk-tb-col-check">
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                            	<input type="checkbox" name="CheckBoxAll" id="CheckBoxAll" class="custom-control-input" onclick="Paging_CheckAll(this,'CheckBoxID',document.myForm.TotalCheckBoxID.value)" />
                                                                <label class="custom-control-label" for="CheckBoxAll"></label>
                                                            </div>
                                                        </th>
                                                        <th class="nk-tb-col"><span class="sub-text"><?php echo $txt_mod["user:fnamelname"]?></span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_mod["user:permission"]?></span></th>
                                                        <th class="nk-tb-col tb-col-lg"><span class="sub-text"><?php echo $txt_language["txt:access"]?></span></th>
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
					$row_id=		$row["sys_staff_id"];
					$row_name=		rechangeQuot($row["sys_staff_fname"])." ".rechangeQuot($row["sys_staff_lname"]);
					$row_compid=	$row["sys_staff_compid"];
					$row_perid=		$row["sys_staff_groupid"];
					$row_status=	$row["sys_staff_status"];
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
                                                                	<span class="tb-lead"><?php echo $row_name;?></span>
                                                                </div>
                                                           </div>
                                                        </a>
                                                        </td>
                                                        <td class="nk-tb-col tb-col-md">
                                                            <span><?php
		$sql_group = "SELECT sys_group_id,sys_group_name FROM sys_group  WHERE sys_group_id='".$row["sys_staff_perid"]."' ORDER BY sys_group_order DESC ";
		$query_group=$mysqli->query($sql_group);
		$row_group=$query_group->fetch_array();
		$row_groupid=$row_group[0];
		$row_groupname=$row_group[1];
		echo $row_groupname;
		?></span>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                         	<span><?php echo DateFormatTime($row["sys_staff_logdate"]);?></span>
                                                        </td>
                                                        
                                                        <td class="nk-tb-col tb-col-md" id="load_status<?php echo $row_id?>">
                                                        <?php if($chk_permissionID="RW"){?>
                                                        <a href="javascript:void(0)"  onclick="changeStatus('load_mainwaiting','<?php echo $row_status?>','<?php echo $row_id?>','load_status<?php echo $row_id?>','changestatus')">
															 <?php if($row["sys_staff_status"]=='1'){
                                                               echo "<span class='badge badge-dim badge-outline-success d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["sys_staff_status"]]."</span></a>";
                                                             }else{
                                                               echo "<span class='badge badge-dim badge-outline-danger d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["sys_staff_status"]]."</span>";
                                                             }//if($row["group_status"]=='Y'){
                                                          }else{
															 if($row["sys_staff_status"]=='1'){
                                                               echo "<sys_staff_status class='badge badge-dim badge-outline-success d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["sys_staff_status"]]."</span></a>";
                                                             }else{
                                                               echo "<span class='badge badge-dim badge-outline-danger d-none d-md-inline-flex'>".$txt_language["system:status:name"][$row["sys_staff_status"]]."</span>";
                                                             }//if($row["group_status"]=='Y'){
                                                         }//if($chk_permissionID="RW"){?>
                                                         </a>
                                                        </td>
                                                        
                                                        <td class="nk-tb-col">
                                                         	<span><?php echo DateFormatTime($row["sys_staff_updatedate"]);?></span>
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
                                                    
                                                    <!-- Modal Default -->
    <div class="modal fade" tabindex="-1" id="modalpersonal<?php echo $row_id?>">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-body modal-body-md">
                    <div class="nk-modal-head mb-3 mb-sm-5">
                        <h4 class="nk-modal-title title">Personal ID</h4>
                    </div>
                    <div class="nk-tnx-details">
                    	<?php //if($Row["account_card_active"]=="W"){?>
                        <div class="row gy-3">
                        	<div class="col-lg-12">
                                <div class="form-group">
                                    <img src="<?php echo $core_pathname_upload_fornt."/account/personal/".$row["account_card"]?>" />
                            	</div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="inptfee">ID CARD</label>
                                    <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="account_cardid" name="account_cardid" value="<?php echo $row["account_cardid"]?>" disabled="disabled">
                                    </div>
                            	</div>
                            </div>
                        </div><!-- .row -->
                        <?php if($chk_permissionID="RW"){?>
                     	<hr/>
                         <div class="row gy-3" align="right">
                             <div class="col-lg-12">
                             <a href="javascript:void(0)" class="btn btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close" onclick="updatepersonal(<?php echo $row["account_id"]?>,'card','Y','home','loadpersonal<?php echo $row_id?>');"><em class="icon ni ni-done"></em><span><?php echo $txt_language["but:approve"];?></span></a>&nbsp;&nbsp;
                             <a href="javascript:void(0)" class="btn btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close" onclick="updatepersonal(<?php echo $row["account_id"]?>,'card','RJ','home','loadpersonal<?php echo $row_id?>');"><em class="icon ni ni-cross"></em><span><?php echo $txt_language["but:reject"];?></span></a>
                             </div>
                         </div>
                     <?php }
					 //}?>
                    </div><!-- .nk-tnx-details -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
    
                                          <?php $index++;$color++; 
									}//while($row=$query->fetch_array()){
							}//if($count_record>0) {?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- .card-preview -->
                                    </div><!-- .nk-block-head-content -->                  
                            </div><!-- .nk-block -->
                            <input name="TotalCheckBoxID" type="hidden" id="TotalCheckBoxID" value="<?php echo $index-1?>" />
</form>
<script type="text/javascript">
NioApp.DataTable('.datatable-init', {
      responsive: {
        details: true,
		order: [[0, 'asc']],
      }
    });
</script>
<?php }elseif($_POST["myaction"]=="addnew"){?> 
<form action="" method="post" name="myForm" id="myForm" class="form-validate is-alter">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["$module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["$module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <?php
			//if($_POST["myContantID"]!=""){
             $sql = "SELECT * FROM sys_staff WHERE sys_staff_id='".$_SESSION["core_session_sys_id"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			//}
			 ?>
<div class="nk-block nk-block-lg">
                                    
                                    <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                 <h4 class="nk-block-title">Profile</h4>
                                                 <br />
                                            </div>
                                            <!--<div class="nk-block-head-content">
                                                <a href="javascript:void(0)" class="btn btn-outline-light bg-white d-none d-sm-inline-flex" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em><span><?php echo $txt_language["but:back"]?></span></a>
                                                <a href="javascript:void(0)" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em></a>
                                            </div>-->
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-gs">
                                                	<div class="col-sm-6">
                                                    	<div class="form-group">
                                                        	<label class="form-label" for="default-06"><?php echo $txt_mod["user:permission"]?></label>
                                                            <div class="form-control-wrap">
                                                            	<div class="form-control-select">
                                                                    <?php 
																	$sql_group = "SELECT * FROM sys_group WHERE 1=1";
																	$Query_GroupPermission=$mysqli->query($sql_group) OR DIE("Error sql_group: <br>$sql_group<br>\n");
																	?>
																	<select class="form-control" id="staff_group" name="staff_group" disabled="disabled"> 
																			<option value=""><?php echo $txt_language["alert:select"]?></option>
                                                                            <?php while($Row_group=$Query_GroupPermission->fetch_array()){
																				$row_group_id=$Row_group['sys_group_id'];
																				$row_group_name=$Row_group['sys_group_name'];
																				
																				?>
																			<option value="<?php echo $row_group_id?>" <?php echo ($Row["sys_staff_perid"]==$row_group_id)?"selected":""?>><?php echo $row_group_name?></option>
                                                                            <?php }?>
                                                                    </select>
                                                               </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee"><?php echo $txt_mod["user:nameuser"]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_username" name="staff_username" value="<?php echo $Row['sys_staff_username']?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:pass"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_password" name="staff_password" value="<?php echo decodeStr($Row['sys_staff_password'])?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:firstname"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_fname" name="staff_fname" value="<?php echo $Row['sys_staff_fname']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:lastname"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_lname" name="staff_lname" value="<?php echo $Row['sys_staff_lname']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:mobile"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_mobile" name="staff_mobile" value="<?php echo $Row['sys_staff_mobile']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:email"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_email" name="staff_email" value="<?php echo $Row['sys_staff_email']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" onClick="loadchkaddform();"><?php echo $txt_language["but:save"]?></button>
                                                        
                                                            <button type="button" class="btn btn-warning" onclick="modLoadContent()"><?php echo $txt_language["but:cancel"]?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
</form>
<?php }elseif($_POST["myaction"]=="insert"){
	
				$group_name=$_POST['group_name'];
				$staff_username=$_POST['staff_username'];
				$staff_password=$_POST['staff_password'];
				$staff_fname=$_POST['staff_fname'];
				$staff_lname=$_POST['staff_lname'];
				$staff_mobile=$_POST['staff_mobile'];
				$staff_email=$_POST['staff_email'];
					
					
					//$update[]="sys_staff_perid ='".$staff_group."'";
					//$update[]="sys_staff_username='".$staff_username."'";
					$update[]="sys_staff_password='".encodeStr($staff_password)."'";
					$update[]="sys_staff_fname='".$staff_fname."'";
					$update[]="sys_staff_lname='".$staff_lname."'";
					$update[]="sys_staff_mobile='".$staff_mobile."'";
					$update[]="sys_staff_email='".$staff_email."'";

					$update[]="sys_staff_updatedate=NOW()";
					$update[]="sys_staff_updatebyid='".$_SESSION["core_session_sys_id"]."'";
	
					$sql_update="UPDATE sys_staff SET ".implode(",",$update)." WHERE sys_staff_id='".$_SESSION["core_session_sys_id"]."'";
					$Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
					
				
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
     	$sql = "UPDATE sys_staff SET sys_staff_status= '$inputstatusname'  WHERE sys_staff_id='". $statusid."'";
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
		
		 $sql="DELETE FROM sys_staff WHERE sys_staff_id='".$permissionID."'";
		 $Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		}}
?>
<?php }elseif($_POST["myaction"]=="view"){?>
<form action="" method="post" name="myForm" id="myForm">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["$module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["$module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <?php
             $sql = "SELECT * FROM sys_staff WHERE sys_staff_id='".$_SESSION["core_session_sys_id"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			 $row_id=$Row['group_id'];
			 ?>
             <div class="nk-block nk-block-lg">
                                    
                                    <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                 <h4 class="nk-block-title">Profile</h4>
                                                 <br />
                                            </div>
                                            <!--<div class="nk-block-head-content">
                                                <a href="javascript:void(0)" class="btn btn-outline-light bg-white d-none d-sm-inline-flex" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em><span><?php echo $txt_language["but:back"]?></span></a>
                                                <a href="javascript:void(0)" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em></a>
                                            </div>-->
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-gs">
                                                    <div class="col-sm-6">
                                                    	<div class="form-group">
                                                        	<label class="form-label" for="default-06"><?php echo $txt_mod["user:permission"]?></label>
                                                            <div class="form-control-wrap">
                                                            	<div class="form-control-select">
                                                                    <?php 
																	$sql_group = "SELECT * FROM sys_group WHERE 1=1";
																	$Query_GroupPermission=$mysqli->query($sql_group) OR DIE("Error sql_group: <br>$sql_group<br>\n");
																	?>
																	<select class="form-control" id="staff_group" name="staff_group" disabled> 
																			<option value=""><?php echo $txt_language["alert:select"]?></option>
                                                                            <?php while($Row_group=$Query_GroupPermission->fetch_array()){
																				$row_group_id=$Row_group['sys_group_id'];
																				$row_group_name=$Row_group['sys_group_name'];
																				
																				?>
																			<option value="<?php echo $row_group_id?>" <?php echo ($Row["sys_staff_perid"]==$row_group_id)?"selected":""?>><?php echo $row_group_name?></option>
                                                                            <?php }?>
                                                                    </select>
                                                               </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee"><?php echo $txt_mod["user:nameuser"]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_username" name="staff_username" value="<?php echo $Row['sys_staff_username']?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:pass"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_password" name="staff_password" value="<?php echo decodeStr($Row['sys_staff_password'])?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:firstname"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_fname" name="staff_fname" value="<?php echo $Row['sys_staff_fname']?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:lastname"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_lname" name="staff_lname" value="<?php echo $Row['sys_staff_lname']?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:mobile"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_mobile" name="staff_mobile" value="<?php echo $Row['sys_staff_mobile']?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["user:email"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="staff_email" name="staff_email" value="<?php echo $Row['sys_staff_email']?>" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" onclick="document.myForm.myContantID.value ='<?php echo $row_id?>';modLoadAddNew();"><?php echo $txt_language["but:edit"]?></button>
                                                        
                                                            <button type="button" class="btn btn-warning" onclick="modLoadContent()"><?php echo $txt_language["but:cancel"]?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
             </form>
             
<?php }?>