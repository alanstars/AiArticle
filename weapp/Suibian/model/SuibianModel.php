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

namespace weapp\Suibian\model;

use think\Db;
use think\Page;
use think\Model;
use weapp\Suibian\logic\SuibianLogic;
use weapp\Suibian\model\WeappAppletsAdContent;

/**
 * 模型
 */
load_trait('controller/Jump');

class SuibianModel extends Model
{
    use \traits\controller\Jump;

    private $terminal = '';
    public function __construct($terminal = '') {
        if (!empty($terminal)) $this->terminal = $terminal;
        parent::__construct();
    }

    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
        // 当前时间戳
        $this->times = getTime();
        // 逻辑层
        $this->suibianLogic = new SuibianLogic;
        // 广告内容模型
        $this->appletsAdContent = new WeappAppletsAdContent;
        // 广告链接
        $this->ad_link_db = Db::name('weapp_applets_ad_link');
        // 底部导航
        $this->bottom_nav_db = Db::name('weapp_applets_bottom_nav');
        // 页面路由
        $this->page_paths_db = Db::name('weapp_applets_page_paths');
        // 广告内容
        $this->ad_content_db = Db::name('weapp_applets_ad_content');
        // 广告位
        $this->ad_position_db = Db::name('weapp_applets_ad_position');
        // 插件配置信息
        $this->weappInfo = model('ShopPublicHandle')->getWeappInfo('Suibian');
    }

    // 获取广告位列表
    public function getAdPositionList()
    {
        // 查询条件
        $where = [];
        // 小程序调用则执行
        if (!empty($this->terminal) && 'applets' == $this->terminal) $where['status'] = 1;

        // 分页查询
        $count = $this->ad_position_db->alias('a')->where($where)->count('position_id');
        $pages = new Page($count, config('paginate.list_rows'));

        // 列表查询
        $list = $this->ad_position_db->where($where)->limit($pages->firstRow.','.$pages->listRows)->order('add_time asc, position_id asc')->select();

        // 小程序调用则执行
        if (!empty($this->terminal) && 'applets' == $this->terminal) {
            $where = [
                'position_id' => ['IN', get_arr_column($list, 'position_id')],
            ];
            $content = $this->ad_content_db->where($where)->order('sort_order desc, content_id desc')->select();
            // 广告处理
            foreach ($content as $key => $value) {
                $value['content_images'] = handle_subdir_pic($value['content_images'], 'img', true);
                $content[$key] = $value;
                if (empty($value['content_title']) || empty($value['content_images'])) unset($content[$key]);
            }
            $content = $this->suibianLogic->getAdContentLinkNames($content, $this->terminal);
            $content = !empty($content) ? group_same_key($content, 'position_id') : [];
            // 如果金刚位广告存在数据则执行
            if (!empty($content[2])) {
                // 数组进行升序排序
                sort($content[2]);
                foreach ($content[2] as $key => $value) {
                    $content[2][$key]['fur_index'] = $key;
                }
            }
            // 广告处理
            foreach ($list as $key => $value) {
                $value['content'] = !empty($content[$value['position_id']]) ? $content[$value['position_id']] : [];
                $list[$key] = $value;
            }
        }

        // 返回数据
        return [
            'list' => $list,
            'pages' => $pages,
            'show' => $pages->show(),
        ];
    }

    // 获取指定广告位的广告内容列表
    public function getAdContentList()
    {
        $position_id = input('param.position_id/d', 0);
        // 查询条件
        $where = [
            'position_id' => intval($position_id),
        ];
        // 广告位信息
        $field = $this->ad_position_db->where($where)->find();

        // 广告内容信息
        $order = 2 === intval($position_id) ? 'sort_order asc, content_id asc' : 'sort_order desc, content_id desc';
        $list = $this->ad_content_db->where($where)->order($order)->select();
        // 获取链接名称
        $list = $this->suibianLogic->getAdContentLinkNames($list);

        // 小程序调用则执行
        if (!empty($this->terminal) && 'applets' == $this->terminal) {
            foreach ($list as $key => $value) {
                if (empty($value['content_title']) || empty($value['content_images'])) unset($list[$key]);
            }
            $list = array_merge($list);
            foreach ($list as $key => $value) {
                $value['fur_index'] = $key;
                $value['content_images'] = handle_subdir_pic($value['content_images'], 'img', true);
                $list[$key] = $value;
            }
            // 返回数据
            $field['content'] = $list;
            return [
                'list' => [$field],
            ];
        } else {
            foreach ($list as $key => $value) {
                $value['content_images'] = handle_subdir_pic($value['content_images'], 'img');
                $list[$key] = $value;
            }
            // 最大 content_id
            $maxContentID = $this->ad_content_db->max('content_id');
            // 返回数据
            return [
                'list' => $list,
                'field' => $field,
                'maxContentID' => $maxContentID,
            ];
        }
    }

    // 编辑广告信息
    public function updateSaveAd($save = 'insert')
    {
        // 接收参数
        $post = input('post.');

        if ('insert' == $save) {
            if (empty($post['position_title'])) $this->error('广告名称不能为空');
            // 保存广告位信息
            $insert = [
                'position_title' => trim($post['position_title']),
                'position_intro' => !empty($post['position_intro']) ? trim($post['position_intro']) : '',
                'add_time' => $this->times,
                'update_time' => $this->times
            ];
            // 执行保存
            $result = $this->ad_position_db->insertGetId($insert);
            $post['position_id'] = intval($result);
        } else if ('update' == $save) {
            // 更新广告位信息
            $where = [
                'position_id' => intval($post['position_id'])
            ];
            $update = [
                'position_intro' => !empty($post['position_intro']) ? trim($post['position_intro']) : '',
                'update_time' => $this->times,
            ];
            // 自定义广告位则存在广告位名称加入更新数据
            if (empty($post['system']) && !empty($post['position_title'])) $update['position_title'] = trim($post['position_title']);
            // 执行更新
            $result = $this->ad_position_db->where($where)->update($update);
        }

        // 更新广告内容
        if (!empty($result)) {
            // 处理保存数据
            $saveAll = [];
            $content_ids = [];
            $i = 1;
            foreach ($post['content_ids'] as $key => $value) {
                $saveAll[$key] = [
                    'position_id' => intval($post['position_id']),
                    'host_id' => !empty($post['host_ids'][$key]) ? intval($post['host_ids'][$key]) : 0,
                    'link_id' => !empty($post['link_ids'][$key]) ? intval($post['link_ids'][$key]) : 0,
                    'content_title' => trim($post['position_title']),
                    'content_images' => !empty($post['content_images'][$key]) ? trim($post['content_images'][$key]) : '',
                    'content_intro' => '',
                    'sort_order'  => $i++,
                    'add_time' => $this->times,
                    'update_time' => $this->times
                ];
                if (!empty($value)) {
                    array_push($content_ids, $value);
                    unset($saveAll[$key]['add_time']);
                    $saveAll[$key] = array_merge(['content_id' => intval($value)], $saveAll[$key]);
                }
            }
            // 查询要删除的广告内容
            $where = [
                'position_id' => intval($post['position_id']),
            ];
            if (!empty($content_ids)) $where['content_id'] = ['NOTIN', $content_ids];
            $delContentID = $this->ad_content_db->where($where)->column('content_id');
            // 保存更新广告内容
            if (!empty($saveAll)) $this->appletsAdContent->saveAll($saveAll);
            // 删除指定广告内容
            if (!empty($delContentID)) $this->ad_content_db->where(['content_id' => ['IN', $delContentID]])->delete(true);
            // 返回成功
            $this->success('insert' == $save ? '保存成功' : '更新成功');
        }
        $this->error('insert' == $save ? '保存失败' : '更新失败');
    }

    // 删除广告信息
    public function delAd()
    {
        $position_id = input('position_id/d', 0);
        if (!empty($position_id)) {
            $where = [
                'position_id' => $position_id,
            ];
            // 删除广告位
            $result = $this->ad_position_db->where($where)->delete(true);
            if (!empty($result)) {
                // 删除广告内容
                $this->ad_content_db->where($where)->delete(true);
                // 返回结束
                $this->success("删除成功");
            }
        }
        $this->error("删除失败");
    }

    // 金刚位广告操作
    public function vajraAction($action = 'update')
    {
        $post = input('post.');
        if (!empty($post['content_id']) && in_array($action, ['update', 'delete'])) {
            $where = [
                'content_id' => intval($post['content_id']),
            ];
            // 更新金刚位
            if ('update' == $action) {
                // 更新信息
                $update = [
                    'update_time' => $this->times,
                ];
                // 更新链接
                if (!empty($post['host_id']) && !empty($post['link_id'])) {
                    $update['host_id'] = intval($post['host_id']);
                    $update['link_id'] = intval($post['link_id']);
                }
                // 更新标题
                if (!empty($post['content_title'])) $update['content_title'] = trim($post['content_title']);
                // 更新图片
                if (!empty($post['content_images'])) $update['content_images'] = trim($post['content_images']);
                // 执行更新
                $result = $this->ad_content_db->where($where)->update($update);
                if (!empty($result)) $this->success('更新成功');
            }
            // 删除金刚位
            else if ('delete' == $action) {
                // 执行删除
                $result = $this->ad_content_db->where($where)->delete(true);
                if (!empty($result)) $this->success('删除成功');
            }
        }
        // 新增金刚位
        else if ('insert' == $action) {
            // 新增信息
            $insert = [
                'position_id' => 2,
                'content_intro' => '',
                'add_time' => $this->times,
                'update_time' => $this->times,
            ];
            // 新增链接
            if (!empty($post['host_id']) && !empty($post['link_id'])) {
                $insert['host_id'] = intval($post['host_id']);
                $insert['link_id'] = intval($post['link_id']);
            }
            // 新增标题
            if (!empty($post['content_title'])) $insert['content_title'] = trim($post['content_title']);
            // 新增图片
            if (!empty($post['content_images'])) $insert['content_images'] = trim($post['content_images']);
            // 执行新增
            $result = $this->ad_content_db->insertGetId($insert);
            if (!empty($result)) $this->success('保存成功');
        }

        // 返回结束
        $this->error('操作失败');
    }

    // 获取页面路径列表
    public function getPagePahtsList()
    {
        // 查询条件
        $where = [
            'status' => 1,
        ];
        
        // 列表查询
        $list = $this->page_paths_db->where($where)->order('add_time asc, id asc')->select();

        // 返回数据
        return [
            'list' => $list,
        ];
    }

    // 获取广告链接列表
    public function getAdLinkList()
    {
        $ad_host_id = input('param.ad_host_id/d', 1);
        $ad_link_id = input('param.ad_link_id/d', 0);

        // 查询条件
        $where = [
            'status' => 1,
        ];
        // 如果未开启积分商城插件则执行
        $pointsShop = model('ShopPublicHandle')->getWeappInfo('PointsShop');
        if (empty($pointsShop['status']) || 1 !== intval($pointsShop['status']) || empty($pointsShop['data']['openPoints'])) {
            $where['link_id'] = ['NOTIN', [5, 15]];
        }
        // 列表查询
        $linkList = $this->ad_link_db->where($where)->order('add_time asc, link_id asc')->select();
        // 获取指定的单个链接
        $linkFind = [];
        if (!empty($ad_link_id)) {
            foreach ($linkList as $key => $value) {
                if (intval($ad_link_id) === intval($value['link_id'])) {
                    $linkFind = $value;
                    break;
                }
            }
        }
        // 获取每个host_id组的第一条内容数据
        $linkGroup = [];
        foreach ($linkList as $key => $value) {
            if (empty($linkGroup[$value['host_id']])) {
                $linkGroup[$value['host_id']] = [
                    'link_id' => $value['link_id'],
                    'host_id' => $value['host_id'],
                    'host_title' => $value['host_title'],
                ];
            }
        }
        // 以host_id分组
        $linkList = group_same_key($linkList, 'host_id');

        // 查询商品列表
        if (3 === intval($ad_host_id)) {
            // 默认查询条件
            $where = [
                'a.channel' => 2,
                'a.is_del' => 0,
                'a.merchant_id' => 0,
            ];

            // 获取到所有GET参数
            $param = input('param.');

            // 应用搜索条件
            foreach (['keywords'] as $key) {
                $param[$key] = addslashes(trim($param[$key]));
                if (isset($param[$key]) && $param[$key] !== '') {
                    if ($key == 'keywords') {
                        $where['a.title'] = array('LIKE', "%{$param[$key]}%");
                    } else {
                        $where['a.'.$key] = array('eq', trim($param[$key]));
                    }
                }
            }

            // 权限控制 by 小虎哥
            $admin_info = session('admin_info');
            if (0 < intval($admin_info['role_id'])) {
                $auth_role_info = $admin_info['auth_role_info'];
                if (!empty($auth_role_info) && isset($auth_role_info['only_oneself']) && 1 == $auth_role_info['only_oneself']) {
                    $where['a.admin_id'] = $admin_info['admin_id'];
                }
            }

            // 自定义排序
            $orderby = input('param.orderby/s');
            $orderway = input('param.orderway/s');
            if (!empty($orderby) && !empty($orderway)) {
                $orderby = "a.{$orderby} {$orderway}, a.aid desc";
            } else {
                $orderby = "a.aid desc";
            }

            $count = Db::name('archives')->alias("a")->where($where)->count('a.aid');
            $Page = $pager = new Page($count, config('paginate.list_rows'));
            $list = Db::name('archives')->alias("a")->field('a.*')->where($where)->order($orderby)->limit($Page->firstRow.','.$Page->listRows)->select();
            foreach ($list as $key => $val) {
                $val['litpic'] = get_default_pic($val['litpic']);
                $val['title_new'] = @msubstr(checkStrHtml($val['title']), 0, 12, true);
                $list[$key] = $val;
            }
            // 返回数据
            $assign = [
                'param' => $param,
                'page' => $Page->show(),
                'list' => $list,
                'pager' => $Page,
            ];
        }
        // 查询商品分类
        else if (4 === intval($ad_host_id)) {
            // 目录列表
            $where = [
                'current_channel' => 2,
                'is_del' => 0,
            ];
            $arctypeLogic = new \app\common\logic\ArctypeLogic;
            $arctype_list = $arctypeLogic->arctype_list(0, 0, false, 0, $where, false);

            // 获取所有有子栏目的栏目id
            $where = [
                'parent_id' => ['gt', 0],
                'is_del' => 0,
            ];
            $parent_ids = Db::name('arctype')->where($where)->group('parent_id')->cache(true, EYOUCMS_CACHE_TIME, 'arctype')->column('parent_id');
            $cookied_treeclicked =  json_decode(cookie('admin-treeLinkClicked-Arr'));
            empty($cookied_treeclicked) && $cookied_treeclicked = [];
            $all_treeclicked = cookie('admin-treeLinkClicked_All');
            empty($all_treeclicked) && $all_treeclicked = [];
            $tree = [
                'has_children'=>!empty($parent_ids) ? 1 : 0,
                'parent_ids'=>json_encode($parent_ids),
                'all_treeclicked'=>$all_treeclicked,
                'cookied_treeclicked'=>$cookied_treeclicked,
                'cookied_treeclicked_arr'=>json_encode($cookied_treeclicked),
            ];
            // 返回数据
            $assign = [
                'tree' => $tree,
                'arctype_list' => $arctype_list,
            ];
        }

        // 返回数据
        $result = [
            'linkFind' => $linkFind,
            'linkList' => $linkList,
            'linkGroup' => $linkGroup,
            'ad_link_id' => $ad_link_id,
            'ad_host_id' => $ad_host_id,
        ];
        return !empty($assign) ? array_merge($result, $assign) : $result;
    }

    // 获取底部导航列表
    public function getBottomNavList()
    {
        // 底部导航列表信息
        $where = [
            'status' => 1,
        ];
        $list = $this->bottom_nav_db->where($where)->order('sort_order asc, add_time asc, nav_id asc')->select();
        foreach ($list as $key => $value) {
            $value['default_pic'] = handle_subdir_pic($value['default_pic'], 'img', true);
            $value['selected_pic'] = handle_subdir_pic($value['selected_pic'], 'img', true);
            $list[$key] = $value;
            if (!empty($this->terminal) && 'applets' == $this->terminal) {
                if (empty($value['link_id']) && empty($value['nav_title']) && empty($value['default_pic']) && empty($value['selected_pic'])) {
                    unset($list[$key]);
                }
            }
        }
        // 获取链接名称
        $list = $this->suibianLogic->getAdContentLinkNames($list, $this->terminal);

        // 插件配置信息
        $config = !empty($this->weappInfo['data']) ? $this->weappInfo['data'] : [];
        if (isset($config['shopIndex'])) unset($config['shopIndex']);
        if (isset($config['dealerPlugin'])) unset($config['dealerPlugin']);
        if (isset($config['guessyoulike'])) unset($config['guessyoulike']);

        // 返回数据
        return [
            'list' => $list,
            'config' => $config,
        ];
    }

    // 更新保存底部导航信息
    public function updateSaveBottomNav($save = '')
    {
        // 接收参数
        $post = input('post.');
        if (empty($post['nav_id'])) $this->error('请选择要更新的导航');
        if ('delete' == $save) {
            // 清除导航信息
            $updates[] = [
                'nav_id' => intval($post['nav_id']),
                'host_id' => 0,
                'link_id' => 0,
                'nav_title' => '',
                'default_pic' => '',
                'selected_pic' => '',
                'update_time' => $this->times,
            ];
        } else if ('update' == $save) {
            // 更新导航信息
            $update = [
                'nav_id' => intval($post['nav_id']),
                'update_time' => $this->times,
            ];
            // 更新导航链接
            if (!empty($post['host_id']) && !empty($post['link_id'])) {
                $update['host_id'] = intval($post['host_id']);
                $update['link_id'] = intval($post['link_id']);
            }
            // 更新导航图标
            if (!empty($post['field']) && !empty($post['value'])) $update[$post['field']] = strval($post['value']);
            $updates[] = $update;
        } else if ('batch_update' == $save) {
            // 更新导航信息
            $updates = [];
            foreach ($post['nav_id'] as $key => $val) {
                $update = [
                    'nav_id' => intval($val),
                    'update_time' => $this->times,
                ];
                if ($post['field'] == 'sort_order') {
                    $update[$post['field']] = $key + 100;
                }
                $updates[] = $update;
            }
        }

        // 执行更新
        $bottom_nav_model = new \weapp\Suibian\model\WeappAppletsBottomNav;
        $result = $bottom_nav_model->saveAll($updates);
        if ($result !== false) {
            $this->success('更新成功');
        }
        $this->error('更新失败');
    }

    // 更新保存样式
    public function updateSaveStyle($post = [], $return = true)
    {
        // 条件
        $where = [
            'code' => $this->weappInfo['code']
        ];
        // 插件配置
        $data = !empty($this->weappInfo['data']) ? $this->weappInfo['data'] : [];
        // 更新插件设置数据
        if (!empty($post['textColor'])) $data['textColor'] = trim($post['textColor']);
        if (!empty($post['selectedColor'])) $data['selectedColor'] = trim($post['selectedColor']);
        if (!empty($post['backgroundColor'])) $data['backgroundColor'] = trim($post['backgroundColor']);
        $update = [
            'data' => serialize($data),
            'update_time' => $this->times
        ];
        $result = Db::name('weapp')->where($where)->update($update);
        if (!empty($return)) {
            if (!empty($result)) $this->success('更新成功');
            $this->error('更新失败');
        }
    }

    // 获取商品推荐设置
    public function getGuessYouLike($parse = [])
    {
        $data = !empty($this->weappInfo['data']) ? $this->weappInfo['data'] : [];
        $config = [];
        if (!empty($data['guessyoulike'])) {
            $config = $data['guessyoulike'];
            if (isset($config['buyClick'])) unset($config['buyClick']);
            $config['applicablePages'] = !empty($config['applicablePages']) ? explode(',', $config['applicablePages']) : [];
        }
        $list = [];
        if (!empty($this->terminal) && 'applets' == $this->terminal) {
            $tagList = new \think\template\taglib\api\TagList;
            $parse['orderby'] = 'sort_order' == $config['goodsSort'] ? '' : $config['goodsSort'];
            $parse['orderway'] = 'desc';
            $list = $tagList->getList($parse);
        }
        return [
            'config' => $config,
            'list' => $list,
        ];
    }

    // 更新保存商品推荐设置
    public function updateSaveGuessYouLike()
    {
        $post = input('post.');
        // 条件
        $where = [
            'code' => $this->weappInfo['code']
        ];
        // 插件配置
        $data = !empty($this->weappInfo['data']) ? $this->weappInfo['data'] : [];
        $data['guessyoulike'] = !empty($data['guessyoulike']) ? $data['guessyoulike'] : [];
        // 更新插件设置数据
        $data['guessyoulike'] = [
            'buyClick' => !empty($post['buyClick']) ? $post['buyClick'] : $data['guessyoulike']['buyClick'],
            'showTitle' => !empty($post['showTitle']) ? $post['showTitle'] : $data['guessyoulike']['showTitle'],
            'goodsSort' => !empty($post['goodsSort']) ? $post['goodsSort'] : $data['guessyoulike']['goodsSort'],
            'applicablePages' => !empty($post['applicablePages']) ? implode(',', $post['applicablePages']) : '',
        ];
        $update = [
            'data' => serialize($data),
            'update_time' => $this->times
        ];
        $result = Db::name('weapp')->where($where)->update($update);
        if (!empty($result)) $this->success('更新成功');
        $this->error('更新失败');
    }

    // 获取分享卡片设置
    public function getShareCardConfig($users = [])
    {
        $data = !empty($this->weappInfo['data']) ? $this->weappInfo['data'] : [];
        $config = [];
        if (!empty($data['shopIndex'])) $config['shopIndex'] = $data['shopIndex'];
        if (!empty($config['shopIndex']['sharePic'])) $config['shopIndex']['sharePic'] = handle_subdir_pic($config['shopIndex']['sharePic']);
        if (!empty($data['dealerPlugin'])) $config['dealerPlugin'] = $data['dealerPlugin'];
        if (!empty($config['dealerPlugin']['sharePic'])) $config['dealerPlugin']['sharePic'] = handle_subdir_pic($config['dealerPlugin']['sharePic']);

        // 如果未开启分销插件则执行
        $dealerPlugin = model('ShopPublicHandle')->getWeappInfo('DealerPlugin');
        $dealerConfig = getUsersConfigData('dealer');
        if (empty($dealerPlugin['status']) || 1 !== intval($dealerPlugin['status']) || empty($dealerConfig['dealer_open'])) unset($config['dealerPlugin']);

        // 返回数据
        $type = input('type/s', '');
        if (!empty($type)) $config = $config[$type];
        // 小程序调用则执行
        if (!empty($this->terminal) && 'applets' == $this->terminal) {
            $config['shopIndex']['sharePic'] = handle_subdir_pic($config['shopIndex']['sharePic'], 'img', true);
            $config['shopIndex']['shareTitle'] = str_replace('{ey_webName}', tpCache('web.web_name'), $config['shopIndex']['shareTitle']);
            if (!empty($config['dealerPlugin']['sharePic'])) {
                $config['dealerPlugin']['sharePic'] = handle_subdir_pic($config['dealerPlugin']['sharePic'], 'img', true);
            }
            if (!empty($users['nickname']) && !empty($config['dealerPlugin']['shareTitle'])) {
                $config['dealerPlugin']['shareTitle'] = str_replace('{ey_nickName}', $users['nickname'], $config['dealerPlugin']['shareTitle']);
            }
        }
        return [
            'type' => $type,
            'config' => $config,
        ];
    }

    // 设置分享卡片配置
    public function setShareCardConfig()
    {
        $post = input('post.');
        // 更新条件
        $where = [
            'code' => $this->weappInfo['code']
        ];
        // 插件配置
        $data = !empty($this->weappInfo['data']) ? $this->weappInfo['data'] : [];
        $config = !empty($data[$post['type']]) ? $data[$post['type']] : [];
        // 更新插件设置数据
        $config = [
            'sharePic' => !empty($post['sharePic']) ? $post['sharePic'] : '',
            'shareTag' => !empty($post['shareTag']) ? $post['shareTag'] : $config['shareTag'],
            'shareTitle' => !empty($post['shareTitle']) ? $post['shareTitle'] : $config['shareTitle'],
        ];
        $data[$post['type']] = $config;
        $update = [
            'data' => serialize($data),
            'update_time' => $this->times
        ];
        $result = Db::name('weapp')->where($where)->update($update);
        if (!empty($result)) $this->success('更新成功');
        $this->error('更新失败');
    }
}