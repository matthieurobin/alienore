<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - <?php echo \MVC\Language::T('Tags'); ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.min.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="."><?php echo Install\App::NAME; ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="."><?php echo \MVC\Language::T('Home'); ?></a></li>
                        <li class="active"><a href="?c=tags&a=all"><?php echo \MVC\Language::T('Tags'); ?></a></li>
                        <!--<li><a href=""><?php echo \MVC\Language::T('Tools'); ?></a></li>--> 
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
        <div id="addlink">
            <div id="nbTags">
                <?php echo \MVC\Language::T('NbTags') . ' ' . $this->nbTags ?>
            </div>
        </div>
        <div class="paging"></div>
        <div id="tags" class="container">
            <?php $tags = $this->tags; ?>
            <?php $minSize = 14; $maxSize = 20; ?>
            <?php $max = current($tags); $min = end($tags); ?>
            <?php foreach ($tags as $key => $nbTag): ?>
                <?php $fontSize = intval($minSize + (($nbTag - $min) * (($maxSize - $minSize) / ($max - $min)))); ?>
                <span class="tags">
                    <a href="?c=links&a=all&tag=<?php echo $key; ?>">
                        <b style="font-size: <?php echo $fontSize; ?>px"><span class="nbLinksByTag"><?php echo $nbTag ?></span><?php echo $key; ?></b>
                    </a>
                </span>
            <?php endforeach; ?>
        </div>
        <div class="paging"></div>
        <div id="footer">
            <?php echo \MVC\Language::T('By') ?> <?php echo \Install\App::COPYRIGHT ?> - <?php echo \Install\App::VERSION ?> 
        </div>
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.min.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>keymaster.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>perso.js"></script>
    </body>
</html>

