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

namespace app\plugins\model;

use think\Db;
use weapp\Suibian\model\SuibianModel;

/**
 * 模型
 */

load_trait('controller/Jump');
class SuibianPluginsModel
{
    use \traits\controller\Jump;

    // 构造函数
    public function __construct($param = [], $users = [])
    {
        // 统一接收参数处理
        $this->times = getTime();
        $this->param = !empty($param) ? $param : [];
        $this->users = !empty($users) ? $users : [];
        // 模型
        $this->suibianModel = new SuibianModel($this->param['terminal']);
    }

    // 获取所有数据
    public function getAllData($parse = [])
    {
        // 获取底部导航配置数据
        $result['bottomNav'] = $this->suibianModel->getBottomNavList();

        // 获取广告位信息数据
        if (!empty($this->param['position_id'])) {
            $result['adPosition'] = $this->suibianModel->getAdContentList();
        } else {
            $result['adPosition'] = $this->suibianModel->getAdPositionList();
        }

        // 商品推荐(猜你喜欢)设置
        $result['guessYouLike'] = $this->suibianModel->getGuessYouLike($parse);

        // 获取分享卡片信息数据
        $result['shareCard'] = $this->suibianModel->getShareCardConfig();
        // 返回数据
        $this->unifyParamSuccess('查询成功', null, $result);
    }

    // 获取底部导航配置数据
    public function getBottomNavData()
    {
        $result['bottomNav'] = $this->suibianModel->getBottomNavList();
        // 返回数据
        $this->unifyParamSuccess('查询成功', null, $result);
    }

    // 获取广告位信息数据
    public function getAdPositionData()
    {
        if (!empty($this->param['position_id'])) {
            $result['adPosition'] = $this->suibianModel->getAdContentList();
        } else {
            $result['adPosition'] = $this->suibianModel->getAdPositionList();
        }
        // 返回数据
        $this->unifyParamSuccess('查询成功', null, $result);
    }

    // 商品推荐(猜你喜欢)设置
    public function getGuessYouLike($parse = [])
    {
        $result['guessYouLike'] = $this->suibianModel->getGuessYouLike($parse);
        // 返回数据
        $this->unifyParamSuccess('查询成功', null, $result);
    }

    // 获取分享卡片信息数据
    public function getShareCardConfig()
    {
        $result['shareCard'] = $this->suibianModel->getShareCardConfig($this->users);
        // 返回数据
        $this->unifyParamSuccess('查询成功', null, $result);
    }

    // 统一携带默认参数返回
    private function unifyParamSuccess($msg = '操作成功', $url = null, $result = [])
    {
        // 是否加载显示
        $result['loadShow'] = 1;
        // 返回结果
        if (model('ShopPublicHandle')->detectH5Terminal($this->param['terminal'])) {
            // $pointsShopController = new \app\plugins\controller\PointsShop;
            // $paramA = !empty($this->param['a']) ? $this->param['a'] : 'errorMsg';
            // $pointsShopController->$paramA($result);
        } else {
            if (!empty($this->param['debugApi'])) {
                dump($result);exit;
            }
            $this->success($msg, $url, $result);
        }
    }
}