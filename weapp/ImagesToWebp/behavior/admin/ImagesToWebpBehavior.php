<?php

namespace weapp\ImagesToWebp\behavior\admin;
use weapp\ImagesToWebp\logic\ImagesToWebpLogic;

/**
 * 行为扩展
 */
class ImagesToWebpBehavior
{
    protected static $actionName;
    protected static $controllerName;
    protected static $moduleName;
    protected static $method;

    /**
     * 构造方法
     * @param Request $request Request对象
     * @access public
     */
    public function __construct()
    {
        !isset(self::$moduleName) && self::$moduleName = request()->module();
        !isset(self::$controllerName) && self::$controllerName = request()->controller();
        !isset(self::$actionName) && self::$actionName = request()->action();
        !isset(self::$method) && self::$method = strtoupper(request()->method());
		$this->logic = new ImagesToWebpLogic;
    }

    /**
     * 模块初始化
     * @param array $params 传入参数
     * @access public
     */
    public function moduleInit(&$params)
    {
		
    }

    /**
     * 操作开始执行
     * @param array $params 传入参数
     * @access public
     */
    public function actionBegin(&$params)
    {
    }

    /**
     * 视图内容过滤
     * @param array $params 传入参数
     * @access public
     */
    public function viewFilter(&$params)
    {
    }

    /**
     * 应用结束
     * @param array $params 传入参数
     * @access public
     */
    public function appEnd(&$params)
    {
        try {
            $this->convertImage();
        } catch (\think\Exception $e) {
            
        }
    }

    /**
     * 插件逻辑
     */
    private function convertImage()
    {
		//插件已关闭
		if(empty($this->logic->config['open'])) return false;
		
		//如果不是POST请求
		if(!IS_POST) return false;
		
		//兼容官方AI插件
		$sm = request()->param()['sm'];
		$sa = request()->param()['sa'];
		if(in_array(5,$this->logic->config['scene']) && $sm == 'Ai' && in_array($sa,['save_archives','create'])){
			if($sa == 'save_archives'){ //如果是单篇
				$title = $_POST['title'];
				if(!$title) return false;
				$archives = db('archives')->where('title',$title)->order('aid', 'desc')->find();
			}else{ //否则就是批量
				$archives = db('archives')->order('aid', 'desc')->find();
			}
			if(!$archives) return false;
			$current_channel = db('arctype')->where('id',$archives['typeid'])->getField('current_channel');
			$table = db('channeltype')->where('id',$current_channel)->getField('table');
			$table = $table.'_content';
			$content = db($table)->where('aid',$archives['aid'])->value('content');

            $contents = db('weapp_images_to_webp_content')->field('old_keyword,new_keyword')->where(['status'=>1])->order('sort_order asc id desc')->select();
            foreach ($contents as $item) {
                $newtitle = preg_replace('/'.preg_quote($item['old_keyword'], '/').'/', $item['new_keyword'],$archives['title']);
            }
			db('archives')->where('aid',$archives['aid'])->update(['title'=>$newtitle]);

			$newcontent = $this->logic->_disposeHtmltext($content);
			if($newcontent){
				db($table)->where('aid',$archives['aid'])->update(['content'=>$newcontent]);
			}
		}

		//当前操作不在允许的操作列表中，或不是 POST 请求，则直接返回false
		if(!in_array(self::$actionName, ['add', 'edit', 'single_edit', 'customvar_save', 'web'])){
			return false;
		}

		//广告管理
		if(self::$controllerName == 'AdPosition' && in_array(2,$this->logic->config['scene'])){
			$data = db('ad')->field('id,litpic')->where('status',1)->select();
			foreach ($data as $key => $val) {
				$Image = $this->logic->_isImage($val['litpic']);
				if($Image) db('ad')->where('id',$val['id'])->update(['litpic'=>$Image]);
			}
		}

		//基本信息-网站信息里面的LOGO
		if(self::$actionName == 'web' && $_POST['web_logo_local'] && in_array(1,$this->logic->config['scene'])){
			$Image = $this->logic->_isImage($_POST['web_logo_local']);
			if($Image){
				db('config')->where('name','web_logo')->update(['value'=>$Image]);
			}
			\think\Cache::clear();
			delFile(RUNTIME_PATH);
		}

		//基本信息-自定义变量的图片
		if(self::$actionName == 'customvar_save' && in_array(1,$this->logic->config['scene'])){
			$data = db('config_attribute')->where('attr_input_type','3')->select();
			if(!$data) return false;
			foreach ($data as $key => $val) {
				$value = db('config')->where('name',$val['attr_var_name'])->getField('value');
				$Image = $this->logic->_isImage($value);
				if($Image){
					db('config')->where('name',$val['attr_var_name'])->update(['value' => $Image]);
				}
			}
			\think\Cache::clear();
			delFile(RUNTIME_PATH);
		}

		//单页模型跟栏目管理
		if(!$_POST['aid'] && $_POST['typeid'] && in_array(3,$this->logic->config['scene'])){
			if($_POST['dirname']){ //如果存在，那就是栏目管理
				//把系统自带的栏目图片增加进循环
				$_POST['addonField']['litpic'] = $_POST['litpic_local']; 
				$this->updateFields('arctype','id',$_POST['addonField'],$_POST['typeid']);
			}else{ //否则就是编辑单页模型
				$this->updateFields('single_content','typeid',$_POST['addonFieldExt'],$_POST['typeid']);
			}
		}
		//频道模型
		if($_POST['aid'] && $_POST['typeid'] && in_array(4,$this->logic->config['scene'])){


			//解决成品模型的图片集
			if(is_array($_POST['proimg'])) {
				$this->updateImageUrls('product_img',$_POST['proimg']);
			}
			//解决图集模型的图片集
			if (is_array($_POST['imgupload'])) {
				$this->updateImageUrls('images_upload',$_POST['imgupload']);
			}

			//根据栏目ID获取模型id
			$current_channel = db('arctype')->where('id',$_POST['typeid'])->getField('current_channel');
			//根据模型id获取table
			$table = db('channeltype')->where('id',$current_channel)->getField('table');
			//拼接附加表
			$table = $table.'_content';
			$this->updateFields($table,'aid',$_POST['addonFieldExt'],$_POST['aid']);
			//如果缩略图字段为空，从内容中获取第一张图片
			if(empty($_POST['litpic_local'])) {
				$_POST['litpic_local'] = get_html_first_imgurl($_POST['addonFieldExt']['content']);
			}
			//检查缩略图已获取到
			if($_POST['litpic_local']){
				$litpic = $this->logic->_isImage($_POST['litpic_local']);
				if($litpic){
    				$litpicPath = str_replace(['\\', '//'], '/', ROOT_PATH . $litpic);
    				//如果有如果.webp文件存在，则更新数据库中的缩略图链接新的文件诞生那就给他更新
    				if(file_exists($litpicPath)){
    					db('archives')->where('aid',$_POST['aid'])->update(['litpic'=>$litpic]);
    				}
				}
			}
		}
	}

	/**
	 * 更新单条信息到指定的数据库表
	 *
	 * @param string $table 目标数据库表名
	 * @param array $data 需要更新的数据数组
	 */
	private function updateImageUrls($table,$data) {
		foreach ($data as $key => $value) {
			$Image = $this->logic->_isImage($value);
			if($Image){
				db($table)->where('image_url',$value)->update([
					'image_url' => $Image,
					'mime' => 'image/webp',
				]);
			}
		}
	}
	
	/**
	 * 更新多条信息到指定的数据库表
	 *
	 * @param string $table 目标数据库表名
	 * @param string $Field 用于查询的字段名
	 * @param array $datas 需要更新的字段数组
	 * @param int $id 对应的ID值
	 */
	private function updateFields($table,$Field,$datas,$id) {
		foreach ($datas as $key => $value) {
			if(!$value)continue; // 如果值为空，则跳过
			$Image = $this->logic->_processFieldType($value,$key);
			if($Image){
				db($table)->where($Field,$id)->update([$key=>$Image]);
			}
		}
	}
}