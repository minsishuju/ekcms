<?php
/*****************WY-top*****************
*   模板类
* @file            /class/contentTemplate.class.php
* @package
* @author       xhg
* @version       1.0.2
* @date         2012-03-01 10:28:48
* @link
*****************WY-top*****************/

!defined('IN_FW') && exit('Access Denied');

class contentTemplate extends template {

    /**
    *  解析模板标签
    *
    * @param string $template ：模板源文件内容
    * @return string
    */
    function parse($template) {
        $template = parent::parse($template);
        for ($i=0; $i<3; $i++) {
            $template = preg_replace_callback("/\{content (.*?)\}(.+?)\{\/content\}/is", array($this, 'contentSection'), $template);
        }
        $template = preg_replace_callback("/\{guestbook (.*?)\}(.+?)\{\/guestbook\}/is", array($this, 'guestbookSection'), $template);
        $template = preg_replace_callback("/\{bbs (.*?)\}(.+?)\{\/bbs\}/is", array($this, 'bbsSection'), $template);
        return $template;
    }
    /**
    * 替换模板中的内容调用
    * @param string $arr ：
    * @param string $k ：
    * @param string $v ：
    * @param string $statement ：
    * @return string
    */
    function contentSection($matches){
        $attr = array();
        $page = false;
        $return = 'data';
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$matches[1],$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        $i = 0;
        foreach($arr as $k=>$v){
            $i++;
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            if(strtolower($name) == 'return'){
                $value = substr($v, $pos + 2,-1);
                $return = $value;
                unset($arr[$k]);
            }
            if(strtolower($name) == 'page'){
                $page = true;
            }
        }
        $arrstr = implode(' ',$arr);
        $arrstr = preg_replace("/({$this->mVarRegexp})/", '\'.\\1.\'',$arrstr);
        $returnstr = $page ? '<?php $'.$return.' = Content::parse(\'' . $arrstr . '\'); if($'.$return.') $pages = Content::page(\'' . $arrstr . '\'); ?> ' . $matches[2] : '<?php $'.$return.' = Content::parse(\'' . $arrstr . '\'); ?> ' . $matches[2];
        return $returnstr;
    }
    /**
    * 替换模板中的内容调用
    * @param string $arr ：
    * @param string $k ：
    * @param string $v ：
    * @param string $statement ：
    * @return string
    */
    function guestbookSection($matches){
        $attr = array();
        $page = false;
        $return = 'data';
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$matches[1],$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        $i = 0;
        foreach($arr as $k=>$v){
            $i++;
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            if(strtolower($name) == 'return'){
                $value = substr($v, $pos + 2,-1);
                $return = $value;
                unset($arr[$k]);
            }
            if(strtolower($name) == 'page'){
                $page = true;
            }
        }
        $arrstr = implode(' ',$arr);
        $arrstr = preg_replace("/({$this->mVarRegexp})/", '\'.\\1.\'',$arrstr);
        $returnstr = $page ? '<?php $'.$return.' = Guestbook::parse(\'' . $arrstr . '\'); if($'.$return.') $pages = Guestbook::page(\'' . $arrstr . '\'); ?> ' . $matches[2] : '<?php $'.$return.' = Guestbook::parse(\'' . $arrstr . '\'); ?> ' . $matches[2];
        return $returnstr;
    }
    function bbsSection($matches){
        $attr = array();
        $page = false;
        $return = 'data';
        preg_match_all('/[a-zA-Z_]\w+=".*?"/is',$matches[1],$arr);
        $arr = $arr[0];
        $arr = array_map('trim',$arr);
        $i = 0;
        foreach($arr as $k=>$v){
            $i++;
            $pos = strpos($v, "=");
            $name = substr($v, 0, $pos);
            if(strtolower($name) == 'return'){
                $value = substr($v, $pos + 2,-1);
                $return = $value;
                unset($arr[$k]);
            }
            if(strtolower($name) == 'page'){
                $page = true;
            }
        }
        $arrstr = implode(' ',$arr);
        $arrstr = preg_replace("/({$this->mVarRegexp})/", '\'.\\1.\'',$arrstr);
        $returnstr = $page ? '<?php $'.$return.' = Bbs::parse(\'' . $arrstr . '\'); if($'.$return.') $pages = Bbs::page(\'' . $arrstr . '\'); ?> ' . $matches[2] : '<?php $'.$return.' = Bbs::parse(\'' . $arrstr . '\'); ?> ' . $matches[2];
        return $returnstr;
    }
}
/**********************************

**********************************/