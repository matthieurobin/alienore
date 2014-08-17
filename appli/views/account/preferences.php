<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo Config\App::NAME; ?> - <?php echo \MVC\Language::T('Home'); ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo \Config\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
    <!-- Application CSS -->
    <link href="<?php echo \Config\Path::CSS; ?>main.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo \Config\Path::IMG; ?>favicon.png" />
</head>
<body ng-app="alienore">
    <aside class="sidebar">
        <div class="table">
            <div class="row">
                <!-- Menu + logo -->
                <header class="nav">
                    <a href=".">
                        <img id="logo" src="<?php echo \Config\Path::IMG; ?>logo.png"></img>
                    </a>
                    <div class="pull-right">
                        <ul>
                            <li id="dropdown-account" class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-align-justify"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="."><span class="glyphicon glyphicon-home"></span> <?php echo \MVC\Language::T('Home'); ?></a></li>
                                    <li><a href="?c=tools&a=all">
                                        <span class="glyphicon glyphicon-wrench"></span> <?php echo \MVC\Language::T('Tools'); ?></a></li>
                                        <li><a href="?c=account&a=help">
                                            <span class="glyphicon glyphicon-question-sign"></span> <?php echo \MVC\Language::T('Help'); ?></a></li>
                                            <li><a href="?c=account&a=preferences">
                                                <span class="glyphicon glyphicon-cog"></span> <?php echo \MVC\Language::T('Preferences'); ?></a></li>
                                                <li role="presentation" class="divider"></li>
                                                <li><a href="?c=users&a=logout"><?php echo \MVC\Language::T('Logout'); ?></a></li>  
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </header>
                        </div>
                        <div class="row collections-list">
                        </div>
                        <div class="row">
                            <div class="footer">
                                <?php echo \MVC\Language::T('Version') .' '. \Config\App::VERSION ?>
                            </div>
                        </div>
                    </div>
                </aside>
                <div id="links">
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
                                <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Submit') ?></button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <script src="<?php echo \Config\Path::JS; ?>jquery.js"></script>
            <script src="<?php echo \Config\Path::JS; ?>bootstrap.min.js"></script>
            <script src="<?php echo \Config\Path::JS; ?>tagging.min.js"></script>
            <script src="<?php echo \Config\Path::JS; ?>perso.js"></script>
            <script src="<?php echo \Config\Path::JS; ?>angular.min.js"></script>
            <script src="<?php echo \Config\Path::JS; ?>app.angular.js"></script>
        </body>
        </html>
