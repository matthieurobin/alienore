<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - <?php echo \MVC\Language::T('SignIn'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.css" rel="stylesheet">
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap-responsive.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
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
                        <a class="navbar-brand" href="."><?php echo Install\App::NAME; ?></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">

                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>    

        </div>
        <div class="container">
            <div class="helper">
                <?php APPLI\V\Helper::display(); ?>
            </div>
            <form class="form-signin" role="form" action="?c=users&a=auth" method="post">
                <h2 class="form-signin-heading">
                    <?php echo \MVC\Language::T('SignIn')?>
                </h2>
                <input name="username" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('Username')?>">
                <input name="password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password')?>">
                <!--<label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>-->
                <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo \MVC\Language::T('SignIn')?></button>
            </form>
            
        </div> <!-- /container -->

        <div id="footer">
            <?php echo \Install\App::COPYRIGHT ?>
        </div>
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>perso.js"></script>
    </body>
</html>