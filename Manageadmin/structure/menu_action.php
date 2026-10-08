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
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" /> 
            <input name="myContantID" type="hidden" id="myContantID" value="" /> 
            <input name="inputgroupID" type="hidden" id="inputgroupID" value="<?php echo $_REQUEST["inputgroupID"]?>" /> 
            <input name="myParentID" type="hidden" id="myParentID" value="<?php echo $_REQUEST["myParentID"]?>" />
  
<?php
	 $chk_permissionID = getUserPermissionOnMenu($_SESSION["core_session_sys_grpid"],$_REQUEST['menukeyid']);
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
                                                             <li><a href="javascript:void(0)" class="btn btn-warning" onclick="sortContantMenu();"><em class="icon ni ni-view-list-fill"></em><span><?php echo $txt_language["but:sort"]?></span></a></li>
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
    										<?php

//include("treemenu.php"); 
$myParentGroupID=0;
$MID=0;
//loadTreeMenu($myParentGroupID,$MID,0);

 	$sql = "SELECT * FROM sys_menu WHERE sys_menu_parentid='".$myParentGroupID."' ORDER BY sys_menu_order ASC ";
	$Query=$mysqli->query($sql) ;
	$RecordCount=$Query->num_rows;
	$MaxOrder =$RecordCount;
	?>
    <div class="row">
    <script language="JavaScript"  type="text/javascript">
function down(menu){
	document.getElementById("menu_"+menu).style.display = 'none'; 
	document.getElementById("icon_donw"+menu).style.display = 'none'; 
	document.getElementById("icon_up"+menu).style.display = ''; 
}
function up(menu){
	document.getElementById("menu_"+menu).style.display = ''; 
	document.getElementById("icon_donw"+menu).style.display = ''; 
	document.getElementById("icon_up"+menu).style.display = 'none';
}
</script>
<div class="dd dd-draghandle col-xs-12" >
											<ol class="dd-list" id="nestable">
                                            <?php
											$index=1;
											while($Row=$Query->fetch_array()) { 
											
											?>
												<li class="dd-item dd2-item" id="<?php echo $Row["sys_menu_id"]?>">
													<div class="dd-handle dd2-handle" onClick="$('#myContantID').val('<?php echo $Row["sys_menu_id"]?>');
	modLoadView();">
                                                    
														<i class="normal-icon <?php echo $Row["sys_menu_icon"]?> bigger-140"></i>

														<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
													</div>
                                                     <?php
                                                    //// เมนูย่อย
               				$sql_list = "SELECT * FROM "."sys_menu Where "."sys_menu_parentid='".$Row["sys_menu_id"]."' ORDER BY "."sys_menu_order ASC ";
							$Query_list=$mysqli->query($sql_list);
							$RecordCount_list=$Query_list->num_rows;
							?>
													<div class="dd2-content"><?php if($RecordCount_list>0){?><i class="ace-icon glyphicon glyphicon-minus" style="cursor:pointer" id="icon_donw<?php echo $index?>" onclick="down(<?php echo $index?>)"></i><i class="ace-icon glyphicon glyphicon-plus" style="cursor:pointer;display:none" id="icon_up<?php echo $index?>" onclick="up(<?php echo $index?>)"></i>&nbsp;<?php }?><?php echo rechangeQuot($Row["sys_menu_name".$_SESSION["core_session_sys_language"]]);?>
                                                    
                                                   
                                                    <!--จัดการ-->
                                                    <div class="pull-right action-buttons" style="float: right;">
                                                     
                                                     <i class="icon ni ni-eye text-primary" onClick="$('#myContantID').val('<?php echo $Row["sys_menu_id"]?>');
	modLoadView();" style="cursor:pointer;"></i>&nbsp;
					  
                      <i class="icon ni ni-pen-alt-fill text-success" onclick="document.myForm.myContantID.value ='<?php echo $Row["sys_menu_id"]?>'; modLoadAddNew();" style="cursor:pointer;"></i>
					 
						<?php if($RecordCount_list==0) { ?>
                        <a href="javascript:void(0)" id="id-btn-dialog<?php echo $index?>" onclick="if(confirm('คุณต้องการลบข้อมูลหรือไม่?')){document.myForm.myContantID.value ='<?php echo $Row["sys_menu_id"]?>';modDeleteContant();}">
                        <i class="icon ni ni-trash-alt text-danger"></i>
   						</a>
						<?php } else { ?>
						<i class="icon ni ni-trash-alt text-gray"></i>
						<?php } ?>					  
                 
                 							
                                                    </div>
                                                     <!--สถานะโมดูล-->
                                                    <div class="pull-right action-buttons" style="float: right;">
                                                     <span  id="load_status<?php echo $Row["sys_menu_id"]?>" style="padding-right:40px;">
                 <?php if($_SESSION["core_session_sys_grpid"]==1){?>
					<?php if($Row["sys_menu_status"]=="Enable"){?>
                    <div class="custom-control custom-switch">
                    <input name="switch-field-1" id="switch-field-<?php echo $Row["sys_menu_id"]?>" class="custom-control-input" type="checkbox" onclick="changeStatus('load_waiting<?php echo $Row["sys_menu_id"]?>','<?php echo "sys_menu"?>','<?php echo $Row["sys_menu_status"]?>','<?php echo $Row["sys_menu_id"]?>','load_status<?php echo $Row["sys_menu_id"]?>','changestatus');" checked="checked">
                    <label class="custom-control-label" for="switch-field-<?php echo $Row["sys_menu_id"]?>"></label>
                    </div>
                    <?php }else{?>
                    <div class="custom-control custom-switch">
                    <input name="switch-field-1" id="switch-field-<?php echo $Row["sys_menu_id"]?>" class="custom-control-input" type="checkbox" onclick="changeStatus('load_waiting<?php echo $Row["sys_menu_id"]?>','<?php echo "sys_menu"?>','<?php echo $Row["sys_menu_status"]?>','<?php echo $Row["sys_menu_id"]?>','load_status<?php echo $Row["sys_menu_id"]?>','changestatus');">
                    <label class="custom-control-label" for="switch-field-<?php echo $Row["sys_menu_id"]?>"></label>
                    </div>
                    <?php }?>
                 <?php }else{?>
                 <?php if($Row["sys_menu_status"]=="Enable"){?>
                 	<div class="custom-control custom-switch">
                    <input name="switch-field-1" id="switch-field-<?php echo $Row["sys_menu_id"]?>" class="custom-control-input" type="checkbox" checked="checked">
                    <label class="custom-control-label" for="switch-field-<?php echo $Row["sys_menu_id"]?>"></label>
                    </div>
                    <?php }else{?>
                    <div class="custom-control custom-switch">
                    <input name="switch-field-1" id="switch-field-<?php echo $Row["sys_menu_id"]?>" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="switch-field-<?php echo $Row["sys_menu_id"]?>"></label>
                    </div>
                    <?php }?>
                 <?php }?>
                 </span>
                 </div>
                                                    <!--ประเทภโมดูล-->
                                                    <div class="pull-right action-buttons" style="padding-right:40px;float: right;">
                                                  
													<?php echo $Row["sys_menu_moduletype"]?>
                                                    
                                                    </div>
                                                    
                                                    </div>
                                                    
                              
							
                            <div id="menu_<?php echo $index?>">
								<ol class="dd-list" id="nestable_list" style="padding-left:35px;">
                                 <?php 
								 $index_list=1;
								 while($Row_list=$Query_list->fetch_array()){?>
									<li class="dd-item dd2-item" id="<?php echo $Row_list["sys_menu_id"]?>">
										<div class="dd-handle dd2-handle" onclick="if(confirm('คุณต้องการลบข้อมูลหรือไม่?')){document.myForm.myContantID.value ='<?php echo $Row_list["sys_menu_id"]?>';modDeleteContant();}">
											<i class="normal-icon <?php echo $Row_list["sys_menu_icon"]?> bigger-140"></i>
											<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
                                        </div>
										<div class="dd2-content"><?php echo rechangeQuot($Row_list["sys_menu_name".$_SESSION["core_session_sys_language"]]);?>
                                        
                                        <div class="pull-right action-buttons" style="float: right;">
                                                    
                                                    
                                                    <span style="padding-right:45px;">
													<?php echo $Row_list["sys_menu_moduletype"]?>
                                                    </span>
                                                  
                                                   
                                                     
                                                     <i class="icon ni ni-eye text-primary" onClick="document.myForm.myContantID.value ='<?php echo $Row_list["sys_menu_id"]?>';modLoadView();" style="cursor:pointer;"></i>&nbsp;
					 
                      <i class="icon ni ni-pen-alt-fill text-success" onclick="document.myForm.myContantID.value ='<?php echo $Row_list["sys_menu_id"]?>'; modLoadAddNew();" style="cursor:pointer;"></i>
					 
						 <a href="javascript:void(0)" id="id-btn-dialog<?php echo $index.$index_list?>" onclick="if(confirm('คุณต้องการลบข้อมูลหรือไม่?')){document.myForm.myContantID.value ='<?php echo $Row_list["sys_menu_id"]?>';modDeleteContant();}">
                        <i class="icon ni ni-trash-alt text-danger"></i>
                        </a>
										  
                
                 							
                                                    </div>
                                                    </div>
									</li>
                                    <?php $index_list++;}//while($Row_list=mysql_fetch_array($Query_list)){?>
                                <?php if($Row["sys_menu_ismodule"]==2) { ?>
                                <li style="padding-bottom:10px;">

                                <a href="javascript:void(0)" class="badge badge-dim badge-outline-warning d-none d-md-inline-flex" onClick="addContantMenu('<?php echo $Row["sys_menu_id"]?>')">
                                <em class="icon ni ni-plus-sm"></em><span><?php echo $txt_mod["menu:add"];?></span> </a>
                               <!-- <a href="javascript:void(0)" onClick="addContantMenu('<?php echo $Row["sys_menu_id"]?>')"><font color=#999999>&lt;&lt;Add Menu&gt;&gt;</font></a>-->
        						</li>
        						<?php }//if ($Row["sys_menu_ismodule"]==2) {?>

								</ol>
							
                            </div>
								</li>
                                
											<?php
											$index++;}//while($Row=mysql_fetch_array($Query)) { ?>

								</ol>
                                           
                                        </div>
                                    </div><!-- .card-preview -->
                                    </div><!-- .nk-block-head-content -->                  
                            </div><!-- .nk-block -->

</form>
<?php }elseif($_POST["myaction"]=="addnew"){?> 
<form action="" method="post" name="myForm" id="myForm" class="form-validate is-alter">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" /> 
            <input name="inputgroupID" type="hidden" id="inputgroupID" value="<?php echo $_REQUEST["inputgroupID"]?>" /> 
            <input name="myParentID" type="hidden" id="myParentID" value="<?php echo $_REQUEST["myParentID"]?>" />
            <?php
			if($_POST["myContantID"]!=""){
             $sql = "SELECT * FROM sys_menu WHERE sys_menu_id='". $_POST["myContantID"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			}
			 ?>
<div class="nk-block nk-block-lg">
                                    
                                    <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                 <h4 class="nk-block-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h4>
                                                 <br />
                                            </div>
                                            <div class="nk-block-head-content">
                                                <a href="javascript:void(0)" class="btn btn-outline-light bg-white d-none d-sm-inline-flex" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em><span><?php echo $txt_language["but:back"]?></span></a>
                                                <a href="javascript:void(0)" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em></a>
                                            </div>
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
																	<select class="form-control" id="inputLevel" name="inputLevel">
																			<option value="admin" <?php echo ($Row["sys_menu_level"]=='admin')?"selected":""?>>Admin</option>
                                                                            <option value="member" <?php echo ($Row["sys_menu_level"]=='member')?"selected":""?>>Member</option>
                                                                    </select>
                                                               </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee"><?php echo $txt_mod["menu:icon"]?></label>
                                                            <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right"><em class="icon ni ni-layers-fill"></em></div>
                                                            <input type="text" class="form-control" id="inputName" name="inputName" readonly="readonly" onclick="js_popup('menu_select_icon.php',500,295); return false;" value="<?php echo $Row['sys_menu_icon']?>" style="cursor:pointer;">
                                                            <input type="text" id="inputIconName" name="inputIconName" class="form-control"  value="<?php echo $Row['sys_menu_icon']?>" style="display:none;" /> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:namemunu"]?> <?php echo $txt_language["lang:supportname"][1]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmenunamethai" name="inputmenunamethai" value="<?php echo $Row['sys_menu_namethai']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:namemunu"]?> <?php echo $txt_language["lang:supportname"][2]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmenunameeng" name="inputmenunameeng" value="<?php echo $Row['sys_menu_nameeng']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:type"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputMenu_LinkType" id="inputMenu_LinkType1" type="radio" class="custom-control-input" onclick="
document.getElementById('rowModule').style.display='';
document.getElementById('rowModuleKey').style.display='';
document.getElementById('rowURL').style.display='none';
document.getElementById('rowTarget').style.display='';
" value="1" <?php if($Row['sys_menu_moduletype']=="Module" || $Row['sys_menu_moduletype']==""){
echo "checked=\"checked\"";
}?>/>
                                                                <label class="custom-control-label" for="inputMenu_LinkType1">&nbsp;Module</label>
                                                                </div>
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputMenu_LinkType" id="inputMenu_LinkType2" type="radio" class="custom-control-input" onclick="
document.getElementById('rowModule').style.display='none';
document.getElementById('rowModuleKey').style.display='none';
document.getElementById('rowURL').style.display='';
document.getElementById('rowTarget').style.display='';
" value="0" <?php if($Row['sys_menu_moduletype']=="Link"){
echo "checked=\"checked\"";
}?>/>
                                                                <label class="custom-control-label" for="inputMenu_LinkType2">&nbsp;Link</label>
                                                                </div>
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputMenu_LinkType" id="inputMenu_LinkType3" type="radio" class="custom-control-input" onclick="
document.getElementById('rowModule').style.display='none';
document.getElementById('rowModuleKey').style.display='none';
document.getElementById('rowURL').style.display='none';
document.getElementById('rowTarget').style.display='none';
" value="2" <?php if($Row['sys_menu_moduletype']=="Group"){
echo "checked=\"checked\"";
}?>/>
                                                                <label class="custom-control-label" for="inputMenu_LinkType3">&nbsp;Group</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowModule" <?php if($Row['sys_menu_moduletype']=="Group" || $Row['sys_menu_moduletype']=="Link"){ ?> style="display:none"<?php } ?>>
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:address"]?> </label>
                                                            <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right"><em class="icon ni ni-folders-fill"></em></div>
                                                                <input type="text" class="form-control" id="inputlinkpath" name="inputlinkpath" value="<?php echo $Row['sys_menu_linkpath']?>" onclick="js_popup('menu_select_mod.php',500,295); return false;"  style="cursor:pointer;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowURL" <?php if($Row['sys_menu_moduletype']=="Module" || $Row['sys_menu_moduletype']=="Group" || $Row['sys_menu_moduletype']==""){ ?> style="display:none"<?php } ?>>
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:link"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmenuurl" name="inputmenuurl" value="<?php echo ($Row['sys_menu_linkpath']!="")?$Row['sys_menu_linkpath']:"http://"?><?php echo $Row['sys_menu_mobile']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowModuleKey">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:masterkey"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmasterkey" name="inputmasterkey" value="<?php echo $Row['sys_menu_masterkey']?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowTarget">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:show"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputmenutarget" id="inputmenutarget1" type="radio" class="custom-control-input" value="_parent" checked="checked"/>
                                                                <label class="custom-control-label" for="inputmenutarget1">&nbsp;<?php echo $txt_mod["menu:oldwindows"]?></label>
                                                                </div>
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputmenutarget" id="inputmenutarget2" type="radio" class="custom-control-input" value="_blank"/>
                                                                <label class="custom-control-label" for="inputmenutarget2">&nbsp;<?php echo $txt_mod["menu:newwindows"]?></label>
                                                                </div>
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
                                </div><!-- .nk-block -->
</form>
<script language="javascript">
function js_popup(theURL,width,height) { //v2.0
	leftpos = (screen.availWidth - width) / 2;
    	toppos = (screen.availHeight - height) / 2;
  	window.open(theURL, "viewdetails","width=" + width + ",height=" + height + ",left=" + leftpos + ",top=" + toppos);
}
</script>
<?php }elseif($_POST["myaction"]=="insert"){
				$inputLevel=$_POST['inputLevel'];
				$inputmenutarget=$_POST['inputmenutarget'];
				$inputIconName=$_POST['inputIconName'];
				$inputmenunamethai=$_POST['inputmenunamethai'];
				$inputmenunameeng=$_POST['inputmenunameeng'];
				$inputMenu_LinkType=$_POST['inputMenu_LinkType'];
				$inputModuleName=$_POST['inputModuleName'];
				$inputmasterkey=$_POST['inputmasterkey'];
				$inputlinkpath=$_POST['inputlinkpath'];
				$myParentID=$_POST['myParentID'];
				
				$inputModuleName='Module';
				if($inputMenu_LinkType==0) { 
					$inputModuleName="Link"; 
					$inputlinkpath=$inputmenuurl;
				}
				if($inputMenu_LinkType==2) { 
					$inputModuleName="Group"; 
				}
				if($myParentID==""){
					$myParentID=0;
				}
					
				if($_POST["myContantID"]!=""){
					
					$update[]="sys_menu_level ='".$inputLevel."'";
					$update[]="sys_menu_target ='".$inputmenutarget."'";
					$update[]="sys_menu_icon='".$inputIconName."'";
					$update[]="sys_menu_namethai='".$inputmenunamethai."'";
					$update[]="sys_menu_nameeng='".$inputmenunameeng."'";
					$update[]="sys_menu_ismodule='".$inputMenu_LinkType."'";
					$update[]="sys_menu_moduletype='".$inputModuleName."'";
					$update[]="sys_menu_masterkey='".$inputmasterkey."'";
					$update[]="sys_menu_linkpath='".$inputlinkpath."'";
	
					$sql_update="UPDATE sys_menu SET ".implode(",",$update)." WHERE sys_menu_id='".$_POST["myContantID"]."'";
					$Query=$mysqli->query($sql_update) OR DIE("Error sql_update: <br>$sql_update<br>\n");
					
				}else{
					$sql = "SELECT MAX(sys_menu_order) FROM sys_menu";
					$Query=$mysqli->query($sql);
					$Row=$Query->fetch_array();
					$maxOrder = $Row[0]+1;
		
					unset($insert);
					$insert["sys_menu_level"] = "'".$inputLevel."'";
					$insert["sys_menu_target"] = "'".$inputmenutarget."'";
					$insert["sys_menu_icon"] = "'".$inputIconName."'";
					$insert["sys_menu_namethai"] = "'".$inputmenunamethai."'";
					$insert["sys_menu_nameeng"] = "'".$inputmenunameeng."'";
					$insert["sys_menu_ismodule"] = "'".$inputMenu_LinkType."'";
					$insert["sys_menu_moduletype"] = "'".$inputModuleName."'";
					$insert["sys_menu_masterkey"] = "'".$inputmasterkey."'";
					$insert["sys_menu_linkpath"] = "'".$inputlinkpath."'";
					$insert["sys_menu_order"] = "'".$maxOrder."'";
					$insert["sys_menu_parentid"] = "'".$myParentID."'";
					$insert["sys_menu_status"] = "'Enable'";

			//echo	"sql_insert=".
					$sql_insert="INSERT INTO sys_menu(".implode(",",array_keys($insert)).") VALUES (".implode(",",array_values($insert)).")";
					$Query_insert=$mysqli->query($sql_insert) OR DIE("Error sql_insert: <br>$sql_insert<br>\n");
					$contantID=$mysqli->insert_id;

				}
}elseif($_POST["myaction"]=="changestatus"){
		$loaddder=$_POST['Valueloaddder'];
		$tablename=$_POST['Valuetablename'];
		$statusname=$_POST['Valuestatusname'];
		$statusid=$_POST['Valuestatusid'];
		$loadderstatus=$_POST['Valueloadderstatus'];
		$filestatus=$_POST['Valuefilestatus'];
		$myaction=$_POST['myaction'];
		
		
		if($statusname=="Disable"){
		$inputstatusname="Enable";
		}else if($statusname=="Enable"){
		$inputstatusname="Disable";
		}
     	$sql = "UPDATE ".$tablename." SET "
		.$tablename."_status= '".$inputstatusname."'  WHERE ".$tablename."_id='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		$sql = "UPDATE ".$tablename." SET "
		.$tablename."_status= '".$inputstatusname."'  WHERE ".$tablename."_parentid='". $statusid."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
	?>
    	<?php  if($inputstatusname=="Enable"){?>
            <div class="custom-control custom-switch">   
<input name="switch-field-1" id="switch-field-<?php echo $statusid?>" class="custom-control-input" type="checkbox" onclick="changeStatus('load_waiting<?php echo $statusid?>','<?php echo $tablename?>','<?php echo $inputstatusname?>','<?php echo $statusid?>','load_status<?php echo $statusid?>','<?php echo $myaction?>')" checked="checked">
				<label class="custom-control-label" for="switch-field-<?php echo $statusid?>"></label>
                </div>
                <?php }else{ ?>
                <div class="custom-control custom-switch">   
				<input name="switch-field-1" id="switch-field-<?php echo $statusid?>" class="custom-control-input" type="checkbox" onclick="changeStatus('load_waiting<?php echo $statusid?>','<?php echo $tablename?>','<?php echo $inputstatusname?>','<?php echo $statusid?>','load_status<?php echo $statusid?>','<?php echo $myaction?>')">
                <label class="custom-control-label" for="switch-field-<?php echo $statusid?>"></label>
                </div>
                <?php }?>
<?php }elseif($_POST["myaction"]=="delete"){
	
		$sql="DELETE FROM sys_menu WHERE sys_menu_id='".$_POST['myContantID']."'";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		/*$sql_permission="DELETE FROM sys_mis WHERE sys_mis_menuid='".$_POST['myContantID']."'";
		$Query_permission=$mysqli->query($sql_permission);*/
		
	
}else if($_POST["myaction"]=="updatesortmenu"){
	 
 
 	$name=$_POST["sortid"];
$nameDemo=explode("|x|",$name);
$countDemo=count($nameDemo);
	for($i=0;$i<$countDemo;$i++){
		if($nameDemo[$i]!="null"){
			$sort=$i;
			
			$sql = "UPDATE sys_menu SET sys_menu_order = '".$sort."' WHERE sys_menu_id='".$nameDemo[$i]."'";
			$Query = $mysqli->query($sql);
		}
	}		
?>
<?php }else if($_POST["myaction"]=="sortmenu"){ ?>     
<form action="" method="post" name="myForm" id="myForm">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="inputgroupID" type="hidden" id="inputgroupID" value="<?php echo $_REQUEST["inputgroupID"]?>" /> 
            <input name="myParentID" type="hidden" id="myParentID" value="<?php echo $_REQUEST["myParentID"]?>" />
            <input name="sortid" type="hidden" id="sortid" value="<?php echo $_REQUEST["sortid"]?>" />
            <?php if($myParentID==""){
			$myParentID=0;
			}
 	  $sql = "SELECT * FROM sys_menu WHERE sys_menu_status='Enable' AND sys_menu_parentid='0'  ORDER BY sys_menu_order ASC ";
			$Query=$mysqli->query($sql) ;
			$RecordCount=$Query->num_rows;

		?>
<div class="nk-block nk-block-lg">
                                    
                                    <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                 <h4 class="nk-block-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h4>
                                                 <br />
                                            </div>
                                            <div class="nk-block-head-content">
                                                <a href="javascript:void(0)" class="btn btn-outline-light bg-white d-none d-sm-inline-flex" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em><span><?php echo $txt_language["but:back"]?></span></a>
                                                <a href="javascript:void(0)" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em></a>
                                            </div>
                                        </div>
                                    </div><!-- .nk-block-head -->
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                                <div class="row g-gs">
                                                    
                                                	<div class="dd dd-draghandle col-xs-12" >
											<ol class="dd-list" id="nestable">
                                            <?php
											$i=1;
											while($Row=$Query->fetch_array()) { 
											
											?>
												<li class="dd-item dd2-item" id="<?php echo $Row["sys_menu_id"]?>">
													<div class="dd-handle dd2-handle">
                                                    
														<i class="normal-icon <?php echo $Row["sys_menu_icon"]?> bigger-140"></i>

														<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
													</div>
                                                     <?php
                                                    //// เมนูย่อย
               				$sql_list = "SELECT * FROM sys_menu Where sys_menu_parentid='".$Row["sys_menu_id"]."' ORDER BY sys_menu_order ASC ";
							$Query_list=$mysqli->query($sql_list);
							$RecordCount_list=$Query_list->num_rows;
							?>
													<div class="dd2-content"><?php if($RecordCount_list>0){?><i class="ace-icon glyphicon glyphicon-minus" style="cursor:pointer" id="icon_donw<?php echo $i?>" onclick="down(<?php echo $i?>)"></i><i class="ace-icon glyphicon glyphicon-plus" style="cursor:pointer;display:none" id="icon_up<?php echo $i?>" onclick="up(<?php echo $i?>)"></i>&nbsp;<?php }?><?php echo $Row["sys_menu_name".$_SESSION["core_session_sys_language"]];?><div class="pull-right action-buttons" style="padding-right:10px; float:right;"><?php echo $Row["sys_menu_moduletype"]?></div></div>
                                                   
							<?php if($RecordCount_list>0){?>
                            <div id="menu_<?php echo $i?>">
								<ol class="dd-list" id="nestable_list<?php echo $i?>" style="padding-left:35px;">
                                 <?php 
								 while($Row_list=$Query_list->fetch_array()){?>
									<li class="dd-item dd2-item" id="<?php echo $Row_list["sys_menu_id"]?>">
										<div class="dd-handle dd2-handle">
											<i class="normal-icon <?php echo $Row_list["sys_menu_icon"]?>"></i>
											<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
                                        </div>
										<div class="dd2-content"><?php echo $Row_list["sys_menu_name".$_SESSION["core_session_sys_language"]];?><div class="pull-right action-buttons" style="padding-right:10px;float:right;"><?php echo $Row_list["sys_menu_moduletype"]?></div></div>
									</li>
                                    <?php }//while($Row_list=mysql_fetch_array($Query_list)){?>

								</ol>
							<?php }//if($RecordCount_list>0){?>
								</li>
											<?php
											$i++;}//while($Row=mysql_fetch_array($Query)) { ?>

								</ol>
                                <input type="hidden" name="RecordCount" id="RecordCount" value="<?php echo $RecordCount?>" />
                                </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" onclick="updateContantSort();"><?php echo $txt_language["but:save"]?></button>
                                                        
                                                            <button type="button" class="btn btn-warning" onclick="modLoadContent()"><?php echo $txt_language["but:cancel"]?></button>
                                                        </div>
                                                    </div>
                                              
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
</form>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script language="JavaScript"  type="text/javascript">
function down(menu){
	document.getElementById("menu_"+menu).style.display = 'none'; 
	document.getElementById("icon_donw"+menu).style.display = 'none'; 
	document.getElementById("icon_up"+menu).style.display = ''; 
}
function up(menu){
	document.getElementById("menu_"+menu).style.display = ''; 
	document.getElementById("icon_donw"+menu).style.display = ''; 
	document.getElementById("icon_up"+menu).style.display = 'none';
}
</script>
<script language="JavaScript"  type="text/javascript">
var idlist=null;
var allidlist=null;

	//เมนูหลัก
	jQuery(function() {
		jQuery("#nestable").sortable({
		placeholder: 'dd-handle',
		update:function(){
		var items = jQuery(".dd-item");
		var photos = [];
		allidlist=null;
		for(var x=0; x<items.length; x++)
		{
		var photo = {}
		photo.id = items[x].id;       
		allidlist= allidlist+'|x|'+photo.id;
		document.myForm.sortid.value =allidlist;
		//alert(document.myForm.sortid.value);
		}
		}
	
	});
	jQuery("#nestable").disableSelection();
	});

	//เมนูย้อย
	var index=document.getElementById("RecordCount").value;
	for(var i=1;i<=index;i++){
		jQuery(function() {
			jQuery("#nestable_list"+i).sortable({
			placeholder: 'dd-handle',
			update:function(){
			var items = jQuery(".dd-item");
			var photos = [];
			allidlist=null;
			for(var x=0; x<items.length; x++)
			{
			var photo = {}
			photo.id = items[x].id;       
			allidlist= allidlist+'|x|'+photo.id;
			document.myForm.sortid.value =allidlist;
			//alert(document.myForm.sortid.value);
			}
			}
		
		});
		jQuery("#nestable_list").disableSelection();
		});
	}


  </script>

<?php }elseif($_POST["myaction"]=="view"){?>
<form action="" method="post" name="myForm" id="myForm">
            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
            <input name="myaction" type="hidden" id="myaction" value="" />
            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
            <input name="myContantID" type="hidden" id="myContantID" value="<?php echo $_REQUEST["myContantID"]?>" /> 
            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
            <input name="module_pageshow" type="hidden" id="module_pageshow" value="<?php echo $_REQUEST["module_pageshow"]?>" />
			<input name="module_pagesize" type="hidden" id="module_pagesize" value="<?php echo $_REQUEST["module_pagesize"]?>" />
			<input name="module_orderby" type="hidden" id="module_orderby" value="<?php echo $_REQUEST["module_orderby"]?>" />
            <input name="module_adesc" type="hidden" id="module_adesc" value="<?php echo $_REQUEST["module_adesc"]?>" />
            <?php
			if($_POST["myContantID"]!=""){
             $sql = "SELECT * FROM sys_menu WHERE sys_menu_id='". $_POST["myContantID"]."'";
			 $query=$mysqli->query($sql) or die("Error sql:  <br/>$sql<br />\n");
			 $Row=$query->fetch_array();
			}
			 ?>
<div class="nk-block nk-block-lg">
                                    
                                    <div class="nk-block-between g-3">
                                            <div class="nk-block-head-content">
                                                 <h4 class="nk-block-title"><?php echo getNameMenu($_POST["menukeyid"]);?></h4>
                                                 <br />
                                            </div>
                                            <div class="nk-block-head-content">
                                                <a href="javascript:void(0)" class="btn btn-outline-light bg-white d-none d-sm-inline-flex" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em><span><?php echo $txt_language["but:back"]?></span></a>
                                                <a href="javascript:void(0)" class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none" onclick="modLoadContent();"><em class="icon ni ni-arrow-left"></em></a>
                                            </div>
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
																	<select class="form-control" id="inputLevel" name="inputLevel" disabled="disabled">
																			<option value="admin" <?php echo ($Row["sys_menu_level"]=='admin')?"selected":""?>>Admin</option>
                                                                            <option value="admin" <?php echo ($Row["sys_menu_level"]=='member')?"selected":""?>>Member</option>
                                                                    </select>
                                                               </div>
                                                             </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inptfee"><?php echo $txt_mod["menu:icon"]?></label>
                                                            <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right"><em class="icon ni ni-layers-fill"></em></div>
                                                            <input type="text" class="form-control" id="inputName" name="inputName" readonly="readonly" value="<?php echo $Row['sys_menu_icon']?>" style="cursor:pointer;">
                                                            <input type="text" id="inputIconName" name="inputIconName" class="form-control"  value="<?php echo $Row['sys_menu_icon']?>" style="display:none;" /> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:namemunu"]?> <?php echo $txt_language["lang:supportname"][1]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmenunamethai" name="inputmenunamethai" value="<?php echo $Row['sys_menu_namethai']?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:namemunu"]?> <?php echo $txt_language["lang:supportname"][2]?></label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmenunameeng" name="inputmenunameeng" value="<?php echo $Row['sys_menu_nameeng']?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:type"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputMenu_LinkType" id="inputMenu_LinkType1" type="radio" class="custom-control-input" value="1" <?php if($Row['sys_menu_moduletype']=="Module" || $Row['sys_menu_moduletype']==""){
echo "checked=\"checked\"";
}?> disabled="disabled"/>
                                                                <label class="custom-control-label" for="inputMenu_LinkType1">&nbsp;Module</label>
                                                                </div>
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputMenu_LinkType" id="inputMenu_LinkType2" type="radio" class="custom-control-input" value="0" <?php if($Row['sys_menu_moduletype']=="Link"){
echo "checked=\"checked\"";
}?> disabled="disabled"/>
                                                                <label class="custom-control-label" for="inputMenu_LinkType2">&nbsp;Link</label>
                                                                </div>
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputMenu_LinkType" id="inputMenu_LinkType3" type="radio" class="custom-control-input" value="2" <?php if($Row['sys_menu_moduletype']=="Group"){
echo "checked=\"checked\"";
}?> disabled="disabled"/>
                                                                <label class="custom-control-label" for="inputMenu_LinkType3">&nbsp;Group</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowModule" <?php if($Row['sys_menu_moduletype']=="Group" || $Row['sys_menu_moduletype']=="Link"){ ?> style="display:none"<?php } ?>>
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:address"]?> </label>
                                                            <div class="form-control-wrap">
                                                            <div class="form-icon form-icon-right"><em class="icon ni ni-folders-fill"></em></div>
                                                                <input type="text" class="form-control" id="inputlinkpath" name="inputlinkpath" value="<?php echo $Row['sys_menu_linkpath']?>" readonly="readonly" onclick="js_popup('menu_select_mod.php',500,295); return false;"  style="cursor:pointer;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowURL" <?php if($Row['sys_menu_moduletype']=="Module" || $Row['sys_menu_moduletype']=="Group" || $Row['sys_menu_moduletype']==""){ ?> style="display:none"<?php } ?>>
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:link"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmenuurl" name="inputmenuurl" value="<?php echo ($Row['sys_menu_linkpath']!="")?$Row['sys_menu_linkpath']:"http://"?><?php echo $Row['sys_menu_mobile']?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowModuleKey">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:masterkey"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="inputmasterkey" name="inputmasterkey" value="<?php echo $Row['sys_menu_masterkey']?>" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6" id="rowTarget">
                                                        <div class="form-group">
                                                            <label class="form-label" for="inputmin"><?php echo $txt_mod["menu:show"]?> </label>
                                                            <div class="form-control-wrap">
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputmenutarget" id="inputmenutarget1" type="radio" class="custom-control-input" value="_parent" checked="checked" disabled="disabled"/>
                                                                <label class="custom-control-label" for="inputmenutarget1">&nbsp;<?php echo $txt_mod["menu:oldwindows"]?></label>
                                                                </div>
                                                                <div class="custom-control custom-radio">
                                                                <input name="inputmenutarget" id="inputmenutarget2" type="radio" class="custom-control-input" value="_blank" disabled="disabled"/>
                                                                <label class="custom-control-label" for="inputmenutarget2">&nbsp;<?php echo $txt_mod["menu:newwindows"]?></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-primary" onclick="document.myForm.myContantID.value ='<?php echo $Row['sys_menu_id']?>';modLoadAddNew();"><?php echo $txt_language["but:edit"]?></button>
                                                        
                                                            <button type="button" class="btn btn-warning" onclick="modLoadContent()"><?php echo $txt_language["but:cancel"]?></button>
                                                        </div>
                                                    </div>
                                              
                                        </div>
                                    </div>
                                </div><!-- .nk-block -->
</form>
             
<?php }?>