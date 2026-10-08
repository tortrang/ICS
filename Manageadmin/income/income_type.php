<?php
include("../libs/session.php");
include("../libs/config.php");
include("../libs/connect.php");
include("../libs/function.php");

if($_SESSION['core_session_sys_language']=="thai"){
	include("../libs/language_thai.php");
}else if($_SESSION['core_session_sys_language']=="eng"){
	include("../libs/language_eng.php");
}
?>
<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="FXTRB">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../../images/favicon.png">
    <!-- Page Title  -->
    <title><?php echo $core_name_title;?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../../assets/css/dashlite.css?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="../../assets/css/theme.css?ver=2.2.0">
    
    
</head>

<body class="nk-body npc-invest bg-lighter <?php if($_SESSION["core_session_sys_mode"]=="darkmode"){ echo "dark-mode";}?>" onLoad="modLoadContent()">
    <div class="nk-app-root">
        <!-- wrap @s -->
        <div class="nk-wrap ">
            <!-- main header @s -->
            <?php include("../include/include_header.php");?>
            <!-- main header @e -->
            <!-- content @s -->
            <div class="nk-content nk-content-fluid">
                <div class="">
                    <div class="nk-content-inner">
                        <div class="nk-content-body">
                        	<div id="load_mainwaiting" style="display:none">
                                 <div class="tb-cell">
                                    <div id="page-loading">
                                    	<div></div>
                                	</div>
                                </div>
                            </div>
                            <div id="load_mainContant">
                            <form action="" method="post" name="myForm" id="myForm">
                            <input name="masterkey" type="hidden" id="masterkey" value="<?php echo $_REQUEST["masterkey"]?>" />
                            <input name="myaction" type="hidden" id="myaction" value="" />
                            <input name="menukeyid" type="hidden" id="menukeyid" value="<?php echo $_REQUEST["menukeyid"]?>" />
                            <input name="submenukeyid" type="hidden" id="submenukeyid" value="<?php echo $_REQUEST["submenukeyid"]?>" />
                            <input name="MenuActive" type="hidden" id="MenuActive" value="<?php echo $_REQUEST["MenuActive"]?>" />
                            <input name="SubMenuActive" type="hidden" id="SubMenuActive" value="<?php echo $_REQUEST["SubMenuActive"]?>" />
                            </form>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content @e -->
            <!-- footer @s -->
            <?php include("../include/include_footer.php");?>
            <!-- footer @e -->
        </div>
        <!-- wrap @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="../../assets/js/bundle.js?ver=2.2.0"></script>
    <script src="../../assets/js/scripts.js?ver=2.2.0"></script>
    <script src="income_type.js"></script>
    
</body>

</html>