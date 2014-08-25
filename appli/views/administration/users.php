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
<body ng-app="alienore" ng-controller="usersCtrl">
    <div id="modal-helper"></div>
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
                                <span style="text-decoration:none" class="pointer" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo $_SESSION['user'] ?> <span class="glyphicon glyphicon-chevron-down"></span>
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
                <div class="tags-title">
                    <!--<p><?php echo \MVC\Language::T('Groups') ?></p>-->
                </div>
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
        <form class="form-inline" ng-submit="submitUser()">
            <div class="form-group">
                <input type="text" ng-model="formDataUser.username" class="form-control" placeholder="<?php echo \MVC\Language::T('Username') ?>" />
            </div>
            <div class="form-group">
                <input type="email" ng-model="formDataUser.email" class="form-control" placeholder="<?php echo \MVC\Language::T('Email Address') ?>" />
            </div>
            <div class="form-group">
                <input type="password" ng-model="formDataUser.password" class="form-control" placeholder="<?php echo \MVC\Language::T('Password') ?>" />
            </div> 
            <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Create') ?></button>
        </form>
        <div class="search-users">
            <input type="text" ng-model="search.$" class="form-control" placeholder="<?php echo \MVC\Language::T('Search in users') ?>" />
        </div>
        <div class="users table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><b><?php echo \MVC\Language::T('Username') ?></b></td>
                        <td><b><?php echo \MVC\Language::T('Email Address') ?></b></td>
                        <td><b><?php echo \MVC\Language::T('Password') ?></b></td>
                        <!--<td><?php echo \MVC\Language::T('Delete the user') ?></td>-->
                    </tr>  
                </thead>  
                <tbody>
                    <tr ng-repeat="user in users | filter: search" id="user-{{ user.id }}">
                        <td>{{ user.username }}</td>
                        <td>{{ user.email }}</td>
                        <td> ●●●●●●● </td>
                        <!--<td>
                            <button class="btn btn-danger"><?php echo \MVC\Language::T('Delete') ?></button>
                        </td>-->
                    </tr>
                </tbody>
            </table>
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