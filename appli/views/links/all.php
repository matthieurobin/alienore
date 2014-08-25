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
<body ng-app="alienore" ng-controller="mainCtrl">
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
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-align-justify"></span></a>
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
                    <p><?php echo \MVC\Language::T('Tags') ?></p>
                </div>
            </div>
            <div class="row collections-list">
                <div class="tags-list">
                    <div class="tags-list-content" id="tags-list">
                        <ul id="tags-list-ul">
                            <ng-include src="'templates/list_tags.html'"></ng-include> 
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="footer">
                    <?php echo \MVC\Language::T('Version') .' '. \Config\App::VERSION ?>
                </div>
            </div>
        </div>
    </aside>
    <div class="wrap" id="links">
        
        <div class="tool-bar">
            <div id="search-bar">
                <ng-include src="'templates/search.html'"></ng-include>
                <div id='search-bar-form'>
                    <form id="form-search" ng-submit="submitSearch()">
                        <input ng-model="formDataSearch.search" id="input-search" class="search-input" name="search" type="text" placeholder="<?php echo \MVC\Language::T('Search'); ?>">
                        <input type="submit" style="position: absolute; left: -9999px"/>
                    </form>  
                </div>
            </div>
            <div id="addlink">
                <span><a id="a-new-link" href="" ng-click="newLink()">
                    <?php echo \MVC\Language::T('Addlink') ?> <span class="glyphicon glyphicon-plus"></span>
                </a></span>
                <span id="nbLinks"><?php echo \MVC\Language::T('NbLinks') ?> <span id="nbLinks-count">{{ nbLinks }}</span></span>
            </div>
        </div>
        <ul id="list">
            <ng-include src="'templates/list_links.html'"></ng-include>
            <div class="empty-result" ng-if="links.length == 0"><?php echo $this->helper ?></div>
        </ul>
        <div ng-if="moreLinks && links.length > 0" class="paging pointer" ng-click="nextPage()">
            <a><?php echo \MVC\Language::T('More') ?></a>
        </div>
        <div ng-if="!moreLinks" class="empty-result">
            <?php echo \MVC\Language::T('No more links') ?>
        </div>
    </div>


    <!-- Modal link -->
    <div class="modal fade" id="modal-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 ng-if="!formDataLink.id" class="modal-title" id="modal-link-title"><?php echo \MVC\Language::T('Addlink') ?></h4>
                    <h4 ng-if="formDataLink.id" class="modal-title" id="modal-link-title"><?php echo \MVC\Language::T('EditLink') ?></h4>
                </div>
                <form method="post" id="form-link" ng-submit="submitLink()">
                    <div class="modal-body">
                        <?php echo \MVC\Language::T('Title') ?>
                        <input id="input-title" class="form-control" type="text" name="title" ng-model="formDataLink.title"><br>
                        <?php echo \MVC\Language::T('Url') ?>
                        <input id="input-url" class="form-control" type="url" name="url" ng-model="formDataLink.url"><br>
                        <?php echo \MVC\Language::T('Description') ?>
                        <textarea id="input-description" type="text" name="description" class="form-control" rows="3" ng-model="formDataLink.description"></textarea><br>
                        <div id="tagsBox">
                            <?php echo \MVC\Language::T('Tags') ?> <br>
                            <span class="legend"><?php echo \MVC\Language::T('Infotags') ?></span>
                            <div data-no-duplicate="true" data-tags-input-name="tag" id="tagBox"></div>
                            <datalist id="datalist-tags"></datalist>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo \MVC\Language::T('Cancel') ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Submit') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal tag -->
    <div class="modal fade" id="modal-tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo \MVC\Language::T('EditTag') ?></h4>
                </div>
                <form ng-submit="submitTag()" method="post" id="form-tag">
                    <div class="modal-body">
                        <?php echo \MVC\Language::T('Title') ?>
                        <input ng-model="formDataTag.label" id="input-tag-title" class="form-control" type="text" name="label" required><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo \MVC\Language::T('Cancel') ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Submit') ?></button>
                    </div>
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
<script>
    $(document).ready(function() {
        var tagOptions = {
            "no-duplicate": true,
            "no-enter": true,
            "forbidden-chars": [",", ".", "_", "?", "<", ">", "/", "\"","'"]
        };
        $("#tagBox").tagging(tagOptions);
        $('#modal-link').on('hidden.bs.modal', function(e) {
            $('#modal-new-link-title').text('<?php echo \MVC\Language::T('Addlink') ?>');
            reset();
            resetTagBox();
        });
    });
</script>
</body>
</html>