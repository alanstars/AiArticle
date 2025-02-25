<?php
/**
 * 易优CMS
 * ============================================================================
 * 版权所有 2016-2028 海南赞赞网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.eyoucms.com
 * ----------------------------------------------------------------------------
 * 如果商业用途务必到官方购买正版授权, 以免引起不必要的法律纠纷.
 * ============================================================================
 * Author: 小虎哥 <1105415366@qq.com>
 * Date: 2018-4-3
 */

namespace weapp\ImagesToWebp\logic;

use think\Db;

/**
 * 业务逻辑
 */
class ImagesToWebpLogic
{
    /**
     * 构造函数，初始化插件配置
     */
    public function __construct()
    {
        //查询插件配置
        $pluginConfig = db('weapp')->where(['code' => 'ImagesToWebp'])->value('data');
        if(!$pluginConfig) return false;

        //解码插件配置
        $this->config = json_decode($pluginConfig,true);
        
        //转换功能已关闭
        if(empty($this->config['open'])) return false;
        
    }

    /**
     * 检查文件是否需要进行转换
     *
     * @param string $filename 文件名
     * @return bool 如果文件扩展名是图片格式之一，则返回 true；否则返回 false
     */
    function _isImage($filename)
    {
        //图片名称不能为空
        if(!$filename) return false;

        //远程图片本地化已开启
        if($this->config['saveRemote']){
            $saveRemote = saveRemote($filename);
            $saveRemote = json_decode($saveRemote, true);
            //如果下载成功，则直接允许转换
            if($saveRemote['state'] == 'SUCCESS'){
                $filename = $saveRemote['url'];
            }
        }

        //获取图片的基本信息
        $pathinfo = pathinfo($filename);

        //扩展名转换为小写，并检查是否在允许的扩展名列表中
        if(!in_array(strtolower($pathinfo['extension']),$this->config['format'])) return false;
        
        //检测是否是外链，如果开启了远程图片本地化则下载，否则false
        if (strpos($filename, '//') === 0) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https:' : 'http:';
            $filename = $protocol . $filename;
        }

        
        //路径规范化并且本地化
        $localPath = str_replace(['\\', '//'], '/', ROOT_PATH . $filename);

        //检查原文件是否存在
        if(!file_exists($localPath)) {
            //构建新的 webp 文件路径
            $newWebpPath = "{$pathinfo['dirname']}/{$pathinfo['filename']}.webp";
            //构建新的 webp 图片链接
            $newWebpLink = str_replace(['\\', '//'], '/', ROOT_PATH . $newWebpPath);
            //检查新的 webp 文件是否存在
            if(file_exists($newWebpLink)) {
                return $newWebpPath;
            }else {
                //查询数据库看是否已经转换过
                $existingWebpData = db('uploads')->where(['image_url'=>$newWebpPath])->value('image_url');
                //使用三元运算符返回新图或者false
                return $existingWebpData ? $existingWebpData : false;
            }
        }
        
        //获得图片的大小
        $filesize = filesize($localPath);

        //如果图片大小小于最小限制，直接返回原图片 URL
        if($filesize < $this->config['min_kb']) return false;
		
		//处理格式以及压缩图片
        $imageResource = $this->_createImageResource($localPath);

        if(!$imageResource) return false;
        
        //如果要求都符合那就进行转换图片
        $newfile = $this->_convertImageToWebP($filename,$imageResource);
        //如果转换成功输出新图片URL，否则false
        return $newfile ? $newfile : false;
        
    }

    /**
     * 转换图片为 WebP 格式
     *
     * @param string $filename 图片的 URL 或路径
     * @return string|bool 成功返回转换后的 WebP 图片的 URL，失败返回 false
     */
    private function _convertImageToWebP($filename,$imageResource = '')
    {
        if(!$imageResource) return false;
        
        $localPath = str_replace(['\\', '//'], '/', ROOT_PATH . $filename);
        
        //获得原图大小
        $filesize = filesize($localPath);

        //获取图片的基本信息
        $pathinfo = pathinfo($filename);

        //新的webp名称
        $title = $pathinfo['filename'].'.webp';
        //新的webp本地路径
        $newLocalPath = dirname($localPath) . '/' . $title;
        //新的webpURL路径
        $newUrl = dirname($filename) . '/' . $title;
        
        //转换图片为 WebP 格式并保存到服务器
        $result = imagewebp($imageResource,$newLocalPath,$this->config['quality']);

        //新的文件大小
        $newFileSize = filesize($newLocalPath);

        //文件成功生成
        if($result && $newFileSize > 0){
            //释放内存中的图像资源
            imagedestroy($imageResource);

            //定义图片数据库
            $uploads =  db('uploads');

            //查询图片数据
            $imageData = $uploads->where(['image_url'=>$filename])->getField('title');

            //如果存在则更新，如果不存在则写入
            if($imageData){
                //更新图片表
                $uploads->where('image_url',$filename)->update([
                    'title' => $title,
                    'image_url' => $newUrl,
                    'filesize' => $newFileSize,
                    'mime' => 'image/webp'
                ]);
            }else{
                //写入图片表
                $addData = [
                    'image_url' => $newUrl,
                    'title' => $title,
                    'width' => $imageInfo['0'],
                    'height' => $imageInfo['1'],
                    'filesize' => $newFileSize,
                    'mime' => $imageInfo['mime'],
                    'users_id' => (int) session('admin_info.syn_users_id'),
                    'add_time' => getTime(),
                    'update_time' => getTime(),
                ];
                $uploads->insert($addData);
            }
            //源文件处理方式，看他要删除还是保留
            if($this->config['sourceFilePath'] && $pathinfo['extension'] != 'webp'){
                //删除原图片
                unlink($localPath);
            }
            //返回新的图片
            return $newUrl;

        }else{ //如果生成失败
            return false;
        }
    }

    /**
     * 对图像进行正比例压缩。
     *
     * @param resource $imageResource 图像资源。
     * @param string $localPath 图片文件的本地路径。
     * @return resource|false 成功返回压缩后的图像资源，失败返回 false。
     */
    function _compressImage($imageResource,$localPath)
    {
        // 获取原始图片的尺寸
        list($originalWidth, $originalHeight) = getimagesize($localPath);

        // 检查是否需要压缩
        if ($this->config['compress'] && ($originalWidth > $this->config['condition_width'] || $originalHeight > $this->config['condition_height'])) {
            // 计算新的宽度和高度，这里简单地将宽度和高度减半
            $newWidth = $originalWidth / 2;
            $newHeight = $originalHeight / 2;

            // 创建一个新的真彩色图像资源
            $newImageResource = imagecreatetruecolor($newWidth, $newHeight);

            // 使用 imagecopyresampled 进行高质量缩放
            $result = imagecopyresampled($newImageResource, $imageResource, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            if ($result) {
                // 如果压缩成功，更新图像资源
                $imageResource = $newImageResource;
            } else {
                // 如果压缩失败，销毁新创建的图像资源
                imagedestroy($newImageResource);
                return false;
            }
        }

        // 返回压缩后的图像资源
        return $imageResource;
    }

    /**
     * 根据给定的图片路径创建一个图像资源，并确保该图像是真彩色格式。
     * 支持 GIF, JPEG, PNG 和 WebP 格式的图片。
     *
     * @param string $localPath 图片文件的本地路径。
     * @return resource|false 成功返回图像资源，失败返回 false。
     */
    function _createImageResource($localPath)
    {
        if (empty($localPath)) {
            // 如果图片路径为空，则直接返回 false
            return false;
        }

        // 获取图片的基本信息
        $imageInfo = @getimagesize($localPath);
        if (!$imageInfo) {
            // 如果无法获取图片信息，则返回 false
            return false;
        }

        // 初始化图像资源变量
        $imageResource = null;

        // 根据图片类型创建图像资源
        switch ($imageInfo[2]) { // 使用索引2来判断图片类型
            case IMAGETYPE_GIF:
                $imageResource = imagecreatefromgif($localPath);
                break;
            case IMAGETYPE_JPEG:
                $imageResource = imagecreatefromjpeg($localPath);
                break;
            case IMAGETYPE_PNG:
                $imageResource = imagecreatefrompng($localPath);
                break;
            case IMAGETYPE_WEBP: // 添加对 WebP 格式的支持
                if($imageInfo[0] < $this->config['condition_width'] && $imageInfo[1] < $this->config['condition_height']){
                    return false;
                }
                $imageResource = imagecreatefromwebp($localPath);
                break;
            default:
                // 不支持的图片格式
                return false;
        }

        // 检查图像资源是否创建成功
        if ($imageResource === false) {
            return false;
        }

        // 检查是否为调色板图像（非真彩色）
        if (!imageistruecolor($imageResource)) {
            // 如果是调色板图像，转换为真彩色图像
            $width = imagesx($imageResource); // 获取宽度
            $height = imagesy($imageResource); // 获取高度
            $trueColorImage = imagecreatetruecolor($width, $height);
            // 将原图像复制到新的真彩色图像中
            imagecopy($trueColorImage, $imageResource, 0, 0, 0, 0, $width, $height);
            // 销毁原来的图像资源
            imagedestroy($imageResource);
            // 更新图像资源为新的真彩色图像
            $imageResource = $trueColorImage;
        }
        
        $imageResource = $this->_compressImage($imageResource,$localPath);
        if($imageResource){
            return $imageResource;
        }else{
            return false;
        }
    }

    /**
     * 根据数据类型处理数据
     *
     * @param mixed $data 需要处理的数据
     * @param string $dtype 数据类型
     * @param string $key 数据键名
     * @return mixed 返回处理后的数据
     */
    function _processFieldType($data,$key)
    {
        
        if(!$data) return false;
        //检查字段键名是否包含 '_eyou_local' 后缀，如果有那就是单图
        if (strpos($key, '_eyou_local') !== false) {
            $key = preg_replace('/_eyou_local$/', '', $key);
        }
        
        $dtype = db('channelfield')->where('name',$key)->value('dtype');
        
        switch ($dtype) {
            case 'imgs': //如果是多图
                return $this->_disposeImgs($data,$key);
            case 'htmltext': //如果是富文本
                return $this->_disposeHtmltext($data);
            case 'img': //如果是单图
                return $this->_isImage($data);
            default:
                return false;
        }
    }

    /**
     * 处理富文本中的图片链接，将其转换为WebP格式
     *
     * @param string $data 富文本内容
     * @return string 返回处理后的富文本内容
     */
    function _disposeHtmltext($data)
    {
        if(!$data) return false;
        
        // HTML字段处理-如果已经开启清除非本站链接,调用了系统的replace_links
        if (in_array(1,$this->config['html'])) {
            $data = replace_links($data);
        }

        //HTML字段处理-内容替换功能
        if(in_array(3,$this->config['html'])) {
            $content = db('weapp_images_to_webp_content')->field('old_keyword,new_keyword')->where(['status'=>1])->order('sort_order asc id desc')->select();
            foreach ($content as $item) {
                $data = preg_replace('/'.preg_quote($item['old_keyword'], '/').'/', $item['new_keyword'], $data);
            }
        }

        //HTML字段处理-关键词内链功能
        if(in_array(2,$this->config['html'])) {
            $keyword = db('weapp_images_to_webp_keyword')->field('title,target,url')->where(['status'=>1])->order('sort_order asc id desc')->select();
            
            $replaced = array_fill_keys(array_column($keyword, 'title'), false);

            foreach ($keyword as $item) {
                if ($replaced[$item['title']]) {
                    continue; // 如果这个关键词已经被替换过，跳过
                }

                $link = '<a href="' . htmlspecialchars($item['url']) . '"';
                if ($item['target'] == 1) {
                    $link .= ' target="_blank"';
                }
                $link .= '>' . htmlspecialchars($item['title']) . '</a>';

                if (!preg_match('/<a[^>]*>' . preg_quote($item['title'], '/') . '<\/a>/i', $data)) {
                    $pattern = '/(' . preg_quote($item['title'], '/') . ')/i';
                    $data = preg_replace($pattern, $link, $data, 1);
                    $replaced[$item['title']] = true;
                }
            }
            $data = preg_replace('/<a[^>]*>\s*<\/a>/', '', $data);
        }
        
        //HTML字段处理-删除标签自带的style
        if(in_array(4,$this->config['html'])) {
            $data = preg_replace('/style=["\'][^"\']*["\']/', '', $data);
        }
        //HTML字段处理-删除内容里面的空格/换行/没有内容的P标签
        if(in_array(5,$this->config['html'])) {
            $data = preg_replace('/<br\s*\/?>/i', '', $data);   
            $data = preg_replace('/<p>\s*<\/p>/i', '', $data);
            $data = preg_replace('/<p>\s*<br\s*\/?>\s*<\/p>/i', '', $data);
        }

        // 使用正则表达式查找所有 <img> 标签
        preg_match_all('/<img[^>]+>/', $data, $matches);
        $images = $matches[0]; // 获取所有匹配到的 <img> 标签

        foreach ($images as $v) {
            if (preg_match('/src=["\']([^"\']+)/i', $v, $match)) {
                $originalSrc = $match[1];
                $Image = $this->_isImage($originalSrc);
                if ($Image) {
                    $data = str_replace(['src="' . $originalSrc . '"', "src='" . $originalSrc . "'"], 'src="' . $Image . '"', $data);
                }
            }
        }
    
        return $data;
    }
    

    /**
     * 处理多图字段
     *
     * @param array $data 图片数组
     * @param string $key 数据键名
     * @return string 返回序列化的多图数据
     */
    private function _disposeImgs($data,$key)
    {
        $result = [];
        foreach ($data as $index => $v) {
            if (empty($v)) continue;

            $Image = $this->_isImage($v);

            // 构建动态键名
            $dynamicKey = $key . '_eyou_intro';
            // 检查动态键名是否存在
            if (isset($_POST['addonFieldExt'][$dynamicKey]) && is_array($_POST['addonFieldExt'][$dynamicKey])) { //大多数地方
                $introText = $_POST['addonFieldExt'][$dynamicKey][$index] ?? '';
            }elseif(isset($_POST['addonField'][$dynamicKey]) && is_array($_POST['addonField'][$dynamicKey])) { //栏目管理
                $introText = $_POST['addonField'][$dynamicKey][$index] ?? '';
            }else{
                $introText = '';
            }

            // 构建结果数组
            $result[] = [
                'image_url' => $Image,
                'intro' => $introText
            ];
        }

        // 返回序列化后的结果
        return serialize($result);
    }
    
}
