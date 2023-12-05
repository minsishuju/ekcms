<?php
class ControllerContent extends Controller {
    protected function template($file) {
        config('__PUBLIC__') && (defined('__PUBLIC__') or define('__PUBLIC__', HTTP_HOST . '/' . config('__PUBLIC__'))); 
        $mtplfile = ROOT_PATH . config('__TEMPLATE__') . 'wap/'. $file.'.html';
        $mobjfile = ROOT_PATH . 'cache/template/wap/'.  $file.'.tpl.php';
        if(ismobile() && is_file($mtplfile)){
            $this->tplfile = $mtplfile;
            $this->objfile = $mobjfile;
        }else{
            $this->tplfile = ROOT_PATH . config('__TEMPLATE__') . $file.'.html';
            $this->objfile = ROOT_PATH . 'cache/template/'.  $file.'.tpl.php';
        }
        if(!is_file($this->tplfile)){
            return false;
        }
        if (IS_DEBUG || (@filemtime($this->tplfile) > @filemtime($this->objfile))) {
            $T = new contentTemplate;
            $T->complie($this->tplfile, $this->objfile);
        }
        return $this->objfile;
    }
}
?>