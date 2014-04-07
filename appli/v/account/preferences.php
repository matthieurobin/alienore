<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - <?php echo \MVC\Language::T('Home'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="<?php echo \Install\Path::IMG; ?>favicon.png" />
    </head>
    <body>
        <div id="header">
            <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="."><img class="logo" src="<?php echo \Install\Path::IMG; ?>logo.png"></img></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="."><?php echo \MVC\Language::T('Home'); ?></a></li>
                        <li><a href="?c=tags&a=all"><?php echo \MVC\Language::T('Tags'); ?></a></li>
                        <li><a href="?c=tools&a=all"><?php echo \MVC\Language::T('Tools'); ?></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="dropdown-account" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo \MVC\Language::T('Account'); ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="?c=account&a=help"><?php echo \MVC\Language::T('Help'); ?></a></li>
                                <li><a href="?c=account&a=preferences"><?php echo \MVC\Language::T('Preferences'); ?></a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="?c=users&a=logout"><?php echo \MVC\Language::T('Logout'); ?></a></li> 
                            </ul>
                        </li>

                    </ul>
                </div><!--/.nav-collapse -->
            </div>    

        </div>
        <div class="paging"></div>
        <div id="account">
            <div class="container">
                <div>
                    <h2 class="page-header"><?php echo \MVC\Language::T('Preferences') ?></h2>
                    <form action="?c=account&a=savedPreferences" method="post">
                        <p><?php echo \MVC\Language::T('Change the language'); ?> :
                            <select name="language">
                                <option <?php if($this->language == 'en') echo 'selected' ?> value="en"><?php echo \MVC\Language::T('English'); ?></option>
                                <option <?php if($this->language == 'fr') echo 'selected' ?> value="fr"><?php echo \MVC\Language::T('French'); ?></option>
                            </select>
                        </p><br>
                        <button type="button" class="btn btn-default"><?php echo \MVC\Language::T('Cancel') ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Submit') ?></button>
                    </form>

                </div>
            </div>
        </div>
        <!-- <br> -->
        <div class="paging"></div>
        <div id="footer">
            <?php echo \MVC\Language::T('By') ?> <?php echo \Install\App::COPYRIGHT ?> - <?php echo \Install\App::VERSION ?>
        </div>
        <script src="<?php echo \Install\Path::JS; ?>jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.min.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>keymaster.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>perso.js"></script>
        <script>
            $(document).ready(function() {
                duplicatePaging();
            });
        </script>
    </body>
</html>