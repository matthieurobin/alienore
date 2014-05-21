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
                        <div class="tags-title">
                            <p><?php echo \MVC\Language::T('Tags') ?></p>
                        </div>
                    </div>
                    <div class="row collections-list">
                        <div class="tags-list">
                            <div class="tags-list-content" id="tags-list">
                                <ul id="tags-list-ul">
                                    <?php for ($i = 0; $i < sizeof($this->tags); ++$i): ?>
                                        <a onclick="getLinksByTag(<?php echo $this->tags[$i]->id ?>)">
                                            <li id="tag-<?php echo $this->tags[$i]->id ?>">
                                                <span class="tag-label"><span class="glyphicon glyphicon-tag"></span> <?php echo $this->tags[$i]->label ?></span>
                                                <span class="tag-nb-links" data-nb-links="<?php echo $this->tags[$i]->count ?>">
                                                    <?php echo $this->tags[$i]->count ?>
                                                </span>
                                            </li>
                                        </a>
                                    <?php endfor; ?>
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
                        <div id="search-bar-tag"></div>
                        <div id='search-bar-form'>
                            <form id="form-search" action="?c=links&a=data_search" method="post">
                                <input id="input-search" class="search-input" name="search" type="text" placeholder="<?php echo \MVC\Language::T('Search'); ?>">
                                <input type="submit" style="position: absolute; left: -9999px"/>
                            </form>  
                        </div>
                    </div>
                    <div id="edit-tag" class="no-display pull-left">
                            <span><a href="" data-toggle="modal" data-target="#modal-edit-tag">
                                <?php echo \MVC\Language::T('EditTag') ?> <span class="glyphicon glyphicon-plus"></span>
                            </a></span>
                        </div>
                        <div id="addlink">
                            <span><a id="a-new-link" href="" data-toggle="modal" data-target="#modal-new-link">
                                <?php echo \MVC\Language::T('Addlink') ?> <span class="glyphicon glyphicon-plus"></span>
                            </a></span>
                        <span id="nbLinks"><?php echo \MVC\Language::T('NbLinks') ?> <span id="nbLinks-count"><?php echo $this->nbLinks ?></span></span>
                        </div>
                </div>
                <div class="loading no-display">
                    <img width="64" height="64" src="<?php echo \Install\Path::IMG; ?>loading-bars.svg" alt="Loading icon" />
                </div>
                <ul id="list">
                    <?php if (sizeof($this->pagination['links']) > 0): ?>
                        <?php foreach ($this->pagination['links'] as $link): ?>
                            <li id="link-<?php echo $link['link']->id ?>">
                                <div class="link">
                                    <div class="link-tools">
                                        <button type="button" class="btn btn-warning" onclick="editLink(<?php echo strval($link['link']->id) ?>, '<?php echo \MVC\Language::T('EditLink') ?>')">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="deleteLink(<?php echo $link['link']->id ?>,'<?php echo $_SESSION['token'] ?>')">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </div>
                                    <h4 id="title-<?php echo $link['link']->id ?>">
                                        <a href="<?php echo $link['link']->url ?>" target="_blank">
                                            <img src="http://www.google.com/s2/favicons?domain=<?php echo $link['link']->url ?>" />
                                            <?php echo $link['link']->title ?>
                                        </a>
                                    </h4>
                                    <p class="link-description-second">
                                        <small><?php echo \MVC\Date::displayDate($link['link']->linkdate) ?></small> - 
                                        <a href="<?php echo $link['link']->url ?>" target="_blank"><?php echo $link['link']->url ?></a>
                                    </p>
                                    <p class="link-description"><?php echo $link['link']->description ?></p>
                                    <div class="tags">
                                        <?php $tags = $link['tags'] ?>
                                        <?php if (sizeof($tags) > 0): ?>
                                            <?php for ($i = 0; $i < sizeof($tags); ++$i): ?>
                                                <div class="tag tag-list">
                                                    <a class="a-tag pointer" onclick="getLinksByTag(<?php echo $tags[$i]->id; ?>)"><span>#</span><?php echo $tags[$i]->label; ?></a></span>
                                                </div>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div id="empty-result"><?php echo $this->helper ?></div>
                    <?php endif; ?>
                </ul>
                <div class="paging pointer" onclick="nextPage()">
                    <a data-pagination="default"><?php echo \MVC\Language::T('More') ?></a>
                </div>
            </div>


            <!-- Modal link -->
            <div class="modal fade" id="modal-new-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modal-new-link-title"><?php echo \MVC\Language::T('Addlink') ?></h4>
                        </div>
                        <form action="?c=links&a=data_saved" method="post" id="form-link">
                            <div class="modal-body">
                                <?php echo \MVC\Language::T('Title') ?>
                                <input id="input-title" class="form-control" type="text" name="title"><br>
                                <?php echo \MVC\Language::T('Url') ?>
                                <input id="input-url" class="form-control" type="url" name="url"><br>
                                <?php echo \MVC\Language::T('Description') ?>
                                <textarea id="input-description" type="text" name="description" class="form-control" rows="3"></textarea><br>
                                <div id="tagsBox">
                                    <?php echo \MVC\Language::T('Tags') ?> <br>
                                    <span class="legend"><?php echo \MVC\Language::T('Infotags') ?></span>
                                    <div data-no-duplicate="true" data-tags-input-name="tag" id="tagBox"></div>
                                    <!--<input list="datalist-tags" id="input-tags" class="form-control" type="text" name="tags" placeholder="<?php echo \MVC\Language::T('Infotags') ?>"><br>-->
                                    <datalist id="datalist-tags"></datalist>
                                </div>
                                <input id="input-linkid" type="hidden" name="linkId">
                                <input id="input-saved" type="hidden" name="saved">
                                <input id="input-datesaved" type="hidden" name="datesaved">
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
            <div class="modal fade" id="modal-edit-tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo \MVC\Language::T('EditTag') ?></h4>
                        </div>
                        <form action="?c=tags&a=saved" method="post" id="form-tag">
                            <div class="modal-body">
                                <?php echo \MVC\Language::T('Title') ?>
                                <input id="input-tag-title" class="form-control" type="text" name="tagName" value="" required><br>
                                <input id="input-tag-id" type="hidden" name="tagId" value="">
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
        <script>
                                    $(document).ready(function() {
                                        $("#tags-list").mCustomScrollbar();
                                        $('#modal-new-link').on('hidden.bs.modal', function(e) {
                                            $('#modal-new-link-title').text('<?php echo \MVC\Language::T('Addlink') ?>');
                                            reset();
                                            resetTagBox();
                                        });
                                        _lastLimit = <?php echo $this->pagination['nbPages'] ?>;
                                    });
        </script>
    </body>
</html>