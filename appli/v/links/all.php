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
                        <li class="active"><a href="."><?php echo \MVC\Language::T('Home'); ?></a></li>
                        <li><a href="?c=tags&a=all"><?php echo \MVC\Language::T('Tags'); ?></a></li>
                        <li><a href="?c=tools&a=all"><?php echo \MVC\Language::T('Tools'); ?></a></li>
                        <form action="?c=links&a=all" method="post" class="navbar-form navbar-right" role="form">
                            <div class="form-group">
                                <input name="search" type="text" class="form-control" placeholder="<?php echo \MVC\Language::T('Search'); ?>">
                            </div>
                            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span> <?php echo \MVC\Language::T('Search'); ?></button>
                        </form>  
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="dropdown-account" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo \MVC\Language::T('Account'); ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="?c=account&a=help"><?php echo \MVC\Language::T('Help'); ?></a></li>
                                <li role="presentation" class="divider"></li>
                                <li><a href="?c=users&a=logout"><?php echo \MVC\Language::T('Logout'); ?></a></li>  
                            </ul>
                        </li>

                    </ul>
                </div><!--/.nav-collapse -->
            </div>    

        </div>
        <div id="links">
            <div id="addlink">
                <?php if ($this->search): ?> 
                    <span>
                        <a id="a-goback" href="."><?php echo \MVC\Language::T('Go back') ?> <span class="glyphicon glyphicon-remove"></span></a>
                    </span>
                <?php elseif ($this->tag): ?>
                    <span>
                        <a id="a-goback" href="."><?php echo \MVC\Language::T('Go back') ?> <span class="glyphicon glyphicon-remove"></span></a>
                        <a id="a-edit-tag" href="" data-toggle="modal" data-target="#modal-edit-tag">
                            <?php echo \MVC\Language::T('EditLink') ?> : <?php echo $this->tag->label ?>
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </span>
                <?php else: ?>
                    <span><a id="a-new-link" href="" data-toggle="modal" data-target="#modal-new-link">
                            <?php echo \MVC\Language::T('Addlink') ?> <span class="glyphicon glyphicon-plus"></span>
                        </a></span>
                <?php endif; ?>
                <span id="nbLinks"><?php echo \MVC\Language::T('NbLinks') . ' ' . $this->nbLinks ?></span>
            </div>
            <div class="paging">
                <?php if ($this->pagination['links']): ?>
                    <?php if ($this->pagination['page'] != 1): ?>
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        <a href="?c=links&a=all&page=<?php echo $this->pagination['page'] - 1 ?>"><?php echo \MVC\Language::T('PreviousPage') ?></a>
                    <?php endif; ?>
                    <span><?php echo $this->pagination['page'] ?>/<?php echo $this->pagination['nbPages'] ?></span>
                    <?php if ($this->pagination['page'] != $this->pagination['nbPages']): ?>
                        <a href="?c=links&a=all&page=<?php echo $this->pagination['page'] + 1 ?>"><?php echo \MVC\Language::T('NextPage') ?></a> 
                        <span class="glyphicon glyphicon-arrow-right"></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <ul id="list">
                <?php if (sizeof($this->pagination['links']) > 0): ?>
                    <?php foreach ($this->pagination['links'] as $link): ?>
                        <li id="link-<?php echo $link['link']->id ?>">
                            <div class="link">
                                <h3 id="title-<?php echo $link['link']->id ?>">
                                    <a href="<?php echo $link['link']->url ?>"><?php echo $link['link']->title ?></a>
                                </h3>
                                <p class="link-description-second">
                                    <small><?php echo \MVC\Date::displayDate($link['link']->linkdate) ?></small> - 
                                    <a href="<?php echo $link['link']->url ?>"><?php echo $link['link']->url ?></a>
                                </p>
                                <p class="link-description"><?php echo $link['link']->description ?></p>
                                <div class="tags">
                                    <?php $tags = $link['tags'] ?>
                                    <?php if (sizeof($tags) > 0): ?>
                                        <?php for ($i = 0; $i < sizeof($tags); ++$i): ?>
                                            <span class="glyphicon glyphicon-tag"></span>
                                            <a href="?c=links&a=all&tagId=<?php echo $tags[$i]->id; ?>"><?php echo $tags[$i]->label; ?></a></span>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="link-tools">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-warning" onclick="editLink(<?php echo strval($link['link']->id) ?>, '<?php echo \MVC\Language::T('EditLink') ?>')">
                                            <?php echo \MVC\Language::T('Edit') ?> <span class="glyphicon glyphicon-pencil"></span>
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="location.href = '?c=links&a=delete&id=<?php echo $link['link']->id ?>&filename=<?php echo $link['link']->title ?>'">
                                            <?php echo \MVC\Language::T('Delete') ?> <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="nolinks"><?php echo $this->helper ?></div>
                <?php endif; ?>
            </ul>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="modal-new-link" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="modal-new-link-title"><?php echo \MVC\Language::T('Addlink') ?></h4>
                    </div>
                    <form action="?c=links&a=saved" method="post" id="form-new-link">
                        <div class="modal-body">
                            <?php echo \MVC\Language::T('Title') ?>
                            <input id="input-title" class="form-control" type="text" name="title"><br>
                            <?php echo \MVC\Language::T('Url') ?>
                            <input id="input-url" class="form-control" type="text" name="url"><br>
                            <?php echo \MVC\Language::T('Description') ?>
                            <textarea id="input-description" type="text" name="description" class="form-control" rows="3"></textarea><br>
                            <?php echo \MVC\Language::T('Tags') ?>
                            <input list="datalist-tags" id="input-tags" class="form-control" type="text" name="tags" placeholder="<?php echo \MVC\Language::T('Infotags') ?>"><br>
                            <!--<datalist id="datalist-tags"></datalist>-->
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

        <?php if ($this->tag): ?> 
            <!-- Modal tag -->
            <div class="modal fade" id="modal-edit-tag" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"><?php echo \MVC\Language::T('EditTag') ?></h4>
                        </div>
                        <form action="?c=tags&a=saved" method="post" id="form-edit-tag">
                            <div class="modal-body">
                                <?php echo \MVC\Language::T('Title') ?>
                                <input id="input-tag-title" class="form-control" type="text" name="tagName" value="<?php echo $this->tag->label ?>" required><br>
                                <input id="input-tag-id" type="hidden" name="tagId" value="<?php echo $this->tag->id ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo \MVC\Language::T('Cancel') ?></button>
                                <button type="submit" class="btn btn-primary"><?php echo \MVC\Language::T('Submit') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="paging">

        </div>
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
                                        $('#modal-new-link').on('hidden.bs.modal', function(e) {
                                            $('#modal-new-link-title').text('<?php echo \MVC\Language::T('Addlink') ?>');
                                            reset($('#form-new-link'));
                                        });
                                        $('#modal-edit-tag').on('hidden.bs.modal', function(e) {
                                            reset($('#form-edit-tag'));
                                        });
                                    });
        </script>
    </body>
</html>