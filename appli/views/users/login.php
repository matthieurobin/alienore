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
<body ng-app="alienore" ng-controller="loginCtrl">
    <div id="modal-helper"></div>
    <div id="header">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="."><img class="logo" src="<?php echo \Config\Path::IMG; ?>logo.png"></img></a>
                </div>
            </div>
        </div>    

    </div>
    <div class="container">
        <form id="formLogin" class="form-signin" role="form" ng-submit="submitLogin()">
            <h2 class="form-signin-heading">
                <?php echo \MVC\Language::T('SignIn') ?>
            </h2><br>
            <input ng-model="formDataLogin.usernameEmail" id="inputToFocus" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('UsernameOrEmail') ?>"><br>
            <input ng-model="formDataLogin.password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>"><br>
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group">
                        <button class="btn btn-lg btn-primary " type="submit"><?php echo \MVC\Language::T('SignIn') ?></button>
                    </div>
                </div>
            </form>

        </div> <!-- /container -->
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