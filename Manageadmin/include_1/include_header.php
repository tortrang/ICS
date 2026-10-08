<?php
if($_SESSION['core_session_sys_language']=="thai"){
	include("../structure/language_thai.php");
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../structure/language_eng.php");
	include("../libs/language_eng.php");	
}
$txturl=curPageName();
?>
<div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">
                            <div class="nk-menu-trigger d-xl-none ml-n1">
                                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                            </div>
                            <div class="nk-header-brand d-xl-none">
                                <a href="html/index.html" class="logo-link">
                                    <img class="logo-light logo-img" src="../../images/logo.png" srcset="../../images/logo2x.png 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="../../images/logo-dark.png" srcset="../../images/logo-dark2x.png 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->
                          
                           <div class="nk-header-news d-none d-xl-block">
                                <div class="nk-news-list">
                                	
                                     <!--<a class="nk-news-item" href="../order/problem.php?masterkey=problem&&menukeyid=35&&MenuActive=35">
                                        <div class="nk-news-icon">
                                            <em class="icon ni ni-card-view"></em>
                                        </div>
                                        <div class="nk-news-text">
                                            <p>แจ้งเตือน คุณมีรายการพัสดุที่เกิดปัญหา! <span> โปรดตรวจสอบรายละเอียดและแจ้งกลับภายใน 1-2 วันเพื่อให้เราสามารถนำส่งพัสดุของคุณได้อีกครั้ง</span></p>
                                            <em class="icon ni ni-external"></em>
                                        </div>
                                    </a>-->
                                    
                                </div>
                            </div><!-- .nk-header-news -->
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">Verified</div>
                                                    <div class="user-name dropdown-indicator"><?php echo $_SESSION["core_session_sys_name"]?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right dropdown-menu-s1">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">
                                                    <div class="user-avatar">
                                                        <em class="icon ni ni-user-alt"></em>
                                                    </div>
                                                    <div class="user-info">
                                                        <span class="lead-text"><?php echo $_SESSION["core_session_sys_name"]?></span>
                                                        <span class="sub-text"><?php echo $_SESSION["core_session_sys_email"]?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="profile.php"><em class="icon ni ni-user-alt"></em><span>โปรไฟล์</span></a></li>
                                                    <li><a class="dark-switch <?php if($_SESSION["core_session_sys_mode"]=="darkmode"){ echo "active";}?>" href="javascript:void(0)" onclick="switchmode()"><em class="icon ni ni-moon"></em><span>โหมดกลางคืน</span></a></li>
                                                </ul>
                                            </div>
                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li><a href="auth-logout.php"><em class="icon ni ni-signout"></em><span>ออกจากระบบ</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->

                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                
                