<?php if (!defined('IN_FW')) exit('Access Denied');?>
<?php include $this->template("index/header"); ?>
<div class="zw mc new_c">
    <?php $data = Content::parse('action="lists" category_id="'.$category_id.'" num="9" page="'.$page.'"'); if($data) $pages = Content::page('action="lists" category_id="'.$category_id.'" num="9" page="'.$page.'"'); ?> 
    <?php $i = 0;?>
    <?php if(is_array($data)){foreach ((array)$data as $k=>$v) {?>
    <?php $i++;?>
    <div class="nee left">
        <div class="new_l">
            <a href="<?php echo $v[url];?>">
                <div class="new_xh">0<?php echo $i;?></div>
                <div class="new_te"><?php echo @date('Y-m-d',$v[add_time]);?></div>
                <div class="new_bt"><?php echo $v[title];?></div>
                <div class="new_xx"><?php echo @icutstr($v[description],100);?></div>
                <div class="new_tu"><img src="<?php echo @thumb($v[image],275,215);?>"></div>
            </a>
        </div>
    </div>
    <?php }}?>
    <div class="pages"><?php echo $pages;?></div>
    
    <div class="clearit"></div>
</div>
<?php include $this->template("index/footer"); ?>