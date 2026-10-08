<div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="../home/index.php" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="../../images/logo.png" srcset="../../images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="../../images/logo-dark.png" srcset="../../images/logo-dark2x.png 2x" alt="logo-dark">
                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                 <?php			//// เมนูหลัก
								$sql = "SELECT * FROM sys_menu Where sys_menu_parentid='0' AND sys_menu_status='Enable' AND sys_menu_level='admin'  ORDER BY sys_menu_order ASC ";
								$Query=$mysqli->query($sql);
								while($Row=$Query->fetch_array()){
								$chk_permissionID = getUserPermissionOnMenu($_SESSION["core_session_sys_grpid"],$Row["sys_menu_id"]);
								if($chk_permissionID!="NA"){
									if($Row["sys_menu_moduletype"]=="Module" || $Row["sys_menu_moduletype"]=="Link"){
										$linkURL=$Row["sys_menu_linkpath"]."?masterkey=".$Row["sys_menu_masterkey"]."&&menukeyid=".$Row["sys_menu_id"]."&&MenuActive=".$Row["sys_menu_id"];
									}else{
										$linkURL="#";
									}
								//// เมนูย่อย
								$sql_list = "SELECT * FROM sys_menu Where sys_menu_parentid='".$Row["sys_menu_id"]."' ORDER BY sys_menu_order ASC ";
								$Query_list=$mysqli->query($sql_list);
								$RecordCount=$Query_list->num_rows;

								?>
                                <li class="nk-menu-item current-page <?php if($RecordCount>0){echo "has-sub";} if($_GET['MenuActive']==$Row["sys_menu_id"]){echo " active";}?>">
                                    <a href="<?php echo $linkURL;?>" class="nk-menu-link <?php if($RecordCount>0){echo "nk-menu-toggle";}?>">
                                        <span class="nk-menu-icon"><em class="<?php echo $Row["sys_menu_icon"];?>"></em></span>
                                        <span class="nk-menu-text"><?php echo $Row["sys_menu_name".$_SESSION["core_session_sys_language"]]?></span>
                                    </a>
									 <?php if($RecordCount>0){?>
                                    <ul class="nk-menu-sub" <?php if($_GET['MenuActive']==$Row["sys_menu_id"]){echo "style='display: block;'";}?>>
                                    	<?php 
										while($Row_list=$Query_list->fetch_array()){
										$chk_permissionsubID = getUserPermissionOnMenu($_SESSION["core_session_sys_grpid"],$Row_list["sys_menu_id"]);
										if($chk_permissionsubID!="NA"){
											if($Row_list["sys_menu_moduletype"]=="Module" || $Row_list["sys_menu_moduletype"]=="Link"){
												$linkURL_list=$Row_list["sys_menu_linkpath"]."?masterkey=".$Row_list["sys_menu_masterkey"]."&&menukeyid=".$Row_list["sys_menu_id"]."&&MenuActive=".$Row["sys_menu_id"]."&&SubMenuActive=".$Row_list["sys_menu_id"];
											}else{
												$linkURL_list="#";
											}
										?>
                                        <li class="nk-menu-item current-page <?php if($_GET['SubMenuActive']==$Row_list["sys_menu_id"]){ echo "active"; }?>">
                                            <a href="<?php echo $linkURL_list;?>" class="nk-menu-link"><span class="nk-menu-text"><?php echo $Row_list["sys_menu_name".$_SESSION["core_session_sys_language"]]?></span></a>
                                        </li>
                                        <?php  }//if($chk_permissionsubID!="NA"){
										}//while($Row_list=$Query_list->fetch_array()){?>
                                    </ul><!-- .nk-menu-sub -->
                                    <?php }//if($RecordCount>0){?>
                                </li><!-- .nk-menu-item -->
                                <?php } //if($chk_permissionID!="NA"){
								}// while($Row=mysql_fetch_array($Query)){?>
                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>