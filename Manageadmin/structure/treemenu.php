
<?
#####################################################
function loadTreeMenu($myParentID,$myMID) {
#####################################################
	global $core_db_name,$mod_sys_menu,$SystemMenuID,$core_session_sys_language;

	  $sql = "SELECT * FROM ".$mod_sys_menu." WHERE ".$mod_sys_menu."_parentid='".$myParentID."' ORDER BY ".$mod_sys_menu."_order ASC ";
	$Query=mysql_query($sql) ;
	$RecordCount=mysql_num_rows($Query);
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
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="row">

									<div class="col-xs-12">
										<div class="dd dd-draghandle col-xs-12" >
											<ol class="dd-list" id="nestable">
                                            <?
											$i=1;
											while($Row=mysql_fetch_array($Query)) { 
											
											?>
												<li class="dd-item dd2-item" id="<?=$Row[$mod_sys_menu."_id"]?>">
													<div class="dd-handle dd2-handle" onClick="$('#myContantID').val('<?=$Row[$mod_sys_menu."_id"]?>');
	modLoadView();">
                                                    
														<i class="normal-icon <?=$Row[$mod_sys_menu."_icon"]?> bigger-140"></i>

														<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
													</div>
                                                     <?
                                                    //// เมนูย่อย
               				$sql_list = "SELECT * FROM ".$mod_sys_menu." Where ".$mod_sys_menu."_parentid='".$Row[$mod_sys_menu."_id"]."' ORDER BY ".$mod_sys_menu."_order ASC ";
							$Query_list=mysql_query($sql_list);
							$RecordCount_list=mysql_num_rows($Query_list);
							?>
													<div class="dd2-content"><? if($RecordCount_list>0){?><i class="ace-icon glyphicon glyphicon-minus" style="cursor:pointer" id="icon_donw<?=$i?>" onclick="down(<?=$i?>)"></i><i class="ace-icon glyphicon glyphicon-plus" style="cursor:pointer;display:none" id="icon_up<?=$i?>" onclick="up(<?=$i?>)"></i>&nbsp;<? }?><?=$Row[$mod_sys_menu."_name".$_SESSION["core_session_sys_language"]];?>
                                                    
                                                   
                                                    <!--จัดการ-->
                                                    <div class="pull-right action-buttons">
                                                     
                                                     <i class="ace-icon fa fa-search-plus bigger-160 green" onClick="$('#myContantID').val('<?=$Row[$mod_sys_menu."_id"]?>');
	modLoadView();" style="cursor:pointer;"></i>
    			<? if($_SESSION["core_session_sys_grpid"]==1){?>
					  
                      <i class="ace-icon fa fa-pencil-square-o bigger-160 blue" onclick="document.myForm.myContantID.value ='<?=$Row[$mod_sys_menu."_id"]?>'; modLoadAddNew();" style="cursor:pointer;"></i>
					 
						<? if($RecordCount_list==0) { ?>
                        <i class="ace-icon fa fa-times red bigger-170" onClick="
			if(confirm('คุณต้องการลบเมนูหรือไม่')) {
    $('#myContantID').val('<?=$Row[$mod_sys_menu."_id"]?>');
	modDeleteContant();}" style="cursor:pointer;"></i>
						<? } else { ?>
						<i class="ace-icon fa fa-times red bigger-170"></i>
						<? } ?>					  
                 <? }?>
                 
                 							
                                                    </div>
                                                     <!--สถานะโมดูล-->
                                                    <div class="pull-right action-buttons">
                                                     <span  id="load_status<?=$Row[$mod_sys_menu."_id"]?>" style="padding-right:40px;">
                 <? if($_SESSION["core_session_sys_grpid"]==1){?>
					<? if($Row[$mod_sys_menu."_status"]=="Enable"){?>
                    <input name="switch-field-1" class="ace ace-switch ace-switch-4" type="checkbox" onclick="changeStatus('load_waiting<?=$Row[$mod_sys_menu."_id"]?>','<?=$mod_sys_menu?>','<?=$Row[$mod_sys_menu."_status"]?>','<?=$Row[$mod_sys_menu."_id"]?>','load_status<?=$Row[$mod_sys_menu."_id"]?>','changestatus');" checked="checked">
                    <span class="lbl"></span>
                    <? }else{?>
                    <input name="switch-field-1" class="ace ace-switch ace-switch-4" type="checkbox" onclick="changeStatus('load_waiting<?=$Row[$mod_sys_menu."_id"]?>','<?=$mod_sys_menu?>','<?=$Row[$mod_sys_menu."_status"]?>','<?=$Row[$mod_sys_menu."_id"]?>','load_status<?=$Row[$mod_sys_menu."_id"]?>','changestatus');">
                    <span class="lbl"></span>
                    <? }?>
                 <? }else{?>
                 <? if($Row[$mod_sys_menu."_status"]=="Enable"){?>
                    <input name="switch-field-1" class="ace ace-switch ace-switch-4" type="checkbox" checked="checked">
                    <span class="lbl"></span>
                    <? }else{?>
                    <input name="switch-field-1" class="ace ace-switch ace-switch-4" type="checkbox">
                    <span class="lbl"></span>
                    <? }?>
                 <? }?>
                 </span>
                 </div>
                                                    <!--ประเทภโมดูล-->
                                                    <div class="pull-right action-buttons" style="padding-right:40px;">
                                                  
													<?=$Row[$mod_sys_menu."_moduletype"]?>
                                                    
                                                    </div>
                                                    
                                                    </div>
                                                    
                              
							
                            <div id="menu_<?=$i?>">
								<ol class="dd-list" id="nestable_list" style="padding-left:35px;">
                                 <? 
								 while($Row_list=mysql_fetch_array($Query_list)){?>
									<li class="dd-item dd2-item" id="<?=$Row_list[$mod_sys_menu."_id"]?>">
										<div class="dd-handle dd2-handle" onClick="$('#myContantID').val('<?=$Row_list[$mod_sys_menu."_id"]?>');
	modLoadView();">
											<i class="normal-icon <?=$Row_list[$mod_sys_menu."_icon"]?> bigger-140"></i>
											<i class="drag-icon ace-icon fa fa-arrows bigger-125"></i>
                                        </div>
										<div class="dd2-content"><?=$Row_list[$mod_sys_menu."_name".$_SESSION["core_session_sys_language"]];?>
                                        <div class="pull-right action-buttons">
                                                    
                                                    
                                                    <span style="padding-right:45px;">
													<?=$Row_list[$mod_sys_menu."_moduletype"]?>
                                                    </span>
                                                   
                                                     
                                                     <i class="ace-icon fa fa-search-plus bigger-160 green" onClick="$('#myContantID').val('<?=$Row_list[$mod_sys_menu."_id"]?>');
	modLoadView();" style="cursor:pointer;"></i>
    			<? if($_SESSION["core_session_sys_grpid"]==1){?>
					 
                      <i class="ace-icon fa fa-pencil-square-o bigger-160 blue" onclick="document.myForm.myContantID.value ='<?=$Row_list[$mod_sys_menu."_id"]?>'; modLoadAddNew();" style="cursor:pointer;"></i>
					 
						
                        <i class="ace-icon fa fa-times red bigger-170" onClick="
			if(confirm('คุณต้องการลบเมนูหรือไม่')) {
    $('#myContantID').val('<?=$Row_list[$mod_sys_menu."_id"]?>');
	modDeleteContant();}" style="cursor:pointer;"></i>
										  
                 <? }?>
                 
                 							
                                                    </div>
                                                    </div>
									</li>
                                    <? }//while($Row_list=mysql_fetch_array($Query_list)){?>
                                <? if ($Row[$mod_sys_menu."_ismodule"]==2) { ?>
                                <li style="padding-bottom:10px;">
                                
                                <a href="javascript:void(0)" onClick="addContantMenu('<?=$Row[$mod_sys_menu."_id"]?>')"><font color=#999999>&lt;&lt;Add Menu&gt;&gt;</font></a>
        						</li>
        						<? }?>

								</ol>
							
                            
								</li>
                                
											<?
											$i++;}//while($Row=mysql_fetch_array($Query)) { ?>
                                 <!-- <li>
                                <a href="javascript:void(0)" onClick="addContantMenu('<?=$myParentID?>')"><font color=#999999>&lt;&lt;Add Menu&gt;&gt;</font></a>
        						</li>-->

								</ol>
                                </div>
										</div>
									</div>
								</div><!-- PAGE CONTENT ENDS -->
                                
							</div>
<?
}  // end fuction
?>