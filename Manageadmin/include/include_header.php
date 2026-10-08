<?php
error_reporting(E_ALL);
if($_SESSION['core_session_sys_language']=="thai"){
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../libs/language_eng.php");	
}
$txturl=curPageName();
?>
<div class="nk-header nk-header-fluid is-theme">
                <div class="container-xl wide-xl">
                    <div class="nk-header-wrap">
                        <div class="nk-menu-trigger mr-sm-2 d-lg-none">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-menu"></em></a>
                        </div>
                        <div class="nk-header-brand">
                            <a href="../home/index.php" class="logo-link">
                                <img class="logo-light logo-img" src="../../images/logo-dark.png" srcset="../../images/logo-dark.png 2x" alt="logo">
                                <img class="logo-dark logo-img" src="../../images/logo-dark.png" srcset="../../images/logo-dark.png 2x" alt="logo-dark">
                            </a>
                        </div><!-- .nk-header-brand -->
                        <div class="nk-header-menu" data-content="headerNav">
                            <div class="nk-header-mobile">
                                <div class="nk-header-brand">
                                    <a href="html/index.html" class="logo-link">
                                        <img class="logo-light logo-img" src="../../images/logo-dark.png" srcset="../../images/logo-dark.png 2x" alt="logo">
                                        <img class="logo-dark logo-img" src="../../images/logo-dark.png" srcset="../../images/logo-dark.png 2x" alt="logo-dark">
                                    </a>
                                </div>
                                <div class="nk-menu-trigger mr-n2">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="headerNav"><em class="icon ni ni-arrow-left"></em></a>
                                </div>
                            </div>
                            <ul class="nk-menu nk-menu-main ui-s2">
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
                                <li class="nk-menu-item <?php if($RecordCount>0){echo "has-sub";}?> <?php if($_GET['MenuActive']==$Row["sys_menu_id"]){echo " active";}?>">
                                    <a href="<?php echo $linkURL;?>" class="nk-menu-link <?php if($RecordCount>0){echo "nk-menu-toggle";}?>">
                                        <span class="nk-menu-text"><?php echo $Row["sys_menu_name".$_SESSION["core_session_sys_language"]]?> </span>
                                    </a>
                                    <?php if($RecordCount>0){
									?>
                                    <ul class="nk-menu-sub">
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
                        </div><!-- .nk-header-menu -->
                        <div class="nk-header-tools">
                            <ul class="nk-quick-nav">
                                <li class="dropdown user-dropdown order-sm-first">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <div class="user-toggle">
                                            <div class="user-avatar sm">
                                                <em class="icon ni ni-user-alt"></em>
                                            </div>
                                            <div class="user-info d-none d-xl-block">
                                                <div class="user-status"><?php echo $_SESSION["core_session_sys_level"];?></div>
                                                <div class="user-name dropdown-indicator"><?php echo $_SESSION["core_session_sys_name"];?></div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1 is-light">
                                        <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                            <div class="user-card">
                                                <div class="user-avatar">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info">
                                                    <span class="lead-text"><?php echo $_SESSION["core_session_sys_name"];?></span>
                                                    <span class="sub-text"><?php echo $_SESSION["core_session_sys_email"];?></span>
                                                </div>
                                                <div class="user-action">
                                                    <a class="btn btn-icon mr-n2" href="html/invest/profile-setting.html"><em class="icon ni ni-setting"></em></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="profile.php"><em class="icon ni ni-user-alt"></em><span>โปรไฟล์</span></a></li>
                                                
                                                <li><a class="dark-switch" href="#"><em class="icon ni ni-moon"></em><span>โหมดกลางคืน</span></a></li>
                                                
                                            </ul>
                                        </div>
                                        <div class="dropdown-inner">
                                            <ul class="link-list">
                                                <li><a href="../home/auth-logout.php"><em class="icon ni ni-signout"></em><span>ออกจากระบบ</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li><!-- .dropdown -->
                                <li class="dropdown notification-dropdown mr-n1">
                                        <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                            <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right dropdown-menu-s1">
                                            <div class="dropdown-head">
                                                <span class="sub-title nk-dropdown-title">การแจ้งเตือน</span>
                                                <!--<a href="#">Mark All as Read</a>-->
                                            </div>
                                            
                                            <div class="dropdown-body">
                                                <div class="nk-notification">
                                                	<?php 
													$sql_log = "SELECT * FROM md_log WHERE 1=1 ORDER BY md_log_id DESC LIMIT 10";
													$Query_log=$mysqli->query($sql_log) OR DIE("Error sql_log: <br>$sql_log<br>\n");
													$count_record_log=$Query_log->num_rows;
													if($count_record_log>0){
														while($Row_log=$Query_log->fetch_array()){
														?>
													<div class="nk-notification-item dropdown-inner">
                                                        <div class="nk-notification-icon">
                                                        	<em class="icon icon-circle bg-success-dim ni ni-curve-down-right"></em>
                                                        </div>
                                                        <div class="nk-notification-content">
                                                            <div class="nk-notification-text">
                                                            <?php echo getStaffName($Row_log['md_log_crebyid'])." ".$Row_log['md_log_detail']?>
                                                            </div>
                                                            <div class="nk-notification-time"><?php echo timeAgo($Row_log['md_log_credate'])?></div>
                                                        </div>
                                                    </div>
													<?php 
														}//while($Row_log=$Query_log->fetch_array()){
													}else{?>
                                                    <div class="nk-notification-item dropdown-inner">
                                                        <div align="center">ไม่มีแจ้งเตือน</div>
                                                    </div>
                                                   <?php }?>
                                                </div><!-- .nk-notification -->
                                            </div><!-- .nk-dropdown-body -->
                                            
                                            <div class="dropdown-foot center">
                                                <a href="https://gophom.com/Manageadmin/home/notifi.php">ดูทั้งหมด</a>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->
                            </ul><!-- .nk-quick-nav -->
                        </div><!-- .nk-header-tools -->
                    </div><!-- .nk-header-wrap -->
                </div><!-- .container-fliud -->
            </div>