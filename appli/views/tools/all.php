<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - <?php echo \MVC\Language::T('Tools'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
        <link href="<?php echo \Install\Path::CSS; ?>jquery.mCustomScrollbar.css" rel="stylesheet">
        <link rel="icon" type="image/png" href="<?php echo \Install\Path::IMG; ?>favicon.png" />
    </head>
    <body>
            <aside class="sidebar">
                <div class="table">
                    <div class="row">
                        <!-- Menu + logo -->
                        <header class="nav">
                            <a href=".">
                                <img id="logo" src="<?php echo \Install\Path::IMG; ?>logo.png"></img>
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
                    <div class="row">
                        <div class="footer">
                            <?php echo \MVC\Language::T('Version') .' '. \Install\App::VERSION ?>
                        </div>
                    </div>
                </div>
            </aside>
            <div id="links">
                <div id="tools">
                    <div class="helper">
                        <?php \APPLI\Views\Helper::display(); ?>
                    </div>
                    <div class="container">
                        <h4><?php echo \MVC\Language::T('Export') ?> :</h4>
                        <div class="tool-body">
                            <button class="btn btn-default" onclick="location.href = '?c=tools&a=exportHtml'">
                                <?php echo \MVC\Language::T('Export to html format') ?>
                            </button>
                        </div>
                        <h4><?php echo \MVC\Language::T('Import') ?> :</h4>
                        <div class="tool-body">
                            <form id="form-import" action="?c=tools&a=import" method="post" enctype="multipart/form-data">
                                <input type="file" name="filePath">                        
                                <input type="hidden" name="MAX_FILE_SIZE" value="100000"><br>
                                <button type="submit" class="btn btn-primary">
                                    <?php echo \MVC\Language::T('Submit'); ?>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo \Install\Path::JS; ?>jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.min.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>keymaster.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>tagging.min.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>jquery.mCustomScrollbar.min.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>perso.js"></script>
    </body>
</html>