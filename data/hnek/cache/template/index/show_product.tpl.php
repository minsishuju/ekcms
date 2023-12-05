<?php if (!defined('IN_FW')) exit('Access Denied');?>
<?php include $this->template("index/header"); ?>

<div class="n_cer_t zw mc">客户：<?php echo $kehu;?></div>
<div class="n_cer_b zw mc">
    <div class="n_cer_b_l left"><?php echo $title;?></div>
    <div class="n_cer_b_r right">1580次点赞</div>
    <div class="clearit"></div>
</div>

<div class="zw mc">
    <div class="xm_xn left">
        <div class="xw_tt">项目概述</div>
        <div class="xm_cc"><?php echo @iStripslashes($content);?></div>
    </div>
    <div class="xm_ms right">
        <div class="xw_tt">项目服务</div>
        <div class="xw_ff">
            <span><samp>时间：</samp><?php echo $shijian;?></span>
            <span><samp>行业：</samp><?php echo $hangye;?></span>
            <span><samp>服务：</samp><?php echo $fuwu;?></span>
        </div>
    </div>
    <div class="clearit"></div>

</div>

<div class="zw mc">
    <?php if ($eone != '') { ?>
    <div class="xm_yw"><?php echo $eone;?></div>
    <?php } ?>
    <?php if ($one != '') { ?>
    <div class="xm_bt"><?php echo $one;?></div>
    <?php } ?>
    <?php if ($miaosuone != '') { ?>
    <div class="xm_xx">
        <?php echo $miaosuone;?>
    </div>
    <?php } ?>

    <?php if ($etwo != '') { ?>
    <div class="xm_yw"><?php echo $etwo;?></div>
    <?php } ?>
    <?php if ($two != '') { ?>
    <div class="xm_bt"><?php echo $two;?></div>
    <?php } ?>
    <?php if ($miaosutwo != '') { ?>
    <div class="xm_xx">
        <?php echo $miaosutwo;?>
    </div>
    <?php } ?>

    <?php if ($ethree != '') { ?>
    <div class="xm_yw"><?php echo $ethree;?></div>
    <?php } ?>
    <?php if ($three != '') { ?>
    <div class="xm_bt"><?php echo $three;?></div>
    <?php } ?>
    <?php if ($miaosuthree != '') { ?>
    <div class="xm_xx">
        <?php echo $miaosuthree;?>
    </div>
    <?php } ?>

</div>

<div class="fx mc"><img src="<?php echo __PUBLIC__;?>images/anli_14.jpg"></div>

<div class="zw mc">
    <div class="fy">
        <div class="fy_l left"><a href="<?php echo $previous_page['url'];?>"><?php echo $previous_page['title'];?></a></div>
        <div class="fy_c left"><a href="<?php echo $CATEGORYS[$category_id][url];?>"></a></div>
        <div class="fy_r right"><a href="<?php echo $next_page['url'];?>"><?php echo $next_page['title'];?></a></div>
        <div class="clearit"></div>
    </div>

</div>
<?php include $this->template("index/footer"); ?>