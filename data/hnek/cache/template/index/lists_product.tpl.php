<?php if (!defined('IN_FW')) exit('Access Denied');?>
<?php include $this->template("index/header"); ?>



<div class="caer_t">

    <ul>

        <li><a href="<?php echo $CATEGORYS[2][url];?>">全部作品</a></li>

        <?php $data = Content::parse('action="category" category_id="2" num="8"'); ?> 

        <?php if(is_array($data)){foreach ((array)$data as $v) {?>

        <li><a href="<?php echo $v[url];?>"><?php echo $v[name];?></a></li>

        <?php }} ?>

        

    </ul>

    <div class="clearit"></div>

</div>

<?php $data = Content::parse('action="lists" category_id="'.$category_id.'" num="20" page="'.$page.'" moreinfo="1"'); if($data) $pages = Content::page('action="lists" category_id="'.$category_id.'" num="20" page="'.$page.'" moreinfo="1"'); ?> 

<div class="caes_c">

    <ul>

        <?php if(is_array($data)){foreach ((array)$data as $k=>$v) {?>

        <li class="view second-effect"><img src="<?php echo @thumb($v[image],628,628);?>">
			<a href="<?php echo $v[url];?>" target="_blank">
        	<div class="mask">
            

							<samp class="info">Image</samp>

                            <div class="w_wz"><?php echo $CATEGORYS[$v[category_id]][name];?></div>

           				 	<p><?php echo $v[title];?></p>

			</div>
            </a>

            <!--<div class="caes_hh ">

                <div class="w_wz"><?php echo $CATEGORYS[$v[category_id]][name];?></div>

                <div class="w_wz1"><?php echo $v[title];?></div>

            </div>-->

        </li>

        <?php }}?>

    </ul>

    <div class="clearit"></div>

</div>

<div class="n_more"><div class="pages"><?php echo $pages;?></div></div>



<?php include $this->template("index/footer"); ?>