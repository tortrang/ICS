<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="FXTRB">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="../../images/favicon.png">
    <!-- Page Title  -->
    <title>เข้าสู่ระบบ</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="../../assets/css/dashlite.css?ver=2.2.0">
    <link id="skin-default" rel="stylesheet" href="../../assets/css/theme.css?ver=2.2.0">
</head>

<body class="nk-body npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div style="padding-bottom:10px" align="center"><img src="../../images/logo_back.png"></div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">Sign-In</h4>
                                    </div>
                                </div>
                                <form action="auth-login.php" method="POST">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="inputUser">Username</label>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" id="inputUser" name="inputUser" placeholder="Enter your username" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="inputPass">Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="inputPass">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="inputPass" name="inputPass" placeholder="Enter your Password" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-block" style="background-color:#81f74d;color:#000">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="../../assets/js/bundle.js?ver=2.2.0"></script>
    <script src="../../assets/js/scripts.js?ver=2.2.0"></script>

</html>