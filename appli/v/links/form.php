<form action="?c=links&a=saved&update=1" method="post">
    <?php echo \MVC\Language::T('Title')?>
    <input type="text" name="title" value="<?php echo isset($this->link['title']) ? $this->link['title'] : null; ?>"><br>
    <?php echo \MVC\Language::T('Url')?>
    <input type="text" name="url" value="<?php echo isset($this->link['url']) ? $this->link['url'] : null ?>"><br>
    <?php echo \MVC\Language::T('Description')?>
    <textarea type="text" name="description"><?php echo isset($this->link['description']) ? $this->link['description'] : null  ?></textarea><br>
    <?php echo \MVC\Language::T('Tags')?>
    <input type="text" name="tags" value="<?php echo isset($this->link['tags']) ? $this->link['tags'] : null  ?>"><br>
    <input type="hidden" name="linkdate" value="<?php echo isset($this->link['linkdate']) ? $this->link['linkdate'] : null  ?>">
    <input type="hidden" name="saved" value="<?php echo isset($this->link['saved']) ? $this->link['saved'] : null  ?>">
    <input type="hidden" name="datesaved" value="<?php echo isset($this->link['datesaved']) ? $this->link['datesaved'] : null  ?>">
    <input type="submit" value="<?php echo \MVC\Language::T('Submit')?>">
    <a href="."><?php echo \MVC\Language::T('Cancel')?></a>   
</form>


