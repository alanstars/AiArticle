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

namespace weapp\Suibian\controller;

use think\Db;
use app\common\controller\Weapp;
use weapp\Suibian\model\SuibianModel;

/**
 * 插件的控制器
 */
class Suibian extends Weapp
{
    /**
     * 构造方法
     */
    public function __construct()
    {
        parent::__construct();
        // 模型
        $this->suibianModel = new SuibianModel;
    }

    // 插件安装的后置操作
    public function afterInstall()
    {
        $data = [
            'textColor' => '#666666',
            'selectedColor' => '#f21340',
            'backgroundColor' => '#ffffff',
            'guessyoulike' => [
                'buyClick' => 'hide',
                'showTitle' => '为你推荐',
                'goodsSort' => 'sort_order',
                'applicablePages' => '1,2,3,4',
            ],
            'shopIndex' => [
                'sharePic' => '',
                'shareTag' => '{ey_webName}',
                'shareTitle' => '{ey_webName}',
            ],
            'dealerPlugin' => [
                'sharePic' => '',
                'shareTag' => '{ey_nickName}',
                'shareTitle' => '快来加入{ey_nickName}的团队吧，一起赚有佣金哦',
            ],
        ];
        Db::name('weapp')->where(['code' => 'Suibian'])->update(['data' => serialize($data), 'update_time' => $this->times]);
    }

    // 小程序列表
    public function applets()
    {
        $result = model('WeappAppletsConfigList')->getAppletsConfigList();
        $this->assign($result);
        return $this->fetch('applets');
    }

    // 添加小程序
    public function applets_add()
    {
        if (IS_AJAX_POST) {
            $post = input('post.');
            model('WeappAppletsConfigList')->updateSaveAppletsConfig($post, 'insert');
        }

        return $this->fetch('applets_add');
    }
    
    // 编辑小程序
    public function applets_edit()
    {
        if (IS_AJAX_POST) {
            $post = input('post.');
            model('WeappAppletsConfigList')->updateSaveAppletsConfig($post, 'update');
        }

        $result = model('WeappAppletsConfigList')->getAppletsConfigDetails(input('applets_id/d', 0));
        $this->assign($result);
        return $this->fetch('applets_edit');
    }

    public function delAppletsConfig()
    {
        if (IS_AJAX_POST) {
            $post = input('post.');
            model('WeappAppletsConfigList')->delAppletsConfig($post);
        }
    }

    // 广告列表
    public function index()
    {
        // 获取广告位列表
        $result = $this->suibianModel->getAdPositionList();
        $this->assign($result);

        return $this->fetch('index');
    }

    // 广告新增
    public function addad()
    {
        if (IS_AJAX_POST) {
            // 保存更新广告信息
            $this->suibianModel->updateSaveAd('insert');
        }

        return $this->fetch('addad');
    }

    // 广告编辑
    public function editad()
    {
        if (IS_AJAX_POST) {
            // 保存更新广告信息
            $this->suibianModel->updateSaveAd('update');
        }

        // 获取指定广告位的广告内容列表
        $result = $this->suibianModel->getAdContentList();
        $this->assign($result);

        // 金刚位广告编辑
        if (2 == input('position_id/d', 0)) {
            return $this->fetch('editad_vajra');
        }
        // 其他广告编辑
        else {
            return $this->fetch('editad');
        }
    }

    // 金刚位广告操作
    public function vajraAction()
    {
        if (IS_AJAX_POST) {
            $action = input('post.action/s', 'update');
            // 金刚位广告操作
            $this->suibianModel->vajraAction($action);
        }
    }

    // 广告删除
    public function delad()
    {
        if (IS_AJAX_POST) {
            // 删除广告信息
            $this->suibianModel->delAd();
        }
    }

    // 检测广告位名称是否存在重复
    public function detectionContentTitle()
    {
        if (IS_AJAX_POST) {
            $post = input('post.');
            $where = [
                'position_title' => trim($post['position_title']),
            ];
            if (!empty($post['position_id'])) $where['position_id'] = ['NEQ', $post['position_id']];
            $count = Db::name('weapp_applets_ad_position')->where($where)->count();
            if (empty($count)) {
                $this->success('检测通过');
            } else {
                $this->error('该广告名称已存在，请检查');
            }
        }
    }

    // 设置广告内容链接
    public function select_link()
    {
        // 获取广告链接列表
        $result = $this->suibianModel->getAdLinkList();
        $this->assign($result);

        return $this->fetch('link_system');
    }

    // 底部导航
    public function bottomnavdesign()
    {
        // 获取底部导航列表
        $result = $this->suibianModel->getBottomNavList();
        $this->assign($result);

        return $this->fetch('bottomnavdesign');
    }

    // 更新保存底部导航信息
    public function updateSaveBottomNav()
    {
        if (IS_AJAX_POST) {
            $action = input('post.action/s', 'update');
            // 删除 或 更新保存底部导航信息
            $this->suibianModel->updateSaveBottomNav($action);
        }
    }

    // 更新保存底部导航样式
    public function updateSaveStyle()
    {
        if (IS_AJAX_POST) {
            // 接收参数
            $post = input('post.');
            // 更新保存底部导航样式
            $this->suibianModel->updateSaveStyle($post);
        }
    }

    // 商品推荐
    public function guessyoulike()
    {
        if (IS_AJAX_POST) {
            // 更新保存商品推荐设置
            $this->suibianModel->updateSaveGuessYouLike();
        }

        // 获取商品推荐设置
        $result = $this->suibianModel->getGuessYouLike();
        $this->assign($result);

        return $this->fetch('guessyoulike');
    }

    // 页面路径
    public function page_paths()
    {
        // 获取页面路径列表
        $result = $this->suibianModel->getPagePahtsList();
        $this->assign($result);

        return $this->fetch('page_paths');
    }

    // 分享卡片
    public function share_card()
    {
        // 获取分享卡片配置
        $result = $this->suibianModel->getShareCardConfig();
        $this->assign($result);

        return $this->fetch('share_card');
    }

    // 分享卡片配置
    public function share_card_config()
    {
        if (IS_AJAX_POST) {
            // 设置分享卡片配置
            $this->suibianModel->setShareCardConfig();
        }

        // 获取分享卡片配置
        $result = $this->suibianModel->getShareCardConfig();
        $this->assign($result);

        return $this->fetch('share_card_config');
    }
}