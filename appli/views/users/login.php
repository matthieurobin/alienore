<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - <?php echo \MVC\Language::T('SignIn'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="<?php echo \Install\Path::IMG; ?>favicon.png" />
    </head>
    <body>
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
                        <a class="navbar-brand" href="."><img class="logo" src="<?php echo \Install\Path::IMG; ?>logo.png"></img></a>
                    </div>
                </div>
            </div>    

        </div>
        <div class="container">
            <div class="helper">
<?php APPLI\Views\Helper::display(); ?>
            </div>
            <form class="form-signin" role="form" action="?c=users&a=auth" method="post">
                <h2 class="form-signin-heading">
<?php echo \MVC\Language::T('SignIn') ?>
                </h2><br>
                <input id="inputUsername" name="username" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('Username') ?>"><br>
                <input name="password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>"><br>
                <!--<label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>-->
                <div class="btn-toolbar" role="toolbar">
                     <div class="btn-group">
                           <button class="btn btn-lg btn-primary  " type="submit"><?php echo \MVC\Language::T('SignIn') ?></button>
                     </div>
                     <div class="btn-group">
                            <a class="btn btn-lg btn-primary  " href="?c=users&a=create"><?php echo \MVC\Language::T('Register') ?></a>         
                    </div>
            </div>
            </form>
            
        </div> <!-- /container -->

        <div id="footer">
<?php echo \MVC\Language::T('By') ?> <?php echo \Install\App::COPYRIGHT ?> - <?php echo \Install\App::VERSION ?>
        </div>
        <script src="<?php echo \Install\Path::JS; ?>jquery.js"></script>
        <script>
            $(document).ready(function() {
                $('#inputUsername').focus();
            });
        </script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>perso.js"></script>
    </body>
</html>