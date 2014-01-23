<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?> - <?php echo \MVC\Language::T('Tags'); ?></title>

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
                            <li><a href="."><?php echo \MVC\Language::T('Home'); ?></a></li>
                            <li class="active"><a href="?c=tags&a=all"><?php echo \MVC\Language::T('Tags'); ?></a></li>
                            <li><a href=""><?php echo \MVC\Language::T('Tools'); ?></a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>    

        </div>
        <div id="tags">
            <?php var_dump($this->tags); ?>
            <?php $tags = $this->tags; ?>
            <?php foreach ($tags as $key => $tag): ?>
            <span><?php echo $key . ' ' . $tag ?></span><br>
            <?php endforeach; ?>
        </div>
        <div id="footer">
            <?php echo \Install\App::COPYRIGHT ?>
        </div>
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.js"></script>
    </body>
</html>

