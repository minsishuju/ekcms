<?php if (!defined('IN_FW')) exit('Access Denied');?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="<?php echo __PUBLIC__;?>kindeditor/themes/default/default.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/bootstrap_min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/css.css" media="all" />
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/jquery.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>js/bootstrap.min.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>kindeditor/kindeditor-all-min.js" ></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>kindeditor/lang/zh_CN.js"></script>
    <script type="text/javascript" src="<?php echo __PUBLIC__;?>DatePicker/DatePicker.js"></script>
    <script type="text/javascript">
        var editor;
        KindEditor.ready(function(K) {
            editor = K.create('textarea.editor', {
                uploadJson:'index.php?c=Common&a=editor',
                allowFileManager : true,
                fileManagerJson: "index.php?c=Common&a=manager",
                urlType : '',
                formatUploadUrl:false,
                loadStyleMode : false
            });
        });
    </script>
    <title>E营销管理系统</title>
</head>
<body>
    <ul class="breadcrumb">
        <li><a href="javascript:void(0)">首页</a> <span class="divider">&gt;&gt;</span></li>
        <li><a href="javascript:void(0)">内容管理</a> <span class="divider">&gt;&gt;</span></li>
        <li class="active"><a href="index.php?c=collection">内容采集</a></li>
        <li class="pull-right" style="margin-top:-3px">
            <a class="btn btn-small btn-primary pull-right" href="index.php?c=collection">返回列表</a>
        </li>
    </ul>
    <form action="" method="post" class="form-search">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th colspan="2"><strong>基本信息</strong></th>
                </tr>
                <tr>
                    <td align="right" width="10%"><strong>采集项目名：</strong></td>
                    <td>
                        <input type="text" name="name" value="<?php echo @iHtmlSpecialChars($info['name']);?>" />
                    </td>
                </tr>
                <tr>
                    <td align="right" width="10%"><strong>采集页面编码：</strong></td>
                    <td>
                        <label class="radio"><input name="sourcecharset" type="radio" value="GBK">GBK</label>
                        <label class="radio"><input name="sourcecharset" checked="checked" type="radio" value="UTF-8">UTF-8</label>
                    </td>
                </tr>
                <tr>
                    <th colspan="2"><strong>网址采集</strong></th>
                </tr>
                <tr>
                    <td align="right"><strong>网址类型：</strong></td>
                    <td>
                        <label class="radio"><input name="sourcetype" checked="checked" type="radio" value="1">序列网址</label>
                        <label class="radio"><input name="sourcetype" type="radio" value="2">多个网页</label>
                    </td>
                </tr>
                <tr id="url_type_1">
                    <td align="right"><strong>网址配置：</strong></td> 
                    <td>
                        <input name="urlpage1" id="urlpage_1" size="100" value="" class="input-xxlarge" type="text"><br> 
                        (如：http://www.hnek.net/news/(*).html,页码使用(*)做为通配符。<br>
                        页码从: <input name="pagesize_start" value="1" size="4" class="input-mini" type="text">
                        到 <input name="pagesize_end" value="10" size="4" class="input-mini" type="text">
                        每次增加 <input name="par_num" size="4" value="1" class="input-mini" type="text">
                    </td>
                </tr>
                <tr id="url_type_2" style="display:none">
                    <td align="right"><strong>网址配置：</strong></td>
                    <td>
                        <textarea rows="10" cols="80" name="urlpage2" class="input-xxlarge" id="urlpage_2"></textarea> <br>每行一条
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>网址配置：</strong></td>
                    <td>
                    网址中必须包含 <input name="url_contain" value="" type="text"> 网址中不得包含  <input name="url_except" value="" type="text">
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>Base配置：</strong></td>
                    <td>
                        <input name="page_base" value="" size="100" type="text">如果目标网站配置了Base请设置。
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>获取网址：</strong></td>
                    <td>
                        从 <textarea rows="5" cols="40" class="input-xlarge" name="url_start"></textarea> 
                        到 <textarea rows="5" cols="40" class="input-xlarge" name="url_end"></textarea> 结束			
                    </td>
                </tr>
                <tr>
                    <th colspan="2"><strong>内容规则</strong></th>
                </tr>
                <tr>
                    <td align="right"><strong>标题匹配规则：</strong></td>
                    <td>
                        匹配规则：
                        <textarea rows="5" cols="40" name="title_rule" id="title_rule">&lt;title&gt;[内容]&lt;/title&gt;</textarea>
                        过滤选项：
                        <textarea rows="5" cols="50" name="title_html_rule" id="title_html_rule"></textarea>
                        <input value="选择" class="btn btn-primary " onclick="html_role('title_html_rule')" type="button">
                        <br>使用"[内容]"作为通配符
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>作者匹配规则：</strong></td>
                    <td>
                        匹配规则：
                        <textarea rows="5" cols="40" name="author_rule" id="author_rule"></textarea>
                        过滤选项：
                        <textarea rows="5" cols="50" name="author_html_rule" id="author_html_rule"></textarea>
                        <input value="选择" class="btn btn-primary " onclick="html_role('author_html_rule')" type="button">
                        <br>使用"[内容]"作为通配符
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>来源匹配规则：</strong></td>
                    <td>
                        匹配规则：
                        <textarea rows="5" cols="40" name="comeform_rule" id="comeform_rule"></textarea>
                        过滤选项：
                        <textarea rows="5" cols="50" name="comeform_html_rule" id="comeform_html_rule"></textarea>
                        <input value="选择" class="btn btn-primary " onclick="html_role('comeform_html_rule')" type="button">
                        <br>使用"[内容]"作为通配符
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>时间匹配规则：</strong></td>
                    <td>
                        匹配规则：
                        <textarea rows="5" cols="40" name="time_rule" id="time_rule"></textarea>
                        过滤选项：
                        <textarea rows="5" cols="50" name="time_html_rule" id="time_html_rule"></textarea>
                        <input value="选择" class="btn btn-primary " onclick="html_role('time_html_rule')" type="button">
                        <br>使用"[内容]"作为通配符
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>内容匹配规则：</strong></td>
                    <td>
                        匹配规则：
                        <textarea rows="5" cols="40" name="content_rule" id="content_rule"></textarea>
                        过滤选项：
                        <textarea rows="5" cols="50" name="content_html_rule" id="content_html_rule"></textarea>
                        <input value="选择" class="btn btn-primary " onclick="html_role('content_html_rule')" type="button">
                        <br>使用"[内容]"作为通配符
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>分页模式：</strong></td>
                    <td>
                        <input name="content_page_rule" checked="checked" value="1" type="radio"> 全部列出模式
                        <input name="content_page_rule" value="2" type="radio"> 上下页模式
                    <td>
                </tr>
                <tr id="nextpage" style="display: none;">
                    <td align="right"><strong>下一页规则：</strong></td>
                    <td>
                        <input name="content_nextpage" size="100" value="" type="text"><br>
                        请填写下一页超链接中间的代码。如：<a href="http://www.hnek.net/page_1.html">下一页</a>，他的“下一页规则”为“下一页”。
                    </td>
                </tr>
                <tr>
                    <td align="right"><strong>下一页匹配规则：</strong></td>
                    <td>
                        从 <textarea rows="5" cols="40" class="input-xlarge" name="content_page_start"></textarea> 
                        到 <textarea rows="5" cols="40" class="input-xlarge" name="content_page_end"></textarea>
                    </td>
                </tr>
				<tr>
                    <td align="right"><strong>头部尾部插入内容：</strong></td>
                    <td>
                        头部 <textarea rows="5" cols="40" class="input-xlarge" name="content_html_add_start"></textarea> 
                        尾部 <textarea rows="5" cols="40" class="input-xlarge" name="content_html_add_end"></textarea>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-center">
                        <input class="btn btn-primary" type="submit" value="保 存" />
                        <input class="btn btn-warning" type="button" onclick="javascript:history.back(-1);" value="返 回" />
                    </td>
                </tr>
            </tfoot>
        </table>
    </form>
    <div id="updateimg" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">选择标签</h3>
        </div>
        <div class="modal-body">
            <p class="form-search">
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;p([^&gt;]*)&gt;(.*)&lt;/p&gt;[|]"> &lt;p&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;a([^&gt;]*)&gt;(.*)&lt;/a&gt;[|]"> &lt;a&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;script([^&gt;]*)&gt;(.*)&lt;/script&gt;[|]"> &lt;script&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;iframe([^&gt;]*)&gt;(.*)&lt;/iframe&gt;[|]"> &lt;iframe&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;table([^&gt;]*)&gt;(.*)&lt;/table&gt;[|]"> &lt;table&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;span([^&gt;]*)&gt;(.*)&lt;/span&gt;[|]"> &lt;span&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;b([^&gt;]*)&gt;(.*)&lt;/b&gt;[|]"> &lt;b&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;img([^&gt;]*)&gt;[|]"> &lt;img&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;object([^&gt;]*)&gt;(.*)&lt;/object&gt;[|]"> &lt;object&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;embed([^&gt;]*)&gt;(.*)&lt;/embed&gt;[|]"> &lt;embed&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;param([^&gt;]*)&gt;(.*)&lt;/param&gt;[|]"> &lt;param&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;div([^&gt;]*)&gt;[|]"> &lt;div&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;/div&gt;[|]"> &lt;/div&gt;
                </label>
                <label class="checkbox">
                    <input type="checkbox" name="html_rule" value="&lt;!--([^&gt;]*)--&gt;[|]"> &lt;!-- --&gt;
                </label>
            </p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            <button class="btn btn-primary" data-dismiss="modal" id="updateimg_btn" aria-hidden="true">确定</button>
        </div>
    </div>
    <script>
    var input_id = '';
    $(function(){
        $('input[name="sourcetype"]').click(function(){
            var obj = $(this).val();
            for (var i=1; i<=2; i++){
                if (obj==i){ 
                    $('#url_type_'+i).show();
                } else {
                    $('#url_type_'+i).hide();
                }
            }
        });
        $('input[name="content_page_rule"]').click(function(){
            var obj = $(this).val();
            if (obj == 2) {
                $('#nextpage').show();
            } else {
                $('#nextpage').hide();
            }
        });
        $('#updateimg_btn').click(function(){
            var old = $("textarea[name='"+input_id+"']").val();
            var str = '';
            $("input[name='html_rule']:checked").each(function(){
                str+=$(this).val()+"\n";
            });
            $("#"+input_id).val((old ? old+"\n" : '')+str);
        });
    });
    function html_role(id) {
        input_id = id;
        $('#updateimg').removeData();
        $('#updateimg').modal('show');
    }
    </script>
</body>
</html>