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

namespace weapp\Footernav\controller;

use think\Page;
use think\Db;
use app\common\controller\Weapp;
use weapp\Footernav\model\FooternavModel;

/**
 * 插件的控制器
 */
class Footernav extends Weapp
{
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
        $this->model = new FooternavModel;
        $this->db = Db::name('WeappFooternav');

        /*插件基本信息*/
        $this->weappInfo = $this->getWeappInfo();
        $this->assign('weappInfo', $this->weappInfo);
        /*--end*/
    }

    /**
     * 插件使用指南
     */
    public function doc(){
        return $this->fetch('doc');
    }

	public function demo(){
        return $this->fetch('demo');
    }
    /**
     * 系统内置钩子show方法（没用到这个方法，建议删掉）
     * 用于在前台模板显示片段的html代码，比如：QQ客服、对联广告等
     *
     * @param  mixed  $params 传入的参数
     */
    public function show($params = null){
		
		$info = $this->model->getWeappData();
        $this->assign('info', $info);
        echo $this->fetch('show');
    }

    /**
     * 插件后台管理 - 列表
     */
    public function index()
    {
		$info = $this->model->getWeappData();
        $this->assign('info', $info);
		$row = M('weapp')->where('code','eq','Footernav')->find();
        $this->assign('row', $row);
        return $this->fetch('index');
    }

	public function save()
    {
        if (IS_POST) {
            $data = input('post.');
            $info = $this->model->getWeappData();
            $saveData = array(
                'data'        => serialize($data),
				'tag_weapp' => $data['tag_weapp'],
                'update_time' => getTime(),
            );
            $r = Db::name('weapp')->where(array('code' => 'Footernav'))->update($saveData);
            if ($r) {
				\think\Cache::clear('hooks');
                adminLog('编辑' . $this->weappInfo['name'] . '成功'); // 写入操作日志
                $this->success("操作成功!", weapp_url('Footernav/Footernav/index'));
            }
        }
        $this->error("操作失败");
    }
  
}