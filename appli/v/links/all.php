<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo Install\App::NAME; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap.css" rel="stylesheet">
        <link href="<?php echo \Install\Path::CSS; ?>bootstrap-responsive.css" rel="stylesheet">
        <!-- Application CSS -->
        <link href="<?php echo \Install\Path::CSS; ?>perso.css" rel="stylesheet">
    </head>
    <body>
         <?php var_dump($this->links); ?>
        <a href="?c=links&a=form"><?php echo \MVC\Language::T('Addlink') ?></a>

        <?php foreach ($this->links as $link): ?>
        <h3><a href="<?php echo $link['url'] ?>"><?php echo $link['title'] ?></a></h3>
            <p><?php echo $link['description'] ?></p>
            <div>
                <?php $tags = \MVC\Tags::displayTags($link['tags']); ?>
                <?php if (!is_string($tags)): ?>
                    <?php for ($i = 0; $i < sizeof($tags); ++$i): ?>
                        <span><a href="?c=tags&a=linksByTag&tag=<?php echo $tags[$i]; ?>"><?php echo $tags[$i]; ?></a></span>
                    <?php endfor; ?>
                <?php else: ?>
                    <span><a href="?c=tags&a=linksByTag&tag=<?php echo $tags; ?>"><?php echo $tags; ?></a></span>
                <?php endif; ?>
            </div>
            <a href="?c=links&a=form&id=<?php echo $link['linkdate'] ?>"><?php echo \MVC\Language::T('Edit') ?></a>
            <a href="?c=links&a=delete&id=<?php echo $link['linkdate'] ?>&filename=<?php echo $link['title'] ?>"><?php echo \MVC\Language::T('Delete') ?></a>
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
        <?php endforeach; ?>

        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="<?php echo \Install\Path::JS; ?>bootstrap.js"></script>
    </body>
</html>