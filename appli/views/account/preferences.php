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
    <link href="<?php echo \Config\Path::CSS; ?>main.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo \Config\Path::IMG; ?>favicon.png" />
</head>
<body ng-app="alienore" ng-controller="preferencesCtrl">
<div id="modal-helper"></div>
    <aside class="sidebar">
        <div class="table">
            <div class="row">
                <!-- Menu + logo -->
                <header class="nav">
                    <a href=".">
                        <img id="logo" src="<?php echo \Config\Path::IMG; ?>logo.png"></img>
                    </a>
                    <div class="pull-right" id="nav" id="nav">
                        <ul>
                            <li id="dropdown-account" class="dropdown">
                                <span style="text-decoration:none" class="pointer" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo $_SESSION['login'] ?> <span class="glyphicon glyphicon-chevron-down"></span>
                                </span>
                                <ul class="dropdown-menu">
                                    <li><a href="."><span class="glyphicon glyphicon-home"></span> <?php echo \MVC\Language::T('Home'); ?></a></li>
                                    <li>
                                        <a href="?c=tools&a=all">
                                            <span class="glyphicon glyphicon-wrench"></span> <?php echo \MVC\Language::T('Tools'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?c=account&a=help">
                                            <span class="glyphicon glyphicon-question-sign"></span> <?php echo \MVC\Language::T('Help'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="?c=account&a=preferences">
                                            <span class="glyphicon glyphicon-cog"></span> <?php echo \MVC\Language::T('Preferences'); ?>
                                        </a>
                                    </li>
                                    <?php if($_SESSION['admin']): ?>
                                        <li role="presentation" class="divider"></li>
                                        <li><a href="?c=administration&a=users"><span class="glyphicon glyphicon-user"></span> <?php echo \MVC\Language::T('Users'); ?></a></li>
                                    <?php endif; ?>
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
    <div class="wrap">
        <div>
            <h2><?php echo \MVC\Language::T('Preferences') ?></h2>
            <br>
            <h3><?php echo \MVC\Language::T('Language'); ?></h3>
            <br>
            <form action="?c=account&a=savedLanguagePreference" method="post">
                <div class="form-group">
                    <p><?php echo \MVC\Language::T('Change the language'); ?> :
                        <select name="language">
                            <option <?php if($this->language == 'en') echo 'selected' ?> value="en"><?php echo \MVC\Language::T('English'); ?></option>
                            <option <?php if($this->language == 'fr') echo 'selected' ?> value="fr"><?php echo \MVC\Language::T('French'); ?></option>
                        </select>
                    </p>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Submit') ?></button>
            </form>
            <br>
            <h3><?php echo \MVC\Language::T('Password'); ?></h3>
            <br>
            <form id="formPassword" ng-submit="submitPassword()">
                <div class="form-group col-lg-4">
                    <input ng-model="formDataPassword.oldPassword" type="password" class="form-control" id="oldPassword" placeholder="<?php echo \MVC\Language::T('Old password'); ?>">
                </div>
                <div class="form-group col-lg-4">
                    <input ng-model="formDataPassword.newPassword" type="password" class="form-control" id="newPassword" placeholder="<?php echo \MVC\Language::T('New password'); ?>">
                </div>
                <div class="form-group col-lg-4">
                    <input ng-model="formDataPassword.repeatNewPassword" type="password" class="form-control" id="repeatNewPassword" placeholder="<?php echo \MVC\Language::T('Repeat new password'); ?>">
                </div>
                <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Change password') ?></button>
            </form>

        </div>
    </div>
</div>
<script src="<?php echo \Config\Path::JS; ?>jquery.js"></script>
<script src="<?php echo \Config\Path::JS; ?>bootstrap.min.js"></script>
<script src="<?php echo \Config\Path::JS; ?>tagging.min.js"></script>
<script src="<?php echo \Config\Path::JS; ?>perso.js"></script>
<script src="<?php echo \Config\Path::JS; ?>angular.min.js"></script>
<script src="<?php echo \Config\Path::JS; ?>app.angular.min.js"></script>
</body>
</html>
