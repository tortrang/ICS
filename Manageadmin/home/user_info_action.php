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
<?php if($_POST["myaction"]=="addnew"){?> 

<?php }elseif($_POST["myaction"]=="insert"){?>

<?php }elseif($_POST["myaction"]=="changestatus"){?>
		
<?php }elseif($_POST["myaction"]=="delete"){
		for($i=1;$i<=$TotalCheckBoxID;$i++) {
		$myVar="CheckBoxID".$i;
		if(strlen($$myVar)>0) {
		 $permissionID=$$myVar;
		
		 $sql="DELETE FROM sys_staff WHERE staff_id=".$permissionID." ";
		$Query=$mysqli->query($sql)OR DIE("Error sql: <br>$sql<br>\n");
		
		}}
?>

<?php }elseif($_POST["myaction"]=="view"){?>
<!-- content @s -->
            <div class="nk-content nk-content-lg nk-content-fluid">
                <div class="container-xl wide-lg">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-content">
                                    <div class="nk-block-head-sub"><span>My Profile</span></div>
                                    <h2 class="nk-block-title fw-normal">Account Info</h2>
                                    <div class="nk-block-des">
                                        <p>You have full control to manage your own account setting. <span class="text-primary"><em class="icon ni ni-info"></em></span></p>
                                    </div>
                                </div>
                            </div>
                            <ul class="nk-nav nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="html/invest/profile.html">Personal</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="html/invest/profile-setting.html">Security<span class="d-none s-sm-inline"> Setting</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="html/invest/profile-notify.html">Notifications</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="html/invest/profile-connected.html">Connect Social</a>
                                </li>
                            </ul><!-- .nav-tabs -->
                            <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Personal Information</h5>
                                        <div class="nk-block-des">
                                            <p>Basic info, like your name and address, that you use on Nio Platform.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="card card-bordered">
                                    <div class="nk-data data-list">
                                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Full Name</span>
                                                <span class="data-value">Abu Bin Ishtiyak</span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div>
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Email</span>
                                                <span class="data-value">info@softnio.com</span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-lock-alt"></em></span></div>
                                        </div>
                                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Phone Number</span>
                                                <span class="data-value text-soft">Not add yet</span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div>
                                        <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                            <div class="data-col">
                                                <span class="data-label">Date of Birth</span>
                                                <span class="data-value">29 Feb, 1986</span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div>
                                        <div class="data-item" data-toggle="modal" data-target="#profile-edit" data-tab-target="#address">
                                            <div class="data-col">
                                                <span class="data-label">Address</span>
                                                <span class="data-value">2337 Kildeer Drive,<br>Kentucky, Canada</span>
                                            </div>
                                            <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-forward-ios"></em></span></div>
                                        </div>
                                    </div><!-- .nk-data -->
                                </div><!-- .card -->
                                <!-- Another Section -->
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Personal Preferences</h5>
                                        <div class="nk-block-des">
                                            <p>Your personalized preference allows you best use.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="card card-bordered">
                                    <div class="nk-data data-list">
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Language</span>
                                                <span class="data-value">English (United State)</span>
                                            </div>
                                            <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change Language</a></div>
                                        </div>
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Date Format</span>
                                                <span class="data-value">M d, YYYY</span>
                                            </div>
                                            <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change</a></div>
                                        </div>
                                        <div class="data-item">
                                            <div class="data-col">
                                                <span class="data-label">Timezone</span>
                                                <span class="data-value">Bangladesh (GMT +6)</span>
                                            </div>
                                            <div class="data-col data-col-end"><a href="#" data-toggle="modal" data-target="#profile-language" class="link link-primary">Change</a></div>
                                        </div>
                                    </div><!-- .nk-data -->
                                </div><!-- .card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->      
<?php }?>