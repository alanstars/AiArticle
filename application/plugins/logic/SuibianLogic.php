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

namespace app\plugins\logic;

use think\Db;
use think\Config;
use app\plugins\model\SuibianPluginsModel;

/**
 * 逻辑定义
 * Class CatsLogic
 * @package plugins\Logic
 */

load_trait('controller/Jump');
class SuibianLogic
{
    use \traits\controller\Jump;

   	// 构造函数
    public function __construct($users = [])
    {
    	// 接口参数
        $this->param = input('param.');
        $this->users = !empty($users) ? $users : [];
        // URL参数处理
        $this->param['m'] = !empty($this->param['m']) ? $this->param['m'] : 'plugins';
        $this->param['c'] = !empty($this->param['c']) ? $this->param['c'] : 'Suibian';
        $this->param['a'] = !empty($this->param['a']) ? $this->param['a'] : ACTION_NAME;
        // 接口操作处理
        $this->param['action'] = !empty($this->param['action']) ? $this->param['action'] : '';
    }

    // 开源小程序插件操作(集合方法)
    public function suibianAction($weappInfo = [], $terminal = '', $action = '')
    {
        // 插件是否正常开启
        $loadShow = 0;
        $jumpPage = '/pages/index/index';
        if (empty($weappInfo) || 1 !== intval($weappInfo['status'])) {
            $this->success('请求失败', null, ['errorMsg' => '已禁用开源小程序插件', 'jumpPage' => $jumpPage, 'loadShow' => $loadShow]);
        }

        // 接口操作终端
        $this->param['terminal'] = !empty($terminal) ? $terminal : 'applets';
        // 接口操作处理
        $this->param['action'] = !empty($action) ? $action : $this->param['action'];

        // 模型层
        $suibianPluginsModel = new SuibianPluginsModel($this->param, $this->users);

        // 查询商品列表参数
        $parse = [
            'page' => !empty($this->param['page']) ? intval($this->param['page']) : 1,
            'label' => !empty($this->param['label']) ? intval($this->param['label']) : 1,
            'typeid' => !empty($this->param['typeid']) ? intval($this->param['typeid']) : 0,
            'pagesize' => !empty($this->param['pagesize']) ? intval($this->param['pagesize']) : 10,
            'channelid' => 2,
        ];

        // 获取全部数据
        if ('all' == $this->param['action']) {
            $suibianPluginsModel->getAllData($parse);
        }
        // 获取底部导航配置数据
        else if ('bottomNav' == $this->param['action']) {
            $suibianPluginsModel->getBottomNavData();
        }
        // 获取广告位信息数据
        else if ('adPosition' == $this->param['action']) {
            $suibianPluginsModel->getAdPositionData();
        }
        // 商品推荐(猜你喜欢)设置
        else if ('guessYouLike' == $this->param['action']) {
            $suibianPluginsModel->getGuessYouLike($parse);
        }
        // 获取分享卡片信息数据
        else if ('shareCard' == $this->param['action']) {
            $suibianPluginsModel->getShareCardConfig();
        }
        else {
            $this->error('请正确操作');
        }
    }
}