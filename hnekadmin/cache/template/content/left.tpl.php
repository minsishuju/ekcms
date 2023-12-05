<?php if (!defined('IN_FW')) exit('Access Denied');?>
<div class="left">
    <div class="main">
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>栏目管理</span></a>
            </div>
            <ul class="subnav-menu" style="display: block">
                <li>
                    <a href="index.php?c=content&a=category" target="mainFrame">栏目列表</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=tags" target="mainFrame">标签管理</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=posids" target="mainFrame">推荐位管理</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=model" target="mainFrame">模型管理</a>
                </li>
            </ul>
        </div>
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>内容相关</span></a>
            </div>
            <ul class="subnav-menu">
                <li>
                    <a href="index.php?c=collection" target="mainFrame">内容采集</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=images" target="mainFrame">附件管理</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=ad" target="mainFrame">广告管理</a>
                </li>
            </ul>
        </div>
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>推广管理</span></a>
            </div>
            <ul class="subnav-menu">
                <li>
                    <a href="index.php?c=content&a=links" target="mainFrame">友情链接</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=region" target="mainFrame">分站管理</a>
                </li>
                <li>
                    <a href="index.php?c=content&a=seotail" target="mainFrame">SEO长尾词</a>
                </li>
            </ul>
        </div>
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>数据统计</span></a>
            </div>
            <ul class="subnav-menu">
                <li>
                    <a href="index.php?c=content&a=counts" target="mainFrame">数据统计</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>
$('div.subnav > .subnav-title').click(function(){    	
    if($(this).parent().find('ul').is(':hidden')){
        $(this).parent().find('ul').stop().slideDown();
    }else{
        $(this).parent().find('ul').stop().slideUp();
    }
});
</script>