<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - Tag </title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.css" rel="stylesheet">
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap-responsive.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
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
                        <a class="navbar-brand" href="."><?php echo Install\App::NAME; ?></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="."><?php echo \MVC\Language::T('Home'); ?></a></li>
                            <li><a href="?c=tags&a=all"><?php echo \MVC\Language::T('Tags'); ?></a></li>
                            <li><a href=""><?php echo \MVC\Language::T('Tools'); ?></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>    

        </div>
        <div id="links">
            <div id="addlink">
                <div>
                    <span><a href="?c=tags&a=form&tag=<?php echo $this->tag ?>"><?php echo \MVC\Language::T('EditLink') ?> : <?php echo $this->tag ?></a></span>
                    <span id="nbLinks"><?php echo \MVC\Language::T('NbLinks') . ' ' . $this->nbLinks ?></span>
                </div>
            </div>
            <div class="paging">
                <span class="glyphicon glyphicon-arrow-left"></span>
                <a href=""><?php echo \MVC\Language::T('PreviousPage') ?></a>
                <a href=""><?php echo \MVC\Language::T('NextPage') ?></a>
                <span class="glyphicon glyphicon-arrow-right"></span>
            </div>
            <?php //var_dump($this->links); ?>
            <ul>
                <?php foreach ($this->links as $link): ?>
                    <li>
                        <div class="link">
                            <h3>
                                <?php if ($link['saved']): ?>
                                    <a href=""><span class="glyphicon glyphicon-new-window"></span></a>
                                <?php endif; ?>
                                <a href="<?php echo $link['url'] ?>"><?php echo $link['title'] ?></a>
                            </h3>
                            <p class="link-description-second">
                                <small><?php echo $link['linkdate'] ?></small> - 
                                <a href="<?php echo $link['saved'] ?>"><?php echo $link['url'] ?></a>
                            </p>
                            <p class="link-description"><?php echo $link['description'] ?></p>
                            <div class="tags">
                                <?php $tags = \MVC\Tags::displayTags($link['tags']); ?>
                                <?php if (!is_string($tags)): ?>
                                    <?php for ($i = 0; $i < sizeof($tags); ++$i): ?>
                                        <span class="glyphicon glyphicon-tag"></span>
                                        <a href="?c=tags&a=linksByTag&tag=<?php echo $tags[$i]; ?>"><?php echo $tags[$i]; ?></a></span>
                                    <?php endfor; ?>
                                <?php elseif (strlen($tags) > 0): ?>
                                    <span class="glyphicon glyphicon-tag"></span>
                                    <a href="?c=tags&a=linksByTag&tag=<?php echo $tags; ?>"><?php echo $tags; ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="link-tools">
                                <span class="label label-warning">
                                    <a href="?c=links&a=form&id=<?php echo $link['linkdate'] ?>"><?php echo \MVC\Language::T('Edit') ?></a>
                                </span>
                                <span class="label label-danger">

                                    <a href="?c=links&a=delete&id=<?php echo $link['linkdate'] ?>&filename=<?php echo $link['title'] ?>"><?php echo \MVC\Language::T('Delete') ?></a>
                                </span>
                                <span class="label label-success">
                                    <?php if ($link['saved']): ?>
                                        <?php
                                        echo \MVC\A::link('links', 'savedLink', \MVC\Language::T('Unsaved'), array(
                                            'id' => $link['linkdate'],
                                            'saved' => $link['saved'],
                                            'filename' => $link['title'],
                                            'url' => $link['url']
                                        ))
                                        ?>
                                    <?php else: ?>
                                        <?php
                                        echo \MVC\A::link('links', 'savedLink', \MVC\Language::T('Save'), array(
                                            'id' => $link['linkdate'],
                                            'saved' => $link['saved'],
                                            'filename' => $link['title'],
                                            'url' => $link['url']
                                        ))
                                        ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="footer">
            <?php echo \Install\App::COPYRIGHT ?>
        </div>
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.js"></script>
    </body>
</html>