<?php if (!defined('IN_FW')) exit('Access Denied');?>
<div class="left">
    <div class="main">
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>快捷操作</span></a>
            </div>
            <ul class="subnav-menu" style="display: block">
                <li>
                    <a href="index.php?c=index&a=info" target="mainFrame">个人信息</a>
                </li>
                <li>
                    <a href="index.php?c=index&a=resetpd" target="mainFrame">修改密码</a>
                </li>
                <li>
                    <a href="index.php?c=index&a=site" target="mainFrame">站点管理</a>
                </li>
                <li>
                    <a href="index.php?c=index&a=keywords" target="mainFrame">关键词设置</a>
                </li>
                <li>
                    <a href="index.php?c=index&a=bdsort" target="mainFrame">排名查询</a>
                </li>
            </ul>
        </div>
        <?php if ($_SESSION['is_master'] == 1) { ?>
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>账号管理</span></a>
            </div>
            <ul class="subnav-menu" style="display: block">
                <li>
                    <a href="index.php?c=index&a=admin" target="mainFrame">账号管理</a>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div>
</div>
<script>
$('div.subnav > .subnav-title').click(function(){    	
    if($(this).parent().find('ul').is(':hidden')){
        $('div.subnav').find('ul').slideUp();
        $(this).parent().find('ul').stop().slideDown();
    }else{
        $('div.subnav').find('ul').slideUp();
    }
});
</script>