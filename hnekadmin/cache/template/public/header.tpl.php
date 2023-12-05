<?php if (!defined('IN_FW')) exit('Access Denied');?>
    <div class="navbar navbar-inverse navbar-fixed-top equinav">
        <div class="navbar-inner">
            <div class="container-fluid">
                <div class="brand navbar-header">
                    <a href="javascript:;" target="_self" ><img src="<?php echo __PUBLIC__;?>images/logo.png" /></a>
                    <a href="javascript:;" target="_self" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-align-justify icon-white"></i></a>
                </div>
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="nav-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li <?php if (strtolower(CONTROLLER_NAME)== 'index') { ?>class="active"<?php } ?>><a href="index.php?c=index">系统首页</a></li>
                        <li <?php if (strtolower(CONTROLLER_NAME)== 'content') { ?>class="active"<?php } ?>><a href="index.php?c=content">内容管理</a></li>
                        <li <?php if (strtolower(CONTROLLER_NAME)== 'other') { ?>class="active"<?php } ?>><a href="index.php?c=other">模块管理</a></li>
                        <li <?php if (strtolower(CONTROLLER_NAME)== 'member') { ?>class="active"<?php } ?>><a href="index.php?c=member">会员管理</a></li>
                        <li <?php if (strtolower(CONTROLLER_NAME)== 'shop') { ?>class="active"<?php } ?>><a href="index.php?c=shop">商城管理</a></li>
                        <li <?php if (strtolower(CONTROLLER_NAME)== 'wechar') { ?>class="active"<?php } ?>><a href="index.php?c=wechar">微信管理</a></li>
                    </ul>
                    <ul class="nav navbar-nav hidden-desktop">
                        <li><a href="index.php?c=index&a=logout" target="_self">退出</a></li>
                        <li><a href="jacascript:void(0);">当前站点：<?php echo $_SESSION['site']['name'];?></a></li>
                    </ul>
                    <div class="user pull-left visible-desktop">
                        <div class="dropdown">
                            <a href="javascript:;" target="_self" class='dropdown-toggle' data-toggle="dropdown">
                                <nobr><span class="caret"></span><?php echo $_SESSION['site']['name'];?></nobr>
                            </a> 
                            <ul class="dropdown-menu pull-right">
                                <?php if(is_array(@getAllSite($_SESSION['admin_id']))){foreach ((array)@getAllSite($_SESSION['admin_id']) as $site) {?>
                                <li>
                                    <a href="index.php?c=index&a=change&site_id=<?php echo $site['site_id'];?>"><?php echo $site['name'];?></a>
                                </li>
                                <?php }} ?>
                            </ul>
                        </div>
                    </div>
                    <div class="user pull-right visible-desktop">
                        <div class="dropdown">
                            <a href="javascript:;" target="_self" class='dropdown-toggle' data-toggle="dropdown">
                                <nobr><span class="caret"></span><?php echo $_SESSION['nickname'];?></nobr>
                            </a> 
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="index.php?c=index&a=info" target="mainFrame">账户信息</a>
                                </li>
                                <li>
                                    <a href="index.php?c=index&a=logout" target="_self">退出</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="pull-right nav">
                        <li>
                            <a class="shortcut-button" href="<?php echo $_SESSION['site']['siteurl'];?>" target="_blank" title="站点首页">
                                <img src="<?php echo __PUBLIC__;?>images/pencil_48.png" alt="站点首页" title="站点首页">
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button" href="index.php?c=index&a=resetpd" target="mainFrame" title="修改密码">
                                <img src="<?php echo __PUBLIC__;?>images/paper_content_pencil_48.png" alt="修改密码" title="修改密码" >                   
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button" href="javascript:void(0);" onClick="fresh_sys();" title="刷新系统">
                                <img src="<?php echo __PUBLIC__;?>images/clock_48.png" alt="刷新系统" title="刷新系统">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $('[data-toggle="dropdown"]').each(function(){
        $(this).parent().hover(function(){
            $(this).find('ul').show();
        },function(){
            $(this).find('ul').hide();
        });
    });
    $('.toggle-nav').click(function(){
        if($('.right').is('.reight_p')){
            $('.right').removeClass('reight_p');    
            $('.left').show();
        }else{
            $('.right').addClass('reight_p');
            $('.left').hide();
        }       
    });
    function fresh_sys(){
        mainFrame.location.reload();
        return false;
    }
    function message_tips(){
        $.get("index.php?c=index&a=tips", function(data){
            
        },'json');
        setTimeout('message_tips()',10000);
    }
    $(function(){
        setTimeout('message_tips()',10000);
    });
    </script>