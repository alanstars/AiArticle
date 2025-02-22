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
 * Date: 2018-06-28
 */

namespace weapp\ImagesToWebp\controller;

use think\Page;
use think\Db;
use app\common\controller\Weapp;
use weapp\ImagesToWebp\model\ImagesToWebpModel;
use weapp\ImagesToWebp\logic\ImagesToWebpLogic;

/**
 * 插件的控制器
 */
class ImagesToWebp extends Weapp
{
	private $data;
    /**
     * 实例化模型
     */
    private $model;

    /**
     * 实例化对象
     */
    private $db;

    /**
     * 插件基本信息
     */
    private $weappInfo;

    /**
     * 构造方法
     */
    public function __construct(){
        parent::__construct();
        $this->model = new ImagesToWebpModel;
        $this->db = Db::name('WeappImagesToWebp');

        $this->data = [
            'open'          => 0,
            'quality'       => 80,
            'min_kb'         => 20,
        ];
        /*插件基本信息*/
        $this->weappInfo = $this->getWeappInfo();
        $this->assign('weappInfo', $this->weappInfo);
        /*--end*/
        $this->logic = new ImagesToWebpLogic;
    }

    /**
     * 插件配置
     */
    public function index()
    {
        if (IS_POST) {
            $post = input('post.');

			$gdInfo = gd_info();
			if(empty($gdInfo['WBMP Support'])) {
				$this->error('您当前环境不支持启用 WebP 拓展，无法启用，请联系开发者！');
			}

			$post['quality'] = intval($post['quality']);
			$post['min_kb'] = intval($post['min_kb']);
			$post['condition_width'] = intval($post['condition_width']);
			$post['condition_height'] = intval($post['condition_height']);

			if(empty($post['quality'])) $this->error('转换质量不能为空！');
			if(empty($post['min_kb'])) $this->error('图片最小KB不能为空！');
			if(empty($post['scene'])) $this->error('转换场景最少要选一个！');
			if(empty($post['format'])) $this->error('转换格式最少要选一个！');
			if(empty($post['condition_width'])) $this->error('设置压缩条件宽度不能为空！');
			if(empty($post['condition_height'])) $this->error('设置压缩条件高度不能为空！');
				
			$postdata = [
				'data'  => json_encode($post, true),
				'tag_weapp' => 2,
				'update_time'   => getTime(),
			];

            $result = Db::name('weapp')->where(['code'=>'ImagesToWebp'])->update($postdata);
            if (!empty($result)) {
                $this->success('操作成功');
            }
            $this->error("操作失败!");
        }

		$data = Db::name('weapp')->where(['code'=>'ImagesToWebp'])->getField('data');
        $data = !empty($data) ? json_decode($data, true) : $this->data;

        $this->assign('data', $data);
        return $this->fetch('index');
    }

    /**
     * 批量操作
     */
    public function batch()
    {
        $where = [
            'status'   => 1,
            'ifsystem' => 1,
            'id' => ['not in',[7,8,51]],
        ];
        $data = Db::name('channeltype')->field('id,title,table')->where($where)->order('id desc')->select();
        $this->assign('data', $data);
        return $this->fetch('batch');
    }
    public function processing()
    {
        $channel = input('get.channel');
        $startid = input('get.startid');
        $maxpagesize = input('get.maxpagesize');
        $endid = input('get.endid');

        $this->assign('channel', $channel);
        $this->assign('startid', $startid);
        $this->assign('maxpagesize', $maxpagesize);
        $this->assign('endid', $endid);
        return $this->fetch();
    }
    public function processing_ajax()
    {
        $channel = input('get.channel');
        $startid = input('get.startid');
        $endid = input('get.endid');
        $current = input('get.current', 0);
        $index = input('get.index', $current + 3);
        $count = input('get.count');
        $where = [];
        if ($channel) $where['channel'] = $channel;
        if ($startid && $endid) $where['aid'] = ['between', [$startid, $endid]];
        $db = Db::name('archives');
        if (!$count) $count = $db->where($where)->count();
    
        // 处理数据库记录
        $batchSize = 3; // 每次处理的数量
        $archives = $db->field('channel,litpic,aid')->limit($current, $batchSize)->where($where)->select();
        foreach($archives as $key=>$val){
            if($val['litpic']){
                $litpic = $this->logic->_isImage($val['litpic']);
                if($litpic) $db->where('aid', $val['aid'])->update(['litpic' =>$litpic]);
            }
            //产品模型
            if($val['channel'] == 2){
                $product_img = Db::name('product_img')->field('img_id,image_url')->where('image_url', '<>', '')->select();
                foreach($product_img as $k=>$v){
                    $image_url = $this->logic->_isImage($v['image_url']);
                    if($image_url) Db::name('product_img')->where('img_id', $v['img_id'])->update(['image_url' =>$image_url]);
                }
            }
            //图片模型
            if($val['channel'] == 3){
                $images_upload = Db::name('images_upload')->field('img_id,image_url')->where('image_url', '<>', '')->select();
                foreach($images_upload as $k=>$v){
                    $image_url = $this->logic->_isImage($v['image_url']);
                    if($image_url) Db::name('images_upload')->where('img_id', $v['img_id'])->update(['image_url' =>$image_url]);
                }
            }
            $table = Db::name('channeltype')->where('id', 'eq',$val['channel'])->value('table');
            if($table){
                $table = $table.'_content';
                $content = Db::name($table)->where('aid', 'eq',$val['aid'])->find();
                foreach ($content as $item_k => $item_v) {
                    $field = Db::name('channelfield')->where(['name'=>$item_k,'channel_id'=>$val['channel']])->value('dtype');
                    if($field == 'imgs'){ //多图
                        $imgs = unserialize($item_v);
                        foreach ($imgs as &$val) {
                            $val['image_url'] = $this->logic->_isImage($val['image_url']);
                        }
                        $Image = serialize($imgs);
                    }elseif($field == 'htmltext'){ //编辑器
                        $item_v = htmlspecialchars_decode($item_v);
                        $Image = $this->logic->_disposeHtmltext($item_v);
                    }elseif($field == 'img'){ //单图
                        $Image = $this->logic->_isImage($item_v);
                    }else{
						continue;
					}
                    if($Image){
                        Db::name($table)->where('aid',$val['aid'])->update([$item_k=>$Image]);
                    }
                }
            }
        }
    
        $current += count($archives);
        $index = $current + $batchSize;

        $data = [
            'count' => $count,
            'channel' => $channel,
            'startid' => $startid,
            'endid' => $endid,
            'current' => $current,
            'index' => $index,
        ];
        $this->success('操作成功', 0, $data);
    }


    /**
     * 插件后台管理 - 内容替换 - 首页
     */
    public function content_replace()
    {
        $list = array();
        $keywords = input('keywords/s');

        $map = array();
        if (!empty($keywords)) {
            $map = "old_keyword LIKE '%" . addslashes($keywords) . "%' OR new_keyword LIKE '%" . addslashes($keywords) . "%'";
        }

        $count = db('weapp_images_to_webp_content')->where($map)->count('id');// 查询满足要求的总记录数
        $pageObj = new Page($count, config('paginate.list_rows'));// 实例化分页类 传入总记录数和每页显示的记录数
        $list = db('weapp_images_to_webp_content')->where($map)->order('id desc')->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
        $pageStr = $pageObj->show(); // 分页显示输出
        $this->assign('list', $list); // 赋值数据集
        $this->assign('pageStr', $pageStr); // 赋值分页输出
        $this->assign('pager', $pageObj); // 赋值分页对象

        return $this->fetch('content_replace');
    }

    /**
     * 插件后台管理 - 内容替换 - 新增
     */
    public function content_add()
    {
        if (IS_POST) {
            $post = input('post.');
                
            if(empty($post['old_keyword'])) $this->error('旧关键词不能为空！');
                
            $title = db('weapp_images_to_webp_content')->where(['old_keyword' => $post['old_keyword']])->find();
            if($title) $this->error('旧关键词已存在！');
            
            $nowData = array(
                'add_time'    => getTime(),
            );
            $saveData = array_merge($post, $nowData);
            $insertId = db('weapp_images_to_webp_content')->insert($saveData);
            if (false !== $insertId) {
                $this->success("操作成功", weapp_url('ImagesToWebp/ImagesToWebp/content_replace'));
            }else{
                $this->error("操作失败");
            }
            exit;
        }

        return $this->fetch('content_add');
    }
    
    /**
     * 插件后台管理 - 内容替换 - 编辑
     */
    public function content_edit()
    {
        if (IS_POST) {
            $post = input('post.');
            $post['id'] = eyIntval($post['id']);
            if(!empty($post['id'])){
                
                if(empty($post['old_keyword'])) $this->error('旧关键词不能为空！');
                
                $title = db('weapp_images_to_webp_content')->where(['old_keyword' => $post['old_keyword'],'id'=> ['neq', $_POST['id']]])->find();
                if($title) $this->error('旧关键词已存在！');
            
                $r = db('weapp_images_to_webp_content')->where(array('id'=>$post['id']))->update($post);
                if ($r) {
                    $this->success("操作成功", weapp_url('ImagesToWebp/ImagesToWebp/content_replace'));
                }else{
                    $this->error("操作失败");
                }
            }
            $this->error("操作失败!");
        }

        $id = input('id/d', 0);
        $row = db('weapp_images_to_webp_content')->find($id);
        if (empty($row)) {
            $this->error('数据不存在，请联系管理员！');
            exit;
        }
        $this->assign('row', $row);
        return $this->fetch('content_edit');
    }
    
    /**
     * 插件后台管理 - 内容替换 - 删除
     */
    public function content_del()
    {
        $id_arr = input('del_id/a');
        $id_arr = eyIntval($id_arr);
        if(!empty($id_arr) && IS_POST){
            $result = db('weapp_images_to_webp_content')->where("id",'IN',$id_arr)->select();
            $title_list = get_arr_column($result, 'title');

            $r = db('weapp_images_to_webp_content')->where("id",'IN',$id_arr)->delete();
            $this->success("操作成功!");
        }
        $this->error("操作失败!");
    }

    /**
     * 插件后台管理 - 关键词内链 - 首页
     */
    public function keyword_link()
    {
        $list = array();
        $keywords = input('keywords/s');

        $map = array();
        if (!empty($keywords)) {
            $map = "title LIKE '%" . addslashes($keywords) . "%' OR url LIKE '%" . addslashes($keywords) . "%'";
        }

        $count = db('weapp_images_to_webp_keyword')->where($map)->count('id');// 查询满足要求的总记录数
        $pageObj = new Page($count, config('paginate.list_rows'));// 实例化分页类 传入总记录数和每页显示的记录数
        $list = db('weapp_images_to_webp_keyword')->where($map)->order('id desc')->limit($pageObj->firstRow.','.$pageObj->listRows)->select();
        $pageStr = $pageObj->show(); // 分页显示输出
        $this->assign('list', $list); // 赋值数据集
        $this->assign('pageStr', $pageStr); // 赋值分页输出
        $this->assign('pager', $pageObj); // 赋值分页对象

        return $this->fetch('keyword_link');
    }

    /**
     * 插件后台管理 - 关键词内链 - 新增
     */
    public function keyword_add()
    {
        if (IS_POST) {
            $post = input('post.');
            
            if(empty($post['title'])) $this->error('标题不能为空！'); 
            if(empty($post['url'])) {
                $this->error('URL不能为空！');
            }elseif(!filter_var($post['url'], FILTER_VALIDATE_URL)) {
                $this->error('必须提供标准的URL格式！');
            }
            
            $title = db('weapp_images_to_webp_keyword')->where(array('title'=>$post['title']))->find();
            if($title) $this->error('该标题已存在！');

            $url = db('weapp_images_to_webp_keyword')->where(array('url'=>$post['url']))->find();
            if($url) $this->error('该URL已存在！');
            
            $nowData = array(
                'add_time'    => getTime(),
            );
            $saveData = array_merge($post, $nowData);
            $insertId = db('weapp_images_to_webp_keyword')->insert($saveData);
            if (false !== $insertId) {
                $this->success("操作成功", weapp_url('ImagesToWebp/ImagesToWebp/keyword_link'));
            }else{
                $this->error("操作失败");
            }
            exit;
        }

        return $this->fetch('keyword_add');
    }
    
    /**
     * 插件后台管理 - 关键词内链 - 编辑
     */
    public function keyword_edit()
    {
        if (IS_POST) {
            $post = input('post.');
            $post['id'] = eyIntval($post['id']);
            if(!empty($post['id'])){
                
                if(empty($post['title'])) $this->error('标题不能为空！'); 
                if(empty($post['url'])) {
                    $this->error('URL不能为空！');
                }elseif(!filter_var($post['url'], FILTER_VALIDATE_URL)) {
                    $this->error('必须提供标准的URL格式！');
                }
            
                $title = db('weapp_images_to_webp_keyword')->where(['title' => $post['title'],'id'=> ['neq', $_POST['id']]])->find();
                if($title) $this->error('该标题已存在！');
    
                $url = db('weapp_images_to_webp_keyword')->where(['url' => $post['url'],'id'=> ['neq', $_POST['id']]])->find();
                if($url) $this->error('该URL已存在！');

                $r = db('weapp_images_to_webp_keyword')->where(array('id'=>$post['id']))->update($post);
                if ($r) {
                    $this->success("操作成功", weapp_url('ImagesToWebp/ImagesToWebp/keyword_link'));
                }else{
                    $this->error("操作失败");
                }
            }
            $this->error("操作失败!");
        }

        $id = input('id/d', 0);
        $row = db('weapp_images_to_webp_keyword')->find($id);
        if (empty($row)) {
            $this->error('数据不存在，请联系管理员！');
            exit;
        }
        $this->assign('row', $row);
        return $this->fetch('keyword_edit');
    }
    
    /**
     * 插件后台管理 - 关键词内链 - 删除
     */
    public function keyword_del()
    {
        $id_arr = input('del_id/a');
        $id_arr = eyIntval($id_arr);
        if(!empty($id_arr) && IS_POST){
            $result = db('weapp_images_to_webp_keyword')->where("id",'IN',$id_arr)->select();
            $title_list = get_arr_column($result, 'title');

            $r = db('weapp_images_to_webp_keyword')->where("id",'IN',$id_arr)->delete();
            $this->success("操作成功!");
        }
        $this->error("操作失败!");
    }
}