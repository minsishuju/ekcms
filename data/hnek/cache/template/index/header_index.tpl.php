<?php if (!defined('IN_FW')) exit('Access Denied');?>
<!doctype html>

<html>

<head>

    <meta charset="utf-8">

	<meta name="viewport" content="width=1200">

    <meta name="format-detection" content="telephone=no">

    <title><?php if (isset($SEO['title']) && !empty($SEO['title'])) { ?><?php echo $SEO['title'];?><?php echo $SEO['name'];?><?php if ($city != '') { ?>-<?php echo $city;?>站<?php } ?><?php } else { ?><?php echo $SEO['site_title'];?><?php } ?></title>

    <meta name="keywords" content="<?php echo $SEO['keyword'];?>">

    <meta name="description" content="<?php echo $SEO['description'];?>">

    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>css/style.css">

    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>css/lrtk.css" media="all">

	<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>css/yx_style.css" media="all">

    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery-1.12.4.min.js"></script>

    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/i_ban.js"></script>
	
	<link rel='shortcut icon' href='<?php echo __PUBLIC__;?>images/favicon.ico' type='image/x-icon'/>
</head>

<body>

<div class="<?php if ($category_id > 0) { ?>n_top<?php } else { ?>i_top<?php } ?>">

	<div class="top_n" id="wrap">

        <div class="zw_logo left"><!--<div class="tel"><?php echo @config('SITE_INFO.phone');?></div>--><a href="<?php echo @config('SITE_INFO.siteurl');?>"><img src="<?php echo __PUBLIC__;?>images/logo.png"></a></div>

        <div class="nav right"  id="main_nav">

            <ul>

                <li><a href="<?php echo @config('SITE_INFO.siteurl');?>">首 页</a></li>

                <?php $data = Content::parse('action="category" category_id="0" num="4"'); ?> 

                <?php if(is_array($data)){foreach ((array)$data as $v) {?>

                <li><a href="<?php echo $v[url];?>"><?php echo $v[name];?></a>
                
                	<?php $data1 = Content::parse('action="category" category_id="'.$v['category_id'].'" num="8"'); ?> 
		  <?php if ($data1 != "") { ?>
			<ul>
			<?php if(is_array($data1)){foreach ((array)$data1 as $s) {?>
			  <li><a href="<?php echo $s['url'];?>"><?php echo $s['name'];?></a></li>
			<?php }} ?>
			</ul>
			<?php } ?>
		
                </li>

                <?php }} ?>

                

            </ul>

            <div class="clearit"></div>

        </div>

    </div>

   <div class="iBan">

    <div class="iBanScreen">

        <ul class="ibanImg">

            <?php $data1 = Content::parse('action="ad" space_id="1" num="3" order="listorder ASC"'); ?> 

            <?php if(is_array($data1)){foreach ((array)$data1 as $k=>$v) {?>

            <li style="background-image:url(<?php echo $v[image];?>)"><a href="<?php echo $v['link_url'];?>" title="<?php echo $v[alt];?>"><img src="<?php echo $v[image];?>" alt="<?php echo $v[alt];?>" border="0" align="left"></a></li>

            <?php }}?>

            

        </ul>

    </div>

    <div class="banFn"></div>

</div>

    <!--<?php if ($category_id == 0) { ?><div class="shin"><img src="<?php echo __PUBLIC__;?>images/shin.png"></div><?php } ?>-->

</div>