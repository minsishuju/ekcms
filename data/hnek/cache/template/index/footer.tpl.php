<?php if (!defined('IN_FW')) exit('Access Denied');?>
<div>

    <div class="diz left"></div>

    <div class="lxw right">

        <div class="lxwm_c">

            <div class="lxwm_c1"><img src="<?php echo __PUBLIC__;?>images/tq_01.jpg"></div>

            <span><?php echo @config('SITE_INFO.phone');?><br>138 3818 8615</span>

            <div class="lxwm_c1"><img src="<?php echo __PUBLIC__;?>images/tq_02.jpg"></div>

            <span>lingpaoad@sina.com</span>

            <div class="lxwm_c1"><img src="<?php echo __PUBLIC__;?>images/tq_03.jpg"></div>

            <span>郑州市中州大道晨旭路<br>瑞银大厦23楼</span>

        </div>

    </div>

    <div class="clearit"></div>

</div>


<style>
  .links{ color:rgba(255,255,255,.6); padding:10px 10%;}
  .links a{ color:rgba(255,255,255,.6);}
  .links a:hover,.links a:focus{color:#c30000;}
</style>
<div class="bott">
   <div>
    <div class="bott_l left">

        <img src="<?php echo __PUBLIC__;?>images/bot_lgo.jpg"><br>Copyright © 2004-2018<br />
 <a href="https://beian.miit.gov.cn/" target="_blank">豫ICP备18007656号-1</a>

    </div>

    <div class="bott_r right">
	

        <ul>

            <li><span>领跑</span>

                <?php $data = Content::parse('action="category" category_id="1" num="4"'); ?> 

                <?php if(is_array($data)){foreach ((array)$data as $v) {?>

                <br><a href="<?php echo $v[url];?>"><?php echo $v[name];?></a>

                <?php }} ?>

                

            </li>

            <li><span>案例</span>

                <?php $data = Content::parse('action="category" category_id="2" num="4"'); ?> 

                <?php if(is_array($data)){foreach ((array)$data as $v) {?>

                <br><a href="<?php echo $v[url];?>"><?php echo $v[name];?></a>

                <?php }} ?>

                

            </li>

            <li><span>观点</span>

                <?php $data = Content::parse('action="category" category_id="3" num="4"'); ?> 

                <?php if(is_array($data)){foreach ((array)$data as $v) {?>

                <br><a href="<?php echo $v[url];?>"><?php echo $v[name];?></a>

                <?php }} ?>

                

            </li>

            <li><span>联系</span>

                <?php $data = Content::parse('action="category" category_id="4" num="4"'); ?> 

                <?php if(is_array($data)){foreach ((array)$data as $v) {?>

                <br><a href="<?php echo $v[url];?>"><?php echo $v[name];?></a>

                <?php }} ?>

                

            </li>

        </ul>

    </div>
	 <div class="clearit"></div>
     </div>
	 <div class="links">
      友情链接：<a href="http://www.zhongxinbanjia.com" target="_blank">张店搬家</a>&nbsp;<a href="http://www.ksrbg.com" target="_blank">轴承压装机</a>&nbsp;<a href="http://www.jxjstcm.cn" target="_blank">南昌庆典公司</a>&nbsp;<a href="http://www.jsxlddq.com" target="_blank">成品支架</a>&nbsp;<a href="http://www.haulsen.cn" target="_blank">AGV</a>&nbsp;<a href="http://www.gyshuntian.com" target="_blank">香油机</a>&nbsp; <a href="http://www.lingpaoad.com" target="_blank">郑州logo设计</a>&nbsp;<a href="http://www.hbgzcd.com" target="_blank">北京玻璃钢化粪池</a>&nbsp;<a href="http://www.njhrjz.net" target="_blank">南京家政</a>&nbsp;<a href="http://www.tjhfsly.com" target="_blank">天津物流公司</a>&nbsp;<a href="http://www.law6b.com" target="_blank">重庆法律顾问律师</a>&nbsp;<a href="http://www.ks-yh.com" target="_blank">昆山废品回收</a>&nbsp;<a href="http://www.gongsilaw22.com" target="_blank">股权律师</a>&nbsp;
	</div>

   

</div>
<!--
  <div class="rightfix" style="top:60%">
    <ul>
        <li><a href="#top"><i class="fixedico01"></i></a></li>
        <li>
            <a href="http://wpa.qq.com/msgrd?v=3&uin=63254829&site=qq&menu=yes" class="fixhover"><i class="fixedico02"></i></a>
            <a href="http://wpa.qq.com/msgrd?v=3&uin=63254829&site=qq&menu=yes">
                <span class="fixqq" style="line-height: 25px">63254829<br>3563596191</span>
            </a>
        </li>
        <li><a href="#" class="fixhover"><i class="fixedico03"></i></a><a></a><span class="fixtel"><?php echo @config('SITE_INFO.phone');?></span></li>
        <li><a href="#" class="fixhoverWx"><i class="fixedico04"></i><div class="fixwx"><img src="<?php echo __PUBLIC__;?>/images/erweima.jpg" width="140" height="140" alt=""></div></a></li>
    </ul>
</div>-->
<link rel="stylesheet" type="text/css" href="<?php echo __PUBLIC__;?>style/lanren.css">
 <!-- 代码部分begin -->
<div id="rightArrow" class="hidden-xs" style="top:250px;right: 170px"><a href="javascript:;" title="在线客户"></a></div>
<div id="floatDivBoxs" class="hidden-xs" style="top:250px;right: 0px">
  <div class="floatDtt">在线客服</div>
  <div class="floatShadow">
    <ul class="floatDqq">
      <li><a target="_blank" href="tencent://message/?uin=819439578&Site=sc.chinaz.com&Menu=yes"><img src="<?php echo __PUBLIC__;?>images/qq.png" align="absmiddle">在线客服1号</a></li>
      <li><a target="_blank" href="tencent://message/?uin=63254829&Site=sc.chinaz.com&Menu=yes"><img src="<?php echo __PUBLIC__;?>images/qq.png" align="absmiddle">在线客服2号</a></li>
    </ul>
    <div class="floatImg"><img src="<?php echo __PUBLIC__;?>images/erweima.jpg" width="100%">微信公众账号</div>
  </div>
  <div class="floatDbg"></div>
</div> 
<script>
    var flag=0;
    $('#rightArrow').on("click",function(){
      if(flag==0){
        $("#floatDivBoxs").animate({right: '-175px'},300);
        $(this).animate({right: '-5px'},300);
        $(this).css('background-position','-50px 0');
        flag=1;
      }else{
        $("#floatDivBoxs").animate({right: '0'},300);
        $(this).animate({right: '170px'},300);
        $(this).css('background-position','0px 0');
        flag=0;
      }
    });
</script>
<?php echo @config('SITE_INFO.site_code');?>

<script type="text/javascript" src="<?php echo __PUBLIC__;?>js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#main_nav').allenMenu();
			$('#slide').allenSlide();
		});
</script>

</body>

</html>