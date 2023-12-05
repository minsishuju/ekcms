<?php
//编辑器配置及编辑器上传信息配置
class EditorController extends Controller
{
    private $site_info,$db,$Uploader;

    public function __construct(){
        parent::__construct();
        // 启动会话
        if (! $_SESSION['site']) {
            die('权限不足');
        }
        $site_id = $_SESSION['site']['site_id'] ? $_SESSION['site']['site_id'] : getGpc('site_id','integer','P');
        if($site_id){
            $this->db = Mysql::connect();
            $this->site_info = $this->db->getOne('select * from '.config('DB_TABLE_PRE').'site where site_id = "' . $site_id . '"');
        }
        //共用文件上传处理类
        $this->Uploader=dirname(dirname(__FILE__))."/common/Uploader.class.php";
    }
    /**
     * 修正上传文件存放目录
     *
    */
    private function getConfig()
    {
        $CONFIG=[];
        include_once dirname(dirname(__FILE__))."/common/ueditor.config.php";
        $path="/data/".$this->site_info['site_dir'];
        $CONFIG['imagePathFormat']      =$path.$CONFIG['imagePathFormat'];
        $CONFIG['scrawlPathFormat']     =$path.$CONFIG['scrawlPathFormat'];
        $CONFIG['snapscreenPathFormat'] =$path.$CONFIG['snapscreenPathFormat'];
        $CONFIG['catcherPathFormat']    =$path.$CONFIG['catcherPathFormat'];
        $CONFIG['videoPathFormat']      =$path.$CONFIG['videoPathFormat'];
        $CONFIG['filePathFormat']       =$path.$CONFIG['filePathFormat'];
        $CONFIG['imageManagerListPath'] =$path.$CONFIG['imageManagerListPath'];
        $CONFIG['fileManagerListPath']  =$path.$CONFIG['fileManagerListPath'];
//        echo SITE_PATH; //根目录地址
        return $CONFIG;
    }
    public function index()
    {
        $CONFIG=self::getConfig();
        $action = $_GET['action'];

        switch ($action) {
            case 'config':
                $result = json_encode($CONFIG);
                break;

            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = self::action_upload($CONFIG);
                break;

            /* 列出图片 */
            case 'listimage':
                $result = self::action_list($CONFIG,'listimage');
                break;
            /* 列出文件 */
            case 'listfile':
                $result = self::action_list($CONFIG,'listfile');
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = self::action_crawler($CONFIG);
                break;

            default:
                $result = json_encode(array(
                    'state' => '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                echo json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        } else {
            echo $result;
        }
    }
    /**
     * 文件上传
    */
    protected function action_upload($CONFIG)
    {
        include $this->Uploader;
        /* 上传配置 */
        $base64 = "upload";
        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $config = array(
                    "pathFormat" => $CONFIG['imagePathFormat'],
                    "maxSize" => $CONFIG['imageMaxSize'],
                    "allowFiles" => $CONFIG['imageAllowFiles']
                );
                $fieldName = $CONFIG['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config = array(
                    "pathFormat" => $CONFIG['scrawlPathFormat'],
                    "maxSize" => $CONFIG['scrawlMaxSize'],
                    "allowFiles" => $CONFIG['scrawlAllowFiles'],
                    "oriName" => "scrawl.png"
                );
                $fieldName = $CONFIG['scrawlFieldName'];
                $base64 = "base64";
                break;
            case 'uploadvideo':
                $config = array(
                    "pathFormat" => $CONFIG['videoPathFormat'],
                    "maxSize" => $CONFIG['videoMaxSize'],
                    "allowFiles" => $CONFIG['videoAllowFiles']
                );
                $fieldName = $CONFIG['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config = array(
                    "pathFormat" => $CONFIG['filePathFormat'],
                    "maxSize" => $CONFIG['fileMaxSize'],
                    "allowFiles" => $CONFIG['fileAllowFiles']
                );
                $fieldName = $CONFIG['fileFieldName'];
                break;
        }

        if (defined('STATIC_DIR')) {
            $config['pathFormat'] = STATIC_DIR . $config['pathFormat'];
        }

        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $base64);

        // 图片打水印
        $rs = $up->getFileInfo();
        $ext = array(
            '.jpg',
            '.png',
            '.gif'
        );
        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         * "state" => "", //上传状态，上传成功时必须返回"SUCCESS"
         * "url" => "", //返回的地址
         * "title" => "", //新文件名
         * "original" => "", //原始文件名
         * "type" => "" //文件类型
         * "size" => "", //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }

    /**
     * 文件管理
    */
    private function action_list($CONFIG,$action)
    {
        include $this->Uploader;
        /* 判断类型 */
        switch ($action) {
            /* 列出文件 */
            case 'listfile':
                $allowFiles = $CONFIG['fileManagerAllowFiles'];
                $listSize = $CONFIG['fileManagerListSize'];
                $path = $CONFIG['fileManagerListPath'];
                break;
            /* 列出图片 */
            case 'listimage':
            default:
                $allowFiles = $CONFIG['imageManagerAllowFiles'];
                $listSize = $CONFIG['imageManagerListSize'];
                $path = $CONFIG['imageManagerListPath'];
        }
        $allowFiles = substr(str_replace(".", "|", join("", $allowFiles)), 1);

        /* 获取参数 */
        $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : $listSize;
        $start = isset($_GET['start']) ? htmlspecialchars($_GET['start']) : 0;
        $end = $start + $size;

        /* 获取文件列表 */
        $path = rtrim(SITE_PATH,"/") . (substr($path, 0, 1) == "/" ? "" : "/") . $path;
        $files = self::getfiles($path, $allowFiles);
        if (! count($files)) {
            return json_encode(array(
                "state" => "no match file",
                "list" => array(),
                "start" => $start,
                "total" => count($files)
            ));
        }

        /* 获取指定范围的列表 */
        $len = count($files);
        for ($i = min($end, $len) - 1, $list = array(); $i < $len && $i >= 0 && $i >= $start; $i --) {
            $list[] = $files[$i];
        }
        // 倒序
        // for ($i = $end, $list = array(); $i < $len && $i < $end; $i++){
        // $list[] = $files[$i];
        // }

        /* 返回数据 */
        $result = json_encode(array(
            "state" => "SUCCESS",
            "list" => $list,
            "start" => $start,
            "total" => count($files)
        ));

        return $result;
    }

    /**
     * 抓取远程图片
    */
    private function action_crawler($CONFIG)
    {
        include $this->Uploader;
        /* 上传配置 */
        $config = array(
            "pathFormat" => $CONFIG['catcherPathFormat'],
            "maxSize" => $CONFIG['catcherMaxSize'],
            "allowFiles" => $CONFIG['catcherAllowFiles'],
            "oriName" => "remote.png"
        );
        $fieldName = $CONFIG['catcherFieldName'];

        if (defined('STATIC_DIR')) {
            $config['pathFormat'] = STATIC_DIR . $config['pathFormat'];
        }

        /* 抓取远程图片 */
        $list = array();
        if (isset($_POST[$fieldName])) {
            $source = $_POST[$fieldName];
        } else {
            $source = $_GET[$fieldName];
        }
        foreach ($source as $imgUrl) {
            $item = new Uploader($imgUrl, $config, "remote");
            $info = $item->getFileInfo();

//            // 图片打水印
//            $ext = array(
//                '.jpg',
//                '.png',
//                '.gif'
//            );
//            if (in_array($info['type'], $ext)) {
//                resize_img(ROOT_PATH . $info['url']); // 缩放大小
//                watermark_img(ROOT_PATH . $info['url']); // 水印
//            }

            array_push($list, array(
                "state" => $info["state"],
                "url" => $info["url"],
                "size" => $info["size"],
                "title" => htmlspecialchars($info["title"]),
                "original" => htmlspecialchars($info["original"]),
                "source" => htmlspecialchars($imgUrl)
            ));
        }

        /* 返回抓取数据 */
        return json_encode(array(
            'state' => count($list) ? 'SUCCESS' : 'ERROR',
            'list' => $list
        ));
    }




    /**
     * 遍历获取目录下的指定类型的文件
     *
     * @param
     *            $path
     * @param array $files
     * @return array
     */
    private function getfiles($path, $allowFiles, &$files = array())
    {
        if (! is_dir($path))
            return null;
        if (substr($path, strlen($path) - 1) != '/') $path .= '/';
        $handle = opendir($path);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path2 = $path . $file;
                if (is_dir($path2)) {
                    self::getfiles($path2, $allowFiles, $files);
                } else {
                    if (preg_match("/\.(" . $allowFiles . ")$/i", $file)) {
                        $files[] = array(
                            'url' => substr($path2, strlen($_SERVER['DOCUMENT_ROOT'])),
                            'mtime' => filemtime($path2)
                        );
                    }
                }
            }
        }
        return $files;
    }
}