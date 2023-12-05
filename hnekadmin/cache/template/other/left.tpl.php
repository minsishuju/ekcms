<?php if (!defined('IN_FW')) exit('Access Denied');?>
<div class="left">
    <div class="main">
        <div class="subnav">
            <div class="subnav-title">
                <a href="javascript:void(0);" target="_self" class='toggle-subnav'><span>模块管理</span></a>
            </div>
            <ul class="subnav-menu" style="display: block">
                <li>
                    <a href="index.php?c=other&a=guestbook" target="mainFrame">留言管理</a>
                </li>
				<li>
                    <a href="index.php?c=other&a=bbs" target="mainFrame">论坛管理</a>
                </li>
                <li>
                    <a href="index.php?c=other&a=talent" target="mainFrame">招聘管理</a>
                </li>
            </ul>
        </div>
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