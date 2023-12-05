<?php if (!defined('IN_FW')) exit('Access Denied');?>
<?php include $this->template("index/header"); ?>
<div class="fwal_t"> <?php echo $title;?></div>
<div class="ab_n zw mc">
    <?php echo @iStripslashes($content);?>
</div>
<?php include $this->template("index/footer"); ?>