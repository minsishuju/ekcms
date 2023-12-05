<?php
/**********************************
 *      基础函数库
 * @file          framework.php
 * @package       framework
 * @author        xhg
 * @version       1.0.0
 * @date          2016-02-22
 * @link
 **********************************/
function config($name=null, $value=null,$default=null) {
    static $_config = array();
    // 无参数时获取所有
    if (empty($name)) {
        return $_config;
    }
    // 优先执行设置获取或赋值
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtoupper($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : $default;
            $_config[$name] = $value;
            return null;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtoupper($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
        $_config[$name[0]][$name[1]] = $value;
        return null;
    }
    // 批量设置
    if (is_array($name)){
        $_config = array_merge($_config, array_change_key_case($name,CASE_UPPER));
        return null;
    }
    return null; // 避免非法参数
}
function is_utf8($string){
    if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$string) == true) {
        return true;
    } else {
        return false;
    }
}
/**
 * 文本转HTML
 *
 * @param string $txt;
 * @return string;
 */
function text2Html($txt) {
    return str_replace(array(' ', '<', '>', "\r\n", "\n"), array('&nbsp;', '&lt;', '&gt;', '<br />', '<br />'), $txt);
}

/**
 * 取真实IP地址
 *
 * @return string;
 */
function getIp()
{
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
    {
        $ip = getenv("HTTP_CLIENT_IP");
    }
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
    {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
    {
        $ip = getenv("REMOTE_ADDR");
    }
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    else
    {
        $ip = "unknown";
    }
    return($ip);
    /*
    $ip=false;
    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip)
        {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++)
        {
            if (!eregi ("^(10│172.16│192.168).", $ips[$i]))
            {
                $ip = $ips[$i];
                break;
            }
        }
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    elseif (isset($_SERVER["HTTP_CLIENT_IP"]))
    {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    elseif ($_SERVER["REMOTE_ADDR"])
    {
        $ip = $_SERVER["REMOTE_ADDR"];
    }
    elseif (getenv("HTTP_X_FORWARDED_FOR"))
    {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }
    elseif (getenv("HTTP_CLIENT_IP"))
    {
        $ip = getenv("HTTP_CLIENT_IP");
    }
    elseif (getenv("REMOTE_ADDR"))
    {
        $ip = getenv("REMOTE_ADDR");
    }
    else
    {
        $ip = "Unknown";
    }
    return $ip;
    */
}

/**
 * 获得一段随机代码
 *
 * @param integer $length - 字符长度
 * 描述：长度为1-x
 *
 * @return string 1位随机x进制字串
 *
 **/
function getRandID($length) {
    $pattern    = '0123456789';
    $ranstr     = '';
    for($i=0; $i<$length; $i++) {
        $ranstr .= $pattern{mt_rand(0,strlen($pattern) - 1)};    //生成php随机数
    }
    return $ranstr;
}

/**
 * 采用RC4为核心算法，通过加密或者解密用户信息
 *
 * @param string $string - 加密或解密的串
 * @param string $operation - DECODE 解密；ENCODE 加密
 * @param string $key - 密钥 默认为FW_AUTHKEY常量
 * @return string 返回字符串
 */
function authCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    /**
     * $ckeyLength 随机密钥长度 取值 0-32;
     * 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
     * 取值越大，密文变动规律越大，密文变化 = 16 的 $ckeyLength 次方
     * 当此值为 0 时，则不产生随机密钥
     */
    $ckeyLength = 4;
    $key = md5($key ? $key : md5(FW_AUTHKEY.$_SERVER['HTTP_USER_AGENT']));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckeyLength ? ($operation == 'DECODE' ? substr($string, 0, $ckeyLength): substr(md5(microtime()), -$ckeyLength)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $keyLength = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckeyLength)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $stringLength = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $keyLength]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $stringLength; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }

}

/**
 * 为变量或者数组添加转义
 *
 * @param string $value - 字符串或者数组变量
 * @return array
 */
function iAddslashes($value) {
    return $value = is_array($value) ? array_map('iAddslashes', $value) : addslashes($value);
}

/**
 * 为变量或者数组添加反转义
 *
 * @param string $value - 字符串或者数组变量
 * @return array
 */
function iStripslashes($value) {
    return $value = is_array($value) ? array_map('iStripslashes', $value) : stripslashes($value);
}


/**
 * 根据中文裁减字符串
 *
 * @param string $string - 待截取的字符串
 * @param integer $length - 截取字符串的长度
 * @param string $dot - 缩略后缀
 * @return string 返回带省略号被裁减好的字符串
 */
function iCutstr($string, $length,$g_charset='utf-8', $dot = ' ...') {
    if (strlen($string) <= $length) {

        return $string;
    }
    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
    $strcut = '';
    if (strtolower($g_charset) == 'utf-8') {
        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {
            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1; $n++; $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2; $n += 2; $noc += 2;
            } elseif (224 <= $t && $t < 239) {
                $tn = 3; $n += 3; $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4; $n += 4; $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5; $n += 5; $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6; $n += 6; $noc += 2;
            } else {
                $n++;
            }
            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }
        $strcut = substr($string, 0, $n);
    } else {
        for ($i = 0; $i < $length; $i++) {

            $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
        }
    }
    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

    return $string == $strcut ? $strcut : $strcut.$dot;
}

/**
 * 获取GPC变量。对于type为integer的变量强制转化为数字型
 *
 * @param string $key - 权限表达式
 * @param string $type - integer 数字类型；string 字符串类型；array 数组类型
 * @param string $var - R $REQUEST变量；G $GET变量；P $POST变量；C $COOKIE变量
 * @return string 返回经过过滤或者初始化的GPC变量
 */
function getGpc($key, $type = 'integer', $var = 'R') {
    switch ($var) {
        case 'G': $var = &$_GET;
            break;
        case 'P': $var = &$_POST;
            break;
        case 'C': $var = &$_COOKIE;
            break;
        case 'R': $var = &$_REQUEST;
            break;
    }
    switch ($type) {
        case 'integer':
            $return = isset($var[$key]) ? intval($var[$key]) : 0;
            break;
        case 'string':
            $return = isset($var[$key]) ? $var[$key] : '';
            break;
        case 'array':
            $return = isset($var[$key]) ? $var[$key] : array();
            break;
        default:
            $return = isset($var[$key]) ? intval($var[$key]) : 0;
    }
    if(function_exists("get_magic_quotes_gpc") && get_magic_quotes_gpc()){
        $return = iStripslashes($return);
    }
    return $return;
}

/**
 * 设置cookie
 *
 * @param mixed $var - 变量名
 * @param mixed $value - 变量值
 * @param mixed $life - 生命周期期
 * @param mixed $prefix - 前缀
 */
function iSetCookie($var, $value, $life=0, $prefix = 1) {
    setcookie(($prefix ? FW_COOKIE_PRE : '').$var, $value, $life ? time() + $life : 0, FW_COOKIE_PATH, FW_COOKIE_DOMAIN, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}


/**
 * PHP下递归创建目录的函数，使用示例fwMakeDir('D:\web\web/a/b/c/d/f');
 *
 * @param string $dir - 需要创建的目录路径，可以是绝对路径或者相对路径
 * @return boolean 返回是否写入成功
 */
function makeDir($dir) {
    return is_dir($dir) or (makeDir(dirname($dir)) and mkdir($dir, 0777));
}

/**
 * 终止程序执行，显示提示信息
 *
 * @param string $message 显示的信息文本
 * @param string $urlForward 跳转地址，默认为空
 * @param string $time 链接跳转时间，默认为3秒
 * @return void
 */
function message($message, $urlForward = '', $time = 3) {
    $title = $message;
    $time = $time * 1000;
    if (0 === $time && $message == '') {
        $urlForward = $urlForward ? $urlForward : $_SERVER['HTTP_REFERER'];
        header('Location: ' . $urlForward);
    } else {
        if ($urlForward) {
            $message .= "<br><br><a href=\"$urlForward\">Check Here!</a>";
            $message .= "<script>".
                "function redirect() {window.location.href = '$urlForward';}\n".
                "setTimeout('redirect();', $time);\n".
                "</script>";
        }else{
            $message .= "<br><br><a href=\"javascript:window.history.go(-1)\">Check Here!</a>";
            $message .= "<script>".
                "function redirect() {window.history.go(-1);}\n".
                "setTimeout('redirect();', $time);\n".
                "</script>";
        }
        echo '<!DOCTYPE html>'.
            '<html>'.
            '<head>'.
            '<meta http-equiv="content-language" content="zh-cn" />'.
            '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'.
            '<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0">'.
            '<meta name="apple-touch-fullscreen" content="yes">'.
            '<meta name="apple-mobile-web-app-capable" content="yes">'.
            '<meta name="apple-mobile-web-app-status-bar-style" content="black">'.
            '<meta name="format-detection" content="telephone=no">'.
            '<meta http-equiv="pragma" content="no-cache">'.
            '<meta http-equiv="cache-control" content="no-cache">'.
            '<meta http-equiv="expires" content="0">'.
            '<title>'.$title.'</title>'.
            '<style type="text/css">'.
            'body { text-align:center; padding: 66px 10px 10px;}'.
            '.notice{ width:1200px; margin:20px auto; max-width:80%; display: block; white-space: pre-wrap; padding:10px 20px; background:#EEE; border:1px solid #654321; border-radius: 15px;font-weight:bold }'.
            '.notice{ width:500px; background: #E6EFC2; color: #264409; border-color: #C6D880; }'.
            '.notice a{ color: #8a1f11; text-decoration: underline}'.
            '.notice a:hover{text-decoration: none}'.
            '.notice p{text-align:center;}'.
            '</style>'.
            '</head>'.
            '<body>'.
            '<div class="notice">'.
            '   <p>'.$message.'</p>'.
            '</div>'.
            '</body>'.
            '</html>';
    }
    exit;
}

/**
 * 读文件
 *
 * @param string $file - 需要读取的文件，系统的绝对路径加文件名
 * @param boolean $exit - 不能读入是否中断程序，默认为中断
 * @return boolean 返回文件的具体数据
 */
function iReadFile($file, $exit = TRUE) {
    if (!@$fp = @fopen($file, 'rb')) {
        if ($exit) {
            exit('File :<br>'.$file.'<br>Have no access to read!');
        } else {
            return false;
        }
    } else {
        @$data = fread($fp, filesize($file));
        fclose($fp);
        return $data;
    }
}

/**
 * 写文件
 *
 * @param string $file - 需要写入的文件，系统的绝对路径加文件名
 * @param string $content - 需要写入的内容
 * @param string $mod - 写入模式，默认为w
 * @param boolean $exit - 不能写入是否中断程序，默认为中断
 * @return boolean 返回是否写入成功
 */
function writeFile($file, $content, $mod = 'w', $exit = TRUE) {
    if (!@$fp = @fopen($file, $mod)) {
        if ($exit) {
            exit('File :<br>'.$file.'<br>Have no access to write!');
        } else {
            return false;
        }
    } else {
        @flock($fp, 2);
        @fwrite($fp, $content);
        @fclose($fp);
        return true;
    }
}

/**
 * 格式化大小函数
 *
 * @param float $size
 * @return string
 */
function formatSize($size) {
    $prec=3;
    $size = round(abs($size));
    $units = array(0=>" B ", 1=>" KB", 2=>" MB", 3=>" GB", 4=>" TB");
    if ($size == 0) {
        return str_repeat(" ", $prec)."0$units[0]";
    }
    $unit = min(4, floor(log($size) / log(2) / 10));
    $size = $size * pow(2, -10 * $unit);
    $digi = $prec - 1 - floor(log($size) / log(10));
    $size = round($size * pow(10, $digi)) * pow(10, -$digi);
    return $size.$units[$unit];
}
/**
 * 获取文件名后缀
 *
 * @param mixed $fileName
 * @return string
 */
function fileExt($fileName) {
    return strtolower(trim(substr(strrchr($fileName, '.'), 1)));
}

/**
 * 获取目录
 *
 * @param mixed $dir
 * @param array $extArr
 * @return string
 */
function feadDir($dir, $extArr=array()) {
    $dirs = array();
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if (!empty($extArr) && is_array($extArr)) {
                if (in_array(strtolower(fwFileExt($file)), $extArr)) {
                    $dirs[] = $file;
                }
            } elseif ($file != '.' && $file != '..') {
                $dirs[] = $file;
            }
        }
        closedir($dh);
    }
    return $dirs;
}
/**
 * 取消HTML代码
 *
 * @param mixed $string
 * @return mixed
 */
function iHtmlSpecialChars($string) {
    if (is_array($string)) {
        foreach($string as $key => $val) {
            $string[$key] = iHtmlSpecialChars($val);
        }
    } else {
        $string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
            str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
    }
    return $string;
}
/**
 * 添加数据
 *
 * @param mixed $tableName
 * @param mixed $insertSqlArr
 * @param mixed $replace
 * @return string
 */
function insertTable($tableName, $insertSqlArr, $replace = false) {
    $insertKeySql = $insertValueSql = $comma = '';
    foreach ($insertSqlArr as $insertKey => $insertValue) {
        $insertKeySql .= $comma.'`'.$insertKey.'`';
        $insertValueSql .= $comma.'\''.$insertValue.'\'';
        $comma = ', ';
    }
    $method = $replace?'REPLACE':'INSERT';
    return $method.' INTO `'.$tableName.'` ('.$insertKeySql.') VALUES ('.$insertValueSql.')';
}

/**
 * 更新数据
 *
 * @param mixed $tableName
 * @param mixed $setSqlArr
 * @param mixed $whereSqlArr
 * @return string
 */
function updateTable($tableName, $setSqlArr, $whereSqlArr) {
    $setSql = $comma = '';
    foreach ($setSqlArr as $setKey => $setValue) {
        $setSql .= $comma.'`'.$setKey.'`'.'=\''.$setValue.'\'';
        $comma = ', ';
    }
    $where = $comma = '';
    if (empty($whereSqlArr)) {
        $where = '1';
    } elseif (is_array($whereSqlArr)) {
        foreach ($whereSqlArr as $key => $value) {
            $where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
            $comma = ' AND ';
        }
    } else {
        $where = $whereSqlArr;
    }
    return 'UPDATE `'.$tableName.'` SET '.$setSql.' WHERE '.$where;
}
/**
 * 转义字符串用于查询
 *
 * @param string $char
 * @return string
 */
function escapeString($char) {
    return mysql_escape_string($char);
}
/**
 * 为sqlite转义字符串用于查询
 *
 * @param string $char
 * @return string
 */
function sqliteEscapeString($char) {
    return str_replace("'","''",$char);
}
/**
 * 生成简单验证码，需配合cookie验证或者session验证
 * @param string $text - 需要生成的验证码
 * @param integer $im_x - 宽
 * @param integer $im_y - 高
 * @return none 无返回
 */
function getSecode($text, $im_x = 140, $im_y = 40) {
    $im = imagecreatetruecolor($im_x,$im_y);
    $text_c = ImageColorAllocate($im, mt_rand(0,0),mt_rand(0,0),mt_rand(0,20));
    $tmpC0=mt_rand(100,255);
    $tmpC1=mt_rand(100,255);
    $tmpC2=mt_rand(100,255);
    $buttum_c = ImageColorAllocate($im,$tmpC0,$tmpC1,$tmpC2);
    imagefill($im, 16, 13, $buttum_c);

    $font = FW_PATH.'include/fonts/'.mt_rand(1,3).'.ttf';

    $array = array(-1,1);
    $p = array_rand($array);

    for ($i=0;$i<strlen($text);$i++) {
        $tmp = substr($text,$i,1);
        $an = $array[$p]*mt_rand(20,35);//角度
        $size = mt_rand(25,30);
        imagettftext($im, $size, $an, 15+$i*$size, 30, $text_c, $font, $tmp);
    }
    $distortion_im = imagecreatetruecolor ($im_x, $im_y);
    imagefill($distortion_im, 16, 13, $buttum_c);
    for( $i=0; $i<$im_x; $i++) {
        for( $j=0; $j<$im_y; $j++) {
            $rgb = imagecolorat($im, $i , $j);
            if( (int)($i+20+sin($j/$im_y*2*M_PI)*10) <= imagesx($distortion_im)&& (int)($i+20+sin($j/$im_y*2*M_PI)*10) >=0 ) {
                imagesetpixel ($distortion_im, (int)($i+10+sin($j/$im_y*2*M_PI-M_PI*0.1)*4) , $j , $rgb);
            }
        }
    }
    //加入干扰象素;
    $count = 160;//干扰像素的数量
    for($i=0; $i<$count; $i++) {
        $randcolor = ImageColorallocate($distortion_im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
        imagesetpixel($distortion_im, mt_rand()%$im_x , mt_rand()%$im_y , $randcolor);
    }

    $rand = mt_rand(5,30);
    $rand1 = mt_rand(15,25);
    $rand2 = mt_rand(5,10);
    for ($yy=$rand; $yy<=+$rand+2; $yy++) {
        for ($px=-80;$px<=80;$px=$px+0.1) {
            $x=$px/$rand1;
            if ($x!=0) {
                $y=sin($x);
            }
            $py=$y*$rand2;
            imagesetpixel($distortion_im, $px+80, $py+$yy, $text_c);
        }
    }

    //设置文件头;
    Header("Content-type: image/JPEG");

    //以PNG格式将图像输出到浏览器或文件;
    ImagePNG($distortion_im);

    //销毁一图像,释放与image关联的内存;
    ImageDestroy($distortion_im);
    ImageDestroy($im);
}
/**
 * 生成缩略图函数
 * @param  $imgurl 图片路径
 * @param  $width  缩略图宽度
 * @param  $height 缩略图高度
 * @param  $autocut 是否自动裁剪 默认裁剪，当高度或宽度有一个数值为0是，自动关闭
 * @param  $smallpic 无图片是默认图片路径
 */
function thumb($imgurl, $width = 0, $height = 0) {
    if(empty($imgurl)) return '';
    $imgurl = substr($imgurl,0,1) == '.' ? $imgurl : '.'.$imgurl;
    if($width ==0 && $height == 0) return $imgurl;
    if(!extension_loaded('gd') || strpos($imgurl, '://')) return $imgurl;
    if(!file_exists($imgurl)) return '';
    list($width_t, $height_t, $type, $attr) = getimagesize($imgurl);
    if($width>=$width_t && $height>=$height_t) return substr($imgurl,1);
    $newimgurl = $imgurl . '_thumb_'.$width.'_'.$height.'.' . fileExt($imgurl);
    if(file_exists($newimgurl)) return substr($newimgurl,1);
    $image = new image;
    return $image->thumb($imgurl, $newimgurl, $width, $height) ? substr($newimgurl,1) : $imgurl;
}
/**
 * 添加水印函数，水印位置右下角
 * @param  $imgurl 图片路径
 * @param  $markurl  水印图片路径
 */
function watermark($imgurl, $markurl) {
    if(empty($imgurl)) return '';
    $imgurl = substr($imgurl,0,1) == '.' ? $imgurl : '.'.$imgurl;
    if(!extension_loaded('gd') || strpos($imgurl, '://')) return $imgurl;
    $image = new image;
    return $image->watermark($imgurl, $markurl);
}
function ismobile() {
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    if (isset ($_SERVER['HTTP_VIA']))
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/**
 * url访问过滤
 */
function SecurityTesting()
{
    $guard = include_once(FW_PATH.'/common/safeguard.php');
    if($guard['guard']==1){
        $pattern = '/[\',:;…*~`$！!@^+（）=?￥)(<>{}]|\]|\[|\\\|\"|\|alert|define|eval|asp|file_get_contents|include|require|require_once|shell_exec|phpinfo|system|passthru|preg_|executeecho|print|print_r|var_dump|showmodaldialog/';
        //规避错误拦截后台页面
        if(substr(REQUEST_URI,0,20)=="/hnekadmin/index.php")
        {
            $admin=['='=>'','?'=>'','&'=>'']; //后台管理 允许的字符串
            $pattern = strtr($pattern,$admin);
        }else{

            //判断是不是搜索页面
            if(substr(REQUEST_URI,0,13)=="/search.html?")
            {
                $search=['='=>'','?'=>'']; //搜索 允许的字符串
                $pattern = strtr($pattern,$search);
            }

            //放行白名单
            if(count(string_to_array())>0)
            {
                $question = string_to_array();
                foreach ($question as $k=>$v)
                {
                    if(in_array($k,$guard['white_list']))
                    {
                        unset($question[$k]);
                    }
                }
                if(empty($question))
                {
                    $admin=['='=>'','?'=>'','&'=>''];
                    $pattern = strtr($pattern,$admin);
                }
            }
        }

        //对于危险的请求进行正则拦截
        if(preg_match($pattern, REQUEST_URI, $matches))
        {
            header('HTTP/1.1 404 Not Found');
            header('Status:404 Not Found');
            $exceptionFile =  FW_PATH.'template/intercept.html';
            include $exceptionFile;
            exit;
        }
    }
}

/**请求参数字符串转数组**/
function string_to_array($string='')
{
    $arrtemp=[];
    $string =$string==''?$_SERVER['QUERY_STRING']:$string;
    foreach (explode('&',$string) as $k=>$v)
    {
        $temp=explode('=',$v);
        $arrtemp[$temp[0]]=$temp[1];
    }

    if($arrtemp['a']=='sitemap' && array_key_exists('type',$arrtemp))
    {
        unset($arrtemp['type']);
    }
    unset($arrtemp['a'],$arrtemp['id'],$arrtemp['othername']);
    return $arrtemp;
}
/**********************************
 **********************************/