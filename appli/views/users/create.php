<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo Config\App::NAME; ?> - <?php echo \MVC\Language::T('CreateAnAccount'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo \Config\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
    <!-- Application CSS -->
    <link href="<?php echo \Config\Path::CSS; ?>main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo \Config\Path::IMG; ?>favicon.png" />
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
                    <a class="navbar-brand" href="."><img class="logo" src="<?php echo \Config\Path::IMG; ?>logo.png"></img></a>
                </div>
            </div>
        </div>    

    </div>
    <div class="container">
        <form class="form-signin" role="form" action="?c=users&a=saved" method="post">
            <h2 class="form-signin-heading">
                <?php echo \MVC\Language::T('CreateAnAccount') ?>
            </h2><br>
            <input name="username" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('Username') ?>" required autofocus><br>
            <input name="password" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>" required><br>
            <input name="passwordRepeat" type="password" class="form-control" placeholder="<?php echo \MVC\Language::T('Repeat password') ?>" required><br>

            <?php echo \MVC\Language::T('Language') ?> <select name="language" class="form-control">
            <option selected value="en"><?php echo MVC\Language::T('English') ?></option>
            <option  value="fr"><?php echo MVC\Language::T('French') ?></option>
        </select><br>
        <input name="email" type="email" class="form-control" placeholder="<?php echo \MVC\Language::T('Email Address') ?>" required><br>
                <!--<label class="checkbox">
                    <input type="checkbox" value="remember-me"> Remember me
                </label>-->
                <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo \MVC\Language::T('Submit') ?></button>
            </form>

        </div> <!-- /container -->

        <div id="footer">
            <?php echo \MVC\Language::T('By') ?> <?php echo \Config\App::COPYRIGHT ?> - <?php echo \Config\App::VERSION ?>
        </div>
        <script src="<?php echo \Config\Path::JS; ?>jquery.js"></script>
        <script src="<?php echo \Config\Path::JS; ?>bootstrap.js"></script>
        <script src="<?php echo \Config\Path::JS; ?>perso.js"></script>
        <script>
            $(document).ready(function() {
                duplicatePaging();
            });
        </script>
    </body>
    </html>