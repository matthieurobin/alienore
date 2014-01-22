<?php var_dump($this->tag);?>
<form action="?c=tags&a=saved" method="post">
    <?php echo \MVC\Language::T('Title')?>
    <input type="text" name="tagName" value="<?php echo $this->tag ?>"><br>
    <input type="hidden" name="tag" value="<?php echo $this->tag ?>">
    <input type="submit" value="<?php echo \MVC\Language::T('Submit')?>">
    <a href="."><?php echo \MVC\Language::T('Cancel')?></a>   
</form>


