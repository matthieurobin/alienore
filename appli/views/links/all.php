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
    <link href="<?php echo \Install\Path::CSS; ?>jquery.mCustomScrollbar.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo \Install\Path::IMG; ?>favicon.png" />
</head>
<body ng-app="alienore" ng-controller="mainCtrl">
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
                            <div class="tags-title">
                                <p><?php echo \MVC\Language::T('Tags') ?></p>
                            </div>
                        </div>
                        <div class="row collections-list">
                            <div class="tags-list">
                                <div class="tags-list-content" id="tags-list">
                                    <ul id="tags-list-ul">
                                        <li id="tag-{{ tag.id }}" ng-repeat="tag in tags">
                                            <a ng-click="editTag(tag.id)" data-toggle="modal" data-target="#modal-tag">
                                                <span class="tag-edit">
                                                    <button type="button" class="btn btn-xs btn-primary">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>
                                                </span>
                                            </a>
                                            <a ng-click="selectTag(tag.id)">
                                                <span class="glyphicon glyphicon-tag"></span> <span class="tag-label">{{ tag.label }}</span>
                                                <span class="tag-nb-links pull-right" data-nb-links="{{ tag.count }}">
                                                    {{ tag.count }}
                                                </span>
                                            </a>
                                        </li> 
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="footer">
                                <?php echo \MVC\Language::T('Version') .' '. \Install\App::VERSION ?>
                            </div>
                        </div>
                    </div>
                </aside>
                <div id="links">
                    <div id="modal-helper"></div>
                    <div class="tool-bar">
                        <div id="search-bar">
                            <div id="search-bar-tag">
                                <div style="display:inline-block" ng-repeat="tag in tagsSelected">
                                    <span class="glyphicon glyphicon-tag"></span> {{ tag.label }} 
                                    <a href="#" ng-click="removeSelectedTag(tag.id)"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                                <div style="display:inline-block" ng-if="search">
                                    <span class="glyphicon glyphicon-search"></span> {{ search }} 
                                    <a href="#" ng-click="removeSearch()"><span class="glyphicon glyphicon-remove"></span></a>
                                </div>
                            </div>
                            <div id='search-bar-form'>
                                <form id="form-search" ng-submit="submitSearch()">
                                    <input ng-model="formDataSearch.search" id="input-search" class="search-input" name="search" type="text" placeholder="<?php echo \MVC\Language::T('Search'); ?>">
                                    <input type="submit" style="position: absolute; left: -9999px"/>
                                </form>  
                            </div>
                        </div>
                        <!--<div ng-if="isTagSelection" id="edit-tag" class="pull-left pointer">
                            <span><a data-toggle="modal" data-target="#modal-edit-tag">
                                <?php echo \MVC\Language::T('EditTag') ?> <span class="glyphicon glyphicon-plus"></span>
                            </a></span>
                        </div>-->
                        <div id="addlink">
                            <span><a id="a-new-link" href="" data-toggle="modal" data-target="#modal-link">
                                <?php echo \MVC\Language::T('Addlink') ?> <span class="glyphicon glyphicon-plus"></span>
                            </a></span>
                            <span id="nbLinks"><?php echo \MVC\Language::T('NbLinks') ?> <span id="nbLinks-count">{{ nbLinks }}</span></span>
                        </div>
                    </div>
                    <div class="loading no-display">
                        <img width="64" height="64" src="<?php echo \Install\Path::IMG; ?>loading-bars.svg" alt="Loading icon" />
                    </div>
                    <ul id="list">
                        <li ng-repeat="link in links" id="link-{{ link.link.id }}">
                            <div class="link">
                                <div class="link-tools">
                                    <button type="button" class="btn btn-warning" ng-click="editLink(link.link.id,'<?php echo \MVC\Language::T('EditLink') ?>')">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </button>
                                    <button type="button" class="btn btn-danger" ng-click="deleteLink(link.link.id)">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </div>
                                <h4>
                                    <a class="title-url" href="{{ link.link.url }}" target="_blank">
                                        <img class="title-img" src="http://www.google.com/s2/favicons?domain={{ link.link.url }}" />
                                        <span class="title" ng-bind-html="link.link.title | unsafe"></span>
                                    </a>
                                </h4>
                                <p class="link-description-second">
                                    <small class="link-date">{{ link.link.linkdate }}</small> - 
                                    <a class="link-url" href="{{ link.link.url }}" target="_blank">{{ link.link.url }}</a>
                                </p>
                                <p class="link-description" ng-bind-html="link.link.description | unsafe"></p>
                                <div class="tags">
                                    <div ng-repeat="tag in link.tags" class="tag tag-list link-tag-{{ tag.id }}">
                                        <a class="a-tag pointer" ng-click="selectTag(tag.id)"><span>#</span><span class="tag-label">{{ tag.label }}</span></a>
                                    </div>
                                </div>
                            </div>
                        </li>
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
                                <h4 class="modal-title" id="modal-link-title"><?php echo \MVC\Language::T('Addlink') ?></h4>
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
            <script src="<?php echo \Install\Path::JS; ?>jquery.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>bootstrap.min.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>keymaster.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>tagging.min.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>jquery.mCustomScrollbar.min.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>perso.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>angular.min.js"></script>
            <script src="<?php echo \Install\Path::JS; ?>app.angular.js"></script>
            <script>
                $(document).ready(function() {
                    var tagOptions = {
                        "no-duplicate": true,
                        "no-enter": true,
                        "forbidden-chars": [",", ".", "_", "?", "<", ">", "/", "\"","'"]
                    };
                    $("#tagBox").tagging(tagOptions);
                    //$("#tags-list").mCustomScrollbar();
                    $('#modal-link').on('hidden.bs.modal', function(e) {
                        $('#modal-new-link-title').text('<?php echo \MVC\Language::T('Addlink') ?>');
                        reset();
                        resetTagBox();
                    });
                });
            </script>
        </body>
        </html>