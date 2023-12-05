<?php if (!defined('IN_FW')) exit('Access Denied');?>
<?php if ($CATEGORYS[$category_id][child]) { ?>
<?php $cat_id = $category_id?>
<?php } elseif ($CATEGORYS[$CATEGORYS[$category_id][parent_id]][child]) { ?>
<?php $cat_id = $CATEGORYS[$category_id][parent_id]?>
<?php } else { ?>
<?php $cat_id = 0?>
<?php } ?>


<div class="abot_lf">
<div class="aboy_up">
  <h2 class="lm">栏目导航</h2>
  <ul class="listy">
    <?php $data = Content::parse('action="category" category_id="'.$cat_id.'" num="25" order="listorder ASC"'); ?> 
      <?php if(is_array($data)){foreach ((array)$data as $r) {?>
        <li><a href="<?php echo $r[url];?>"><?php echo $r['name'];?></a></li>
      <?php }} ?>
    
  </ul>
</div>
<div class="aboy_bn">
  <h2 class="lmf">推荐产品</h2>
  <?php $data = Content::parse('action="position" posid="1" category_id="2" num="2" order="listorder ASC"'); ?> 
        <?php if(is_array($data)){foreach ((array)$data as $r) {?>
        <div class="imgp">
            <a href="<?php echo $r['url'];?>" title="<?php echo $r['title'];?>"><img src="<?php echo @thumb($r['image'],200,145);?>" alt="<?php echo $r['title'];?>" title="<?php echo $r['title'];?>"></a>
        
            <span><a href="<?php echo $r['url'];?>" title="<?php echo $r['title'];?>"><?php echo $r['title'];?></a></span>
        </div>
        <?php }} ?>
  
</div>
<div class="aboy_bn">
  <h2 class="lmf">联系我们</h2>
  <div class="contact_boxs"><?php echo @config('SITE_INFO.phone');?></div>
  <div class="addy">地址：河南省南阳市淅川县<br />
  电话：<?php echo @config('SITE_INFO.phone');?>（何经理）<br />
  </div>
</div>
</div>
  
 

