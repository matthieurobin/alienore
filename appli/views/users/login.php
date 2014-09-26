<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo Config\App::NAME; ?> - <?php echo \MVC\Language::T('SignIn'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo \Config\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
    <!-- Application CSS -->
    <link href="<?php echo \Config\Path::CSS; ?>main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo \Config\Path::IMG; ?>favicon.png" />
</head>
<body ng-app="alienore" ng-controller="loginCtrl" id="login">
    <div id="modal-helper"></div>
    <div class="table table-center">
        <div class="cell">
            <div class="center-block">
                <div>
                    <img class="logo img-center" src="<?php echo \Config\Path::IMG; ?>logo.png"></img>
                </div>
                <br>
                <div>
                    <form id="formLogin" class="form-signin" role="form" ng-submit="submitLogin()">
                        <div class="form-group form-group-lg">
                            <input ng-model="formDataLogin.usernameEmail" id="inputToFocus" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('UsernameOrEmail') ?>"><br>
                            <input ng-model="formDataLogin.password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>"><br>
                        </div>
                        <button class="btn btn-lg btn-block btn-warning " type="submit"><?php echo \MVC\Language::T('SignIn') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo \Config\Path::JS; ?>jquery.js"></script>
    <script>
        $(document).ready(function() {
            $('#inputToFocus').focus();
        });
    </script>
    <script src="<?php echo \Config\Path::JS; ?>bootstrap.js"></script>
    <script src="<?php echo \Config\Path::JS; ?>perso.js"></script>
    <script src="<?php echo \Config\Path::JS; ?>angular.min.js"></script>
    <script src="<?php echo \Config\Path::JS; ?>app.angular.js"></script>
</body>
</html>